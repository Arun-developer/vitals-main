<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
* Exit details Controller Page
*
* @ControllerName     exitdetails.php
* @Author             Sanjoy Dey
* @Created Date       4-12-2011
* @Modified Date      6-12-2011
* @Modified By        Sanjoy Dey
* @copyright          Quadruple Business Service Pvt. Ltd. Copyright(c) 2011
* @version            CodeIgniter_2.0.3
* @link               http://www.codeigniter.com
* @since              File available since Release 2.0.3
* @Warning            Any change in this file may cause abnormal behaviour of application.
*
*/

class Exitdetails extends CI_Controller {

	function __construct() { 
		//Call Constructor 
		parent::__construct(); 
		$this->Mauth->isLoggedCheck(); // Check user logged in or not
		$this->load->model('mexitdetails');
	} 
	/*
	* index Function is used to add and edit details
	*/
	function index($insertID =NULL){
	
		$innovationID = '49';
		$data['currentStage'] = $this->mexitdetails->getCurrentStage('1');		
		$data['activity'] = $this->mexitdetails->getActivityForGrading($innovationID,$data['currentStage']);
		
		$activity = $data['activity'][0];
		$data['grading'] = $this->mexitdetails->getGradeDetails($activity['id']);
		
		$data['innovation'] = $this->mexitdetails->getInnovationName($innovationID);	
		$data['amount_details'] =$this->mexitdetails->getBudgetDetails($innovationID);
		$data['amount_Date'] =$this->mexitdetails->getApprovalDate($innovationID);
		$data['utilizedAmount'] =$this->mexitdetails->getfundUtilized($innovationID);
		
		$exitPostData= $this->input->post('exit');
		$this->load->helper(array('form', 'url'));
		
		$data['detailsByLastID'] =$this->mexitdetails->checkDuplicate($innovationID);
		$count= count($data['detailsByLastID']);
				
			if($count > 0 )  {
				$insertID = $data['detailsByLastID'][0]['id'];
			}
		
			//Check form is submitted or not
			if(isset($_POST['txtSubmit'])) {
	
				if(!empty($_FILES['documentUpload']['name'])) {				
					$data = $this->doUpload();
					if(isset($data['filename'])) {
						$exitPostData['document_path'] = $data['filename'];
					}
				} 
				
				if(empty($data['error']))  {
				
					if(!$insertID) {
					
						$innovationID = '49';
						$data['amount_details'] =$this->mexitdetails->getBudgetDetails($innovationID);
						$data['amount_Date'] =$this->mexitdetails->getApprovalDate($innovationID);
						$data['utilizedAmount'] =$this->mexitdetails->getfundUtilized($innovationID);
						$lastID = $this->mexitdetails->insert($exitPostData,$innovationID);
						redirect('exit_details/exitdetails/index/'.$lastID);
					}
					else {
						
						$innovationID = '49';					
						$data['currentStage'] = $this->mexitdetails->getCurrentStage('1');		
						$data['activity'] = $this->mexitdetails->getActivityForGrading($innovationID,$data['currentStage']);

						$activity = $data['activity'][0];
						$data['grading'] = $this->mexitdetails->getGradeDetails($activity['id']);
						$data['amount_details'] =$this->mexitdetails->getBudgetDetails($innovationID);
						$data['amount_Date'] =$this->mexitdetails->getApprovalDate($innovationID);
						$data['utilizedAmount'] =$this->mexitdetails->getfundUtilized($innovationID);
						$filedetails = $this->doUpload();						
						$this->mexitdetails->update($exitPostData,$filedetails,$insertID,$innovationID);
					} 
				
				}
			}		
		$data['insertID'] = $insertID;
		$data['innovationID'] = $innovationID;
		$data['cpagetitle'] = "Exit Details";
		$data['cpage'] = "vexitdetails";
		$this->load->view('template',$data);
	}
	
