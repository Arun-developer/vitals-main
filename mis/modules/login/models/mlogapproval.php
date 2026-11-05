<?php

class Mlogapproval extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->model('login/Muser');
        $this->load->helper('debug');

        $this->ais = $this->load->database('ais', true);
        $this->hris = $this->load->database('hris', true);
    }

    public function getApprovalSetting($option) {
        $data = array();
        $this->ais->where('partner_id', $this->session->userdata('partner_id'));
        $query = $this->ais->get('approval_setting');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            $query->free_result();
            return $data['0'][$option];
        }
    }
	
	
    public function getAllApprovalNotesCount_test($where = null, $admin = null, $report = null) {  

        $data = array();

        $whereArray = array();

        $q = "select count(distinct(AP.approval_id)) as total,sum(AN.amt_required) as total_amount from approval_note AP";

        $q .= " left join master_programme MP  ON FIND_IN_SET(MP.programme_id,AP.programme) > 0";

        $q .= " left join approval_note_donors AN on AP.approval_id= AN.approval_id";

        if ($admin == null) {
            $whereArray[] = "AP.assigned_user ='" . $this->session->userdata('user_id') . "'";
        }

        if ($where != null) {
            $whereArray[] = $where;
        }

        $whereCond = implode(' and ', $whereArray);

        $financialArray = $this->findCurrentFinancialYear();
        $from = $this->convertMonthYearFrom($financialArray[0]['from']);
        $to = $this->convertMonthYearTo($financialArray[0]['to']);

        if ($whereCond != '') {
            $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to' and " . $whereCond;
        } else {
            $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to'";
        }
        $partner_id = $this->session->userdata('partner_id');
        $q .= " and AP.partner_id = '$partner_id'";
		
		#echo'<pre>';print_r($q);die;
        if ($report == null) {
            $query = $this->ais->query($q);
        }

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;
            }

            $data = array_pop($data);
        }
	
        $query->free_result();
        return $data;
    }

    public function getAllApprovalNotesCount($where = null, $admin = null, $report = null) {

        $data = array();

        $whereArray = array();

        $q = "select count(distinct(AP.approval_id)) as total,sum(AN.amt_required) as total_amount from approval_note AP";

        $q .= " left join master_programme MP  ON FIND_IN_SET(MP.programme_id,AP.programme) > 0";

        $q .= " left join approval_note_donors AN on AP.approval_id= AN.approval_id";

        if ($admin == null) {
            $whereArray[] = "AP.from_employee ='" . $this->session->userdata('user_id') . "'";
        }

        if ($where != null) {
            $whereArray[] = $where;
        }

        $whereCond = implode(' and ', $whereArray);

        $financialArray = $this->findCurrentFinancialYear();
        $from = $this->convertMonthYearFrom($financialArray[0]['from']);
        $to = $this->convertMonthYearTo($financialArray[0]['to']);

        if ($whereCond != '') {
            $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to' and " . $whereCond;
        } else {
            $q .= " where EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to'";
        }
        $partner_id = $this->session->userdata('partner_id');
        $q .= " and AP.partner_id = '$partner_id'";
		
        if ($report == null) {
            $query = $this->ais->query($q);
        }

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;
            }

            $data = array_pop($data);
        }

        $query->free_result();

        return $data;
    }

    public function reportingUser($type, $field, $empNumber = null) {
        $subUserArray = array();
        if ($empNumber == null) {
            $employees = $this->Muser->getReportingUser($this->session->userdata('emp_number'), $type);
        } else {
            $employees = $this->Muser->getReportingUser($empNumber, $type);
        }

        foreach ($employees as $row) {
            $subUserArray[] = $row['id'];
        }
        if ($field == 'userId') {
            return $subUserArray;
        } else {
            return $employees;
        }
    }

    public function convertMonthYearFrom($from) {
        $month = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07',
            'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
        $fromarray = explode(' ', $from);
        if (!empty($fromarray)) {
            @list($fromMonth, $fromYear) = array_pad(explode(' ', $from, 2), 2, null);
        }
        @$fromMonth = $month[$fromMonth];
        $yearmonth1 = $fromYear . $fromMonth;
        return $yearmonth1;
    }

    public function convertMonthYearTo($to) {
        $month = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07',
            'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
        @list($toMonth, $toYear) = array_pad(explode(' ', $to, 2), 2, null);
        if (isset($toMonth)) {
            @$toMonth = $month[$toMonth];
        }

        $yearmonth2 = $toYear . $toMonth;
        return $yearmonth2;
    }

    public function getApprovalDashboard($section, $currentTab) {
        $subUsers = implode("','", $this->reportingUser('subUser', 'userId'));
        $searchArray = array();
        $status = 'status';
        $admin = null;

        switch ($section) {

            case 'mylist':

            $admin = null;

            $status = 'status';

            break;

            case 'rolist':

            $searchArray[] = "AP.to_RO =  '" . $this->session->userdata('user_id') . "' ";
            $admin = 'Show all';

            $status = 'RO_status';

            break;

            case 'phlist':

            $searchArray[] = "AP.assigned_user = '" . $this->session->userdata('user_id') . "' ";

            $status = 'PH_status';

            $admin = 'Show all';

            if ($currentTab == 'pending' || $currentTab == 'confirmed') {

                $searchArray[] = "AP.RO_status = 'confirmed'";
            }

            break;

            case 'ceolist':

            $searchArray[] = "(AP.above_50000 = 'yes' or AP.estimated_in_workplan = 'no' )";

            $admin = 'Show all';

            $status = 'CEO_status';

            if ($currentTab == 'pending' || $currentTab == 'confirmed') {

                $searchArray[] = "AP.PH_status = 'confirmed'";
            }

            break;

            case 'finance':

            $admin = 'Show all';

            $title = 'Finance';
            if ($currentTab == 'pending') {
                $searchArray[] = "AP.finance_status = 'inprogress' AND AP.status = 'confirmed'";
            } else if ($currentTab == 'confirmed') {
                $searchArray[] = "AP.finance_status = 'confirmed' AND AP.status = 'confirmed'";
            }

            break;
            case 'admin':

            $admin = 'Show all';

            $status = 'status';

            break;
        }

        switch ($currentTab) {

            case 'pending':
            if ($section != 'finance') {
                $searchArray[] = "AP." . $status . " = 'pending' AND AP.status = 'pending'";
            }

            break;

            case 'confirmed':

            $searchArray[] = "AP." . $status . " = 'confirmed' AND AP.status = 'confirmed'";

            break;

            case 'cancelled':
            $searchArray[] = "AP." . $status . " = 'cancelled' AND AP.status = 'cancelled'";
            break;

            case 'defered':
            $searchArray[] = "  AP.status = 'defered'";
            break;
        }

        $financialArray = $this->findCurrentFinancialYear();
        $from = $this->convertMonthYearFrom($financialArray[0]['from']);
        $to = $this->convertMonthYearTo($financialArray[0]['to']);
        $searchArray[] = "EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to'";

        $where = implode(" and ", $searchArray);
 
        #Pagination Scripts Starts
		
        $total = $this->getAllApprovalNotesCount($where, $admin);

        return $total['total'];
    }
	
	
	
	
	public function getApprovalDashboard_test($section, $currentTab) {
        $subUsers = implode("','", $this->reportingUser('subUser', 'userId'));
        $searchArray = array();
        $status = 'status';
        $admin = null;

        switch ($section) {

            case 'mylist':

            $admin = null;

            $status = 'status';

            break;

            case 'rolist':

            $searchArray[] = "AP.to_RO =  '" . $this->session->userdata('user_id') . "' ";
            $admin = 'Show all';

            $status = 'RO_status';

            break;

            case 'phlist':

            $searchArray[] = "AP.assigned_user = '" . $this->session->userdata('user_id') . "' ";

            $status = 'PH_status';

            $admin = 'Show all';

            if ($currentTab == 'pending' || $currentTab == 'confirmed') {

                $searchArray[] = "AP.RO_status = 'confirmed'";
            }

            break;

            case 'ceolist':

            $searchArray[] = "(AP.above_50000 = 'yes' or AP.estimated_in_workplan = 'no' )";

            $admin = 'Show all';

            $status = 'CEO_status';

            if ($currentTab == 'pending' || $currentTab == 'confirmed') {

                $searchArray[] = "AP.PH_status = 'confirmed'";
            }

            break;

            case 'finance':

            $admin = 'Show all';

            $title = 'Finance';
            if ($currentTab == 'pending') {
                $searchArray[] = "AP.finance_status = 'inprogress' AND AP.status = 'confirmed'";
            } else if ($currentTab == 'confirmed') {
                $searchArray[] = "AP.finance_status = 'confirmed' AND AP.status = 'confirmed'";
            }

            break;
            case 'admin':

            $admin = 'Show all';

            $status = 'status';

            break;
        }

        switch ($currentTab) {

            case 'pending':
            if ($section != 'finance') {
                $searchArray[] = "AP." . $status . " = 'pending' AND AP.status = 'pending'";
            }

            break;

            case 'confirmed':

            $searchArray[] = "AP." . $status . " = 'confirmed' AND AP.status = 'confirmed'";

            break;

            case 'cancelled':
            $searchArray[] = "AP." . $status . " = 'cancelled' AND AP.status = 'cancelled'";
            break;

            case 'defered':
            $searchArray[] = "  AP.status = 'defered'";
            break;
        }

        $financialArray = $this->findCurrentFinancialYear();
        $from = $this->convertMonthYearFrom($financialArray[0]['from']);
        $to = $this->convertMonthYearTo($financialArray[0]['to']);
        $searchArray[] = "EXTRACT(YEAR_MONTH FROM AP.date_of_request) >= '$from' and EXTRACT(YEAR_MONTH FROM AP.date_of_request) <= '$to'";

        $where = implode(" and ", $searchArray);
		
        #Pagination Scripts Starts
		 
        $total = $this->getAllApprovalNotesCount_test($where, $admin);
		#echo'<pre>';print_r( $total);
        return $total['total'];
    }

    public function findCurrentFinancialYear() {
        $data = array();
        $this->ais->select('*');
        $this->ais->where('status', '1');
        $this->ais->where('partner_id', $this->session->userdata('partner_id'));
        $query = $this->ais->get('financial_year');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getInternalDashboard($section = 'mylist', $currentTab = 'pending') {
        $searchArray = array();

        $subUsers = implode("','", $this->reportingUser('subUser', 'userId'));

        $status = 'status';

        switch ($section) {

            case 'mylist':
            $searchArray[] = "INTER.from = '" . $this->session->userdata('user_id') . "'";
            $admin = null;

            break;

            case 'rolist':

            $single[] = '';
            $having[] = '';
            $users[] = '';
            $sub_user = $this->reportingUser('subUser', 'userId');
            foreach ($sub_user as $row) {
                    //to get emp number
                $this->db->where('id', $row);
                $emp = $this->db->get('hr_user_profile');
                $emp_num = $emp->result_array();
                $sub_supUser = $this->reportingUser('supUser', 'All', $emp_num[0]['id']);

                $count = count($sub_supUser);

                if ($count == 1) {
                    $single[] = $row;
                } elseif ($count > 1) {

                    $having[] = $row;
                } else {
                    $users[] = $row;
                }
            }
            $sub_user1 = implode("','", $sub_user);
            $single1 = implode("','", @$single);
            $users1 = implode("','", @$users);
            $having1 = implode("','", @$having);
            $searchArray[] = "((INTER.to IN ('" . $this->session->userdata('user_id') . "')) or (AN.to_RO ='" . $this->session->userdata('user_id') . "'))";
            $admin = 'Show all';

            $status = 'RO_status';

            break;

            case 'phlist':

            $searchArray[] = "MP.programme_head = '" . $this->session->userdata('user_id') . "'";

            if ($currentTab == 'pending' || $currentTab == 'confirmed') {

                $searchArray[] = "INTER.RO_status = 'confirmed'";
            }

            $admin = 'Show all';

            $status = 'PH_status';

            break;

            case 'finance':

            $admin = 'Show all';

            $title = 'Finance';
            if ($currentTab == 'pending') {
                $searchArray[] = "INTER.finance_status = 'inprogress' AND INTER.status = 'confirmed'";
            } else if ($currentTab == 'confirmed') {
                $searchArray[] = "INTER.finance_status = 'confirmed' AND INTER.status = 'confirmed'";
            }

            break;

            case 'admin':

            $admin = 'Show all';

            $status = 'status';

            break;
        }

        switch ($currentTab) {

            case 'pending':
            if ($section != 'finance') {
                $searchArray[] = "INTER." . $status . " = 'pending' AND INTER.status = 'pending' ";
            }

            break;

            case 'confirmed':

            $searchArray[] = "INTER." . $status . " = 'confirmed' AND INTER.status = 'confirmed'";

            break;

            case 'cancelled':

            $searchArray[] = "INTER." . $status . " = 'cancelled' AND INTER.status = 'cancelled'";

            break;

            case 'defered':

            $searchArray[] = "INTER.status = 'defered'";

            break;
        }

        $financialArray = $this->findCurrentFinancialYear();
        $from = $this->convertMonthYearFrom($financialArray[0]['from']);
        $to = $this->convertMonthYearTo($financialArray[0]['to']);

        $searchArray[] = "EXTRACT(YEAR_MONTH FROM INTER.date) >= '$from' and EXTRACT(YEAR_MONTH FROM INTER.date) <= '$to'";

        $where = implode(" and ", $searchArray);

        #Pagination Scripts Starts

        $total = $this->getAllInternalNotesCount($where, $admin);

        return $total['total'];
    }

    public function getAllInternalNotesCount($where = null, $admin = null) {

        $financialArray = $this->findCurrentFinancialYear();
        $from = $this->convertMonthYearFrom($financialArray[0]['from']);
        $to = $this->convertMonthYearTo($financialArray[0]['to']);

        if ($where != '') {

            $where .= "and EXTRACT(YEAR_MONTH FROM INTER.date) >= '$from' and EXTRACT(YEAR_MONTH FROM INTER.date) <= '$to' ";
        } else {
            $where .= "EXTRACT(YEAR_MONTH FROM INTER.date) >= '$from' and EXTRACT(YEAR_MONTH FROM INTER.date) <= '$to'";
        }

        $this->ais->select("count(*) as total, sum(amount_toapprove) as total_amount_toapprove");

        $this->ais->join('approval_note AN', 'AN.approval_id = INTER.approval_id');

        $this->ais->join('master_programme MP', 'MP.programme_id = AN.programme', 'left');

        $this->ais->where('AN.partner_id', $this->session->userdata('partner_id'));

        if ($where != null) {
            $query = $this->ais->get_where('internal_note INTER', $where);
        } else {
            $query = $this->ais->get('internal_note INTER');
        }

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;
            }
        }
        $query->free_result();

        return array_pop($data);
    }

    public function travelcount() {
        $financialArray = $this->findCurrentFinancialYear();
        $from = $this->convertMonthYearFrom($financialArray[0]['from']);
        $to = $this->convertMonthYearTo($financialArray[0]['to']);
        $sub_user = $this->reportingUser('subUser', 'userId');

        $this->ais->select('travel_request_id');
        $this->ais->join('travel_journey TJ', 'TB.travel_request_id = TJ.travel_booking_id', 'left');
        $where = "((EXTRACT(YEAR_MONTH FROM TJ.date_of_travel) >= '$from' and EXTRACT(YEAR_MONTH FROM TJ.date_of_travel) <= '$to') OR (EXTRACT(YEAR_MONTH FROM TB.date_of_requisition) >= '$from' and EXTRACT(YEAR_MONTH FROM TB.date_of_requisition) <= '$to'))";
        $emp_where = "(`employee_id`='" . $this->session->userdata('user_id') . "'";
        if (!empty($sub_user)) {
            foreach ($sub_user as $sub) {

                $subuser[] = $sub;
            }

            if (isset($subuser) && !empty($subuser)) {
                $array = '"' . implode('" , " ', $subuser) . '"';
                $emp_where .= " or  `employee_id` IN (" . $array . ")";
            }
        }
        $emp_where .= ")";
        if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
            $this->ais->where($emp_where);
        }

        $this->ais->where("TB.status", "pending");
        $this->ais->where($where);
        $this->ais->group_by('TJ.travel_booking_id');
        $query = $this->ais->get('travel_booking TB');
        return $query->num_rows();
    }

    public function librarycount() {
        $financialArray = $this->findCurrentFinancialYear();
        $from = $this->convertMonthYearFrom($financialArray[0]['from']);
        $to = $this->convertMonthYearTo($financialArray[0]['to']);
        $this->ais->select('count(*) as lib_count');
        if ($this->session->userdata('user_type') != 'admin') {
            $this->ais->where('employee_id', $this->session->userdata('user_id'));
        }

        $where = "((EXTRACT(YEAR_MONTH FROM request_date) >= '$from' and EXTRACT(YEAR_MONTH FROM request_date) <= '$to'))";
        $this->ais->where('status', 'pending');
        $this->ais->where($where);
        $query = $this->ais->get('library_booking');
        $row = $query->result_array();
        return $row[0]['lib_count'];
    }

    function checkLibraryRequest() {
        if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
            $this->ais->where('employee_id', $this->session->userdata('user_id'));
        }
        $this->ais->where('status', 'pending');
        $query = $this->ais->get('library_booking');

        return $query->num_rows();
    }

    public function leavecount() {
        $financialArray = $this->findCurrentFinancialYear();
        $from = $this->convertMonthYearFrom($financialArray[0]['from']);
        $to = $this->convertMonthYearTo($financialArray[0]['to']);
        $sub_user = $this->reportingUser('subUser', 'userId');
        $employee = array("employee_id" => $this->session->userdata('emp_number'));
        $where = "EXTRACT(YEAR_MONTH FROM leave_date) >= '$from' and EXTRACT(YEAR_MONTH FROM leave_date) <= '$to'";
        $this->db->select('count(DISTINCT leave_request_id) as leave_count');
        $emp_where = "(`employee_id`=" . $this->session->userdata('emp_number');
        if (!empty($sub_user)) {
            foreach ($sub_user as $sub) {
                $subuser[] = $sub['report_supervisor'];
            }

            if (isset($subuser) && !empty($subuser)) {
                $array = '"' . implode('" , " ', $subuser) . '"';
                $emp_where .= " or  `employee_id` IN (" . $array . ")";
            }
        }
        $emp_where .= ")";
        if ($this->session->userdata('user_type') != 'admin') {
            $this->db->where($emp_where);
        }

        $this->db->where("leave_status", "1");
        $this->db->where($where);
        $query = $this->db->get('hr_leave');
        $row = $query->result_array();
        return $row[0]['leave_count'];
    }

    public function emp_leavecount() {
        $financialArray = $this->findCurrentFinancialYear();
        $from = $this->convertMonthYearFrom($financialArray[0]['from']);
        $to = $this->convertMonthYearTo($financialArray[0]['to']);
        $sub_user = $this->reportingUser('subUser', 'erep_sub_emp_number');
        $employee = array("employee_id" => $this->session->userdata('emp_number'));
        $where = "EXTRACT(YEAR_MONTH FROM leave_date) >= '$from' and EXTRACT(YEAR_MONTH FROM leave_date) <= '$to'";
        $this->hris->select('count(DISTINCT leave_request_id) as leave_count');
        $emp_where = "(`employee_id`=" . $this->session->userdata('emp_number');
        $emp_where .= ")";
        if ($this->session->userdata('user_type') != 'admin') {
            $this->hris->where($emp_where);
        }

        $this->hris->where("leave_status", "1");
        $this->hris->where($where);
        $query = $this->hris->get('hr_leave');
        $row = $query->result_array();
        return $row[0]['leave_count'];
    }

    public function subord_leavecount() {
        $emp_where = $count = "";
        $financialArray = $this->findCurrentFinancialYear();
        $year = date('Y');
        $from = date($year . '-01-01');
        $to = date($year . '-12-31');
        $sub_user = $this->reportingUser('subUser', 'erep_sub_emp_number');

        if (!empty($sub_user)) {
            $where = "leave_date >= '$from' and leave_date <= '$to'";
            $this->hris->select('count(DISTINCT leave_request_id) as leave_count');
            $emp_where = "(";
            foreach ($sub_user as $sub) {
                $subuser[] = $sub['erep_sub_emp_number'];
            }

            if (isset($subuser) && !empty($subuser)) {
                $array = '"' . implode('" , " ', $subuser) . '"';
                $emp_where .= " `employee_id` IN (" . $array . ")";
            }
            $emp_where .= ")";
            if ($this->session->userdata('user_type') != 'admin' && $emp_where != '') {
                $this->hris->where($emp_where);
            }

            $this->hris->where("leave_status", "1");
            $this->hris->where($where);
            $query1 = $this->hris->get('hr_leave');
            if ($query1->num_rows() > 0) {
                $row = $query1->result_array(); //var_dump($row);
                $count = $row[0]['leave_count'];
            }
        }

        return $count;
    }

    function get_ph_user($userID, $partnerId) {
        $data = array();
        $this->ais->select('*');
        $this->ais->where('status', '1');
        $this->ais->where('partner_id', $partnerId);
        $this->ais->where('programme_head', $userID);
        $query = $this->ais->get('master_programme');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function get_PartnerDetails($id) {
        $data = array();
        $this->db->where('id', $id);
        $query = $this->db->get('hr_partner_type');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = $row;
            }
        }
        return $data;
    }

}
