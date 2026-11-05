<?php

class Traveladmin extends CI_Controller {

    function __construct() {
        #error_reporting(-1);
        parent::__construct();
        /* $this->Mauth->isLoggedCheck();
          $this->Mauth->isAdminCheck();
          $this->Mauth->loginUser(); */
        $this->load->model('traveladmin/mcommon');
        $this->load->model('traveladmin/Mlogin');
        $this->load->model('traveladmin/Common_model');
        $this->load->model('traveladmin/Mmasters');
		//$this->load->model('travel/Mapproval');
        $this->load->model('traveladmin/Mtravel');
    }

    public function report() {
		$data['costCentreList'] = $this->mcommon->getMasterSetting('Cost Centre');
		$data['userList'] = $this->Mlogin->getAllUserList();
		$data['monthArray'] = array('1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'Aug', '9' => 'Sept', '10' => 'Oct', '11' => 'Nov', '12' => 'Des');
		
        $data['categoryList'] = $this->Common_model->getMasterSetting('Books Category');
        $this->load->view('traveladmin/report', $data);
    }
	
	public function requestlist() {
		$report_type = $this->uri->segment(3);
		$reportType = $this->Mmasters->getReportList($report_type);
		#echo'<pre>';print_r($reportType);die;
		
		/* $userInfo = $this->Mtravel->getUserInfo(23);
		$employee_name = $userInfo[0]['user_name']; */
		$data['userList'] = $this->Mlogin->getAllUserList($userType);
        $data['categoryList'] = $this->Common_model->getMasterSetting('Books Category');
        $this->load->view('traveladmin/request', $data);
        //$this->load->view('travel/request_from',$data);
    }
	public function requestlistreport() {
		#echo'<pre>';print_r($this->session->all_userdata());die;
		$data['subuserList'] = $this->Mtravel->reportingUser('subUser', 'all');
		$data['categoryList'] = $this->Common_model->getMasterSetting('Books Category');
        $this->load->view('traveladmin/requestlistreport', $data);
    }
	public function archive(){
		$data['financialList'] = $this->Mtravel->getfinanciallist();
        $this->load->view('traveladmin/archive',$data);
    }
	
	public function edit_request_from($currentTab, $requestId){
		#error_reporting(-1);
		$requestListInfo = $this->Mtravel->getTravelRequestDetails($requestId);
        $data['requestListInfo'] = $requestListInfo;
		if((in_array($requestListInfo['0']['employee_id'], $this->Mtravel->reportingUser('subUser', 'userId')) && $requestListInfo['0']['status'] == 'pending' ) || $this->session->userdata('isAdmin') == "Yes" || $this->session->userdata('user') == $requestListInfo['0']['employee_id']){
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
		$this->load->view('traveladmin/edit_request_from',$data);
    }
	
	public function get_lists($currentTab, $requestId){ 
		$pid = $this->input->post('pid');
		$type = $this->input->post('type');
		$budgetHeadList = $this->mcommon->getMasterSetting($type, NULL, $pid);
		if(!empty($budgetHeadList)){
			$returnArr['status'] = '0';
				$option = '<option  value="" >--Select--</option>';
				foreach ($budgetHeadList as $lists) {
					$option .= '<option value="' . $lists['master_id'] . '" >' . $lists['master_name'] . '</option>';
					$returnArr['status'] = '1';
				}
				$option .= '<option value="' . '0' . '" >' .'Others'. '</option>';
			
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
			$searchArray[] = $curField . " >= '" . date('Y-m-d', strtotime($this->input->post('from_date'))). "'";
        if ($this->input->post('to_date') != "")
           $searchArray[] = $curField . " >= '" . date('Y-m-d', strtotime($this->input->post('to_date'))). "'";
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

			if($lists["donor"]==0){
				$donor = $lists["other_donor"];
			}else{
				$donor = $this->showMaster($lists["donor"]);
			}
			if($lists["budget_head"]==0){
				$budget_head = $lists["other_budget_head"];
			}else{
				$budget_head = $this->showMaster($lists["budget_head"]);
			}
			if($lists["cost_centre"]==0){
				$cost_centre = $lists["other_cost_centre"];
			}else{
				$cost_centre = $this->showMaster($lists["cost_centre"]);
			}
			
			$url = base_url() . 'index.php/traveladmin/travel_request_details/archive/' . $lists['travel_request_id'];
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
    public function DTrequestlistreport(){

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
        $subUsers = implode("','",  $this->Mtravel->reportingUser('subUser', 'userId'));
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
			$searchArray[] = $curField . " >= '" . date('Y-m-d', strtotime($this->input->post('date_from'))). "'";
		if ($this->input->post('date_to') != "")
			$searchArray[] = $curField . " <= '" . date('Y-m-d', strtotime($this->input->post('date_to'))) . "'";
        
		
        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }
        $where = implode(" and ", $searchArray);

        $travel_requestLists = $this->Mmasters->getLimitTravelRequest($where, $limit, $start, $sort_column, $columnSortOrder,  'show all');
        $getLimit_count = count($travel_requestLists);
		
		$AllrequestLists = $this->Mmasters->getLimitTravelRequest($where,'','', $sort_column, $columnSortOrder,  'show all');
		$getAll_count = count($AllrequestLists);
		
        #echo'<pre>';print_r($_POST);die;
        foreach ($travel_requestLists as $lists){
            $url = base_url() . 'index.php/traveladmin/travel_request_details/' . $currentTab . '/' . $lists['travel_request_id'];
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
        $employee_id = $this->input->post('employee_id');

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
		
		if ($this->input->post('employee_id') != "")
            $searchArray[] = "employee_id ='" . $this->input->post('employee_id') . "'";
				
				
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
        if ($this->session->userdata('user_type') != 'superadmin') {
            $partner = $this->session->userdata('partner_id');
            $searchArray[] = "partner_id ='" . $partner . "'";
        }

        $where = implode(" and ", $searchArray);

        $travel_requestLists = $this->Mmasters->getLimitTravelRequest($where, $limit, $start, $sort_column, $columnSortOrder,'Show All', null);
        $getLimit_count = count($travel_requestLists);

		$travel_requestListsAll = $this->Mmasters->getLimitTravelRequest($where, null, null, $sort_column, $columnSortOrder,'Show All', null);
        $getAll_count = count($travel_requestListsAll);
		#echo'<pre>';print_r($travel_requestLists);die;
		$employee_name ='';
		$donor_str = $budget_head_str = $cost_centre_str=  '';
        foreach ($travel_requestLists as $lists) {
			
			$donor_str = $lists['other_donor'];
			if($lists['donor']!=0){
				$donor_str = $this->showMaster($lists['donor']);
			}
			$budget_head_str = $lists['other_budget_head'];
			if($lists['budget_head']!=0){
				$budget_head_str = $this->showMaster($lists['budget_head']);
			}
			$cost_centre_str = $lists['other_cost_centre'];
			if($lists['budget_head']!=0){
				$cost_centre_str = $this->showMaster($lists['cost_centre']);
			}
			if($lists['employee_id']!=''){
				$userInfo = $this->Mtravel->getUserInfo($lists['employee_id']);
				$employee_name = $userInfo[0]['user_name'];
			}
			
            $url = base_url() . 'index.php/traveladmin/travel_request_details/' . $currentTab . '/' . $lists['travel_request_id'];
            $status = '';
            $nestedData = array();
            $nestedData[] = $lists['travel_request_id'];
            $nestedData[] = $employee_name;
            $nestedData[] = date('Y-m-d',strtotime($lists['date_of_requisition']));
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
	
	
	
	public function DTreports(){

      
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
		 $where =null;
        $travel_requestLists = $this->Mmasters->getLimitTravelReport($where, $limit, $start, $sort_column, $columnSortOrder, null, null);
        $getLimit_count = count($travel_requestLists);

        #echo'<pre>';print_r($_POST);die;

        foreach ($travel_requestLists as $lists) {
            $url = base_url() . 'index.php/traveladmin/travel_request_details/' . $currentTab . '/' . $lists['travel_request_id'];
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
	
	
	public function DTreport(){

        #echo'<pre>';print_r($_POST);die;
        #error_reporting(-1);
        $data = $datas= array();
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
		
		if($currentTab==''){
			$currentTab = 'report';
		}

        $columnArr = array('travel_booking.travel_request_id', 'travel_booking.master_name', '', '', '', 'travel_booking.journey_type', 'travel_booking.reporting_approval', 'travel_booking.status');

		########## START #############
		
		$searchArray = array();
        $stitle = array();
		$monthArray = array('1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'Aug', '9' => 'Sept', '10' => 'Oct', '11' => 'Nov', '12' => 'Des');
		$searchArray[] = "TB.status = 'confirmed' and TB.reporting_approval = 'confirmed'";
        $data['sort_column'] = 'date_of_travel';
        $data['sort_order'] = 'desc';
        if (!isset($_POST)) {
            $_POST['month'] = date('n');
            $_POST['year'] = date('Y');
            $searchArray[] = "MONTH(TJ.date_of_travel) ='" . $this->input->post('month') . "'";
            $searchArray[] = "YEAR(TJ.date_of_travel) ='" . $this->input->post('year') . "'";
        }
        switch ($currentTab) {
            case('report'): if ($this->input->post('sort_column') == '') {
                    $data['sort_column'] = 'date_of_travel';
                    $data['sort_order'] = 'desc';
                }
                break;
            case('employee'): if ($this->input->post('sort_column') == '') {
                    $data['sort_column'] = 'employee_id';
                    $data['sort_order'] = 'asc';
                }
                break;
            case('costcentre'): if ($this->input->post('sort_column') == '') {
                    $data['sort_column'] = 'cost_centre';
                    $data['sort_order'] = 'asc';
                }
                break;
        }
        if ($this->input->post('employee_id') != "" && $this->input->post('employee_id') != 'ALL') {
            if ($this->input->post('employee_id') == '0') {
                #$searchArray[] = "PD.name not like '%USR%'";
                $stitle[] = 'Others';
            } else {
                $searchArray[] = "PD.name ='" . $this->input->post('employee_id') . "'";
                $stitle[] = $this->Mtravel->getEmployeeName($this->input->post('employee_id'));
            }
        } if ($this->input->post('employee_id') == '') {
           # $searchArray[] = "PD.name like '%USR%'";
        }
        if ($this->input->post('budget_head') != "")
            $searchArray[] = "budget_head ='" . $this->input->post('budget_head') . "'";
        if ($this->input->post('cost_centre') != "") {
            $searchArray[] = "cost_centre ='" . $this->input->post('cost_centre') . "'";
            $stitle[] = $this->showMaster($this->input->post('cost_centre'));
        }
        if ($this->input->post('month') != "" && $this->input->post('year') != "") {
            $searchArray[] = "MONTH(TJ.date_of_travel) >='" . $this->input->post('month') . "'";
            $searchArray[] = "YEAR(TJ.date_of_travel) >='" . $this->input->post('year') . "'";
            $dtitle .= $monthArray[$this->input->post('month')] . ". " . $this->input->post('year');
        }
        if ($this->input->post('month1') != "" && $this->input->post('year1') != "") {
            $searchArray[] = "MONTH(TJ.date_of_travel) <='" . $this->input->post('month1') . "'";
            $searchArray[] = "YEAR(TJ.date_of_travel) <='" . $this->input->post('year1') . "'";
            $dtitle .= " TO " . $monthArray[$this->input->post('month1')] . ". " . $this->input->post('year1');
        }
        if ($_POST['month']=='')
            $searchArray[] = "MONTH(TJ.date_of_travel) ='" . date('m') . "' and YEAR(TJ.date_of_travel) ='" . date('Y') . "'";
        if ($dtitle != '')
            $stitle[] = $dtitle;
        if (count($stitle))
            $title .= " ( " . implode(" , ", $stitle) . " )";
        $where = implode(" and ", $searchArray);
		
		$travel_reportLists = $this->Mtravel->getLimitTravelReport($where, $limit, $start, $sort_column, $columnSortOrder, 'Show All');
		$getLimit_count = count($travel_reportLists);
		
		#echo $where;die;
		//TB.status = 'confirmed' and TB.reporting_approval = 'confirmed' and MONTH(TJ.date_of_travel) ='03' and YEAR(TJ.date_of_travel) ='2021'
		
		/* TB.status = 'confirmed' and TB.reporting_approval = 'confirmed' and MONTH(TJ.date_of_travel) >='1' and YEAR(TJ.date_of_travel) >='2020' and MONTH(TJ.date_of_travel) <='6' and YEAR(TJ.date_of_travel) <='2022' */
		
		#$where = "TB.status = 'confirmed' and TB.reporting_approval = 'confirmed' and MONTH(TJ.date_of_travel) >='1' and YEAR(TJ.date_of_travel) >='2020'";
		#echo '<pre>';print_r($travel_reportLists);die;
		$travel_reportLists_count = $this->Mtravel->getLimitTravelReport_count($where, NULL, NULL, $sort_column, $columnSortOrder, 'Show All');
		$getAll_count = count($travel_reportLists_count);
		
		
		#error_reporting(-1);
		############# END ################
       
        foreach ($travel_reportLists as $lists) {
            $name = $donor ='';
			if(strpos($lists['name'], 'SR')){
				$name = $this->Mtravel->getEmployeeName($lists['name']); 
			}else{
				$name = $lists['name'];
			}
			if($lists["donor"] == 0){
				$donor =  $lists["other_donor"]; 
			}else{
				$donor = $this->showMaster($lists["donor"]);
			}
			if($lists["budget_head"] == 0){
				$budget_head =  $lists["other_budget_head"]; 
			}else{
				$budget_head = $this->showMaster($lists["budget_head"]);
			}
			if($lists["line_item"] == 0){
				$line_item =  $lists["other_line_item"]; 
			}else{
				$line_item = $this->showMaster($lists["line_item"]);
			}
			if($lists["cost_centre"] == 0){
				$cost_centre =  $lists["other_cost_centre"]; 
			}else{
				$cost_centre = $this->showMaster($lists["cost_centre"]);
			} 
            $nestedData = array();
            $nestedData[] = $lists['travel_request_id'];
            $nestedData[] = $lists['bill_no'];
            $nestedData[] = $name;
            $nestedData[] = $lists['destination_from'];
            $nestedData[] = $lists['destination_to'];
            $nestedData[] = date('Y-m-d',strtotime($lists['date_of_travel']));
            $nestedData[] = $this->showMaster($lists["travel_mode"]);
            $nestedData[] = $lists['amount'];
            $nestedData[] = $lists['purpose'];
            $nestedData[] = $donor;
            $nestedData[] = $budget_head;
            $nestedData[] = $line_item;
            $nestedData[] = $cost_centre; 
            $datas[] = $nestedData;
            $i++;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($getLimit_count),
            "recordsFiltered" => intval($getAll_count),
            "data" => $datas,
            "POST" => $_POST
        );
		 #echo'<pre>';print_r($json_data);die;
        echo json_encode($json_data);
    }

    function travel_request_details($current_tab, $requestId) {
		
		#echo'<pre>';print_r($this->session->all_userdata());die;

        $data['subUsers'] = $this->Mtravel->reportingUser('subUser', 'userId');
        $data['requestListInfo'] = $this->Mtravel->getTravelRequestDetails($requestId);
        $data['personsList'] = $this->Mtravel->getPersonsList($requestId);
        $data['journeyList'] = $this->Mtravel->getJourneyList($requestId);
		$data['vendorList'] = $this->Mmaster->getVendorsList();
		#echo'<pre>';print_r($data);die;
        $this->load->view('traveladmin/travel_request_details', $data);
    }
	
	function sendtovendor($currentTab, $requestId, $value) {
		#error_reporting(-1);
        $data['requestListInfo'] = $this->Mtravel->getTravelRequestDetails($requestId);
        $data['personsList'] = $this->Mtravel->getPersonsList($requestId);
        $data['cpagetitle'] = "Travel Request Informations";
        $this->load->plugin('to_pdf');
        $journeyList = $this->Mtravel->getJourneyList($requestId, $value);
        $vendorDetails = $this->mcommon->getRecords_ais('master_vendor', 'vendor_id', $this->input->post('vendor'));
		$this->Mtravel->sentToVendor($requestId, $value);
        $data['journeyList'] = $journeyList;
        $html = $this->load->view('traveladmin/pdfVendor', $data, true);
		pdf_create($html, $requestId . "_" . $value, false, 'letter', 'potrait', 'uploads/travel/');
        $attach[] = "uploads/travel/" . $requestId . "_" . $value . ".pdf";
        $mailContant = array('org' => array('#toName#', '#fromName#'), 'replace' => array($vendorDetails['0']['vendor_name'], $this->session->userdata('username')));
        $adminEmail = $this->session->userdata('adminEmail');
        $vendorEmail = $vendorDetails['0']['vendor_email'];
        $toEmail = array($vendorEmail, $adminEmail);
		#sendMail($mailContant['adminEmail'], $toEmail, 'Travel Tickets Information', $mailContant, $attach);
		//$this->session->set_flashdata('successMsg', 'Your Request Sent Successfully!');
        redirect('traveladmin/travel_request_details/' . $currentTab . '/' . $requestId);
    }
	function upload_tickets($currentTab, $requestId) { #echo'<pre>';print_r($_POST);die;
		$bill_no = $this->input->post('bill_no');
        if ($bill_no != '') {
            if ($_FILES['e_ticket']['name'] != '') {
                if (@$this->input->post('ticket_id') == '') {
                    $result = $this->Mtravel->uploadTickets($requestId);
                    $this->ticketConfirmMail($requestId);
                    $this->session->set_flashdata('successMsg', 'Ticktets Uploaded!');
                } else {
                    $result = $this->Mtravel->reuploadTickets($requestId);
                    $this->ticketConfirmMail($requestId);
                    $this->session->set_flashdata('successMsg', 'Ticktets Reuploaded!');
                }
            } else
                $this->session->set_flashdata('errorMsg', 'Please Select File to Upload!');
        }
        else {
            $this->session->set_flashdata('errorMsg', 'Validation Error, Please Enter * Fields!');
        }
        redirect('traveladmin/travel_request_details/' . $currentTab . '/' . $requestId);
	}
	
	function ticket_cancel($requestId,$currentTab) {
		$credit_note_no = $this->input->post('credit_note_no');
        if ($credit_note_no != '') {
			$this->session->set_flashdata('successMsg', 'Ticket cancelled successfully');
            $result = $this->Mtravel->cancelTickets($requestId);    
			//$this->ticketCancelMail($requestId);$this->session->set_flashdata('successMsg','Ticktets Uploaded!');
        } else {
            $this->session->set_flashdata('errorMsg', 'Validation Error, Please Enter * Fields!');
        }
        redirect('traveladmin/travel_request_details/' . $currentTab . '/' . $requestId);
	}
	
	function ticketConfirmMail($requestId) {
	  
		$mailContant = $this->Mtravel->mailContant($requestId, 'employee');
        $personsList = $this->Mtravel->getPersonsList($requestId);
        foreach ($personsList as $row) {
            if ($row['name']!='') {
                $pDetails = $this->Mtravel->getUserInfo_details($row['name']);
				
                $toEmail[] = ($pDetails['0']['official_email'] != '') ? $pDetails['0']['official_email'] : $pDetails['0']['personal_email']; 
            } else {
                $toEmail[] = $this->session->userdata('adminEmail'); 
				
            }
        } $attach = array();
        foreach (array_filter($mailContant['ticket']) as $key => $value) {
            $attach[] = "uploads/tickets/" . $value;
        }
        $toEmail[] = $mailContant['reportAuthEmail'];
        sendMail($mailContant['adminEmail'], $toEmail, 'Travel Tickets Information', $mailContant, $attach);
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
        $this->load->view('traveladmin/request_from', $data);
		
    }

    public function approval_form() {

     
        $start = 0;
        $limit = 1;
        $orderby = array('approval_id' => 'desc');
        $getApproval_Details = $this->Common_model->get_all_details('approval_note', array(), array(), $limit, $start, $orderby, true, 'ais');
        $text = "APN/";

        if (count($getApproval_Details))
            $id = str_pad((int) $getApproval_Details[0]->approval_id + 1, 4, "0", STR_PAD_LEFT);
        else
            $id = '0001';
        $data['approval_new'] = $text . $id;

        
        $type = 'supUser';
        $emp_number = $this->session->userdata('emp_number');

        /* if ($emp_number == NULL) {
            $employees = $this->Mtravel->getReportingUser($emp_number, $type);
        } else {
            $employees = $this->Mtravel->getReportingUser($emp_number, $type);
        }
        #error_reporting(-1);
        $data['RO'] = $employees; */
		
		$emp_id = $this->session->userdata('user');
        $data['reporting_list'] = $this->Mtravel->getROlist($emp_id);
		
		

        $data['programmeList'] = $this->Mmasters->getBalanceProgramme();

        $data['datas'] = '';
        $this->session->unset_userdata('travelRequest');
        $this->session->set_userdata('travelRequest', json_encode($_POST));
        $this->load->view('traveladmin/approval_form', $data);
    }

    public function insertApproval_note() {
		
		#error_reporting(-1);
		$prog = $this->Mtravel->getMasterProgramme($_POST['programme']);
		/* echo'<pre>';print_r($prog);
		echo'<pre>';print_r($_FILES);
		echo'<pre>';print_r($_POST);die; */
        if (count($_POST) > 0) {
            $data = $this->Mtravel->insertapprovaldraft();
			$travel = $this->session->userdata('travelRequest');
			$_POST = (array) json_decode($travel);
			/*  echo'<pre>'; print_r($this->session->all_userdata());
				echo'<pre>';print_r($_POST);die; */
			$prog = $this->Mtravel->getMasterProgramme($_POST['programme']);
			$_POST['programme'] = @$prog['0']['programme'];
			$_POST['approval_id'] = $approval_id;
			$reslut = $this->Mtravel->requestTravelBooking();
			
			#$this->travelRequestMail($reslut);
			$this->session->set_flashdata('successMsg', 'Your Request Sent Successfully!');
			$this->session->unset_userdata('travelRequest', '');
		
        }
        redirect('traveladmin/requestlist/pending');
    }
	
	
	public function insertedit_travel_request($current_tab, $requestId) {
		#echo $requestId; echo'<pre>';print_r($_POST);die;
		if (!empty($_POST)){
			$reslut = $this->Mtravel->requestTravelBookingUpdate($requestId);
			$this->session->set_flashdata('successMsg', 'Your Request Updated Successfully!');
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
	
	
	function cancel($requestId, $currentTab) {#echo'asd';die;
		
        $requestListInfo = $this->Mtravel->getTravelRequestDetails($requestId);
		#echo'<pre>';print_r($requestListInfo);die	;
		/* if ($requestListInfo['0']['cancel_request'] == 'no') { */
            $result = $this->Mtravel->cancelBooking($requestId);
            if ($result) {
                #$this->cancelMail($requestId);
                $this->session->set_flashdata('successMsg', 'Your Cancel Request sent for admin approvel!');
                redirect('traveladmin/travel_request_details/' . $currentTab . '/' . $requestId);
            }
        /* } else {
            $this->session->set_flashdata('errorMsg', 'Your Cancel Request Already Sent!');
            redirect('traveladmin/travel_request_details/' . $currentTab . '/' . $requestId);
        }  */
    }
	function admin_cancel($requestId, $currentTab) { #error_reporting(-1);
		$this->load->helper('common_helper');
        $requestListInfo = $this->Mtravel->getTravelRequestDetails($requestId);
        $result = $this->Mtravel->adminAction($requestId, 'cancelled');
        $this->travelCancelMailAdmin($requestId);
        $this->session->set_flashdata('successMsg', 'Employee Request Cancelled!');
		redirect('traveladmin/travel_request_details/' . $currentTab . '/' . $requestId);
    } 
	function travelCancelMailAdmin($requestId) {
		$this->load->model('traveladmin/Mtravel');
        $mailContant = $this->Mtravel->mailContant($requestId, 'employee');
		#error_reporting(-1);
        $toMailArrray[] = $mailContant['employeeEmail'];
        $toMailArrray[] = $mailContant['reportAuthEmail'];
		$tomailArr = array();
		foreach($toMailArrray as $lists){
			if($lists!=''){
				$tomailArr = array($lists);
				sendMail($mailContant['adminEmail'], $tomailArr, 'Travel booking Request Disapproval by Admin', $mailContant);	
			}
	    }
    }

	function confirm($requestId, $currentTab) {
        $requestListInfo = $this->Mtravel->getTravelRequestDetails($requestId);
		#echo'<pre>';print_r($requestListInfo);die;
		if ($requestListInfo['0']['status'] == 'pending' && $requestListInfo['0']['reporting_approval'] == 'confirmed') {
            $result = $this->Mtravel->adminAction($requestId, 'confirmed'); 
            $mailContant = $this->Mtravel->mailContant($requestId, 'employee');
            $toMailArrray[] = $mailContant['employeeEmail'];
            $toMailArrray[] = $mailContant['reportAuthEmail'];
			foreach($toMailArrray as $lists){
				if($lists!=''){
					sendMail($mailContant['adminEmail'], $toMailArrray, 'Travel Booking Request confirmed by Admin', $mailContant); 
				}
			}
            $this->session->set_flashdata('successMsg', 'Employee Request Confirmed!');
            redirect('traveladmin/travel_request_details/' . $currentTab . '/' . $requestId);
        } else {
            $this->session->set_flashdata('errorMsg', 'Your Request Already Processed!');
            redirect('traveladmin/travel_request_details/' . $currentTab . '/' . $requestId);
        }
    }
	
	function auth_cancel($requestId, $currentTab) {
        $requestListInfo = $this->Mtravel->getTravelRequestDetails($requestId);
        if (in_array($requestListInfo['0']['employee_id'], $this->Mtravel->reportingUser('subUser', 'userId'))) {
            $result = $this->Mtravel->reportingAuthorityAction($requestId, 'cancelled');
            #$this->travelCancelMailReport($requestId);
            $this->session->set_flashdata('successMsg', 'Employee Request Cancelled!');
            redirect('traveladmin/travel_request_details/' . $requestId . '/' . $currentTab);
        } else {
            $this->session->set_flashdata('errorMsg', 'Your Request Already Processed!');
            redirect('traveladmin/travel_request_details/' . $requestId . '/' . $currentTab);
        }
    }
	function roaction($requestId, $option) {
        $requestListInfo = $this->Mtravel->getTravelRequestDetails($requestId);
        if (in_array($requestListInfo['0']['employee_id'], $this->Mtravel->reportingUser('subUser', 'userId')) && $requestListInfo['0']['status'] == 'pending') {
            $result = $this->Mtravel->deferedAction($requestId, $option);
            $this->Mtravel->insertdeferedcomments($requestId, $_POST['comments_RO'], $_POST['from_employee']);
            redirect('traveladmin/requestlistreport');
        }
    }
	
	function approve_ro($requestId, $currentTab) {
        $result = $this->Mtravel->reportingAuthorityAction($requestId, 'confirmed');
        $this->session->set_flashdata('successMsg', 'Employee Request Confirmed!');
        redirect('traveladmin/travel_request_details/' . $currentTab . '/' . $requestId);
    }

    function disapprove_ro($requestId, $currentTab) {
        $result = $this->Mtravel->reportingAuthorityAction($requestId, 'cancelled');
        $this->session->set_flashdata('successMsg', 'Employee Request Rejected!');
        redirect('traveladmin/travel_request_details/' . $currentTab . '/' . $requestId);
    }
	

}

?>