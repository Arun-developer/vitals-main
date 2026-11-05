<?php

class Mexport extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ais = $this->load->database('ais', TRUE);
        $this->hris = $this->load->database('hris', TRUE);
    }

    public function getIncubDetails($inv) {
        $this->db->select("IP.program,iaf.business_plan as file1, iaf.add_info as file2, iaf.inc_cert as file3");
        $this->db->join('inv_user INV', 'INV.inv_no =  IP.innovation_id', 'left');
        $this->db->join('inv_additional_info iaf', 'iaf.inv_user_id =  INV.id', 'left');
        $this->db->where('IP.innovation_id', $inv);
        $query = $this->db->get('innovation_pool IP');
        $rows = $query->result_array();
        return $rows;
    }

    public function getPitchDetails($inv) {
        $this->db->select("AW.doc1 as file1, AW.doc2 as file2");
        $this->db->join('award_share AW', 'AW.pitch_id =  PI.pitch_id', 'left');
        $this->db->where('PI.inno_id', $inv);
        $query = $this->db->get('pitch_user PI');
        $rows = $query->result_array();
        return $rows;
    }

    public function getProgramID($inv) {
        $this->db->select("program");
        $this->db->where('id', $inv);
        $query = $this->db->get('innovation_pool');
        $rows = $query->result_array();
        return $rows;
    }

}
