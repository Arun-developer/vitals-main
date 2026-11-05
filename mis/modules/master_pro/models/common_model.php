
<?php 
    class Common_model extends MY_Model{
        public function __construct(){
        parent::__construct(); 
        }
        function getdonorsfromprogram($program,$change_db,$db_name) {

            $db_var = $this->db;
            if(isset($change_db) && $change_db ==  true && $db_name!=''){
                $this->current_db = $this->load->database($db_name, true);
                $db_var = $this->current_db;
            }

            $data = '';
            $db_var->where('programme_id', $program);
            $db_var->select('donor');
            $query = $db_var->get('master_programme');
    
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data = unserialize($row['donor']);
                }
            }
            $data = ($data != '') ? php72_implode(',', $data) : '';
            return $data;
        }
    
        function getMasterSetting($masterType = NULL, $id = NULL, $pid = NULL, $program = NULL,$change_db = false,$db_name='') {
            
            $db_var = $this->db;
            if(isset($change_db) && $change_db ==  true && $db_name!=''){
                $this->current_db = $this->load->database($db_name, true);
                $db_var = $this->current_db;
            }
            $donor_id = explode(',', $this->getdonorsfromprogram($program,$change_db,$db_name));
            $partner_id = $this->session->userdata('partner_id');
    
            $data = array();
            $db_var->where('ms.status', '1');
            $db_var->where('ms.partner_id', $partner_id);
            if ($pid != NULL)
            $db_var->where_in('ms.pid', $pid);
            
            if ($masterType != NULL) {
                $db_var->select('ms.master_id,ms.master_name');
                if ($masterType == 'Budget Head') {
                    $db_var->join('master_settings DMS', 'DMS.master_id=ms.pid', 'left');
                } else if ($masterType == 'Line Item') {
                    $db_var->join('master_settings BMS', 'BMS.master_id=ms.pid', 'left');
                    $db_var->join('master_settings DMS', 'DMS.master_id=BMS.pid', 'left');
                } else if ($masterType == 'Cost Centre') {
                    $db_var->join('master_settings CMS', 'CMS.master_id=ms.pid', 'left');
                    $db_var->join('master_settings BMS', 'BMS.master_id=CMS.pid', 'left');
                    $db_var->join('master_settings DMS', 'DMS.master_id=BMS.pid', 'left');
                }
                if ($donor_id[0] != '' && $masterType != 'Donor') {
                    $db_var->where_in('DMS.master_id', $donor_id);
                } else if ($donor_id[0] != '') {
                    $db_var->where_in('ms.master_id', $donor_id);
                }
                $db_var->where('ms.master_type', $masterType);
            }
            if ($id != NULL) {
                $db_var->where('ms.master_id', $id);
                $db_var->select('ms.master_name');
            }
            $db_var->order_by('ms.master_name');
            $query = $db_var->get('master_settings ms');
    
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
            }
            $query->free_result();
            #echo'<pre>';print_r($data);die;
            return $data;
        }
    }




?>
  
