<?php
class Minvitation extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }

    public function getinvite($innovation, $id)
    {
        $data = array();
        $query = "SELECT * from invite_prescreen where id = '" . $id . "'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    //invitation
    public function getInviteInfo($id)
    {
        $data = array();
        $this->db->select("IP.*");
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = IP.created_by) as created_emp", false);
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = IP.modified_by) as modified_emp", false);

        $this->db->where('IP.innovation', $id);

        $query = $this->db->get('invite_prescreen IP');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function insertInvitation($id, $form)
    {
        $data = array('email' => $form['email'],
            'invite_code' => $form['invite_code'],
            'innovation' => $id,
            'subject' => $form['subject'],
            'description' => $form['description'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'),
        );
        $this->db->insert('invite_prescreen', $data);

        #update status in inovation pool table
        $this->db->set('prescreen_invite', '1');
        $this->db->where('id', $id);
        $this->db->update('innovation_pool');
        #inserting in innovation_mail_history
        $data2 = array(
            'from' => $form['email'],
            'innovation' => $id,
            'subject' => $form['subject'],
            'body' => $form['description'],
            'send_by' => $this->session->userdata('emp_name'),
            'sent_date' => date($this->config->item('mysqlDate')),
            'mail_type' => 'invite_prescreen');
        $this->db->insert('innovation_mail_history', $data2);
        #send mail to innovator
        $this->load->model('common/Minnovation_mail');
        $this->Minnovation_mail->invitation_mail($id);
        return true;
    }
    public function reInvitation($id, $form)
    {
        $data = array(
            'email' => $form['email'],
            'subject' => $form['subject'],
            'description' => $form['description'],
            'modified_date' => date($this->config->item('mysqlDate')),
            'modified_by' => $this->session->userdata('emp_number'),
        );
        $this->db->where('innovation', $id);
        $this->db->update('invite_prescreen', $data);
        $data2 = array(
            'from' => $form['email'],
            'innovation' => $id,
            'subject' => $form['subject'],
            'body' => $form['description'],
            'send_by' => $this->session->userdata('emp_number'),
            'sent_date' => date($this->config->item('mysqlDate')),
            'mail_type' => 'invite_prescreen');
        $this->db->insert('innovation_mail_history', $data2);
        #send mail to innovator
        $this->load->model('common/Minnovation_mail');
        $this->Minnovation_mail->invitation_mail($id, $form);
        return true;
    }
    public function changeInvitationStatus($id, $status)
    {
        $idexist = $this->checkinvitation($id);
        if (php72_cmp($idexist) != 0) {
            $this->db->set('status', $status);
            $this->db->where('innovation', $id);
            $this->db->update('invite_prescreen');
            return true;
        } else {
            return false;
        }
    }
    public function checkinvitation($id)
    {
        $this->db->where('innovation', $id);
        $query = $this->db->get('invite_prescreen');
        return $query->num_rows();

    }
    public function getInvitationByCode($code)
    {
        $data = array();
        $this->db->where('invite_code', $code);
        $query = $this->db->get('invite_prescreen');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
}
