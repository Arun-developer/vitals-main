<?php

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->Mauth->isAdminCheck();
        $this->load->model('Empuser');
        $this->load->model('leave/Mleave');
        $this->load->model('myprofile/Mprofile');
        $this->load->library('upload');
        $this->load->model('portfolio/Mportfolio');
    }

    public function lists($type) {
        $u_option['status'] = $option['status'] = 1;
        $data['search_field'] = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['search_value'] = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';
        $u_option['id'] = $data['current_user'] = $type;
//        $data['current_user'] = (isset($_POST['current_user'])) ? $_POST['current_user'] : 'employee';

        $data['type_name'] = $this->Empuser->getCommonDetails('hr_user_type', $u_option);
        $data['user_type'] = $this->Empuser->getCommonDetails('hr_user_type', $option, 'asc', 'user_type');
        $this->load->vars($data);
        $this->load->view('user/profile/employees_list');
    }

    public function DT_employee() {
        $requestData = $_POST;

        if ($this->session->userdata['user_type'] == 'superadmin') {
            $columns = array(
                0 => 'emp_type',
                1 => 'id',
                2 => 'emp_name',
                3 => 'partner_name',
                4 => 'user_role',
                5 => 'job_title',
                6 => 'designation'
            );
        } else {
            $columns = array(
                0 => 'emp_type',
                1 => 'id',
                2 => 'emp_name',
                3 => 'user_role',
                4 => 'job_title',
                5 => 'designation'
            );
        }

        $data['search_field'] = $search_field = (isset($_POST['search_field'])) ? $_POST['search_field'] : '';
        $data['search_value'] = $search_value = (isset($_POST['search_value'])) ? $_POST['search_value'] : '';
        $data['current_user'] = $current_user = (isset($_POST['current_user'])) ? $_POST['current_user'] : 'employee';

        $totalrows = $this->Empuser->getDTEmployeeCount($search_field, $search_value, $current_user, $columns, $requestData);
        $query = $this->Empuser->getDTEmployeeDetails($requestData['length'], $requestData['start'], $search_field, $search_value, $current_user, $columns, $requestData);
		
		////////////////////
		/* if($this->session->userdata('emp_number') =='275'){
			$query = $this->Empuser->getDTEmployeeDetails('', '', '', '', $current_user, $columns, $requestData);
			foreach($query as $emp_lists){
				$emp_id = $emp_lists['id'];
				$emp_name = $emp_lists['emp_name'];
				$condition = array('emp_id'=>$emp_id);
				$get_documentDetails[$emp_name] =  $this->Empuser->getCommonDetails('hr_user_document',$condition);
				
			}
			echo'<pre>';print_r($get_documentDetails);die;
		} */
		////////////////////
		
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

            $user_role = '-';
            if(php72_cmp($row['user_role']) == 1) {
                $user_role = 'User';
            } else if(php72_cmp($row['user_role']) == 2) {
                $user_role = 'Partner Admin';
            } else if(php72_cmp($row['user_role']) == 3) {
                $user_role = 'Super Admin';
            } else if(php72_cmp($row['user_role']) == 4) {
                $user_role = 'Custom User';
            }

            $nestedData[] = '<input type="checkbox" class="chk_box" id="emp_chk_box" name="employee_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['id'];
            $get_emp_name = $row['emp_name'];
            $emp_name = str_replace("  ", " ", $get_emp_name);
            $derive_name = (strlen($emp_name) > 15) ? substr($emp_name, 0, 15) . ".." : $emp_name;
            $nestedData[] = "<a href=" . site_url('user/personal/' . $row['id']) . " title='" . $emp_name . "'>" . $derive_name . "</a>";
            if ($this->session->userdata['user_type'] == 'superadmin') {
                $nestedData[] = $row['partner_name'] != '' ? $row['partner_name'] : '-';
            }
            $nestedData[] = $user_role;
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

    public function deleteDetail() {
        $id = $this->input->post('id');
        $condition = "'" . php72_implode("', '", $id) . "'";
        $table = $_POST['table'];
        $query = $this->Empuser->deleteEmployeeDetail($table, $condition);

        if ($query) {
            echo '1';
            $this->session->set_flashdata('successMsg', "Record(s) deleted successfully");
        } else {
            echo '0';
        }
    }

    public function add_user() {
        $option['status'] = 1;
        $data['user_type'] = $this->Empuser->getCommonDetails('hr_user_type', $option, 'asc', 'user_type');
        $data['experience'] = $this->Empuser->getCommonDetails('hr_experience_type', $option, 'asc', 'id');
        $data['nationality'] = $this->Empuser->getCommonDetails('hr_nationality', $option, 'asc', 'nationality');
        $data['partner_type'] = $this->Empuser->getCommonDetails('hr_partner_type', $option, 'asc', 'partner_name');
        $last_id = $this->Empuser->last_employee_id();
        $data['employee_id'] = $last_id[0]['id'] + 1;
        $this->load->vars($data);
        $this->load->view('user/profile/add_user');
    }

    public function personal($id = '') {
        $emp_id = $this->session->userdata('emp_number');
        $user['status'] = $option['status'] = 1;
        $user['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $user);
        }

        $data['employee_detail'] = $this->Mprofile->getDetails('hr_user_login', $emp_id);
        $data['experience'] = $this->Empuser->getCommonDetails('hr_experience_type', $option, 'asc', 'id');
        $data['nationality'] = $this->Empuser->getCommonDetails('hr_nationality', $option, 'asc', 'nationality');
        $data['user_type'] = $this->Empuser->getCommonDetails('hr_user_type', $option, 'asc', 'user_type');
        $this->load->vars($data);
        $this->load->view('user/profile/personal');
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
        } 
        // else if (isset($_POST['old_profile_pic']) && $_POST['old_profile_pic'] != '') {
        //     $data['emp_picture'] = $_POST['old_profile_pic'];
        // } 
        else {
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
        if (php72_count($checkExist) > 0) {
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
                if (php72_count($check_leave_quota) == 0) {
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

    public function deleteValues() {
        $condition['id'] = $this->input->post('id');
        $query = $this->Empuser->deleteProfilePicture('hr_user_profile', $condition);
        if ($query) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function login($id = '') {     
        $employee['status'] = $option['status'] = 1;
        $employee['id'] = $user['emp_id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
            $data['login'] = $this->Empuser->getCommonDetails('hr_user_login', $user);
        }

        $emp_id = $this->session->userdata('emp_number');
        $data['employee_detail'] = $this->Mprofile->getDetails('hr_user_login', $emp_id);
        $data['partner_type'] = $this->Empuser->getCommonDetails('hr_partner_type', $option, 'asc', 'partner_name');
        $data['user_type'] = $this->Empuser->getCommonDetails('hr_user_type', $option, 'asc', 'user_type');
        $data['sector_list'] = $this->Empuser->getPitchSectorLists();
        $this->load->vars($data);
        $this->load->view('user/profile/login');
    }

    public function loginName() {
        $emp_id = $_POST['id'];
        $option['user_name'] = $_POST['check_user'];
//        $option['partner_id'] = $_POST['partner'];
        $option['status'] = 1;
        $checkExist = $this->Empuser->getUserName($option, $emp_id);
        if (php72_count($checkExist) > 0) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function add_login() {

        $data['emp_id'] = $emp_id = $option['id'] = $emp_option['emp_id'] = $_POST['employee_id'];
        $data['user_name'] = $_POST['user_name'];
        if ($_POST['user_newpass'] != '******') {
            $data['password'] = md5($_POST['user_newpass']);
            // $data['original_password'] = $_POST['user_newpass'];
        }
        $data['user_role'] = $_POST['user_role'];
        $data['partner_id'] = $_POST['user_partner'];
        $data['status'] = $_POST['user_status'];

        if (isset($_POST['user_partner_access'])) {
            $partner_access = php72_implode(',', $_POST['user_partner_access']);
            $data['partner_access'] = $partner_access;
        }

        if (isset($_POST['tab_access'])) {
            $tab_access = php72_implode(',', $_POST['tab_access']);
            $data['tab_access'] = $tab_access;
        }

        if (php72_cmp($_POST['user_role']) == 4) {
            if (isset($_POST['user_module_access'])) {
                $tab_access = php72_implode(',', $_POST['user_module_access']);
                $data['menu_access'] = $tab_access;
            }

            if (isset($_POST['user_sector_access'])) {
                $tab_access = php72_implode(',', $_POST['user_sector_access']);
                $data['sector_access'] = $tab_access;
            }

            if (isset($_POST['user_program_access'])) {
                $tab_access = php72_implode(',', $_POST['user_program_access']);
                $data['program_access'] = $tab_access;
            }

            $data['deals_from_date'] = (isset($_POST['deals_from']) && $_POST['deals_from'] != '') ? date('Y-m-d', strtotime($_POST['deals_from'])) : '';
            $data['deals_to_date'] = (isset($_POST['deals_to']) && $_POST['deals_to'] != '') ? date('Y-m-d', strtotime($_POST['deals_to'])) : '';
            $data['independent_shortlist'] = isset($_POST['shortlistID']) && php72_cmp($_POST['shortlistID']) == 1 ? $_POST['shortlistID'] : 0;
        } else {
            $data['menu_access'] = $data['sector_access'] = $data['program_access'] = '';
            $data['deals_from_date'] = $data['deals_to_date'] = '0000-00-00';
            $data['independent_shortlist'] = 0;
        }

        $profile['partner_id'] = $_POST['user_partner'];
        $profile['updated_by'] = $this->session->userdata('emp_number');
        $profile_query = $this->Mportfolio->updatePortfolioDetail('hr_user_profile', $profile, $option);

        $checkExist = $this->Mportfolio->getDetails('hr_user_login', $emp_option);

        if($checkExist[0]['enc_user_key'] == ''){
            //Insert a random unique encryption key for indium iframe embed
            $enc_user_key = md5($data['user_name'].date('YmdHis'));
            $data['enc_user_key'] = $enc_user_key;
        }

        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $query = $this->Mportfolio->updatePortfolioDetail('hr_user_login', $data, $emp_option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");

            $enc_user_key = md5($data['user_name'].date('YmdHis'));
            $data['enc_user_key'] = $enc_user_key;
            
            $query = $this->Mportfolio->insertPortfolioDetail('hr_user_login', $data);
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Login details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/login/' . $emp_id);
    }

    public function job($id = '') {
        $user['status'] = $employee['status'] = $option['status'] = 1;
        $user['emp_id'] = $employee['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['job_salary'] = $this->Empuser->getCommonDetails('hr_job_salary', $user);
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }

        $emp_id = $this->session->userdata('emp_number');
        $data['employee_detail'] = $this->Mprofile->getDetails('hr_user_login', $emp_id);
        $data['job_designation'] = $this->Empuser->getCommonDetails('hr_job_designation', $option, 'asc', 'job_title');
        $data['job_location'] = $this->Empuser->getCommonDetails('hr_job_location', $option, 'asc', 'location_name');
        $data['job_department'] = $this->Empuser->getCommonDetails('hr_job_department', $option, 'asc', 'job_department');
        $data['job_type'] = $this->Empuser->getCommonDetails('hr_job_type', $option, 'asc', 'job_name');
        $data['salary_ctc'] = $this->Empuser->getCommonDetails('hr_job_salary_ctc', $option, 'asc', 'id');

        $this->load->vars($data);
        $this->load->view('user/profile/job_salary');
    }

    public function add_designation() {
        $data['emp_id'] = $option['emp_id'] = $_POST['employee_id'];
        $data['designation'] = $_POST['job_design'];
        $data['job_type'] = $_POST['job_type'];
        $data['department'] = $_POST['job_dept'];
        $data['job_date'] = (isset($_POST['job_date']) && $_POST['job_date'] != '') ? date('Y-m-d', strtotime($_POST['job_date'])) : '';
        $data['location'] = $_POST['job_location'];
        $data['job_service_year'] = $_POST['service_year'];
        $data['job_service_month'] = $_POST['service_month'];
        $data['status'] = '1';

        $checkExist = $this->Mportfolio->getDetails('hr_job_salary', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $query = $this->Mportfolio->updatePortfolioDetail('hr_job_salary', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('hr_job_salary', $data);
        }

        if ($query) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function add_salary() {
        $data['emp_id'] = $option['emp_id'] = $_POST['employee_id'];
        $data['ctc_salary'] = $_POST['salary_ctc'];
        $data['gross_salary'] = $_POST['salary_gross'];
        $data['salary_incentive'] = $_POST['salary_incentive'];
        $data['salary_date'] = (isset($_POST['salary_date']) && $_POST['salary_date'] != '') ? date('Y-m-d', strtotime($_POST['salary_date'])) : '';
        $data['contract_hours'] = $_POST['salary_contract'];
        $data['payment_hours'] = $_POST['payment_hours'];

        $checkExist = $this->Mportfolio->getDetails('hr_job_salary', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $query = $this->Mportfolio->updatePortfolioDetail('hr_job_salary', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('hr_job_salary', $data);
        }

        if ($query) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function add_offer() {
        $data['emp_id'] = $emp_id = $option['emp_id'] = $_POST['employee_id'];
        $data['offer_date'] = (isset($_POST['offer_date']) && $_POST['offer_date'] != '') ? date('Y-m-d', strtotime($_POST['offer_date'])) : '';
        $data['offer_designation'] = $_POST['offer_designation'];
        $data['offer_salary'] = $_POST['offer_salary'];
        $data['offer_incentive'] = $_POST['offer_incentive'];
        $data['resignation_date'] = (isset($_POST['resign_date']) && $_POST['resign_date'] != '') ? date('Y-m-d', strtotime($_POST['resign_date'])) : '';
        $data['last_working_date'] = (isset($_POST['resign_last_working']) && $_POST['resign_last_working'] != '') ? date('Y-m-d', strtotime($_POST['resign_last_working'])) : '';

        $checkExist = $this->Mportfolio->getDetails('hr_job_salary', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $query = $this->Mportfolio->updatePortfolioDetail('hr_job_salary', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('hr_job_salary', $data);
        }

        if ($query) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function add_revisedesignation() {
        $option['emp_id'] = $revise['emp_id'] = $data['emp_id'] = $_POST['employee_id'];

        $get_job_details = $this->Mportfolio->getDetails('hr_job_salary', $option);
        $revise['designation'] = $get_job_details[0]['designation'];
        $revise['department'] = $get_job_details[0]['department'];
        $revise['location'] = $get_job_details[0]['location'];
        $revise['job_type'] = $get_job_details[0]['job_type'];
        $revise['job_date'] = $get_job_details[0]['job_date'];
        $revise['job_service_year'] = $get_job_details[0]['job_service_year'];
        $revise['job_service_month'] = $get_job_details[0]['job_service_month'];
        $revise['created_by'] = $this->session->userdata('emp_number');
        $revise['created_at'] = date("Y-m-d H:i:s");
        if ($get_job_details[0]['designation'] != '')
            $revise_query = $this->Mportfolio->insertPortfolioDetail('hr_job_designation_revise', $revise);

//        if ($revise_query) {
        $data['designation'] = $_POST['job_design'];
        $data['job_type'] = $_POST['job_type'];
        $data['department'] = $_POST['job_dept'];
        $data['job_date'] = (isset($_POST['job_date']) && $_POST['job_date'] != '') ? date('Y-m-d', strtotime($_POST['job_date'])) : '';
        $data['location'] = $_POST['job_location'];
        $data['job_service_year'] = $_POST['service_year'];
        $data['job_service_month'] = $_POST['service_month'];
        $data['status'] = '1';

        $checkExist = $this->Mportfolio->getDetails('hr_job_salary', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $query = $this->Mportfolio->updatePortfolioDetail('hr_job_salary', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('hr_job_salary', $data);
        }
//        }

        if ($query) {
            echo '1';
            $this->session->set_flashdata('successMsg', "Revise designation saved successfully");
        } else {
            echo '0';
        }
    }

    public function add_revisesalary() {
        $option['emp_id'] = $salary['emp_id'] = $data['emp_id'] = $_POST['employee_id'];
        $get_salary_details = $this->Mportfolio->getDetails('hr_job_salary', $option);
        $salary['ctc_salary'] = $get_salary_details[0]['ctc_salary'];
        $salary['gross_salary'] = $get_salary_details[0]['gross_salary'];
        $salary['salary_incentive'] = $get_salary_details[0]['salary_incentive'];
        $salary['salary_date'] = $get_salary_details[0]['salary_date'];
        $salary['contract_hours'] = $get_salary_details[0]['contract_hours'];
        $salary['payment_hours'] = $get_salary_details[0]['payment_hours'];
        $salary['created_by'] = $this->session->userdata('emp_number');
        $salary['created_at'] = date("Y-m-d H:i:s");
        if ($get_salary_details[0]['ctc_salary'] != '')
            $salary_query = $this->Mportfolio->insertPortfolioDetail('hr_job_salary_revise', $salary);

//        if ($salary_query) {
        $data['ctc_salary'] = $_POST['salary_ctc'];
        $data['gross_salary'] = $_POST['salary_gross'];
        $data['salary_incentive'] = $_POST['salary_incentive'];
        $data['salary_date'] = (isset($_POST['salary_date']) && $_POST['salary_date'] != '') ? date('Y-m-d', strtotime($_POST['salary_date'])) : '';
        $data['contract_hours'] = $_POST['salary_contract'];
        $data['payment_hours'] = $_POST['payment_hours'];

        $checkExist = $this->Mportfolio->getDetails('hr_job_salary', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $query = $this->Mportfolio->updatePortfolioDetail('hr_job_salary', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('hr_job_salary', $data);
        }
//        }

        if ($query) {
            echo '1';
            $this->session->set_flashdata('successMsg', "Revise salary saved successfully");
        } else {
            echo '0';
        }
    }

    public function DT_designation() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'designation',
            2 => 'location',
            3 => 'job_date',
            4 => 'department',
            5 => 'job_type'
        );

        $employee_id = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : '';

        $totalrows = $this->Empuser->getDTDesignationCount($employee_id, $columns, $requestData);
        $query = $this->Empuser->getDTDesignationDetails($requestData['length'], $requestData['start'], $employee_id, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = php72_count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();

            $nestedData[] = '<input type="checkbox" class="chk_box design_chckbox" id="design_chk_box" name="designation_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['job_title'];
            $nestedData[] = $row['location_name'];
            $nestedData[] = $row['job_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($row['job_date'])) : '-';
            $nestedData[] = $row['job_department'];
            $nestedData[] = $row['job_name'];

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

    public function DT_salary() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'gross_salary',
            2 => 'salary_incentive',
            3 => 'salary_date',
            4 => 'contract_hours',
            5 => 'payment_hours',
            6 => 'ctc_salary'
        );

        $employee_id = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : '';

        $totalrows = $this->Empuser->getDTSalaryCount($employee_id, $columns, $requestData);
        $query = $this->Empuser->getDTSalaryDetails($requestData['length'], $requestData['start'], $employee_id, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = php72_count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();

            $nestedData[] = '<input type="checkbox" class="chk_box salary_chckbox" id="salary_chk_box" name="salary_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['gross_salary'];
            $nestedData[] = $row['salary_incentive'];
            $nestedData[] = $row['salary_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($row['salary_date'])) : '-';
            $nestedData[] = $row['contract_hours'];
            $nestedData[] = $row['payment_hours'];
            $nestedData[] = $row['salary_ctc'];

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

    public function deleteUserData() {
        $id = $this->input->post('id');
        $condition = "'" . php72_implode("', '", $id) . "'";
        $table = $_POST['table'];
        $query = $this->Empuser->deleteCommonDetail($table, $condition);

        if ($query) {
            echo '1';
            $this->session->set_flashdata('successMsg', "Record(s) deleted successfully");
        } else {
            echo '0';
        }
    }

    public function contact($id = '') {
        $employee['status'] = $option['status'] = 1;
        $employee['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }

        $emp_id = $this->session->userdata('emp_number');
        $data['employee_detail'] = $this->Mprofile->getDetails('hr_user_login', $emp_id);
        $data['country'] = $this->Empuser->getCommonDetails('hr_country', $option, 'asc', 'country_name');
        $this->load->vars($data);
        $this->load->view('user/profile/contact');
    }

    public function add_emergency($id = '') {
        $employee['status'] = $option['status'] = 1;
        $employee['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }
        $data['country'] = $this->Empuser->getCommonDetails('hr_country', $option, 'asc', 'country_name');

        $this->load->vars($data);
        $this->load->view('user/profile/add_contact');
    }

    public function edit_emergency($id = '') {
        $cond['status'] = $option['status'] = 1;
        $cond['id'] = $id;
        if ($id != '') {
            $data['emergency'] = $this->Empuser->getCommonDetails('hr_user_emergency_contact', $cond);
            $employee['id'] = $data['emergency'][0]['emp_id'];
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }
        $data['country'] = $this->Empuser->getCommonDetails('hr_country', $option, 'asc', 'country_name');
        $data['emp_id'] = $data['emergency'][0]['emp_id'];

        $this->load->vars($data);
        $this->load->view('user/profile/edit_contact');
    }

    public function add_contact() {
        $emp_id = $option['id'] = $e_option['emp_id'] = $emergency['emp_id'] = $_POST['employee_id'];
        $data['address'] = $_POST['user_address'];
        $data['official_email'] = $_POST['work_email'];
        $data['official_mobile'] = $_POST['official_mobile'];
        $data['personal_email'] = $_POST['personal_email'];
        $data['personal_mobile'] = $_POST['personal_mobile'];
        $data['home_mobile'] = $_POST['home_mobile'];
        $data['city'] = $_POST['user_city'];
        $data['state'] = $_POST['user_state'];
        $data['country'] = $_POST['user_country'];
        $data['zipcode'] = $_POST['user_zipcode'];

        $checkExist = $this->Mportfolio->getDetails('hr_user_profile', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $query = $this->Mportfolio->updatePortfolioDetail('hr_user_profile', $data, $option);
        } else {
            $data['created_by'] = $this->session->userdata('emp_number');
            $data['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('hr_user_profile', $data);
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Contact details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/contact/' . $emp_id);
    }

    public function addNew_emergency() {
        if ($_POST['emer_name'] != '') {
            $emergency['emp_id'] = $_POST['employee_id'];
            $emergency['name'] = $_POST['emer_name'];
            $emergency['relationship'] = $_POST['emer_relation'];
            $emergency['email'] = $_POST['emer_email'];
            $emergency['mobile'] = $_POST['emer_mobile'];
            $emergency['official_mobile'] = $_POST['emer_work'];
            $emergency['home_mobile'] = $_POST['emer_home'];

            $emergency['created_by'] = $this->session->userdata('emp_number');
            $emergency['created_at'] = date("Y-m-d H:i:s");
            $query = $this->Mportfolio->insertPortfolioDetail('hr_user_emergency_contact', $emergency);
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Emergency contact details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/contact/' . $_POST['employee_id']);
    }

    public function update_emergency() {
        if ($_POST['emer_name'] != '') {
            $option['id'] = $_POST['emergency_id'];
            $emergency['name'] = $_POST['emer_name'];
            $emergency['relationship'] = $_POST['emer_relation'];
            $emergency['email'] = $_POST['emer_email'];
            $emergency['mobile'] = $_POST['emer_mobile'];
            $emergency['official_mobile'] = $_POST['emer_work'];
            $emergency['home_mobile'] = $_POST['emer_home'];

            $checkExist = $this->Mportfolio->getDetails('hr_user_emergency_contact', $option);
            if (php72_count($checkExist) > 0) {
                $emergency['updated_by'] = $this->session->userdata('emp_number');
                $query = $this->Mportfolio->updatePortfolioDetail('hr_user_emergency_contact', $emergency, $option);
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Emergency contact details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/edit_emergency/' . $_POST['emergency_id']);
    }

    public function DT_emergency() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'relationship',
            3 => 'email',
            4 => 'mobile',
            5 => 'official_mobile',
            6 => 'home_mobile'
        );

        $employee_id = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : '';
        $table = 'hr_user_emergency_contact';
        $totalrows = $this->Empuser->getDTCommonCount($table, $employee_id, $columns, $requestData);
        $query = $this->Empuser->getDTCommonDetails($table, $requestData['length'], $requestData['start'], $employee_id, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = php72_count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();
            $nestedData[] = '<input type="checkbox" class="chk_box" id="contact_chk_box" name="emergency_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = "<a href=" . site_url('user/edit_emergency/' . $row['id']) . " title='" . $row['name'] . "'>" . $row['name'] . "</a>";
            $nestedData[] = $row['relationship'];
            $nestedData[] = $row['email'];
            $nestedData[] = $row['mobile'];
            $nestedData[] = $row['official_mobile'];
            $nestedData[] = $row['home_mobile'];

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

    public function bank($id = '') {
        $employee['status'] = $option['status'] = 1;
        $employee['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }

        $emp_id = $this->session->userdata('emp_number');
        $data['employee_detail'] = $this->Mprofile->getDetails('hr_user_login', $emp_id);
        $data['bank_list'] = $this->Empuser->getBankList('hr_user_bank', $id);

        $this->load->vars($data);
        $this->load->view('user/profile/bank');
    }

    public function add_bank() {
        for ($i = 0; $i < php72_count($_POST['bank_name']); $i++) {
            if ($_POST['bank_name'][$i] != '') {
                $data = array();
                $option['id'] = $_POST['account_id'][$i];
                $data['emp_id'] = $_POST['employee_id'];
                $data['bank_name'] = $_POST['bank_name'][$i];
                $data['account_number'] = $_POST['account_number'][$i];
                $data['branch_name'] = $_POST['branch_name'][$i];
                $data['ifsc_code'] = $_POST['ifsc_code'][$i];

                $checkExist = $this->Mportfolio->getDetails('hr_user_bank', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $query = $this->Mportfolio->updatePortfolioDetail('hr_user_bank', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('hr_user_bank', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Bank details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/bank/' . $_POST['employee_id']);
    }

    public function DT_bank() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'bank_name',
            2 => 'account_number',
            3 => 'branch_name',
            4 => 'ifsc_code'
        );

        $employee_id = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : '';
        $table = 'hr_user_bank';
        $totalrows = $this->Empuser->getDTCommonCount($table, $employee_id, $columns, $requestData);
        $query = $this->Empuser->getDTCommonDetails($table, $requestData['length'], $requestData['start'], $employee_id, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = php72_count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();
            $nestedData[] = '<input type="checkbox" class="chk_box" id="bank_chk_box" name="bank_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['bank_name'];
            $nestedData[] = $row['account_number'];
            $nestedData[] = $row['branch_name'];
            $nestedData[] = $row['ifsc_code'];

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

    public function education($id = '') {
        $employee['status'] = $option['status'] = 1;
        $employee['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }
        $emp_id = $this->session->userdata('emp_number');
        $data['employee_detail'] = $this->Mprofile->getDetails('hr_user_login', $emp_id);

        $this->load->vars($data);
        $this->load->view('user/profile/education');
    }

    public function add_education($id = '') {
        $employee['status'] = $option['status'] = 1;
        $employee['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }

        $this->load->vars($data);
        $this->load->view('user/profile/add_education');
    }

    public function edit_education($id = '') {
        if ($id != '') {
            $data['education'] = $this->Empuser->getEducationDetails('hr_user_education', $id);
            $employee['id'] = $data['education'][0]['emp_id'];
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }
        $data['emp_id'] = $data['education'][0]['emp_id'];

        $this->load->vars($data);
        $this->load->view('user/profile/edit_education');
    }

    function getEducationDegree() {
        $type = $this->input->post('type');
        $degree = $this->Empuser->getQualificationList($type);
        echo json_encode($degree);
    }

    public function submit_education() {
        $emp_id = $data['emp_id'] = $_POST['employee_id'];
        $data['qualification'] = $_POST['edu_graduate'];
        $data['degree'] = $_POST['edu_degree'];
        $data['institute_name'] = $_POST['institute_name'];
        $data['gpa_score'] = $_POST['gpa_score'];
        $data['year_numbers'] = $_POST['edu_years'];
        $data['year_from'] = $_POST['edu_yearfrom'];
        $data['year_to'] = $_POST['edu_yearto'];
        $data['city'] = $_POST['edu_city'];
        $data['state'] = $_POST['edu_state'];
        $data['created_by'] = $this->session->userdata('emp_number');
        $data['created_at'] = date("Y-m-d H:i:s");
        $query = $this->Mportfolio->insertPortfolioDetail('hr_user_education', $data);

        if ($query) {
            $this->session->set_flashdata('successMsg', "Education details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/education/' . $emp_id);
    }

    public function update_education() {
        $option['id'] = $_POST['education_id'];
        $data['qualification'] = $_POST['edu_graduate'];
        $data['degree'] = $_POST['edu_degree'];
        $data['institute_name'] = $_POST['institute_name'];
        $data['gpa_score'] = $_POST['gpa_score'];
        $data['year_numbers'] = $_POST['edu_years'];
        $data['year_from'] = $_POST['edu_yearfrom'];
        $data['year_to'] = $_POST['edu_yearto'];
        $data['city'] = $_POST['edu_city'];
        $data['state'] = $_POST['edu_state'];
        $checkExist = $this->Mportfolio->getDetails('hr_user_education', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $query = $this->Mportfolio->updatePortfolioDetail('hr_user_education', $data, $option);
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Education details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/edit_education/' . $_POST['education_id']);
    }

    public function DT_education() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'qualification_name',
            2 => 'institute_name',
            3 => 'gpa_score',
            4 => 'city',
            5 => 'year_from',
            6 => 'year_numbers'
        );

        $employee_id = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : '';

        $totalrows = $this->Empuser->getDTEducationCount($employee_id, $columns, $requestData);
        $query = $this->Empuser->getDTEducationDetails($requestData['length'], $requestData['start'], $employee_id, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = php72_count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();
            $nestedData[] = '<input type="checkbox" class="chk_box" id="education_chk_box" name="education_id[]" value="' . $row['id'] . '"/>';
            $graduate = '';
            if (php72_cmp($row['qualification']) == 1) {
                $graduate = 'UG';
            } else if (php72_cmp($row['qualification']) == 2) {
                $graduate = 'PG';
            }
            $institute_name = $row['institute_name'];
            $list_qualify = $graduate . ' (' . $row['qualification_name'] . ')';
            $nestedData[] = "<a href=" . site_url('user/edit_education/' . $row['id']) . " title='" . $list_qualify . "'>" . $list_qualify . "</a>";
            $nestedData[] = (strlen($institute_name) > 30) ? substr($institute_name, 0, 30) . ".." : $institute_name;
            $nestedData[] = $row['gpa_score'];
            $city_name = (strlen($row['city']) > 10) ? substr($row['city'], 0, 10) . ".." : $row['city'];
            $state_name = (strlen($row['state']) > 10) ? substr($row['state'], 0, 10) . ".." : $row['state'];
            $get_city = isset($city_name) && $city_name != '' ? $city_name : '-';
            $get_state = isset($state_name) && $state_name != '' ? $state_name : '-';
            $nestedData[] = $get_city . '/' . $get_state;
            $nestedData[] = $row['year_from'] . '-' . $row['year_to'];
            $nestedData[] = $row['year_numbers'];

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

    public function dependents($id = '') {
        $employee['status'] = $option['status'] = 1;
        $employee['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }
        $emp_id = $this->session->userdata('emp_number');
        $data['employee_detail'] = $this->Mprofile->getDetails('hr_user_login', $emp_id);
        $data['dependent_list'] = $this->Empuser->getDependentList('hr_user_dependents', $id);

        $this->load->vars($data);
        $this->load->view('user/profile/dependents');
    }

    public function add_dependents() {

        for ($i = 0; $i < php72_count($_POST['dependent_name']); $i++) {
            if ($_POST['dependent_name'][$i] != '') {
                $data = array();
                $option['id'] = $_POST['dept_id'][$i];
                $data['emp_id'] = $_POST['employee_id'];
                $data['name'] = $_POST['dependent_name'][$i];
                $data['relationship'] = $_POST['dependent_relation'][$i];
                $data['birth_date'] = (isset($_POST['dependent_birth'][$i]) && $_POST['dependent_birth'][$i] != '') ? date('Y-m-d', strtotime($_POST['dependent_birth'][$i])) : '';

                $checkExist = $this->Mportfolio->getDetails('hr_user_dependents', $option);
                if (php72_count($checkExist) > 0) {
                    $data['updated_by'] = $this->session->userdata('emp_number');
                    $query = $this->Mportfolio->updatePortfolioDetail('hr_user_dependents', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('hr_user_dependents', $data);
                }
            }
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Dependents details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/dependents/' . $_POST['employee_id']);
    }

    public function DT_dependents() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'relationship',
            3 => 'birth_date'
        );

        $employee_id = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : '';
        $table = 'hr_user_dependents';
        $totalrows = $this->Empuser->getDTCommonCount($table, $employee_id, $columns, $requestData);
        $query = $this->Empuser->getDTCommonDetails($table, $requestData['length'], $requestData['start'], $employee_id, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = php72_count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();
            $relation = array('1' => 'Father', '2' => 'Mother', '3' => 'Spouse', '4' => 'Child');
            $nestedData[] = '<input type="checkbox" class="chk_box" id="depent_chk_box" name="depent_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['name'];
            $nestedData[] = $relation[$row['relationship']];
            $nestedData[] = (isset($row['birth_date']) && $row['birth_date'] != '0000-00-00 00:00:00') ? date('d-m-y', strtotime($row['birth_date'])) : '-';

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

    public function immigration($id = '') {
        $employee['status'] = $option['status'] = 1;
        $employee['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }

        $emp_id = $this->session->userdata('emp_number');
        $data['employee_detail'] = $this->Mprofile->getDetails('hr_user_login', $emp_id);
        $data['country'] = $this->Empuser->getCommonDetails('hr_country', $option, 'asc', 'country_name');

        $this->load->vars($data);
        $this->load->view('user/profile/immigration');
    }

    public function add_immigration($id = '') {
        $employee['status'] = $option['status'] = 1;
        $employee['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }
        $data['country'] = $this->Empuser->getCommonDetails('hr_country', $option, 'asc', 'country_name');

        $this->load->vars($data);
        $this->load->view('user/profile/add_immigration');
    }

    public function edit_immigration($id = '') {
        $cond['status'] = $option['status'] = 1;
        $cond['id'] = $id;
        if ($id != '') {
            $data['immigration'] = $this->Empuser->getCommonDetails('hr_user_immigration', $cond);
            $employee['id'] = $data['immigration'][0]['emp_id'];
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }
        $data['country'] = $this->Empuser->getCommonDetails('hr_country', $option, 'asc', 'country_name');
        $data['emp_id'] = $data['immigration'][0]['emp_id'];

        $this->load->vars($data);
        $this->load->view('user/profile/edit_immigration');
    }

    public function addNew_immigration() {
        $emp_id = $data['emp_id'] = $_POST['employee_id'];
        $data['citizenship'] = $_POST['img_country'];
        $data['passport_number'] = $_POST['pass_number'];
        $data['passport_issue_date'] = (isset($_POST['pass_issue_date']) && $_POST['pass_issue_date'] != '') ? date('Y-m-d', strtotime($_POST['pass_issue_date'])) : '';
        $data['passport_expiry_date'] = (isset($_POST['pass_expiry']) && $_POST['pass_expiry'] != '') ? date('Y-m-d', strtotime($_POST['pass_expiry'])) : '';
        $data['visa_type'] = $_POST['visa_type'];
        $data['visa_number'] = $_POST['visa_number'];
        $data['visa_issue_date'] = (isset($_POST['visa_issue_date']) && $_POST['visa_issue_date'] != '') ? date('Y-m-d', strtotime($_POST['visa_issue_date'])) : '';
        $data['visa_expiry_date'] = (isset($_POST['visa_expiry']) && $_POST['visa_expiry'] != '') ? date('Y-m-d', strtotime($_POST['visa_expiry'])) : '';
        $data['img_comments'] = $_POST['img_comments'];
        $data['created_by'] = $this->session->userdata('emp_number');
        $data['created_at'] = date("Y-m-d H:i:s");
        $query = $this->Mportfolio->insertPortfolioDetail('hr_user_immigration', $data);

        if ($query) {
            $this->session->set_flashdata('successMsg', "Immigration details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/immigration/' . $emp_id);
    }

    public function update_immigration() {
        $option['id'] = $_POST['immigration_id'];
        $data['citizenship'] = $_POST['img_country'];
        $data['passport_number'] = $_POST['pass_number'];
        $data['passport_issue_date'] = (isset($_POST['pass_issue_date']) && $_POST['pass_issue_date'] != '') ? date('Y-m-d', strtotime($_POST['pass_issue_date'])) : '';
        $data['passport_expiry_date'] = (isset($_POST['pass_expiry']) && $_POST['pass_expiry'] != '') ? date('Y-m-d', strtotime($_POST['pass_expiry'])) : '';
        $data['visa_type'] = $_POST['visa_type'];
        $data['visa_number'] = $_POST['visa_number'];
        $data['visa_issue_date'] = (isset($_POST['visa_issue_date']) && $_POST['visa_issue_date'] != '') ? date('Y-m-d', strtotime($_POST['visa_issue_date'])) : '';
        $data['visa_expiry_date'] = (isset($_POST['visa_expiry']) && $_POST['visa_expiry'] != '') ? date('Y-m-d', strtotime($_POST['visa_expiry'])) : '';
        $data['img_comments'] = $_POST['img_comments'];
        $checkExist = $this->Mportfolio->getDetails('hr_user_immigration', $option);
        if (php72_count($checkExist) > 0) {
            $data['updated_by'] = $this->session->userdata('emp_number');
            $query = $this->Mportfolio->updatePortfolioDetail('hr_user_immigration', $data, $option);
        }

        if ($query) {
            $this->session->set_flashdata('successMsg', "Immigration details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/edit_immigration/' . $_POST['immigration_id']);
    }

    public function DT_immigration() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'passport_number',
            2 => 'passport_issue_date',
            3 => 'passport_expiry_date',
            4 => 'visa_type',
            5 => 'visa_number',
            6 => 'visa_issue_date',
            7 => 'visa_expiry_date',
            8 => 'citizenship',
            9 => 'img_comments'
        );

        $employee_id = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : '';

        $totalrows = $this->Empuser->getDTImmigrationCount($employee_id, $columns, $requestData);
        $query = $this->Empuser->getDTImmigrationDetails($requestData['length'], $requestData['start'], $employee_id, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = php72_count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();
            $nestedData[] = '<input type="checkbox" class="chk_box" id="immigration_chk_box" name="immigration_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = "<a href=" . site_url('user/edit_immigration/' . $row['id']) . " title='" . $row['passport_number'] . "'>" . $row['passport_number'] . "</a>";
            $nestedData[] = $row['passport_issue_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($row['passport_issue_date'])) : '-';
            $nestedData[] = $row['passport_expiry_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($row['passport_expiry_date'])) : '-';
            $nestedData[] = $row['visa_type'];
            $nestedData[] = $row['visa_number'];
            $nestedData[] = $row['visa_issue_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($row['visa_issue_date'])) : '-';
            $nestedData[] = $row['visa_expiry_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($row['visa_expiry_date'])) : '-';
            $nestedData[] = $row['country_name'];
            $nestedData[] = $row['img_comments'];

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

    public function reporting($id = '') {
        $employee['status'] = $option['status'] = 1;
        $employee['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }
//        $data['employee_list'] = $this->Empuser->getCommonDetails('hr_user_profile', $option, 'asc', 'emp_name');

        $emp_id = $this->session->userdata('emp_number');
        $data['employee_detail'] = $this->Mprofile->getDetails('hr_user_login', $emp_id);
        $data['employee_list'] = $this->Empuser->getReportingEmployee($id);
        $data['supervisor_list'] = $this->Empuser->getReportingList('hr_user_reporting', $id, 'report_subordinate', 'report_supervisor');
        $data['subordinate_list'] = $this->Empuser->getReportingList('hr_user_reporting', $id, 'report_supervisor', 'report_subordinate');

        $this->load->vars($data);
        $this->load->view('user/profile/reporting');
    }

    public function add_reporting() {
        $emp_id = $_POST['employee_id'];
        if (php72_cmp($_POST['report_to']) == 1) {
            $data['report_supervisor'] = $_POST['employee_id'];
            $data['report_subordinate'] = $_POST['report_employee'];
        } else if (php72_cmp($_POST['report_to']) == 2) {
            $data['report_supervisor'] = $_POST['report_employee'];
            $data['report_subordinate'] = $_POST['employee_id'];
        }

        $data['report_method'] = $_POST['report_method'];
        $data['created_by'] = $this->session->userdata('emp_number');
        $data['created_at'] = date("Y-m-d H:i:s");
        $query = $this->Mportfolio->insertPortfolioDetail('hr_user_reporting', $data);

        if ($query) {
            $this->session->set_flashdata('successMsg', "Reporting details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('user/reporting/' . $emp_id);
    }

    public function add_supervisor() {
        for ($i = 0; $i < php72_count($_POST['supervisor_employee']); $i++) {
            if ($_POST['supervisor_employee'][$i] != '') {
                $data = array();
                $option['id'] = $_POST['report_sup'][$i];
                $data['report_supervisor'] = $_POST['employee_id'];
                $data['report_subordinate'] = $_POST['supervisor_employee'][$i];
                $data['report_method'] = $_POST['supervisor_method'][$i];

                $checkExist = $this->Mportfolio->getDetails('hr_user_reporting', $option);
                if (php72_count($checkExist) > 0) {
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
        for ($i = 0; $i < php72_count($_POST['subordinate_employee']); $i++) {
            if ($_POST['subordinate_employee'][$i] != '') {
                $data = array();
                $option['id'] = $_POST['report_subor'][$i];
                $data['report_subordinate'] = $_POST['employee_id'];
                $data['report_supervisor'] = $_POST['subordinate_employee'][$i];
                $data['report_method'] = $_POST['subordinate_method'][$i];

                $checkExist = $this->Mportfolio->getDetails('hr_user_reporting', $option);
                if (php72_count($checkExist) > 0) {
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

    public function DT_supervisor() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'report_supervisor',
            2 => 'emp_name',
            3 => 'report_method'
        );

        $employee_id = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : '';

        $totalrows = $this->Empuser->getDTReportingCount($employee_id, $columns, $requestData, 'report_supervisor', 'report_subordinate');
        $query = $this->Empuser->getDTReportingDetails($requestData['length'], $requestData['start'], $employee_id, $columns, $requestData, 'report_supervisor', 'report_subordinate');
        $totalFiltered = $totalrows;
        $totalData = php72_count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();
            $nestedData[] = '<input type="checkbox" class="chk_box supervisor_chkbox" id="supervisor_chk_box" name="supervisor_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['report_subordinate'];
            $nestedData[] = $row['emp_name'];
            if (php72_cmp($row['report_method']) == 1) {
                $report_method = 'Direct';
            } else {
                $report_method = 'Indirect';
            }
            $nestedData[] = $report_method;

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

    public function DT_subordinate() {
        $requestData = $_POST;

        $columns = array(
            0 => 'id',
            1 => 'report_subordinate',
            2 => 'emp_name',
            3 => 'report_method'
        );

        $employee_id = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : '';

        $totalrows = $this->Empuser->getDTReportingCount($employee_id, $columns, $requestData, 'report_subordinate', 'report_supervisor');
        $query = $this->Empuser->getDTReportingDetails($requestData['length'], $requestData['start'], $employee_id, $columns, $requestData, 'report_subordinate', 'report_supervisor');
        $totalFiltered = $totalrows;
        $totalData = php72_count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();
            $nestedData[] = '<input type="checkbox" class="chk_box subordinate_chkbox" id="subordinate_chk_box" name="subordinate_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['report_supervisor'];
            $nestedData[] = $row['emp_name'];
            if (php72_cmp($row['report_method']) == 1) {
                $report_method = 'Direct';
            } else {
                $report_method = 'Indirect';
            }
            $nestedData[] = $report_method;

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

    public function user_setup() {

        $this->load->model('user/Common_model');
        $data['usersList'] = array();
        if ($this->session->userdata('user_type') == 'superadmin') {
            $data['admin_status'] = false;
        } else {
            $data['admin_status'] = true;
            $data['partner_id'] = $this->session->userdata('partner_id');
            #$data['usersList'] = $usersList = $this->Common_model->getUsersList_sa($this->session->userdata('partner_id'));
            $data['userSetup'] = $this->Common_model->getUserSetup($this->session->userdata('partner_id'));
        }
        $data['branch'] = $this->Common_model->get_all_details('hr_partner_type', array('status' => '1'), array());
        $data['stage_efficiency'] = $this->Common_model->get_all_details('stagefficiency', array(), array());

        $this->load->view('user/profile/user_setup', $data);
    }
	
	public function assign_an_user() {
		
		$branch = 1;
        $this->load->model('user/Common_model');
		$users = $this->Common_model->getUsersList_sa($branch);
		$data['users'] =$users;
		$data['get_user_data'] = $this->Common_model->get_all_details('an_assign_user', array(), array());
        $this->load->view('user/profile/assign_an_user', $data);
    }
	public function insertEdit_an_assign_users() {
		
		$lessthan_3 = $this->input->post('lessthan_3');
		$above_3 = $this->input->post('above_3');
		$above_ten_lakhs = $this->input->post('above_ten_lakhs');
		 
		if($lessthan_3!='' && $lessthan_3!=''){
			$this->Mprofile->update_data('an_assign_user',array('below_three_lakhs' => $lessthan_3,'above_three_lakhs' => $above_3,'above_ten_lakhs' => $above_ten_lakhs), array('id' => 1));
		}
        $this->session->set_flashdata('successMsg', "Record saved successfully");
        redirect('user/assign_an_user');
    }
	

    public function insertEdit_usersetup() {
        $this->load->model('user/Common_model');
        $result = $this->Common_model->insertUserSetup($_POST);
        $this->session->set_flashdata('successMsg', "Record saved successfully");
        redirect('user/user_setup');
    }

    function user_setup_sa() {
        $this->load->model('user/Common_model');
        $branch = $this->input->post('branch');
        $users = $this->Common_model->getUsersList_sa($branch);
        #echo'<pre>';print_r($users);die;
        $default = $this->Common_model->getUserSetup($branch);
        $defaultval = array();
        if (!empty($default)) {
            $defaultval = $default;
        }
        echo json_encode(array('users' => $users, 'defaultt' => $defaultval));
    }

    public function document($id = '') {
        $employee['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $employee);
        }

        $emp_id = $this->session->userdata('emp_number');
        $data['employee_detail'] = $this->Mprofile->getDetails('hr_user_login', $emp_id);
        $funder_id = $this->uri->segment(3);

        if ($funder_id != '') {
            $conditions = array('emp_id' => $funder_id);
            $join[0]['select'] = "emp.emp_first_name,emp.emp_last_name";
            $join[0]['table'] = 'hr_user_profile as emp';
            $join[0]['condition'] = "hr_user_document.uploaded_by = emp.id";
            $join[0]['type'] = "LEFT";
            
            $getFunderDoc = $this->Mprofile->get_all_details('hr_user_document', $conditions, array('hr_user_document.id', 'description', 'emp_id', 'file_name', 'created_date', 'updated_date'), '', '',array('created_date'=>'desc'), '', '', $join, '');
            
            if (!empty($getFunderDoc)) {
                $data['funder_document'] = $getFunderDoc;
            }
            $data['user_name'] = $getFunderDoc[0]->emp_first_name . ' ' . $getFunderDoc[0]->emp_last_name;

            $updated_date_doc = date('d-m-Y', strtotime($getFunderDoc[0]->created_date));
            if (isset($getFunderDoc[0]->updated_date) && $getFunderDoc[0]->updated_date != '') {
                if (php72_cmp($getFunderDoc[0]->updated_date) > 0) {
                    $updated_date_doc = date('d-m-Y', strtotime($getFunderDoc[0]->updated_date));
                }
            }
            
            $data['updated_date_doc'] = $updated_date_doc;
            $this->load->view('user/profile/edit_document', $data);
        } else {
            $this->setErrorMessage('error', 'Record(s) not found');
            $this->load->view('user/profile/edit_document', $data);
        }
    }

    public function editFunder_Documents() {

        $description = $this->input->post('description');
        $document_id = $this->input->post('document_id');
        $funder_id = $this->input->post('funder_id');
        $condition = $file_dataArr = array();
        $user_id = $this->session->userdata('emp_number');

    //$updatedName = $this->getAuthorization();
        if (!empty($description)) {

            $config['overwrite'] = FALSE;
            $config['allowed_types'] = 'doc|docx|ppt|pptx|pdf|xls|xlsx|jpg|jpeg';
            $config['max_size'] = 10485760;
            $config['upload_path'] = './uploads/profile_document/';
            $this->load->library('upload', $config);
            $doc_id = '';
            $countErr = 0;
            for ($i = 0; $i < php72_count($description); $i++) {

                $Check_fname = php72_array_values($_FILES['file_upload']['name'][$i])[0];
                $Check_description_val = php72_array_values($description[$i])[0];
                $countErr++;
                if (!empty($_FILES['file_upload'])) {
                    if (php72_count($_FILES['file_upload']['name']) > 0) {
                        $fname = php72_array_values($_FILES['file_upload']['name'][$i])[0];
                        $description_val = php72_array_values($description[$i])[0];

                        $file_dataArr = array();
                        if (isset($fname) && $fname != '') {
                            $fileType = pathinfo($fname, PATHINFO_EXTENSION);
                            //$file_name = uniqid(md5($fName . '' . time())) . '.' . $fileType;
							$rename_file = str_replace(' ', '_', strtolower($fname));
							$new_name = preg_replace('/[^A-Za-z0-9.\_]/', '', $rename_file);
							$file_name = date('Ymdhis') . '_' . $new_name;

                            $_FILES['images[]']['name'] = $file_name;
                            $_FILES['images[]']['type'] = $file_type = php72_array_values($_FILES['file_upload']['type'][$i])[0];
                            $_FILES['images[]']['tmp_name'] = php72_array_values($_FILES['file_upload']['tmp_name'][$i])[0];
                            $_FILES['images[]']['error'] = php72_array_values($_FILES['file_upload']['error'][$i])[0];
                            $_FILES['images[]']['size'] = php72_array_values($_FILES['file_upload']['size'][$i])[0];

                            @copy(php72_array_values($_FILES['file_upload']['tmp_name'][$i])[0], "uploads/profile_document/" . $file_name);
                            $fileName = $file_name;
                            $images[] = $file_name;
                            $filenameArr[] = $file_name;
							$file_dataArr = array(
								'file_name' => $fileName,
								'status' => 1, 'file_type' => $file_type
							);
							
                            /* $this->upload->initialize($config);
                            if ($this->upload->do_upload('images[]')) {
                                $uploaded = $this->upload->data();
                                $file_dataArr = array(
                                    'file_name' => $fileName,
                                    'status' => 1, 'file_type' => $file_type
                                );
                            } else {
                                $logoDetails = $this->upload->display_errors();
                            } */
                                #die;
                        } //endif isset fnamme
                    } //count filesname
                } // empty if files upload

                $dataArr = array();
                $document_Ids = $document_id[$i];

                if ($document_Ids != '') {#update
                    $condition = array('id' => $document_Ids);
                    $dataArr = array('description' => $description_val, 'uploaded_by' => $user_id, 'emp_id' => $funder_id, 'updated_by' => $user_id, 'updated_date' => date('Y-m-d H:i:s'));
                    $dataArr = array_merge_recursive($dataArr, $file_dataArr);
                    $get_funderDoc = $this->Mprofile->get_all_details('hr_user_document', $condition, array('file_name'));

                    if (!empty($file_dataArr)) {
                        if (isset($get_funderDoc[0]->file_name) && $get_funderDoc[0]->file_name != '') {
                            unlink('uploads/profile_document/' . $get_funderDoc[0]->file_name);
                        }
                    }
                     //echo'<pre>';print_r( $condition);exit();
                    $this->Mprofile->update_data('hr_user_document', $dataArr,$condition);
                } else {#Insert
                    //echo $Check_fname;die;
                    if ($Check_fname != '' || $Check_description_val != '') {
                        $dataArr = array(
                            'description' => $description_val, 'emp_id' => $funder_id, 'uploaded_by' => $user_id,
                            'created_date' => date('Y-m-d H:i:s'), 'created_by' => '$user_id'
                        );
                        //echo $Check_fname;die;
                        $dataArr = array_merge_recursive($dataArr, $file_dataArr);
                        $this->Mprofile->insert_data('hr_user_document', $dataArr);
                    }
                }
            }
        }
        //print_r($countErr);die;
        if ($countErr > 0) {
            $this->session->set_flashdata('successMsg', "Documents details saved successfully");
            redirect('user/document/' . $funder_id);
        } else {

        }
        redirect('user/document/' . $funder_id);
    }

     function ajax_common_delete() { #error_reporting(-1);

        $returnArr['status'] = '0';
        $common_id = $this->input->post('common_id');
        $formType = $this->input->post('formType');
        $grant_id = $this->input->post('grant_id');
        $common_id = array_values(php72_array_filter($common_id));
        if (!empty($common_id) && $formType != '') {

            $condition = array('id' => $common_id);
            if ($formType == 'hr_user_document') {
                $table_name = 'hr_user_document';
                $condition = array('id' => $common_id);
				$get_file_names = $this->Mprofile->get_document_details('hr_user_document', $common_id);
                foreach ($get_file_names as $lists) {
                    if ($lists->file_name != '') {
                        unlink('uploads/profile_document/' . $lists->file_name);
                    }
                }
            } 
            $this->Mprofile->delete_data_in($table_name, $condition);
            $returnArr['status'] = '1';
        }
        $this->session->set_flashdata('successMsg', "Documents details deleted successfully");
        $returnArr['response'] = 'Record(s) Deleted successfully';
        $output = json_encode($returnArr);
        echo $output;
        exit;
    }

    function ajax_delete_funder_document() { 

        $id = $this->input->post('id');
        //echo'<pre>';print_r($id);die;
        $returnArr['status'] = '0';
        if ($id != '') {
            $get_file_names = $this->Mprofile->get_all_details('hr_user_document', array('id' => $id), array('file_name'));
            //echo'<pre>';print_r($get_file_names);die;
            if (!empty($get_file_names)) {
                unlink('uploads/profile_document/' . $get_file_names[0]->file_name);
                $this->Mprofile->update_data('hr_user_document',array('file_name' => ''), array('id' => $id));
                $returnArr['status'] = '1';
            }
        }
        $this->session->set_flashdata('successMsg', "Document deleted successfully");
        echo json_encode($returnArr);
    }

    public function add_document() {

        //$emp_id = $_POST['employee_id'];
        $emp_id = $this->input->post('employee_id');
        $user_id = $this->session->userdata('emp_number');

        $insertData = [];
        if(!empty($_POST)){        

            for($i=0;$i<php72_count($_POST['description']);$i++){
             /* Checking file for upload*/

             if(!empty($_FILES['file_upload']['name'][$i])){


                    //print_r('hel');exit();
                if($_POST['doc_id']!=""){

                    $file_data = $this->upload_files($i,'update');
                    //echo '<pre>'; print_r($file_data);exit;
                    if($file_data['status'] == true){
                        $insertData['document']= $file_data['file_name'];
                        $insertData['file_type']=$file_data['file_type'];
                    }

                }else{
                    $file_data = $this->upload_files($i,'insert');
                    //echo '<pre>'; print_r($file_data);exit;
                    if($file_data['status'] == true){
                        $insertData['document']= $file_data['file_name'];
                        $insertData['file_type']=$file_data['file_type'];
                    }
                }

            }

            /* other datas */
            if(empty($_POST['doc_id'])){
                $insertData['emp_id'] = $emp_id;
                $insertData['description'] = $_POST['description'][$i][0];
                $insertData['status'] = 1;
                $insertData['created_at'] = date('Y-m-d H:i:s');
                $insertData['created_by'] = $user_id;
                $insertData['updated_at'] = date('Y-m-d H:i:s');
                $insertData['updated_by'] = $user_id;

                $arrayData[]= $insertData;
            }else{

                $insertData['emp_id'] = $emp_id;
                $insertData['description'] = $_POST['description'][$i][0];
                $insertData['status'] = 1;
                $insertData['updated_at'] = date('Y-m-d H:i:s');
                $insertData['updated_by'] = $user_id;
                $arrayData[]= $insertData;
            }  
                //echo'<pre>';print_r($arrayData);exit();          
            if(!empty($arrayData) && empty($_POST['doc_id'][$i])){
                $this->db->insert_batch('hr_user_document',$arrayData);
                $this->session->set_flashdata('successMsg', "Documents details saved successfully");
            }else{
                $this->Mprofile->updatePortfolioDetail('hr_user_document', $arrayData[$i], $_POST['doc_id'][$i]);
                $this->session->set_flashdata('successMsg', "Documents details saved successfully");
            }
        }/* for loop ends */
        redirect('user/document/'. $emp_id);
    }
}

public function upload_files($i,$type=""){

        //print_r($i);//exit();
    $file_data = [];
    $config['overwrite'] = FALSE;
    $config['allowed_types'] = 'doc|docx|ppt|pptx|pdf|xls|xlsx';
    $config['max_size'] = 10485760;
    $config['upload_path'] = './uploads/profile_document/';
    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    if($type=='update'){
        $_FILES['file']['name']     = $_FILES['file_upload']['name'][$i][0]; 
        $_FILES['file']['type']     = $_FILES['file_upload']['type'][$i][0]; 
        $_FILES['file']['tmp_name'] = $_FILES['file_upload']['tmp_name'][$i][0]; 
        $_FILES['file']['error']     = $_FILES['file_upload']['error'][$i][0]; 
        $_FILES['file']['size']     = $_FILES['file_upload']['size'][$i][0]; 

    }else{
     $_FILES['file']['name']     = $_FILES['file_upload']['name'][$i]; 
     $_FILES['file']['type']     = $_FILES['file_upload']['type'][$i]; 
     $_FILES['file']['tmp_name'] = $_FILES['file_upload']['tmp_name'][$i]; 
     $_FILES['file']['error']     = $_FILES['file_upload']['error'][$i]; 
     $_FILES['file']['size']     = $_FILES['file_upload']['size'][$i]; 
 }

 $fileType = pathinfo( $_FILES['file']['name'] , PATHINFO_EXTENSION);

        //echo'<pre>';print_r($_FILES);exit();
 if ($this->upload->do_upload('file')) {

   $file_data = $this->upload->data(); 
   $file_data['file_type'] = $fileType;
   $file_data['status']= true;                
}else{
         //echo '<pre>'; print_r($this->upload->display_errors());exit;
  $file_data['status']= false;
}

return $file_data;
}


public function change_status_emp() {
    $data = [
        [
            "Name" => "Vijay  Rangarajan",
            "partner_id" => 1,
            "emp_dob" => "2/17/1983",
            "official_email" => "",
            "Status" => "Exit"
        ],
        [
            "Name" => "Subalakshmi  T.R",
            "partner_id" => 1,
            "emp_dob" => "10-04-1983",
            "official_email" => "suba@villgro.org",
            "Status" => "Exit"
        ],
        [
            "Name" => "Ashish  Thekkekara",
            "partner_id" => 1,
            "emp_dob" => "09-07-1985",
            "official_email" => "ashish@villgro.org",
            "Status" => "Exit"
        ],
        [
            "Name" => "Chakravarthy  A.B",
            "partner_id" => 1,
            "emp_dob" => "04-03-1985",
            "official_email" => "",
            "Status" => "Exit"
        ],
        [
            "Name" => "Deepti  Arya",
            "partner_id" => 1,
            "emp_dob" => "07-12-1985",
            "official_email" => "deepti@villgro.org",
            "Status" => "Exit"
        ],
        [
            "Name" => "Garima  Jyoti",
            "partner_id" => 1,
            "emp_dob" => "11-04-1983",
            "official_email" => "garima@villgro.org",
            "Status" => "Exit"
        ],
        [
            "Name" => "Rajat  Das",
            "partner_id" => 1,
            "emp_dob" => "1/26/1986",
            "official_email" => "",
            "Status" => "Exit"
        ],
        [
            "Name" => "Reihem  Roy",
            "partner_id" => 1,
            "emp_dob" => "8/20/1985",
            "official_email" => "reihem@villgro.org",
            "Status" => "Exit"
        ],
        [
            "Name" => "Sabyasachi  Das",
            "partner_id" => 1,
            "emp_dob" => "8/15/1986",
            "official_email" => "sabyasachi@villgro.org",
            "Status" => "Exit"
        ],
        [
            "Name" => "Bala Gangadhar  Godina",
            "partner_id" => 1,
            "emp_dob" => "5/15/1979",
            "official_email" => "balagangadhar@villgro.org",
            "Status" => "Exit"
        ],
        [
            "Name" => "Rahimunnisa  H",
            "partner_id" => 1,
            "emp_dob" => "9/21/1987",
            "official_email" => "nisha@villgro.org",
            "Status" => "Exit"
        ],
		
				  [
					"Name"=> "Ruchita  De",
					"partner_id"=> 1,
					"emp_dob"=> "11-01-1987",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ranjit  Koshi",
					"partner_id"=> 1,
					"emp_dob"=> "11/28/1983",
					"official_email"=> "ranjitk@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sathish Kumar V",
					"partner_id"=> 1,
					"emp_dob"=> "3/19/1988",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Monika  Khullar",
					"partner_id"=> 1,
					"emp_dob"=> "9/13/1985",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Priya Darshini  Rajesh",
					"partner_id"=> 1,
					"emp_dob"=> "10/26/1979",
					"official_email"=> "priya@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Krupa  Ventrapati",
					"partner_id"=> 1,
					"emp_dob"=> "4/15/1983",
					"official_email"=> "krupa@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rajeev Suresh Surana",
					"partner_id"=> 1,
					"emp_dob"=> "03-05-1974",
					"official_email"=> "rajeev@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Prabhakaran  R",
					"partner_id"=> 1,
					"emp_dob"=> "06-12-1987",
					"official_email"=> "prabhakar@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Murugan M",
					"partner_id"=> 1,
					"emp_dob"=> "4/26/1980",
					"official_email"=> "murugan.m@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Sucharita  Kamath",
					"partner_id"=> 1,
					"emp_dob"=> "9/19/1972",
					"official_email"=> "sucharita@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Joseph  Thomas",
					"partner_id"=> 1,
					"emp_dob"=> "3/17/1961",
					"official_email"=> "joseph@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Siddharth  Venkataraman",
					"partner_id"=> 1,
					"emp_dob"=> "4/13/1983",
					"official_email"=> "siddharth@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Michelle Maria Abraham",
					"partner_id"=> 1,
					"emp_dob"=> "3/25/1983",
					"official_email"=> "michelle@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Jeanne  Chen",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Mayank  Jaiswal",
					"partner_id"=> 1,
					"emp_dob"=> "02-06-1978",
					"official_email"=> "mayank@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Paul  Basil",
					"partner_id"=> 1,
					"emp_dob"=> "4/18/1969",
					"official_email"=> "paul@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Lenin  S",
					"partner_id"=> 1,
					"emp_dob"=> "2/26/1986",
					"official_email"=> "lenin@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ambika  Sambasivan",
					"partner_id"=> 1,
					"emp_dob"=> "10-02-1983",
					"official_email"=> "ambika@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "James  Rajanayagam",
					"partner_id"=> 1,
					"emp_dob"=> "08-05-1971",
					"official_email"=> "james@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Kumar  UM",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Kumud  Ranjan",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sutanu Sankha Ghosh",
					"partner_id"=> 1,
					"emp_dob"=> "5/28/1987",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Divaker  J",
					"partner_id"=> 1,
					"emp_dob"=> "9/28/2010",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Zubaida  Bai",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Zubaida  Bai",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Zubaida  Bai",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Thyagarajan  Thyagarajan",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Arun  Shrma",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Tariq  Ali",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Dimple  sharma",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Bharat  Varshney",
					"partner_id"=> 1,
					"emp_dob"=> "11/25/1984",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Robert Hudson Ashodian Moore",
					"partner_id"=> 1,
					"emp_dob"=> "1/17/1987",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shveta  Suneja",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Yeshesvini  Chandar",
					"partner_id"=> 1,
					"emp_dob"=> "03-10-1983",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "John R.E Mixon",
					"partner_id"=> 1,
					"emp_dob"=> "03-07-1975",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Jessica  Liu",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Prabhu  Prabhu",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Alexander  Alexander",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Geetha  Geetha",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Bhuvaneswari  Bhuvaneswari",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Gautam  Prateek",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Karthik  R",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ashutosh  Sinha",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "ashutosh@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Avinash  Baskar",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sarah  Hermes",
					"partner_id"=> 1,
					"emp_dob"=> "8/21/1990",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Poornima Rachel Padmanabhan",
					"partner_id"=> 1,
					"emp_dob"=> "01-11-1990",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Swetha  Krishnakumar",
					"partner_id"=> 1,
					"emp_dob"=> "12/18/1988",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Alvaro Illanas Cerezo",
					"partner_id"=> 1,
					"emp_dob"=> "06-07-1988",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Himanshu  Kumar",
					"partner_id"=> 1,
					"emp_dob"=> "08-03-1983",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Satish Suman Behera",
					"partner_id"=> 1,
					"emp_dob"=> "2/23/1986",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Deepika  Chandrasekaran",
					"partner_id"=> 1,
					"emp_dob"=> "9/29/1989",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Nivedita  Pandey",
					"partner_id"=> 1,
					"emp_dob"=> "03-11-1984",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rajnish  Kumar",
					"partner_id"=> 1,
					"emp_dob"=> "01-02-1984",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Arne  Sanne",
					"partner_id"=> 1,
					"emp_dob"=> "11-09-1983",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sridevi  Prasanna",
					"partner_id"=> 1,
					"emp_dob"=> "12/23/1986",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Gaurav  Gupta",
					"partner_id"=> 1,
					"emp_dob"=> "04-10-1991",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Nagesh  Yelamanchili",
					"partner_id"=> 1,
					"emp_dob"=> "06-06-1991",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Pragya  Thakur",
					"partner_id"=> 1,
					"emp_dob"=> "06-10-1982",
					"official_email"=> "pragya@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Angela  Kagume",
					"partner_id"=> 1,
					"emp_dob"=> "11-12-1983",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Krithika  Narayanan",
					"partner_id"=> 1,
					"emp_dob"=> "04-04-1987",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Emily  Paarmann",
					"partner_id"=> 1,
					"emp_dob"=> "02-06-1986",
					"official_email"=> "emily@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Caitlin  Marinelli",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "caitlin@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Neel  Shah",
					"partner_id"=> 1,
					"emp_dob"=> "7/22/1986",
					"official_email"=> "neel@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Swetha  Krishnakumar",
					"partner_id"=> 1,
					"emp_dob"=> "12/18/1988",
					"official_email"=> "swetha@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Nilima  Achwal",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "nilima@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shrey  Goyal",
					"partner_id"=> 1,
					"emp_dob"=> "01-07-1989",
					"official_email"=> "shrey@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Josep  Borras",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "josep@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ashish  Sinha",
					"partner_id"=> 1,
					"emp_dob"=> "09-05-1977",
					"official_email"=> "ashish.sinha@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Lance Joseph Casey",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "lance@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Hanu  Kiran",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "hanukiran@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Palamadai R Ganapathy",
					"partner_id"=> 1,
					"emp_dob"=> "11/19/1970",
					"official_email"=> "ganapathy@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Preethi  Nair",
					"partner_id"=> 1,
					"emp_dob"=> "9/29/1985",
					"official_email"=> "preethi@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Krithika  Narayanan",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ramya  Chellapandian",
					"partner_id"=> 1,
					"emp_dob"=> "10-12-1985",
					"official_email"=> "ramya@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Thomas  Pullenkav",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Jessica  Seddon",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Mukesh  Sharma",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "mukesh@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Aparna  Ram",
					"partner_id"=> 1,
					"emp_dob"=> "11-02-1978",
					"official_email"=> "aparna@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Satinder  Singh",
					"partner_id"=> 1,
					"emp_dob"=> "4/27/2012",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Aina  Gaur",
					"partner_id"=> 1,
					"emp_dob"=> "08-06-1987",
					"official_email"=> "aina@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Cristina  Fernandes",
					"partner_id"=> 1,
					"emp_dob"=> "4/26/1984",
					"official_email"=> "cristina@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Claude  Pierre",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Timothy  Hartpence",
					"partner_id"=> 1,
					"emp_dob"=> "9/15/1983",
					"official_email"=> "tim@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Michael  Raykher",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Laura  Espiau",
					"partner_id"=> 1,
					"emp_dob"=> "12/21/1982",
					"official_email"=> "laura@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Nilima  Achwal",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Jasmin  Patel",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Emily  Paarmann",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "emily@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Aditi  Seshadri",
					"partner_id"=> 1,
					"emp_dob"=> "1/14/1982",
					"official_email"=> "aditi@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Vijitha  Panikkar",
					"partner_id"=> 1,
					"emp_dob"=> "9/29/1967",
					"official_email"=> "vijitha@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Pinaki  Bhattacharyya",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "pinaki@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Arun  Jayachandran",
					"partner_id"=> 1,
					"emp_dob"=> "09-11-1977",
					"official_email"=> "heera@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Claritaz  sample",
					"partner_id"=> 1,
					"emp_dob"=> "9/13/1989",
					"official_email"=> "aravindhan.p@claritaz.com",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Jui  Gangan",
					"partner_id"=> 1,
					"emp_dob"=> "10-02-1987",
					"official_email"=> "jui@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Kavita  Rajagopalan",
					"partner_id"=> 1,
					"emp_dob"=> "10/18/1983",
					"official_email"=> "kavita@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Priya Soman Thachadi",
					"partner_id"=> 1,
					"emp_dob"=> "1/13/1983",
					"official_email"=> "priya@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Punit  Manek",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Jayakrishna  Mallick",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sumant  Singh",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Aryan  Kenchin",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "aryan@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Nachiket  Kulkarni",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Nitin  Lahoti",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rachana  Iyer",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Wilfred  Njagi",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ruchi  Malhotra",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sagar  Laygude",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "B  Ganesh",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "R  Sankar",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Minhaj  Ameen",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Adithya  Pasupuleti",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Koushik  Yanamandram",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Mervin  Rosario",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rilliya  S",
					"partner_id"=> 1,
					"emp_dob"=> "12/19/1988",
					"official_email"=> "rilliya@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shiv  Govind",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Mohan  Loganathan",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "mohan@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Bhavana  Mohan",
					"partner_id"=> 1,
					"emp_dob"=> "3/19/1986",
					"official_email"=> "bhavana@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Anna  Hoppenau",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Aashna  Jamal",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ranjith  Babu",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "ranjith@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Arun Kumar Das",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Paul  Belknap",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Prateek  Mishra",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "prateek@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ullas  Marar",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "ullas@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Raghavendra  Rao",
					"partner_id"=> 1,
					"emp_dob"=> "04-03-1985",
					"official_email"=> "raghavendra@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sonia  Oprean",
					"partner_id"=> 1,
					"emp_dob"=> "08-06-1984",
					"official_email"=> "sonia@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Krithika  Natarajan",
					"partner_id"=> 1,
					"emp_dob"=> "10/31/1985",
					"official_email"=> "krithika@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Yamini  Srivastava",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "yamini@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ngoc BAO HO Huynh",
					"partner_id"=> 1,
					"emp_dob"=> "02-07-1990",
					"official_email"=> "NGOC@VILLGRO.ORG",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Hang Thuy Vo",
					"partner_id"=> 1,
					"emp_dob"=> "08-03-1991",
					"official_email"=> "hang@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Michael Andrew Sizemore",
					"partner_id"=> 1,
					"emp_dob"=> "05-07-1990",
					"official_email"=> "michael@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sudhanshu  Malani",
					"partner_id"=> 1,
					"emp_dob"=> "9/16/1986",
					"official_email"=> "sudhanshu@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Siddhartha  Roy",
					"partner_id"=> 1,
					"emp_dob"=> "05-01-2018",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Deepika  Dravid",
					"partner_id"=> 1,
					"emp_dob"=> "3/24/1988",
					"official_email"=> "deepika@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sarah  Afraz",
					"partner_id"=> 1,
					"emp_dob"=> "5/13/1989",
					"official_email"=> "sarah@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Mariella  Belli Yaringano",
					"partner_id"=> 1,
					"emp_dob"=> "3/13/1985",
					"official_email"=> "mariella@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Nachiket  Sule",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Christopher  Achuenu",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Keshav  Kaul",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Siddharth  Nair",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Aditya  Pant",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Daphne Patricia Salinas Rodriguez",
					"partner_id"=> 1,
					"emp_dob"=> "07-04-1986",
					"official_email"=> "daphne@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Bangalore  VIF",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ashwin  Ramachandran",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Thuy Ngoc Dinh Pham",
					"partner_id"=> 1,
					"emp_dob"=> "11/16/1983",
					"official_email"=> "thuy@artoo.in",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Chaarvi  Badani",
					"partner_id"=> 1,
					"emp_dob"=> "09-04-1993",
					"official_email"=> "chaarvi@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Bhavana  Rajendran",
					"partner_id"=> 1,
					"emp_dob"=> "09-03-1985",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Arunkumar  Venkatesan",
					"partner_id"=> 1,
					"emp_dob"=> "05-12-1971",
					"official_email"=> "arun@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Maya  Chandrashekar",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "maya@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Paramjyoti  Chattopadhyay",
					"partner_id"=> 1,
					"emp_dob"=> "10/13/1979",
					"official_email"=> "paramjyoti@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Tanvi  Lal",
					"partner_id"=> 1,
					"emp_dob"=> "5/17/1992",
					"official_email"=> "tanvi@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Mohammad Azhar",
					"partner_id"=> 1,
					"emp_dob"=> "7/13/1989",
					"official_email"=> "mohammad@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Rama  Kannan",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "rama@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Soumya  Prakash",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "soumya@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Binu  Mathews",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "binu@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ragini  Pillai",
					"partner_id"=> 1,
					"emp_dob"=> "01-07-1994",
					"official_email"=> "ragini@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Vikash  Jha",
					"partner_id"=> 1,
					"emp_dob"=> "02-11-1987",
					"official_email"=> "vikash@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Nirupa  Rao",
					"partner_id"=> 1,
					"emp_dob"=> "12/20/1989",
					"official_email"=> "nirupa@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sukriti  Somvanshi",
					"partner_id"=> 1,
					"emp_dob"=> "10-11-1992",
					"official_email"=> "sukriti@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rohit  Lalwani",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "rohit@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Gowtham Sundara Raju",
					"partner_id"=> 1,
					"emp_dob"=> "03-04-1989",
					"official_email"=> "gowtham@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Vigneshwaran V",
					"partner_id"=> 1,
					"emp_dob"=> "09-07-1990",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Tanya  Upadhyaya",
					"partner_id"=> 1,
					"emp_dob"=> "05-12-1991",
					"official_email"=> "tanya@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Jenaan Lilani",
					"partner_id"=> 1,
					"emp_dob"=> "9/16/1988",
					"official_email"=> "jenaan@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Devendra  Banwari",
					"partner_id"=> 1,
					"emp_dob"=> "08-10-1971",
					"official_email"=> "devendra@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Anuja  Master",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "anuja@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Nidhi  Singh",
					"partner_id"=> 1,
					"emp_dob"=> "4/13/1986",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Srinivas  Ramanujam",
					"partner_id"=> 1,
					"emp_dob"=> "7/29/1977",
					"official_email"=> "srinivas@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Jaspreet  Singh",
					"partner_id"=> 1,
					"emp_dob"=> "5/24/1975",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Claritaz User",
					"partner_id"=> 1,
					"emp_dob"=> "4/24/1980",
					"official_email"=> "arunkumar.d@claritaz.com",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vigneshwar  Dogubarthy",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "vigneshwar@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Anika  Pandey",
					"partner_id"=> 1,
					"emp_dob"=> "3/26/1993",
					"official_email"=> "anika@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ananth  Aravamudan",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "ananth@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sucharita  Kamath",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "Sucharita.Kamath@aspeninstitute.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Venture  Centre, Pune",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Praveen  Rajan",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Devyani  Singh",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "devyani.singh@aspeninstitute.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shrikant  Patil",
					"partner_id"=> 1,
					"emp_dob"=> "02-01-1992",
					"official_email"=> "shrikant@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sayantani  Mukherjee",
					"partner_id"=> 1,
					"emp_dob"=> "08-01-2018",
					"official_email"=> "sayantani@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Deepanshi  Balooni",
					"partner_id"=> 1,
					"emp_dob"=> "4/19/1993",
					"official_email"=> "deepanshi@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rashi  .",
					"partner_id"=> 1,
					"emp_dob"=> "2/25/1998",
					"official_email"=> "rashi@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Tanuja Kate",
					"partner_id"=> 1,
					"emp_dob"=> "9/29/1995",
					"official_email"=> "tanuja@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shankha Lahiri",
					"partner_id"=> 1,
					"emp_dob"=> "10-05-1989",
					"official_email"=> "shankha@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shaikh Tariq Mobin",
					"partner_id"=> 1,
					"emp_dob"=> "6/15/1991",
					"official_email"=> "tariq@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ritika  Rastogi",
					"partner_id"=> 1,
					"emp_dob"=> "04-06-1993",
					"official_email"=> "ritika@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Siddharth  Vashist",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Malathy M",
					"partner_id"=> 1,
					"emp_dob"=> "4/29/1985",
					"official_email"=> "malathy@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Aditya  Jahagirdar",
					"partner_id"=> 1,
					"emp_dob"=> "2/19/1996",
					"official_email"=> "aditya.jahagirdar@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shreya  Agrawal (IITK)",
					"partner_id"=> 1,
					"emp_dob"=> "8/17/2018",
					"official_email"=> "agshreya@iitk.ac.in",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Abhijit  Sathe (IITK)",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "asathe@iitk.ac.in",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Vaibhav  Vashishtha (SO)",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "vaibhav@startupoasis.in",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Surekha  Routray (KIIT)",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "surekha@kiitincubator.in",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Soujit  Das (IIMCIP)",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "soujit.das@iimcip.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Kavya Agarwal",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "kavya@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Kevin  Bobby",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Pankaj  Anand",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "pankaj@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Bhargava  KC",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "bhargava@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Octavio  Roca",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "octavio@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Seraphina Selvanayakom",
					"partner_id"=> 1,
					"emp_dob"=> "11-05-1996",
					"official_email"=> "seraphina@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Saipriya Devamuthyam Salla",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "saipriya.salla@aspeninstitute.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Swetha Tipparaju",
					"partner_id"=> 1,
					"emp_dob"=> "01-06-1996",
					"official_email"=> "swetha.tipparaju@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Mehal Poddar",
					"partner_id"=> 1,
					"emp_dob"=> "5/25/1997",
					"official_email"=> "mehal@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shoma  Bhardwaj",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Mrinalini  V",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "mrinalini@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Nivvedhitha  Shankar",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Meenatshi  C",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "meenatshi@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ram  V",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "ramv@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sampriti  Saxena",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "sampriti@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Beyond  Capital",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Tanya  Agarwal",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rajeev  Aiyappa",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Hemendra  Mathur",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rajnish  Jha",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Nipun  Kwatra",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Mukul  Bagga",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Raj  Sarda",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Murali  CV",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ramanathan  V",
					"partner_id"=> 1,
					"emp_dob"=> "3/15/1967",
					"official_email"=> "ramv@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ananth  Aravamudan (Mentor)",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Chand  Das",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "N C  Venkatachari",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Aditya  Ajmera",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Pradeep  Ghosh",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ochintya  Sharma",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shubhendu  Agrawal",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Ashis Kumar Sahu",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Siva  Karthikeyan",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Alka  Dangash",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Raman  Ahuja",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Narayanan  Kottaram",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Dharm  Chaturvedi",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Finance Team  (Aria Advisory)",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "vifaccounts@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Sharada  Priya",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Adarsh  Naik",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Priya  Yadav",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Hajrah  Haider",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Anju Jayprakash",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Santhosh  B",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Divyaroop  Bhatnagar",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Anujay  Rao",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Maithili Rege",
					"partner_id"=> 1,
					"emp_dob"=> "08-03-1989",
					"official_email"=> "maithili@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Anuja Master Bose",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shyam Sundar Vembar",
					"partner_id"=> 1,
					"emp_dob"=> "10-02-1962",
					"official_email"=> "shyam@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sanyam  Kumar",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shalu  Mitruka",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Kannan  Neelakanta",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sridhar  B",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Niranjana  Ajith",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Anusha Kamath",
					"partner_id"=> 1,
					"emp_dob"=> "03-06-1992",
					"official_email"=> "anusha@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Pratim Raha",
					"partner_id"=> 1,
					"emp_dob"=> "07-02-1989",
					"official_email"=> "pratim@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Akshata Surej",
					"partner_id"=> 1,
					"emp_dob"=> "07-01-1992",
					"official_email"=> "akshata@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Malavika Ravi",
					"partner_id"=> 1,
					"emp_dob"=> "6/25/1995",
					"official_email"=> "malavika@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Y S Prabhakara",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Anubha Sharma",
					"partner_id"=> 1,
					"emp_dob"=> "05-02-1992",
					"official_email"=> "anubha@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Akash  Kumar",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Prashanth Jalla",
					"partner_id"=> 1,
					"emp_dob"=> "08-03-1993",
					"official_email"=> "prashanth@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Anjali Menon",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "anjali@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Caspian  Debt",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shell  Foundation",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Upaya Social Ventures",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Habitat  For Humanity",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sanjiv  Verma",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Indium  Software",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Balakumar Rajaram",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "balakumar@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "MSMF  (External)",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shashi  Bhushan",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Piyush  Mathur",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sandeep Kumar Jain",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sajal  Garg",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Eshan  Tyagi",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "CEEW  (PL)",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Abhishek  Sen",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shashi Bhushan",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "shashi@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Prateek  Patwari",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Demo  User",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "HDFC  (External)",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Dr. M V  Ravikumar",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Hari  Natarajan",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Emanuele  Colonnelli",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Medhavi Gupta",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rinu Susan Jacob",
					"partner_id"=> 1,
					"emp_dob"=> "01-01-1970",
					"official_email"=> "rinu@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Pavani Kashinath",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Pramod  Pradhan",
					"partner_id"=> 1,
					"emp_dob"=> "NULL",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Devansh Peshin",
					"partner_id"=> 1,
					"emp_dob"=> "08-06-1993",
					"official_email"=> "devansh@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sowmiya Santhanam",
					"partner_id"=> 1,
					"emp_dob"=> "3/22/1991",
					"official_email"=> "sowmiya@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Samyukta Prabhu",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "samyukta@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rohang  Mishal",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "rohang@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Aakriti  Mendiratta",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "aakriti@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rohang Mishal",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "rohang@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Hemant Pawaskar",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Kiran P B",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Lalith Kishore",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Artha Impact",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Lavni Ventures",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Blue Ashva Capital",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "India Health Fund",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Test Custom User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "CVRCE Technology Incubator Foundation",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "CVRCE Technology Incubator Foundation",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "3i Partners",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Johnson and Johnson",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Geetha Sanjay",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "geetha@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Krati Airan",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "krati@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Siddharth Lulla",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Siddharth Lulla",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Krithika R",
					"partner_id"=> 1,
					"emp_dob"=> "10/21/1997",
					"official_email"=> "krithika@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Manojit Bose",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sreejith A Narayanan",
					"partner_id"=> 1,
					"emp_dob"=> "05-05-1984",
					"official_email"=> "sreejith@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Demo User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ali Atik Ansari",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "ali@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Durjoy  Chakraborty",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shailesh Kumar",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "shailesh@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rini Dutta",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "rini@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Indium  Test 1",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Indium Test_2",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shashikanth Subramanya",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "shashikanth@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Parul Rana",
					"partner_id"=> 1,
					"emp_dob"=> "12-03-1992",
					"official_email"=> "parul@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Kalyani Krishna",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "kalyani@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Greenfunder .",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shankha Lahiri",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Roshan Dinesh Yedery",
					"partner_id"=> 1,
					"emp_dob"=> "2/15/1979",
					"official_email"=> "roshan@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Mili Jain",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Vibha Mukesh Sharma",
					"partner_id"=> 1,
					"emp_dob"=> "09-02-1979",
					"official_email"=> "vibha@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Ananya Saini",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Harish BG",
					"partner_id"=> 1,
					"emp_dob"=> "2/22/1994",
					"official_email"=> "harish@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "YEP  (External)",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Deshna Suryanarayan",
					"partner_id"=> 1,
					"emp_dob"=> "5/24/1997",
					"official_email"=> "deshna@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Sonal Raj",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "sonal@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Anshu Raina",
					"partner_id"=> 1,
					"emp_dob"=> "12/28/1992",
					"official_email"=> "anshu@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Shivang Sharma",
					"partner_id"=> 1,
					"emp_dob"=> "7/16/1995",
					"official_email"=> "shivang@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Purushotham S",
					"partner_id"=> 1,
					"emp_dob"=> "8/31/2000",
					"official_email"=> "purushotham@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Rohith Venkatakrishna",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "rohith.v@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sripad Atri",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "sripad@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Prashant Parashar",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Prashanth Venkatesh",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Dr. Jeyaseelan .",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Mridul Kabra",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sridhar Ramanathan",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Padhma  C",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Vikas Bhagaria",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Manak Matiyani",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Saumil Gandhi",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rashmi Ardey",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ameesh Masurekar",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Himanshu  .",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Renuka Motihar",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Gursimran Wadhawan",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Nayan  Bheda",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Vikas Goswami",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Divya Dutta",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Preeti Chaudhary",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "James Rajanayagam",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Agomoni Bose",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "agomoni@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Pragati Keswani",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "pragati@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Oshin Anna Shaji",
					"partner_id"=> 1,
					"emp_dob"=> "8/30/1996",
					"official_email"=> "oshin@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Tvaran (CISCO)",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Abishek Kumar",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "abishek@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Yukta Bhatia",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "yukta@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Kiran Ramaraj",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "kiran@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Amit Kumar Singh",
					"partner_id"=> 1,
					"emp_dob"=> "07-12-1988",
					"official_email"=> "amit@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Elavarasan H",
					"partner_id"=> 1,
					"emp_dob"=> "06-10-1997",
					"official_email"=> "elavarasan@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Rekha Gopalkrishnan",
					"partner_id"=> 1,
					"emp_dob"=> "8/22/1992",
					"official_email"=> "rekha@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Roshini Muthukumar",
					"partner_id"=> 1,
					"emp_dob"=> "4/20/1996",
					"official_email"=> "roshini@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Divya Sharma",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "divya@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Gita Arjun",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rajasekhar Reddy",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "rajasekhar@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Isha Dhingra",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "isha@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Savitha G Ananth",
					"partner_id"=> 1,
					"emp_dob"=> "4/18/1975",
					"official_email"=> "savitha@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Aditi Dhamanaskar",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "aditi@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Samiksha Rele",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "samiksha@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Vaishnavi  Chandrasekar",
					"partner_id"=> 1,
					"emp_dob"=> "05-07-2001",
					"official_email"=> "",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Upasana Nallari",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "upasana@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Srividhya Venkataraman",
					"partner_id"=> 1,
					"emp_dob"=> "02-04-1983",
					"official_email"=> "srividhya@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Anant Bhan",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Prashant Mandke",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Arundati Muralidharan",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Padma Chandrasekaran",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Manisha Bhise",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Richa Vashista",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Aryan Somaiya",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Vidhi Naiyar",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Dr. Zahoor",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shampa Sengupta",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Vedanarayanan Vedantham",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Stanley Stephen",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sharat Dhall",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Arun Kumbhat",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rajat Chhaba",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Saishah Joseph",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Chandana Jayaraj",
					"partner_id"=> 1,
					"emp_dob"=> "6/15/1983",
					"official_email"=> "chandana@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sunder Ram M",
					"partner_id"=> 1,
					"emp_dob"=> "7/30/1991",
					"official_email"=> "sunder@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Radhika Ramesh",
					"partner_id"=> 1,
					"emp_dob"=> "7/24/1966",
					"official_email"=> "radhika@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "R Mani Maran",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sriram  Chidambaram",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Bhaskar Roy",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Anugya Patidar",
					"partner_id"=> 1,
					"emp_dob"=> "10/19/1999",
					"official_email"=> "anugya@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Aishwarya S",
					"partner_id"=> 1,
					"emp_dob"=> "3/24/1999",
					"official_email"=> "aishwarya@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rishabh Shrivastava",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "rishabh@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sharun A",
					"partner_id"=> 1,
					"emp_dob"=> "8/22/1997",
					"official_email"=> "sharun@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Manu  Priyadarshi",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "manu@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Samuel Solomon",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Anita Joshi",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ashutosh Mundkur",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Arsal Akhtar Khan",
					"partner_id"=> 1,
					"emp_dob"=> "7/20/1996",
					"official_email"=> "arsal@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Jigar Rameshbhai Patel",
					"partner_id"=> 1,
					"emp_dob"=> "10-09-1989",
					"official_email"=> "jigar@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Pooja Ravindra",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "pooja@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Akshay Gode",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "Akshay@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sanam Rajendra Jain",
					"partner_id"=> 1,
					"emp_dob"=> "10-04-1987",
					"official_email"=> "sanam@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vineetha Venugopal",
					"partner_id"=> 1,
					"emp_dob"=> "10-07-1986",
					"official_email"=> "Vineetha.VK@aspeninstitute.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Divya Suresh",
					"partner_id"=> 1,
					"emp_dob"=> "4/15/2023",
					"official_email"=> "divya.s@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Rini Dutta",
					"partner_id"=> 1,
					"emp_dob"=> "1/14/1974",
					"official_email"=> "rini@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Aditi Jain",
					"partner_id"=> 1,
					"emp_dob"=> "12/17/1986",
					"official_email"=> "aditi.jain@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Finance User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Priyanka Choubey",
					"partner_id"=> 1,
					"emp_dob"=> "2/18/1985",
					"official_email"=> "priyanka.choubey@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "finance user",
					"partner_id"=> 1,
					"emp_dob"=> "04-12-2024",
					"official_email"=> "",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Mallika Emily Vaznaik",
					"partner_id"=> 1,
					"emp_dob"=> "6/15/1995",
					"official_email"=> "mallika.vaznaik@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Aparna Narayanan",
					"partner_id"=> 1,
					"emp_dob"=> "6/30/1998",
					"official_email"=> "aparna.narayanan@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Anirudhh  Shankar",
					"partner_id"=> 1,
					"emp_dob"=> "8/18/2002",
					"official_email"=> "anirudhh.shankar@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Sanjana Vijay",
					"partner_id"=> 1,
					"emp_dob"=> "12/21/1997",
					"official_email"=> "sanjana.vijay@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Test user",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Madhu Malay",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Jayesh  Sangpal",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Rohini  Kamath",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Sirisha  Palepu",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Ananya Vyas",
					"partner_id"=> 1,
					"emp_dob"=> "9/30/2000",
					"official_email"=> "ananya.vyas@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Harshil Dhruv",
					"partner_id"=> 1,
					"emp_dob"=> "02-09-1998",
					"official_email"=> "harshil.dhruv@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Aditi Pareek",
					"partner_id"=> 1,
					"emp_dob"=> "01-01-2000",
					"official_email"=> "aditi.pareek@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Anurag Meghna  Sridharan",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Prashanth Varanasi",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Vignesh Climate Action User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vignesh Agri User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vignesh Health User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vignesh ILE User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vignesh RAIIN User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vignesh WastetoValue User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vignesh Sheltertech User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vignesh Eco Dev User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Admin User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vignesh Program Partnerships User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vignesh Tech User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vignesh Impact Finance User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Murugan ProgramPartnerships User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "murugan.m@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Murugan Ecodev User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "murugan.m@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Murugan Sheltertech User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "murugan.m@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Murugan WastetoValue User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "murugan.m@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Murugan RAIIN User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "murugan.m@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Murugan ILE User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "murugan.m@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Murugan Health User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "murugan.m@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Murugan Agri User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "murugan.m@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Murugan Climate Action User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "murugan.m@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Murugan Tech User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "murugan.m@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Murugan Impact Finance  User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "murugan.m@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vignesh ANDE User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vignesh Restricted User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Vignesh Finance User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "vigneshwaran@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Dr Vimal  Kumar Gahlot",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Hiten  Saklani",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Jhpiego  User",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Lakshmi Venkatraman",
					"partner_id"=> 1,
					"emp_dob"=> "8/26/1984",
					"official_email"=> "lakshmi.venkatraman@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Pallavi Sharma",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> ""
				  ],
				  [
					"Name"=> "Manashapriya P",
					"partner_id"=> 1,
					"emp_dob"=> "12-01-1996",
					"official_email"=> "manashapriya.p@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Preethika Sabu",
					"partner_id"=> 1,
					"emp_dob"=> "8/14/1999",
					"official_email"=> "preethika.sabu@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Shikha Tailor",
					"partner_id"=> 1,
					"emp_dob"=> "1/30/1998",
					"official_email"=> "shikha.tailor@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Nehal  Gulia",
					"partner_id"=> 1,
					"emp_dob"=> "9/23/2005",
					"official_email"=> "",
					"Status"=> ""
				  ],
				  [
					"Name"=> "Ashok  M. V",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> ""
				  ],
				  [
					"Name"=> "Avdhesh  Kumar",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> ""
				  ],
				  [
					"Name"=> "7th Gen  Consultants",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> ""
				  ],
				  [
					"Name"=> "J T Attorney  Alliance",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> ""
				  ],
				  [
					"Name"=> "Megha  Bedia",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "megha.bedia@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Pranay Salve",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "pranay.salve@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Sudhir  G Kulkarni",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Divya Rao",
					"partner_id"=> 1,
					"emp_dob"=> "5/16/1997",
					"official_email"=> "divya.rao@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Sabarikanth R",
					"partner_id"=> 1,
					"emp_dob"=> "6/21/1987",
					"official_email"=> "sabarikanth.r@villgro.org",
					"Status"=> "Exit"
				  ],
				  [
					"Name"=> "Shriyam  Yagnik",
					"partner_id"=> 1,
					"emp_dob"=> "01-01-1970",
					"official_email"=> "",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Navneet Mishra",
					"partner_id"=> 1,
					"emp_dob"=> "01-01-1995",
					"official_email"=> "navneet.mishra@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Murugan OD",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "VigneshOD user",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Shoma  Bhardwaj",
					"partner_id"=> 1,
					"emp_dob"=> "5/14/1984",
					"official_email"=> "shoma.bhardwaj@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Shubhendu Agrawal",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "shubhendu.agrawal@villgro.org",
					"Status"=> "Active"
				  ],
				  [
					"Name"=> "Poonacha K A",
					"partner_id"=> 1,
					"emp_dob"=> "0000-00-00",
					"official_email"=> "poonacha.ka@villgro.org",
					"Status"=> "Active"
				  ]
		
    ];
	
	/* foreach($data as $lists){
			
		   $this->load->model('user/Common_model');
           $getData = $this->Common_model->getEmpDataLists($lists['Name']);
		    
		   $status = '';
		   if(!empty($getData)){
			 
				if($lists['Status']=='Exit'){
					$status = 2;
				}else if($lists['Status']=='Active'){
					$status = 1;
				}
				foreach($getData as $employeeList){
					 if($status!='' && $employeeList['emp_id']!=''){
						 
						  echo'<pre>';print_r($employeeList); 
						  $this->Common_model->updateEmpDataLists($status,$employeeList['emp_id']);
					 }
					
				}
				#$this->Common_model->updateEmpDataLists($status,$getData['id']);
				 #echo'<pre>';print_r($getData); 
		   }
		  # die;
	} */
	
}




 
 
 
 
}

?>