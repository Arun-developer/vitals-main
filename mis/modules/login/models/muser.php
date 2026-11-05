<?php

class Muser extends CI_Model {

    public function __construct() {

        parent::__construct();

        $this->hris = $this->load->database('hris', true);
    }

//    public function loginUser($username, $password) {
//        $data = array();
//
//        $this->db->where('user_name', $username);
//        $this->db->where('user_password', md5($password));
//        $this->db->where('status', 'Enabled');
//
//        $this->db->join('hr_employee', 'hr_employee.emp_number=hr_users.emp_number', 'left');
//
//        $query = $this->db->get('hr_users');
//        if ($query->num_rows() > 0) {
//
//            foreach ($query->result_array() as $row) {
//
//                $data[] = $row;
//            }
//        }
//
//        $query->free_result();
//
//        return $data;
//    }

    public function loginUser($username, $password) {
        $data = array();
        $this->db->where(array('user_name' => $username, 'password' => md5($password), 't1.status' => '1', 't2.status' => '1'));
        $this->db->join('hr_user_profile t2', 't2.id=t1.emp_id', 'left');
        $query = $this->db->get('hr_user_login t1');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function get_aisPrivilege($partner_id) {
        $this->db->select('*');
        $this->db->where('id', $partner_id);
        $query = $this->db->get('hr_partner_type');
        return $query->result_array();
    }

    public function create_emp_log($table, $data) {
        $last_inserted = $this->db->insert($table, $data);
        return $last_inserted;
    }

    function getReportingUser($employeeId, $option) {
        $data = array();
        if ($option == 'subUser') {
            $lable1 = 'report_subordinate';
            $lable2 = 'report_supervisor';
        } elseif ($option == 'supUser') {
            $lable1 = 'report_supervisor';
            $lable2 = 'report_subordinate';
        }
        $this->db->where($lable1, $employeeId);
        $this->db->select($lable2 . ",CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,hr_user_profile.id,emp_name,official_email,personal_email", false);
//        $this->db->join("hr_user_login", 'hr_user_login.emp_id=hr_user_reporting.' . $lable2);
        $this->db->join("hr_user_profile", 'hr_user_profile.id=hr_user_reporting.' . $lable2);
        $query = $this->db->get('hr_user_reporting');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getUsersListNotAbi($emp_id = null) {

        $data = array();
        if ($emp_id != null) {
            if (is_array($emp_id)) {
                $this->hris->where_not_in('emp_number', $emp_id);
            } else {
                $this->hris->where('emp_number !=', $emp_id);
            }
        }

        $this->hris->where('emp_type', 'employee');
        $this->hris->select("emp_number,CONCAT_WS(' ',emp_firstname,emp_lastname) as emp_name,emp_work_email,emp_oth_email", false);
        $this->hris->order_by("emp_firstname", "asc");
        $query = $this->hris->get('hr_employee');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function getUsersList_old($emp_id = null, $branch = '') {

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

    public function getUsersList($emp_id = null, $branch = '') {
        $data = array();
        if ($emp_id != null) {
            if (is_array($emp_id)) {
                $this->db->where_in('id', $emp_id);
            } else {
                $this->db->where('id', $emp_id);
            }
        }
        if ($branch != '') {
            $this->db->where('partner_id', $branch);
        }

        $this->db->select("id as emp_number, emp_name,official_email");
        $this->db->group_by("id");
        $this->db->order_by("emp_first_name", "asc");
        $query = $this->db->get('hr_user_profile');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function geticstatus($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $data = $this->db->get('innovation_pool');
        return $data->result_array();
    }

    public function getActiveEmployees() {

        $this->hris->select("hr_users.id as user_id,hr_employee.emp_number,CONCAT_WS(' ',emp_firstname,emp_lastname) as emp_name,emp_work_email,emp_oth_email", false);
        $this->hris->join('hr_users', 'hr_employee.emp_number=hr_users.emp_number');
        $this->hris->where('hr_users.status', 'Enabled');
        $this->hris->order_by("emp_firstname", "asc");
        $query = $this->hris->get('hr_employee ');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;
            }
        }

        $query->free_result();

        return $data;
    }

    public function getUsersList_sa($branch) {

        $data = array();
        if (!empty($branch) || ($branch != '')) {
            $this->hris->where('hr_users.partner_id', $branch);
        }
        $this->hris->where('hr_users.status', 'Enabled');
        $this->hris->select("hr_employee.emp_number,CONCAT_WS(' ',emp_firstname,emp_lastname) as emp_name,emp_work_email,emp_oth_email,hr_users.id", false);
        $this->hris->join('hr_users', 'hr_employee.emp_number=hr_users.emp_number');
        $this->hris->group_by("hr_users.emp_number", "asc");
        $query = $this->hris->get('hr_employee');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getLogindate($id) {
        $data = array();
        $this->hris->select('hr_users.login_date');
        $this->hris->where('id', $id);
        $query = $this->hris->get('hr_users');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = $row;
            }
        }
        return $data;
    }

    public function user_login_update($date, $id) {

        $this->hris->set('login_date', $date);
        $this->hris->where('id', $id);
        $this->hris->update('hr_users');

        return true;
    }

    public function getPartneremail($id) {
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
