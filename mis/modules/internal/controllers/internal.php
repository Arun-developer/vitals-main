<?php

class Internal extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->Mauth->isLoggedCheck();
        //$this->Mauth->isAdminCheck();
    $this->load->library('upload');
    $this->load->model('approval/Mapproval');
    $this->load->model('Minternal');
  }

  public function DT_action_history() {
    $requestData = $_POST;

    if ($this->session->userdata['user_type'] == 'superadmin') {
      $columns = array(
        0 => 'emp_type',
        1 => 'id',
        2 => 'emp_name',
        3 => 'partner_name',
        4 => 'job_title',
        5 => 'designation'
      );
    } else {
      $columns = array(
        0 => 'emp_type',
        1 => 'id',
        2 => 'emp_name',
        3 => 'job_title',
        4 => 'designation'
      );
    }

    $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
    $data['search_value'] = $search_value = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';
    $data['current_user'] = $current_user = (isset($_POST['current_user'])) ? $_POST['current_user'] : 'employee';

    $totalrows = $this->Mapproval->getDTApprovalNotesCount($search_field, $search_value, $current_user, $columns, $requestData);
    $query = $this->Mapproval->getDTApprovalNotes($requestData['length'], $requestData['start'], $search_field, $search_value, $current_user, $columns, $requestData);
    $totalFiltered = $totalrows;
    $totalData = php72_count($query);
    $data = array();
    $i = $requestData['start'] + 1;
    foreach ($query as $row) {
      $nestedData = $report_to = array();
      $get_report_to = $this->Empuser->getReportingOfficer($row['id']);
      foreach ($get_report_to as $report) {
        $get_report_name = $report['emp_name'];
        $report_name = str_replace("  ", " ", $get_report_name);
        array_push($report_to, $report_name);
      }
      $ro_officer = implode(', ', $report_to);

      $nestedData[] = '<input type="checkbox" class="chk_box" id="emp_chk_box" name="employee_id[]" value="' . $row['id'] . '"/>';
      $nestedData[] = $row['id'];
      $get_emp_name = $row['emp_name'];
      $emp_name = str_replace("  ", " ", $get_emp_name);
      $derive_name = (strlen($emp_name) > 15) ? substr($emp_name, 0, 15) . ".." : $emp_name;
      $nestedData[] = "<a href=" . site_url('user/personal/' . $row['id']) . " title='" . $emp_name . "'>" . $derive_name . "</a>";
      if ($this->session->userdata['user_type'] == 'superadmin') {
        $nestedData[] = $row['partner_name'] != '' ? $row['partner_name'] : '-';
      }
      $nestedData[] = $row['job_title'] != '' ? $row['job_title'] : '-';
      $rep_manager = strlen($ro_officer) > 15 ? substr($ro_officer, 0, 15) . ".." : $ro_officer;
      $nestedData[] = $rep_manager != '' ? $rep_manager : '-';
      $nestedData[] = $row['user_type'];

      $data[] = $nestedData;
      $i++;
    }
    $json_data = array(
      "draw" => intval($requestData['draw']),
      "recordsTotal" => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data" => $data
    );
    echo json_encode($json_data);
  }

    function edit_internal_note_old($id = '', $section = 'mylist') { 
        /* $partnerNote = $this->Mapproval->getPartnerInternal($id);

          if ($partnerNote < 1 && is_numeric($id)) {
          redirect('approvaluser/approval_note/confirmed');
          }
          $data['section'] = $section;
          if (isset($_REQUEST['internal_id'])) {
          $this->form_validation->set_rules('payment_favor', 'Payment favor of', 'required');
          $this->form_validation->set_rules('total_amount', 'Amount', 'required');
          $this->form_validation->set_rules('subject', 'Subject', 'required');
          $this->form_validation->set_rules('amount_toapprove', 'Amount to be approved', 'required');
          $this->form_validation->set_rules('invoice_date', 'Invoice date', 'required');
          $this->form_validation->set_rules('proposed_date', 'Proposed date', 'required');

          if ($this->form_validation->run() != FALSE) {


          $txtsubmit = $this->input->post('txtsubmit');
          if ($txtsubmit) {
          $result_old = $this->Minternal->getOldGrantAmount($id);
          if (!empty($result_old)) {
          foreach ($result_old as $lists) {
          $grant_id = $lists->grant_id;
          echo'==';
          $status = $lists->status;
          $amount_toapprove = $lists->amount_toapprove;
          if ($status == 'confirmed' && $grant_id != '') {//amount_utilized
          $this->Minternal->updateOldGrantAmount($grant_id, $amount_toapprove);
          }
          }
          }
          }

          $insert = $this->Minternal->updateInternalNote();
          if ($id != '') {
          $res = $this->Minternal->getGrantAmount($id);
          if (!empty($res)) {
          foreach ($res as $lists) {
          $grant_id = $lists->grant_id;
          $status = $lists->status;
          $amount_toapprove = $lists->amount_toapprove;
          if ($status == 'confirmed' && $grant_id != '') {//amount_utilized
          $this->Minternal->updateGrantAmount($grant_id, $amount_toapprove);
          }
          }
          }
          }

          $this->session->set_flashdata('successMsg', 'Internal Note Updated Successfully!');
          if ($this->session->userdata('isAdmin') == 'Yes')
          redirect('internaladmin/internal_note_details/' . $id);
          else
          redirect('internaluser/internal_note_details/' . $id . '/' . $section);
          } else {
          $data['errorMsg'] = "Validation error found, check it again!";
          }
          }

          $data['internalNoteDetails'] = $internalNoteDetails = $getInternalNoteDetails = $this->Minternal->getInternalNoteDetailsEdit($id);
          $data['apn_donor_id'] = $this->Minternal->getAPNdonorId($id, $internalNoteDetails); // newly added on 2/6/14
          $data['subUsers'] = reportingUser('subUser', 'userId');
          $total_balance = $this->Mapproval->get_internal_balance($data['internalNoteDetails']); // newly added on 2/6/14
          $data['donor_balance'] = $total_balance + $internalNoteDetails[0]['amount_toapprove']; // newly added on 2/6/14
          #echo'<pre>';print_r($internalNoteDetails);die;
          if ((in_array($internalNoteDetails['0']['from_employee'], $data['subUsers']) && $internalNoteDetails['0']['RO_status'] == 'pending') || ($this->session->userdata('user') == $internalNoteDetails['0']['programme_head'] && $internalNoteDetails['0']['RO_status'] == 'confirmed') || ($this->session->userdata('isAdmin') == 'Yes') || ($internalNoteDetails['0']['from_employee'] == $this->session->userdata('user')) || $internalNoteDetails['0']['from_employee'] != $this->session->userdata('user')) {
          $data['donorList'] = $this->Mcommon->getMasterSetting('Donor');
          $data['budgetHeadList'] = $this->Mcommon->getMasterSetting('Budget Head');
          $data['costcentrerList'] = $this->Mcommon->getMasterSetting('Cost Centre');
          $data['budgetHeadList'] = $this->Mcommon->getMasterSetting('Budget Head');
          $data['cpagetitle'] = "Edit Internal Note";
          $data['cpage'] = "internal/user/editInternalNote";
          $this->load->vars($data);
          $this->load->view('design/template');
          } else {
          $this->session->set_flashdata('errorMsg', 'Access Denied!');
          if ($this->session->userdata('isAdmin') == 'Yes')
          redirect('internaladmin/internal_note_details/' . $id);
          else
          redirect('internaluser/internal_note_details/' . $id);
        } */
      }

    function edit_internal_note($id = NULL, $section = 'mylist') { #echo'asdasd';die;
		#echo$_SERVER['REMOTE_ADDR'];die;
		
		$this->load->model('vendor/vendor_model');
		$user_id = $this->session->userdata('emp_number');
		$role_id = $this->session->userdata('role_id');
		$partner_id = $this->session->userdata('partner_id');
		$conditionFinance = array('partner_id'=>$partner_id);
		$getFinanceUser = $this->vendor_model->get_all_details('approval_setting', $conditionFinance, array('finance'), '', '', '', true, 'ais');
		
		$data['user_status'] ='';
		$cond ='';
		$data['finance_user_status'] =  '';
		if(!empty($getFinanceUser)){
			$financeUserId = unserialize($getFinanceUser[0]->finance);
			if(!empty($financeUserId)){
				if(php72_in_array($user_id, $financeUserId)){
					$data['finance_user_status'] =  '1';
				}
			}
		}
		$data['get_vendor'] =  $get_vendor= $this->Minternal->getVendorDetails('vendor', array('status'=>2));
		$data['tdsDetails'] = '';
		if($id!=''){
			$tdsDetails = $this->Minternal->getTdsDetails('tds_vendor',array('internal_id'=>$id));
			if(!empty($tdsDetails)){
				$data['tdsDetails'] =  $tdsDetails[0];
			}
		}
		
		
		$partnerNote = $this->Mapproval->getPartner($id);
		if (php72_cmp($partnerNote) < 1 && is_numeric($id)) {
				//redirect('approvaladmin/approval_note/pending');
		}
		$data['section'] = $section;
		if ($id == NULL) {
				//redirect('approvaladmin/approval_note/pending');
		}

		$data['internalNoteDetails'] = $internalNoteDetails = $getInternalNoteDetails = $this->Minternal->getInternalNoteDetailsEdit($id);
        $data['apn_donor_id'] = $this->Minternal->getAPNdonorId($id, $internalNoteDetails); // newly added on 2/6/14

        $data['subUsers'] = $this->Mapproval->reportingUser('subUser', 'userId');
        $total_balance = $this->Minternal->get_internal_balance($data['internalNoteDetails']); // newly added on 2/6/14
        $data['donor_balance'] = $total_balance + $internalNoteDetails[0]['amount_toapprove']; // newly added on 2/6/14


        $data['internalNoteDetails'] = $internalNoteDetails = $getInternalNoteDetails = $this->Minternal->getInternalNoteDetailsEdit($id);
        $data['donorList'] = $this->Mapproval->getMasterSetting('Donor');
        $data['budgetHeadList'] = $this->Mapproval->getMasterSetting('Budget Head');
        $data['programmeList'] = $this->Mapproval->getBalanceProgramme();
        $from_emp_num = $this->Mapproval->getempidfromuserid($data['internalNoteDetails'][0]['from_employee']);
        $data['donors'] = $this->Mapproval->getBalanceDonor($data['internalNoteDetails'][0]['programme']);

        $employe_id = $internalNoteDetails[0]['from_employee'];
        $employeeName = $this->Minternal->getUserNameInfo($employe_id);
        $data['from_employee'] = $employeeName[0]['user_name'];

        $data['donorAN'] = $this->Mapproval->getApprovalDonors($internalNoteDetails[0]["approval_id"]);
        $data['RO'] = $this->Mapproval->reportingUser('supUser', 'All', $from_emp_num[0]['emp_number']);
        $data['costCentreList'] = $this->Mapproval->getMasterSetting('Cost Centre');
		if($_SERVER['REMOTE_ADDR']=='172.31.31.99'){
			#echo'<pre>';print_r($data);die;
		}
		if($internalNoteDetails[0]["donor"]!=''){
			$get_funder= $this->Minternal->getVendorBankDetails('funder_list', array('id'=>$internalNoteDetails[0]["donor"]),array('id','fcra_status'));
			$fcra_status ='';
			$data['get_funder'] ='';
			if(!empty($get_funder)){
				$fcra_status = ucfirst(str_replace('_', ' ', $get_funder[0]['fcra_status']));
				$data['get_funder'] =  $fcra_status;
			}
		}
        foreach ($donorAN as $rows):
          $amt_required[] = $rows['amt_required'];
        endforeach;
        $data['total_amount'] = php72_array_sum($amt_required);
		
		$getDebitAccount = $this->vendor_model->get_all_details('debit_bank_details', array('donor_type'=>$data['get_funder']), array('id,account_number,bank_name'), '', '', '', true);
		$data['get_debit_account'] = $getDebitAccount;
        $this->load->view('internal/admin/edit_internal_note', $data);
      }

      function sent_internal_note($id = '', $section = 'mylist') {
		
		$this->load->model('vendor/vendor_model');
		$user_id = $this->session->userdata('emp_number');
		$role_id = $this->session->userdata('role_id');
		$partner_id = $this->session->userdata('partner_id');
		$conditionFinance = array('partner_id'=>$partner_id);
		$getFinanceUser = $this->vendor_model->get_all_details('approval_setting', $conditionFinance, array('finance'), '', '', '', true, 'ais');
		
		$data['user_status'] ='';
		$cond ='';
		$data['finance_user_status'] =  '';
		if(!empty($getFinanceUser)){
			$financeUserId = unserialize($getFinanceUser[0]->finance);
			if(!empty($financeUserId)){
				if(php72_in_array($user_id, $financeUserId)){
					$data['finance_user_status'] =  '1';
				}
			}
		}
		$data['get_vendor'] =  $get_vendor= $this->Minternal->getVendorDetails('vendor', array('status'=>2));
		$data['tdsDetails'] = '';
		if($id!=''){
			$tdsDetails = $this->Minternal->getTdsDetails('tds_vendor',array('internal_id'=>$id));
			if(!empty($tdsDetails)){
				$data['tdsDetails'] =  $tdsDetails[0];
			}
		}
		
        $emp_id = $this->session->userdata('emp_number');
        $partnerNote = $this->Mapproval->getPartner($id);
        if (php72_cmp($partnerNote) < 1 && is_numeric($id)) {
          redirect('approvaladmin/approval_note/confirmed');
        }
        $data['section'] = $section;
        if ($id == NULL) {
          redirect('approvaladmin/approval_note/confirmed');
        }
        $data['approval_id'] = $id; 
        $data['donorList'] = $this->Mapproval->getMasterSetting('Donor');
        $data['approvalNoteDetails'] = $approvalNoteDetails = $this->Mapproval->getApprovalNote($id);
        // $data['internalNoteDetails'] = $internalNoteDetails = $getInternalNoteDetails = $this->Minternal->getInternalNoteDetailsEdit($id);
		//$data['internalNoteDetails'] =  = $this->Minternal->getInternalNoteDetailsByapproval($id);
        $data['sup_user'] = $this->Mapproval->reportingUser('subUser', 'userId');
        $data['Emp_number'] = $this->session->userdata('user');
        $data['internalNo'] = $this->Minternal->internalNumber();
        $data['reporting_list'] = $this->Mapproval->getROlist($emp_id);

        if ($approvalNoteDetails['0']['status'] == 'confirmed') {
          $amt_required = array();
          $donorAN = $data['donorAN'] = $this->Mapproval->getApprovalDonors($approvalNoteDetails['0']["approval_id"]);
          $grantList = $this->Mapproval->get_grantList();
          $grantArr = array();
          foreach ($grantList as $lists) {
            $grantArr[$lists->id] = $lists->name;
          }
          $data['grantArr'] = $grantArr;

          if ($this->input->post('select_donor') != '') {
            $AN_donor_id = $this->input->post('select_donor');
          } else {
            $AN_donor_id = $donorAN[0]['approval_donor_id'];
          }
          $donor_detail = $this->Minternal->getDonorDetail($AN_donor_id);
          $data['donor_balance'] = $this->Minternal->get_donor_balance($approvalNoteDetails['0']["approval_id"], $donor_detail);
          $data['sum_amt'] = $this->Mapproval->int_amt_sumof($approvalNoteDetails['0']["approval_id"]);

          foreach ($donorAN as $rows):
            $amt_required[] = $rows['amt_required'];
          endforeach;
          $data['total_amount'] = array_sum($amt_required);
          $data['cpagetitle'] = "Send Internal Note";
          ;
		  
		   if($approvalNoteDetails[0]["donor"]!=''){
			$get_funder= $this->Minternal->getVendorBankDetails('funder_list', array('id'=>$approvalNoteDetails[0]["donor"]),array('id','fcra_status'));
			$fcra_status ='';
			$data['get_funder'] ='';
			if(!empty($get_funder)){
				$fcra_status = ucfirst(str_replace('_', ' ', $get_funder[0]['fcra_status']));
				$data['get_funder'] =  $fcra_status;
			}
		}
		$getDebitAccount = $this->vendor_model->get_all_details('debit_bank_details', array('donor_type'=>$data['get_funder']), array('id,account_number,bank_name'), '', '', '', true);
		$data['get_debit_account'] = $getDebitAccount;
		  
          $this->load->view('internal/user/sent_internal_note', $data);
        } else {
          $this->session->set_flashdata('successMsg', 'Access Denied!');
          redirect('approval/approval_note/confirmed');
        }
      }
	  
	  function getVendorBankDetails($id = NULL, $section = 'mylist') {

		$vendor_id = $this->input->post('vendor_id');
		$internal_id = $this->input->post('internal_id');
		
		$vendor_bank_id ='';
		if($internal_id!=''){
			$tdsDetails = $this->Minternal->getTdsDetails('tds_vendor',array('internal_id'=>$internal_id));
			if(!empty($tdsDetails)){
				$vendor_bank_id =  $tdsDetails[0]['vendor_bank_id'];
			}
		}
	
		$data['status']='0';
		$data['option_lists']='0';
		if($vendor_id!=''){
			$get_vendor_bank_details = $this->Minternal->getVendorBankDetails('vendor_bank_details',array('vendor_id'=>$vendor_id), array('id','vendor_id','account_number','bank_name'));
			if(!empty($get_vendor_bank_details)){
				$data['status']='1';
				$output .='<select class="form-control " name="vendor_bank_id" id="vendor_bank_id">';
				$output .= '<option value="">--Select--</option>';
				
				foreach($get_vendor_bank_details as $lits){
					$selected = "";
						if($lits['id'] == $vendor_bank_id){
							$selected = "selected";
						}
					  $output .= '<option '.$selected.' value="' . $lits['id'] . '">' . $lits['bank_name'] . ' - ' . $lits['account_number'] . '</option>';
				}
				$output .= '</select>';
			}
		}
		echo $output;
	}
	
	  function ajax_get_addinfo_details() { 
			$data['status'] = '0';$data['data'] ='';
			$programme = $this->input->post('programme');
			$donor = $this->input->post('donor');
			$budgethead = $this->input->post('budgethead');
			$lineitem = $this->input->post('lineitem');
			$selected_id = $this->input->post('selected_id');
			if($programme!='' && $donor!='' && $budgethead!='' && $lineitem!=''){
				$data['data'] = $this->Mapproval->getAdditionalDetails($programme, $donor, $budgethead, $lineitem);
				$data['status'] = '1';
				$data['selected_id'] = $selected_id;
			}
			echo json_encode($data);
      }

      function inserts_internal_note($id = '', $section = 'mylist') { 
		
		/* $approval_id = $this->input->post('approval_id');
		$amount_1 = $this->input->post('remain_amt');
		$amount_2 = $this->input->post('amount_toapprove');
		$error = '1';
		if($amount_1 !='' && $amount_2!=''){
			$Remaining_amt = str_replace(',', '', $amount_1);
			$approved_amt = str_replace(',', '', $amount_2);
			if($approved_amt < $Remaining_amt){
				
				$this->session->set_flashdata('successMsg', 'The amount exceeds amount approved and it is not possible to enter higher amount');
				redirect("/internal/sent_internal_note/$approval_id");
			}
		} */
		
		$this->load->model('vendor/vendor_model');
		$user_id = $this->session->userdata('emp_number');
		$partner_id = $this->session->userdata('partner_id');
		$conditionFinance = array('partner_id'=>$partner_id);
		$getFinanceUser = $this->vendor_model->get_all_details('approval_setting', $conditionFinance, array('finance'), '', '', '', true, 'ais');
		
		$data['finance_user_status'] =  $finance_user_status =  '';
		if(!empty($getFinanceUser)){
			$financeUserId = unserialize($getFinanceUser[0]->finance);
			if(!empty($financeUserId)){
				if(php72_in_array($user_id, $financeUserId)){
					$data['finance_user_status'] = $finance_user_status = '1';
				}
			}
		}
		
		$vendor_id = $this->input->post('vendor_id');
		if($vendor_id!=''){
			
			$tds_id = $this->input->post('tds_id');  
			if($tds_id!=''){
				#update
				$updateData = array(
					'taxable_amount'=>$this->input->post('taxable_amount'),
					'tds_type'=>$this->input->post('tds_type'),
					'tds_percentage'=>$this->input->post('tds_percentage'),
					'tds_custom_percentage'=>(string)$this->input->post('custom_percentage'),
					'tds_amount'=>$this->input->post('tds_amount'),
					'advance_paid'=>$this->input->post('advance_paid'),
					'net_amount'=>$this->input->post('net_amount'),
					'vendor_bank_id'=>$this->input->post('vendor_bank_id'),
					'vendor_id'=>$this->input->post('vendor_id'),
					'debit_bank_id'=>$this->input->post('debit_bank_id'),
					'updated_date'=>date('Y-m-d H:i:s')
				);
				
				$this->Minternal->updateTdsDetails('tds_vendor',array('id'=>$tds_id),$updateData);
				#echo'<pre>';print_r($updateData);die;
				
			}else{
				#Insert
				$insertData = array(
					'internal_id'=>$this->input->post('internal_edit_id'),
					'approval_id'=>$this->input->post('approval_id'),
					'taxable_amount'=>$this->input->post('taxable_amount'),
					'tds_type'=>$this->input->post('tds_type'),
					'tds_percentage'=>$this->input->post('tds_percentage'),
					'tds_custom_percentage'=>$this->input->post('custom_percentage'),
					'tds_amount'=>$this->input->post('tds_amount'),
					'advance_paid'=>$this->input->post('advance_paid'),
					'net_amount'=>$this->input->post('net_amount'),
					'vendor_bank_id'=>$this->input->post('vendor_bank_id'),
					'vendor_id'=>$this->input->post('vendor_id'),
					'debit_bank_id'=>$this->input->post('debit_bank_id'),
					'created_date'=>date('Y-m-d H:i:s')
				);
				$this->Minternal->insertTdsDetails('tds_vendor',$insertData);
			} 
		}
		
        $insert = $this->Minternal->insertInternalNote();
        $this->internalRequestMail($insert);
        $this->session->set_flashdata('successMsg', 'Internal Note sent successfully!');
        redirect('internal/internal_notes/pending');
      }

      function internalRequestMail($id = '') {
        $internalNoteDetails = $this->Minternal->getInternalNoteDetails($id);
        $employeeDetails = $this->Minternal->getEmployeeFromUserId($internalNoteDetails[0]['from_employee']);

        $RO_user = $this->Minternal->reportingUser('supUser', 'All', $employeeDetails[0]['id']);

        if (php72_count($RO_user)) {
          $toName = array('employee', 'ro');
          $toEmail = array('employeeEmail', 'reportAuthEmail');
          foreach ($toName as $key => $value) {
            $mailContent = $this->Minternal->mailContent($id, $value);
            $this->sendMailPhpMailer_IN($mailContent['employeeEmail'], $mailContent[$toEmail[$key]], 'Internal Note Request by Employee', $mailContent, $mailContent['attach']);
          }
        } else {
          $this->Minternal->internalRoAction('approve', $id);
          if ($internalNoteDetails['0']['programme_head'] == $internalNoteDetails['0']['from_employee']) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $approve_from = "Programhead";
            $this->Minternal->internalPhAction($option, $id, $ipaddress, $approve_from);
          }
          $mailContent = $this->Minternal->mailContent($id, 'ph');
          $to = array($mailContent['phEmail'], $mailContent['employeeEmail']);
          $this->sendMailPhpMailer_IN($mailContent['employeeEmail'], $mailContent['phEmail'], 'Internal Note Request by Employee', $mailContent, $mailContent['attach']);
        }
      }

      function insert_internal_note($id = NULL, $section = 'mylist') {
        $internal_edit_id = $this->input->post('internal_edit_id');
        $insert = $this->Minternal->updateInternalNote();
        $succ = 'Internal note updated sucessfullly';
        $this->session->set_flashdata('successMsg', $succ);
        redirect('internal/internaladmin/edit_internal_note/' . $internal_edit_id);
      }

      public function internal_notes() {
        $partner_id = $this->session->userdata('partner_id');
        $emp_id = $this->session->userdata('emp_number');
        $ro_user_count = $this->Minternal->get_ro_user($emp_id, $partner_id);
        $finance = unserialize($this->Mapproval->getApprovalSetting('finance'));

        $data['in_appcount'] = $appcount = totalin_apppending_count($emp_id);
        $data['ro_Usercount'] = '0';
        if (!empty($ro_user_count)) {
          $data['ro_Usercount'] = '1';

          $data['in_rocount'] = $rocount = totalin_ropending_count($emp_id);
        }
        $data['fin_Usercount'] = '0';
        if (php72_in_array($emp_id, $finance)) {
          $data['fin_Usercount'] = '1';
          $data['fin_count'] = $fincount = totalin_finpending_count();
        }

        $this->load->view('internal/user/internal_note', $data);
      }

      public function finance_list() {
        $partner_id = $this->session->userdata('partner_id');
        $emp_id = $this->session->userdata('emp_number');
        $ro_user_count = $this->Minternal->get_ro_user($emp_id, $partner_id);
        $finance = unserialize($this->Mapproval->getApprovalSetting('finance'));

        $data['in_appcount'] = $appcount = totalin_apppending_count($emp_id);

        $data['ro_Usercount'] = '0';
        if (!empty($ro_user_count)) {
          $data['ro_Usercount'] = '1';
          $data['in_rocount'] = $rocount = totalin_ropending_count($emp_id);
        }
        $data['fin_Usercount'] = '0';
        if (php72_in_array($emp_id, $finance)) {
          $data['fin_Usercount'] = '1';
          $data['fin_count'] = $fincount = totalin_finpending_count();
        }

        $this->load->view('internal/user/fininternal_note', $data);
      }

      public function approval($inid = '', $status = '') {
        $data['approvalNoteDetails'] = $approvalNoteDetails = $this->Mapproval->getApprovalNote($inid);
        $data['approval_id'] = $inid;
        $data['approval_no'] = $approvalNoteDetails[0]['approval_no'];

        $ro_user_count = $this->Minternal->get_ro_user($emp_id, $partner_id);
        $data['ro_Usercount'] = '0';
        if (!empty($ph_user_count)) {
          $data['ro_Usercount'] = '1';
        }

        $this->load->view('internal/user/approvalwise_internal', $data);
      }

      public function report() {
        $data['userList'] = $this->Mapproval->getAllUserList();
        $data['monthArray'] = array('1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'Aug', '9' => 'Sept', '10' => 'Oct', '11' => 'Nov', '12' => 'Des');

        $export = $this->input->post('export');
        $currentTab = $this->input->post('currentTab');

        if ($export == "export") {
          $status = 'status';
          switch ($currentTab) {
            case 'pending':
            $searchArray[] = "AP.status = 'pending'";
            break;
            case 'confirmed':
            $searchArray[] = "AP.status = 'confirmed'";
            break;
            case 'cancelled':
            $searchArray[] = "AP.status = 'cancelled'";
            break;
            case 'defered':
            $searchArray[] = "AP.status = 'defered'";
            break;
            case 'closed':
            $searchArray[] = "AP.status = 'closed'";
            break;
            case 'draft':
            $searchArray[] = "AP.status  = 'draft'";
            break;
          }

          if ($this->input->post('approval_no') != "")
            $searchArray[] = "AP.approval_no ='" . $this->input->post('approval_no') . "'";

          if ($this->input->post('purpose') != "")
            $searchArray[] = "AP.purpose like '%" . $this->input->post('purpose') . "%'";

          $where = php72_implode(" and ", $searchArray);
          $rowExport = $this->Mapproval->getLimitApprovalNotes($where, NULL, NULL, '', '', 'show All');

          if (php72_count($rowExport) != 0) {
            $this->Mmaster->customExport($this->input->post('report_name'), $rowExport);
            exit;
          }
        }
        $this->load->view('internal/admin/internal_report', $data);
      }

      public function DTinternal_report() {
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $action = $this->input->post('action');
        $currentTab = $this->input->post('currentTab');
        $section = $this->input->post('section');

        $columnArr = array('AP.approval_no', 'AP.date_of_seeking_approval', 'AP.amt_required', 'AP.budget_head', 'AP.donor', 'AP.from_employee', 'AP.purpose');

        if ($this->input->post('employee_id') != "") {
          $searchArray[] = "AN.from_employee ='" . $this->input->post('employee_id') . "'";
        }

        if ($this->input->post('date1') != "" && $this->input->post('date2') != "") {
          $searchArray[] = "INTER.date >='" . $this->input->post('date1') . "'";
          $searchArray[] = "INTER.date <='" . $this->input->post('date2') . "'";
        }
        $where = php72_implode(" and ", $searchArray);

        $approvalCount = $this->Minternal->getLimitInternalNotes('2', $where, '', '', $sort_column, $columnSortOrder, 'show All', 'report');
        $getAll_count = php72_count($approvalCount);
        $approval_lists = $this->Minternal->getLimitInternalNotes('2', $where, $limit, $start, $sort_column, $columnSortOrder, 'show All', 'report');
        $getLimit_count = php72_count($approval_lists);

        foreach ($approval_lists as $lists) {
          $date = '';
          if ($lists['date'] != '' && $lists['date'] != '0000-00-00') {
            $date = date('d-m-Y', strtotime($lists['date']));
          }
          $employe_id = $lists['from_employee'];
          $employeeName = $this->Minternal->getUserNameInfo($employe_id);
          $user_name = $employeeName[0]['user_name'];
          $nestedData = array();
          $nestedData[] = $lists['internal_no'];
          $nestedData[] = $lists['approval_no'];
          $nestedData[] = $date;
          $nestedData[] = $lists['amount_toapprove'];
          $nestedData[] = $lists['budget_head'];
          $nestedData[] = $lists['donor'];
          $nestedData[] = $user_name;
          $nestedData[] = $lists['payment_favor'];
          $data[] = $nestedData;

          $i++;
        }
        $json_data = array(
          "draw" => intval($requestData['draw']),
          "recordsTotal" => intval($getLimit_count),
          "recordsFiltered" => intval($getAll_count),
          "data" => $data,
          "POST" => $_POST
        );
        echo json_encode($json_data);
      }

      public function DTinternal_note() {
        $data = array();
        $i = $requestData['start'] + 1;
        $columnIndex = $_POST['order'][0]['column'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $start = $this->input->post('start');
        $limit = $this->input->post('length');

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $action = $this->input->post('action');

        $return_date_from = $this->input->post('return_date_from');
        $return_date_to = $this->input->post('return_date_to');
        $currentTab = $this->input->post('currentTab');
        $section = $this->input->post('section');


        $columnArr = array('INTER.internal_no', 'AN.approval_no', 'INTER.date', 'AN.from_employee', 'INTER.subject', 'INTER.payment_favor', 'AP.to_RO', 'INTER.amount_toapprove', 'INTER.programe', 'INTER.donor', 'INTER.budget_head');

        $status = 'status';
        if ($columnArr[$columnIndex] != '') {
          $sort_column = $columnArr[$columnIndex];
        }

        if ($section == 'rolist') {
          $currentTab = $this->input->post('status_type');
        }

        $searchArray = array();
        
        $status_type = $this->input->post('status_type');
        if ($this->input->post('status_type') != ""){
         
         $status_arry = array();
         foreach($status_type as $status_list){
          $status_arry[] = "'".$status_list."'";
        }
      }
      if(!empty($status_arry)){
       $split_status = implode(",", $status_arry);
       $searchArray[] = "INTER.status IN ($split_status)";
     }
     
     switch ($currentTab) {
      case 'pending':
      $searchArray[] = "INTER.status = 'pending'";
      break;
      case 'confirmed':
      $searchArray[] = "INTER.status = 'confirmed'";
      break;
      case 'cancelled':
      $searchArray[] = "INTER.status = 'cancelled'";
      break;
      case 'deferred':
      $searchArray[] = "INTER.status = 'defered'";
      break;
    }
    if($currentTab=='defered'){
     $searchArray[] = "INTER.status = 'defered'";
   }
   
   $searchArray[] = "INTER.partner_id ='" . $this->session->userdata('partner_id') . "'";

   if ($this->input->post('internal_no') != "")
    $searchArray[] = "INTER.internal_no ='" . $this->input->post('internal_no') . "'";

  if ($this->input->post('approval_no') != "")
    $searchArray[] = "AN.approval_no ='" . $this->input->post('approval_no') . "'";

  if ($this->input->post('finance_status') != "")
    $searchArray[] = "INTER.finance_status ='" . $this->input->post('finance_status') . "'";

  if ($this->input->post('reason') != "")
    $searchArray[] = "INTER.payment_favor like '%" . $this->input->post('reason') . "%'";

  if ($this->input->post('reason1') != "")
    $searchArray[] = "INTER.reason_payment_sougnt like '%" . $this->input->post('reason1') . "%'";


  switch ($section) {
    case 'rolist':
    $searchArray[] = "((INTER.to IN ('" . $this->session->userdata('user') . "')) or (AN.to_RO ='" . $this->session->userdata('user') . "'))";
    $admin = 'Show all';
    $mystatus = "RO_status";
    $title = 'Reporting Officer';
    $status = 'RO_status';
    break;
    case 'finlist':
    if ($this->input->post('finance_status') == "") {
      $searchArray[] = "INTER.status ='confirmed' and INTER.finance_status ='inprogress'";
    } else {
      $searchArray[] = "";
    }
    default:
    $admin = NULL;
  }
  $where = implode(" and ", $searchArray);

  $internalCount = $this->Minternal->getLimitInternalNotes('1', $where, '', '', $sort_column, $columnSortOrder, $admin);
  $getAll_count = php72_count($internalCount);

  $internal_lists = $this->Minternal->getLimitInternalNotes('1', $where, $limit, $start, $sort_column, $columnSortOrder, $admin);
  $getLimit_count = php72_count($internal_lists);

  foreach ($internal_lists as $lists) {

    $Date_str = $set_name = '';
    if ($lists['date'] != '' && $lists['date'] != '0000-00-00') {
      $Date_str = date('d-m-Y', strtotime($lists['date']));
    }
    $employe_id = $lists['from_employee'];
    $to_RO = $lists['to_RO'];
    $programme_head = $lists['programme_head'];
            #$employe_id = '23';
    $employeeName = $this->Mapproval->getUserNameInfo($employe_id);
    $user_name = $employeeName[0]['user_name'];

    $RoName = $this->Mapproval->getUserNameInfo($to_RO);
    $ro_name = $RoName[0]['user_name'];

    $approval_userName = $ro_username = '';
    if ($currentTab == 'pending') {
      if ($lists['PH_status'] == 'pending') {
        $RoName = $this->Mapproval->getUserNameInfo($to_RO);
        $approval_userName = $RoName[0]['user_name'];
      } else if ($lists['CEO_status'] == 'pending') {
        $ceoUser = $this->Mapproval->getApprovalSetting('ceo');
        $ceoName = $this->Mapproval->getUserNameInfo($ceoUser);
        $approval_userName = $ceoName[0]['user_name'];
      }
    }

    $get_grantName = $this->Minternal->get_grantName($lists['grant_id']);
    $url = base_url() . 'index.php/internal/internal_note_details/' . $lists['internal_id'] . '/mylist';
    $view_btn = "<a href=" . $url . " >" . $lists['internal_no'] . "</a>";

    if ($lists['RO_status'] == 'pending') {
      $RoName = $this->Mapproval->getUserNameInfo($to_RO);
      $ro_username = $RoName[0]['user_name'] . " (RO)";
    }
    if ($lists['RO_status'] == 'pending' && $currentTab == 'pending') {
      $RoName = $this->Mapproval->getUserNameInfo($to_RO);
      $ro_username = $RoName[0]['user_name'] . " (RO)";
    }

    $status = $lists["status"];
    if ($lists["status"] == 'defered') {
      $status = 'deferred';
    }
    $nestedData = array();
    $nestedData[] = $view_btn;
    $nestedData[] = $lists['approval_no'];
    $nestedData[] = $Date_str;
    if ($section == 'rolist') {
      $nestedData[] = $user_name;
    }
    $nestedData[] = (strlen($lists['subject']) > 40) ? substr($lists['subject'], 0, 40) . ".." : $lists['subject'];
    $nestedData[] = $lists['payment_favor'];
    $nestedData[] = $ro_username;
    $nestedData[] = number_format($lists['amount_toapprove']);
    $nestedData[] = $lists['programe'];
    $nestedData[] = $lists['donor'];
    $nestedData[] = $lists['budget_head'];
    $nestedData[] = ucfirst($status);
    $data[] = $nestedData;

    $i++;
  }
  $json_data = array(
    "draw" => intval($requestData['draw']),
    "recordsTotal" => intval($getLimit_count),
    "recordsFiltered" => intval($getAll_count),
    "data" => $data,
    "POST" => $_POST
  );
  echo json_encode($json_data);
}

public function DTfininternal_note() {
  $data = array();
  $i = $requestData['start'] + 1;
  $columnIndex = $_POST['order'][0]['column'];
  $columnSortOrder = $_POST['order'][0]['dir'];
  $start = $this->input->post('start');
  $limit = $this->input->post('length');

  $date_from = $this->input->post('date_from');
  $date_to = $this->input->post('date_to');
  $action = $this->input->post('action');

  $return_date_from = $this->input->post('return_date_from');
  $return_date_to = $this->input->post('return_date_to');
  $currentTab = $this->input->post('currentTab');
  $section = $this->input->post('section');


  $columnArr = array('INTER.internal_no', 'AN.approval_no', 'INTER.date', 'AN.from_employee', 'INTER.subject', 'INTER.payment_favor', 'AP.to_RO', 'INTER.amount_toapprove', 'INTER.programe', 'INTER.donor', 'INTER.budget_head', 'INTER.status', 'AN.RO_date', 'AN.to_RO');

  $status = 'status';
  if ($columnArr[$columnIndex] != '') {
    $sort_column = $columnArr[$columnIndex];
  }

  if ($section == 'rolist') {
    $currentTab = $this->input->post('status_type');
  }

  $searchArray = array();
  switch ($currentTab) {
    case 'pending':
    $searchArray[] = "INTER.status = 'pending'";
    break;
    case 'confirmed':
    $searchArray[] = "INTER.status = 'confirmed'";
    break;
    case 'cancelled':
    $searchArray[] = "INTER.status = 'cancelled'";
    break;
    case 'deferred':
    $searchArray[] = "INTER.status = 'defered'";
    break;
  }
  $searchArray[] = "INTER.partner_id ='" . $this->session->userdata('partner_id') . "'";

  if ($this->input->post('internal_no') != "")
    $searchArray[] = "INTER.internal_no ='" . $this->input->post('internal_no') . "'";

  if ($this->input->post('approval_no') != "")
    $searchArray[] = "AN.approval_no ='" . $this->input->post('approval_no') . "'";



  if ($this->input->post('reason') != "")
    $searchArray[] = "INTER.payment_favor like '%" . $this->input->post('reason') . "%'";

  if ($this->input->post('reason1') != "")
    $searchArray[] = "INTER.reason_payment_sougnt like '%" . $this->input->post('reason1') . "%'";

if ($this->input->post('donor') != "")
    $searchArray[] = "D.master_name like '%" . $this->input->post('donor') . "%'";


  if ($this->input->post('finance_status') == "") {
    $searchArray[] = "INTER.status ='confirmed' and INTER.finance_status ='inprogress'";
  } else if ($this->input->post('finance_status') != "") {
    if ($this->input->post('finance_status') == "pending") {
      $searchArray[] = "INTER.status ='confirmed' and INTER.finance_status ='inprogress'";
    } else {
      $searchArray[] = "INTER.status ='confirmed' and INTER.finance_status ='" . $this->input->post('finance_status') . "'";
    }
  }
  $admin = "Show all";

  $where = implode(" and ", $searchArray);

  $internalCount = $this->Minternal->getLimitInternalNotes('1', $where, '', '', $sort_column, $columnSortOrder, $admin);
  $getAll_count = php72_count($internalCount);

  $internal_lists = $this->Minternal->getLimitInternalNotes('1', $where, $limit, $start, $sort_column, $columnSortOrder, $admin);
  $getLimit_count = php72_count($approval_lists);

  foreach ($internal_lists as $lists) {

    $Date_str = $set_name = '';
    if ($lists['date'] != '' && $lists['date'] != '0000-00-00') {
      $Date_str = date('d-m-Y', strtotime($lists['date']));
    }
    $employe_id = $lists['from_employee'];
    $to_RO = $lists['to_RO'];
    $programme_head = $lists['programme_head'];
            #$employe_id = '23';
    $employeeName = $this->Mapproval->getUserNameInfo($employe_id);
    $user_name = $employeeName[0]['user_name'];

    $RoName = $this->Mapproval->getUserNameInfo($to_RO);
    $ro_name = $RoName[0]['user_name'];

    $approval_userName = $ro_username = '';
    if ($currentTab == 'pending') {
      if ($lists['PH_status'] == 'pending') {
        $RoName = $this->Mapproval->getUserNameInfo($to_RO);
        $approval_userName = $RoName[0]['user_name'];
      } else if ($lists['CEO_status'] == 'pending') {
        $ceoUser = $this->Mapproval->getApprovalSetting('ceo');
        $ceoName = $this->Mapproval->getUserNameInfo($ceoUser);
        $approval_userName = $ceoName[0]['user_name'];
      }
    }

    $get_grantName = $this->Minternal->get_grantName($lists['grant_id']);
    $url = base_url() . 'index.php/internal/internal_note_details/' . $lists['internal_id'] . '/mylist';
    $view_btn = "<a href=" . $url . " >" . $lists['internal_no'] . "</a>";

    if ($lists['RO_status'] == 'pending') {
      $RoName = $this->Mapproval->getUserNameInfo($to_RO);
      $ro_username = $RoName[0]['user_name'] . " (RO)";
    }
    if ($lists['RO_status'] == 'pending' && $currentTab == 'pending') {
      $RoName = $this->Mapproval->getUserNameInfo($to_RO);
      $ro_username = $RoName[0]['user_name'] . " (RO)";
    }

    $status = $lists["status"];
    if ($lists["status"] == 'defered') {
      $status = 'deferred';
    }
    $nestedData = array();
    $nestedData[] = $view_btn;
    $nestedData[] = $lists['approval_no'];
	$Date_RO_date = '';
    if ($lists['RO_date'] != '' && $lists['RO_date'] != '0000-00-00') {
      $Date_RO_date = date('d-m-Y', strtotime($lists['RO_date']));
    } if ($lists['in_ro_date'] != '' && $lists['in_ro_date'] != '0000-00-00') {
		$Date_RO_date = date('d-m-Y', strtotime($lists['in_ro_date']));
	}
	$nestedData[] = $Date_RO_date;
   
    $nestedData[] = $user_name;
    $nestedData[] = (strlen($lists['subject']) > 40) ? substr($lists['subject'], 0, 40) . ".." : $lists['subject'];
    $nestedData[] = $lists['payment_favor'];
//            $nestedData[] = $ro_username;
    $nestedData[] = number_format($lists['amount_toapprove']);
    $nestedData[] = $lists['programe'];
    $nestedData[] = $lists['donor'];
    $nestedData[] = $lists['budget_head'];
    $nestedData[] = ucfirst($status);
	$nestedData[] = $Date_str;
	
	$getEmpName = $this->Minternal->getUserNameInfo($lists['to_RO']);
	$ROName ='';
	if(!empty($getEmpName)){
		$ROName = $getEmpName[0]['user_name'];
	}
	$nestedData[] = $ROName;
	
    $data[] = $nestedData;

    $i++;
  }
  $json_data = array(
    "draw" => intval($requestData['draw']),
    "recordsTotal" => intval($getLimit_count),
    "recordsFiltered" => intval($getAll_count),
    "data" => $data,
    "POST" => $_POST
  );
  echo json_encode($json_data);
}

public function DTapproval_internalnote() {
  $data = array();
  $i = $requestData['start'] + 1;
  $columnIndex = $_POST['order'][0]['column'];
  $columnSortOrder = $_POST['order'][0]['dir'];
  $start = $this->input->post('start');
  $limit = $this->input->post('length');

  $date_from = $this->input->post('date_from');
  $date_to = $this->input->post('date_to');
  $action = $this->input->post('action');

  $return_date_from = $this->input->post('return_date_from');
  $return_date_to = $this->input->post('return_date_to');
  $currentTab = $this->input->post('currentTab');
  $section = $this->input->post('section');

  $columnArr = array('INTER.internal_no', 'AN.approval_no', 'INTER.date', 'AN.from_employee', 'INTER.subject', 'INTER.payment_favor', 'AP.to_RO', 'INTER.amount_toapprove', 'INTER.programe', 'INTER.donor', 'INTER.budget_head', 'INTER.line_item', 'INTER.additionalinfo');

  $status = 'status';
  if ($columnArr[$columnIndex] != '') {
    $sort_column = $columnArr[$columnIndex];
  }

  if ($section == 'rolist') {
    $currentTab = $this->input->post('status_type');
  }

  $searchArray = array();
  switch ($currentTab) {
    case 'pending':
    $searchArray[] = "INTER.status = 'pending'";
    break;
    case 'confirmed':
    $searchArray[] = "INTER.status = 'confirmed'";
    break;
    case 'cancelled':
    $searchArray[] = "INTER.status = 'cancelled'";
    break;
    case 'deferred':
    $searchArray[] = "INTER.status = 'defered'";
    break;
  }
  $searchArray[] = "INTER.partner_id ='" . $this->session->userdata('partner_id') . "'";

  if ($this->input->post('internal_no') != "")
    $searchArray[] = "INTER.internal_no ='" . $this->input->post('internal_no') . "'";

  if ($this->input->post('approval_no') != "")
    $searchArray[] = "AN.approval_no ='" . $this->input->post('approval_no') . "'";

  if ($this->input->post('finance_status') != "")
    $searchArray[] = "INTER.finance_status ='" . $this->input->post('finance_status') . "'";

  if ($this->input->post('reason') != "")
    $searchArray[] = "INTER.payment_favor like '%" . $this->input->post('reason') . "%'";

  if ($this->input->post('reason1') != "")
    $searchArray[] = "INTER.reason_payment_sougnt like '%" . $this->input->post('reason1') . "%'";


  switch ($section) {
    case 'rolist':
    $searchArray[] = "((INTER.to IN ('" . $this->session->userdata('user') . "')) or (AN.to_RO ='" . $this->session->userdata('user') . "'))";
    $admin = 'Show all';
    $mystatus = "RO_status";
    $title = 'Reporting Officer';
    $status = 'RO_status';
    break;
    default:
    $admin = NULL;
  }
  $where = implode(" and ", $searchArray);

  $internalCount = $this->Minternal->getLimitInternalNotes('1', $where, '', '', $sort_column, $columnSortOrder, $admin);
  $getAll_count = php72_count($internalCount);

  $internal_lists = $this->Minternal->getLimitInternalNotes('1', $where, $limit, $start, $sort_column, $columnSortOrder, $admin);
  $getLimit_count = php72_count($approval_lists);

  foreach ($internal_lists as $lists) {

    $Date_str = $set_name = '';
    if ($lists['date'] != '' && $lists['date'] != '0000-00-00') {
      $Date_str = date('d-m-Y', strtotime($lists['date']));
    }
    $employe_id = $lists['from_employee'];
    $to_RO = $lists['to_RO'];
    $programme_head = $lists['programme_head'];
            #$employe_id = '23';
    $employeeName = $this->Mapproval->getUserNameInfo($employe_id);
    $user_name = $employeeName[0]['user_name'];

    $RoName = $this->Mapproval->getUserNameInfo($to_RO);
    $ro_name = $RoName[0]['user_name'];

    $approval_userName = $ro_username = '';
    if ($currentTab == 'pending') {
      if ($lists['PH_status'] == 'pending') {
        $RoName = $this->Mapproval->getUserNameInfo($to_RO);
        $approval_userName = $RoName[0]['user_name'];
      } else if ($lists['CEO_status'] == 'pending') {
        $ceoUser = $this->Mapproval->getApprovalSetting('ceo');
        $ceoName = $this->Mapproval->getUserNameInfo($ceoUser);
        $approval_userName = $ceoName[0]['user_name'];
      }
    }

    $get_grantName = $this->Minternal->get_grantName($lists['grant_id']);
    $url = base_url() . 'index.php/internal/internal_note_details/' . $lists['internal_id'] . '/mylist';
    $view_btn = "<a class='bordergrn-btn-outline' href=" . $url . " >" . 'View' . "</a>";

    if ($lists['RO_status'] == 'pending') {
      $RoName = $this->Mapproval->getUserNameInfo($to_RO);
      $ro_username = $RoName[0]['user_name'] . " (RO)";
    }
    if ($lists['RO_status'] == 'pending' && $currentTab == 'pending') {
      $RoName = $this->Mapproval->getUserNameInfo($to_RO);
      $ro_username = $RoName[0]['user_name'] . " (RO)";
    }

    $status = $lists["status"];
    if ($lists["status"] == 'defered') {
      $status = 'deferred';
    }
    $view_internal = "<a style='padding: 10px;' class='action_cls' href=" . $url . " >" . $lists['internal_no'] . "</a>";
    $nestedData = array();
    $nestedData[] = $view_internal;
    $nestedData[] = $lists['approval_no'];
    $nestedData[] = $Date_str;
    $nestedData[] = $user_name;
    $nestedData[] = (strlen($lists['subject']) > 40) ? substr($lists['subject'], 0, 40) . ".." : $lists['subject'];
    $nestedData[] = $lists['payment_favor'];

    $nestedData[] = $ro_username;
    $nestedData[] = $lists['amount_toapprove'];
    $nestedData[] = $lists['programe'];
    $nestedData[] = $lists['donor'];
    $nestedData[] = $lists['budget_head'];
    $nestedData[] = $lists['line_item'];
    $nestedData[] = $lists['additionalinfo'];
    $nestedData[] = ucfirst($status);
//            $nestedData[] = $view_btn;
    $data[] = $nestedData;

    $i++;
  }
  $json_data = array(
    "draw" => intval($requestData['draw']),
    "recordsTotal" => intval($getLimit_count),
    "recordsFiltered" => intval($getAll_count),
    "data" => $data,
    "POST" => $_POST
  );
  echo json_encode($json_data);
}

public function ecport_in_approval() {
  $date_from = $this->input->post('date_from');
  $date_to = $this->input->post('date_to');
  $action = $this->input->post('action');

  $return_date_from = $this->input->post('return_date_from');
  $return_date_to = $this->input->post('return_date_to');
  $currentTab = $this->input->post('currentTab');
  $section = $this->input->post('section');

  $searchArray = array();
  switch ($currentTab) {
    case 'pending':
    $searchArray[] = "INTER.status = 'pending'";
    break;
    case 'confirmed':
    $searchArray[] = "INTER.status = 'confirmed'";
    break;
    case 'cancelled':
    $searchArray[] = "INTER.status = 'cancelled'";
    break;
    case 'deferred':
    $searchArray[] = "INTER.status = 'defered'";
    break;
  }
  $searchArray[] = "INTER.partner_id ='" . $this->session->userdata('partner_id') . "'";

  if ($this->input->post('internal_no') != "")
    $searchArray[] = "INTER.internal_no ='" . $this->input->post('internal_no') . "'";

  if ($this->input->post('approval_no') != "")
    $searchArray[] = "AN.approval_no ='" . $this->input->post('approval_no') . "'";

  if ($this->input->post('finance_status') != "")
    $searchArray[] = "INTER.finance_status ='" . $this->input->post('finance_status') . "'";

  if ($this->input->post('reason') != "")
    $searchArray[] = "INTER.payment_favor like '%" . $this->input->post('reason') . "%'";

  if ($this->input->post('reason1') != "")
    $searchArray[] = "INTER.reason_payment_sougnt like '%" . $this->input->post('reason1') . "%'";

  switch ($section) {
    case 'rolist':
    $searchArray[] = "((INTER.to IN ('" . $this->session->userdata('user') . "')) or (AN.to_RO ='" . $this->session->userdata('user') . "'))";
    $admin = 'Show all';
    $mystatus = "RO_status";
    $title = 'Reporting Officer';
    $status = 'RO_status';
    break;
    default:
    $admin = NULL;
  }
  $where = implode(" and ", $searchArray);

  $data_lists = $this->Minternal->getLimitInternalNotes('1', $where, '', '', array(), array(), $admin);

  header("Content-type: application/csv");
  header("Content-Disposition: attachment; filename=\"IN_approved_notes_" . date('m-d-Y') . ".csv\"");
  header("Pragma: no-cache");
  header("Expires: 0");
  $handle = fopen('php://output', 'w');
  fputcsv($handle, array(
    'Internal Note Number',
    'Date',
    'Approval Number',
    'From',
    'Subject',
    'Amount for which approval has been taken',
    'Programme',
    'Budget Head',
    'Donor - Grant',
    'Cost Centre',
    'Detail',
    'Reason for Deviation:',
    'Reason for which payment is sought',
    'Supporting documents attached',
    'Amount to be approved',
    'Reporting Officers Approval',
    'Programme Head Approval',
    'Line Item',
  ));

  foreach ($data_lists as $list) {
    $emp_name = '';
    if ($list['from'] != '') {
      $emp_name_arr = $this->Mapproval->getUserNameInfo($list['from']);
      $emp_name = $emp_name_arr[0]['user_name'];
    }
    $to_RO = '';
    if ($list['to_RO'] != '') {
      $ro_name_arr = $this->Mapproval->getUserNameInfo($list['to_RO']);
      $to_RO = $ro_name_arr[0]['user_name'];
    }
    $date = '';
    if ($list['date'] != '0000-00-00 00:00:00' && $list['date'] != '0000-00-00') {
      $date = $list['date'];
    }
    $date_of_seeking_approval = '';
    if ($list['date_of_seeking_approval'] != '0000-00-00 00:00:00' && $list['date_of_seeking_approval'] != '0000-00-00') {
      $date_of_seeking_approval = $list['date_of_seeking_approval'];
    }
    $date_payment_required = '';
    if ($list['date_payment_required'] != '0000-00-00 00:00:00' && $list['date_payment_required'] != '0000-00-00') {
      $date_payment_required = $list['date_payment_required'];
    }

    fputcsv($handle, array(
      $list['internal_no'],
      $date,
      $list['approval_no'],
      $emp_name,
      $list['subject'],
      $list['amount_toapprove'],
      $list['programe'],
      $list['budget_head'],
      $list['donor'],
      $list['cost_centre'],
      $list['additionalinfo'],
      $list['reason_for_deviation'],
      $list['supporting_documents'],
      $list['reason_payment_sougnt'],
      $list['total_amount'],
      $to_RO,
      $list['PH_status'],
      $list['line_item']
    ));
  }

  fclose($handle);
  exit;
}

public function finddgance_list() {
  $partner_id = $this->session->userdata('partner_id');
  $emp_id = $this->session->userdata('emp_number');
  $ro_user_count = $this->Minternal->get_ro_user($emp_id, $partner_id);
  $finance = unserialize($this->Mapproval->getApprovalSetting('finance'));

  $data['in_appcount'] = $appcount = totalin_apppending_count($emp_id);

  $data['ro_Usercount'] = '0';
  if (!empty($ro_user_count)) {
    $data['ro_Usercount'] = '1';
    $data['in_rocount'] = $rocount = totalin_ropending_count($emp_id);
  }
  $data['fin_Usercount'] = '0';
  if (php72_in_array($emp_id, $finance)) {
    $data['fin_Usercount'] = '1';
    $data['fin_count'] = $fincount = totalin_finpending_count();
  }

  $this->load->view('internal/user/fininternal_note', $data);
}

public function archive() {
  $data['financialList'] = $this->Minternal->getfinanciallist();
  $partner_id = $this->session->userdata('partner_id');
  $emp_id = $this->session->userdata('emp_number');
  $ro_user_count = $this->Minternal->get_ro_user($emp_id, $partner_id);
  $finance = unserialize($this->Mapproval->getApprovalSetting('finance'));

  $data['in_appcount'] = $appcount = totalin_apppending_count($emp_id);
  $data['ro_Usercount'] = '0';
  if (!empty($ro_user_count)) {
    $data['ro_Usercount'] = '1';
    $data['in_rocount'] = $rocount = totalin_ropending_count($emp_id);
  }
  $data['fin_Usercount'] = '0';
  if (php72_in_array($emp_id, $finance)) {
    $data['fin_Usercount'] = '1';
    $data['fin_count'] = $fincount = totalin_finpending_count();
  }

  $this->load->view('internal/user/archive', $data);
}

public function DTarchive() {
  $data = array();
  $i = $requestData['start'] + 1;
  $columnIndex = $_POST['order'][0]['column'];
  $columnSortOrder = $_POST['order'][0]['dir'];
  $start = $this->input->post('start');
  $limit = $this->input->post('length');

  $date_from = $this->input->post('date_from');
  $date_to = $this->input->post('date_to');
  $action = $this->input->post('action');

  $return_date_from = $this->input->post('return_date_from');
  $return_date_to = $this->input->post('return_date_to');
  $currentTab = $this->input->post('currentTab');
  $section = $this->input->post('section');
  
  $internal_note_type = $this->input->post('internal_note_type');

  $columnArr = array('INTER.internal_no', 'AN.approval_no', 'INTER.date', 'AN.from_employee', 'INTER.subject', 'INTER.payment_favor', 'AP.to_RO', 'INTER.amount_toapprove', 'INTER.programe', 'INTER.donor', 'INTER.budget_head');

  $status = 'status';
  if ($columnArr[$columnIndex] != '') {
    $sort_column = $columnArr[$columnIndex];
  }
  $status = 'status';

  $searchArray = array();
  switch ($currentTab) {
    case 'pending':
    $searchArray[] = "INTER.status = 'pending'";
    break;
    case 'confirmed':
    $searchArray[] = "INTER.status = 'confirmed'";
    break;
    case 'cancelled':
    $searchArray[] = "INTER.status = 'cancelled'";
    break;
    case 'deferred':
    $searchArray[] = "INTER.status = 'defered'";
    break;
  }

  $return_date_from = $this->input->post('interval_date');
  $get_date = explode('-', $return_date_from);
  $from = $get_date[0];
  $to = $get_date[1];

  if ($from == NULL || $to == NULL) {
    $from = '2009-04-01';
    $to = '2010-03-30';
  } else {
    $from = date('Y-m-01', strtotime('April' . substr($from, strlen($from) - 4)));
    $to = date('Y-m-t', strtotime('March' . substr($to, strlen($to) - 4)));
  }

  $section = isset($section) && $section != '' ? $section : 'mylist';
  $subUsers = php72_implode("','", $this->Mapproval->reportingUser('subUser', 'userId'));
  switch ($section) {
    case 'mylist':
    if($internal_note_type!='' && $internal_note_type=='1'){
     $searchArray[] = "AN.from_employee ='" . $this->session->userdata('user') . "'";
   }else if($internal_note_type!='' && $internal_note_type=='0'){
     $searchArray[] = "";
   }else{
     $searchArray[] = "AN.from_employee ='" . $this->session->userdata('user') . "'";
   }
   $admin = NULL;
   $mystatus = 'status';
   $title = 'My';
   break;
   case 'rolist':
   $searchArray[] = "AN.from_employee IN ('" . $subUsers . "')";
   $searchArray[] = "AN.to_RO =  '" . $this->session->userdata('user') . "' ";
   $admin = 'Show all';
   $mystatus = "RO_status";
   $title = 'Reporting Officer';
   $status = 'RO_status';
   break;
   case 'phlist':
   $title = 'Programme Head';
   $searchArray[] = "MP.programme_head = '" . $this->session->userdata('user') . "'";
   if ($currentTab == 'pending' || $currentTab == 'confirmed') {
    $searchArray[] = "INTER.RO_status = 'confirmed'";
  }
  $admin = 'Show all';
  $mystatus = 'PH_status';
  break;
  case 'finance':
  $admin = 'Show all';
  $title = 'Finance';
  $mystatus = 'finance_status';
  break;

  default:
  $admin = NULL;
}

if ($this->input->post('internal_no') != "")
  $searchArray[] = "INTER.internal_no ='" . $this->input->post('internal_no') . "'";

if ($this->input->post('approval_no') != "")
  $searchArray[] = "AN.approval_no ='" . $this->input->post('approval_no') . "'";

if ($this->input->post('finance_status') != "")
  $searchArray[] = "INTER.finance_status ='" . $this->input->post('finance_status') . "'";

if ($this->input->post('reason') != "")
  $searchArray[] = "INTER.payment_favor like '%" . $this->input->post('reason') . "%'";

if ($this->input->post('reason1') != "")
  $searchArray[] = "INTER.reason_payment_sougnt like '%" . $this->input->post('reason1') . "%'";

if (isset($searchArray))
  $where = implode(" and ", $searchArray);
else
  $where = "2=2";

$internalCount = $this->Minternal->getarchiveInternalNotes($from, $to, NULL, NULL, $where);
$getAll_count = php72_count($internalCount);

$internal_lists = $this->Minternal->getarchiveInternalNotes($from, $to, $limit, $start, $where);
$getLimit_count = php72_count($internal_lists);

foreach ($internal_lists as $lists) {

  $Date_str = $set_name = '';
  if ($lists['date'] != '' && $lists['date'] != '0000-00-00') {
    $Date_str = date('d-m-Y', strtotime($lists['date']));
  }
  $employe_id = $lists['from_employee'];
  $to_RO = $lists['to_RO'];
  $programme_head = $lists['programme_head'];
            #$employe_id = '23';
  $employeeName = $this->Mapproval->getUserNameInfo($employe_id);
  $user_name = $employeeName[0]['user_name'];

  $RoName = $this->Mapproval->getUserNameInfo($to_RO);
  $ro_name = $RoName[0]['user_name'];

  $approval_userName = $ro_username = '';
  if ($currentTab == 'pending') {
    if ($lists['PH_status'] == 'pending') {
      $RoName = $this->Mapproval->getUserNameInfo($to_RO);
      $approval_userName = $RoName[0]['user_name'];
    } else if ($lists['CEO_status'] == 'pending') {
      $ceoUser = $this->Mapproval->getApprovalSetting('ceo');
      $ceoName = $this->Mapproval->getUserNameInfo($ceoUser);
      $approval_userName = $ceoName[0]['user_name'];
    }
  }

  $get_grantName = $this->Minternal->get_grantName($lists['grant_id']);
  $url = base_url() . 'index.php/internal/internal_note_details/' . $lists['internal_id'];
  $view_btn = "<a href=" . $url . " >" . $lists['internal_no'] . "</a>";
  $action_url = "<a title='View Internal Note' style='padding: 10px;' href=" . $url . "><i class='fas fa-eye'></i></a>";

  if ($lists['RO_status'] == 'pending') {
    $RoName = $this->Mapproval->getUserNameInfo($to_RO);
    $ro_username = $RoName[0]['user_name'] . " (RO)";
  }
  if ($lists['RO_status'] == 'pending' && $currentTab == 'pending') {
    $RoName = $this->Mapproval->getUserNameInfo($to_RO);
    $ro_username = $RoName[0]['user_name'] . " (RO)";
  }

  $status = $lists["status"];
  if ($lists["status"] == 'defered') {
    $status = 'deferred';
  }
  $nestedData = array();
  $nestedData[] = $view_btn;
  $nestedData[] = $lists['approval_no'];
  $nestedData[] = $Date_str;
  $nestedData[] = $user_name;
  $nestedData[] = (strlen($lists['subject']) > 40) ? substr($lists['subject'], 0, 40) . ".." : $lists['subject'];
  $nestedData[] = $lists['payment_favor'];
  $nestedData[] = $lists['amount_toapprove'];
  $nestedData[] = $lists['donor'];
  $nestedData[] = $lists['budget_head'];
  $nestedData[] = $status;
  $nestedData[] = $action_url;

  $data[] = $nestedData;

  $i++;
}
$json_data = array(
  "draw" => intval($requestData['draw']),
  "recordsTotal" => intval($getLimit_count),
  "recordsFiltered" => intval($getAll_count),
  "data" => $data,
  "POST" => $_POST
);
echo json_encode($json_data);
}

function internal_note_details($id = '', $section = 'mylist') {
  
		#echo  $_SERVER['REMOTE_ADDR'];die;
  

  $partner_id = $this->session->userdata('partner_id');
  $emp_id = $this->session->userdata('emp_number');
  $finance = unserialize($this->Mapproval->getApprovalSetting('finance'));

  $data['fin_Usercount'] = '0';
  if (php72_in_array($emp_id, $finance)) {
    $data['fin_Usercount'] = '1';
  }

  $data['internalNoteDetails'] = $internalNoteDetails = $this->Minternal->getInternalNoteDetails($id);

  /* amount recoverable */
  if (php72_cmp($data['fin_Usercount']) == 1) {
    $data['recover_detail'] = $recover_detail = $this->Minternal->getRecoveredDetail($id);
    if (php72_count($recover_detail) > 0) {
      $data['recover_amt'] = $this->Minternal->getRecoveredAmount($recover_detail[0]['id']);
    }
  }

  $to_RO = $internalNoteDetails[0]['to_RO'];
  $employeeName = $this->Minternal->getUserNameInfo($to_RO);
  $data['reporting_officer'] = $employeeName[0]['user_name'];

  $programme_head = $internalNoteDetails[0]['programme_head'];
  $programme_headName = $this->Minternal->getUserNameInfo($programme_head);
  $data['programme_head_name'] = $programme_headName[0]['user_name'];

  $from_employee = $internalNoteDetails[0]['from_employee'];
  $from_employeeName = $this->Minternal->getUserNameInfo($from_employee);
  $data['from_employeeName'] = $from_employeeName[0]['user_name'];

  $emp_no = $this->Minternal->getEmployeeFromUserId($internalNoteDetails[0]['from_employee']);
  $sp = $this->Minternal->reportingUser('supUser', '', $emp_no['0']['emp_number']);

  if ($internalNoteDetails[0]['an_from_emp'] == $internalNoteDetails[0]['from']) {
    $data['ro_officer_name'] = $this->Minternal->getUserNameInfo($internalNoteDetails[0]['to_RO']);
  } elseif ($internalNoteDetails[0]['an_from_emp'] != $internalNoteDetails[0]['from'] && php72_count($sp) == 1) {
    $data['ro_officer_name'] = $sp['0']['user_name'];
  } elseif ($internalNoteDetails[0]['an_from_emp'] != $internalNoteDetails[0]['from'] && php72_count($sp) > 1) {
    $data['ro_officer_name'] = $this->Minternal->getUserNameInfo($internalNoteDetails[0]['to_RO']);
  }
  $get_grantName = $this->Minternal->get_grantName($internalNoteDetails[0]['grant_id']);
  if ($get_grantName[0]->name != '') {
    $data['donor_grant'] = $internalNoteDetails[0]["donor"] . '<strong> - </strong>' . $get_grantName[0]->name;
  } else {
    $data['donor_grant'] = $internalNoteDetails[0]["donor"];
  }
  if($_SERVER['REMOTE_ADDR']=='172.31.2.248'){
			#echo'<pre>';print_r($data);die;
  }
  if($internalNoteDetails[0]["donor_id"]!=''){
		$get_funder= $this->Minternal->getVendorBankDetails('funder_list', array('id'=>$internalNoteDetails[0]["donor_id"]),array('id','fcra_status'));
		$fcra_status ='';
		$data['get_funder'] ='';
		if(!empty($get_funder)){
			$fcra_status = ucfirst(str_replace('_', ' ', $get_funder[0]['fcra_status']));
			$data['get_funder'] =  $fcra_status;
		}
	}

  $this->load->view('internal/user/internal_note_details', $data);
}

function amountAvailableforssval($programmeid = '', $donorid = '', $budgetid = '', $lineitemid = '', $sublineitemid = '', $grant_id = '') {
  $financialArray = $this->Mapproval->findCurrentFinancialYears();
  $from = $this->Mapproval->convertMonthYearFroms($financialArray[0]['from']);
  $to = $this->Mapproval->convertMonthYearTos($financialArray[0]['to']);
  $assignAmount = $this->Mapproval->checkAmountAssigned($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to, $grant_id);

  $approvalAmount = $this->Mapproval->checkApprovalNoteAmount($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to, $grant_id);
  $internalAmount = $this->Mapproval->checkInternalAmount($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to, $grant_id);
  $RecoveredAmount = $this->Mapproval->checkRecoveredAmount($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to, $grant_id);
  $availAmt = ($assignAmount - ($approvalAmount)) + $RecoveredAmount;
  $availableAmount = $availAmt;
  return $availableAmount;
}

function approvalRequestMail($id = '') {

  $approvalNoteDetails = $this->Mapproval->getApprovalNote($id);

  /* ---------Auto approving RO status when submitting approval note------------ */
  $this->Mapproval->actionApproveRO('approve', $id);

  if ($approvalNoteDetails['0']['above_50000'] != 'yes') {
    if ($approvalNoteDetails['0']['programme_head'] == $approvalNoteDetails['0']['from_employee']) {
      $this->Mapproval->actionApprovePHEnd('approve', $id);
      $toName = array('employee', 'ph');
      $toEm = array('employeeEmail', 'phEmail');
    } else {
      $toName = array('employee', 'ph');
      $toEm = array('employeeEmail', 'phEmail');
    }
  } else {
    if ($approvalNoteDetails['0']['programme_head'] == $approvalNoteDetails['0']['from_employee']) {
      $this->Mapproval->actionApprovePH('approve', $id);
      $toName = array('employee', 'ph', 'ceo');
      $toEm = array('employeeEmail', 'phEmail', 'ceoEmail');
    } else {
      $toName = array('employee', 'ph');
      $toEm = array('employeeEmail', 'phEmail');
    }
  }

  foreach ($toName as $key => $value) {
    $mailContent = $this->Mapproval->mailContent($id, $value);
    $this->sendMailPhpMailer_IN($mailContent['employeeEmail'], $mailContent[$toEm[$key]], 'Approval Note Request by Employee', $mailContent, $mailContent['attach']);
  }
}

public function getDonorNameList() {
  $program_id = $this->input->post('program');
  $data = $this->Mapproval->getDonorList($program_id);
  echo json_encode($data);
}

public function getGrantNameList() {
  $donor_id = $this->input->post('donor');
  $data = $this->Mapproval->getGrantList($donor_id);
  echo json_encode($data);
}

public function getBudgetItemList() {
  $program_id = $this->input->post('program');
  $donor_id = $this->input->post('donor');
  $grant_id = $this->input->post('grant');
  $data = $this->Mapproval->getBudgetList($program_id, $donor_id, $grant_id);
  echo json_encode($data);
}

public function getLineList() {
  $program_id = $this->input->post('program');
  $donor_id = $this->input->post('donor');
  $grant_id = $this->input->post('grant');
  $budget_id = $this->input->post('budget');
  $data = $this->Mapproval->getLineItemList($program_id, $donor_id, $grant_id, $budget_id);
  echo json_encode($data);
}

public function getAdditionalList() {
  $program_id = $this->input->post('program');
  $donor_id = $this->input->post('donor');
  $budget_id = $this->input->post('budget');
  $line_id = $this->input->post('lineitem');
  $data = $this->Mapproval->getAdditionalDetails($program_id, $donor_id, $budget_id, $line_id);
  echo json_encode($data);
}

function check_calucalations() {
  if (!empty($_REQUEST)) {
    $count = php72_count($_REQUEST["donor"]);
    $return = array();
    for ($i = 0; $i < $count; $i++) {
      if ($_REQUEST["donor"][$i] != "" && $_REQUEST["budgethead"][$i] != "" && $_REQUEST["lineitem"][$i] != "") {
        if (isset($_REQUEST["edit"])) {
          $pre = $this->PreCheckExist($_REQUEST);
          $check = $this->CheckExist($return, $_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i]);
          $inam = $this->Mapproval->tot_amt_in($_REQUEST['id'], $_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i], $_REQUEST['detail'][$i]);
          $return[$i]["donor"] = $_REQUEST["donor"][$i];
          $return[$i]["budgethead"] = $_REQUEST["budgethead"][$i];
          $return[$i]["lineitem"] = $_REQUEST["lineitem"][$i];
          $return[$i]["amtavailable"] = $gran_wise_amount = $this->getaval_amount($_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i], $_REQUEST["progid"], $check, $pre, $_REQUEST["grant_list"][$i]);
          $return[$i]["amtreq"] = $_REQUEST["amtreq"][$i];
          if (php72_cmp($inam) != 0 && !empty($inam)) {
            if ($return[$i]['amtreq'] < $inam[$i]['amount_toapprove']) {
              $return[$i]['amtreq'] = 0;
            }
          }
          if ($return[$i]["amtreq"] > $return[$i]['amtavailable']) {
            $return[$i]['amtreq'] = 0;
          }if ((!is_numeric($return[$i]["amtreq"]) || (php72_cmp($return[$i]["amtreq"]) < 0)) && !empty($return[$i]["amtreq"])) {
            $return[$i]['amtreq'] = 0;
          }
        } else {
          $check = $this->CheckExist($return, $_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i]);
          $return[$i]["donor"] = $_REQUEST["donor"][$i];
          $return[$i]["budgethead"] = $_REQUEST["budgethead"][$i];
          $return[$i]["lineitem"] = $_REQUEST["lineitem"][$i];
          $return[$i]["amtavailable"] = $this->getaval_amount($_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i], $_REQUEST["progid"], $check, '', $_REQUEST["grant_list"][$i]);
          $return[$i]["amtreq"] = $_REQUEST["amtreq"][$i];
          if ($return[$i]["amtreq"] > $return[$i]['amtavailable']) {
            $return[$i]['amtreq'] = 0;
          }
          if ((!is_numeric($return[$i]["amtreq"]) || (php72_cmp($return[$i]["amtreq"]) < 0)) && !empty($return[$i]["amtreq"])) {
            $return[$i]['amtreq'] = 0;
          }
        }
      } else {
        $return[$i]["donor"] = $_REQUEST["donor"][$i];
        $return[$i]["budgethead"] = $_REQUEST["budgethead"][$i];
        $return[$i]["lineitem"] = $_REQUEST["lineitem"][$i];
        $return[$i]["amtavailable"] = "";
        $return[$i]["amtreq"] = "";
      }
    }
  }
  echo json_encode($return);
}

