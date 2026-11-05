<?php
class Mcycle extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
        $this->load->model('master/Msource');
        $this->load->model('master/Mmaster_settings');
    }
    public function updateCycle($id, $form)
    {
        $this->db->set('cycle', $form['cycle']);
        $this->db->set('comments', $form['comments']);
        $this->db->set('created_by', $this->session->userdata('emp_number'));
        $this->db->set('created_date', date($this->config->item('mysqlDate')));
        $this->db->set('innovation', $id);
        $this->db->insert('incubation_cycle');
        $this->load->model('common/Minnovation_mail');
        $this->Minnovation_mail->assign_cycle($id);
        return true;
    }
    public function getCycleHistory($innovation)
    {
        $data = array();
        $this->db->select("IC.*");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = IC.created_by) as created_emp", false);
        $this->db->select("(select master_name from master_settings where id=IC.cycle) as cycle_name");
        $this->db->where('IC.innovation', $innovation);
        $query = $this->db->get('incubation_cycle IC');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getIncubationCycle($innovation)
    {
        $data = array();
        $this->db->select("IC.*");
        $this->db->select("(select master_name from master_settings where id=IC.cycle) as cycle_name");
        $this->db->where('IC.innovation', $innovation);
        $this->db->order_by('IC.id', 'DESC');
        $this->db->limit('1', '0');
        $query = $this->db->get('incubation_cycle IC');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

}
