<?php

class Cron extends CI_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('Mcron');
		$this->load->model('travel/Mtravel');
    }	

	public function index() {
		
		//Reminder email for employees completing one year of earned leave (EL) 1,3,5 years
		 
		$this->sendOneYearELReminder(1);
		$this->sendOneYearELReminder(3);
		$this->sendOneYearELReminder(5);
		
		//Reminder Email Regarding Paternity or Maternity Leave Expiry
		$this->sendLeaveExpiryReminder();
		
		//Reminder Email Regarding Paternity or Maternity Leave Expiry
		$this->sendLeaveExpiryCompOffReminder();
		
	}
	
	public function sendLeaveExpiryCompOffReminder() {
		
		$remainderStatus = 'Yes';
		$getAllUserList = $this->Mcron->getAllEmployeeLeaveQuotasCompOff($remainderStatus);
		#echo'<pre>';print_r($getAllUserList);die;
		if (!empty($getAllUserList)) {
			foreach ($getAllUserList as $userData) {
				$to = !empty($userData['official_email']) ? $userData['official_email'] : $userData['personal_email'];
				$expiredDate = date('d-m-Y', strtotime('+10 days'));
				$messageType = 'Leave Expiry Notification';
				$org = ['#To#', '#LeaveType#', '#ExpiryDate#'];
				$replace = [
					$userData['emp_firstname'] . ' ' . $userData['emp_lastname'],
					$userData['leave_type_name'],
					$expiredDate
				];
				$this->sendTravelRequestMail($from, $to, $messageType, $org, $replace);
			}
		}
		
		#Update Expired Leaves
		 $fetchUpdatedUserLeave = $this->Mcron->getAllEmployeeLeaveQuotasCompOff('No');
		 #echo'<pre>';print_r($fetchUpdatedUserLeave);die;
		if (!empty($fetchUpdatedUserLeave)) {
			foreach ($fetchUpdatedUserLeave as $userLeaveData) {
				$condition = array('id'=>$userLeaveData['id']);
				$updateData = array('no_of_days_allotted'=>0);
				$this->Mcron->updateLeaveQuota($condition,$updateData);
				$userLeaveData['leave_created_date']= $userLeaveData['created_date'];
				$userLeaveData['created_date'] = date('Y-m-d H:i:s');
				$userLeaveData['leave_qouta_update'] = 0;
				$userLeaveData['reference_id'] =$userLeaveData['id'];
				$this->Mcron->updateLog($userLeaveData);
			}
		} 
	}
	
	public function sendLeaveExpiryReminder() {
		
		$remainderStatus = 'Yes';
		$getAllUserList = $this->Mcron->getAllEmployeeLeaveQuotas($remainderStatus);
		if (!empty($getAllUserList)) {
			foreach ($getAllUserList as $userData) {
				$to = !empty($userData['official_email']) ? $userData['official_email'] : $userData['personal_email'];
				$expiredDate = date('d-m-Y', strtotime('+1 month'));
				$messageType = 'Leave Expiry Notification';
				$org = ['#To#', '#LeaveType#', '#ExpiryDate#'];
				$replace = [
					$userData['emp_firstname'] . ' ' . $userData['emp_lastname'],
					$userData['leave_type_name'],
					$expiredDate
				];
				$this->sendTravelRequestMail($from, $to, $messageType, $org, $replace);
			}
		}
		
		#Update Expired Leaves
		$fetchUpdatedUserLeave = $this->Mcron->getAllEmployeeLeaveQuotas('No');
		if (!empty($fetchUpdatedUserLeave)) {
			foreach ($fetchUpdatedUserLeave as $userLeaveData) {
				$condition = array('id'=>$userLeaveData['id']);
				$updateData = array('no_of_days_allotted'=>0);
				$this->Mcron->updateLeaveQuota($condition,$updateData);
				$userLeaveData['leave_created_date']= $userLeaveData['created_date'];
				$userLeaveData['created_date'] = date('Y-m-d H:i:s');
				$userLeaveData['leave_qouta_update'] = 0;
				$userLeaveData['reference_id'] =$userLeaveData['id'];
				unset($userLeaveData['id']);
				$this->Mcron->updateLog($userLeaveData);
			}
		}
	}
	

	public function sendOneYearELReminder($yearInterval='') {
		$getAllUserList = $this->Mcron->getAllUserList($yearInterval);
		
		if (!empty($getAllUserList)) {
			foreach ($getAllUserList as $userData) {

				$from = '';
				$to = !empty($userData['official_email']) ? $userData['official_email'] : $userData['personal_email'];

				if ($yearInterval == 1) {
					// 1-Year Milestone
					$messageType = 'Eligible for Earned Leave Year';
					$placeholders = ['#username#', '#content#', '#month#', '#completionData#', '#year#'];
					$replacements = [
						$userData['user_name'],
						' Earned Leave (EL).',
						'12 months',
						date('Y-m-d'),
						'1 years'
					];
					$this->sendTravelRequestMail($from, $to, $messageType, $placeholders, $replacements);

				} elseif ($yearInterval == 3) {
					// 3-Year Milestone
					$messageType = 'Eligible for Earned Leave Year';
					$placeholders = ['#username#', '#content#', '#month#', '#completionData#', '#year#'];
					$replacements = [
						$userData['user_name'],
						'special (7 working days) paid leave',
						'12 months',
						date('Y-m-d'),
						'3 years'
					];
					$this->sendTravelRequestMail($from, $to, $messageType, $placeholders, $replacements);

				} elseif ($yearInterval == 5) { 
					// 5-Year Milestone
					$messageType = 'Eligible for Earned Leave Year';
					$placeholders = ['#username#', '#content#', '#month#', '#completionData#', '#year#'];
					$replacements = [
						$userData['user_name'],
						'special (15 working days) paid leave',
						'12 months',
						date('Y-m-d'),
						'5 years'
					];
					$this->sendTravelRequestMail($from, $to, $messageType, $placeholders, $replacements);
				}
			}
		}

		
	}

	public function sendTravelRequestMail($from = NULL, $to = array(), $messageType = NULL, $org = array(), $replace = array()) {
		
		$mailTemplate = $this->Mcron->getMail_Template($messageType);
		$messageSubject = $mailTemplate[0]['messagesubject'] ?? 'No Subject';
		$messageBody = str_replace($org, $replace, $mailTemplate[0]['messagebody']);
		
		$toEmail = $to;
		$ccEmail = 'vijitha@villgro.org';
		$ccEmail = 'arunkumarvitals@yopmail.com';
		try {
			$this->load->library("PhpMailerLib");
			$mail = $this->phpmailerlib->load();

			$mail->isSMTP();
			$mail->CharSet = 'utf-8';
			$mail->SMTPDebug = 1;

			$mail->setFrom('mis@villgro.org', 'Villgro Admin');
			
			$mail->Username = "AKIAWKHBS5IYYPXSDZQE";
			$mail->Password = "BCGFofeOlqofgdBTFAewlaSQv7pzYSdxau4RbKO5OoLa";
			$mail->Host = "email-smtp.ap-south-1.amazonaws.com";
			$mail->Port = 587;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls';

			$mail->Subject = $messageSubject;
			$mail->MsgHTML($messageBody);
			
			if (!empty($ccEmail)) {
				$mail->addCC($ccEmail);
			}
			
			if (is_array($toEmail)) {
				foreach ($toEmail as $email) {
					if (!empty($email)) {
						$mail->addAddress($email);
					}
				}
			} else {
				if (!empty($toEmail)) {
					$mail->addAddress($toEmail);
				}
			}

			if (!$mail->send()) {
				
			}
		} catch (Exception $e) {
		
		}
	}

	
	
}


?>