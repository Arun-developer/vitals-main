<?php
#
# Model Class -  hs_quad_master_settings
#

class Mcompany extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function insertBoard($options = array(), $innovation)
    {
        if (!empty($options['id'])) {
            foreach ($options['id'] as $key => $value):

                if ($options['id'][$key] == '') {
                    $data = array(
                        'innovation' => $innovation,
                        'members' => $options['members'][$key],
                        'designation' => $options['designation'][$key],
                        'profile' => $options['profile'][$key],
                        'year' => $options['year'][$key],
                        'email' => $options['email'][$key],
                        'created_date' => date($this->config->item('mysqlDate')),
                        'created_by' => $this->session->userdata('emp_number'));
                    $result = $this->db->insert('board_details', $data);
                } else {
                    $data1 = array(
                        'members' => $options['members'][$key],
                        'designation' => $options['designation'][$key],
                        'profile' => $options['profile'][$key],
                        'year' => $options['year'][$key],
                        'email' => $options['email'][$key],
                        'modified_date' => date($this->config->item('mysqlDate')),
                        'modified_by' => $this->session->userdata('emp_number'));
                    $this->db->where('id', $options['id'][$key]);
                    $result1 = $this->db->update('board_details', $data1);
                }
            endforeach;
            return true;
        }
    }

    #delete
    public function deleteBoard($id)
    {
        $this->db->where('id', $id);
        $this->db->db_debug = false;
        $result = $this->db->delete('board_details');
        if (!$result) {
            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            return $num;
        }
        return '';
    }

    //getting list
    public function getBoardList($innovation)
    {
        $data = array();
        $this->db->select('board_details.*');
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('board_details');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function insertInvestment($options = array(), $innovation)
    {
        foreach ($options['id'] as $key => $value):

            if ($options['id'][$key] == '') {
                $data = array(
                    'innovation' => $innovation,
                    'funding_details' => $options['funding_details'][$key],
                    'amount' => $options['amount'][$key],
                    'nature_source' => $options['nature_source'][$key],
                    'ownership' => $options['ownership'][$key],
                    'year' => $options['year'][$key],
                    'created_date' => date($this->config->item('mysqlDate')),
                    'created_by' => $this->session->userdata('emp_number'));
                $result = $this->db->insert('investment_details', $data);
            } else {

                $data1 = array(

                    'funding_details' => $options['funding_details'][$key],
                    'amount' => $options['amount'][$key],
                    'nature_source' => $options['nature_source'][$key],
                    'ownership' => $options['ownership'][$key],
                    'year' => $options['year'][$key],
                    'modified_date' => date($this->config->item('mysqlDate')),
                    'modified_by' => $this->session->userdata('emp_number'));

                $this->db->where('id', $options['id'][$key]);
                $result1 = $this->db->update('investment_details', $data1);
            }
        endforeach;
        return true;
    }

    #delete
    public function deleteInvestment($id)
    {
        $this->db->where('id', $id);
        $this->db->db_debug = false;
        $result = $this->db->delete('investment_details');
        if (!$result) {
            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            return $num;
        }
        return '';
    }

    //getting list
    public function getInvestmentList($innovation)
    {
        $data = array();
        $this->db->select('investment_details.*');
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('investment_details');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function insertFinancial($options = array(), $innovation)
    {
        foreach ($options['id'] as $key => $value):

            if ($options['id'][$key] == '') {
                $data = array(
                    'innovation' => $innovation,
                    'revenue' => $options['revenue'][$key],
                    'cogs' => $options['cogs'][$key],
                    'expense' => $options['expense'][$key],
                    'profit' => $options['profit'][$key],
                    'no_employees' => $options['no_employees'][$key],
                    'senior' => $options['senior'][$key],
                    'middle' => $options['middle'][$key],
                    'lower' => $options['lower'][$key],
                    'year' => $options['year'][$key],
                    'created_date' => date($this->config->item('mysqlDate')),
                    'created_by' => $this->session->userdata('emp_number'));
                $result = $this->db->insert('financial_details', $data);
            } else {
                $data1 = array(
                    'revenue' => $options['revenue'][$key],
                    'cogs' => $options['cogs'][$key],
                    'expense' => $options['expense'][$key],
                    'profit' => $options['profit'][$key],
                    'no_employees' => $options['no_employees'][$key],
                    'senior' => $options['senior'][$key],
                    'middle' => $options['middle'][$key],
                    'lower' => $options['lower'][$key],
                    'year' => $options['year'][$key],
                    'modified_date' => date($this->config->item('mysqlDate')),
                    'modified_by' => $this->session->userdata('emp_number'));
                $this->db->where('id', $options['id'][$key]);
                $result1 = $this->db->update('financial_details', $data1);
            }
        endforeach;
        return true;
    }

    #delete
    public function deleteFinancial($id)
    {
        $this->db->where('id', $id);
        $this->db->db_debug = false;
        $result = $this->db->delete('financial_details');
        if (!$result) {
            $msg = $this->db->_error_message();
            $num = $this->db->_error_number();
            return $num;
        }
        return '';
    }

    //getting list
    public function getFinancialList($innovation)
    {
        $data = array();
        $this->db->select('financial_details.*');
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('financial_details');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
