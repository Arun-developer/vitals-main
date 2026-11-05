<?php
#
# Model Class -  hs_quad_master_settings
#

class Mmilestone extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function insert($options = array(), $innovation)
    {
        foreach ($options['id'] as $key => $value):

            if ($options['id'][$key] == '') {
                $data = array(
                    'innovation' => $innovation,
                    'goal' => $options['goal'][$key],
                    'milestone' => $options['milestone'][$key],
                    'created_date' => date($this->config->item('mysqlDate')),
                    'created_by' => $this->session->userdata('emp_number'));
                $result = $this->db->insert('sf_milestone', $data);
            } else {
                $data1 = array(
                    'goal' => $options['goal'][$key],
                    'milestone' => $options['milestone'][$key]);
                $this->db->where('id', $options['id'][$key]);
                $result1 = $this->db->update('sf_milestone', $data1);
            }
        endforeach;
        return true;
    }

    #delete
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->db_debug = false;
        $result = $this->db->delete('sf_milestone');
        if (!$result) {
            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            return $num;
        }
        return '';
    }

    //getting list
    public function getMilestoneList($innovation)
    {
        $data = array();
        $this->db->select('sf_milestone.*');
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('sf_milestone');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
