<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	
	}

	function connectmail() {
		
		echo phpinfo();
			/* try {	
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

			$mail->CharSet = 'utf-8';  
			$mail->SMTPDebug  = 1;   

			$mail->Subject = "Villgro Mail";

			$mail->MsgHTML($body);
			$attach = array('uploads/support_docs/Villgro_Email_testing_file.pdf');
			 if (count($attach)) {
				foreach ($attach as $key => $value):
					if (file_exists($value)) {
						$mail->addAttachment($value);
					}
				endforeach;
			}
			$address1 = 'arunkumar.d@claritaz.com';
			$mail->AddAddress($address1);
			//$mail->send();
			if($mail->send()){
				  echo 'Message has been sent';
			}else{
				
			}
		  
		} catch (Exception $e) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} */
			
	}
	function info()
	{	
		$sector ='';
		$toEmail ='prakash@claritaz.com';
		$messageSubject ='Test Mail from vitals live server with attachment';
		$messageBody ='<h1>Test Mail from vitals live server</h1>';
		$mail_config = partner_smtp();
		  $config = array(
            'protocol' => $mail_config['protocol'],
            'smtp_host' => 'email-smtp.ap-south-1.amazonaws.com',
            'smtp_port' => '465',
			'smtp_crypto' => 'ssl',
            'smtp_user' => 'AKIAWKHBS5IYYPXSDZQE',
            'smtp_pass' => 'BCGFofeOlqofgdBTFAewlaSQv7pzYSdxau4RbKO5OoLa',
            'newline' => '\r\n',
        ); 		
		/*$config = array(
            'protocol' => $mail_config['protocol'],
            'smtp_host' => $mail_config['smtp_host'],
            'smtp_port' => $mail_config['smtp_port'],
            'smtp_user' => $mail_config['smtp_user'],
            'smtp_pass' => $mail_config['smtp_pass'],
            'newline' => '\r\n',
        ); */
	
		$this->load->library('email', $config);
        $this->email->clear(true);
        $this->email->set_newline("\r\n");
        $this->email->from($mail_config['smtp_user'], $mail_config['smtp_subject']);

        $this->email->to($toEmail);
		//$bcc ='kalaiprakash@quadrupleindia.com';
		//$this->email->bcc($bcc);
       /*  if ($sector == 'Energy') {
            $this->email->bcc('ananth@villgro.org');
        }  */
		$reply ='arunkumar.d@claritaz.com';
        if ($reply != '') {
            //$this->email->reply_to($reply);
        }
		$value="Villgro_Email_testing_file.pdf";
		$attach = "uploads/support_docs/".$value;
		$this->email->attach($attach);

        $this->email->subject($messageSubject);
        $this->email->message($messageBody);
        $this->email->send();
		echo $this->email->print_debugger();
		
		//phpinfo();
		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