function PreCheckExist($data = '') {
  $r = array();
  $c = php72_count($data["donor"]);
  $id = $data['id'];
  for ($i = 0; $i < $c; $i++) {
    $r[$i]["donor"] = $data["donor"][$i];
    $r[$i]["budgethead"] = $data["budgethead"][$i];
    $r[$i]["lineitem"] = $data["lineitem"][$i];
    $r[$i]["amtavailable"] = $data["amtavailable"][$i];
    $r[$i]["amtreq"] = $data["amtreq"][$i];
  }
  $return = array();
  if (!empty($r)) {
    foreach ($r as $v) {
      $rv = $this->getReqAmt($data, $v["donor"], $v["budgethead"], $v["lineitem"], $id);
      if (!isset($return[$v["donor"]][$v["budgethead"]][$v["lineitem"]])) {
        $return[$v["donor"]][$v["budgethead"]][$v["lineitem"]] = $rv;
      }
    }
  }
  return $return;
}

function CheckExist($data = '', $d = '', $b = '', $l = '') {
  $c = php72_count($data);
  $return = 0;
  if ($c > 0) {
    for ($i = 0; $i < $c; $i++) {
      if ($data[$i]["donor"] == $d && $data[$i]["budgethead"] == $b && $data[$i]["lineitem"] == $l && $data[$i]["amtreq"] != "") {
        $return = $return + $data[$i]["amtreq"];
      }
    }
  }
  return $return;
}

