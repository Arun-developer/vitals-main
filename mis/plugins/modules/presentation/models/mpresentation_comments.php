<?php
class Mpresentation_comments extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function insert($innovation, $form)
    {
        $data = array(
            'innovation' => $innovation,
            'comments' => $form['comments'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('presentation_comments', $data);
        return true;
    }
    public function update($form)
    {
        $data = array(
            'comments' => $form['comments'],
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'),
        );
        $this->db->where('id', $form['id']);
        $this->db->update('presentation_comments', $data);
        return true;
    }
    public function delete($id = null)
    {
        if ($id != null) {
            $this->db->where('id', $id);
            $this->db->delete('presentation_comments');
        }
        return true;
    }
    public function getComments($innovation)
    {
        $data = array();
        $this->db->select('A.*');
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = A.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = A.modified_by) as modified_emp", false);
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('presentation_comments A');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
}
