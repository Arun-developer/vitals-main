<?php
class Mscreening_comments extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function insertComments($innovation, $criteria, $form)
    {
        $data = array('criteria' => $criteria,
            'innovation' => $innovation,
            'comments' => $form['comments'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('screening_comments', $data);
        return true;
    }
    public function updateComments($form)
    {
        $data = array(
            'comments' => $form['comments'],
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'),
        );
        $this->db->where('id', $form['id']);
        $this->db->update('screening_comments', $data);
        return true;
    }
    public function deleteComments($id = null)
    {
        if ($id != null) {
            $this->db->where('id', $id);
            $this->db->delete('screening_comments');
        }
        return true;
    }
    public function getScreeningComments($innovation, $criteria)
    {
        $data = array();
        $this->db->select('A.*');
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = A.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = A.modified_by) as modified_emp", false);
        $this->db->where('innovation', $innovation);
        $this->db->where('criteria', $criteria);
        $query = $this->db->get('screening_comments A');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
}
