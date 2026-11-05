<?php

#
# Model Class -  hs_quad_master_settings
#

class Malldocument extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getInnovationDocument($innovation) {
        $data = array();
        $this->db->select("business_plan_document ");
        $this->db->where('id', $innovation);
        $query = $this->db->get('innovation_pool');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function getincubateename($innovation) {
        $query = "SELECT user_name from incubatee where innovation  = '" . $innovation . "'";
        $result = $this->db->query($query);
        return $result->row_array();
    }

    function getgeneraldocument($innovation) {
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('upload_documents');
        return $query->result_array();
    }

    function getInnovationSupportingDocument($innovation) {
        $data = array();

        $this->db->select("ID.*,(select master_name from master_settings where id=ID.document_type) as document_type_value");

        if ($innovation != NULL)
            $this->db->where('innovation', $innovation);
        $query = $this->db->get('innovation_document ID');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    function getAssessmentDocument($innovation) {
        $data = array();
        $this->db->select("documents");
        $this->db->where('innvation', $innovation);
        $query = $this->db->get('assessment');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function getPresentationDocument($innovation) {
        $data = array();
        $this->db->select("document");
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('presentation');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function getscreenDoc($innovation) {
        $data = array();
        $this->db->select("answer");
        $this->db->join('screening_master SM', 'SM.id = S.field', 'left');
        $this->db->where('S.innovation', $innovation);
        $this->db->where('SM.input_type', 'File');
        $query = $this->db->get('screening S');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function getsignDoc($innovation) {
        $data = array();
        $sql = "SELECT signed_copy2 as signed_document from innovation_agreement WHERE innovation = '" . $innovation . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function insertdocuments($options) {
        $data = array('uploader_name' => $options['uploader_name'],
            'purpose_of_document' => $options['document_name'],
            'innovation' => $options['innovation'],
            'documents' => $options['files'],
            'created_date' => date('Y-m-d H:i:s'));

        $this->db->insert('upload_documents', $data);
        return $options['innovation'];
    }

}

?>