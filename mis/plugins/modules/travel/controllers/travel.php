<?php

class Travel extends CI_Controller {

    function __construct() {
        #error_reporting(-1);
        parent::__construct();
        /* $this->Mauth->isLoggedCheck();
          $this->Mauth->isAdminCheck();
          $this->Mauth->loginUser(); */
          $this->Mauth->isLoggedCheck();
          $this->load->model('travel/mcommon');
          $this->load->model('travel/Mlogin');
          $this->load->model('travel/Common_model');
          $this->load->model('travel/Mmasters');
        //$this->load->model('travel/Mapproval');
          $this->load->model('travel/Mtravel');
      }

      public function requestlist() {
        $data['categoryList'] = $this->Common_model->getMasterSetting('Books Category');
        $this->load->view('travel/request', $data);
        //$this->load->view('travel/request_from',$data);
    }

    public function requestlistreport() {
        #echo'<pre>';print_r($this->session->all_userdata());die;
        $data['subuserList'] = $this->Mtravel->reportingUser('subUser', 'all');
        $data['categoryList'] = $this->Common_model->getMasterSetting('Books Category');
        $this->load->view('travel/requestlistreport', $data);
    }

    public function archive() {
        $data['financialList'] = $this->Mtravel->getfinanciallist();
        $this->load->view('travel/archive', $data);
    }

    public function edit_request_from($currentTab, $requestId) {
        #error_reporting(-1);
        $requestListInfo = $this->Mtravel->getTravelRequestDetails($requestId);
        $data['requestListInfo'] = $requestListInfo;
        if ((in_array($requestListInfo['0']['employee_id'], $this->Mtravel->reportingUser('subUser', 'userId')) && $requestListInfo['0']['status'] == 'pending' ) || $this->session->userdata('isAdmin') == "Yes" || $this->session->userdata('user') == $requestListInfo['0']['employee_id']) {
            $data['costCentreList'] = $this->mcommon->getMasterSetting('Cost Centre');
            $data['donorList'] = $this->mcommon->getMasterSetting('Donor');
            $data['budgetHeadList'] = $this->mcommon->getMasterSetting('Budget Head');
            $data['traveMode'] = $this->mcommon->getMasterSetting('Travel Mode');
            $data['vendorList'] = $this->Mmasters->getVendorsList();
        }
        $data['personsList'] = $this->Mtravel->getPersonsList($requestId);
        $data['userList'] = $this->Mlogin->getAllUserList();
        $data['programmeList'] = $this->Mmasters->getMasterProgramme();
        $data['journeyList'] = $this->Mtravel->getJourneyList($requestId);
        #echo'<pre>';print_r($data);die;
        $this->load->view('travel/edit_request_from', $data);
    }

    public function get_lists($currentTab, $requestId) {
        $pid = $this->input->post('pid');
        $type = $this->input->post('type');
        $budgetHeadList = $this->mcommon->getMasterSetting($type, NULL, $pid);
        if (!empty($budgetHeadList)) {
            $returnArr['status'] = '0';
            $option = '<option  value="" >--Select--</option>';
            foreach ($budgetHeadList as $lists) {
                $option .= '<option value="' . $lists['master_id'] . '" >' . $lists['master_name'] . '</option>';
                $returnArr['status'] = '1';
            }
            $option .= '<option value="' . '0' . '" >' . 'Others' . '</option>';

            $returnArr['response'] = $option;
            $output = json_encode($returnArr);
            echo $output;
            exit;
        }
    }

    public function DTarchive() {

        #echo'<pre>';print_r($_POST);die;
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
        $section = $this->input->post('section');
        #echo'<pre>';print_r($_POST);die;
        $columnArr = array('AP.approval_no', 'AP.date_of_seeking_approval', 'AP.to_RO', 'AP.purpose', 'programme_name', 'AN.additionalinfo', 'AP.status');
        $status = 'status';
        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }

        $return_date_from = $this->input->post('interval_date');
        $get_date = explode('-', $return_date_from);
        $from = $get_date[0];
        $to = $get_date[1];

        if ($from == NULL || $to == NULL) {
            $from = '2009-04-01';
            $to = '2010-03-30';
        } else {
            $from = date('Y-m-01', strtotime('April' . substr($from, strlen($from) - 4)));
            $to = date('Y-m-t', strtotime('March' . substr($to, strlen($to) - 4)));
        }

