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
                    'to' => $options['to'][$key],
                    'amount' => $options['amount'][$key]);
                $result = $this->db->insert('sf_installments', $data);
            } else {
                $data1 = array(
                    'from' => $options['from'][$key],
                    'to' => $options['to'][$key],
                    'amount' => $options['amount'][$key]);
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
        $this->db->select('sf_installments.*,(select sum(amount) from sf_installments where innovation = sf_installments.innovation) as total_amount');
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
    public function getInstallmentDetails($installment)
    {
        $data = array();
        $this->db->select('sf_installments.*');
        $this->db->where('id', $installment);
        $query = $this->db->get('sf_installments');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
