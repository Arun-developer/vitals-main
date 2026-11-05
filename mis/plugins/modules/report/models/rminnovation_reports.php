<?php

class Rminnovation_reports extends CI_Model {
    /*  public function __construct() {
      parent::__construct();
      $this->hris = $this->load->database('hris', true);
      $this->load->model('master/Msource');
      $this->load->model('master/Mmaster_settings');
  } */

  public function __construct() {
//        ini_set('display_errors', 1);
//        ini_set('display_startup_errors', 1);
//        error_reporting(E_ALL);

    parent::__construct();
    $this->ais = $this->load->database('ais', TRUE);
    $this->hris = $this->load->database('hris', true);
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
    $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = IP.created_by) as created_emp", false);
    $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = IP.modified_by) as modified_emp", false);

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
            $associate = $this->getAssociate(array('innovation' => $row['id'], 'active' => 'Active'));

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

public function getAssociate($options = array()) {
    $data = array();
    $this->db->select("AA.*");
    $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = AA.associate_employee) as emp_name", false);
    $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = AA.created_by) as created_emp", false);
    $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = AA.modified_by) as modified_emp", false);

    if (!empty($options['innovation'])) {
        $this->db->where('AA.innovation', $options['innovation']);
    }

    if (!empty($options['associate'])) {
        $this->db->where('AA.associate_employee', $options['associate']);
    }

    $this->db->where('AA.status', '1');

    $query = $this->db->get('assign_associate AA');
    if ($query->num_rows() > 0) {
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }
    return $data;
}