function getReqAmt($v = '', $d = '', $b = '', $l = '', $id = '') {
  $this->ais->select('sum(amt_required) as amount');
  $this->ais->where('donor', $d);
  $this->ais->where('budget_head', $b);
  $this->ais->where('line_item', $l);
  $this->ais->where('approval_id', $id);
  $q = $this->ais->get('approval_note_donors');
  $res = $q->result_array();
  return $res[0]['amount'];
}

function getaval_amount($d = '', $b = '', $l = '', $progid = '', $existamount = '', $pre = "", $grant_id = '') {
  $sublineitemid = '';
  $lineitemid = $l;
  $budgetid = $b;
  $donorid = $d;
  $programmeid = $progid;
  $financialArray = $this->Mapproval->findCurrentFinancialYear();
  $from = convertMonthYearFrom($financialArray[0]['from']);
  $to = convertMonthYearTo($financialArray[0]['to']);

  $assignAmount = $this->Mapproval->checkAmountAssigned($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to, $grant_id);
  $approvalAmount = $this->Mapproval->checkApprovalNoteAmount($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to, $grant_id);
  $internalAmount = $this->Mapproval->checkInternalAmount($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to, $grant_id);
  $RecoveredAmount = $this->Mapproval->checkRecoveredAmount($programmeid, $donorid, $budgetid, $lineitemid, $sublineitemid, $from, $to, $grant_id);
  $availableAmount = ($assignAmount - ($approvalAmount)) + $RecoveredAmount;

  if (!empty($pre)) {
    $availableAmount = $availableAmount + $pre[$d][$b][$l];
  }
  $return = number_format((float) $availableAmount, 2, '.', '') - number_format((float) $existamount, 2, '.', '');
  return $return;
}

