<?php

class Funder_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    function getdonorsfromprogram($program, $change_db, $db_name) {

        $db_var = $this->db;
        if (isset($change_db) && $change_db == true && $db_name != '') {
            $this->current_db = $this->load->database($db_name, true);
            $db_var = $this->current_db;
        }

        $data = '';
        $db_var->where('programme_id', $program);
        $db_var->select('donor');
        $query = $db_var->get('master_programme');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = unserialize($row['donor']);
            }
        }
        $data = ($data != '') ? php72_implode(',', $data) : '';
        return $data;
    }

    public function getAllUserList() {
        $data = array();
        $this->db->distinct('UP.emp_first_name');
        $this->db->select("UL.emp_id as id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,UP.id as emp_number", false);
        $this->db->where('UP.partner_id', $this->session->userdata('partner_id'));
        $this->db->where_in('UP.emp_type', array('2', '3', '7', '10'));
        $this->db->join('hr_user_login UL', 'UL.emp_id = UP.id');
        $this->db->order_by('UP.emp_first_name');
        $query = $this->db->get('hr_user_profile UP');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getMasterSetting($masterType = NULL, $id = NULL, $pid = NULL, $program = NULL, $change_db = false, $db_name = '') {

        $db_var = $this->db;
        if (isset($change_db) && $change_db == true && $db_name != '') {
            $this->current_db = $this->load->database($db_name, true);
            $db_var = $this->current_db;
        }
        $donor_id = explode(',', $this->getdonorsfromprogram($program, $change_db, $db_name));
        $partner_id = $this->session->userdata('partner_id');

        $data = array();
        $db_var->where('ms.status', '1');
        $db_var->where('ms.partner_id', $partner_id);
        if ($pid != NULL)
            $db_var->where_in('ms.pid', $pid);

        if ($masterType != NULL) {
            $db_var->select('ms.master_id,ms.master_name');
            if ($masterType == 'Budget Head') {
                $db_var->join('master_settings DMS', 'DMS.master_id=ms.pid', 'left');
            } else if ($masterType == 'Line Item') {
                $db_var->join('master_settings BMS', 'BMS.master_id=ms.pid', 'left');
                $db_var->join('master_settings DMS', 'DMS.master_id=BMS.pid', 'left');
            } else if ($masterType == 'Cost Centre') {
                $db_var->join('master_settings CMS', 'CMS.master_id=ms.pid', 'left');
                $db_var->join('master_settings BMS', 'BMS.master_id=CMS.pid', 'left');
                $db_var->join('master_settings DMS', 'DMS.master_id=BMS.pid', 'left');
            }
            if ($donor_id[0] != '' && $masterType != 'Donor') {
                $db_var->where_in('DMS.master_id', $donor_id);
            } else if ($donor_id[0] != '') {
                $db_var->where_in('ms.master_id', $donor_id);
            }
            $db_var->where('ms.master_type', $masterType);
        }
        if ($id != NULL) {
            $db_var->where('ms.master_id', $id);
            $db_var->select('ms.master_name');
        }
        $db_var->order_by('ms.master_name');
        $query = $db_var->get('master_settings ms');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        #echo'<pre>';print_r($data);die;
        return $data;
    }
	
	
	public function getDTBankDetails($num, $offset, $search_field, $search_value, $current_user, $columns, $requestData,$condition ='') {

        $offset = (!is_numeric($offset)) ? '0' : $offset;
		$this->db->select("*");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
		
		$cond = '';
        if ($search_value != '') { 
            $cond = "v1.bank_name LIKE '%$search_value%' AND v1.status !=4 ".$condition."";
        } else{
           $cond .= "v1.status !=4 ".$condition."";
        }
		
        if ($cond != '') {
            $this->db->where($cond);
        }
		$this->db->limit($num, $offset);
        $query = $this->db->get('debit_bank_details v1');
		
		//debug_last_query();die;
        $rows = $query->result_array();
        return $rows;
    }
	
	public function getDTBankCount($search_field, $search_value, $current_user, $columns, $requestData,$condition ='') {
        $offset = (!is_numeric($offset)) ? '0' : $offset;
        $this->db->select("*");
        $this->db->order_by($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
		
        $cond = '';
        if ($search_value != '') { 
            $cond = "v1.bank_name LIKE '%$search_value%'  AND v1.status !=4 ".$condition."";
        } else{
           $cond .= "v1.status !=4 ".$condition."";
        }
		
        if ($cond != '') {
            $this->db->where($cond);
        }
        $query = $this->db->get('debit_bank_details v1');
		$this->db->limit($num, $offset);
	
        $rows = $query->num_rows();
		
        return $rows;
    }
	
	 public function update_data($table, $id, $data) { 
        $this->db->set($data);
        $this->db->where($id);
        $this->db->update($table);
        return true;
    }
	public function insert_data($table ='',$options = array(),$change_db=false,$db_name='')
    {
		$db_var = $this->db;
        if (isset($change_db) && $change_db == true && $db_name != '') {
            $this->current_db = $this->load->database($db_name, true);
            $db_var = $this->current_db;
			$result = $db_var->insert($table, $options);
			 return $result;
        }else{
			$result = $db_var->insert($table, $options);
			 return $result;
		}
		#echo $this->db->last_query();
       
    }
	
	public function deleteBankDetail($table, $condition) {
        $option = "id IN($condition)";
        $this->db->set('status', '2');
        if ($condition != '') {
            $this->db->where($option);
        }
        $result = $this->db->update($table);
        return $result;
    }
	

}
