<?php

class Approval extends CI_Controller {

    function __construct() {

        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->Mauth->isAdminCheck();
        //  $this->Mauth->loginUser(); 
        $this->load->model('book/Common_model');
        $this->load->model('book/Mcommon');
        $this->load->model('book/Mlibrary');
        $this->load->model('book/Mlogin');
    }
    
    public function booklist() {
        $data['categoryList'] = $this->Common_model->getMasterSetting('Books Category');
        $this->load->view('approval/book_lists', $data);
    }

    public function requests() {

        $data['request_type'] = $this->uri->segment(4);
        $data['categoryList'] = $this->Common_model->getMasterSetting('Books Category');
        $data['userList'] = $this->Mlibrary->getAllUserList();
        $this->load->view('approval/requests', $data);
    }

    public function DTbook_list() {

        #error_reporting(-1);
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $master_id = $this->input->post('master_id');
        $book_name = $this->input->post('book_name');
        $author = $this->input->post('author');

        $orderby = '';
        $columnArr = array('master_settings.master_name');
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }

        $condition = array('master_books.status' => '1');
        if ($master_id != '') {
            $condition['master_settings.master_id'] = $master_id;
        }
        if ($book_name != '') {
            $condition['master_books.book_name LIKE'] = "%$book_name%";
        }
        if ($author != '') {
            $condition['master_books.author LIKE'] = "%$author%";
        }

        $this->ais = $this->load->database('ais', TRUE);
        $join[0]['select'] = "master_settings.master_name, master_books.*";
        $join[0]['table'] = "master_settings";
        $join[0]['condition'] = "master_books.master_id=master_settings.master_id";
        $join[0]['type'] = "LEFT";
        #echo'<pre>';print_r($_POST);die;

        /*
          if ($admin == NULL){
          $this->db->where('library_booking.employee_id !=', $this->session->userdata('user'));
          }
         */
          $getBookListCount = $this->Common_model->get_all_details('master_books', $condition, array(), '', '', $orderby, true, 'ais', $join);
          $getAll_count = count($getBookListCount);
          $getBookList = $this->Common_model->get_all_details('master_books', $condition, array(), $limit, $start, $orderby, true, 'ais', $join);
          $getLimit_count = count($getBookList);