public function archive_old() {
  $data['financialList'] = $this->Mapproval->getfinanciallist();
  $emp_id = $this->session->userdata('emp_number');
  $data['approval_new'] = $this->Mapproval->approvalNumber();
  $data['reporting_list'] = $this->Mapproval->getROlist($emp_id);
  $data['program_list'] = $this->Mapproval->getProgrammeList();

  $this->load->vars($data);
  $this->load->view('approval/admin/archive');
}

public function DTarchive_old() {
  $data = array();
  $i = $requestData['start'] + 1;
  $columnIndex = $_POST['order'][0]['column'];
  $columnSortOrder = $_POST['order'][0]['dir'];
  $start = $this->input->post('start');
  $limit = $this->input->post('length');

  $date_from = $this->input->post('date_from');
  $date_to = $this->input->post('date_to');
  $action = $this->input->post('action');

  $return_date_from = $this->input->post('return_date_from');
  $return_date_to = $this->input->post('return_date_to');
  $currentTab = $this->input->post('currentTab');
  $section = $this->input->post('section');
  $columnArr = array('AP.approval_no', 'AP.date_of_seeking_approval', 'AP.to_RO', 'AP.purpose', 'programme_name', 'AN.additionalinfo', 'AP.status');
  $status = 'status';
  if ($columnArr[$columnIndex] != '') {
    $sort_column = $columnArr[$columnIndex];
  }

  $return_date_from = $this->input->post('interval_date');
  $get_date = explode('-', $return_date_from);
  $from = $get_date[0];
  $to = $get_date[1];

  if ($from == NULL || $to == NULL) {
    $from = '2009-04-01';
    $to = '2010-03-30';
  } else {
    $from = date('Y-m-01', strtotime('April' . substr($from, strlen($from) - 4)));
    $to = date('Y-m-t', strtotime('March' . substr($to, strlen($to) - 4)));
  }
  if ($this->input->post('approval_no') != "")
    $searchArray[] = "AP.approval_no ='" . $this->input->post('approval_no') . "'";

  if ($this->input->post('purpose') != "")
    $searchArray[] = "AP.purpose like '%" . $this->input->post('purpose') . "%'";

  if ($this->input->post('status') != "")
    $searchArray[] = "AP.status like '%" . $this->input->post('status') . "%'";

  if ($this->input->post('raise_from') != "") {
    $raise_from = array_pop($this->Mlogin->getuserid($this->input->post('raise_from')));
    $from_emp = array_pop($raise_from);
    $searchArray[] = "AP.from_employee ='" . $from_emp . "'";
  }
  if (($this->input->post('from_date') != "") && ($this->input->post('to_date') != "")) {
    $from_date = date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('from_date'))));
    $to_date = date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('to_date'))));
    $searchArray[] = "AP.date_of_seeking_approval >= '" . $from_date . "' and AP.date_of_seeking_approval <= '" . $to_date . "'";
  }

  $where = php72_implode(" and ", $searchArray);
  $total = $this->Mapproval->getarchiveApprovalNotesCount($from, $to, $where);
  $getAll_count = php72_count($total);

  $approval_lists = $this->Mapproval->getarchiveApprovalNotes($from, $to, $limit, $start, $where, $sort_column, $columnSortOrder);
  $getLimit_count = php72_count($approval_lists);

  foreach ($approval_lists as $lists) {
    $requestDate = '';
    $seekingDate = '';
    $paymentDate = '';
    if ($lists['date_of_request'] != '') {
      $requestDate = date('Y-m-d', strtotime($lists['date_of_request']));
    }
    $employe_id = $lists['raise_from'];
    $to_RO = $lists['to_RO'];
    $programme_head = $lists['programme_head'];
            #$employe_id = '23';
    $employeeName = $this->Mapproval->getUserNameInfo($employe_id);
    $user_name = $employeeName[0]['user_name'];

    $RoName = $this->Mapproval->getUserNameInfo($to_RO);
    $ro_name = $RoName[0]['user_name'];
    $url = base_url() . 'index.php/approval/approvaladmin/approval_note_details/' . $lists['approval_id'] . '/mylist';

    $view_btn = "<a class='bordergrn-btn-outline' href=" . $url . " >" . 'View' . "</a>";
    $status = '';
    $nestedData = array();
    $nestedData[] = $lists['approval_no'];
    $nestedData[] = date('d-m-Y', strtotime($lists["date_of_seeking_approval"]));
    $nestedData[] = $ro_name;
    $nestedData[] = $lists['purpose'];
    $nestedData[] = $lists['programme_name'];
    $nestedData[] = $lists['additionalinfo'];
    $nestedData[] = ucfirst($lists['status']);
    $nestedData[] = $user_name;
    $nestedData[] = $view_btn;
    $data[] = $nestedData;
    $i++;
  }
  $json_data = array(
    "draw" => intval($requestData['draw']),
    "recordsTotal" => intval($getLimit_count),
    "recordsFiltered" => intval($getAll_count),
    "data" => $data,
    "POST" => $_POST
  );
  echo json_encode($json_data);
}

