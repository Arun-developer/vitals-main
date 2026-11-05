<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Mfellow extends CI_Model
{
    public function add_kra($options)
    {
        for ($i = 0; $i < php72_count($options['kra']); $i++) {
            $data = array('employee' => $options['employee'],
                'from_date' => $options['from-date'],
                'to_date' => $options['to-date'],
                'kra' => $options['kra'][$i],
                'kpi' => $options['kpi'][$i]);
            $this->db->insert('kra_master', $data);
        }
        return true;
    }
    public function getkra_list()
    {
        $query = "SELECT * FROM kra_master";
        $result = $this->db->query($query);
        return $result->result_array();
    }
}
