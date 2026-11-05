<?php
class Magreement extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function checkDuplicateAgreement($innovation)
    {
        $this->db->where('innovation', $innovation);
        $result = $this->db->get('innovation_agreement');
        if ($result->num_rows() > 0) {
            return false;
        }
        return true;
    }
    public function insertAgreement($innovation, $agreement)
    {
        $data = array('innovation' => $innovation,
            'agreement' => $agreement);
        $this->db->insert('innovation_agreement', $data);
        $this->db->insert('innovation_agreement_history', $data);
    }
    public function updateAgreement($form = array())
    {
        $version = $this->getlastversion($form['innovation']);
        $versions = $version[0]['version'];
        if ($versions != '') {

            $versions += 1;
        } else {
            $versions = 1;
        }

        $this->db->set('agreement', $form['agreement']);
        $this->db->where('innovation', $form['innovation']);
        $this->db->update('innovation_agreement');
        $this->db->set('agreement', $form['agreement']);
        $this->db->set('innovation', $form['innovation']);
        $this->db->set('modified_by', $this->session->userdata('user_name'));
        $this->db->set('version', $versions);
        $date = date('Y/m/d');
        $this->db->set('modified_date', $date);
        $this->db->insert('innovation_agreement_history');
        return true;
    }
    public function getlastversion($innovation)
    {
        $query = "select max(version) as version from innovation_agreement_history where innovation = " . $innovation;
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function updateAgreementStatus($innovation)
    {
        $this->db->set('status', '1');
        $this->db->where('innovation', $innovation);
        $this->db->update('innovation_agreement');
        return true;
    }
    public function updateSignedCopy1($form)
    {
        $this->db->set('signed_copy1', $form['signed_document']);
        $this->db->set('signed_copy1_date', date($this->config->item('mysqlDate')));
        $this->db->where('innovation', $form['innovation']);
        $this->db->update('innovation_agreement');
        return true;
    }
    public function updateSignedCopy2($form)
    {
        $this->db->set('signed_copy2', $form['signed_document']);
        $this->db->set('signed_copy2_date', date($this->config->item('mysqlDate')));
        $this->db->where('innovation', $form['innovation']);
        $this->db->update('innovation_agreement');
        return true;
    }
    public function getInnovationAgreement($innovation)
    {
        $data = array();
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('innovation_agreement');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getAgreementComments($innovation)
    {
        $data = array();
        $this->db->select('A.*');
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = A.created_by) as created_emp", false);
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('agreement_comments A');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getactionhistory($id)
    {
        $data = array();
        $this->db->select('A.*');
        $this->db->where('innovation', $id);
        $query = $this->db->get('innovation_agreement_history A');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;

            }
        }
        return $data;
    }
    public function showagreement($id)
    {
        $this->db->select('agreement');
        $this->db->where('id', $id);
        $query = $this->db->get('innovation_agreement_history');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;

    }
    public function insertAgreementComments($id, $form)
    {
        $data = array('innovation' => $id,
            'comments' => $form['comments'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('agreement_comments', $data);
        return true;
    }
    public function deleteAgreementComments($id)
    {
        if ($id != null) {
            $this->db->where('id', $id);
            $this->db->delete('agreement_comments');
        }
        return true;
    }

}