public function DTview_internalNote() {
  $data = array();
  $i = $requestData['start'] + 1;
  $columnIndex = $_POST['order'][0]['column'];
  $columnSortOrder = $_POST['order'][0]['dir'];
  $start = $this->input->post('start');
  $limit = $this->input->post('length');

  $date_from = $this->input->post('date_from');
  $date_to = $this->input->post('date_to');
  $action = $this->input->post('action');

  $employee_id = $this->input->post('employee_id');
  $columnArr = array('AP.approval_no', 'AP.date_of_seeking_approval', 'AP.to_RO', 'AP.purpose', 'programme_name', 'AN.additionalinfo', 'AP.status');
  $status = 'status';
  if ($columnArr[$columnIndex] != '') {
    $sort_column = $columnArr[$columnIndex];
  }
  $offset = 3;
  $searchArray = array();
  $options['offset'] = $start;
  $options['num'] = $limit;
  if ($employee_id != '') {
    $options['employee'] = $employee_id;
  }
  $option['offset'] = '';
  $option['num'] = '';
  $approval_list = $this->Mapproval->getApprovalActionHistory($option);
  $getAll_count = php72_count($approval_list);
  $approval_lists = $this->Mapproval->getApprovalActionHistory($options);
  $getLimit_count = php72_count($approval_lists);
  foreach ($approval_lists as $lists) {
    $assigned_date = '';
    if ($lists['assigned_date'] != '') {
      $assigned_date = date('d-m-Y', strtotime($lists['assigned_date']));
    }
    $employe_id = $lists['from_employee'];
    $employeeName = $this->Mapproval->getUserNameInfo($employe_id);
    $user_name = $employeeName[0]['user_name'];

    $assgn_employe_id = $lists['assigned_employee'];
    $assgn_employeeName = $this->Mapproval->getUserNameInfo($assgn_employe_id);
    $assgn_user_name = $assgn_employeeName[0]['user_name'];

    $ro_employe_id = $lists['ro'];
    $ro_employeeName = $this->Mapproval->getUserNameInfo($ro_employe_id);
    $ro_user_name = $ro_employeeName[0]['user_name'];

    $RoName = $this->Mapproval->getUserNameInfo($to_RO);
    $ro_name = $RoName[0]['user_name'];
    $url = base_url() . 'index.php/approval/approval_note_details/' . $lists['approval_id'] . '/mylist';

    $internalnoteList = $this->Mapproval->getInternalNote($lists["approval_id"]);
    if (php72_count($internalnoteList) > 0) {
      $view_btn = "<a href='javascript:void(0)' data-attr=" . $lists["approval_id"] . " class='view_internal bordergrn-btn-outline' >" . 'View' . "</a>";
    } else {
      $view_btn = "Not Assigned";
    }

    $status = '';
    $nestedData = array();
    $nestedData[] = $lists['approval_no'];
    $nestedData[] = $user_name;
    $nestedData[] = $assgn_user_name;
    $nestedData[] = $ro_user_name;
    $nestedData[] = $assigned_date;
    $nestedData[] = $view_btn;
    $data[] = $nestedData;
    $i++;
  }
  $json_data = array(
    "draw" => intval($requestData['draw']),
    "recordsTotal" => intval($getLimit_count),
    "recordsFiltered" => intval($getAll_count),
    "data" => $data,
    "POST" => $_POST
  );
  echo json_encode($json_data);
}

