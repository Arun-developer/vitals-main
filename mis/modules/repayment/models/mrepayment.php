<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * Repayment Model Page
 *
 * @ControllerName     mrepayment.php
 * @Author             Sanjoy Dey
 * @Created Date       1-12-2011
 * @Modified Date      4-12-2011
 * @Modified By        Sanjoy Dey
 * @copyright          Quadruple Business Service Pvt. Ltd. Copyright(c) 2011
 * @version            CodeIgniter_2.0.3
 * @link               http://www.codeigniter.com
 * @since              File available since Release 2.0.3
 * @Warning            Any change in this file may cause abnormal behaviour of application.
 *
 */

class Mrepayment extends CI_Model
{

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }

    public function getInnovationName($innovationID)
    {

        $this->db->select("id,name_of_entrepreneur,email_id");
        if ($innovationID != "") {
            $this->db->where('id', $innovationID);
        }
        $query = $this->db->get("innovation_pool");
        $value = $query->result_array();
        $data = $value[0];
        return $data;
    }

    public function insertPaymentDetails($data)
    {

        unset($data['txtSubmit'], $data['innovation']);
        $innovatorID = $this->getInnovationName($data['innovationID']);
        $data = array(
            'innovation' => $innovatorID['email_id'],
            'repayment_amount' => $data['repayment_amount'],
            'from_date' => $data['from_date'],
            'to_date' => $data['to_date'],
            'average_amount' => $data['average_amount'],
            'description' => $data['description'],
            'created_date' => date("Y-m-d"),
        );

        $this->db->insert('repayment_details', $data);
        return true;
    }
    public function getMailTemplate($payment)
    {
        $this->db->select("messagetype,messagesubject,messagebody");
        if ($payment != "") {
            $this->db->where('messagetype', $payment);
        }
        $query = $this->db->get("master_mailtemplate");
        $data = $query->result_array();

        return $data;
    }
    #GET RECEIVER INFO#
    public function getReceiver($id)
    {
        $this->db->select("email_id,created_by");
        if ($id != "") {
            $this->db->where('id', $id);
        }
        $query = $this->db->get("innovation_pool");
        $data = $query->result_array();
        return $data;
    }

    public function getDetails($id)
    {
        $this->hris->select("emp_work_email");
        if ($id != "") {
            $this->hris->where('emp_number', $id);
        }
        $query = $this->hris->get("hs_hr_employee");
        $data = $query->result_array();

        return $data;
    }
    public function getRepaymentDetails($id)
    {
        $data = array();
        $this->db->select("innovation,repayment_amount,from_date,to_date,average_amount");
        $this->db->where('status', $id);
        $query = $this->db->get('repayment_details');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    #DIRECT APPLICATION#
    public function direct_innovation($subject, $messege_body, $id)
    {
        $innovatorID = $this->getInnovationName($id);
        $this->changeStatus($innovatorID['email_id']);

        $to = array();
        $value = $this->getReceiver($id);
        $form = $value['0']['email_id'];
        if ($value['0']['created_by'] != '0') {
            $to = $this->getDetails($value[0]['created_by']);

        }
        if ($value['0']['created_by'] == '0') {
            unset($value['0']['created_by']);
            $to = "admin@villgro.org";
        }

        $repaymentDetails = $this->getRepaymentDetails($id);

        $innovation = $repaymentDetails['0'];
        $innovationName = $this->getInnovationName($id);

        $content = array(
            '#to#' => $innovationName['name_of_entrepreneur'],
            '#from#' => "Villgro Team",
            '#innovation_Name#' => $innovation['innovation'],
            '#repayment_amount#' => $innovation['repayment_amount'],
            '#form_date#' => $innovation['from_date'],
            '#to_date#' => $innovation['to_date'],
            '#Average_amount#' => $innovation['average_amount'],

        );
        #sending mail
        $this->_send($form, $to, $subject, $content);
    }

    public function changeStatus($id)
    {

        $data = array(
            'status' => '1',
            'mail_sent_date' => date("Y-m-d"),
        );

        $this->db->where('innovation', $id);
        $result = $this->db->update('repayment_details', $data);
        return $result;
    }

    public function _send($fromEmail, $toEmail, $messageSubject, $content)
    {

        $template = "repayment";
        $templateContent = $this->getMailTemplate($template);

        if (php72_count($templateContent)) {
            $template = $this->parseContent($content, $templateContent);
            $this->send($fromEmail, $toEmail, $template['subject'], $template['body']);
        }
    }
    public function parseContent($content, $template)
    {

        $data['subject'] = $this->_parseContent($template['0']['messagesubject'], $content);
        $data['body'] = $this->_parseContent($template['0']['messagebody'], $content);
        return $data;
    }
    public function _parseContent($main, $replace)
    {

        $main = str_replace(php72_array_keys($replace), php72_array_values($replace), $main);
        return $main;
    }

    public function send($fromEmail, $toEmail, $messageSubject, $messageBody)
    {

        $this->load->library('email');
        $this->email->clear(true);
        $this->email->set_newline("\r\n");
        $this->email->from($fromEmail, "Incubatee");
        $this->email->to($toEmail);
        $this->email->subject($messageSubject);
        $this->email->message($messageBody);
        $this->email->send();
    }
}
