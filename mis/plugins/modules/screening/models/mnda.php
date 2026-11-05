<?php
class Mnda extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function getNdaList($innovation = '', $id = '')
    {
        $data = array();
        $this->db->select("ND.*");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = ND.created_by) as created_emp", false);
        $this->db->where('ND.innovation', $innovation);

        if ($id != '') {
            $this->db->where('ND.id', $id);
        }

        $query = $this->db->get('nda_document ND');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getNdaListPending($innovation)
    {
        $data = array();
        $this->db->where('innovation', $innovation);
        $this->db->where('copy2', '');
        $query = $this->db->get('nda_document');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function insertNda($id, $form)
    {
        $data = array('innovation' => $id,
            'copy1' => $form['copy1'],
            'copy1_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('nda_document', $data);
        return true;
    }

    public function updateCopy1($id, $form)
    {
        $data = array('copy1' => $form['copy1']);
        $this->db->where('id', $id);
        $this->db->update('nda_document', $data);
        $this->updateCopy2($id, $form);
        return true;
    }
    public function updateCopy2($id, $form)
    {
        $data = array('copy2' => $form['copy1'], 'copy2_date' => date($this->config->item('mysqlDate')));
        $this->db->where('id', $id);
        $this->db->update('nda_document', $data);
        return true;
    }
    public function changeNdaStatus($id, $status)
    {
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $this->db->update('nda_document');
        return true;
    }
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('nda_document');
        return true;
    }

}