          $this->load->helper('common_helper');
          $this->load->model('Mlogin');
          $this->load->model('Mlibrary');
    #echo'<pre>';print_r($getBookList);die;
          foreach ($getBookList as $lists) {
            $status = '';
            #error_reporting(-1);
            /* $sta = bookStatus($lists->book_id, $this->session->userdata('user'));
            $userId = 'USR122'; */
            $userId = $this->session->userdata('user');
            $this->load->model('Mlibrary');
            $sta = $this->Mlibrary->bookStatus($lists->book_id, $userId);
            #echo'<pre>';print_r($sta);die;
            if ($sta != 'pending') {
                $status = "<a  href='javascript:void(0);' class='action_cls' value=" . $lists->book_id . " data-attr=" . $lists->book_id . " >" . 'Request' . "</a>";
            } else {
                $status = "Pending";
            }
            if ($lists->available == 1) {
                $available_status = 'Available';
            }
            $nestedData = array();
            $nestedData[] = $lists->master_name;
            $nestedData[] = $lists->book_number;
            $nestedData[] = strlen($lists->book_name) > 40 ? substr($lists->book_name, 0, 40) . ".." : $lists->book_name;
            $nestedData[] = $lists->author;
            $nestedData[] = $available_status;
            $nestedData[] = $status;
            $data[] = $nestedData;
            $i++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($getLimit_count),
            "recordsFiltered" => intval($getAll_count),
            "data" => $data,
            "POST" => $_POST
        );
        echo json_encode($json_data);
    }

    public function DTbook_request() {

        #error_reporting(-1);
        #echo'<pre>';print_r($_POST);die;
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $master_id = $this->input->post('master_id');
        $book_name = $this->input->post('book_name');
        $author = $this->input->post('author');

        $request_type = $this->input->post('request_type');

        $orderby = '';
        $columnArr = array('library_booking.library_booking_id', 'master_settings.master_name', 'master_books.book_number', 'master_books.book_name', 'master_books.author', 'library_booking.request_date', 'library_booking.status');
        if ($columnArr[$columnIndex] != '') {
            $orderby = array($columnArr[$columnIndex] => $columnSortOrder);
        }

        $userId = $this->session->userdata('user_id');


        $master_id = $this->input->post('master_id');
        $book_name = $this->input->post('book_name');
        $author = $this->input->post('author');
        $date_from_or = $this->input->post('date_from');
        $date_to_or = $this->input->post('date_to');
        $employee_id = $this->input->post('employee_id');
        $date_from = date('Y-m-d', strtotime($date_from_or));
        $date_to = date('Y-m-d', strtotime($date_to_or));

        $search_cond = '';
        $search_date = '';
        if ($request_type != '' && $request_type == 'pending') {
            $search_cond = 'pending';
            $search_date = 'request_date';
        } else if ($request_type != '' && $request_type == 'cancelled') {
            $search_cond = 'cancelled';
            $search_date = 'cancel_date';
        } else if ($request_type != '' && $request_type == 'confirmed') {
            $search_cond = 'confirmed';
            $search_date = 'issue_date';
        } else if ($request_type != '' && $request_type == 'returned') {
            $search_cond = 'returned';
            $search_date = 'return_date';
        }
        $isSuperAdmin = $this->session->userdata('isSuperAdmin');
        $isSuperAdmin1 = $this->session->userdata('isAdmin');
        
        if ($isSuperAdmin == 'Yes') {
            $condition = array('library_booking.employee_id !=' => $userId);
        }

        if ($this->session->userdata('user_type') != 'superadmin') {
            $partner = $this->session->userdata('partner_id');
            $condition['UP.partner_id'] = $partner;
        }

        $condition['library_booking.status'] = $search_cond;
        if ($employee_id != '') {
            $condition['library_booking.employee_id'] = $employee_id;
        }
        if ($master_id != '') {
            $condition['master_books.master_id'] = $master_id;
        }
        if ($book_name != '') {
            $condition['master_books.book_name LIKE'] = "%$book_name%";
        }
        if ($author != '') {
            $condition['master_books.author LIKE'] = "%$author%";
        }

        if ($date_from_or != '' && $date_to_or == '') {
            $condition['library_booking.' . $search_date . ' >='] = $date_from . " 00:00:00";
        } else if ($date_to_or != '' && $date_from_or == '') {
            $condition['library_booking.' . $search_date . ' <='] = $date_to . " 23:59:59";
        } else if ($date_from_or != '' && $date_to_or != '') {
            $condition['library_booking.' . $search_date . ' >='] = $date_from . " 00:00:00";
            $condition['library_booking.' . $search_date . ' <='] = $date_to . " 23:59:59";
        }
        # echo'<pre>';print_r($condition);die;

        $this->ais = $this->load->database('ais', TRUE);
        $join[0]['select'] = "master_settings.master_name,master_books.book_name,master_books.author,master_books.available,master_books.book_number,library_booking.*";
        $join[0]['table'] = "master_books";
        $join[0]['condition'] = "library_booking.book_id=master_books.book_id";
        $join[0]['type'] = "LEFT";

        $join[1]['table'] = "master_settings";
        $join[1]['condition'] = "master_books.master_id=master_settings.master_id";
        $join[1]['type'] = "LEFT";

        $join[2]['table'] = $this->db->database .".hr_user_profile UP";
        $join[2]['condition'] = "UP.id= library_booking.employee_id";
        $join[2]['type'] = "LEFT";

        $getBookListCount = $this->Common_model->get_all_details('library_booking', $condition, array(), '', '', $orderby, true, 'ais', $join);
        $getAll_count = count($getBookListCount);

        $getBookList = $this->Common_model->get_all_details('library_booking', $condition, array(), $limit, $start, $orderby, true, 'ais', $join);
        $getLimit_count = count($getBookList);
       # echo'<pre>';print_r($getBookList);die;


        $action_status = '';
        $date_type = '';
        $date_type_cancel = '';
        foreach ($getBookList as $lists) {

            $date_type = $lists->request_date;
            if ($request_type == 'pending') {
                $action_status = 'Cancel';
            } else if ($request_type == 'cancelled') {
                $date_type_cancel = $lists->cancel_date;
            } else if ($request_type == 'confirmed' || $request_type == 'returned') {
                $date_type_issue_date = $lists->issue_date;
                $date_type_return_date = $lists->expected_return_date;
                $date_type_renew = $lists->renew;
                $date_type_renew_date = $lists->renew_date;
                $action_status = '';
            }
            $nestedData = array();
            $nestedData[] = $lists->library_booking_id;
            $nestedData[] = $lists->master_name;
            $employeeName = $this->Mlibrary->getUserNameInfo($lists->employee_id);
            #print_r($employeeName);die;
            $user_name="";
            if(isset($employeeName[0]['user_name'])){
                $user_name = $employeeName[0]['user_name'];
            }
            $nestedData[] = $user_name;
            $nestedData[] = $lists->book_number;
            $nestedData[] = strlen($lists->book_name) > 40 ? substr($lists->book_name, 0, 40) . ".." : $lists->book_name;
            $nestedData[] = strlen($lists->author) > 25 ? substr($lists->author, 0, 25) . ".." : $lists->author;
            if ($request_type == 'cancelled') {
                $nestedData[] = date('d-m-Y', strtotime($date_type_cancel));
            }else{
                $nestedData[] = date('d-m-Y', strtotime($date_type));

            }
            if ($request_type == 'confirmed' || $request_type == 'returned') {
                if ($date_type_renew != '' && $date_type_renew != 0) {
                    $date_type_renew = date('d-m-Y', strtotime($date_type_renew));
                };


                $date_type_issue_dates = '';
                if ($date_type_issue_date != '') {
                    $date_type_issue_dates = date('d-m-Y', strtotime($date_type_issue_date));
                }
                $nestedData[] = $date_type_issue_dates;
                $date_type_return_dates = '';
                if ($date_type_return_date != '') {
                    $date_type_return_dates = date('d-m-Y', strtotime($date_type_return_date));
                }
                $nestedData[] = $lists->renew;
                $nestedData[] = $date_type_return_dates;
                if ($request_type == 'returned') {
                    if ($date_type_renew != '') {
                        $date_type_renew = date('d-m-Y', strtotime($lists->return_date));
                    };
                    $nestedData[] = $date_type_renew;
                } else {
                    $nestedData[] = ucfirst($lists->status);
                }

               /* $date_type_renew = '-';
                if ($date_type_renew != '' && $date_type_renew != 0) {
                    $date_type_renew = date('d-m-Y', strtotime($date_type_renew));
                };

                $nestedData[] = $date_type_renew;*/
                

                if ($isSuperAdmin1 == 'Yes') {
                    if ($lists->status == 'confirmed') {
                    //if($lists->renew_status == 'pending') {
                        $Renew = "<a  href='javascript:void(0);'class='renews_cls' value=" . $lists->library_booking_id . " data-attr-bid=" . $lists->book_id . " data-attr-id=" . $lists->library_booking_id . " data-attr-status=" . $lists->renew_status . " >" . 'Renew ' . "</a>";
                    //}
                        $Renew = '';
                        $nestedData[] = "<a  href='javascript:void(0);'class='return_cls' value=" . $lists->library_booking_id . " data-attr-bid=" . $lists->book_id . " data-attr-id=" . $lists->library_booking_id . " >" . 'Return    ' . "</a> $Renew";
                    }
                }else{
                    $nestedData[]="-";
                }
            }
            if ($request_type != 'confirmed' || $request_type != 'returned') {
                $nestedData[] = ucfirst($lists->status);
            }
            if ($isSuperAdmin1 == 'Yes') {

                if ($request_type == 'returned' || $request_type == 'cancelled') {
                    $nestedData[] = "<a  href='javascript:void(0);'class='delete_cls' value=" . $lists->library_booking_id . " data-attr-bid=" . $lists->book_id . " data-attr-id=" . $lists->library_booking_id . " >" . 'Delete' . "</a> $Renew";
                }
            }else{
               $nestedData[]="-";
           }

           if ($isSuperAdmin1 == 'Yes') {
            if ($lists->status == 'pending') {
                $nestedData[] = "<a  href='javascript:void(0);'class='approve_cls' value=" . $lists->library_booking_id . " data-attr-bid=" . $lists->book_id . " data-attr-id=" . $lists->library_booking_id . " >" . 'Approve ' . "</a><a  href='javascript:void(0);'  class='dissapprove_cls' value=" . $lists->library_booking_id . "  data-attr-bid=" . $lists->book_id . " data-attr-id=" . $lists->library_booking_id . ">" . ' Disapprove' . "</a>";
            }
        }else{
            $nestedData[]="-";
        }

        $data[] = $nestedData;
        $i++;
    }
    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($getLimit_count),
        "recordsFiltered" => intval($getAll_count),
        "data" => $data,
        "POST" => $_POST
    );
    echo json_encode($json_data);
}

