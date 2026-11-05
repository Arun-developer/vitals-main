<?php
class Eirmodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Minnovation');
    }

    //* function to store the data in the table
    public function insert_data($table, $data)
    {
        if ($this->db->insert($table, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    //to validate existing mail id
    public function check_mail($mail)
    {
        $this->db->where('user_email', $mail);
        $query = $this->db->get('eir_user');
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    // Function to check the user existence
    public function user_check($table, $data)
    {
        $this->db->where($data);
        $this->db->select('id');
        $query = $this->db->get($table);
        if ($query->num_rows > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    /// function to update the user table
    /// insert and update the details in innovation table
    /// send a mail once the application was finished
    public function update_data($table, $data)
    {
        $status = $data['status'];
        $this->db->where('id', $this->input->post('applicant_id'));
        $this->db->update($table, $data);
        if ($this->input->post('innovation_id') == '') {
            $source = $this->fetch_source_data();

            $data = array(
                'source' => $source[0]['source'],
                'sourceType' => $source[0]['source_type'],
                'name_of_entrepreneur' => $this->input->post('applicant'),
                'phone_no' => $this->input->post('phone_no'),
                'mobile_no' => $this->input->post('mobile_no'),
                'email_id' => $this->input->post('email1'),
                'name_of_enterprise' => $this->input->post('organisation'),
                'stage' => '0',
                'status' => '4',
                'program' => '1',
                'created_date' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('innovation_pool', $data);
            $id = $this->db->insert_id();
            $this->Minnovation->updateInnovationNumber($id);
            $this->db->select('innovation_id');
            $this->db->where('id', $id);
            $query = $this->db->get('innovation_pool');
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $innovation_id = $row['innovation_id'];
                }
                $this->db->set('innovation_no', $innovation_id);
                $this->db->where('id', $this->input->post('applicant_id'));
                $this->db->update($table);
            }
        } else if ($status != 'completed') {
            $data = array(
                'name_of_entrepreneur' => $this->input->post('applicant'),
                'phone_no' => $this->input->post('phone_no'),
                'mobile_no' => $this->input->post('mobile_no'),
                'email_id' => $this->input->post('email1'),
                'name_of_enterprise' => $this->input->post('organisation'),
            );
            $this->db->where('innovation_id', $this->input->post('innovation_id'));
            $this->db->update('innovation_pool', $data);
        }

        if ($status == 'completed') {
            $this->db->set('status', '0');
            $this->db->where('innovation_id', $this->input->post('innovation_id'));
            $this->db->update('innovation_pool');

            $this->load->model('common/Minnovation_mail');
            $this->Minnovation_mail->EIR_innovation($this->input->post('applicant_id'));
        }

        return true;
    }

    ///////// function to update the details in EIR_team table
    public function update_team($table, $data, $app_id, $id)
    {
        $where = array('id' => $id, 'app_id' => $app_id);
        $this->db->where($where);
        $this->db->update($table, $data);
        return true;
    }

    /// to store documents in eir_ files
    public function insert_files($id, $data1, $data2)
    {
        $arr = array('app_id' => $id, 'resume' => $data1, 'additional_documents' => $data2);
        $this->db->insert('eir_files', $arr);

        return true;
    }

    //// function to update the details in EIR_app table
    public function update_app($table, $data, $app_id)
    {
        $this->db->where('app_id', $app_id);
        $this->db->update($table, $data);
        return true;
    }

    ///// function to fetch the details from the given table
    public function fetch_data($table, $id)
    {
        $this->db->select('*');
        if ($table == 'eir_user') {
            $this->db->where('id', $id);
        } else {
            $this->db->where('app_id', $id);
        }

        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function fetch_state()
    {
        $query = $this->db->get("eir_state");
        return $query->result_array();
    }

    public function fetch_city($name)
    {
        $data = array();
        $this->db->where('state_id', $name);
        $query = $this->db->get('eir_city');
        foreach ($query->result_array() as $city) {
            $data[$city['id']] = $city['city_name'];
        }
        return $data;
    }

    public function get_city_state($id, $name)
    {
        $query = $this->db->query("select city_name, state_name from eir_city join eir_state on eir_city.state_id = eir_state.id where eir_city.id='$id'");
        $res = $query->result_array();

        if ($name == 'state') {
            return $res[0]['state_name'];
        } else {
            return $res[0]['city_name'];
        }
    }

    ////////////// function to fetch the source type and source id for EIR application //////////////////////
    public function fetch_source_data()
    {
        $this->db->select('st.id as source_type,s.id as source');
        $this->db->join('source_master as s', 's.source_type = st.id');
        $this->db->where('st.master_type', 'Source Type');
        $this->db->where('st.master_name', 'EIR');
        $query = $this->db->get('master_settings as st');
        return $query->result_array();

    }
    //to fetch eir files from db
    public function eir_file($id)
    {
        $query = $this->db->query("select a.* from eir_files a join eir_user b on a.app_id=b.id where b.innovation_no='" . $id . "'");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function insert_files1($id, $data1, $data2)
    {
        $hid_id = $this->input->post('hresume');
        $add_id = $this->input->post('hdoc');

        if ($hid_id[0] != '' || $add_id[0] != '') {
            $update = array('resume' => $data1, 'additional_documents' => $data2);
            $this->db->where('app_id', $id);
            $this->db->update('eir_files', $update);
        } else {
            $arr = array('app_id' => $id, 'resume' => $data1, 'additional_documents' => $data2);
            $this->db->insert('eir_files', $arr);
        }
        return true;
    }

}
