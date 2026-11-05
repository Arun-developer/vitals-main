<?php
class Mpresentation extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
        $this->table = 'presentation';
        $this->load->model('master/Mmaster');
    }
    public function insert($innovation, $form)
    {
        $data = array('innovation' => $innovation,
            'description' => $form['document_description'],
            'document' => $form['document'],
            'description' => $form['description'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('presentation', $data);
        return true;
    }
    public function update($form)
    {
        $data = array('document_description' => $form['document_description'],
            'document' => $form['document'],
            'description' => $form['description'],
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'),
        );
        $this->db->where('id', $form['id']);
        $this->db->update('presentation', $data);
        return true;
    }
    public function getDetails($innovation, $id = null)
    {
        $data = array();
        $this->db->select('P.*');
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = P.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = P.modified_by) as modified_emp", false);

        $this->db->where('innovation', $innovation);

        if ($id != null) {
            $this->db->where('id', $id);
        }

        $query = $this->db->get('presentation P');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('presentation');
        $this->load->helper('debug');
        debug_last_query();
        return true;
    }

}
