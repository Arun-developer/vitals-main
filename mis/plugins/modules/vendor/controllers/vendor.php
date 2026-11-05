<?php

class Vendor extends CI_Controller {

function __construct() {

	#error_reporting(-1);
	parent::__construct();
	$this->Mauth->isLoggedCheck();
	$this->load->model('vendor/vendor_model');
	
}

function vendor_list() {
	
	#echo'<pre>';print_r($this->session->all_userdata());die;
	$user_id = $this->session->userdata('emp_number');
	$role_id = $this->session->userdata('role_id');
	$partner_id = $this->session->userdata('partner_id');
	$conditionFinance = array('partner_id'=>$partner_id);
	$getFinanceUser = $this->vendor_model->get_all_details('approval_setting', $conditionFinance, array('finance'), '', '', '', true, 'ais');
	$data['user_status'] ='';
	if(!empty($getFinanceUser)){
		if(in_array($role_id, array(1,2,3))){
			$data['user_status'] ='1';
		}
		$financeUserId = unserialize($getFinanceUser[0]->finance);
		if(!empty($financeUserId)){
			if(in_array($user_id, $financeUserId)){
				$data['user_status'] ='2';
			}
		}
	}
	
	$condition['status'] = 1;
	$data['search_value'] = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';
	$getVendorArray = $this->vendor_model->get_all_details('vendor', $condition,'', '', '', '');
	#echo'<pre>';print_r($getVendorArray);die;
	$this->load->vars($data);
	$this->load->view('vendor_list');
}


function addEdit_vendor() {
	$partner_id = $this->session->userdata('partner_id');
	#$this->ais = $this->load->database('ais', true);
	$conditionFinance = array('partner_id'=>$partner_id);
	$getFinanceUser = $this->vendor_model->get_all_details('approval_setting', $conditionFinance, array('finance'), '', '', '', true, 'ais');
	$data['finance_user_lists'] = array();
	if(!empty($getFinanceUser)){
		$financeUserId = unserialize($getFinanceUser[0]->finance);
		if(!empty($financeUserId)){
			$data['finance_user_lists'] = $this->vendor_model->getFinanceUsersList($partner_id, $financeUserId);
		}
	}
	$getVendorId = $this->uri->segment(3); 
	$data['search_value'] = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';
	$data['vendorId'] = $getVendorId;
	$data['vendorDetails'] = array();
	if($getVendorId!=''){
		$condition['id'] = $getVendorId;
		$getVnedor = $this->vendor_model->get_all_details('vendor', $condition,'', '', '', '');
		if(!empty($getVnedor)){
			$data['vendorDetails'] = $getVnedor[0];
		}
	}
	
	
	$user_id = $this->session->userdata('emp_number');
	$role_id = $this->session->userdata('role_id');
	$data['user_status'] ='';
	if(!empty($getFinanceUser)){
		if(in_array($role_id, array(1,2,3))){
			$data['user_status'] ='1';
		}
		$financeUserId = unserialize($getFinanceUser[0]->finance);
		if(!empty($financeUserId)){
			if(in_array($user_id, $financeUserId)){
				$data['user_status'] ='1';
			}
		}
	}
	if($this->session->userdata('emp_number')==575){
		$data['user_status'] ='2';
	}
	
	
	$this->load->vars($data);
	$this->load->view('vendor_bank_details');
}



public function DT_vendor() {
	
		$user_id = $this->session->userdata('emp_number');
		$role_id = $this->session->userdata('role_id');
		$partner_id = $this->session->userdata('partner_id');
		$conditionFinance = array('partner_id'=>$partner_id);
		$getFinanceUser = $this->vendor_model->get_all_details('approval_setting', $conditionFinance, array('finance'), '', '', '', true, 'ais');
		$data['user_status'] ='';
		$cond ='';
		
		if(!empty($getFinanceUser)){
			if(in_array($role_id, array(1,2,3))){
				$cond = " AND v1.created_user_id = ".$user_id."";
			}
			$financeUserId = unserialize($getFinanceUser[0]->finance);
			if(!empty($financeUserId)){
				if(in_array($user_id, $financeUserId)){
					$cond = " AND v1.finance_user_id = ".$user_id."";
				}
			}
		}
		
		if(isset($user_id) && $user_id!=''){
			if($user_id==575){
				$cond = " AND v1.finance_user_id = ".$user_id."";
			}else{
				if(in_array($role_id, array(1,2,3))){
					$cond = " AND v1.created_user_id = ".$user_id."";
				}
			}
		}
		
        $requestData = $_POST;
		$columns = array(
				0 => 'id',
				1 => 'name',
				2 => 'address',
				3 => 'pan',
				4 => 'gst_number',
				5 => 'msme_registered',
				6 => 'status',
			);
			if($this->session->userdata('emp_number')==575){
				$columns = array(
					0 => 'id',
					1 => 'name',
					1 => 'created_user_id',
					2 => 'address',
					3 => 'pan',
					4 => 'gst_number',
					5 => 'msme_registered',
					6 => 'status',
				);
			}
        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['search_value'] = $search_value = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';
        $data['current_user'] = $current_user = (isset($_POST['current_user'])) ? $_POST['current_user'] : '';
		
		$totalrows = $this->vendor_model->getDTVendorCount($search_field, $search_value, $current_user, $columns, $requestData,$cond);
		$query = $this->vendor_model->getDTVendorDetails($requestData['length'], $requestData['start'], $search_field, $search_value, $current_user, $columns, $requestData,$cond);
		
		$totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = $report_to = array();
            $nestedData[] = '<input type="checkbox" class="chk_box" id="emp_chk_box" name="employee_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['name'];
			if($this->session->userdata('emp_number')==575){
				$getUserData = $this->vendor_model->get_all_details('hr_user_profile', array('id'=>$row['created_user_id']), array('official_email','emp_name'), '', '', '');
				$nestedData[] =  $getUserData[0]->emp_name;
			}
            $nestedData[] =   wordwrap($row['address'], 40, "<br>\n");
			$nestedData[] =  $row['pan'];
			$nestedData[] =  $row['gst_number'];
			$nestedData[] =  $row['msme_registered'];
			$status = '';
			if($row['status']==1){
				$status = 'Pending';
			}else if($row['status']==2){
				$status = 'Approved';
			}else if($row['status']==3){
				$status = 'Amend';
			}
			
			$nestedData[] =  $status;
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
	
	public function deleteVendor() {
        $id = $this->input->post('id');
        $condition = "'" . implode("', '", $id) . "'";
        $table = $_POST['table'];
        $query = $this->vendor_model->deleteVendorDetail($table, $condition);
		$this->vendor_model->deleteVendorBankDetail('vendor_bank_details', $condition);

        if ($query) {
            echo '1';
            $this->session->set_flashdata('successMsg', "Record(s) deleted successfully");
        } else {
            echo '0';
        }
    }
	
	public function DTVendorBankDetails() {
        $search_field = $this->input->post('search_field');
        $vendorId = $this->input->post('vendorId');
        $requestData = $_POST;
        $data = array();
        $i = $requestData['start'] + 1;
	
		$columns = array('account_number','bank_name','branch_name','ifsc_code');

        $partner = ($this->session->userdata('user_type') == 'superadmin') ? $_POST['branch'] : $_POST['branch_name'];
		$orderby_sec = array($columns[$requestData['order'][0]['column']-1] => $requestData['order'][0]['dir']);
      
		$condition = array('vendor_id' =>  $vendorId );
		#echo'<pre>';print_r($_POST);die;
        $getBankDetails = $this->vendor_model->get_all_details('vendor_bank_details', $condition, array(), '', '', '');
        $count = count($getBankDetails);

        $start = $this->input->post('start');
        $limit = 10;
        $getVendor_details = $this->vendor_model->get_all_details('vendor_bank_details', $condition, array(), $limit, $start, $orderby_sec);

        $option_list = '';
        $orderby = '';
		$data = array();
        foreach ($getVendor_details as $lists) {
			
			$selected = '';
			$selected2 = '';
            if ($lists->status == 1) {
                $selected = 'selected';
            } else if ($lists->status == 2) {
                $selected2 = 'selected';
            }
            $condition = array('id' => $lists->partner_id);
            $nestedData = array();
            $nestedData[] = '<input type="hidden" name="master_edit_id[' . $i . ']" value="' . $lists->id . '" disabled><input class="form-control master_check" type="checkbox" name="master_check[' . $i . ']" value="' . $lists->id . '"> ';
            $nestedData[] = '<input class="form-control commonAlphaNum" type="text" value="' . $lists->account_number . '" name="account_number[' . $i . ']" disabled>';
			$nestedData[] = '<input class="form-control commonAlphaNum" type="text" value="' . $lists->bank_name . '" name="bank_name[' . $i . ']" disabled>';
			$nestedData[] = '<input class="form-control commonAlphaNum" type="text" value="' . $lists->branch_name . '" name="branch_name[' . $i . ']" disabled>';
			$nestedData[] = '<input class="form-control commonAlphaNum" type="text" value="' . $lists->ifsc_code . '" name="ifsc_code[' . $i . ']" disabled>';
         
            $nestedData[] = "";
            $data[] = $nestedData;
            $i++;
        }
		
			#echo'<pre>';print_r($data);die;
		
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval(count($getVendor_details)),
            "recordsFiltered" => intval($count),
            "data" => $data
        );
        echo json_encode($json_data);
    }
	
