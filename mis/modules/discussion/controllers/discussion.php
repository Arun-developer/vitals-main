<?php
	class Discussion extends CI_Controller {

		function __construct()
		{
			parent::__construct();
			$this->load->model('Mdiscussion');
			$this->load->model('activities/Mactivities');
			$this->load->model('scouting/Minnovation');
			$this->items_perpage = '10';
		}
		
		function view($activity = NULL)
		{
			if($activity == NULL)
			{
				echo "Invalid Url!";exit;
			}
			$options = array();
			$options = $_POST;
			$options['activity'] = $activity;
			$options['num'] = $this->items_perpage;
			$options['offset'] = $this->uri->segment(5);
			
			#Pagination Scripts Starts
			$config = array( 'base_url' => site_url('scouting/discussion/view/'.$activity),
							 'per_page'	=> $this->items_perpage,
							 'total_rows' => $this->Mdiscussion->getAllCount($options),
							 'num_links' => 10,
							 'uri_segment' => 5);
			$this->pagination->initialize($config);
			#pagination Ends
		
			#Loading View and data
			$data['activity'] = $activity;
			$activityDetails = $this->Mactivities->getActivityDetails($activity);
			$data['activityDetails'] = $activityDetails;
			$data['discussionDetails'] = $discussionDetails = $this->Mdiscussion->getDiscussionDetails($activity); 
			$data['innovation'] = $innovationInfo = $this->Minnovation->getInnovation($activityDetails['0']['innovation']);
			
			$data['commentsList'] = array();
			if(php72_count($discussionDetails))
			{
				$options['discussion'] = $discussionDetails['0']['id'];
				$data['commentsList'] = $this->Mdiscussion->getLimitRecords($options);
			}
			$data['orderby'] = $this->input->post('orderby'); 
			$data['ordertype']  = $this->input->post('ordertype');
			$data['cpagetitle'] = "Discussion";
			$data['cpage'] = "discussion/viewDiscussion";
			
			$data['left_box'] = array('screening','innovation_tab');
			
			$this->load->view('../template',$data);
		}
		function create($activity = NULL)
		{
			if($activity == NULL)
			{
				echo "Invalid Url!";exit;
			}
			$activityDetails = $this->Mactivities->getActivityDetails($activity);
			$data['innovation'] = $activityDetails['0']['innovation'];
			$data['innovationInfo'] = $innovationInfo = $this->Minnovation->getInnovation($data['innovation']);
			
			$data['errorMsg'] = '';
			if(isset($_POST['txtSubmit']))
			{
				if($this->_validation())
				{
					if($_FILES['documents']['name'] != '')
					{
						$config['upload_path'] = './uploads/discussion';
						$config['allowed_types'] = '*';
						$config['file_name'] = str_replace(' ','_',$innovationInfo['name_of_enterprise'])."-activities_discussion-".str_replace(' ','_',$_FILES['documents']['name']);
						
						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('documents'))
						{
							$data['errorMsg'] = $this->upload->display_errors();
							$this->session->set_flashdata('errorMsg',$data['errorMsg']);
						}
						else
						{
							$upload_data = $this->upload->data();
							$_POST['documents'] = $upload_data['file_name'];
						}
					}
					else
						$_POST['documents'] = '';
					if(empty($data['errorMsg']))
					{
						$_POST['activity'] = $activity;
						$result = $this->Mdiscussion->create($_POST);
						$this->session->set_flashdata('successMsg','Discussion Created Successfully!');
					}
				}
				else
					$this->session->set_flashdata('errorMsg',"Validation error found, check it again!");
			}
			redirect('discussion/view/'.$activity);
		}
		function add_comments($activity = NULL,$id = NULL)
		{
			if($activity == NULL || $id == NULL)
			{
				echo "Invalid Url!";exit;
			}
			$activityDetails = $this->Mactivities->getActivityDetails($activity);
			$data['innovation'] = $activityDetails['0']['innovation'];
			$data['innovationInfo'] = $innovationInfo = $this->Minnovation->getInnovation($data['innovation']);
			$data['errorMsg'] = '';
			if(isset($_POST['txtSubmit']))
			{
				if($_FILES['documents']['name'] != '')
				{
					$config['upload_path'] = 'uploads\discussion';
					$config['allowed_types'] = '*';
					$config['file_name'] = str_replace(' ','_',$innovationInfo['name_of_enterprise'])."-activities_discussion_comments-".str_replace(' ','_',$_FILES['documents']['name']);
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('documents'))
					{
						$data['errorMsg'] = $this->upload->display_errors();
						$this->session->set_flashdata('errorMsg',$data['errorMsg']);
					}
					else
					{
						$upload_data = $this->upload->data();
						$_POST['documents'] = $upload_data['file_name'];
					}
				}
				else
					$_POST['documents'] = '';
				if(empty($data['errorMsg']))
				{
					$_POST['discussion'] = $id;
					$result = $this->Mdiscussion->add_comments($_POST);
					$this->session->set_flashdata('successMsg','Record inserted !');
					
				}
			}
			redirect('discussion/view/'.$activity);
			
		}
		function edit($activity = NULL,$id = NULL)
		{
			$data['errorMsg'] = '';
			if(isset($_POST['txtSubmit']))
			{
				if($this->_validation())
				{
					//insert mailtemplates
					if($_FILES['documents']['name'] != '')
					{
						if(!empty($_POST['pre_documents']))
							unlink('uploads/discussion/'.$_POST['pre_documents']);
						$config['upload_path'] = 'uploads\query';
						$config['allowed_types'] = 'gif|jpg|png|pdf|doc|txt';
						$config['file_name'] = rand()."_".str_replace(' ','_',$_FILES['documents']['name']);
						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('documents'))
						{
							$data['errorMsg'] = $this->upload->display_errors();
							$this->session->set_flashdata('errorMsg',$data['errorMsg']);
						}
						else
						{
							$upload_data = $this->upload->data();
							$_POST['documents'] = $upload_data['file_name'];
						}
					}
					else
						$_POST['documents'] = $_POST['pre_documents'];
						
					$_POST['id'] = $id;
					if(empty($data['errorMsg']))
					{
						$this->Mdiscussion->update($_POST);
						$this->session->set_flashdata('successMsg','Record Updated !');
					}
				}
				else
					$this->session->set_flashdata('errorMsg',"Validation error found, check it again!");
			}
			#Loading View and data
			redirect('discussion/view/'.$activity);
		}
		
		/**
		* Function : delete method is used for delete mailtemplates.
		* 
		* @param int $id
		*
		*/
		
		function delete_comments($activity = '',$discussion = '', $id = '')
		{
			if($id != '')
			{
				$result = $this->Mdiscussion->deleteComments($id,$discussion);
				$this->session->set_flashdata('successMsg','Comments deleted Successfully');
			}
			else
				$this->session->set_flashdata('successMsg','Value Missing');
			redirect('discussion/view/'.$activity);
		}
		
		
		
		/**
		* Function : _validation method is used for validation before add, edit mailtemplate.
		*
		* Function called by: 
		* ---------------
		* $this->add()
		* $this->edit()
		* 
		* @param null
		*/
		
		function _validation()
		{
				$this->load->library("form_validation");
				$this->form_validation->set_rules('discussion_title', 'Title', 'required'); 
				if ($this->form_validation->run() == FALSE)
				{
					return false;
				}
				return true;
		}
		
	}
?>
