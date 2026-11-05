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

        $totalrows = $this->Empuser->getDTEmployeeCount($search_field, $search_value, $current_user, $columns, $requestData);
        $query = $this->Empuser->getDTEmployeeDetails($requestData['length'], $requestData['start'], $search_field, $search_value, $current_user, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
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

    public function deleteDetail() {
        $id = $this->input->post('id');
        $condition = "'" . implode("', '", $id) . "'";
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
        $user['status'] = $option['status'] = 1;
        $user['id'] = $data['emp_id'] = $id;
        if ($id != '') {
            $data['employee'] = $this->Empuser->getCommonDetails('hr_user_profile', $user);
        }

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
        if (count($checkExist) > 0) {
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
            $partner_access = implode(',', $_POST['user_partner_access']);
            $data['partner_access'] = $partner_access;
        }

        if (isset($_POST['tab_access'])) {
            $tab_access = implode(',', $_POST['tab_access']);
            $data['tab_access'] = $tab_access;
        }

        if ($_POST['user_role'] == 4) {
            if (isset($_POST['user_module_access'])) {
                $tab_access = implode(',', $_POST['user_module_access']);
                $data['menu_access'] = $tab_access;
            }

            if (isset($_POST['user_sector_access'])) {
                $tab_access = implode(',', $_POST['user_sector_access']);
                $data['sector_access'] = $tab_access;
            }

            if (isset($_POST['user_program_access'])) {
                $tab_access = implode(',', $_POST['user_program_access']);
                $data['program_access'] = $tab_access;
            }

            $data['deals_from_date'] = (isset($_POST['deals_from']) && $_POST['deals_from'] != '') ? date('Y-m-d', strtotime($_POST['deals_from'])) : '';
            $data['deals_to_date'] = (isset($_POST['deals_to']) && $_POST['deals_to'] != '') ? date('Y-m-d', strtotime($_POST['deals_to'])) : '';
            $data['independent_shortlist'] = isset($_POST['shortlistID']) && $_POST['shortlistID'] == 1 ? $_POST['shortlistID'] : 0;
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

        if (count($checkExist) > 0) {
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
        if (count($checkExist) > 0) {
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
        if (count($checkExist) > 0) {
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
        if (count($checkExist) > 0) {
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
        if (count($checkExist) > 0) {
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
        if (count($checkExist) > 0) {
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
        $totalData = count($query);
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
        $totalData = count($query);
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
        $condition = "'" . implode("', '", $id) . "'";
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
        if (count($checkExist) > 0) {
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
            if (count($checkExist) > 0) {
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
        $totalData = count($query);
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
        $data['bank_list'] = $this->Empuser->getBankList('hr_user_bank', $id);

        $this->load->vars($data);
        $this->load->view('user/profile/bank');
    }

    public function add_bank() {
        for ($i = 0; $i < count($_POST['bank_name']); $i++) {
            if ($_POST['bank_name'][$i] != '') {
                $data = array();
                $option['id'] = $_POST['account_id'][$i];
                $data['emp_id'] = $_POST['employee_id'];
                $data['bank_name'] = $_POST['bank_name'][$i];
                $data['account_number'] = $_POST['account_number'][$i];
                $data['branch_name'] = $_POST['branch_name'][$i];
                $data['ifsc_code'] = $_POST['ifsc_code'][$i];

                $checkExist = $this->Mportfolio->getDetails('hr_user_bank', $option);
                if (count($checkExist) > 0) {
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
        $totalData = count($query);
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
        if (count($checkExist) > 0) {
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
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();
            $nestedData[] = '<input type="checkbox" class="chk_box" id="education_chk_box" name="education_id[]" value="' . $row['id'] . '"/>';
            $graduate = '';
            if ($row['qualification'] == 1) {
                $graduate = 'UG';
            } else if ($row['qualification'] == 2) {
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
        $data['dependent_list'] = $this->Empuser->getDependentList('hr_user_dependents', $id);

        $this->load->vars($data);
        $this->load->view('user/profile/dependents');
    }

    public function add_dependents() {

        for ($i = 0; $i < count($_POST['dependent_name']); $i++) {
            if ($_POST['dependent_name'][$i] != '') {
                $data = array();
                $option['id'] = $_POST['dept_id'][$i];
                $data['emp_id'] = $_POST['employee_id'];
                $data['name'] = $_POST['dependent_name'][$i];
                $data['relationship'] = $_POST['dependent_relation'][$i];
                $data['birth_date'] = (isset($_POST['dependent_birth'][$i]) && $_POST['dependent_birth'][$i] != '') ? date('Y-m-d', strtotime($_POST['dependent_birth'][$i])) : '';

                $checkExist = $this->Mportfolio->getDetails('hr_user_dependents', $option);
                if (count($checkExist) > 0) {
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
        $totalData = count($query);
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
        if (count($checkExist) > 0) {
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
        $totalData = count($query);
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
        $data['employee_list'] = $this->Empuser->getReportingEmployee($id);
        $data['supervisor_list'] = $this->Empuser->getReportingList('hr_user_reporting', $id, 'report_subordinate', 'report_supervisor');
        $data['subordinate_list'] = $this->Empuser->getReportingList('hr_user_reporting', $id, 'report_supervisor', 'report_subordinate');

        $this->load->vars($data);
        $this->load->view('user/profile/reporting');
    }

    public function add_reporting() {
        $emp_id = $_POST['employee_id'];
        if ($_POST['report_to'] == 1) {
            $data['report_supervisor'] = $_POST['employee_id'];
            $data['report_subordinate'] = $_POST['report_employee'];
        } else if ($_POST['report_to'] == 2) {
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
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();
            $nestedData[] = '<input type="checkbox" class="chk_box supervisor_chkbox" id="supervisor_chk_box" name="supervisor_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['report_subordinate'];
            $nestedData[] = $row['emp_name'];
            if ($row['report_method'] == 1) {
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
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();
            $nestedData[] = '<input type="checkbox" class="chk_box subordinate_chkbox" id="subordinate_chk_box" name="subordinate_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['report_supervisor'];
            $nestedData[] = $row['emp_name'];
            if ($row['report_method'] == 1) {
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

        $funder_id = $this->uri->segment(3);

        if ($funder_id != '') {
            $conditions = array('emp_id' => $funder_id);
            $join[0]['select'] = "emp.emp_first_name,emp.emp_last_name";
            $join[0]['table'] = 'hr_user_profile as emp';
            $join[0]['condition'] = "hr_user_document.uploaded_by = emp.id";
            $join[0]['type'] = "LEFT";
            
            $getFunderDoc = $this->Mprofile->get_all_details('hr_user_document', $conditions, array('hr_user_document.id', 'description', 'emp_id', 'file_name', 'created_date', 'updated_date'), '', '', '', '', '', $join, '');
            
            if (!empty($getFunderDoc)) {
                $data['funder_document'] = $getFunderDoc;
            }
            $data['user_name'] = $getFunderDoc[0]->emp_first_name . ' ' . $getFunderDoc[0]->emp_last_name;

            $updated_date_doc = date('d-m-Y', strtotime($getFunderDoc[0]->created_date));
            if (isset($getFunderDoc[0]->updated_date) && $getFunderDoc[0]->updated_date != '') {
                if ($getFunderDoc[0]->updated_date > 0) {
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
            $config['allowed_types'] = 'doc|docx|ppt|pptx|pdf|xls|xlsx';
            $config['max_size'] = 10485760;
            $config['upload_path'] = './uploads/profile_document/';
            $this->load->library('upload', $config);
            $doc_id = '';
            $countErr = 0;
            for ($i = 0; $i < count($description); $i++) {

                $Check_fname = array_values($_FILES['file_upload']['name'][$i])[0];
                $Check_description_val = array_values($description[$i])[0];
                $countErr++;
                if (!empty($_FILES['file_upload'])) {
                    if (count($_FILES['file_upload']['name']) > 0) {
                        $fname = array_values($_FILES['file_upload']['name'][$i])[0];
                        $description_val = array_values($description[$i])[0];

                        $file_dataArr = array();
                        if (isset($fname) && $fname != '') {
                            $fileType = pathinfo($fname, PATHINFO_EXTENSION);
                            $file_name = uniqid(md5($fName . '' . time())) . '.' . $fileType;

                            $_FILES['images[]']['name'] = $file_name;
                            $_FILES['images[]']['type'] = $file_type = array_values($_FILES['file_upload']['type'][$i])[0];
                            $_FILES['images[]']['tmp_name'] = array_values($_FILES['file_upload']['tmp_name'][$i])[0];
                            $_FILES['images[]']['error'] = array_values($_FILES['file_upload']['error'][$i])[0];
                            $_FILES['images[]']['size'] = array_values($_FILES['file_upload']['size'][$i])[0];

                            $fileName = $file_name;
                            $images[] = $fileName;
                            $filenameArr[] = $fileName;

                            $this->upload->initialize($config);
                                #echo'<pre>';print_r($_FILES);
                                #echo $fileName; echo '==';echo $file_type;
                            if ($this->upload->do_upload('images[]')) {
                                $uploaded = $this->upload->data();
                                $file_dataArr = array(
                                    'file_name' => $fileName,
                                    'status' => 1, 'file_type' => $file_type
                                );
                            } else {
                                $logoDetails = $this->upload->display_errors();
                                    #echo'<pre>';print_r($logoDetails);die;
                            }
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
        $common_id = array_values(array_filter($common_id));
        if (!empty($common_id) && $formType != '') {

            $condition = array('id' => $common_id);
                   // echo'<pre>';print_r($condition);die;

            if ($formType == 'hr_user_document') {
                $table_name = 'hr_user_document';
                $condition = array('id' => $common_id);
                $get_file_names = $this->Mprofile->get_all_details_win('hr_user_document', $condition, array('file_name'));
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

            for($i=0;$i<count($_POST['description']);$i++){
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


}

?>