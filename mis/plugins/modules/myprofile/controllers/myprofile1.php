<?php
class Myprofile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
         $this->Mauth->isLoggedCheck();
         $this->load->model('Mprofile');
        
    }

    public function index()
    {
    	//echo'hi';exit();

      $emp_id = $this->session->userdata('emp_number');

       $data = $this->Mprofile->getpersonalType($emp_id);
       //echo'<pre>';print_r($data);exit();
      $this->load->view('myprofile/personal',$data[0]);
    }
    public function editpersonal()
    {
    	//$this->load->model('Mprofile');
    	$emp_id = $this->session->userdata('emp_number');
    	//print_r($emp_id);exit();
	   	if(isset($_POST) && !empty($_POST)){
            
            $file=$_FILES;
            $file_name = $_FILES['emp_picture']['name'];
        	$file_tmp_name = $_FILES['emp_picture']['tmp_name'];
      
//                $fName = rand() . "_" . str_replace(" ", "_", $value);
                $rename_file = str_replace(' ', '_', strtolower($file_name));
                $new_name = preg_replace('/[^A-Za-z0-9.\_]/', '', $rename_file);
                $fName = date('Ymdhis') . '_' . $new_name;
                @copy($file_tmp_name, "uploads/profile/" . $fName);
                //$fNameArray[] = $fName;
        
          // echo "<pre>"; print_r($fName);die;
	        $new_allocate['emp_first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : '';
	        $new_allocate['emp_middle_name'] = isset($_POST['middle_name']) ? $_POST['middle_name'] : '';
	        $new_allocate['emp_last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : '';
	        $new_allocate['emp_dob'] = isset($_POST['dob']) ? date("Y-m-d",$_POST['dob']) : '';
	        $new_allocate['emp_age'] = isset($_POST['age']) ? $_POST['age'] : '';
	        $new_allocate['emp_gender'] = isset($_POST['gender']) ? $_POST['gender'] : '';
	        $new_allocate['blood_group'] =isset($_POST['blood_group']) ? $_POST['blood_group'] : '';
	        $new_allocate['marital_status'] = isset($_POST['marital_status']) ? $_POST['marital_status'] : '';
	        $new_allocate['nationality'] = isset($_POST['nationality']) ? $_POST['nationality'] : '';
	        $new_allocate['experience'] = isset($_POST['experience']) ? $_POST['experience'] : '';
	        $new_allocate['uan_number'] = isset($_POST['uan_number']) ? $_POST['uan_number'] : '';
	        $new_allocate['pan_number'] = isset($_POST['pan_number']) ? $_POST['pan_number'] : '';
	        $new_allocate['emp_picture'] = isset($fName) ? $fName : '';
	        

	        $hm_query = $this->Mprofile->update('hr_user_profile',$new_allocate,$emp_id);

	        $this->session->set_flashdata('successMsg', "Personal details saved successfully");
	          redirect('myprofile/index');
	    }else{
	    	 $this->session->set_flashdata('errormsg', 'Value Missing');
              redirect('myprofile/index');
	    }
       
    }

    public function reporting($id = '') {

        $employee['status'] = $option['status'] = 1;
        $employee['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Mprofile->getCommonDetails('hr_user_profile', $employee);
        }
		
        $data['employee_list'] = $this->Mprofile->getReportingEmployee($id);

        $data['supervisor_list'] = $this->Mprofile->getReportingList('hr_user_reporting', $id, 'report_subordinate', 'report_supervisor');

        $data['subordinate_list'] = $this->Mprofile->getReportingList('hr_user_reporting', $id, 'report_supervisor', 'report_subordinate');

        $this->load->vars($data);

        $this->load->view('myprofile/reporting');
    }

        public function add_supervisor() {
        for ($i = 0; $i < count($_POST['supervisor_employee']); $i++) {
            if ($_POST['supervisor_employee'][$i] != '') {
                $data = array();
                $option['id'] = $_POST['report_sup'][$i];
                $data['report_supervisor'] = $_POST['employee_id'];
                $data['report_subordinate'] = $_POST['supervisor_employee'][$i];
                $data['report_method'] = $_POST['supervisor_method'][$i];

                $checkExist = $this->Mportfolio->getDetails('hr_user_reporting', $option);
                if (count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $query = $this->Mportfolio->updatePortfolioDetail('hr_user_reporting', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('hr_user_reporting', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Supervisor details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/reporting/' . $_POST['employee_id']);
    }

    public function add_subordinate() {
        for ($i = 0; $i < count($_POST['subordinate_employee']); $i++) {
            if ($_POST['subordinate_employee'][$i] != '') {
                $data = array();
                $option['id'] = $_POST['report_subor'][$i];
                $data['report_subordinate'] = $_POST['employee_id'];
                $data['report_supervisor'] = $_POST['subordinate_employee'][$i];
                $data['report_method'] = $_POST['subordinate_method'][$i];

                $checkExist = $this->Mportfolio->getDetails('hr_user_reporting', $option);
                if (count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $query = $this->Mportfolio->updatePortfolioDetail('hr_user_reporting', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('hr_user_reporting', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Subordinate details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/reporting/' . $_POST['employee_id']);
    }

    public function add_user() {
        $option['status'] = 1;
        $data['user_type'] = $this->Mprofile->getCommonDetails('hr_user_type', $option, 'asc', 'user_type');
        $data['experience'] = $this->Mprofile->getCommonDetails('hr_experience_type', $option, 'asc', 'id');
        $data['nationality'] = $this->Mprofile->getCommonDetails('hr_nationality', $option, 'asc', 'nationality');
        $data['partner_type'] = $this->Mprofile->getCommonDetails('hr_partner_type', $option, 'asc', 'partner_name');
        $last_id = $this->Mprofile->last_employee_id();
        $data['employee_id'] = $last_id[0]['id'] + 1;
        $this->load->vars($data);
        $this->load->view('myprofile/add_user');
    }

    public function personal($id = '') {
        $user['status'] = $option['status'] = 1;
        $user['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Mprofile->getCommonDetails('hr_user_profile', $user);
        }

        $data['experience'] = $this->Mprofile->getCommonDetails('hr_experience_type', $option, 'asc', 'id');
        $data['nationality'] = $this->Mprofile->getCommonDetails('hr_nationality', $option, 'asc', 'nationality');
        $data['user_type'] = $this->Mprofile->getCommonDetails('hr_user_type', $option, 'asc', 'user_type');
        $this->load->vars($data);
        $this->load->view('myprofile/personal');
    }

    public function add_personal() {

        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/profile';
        if ($_FILES["profile_pic"]["name"] != "") {
            $split_name = explode('.', $_FILES["profile_pic"]["name"]);
            $get_extension = array_pop($split_name);
            $get_name = implode('', $split_name);

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'png|jpg|jpeg';
            $rename_file = str_replace(' ', '_', strtolower($get_name));
            $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
            $config['file_name'] = date('Ymdhis') . '_' . $new_name . '.' . $get_extension;

            $this->upload->initialize($config);

            $_FILES['upload_pic']['name'] = $_FILES['profile_pic']['name'];
            $_FILES['upload_pic']['tmp_name'] = $_FILES['profile_pic']['tmp_name'];
            $_FILES['upload_pic']['size'] = $_FILES['profile_pic']['size'];
            $_FILES['upload_pic']['type'] = $_FILES['profile_pic']['type'];
            $_FILES['upload_pic']['error'] = $_FILES['profile_pic']['error'];

            if (!$this->upload->do_upload('upload_pic')) {
                $upload_error = $this->upload->display_errors();
                echo $upload_error . "--" . $i;
            } else {
                $upload_data = $this->upload->data();
                $data['emp_picture'] = $upload_data['file_name'];
            }
            unset($config);
        } else if (isset($_POST['old_profile_pic']) && $_POST['old_profile_pic'] != '') {
            $data['emp_picture'] = $_POST['old_profile_pic'];
        } else {
            $data['emp_picture'] = '';
        }

        $get_fullname = $_POST['txt_firstname'] . ' ' . $_POST['txt_middlename'] . ' ' . $_POST['txt_lastname'];
        $emp_fullname = str_replace("  ", " ", $get_fullname);

        $option['id'] = isset($_POST['txt_empid']) && $_POST['txt_empid'] != '' ? $_POST['txt_empid'] : '';
        $data['emp_first_name'] = $_POST['txt_firstname'];
        $data['emp_middle_name'] = $_POST['txt_middlename'];
        $data['emp_last_name'] = $_POST['txt_lastname'];
        $data['emp_name'] = $emp_fullname;
        $data['emp_type'] = $_POST['txt_employee'];
        if ($this->session->userdata['user_type'] == 'superadmin') {
            $data['partner_id'] = $_POST['txt_partner'];
        } else {
            $data['partner_id'] = $this->session->userdata('partner_id');
        }
        $data['emp_dob'] = (isset($_POST['txt_dob']) && $_POST['txt_dob'] != '') ? date('Y-m-d', strtotime($_POST['txt_dob'])) : '';
        $data['emp_age'] = $_POST['txt_age'];
        $data['emp_gender'] = $_POST['txt_gender'];
        $data['blood_group'] = $_POST['txt_blood'];
        $data['marital_status'] = $_POST['txt_marital'];
        $data['nationality'] = $_POST['txt_nationality'];
        $data['experience'] = $_POST['txt_experience'];
        $data['hiring_source'] = $_POST['txt_hiring'];
        $data['military_service'] = $_POST['txt_military'];
        $data['insurance'] = $_POST['txt_insurance'];
        $data['uan_number'] = $_POST['txt_uan'];
        $data['pan_number'] = $_POST['txt_pan'];
        $data['license_number'] = $_POST['txt_license'];
        $data['license_expiry_date'] = (isset($_POST['txt_license_expiry']) && $_POST['txt_license_expiry'] != '') ? date('Y-m-d', strtotime($_POST['txt_license_expiry'])) : '';
        $data['organ_donor'] = $_POST['txt_organ'];
        $data['illness'] = $_POST['txt_illness'];
        $data['hobbies'] = $_POST['txt_hobbies'];

        $checkExist = $this->Mportfolio->getDetails('hr_user_profile', $option);
        if (count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $query = $this->Mportfolio->updatePortfolioDetail('hr_user_profile', $data, $option);
            $emp_id = $_POST['txt_empid'];
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('hr_user_profile', $data);
            $emp_id = $this->db->insert_id();

            /* assign leave quota for employee */
            $leavetypes = $this->Mleave->getLeaveTypes();
            $empid = $this->session->userdata['emp_number'];
            $emp_list = $this->Mleave->getEmployeedetail($emp_id);
            foreach ($emp_list as $elist) {
                $check_leave_quota = $this->Mleave->getLeaveQuota($elist['employee_id'], date('Y'));
                if (count($check_leave_quota) == 0) {
                    foreach ($leavetypes as $leaves) {
                        $leavedetails['year'] = date('Y');
                        $leavedetails['leave_type_id'] = $leaves['leave_type_id'];
                        $leavedetails['employee_id'] = $elist['employee_id'];
                        $leavedetails['partner_id'] = $data['partner_id'];
                        $leavedetails['created_date'] = date("Y-m-d H:i:s");
                        $quota_query = $this->Mleave->insertLeaveDetail('hr_leave_quota', $leavedetails);
                    }
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Personal details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/personal/' . $emp_id);
    }



}
