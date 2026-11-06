<?php

class Travel_admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        /* $this->Mauth->isLoggedCheck();
          $this->Mauth->isAdminCheck();
          $this->Mauth->loginUser(); */
        $this->Mauth->isLoggedCheck();
        $this->Mauth->isAdminCheck();
        $this->load->model('travel/mcommon');
        $this->load->model('travel/Mlogin');
        $this->load->model('travel/Common_model');
        $this->load->model('travel/Mmasters');
        $this->load->model('travel/Mapproval');
    }

    public function requestlist() {
        $data['categoryList'] = $this->Common_model->getMasterSetting('Books Category');
        $this->load->view('travel/request_admin', $data);
        //$this->load->view('travel/request_from',$data);
    }

    public function DTrequest_list() {

        #error_reporting(-1);
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $action = $this->input->post('action');

        $return_date_from = $this->input->post('return_date_from');
        $return_date_to = $this->input->post('return_date_to');
        $currentTab = $this->input->post('currentTab');

        $columnArr = array('travel_booking.travel_request_id', 'travel_booking.master_name', '', '', '', 'travel_booking.journey_type', 'travel_booking.reporting_approval', 'travel_booking.status');

        #echo'<pre>';print_r($_POST);die;
        $curField = 'date_of_requisition';
        switch ($currentTab) {
            case 'pending':
                $searchArray[] = "travel_booking.status = 'pending'";
                $curField = 'cancel_date';
                break;
            case 'confirmed':
                $searchArray[] = "travel_booking.status = 'confirmed'";
                $curField = 'date_of_requisition';
                break;
            case 'cancelled':
                $searchArray[] = "travel_booking.status = 'cancelled'";
                $curField = 'date_of_requisition';
                break;
            case 'defered':
                $searchArray[] = "travel_booking.status = 'defered'";
                break;
        }
        if ($this->input->post('travel_request_id') != "") {
            $searchArray[] = "travel_booking.travel_request_id ='" . $this->input->post('travel_request_id') . "'";
        }
        if ($this->input->post('request1') != "") {
            $searchArray[] = $curField . " >= '" . date('Y-m-d', strtotime($this->input->post('request1'))) . "'";
        }
        if ($this->input->post('request1') != "") {
            $searchArray[] = $curField . " <= '" . date('Y-m-d', strtotime($this->input->post('request2'))) . "'";
        }

        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }
        #echo'<pre>';print_r($_POST);die;
        $where = php72_implode(" and ", $searchArray);
        $start = 0;
        #echo $where;die;
        /* $assetListCount = $this->Mmasters->getLimitTravelRequest($where, '', '', $sort_column, $columnSortOrder);
          $getAll_count = count($assetListCount); */

        $travel_requestLists = $this->Mmasters->getLimitTravelRequest($where, $limit, $start, $sort_column, $columnSortOrder, 'Show All');
        $getLimit_count = php72_count($travel_requestLists);
        $travel_requestLists = array();
        #echo'<pre>';print_r($assetList);die;

        foreach ($travel_requestLists as $lists) {
            /* $emp_name ='';
              if($lists['employee_id']!=''){
              $employe_name= $this->Common_model->get_all_details('hr_user_profile',array('id'=>$lists['employee_id']),array('emp_first_name','emp_last_name'));
              $emp_name = $employe_name[0]->emp_first_name.' '.$employe_name[0]->emp_last_name;
              } */
            $status = '';
            $nestedData = array();
            $nestedData[] = $lists['travel_request_id'];
            $nestedData[] = $lists['date_of_requisition'];
            $nestedData[] = $this->showMaster($lists['other_donor']);
            $nestedData[] = $this->showMaster($lists['other_budget_head']);
            $nestedData[] = $this->showMaster($lists['cost_centre']);
            $nestedData[] = $lists['journey_type'];
            $nestedData[] = $lists['reporting_approval'];
            $nestedData[] = $lists['status'];
            $nestedData[] = "<a  href='javascript:void(0);' class='action_cls delete_cls' value=" . $lists['asset_id'] . " data-attr-an=" . $lists['asset_no'] . " data-attr-tid=" . $lists['transfer_id'] . " data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . ">" . 'View' . "</a>";
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

    function showMaster($master_id) {
        if ($master_id == '') {
            return '-';
        } else {
            $condition = array('master_id' => $master_id);
            $get_masterName = $this->Common_model->get_all_details('master_settings', $condition, array(), '', '', '', true, 'ais');
            return $get_masterName[0]->master_name;
        }
    }

    public function request_form() {
        #echo'asdsdsa';die;
        #error_reporting(-1);
        $data['traveMode'] = $traveMode = $this->mcommon->getMasterSetting('Travel Mode');
        $data['traveMode_json'] = $traveMode_json = json_encode($traveMode, true);

        $user_type = $this->session->all_userdata('user_type');
        $userType = '';
        if ($user_type['user_type'] != '') {
            $get_userType = $this->Common_model->get_all_details('hr_user_type', array('user_slug' => $user_type['user_type']), array('id'));
            $userType = $get_userType[0]->id;
        }
        $data['userList'] = $this->Mlogin->getAllUserList($userType);
        #echo'<pre>';print_r($data['userList']);die;
        $data['categoryList'] = $this->Common_model->getMasterSetting('Books Category');

        #echo'<pre>';print_r($userDetails);die;
        $this->load->view('travel/request_from', $data);
    }

    public function approval_form() {

        #echo'<pre>';print_r($_POST);die;
        $start = 0;
        $limit = 1;
        $orderby = array('approval_id' => 'desc');
        $getApproval_Details = $this->Common_model->get_all_details('approval_note', array(), array(), $limit, $start, $orderby, true, 'ais');
        $text = "APN/";

        if (php72_count($getApproval_Details))
            $id = str_pad((int) $getApproval_Details[0]->approval_id + 1, 4, "0", STR_PAD_LEFT);
        else
            $id = '0001';
        $data['approval_new'] = $text . $id;

        #echo'<pre>'; print_r($this->session->all_userdata());die;
        $type = 'supUser';
        $emp_number = $this->session->userdata('emp_number');

        if ($emp_number == NULL) {
            $employees = $this->Mlogin->getReportingUser($emp_number, $type);
        } else {
            $employees = $this->Mlogin->getReportingUser($emp_number, $type);
        }
        #error_reporting(-1);
        $data['RO'] = $employees;

        $data['programmeList'] = $this->Mmasters->getBalanceProgramme();

        $data['datas'] = '';
        $this->session->unset_userdata('travelRequest');
        $this->session->set_userdata('travelRequest', json_encode($_POST));
        $this->load->view('travel/approval_form', $data);
    }

    public function insertApproval_note() {
        if (php72_count($_POST) > 0) {
            $data = $this->Mapproval->insertapprovaldraft();
        }
        redirect('travel/requestlist/pending');
    }

    function ajax_get_donor() {
        #error_reporting(-1);
        $programm_id = $this->input->post('programm_id');
        $donors = $this->Mmasters->getBalanceDonor($programm_id);
        $donor_lists = $this->mcommon->getMasterSetting('Donor');

        $option = '<option value="">--Select--</option>';
        foreach ($donor_lists as $rows) {
            if (php72_in_array($rows['master_id'], $donors)) {
                $option .= '<option value="' . $rows['master_id'] . '" name="a">' . $rows['master_name'] . '</option>';
            }
        }
        $returnArr['response'] = $option;
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }

    function ajax_get_grant() {

        #error_reporting(-1);
        $donor_id = $this->input->post('donor_id');

        if ($donor_id != '') {
            $this->current_db = $this->db;
            $db_var = $this->current_db;
            $fields = array('id', 'name');
            $condition = array('funder_id' => $donor_id, 'status_type' => 'open');
            $db_var->select($fields);
            $db_var->where($condition);
            $get_val = $db_var->get('grant_list');
            $get_results = $get_val->result();
            #echo'<pre>';print_r($get_results->result());
            $grant_option = '<option value="" >-Select-</option>';
            if (isset($get_results) && !empty($get_results)) {
                foreach ($get_results as $lists) {
                    $selected_opt = '';
                    if ($grant_id != '') {
                        if ($grant_id == $lists->id) {
                            $selected_opt = 'selected';
                        }
                    }
                    $grant_option .= '<option  ' . $selected_opt . ' value="' . $lists->id . '">' . $lists->name . '</option>';
                    $returnArr['status'] = '1';
                }
            }
            $returnArr['response'] = $grant_option;
            $output = json_encode($returnArr);
            echo $output;
            exit;
        }
    }

    function ajax_get_budget_head() {

        #error_reporting(-1);
        $programm_id = $this->input->post('programm_id');
        $donor_id = $this->input->post('donor_id');
        $budget_head = $this->input->post('budget_head');
        $balance_budget_head = $this->mcommon->get_balance_sheet_detail('Budget Head', $programm_id, $donor_id, '', '', $grant_id);
        $budgetHeadList = $this->mcommon->getMasterSetting('Budget Head', NULL, '', $programm_id);

        $budget_head_option = '<option value="" >-Select-</option>';
        if (isset($budgetHeadList) && !empty($budgetHeadList)) {
            foreach ($budgetHeadList as $lists) {
                $selected_opt = '';
                if ($budget_head != '') {
                    if ($budget_head == $lists['master_id']) {
                        $selected_opt = 'selected';
                    }
                }
                $budget_head_option .= '<option  ' . $selected_opt . ' value="' . $lists['master_id'] . '">' . $lists['master_name'] . '</option>';
                $returnArr['status'] = '1';
            }
        }
        $returnArr['response'] = $budget_head_option;
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }

    function ajax_get_lineitem() {
        #echo'<pre>';print_r($_POST);die;
        #error_reporting(-1);
        $programm_id = $this->input->post('programm_id');
        $donor_id = $this->input->post('donor_id');
        $budget_head = $this->input->post('budget_head');
        $balance_budget_head = $this->mcommon->get_balance_sheet_detail('Line Item', $programm_id, $donor_id, '', '', $grant_id);
        $lineItem = $this->mcommon->getMasterSetting('Line Item', NULL, '', $programm_id);

        $lineItem_option = '<option value="" >-Select-</option>';
        if (isset($lineItem) && !empty($lineItem)) {
            foreach ($lineItem as $lists) {
                $selected_opt = '';
                if ($budget_head != '') {
                    if ($budget_head == $lists['master_id']) {
                        $selected_opt = 'selected';
                    }
                }
                $lineItem_option .= '<option  ' . $selected_opt . ' value="' . $lists['master_id'] . '">' . $lists['master_name'] . '</option>';
                $returnArr['status'] = '1';
            }
        }
        $returnArr['response'] = $lineItem_option;
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }

    function ajax_get_user($requestId) {
        $returnArr['response'] = '0';
        $userId = $this->input->post('user_id');
        $current_attr = $this->input->post('current_attr');
        $returnArr['data'] = '';
        $attr_val = '';
        if ($userId != '') {
            $returnArr['response'] = '1';
            $userDetails = $this->Mlogin->getEmployeeFromUserId($userId);
            $age = $userDetails[0]['emp_age'];
            $gender = $userDetails[0]['emp_gender'];
            $mobile_number = $userDetails[0]['personal_mobile'];
            $attr_val = substr($current_attr, 6);
            $returnArr['data'] = array('age' => $age, 'gender' => $gender, 'mobile_number' => $mobile_number, 'attr_val' => $attr_val);
        }
        echo json_encode($returnArr);
        die;
    }

    function ajax_get_user_list() {
        #error_reporting(-1);
        $user_type = $this->session->all_userdata('user_type');
        $userType = '';
        $returnArr['status'] = '0';
        if ($user_type['user_type'] != '') {
            $get_userType = $this->Common_model->get_all_details('hr_user_type', array('user_slug' => $user_type['user_type']), array('id'));
            $userType = $get_userType[0]->id;
        }
        $userList = $this->Mlogin->getAllUserList($userType);
        $option = '<option  value="" >--Select--</option>';
        foreach ($userList as $list) {
            $option .= '<option  value="' . $list['id'] . '" >' . $list['user_name'] . '</option>';
        }
        $returnArr['response'] = $option;
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }

    public function requests() {
        $data['request_type'] = $this->uri->segment(3);
        $data['categoryList'] = $this->Common_model->getMasterSetting('Books Category');
        $this->load->view('travel/requests', $data);
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
        $join[0]['table'] = $this->ais . "master_settings";
        $join[0]['condition'] = "master_books.master_id=master_settings.master_id";
        $join[0]['type'] = "LEFT";
        #echo'<pre>';print_r($_POST);die;

        $getBookListCount = $this->Common_model->get_all_details('master_books', $condition, array(), '', '', $orderby, true, 'ais', $join);
        $getAll_count = php72_count($getBookListCount);
        $getBookList = $this->Common_model->get_all_details('master_books', $condition, array(), $limit, $start, $orderby, true, 'ais', $join);
        $getLimit_count = php72_count($getBookList);


        $this->load->helper('common_helper');
        $this->load->model('Mlogin');
        $this->load->model('Mlibrary');
        #echo'<pre>';print_r($getBookList);die;
        foreach ($getBookList as $lists) {
            $status = '';
            #error_reporting(-1);
            #$sta = bookStatus($lists->book_id, $this->session->userdata('user'));
            $userId = 'USR122';
            $sta = bookStatus($lists->book_id, $userId);
            if ($sta != 'pending') {
                $status = "<a  href='javascript:void(0);' class='action_cls' value=" . $lists->book_id . " data-attr=" . $lists->book_id . " >" . 'Request' . "</a>";
            } else {
                $status = "Pending";
            }
            if (php72_cmp($lists->available) == 1) {
                $available_status = 'Available';
            }
            $nestedData = array();
            $nestedData[] = $lists->master_name;
            $nestedData[] = $lists->book_number;
            $nestedData[] = $lists->book_name;
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
        $userId = 'USR122';

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
        $condition = array('library_booking.employee_id !=' => $userId);
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
        $join[0]['table'] = $this->ais . "master_books";
        $join[0]['condition'] = "library_booking.book_id=master_books.book_id";
        $join[0]['type'] = "LEFT";

        $join[1]['table'] = $this->ais . "master_settings";
        $join[1]['condition'] = "master_books.master_id=master_settings.master_id";
        $join[1]['type'] = "LEFT";

        $getBookListCount = $this->Common_model->get_all_details('library_booking', $condition, array(), '', '', $orderby, true, 'ais', $join);
        $getAll_count = php72_count($getBookListCount);

        $getBookList = $this->Common_model->get_all_details('library_booking', $condition, array(), $limit, $start, $orderby, true, 'ais', $join);
        $getLimit_count = php72_count($getBookList);

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
            $nestedData[] = $lists->book_name;
            $nestedData[] = $lists->author;
            $nestedData[] = date('d-m-Y', strtotime($date_type));
            if ($request_type == 'cancelled') {
                $nestedData[] = date('d-m-Y', strtotime($date_type_cancel));
            }
            if ($request_type == 'confirmed' || $request_type == 'returned') {
                if ($date_type_renew != '') {
                    $date_type_renew = date('d-m-Y', strtotime());
                };

                $nestedData[] = date('d-m-Y', strtotime($date_type_issue_date));
                $nestedData[] = date('d-m-Y', strtotime($date_type_return_date));
                $nestedData[] = $lists->renew;
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

    function ajax_book_request($bookId) {
        $this->load->helper('common_helper');
        $this->load->model('Mlogin');
        $this->load->model('Mlibrary');
        $returnArr = '0';
        $chechDup = $this->Mlibrary->checkRequest($bookId, $this->session->userdata("user"));
        if (php72_count($chechDup) == 0) {
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

    function check_calucalations() {
        #error_reporting(-1);
        if (!empty($_REQUEST)) {
            $count = php72_count($_REQUEST["donor"]);
            $return = array();
            for ($i = 0; $i < $count; $i++) {
                if ($_REQUEST["donor"][$i] != "" && $_REQUEST["budgethead"][$i] != "" && $_REQUEST["lineitem"][$i] != "") {
                    if (isset($_REQUEST["edit"])) {
                        $pre = $this->PreCheckExist($_REQUEST); //echo "<pre>";print_r($pre);exit;
                        $check = $this->CheckExist($return, $_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i]);
                        $inam = $this->Mapproval->tot_amt_in($_REQUEST['id'], $_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i], $_REQUEST['detail'][$i]);
                        $return[$i]["donor"] = $_REQUEST["donor"][$i];
                        $return[$i]["budgethead"] = $_REQUEST["budgethead"][$i];
                        $return[$i]["lineitem"] = $_REQUEST["lineitem"][$i];
                        #echo'<pew>';print_r($_REQUEST);die;
                        #echo $_REQUEST["grant_list"][$i];die;
                        $return[$i]["amtavailable"] = $gran_wise_amount = $this->getaval_amount($_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i], $_REQUEST["progid"], $check, $pre, $_REQUEST["grant_id"][$i]);
                        #echo'<pew>';print_r($gran_wise_amount);die;
                        $return[$i]["amtreq"] = $_REQUEST["amtreq"][$i];
                        if (php72_cmp($inam) != 0 && !empty($inam)) {
                            if ($return[$i]['amtreq'] < $inam[$i]['amount_toapprove']) {
                                $return[$i]['amtreq'] = 0;
                            }
                        }
                        if ($return[$i]["amtreq"] > $return[$i]['amtavailable']) {
                            $return[$i]['amtreq'] = 0;
                        }if ((!is_numeric($return[$i]["amtreq"]) || (php72_cmp($return[$i]["amtreq"]) < 0)) && !empty($return[$i]["amtreq"])) {
                            $return[$i]['amtreq'] = 0;
                        }
                    } else { #error_reporting(-1);
                        $check = $this->CheckExist($return, $_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i]);
                        $return[$i]["donor"] = $_REQUEST["donor"][$i];
                        $return[$i]["budgethead"] = $_REQUEST["budgethead"][$i];
                        $return[$i]["lineitem"] = $_REQUEST["lineitem"][$i];
                        $return[$i]["amtavailable"] = $this->getaval_amount($_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i], $_REQUEST["progid"], $check, '', $_REQUEST["grant_id"][$i]);
                        $return[$i]["amtreq"] = $_REQUEST["amtreq"][$i];
                        if ($return[$i]["amtreq"] > $return[$i]['amtavailable']) {
                            $return[$i]['amtreq'] = 0;
                        }
                        if ((!is_numeric($return[$i]["amtreq"]) || (php72_cmp($return[$i]["amtreq"]) < 0)) && !empty($return[$i]["amtreq"])) {
                            $return[$i]['amtreq'] = 0;
                        }
                        #echo'<pre>';print_r($return);die;
                    }
                } else {
                    $return[$i]["donor"] = $_REQUEST["donor"][$i];
                    $return[$i]["budgethead"] = $_REQUEST["budgethead"][$i];
                    $return[$i]["lineitem"] = $_REQUEST["lineitem"][$i];
                    $return[$i]["amtavailable"] = "";
                    $return[$i]["amtreq"] = "";
                }
            }
        }
        echo json_encode($return);
    }

    function PreCheckExist($data) {
        $r = array();
        $c = php72_count($data["donor"]);
        $id = $data['id']; //echo $id;exit;
        for ($i = 0; $i < $c; $i++) {
            $r[$i]["donor"] = $data["donor"][$i];
            $r[$i]["budgethead"] = $data["budgethead"][$i];
            $r[$i]["lineitem"] = $data["lineitem"][$i];
            $r[$i]["amtavailable"] = $data["amtavailable"][$i];
            $r[$i]["amtreq"] = $data["amtreq"][$i];
        }
        $return = array();
        if (!empty($r)) {
            foreach ($r as $v) {
                $rv = $this->getReqAmt($data, $v["donor"], $v["budgethead"], $v["lineitem"], $id);
                if (!isset($return[$v["donor"]][$v["budgethead"]][$v["lineitem"]])) {
                    $return[$v["donor"]][$v["budgethead"]][$v["lineitem"]] = $rv;
                }
            }
        }
        return $return;
    }

    function CheckExist($data, $d, $b, $l) {
        $c = php72_count($data);
        $return = 0;
        if ($c > 0) {
            for ($i = 0; $i < $c; $i++) {
                if ($data[$i]["donor"] == $d && $data[$i]["budgethead"] == $b && $data[$i]["lineitem"] == $l && $data[$i]["amtreq"] != "") {
                    $return = $return + $data[$i]["amtreq"];
                }
            }
        }
        return $return;
    }

    function getReqAmt($v, $d, $b, $l, $id) {
        //$count = count($v);
        $this->db->select('sum(amt_required) as amount');
        $this->db->where('donor', $d);
        $this->db->where('budget_head', $b);
        $this->db->where('line_item', $l);
        $this->db->where('approval_id', $id);
        $q = $this->db->get('approval_note_donors');
        //debug_last_query();
        $res = $q->result_array();
        return $res[0]['amount'];
    }

    function getaval_amount($d, $b, $l, $progid, $existamount, $pre = "", $grant_id) {
        $sublineitemid = '';
        $lineitemid = $l;
        $budgetid = $b;
        $donorid = $d;
        $programmeid = $progid;
        $financialArray = $this->Mmasters->findCurrentFinancialYear();
        $from = convertMonthYearFrom($financialArray[0]['from']);
        $to = convertMonthYearTo($financialArray[0]['to']);

        $assignAmount = $this->Mmasters->checkAmountAssigned($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to, $grant_id);
        $approvalAmount = $this->Mmasters->checkApprovalNoteAmount($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to, $grant_id);
        $internalAmount = $this->Mmasters->checkInternalAmount($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to, $grant_id);
        $RecoveredAmount = $this->Mmasters->checkRecoveredAmount($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to, $grant_id);
        $availableAmount = ($assignAmount - ($approvalAmount)) + $RecoveredAmount;

        if (!empty($pre)) {
            $availableAmount = $availableAmount + $pre[$d][$b][$l];
        }
        $return = number_format((float) $availableAmount, 2, '.', '') - number_format((float) $existamount, 2, '.', '');
        return $return;
    }

    function get_travel_mode() {
        $traveMode = $this->mcommon->getMasterSetting('Travel Mode');
        $returnArr['status'] = '0';
        if (!empty($traveMode)) {
            $option = '<option  value="" >--Select--</option>';
            foreach ($traveMode as $lists) {
                $option .= '<option value="' . $lists['master_id'] . '" >' . $lists['master_name'] . '</option>';
                $returnArr['status'] = '1';
            }
        }
        $returnArr['response'] = $option;
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }

    function autocomplete($type = NULL, $terms = NULL) {
        $this->ais = $this->load->database('ais', TRUE);
        switch ($type) {
            case('cities'):
                $query = $this->ais->query("SELECT city FROM  cities where city like '" . $terms . "%' limit 0,10");
                foreach ($query->result_array() as $row) {
                    $values[] = $row['city'];
                }
                break;
        }
        echo json_encode($values);
    }

}

?>