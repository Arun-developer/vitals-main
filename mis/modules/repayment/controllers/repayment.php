<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * Repayment Controller Page
 *
 * @ControllerName     repayment.php
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
class Repayment extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->Mauth->isLoggedCheck(); //Check user logged in or not
        $this->items_perpage = '15';
        $this->load->model('mrepayment');
    }
    public function index($innovation)
    {
        $innovationID = $innovation;
        $data['innovation'] = $this->mrepayment->getInnovationName($innovationID);
        $data['innovationID'] = $innovationID;
        $data['cpagetitle'] = "Repayment";
        $data['cpage'] = "vrepayment";
        $this->load->view('template', $data);
    }

    public function send_mail()
    {
        $innovationID = $this->uri->segment("3");
        $postData = $this->input->post('repayment');
        if (isset($_POST['txtSubmit'])) {

            $this->mrepayment->insertPaymentDetails($postData);
        }
        $repayment = "repayment";
        $data['mailTemplate'] = $this->mrepayment->getMailTemplate($repayment);
        $data['innovationID'] = $innovationID;
        $data['post_Details'] = $postData;
        $data['cpagetitle'] = "Send Mail";
        $data['cpage'] = "send_mail";
        $this->load->view('template', $data);
    }

    public function mail()
    {
        $innovationID = $this->uri->segment("3");
        if (isset($_POST['txtSubmit'])) {
            $subject = $_POST['subject'];
            $messege_body = $_POST['messegebody'];
            $data['mail_details'] = $this->mrepayment->direct_innovation($subject, $messege_body, $innovationID);
        }

        $this->session->set_flashdata('successMsg', 'Mail Sent Successfully!');
    }
    public function reminderMail()
    {
        $status = '1';
        $reminderDetails = $this->mrepayment->getRepaymentDetails($status);
        foreach ($reminderDetails as $row) {

            $reminderContent = $reminderDetails[0]; //$reminderContent['to_date']
            $expire_Date = strtotime('2011-12-07');
            $today_Date = strtotime(date('Y-m-d'));
            $datediff = $expire_Date - $today_Date;
            $datesCount = floor($datediff / (60 * 60 * 24));

            if (($datesCount <= '5') && ($datesCount >= '0')) {

                $subject = "Please Pay your Average amount before " . $reminderContent['to_date'] . "";
                $from = "admin@villgro.org";
                $to[] = $row['innovation'];
                /****  For html content ****/
                $message = "<html><body>";
                $message .= '<table>';
                $message .= "<tr><td>Dear&nbsp;&nbsp;Incubatee</td></tr>";
                $message .= "<tr><td>&nbsp;Your Repayment Amount is" . $reminderContent['repayment_amount'] . "</td></tr>";
                $message .= "<tr><td>" . "Not paid yet" . "</td></tr>";
                $message .= "<tr><td>&nbsp;Please Kindly pay your amount on or before" . $reminderContent['to_date'] . "</td></tr>";
                $message .= "<tr><td>With Thanks & Regards,</td></tr>";
                $message .= "<tr><td>Villgro Team</td></tr>";
                $message .= "</table>";
                $message .= "</body></html>";
                /*** End ****/
                $this->send($from, $to, $subject, $message);
            }
        }
    }
    public function send($fromEmail, $toEmail, $messageSubject, $messageBody)
    {
        $this->load->library('email');
        $this->email->clear(true);
        $this->email->set_newline("\r\n");
        $this->email->from($fromEmail, "Incubatee");
        $this->email->to($toEmail);
        echo $this->email->subject($messageSubject);
        echo $this->email->message($messageBody);
        echo $this->email->send();
        return true;
    }
}