function renew() {
    
}

function reject() {
    
}

function return_book() {
        #echo'<pre>';print_r($_POST);die;
    $book_id = $this->input->post('book_id');
    $requestId = $this->input->post('return_req_id');
    $issue_date = $this->input->post('issue_date');
    $result = $this->Mlibrary->returnLibraryBook($requestId, $book_id, $issue_date);
    if ($result) {
        $returnUrl = 'book/approval/requests/confirmed';
        $mailContant = $this->Mlibrary->libraryMailContant($requestId, 'Admin');
        sendMail($mailContant['adminEmail'], $mailContant['toEmail'], 'Book return', $mailContant);
        $this->session->set_flashdata('successMsg', 'Book Returned Successfully!');
        redirect($returnUrl);
    }
}

function approve_book($requestId = '', $book_id = NULL, $action = NULL) {
    $book_id = $this->input->post('book_id');
    $approve_issue_date = $this->input->post('approve_issue_date');
    $requestId = $this->input->post('approve_request_id');

    $bookStatus = $this->Mcommon->getRecords('master_books', 'book_id', $book_id);

    $noOfDaystoReturn = $this->Mlibrary->getLibrarySettings('days_for_return');
    
    $dateformat=$this->input->post('approve_issue_date');
    $dateformatchange=date("d/m/Y", strtotime($dateformat));
    $expectedReturnDates = addDays($dateformatchange, $noOfDaystoReturn);
    $expectedReturnDate=date("d-m-Y", strtotime($expectedReturnDates));
    
    $date = str_replace('/', '-', $expectedReturnDates );
    $expectedReturnDate = date("d-m-Y", strtotime($date)); 
    $result = $this->Mlibrary->confirmLibraryRequest($requestId, $expectedReturnDate, $this->input->post('approve_issue_date'), $book_id);
    $mailContant = $this->Mlibrary->libraryMailContant($requestId, 'Admin');
    if ($result) {
        $mailContant = $this->Mlibrary->libraryMailContant($requestId, 'Admin');
        sendMail($mailContant['adminEmail'], $mailContant['toEmail'], 'Book Request Confirmation', $mailContant);
    }
    $this->session->set_flashdata('successMsg', 'Request Approved Successfully!');
    redirect('book/approval/requests/pending');
}

    function delete_request($requestId, $status) { #echo'<pre>';print_r($_POST);die;
    $requestId = $this->input->post('delete_request_id');
    $this->Mcommon->delete('library_booking', 'library_booking_id', $requestId);
    $this->session->set_flashdata('successMsg', 'Record Deleted Successfully!');
    redirect('book/approval/requests/returned');
}

