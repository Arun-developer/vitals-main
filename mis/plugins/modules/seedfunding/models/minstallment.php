<?php
#
# Model Class -  hs_quad_master_settings
#

class Minstallment extends CI_Model
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
                    'from' => $options['from'][$key],
                    'to' => $options['to'][$key]);
                $result = $this->db->insert('sf_installments', $data);
                $result = $this->db->insert('sf_installments_history', $data);
            } else {
                $data1 = array(
                    'from' => $options['from'][$key],
                    'to' => $options['to'][$key]);
                $this->db->where('id', $options['id'][$key]);
                $result1 = $this->db->update('sf_installments', $data1);
            }
        endforeach;
        return true;
    }

    #delete
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->db_debug = false;
        $result = $this->db->delete('sf_installments');
        if (!$result) {
            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            return $num;
        }
        return '';
    }

    //getting list
    public function getInstallmentList($innovation)
    {
        $data = array();
        $this->db->select('sf_installments.*');
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('sf_installments');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getInstallmenthistory($innovation)
    {
        $data = array();
        $this->db->select('sf_installments_history.*,(select sum(amount) from sf_installments where innovation = sf_installments_history.innovation) as total_amount');
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('sf_installments_history');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getInstallmentDetails($innovation, $installment)
    {
        $data = array();
        $query = "select SI.id,sum(AA.vfunded)as vfunded,SI.from,SI.to from sf_installments as SI JOIN sf_activity_amount as AA ON(AA.installment = SI.id) WHERE SI.id ='" . $installment . "' AND  SI.innovation = '" . $innovation . "'";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data = $row;
            }
        }
        $result->free_result();
        return $data;
    }

}
