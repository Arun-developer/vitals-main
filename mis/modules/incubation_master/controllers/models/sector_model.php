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

    public function addSectorIncharge1($data, $table = '') { #echo'<pre>';print_r($data);die;
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

    public function getEmployeeNameByID_old($id) {
        #$this->hris = $this->load->database('hris', true);
        $this->db->select("CONCAT_WS(' ',emp_firstname,emp_lastname) as emp_name,emp_number", false);
        $this->db->where('emp_number =', $id);
        $query = $this->db->get('hr_employee');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function getEmployeeNameByID($id) {
        $this->db->select("CONCAT_WS(' ',emp_first_name,emp_last_name) as emp_name", false);
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

    public function getUsersList_olf($emp_id = null, $branch = '') {

        $data = array();

        if ($emp_id != null) {

            if (is_array($emp_id)) {
                $this->hris->where_in('hr_employee.emp_number', $emp_id);
            } else {
                $this->hris->where('hr_employee.emp_number', $emp_id);
            }
        }
        if ($branch != '') {
            $this->hris->where('hr_users.partner_id', $branch);
        }

        $this->hris->select("hr_employee.emp_number,CONCAT_WS(' ',emp_firstname,emp_lastname) as emp_name,emp_work_email,emp_oth_email", false);
        $this->hris->join('hr_users', 'hr_employee.emp_number=hr_users.emp_number');
        $this->hris->group_by("hr_employee.emp_number");
        $this->hris->order_by("hr_employee.emp_firstname", "asc");
        $query = $this->hris->get('hr_employee');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;
            }
        }

        $query->free_result();

        return $data;
    }

    public function getUsersList($emp_id = '', $branch = '') {

        $data = array();

        if ($emp_id != '') {

            if (is_array($emp_id)) {
                $this->db->where_in('hr_user_profile.id', $emp_id);
            } else {
                $this->db->where('hr_user_profile.id', $emp_id);
            }
        }
        if ($branch != '') {
            $this->db->where('hr_user_login.partner_id', $branch);
        }

        $this->db->select("hr_user_profile.id,CONCAT_WS(' ',emp_first_name,emp_last_name) as emp_name,official_email,personal_email", false);
        $this->db->join('hr_user_login', 'hr_user_profile.id=hr_user_login.emp_id');
        $this->db->group_by("hr_user_profile.id");
        $this->db->order_by("hr_user_profile.emp_first_name", "asc");
        $query = $this->db->get('hr_user_profile');
        //hr_user_profile hr_user_login
        #echo debug_last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
