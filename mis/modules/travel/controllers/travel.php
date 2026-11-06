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
        if ((php72_in_array($requestListInfo['0']['employee_id'], $this->Mtravel->reportingUser('subUser', 'userId')) && $requestListInfo['0']['status'] == 'pending' ) || $this->session->userdata('isAdmin') == "Yes" || $this->session->userdata('user') == $requestListInfo['0']['employee_id']) {
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
        $getLimit_count = php72_count($approvalNotesList);

        $All_approvalNotesList = $this->Mtravel->getarchiveTravelrequest($from, $to, $limit, $start, $where, 'Show All');
        $getAll_count = php72_count($All_approvalNotesList);

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

            if (php72_cmp($lists["donor"]) == 0) {
                $donor = $lists["other_donor"];
            } else {
                $donor = $this->showMaster($lists["donor"]);
            }
            if (php72_cmp($lists["budget_head"]) == 0) {
                $budget_head = $lists["other_budget_head"];
            } else {
                $budget_head = $this->showMaster($lists["budget_head"]);
            }
            if (php72_cmp($lists["cost_centre"]) == 0) {
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
        $subUsers = php72_implode("','", $this->Mtravel->reportingUser('subUser', 'userId'));
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
        $getLimit_count = php72_count($travel_requestLists);

        $AllrequestLists = $this->Mmasters->getLimitTravelRequest($where, '', '', $sort_column, $columnSortOrder, 'show all');
        $getAll_count = php72_count($AllrequestLists);

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
        $where = php72_implode(" and ", $searchArray);

        $travel_requestLists = $this->Mmasters->getLimitTravelRequest($where, $limit, $start, $sort_column, $columnSortOrder, null, null);
        $getLimit_count = php72_count($travel_requestLists);

        $travel_requestListsAll = $this->Mmasters->getLimitTravelRequest($where, null, null, $sort_column, $columnSortOrder, null, null);
        $getAll_count = php72_count($travel_requestListsAll);

        #echo'<pre>';print_r($travel_requestLists);die;
        $donor_str = $budget_head_str = $cost_centre_str = '';
        foreach ($travel_requestLists as $lists) {
            $donor_str = $lists['other_donor'];
            if (php72_cmp($lists['donor']) != 0) {
                $donor_str = $this->showMaster($lists['donor']);
            }
            $budget_head_str = $lists['other_budget_head'];
            if (php72_cmp($lists['budget_head']) != 0) {
                $budget_head_str = $this->showMaster($lists['budget_head']);
            }
            $cost_centre_str = $lists['other_cost_centre'];
            if (php72_cmp($lists['budget_head']) != 0) {
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
        if (php72_count($getApproval_Details))
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

        if (!php72_count($reportingAuth)) {
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
            $toMailArrray[] = php72_array_slice($mailContant['toEmail'], 1);
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
        #echo '<pre>';print_r($	);die;
        if (!empty($_REQUEST)) {
            $count = php72_count($_REQUEST["donor"]);
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
        if (php72_in_array($requestListInfo['0']['employee_id'], $this->Mtravel->reportingUser('subUser', 'userId')) && $requestListInfo['0']['status'] == 'pending') {
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
        if (php72_in_array($requestListInfo['0']['employee_id'], $this->Mtravel->reportingUser('subUser', 'userId'))) {
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
        if (php72_in_array($requestListInfo['0']['employee_id'], $this->Mtravel->reportingUser('subUser', 'userId')) && $requestListInfo['0']['status'] == 'pending') {
            $result = $this->Mtravel->deferedAction($requestId, $option);
            $this->Mtravel->insertdeferedcomments($requestId, $_POST['comments_RO'], $_POST['from_employee']);
            redirect('travel/requestlistreport');
        }
    }
	
	
	//Travel Request
	function addTravelRequest() {
        $data['traveMode'] = $traveMode = $this->mcommon->getMasterSetting('Travel Mode');
        $data['traveMode_json'] = $traveMode_json = json_encode($traveMode, true);

        $user_type = $this->session->all_userdata('user_type');
        $data['userList'] = $this->Mlogin->getAllEmployeeUserConsultList();
		$this->load->model('user/Empuser');
		$option['status'] = 1;
		$data['nationality'] = $this->Empuser->getCommonDetails('hr_nationality', $option, 'asc', 'nationality');

		if ($this->session->userdata('user_type') != 'superadmin') {
			$partner_id = $this->session->userdata('partner_id');
			if ($partner_id == '10') {
				$pitch_id = '3';
			} else {
				$pitch_id = '1';
			}
			$condition = array('pitch' => $pitch_id, 'parent_id' => 0);
		} else {
			$condition = array('parent_id' => 0);
		}
		
		
		$get_sectorDetails = $this->Common_model->get_all_details('sector_category', $condition, array());

		$data['sector_details'] = array();
		if (!empty($get_sectorDetails)) {
			$excluded_ids = array(1, 214, 208, 215, 213, 219, 218, 196, 216,205,207,204,209,110);
			$filtered_sectors = array();
			foreach ($get_sectorDetails as $item) {
				if (in_array($item->id, $excluded_ids)) {
					$filtered_sectors[] = $item;
				}
			}
			$data['sector_details'] = $filtered_sectors;
		} else {
			$filtered_sectors = array(); 
		}
		

		#$data['sector_details'] = $filtered_sectors;
	



		/* $get_sectorDetails = $this->Common_model->get_all_details('sector_category', $condition, array());
		$data['sector_details'] ='';
		if (!empty($get_sectorDetails)) {
			$data['sector_details'] = $get_sectorDetails;
		} */
		
		/* $this->load->model('portfolio/Mportfolio');
		$get_inc_sector = $this->Mportfolio->getIncSector();
		$inc_sectors = array();
		foreach ($get_inc_sector as $sect) {
			array_push($inc_sectors, $sect['sector']);
		}
		
		$merge_incs = implode(',', $inc_sectors);
		$sectors_values = $this->Mportfolio->getIncSectorNames($merge_incs);
		$data['sector_details'] = $sectors_values; */
	
			
			
			
		$this->load->model('approval/Mapproval');
		$program_list = $this->Mapproval->getProgrammeList();
		$emp_id = $this->session->userdata('user');
        $data['reporting_list'] = $this->Mapproval->getROlist($emp_id);
		
		
		//($lists['programme_id']==113){
			/* echo'<pre>';print_r($lists['programme_id']);
			echo'<pre>';print_r($donorIds);die; */
			//echo'<pre>';print_r($program_list);
			//die;
		//}
		$programList = [];	
		if(!empty($program_list)){
			foreach($program_list as $lists){
				if($lists['programme_id']!='' && $lists['donor']!=''){
					$donorArray = unserialize($lists['donor']);
					
					
					if(!empty($donorArray)){
						foreach($donorArray as $donorIds){
							
							$dataBudjectArr = $this->Mtravel->getBudgetListTravel($lists['programme_id'], $donorIds);
							//if($lists['programme_id']==113){
								/* echo $lists['programme_id']." - ".$donorIds;
								echo'<br>';
								echo'<pre>';print_r($dataBudjectArr);  */
								
							//}
							
							if(!empty($dataBudjectArr)){
								
								 $programList[] = [
									'programme_id' => $lists['programme_id'],
									'partner_id' => $lists['partner_id'],
									'programme' => $lists['programme'],
									'programme_head' => $lists['programme_head'],
									'other_programme_head' => $lists['other_programme_head'],
									'other_donor' => $lists['other_donor'],
									'an_assign_user' => $lists['an_assign_user'],
									'an_request_sector' => $lists['an_request_sector'],
									'status' => $lists['status']
								];
							}
							
						}
					}
				}
			}
		}
		/* die; */
		$uniquePrograms = [];
		$seenProgrammeIds = [];

		if(!empty($programList)){
		foreach ($programList as $program) {
			if (!in_array($program['programme_id'], $seenProgrammeIds)) {
					$seenProgrammeIds[] = $program['programme_id'];
					$uniquePrograms[] = $program;
				}
			}
		}
		$data['program_list'] = $uniquePrograms;
		
        $this->load->view('travel/travel_request', $data);
    }
	
	
	
	
	function editTravelRequest(){
		
		$getTravelRequestId = $this->uri->segment(3); 
		if($getTravelRequestId!=''){
			$condition = array('id' => $getTravelRequestId);
			$data['get_travel_request'] =  $get_travel_request = $this->Mtravel->getTravelData('travel_request', $condition);
			
			$conditionTravel = array('travel_request_id' => $getTravelRequestId);
			$data['get_travel_personal_details'] = $get_travel_personal_details = $this->Mtravel->getTravelData('travel_request_personal_details', $conditionTravel);
			$data['get_travel_bus_details'] = $this->Mtravel->getTravelData('travel_request_bus_details', $conditionTravel);
			$data['get_travel_flight_details'] = $this->Mtravel->getTravelData('travel_request_flight_details', $conditionTravel);
			$data['get_travel_train_details'] = $this->Mtravel->getTravelData('travel_request_train_details', $conditionTravel);
			
			$userId = $this->input->post('user_id');
			$data['show_approve']= 'No';
			
			#print_r($this->session->all_userdata());die;
			
			$userId = $this->session->userdata('user_id');
			#echo $userId;die;
			if($userId==$get_travel_request[0]['to_RO']){
				$data['show_approve']= 'Yes';
			}
			
			$user_type = $this->session->all_userdata('user_type');
			#$data['userList'] = $this->Mlogin->getAllEmployeeUserList();
			$data['userList'] = $this->Mlogin->getAllEmployeeUserConsultList();
			
			$this->load->model('user/Empuser');
			$option['status'] = 1;
			$data['nationality'] = $this->Empuser->getCommonDetails('hr_nationality', $option, 'asc', 'nationality');

			if ($this->session->userdata('user_type') != 'superadmin') {
				$partner_id = $this->session->userdata('partner_id');
				if ($partner_id == '10') {
					$pitch_id = '3';
				} else {
					$pitch_id = '1';
				}
				$condition = array('pitch' => $pitch_id, 'parent_id' => 0);
			} else {
				$condition = array('parent_id' => 0);
			}

			/* $get_sectorDetails = $this->Common_model->get_all_details('sector_category', $condition, array());
			$data['sector_details'] ='';
			if (!empty($get_sectorDetails)) {
				$data['sector_details'] = $get_sectorDetails;
			}
			 */
			/* $this->load->model('portfolio/Mportfolio');
			$get_inc_sector = $this->Mportfolio->getIncSector();
			$inc_sectors = array();
			foreach ($get_inc_sector as $sect) {
				array_push($inc_sectors, $sect['sector']);
			}
			
			$merge_incs = implode(',', $inc_sectors);
			$sectors_values = $this->Mportfolio->getIncSectorNames($merge_incs);
			$data['sector_details'] = $sectors_values; */
			
			$get_sectorDetails = $this->Common_model->get_all_details('sector_category', $condition, array());

			$data['sector_details'] = array();
			if (!empty($get_sectorDetails)) {
				$excluded_ids = array(1, 214, 208, 215, 213, 219, 218, 196, 216,205,207,204,209,110);
				$filtered_sectors = array();
				foreach ($get_sectorDetails as $item) {
					if (in_array($item->id, $excluded_ids)) {
						$filtered_sectors[] = $item;
					}
				}
				$data['sector_details'] = $filtered_sectors;
			} else {
				$filtered_sectors = array(); 
			}
		
		
		
			
			$this->load->model('approval/Mapproval');
			$program_list = $this->Mapproval->getProgrammeList();
			
			$programList = [];	
			if(!empty($program_list)){
			foreach($program_list as $lists){
				if($lists['programme_id']!='' && $lists['donor']!=''){
					$donorArray = unserialize($lists['donor']);
					if(!empty($donorArray)){
						foreach($donorArray as $donorIds){
							$dataBudjectArr = $this->Mtravel->getBudgetList($lists['programme_id'], $donorIds);
							if(!empty($dataBudjectArr)){
								
								 $programList[] = [
									'programme_id' => $lists['programme_id'],
									'partner_id' => $lists['partner_id'],
									'programme' => $lists['programme'],
									'programme_head' => $lists['programme_head'],
									'other_programme_head' => $lists['other_programme_head'],
									'other_donor' => $lists['other_donor'],
									'an_assign_user' => $lists['an_assign_user'],
									'an_request_sector' => $lists['an_request_sector'],
									'status' => $lists['status']
								];
							}
							
						}
					}
				}
			}
		}
		$uniquePrograms = [];
		$seenProgrammeIds = [];

		if(!empty($programList)){
		foreach ($programList as $program) {
			if (!in_array($program['programme_id'], $seenProgrammeIds)) {
					$seenProgrammeIds[] = $program['programme_id'];
					$uniquePrograms[] = $program;
				}
			}
		}
			
			$data['program_list'] =$uniquePrograms;
			$data['reporting_list'] = $this->Mapproval->getROlist($get_travel_request[0]['user_id']);
			$this->load->view('travel/edit_travel_request', $data);
		}
	}
	

	function ajax_get_data() {
		
		$returnArr['response'] = '0';
		$userId = $this->input->post('user_id');
		$current_attr = $this->input->post('current_attr');
		$returnArr['data'] = '';
		$attr_val = '';
		if ($userId != '') {
			$returnArr['response'] = '1';
			$this->load->model('Mlogin');
			$userDetails = $this->Mlogin->getEmployeeData($userId);
			$emp_name = $userDetails[0]['emp_name'];
			$nationality = $userDetails[0]['nationality']?$userDetails[0]['nationality']:'';
			$mobile_number = $userDetails[0]['personal_mobile'];
			$emp_dob = date('d-m-Y',strtotime($userDetails[0]['emp_dob']));
			$attr_val = substr($current_attr, 6);
			$returnArr['data'] = array('attr_val' => $attr_val,'emp_name' => $emp_name, 'nationality' => $nationality, 'mobile_number' => $mobile_number, 'emp_dob' => $emp_dob);
		}
		echo json_encode($returnArr);
	}
	
	public function getBudgetItemList() {
        $program_id = $this->input->post('program');  
        $donor_id = $this->input->post('donor');
        $data = $this->Mtravel->getBudgetList($program_id, $donor_id);
        echo json_encode($data);
    }
	
	public function getLineList() {
        $program_id = $this->input->post('program');
        $donor_id = $this->input->post('donor');
        $budget_id = $this->input->post('budget');
        $data = $this->Mtravel->getLineItemList($program_id, $donor_id,$budget_id);
        echo json_encode($data);
    }
	 
	public function sendTravelRequestMail($from = NULL, $to = array(), $tamplate = NULL, $mailContant = NULL, $attach = NULL, $ccEmail = NULL,$replaceData =array()) { 
	
	/* 	ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL); 
		 */
		$this->load->model('approval/Mapproval');
		$org = $replaceData['org'];
		$replace = $replaceData['replace'];
		$mailTemplate = $this->Mapproval->getMailTemplate($tamplate);
		
        $messageSubject = $mailTemplate['0']['messagesubject'];
        #$messageBody = $mailTemplate['0']['messagebody'];
		$messageBody = str_replace($org, $replace, $mailTemplate['0']['messagebody']);
		$toEmail = $to;
		
		try {	
			$body = "Testing Mail";
			$this->load->library("PhpMailerLib");
			$mail = $this->phpmailerlib->load();
			$mail->setFrom('mis@villgro.org', 'Villgro Admin');
			$mail->Username   = "AKIAWKHBS5IYYPXSDZQE";
			$mail->Password   = "BCGFofeOlqofgdBTFAewlaSQv7pzYSdxau4RbKO5OoLa";
			$mail->Host       = "email-smtp.ap-south-1.amazonaws.com";
			$mail->Port       = 587;
			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = 'tls';
			
			$mail->IsSMTP(); 

			$mail->CharSet = 'utf-8';  
			$mail->SMTPDebug  = 1;   

			$mail->Subject = $messageSubject;

			$mail->MsgHTML($messageBody);
			/*  if (count($attach)) {
				foreach ($attach as $key => $value):
					if (file_exists($value)) {
						$mail->addAttachment($value);
					}
				endforeach;
			} */
			if(is_array($toEmail)){
				 if (!empty($toEmail)) {
					foreach ($toEmail as $keys => $email){
						if($email!=''){
							$mail->AddAddress($email);
						}
					}
				}
			  }else{ 
				if($to!=''){
				  $mail->AddAddress($to);
				}
			  }
			  if($mail->send()){ 
				  
			}else{
				
			}
		  
		} catch (Exception $e) { 
			#echo'<pre>';print_r($e);
		}
		
		
		/* echo'<pre>';print_r($from);
		echo'<pre>';print_r($messageBody);
		echo'<pre>';print_r($to);die; */
		
        //return true;
	}
	
	
	function approveRequest(){
		

		$getTravelRequestId = $this->uri->segment(3);
		$tmplate = 'Travel Request';
		$geAdminUsers = $this->Mtravel->getAdminUserDetails();
		
		$condition = array('id' => $getTravelRequestId);
		
		$busDataArr = array(
			'status' => 1,
			'ro_status' => 3,
			'updated_at'=>date('Y-m-d H:i:s'),
			'status_date'=>date('Y-m-d H:i:s'),
			'ro_status_date'=>date('Y-m-d H:i:s')
		
		);
		if(!empty($busDataArr)){ 
			$this->Mtravel->updateBatchTravelRequest('travel_request',$busDataArr,array('id'=>$getTravelRequestId));
		}
								
		$get_travel_request = $this->Mtravel->getTravelData('travel_request', $condition);
		$user_id = 	$get_travel_request[0]['user_id'];
		$ro_id  = 	$get_travel_request[0]['to_RO'];
		$admin_id = $get_travel_request[0]['admin_id'];
		
		$get_user_details = $this->Mtravel->getUserMisData('hr_user_profile', array('id'=>$user_id));
		$get_ro_details = $this->Mtravel->getUserMisData('hr_user_profile', array('id'=>$ro_id));
		
		$get_admin_details = $this->Mtravel->getUserMisData('hr_user_profile', array('id'=>$admin_id));
		
		$from = $get_ro_details[0]['official_email'];
		#$to = $get_user_details[0]['official_email'];
		$to = array($get_user_details[0]['official_email'],$get_admin_details[0]['official_email']);
		
		
		$org = array('#To#','#subject#', '#From#','#employeeName#','#requestNumber#','#emailId#','#travelNumber#','#requestDate#','#status#','#roStatus#');
		$replace = array(
			'',
			'Your request was approved',
			$get_user_details[0]['emp_name'],
			$get_user_details[0]['emp_first_name'].' '.$get_user_details[0]['emp_last_name'],
			$get_user_details[0]['personal_mobile'],
			$get_user_details[0]['official_email'],
			'TR'.$getTravelRequestId,
			date('d-m-Y'),
			'Pending',
			'Confirmed',
		);
		$replaceData = array('org'=>$org,'replace'=>$replace);
			
		$res = $this->sendTravelRequestMail($from, $to, $tmplate, null,null,null,$replaceData );
		
		
		//redirect('travel/travelRequestList');
		redirect('travel/travelApproveList');
        exit;
	}

	
	
	
	function cancelRequest(){
		

		$getTravelRequestId = $this->uri->segment(3);
		$tmplate = 'Travel Request';
		$geAdminUsers = $this->Mtravel->getAdminUserDetails();
		
		$condition = array('id' => $getTravelRequestId);
		
		$busDataArr = array(
			'status' => 2,
			'ro_status' => 2,
			'updated_at'=>date('Y-m-d H:i:s'),
			'status_date'=>date('Y-m-d H:i:s'),
			'ro_status_date'=>date('Y-m-d H:i:s')
		);
		if(!empty($busDataArr)){ 
			$this->Mtravel->updateBatchTravelRequest('travel_request',$busDataArr,array('id'=>$getTravelRequestId));
		}
								
		$get_travel_request = $this->Mtravel->getTravelData('travel_request', $condition);
		$user_id = 	$get_travel_request[0]['user_id'];
		$ro_id = 	$get_travel_request[0]['to_RO'];
		
		$get_user_details = $this->Mtravel->getUserMisData('hr_user_profile', array('id'=>$user_id));
		$get_ro_details = $this->Mtravel->getUserMisData('hr_user_profile', array('id'=>$ro_id));
		
		$from = $get_ro_details[0]['official_email'];
		$to = $get_user_details[0]['official_email'];
		
		$org = array('#To#', '#subject#', '#From#','#employeeName#','#requestNumber#','#emailId#','#travelNumber#','#requestDate#','#status#','#roStatus#');
		$replace = array(
			'',
			'Your request was cancelled',
			$get_user_details[0]['emp_name'],
			$get_user_details[0]['emp_first_name'].' '.$get_user_details[0]['emp_last_name'],
			$get_user_details[0]['personal_mobile'],
			$get_user_details[0]['official_email'],
			'TR'.$getTravelRequestId,
			date('d-m-Y'),
			'Cancel',
			'Cancelled',
		);
		$replaceData = array('org'=>$org,'replace'=>$replace);
			
		$res = $this->sendTravelRequestMail($from, $to, $tmplate, null,null,null,$replaceData );
	
		//redirect('travel/travelRequestList');
		
		redirect('travel/travelApproveList');
        exit;
		#echo $getTravelRequestId = $this->uri->segment(3); die;
	}
	
		
	public function add_edit_travel_request() { 

			
		$geAdminUsers = $this->Mtravel->getAdminUserDetails();
		
		$user_name = $this->input->post('user_name');
		$mobile_number = $this->input->post('mobile_number');
		$dob = $this->input->post('dob');
		$nationality = $this->input->post('nationality');
		$personDataArr = [];
		$busDataArr = [];
		$trainDataArr = [];
		$flightDataArr = [];
		
		$default_employee_type = $this->input->post('default_employee');
		
			$user_id = $this->input->post('user_id');
			
			$insertData = array(
				'user_id'=>$this->session->userdata('user'),
				'admin_id'=>$geAdminUsers[0]['emp_id'],
				'status'=>1,
				'to_RO'=>$this->input->post('to_RO'),
				'ro_status'=>1,
				'default_employee_type'=>$this->input->post('default_employee'),
				'purpose_of_travel'=>$this->input->post('purpose_of_travel'),
				'purpose_of_travel'=>$this->input->post('purpose_of_travel'),
				'sector'=>$this->input->post('sector'),
				'programme'=>$this->input->post('programme'),
				'donor'=>$this->input->post('donor_list'),
				'budget'=>$this->input->post('budget_list'),
				'line_item'=>$this->input->post('line_item'),
				'mode_of_transport'=>$this->input->post('mode_of_transport'),
				'require_stay'=>$this->input->post('require_stay'),
				'hotel_details'=>$this->input->post('hotel_details'),
				'city'=>$this->input->post('city'),
				'no_of_nights'=>$this->input->post('number_of_nights'),
				'check_in_date'=>$this->input->post('check_in_date')? date('Y-m-d', strtotime($this->input->post('check_in_date'))) :'',
				'check_out_date'=>$this->input->post('check_out_date')?date('Y-m-d', strtotime($this->input->post('check_out_date'))):'',
				'booking_instructions'=>$this->input->post('booking_instructions'),
				'additional_comments'=>$this->input->post('additional_comments'),
				'occupancy'=>$this->input->post('occupancy'),
				'created_at'=>date('Y-m-d H:i:s')
			);
			
		
			$getLastInsertId = $this->Mtravel->insertTravelRequest('travel_request',$insertData);
			
			#echo'<pre>';print_r($insertData);die;
				if($getLastInsertId!=''){
					
					if($default_employee_type=='No'){
			
							foreach ($user_name as $key => $value) {
								$personDataArr[] = array(
									'user_name' => $value,
									'travel_request_id' => $getLastInsertId,
									'mobile_number'=>$mobile_number[$key],
									'dob'=>date('Y-m-d', strtotime($dob[$key])),
									'nationality'=>$nationality[$key],
									'created_at'=>date('Y-m-d')
								);
							
							}
							if(!empty($personDataArr)){
								$this->Mtravel->insertBatchTravelRequest('travel_request_personal_details',$personDataArr);
							}
						
					}else{
						
						foreach ($user_id as $key => $value) {
							$userDetails = $this->Mlogin->getEmployeeData($value);
							$personDataArr[] = array(
								'user_name' => $userDetails[0]['emp_name'],
								'user_id' => $value,
								'travel_request_id' => $getLastInsertId,
								'mobile_number'=>$mobile_number[$key],
								'dob'=>date('Y-m-d', strtotime($dob[$key])),
								'nationality'=>$nationality[$key],
								'created_at'=>date('Y-m-d')
							);
						}
						#echo'<pre>';print_r($personDataArr);
						if(!empty($personDataArr)){
							$this->Mtravel->insertBatchTravelRequest('travel_request_personal_details',$personDataArr);
						}
					}
					
					
					if($this->input->post('mode_of_transport') =='Bus'){
						$bus_details = $this->input->post('bus_details');
						$travel_from_date = $this->input->post('travel_from_date');
						$travel_to_date = $this->input->post('travel_to_date');
						$comments = $this->input->post('comments');
						$bus_from_to_type = $this->input->post('bus_from_to_type');
						foreach ($bus_details as $key => $value) {
							$busDataArr[] = array(
								'bus_details' => $value,
								'travel_request_id' => $getLastInsertId,
								'bus_from_to_type' => $bus_from_to_type[$key],
								'travel_from_date' => date('Y-m-d', strtotime($travel_from_date[$key])),
								'travel_to_date' => date('Y-m-d', strtotime($travel_to_date[$key])),
								'comments' => $comments[$key],
								'created_at'=>date('Y-m-d')
							);
						}
						if(!empty($busDataArr)){
							$this->Mtravel->insertBatchTravelRequest('travel_request_bus_details',$busDataArr);
						}
					}else if($this->input->post('mode_of_transport') =='Train'){
						$train_name = $this->input->post('train_name');
						$train_travel_from_date = $this->input->post('train_travel_from_date');
						$train_travel_to_date = $this->input->post('train_travel_to_date');
						$train_class = $this->input->post('train_class');
						$train_comments = $this->input->post('train_comments');
						$train_from_to_type = $this->input->post('train_from_to_type');
						
						foreach ($train_name as $key => $value) {
							$trainDataArr[] = array(
								'train_name' => $value,
								'travel_request_id' => $getLastInsertId,
								'train_from_to_type' => $train_from_to_type[$key],
								'train_travel_from_date' => date('Y-m-d', strtotime($train_travel_from_date[$key])),
								'train_travel_to_date' => date('Y-m-d', strtotime($train_travel_to_date[$key])),
								'train_class' => $train_class[$key],
								'comments' => $train_comments[$key],
								'created_at'=>date('Y-m-d')
							);
						}
						if(!empty($trainDataArr)){
							$this->Mtravel->insertBatchTravelRequest('travel_request_train_details',$trainDataArr);
						}
					}else if($this->input->post('mode_of_transport') =='Flight'){
						$flight_name = $this->input->post('flight_name');
						$flight_from = $this->input->post('flight_from');
						$flight_from_to_type = $this->input->post('flight_from_to_type');
						$flight_to = $this->input->post('flight_to');
						$flight_travel_from_date = $this->input->post('flight_travel_from_date');
						$flight_travel_to_date = $this->input->post('flight_travel_to_date');
						$flight_comments = $this->input->post('flight_comments');
						
						foreach ($flight_name as $key => $value) {
							$flightDataArr[] = array(
								'flight_name' => $value,
								'travel_request_id' => $getLastInsertId,
								'flight_from_to_type' => $flight_from_to_type[$key],
								'flight_travel_from_date' => date('Y-m-d', strtotime($flight_travel_from_date[$key])),
								'flight_travel_to_date' => date('Y-m-d', strtotime($flight_travel_to_date[$key])),
								'comments' => $flight_comments[$key],
								'created_at'=>date('Y-m-d')
							);
						}
						if(!empty($flightDataArr)){
							$this->Mtravel->insertBatchTravelRequest('travel_request_flight_details',$flightDataArr);
						}
					}
				}
			
		
			#Send email user to admin
			
			$tmplate = 'Travel Request';
			$user_id = $this->session->userdata('emp_number');
			$get_user_details = $this->Mtravel->getUserMisData('hr_user_profile', array('id'=>$user_id));
			
			$getRoUsers = $this->Mtravel->getUserMisData('hr_user_profile', array('id'=>$this->input->post('to_RO')));
			
			$from = $get_user_details[0]['official_email'];
			$to = php72_array_column($getRoUsers, 'official_email');
			
			$org = array('#To#','#subject#', '#From#','#employeeName#','#requestNumber#','#emailId#','#travelNumber#','#requestDate#','#status#','#roStatus#');
			$replace = array(
				'',
				'You have a new travel request; the information is as follows:'.
				$get_user_details[0]['emp_name'],
				$get_user_details[0]['emp_first_name'].' '.$get_user_details[0]['emp_last_name'],
				$get_user_details[0]['personal_mobile'],
				$get_user_details[0]['official_email'],
				'TR'.$getLastInsertId,
				date('d-m-Y'),
				'Pending',
				'Pending',
			);
			$replaceData = array('org'=>$org,'replace'=>$replace);
			$this->sendTravelRequestMail($from, $to, $tmplate, null,null,null,$replaceData );
			
		redirect('travel/travelRequestList');
		
	}
	
	function travelRequestList() { 
	
	
	
		$user_id = $this->session->userdata('emp_number');
		$role_id = $this->session->userdata('role_id');
		$partner_id = $this->session->userdata('partner_id');
		$conditionFinance = array('partner_id'=>$partner_id);
		#$getFinanceUser = $this->vendor_model->get_all_details('approval_setting', $conditionFinance, array('finance'), '', '', '', true, 'ais');
		$data['user_status'] ='';
		if(!empty($getFinanceUser)){
			if(php72_in_array($role_id, array(1,2,3))){
				$data['user_status'] ='1';
			}
			$financeUserId = unserialize($getFinanceUser[0]->finance);
			if(!empty($financeUserId)){
				if(php72_in_array($user_id, $financeUserId)){
					$data['user_status'] ='2';
				}
			}
		}
		
		$condition['status'] = 1;
		$data['search_value'] = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';
		#$getVendorArray = $this->vendor_model->get_all_details('vendor', $condition,'', '', '', '');
		#echo'<pre>';print_r($getVendorArray);die;
		$this->load->vars($data);
		$this->load->view('travel_request_list');
	}
	
	function travelApproveList() { 
	
	
	
		$user_id = $this->session->userdata('emp_number');
		$role_id = $this->session->userdata('role_id');
		$partner_id = $this->session->userdata('partner_id');
		$conditionFinance = array('partner_id'=>$partner_id);
		#$getFinanceUser = $this->vendor_model->get_all_details('approval_setting', $conditionFinance, array('finance'), '', '', '', true, 'ais');
		$data['user_status'] ='';
		if(!empty($getFinanceUser)){
			if(php72_in_array($role_id, array(1,2,3))){
				$data['user_status'] ='1';
			}
			$financeUserId = unserialize($getFinanceUser[0]->finance);
			if(!empty($financeUserId)){
				if(php72_in_array($user_id, $financeUserId)){
					$data['user_status'] ='2';
				}
			}
		}
		$condition['status'] = 1;
		$data['search_value'] = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';
		#$getVendorArray = $this->vendor_model->get_all_details('vendor', $condition,'', '', '', '');
		#echo'<pre>';print_r($getVendorArray);die;
	
		
		$this->load->vars($data);
		$this->load->view('travel_approve_list');
	}
	
	
	
	public function DT_travelRequest_approve() {
		$requestData = $_POST;
		
		$user_id = $this->session->userdata('emp_number');
		/* $query = $this->Mtravel->getTravelApproveData($user_id);
		$totalData = count($query);
		$totalFiltered = $totalData; // Add this to avoid "undefined variable" notice */
		
		
		$getTotalCont = $this->Mtravel->getTravelApproveDataCount($user_id,$date_from,$date_to);
		$query = $this->Mtravel->getTravelApproveData($user_id,$date_from,$date_to,$requestData['length'], $requestData['start']);
		
		$totalData = php72_count($query);
		$totalFiltered =  php72_count($getTotalCont);
		
		$data = []; // Initialize $data
		$i = 0;

		foreach ($query as $row) { 
			$name = [];
			$userName = '';
			$getPersonalData = $this->Mtravel->getPersonalData($row['id']);
			if (!empty($getPersonalData)) {
				foreach ($getPersonalData->result() as $dataItem) {
					$name[] = $dataItem->user_name;
				}
				$userName = implode(', ', $name);
			}
			$nestedData = [];
			$nestedData[] = '<input type="checkbox" class="chk_box" id="emp_chk_box" name="id[]" value="' . $row['id'] . '"/>';
			$nestedData[] = 'TR'.$row['id'];
			$nestedData[] = $userName;
			$nestedData[] = $row['default_employee_type'];
			$status = '';
			if (php72_cmp($row['status']) == 1) {
				$status = 'Pending';
			} else if (php72_cmp($row['status']) == 2) {
				$status = 'Cancel';
			} else if (php72_cmp($row['status']) ==3) {
				$status = 'Confirm';
			} else if (php72_cmp($row['status']) == 4) {
				$status = 'Reject';
			}
			$nestedData[] = $status;
			$data[] = $nestedData;
			$i++;
		}

		$json_data = array(
			"draw" => intval($requestData['draw']),
			"recordsTotal" => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data" => $data
		);

		echo json_encode($json_data);
    }
	
	
	public function DT_travelRequest() {
		
		
		$requestData = $_POST;
		$user_id = $this->session->userdata('emp_number');
		#$query = $this->Mtravel->getTravelRequestData($user_id);
		
		$getTotalCont = $this->Mtravel->getTravelRequestCount($user_id,$date_from,$date_to);
		$query = $this->Mtravel->getTravelRequestData($user_id,$date_from,$date_to,$requestData['length'], $requestData['start']);
		
		$totalData = php72_count($query);
		$totalFiltered =  php72_count($getTotalCont);
		
		$requestData = $_POST;
		$data = []; // Initialize $data
		$i = 0;

		foreach ($query as $row) { 
			$name = [];
			$userName = '';
			$getPersonalData = $this->Mtravel->getPersonalData($row['id']);
			if (!empty($getPersonalData)) {
				foreach ($getPersonalData->result() as $dataItem) {
					$name[] = $dataItem->user_name;
				}
				$userName = implode(', ', $name);
			}
			$nestedData = [];
			$nestedData[] = '<input type="checkbox" class="chk_box" id="emp_chk_box" name="id[]" value="' . $row['id'] . '"/>';
			$nestedData[] = 'TR'.$row['id'];
			$nestedData[] = $userName;
			$nestedData[] = $row['default_employee_type'];
			$status = '';
			if (php72_cmp($row['status']) == 1) {
				$status = 'Pending';
			} else if (php72_cmp($row['status']) == 2) {
				$status = 'Cancel';
			} else if (php72_cmp($row['status']) ==3) {
				$status = 'Confirm';
			} else if (php72_cmp($row['status']) == 4) {
				$status = 'Reject';
			}
			$nestedData[] = $status;
			$data[] = $nestedData;
			$i++;
		}

		$json_data = array(
			"draw" => intval($requestData['draw']),
			"recordsTotal" => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data" => $data
		);

		echo json_encode($json_data);
		
		/* 
		echo'<pre>';print_r($getTravelDetails);die;
		$this->load->model('vendor/vendor_model');
		
		echo $user_id;die;
		$role_id = $this->session->userdata('role_id');
		$partner_id = $this->session->userdata('partner_id');
		$conditionFinance = array('partner_id'=>$partner_id);
		$getFinanceUser = $this->vendor_model->get_all_details('approval_setting', $conditionFinance, array('finance'), '', '', '', true, 'ais');
		$data['user_status'] ='';
		$cond ='';
		
		if(!empty($getFinanceUser)){
			if(in_array($role_id, array(1,2,3))){
				$cond = " AND v1.created_user_id = ".$user_id."";
			}
			$financeUserId = unserialize($getFinanceUser[0]->finance);
			if(!empty($financeUserId)){
				if(in_array($user_id, $financeUserId)){
					$cond = " AND v1.finance_user_id = ".$user_id."";
				}
			}
		}
		
		if(isset($user_id) && $user_id!=''){
			if($user_id==575){
				$cond = " AND v1.finance_user_id = ".$user_id."";
			}else{
				if(in_array($role_id, array(1,2,3))){
					$cond = " AND v1.created_user_id = ".$user_id."";
				}
			}
		}
		
        $requestData = $_POST;
		$columns = array(
				0 => 'id',
				1 => 'name',
				2 => 'address',
				3 => 'pan',
				4 => 'gst_number',
				5 => 'msme_registered',
				6 => 'status',
			);
			if($this->session->userdata('emp_number')==575){
				$columns = array(
					0 => 'id',
					1 => 'name',
					1 => 'created_user_id',
					2 => 'address',
					3 => 'pan',
					4 => 'gst_number',
					5 => 'msme_registered',
					6 => 'status',
				);
			}
        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['search_value'] = $search_value = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';
        $data['current_user'] = $current_user = (isset($_POST['current_user'])) ? $_POST['current_user'] : '';
		
		$totalrows = $this->vendor_model->getDTVendorCount($search_field, $search_value, $current_user, $columns, $requestData,$cond);
		$query = $this->vendor_model->getDTVendorDetails($requestData['length'], $requestData['start'], $search_field, $search_value, $current_user, $columns, $requestData,$cond);
		
		$totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = $report_to = array();
            $nestedData[] = '<input type="checkbox" class="chk_box" id="emp_chk_box" name="employee_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['name'];
			if($this->session->userdata('emp_number')==575){
				$getUserData = $this->vendor_model->get_all_details('hr_user_profile', array('id'=>$row['created_user_id']), array('official_email','emp_name'), '', '', '');
				$nestedData[] =  $getUserData[0]->emp_name;
			}
            $nestedData[] =   wordwrap($row['address'], 40, "<br>\n");
			$nestedData[] =  $row['pan'];
			$nestedData[] =  $row['gst_number'];
			$nestedData[] =  $row['msme_registered'];
			$status = '';
			if($row['status']==1){
				$status = 'Pending';
			}else if($row['status']==2){
				$status = 'Approved';
			}else if($row['status']==3){
				$status = 'Amend';
			}
			
			$nestedData[] =  $status;
            $data[] = $nestedData;
            $i++;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data); */
    }
	
	 public function getDonorNameList() {
        $program_id = $this->input->post('program');
        #$data = $this->Mtravel->getDonorList($program_id);
		$getDonor = $this->Mtravel->getDonorList($program_id);
		$donorList = [];	
		
		
		if($getDonor){
			foreach($getDonor  as $lists){
				$dataBudjectArr = $this->Mtravel->getBudgetList($program_id, $lists['donor_id']);
				
				/* echo'<pre>';print_r($program_id);
				echo'<pre>';print_r($getDonor);
				echo'<pre>';print_r($dataBudjectArr);die; */
				if(!empty($dataBudjectArr)){
					 $donorList[] = [
						'master_name' => $lists['master_name'],
						'donor_id' => $lists['donor_id'],
						'emp_name' => $lists['emp_name'],
					];
				}
				
			}
		}
		$uniqueDonors = [];
		$seenDonorIds = [];
		if(!empty($donorList)){
		foreach ($donorList as $lists) {
			if (!in_array($lists['donor_id'], $seenDonorIds)) {
					$seenDonorIds[] = $lists['donor_id'];
					$uniqueDonors[] = $lists;
				}
			}
		}
        echo json_encode($uniqueDonors);
    }
	
	



}

?>