function ro() {
  $approval_id = $this->input->post('approval_id');
  $internal_id = $id = $this->input->post('internal_id');
  $status = $currentTab = $this->input->post('status');
  $section = $this->input->post('section');
  $comments_PH = $this->input->post('comments_PH');
  $option = $this->input->post('option');

  $this->Minternal->internalRoAction($option, $id);
  switch ($option) {
    case 'approve' :
    $tmplate = 'Internal Note Confirmed by RO';
    break;
    case 'rejected':
    $tmplate = 'Internal Note Rejected by RO';
    break;
    default:
    $tmplate = 'Internal Note Deferred by RO';
    break;
  }
  $internalNoteDetails = $this->Minternal->getInternalNoteDetails($id);

  $employeeDetails = $this->Minternal->getEmployeeFromUserId($internalNoteDetails['0']['from_employee']);
  $RO_user = $this->Minternal->reportingUser('supUser', 'All', $employeeDetails['0']['emp_number']);
  $toName = array('employee', 'ro');
  $toEmail = array('employeeEmail', 'reportAuthEmail');
  foreach ($RO_user as $ro) {
    $rolist[] = $ro['id'];
  }
  if (($internalNoteDetails['0']['programme_head'] == $RO_user['0']['id']) || (php72_in_array($internalNoteDetails['0']['programme_head'], $rolist))) {
    switch ($option) {
      case 'approve' :
      $tmplate = 'Internal Note Confirmed by PH';
      break;
      case 'rejected':
      $tmplate = 'Internal Note Rejected by PH';
      break;
      default:
      $tmplate = 'Internal Note Deferred by PH';
      break;
    }
    $toName = 'employee';
    $toEmail = 'employeeEmail';
    $ipaddress = $_SERVER['REMOTE_ADDR'];
    $approve_from = "Report&Programhead";
    $this->Minternal->internalPhAction($option, $id, $ipaddress, $approve_from);
  }
  if ($internalNoteDetails['0']['programme_head'] == $internalNoteDetails['0']['from'] && $option == 'approve') {
    $toName = 'employee';
    $toEmail = 'employeeEmail';
    $ipaddress = $_SERVER['REMOTE_ADDR'];
    $approve_from = "Report&Programhead";
    $this->Minternal->internalPhAction($option, $id, $ipaddress, $approve_from);
  }
  
   if (is_array($toName)) {
	   foreach ($toName as $key => $value) {
		$mailContent = $this->Minternal->mailContent($id, $value);
		$this->sendMailPhpMailer_IN($mailContent['employeeEmail'], $mailContent[$toEmail[$key]], $tmplate, $mailContent, $mailContent['attach']);
	  }
  }else{
    $mailContent = $this->Minternal->mailContent($id, $toName);
    $this->sendMailPhpMailer_IN('',$mailContent['employeeEmail'], $tmplate, $mailContent, $mailContent['attach']);
  }
	
	
  /* foreach ($toName as $key => $value) {
    $mailContent = $this->Minternal->mailContent($id, $value);
    $this->sendMailPhpMailer_IN($mailContent['employeeEmail'], $mailContent[$toEmail[$key]], $tmplate, $mailContent, $mailContent['attach']);
  } */
  if ($internalNoteDetails['0']['programme_head'] == $RO_user['0']['id'] || $internalNoteDetails['0']['programme_head'] == $internalNoteDetails['0']['from']) {
    if ($option == 'approve') {
//                array_push($to, 'vifaccounts@villgro.org');
      array_push($to);
    }
  }
  switch ($option) {
    case "approve":
    $succ = 'Internal Note Confirmed';
    break;
    case "disapprove":
    $succ = 'Internal Note Rejected';
    break;
    default:
    $succ = 'Internal Note Deferred';
  }

  $this->session->set_flashdata('successMsg', $succ);
  redirect('internal/internal_note_details/' . $id);
}