function cancel($requestId) {

    echo $requestId = $this->input->post('dissapprove_request_id');
        $result = $this->Mlibrary->checkLibraryBookingStatus($requestId); #echo'<pre>';print_r($_POST);die;
        $returnUrl = 'book/approval/requests/pending';
        if ($result['0']['status'] == 'pending') {
            $result = $this->Mlibrary->cancelLibraryRequest($requestId);
            if ($this->session->userdata('isAdmin') == 'Yes') {
                $mailContant = $this->Mlibrary->libraryMailContant($requestId, 'Admin');
                sendMail($mailContant['adminEmail'], $mailContant['toEmail'], 'Book Request Disapproval', $mailContant);
                $returnUrl = 'book/approval/requests/pending';
            } else {
                $mailContant = $this->Mlibrary->libraryMailContant($requestId);
                sendMail($mailContant['employeeEmail'], $mailContant['toEmail'], 'Book Request Cancel By Employee', $mailContant);
                $returnUrl = 'book/approval/requests/pending';
            }
            $this->session->set_flashdata('successMsg', 'Your Request Cancelled !');
            redirect($returnUrl);
        } else {
            $this->session->set_flashdata('warningMsg', 'Your Request Can not be process !');
            redirect($returnUrl);
        }
    }

    function ajax_book_request($bookId) {

        $this->load->helper('common_helper');
        $this->load->model('Mlogin');
        $this->load->model('Mlibrary');
        $bookId = $this->input->post('request_id');
        $returnArr = '0';
        $chechDup = $this->Mlibrary->checkRequest($bookId, $this->session->userdata("user"));


        if (count($chechDup) == 0) {
            #   echo $bookId;die;

            $requestId = $this->Mlibrary->bookRequestForm($bookId, $this->session->userdata("user"));

            /* $returnArr ='1';
              $requestId = $this->Mlibrary->bookRequestForm($bookId, $this->session->userdata("user"));
              $mailContant = $this->Mlibrary->libraryMailContant($requestId);
              sendMail($mailContant['employeeEmail'], $mailContant['adminEmail'], 'Book Request', $mailContant); */
              $this->session->set_flashdata('successMsg', 'Your request sent!');
          } else {
            $returnArr = '2';
            $this->session->set_flashdata('infoMsg', 'Your request already in pending! Request not sent!');
        }
        echo json_encode($returnArr);
    }

    function ajax_request() {
        #error_reporting(-1);
        $requestId = $this->input->post('request_id');
        #echo'<pre>';print_r($requestId);die;
        $returnArr['response'] = '0';
        if ($requestId != '') {
            $this->load->helper('common_helper');
            $this->load->model('Mlogin');
            $this->load->model('Mlibrary');
            $condition = array('library_booking_id' => $requestId);
            $getBookList = $this->Common_model->get_all_details('library_booking', $condition, array(), '', '', '', true, 'ais');
            if ($getBookList['0']->status == 'pending') {
                $returnArr = '1';
                $condition = array('library_booking_id' => $requestId);
                $data = array('cancel_date' => date('Y-m-d'));
                #$this->Common_model->update_data('library_booking', $condition, $data);
                if ($this->session->userdata('isAdmin') == 'Yes') {
                    $mailContant = $this->Mlibrary->libraryMailContant($requestId, 'Admin');
                    #sendMail($mailContant['adminEmail'], $mailContant['toEmail'], 'Book Request Disapproval', $mailContant);
                    #$returnUrl = 'libraryadmin/requests';
                } else {
                    $mailContant = $this->Mlibrary->libraryMailContant($requestId);
                    #sendMail($mailContant['employeeEmail'], $mailContant['toEmail'], 'Book Request Cancel By Employee', $mailContant);
                    #$returnUrl = 'libraryuser/requests';
                }
                $this->session->set_flashdata('successMsg', 'Your Request Cancelled !');
            } else {
                $returnArr = '2';
                $this->session->set_flashdata('warningMsg', 'Your Request Can not be process !');
                #redirect($returnUrl);
            }
        }
        echo json_encode($returnArr);
    }

    function ajax_renew($requestId) {

        $this->load->helper('common_helper');
        $this->load->model('Mlogin');
        $this->load->model('Mlibrary');
        $returnArr['response'] = '0';
        $noOfRenew = $this->Mlibrary->getLibrarySettings('no_of_renewals');
        $requestDateils = $this->Mlibrary->getLibraryRequestDetails($requestId);
        if ($noOfRenew < $requestDateils['0']['renew']) {
            $this->session->set_flashdata('errorMsg', 'You have Reached Renewal Limit!');
            #redirect('libraryuser/requests/confirmed');
        }
        $this->session->set_flashdata('errorMsg', 'You have Reached Renewal Limit!');
        /* $result = $this->Mlibrary->renewRequest($requestId);
          if ($result) {
          $mailContant = $this->Mlibrary->libraryMailContant($requestId, 'booking_request_mail');
          sendMail($mailContant['employeeEmail'], $mailContant['adminEmail'], 'Book Request Renewal', $mailContant);
          $this->session->set_flashdata('successMsg', 'You book Renewed Successfully!');
          #redirect('libraryuser/requests/confirmed');
      } */
      echo json_encode($returnArr);
  }

}

?>