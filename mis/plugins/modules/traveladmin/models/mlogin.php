<?php

class Mlogin extends My_Model {

    /* function Mlogin() {
        parent::Model();
        $this->hris = $this->load->database('hris', TRUE);
    } */
	public function __construct(){
        parent::__construct();
		$this->ais = $this->load->database('ais', TRUE);
		$this->hris = $this->load->database('hris', TRUE);
    }

    function loginUser($username, $password) {
        $data = array();
        $where = "user_name = '" . $username . "' and user_password = '" . md5($password) . "'";
        $query = $this->hris->get_where('hr_users', $where);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function get_aisPrivilege($partner_id) {
        $this->hris->select('*');
        $this->hris->where('id', $partner_id);
        $query = $this->hris->get('hs_hr_branch');
        return $query->result_array();
    }

    function floginUser($username, $password) {
        $data = array();
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('finance_user');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function adminDetails() {
        $data = array();
        $this->hris->where('is_admin', 'Yes');
        $query = $this->hris->get('hr_users');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getuserid($empname) {
        $data = array();
        $this->hris->select('id');
        $this->hris->where('user_name', $empname);
        $result = $this->hris->get('hr_users');
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    function employeeDetails($employeeId) {
        $data = array();
        $this->db->where('id', $employeeId);
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getEmployeeFromUserId($userId) {
        $data = $this->getUserInfo($userId);
		if (count($data)) {
            return $this->employeeDetails($data['0']['emp_id']);
        } else
            return true;
    }

    function getEmployeenameFromUserId($userid) {
        $data = array();
        $data = $this->getUserNameInfo($userid);

        if (count($data))
            return $data['0']['user_name'];
        else
            return true;
    }

    function getUserNameInfo($userid) {

        $data = array();
        $this->hris->select("hr_users.emp_number,CONCAT_WS(' ',emp_firstname,emp_lastname) as user_name,emp_work_email,emp_oth_email", false);
        $this->hris->where('id', $userid);
        $this->hris->join('hr_employee', 'hr_employee.emp_number = hr_users.emp_number');
        $query = $this->hris->get('hr_users');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function getleaveCount($where = NULL, $admin = NULL, $report = NULL) {

        $data = array();
        $whereArray = array();
        if ($where != NULL)
            $whereArray[] = $where;
        $whereCond = implode(' and ', $whereArray);
        $this->hris->select("hs_hr_leavetype.leave_type_name,hs_hr_leave.*,COUNT(`hs_hr_leave`.leave_type_id) AS totalleave", false);
        $this->hris->join('hs_hr_leavetype', 'hs_hr_leavetype.leave_type_id = hs_hr_leave.leave_type_id	', 'left');
        $this->hris->where($whereCond);
        $this->hris->group_by('hs_hr_leave.leave_type_id');
        $query = $this->hris->get('hs_hr_leave');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getRecruitmentDashboard($section, $stage, $statusstage) {
        $searchArray = array();
        $where = array();
        $status = 'hs_hr_job_application.status';
        $admin = NULL;
        $empid = $this->session->userdata('empNumber');
        switch ($section) {
            case 'mylist':
                $admin = NULL;
                $searchArray[] = "emp_number  IN ('" . $empid . "')";
                break;
            case 'admin':
                $admin = 'Show all';
                break;
        }
        switch ($stage) {
            case 'pending':
                $searchArray[] = $status . " = $statusstage";
                break;
        }
        $where = implode(" and ", $searchArray);
        #Pagination Scripts Starts
        $total = $this->getRecruitmentCount($where, $admin);
        return $total;
    }

    function getRecruitmentCount($where = NULL, $admin = NULL, $report = NULL) {
        $data = array();
        $whereArray = array();
        if ($where != NULL)
            $whereArray[] = $where;
        $whereCond = implode(' and ', $whereArray);
        $this->hris->select("COUNT(`hs_hr_job_application`.application_id ) AS totalapply", false);
        $this->hris->where($whereCond);
        $query = $this->hris->get('hs_hr_job_application');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getLeaveDashboard($section, $currentTab) {
        $searchArray = array();
        $where = array();
        $status = 'hs_hr_leave.leave_status';
        $admin = NULL;
        switch ($section) {
            case 'mylist':
                $admin = NULL;
                $empid = $this->session->userdata('empNumber');
                $searchArray[] = "hs_hr_leave.employee_id  IN ('" . $empid . "')";
                break;
            case 'rolist':
                $subUsers = implode("','", reportingUser('subUser', 'empid'));
                $searchArray[] = "hs_hr_leave.employee_id  IN ('" . $subUsers . "')";
                $admin = 'Show all';
                break;
            case 'admin':
                $admin = 'Show all';
                break;
        }
        switch ($currentTab) {
            case 'pending':
                $searchArray[] = $status . " = '1'";
                break;
        }

        $where = implode(" and ", $searchArray);

        #Pagination Scripts Starts
        $total = $this->getleaveCount($where, $admin);

        return $total;
    }

    function getUserInfo($userId) {
		
        $data = array();
        $this->db->select("hr_user_login.emp_id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,emp_gender", false);
        $this->db->where('hr_user_login.emp_id', $userId);
        $this->db->join('hr_user_profile', 'hr_user_profile.id = hr_user_login.emp_id');
        $this->db->group_by('hr_user_login.user_name');
        $query = $this->db->get('hr_user_login');
		#echo'<pre>';print_r($query->result());die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getAllUserList($user_type=''){
        $data = array();
        $this->db->distinct('hr_user_profile.emp_first_name');
        $this->db->select("hr_user_login.id,CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,hr_user_profile.id", false);
        $this->db->where('hr_user_profile.partner_id', $this->session->userdata('partner_id'));
        $this->db->where_in('emp_type', array(3,2,7,10));
		$this->db->where_not_in('hr_user_profile.status', array(2));
        $this->db->join('hr_user_login', 'hr_user_login.emp_id = hr_user_profile.id');
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

    function getAllUserList_part() {
        $data = array();
        $this->hris->distinct('hr_employee.emp_firstname');
        $this->hris->select("hr_users.id,CONCAT_WS(' ',emp_firstname,emp_lastname) as user_name,hr_employee.emp_number", false);
        $this->hris->where_in('emp_type', array('employee', 'fellow', 'consultant', 'student'));
        $this->hris->where('hr_users.partner_id', 1);
        $this->hris->join('hr_users', 'hr_users.emp_number = hr_employee.emp_number');
        $this->hris->order_by('hr_employee.emp_firstname');
        $query = $this->hris->get('hr_employee');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    function getReportingUser($employeeId, $option) {
		
		$data = array();
        if ($option == 'subUser') {
            $lable1 = 'erep_sup_emp_number';
            $lable2 = 'erep_sub_emp_number';
        } elseif ($option == 'supUser') {
            $lable1 = 'erep_sub_emp_number';
            $lable2 = 'erep_sup_emp_number'; 
        }
		#echo $lable1;die;
        $this->db->where($lable1, $employeeId);
        $this->db->select($lable2 . ",CONCAT_WS(' ',emp_first_name,emp_last_name) as user_name,hr_user_profile.id as user_id,official_email,personal_email", false);
        //$this->db->join("hr_user_login", 'hr_user_login.emp_id=hr_emp_reportto.' . $lable2);
        $this->db->join("hr_user_profile", 'hr_user_profile.id=hr_emp_reportto.' . $lable2);
        $query = $this->db->get('hr_emp_reportto');
		#echo'<pre>';print_r($query->result());die;
		#echo debug_last_query();die;
		
		if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getrolist() {
        $lable2 = 'erep_sup_emp_number';
        $data = array();
        $this->hris->distinct();
        $this->hris->select("erep_sup_emp_number as sup_id,CONCAT_WS(' ',emp_firstname,emp_lastname) as user_name", false);

        $this->hris->join("hr_users", 'hr_users.emp_number=hr_emp_reportto.' . $lable2);
        $this->hris->join("hr_employee", 'hr_employee.emp_number=hr_emp_reportto.' . $lable2);
        $this->hris->where("hr_employee.emp_type !=", "alumni");
        $this->hris->where("hr_users.status =", "Enabled");
        $query = $this->hris->get('hr_emp_reportto');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function get_subordinates($sup_id) {
        $lable2 = 'erep_sub_emp_number';
        $data = array();
        $this->hris->distinct();
        $this->hris->select("erep_sub_emp_number,CONCAT_WS(' ',emp_firstname,emp_lastname) as user_name", false);

        $this->hris->join("hr_users", 'hr_users.emp_number=hr_emp_reportto.' . $lable2);
        $this->hris->join("hr_employee", 'hr_employee.emp_number=hr_emp_reportto.' . $lable2);
        $this->hris->where("hr_employee.emp_type !=", "alumni");
        $this->hris->where("hr_users.status", "Enabled");
        $this->hris->where("hr_emp_reportto.erep_sup_emp_number", $sup_id);
        $query = $this->hris->get('hr_emp_reportto');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getempidfromuserid($userid) {
        $this->hris->select('emp_number');
        $this->hris->where("id", $userid);
        $query = $this->hris->get('hr_users');
        return $query->result_array();
    }

    function supadminDetails() {
        $data = array();
        $this->hris->where('role_id', '3');
        $query = $this->hris->get('hr_users');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getPartneremail($id) {
        $data = array();
        $this->hris->select('hr_branch.branch_email,hr_branch.branch_name');
        $this->hris->where('id', $id);
        $query = $this->hris->get('hr_branch');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = $row;
            }
        }
        return $data;
    }

}

?>
