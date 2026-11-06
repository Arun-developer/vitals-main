<?php

class Approval extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        //$this->Mauth->isAdminCheck();
        $this->load->library('upload');
        $this->load->model('Mapproval');
        $this->load->model('login/Mlogapproval');
        $this->load->model('user/Empuser');
    }

    public function new_approval() {
        #$emp_id = $this->session->userdata('emp_number');
        $emp_id = $this->session->userdata('user');
        $data['approval_new'] = $this->Mapproval->approvalNumber();
        $data['reporting_list'] = $this->Mapproval->getROlist($emp_id);
        $data['program_list'] = $this->Mapproval->getProgrammeList();

        $this->load->vars($data);
        $this->load->view('approval/user/send_approval_note');
    }
	
	 public function new_approval_test() {
        #$emp_id = $this->session->userdata('emp_number');
        $emp_id = $this->session->userdata('user');
        $data['approval_new'] = $this->Mapproval->approvalNumber();
        $data['reporting_list'] = $this->Mapproval->getROlist($emp_id);
        $data['program_list'] = $this->Mapproval->getProgrammeList();

        $this->load->vars($data);
		#echo 'approval/user/send_approval_note_test';die;
        $this->load->view('approval/user/send_approval_note_test');
    }

    // function close_approval_note() {
    //     $json_data['response'] = '1';
    //     $approval_id = $this->input->post('approval_id');
    //     $status = $currentTab = $this->input->post('status');
    //     $section = $this->input->post('section');
    //     $progID = $this->Mapproval->getApprovalDonors_id($approval_id);
    //     $internalID = $this->Mapproval->internalnoteid($approval_id);
    //     if ($currentTab == 'confirmed') {
    //     } else if (($currentTab == 'pending' || $currentTab == 'draft' || $currentTab == 'defered') && count($internalID) == 0) {
    //         $internal_amount = 0;
    //         $prog_count = count($progID);
    //         for ($i = 0; $i < $prog_count; $i++) {
    //             $this->Mapproval->update_apn($approval_id, $internal_amount, $progID[$i]['approval_donor_id']);
    //         }
    //         $this->Mapproval->action_close('closed', $approval_id);
    //         $this->session->set_flashdata('successMsg', 'Approval Note Closed Successfully');
    //     }
    //     if ($this->session->userdata('isAdmin') == 'Yes')
    //         $this->session->set_flashdata('successMsg', 'Approval Note Closed Successfully');
    //     else
    //         $this->session->set_flashdata('successMsg', 'Approval Note Closed Successfully');
    //     echo json_encode($json_data);
    // }

    function close_approval_note($currentTab = '', $approval_id = '', $section = '') {
        $progID = $this->Mapproval->getApprovalDonors_id($approval_id);
        $internalID = $this->Mapproval->internalnoteid($approval_id);
        $donor_amt = $this->input->post('new_donor');
        $programmeid = $this->input->post('programmeid');
        if ($currentTab == 'confirmed') {
            if (php72_cmp($donor_amt) != 0) {
                $financialArray = $this->Mapproval->findCurrentFinancialYears();
                $from = $this->Mlogapproval->convertMonthYearFrom($financialArray[0]['from']);
                $to = $this->Mlogapproval->convertMonthYearTo($financialArray[0]['to']);
                $prog_count = php72_count($progID);
                $int_count2 = php72_count($internalID);
                for ($i = 0; $i < $prog_count; $i++) {
                    $internal_amount = 0;
                    for ($j = 0; $j < $int_count2; $j++) {
                        $flag[$j] = 0;
                        $progID[$i]['cost_centre'] = ($progID[$i]['cost_centre'] == '') ? 0 : $progID[$i]['cost_centre'];
                        if (php72_cmp($flag[$j]) == 0 && $progID[$i]['donor_id'] == $internalID[$j]['donor'] && $progID[$i]['grant_id'] == $internalID[$j]['grant_id'] && $progID[$i]['line_item'] == $internalID[$j]['line_item'] && $progID[$i]['cost_centre'] == $internalID[$j]['cost_centre'] && $progID[$i]['budget_head'] == $internalID[$j]['budget_head']) {
                            $flag[$j] = 1;
                            $internal_amount += php72_num($internalID[$j]['amount_toapprove']);
                        }
                    }
                    if ($internal_amount <= $progID[$i]['amt_required'])
                        $internal_amount = $internal_amount;
                    else if (php72_cmp($progID[$i]['amt_required']) < 0 && php72_cmp($internal_amount) == 0)
                        $internal_amount = $internal_amount;
                    else
                        $internal_amount = $progID[$i]['amt_required'];
                    $this->Mapproval->update_apn($approval_id, $internal_amount, $progID[$i]['approval_donor_id']);
                    $APN_amount = $progID[$i]['amt_required'];
                    $remain_amt = $APN_amount - $internal_amount;
                }
                $this->Mapproval->action_close('closed', $approval_id);
                $this->session->set_flashdata('successMsg', 'Approval Note Closed Successfully');
            } else {
                $financialArray = $this->Mapproval->findCurrentFinancialYears();
                $from = $this->Mlogapproval->convertMonthYearFrom($financialArray[0]['from']);
                $to = $this->Mlogapproval->convertMonthYearTo($financialArray[0]['to']);
                $prog_count = php72_count($progID);
                $int_count2 = php72_count($internalID);
                for ($i = 0; $i < $prog_count; $i++) {
                    $internal_amount = 0;
                    for ($j = 0; $j < $int_count2; $j++) {
                        $flag[$j] = 0;
                        $progID[$i]['cost_centre'] = ($progID[$i]['cost_centre'] == '') ? 0 : $progID[$i]['cost_centre'];
                        if (php72_cmp($flag[$j]) == 0 && $progID[$i]['donor_id'] == $internalID[$j]['donor'] && $progID[$i]['grant_id'] == $internalID[$j]['grant_id'] && $progID[$i]['line_item'] == $internalID[$j]['line_item'] && $progID[$i]['cost_centre'] == $internalID[$j]['cost_centre'] && $progID[$i]['budget_head'] == $internalID[$j]['budget_head']) {
                            $flag[$j] = 1;
                            $internal_amount += php72_num($internalID[$j]['amount_toapprove']);
                        }
                    }
                    if ($internal_amount <= $progID[$i]['amt_required'])
                        $internal_amount = $internal_amount;
                    else if (php72_cmp($progID[$i]['amt_required']) < 0 && php72_cmp($internal_amount) == 0)
                        $internal_amount = $internal_amount;
                    else
                        $internal_amount = $progID[$i]['amt_required'];
                    $this->Mapproval->update_apn($approval_id, $internal_amount, $progID[$i]['approval_donor_id']);
                }
                if ($approval_id != '') {
                    $result_old = $this->Mapproval->getOldGrantAmount($approval_id);
                    if (!empty($result_old)) {
                        foreach ($result_old as $lists) {
                            $grant_id = $lists->an_grant_id;
                            $status = $lists->an_status;
                            $projected_amount = $lists->projected_amount;
                            if (($status == 'confirmed') && $grant_id != '') {
                                
                            }
                        }
                    }
                }
                $this->Mapproval->action_close('closed', $approval_id);
                $this->session->set_flashdata('successMsg', 'Approval Note Closed Successfully');
            }
        } else if (($currentTab == 'pending' || $currentTab == 'draft' || $currentTab == 'defered') && php72_count($internalID) == 0) {
            $internal_amount = 0;
            $prog_count = php72_count($progID);
            for ($i = 0; $i < $prog_count; $i++) {
                $this->Mapproval->update_apn($approval_id, $internal_amount, $progID[$i]['approval_donor_id']);
            }
            $this->Mapproval->action_close('closed', $approval_id);
            $this->session->set_flashdata('successMsg', 'Approval Note Closed Successfully');
        }
        if ($this->session->userdata('isAdmin')) {
            $from = array($this->session->userdata('emp_name'));
        } else {
            $from = array($this->session->userdata('employeeEmail'));
        }
        $mailcontent = $this->Mapproval->mailContent_close($approval_id);
        $to = array($from, $mailcontent['employeeEmail']);
        $tamplate = "Approval Note Closed";
        $mailcontent['attach'] = 'NULL';
//        $this->sendMail($mailcontent['ceoEmail'], $to, $tamplate, $mailcontent, $mailcontent['attach']);
        $this->session->set_flashdata('successMsg', 'Approval Note Closed Successfully');
        redirect('approval/approval_note_details/' . $approval_id);
    }

    function edit_approval_note($id = NULL, $section = 'mylist') {
        $partnerNote = $this->Mapproval->getPartner($id);
        if (php72_cmp($partnerNote) < 1 && is_numeric($id)) {
            redirect('approval/approval_note/pending');
        }
        $data['section'] = $section;
        if ($id == NULL) {
            redirect('approval/approval_note/pending');
        }
        $data['approvalNoteDetails'] = $this->Mapproval->getApprovalNote($id);
        $data['donorList'] = $this->Mapproval->getMasterSetting('Donor');
        $data['budgetHeadList'] = $this->Mapproval->getMasterSetting('Budget Head');
        $data['programmeList'] = $this->Mapproval->getBalanceProgramme();
        $from_emp_num = $this->Mapproval->getempidfromuserid($data['approvalNoteDetails'][0]['from_employee']);
        $data['donors'] = $this->Mapproval->getBalanceDonor($data['approvalNoteDetails'][0]['programme']);

        $data['reporting_list'] = $this->Mapproval->getROlist($data['approvalNoteDetails'][0]['from_employee']);
        $data['RO'] = $this->Mapproval->reportingUser('supUser', 'All', $from_emp_num[0]['emp_number']);

        $ro_name_arr = $this->Mapproval->getUserNameInfo($data['approvalNoteDetails'][0]['to_RO']);
        $data['to_RO'] = $ro_name_arr[0]['user_name'];
        $data['costCentreList'] = $this->Mapproval->getMasterSetting('Cost Centre');
        $data['donorAN'] = $this->Mapproval->getRecords('approval_note_donors', 'approval_id', $id);
		
        $this->load->view('approval/user/edit_approval_note', $data);
    }

    function insert_approval_note($id = NULL, $section = 'mylist') {
		
		/* $amt_available_post =  $this->input->post('amt_available');
		$amt_required_post = $this->input->post('amt_required');
		$approval_id = $this->input->post('approval_id');
		
		$err_count = 0;
		if(!empty($amt_available_post) && !empty($amt_required_post)){
			$total_count = count($amt_available_post);
			if($total_count > 0){
				for ($j = 0; $j <= $total_count; $j++){
					$amt_available_count =   str_replace(',', '', $amt_available_post[$j]);
					$amt_required_count =  str_replace(',', '', $amt_required_post[$j]);
					if($amt_required_count > $amt_available_count){
						$err_count++;
					}
				}
			}
		}
		if($err_count > 0){
			$this->session->set_flashdata('successMsg', 'The amount exceeds amount approved and it is not possible to enter higher amount');
			redirect("/approval/edit_approval_note/$approval_id");
			exit;
		} */
		
        $error = 0;
        $donor = $this->input->post('donor_list');
        $other_donor = $this->input->post('other_donor');
        $budget_head = $this->input->post('budget_list');
        $grant_list = $this->input->post('grant_list');
        $other_budget_head = $this->input->post('other_budget_head');
        $line_item = $this->input->post('line_list');
        $other_line_item = $this->input->post('line_item');
        $cost_avail = $this->input->post('subline_avail');
        $subline_item = $this->input->post('cost_centre');
        $additional_avail = $this->input->post('additional_avail');
        $additional_info = $this->input->post('additional_list');
        $amt_available = str_replace(',', '', $this->input->post('amt_available'));
        $amt_required = str_replace(',', '', $this->input->post('amt_required'));

        #amt_avail
        if (!empty($donor)) {
            foreach ($donor as $key => $value):
                if ($donor[$key] == '' || $grant_list[$key] == '' || $budget_head[$key] == '' || $line_item[$key] == '' || $amt_available[$key] == '' || $amt_required[$key] == '')
                    $error = 1;
            endforeach;
            # server side validation #
            foreach ($donor as $dondetails => $value) {
                $prog = $this->input->post('program_id');
                $don = $donor[$dondetails];
                $abc = $additional_info[$dondetails];
                $bh = $budget_head[$dondetails];
                $li = $line_item[$dondetails];
                $grant_ids = $grant_list[$dondetails];

                $amt_avail = $this->amountAvailableforssval($prog, $don, $bh, $li, '', $grant_ids);

                $amount_req = $amt_required[$dondetails];
                $curr_apn_amt = $this->Mapproval->getCurrentAmt($prog, $don, $bh, $li, $id);
                $in_amt_an = $this->Mapproval->getCurrentInAmt($prog, $don, $bh, $li, $abc, $id);
                if (php72_cmp($curr_apn_amt) != 0) {
                    $avail_amt = ($amt_avail + $curr_apn_amt);
                } else
                    $avail_amt = $amt_avail;
                if ($avail_amt >= $amount_req) {
                    if (php72_cmp($in_amt_an) != 0) {
                        if ($amount_req < $in_amt_an) {
                            $error = 4;
                        }
                    }
                } else {
                    $error = 2;
                }
            }
        }
        if ($error == 0) {
            $this->Mapproval->updateApprovalNote();
            $this->session->set_flashdata('successMsg', 'Request Updated successfully !');
        } else if ($error == 1) {
            $this->session->set_flashdata('warningMsg', 'Your Request Can not be process !');
        } else if ($error == 2) {
            $this->session->set_flashdata('warningMsg', 'The amount required exceeds amount Available and it is not possible to enter higher amount');
        } else if ($error == 4) {
            $this->session->set_flashdata('warningMsg', 'The approval amount is lesser than the internal amount');
        }

        if ($this->input->post('approval_id') != '') {
            redirect('approval/approval_note_details/' . $this->input->post('approval_id'));
        } else {
            redirect('approval/approval_note_details/');
        }
    }

    public function approval_note() {
		
	
        $emp_id = $this->session->userdata('emp_number');
        $partner_id = $this->session->userdata('partner_id');
        $data['approval_new'] = $this->Mapproval->approvalNumber();
        $data['reporting_list'] = $this->Mapproval->getROlist($emp_id);
        $data['program_list'] = $this->Mapproval->getProgrammeList();
		
        $sess_empid = $this->session->userdata('emp_number');
		/*  $data['an_rocount'] = $rocount = total_ropending_count($sess_empid);
				$data['an_phcount'] = $phcount = total_phpending_count($sess_empid);
		*/
      
		
		/* if($this->session->userdata('emp_number')==279){
			$phcount = total_phpending_count_assign($sess_empid);
		}else{
			$phcount = total_phpending_count($sess_empid);
		} */
		$phcount = total_phpending_count($sess_empid);
		
		
		$rocount = total_ropending_count($sess_empid);
		#$roOnlycount = total_roOnlypending_count($sess_empid);
		
		/* $data['an_phcount'] = $phcount + $rocount ; 
		$data['rocount'] = $rocount+$roOnlycount; */
		
		$data['an_phcount'] = $phcount; 
		$data['rocount'] = $rocount;



        $ph_user_count = $this->Mapproval->get_ph_user($emp_id, $partner_id);
        $ceo = $this->Mapproval->getApprovalSetting('ceo');

        $currentTab = $this->uri->segment(3);
        $page_list = $this->uri->segment(4);
        if ($page_list != '' && $page_list == 'ceolist') {
            if ($ceo != $this->session->userdata('emp_number')) {
                $this->session->set_flashdata('successMsg', 'Access Denied!');
                redirect('approval/approval_note/' . $currentTab);
                exit;
            }
        }
		
        $data['ceo_status'] = '';
        if ($ceo == $this->session->userdata('emp_number')) {
            $data['ceo'] = $ceo;
            $data['ceo_status'] = 'Yes';
            $where = "(AP.above_50000 = 'yes' or AP.estimated_in_workplan = 'no' ) and AP.status = 'pending'";
            $columnSortOrder = 'asc';
            $admin = 'Show all';
            $approvalCount = $this->Mapproval->getLimitApprovalNotes($where, '', '', $sort_column, $columnSortOrder, $admin);
            $getAll_count = php72_count($approvalCount);
            $data['pending_ceo_count'] = $getAll_count;
        }

        $data['ph_Usercount'] = '0';
        if (!empty($ph_user_count)) {
            $data['ph_Usercount'] = '1';
        }
		
        $this->load->vars($data);
        $this->load->view('approval/user/approval_note');
		
    }
	
	 public function approval_note_test() {
		
	
        $emp_id = $this->session->userdata('emp_number');
        $partner_id = $this->session->userdata('partner_id');
        $data['approval_new'] = $this->Mapproval->approvalNumber();
        $data['reporting_list'] = $this->Mapproval->getROlist($emp_id);
        $data['program_list'] = $this->Mapproval->getProgrammeList();
		
        $sess_empid = $this->session->userdata('emp_number');
		/*  $data['an_rocount'] = $rocount = total_ropending_count($sess_empid);
				$data['an_phcount'] = $phcount = total_phpending_count($sess_empid);
		*/
        $phcount = total_phpending_count($sess_empid);
		#$rocount = total_ropending_count($sess_empid);
		$rocount = 0;
		$roOnlycount = total_roOnlypending_count($sess_empid);
		
		$data['an_phcount'] = $phcount + $rocount ; 
		$data['rocount'] = $rocount+$roOnlycount;
		#print_r($this->session->all_userdata());
		
		
		#$rocount = total_ropending_count_test($sess_empid);
		
		#echo'<pre>';print_r($rocount);die;


        $ph_user_count = $this->Mapproval->get_ph_user($emp_id, $partner_id);
        $ceo = $this->Mapproval->getApprovalSetting('ceo');

        $currentTab = $this->uri->segment(3);
        $page_list = $this->uri->segment(4);
        if ($page_list != '' && $page_list == 'ceolist') {
            if ($ceo != $this->session->userdata('emp_number')) {
                $this->session->set_flashdata('successMsg', 'Access Denied!');
                redirect('approval/approval_note/' . $currentTab);
                exit;
            }
        }
		
        $data['ceo_status'] = '';
        if ($ceo == $this->session->userdata('emp_number')) {
            $data['ceo'] = $ceo;
            $data['ceo_status'] = 'Yes';
            $where = "(AP.above_50000 = 'yes' or AP.estimated_in_workplan = 'no' ) and AP.status = 'pending'";
            $columnSortOrder = 'asc';
            $admin = 'Show all';
            $approvalCount = $this->Mapproval->getLimitApprovalNotes($where, '', '', $sort_column, $columnSortOrder, $admin);
            $getAll_count = php72_count($approvalCount);
            $data['pending_ceo_count'] = $getAll_count;
        }

        $data['ph_Usercount'] = '0';
        if (!empty($ph_user_count)) {
            $data['ph_Usercount'] = '1';
        }
		
        $this->load->vars($data);
        $this->load->view('approval/user/approval_note');
		
    }
	

    public function my_approval_notes() {
        $emp_id = $this->session->userdata('emp_number');
        $data['approval_new'] = $this->Mapproval->approvalNumber();
        $data['reporting_list'] = $this->Mapproval->getROlist($emp_id);
        $data['program_list'] = $this->Mapproval->getProgrammeList();
        $sess_empid = $this->session->userdata('emp_number');
        $data['an_rocount'] = $rocount = total_ropending_count($sess_empid);
        $data['an_phcount'] = $phcount = total_phpending_count($sess_empid);

        $this->load->vars($data);
        $this->load->view('approval/user/my_approval_notes');
    }
	
	
	
    public function DTapproval_note() {
		
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
        $list_type = $this->input->post('list_type');

        $columnArr = array('AP.approval_no', 'AP.from_employee', 'AP.date_of_seeking_approval', 'AP.to_RO', 'MP.programme_head', 'programme_name', 'AP.purpose', 'AN.additionalinfo', 'AP.status');
        $status = 'status';
        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }
		

        if ($currentTab != 'all_pending' && $currentTab != 'all_approval') {
            $currentTab = $this->input->post('status');
        }
        if ($currentTab == 'all_approval') {
            $currentTab = 
			$this->input->post('section');
        }
        switch ($section) {
            case 'mylist':
                $admin = NULL;
                $status = 'status';
                $title = 'My List';
                break;
            case 'rolist':
                #$searchArray[] = "AP.to_RO =  '" . $this->session->userdata('emp_number') . "' ";
				$searchArray[] = "AP.to_RO =  '" . $this->session->userdata('emp_number') . "' AND RO_status ='pending'";
                $admin = 'Show all';
                $status = 'RO_status';
                $title = 'Reporting Officer';
                break;
            case 'phlist':
				
				$check_an_approver_user = $this->Mapproval->get_an_approver_user($this->session->userdata('emp_number'));
				#echo'asd';die;
			
				if($check_an_approver_user!=''){
					$admin = 'Show all';
				}else{
					#$searchArray[] = "MP.programme_head = '" . $this->session->userdata('emp_number') . "'";
					$searchArray[] = "AP.assigned_user = '" . $this->session->userdata('emp_number') . "'";
					if ($currentTab == 'pending' || $currentTab == 'confirmed') {
						$searchArray[] = "AP.RO_status = 'confirmed'";
					}
					$status = 'PH_status';
					$admin = 'Show all';
					$title = 'Programme Head';
				}
				
                break;
            case 'ceolist':
                $ceo = $this->Mapproval->getApprovalSetting('ceo');
                $this->session->userdata('emp_number');
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

        $status_type = $this->input->post('status');
        if ($this->input->post('status') != "") {

            $status_arry = array();
            foreach ($status_type as $status_list) {
                $status_arry[] = "'" . $status_list . "'";
            }
        }
        if (!empty($status_arry)) {
            $split_status = implode(",", $status_arry);
            $searchArray[] = "AP.status IN ($split_status)";
        }

        $where = php72_implode(" and ", $searchArray);
		
		if($this->input->post('currentTab') =='approved'){
			$where = "AP.ro_approved_user =  '" . $this->session->userdata('emp_number') . "' OR ph_approved_user ='" . $this->session->userdata('emp_number') . "' OR ceo_approved_user ='" . $this->session->userdata('emp_number') . "'";
        }
		
		#echo'<pre>';print_r($_POST);
		#echo'<pre>';print_r($where);die;
		#echo'asd';die;
        $approvalCount = $this->Mapproval->getLimitApprovalNotes($where, '', '', $sort_column, $columnSortOrder, $admin);
        $getAll_count = php72_count($approvalCount);
	
        $approval_lists = $this->Mapproval->getLimitApprovalNotes($where, $limit, $start, $sort_column, $columnSortOrder, $admin);
        $getLimit_count = php72_count($approval_lists);
			#echo'<pre>';print_r($approval_lists);die;
        foreach ($approval_lists as $lists) {
            $requestDate = '';
            $seekingDate = '';
            $paymentDate = '';
            if ($lists['date_of_seeking_approval'] != '') {
                $requestDate = date('Y-m-d', strtotime($lists['date_of_seeking_approval']));
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
            if ($lists['PH_status'] == 'pending') {
                $phUser = $lists['assigned_user'];
                $phName = $this->Mapproval->getUserNameInfo($phUser);
				if($phName[0]['user_name']){
					 $approval_userName = $phName[0]['user_name'];
				}
            } else if ($lists['CEO_status'] == 'pending') {
                $ceoUser = $this->Mapproval->getApprovalSetting('ceo');
                $ceoName = $this->Mapproval->getUserNameInfo($ceoUser);
                $approval_userName = $ceoName[0]['user_name'];
            }
			if($phName[0]['user_name']==''){
				#$approval_userName = $RoName[0]['user_name'];
			}
			
			$phUser = $lists['assigned_user'];
			$phName = $this->Mapproval->getUserNameInfo($phUser);
			if($phName[0]['user_name']){
				 $approval_userName = $phName[0]['user_name'];
			}
			
			if (php72_cmp($lists['assigned_user'])==0) {
				 $approval_userName =$RoName[0]['user_name'];
			}
			
			if ($lists['RO_status'] == 'pending') {
				$approval_userName =$RoName[0]['user_name'];
			}if ($lists['RO_status'] == 'confirmed' && $lists['PH_status']=='pending') {
				$approval_userName = $phName[0]['user_name'];
			}
			
			
			
			 #$user_name =  $this->session->userdata('name');
            #}
			#echo'<pre>';print_r($approval_userName);die;

            $grant_status = $this->Mapproval->get_allGrantVal($lists['approval_id']);
            $url = base_url() . 'index.php/approval/approval_note_details/' . $lists['approval_id'] . '/mylist';

            if ($section == 'ceolist') {
                $url = base_url() . 'index.php/approval/approval_note_details/' . $lists['approval_id'] . '/ceolist';
            }
            $confirm_url = $confirm_ur2 = '';

            if ($lists['status'] == 'confirmed') {
				if($this->input->post('currentTab') !='approved'){
					if ($lists["internal_note"] == 'sent') {
						$url_1 = base_url() . 'index.php/internal/approval/' . $lists['approval_id'] . '/' . $section;
						$confirm_url = "<a title='View Internal Note' style='padding: 10px;' href=" . $url_1 . " class='action_cls' data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . "><i class='fas fa-eye'></i></a>";
					}
					if (/* count(array_unique($grant_status)) == 1 && */ $grant_status[0]['status_type'] == 'open') {
						$url_2 = base_url() . 'index.php/internal/sent_internal_note/' . $lists['approval_id'];
						$confirm_ur2 = "<a title='Send Internal Note' style='padding: 10px;' href=" . $url_2 . " class='action_cls'><i class='fas fa-calendar-check'></i></a>";
					} else {
						$confirm_ur2 = "<a title='Send Internal Note' style='padding: 10px;' href='javascript:void(0)' class='show_error_msg'><i class='fas fa-calendar-times'></i></a>";
					}
				}
            }
            if ($lists['status'] == 'draft') {

                $url_1 = base_url() . 'index.php/approval/edit_approval_note/' . $lists['approval_id'];
                $confirm_url = "<a title='Edit' style='padding: 10px;' href=" . $url_1 . " ><i class='fas fa-edit'></i></a>";

                $url_1 = base_url() . 'index.php/approval/send_approval_note/' . $lists['approval_id'] . '/' . $section;
                $confirm_ur2 = "<a title='Send Approval Note' style='padding: 10px;' href=" . $url_1 . " ><i class='fas fa-clipboard-check'></i></a>";
            }

            $view_btn = "<a  style='padding: 10px;' href=" . $url . " class='action_cls delete_cls bordergrn-btn-outline'>" . 'View' . "</a>";
            $an_link = "<a  style='padding: 10px;' href=" . $url . " class='action_cls delete_cls'>" . $lists['approval_no'] . "</a>";
            $status = '';
            $nestedData = array();
            #$nestedData[] = "<a href=''>" . $lists['approval_no'] . "</a>";
            $nestedData[] = $an_link;
            $nestedData[] = $user_name;
            $nestedData[] = date('d-m-Y', strtotime($requestDate));
            // $nestedData[] = $ro_name;
            if ($currentTab == 'all_pending') {
                $nestedData[] = $approval_userName;
            }
            $nestedData[] = $lists['programme_name'];
            $nestedData[] = (strlen($lists['purpose']) > 40) ? substr($lists['purpose'], 0, 40) . ".." : $lists['purpose'];
            // $nestedData[] = $lists['additionalinfo'];
            $nestedData[] = ucfirst($lists['status']);
            // if ($currentTab == 'pending' || $currentTab == 'all_pending') {
            //     $nestedData[] = $approval_userName;
            // }
            #$nestedData[] = "<input type='hidden' class='get_approval_id' value=" . $lists['approval_id'] . " >";
//            if ($currentTab == 'all_approval') {
	 if($this->input->post('currentTab') !='approved'){
            $nestedData[] = $confirm_url . '' . $confirm_ur2;
			
	 }
//            }
			if($this->input->post('currentTab') =='approved'){
				   $nestedData[] ="";
				   $nestedData[] ="";
			   }
				
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
	
	

    public function DTapproval_note_old_an() {
		
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
        $list_type = $this->input->post('list_type');

        $columnArr = array('AP.approval_no', 'AP.from_employee', 'AP.date_of_seeking_approval', 'AP.to_RO', 'MP.programme_head', 'programme_name', 'AP.purpose', 'AN.additionalinfo', 'AP.status');
        $status = 'status';
        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }

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
                $this->session->userdata('emp_number');
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

        $status_type = $this->input->post('status');
        if ($this->input->post('status') != "") {

            $status_arry = array();
            foreach ($status_type as $status_list) {
                $status_arry[] = "'" . $status_list . "'";
            }
        }
        if (!empty($status_arry)) {
            $split_status = implode(",", $status_arry);
            $searchArray[] = "AP.status IN ($split_status)";
        }

        $where = php72_implode(" and ", $searchArray);

        $approvalCount = $this->Mapproval->getLimitApprovalNotes($where, '', '', $sort_column, $columnSortOrder, $admin);
        $getAll_count = php72_count($approvalCount);

        $approval_lists = $this->Mapproval->getLimitApprovalNotes($where, $limit, $start, $sort_column, $columnSortOrder, $admin);
        $getLimit_count = php72_count($approval_lists);

        foreach ($approval_lists as $lists) {
            $requestDate = '';
            $seekingDate = '';
            $paymentDate = '';
            if ($lists['date_of_seeking_approval'] != '') {
                $requestDate = date('Y-m-d', strtotime($lists['date_of_seeking_approval']));
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

            if ($section == 'ceolist') {
                $url = base_url() . 'index.php/approval/approval_note_details/' . $lists['approval_id'] . '/ceolist';
            }
            $confirm_url = $confirm_ur2 = '';

            if ($lists['status'] == 'confirmed') {
                if ($lists["internal_note"] == 'sent') {
                    $url_1 = base_url() . 'index.php/internal/approval/' . $lists['approval_id'] . '/' . $section;
                    $confirm_url = "<a title='View Internal Note' style='padding: 10px;' href=" . $url_1 . " class='action_cls' data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . "><i class='fas fa-eye'></i></a>";
                }
                if (/* count(array_unique($grant_status)) == 1 && */ $grant_status[0]['status_type'] == 'open') {
                    $url_2 = base_url() . 'index.php/internal/sent_internal_note/' . $lists['approval_id'];
                    #$confirm_ur2 = "<a title='Send Internal Note' style='padding: 10px;' href=" . $url_2 . " class='action_cls'><i class='fas fa-calendar-check'></i></a>";
					$confirm_ur2 = "<a title='Send Internal Note' style='padding: 10px;' href='javascript:void(0)' class=''><i class='fas fa-calendar-times'></i></a>";
                } else {
                    $confirm_ur2 = "<a title='Send Internal Note' style='padding: 10px;' href='javascript:void(0)' class='show_error_msg'><i class='fas fa-calendar-times'></i></a>";
                }
				 
            }
            if ($lists['status'] == 'draft') {

                $url_1 = base_url() . 'index.php/approval/edit_approval_note/' . $lists['approval_id'];
                $confirm_url = "<a title='Edit' style='padding: 10px;' href=" . $url_1 . " ><i class='fas fa-edit'></i></a>";

                $url_1 = base_url() . 'index.php/approval/send_approval_note/' . $lists['approval_id'] . '/' . $section;
                $confirm_ur2 = "<a title='Send Approval Note' style='padding: 10px;' href=" . $url_1 . " ><i class='fas fa-clipboard-check'></i></a>";
            }

            $view_btn = "<a  style='padding: 10px;' href=" . $url . " class='action_cls delete_cls bordergrn-btn-outline'>" . 'View' . "</a>";
            $an_link = "<a  style='padding: 10px;' href=" . $url . " class='action_cls delete_cls'>" . $lists['approval_no'] . "</a>";
            $status = '';
            $nestedData = array();
            #$nestedData[] = "<a href=''>" . $lists['approval_no'] . "</a>";
            $nestedData[] = $an_link;
            $nestedData[] = $user_name;
            $nestedData[] = date('d-m-Y', strtotime($requestDate));
            // $nestedData[] = $ro_name;
            if ($currentTab == 'all_pending') {
                $nestedData[] = $approval_userName;
            }
            $nestedData[] = $lists['programme_name'];
            $nestedData[] = (strlen($lists['purpose']) > 40) ? substr($lists['purpose'], 0, 40) . ".." : $lists['purpose'];
            // $nestedData[] = $lists['additionalinfo'];
            $nestedData[] = ucfirst($lists['status']);
            // if ($currentTab == 'pending' || $currentTab == 'all_pending') {
            //     $nestedData[] = $approval_userName;
            // }
            #$nestedData[] = "<input type='hidden' class='get_approval_id' value=" . $lists['approval_id'] . " >";
//            if ($currentTab == 'all_approval') {
            $nestedData[] = $confirm_url . '' . $confirm_ur2;
//            }
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

    public function export_an() {

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $action = $this->input->post('action');

        $return_date_from = $this->input->post('return_date_from');
        $return_date_to = $this->input->post('return_date_to');
        $currentTab = $this->input->post('currentTab');
        $section = $this->input->post('section');
        $list_type = $this->input->post('list_type');

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
                $this->session->userdata('emp_number');
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

        /* if ($this->input->post('purpose') != "")
          $searchArray[] = "AP.purpose like '%" . $this->input->post('purpose') . "%'"; */

        $status_type = $this->input->post('status');
        if ($this->input->post('status') != "") {
            $status_arry = array();
            foreach ($status_type as $status_list) {
                $status_arry[] = "'" . $status_list . "'";
            }
        }
        if (!empty($status_arry)) {
            $split_status = implode(",", $status_arry);
            $searchArray[] = "AP.status IN ($split_status)";
        }
        $where = php72_implode(" and ", $searchArray);

        $data_lists = $this->Mapproval->getLimitApprovalNotes($where, '', '', array(), array(), $admin);

        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"AN_" . $currentTab . "_notes" . date('m-d-Y') . ".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');
        fputcsv($handle, array(
            'Approval Number',
            'Date of Request',
            'Date of Seeking Approval',
            'From: (employee)',
            'Date on which payment is required',
            'To:(RO)',
            'Purpose',
            'Programme',
            'Donor - Grant',
            'Budget Head',
            'Line Item',
            'Cost Centre',
            'Detail',
            'Amount Available',
            'Amount Required',
            'Payment in favor of',
            'Supporting Documents',
            'Comments of Reporting Officer',
            'Comments of Programme Head',
            'Is expense estimated in work plan?',
            'Is expense above Rs. 20,000?'
        ));

        foreach ($data_lists as $list) {
            $emp_name = '';
            if ($list['from_employee'] != '') {
                $emp_name_arr = $this->Mapproval->getUserNameInfo($list['from_employee']);

                $emp_name = $emp_name_arr[0]['user_name'];
            }
            $to_RO = '';
            if ($list['to_RO'] != '') {
                $ro_name_arr = $this->Mapproval->getUserNameInfo($list['to_RO']);
                $to_RO = $ro_name_arr[0]['user_name'];
            }
            $date_of_request = '';
            if ($list['date_of_request'] != '0000-00-00 00:00:00' && $list['date_of_request'] != '0000-00-00') {
                $date_of_request = $list['date_of_request'];
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
                $list['approval_no'],
                $date_of_request,
                $date_of_seeking_approval,
                $emp_name,
                $date_payment_required,
                $to_RO,
                $list['purpose'],
                $list['programme_name'],
                $list['donor'],
                $list['budget_head'],
                $list['line_item'],
                $list['cost_centre'],
                $list['additionalinfo'],
                $list['amt_available'],
                $list['amt_required'],
                $list['payment_favor'],
                $list['supporting_documents'],
                $list['comments_PH'],
                $list['estimated_in_workplan'],
                $list['above_50000']
            ));
        }

        fclose($handle);
        exit;
    }

    public function archive() {
        $ceo = $this->Mapproval->getApprovalSetting('ceo');
        if ($ceo == $this->session->userdata('emp_number')) {
            $data['ceo'] = $ceo;
            $data['ceo_status'] = 'Yes';
            $where = "(AP.above_50000 = 'yes' or AP.estimated_in_workplan = 'no' ) and AP.status = 'pending'";
            $columnSortOrder = 'asc';
            $admin = 'Show all';
            $approvalCount = $this->Mapproval->getLimitApprovalNotes($where, '', '', $sort_column, $columnSortOrder, $admin);
            $getAll_count = php72_count($approvalCount);
            $data['pending_ceo_count'] = $getAll_count;
        }

        $emp_id = $this->session->userdata('emp_number');
        $partner_id = $this->session->userdata('partner_id');

        $data['financialList'] = $this->Mapproval->getfinanciallist();
        $data['approval_new'] = $this->Mapproval->approvalNumber();
        $data['reporting_list'] = $this->Mapproval->getROlist($emp_id);
        $data['program_list'] = $this->Mapproval->getProgrammeList();
        $data['an_rocount'] = $rocount = total_ropending_count($emp_id);
        $data['an_phcount'] = $phcount = total_phpending_count($emp_id);

        $ph_user_count = $this->Mapproval->get_ph_user($emp_id, $partner_id);
        $data['ph_Usercount'] = '0';


        if (!empty($ph_user_count)) {
            $data['ph_Usercount'] = '1';
        }

        $this->load->vars($data);
        $this->load->view('approval/user/archive');
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
        $approval_note_type = $this->input->post('approval_note_type');
        #echo'<pre>';print_r($_POST);die;
        $columnArr = array('AP.approval_no', 'AP.date_of_seeking_approval', 'AP.to_RO', 'AP.purpose', 'programme_name', 'AN.additionalinfo', 'AP.status');
        $status = 'status';
        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }

        switch ($section) {
            case 'mylist':
                $admin = NULL;
                $status = 'status';
                $title = 'My List';
                break;
            case 'rolist':
                $searchArray[] = "AP.to_RO =  '" . $this->session->userdata('user') . "' ";
                $admin = 'Show all';
                $status = 'RO_status';
                $title = 'Reporting Officer';
                break;
            case 'phlist':
                $searchArray[] = "MP.programme_head = '" . $this->session->userdata('user') . "'";
                if ($currentTab == 'pending' || $currentTab == 'confirmed') {
                    $searchArray[] = "AP.RO_status = 'confirmed'";
                }
                $status = 'PH_status';
                $admin = 'Show all';
                $title = 'Programme Head';
                break;
            case 'ceolist':
                $ceo = $this->Mapproval->getApprovalSetting('ceo');
                if ($ceo != $this->session->userdata('user')) {
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

        /* if ($this->input->post('status') != "")
          $searchArray[] = "AP.status like '%" . $this->input->post('status') . "%'"; */

        $finance = unserialize($this->Mapproval->getApprovalSetting('finance'));
        if (php72_in_array($this->session->userdata['emp_number'], $finance)) {
            #$searchArray[] = "";
        } else {
            $searchArray[] = "AP.from_employee = '" . $this->session->userdata['emp_number'] . "'";
        }
        if ($approval_note_type == '1') {
            $searchArray[] = "AP.from_employee = '" . $this->session->userdata('emp_number') . "'";
        }


        $status_type = $this->input->post('status');
        if ($this->input->post('status') != "") {

            $status_arry = array();
            foreach ($status_type as $status_list) {
                $status_arry[] = "'" . $status_list . "'";
            }
        }

        if (!empty($status_arry)) {

            $split_status = implode(",", $status_arry);
            $searchArray[] = $esf = "AP.status IN ($split_status)";
            #echo'<pre>';print_r($esf);die;
        }

        $where = php72_implode(" and ", $searchArray);

        /* echo'<pre>';print_r($_POST);
          ECHO $where;DIE; */

        $getAll_count = $this->Mapproval->getarchiveApprovalNotesCount($from, $to, $where);

        $approval_lists = $this->Mapproval->getarchiveApprovalNotes($from, $to, $limit, $start, $where, $sort_column, $columnSortOrder);
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
            $url = base_url() . 'index.php/approval/approval_note_details/' . $lists['approval_id'] . '/mylist';
            $confirm_url = $confirm_ur2 = '';

            $view_btn = "<a title='View Approval Note' style='padding: 10px;' href=" . $url . " class='action_cls'><i class='fas fa-eye'></i></a>";
            $status = '';
            $nestedData = array();
            $nestedData[] = "<a  style='padding: 10px;' href=" . $url . " class='action_cls delete_cls'>" . $lists['approval_no'] . "</a>";
            $nestedData[] = $user_name;
            $nestedData[] = date('d-m-Y', strtotime($lists["date_of_seeking_approval"]));
            // $nestedData[] = $ro_name;
            $nestedData[] = ucfirst($lists['programme_name']);
            $nestedData[] = (strlen($lists['purpose']) > 50) ? substr($lists['purpose'], 0, 50) . ".." : $lists['purpose'];
            // $nestedData[] = ucfirst($lists['additionalinfo']);
            $nestedData[] = ucfirst($lists['status']);
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

    public function export_an_archive() {
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $action = $this->input->post('action');

        $return_date_from = $this->input->post('return_date_from');
        $return_date_to = $this->input->post('return_date_to');
        $currentTab = $this->input->post('currentTab');
        $section = $this->input->post('section');
        $approval_note_type = $this->input->post('approval_note_type');
        $columnArr = array('AP.approval_no', 'AP.date_of_seeking_approval', 'AP.to_RO', 'AP.purpose', 'programme_name', 'AN.additionalinfo', 'AP.status');
        $status = 'status';
        if ($columnArr[$columnIndex] != '') {
            $sort_column = $columnArr[$columnIndex];
        }

        switch ($section) {
            case 'mylist':
                $admin = NULL;
                $status = 'status';
                $title = 'My List';
                break;
            case 'rolist':
                $searchArray[] = "AP.to_RO =  '" . $this->session->userdata('user') . "' ";
                $admin = 'Show all';
                $status = 'RO_status';
                $title = 'Reporting Officer';
                break;
            case 'phlist':
                $searchArray[] = "MP.programme_head = '" . $this->session->userdata('user') . "'";
                if ($currentTab == 'pending' || $currentTab == 'confirmed') {
                    $searchArray[] = "AP.RO_status = 'confirmed'";
                }
                $status = 'PH_status';
                $admin = 'Show all';
                $title = 'Programme Head';
                break;
            case 'ceolist':
                $ceo = $this->Mapproval->getApprovalSetting('ceo');
                if ($ceo != $this->session->userdata('user')) {
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

        /* if ($this->input->post('status') != "")
          $searchArray[] = "AP.status like '%" . $this->input->post('status') . "%'"; */

        $status_type = $this->input->post('status');
        if ($this->input->post('status') != "") {
            $status_arry = array();
            foreach ($status_type as $status_list) {
                $status_arry[] = "'" . $status_list . "'";
            }
        }
        if (!empty($status_arry)) {
            $split_status = implode(",", $status_arry);
            $searchArray[] = "AP.status IN ($split_status)";
        }
        $finance = unserialize($this->Mapproval->getApprovalSetting('finance'));
        if (php72_in_array($this->session->userdata('emp_number'), $finance)) {
            #$searchArray[] = "";
        } else {
            $searchArray[] = "AP.from_employee = '" . $this->session->userdata('emp_number') . "'";
        }
        if ($approval_note_type == '1') {
            $searchArray[] = "AP.from_employee = '" . $this->session->userdata('emp_number') . "'";
        }


        $where = php72_implode(" and ", $searchArray);
        $data_lists = $this->Mapproval->getarchiveApprovalNotes($from, $to, '', '', $where, array(), array());

        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"AN_archives_notes_" . date('m-d-Y') . ".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $handle = fopen('php://output', 'w');
        fputcsv($handle, array(
            'Approval Number',
            'Date of Request',
            'Date of Seeking Approval',
            'From: (employee)',
            'Date on which payment is required',
            'To:(RO)',
            'Purpose',
            'Programme',
            'Donor - Grant',
            'Budget Head',
            'Line Item',
            'Cost Centre',
            'Detail',
            'Amount Available',
            'Amount Required'
        ));

        foreach ($data_lists as $list) {
            $emp_name = '';
            if ($list['from_employee'] != '') {
                $emp_name_arr = $this->Mapproval->getUserNameInfo($list['from_employee']);

                $emp_name = $emp_name_arr[0]['user_name'];
            }
            $to_RO = '';
            if ($list['to_RO'] != '') {
                $ro_name_arr = $this->Mapproval->getUserNameInfo($list['to_RO']);
                $to_RO = $ro_name_arr[0]['user_name'];
            }
            $date_of_request = '';
            if ($list['date_of_request'] != '0000-00-00 00:00:00' && $list['date_of_request'] != '0000-00-00') {
                $date_of_request = $list['date_of_request'];
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
                $list['approval_no'],
                $date_of_request,
                $date_of_seeking_approval,
                $emp_name,
                $date_payment_required,
                $to_RO,
                $list['purpose'],
                $list['programme_name'],
                $list['donor'],
                $list['budget_head'],
                $list['line_item'],
                $list['cost_centre'],
                $list['additionalinfo'],
                $list['amt_available'],
                $list['amt_required']
            ));
        }

        fclose($handle);
        exit;
    }

    public function action_history() {
        $emp_id = $this->session->userdata('emp_number');
        $partner_id = $this->session->userdata('partner_id');

        $data['financialList'] = $this->Mapproval->getfinanciallist();
        $data['approval_new'] = $this->Mapproval->approvalNumber();
        $data['reporting_list'] = $this->Mapproval->getROlist($emp_id);
        $data['program_list'] = $this->Mapproval->getProgrammeList();
        $data['an_rocount'] = $rocount = total_ropending_count($emp_id);
        $data['an_phcount'] = $phcount = total_phpending_count($emp_id);

        $ph_user_count = $this->Mapproval->get_ph_user($emp_id, $partner_id);
        $data['ph_Usercount'] = '0';
        if (!empty($ph_user_count)) {
            $data['ph_Usercount'] = '1';
        }

        $this->load->vars($data);
        $this->load->view('approval/user/action_history');
    }

    public function DTaction_history() {
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

        switch ($section) {
            case 'mylist':
                $admin = NULL;
                $status = 'status';
                $title = 'My List';
                break;
            case 'rolist':
                $searchArray[] = "AP.to_RO =  '" . $this->session->userdata('user') . "' ";
                $admin = 'Show all';
                $status = 'RO_status';
                $title = 'Reporting Officer';
                break;
            case 'phlist':
                $searchArray[] = "MP.programme_head = '" . $this->session->userdata('user') . "'";
                if ($currentTab == 'pending' || $currentTab == 'confirmed') {
                    $searchArray[] = "AP.RO_status = 'confirmed'";
                }
                $status = 'PH_status';
                $admin = 'Show all';
                $title = 'Programme Head';
                break;
            case 'ceolist':
                $ceo = $this->Mapproval->getApprovalSetting('ceo');
                if ($ceo != $this->session->userdata('user')) {
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
            $url = base_url() . 'index.php/approval/approval_note_details/' . $lists['approval_id'] . '/mylist';
            $confirm_url = $confirm_ur2 = '';

            $view_btn = "<a  href=" . $url . " class='action_cls delete_cls bordergrn-btn-outline' value=" . $lists['asset_id'] . " data-attr-an=" . $lists['asset_no'] . " data-attr-tid=" . $lists['transfer_id'] . " data-attr-ac=" . $lists['asset_code'] . " data-attr-aid=" . $lists['asset_id'] . ">" . 'View' . "</a>";
            $status = '';
            $nestedData = array();
            $nestedData[] = $lists['approval_no'];
            $nestedData[] = date('Y-m-d', strtotime($lists["date_of_seeking_approval"]));
            $nestedData[] = $ro_name;
            $nestedData[] = (strlen($lists['purpose']) > 50) ? substr($lists['purpose'], 0, 50) . ".." : $lists['purpose'];
            $nestedData[] = ucfirst($lists['programme_name']);
            $nestedData[] = ucfirst($lists['additionalinfo']);
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

    function approval_note_details($id = '', $section = 'mylist') {
        $ceo = $this->Mapproval->getApprovalSetting('ceo');
        $data['ceo'] = $ceo;

        $partnerNote = $this->Mapproval->getPartner($id);
        if (php72_cmp($partnerNote) < 1 && is_numeric($id)) {
            redirect('approval/approval_note/pending');
        }
        $data['section'] = $section;
        $finance = unserialize($this->Mapproval->getApprovalSetting('finance'));
        if (php72_in_array($this->session->userdata('user'), $finance)) {
            $data['isFinance'] = 'Yes';
        } else {
            $data['isFinance'] = 'No';
        }

        $grantList = $this->Mapproval->get_grantList();
        $grantArr = array();
        foreach ($grantList as $lists) {
            $grantArr[$lists->id] = $lists->name;
        }
        $data['grantArr'] = $grantArr;

        $data['comments'] = $this->Mapproval->selectComment($id);
        $data['totalcomments'] = $this->Mapproval->selectTotalComment($id);

        $adminDetails = $this->Mapproval->adminDetails();
        $admin = $adminDetails[0]['id'];
        $data['isView'] = 'true';
        $data['isbView'] = 'true';
        $data['approvalNoteDetails'] = $approvalNoteDetails = $this->Mapproval->getApprovalNote($id);
        $partner_id = $data['approvalNoteDetails'][0]['partner_id'];
        $data['partner_details'] = $this->Mapproval->get_partnerName($partner_id);

        if ($approvedetails[0]['RO_status'] == 'defered' || $approvedetails[0]['PH_status'] == 'defered' || $approvedetails[0]['CEO_status'] == 'defered') {
            $data['isView'] = 'true';
        }
        if ($userid == $approvedetails[0]['from_employee'] || $userid == $approvedetails[0]['to_RO'] || $userid == $approvedetails[0]['programme_head'] || $userid == $ceo || $admin) {
            $data['isbView'] = 'true';
        }
        $data['emp_name'] = '';
		
        if ($approvalNoteDetails[0]['from_employee'] != '') {
            $emp_name_arr = $this->Mapproval->getUserNameInfo($approvalNoteDetails[0]['from_employee']);
            $data['emp_name'] = $emp_name_arr[0]['user_name'];
        }
        $data['ph_name'] = '';
        if ($approvalNoteDetails[0]['programme_head'] != '') {
            $ph_name_arr = $this->Mapproval->getUserNameInfo($approvalNoteDetails[0]['programme_head']);
            $data['ph_name'] = $ph_name_arr[0]['user_name'];
        }
		if($approvalNoteDetails[0]['assigned_user']!=''){
			$ph_name_arr = $this->Mapproval->getUserNameInfo($approvalNoteDetails[0]['assigned_user']);
            $data['ph_name'] = $ph_name_arr[0]['user_name'];
		}
        $data['to_RO'] = '';

        if ($approvalNoteDetails[0]['to_RO'] != '') {
            $ro_name_arr = $this->Mapproval->getUserNameInfo($approvalNoteDetails[0]['to_RO']);
            $data['to_RO'] = $ro_name_arr[0]['user_name'];
        }
		
		if($approvalNoteDetails[0]["assigned_user"]=='0'){ 
			$data['phhead'] = '';
		}else if(php72_cmp($approvalNoteDetails[0]["assigned_user"])>0){
			 $data['ph_name'] = $ph_name_arr[0]['user_name'];
		}else{
			if(trim($approvalNoteDetails[0]['above_50000'])=='yes'){ 
				//CEO
				$ph_name_arr = $this->Mapproval->getUserNameInfo(268);
				$data['ph_name'] = $ph_name_arr[0]['user_name'];
			}else{
				 $data['ph_name'] = $ph_name_arr[0]['user_name'];
			}
			
		}
			
			
        $ceoUser = $this->Mapproval->getApprovalSetting('ceo');

        $ceoName = $this->Mapproval->getUserNameInfo($ceoUser);
        $data['ceo_name'] = $ceoName[0]['user_name'];

        $data['subUsers'] = $this->Mapproval->reportingUser('subUser', 'userId');
        $data['sumof_int_amt'] = $this->Mapproval->int_amt_sumof($id);
        $data['donorAN'] = $this->Mapproval->getApprovalDonors($approvalNoteDetails[0]["approval_id"]);
        $data['open_int_notes'] = $this->Mapproval->getStatusINT($approvalNoteDetails[0]["approval_id"]);

        $data['employee_name'] = $this->Mapproval->getEmployeeName($approvalNoteDetails[0]['from_employee']);
        $data['user_id'] = $approvalNoteDetails[0]['from_employee'];

        $data['approval_id'] = $approvalNoteDetails[0]["approval_id"];
        $data['cpagetitle'] = "Approval Note Details";
        $this->load->view('approval/user/approval_note_details', $data);
    }
	
	
	function approval_note_details_test($id = '', $section = 'mylist') {
        $ceo = $this->Mapproval->getApprovalSetting('ceo');
        $data['ceo'] = $ceo;

        $partnerNote = $this->Mapproval->getPartner($id);
        if (php72_cmp($partnerNote) < 1 && is_numeric($id)) {
            redirect('approval/approval_note/pending');
        }
        $data['section'] = $section;
        $finance = unserialize($this->Mapproval->getApprovalSetting('finance'));
        if (php72_in_array($this->session->userdata('user'), $finance)) {
            $data['isFinance'] = 'Yes';
        } else {
            $data['isFinance'] = 'No';
        }

        $grantList = $this->Mapproval->get_grantList();
        $grantArr = array();
        foreach ($grantList as $lists) {
            $grantArr[$lists->id] = $lists->name;
        }
        $data['grantArr'] = $grantArr;

        $data['comments'] = $this->Mapproval->selectComment($id);
        $data['totalcomments'] = $this->Mapproval->selectTotalComment($id);

        $adminDetails = $this->Mapproval->adminDetails();
        $admin = $adminDetails[0]['id'];
        $data['isView'] = 'true';
        $data['isbView'] = 'true';
        $data['approvalNoteDetails'] = $approvalNoteDetails = $this->Mapproval->getApprovalNote($id);
        $partner_id = $data['approvalNoteDetails'][0]['partner_id'];
        $data['partner_details'] = $this->Mapproval->get_partnerName($partner_id);

        if ($approvedetails[0]['RO_status'] == 'defered' || $approvedetails[0]['PH_status'] == 'defered' || $approvedetails[0]['CEO_status'] == 'defered') {
            $data['isView'] = 'true';
        }
        if ($userid == $approvedetails[0]['from_employee'] || $userid == $approvedetails[0]['to_RO'] || $userid == $approvedetails[0]['programme_head'] || $userid == $ceo || $admin) {
            $data['isbView'] = 'true';
        }
        $data['emp_name'] = '';
		
        if ($approvalNoteDetails[0]['from_employee'] != '') {
            $emp_name_arr = $this->Mapproval->getUserNameInfo($approvalNoteDetails[0]['from_employee']);
            $data['emp_name'] = $emp_name_arr[0]['user_name'];
        }
        $data['ph_name'] = '';
        if ($approvalNoteDetails[0]['programme_head'] != '') {
            $ph_name_arr = $this->Mapproval->getUserNameInfo($approvalNoteDetails[0]['programme_head']);
            $data['ph_name'] = $ph_name_arr[0]['user_name'];
        }
		if($approvalNoteDetails[0]['assigned_user']!=''){
			$ph_name_arr = $this->Mapproval->getUserNameInfo($approvalNoteDetails[0]['assigned_user']);
            $data['ph_name'] = $ph_name_arr[0]['user_name'];
		}
        $data['to_RO'] = '';

        if ($approvalNoteDetails[0]['to_RO'] != '') {
            $ro_name_arr = $this->Mapproval->getUserNameInfo($approvalNoteDetails[0]['to_RO']);
            $data['to_RO'] = $ro_name_arr[0]['user_name'];
        }
		
		if($approvalNoteDetails[0]["assigned_user"]=='0'){ 
			$data['phhead'] = '';
		}else if(php72_cmp($approvalNoteDetails[0]["assigned_user"])>0){
			 $data['ph_name'] = $ph_name_arr[0]['user_name'];
		}else{
			if(trim($approvalNoteDetails[0]['above_50000'])=='yes'){ 
				//CEO  ph_name
				$ph_name_arr = $this->Mapproval->getUserNameInfo(268);
				$data['ph_name'] = $ph_name_arr[0]['user_name'];
			}else{
				 $data['ph_name'] = $ph_name_arr[0]['user_name'];
			}
			
		}
			
			
        $ceoUser = $this->Mapproval->getApprovalSetting('ceo');

        $ceoName = $this->Mapproval->getUserNameInfo($ceoUser);
        $data['ceo_name'] = $ceoName[0]['user_name'];

        $data['subUsers'] = $this->Mapproval->reportingUser('subUser', 'userId');
        $data['sumof_int_amt'] = $this->Mapproval->int_amt_sumof($id);
        $data['donorAN'] = $this->Mapproval->getApprovalDonors($approvalNoteDetails[0]["approval_id"]);
        $data['open_int_notes'] = $this->Mapproval->getStatusINT($approvalNoteDetails[0]["approval_id"]);

        $data['employee_name'] = $this->Mapproval->getEmployeeName($approvalNoteDetails[0]['from_employee']);
        $data['user_id'] = $approvalNoteDetails[0]['from_employee'];

        $data['approval_id'] = $approvalNoteDetails[0]["approval_id"];
        $data['cpagetitle'] = "Approval Note Details";
        $this->load->view('approval/user/approval_note_details', $data);
    }
	
	
	function add_new_approval_test($action = NULL, $travel = NULL) {
		
		
        if ($this->input->post('saveForm') != '') {
			
	

            $error = 0;
            $donor = $this->input->post('donor_list');
            $other_donor = $this->input->post('other_donor');
            $budget_head = $this->input->post('budget_list');
            $grant_list = $this->input->post('grant_list');
            $other_budget_head = $this->input->post('other_budget_head');
            $line_item = $this->input->post('line_list');
            $other_line_item = $this->input->post('other_line_item');
            $cost_avail = $this->input->post('subline_avail');
            $subline_item = $this->input->post('cost_centre');
            $additional_avail = $this->input->post('additional_avail');
            $additional_info = $this->input->post('additional_list');
            @$amt_available = str_replace(',', '', $this->input->post('amt_available'));
            @$amt_required = str_replace(',', '', $this->input->post('amt_required'));
            foreach ($donor as $key => $value):
                if ($donor[$key] == '' || $grant_list[$key] == '' || $budget_head[$key] == '' || $line_item[$key] == '' || $amt_available[$key] == '' || $amt_required[$key] == '' || ($cost_avail[$key] == '1' && $subline_item[$key] == '') || ($additional_avail[$key] == '1' && $additional_info[$key] == ''))
                    $error = 1;
                if ((php72_cmp($donor[$key]) == 0 && $other_donor[$key] == '') || (php72_cmp($budget_head[$key]) == 0 && $other_budget_head[$key] == '') || (php72_cmp($line_item[$key]) == 0 && $other_line_item[$key] == ''))
                    $error = 1;
            endforeach;
            /* added for server side validation by amala */
            foreach ($donor as $dondetails => $value) {
                $prog = $this->input->post('programme');
                $don = $donor[$dondetails];
                $bh = $budget_head[$dondetails];
                $li = $line_item[$dondetails];
                $additional_info = $additional_info[$dondetails];
                $amount_req = $amt_required[$dondetails];
                $grant_ids = $grant_list[$dondetails];
                $avail_amt = $this->amountAvailableforssval($prog, $don, $bh, $li, '', $grant_ids);
				
				if ((string)$avail_amt < (string)$amount_req){
						$error = 2;
				}
                
                    
            }
			
            $this->form_validation->set_rules('date_of_seeking_approval', 'Date of Seeking Approval', 'required');
            $this->form_validation->set_rules('programme', 'Programme', 'required');
            $this->form_validation->set_rules('to_RO', 'Reporting Officer', 'required');

            if ($this->form_validation->run() != FALSE && $error == 0) {
                $data = $this->Mapproval->insertapprovaldraftTest();
                if ($data) {
                    $this->session->set_flashdata('successMsg', 'Approval Note Saved Successfully!');
                    redirect('approval/approval_note/all_pending');
                } else {
                    redirect('approval/approvalform');
                }
            } else if ($error == 2) {
                $data['errorMsg'] = "The amount required exceeds amount Available and it is not possible to enter higher amount";
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }
        }
        if ($this->input->post('submitForm') != '') {
            $error = 0;
            $donor = $this->input->post('donor_list');
            $grant_list = $this->input->post('grant_list');
            $other_donor = $this->input->post('other_donor');
            $budget_head = $this->input->post('budget_list');
            $other_budget_head = $this->input->post('other_budget_head');
            $line_item = $this->input->post('line_list');
            $other_line_item = $this->input->post('other_line_item');
            $cost_avail = $this->input->post('subline_avail');
            $subline_item = $this->input->post('cost_centre');
            $additional_avail = $this->input->post('additional_avail');
            $additional_info = $this->input->post('additional_list');
            @$amt_available = str_replace(',', '', $this->input->post('amt_available'));
            @$amt_required = str_replace(',', '', $this->input->post('amt_required'));
            foreach ($donor as $key => $value):
                if ($donor[$key] == '' || $grant_list[$key] == '' || $budget_head[$key] == '' || $line_item[$key] == '' || $amt_available[$key] == '' || $amt_required[$key] == '' || ($cost_avail[$key] == '1' && $subline_item[$key] == '') || ($additional_avail[$key] == '1' && $additional_info[$key] == ''))
                    $error = 1;
                if ((php72_cmp($donor[$key]) == 0 && $other_donor[$key] == '') || $grant_list[$key] == '' || (php72_cmp($budget_head[$key]) == 0 && $other_budget_head[$key] == '') || (php72_cmp($line_item[$key]) == 0 && $other_line_item[$key] == ''))
                    $error = 1;
            endforeach;
            /* server side validation */
            foreach ($donor as $dondetails => $value) {
                $prog = $this->input->post('programme');
                $don = $donor[$dondetails];
                $bh = $budget_head[$dondetails];
                $li = $line_item[$dondetails];
                $additional_info = $additional_info[$dondetails];
                $amount_req = $amt_required[$dondetails];
                $grant_ids = $grant_list[$dondetails];
                $avail_amt = $this->amountAvailableforssval($prog, $don, $bh, $li, '', $grant_ids);
				if ((string)$avail_amt < (string)$amount_req){
					$error = 2;
				}
                   
            }

            $this->form_validation->set_rules('date_of_seeking_approval', 'Date of Seeking Approval', 'required');
            $this->form_validation->set_rules('programme', 'Programme', 'required');
            $this->form_validation->set_rules('to_RO', 'Reporting Officer', 'required');  // added on 2/7/14 for multiple ro concept
            if ($this->form_validation->run() != FALSE && $error == 0) {

                $grnat_status_error = 'Yes';
                if (!empty($grant_list)) {
                    foreach ($grant_list as $grantID) {
                        if ($grantID != '') {
                            #$this->current_db = $this->load->database('mis', true);
                            $db_var = $this->db;
                            $fields = array('id', 'name', 'status_type');
                            $condition = array('id' => $grantID, 'status_type' => 'open');
                            $db_var->select($fields);
                            $db_var->where($condition);
                            $query = $db_var->get('grant_list');
                            $get_results = $query->result();
                            if (empty($get_results)) {
                                $grnat_status_error = 'No';
                            }
                        }
                    }
                }
                if ($grnat_status_error == 'Yes') {
					
					
                    $id = $this->Mapproval->insertApprovalNote();
					
					$sendMail = $this->approvalRequestMail($id);
					
					#AN Assign User
					
					#Update PH status to confirmed when the amount is lessthan 50000
					
					$amount = 0;
					$amt_required_str = str_replace(',', '',$this->input->post('amt_required'));
					foreach ($amt_required_str as $key => $value):
						$amount += $value;
					endforeach;
			
					$this->ais = $this->load->database('ais', TRUE);			
					$this->ais->select('MP.programme_id,MP.an_assign_user');
					$this->ais->where('MP.programme_id', $this->input->post('programme'),);
					$this->ais->where('MP.partner_id', $this->session->userdata('partner_id'));
					$queryMasterProgram = $this->ais->get('master_programme MP');
					$getMasterProgram = $queryMasterProgram->result();
					$assigned_user ='';
					if(!empty($getMasterProgram)){
						if ($this->session->userdata('currency') == 'INR' && $amount <= 50000 ) {
							$this->Mapproval->updatePHStatus($id);
						}
					}else{
						$this->db->select('below_three_lakhs,above_three_lakhs,above_ten_lakhs');
						$query = $this->db->get('an_assign_user');
						$get_an_assign_user = $query->result_array();
						if ($this->session->userdata('currency') == 'INR' && $amount <=50000) { 
							$this->Mapproval->updatePHStatus($id);
						}
					}
					#AN Assign User
					
					
                    $this->session->set_flashdata('successMsg', 'Approval Note Added Successfully!');

                    if ($travel == 'travel') {
                        redirect('traveluser/after_approval/' . $id);
                    } else if ($this->input->post('service') == 'seedfunding') {
                        redirect('<?php echo host_url(); ?>vital/index.php/seedfunding/getinstallment/' . $this->input->post('innovation') . '/' . $this->input->post('installment') . '/approval/' . $id);
                    } else {
                        //redirect('approvaluser/approval_form');
                    }
                } else {
                    $data['errorMsg'] = "Choose another grant type";
                }
            } else if ($error == 2) {
                $data['errorMsg'] = "The amount required exceeds amount Available and it is not possible to enter higher amount";
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }
        }

        $grant_lists = $this->input->post('grant_list');
        $data['grant_list'] = $grant_lists;

        $data['approval_new'] = $this->Mapproval->approvalNumber();
        $data['RO'] = $this->Mapproval->reportingUser('supUser', 'All', $this->session->userdata('empNumber'));
        $data['donorList'] = $this->Mapproval->getMasterSetting('Donor');
        $data['budgetHeadList'] = $this->Mapproval->getMasterSetting('Budget Head');
        $data['costCentreList'] = $this->Mapproval->getMasterSetting('Cost Centre');
        $data['programmeList'] = $this->Mapproval->getBalanceProgramme();
        $data['cpagetitle'] = "New Approval Note ";
        $data['cpage'] = "approval/user/approvalForm";
        redirect('approval/approval_note/all_pending');
    }

   
   

    function add_new_approval($action = NULL, $travel = NULL) {
		
		
		
		/* if($this->session->userdata('emp_number') == '275') {
				
				$id='11359';
				$approvalNoteDetails = $this->Mapproval->getApprovalNote($id);
				
				
				$this->Mapproval->actionApproveRO('approve', $id);
				#echo'<pre>';print_r($approvalNoteDetails);die;
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
					$mailContent['employeeEmail']='arunkumar.d@claritaz.com';
					$mailContent['phEmail']='arunkumar.d@claritaz.com';
					$mailContent['phEmail']='arunkumar.d@claritaz.com';
					$mailContent['reportAuthEmail']='arunkumar.d@claritaz.com';
					$mailContent['ceoEmail']='arunkumar.d@claritaz.com';
					$mailContent['attach'][0] ='uploads/support_docs/sample597899902811.pdf';
					
					$this->sendMail($mailContent['employeeEmail'], $mailContent[$toEm[$key]], 'Approval Note Request by Employee', $mailContent, $mailContent['attach']);
					
				}
				
				echo'sent'; die;
		}
				 */	
		/* 
		$amt_available_post =  $this->input->post('amt_available');
		$amt_required_post = $this->input->post('amt_required');
		
		$err_count = 0;
		if(!empty($amt_available_post) && !empty($amt_required_post)){
			$total_count = count($amt_available_post);
			if($total_count > 0){
				for ($j = 0; $j <= $total_count; $j++){
					$amt_available_count =   str_replace(',', '', $amt_available_post[$j]);
					$amt_required_count =  str_replace(',', '', $amt_required_post[$j]);
					if($amt_required_count > $amt_available_count){
						$err_count++;
					}
				}
			}
		}
		if($err_count > 0){
			$this->session->set_flashdata('successMsg', 'The amount exceeds amount approved and it is not possible to enter higher amount');
			redirect("/approval/new_approval");
			exit;
		} */
		
        if ($this->input->post('saveForm') != '') {
            $error = 0;
            $donor = $this->input->post('donor_list');
            $other_donor = $this->input->post('other_donor');
            $budget_head = $this->input->post('budget_list');
            $grant_list = $this->input->post('grant_list');
            $other_budget_head = $this->input->post('other_budget_head');
            $line_item = $this->input->post('line_list');
            $other_line_item = $this->input->post('other_line_item');
            $cost_avail = $this->input->post('subline_avail');
            $subline_item = $this->input->post('cost_centre');
            $additional_avail = $this->input->post('additional_avail');
            $additional_info = $this->input->post('additional_list');
            @$amt_available = str_replace(',', '', $this->input->post('amt_available'));
            @$amt_required = str_replace(',', '', $this->input->post('amt_required'));
            foreach ($donor as $key => $value):
                if ($donor[$key] == '' || $grant_list[$key] == '' || $budget_head[$key] == '' || $line_item[$key] == '' || $amt_available[$key] == '' || $amt_required[$key] == '' || ($cost_avail[$key] == '1' && $subline_item[$key] == '') || ($additional_avail[$key] == '1' && $additional_info[$key] == ''))
                    $error = 1;
                if ((php72_cmp($donor[$key]) == 0 && $other_donor[$key] == '') || (php72_cmp($budget_head[$key]) == 0 && $other_budget_head[$key] == '') || (php72_cmp($line_item[$key]) == 0 && $other_line_item[$key] == ''))
                    $error = 1;
            endforeach;
            /* added for server side validation by amala */
            foreach ($donor as $dondetails => $value) {
                $prog = $this->input->post('programme');
                $don = $donor[$dondetails];
                $bh = $budget_head[$dondetails];
                $li = $line_item[$dondetails];
                $additional_info = $additional_info[$dondetails];
                $amount_req = $amt_required[$dondetails];
                $grant_ids = $grant_list[$dondetails];
                $avail_amt = $this->amountAvailableforssval($prog, $don, $bh, $li, '', $grant_ids);
				
				if ((string)$avail_amt < (string)$amount_req){
						$error = 2;
				}
                
                    
            }
			
            $this->form_validation->set_rules('date_of_seeking_approval', 'Date of Seeking Approval', 'required');
            $this->form_validation->set_rules('programme', 'Programme', 'required');
            $this->form_validation->set_rules('to_RO', 'Reporting Officer', 'required');
			
			
            if ($this->form_validation->run() != FALSE && $error == 0) {
                $data = $this->Mapproval->insertapprovaldraft();
                if ($data) {
                    $this->session->set_flashdata('successMsg', 'Approval Note Saved Successfully!');
                    redirect('approval/approval_note/all_pending');
                } else {
                    redirect('approval/approvalform');
                }
            } else if ($error == 2) {
                $data['errorMsg'] = "The amount required exceeds amount Available and it is not possible to enter higher amount";
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }
        }
		
		
        if ($this->input->post('submitForm') != '') {
            $error = 0;
            $donor = $this->input->post('donor_list');
            $grant_list = $this->input->post('grant_list');
            $other_donor = $this->input->post('other_donor');
            $budget_head = $this->input->post('budget_list');
            $other_budget_head = $this->input->post('other_budget_head');
            $line_item = $this->input->post('line_list');
            $other_line_item = $this->input->post('other_line_item');
            $cost_avail = $this->input->post('subline_avail');
            $subline_item = $this->input->post('cost_centre');
            $additional_avail = $this->input->post('additional_avail');
            $additional_info = $this->input->post('additional_list');
            @$amt_available = str_replace(',', '', $this->input->post('amt_available'));
            @$amt_required = str_replace(',', '', $this->input->post('amt_required'));
            foreach ($donor as $key => $value):
                if ($donor[$key] == '' || $grant_list[$key] == '' || $budget_head[$key] == '' || $line_item[$key] == '' || $amt_available[$key] == '' || $amt_required[$key] == '' || ($cost_avail[$key] == '1' && $subline_item[$key] == '') || ($additional_avail[$key] == '1' && $additional_info[$key] == ''))
                    $error = 1;
                if ((php72_cmp($donor[$key]) == 0 && $other_donor[$key] == '') || $grant_list[$key] == '' || (php72_cmp($budget_head[$key]) == 0 && $other_budget_head[$key] == '') || (php72_cmp($line_item[$key]) == 0 && $other_line_item[$key] == ''))
                    $error = 1;
            endforeach;
            /* server side validation */
            foreach ($donor as $dondetails => $value) {
                $prog = $this->input->post('programme');
                $don = $donor[$dondetails];
                $bh = $budget_head[$dondetails];
                $li = $line_item[$dondetails];
                $additional_info = $additional_info[$dondetails];
                $amount_req = $amt_required[$dondetails];
                $grant_ids = $grant_list[$dondetails];
                $avail_amt = $this->amountAvailableforssval($prog, $don, $bh, $li, '', $grant_ids);
				if ((string)round($avail_amt) < (string)$amount_req){
					$error = 2;
				}
                   
            }

            $this->form_validation->set_rules('date_of_seeking_approval', 'Date of Seeking Approval', 'required');
            $this->form_validation->set_rules('programme', 'Programme', 'required');
            $this->form_validation->set_rules('to_RO', 'Reporting Officer', 'required');  // added on 2/7/14 for multiple ro concept
            if ($this->form_validation->run() != FALSE && $error == 0) {

                $grnat_status_error = 'Yes';
                if (!empty($grant_list)) {
                    foreach ($grant_list as $grantID) {
                        if ($grantID != '') {
                            #$this->current_db = $this->load->database('mis', true);
                            $db_var = $this->db;
                            $fields = array('id', 'name', 'status_type');
                            $condition = array('id' => $grantID, 'status_type' => 'open');
                            $db_var->select($fields);
                            $db_var->where($condition);
                            $query = $db_var->get('grant_list');
                            $get_results = $query->result();
                            if (empty($get_results)) {
                                $grnat_status_error = 'No';
                            }
                        }
                    }
                }
                if ($grnat_status_error == 'Yes') {
					
					
                    $id = $this->Mapproval->insertApprovalNote();
					
					$sendMail = $this->approvalRequestMail($id);
					
					#AN Assign User
					
					#Update PH status to confirmed when the amount is lessthan 50000
					
					$amount = 0;
					$amt_required_str = str_replace(',', '',$this->input->post('amt_required'));
					foreach ($amt_required_str as $key => $value):
						$amount += $value;
					endforeach;
			
					$this->ais = $this->load->database('ais', TRUE);			
					$this->ais->select('MP.programme_id,MP.an_assign_user');
					$this->ais->where('MP.programme_id', $this->input->post('programme'),);
					$this->ais->where('MP.partner_id', $this->session->userdata('partner_id'));
					$queryMasterProgram = $this->ais->get('master_programme MP');
					$getMasterProgram = $queryMasterProgram->result();
					$assigned_user ='';
					if(!empty($getMasterProgram)){
						if ($this->session->userdata('currency') == 'INR' && $amount <= 50000 ) {
							$this->Mapproval->updatePHStatus($id);
						}
					}else{
						$this->db->select('below_three_lakhs,above_three_lakhs,above_ten_lakhs');
						$query = $this->db->get('an_assign_user');
						$get_an_assign_user = $query->result_array();
						if ($this->session->userdata('currency') == 'INR' && $amount <=50000) { 
							$this->Mapproval->updatePHStatus($id);
						}
					}
					#AN Assign User
					
					
                    $this->session->set_flashdata('successMsg', 'Approval Note Added Successfully!');

                    if ($travel == 'travel') {
                        redirect('traveluser/after_approval/' . $id);
                    } else if ($this->input->post('service') == 'seedfunding') {
                        redirect('<?php echo host_url(); ?>vital/index.php/seedfunding/getinstallment/' . $this->input->post('innovation') . '/' . $this->input->post('installment') . '/approval/' . $id);
                    } else {
                        //redirect('approvaluser/approval_form');
                    }
                } else {
                    $data['errorMsg'] = "Choose another grant type";
                }
            } else if ($error == 2) {
                $data['errorMsg'] = "The amount required exceeds amount Available and it is not possible to enter higher amount";
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }
        }

        $grant_lists = $this->input->post('grant_list');
        $data['grant_list'] = $grant_lists;

        $data['approval_new'] = $this->Mapproval->approvalNumber();
        $data['RO'] = $this->Mapproval->reportingUser('supUser', 'All', $this->session->userdata('empNumber'));
        $data['donorList'] = $this->Mapproval->getMasterSetting('Donor');
        $data['budgetHeadList'] = $this->Mapproval->getMasterSetting('Budget Head');
        $data['costCentreList'] = $this->Mapproval->getMasterSetting('Cost Centre');
        $data['programmeList'] = $this->Mapproval->getBalanceProgramme();
        $data['cpagetitle'] = "New Approval Note ";
        $data['cpage'] = "approval/user/approvalForm";
        redirect('approval/approval_note/all_pending');
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
	
	function approvalRequestMail_test($id = '') {
		$id ='13882';
        $approvalNoteDetails = $this->Mapproval->getApprovalNote($id);

        /* ---------Auto approving RO status when submitting approval note------------ */
        #$this->Mapproval->actionApproveRO('approve', $id);

        if ($approvalNoteDetails['0']['above_50000'] != 'yes') {
            if ($approvalNoteDetails['0']['programme_head'] == $approvalNoteDetails['0']['from_employee']) {
                #$this->Mapproval->actionApprovePHEnd('approve', $id);
                $toName = array('employee', 'ph', 'reportAuthEmail');
                $toEm = array('employeeEmail', 'phEmail', 'reportAuthEmail');
            } else {
                $toName = array('employee', 'ph', 'reportAuthEmail');
                $toEm = array('employeeEmail', 'phEmail', 'reportAuthEmail');
            }
        } else {
            if ($approvalNoteDetails['0']['programme_head'] == $approvalNoteDetails['0']['from_employee']) {
                #$this->Mapproval->actionApprovePH('approve', $id);
                $toName = array('employee', 'ph', 'ceo', 'reportAuthEmail');
                $toEm = array('employeeEmail', 'phEmail', 'ceoEmail', 'reportAuthEmail');
            } else {
                $toName = array('employee', 'ph', 'reportAuthEmail');
                $toEm = array('employeeEmail', 'phEmail', 'reportAuthEmail');
            }
        }
		
        foreach ($toName as $key => $value) {
			#echo'<pre>';print_r($toName);
			
            $mailContent = $this->Mapproval->mailContent($id, $value);
			echo'<pre>';print_r($mailContent);
			/* if($this->session->userdata('emp_number') == '275') {
				
				$this->sendMailPhpMailer_AN($mailContent['employeeEmail'], $mailContent[$toEm[$key]], 'Approval Note Request by Employee', $mailContent, $mailContent['attach']);		
			}else{
				sendMail($mailContent['employeeEmail'], $mailContent[$toEm[$key]], 'Approval Note Request by Employee', $mailContent, $mailContent['attach']);
			} */
			#$this->sendMailPhpMailer_AN($mailContent['employeeEmail'], $mailContent[$toEm[$key]], 'Approval Note Request by Employee', $mailContent, $mailContent['attach']);		
        }
		die;
    }
	
    function approvalRequestMail($id = '') {
        $approvalNoteDetails = $this->Mapproval->getApprovalNote($id);

        /* ---------Auto approving RO status when submitting approval note------------ */
        #$this->Mapproval->actionApproveRO('approve', $id);

        if ($approvalNoteDetails['0']['above_50000'] != 'yes') {
            if ($approvalNoteDetails['0']['programme_head'] == $approvalNoteDetails['0']['from_employee']) {
               # $this->Mapproval->actionApprovePHEnd('approve', $id);
                $toName = array('employee', 'ph', 'reportAuthEmail');
                $toEm = array('employeeEmail','reportAuthEmail');
            } else {
                $toName = array('employee', 'ph', 'reportAuthEmail');
                $toEm = array('employeeEmail','reportAuthEmail');
            }
        } else {
            if ($approvalNoteDetails['0']['programme_head'] == $approvalNoteDetails['0']['from_employee']) {
                #$this->Mapproval->actionApprovePH('approve', $id);
                $toName = array('employee', 'ph', 'ceo', 'reportAuthEmail');
                $toEm = array('employeeEmail','ceoEmail', 'reportAuthEmail');
            } else {
                $toName = array('employee', 'ph', 'reportAuthEmail');
                $toEm = array('employeeEmail', 'reportAuthEmail');
            }
        }

        foreach ($toName as $key => $value) {
            $mailContent = $this->Mapproval->mailContent($id, $value);
			/* if($this->session->userdata('emp_number') == '275') {
				$this->sendMailPhpMailer_AN($mailContent['employeeEmail'], $mailContent[$toEm[$key]], 'Approval Note Request by Employee', $mailContent, $mailContent['attach']);		
			}else{
				sendMail($mailContent['employeeEmail'], $mailContent[$toEm[$key]], 'Approval Note Request by Employee', $mailContent, $mailContent['attach']);
			} */
			$this->sendMailPhpMailer_AN($mailContent['employeeEmail'], $mailContent[$toEm[$key]], 'Approval Note Request by Employee', $mailContent, $mailContent['attach']);		
        }
    }

    public function getDonorNameList() {
        $program_id = $this->input->post('program');
        $data = $this->Mapproval->getDonorList($program_id);
        echo json_encode($data);
    }
	
	
	
	public function getAnRequester() {
		
			$program_id = $this->input->post('program');
			$data['an_request_user_status'] = '0';
			if($program_id!=''){
				 $programme_details = $this->Mmaster->getProgrammeDetails($program_id);
				
				$user_id = $this->session->userdata('user_id');
				$branch = $this->session->userdata('partner_id');
				$this->load->model('user/Common_model');
				$users = $this->Common_model->getUsersList_sa($branch);
				$default = $this->Common_model->getUserSetup($branch);
				
				
				 # echo'<pre>';print_r($this->session->all_userdata());die;
				 if(!empty($programme_details)){
					if($programme_details[0]['an_request_sector']!=''){
						$this->load->model('scouting/Mincharge'); 
						$anUser = $this->Mincharge->getAnSectorUser($programme_details[0]['an_request_sector']);
						 
						if(!empty($anUser)){
							$data['an_request_user_status'] = '1';
						}
					}
				 }
				 if(!empty($default)){
					if(!empty($default['non_sector_user'])){
						if (php72_in_array($user_id, $default['non_sector_user'])) {
							$data['an_request_user_status'] = '1';
						}
					}
				}
				
			}
			 echo json_encode($data);
			 
	}
	

    public function getGrantNameList() {
       /*  $donor_id = $this->input->post('donor');
        $data = $this->Mapproval->getGrantList($donor_id);
        echo json_encode($data); */
		
		$donor_id = $this->input->post('donor');
		$program = $this->input->post('program');
        $data = $this->Mapproval->getGrantList($donor_id);
		
		$get_grantIds =array();
		if($program!=''){
			if(!empty($data)){ 
				$get_grantIds =php72_array_column($data,'id');
				$checkdata = $this->Mapproval->checkGrantList_balanceamt($donor_id,$get_grantIds,$program);
				$data = $checkdata;
			}
		}
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

    function check_calucalations_old() {
        if (!empty($_REQUEST)) {
            $count = php72_count($_REQUEST["donor"]);
            $return = array();
            for ($i = 0; $i < $count; $i++) {
                if ($_REQUEST["donor"][$i] != "" && $_REQUEST["budgethead"][$i] != "" && $_REQUEST["lineitem"][$i] != "") {
                    if (isset($_REQUEST["edit"]) && $_REQUEST["edit"] != '') {
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

    function check_calucalations() {
        if (!empty($_REQUEST)) {
            $count = php72_count($_REQUEST["donor"]);
            $return = array();

            for ($i = 0; $i < $count; $i++) {
                if ($_REQUEST["donor"][$i] != "" && $_REQUEST["budgethead"][$i] != "" && $_REQUEST["lineitem"][$i] != "") {
                    if (isset($_REQUEST["edit"]) && $_REQUEST["edit"] != '') {

                        $pre = $this->PreCheckExist($_REQUEST);
                        $check = $this->CheckExist($return, $_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i]);
                        $inam = $this->Mapproval->tot_amt_in($_REQUEST['id'], $_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i], $_REQUEST['detail'][$i]);
                        $return[$i]["donor"] = $_REQUEST["donor"][$i];
                        $return[$i]["budgethead"] = $_REQUEST["budgethead"][$i];
                        $return[$i]["lineitem"] = $_REQUEST["lineitem"][$i];
                        $return[$i]["amtavailable"] = $gran_wise_amount = $this->getaval_amount($_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i], $_REQUEST["progid"], $check, $pre, $_REQUEST["grant_list"][$i]);
                        $amtreq = str_replace(',', '', $_REQUEST["amtreq"][$i]);

                        $return[$i]["amtreq"] = str_replace(',', '', $_REQUEST["amtreq"][$i]);

                        if (php72_cmp($inam) != 0 && !empty($inam)) {
                            if ($amtreq < $inam[$i]['amount_toapprove']) {
                                $amtreq = 0;
                            }
                        }
                        if ($amtreq > $return[$i]['amtavailable']) {
                            $amtreq = 0;
                        }if ((!is_numeric($amtreq) || (php72_cmp($amtreq) < 0)) && !empty($amtreq)) {
                            $amtreq = 0;
                        }
                        $return[$i]['amtreq'] = formatnumber($amtreq);
                        $return[$i]['amtavailable'] = formatnumber($return[$i]["amtavailable"]);
                    } else {
                        #echo'<pre>';print_r($_POST);
                        $check = $this->CheckExist($return, $_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i]);
                        #echo $check;echo'==';
                        $return[$i]["donor"] = $_REQUEST["donor"][$i];
                        $return[$i]["budgethead"] = $_REQUEST["budgethead"][$i];
                        $return[$i]["lineitem"] = $_REQUEST["lineitem"][$i];
                        $return[$i]["amtavailable"] = $this->getaval_amount($_REQUEST["donor"][$i], $_REQUEST["budgethead"][$i], $_REQUEST["lineitem"][$i], $_REQUEST["progid"], $check, '', $_REQUEST["grant_list"][$i]);
                        $amtreq = str_replace(',', '', $_REQUEST["amtreq"][$i]);
                        if ($amtreq > $return[$i]['amtavailable']) {
                            $amtreq = 0;
                        }
                        if ((!is_numeric($amtreq) || (php72_cmp(amtreq) < 0)) && !empty($amtreq)) {
                            $amtreq = 0;
                        }
                        $return[$i]['amtreq'] = formatnumber($amtreq);
                        $return[$i]['amtavailable'] = formatnumber($return[$i]["amtavailable"]);
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
                    $return = $return + php72_num(str_replace(',', '', $data[$i]["amtreq"]));
                }
            }
        }
        return $return;
    }

    function getReqAmt($v = '', $d = '', $b = '', $l = '', $id = '') {
        $this->ais = $this->load->database('ais', TRUE);
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

	function test_ph_mail() { 
		$id='11404';
		$approvalNoteDetails = $this->Mapproval->getApprovalNote($id);
        $ceo = $this->Mapproval->getCeo();
        $employeeDetails = $this->Mapproval->getEmployeeFromUserId($approvalNoteDetails['0']['from_employee']);
        #$employeeDetails = $this->Mapproval->getEmployeeFromUserId('23');
		
        $RO_user = $this->Mapproval->reportingUser('supUser', 'All', $employeeDetails['0']['id']);
        if ($RO_user['0']['id'] == $ceo || $approvalNoteDetails['0']['programme_head'] == $ceo) {
            $this->ceo($option, $id);
        }
        if ($approvalNoteDetails['0']['above_50000'] == 'yes' || $approvalNoteDetails['0']['estimated_in_workplan'] == 'no') {
            $toName = array('employee', 'ceo');
            $toEmailceo = array('employeeEmail', 'ceoEmail');
        } else {
            $approve_from = "Programhead";
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $this->Mapproval->actionApproveNote($option, $id, $ipaddress, $approve_from);
            if ($option == 'defer') {
                $emp = $this->Mapproval->getEmployeeName($approvalNoteDetails[0]['from_employee']);
                $ro = $this->Mapproval->getEmployeeName($approvalNoteDetails[0]['to_RO']);
                if ($_POST['employee'] == $ro) {
                    $toName = 'To';
                    $toEmail = 'reportAuthEmail';
                } else {
                    $toName = array('employee', 'To', 'ph');
                    $toEmail = array('employeeEmail', 'reportAuthEmail', 'phEmail');
                }
            } else {
                $toName = array('employee', 'To', 'ph');
                $toEmail = array('employeeEmail', 'reportAuthEmail', 'phEmail');
            }
        }
		 $tmplate = 'Approval Note Confirmed by PH';
		//$toName = array('To');
		
        foreach ($toName as $key => $value) {
            $mailContent = $this->Mapproval->mailContent_test($id, $value);
            $to = $mailContent[$toEmail[$key]];
			
			//echo'<pre>';print_r($mailContent);
            if ($toEmail[$key] != 'employeeEmail') {
               array_push($to, $mailContent['employeeEmail']); //employee added in to address
            }

            if (isset($toEmailceo) && $approvalNoteDetails[0]['CEO_status'] == 'pending') {
               $to = $mailContent[$toEmailceo[$key]]; //ceo added in to address
            }
			//die;
			
            $this->Mapproval->sendMailPhpMailer_test($mailContent['phEmail'], $to, $tmplate, $mailContent, $mailContent['attach']);
			
        }
		die;
		
		
	}
    function ph() {
		
        $approval_id = $id = $this->input->post('approval_id');
        $status = $currentTab = $this->input->post('status');
        $section = $this->input->post('section');
        $comments_PH = $this->input->post('comments_PH');
        $option = $this->input->post('option');

        if (isset($_POST)) {
            $approvalid = $id;
            $message = $option;
            $this->Mapproval->inserttodb($approvalid, $message);
        }
        $this->Mapproval->actionApprovePH($option, $id);
        $this->Mapproval->approval_confirmed($approvalid);
        switch ($option) {
            case "approve":
                $tmplate = 'Approval Note Confirmed by PH';
                break;
            case "disapprove":
                $tmplate = 'Approval Note Rejected by PH';
                break;
            default:
                $tmplate = 'Approval Note Deferred by PH';
        }
		
		if($option == 'approve'){
			$emp_id = $this->session->userdata('emp_number');
			$this->ais = $this->load->database('ais', TRUE);					
			$this->ais->set('ph_approved_user', $emp_id);
			$this->ais->where('approval_id', $id);
			$this->ais->update('approval_note');
		}
		
		
		
        $approvalNoteDetails = $this->Mapproval->getApprovalNote($id);
        $ceo = $this->Mapproval->getCeo();
        $employeeDetails = $this->Mapproval->getEmployeeFromUserId($approvalNoteDetails['0']['from_employee']);
        #$employeeDetails = $this->Mapproval->getEmployeeFromUserId('23');
        $RO_user = $this->Mapproval->reportingUser('supUser', 'All', $employeeDetails['0']['id']);
        if ($RO_user['0']['id'] == $ceo || $approvalNoteDetails['0']['programme_head'] == $ceo) {
            $this->ceo($option, $id);
        }
        if ($approvalNoteDetails['0']['above_50000'] == 'yes' || $approvalNoteDetails['0']['estimated_in_workplan'] == 'no') {
            $toName = array('employee', 'ceo');
            $toEmailceo = array('employeeEmail', 'ceoEmail');
        } else {
            $approve_from = "Programhead";
            $ipaddress = $_SERVER['REMOTE_ADDR'];
            $this->Mapproval->actionApproveNote($option, $id, $ipaddress, $approve_from);
            if ($option == 'defer') {
                $emp = $this->Mapproval->getEmployeeName($approvalNoteDetails[0]['from_employee']);
                $ro = $this->Mapproval->getEmployeeName($approvalNoteDetails[0]['to_RO']);
                if ($_POST['employee'] == $ro) {
                    $toName = 'To';
                    $toEmail = 'reportAuthEmail';
                } else {
                    $toName = array('employee', 'To', 'ph');
                    $toEmail = array('employeeEmail', 'reportAuthEmail');
                }
            } else {
                $toName = array('employee', 'To', 'ph');
                $toEmail = array('employeeEmail', 'reportAuthEmail');
            }
        }
        foreach ($toName as $key => $value) {
            $mailContent = $this->Mapproval->mailContent($id, $value);
            $to = $mailContent[$toEmail[$key]];
            if ($toEmail[$key] != 'employeeEmail') {
                array_push($to, $mailContent['employeeEmail']); //employee added in to address
            }

            if (isset($toEmailceo) && $approvalNoteDetails[0]['CEO_status'] == 'pending') {
                $to = $mailContent[$toEmailceo[$key]]; //ceo added in to address
            }
            $this->Mapproval->sendMailPhpMailer($mailContent['phEmail'], $to, $tmplate, $mailContent, $mailContent['attach']);
        }
        switch ($option) {
            case "approve":
                $succ = 'Approval Note Confirmed';
                break;
            case "disapprove":
                $succ = 'Approval Note Rejected';
                break;
            default:
                $succ = 'Approval Note Deferred';
        }
        $this->session->set_flashdata('successMsg', $succ);
        redirect('approval/approval_note_details/' . $id . '/' . $section);
        echo json_encode($json_data);
		
		
    }

    function ceo($option = '', $id = '', $section = 'mylist') {
        $approval_id = $id = $this->input->post('approval_id');
        $status = $currentTab = $this->input->post('status');
        $section = $this->input->post('section');
        $comments_PH = $this->input->post('comments_PH');
        $option = $this->input->post('option');

        if (isset($_POST)) {
            $approvalid = $approval_id;
            $message = $option;
            $this->Mapproval->inserttodb($approvalid, $message);
        }
        $approve_from = "Ceohead";
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        $approvalNoteDetails = $this->Mapproval->getApprovalNote($approvalid);

        if ($approvalNoteDetails['0']['programme_head'] == $approvalNoteDetails['0']['from_employee'] && $option == 'approve' && $approvalNoteDetails['0']['PH_status'] == 'pending') {
            $this->Mapproval->actionApprovePH($option, $id);
        }
        $this->Mapproval->actionApproveCEO($option, $id, $ipaddress, $approve_from);
        $this->Mapproval->approval_confirmed($approvalid);

        if ($option == 'defer') {
            $emp = $this->Mapproval->getUserInfo($approvalNoteDetails[0]['from_employee']);
            $ro = $this->Mapproval->getUserInfo($approvalNoteDetails[0]['to_RO']);
            $ph = $this->Mapproval->getUserInfo($approvalNoteDetails[0]['programme_head']);

            if ($_POST['employee'] == $ro) {
                $toName = 'To';
                $toEmail = 'reportAuthEmail';
                $name = $_POST['employee'];
            } else if ($_POST['employee'] == 'programme_head') {
                $toName = 'ph';
                $toEmail = 'phEmail';
                $name = $this->Mapproval->getUserInfo($approvalNoteDetails[0]['programme_head']);
            } else {
                $toName = array('employee', 'To', 'ph', 'ceo');
                $toEmail = array('employeeEmail', 'reportAuthEmail', 'phEmail', 'ceoEmail');
            }
        } else {
            $toName = array('employee', 'To', 'ph', 'ceo');
            $toEmail = array('employeeEmail', 'reportAuthEmail', 'phEmail', 'ceoEmail');
        }
        switch ($option) {
            case "approve":
                $tmplate = 'Approval Note Confirmed by CEO';
                break;
            case "disapprove":
                $tmplate = 'Approval Note Rejected by CEO';
                break;
            default:
                $tmplate = 'Approval Note Deferred by CEO';
        }
        foreach ($toName as $key => $value) {
            $mailContent = $this->Mapproval->mailContent($id, $value);
            $to = $mailContent[$toEmail[$key]];
            if ($toEmail[$key] != 'employeeEmail') {
                $to = array($mailContent[$toEmail[$key]], $mailContent[$key]); //employee added in to address
            }
            if ($toEmail[$key] == 'employeeEmail') {
                $this->Mapproval->sendMailPhpMailer($mailContent['ceoEmail'], $to, $tmplate, $mailContent, $mailContent['attach']);
            }
        }
        if ($option == 'approve' && $approvalNoteDetails['0']['PH_status'] == 'pending') {
            $mailContent = $this->Mapproval->mailContent($id, 'ph');
            $tmplate = 'Approval Note Confirmed by RO';
            $toEmail = 'phEmail';
            $to = array($mailContent[$toEmail]);
            $this->sendMailPhpMailer_AN($mailContent['ceoEmail'], $to, $tmplate, $mailContent, $mailContent['attach']);
        }
        switch ($option) {
            case "approve":
                $succ = 'Approval Note Confirmed';
                break;
            case "disapprove":
                $succ = 'Approval Note Rejected';
                break;
            default:
                $succ = 'Approval Note Deferred';
        }
		
		if($option == 'approve'){
			$emp_id = $this->session->userdata('emp_number');
			$this->ais = $this->load->database('ais', TRUE);					
			$this->ais->set('ceo_approved_user', $emp_id);
			$this->ais->where('approval_id', $id);
			$this->ais->update('approval_note');
		}
		
        $this->session->set_flashdata('successMsg', $succ);
        redirect('approval/approval_note_details/' . $id . '/' . $section);
    }

    function ro() {
        $approval_id = $id = $this->input->post('approval_id');
        $status = $currentTab = $this->input->post('status');
        $section = $this->input->post('section');
        $comments_PH = $this->input->post('comments_PH');
        $option = $this->input->post('option');

        $this->Mapproval->actionApproveRO($option, $id);
        switch ($option) {
            case "approve":
                $tmplate = 'Approval Note Confirmed by RO';
                break;
            case "disapprove":
                $tmplate = 'Approval Note Rejected by RO';
                break;
            default:
                $tmplate = 'Approval Note Deferred by RO';
        }

        $approvalNoteDetails = $this->Mapproval->getApprovalNote($id);
		
		#AN assign User
		if(($approvalNoteDetails[0]['RO_status']=='pending' || $approvalNoteDetails[0]['RO_status']=='confirmed') && $approvalNoteDetails[0]['PH_status']=='confirmed'){
			$this->ais = $this->load->database('ais', TRUE);					
			$this->ais->set('status', 'confirmed');
			$this->ais->where('approval_id', $id);
			$this->ais->update('approval_note');
		}
		#AN assign User
		
		if($option == 'approve'){
			$emp_id = $this->session->userdata('emp_number');
			$this->ais = $this->load->database('ais', TRUE);					
			$this->ais->set('ro_approved_user', $emp_id);
			$this->ais->where('approval_id', $id);
			$this->ais->update('approval_note');
		}
		
		
        $employeeDetails = $this->Mapproval->getEmployeeFromUserId($approvalNoteDetails['0']['from_employee']);
        #$employeeDetails = $this->Mapproval->getEmployeeFromUserId('23');
        $RO_user = $this->Mapproval->reportingUser('supUser', 'All', $employeeDetails['0']['id']);
        $ceo = $this->Mapproval->getCeo();
        foreach ($RO_user as $ro) {
            $rolist[] = $ro['id'];
        }
		
		$toName = 'employee';
        $toEmail = 'employeeEmail';
        /* if (($approvalNoteDetails['0']['programme_head'] == $RO_user['0']['id']) || (in_array($approvalNoteDetails['0']['programme_head'], $rolist))) {
            if (isset($_POST)) {
                $approvalid = $id;
                $message = $option;
                $this->Mapproval->inserttodb($approvalid, $message);
            }

            switch ($option) {
                case "approve":
                    $tmplate = 'Approval Note Confirmed by PH';
                    break;
                case "disapprove":
                    $tmplate = 'Approval Note Rejected by PH';
                    break;
                default:
                    $tmplate = 'Approval Note Deferred by PH';
            }

            $toName = 'employee';
            $toEmail = 'employeeEmail';
            $_POST['comments_PH'] = $this->input->post('comments_RO');
            $this->Mapproval->actionApprovePH($option, $id);


            if ($approvalNoteDetails['0']['above_50000'] == 'yes' || $approvalNoteDetails['0']['estimated_in_workplan'] == 'no') {
                $toName = 'ceo';
                $toEmail = 'ceoEmail';
            } else {
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $approve_from = "Report&Programhead";
                $this->Mapproval->actionApproveNote($option, $id, $ipaddress, $approve_from);
                $toName = 'employee';
                $toEmail = 'employeeEmail';
            }
        } */
        /* if ($approvalNoteDetails['0']['programme_head'] == $approvalNoteDetails['0']['from_employee'] && $option == 'approve') {
            $this->Mapproval->actionApprovePH($option, $id);
           
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $approve_from = "Report&Programhead";
                $this->Mapproval->actionApproveNote($option, $id, $ipaddress, $approve_from);
                $toName = 'employee';
                $toEmail = 'employeeEmail';
            
        } */

        if (isset($_POST)) {
            $approvalid = $id;
            $message = $option;
            $this->Mapproval->inserttodb($approvalid, $message);
        }

        if ($option == 'defer') {
            $toName = 'from_employee';
            $toEmail = 'employeeEmail';
        } else if (($approvalNoteDetails['0']['programme_head'] != $RO_user['0']['id'] || !php72_in_array($approvalNoteDetails['0']['programme_head'], $rolist)) && $approvalNoteDetails['0']['programme_head'] != $approvalNoteDetails['0']['from_employee']) {
            $toName = 'ph';
            $toEmail = 'phEmail';
        }
        $deferedby = $mailContent['replace'][19];

        $mailContent = $this->Mapproval->mailContent($id, $toName);
        $to = array($mailContent[$toEmail]);
        if ($toEmail != 'employeeEmail') {
            array_push($to, $mailContent['employeeEmail']); //employee included in mail process
        }
		if($approvalNoteDetails[0]['RO_status']=='confirmed' && $approvalNoteDetails[0]['PH_status'] =='pending'){ 
			array_push($to, $mailContent['phEmail']); 
		} 
		
		

        $comments = $mailContent['replace'][9];
        $this->sendMailPhpMailer_AN($mailContent['reportAuthEmail'], $to, $tmplate, $mailContent, $mailContent['attach']);

        switch ($option) {
            case "approve":
                $succ = 'Approval Note Confirmed';
                break;
            case "disapprove":
                $succ = 'Approval Note Rejected';
                break;
            default:
                $succ = 'Approval Note Deferred';
        }
        $this->session->set_flashdata('successMsg', $succ);
        redirect('approval/approval_note_details/' . $approval_id);
    }

    function sendMail($from = NULL, $to = array(), $tamplate = NULL, $mailContant = NULL, $attach = NULL, $ccEmail = NULL) {
        $mailTemplate = $this->Mapproval->getMailTemplate($tamplate);
        $messageSubject = $mailTemplate['0']['messagesubject'];
        $messageBody = str_replace($mailContant['org'], $mailContant['replace'], $mailTemplate['0']['messagebody']);
        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->from('mis@mis.villgroapps.org', 'Admin');
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
	function sendMailPhpMailer_AN($from = NULL, $to = array(), $tamplate = NULL, $mailContant = NULL, $attach = NULL, $ccEmail = NULL) { 
        $mailTemplate = $this->Mapproval->getMailTemplate($tamplate);
		
        $messageSubject = $mailTemplate['0']['messagesubject'];
        $messageBody = str_replace($mailContant['org'], $mailContant['replace'], $mailTemplate['0']['messagebody']);
        /* $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->from('mis@mis.villgroapps.org', 'Admin');
        $this->email->to($to);

        if (!empty($attach)) {
            foreach ($attach as $key => $value):
                $this->email->attach($value);
            endforeach;
        }
        $this->email->subject($messageSubject);
        $this->email->message($messageBody);
        $this->email->send(); 
		
        return true; */
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

    function send_approval_note($id = NULL) {
        $data = $this->Mapproval->send_approval_note($id);
        if ($data) {
            $this->session->set_flashdata('successMsg', 'Approval Note sent Successfully!');
            redirect('approval/approval_note/pending');
        } else {
            redirect('approval/approval_note/draft');
        }
    }

}
?>