<?php

class Vendor_model extends CI_Model {

   
    public function __construct() {
        parent::__construct();
    }

	
     public function getDTVendorCount($search_field, $search_value, $current_user, $columns, $requestData,$condition ='') {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("*");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
		
        $cond = '';
        if ($search_value != '') { 
            $cond = "v1.name LIKE '%$search_value%'  AND v1.status !=4 ".$condition."";
        } else{
           $cond .= "v1.status !=4 ".$condition."";
        }
		
        if ($cond != '') {
            $this->db->where($cond);
        }
        $query = $this->db->get('vendor v1');
		$this->db->limit($num, $offset);
	
        $rows = $query->num_rows();
        return $rows;
    }
	
	public function getDTVendorDetails($num, $offset, $search_field, $search_value, $current_user, $columns, $requestData,$condition ='') {

        $offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("v1.id,v1.created_user_id,v1.name,v1.address,v1.pan,v1.gst_number,v1.msme_registered,v1.status");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
		
		$cond = '';
        if ($search_value != '') { 
            $cond = "v1.name LIKE '%$search_value%'   AND v1.status !=4 ".$condition."";
        } else{
           $cond .= "v1.status !=4 ".$condition."";
        }
		
        if ($cond != '') {
            $this->db->where($cond);
        }
		$this->db->limit($num, $offset);
        $query = $this->db->get('vendor v1');
		
		//debug_last_query();die;
        $rows = $query->result_array();
        return $rows;
    }
	
	public function getExportVendorDetails($search_value='') {
		$this->db->select("v1.id,v1.created_user_id,v1.name,v1.address,v1.pan,v1.gst_number,v1.msme_registered,v1.status,v1.msme_status,v1.gst_status,v1.vendor_person_name,v1.vendor_number,v1.vendor_email,v1.created_date");
        if ($cond != '') {
            $this->db->where($cond);
        }
        $query = $this->db->get('vendor v1');
        $rows = $query->result_array();
        return $rows;
    }
	
	
	public function deleteVendorDetail($table, $condition) {
        $option = "id IN($condition)";
        $this->db->set('status', '4');
        if ($condition != '') {
            $this->db->where($option);
        }
        $result = $this->db->update($table);
        return $result;
    }
	public function deleteVendorBankDetail($table, $condition) {
        $option = "vendor_id IN($condition)";
        $this->db->set('status', '4');
        if ($condition != '') {
            $this->db->where($option);
        }
        $result = $this->db->update($table);
        return $result;
    }
	
	public function getFinanceUsersList($branch,$financeUserId=array()) {
        $data = array();
        if (!empty($branch) || ($branch != '')) {
            $this->db->where('hr_user_login.partner_id', $branch);
        }
		if (!empty($financeUserId)) {
            $this->db->where_in('hr_user_profile.id', $financeUserId);
        }
		
        $this->db->where('hr_user_login.status', '1');
        $this->db->select("hr_user_profile.id,CONCAT_WS(' ',emp_first_name,emp_last_name) as emp_name,personal_email,hr_user_login.emp_id", false);
        $this->db->join('hr_user_login', 'hr_user_profile.id=hr_user_login.emp_id');
        $this->db->group_by("hr_user_login.emp_id");
        $this->db->order_by("hr_user_profile.emp_first_name", "ASC");
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
	
	
	 function update_data($table, $id, $data) { 
        $this->db->set($data);
        $this->db->where($id);
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
            for ($i = 0; $i < count($join); $i++) {
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
            $db_var->order_by(array_keys($order_by)[0], array_values($order_by)[0]);
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
	
	public function insert_data($table ='',$options = array())
    {
        $result = $this->db->insert($table, $options);
        return $result;
    }

	

}
