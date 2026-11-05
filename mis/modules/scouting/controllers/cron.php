<?php

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Minnovation');
        $this->load->model('Memail');
    }

    public function inv_warning() {
        $inv_drafts = $this->getDraftInv_Partner();
        $current_date = date('Y-m-d');
        if (!empty($inv_drafts)) {
            foreach ($inv_drafts as $inv) {
                $datetime1 = new DateTime($inv['created_date']);
                $datetime2 = new DateTime($current_date);
                $interval = $datetime1->diff($datetime2);

                $days = $interval->format('%a');
                $partner = $inv['partner_id'];
                if ($partner == '02') {
                    $url = 'http://villgrokenya.or.ke/apply-for-incubation';
                    $name = 'Villgro Kenya';
                    $email = 'apply@villgro.org';
                    $it = 'apply@villgro.org';
                } else if ($partner == '04') {
                    $url = 'http://startupoasis.in/invent-apply.php';
                    $name = 'Startup Oasis';
                    $email = 'invent@startupoasis.in';
                    $it = 'invent@startupoasis.in';
                } else if ($partner == '05') {
                    $url = 'https://mis.villgroapps.org/IncubationForm/Login.php?partner=IIMC';
                    $name = 'Villgro IIMC';
                    $email = 'invent@iimcip.org';
                    $it = 'invent@iimcip.org';
                } else if ($partner == '06') {
                    $url = 'http://kiitincubator.in/invent-form/';
                    $name = 'Villgro KIIT';
                    $email = 'invent@kiitincubator.in';
                    $it = 'invent@kiitincubator.in';
                } else if ($partner == '07') {
                    $url = 'https://mis.villgroapps.org/IncubationForm/Login.php?partner=SIIC';
                    $name = 'Villgro SIIC';
                    $email = 'socialincubator.iitk@gmail.com';
                    $it = 'socialincubator.iitk@gmail.com';
                } else {
                    $url = 'http://www.villgro.org/incubation-apply';
                    $name = 'Villgro';
                    $email = 'apply@villgro.org';
                    $it = 'it@villgro.org';
                }
                if ($days == 11) {
                    $msg = "<p>You have not submitted your application form for the " . $name . " Incubation program in the last 10 days. Applications will need to be submitted within 3 weeks of registering. To access your application form login on <a href=" . $url . ">" . $url . "</a> Please complete and submit your application at the earliest.</p>
                    <p>Please contact us at " . $email . " if you have any questions regarding the Incubation program. Or email us at " . $it . " for technical queries. </p>";
                    $sub = $name . " " . "Incubation Application form - Submission Reminder";
                    $this->mail($inv['applicant_name'], $inv['email'], $inv['inv_no'], $msg, $sub, $partner);
                } else if ($days == 21) {
                    $msg = "<p>You have not submitted your application form for the " . $name . " Incubation program in the last 3 weeks. Your application will be purged from the system within the next 24 hours. Following this you will need to re-register if you are still interested in applying to the incubation program.</p>
                    <p>Please contact us at " . $email . " if you have any questions regarding the Incubation program. Or email us at " . $it . " for technical queries. </p>
                    <p>You can access your application at <a href=" . $url . ">" . $url . "</a></p>";
                    $sub = $name . " " . "Incubation Application form - Final Reminder";
                    $this->mail($inv['applicant_name'], $inv['email'], $inv['inv_no'], $msg, $sub, $partner);
                } else if ($days == 22) {
                    $result = $this->inv_status_update($inv['inv_no'], $inv['id']);
                }
            }
        }
    }

    public function inv_status_update($in, $id) {
        $this->db->set('status', 'Deleted');
        $this->db->where('inv_no', $in);
        $this->db->where('id', $id);
        $this->db->update('inv_user');
        if ($this->db->affected_rows() > 0) {
            $this->db->set('status', '11');
            $this->db->where('innovation_id', $in);
            $this->db->update('innovation_pool');
        }
        return true;
    }

    public function getDraftInv_partner() {
        $data = array();
        $this->db->select("INV.*,IP.partner_id");
        $this->db->from("inv_user INV");
        $this->db->join("innovation_pool IP", "IP.innovation_id = INV.inv_no", 'left');
        $this->db->where('INV.status', 'Draft');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return $data;
        }
    }

    public function mail($name, $email, $inv_no, $msg_val, $sub, $partner) {
        $this->db->where('messagetype', 'Inv Remainder Message');
        $template = $this->db->get('master_mailtemplate');
        if ($template->num_rows() > 0) {
            $template1 = $template->result_array();
            $mail_template = $template1[0]['messagebody'];
            $org = array('#name_of_entrepreneur#', '#msg#');
            $replace = array($name, $msg_val);
            $messageBody = str_replace($org, $replace, $mail_template);
            $body = $this->imgUrl($messageBody);
            $toEmail = $email;
            $datas = array('innovation' => $inv_no,
                'from' => 'villgro.org',
                'to' => $email,
                'mail_type' => 'Remainder',
                'sent_date' => date('Y-m-d'),
                'subject' => 'Innovation Detail Submittion Remainder',
                'body' => $body,
                'send_by' => '',
            );
            $result = $this->db->insert('innovation_mail_history', $datas);
            if ($partner == '02') {
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'admin@villgrokenya.or.ke',
                    'smtp_pass' => 'kahawa1234',
                    'newline' => '\r\n',
                );
            } else if ($partner == '04') {
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.gmail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'invent@startupoasis.in',
                    'smtp_pass' => 'User12345',
                    'newline' => '\r\n',
                );
            } else if ($partner == '05') {
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.gmail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'invent@iimcip.org',
                    'smtp_pass' => 'Google@12345',
                    'newline' => '\r\n',
                );
            } else if ($partner == '06') {
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.gmail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'invent@kiitincubator.in',
                    'smtp_pass' => 'INVENT@info123',
                    'newline' => '\r\n',
                );
            } else if ($partner == '07') {
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'socialincubator.iitk@gmail.com',
                    'smtp_pass' => 'siic1234',
                    'newline' => '\r\n',
                );
            } else if ($partner == '01') {
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'mis@villgro.org',
                    'smtp_pass' => 'misvillgro',
                    'newline' => '\r\n',
                );
            } else {
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'mis@villgro.org',
                    'smtp_pass' => 'misvillgro',
                    'newline' => '\r\n',
                );
            }

            $this->load->library('email', $config);

            $this->email->set_newline("\r\n");
            if ($partner == '01') {
                $this->email->from('mis@villgro.org', 'Villgro Admin');
            } else if ($partner == '02') {
                $this->email->from('admin@villgrokenya.or.ke ', 'Villgro Kenya Admin');
            } else if ($partner == '04') {
                $this->email->from('invent@startupoasis.in ', 'Startup Oasis Admin');
            } else if ($partner == '05') {
                $this->email->from('invent@iimcip.org ', 'IIMC Admin');
            } else if ($partner == '06') {
                $this->email->from('invent@kiitincubator.in ', 'KIIT Admin');
            } else if ($partner == '07') {
                $this->email->from('socialincubator.iitk@gmail.com ', 'SIIC Admin');
            } else {
                $this->email->from('mis@villgro.org', 'Villgro Admin');
            }
            $this->email->to($toEmail);
            $this->email->subject($sub);

            $this->email->message($body);
            $this->email->send();
            if ($this->email) {
                echo "Mail Sent Successfully";
            } else {
                echo $this->email->print_debugger();
            }
        }
    }

    public function imgUrl($source) {
        $imgLink = '/S*src\s*=\s*[\""\']?([^\""\']*)/i';
        preg_match_all($imgLink, $source, $matches);
        $matchVal = php72_array_filter($matches);
        $count = count($matchVal);
        if ($count != 0) {
            $imageArray = $matchVal['1'];
            foreach ($imageArray as $key => $img):
                $imgArray[] = $img;
                $imgFullPath[] = base_url() . str_replace('../', '', $img);
            endforeach;
            $source = str_replace($imgArray, $imgFullPath, $source);
        } //count the array elements

        return $source;
    }

}