function ph($option = '', $id = '', $section = 'mylist') {
  $approval_id = $id = $this->input->post('approval_id');
  $status = $currentTab = $this->input->post('status');
  $section = $this->input->post('section');
  $comments_PH = $this->input->post('comments_PH');
  $option = $this->input->post('option');

  $ipaddress = $_SERVER['REMOTE_ADDR'];
  $approve_from = "Programhead";
  $this->Minternal->internalPhAction($option, $id, $ipaddress, $approve_from);
  switch ($option) {
    case 'approve' :
    $tmplate = 'Internal Note Confirmed by PH';
    break;
    case 'rejected':
    $tmplate = 'Internal Note Rejected by PH';
    break;
    default:
    $tmplate = 'Internal Note Deferred by PH';
    break;
  }
  if ($option == 'defer') {
    $emp = $this->Minternal->getUserInfo($internalNoteDetails[0]['from_employee']);
    $ro = $this->Minternal->getUserInfo($internalNoteDetails[0]['to_RO']);
    if ($_POST['employee'] == $ro) {
      $toName = 'To';
      $toEmail = 'reportAuthEmail';
    } else {
      $toName = 'employee';
      $toEmail = 'employeeEmail';
    }
  }
  $mailContent = $this->Minternal->mailContent($id, 'employee');
  $defered_by = $this->Minternal->getUserInfo($internalNoteDetails[0]['programme_head']);
  $to = array($mailContent['reportAuthEmail'], $mailContent['employeeEmail']);
  if ($option == 'approve') {
//            array_push($to, 'vifaccounts@villgro.org');
    array_push($to);
  }
  $this->sendMailPhpMailer_IN($mailContent['phEmail'], $to, $tmplate, $mailContent, $mailContent['attach']);
  switch ($option) {
    case "approve":
    $masg = 'Internal Note Confirmed';
    break;
    case "disapprove":
    $masg = 'Internal Note Rejected';
    break;
    default:
    $masg = 'Internal Note Deferred';
  }
  $this->session->set_flashdata('successMsg', $succ);
  redirect('internal/internaladmin/internal_note_details/' . $approval_id);
}

function finance_approval($option = '', $id = '', $section = 'mylist') {
  $approval_id = $appid = $this->input->post('approval_id');
  $internal_id = $id = $this->input->post('internal_id');
  $option = $this->input->post('option');

  $this->Minternal->internalFinAction($option, $id);
  switch ($option) {
    case 'approve' :
    $tmplate = 'Internal Notes - Payment Status Confirmed';
    break;
    case 'cancelled':
    $tmplate = 'Internal Notes - Payment Status Cancelled';
    break;
    case 'disapprove':
    $tmplate = 'Internal Notes - Payment Status Cancelled';
    break;
  }
  if ($option == 'defer') {
    $emp = $this->Minternal->getUserInfo($internalNoteDetails[0]['from_employee']);
    $ro = $this->Minternal->getUserInfo($internalNoteDetails[0]['to_RO']);
    if ($_POST['employee'] == $ro) {
      $toName = 'To';
      $toEmail = 'reportAuthEmail';
    } else {
      $toName = 'employee';
      $toEmail = 'employeeEmail';
    }
  }

  $mailContent = $this->Minternal->mailContent($id, 'employee');
  $defered_by = $this->Minternal->getUserInfo($internalNoteDetails[0]['programme_head']);
  $to = array($mailContent['reportAuthEmail'], $mailContent['employeeEmail']);
  if ($option == 'approve') {
//            array_push($to, 'vifaccounts@villgro.org');
    array_push($to);
  }
  $this->sendMailPhpMailer_IN($mailContent['phEmail'], $to, $tmplate, $mailContent, $mailContent['attach']);
  switch ($option) {
    case "approve":
    $masg = 'Internal Note - Payment Confirmed';
    break;
    case "disapprove":
    $masg = 'Internal Note - Payment Cancelled';
    break;
  }
  $this->session->set_flashdata('successMsg', $masg);
  redirect('internal/internal_note_details/' . $internal_id);
}

function finance_recoveramt() {
  $rec_data['approval_id'] = $approval_id = $appid = $this->input->post('approval_id');
  $rec_data['internal_id'] = $internal_id = $id = $this->input->post('internal_id');
  $rec_where['id'] = $recovery_id = $this->input->post('recovery_id');

  if ($recovery_id != '') {
    $this->Minternal->update_recover_data('recovered_amount', $rec_data, $rec_where);
  } else {
    $recovery_id = $this->Minternal->insert_recover_data('recovered_amount', $rec_data);
  }
  $j = 0;
  $len_amt = php72_count($this->input->post('recover_amt'));
  $rec_amt = $this->input->post('recover_amt');
  $rec_date = $this->input->post('recover_date');
  $rec_comments = $this->input->post('recover_comments');
  $rec_amt_id = $this->input->post('recov_amt_id');

  for ($j = 0; $j < $len_amt; $j++) {
    $recamt_data['recover_id'] = $recovery_id;
    $recamt_data['amount_recovered'] = $rec_amt[$j];
    $recamt_data['recovered_date'] = date('Y-m-d', strtotime($rec_date[$j]));
    $recamt_data['comments'] = $rec_comments[$j];
    $recamt_data['entered_by'] = $this->session->userdata('emp_number');

    if ($rec_amt_id[$j] != '') {
      $rec_amtwhere['id'] = $rec_amt_id[$j];
      $this->Minternal->update_recover_data('recovered_amount_detail', $recamt_data, $rec_amtwhere);
    } else {
      $this->Minternal->insert_recover_data('recovered_amount_detail', $recamt_data);
    }
  }

  $masg = 'Recovered amount is updated successfully';
  $this->session->set_flashdata('successMsg', $masg);
  redirect('internal/internal_note_details/' . $internal_id);
}

