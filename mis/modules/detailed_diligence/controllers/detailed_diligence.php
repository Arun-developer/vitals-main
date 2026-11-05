<?php

class Detailed_diligence extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->helper('url');
        $this->load->model('login/Muser');
        $this->load->model('scouting/Mincharge');
        $this->load->model('login/Mdiligence');
        $this->load->model('master/Sector_model');
        $this->load->model('master/Mmaster');
        $this->load->model('scouting/Minnovation');
    }

    /*
     * Main Function for Employee Login Which verifies the Given Username and Password with the Database
     * Get the User details and saved it in the Session Variable
     * Redirect to the Main Menu Page.
     */

    public function company_team($id) {
        $invID = 'INV' . $id;
        $innv_pool = $this->Mdiligence->get_data('innovation_pool', $invID);
        if ($innv_pool[0]['program'] == 0) {
            $data['main_data'] = $this->Mdiligence->getMainIncub($invID);
            $data['mem_data'] = $this->Mdiligence->getManageIncub($invID);
        } else if ($innv_pool[0]['program'] == 3 || $innv_pool[0]['program'] == 4) {
            $data['main_data'] = $this->Mdiligence->getMainPitch($invID);
            $data['mem_data'] = $this->Mdiligence->getManagePitch($invID);
        }
        $data['innv_pool'] = $innv_pool;
        $data['masterData'] = $this->Mdiligence->get_data('company_master_data', $invID);
        $data['teamData'] = $this->Mdiligence->get_data('management_team', $invID);
        $data['shareData'] = $this->Mdiligence->get_data('share_details', $invID);
        $branch_id = $this->session->userdata('partner_id');
        $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
        $data['userbranch'] = $this->Mmaster->getYbranch($branch_id);
        $data['usersABIList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
        $data['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);

        $data['log_details'] = $this->Mincharge->getStatusLog($id);
        $empName = array();
        $modified_employer = array();

        foreach ($data['log_details'] as $key => $value) {

            $employees = explode(",", $data['log_details'][$key]['assigned_user']);

            foreach ($employees as $k => $val) {
                $empName = $this->Sector_model->getEmployeeNameByID($employees[$k]);
                $employees[$k] = $empName['emp_name'];
            }
            $data['log_details'][$key]['assigned_incharge'] = implode(", ", $employees);
            $modified_employer = $this->Sector_model->getEmployeeNameByID($data['log_details'][$key]['modified_by']);
            $data['log_details'][$key]['modified_by_user'] = $modified_employer['emp_name'];
        }

        $data['id'] = $id;
        $data['innovation'] = $innovation = $this->Minnovation->getinnovation($id);
        $data['inv_id_format'] = $data['innovation']['copy_id'] . "_" . $data['innovation']['partner_id'] . "_" . $data['innovation']['partner_count'];
        $get_sector = isset($data['masterData'][0]['sector']) && $data['masterData'][0]['sector'] != '' ? $data['masterData'][0]['sector'] : $innovation['sector'];
        $data['sector'] = $this->Minnovation->getSectorNamePitch($get_sector);
        if ($innovation['program'] == '3' || $innovation['program'] == '4') {
            $pitch_user = $this->Minnovation->get_pitch('pitch_user', $innovation['innovation_id']);
            $pitch_org = $this->Minnovation->get_pitch('pitch_step2', $pitch_user[0]['pitch_id']);
            $data['subsec_title'] = 'Sub Sector';
            $get_subsec_name = isset($data['masterData'][0]['sub_sector']) && $data['masterData'][0]['sub_sector'] != '' ? $data['masterData'][0]['sub_sector'] : $pitch_org[0]['sub_sector'];
            $subsec_name = $this->Minnovation->getSectorNamePitch($get_subsec_name);
            $data['subsector'] = $subsec_name[0]['sector'];
        } else if ($innovation['program'] == '0') {
            $inv_details = $this->Minnovation->get_innovation('inv_user', "INV" . $innovation['id']);
            $data['subsec_title'] = 'Sub Sector';
            $get_subsec_name = isset($data['masterData'][0]['sub_sector']) && $data['masterData'][0]['sub_sector'] != '' ? $data['masterData'][0]['sub_sector'] : $inv_details[0]['sub_sector'];
            $subsec_name = $this->Minnovation->getSectorNamePitch($get_subsec_name);
            $data['subsector'] = $subsec_name[0]['sector'];
        }
        $app_stage = $this->Minnovation->getInnvationStage();
        $app_status = $this->Minnovation->getInnvationStatus();
        $data['stage_name'] = $app_stage[$innovation['stage']];
        $data['status_name'] = $app_status[$innovation['status']];
        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['sectors_values'] = $this->Mincharge->getSectorNames($innovation['partner_id']);
        if ($data['masterData'][0]['sub_sector'] != '') {
            $ssector = $data['masterData'][0]['sub_sector'];
        } else {
            $ssector = $data['main_data'][0]['sub_sector'];
        }

        if ($innovation['status'] == '17') {
            $eic_app = $this->Mdiligence->get_landingInfo('application_status_log', $innovation['id'], 17);
        } else if ($innovation['status'] == '18') {
            $eic_app = $this->Mdiligence->get_landingInfo('application_status_log', $innovation['id'], 18);
        } else if ($innovation['status'] == '20' || ($innovation['stage'] == '12' && $innovation['status'] == '12')) {
            $eic_app = $this->Mdiligence->get_landingInfo('application_status_log', $innovation['id'], 20);
        } else {
            $eic_app = "";
        }

        if ($eic_app[0]['modified_date'] != '') {
            $data['eic_date'] = date('d-M-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $data['subSectorName'] = $this->Mincharge->getSubsectorName($ssector);
        $data['cpage'] = 'companyTeam';
        $data['cpagetitle'] = $innovation['name_of_enterprise'];
        $this->load->view('../template', $data);
    }

    public function master_data() {
        $pitch_user = $this->Minnovation->get_pitch('pitch_user', $_POST['innovation_id']);
        if ($_POST['masterSubmit'] != '') {
            $get_innovation = $this->Mdiligence->get_data('company_master_data', $_POST['innovation_id']);
            $format_date = date('Y-m-d', strtotime($_POST['incorporation_date']));
            if (!empty($get_innovation)) {
                $inv_user_data = array(
                    'business_description' => ($_POST['description'] != '') ? $_POST['description'] : '',
                    'cik' => ($_POST['cik'] != '') ? $_POST['cik'] : '',
                    'sector' => ($_POST['sector'] != '') ? $_POST['sector'] : '',
                    'sub_sector' => ($_POST['sub_sector'] != '') ? $_POST['sub_sector'] : '',
                    'incorporation_date' => ($format_date != '') ? $format_date : '',
                    'invention' => ($_POST['invention'] != '') ? $_POST['invention'] : '',
                    'reg_office_address' => ($_POST['reg_address'] != '') ? $_POST['reg_address'] : '',
                    'reg_city' => ($_POST['reg_city'] != '') ? $_POST['reg_city'] : '',
                    'reg_pincode' => ($_POST['reg_pin'] != '') ? $_POST['reg_pin'] : '',
                    'other_address_1' => ($_POST['other_addr_1'] != '') ? $_POST['other_addr_1'] : '',
                    'other_city_1' => ($_POST['other_city_1'] != '') ? $_POST['other_city_1'] : '',
                    'other_pincode_1' => ($_POST['other_pin_1'] != '') ? $_POST['other_pin_1'] : '',
                    'other_address_2' => ($_POST['other_addr_2'] != '') ? $_POST['other_addr_2'] : '',
                    'other_city_2' => ($_POST['other_city_2'] != '') ? $_POST['other_city_2'] : '',
                    'other_pincode_2' => ($_POST['other_pin_2'] != '') ? $_POST['other_pin_2'] : '',
                    'modified_date' => date('Y-m-d H:i:s'),
                );
                $user_where = array('innovation_id' => $_POST['innovation_id']);
                $table = "company_master_data";
                $this->Minnovation->pitch_update($table, $inv_user_data, $user_where);
            } else {
                $inv_user_data = array(
                    'innovation_id' => $_POST['innovation_id'],
                    'business_description' => ($_POST['description'] != '') ? $_POST['description'] : '',
                    'cik' => ($_POST['cik'] != '') ? $_POST['cik'] : '',
                    'sector' => ($_POST['sector'] != '') ? $_POST['sector'] : '',
                    'sub_sector' => ($_POST['sub_sector'] != '') ? $_POST['sub_sector'] : '',
                    'incorporation_date' => ($format_date != '') ? $format_date : '',
                    'invention' => ($_POST['invention'] != '') ? $_POST['invention'] : '',
                    'reg_office_address' => ($_POST['reg_address'] != '') ? $_POST['reg_address'] : '',
                    'reg_city' => ($_POST['reg_city'] != '') ? $_POST['reg_city'] : '',
                    'reg_pincode' => ($_POST['reg_pin'] != '') ? $_POST['reg_pin'] : '',
                    'other_address_1' => ($_POST['other_addr_1'] != '') ? $_POST['other_addr_1'] : '',
                    'other_city_1' => ($_POST['other_city_1'] != '') ? $_POST['other_city_1'] : '',
                    'other_pincode_1' => ($_POST['other_pin_1'] != '') ? $_POST['other_pin_1'] : '',
                    'other_address_2' => ($_POST['other_addr_2'] != '') ? $_POST['other_addr_2'] : '',
                    'other_city_2' => ($_POST['other_city_2'] != '') ? $_POST['other_city_2'] : '',
                    'other_pincode_2' => ($_POST['other_pin_2'] != '') ? $_POST['other_pin_2'] : '',
                    'created_date' => date('Y-m-d H:i:s'),
                );
                $table = "company_master_data";
                $inv_user_id = $this->Minnovation->pitch_insert($table, $inv_user_data);
            }

            $this->session->set_userdata("company_sucmsg", 'Company master details updated successfully');
            redirect('/detailed_diligence/company_team/' . $_POST['innovation']);
        }
    }

    public function team_data() {
        $this->load->library('upload');
        $count = php72_count($_POST['name']);
        for ($i = 0; $i < $count; $i++) {
            $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/detailed_diligence';
            $resume_path = '';

            if ($_FILES["resume"]["name"][$i] != "") {
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';

                $file_name = explode('.', $_FILES["resume"]["name"][$i]);
                $file_ext = end(explode('.', $_FILES["resume"]["name"][$i]));
                $sliced = array_slice($file_name, 0, -1);
                $string = implode(" ", $sliced);
                $change_first = str_replace('.', '-', $string);

                $newfilename = preg_replace('/[^A-Za-z0-9\_.]/', '-', $change_first);
                $change_name = str_replace(' ', '-', $newfilename . '.' . $file_ext);
                $config['file_name'] = date('Ymdhis') . '_management_' . str_replace('_', '-', $change_name);

                $this->upload->initialize($config);

                $_FILES['resume_upload']['name'] = $_FILES['resume']['name'][$i];
                $_FILES['resume_upload']['tmp_name'] = $_FILES['resume']['tmp_name'][$i];
                $_FILES['resume_upload']['size'] = $_FILES['resume']['size'][$i];
                $_FILES['resume_upload']['type'] = $_FILES['resume']['type'][$i];
                $_FILES['resume_upload']['error'] = $_FILES['resume']['error'][$i];

                if (!$this->upload->do_upload('resume_upload')) {
                    $upload_error = $this->upload->display_errors();
                } else {
                    $upload_data = $this->upload->data();
                    $resume_path = $upload_data['file_name'];
                }
                unset($config);
            } else if (isset($_POST['resume_old'][$i])) {
                $resume_path = $_POST['resume_old'][$i];
            }
            $get_innovation = $this->Mdiligence->get_data('management_team', $_POST['innovation_id']);
            if (!empty($get_innovation) && $_POST['memberId'][$i] != '') {
                if ($_POST['name'][$i] != '') {
                    $member_data = array(
                        'name' => $this->db->escape_str($_POST['name'][$i]),
                        'mobile' => $this->db->escape_str($_POST['mobile'][$i]),
                        'email' => $this->db->escape_str($_POST['email'][$i]),
                        'location' => $this->db->escape_str($_POST['location'][$i]),
                        'design' => $this->db->escape_str($_POST['design'][$i]),
                        'resume' => $this->db->escape_str($resume_path),
                        'modified_date' => date('Y-m-d H:i:s'),
                        'innovation_id' => $_POST['innovation_id'],
                    );
                    $user_where = array('id' => $_POST['memberId'][$i]);
                    $table = "management_team";
                    $result = $this->Minnovation->pitch_update($table, $member_data, $user_where);
                }
            } else {
                if ($_POST['name'][$i] != '') {
                    $member_data = array(
                        'name' => $this->db->escape_str($_POST['name'][$i]),
                        'mobile' => $this->db->escape_str($_POST['mobile'][$i]),
                        'email' => $this->db->escape_str($_POST['email'][$i]),
                        'location' => $this->db->escape_str($_POST['location'][$i]),
                        'design' => $this->db->escape_str($_POST['design'][$i]),
                        'resume' => $this->db->escape_str($resume_path),
                        'created_date' => date('Y-m-d H:i:s'),
                        'innovation_id' => $_POST['innovation_id'],
                    );
                    $table = "management_team";
                    $result = $this->Minnovation->pitch_insert($table, $member_data);
                }
            }
        }
        $this->session->set_userdata("company_sucmsg", 'Team details updated successfully');
        $this->session->set_userdata('company_tab', 2);
        redirect('/detailed_diligence/company_team/' . $_POST['innovation']);
    }

    public function share_data() {
        $count = php72_count($_POST['holder']);
        for ($i = 0; $i < $count; $i++) {
            $get_innovation = $this->Mdiligence->get_data('share_details', $_POST['innovation_id']);
            if (!empty($get_innovation) && $_POST['shareId'][$i] != '') {
                if ($_POST['holder'][$i] != '') {
                    $member_data = array(
                        'holder' => $this->db->escape_str($_POST['holder'][$i]),
                        'share' => $this->db->escape_str($_POST['share'][$i]),
                        'type' => $this->db->escape_str($_POST['type'][$i]),
                        'modified_date' => date('Y-m-d H:i:s'),
                        'innovation_id' => $_POST['innovation_id'],
                    );
                    $user_where = array('id' => $_POST['shareId'][$i]);
                    $table = "share_details";
                    $result = $this->Minnovation->pitch_update($table, $member_data, $user_where);
                }
            } else {
                if ($_POST['holder'][$i] != '') {
                    $member_data = array(
                        'holder' => $this->db->escape_str($_POST['holder'][$i]),
                        'share' => $this->db->escape_str($_POST['share'][$i]),
                        'type' => $this->db->escape_str($_POST['type'][$i]),
                        'created_date' => date('Y-m-d H:i:s'),
                        'innovation_id' => $_POST['innovation_id'],
                    );
                    $table = "share_details";
                    $result = $this->Minnovation->pitch_insert($table, $member_data);
                }
            }
        }
        $this->session->set_userdata("company_sucmsg", 'Share details updated successfully');
        $this->session->set_userdata('company_tab', 3);
        redirect('/detailed_diligence/company_team/' . $_POST['innovation']);
    }

    public function dashboard($id) {
        $branch_id = $this->session->userdata('partner_id');
        $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
        $data['userbranch'] = $this->Mmaster->getYbranch($branch_id);
        $data['usersABIList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
        $data['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);

        $data['log_details'] = $this->Mincharge->getStatusLog($id);
        $empName = array();
        $modified_employer = array();

        foreach ($data['log_details'] as $key => $value) {
            $employees = explode(",", $data['log_details'][$key]['assigned_user']);

            foreach ($employees as $k => $val) {
                $empName = $this->Sector_model->getEmployeeNameByID($employees[$k]);
                $employees[$k] = $empName['emp_name'];
            }
            $data['log_details'][$key]['assigned_incharge'] = implode(", ", $employees);
            $modified_employer = $this->Sector_model->getEmployeeNameByID($data['log_details'][$key]['modified_by']);
            $data['log_details'][$key]['modified_by_user'] = $modified_employer['emp_name'];
        }

        $data['id'] = $id;
        $invID = 'INV' . $id;
        $data['masterData'] = $this->Mdiligence->get_data('company_master_data', $invID);
        $data['innovation'] = $innovation = $this->Minnovation->getinnovation($id);
        $data['inv_id_format'] = $data['innovation']['copy_id'] . "_" . $data['innovation']['partner_id'] . "_" . $data['innovation']['partner_count'];
        $get_sector = isset($data['masterData'][0]['sector']) && $data['masterData'][0]['sector'] != '' ? $data['masterData'][0]['sector'] : $innovation['sector'];
        $data['sector'] = $this->Minnovation->getSectorNamePitch($get_sector);
        if ($innovation['program'] == '3' || $innovation['program'] == '4') {
            $pitch_user = $this->Minnovation->get_pitch('pitch_user', $innovation['innovation_id']);
            $pitch_org = $this->Minnovation->get_pitch('pitch_step2', $pitch_user[0]['pitch_id']);
            $data['subsec_title'] = 'Sub Sector';
            $get_subsec_name = isset($data['masterData'][0]['sub_sector']) && $data['masterData'][0]['sub_sector'] != '' ? $data['masterData'][0]['sub_sector'] : $pitch_org[0]['sub_sector'];
            $subsec_name = $this->Minnovation->getSectorNamePitch($get_subsec_name);
            $data['subsector'] = $subsec_name[0]['sector'];
            $data['application_date'] = $this->Mdiligence->get_landingInfo('pitch_user', $innovation['innovation_id']);
        } else if ($innovation['program'] == '0') {
            $inv_details = $this->Minnovation->get_innovation('inv_user', "INV" . $innovation['id']);
            $data['subsec_title'] = 'Sub Sector';
            $get_subsec_name = isset($data['masterData'][0]['sub_sector']) && $data['masterData'][0]['sub_sector'] != '' ? $data['masterData'][0]['sub_sector'] : $inv_details[0]['sub_sector'];
            $subsec_name = $this->Minnovation->getSectorNamePitch($get_subsec_name);
            $data['subsector'] = $subsec_name[0]['sector'];
            $data['application_date'] = $this->Mdiligence->get_landingInfo('inv_user', $innovation['innovation_id']);
        }
        $app_stage = $this->Minnovation->getInnvationStage();
        $app_status = $this->Minnovation->getInnvationStatus();
        $data['stage_name'] = $app_stage[$innovation['stage']];
        $data['status_name'] = $app_status[$innovation['status']];

        $data['iic_val'] = $this->Mdiligence->get_landingInfo('grading_feedback', $innovation['id']);
        $data['nda_signed'] = $this->Mdiligence->get_landingInfo('diligence_document', $innovation['innovation_id'], 1);
        $data['all_docs'] = $this->Mdiligence->get_landingDocs('diligence_document', $innovation['innovation_id']);
        $data['quest_res'] = $this->Mdiligence->get_landingInfo('diligence_document', $innovation['innovation_id'], 2);
        $data['site_plan'] = $this->Mdiligence->get_landingInfo('diligence_document', $innovation['innovation_id'], 12);
        $data['assessment'] = $this->Mdiligence->get_landingInfo('detailed_diligence', $innovation['innovation_id']);

        if ($innovation['status'] == '17') {
            $eic_app_date = $data['eic_app'] = $this->Mdiligence->get_landingInfo('application_status_log', $innovation['id'], 17);
        } else if ($innovation['status'] == '18') {
            $eic_app_date = $data['eic_app'] = $this->Mdiligence->get_landingInfo('application_status_log', $innovation['id'], 18);
        } else if ($innovation['status'] == '20' || ($innovation['stage'] == '12' && $innovation['status'] == '12')) {
            $data['eic_app'] = $this->Mdiligence->get_landingInfo('application_status_log', $innovation['id'], 17);
            $eic_app_date = $this->Mdiligence->get_landingInfo('application_status_log', $innovation['id'], 20);
        } else {
            $data['eic_app'] = "-N/A-";
            $eic_app_date = '';
        }

        if ($eic_app_date[0]['modified_date'] != '') {
            $data['eic_app_date'] = date('d-M-Y', strtotime($eic_app_date[0]['modified_date']));
        } else {
            $data['eic_app_date'] = '';
        }

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);

        $data['cpage'] = 'diligenceDashboard';
        $data['cpagetitle'] = $innovation['name_of_enterprise'];
        $this->load->view('../template', $data);
    }

    public function detailed_assessment($id) {
        $branch_id = $this->session->userdata('partner_id');
        $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
        $data['userbranch'] = $this->Mmaster->getYbranch($branch_id);
        $data['usersABIList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
        $data['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);

        $data['log_details'] = $this->Mincharge->getStatusLog($id);
        $empName = array();
        $modified_employer = array();

        foreach ($data['log_details'] as $key => $value) {

            $employees = explode(",", $data['log_details'][$key]['assigned_user']);

            foreach ($employees as $k => $val) {
                $empName = $this->Sector_model->getEmployeeNameByID($employees[$k]);
                $employees[$k] = $empName['emp_name'];
            }
            $data['log_details'][$key]['assigned_incharge'] = implode(", ", $employees);
            $modified_employer = $this->Sector_model->getEmployeeNameByID($data['log_details'][$key]['modified_by']);
            $data['log_details'][$key]['modified_by_user'] = $modified_employer['emp_name'];
        }

        $data['id'] = $id;
        $invID = 'INV' . $id;
        $data['masterData'] = $this->Mdiligence->get_data('company_master_data', $invID);
        $data['innovation'] = $innovation = $this->Minnovation->getinnovation($id);
        $data['inv_id_format'] = $data['innovation']['copy_id'] . "_" . $data['innovation']['partner_id'] . "_" . $data['innovation']['partner_count'];
        $get_sector = isset($data['masterData'][0]['sector']) && $data['masterData'][0]['sector'] != '' ? $data['masterData'][0]['sector'] : $innovation['sector'];
        $data['sector'] = $this->Minnovation->getSectorNamePitch($get_sector);
        if ($innovation['program'] == '3' || $innovation['program'] == '4') {
            $pitch_user = $this->Minnovation->get_pitch('pitch_user', $innovation['innovation_id']);
            $pitch_org = $this->Minnovation->get_pitch('pitch_step2', $pitch_user[0]['pitch_id']);
            $data['subsec_title'] = 'Sub Sector';
            $get_subsec_name = isset($data['masterData'][0]['sub_sector']) && $data['masterData'][0]['sub_sector'] != '' ? $data['masterData'][0]['sub_sector'] : $pitch_org[0]['sub_sector'];
            $subsec_name = $this->Minnovation->getSectorNamePitch($get_subsec_name);
            $data['subsector'] = $subsec_name[0]['sector'];
        } else if ($innovation['program'] == '0') {
            $inv_details = $this->Minnovation->get_innovation('inv_user', "INV" . $innovation['id']);
            $data['subsec_title'] = 'Sub Sector';
            $get_subsec_name = isset($data['masterData'][0]['sub_sector']) && $data['masterData'][0]['sub_sector'] != '' ? $data['masterData'][0]['sub_sector'] : $inv_details[0]['sub_sector'];
            $subsec_name = $this->Minnovation->getSectorNamePitch($get_subsec_name);
            $data['subsector'] = $subsec_name[0]['sector'];
        }
        $app_stage = $this->Minnovation->getInnvationStage();
        $app_status = $this->Minnovation->getInnvationStatus();
        $data['stage_name'] = $app_stage[$innovation['stage']];
        $data['status_name'] = $app_status[$innovation['status']];

        $data['get_diligence'] = $this->Mdiligence->get_lastdata('detailed_diligence', $innovation['innovation_id']);
        $data['version_log'] = $this->Mdiligence->get_data('detailed_diligence', $innovation['innovation_id']);

        if ($innovation['status'] == '17') {
            $eic_app = $this->Mdiligence->get_landingInfo('application_status_log', $innovation['id'], 17);
        } else if ($innovation['status'] == '18') {
            $eic_app = $this->Mdiligence->get_landingInfo('application_status_log', $innovation['id'], 18);
        } else if ($innovation['status'] == '20' || ($innovation['stage'] == '12' && $innovation['status'] == '12')) {
            $eic_app = $this->Mdiligence->get_landingInfo('application_status_log', $innovation['id'], 20);
        } else {
            $eic_app = "";
        }

        if ($eic_app[0]['modified_date'] != '') {
            $data['eic_date'] = date('d-M-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['inv_id'] = $innovation['innovation_id'];
        $data['cpage'] = 'detailedAssessment';

        $data['cpagetitle'] = $innovation['name_of_enterprise'];

        $this->load->view('../template', $data);
    }

    public function save_detailed_assessment() {
        $data['innovation_id'] = $inv_id = $_POST['inv_id'];
        $data['description'] = $desc['description'] = $this->db->escape_str($_POST['description']);
        $data['current_situation'] = $this->db->escape_str($_POST['current_situation']);
        $data['pre_money'] = $this->db->escape_str($_POST['pre_money']);
        $data['investment'] = $this->db->escape_str($_POST['investment']);
        $data['round_size'] = $this->db->escape_str($_POST['round_size']);
        $data['post_money'] = $this->db->escape_str($_POST['post_money']);
        $data['number_of_shares'] = $this->db->escape_str($_POST['number_of_shares']);
        $data['cap_table'] = $this->db->escape_str($_POST['cap_table']);
        $data['valuation'] = $this->db->escape_str($_POST['valuation_method']);
        $data['governance'] = $this->db->escape_str($_POST['governance']);
        $data['team_like'] = $this->db->escape_str($_POST['like_team']);
        $data['solution_fit'] = $this->db->escape_str($_POST['solution_fit']);
        $data['market_fit'] = $this->db->escape_str($_POST['market_fit']);
        $data['impact_potential'] = $this->db->escape_str($_POST['impact_potential']);
        $data['mandate_fit'] = $this->db->escape_str($_POST['mandate_fit']);
        $data['proposed_funding'] = $this->db->escape_str($_POST['proposed_funding']);
        $data['return_expectations'] = $this->db->escape_str($_POST['return_expectations']);
        $data['downstream'] = $this->db->escape_str($_POST['downstream']);
        $data['pain_points'] = $this->db->escape_str($_POST['pain_points']);
        $data['value_proposition'] = $this->db->escape_str($_POST['value_proposition']);
        $data['customer_segment'] = $this->db->escape_str($_POST['customer_segment']);
        $data['product_portfolio'] = $this->db->escape_str($_POST['product_portfolio']);
        $data['customer_channels'] = $this->db->escape_str($_POST['customer_channels']);
        $data['revenue_model'] = $this->db->escape_str($_POST['revenue_model']);
        $data['key_risks'] = $this->db->escape_str($_POST['key_risks']);
        $data['entry_point'] = $this->db->escape_str($_POST['entry_point']);
        $data['market_sizing'] = $this->db->escape_str($_POST['market_sizing']);
        $data['company_grow'] = $this->db->escape_str($_POST['company_grow']);
        $data['lever_deployed'] = $this->db->escape_str($_POST['lever_deployed']);
        $data['exit_point'] = $this->db->escape_str($_POST['exit_point']);
        $data['problem'] = $this->db->escape_str($_POST['problem']);
        $data['theory_of_change'] = $this->db->escape_str($_POST['theory_change']);
        $data['current_impact'] = $this->db->escape_str($_POST['current_impact']);
        $data['target_impact'] = $this->db->escape_str($_POST['target_impact']);
        $data['social_impact'] = $this->db->escape_str($_POST['social_impact']);
        $data['discuss_options'] = $this->db->escape_str($_POST['discuss_options']);
        $data['structure_terms_agreed'] = $this->db->escape_str($_POST['structure_terms']);
        $data['exit_options'] = $this->db->escape_str($_POST['exit_options']);
        $data['other_key_agreements'] = $this->db->escape_str($_POST['other_key']);
        $data['sector_summary'] = $this->db->escape_str($_POST['sector_summary']);
        $data['swot'] = $this->db->escape_str($_POST['swot']);
        $data['key_transaction'] = $this->db->escape_str($_POST['key_transaction']);
        $data['risks_mitigations'] = $this->db->escape_str($_POST['risks_mitigations']);
        $data['tranche_suggestions'] = $this->db->escape_str($_POST['tranche_suggestions']);
        $data['villgro_team'] = $this->db->escape_str($_POST['villgro_team']);
        $data['ic_inputs'] = $this->db->escape_str($_POST['ic_inputs']);
        $data['thoughts_opportunities'] = $this->db->escape_str($_POST['thoughts_opportunities']);

        if ($_POST['save_type'] == 'save_exist') {
            $get_innovation = $this->Mdiligence->get_data('detailed_diligence', $inv_id);
            if (!empty($get_innovation)) {
                $data['last_updated_by'] = $this->session->userdata['emp_number'];
                $data['last_updated_by_name'] = $this->session->userdata['emp_name'];
                $data['last_updated_at'] = date('Y-m-d H:i:s');
                foreach ($data as $key => $value) {
                    $update[$key] = $value;
                    $sendData = $this->Mdiligence->update_data('detailed_diligence', $update, $inv_id, $_POST['version']);
                    $update = array();
                }
                $txtmsg = 'updated';
            } else {
                $data['version'] = '0';
                $data['added_by'] = $this->session->userdata['emp_number'];
                $data['added_name'] = $this->session->userdata['emp_name'];
                $data['created_at'] = date('Y-m-d H:i:s');
                $sendData = $this->Mdiligence->insert_detailed_assessment('detailed_diligence', $desc);
                foreach ($data as $key => $value) {
                    $update[$key] = $value;
                    $updateData = $this->Mdiligence->update_detailed_assessment('detailed_diligence', $update, $sendData);
                    $update = array();
                }
                $txtmsg = 'saved';
            }
        } elseif ($_POST['save_type'] == 'save_version') {
            $get_innovation = $this->Mdiligence->get_lastdata('detailed_diligence', $inv_id);
            if (!empty($get_innovation)) {
                $data['version'] = number_format($get_innovation[0]['version'] + 1, 0);
            } else {
                $data['version'] = 0;
            }

            $data['added_by'] = $this->session->userdata['emp_number'];
            $data['added_name'] = $this->session->userdata['emp_name'];
            $data['created_at'] = date('Y-m-d H:i:s');
            $sendData = $this->Mdiligence->insert_detailed_assessment('detailed_diligence', $desc);
            foreach ($data as $key => $value) {
                $update[$key] = $value;
                $updateData = $this->Mdiligence->update_detailed_assessment('detailed_diligence', $update, $sendData);
                $update = array();
            }
            $txtmsg = 'saved as new version';
        }

        if ($sendData) {
            $this->session->set_userdata("detail_sucmsg", 'Detailed assessment successfully ' . $txtmsg);
            redirect('detailed_diligence/detailed_assessment/' . $_POST['id']);
        }
    }

    public function document_meeting($id) {
        $branch_id = $this->session->userdata('partner_id');
        $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
        $data['userbranch'] = $this->Mmaster->getYbranch($branch_id);
        $data['usersABIList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
        $data['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);

        $data['log_details'] = $this->Mincharge->getStatusLog($id);
        $empName = array();
        $modified_employer = array();

        foreach ($data['log_details'] as $key => $value) {
            $employees = explode(",", $data['log_details'][$key]['assigned_user']);
            foreach ($employees as $k => $val) {
                $empName = $this->Sector_model->getEmployeeNameByID($employees[$k]);
                $employees[$k] = $empName['emp_name'];
            }
            $data['log_details'][$key]['assigned_incharge'] = implode(", ", $employees);
            $modified_employer = $this->Sector_model->getEmployeeNameByID($data['log_details'][$key]['modified_by']);
            $data['log_details'][$key]['modified_by_user'] = $modified_employer['emp_name'];
        }

        $data['id'] = $id;
        $invID = 'INV' . $id;
        $data['masterData'] = $this->Mdiligence->get_data('company_master_data', $invID);
        $data['innovation'] = $innovation = $this->Minnovation->getinnovation($id);
        $data['inv_id_format'] = $data['innovation']['copy_id'] . "_" . $data['innovation']['partner_id'] . "_" . $data['innovation']['partner_count'];
        $get_sector = isset($data['masterData'][0]['sector']) && $data['masterData'][0]['sector'] != '' ? $data['masterData'][0]['sector'] : $innovation['sector'];
        $data['sector'] = $this->Minnovation->getSectorNamePitch($get_sector);
        if ($innovation['program'] == '3' || $innovation['program'] == '4') {
            $pitch_user = $this->Minnovation->get_pitch('pitch_user', $innovation['innovation_id']);
            $pitch_org = $this->Minnovation->get_pitch('pitch_step2', $pitch_user[0]['pitch_id']);
            $data['subsec_title'] = 'Sub Sector';
            $get_subsec_name = isset($data['masterData'][0]['sub_sector']) && $data['masterData'][0]['sub_sector'] != '' ? $data['masterData'][0]['sub_sector'] : $pitch_org[0]['sub_sector'];
            $subsec_name = $this->Minnovation->getSectorNamePitch($get_subsec_name);
            $data['subsector'] = $subsec_name[0]['sector'];
        } else if ($innovation['program'] == '0') {
            $inv_details = $this->Minnovation->get_innovation('inv_user', "INV" . $innovation['id']);
            $data['subsec_title'] = 'Sub Sector';
            $get_subsec_name = isset($data['masterData'][0]['sub_sector']) && $data['masterData'][0]['sub_sector'] != '' ? $data['masterData'][0]['sub_sector'] : $inv_details[0]['sub_sector'];
            $subsec_name = $this->Minnovation->getSectorNamePitch($get_subsec_name);
            $data['subsector'] = $subsec_name[0]['sector'];
        }
        $app_stage = $this->Minnovation->getInnvationStage();
        $app_status = $this->Minnovation->getInnvationStatus();
        $data['stage_name'] = $app_stage[$innovation['stage']];
        $data['status_name'] = $app_status[$innovation['status']];
        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['doc_type'] = $this->Mdiligence->get_data('diligence_document_types');
        $data['meeting_type'] = $this->Mdiligence->get_data('diligence_meeting_type');

        $data['nda_list'] = $this->Mdiligence->get_data('diligence_document', $innovation['innovation_id'], '1');
        $data['quest_list'] = $this->Mdiligence->get_data('diligence_document', $innovation['innovation_id'], '2');
        $data['term_list'] = $this->Mdiligence->get_data('diligence_document', $innovation['innovation_id'], '3');
        $data['service_list'] = $this->Mdiligence->get_data('diligence_document', $innovation['innovation_id'], '4');
        $data['compnay_list'] = $this->Mdiligence->get_data('diligence_document', $innovation['innovation_id'], '5');
        $data['villgro_list'] = $this->Mdiligence->get_data('diligence_document', $innovation['innovation_id'], '6');
        $data['type_list'] = $this->Mdiligence->get_otherDoc($innovation['innovation_id']);

        $data['meeting_list'] = $this->Mdiligence->get_meetingDoc($innovation['innovation_id']);

        if ($innovation['status'] == '17') {
            $eic_app = $this->Mdiligence->get_landingInfo('application_status_log', $innovation['id'], 17);
        } else if ($innovation['status'] == '18') {
            $eic_app = $this->Mdiligence->get_landingInfo('application_status_log', $innovation['id'], 18);
        } else if ($innovation['status'] == '20' || ($innovation['stage'] == '12' && $innovation['status'] == '12')) {
            $eic_app = $this->Mdiligence->get_landingInfo('application_status_log', $innovation['id'], 20);
        } else {
            $eic_app = "";
        }

        if ($eic_app[0]['modified_date'] != '') {
            $data['eic_date'] = date('d-M-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $data['cpage'] = 'documentMeeting';
        $data['cpagetitle'] = $innovation['name_of_enterprise'];
        $this->load->view('../template', $data);
    }

    public function save_document() {
        if ($_POST['doc_type'] != '' && $_POST['txt_desc'] != '' && ($_FILES["file_doc"]["name"] != '' || $_POST['file_doc_old'] != '')) {
            $data['innovation_id'] = $_POST['inv_id'];
            $data['doc_type'] = $this->db->escape_str($_POST['doc_type']);
            $get_nam = $this->Mdiligence->get_documentName('diligence_document_types', $_POST['doc_type']);
            $data['description'] = $this->db->escape_str($_POST['txt_desc']);
            $data['added_by_id'] = $this->session->userdata['emp_number'];
            $data['added_by_name'] = $this->session->userdata['emp_name'];
            $data['created_at'] = date('Y-m-d H:i:s');

            $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/detailed_diligence';
            $resume_path = '';
            if ($_FILES["file_doc"]["name"] != "") {
                $this->load->library('upload');
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';
                $file_name = explode('.', $_FILES["file_doc"]["name"]);
                $file_ext = end(explode('.', $_FILES["file_doc"]["name"]));
                $sliced = array_slice($file_name, 0, -1);
                $string = implode(" ", $sliced);
                $change_first = str_replace('.', '-', $string);
                $change_name = str_replace(' ', '-', $change_first . '.' . $file_ext);
                $config['file_name'] = date('Ymdhis') . '_document_' . str_replace('_', '-', $change_name);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('file_doc')) {
                    $upload_error = $this->upload->display_errors();
                    echo $upload_error;
                } else {
                    $upload_data = $this->upload->data();
                    $resume_path = $upload_data['file_name'];
                }
                unset($config);
                $data['document'] = $resume_path;
            } else if (isset($_POST['file_doc_old']) && $resume_path == '') {
                $data['document'] = $_POST['file_doc_old'];
            }

            $get_value = $this->Mdiligence->check_docExist('diligence_document', $_POST['inv_id'], $_POST['doc_type']);
            if (!empty($get_value)) {
                $data['status'] = 1;
                $send_data = $this->Mdiligence->update_data('diligence_document', $data, $_POST['inv_id'], '', $_POST['doc_type']);
                $txtmsg = 'updated';
            } else {
                $send_data = $this->Mdiligence->insert_data('diligence_document', $data);
                $txtmsg = 'inserted';
            }
            if ($send_data) {
                $this->session->set_userdata("document_sucmsg", $get_nam[0]['name'] . ' successfully ' . $txtmsg);
                $this->session->set_userdata("document_active", 1);
                redirect('detailed_diligence/document_meeting/' . $_POST['id']);
            }
        } else {
            $this->session->set_userdata("document_errmsg", 'Some information missing');
            $this->session->set_userdata("document_active", 1);
            redirect('detailed_diligence/document_meeting/' . $_POST['id']);
        }
    }

    public function delete_action() {
        $data['status'] = 2;
        $get_nam = $this->Mdiligence->delete_action($_POST['table'], $data, $_POST['id']);
    }

    public function save_meeting() {
        if ($_POST['meet_type'] != '' && $_POST['meet_desc'] != '' && ($_FILES["meet_doc"]["name"] != '' || $_POST['meet_doc_old'] != '')) {
            $data['innovation_id'] = $_POST['inv_id'];
            $meeting_id = $_POST['meeting_id'];
            $data['meeting_date'] = date('Y-m-d', strtotime($_POST['meet_date']));
            $data['meeting_type'] = $this->db->escape_str($_POST['meet_type']);
            $get_nam = $this->Mdiligence->get_documentName('diligence_meeting_type', $_POST['meet_type']);
            $data['comments'] = $this->db->escape_str($_POST['meet_desc']);
            $data['added_by_id'] = $this->session->userdata['emp_number'];
            $data['added_by_name'] = $this->session->userdata['emp_name'];
            $data['added_on'] = date('Y-m-d H:i:s');

            $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/detailed_diligence';
            $resume_path = '';
            if ($_FILES["meet_doc"]["name"] != "") {
                $this->load->library('upload');
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';
                $file_name = explode('.', $_FILES["meet_doc"]["name"]);
                $file_ext = end(explode('.', $_FILES["meet_doc"]["name"]));
                $sliced = array_slice($file_name, 0, -1);
                $string = implode(" ", $sliced);
                $change_first = str_replace('.', '-', $string);
                $change_name = str_replace(' ', '-', $change_first . '.' . $file_ext);
                $config['file_name'] = date('Ymdhis') . '_meeting_' . str_replace('_', '-', $change_name);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('meet_doc')) {
                    $upload_error = $this->upload->display_errors();
                    echo $upload_error;
                } else {
                    $upload_data = $this->upload->data();
                    $resume_path = $upload_data['file_name'];
                }
                unset($config);
                $data['meeting_doc'] = $resume_path;
            } else if (isset($_POST['meet_doc_old']) && $resume_path == '') {
                $data['meeting_doc'] = $_POST['meet_doc_old'];
            }

            if ($meeting_id != '') {
                $data['status'] = 1;
                $send_data = $this->Mdiligence->update_meeting('diligence_meeting', $data, $meeting_id);
                $txtmsg = 'updated';
            } else {
                $send_data = $this->Mdiligence->insert_data('diligence_meeting', $data);
                $txtmsg = 'inserted';
            }
            if ($send_data) {
                $this->session->set_userdata("document_sucmsg", $get_nam[0]['name'] . ' successfully ' . $txtmsg);
                $this->session->set_userdata("document_active", 2);
                redirect('detailed_diligence/document_meeting/' . $_POST['id']);
            }
        } else {
            $this->session->set_userdata("document_errmsg", 'Some information missing');
            $this->session->set_userdata("document_active", 2);
            redirect('detailed_diligence/document_meeting/' . $_POST['id']);
        }
    }

    public function export_ppt($id, $version = '') {

        if ($version != '') {
            $get_records = $this->Mdiligence->get_lastdata('detailed_diligence', $id, $version);
        } else {
            $get_records = $this->Mdiligence->get_lastdata('detailed_diligence', $id);
        }

        $innovation = $this->Mdiligence->get_lastdata('innovation_pool', $id);
        $company_details = $this->Mdiligence->get_data('company_master_data', $id);
        $share_details = $this->Mdiligence->get_lastdata('share_details', $id);

        $sector_name = $this->Minnovation->getSectorNamePitch($innovation[0]['sector']);
        $program_name = $innovation[0]['program'];
        if ($program_name == '3') {
            $pitch_user = $this->Minnovation->get_pitch('pitch_user', $id);
            $pitch_sector = $this->Minnovation->get_pitch('pitch_step2', $pitch_user[0]['pitch_id']);
            $team_members = $this->Minnovation->get_pitch('pitch_step1_members', $pitch_user[0]['pitch_id']);
            $sub_sector_title = 'Sub Sector';
            $get_sector_name = $this->Minnovation->getSectorNamePitch($pitch_sector[0]['sub_sector']);
            $sub_sector_name = $get_sector_name[0]['sector'];
        } else if ($program_name == '0') {
            $inv_details = $this->Minnovation->get_innovation('inv_user', "INV" . $innovation[0]['id']);
            $team_members = $this->Minnovation->get_innovation('inv_member', $inv_details[0]['id']);
            $sub_sector_title = 'Sub Sector';
            $subsec_name = $this->Minnovation->getSectorNamePitch($inv_details[0]['sub_sector']);
            $sub_sector_name = $subsec_name[0]['sector'];
        }

        $data['stage'] = $stage = $this->Minnovation->getInnvationStage();
        $data['status'] = $status = $this->Minnovation->getInnvationStatus();
        $app_stage = $stage[$innovation[0]['stage']];
        $app_status = $status[$innovation[0]['status']];

        $assign_to = $this->Minnovation->getAssignIncharge($innovation[0]['id'], 2);
        $src_logo = 'logo.png';

        if ($program_name == '1') {
            $app_name = 'EIR';
        } else if ($program_name == '2') {
            $app_name = 'SEED';
        } else if ($program_name == '3') {
            $app_name = 'Unc Pitch';
        } else {
            $app_name = 'Incubation';
        }

        $date = $innovation[0]['created_date'];
        $dt = new DateTime($date);
        $formatted_date = $dt->format('d-m-Y');

        include_once APPPATH . 'libraries/PhpPresentation/samples/Sample_Header.php';

        $Alignment = new PhpOffice\PhpPresentation\Style\Alignment();
        $Color = new PhpOffice\PhpPresentation\Style\Color();
        $Fill = new PhpOffice\PhpPresentation\Style\Fill();
        $Bullet = new PhpOffice\PhpPresentation\Style\Bullet();
        $IOFactory = new PhpOffice\PhpPresentation\IOFactory();

        echo date('H:i:s') . ' Create new PHPPresentation object' . EOL;
        $objPHPPresentation = new PhpOffice\PhpPresentation\PhpPresentation();

        echo date('H:i:s') . ' Set properties' . EOL;
        $objPHPPresentation->getDocumentProperties()->setCreator('PHPOffice')
        ->setLastModifiedBy('PHPPresentation Team')
        ->setTitle('Sample 01 Title')
        ->setSubject('Sample 01 Subject')
        ->setDescription('Sample 01 Description')
        ->setKeywords('office 2007 openxml libreoffice odt php')
        ->setCategory('Sample Category');

        echo date('H:i:s') . ' Create slide' . EOL;
        $currentGroup = $objPHPPresentation->getActiveSlide()->createGroup();

        echo date('H:i:s') . ' Create a shape (drawing)' . EOL;
        $shape = $currentGroup->createDrawingShape();
        $shape->setName('Villgro Logo')
        ->setDescription('Villgro Logo')
        ->setPath('./resources/logo.png')
        ->setHeight(90)
        ->setOffsetX(750)
        ->setOffsetY(10);

        echo date('H:i:s') . ' Create a shape (rich text)' . EOL;
        $shape = $currentGroup->createRichTextShape()
        ->setHeight(300)
        ->setWidth(600)
        ->setOffsetX(170)
        ->setOffsetY(230);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal($Alignment::HORIZONTAL_CENTER);
        $textRun = $shape->createTextRun(ucfirst($innovation[0]['name_of_enterprise']));
        $textRun->getFont()->setBold(true)
        ->setSize(40)
        ->setColor(new PhpOffice\PhpPresentation\Style\Color('000'));

        $shape->getActiveParagraph()->createBreak();
        $shape->createParagraph()->getAlignment()->setHorizontal($Alignment::HORIZONTAL_CENTER);
        $content = $shape->createTextRun('Detailed Assessment - Version ' . $get_records[0]['version']);
        $content->getFont()->setBold(true)
        ->setSize(20)
        ->setColor(new PhpOffice\PhpPresentation\Style\Color('000'));

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Executive Summary');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Name of the Enterprise')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(ucfirst($innovation[0]['name_of_enterprise']))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Name of the Entrepreneur')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(ucfirst($innovation[0]['name_of_entrepreneur']))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        if ($sub_sector_name != '') {
            $sector_title = 'Sector and Sub-Sector';
            $sector_value = $sector_name[0]['sector'] . ', ' . $sub_sector_name;
        } else {
            $sector_title = 'Sector';
            $sector_value = $sector_name[0]['sector'];
        }

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun($sector_title)->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun($sector_value)->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Background/ Description');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Background/ Description')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['description'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Current Situation/ Next Steps');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Current Situation/ Next Steps')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['current_situation'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Investment Structure and Returns');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Pre-money Valuation')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['pre_money'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Investment Amount')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['investment'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Round size')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['round_size'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Post Money')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['post_money'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Investment Structure and Returns');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Number of Shares')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['number_of_shares'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Cap-table')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['cap_table'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Valuation Methodology')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['valuation'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Governance – Board Structure')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['governance'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Investment Thesis');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Why do we like this team?')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['team_like'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Problem Solution Fit')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['solution_fit'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Product Market Fit')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['market_fit'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Impact Potential')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['impact_potential'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Investment Thesis');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Mandate Fit')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['mandate_fit'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Current Status of the Company, Achievements with our proposed funding')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['proposed_funding'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Return Expectations')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['return_expectations'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Downstream Investor’s view')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['downstream'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Business Model');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Pain points')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['pain_points'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Value proposition')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['value_proposition'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Customer Segment')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['customer_segment'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Product Portfolio')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['product_portfolio'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Business Model');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Customer Channels')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['customer_channels'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Revenue Model')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['revenue_model'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Key Risks and Challenges')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['key_risks'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Launch and scaling strategy of the company');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Entry point')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['entry_point'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Market Sizing')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['market_sizing'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('How will the company grow?')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['company_grow'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Which lever is being deployed?')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['lever_deployed'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Launch and scaling strategy of the company');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Exit point')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['exit_point'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Social Impact');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Problem')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['problem'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Theory of Change')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['theory_of_change'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Current impact, if any')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['current_impact'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Target impact')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['target_impact'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Social Impact');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Social Impact Metrics')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['social_impact'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Exit Options');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Discuss options as per SHA')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['discuss_options'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Existing investors and strategic partners');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Include structure and terms agreed with earlier investors')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['structure_terms_agreed'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Exit Options');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Exit Options')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['exit_options'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Summary of other key Agreements');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Summary of other key Agreements')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['other_key_agreements'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Sector summary and key Drivers');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Sector summary and key Drivers')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['sector_summary'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'SWOT');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('SWOT')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['swot'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Key Transaction Terms');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Key Transaction Terms')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['key_transaction'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Risks and Mitigations');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Risks and Mitigations')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['risks_mitigations'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Timing & Next Steps');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Tranche suggestions for funding')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['tranche_suggestions'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'Villgro Team');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Villgro Team')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['villgro_team'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $tableSlide = createTemplatedSlide($objPHPPresentation, 'IC Decision');
        $shape = $tableSlide->createTableShape(2);
        $shape->setHeight(900);
        $shape->setWidth(800);
        $shape->setOffsetX(70);
        $shape->setOffsetY(150);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('IC Inputs')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['ic_inputs'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $row = $shape->createRow();
        $row->setHeight(100);
        $oCell = $row->nextCell();
        $oCell->createTextRun('Summary of thoughts – opportunities and things to watch')->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);
        $oCell = $row->nextCell();
        $oCell->createTextRun(html_entity_decode($this->first20words($get_records[0]['thoughts_opportunities'])))->getFont()->setSize(15)->setBold(true);
        $oCell->getActiveParagraph()->getAlignment()
        ->setMarginBottom(10)
        ->setMarginTop(20)
        ->setMarginRight(30)
        ->setMarginLeft(20);

        $getName = $innovation[0]['innovation_id'] . '_assessment_V' . $get_records[0]['version'];

        echo write($objPHPPresentation, $getName, $writers);
    }

    public function export_assessment($id, $version = '') {
        if ($version != '') {
            $get_records = $this->Mdiligence->get_lastdata('detailed_diligence', $id, $version);
        } else {
            $get_records = $this->Mdiligence->get_lastdata('detailed_diligence', $id);
        }
        $innovation = $this->Mdiligence->get_lastdata('innovation_pool', $id);

        $share_details = $this->Mdiligence->get_lastdata('share_details', $id);

        $sector_name = $this->Minnovation->getSectorNamePitch($innovation[0]['sector']);
        $program_name = $innovation[0]['program'];
        if ($program_name == '3') {
            $pitch_user = $this->Minnovation->get_pitch('pitch_user', $id);
            $pitch_sector = $this->Minnovation->get_pitch('pitch_step2', $pitch_user[0]['pitch_id']);
            $team_members = $this->Minnovation->get_pitch('pitch_step1_members', $pitch_user[0]['pitch_id']);
            $sub_sector_title = 'Sub Sector';
            $get_sector_name = $this->Minnovation->getSectorNamePitch($pitch_sector[0]['sub_sector']);
            $sub_sector_name = $get_sector_name[0]['sector'];
        } else if ($program_name == '0') {
            $inv_details = $this->Minnovation->get_innovation('inv_user', "INV" . $innovation[0]['id']);
            $team_members = $this->Minnovation->get_innovation('inv_member', $inv_details[0]['id']);
            $sub_sector_title = 'Sub Sector';
            $subsec_name = $this->Minnovation->getSectorNamePitch($inv_details[0]['sub_sector']);
            $sub_sector_name = $subsec_name[0]['sector'];
        }

        $data['stage'] = $stage = $this->Minnovation->getInnvationStage();
        $data['status'] = $status = $this->Minnovation->getInnvationStatus();
        $app_stage = $stage[$innovation[0]['stage']];
        $app_status = $status[$innovation[0]['status']];

        $assign_to = $this->Minnovation->getAssignIncharge($innovation[0]['id'], 2);
        $src_logo = 'logo.png';

        if ($program_name == '1') {
            $app_name = 'EIR';
        } else if ($program_name == '2') {
            $app_name = 'SEED';
        } else if ($program_name == '3') {
            $app_name = 'Unc Pitch';
        } else {
            $app_name = 'Incubation';
        }

        $this->load->library('Phpword');

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->getCompatibility()->setOoxmlVersion(14);
        $phpWord->getCompatibility()->setOoxmlVersion(15);
        $phpWord->addFontStyle('title_Style', array('bold' => true, 'italic' => true, 'size' => 14));
        $phpWord->addParagraphStyle('para_Style', array('align' => 'both', 'spaceAfter' => 100));

        $section = $phpWord->addSection();
        $footer = $section->addFooter();
        $footer->addPreserveText('CONFIDENTIAL | Page {PAGE} of {NUMPAGES}', null, array('align' => 'center'));
        $section->addImage($src_logo, array(
            'width' => 130,
            'height' => 60,
            'align' => 'right',
            'wrappingStyle' => 'square',
            'positioning' => 'absolute',
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line',
        ));
        $section->addTextBreak(5);
        $member_count = php72_count($team_members);
        $share_count = php72_count($share_details);
        $styleCell = array('borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', 'space' => array('before' => 360, 'after' => 280), 'indentation' => array('left' => 540, 'right' => 120));
        $styleRightCell = array('borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', 'space' => array('before' => 360, 'after' => 280), 'indentation' => array('left' => 540, 'right' => 120));

        $headCell = array('borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', 'bgColor' => 'E2E2E2');
        $teamCell = array('borderRightSize' => 1, 'borderRightColor' => 'black', 'space' => array('before' => 360, 'after' => 280), 'indentation' => array('left' => 540, 'right' => 120));

        $fontStyle = array('size' => 13, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0);
        $TfontStyle = array('bold' => true, 'size' => 13, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0);

        $noSpace = array('textBottomSpacing' => -1);

        $title = 'Detailed Assessment - ' . ucfirst($innovation[0]['name_of_enterprise']) . ' - Version ' . $get_records[0]['version'];
        $section->addText($title, ['size' => 16], ['align' => \PhpOffice\PhpWord\Style\Alignment::ALIGN_CENTER]);
        $section->addTextBreak(3);

        $table = $section->addTable('myOwnTableStyle', array('borderRightSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0));
        $table2 = $section->addTable('myOwnTableStyle2');
        $table->addRow(700, array("exactHeight" => true));

        $table->addCell(3000, $styleCell)->addText('Name of Enterprise', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(ucfirst($innovation[0]['name_of_enterprise']), $fontStyle);
        $table->addRow(700, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Sector', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($sector_name[0]['sector']), $fontStyle);
        $table->addRow(700, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Sub-Sector', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($sub_sector_name), $fontStyle);

        if ($program_name == '3') {
            for ($i = 0; $i < $member_count; $i++) {
                if ($team_members[$i]['name'] != '') {
                    $j = $i + 1;
                    $team_title = "Team " . $j;
                    $table->addRow(600, array("exactHeight" => true));
                    $table->addCell(3000, $teamCell)->addText($team_title, $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
                    $table->addCell(7000, $styleRightCell)->addText(ucfirst($team_members[$i]['name']), $fontStyle);
                    $table->addRow(600, array("exactHeight" => true));
                    $table->addCell(3000, $teamCell)->addText();
                    $table->addCell(7000, $styleRightCell)->addText($team_members[$i]['email'], $fontStyle);
                    $table->addRow(600, array("exactHeight" => true));
                    $table->addCell(3000, $teamCell)->addText();
                    $table->addCell(7000, $styleRightCell)->addText($team_members[$i]['phone'], $fontStyle);
                    $table->addRow(600, array("exactHeight" => true));
                    $table->addCell(3000, $styleCell)->addText();
                    $table->addCell(7000, $styleRightCell)->addText(ucfirst($team_members[$i]['gender']), $fontStyle);
                }
            }
        } else if ($program_name == '0') {
            for ($i = 0; $i < $member_count; $i++) {
                if ($team_members[$i]['mem_name'] != '') {
                    $j = $i + 1;
                    $team_title = "Team " . $j;
                    $table->addRow(400, array("exactHeight" => true));
                    $table->addCell(3000, $teamCell)->addText($team_title, $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
                    $table->addCell(7000, $styleRightCell)->addText(ucfirst($team_members[$i]['mem_name']), $fontStyle);
                    $table->addRow(400, array("exactHeight" => true));
                    $table->addCell(3000, $teamCell)->addText();
                    $table->addCell(7000, $styleRightCell)->addText($team_members[$i]['mem_occupation'], $fontStyle);
                    $table->addRow(400, array("exactHeight" => true));
                    $table->addCell(3000, $teamCell)->addText();
                    $table->addCell(7000, $styleRightCell)->addText($team_members[$i]['mem_org'], $fontStyle);
                    $table->addRow(400, array("exactHeight" => true));
                    $table->addCell(3000, $styleCell)->addText();
                    $table->addCell(7000, $styleRightCell)->addText(ucfirst($team_members[$i]['mem_email']), $fontStyle);
                    $table->addRow(400, array("exactHeight" => true));
                    $table->addCell(3000, $styleCell)->addText();
                    $table->addCell(7000, $styleRightCell)->addText(ucfirst($team_members[$i]['mem_gender']), $fontStyle);
                }
            }
        }

        $section->addPageBreak();
        $section->addImage($src_logo, array(
            'width' => 130,
            'height' => 60,
            'wrappingStyle' => 'square',
            'positioning' => 'absolute',
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line',
        ));
        $section->addTextBreak(5);
        $table = $section->addTable();

        $table->addRow(600, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Executive Summary', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText('', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addRow(800, array("exactHeight" => true));
        $table->addCell(3000, $headCell)->addText('Term', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $headCell)->addText('Description / Remarks', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Background/ Description', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['description']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Current Situation/ Next Steps', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['current_situation']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Pre-money Valuation', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['pre_money']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Investment Amount', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['investment']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Round size', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['round_size']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Post Money', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['post_money']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Number of Shares', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['number_of_shares']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Cap-table', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['cap_table']), $fontStyle);

        $section->addPageBreak();
        $section->addImage($src_logo, array(
            'width' => 130,
            'height' => 60,
            'wrappingStyle' => 'square',
            'positioning' => 'absolute',
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line',
        ));
        $section->addTextBreak(5);
        $table = $section->addTable();

        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Valuation Methodology', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['valuation']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Governance – Board Structure', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['governance']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Why do we like this team?', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['team_like']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Problem Solution Fit', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['solution_fit']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Product Market Fit', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['market_fit']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Impact Potential', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['impact_potential']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Mandate Fit', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['mandate_fit']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Current Status of the Company, Achievements with our proposed funding', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['proposed_funding']), $fontStyle);

        $section->addPageBreak();
        $section->addImage($src_logo, array(
            'width' => 130,
            'height' => 60,
            'wrappingStyle' => 'square',
            'positioning' => 'absolute',
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line',
        ));
        $section->addTextBreak(5);
        $table = $section->addTable();

        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Return Expectations', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['return_expectations']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Downstream Investor’s view', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['downstream']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Pain points', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['pain_points']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Value proposition', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['value_proposition']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Customer Segment', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['customer_segment']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Product Portfolio', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['product_portfolio']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Customer Channels', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['customer_channels']), $fontStyle);

        $section->addPageBreak();
        $section->addImage($src_logo, array(
            'width' => 130,
            'height' => 60,
            'wrappingStyle' => 'square',
            'positioning' => 'absolute',
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line',
        ));
        $section->addTextBreak(5);
        $table = $section->addTable();

        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Revenue Model', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['revenue_model']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Key Risks and Challenges', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['key_risks']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Entry point', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['entry_point']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Market Sizing', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['market_sizing']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('How will the company grow?', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['company_grow']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Which lever is being deployed?', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['lever_deployed']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Exit point', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['exit_point']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Problem', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['problem']), $fontStyle);

        $section->addPageBreak();
        $section->addImage($src_logo, array(
            'width' => 130,
            'height' => 60,
            'wrappingStyle' => 'square',
            'positioning' => 'absolute',
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line',
        ));
        $section->addTextBreak(5);
        $table = $section->addTable();

        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Theory of Change', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['theory_of_change']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Current impact, if any', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['current_impact']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Target impact', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['target_impact']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Social Impact Metrics', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['social_impact']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Discuss options as per SHA', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['discuss_options']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Include structure and terms agreed with earlier investors', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['structure_terms_agreed']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Exit Options', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['exit_options']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Summary of other key Agreements', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['other_key_agreements']), $fontStyle);

        $section->addPageBreak();
        $section->addImage($src_logo, array(
            'width' => 130,
            'height' => 60,
            'wrappingStyle' => 'square',
            'positioning' => 'absolute',
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line',
        ));
        $section->addTextBreak(5);
        $table = $section->addTable();

        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Sector summary and key Drivers', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['sector_summary']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('SWOT', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['swot']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Key Transaction Terms', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['key_transaction']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Risks and Mitigations', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['risks_mitigations']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Tranche suggestions for funding', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['tranche_suggestions']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Villgro Team', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['villgro_team']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('IC Inputs', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['ic_inputs']), $fontStyle);
        $table->addRow(1350, array("exactHeight" => true));
        $table->addCell(3000, $styleCell)->addText('Summary of thoughts – opportunities and things to watch', $TfontStyle, array('align' => 'left', 'spaceAfter' => 0));
        $table->addCell(7000, $styleRightCell)->addText(htmlspecialchars($get_records[0]['thoughts_opportunities']), $fontStyle);

        $filename = $innovation[0]['innovation_id'] . '_assessment_V' . $get_records[0]['version'] . '.docx';
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filename);

        header('Content-Description: File Transfer');
        header('Content-Type: text/html; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        flush();
        readfile($filename);
        unlink($filename);
    }

    public function remove_member() {
        $id = $this->input->post('id');
        $member_data = array(
            'status' => 2,
            'modified_date' => date('Y-m-d H:i:s'),
        );
        $user_where = array('id' => $id);
        $table = "management_team";
        $result = $this->Minnovation->pitch_update($table, $member_data, $user_where);
    }

    public function remove_share() {
        $id = $this->input->post('id');
        $member_data = array(
            'status' => 2,
            'modified_date' => date('Y-m-d H:i:s'),
        );
        $user_where = array('id' => $id);
        $table = "share_details";
        $result = $this->Minnovation->pitch_update($table, $member_data, $user_where);
    }

    public function export_checklist() {
        $data = array();
        $this->db->select("checklist_master.*,(select master_name from master_settings where id=checklist_master.area) as master_name");
        $this->db->order_by('area', 'asc');
        $this->db->where('status', '1');
        $query = $this->db->get('checklist_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Villgro")
        ->setLastModifiedBy("Villgro")
        ->setTitle("Documents Master List")
        ->setSubject("Documents Master List")
        ->setDescription("Documents Master List")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Documents Master List");

        $objPHPExcel->setActiveSheetIndex(0);
        $styletitle = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Times New Roman',
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'A9CF55'),
            ),
        );
        $styleheader = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman',
            ));
        $stylebody = array(
            'text-align' => 'left',
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman',
            ));
        $dataStyle = array('alignment' => array('wrap' => true, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP));
        $objPHPExcel->getActiveSheet()->getStyle('A1:B' . $objPHPExcel->getActiveSheet()->getHighestRow())
        ->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()
        ->getStyle('B')
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(70);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '1')->applyFromArray($styletitle);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '1', 'Documents Master List');

        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '2')->applyFromArray($styleheader);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '2', 'S.No');
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '2')->applyFromArray($styleheader);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '2', 'Master Name');
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('2', '2')->applyFromArray($styleheader);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2', '2', 'Description');

        $key = 0;
        $j = 3;
        foreach ($data as $row):
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $j)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $j, ++$key);

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $j)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $j, $row['master_name']);

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('2', $j)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2', $j, $row['document_description']);

            $j++;
        endforeach;

        $file_name = 'documents_master_list.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_name . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
        exit;
    }

    public function first20words($s, $limit = 15) {
        return preg_replace('/((\w+\W*){' . ($limit - 1) . '}(\w+))(.*)/', '${1}...', $s);
    }

}
