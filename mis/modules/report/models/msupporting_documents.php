<?php
class Msupporting_documents extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function insertSuportingDocuments($id, $form)
    {
        if (php72_count(@$form['document_type_value'])) {
            foreach ($form['document_type_value'] as $key => $value):
                $data = array('innovation' => $id,
                    'document_type' => $value,
                    'document' => $form['supporting_documents'][$key],
                    'youtube' => $form['youtubeValue'][$key],
                );
                $this->db->insert('innovation_document', $data);
            endforeach;
        }
    }
    public function insertSingleDocument($id, $form)
    {
        if (!empty($form['document'])) {
            $data = array('innovation' => $id,
                'document_type' => $form['document_type'],
                'document' => $form['document'],
                'youtube' => $form['youtube'],
            );
            $this->db->insert('innovation_document', $data);
            return true;
        } else {
            return false;
        }
    }
    public function getInnovationDocuments($innovation, $id = null)
    {
        $data = array();

        $this->db->select("ID.*,(select master_name from master_settings where id=ID.document_type) as document_type_value");
        if ($id != null) {
            $this->db->where('id', $id);
        }

        if ($innovation != null) {
            $this->db->where('innovation', $innovation);
        }

        $query = $this->db->get('innovation_document ID');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function deleteDocument($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('innovation_document');
    }
}