public function _searchReport_All($options = array()) {

    $searchArray = array();
    $searchArray1 = array();
    $where = null;
    if (is_array($options['associate'])) {
        $searchArray[] = "IP.id IN ('" . implode("','", $options['associate']) . "')";
    }

    if (!empty($options['sector'])) {
        $searchArray[] = "(SC.id = '" . $options['sector'] . "')";
            // $searchArray[] = "(SC.sector like '%" . $options['sector'] . "%' OR pitch_step2.sector like '%" . $options['sector'] . "%')";
    }

    if (isset($options['source_type']) && $options['source_type'] == '0') {
        $searchArray[] = "IP.source IN (0,101,103,123) and (IP.created_by = 0 or IP.created_by IS NULL)";
    } else if (isset($options['source_type']) && $options['source_type'] == '1') {
        $searchArray[] = "IP.source NOT IN (0,101,103,123) and IP.created_by > 0 and IP.created_by IS NOT NULL";
    }

    if (isset($options['program']) && $options['program'] != "") {
//            $searchArray[] = "IP.program = '" . $options['program'] . "'";
        if ($options['program'] == 0) {
            $searchArray[] = "(IP.program = 0 or IP.program = 4)";
        } else {
            $searchArray[] = "IP.program = '" . $options['program'] . "'";
        }
    }

    $copypartner = $options['copy_id'];
    $copyid = explode("_", $copypartner);
    if (isset($options['copy_id']) && $options['copy_id'] != "") {
        $searchArray[] = "IP.copy_id ='" . $copyid[0] . "' and (IP.partner_id ='" . ltrim($copyid[1], '0') . "' or IP.partner_id ='0" . $options['branch'] . "') and IP.partner_count ='" . $copyid[2] . "'";
    }

    $searchArray[] = "IP.copy_status != '4'";
    if ($copypartner == '') {
        if (isset($options['branch_name']) && !empty($options['branch_name'])) {
            $searchArray[] = "(IP.partner_id = '" . $options['branch_name'] . "' or IP.partner_id ='0" . $options['branch_name'] . "')";
        } else {

            if (!empty($options['branch'])) {
                $searchArray[] = "(IP.partner_id = '" . $options['branch'] . "' or IP.partner_id ='0" . $options['branch'] . "')";
            }
        }
    }

    if (!empty($options['employee'])) {
        $searchArray[] = "IP.created_by = '" . $options['employee'] . "'";
    }

    if (!empty($options['assign_employee'])) {
        $searchArray[] = "AA.associate_employee = '" . $options['assign_employee'] . "'";
    }

    if (!empty($options['created_by'])) {
        $searchArray[] = "IP.created_by = '" . $options['created_by'] . "'";
    }

    if (!empty($options['created_date'])) {
        $searchArray[] = "IP.created_date >= '" . date2mysql($options['created_date']) . " 00:00:00'";
    }

    if (!empty($options['created_date_to'])) {
        $searchArray[] = "IP.created_date <= '" . date2mysql($options['created_date_to']) . " 23:59:59'";
    }

    $stage_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '!1', '!2', '!3', '!4', '!5', '!6', '!7', '!8', '!9', '!10', '!11', '!12');
    $status_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '!1', '!2', '!3', '!4', '!5', '!6', '!7', '!8', '!9', '!10', '!11', '!12', '!13', '!14', '!15', '!16', '!17', '!18', '!19', '!20');

    if (isset($options['sstage']) && $options['sstage'] != '' && isset($options['sstatus']) && $options['sstatus'] != '') {

        if (in_array($options['sstage'], $stage_array) && in_array($options['sstatus'], $status_array)) {
            if (strpos($options['sstatus'], '!') !== false && strpos($options['sstage'], '!') !== false) {
                $searchArray[] = "IP.status != '" . str_replace('!', '', $options['sstatus']) . "' and IP.stage != '" . str_replace('!', '', $options['sstage']) . "'";
            } else if (strpos($options['sstatus'], '!') !== false && strpos($options['sstage'], '!') === false) {
                $searchArray[] = "IP.status != '" . str_replace('!', '', $options['sstatus']) . "' and IP.stage = '" . $options['sstage'] . "'";
            } else if (strpos($options['sstatus'], '!') === false && strpos($options['sstage'], '!') !== false) {
                $searchArray[] = "IP.status != '" . $options['sstatus'] . "' and IP.stage != '" . str_replace('!', '', $options['sstage']) . "'";
            } else if (strpos($options['sstatus'], '!') === false && strpos($options['sstage'], '!') === false) {
                $searchArray[] = "IP.stage='" . $options['sstage'] . "' AND IP.status='" . $options['sstatus'] . "'";
            }
        }
    }

    if (isset($options['istage']) && $options['istage'] != '' && isset($options['istatus']) && $options['istatus'] != '') {

        if (in_array($options['istage'], $stage_array) && in_array($options['istatus'], $status_array)) {

            $searchArray[] = "(IP.stage='" . $options['istage'] . "' OR IP.status='" . $options['istatus'] . "')";
        }
    }

    if (isset($options['stage']) && @$options['stage'] != '') {
        if ($options['stage'] == '!5') {
            $searchArray[] = "IP.stage != '5'";
        } else if (in_array($options['stage'], $stage_array)) {
            $searchArray[] = "IP.stage = '" . $options['stage'] . "'";
        } else {
            $searchArray[] = "GF.fstage = '" . $options['stage'] . "'";
        }
    }

    if (isset($options['status']) && @$options['status'] != '') {
        if ($options['status'] == '!3') {
            $status = "IP.status != '3'";
        } else {
            $status = "IP.status = '" . $options['status'] . "'";
        }

        $status_where = '(' . $status;

        if (isset($options['dstatus']) && $options['dstatus'] != '' && strpos($options['dstatus'], '!') === false) {
            $dstatus = "IP.status = '" . $options['dstatus'] . "'";
            $status_where .= ' or ' . $dstatus;
        }
        if (isset($options['rstatus']) && $options['rstatus'] != '' && strpos($options['rstatus'], '!') === false) {
            $rstatus = "IP.status = '" . $options['rstatus'] . "'";
            $status_where .= ' or ' . $rstatus;
        }
        if (isset($options['delstatus']) && $options['delstatus'] != '' && strpos($options['delstatus'], '!') === false) {
            $delstatus = "IP.status = '" . $options['delstatus'] . "'";
            $status_where .= ' or ' . $delstatus;
        }
        $status_where .= ')';
        $searchArray[] = $status_where;
    }

    if (isset($options['dstatus']) && $options['dstatus'] != '') {
        if (strpos($options['dstatus'], '!') !== false) {
            $searchArray[] = "IP.status != '" . str_replace('!', '', $options['dstatus']) . "'";
        }
    }
    if (isset($options['rstatus']) && $options['rstatus'] != '') {
        if (strpos($options['rstatus'], '!') !== false) {
            $searchArray[] = "IP.status != '" . str_replace('!', '', $options['rstatus']) . "'";
        }
    }
    if (isset($options['delstatus']) && $options['delstatus'] != '') {
        if (strpos($options['delstatus'], '!') !== false) {
            $searchArray[] = "IP.status != '" . str_replace('!', '', $options['delstatus']) . "'";
        }
    }

    if (isset($options['decision_status']) && $options['decision_status'] != '') {
        $searchArray[] = "(IP.status = '" . $options['decision_status'] . "' OR IP.grading_status = '" . $options['grading_status'] . "')";
    } else {
        if (isset($options['grading_status']) && @$options['grading_status'] != '') {
            $searchArray[] = "IP.grading_status = '" . $options['grading_status'] . "'";
        }
    }
    $options['name_of_enterprise'] = $this->db->escape_str($options['name_of_enterprise']);
    $options['name_of_entrepreneur'] = $this->db->escape_str($options['name_of_entrepreneur']);
    if (!empty($options['name_of_enterprise'])) {
        $searchArray[] = "IP.name_of_enterprise like '%" . $options['name_of_enterprise'] . "%'";
    }

    if (!empty($options['incubation_cycle'])) {
        $searchArray[] = "IP.incubation_cycle = '" . $options['incubation_cycle'] . "'";
    }

    if (!empty($options['summary_of_business'])) {
        $searchArray[] = "IP.summary_of_business LIKE '%" . $options['summary_of_business'] . "%'";
    }

    if (!empty($options['website'])) {
        $searchArray[] = "IP.website LIKE '%" . $options['website'] . "%'";
    }

    if (!empty($options['name_of_entrepreneur'])) {
        $searchArray[] = "IP.name_of_entrepreneur like '%" . $options['name_of_entrepreneur'] . "%'";
    }

    if (!empty($options['geography'])) {
        $searchArray[] = "IP.state like '%" . $options['geography'] . "%'";
    }

    if (!empty($options['city'])) {
        $searchArray[] = "IP.city like '%" . $options['city'] . "%'";
    }

    if (!empty($options['email'])) {
        $searchArray[] = "IP.email_id = '" . $options['email'] . "'";
    }

    if (!empty($options['mobile'])) {
        $searchArray[] = "IP.mobile_no like '%" . $options['mobile'] . "%'";
    }

    if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "") {
        $searchArray[] = "AA.associate_employee = '" . $options['assigned_incharge'] . "'";
        $searchArray[] = "AA.status=1";
    }

    global $assign;
    if (isset($options['lis']) && $options['lis'] != '') {
        $searchArray[] = "GF.LIS ='" . $options['lis'] . "'";
    }

    if (isset($options['donor_fit']) && $options['donor_fit'] != '') {
        $searchArray[] = "FIND_IN_SET( '" . $options['donor_fit'] . "', donor_fit )";
    }

    if ($options['copy_id'] == '' && $options['email'] == '' && $options['name_of_enterprise'] == '' && $options['name_of_entrepreneur'] == '' && $options['source_type'] == '' && $options['source'] == '' && $options['sector'] == '' && $options['status'] == '' && $options['stage'] == '' && $options['lis'] == '' && $options['donor_fit'] == '' && $options['mobile'] == '') {

    }

    if ((isset($options['firstdraft']) && $options['dealsearch'] == 'draft') && $options['dealsearch'] != 1) {

        $searchArray[] = "IP.is_deleted != '0' AND ((
        (INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' or INV.submitted_date = '0000-00-00')
        and (INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' or INV.submitted_date = '0000-00-00')
        and INV.created_date >='" . date2mysql($options['submitted_date']) . "'
        and INV.created_date <='" . date2mysql($options['submitted_date_to']) . "'
        ) or
        ((pitch_user.submitted_date >='" . date2mysql($options['submitted_date']) . "' OR pitch_user.submitted_date = '0000-00-00')
        and (pitch_user.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' OR pitch_user.submitted_date = '0000-00-00')
        and date(pitch_user.reg_date) >='" . date2mysql($options['submitted_date']) . "'
        and date(pitch_user.reg_date) <='" . date2mysql($options['submitted_date_to']) . "')
    )";
}

if ((isset($options['firstdraft']) && $options['firstdraft'] == 'draft') && $options['dealsearch'] == 1) {
    $searchArray[] = "IP.is_deleted != '0'";
}
if ((isset($options['firstw']) && $options['firstw'] == '') && $options['dealsearch'] != 1 && $options['rstatus'] != 10) {
    $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' AND INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "') or (pitch_user.submitted_date>='" . date2mysql($options['submitted_date']) . "' and  pitch_user.submitted_date <='" . date2mysql($options['submitted_date_to']) . "'))";
}

