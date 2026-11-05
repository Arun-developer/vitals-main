<?php

class Mleave extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function getLeaveCommonDetails($table, $condition = '', $orderby = '', $column = '') {

		if ($condition != '') {
			$this->db->where($condition);
		}

		if ($column == '') {
			if ($orderby != '') {
				$this->db->order_by('id', $orderby);
			} else {
				$this->db->order_by('id', 'desc');
			}
		} else {
			if ($orderby != '') {
				$this->db->order_by($column, $orderby);
			} else {
				$this->db->order_by($column, 'desc');
			}
		}

		$this->db->select('*');
		$query = $this->db->get($table);
		$rows = $query->result_array();
		return $rows;
	}

	public function getEmployeedetail($empid = '', $cond = '') {
		if ($empid != '') {
			$this->db->where('id', $empid);
		}
		if ($cond != '') {
			$this->db->where($cond);
		}
		$this->db->where('status', 1);
		$this->db->select("id as employee_id, emp_first_name as emp_firstname, emp_last_name as emp_lastname, emp_type, YEAR(created_at) as created_year, official_email");

		$query = $this->db->get('hr_user_profile');
		$rows = $query->result_array();
		return $rows;
	}

	public function getSupervisor($empid = '', $subid = '') {
		if ($empid != '') {
			$this->db->where('t1.report_subordinate', $empid);
		}
		if ($subid != '') {
			$this->db->where('t1.report_supervisor', $subid);
		}
		$this->db->select("t1.report_subordinate as erep_sup_emp_number, t1.report_supervisor as erep_sub_emp_number, t2.emp_first_name as emp_firstname, t2.emp_last_name as emp_lastname, t2.official_email as emp_work_email");
		$this->db->join('hr_user_profile t2', 't2.id =  t1.report_subordinate', 'left');

		$this->db->where('t1.status', '1');
		$query = $this->db->get('hr_user_reporting t1');
		$rows = $query->result_array();
		return $rows;
	}

	public function getchecksuperadmin($empid = '') {
		if ($empid != '') {
			$this->db->where('t1.emp_id', $empid);
		}
		$this->db->where('t1.user_role', 3);
		$this->db->select("t1.emp_id, t1.user_role");

        // $query = $this->db->get('hr_user_profile');
		$query = $this->db->get('hr_user_login t1');
		$rows = $query->result_array();
		return $rows;
	}

	public function checkLeaveStatus($curdate = '') {
		if ($curdate != '') {
			$this->db->where('leave_startdate <=', $curdate);
		}
		$this->db->where('leave_status', 1);
		$this->db->select("id, leave_request_id, leave_length_days, employee_id, leave_type_id, leave_startdate, YEAR(leave_startdate) as year");

		$query = $this->db->get('hr_leave');
		$rows = $query->result_array();
		return $rows;
	}

	public function checkscheduledLeave($cond = '') {
		if ($cond != '') {
			$this->db->where($cond);
		}
		$this->db->where('leave_status', 1);
		$this->db->select("id, leave_request_id, leave_length_days, employee_id, leave_type_id, leave_startdate, YEAR(leave_startdate) as year, SUM(leave_length_days) as scheduled");

		$query = $this->db->get('hr_leave');
		$rows = $query->result_array();
		return $rows;
	}

	public function getLeaveTypes($typeid = '', $id = '') {
		if ($typeid != '') {
			$this->db->where('leave_type_id', $typeid);
		}

		if ($id != '') {
			$this->db->where('id', $id);
		}
		$partner_id = $this->session->userdata['partner_id'];
		$this->db->where(array('status' => '1', 'partner_id' => $partner_id));
		$this->db->select("id, leave_type_id, leave_type_name, no_restrictions");

		$query = $this->db->get('hr_leave_type');
		$rows = $query->result_array();
		return $rows;
	}

	public function getDTLeavetypeCount($search_field, $columns, $requestData) {
		$offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("id, leave_type_id, leave_type_name, no_restrictions");
		$this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

		if ($search_field != '') {
			$this->db->where($search_field);
		}

		$partner_id = $this->session->userdata['partner_id'];
		$this->db->where(array('status' => '1', 'partner_id' => $partner_id));
		$query = $this->db->get('hr_leave_type');
		$rows = $query->num_rows();
		return $rows;
	}

	public function getDTLeavetypeDetails($num, $offset, $search_field, $columns, $requestData) {
		$offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("id, leave_type_id, leave_type_name, no_restrictions");
		$this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

		if ($search_field != '') {
			$this->db->where($search_field);
		}

		$partner_id = $this->session->userdata['partner_id'];
		$this->db->where(array('status' => '1', 'partner_id' => $partner_id));
		$this->db->limit($num, $offset);
		$query = $this->db->get('hr_leave_type');
		$rows = $query->result_array();
		return $rows;
	}

	public function getWorkingDays($id = '') {
		if ($id != '') {
			$this->db->where('id', $id);
		}
		$this->db->where('status', 1);
		$this->db->select("id, workingday_name, date, length");

		$query = $this->db->get('hr_working_days');
		$rows = $query->result_array();
		return $rows;
	}

	public function getDTWorkingCount($year, $columns, $requestData) {
		$offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("t1.id,t1.workingday_name,t1.date,t1.length");
		$this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

		$cond = '';
		if ($year != '') {
			$cond = "YEAR(t1.date) = '$year'";
		} else {
			$cond = '';
		}

		if ($cond != '') {
			$this->db->where($cond);
		}

		$this->db->where(array('t1.status' => '1'));
		$query = $this->db->get('hr_working_days t1');
		$rows = $query->num_rows();
		return $rows;
	}

	public function getDTWorkingdayDetails($num, $offset, $year, $columns, $requestData) {
		$offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("t1.id,t1.workingday_name,t1.date,t1.length");
		$this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

		$cond = '';
		if ($year != '') {
			$cond = "YEAR(t1.date) = '$year'";
		} else {
			$cond = '';
		}

		if ($cond != '') {
			$this->db->where($cond);
		}

		$this->db->where(array('t1.status' => '1'));
		$this->db->limit($num, $offset);
		$query = $this->db->get('hr_working_days t1');
		$rows = $query->result_array();
		return $rows;
	}

	public function getWeekDays($year = '') {
		if ($year != '') {
			$this->db->where('year', $year);
		}
		$this->db->select("id, year, monday, tuesday, wednesday, thursday, friday, saturday, sunday");

		$query = $this->db->get('hr_weekdays');
		$rows = $query->result_array();
		return $rows;
	}

	public function insertLeaveDetail($table, $data) {
		$last_inserted = $this->db->insert($table, $data);
		return $last_inserted;
	}

	public function updateLeaveDetail($table, $condition, $fields, $status = '') {
		$this->db->set($fields);
		if ($condition != '') {
			$this->db->where($condition);
		}
		if ($status != '' && $status == '3') {
			$this->db->where('status !=', $status);
		}
		$result = $this->db->update($table);
		return $result;
	}

	public function updateLeaveQuota($table, $condition, $fields, $status = '') {
		$this->db->set($fields);
		if ($condition != '') {
			$this->db->where($condition);
		}
		if ($status != '' && $status == '3') {
			$this->db->where('status !=', $status);
		}
		$result = $this->db->update($table);
		return $result;
	}

	public function getDTHolidayCount($year, $columns, $requestData) {
		$offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("t1.id,t1.holiday_id,t1.holiday_name,t1.date,t1.repeat_annually,t1.length");
		$this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

		$cond = '';
		if ($year != '') {
			$cond = "YEAR(t1.date) = '$year'";
		} else {
			$cond = '';
		}

		if ($cond != '') {
			$this->db->where($cond);
		}
		$partner_id = $this->session->userdata['partner_id'];
		$this->db->where(array('t1.status' => '1', 't1.partner_id' => $partner_id));
		$query = $this->db->get('hr_holidays t1');
		$rows = $query->num_rows();
		return $rows;
	}

	public function getDTHolidayDetails($num, $offset, $year, $columns, $requestData) {
		$offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("t1.id,t1.holiday_id,t1.holiday_name,t1.date,t1.repeat_annually,t1.length");
		$this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

		$cond = '';
		if ($year != '') {
			$cond = "YEAR(t1.date) = '$year'";
		} else {
			$cond = '';
		}

		if ($cond != '') {
			$this->db->where($cond);
		}
		$partner_id = $this->session->userdata['partner_id'];
		$this->db->where(array('t1.status' => '1', 't1.partner_id' => $partner_id));
		$this->db->limit($num, $offset);
		$query = $this->db->get('hr_holidays t1');
		$rows = $query->result_array();
		return $rows;
	}

	public function getHolidayDetails($year = '', $holiday_id = '', $repeat = '') {
        // $offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("t1.id,t1.holiday_id,t1.holiday_name,t1.date,t1.repeat_annually,t1.length");

		$cond = '';
		if ($holiday_id != '') {
			$this->db->where("t1.id = $holiday_id");
		}
		if ($repeat != '') {
			$this->db->where("t1.repeat_annually = $repeat");
		}

		if ($year != '') {
			$this->db->where("YEAR(t1.date) = $year");
		}

		$partner_id = $this->session->userdata['partner_id'];
		$this->db->where(array('t1.status' => '1', 't1.partner_id' => $partner_id));
		$query = $this->db->get('hr_holidays t1');
		$rows = $query->result_array();
		return $rows;
	}

	public function checkLeavedates($dates, $empid) {
		if ($dates != '') {
			$this->db->where('leave_date', $dates);
		}
		if ($empid != '') {
			$this->db->where('employee_id', $empid);
		}
		$cond = "leave_status IN (0,1,2)";
		$this->db->where($cond);
		$this->db->select("id, leave_type_id, leave_date");
		$query = $this->db->get('hr_leave');
		$rows = $query->result_array();
		return $rows;
	}

	public function checkHolidays($dates = '', $repeat = '') {
		$partner_id = $this->session->userdata('partner_id');
		if ($dates != '') {
			$this->db->where('date', $dates);
		}
		if ($repeat != '') {
			$this->db->where('repeat_annually', $repeat);
		}
		$this->db->select("id, holiday_name, date, holiday_id, length");
		$this->db->where(array('partner_id' => $partner_id, 'status' => 1));
		$query = $this->db->get('hr_holidays');
		$rows = $query->result_array();
		return $rows;
	}

	public function checkWorkingdays($dates) {
		if ($dates != '') {
			$this->db->where('date', $dates);
		}
		$this->db->select("id, workingday_name, date, length");

		$this->db->where('status', 1);
		$query = $this->db->get('hr_working_days');
		$rows = $query->result_array();
		return $rows;
	}

	public function checkWeekends($day) {
		if ($day != '') {
			$this->db->where($day, 3);
		}
		$this->db->select("id, year");

		$query = $this->db->get('hr_weekdays');
		$rows = $query->result_array();
		return $rows;
	}

	public function getLeavelistByreqid($req_id = '', $empid = '', $year = '') {

		$partner_id = $this->session->userdata('partner_id');
		if ($req_id != '') {
			$this->db->where('t1.leave_request_id', $req_id);
		}

		if ($empid != '') {
			$this->db->where('t1.employee_id', $empid);
		}
		if ($year != '') {
			$this->db->where('YEAR(t1.leave_date)', $year);
		}

		if ($this->session->userdata('user_type') != 'superadmin') {
			$this->db->where(array('t2.partner_id' => $partner_id, 't3.partner_id' => $partner_id));
		}
		$this->db->select("t1.id,t1.leave_type_id, t1.leave_date, t1.leave_startdate, YEAR(t1.leave_startdate) as year, t1.leave_enddate, t1.leave_length_days, t1.leave_applied_date, t1.leave_approval_date, t1.leave_comments, t1.leave_status, t2.emp_first_name as emp_firstname, t2.emp_last_name as emp_lastname, t2.id as employee_id, t2.official_email as emp_work_email, t3.leave_type_name, t3.no_restrictions");
		$this->db->join('hr_user_profile t2', 't2.id =  t1.employee_id', 'left');
		$this->db->join('hr_leave_type t3', 't3.leave_type_id =  t1.leave_type_id', 'left');

		$query = $this->db->get('hr_leave t1');
		$rows = $query->result_array();
		return $rows;
	}

	public function getDTLeaveCount($filtercond = '', $columns = '', $requestData = '') {
		$offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("t4.id,t1.leave_type_id, t1.leave_startdate, t1.leave_enddate,t4.leave_length_days,t4.date_applied,t4.date_approval, t4.approved_by, t4.status as req_status, t1.leave_comments, t1.leave_status, t2.emp_first_name as emp_firstname, t2.emp_last_name as emp_lastname, t3.leave_type_name, t4.status,t5.partner_name");
		$this->db->join('hr_user_profile t2', 't2.id =  t4.employee_id', 'left');
		$this->db->join('hr_leave_type t3', 't3.leave_type_id =  t4.leave_type_id and t3.partner_id = t2.partner_id', 'left');
		$this->db->join('hr_leave t1', 't1.leave_request_id =  t4.id', 'left');
		$this->db->join('hr_partner_type t5', 't5.id =  t2.partner_id', 'left');
		$this->db->group_by('t1.leave_request_id');
		if ($columns != '' && $requestData != '') {
			$this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
		}


		if ($filtercond != '') {
			$this->db->where($filtercond);
		}

		$query = $this->db->get('hr_leave_request t4');		
		$rows = $query->num_rows();
		return $rows;
	}

	public function getDTLeaveDetails($num = '', $offset = '', $filtercond = '', $columns = '', $requestData = '') {
		$offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("t4.id,t1.leave_type_id, t1.leave_startdate, t1.leave_enddate,t4.leave_length_days,t4.date_applied,t4.date_approval, t4.approved_by, t4.status as req_status, t1.leave_comments, t1.leave_status, t2.id as employee_id, t2.emp_first_name as emp_firstname, t2.emp_last_name as emp_lastname, t3.leave_type_name,t5.partner_name");
		$this->db->join('hr_user_profile t2', 't2.id =  t4.employee_id', 'left');
		$this->db->join('hr_leave_type t3', 't3.leave_type_id =  t4.leave_type_id and t3.partner_id = t2.partner_id', 'left');
		$this->db->join('hr_leave t1', 't1.leave_request_id =  t4.id', 'left');
		$this->db->join('hr_partner_type t5', 't5.id =  t2.partner_id', 'left');
		$this->db->group_by('t1.leave_request_id');
		if ($columns != '' && $requestData != '') {
			$this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
		}


		if ($filtercond != '') {
			$this->db->where($filtercond);
		}

		if ($num != '' && $offset != '') {
			$this->db->limit($num, $offset);
		}
		$query = $this->db->get('hr_leave_request t4');
		
		$rows = $query->result_array();
		return $rows;
	}

	public function getDTLeavesummaryCount($filter_cond, $columns, $requestData) {
		$offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("t1.id,t1.leave_type_id, t1.no_of_days_allotted, t1.leave_taken,t1.leave_brought_forward,t1.leave_encashed,t1.comments,t2.leave_type_name, t2.no_restrictions, t3.emp_first_name as emp_firstname, t3.emp_last_name as emp_lastname");
		$this->db->join('hr_user_profile t3', 't3.id =  t1.employee_id', 'left');
		$this->db->join('hr_leave_type t2', 't2.leave_type_id =  t1.leave_type_id and t2.partner_id = t3.partner_id', 'left');		
		$this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

		$filter_cond = $filter_cond." and t3.status = '1'";
		if ($filter_cond != '') {
			$this->db->where($filter_cond);
		}

		$query = $this->db->get('hr_leave_quota t1');
		$rows = $query->num_rows();
		return $rows;
	}

	public function getDTLeavesummaryDetails($num = '', $offset = '', $filter_cond = '', $columns = '', $requestData = '') {
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
		$this->db->limit($num, $offset);
		$query = $this->db->get('hr_leave_quota t1');
		// if($this->session->userdata['emp_number'] == '275') {
		// 	debug_last_query();die;
		// }

		$rows = $query->result_array();
		return $rows;
	}

	public function deleteHolidayDetail($table, $condition) {
		$option = "id IN($condition)";
		$this->db->set('status', '2');
		if ($condition != '') {
			$this->db->where($option);
		}
		$result = $this->db->update($table);
		return $result;
	}

	public function getLeaveQuota($empid = '', $year = '', $leavetypeid = '', $partner_id = '') {
		if ($empid != '') {
			$this->db->where('t1.employee_id', $empid);
		}
		if ($partner_id != '') {
			$this->db->where('t2.partner_id', $partner_id);
		}
		if ($year != '') {
			$this->db->where('t1.year', $year);
		}
		if ($leavetypeid != '') {
			$this->db->where('t1.leave_type_id', $leavetypeid);
		}
		$this->db->where('t2.status', 1);
		$this->db->select("t1.id, t1.leave_type_id, t1.no_of_days_allotted, t1.leave_taken, t1.leave_brought_forward, t1.leave_encashed, t1.comments, t2.leave_type_name, t2.no_restrictions");
		$this->db->join('hr_leave_type t2', 't2.leave_type_id =  t1.leave_type_id', 'left');
		$query = $this->db->get('hr_leave_quota t1');
		$rows = $query->result_array();
		return $rows;
	}

	public function getUserType($id = '') {
		if ($id != '') {
			$this->db->where('id', $id);
		}
		$this->db->select("id, user_type");
		$this->db->where('status', 1);
		$query = $this->db->get('hr_user_type');
		$rows = $query->result_array();
		return $rows;
	}

	public function getUsers($id = '', $type = '') {
		$partner_id = $this->session->userdata('partner_id');
		if ($id != '') {
			$this->db->where('id', $id);
		}
		if ($type != '') {
			$this->db->where('emp_type', $type);
		}
		$this->db->select("id as employee_id, emp_first_name as emp_firstname, emp_last_name as emp_lastname");
		$this->db->where('status', 1);
		$this->db->where('partner_id', $partner_id);
		$query = $this->db->get('hr_user_profile');
		$rows = $query->result_array();
		return $rows;
	}

	public function getDTuserDetails($num = '', $offset = '', $filter_cond = '', $columns = '', $requestData = '') {
		$offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("id, emp_first_name as emp_firstname,emp_last_name as emp_lastname");
		if ($columns != '' && $requestData != '') {
			$this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
		} else {
			$this->db->order_by('id', 'asc');
		}

		if ($filter_cond != '') {
			$this->db->where($filter_cond);
		}
		if ($num != '') {
			$this->db->limit($num, $offset);
		}
		$query = $this->db->get('hr_user_profile');
		$rows = $query->result_array();
		return $rows;
	}

	public function getUserQuotaDetails($filter_cond = '', $emp_id = '') {
		$this->db->select("t1.id,t1.year,t1.leave_type_id, t1.no_of_days_allotted, t1.leave_taken,t1.leave_brought_forward,t1.leave_encashed,t1.comments,t1.employee_id,t2.leave_type_name, t2.no_restrictions");
		$this->db->join('hr_leave_type t2', 't2.leave_type_id =  t1.leave_type_id', 'left');
		$this->db->order_by('id', 'asc');

		if ($filter_cond != '') {
			$this->db->where($filter_cond);
		}
		if ($emp_id != '') {
			$this->db->where('t1.employee_id', $emp_id);
		}
		$partner_id = $this->session->userdata['partner_id'];
		if ($partner_id != '') {
			$this->db->where('t2.partner_id', $partner_id);
		}
		$query = $this->db->get('hr_leave_quota t1');
		$rows = $query->result_array();
		return $rows;
	}

	public function getLastQuotaID() {
		$this->db->select("id");
		$this->db->order_by('id', 'desc');
		$this->db->limit('1');
		$query = $this->db->get('hr_leave_quota');
		$rows = $query->result_array();
		return $rows[0]['id'];
	}

	public function getUserLeaveCount($id) {
		$this->db->select("SUM(leave_length_days) as tot_leave");
		$this->db->where('leave_request_id', $id);
		$query = $this->db->get('hr_leave');
		$rows = $query->result_array();
		return $rows;
	}

	public function getLeaveFYquota() {
		$this->db->where('year', '2021');
		$this->db->where('no_of_days_allotted >', '0');
		$this->db->select("t1.employee_id, t2.leave_type_name, t1.leave_taken, t1.leave_type_id");
		$this->db->join('hr_leave_type t2', 't2.leave_type_id =  t1.leave_type_id', 'left');
		$query = $this->db->get('hr_leave_quota t1');
		$rows = $query->result_array();
		return $rows;
	}

	public function getLeaveFYrequest($cond = '') {
		$status_cond = "status IN ('2','3')";
		$this->db->where($status_cond);
		$this->db->select("SUM(leave_length_days) as tot_leave");
		$this->db->where($cond);
		$this->db->where('date_applied >=', '2021-01-01');
		$this->db->where('date_applied <=', '2021-12-31');
		$query = $this->db->get('hr_leave_request');
		$rows = $query->result_array();
		return $rows;
	}

	public function getLeaveFYleave($cond = '') {
		$status_cond = "leave_status IN ('2','3')";
		$this->db->where($status_cond);
		$this->db->select("SUM(leave_length_days) as applied_leave");
		$this->db->where($cond);
		$this->db->where('leave_date >=', '2021-01-01');
		$this->db->where('leave_date <=', '2021-12-31');
		$query = $this->db->get('hr_leave');
		$rows = $query->result_array();
		return $rows;
	}

	public function getLeaveFYEmployee($empid = '') {
		if ($empid != '') {
			$this->db->where('t1.id', $empid);
		}
		$this->db->select("emp_first_name, emp_last_name, t2.user_type, t3.partner_name");
		$this->db->join('hr_user_type t2', 't2.id =  t1.emp_type', 'left');
		$this->db->join('hr_partner_type t3', 't3.id =  t1.partner_id', 'left');
		$query = $this->db->get('hr_user_profile t1');
		$rows = $query->result_array();
		return $rows;
	}

}
