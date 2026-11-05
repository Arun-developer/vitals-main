<?php
#
# Model Class -  hs_quad_master_settings
#

class Massign_incubation extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function assignChecklist($form = array())
    {
        $data = array('innovation' => $form['innovation'],
            'checklist' => php72_implode(',', $form['checklist']));
        if ($this->checkDuplicateChecklist($form['innovation'])) {
            $this->db->insert('checklist_incubation', $data);
        } else {
            $this->db->where('innovation', $form['innovation']);
            $this->db->update('checklist_incubation', $data);
        }
        return true;
    }
    public function checkDuplicateChecklist($innovation)
    {
        $this->db->where('innovation', $innovation);
        $result = $this->db->get('checklist_incubation');
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

        $query = $this->db->get('checklist_incubation');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = explode(',', $row['checklist']);
            }
        }
        return $data;
    }
    public function getCheckList($innovation)
    {
        $dbquery = "SELECT PM.* from progress_master as PM
                         WHERE PM.innovation in (0," . $innovation . ") AND PM.type='metrices' ORDER BY PM.mastertype";
        $query = $this->db->query($dbquery);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getInnovationCheckListView($innovation)
    {
        $data = array();
        $this->db->select("PM.*,(select master_type from master_settings where id=PM.criteria) as master_name");
        $this->db->where('PM.status', '1');
        $this->db->where('PM.type', 'metrices');
        $this->db->order_by('PM.criteria');
        $query = $this->db->get('progress_master PM');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