if ((isset($options['firstw']) && $options['firstw'] == '') && $options['dealsearch'] == 1) {
    $searchArray[] = "IP.is_deleted != '0'";
}

if (isset($options['first']) && $options['first'] == 1) {
    $searchArray[] = "IP.is_deleted != '0'";
} else if (isset($options['checkbox']) && $options['checkbox'] == 0) {
    $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' and INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' or INV.submitted_date = 0000-00-00) or (pitch_user.submitted_date>='" . date2mysql($options['submitted_date']) . "' and  pitch_user.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' or pitch_user.submitted_date = 0000-00-00))";
} else if (isset($options['first']) && $options['first'] == 0) {

    $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' AND INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "') or (pitch_user.submitted_date>='" . date2mysql($options['submitted_date']) . "' and  pitch_user.submitted_date <='" . date2mysql($options['submitted_date_to']) . "'))";
} else if (isset($options['first']) && $options['first'] == 'draft') {
    $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' and INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' or INV.submitted_date = 0000-00-00) or (pitch_user.submitted_date>='" . date2mysql($options['submitted_date']) . "' and  pitch_user.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' or pitch_user.submitted_date = 0000-00-00))";
} else {
    if ((isset($options['submitted_date']) && $options['submitted_date'] != '') || (isset($options['submitted_date_to']) && $options['submitted_date_to'] != '')) {
        $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' AND INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "') or (pitch_user.submitted_date>='" . date2mysql($options['submitted_date']) . "' and  pitch_user.submitted_date <='" . date2mysql($options['submitted_date_to']) . "'))";
    }
}

