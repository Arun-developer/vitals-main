<?php

class Mcron extends CI_Model {

	public function __construct() {
		 parent::__construct();
        $this->ais = $this->load->database('ais', TRUE);
        $this->hris = $this->load->database('hris', TRUE);
	}
	
	
	 function getAllUserList($yearInterval='') {
        $data = array();
        $this->db->distinct('hr_user_profile.emp_first_name');
        $this->db->select("hr_user_login.id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,hr_user_profile.id,hr_user_profile.official_email,hr_user_profile.personal_email", false);
        $this->db->where('hr_user_profile.partner_id', 1);
        $this->db->where_in('emp_type', array(3, 2, 7, 10));
        $this->db->join('hr_user_login', 'hr_user_login.emp_id = hr_user_profile.id');
		$this->db->join('hr_job_salary', 'hr_job_salary.emp_id = hr_user_profile.id');
		if($yearInterval!=''){
			$this->db->where('DATE(hr_job_salary.job_date)', date('Y-m-d', strtotime("-{$yearInterval} year")));
		}
        $this->db->order_by('hr_user_profile.emp_first_name');
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
	
	function getMail_Template($messageType) {
		$data = array();
		$this->ais = $this->load->database('ais', TRUE);
		$this->ais->where('messagetype', $messageType);
		$query = $this->ais->get('mailtemplate');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data[] = $row;
			}
		}
		$query->free_result();
		return $data;
	}
	
	
	function getAllEmployeeLeaveQuotas($remainderStatus ='') {
		
		$getFinancialYear = $this->mFindCurrentFinancialYear();
		$year = date('Y');
		if (!empty($getFinancialYear)) {
			$date = new DateTime($getFinancialYear[0]['from']);
			$year = $date->format("Y");
		}

		$this->db->select("
			t1.id,
			t1.year,
			t1.leave_type_id,
			t1.no_of_days_allotted,
			t1.leave_taken,
			t1.leave_brought_forward,
			t1.leave_encashed,
			t1.comments,
			t1.employee_id,
			t2.leave_type_name,
			t2.no_restrictions,
			t1.created_date,
			t3.emp_first_name AS emp_firstname,
			t3.emp_last_name AS emp_lastname,
			t3.official_email,
			t3.personal_email
		");

		$this->db->from('hr_leave_quota t1');
		$this->db->join('hr_user_profile t3', 't3.id = t1.employee_id', 'left');
		$this->db->join('hr_leave_type t2', 't2.leave_type_id = t1.leave_type_id AND t2.partner_id = t3.partner_id', 'left');
		$this->db->where('t1.year', $year);
		$this->db->where('t3.status', '1');
		$this->db->where('t3.emp_type', '3');
		if($remainderStatus=='Yes'){
			$this->db->where('DATE(t1.created_date)', date('Y-m-d', strtotime('-5 months')));
		}else{
			$this->db->where('DATE(t1.created_date)', date('Y-m-d', strtotime('-6 months')));
		}
		$this->db->where_in('t1.leave_type_id', ['LTY009', 'LTY010']);
		$this->db->order_by('t1.id', 'asc');

		$query = $this->db->get();
		$rows = $query->result_array();
		return $rows;
		
	}
	
	
	function getAllEmployeeLeaveQuotasCompOff($remainderStatus ='') {
		
		$getFinancialYear = $this->mFindCurrentFinancialYear();
		$year = date('Y');
		if (!empty($getFinancialYear)) {
			$date = new DateTime($getFinancialYear[0]['from']);
			$year = $date->format("Y");
		}

		$this->db->select("
			t1.id,
			t1.year,
			t1.leave_type_id,
			t1.no_of_days_allotted,
			t1.leave_taken,
			t1.leave_brought_forward,
			t1.leave_encashed,
			t1.comments,
			t1.employee_id,
			t2.leave_type_name,
			t2.no_restrictions,
			t1.created_date,
			t3.emp_first_name AS emp_firstname,
			t3.emp_last_name AS emp_lastname,
			t3.official_email,
			t3.personal_email
		");

		$this->db->from('hr_leave_quota t1');
		$this->db->join('hr_user_profile t3', 't3.id = t1.employee_id', 'left');
		$this->db->join('hr_leave_type t2', 't2.leave_type_id = t1.leave_type_id AND t2.partner_id = t3.partner_id', 'left');
		$this->db->where('t1.year', $year);
		$this->db->where('t3.status', '1');
		$this->db->where('t3.emp_type', '3');
		if($remainderStatus=='Yes'){
			#$this->db->where("DATE(t1.created_date)", date('Y-m-d', strtotime('-20 days')));
			$this->db->where(
				"DATE_SUB(DATE_ADD(DATE(t1.created_date), INTERVAL 1 MONTH), INTERVAL 10 DAY) =",
				date('Y-m-d')
			);
		}else{
			$this->db->where('DATE(t1.created_date)', date('Y-m-d', strtotime('-1 months')));
		}
		
		$this->db->where_in('t1.leave_type_id', ['LTY015']);
		$this->db->order_by('t1.id', 'asc');

		$query = $this->db->get();
		if($this->session->userdata['emp_number'] == '275') {
			debug_last_query();die;
		}
		
		$rows = $query->result_array();
		return $rows;
		
	}
	
	
	 public function mFindCurrentFinancialYear() {
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
	
	public function getDLeavesummaryDetails($filter_cond = '', $columns = '', $requestData = '') {
		$offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("t1.id,t1.year,t1.leave_type_id, t1.no_of_days_allotted, t1.leave_taken,t1.leave_brought_forward,t1.leave_encashed,t1.comments,t1.employee_id,t2.leave_type_name,  t2.no_restrictions, t3.emp_first_name as emp_firstname,t3.emp_last_name as emp_lastname");
		$this->db->join('hr_user_profile t3', 't3.id =  t1.employee_id', 'left');
		$this->db->join('hr_leave_type t2', 't2.leave_type_id =  t1.leave_type_id and t2.partner_id = t3.partner_id', 'left');		
		if ($columns != '' && $requestData != '') {
			$this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
		} else {
			$this->db->order_by('id', 'asc');
		}

		$filter_cond = $filter_cond." and t3.status = '1'";
		if ($filter_cond != '') {
			$this->db->where($filter_cond);
		}
		#$this->db->limit($num, $offset);
		$query = $this->db->get('hr_leave_quota t1');
		

		$rows = $query->result_array();
		return $rows;
	}
	
	public function updateLeaveQuota($condition=array(),$updateData=array()) {
		$this->db->where($condition);
		$this->db->set($updateData);
		$result = $this->db->update('hr_leave_quota');
		return $result; 
	}
	
	public function updateLog($data=array()) {
		$last_inserted = $this->db->insert('leave_request_log', $data);
		return $last_inserted; 
	}
	
	
	
	
	
	
}
