<?php

class Minnovation_reports extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
        $this->load->model('master/Msource');
        $this->load->model('master/Mmaster_settings');
    }

    public function getLimitReportRecords($options = array()) {
        $data = array();
        $whereQuery = $this->_searchReport($options);
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        $this->db->select("IP.*,DATEDIFF(entry_date,IP.created_date) as new_entry,DATEDIFF(lead_date,entry_date) as entry_lead");
        $this->db->select("SM.source_name,IM.instance_name,(select master_name from master_settings where id=SM.source_type) as source_type");
        $this->db->select("(select master_name from master_settings where id=IP.incubation_cycle) as incubation_cycle_title");
        $this->db->select("(select master_name from master_settings where id=IP.reasons) as reasons_title");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = IP.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = IP.modified_by) as modified_emp", false);

        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
        if (!empty($whereQuery)) {
            $query = $this->db->get_where('innovation_pool IP', $whereQuery);
        } else {
            $query = $this->db->get('innovation_pool IP');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $asArray = array();
                $associate = $this->Mincharge->getAssociate(array('innovation' => $row['id'], 'active' => 'Active'));
                foreach ($associate as $as):
                    $asArray[] = $as['emp_name'];
                endforeach;
                $row['no_of_incharge'] = count($asArray);
                $row['associate_emp_name'] = implode(', ', $asArray);

                $row['source_name'] = ($row['source_name'] != '') ? $row['source_name'] : 'Direct Application';
                $row['reference'] = ($row['reference'] == 'Others') ? $row['reference'] . '-' . $row['other_reference'] : $row['reference'];
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function _searchReport_All($options = array()) {
        $searchArray = array();
        $searchArray[] = "IP.copy_status != '4'";

        if (is_array($options['associate'])) {
            $searchArray[] = "IP.id IN ('" . php72_implode("','", $options['associate']) . "')";
        }

        $copypartner = $options['copy_id'];
        $copyid = explode("_", $copypartner);
        if ($copypartner != "") {
            $searchArray[] = "IP.copy_id ='" . $copyid[0] . "' and (IP.partner_id ='" . ltrim($copyid[1], '0') . "' or IP.partner_id ='0" . $options['branch_name'] . "') and IP.partner_count ='" . $copyid[2] . "'";
        } else {
            $searchArray[] = "(IP.partner_id = '" . $options['branch_name'] . "' or IP.partner_id ='0" . $options['branch_name'] . "')";
        }

        $options['name_of_enterprise'] = $this->db->escape_str($options['name_of_enterprise']);
        if (!empty($options['name_of_enterprise'])) {
            $searchArray[] = "IP.name_of_enterprise like '%" . $options['name_of_enterprise'] . "%'";
        }

        $options['name_of_entrepreneur'] = $this->db->escape_str($options['name_of_entrepreneur']);
        if (!empty($options['name_of_entrepreneur'])) {
            $searchArray[] = "IP.name_of_entrepreneur like '%" . $options['name_of_entrepreneur'] . "%'";
        }

        if (isset($options['source_type']) && $options['source_type'] == '0') {
            $searchArray[] = "IP.source IN (0,101,103,123,124,126,127,128,129) and (IP.created_by = 0 or IP.created_by IS NULL)";
        } else if (isset($options['source_type']) && $options['source_type'] == '1') {
            $searchArray[] = "IP.source NOT IN (0,101,103,123,124,126,127,128,129) and IP.created_by > 0 and IP.created_by IS NOT NULL";
        } else if (isset($options['source_type']) && $options['source_type'] == '2') {
            $searchArray[] = "IP.source IN (124,126)";
        }

        if (!empty($options['sector'])) {
            $searchArray[] = "SC.id = '" . $options['sector'] . "'";
        } else {
            if ($this->session->userdata['role_id'] == '4') {
                $customt_sector = $this->session->userdata['sectorAccess'];
                $searchArray[] = "SC.id IN(" . $customt_sector . ")";
            }
        }

        if (isset($options['program']) && $options['program'] != "") {
            if (php72_cmp($options['program']) == 0) {
                if ($this->session->userdata['role_id'] == '4') {
                    $searchArray[] = "IP.program = 0";
                } else {
                    $searchArray[] = "(IP.program = 0 or IP.program = 4)";
                }
            } else {
                $searchArray[] = "IP.program = '" . $options['program'] . "'";
            }
        } else {
            if ($this->session->userdata['role_id'] == '4') {
                $customt_program = $this->session->userdata['programAccess'];
                $searchArray[] = "IP.program IN(" . $customt_program . ")";
            }
        }

        if (isset($options['stage']) && $options['stage'] != "") {
            $searchArray[] = "IP.stage='" . $options['stage'] . "'";
        }

        if (isset($options['status']) && $options['status'] != "") {
            $split_status = explode(',', $options['status']);
            $merge_status = "'" . implode("','", $split_status) . "'";
            if ($this->session->userdata['role_id'] == '4' && php72_cmp($this->session->userdata('independent_shortlist')) == 1) {
                $searchArray[] = "(ISC.current_app_status IN(" . $options['status'] . ") AND ISC.created_by = " . $this->session->userdata('emp_number') . ")";
            } else {
                $searchArray[] = "IP.status IN(" . $options['status'] . ")";
            }
        }

        if (!empty($options['created_date'])) {
            $searchArray[] = "IP.created_date >= '" . date2mysql($options['created_date']) . " 00:00:00'";
        }

        if (!empty($options['created_date_to'])) {
            $searchArray[] = "IP.created_date <= '" . date2mysql($options['created_date_to']) . " 23:59:59'";
        }

        if ((isset($options['submitted_date']) && $options['submitted_date'] != '') || (isset($options['submitted_date_to']) && $options['submitted_date_to'] != '')) {
            $cond_subFrom = $enter_fromDate = date('Y-m-d', strtotime($options['submitted_date']));
            $cond_subTo = $enter_toDate = date('Y-m-d', strtotime($options['submitted_date_to']));
            if ($this->session->userdata('role_id') == '4') {
                $define_fromDate = $this->session->userdata('dealsFrom');
                $define_toDate = $this->session->userdata('dealsTo');
                if ($define_fromDate >= $enter_fromDate) {
                    $cond_subFrom = $define_fromDate;
                } else {
                    $cond_subFrom = $enter_fromDate;
                }
                if ($define_toDate <= $enter_toDate) {
                    $cond_subTo = $define_toDate;
                } else {
                    $cond_subTo = $enter_toDate;
                }
            }
            $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $cond_subFrom . "' AND INV.submitted_date <='" . $cond_subTo . "') or (pitch.submitted_date >='" . $cond_subFrom . "' and  pitch.submitted_date <='" . $cond_subTo . "'))";
        }



        if (!empty($options['geography'])) {
            $searchArray[] = "IP.state like '%" . $options['geography'] . "%'";
        }

        if (!empty($options['city'])) {
            $searchArray[] = "(IP.city like '%" . $options['city'] . "%' OR EC.city_name like '%" . $options['city'] . "%')";
        }

        if (isset($options['lis']) && $options['lis'] != '') {
            $searchArray[] = "GF.LIS ='" . $options['lis'] . "'";
        }

        if (isset($options['donor_fit']) && $options['donor_fit'] != '') {
            $searchArray[] = "FIND_IN_SET( '" . $options['donor_fit'] . "', donor_fit )";
        }

        if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "") {
            $searchArray[] = "AA.associate_employee = '" . $options['assigned_incharge'] . "'";
            $searchArray[] = "AA.status = 1";
        }

        if (!empty($options['email'])) {
            $searchArray[] = "IP.email_id = '" . $options['email'] . "'";
        }

        if (!empty($options['mobile'])) {
            $searchArray[] = "IP.mobile_no like '%" . $options['mobile'] . "%'";
        }

        if ($options['deals_tab'] == 'mydeals') {
            if ($this->session->userdata('role_id') == '4')
                $check_count = 5;
            else
                $check_count = 3;
        } else {
            if ($this->session->userdata('role_id') == '4')
                $check_count = 4;
            else
                $check_count = 2;
        }

        if ($this->session->userdata('role_id') == '4' && empty($options['submitted_date']) && empty($options['submitted_date_to'])) {
            if ($options['deals_tab'] == 'alldeals') {
                $def_subTo = $current_date = date('Y-m-d');
                $last_date = strtotime("$current_date -1 year");
                $def_subFrom = $last_year = date('Y-m-d', $last_date);
                if ($this->session->userdata('role_id') == '4') {
                    $default_fromDate = $this->session->userdata('dealsFrom');
                    $default_toDate = $this->session->userdata('dealsTo');
                    if ($default_fromDate >= $last_year) {
                        $def_subFrom = $default_fromDate;
                    } else {
                        $def_subFrom = $last_year;
                    }
                    if ($default_toDate <= $current_date) {
                        $def_subTo = $default_toDate;
                    } else {
                        $def_subTo = $current_date;
                    }
                }
                $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $def_subFrom . "' AND INV.submitted_date <='" . $def_subTo . "') or (pitch.submitted_date >='" . $def_subFrom . "' and  pitch.submitted_date <='" . $def_subTo . "'))";
            } else {
                $searchArray[] = "IP.is_deleted != '0'";
            }
        }

        if ((count($searchArray) == $check_count && $this->session->userdata('role_id') != '4') && empty($options['created_date']) && empty($options['created_date']) && empty($options['submitted_date']) && empty($options['submitted_date_to'])) {
            if ($options['deals_tab'] == 'alldeals') {
                $def_subTo = $current_date = date('Y-m-d');
                $last_date = strtotime("$current_date -1 year");
                $def_subFrom = $last_year = date('Y-m-d', $last_date);
                if ($this->session->userdata('role_id') == '4') {
                    $default_fromDate = $this->session->userdata('dealsFrom');
                    $default_toDate = $this->session->userdata('dealsTo');
                    if ($default_fromDate >= $last_year) {
                        $def_subFrom = $default_fromDate;
                    } else {
                        $def_subFrom = $last_year;
                    }
                    if ($default_toDate <= $current_date) {
                        $def_subTo = $default_toDate;
                    } else {
                        $def_subTo = $current_date;
                    }
                }
                $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $def_subFrom . "' AND INV.submitted_date <='" . $def_subTo . "') or (pitch.submitted_date >='" . $def_subFrom . "' and  pitch.submitted_date <='" . $def_subTo . "'))";
            } else {
                $searchArray[] = "IP.is_deleted != '0'";
            }
        }

        if ($options['status'] == "") {
            $searchArray[] = "IP.status NOT IN('4','10','11')";
        }

        if (!empty($options['opertaion_stage'])) {
            $searchArray[] = "(iet.stage_product LIKE '%" . $options['opertaion_stage'] . "%' OR pitch_step2.operation_stage LIKE '%" . $options['opertaion_stage'] . "%')";
        }

        if (!empty($options['enterprise_stage'])) {
            $searchArray[] = "(INV.ent_type LIKE '%" . $options['enterprise_stage'] . "%' OR pitch_step1_info.ent_type LIKE '%" . $options['enterprise_stage'] . "%')";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }
        return $where;
    }

    public function _searchReport($options = array()) {
        $searchArray = array();
        $searchArray[] = "IP.copy_status != '4'";

        if (is_array($options['associate'])) {
            $searchArray[] = "IP.id IN ('" . php72_implode("','", $options['associate']) . "')";
        }

        $copypartner = $options['copy_id'];
        $copyid = explode("_", $copypartner);
        if ($copypartner != "") {
            $searchArray[] = "IP.copy_id ='" . $copyid[0] . "' and (IP.partner_id ='" . ltrim($copyid[1], '0') . "' or IP.partner_id ='0" . $options['branch_name'] . "') and IP.partner_count ='" . $copyid[2] . "'";
        } else {
            $searchArray[] = "(IP.partner_id = '" . $options['branch_name'] . "' or IP.partner_id ='0" . $options['branch_name'] . "')";
        }

        $options['name_of_enterprise'] = $this->db->escape_str($options['name_of_enterprise']);
        if (!empty($options['name_of_enterprise'])) {
            $searchArray[] = "IP.name_of_enterprise like '%" . $options['name_of_enterprise'] . "%'";
        }

        $options['name_of_entrepreneur'] = $this->db->escape_str($options['name_of_entrepreneur']);
        if (!empty($options['name_of_entrepreneur'])) {
            $searchArray[] = "IP.name_of_entrepreneur like '%" . $options['name_of_entrepreneur'] . "%'";
        }

        if (isset($options['source_type']) && $options['source_type'] == '0') {
            $searchArray[] = "IP.source IN (0,101,103,123,124,126,127,128,129) and (IP.created_by = 0 or IP.created_by IS NULL)";
        } else if (isset($options['source_type']) && $options['source_type'] == '1') {
            $searchArray[] = "IP.source NOT IN (0,101,103,123,124,126,127,128,129) and IP.created_by > 0 and IP.created_by IS NOT NULL";
        } else if (isset($options['source_type']) && $options['source_type'] == '2') {
            $searchArray[] = "IP.source IN (124,126)";
        }

        if (!empty($options['sector'])) {
            $searchArray[] = "SC.id = '" . $options['sector'] . "'";
        } else {
            if ($this->session->userdata['role_id'] == '4') {
                $customt_sector = $this->session->userdata['sectorAccess'];
                $searchArray[] = "SC.id IN(" . $customt_sector . ")";
            }
        }

        if (isset($options['program']) && $options['program'] != "") {
            if (php72_cmp($options['program']) == 0) {
                if ($this->session->userdata['role_id'] == '4') {
                    $searchArray[] = "IP.program = 0";
                } else {
                    $searchArray[] = "(IP.program = 0 or IP.program = 4)";
                }
            } else {
                $searchArray[] = "IP.program = '" . $options['program'] . "'";
            }
        } else {
            if ($this->session->userdata['role_id'] == '4') {
                $customt_program = $this->session->userdata['programAccess'];
                $searchArray[] = "IP.program IN(" . $customt_program . ")";
            }
        }

        if (isset($options['stage']) && $options['stage'] != "") {
            $searchArray[] = "IP.stage='" . $options['stage'] . "'";
        }

        if (isset($options['status']) && $options['status'] != "") {
            $split_status = explode(',', $options['status']);
            $merge_status = "'" . implode("','", $split_status) . "'";
            if ($this->session->userdata['role_id'] == '4' && php72_cmp($this->session->userdata('independent_shortlist')) == 1) {
                $searchArray[] = "(ISC.current_app_status IN(" . $options['status'] . ") AND ISC.created_by = " . $this->session->userdata('emp_number') . ")";
            } else {
                $searchArray[] = "IP.status IN(" . $options['status'] . ")";
            }
        }

        if (!empty($options['created_date'])) {
            $searchArray[] = "IP.created_date >= '" . date2mysql($options['created_date']) . " 00:00:00'";
        }

        if (!empty($options['created_date_to'])) {
            $searchArray[] = "IP.created_date <= '" . date2mysql($options['created_date_to']) . " 23:59:59'";
        }

        if ((isset($options['submitted_date']) && $options['submitted_date'] != '') || (isset($options['submitted_date_to']) && $options['submitted_date_to'] != '')) {
            $cond_subFrom = $enter_fromDate = date('Y-m-d', strtotime($options['submitted_date']));
            $cond_subTo = $enter_toDate = date('Y-m-d', strtotime($options['submitted_date_to']));
            if ($this->session->userdata('role_id') == '4') {
                $define_fromDate = $this->session->userdata('dealsFrom');
                $define_toDate = $this->session->userdata('dealsTo');
                if ($define_fromDate >= $enter_fromDate) {
                    $cond_subFrom = $define_fromDate;
                } else {
                    $cond_subFrom = $enter_fromDate;
                }
                if ($define_toDate <= $enter_toDate) {
                    $cond_subTo = $define_toDate;
                } else {
                    $cond_subTo = $enter_toDate;
                }
            }
            $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $cond_subFrom . "' AND INV.submitted_date <='" . $cond_subTo . "') or (pitch.submitted_date >='" . $cond_subFrom . "' and  pitch.submitted_date <='" . $cond_subTo . "'))";
        }



        if (!empty($options['geography'])) {
            $searchArray[] = "IP.state like '%" . $options['geography'] . "%'";
        }

        if (!empty($options['city'])) {
            $searchArray[] = "(IP.city like '%" . $options['city'] . "%' OR EC.city_name like '%" . $options['city'] . "%')";
        }

        if (isset($options['lis']) && $options['lis'] != '') {
            $searchArray[] = "GF.LIS ='" . $options['lis'] . "'";
        }

        if (isset($options['donor_fit']) && $options['donor_fit'] != '') {
            $searchArray[] = "FIND_IN_SET( '" . $options['donor_fit'] . "', donor_fit )";
        }

        if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "") {
            $searchArray[] = "AA.associate_employee = '" . $options['assigned_incharge'] . "'";
            $searchArray[] = "AA.status = 1";
        }

        if (!empty($options['email'])) {
            $searchArray[] = "IP.email_id = '" . $options['email'] . "'";
        }

        if (!empty($options['mobile'])) {
            $searchArray[] = "IP.mobile_no like '%" . $options['mobile'] . "%'";
        }

        if ($options['deals_tab'] == 'mydeals') {
            if ($this->session->userdata('role_id') == '4')
                $check_count = 5;
            else
                $check_count = 3;
        } else {
            if ($this->session->userdata('role_id') == '4')
                $check_count = 4;
            else
                $check_count = 2;
        }

        if ($this->session->userdata('role_id') == '4' && empty($options['submitted_date']) && empty($options['submitted_date_to'])) {
            if ($options['deals_tab'] == 'alldeals') {
                $def_subTo = $current_date = date('Y-m-d');
                $last_date = strtotime("$current_date -1 year");
                $def_subFrom = $last_year = date('Y-m-d', $last_date);
                if ($this->session->userdata('role_id') == '4') {
                    $default_fromDate = $this->session->userdata('dealsFrom');
                    $default_toDate = $this->session->userdata('dealsTo');
                    if ($default_fromDate >= $last_year) {
                        $def_subFrom = $default_fromDate;
                    } else {
                        $def_subFrom = $last_year;
                    }
                    if ($default_toDate <= $current_date) {
                        $def_subTo = $default_toDate;
                    } else {
                        $def_subTo = $current_date;
                    }
                }
                $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $def_subFrom . "' AND INV.submitted_date <='" . $def_subTo . "') or (pitch.submitted_date >='" . $def_subFrom . "' and  pitch.submitted_date <='" . $def_subTo . "'))";
            } else {
                $searchArray[] = "IP.is_deleted != '0'";
            }
        }

        if ((count($searchArray) == $check_count && $this->session->userdata('role_id') != '4') && empty($options['created_date']) && empty($options['created_date']) && empty($options['submitted_date']) && empty($options['submitted_date_to'])) {
            if ($options['deals_tab'] == 'alldeals') {
                $def_subTo = $current_date = date('Y-m-d');
                $last_date = strtotime("$current_date -1 year");
                $def_subFrom = $last_year = date('Y-m-d', $last_date);
                if ($this->session->userdata('role_id') == '4') {
                    $default_fromDate = $this->session->userdata('dealsFrom');
                    $default_toDate = $this->session->userdata('dealsTo');
                    if ($default_fromDate >= $last_year) {
                        $def_subFrom = $default_fromDate;
                    } else {
                        $def_subFrom = $last_year;
                    }
                    if ($default_toDate <= $current_date) {
                        $def_subTo = $default_toDate;
                    } else {
                        $def_subTo = $current_date;
                    }
                }
                $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . $def_subFrom . "' AND INV.submitted_date <='" . $def_subTo . "') or (pitch.submitted_date >='" . $def_subFrom . "' and  pitch.submitted_date <='" . $def_subTo . "'))";
            } else {
                $searchArray[] = "IP.is_deleted != '0'";
            }
        }

        if ($options['status'] == "") {
            $searchArray[] = "IP.status NOT IN('4','10','11')";
        }

        if (!empty($options['opertaion_stage'])) {
            $searchArray[] = "(iet.stage_product LIKE '%" . $options['opertaion_stage'] . "%' OR pitch_step2.operation_stage LIKE '%" . $options['opertaion_stage'] . "%')";
        }

        if (!empty($options['enterprise_stage'])) {
            $searchArray[] = "(INV.ent_type LIKE '%" . $options['enterprise_stage'] . "%' OR pitch_step1_info.ent_type LIKE '%" . $options['enterprise_stage'] . "%')";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }
        return $where;
    }

    public function getSourceWiseReport($employee = '', $type = '') {
        $source = array();
        if ($employee == '' && $type == '') {
            $sourceTypeList = $this->Mmaster_settings->getMasterSetting('Source Type');
            foreach ($sourceTypeList as $st):
                $s = array();
                $s['id'] = $this->Msource->getSourceByType($st['id']);
                $s['master_name'] = $st['master_name'];
                $s['source_name'] = $st['master_name'];
                $source[] = $s;
            endforeach;
        } else {
            $source = $this->Msource->getSourceList();
        }
        $totalInnovation = $this->getCountOnly();
        $records = array();
        if ($employee == '') {
            $direct = array('id' => '0', 'name' => 'Direct Applications', 'source_name' => 'Direct Applications', 'master_name' => 'Direct Applications');
            array_push($source, $direct);
        }
        foreach ($source as $row2):
            $data = array();
            $new = $this->getCountOnly(array('stage' => '0', 'source' => $row2['id'], 'employee' => $employee));
            $entry = $this->getCountOnly(array('stage' => '1', 'source' => $row2['id'], 'employee' => $employee));
            $lead = $this->getCountOnly(array('stage' => '2', 'source' => $row2['id'], 'employee' => $employee));

            $total_new = $data['total_new'] = $new + $entry + $lead;
            $total_entry = $data['total_entry'] = $entry + $lead;
            $total_lead = $data['total_lead'] = $lead;

            @$data['convertion_new_entry'] = round(($total_entry / $total_new) * 100, 2);
            @$data['convertion_entry_lead'] = round(($total_lead / $total_entry) * 100, 2);
            @$data['innovation_percent'] = round(($total_new / $totalInnovation) * 100, 2);
            $data['name'] = $row2['master_name'];
            $data['source_name'] = $row2['source_name'];
            $data['source_type'] = $row2['master_name'];
            $records[] = $data;
        endforeach;
        return $records;
    }

    public function getCountOnly($options = array()) {
        $data = array();
        $this->db->select('count(*) as total');
        if (!empty($options['source']) || @$options['source'] == '0') {
            $this->db->where_in('source', $options['source']);
        } elseif (isset($options['source'])) {
            $options['source'] = (php72_count($options['source'])) ? $options['source'] : '4564065348593407589345734534587346584365783457';
            $this->db->where('source', $options['source']);
        }

        if (!empty($options['stage']) || @$options['stage'] == '0') {
            $this->db->where('stage', $options['stage']);
        }

        if (!empty($options['employee']) || @$options['employee'] == '0') {
            $this->db->where('created_by', $options['employee']);
        }

        $query = $this->db->get('innovation_pool');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

}