if (count($searchArray)) {
    $where = implode(' and ', $searchArray);
}

if (count($searchArray1)) {
    $where .= " AND (" . implode(' or ', $searchArray1) . ")";
}
return $where;
}

public function _searchReport($options = array()) {
    $searchArray = array();
    $searchArray1 = array();
    $where = null;
    if (is_array($options['associate'])) {
        $searchArray[] = "IP.id IN ('" . implode("','", $options['associate']) . "')";
    }

    if (!empty($options['sector'])) {
        $searchArray[] = "(SC.id = '" . $options['sector'] . "')";
            // $searchArray[] = "(SC.sector like '%" . $options['sector'] . "%' OR pitch_step2.sector like '%" . $options['sector'] . "%')";
    }

    if (isset($options['source_type']) && $options['source_type'] == '0') {
        $searchArray[] = "IP.source IN (0,101,103,123) and (IP.created_by = 0 or IP.created_by IS NULL)";
    } else if (isset($options['source_type']) && $options['source_type'] == '1') {
        $searchArray[] = "IP.source NOT IN (0,101,103,123) and IP.created_by > 0 and IP.created_by IS NOT NULL";
    }

    if (isset($options['program']) && $options['program'] != "") {
//            $searchArray[] = "IP.program = '" . $options['program'] . "'";
        if ($options['program'] == 0) {
            $searchArray[] = "(IP.program = 0 or IP.program = 4)";
        } else {
            $searchArray[] = "IP.program = '" . $options['program'] . "'";
        }
    }

    $copypartner = $options['copy_id'];
    $copyid = explode("_", $copypartner);
    if (isset($options['copy_id']) && $options['copy_id'] != "") {
        $searchArray[] = "IP.copy_id ='" . $copyid[0] . "' and (IP.partner_id ='" . ltrim($copyid[1], '0') . "' or IP.partner_id ='0" . $options['branch'] . "') and IP.partner_count ='" . $copyid[2] . "'";
    }

    $searchArray[] = "IP.copy_status != '4'";

    if ($copypartner == '') {
        if (isset($options['branch_name']) && !empty($options['branch_name'])) {
            $searchArray[] = "(IP.partner_id = '" . $options['branch_name'] . "' or IP.partner_id ='0" . $options['branch_name'] . "')";
        } else {

            if (!empty($options['branch'])) {
                $searchArray[] = "(IP.partner_id = '" . $options['branch'] . "' or IP.partner_id ='0" . $options['branch'] . "')";
            }
        }
    }

    if (!empty($options['employee'])) {
        $searchArray[] = "IP.created_by = '" . $options['employee'] . "'";
    }

    if (!empty($options['assign_employee'])) {
        $searchArray[] = "AA.associate_employee = '" . $options['assign_employee'] . "'";
    }

    if (!empty($options['created_by'])) {
        $searchArray[] = "IP.created_by = '" . $options['created_by'] . "'";
    }

    if (!empty($options['created_date'])) {
        $searchArray[] = "IP.created_date >= '" . date2mysql($options['created_date']) . " 00:00:00'";
    }

    if (!empty($options['created_date_to'])) {
        $searchArray[] = "IP.created_date <= '" . date2mysql($options['created_date_to']) . " 23:59:59'";
    }

    $stage_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '!1', '!2', '!3', '!4', '!5', '!6', '!7', '!8', '!9', '!10', '!11', '!12');
    $status_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '!1', '!2', '!3', '!4', '!5', '!6', '!7', '!8', '!9', '!10', '!11', '!12', '!13', '!14', '!15', '!16', '!17', '!18', '!19', '!20');

    if (isset($options['sstage']) && $options['sstage'] != '' && isset($options['sstatus']) && $options['sstatus'] != '') {

        if (in_array($options['sstage'], $stage_array) && in_array($options['sstatus'], $status_array)) {
            if (strpos($options['sstatus'], '!') !== false && strpos($options['sstage'], '!') !== false) {
                $searchArray[] = "IP.status != '" . str_replace('!', '', $options['sstatus']) . "' and IP.stage != '" . str_replace('!', '', $options['sstage']) . "'";
            } else if (strpos($options['sstatus'], '!') !== false && strpos($options['sstage'], '!') === false) {
                $searchArray[] = "IP.status != '" . str_replace('!', '', $options['sstatus']) . "' and IP.stage = '" . $options['sstage'] . "'";
            } else if (strpos($options['sstatus'], '!') === false && strpos($options['sstage'], '!') !== false) {
                $searchArray[] = "IP.status != '" . $options['sstatus'] . "' and IP.stage != '" . str_replace('!', '', $options['sstage']) . "'";
            } else if (strpos($options['sstatus'], '!') === false && strpos($options['sstage'], '!') === false) {
                $searchArray[] = "IP.stage='" . $options['sstage'] . "' AND IP.status='" . $options['sstatus'] . "'";
            }
        }
    }

    if (isset($options['istage']) && $options['istage'] != '' && isset($options['istatus']) && $options['istatus'] != '') {

        if (in_array($options['istage'], $stage_array) && in_array($options['istatus'], $status_array)) {

            $searchArray[] = "(IP.stage='" . $options['istage'] . "' OR IP.status='" . $options['istatus'] . "')";
        }
    }

    if (isset($options['stage']) && @$options['stage'] != '') {
        if ($options['stage'] == '!5') {
            $searchArray[] = "IP.stage != '5'";
        } else if (in_array($options['stage'], $stage_array)) {
            $searchArray[] = "IP.stage = '" . $options['stage'] . "'";
        } else {
            $searchArray[] = "GF.fstage = '" . $options['stage'] . "'";
        }
    }

    if (isset($options['status']) && @$options['status'] != '') {
        if ($options['status'] == '!3') {
            $status = "IP.status != '3'";
        } else {
            $status = "IP.status = '" . $options['status'] . "'";
        }

        $status_where = '(' . $status;

        if (isset($options['dstatus']) && $options['dstatus'] != '' && strpos($options['dstatus'], '!') === false) {
            $dstatus = "IP.status = '" . $options['dstatus'] . "'";
            $status_where .= ' or ' . $dstatus;
        }
        if (isset($options['rstatus']) && $options['rstatus'] != '' && strpos($options['rstatus'], '!') === false) {
            $rstatus = "IP.status = '" . $options['rstatus'] . "'";
            $status_where .= ' or ' . $rstatus;
        }
        if (isset($options['delstatus']) && $options['delstatus'] != '' && strpos($options['delstatus'], '!') === false) {
            $delstatus = "IP.status = '" . $options['delstatus'] . "'";
            $status_where .= ' or ' . $delstatus;
        }
        $status_where .= ')';
        $searchArray[] = $status_where;
    }

    if (isset($options['dstatus']) && $options['dstatus'] != '') {
        if (strpos($options['dstatus'], '!') !== false) {
            $searchArray[] = "IP.status != '" . str_replace('!', '', $options['dstatus']) . "'";
        }
    }
    if (isset($options['rstatus']) && $options['rstatus'] != '') {
        if (strpos($options['rstatus'], '!') !== false) {
            $searchArray[] = "IP.status != '" . str_replace('!', '', $options['rstatus']) . "'";
        }
    }
    if (isset($options['delstatus']) && $options['delstatus'] != '') {
        if (strpos($options['delstatus'], '!') !== false) {
            $searchArray[] = "IP.status != '" . str_replace('!', '', $options['delstatus']) . "'";
        }
    }

    if (isset($options['decision_status']) && $options['decision_status'] != '') {
        $searchArray[] = "(IP.status = '" . $options['decision_status'] . "' OR IP.grading_status = '" . $options['grading_status'] . "')";
    } else {
        if (isset($options['grading_status']) && @$options['grading_status'] != '') {
            $searchArray[] = "IP.grading_status = '" . $options['grading_status'] . "'";
        }
    }
    $options['name_of_enterprise'] = $this->db->escape_str($options['name_of_enterprise']);
    $options['name_of_entrepreneur'] = $this->db->escape_str($options['name_of_entrepreneur']);
    if (!empty($options['name_of_enterprise'])) {
        $searchArray[] = "IP.name_of_enterprise like '%" . $options['name_of_enterprise'] . "%'";
    }

    if (!empty($options['incubation_cycle'])) {
        $searchArray[] = "IP.incubation_cycle = '" . $options['incubation_cycle'] . "'";
    }

    if (!empty($options['summary_of_business'])) {
        $searchArray[] = "IP.summary_of_business LIKE '%" . $options['summary_of_business'] . "%'";
    }

    if (!empty($options['website'])) {
        $searchArray[] = "IP.website LIKE '%" . $options['website'] . "%'";
    }

    if (!empty($options['name_of_entrepreneur'])) {
        $searchArray[] = "IP.name_of_entrepreneur like '%" . $options['name_of_entrepreneur'] . "%'";
    }

    if (!empty($options['geography'])) {
        $searchArray[] = "IP.state like '%" . $options['geography'] . "%'";
    }

    if (!empty($options['city'])) {
        $searchArray[] = "IP.city like '%" . $options['city'] . "%'";
    }

    if (!empty($options['email'])) {
        $searchArray[] = "IP.email_id = '" . $options['email'] . "'";
    }

    if (!empty($options['mobile'])) {
        $searchArray[] = "IP.mobile_no like '%" . $options['mobile'] . "%'";
    }

    if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "") {
        $searchArray[] = "AA.associate_employee = '" . $options['assigned_incharge'] . "'";
        $searchArray[] = "AA.status=1";
    }

    global $assign;
    if (isset($options['lis']) && $options['lis'] != '') {
        $searchArray[] = "GF.LIS ='" . $options['lis'] . "'";
    }

    if (isset($options['donor_fit']) && $options['donor_fit'] != '') {
        $searchArray[] = "FIND_IN_SET( '" . $options['donor_fit'] . "', donor_fit )";
    }

    if ($options['copy_id'] == '' && $options['email'] == '' && $options['name_of_enterprise'] == '' && $options['name_of_entrepreneur'] == '' && $options['source_type'] == '' && $options['source'] == '' && $options['sector'] == '' && $options['status'] == '' && $options['stage'] == '' && $options['lis'] == '' && $options['donor_fit'] == '' && $options['mobile'] == '') {

    }

    if ((isset($options['firstdraft']) && $options['dealsearch'] == 'draft') && $options['dealsearch'] != 1) {

        $searchArray[] = "IP.is_deleted != '0' AND ((
        (INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' or INV.submitted_date = '0000-00-00')
        and (INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' or INV.submitted_date = '0000-00-00')
        and INV.created_date >='" . date2mysql($options['submitted_date']) . "'
        and INV.created_date <='" . date2mysql($options['submitted_date_to']) . "'
        ) or
        ((pitch_user.submitted_date >='" . date2mysql($options['submitted_date']) . "' OR pitch_user.submitted_date = '0000-00-00')
        and (pitch_user.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' OR pitch_user.submitted_date = '0000-00-00')
        and date(pitch_user.reg_date) >='" . date2mysql($options['submitted_date']) . "'
        and date(pitch_user.reg_date) <='" . date2mysql($options['submitted_date_to']) . "')
    )";
}

if ((isset($options['firstdraft']) && $options['firstdraft'] == 'draft') && $options['dealsearch'] == 1) {
    $searchArray[] = "IP.is_deleted != '0'";
}
if ((isset($options['firstw']) && $options['firstw'] == '') && $options['dealsearch'] != 1 && $options['rstatus'] != 10) {
    $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' AND INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "') or (pitch_user.submitted_date>='" . date2mysql($options['submitted_date']) . "' and  pitch_user.submitted_date <='" . date2mysql($options['submitted_date_to']) . "'))";
}

