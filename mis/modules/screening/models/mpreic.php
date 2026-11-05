<?php

class Mpreic extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

        $this->hris = $this->load->database('hris', true);

    }

    public function sendPreIC($form)
    {
        $data = array(
            'innovation' => $form['innovation'],
            'email' => $form['email'],
            'subject' => $form['subject'],
            'body' => $form['body'],
            'created_date' => date('Y-m-d'),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('pre_ic_mail', $data);
        $this->load->model('common/Minnovation_mail');
        $this->Minnovation_mail->send_pre_ic($form);
        $this->Minnovation->updatePreIc($form['innovation']);
    }

    public function resendPreIC($form)
    {

        $data = array(

            'innovation' => $form['innovation'],

            'email' => $form['email'],

            'subject' => $form['subject'],

            'body' => $form['body'],

            'modified_date' => date($this->config->item('mysqlDate')),

            'modified_by' => $this->session->userdata('emp_number'),

        );

        $this->db->where('innovation', $form['innovation']);

        $this->db->update('pre_ic_mail', $data);

        $this->load->model('common/Minnovation_mail');

        $this->Minnovation_mail->send_pre_ic($form);

    }

    public function getSentMail($innovation)
    {

        $data = array();

        $this->db->select('A.*');

        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = A.created_by) as created_emp", false);

        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = A.modified_by) as modified_emp", false);

        $this->db->where('innovation', $innovation);

        $query = $this->db->get('pre_ic_mail A');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;

            }

        }

        $query->free_result();

        return $data;

    }

    public function insertPreICComments($form)
    {

        $data = array(

            'innovation' => $form['innovation'],

            'comments' => $form['comments'],

            'created_date' => date($this->config->item('mysqlDate')),

            'created_by' => $this->session->userdata('emp_number'),

        );

        $this->db->insert('innovation_preiccomments', $data);

        return true;

    }

    public function updatePreICComments($form)
    {

        $data = array(

            'comments' => $form['comments'],

            'modified_date' => date($this->config->item('mysqlDate')),

            'modified_by' => $this->session->userdata('emp_number'),

        );

        $this->db->where('id', $form['id']);

        $this->db->update('innovation_preiccomments', $data);

        return true;

    }

    public function deletePreICComments($id = null)
    {

        if ($id != null) {

            $this->db->where('id', $id);

            $this->db->delete('innovation_preiccomments');

        }

        return true;

    }

    public function getPreICComments($innovation)
    {

        $data = array();

        $this->db->select('A.*');

        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = A.created_by) as created_emp", false);

        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = A.modified_by) as modified_emp", false);

        $this->db->where('innovation', $innovation);

        $query = $this->db->get('innovation_preiccomments A');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;

            }

        }

        $query->free_result();

        return $data;

    }

}
