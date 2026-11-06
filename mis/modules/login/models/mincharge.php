<?php
class Mincharge extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Msource');
        $this->load->model('master/Mmaster_settings');
    }
    public function assignIncharge($id, $innovation)
    {
        $emp = $this->input->post('associate_employee');
        foreach ($emp as $key => $value):
            $data = array('innovation' => $id,
                'associate_employee' => $value,
                'created_date' => date($this->config->item('mysqlDate')),
                'created_by' => $this->session->userdata('empNumber'));
            $this->db->insert('assign_associate', $data);
            $this->load->model('common/Minnovation_mail');
            if ($innovation['stage'] != '5') {
                $this->Minnovation_mail->assign($id, $value);
            }

        endforeach;
        return true;
    }

    public function assignmulincharge($id, $employee)
    {
        foreach ($employee as $key => $value) {
            $cnt = $this->checkalreadyassgined($id, $value);
            if (php72_cmp($cnt) < 1) {

                $data = array('innovation' => $id,
                    'associate_employee' => $value,
                    'created_date' => date($this->config->item('mysqlDate')),
                    'created_by' => $this->session->userdata('empNumber'));
                $this->db->insert('assign_associate', $data);
                $this->load->model('common/Minnovation_mail');
                $this->Minnovation_mail->assign($id, $value);

            } else {
                $this->session->set_flashdata('errorMsg', 'Employee Already Assigned as Incharge');
            }

        }

    }

    public function checkalreadyassgined($id, $employee)
    {
        $this->db->select("*");
        $this->db->where('associate_employee', $employee);
        $this->db->where('innovation', $id);
        $query = $this->db->get('assign_associate');
        return $query->num_rows();
    }

    public function getAssociate($options = array())
    {
        $data = array();
        $this->db->select("AA.*");
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from hr_user_profile where id = AA.associate_employee) as emp_name", false);
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from  hr_user_profile where id = AA.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_first_name,emp_last_name) from  hr_user_profile where id = AA.modified_by) as modified_emp", false);

        if (!empty($options['innovation'])) {
            $this->db->where('AA.innovation', $options['innovation']);
        }

        if (!empty($options['associate'])) {
            $this->db->where('AA.associate_employee', $options['associate']);
        }

        if (!empty($options['active'])) {
            $this->db->where('AA.status', '1');
        }

        $query = $this->db->get('assign_associate AA');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getAssociateId($innovation)
    {
        $data = array();
        $this->db->select("associate_employee");
        $this->db->where('innovation', $innovation);
        $this->db->where('status', '1');
        $query = $this->db->get('assign_associate');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row['associate_employee'];
            }
        }
        return $data;
    }
    public function getAssociateInnovation($emp_number = '')
    {
        $data = array();
        $this->db->select("innovation");
        $this->db->where('associate_employee', $emp_number);
        $this->db->where('status', '1');
        $query = $this->db->get('assign_associate');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row['innovation'];
            }
        }
        return $data;
    }
    public function isAssociateUser($id, $user = null)
    {
        $data = array();
        $this->db->select("id");
        $this->db->where('innovation', $id);
        $user = ($user == null) ? $this->session->userdata('emp_number') : $user;
        $this->db->where('associate_employee', $user);
        $query = $this->db->get('assign_associate');
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;

    }
    public function changeAssociateStatus($id, $status)
    {
        $this->db->set('status', $status);
        $this->db->set('modified_date', date($this->config->item('mysqlDate')));
        $this->db->set('modified_by', $this->session->userdata('emp_number'));
        $this->db->where('id', $id);
        $this->db->update('assign_associate');
        return true;
    }
    public function getInnovationUncharge()
    {
        $query = "SELECT name_of_enterprise,id FROM innovation_pool ";
        $result = $this->db->query($query);
        return $result->result_array();
    }

}
