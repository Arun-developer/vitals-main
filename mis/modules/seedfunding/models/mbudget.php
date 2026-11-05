<?php
#
# Model Class -  hs_quad_master_settings
#

class Mbudget extends CI_Model
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
                    'installment' => $options['installment'][$key],
                    'budget' => $options['budget'][$key],
                    'lineitem' => $options['lineitem'][$key],
                    'budgetamt' => $options['budgetamt'][$key],
                    'created_date' => date($this->config->item('mysqlDate')),
                    'created_by' => $this->session->userdata('emp_number'));
                $result = $this->db->insert('sf_budget', $data);

                $result = $this->db->insert('sf_budget_history', $data);
            } else {
                $data1 = array(
                    'goal' => $options['goal'][$key],
                    'milestone' => $options['milestone'][$key],
                    'installment' => $options['installment'][$key],
                    'budget' => $options['budget'][$key],
                    'lineitem' => $options['lineitem'][$key],
                    'budgetamt' => $options['budgetamt'][$key]);
                $this->db->where('id', $options['id'][$key]);
                $result1 = $this->db->update('sf_budget', $data1);
            }
        endforeach;
        return true;
    }

    #delete
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->db_debug = false;
        $result = $this->db->delete('sf_budget');
        if (!$result) {
            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            return $num;
        }
        return '';
    }

    //getting list
    public function getbudgetList($innovation)
    {
        $data = array();
        $this->db->select('sf_budget.*');
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('sf_budget');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getbudgetLists($goals, $innovation)
    {
        $data = array();
        $this->db->select('sf_budget.*');
        $this->db->where('innovation', $innovation);
        $this->db->where('installment', $goals);
        $query = $this->db->get('sf_budget');
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
    public function getbudgethistory($innovation)
    {
        $data = array();
        $this->db->select('sf_budget_history.*');
        $this->db->where('innovation', $innovation);
        $this->db->order_by('incubationplan_version');
        $query = $this->db->get('sf_budget_history');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
