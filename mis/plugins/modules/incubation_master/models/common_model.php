<?php

#
# Model Class -  hs_quad_master_settings
#

class Common_model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->ais = $this->load->database('ais', TRUE);
        $this->hris = $this->load->database('hris', true);
    }

    public function getAllFinancialYear($partner_id) {
        $this->ais = $this->load->database('ais', TRUE);
        $this->ais->select("fin.*, SUBSTRING_INDEX(SUBSTRING_INDEX(fin.from, ' ', 2), ' ', -1) AS fin_year", FALSE);
        $this->ais->where('fin.partner_id', $partner_id);
        $this->ais->order_by("fin_year", "desc");
        $query = $this->ais->get('financial_year fin');

        $rows = $query->result_array();
        return $rows;
    }

    public function getLimitRecords($options = array(), $conditions = array()) {
        $data = array();
        $whereQuery = $this->_search($options);

        $this->db->select("progress_master.*");
        $this->db->select("(select master_name from master_settings where id=progress_master.criteria) as criteria_title");

        $this->db->where('pid', '0');
        $this->db->where('type', 'metrices');
        #echo'<pre>';print_r($conditions);die;
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }
        /* $this->db->order_by('criteria', 'asc');
          $this->db->order_by('order', 'asc'); */

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('progress_master', $whereQuery);
        } else {
            $query = $this->db->get('progress_master');
        }
        #echo debug_last_query();die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['value'] = unserialize($row['value']);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function _search($options = array()) {
        $searchArray = array();
        $where = null;
        if (!empty($options['criteria'])) {
            $searchArray[] = "criteria = '" . $options['criteria'] . "'";
        }

        if (!empty($options['label'])) {
            $searchArray[] = "label = '" . $options['label'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }

    public function getmastertype() {
        $data = array();
        $this->db->select('master_type');
        $this->db->distinct('master_type');
        $this->db->where('iris_tab', 'standard');
        $query = $this->db->get('master_settings');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function getUserSetup_branch($branch) {
        $this->db->where('partner_id', $branch);
        $query = $this->db->get('user_setup');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['icm'] = @unserialize($row['icm']);
                $row['abi'] = @unserialize($row['abi']);
            }
        }

        $this->ais = $this->load->database('ais', true);
        $this->ais->where('partner_id', $branch);
        $query2 = $this->ais->get('approval_setting');
        if ($query2->num_rows() > 0) {
            $finance_id = array();
            foreach ($query2->result_array() as $row2) {
                $row2['finance'] = @unserialize($row2['finance']);
            }
        }
        $data[] = array_merge($row, $row2);
        return array_pop($data);
    }

    public function getYbranch($id) {
        $this->hris->select('branch_name');
        $this->hris->where('id', $id);
        $query = $this->hris->get('hs_hr_branch');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return '';
    }

    public function getProgressInfo($id) {
        $data = array();
        $this->db->select("progress_master.*");
        $this->db->select("(select master_name from master_settings where id=progress_master.criteria) as criteria_title");
        $this->db->where("id", $id);
        $query = $this->db->get('progress_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row["value"] = unserialize($row["value"]);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function get_source_master($options = array(), $conditions = array()) {
        $data = array();
        $whereQuery = $this->_search_source_master($options);


        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        $this->db->select("source_master.*,(select master_name from master_settings where id=source_master.source_type) as master_name, IF(alert = 1,'Yes','No') as alert_title", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = source_master.employee) as emp_name", false);

        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        if (!empty($whereQuery)) {
            $query = $this->db->get_where('source_master', $whereQuery);
        } else {
            $query = $this->db->get('source_master');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function _search_source_master($options = array()) {
        $searchArray = array();
        $where = null;
        if (!empty($options['source_name'])) {
            $searchArray[] = "source_name like '%" . $options['source_name'] . "%'";
        }

        if (!empty($options['employee'])) {
            $searchArray[] = "employee like '%" . $options['employee'] . "%'";
        }

        if (!empty($options['contact_person'])) {
            $searchArray[] = "contact_person like '%" . $options['contact_person'] . "%'";
        }

        if (!empty($options['source_type'])) {
            $searchArray[] = "source_type = '" . $options['source_type'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }

    public function getProgram_stage($options = array(), $conditions = array()) {

        $data = array();
        $whereQuery = $this->_search_program_stage($options);
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        $this->db->select("PS.*,PSO.title as program_service_title,MS.master_name as master_name");
        $this->db->join('program_service_offering PSO', 'PSO.id=PS.program_service_offering', 'left');
        $this->db->join('master_settings MS', 'MS.id = PSO.program_type', 'left');

        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        if (!empty($whereQuery)) {
            $query = $this->db->get_where('program_stage PS', $whereQuery);
        } else {
            $query = $this->db->get('program_stage PS');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function _search_program_stage($options = array()) {
        $searchArray = array();
        $where = null;
        if (!empty($options['message_type'])) {
            $searchArray[] = "messagetype like '%" . $options['message_type'] . "%'";
        }

        if (!empty($options['status'])) {
            $searchArray[] = "status = '" . $options['status'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }

    public function getProgramStageInfo($id) {
        $data = array();
        $this->db->where("PS.id", $id);
        $this->db->select("PS.*,PSO.program_type,PSO.title as program_service_title,MS.master_name as master_name");
        $this->db->join('program_service_offering PSO', 'PSO.id=PS.program_service_offering', 'left');
        $this->db->join('master_settings MS', 'MS.id = PSO.program_type', 'left');
        $query = $this->db->get('program_stage PS');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function get_screeningRecords($options = array(), $conditions = array()) {
        $data = array();
        $whereQuery = $this->_search_screening($options);
        $this->db->select("screening_master.*");
        $this->db->select("(select master_name from master_settings where id=screening_master.criteria) as criteria_title");

        $this->db->where('pid', '0');

        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        /*  $this->db->order_by('criteria', 'asc');
          $this->db->order_by('order', 'asc'); */
        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('screening_master', $whereQuery);
        } else {
            $query = $this->db->get('screening_master');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['value'] = unserialize($row['value']);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function _search_screening($options = array()) {

        $searchArray = array();
        $where = null;
        if (!empty($options['criteria'])) {
            $searchArray[] = "criteria = '" . $options['criteria'] . "'";
        }

        if (!empty($options['label'])) {
            $searchArray[] = "label = '" . $options['label'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }

    public function get_checklist($options = array(), $conditions = "") {
        #echo'<pre>';print_r($conditions);die;
        $data = array();
        $query = "SELECT CM.*,MS.master_name as master_name from checklist_master as CM JOIN master_settings as MS ON(MS.id = CM.area)";
        if ($conditions != "") {
            $query .= $conditions;
        }
        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $query .= "order by " . $options['orderby'] . " " . $options['ordertype'] . "";
        }
        if (isset($options['num']) && isset($options['offset'])) {
            $query .= " LIMIT " . $options['num'] . "," . $options['offset'] . "";
        }

        $result = $this->db->query($query);
        #echo debug_last_query();

        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getUsersList($emp_id = null, $branch = '') {
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

    public function getUsersList_sa($branch) {
        $data = array();
        if (!empty($branch) || ($branch != '')) {
            $this->db->where('hr_user_login.partner_id', $branch);
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

    public function getUserSetup($branch) {
        $this->db->where('partner_id', $branch);
        $query = $this->db->get('user_setup');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['icm'] = @unserialize($row['icm']);
                $row['abi'] = @unserialize($row['abi']);
                $row['donor_team'] = @unserialize($row['donor_team']);
                $row['ceo'] = $row['ceo'];
            }
        }

        $this->ais = $this->load->database('ais', true);
        $this->ais->where('partner_id', $branch);
        $query2 = $this->ais->get('approval_setting');
        if ($query2->num_rows() > 0) {
            $finance_id = array();
            foreach ($query2->result_array() as $row2) {
                $row2['finance'] = @unserialize($row2['finance']);
            }
        }
        $data[] = array_merge($row2, $row);
        return array_pop($data);
    }

    public function getEmpUserID($emp_id) {
        $user_id = '';
        $this->db->select('id');
        $this->db->where('emp_id', $emp_id);
        $query = $this->db->get('hr_user_login');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $user_id = $row['id'];
            }
        }
        return $user_id;
    }

    public function insertUserSetup($form) { #echo'<pre>';print_r($form);die;
        $this->ais = $this->load->database('ais', true);
        $branch = $form['branch'];
        $this->db->where('partner_id', $branch);
        $this->db->select('*');
        $query = $this->db->get('user_setup');

        #echo'<pre>';print_r($query->result());die;
        $donor_team = $this->input->post('donor_team');
        #echo'<pre>';print_r($donor_team);die;
        if ($query->num_rows() == 0) {
            $data = array(
                'partner_id' => $form['branch'],
                'ceo' => $form['ceo'],
                'cio' => $form['cio'],
                'icm' => serialize($form['icm']),
                'abi' => serialize($form['abi']),
                'pre_ic' => $form['pre_ic'],
            );
            $result = $this->db->insert('user_setup', $data);
            $user_id = $this->getEmpUserID($form['ceo']);
            $data1 = array(
                'ceo' => $user_id,
                'finance' => serialize($form['finance']),
                'partner_id' => $form['branch'],
            );
            $this->ais->insert('approval_setting', $data1);
        } else {
            $data = array(
                'ceo' => $form['ceo'],
                'cio' => $form['cio'],
                'icm' => serialize($form['icm']),
                'abi' => serialize($form['abi']),
                'pre_ic' => $form['pre_ic'],
                'donor_team' => serialize($donor_team),
            );
            $this->db->where('partner_id', $branch);
            $result = $this->db->update('user_setup', $data);
        }

        $this->ais->where('partner_id', $branch);
        $this->ais->select('*');
        $query = $this->ais->get('approval_setting');
        if ($query->num_rows() == 0) {
            $user_id = $this->getEmpUserID($form['ceo']);
            $data1 = array(
                'ceo' => $user_id,
                'partner_id' => $branch,
                'finance' => serialize($form['finance']),
            );
            $this->ais->insert('approval_setting', $data1);
        } else {
            $user_id = $this->getEmpUserID($form['ceo']);
            $data1 = array(
                'ceo' => $user_id,
                'finance' => serialize($form['finance']),
            );
            $this->ais->where('partner_id', $form['branch']);
            $this->ais->update('approval_setting', $data1);
        }
        /* echo'<pre>';print_r($data);
          echo'<pre>';print_r($data1);die;
          die; */
        return $result;
    }

}
