<?php

#
# Model Class -  hs_master_settings
#

class Mmaster_settings extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }

    public function getMaster($MasterType = null, $MasterName = null, $Id = null) {
        $data = array();
        if ($MasterType != null) {
            $terms['master_type'] = $MasterType;
        }

        if ($MasterName != null) {
            $terms['master_name'] = $MasterName;
        }

        if ($Id != null) {
            $terms['id'] = $Id;
        }

        $query = $this->db->get_where('master_settings', $terms);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function insert() {
        $data = array('master_type' => $this->input->post('master_type'),
            'master_name' => $this->input->post('master_name'));
        $result = $this->db->insert('master_settings', $data);
        return $result;
    }

    public function update() {
        $data = array('master_type' => $this->input->post('master_type'),
            'master_name' => $this->input->post('master_name'));
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('master_settings', $data);
        return $result;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->db_debug = false;
        $result = $this->db->delete('master_settings');
        if (!$result) {
            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            return $num;
        }
        return '';
    }

    /**
     * Function : changeStatus method is used for Make active inactive.
     * $options - values
     *     staus
     *    vendor_id
     *
     * @param array $options
     *
     */
    public function changeStatus($options = array()) {
        $data = array('status' => $options['status']);
        $this->db->where('id', $options['id']);
        $this->db->update('master_settings', $data);
        return true;
    }

    /**
     * Function : getAllCount method is used for get count records from  vendors.
     * $options - values
     *     orderby
     *    ordertype
     *    vendorName
     *    contactPerson
     *
     * @param array $options
     *
     */
    public function getAllCount($options = array()) {
        $data = array();
        $whereQuery = $this->_search($options);
        $this->db->select("count(*) as total");
        $this->db->where("status !=", "-1");

        if ($options['currentTab'] == 'reject_reasons') {
            $this->db->where("master_type =", 'Reject Reasons');
            if ($this->session->userdata('user_type') != 'superadmin') {
                $this->db->where("partner_id =", $this->session->userdata('partner_id'));
            }
            $query = $this->db->get('master_settings');
        } else if ($whereQuery != null) {
            $query = $this->db->get_where('master_settings', $whereQuery);
        } else {
            $query = $this->db->get('master_settings');
        }
        // debug_last_query();exit;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        // print_r($data[0]['total']);exit;
        $query->free_result();
        return $data['0']['total'];
    }

    /**
     * Function : getLimitRecords method is used for get Limit records from  vendors.
     *
     * @param array $options
     *
     */
    public function getLimitRecords($options = array(), $where) {

        $data = array();
        $whereQuery = $this->_search($options);
        $this->db->where("status !=", "-1");

        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        if (!empty($where)) {
            $this->db->like($where);
        }

        if ($options['currentTab'] == 'reject_reasons') {
            $this->db->where("master_type =", 'Reject Reasons');
            if ($this->session->userdata('user_type') != 'superadmin') {
                $this->db->where("partner_id =", $this->session->userdata('partner_id'));
            }
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('master_settings');
        } else if (!empty($whereQuery)) {
            $query = $this->db->get_where('master_settings', $whereQuery);
        } else {
            $query = $this->db->get('master_settings');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getMasterSettings($id) {
        $data = array();
        $this->db->where("id", $id);
        $this->db->order_by('master_name');
        $query = $this->db->get('master_settings');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    /**
     * Function : _search method is used for generate Search query .
     *
     * @param array $options
     *
     */
    public function _search($options = array()) {
        $masterType = $this->config->item('masterType');
        $searchArray = array();
        $where = null;
        if (!empty($options['master_name'])) {
            $searchArray[] = "master_name like '%" . $options['master_name'] . "%'";
        }

        if (!empty($options['currentTab'])) {
            $searchArray[] = "master_type = '" . $masterType[$options['currentTab']] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }

    public function getMasterSetting($masterType = null, $partner_id = '') {
        $data = array();
        if ($partner_id != '') {
            $this->db->where('partner_id', "$partner_id");
        }
        $this->db->where('status', '1');
        $this->db->where('master_type', $masterType);
        $this->db->select('id,master_name');
        if ($masterType != 'Incubation Cycle') {
            $this->db->order_by("master_name", "asc");
        }
        $query = $this->db->get('master_settings');
		#echo debug_last_query();die;
		#echo $this->db->database;die;
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function insertDonorFit($array) {
        $result = $this->db->insert('donor_fit_master', $array);
        return $result;
    }

    public function insertRejectReasons($array) {
        $result = $this->db->insert('master_settings', $array);
        return $result;
    }

    public function insertPreliminaryReason($array) {
        $result = $this->db->insert('preliminary_reasons', $array);
        return $result;
    }

    public function fetchDonorFit($where = null, $options = null) {
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($where)) {
            $this->db->like($where);
        }

        if ($this->session->userdata('user_type') != 'superadmin') {
            $this->db->where('partner_id', $this->session->userdata('partner_id'));
        }

        $this->db->select('*');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('donor_fit_master');
        $result = $query->result_array();
        return $result;
    }

    public function rejectReasons($where = null, $options = null) {
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($where)) {
            $this->db->like($where);
        }

        if ($this->session->userdata('user_type') != 'superadmin') {
            $this->db->where('partner_id', $this->session->userdata('partner_id'));
        }

        $this->db->select('*');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('donor_fit_master');
        $result = $query->result_array();
        return $result;
    }

    public function fetchDonorFit_p($where = null, $options = null) {
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($where)) {
            $this->db->like($where);
        }

        $this->db->select('donor_fit_master.*,hr_partner_type.partner_name as branch_name');
        $this->db->select('donor_fit_master.*');
        $this->db->join('hr_partner_type', 'hr_partner_type.id = donor_fit_master.partner_id');
        $this->db->order_by('donor_fit_master.id', 'desc');
        $query = $this->db->get('donor_fit_master');

        foreach ($result as $key => $value) {
            $id = $value['from_employee'];
            $this->hris->where('id', $id);
            $emp = $this->hris->get('hr_users');
            $rs = $emp->result_array();
            $value['from_employee'] = $rs[0]['user_name'];
            $add = $value['additionalinfo'];
            $value['additionalinfo'] = $this->get_additional_info($add);
            $data[$key] = array();
            foreach ($value as $rw) {
                array_push($data[$key], $rw);
            }
        }

        return $query->result_array();
    }

    public function fetchPreliminaryReasons($where = null, $options = null) {
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($where)) {
            $this->db->like($where);
        }

        $this->db->select('*');
        if ($this->session->userdata('user_type') != 'superadmin') {
            $this->db->where('partner_id', $this->session->userdata('partner_id'));
        }
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('preliminary_reasons');
        $prelim_data = $query->result_array();

        return $query->result_array();
    }

    public function getPartnerName($id) {
        $this->db->select('partner_name as branch_name');
        $this->db->where('id', $id);
        $query = $this->db->get('hr_partner_type');

        return $query->result_array();
    }

    public function getSectorName($id) {
        $this->db->select('sector');
        $this->db->where('id', $id);
        $query = $this->db->get('sector_category');
        return $query->result_array();
    }

    public function getDonorFit($id = null) {
        if ($id != null) {
            $this->db->where('id', $id);
        }

        $this->db->select('*');
        $query = $this->db->get('donor_fit_master');
        return $query->result_array();
    }

    public function getRejectReasons($id = null) {
        if ($id != null) {
            $this->db->where('id', $id);
        }

        $this->db->select('*');
        $this->db->where('partner_id', $this->session->userdata('partner_id'));
        $this->db->where('master_type', 'Reject Reasons');
        $query = $this->db->get('master_settings');
        return $query->result_array();
    }

    public function getPrelim($id = null) {
        if ($id != null) {
            $this->db->where('id', $id);
        }

        $this->db->select('*');
        $query = $this->db->get('preliminary_reasons');
        return $query->result_array();
    }

    public function updateDonorFit($update, $where) {
        $this->db->where($where);
        $result = $this->db->update('donor_fit_master', $update);
        return $result;
    }

    public function updateRejectReason($update, $where) {
        $this->db->where($where);
        $result = $this->db->update('master_settings', $update);
        return $result;
    }

    public function updatePrelim($update, $where) {
        $this->db->where($where);
        $result = $this->db->update('preliminary_reasons', $update);
        return $result;
    }

    public function donorFitExist($donor, $id = null) {
        $data = array();
        $this->db->select('count(*) as total');
        $this->db->where('name', $donor);
        if ($id != null) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('donor_fit_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data['0']['total'];
    }

    public function PreliminaryExist($donor, $id = null) {
        $data = array();
        $this->db->select('count(*) as total');
        $this->db->where('name', $donor);
        if ($id != null) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get('preliminary_reasons');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data['0']['total'];
    }

    public function deleteDonorFit($id) {
        $result = $this->db->query('SELECT count(*) as total FROM grading_feedback WHERE FIND_IN_SET( ' . $id . ', donor_fit )');
        $row = $result->result_array();
        if (php72_cmp($row[0]['total']) > 0) {
            return 'Exist'; // 5 just a number
        } else {
            $this->db->where('id', $id);
            $this->db->db_debug = false;
            $result = $this->db->delete('donor_fit_master');
            if (!$result) {
                $msg = $this->db->_error_message();
                $num = $this->db->_error_number();
                return $num;
            }
            return '';
        }
    }

    public function deleteRejectReasons($id) {
        $this->db->where('id', $id);
        $result = $this->db->delete('master_settings');
        if (!$result) {
            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            return $num;
        }
        return '';
    }

    public function deletePrelim($id) {
        $exp = '.*;s:[0-9]+:"' . $id . '".*';
        $result = $this->db->query("SELECT count(*) as total FROM assesst_sub_cat_detail WHERE add_score REGEXP '" . $exp . "'");
        $row = $result->result_array();
        if (php72_cmp($row[0]['total']) > 0) {
            return 'Exist'; // 5 just a number
        } else {
            $this->db->where('id', $id);
            $this->db->db_debug = false;
            $result = $this->db->delete('preliminary_reasons');
            if (!$result) {
                $msg = $this->db->_error_message();
                $num = $this->db->_error_number();
                return $num;
            }
            return '';
        }
    }

    public function fetchListType($table, $id) {
        if ($table == 'diligence_document_types') {
            $this->db->where('type', 1);
        }
        if ($id != null) {
            $this->db->where('id', $id);
        }

        $this->db->where('status <>', 3);
        $this->db->order_by('name', 'asc');
        $result = $this->db->get($table);
        return $result->result_array();
    }

    public function type_checkExist($table, $value, $id = null) {
        $data = array();
        $this->db->select('count(*) as total');
        $this->db->where(array('name' => $value, 'status <>' => 3));
        if ($id != null) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data['0']['total'];
    }

    public function insertUploadTypes($table, $data) {
        $result = $this->db->insert($table, $data);
        return $result;
    }

    public function updateDocType($table, $update, $where) {
        $this->db->where($where);
        $result = $this->db->update($table, $update);
        return $result;
    }

    public function getPortfolioSettings($table, $partner_id = '') {
        $data = array();
        if ($partner_id != '') {
            $this->db->where('partner_id', $partner_id);
        }
        $this->db->where('status !=', 3);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function portfolioStatus($options = array(), $tablename) {
        $data = array('status' => $options['status'], 'updated_by' => $this->session->userdata('emp_number'));
        $this->db->where('id', $options['id']);
        $this->db->update($tablename, $data);
        return true;
    }

    public function portfolioInsert() {
        $table = '';
        $data = array();
        $v = isset($_POST['partner_id']) && $_POST['partner_id'] != '' ? $_POST['partner_id'] : $this->session->userdata('partner_id');
        if ($this->input->post('master_type') == 'Designation') {
            $table = 'port_team_designations';
            $data = array('name' => $this->input->post('master_name'), 'partner_id' => $partner_type, 'created_by' => $this->session->userdata('emp_number'), 'created_at' => date('Y-m-d H:i:s'));
        } else if ($this->input->post('master_type') == 'Non TAP') {
            $table = 'port_ttm_partnership_master';
            $data = array('name' => $this->input->post('master_name'), 'partner_id' => $partner_type, 'created_by' => $this->session->userdata('emp_number'), 'created_at' => date('Y-m-d H:i:s'));
        } else if ($this->input->post('master_type') == 'Units') {
            $table = 'port_units';
            $data = array('name' => $this->input->post('master_name'), 'partner_id' => $partner_type, 'created_by' => $this->session->userdata('emp_number'), 'created_at' => date('Y-m-d H:i:s'), 'status' => 1);
        } else if ($this->input->post('master_type') == 'Donor') {
            $table = 'port_donor_masters';
            $data = array('name' => $this->input->post('master_name'), 'partner_id' => $partner_type, 'created_by' => $this->session->userdata('emp_number'), 'created_at' => date('Y-m-d H:i:s'), 'status' => 1);
        } else if ($this->input->post('master_type') == 'TAP') {
            $table = 'port_service_providers';
            $data = array('name' => $this->input->post('master_name'), 'partner_id' => $partner_type, 'created_by' => $this->session->userdata('emp_number'), 'created_at' => date('Y-m-d H:i:s'), 'status' => 1);
        }
        
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where(array('name' => $this->input->post('master_name'), 'partner_id' => $partner_type));
        $this->db->where('status !=', '3');
        // will check row by column
        $this->result = $this->db->get();

        if ($this->result->num_rows() > 0) {

            return false;
        } else {

            $result = $this->db->insert($table, $data);
            return $result;
        }
    }

    public function portfolioInsertCompany() {
        $table = '';
        $data = array();
        $partner_type = isset($_POST['partner_id']) && $_POST['partner_id'] != '' ? $_POST['partner_id'] : $this->session->userdata('partner_id');
        $table = 'port_dashboard_master';
        $data = array('partner_id' => $partner_type, 'created_by' => $this->session->userdata('emp_number'), 'created_at' => date('Y-m-d H:i:s'), 'status' => 1, 'sector' => $this->input->post('sector_name'), 'financial_year' => $this->input->post('f_year'),
            'app_q1' => $this->input->post('app_q1'), 'app_q2' => $this->input->post('app_q2'), 'app_q3' => $this->input->post('app_q3'), 'app_q4' => $this->input->post('app_q4'), 'app_annual' => $this->input->post('app_annual'),
            'pard_q1' => $this->input->post('pard_q1'), 'pard_q2' => $this->input->post('pard_q2'), 'pard_q3' => $this->input->post('pard_q3'), 'pard_q4' => $this->input->post('pard_q4'), 'pard_annual' => $this->input->post('pard_annual'),
            'iic_q1' => $this->input->post('iic_q1'), 'iic_q2' => $this->input->post('iic_q2'), 'iic_q3' => $this->input->post('iic_q3'), 'iic_q4' => $this->input->post('iic_q4'), 'iic_annual' => $this->input->post('iic_annual'),
            'eic_q1' => $this->input->post('eic_q1'), 'eic_q2' => $this->input->post('eic_q2'), 'eic_q3' => $this->input->post('eic_q3'), 'eic_q4' => $this->input->post('eic_q4'), 'eic_annual' => $this->input->post('eic_annual'),
            'inc_q1' => $this->input->post('inc_q1'), 'inc_q2' => $this->input->post('inc_q2'), 'inc_q3' => $this->input->post('inc_q3'), 'inc_q4' => $this->input->post('inc_q4'), 'inc_annual' => $this->input->post('inc_annual'),
            'tot_q1' => $this->input->post('tot_q1'), 'tot_q2' => $this->input->post('tot_q2'), 'tot_q3' => $this->input->post('tot_q3'), 'tot_q4' => $this->input->post('tot_q4'), 'tot_annual' => $this->input->post('tot_annual'),
            'new_q1' => $this->input->post('new_q1'), 'new_q2' => $this->input->post('new_q2'), 'new_q3' => $this->input->post('new_q3'), 'new_q4' => $this->input->post('new_q4'), 'new_annual' => $this->input->post('new_annual'),
            'ext_q1' => $this->input->post('ext_q1'), 'ext_q2' => $this->input->post('ext_q2'), 'ext_q3' => $this->input->post('ext_q3'), 'ext_q4' => $this->input->post('ext_q4'), 'ext_annual' => $this->input->post('ext_annual')
        );

        $this->db->select("*");
        $this->db->from($table);
        $this->db->where(array('partner_id' => $partner_type, 'financial_year' => $this->input->post('f_year'), 'sector' => $this->input->post('sector_name')));
        $this->db->where('status !=', '3');
        $this->result = $this->db->get();

        if ($this->result->num_rows() > 0) {
            return false;
        } else {

            $result = $this->db->insert($table, $data);
            return $result;
        }
    }

    public function portfolioEdit($id, $table) {
        $data = array();
        $this->db->where("id", $id);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function portfolioUpdate() {
        $partner_type = isset($_POST['partner_id']) && $_POST['partner_id'] != '' ? $_POST['partner_id'] : $this->session->userdata('partner_id');
        if ($this->input->post('master_type') == 'Designation') {
            $table = 'port_team_designations';
            $data = array('name' => $this->input->post('master_name'), 'partner_id' => $partner_type, 'updated_by' => $this->session->userdata('emp_number'), 'status' => 1);
            $this->db->set($data);
        } else if ($this->input->post('master_type') == 'Non TAP') {
            $table = 'port_ttm_partnership_master';
            $data = array('name' => $this->input->post('master_name'), 'partner_id' => $partner_type, 'updated_by' => $this->session->userdata('emp_number'), 'status' => 1);
            $this->db->set($data);
        } else if ($this->input->post('master_type') == 'Units') {
            $table = 'port_units';
            $data = array('name' => $this->input->post('master_name'), 'partner_id' => $partner_type, 'updated_by' => $this->session->userdata('emp_number'), 'status' => 1);
            $this->db->set($data);
        } else if ($this->input->post('master_type') == 'Donor') {
            $table = 'port_donor_masters';
            $data = array('name' => $this->input->post('master_name'), 'partner_id' => $partner_type, 'updated_by' => $this->session->userdata('emp_number'), 'status' => 1);
            $this->db->set($data);
        } else if ($this->input->post('master_type') == 'TAP') {
            $table = 'port_service_providers';
            $data = array('name' => $this->input->post('master_name'), 'partner_id' => $partner_type, 'updated_by' => $this->session->userdata('emp_number'), 'status' => 1);
            $this->db->set($data);
        } else if ($this->input->post('master_type') == 'Sector Target') {
            $table = 'port_dashboard_master';
            $data = array('partner_id' => $partner_type, 'updated_by' => $this->session->userdata('emp_number'), 'status' => 1, 'sector' => $this->input->post('sector_name'), 'financial_year' => $this->input->post('f_year'),
                'app_q1' => $this->input->post('app_q1'), 'app_q2' => $this->input->post('app_q2'), 'app_q3' => $this->input->post('app_q3'), 'app_q4' => $this->input->post('app_q4'), 'app_annual' => $this->input->post('app_annual'),
                'pard_q1' => $this->input->post('pard_q1'), 'pard_q2' => $this->input->post('pard_q2'), 'pard_q3' => $this->input->post('pard_q3'), 'pard_q4' => $this->input->post('pard_q4'), 'pard_annual' => $this->input->post('pard_annual'),
                'iic_q1' => $this->input->post('iic_q1'), 'iic_q2' => $this->input->post('iic_q2'), 'iic_q3' => $this->input->post('iic_q3'), 'iic_q4' => $this->input->post('iic_q4'), 'iic_annual' => $this->input->post('iic_annual'),
                'eic_q1' => $this->input->post('eic_q1'), 'eic_q2' => $this->input->post('eic_q2'), 'eic_q3' => $this->input->post('eic_q3'), 'eic_q4' => $this->input->post('eic_q4'), 'eic_annual' => $this->input->post('eic_annual'),
                'inc_q1' => $this->input->post('inc_q1'), 'inc_q2' => $this->input->post('inc_q2'), 'inc_q3' => $this->input->post('inc_q3'), 'inc_q4' => $this->input->post('inc_q4'), 'inc_annual' => $this->input->post('inc_annual'),
                'tot_q1' => $this->input->post('tot_q1'), 'tot_q2' => $this->input->post('tot_q2'), 'tot_q3' => $this->input->post('tot_q3'), 'tot_q4' => $this->input->post('tot_q4'), 'tot_annual' => $this->input->post('tot_annual'),
                'new_q1' => $this->input->post('new_q1'), 'new_q2' => $this->input->post('new_q2'), 'new_q3' => $this->input->post('new_q3'), 'new_q4' => $this->input->post('new_q4'), 'new_annual' => $this->input->post('new_annual'),
                'ext_q1' => $this->input->post('ext_q1'), 'ext_q2' => $this->input->post('ext_q2'), 'ext_q3' => $this->input->post('ext_q3'), 'ext_q4' => $this->input->post('ext_q4'), 'ext_annual' => $this->input->post('ext_annual'));
        }
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update($table, $data);
        return $result;
    }

    public function portfolioDelete($id, $table) {
        $this->db->set(array('status' => 3, 'updated_by' => $this->session->userdata('emp_number')));
        $this->db->where('id', $id);
        $result = $this->db->update($table);
        return $result;
    }

}