	function gradingDetails($innovationID) {
		
		$activityID = $this->uri->segment('4');		
		$data['innovation'] = $innovationID;
		$data['grading'] = $this->mexitdetails->getGradeDetails($activityID);
		$data['grading_Details']=$this->mexitdetails->getGradingDetails($innovationID);
		$data['totalfundreleased'] = $this->mexitdetails->getfunddisbursed($innovationID);
		$data['totalfundutilized'] = $this->mexitdetails->getfundUtilized($innovationID);
		if(isset($_POST['txtSubmit'])) 
		{

			$exitPostData = $_POST;
			
			if(!empty($_FILES['documentUpload']['name'])) 
			{				
				$data = $this->doUpload();
				$exitPostData['exit']['document_path'] = $_FILES['documentUpload']['name'];
			}
			$this->mexitdetails->insert($exitPostData,$innovationID);
			redirect('exit_details/exitdetails/summary');
			$this->session->set_flashdata('successMsg','Information Added successfully!');
		} 
        $data['exitdetails'] = $this->mexitdetails->checkDuplicate($innovationID);
		if($data['exitdetails'])
		{
			$data['cpage'] = 'exitlist';
			$data['cpagetitle'] = 'Exited Innovations List';
			$this->load->view('../dashboard_template',$data);
		}
		else
		{
		$data['cpagetitle'] = "Exit Details";
		$data['cpage'] = "vexitdetails";
		$this->load->view('template',$data);
    	}
	}
	
	
	function summary()
	{
		$data['exitdetails'] = $this->mexitdetails->getdetails();
		$data['cpage'] = 'exitlist';
		$data['cpagetitle'] = 'Exited Innovations List';
		$this->load->view('../dashboard_template',$data);
	}
	
	
	function liststatus($decision = NULL,$innovationid=NULL,$id=NULL)
		 {
		  
		   if($decision=='approve')
		   {
		      
		     if(isset($_POST['approveSubmit']))
			 {
			 
			   $options=array();
			   $options=$_POST;
			   $this->mexitdetails->updateliststatus($options);
			   $this->mexitdetails->changestatus($innovationid);
               redirect('scouting/innovation_pool/all');
			 }
		    $data['cpagetitle'] = "Approve Request";
		    $data['innovationid']=$innovationid;
			
			$data['id']=$id;
			$data['cpage'] = "listrequest";
			$this->load->view('../template_plain',$data);
		   }
		   else
		   {
			   if(isset($_POST['rejectSubmit']))
			 {
			  
			   $options=array();
			   $options=$_POST;
			   $this->mexitdetails->updateliststatus($options);
			   redirect('exit_details/exitdetails/summary');
			 }
			
		     $data['cpagetitle'] = "Reject Request";
		     $data['innovationid']=$innovationid;
			 $data['id']=$id;
			 $data['cpage'] = "listreject";
		     $this->load->view('../template_plain',$data);
		   }	 
		 }
	
	/*
	* doUpload Function is used to upload exit details file
	*/
	function doUpload() {
		
		$config['upload_path'] = './uploads/exit_details/';
		$config['allowed_types'] = 'txt|pdf|doc|docx';
		$config['max_size'] = '0';						
		$config['max_width']= '1024';
		$config['max_height']= '768';
		$config['remove_spaces']= 'TRUE';
		$config['overwrite'] = 'TRUE';
		
		//show($_FILES);exit;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);//Intialising Upload Functuion
		if ( ! $this->upload->do_upload('documentUpload')) {
		
			$data['error'] = $this->upload->display_errors();
			return $data;
		}
		else {
			$this->session->set_flashdata('error','File Uploaded Successfully!');	
			$data['filename'] = $_FILES['documentUpload']['name'];			
			$data['upload_path']=$config['upload_path'];
			return $data;
		}
	
	}
	
	/*
	* download Function is used to download file which is uploaded
	*/
	function download($insertID =NULL) {
	
		$queryArray['select'] = '*';
		$queryArray['where']  = array( 'id' => $insertID);
		$data = $this->mexitdetails->getDetailsByLastID($queryArray);
		$file_path = $data['document_path'];
		$file_name = $data['document_name'];
		$path=$path['upload_path'];	
		$this->load->helper('download');//Load Download helper 
		$fullPath = $file_path.$file_name;	
		$data = file_get_contents($fullPath); 
		$name = $file_name;
		force_download($name,$data);//Download Data/File
		redirect('exit_details/exitdetails/index/'.$insertID);
		
	}
	
	
}
?>
