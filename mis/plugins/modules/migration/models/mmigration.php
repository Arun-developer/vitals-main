<?php

class Mmigration extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ais = $this->load->database('ais', TRUE);
        $this->hris = $this->load->database('hris', TRUE);
    }

    public function get_table_details($table_name, $field_name) {
        $data = array();
        $this->ais->select($field_name);
        $query = $this->ais->get($table_name);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function get_hris_emp_details($usr_id) {
        $this->hris->select('emp_number');
        $this->hris->where('id', $usr_id);
        $query = $this->hris->get('hs_hr_users');
        return $query->result_array();
    }

    public function insert_table_details($table_name, $data) {
        $last_inserted = $this->db->insert($table_name, $data);
        return $last_inserted;
    }

    public function update_table_details($table_name, $field_name, $update_value, $exist_value) {
        $this->ais->set($field_name, $update_value);
        $this->ais->where($field_name, $exist_value);
        $this->ais->update($table_name);
        return true;
    }

    public function update_mis_table_details($table, $data, $condition) {
        if ($condition != '') {
            $this->db->where($condition);
        }
        $result = $this->db->update($table, $data);
        return $result;
    }

    public function get_hris_table_details($table_name, $column_name = '') {
        if ($column_name != '')
            $this->hris->order_by($column_name, 'ASC');
        $query = $this->hris->get($table_name);
        return $query->result_array();
    }

    public function get_country_details($country) {
        $data = array();
        $this->db->select('id');
        $this->db->where('country_code', $country);
        $query = $this->db->get('hr_country');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function get_empType_details($emp_type) {
        $data = array();
        $this->db->select('id');
        $this->db->where('user_slug', $emp_type);
        $query = $this->db->get('hr_user_type');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function get_nationality_details($nation) {
        $data = array();
        $this->db->select('id');
        $this->db->where('code', $nation);
        $query = $this->db->get('hr_nationality');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function get_checkLogin_details($emp_id) {
        $data = array();
        $this->db->select('status');
        $this->db->where('emp_id', $emp_id);
        $query = $this->db->get('hr_user_login');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function get_education_details($degree) {
        $data = array();
        $this->db->select('id');
        $this->db->where('qualification_name', $degree);
        $query = $this->db->get('hr_qualification_list');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function get_leaveReq_details($req_id, $emp_id) {
        $data = array();
        $this->hris->select('date_applied, approval_date');
        $this->hris->where(array('leave_request_id' => $req_id, 'employee_id' => $emp_id));
        $query = $this->hris->get('hs_hr_leave_requests');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function get_employee_details($emp_id) {
        $data = array();
        $this->db->select('partner_id');
        $this->db->where('id', $emp_id);
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
