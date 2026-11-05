<?php

class Mdiligence extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->model('login/Muser');
        $this->load->helper('debug');
        $this->ais = $this->load->database('ais', TRUE);
    }

    function get_landingInfo($table, $id, $type = '') {
        if ($table == 'pitch_user') {
            $this->db->where('inno_id', $id);
        } else if ($table == 'inv_user') {
            $this->db->where('inv_no', $id);
        } else {
            $this->db->where('innovation_id', $id);
        }
        if ($table == 'diligence_document' && $type != '') {
            $this->db->where('doc_type', $type);
        }
        if ($table == 'application_status_log' && $type != '') {
            $this->db->where('status', $type);
            $this->db->order_by('id', 'desc');
            $this->db->limit(1);
        }
        if ($table == 'diligence_document') {
            $this->db->where('status', 1);
        }
        $result = $this->db->get($table);
        return $result->result_array();
    }

    function get_landingDocs($table, $id) {
        $this->db->select('doc_type');
        $this->db->where(array('innovation_id' => $id, 'status' => 1));
        $result = $this->db->get($table);
        return $result->result_array();
    }

    function get_data($table, $id = '', $cond = '') {
        if ($table == 'diligence_meeting') {
            $field = 'meeting_type';
        } else {
            $field = 'doc_type';
        }

        if ($table == 'diligence_document_types' || $table == 'diligence_meeting_type') {
            $this->db->order_by('name', 'asc');
        }
        if ($cond != '') {
            $this->db->where($field, $cond);
        }
        if ($id != '') {
            $this->db->where('innovation_id', $id);
        }
        if ($table == 'diligence_document_types') {
            $this->db->where('type', 1);
        }
        if ($table == 'detailed_diligence') {
            $this->db->order_by('version', 'desc');
        }
        if ($table != 'innovation_pool') {
            $this->db->where('status', '1');
        }
        $result = $this->db->get($table);
        return $result->result_array();
    }

    function getMainIncub($inv) {
        $this->db->select("IP.summary_of_business,IP.stage,IP.city,IP.sector,INV.address1,INV.sub_sector");

        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->where('IP.innovation_id', $inv);
        $query = $this->db->get('innovation_pool IP');

        return $query->result_array();
    }

    function getMainPitch($inv) {
        $this->db->select("IP.summary_of_business,IP.stage,PI.city,IP.sector,PI2.sub_sector,PI1.invention_based");

        $this->db->join('pitch_user PI', 'PI.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_step1_info PI1', 'PI1.pitch_id = PI.pitch_id', 'left');
        $this->db->join('pitch_step2 PI2', 'PI2.pitch_id = PI.pitch_id', 'left');
        $this->db->where('IP.innovation_id', $inv);
        $query = $this->db->get('innovation_pool IP');

        return $query->result_array();
    }

    function getManageIncub($inv) {
        $this->db->select("IM.mem_name as name,IM.mem_occupation as desg,IM.mem_email as email,IM.mem_mobile as mobile,IM.mem_resume as resume");

        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('inv_member IM', 'IM.inv_user_id = INV.id', 'left');
        $this->db->where('IP.innovation_id', $inv);
        $query = $this->db->get('innovation_pool IP');

        return $query->result_array();
    }

    function getManagePitch($inv) {
        $this->db->select("PM.name,PM.cur_title as desg,PM.email,PM.phone as mobile");

        $this->db->join('pitch_user PI', 'PI.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_step1_members PM', 'PM.pitch_id = PI.pitch_id', 'left');
        $this->db->where('IP.innovation_id', $inv);
        $query = $this->db->get('innovation_pool IP');

        return $query->result_array();
    }

    function get_lastdata($table, $id, $version = '') {
        if ($version != '') {
            $this->db->where('version', $version);
        }
        if ($table == 'innovation_pool') {
            $this->db->where(array('innovation_id' => $id));
        } else {
            $this->db->where(array('innovation_id' => $id, 'status' => '1'));
        }
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $result = $this->db->get($table);
        return $result->result_array();
    }

    function insert_data($table, $value) {
        $this->db->insert($table, $value);
        return true;
    }

    function insert_detailed_assessment($table, $value) {
        $this->db->insert($table, $value);
        return $this->db->insert_id();
    }

    function update_detailed_assessment($table, $value, $id) {
        $this->db->set($value);
        $this->db->where('id', $id);
        $this->db->update($table);
        return true;
    }

    function update_data($table, $data, $id, $version = '', $doc = '') {
        $this->db->set($data);
        $this->db->where('innovation_id', $id);
        if ($version != '') {
            $this->db->where('version', $version);
        }
        if ($doc != '') {
            $this->db->where('doc_type', $doc);
        }
        $this->db->update($table);
        return true;
    }

    function update_meeting($table, $data, $id, $doc = '') {
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update($table);
        return true;
    }

    function get_documentName($table, $id) {
        $this->db->where(array('id' => $id, 'status' => '1'));
        $result = $this->db->get($table);
        return $result->result_array();
    }

    function check_docExist($table, $id = '', $cond = '') {
        if ($cond != '') {
            $this->db->where('doc_type', $cond);
        }
        if ($id != '') {
            $this->db->where('innovation_id', $id);
        }
        if ($table == 'diligence_document_types') {
            $this->db->where('type', 1);
        }
        $result = $this->db->get($table);
        return $result->result_array();
    }

    function delete_action($table, $data, $id) {
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update($table);
        return true;
    }

    function get_otherDoc($id) {
        $this->db->select('*, t1.id as detail_id');
        $this->db->join('diligence_document_types t2', 't2.id = t1.doc_type', 'left');
        $this->db->where(array('t1.innovation_id' => $id, 't1.status' => '1', 't2.type' => '1'));
        $this->db->order_by('t1.id', 'asc');
        $result = $this->db->get('diligence_document t1');
        return $result->result_array();
    }

    function get_meetingDoc($id) {
        $this->db->select('*, t1.id as meeting_id');
        $this->db->join('diligence_meeting_type t2', 't2.id = t1.meeting_type', 'left');
        $this->db->where(array('t1.innovation_id' => $id, 't1.status' => '1'));
        $this->db->order_by('t1.id', 'asc');
        $result = $this->db->get('diligence_meeting t1');
        return $result->result_array();
    }

}

?>
