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
            'created_by' => "",
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
    public function insertboardResulation_file($options = array())
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
        $result = $this->db->insert('boardresulation_file', $data);
        return $result;
    }

    //pitch document insert
    public function insertpitchDocument_file($options = array())
    {

        $filename = str_replace(' ', '_', $options['filename']);
        $currentdate = date('Y-m-d');
        $data = array(
            'request_id' => $options['requestid'],
            'document' => $filename,
            'created_date' => $currentdate,
            'created_by' => "",
            'modified_date' => "",
            'modified_by' => "",
        );
        $result = $this->db->insert('pitchdocument_file', $data);
        return $result;
    }

    public function deleteDocByID($id = null, $docName = null)
    {

        $this->db->where('document', $docName);
        $this->db->where('request_id', $id);
        $result = $this->db->delete('pitchdocument_file');

        return $result;
    }

    public function deleteCommentsByID($id = null, $createdDate = null)
    {

        $this->db->where('created_date', $createdDate);
        $this->db->where('request_id', $id);
        $result = $this->db->delete('pitchdocument_comments');

        return $result;
    }

    public function selectpitch_file($innovationid = null, $requestid = null)
    {

        $data = array();
        $this->db->select("PF.*");
        $this->db->join('request_invester RI', 'RI.id = PF.request_id', 'left');
        $this->db->where('RI.innovation', $innovationid);
        $this->db->where("PF.request_id", $requestid);
        $query = $this->db->get('pitchdocument_file PF');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function insertpitch_comment($options = array())
    {
        $currentdate = date('Y-m-d');
        $data = array(
            'request_id' => $options['requestid'],
            'comments' => $options['comments'],
            'created_date' => $currentdate,
            'created_by' => "",
            'modified_date' => "",
            'modified_by' => "",
        );
        $result = $this->db->insert('pitchdocument_comments', $data);
        return $result;
    }

    public function selectpitch_comment($innovationid = null, $requestid = null)
    {
        $data = array();
        $this->db->select("PC.*");
        $this->db->join('request_invester RI', 'RI.id = PC.request_id', 'left');
        $this->db->where('RI.innovation', $innovationid);
        $this->db->where("PC.request_id", $requestid);
        $query = $this->db->get('pitchdocument_comments PC');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }
    //end pitch documents

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

    public function selectboardresolution_comment($innovationid = null, $requestid = null)
    {

        $data = array();
        $this->db->select("BC.*");
        $this->db->join('request_invester RI', 'RI.id = BC.request_id', 'left');
        $this->db->where('RI.innovation', $innovationid);
        $this->db->where("BC.request_id", $requestid);
        $query = $this->db->get('boardresolution_comments BC');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $query->free_result();
        return $data;
    }

    public function updateagreement_file($options = array())
    {
        if ($options['uploadby'] == 'Invester') {
            $field = 'invester_agreement';
        } else {
            $field = 'incubatee_agreement';
        }
        $dataup = array(
            $field => $options['filename'],
        );
        $this->db->where('id', $options['id']);

        $result = $this->db->update('assign_invester', $dataup);

        return $result;

    }

    public function findagreementDoc($id)
    {
        $data = array();
        $this->db->select("AI.invester_agreement,AI.incubatee_agreement");
        $this->db->where('AI.id', $id);
        $query = $this->db->get('assign_invester AI');
        return $query->row_array();
    }
}
