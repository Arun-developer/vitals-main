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
                $milestone_id = $this->db->insert_id();
                $data2 = array('innovation' => $innovation,
                    'milestone' => $milestone_id,
                    'amount' => $options['amount'][$key],
                    'installment' => $options['installment_id'][$key],
                    'companyamt' => $options['companyamt'][$key]);
                $this->db->insert('sf_activities', $data2);
                $result = $this->db->insert('sf_milestone_history', $data);
            } else {
                $data1 = array(
                    'goal' => $options['goal'][$key],
                    'milestone' => $options['milestone'][$key]);
                $this->db->where('id', $options['id'][$key]);
                $result1 = $this->db->update('sf_milestone', $data1);
                $data2 = array(
                    'amount' => $options['amount'][$key],
                    'installment' => $options['installment_id'][$key],
                    'companyamt' => $options['companyamt'][$key]);
                $this->db->where('milestone', $options['id'][$key]);
                $result2 = $this->db->update('sf_activities', $data2);
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
        $bdquery = "SELECT SFM.*,SFA.amount,SFA.companyamt,SFA.companyname,SFA.installment from sf_milestone as SFM LEFT JOIN sf_activities as SFA ON(SFA.milestone = SFM.id) where SFM.innovation = $innovation";
        $query = $this->db->query($bdquery);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getMilestoneLists($goals, $innovation)
    {

        $data = array();
        $this->db->select('sf_milestone.*');
        $this->db->where('innovation', $innovation);
        $this->db->where('goal', $goals);
        $query = $this->db->get('sf_milestone');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getactivityLists($installments, $innovation)
    {
        $data = array();
        $this->db->select('sf_activities.*');
        $this->db->where('innovation', $innovation);
        $this->db->where('installment', $installments);
        $query = $this->db->get('sf_activities');
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
