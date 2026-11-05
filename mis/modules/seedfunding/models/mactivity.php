<?php
#
# Model Class -  hs_quad_master_settings
#

class Mactivity extends CI_Model
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
                    'milestone' => $options['milestone'][$key],
                    'activity' => $options['activity'][$key],
                    'created_date' => date($this->config->item('mysqlDate')),
                    'created_by' => $this->session->userdata('emp_number'));
                $result = $this->db->insert('sf_activities', $data);
                $result = $this->db->insert('sf_activities_history', $data);
            } else {
                $data1 = array(
                    'innovation' => $innovation,
                    'activity' => $options['activity'][$key],
                    'created_date' => date($this->config->item('mysqlDate')),
                    'milestone' => $options['milestone'][$key]);
                $this->db->where('id', $options['id'][$key]);
                $result1 = $this->db->update('sf_activities', $data1);
                $this->db->insert('sf_activities_history', $data1);
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
    public function getActivityList($innovation)
    {
        $data = array();
        $buildquery = "SELECT SFA.*,SFM.goal as goal FROM sf_activities as SFA LEFT JOIN sf_milestone as SFM ON (SFA.milestone = SFM.id) WHERE SFA.innovation =" . $innovation;

        $query = $this->db->query($buildquery);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getMilestonehistory($innovation)
    {
        $data = array();
        $this->db->select('sf_milestone_history.*');
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('sf_milestone_history');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
