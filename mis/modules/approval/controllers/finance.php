<?php

class Finance extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->Mauth->isLoggedCheck();
        //$this->Mauth->isAdminCheck();
		$this->load->library('upload');
		$this->load->model('Mapproval');
		$this->load->model('user/Empuser');
	}

	public function approval_note() {
		$emp_id = $this->session->userdata('emp_number');
		$data['approval_new'] = $this->Mapproval->approvalNumber();
		$data['reporting_list'] = $this->Mapproval->getROlist($emp_id);
		$data['program_list'] = $this->Mapproval->getProgrammeList();
		$sess_empid = $this->session->userdata('emp_number');
		$data['an_rocount'] = $rocount = total_ropending_count($sess_empid);
		$data['an_phcount'] = $phcount = total_phpending_count($sess_empid);

		$this->load->vars($data);
		$this->load->view('approval/finance/approval_note');
	}

	public function DTapproval_note() {
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

		$columnArr = array('AP.approval_no', 'AP.from_employee', 'AP.date_of_request', 'AP.date_of_seeking_approval', 'AP.date_payment_required', 'AP.to_RO', 'AP.from_employee', 'AP.purpose', 'programme_name', 'AN.additionalinfo', 'AP.status');
		$status = 'status';
		if ($columnArr[$columnIndex] != '') {
			$sort_column = $columnArr[$columnIndex];
		}
		$status = 'status';

		switch ($currentTab) {
			case 'pending':
			$searchArray[] = "AP.status = 'pending'";
			break;
			case 'confirmed':
			$searchArray[] = "AP.status = 'confirmed'";
			break;
			case 'cancelled':
			$searchArray[] = "AP.status = 'cancelled'";
			break;
			case 'defered':
			$searchArray[] = "AP.status = 'defered'";
			break;
			case 'closed':
			$searchArray[] = "AP.status = 'closed'";
			break;
			case 'draft':
			$searchArray[] = "AP.status  = 'draft'";
			break;
		}

		switch ($currentTab) {
			case 'all_pending':
			$searchArray[] = "AP.status = 'pending' OR AP.status = 'draft' OR AP.status = 'defered'";
			break;
			case 'all_approval':
			$searchArray[] = "AP.status = 'confirmed'";
			break;
		}

		if ($this->input->post('approval_no') != "")
			$searchArray[] = "AP.approval_no ='" . $this->input->post('approval_no') . "'";

		if ($this->input->post('purpose') != "")
			$searchArray[] = "AP.purpose like '%" . $this->input->post('purpose') . "%'";


		$where = php72_implode(" and ", $searchArray);

		$approvalCount = $this->Mapproval->getLimitApprovalNotes($where, '', '', $sort_column, $columnSortOrder, 'show All');
		$getAll_count = php72_count($approvalCount);

		$approval_lists = $this->Mapproval->getLimitApprovalNotes($where, $limit, $start, $sort_column, $columnSortOrder, 'show All');
		$getLimit_count = php72_count($approval_lists);

		foreach ($approval_lists as $lists) {
			$requestDate = '';
			$seekingDate = '';
			$paymentDate = '';
			if ($lists['date_of_request'] != '' && $lists['date_of_request'] != '0000-00-00') {
				$requestDate = date('Y-m-d', strtotime($lists['date_of_request']));
			}
			if ($lists['date_of_seeking_approval'] != '' && $lists['date_of_seeking_approval'] != '0000-00-00') {
				$seekingDate = date('Y-m-d', strtotime($lists['date_of_seeking_approval']));
			}
			if ($lists['date_payment_required'] != '' && $lists['date_payment_required'] != '0000-00-00') {
				$paymentDate = date('Y-m-d', strtotime($lists['date_payment_required']));
			}
			$employe_id = $lists['from_employee'];
			$to_RO = $lists['to_RO'];
			$programme_head = $lists['programme_head'];
            #$employe_id = '23';
			$employeeName = $this->Mapproval->getUserNameInfo($employe_id);
			$user_name = $employeeName[0]['user_name'];

			$RoName = $this->Mapproval->getUserNameInfo($to_RO);
			$ro_name = $RoName[0]['user_name'];

			$approval_userName = '';
            //if ($currentTab == 'pending') {
			if ($lists['PH_status'] == 'pending') {
				$phUser = $lists['programme_head'];
				$phName = $this->Mapproval->getUserNameInfo($phUser);
				$approval_userName = $phName[0]['user_name'];
			} else if ($lists['CEO_status'] == 'pending') {
				$ceoUser = $this->Mapproval->getApprovalSetting('ceo');
				$ceoName = $this->Mapproval->getUserNameInfo($ceoUser);
				$approval_userName = $ceoName[0]['user_name'];
			}
            //}
			$url = base_url() . 'index.php/approval/finance/approval_note_details/' . $lists['approval_id'];
			$view_btn = "<a  href=" . $url . " >" . 'View' . "</a>";
			$nestedData = array();
            #$nestedData[] = $lists['approval_no'];
			$nestedData[] = "<a href=''>" . $lists['approval_no'] . "</a>";
			$nestedData[] = date('d-m-Y', strtotime($requestDate));
			$nestedData[] = $lists['programme_name'];
			$nestedData[] = (strlen($lists['purpose']) > 50) ? substr($lists['purpose'], 0, 50) . ".." : $lists['purpose'];
			$nestedData[] = ucfirst($lists['status']);
			$nestedData[] = $approval_userName;
            #$nestedData[] = $view_btn;
			$nestedData[] = "<input type='hidden' class='get_approval_id' value=" . $lists['approval_id'] . " >";

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

	public function archive() {
		$data['financialList'] = $this->Mapproval->getfinanciallist();
		$emp_id = $this->session->userdata('emp_number');
		$data['approval_new'] = $this->Mapproval->approvalNumber();
		$data['reporting_list'] = $this->Mapproval->getROlist($emp_id);
		$data['program_list'] = $this->Mapproval->getProgrammeList();

		$this->load->vars($data);
		$this->load->view('approval/user/archive');
	}

	public function DTarchive() {
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
		$columnArr = array('AP.approval_no', 'AP.date_of_seeking_approval', 'AP.to_RO', 'AP.purpose', 'programme_name', 'AN.additionalinfo', 'AP.status');
		$status = 'status';
		if ($columnArr[$columnIndex] != '') {
			$sort_column = $columnArr[$columnIndex];
		}

		switch ($section) {
			case 'mylist':
			$admin = NULL;
			$status = 'status';
			$title = 'My List';
			break;
			case 'rolist':
			$searchArray[] = "AP.to_RO =  '" . $this->session->userdata('user') . "' ";
			$admin = 'Show all';
			$status = 'RO_status';
			$title = 'Reporting Officer';
			break;
			case 'phlist':
			$searchArray[] = "MP.programme_head = '" . $this->session->userdata('user') . "'";
			if ($currentTab == 'pending' || $currentTab == 'confirmed') {
				$searchArray[] = "AP.RO_status = 'confirmed'";
			}
			$status = 'PH_status';
			$admin = 'Show all';
			$title = 'Programme Head';
			break;
			case 'ceolist':
			$ceo = $this->Mapproval->getApprovalSetting('ceo');
			if ($ceo != $this->session->userdata('user')) {
				$this->session->set_flashdata('successMsg', 'Access Denied!');
				redirect('approvaluser/approval_note/' . $currentTab);
			}

			$searchArray[] = "(AP.above_50000 = 'yes' or AP.estimated_in_workplan = 'no' )";
			if ($currentTab == 'pending' || $currentTab == 'confirmed') {
				$searchArray[] = "AP.PH_status = 'confirmed'";
			}
			$admin = 'Show all';
			$status = 'CEO_status';
			$title = 'CEO';
			break;
			case 'finance':
			$admin = 'Show all';
			$title = 'Finance';
			break;
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

		if ($this->input->post('approval_no') != "")
			$searchArray[] = "AP.approval_no ='" . $this->input->post('approval_no') . "'";

		if ($this->input->post('purpose') != "")
			$searchArray[] = "AP.purpose like '%" . $this->input->post('purpose') . "%'";

		if ($this->input->post('status') != "")
			$searchArray[] = "AP.status like '%" . $this->input->post('status') . "%'";

		$where = php72_implode(" and ", $searchArray);

		$total = $this->Mapproval->getarchiveApprovalNotesCount($from, $to, $where);
		$getAll_count = php72_count($total);

		$approval_lists = $this->Mapproval->getarchiveApprovalNotes($from, $to, $limit, $start, $where, $sort_column, $columnSortOrder);
		$getLimit_count = php72_count($approval_lists);

		foreach ($approval_lists as $lists) {
			$requestDate = '';
			$seekingDate = '';
			$paymentDate = '';
			if ($lists['date_of_request'] != '') {
				$requestDate = date('Y-m-d', strtotime($lists['date_of_request']));
			}
			$employe_id = $lists['raise_from'];
			$to_RO = $lists['to_RO'];
			$programme_head = $lists['programme_head'];
            #$employe_id = '23';
			$employeeName = $this->Mapproval->getUserNameInfo($employe_id);
			$user_name = $employeeName[0]['user_name'];

			$RoName = $this->Mapproval->getUserNameInfo($to_RO);
			$ro_name = $RoName[0]['user_name'];
			$url = base_url() . 'index.php/approval/approval_note_details/' . $lists['approval_id'] . '/mylist';
			$confirm_url = $confirm_ur2 = '';

			$view_btn = "<a  href=" . $url . " class='action_cls delete_cls bordergrn-btn-outline' value=" . $lists['asset_id'] . " data-attr-an=" . $lists['asset_no'] . " data-attr-tid=" . $lists['transfer_id'] . " data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . ">" . 'View' . "</a>";
			$status = '';
			$nestedData = array();
			$nestedData[] = $lists['approval_no'];
			$nestedData[] = date('Y-m-d', strtotime($lists["date_of_seeking_approval"]));
			$nestedData[] = $ro_name;
			$nestedData[] = (strlen($lists['purpose']) > 50) ? substr($lists['purpose'], 0, 50) . ".." : $lists['purpose'];
			$nestedData[] = ucfirst($lists['programme_name']);
			$nestedData[] = ucfirst($lists['additionalinfo']);
			$nestedData[] = ucfirst($lists['status']);

			$nestedData[] = $user_name;
			$nestedData[] = $view_btn;
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

	public function action_history() {
		$data['financialList'] = $this->Mapproval->getfinanciallist();
		$emp_id = $this->session->userdata('emp_number');
		$data['approval_new'] = $this->Mapproval->approvalNumber();
		$data['reporting_list'] = $this->Mapproval->getROlist($emp_id);
		$data['program_list'] = $this->Mapproval->getProgrammeList();

		$this->load->vars($data);
		$this->load->view('approval/user/action_history');
	}

	public function DTaction_history() {
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
		$columnArr = array('AP.approval_no', 'AP.date_of_seeking_approval', 'AP.to_RO', 'AP.purpose', 'programme_name', 'AN.additionalinfo', 'AP.status');
		$status = 'status';
		if ($columnArr[$columnIndex] != '') {
			$sort_column = $columnArr[$columnIndex];
		}

		switch ($section) {
			case 'mylist':
			$admin = NULL;
			$status = 'status';
			$title = 'My List';
			break;
			case 'rolist':
			$searchArray[] = "AP.to_RO =  '" . $this->session->userdata('user') . "' ";
			$admin = 'Show all';
			$status = 'RO_status';
			$title = 'Reporting Officer';
			break;
			case 'phlist':
			$searchArray[] = "MP.programme_head = '" . $this->session->userdata('user') . "'";
			if ($currentTab == 'pending' || $currentTab == 'confirmed') {
				$searchArray[] = "AP.RO_status = 'confirmed'";
			}
			$status = 'PH_status';
			$admin = 'Show all';
			$title = 'Programme Head';
			break;
			case 'ceolist':
			$ceo = $this->Mapproval->getApprovalSetting('ceo');
			if ($ceo != $this->session->userdata('user')) {
				$this->session->set_flashdata('successMsg', 'Access Denied!');
				redirect('approvaluser/approval_note/' . $currentTab);
			}

			$searchArray[] = "(AP.above_50000 = 'yes' or AP.estimated_in_workplan = 'no' )";
			if ($currentTab == 'pending' || $currentTab == 'confirmed') {
				$searchArray[] = "AP.PH_status = 'confirmed'";
			}
			$admin = 'Show all';
			$status = 'CEO_status';
			$title = 'CEO';
			break;
			case 'finance':
			$admin = 'Show all';
			$title = 'Finance';
			break;
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

		if ($this->input->post('approval_no') != "")
			$searchArray[] = "AP.approval_no ='" . $this->input->post('approval_no') . "'";

		if ($this->input->post('purpose') != "")
			$searchArray[] = "AP.purpose like '%" . $this->input->post('purpose') . "%'";

		if ($this->input->post('status') != "")
			$searchArray[] = "AP.status like '%" . $this->input->post('status') . "%'";

		$where = php72_implode(" and ", $searchArray);

		$total = $this->Mapproval->getarchiveApprovalNotesCount($from, $to, $where);
		$getAll_count = php72_count($total);

		$approval_lists = $this->Mapproval->getarchiveApprovalNotes($from, $to, $limit, $start, $where, $sort_column, $columnSortOrder);
		$getLimit_count = php72_count($approval_lists);

		foreach ($approval_lists as $lists) {
			$requestDate = '';
			$seekingDate = '';
			$paymentDate = '';
			if ($lists['date_of_request'] != '') {
				$requestDate = date('Y-m-d', strtotime($lists['date_of_request']));
			}
			$employe_id = $lists['raise_from'];
			$to_RO = $lists['to_RO'];
			$programme_head = $lists['programme_head'];
            #$employe_id = '23';
			$employeeName = $this->Mapproval->getUserNameInfo($employe_id);
			$user_name = $employeeName[0]['user_name'];

			$RoName = $this->Mapproval->getUserNameInfo($to_RO);
			$ro_name = $RoName[0]['user_name'];
			$url = base_url() . 'index.php/approval/approval_note_details/' . $lists['approval_id'] . '/mylist';
			$confirm_url = $confirm_ur2 = '';

			$view_btn = "<a  href=" . $url . " class='action_cls delete_cls bordergrn-btn-outline' value=" . $lists['asset_id'] . " data-attr-an=" . $lists['asset_no'] . " data-attr-tid=" . $lists['transfer_id'] . " data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . ">" . 'View' . "</a>";
			$status = '';
			$nestedData = array();
			$nestedData[] = $lists['approval_no'];
			$nestedData[] = date('Y-m-d', strtotime($lists["date_of_seeking_approval"]));
			$nestedData[] = $ro_name;
			$nestedData[] = (strlen($lists['purpose']) > 50) ? substr($lists['purpose'], 0, 50) . ".." : $lists['purpose'];
			$nestedData[] = ucfirst($lists['programme_name']);
			$nestedData[] = ucfirst($lists['additionalinfo']);
			$nestedData[] = ucfirst($lists['status']);

			$nestedData[] = $user_name;
			$nestedData[] = $view_btn;
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

	function approval_note_details($id = '', $section = 'mylist') {

		$partnerNote = $this->Mapproval->getPartner($id);
		if ($partnerNote < 1 && is_numeric($id)) {
			redirect('approval/approval_note/pending');
		}
		$data['section'] = $section;
		$finance = unserialize($this->Mapproval->getApprovalSetting('finance'));
		if (php72_in_array($this->session->userdata('user'), $finance)) {
			$data['isFinance'] = 'Yes';
		} else {
			$data['isFinance'] = 'No';
		}

		$grantList = $this->Mapproval->get_grantList();
		$grantArr = array();
		foreach ($grantList as $lists) {
			$grantArr[$lists->id] = $lists->name;
		}
		$data['grantArr'] = $grantArr;

		$data['comments'] = $this->Mapproval->selectComment($id);
		$data['totalcomments'] = $this->Mapproval->selectTotalComment($id);

		$adminDetails = $this->Mapproval->adminDetails();
		$admin = $adminDetails[0]['id'];
		$data['isView'] = 'true';
		$data['isbView'] = 'true';
		$data['approvalNoteDetails'] = $approvalNoteDetails = $this->Mapproval->getApprovalNote($id);
		$partner_id = $data['approvalNoteDetails'][0]['partner_id'];
		$data['partner_details'] = $this->Mapproval->get_partnerName($partner_id);

		if ($approvedetails[0]['RO_status'] == 'defered' || $approvedetails[0]['PH_status'] == 'defered' || $approvedetails[0]['CEO_status'] == 'defered') {
			$data['isView'] = 'true';
		}
		if ($userid == $approvedetails[0]['from_employee'] || $userid == $approvedetails[0]['to_RO'] || $userid == $approvedetails[0]['programme_head'] || $userid == $ceo || $admin) {
			$data['isbView'] = 'true';
		}
		$data['emp_name'] = '';
		if ($approvalNoteDetails[0]['from_employee'] != '') {
			$emp_name_arr = $this->Mapproval->getUserNameInfo($approvalNoteDetails[0]['from_employee']);
			$data['emp_name'] = $emp_name_arr[0]['user_name'];
		}
		$data['ph_name'] = '';
		if ($approvalNoteDetails[0]['programme_head'] != '') {
			$ph_name_arr = $this->Mapproval->getUserNameInfo($approvalNoteDetails[0]['programme_head']);
			$data['ph_name'] = $ph_name_arr[0]['user_name'];
		}
		$data['to_RO'] = '';

		if ($approvalNoteDetails[0]['to_RO'] != '') {
			$ro_name_arr = $this->Mapproval->getUserNameInfo($approvalNoteDetails[0]['to_RO']);
			$data['to_RO'] = $ro_name_arr[0]['user_name'];
		}
		$ceoUser = $this->Mapproval->getApprovalSetting('ceo');

		$ceoName = $this->Mapproval->getUserNameInfo($ceoUser);
		$data['ceo_name'] = $ceoName[0]['user_name'];

		$data['subUsers'] = $this->Mapproval->reportingUser('subUser', 'userId');
		$data['sumof_int_amt'] = $this->Mapproval->int_amt_sumof($id);

		$data['donorAN'] = $this->Mapproval->getApprovalDonors($approvalNoteDetails[0]["approval_id"]);
		$data['open_int_notes'] = $this->Mapproval->getStatusINT($approvalNoteDetails[0]["approval_id"]);

		$data['employee_name'] == $this->Mapproval->getEmployeeName($approvalNoteDetails[0]['from_employee']);
		$data['user_id'] == $approvalNoteDetails[0]['from_employee'];

		$data['approval_id'] = $approvalNoteDetails[0]["approval_id"];
		$data['cpagetitle'] = "Approval Note Details";
		$this->load->view('approval/finance/approval_note_details', $data);
	}

}

?>