function finance_deleteamt() {
  $amtid = $this->input->post('amtid');
  $recovery_id = $this->input->post('recovery_id');
  $delete_amt = $this->Minternal->delete_recover_data($amtid, $recovery_id);
  if ($delete_amt) {
    return 1;
  }
}

function sendMail($from = NULL, $to = array(), $tamplate = NULL, $mailContant = NULL, $attach = NULL, $ccEmail = NULL) {
  $mail_config = partner_smtp();
  $mailTemplate = $this->Minternal->getMailTemplate($tamplate);
  $messageSubject = $mailTemplate['0']['messagesubject'];
  $messageBody = str_replace($mailContant['org'], $mailContant['replace'], $mailTemplate['0']['messagebody']);

  $this->load->library('email');
  $this->email->clear(TRUE);
  $this->email->from($mail_config['smtp_user'], $mail_config['smtp_subject']);
  $this->email->to($to);

  if (!empty($attach)) {
    foreach ($attach as $key => $value):
      $this->email->attach($value);
    endforeach;
  }
  $this->email->subject($messageSubject);
  $this->email->message($messageBody);
  $this->email->send();
  return true;
}

function sendMailPhpMailer_IN($from = NULL, $to = array(), $tamplate = NULL, $mailContant = NULL, $attach = NULL, $ccEmail = NULL) {
  $mail_config = partner_smtp();
  $mailTemplate = $this->Minternal->getMailTemplate($tamplate);
  $messageSubject = $mailTemplate['0']['messagesubject'];
  $messageBody = str_replace($mailContant['org'], $mailContant['replace'], $mailTemplate['0']['messagebody']);
  
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

		$mail->CharSet = 'utf-8';  
		$mail->SMTPDebug  = 1;   

		$mail->Subject = $messageSubject;

		$mail->MsgHTML($messageBody);
		//$attach = array('uploads/support_docs/Villgro_Email_testing_file.pdf');
		 if (php72_count($attach)) {
			foreach ($attach as $key => $value):
				if (file_exists($value)) {
					$mail->addAttachment($value);
				}
			endforeach;
		}
		if(is_array($to)){
			 if (!empty($to)) {
				foreach ($to as $keys => $email){
					if($email!=''){
						//$email = 'arunkumar.d@claritaz.com';
						$mail->AddAddress($email);
					}
				}
			}
		  }else{ 
			if($to!=''){
				//$to = 'arunkumar.d@claritaz.com';
			  $mail->AddAddress($to);
			}
		  }
		
		//$mail->AddAddress($address1);
		//$mail->send();
		if($mail->send()){
			  //echo 'Message has been sent';
		}else{
			
		}
	  
	} catch (Exception $e) {
		//echo 'Message could not be sent.';
		//echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
		
	return true;
}

function InCancel($option = '', $id = '') {
  $this->Minternal->internalAdminAction($option, $id);
  switch ($option) {
    case 'cancelbyadmin' :
    $tmplate = 'Internal Note Cancelled by Admin';
    break;
  }
  $internalNoteDetails = $this->Minternal->getInternalNoteDetails($id);
  $mailContent = $this->Minternal->mailContent($id, 'employee');
  $this->sendMailPhpMailer_IN($mailContent['employeeEmail'], $mailContent['employeeEmail'], 'Internal Note Cancelled by Admin', $mailContent, $mailContent['attach']);
  redirect('internal/internaladmin/internal_note_details/' . $id);
}

public function confirmed_approval_note() {
  $emp_id = $this->session->userdata('emp_number');
  $partner_id = $this->session->userdata('partner_id');
  $data['approval_new'] = $this->Mapproval->approvalNumber();
  $data['reporting_list'] = $this->Mapproval->getROlist($emp_id);
  $data['program_list'] = $this->Mapproval->getProgrammeList();
  $sess_empid = $this->session->userdata('emp_number');
  $data['an_rocount'] = $rocount = total_ropending_count($sess_empid);
  $data['an_phcount'] = $phcount = total_phpending_count($sess_empid);

  $ph_user_count = $this->Mapproval->get_ph_user($emp_id, $partner_id);
  $data['ph_Usercount'] = '0';
  if (!empty($ph_user_count)) {
    $data['ph_Usercount'] = '1';
  }
  $this->load->vars($data);
  $this->load->view('user/confirmed_an');
}

public function DTconfirmed_Approval_note() {
  $data = array();
  $i = $requestData['start'] + 1;
  $columnIndex = $_POST['order'][0]['column'];
  $columnSortOrder = $_POST['order'][0]['dir'];
  $start = $this->input->post('start');
  $limit = $this->input->post('length');

  $date_from = $this->input->post('date_from');
  $date_to = $this->input->post('date_to');
  $action = $this->input->post('action');

  $return_date_from = $this->input->post('return_date_from');
  $return_date_to = $this->input->post('return_date_to');
  $currentTab = $this->input->post('currentTab');
  $section = $this->input->post('section');
  $columnArr = array('travel_booking.travel_request_id', 'travel_booking.master_name', '', '', '', 'travel_booking.journey_type', 'travel_booking.reporting_approval', 'travel_booking.status');
  $status = 'status';

  if ($currentTab != 'all_pending' && $currentTab != 'all_approval') {
    $currentTab = $this->input->post('status');
  }
  if ($currentTab == 'all_approval') {
    $currentTab = $this->input->post('section');
  }

  switch ($section) {
    case 'mylist':
    $admin = NULL;
    $status = 'status';
    $title = 'My List';
    break;
    case 'rolist':
    $searchArray[] = "AP.to_RO =  '" . $this->session->userdata('emp_number') . "' ";
    $admin = 'Show all';
    $status = 'RO_status';
    $title = 'Reporting Officer';
    break;
    case 'phlist':
    $searchArray[] = "MP.programme_head = '" . $this->session->userdata('emp_number') . "'";
    if ($currentTab == 'pending' || $currentTab == 'confirmed') {
      $searchArray[] = "AP.RO_status = 'confirmed'";
    }
    $status = 'PH_status';
    $admin = 'Show all';
    $title = 'Programme Head';
    break;
    case 'ceolist':
    $ceo = $this->Mapproval->getApprovalSetting('ceo');
    if ($ceo != $this->session->userdata('emp_number')) {
      $this->session->set_flashdata('successMsg', 'Access Denied!');
      redirect('approvaluser/approval_note/' . $currentTab);
    }

    $searchArray[] = "(AP.above_50000 = 'yes' or AP.estimated_in_workplan = 'no' )";
    if ($currentTab == 'pending' || $currentTab == 'confirmed') {
      $searchArray[] = "AP.PH_status = 'confirmed'";
    }
    $admin = 'Show all';
    $status = 'CEO_status';
    $title = 'CEO';
    break;
    case 'finance':
    $admin = 'Show all';
    $title = 'Finance';
    break;
  }
  switch ($currentTab) {
    case 'pending':
    $searchArray[] = "AP.status = 'pending'";
    break;
    case 'confirmed':
    $searchArray[] = "AP.status = 'confirmed'";
    break;
    case 'cancelled':
    $searchArray[] = "AP.status = 'cancelled'";
    break;
    case 'defered':
    $searchArray[] = "AP.status = 'defered'";
    break;
    case 'closed':
    $searchArray[] = "AP.status = 'closed'";
    break;
    case 'draft':
    $searchArray[] = "AP.status = 'draft'";
    break;
    case 'all_pending':
    $searchArray[] = "AP.status = 'pending'";
    break;
    case 'all_approval':
    $searchArray[] = "AP.status = 'draft' OR AP.status = 'defered' OR AP.status = 'confirmed' OR AP.status = 'cancelled'";
    break;
  }

  if ($this->input->post('approval_no') != "")
    $searchArray[] = "AP.approval_no ='" . $this->input->post('approval_no') . "'";

  if ($this->input->post('program_name') != "")
    $searchArray[] = "MP.programme_id ='" . $this->input->post('program_name') . "'";

  if ($this->input->post('purpose') != "")
    $searchArray[] = "AP.purpose like '%" . $this->input->post('purpose') . "%'";

  $where = php72_implode(" and ", $searchArray);

  $approvalCount = $this->Mapproval->getLimitApprovalNotes($where, '', '', $sort_column, $columnSortOrder, $admin);
  $getAll_count = php72_count($approvalCount);

  $approval_lists = $this->Mapproval->getLimitApprovalNotes($where, $limit, $start, $sort_column, $columnSortOrder, $admin);
  $getLimit_count = php72_count($approval_lists);

  foreach ($approval_lists as $lists) {

    $requestDate = '';
    $seekingDate = '';
    $paymentDate = '';
    if ($lists['date_of_request'] != '') {
      $requestDate = date('Y-m-d', strtotime($lists['date_of_request']));
    }
    $employe_id = $lists['from_employee'];
    $to_RO = $lists['to_RO'];
    $programme_head = $lists['programme_head'];
            #$employe_id = '23';
    $employeeName = $this->Mapproval->getUserNameInfo($employe_id);
    $user_name = $employeeName[0]['user_name'];

    $RoName = $this->Mapproval->getUserNameInfo($to_RO);
    $ro_name = $RoName[0]['user_name'];

    $approval_userName = '';
            #if ($currentTab == 'pending') {
    if ($lists['PH_status'] == 'pending') {
      $phUser = $lists['programme_head'];
      $phName = $this->Mapproval->getUserNameInfo($phUser);
      $approval_userName = $phName[0]['user_name'];
    } else if ($lists['CEO_status'] == 'pending') {
      $ceoUser = $this->Mapproval->getApprovalSetting('ceo');
      $ceoName = $this->Mapproval->getUserNameInfo($ceoUser);
      $approval_userName = $ceoName[0]['user_name'];
    }
            #}

    $grant_status = $this->Mapproval->get_allGrantVal($lists['approval_id']);
    $url = base_url() . 'index.php/approval/approval_note_details/' . $lists['approval_id'] . '/mylist';
    $confirm_url = $confirm_ur2 = '';
    if ($lists['status'] == 'confirmed') {
      if ($lists["internal_note"] == 'sent') {
        $url_1 = base_url() . 'index.php/internal/approval/' . $lists['approval_id'] . '/' . $section;
        $confirm_url = "<a title='View Internal Note' style='padding: 10px;' href=" . $url_1 . " class='action_cls' data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . "><i class='fas fa-eye'></i></a>";
      }
      if (/* count(array_unique($grant_status)) == 1 && */ $grant_status[0]['status_type'] == 'open') {
        $url_2 = base_url() . 'index.php/internal/sent_internal_note/' . $lists['approval_id'];
        $confirm_ur2 = "<a title='Send Internal Note' style='padding: 10px;' href=" . $url_2 . " class='action_cls'><i class='fas fa-calendar-check'></i></a>";
        $an_link = "<a href=" . $url_2 . " class='action_cls'>" . $lists['approval_no'] . "</a>";
      } else {
        $confirm_ur2 = "<a title='Send Internal Note' style='padding: 10px;' href='javascript:void(0)' class='show_error_msg'><i class='fas fa-calendar-times'></i></a>";
        $an_link = "<a href='javascript:void(0)' class='show_error_msg'>" . $lists['approval_no'] . "</a>";
      }
    }
    if ($lists['status'] == 'draft') {
      $url_1 = base_url() . 'index.php/approval/edit_approval_note/' . $lists['approval_id'];
      $confirm_url = "<a title='Edit' style='padding: 10px;' href=" . $url_1 . " ><i class='fas fa-edit'></i></a>";

      $url_1 = base_url() . 'index.php/approval/send_approval_note/' . $lists['approval_id'] . '/' . $section;
      $confirm_ur2 = "<a title='Send Approval Note' style='padding: 10px;' href=" . $url_1 . " ><i class='fas fa-clipboard-check'></i></a>";
    }

//            $an_link = "<a  style='padding: 10px;' href=" . $url . " class='action_cls delete_cls'>" . $lists['approval_no'] . "</a>";
    $status = '';
    $nestedData = array();
            #$nestedData[] = "<a href=''>" . $lists['approval_no'] . "</a>";
    $nestedData[] = $an_link;
    $nestedData[] = date('d-m-Y', strtotime($requestDate));
    $nestedData[] = $lists['programme_name'];
    $nestedData[] = (strlen($lists['purpose']) > 50) ? substr($lists['purpose'], 0, 50) . ".." : $lists['purpose'];
    $nestedData[] = ucfirst($lists['status']);
    $nestedData[] = $confirm_url . '' . $confirm_ur2;
	//$nestedData[] ='';
    $data[] = $nestedData;
    $i++;
  }
  $json_data = array(
    "draw" => intval($requestData['draw']),
    "recordsTotal" => intval($getLimit_count),
    "recordsFiltered" => intval($getAll_count),
    "data" => $data,
    "POST" => $_POST
  );
  echo json_encode($json_data);
}

function donor_balance() {
  $donor_id = $this->input->post('donor_id');
  $approval_id = $this->input->post('approval_id');
  $donor_detail = $this->Mapproval->getDonorDetail($donor_id);
  $data['donor_balance'] = $this->Mapproval->get_donor_balance($approval_id, $donor_detail);
  echo $data['donor_balance'];
}

function edit_donor_balance() {
  $donor_id = $this->input->post('donor_id');
  $approval_id = $this->input->post('approval_id');
  $internal_id = $this->input->post('internal_id');
  $donor_detail = $this->Mapproval->getDonorDetail($donor_id);
  $data['donor_balance'] = $this->Mapproval->get_edit_donor_balance($internal_id, $approval_id, $donor_detail);
  echo $data['donor_balance'];
}

}

?>