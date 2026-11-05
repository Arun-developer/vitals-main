<?php

class Memail extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/Mmailtemplate');
        error_reporting(0);
    }

    //replace values in template

    public function parseContent($content, $template) {
        if (isset($template)) {
            $data['subject'] = $this->_parseContent(@$template[0]['subject'], $content);
            $data['body'] = $this->_parseContent(@$template[0]['body'], $content);
            return $data;
        }
    }

    public function _parseContent($main, $replace) {
        $main = str_replace(php72_array_keys($replace), php72_array_values($replace), $main);
        return $main;
    }

    //send mail
    public function _send($fromEmail, $toEmail = array(), $content, $template = null, $partner_id, $sector = '', $attach = array(), $reply = '') {
        $templateContent = $this->Mmailtemplate->getMailTemplate($template, $partner_id);
        if (php72_count($templateContent)) {
            $template = $this->parseContent($content, $templateContent);
//            $msg_subj = imap_utf8($template['subject']);
//            $msg_body = imap_utf8($template['body']);
//            $this->Memail->send($fromEmail, $toEmail, $msg_subj, $msg_body, $partner_id, $sector, $attach, $reply);
            $this->send($fromEmail, $toEmail, $template['subject'], $template['body'], $partner_id, $sector, $attach, $reply);
        }
    }

    public function send($fromEmail, $toEmail, $messageSubject, $messageBody, $partner_id, $sector = '', $attach = array(), $reply = '') {
        $mail_config = partner_smtp();
        $config = array(
            'protocol' => $mail_config['protocol'],
            'smtp_host' => $mail_config['smtp_host'],
            'smtp_port' => $mail_config['smtp_port'],
            'smtp_user' => $mail_config['smtp_user'],
            'smtp_pass' => $mail_config['smtp_pass'],
            'newline' => '\r\n',
        );
        $this->load->library('email', $config);
        $this->email->clear(true);
        $this->email->set_newline("\r\n");
        $this->email->from($mail_config['smtp_user'], $mail_config['smtp_subject']);

        $this->email->to($toEmail);
        if ($sector == 'Energy') {
            $this->email->bcc('ananth@villgro.org');
        }
        if ($reply != '') {
            $this->email->reply_to($reply);
        }

        if (php72_count($attach)) {
            foreach ($attach as $key => $value):
                if (file_exists($value)) {
                    $this->email->attach($value);
                }
            endforeach;
        }

        $this->email->subject($messageSubject);
        $this->email->message($messageBody);
        $this->email->send();
    }
	
	
	 public function _send_phpmailer($fromEmail, $toEmail = array(), $content, $template = null, $partner_id, $sector = '', $attach = array(), $reply = '') {
        $templateContent = $this->Mmailtemplate->getMailTemplate($template, $partner_id);
        if (php72_count($templateContent)) {
            $template = $this->parseContent($content, $templateContent);

            $this->sendphpmailer($fromEmail, $toEmail, $template['subject'], $template['body'], $partner_id, $sector, $attach, $reply);
			
        }
    }
	
	public function sendphpmailer($fromEmail, $toEmail, $messageSubject, $messageBody, $partner_id, $sector = '', $attach = array(), $reply = '') {
		
	
		try {	
			$body = "Testing Mail";
			$this->load->library("PhpMailerLib");
			$mail = $this->phpmailerlib->load();
			$mail->setFrom('mis@villgro.org', 'Villgro Admin');
			$mail->Username   = "AKIAWKHBS5IYYPXSDZQE";
			$mail->Password   = "BCGFofeOlqofgdBTFAewlaSQv7pzYSdxau4RbKO5OoLa";
			$mail->Host       = "email-smtp.ap-south-1.amazonaws.com";
			$mail->Port       = 587;
			$mail->SMTPAuth   = true;
			$mail->SMTPSecure = 'tls';
			
			$mail->IsSMTP(); 
			
			if ($sector == 'Energy') {
				$mail->addBCC('ananth@villgro.org');
			}
			if ($reply != '') {
				$mail->addReplyTo($reply);
			}
			$mail->CharSet = 'utf-8';  
			$mail->SMTPDebug  = 1;   

			$mail->Subject = $messageSubject;

			$mail->MsgHTML($messageBody);
			 if (php72_count($attach)) {
				foreach ($attach as $key => $value):
					if (file_exists($value)) {
						$mail->addAttachment($value);
					}
				endforeach;
			}
			if(is_array($toEmail)){
				 if (!empty($toEmail)) {
					foreach ($toEmail as $keys => $email){
						if($email!=''){
							//$email = 'arunkumar.d@claritaz.com';
							$mail->AddAddress($email);
						}
					}
				}
			  }else{ 
				if($toEmail!=''){
					//$to = 'arunkumar.d@claritaz.com';
					
				  $mail->AddAddress($toEmail);
				}
			  }
			
			//$mail->AddAddress($address1);
		
			if($mail->send()){
				  //echo 'Message has been sent';
			}else{
				
			}
		  
		} catch (Exception $e) {
		    //echo 'Message could not be sent.';
		    //echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		
		
		
    }
	

}
