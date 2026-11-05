<?php

class Sector_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getSectors() {
        $this->db->select('*');
        $this->db->from('sector_category');
        if ($this->session->userdata('user_type') != 'superadmin') {
            $partner_id = $this->session->userdata('partner_id');
            if ($partner_id == '10') {
                $pitch_id = '3';
            } else {
                $pitch_id = '1';
            }
            $this->db->where('pitch', $pitch_id);
        }
        $this->db->where('parent_id', 0);
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }


public function getSectorDetails($sectorIds =array()) {#echo'<pre>';print_r($sectorIds);die;
		 $data = array();
	    $this->db->select('*');
		$this->db->where_in('id', $sectorIds);
		$getdata =$this->db->get('sector_category');
		$data = $getdata->result_array();
        return $data; 
	
	}

    public function getUsersList1($emp_id = null, $branch = '') {

        $data = array();

        if ($emp_id != null) {

            if (is_array($emp_id)) {
                $this->db->where_in('hr_user_profile.id', $emp_id);
            } else {
                $this->db->where('hr_user_profile.id', $emp_id);
            }
        }
        if ($branch != '') {
            $this->db->where('hr_user_login.partner_id', $branch);
        }
		 $this->db->where('hr_user_login.status', '1');
        $this->db->select("hr_user_profile.id,CONCAT_WS(' ',emp_first_name,emp_last_name) as emp_name,official_email,personal_email", false);
        $this->db->join('hr_user_login', 'hr_user_profile.id=hr_user_login.emp_id');
        $this->db->group_by("hr_user_profile.id");
        $this->db->order_by("hr_user_profile.emp_first_name", "asc");
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
	
	public function addanRequester($data, $table = '') {
		
        $sqldel = "DELETE FROM $table WHERE sector_id = '" . $data['sector_id'] . "' AND partner_id = '" . $data['partner_id'] . "'";
        $querydel = $this->db->query($sqldel);

        $count = php72_count($data['employee_number']);
        $date = date('Y-m-d');
        for ($i = 0; $i < $count; $i++) {
            $sql = "INSERT INTO $table (employee_id,created_at,sector_id,partner_id,status) VALUES ('" . $data['employee_number'][$i] . "', '" . $date . "', '" . $data['sector_id'] . "','" . $data['partner_id'] . "', 1)";
            $query = $this->db->query($sql);
            $insert_id = $this->db->insert_id();
        }

        return $insert_id;
	}
	

    public function getIncSectors($program = '') {
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }

        if ($program == 'incubation') {
            $this->db->where('incubation', '1');
        } else {
            $this->db->where('pitch', $pitch_id);
        }

        $this->db->select('*');
        $this->db->from('sector_category');
        $this->db->where('parent_id', '0');
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }
	
	  public function getIncSectorsAddDeal($program = '') {
		
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }

        if ($program == 'incubation') {
            $this->db->where('incubation', '1');
			
        } else {
            $this->db->where('pitch', $pitch_id);
        }

        $this->db->select('*');
        $this->db->from('sector_category');
        $this->db->where('parent_id', '0');
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }
	
	//195

    public function getPitchSectors() {
        $partner_id = $this->session->userdata('partner_id');
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }
        $this->db->select('*');
        $this->db->from('sector_category');
        $this->db->where('parent_id', '0');
        $this->db->where('pitch', $pitch_id);
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }

    public function addSectorIncharge($data, $table = '') {
        if ($table != '') {
            $table_name = $table;
            $field1 = 'employee_id';
        } else {
            $table_name = 'assigned_incharge';
            $field1 = 'associate_employee';
        }
        $sqldel = "DELETE FROM $table_name WHERE sector_id = '" . $data['sector_id'] . "' AND partner_id = '" . $data['partner_id'] . "'";
        $querydel = $this->db->query($sqldel);

        $count = php72_count($data['employee_number']);
        $date = date('Y-m-d');
        for ($i = 0; $i < $count; $i++) {
            $sql = "INSERT INTO $table_name ($field1,created_date,sector_id,partner_id,status) VALUES ('" . $data['employee_number'][$i] . "', '" . $date . "', '" . $data['sector_id'] . "','" . $data['partner_id'] . "', 1)";
            $query = $this->db->query($sql);
            $insert_id = $this->db->insert_id();
        }

        return $insert_id;
    }

    public function getEmployeeSector() {
        $sql = "SELECT * FROM assigned_incharge WHERE sector_id != '0' AND status = '1'";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function getEmployeePartner($branch_id, $table = '') {
        if ($table != '') {
            $table_name = $table;
        } else {
            $table_name = 'assigned_incharge';
        }
        if ($this->session->userdata('user_type') != 'superadmin') {
            if ($branch_id != '') {
                $partnerid = "AND partner_id = '" . $branch_id . "'";
            } else {
                $partnerid = '';
            }
        } else {
            $partnerid = '';
        }
        $sql = "SELECT * FROM $table_name WHERE sector_id != '0' AND status = '1' $partnerid";
        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;
    }

    public function getEmployeeNameByID($id) {
        $this->db->select("emp_name, id as emp_number");
        $this->db->where('id', $id);
        $query = $this->db->get('hr_user_profile');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function getEmployeeMailByID($id) {
        $this->db->select("official_email as emp_work_email");
        $this->db->where('id =', $id);
        $query = $this->db->get('hr_user_profile');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function getEmployeeNumberByID($sector_id, $partner_id) {
        $this->db->select('associate_employee');
        $this->db->from('assigned_incharge');
        $this->db->where('sector_id', $sector_id);
        if ($partner_id != '') {
            $this->db->where('partner_id', $partner_id);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getSectorNameByID($sector_id) {
        $this->db->select('sector');
        $this->db->from('sector_category');
        $where = "(id = '$sector_id')";
        $this->db->where($where);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $output = $query->result_array();
            $result = $output[0]['sector'];
            return $result;
        }
        return false;
    }

    public function getSectorCategory($sector_id) {
        $this->db->select('sector');
        $this->db->from('sector_category');
        $where = "(id = '$sector_id')";
        $this->db->where($where);
        $ret = $this->db->get();
        $query = $ret->row();
        $output = array();

        if (php72_count($query) > 0) {
            $output[] = $query->sector;
            return $output;
        }
        return false;
    }

    public function getDonorNameByID($id) {
        $this->db->select('name');
        $this->db->from('donor_fit_master');
        $where = "(id = '$id')";
        $this->db->where($where);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $output = $query->result_array();
            $result = $output[0]['name'];
            return $result;
        }
        return false;
    }

    public function getEmpId($id) {
        $this->db->select('associate_employee');
        $this->db->where('innovation', $id);
        $this->db->where('status', '1');
        $data = $this->db->get('assign_associate');
        return $data->result_array();
    }

}
