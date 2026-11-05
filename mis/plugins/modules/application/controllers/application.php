<?php

class Application extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->library('upload');
        $this->load->model('login/Muser');
        $this->load->model('common/Mmail');
        $this->load->model('Mapplication');
        $this->load->model('master/Mmaster');
        $this->load->model('login/Mdiligence');
        $this->load->model('scouting/Mincharge');
        $this->load->model('master/Sector_model');
        $this->load->model('common/Malldocument');
        $this->load->model('portfolio/Mportfolio');
        $this->load->model('scouting/Minnovation');
        $this->load->model('screening/Mscreening');
        $this->load->model('master/Mmailtemplate');
        $this->load->model('assessment/Massessment');
        $this->load->model('master/Mmaster_settings');
    }

    public function app_assign_incharge($id) {
        $asArray = array();
        $associate = $this->Mincharge->getAssociate(array('innovation' => $id, 'active' => 'Active'));

        foreach ($associate as $as):
            $asArray[] = $as['emp_name'];
        endforeach;
        $row = implode(', ', $asArray);
        return $row;
    }

    public function add_deal() {
        $partner_id = $this->session->userdata('partner_id');
        $getLastInnovation_id = $this->Mapplication->getLastInnovationID();
        $increment_val = $getLastInnovation_id[0]['id'] + 1;
        $data['inv_id'] = $increment_val . '_0' . $partner_id . '_01';

        $data['country_list'] = $this->Minnovation->getCountry();
        $data['branch'] = $this->Mmaster->getBranch();
        $data['sector_details'] = $this->Sector_model->getIncSectors('incubation');

        $this->load->vars($data);
        if ($partner_id == '2') {
            $this->load->view('application/incubatee/add_kenya_info');
        } else {
            $this->load->view('application/incubatee/add_basic_info');
        }
    }

    public function add_kenya_details() {
/////////////////////////////// Innovation table insert ///////////////////////////////////
        $partnerdeal1 = $this->session->userdata('partner_id');
        $innovationpartnerid1 = str_pad($partnerdeal1, 2, "0", STR_PAD_LEFT);

        $innovation_data = array(
            'name_of_entrepreneur' => $this->db->escape_str($this->input->post('txtEntrepreneur')),
            'name_of_enterprise' => $this->db->escape_str($this->input->post('txtEnterprise')),
            'email_id' => $this->db->escape_str($this->input->post('txtEmail')),
            'mobile_no' => $this->db->escape_str($this->input->post('txtMobile')),
            'status' => '12',
            'stage' => '7',
            'program' => '0',
            'source' => '-1',
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('emp_number'),
            'partner_id' => $innovationpartnerid1
        );
        $table = "innovation_pool";
        $inc_inv_id = $this->Minnovation->pitch_insert($table, $innovation_data);
//////////////////////////// Innovation table insert ends /////////////////////////////////////
////////////////////// Innovation user insert/////////////////////
        $stat = "Completed";
        $inv_user_data = array(
            'inv_no' => 'INV' . $inc_inv_id,
            'ent_name' => $this->db->escape_str($this->input->post('txtEnterprise')),
            'applicant_name' => $this->db->escape_str($this->input->post('txtEntrepreneur')),
            'email' => $this->db->escape_str($this->input->post('txtEmail')),
            'mobile' => $this->db->escape_str($this->input->post('txtMobile')),
            'ent_type' => $this->db->escape_str($this->input->post('txtProfit')),
            'benificiary' => serialize($this->input->post('txtBeneficiary')),
            'impact_of_product' => $this->db->escape_str($this->input->post('txtImpact')),
            'website' => $this->db->escape_str($this->input->post('txtWebsite')),
            'status' => 'Completed',
            'created_date' => date('Y-m-d'),
            'submitted_date' => date('Y-m-d')
        );

        $table = "inv_user";
        $inv_user_id = $this->Minnovation->pitch_insert($table, $inv_user_data);

        $this->session->set_flashdata('successMsg', 'Deals added successfully');
        redirect('application/basic_info/' . $inc_inv_id);
    }

    public function add_basic_details() {
        if ($this->input->post('txtCountry') != '') {
            $country_name = $this->Minnovation->getCountryName($this->input->post('txtCountry'));
            $count_name = $country_name[0];
        }
/////////////////////////////// Innovation table insert ///////////////////////////////////
        $partneriddeal = $this->input->post('txtPartner');
        $innovationpartnerid = str_pad($partneriddeal, 2, "0", STR_PAD_LEFT);
        $partnerdeal1 = $this->session->userdata('partner_id');
        $innovationpartnerid1 = str_pad($partnerdeal1, 2, "0", STR_PAD_LEFT);

        if($this->input->post('txtSector') == '177') {
            $program = '11';
        } else {
            $program = '0';
        }

        $innovation_data = array(
            'name_of_entrepreneur' => $this->db->escape_str($this->input->post('txtEntrepreneur')),
            'name_of_enterprise' => $this->db->escape_str($this->input->post('txtEnterprise')),
            'email_id' => $this->db->escape_str($this->input->post('txtEmail')),
            'mobile_no' => $this->db->escape_str($this->input->post('txtMobile')),
            'address_line1' => $this->db->escape_str($this->input->post('txtAddressOne')),
            'address_line2' => $this->db->escape_str($this->input->post('txtAddressTwo')),
            'country' => $count_name,
            'sector' => $this->input->post('txtSector'),
            'status' => '12',
            'stage' => '7',
            'program' => $program,
            'source' => '-1',
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('emp_number'),
            'partner_id' => ($this->session->userdata('user_type') == 'superadmin') ? $innovationpartnerid : $innovationpartnerid1
        );
        $table = "innovation_pool";
        $inc_inv_id = $this->Minnovation->pitch_insert($table, $innovation_data);
//////////////////////////// Innovation table insert ends /////////////////////////////////////
////////////////////// Innovation user insert/////////////////////
        $stat = "Completed";
        $inv_user_data = array(
            'inv_no' => 'INV' . $inc_inv_id,
            'ent_name' => $this->db->escape_str($this->input->post('txtEnterprise')),
            'applicant_name' => $this->db->escape_str($this->input->post('txtEntrepreneur')),
            'email' => $this->db->escape_str($this->input->post('txtEmail')),
            'mobile' => $this->db->escape_str($this->input->post('txtMobile')),
            'address1' => $this->db->escape_str($this->input->post('txtAddressOne')),
            'address2' => $this->db->escape_str($this->input->post('txtAddressTwo')),
            'country' => $this->db->escape_str($this->input->post('txtCountry')),
            'ent_type' => $this->db->escape_str($this->input->post('txtProfit')),
            'india_based' => $this->db->escape_str($this->input->post('txtIndia')),
            'ent_sector' => $this->input->post('txtSector'),
            'sub_sector' => $this->input->post('txtSubSector'),
            'benificiary' => serialize($this->input->post('txtBeneficiary')),
            'impact_of_product' => $this->db->escape_str($this->input->post('txtImpact')),
            'status' => $stat,
            'created_date' => date('Y-m-d'),
            'submitted_date' => date('Y-m-d')
        );

        $table = "inv_user";
        $inv_user_id = $this->Minnovation->pitch_insert($table, $inv_user_data);

        $partner_id = $this->session->userdata('partner_id');
        $employee_number = $this->Sector_model->getEmployeeNumberByID($this->input->post('txtSector'), $partner_id);
        $emp_num = array_map(function ($emp_num) {
            return $emp_num['associate_employee'];
        }, $employee_number);

        array_push($emp_num, $this->session->userdata['emp_number']);
        $assign_list = array_unique($emp_num);

        $empmail = array();
        $employee_name = array();
        for ($i = 0; $i < count($assign_list); $i++) {
            $additional_info_data = array(
                'innovation' => $inc_inv_id,
                'associate_employee' => $assign_list[$i],
                'status' => 1,
                'created_date' => date('Y-m-d H:i:s'),
                'sector_id' => $this->input->post('inv_sector')
            );

            $empmail[$i] = $this->Sector_model->getEmployeeMailByID($assign_list[$i]);
            $employee_name[$i] = $this->Sector_model->getEmployeeNameByID($assign_list[$i]);

            $table = "assign_associate";
            $result = $this->Minnovation->pitch_insert($table, $additional_info_data);
        }

        $emp_mail = array_map(function ($emp_mail) {
            return $emp_mail['emp_work_email'];
        }, $empmail);

        $emp_names = array_map(function ($emp_names) {
            return $emp_names['emp_name'];
        }, $employee_name);

        $employees = rtrim(implode(',', $assign_list), ',');

        $log_data = array(
            'innovation_id' => $inc_inv_id,
            'stage' => 7,
            'status' => 12,
            'assigned_user' => $employees,
            'modified_by' => $this->session->userdata['emp_number'],
            'modified_date' => date('Y-m-d H:i:s')
        );

        $table_log = "application_status_log";
        $result = $this->Minnovation->pitch_insert($table_log, $log_data);

        $this->load->model('common/Minnovation_mail');
        $this->Minnovation_mail->mailSendIncharge('INV' . $inc_inv_id, $partner_id, $emp_mail, $emp_names);

        $this->session->set_flashdata('successMsg', 'Deals added successfully');
        redirect('application/basic_info/' . $inc_inv_id);
    }

    public function checkEmailExist() {
        $current_email = $_POST['txtEmail'];
        $partner = $this->session->userdata('partner_id');
        $innovation_partnerid = str_pad($partner, 2, "0", STR_PAD_LEFT);
        $email = $this->Mapplication->checkEmailExistValue($current_email, $innovation_partnerid);

        if (count($email) > 0) {
            $response = 'false';
        } else {
            $response = 'true';
        }
        echo $response;
    }

    public function save_comments() {

        $data['inv_id'] = $inv = $_POST['application_id'];
        $data['partner_id'] = $this->session->userdata('partner_id');
        $data['application_type'] = $_POST['application_type'];
        $data['application_status'] = $crr_status = $_POST['comment_status'];
        $data['comments'] = $_POST['comment'];
        $data['created_date'] = date('Y-m-d H:i:s');
        $data['created_by'] = $empid = $this->session->userdata['emp_number'];
        $data['status'] = 1;

        $result = $this->Minnovation->insert_shortlistcomments($data);
        if ($result) {
            $options['inv_id'] = $inv;
            $options['created_by'] = $empid;
            $this->Minnovation->update_shortlistcomments($crr_status, $options);
            $this->session->set_flashdata('successMsg', "Comment added successfully");
            redirect('application/basic_info/' . $inv);
        }
    }

    public function basic_info($id) { 
		#error_reporting(-1);
        $emp_id = $this->session->userdata('emp_number');
        $check_app = $this->Mapplication->getApplicationType($id);

        $data['country_list'] = $this->Minnovation->getCountry();
        $data['branch'] = $this->Mmaster->getBranch();
        $data['sector_details'] = $this->Sector_model->getIncSectors('incubation');
        $data['program_name'] = $this->Mapplication->getProgramName($check_app[0]['program']);

        if ($check_app[0]['program'] == 31|| $check_app[0]['program'] == 0 || $check_app[0]['program'] == 9 || $check_app[0]['program'] == 10 || $check_app[0]['program'] == 11 || $check_app[0]['program'] == 12 || $check_app[0]['program'] == 13 || $check_app[0]['program'] == 14|| $check_app[0]['program'] == 21|| $check_app[0]['program'] == 22 || $check_app[0]['program'] == 23 || $check_app[0]['program'] == 24  || $check_app[0]['program'] == 25 || $check_app[0]['program'] == 26  || $check_app[0]['program'] == 27  || $check_app[0]['program'] == 28 || $check_app[0]['program'] == 29 || $check_app[0]['program'] == 30)
            $data['basic_information'] = $this->Mapplication->getIncApplicationBasic($id);
			if($check_app[0]['program'] == 23 || $check_app[0]['program'] == 31||$check_app[0]['program'] == 30){
				$data['inv_ent_info'] = $this->Mapplication->getIncApplicationTeam($id);
			}
        else if ($check_app[0]['program'] == 3 || $check_app[0]['program'] == 5 || $check_app[0]['program'] == 6 || $check_app[0]['program'] == 7 || $check_app[0]['program'] == 8)
            $data['basic_information'] = $this->Mapplication->getPitchApplicationBasic($id);

        if ($this->session->userdata('role_id') == '4' && $this->session->userdata('independent_shortlist') == 1) {
            $get_shortlist = $this->Mportfolio->getShortlistStatus($emp_id, $id);
            $shortlist_status = isset($get_shortlist['application_status']) && $get_shortlist['application_status'] != '' ? $get_shortlist['application_status'] : '12';
        }

        $stage = $this->Minnovation->getInnvationStage();
        $status = $this->Minnovation->getInnvationStatus();
        $data['stage'] = $stage[$data['basic_information'][0]['stage']];
        $deals_status = isset($shortlist_status) && $shortlist_status != '' ? $shortlist_status : $data['basic_information'][0]['status'];
        $data['status'] = $status[$deals_status];
        $data['assign_incharge'] = $this->app_assign_incharge($data['basic_information'][0]['id']);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);

        $empName = $modified_employer = array();
        $data['log_details'] = $this->Mincharge->getStatusLog($id);

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

        $userSetup = $this->Mmaster->getUserSetup();
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['basic_information'][0]['partner_id']);
        $data['innovation'] = $innovation_details = $this->Minnovation->getInnovation($id);
        $data['innovationDetails'] = $this->Minnovation->getInnovationDetails($id);

        if ($innovation_details['id'] != '') {
            $this->load->model('incubation_master/Common_model');
            $inovID = 'INV' . $innovation_details['id'];
            $condition = array('inno_id' => $inovID);
            $getLangCode = $this->Common_model->get_all_details('pitch_user', $condition, array('lang_code'));
            $data['lang_code'] = $getLangCode[0]->lang_code;
        }
		#$echo'<pre>';print_r($data);die;
        $data['application_id'] = $id;
        $this->load->vars($data);

        if (($check_app[0]['program'] == 0 || $check_app[0]['program'] == 30 || $check_app[0]['program'] == 24  || $check_app[0]['program'] == 9 || $check_app[0]['program'] == 10 || $check_app[0]['program'] == 11 || $check_app[0]['program'] == 12 || $check_app[0]['program'] == 13) && $check_app[0]['partner_id'] == 1 || $check_app[0]['program'] == 14 || $check_app[0]['program'] == 21|| $check_app[0]['program'] == 22 || $check_app[0]['program'] == 23  || $check_app[0]['program'] == 31 || $check_app[0]['program'] == 27  || $check_app[0]['program'] == 25 || $check_app[0]['program'] == 26 || $check_app[0]['program'] == 28 ||  $check_app[0]['program'] == 29) {
            $this->load->view('application/incubatee/incubation_basic_info');
        } else if ($check_app[0]['program'] == 0 && $check_app[0]['partner_id'] == 2) {
            $this->load->view('application/incubatee/kenya_basic_info');
        } else if ($check_app[0]['program'] == 6 && $check_app[0]['partner_id'] == 1) {
            $this->load->view('application/incubatee/ubs_basic_info');
        } else {
            if ($this->uri->segment(4) == 'hi') {
                $this->load->view('application/incubatee/pitch_basic_info_hi');
            } else {
                $this->load->view('application/incubatee/pitch_basic_info');
            }
        }
    }

    public function update_basic_details($id) {
        $inv_id = $this->input->post('inv_id');
        $innovation_id = $inno_cond['innovation_id'] = 'INV' . $this->input->post('inv_id');
        $inv_user_id = $cond['id'] = $this->input->post('inv_user_id');
        $check_innovation = $this->Mapplication->checkApplicationDetails('innovation_pool', $innovation_id, 'innovation_id');
        $check_basic = $this->Mapplication->checkApplicationDetails('inv_user', $inv_user_id, 'id');

        if ($this->input->post('txtCountry') != '') {
            $country_name = $this->Minnovation->getCountryName($this->input->post('txtCountry'));
            $count_name = $country_name[0];
        }
        $partneriddeal = $this->input->post('txtPartner');
        $innovationpartnerid = str_pad($partneriddeal, 2, "0", STR_PAD_LEFT);
        $partnerdeal1 = $this->session->userdata('partner_id');
        $innovationpartnerid1 = str_pad($partnerdeal1, 2, "0", STR_PAD_LEFT);

        $innovation['name_of_entrepreneur'] = $this->db->escape_str($this->input->post('txtEntrepreneur'));
        $innovation['name_of_enterprise'] = $this->db->escape_str($this->input->post('txtEnterprise'));
        $innovation['mobile_no'] = $this->db->escape_str($this->input->post('txtMobile'));
        $innovation['address_line1'] = $this->db->escape_str($this->input->post('txtAddressOne'));
        $innovation['address_line2'] = $this->db->escape_str($this->input->post('txtAddressTwo'));
        $innovation['country'] = $count_name;
        $innovation['sector'] = $this->input->post('txtSector');
        $innovation['partner_id'] = ($this->session->userdata('user_type') == 'superadmin') ? $innovationpartnerid : $innovationpartnerid1;

        if($this->input->post('txtSector') == '177') {
            $innovation['program']='11';
        } else {
            $innovation['program']='0';
        }

        if (count($check_innovation) > 0) {
            $e_query = $this->Mapplication->updateApplicationDetail('innovation_pool', $innovation, $inno_cond);
        }

        $basic['ent_name'] = $this->db->escape_str($this->input->post('txtEnterprise'));
        $basic['applicant_name'] = $this->db->escape_str($this->input->post('txtEntrepreneur'));
        $basic['mobile'] = $this->db->escape_str($this->input->post('txtMobile'));
        $basic['address1'] = $this->db->escape_str($this->input->post('txtAddressOne'));
        $basic['address2'] = $this->db->escape_str($this->input->post('txtAddressTwo'));
        $basic['country'] = $this->db->escape_str($this->input->post('txtCountry'));
        $basic['ent_type'] = $this->db->escape_str($this->input->post('txtProfit'));
        $basic['india_based'] = $this->db->escape_str($this->input->post('txtIndia'));
        $basic['ent_sector'] = $this->input->post('txtSector');
        $basic['sub_sector'] = $this->input->post('txtSubSector');
        $basic['benificiary'] = serialize($this->input->post('txtBeneficiary'));
        $basic['impact_of_product'] = $this->db->escape_str($this->input->post('txtImpact'));

        if (count($check_basic) > 0) {
            $e_query = $this->Mapplication->updateApplicationDetail('inv_user', $basic, $cond);
        }
        if ($e_query) {
            $this->session->set_flashdata('successMsg', "Basic details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('application/basic_info/' . $inv_id);
    }

    public function update_kenya_details() {
        $inv_id = $this->input->post('inv_id');
        $innovation_id = $inno_cond['innovation_id'] = 'INV' . $this->input->post('inv_id');
        $inv_user_id = $cond['id'] = $this->input->post('inv_user_id');
        $check_innovation = $this->Mapplication->checkApplicationDetails('innovation_pool', $innovation_id, 'innovation_id');
        $check_basic = $this->Mapplication->checkApplicationDetails('inv_user', $inv_user_id, 'id');

        $innovation['name_of_entrepreneur'] = $this->db->escape_str($this->input->post('txtEntrepreneur'));
        $innovation['name_of_enterprise'] = $this->db->escape_str($this->input->post('txtEnterprise'));
        $innovation['mobile_no'] = $this->db->escape_str($this->input->post('txtMobile'));

        if (count($check_innovation) > 0) {
            $e_query = $this->Mapplication->updateApplicationDetail('innovation_pool', $innovation, $inno_cond);
        }

        $basic['ent_name'] = $this->db->escape_str($this->input->post('txtEnterprise'));
        $basic['applicant_name'] = $this->db->escape_str($this->input->post('txtEntrepreneur'));
        $basic['mobile'] = $this->db->escape_str($this->input->post('txtMobile'));
        $basic['ent_type'] = $this->db->escape_str($this->input->post('txtProfit'));
        $basic['benificiary'] = serialize($this->input->post('txtBeneficiary'));
        $basic['impact_of_product'] = $this->db->escape_str($this->input->post('txtImpact'));
        $basic['website'] = $this->db->escape_str($this->input->post('txtWebsite'));

        if (count($check_basic) > 0) {
            $e_query = $this->Mapplication->updateApplicationDetail('inv_user', $basic, $cond);
        }
        if ($e_query) {
            $this->session->set_flashdata('successMsg', "Basic details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('application/basic_info/' . $inv_id);
    }

    public function team_info($id) {

        $emp_id = $this->session->userdata('emp_number');
        $check_app = $this->Mapplication->getApplicationType($id);
        if ($check_app[0]['program'] == 30 ||  $check_app[0]['program'] == 0 || $check_app[0]['program'] == 9 || $check_app[0]['program'] == 10 || $check_app[0]['program'] == 11 || $check_app[0]['program'] == 12 || $check_app[0]['program'] == 13 || $check_app[0]['program'] == 14|| $check_app[0]['program'] == 21 || $check_app[0]['program'] == 22 || $check_app[0]['program'] == 23 ||  $check_app[0]['program'] == 31 || $check_app[0]['program'] == 24 || $check_app[0]['program'] == 25 || $check_app[0]['program'] == 27 || $check_app[0]['program'] == 26 || $check_app[0]['program'] == 28 || $check_app[0]['program'] == 29)
            $data['team_information'] = $this->Mapplication->getIncApplicationTeam($id);
        else if ($check_app[0]['program'] == 3 || $check_app[0]['program'] == 5 || $check_app[0]['program'] == 6 || $check_app[0]['program'] == 7 || $check_app[0]['program'] == 8)
            $data['team_information'] = $this->Mapplication->getPitchApplicationTeam($id);

        if ($this->session->userdata('role_id') == '4' && $this->session->userdata('independent_shortlist') == 1) {
            $get_shortlist = $this->Mportfolio->getShortlistStatus($emp_id, $id);
            $shortlist_status = isset($get_shortlist['application_status']) && $get_shortlist['application_status'] != '' ? $get_shortlist['application_status'] : '12';
        }

        $stage = $this->Minnovation->getInnvationStage();
        $status = $this->Minnovation->getInnvationStatus();
        $data['stage'] = $stage[$data['team_information'][0]['stage']];
        $deals_status = isset($shortlist_status) && $shortlist_status != '' ? $shortlist_status : $data['team_information'][0]['status'];
        $data['status'] = $status[$deals_status];
        $data['assign_incharge'] = $this->app_assign_incharge($data['team_information'][0]['id']);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);

        $empName = $modified_employer = array();
        $data['log_details'] = $this->Mincharge->getStatusLog($id);

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

        $userSetup = $this->Mmaster->getUserSetup();
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['basic_information'][0]['partner_id']);
        $data['innovation'] = $innovation_details = $this->Minnovation->getInnovation($id);
        $data['innovationDetails'] = $this->Minnovation->getInnovationDetails($id);

        $data['application_id'] = $id;

        if ($innovation_details['program'] == '3') {
            $this->load->model('incubation_master/Common_model');
            $inovID = 'INV' . $innovation_details['id'];
            $condition = array('inno_id' => $inovID);
            $getLangCode = $this->Common_model->get_all_details('pitch_user', $condition, array('lang_code'));
            $data['lang_code'] = $getLangCode[0]->lang_code;
        }

        if ($this->uri->segment(4) == 'hi') {
            $data['lang_code'] = 'hi';
        }
        $this->load->vars($data);
        if ($check_app[0]['program'] == 0 || $check_app[0]['program'] == 30 || $check_app[0]['program'] == 24 || $check_app[0]['program'] == 25 || $check_app[0]['program'] == 9  || $check_app[0]['program'] == 10 || $check_app[0]['program'] == 11 || $check_app[0]['program'] == 12 || $check_app[0]['program'] == 13 || $check_app[0]['program'] == 14|| $check_app[0]['program'] == 21 || $check_app[0]['program'] == 22 || $check_app[0]['program'] == 23  || $check_app[0]['program'] == 31|| $check_app[0]['program'] == 27|| $check_app[0]['program'] == 26 || $check_app[0]['program'] == 29 || $check_app[0]['program'] == 28) {
            $this->load->view('application/incubatee/incubation_team_info');
        } else if ($check_app[0]['program'] == 6) {
            $this->load->view('application/incubatee/ubs_team_info');
        } else {
            if ($this->uri->segment(4) == 'hi') {
                $this->load->view('application/incubatee/pitch_team_info_hi');
            } else {
                $this->load->view('application/incubatee/pitch_team_info');
            }
        }
    }

    public function add_team_details() {
        $inv_id = $this->input->post('inv_id');
        for ($i = 0; $i < 3; $i++) {
            if (trim($_POST['team_name'][$i]) != '') {
                $cond['id'] = $_POST['team_id'][$i];
                $cond['inv_user_id'] = $team['inv_user_id'] = $_POST['inv_user_id'];

                $team['mem_name'] = trim($_POST['team_name'][$i]);
                $team['mem_occupation'] = $_POST['team_desg'][$i];
                $team['mem_org'] = $_POST['team_org'][$i];
                $team['mem_email'] = $_POST['team_email'][$i];
                $team['mem_mobile'] = $_POST['team_mob'][$i];
                $team['mem_gender'] = $_POST['gender'][$i];

                $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/IncubationForm/uploads';

                if ($_FILES["mem_doc"]["name"][$i] != "") {
                    $split_name = explode('.', $_FILES["mem_doc"]["name"][$i]);
                    $get_extension = array_pop($split_name);
                    $get_name = implode('', $split_name);
                    $this->load->library('upload');
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx';
                    $rename_file = str_replace(' ', '_', strtolower($get_name));
                    $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
                    $config['file_name'] = date('Ymdhis') . '_' . $new_name . '.' . $get_extension;

                    $this->upload->initialize($config);

                    $_FILES['upload_single']['name'] = $_FILES['mem_doc']['name'][$i];
                    $_FILES['upload_single']['tmp_name'] = $_FILES['mem_doc']['tmp_name'][$i];
                    $_FILES['upload_single']['size'] = $_FILES['mem_doc']['size'][$i];
                    $_FILES['upload_single']['type'] = $_FILES['mem_doc']['type'][$i];
                    $_FILES['upload_single']['error'] = $_FILES['mem_doc']['error'][$i];

                    if (!$this->upload->do_upload('upload_single')) {
                        $upload_error = $this->upload->display_errors();
                        echo $upload_error . "--" . $i;
                    } else {
                        $upload_data = $this->upload->data();
                        $team['mem_resume'] = $upload_data['file_name'];
                    }
                    unset($config);
                } else if (isset($_POST['old_mem_doc'][$i]) && $_POST['old_mem_doc'][$i] != '') {
                    $team['mem_resume'] = $_POST['old_mem_doc'][$i];
                } else {
                    $team['mem_resume'] = '';
                }

                $checkTeamData = $this->Mapplication->getTeamInfo($cond);
                if (count($checkTeamData) > 0) {
                    $e_query = $this->Mapplication->updateApplicationDetail('inv_member', $team, $cond);
                } else {
                    $e_query = $this->Mapplication->insertApplicationDetail('inv_member', $team);
                }
            }
        }

        if ($e_query) {
            $this->session->set_flashdata('successMsg', "Team details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('application/team_info/' . $inv_id);
    }

    public function enterprise_info($id) {
		
		#echo $_SERVER['REMOTE_ADDR'];die;
		
        $emp_id = $this->session->userdata('emp_number');
        $check_app = $this->Mapplication->getApplicationType($id);
        if ($check_app[0]['program'] == 30 ||$check_app[0]['program'] == 0 || $check_app[0]['program'] == 10 || $check_app[0]['program'] == 11 || $check_app[0]['program'] == 12 || $check_app[0]['program'] == 13 || $check_app[0]['program'] == 14|| $check_app[0]['program'] == 21 || $check_app[0]['program'] == 22 || $check_app[0]['program'] == 23  || $check_app[0]['program'] == 31  || $check_app[0]['program'] == 24 || $check_app[0]['program'] == 27 || $check_app[0]['program'] == 26 || $check_app[0]['program'] == 25 || $check_app[0]['program'] == 29 || $check_app[0]['program'] == 28 )
            $data['enterprise_information'] = $this->Mapplication->getIncApplicationEnterprise($id);
        else if ($check_app[0]['program'] == 9)
            $data['enterprise_information'] = $this->Mapplication->getAFDapplicationEnterprise($id);
        else if ($check_app[0]['program'] == 3 || $check_app[0]['program'] == 5 || $check_app[0]['program'] == 6 || $check_app[0]['program'] == 7)
            $data['enterprise_information'] = $this->Mapplication->getPitchApplicationEnterprise($id);

        if ($this->session->userdata('role_id') == '4' && $this->session->userdata('independent_shortlist') == 1) {
            $get_shortlist = $this->Mportfolio->getShortlistStatus($emp_id, $id);
            $shortlist_status = isset($get_shortlist['application_status']) && $get_shortlist['application_status'] != '' ? $get_shortlist['application_status'] : '12';
        }
		
        $stage = $this->Minnovation->getInnvationStage();
        $status = $this->Minnovation->getInnvationStatus();
        $data['stage'] = $stage[$data['enterprise_information'][0]['stage']];
        $deals_status = isset($shortlist_status) && $shortlist_status != '' ? $shortlist_status : $data['enterprise_information'][0]['status'];
        $data['status'] = $status[$deals_status];
        $data['assign_incharge'] = $this->app_assign_incharge($data['enterprise_information'][0]['id']);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
		
		
        $empName = $modified_employer = array();
        $data['log_details'] = $this->Mincharge->getStatusLog($id);

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

		
        $userSetup = $this->Mmaster->getUserSetup();
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['basic_information'][0]['partner_id']);
        $data['innovation'] = $innovation_details = $this->Minnovation->getInnovation($id);
        $data['innovationDetails'] = $this->Minnovation->getInnovationDetails($id);
		
		
		
        $data['application_id'] = $id;
        if ($innovation_details['program'] == '3') {
            $this->load->model('incubation_master/Common_model');
            $inovID = 'INV' . $innovation_details['id'];
            $condition = array('inno_id' => $inovID);
            $getLangCode = $this->Common_model->get_all_details('pitch_user', $condition, array('lang_code'));
            $data['lang_code'] = $getLangCode[0]->lang_code;
        }
		

        if ($this->uri->segment(4) == 'hi') {
            $data['lang_code'] = 'hi';
        }
        $this->load->vars($data);
		
		if($check_app[0]['program'] == 14|| $check_app[0]['program'] == 21 || $check_app[0]['program'] == 22 || $check_app[0]['program'] == 23  || $check_app[0]['program'] == 31  || $check_app[0]['program'] == 27 || $check_app[0]['program'] == 26 || $check_app[0]['program'] == 25){
			 $this->load->view('application/incubatee/cisco_enterprise_info'); return false;
		}
        if ($check_app[0]['program'] == 0 || $check_app[0]['program'] == 30 ||  $check_app[0]['program'] == 24 || $check_app[0]['program'] == 11 || $check_app[0]['program'] == 28  || $check_app[0]['program'] == 12 || $check_app[0]['program'] == 13 || $check_app[0]['program'] == 29 ) {
			
			/* if($this->session->userdata('emp_number') =='275'){
				$this->load->view('application/incubatee/incubation_enterprise_info_test');
			}else{
				
			} */
			$this->load->view('application/incubatee/incubation_enterprise_info');
            
        } else if ($check_app[0]['program'] == 9) {
            $this->load->view('application/incubatee/afd_entity');
        } else if ($check_app[0]['program'] == 10) {
            $this->load->view('application/incubatee/tanseed_entity');
        } else if ($check_app[0]['program'] == 6) {
            $this->load->view('application/incubatee/ubs_enterprise_info');
        } else {
            if ($this->uri->segment(4) == 'hi') {
                $this->load->view('application/incubatee/pitch_enterprise_info_hi');
            } else {
                $this->load->view('application/incubatee/pitch_enterprise_info');
            }
        }
    }

    public function load_state_list() {
        $data = array();
        $branch = $this->session->userdata('partner_id');
        $inv_user_id = $this->input->post('inv_user_id');
        $getAllState = $this->Minnovation->getPartnerState($branch);
        $getSelectedSates = $this->Mapplication->getStateByApplication($inv_user_id);
        $split_value = explode(',', $getSelectedSates[0]['operate_on_state']);
        foreach ($split_value as $row) {
            array_push($data, $row);
        }
        $user_data['user_state'] = $data;

        $defaultval = array();
        if (!empty($user_data)) {
            $defaultval = $user_data;
        }

        echo json_encode(array('all_states' => $getAllState, 'ext_state' => $defaultval));
    }


	public function load_state_list_geo() {
        $data = array();
        $branch = $this->session->userdata('partner_id');
        $inv_user_id = $this->input->post('inv_user_id');
        $getAllState = $this->Minnovation->getPartnerState($branch);
        $getSelectedSates = $this->Mapplication->getStateByApplicationGeo($inv_user_id);
        $split_value = explode(',', $getSelectedSates[0]['startup_challenge']);
		#echo'<pre>';print_r($getSelectedSates);die;
        foreach ($split_value as $row) {
            array_push($data, $row);
        }
        $user_data['user_state'] = $data;

        $defaultval = array();
        if (!empty($user_data)) {
            $defaultval = $user_data;
        }

        echo json_encode(array('all_states' => $getAllState, 'ext_state' => $defaultval));
    }
	
	
	public function load_state_list_cisco() {
        $data = array();
        $branch = $this->session->userdata('partner_id');
        $inv_user_id = $this->input->post('inv_user_id');
        $getAllState = $this->Minnovation->getState($branch);
        $getSelectedSates = $this->Mapplication->getStateByApplication($inv_user_id);
        $split_value = explode(',', $getSelectedSates[0]['operate_on_state']);
        foreach ($split_value as $row) {
            array_push($data, $row);
        }
        $user_data['user_state'] = $data;

        $defaultval = array();
        if (!empty($user_data)) {
            $defaultval = $user_data;
        }

        echo json_encode(array('all_states' => $getAllState, 'ext_state' => $defaultval));
    }

    public function add_enterprise_details() {
        $inv_id = $this->input->post('inv_id');
        $inv_user_id = $cond['inv_user_id'] = $enterprise['inv_user_id'] = $additional['inv_user_id'] = $this->input->post('inv_user_id');
        $check_enterprise = $this->Mapplication->checkApplicationDetails('inv_ent_info', $inv_user_id);
        $check_additional = $this->Mapplication->checkApplicationDetails('inv_additional_info', $inv_user_id);

        $enterprise['in_operation'] = $this->input->post('in_operation');
        $enterprise['operate_on_state'] = implode(',', $this->input->post('select_state'));

        $additional['ant_org'] = $this->input->post('with_other_org');
        $additional['ant_org_name'] = $this->db->escape_str($this->input->post('other_org_name'));
        $additional['won_competition'] = $this->input->post('competition');
        $additional['competition_name'] = $this->db->escape_str($this->input->post('business_compet'));


        if (count($check_enterprise) > 0) {
            $e_query = $this->Mapplication->updateApplicationDetail('inv_ent_info', $enterprise, $cond);
        } else {
            $e_query = $this->Mapplication->insertApplicationDetail('inv_ent_info', $enterprise);
        }

        if (count($check_additional) > 0) {
            $a_query = $this->Mapplication->updateApplicationDetail('inv_additional_info', $additional, $cond);
        } else {
            $a_query = $this->Mapplication->insertApplicationDetail('inv_additional_info', $additional);
        }

        if ($e_query || $a_query) {
            $this->session->set_flashdata('successMsg', "Enterprise details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('application/enterprise_info/' . $inv_id);
    }
	
	 public function about_business($id) {
        $emp_id = $this->session->userdata('emp_number');
        $check_app = $this->Mapplication->getApplicationType($id);
        if ($check_app[0]['program'] == 14 || $check_app[0]['program'] == 21 ||  $check_app[0]['program'] == 22)
            $data['innovation_information'] = $this->Mapplication->getIncApplicationInnovation($id);
        else if ($check_app[0]['program'] == 9 || $check_app[0]['program'] == 10)

        if ($this->session->userdata('role_id') == '4' && $this->session->userdata('independent_shortlist') == 1) {
            $get_shortlist = $this->Mportfolio->getShortlistStatus($emp_id, $id);
            $shortlist_status = isset($get_shortlist['application_status']) && $get_shortlist['application_status'] != '' ? $get_shortlist['application_status'] : '12';
        }

        $stage = $this->Minnovation->getInnvationStage();
        $status = $this->Minnovation->getInnvationStatus();
        $data['stage'] = $stage[$data['innovation_information'][0]['stage']];
        $deals_status = isset($shortlist_status) && $shortlist_status != '' ? $shortlist_status : $data['innovation_information'][0]['status'];
        $data['status'] = $status[$deals_status];
        $data['assign_incharge'] = $this->app_assign_incharge($data['innovation_information'][0]['id']);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);

        $empName = $modified_employer = array();
        $data['log_details'] = $this->Mincharge->getStatusLog($id);

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

        $userSetup = $this->Mmaster->getUserSetup();
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['basic_information'][0]['partner_id']);
        $data['innovation'] = $innovation_details = $this->Minnovation->getInnovation($id);
        $data['innovationDetails'] = $this->Minnovation->getInnovationDetails($id);

        $data['application_id'] = $id;
        if ($innovation_details['program'] == '3') {
            $this->load->model('incubation_master/Common_model');
            $inovID = 'INV' . $innovation_details['id'];
            $condition = array('inno_id' => $inovID);
            $getLangCode = $this->Common_model->get_all_details('pitch_user', $condition, array('lang_code'));
            $data['lang_code'] = $getLangCode[0]->lang_code;
        }

        if ($this->uri->segment(4) == 'hi') {
            $data['lang_code'] = 'hi';
        }
        $this->load->vars($data);

        if ( $check_app[0]['program'] == 14 || $check_app[0]['program'] == 21 ||  $check_app[0]['program'] == 22) {
            $this->load->view('application/incubatee/cico_innovation_info');
        } 
    }

    public function innovation_info($id) {
        $emp_id = $this->session->userdata('emp_number');
        $check_app = $this->Mapplication->getApplicationType($id);
        if ($check_app[0]['program'] == 0 || $check_app[0]['program'] == 30 || $check_app[0]['program'] == 11 || $check_app[0]['program'] == 12 || $check_app[0]['program'] == 13 || $check_app[0]['program'] == 14|| $check_app[0]['program'] == 21 || $check_app[0]['program'] == 22 || $check_app[0]['program'] == 23 || $check_app[0]['program'] == 24 || $check_app[0]['program'] == 27 || $check_app[0]['program'] == 26 || $check_app[0]['program'] == 25 || $check_app[0]['program'] == 29)
            $data['innovation_information'] = $this->Mapplication->getIncApplicationInnovation($id);
        else if ($check_app[0]['program'] == 9 || $check_app[0]['program'] == 10)
            $data['innovation_information'] = $this->Mapplication->getAFDapplicationInnovation($id);
        else if ($check_app[0]['program'] == 3 || $check_app[0]['program'] == 5 || $check_app[0]['program'] == 6 || $check_app[0]['program'] == 7)
            $data['innovation_information'] = $this->Mapplication->getPitchApplicationInnovation($id);

        if ($this->session->userdata('role_id') == '4' && $this->session->userdata('independent_shortlist') == 1) {
            $get_shortlist = $this->Mportfolio->getShortlistStatus($emp_id, $id);
            $shortlist_status = isset($get_shortlist['application_status']) && $get_shortlist['application_status'] != '' ? $get_shortlist['application_status'] : '12';
        }

        $stage = $this->Minnovation->getInnvationStage();
        $status = $this->Minnovation->getInnvationStatus();
        $data['stage'] = $stage[$data['innovation_information'][0]['stage']];
        $deals_status = isset($shortlist_status) && $shortlist_status != '' ? $shortlist_status : $data['innovation_information'][0]['status'];
        $data['status'] = $status[$deals_status];
        $data['assign_incharge'] = $this->app_assign_incharge($data['innovation_information'][0]['id']);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);

        $empName = $modified_employer = array();
        $data['log_details'] = $this->Mincharge->getStatusLog($id);

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

        $userSetup = $this->Mmaster->getUserSetup();
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['basic_information'][0]['partner_id']);
        $data['innovation'] = $innovation_details = $this->Minnovation->getInnovation($id);
        $data['innovationDetails'] = $this->Minnovation->getInnovationDetails($id);

        $data['application_id'] = $id;
        if ($innovation_details['program'] == '3') {
            $this->load->model('incubation_master/Common_model');
            $inovID = 'INV' . $innovation_details['id'];
            $condition = array('inno_id' => $inovID);
            $getLangCode = $this->Common_model->get_all_details('pitch_user', $condition, array('lang_code'));
            $data['lang_code'] = $getLangCode[0]->lang_code;
        }

        if ($this->uri->segment(4) == 'hi') {
            $data['lang_code'] = 'hi';
        }
        $this->load->vars($data);


        if ($check_app[0]['program'] == 0 || $check_app[0]['program'] == 30 || $check_app[0]['program'] == 24 || $check_app[0]['program'] == 11 || $check_app[0]['program'] == 12 || $check_app[0]['program'] == 13 || $check_app[0]['program'] == 14|| $check_app[0]['program'] == 21 || $check_app[0]['program'] == 22 || $check_app[0]['program'] == 23 || $check_app[0]['program'] == 27 || $check_app[0]['program'] == 26 || $check_app[0]['program'] == 25 || $check_app[0]['program'] == 29) {
            $this->load->view('application/incubatee/incubation_innovation_info');
        } else if ($check_app[0]['program'] == 9) {
            $this->load->view('application/incubatee/afd_organisation');
        } else if ($check_app[0]['program'] == 10) {
            $this->load->view('application/incubatee/tanseed_organisation');
        } else if ($check_app[0]['program'] == 6) {
            $this->load->view('application/incubatee/ubs_innovation_info');
        } else {
            if ($this->uri->segment(4) == 'hi') {
                $this->load->view('application/incubatee/pitch_innovation_info_hi');
            } else {
                $this->load->view('application/incubatee/pitch_innovation_info');
            }
        }
    }
	
	
	public function support_info($id) {
        $emp_id = $this->session->userdata('emp_number');
        $check_app = $this->Mapplication->getApplicationType($id);
        $data['innovation_information'] = $this->Mapplication->getIncApplicationInnovation($id);
		 
        if ($this->session->userdata('role_id') == '4' && $this->session->userdata('independent_shortlist') == 1) {
            $get_shortlist = $this->Mportfolio->getShortlistStatus($emp_id, $id);
            $shortlist_status = isset($get_shortlist['application_status']) && $get_shortlist['application_status'] != '' ? $get_shortlist['application_status'] : '12';
        }

        $stage = $this->Minnovation->getInnvationStage();
        $status = $this->Minnovation->getInnvationStatus();
        $data['stage'] = $stage[$data['innovation_information'][0]['stage']];
        $deals_status = isset($shortlist_status) && $shortlist_status != '' ? $shortlist_status : $data['innovation_information'][0]['status'];
        $data['status'] = $status[$deals_status];
        $data['assign_incharge'] = $this->app_assign_incharge($data['innovation_information'][0]['id']);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);

        $empName = $modified_employer = array();
        $data['log_details'] = $this->Mincharge->getStatusLog($id);

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

        $userSetup = $this->Mmaster->getUserSetup();
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['basic_information'][0]['partner_id']);
        $data['innovation'] = $innovation_details = $this->Minnovation->getInnovation($id);
        $data['innovationDetails'] = $this->Minnovation->getInnovationDetails($id);

        $data['application_id'] = $id;
        if ($innovation_details['program'] == '3') {
            $this->load->model('incubation_master/Common_model');
            $inovID = 'INV' . $innovation_details['id'];
            $condition = array('inno_id' => $inovID);
            $getLangCode = $this->Common_model->get_all_details('pitch_user', $condition, array('lang_code'));
            $data['lang_code'] = $getLangCode[0]->lang_code;
        }

        $this->load->vars($data);
        $this->load->view('application/incubatee/incubation_support');
    }

    public function add_innovation_details() {
        $inv_id = $this->input->post('inv_id');
        $inv_user_id = $cond['inv_user_id'] = $enterprise['inv_user_id'] = $impact['inv_user_id'] = $this->input->post('inv_user_id');
        $check_enterprise = $this->Mapplication->checkApplicationDetails('inv_ent_info', $inv_user_id);
        $check_impact = $this->Mapplication->checkApplicationDetails('inv_impact', $inv_user_id);

        $enterprise['develop_product'] = $this->db->escape_str($this->input->post('type_prod'));
        $enterprise['stage_product'] = $this->db->escape_str($this->input->post('stage_prod'));
        $enterprise['inv_desc'] = $this->db->escape_str($this->input->post('inno_desc'));
        $enterprise['inv_problem'] = $this->db->escape_str($this->input->post('inno_prob'));
        $enterprise['inv_alternatives'] = $this->db->escape_str($this->input->post('avail_alter'));
        $enterprise['proposal_desc'] = $this->db->escape_str($this->input->post('prop_model'));
        $enterprise['inv_risks'] = $this->db->escape_str($this->input->post('ident_risk'));

        $impact['primary_benifi'] = $this->db->escape_str($this->input->post('prim_benefi'));
        $impact['research_cus_seg'] = $this->db->escape_str($this->input->post('cust_seg'));
        $impact['demographic_profie'] = $this->db->escape_str($this->input->post('benefi_grp'));
        $impact['avg_monthly'] = $this->db->escape_str($this->input->post('avg_earn'));
        $impact['inv_impact'] = $this->db->escape_str($this->input->post('no_impact'));
        $impact['others_benefit'] = $this->db->escape_str($this->input->post('service_benefit'));

        if (count($check_enterprise) > 0) {
            $e_query = $this->Mapplication->updateApplicationDetail('inv_ent_info', $enterprise, $cond);
        } else {
            $e_query = $this->Mapplication->insertApplicationDetail('inv_ent_info', $enterprise);
        }

        if (count($check_impact) > 0) {
            $a_query = $this->Mapplication->updateApplicationDetail('inv_impact', $impact, $cond);
        } else {
            $a_query = $this->Mapplication->insertApplicationDetail('inv_impact', $impact);
        }

        if ($e_query || $a_query) {
            $this->session->set_flashdata('successMsg', "Impact details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('application/innovation_info/' . $inv_id);
    }
	
		public function gmt_info($id) {
        $emp_id = $this->session->userdata('emp_number');
        $check_app = $this->Mapplication->getApplicationType($id);
        if ($check_app[0]['program'] == 0 || $check_app[0]['program'] == 24 ||$check_app[0]['program'] == 9 || $check_app[0]['program'] == 10 || $check_app[0]['program'] == 11 || $check_app[0]['program'] == 12 || $check_app[0]['program'] == 13 || $check_app[0]['program'] == 14 || $check_app[0]['program'] == 21 || $check_app[0]['program'] == 22|| $check_app[0]['program'] == 23 || $check_app[0]['program'] == 25)
            $data['additional_information'] = $this->Mapplication->getIncApplicationAdditional_gmt($id);
        else if ($check_app[0]['program'] == 3 || $check_app[0]['program'] == 5 || $check_app[0]['program'] == 6 || $check_app[0]['program'] == 7)
            $data['additional_information'] = $this->Mapplication->getPitchApplicationAdditional($id);

        if ($this->session->userdata('role_id') == '4' && $this->session->userdata('independent_shortlist') == 1) {
            $get_shortlist = $this->Mportfolio->getShortlistStatus($emp_id, $id);
            $shortlist_status = isset($get_shortlist['application_status']) && $get_shortlist['application_status'] != '' ? $get_shortlist['application_status'] : '12';
        }

        $stage = $this->Minnovation->getInnvationStage();
        $status = $this->Minnovation->getInnvationStatus();
        $data['stage'] = $stage[$data['additional_information'][0]['stage']];
        $deals_status = isset($shortlist_status) && $shortlist_status != '' ? $shortlist_status : $data['additional_information'][0]['status'];
        $data['status'] = $status[$deals_status];
        $data['assign_incharge'] = $this->app_assign_incharge($data['additional_information'][0]['id']);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);

        $empName = $modified_employer = array();
        $data['log_details'] = $this->Mincharge->getStatusLog($id);

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

        $userSetup = $this->Mmaster->getUserSetup();
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['basic_information'][0]['partner_id']);
        $data['innovation'] = $innovation_details = $this->Minnovation->getInnovation($id);
        $data['innovationDetails'] = $this->Minnovation->getInnovationDetails($id);

        $data['application_id'] = $id;
        if ($innovation_details['program'] == '3') {
            $this->load->model('incubation_master/Common_model');
            $inovID = 'INV' . $innovation_details['id'];
            $condition = array('inno_id' => $inovID);
            $getLangCode = $this->Common_model->get_all_details('pitch_user', $condition, array('lang_code'));
            $data['lang_code'] = $getLangCode[0]->lang_code;
        }

        if ($this->uri->segment(4) == 'hi') {
            $data['lang_code'] = 'hi';
        }
        $this->load->vars($data);

        $this->load->view('application/incubatee/gmt_info');
    }
	
    public function additional_info($id) {//competition_name
        $emp_id = $this->session->userdata('emp_number');
        $check_app = $this->Mapplication->getApplicationType($id);
        if ($check_app[0]['program'] == 0 || $check_app[0]['program'] == 9 || $check_app[0]['program'] == 30 || $check_app[0]['program'] == 10 || $check_app[0]['program'] == 11 || $check_app[0]['program'] == 12 || $check_app[0]['program'] == 13 || $check_app[0]['program'] == 14  || $check_app[0]['program'] == 21 || $check_app[0]['program'] == 22 || $check_app[0]['program'] == 23  || $check_app[0]['program'] == 31 || $check_app[0]['program'] == 24 || $check_app[0]['program'] == 27 || $check_app[0]['program'] == 26 || $check_app[0]['program'] == 25 || $check_app[0]['program'] == 29 || $check_app[0]['program'] == 28 )
            $data['additional_information'] = $this->Mapplication->getIncApplicationAdditional($id);
        else if ($check_app[0]['program'] == 3 || $check_app[0]['program'] == 5 || $check_app[0]['program'] == 6 || $check_app[0]['program'] == 7)
            $data['additional_information'] = $this->Mapplication->getPitchApplicationAdditional($id);

        if ($this->session->userdata('role_id') == '4' && $this->session->userdata('independent_shortlist') == 1) {
            $get_shortlist = $this->Mportfolio->getShortlistStatus($emp_id, $id);
            $shortlist_status = isset($get_shortlist['application_status']) && $get_shortlist['application_status'] != '' ? $get_shortlist['application_status'] : '12';
        }

        $stage = $this->Minnovation->getInnvationStage();
        $status = $this->Minnovation->getInnvationStatus();
        $data['stage'] = $stage[$data['additional_information'][0]['stage']];
        $deals_status = isset($shortlist_status) && $shortlist_status != '' ? $shortlist_status : $data['additional_information'][0]['status'];
        $data['status'] = $status[$deals_status];
        $data['assign_incharge'] = $this->app_assign_incharge($data['additional_information'][0]['id']);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);

        $empName = $modified_employer = array();
        $data['log_details'] = $this->Mincharge->getStatusLog($id);

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

        $userSetup = $this->Mmaster->getUserSetup();
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['basic_information'][0]['partner_id']);
        $data['innovation'] = $innovation_details = $this->Minnovation->getInnovation($id);
        $data['innovationDetails'] = $this->Minnovation->getInnovationDetails($id);

        $data['application_id'] = $id;
        if ($innovation_details['program'] == '3') {
            $this->load->model('incubation_master/Common_model');
            $inovID = 'INV' . $innovation_details['id'];
            $condition = array('inno_id' => $inovID);
            $getLangCode = $this->Common_model->get_all_details('pitch_user', $condition, array('lang_code'));
            $data['lang_code'] = $getLangCode[0]->lang_code;
        }

        if ($this->uri->segment(4) == 'hi') {
            $data['lang_code'] = 'hi';
        }
        $this->load->vars($data);


        if (($check_app[0]['program'] == 0 ||  $check_app[0]['program'] == 30  || $check_app[0]['program'] == 24 ||  $check_app[0]['program'] == 11 || $check_app[0]['program'] == 12 || $check_app[0]['program'] == 13) && $check_app[0]['partner_id'] == 1 || $check_app[0]['program'] == 14  || $check_app[0]['program'] == 21 || $check_app[0]['program'] == 22 || $check_app[0]['program'] == 23 || $check_app[0]['program'] == 31 || $check_app[0]['program'] == 27 || $check_app[0]['program'] == 26 || $check_app[0]['program'] == 25 || $check_app[0]['program'] == 29 || $check_app[0]['program'] == 28 ) {
            $this->load->view('application/incubatee/incubation_additional_info');
        } else if (($check_app[0]['program'] == 9 || $check_app[0]['program'] == 10) && $check_app[0]['partner_id'] == 1) {
            $this->load->view('application/incubatee/afd_document');
        } else if ($check_app[0]['program'] == 0 && $check_app[0]['partner_id'] == 2) {
            $this->load->view('application/incubatee/kenya_additional_info');
        } else if ($check_app[0]['program'] == 6 && $check_app[0]['partner_id'] == 1) {
            $this->load->view('application/incubatee/ubs_additional_info');
        } else {
            if ($this->uri->segment(4) == 'hi') {
                $this->load->view('application/incubatee/pitch_additional_info_hi');
            } else {
                $this->load->view('application/incubatee/pitch_additional_info');
            }
        }
    }

    public function add_additional_details() {
        $inv_id = $this->input->post('inv_id');
        $inv_user_id = $cond['inv_user_id'] = $additional['inv_user_id'] = $this->input->post('inv_user_id');
        $check_additional = $this->Mapplication->checkApplicationDetails('inv_additional_info', $inv_user_id);

        $additional['from_villgro'] = implode(',', $this->input->post('vill_support'));
        if (in_array('Other', $this->input->post('vill_support'))) {
            $additional['support_name'] = $this->input->post('otr_support');
        } else {
            $additional['support_name'] = '';
        }
        $additional['hear_abt'] = implode(',', $this->input->post('abt_vill'));
        if (in_array('Other', $this->input->post('abt_vill'))) {
            $additional['referal_name'] = $this->input->post('ref_name');
        } else {
            $additional['referal_name'] = '';
        }

        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/IncubationForm/uploads';

        if ($_FILES["business_file"]["name"] != "") {
            $split_name = explode('.', $_FILES["business_file"]["name"]);
            $get_extension = array_pop($split_name);
            $get_name = implode('', $split_name);
            $this->load->library('upload');
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx';
            $rename_file = str_replace(' ', '_', strtolower($get_name));
            $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
            $config['file_name'] = date('Ymdhis') . '_' . $new_name . '.' . $get_extension;

            $this->upload->initialize($config);

            $_FILES['upload_single']['name'] = $_FILES['business_file']['name'];
            $_FILES['upload_single']['tmp_name'] = $_FILES['business_file']['tmp_name'];
            $_FILES['upload_single']['size'] = $_FILES['business_file']['size'];
            $_FILES['upload_single']['type'] = $_FILES['business_file']['type'];
            $_FILES['upload_single']['error'] = $_FILES['business_file']['error'];

            if (!$this->upload->do_upload('upload_single')) {
                $upload_error = $this->upload->display_errors();
                echo $upload_error . "--business document";
            } else {
                $upload_data = $this->upload->data();
                $additional['business_plan'] = $upload_data['file_name'];
            }
            unset($config);
        } else if (isset($_POST['old_business_file']) && $_POST['old_business_file'] != '') {
            $additional['business_plan'] = $_POST['old_business_file'];
        } else {
            $additional['business_plan'] = '';
        }

        if ($_FILES["info_file"]["name"] != "") {
            $split_name = explode('.', $_FILES["info_file"]["name"]);
            $get_extension = array_pop($split_name);
            $get_name = implode('', $split_name);
            $this->load->library('upload');
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx';
            $rename_file = str_replace(' ', '_', strtolower($get_name));
            $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
            $config['file_name'] = date('Ymdhis') . '_' . $new_name . '.' . $get_extension;

            $this->upload->initialize($config);

            $_FILES['upload_single']['name'] = $_FILES['info_file']['name'];
            $_FILES['upload_single']['tmp_name'] = $_FILES['info_file']['tmp_name'];
            $_FILES['upload_single']['size'] = $_FILES['info_file']['size'];
            $_FILES['upload_single']['type'] = $_FILES['info_file']['type'];
            $_FILES['upload_single']['error'] = $_FILES['info_file']['error'];

            if (!$this->upload->do_upload('upload_single')) {
                $upload_error = $this->upload->display_errors();
                echo $upload_error . "--additional document";
            } else {
                $upload_data = $this->upload->data();
                $additional['add_info'] = $upload_data['file_name'];
            }
            unset($config);
        } else if (isset($_POST['old_info_file']) && $_POST['old_info_file'] != '') {
            $additional['add_info'] = $_POST['old_info_file'];
        } else {
            $additional['add_info'] = '';
        }

        if (count($check_additional) > 0) {
            $a_query = $this->Mapplication->updateApplicationDetail('inv_additional_info', $additional, $cond);
        } else {
            $a_query = $this->Mapplication->insertApplicationDetail('inv_additional_info', $additional);
        }

        if ($a_query) {
            $this->session->set_flashdata('successMsg', "Additional details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('application/additional_info/' . $inv_id);
    }

    public function kenya_additional_details() {
        $inv_id = $inno['id'] = $this->input->post('inv_id');
        $inv_user_id = $cond['inv_user_id'] = $inv_cond['id'] = $additional['inv_user_id'] = $this->input->post('inv_user_id');
        $check_additional = $this->Mapplication->checkApplicationDetails('inv_additional_info', $inv_user_id);

        $inv_user['india_based'] = $this->input->post('inno_based');
        $additional['company_description'] = $this->input->post('company_desc');
        $additional['inv_idea_ent'] = $this->input->post('inv_idea_ent');
        $additional['hear_abt'] = implode(',', $this->input->post('abt_vill'));
        $innovation['sector'] = $inv_user['ent_sector'] = implode(',', $this->input->post('sector'));
        $innovation['sector_others'] = $this->input->post('sector_other');

        $inno_query = $this->Mapplication->updateApplicationDetail('innovation_pool', $innovation, $inno);
        $inv_query = $this->Mapplication->updateApplicationDetail('inv_user', $inv_user, $inv_cond);

        if (count($check_additional) > 0) {
            $a_query = $this->Mapplication->updateApplicationDetail('inv_additional_info', $additional, $cond);
        } else {
            $a_query = $this->Mapplication->insertApplicationDetail('inv_additional_info', $additional);
        }

        if ($a_query) {
            $this->session->set_flashdata('successMsg', "Additional details saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('application/additional_info/' . $inv_id);
    }

    public function saveAction($id) {
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $status = $this->input->post('status');
        $ids = $data['innovation']['id'];
        $employees = $this->Sector_model->getEmpId($ids);

        $emp_Ids = array_map(function ($emp_Ids) {
            return $emp_Ids['associate_employee'];
        }, $employees);
        $employees_id = rtrim(implode(',', $emp_Ids), ',');

        $log_data = array(
            'innovation_id' => $data['innovation']['id'],
            'stage' => $data['innovation']['stage'],
            'status' => $status,
            'assigned_user' => $employees_id,
            'modified_by' => $this->session->userdata['emp_number'],
            'modified_date' => date('Y-m-d H:i:s')
        );

        $table_log = "application_status_log";
        $result = $this->Minnovation->pitch_insert($table_log, $log_data);

        $this->Minnovation->updateComments($id, $_POST, $status);
        $this->Minnovation->changeStatus($id, $status);

        $this->session->set_flashdata('successMsg', 'Status Changed successfully!');
        if ($status == '3') {
            $this->session->set_userdata('close_action', 'yes');
        }
        redirect('application/basic_info/' . $id);
    }

    function assignInchargeInView() {
        $partner_id = $this->session->userdata['partner_id'];
        $employee = array();
        $employee = $_POST['associate_employee'];

        $ids = $_POST['innovations'];
        $innovationDetails = $this->Minnovation->getInnovation($ids);

        $acnt = count($employee);

        if ($acnt) {
            $this->Mincharge->removeOldIncharge($ids);
            for ($i = 0; $i < $acnt; $i++) {
                $this->Mincharge->assignmulincharge($ids, $employee, $partner_id);
                $this->Minnovation->approve_scoring($ids, '12');
            }
        }
        $employees = $this->Sector_model->getEmpId($ids);

        $emp_Ids = array_map(function ($emp_Ids) {
            return $emp_Ids['associate_employee'];
        }, $employees);
        $employees_id = rtrim(implode(',', $emp_Ids), ',');

        $log_data = array(
            'innovation_id' => $_POST['innovations'],
            'stage' => 8,
            'status' => $innovationDetails['status'],
            'assigned_user' => $employees_id,
            'modified_by' => $this->session->userdata['emp_number'],
            'modified_date' => date('Y-m-d H:i:s')
        );

        $table_log = "application_status_log";
        $result = $this->Minnovation->pitch_insert($table_log, $log_data);

        redirect('application/basic_info/' . $_POST['innovations'] . '');
    }

    public function assessment_scoring($id) {
        $count = $this->Massessment->check_innovation($id);
        if ($count == '0') {
            $this->view_assesst($id);
        } else {
            $data = array();
            $assessDetails = array();
            $data['innovation'] = $this->Minnovation->getInnovation($id);
            $data['assigned_incharge'] = $assigned_incharge = $this->Mincharge->getAssociateId($id);
            $data['assessmentCriteria'] = $this->Massessment->getCriteria();
            $this->load->model('master/Mgrade');
            $data['gradesMasterList'] = $this->Mgrade->getGradeListByStage('5');
            $data['criteria'] = $this->Mmaster->getMasterSettings('Grading Category');
            foreach ($data['criteria'] as $row) {
                $assessDetails[$row['id']] = $this->Massessment->getAssessDetails($id, $row['id']);
            }

            if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
                $data['exist'] = $this->Massessment->checkassessexist($id, $this->session->userdata('emp_number'));
                if ($data['exist'] == 0 || $data['exist'] == '') {
                    $no_assigned = count($assigned_incharge);
                    if ($no_assigned > 1) {
                        foreach ($assigned_incharge as $incharge) {
                            $assign_exist = $this->Massessment->checkassessexist($id, $incharge);
                            if ($assign_exist != 0) {
                                $assigned_incharge[0] = $incharge;
                                break;
                            }
                        }
                    }
                    foreach ($data['criteria'] as $row) {
                        $assessDetails[$row['id']] = $this->Massessment->getAssessDetails($id, $row['id'], $ass_id = null, $assigned_incharge[0]);
                    }
                }
            }

            $data['application_id'] = $id;
            $data['files'] = $this->Massessment->getfiles($id);
            $data['assessDetails'] = $assessDetails;
            $data['cpagetitle'] = "Assessment";
            if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || in_array($this->session->userdata('emp_number'), $assigned_incharge)) {
                $data['cpage'] = "assessment/assessment";
            } else {
                redirect('grading/view/' . $id);
            }

            $this->load->vars($data);
            $this->load->view('application/assessment/assessment_scoring');
        }
    }

    public function view_assesst($id, $option = null) {
        $data = array();
        $data['application_id'] = $id;
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $data['assigned_incharge'] = $assigned_incharge = $this->Mincharge->getActiveIncharge($id);
		
		$programId = $data['innovation']['program'];
        $data['area'] = $area = $this->Massessment->getArea($data['innovation']['partner_id'],$programId);

        $this->load->model('master/Mmaster');
        $userSetup = $this->Mmaster->getUserSetup_branch($this->session->userdata('partner_id'));
        $data['emplist'] = $this->Muser->getUsersList($userSetup['abi'], $this->session->userdata('partner_id'));
        $data['assessors'] = $assessor = $this->Massessment->getAssessors($id);
        $data['inno_status'] = $this->Massessment->getInnoStatus($id);
        $data['reasons'] = $this->Massessment->getReasons('', $data['innovation']['partner_id']);
        $status = unserialize($assessor[0]['status']);
        $employee = unserialize($assessor[0]['assessor_id']);
        $assessor_emp = array();
        $i = 0;
        foreach ($status as $stat) {
            if ($stat == 1) {
                if (!empty($employee)) {
                    $assessor_emp[] = $employee[$i];
                }
            }
            $i++;
        }

        $data['assesst_exist'] = $exist = $this->Massessment->assesstExist($id, $this->session->userdata('emp_number'));
        if ($exist) {
            /* -----Retrieving assesst records if exist----- */
            $data['assesst'] = $assesst = $this->Massessment->getAssesst($id, $this->session->userdata('emp_number'));
            $data['sub_assesst'] = $sub_assesst = $this->Massessment->getSubAssesst($data['assesst'][0]['id']);
        }
        $data['cpagetitle'] = "Assessment";

        /* -----Checking assign incharge for an innovation----- */
        if (in_array($this->session->userdata('emp_number'), $assigned_incharge) || in_array($this->session->userdata('emp_number'), $assessor_emp)) {
            $data['cpage'] = "application/assessment/assessment_scoring";
        } else {
            redirect('application/assessment_summary/' . $id);
        }
        if ($option == 'export') {
            $this->load->library('Excel');
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()->setCreator("Villgro")
            ->setLastModifiedBy("Villgro")
            ->setTitle("Preliminary Assessment")
            ->setSubject("Preliminary Assessment")
            ->setDescription("Preliminary Assessment")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Preliminary Assessment");

            $objPHPExcel->setActiveSheetIndex(0);
            $styleuser = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '6C2C2C'),
                    'size' => 11,
                    'name' => 'Times New Roman',
                ));
            $stylepres = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '6C2C2C'),
                    'size' => 10,
                    'name' => 'Times New Roman',
                ));
            $stylepres1 = array(
                'font' => array(
                    'bold' => true,
                    'background-color' => array('rgb' => '05C62C'),
                    'size' => 11,
                    'name' => 'Times New Roman',
                ));
            $dataStyle = array('alignment' => array('wrap' => true, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),
        );
            $objPHPExcel->getActiveSheet()->getStyle('A1:F' . $objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '1', 'Area');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '1', 'Enterprise Score');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('2', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2', '1', 'NA');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('3', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('3', '1', 'No - 0');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('4', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('4', '1', 'Low - 1');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('5', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('5', '1', 'Medium - 2');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('6', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('6', '1', 'High - 3');
            $col = 0;
            $row = 1;

            if (isset($assesst)) {
                $area_id = unserialize($assesst[0]['area_id']);
                $score = unserialize($assesst[0]['score']);
                $rational = unserialize($assesst[0]['rational']);
                $risk = unserialize($assesst[0]['risk']);
            }

            $count_area = count($area);
            foreach ($area as $area) {

                $col = 0;
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($stylepres);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $area['Name']);
                $col++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($stylepres);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $score[$area['id']]);

                $sub_category = $this->Massessment->getSubCategory($area['id']);
                $sub_count = count($sub_category);
                $i = 0;
                if (isset($sub_assesst)) {
                    foreach ($sub_assesst as $sub) {

                        if ($area['id'] == $sub['area_id']) {
                            $category_id = unserialize($sub['sub_category']);
                            $sub_score = unserialize($sub['sub_score']);
                            $add_score = unserialize($sub['add_score']);
                        }
                    }
                }
                foreach ($sub_category as $sub) {
                    $addscore = '';
                    if (isset($category_id) && in_array($sub['id'], $category_id)) {
                        $key = array_search($sub['id'], $category_id);
                        $subscore = $sub_score[$key];
                        $addscore = $add_score[$key];
                    }
                    $i++;
                    $col = 0;
                    $row++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['category']);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $subscore = ($subscore != '-1') ? $subscore : "";
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $subscore);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    if (isset($addscore) && $addscore != '') {
                        $reason = $this->Massessment->getReasons($addscore, $data['innovation']['partner_id']);
                        $result = $reason[0]['name'];
                    } else {
                        $result = "";
                    }
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['no']);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['low']);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['medium']);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['high']);
                }
                $row++;
                $col = 0;
                $cols = 'A';
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'A8F9A2'),
                    ),
                ));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Rationale");
                $col = $col + 1;

                $col1 = ++$cols . $row;
                $col2 = ++$cols . $row;
                $mer = $col1 . ':' . $col2;
                $objPHPExcel->getActiveSheet()->mergeCells($mer);
                $objPHPExcel->getActiveSheet()->getStyle($mer)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'DFFFDC'),
                    ),
                ));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rational[$area['id']]);
                $col = $col + 2;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'A8F9A2'),
                    ),
                ));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Risk");
                $col = $col + 1;
                ++$cols;
                $col1 = ++$cols . $row;
                ++$cols;
                $col2 = ++$cols . $row;
                $mer = $col1 . ':' . $col2;
                $objPHPExcel->getActiveSheet()->mergeCells($mer);
                $objPHPExcel->getActiveSheet()->getStyle($mer)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'DFFFDC'),
                    ),
                ));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $risk[$area['id']]);
                $row++;
            }

            $col = 0;
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL");
            $col++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCF3FF'),
                ),
            ));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $assesst[0]['total_score']);
            $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL %");
            $col++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCF3FF'),
                ),
            ));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $assesst[0]['total_per']);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Preliminary Assessment.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            ob_end_clean();
            $objWriter->save('php://output');

            exit;
        }
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
        $this->load->vars($data);
        $this->load->view('application/assessment/assessment_scoring');
    }

    public function store_assesst() {

        $check_main = $check_individual = 0;
        foreach ($_POST['checkall'] as $check) {
            $check_main += count($check);
        }
        foreach ($_POST['check'] as $check) {
            $check_individual += count($check);
        }

        $rationale_string = preg_replace('/[^A-Za-z0-9\n\r\s\_ .,\/\@$%&*():;\'"?-]/', '', $_POST['rational']);
        $risk_string = preg_replace('/[^A-Za-z0-9\n\r\s\_ .,\/\@$%&*():;\'"?-]/', '', $_POST['risk']);

        $area_id = serialize($_POST['area_id']);
        $score = serialize($_POST['score']);
        $rational = serialize($rationale_string);
        $risk = serialize($risk_string);
        $table = "assest_detail";

        if ($_POST['total_score'] != '' || $check_main > 0 || $check_individual > 0) {
            $score_enter = '1';
        } else {
            $score_enter = '0';
        }

        if ($_POST['assesst_id'] == "") {
            $data = array(
                "innovation_id" => $_POST['innovation_id'],
                "area_id" => $area_id,
                "score" => $score,
                "total_score" => $_POST['total_score'],
                "total_per" => $_POST['total_per'],
                "comment" => $_POST['comment'],
                "rational" => $rational,
                "risk" => $risk,
                "assesst_by" => $this->session->userdata('emp_number'),
                "assesst_date" => date("Y-m-d H:i:s"),
                "score_entered" => $score_enter
            );

            $assesst_id = $this->Massessment->insert_assesst($table, $data);
            $assigned_incharge = $this->Mincharge->getAssociateId($_POST['innovation_id']);
            $msg = "Assessment details saved successfully";
        } else {
            $data = array(
                "area_id" => $area_id,
                "score" => $score,
                "total_score" => $_POST['total_score'],
                "total_per" => $_POST['total_per'],
                "comment" => $_POST['comment'],
                "rational" => $rational,
                "risk" => $risk,
                "modified_by" => $this->session->userdata('emp_number'),
                "modified_date" => date("Y-m-d H:i:s"),
                "score_entered" => $score_enter
            );

            $where = array("innovation_id" => $_POST['innovation_id'], "id" => $_POST['assesst_id'], "assesst_by" => $this->session->userdata('emp_number'));
            $updated_rows = $this->Massessment->update_assesst($table, $data, $where);
            $msg = "Assessment details updated successfully";
        }

        foreach ($_POST['area_id'] as $area) {
            $count = $_POST['sub_count'][$area];
            $sub_score[$area] = array();
            $sub_id[$area] = array();
            $add_score[$area] = array();
            for ($i = 1; $i <= $count; $i++) {
                if (isset($_POST['check'][$area . '_' . $i])) {
                    array_push($sub_id[$area], $_POST['category_id'][$area . '_' . $i]);
                    array_push($sub_score[$area], '-1');
                    array_push($add_score[$area], '20');
                    // array_push($add_score[$area], $_POST['reason'][$area . '_' . $i]);
                } else {

                    array_push($sub_id[$area], $_POST['category_id'][$area . '_' . $i]);
                    array_push($sub_score[$area], $_POST['sub'][$area . '_' . $i]);
                    array_push($add_score[$area], '');
                }
            }
            $table1 = "assesst_sub_cat_detail";
            if ($_POST['assesst_id'] == "") {
                $data1 = array(
                    "area_id" => $area,
                    "sub_category" => serialize($sub_id[$area]),
                    "sub_score" => serialize($sub_score[$area]),
                    "add_score" => serialize($add_score[$area]),
                    "assesst_detail_id" => $assesst_id,
                );
                $subcat_id = $this->Massessment->insert_assesst($table1, $data1);
            } else {
                $data1 = array(
                    "sub_category" => serialize($sub_id[$area]),
                    "sub_score" => serialize($sub_score[$area]),
                    "add_score" => serialize($add_score[$area]),
                );

                $where1 = array('area_id' => $area, "assesst_detail_id" => $_POST['assesst_id']);
                $updated_rows = $this->Massessment->update_assesst($table1, $data1, $where1);
            }
        }
        $this->session->set_flashdata('successMsg', $msg);
        redirect('application/assessment_scoring/' . $_POST['innovation_id']);
    }

    public function assessment_summary($id) {
        $data['log_details'] = $this->Mincharge->getStatusLog($id);
        $data['iic_log_detail'] = $this->Mincharge->getIICLogDate($id);
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $data['get_score'] = $this->Massessment->checkScoreAssesst($id);

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
		
		$programId = $data['innovation']['program'];
        $data['area'] = $this->Massessment->getArea($data['innovation']['partner_id'],$programId);
        $data['assigned_incharge'] = $assigned_incharge = $this->Mincharge->getAssociateId($id);
        $data['active_incharge'] = $active_incharge = $this->Mincharge->getActiveIncharge($id);
        $data['inno_status'] = $this->Massessment->getInnoStatus($id);
        $innovation = $this->Minnovation->getInnovation($id);
        // $data['donor_fit'] = $this->Massessment->getDonorFit($innovation['partner_id']);
        $cio_emp_id = $this->Mmaster->getEmpIdBySetUP('cio', $this->session->userdata('partner_id'));
        $data['cio_emp_num'] = $cio_emp_id[0]['cio'];

        $deals_donor = '';
        $data['feed_back_exist'] = $this->Massessment->feedbackCheck($id);
        if ($data['feed_back_exist']) {
            $data['feed_back'] = $this->Massessment->getFeedback($id);
            $deals_donor = $data['feed_back'][0]['donor_fit'];
        }
        if (!empty($assigned_incharge) && in_array($this->session->userdata('emp_number'), $assigned_incharge)) {
            $data['assesst'] = $this->Massessment->getAssesst($id, $this->session->userdata('emp_number'));
        }

        $app_stage = $innovation['stage'];
        $app_status = $innovation['status'];

        $active_donor_fit = $existing_donor = $sortArray = array();
        $active_donor_fit = $this->Massessment->getDonorFit($innovation['partner_id']);
        if (($app_stage == '12' && $app_status == '12') || $app_status == '13' || $app_status == '17' || $app_status == '18' || $app_status == '20') {
            $existing_donor = $this->Massessment->getExistDonorFit($deals_donor);
        }

        $d_fitList = array_merge($active_donor_fit, $existing_donor);
        foreach ($d_fitList as $fit) {
            foreach ($fit as $key => $value) {
                if (!isset($sortArray[$key])) {
                    $sortArray[$key] = array();
                }
                $sortArray[$key][] = $value;
            }
        }

        $orderby = "name";

        array_multisort($sortArray[$orderby], SORT_ASC, $d_fitList);
        $data['donor_fit'] = $d_fitList;
        $data['application_id'] = $id;
        $data['assessor'] = $this->Massessment->getAssessors($id);
        $this->load->model('master/Mmaster_settings');
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $innovation['partner_id']);
        $this->load->vars($data);
        $this->load->view('application/assessment/assessment_summary');
    }

    public function store_summary() {
        $this->load->library('upload');
        $stage_data = array(
            'enterprise_stage' => (isset($_POST['stage'])) ? $_POST['stage'] : '',
        );
        $user_where = array('id' => $_POST['innovation_id']);
        $table = "innovation_pool";
        $this->Minnovation->pitch_update($table, $stage_data, $user_where);

        $partner_id = $this->session->userdata('partner_id');
        $assigned_incharge = $this->Mincharge->getAssociateId($_POST['innovation_id']);
        $innovation = $this->Minnovation->getInnovation($_POST['innovation_id']);
        $cio_emp_id = $this->Mmaster->getEmpIdBySetUP('cio', $this->session->userdata('partner_id'));
        $don_fit1 = explode(',', $_POST['donor_fit1']);
        $donor_fit = (isset($_POST['donor_fit'])) ? implode(',', $_POST['donor_fit']) : $_POST['donor_fit1'];
        $fund_recom = array();
        $fund_approved = array();
        $don_fit = !empty($_POST['donor_fit']) ? $_POST['donor_fit'] : $don_fit1;
        if (isset($don_fit)) {
            foreach ($don_fit as $donor) {
                $fund_recom[] = ($_POST['fund_recom'][$donor] != '') ? $donor . '_' . $_POST['fund_recom'][$donor] : '0';
                $fund_approved[] = ($_POST['fund_approved'][$donor] != '') ? $donor . '_' . $_POST['fund_approved'][$donor] : '0';
            }
        }

        $time = date("H:i:s");
        $get_iic_date = $_POST['iic_date'] . ' ' . $time;
        $create_iic_log = date("Y-m-d H:i:s", strtotime($get_iic_date));

        $recom_fund = (!empty($fund_recom)) ? implode(',', $fund_recom) : '';
        $approved_fund = (!empty($fund_approved)) ? implode(',', $fund_approved) : '';
        $lis = (isset($_POST['LIS'])) ? $_POST['LIS'] : $_POST['LIS1'];

        if ($_POST['donor_fit'] == '') {
            $donor_up = $_POST['donor_fit'];
        } else {
            $donor_up = $donor_fit;
        }

        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/assessment';
        $user_doc_path = $iic_doc_path = '';

        if ($_FILES["user_doc"]["name"] != "") {
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';

            $file_name = explode('.', $_FILES["user_doc"]["name"]);
            $file_ext = end(explode('.', $_FILES["user_doc"]["name"]));
            $sliced = array_slice($file_name, 0, -1);
            $string = implode(" ", $sliced);
            $change_first = str_replace('.', '-', $string);

            $newfilename = preg_replace('/[^A-Za-z0-9\_.]/', '-', $change_first);
            $change_name = str_replace(' ', '-', $newfilename . '.' . $file_ext);
            $config['file_name'] = date('Ymdhis') . '_user_' . str_replace('_', '-', $change_name);

            $this->upload->initialize($config);

            $_FILES['user_doc_upload']['name'] = $_FILES['user_doc']['name'];
            $_FILES['user_doc_upload']['tmp_name'] = $_FILES['user_doc']['tmp_name'];
            $_FILES['user_doc_upload']['size'] = $_FILES['user_doc']['size'];
            $_FILES['user_doc_upload']['type'] = $_FILES['user_doc']['type'];
            $_FILES['user_doc_upload']['error'] = $_FILES['user_doc']['error'];

            if (!$this->upload->do_upload('user_doc_upload')) {
                $upload_error = $this->upload->display_errors();
            } else {
                $upload_data = $this->upload->data();
                $user_doc_path = $upload_data['file_name'];
            }
            unset($config);
        } else if (isset($_POST['user_doc_old'])) {
            $user_doc_path = $_POST['user_doc_old'];
        }

        if ($_FILES["iic_doc"]["name"] != "") {
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';

            $file_name = explode('.', $_FILES["iic_doc"]["name"]);
            $file_ext = end(explode('.', $_FILES["iic_doc"]["name"]));
            $sliced = array_slice($file_name, 0, -1);
            $string = implode(" ", $sliced);
            $change_first = str_replace('.', '-', $string);

            $newfilename = preg_replace('/[^A-Za-z0-9\_.]/', '-', $change_first);
            $change_name = str_replace(' ', '-', $newfilename . '.' . $file_ext);
            $config['file_name'] = date('Ymdhis') . '_iic_' . str_replace('_', '-', $change_name);

            $this->upload->initialize($config);

            $_FILES['iic_doc_upload']['name'] = $_FILES['iic_doc']['name'];
            $_FILES['iic_doc_upload']['tmp_name'] = $_FILES['iic_doc']['tmp_name'];
            $_FILES['iic_doc_upload']['size'] = $_FILES['iic_doc']['size'];
            $_FILES['iic_doc_upload']['type'] = $_FILES['iic_doc']['type'];
            $_FILES['iic_doc_upload']['error'] = $_FILES['iic_doc']['error'];

            if (!$this->upload->do_upload('iic_doc_upload')) {
                $upload_error = $this->upload->display_errors();
            } else {
                $upload_data = $this->upload->data();
                $iic_doc_path = $upload_data['file_name'];
            }
            unset($config);
        } else if (isset($_POST['iic_doc_old'])) {
            $iic_doc_path = $_POST['iic_doc_old'];
        }

        $data = array(
            "feed_back" => (isset($_POST['comments'])) ? $_POST['comments'] : '',
            "result" => (isset($_POST['recomment'])) ? $_POST['recomment'] : '',
            "reject_reason" => (isset($_POST['reason'])) ? $_POST['reason'] : '',
            "LIS" => $lis,
            "donor_fit" => $donor_up,
            "fund_recom" => $recom_fund,
            "fund_approved" => $approved_fund,
            "innovation_id" => $_POST['innovation_id'],
            'user_document' => $this->db->escape_str($user_doc_path),
            'iic_document' => $this->db->escape_str($iic_doc_path)
        );

        if (isset($_POST['internal_status'])) {
            $data['internal_status'] = $_POST['internal_status'];
            $data['internal_comment'] = (isset($_POST['internal_comment'])) ? $_POST['internal_comment'] : '';
            $data['internal_date'] = $create_iic_log;
        }
        if ($this->session->userdata('emp_number') == $cio_emp_id[0]['cio']) {
            $score = serialize($_POST['score']);
            $rational = serialize($_POST['rational']);
            $risk = serialize($_POST['risk']);
            $data["score"] = (isset($_POST['total_score'])) ? $_POST['total_score'] : '';
            $data["per_score"] = (isset($_POST['total_per_cio'])) ? $_POST['total_per_cio'] : '';
            $data["area_score"] = $score;
            $data["rational"] = $rational;
            $data["risk"] = $risk;
            $data["cio_status"] = (isset($_POST['cio_status'])) ? $_POST['cio_status'] : '';
            $data["cio_comment"] = (isset($_POST['cio_comment'])) ? $_POST['cio_comment'] : '';
        }
        $table = "grading_feedback";

        if ($_POST['recomment'] != '' && $_POST['accept_reject'] == '1') {
            $data['userstatus_date'] = date("Y-m-d H:i:s");

            $ids = $_POST['innovation_id'];
            $employees = $this->Sector_model->getEmpId($ids);
            $emp_Ids = array_map(function ($emp_Ids) {
                return $emp_Ids['associate_employee'];
            }, $employees);
            $employees_id = rtrim(implode(',', $emp_Ids), ',');

            $log_data = array(
                'innovation_id' => $_POST['innovation_id'],
                'stage' => $innovation['stage'],
                'assigned_user' => $employees_id,
                'modified_by' => $this->session->userdata('emp_number'),
                'modified_date' => date('Y-m-d H:i:s'),
            );

            /* -----User Accept/Reject------ */
            if ($_POST['recomment'] == 'Accept') {
                $log_data['status'] = 15;
            } else if ($_POST['recomment'] == 'Reject') {
                $this->session->set_userdata('close_action', 'yes');
                $log_data['status'] = 16;
                $data1 = array('status' => '3',
                    'close_status' => $innovation['status'],
                    "comments" => (isset($_POST['comments'])) ? $_POST['comments'] : '',
                    "reasons" => (isset($_POST['reason'])) ? $_POST['reason'] : '',
                    'reopen_status' => 0);
                $table1 = 'innovation_pool';
                $where1 = array('id' => $_POST['innovation_id']);
                $updated_rows = $this->Massessment->update_assesst($table1, $data1, $where1);
            }

            $table_log = "application_status_log";
            $result = $this->Minnovation->pitch_insert($table_log, $log_data);
        }

        if ($_POST['feed_back_id'] == '') {
            $data['created_date'] = date("Y-m-d H:i:s");
            $data['created_by'] = $this->session->userdata('emp_number');
            $assign_id = $this->Massessment->insert_assesst($table, $data);
//            $msg = "Assessment Grading Added Successfully";
            $msg = "Summary details saved successfully";
        } else {
            $data['modified_date'] = date("Y-m-d H:i:s");
            $data['modified_by'] = $this->session->userdata('emp_number');

            $where = array('id' => $_POST['feed_back_id'], 'innovation_id' => $_POST['innovation_id']);
            $assign_id = $this->Massessment->update_assesst($table, $data, $where);
//            $msg = "Assessment Grading Updated Successfully";
            $msg = "Summary details saved successfully";
        }

        /* -----Internal IC Accept/Reject------ */
        if ($_POST['form_type'] == 'submit') {
            if ($_POST['internal_status'] == 'Accept' || $_POST['cio_status'] == 'Accept') {
                $ids = $_POST['innovation_id'];

                $invID = 'INV' . $ids;
                $innv_pool = $this->Mdiligence->get_data('innovation_pool', $invID);
                $mem_data = array();
                if ($innv_pool[0]['program'] == 0) {
                    $mem_data = $this->Mdiligence->getManageIncub($invID);
                } else if ($innv_pool[0]['program'] == 3 || $innv_pool[0]['program'] == 4 || $innv_pool[0]['program'] == 6) {
                    $mem_data = $this->Mdiligence->getManagePitch($invID);
                }

                foreach ($mem_data as $team) {
                    if ($team['name'] != '') {
                        $m_team['name'] = isset($team['name']) && $team['name'] != '' ? $team['name'] : '';
                        $m_team['mobile'] = isset($team['mobile']) && $team['mobile'] != '' ? $team['mobile'] : '';
                        $m_team['email'] = isset($team['email']) && $team['email'] != '' ? $team['email'] : '';
                        $m_team['design'] = isset($team['desg']) && $team['desg'] != '' ? $team['desg'] : '';
                        $m_team['created_date'] = date('Y-m-d H:i:s');
                        $m_team['innovation_id'] = $invID;
                        $table = "management_team";
                        $result = $this->Minnovation->pitch_insert($table, $m_team);
                    }
                }

                $employees = $this->Sector_model->getEmpId($ids);

                $emp_Ids = array_map(function ($emp_Ids) {
                    return $emp_Ids['associate_employee'];
                }, $employees);
                $employees_id = rtrim(implode(',', $emp_Ids), ',');

                $log_data = array(
                    'innovation_id' => $_POST['innovation_id'],
                    'stage' => 9,
                    'status' => 13,
                    'assigned_user' => $employees_id,
                    'modified_by' => $this->session->userdata('emp_number'),
                    'modified_date' => $create_iic_log,
                );

                $table_log = "application_status_log";
                $result = $this->Minnovation->pitch_insert($table_log, $log_data);

                $status = '13';
                $stage = '9';

                $table1 = 'innovation_pool';
                $where1 = array('id' => $_POST['innovation_id']);
                $data1 = array('status' => $status, 'stage' => $stage);
                $updated_rows = $this->Massessment->update_assesst($table1, $data1, $where1);
            } else if ($_POST['internal_status'] == 'Reject' || $_POST['cio_status'] == 'Reject') {
                $this->session->set_userdata('close_action', 'yes');
                $ids = $_POST['innovation_id'];
                $employees = $this->Sector_model->getEmpId($ids);

                $emp_Ids = array_map(function ($emp_Ids) {
                    return $emp_Ids['associate_employee'];
                }, $employees);
                $employees_id = rtrim(implode(',', $emp_Ids), ',');

                $log_data = array(
                    'innovation_id' => $_POST['innovation_id'],
                    'stage' => 8,
                    'status' => 14,
                    'assigned_user' => $employees_id,
                    'modified_by' => $this->session->userdata('emp_number'),
                    'modified_date' => $create_iic_log,
                );

                $table_log = "application_status_log";
                $result = $this->Minnovation->pitch_insert($table_log, $log_data);

                $status = '14';
                $stage = '8';

                $table1 = 'innovation_pool';
                $where1 = array('id' => $_POST['innovation_id']);
                $data1 = array('status' => $status, 'stage' => $stage);
                $updated_rows = $this->Massessment->update_assesst($table1, $data1, $where1);

                $table1 = 'innovation_pool';
                $where1 = array('id' => $_POST['innovation_id']);
                $data1 = array('status' => $status);
                $updated_rows = $this->Massessment->update_assesst($table1, $data1, $where1);
                //////////////////// Rejection mail sending process///////////////////////
                $this->db->select("email_id,id,created_date,name_of_entrepreneur");
                $this->db->where('id', $_POST['innovation_id']);
                $query = $this->db->get('innovation_pool');
                $details = $query->result_array();
                $innovation_no = $details[0]['id'];
                $to_mail = $details[0]['email_id'];
                $date = $details[0]['created_date'];
                $createDate = new DateTime($date);
                $strip = $createDate->format('Y-m-d');
                $this->db->where('messagetype', 'Rejection');
                $this->db->where('partner_id', $partner_id);
                $template = $this->db->get('master_mailtemplate');
                if ($template->num_rows() > 0) {
                    $template1 = $template->result_array();
                    $mail_template = $template1[0]['messagebody'];
                    $org = array('#name_of_entrepreneur#', '#applied_date#');
                    $replace = array($details[0]['name_of_entrepreneur'], $strip);
                    $messageBody = str_replace($org, $replace, $mail_template);
                    if ($partner_id == 1) {
                        $body = $this->imgUrl($messageBody);
                    } else {
                        $body = $messageBody;
                    }
                }
                //////////////////// Rejection mail sending process ends /////////////////
            }
            $msg = "Deal submitted for IIC review";
        }
        $this->session->set_flashdata('successMsg', $msg);
        redirect('application/assessment_summary/' . $_POST['innovation_id']);
    }

    public function mail_history($id = '') {
        $data['application_id'] = $id;
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $this->load->vars($data);
        $this->load->view('application/options/mail_history');
    }

    public function viewMailHistory() {
        $id = $this->input->post('id');
        $data['viewMail'] = $this->Mmail->getMailInfo($id);
        echo json_encode($data['viewMail']);
    }

    public function deleteMailHistory($innovation = '', $id = '') {
        if ($innovation != '' && $id != '') {
            $result = $this->Mmail->delete($id);
            $this->session->set_flashdata('successMsg', 'Mail history deleted successfully');
        } else {
            $this->session->set_flashdata('successMsg', 'Value Missing');
        }
        redirect('application/mail_history/' . $innovation);
    }

    public function DT_internalMail() {
        $requestData = $_POST;

        $columns = array(
            0 => 'from',
            1 => 'to',
            2 => 'sent_date',
            3 => 'subject'
        );

        $option['innovation'] = (isset($_POST['innovation'])) ? $_POST['innovation'] : '';

        $totalrows = $this->Mapplication->getDTInternalMailCount($option, $columns, $requestData);
        $query = $this->Mapplication->getDTInternalMailDetails($requestData['length'], $requestData['start'], $option, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();

            // $nestedData[] = '<input type="checkbox" class="chk_box" id="emp_chk_box" name="internal_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['from'];
            $nestedData[] = $row['to'];
            $nestedData[] = (isset($row['sent_date']) && $row['sent_date'] != '') ? date('d-m-Y', strtotime($row['sent_date'])) : '';
            $nestedData[] = $row['mail_type'];
            $nestedData[] = strlen($row['subject']) > 25 ? substr($row['subject'], 0, 25) . ".." : $row['subject'];
            $nestedData[] = '<span class="fa fa-eye clr_geen" title="View Details" onclick="mailDetails(' . $row['id'] . ');"></span>';
            $nestedData[] = '<a href="' . base_url() . 'index.php/application/send_mail/' . $row['innovation'] . '/' . $row['id'] . '" title="Resend Mail"><span class="fa fa-envelope"></span></a>&nbsp;&nbsp;<span class="fa fa-trash clr_geen" title="Delete History" onclick="deleteMail(' . $row['innovation'] . ',' . $row['id'] . ')"></span>';

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

    public function DT_externalMail() {
        $requestData = $_POST;

        $columns = array(
            0 => 'to',
            1 => 'subject',
            2 => 'body',
            3 => 'sent_on'
        );

        $option['innovation'] = (isset($_POST['innovation'])) ? $_POST['innovation'] : '';

        $totalrows = $this->Mapplication->getDTExternalMailCount($option, $columns, $requestData);
        $query = $this->Mapplication->getDTExternalMailDetails($requestData['length'], $requestData['start'], $option, $columns, $requestData);
        $totalFiltered = $totalrows;
        $totalData = count($query);
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query as $row) {
            $nestedData = array();

            // $nestedData[] = '<input type="checkbox" class="chk_box" id="emp_chk_box" name="internal_id[]" value="' . $row['id'] . '"/>';
            $nestedData[] = $row['to'];
            $nestedData[] = strlen($row['subject']) > 25 ? substr($row['subject'], 0, 25) . ".." : $row['subject'];
            $nestedData[] = strlen($row['body']) > 40 ? substr($row['body'], 0, 40) . ".." : $row['body'];
            $nestedData[] = (isset($row['sent_on']) && $row['sent_on'] != '') ? date('d-m-Y', strtotime($row['sent_on'])) : '';
            $nestedData[] = "<a href='" . base_url() . "uploads/ext_mail_docs/" . $row['file_name'] . "' target='_blank'><span class='fa fa-download'></span></a>";

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

    public function view_documents($id = '') {
        $data['application_id'] = $id;
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $data['innovationDoc'] = $this->Malldocument->getInnovationDocument($id);
        $data['innovationsupportDoc'] = $this->Malldocument->getInnovationSupportingDocument($id);
        $data['assesmentDoc'] = $this->Malldocument->getAssessmentDocument($id);
        $data['presentDoc'] = $this->Malldocument->getPresentationDocument($id);
        $data['screeningDoc'] = $this->Malldocument->getscreenDoc($id);
        $data['assesDoc'] = $this->Mscreening->getassessdocument($id);
        $data['signDoc'] = $this->Malldocument->getsignDoc($id);
        $data['generaldocument'] = $this->Malldocument->getgeneraldocument($id);

        $incubatee = $this->Malldocument->getincubateename($id);
        $username = @$incubatee['user_name'];
        $path = "../ajaxplorer/data/personal/admin/Villgro/departments/ramp/incubation/incubation-innovations-funded";
        $file_names = $this->scanFileNameRecursivly($path);
        $files = array();
        foreach ($file_names as $key => $value) {
            if (isset($username)) {
                if (strpos($value, strtolower($username))) {
                    $files[] = $value;
                }
            }
        }
        $data['files'] = $files;

        $this->load->vars($data);
        $this->load->view('application/options/view_documents');
    }

    public function upload_document($id = null) {
        $data['application_id'] = $id;
        $data['innovation'] = $this->Minnovation->getInnovation($id);

        $this->load->vars($data);
        $this->load->view('application/options/upload_document');
    }

    public function add_upload_document() {
        $options = array();
        $this->load->library('upload');
        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/upload_document';
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';
        $config['file_name'] = date('Ymdhis') . '_' . str_replace(' ', '_', $_FILES['document_file']["name"]);

        $this->upload->initialize($config);

        $_FILES['upload']['name'] = $config['file_name'];
        $_FILES['upload']['tmp_name'] = $_FILES['document_file']['tmp_name'];
        $_FILES['upload']['size'] = $_FILES['document_file']['size'];
        $_FILES['upload']['type'] = $_FILES['document_file']['type'];
        $_FILES['upload']['error'] = $_FILES['document_file']['error'];

        $this->upload->do_upload('upload');

        $options = $_POST;
        $options['files'] = $config['file_name'];
        $value = $this->Malldocument->insertdocuments($options);
        redirect('application/view_documents/' . $value);
        $this->session->set_flashdata('successMsg', 'Documents Inserted Successfully');
    }

    public function scanFileNameRecursivly($path = '', $name = array()) {
        $path = $path == '' ? dirname(__FILE__) : $path;
        $lists = @scandir($path);
        if (!empty($lists)) {
            foreach ($lists as $f) {

                if (is_dir($path . DIRECTORY_SEPARATOR . $f) && $f != ".." && $f != ".") {

                } else {
                    $name[] = $path . DIRECTORY_SEPARATOR . $f;
                }
            }
        }
        return $name;
    }

    public function external_mail($id = '') {
        $data['application_id'] = $id;
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);

        $this->load->vars($data);
        $this->load->view('application/options/external_mail');
    }

    public function add_external_mail() {
        $this->load->library('upload');
        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/ext_mail_docs';
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';
        $config['file_name'] = date('Ymdhis') . '_' . str_replace(' ', '_', $_FILES['document_file']["name"]);

        $this->upload->initialize($config);

        $_FILES['upload']['name'] = $config['file_name'];
        $_FILES['upload']['tmp_name'] = $_FILES['document_file']['tmp_name'];
        $_FILES['upload']['size'] = $_FILES['document_file']['size'];
        $_FILES['upload']['type'] = $_FILES['document_file']['type'];
        $_FILES['upload']['error'] = $_FILES['document_file']['error'];

        $this->upload->do_upload('upload');

        $filename = $config['file_name'];
        $data = array(
            'to' => $_POST['messageTo'],
            'subject' => $_POST['messageSubject'],
            'body' => trim($_POST['messageBody']),
            'sent_on' => date('Y-m-d'),
            'file_name' => $filename,
            'innovation_id' => $_POST['innovation'],
        );
        $this->Mmail->insert_ext_mail($data);

        $msg = "External mail saved successfully";
        $this->session->set_flashdata('successMsg', $msg);
        redirect('application/mail_history/' . $_POST['innovation']);
    }

    public function send_mail($inv_id = '', $id = '') {
        $data['application_id'] = $inv_id;
        $data['innovation'] = $this->Minnovation->getInnovation($inv_id);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($inv_id);
        $data['mailType'] = $this->Mmailtemplate->getMailtype();
        if ($id != '') {
            $data['mailDetails'] = $this->Mmail->getMailInfo($id);
        }

        $this->load->vars($data);
        $this->load->view('application/options/send_mail');
    }

    public function add_send_mail() {
        $options['innovation'] = $_POST['innovation'];
        $options['from'] = $_POST['from'];
        $options['to'] = $_POST['messageTo'];
        $options['mail_type'] = $_POST['mailType'];
        $options['subject'] = $_POST['messageSubject'];
        $options['body'] = trim($_POST['messageBody']);
        $result = $this->Mmail->insert($options);
        $msg = "Mail sent successfully !";
        $this->session->set_flashdata('successMsg', $msg);
        redirect('application/mail_history/' . $_POST['innovation']);
    }

    public function getMailContent() {
        $option['messagetype'] = $this->input->post('mail_type');
        $option['partner_id'] = $this->session->userdata('partner_id');
        $template = $this->Mportfolio->getDetails('master_mailtemplate', $option);
        echo json_encode($template);
    }

    public function getFromMail() {
        $inv_id = $this->input->post('inv_id');
        $mail_type = $this->input->post('mail_type');
        $partner_id = $this->session->userdata('partner_id');
        $mailContent = $this->Mmail->getMailContent($inv_id, $mail_type, $partner_id, 1);
        echo json_encode($mailContent);
    }

    public function diligence_summary($id = '') {
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
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/diligence_summary');
    }

    public function diligence_company_data($id = '') {
        $invID = 'INV' . $id;
        $innv_pool = $this->Mdiligence->get_data('innovation_pool', $invID);
        if ($innv_pool[0]['program'] == 0) {
            $data['main_data'] = $this->Mdiligence->getMainIncub($invID);
            $data['mem_data'] = $this->Mdiligence->getManageIncub($invID);
        } else if ($innv_pool[0]['program'] == 3 || $innv_pool[0]['program'] == 4 || $innv_pool[0]['program'] == 6) {
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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $data['subSectorName'] = $this->Mincharge->getSubsectorName($ssector);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/diligence_company_data');
    }

    public function save_master_data() {
        $invID = 'INV' . $_POST['innovation_id'];
        $get_innovation = $this->Mdiligence->get_data('company_master_data', $invID);
        $format_date = (isset($_POST['incorporation_date']) && $_POST['incorporation_date'] != '') ? date('Y-m-d', strtotime($_POST['incorporation_date'])) : '';
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
            $user_where = array('innovation_id' => $invID);
            $table = "company_master_data";
            $this->Minnovation->pitch_update($table, $inv_user_data, $user_where);
        } else {
            $inv_user_data = array(
                'innovation_id' => $invID,
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
        redirect('application/diligence_company_data/' . $_POST['innovation_id']);
    }

    public function diligence_management_team($id) {
        $invID = 'INV' . $id;
        $data['teamData'] = $this->Mdiligence->get_data('management_team', $invID);
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
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/diligence_management_team');
    }

    public function save_diligence_management() {
        $add_count = count($_POST['name']);
        for ($i = 0; $i < $add_count; $i++) {
            if ($_POST['name'][$i] != '') {
                $data['innovation_id'] = 'INV' . $_POST['inv_id'];
                $mgmt_id = $_POST['memberId'][$i];
                $data['name'] = $_POST['name'][$i];
                $data['mobile'] = $_POST['mobile'][$i];
                $data['email'] = $_POST['email'][$i];
                $data['location'] = $_POST['location'][$i];
                $data['design'] = $_POST['design'][$i];
                $data['modified_date'] = date('Y-m-d H:i:s');

                $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/detailed_diligence';
                $resume_path = '';
                if ($_FILES["resume"]["name"][$i] != "") {
                    $split_name = explode('.', $_FILES["resume"]["name"][$i]);
                    $get_extension = array_pop($split_name);
                    $get_name = implode('', $split_name);
                    $this->load->library('upload');
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';

                    $rename_file = str_replace(' ', '_', strtolower($get_name));
                    $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
                    $config['file_name'] = date('Ymdhis') . '_management_' . $new_name . '.' . $get_extension;

                    $this->upload->initialize($config);
                    $_FILES['resume_doc']['name'] = $_FILES['resume']['name'][$i];
                    $_FILES['resume_doc']['tmp_name'] = $_FILES['resume']['tmp_name'][$i];
                    $_FILES['resume_doc']['size'] = $_FILES['resume']['size'][$i];
                    $_FILES['resume_doc']['type'] = $_FILES['resume']['type'][$i];
                    $_FILES['resume_doc']['error'] = $_FILES['resume']['error'][$i];

                    if (!$this->upload->do_upload('resume_doc')) {
                        $upload_error = $this->upload->display_errors();
                        echo $upload_error . "--" . $i;
                    } else {
                        $upload_data = $this->upload->data();
                        $resume_path = $upload_data['file_name'];
                    }
                    unset($config);
                    $data['resume'] = $resume_path;
                } else if ((isset($_POST['old_resume_doc'][$i]) && $_POST['old_resume_doc'][$i] != '') && $resume_path == '') {
                    $data['resume'] = $_POST['old_resume_doc'][$i];
                }

                if ($mgmt_id != '') {
                    $data['status'] = 1;
                    $send_data = $this->Mdiligence->update_meeting('management_team', $data, $mgmt_id);
                } else {
                    $data['created_date'] = date('Y-m-d H:i:s');
                    $send_data = $this->Mdiligence->insert_data('management_team', $data);
                }
            }
        }
        if ($send_data) {
            $this->session->set_userdata("successMsg", 'Management details saved successfully');
            redirect('application/diligence_management_team/' . $_POST['inv_id']);
        } else {
            $this->session->set_userdata("errorMsg", 'Some information missing');
            redirect('application/diligence_management_team/' . $_POST['inv_id']);
        }
    }

    public function diligence_cap_table($id) {
        $invID = 'INV' . $id;
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
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/diligence_cap_table');
    }

    public function save_diligence_share() {
        $inv_id = 'INV' . $_POST['inv_id'];
        $count = count($_POST['holder']);
        for ($i = 0; $i < $count; $i++) {
            $get_innovation = $this->Mdiligence->get_data('share_details', $inv_id);
            if (!empty($get_innovation) && $_POST['shareId'][$i] != '') {
                if ($_POST['holder'][$i] != '') {
                    $member_data = array(
                        'holder' => $this->db->escape_str($_POST['holder'][$i]),
                        'share' => $this->db->escape_str($_POST['share'][$i]),
                        'type' => $this->db->escape_str($_POST['type'][$i]),
                        'modified_date' => date('Y-m-d H:i:s'),
                        'innovation_id' => $inv_id,
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
                        'innovation_id' => $inv_id,
                    );
                    $table = "share_details";
                    $result = $this->Minnovation->pitch_insert($table, $member_data);
                }
            }
        }
        $this->session->set_userdata("successMsg", 'Share details saved successfully');
        redirect('/application/diligence_cap_table/' . $_POST['inv_id']);
    }

    public function diligence_documents($id) {
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
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
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
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/diligence_documents');
    }

    public function save_diligence_document() {
        $inv_id = $_POST['inv_id'];
        $send_data = 0;

        foreach ($_POST['doc_type'] as $type) {
            if ($type == 1) {
                $this->dd_document_type($inv_id, $type, $_POST['signed_desc'], 'signed_file', $_FILES['signed_file'], $_POST['old_signed_file']);
            } else if ($type == 2) {
                $this->dd_document_type($inv_id, $type, $_POST['quest_desc'], 'quest_file', $_FILES['quest_file'], $_POST['old_quest_file']);
            } else if ($type == 3) {
                $this->dd_document_type($inv_id, $type, $_POST['term_desc'], 'term_file', $_FILES['term_file'], $_POST['old_term_file']);
            } else if ($type == 4) {
                $this->dd_document_type($inv_id, $type, $_POST['service_desc'], 'service_file', $_FILES['service_file'], $_POST['old_service_file']);
            } else if ($type == 5) {
                $this->dd_document_type($inv_id, $type, $_POST['comp_desc'], 'comp_file', $_FILES['comp_file'], $_POST['old_comp_file']);
            } else if ($type == 6) {
                $this->dd_document_type($inv_id, $type, $_POST['villgro_desc'], 'villgro_file', $_FILES['villgro_file'], $_POST['old_villgro_file']);
            }
            $send_data = 1;
        }

        $add_count = count($_POST['add_doc_type']);
        for ($i = 0; $i < $add_count; $i++) {
            if ($_POST['add_doc_type'][$i] != '') {
                $data['innovation_id'] = $innovation_id = 'INV' . $inv_id;
                $data['doc_type'] = $_POST['add_doc_type'][$i];
                $data['description'] = $this->db->escape_str($_POST['additional_desc'][$i]);
                $data['added_by_id'] = $this->session->userdata['emp_number'];
                $data['added_by_name'] = $this->session->userdata['emp_name'];
                $data['created_at'] = date('Y-m-d H:i:s');

                $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/detailed_diligence';
                $resume_path = '';
                if ($_FILES["additional_file"]["name"][$i] != "") {
                    $split_name = explode('.', $_FILES["additional_file"]["name"][$i]);
                    $get_extension = array_pop($split_name);
                    $get_name = implode('', $split_name);
                    $this->load->library('upload');
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';

                    $rename_file = str_replace(' ', '_', strtolower($get_name));
                    $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
                    $config['file_name'] = date('Ymdhis') . '_document_' . $new_name . '.' . $get_extension;

                    $this->upload->initialize($config);
                    $_FILES['additional_doc']['name'] = $_FILES['additional_file']['name'][$i];
                    $_FILES['additional_doc']['tmp_name'] = $_FILES['additional_file']['tmp_name'][$i];
                    $_FILES['additional_doc']['size'] = $_FILES['additional_file']['size'][$i];
                    $_FILES['additional_doc']['type'] = $_FILES['additional_file']['type'][$i];
                    $_FILES['additional_doc']['error'] = $_FILES['additional_file']['error'][$i];

                    if (!$this->upload->do_upload('additional_doc')) {
                        $upload_error = $this->upload->display_errors();
                        echo $upload_error . "--" . $i;
                    } else {
                        $upload_data = $this->upload->data();
                        $resume_path = $upload_data['file_name'];
                    }
                    unset($config);
                    $data['document'] = $resume_path;
                } else if ((isset($_POST['old_additional_file'][$i]) && $_POST['old_additional_file'][$i] != '') && $resume_path == '') {
                    $data['document'] = $_POST['old_additional_file'][$i];
                }

                $get_value = $this->Mdiligence->check_docExist('diligence_document', $innovation_id, $_POST['add_doc_type'][$i]);
                if (!empty($get_value)) {
                    $data['status'] = 1;
                    $update_data = $this->Mdiligence->update_data('diligence_document', $data, $innovation_id, '', $_POST['add_doc_type'][$i]);
                } else {
                    $insert_data = $this->Mdiligence->insert_data('diligence_document', $data);
                }
                $send_data = 1;
            }
        }

        if ($send_data == 1) {
            $this->session->set_userdata("document_sucmsg", 'Document saved successfully');
            redirect('application/diligence_documents/' . $inv_id);
        } else {
            $this->session->set_userdata("document_errmsg", 'Some information missing');
            redirect('application/diligence_documents/' . $inv_id);
        }
    }

    public function dd_document_type($inv_id, $doc_id, $desc, $f_name, $new_doc, $old_doc) {
        if ($doc_id != '' && $desc != '' && ($new_doc != '' || $old_doc != '')) {
            $data['innovation_id'] = $innovation_id = 'INV' . $inv_id;
            $data['doc_type'] = $doc_id;
            $data['description'] = $this->db->escape_str($desc);
            $data['added_by_id'] = $this->session->userdata['emp_number'];
            $data['added_by_name'] = $this->session->userdata['emp_name'];
            $data['created_at'] = date('Y-m-d H:i:s');

            $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/detailed_diligence';
            $resume_path = '';
            if ($new_doc["name"] != "") {
                $split_name = explode('.', $new_doc["name"]);
                $get_extension = array_pop($split_name);
                $get_name = implode('', $split_name);
                $this->load->library('upload');
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';

                $rename_file = str_replace(' ', '_', strtolower($get_name));
                $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
                $config['file_name'] = date('Ymdhis') . '_document_' . $new_name . '.' . $get_extension;
                $this->upload->initialize($config);

                if (!$this->upload->do_upload($f_name)) {
                    $upload_error = $this->upload->display_errors();
                    echo $upload_error;
                } else {
                    $upload_data = $this->upload->data();
                    $resume_path = $upload_data['file_name'];
                }
                unset($config);
                $data['document'] = $resume_path;
            } else if (isset($old_doc) && $resume_path == '') {
                $data['document'] = $old_doc;
            }

            $get_value = $this->Mdiligence->check_docExist('diligence_document', $innovation_id, $doc_id);
            if (!empty($get_value)) {
                $data['status'] = 1;
                $send_data = $this->Mdiligence->update_data('diligence_document', $data, $innovation_id, '', $doc_id);
            } else {
                $send_data = $this->Mdiligence->insert_data('diligence_document', $data);
            }
        }
    }

    public function diligence_meetings($id) {
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
        $data['isAssociate'] = $this->Mincharge->isAssociateUser($id, $this->session->userdata('emp_number'));
        $data['doc_type'] = $this->Mdiligence->get_data('diligence_document_types');
        $data['meeting_type'] = $this->Mdiligence->get_data('diligence_meeting_type');
        $data['meeting_list'] = $this->Mdiligence->get_meetingDoc($innovation['innovation_id']);

        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/diligence_meetings');
    }

    public function save_diligence_meeting() {
        $add_count = count($_POST['meet_type']);
        for ($i = 0; $i < $add_count; $i++) {
            if ($_POST['meet_type'][$i] != '') {
                $data['innovation_id'] = 'INV' . $_POST['inv_id'];
                $meeting_id = $_POST['meeting_id'][$i];
                $data['meeting_date'] = date('Y-m-d', strtotime($_POST['meet_date'][$i]));
                $data['meeting_type'] = $this->db->escape_str($_POST['meet_type'][$i]);
                $data['comments'] = $this->db->escape_str($_POST['meet_desc'][$i]);
                $data['added_by_id'] = $this->session->userdata['emp_number'];
                $data['added_by_name'] = $this->session->userdata['emp_name'];
                $data['added_on'] = date('Y-m-d H:i:s');

                $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/detailed_diligence';
                $resume_path = '';
                if ($_FILES["meet_doc"]["name"][$i] != "") {
                    $split_name = explode('.', $_FILES["meet_doc"]["name"][$i]);
                    $get_extension = array_pop($split_name);
                    $get_name = implode('', $split_name);
                    $this->load->library('upload');
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';

                    $rename_file = str_replace(' ', '_', strtolower($get_name));
                    $new_name = preg_replace('/[^A-Za-z0-9\_]/', '', $rename_file);
                    $config['file_name'] = date('Ymdhis') . '_meeting_' . $new_name . '.' . $get_extension;

                    $this->upload->initialize($config);
                    $_FILES['meeting_doc']['name'] = $_FILES['meet_doc']['name'][$i];
                    $_FILES['meeting_doc']['tmp_name'] = $_FILES['meet_doc']['tmp_name'][$i];
                    $_FILES['meeting_doc']['size'] = $_FILES['meet_doc']['size'][$i];
                    $_FILES['meeting_doc']['type'] = $_FILES['meet_doc']['type'][$i];
                    $_FILES['meeting_doc']['error'] = $_FILES['meet_doc']['error'][$i];

                    if (!$this->upload->do_upload('meeting_doc')) {
                        $upload_error = $this->upload->display_errors();
                        echo $upload_error . "--" . $i;
                    } else {
                        $upload_data = $this->upload->data();
                        $resume_path = $upload_data['file_name'];
                    }
                    unset($config);
                    $data['meeting_doc'] = $resume_path;
                } else if ((isset($_POST['old_meet_doc'][$i]) && $_POST['old_meet_doc'][$i] != '') && $resume_path == '') {
                    $data['meeting_doc'] = $_POST['old_meet_doc'][$i];
                }

                if ($meeting_id != '') {
                    $data['status'] = 1;
                    $send_data = $this->Mdiligence->update_meeting('diligence_meeting', $data, $meeting_id);
                } else {
                    $send_data = $this->Mdiligence->insert_data('diligence_meeting', $data);
                }
            }
        }
        if ($send_data) {
            $this->session->set_userdata("document_sucmsg", 'Meeting details saved successfully');
            redirect('application/diligence_meetings/' . $_POST['inv_id']);
        } else {
            $this->session->set_userdata("document_errmsg", 'Some information missing');
            redirect('application/diligence_meetings/' . $_POST['inv_id']);
        }
    }

    public function assessment_background($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_background');
    }

    public function assessment_situation($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_situation');
    }

    public function assessment_investment($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_investment');
    }

    public function assessment_thesis($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_thesis');
    }

    public function assessment_model($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_model');
    }

    public function assessment_strategy($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_strategy');
    }

    public function assessment_impact($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_impact');
    }

    public function assessment_sha($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_sha');
    }

    public function assessment_investors($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_investors');
    }

    public function assessment_options($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_options');
    }

    public function assessment_agreements($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_agreements');
    }

    public function assessment_drivers($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_drivers');
    }

    public function assessment_swot($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_swot');
    }

    public function assessment_terms($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_terms');
    }

    public function assessment_risks($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_risks');
    }

    public function assessment_timing($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_timing');
    }

    public function assessment_team($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_team');
    }

    public function assessment_decision($id) {
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

        $data['assign_to'] = $this->Minnovation->getAssignIncharge($innovation['id'], 1);
        $data['assign_incharge_id'] = $this->Mincharge->getAssociateId($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation'][0]['partner_id']);
        $data['application_id'] = $id;

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
            $data['eic_date'] = date('d-m-Y', strtotime($eic_app[0]['modified_date']));
        } else {
            $data['eic_date'] = '';
        }

        $this->load->vars($data);
        $this->load->view('application/detailed_diligence/assessment_decision');
    }

    public function add_detailed_assessment() {
        $form_name = $_POST['form_name'];
        $data['innovation_id'] = $inv_id = 'INV' . $_POST['innovation_id'];
        if (isset($_POST['description']) && $_POST['description'] != '') {
            $data['description'] = $desc['description'] = $this->db->escape_str($_POST['description']);
        }
        if (isset($_POST['current_situation']) && $_POST['current_situation'] != '') {
            $data['current_situation'] = $desc['current_situation'] = $this->db->escape_str($_POST['current_situation']);
        }
        if (isset($_POST['pre_money']) && $_POST['pre_money'] != '') {
            $data['pre_money'] = $desc['pre_money'] = $this->db->escape_str($_POST['pre_money']);
        }
        if (isset($_POST['investment']) && $_POST['investment'] != '') {
            $data['investment'] = $desc['investment'] = $this->db->escape_str($_POST['investment']);
        }
        if (isset($_POST['round_size']) && $_POST['round_size'] != '') {
            $data['round_size'] = $desc['round_size'] = $this->db->escape_str($_POST['round_size']);
        }
        if (isset($_POST['post_money']) && $_POST['post_money'] != '') {
            $data['post_money'] = $desc['post_money'] = $this->db->escape_str($_POST['post_money']);
        }
        if (isset($_POST['number_of_shares']) && $_POST['number_of_shares'] != '') {
            $data['number_of_shares'] = $desc['number_of_shares'] = $this->db->escape_str($_POST['number_of_shares']);
        }
        if (isset($_POST['cap_table']) && $_POST['cap_table'] != '') {
            $data['cap_table'] = $desc['cap_table'] = $this->db->escape_str($_POST['cap_table']);
        }
        if (isset($_POST['valuation_method']) && $_POST['valuation_method'] != '') {
            $data['valuation'] = $desc['valuation'] = $this->db->escape_str($_POST['valuation_method']);
        }
        if (isset($_POST['governance']) && $_POST['governance'] != '') {
            $data['governance'] = $desc['governance'] = $this->db->escape_str($_POST['governance']);
        }
        if (isset($_POST['team_like']) && $_POST['team_like'] != '') {
            $data['team_like'] = $desc['team_like'] = $this->db->escape_str($_POST['team_like']);
        }
        if (isset($_POST['solution_fit']) && $_POST['solution_fit'] != '') {
            $data['solution_fit'] = $desc['solution_fit'] = $this->db->escape_str($_POST['solution_fit']);
        }
        if (isset($_POST['market_fit']) && $_POST['market_fit'] != '') {
            $data['market_fit'] = $desc['market_fit'] = $this->db->escape_str($_POST['market_fit']);
        }
        if (isset($_POST['impact_potential']) && $_POST['impact_potential'] != '') {
            $data['impact_potential'] = $desc['impact_potential'] = $this->db->escape_str($_POST['impact_potential']);
        }
        if (isset($_POST['mandate_fit']) && $_POST['mandate_fit'] != '') {
            $data['mandate_fit'] = $desc['mandate_fit'] = $this->db->escape_str($_POST['mandate_fit']);
        }
        if (isset($_POST['proposed_funding']) && $_POST['proposed_funding'] != '') {
            $data['proposed_funding'] = $desc['proposed_funding'] = $this->db->escape_str($_POST['proposed_funding']);
        }
        if (isset($_POST['return_expectations']) && $_POST['return_expectations'] != '') {
            $data['return_expectations'] = $desc['return_expectations'] = $this->db->escape_str($_POST['return_expectations']);
        }
        if (isset($_POST['downstream']) && $_POST['downstream'] != '') {
            $data['downstream'] = $desc['downstream'] = $this->db->escape_str($_POST['downstream']);
        }
        if (isset($_POST['pain_points']) && $_POST['pain_points'] != '') {
            $data['pain_points'] = $desc['pain_points'] = $this->db->escape_str($_POST['pain_points']);
        }
        if (isset($_POST['value_proposition']) && $_POST['value_proposition'] != '') {
            $data['value_proposition'] = $desc['value_proposition'] = $this->db->escape_str($_POST['value_proposition']);
        }
        if (isset($_POST['customer_segment']) && $_POST['customer_segment'] != '') {
            $data['customer_segment'] = $desc['customer_segment'] = $this->db->escape_str($_POST['customer_segment']);
        }
        if (isset($_POST['product_portfolio']) && $_POST['product_portfolio'] != '') {
            $data['product_portfolio'] = $desc['product_portfolio'] = $this->db->escape_str($_POST['product_portfolio']);
        }
        if (isset($_POST['customer_channels']) && $_POST['customer_channels'] != '') {
            $data['customer_channels'] = $desc['customer_channels'] = $this->db->escape_str($_POST['customer_channels']);
        }
        if (isset($_POST['revenue_model']) && $_POST['revenue_model'] != '') {
            $data['revenue_model'] = $desc['revenue_model'] = $this->db->escape_str($_POST['revenue_model']);
        }
        if (isset($_POST['key_risks']) && $_POST['key_risks'] != '') {
            $data['key_risks'] = $desc['key_risks'] = $this->db->escape_str($_POST['key_risks']);
        }
        if (isset($_POST['entry_point']) && $_POST['entry_point'] != '') {
            $data['entry_point'] = $desc['entry_point'] = $this->db->escape_str($_POST['entry_point']);
        }
        if (isset($_POST['market_sizing']) && $_POST['market_sizing'] != '') {
            $data['market_sizing'] = $desc['market_sizing'] = $this->db->escape_str($_POST['market_sizing']);
        }
        if (isset($_POST['company_grow']) && $_POST['company_grow'] != '') {
            $data['company_grow'] = $desc['company_grow'] = $this->db->escape_str($_POST['company_grow']);
        }
        if (isset($_POST['lever_deployed']) && $_POST['lever_deployed'] != '') {
            $data['lever_deployed'] = $desc['lever_deployed'] = $this->db->escape_str($_POST['lever_deployed']);
        }
        if (isset($_POST['exit_point']) && $_POST['exit_point'] != '') {
            $data['exit_point'] = $desc['exit_point'] = $this->db->escape_str($_POST['exit_point']);
        }
        if (isset($_POST['problem']) && $_POST['problem'] != '') {
            $data['problem'] = $desc['problem'] = $this->db->escape_str($_POST['problem']);
        }
        if (isset($_POST['theory_change']) && $_POST['theory_change'] != '') {
            $data['theory_of_change'] = $desc['theory_of_change'] = $this->db->escape_str($_POST['theory_change']);
        }
        if (isset($_POST['current_impact']) && $_POST['current_impact'] != '') {
            $data['current_impact'] = $desc['current_impact'] = $this->db->escape_str($_POST['current_impact']);
        }
        if (isset($_POST['target_impact']) && $_POST['target_impact'] != '') {
            $data['target_impact'] = $desc['target_impact'] = $this->db->escape_str($_POST['target_impact']);
        }
        if (isset($_POST['social_impact']) && $_POST['social_impact'] != '') {
            $data['social_impact'] = $desc['social_impact'] = $this->db->escape_str($_POST['social_impact']);
        }
        if (isset($_POST['discuss_options']) && $_POST['discuss_options'] != '') {
            $data['discuss_options'] = $desc['discuss_options'] = $this->db->escape_str($_POST['discuss_options']);
        }
        if (isset($_POST['structure_terms']) && $_POST['structure_terms'] != '') {
            $data['structure_terms_agreed'] = $desc['structure_terms_agreed'] = $this->db->escape_str($_POST['structure_terms']);
        }
        if (isset($_POST['exit_options']) && $_POST['exit_options'] != '') {
            $data['exit_options'] = $desc['exit_options'] = $this->db->escape_str($_POST['exit_options']);
        }
        if (isset($_POST['other_key']) && $_POST['other_key'] != '') {
            $data['other_key_agreements'] = $desc['other_key_agreements'] = $this->db->escape_str($_POST['other_key']);
        }
        if (isset($_POST['sector_summary']) && $_POST['sector_summary'] != '') {
            $data['sector_summary'] = $desc['sector_summary'] = $this->db->escape_str($_POST['sector_summary']);
        }
        if (isset($_POST['swot']) && $_POST['swot'] != '') {
            $data['swot'] = $desc['swot'] = $this->db->escape_str($_POST['swot']);
        }
        if (isset($_POST['key_transaction']) && $_POST['key_transaction'] != '') {
            $data['key_transaction'] = $desc['key_transaction'] = $this->db->escape_str($_POST['key_transaction']);
        }
        if (isset($_POST['risks_mitigations']) && $_POST['risks_mitigations'] != '') {
            $data['risks_mitigations'] = $desc['risks_mitigations'] = $this->db->escape_str($_POST['risks_mitigations']);
        }
        if (isset($_POST['tranche_suggestions']) && $_POST['tranche_suggestions'] != '') {
            $data['tranche_suggestions'] = $desc['tranche_suggestions'] = $this->db->escape_str($_POST['tranche_suggestions']);
        }
        if (isset($_POST['villgro_team']) && $_POST['villgro_team'] != '') {
            $data['villgro_team'] = $desc['villgro_team'] = $this->db->escape_str($_POST['villgro_team']);
        }
        if (isset($_POST['ic_inputs']) && $_POST['ic_inputs'] != '') {
            $data['ic_inputs'] = $desc['ic_inputs'] = $this->db->escape_str($_POST['ic_inputs']);
        }
        if (isset($_POST['thoughts_opportunities']) && $_POST['thoughts_opportunities'] != '') {
            $data['thoughts_opportunities'] = $desc['thoughts_opportunities'] = $this->db->escape_str($_POST['thoughts_opportunities']);
        }

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
				if(!empty($desc)){
					foreach ($data as $key => $value) {
						$update[$key] = $value;
						$updateData = $this->Mdiligence->update_detailed_assessment('detailed_diligence', $update, $sendData);
						$update = array();
					}
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
			if(!empty($desc)){
				foreach ($data as $key => $value) {
					$update[$key] = $value;
					$updateData = $this->Mdiligence->update_detailed_assessment('detailed_diligence', $update, $sendData);
					$update = array();
				}
			}
            $txtmsg = 'saved as new version';
        }

        if ($sendData) {
            $this->session->set_userdata("detail_sucmsg", 'Detailed assessment successfully ' . $txtmsg);
            redirect('application/' . $form_name . '/' . $_POST['innovation_id']);
        }
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
        if ($program_name == '3' || $program_name == '5' || $program_name == '6') {
            $pitch_user = $this->Minnovation->get_pitch('pitch_user', $id);
            $pitch_sector = $this->Minnovation->get_pitch('pitch_step2', $pitch_user[0]['pitch_id']);
            $team_members = $this->Minnovation->get_pitch('pitch_step1_members', $pitch_user[0]['pitch_id']);
            $sub_sector_title = 'Sub Sector';
            $get_sector_name = $this->Minnovation->getSectorNamePitch($pitch_sector[0]['sub_sector']);
            $sub_sector_name = isset($get_sector_name[0]['sector']) ? $get_sector_name[0]['sector'] : '';
        } else if ($program_name == '0') {
            $inv_details = $this->Minnovation->get_innovation('inv_user', "INV" . $innovation[0]['id']);
            $team_members = $this->Minnovation->get_innovation('inv_member', $inv_details[0]['id']);
            $sub_sector_title = 'Sub Sector';
            $subsec_name = $this->Minnovation->getSectorNamePitch($inv_details[0]['sub_sector']);
            $sub_sector_name = isset($subsec_name[0]['sector']) ? $subsec_name[0]['sector'] : '';
        }

        $data['stage'] = $stage = $this->Minnovation->getInnvationStage();
        $data['status'] = $status = $this->Minnovation->getInnvationStatus();
        $app_stage = $stage[$innovation[0]['stage']];
        $app_status = $status[$innovation[0]['status']];

//        $assign_to = $this->Minnovation->getAssignIncharge($innovation[0]['id'], 2);
        $src_logo = 'logo.png';

        if ($program_name == '1') {
            $app_name = 'EIR';
        } else if ($program_name == '2') {
            $app_name = 'SEED';
        } else if ($program_name == '3') {
            $app_name = 'Unc Pitch';
        } else if ($program_name == '5') {
            $app_name = 'FPAI Challenge Application';
        } else if ($program_name == '6') {
            $app_name = 'UBS Challenge Application';
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
        $member_count = count($team_members);
        $share_count = count($share_details);
        $styleCell = array('borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', 'space' => array('before' => 360, 'after' => 280), 'indentation' => array('left' => 540, 'right' => 120));
        $styleRightCell = array('borderLeftSize' => 1, 'borderLeftColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', 'space' => array('before' => 360, 'after' => 280), 'indentation' => array('left' => 540, 'right' => 120));

        $headCell = array('borderRightSize' => 1, 'borderRightColor' => 'black', 'borderBottomSize' => 1, 'borderBottomColor' => 'black', 'bgColor' => 'E2E2E2');
        $teamCell = array('borderRightSize' => 1, 'borderRightColor' => 'black', 'space' => array('before' => 360, 'after' => 280), 'indentation' => array('left' => 540, 'right' => 120));

        $fontStyle = array('size' => 13, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0);
        $TfontStyle = array('bold' => true, 'size' => 13, 'name' => 'Times New Roman', 'afterSpacing' => 0, 'Spacing' => 0, 'cellMargin' => 0);

        $noSpace = array('textBottomSpacing' => -1);

        $title = 'Detailed Assessment - ' . ucfirst($innovation[0]['name_of_enterprise']) . ' - Version ' . $get_records[0]['version'];
//        $section->addText($title, ['size' => 16], ['align' => \PhpOffice\PhpWord\Style\Alignment::ALIGN_CENTER]);
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

        if ($program_name == '3' || $program_name == '5' || $program_name == '6') {
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

    public function assign_incharge($id = '') {
        $data['application_id'] = $id;
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $data['assigned_incharge'] = $this->Mincharge->getAssociateId($id);

        $this->load->vars($data);
        $this->load->view('application/options/assign_incharge');
    }

    public function load_assign_incharge() {
        $data = array();
        $branch = $this->input->post('branch');
        $inv_id = $this->input->post('inv_id');
        $this->load->model('incubation_master/Common_model');
        #$getAllUsers = $this->Mapplication->getAllUsers($branch);
        $getAssignedUsers = $this->Mapplication->getUserSetup($inv_id);
		
		$userSetup = $this->Mmaster->getUserSetup();
		$getAllUsers = $this->Muser->getUsersList($userSetup['abi']);
		
        foreach ($getAssignedUsers as $row) {
            array_push($data, $row['associate_employee']);
        }
        $user_data['assign_user'] = $data;

        $defaultval = array();
        if (!empty($user_data)) {
            $defaultval = $user_data;
        }
        echo json_encode(array('all_users' => $getAllUsers, 'ext_user' => $defaultval));
    }

    public function update_assignUser() {
        $data = array();
        $cond['innovation'] = $_POST['inv_id'];
        $status['status'] = 0;
        $update_assign = $this->Mapplication->updateDetails('assign_associate', $status, $cond);
        for ($i = 0; $i < count($_POST['select_assign']); $i++) {
            if ($_POST['select_assign'][$i] != '') {
                $data['innovation'] = $option['innovation'] = $_POST['inv_id'];
                $data['associate_employee'] = $option['associate_employee'] = $_POST['select_assign'][$i];
                $data['status'] = '1';
                $checkExist = $this->Mportfolio->getDetails('assign_associate', $option);
                if (count($checkExist) > 0 && $checkExist[0]['status'] == 0) {
                    $data['modified_by'] = $this->session->userdata('emp_number');
                    $query = $this->Mportfolio->updatePortfolioDetail('assign_associate', $data, $option);
                } else {
                    $data['created_by'] = $this->session->userdata('emp_number');
                    $data['created_date'] = date("Y-m-d H:i:s");
                    $query = $this->Mportfolio->insertPortfolioDetail('assign_associate', $data);
                }
            }
        }
        if ($query) {
            $this->session->set_flashdata('successMsg', "Assign incharge saved successfully");
        } else {
            $this->session->set_flashdata('errormsg', 'Value Missing');
        }
        redirect('application/assign_incharge/' . $_POST['inv_id']);
    }

    public function close_application($id = '') {
        $data['application_id'] = $id;
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $data['innovation']['partner_id']);
        $data['assigned_incharge'] = $this->Mincharge->getAssociateId($id);

        $this->load->vars($data);
        $this->load->view('application/options/close_application');
    }

    public function updateCloseAction() {
        $inv_id = $_POST['inv_id'];
        $data['innovation'] = $this->Minnovation->getInnovation($inv_id);
        $status = $_POST['status'];
        $user_data = array(
            'close_status' => $data['innovation']['status'],
            'reopen_status' => '0'
        );
        $user_where = array('id' => $inv_id);
        $table = "innovation_pool";
        $this->Minnovation->pitch_update($table, $user_data, $user_where);

        $ids = $data['innovation']['id'];
        $employees = $this->Sector_model->getEmpId($ids);

        $emp_Ids = array_map(function ($emp_Ids) {
            return $emp_Ids['associate_employee'];
        }, $employees);
        $employees_id = rtrim(implode(',', $emp_Ids), ',');

        $log_data = array(
            'innovation_id' => $data['innovation']['id'],
            'stage' => $data['innovation']['stage'],
            'status' => $status,
            'assigned_user' => $employees_id,
            'modified_by' => $this->session->userdata['emp_number'],
            'modified_date' => date('Y-m-d H:i:s')
        );

        $table_log = "application_status_log";
        $result = $this->Minnovation->pitch_insert($table_log, $log_data);

        $this->Minnovation->updateComments($inv_id, $_POST, $status);
        $this->Minnovation->changeStatus($inv_id, $status);

        $this->session->set_flashdata('successMsg', 'Status changed successfully!');
        redirect('application/reopen/' . $inv_id);
    }

    public function reopen($id = '') {
        $data['application_id'] = $id;
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Resume Reasons');
        $data['assigned_incharge'] = $this->Mincharge->getAssociateId($id);

        $this->load->vars($data);
        $this->load->view('application/options/reopen');
    }

    public function reopen_action() {
        $inv_id = $_POST['inv_id'];
        $get_table = "grading_feedback";
        $data['innovation'] = $this->Minnovation->getInnovation($inv_id);
        $feedback = $this->Minnovation->get_innovation($get_table, $inv_id);
        if ($feedback[0]['result'] == 'Reject') {
            $feed_where = array('innovation_id' => $inv_id);
            $feed_data = array(
                'feed_back' => '',
                'result' => '',
                'reject_reason' => ''
            );
            $this->Minnovation->pitch_update($get_table, $feed_data, $feed_where);
        }

        if ($data['innovation']['close_status'] != '' && $data['innovation']['close_status'] != '3') {
            $status = $data['innovation']['close_status'];
        } else {
            $status = '12';
        }

        $reason = 'Resume Reasons';
        $user_data = array(
            'reopen_status' => '1'
        );
        $user_where = array('id' => $inv_id);
        $table = "innovation_pool";
        $this->Minnovation->pitch_update($table, $user_data, $user_where);

        $ids = $data['innovation']['id'];
        $employees = $this->Sector_model->getEmpId($ids);

        $emp_Ids = array_map(function ($emp_Ids) {
            return $emp_Ids['associate_employee'];
        }, $employees);
        $employees_id = rtrim(implode(',', $emp_Ids), ',');

        $log_data = array(
            'innovation_id' => $data['innovation']['id'],
            'stage' => $data['innovation']['stage'],
            'status' => '19',
            'assigned_user' => $employees_id,
            'modified_by' => $this->session->userdata['emp_number'],
            'modified_date' => date('Y-m-d H:i:s')
        );

        $table_log = "application_status_log";
        $result = $this->Minnovation->pitch_insert($table_log, $log_data);

        $this->Minnovation->updateComments($inv_id, $_POST, $status);
        $this->Minnovation->changeStatus($inv_id, $status);

        $this->session->set_flashdata('successMsg', 'Successfully reopened the application!');
        redirect('application/close_application/' . $inv_id);
    }

}

?>