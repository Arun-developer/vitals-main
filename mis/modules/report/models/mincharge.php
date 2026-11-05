<?php

class Mincharge extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
        $this->load->model('master/Msource');
        $this->load->model('master/Mmaster_settings');
    }

    public function assignIncharge($id, $innovation) {
        $emp = $this->input->post('associate_employee');
        foreach ($emp as $key => $value):
            $data = array('innovation' => $id,
                'associate_employee' => $value,
                'created_date' => date($this->config->item('mysqlDate')),
                'created_by' => $this->session->userdata('empNumber'));
            $this->db->insert('assign_associate', $data);
            $this->load->model('common/Minnovation_mail');
            if ($innovation['stage'] != '5') {
                $this->Minnovation_mail->assign($id, $value, $partner_id);
            }

        endforeach;
        return true;
    }

    public function removeOldIncharge($ids) {
        $this->db->set('status', 0);
        $this->db->where('innovation', $ids);
        $this->db->update('assign_associate');
    }

    public function removeIncharges($ids) {
        for ($i = 0; $i < php72_count($ids); $i++) {
            $this->db->set('status', 0);
            $this->db->where('innovation', $ids[$i]);
            $this->db->update('assign_associate');
        }
    }

    public function assignmulincharge($id, $employee, $partner_id, $pa_rd) {
        foreach ($employee as $key => $value) {
            $cnt = $this->checkalreadyassgined($id, $value);
            if ($cnt < 1) {

                $data = array('innovation' => $id,
                    'associate_employee' => $value,
                    'created_date' => date($this->config->item('mysqlDate')),
                    'created_by' => $this->session->userdata('empNumber'));
                $this->db->insert('assign_associate', $data);
                $this->load->model('common/Minnovation_mail');
                $this->Minnovation_mail->assign($id, $value, $partner_id, $pa_rd);
            } else {
                $this->session->set_flashdata('successMsg', 'Assigned Incharge successfully.');
            }
        }
    }

    public function checkalreadyassgined($id, $employee) {
        $this->db->select("*");
        $this->db->where('associate_employee', $employee);
        $this->db->where('innovation', $id);
        $this->db->where('status', '1');
        $query = $this->db->get('assign_associate');
        return $query->num_rows();
    }

    public function getSubsector($id) {
        $this->db->select("*");
        $this->db->where('parent_id', $id);
        $query = $this->db->get('sector_category');
        if ($query->num_rows() > 1) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getSectorNames($partner_id = '', $program = '') {
        $this->db->select("*");
        $this->db->where('parent_id', 0);
        if ($partner_id == '10') {
            $pitch_id = '3';
        } else {
            $pitch_id = '1';
        }

        if ($program == 'incubation') {
            $this->db->where('incubation', '1');
        } else {
            $this->db->where('pitch', $pitch_id);
        }

        $query = $this->db->get('sector_category');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function getSubsectorName($id) {
        $this->db->select("*");
        $this->db->where('id', $id);
        $query = $this->db->get('sector_category');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }
	
	public function get_state_city($state_id, $city_id) {
        $get_state = $get_city = array();
        if ($state_id != '') {
            $this->db->select("state_name");
            $this->db->where('id', $state_id);
            $query = $this->db->get('eir_state');
            if ($query->num_rows() > 0) {
                $get_state = $query->result_array();
            }
        }
        if ($city_id != '') {
            $this->db->select("city_name");
            $this->db->where('id', $city_id);
            $query = $this->db->get('eir_city');
            if ($query->num_rows() > 0) {
                $get_city = $query->result_array();
            }
        }
        $dataArr = php72_array_merge($get_state, $get_city);
        $result = '';
        if (!empty($dataArr)) {
            $result = $dataArr;
        }
        return $result;
    }

    public function getUsername($id) {
        $this->hris->select("emp_firstname");
        $this->hris->where('emp_number', $id);
        $query = $this->hris->get('hr_employee');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getSectors($id) {
        $data = array();
        $this->db->select("AA.*");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from " . $this->hris->database . ".hs_hr_employee where emp_number = AA.associate_employee) as emp_name", false);

        $this->db->where('AA.sector_id', $id);
        $query = $this->db->get('assigned_incharge AA');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getSectorLeads($id) {
        $data = array();
        $this->db->select("AA.*");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from " . $this->hris->database . ".hs_hr_employee where emp_number = AA.employee_id) as emp_name", false);

        $this->db->where('AA.sector_id', $id);
        $query = $this->db->get('assign_sector_lead AA');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getAssociate($options = array()) {
        $data = array();
        $this->db->select("AA.*");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from " . $this->hris->database . ".hs_hr_employee where emp_number = AA.associate_employee) as emp_name", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = AA.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = AA.modified_by) as modified_emp", false);

        if (!empty($options['innovation'])) {
            $this->db->where('AA.innovation', $options['innovation']);
        }

        if (!empty($options['associate'])) {
            $this->db->where('AA.associate_employee', $options['associate']);
        }

        $this->db->where('AA.status', '1');

        $query = $this->db->get('assign_associate AA');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getAssociateId($innovation) {
        $data = array();
        $this->db->select("associate_employee");
        $this->db->where('innovation', $innovation);
        $this->db->group_by('associate_employee');
        $query = $this->db->get('assign_associate');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row['associate_employee'];
            }
        }
        return $data;
    }

    public function getActiveIncharge($innovation) {
        $data = array();
        $this->db->select("associate_employee");
        $this->db->where('innovation', $innovation);
        $this->db->where('status', '1');
        $this->db->group_by('associate_employee');
        $query = $this->db->get('assign_associate');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row['associate_employee'];
            }
        }
        return $data;
    }

    public function getAssociateInnovation($emp_number = '') {
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

    public function isAssociateUser($id, $user = null) {

        $data = array();
        $this->db->select("id");
        $this->db->where('innovation', $id);
        $user = ($user == null) ? $this->session->userdata('emp_number') : $user;
        $this->db->where('associate_employee', $user);
        $this->db->where('status', '1');
        $query = $this->db->get('assign_associate');
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function changeAssociateStatus($id, $status) {
        $this->db->set('status', $status);
        $this->db->set('modified_date', date($this->config->item('mysqlDate')));
        $this->db->set('modified_by', $this->session->userdata('emp_number'));
        $this->db->where('id', $id);
        $this->db->update('assign_associate');
        return true;
    }

    public function getInnovationUncharge() {
        $query = "SELECT name_of_enterprise,id FROM innovation_pool ";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getStatusLog($id) {
        $this->db->select("*");
        $this->db->where('innovation_id', $id);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('application_status_log');
        return $query->result_array();
    }

    public function getIICLogDate($id) {
        $this->db->select("*");
        $this->db->where(array('innovation_id' => $id, 'stage' => '9', 'status' => '13'));
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('application_status_log');
        return $query->result_array();
    }

}
