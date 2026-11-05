<?php

class Book extends CI_Controller {

    function __construct() {

        parent::__construct();
        $this->Mauth->isLoggedCheck();
        /* $this->Mauth->isLoggedCheck();
          $this->Mauth->isAdminCheck();
          $this->Mauth->loginUser(); */
          $this->Mauth->isLoggedCheck();
          $this->load->model('book/Common_model');
          $this->ais = $this->load->database('ais', TRUE);
      }

      public function booklist() {

        $data['categoryList'] = $this->Common_model->getMasterSetting('Books Category');
        $this->load->view('book/book_lists', $data);
    }

    public function requests() {

        $data['request_type'] = $this->uri->segment(3);
        $data['categoryList'] = $this->Common_model->getMasterSetting('Books Category');
        $this->load->view('book/requests', $data);
    }

    public function DTbook_list() {
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

        $this->aisDB = $this->load->database('ais', TRUE);
        
        $join[0]['select'] = "master_settings.master_name, master_books.*";
        $join[0]['table'] = "master_settings";
        $join[0]['condition'] = "master_books.master_id=master_settings.master_id";
        $join[0]['type'] = "LEFT";

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
          foreach ($getBookList as $lists) {
            $status = '';
            $userId = $this->session->userdata('user');
            $this->load->model('Mlibrary');
            $sta = $this->Mlibrary->bookStatus($lists->book_id, $userId);
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
        #$userId = 'USR122';
        $master_id = $this->input->post('master_id');
        $book_name = $this->input->post('book_name');
        $author = $this->input->post('author');
        $date_from_or = $this->input->post('date_from');
        $date_to_or = $this->input->post('date_to');
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
        $condition = array('library_booking.employee_id =' => $userId);
        $condition['library_booking.status'] = $search_cond;

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
        #echo'<pre>';print_r($condition);die;

        $this->ais = $this->load->database('ais', TRUE);
        $join[0]['select'] = "master_settings.master_name,master_books.book_name,master_books.author,master_books.available,master_books.book_number,library_booking.*";
        $join[0]['table'] = "master_books";
        $join[0]['condition'] = "library_booking.book_id=master_books.book_id";
        $join[0]['type'] = "LEFT";

        $join[1]['table'] = "master_settings";
        $join[1]['condition'] = "master_books.master_id=master_settings.master_id";
        $join[1]['type'] = "LEFT";

        $getBookListCount = $this->Common_model->get_all_details('library_booking', $condition, array(), '', '', $orderby, true, 'ais', $join);
        $getAll_count = count($getBookListCount);

        $getBookList = $this->Common_model->get_all_details('library_booking', $condition, array(), $limit, $start, $orderby, true, 'ais', $join);
        $getLimit_count = count($getBookList);

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
            $nestedData[] = $lists->book_number;
            $nestedData[] = strlen($lists->book_name) > 40 ? substr($lists->book_name, 0, 40) . ".." : $lists->book_name;
            $nestedData[] = strlen($lists->author) > 25 ? substr($lists->author, 0, 25) . ".." : $lists->author;
            $nestedData[] = date('d-m-Y', strtotime($date_type));
            if ($request_type == 'cancelled') {
                $nestedData[] = date('d-m-Y', strtotime($date_type_cancel));
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
                $nestedData[] = $date_type_return_dates;
                $nestedData[] = $lists->renew;

                $date_type_renew = '-';
                if ($date_type_renew != '' && $date_type_renew != 0) {
                    $date_type_renew = date('d-m-Y', strtotime($date_type_renew));
                };

                $nestedData[] = $date_type_renew;
                if ($request_type == 'returned') {
                    if ($date_type_renew != '') {
                        $date_type_renew = date('d-m-Y', strtotime($lists->return_date));
                    };
                    $nestedData[] = $date_type_renew;
                } else {
                    $nestedData[] = ucfirst($lists->status);
                }


                if ($request_type == 'confirmed') {
                    if (($lists->renew_status == 'no' || $lists->renew_status == 'confirmed') && strtotime($lists->expected_return_date) <= time()) {
                        $nestedData[] = "<a href='' class='action_cls' value=" . $lists->library_booking_id . " data-attr=" . $lists->library_booking_id . " >" . 'Renew' . "</a>";
                    } else {
                        $nestedData[] = ucfirst($lists->renew_status);
                    }
                } else {
                    $nestedData[] = 'Returned';
                }
            }
            if ($request_type != 'confirmed' || $request_type != 'returned') {
                $nestedData[] = ucfirst($lists->status);
            }
            $nestedData[] = "<a  href='javascript:void(0);'  class='action_cls' value=" . $lists->library_booking_id . " data-attr=" . $lists->library_booking_id . " >" . $action_status . "</a>";
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

    function ajax_book_request($bookId = '') {

        $this->load->helper('common_helper');
        $this->load->model('Mlogin');
        $this->load->model('Mlibrary');
        if($bookId == '') {
            $bookId = $this->input->post('request_id');
        }
        $returnArr = '0';
        $chechDup = $this->Mlibrary->checkRequest($bookId, $this->session->userdata("user"));

        if (count($chechDup) == 0) {
            #	echo $bookId;die;

            $requestId = $this->Mlibrary->bookRequestForm($bookId, $this->session->userdata("user"));
            $mailContant = $this->Mlibrary->libraryMailContant($requestId);
            sendMail($mailContant['employeeEmail'], $mailContant['adminEmail'], 'Book Request', $mailContant);
            $to_email_hr[]='hr@villgro.org';
            sendMail($mailContant['employeeEmail'], $to_email_hr, 'Book Request', $mailContant);
            #echo'<PRE>';print_r($mailContant);die;
            #sendMail($mailContant['employeeEmail'], $mailContant['adminEmail'], 'Book Request', $mailContant);
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


        $requestId = $this->input->post('request_id');
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
        $result = $this->Mlibrary->renewRequest($requestId);

        if ($result) {
            $mailContant = $this->Mlibrary->libraryMailContant($requestId, 'booking_request_mail');

            sendMail($mailContant['employeeEmail'], $mailContant['adminEmail'], 'Book Request Renewal', $mailContant);
            $this->session->set_flashdata('successMsg', 'You book Renewed Successfully!');
            #redirect('libraryuser/requests/confirmed');
        }
        echo json_encode($returnArr);
    }

}

?>