<?php
class Mscreening_documents extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function assignChecklist($form = array())
    {

        $data = array('innovation' => $form['innovation'],
            'checklist' => php72_implode(',', $form['checklist']));
        if ($this->checkDuplicateChecklist($form['innovation'])) {
            $this->db->insert('checklist_innovation', $data);
        } else {
            $this->db->where('innovation', $form['innovation']);
            $this->db->update('checklist_innovation', $data);
        }
        return true;
    }
    public function checkDuplicateChecklist($innovation)
    {
        $this->db->where('innovation', $innovation);
        $result = $this->db->get('checklist_innovation');
        if ($result->num_rows() > 0) {
            return false;
        }
        return true;
    }
    public function getAssignedChecklist($innovation)
    {
        $data = array();
        $this->db->select("checklist");
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('checklist_innovation');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = explode(',', $row['checklist']);
            }
        }
        return $data;
    }

    public function getAssignedPeople($innovation)
    {
        $data = array();
        $this->db->select("checklist");
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('checklist_innovation');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = explode(',', $row['checklist']);
            }
        }
        return $data;
    }

    public function getInnovationPeopleByStatus($innovation)
    {
        $data = array();
        $this->db->select('PM.criteria,CM.comments,CM.documents,PM.category,PM.place,PM.date,PM.status,DP.field,DP.answer,DP.comments,DP.documents');
        $this->db->where('PM.status', '1');
        $this->db->join('screening_assesment_comments as CM', 'PM.innovation = CM.innovation', 'left');
        $this->db->join('document_to_produce as DP', 'DP.innovation = CM.innovation', 'left');
        $query = $this->db->get('people_meet as PM');
        $data = $query->result_array();

        $query->free_result();

        return $data;
    }

    public function getInnovationCheckList($innovation, $checklist = array())
    {
        $data = array();
        $this->db->select("CM.*,(select master_name from master_settings where id=CM.area) as master_name");
        $this->db->select("(select SD.documents from screening_documents SD where SD.checklist=CM.id and SD.innovation='$innovation')
								as documents");
        $this->db->order_by('CM.area', 'asc');
        $this->db->where('CM.status', '1');
        $checklist = (php72_count($checklist) == 0) ? array('') : $checklist;
        $this->db->where_in('CM.id', $checklist);
        $query = $this->db->get('checklist_master CM');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function insertDocuments($id, $form = array())
    {
        $innovation = $form['innovation'];
        $innovation = $id;

        unset($form['innovation']);
        unset($form['txtSubmit']);
        unset($form['name_of_enterprise']);

        foreach ($form as $key => $value):
            if (!empty($value)) {
                if (preg_match('/olddocument_/', $key) != 1) {
                    $data = array('innovation' => $innovation,
                        'checklist' => $key,
                        'documents' => $value);
                    if ($this->checkDuplicateDocuments($innovation, $key)) {
                        $this->db->insert('screening_documents', $data);
                    } else {

                        $this->db->where('innovation', $innovation);
                        $this->db->where('checklist', $key);
                        $this->db->update('screening_documents', $data);
                    }
                }
            }
        endforeach;
    }
    public function checkDuplicateDocuments($innovation, $checklist)
    {
        $this->db->where('innovation', $innovation);
        $this->db->where('checklist', $checklist);
        $result = $this->db->get('screening_documents');
        if ($result->num_rows() > 0) {
            return false;
        }
        return true;
    }
    public function getInnovationCheckListView($innovation)
    {
        $data = array();
        $this->db->select("CM.*,(select master_name from master_settings where id=CM.area) as master_name");
        $this->db->select("(select SD.documents from screening_documents SD where SD.checklist=CM.id and SD.innovation='$innovation')
								as documents");
        $this->db->order_by('CM.area', 'asc');
        $this->db->where('CM.status', '1');
        $query = $this->db->get('checklist_master CM');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
}