	public function insertEditVendorBank() {
		
		$vendor_id = $this->input->post('vendor_id');
		
		if(!empty($_FILES['meet_doc'])){
			$file_name = $_FILES['meet_doc']['name'];
			$file_tmp_name = $_FILES['meet_doc']['tmp_name'];
			foreach ($file_name as $key => $value):
				if ($value != '') {
					
					$rename_file = str_replace(' ', '_', strtolower($value));
					$new_name = preg_replace('/[^A-Za-z0-9.\_]/', '', $rename_file);
					$fName = date('Ymdhis') . '_' . $new_name;
					@copy($file_tmp_name[$key], "uploads/vendor_documents/" . $fName);
					$fNameArray[] = $fName;
				}
			endforeach;
			$hidfile_name = $this->input->post('exist_doc');
			foreach ($hidfile_name as $key => $value) {
				if ($value != '') {
					$fName = $value;
					$fNameArray[] = $fName;
				}
			}
		}
		
		$insertEditData['name'] = $this->input->post('vendorName');
		$insertEditData['address'] = trim($this->input->post('address'));
		$insertEditData['pan'] = $this->input->post('pan');
		$insertEditData['gst_status'] = $this->input->post('gst_status');
		$insertEditData['gst_number'] = $this->input->post('gst_number');
		$insertEditData['msme_status'] = $this->input->post('msme_status');
		$insertEditData['msme_registered'] = $this->input->post('msme_registered');
		$insertEditData['finance_user_id'] = 575;
		$insertEditData['created_user_id'] = $this->session->userdata('emp_number');
		$insertEditData['status'] = 1;
        if ($this->input->post('supporting_documents') != '') {
            $insertEditData['supporting_documents'] =  implode(', ', $this->input->post('supporting_documents'));
        }
		
		
		if(!empty($fNameArray)){
			$insertEditData['upload_invoice'] =  (serialize($fNameArray));
		}
		
		
		if(isset($vendor_id) && $vendor_id!=''){
			#update
			$condition = array('id'=>$vendor_id);
			$this->vendor_model->update_data('vendor', $condition, $insertEditData);
			$this->vendor_model->update_data('vendor_bank_details',array('vendor_id'=>$vendor_id), array('status'=>1));
		
		}else{
			#insert 
			
			$this->vendor_model->insert_data('vendor', $insertEditData);
			#ECHO'<pre>';print_r($insertEditData);die;
			$getLastInsertId = $this->db->insert_id();
		}
		
        $reason_edit_id = $this->input->post('master_edit_id');
        $account_number = $this->input->post('account_number');
		$bank_name = $this->input->post('bank_name');
		$branch_name = $this->input->post('branch_name');
		$ifsc_code = $this->input->post('ifsc_code');
        $status_data = 1;
        $updateData = $InsetData = array();
         if (!empty($account_number)) {
            $is_record = 0;
            foreach ($account_number as $id => $value) {
                $partner_id = $this->session->userdata('partner_id');
                if ($account_number[$id] != '') {
                    if ($account_number[$id] != '') {
                        if ($reason_edit_id[$id]) {
                            $condition = array('id' => $reason_edit_id[$id]);
                            $updateData = array('vendor_id'=>$vendor_id,'account_number' => $account_number[$id],'bank_name'=>$bank_name[$id],'branch_name'=>$branch_name[$id],'ifsc_code'=>$ifsc_code[$id], 'partner_id' => $partner_id, 'status' => $status_data, 'updated_date' => date('Y-m-d H:i:s'));
							$this->vendor_model->update_data('vendor_bank_details', $condition, $updateData);
                        } else {
							if($vendor_id!=''){
								$getLastInsertId = $vendor_id;
							}
                            $InsetData = array('vendor_id'=>$getLastInsertId,'account_number' => $account_number[$id],'bank_name'=>$bank_name[$id],'branch_name'=>$branch_name[$id],'ifsc_code'=>$ifsc_code[$id], 'partner_id' => $partner_id, 'status' => $status_data, 'created_date' => date('Y-m-d H:i:s'));
							$this->vendor_model->insert_data('vendor_bank_details', $InsetData);
                        }
                    }
                    $is_record++;
                }
            }
            if ($is_record > 0) {
                $this->session->set_flashdata('successMsg', "Vendor details saved successfully");
            }
        }
		$this->session->set_flashdata('successMsg', "Vendor details saved successfully");
        redirect('vendor/addEdit_vendor/'.$vendor_id);
}


public function vendorDelete() {
    $id = $this->input->post('id');
    $table = $this->input->post('table');
    $file = $this->input->post('file');
    $returnArr['status'] = '0';
	
    if (!empty($id) && $table != '') {
        $updateData['upload_invoice'] = '';
        $condition = array('id' => $id);
		$upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/vendor_documents/'.$file;
		unlink(upload_path);
		$this->vendor_model->update_data($table, $condition, $updateData);
        $this->session->set_flashdata('successMsg', "Record(s) deleted successfully");
    }
    echo json_encode($returnArr);
}
	
public function vendorBankDelete() {
    $id = array_filter($this->input->post('id'));
    $table = $this->input->post('table');
    $returnArr['status'] = '0';
    if (!empty($id) && $table != '') {
        $returnArr['status'] = '1';
        $condition = array('id' => $id);
        $this->vendor_model->delete_data_in($table, $condition);
        $this->session->set_flashdata('successMsg', "Record(s) deleted successfully");
    }
    echo json_encode($returnArr);
}
	
public function updateAmendStatus() {
	#echo'<pre>';print_r($_POST);die;
    $vendorId = $this->input->post('id');
    $amend = $this->input->post('amend');
    $comment = trim($this->input->post('comment'));
    $type = $this->input->post('type');
	
	$getVendorDetails = $this->vendor_model->get_all_details('vendor', array('id'=>$vendorId), array('created_user_id','name'), '', '', '');
	if(!empty($getVendorDetails)){
		$cretedUserId = $getVendorDetails[0]->created_user_id;
		$getUserData = $this->vendor_model->get_all_details('hr_user_profile', array('id'=>$cretedUserId), array('official_email','emp_name'), '', '', '');
		if(!empty($getUserData)){
			$cretedUserEmail = $getUserData[0]->official_email;
			
			$mail_config = partner_smtp();
			$config = array(
				'protocol' => $mail_config['protocol'],
				'smtp_host' => $mail_config['smtp_host'],
				'smtp_port' => $mail_config['smtp_port'],
				'smtp_user' => $mail_config['smtp_user'],
				'smtp_pass' => $mail_config['smtp_pass'],
				'newline' => "\r\n",
			);
			$this->load->library('email', $config);
			$this->email->clear(true);
			$this->email->set_newline("\r\n");
	
			
			$this->load->library('email', $config);
			$this->email->clear(true);
			
			
			if($type=='amend'){
				$this->email->from($mail_config['smtp_user'],'Ammend Change Request');
				
			$mail_message = '
			<html lang="en">
			<head>
			<title>Email Template</title>
			<style>
			body {
			font-family: Arial, sans-serif;
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
			background-color: #f4f4f4;
			}
			h1 {
			color: #333;
			}
			p, ul {
			color: #666;
			}
			ul {
			margin-top: 10px;
			margin-bottom: 10px;
			}
			li {
			margin-bottom: 5px;
			}
			</style>
			</head>
			<body>
			<div>
			<h1>Amendment request regarding the vendor details</h1>
			<p>Hi '.$getUserData[0]->emp_name.',</p>
			<p>Following request has been raised:</p>
			<ul>
			<li><strong>Amend Message:</strong> '.$comment .'</li>
			<li><strong>Vendor Name:</strong> '.$getVendorDetails[0]->name .'</li>
			</ul>
			<p>Thanks,<br> Villgro</p>
			</div>
			</body>
			</html>';
			$mail_subject ='Ammed request';
			
			}else if($type=='approved'){
				$this->email->from($mail_config['smtp_user'],'Vendor Request');
				$mail_message = '
			<html lang="en">
			<head>
			<title>Email Template</title>
			<style>
			body {
			font-family: Arial, sans-serif;
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
			background-color: #f4f4f4;
			}
			h1 {
			color: #333;
			}
			p, ul {
			color: #666;
			}
			ul {
			margin-top: 10px;
			margin-bottom: 10px;
			}
			li {
			margin-bottom: 5px;
			}
			</style>
			</head>
			<body>
			<div>
			<p>Hi '.$getUserData[0]->emp_name.',</p>
			<p>'.$getVendorDetails[0]->name.' Vendor request is approved:</p>
			
			<p>Thanks,<br> Villgro</p>
			</div>
			</body>
			</html>';
			$mail_subject ='Approved Vendor request';
			}
			$this->email->to($cretedUserEmail);
			$this->email->subject($mail_subject);
			$this->email->message($mail_message);
			$this->email->send();

		}
	}
	
	
    if (!empty($vendorId) && $type != '') {
		if($type=='approved'){
			$status = 2;
			$condition = array('id'=>$vendorId);
			$this->vendor_model->update_data('vendor',$condition, array('amend'=>$amend,'status'=>$status,'comment'=>$comment));
			$this->vendor_model->update_data('vendor_bank_details',array('vendor_id'=>$vendorId), array('status'=>$status));
			$this->session->set_flashdata('successMsg', "Record(s) approved successfully");
		}else if($type=='amend'){
			$status = 3;
			$condition = array('id'=>$vendorId);
			$this->vendor_model->update_data('vendor',$condition, array('amend'=>$amend,'status'=>$status,'comment'=>$comment));
			$this->vendor_model->update_data('vendor_bank_details',array('vendor_id'=>$vendorId), array('status'=>$status));
			$this->session->set_flashdata('successMsg', "Record(s) approved successfully");
			$this->session->set_flashdata('successMsg', "Record(s) amend successfully");
		}
		
    }
    echo json_encode($returnArr);
}


public function checkPanNumerExist() {
	$panNumber = $this->input->post('panNumber');
	$vendorId = $this->input->post('vendorId');
	
	if($vendorId!=''){
		$getVendorDetails = $this->vendor_model->get_all_details('vendor', array('status !='=>4,'pan'=>$panNumber,'id !='=>$vendorId), array(''), '', '', '');
	}else{
		$getVendorDetails = $this->vendor_model->get_all_details('vendor', array('pan'=>$panNumber,'status !='=>4), array(''), '', '', '');
	}
	$returnArr['status'] = '0';
	if(!empty($getVendorDetails)){
		$returnArr['status'] = '1';
	}
	echo json_encode($returnArr);
}
	public function checkAccountNumberExist() {
		$account_number = $this->input->post('account_number');
		$vendorId = $this->input->post('vendorId');
		if($vendorId!=''){
			$getVendorDetails = $this->vendor_model->get_all_details('vendor_bank_details', array('status !='=>4,'account_number'=>$account_number,'id !='=>$vendorId), array(''), '', '', '');
		}else{
			$getVendorDetails = $this->vendor_model->get_all_details('vendor_bank_details', array('status !='=>4,'account_number'=>$account_number), array(''), '', '', '');
		}
		$returnArr['status'] = '0';
		if(!empty($getVendorDetails)){
			$returnArr['status'] = '1';
		}
		echo json_encode($returnArr);
	}
		

}

?>
