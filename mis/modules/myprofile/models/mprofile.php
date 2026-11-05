<?php

class Mprofile extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

     public function getpersonalType($emp_id) {

    $query = "SELECT  *,ut.user_type FROM hr_user_profile AS up
              LEFT JOIN hr_user_type AS ut ON ut.id = up.emp_type
              where up.id = $emp_id";
    $result = $this->db->query($query);
    return $result->result_array();
    }

     public function updatePortfolioDetail($table, $data, $condition) {

       // print_r($condition);die;
        if ($condition != '') {
            $this->db->where('id',$condition);
        }
        $result = $this->db->update($table, $data);
        return $result;
    }

    public function updatePortfolioDetail1($table, $data, $condition) {

       // print_r($condition);die;
        if ($condition != '') {
            $this->db->where('id',$condition);
        }
        $result = $this->db->update_batch($table, $data);
        return $result;
    }

    public function last_employee_id() {

        $this->db->select('id');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('hr_user_profile');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDetails($table, $condition = '',$status=''){

        if ($condition != '') {
            $this->db->where('emp_id',$condition);
        }
        if ($status != '') {
            $this->db->where('status',$status);
        }
        $this->db->select('*');
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }
     public function getDetails1($table, $condition = ''){

        if ($condition != '') {
            $this->db->where('id',$condition);
        }
        $this->db->select('*');
        
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }
	
	
	public function get_document_details($table_name = '', $cond =''){
		
		if(!empty($cond)){
			$this->db->where_in('id', $cond);
		}
		$this->db->select("*");
        $query = $this->db->get($table_name);
        $rows = $query->result_array($rows);
        return $rows;
		
	}
	 
	
    public function insert_batch($table_name = '', $data = array(), $change_db = false, $db_name = '') {
           $db_var = $this->db;
         if (isset($change_db) && $change_db == true && $db_name != '') {
   
              $db_var = $this->current_db;
            }
                $db_var->insert_batch($table_name, $data);
        }


    public function getCommonDetails($table, $condition = '', $orderby = '', $column = '') {

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

    public function getDTEmployeeCount($search_field, $search_value, $current_user, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.emp_name,t1.emp_type,t3.job_title,t4.partner_name,t5.user_type");
        $this->db->join('hr_job_salary t2', 't2.emp_id =  t1.id', 'left');
        $this->db->join('hr_job_designation t3', 't3.id =  t2.designation', 'left');
        $this->db->join('hr_partner_type t4', 't4.id =  t1.partner_id', 'left');
        $this->db->join('hr_user_type t5', 't5.id =  t1.emp_type', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($search_field == '1' && $search_value != '') {
            $cond = "t1.id = '$search_value'";
        } else if ($search_field == '2' && $search_value != '') {
            $cond = "(t1.emp_name LIKE '%$search_value%')";
        } else if ($search_field == '3' && $search_value != '') {
            $cond = "t4.partner_name LIKE '%$search_value%'";
        } else if ($search_field == '4' && $search_value != '') {
            $cond = "t3.job_title LIKE '%$search_value%'";
        } else if ($search_field == '5' && $search_value != '') {
            $cond = '';
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        if ($this->session->userdata['user_type'] != 'superadmin') {
            $partner_id = $this->session->userdata['partner_id'];
            $this->db->where('t1.partner_id', $partner_id);
        }

        $this->db->where(array('t1.emp_type' => $current_user, 't1.status' => '1'));
        $query = $this->db->get('hr_user_profile t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTEmployeeDetails($num, $offset, $search_field, $search_value, $current_user, $columns, $requestData) {

        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.emp_name,t1.emp_type,t3.job_title,t4.partner_name,t5.user_type");
        $this->db->join('hr_job_salary t2', 't2.emp_id =  t1.id', 'left');
        $this->db->join('hr_job_designation t3', 't3.id =  t2.designation', 'left');
        $this->db->join('hr_partner_type t4', 't4.id =  t1.partner_id', 'left');
        $this->db->join('hr_user_type t5', 't5.id =  t1.emp_type', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($search_field == '1' && $search_value != '') {
            $cond = "t1.id = '$search_value'";
        } else if ($search_field == '2' && $search_value != '') {
            $cond = "(t1.emp_name LIKE '%$search_value%')";
        } else if ($search_field == '3' && $search_value != '') {
            $cond = "t4.partner_name LIKE '%$search_value%'";
        } else if ($search_field == '4' && $search_value != '') {
            $cond = "t3.job_title LIKE '%$search_value%'";
        } else if ($search_field == '5' && $search_value != '') {
            $cond = '';
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        if ($this->session->userdata['user_type'] != 'superadmin') {
            $partner_id = $this->session->userdata['partner_id'];
            $this->db->where('t1.partner_id', $partner_id);
        }

        $this->db->where(array('t1.emp_type' => $current_user, 't1.status' => '1'));
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_user_profile t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getReportingOfficer($emp_id) {
        $this->db->where(array('t1.report_supervisor' => $emp_id, 't1.report_method' => '1', 't1.status' => 1));
        $this->db->select("t1.report_supervisor, t2.emp_name");
        $this->db->join('hr_user_profile t2', 't2.id = t1.report_subordinate', 'left');
        $query = $this->db->get('hr_user_reporting t1');

        $rows = $query->result_array();
        return $rows;
    }

    public function deleteEmployeeDetail($table, $condition) {
        $option = "id IN($condition)";
        $this->db->set('status', '2');
        if ($condition != '') {
            $this->db->where($option);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function deleteCommonDetail($table, $condition) {
        $option = "id IN($condition)";
        $this->db->set('status', '2');
        if ($condition != '') {
            $this->db->where($option);
        }
        $result = $this->db->update($table);
        return $result;
    }

    public function deleteProfilePicture($table, $condition) {
        $this->db->set('emp_picture', '');
        $this->db->where($condition);
        $result = $this->db->update($table);
        return $result;
    }

    function getUserName($cond, $id) {
        $this->db->select("id");
        $this->db->where($cond);
        $this->db->where('emp_id <>', $id);
        $query = $this->db->get('hr_user_login');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTDesignationCount($employee_id, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.job_date,t2.job_title,t3.location_name,t4.job_department,t5.job_name");
        $this->db->join('hr_job_designation t2', 't2.id =  t1.designation', 'left');
        $this->db->join('hr_job_location t3', 't3.id =  t1.location', 'left');
        $this->db->join('hr_job_department t4', 't4.id =  t1.department', 'left');
        $this->db->join('hr_job_type t5', 't5.id =  t1.job_type', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($employee_id != '') {
            $cond = "t1.emp_id = $employee_id";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('t1.status', '1');
        $query = $this->db->get('hr_job_designation_revise t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTDesignationDetails($num, $offset, $employee_id, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.job_date,t2.job_title,t3.location_name,t4.job_department,t5.job_name");
        $this->db->join('hr_job_designation t2', 't2.id =  t1.designation', 'left');
        $this->db->join('hr_job_location t3', 't3.id =  t1.location', 'left');
        $this->db->join('hr_job_department t4', 't4.id =  t1.department', 'left');
        $this->db->join('hr_job_type t5', 't5.id =  t1.job_type', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($employee_id != '') {
            $cond = "t1.emp_id = $employee_id";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('t1.status', '1');
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_job_designation_revise t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTSalaryCount($employee_id, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.gross_salary,t1.salary_incentive,t1.salary_date,t1.contract_hours,t1.payment_hours,t2.salary_ctc");
        $this->db->join('hr_job_salary_ctc t2', 't2.id =  t1.ctc_salary', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($employee_id != '') {
            $cond = "t1.emp_id = $employee_id";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('t1.status', '1');
        $query = $this->db->get('hr_job_salary_revise t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTSalaryDetails($num, $offset, $employee_id, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.gross_salary,t1.salary_incentive,t1.salary_date,t1.contract_hours,t1.payment_hours,t2.salary_ctc");
        $this->db->join('hr_job_salary_ctc t2', 't2.id =  t1.ctc_salary', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($employee_id != '') {
            $cond = "t1.emp_id = $employee_id";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('t1.status', '1');
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_job_salary_revise t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTCommonCount($table, $employee_id, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($employee_id != '') {
            $cond = "emp_id = $employee_id";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('status', '1');
        $query = $this->db->get($table);
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTCommonDetails($table, $num, $offset, $employee_id, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($employee_id != '') {
            $cond = "emp_id = $employee_id";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('status', '1');
        $this->db->limit($num, $offset);
        $query = $this->db->get($table);
        $rows = $query->result_array();
        return $rows;
    }

    public function getQualificationList($type) {
        $cond = "type IN (0,$type) and status = 1";
        $this->db->select("id,qualification_name");
        $this->db->where($cond);
        $query = $this->db->get('hr_qualification_list');
        if ($query->num_rows() > 1) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getDTEducationCount($employee_id, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.qualification,t1.institute_name,t1.gpa_score,t1.year_numbers,t1.year_from,t1.year_to,t1.city,t1.state,t2.qualification_name");
        $this->db->join('hr_qualification_list t2', 't2.id =  t1.degree', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($employee_id != '') {
            $cond = "t1.emp_id = $employee_id";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('t1.status', '1');
        $query = $this->db->get('hr_user_education t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTEducationDetails($num, $offset, $employee_id, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.qualification,t1.institute_name,t1.gpa_score,t1.year_numbers,t1.year_from,t1.year_to,t1.city,t1.state,t2.qualification_name");
        $this->db->join('hr_qualification_list t2', 't2.id =  t1.degree', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($employee_id != '') {
            $cond = "t1.emp_id = $employee_id";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('t1.status', '1');
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_user_education t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTImmigrationCount($employee_id, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.*,t2.country_name");
        $this->db->join('hr_country t2', 't2.id =  t1.citizenship', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($employee_id != '') {
            $cond = "t1.emp_id = $employee_id";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('t1.status', '1');
        $query = $this->db->get('hr_user_immigration t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTImmigrationDetails($num, $offset, $employee_id, $columns, $requestData) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.*,t2.country_name");
        $this->db->join('hr_country t2', 't2.id =  t1.citizenship', 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($employee_id != '') {
            $cond = "t1.emp_id = $employee_id";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where('t1.status', '1');
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_user_immigration t1');
        $rows = $query->result_array();
        return $rows;
    }

    public function getDTReportingCount($employee_id, $columns, $requestData, $field, $get_field) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.report_supervisor,t1.report_subordinate,t1.report_method,t2.emp_name");
        $this->db->join("hr_user_profile t2", "t2.id =  t1.$get_field", 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($employee_id != '') {
            $cond = "t1.$field = $employee_id";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where(array('t1.status' => '1', 't2.status' => '1'));
        $query = $this->db->get('hr_user_reporting t1');
        $rows = $query->num_rows();
        return $rows;
    }

    public function getDTReportingDetails($num, $offset, $employee_id, $columns, $requestData, $field, $get_field) {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("t1.id,t1.report_supervisor,t1.report_subordinate,t1.report_method,t2.emp_name");
        $this->db->join("hr_user_profile t2", "t2.id =  t1.$get_field", 'left');
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $cond = '';
        if ($employee_id != '') {
            $cond = "t1.$field = $employee_id";
        }

        if ($cond != '') {
            $this->db->where($cond);
        }

        $this->db->where(array('t1.status' => '1', 't2.status' => '1'));
        $this->db->limit($num, $offset);
        $query = $this->db->get('hr_user_reporting t1');
        $rows = $query->result_array();
        return $rows;
    }

    function getReportingEmployee($id) {
        $cond = "emp_type IN(2,3)";
        $this->db->where($cond);
        $this->db->select("id,emp_name");
        $this->db->where(array("id <>" => "$id", 'status' => 1));
        $this->db->order_by('emp_name', 'asc');
        $query = $this->db->get("hr_user_profile");
        $rows = $query->result_array();
        return $rows;
    }

    function getReportingList($table, $id, $field, $column) {
        $this->db->select("t1.id,t1.report_supervisor,t1.report_subordinate,t1.report_method,t2.emp_name");
        $this->db->join("hr_user_profile t2", "t2.id =  t1.$field", 'left');
        $this->db->where(array("t1.$column" => "$id", 't1.status' => 1, 't2.status' => 1));
        $query = $this->db->get("$table t1");
        $rows = $query->result_array();
        return $rows;
    }

    function getDependentList($table, $id) {
        $this->db->select("id,name,relationship,birth_date");
        $this->db->where(array('emp_id' => $id, 'status' => 1));
        $query = $this->db->get("$table");
        $rows = $query->result_array();
        return $rows;
    }

    function getBankList($table, $id) {
        $this->db->select("id,bank_name,account_number,branch_name,ifsc_code");
        $this->db->where(array('emp_id' => $id, 'status' => 1));
        $query = $this->db->get("$table");
        $rows = $query->result_array();
        return $rows;
    }

    function getEducationDetails($table, $edu_id) {
        $this->db->select("t1.id,t1.emp_id,t1.qualification,t1.degree,t1.institute_name,t1.gpa_score,t1.year_numbers,t1.year_from,t1.year_to,t1.city,t1.state,t2.qualification_name");
        $this->db->join('hr_qualification_list t2', 't2.id =  t1.degree', 'left');
        $this->db->where(array('t1.id' => $edu_id, 't1.status' => 1));
        $query = $this->db->get("$table t1");
        $rows = $query->result_array();
        return $rows;
    }

    function getPitchSectorLists() {
        $this->db->select("id,sector");
        $this->db->where(array('pitch' => '1', 'parent_id' => '0', 'status' => 1));
        $query = $this->db->get('sector_category');
        $rows = $query->result_array();
        return $rows;
    }

     function insert_data($table, $value) {
        $this->db->insert($table, $value);
        return true;
    }

     function update_data($table, $data, $id, $version = '', $doc = '') {
        $this->db->set($data);
        $this->db->where($id);
        if ($version != '') {
            $this->db->where('version', $version);
        }
        if ($doc != '') {
            $this->db->where('doc_type', $doc);
        }
        $this->db->update($table);
        return true;
    }

    public function get_all_details($table_name = '', $condition = array(), $fields = array(), $limit = '', $start = '', $order_by = '', $change_db = false, $db_name = '', $join = '', $groupby = '', $sum = '', $like = array()) {


        $db_var = $this->db;
        if (isset($change_db) && $change_db == true && $db_name != '') {
            $this->current_db = $this->load->database($db_name, true);
            $db_var = $this->current_db;
        }

        if (!empty($join)) {
            for ($i = 0; $i < php72_count($join); $i++) {
                $db_var->select($join[$i]['select']);
                $db_var->join($join[$i]['table'], $join [$i]['condition'], $join [$i] ['type']);
            }
        }

        if ($sum != '') {
            $this->db->select_sum($sum);
        }

        $db_var->select($fields);
        if (!empty($condition)) {
            $db_var->where($condition);
        }

//        if ($table_name != 'hr_user_reporting') {
        if ($groupby) {
            $db_var->group_by($groupby);
        }
//        }

        if (!empty($order_by)) {
            $db_var->order_by(php72_array_keys($order_by)[0], php72_array_values($order_by)[0]);
        }

        if ($limit != '') {
            $db_var->limit($limit, $start);
        }
        if (!empty($like)) {
            $db_var->like($like);
        }
        if ($table_name != '') {
            $query = $db_var->get($table_name);
        }

        return $rows = $query->result();
    }

     public function get_all_details_win($table_name = '', $condition = array(), $fields = array(), $limit = '', $start = '', $order_by = '', $change_db = false, $db_name = '') {
        $db_var = $this->db;
        if (isset($change_db) && $change_db == true && $db_name != '') {
            $this->current_db = $this->load->database($db_name, true);
            $db_var = $this->current_db;
        }
        $db_var->select($fields);
        if (!empty($condition)) {
            foreach ($condition as $key => $val) {
                $db_var->where_in($val);
            }
        }
        if (!empty($order_by)) {
            $db_var->order_by(php72_array_keys($order_by)[0], php72_array_values($order_by)[0]);
        }

        if ($limit != '') {
            $db_var->limit($limit, $start);
        }

        if ($table_name != '') {
            $query = $db_var->get($table_name);
        }
        return $rows = $query->result();
    }
    public function delete_data_in($table_name = '', $condition = array(), $change_db = false, $db_name = '') {
        $db_var = $this->db;
        if (isset($change_db) && $change_db == true && $db_name != '') {
            $this->current_db = $this->load->database($db_name, true);
            $db_var = $this->current_db;
        }
        if (!empty($condition)) {
            foreach ($condition as $key => $val) {
                $db_var->where_in($key, $val);
            }
        }
        $db_var->delete($table_name);
    }


}