if ((isset($options['firstw']) && $options['firstw'] == '') && $options['dealsearch'] == 1) {
    $searchArray[] = "IP.is_deleted != '0'";
}

if (isset($options['first']) && $options['first'] == 1) {
    $searchArray[] = "IP.is_deleted != '0'";
} else if (isset($options['checkbox']) && $options['checkbox'] == 0) {
    $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' and INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' or INV.submitted_date = 0000-00-00) or (pitch_user.submitted_date>='" . date2mysql($options['submitted_date']) . "' and  pitch_user.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' or pitch_user.submitted_date = 0000-00-00))";
} else if (isset($options['first']) && $options['first'] == 0) {

    $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' AND INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "') or (pitch_user.submitted_date>='" . date2mysql($options['submitted_date']) . "' and  pitch_user.submitted_date <='" . date2mysql($options['submitted_date_to']) . "'))";
} else if (isset($options['first']) && $options['first'] == 'draft') {
    $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' and INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' or INV.submitted_date = 0000-00-00) or (pitch_user.submitted_date>='" . date2mysql($options['submitted_date']) . "' and  pitch_user.submitted_date <='" . date2mysql($options['submitted_date_to']) . "' or pitch_user.submitted_date = 0000-00-00))";
} else {
    if ((isset($options['submitted_date']) && $options['submitted_date'] != '') || (isset($options['submitted_date_to']) && $options['submitted_date_to'] != '')) {
        $searchArray[] = "IP.is_deleted != '0' AND ((INV.submitted_date >='" . date2mysql($options['submitted_date']) . "' AND INV.submitted_date <='" . date2mysql($options['submitted_date_to']) . "') or (pitch_user.submitted_date>='" . date2mysql($options['submitted_date']) . "' and  pitch_user.submitted_date <='" . date2mysql($options['submitted_date_to']) . "'))";
    }
}

if (count($searchArray)) {
    $where = implode(' and ', $searchArray);
}

if (count($searchArray1)) {
    $where .= " AND (" . implode(' or ', $searchArray1) . ")";
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
        $options['source'] = (count($options['source'])) ? $options['source'] : '4564065348593407589345734534587346584365783457';
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
