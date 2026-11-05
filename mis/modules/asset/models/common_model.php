<?php
#
# Model Class -  hs_quad_master_settings
#
class Common_model extends My_Model{

    public function __construct(){
        parent::__construct();
		$this->ais = $this->load->database('ais', TRUE);
    }
	
	function getMasterSetting($masterType = NULL, $id = NULL, $pid = NULL, $program = NULL) {
        $donor_id = explode(',', $this->getdonorsfromprogram($program));
        $partner_id = $this->session->userdata('partner_id');

        $data = array();
        $this->ais->where('ms.status', '1');
        $this->ais->where('ms.partner_id', $partner_id);
        if ($pid != NULL)
            $this->ais->where_in('ms.pid', $pid);

        if ($masterType != NULL) {
            $this->ais->select('ms.master_id,ms.master_name');
            if ($masterType == 'Budget Head') {
                $this->ais->join('master_settings DMS', 'DMS.master_id=ms.pid', 'left');
            } else if ($masterType == 'Line Item') {
                $this->ais->join('master_settings BMS', 'BMS.master_id=ms.pid', 'left');
                $this->ais->join('master_settings DMS', 'DMS.master_id=BMS.pid', 'left');
            } else if ($masterType == 'Cost Centre') {
                $this->ais->join('master_settings CMS', 'CMS.master_id=ms.pid', 'left');
                $this->ais->join('master_settings BMS', 'BMS.master_id=CMS.pid', 'left');
                $this->ais->join('master_settings DMS', 'DMS.master_id=BMS.pid', 'left');
            }
            if ($donor_id[0] != '' && $masterType != 'Donor') {
                $this->ais->where_in('DMS.master_id', $donor_id);
            } else if ($donor_id[0] != '') {
                $this->ais->where_in('ms.master_id', $donor_id);
            }
            $this->ais->where('ms.master_type', $masterType);
        }
        if ($id != NULL) {
            $this->ais->where('ms.master_id', $id);
            $this->ais->select('ms.master_name');
        }

        $this->ais->order_by('ms.master_name');
        $query = $this->ais->get('master_settings ms');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
	function getdonorsfromprogram($program) {
        $data = '';
        $this->ais->where('programme_id', $program);
        $this->ais->select('donor');
        $query = $this->ais->get('master_programme');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = unserialize($row['donor']);
            }
        }
        $data = ($data != '') ? implode(',', $data) : '';
        return $data;
    }
	
	
	
}
