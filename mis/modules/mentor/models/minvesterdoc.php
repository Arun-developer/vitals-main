<?php

class Minvesterdoc extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insertbusiness_comment($options = array())
    {
        $currentdate = date('Y-m-d');
        $data = array(
            'request_id' => $options['requestid'],
            'comments' => $options['comments'],
            'created_date' => $currentdate,
            'created_by' => $options['description'],
            'modified_date' => "",
            'modified_by' => "",
        );
        $result = $this->db->insert('businessdocument_comments', $data);
        return $result;
    }

    public function selectbusiness_comment($innovationid = null, $requestid = null)
    {

        $data = array();
        $this->db->select("BC.*");
        $this->db->join('request_invester RI', 'RI.id = BC.request_id', 'left');
        $this->db->where('RI.innovation', $innovationid);
        $this->db->where("BC.request_id", $requestid);
        $query = $this->db->get('businessdocument_comments BC');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function insertbusiness_file($options = array())
    {
        $currentdate = date('Y-m-d');
        $data = array(
            'request_id' => $options['requestid'],
            'document' => $options['filename'],
            'created_date' => $currentdate,
            'created_by' => "",
            'modified_date' => "",
            'modified_by' => "",
        );
        $result = $this->db->insert('businessdocument_file', $data);
        return $result;
    }

    public function selectbusiness_file($innovationid = null, $requestid = null)
    {

        $data = array();
        $this->db->select("BF.*");
        $this->db->join('request_invester RI', 'RI.id = BF.request_id', 'left');
        $this->db->where('RI.innovation', $innovationid);
        $this->db->where("BF.request_id", $requestid);
        $query = $this->db->get('businessdocument_file BF');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