        $searchArray = array();
        if ($this->input->post('travel_request_id') != "")
            $searchArray[] = "travel_booking.travel_request_id ='" . $this->input->post('travel_request_id') . "'";
        if ($this->input->post('from_date') != "")
            $searchArray[] = $curField . " >= '" . date('Y-m-d', strtotime($this->input->post('from_date'))) . "'";
        if ($this->input->post('to_date') != "")
            $searchArray[] = $curField . " >= '" . date('Y-m-d', strtotime($this->input->post('to_date'))) . "'";
        $where = implode(" and ", $searchArray);

        $approvalNotesList = $this->Mtravel->getarchiveTravelrequest($from, $to, $limit, $start, $where, 'Show All');
        $getLimit_count = count($approvalNotesList);

        $All_approvalNotesList = $this->Mtravel->getarchiveTravelrequest($from, $to, $limit, $start, $where, 'Show All');
        $getAll_count = count($All_approvalNotesList);

        foreach ($approvalNotesList as $lists) {
            #echo'<pre>';print_r($lists['programme_name']);die;

            $requestDate = '';
            $seekingDate = '';
            $paymentDate = '';
            if ($lists['date_of_request'] != '') {
                $requestDate = date('Y-m-d', strtotime($lists['date_of_request']));
            }
            $employe_id = $lists['employee_id'];
            #$employe_id = '23';
            $employeeName = $this->Mtravel->getUserNameInfo($employe_id);
            $user_name = $employeeName[0]['user_name'];

            if ($lists["donor"] == 0) {
                $donor = $lists["other_donor"];
            } else {
                $donor = $this->showMaster($lists["donor"]);
            }
            if ($lists["budget_head"] == 0) {
                $budget_head = $lists["other_budget_head"];
            } else {
                $budget_head = $this->showMaster($lists["budget_head"]);
            }
            if ($lists["cost_centre"] == 0) {
                $cost_centre = $lists["other_cost_centre"];
            } else {
                $cost_centre = $this->showMaster($lists["cost_centre"]);
            }

            $url = base_url() . 'index.php/travel/travel_request_details/archive/' . $lists['travel_request_id'];
            $nestedData = array();
            $nestedData[] = $lists['travel_request_id'];
            $nestedData[] = $user_name;
            $nestedData[] = date('Y-m-d', strtotime($lists["date_of_requisition"]));
            $nestedData[] = $donor;
            $nestedData[] = $budget_head;
            $nestedData[] = $cost_centre;
            $nestedData[] = ucfirst($lists["journey_type"]);
            $nestedData[] = $lists["reporting_approval"];
            $nestedData[] = ucfirst($lists["status"]);
            $nestedData[] = "<a  href='$url' >" . 'View' . "</a>";
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

    public function DTrequestlistreport() {

        #echo'<pre>';print_r($_POST);die;#error_reporting(-1);
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $action = $this->input->post('action');

        $currentTab = $this->input->post('currentTab');
        $columnArr = array('travel_booking.travel_request_id', 'travel_booking.master_name', '', '', '', 'travel_booking.journey_type', 'travel_booking.reporting_approval', 'travel_booking.status');

        $data['form_name'] = "master_search";
        $subUsers = implode("','", $this->Mtravel->reportingUser('subUser', 'userId'));
        $searchArray = array();
        $searchArray[] = "travel_booking.employee_id IN ('" . $subUsers . "')";
        switch ($currentTab) {
            case 'pending':
            $searchArray[] = "travel_booking.reporting_approval = 'pending'";
            $curField = 'cancel_date';
            break;
            case 'confirmed':
            $searchArray[] = "travel_booking.reporting_approval = 'confirmed'";
            $curField = 'date_of_requisition';
            break;
            case 'cancelled':
            $searchArray[] = "travel_booking.reporting_approval = 'cancelled'";
            $curField = 'date_of_requisition';
            break;
            case 'defered':
            $searchArray[] = "travel_booking.reporting_approval = 'defered'";
            break;
        }
        if ($this->input->post('travel_request_id') != "")
            $searchArray[] = "travel_request_id ='" . $this->input->post('travel_request_id') . "'";
        if ($this->input->post('employee_id') != "")
            $searchArray[] = "employee_id ='" . $this->input->post('employee_id') . "'";
        if ($this->input->post('date_from') != "")
            $searchArray[] = $curField . " >= '" . date('Y-m-d', strtotime($this->input->post('date_from'))) . "'";
        if ($this->input->post('date_to') != "")
            $searchArray[] = $curField . " <= '" . date('Y-m-d', strtotime($this->input->post('date_to'))) . "'";


        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }
        $where = implode(" and ", $searchArray);

        $travel_requestLists = $this->Mmasters->getLimitTravelRequest($where, $limit, $start, $sort_column, $columnSortOrder, 'show all');
        $getLimit_count = count($travel_requestLists);

        $AllrequestLists = $this->Mmasters->getLimitTravelRequest($where, '', '', $sort_column, $columnSortOrder, 'show all');
        $getAll_count = count($AllrequestLists);

        #echo'<pre>';print_r($_POST);die;
        foreach ($travel_requestLists as $lists) {
            $url = base_url() . 'index.php/travel/travel_request_details/' . $currentTab . '/' . $lists['travel_request_id'];
            $status = '';
            $nestedData = array();
            $nestedData[] = $lists['travel_request_id'];
            $nestedData[] = $lists['date_of_requisition'];
            $nestedData[] = $this->showMaster($lists['donor']);
            $nestedData[] = $this->showMaster($lists['budget_head']);
            $nestedData[] = $this->showMaster($lists['cost_centre']);
            $nestedData[] = $lists['journey_type'];
            $nestedData[] = $lists['reporting_approval'];
            $nestedData[] = $lists['status'];
            $nestedData[] = "<a  href='$url' >" . 'View' . "</a>";
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

    public function DTrequest_list() {

        #echo'<pre>';print_r($_POST);die;
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
        $where = implode(" and ", $searchArray);

        $travel_requestLists = $this->Mmasters->getLimitTravelRequest($where, $limit, $start, $sort_column, $columnSortOrder, null, null);
        $getLimit_count = count($travel_requestLists);

        $travel_requestListsAll = $this->Mmasters->getLimitTravelRequest($where, null, null, $sort_column, $columnSortOrder, null, null);
        $getAll_count = count($travel_requestListsAll);

        #echo'<pre>';print_r($travel_requestLists);die;
        $donor_str = $budget_head_str = $cost_centre_str = '';
        foreach ($travel_requestLists as $lists) {
            $donor_str = $lists['other_donor'];
            if ($lists['donor'] != 0) {
                $donor_str = $this->showMaster($lists['donor']);
            }
            $budget_head_str = $lists['other_budget_head'];
            if ($lists['budget_head'] != 0) {
                $budget_head_str = $this->showMaster($lists['budget_head']);
            }
            $cost_centre_str = $lists['other_cost_centre'];
            if ($lists['budget_head'] != 0) {
                $cost_centre_str = $this->showMaster($lists['cost_centre']);
            }

            $url = base_url() . 'index.php/travel/travel_request_details/' . $currentTab . '/' . $lists['travel_request_id'];
            $status = '';
            $nestedData = array();
            $nestedData[] = $lists['travel_request_id'];
            $nestedData[] = date('Y-m-d', strtotime($lists['date_of_requisition']));
            $nestedData[] = $donor_str;
            $nestedData[] = $budget_head_str;
            $nestedData[] = $cost_centre_str;
            $nestedData[] = $lists['journey_type'];
            $nestedData[] = $lists['reporting_approval'];
            $nestedData[] = $lists['status'];
            $nestedData[] = "<a  href='$url' >" . 'View' . "</a>";
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

    function travel_request_details($current_tab, $requestId) {

        $data['subUsers'] = $this->Mtravel->reportingUser('subUser', 'userId');

        $data['currentTab'] = $current_tab;
        $data['cpagetitle'] = "Travel Request - Details";
        $data['cpage'] = 'travel/user/requestInfo';
        $data['requestListInfo'] = $this->Mtravel->getTravelRequestDetails($requestId);
        $data['personsList'] = $this->Mtravel->getPersonsList($requestId);
        $data['journeyList'] = $this->Mtravel->getJourneyList($requestId);
        #echo'<pre>';print_r($data);die;
        $this->load->view('travel/travel_request_details', $data);
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
        #echo'<pre>';print_r($this->session->all_userdata());die;
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
        #echo'<pre>'; print_r($this->session->all_userdata());die;

        $start = 0;
        $limit = 1;
        $orderby = array('approval_id' => 'desc');
        $getApproval_Details = $this->Common_model->get_all_details('approval_note', array(), array(), $limit, $start, $orderby, true, 'ais');
        $text = "APN/";
        #echo'<pre>';print_r($getApproval_Details);die;
        if (count($getApproval_Details))
            $id = str_pad((int) $getApproval_Details[0]->approval_id + 1, 4, "0", STR_PAD_LEFT);
        else
            $id = '0001';
        $data['approval_new'] = $text . $id;
        $type = 'supUser';
        $emp_number = $this->session->userdata('emp_number');

        if ($emp_number == NULL) {
            $employees = $this->Mtravel->getReportingUser($emp_number, $type);
        } else {
            $employees = $this->Mtravel->getReportingUser($emp_number, $type);
        }
        #error_reporting(-1);
        $emp_id = $this->session->userdata('emp_number');

        $data['reporting_list'] = $this->Mtravel->getROlist($emp_id);
        $data['programmeList'] = $this->Mmasters->getBalanceProgramme();

        $data['datas'] = '';
        $this->session->unset_userdata('travelRequest');
        $this->session->set_userdata('travelRequest', json_encode($_POST));
        $this->load->view('travel/approval_form', $data);
    }

    public function insertApproval_note() {  #error_reporting(-1);
        //approval_note_donors
        $to_RO_show = $_POST['to_RO_show'];
        $submitForm = $this->input->post('submitForm');

        if (count($_POST) > 0) {
            if ($submitForm == 'Save') {
                $id = $this->Mtravel->insertapprovaldraft();
                $this->session->set_flashdata('successMsg', 'Approval Note Saved Successfully!');
                redirect('approval/approval_note/all_pending');
                exit;
            } else { #error_reporting(-1);
                $this->load->model('travel/mapproval');
                $id = $this->mapproval->insertApprovalNote();
            }
            $travel = $this->session->userdata('travelRequest');
            $_POST = (array) json_decode($travel);

            $prog = $this->Mtravel->getMasterProgramme($_POST['programme']);
            $_POST['programme'] = @$prog['0']['programme'];
            $_POST['approval_id'] = $approval_id;
            $reslut = $this->Mtravel->requestTravelBooking($to_RO_show);

            $this->approvalRequestMail($id);
            $this->travelRequestMail($reslut);
            # $this->session->set_flashdata('successMsg', 'Your Request Sent Successfully!');
            $this->session->unset_userdata('travelRequest', '');
        }
        redirect('traveladmin/requestlist/pending');
    }

    function test_mail($requestId) {
        echo $approval_id = '113';
        $this->testapprovalRequestMail($approval_id);
        die;
    }

    function testapprovalRequestMail($id) {  #echo'asd';die;
    $this->load->model('travel/mapproval');
    $approvalNoteDetails = $this->Mtravel->getApprovalNote($id);

    /* ---------Auto approving RO status when submitting approval note------------ */
        #$this->Mtravel->actionApproveRO('approve', $id);
    if ($approvalNoteDetails['0']['above_50000'] != 'yes') {
        if ($approvalNoteDetails['0']['programme_head'] == $approvalNoteDetails['0']['from_employee']) {
                #$this->Mtravel->actionApprovePHEnd('approve', $id);
            $toName = array('employee', 'ph');
            $toEm = array('employeeEmail', 'phEmail');
        } else {
            $toName = array('employee', 'ph');
            $toEm = array('employeeEmail', 'phEmail');
        }
    } else {
        if ($approvalNoteDetails['0']['programme_head'] == $approvalNoteDetails['0']['from_employee']) {
                #$this->Mtravel->actionApprovePH('approve', $id);
            $toName = array('employee', 'ph', 'ceo');
            $toEm = array('employeeEmail', 'phEmail', 'ceoEmail');
        } else {
            $toName = array('employee', 'ph');
            $toEm = array('employeeEmail', 'phEmail');
        }
    }
    foreach ($toName as $key => $value) {
        $mailContent = $this->Mtravel->mailContent($id, $value);
        $mailContent['phEmail'] = 'arunkumar.d@claritaz.com';
            #echo'<pre>';print_r($mailContent);
            #sendMail($mailContent['employeeEmail'], $mailContent[$toEm[$key]], 'Approval Note Request by Employee', $mailContent, $mailContent['attach']);
    }
    die;
}

    function approvalRequestMail($id) {  #echo'asd';die;
    $this->load->model('travel/mapproval');
    $approvalNoteDetails = $this->Mtravel->getApprovalNote($id);

    /* ---------Auto approving RO status when submitting approval note------------ */
        #$this->Mtravel->actionApproveRO('approve', $id);
    if ($approvalNoteDetails['0']['above_50000'] != 'yes') {
        if ($approvalNoteDetails['0']['programme_head'] == $approvalNoteDetails['0']['from_employee']) {
            $this->Mtravel->actionApprovePHEnd('approve', $id);
            $toName = array('employee', 'ph');
            $toEm = array('employeeEmail', 'phEmail');
        } else {
            $toName = array('employee', 'ph');
            $toEm = array('employeeEmail', 'phEmail');
        }
    } else {
        if ($approvalNoteDetails['0']['programme_head'] == $approvalNoteDetails['0']['from_employee']) {
            $this->Mtravel->actionApprovePH('approve', $id);
            $toName = array('employee', 'ph', 'ceo');
            $toEm = array('employeeEmail', 'phEmail', 'ceoEmail');
        } else {
            $toName = array('employee', 'ph');
            $toEm = array('employeeEmail', 'phEmail');
        }
    }
    foreach ($toName as $key => $value) {
        $mailContent = $this->Mtravel->mailContent($id, $value);
            #echo'<pre>';print_r($mailContent);die;
        sendMail($mailContent['employeeEmail'], $mailContent[$toEm[$key]], 'Approval Note Request by Employee', $mailContent, $mailContent['attach']);
    }
        #die;
}

    function travelRequestMail($requestId) { #error_reporting(-1);
        $this->load->helper('common_helper');
        $toMailArrray = array();
        $info = $this->Mtravel->getTravelRequestDetails($requestId);
        $employeeInfo = $this->Mlogin->getEmployeeFromUserId($info['0']['employee_id']);
        # $reportingAuth = $this->Mtravel->reportingUser('supUser', 'All', $employeeInfo['0']['id']);
        $reportingAuth = $this->Mtravel->getROlist($employeeInfo['0']['id']);

        if (!count($reportingAuth)) {
            $this->Mtravel->reportingAuthorityAction($requestId, 'confirmed');
            $mailContant = $this->Mtravel->mailContant($requestId, 'admin');
            $toMailArrray[] = $mailContant['adminEmail'];
            $tomailArr = array();
            foreach ($toMailArrray[0] as $lists) {
                $tomailArr = array($lists);
                $this->Mtravel->sendMail($mailContant['employeeEmail'], $tomailArr, 'Travel Booking Request', $mailContant);
            }
        } else {
            $mailContant = $this->Mtravel->mailContant($requestId, 'report');
            $toMailArrray[] = array_slice($mailContant['toEmail'], 1);
            $tomailArr = array();
            foreach ($toMailArrray[0] as $lists) {
                $tomailArr = array($lists);
                $this->Mtravel->sendMail($mailContant['employeeEmail'], $tomailArr, 'Travel Booking Request', $mailContant);
            }
        }
    }

    public function insertedit_travel_request($current_tab, $requestId) {
        #error_reporting(-1);
        #echo $requestId; echo'<pre>';print_r($_POST);die;
        if (!empty($_POST)) {
            $reslut = $this->Mtravel->requestTravelBookingUpdate($requestId);
            //$this->session->set_flashdata('successMsg', 'Your Request Updated Successfully!');
        }
        redirect('traveladmin/requestlist/pending');
    }

    function ajax_get_donor() {
        #error_reporting(-1);
        $programm_id = $this->input->post('programm_id');
        $donors = $this->Mmasters->getBalanceDonor($programm_id);
        $donor_lists = $this->mcommon->getMasterSetting('Donor');

        $option = '<option value="">--Select--</option>';
        foreach ($donor_lists as $rows) {
            if (in_array($rows['master_id'], $donors)) {
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

        /* error_reporting(-1);
        echo'<pre>';print_r($_POST);die; */

        #error_reporting(-1);
        $programm_id = $this->input->post('programm_id');
        $donor_id = $this->input->post('donor_id');
        $grant_id = $this->input->post('grant_id');
        $budget_head = $this->input->post('budget_head');
        $balance_budget_head = $this->mcommon->get_balance_sheet_detail('Budget Head', $programm_id, $donor_id, '', '', $grant_id);
        $budgetHeadList = $this->mcommon->getMasterSetting('Budget Head', NULL, '', $programm_id);
        $budgetHeadList = $this->mcommon->getBudgetLists($programm_id, $donor_id, $grant_id);
        #echo'<pre>';print_r($budgetHeadList);die;
        $budget_head_option = '<option value="" >-Select-</option>';
        if (isset($budgetHeadList) && !empty($budgetHeadList)) {
            foreach ($budgetHeadList as $lists) {
                $selected_opt = '';
                if ($budget_head != '') {
                    if ($budget_head == $lists['budget_id']) {
                        $selected_opt = 'selected';
                    }
                }
                $budget_head_option .= '<option  ' . $selected_opt . ' value="' . $lists['budget_id'] . '">' . $lists['master_name'] . '</option>';
                $returnArr['status'] = '1';
            }
        }
        $returnArr['response'] = $budget_head_option;
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }

    public function getAdditionalList() {#echo'<pre>';print_r($_POST);die;
    $program_id = $this->input->post('program');
    $donor_id = $this->input->post('donor');
    $budget_id = $this->input->post('budget');
    $line_id = $this->input->post('lineitem');
        #$data = $this->Mtravel->getAdditionalDetails_list($program_id, $donor_id, $budget_id, $line_id);
    $data = $this->mcommon->getAdditionalDetails_list($program_id, $donor_id, $budget_id, $line_id);

    $desc_option = '<option value="" >-Select-</option>';
    if (isset($data) && !empty($data)) {
        foreach ($data as $lists) {
            $selected_opt = '';
            if ($line_id != '') {
                if ($line_id == $lists['id']) {
                    $selected_opt = 'selected';
                }
            }
            $desc_option .= '<option  ' . $selected_opt . ' value="' . $lists['id'] . '">' . $lists['additionalinfo'] . '</option>';
            $returnArr['status'] = '1';
        }
    }
    $returnArr['response'] = $desc_option;
    $output = json_encode($returnArr);
    echo $output;
    exit;
}

function ajax_get_lineitem() {
        #echo'<pre>';print_r($_POST);die;
        #error_reporting(-1);
    $programm_id = $this->input->post('programm_id');
    $donor_id = $this->input->post('donor_id');
    $budget_head = $budget_id = $this->input->post('budget_id');
    $grant_id = $this->input->post('grant_id');
    $balance_budget_head = $this->mcommon->get_balance_sheet_detail('Line Item', $programm_id, $donor_id, '', '', $grant_id);
        #$lineItem = $this->mcommon->getMasterSetting('Line Item', NULL, '', $programm_id);

    $lineItem = $this->mcommon->getLineItemLists($programm_id, $donor_id, $grant_id, $budget_id);
        #echo'<pre>';print_r($lineItem);die;

    $lineItem_option = '<option value="" >-Select-</option>';
    if (isset($lineItem) && !empty($lineItem)) {
        foreach ($lineItem as $lists) {
            $selected_opt = '';
            if ($budget_head != '') {
                if ($budget_head == $lists['line_itemid']) {
                    $selected_opt = 'selected';
                }
            }
            $lineItem_option .= '<option  ' . $selected_opt . ' value="' . $lists['line_itemid'] . '">' . $lists['master_name'] . '</option>';
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

function ajax_book_request($bookId) {
    $this->load->helper('common_helper');
    $this->load->model('Mlogin');
    $this->load->model('Mlibrary');
    $returnArr = '0';
    $chechDup = $this->Mlibrary->checkRequest($bookId, $this->session->userdata("user"));
    if (count($chechDup) == 0) {
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
        #echo '<pre>';print_r($	);die;
        if (!empty($_REQUEST)) {
            $count = count($_REQUEST["donor"]);
            $return = array();
            for ($i = 0; $i < $count; $i++) {
                if ($_REQUEST["donor"][$i] != "" && $_REQUEST["budgethead"][$i] != "" && $_REQUEST["lineitem"][$i] != "") {


                    if (isset($_REQUEST["edit"])) {
                        $pre = $this->PreCheckExist($_REQUEST); //echo "<pre>";print_r($pre);exit;
                        $check = $this->CheckExist($return, $_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i]);
                        $inam = $this->Mtravel->tot_amt_in($_REQUEST['id'], $_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i], $_REQUEST['detail'][$i]);
                        $return[$i]["donor"] = $_REQUEST["donor"][$i];
                        $return[$i]["budgethead"] = $_REQUEST["budgethead"][$i];
                        $return[$i]["lineitem"] = $_REQUEST["lineitem"][$i];
                        #echo'<pew>';print_r($_REQUEST);die;
                        #echo $_REQUEST["grant_list"][$i];die;
                        $return[$i]["amtavailable"] = $gran_wise_amount = $this->getaval_amount($_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i], $_REQUEST["progid"], $check, $pre, $_REQUEST["grant_id"][$i]);
                        #echo'<pew>';print_r($gran_wise_amount);die;
                        $return[$i]["amtreq"] = $_REQUEST["amtreq"][$i];
                        if ($inam != 0 && !empty($inam)) {
                            if ($return[$i]['amtreq'] < $inam[$i]['amount_toapprove']) {
                                $return[$i]['amtreq'] = 0;
                            }
                        }
                        if ($return[$i]["amtreq"] > $return[$i]['amtavailable']) {
                            $return[$i]['amtreq'] = 0;
                        }if ((!is_numeric($return[$i]["amtreq"]) || ($return[$i]["amtreq"] < 0)) && !empty($return[$i]["amtreq"])) {
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
                        if ((!is_numeric($return[$i]["amtreq"]) || ($return[$i]["amtreq"] < 0)) && !empty($return[$i]["amtreq"])) {
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
        $c = count($data["donor"]);
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
        $c = count($data);
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

    function cancel($requestId, $currentTab) {
        $requestListInfo = $this->Mtravel->getTravelRequestDetails($requestId);
        if ($requestListInfo['0']['cancel_request'] == 'no') {
            $result = $this->Mtravel->cancelBooking($requestId);
            if ($result) {
                $this->cancelMail($requestId);
                $this->session->set_flashdata('successMsg', 'Your Cancel Request sent for admin approvel!');
                redirect('travel/travel_request_details/' . $requestId . '/' . $currentTab);
            }
        } else {
            $this->session->set_flashdata('errorMsg', 'Your Cancel Request Already Sent!');
            redirect('travel/travel_request_details/' . $requestId . '/' . $currentTab);
        }
    }

    function cancelMail($requestId) {

        $this->load->helper('common_helper');
        $toMailArrray = array();
        $mailContant = $this->Mtravel->mailContant($requestId, 'admin');

        $toMailArrray[] = $mailContant['adminEmail'];
        $toMailArrray[] = $mailContant['reportAuthEmail'];
        sendMail($mailContant['employeeEmail'], $toMailArrray, 'Travel Request cancellation by Employee', $mailContant);
    }

    function confirm($requestId, $currentTab) {
        $requestListInfo = $this->Mtravel->getTravelRequestDetails($requestId);
        if (in_array($requestListInfo['0']['employee_id'], $this->Mtravel->reportingUser('subUser', 'userId')) && $requestListInfo['0']['status'] == 'pending') {
            $result = $this->Mtravel->reportingAuthorityAction($requestId, 'confirmed');
            #$this->travelConfirmMailReport($requestId);
            $this->session->set_flashdata('successMsg', 'Employee Request Confirmed!');
            redirect('travel/travel_request_details/' . $requestId . '/' . $currentTab);
        } else {
            $this->session->set_flashdata('errorMsg', 'Your Request Already Processed!');
            redirect('travel/travel_request_details/' . $requestId . '/' . $currentTab);
        }
    }

    function auth_cancel($requestId, $currentTab) {
        $requestListInfo = $this->Mtravel->getTravelRequestDetails($requestId);
        if (in_array($requestListInfo['0']['employee_id'], $this->Mtravel->reportingUser('subUser', 'userId'))) {
            $result = $this->Mtravel->reportingAuthorityAction($requestId, 'cancelled');
            #$this->travelCancelMailReport($requestId);
            $this->session->set_flashdata('successMsg', 'Employee Request Cancelled!');
            redirect('travel/travel_request_details/' . $requestId . '/' . $currentTab);
        } else {
            $this->session->set_flashdata('errorMsg', 'Your Request Already Processed!');
            redirect('travel/travel_request_details/' . $requestId . '/' . $currentTab);
        }
    }

    function roaction($requestId, $option) {
        $requestListInfo = $this->Mtravel->getTravelRequestDetails($requestId);
        if (in_array($requestListInfo['0']['employee_id'], $this->Mtravel->reportingUser('subUser', 'userId')) && $requestListInfo['0']['status'] == 'pending') {
            $result = $this->Mtravel->deferedAction($requestId, $option);
            $this->Mtravel->insertdeferedcomments($requestId, $_POST['comments_RO'], $_POST['from_employee']);
            redirect('travel/requestlistreport');
        }
    }

}

?>