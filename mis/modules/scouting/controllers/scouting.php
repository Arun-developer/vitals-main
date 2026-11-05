<?php

class Scouting extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Calcutta");
        $this->Mauth->isLoggedCheck();
        $this->hris = $this->load->database('hris', TRUE);
        $this->load->model('master/Sector_model');
        $this->load->model('master/Mmaster_settings');
        $this->load->model('Minnovation');
        $this->load->model('Memail');
        $this->load->model('Mincharge');
        $this->load->model('Eirmodel');
        $this->load->model('login/Muser');
        $this->load->helper(array('file', 'download'));
    }

    function eir_action() {
        $eir_action = $this->input->post('action');
        $id = $this->input->post('id');
        if ($this->input->post('action_date') != '') {
            $set_date = $this->input->post('action_date') . ' ' . date('H:i:s');
        } else {
            $set_date = date('Y-m-d H:i:s');
        }

        $data['innovation'] = $this->Minnovation->getInnovation($id);

        if ($eir_action == '2') {
            $status = '17';
        } else if ($eir_action == '3') {
            $this->session->set_userdata('close_action', 'yes');
            $status = '18';
        } else {
            $status = '20';
        }

        $user_data = array(
            'status' => $status,
            'stage' => '9'
        );
        $user_where = array('id' => $id);
        $table = "innovation_pool";
        $this->Minnovation->pitch_update($table, $user_data, $user_where);

        $employees = $this->Sector_model->getEmpId($id);
        $emp_Ids = php72_array_map(function ($emp_Ids) {
            return $emp_Ids['associate_employee'];
        }, $employees);
        $employees_id = rtrim(implode(',', $emp_Ids), ',');

        $log_data = array(
            'innovation_id' => $data['innovation']['id'],
            'stage' => $data['innovation']['stage'],
            'status' => $status,
            'assigned_user' => $employees_id,
            'modified_by' => $this->session->userdata['emp_number'],
            'modified_date' => date('Y-m-d H:i:s', strtotime($set_date))
        );

        $table_log = "application_status_log";
        $result = $this->Minnovation->pitch_insert($table_log, $log_data);
    }

    /* CREATE NEW INNOVATION AND EDIT INNOVATION
    int $id IS INNOVATION ID */

    function copy_innovation() {
        $data['copyinnovationList'] = $this->Minnovation->getcopyRecords($_POST['newpartner'], $_POST['branchname1'], $_POST['comment']);
        redirect('scouting/innovation_pool/all');
    }

    function check_mail_exists() {
        $mail = $this->input->post('mailid');
        $inv = $this->input->post('invId');
        if ($mail != '') {
            $mailIdCount = $this->Minnovation->checkmailExists($mail, $inv);
        } else {
            $mailIdCount = 0;
        }
        echo $mailIdCount;
    }

    function check_pitch_mail_exists() {
        $mail = $this->input->post('mailid');
        $inv = $this->input->post('invId');
        if ($mail != '') {
            $mailIdCount = $this->Minnovation->checkmailPitchExists($mail, $inv);
        } else {
            $mailIdCount = 0;
        }
        echo $mailIdCount;
    }

    function dealsScoreboard() {

        $data['getdealsScoreboard'] = $this->Minnovation->getdealsScoreboard();

        $data['cpagetitle'] = "Deals Scoreboard";
        $data['cpage'] = "dealsScoreboard";
        $this->load->vars($data);
        $this->load->view('../template');
    }

    function new_innovation($id = NULL) {
        checkAuth();
        $data['upload_error'] = array();

        if ($this->input->post('eirSubmit') != '') {
            $data = array(
                'name_of_entrepreneur' => $this->input->post('applicant'),
                'phone_no' => $this->input->post('phone_no'),
                'mobile_no' => $this->input->post('mobile_no'),
                'email_id' => $this->input->post('email1'),
                'name_of_enterprise' => $this->input->post('organisation'),
                'stage' => '0',
                'status' => '0',
                'program' => '1',
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('emp_number'),
            );
            $inv_id = $this->Minnovation->insert_pool($data);

//get innovationid
            $data1 = array(
                'name_of_organisation' => $this->input->post('organisation'),
                'name_of_applicant' => $this->input->post('applicant'),
                'email_id' => $this->input->post('email1'),
                'mobile_no' => $this->input->post('mobile_no'),
                'address' => $this->input->post('address'),
                'state' => $this->input->post('state'),
                'city' => $this->input->post('city'),
                'alt_phone_no' => $this->input->post('phone_no'),
                'innovation_no' => $inv_id,
                'date_created' => date('Y-m-d H:i:s'),
                'date_submitted' => date('Y-m-d H:i:s'),
                'date_modified' => '',
                'status' => 'completed'
            );
            $app_id = $this->Minnovation->insert_eir_user($data1);

//get app_id
            $data2 = array(
                'app_id' => $app_id,
                'skills' => $this->input->post('skills'),
                'describtion_of_idea' => $this->input->post('describtion'),
                'innovative_element' => $this->input->post('innovative_element'),
                'social_benefit' => $this->input->post('social_benefit'),
                'pilots_of_idea' => $this->input->post('pilots'),
                'expectation_from_EIR' => $this->input->post('expectation'),
                'funding' => $this->input->post('funding'),
                'funding_detail' => $this->input->post('fund_detail'),
                'enterprise_setup' => $this->input->post('setup'),
                'setup_detail' => $this->input->post('setup_detail'),
                'for_profit' => $this->input->post('profit'),
                'program_time' => $this->input->post('program_time'),
                'know_about' => $this->input->post('know_about')
            );

            $this->Minnovation->insert_eir_app($data2);
//files
            $upload_path = "./uploads/EIR_resume/";

            $data_file1 = array();
            $this->load->library('upload');
            for ($i = 0; $i < 3; $i++) {
                if ($_FILES["resume"]["name"][$i] != "") {
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'doc|docx|pdf';
                    $file_name = explode('.', $_FILES["resume"]["name"][$i]);
                    $config['file_name'] = str_replace(' ', '_', $file_name[0] . '-' . $_POST['name'][$i] . '.' . $file_name[1]);

                    $this->upload->initialize($config);

                    $_FILES['resume_single']['name'] = $_FILES['resume']['name'][$i];
                    $_FILES['resume_single']['tmp_name'] = $_FILES['resume']['tmp_name'][$i];
                    $_FILES['resume_single']['size'] = $_FILES['resume']['size'][$i];
                    $_FILES['resume_single']['type'] = $_FILES['resume']['type'][$i];
                    $_FILES['resume_single']['error'] = $_FILES['resume']['error'][$i];

                    if (!$this->upload->do_upload('resume_single')) {
                        $upload_error = $this->upload->display_errors();
                        echo $upload_error . "--" . $i;
                    } else {
                        $upload_data = $this->upload->data();
                        $resume_path[$i] = $upload_data['file_name'];
                    }
                    unset($config);

                    $data_file1[] = base_url() . 'uploads/EIR_resume/' . $resume_path[$i];
                }
            }

            $resume = implode("|", $data_file1);

//applicant
            for ($i = 0; $i < 3; $i++) {
                if ($_POST['name'][$i] != "" && $_POST['org'][$i] != "" && $_POST['title'][$i] != "" && $_POST['email'][$i] != "" && $_POST['mobile'][$i] != "") {
                    $data4 = array(
                        'app_id' => $app_id,
                        'name' => $_POST['name'][$i],
                        'current_organisation' => $_POST['org'][$i],
                        'current_title' => $_POST['title'][$i],
                        'email_id' => $_POST['email'][$i],
                        'mobile_no' => $_POST['mobile'][$i],
                    );
                    $this->Minnovation->insert_eir_team($data4);
                }
            }

            $data_file2 = array();
            for ($i = 0; $i < 2; $i++) {
                if ($_FILES["additional"]["name"][$i] != "") {
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'doc|docx|pdf|txt';
                    $file_name = explode('.', $_FILES["additional"]["name"][$i]);
                    $config['file_name'] = str_replace(' ', '_', $file_name[0] . '.' . $file_name[1]);

                    $this->upload->initialize($config);

                    $_FILES['additional_single']['name'] = $_FILES['additional']['name'][$i];
                    $_FILES['additional_single']['tmp_name'] = $_FILES['additional']['tmp_name'][$i];
                    $_FILES['additional_single']['size'] = $_FILES['additional']['size'][$i];
                    $_FILES['additional_single']['type'] = $_FILES['additional']['type'][$i];
                    $_FILES['additional_single']['error'] = $_FILES['additional']['error'][$i];

                    if (!$this->upload->do_upload('additional_single')) {
                        $upload_error = $this->upload->display_errors();
                    } else {
                        $upload_data = $this->upload->data();
                        $additional_path[$i] = $upload_data['file_name'];
                    }
                    unset($config);

                    $data_file2[] = base_url() . 'uploads/EIR_resume/' . $additional_path[$i];
                }
            }
            $doc = implode("|", $data_file2);
            $result = $this->Minnovation->insert_eir_file($app_id, $resume, $doc);
            $this->session->set_flashdata('successMsg', 'Innovation details added successfully');
            redirect('scouting/new_innovation');
        }

/////////////////////////////// SEED Program Insert process//////////////////////////////////////////
        if ($this->input->post('seedSubmit') != '') {

///////////////// innovation array and insert process////////////////////

            $inno = array(
                'name_of_entrepreneur' => $this->input->post('first_name'),
                'phone_no' => $this->input->post('ph_num'),
                'mobile_no' => $this->input->post('ph_num'),
                'email_id' => $this->input->post('email_id'),
                'name_of_enterprise' => $this->input->post('venture'),
                'stage' => '0',
                'status' => '0',
                'program' => '2',
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('emp_number')
            );
            $table = "innovation_pool";
            $inn_id = $this->Minnovation->insert_seed($table, $inno);

///////////////// innovation inser process ends ////////////////////////
//////////////// seed form  insert process //////////////////////////////
            $seed_user = array(
                'mode_insert' => 'MIS',
                'status' => 'completed'
            );
            $table = "seed_user";
            $sapp_id = $this->Minnovation->insert_seed($table, $seed_user);


            $oper_count = php72_count($_POST['operate']);

            $sector = php72_implode(',', $_POST['operate']);

            $sector = ($_POST['operate_other'] != '') ? $sector . ',' . $_POST['operate_other'] : $sector;

            $state = $this->Eirmodel->get_city_state($this->input->post('city_seed'), 'state');

            $city = $this->Eirmodel->get_city_state($this->input->post('city_seed'), 'city');


            $seed_1 = array(
                'app_id' => $sapp_id,
                'inno_id' => $inn_id,
                'firstname' => $this->input->post('first_name'),
                'email' => $this->input->post('email_id'),
                'phone' => $this->input->post('ph_num'),
                'hear_seed' => $this->input->post('hear_abt'),
                'citizenship' => $this->input->post('citizen_ship'),
                'commit_fulltime' => $this->input->post('full_time'),
                'name_venture' => $this->input->post('venture'),
                'org_incorp' => $this->input->post('profit_entity'),
                'website' => $this->input->post('website'),
                'postal_add' => $this->input->post('address'),
                'org_state' => $state,
                'org_city' => $city,
                'regions_ope' => $this->input->post('region_oper'),
                'nom_ope' => $this->input->post('month_oper'),
                'sector' => $sector,
                'funding_summary' => $this->input->post('past_invest')
            );

            $table = "seed_step1";


            $step_id = $this->Minnovation->insert_seed($table, $seed_1);

//////////////// seed form insert process ends /////////////////////////
//////////////// seed form member insert process ///////////////////////
            $this->load->library('upload');
            for ($i = 1; $i <= 5; $i++) {
                $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/seedForm/memberuploads/';

                $resume_path[$i] = '';
                if ($_FILES["seed_res"]["name"][$i] != "") {
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'doc|docx|pdf';
                    $file_name = explode('.', $_FILES["seed_res"]["name"][$i]);
                    $config['file_name'] = str_replace(' ', '_', $file_name[0] . '-' . $_POST['seed_name'][$i] . '.' . $file_name[1]);

                    $this->upload->initialize($config);

                    $_FILES['resume_single']['name'] = $_FILES['seed_res']['name'][$i];
                    $_FILES['resume_single']['tmp_name'] = $_FILES['seed_res']['tmp_name'][$i];
                    $_FILES['resume_single']['size'] = $_FILES['seed_res']['size'][$i];
                    $_FILES['resume_single']['type'] = $_FILES['seed_res']['type'][$i];
                    $_FILES['resume_single']['error'] = $_FILES['seed_res']['error'][$i];

                    if (!$this->upload->do_upload('resume_single')) {
                        $upload_error = $this->upload->display_errors();
                        echo $upload_error . "--" . $i;
                    } else {
                        $upload_data = $this->upload->data();
                        $resume_path[$i] = $upload_data['file_name'];
                    }
                    unset($config);
                }


                if ($_POST['seed_name'][$i] != '' || $_POST['seed_email'][$i] != '' || $_POST['seed_mob'][$i] != '' || $_FILES['seed_res']['name'][$i] != '' || isset($_POST['ftm'][$i])) {
                    $check = isset($_POST['ftm'][$i]) ? 1 : 0;
                    $seed_member = array(
                        'app_id' => $sapp_id,
                        'step2_id' => $step_id,
                        's2_name' => $_POST['seed_name'][$i],
                        's2_email' => $_POST['seed_email'][$i],
                        's2_phone' => $_POST['seed_mob'][$i],
                        's2_resume' => $resume_path[$i],
                        's2_check' => $check,
                        'member_no' => $i
                    );

                    $table = "seed_step1_member";
                    $this->Minnovation->insert_seed($table, $seed_member);
                }
            }

//////////////// seed form member insert process ends //////////////////
/////////////// seed form step two insert process //////////////////////
            $seed_2 = array(
                'app_id' => $sapp_id,
                'inspire_start' => $this->input->post('inspiration'),
                'seed_value' => $this->input->post('expect_seed'),
                'product_service' => $this->input->post('product'),
                'need_service' => $this->input->post('product_need'),
                'solution_inno' => $this->input->post('innovative_solution'),
                'social_impact' => $this->input->post('social_impact'),
                'measure_impact' => $this->input->post('measure_impact')
            );
            $table = "seed_step2";
            $this->Minnovation->insert_seed($table, $seed_2);

/////////////// seed form step two insert process ends /////////////////
/////////////// seed form step three insert process //////////////////////

            $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/seedForm/businessdocs/';
            $resume_path = '';
            if ($_FILES["business_plan"]["name"] != "") {
                $this->load->library('upload');
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx';
                $file_name = explode('.', $_FILES["business_plan"]["name"]);
                $config['file_name'] = str_replace(' ', '_', $file_name[0] . '-' . $_POST['first_name'] . '.' . $file_name[1]);

                $this->upload->initialize($config);

                $_FILES['business']['name'] = $_FILES['business_plan']['name'];
                $_FILES['business']['tmp_name'] = $_FILES['business_plan']['tmp_name'];
                $_FILES['business']['size'] = $_FILES['business_plan']['size'];
                $_FILES['business']['type'] = $_FILES['business_plan']['type'];
                $_FILES['business']['error'] = $_FILES['business_plan']['error'];

                if (!$this->upload->do_upload('business')) {
                    $upload_error = $this->upload->display_errors();
                    echo $upload_error;
                } else {
                    $upload_data = $this->upload->data();
                    $resume_path = $upload_data['file_name'];
                }
                unset($config);
            }

            $seed_3 = array(
                'app_id' => $sapp_id,
                'ques1' => $this->input->post('market_estimate'),
                'ques2' => $this->input->post('pilots_venture'),
                'ques3' => $this->input->post('launch_learn'),
                'ques4' => $this->input->post('customer'),
                'business_plan' => $resume_path,
                'ques5' => $this->input->post('steps_to_goal')
            );
            $table = "seed_step3";
            $this->Minnovation->insert_seed($table, $seed_3);

/////////////// seed form step three insert process ends /////////////////
///////////////////////// SEED APP mail process /////////////////////////
            $this->load->model('common/Minnovation_mail');
            $this->Minnovation_mail->SEED_innovation($inn_id);
///////////////////////// SEED APP mail process ends ////////////////////

            $this->session->set_flashdata('successMsg', 'Innovation details added successfully');
            redirect('scouting/new_innovation');
        }
/////////////////////////////// SEED Program Insert Process ends ////////////////////////////////////
////////////////////////////////Pitch Form Insertion Process//////////////////////////

        if ($this->input->post('pitchSubmit') != '') {
/////////////////////////////// Innovation table insert ///////////////////////////////////
            $partneriddeal = $this->input->post('branch');
            $innovationpartnerid = str_pad($partneriddeal, 2, "0", STR_PAD_LEFT);
            $partnerdeal1 = $this->session->userdata('partner_id');
            $innovationpartnerid1 = str_pad($partnerdeal1, 2, "0", STR_PAD_LEFT);

            $h_city = $this->input->post('city');
            $o_city = $this->input->post('othercity');
            $getother_city = isset($h_city) && $h_city == 'Others' ? $o_city : '';

            $innovation_data = array(
                'name_of_entrepreneur' => $this->input->post('app_name'),
                'name_of_enterprise' => $this->input->post('org_name'),
                'email_id' => $this->input->post('email'),
                'mobile_no' => $this->input->post('mobile'),
                'phone_no' => $this->input->post('alt_ph'),
                'city' => $this->input->post('city'),
                'sector' => $this->input->post('sector'),
                'summary_of_business' => $this->input->post('bus_summary'),
                'status' => '12',
                'stage' => '7',
                'source' => '-1',
                'program' => '3',
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('emp_number'),
                'partner_id' => ($this->session->userdata('user_type') == 'superadmin') ? $innovationpartnerid : $innovationpartnerid1
            );

            $table = "innovation_pool";
            $in_id = $this->Minnovation->pitch_insert($table, $innovation_data);
//////////////////////////// Innovation table insert ends /////////////////////////////////////
////////////////////// Pitch user insert/////////////////////

            $user_data = array(
                'inno_id' => 'INV' . $in_id,
                'org_name' => $this->input->post('org_name'),
                'app_name' => $this->input->post('app_name'),
                'email' => $this->input->post('email'),
                'mobileno' => $this->input->post('mobile'),
                'altmobileno' => $this->input->post('alt_ph'),
                'city' => $this->input->post('city'),
                'other_city' => $getother_city,
                'status_pitch' => 'completed',
                'reg_date' => date('Y-m-d H:i:s'),
                'submitted_date' => date('Y-m-d')
            );

            $table = "pitch_user";
            $pitch_id = $this->Minnovation->pitch_insert($table, $user_data);

///////////////////// Pitch user update ends //////////////////
//////////////////// Pitch member update /////////////////////

            $mem_count = php72_count($_POST['pitch_name']);
            for ($i = 1; $i <= $mem_count; $i++) {

                $member_data = array(
                    'name' => $_POST['pitch_name'][$i],
                    'email' => $_POST['pitch_email'][$i],
                    'phone' => $_POST['pitch_mob'][$i],
                    'gender' => !empty($_POST['pitch_gender'][$i]) ? $_POST['pitch_gender'][$i] : '',
                    'pitch_id' => $pitch_id
                );

                $table = "pitch_step1_members";
                $result = $this->Minnovation->pitch_insert($table, $member_data);
            }

            $user_data = array(
                'ent_type' => $this->input->post('ent_type'),
                'type_prod' => $this->input->post('type_prod'),
                'invention_based' => $this->input->post('invention_based'),
                'pitch_id' => $pitch_id
            );

            $table = "pitch_step1_info";
            $this->Minnovation->pitch_insert($table, $user_data);

/////////////////// Pitch member update ends ////////////////////
////////////////// Pitch Org info update ///////////////////////

            $sector_other = '';
            if (php72_in_array('others', $this->input->post('sector')) || $this->input->post('sector') == 'others') {
                $sector_other = $this->input->post('sector_other');
            }
            $fund_from = '';
            if ($this->input->post('pitch_fund_raise') != 'no') {
                $fund_from = $this->input->post('pitch_fund_from');
            }

            $abt_vill = php72_implode(',', $this->input->post('abt_vill'));
            $get_sector = $this->Sector_model->getSectorCategory($this->input->post('sector'));

            $org_data = array(
                'addr_problem' => $this->input->post('problem_addressed'),
                'quest_1' => $this->input->post('product_service'),
                'ent_impact' => $this->input->post('enterprise_impact'),
                'sector' => serialize($get_sector),
                'regions' => $this->input->post('regions'),
                'operation_stage' => $this->input->post('operation_stage'),
                'fund_req' => $this->input->post('current_status'),
                'people_impact' => $this->input->post('no_of_people'),
                'info_about_program' => $abt_vill,
                'partner_name' => $this->input->post('partner_name'),
                'inc_name' => $this->input->post('inc_name'),
                'fund' => $this->input->post('pitch_fund_raise'),
                'awards' => $this->input->post('award_detail'),
                'sub_sector' => $this->input->post('sub_sector'),
                'pitch_id' => $pitch_id);


            $table = "pitch_step2";
            $result2 = $this->Minnovation->pitch_insert($table, $org_data);

///////////////////////// Pitch Org Info update ends //////////////////////
////////////////////////  Pitch document update //////////////////////////

            $uploads1 = $this->pitch_file_upload('pitchform', 'document', 'uploads1', 'pdf|ppt|pptx', $this->input->post('uploads1_hidden'));
            $uploads2 = $this->pitch_file_upload('pitchform', 'document', 'uploads2', 'pdf|ppt|pptx', $this->input->post('uploads2_hidden'));

            $doc_data = array(
                'doc1' => $uploads1,
                'doc2' => $uploads2,
                'pitch_id' => $pitch_id);

            $table = "award_share";
            $result3 = $this->Minnovation->pitch_insert($table, $doc_data);


            $partner_id = $this->session->userdata('partner_id');
            $employee_number = $this->Sector_model->getEmployeeNumberByID($this->input->post('sector'), $partner_id);

            $emp_num = php72_array_map(function ($emp_num) {
                return $emp_num['associate_employee'];
            }, $employee_number);

            $empmail = array();
            $employee_name = array();
            for ($i = 0; $i < count($emp_num); $i++) {

                $additional_info_data = array(
                    'innovation' => $in_id,
                    'associate_employee' => $emp_num[$i],
                    'status' => 1,
                    'created_date' => date('Y-m-d H:i:s'),
                    'sector_id' => $this->input->post('sector')
                );

                $empmail[$i] = $this->Sector_model->getEmployeeMailByID($emp_num[$i]);
                $employee_name[$i] = $this->Sector_model->getEmployeeNameByID($emp_num[$i]);

                $table = "assign_associate";
                $result = $this->Minnovation->pitch_insert($table, $additional_info_data);
            }
            $emp_mail = array_map(function ($emp_mail) {
                return $emp_mail['emp_work_email'];
            }, $empmail);
            $employee_names = array_map(function ($employee_names) {
                return $employee_names['emp_name'];
            }, $employee_name);

            $employees = rtrim(implode(',', $emp_num), ',');

            $log_data = array(
                'innovation_id' => $in_id,
                'stage' => 7,
                'status' => 12,
                'assigned_user' => $employees,
                'modified_by' => $this->session->userdata['emp_number'],
                'modified_date' => date('Y-m-d H:i:s')
            );

            $table_log = "application_status_log";
            $result = $this->Minnovation->pitch_insert($table_log, $log_data);

//////////////////////////////// Pitch document insert ends ///////////////////////////////
///////////////////////// Pitch APP mail process /////////////////////////
            $this->load->model('common/Minnovation_mail');
            $this->Minnovation_mail->Pitch_innovation('INV' . $in_id);

            $this->Minnovation_mail->pitch_mailSendIncharge('INV' . $in_id, $partner_id, $emp_mail, $employee_names);
///////////////////////// Pitch APP mail process ends ////////////////////


            $this->session->set_flashdata('successMsg', 'Innovation details added successfully');
            redirect('scouting/new_innovation');
        }

//////////////////////////////// Pitch Form Insertion Process ends ///////////////////
//////////////////////////////// Incubation Form Insertion Process starts ////////////
        if ($this->input->post('invSubmit') != '') {
            if ($this->input->post('country') != '') {
                $country_name = $this->Minnovation->getCountryName($this->input->post('country'));
                $count_name = $country_name[0];
                $beneficiary_invalid = "";
                foreach ($this->input->post('beneficiary') as $key => $value) {
                    if ($value == "Rural or urban middle income" || $value == "Rural or urban high income")
                        $beneficiary_invalid = 'yes';
                }
            }
            $status = '12';
/////////////////////////////// Innovation table insert ///////////////////////////////////
            $partneriddeal = $this->input->post('branch');
            $innovationpartnerid = str_pad($partneriddeal, 2, "0", STR_PAD_LEFT);
            $partnerdeal1 = $this->session->userdata('partner_id');
            $innovationpartnerid1 = str_pad($partnerdeal1, 2, "0", STR_PAD_LEFT);

            $innovation_data = array(
                'name_of_entrepreneur' => $this->db->escape_str($this->input->post('name_entr')),
                'name_of_enterprise' => $this->db->escape_str($this->input->post('ent_name')),
                'email_id' => $this->db->escape_str($this->input->post('inv_email')),
                'mobile_no' => $this->db->escape_str($this->input->post('inv_mobile')),
                'sourceName' => $this->db->escape_str($this->input->post('inv_srcname')),
                'website' => $this->db->escape_str($this->input->post('website_url')),
                'address_line1' => $this->db->escape_str($this->input->post('address1')),
                'address_line2' => $this->db->escape_str($this->input->post('address2')),
                'country' => $count_name,
                'sector' => ($this->input->post('sector') != '') ? php72_implode(',', $this->input->post('sector')) : $this->input->post('inv_sector'),
                'status' => $status,
                'stage' => '7',
                'program' => '0',
                'source' => '-1',
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('emp_number'),
                'partner_id' => ($this->session->userdata('user_type') == 'superadmin') ? $innovationpartnerid : $innovationpartnerid1
            );
            $table = "innovation_pool";
            $inc_inv_id = $this->Minnovation->pitch_insert($table, $innovation_data);

//////////////////////////// Innovation table insert ends /////////////////////////////////////
////////////////////// Innovation user insert/////////////////////
            $stat = ($status == '10') ? "Registered" : "Completed";
            $inv_user_data = array(
                'inv_no' => 'INV' . $inc_inv_id,
                'ent_name' => $this->db->escape_str($this->input->post('ent_name')),
                'applicant_name' => $this->db->escape_str($this->input->post('name_entr')),
                'email' => $this->db->escape_str($this->input->post('inv_email')),
                'mobile' => $this->db->escape_str($this->input->post('inv_mobile')),
                'address1' => $this->db->escape_str($this->input->post('address1')),
                'address2' => $this->db->escape_str($this->input->post('address2')),
                'website' => $this->db->escape_str($this->input->post('website_url')),
                'country' => $this->db->escape_str(@$this->input->post('country')),
                'ent_type' => $this->db->escape_str($this->input->post('compnay_type')),
                'india_based' => $this->db->escape_str($this->input->post('location')),
                'ent_sector' => ($this->input->post('sector') != '') ? php72_implode(',', $this->input->post('sector')) : $this->input->post('inv_sector'),
                'sub_sector' => $this->input->post('sub_sector'),
                'benificiary' => serialize($this->input->post('beneficiary')),
                'impact_of_product' => $this->db->escape_str($this->input->post('impact_type')),
                'status' => $stat,
                'created_date' => date('Y-m-d'),
                'submitted_date' => date('Y-m-d')
            );

            $table = "inv_user";
            $inv_user_id = $this->Minnovation->pitch_insert($table, $inv_user_data);

///////////////////// Innovation user insert ends //////////////////
//////////////////// Innovation member insert /////////////////////
            $this->load->library('upload');
            $mem_count = php72_count($_POST['team_name']);
            for ($i = 1; $i <= $mem_count; $i++) {
                $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/IncubationForm/uploads';
                $resume_path[$i] = '';
                if ($_FILES["team_res"]["name"][$i] != "") {
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'doc|docx|ppt|pptx|pdf';
                    $file_name = explode('.', $_FILES["team_res"]["name"][$i]);
                    $config['file_name'] = str_replace(' ', '_', $file_name[0] . '-' . $_POST['team_name'][$i] . '.' . $file_name[1]);

                    $this->upload->initialize($config);

                    $_FILES['resume']['name'] = $_FILES['team_res']['name'][$i];
                    $_FILES['resume']['tmp_name'] = $_FILES['team_res']['tmp_name'][$i];
                    $_FILES['resume']['size'] = $_FILES['team_res']['size'][$i];
                    $_FILES['resume']['type'] = $_FILES['team_res']['type'][$i];
                    $_FILES['resume']['error'] = $_FILES['team_res']['error'][$i];

                    if (!$this->upload->do_upload('resume')) {
                        $upload_error = $this->upload->display_errors();
                        echo $upload_error . "--" . $i;
                    } else {
                        $upload_data = $this->upload->data();
                        $resume_path[$i] = $upload_data['file_name'];
                    }
                    unset($config);
                }
                if ($_POST['team_name'][$i] != '' || $_POST['team_desg'][$i] != '' || $_POST['team_org'][$i] != '' || $_POST['team_email'][$i] != '' || $_POST['team_mob'][$i] != '' || $_FILES['team_res']['name'][$i] != '') {
                    $member_data = array(
                        'mem_name' => $this->db->escape_str($_POST['team_name'][$i]),
                        'mem_occupation' => $this->db->escape_str($_POST['team_desg'][$i]),
                        'mem_org' => $this->db->escape_str($_POST['team_org'][$i]),
                        'mem_email' => $this->db->escape_str($_POST['team_email'][$i]),
                        'mem_mobile' => $this->db->escape_str($_POST['team_mob'][$i]),
                        'mem_resume' => $resume_path[$i],
                        'inv_user_id' => $inv_user_id
                    );

                    $table = "inv_member";
                    $result = $this->Minnovation->pitch_insert($table, $member_data);
                }
            }

/////////////////// Innovation member insert ends ////////////////////
/////////////////////////////// Innovation Enterprise info insert ///////////////////////////////////

            $ent_info_data = array(
                'inv_user_id' => $inv_user_id,
                'ent_name_info' => $this->db->escape_str($this->input->post('ent_name')),
                'in_operation' => $this->db->escape_str($this->input->post('in_operation')),
                'operate_on_state' => php72_implode(',', $this->input->post('inv_state')),
                'develop_product' => $this->db->escape_str($this->input->post('type_prod')),
                'stage_product' => $this->db->escape_str($this->input->post('stage_prod')),
                'inv_desc' => $this->db->escape_str($this->input->post('inno_desc')),
                'inv_problem' => $this->db->escape_str($this->input->post('inno_prob')),
                'inv_alternatives' => $this->db->escape_str($this->input->post('avail_alter')),
                'pilots' => $this->db->escape_str($this->input->post('pilots')),
                'proposal_desc' => $this->db->escape_str($this->input->post('prop_model')),
                'inv_risks' => $this->db->escape_str($this->input->post('ident_risk'))
            );

            $table = "inv_ent_info";
            $result = $this->Minnovation->pitch_insert($table, $ent_info_data);

//////////////////////////// Innovation Enterprise info insert ends /////////////////////////////////////
/////////////////////////////// Innovation Impact info insert ///////////////////////////////////

            $impact_info_data = array(
                'inv_user_id' => $inv_user_id,
                'primary_benifi' => $this->db->escape_str($this->input->post('prim_benefi')),
                'research_cus_seg' => $this->db->escape_str($this->input->post('cust_seg')),
                'demographic_profie' => $this->db->escape_str($this->input->post('benefi_grp')),
                'avg_monthly' => $this->db->escape_str($this->input->post('avg_earn')),
                'inv_impact' => $this->db->escape_str($this->input->post('no_impact')),
                'others_benefit' => $this->db->escape_str($this->input->post('service_benefit'))
            );

            $table = "inv_impact";
            $result = $this->Minnovation->pitch_insert($table, $impact_info_data);

//////////////////////////// Innovation Impact info insert ends /////////////////////////////////////
/////////////////////////////// Innovation Additional info insert ///////////////////////////////////
            $business_file = '';
            if ($_FILES['busi_plan']['name'] != '') {
                $business_file = $this->pitch_file_upload('IncubationForm', 'uploads', 'busi_plan', 'pdf|doc|docx|ppt|pptx');
                if ($business_file == 0) {
                    $data['error'] = "File related to business plan not uploaded. Please upload a valid file";
                }
            }
            $additional_file = '';
            if ($_FILES['add_info_file']['name'] != '') {
                $additional_file = $this->pitch_file_upload('IncubationForm', 'uploads', 'add_info_file', 'pdf|doc|docx|ppt|pptx');
                if ($additional_file == 0) {
                    $data['error'] = "File related to additonal information not uploaded. Please upload a valid file";
                }
            }


            $additional_info_data = array(
                'inv_user_id' => $inv_user_id,
                'from_villgro' => php72_implode(',', $this->input->post('vill_support')),
                'support_name' => $this->db->escape_str($this->input->post('otr_support')),
                'hear_abt' => php72_implode(',', $this->input->post('abt_vill')),
                'referal_name' => $this->db->escape_str($this->input->post('ref_name')),
                'ant_org' => $this->input->post('with_other_org'),
                'ant_org_name' => $this->db->escape_str($this->input->post('other_org_name')),
                'won_competition' => $this->input->post('competition'),
                'competition_name' => $this->db->escape_str($this->input->post('business_compet')),
                'company_description' => $this->db->escape_str($this->input->post('company_desc')),
                'inv_idea_ent' => $this->db->escape_str($this->input->post('inv_idea_ent')),
                'business_plan' => $business_file,
                'add_info' => $additional_file
            );

            $table = "inv_additional_info";
            $result = $this->Minnovation->pitch_insert($table, $additional_info_data);

            $partnerId = $this->session->userdata('partner_id');
            $employee_number = $this->Sector_model->getEmployeeNumberByID($this->input->post('inv_sector'), $partnerId);
            $emp_num = php72_array_map(function ($emp_num) {
                return $emp_num['associate_employee'];
            }, $employee_number);

            $empmail = array();
            $employee_name = array();
            for ($i = 0; $i < count($emp_num); $i++) {

                $additional_info_data = array(
                    'innovation' => $inc_inv_id,
                    'associate_employee' => $emp_num[$i],
                    'status' => 1,
                    'created_date' => date('Y-m-d H:i:s'),
                    'sector_id' => $this->input->post('inv_sector')
                );

                $empmail[$i] = $this->Sector_model->getEmployeeMailByID($emp_num[$i]);
                $employee_name[$i] = $this->Sector_model->getEmployeeNameByID($emp_num[$i]);

                $table = "assign_associate";
                $result = $this->Minnovation->pitch_insert($table, $additional_info_data);
            }
            $emp_mail = array_map(function ($emp_mail) {
                return $emp_mail['emp_work_email'];
            }, $empmail);
            $emp_names = array_map(function ($emp_names) {
                return $emp_names['emp_name'];
            }, $employee_name);
            $employees = rtrim(implode(',', $emp_num), ',');

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

//////////////////////////// Innovation Additional info insert ends /////////////////////////////////////
///////////////////////// Innovation APP mail process /////////////////////////
            $partner_id = $this->session->userdata('partner_id');
            $this->load->model('common/Minnovation_mail');

            $this->Minnovation_mail->mailSendIncharge('INV' . $inc_inv_id, $partner_id, $emp_mail, $emp_names);
///////////////////////// Innovation APP mail process ends ////////////////////

            $this->session->set_flashdata('successMsg', 'Innovation details added successfully');
            redirect('scouting/new_innovation');
        }
//////////////////////////////// Incubation Form Insertion Process ends /////////////

        if ($this->input->post('txtSubmit') != '') {
            $this->load->library('upload');
            ini_set("upload_max_filesize", "30M");
            $_POST['business_plan_document'] = '';
            if ($_FILES['business_plan_document']['name'] != '') {
                $config['upload_path'] = './uploads/innovaton/supporting_documents';
                $config['allowed_types'] = '*';
                $config['file_name'] = str_replace(' ', '_', $_POST['name_of_enterprise']) . "-business_plan-" . str_replace(' ', '_', $_FILES['business_plan_document']['name']);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('business_plan_document'))
                    $data['upload_error'] = $this->upload->display_errors();
                else {
                    $upload_data = $this->upload->data();
                    $_POST['business_plan_document'] = $upload_data['file_name'];
                    if ($_POST['pre_business_plan_document'] != '')
                        @unlink('./uploads/innovaton/supporting_documents/' . $_POST['pre_business_plan_document']);
                }
                unset($config);
            }
            if ($_POST['business_plan_document'] == '') {
                $_POST['business_plan_document'] = $_POST['pre_business_plan_document'];
            }
            if ($_POST['action'] == 'add') {
                foreach ($_POST['document_type'] as $key => $value):
                    if (($_FILES['supporting_documents']['name'][$key] != '' || $_POST['youtube'][$key] != "") && $value != '') {
                        if ($_FILES['supporting_documents']['name'][$key] != '') {
                            $config['upload_path'] = './uploads/innovaton/supporting_documents';
                            $config['allowed_types'] = '*';
                            $config['file_name'] = str_replace(' ', '_', $_POST['name_of_enterprise']) . "-supporting_documents-" . str_replace(' ', '_', $_FILES['supporting_documents']['name'][$key]);
                            $this->upload->initialize($config);

                            $_FILES['file_field']['name'] = $_FILES['supporting_documents']['name'][$key];
                            $_FILES['file_field']['tmp_name'] = $_FILES['supporting_documents']['tmp_name'][$key];
                            $_FILES['file_field']['size'] = $_FILES['supporting_documents']['size'][$key];
                            $_FILES['file_field']['type'] = $_FILES['supporting_documents']['type'][$key];
                            $_FILES['file_field']['error'] = $_FILES['supporting_documents']['error'][$key];

                            if (!$this->upload->do_upload('file_field'))
                                $data['upload_error'] = $this->upload->display_errors();
                            else {
                                $upload_data = $this->upload->data();
                                $_POST['supporting_documents'][] = $upload_data['file_name'];
                                $_POST['document_type_value'][] = $value;
                                $_POST['youtubeValue'][] = $_POST['youtube'][$key];
                            }
                            unset($config);
                        } else {
                            $_POST['supporting_documents'][] = '';
                            $_POST['document_type_value'][] = $value;
                            $_POST['youtubeValue'][] = $_POST['youtube'][$key];
                        }
                    }
                endforeach;
                $this->Minnovation->insert($_POST);
                $this->session->set_flashdata('successMsg', 'Application Submitted Successfully');
                redirect('scouting/new_innovation');
            } else {
                $this->Minnovation->update($_POST);
                $this->session->set_flashdata('successMsg', 'Application Updated Successfully');
                redirect('scouting/innovation_details/' . $id);
            }
        }
        $data['innovationDetails'] = array();
        $data['left_box'] = array('innovation_pool');
        $data['cpagetitle'] = "Incubation Application Form";
        if ($id != '') {
            $data['old_inv'] = 'set';
            $data['innovationDetails'] = $this->Minnovation->getInnovationDetails($id);
            $data['innovation'] = $this->Minnovation->getInnovation($id);
            $data['cpagetitle'] = "Edit Application";
            $data['left_box'] = array('innovation_tab');
        }
        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['documentTypeList'] = $this->Mmaster_settings->getMasterSetting('Document Checklist');
        $data['states'] = $this->Eirmodel->fetch_state(); // added for pitch form
        $data['videoOption'] = '52'; //TO SHOW YOUTUBE
        $data['branch'] = $this->Mmaster->getBranch();
        $partner_id = $this->session->userdata('partner_id');
        $data['sectors'] = $this->Mincharge->getSectorNames($partner_id);
        $data['sector_details'] = $this->Sector_model->getIncSectors('incubation');
        $data['cpage'] = "new_innovation";

        $data['custom_js'] = array('new_innovation');
        $this->load->vars($data);
        $this->load->view('../template');
    }

    /** INNOVATION IMPORT FROM CSV * */
    function new_innovation_import() {
        set_time_limit(0);

        if (isset($_POST['submit'])) {

            $ext = explode(".", $_FILES['card']['name']);
            if ($_FILES['card']['name'] != '' && $ext[count($ext) - 1] == 'csv') {

                $path = $_FILES['card']['tmp_name'];
                $file = fopen($path, "r");
                while (!feof($file)) {
                    $arr[] = fgetcsv($file);
                }
                fclose($file);

                $arr = array_filter($arr);

                for ($i = 1; $i < count($arr); $i++) {
                    $first[] = @$arr[$i][14];
                    $second[] = @$arr[$i][16];
                    $mail[] = @$arr[$i][6];
                }
                $msg = '';
                if ($msg == 'true') {
                    $data['errorMsg'] = 'Please Enter valid Email Address';
                } else if (count($arr) <= 1) {
                    $data['errorMsg'] = 'Please Fill up the Columns with Values';
                } else if (php72_in_array('', $first) && php72_in_array('', $second)) {
                    $data['errorMsg'] = 'Name of the Enterprise or Summary of the Business column value is empty please fill the columns';
                } else if (php72_count($arr[0]) > 18) {
                    $data['errorMsg'] = 'More Columns are used in the CSV File Please Keep in Format.';
                } else {

                    $result = $this->Minnovation->new_innovation_import_CSV($arr);
                    $data['successMsg'] = 'Innovations Imported !!';
                    if ($result) {
                        $data['successMsg'] = 'Innovations Imported !!';
                    } else {
                        $data['errorMsg'] = 'Innovations failed to insert in database!';
                    }
                }
            } else {
                $data['errorMsg'] = 'Please select Csv file!';
            }
        }

        $data['cpagetitle'] = "Import Innovations";
        $data['cpage'] = "new_innovation_import";
        $this->load->vars($data);
        $this->load->view('../template');
    }

    function innovation_export_all($options = array()) {
        $tab = $this->uri->segment(3);
        $this->load->dbutil();
        $this->hris = $this->load->database('hris', TRUE);
        $this->load->model('Minnovation_reports');
        $whereQuery = $this->Minnovation_reports->_searchReport($options);

        if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "" && $whereQuery == "")
            $whereQuery = "AA.associate_employee = '" . $options['assigned_incharge'] . "' and AA.status=1";
        else if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "" && $whereQuery != '')
            $whereQuery .= " and AA.associate_employee = '" . $options['assigned_incharge'] . "' and AA.status=1";

        if (!empty($options['orderby']) && !empty($options['ordertype']))
            $this->db->order_by($options['orderby'], $options['ordertype']);
        else
            $this->db->select("IP.program");
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('pitch_user', 'pitch_user.inno_id = IP.innovation_id', 'left');
        $this->db->join('pitch_step2', 'pitch_step2.pitch_id=pitch_user.pitch_id', 'left');
        $this->db->join('inv_additional_info iaf ', 'iaf.inv_user_id=INV.id', 'left');
        $this->db->join('inv_ent_info iet ', 'iet.inv_user_id=INV.id', 'left');
        $this->db->join('inv_impact imt ', 'imt.inv_user_id=INV.id', 'left');
        $this->db->join('eir_user eir', 'eir.innovation_no = IP.innovation_id', 'left');
        $this->db->join('inv_member inv_mem', 'inv_mem.inv_user_id = INV.id', 'left');


        $this->db->join('(SELECT innovation_id, id, fstage, donor_fit, LIS
            FROM grading_feedback AS ga
            INNER JOIN (
            SELECT max( id ) AS maxid
            FROM grading_feedback
            GROUP BY innovation_id
        ) AS gb ON ga.id = gb.maxid) as GF', 'GF.innovation_id=IP.id', 'left');
        $this->db->distinct();
        $this->db->group_by('IP.program');
        if (isset($options['innovation_score'])) {
            $this->db->select('INS.*');
            $this->db->join('innovation_score INS', 'INS.innovation = IP.id', 'left');
        }

        if (!empty($whereQuery))
            $query = $this->db->get_where('innovation_pool IP', $whereQuery);
        else
            $query = $this->db->get('innovation_pool IP');

        if ($query->num_rows() > 1) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }

            echo "invalid";
        } else {

        }
    }

///////// ajax call ///////////////

    public function getPartnersList() {
        $p_enterprise = $data['pa_entreprise'] = $this->input->post('enterprise');
        $p_enterpreneur = $data['pa_entrepreneur'] = $this->input->post('enterpreneur');
        $p_email = $data['pa_email'] = $this->input->post('email');
        $data['partnersList'] = $this->Minnovation->getPartnersRecords($p_enterprise, $p_enterpreneur, $p_email, 1);
        $ss = $this->load->view('../partners_list_ajax', $data);
        echo $ss;
    }

    function getInnovationList($currentTab = 'all', $post_val) {
//incomplete-draft:register-register:deleted-delete
        $options = $this->make_filter($currentTab, $post_val);
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $options['offset'] = intval($_GET['iDisplayStart']);
            $options['num'] = intval($_GET['iDisplayLength']);
        }
        $options['currentTab'] = $currentTab;
        $data['innovationList'] = $this->Minnovation->getLimitRecords_new($options);
        if (isset($this->session->userdata['user_id'])) {
            echo json_encode($data['innovationList']);
        } else {
            echo json_encode($data['error'] = "LoginError");
        }
    }

    function innovation_pool_export_all() {
        $currentTab = 'all';
        $options = $this->make_filter($currentTab, $_POST);
        $this->innovation_export_all($options);
    }

    /* INNOVATION LIST */

    function innovation_pool($currentTab = '') {
        if ($this->session->userdata['partner_id'] == '1') {
            if ($currentTab == 'assigned') {
                $newDeals = site_url('portfolio/mydeals');
            } else {
                $newDeals = site_url('portfolio/alldeals');
            }
            redirect($newDeals);
        } else {
            $offset = 4;
            if ($currentTab == '') {
                if (in_array($this->session->userdata('user_type'), array('superadmin', 'admin', 'ceo', 'cio')))
                    $currentTab = 'all';
                if ($this->session->userdata('user_name') == 'Altacit')
                    $currentTab = 'identified';
                else
                    $currentTab = 'assigned';
            }
            $data['currentTab'] = $currentTab;
            $options = $this->make_filter($currentTab, $_POST);
            $this->session->branchdetails['admin_branch'] = (!empty($this->session->branchdetails['admin_branch']) ? $this->session->branchdetails['admin_branch'] : $options['branch_name'] != '') ? $options['branch_name'] : $_POST['branch'];

            if ($currentTab == 'similar') {
                $offset = 5;
                $data['name_of_enterprise'] = $options['name_of_enterprise'];
            }
#Pagination Scripts Starts
            $config = array('base_url' => site_url('scouting/innovation_pool/' . $currentTab),
                'per_page' => '15',
                'total_rows' => $this->Minnovation->getPageCount($options),
                'num_links' => 10,
                'uri_segment' => $offset);
            $this->pagination->initialize($config);
#pagination Ends
            $data['emplist'] = $this->Muser->getUsersList();
            $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');
            $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
            $data['reportsList'] = $this->Mreports->getReportsByType('innovation');
            $data['orderby'] = $this->input->post('orderby');
            $data['ordertype'] = $this->input->post('ordertype');
            $data['stage'] = $this->Minnovation->getInnvationStage();
            $data['status'] = $this->Minnovation->getInnvationStatus();
            $data['selDraft'] = $options['app_draft'];
            $data['selRegis'] = $options['app_regist'];
            $data['selDelet'] = $options['app_delet'];

            $this->load->model('master/Mmaster');
            $branch_id = $this->session->userdata('partner_id');
            $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
            $data['userbranch'] = $this->Mmaster->getYbranch($branch_id);
            $data['usersABIList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
            $data['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
            $data['usersListEmployee'] = $this->Muser->getUsersListNotAbi($userSetup1['abi'], $branch_id);
            $data['users'] = php72_array_merge($data['usersList'], $data['usersListEmployee']);
            $data['donor_fit'] = $this->Minnovation->getDonorFit();

            $this->load->model('master/Mstageefficiency');
            $data['timelimit'] = $this->Mstageefficiency->getMaxDays();
            $data['stagedate'] = $this->Mstageefficiency->getStageDate();

            if (!empty($options['export'])) {
                $this->export_innovation($options);
            }

            if ($this->input->post('txtExport')) {
                $this->innovation_download($options);
            }

            if ($this->input->post('txtExport_all')) {
                $this->innovation_export($options);
            }

            $data['branch'] = $this->Mmaster->getBranch();
            $data['cpagetitle'] = "Innovation Pool";
            $data['cpage'] = "innovation_pool";
            $data['custom_js'] = array('list_page', 'innovation_pool');
            if ($this->session->userdata('user_type') != 'incubatee') {
                $data['left_box'] = array('innovation_pool');
            }

            $this->load->vars($data);
            $this->load->view('../template');
        }
    }

    function ui_new_deal($currentTab = '') {
        $offset = 4;
        if ($currentTab == '') {
            if (in_array($this->session->userdata('user_type'), array('superadmin', 'admin', 'ceo', 'cio')))
                $currentTab = 'all';
            if ($this->session->userdata('user_name') == 'Altacit')
                $currentTab = 'identified';
            else
                $currentTab = 'all';
        }
        $data['currentTab'] = $currentTab;
        $options = $this->make_filter($currentTab, $_POST);
        $this->session->branchdetails['admin_branch'] = (!empty($this->session->branchdetails['admin_branch']) ? $this->session->branchdetails['admin_branch'] : $options['branch_name'] != '') ? $options['branch_name'] : $_POST['branch'];

        if ($currentTab == 'similar') {
            $offset = 5;
            $data['name_of_enterprise'] = $options['name_of_enterprise'];
        }
#Pagination Scripts Starts
        $config = array('base_url' => site_url('scouting/ui_new_deal/' . $currentTab),
            'per_page' => '15',
            'total_rows' => $this->Minnovation->getPageCount($options),
            'num_links' => 10,
            'uri_segment' => $offset);

        $this->pagination->initialize($config);
#pagination Ends
        $data['emplist'] = $this->Muser->getUsersList();
        $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');
        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['reportsList'] = $this->Mreports->getReportsByType('innovation');
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['innovationList'] = $this->Minnovation->getLimitRecords_new($options);

        $data['status'] = $this->Minnovation->getInnvationStatus();
        $data['selDraft'] = $options['app_draft'];
        $data['selRegis'] = $options['app_regist'];
        $data['selDelet'] = $options['app_delet'];


        $this->load->model('master/Mmaster');
        $branch_id = $this->session->userdata('partner_id');
        $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
        $data['userbranch'] = $this->Mmaster->getYbranch($branch_id);
        $data['usersABIList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
        $data['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
        $data['usersListEmployee'] = $this->Muser->getUsersListNotAbi($userSetup1['abi'], $branch_id);
        $data['users'] = php72_array_merge($data['usersList'], $data['usersListEmployee']);
        $data['donor_fit'] = $this->Minnovation->getDonorFit();

        $this->load->model('master/Mstageefficiency');
        $data['timelimit'] = $this->Mstageefficiency->getMaxDays();
        $data['stagedate'] = $this->Mstageefficiency->getStageDate();


        if (!empty($options['export'])) {
            $this->export_innovation($options);
        }

        if ($this->input->post('txtExport')) {
            $this->innovation_download($options);
        }

        if ($this->input->post('txtExport_all')) {
            $this->innovation_export($options);
        }

        $data['branch'] = $this->Mmaster->getBranch();

        $data['cpagetitle'] = "Innovation Pool";
        $data['cpage'] = "new_deals";
        $data['custom_js'] = array('list_page', 'innovation_pool');
        if ($this->session->userdata('user_type') != 'incubatee') {
            $data['left_box'] = array('innovation_pool');
        }

        $this->load->vars($data);
        $this->load->view('../template');
    }

    function innovation_export($options = array()) {

        $tab = $this->uri->segment(3);
        $this->load->dbutil();
        $this->hris = $this->load->database('hris', TRUE);
        $this->load->model('Minnovation_reports');
        $whereQuery = $this->Minnovation_reports->_searchReport($options);

        if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "" && $whereQuery == "")
            $whereQuery = "AA.associate_employee = '" . $options['assigned_incharge'] . "' and AA.status=1";
        else if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "" && $whereQuery != '')
            $whereQuery .= " and AA.associate_employee = '" . $options['assigned_incharge'] . "' and AA.status=1";

        if (!empty($options['orderby']) && !empty($options['ordertype']))
            $this->db->order_by($options['orderby'], $options['ordertype']);
        else
            $this->db->order_by('Submitted_Date', 'desc');

        $whereQuery = $this->Minnovation_reports->_searchReport($options);

        if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "" && $whereQuery == "")
            $whereQuery = "AA.associate_employee = '" . $options['assigned_incharge'] . "' and AA.status=1";
        else if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "" && $whereQuery != '')
            $whereQuery .= " and AA.associate_employee = '" . $options['assigned_incharge'] . "' and AA.status=1";

        if (!empty($options['orderby']) && !empty($options['ordertype']))
            $this->db->order_by($options['orderby'], $options['ordertype']);
        else
            $this->db->order_by('Submitted_Date', 'desc');

        if ($options['program'] == 0) {
            $program_type = 'Incubation';
            $this->db->select("CONCAT(IP.copy_id,'_',IP.partner_id,'_',IP.partner_count) as Innovation_id,IP.copy_id,IP.name_of_enterprise as Name_of_Enterprise,IP.name_of_entrepreneur as Name_of_Entrepreneur,
                IP.email_id as Email,IP.mobile_no as Mobile_number,IP.country as Country,IP.address_line1 as Address1,IP.address_line2 as Address2,
                CONCAT(UCASE(LEFT(INV.ent_type, 1)),SUBSTRING(INV.ent_type, 2)) as Is_your_enterprise,
                IF(IP.program=1 ,'EIR', IF(IP.program=2 , 'SEED', IF(IP.program=3, 'Unc Pitch','Incubation'))) as Program,
                IP.stage as Stage, IP.status as Status, MS.master_name as Closed_Reasons, IP.comments as Closed_Comments,
                CONCAT(UCASE(LEFT(INV.india_based, 1)),SUBSTRING(INV.india_based, 2)) as Will_your_social_enterprise_be_based_India,SC.sector as Sector_for_your_enterprise,SubCat.sector as Sub_Sector_for_your_enterprise,
                INV.benificiary as Beneficiaries_of_product_service,INV.impact_of_product as What_type_of_impact_will_your_product, iet.operate_on_state as States_plan_to_operate,
                if(iet.in_operation='2','2 years',if(iet.in_operation='1','1 year',if(iet.in_operation='0to6','0 to 6 months',if(iet.in_operation='6to12','6 to 12 months','')))) as How_long_have_you_been_in_operation,iet.develop_product as Are_you_developing_a,iet.stage_product as At_what_stage_is_your_product,
                iet.inv_desc as Description_of_your_innovation,iet.inv_problem as What_problem_does_your_innovation,iet.inv_alternatives as How_is_the_need_addressed_without_your_innovation,
                iet.proposal_desc as Describe_your_proposed,iet.inv_risks as Risks_have_you_identified_in_the_business,
                imt.primary_benifi as Primary_beneficiary_of_your_product,
                CONCAT(UCASE(LEFT(imt.research_cus_seg, 1)),SUBSTRING(imt.research_cus_seg, 2)) as Have_you_conducted_research_on_your_customer_segments,
                imt.demographic_profie as What_is_the_demographic_profile,imt.avg_monthly as What_is_the_average_monthly,
                imt.inv_impact as People_expect_to_impact_through_innovation,imt.others_benefit as Will_your_product_or_service_benefit,
                iaf.from_villgro as Please_indicate_the_support, iaf.support_name as Support_name, iaf.hear_abt as How_did_you_hear_about_our_program,
                iaf.referal_name as Incubated_funded_or_participated_by_referal, iaf.ant_org as Have_you_been_incubated_funded_or_participated,
                iaf.ant_org_name as Name_of_organization,iaf.won_competition as Have_you_participated_in_or_won_any_business_plan,
                iaf.competition_name as Name_of_business_plan_competition, iaf.business_plan as link1, iaf.add_info as link2");
            $this->db->select("(select branch_name from  " . $this->hris->database . ".hs_hr_branch where id = IP.partner_id) as Partner");
            $this->db->select("(select GROUP_CONCAT(CONCAT_WS(' ',emp.emp_firstname,emp.emp_lastname)) as employees from " . $this->hris->database . ".hs_hr_employee emp
                Join assign_associate AA1 ON emp.emp_number = AA1.associate_employee where IP.id = AA1.innovation and AA1.status = 1 group by AA1.innovation ) as Assigned_Incharge", false);
            $this->db->select("ROUND(AVG(total_score),2) AS PA_RD_Score");
            $this->db->select("ROUND(AVG(total_per),2) AS PA_RD_Score_Percentage");
            $this->db->select("(select GROUP_CONCAT(DFM.name SEPARATOR ',') as donor from donor_fit_master as DFM where find_in_set(DFM.id, GF.donor_fit) !=0 group by GF.id) as Donors", false);
            $this->db->select('INV.id');
            $this->db->select("DATE_FORMAT(IFNULL(IFNULL(pitch_user.submitted_date, INV.submitted_date),eir.date_submitted), '%d-%b-%y') AS Submitted_Date");
            $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
            $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
            $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
            $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
            $this->db->join('master_settings MS', 'MS.id = IP.reasons', 'left');
            $this->db->join('assest_detail AD', 'AD.innovation_id = IP.id', 'left');
            $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'inner');
            $this->db->join('sector_category SubCat', 'SubCat.id =  INV.sub_sector', 'left');
            $this->db->join('pitch_user', 'pitch_user.inno_id = IP.innovation_id', 'left');
            $this->db->join('pitch_step2', 'pitch_step2.pitch_id=pitch_user.pitch_id', 'left');
            $this->db->join('inv_additional_info iaf ', 'iaf.inv_user_id=INV.id', 'left');
            $this->db->join('inv_ent_info iet', 'iet.inv_user_id=INV.id', 'left');
            $this->db->join('inv_impact imt ', 'imt.inv_user_id=INV.id', 'left');
            $this->db->join('eir_user eir', 'eir.innovation_no = IP.innovation_id', 'left');
            $this->db->join('inv_member inv_mem', 'inv_mem.inv_user_id = INV.id', 'left');

            $this->db->join('(SELECT innovation_id, id, fstage, donor_fit, LIS
                FROM grading_feedback AS ga
                INNER JOIN (
                SELECT max( id ) AS maxid
                FROM grading_feedback
                GROUP BY innovation_id
            ) AS gb ON ga.id = gb.maxid) as GF', 'GF.innovation_id=IP.id', 'left');
            $this->db->distinct();
            $this->db->group_by('IP.innovation_id');
            if (isset($options['innovation_score'])) {
                $this->db->select('INS.*');
                $this->db->join('innovation_score INS', 'INS.innovation = IP.id', 'left');
            }

            if (!empty($whereQuery))
                $query = $this->db->get_where('innovation_pool IP', $whereQuery);
            else
                $query = $this->db->get('innovation_pool IP');
        } else if ($options['program'] == 3) {
            $program_type = 'Unc Pitch';
            $this->db->select("CONCAT(IP.copy_id,'_',IP.partner_id,'_',IP.partner_count) as Innovation_id,IP.copy_id,IP.name_of_entrepreneur as Name_of_Entrepreneur,IP.name_of_enterprise as Name_of_Enterprise,
                pitch_user.gst_number as GST_Number,IP.email_id as Email,IP.mobile_no as Mobile_number,pitch_user.altmobileno as Alternate_mobile,
                IF(IP.program=1 ,'EIR', IF(IP.program=2 , 'SEED', IF(IP.program=3, 'Unc Pitch','Incubation'))) as Program,
                IP.stage as Stage,IP.status as Status, MS.master_name as Closed_Reasons, IP.comments as Closed_Comments,
                pitch_user.city as City,pitch_user.other_city as Other_City,SC.sector as Sector,SubCat.sector as Sub_Sector,pitch_step2.other_subsector as Other_Subsector,
                CONCAT(UCASE(LEFT(pitch_step1_info.ent_type, 1)),SUBSTRING(pitch_step1_info.ent_type, 2)) as Enterprise_Stage,pitch_step2.website as Company_Website,
                pitch_step2.incorporation_year as Year_of_incorporation,pitch_step2.operation_stage as Stage_of_operation,pitch_step2.water_consumption as Reduce_water_consumption_in_agriculture,
                pitch_step2.saved_water as How_many_liters_of_water_have_you_saved_in_the_last_one_year,pitch_step2.fy_18_19 as Revenue_of_company_2018_19,pitch_step2.fy_17_18 as Revenue_of_company_2017_18,
                pitch_step2.fy_16_17 as Revenue_of_company_2016_17,IF(pitch_step2.patents=1 ,'Yes', IF(pitch_step2.patents=2 , 'No','')) as Patents,
                CONCAT(UCASE(LEFT(pitch_step2.fund, 1)),SUBSTRING(pitch_step2.fund, 2)) as Have_you_raised_funding,pitch_step2.fund_raised_amount as How_much,
                pitch_step2.last_fund_desc as When_did_you_last_raise_funding_or_win_a_grant,pitch_step2.awards as Have_you_won_a_prize,
                pitch_step2.addr_problem as Briefly_explain_the_specific_problem,pitch_step2.quest_1 as Describe_your_idea_product_or_service,
                pitch_step2.ent_impact as How_is_your_product_idea_or_service_creating_social_impact,pitch_step2.accelerate_type as Incubated_or_accelerated_by_any_institution,
                pitch_step2.incubated_accelerated as Name_of_the_incubator_or_accelerator,pitch_step2.info_about_program as How_did_you_hear_about_the_program,
                pitch_step2.partner_name as Other_mailers_newsletter,pitch_step2.referral_name as Referral_name, awd.doc1 as link1, awd.doc2 as link2
                ");
            $this->db->select("(select GROUP_CONCAT(CONCAT_WS(' ',emp.emp_firstname,emp.emp_lastname)) as employees from " . $this->hris->database . ".hs_hr_employee emp
                Join assign_associate AA1 ON emp.emp_number = AA1.associate_employee where IP.id = AA1.innovation  group by AA1.innovation ) as Assigned_Incharge", false);
            $this->db->select("ROUND(AVG(total_score),2) AS PA_RD_Score");
            $this->db->select("ROUND(AVG(total_per),2) AS PA_RD_Score_Percentage");
            $this->db->select("(select GROUP_CONCAT(DFM.name SEPARATOR ',') as donor from donor_fit_master as DFM where find_in_set(DFM.id, GF.donor_fit) !=0 group by GF.id) as Donors", false);
            $this->db->select('pitch_user.pitch_id');
            $this->db->select("DATE_FORMAT(IFNULL(IFNULL(pitch_user.submitted_date, INV.submitted_date),eir.date_submitted), '%d-%b-%y') AS Submitted_Date");

            $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
            $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
            $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
            $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
            $this->db->join('master_settings MS', 'MS.id = IP.reasons', 'left');
            $this->db->join('assest_detail AD', 'AD.innovation_id = IP.id', 'left');
            $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
            $this->db->join('pitch_user', 'pitch_user.inno_id = IP.innovation_id', 'inner');
            $this->db->join('pitch_step1_info', 'pitch_step1_info.pitch_id=pitch_user.pitch_id', 'left');
            $this->db->join('pitch_step2', 'pitch_step2.pitch_id=pitch_user.pitch_id', 'left');
            $this->db->join('sector_category SubCat', 'SubCat.id =  pitch_step2.sub_sector', 'left');
            $this->db->join('inv_additional_info iaf ', 'iaf.inv_user_id=INV.id', 'left');
            $this->db->join('inv_ent_info iet ', 'iet.inv_user_id=INV.id', 'left');
            $this->db->join('inv_impact imt ', 'imt.inv_user_id=INV.id', 'left');
            $this->db->join('eir_user eir', 'eir.innovation_no = IP.innovation_id', 'left');
            $this->db->join('inv_member inv_mem', 'inv_mem.inv_user_id = INV.id', 'left');
            $this->db->join('award_share awd', 'awd.pitch_id = pitch_user.pitch_id', 'left');


            $this->db->join('(SELECT innovation_id, id, fstage, donor_fit, LIS
                FROM grading_feedback AS ga
                INNER JOIN (
                SELECT max( id ) AS maxid
                FROM grading_feedback
                GROUP BY innovation_id
            ) AS gb ON ga.id = gb.maxid) as GF', 'GF.innovation_id=IP.id', 'left');
            $this->db->distinct();
            $this->db->group_by('IP.innovation_id');
            if (isset($options['innovation_score'])) {
                $this->db->select('INS.*');
                $this->db->join('innovation_score INS', 'INS.innovation = IP.id', 'left');
            }

            if (!empty($whereQuery))
                $query = $this->db->get_where('innovation_pool IP', $whereQuery);
            else
                $query = $this->db->get('innovation_pool IP');
        } else {
            $program_type = 'Livelihoods';
            $this->db->select("CONCAT(IP.copy_id,'_',IP.partner_id,'_',IP.partner_count) as Innovation_id,IP.copy_id,IP.name_of_entrepreneur as Name_of_Entrepreneur,IP.name_of_enterprise as Name_of_Enterprise,
                IP.email_id as Email,IP.mobile_no as Mobile_number,pitch_user.altmobileno as Alternate_mobile,
                IF(IP.program=1 ,'EIR', IF(IP.program=2 , 'SEED', IF(IP.program=3, 'Unc Pitch','Incubation'))) as Program, pitch_user.beneficiary as Product_beneficiary,
                IP.stage as Stage,IP.status as Status, MS.master_name as Closed_Reasons, IP.comments as Closed_Comments,pitch_user.enterprise_registered_under as Enterprise_type,
                pitch_user.components as Product_components, pitch_user.city as City,pitch_user.other_city as Other_City, pitch_step2.website as Company_Website,
                SC.sector as Sector,pitch_step2.operation_stage as Stage_of_operation, pitch_step2.product_test_details as Tested_your_products,
                pitch_step2.product_units as Units_of_product,pitch_step2.incorporation_year as Year_of_incorporation, pitch_step2.fy_18_19 as 2018_19_revenue,
                pitch_step2.fy_17_18 as 2017_18_revenue, pitch_step2.fy_16_17 as 2016_17_revenue, pitch_step2.fy_15_16 as 2015_16_revenue, pitch_step2.fy_14_15 as 2014_15_revenue,
                CONCAT(UCASE(LEFT(pitch_step2.fund, 1)),SUBSTRING(pitch_step2.fund, 2)) as Have_you_raised_funding,
                pitch_step2.fund_raised_amount as Amount_of_fund_raised,pitch_step2.last_fund_desc as Last_raise_funding,
                pitch_step2.addr_problem as Briefly_explain_the_specific_problem,pitch_step2.quest_1 as Describe_your_idea_product_or_service,
                pitch_step2.inclusion_strategy as Describe_your_organization_inclusion_strategies, pitch_step2.accelerate_type as Incubated_or_accelerated_by_any_institution,
                pitch_step2.incubated_accelerated as Details_of_incubated_or_accelerated, pitch_step2.info_about_program as How_did_you_hear_about_program,
                pitch_step2.partner_name as Other_mailers_newsletter,pitch_step2.referral_name as Referral_name, awd.doc1 as link1, awd.doc2 as link2
                ");
            $this->db->select("(select GROUP_CONCAT(CONCAT_WS(' ',emp.emp_firstname,emp.emp_lastname)) as employees from " . $this->hris->database . ".hs_hr_employee emp
                Join assign_associate AA1 ON emp.emp_number = AA1.associate_employee where IP.id = AA1.innovation  group by AA1.innovation ) as Assigned_Incharge", false);
            $this->db->select("ROUND(AVG(total_score),2) AS PA_RD_Score");
            $this->db->select("ROUND(AVG(total_per),2) AS PA_RD_Score_Percentage");
            $this->db->select("(select GROUP_CONCAT(DFM.name SEPARATOR ',') as donor from donor_fit_master as DFM where find_in_set(DFM.id, GF.donor_fit) !=0 group by GF.id) as Donors", false);
            $this->db->select('pitch_user.pitch_id');
            $this->db->select("DATE_FORMAT(IFNULL(IFNULL(pitch_user.submitted_date, INV.submitted_date),eir.date_submitted), '%d-%b-%y') AS Submitted_Date");

            $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
            $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
            $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
            $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
            $this->db->join('master_settings MS', 'MS.id = IP.reasons', 'left');
            $this->db->join('assest_detail AD', 'AD.innovation_id = IP.id', 'left');
            $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
            $this->db->join('pitch_user', 'pitch_user.inno_id = IP.innovation_id', 'inner');
            $this->db->join('pitch_step1_info', 'pitch_step1_info.pitch_id=pitch_user.pitch_id', 'left');
            $this->db->join('pitch_step2', 'pitch_step2.pitch_id=pitch_user.pitch_id', 'left');
            $this->db->join('sector_category SubCat', 'SubCat.id =  pitch_step2.sub_sector', 'left');
            $this->db->join('inv_additional_info iaf ', 'iaf.inv_user_id=INV.id', 'left');
            $this->db->join('inv_ent_info iet ', 'iet.inv_user_id=INV.id', 'left');
            $this->db->join('inv_impact imt ', 'imt.inv_user_id=INV.id', 'left');
            $this->db->join('eir_user eir', 'eir.innovation_no = IP.innovation_id', 'left');
            $this->db->join('inv_member inv_mem', 'inv_mem.inv_user_id = INV.id', 'left');
            $this->db->join('award_share awd', 'awd.pitch_id = pitch_user.pitch_id', 'left');


            $this->db->join('(SELECT innovation_id, id, fstage, donor_fit, LIS
                FROM grading_feedback AS ga
                INNER JOIN (
                SELECT max( id ) AS maxid
                FROM grading_feedback
                GROUP BY innovation_id
            ) AS gb ON ga.id = gb.maxid) as GF', 'GF.innovation_id=IP.id', 'left');
            $this->db->distinct();
            $this->db->group_by('IP.innovation_id');
            if (isset($options['innovation_score'])) {
                $this->db->select('INS.*');
                $this->db->join('innovation_score INS', 'INS.innovation = IP.id', 'left');
            }

            if (!empty($whereQuery))
                $query = $this->db->get_where('innovation_pool IP', $whereQuery);
            else
                $query = $this->db->get('innovation_pool IP');
        }

        $csvContent = $this->dbutil->csv_from_result_deals_export($query, $program_type);

        if (!write_file("export.csv", $csvContent)) {
            echo 'Unable to write the file';
        } else {
            $data = file_get_contents("export.csv");
            force_download("export.csv", $data);
            echo "ok";
        }
    }

    function innovation_pool1($currentTab = '') {
        $offset = 4;
        if ($currentTab == '') {
            if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')))
                $currentTab = 'all';
            if ($this->session->userdata('user_name') == 'Altacit') {
                $currentTab = 'identified';
            } else
            $currentTab = 'assigned';
        }
        $data['currentTab'] = $currentTab;

        $options = $this->make_filter($currentTab);
        if ($currentTab == 'similar') {
            $offset = 5;
            $data['name_of_enterprise'] = $options['name_of_enterprise'];
        }
#Pagination Scripts Starts
        $config = array('base_url' => site_url('scouting/innovation_pool/' . $currentTab),
            'per_page' => '15',
            'total_rows' => $this->Minnovation->getPageCount($options),
            'num_links' => 10,
            'uri_segment' => $offset);
        $this->pagination->initialize($config);
#pagination Ends
        $data['emplist'] = $this->Muser->getUsersList();
        $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');
        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');
        $data['reportsList'] = $this->Mreports->getReportsByType('innovation');
        $data['orderby'] = $this->input->post('orderby');
        $data['ordertype'] = $this->input->post('ordertype');
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['status'] = $this->Minnovation->getInnvationStatus();
        $data['innovationList'] = $this->Minnovation->getLimitRecords($options);
        $this->load->model('master/Mmaster');
        $userSetup = $this->Mmaster->getUserSetup();
        $this->load->model('login/Muser');
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        echo 'usersList :';
        var_dump($data['usersList']);
        $data['usersListEmployee'] = $this->Muser->getUsersListNotAbi($userSetup['abi']);
        echo 'usersEmployee :';
        var_dump($data['usersListEmployee']);
        $data['users'] = php72_array_merge($data['usersList'], $data['usersListEmployee']);

        $this->load->model('master/Mstageefficiency');
        $data['timelimit'] = $this->Mstageefficiency->getMaxDays();
        $data['stagedate'] = $this->Mstageefficiency->getStageDate();

        if (!empty($options['export']))
            $this->export_innovation($options);

        if ($this->input->post('txtExport')) {
            $this->innovation_download($options);
        }

        $data['cpagetitle'] = "Innovation Pool";
        $data['cpage'] = "innovation_pool1";
        $data['custom_js'] = array('list_page', 'innovation_pool');
        if ($this->session->userdata('user_type') != 'incubatee') {
            $data['left_box'] = array('innovation_pool');
        }
        $this->load->vars($data);
        $this->load->view('../template');
    }

    function export_innovation($options = array()) {
        $options['num'] = '';
        $options['offset'] = '';
        $options['orderby'] = '';
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['status'] = $this->Minnovation->getInnvationStatus();
        $this->load->model('Minnovation_reports');
        $reportData = $this->Minnovation_reports->getLimitReportRecords($options);
        if (php72_count($reportData)) {
            foreach ($reportData as $r):
                $r['stage'] = $data['stage'][$r['stage']];
                $r['status'] = $data['status'][$r['status']];
                $reportArray[] = $r;
            endforeach;
            $this->Mexport->export($reportArray, $options['export']);
        }
        else {
            $data['errorMsg'] = "No Matched records found!";
        }
    }

    /* INNOVATION DETAILS */

    function innovation_details_old($id = '') {
        $data['innovation'] = $this->Minnovation->getInnovation($id);

        $this->load->model('Mcycle');
        $data['cycle'] = $this->Mcycle->getIncubationCycle($id);

        $data['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($id);
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['status'] = $this->Minnovation->getInnvationStatus();
        $data['cpagetitle'] = "Innovation Details";
        #echo$innovationDetails[0]['program'];die;
        if ($innovationDetails[0]['program'] == '1') {
            $this->load->model('eirmodel');
            $data['files'] = $this->eirmodel->eir_file($innovationDetails[0]['id']);
            $data['eir_user'] = $this->Minnovation->get_user_eir($innovationDetails[0]['id']);
            $data['eir_team'] = $this->Minnovation->getTeam($innovationDetails[0]['id']);

            $data['eir_detail'] = $this->Minnovation->getEIR($innovationDetails[0]['id']);
            $data['cpage'] = "eir_details";
        } else if ($innovationDetails[0]['program'] == '2') {
            $data['step1'] = $step1 = $this->Minnovation->get_seed('seed_step1', $innovationDetails[0]['innovation_id']);
            $data['member'] = $this->Minnovation->get_seed(' seed_step1_member', $step1[0]['app_id']);
            $data['step2'] = $this->Minnovation->get_seed(' seed_step2', $step1[0]['app_id']);
            $data['step3'] = $this->Minnovation->get_seed(' seed_step3', $step1[0]['app_id']);
            $data['cpage'] = "seed_detail";
        } else if ($innovationDetails[0]['program'] == '3' || $innovationDetails[0]['program'] == '4') {
            $branch_id = $this->session->userdata('partner_id');
            $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
            $data['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
            $data['pitch_user'] = $this->Minnovation->get_pitch('pitch_user', "INV" . $innovationDetails[0]['id']);
            $data['pitch_member'] = $this->Minnovation->get_pitch('pitch_step1_members', $data['pitch_user'][0]['pitch_id']);
            $data['pitch_org'] = $this->Minnovation->get_pitch('pitch_step2', $data['pitch_user'][0]['pitch_id']);
            $data['pitch_doc'] = $this->Minnovation->get_pitch('award_share', $data['pitch_user'][0]['pitch_id']);

            $data['pitch_info'] = $this->Minnovation->get_pitch('pitch_step1_info', $data['pitch_user'][0]['pitch_id']);
            $data['cpage'] = "pitch_detail";
        } else if ($innovationDetails[0]['program'] == '0') {
            $data['inv_user'] = $this->Minnovation->get_innovation('inv_user', "INV" . $innovationDetails[0]['id']);
            $sector = $data['inv_user'][0]['ent_sector'];

            if ($sector != 'MCH' && $sector != 'Maternal & child health') {
                $data['inv_team'] = $this->Minnovation->get_innovation('inv_member', $data['inv_user'][0]['id']);
                $data['inv_ent_info'] = $this->Minnovation->get_innovation('inv_ent_info', $data['inv_user'][0]['id']);
                $data['inv_impact'] = $this->Minnovation->get_innovation('inv_impact', $data['inv_user'][0]['id']);
                $data['add_info'] = $this->Minnovation->get_innovation('inv_additional_info', $data['inv_user'][0]['id']);
                $data['sector_name'] = $this->Minnovation->getSectorNamePitch($sector);
            } else {
                $data['mch_users'] = $this->Minnovation->get_innovation('mch_users', $data['inv_user'][0]['id']);
            }
            $branch_id = $this->session->userdata('partner_id');
            $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
            $data['userbranch'] = $this->Mmaster->getYbranch($branch_id);
            $data['usersABIList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
            $data['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
            if (!empty($data['inv_user'])) {
                $data['cpage'] = "inv_detail";
            } else {
                $data['cpage'] = "innovation_details";
            }
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

        if ($this->session->userdata('user_type') != 'incubatee')
            $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array();
        #echo'<pre>';print_r($data);die;
        $this->load->vars($data);
        $this->load->view('../template');
    }

    function innovation_details($id = '') {

        #error_reporting(-1);
        #header('Content-type: text/html; charset=UTF-8');
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        if ($this->session->userdata('independent_shortlist') == 1 && $this->session->userdata('role_id') == 4) {
            $emp_comment = $this->session->userdata['emp_number'];
        } else {
            $emp_comment = '';
        }
        $data['shortlist_comment'] = $this->Minnovation->getShortlistComments($id, $emp_comment);
        $data['application_id'] = $id;
        $this->load->model('Mcycle');
        $data['cycle'] = $this->Mcycle->getIncubationCycle($id);

        $data['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($id);
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['status'] = $this->Minnovation->getInnvationStatus();
        $data['cpagetitle'] = "Innovation Details";
        if ($innovationDetails[0]['program'] == '1') {
            $this->load->model('eirmodel');
            $data['files'] = $this->eirmodel->eir_file($innovationDetails[0]['id']);
            $data['eir_user'] = $this->Minnovation->get_user_eir($innovationDetails[0]['id']);
            $data['eir_team'] = $this->Minnovation->getTeam($innovationDetails[0]['id']);

            $data['eir_detail'] = $this->Minnovation->getEIR($innovationDetails[0]['id']);
            $data['cpage'] = "eir_details";
        } else if ($innovationDetails[0]['program'] == '2') {
            $data['step1'] = $step1 = $this->Minnovation->get_seed('seed_step1', $innovationDetails[0]['innovation_id']);
            $data['member'] = $this->Minnovation->get_seed(' seed_step1_member', $step1[0]['app_id']);
            $data['step2'] = $this->Minnovation->get_seed(' seed_step2', $step1[0]['app_id']);
            $data['step3'] = $this->Minnovation->get_seed(' seed_step3', $step1[0]['app_id']);
            $data['cpage'] = "seed_detail";
        } else if ($innovationDetails[0]['program'] == '3' || $innovationDetails[0]['program'] == '4') {
            $branch_id = $this->session->userdata('partner_id');
            $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
            $data['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
            $data['pitch_user'] = $this->Minnovation->get_pitch('pitch_user', "INV" . $innovationDetails[0]['id']);
            $data['pitch_member'] = $this->Minnovation->get_pitch('pitch_step1_members', $data['pitch_user'][0]['pitch_id']);
            $data['pitch_org'] = $this->Minnovation->get_pitch('pitch_step2', $data['pitch_user'][0]['pitch_id']);
            $data['pitch_doc'] = $this->Minnovation->get_pitch('award_share', $data['pitch_user'][0]['pitch_id']);

            $data['pitch_info'] = $this->Minnovation->get_pitch('pitch_step1_info', $data['pitch_user'][0]['pitch_id']);
            $data['cpage'] = "pitch_detail";
        } else if ($innovationDetails[0]['program'] == '0') {
            $data['inv_user'] = $this->Minnovation->get_innovation('inv_user', "INV" . $innovationDetails[0]['id']);
            $sector = $data['inv_user'][0]['ent_sector'];

            if ($sector != 'MCH' && $sector != 'Maternal & child health') {
                $data['inv_team'] = $this->Minnovation->get_innovation('inv_member', $data['inv_user'][0]['id']);
                $data['inv_ent_info'] = $this->Minnovation->get_innovation('inv_ent_info', $data['inv_user'][0]['id']);
                $data['inv_impact'] = $this->Minnovation->get_innovation('inv_impact', $data['inv_user'][0]['id']);
                $data['add_info'] = $this->Minnovation->get_innovation('inv_additional_info', $data['inv_user'][0]['id']);
                $data['sector_name'] = $this->Minnovation->getSectorNamePitch($sector);
            } else {
                $data['mch_users'] = $this->Minnovation->get_innovation('mch_users', $data['inv_user'][0]['id']);
            }
            $branch_id = $this->session->userdata('partner_id');
            $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
            $data['userbranch'] = $this->Mmaster->getYbranch($branch_id);
            $data['usersABIList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
            $data['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
            if (!empty($data['inv_user'])) {
                $data['cpage'] = "inv_detail";
            } else {
                $data['cpage'] = "innovation_details";
            }
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

        $lang_code = $this->uri->segment(4);
        if ($lang_code == 'hi') {
            $data['cpage'] = "pitch_detail_hi";
        }

        #echo'<pre>';print_r($data);die;
        if ($this->session->userdata('user_type') != 'incubatee')
            $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array();
        $this->load->vars($data);
        $this->load->view('../template');
    }

    /* SHORTLIST COMMENTS INSERT */

    function saveshortlist_comments() {

        $data['inv_id'] = $inv = $_POST['application_id'];
        $data['partner_id'] = $this->session->userdata('partner_id');
        $data['application_type'] = $_POST['application_type'];
        $data['application_status'] = $crr_status = $_POST['comments_status'];
        $data['comments'] = $_POST['shortlist_comment'];
        $data['created_date'] = date('Y-m-d H:i:s');
        $data['created_by'] = $empid = $this->session->userdata['emp_number'];
        $data['status'] = 1;

        $result = $this->Minnovation->insert_shortlistcomments($data);
        if ($result) {
            $options['inv_id'] = $inv;
            $options['created_by'] = $empid;
            $this->Minnovation->update_shortlistcomments($crr_status, $options);
            redirect('scouting/innovation_details/' . $_POST['application_id']);
        }
    }

    /* INNOVATION SUPPORTING DOCUMENTS */

    function innovation_document($id = '') {
        $this->load->model('Msupporting_documents');
        $data['innovation'] = $innovation = $this->Minnovation->getInnovation($id);
        $data['upload_error'] = array();
        if ($this->input->post('txtSubmit') != '') {
            if (($_FILES['document']['name'] != '' || $_POST['youtube'] != '') && $_POST['document_type'] != '') {
                if ($_FILES['document']['name'] != '') {
                    $config['upload_path'] = './uploads/innovaton/supporting_documents';
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $innovation['name_of_enterprise'] . "-supporting_document-" . str_replace(' ', '_', $_FILES['document']['name']);
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('document'))
                        $data['upload_error'] = $this->upload->display_errors();
                    else {
                        $upload_data = $this->upload->data();
                        $_POST['document'] = $upload_data['file_name'];
                    }
                    $res = $this->Msupporting_documents->insertSingleDocument($id, $_POST);
                    if ($res) {
                        $data['successMsg'] = "Record Inserted Successfully";
                    } else {
                        $this->session->set_flashdata('errorMsg', 'File Upload Limit Exceeds');
                    }
                } else {
                    $_POST['document'] = '';
                }
                $data['successMsg'] = "Record Inserted Successfully";
            } else
            $data['errorMsg'] = "Validation Error! Please Select file or Youtube";
        }
        $data['documentList'] = $this->Msupporting_documents->getInnovationDocuments($id);
        $data['documentTypeList'] = $this->Mmaster_settings->getMasterSetting('Document Checklist');
        $data['cpagetitle'] = "Innovation Supporting Documents";
        $data['cpage'] = "innovation_document";

        $data['custom_js'] = array('supporting_documents');
        $this->load->vars($data);
        $this->load->view('../template_iframe');
    }

    function delete_document($id = '', $rid = '') {
        $this->load->model('Msupporting_documents');
        if ($rid != '') {
            $docInfo = $this->Msupporting_documents->getInnovationDocuments($id, $rid);
            if (php72_count($docInfo)) {
                $file_path = 'uploads/innovaton/supporting_documents/' . $docInfo['0']['document'];
                if (file_exists($file_path))
                    unlink($file_path);
                $this->Msupporting_documents->deleteDocument($rid);
                $this->session->set_flashdata('successMsg', 'Document Deleted Successfully!');
            }
        }
        redirect('scouting/innovation_document/' . $id);
    }

    /* ACTION FOR INNOVATION */

    function action_old($action, $id) {
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        switch ($action) {
            case 'hold':
            $status = '2';
            $reason = 'Onhold Reasons';
            break;
            case 'follow':
            $status = '1';
            $reason = 'Follow Reasons';
            break;
            case 'close':
            $status = '3';
            $reason = 'Reject Reasons';
            $user_data = array(
                'close_status' => $data['innovation']['status'],
                'reopen_status' => '0'
            );
            $user_where = array('id' => $id);
            $table = "innovation_pool";
            $this->Minnovation->pitch_update($table, $user_data, $user_where);
            break;
            case 'resume':
            $get_table = "grading_feedback";
            $feedback = $this->Minnovation->get_innovation($get_table, $id);
            if ($feedback[0]['result'] == 'Reject') {
                $feed_where = array('innovation_id' => $id);
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
                    $status = '12'; // Open Status
                }


                $log_status = '19';
                $reason = 'Resume Reasons';
                $user_data = array(
                    'reopen_status' => '1'
                );
                $user_where = array('id' => $id);
                $table = "innovation_pool";
                $this->Minnovation->pitch_update($table, $user_data, $user_where);
                break;
            }
            if ($reason == 'Reject Reasons') {
                $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting($reason, $data['innovation']['partner_id']);
            } else {
                $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting($reason);
            }
            if ($this->input->post('txtSubmit') != '') {
                $ids = $data['innovation']['id'];
                $employees = $this->Sector_model->getEmpId($ids);

                $emp_Ids = php72_array_map(function ($emp_Ids) {
                    return $emp_Ids['associate_employee'];
                }, $employees);
                $employees_id = rtrim(implode(',', $emp_Ids), ',');

                $log_data = array(
                    'innovation_id' => $data['innovation']['id'],
                    'stage' => $data['innovation']['stage'],
                    'assigned_user' => $employees_id,
                    'modified_by' => $this->session->userdata['emp_number'],
                    'modified_date' => date('Y-m-d H:i:s')
                );
                if ($log_status == '19') {
                    $log_data['status'] = $log_status;
                } else {
                    $log_data['status'] = $status;
                }

                $table_log = "application_status_log";
                $result = $this->Minnovation->pitch_insert($table_log, $log_data);

                $this->Minnovation->updateComments($id, $_POST, $status);
                $this->Minnovation->changeStatus($id, $status);
                $this->session->set_flashdata('successMsg', 'Status Changed successfully!');
                if ($action == 'close') {
                    $this->session->set_userdata('close_action', 'yes');
                }
                redirect('scouting/innovation_details/' . $id);
            }
            $data['action'] = $action;
            $data['cpagetitle'] = '';
            $data['cpage'] = "action";
            $this->load->vars($data);
            $this->load->view('../template_plain');
        }

        function action($action, $id, $status) {
            $data['innovation'] = $this->Minnovation->getInnovation($id);
            $data['status_id'] = $status;
            switch ($action) {
                case 'hold':
                $status = '2';
                $reason = 'Onhold Reasons';
                break;
                case 'follow':
                $status = '1';
                $reason = 'Follow Reasons';
                break;
                case 'close':
                $status = '3';
                $hid_status = $this->input->post('status');
                if ($hid_status == '24') {
                    $status = $hid_status;
                } else {
                    $reason = 'Reject Reasons';
                    $user_data = array(
                        'close_status' => $data['innovation']['status'],
                        'reopen_status' => '0'
                    );
                    $user_where = array('id' => $id);
                    $table = "innovation_pool";
                    $this->Minnovation->pitch_update($table, $user_data, $user_where);
                }
                break;
                case 'resume':
                $get_table = "grading_feedback";
                $feedback = $this->Minnovation->get_innovation($get_table, $id);
                if ($feedback[0]['result'] == 'Reject') {
                    $feed_where = array('innovation_id' => $id);
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
                    $status = '12'; // Open Status
                }


                $log_status = '19';
                $reason = 'Resume Reasons';
                $user_data = array(
                    'reopen_status' => '1'
                );
                $user_where = array('id' => $id);
                $table = "innovation_pool";
                $this->Minnovation->pitch_update($table, $user_data, $user_where);
                break;
            }
            if ($reason == 'Reject Reasons') {
                $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting($reason, $data['innovation']['partner_id']);
            } else {
                $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting($reason);
            }
            if ($this->input->post('txtSubmit') != '') {
                $ids = $data['innovation']['id'];
                $employees = $this->Sector_model->getEmpId($ids);

                $emp_Ids = php72_array_map(function ($emp_Ids) {
                    return $emp_Ids['associate_employee'];
                }, $employees);
                $employees_id = rtrim(implode(',', $emp_Ids), ',');

                $log_data = array(
                    'innovation_id' => $data['innovation']['id'],
                    'stage' => $data['innovation']['stage'],
                    'assigned_user' => $employees_id,
                    'modified_by' => $this->session->userdata['emp_number'],
                    'modified_date' => date('Y-m-d H:i:s')
                );
                if ($log_status == '19') {
                    $log_data['status'] = $log_status;
                } else {
                    $log_data['status'] = $status;
                }
                $status_type = $this->input->post('status');
                if ($status_type == '24') {
                    $log_data['status'] = $status_type;
                }
                $table_log = "application_status_log";
                $result = $this->Minnovation->pitch_insert($table_log, $log_data);

                $this->Minnovation->updateComments($id, $_POST, $status);
                $this->Minnovation->changeStatus($id, $status);

            #echo'<pre>';print_r($_POST); echo'<pre>';print_r($log_data);echo'<pre>';print_r($status);die;
                $this->session->set_flashdata('successMsg', 'Status Changed successfully!');
                if ($action == 'close') {
                    $this->session->set_userdata('close_action', 'yes');
                }
                redirect('scouting/innovation_details/' . $id);
            }
        #echo'<pre>';print_r($data);die;
            $data['action'] = $action;
            $data['cpagetitle'] = '';
            $data['cpage'] = "action";
            $this->load->vars($data);
            $this->load->view('../template_plain');
        }

        function action_history($innovation) {
            $data['innovation'] = $this->Minnovation->getInnovation($innovation);
            $data['stage'] = $this->Minnovation->getInnvationStage();
            $data['status'] = $this->Minnovation->getInnvationStatus();
            $data['historyList'] = $this->Minnovation->getActionHistory($innovation);
            $data['cpagetitle'] = '';
            $data['cpage'] = "action_history";
            $this->load->vars($data);
            $this->load->view('../template_plain');
        }

        /* ASSIGN ASSOCIATE FOR INNOVATION */

        function assign_incharge($id) {
            $this->load->model('Mincharge');
            $data['innovation'] = $this->Minnovation->getInnovation($id);
            $data['inchargeList'] = $this->Mincharge->getAssociate(array('innovation' => $id));

            if (isset($_POST['txtSubmit'])) {
                if ($this->input->post('associate_employee') != '') {
                    $this->Mincharge->assignIncharge($id);
                    if ($data['innovation']['status'] == '0')
                        $this->Minnovation->changeStatus($id, '13');
                    if ($data['innovation']['stage'] == '0')
                        $this->Minnovation->changeStage($id, '8');
                    $this->session->set_flashdata('successMsg', 'Associate: Business Incubation assigned successfully! ');
                }
                else {
                    $this->session->set_flashdata('errorMsg', 'Error!, Please Select Employee');
                }
                redirect('scouting/innovation_details/' . $id);
            }

            $this->load->model('master/Mmaster');
            $this->load->model('login/Muser');
            $branch_id = $this->session->userdata('partner_id');
            $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
            $data['userbranch'] = $this->Mmaster->getYbranch($branch_id);
            $data['usersABIList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);
            $data['usersList'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);

            $data['cpagetitle'] = "Associate: Business Incubation";
            $data['cpage'] = "assign_incharge";
            $this->load->vars($data);
            $this->load->view('../template_plain');
        }

        function change_associate_status($id, $status, $innovation = '') {
            $this->load->model('Mincharge');
            $this->Mincharge->changeAssociateStatus($id, $status);
            $this->session->set_flashdata('successMsg', 'Associate Member Status Updated');
            redirect('scouting/innovation_details/' . $innovation);
        }

        function assignInchargeInView() {

            $partner_id = $this->session->userdata['partner_id'];
            $employee = array();
            $employee = $_POST['associate_employee'];

            $ids = $_POST['innovations'];
            $innovationDetails = $this->Minnovation->getInnovation($ids);

            $acnt = php72_count($employee);

            if ($acnt) {
                $this->Mincharge->removeOldIncharge($ids);
                for ($i = 0; $i < $acnt; $i++) {
                    $this->Mincharge->assignmulincharge($ids, $employee, $partner_id);
                    $this->Minnovation->approve_scoring($ids, '12');
                }
            }
            $employees = $this->Sector_model->getEmpId($ids);

            $emp_Ids = php72_array_map(function ($emp_Ids) {
                return $emp_Ids['associate_employee'];
            }, $employees);
            $employees_id = rtrim(implode(',', $emp_Ids), ',');

            $log_data = array(
                'innovation_id' => $_POST['innovations'],
            'stage' => 8, //PA/RD stage
            'status' => $innovationDetails['status'],
            'assigned_user' => $employees_id,
            'modified_by' => $this->session->userdata['emp_number'],
            'modified_date' => date('Y-m-d H:i:s')
        );

            $table_log = "application_status_log";
            $result = $this->Minnovation->pitch_insert($table_log, $log_data);

            redirect('scouting/innovation_details/' . $_POST['innovations'] . '');
        }

        /* ASSIGN INCUBATION CYCLE */

        function cycle($id) {
            $data['innovationDetails'] = $innovation = $this->Minnovation->getInnovation($id);
            if ($this->input->post('txtSubmit') != '') {
                $this->load->model('Mcycle');
                $this->Mcycle->updateCycle($id, $_POST);
                if ($innovation['stage'] == '2')
                    $this->Minnovation->changeStage($id, '4');
                $this->session->set_flashdata('successMsg', 'Incubation Cycle Assigned successfully!');
                redirect('scouting/innovation_details/' . $id);
            }
            $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');
            $data['cpagetitle'] = 'Assign Cycle';
            $data['cpage'] = "assign_cycle";
            $this->load->vars($data);
            $this->load->view('../template_plain');
        }

        function multi_cycle($id = NULL) {
            if ($this->input->post('txtSubmit') != '') {
                $this->load->model('Mcycle');
                $innovation = $_POST['innovation'];
                $innovationarr = explode(",", $innovation);
                if (is_array($innovationarr)) {
                    foreach ($innovationarr as $value) {
                        $innovation = $this->Minnovation->getInnovation($id);
                        $this->Mcycle->updateCycle($id, $_POST);
                        if ($innovation['stage'] == '2')
                            $this->Minnovation->changeStage($id, '4');
                    }
                }
                $this->session->set_flashdata('successMsg', 'Incubation Cycle Assigned successfully!');
                redirect('scouting/innovation_pool/');
            }
            $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');
            $data['cpagetitle'] = '';
            $data['cpage'] = "assign_multi_cycle";
            $this->load->vars($data);
            $this->load->view('../template_plain');
        }

        function cycle_history($id) {
            $this->load->model('Mcycle');
            $data['innovation'] = $this->Minnovation->getInnovation($id);
            $data['historyList'] = $this->Mcycle->getCycleHistory($id);
            $data['cpagetitle'] = 'Incubation Cycle History';
            $data['cpage'] = "cycle_history";
            $this->load->vars($data);
            $this->load->view('../template_plain');
        }

        function delete($id) {
            $result = $this->Minnovation->deleteinnovation($id);
            if ($result) {
                $this->session->set_flashdata('successMsg', 'Innovation Deleted Successfully');
                echo "successMsg";
            } else {
                $this->session->set_flashdata('errorMsg', 'Innovation Not Deleted Successfully');
                echo "errorMsg";
            }
        }

        function old_innovation() {
            $offset = 3;
            $searchArray = array();
            $options['num'] = '15';
            $options['offset'] = $this->uri->segment($offset);

            if ($this->input->post('name_of_entrepreneur') != "")
                $searchArray[] = "`Name of the Promoter` like '%" . $this->input->post('name_of_entrepreneur') . "%'";
            if ($this->input->post('name_of_enterprise') != "")
                $searchArray[] = "`Name of your Enterprise` like '%" . $this->input->post('name_of_enterprise') . "%'";
            if ($this->input->post('summary_business') != "")
                $searchArray[] = "`Summary` like '%" . $this->input->post('summary_business') . "%'";
            if ($this->input->post('website') != "")
                $searchArray[] = "`website` = '" . $this->input->post('website') . "'";
            if ($this->input->post('status') != "")
                $searchArray[] = "`status` like '%" . $this->input->post('status') . "%'";

            $where = implode(" and ", $searchArray);
            $data['innovationlist'] = $this->Minnovation->getoldinnovation($where, $options);
        /* echo $where;
          echo'<pre>';print_r($options);
          echo'<pre>';print_r($data['innovationlist']);die; */
          $config = array('base_url' => site_url('scouting/old_innovation/'),
            'per_page' => '10',
            'total_rows' => $this->Minnovation->getoldcount($where),
            'num_links' => 10,
            'uri_segment' => $offset);

          $this->pagination->initialize($config);
          $data['cpage'] = 'old_innovations';
          $data['cpagetitle'] = 'Innovation List';
          $this->load->view('../dashboard_template', $data);
      }

      function old_innovations() {
        $offset = 3;
        $options['num'] = '10';
        $searchArray = array();
        $options['offset'] = $this->uri->segment($offset);

        if ($this->input->post('name') != "") {
            $searchArray[] = " `Name of the Proposer` like '%" . $this->input->post('name') . "%'";
            $data['name'] = $this->input->post('name');
        }
        if ($this->input->post('enterprise') != "") {
            $searchArray[] = " `Proposal` like '%" . $this->input->post('enterprise') . "%'";
            $data['enterprise'] = $this->input->post('enterprise');
        }
        if ($this->input->post('sector') != "") {
            $searchArray[] = " `Sector` like '%" . $this->input->post('sector') . "%'";
            $data['sector'] = $this->input->post('sector');
        }
        if ($this->input->post('summary') != "") {
            $searchArray[] = "`N` like '%" . $this->input->post('summary') . "%'";
            $data['summary'] = $this->input->post('summary');
        }

        $where = implode(" and ", $searchArray);
        $config = array('base_url' => site_url('scouting/old_innovations/'),
            'per_page' => '10',
            'total_rows' => $this->Minnovation->getoldcounts($where),
            'num_links' => 10,
            'uri_segment' => $offset);
        $data['innovationlist'] = $this->Minnovation->getoldinnovations($where, $options);
        $this->pagination->initialize($config);
        $data['cpage'] = 'old_innovation';
        $data['cpagetitle'] = 'Innovation List';
        $this->load->view('../dashboard_template', $data);
    }

    function oldinnovation() {

        $offset = 3;
        $options['num'] = '10';
        $searchArray = array();
        $options['offset'] = $this->uri->segment($offset);


        if ($this->input->post('name') != "") {
            $searchArray[] = " `Name of the Proposer` like '%" . $this->input->post('name') . "%'";
            $data['name'] = $this->input->post('name');
        }
        if ($this->input->post('enterprise') != "") {
            $searchArray[] = " `Proposal` like '%" . $this->input->post('enterprise') . "%'";
            $data['enterprise'] = $this->input->post('enterprise');
        }
        if ($this->input->post('sector') != "") {
            $searchArray[] = " `Sector` like '%" . $this->input->post('sector') . "%'";
            $data['sector'] = $this->input->post('sector');
        }

        $where = implode(" and ", $searchArray);

        $data['innovationlist'] = $this->Minnovation->getoldinnovationss($where, $options);
        $config = array('base_url' => site_url('scouting/oldinnovation/'),
            'per_page' => '10',
            'total_rows' => $this->Minnovation->getoldcountss($where),
            'num_links' => 10,
            'uri_segment' => $offset);
        $this->pagination->initialize($config);
        $data['cpage'] = 'oldinnovation';
        $data['cpagetitle'] = 'Innovation List';
        $this->load->view('../dashboard_template', $data);
    }

    function assign_multi_incharge() {
        $partner_id = $this->session->userdata['partner_id'];
        $this->load->model('Mincharge');
        $data['innovations'] = $this->Mincharge->getInnovationUncharge();

        if (isset($_POST['txtSubmit'])) {
            $employee = array();
            $employee = $_POST['associate_employee'];
            $ids = array();
            $ids = explode(',', $_POST['innovations']);

            $acnt = count($ids);

            if ($acnt == 1 && $employee != '') {
                $this->Mincharge->removeIncharges($ids);
                for ($i = 0; $i < $acnt; $i++) {
                    $id = $ids[$i];
                    $innovation = $this->Minnovation->getInnovation($id);
                    $this->Mincharge->assignmulincharge($id, $employee, $partner_id);

                    $employees = $this->Sector_model->getEmpId($id);

                    $emp_Ids = php72_array_map(function ($emp_Ids) {
                        return $emp_Ids['associate_employee'];
                    }, $employees);
                    $employees_id = rtrim(implode(',', $emp_Ids), ',');

                    $log_data = array(
                        'innovation_id' => $id,
                        'stage' => $innovation['stage'],
                        'status' => $innovation['status'],
                        'assigned_user' => $employees_id,
                        'modified_by' => $this->session->userdata['emp_number'],
                        'modified_date' => date('Y-m-d H:i:s')
                    );

                    $table_log = "application_status_log";
                    $result = $this->Minnovation->pitch_insert($table_log, $log_data);
                }
                $this->session->set_flashdata('successMsg', 'Associate: Business Incubation assigned successfully!');
                redirect('scouting/innovation_pool/all');
            } else if ($acnt > 1 && $employee != '') {
                for ($i = 0; $i < $acnt; $i++) {
                    $id = $ids[$i];
                    $innovation = $this->Minnovation->getInnovation($id);
                    $assigned_id = $this->Mincharge->getActiveIncharge($id);
                    $assign_combine = php72_array_merge($employee, $assigned_id);
                    array_unique($assign_combine);
                    $this->Mincharge->assignmulincharge($id, $assign_combine, $partner_id);
                    $employees = $this->Sector_model->getEmpId($id);

                    $emp_Ids = php72_array_map(function ($emp_Ids) {
                        return $emp_Ids['associate_employee'];
                    }, $employees);
                    $employees_id = rtrim(implode(',', $emp_Ids), ',');

                    $log_data = array(
                        'innovation_id' => $id,
                        'stage' => $innovation['stage'],
                        'status' => $innovation['status'],
                        'assigned_user' => $employees_id,
                        'modified_by' => $this->session->userdata['emp_number'],
                        'modified_date' => date('Y-m-d H:i:s')
                    );

                    $table_log = "application_status_log";
                    $result = $this->Minnovation->pitch_insert($table_log, $log_data);
                }
                $this->session->set_flashdata('successMsg', 'Associate: Business Incubation assigned successfully!');
                redirect('scouting/innovation_pool/all');
            } else
            $this->session->set_flashdata('errorMsg', 'Error!, Please Select Employee');
            redirect('scouting/innovation_pool/all');
        }
        else {
            echo 'test';
        }
        $this->load->model('master/Mmaster');
        $userSetup = $this->Mmaster->getUserSetup();

        $this->load->model('login/Muser');
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        $data['usersListEmployee'] = $this->Muser->getUsersListNotAbi($userSetup['abi']);

        $data['cpagetitle'] = "Associate: Business Incubation";
        $data['cpage'] = "assign_multiple_incharge";
        $this->load->vars($data);
        $this->load->view('../template');
    }

    function associate_assign_incharge() {
        $partner_id = $this->session->userdata['partner_id'];
        $this->load->model('Mincharge');
        $data['innovations'] = $this->Mincharge->getInnovationUncharge();

        if (isset($_POST['txtSubmit'])) {
            $employee = array();
            $employee = $_POST['associate_employee'];
            $ids = array();
            $ids = explode(',', $_POST['innovations']);

            $acnt = count($ids);

            if ($acnt && $employee != '') {
                $this->Mincharge->removeIncharges($ids);
                for ($i = 0; $i < $acnt; $i++) {
                    $id = $ids[$i];
                    $innovation = $this->Minnovation->getInnovation($id);
                    $this->Mincharge->assignmulincharge($id, $employee, $partner_id);

                    $employees = $this->Sector_model->getEmpId($id);

                    $emp_Ids = php72_array_map(function ($emp_Ids) {
                        return $emp_Ids['associate_employee'];
                    }, $employees);
                    $employees_id = rtrim(implode(',', $emp_Ids), ',');

                    $log_data = array(
                        'innovation_id' => $id,
                        'stage' => $innovation['stage'],
                        'status' => $innovation['status'],
                        'assigned_user' => $employees_id,
                        'modified_by' => $this->session->userdata['emp_number'],
                        'modified_date' => date('Y-m-d H:i:s')
                    );

                    $table_log = "application_status_log";
                    $result = $this->Minnovation->pitch_insert($table_log, $log_data);
                }
                $this->session->set_flashdata('successMsg', 'Associate: Business Incubation assigned successfully! ');
                redirect('login/options/' . $_POST['innovations']);
            } else
            $this->session->set_flashdata('errorMsg', 'Error!, Please Select Employee');
            redirect('login/options/' . $_POST['innovations']);
        }
        else {
            echo 'test';
        }
        $this->load->model('master/Mmaster');
        $userSetup = $this->Mmaster->getUserSetup();

        $this->load->model('login/Muser');
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        $data['usersListEmployee'] = $this->Muser->getUsersListNotAbi($userSetup['abi']);

        $data['cpagetitle'] = "Associate: Business Incubation";
        $data['cpage'] = "assign_multiple_incharge";
        $this->load->vars($data);
        $this->load->view('../template');
    }

    function onlyAssignIncharge() {
        $partner_id = $this->session->userdata['partner_id'];
        $data['innovations'] = $this->Mincharge->getInnovationUncharge();
        $form_type = isset($_POST['form_name']) && $_POST['form_name'] != '' ? $_POST['form_name'] : '';
        if ($form_type == 'dilegence') {
            $redirect_link = "detailed_diligence/dashboard/" . $_POST['innovations'];
        } else {
            $redirect_link = "scouting/innovation_details/" . $_POST['innovations'];
        }

        if (isset($_POST['txtSubmit'])) {
            $employee = array();
            $employee = $_POST['associate_employee'];
            $ids = array();
            $ids = explode(',', $_POST['innovations']);

            $acnt = count($ids);

            if ($acnt && $employee != '') {
                $this->Mincharge->removeIncharges($ids);
                for ($i = 0; $i < $acnt; $i++) {
                    $id = $ids[$i];
                    $pa_rd = 1;
                    $innovation = $this->Minnovation->getInnovation($id);
                    $this->Mincharge->assignmulincharge($id, $employee, $partner_id, $pa_rd);

                    $employees = $this->Sector_model->getEmpId($id);
                    $emp_Ids = php72_array_map(function ($emp_Ids) {
                        return $emp_Ids['associate_employee'];
                    }, $employees);
                    $employees_id = rtrim(implode(',', $emp_Ids), ',');

                    $log_data = array(
                        'innovation_id' => $id,
                        'stage' => $innovation['stage'],
                        'status' => $innovation['status'],
                        'assigned_user' => $employees_id,
                        'modified_by' => $this->session->userdata['emp_number'],
                        'modified_date' => date('Y-m-d H:i:s')
                    );

                    $table_log = "application_status_log";
                    $result = $this->Minnovation->pitch_insert($table_log, $log_data);
                }
                $this->session->set_flashdata('successMsg', 'Associate: Business Incubation assigned successfully! ');
                redirect($redirect_link);
            } else
            $this->session->set_flashdata('errorMsg', 'Error!, Please Select Employee');
            redirect($redirect_link);
        }
        $this->load->model('master/Mmaster');
        $userSetup = $this->Mmaster->getUserSetup();

        $this->load->model('login/Muser');
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        $data['usersListEmployee'] = $this->Muser->getUsersListNotAbi($userSetup['abi']);

        $data['cpagetitle'] = "Associate: Business Incubation";
        $data['cpage'] = "assign_multiple_incharge";
        $this->load->vars($data);
        $this->load->view('../template');
    }

    function getassemployee() {
        $id = $this->input->post('id');
        $this->load->model('Mincharge');
        $data['inchargeList'] = $this->Mincharge->getAssociate(array('innovation' => $id));
        echo json_encode($data['inchargeList']);
    }

    function getSubsector() {
        $id = $this->input->post('sector_id');
        $this->load->model('Mincharge');
        $sub_sectors = $this->Mincharge->getSubsector_ws($id);
        echo json_encode($sub_sectors);
    }
	 function getSubsectorAddDeal() {
        $id = $this->input->post('sector_id');
		
		//set climate action subsector to waste to value
		if($id==195){
			$id = 4;	
		}
        $this->load->model('Mincharge');
        $sub_sectors = $this->Mincharge->getSubsector($id);
        echo json_encode($sub_sectors);
    }


    function getPartner() {
        $id = $this->input->post('id');
        $data['inchargeList'] = $this->Minnovation->PartnerList($id);
        echo json_encode($data['inchargeList']);
    }

    function PartnerId() {
        $id = $this->input->post('branch_name');
        $data['inchargeList'] = $this->Minnovation->PartnerId($id);
        echo json_encode($data['inchargeList']);
    }

    function getPartnerName() {
        $id = $this->input->post('id');
        $pname = $this->Minnovation->Partnername($id);
        echo json_encode($pname);
    }

    function innovation_download($options = array()) {

        $tab = $this->uri->segment(3);
        $this->load->dbutil();
        $this->hris = $this->load->database('hris', TRUE);
        $this->load->model('Minnovation_reports');

        if ($tab == "assigned") {  // for my deals
            $this->load->model('Mincharge');
            $innovation = $this->Mincharge->getAssociateInnovation($this->session->userdata('emp_number'));
            $innovation = (php72_count($innovation)) ? $innovation : array();
            $options['associate'] = $innovation;
            if ($options['stage'] == '')
                $options['sstage'] = '!5'; // incubation stage
            if ($options['status'] == '')
                $options['sstatus'] = '!8'; // incubation status
        }
        if ($tab == 'decision_pending') { // for decision pending
            $options['status'] = '!3';
            $options['grading_status'] = '1';
            $options['decision_status'] = '6';
        }
        $whereQuery = $this->Minnovation_reports->_searchReport($options);
        if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "" && $whereQuery == "")
            $whereQuery = "AA.associate_employee = '" . $options['assigned_incharge'] . "' and AA.status=1";
        else if (isset($options['assigned_incharge']) && $options['assigned_incharge'] != "" && $whereQuery != '')
            $whereQuery .= " and AA.associate_employee = '" . $options['assigned_incharge'] . "' and AA.status=1";

        if (!empty($options['orderby']) && !empty($options['ordertype']))
            $this->db->order_by($options['orderby'], $options['ordertype']);
        else
            $this->db->order_by('submitted_date', 'desc');

        $this->db->select("CONCAT(IP.copy_id,'_',IP.partner_id,'_',IP.partner_count) as Innovation_id,IP.name_of_enterprise as Name_of_the_Enterprise,IP.name_of_entrepreneur as Name_of_Entrepreneur,IP.email_id as Email,IP.mobile_no as Mobile_No,(CASE WHEN (IP.source = '0' || IP.source = '101' || IP.source = '103' || IP.source = '123') THEN 'Website' WHEN (IP.source = '2') THEN 'Imported' ELSE (select CONCAT_WS(' ',emp_firstname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = IP.created_by) END) as Source");
        $this->db->select("IP.sourceName as Source_Name,SC.sector as Sector, IF(IP.program=0 ,InvSubCat.sector, IF(IP.program=3 , PitSubCat.sector, '')) as Sub_Sector, IF(IP.program=1 ,'EIR', IF(IP.program=2 , 'SEED', IF(IP.program=3, 'Unc Pitch','Incubation'))) as Program");
        $this->db->select("IP.country as Country,IP.city as City,pitch_user.other_city as Other_City,IP.stage as Stage,IP.status as Status");
        $this->db->select("(select branch_name from  " . $this->hris->database . ".hs_hr_branch where id = IP.partner_id) as Partner");
        $this->db->select("(select GROUP_CONCAT(CONCAT_WS(' ',emp.emp_firstname,emp.emp_lastname)) as employees from " . $this->hris->database . ".hs_hr_employee emp
            Join assign_associate AA1 ON emp.emp_number = AA1.associate_employee where IP.id = AA1.innovation and AA1.status = 1 group by AA1.innovation ) as Assigned_Incharge", false);
        $this->db->select("IP.other_partner_id as Applied_to_Partners");
        $this->db->select("DATE_FORMAT(IP.created_date, '%d-%b-%y') as Registered_Date");
        $this->db->select('INV.id, pitch_user.pitch_id');
        $this->db->select("DATE_FORMAT(IFNULL(IFNULL(pitch_user.submitted_date, INV.submitted_date),eir.date_submitted), '%d-%b-%y') AS Submitted_Date ");
        $this->db->join('pitch_user', 'IP.innovation_id=pitch_user.inno_id', 'left');
        $this->db->join('pitch_step2', 'pitch_step2.pitch_id=pitch_user.pitch_id', 'left');
        $this->db->join('source_master SM', 'IP.source = SM.id', 'left');
        $this->db->join('instance_master IM', 'IP.instance = IM.id', 'left');
        $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
        $this->db->join('eir_user eir', 'eir.innovation_no = IP.innovation_id', 'left');
        $this->db->join('inv_additional_info iaf ', 'iaf.inv_user_id=INV.id', 'left');
        $this->db->join('inv_ent_info iet ', 'iet.inv_user_id=INV.id', 'left');
        $this->db->join('assign_associate AA', 'AA.innovation =  IP.id', 'left');
        $this->db->join('sector_category SC', 'SC.id =  IP.sector', 'left');
        $this->db->join('sector_category InvSubCat', 'InvSubCat.id =  INV.sub_sector', 'left');
        $this->db->join('sector_category PitSubCat', 'PitSubCat.id =  pitch_step2.sub_sector', 'left');
        $this->db->join('(SELECT innovation_id, id, fstage, donor_fit, LIS
            FROM grading_feedback AS ga
            INNER JOIN (
            SELECT max( id ) AS maxid
            FROM grading_feedback
            GROUP BY innovation_id
        ) AS gb ON ga.id = gb.maxid) as GF', 'GF.innovation_id=IP.id', 'left');
        $this->db->distinct();
        $this->db->group_by('IP.innovation_id');


        if (!empty($whereQuery))
            $query = $this->db->get_where('innovation_pool IP', $whereQuery);
        else
            $query = $this->db->get('innovation_pool IP');

        $csvContent = $this->dbutil->csv_from_result_deals($query);

        if (!write_file("export.csv", $csvContent)) {
            echo 'Unable to write the file';
        } else {
            $data = file_get_contents("export.csv");
            force_download("export.csv", $data);
        }
    }

//////////////////////////////print function //////////////////////////////
    function innovation_print($currentTab = '', $post = '') {
        $offset = 4;
        if ($currentTab == '') {
            if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')))
                $currentTab = 'all';
            if ($this->session->userdata('user_name') == 'Altacit') {
                $currentTab = 'identified';
            } else
            $currentTab = 'assigned';
        }
        $data['currentTab'] = $currentTab;

        $options = $this->make_filter($currentTab, $post);

        if ($currentTab == 'similar') {
            $offset = 5;
            $data['name_of_enterprise'] = $options['name_of_enterprise'];
        }
#Pagination Scripts Starts
        $config = array('base_url' => site_url('scouting/innovation_pool/' . $currentTab),
            'per_page' => '15',
            'total_rows' => $this->Minnovation->getPageCount($options),
            'num_links' => 10,
            'uri_segment' => $offset);
        $this->pagination->initialize($config);
#pagination Ends

        $data['emplist'] = $this->Muser->getUsersList();

        $data['cycleList'] = $this->Mmaster_settings->getMasterSetting('Incubation Cycle');

        $data['sourceTypeList'] = $this->Mmaster_settings->getMasterSetting('Source Type');

        $data['reportsList'] = $this->Mreports->getReportsByType('innovation');

        $data['orderby'] = $this->input->post('orderby');

        $data['ordertype'] = $this->input->post('ordertype');

        $data['stage'] = $this->Minnovation->getInnvationStage();

        $data['status'] = $this->Minnovation->getInnvationStatus();

        $data['innovationList'] = $this->Minnovation->getLimitRecords($options);

        $this->load->model('master/Mmaster');
        $userSetup = $this->Mmaster->getUserSetup();

        $this->load->model('login/Muser');
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        $data['usersListEmployee'] = $this->Muser->getUsersListNotAbi($userSetup['abi']);
        $data['users'] = php72_array_merge($data['usersList'], $data['usersListEmployee']);


        $this->load->model('master/Mstageefficiency');
        $data['timelimit'] = $this->Mstageefficiency->getMaxDays();
        $data['stagedate'] = $this->Mstageefficiency->getStageDate();

        $data['cpage'] = 'printinnovation';
        $data['cpagetitle'] = 'Innovation List';
        $this->load->view('printinnovation', $data);
    }

    function eir_app_edit($in, $id) {
        $this->load->model('eirmodel');
        $data['eir_user'] = $this->eirmodel->fetch_data('eir_user', $id);
        $data['eir_team'] = $this->eirmodel->fetch_data('eir_team', $id);
        $data['eir_app'] = $this->eirmodel->fetch_data('eir_app', $id);
        $data['eir_file'] = $this->eirmodel->fetch_data('eir_files', $id);
        $data['states'] = $this->eirmodel->fetch_state();
        $data['app_id'] = $id;
        $data['cpage'] = 'EIR_edit_form.php';
        $data['cpagetitle'] = 'Edit EIR Application';

        $this->load->vars($data);
        $this->load->view('../template');
    }

    function get_city() {
        $this->load->model('eirmodel');
        $name = $_POST['sname'];
        $statess = $this->eirmodel->fetch_city($name);
        echo json_encode($statess);
    }

    function get_cities($id = '') {
        $cities = $this->Minnovation->getCity($id);
        echo json_encode($cities);
    }

    function seed_app_edit($in, $id) {
        $data['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($in);
        $data['step1'] = $step1 = $this->Minnovation->get_seed('seed_step1', $innovationDetails[0]['innovation_id']);
        $data['member'] = $this->Minnovation->get_seed(' seed_step1_member', $step1[0]['app_id']);
        $data['step2'] = $this->Minnovation->get_seed(' seed_step2', $step1[0]['app_id']);
        $data['step3'] = $this->Minnovation->get_seed(' seed_step3', $step1[0]['app_id']);
        $data['cpage'] = 'seed_edit_form.php';
        $data['cpagetitle'] = 'Edit SEED Application';

        $this->load->vars($data);
        $this->load->view('../template');
    }

    function seed_app_edit_save($in, $id) {
///////////////// innovation array and insert process////////////////////

        $inno = array(
            'name_of_entrepreneur' => $this->input->post('first_name'),
            'phone_no' => $this->input->post('ph_num'),
            'mobile_no' => $this->input->post('ph_num'),
            'email_id' => $this->input->post('email_id'),
            'name_of_enterprise' => $this->input->post('venture'),
            'stage' => '7',
            'status' => '12',
            'program' => '2',
            'modified_date' => date('Y-m-d H:i:s'),
            'modified_by' => $this->session->userdata('emp_number')
        );
        $where = array('id' => $in);
        $table = "innovation_pool";
///////////////// innovation inser process ends ////////////////////////
//////////////// seed form  insert process //////////////////////////////

        $oper_count = php72_count($_POST['operate']);
        $sector = php72_implode(',', $_POST['operate']);
        $sector = ($_POST['operate_other'] != '') ? $sector . ',' . $_POST['operate_other'] : $sector;
        $state = $this->Eirmodel->get_city_state($this->input->post('city_seed'), 'state');
        $city = $this->Eirmodel->get_city_state($this->input->post('city_seed'), 'city');

        $seed_1 = array(
            'firstname' => $this->input->post('first_name'),
            'email' => $this->input->post('email_id'),
            'phone' => $this->input->post('ph_num'),
            'hear_seed' => $this->input->post('hear_abt'),
            'citizenship' => $this->input->post('citizen_ship'),
            'commit_fulltime' => $this->input->post('full_time'),
            'name_venture' => $this->input->post('venture'),
            'org_incorp' => $this->input->post('profit_entity'),
            'website' => $this->input->post('website'),
            'postal_add' => $this->input->post('address'),
            'org_state' => $state,
            'org_city' => $city,
            'regions_ope' => $this->input->post('region_oper'),
            'nom_ope' => $this->input->post('month_oper'),
            'sector' => $sector,
            'funding_summary' => $this->input->post('past_invest')
        );
        $where = array('inno_id' => 'INV' . $in, 'app_id' => $id);
        $table = "seed_step1";
        $this->Minnovation->seed_update($table, $where, $seed_1);



//////////////// seed form insert process ends /////////////////////////
//////////////// seed form member insert process ///////////////////////
        $this->load->library('upload');
        for ($i = 1; $i <= 5; $i++) {
            $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/seedForm/memberuploads';

            $resume_path[$i] = '';
            if ($_FILES["seed_res"]["name"][$i] != "") {
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'doc|docx|pdf';
                $file_name = explode('.', $_FILES["seed_res"]["name"][$i]);
                $config['file_name'] = str_replace(' ', '_', $file_name[0] . '-' . $_POST['seed_name'][$i] . '.' . $file_name[1]);

                $this->upload->initialize($config);

                $_FILES['resume_single']['name'] = $_FILES['seed_res']['name'][$i];
                $_FILES['resume_single']['tmp_name'] = $_FILES['seed_res']['tmp_name'][$i];
                $_FILES['resume_single']['size'] = $_FILES['seed_res']['size'][$i];
                $_FILES['resume_single']['type'] = $_FILES['seed_res']['type'][$i];
                $_FILES['resume_single']['error'] = $_FILES['seed_res']['error'][$i];

                if (!$this->upload->do_upload('resume_single')) {
                    $upload_error = $this->upload->display_errors();
                    echo $upload_error . "--" . $i;
                } else {
                    $upload_data = $this->upload->data();
                    $resume_path[$i] = $upload_data['file_name'];
                    if ($_POST['seed_resume'][$i] != '') {
                        unlink($upload_path . '/' . $_POST['seed_resume'][$i]);
                    }
                }
                unset($config);
            }


            if ($_POST['seed_name'][$i] != '' || $_POST['seed_email'][$i] != '' || $_POST['seed_mob'][$i] != '' || $_FILES['seed_res']['name'][$i] != '' || isset($_POST['ftm'][$i])) {
                $check = isset($_POST['ftm'][$i]) ? 1 : 0;

                if ($_POST['seed_mem_id'][$i] != '') {
                    $file = ($resume_path[$i] == '' && $_POST['seed_resume'][$i] != '') ? $_POST['seed_resume'][$i] : $resume_path[$i];
                    $seed_member = array(
                        's2_name' => $_POST['seed_name'][$i],
                        's2_email' => $_POST['seed_email'][$i],
                        's2_phone' => $_POST['seed_mob'][$i],
                        's2_resume' => $file,
                        's2_check' => $check,
                        'member_no' => $i
                    );
                    $where = "id=" . $_POST['seed_mem_id'][$i] . " and app_id=" . $id;
                    $where = array('id' => $_POST['seed_mem_id'][$i], 'app_id' => $id);
                } else {
                    $where = '';
                    $step = $this->Minnovation->get_step1_id($id);
                    $step1_id = $step[0]['id'];
                    $seed_member = array(
                        'app_id' => $id,
                        'step2_id' => $step1_id,
                        's2_name' => $_POST['seed_name'][$i],
                        's2_email' => $_POST['seed_email'][$i],
                        's2_phone' => $_POST['seed_mob'][$i],
                        's2_resume' => $resume_path[$i],
                        's2_check' => $check,
                        'member_no' => $i
                    );
                }

                $table = "seed_step1_member";

                $this->Minnovation->seed_update($table, $where, $seed_member);
            }
        }

//////////////// seed form member insert process ends //////////////////
/////////////// seed form step two insert process //////////////////////
        $seed_2 = array(
            'inspire_start' => $this->input->post('inspiration'),
            'seed_value' => $this->input->post('expect_seed'),
            'product_service' => $this->input->post('product'),
            'need_service' => $this->input->post('product_need'),
            'solution_inno' => $this->input->post('innovative_solution'),
            'social_impact' => $this->input->post('social_impact'),
            'measure_impact' => $this->input->post('measure_impact')
        );
        $where = array('app_id' => $id);
        $table = "seed_step2";
        $this->Minnovation->seed_update($table, $where, $seed_2);

/////////////// seed form step two insert process ends /////////////////
/////////////// seed form step three insert process //////////////////////

        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/seedForm/businessdocs/';
        $resume_path = '';
        if ($_FILES["business_plan"]["name"] != "") {
            $this->load->library('upload');
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx';
            $file_name = explode('.', $_FILES["business_plan"]["name"]);
            $config['file_name'] = str_replace(' ', '_', $file_name[0] . '-' . $_POST['first_name'] . '.' . $file_name[1]);

            $this->upload->initialize($config);

            $_FILES['business']['name'] = $_FILES['business_plan']['name'];
            $_FILES['business']['tmp_name'] = $_FILES['business_plan']['tmp_name'];
            $_FILES['business']['size'] = $_FILES['business_plan']['size'];
            $_FILES['business']['type'] = $_FILES['business_plan']['type'];
            $_FILES['business']['error'] = $_FILES['business_plan']['error'];

            if (!$this->upload->do_upload('business')) {
                $upload_error = $this->upload->display_errors();
                echo $upload_error;
            } else {
                $upload_data = $this->upload->data();
                $resume_path = $upload_data['file_name'];
                if ($_POST['business_file'] != '') {
                    unlink($upload_path . '/' . $_POST['business_file']);
                }
            }
            unset($config);
        }
        $file = ($resume_path == '' && $_POST['business_file'] != '') ? $_POST['business_file'] : $resume_path;
        $seed_3 = array(
            'ques1' => $this->input->post('market_estimate'),
            'ques2' => $this->input->post('pilots_venture'),
            'ques3' => $this->input->post('launch_learn'),
            'ques4' => $this->input->post('customer'),
            'business_plan' => $file,
            'ques5' => $this->input->post('steps_to_goal')
        );
        $where = array('app_id' => $id);
        $table = "seed_step3";
        $this->Minnovation->seed_update($table, $where, $seed_3);


/////////////// seed form step three insert process ends /////////////////

        $this->session->set_flashdata('successMsg', 'SEED Information updated Successfully!');
        redirect('scouting/seed_app_edit/' . $in . '/' . $id);
    }

///////////////////// bulk upload of new innovations by deepan //////////////////
    function bulk_innovation() {

        if ($this->input->post('ImportFile')) {
            $this->hris = $this->load->database('hris', TRUE);
            $ext = explode('.', $_FILES["inno_file"]["name"]);

            if (!in_array($ext[1], array('xlsx', 'xls', 'csv'))) {
                redirect('scouting/bulk_innovation');
            }
            $this->load->library('excel');
            $csv = "uploads/csv";
            if (!is_dir($csv))
                mkdir($csv);

            $move_to = "$csv/" . $_FILES["inno_file"]["name"];

            if (file_exists($move_to)) {
                unlink($move_to);
                move_uploaded_file($_FILES["inno_file"]["tmp_name"], $move_to);
            } else
            move_uploaded_file($_FILES["inno_file"]["tmp_name"], $move_to);
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($move_to);
            $objPHPExcel->setActiveSheetIndex(0);
            $sheet = $objPHPExcel->getActiveSheet();
            $highestColumn = $sheet->getHighestDataColumn(); // get max column value (E)

            $rowCount = 1;
            $count = 0;
            for ($column = 'A'; $column <= $highestColumn; $column++) {
                $column_name[$count] = $sheet->GetCell($column . $rowCount)->getValue();
                $count++;
            }
            if ($column_name[0] != 'Name of Enterprise' || $column_name[1] != 'Name of Entrepreneur' || $column_name[2] != 'Website' ||
                $column_name[3] != 'Address' || $column_name[4] != 'Email ID' ||
                $column_name[5] != 'Phone' || $column_name[6] != 'Sources Type' || $column_name[7] != 'Sources' || $column_name[8] != 'Summary' ||
                $column_name[9] != 'Notes/ Comments' || $column_name[10] != 'Sector' || $column_name[11] != 'Stage' ||
                $column_name[12] != 'Assign in-charge' || $column_name[13] != 'Status') {
                echo 'error in format';
            exit;
            redirect('scouting/bulk_innovation');
        }
        echo "<table border=\"1\"><th>Name of Enterprise</th><th>Name of Entrepreneur</th><th>Website</th><th>Address</th><th>Email ID</th>
        <th>Phone</th><th>Sources Type</th><th>Sources</th><th>Summary</th><th>Notes/ Comments</th><th>Sector</th><th>Stage</th>
        <th>Assign in-charge</th><th>Status</th><th>Innovation No</th><th>Update Status</th><th>Error Message</th>";
        $success = 0;
            $j = 0; //for jump from first loop
            foreach ($sheet->getRowIterator() as $row) {
                $row->getRowIndex();
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE);
                $i = 0;
                foreach ($cellIterator as $cell) {
                    if ($j) { // jump from header
// Collect the data of the row:
                        $cell->setDataType(PHPExcel_Cell_DataType::TYPE_STRING);
                        $data[$i] = $cell->getCalculatedValue();
                    }
                    $i++;
                }
                if ($j) { // jump from header
                    $error = 0;
                    $err_msg = '';
//get source type id
                    $this->db->where('master_type', 'Source Type');
                    $this->db->where('master_name', $data[6]);
                    $sourcetype_exe = $this->db->get('master_settings');
                    if ($sourcetype_exe->num_rows() > 0) {
                        $sourcetype = $sourcetype_exe->result_array();
                        $sourceType_id = $sourcetype[0]['id'];
                    } else {
                        $error = 1;
                        $err_msg .= 'Source type doesnt matches our current system';
                    }
//check for source others
                    if ($data[7] == 'Others') {
                        $source_id = '-1';
                        $source_other = 'Others';
                    } else {
//get source id
                        $this->db->where('source_type', $sourceType_id);
                        $this->db->where('source_name', $data[7]);
                        $source_exe = $this->db->get('source_master');
                        if ($source_exe->num_rows() > 0) {
                            $sources = $source_exe->result_array();
                            $source_id = $sources[0]['id'];
                        } else {
                            $error = 1;
                            $err_msg .= 'Source doesnt matches our current system';
                        }
                        $source_other = 'NULL';
                    }

                    $temp_name = explode(" ", $data[12]);
                    $this->hris->where('emp_firstname', $temp_name[0]);
                    $this->hris->where('emp_lastname', $temp_name[1]);
                    $emp = $this->hris->get('hs_hr_employee');
                    if ($emp->num_rows() > 0) {

                        $emps_id = $emp->result_array();
                        $emp_id = $emps_id[0]['emp_number'];
                    } else {

                        $error = 1;
                        $err_msg .= 'Assigned name not found';
                    }
                    if (!$error) {
                        echo $data[11] . '-' . $data[13];
//stage
                        switch ($data[11]) {
                            case 'New':
                            $stage = '0';
                            break;
                            case 'Entry':
                            $stage = '1';
                            break;
                            case 'Lead':
                            $stage = '2';
                            break;
                        }

//status
                        switch ($data[13]) {
                            case 'Follow-up':
                            $status = '1';
                            break;
                            case 'Close':
                            $status = '3';
                            break;
                        }
//insertion of table
                        $inno_details = array('name_of_enterprise' => $data[0],
                            'website' => $data[2],
                            'address_line1' => $data[3],
                            'email_id' => $data[4],
                            'sourceType' => $sourceType_id,
                            'source' => $source_id,
                            'source_others' => $source_other,
                            'summary_of_business' => $data[8],
                            'comments' => $data[9],
                            'sector' => $data[10],
                            'name_of_entrepreneur' => $data[1],
                            'mobile_no' => $data[5],
                            'stage' => $stage,
                            'status' => $status,
                            'created_date' => date('Y-m-d H:i:s'),
                            'created_by' => ''
                        );
                        $this->db->insert('innovation_pool', $inno_details);
                        $new_inno_id = $this->db->insert_id();
//update innovation id
                        $inno_number = 'INV' . $new_inno_id;
                        $this->db->where('id', $new_inno_id);
                        $update = array('innovation_id' => $inno_number);
                        $this->db->update('innovation_pool', $update);
//assign employee

                        $assign_to = array(
                            'innovation' => $new_inno_id,
                            'associate_employee' => $emp_id,
                            'status' => '1'
                        );
                        $this->db->insert('assign_associate', $assign_to);
                        echo "<tr><td>" . $data[0] . "</td><td>" . $data[1] . "</td><td>" . $data[2] . "</td><td>" . $data[3] . "</td><td>" . $data[4] . "</td>
                        <td>" . $data[5] . "</td><td>" . $data[6] . "</td><td>" . $data[7] . "</td><td>" . $data[8] . "</td><td>" . $data[9] . "</td>
                        <td>" . $data[10] . "</td><td>" . $data[11] . "</td><td>" . $data[12] . "</td><td>" . $data[13] . "</td><td>" . $inno_number . "</td>
                        <td>success</td><td>" . $err_msg . "</td></tr>";
                    } else {
                        echo "<tr><td>" . $data[0] . "</td><td>" . $data[1] . "</td><td>" . $data[2] . "</td><td>" . $data[3] . "</td><td>" . $data[4] . "</td>
                        <td>" . $data[5] . "</td><td>" . $data[6] . "</td><td>" . $data[7] . "</td><td>" . $data[8] . "</td><td>" . $data[9] . "</td>
                        <td>" . $data[10] . "</td><td>" . $data[11] . "</td><td>" . $data[12] . "</td><td>" . $data[13] . "</td><td>-</td>
                        <td>Failed</td><td>" . $err_msg . "</td></tr>";
                    }
                }
                $j++;
            }
            echo "</table>";
        }
        $this->load->view('bulk_inno');
    }

///////////////////////// Pitch Form process//////////////////////////////////
    function pitch_app_edit($in, $id, $error = '') {
        $in = substr($in, 3);

        $data['inv_id'] = $in;
        $data['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($in);
        $data['pitch_user'] = $this->Minnovation->get_pitch('pitch_user', $innovationDetails[0]['innovation_id']);
        $data['branch'] = $this->Mmaster->getBranch();
        $data['pitch_member'] = $this->Minnovation->get_pitch('pitch_step1_members', $data['pitch_user'][0]['pitch_id']);
        $data['pitch_org'] = $this->Minnovation->get_pitch('pitch_step2', $data['pitch_user'][0]['pitch_id']);
        $data['pitch_doc'] = $this->Minnovation->get_pitch('award_share', $data['pitch_user'][0]['pitch_id']);

        $data['pitch_info'] = $this->Minnovation->get_pitch('pitch_step1_info', $data['pitch_user'][0]['pitch_id']);
        $data['sectors_values'] = $this->Mincharge->getSectorNames($data['innovationDetails'][0]['partner_id']);
        $data['subSectorName'] = $this->Mincharge->getSubsectorName($data['pitch_org'][0]['sub_sector']);

        $data['states'] = $this->Eirmodel->fetch_state();
        $data['error'] = $error;
        $data['cpage'] = 'pitch_edit_form.php';
        $data['cpagetitle'] = 'Edit Pitch Application';


        $this->load->vars($data);
        $this->load->view('../template');
    }

    function pitch_app_edit_save($in, $id) {

        if ($this->input->post('pitchSubmit') == 'Save') {
////////////////////// Pitch user update/////////////////////

            $h_city = $this->input->post('city');
            $o_city = $this->input->post('othercity');
            $getother_city = isset($h_city) && $h_city == 'Others' ? $o_city : '';
            $user_data = array(
                'org_name' => $this->input->post('org_name'),
                'app_name' => $this->input->post('app_name'),
                'email' => $this->input->post('email'),
                'mobileno' => $this->input->post('mobile'),
                'altmobileno' => $this->input->post('alt_ph'),
                'city' => $this->input->post('city'),
                'other_city' => $getother_city
            );
            $user_where = array('inno_id' => $in, 'pitch_id' => $id);
            $table = "pitch_user";
            $result1 = $this->Minnovation->pitch_update($table, $user_data, $user_where);

///////////////////// Pitch user update ends //////////////////
//////////////////// Pitch member update /////////////////////

            $mem_count = php72_count($_POST['pitch_name']);
            for ($i = 1; $i <= $mem_count; $i++) {
                if ($_POST['pitch_name'][$i] != '' || $_POST['pitch_org'][$i] != '' || $_POST['pitch_email'][$i] != '' || $_POST['pitch_mob'][$i] != '' || $_POST['pitch_gender'][$i] != '') {
                    $member_data = array(
                        'name' => $_POST['pitch_name'][$i],
                        'email' => $_POST['pitch_email'][$i],
                        'phone' => $_POST['pitch_mob'][$i],
                        'gender' => !empty($_POST['pitch_gender'][$i]) ? $_POST['pitch_gender'][$i] : '',
                        'pitch_id' => $id
                    );
                    $member_where = array('id' => $_POST['pitch_mem_id'][$i], 'pitch_id' => $id);
                    $table = "pitch_step1_members";
                    $result2 = $this->Minnovation->pitch_update($table, $member_data, $member_where);
                }
            }

            $info_data = array(
                'ent_type' => $this->input->post('ent_type'),
                'type_prod' => $this->input->post('type_prod'),
                'invention_based' => $this->input->post('invention_based'),
                'pitch_id' => $id
            );

            $where = array('pitch_id' => $id);
            $table = "pitch_step1_info";
            $this->Minnovation->pitch_update($table, $info_data, $where);

/////////////////// Pitch member update ends ////////////////////
////////////////// Pitch Org info update ///////////////////////

            $sector_other = '';
            if (php72_in_array('others', $this->input->post('sector')) || $this->input->post('sector') == 'others') {
                $sector_other = $this->input->post('sector_other');
            }
            $fund_from = '';
            if ($this->input->post('fund') != 'no') {
                $fund_from = $this->input->post('fund_from');
            }

            $get_sector = $this->Sector_model->getSectorCategory($this->input->post('sector'));

            $abt_vill = php72_implode(',', $this->input->post('abt_vill'));
            $org_data = array(
                'addr_problem' => $this->input->post('problem_addresed'),
                'quest_1' => $this->input->post('product_service'),
                'ent_impact' => $this->input->post('enterprise_impact'),
                'sector' => serialize($get_sector),
                'operation_stage' => $this->input->post('operation_stage'),
                'partner_name' => $this->input->post('partner_name'),
                'inc_name' => $this->input->post('inc_name'),
                'people_impact' => $this->input->post('no_of_people'),
                'info_about_program' => $abt_vill,
                'fund' => $this->input->post('fund'),
                'awards' => $this->input->post('award_detail'),
                'sub_sector' => $this->input->post('sub_sector'),
                'pitch_id' => $id);

            $org_where = array('pitch_id' => $id);
            $table = "pitch_step2";
            $result3 = $this->Minnovation->pitch_update($table, $org_data, $org_where);

///////////////////////// Pitch Org Info update ends //////////////////////
////////////////////////  Pitch document update //////////////////////////

            $uploads1 = $this->pitch_file_upload('pitchform', 'document', 'uploads1', 'pdf|doc|docx|ppt|pptx', $this->input->post('uploads1_hidden'));
            $uploads2 = $this->pitch_file_upload('pitchform', 'document', 'uploads2', 'pdf|doc|docx|ppt|pptx', $this->input->post('uploads2_hidden'));
            $uploads3 = $this->pitch_file_upload('pitchform', 'document', 'uploads3', 'pdf|doc|docx|ppt|pptx', $this->input->post('uploads3_hidden'));
            $doc_data = array(
                'doc1' => $uploads1,
                'doc2' => $uploads2,
                'pitch_id' => $id);
            $doc_where = array('pitch_id' => $id);
            $table = "award_share";
            $result4 = $this->Minnovation->pitch_update($table, $doc_data, $doc_where);

//////////////////////////////// Pitch document update ends ///////////////////////////////
/////////////////////////////// Innovation table update ///////////////////////////////////

            $innovation_data = array(
                'name_of_entrepreneur' => $this->input->post('app_name'),
                'name_of_enterprise' => $this->input->post('org_name'),
                'email_id' => $this->input->post('email'),
                'mobile_no' => $this->input->post('mobile'),
                'phone_no' => $this->input->post('alt_ph'),
                'city' => $this->input->post('city'),
                'sector' => $this->input->post('sector'),
                'summary_of_business' => $this->input->post('bus_summary'));
            $id = $in;
            $search = 'INV';
            $trimmed = str_replace($search, '', $id);
            $innovation_where = array('id' => $trimmed);
            $table = "innovation_pool";
            $result5 = $this->Minnovation->pitch_update($table, $innovation_data, $innovation_where);

//////////////////////////// Innovation table update ends /////////////////////////////////////

            if ($result1 == 1 && $result2 == 1 && $result3 == 1 && $result4 == 1 && $result5 == 1) {
                $this->session->set_flashdata('successMsg', 'Pitch Information updated Successfully!');
                redirect('scouting/innovation_details/' . substr($in, 3));
            } else {
                $this->session->set_flashdata('errorMsg', 'Updation Failed!');
                redirect('scouting/pitch_app_edit/' . $in . '/' . $id);
            }
        }
    }

    function pitch_file_upload($rootfolder, $folder, $field, $allowed_types, $field_hidden = '') {
        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $rootfolder . '/' . $folder . '/';

        $file_name = '';
        if ($_FILES[$field]["name"] != "") {
            $this->load->library('upload');
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = $allowed_types;
            $config['file_name'] = date('Ymdhis') . '_' . str_replace(' ', '_', $_FILES[$field]["name"]);

            $this->upload->initialize($config);

            if (!$this->upload->do_upload($field)) {
                $upload_error = $this->upload->display_errors();
                return false;
            } else {
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
                if ($field_hidden != '') {
                    unlink($upload_path . '/' . $field_hidden);
                }
            }
            unset($config);
        } else if ($_FILES[$field]["name"] == "" && $field_hidden != '') {
            $file_name = $field_hidden;
        }
        return $file_name;
    }

///////////////////////// Pitch Form process ends ////////////////////////////
///////////////////// Innovation app edit //////////////////////////////////
    function inv_app_edit($in, $id, $error = '') {
        $data['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($in);
        $data['branch'] = $this->Mmaster->getBranch();
        $data['inv_user'] = $this->Minnovation->get_innovation('inv_user', 'INV' . $in);
        $data['sectors_values'] = $this->Mincharge->getSectorNames($data['innovationDetails'][0]['partner_id'], 'incubation');
        $data['subSectorName'] = $this->Mincharge->getSubsectorName($data['inv_user'][0]['sub_sector']);

        $sector = $data['inv_user'][0]['ent_sector'];
        if ($sector == 'MCH' || $sector == "Maternal & child health") {
            $status = $data['inv_user'][0]['status'];
            $data['mch_users'] = $this->Minnovation->get_innovation('mch_users', $data['inv_user'][0]['id']);
        } else {
            $data['inv_team'] = $this->Minnovation->get_innovation('inv_member', $data['inv_user'][0]['id']);
            $data['inv_ent_info'] = $this->Minnovation->get_innovation('inv_ent_info', $data['inv_user'][0]['id']);
            $data['inv_impact'] = $this->Minnovation->get_innovation('inv_impact', $data['inv_user'][0]['id']);
            $data['add_info'] = $this->Minnovation->get_innovation('inv_additional_info', $data['inv_user'][0]['id']);
        }
        $data['states'] = $this->Eirmodel->fetch_state();
        $data['countries'] = $this->Minnovation->getCountry();
        $data['error'] = $error;
        $data['cpage'] = 'inv_app_edit.php';
        $data['cpagetitle'] = 'Edit Innovation Application';

        $this->load->vars($data);
        $this->load->view('../template');
    }

    function inv_app_edit_save($in, $id) {
        if ($this->input->post('invupdate') == 'Submit') {
            $country_name = $this->Minnovation->getCountryName($this->input->post('country'));
            $count_name = $country_name[0];
            $beneficiary_invalid = "no";
            foreach ($this->input->post('beneficiary') as $key => $value) {
                if ($value == "Rural or urban middle income" || $value == "Rural or urban high income")
                    $beneficiary_invalid = 'yes';
            }
            $status = '0';
            $sector = $this->input->post('inv_sector');

            $status = ($status == '0' && $this->input->post('inv_status') != '11' && $this->input->post('inv_status') != '10') ? $this->input->post('inv_status') : $status;

////////////////////// Inv user update/////////////////////

            switch ($status) {
                case '10':
                $stat = 'Registered';
                break;
                case '11':
                $stat = 'Deleted';
                break;
                default:
                $stat = 'Completed';
                break;
            }
            $sector = $this->input->post('inv_sector');
            $inv_user_data = array(
                'ent_name' => $this->input->post('ent_name'),
                'applicant_name' => $this->input->post('name_entr'),
                'email' => $this->input->post('inv_email'),
                'mobile' => $this->input->post('inv_mobile'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'country' => $this->input->post('country'),
                'ent_type' => $this->input->post('compnay_type'),
                'india_based' => $this->input->post('location'),
                'benificiary' => serialize($this->input->post('beneficiary')),
                'impact_of_product' => $this->input->post('impact_type'),
            );

            $inv_user_data['ent_sector'] = $this->input->post('inv_sector');
            $inv_user_data['sub_sector'] = $this->input->post('sub_sector');

            $user_where = array('inv_no' => 'INV' . $in, 'id' => $id);
            $table = "inv_user";
            $result1 = $this->Minnovation->pitch_update($table, $inv_user_data, $user_where);

///////////////////// INV user update ends //////////////////
//////////////////// INV member update /////////////////////

            $this->load->library('upload');
            if ($sector == 'Maternal & child health') {
                $prev_file = $this->input->post('tm_resume_old');
                $doc_name = $this->pitch_file_upload('IncubationForm', 'uploads', 'tm_resume', 'doc|docx|ppt|pptx|pdf', $prev_file);
                $mch_info = array(
                    'start_company' => $this->input->post('company'),
                    'company_age' => $this->input->post('age_company'),
                    'company_stage' => $this->input->post('stage_cmpany'),
                    'citizen_status' => $this->input->post('cust_seg'),
                    'background' => $this->input->post('background'),
                    'mch_problem' => $this->input->post('inno_prob'),
                    'problem_solving' => $this->input->post('problrm_solv'),
                    'strength_exp' => $this->input->post('medical_device'),
                    'idea_problem' => $this->input->post('work_done'),
                    'intrest_solve' => $this->input->post('child_health'),
                    'problem_time' => $this->input->post('problem_time'),
                    'name1' => $this->input->post('tm_name1'),
                    'email1' => $this->input->post('tm_email1'),
                    'phone1' => $this->input->post('tm_phone1'),
                    'name2' => $this->input->post('tm_name2'),
                    'email2' => $this->input->post('tm_email2'),
                    'phone2' => $this->input->post('tm_phone2'),
                    'name3' => $this->input->post('tm_name3'),
                    'email3' => $this->input->post('tm_email3'),
                    'phone3' => $this->input->post('tm_phone3'),
                    'documents' => $doc_name,
                    'inv_user_id' => $id
                );
                $table = "mch_users";
                $where = array('inv_user_id' => $id);
                $resulttt = $this->Minnovation->pitch_update($table, $mch_info, $where);
            } else {
                for ($i = 1; $i <= 4; $i++) {

                    $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/IncubationForm/uploads';
                    $resume_path[$i] = '';
                    if ($_FILES["team_res"]["name"][$i] != "") {
                        $config['upload_path'] = $upload_path;
                        $config['allowed_types'] = 'doc|docx|ppt|pptx|pdf';
                        $file_name = explode('.', $_FILES["team_res"]["name"][$i]);
                        $config['file_name'] = str_replace(' ', '_', $file_name[0] . '-' . $_POST['team_name'][$i] . '.' . $file_name[1]);

                        $this->upload->initialize($config);

                        $_FILES['resume']['name'] = $_FILES['team_res']['name'][$i];
                        $_FILES['resume']['tmp_name'] = $_FILES['team_res']['tmp_name'][$i];
                        $_FILES['resume']['size'] = $_FILES['team_res']['size'][$i];
                        $_FILES['resume']['type'] = $_FILES['team_res']['type'][$i];
                        $_FILES['resume']['error'] = $_FILES['team_res']['error'][$i];

                        if (!$this->upload->do_upload('resume')) {
                            $upload_error = $this->upload->display_errors();
                            echo $upload_error . "--" . $i;
                        } else {
                            $upload_data = $this->upload->data();
                            $resume_path[$i] = $upload_data['file_name'];
                            if ($_FILES['team_res']['name'][$i] != '' && $_POST['hidden_team_res'][$i] != '') {
                                unlink($upload_path . '/' . $_POST['hidden_team_res'][$i]);
                            }
                        }
                        unset($config);
                    }

                    if (trim($_POST['team_name'][$i]) != '' || trim($_POST['team_desg'][$i]) != '' || trim($_POST['team_org'][$i]) != '' || trim($_POST['team_email'][$i]) != '' || trim($_POST['team_mob'][$i]) != '' || trim($_FILES['team_res']['name'][$i]) != '') {
                        $file = ($resume_path[$i] == '' && $_POST['hidden_team_res'][$i] != '') ? $_POST['hidden_team_res'][$i] : $resume_path[$i];
                        if ($_POST['team_id'][$i] != '') {
                            $member_data = array(
                                'mem_name' => $_POST['team_name'][$i],
                                'mem_occupation' => $_POST['team_desg'][$i],
                                'mem_org' => $_POST['team_org'][$i],
                                'mem_email' => $_POST['team_email'][$i],
                                'mem_mobile' => $_POST['team_mob'][$i],
                                'mem_gender' => $_POST['gender'][$i],
                                'mem_resume' => $file
                            );

                            $table = "inv_member";
                            $where = array('id' => $_POST['team_id'][$i], 'inv_user_id' => $id);
                            $result2 = $this->Minnovation->pitch_update($table, $member_data, $where);
                        } else {

                            $member_data = array(
                                'mem_name' => $_POST['team_name'][$i],
                                'mem_occupation' => $_POST['team_desg'][$i],
                                'mem_org' => $_POST['team_org'][$i],
                                'mem_email' => $_POST['team_email'][$i],
                                'mem_mobile' => $_POST['team_mob'][$i],
                                'mem_gender' => $_POST['gender'][$i],
                                'mem_resume' => $file,
                                'inv_user_id' => $id
                            );

                            $table = "inv_member";
                            $result2 = $this->Minnovation->pitch_insert($table, $member_data);
                        }
                    }
                }

/////////////////// INV member update ends ////////////////////
////////////////// Inv enterprise info update ///////////////////////

                $ent_info_data = array(
                    'ent_name_info' => $this->input->post('ent_name'),
                    'in_operation' => $this->input->post('in_operation'),
                    'operate_on_state' => php72_implode(',', $this->input->post('inv_state')),
                    'develop_product' => $this->input->post('type_prod'),
                    'stage_product' => $this->input->post('stage_prod'),
                    'inv_desc' => $this->input->post('inno_desc'),
                    'inv_problem' => $this->input->post('inno_prob'),
                    'inv_alternatives' => $this->input->post('avail_alter'),
                    'pilots' => $this->input->post('pilots'),
                    'proposal_desc' => $this->input->post('prop_model'),
                    'inv_risks' => $this->input->post('ident_risk'),
                    'inv_user_id' => $id
                );

                $table = "inv_ent_info";
                $where = array('inv_user_id' => $id);
                $result3 = $this->Minnovation->pitch_update($table, $ent_info_data, $where);

///////////////////////// Inv enterprise Info update ends //////////////////////
/////////////////////////////// Innovation Impact info update ///////////////////////////////////

                $impact_info_data = array(
                    'primary_benifi' => $this->input->post('prim_benefi'),
                    'research_cus_seg' => $this->input->post('cust_seg'),
                    'demographic_profie' => $this->input->post('benefi_grp'),
                    'avg_monthly' => $this->input->post('avg_earn'),
                    'inv_impact' => $this->input->post('no_impact'),
                    'others_benefit' => $this->input->post('service_benefit'),
                    'inv_user_id' => $id
                );

                $table = "inv_impact";
                $where = array('inv_user_id' => $id);
                $result4 = $this->Minnovation->pitch_update($table, $impact_info_data, $where);

//////////////////////////// Innovation Impact info update ends /////////////////////////////////////
////////////////////////  Inv additional info update //////////////////////////

                $business_file = $this->input->post('hidden_busi_plan');
                if ($_FILES['busi_plan']['name'] != '') {
                    $business_file = $this->pitch_file_upload('IncubationForm', 'uploads', 'busi_plan', 'pdf|doc|docx|ppt|pptx', $this->input->post('hidden_busi_plan'));
                    if ($business_file == 0) {
                        $data['error'] = "File related to business plan not uploaded. Please upload a valid file";
                        $this->inv_app_edit($in, $id, $data['error']);
                    }
                }
                $additional_file = $this->input->post('hidden_add_info_file');
                if ($_FILES['add_info_file']['name'] != '') {
                    $additional_file = $this->pitch_file_upload('IncubationForm', 'uploads', 'add_info_file', 'pdf|doc|docx|ppt|pptx', $this->input->post('hidden_add_info_file'));
                    if ($additional_file == 0) {
                        $data['error'] = "File related to additonal information not uploaded. Please upload a valid file";
                        $this->inv_app_edit($in, $id, $data['error']);
                    }
                }

                $additional_info_data = array(
                    'from_villgro' => php72_implode(',', $this->input->post('vill_support')),
                    'support_name' => $this->input->post('otr_support'),
                    'hear_abt' => php72_implode(',', $this->input->post('abt_vill')),
                    'referal_name' => $this->input->post('ref_name'),
                    'ant_org' => $this->input->post('with_other_org'),
                    'ant_org_name' => $this->input->post('other_org_name'),
                    'won_competition' => $this->input->post('competition'),
                    'competition_name' => $this->input->post('business_compet'),
                    'business_plan' => $business_file,
                    'add_info' => $additional_file,
                    'inv_user_id' => $id
                );

                $table = "inv_additional_info";
                $where = array('inv_user_id' => $id);
                $result5 = $this->Minnovation->pitch_update($table, $additional_info_data, $where);
            } // end of not MCH block
//////////////////////////////// Inv additional info update ends ///////////////////////////////
/////////////////////////////// Innovation table update ///////////////////////////////////

            $innovation_data = array(
                'partner_id' => $this->input->post('branch_name'),
                'name_of_entrepreneur' => $this->input->post('name_entr'),
                'name_of_enterprise' => $this->input->post('ent_name'),
                'email_id' => $this->input->post('inv_email'),
                'mobile_no' => $this->input->post('inv_mobile'),
                'sourceName' => $this->input->post('inv_srcname'),
                'address_line1' => $this->input->post('address1'),
                'address_line2' => $this->input->post('address2'),
                'country' => $count_name,
                'sector' => $this->input->post('inv_sector'),
                'status' => $status,
                'modified_date' => date('Y-m-d H:i:s'),
                'modified_by' => $this->session->userdata('emp_number')
            );

            $table = "innovation_pool";
            $innovation_where = array('id' => $in);
            $result6 = $this->Minnovation->pitch_update($table, $innovation_data, $innovation_where);

//////////////////////////// Innovation table update ends /////////////////////////////////////
            if ($sector != 'Maternal & child health') {
                if ($result1 == 1 && $result2 == 1 && $result3 == 1 && $result4 == 1 && $result5 == 1 && $result6 == 1) {
                    $this->session->set_flashdata('successMsg', 'Innovation Information updated Successfully!');
                    redirect('scouting/innovation_details/' . $in);
                } else {
                    $this->session->set_flashdata('successMsg', 'Innovation Information updated Successfully!');
                    redirect('scouting/innovation_details/' . $in);
                }
            } // not mch
            else {
                if ($resulttt == 1 && $result1 == 1 && $result6 == 1) {
                    $this->session->set_flashdata('successMsg', 'Innovation Information updated Successfully!');
                    redirect('scouting/innovation_details/' . $in);
                } else {
                    $this->session->set_flashdata('successMsg', 'Innovation Information updated Successfully!');
                    redirect('scouting/innovation_details/' . $in);
                }
            }
        }
    }

///////////////////// Innovation app edit ends /////////////////////////////

    function export_deals($id = '', $tab = '') {
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $this->load->model('Mcycle');
        $data['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($id);

        if ($innovationDetails[0]['program'] == '0') {
            $inv_user = $this->Minnovation->get_innovation('inv_user', $innovationDetails[0]['innovation_id']);
            $inv_team = $this->Minnovation->get_innovation('inv_member', $inv_user[0]['id']);
            $inv_ent_info = $this->Minnovation->get_innovation('inv_ent_info', $inv_user[0]['id']);
            $inv_impact = $this->Minnovation->get_innovation('inv_impact', $inv_user[0]['id']);
            $add_info = $this->Minnovation->get_innovation('inv_additional_info', $inv_user[0]['id']);
            $sector_name = $this->Minnovation->getSectorNamePitch($inv_user[0]['ent_sector']);
        }

        if ($innovationDetails[0]['program'] == '3' || $innovationDetails[0]['program'] == '4') {
            $ipitch_user = $this->Minnovation->get_pitch('pitch_user', $innovationDetails[0]['innovation_id']);
        }

        $data['stage'] = $stage = $this->Minnovation->getInnvationStage();
        $data['status'] = $status = $this->Minnovation->getInnvationStatus();
        $app_stage = $stage[$innovationDetails[0]['stage']];
        $app_status = $status[$innovationDetails[0]['status']];
        $partner_list = $this->Minnovation->getIncubationPartners();


        /*         * ****************************************** */
        /*         * ***************Export starts here********* */
        /*         * ****************************************** */


        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
// Set properties
        $objPHPExcel->getProperties()->setCreator("Villgro")
        ->setLastModifiedBy("Villgro")
        ->setTitle("My Deals")
        ->setSubject("My Deals")
        ->setDescription("My Deals")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("My Deals");

        $objPHPExcel->setActiveSheetIndex(0);
        $styleheader = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman'
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'A9CF55')
            )
        );

        $styleheader2 = array(
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman'
            ),
        );
        $styleheader3 = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '4AA02C'),
                'size' => 11,
                'name' => 'Times New Roman'
            ));
        $stylebody = array(
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 11,
                'name' => 'Times New Roman'
            ));
        $dataStyle = array('alignment' => array('wrap' => TRUE, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP)
    );
        $objPHPExcel->getActiveSheet()->getStyle('A1:B' . $objPHPExcel->getActiveSheet()->getHighestRow())
        ->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()
        ->getStyle('B')
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '1')->applyFromArray($styleheader);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '1', $data['innovation']['name_of_enterprise']);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '2')->applyFromArray($styleheader3);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '2', 'Basic Information');

        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '3')->applyFromArray($styleheader2);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '3', 'Innovation Id');
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '4')->applyFromArray($styleheader2);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '4', 'Name of the Enterprise');
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '5')->applyFromArray($styleheader2);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '5', 'Name of the Entrepreneur');
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '6')->applyFromArray($styleheader2);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '6', 'Email Address');
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '7')->applyFromArray($styleheader2);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '7', 'Mobile Number');
        if ($innovationDetails[0]['program'] == '0') {
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '8')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '8', 'Country');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '9')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '9', 'Address 1');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '10')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '10', 'Address 2');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '11')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '11', 'Is your enterprise a');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '12')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '12', 'Will your social enterprise be based in India');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '13')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '13', 'Please select the relevant sector for your enterprise');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '14')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '14', 'Who will be the beneficiaries of your product / service?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '15')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '15', 'What type of impact will your product / service have on the BoP / poor?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '16')->applyFromArray($styleheader2);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '16', 'Created Date');
            if ($tab == 'all') {
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '17')->applyFromArray($styleheader2);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '17', 'Other Partners');
            }
        } else {
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '8')->applyFromArray($styleheader2);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '8', 'Alternate Number');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '9')->applyFromArray($styleheader2);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '9', 'City');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '10')->applyFromArray($styleheader2);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '10', 'Other City');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '11')->applyFromArray($styleheader2);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '11', 'Created Date');
        }

        $other_partners = $data['innovation']['other_partner_id'];
        $partnersList = $get_partner_id = array();
        if ($other_partners != '') {
            $explode_partners = explode(',', $other_partners);
            for ($i = 0; $i < count($explode_partners); $i++) {
                $individual_id = $explode_partners[$i];
                $this->db->select('t1.partner_id');
                $this->db->where("t2.id", $individual_id);
                $this->db->join('inv_user t2', 't2.inv_no = t1.innovation_id', 'left');
                $query = $this->db->get('innovation_pool t1');
                if ($query->num_rows() > 0) {
                    foreach ($query->result_array() as $partner_row) {
                        if ($partner_row['partner_id'] == '01') {
                            $partner_nam = 'India';
                            array_push($get_partner_id, $partner_nam);
                        } else if ($searchPartners == '02') {
                            $partnersList = 'Villgro Kenya';
                        } else if ($searchPartners == '03') {
                            $partnersList = 'Menterra';
                        } else if ($partner_row['partner_id'] == '04') {
                            $partner_nam = 'Startup Oasis';
                            array_push($get_partner_id, $partner_nam);
                        } else if ($partner_row['partner_id'] == '05') {
                            $partner_nam = 'IIMC';
                            array_push($get_partner_id, $partner_nam);
                        } else if ($partner_row['partner_id'] == '06') {
                            $partner_nam = 'KIIT';
                            array_push($get_partner_id, $partner_nam);
                        } else if ($partner_row['partner_id'] == '07') {
                            $partner_nam = 'SIIC';
                            array_push($get_partner_id, $partner_nam);
                        } else if ($partner_row['partner_id'] == '08') {
                            $partner_nam = 'External Vendors';
                            array_push($get_partner_id, $partner_nam);
                        } else if ($partner_row['partner_id'] == '10') {
                            $partner_nam = 'Powering Livelihoods';
                            array_push($get_partner_id, $partner_nam);
                        }
                    }
                }
            }
        }
        $partnersList = implode(',', $get_partner_id);

        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '3')->applyFromArray($styleheader2);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '3', $data['innovation']['copy_id'] . '_' . $data['innovation']['partner_id'] . '_' . $data['innovation']['partner_count']);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '4')->applyFromArray($styleheader2);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '4', $data['innovation']['name_of_enterprise']);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '5')->applyFromArray($styleheader2);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '5', $data['innovation']['name_of_entrepreneur']);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '6')->applyFromArray($styleheader2);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '6', $data['innovation']['email_id']);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '7')->applyFromArray($styleheader2);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '7', $data['innovation']['mobile_no']);

        if ($innovationDetails[0]['program'] == '0') {
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '8')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '8', $data['innovation']['country']);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '9')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '9', $data['innovation']['address_line1']);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '10')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '10', $data['innovation']['address_line2']);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '11')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '11', ucfirst($inv_user[0]['ent_type']));
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '12')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '12', ucfirst($inv_user[0]['india_based']));
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '13')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '13', $sector_name[0]['sector']);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '14')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '14', php72_implode(',', unserialize($inv_user[0]['benificiary'])));
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '15')->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '15', $inv_user[0]['impact_of_product']);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '16')->applyFromArray($styleheader2);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '16', date('d-m-Y', strtotime($data['innovation']['created_date'])));
            if ($tab == 'all') {
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '17')->applyFromArray($styleheader2);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '17', $partnersList);
            }
        } else {
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '8')->applyFromArray($styleheader2);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '8', $data['innovation']['phone_no']);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '9')->applyFromArray($styleheader2);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '9', $data['innovation']['city']);
            if ($innovationDetails[0]['program'] == '3' || $innovationDetails[0]['program'] == '4') {
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '10')->applyFromArray($styleheader2);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '10', $ipitch_user[0]['other_city']);
            } else {
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '10')->applyFromArray($styleheader2);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '10', '');
            }
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '11')->applyFromArray($styleheader2);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '11', date('d-m-Y', strtotime($data['innovation']['created_date'])));
        }

        $col = 0;
        if ($innovationDetails[0]['program'] == '0') {
            $row = 20;
        } else {
            $row = 14;
        }
        $program_name = $innovationDetails[0]['program'];
        if ($program_name == '1')
            $filename = 'EIR';
        else if ($program_name == '2')
            $program = 'SEED';
        else if ($program_name == '3')
            $filename = 'Unc Pitch';
        else
            $filename = 'Incubation';

        if ($innovationDetails[0]['program'] == '1') {
            $this->load->model('eirmodel');
            $files = $this->eirmodel->eir_file($innovationDetails[0]['innovation_id']);
            $eir_user = $this->Minnovation->get_user_eir($innovationDetails[0]['innovation_id']);
            $eir_team = $this->Minnovation->getTeam($innovationDetails[0]['innovation_id']);
            $eir_detail = $this->Minnovation->getEIR($innovationDetails[0]['innovation_id']);

            $objPHPExcel->getActiveSheet()->mergeCells('A13:B13');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '13')->applyFromArray($styleheader3);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '13', 'Application Information');
            $i++;

            $i = 1;
            foreach ($eir_team as $team) {
                if ($team['name'] != '') {
                    $member = 'Member ' . $i;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, $member);
                    $row++;

                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Name');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $team['name']);
                    $row++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Current Organisation');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $team['current_organisation']);
                    $row++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Current title');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $team['current_title']);
                    $row++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Email id');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $team['email_id']);
                    $row++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Mobile No');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $team['mobile_no']);
                    $row++;
                    $i++;
                }
            }

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Briefly describe your key competencies and skills that will enable you to set up an enterprise ');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $eir_detail[0]['skills']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Information about enterprise');
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Briefly describe your idea, product or service (250 words)');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $eir_detail[0]['describtion_of_idea']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Describe the innovative element in your enterprise (250 words)');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $eir_detail[0]['innovative_element']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What need does your idea address? What is the social benefit created by your idea? (250 words) ');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $eir_detail[0]['social_benefit']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Have you undertaken any pilots for your idea? If yes, please provide some detail on the pilot and the key insights you gathered from the pilot (250 words) ');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $eir_detail[0]['pilots_of_idea']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What are your expectations from the EIR program? What specific value addition are you looking for? (250 words)');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $eir_detail[0]['expectation_from_EIR']);
            $row++;
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Additional Information');
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Have you raised any funding for your enterprise? ');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, ($eir_detail[0]['funding'] == '1') ? 'Yes' : 'No');
            $row++;
            if ($eir_detail[0]['funding'] == '1') {
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'If yes, provide details of funding raised');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $eir_detail[0]['funding_detail']);
                $row++;
            }
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Have you set up an enterprise previously?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, ($eir_detail[0]['enterprise_setup'] == '1') ? 'Yes' : 'No');
            $row++;
            if ($eir_detail[0]['enterprise_setup'] == '1') {
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'If yes, provide details of enterprise and current status of the enterprise ');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $eir_detail[0]['setup_detail']);
                $row++;
            }
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Are you incorporated as a for-profit entity?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, ($eir_detail[0]['for_profit'] == '1') ? 'Yes' : 'No');
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'The Entrepreneur-in-Residence program is a full-time, 12-month commitment. Are you willing to commit 12 months to establishing your business? ');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, ($eir_detail[0]['program_time'] == '1') ? 'Yes' : 'No');
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'How did you hear about the Entrepreneur-in-Residence program?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $eir_detail[0]['know_about']);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Additional Documents');
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Resume');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $files[0]['resume']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'General documents');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $files[0]['additional_documents']);
            $row++;
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Program');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, 'EIR');
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Stage');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $app_stage);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Status');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $app_status);
            $row++;
        } else if ($innovationDetails[0]['program'] == '2') {
            $step1 = $this->Minnovation->get_seed('seed_step1', $innovationDetails[0]['innovation_id']);
            $member = $this->Minnovation->get_seed('seed_step1_member', $step1[0]['app_id']);
            $step2 = $this->Minnovation->get_seed('seed_step2', $step1[0]['app_id']);
            $step3 = $this->Minnovation->get_seed('seed_step3', $step1[0]['app_id']);

            $objPHPExcel->getActiveSheet()->mergeCells('A13:B13');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '13')->applyFromArray($styleheader3);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '13', 'Applicant Information');

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Website');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step1[0]['website']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Postal Address');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step1[0]['postal_add']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Region(s) of Organization');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step1[0]['regions_ope']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Number of months in operation');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step1[0]['nom_ope']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What sector do you operate in?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step1[0]['sector']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Have you raised institutional funding/grants/investment in the past? If so, how much and from whom?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step1[0]['funding_summary']);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Management Team');
            $row++;

            $i = 1;
            foreach ($member as $mem) {
                if ($mem['s2_name'] != '') {
                    $member = 'Member ' . $i;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, $member);
                    $row++;

                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Name');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $mem['s2_name']);
                    $row++;

                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Email ID');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $mem['s2_email']);
                    $row++;

                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Phone Number');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $mem['s2_phone']);
                    $row++;

                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Resume');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $mem['s2_resume']);
                    $row++;

                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Member of Founding Team');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, ($mem['s2_check'] == '1') ? 'YES' : 'NO');
                    $row++;
                    $i++;
                }
            }

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Entrepreneur');
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What inspired you to start this social enterprise?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step2[0]['inspire_start']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What value do you expect the SEED program to bring to you and your organization?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step2[0]['seed_value']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Product');
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What is your product/service?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step2[0]['product_service']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What need does your product/service address?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step2[0]['need_service']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What makes your solution innovative?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step2[0]['solution_inno']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Social Impact');
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What is the social impact that your innovation creates?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step2[0]['social_impact']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'How does your organizaton measure its social impact? ');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step2[0]['measure_impact']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Business Viability');
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'How big do you estimate the market for your product to be?(In terms of Rs. crores) ');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step3[0]['ques1']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Have you undertaken pilots for your venture? If so, where and to what scale?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step3[0]['ques2']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What have been your major learning since launching your enterprise?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step3[0]['ques3']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Who are your key customers? And who is your end user?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step3[0]['ques4']);
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Business plan document');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step3[0]['business_plan']);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Scalability');
            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'List the steps you will take to achieve your business goals for the next 6 months.');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $step3[0]['ques5']);
            $row++;
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Program');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, 'SEED');
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Stage');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $app_stage);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Status');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $app_status);
            $row++;
        } else if ($innovationDetails[0]['program'] == '3' || $innovationDetails[0]['program'] == '4') {
            $pitch_user = $this->Minnovation->get_pitch('pitch_user', $innovationDetails[0]['innovation_id']);
            $pitch_info = $this->Minnovation->get_pitch('pitch_step1_info', $pitch_user[0]['pitch_id']);
            $pitch_member = $this->Minnovation->get_pitch('pitch_step1_members', $pitch_user[0]['pitch_id']);
            $pitch_org = $this->Minnovation->get_pitch('pitch_step2', $pitch_user[0]['pitch_id']);
            $pitch_doc = $this->Minnovation->get_pitch('award_share', $pitch_user[0]['pitch_id']);
            $pitch_sector_name = $this->Minnovation->getSectorNamePitch($pitch_org[0]['sector']);
            $pitch_subsector_name = $this->Minnovation->getSectorNamePitch($pitch_org[0]['sub_sector']);
            $sector_value = unserialize($pitch_org[0]['sector']);
            $sector = $sector_value[0];

            $enterprisestage = unserialize($pitch_org[0]['stage']);
            $stage = $enterprisestage[0];

            $objPHPExcel->getActiveSheet()->mergeCells('A13:B13');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '13')->applyFromArray($styleheader3);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '13', 'Team Information');

            $i = 1;
            foreach ($pitch_member as $puser) {
                if ($puser['name'] != '') {
                    $member = 'Member ' . $i;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, $member);
                    $row++;

                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Name');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $puser['name']);
                    $row++;

                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Email id');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $puser['email']);
                    $row++;

                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Mobile No');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $puser['phone']);
                    $row++;

                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Gender');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, ucfirst($puser['gender']));
                    $row++;

                    $i++;
                }
            }

            $row++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Information about enterprise');
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Enterprise Stage');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, ucfirst($pitch_info[0]['ent_type']));
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Developing');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, ucfirst($pitch_info[0]['type_prod']));
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Invention based product');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, ucfirst($pitch_info[0]['invention_based']));
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Sector');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_sector_name[0]['sector']);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Sub Sector');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_subsector_name[0]['sector']);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Stage of operation');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_org[0]['operation_stage']);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Enterprise region currently operational in');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_org[0]['regions']);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Briefly explain the specific problem');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_org[0]['addr_problem']);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Describe your idea, product or service');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_org[0]['quest_1']);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Explain using bullet points the impact your enterprise');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_org[0]['ent_impact']);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Expected people to impact the innovation');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_org[0]['people_impact']);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Have you raised funding?');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, ucfirst($pitch_org[0]['fund']));
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Have you won a prize, recognition, award for your enterprise');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_org[0]['awards']);
            $row++;
//additinal docs

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'How did you hear about program');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_org[0]['info_about_program']);
            $row++;

            if ($pitch_org[0]['partner_name'] != '') {
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Other Mailers/Newsletter');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_org[0]['partner_name']);
                $row++;
            }

            if ($pitch_org[0]['inc_name'] != '') {
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Past Incubatee name');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_org[0]['inc_name']);
                $row++;
            }

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Document 1');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_doc[0]['doc1']);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Document 2');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $pitch_doc[0]['doc2']);
            $row++;

            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Program');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, 'Unc Pitch');
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Stage');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $app_stage);
            $row++;

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Status');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $app_status);
            $row++;

            if ($innovationDetails[0]['comments'] != '') {
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Closed Reasons');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['comments']);
                $row++;
            }

            if ($innovationDetails[0]['reasons'] > 0) {
                $get_reasons = $this->Minnovation->getSourceName($innovationDetails[0]['reasons']);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Closed Comments');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $get_reasons[0]['master_name']);
                $row++;
            }

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Submitted Date');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, date('d-m-Y', strtotime($pitch_user[0]['submitted_date'])));
            $row++;
        } else if ($innovationDetails[0]['program'] == '0') {
            if (!empty($inv_user)) {
                $objPHPExcel->getActiveSheet()->mergeCells('A19:B19');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '19')->applyFromArray($styleheader3);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '19', 'Team Information');

                $i = 1;
                foreach ($inv_team as $team) {
                    $member = 'Member ' . $i;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, $member);
                    $row++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Name');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $team['mem_name']);
                    $row++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Current designation / occupation');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $team['mem_occupation']);
                    $row++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Current organisation');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $team['mem_org']);
                    $row++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Email');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $team['mem_email']);
                    $row++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Mobile');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $team['mem_mobile']);
                    $row++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Resume');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $team['mem_resume']);
                    $row++;
                    $row++;
                    $i++;
                }


                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Information at enterprise');
                $row++;

                if ($inv_ent_info[0]['in_operation']) {
                    switch ($inv_ent_info[0]['in_operation']) {
                        case '0to6':
                        $option = '0 to 6 Months';
                        break;
                        case '6to12':
                        $option = '6 to 12 Months';
                        break;
                        case '1':
                        $option = '1 Year';
                        break;
                        case '2':
                        $option = '2 Years';
                        break;
                    }
                }
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'How long have you been in operation');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $option);
                $row++;

                if ($inv_ent_info[0]['operate_on_state'] != '') {
                    $states = explode(',', $inv_ent_info[0]['operate_on_state']);
                    $state_list = '';
                    foreach ($states as $state) {
                        if ($state_list != '')
                            $state_list = $state_list . ',' . $this->Minnovation->getStateName($state);
                        else
                            $state_list = $this->Minnovation->getStateName($state);
                    }
                }

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'In which states are you operating / plan to operate');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $state_list);
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Are you developing a');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $inv_ent_info[0]['develop_product']);
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'At what stage is your product / service');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $inv_ent_info[0]['stage_product']);
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Provide a brief description of your innovation (product or service)');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $inv_ent_info[0]['inv_desc']);
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What problem does your innovation address? ');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $inv_ent_info[0]['inv_problem']);
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'How is the need addressed without your innovation? What are the available alternatives?');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $inv_ent_info[0]['inv_alternatives']);
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Describe your proposed / current business model ');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $inv_ent_info[0]['proposal_desc']);
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What challenges / risks have you identified in the business?   ');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $inv_ent_info[0]['inv_risks']);
                $row++;
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Impact of innovation ');
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Who is the intended primary beneficiary of your product / service? ');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $inv_impact[0]['primary_benifi']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Have you conducted research on your customer segments / run pilots?');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, ucfirst($inv_impact[0]['research_cus_seg']));
                $row++;
                if ($inv_impact[0]['research_cus_seg'] == 'yes') {
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What is the demographic profile of the primary beneficiary group?');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $inv_impact[0]['demographic_profie']);
                    $row++;

                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'What is the average monthly earning of the primary beneficiary group?');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $inv_impact[0]['avg_monthly']);
                    $row++;
                }
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'How many people do you expect to impact through your innovation? ');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $inv_impact[0]['inv_impact']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Will your product or service benefit other beneficiary groups? Describe these groups briefly. ');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $inv_impact[0]['others_benefit']);
                $row++;
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($styleheader3);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Additional Information');
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Please indicate the support you would like from Villgro');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $add_info[0]['from_villgro']);
                $row++;
                $support = explode(',', $add_info[0]['from_villgro']);

                if (in_array('Other', $support)) {
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Support Name');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $add_info[0]['support_name']);
                    $row++;
                }
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'How did you hear about Villgro');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $add_info[0]['hear_abt']);
                $row++;
                $hear = explode(',', $add_info[0]['hear_abt']);

                if (in_array('Referral', $hear)) {
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Referal Name');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $add_info[0]['referal_name']);
                    $row++;
                }
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Have you been incubated, funded or participated in an accelerator program with another organization?');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $add_info[0]['ant_org']);
                $row++;
                if ($add_info[0]['ant_org'] == 'Yes') {
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Name of organization(s)');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $add_info[0]['ant_org_name']);
                    $row++;
                }
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Have you participated in or won any business plan competitions?');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $add_info[0]['won_competition']);
                $row++;
                if ($add_info[0]['won_competition'] == 'Yes') {
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Name of business plan competition(s)');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $add_info[0]['competition_name']);
                    $row++;
                }

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Business plan (if available)');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $add_info[0]['business_plan']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Additional Information');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $add_info[0]['add_info']);
                $row++;
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Partner');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $partner_list[$innovationDetails[0]['partner_id']]);
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Program');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, 'Incubation');
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Stage');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $app_stage);
                $row++;

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Status');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $app_status);
                $row++;

                if ($innovationDetails[0]['comments'] != '') {
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Closed Reasons');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['comments']);
                    $row++;
                }

                if ($innovationDetails[0]['reasons'] > 0) {
                    $get_reasons = $this->Minnovation->getSourceName($innovationDetails[0]['reasons']);
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Closed Comments');
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $get_reasons[0]['master_name']);
                    $row++;
                }

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Submitted Date');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, date('d-m-Y', strtotime($inv_user[0]['submitted_date'])));
                $row++;
            } else {
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Sector');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['sector']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Address Line1');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['address_line1']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Address Line2');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['address_line2']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'City');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['city']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'District');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['district']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'State');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['state']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Country');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['country']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Pin Code');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['pincode']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Website(If available)');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['website']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'For how long have you been in operation?');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['entreprise_years']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Do you Have a Business Plan ? ');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['business_plan']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Applied Date');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['created_date']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Identified by ');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['created_emp']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Last Modified');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['modified_date']);
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $row, 'Modified By');
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $row)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $row, $innovationDetails[0]['modified_emp']);
                $row++;
            }
        }


        $file_name = $filename . '_form_' . $id . '.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_name . '"');
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

    function export_deals_pdf($id = '', $tab = '') {

        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $this->load->model('Mcycle');
        $data['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($id);
		
		

        if ($innovationDetails[0]['program'] == '37' || $innovationDetails[0]['program'] == '38' || $innovationDetails[0]['program'] == '0' || $innovationDetails[0]['program'] == '33' || $innovationDetails[0]['program'] == '31'  || $innovationDetails[0]['program'] == '9' || $innovationDetails[0]['program'] == '10' || $innovationDetails[0]['program'] == '11' || $innovationDetails[0]['program'] == '12' || $innovationDetails[0]['program'] == '13'|| $innovationDetails[0]['program'] == '14'||  $innovationDetails[0]['program'] == '21'||  $innovationDetails[0]['program'] == '22' ||  $innovationDetails[0]['program'] == '23' ||$innovationDetails[0]['program'] == '24'  ||$innovationDetails[0]['program'] == '25'  ||$innovationDetails[0]['program'] == '26'  ||$innovationDetails[0]['program'] == '34' || $innovationDetails[0]['program'] == '27'  ||$innovationDetails[0]['program'] == '28' || $innovationDetails[0]['program'] == '29' ||$innovationDetails[0]['program'] == '30'  ||$innovationDetails[0]['program'] == '32') {
            $data['inv_user'] = $inv_user = $this->Minnovation->get_innovation('inv_user', $innovationDetails[0]['innovation_id']);
			
            $data['inv_team'] = $this->Minnovation->get_innovation('inv_member', $inv_user[0]['id']);
            $data['inv_ent_info'] = $this->Minnovation->get_innovation('inv_ent_info', $inv_user[0]['id']);
            $data['inv_impact'] = $this->Minnovation->get_innovation('inv_impact', $inv_user[0]['id']);
            $data['add_info'] = $this->Minnovation->get_innovation('inv_additional_info', $inv_user[0]['id']);
            $data['sector_name'] = $this->Minnovation->getSectorNamePitch($inv_user[0]['ent_sector']);
			
		   
			if($innovationDetails[0]['program'] == '30'){
				$this->load->view('scouting/export_inc_tvaran_pdf', $data);	
			}else if($innovationDetails[0]['program'] == '32'){ 
				$this->load->view('scouting/export_villgro_debt_access_program_pdf.php', $data);	
			}else if($innovationDetails[0]['program'] == '37'){ 
				$this->load->view('scouting/export_water_lab_pdf.php', $data);	
			}else{
				$this->load->view('scouting/export_inc_pdf.php', $data);
			}
            
			
            if ($innovationDetails[0]['program'] == '9') {
                $pdfName = 'Swachhata_Application_' . $id;
            } else if ($innovationDetails[0]['program'] == '10') {
                $pdfName = 'TANSEED_Application_' . $id;
            } else if ($innovationDetails[0]['program'] == '11') {
                $pdfName = 'SISFS_Application_' . $id;
            } else if ($innovationDetails[0]['program'] == '12') {
                $pdfName = 'YASH_Application_' . $id;
            } else if ($innovationDetails[0]['program'] == '13') {
                $pdfName = 'Nidhi_Application_' . $id;
            } else if ($innovationDetails[0]['program'] == '14') {

                $pdfName = 'Tvaran_Application_' . $id;
            }else if ($innovationDetails[0]['program'] == '21') {

                $pdfName = 'Empower_Application_' . $id;
            }else if ($innovationDetails[0]['program'] == '22') {

                $pdfName = 'Working_Capital_Loans_for_Social_Enterprises_Application_' . $id;
            }else if ($innovationDetails[0]['program'] == '23') {

                $pdfName = 'ShelterTech_' . $id;
            }else if ($innovationDetails[0]['program'] == '24') {

                $pdfName = 'sustainablemobility' . $id;
            }else if ($innovationDetails[0]['program'] == '25') {
                $pdfName = 'MAPHealth' . $id;
            }else if ($innovationDetails[0]['program'] == '26') {
                $pdfName = 'Poweringlivelihoods' . $id;
            }else if ($innovationDetails[0]['program'] == '27') {
                $pdfName = 'EcoSakhi_' . $id;
            }else if ($innovationDetails[0]['program'] == '28') { 
                $pdfName = 'Innovators_for_Bharat_' . $id;
            }else if ($innovationDetails[0]['program'] == '29') { 
                $pdfName = 'Rural_Access_to_Impact_Innovations' . $id;
            }else if ($innovationDetails[0]['program'] == '30') { 
                $pdfName = 'Tvaran_2_' . $id;
            }else if ($innovationDetails[0]['program'] == '31') { 
                $pdfName = 'Mobilityservice' . $id;
            }else if ($innovationDetails[0]['program'] == '32') { 
                $pdfName = 'villgro_debt_access_program_' . $id;
            }else if ($innovationDetails[0]['program'] == '33') { 
                $pdfName = 'climate_tech_incubator_' . $id;
            }else if ($innovationDetails[0]['program'] == '34') { 
                $pdfName = 'MAPHealth' . $id;
            }else if ($innovationDetails[0]['program'] == '37') { 
                $pdfName = 'Water_lab_' . $id;
            }else if ($innovationDetails[0]['program'] == '37') { 
                $pdfName = 'tvaran_3_' . $id;
            }else {  
                $pdfName = 'Incubation_Application_' . $id;
            }
			
			
			
            $html = $this->output->get_output();
			#echo'<pre>';print_r($html);die;
            $this->load->library('pdf');
            $this->dompdf->loadHtml($html);
            $this->dompdf->set_option('isRemoteEnabled', TRUE);
            $this->dompdf->setPaper('A4', 'portrait');
            $this->dompdf->render();
            $this->dompdf->stream($pdfName, array("Attachment" => 1));
        }

        if ($innovationDetails[0]['program'] == '3' || $innovationDetails[0]['program'] == '4' || $innovationDetails[0]['program'] == '5' || $innovationDetails[0]['program'] == '7') {
            $data['pitch_user'] = $this->Minnovation->get_pitch('pitch_user', $innovationDetails[0]['innovation_id']);
            $pitch_user = $this->Minnovation->get_pitch('pitch_user', $innovationDetails[0]['innovation_id']);
            $data['pitch_info'] = $this->Minnovation->get_pitch('pitch_step1_info', $pitch_user[0]['pitch_id']);
            $data['pitch_member'] = $this->Minnovation->get_pitch('pitch_step1_members', $pitch_user[0]['pitch_id']);
            $data['pitch_org'] = $pitch_org = $this->Minnovation->get_pitch('pitch_step2', $pitch_user[0]['pitch_id']);
            $data['pitch_add'] = $this->Minnovation->get_pitch('pitch_step2_additional', $pitch_user[0]['pitch_id']);
            $data['pitch_doc'] = $this->Minnovation->get_pitch('award_share', $pitch_user[0]['pitch_id']);
            $data['subsector'] = $this->Minnovation->getSectorNamePitch($pitch_org[0]['sub_sector']);
            $data['sdg_align'] = $this->Minnovation->get_sdg_align($pitch_org[0]['sdg_aligns']);

            $this->load->view('scouting/export_pitch_pdf', $data);

            if ($innovationDetails[0]['program'] == '3') {
                $pdfName = 'iPitch_Application_' . $id;
            } else if ($innovationDetails[0]['program'] == '4') {
                $pdfName = 'iPitch_Application_' . $id;
            } else if ($innovationDetails[0]['program'] == '5') {
                $pdfName = 'FPAI_IC_Application_' . $id;
            } else if ($innovationDetails[0]['program'] == '7') {
                $pdfName = 'YSVF_' . $id;
            }

            $html = $this->output->get_output();
            $this->load->library('pdf');
            $this->dompdf->loadHtml($html);
            $this->dompdf->set_option('isRemoteEnabled', TRUE);
            $this->dompdf->setPaper('A4', 'portrait');
            $this->dompdf->render();
            $this->dompdf->stream($pdfName, array("Attachment" => 1));
        }
    }

    function ucheckmail() {
        $email = $this->input->post('email');
        $resp = $this->Minnovation->umailcheck($email);
        echo json_encode($resp);
    }

    function getStateajax() {
        $result = $this->Minnovation->getState();
        echo json_encode($result);
    }

    function getKenyaStateajax() {
        $result = $this->Minnovation->getKenyaState();
        echo json_encode($result);
    }

    function getPartnerStateajax() {
        $id = $_REQUEST['p_id'] ? $_REQUEST['p_id'] : $this->session->userdata('partner_id');
        $result = $this->Minnovation->getPartnerState($id);
        echo json_encode($result);
    }

    function getPartnerState($id) {
        $result = $this->Minnovation->getPartnerState($id);
        return $result;
    }

    function getPartnerCityajax() {
        $id = $_REQUEST['p_id'] ? $_REQUEST['p_id'] : $this->session->userdata('partner_id');
        $result = $this->Minnovation->getPartnerCity($id);
        echo json_encode($result);
    }

    function getPartnerCity($id) {
        $result = $this->Minnovation->getPartnerCity($id);
        return $result;
    }

    function make_filter($currentTab, $post_Val = "") {
        $end_to = date('d/m/Y');
        if ($this->session->userdata('partner_id') == '10') {
            $start = date('Y', strtotime('-10 year'));
        } else {
            $start = date('Y', strtotime('-1 year'));
        }
        $start_from = date('d/m/' . $start);
        $options = array();
        if ($post_Val != '' && !empty($post_Val)) {
            $post_Val = trim($post_Val, "%22");
            if ($post_Val['name_of_entrepreneur'] == '') {
                $post_Val = str_replace("%20", ',', $post_Val);
            }
            $val = explode(':', $post_Val);
            foreach ($val as $key => $value) {
                $inner_val[] = explode('-', $value);
            }
            foreach ($inner_val as $key => $value) {
                if ($value[0] == "created_date" || $value[0] == "created_date_to") {

                    $value[1] = implode('/', explode('_', $value[1]));
                }
                if ($value[0] == "submitted_date" || $value[0] == "submitted_date_to") {

                    $value[1] = implode('/', explode('_', $value[1]));
                }
                if ($value[0] == "email") {

                    $value[1] = str_replace('%5Eat%5E', '@', $value[1]);
                    /* This has been added to handle - in the email domain */
                    if ($value[2]) {
                        $value[1] = $value[1] . "-" . $value[2];
                    }

                    /* This has been added to handle - in the email domain */
                }
                if ($value[0] == 'stage') {
                    $value[1] = str_replace('%5E', '-', $value[1]);
                }
                $_POST[$value[0]] = urldecode($value[1]);
            }

            $options = $_POST;
            $options['dstatus'] = '!4';
            $options['rstatus'] = '!10';
            $options['delstatus'] = '!11';
            $options['branch'] = (!empty($_POST['branch'])) ? ($_POST['branch']) : ($this->session->userdata('partner_id'));
            $currentdate = date("d/m/Y");
            $year = (date("Y") - 1);
            $preyear = date('d/m') . "/" . $year;

            /* muthu changes 12/12/2017 */
            if (isset($options['incomplete']) && $options['incomplete'] == 'draft') {
                $options['firstdraft'] = 'draft';
            }
            if (isset($options['register']) && $options['register'] == 'register') {
                $options['firstregister'] = 'register';
            }
            if (isset($options['register']) && $options['register'] == '') {
                $options['firstregister'] = '';
            }
            /* muthu changes 12/12/2017 */

            if (isset($options['status']) && $options['status'] != '') {
                if (isset($options['incomplete']) && $options['incomplete'] != '')
                    $options['dstatus'] = '4'; // status = draft
                else
                    $options['dstatus'] = '';
                if (isset($options['register']) && $options['register'] != '')
                    $options['rstatus'] = '10'; // status = registered
                else
                    $options['rstatus'] = '';
                if (isset($options['deleted']) && $options['deleted'] != '')
                    $options['delstatus'] = '11'; // status != deleted
                else
                    $options['delstatus'] = '';
            }
            else {
                if (isset($options['incomplete']) && $options['incomplete'] != '')
                    $options['dstatus'] = '4';
                if (isset($options['register']) && $options['register'] != '')
                    $options['rstatus'] = '10';
                if (isset($options['deleted']) && $options['deleted'] != '')
                    $options['delstatus'] = '11';
            }
        }
        else {
            $options = $_POST;
            $options['dstatus'] = '!4'; // status != draft
            $options['rstatus'] = '!10'; // status != registered
            $options['delstatus'] = '!11'; // status != deleted
            $options['branch'] = (!empty($_POST['branch'])) ? ($_POST['branch']) : ($this->session->userdata('partner_id'));

            if (empty($_POST['txtExport'])) {
                $options['submitted_date'] = $start_from;
                $options['submitted_date_to'] = $end_to;
                $options['first'] = 0;
            }

            if (empty($_POST['txtExport_all'])) {
                $options['submitted_date'] = $start_from;
                $options['submitted_date_to'] = $end_to;
                $options['first'] = 0;
            }
            if (isset($_POST['incomplete'])) {
                $options['dstatus'] = ($_POST['incomplete'] != '') ? '4' : '!4'; // status != draft
            }

            if (isset($_POST['register'])) {
                $options['rstatus'] = ($_POST['register'] != '') ? '10' : '!10';
            }

            if (isset($_POST['deleted'])) {
                $options['delstatus'] = ($_POST['deleted'] != '') ? '11' : '!11';
            }
        }
        $options['associate'] = '';
        switch ($currentTab) {
            case 'new':
            $options['stage'] = '0';
            $options['status'] = '0';
            break;
            case 'entry':
            $options['stage'] = '1';
            break;
            case 'incubation':
            $options['istage'] = '11';
            break;
            case 'exit':
            $options['stage'] = '6';
            break;
            case 'lead':
            $options['stage'] = '2';
            $this->load->model('grading/Mgrading');
            $this->Mgrading->createGradeScoreView();
            $options['innovation_score'] = 'yes';
            $options['orderby'] = "INS.score";
            $options['ordertype'] = "desc";
            break;
            case 'entry_pending':
            $options['stage'] = '1';
            $options['grading_status'] = '0';
            break;
            case 'cnew':
            $options['stage'] = '0';
            $options['status'] = '0';
            $options['created_date'] = date('1' . "/m/Y");
            $options['created_date_to'] = date('31' . "/m/Y");
            break;
            case 'centry':
            $options['stage'] = '1';
            $options['created_date'] = date('1' . "/m/Y");
            $options['created_date_to'] = date('31' . "/m/Y");
            break;
            case 'clead':
            $options['stage'] = '2';
            $options['created_date'] = date('1' . "/m/Y");
            $options['created_date_to'] = date('31' . "/m/Y");
            break;
            case 'cfollow':
            $options['status'] = '1';
            $options['created_date'] = date('1' . "/m/Y");
            $options['created_date_to'] = date('31' . "/m/Y");
            break;
            case 'identified':
            $options['created_by'] = $this->session->userdata('emp_number');
            break;
            case 'assigned':
            $this->load->model('Mincharge');
            $innovation = $this->Mincharge->getAssociateInnovation($this->session->userdata('emp_number'));
            $innovation = (php72_count($innovation)) ? $innovation : array();
            $options['associate'] = $innovation;
            if (!isset($_POST['stage']))
                    $options['sstage'] = '!11'; // incubation stage
                break;
                case 'assigned_incubation':
                $this->load->model('Mincharge');
                $innovation = $this->Mincharge->getAssociateInnovation($this->session->userdata('emp_number'));
                $innovation = (php72_count($innovation)) ? $innovation : array();
                $options['associate'] = $innovation;
                $options['istage'] = '11';
                break;
                case 'similar':
                $innovationSimilar = $this->Minnovation->getInnovation($this->uri->segment(4));
                $options['name_of_enterprise'] = $innovationSimilar['name_of_enterprise'];
                $options['email_id'] = $innovationSimilar['email_id'];
                $options['phone_no'] = $innovationSimilar['phone_no'];
                break;
                case 'decision_pending':
                $options['status'] = '!3';
                $options['grading_status'] = '1';
                $options['decision_status'] = '6';
                break;
            }
            return $options;
        }

        function deal_imp() {
            $data['cpagetitle'] = "Innovation Pool";
            $data['cpage'] = "import_deals";
            $this->load->vars($data);
            $this->load->view('../template');
        }

        function import_deals() {
//xit;
            $imp_array = array();
            $err_arr = array();
            $m_arr = ['A', 'B', 'C', 'D', 'E', 'F', 'H', 'I', 'J', 'K', 'L', 'V', 'X', 'Y', 'Z', 'AB', 'AC', 'AS', 'AU', 'AV'];
            $file = $_FILES['upload']['tmp_name'];
//load the excel library
            $this->load->library('excel');
//read file from path
            $objPHPExcel = PHPExcel_IOFactory::load($file);
//get only the Cell Collection
            $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
//extract to a PHP readable array format
            foreach ($cell_collection as $cell) {
                $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

//header will/should be in row 1 only.
                if ($row == 1) {
                    $header[$row][$column] = $data_value;
                } else {
                    if ($row >= 2) {
                        $arr_data[$row][$column] = $data_value;
                    }
                }
            }
            foreach ($arr_data as $key => $value) {
                foreach ($m_arr as $m) {

                    if (!isset($arr_data[$key][$m]) || empty($arr_data[$key][$m])) {
                        $err_arr[] = [$key];
                        unset($imp_array[$key]);
                    } else {
                        $imp_array[$key] = $value;
                    }
                }
            }
            foreach ($arr_data as $ins) {
                $add_by = explode(" ", $ins[A]);

                $Added_by = $this->Minnovation->getemp_id($add_by[0], $add_by[1]);
                $states = explode('/', $ins[N]);
                $date = $states[2] . "-" . $states[1] . "-" . $states[0];
                $innovation_data = array(
                    'name_of_entrepreneur' => $ins[B],
                    'name_of_enterprise' => '',
                    'email_id' => $ins[D],
                    'mobile_no' => $ins[C],
                    'website' => $ins[B],
                    'address_line1' => $ins[F],
                    'address_line2' => $ins[G],
                    'country' => 'India',
                    'sector' => $ins[K],
                    'status' => '3',
                    'comments' => $ins[Q],
                    'stage' => '0',
                    'program' => '0',
                    'source' => '-1',
                    'sourceType' => $ins[L],
                    'created_date' => date('Y-m-d H:i:s', strtotime($date)),
                    'created_by' => $Added_by,
                    'partner_id' => '01'
                );
                $table = "innovation_pool";

                $inc_inv_id = $this->Minnovation->pitch_insert($table, $innovation_data);

//////////////////////////// Innovation table insert ends /////////////////////////////////////
////////////////////// Innovation user insert/////////////////////
                $beni[] = $ins[U];
                $inv_user_data = array(
                    'inv_no' => 'INV' . $inc_inv_id,
                    'ent_name' => '',
                    'applicant_name' => $ins[B],
                    'email' => $ins[D],
                    'mobile' => $ins[C],
                    'address1' => $ins[F],
                    'address2' => $ins[G],
                    'website' => $ins[B],
                    'country' => 99,
                    'ent_type' => ($ins[I] == 'Profit' ? 'profit' : 'nonprofit'),
                    'india_based' => ($ins[J] == 'Yes' ? 'yes' : 'no'),
                    'ent_sector' => $ins[K],
                    'benificiary' => serialize($beni),
                    'impact_of_product' => $ins[W],
                    'status' => ($ins[S] != '' ? 1 : ($ins[O] == 'New' ? 0 : 3)),
                    'created_date' => date('Y-m-d'),
                    'submitted_date' => date('Y-m-d')
                );

                $table = "inv_user";
                $inv_user_id = $this->Minnovation->pitch_insert($table, $inv_user_data);

///////////////////// Innovation user insert ends //////////////////
//////////////////// Innovation member insert /////////////////////
                $member_data = array(
                    'mem_name' => $ins[X],
                    'mem_occupation' => $ins[Y],
                    'mem_org' => $ins[Z],
                    'mem_email' => $ins[AA],
                    'mem_mobile' => $ins[AB],
                    'inv_user_id' => $inv_user_id
                );

                $table = "inv_member";
                $result = $this->Minnovation->pitch_insert($table, $member_data);

                if ($ins[AC] != '' || $ins[AD] != '' || $ins[AE] != '' || $ins[AF] != '' || $ins[AG] != '') {
                    $member_data1 = array(
                        'mem_name' => $ins[AC],
                        'mem_occupation' => $ins[AD],
                        'mem_org' => $ins[AE],
                        'mem_email' => $ins[AF],
                        'mem_mobile' => $ins[AG],
                        'inv_user_id' => $inv_user_id
                    );

                    $table = "inv_member";
                    $result = $this->Minnovation->pitch_insert($table, $member_data1);
                }
                if ($ins[AH] != '' || $ins[AI] != '' || $ins[AJ] != '' || $ins[AK] != '' || $ins[AL] != '') {
                    $member_data2 = array(
                        'mem_name' => $ins[AH],
                        'mem_occupation' => $ins[AI],
                        'mem_org' => $ins[AJ],
                        'mem_email' => $ins[AK],
                        'mem_mobile' => $ins[AL],
                        'inv_user_id' => $inv_user_id
                    );

                    $table = "inv_member";
                    $result = $this->Minnovation->pitch_insert($table, $member_data2);
                }
                if ($ins[AM] != '' || $ins[AN] != '' || $ins[AO] != '' || $ins[AP] != '' || $ins[AQ] != '') {
                    $member_data3 = array(
                        'mem_name' => $ins[AM],
                        'mem_occupation' => $ins[AN],
                        'mem_org' => $ins[AO],
                        'mem_email' => $ins[AP],
                        'mem_mobile' => $ins[AQ],
                        'inv_user_id' => $inv_user_id
                    );

                    $table = "inv_member";
                    $result = $this->Minnovation->pitch_insert($table, $member_data3);
                }

/////////////////// Innovation member insert ends ////////////////////
/////////////////////////////// Innovation Enterprise info insert ///////////////////////////////////

                $ent_info_data = array(
                    'inv_user_id' => $inv_user_id,
                    'ent_name_info' => $ins[E],
                    'develop_product' => $ins[AT],
                    'stage_product' => $ins[AU],
                    'inv_desc' => $ins[AV],
                    'inv_problem' => $ins[AW],
                    'inv_alternatives' => $ins[AX],
                    'proposal_desc' => $ins[AY],
                    'inv_risks' => $ins[AZ]
                );

                $table = "inv_ent_info";

                $result = $this->Minnovation->pitch_insert($table, $ent_info_data);

//////////////////////////// Innovation Enterprise info insert ends /////////////////////////////////////
/////////////////////////////// Innovation Impact info insert ///////////////////////////////////

                $impact_info_data = array(
                    'inv_user_id' => $inv_user_id,
                    'primary_benifi' => $ins[BA],
                    'research_cus_seg' => ($ins[BB] != '' ? ($ins[BB] == 'Yes' ? 'yes' : 'no') : ''),
                    'demographic_profie' => $ins[BC],
                    'avg_monthly' => $ins[BD],
                    'inv_impact' => $ins[BE],
                    'others_benefit' => $ins[BF]
                );
                $table = "inv_impact";
                $result = $this->Minnovation->pitch_insert($table, $impact_info_data);

//////////////////////////// Innovation Impact info insert ends /////////////////////////////////////
/////////////////////////////// Innovation Additional info insert ///////////////////////////////////
                $additional_info_data = array(
                    'inv_user_id' => $inv_user_id,
                    'from_villgro' => $ins[BG],
                    'support_name' => $ins[BH],
                    'hear_abt' => $ins[BI],
                    'ant_org' => $ins[BJ],
                    'ant_org_name' => $ins[BK],
                    'won_competition' => $ins[BL],
                    'competition_name' => $ins[BM]
                );
                $table = "inv_additional_info";
                $result = $this->Minnovation->pitch_insert($table, $additional_info_data);

                if ($ins[S] != '') {
                    $ass_to = explode(" ", $ins[S]);

                    $assigned_to = $this->Minnovation->getemp_id($ass_to[0], $ass_to[1]);

                    $ass_in_data = array('innovation' => $inc_inv_id,
                    'associate_employee' => $assigned_to, //138
                    'created_date' => date($this->config->item('mysqlDate')));
                    $table = "assign_associate";
                    $result = $this->Minnovation->pitch_insert($table, $ass_in_data);
                }

                if ($result) {
                    echo "success" . "</br>";
                }
            }
            die();
            exit;
        }

        public function export_partners($enterprise, $enterpreneur, $email) {
            $get_email = urldecode($email);
            $data = $this->Minnovation->getPartnersRecords($enterprise, $enterpreneur, $get_email, 2);

            $this->load->library('Excel');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("Villgro")
            ->setLastModifiedBy("Villgro")
            ->setTitle("My Deals")
            ->setSubject("My Deals")
            ->setDescription("My Deals")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("My Deals");

            $objPHPExcel->setActiveSheetIndex(0);
            $styleheader = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'size' => 11,
                    'name' => 'Times New Roman',
                ));
            $stylebody = array(
                'text-align' => 'center',
                'font' => array(
                    'color' => array('rgb' => '000000'),
                    'size' => 11,
                    'name' => 'Times New Roman',
                ));
            $dataStyle = array('alignment' => array('wrap' => true, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),
        );
            $objPHPExcel->getActiveSheet()->getStyle('A1:B' . $objPHPExcel->getActiveSheet()->getHighestRow())
            ->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()
            ->getStyle('B')
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '1', 'Partner');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '1', 'Innovation ID');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('2', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2', '1', 'Name of Enterprise');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('3', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('3', '1', 'Name of Enterpreneur');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('4', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('4', '1', 'Sector');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('5', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('5', '1', 'Stage');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('6', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('6', '1', 'Status');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('7', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('7', '1', 'Registered Date');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('8', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('8', '1', 'Email ID');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('9', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('9', '1', 'Mobile');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('10', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('10', '1', 'Submitted Date');

            for ($i = 1; $i <= php72_count($data); $i++) {
                $j = $i + 1;
                $k = $i - 1;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $j, $data[$k]['partnersList']);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $j, $data[$k]['inv_id']);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('2', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2', $j, $data[$k]['enterprise']);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('3', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('3', $j, $data[$k]['entrepreneur']);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('4', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('4', $j, $data[$k]['sector']);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('5', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('5', $j, $data[$k]['stage']);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('6', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('6', $j, $data[$k]['status_text']);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('7', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('7', $j, $data[$k]['identified_date']);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('8', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('8', $j, $data[$k]['email']);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('9', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('9', $j, $data[$k]['phone']);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('10', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('10', $j, $data[$k]['submitted_date']);
            }

            $file_name = 'search_across_partners.xlsx';
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

        function export_leave() {
            $this->hris = $this->load->database('hris', TRUE);

            $frm_date = $_POST['from_date'];
            $to_date = $_POST['to_date'];
            $in_status = $_POST['checkLeave'];

            $cond = "t1.leave_date > '$frm_date'";
            $cond .= " AND t1.leave_date < '$to_date'";
            $cond .= " AND t1.leave_status IN ($in_status)";

            $this->db->where($cond);
            $this->db->select('t1.leave_date, t2.date_applied, t2.approval_date, t3.emp_firstname, t3.emp_lastname, t2.leave_type_name, t1.leave_status, t1.leave_comments');
            $this->db->select("(select sum(CASE WHEN leave_status IN (1,2,3) THEN leave_length_days ELSE 0 END) from " . $this->hris->database . ".hs_hr_leave where leave_request_id = t2.leave_request_id and leave_length_days > 0 and leave_status IN (" . $in_status . ")) as no_of_days", false);
            $this->db->select("(select MIN(leave_date) from " . $this->hris->database . ".hs_hr_leave where leave_request_id = t2.leave_request_id) as from_date");
            $this->db->select("(select MAX(leave_date) from " . $this->hris->database . ".hs_hr_leave where leave_request_id = t2.leave_request_id) as to_date");
            $this->db->join($this->hris->database . '.hs_hr_leave_requests t2', 't2.leave_request_id =  t1.leave_request_id', 'left');
            $this->db->join($this->hris->database . '.hs_hr_employee t3', 't3.employee_id =  t1.employee_id', 'left');
            $this->db->group_by('t1.leave_request_id');
            $this->db->order_by('t1.leave_id', 'desc');
            $query = $this->db->get($this->hris->database . '.hs_hr_leave t1');
            $rows = $query->num_rows();
            $result = $query->result_array();

            $this->load->library('Excel');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("Villgro")
            ->setLastModifiedBy("Villgro")
            ->setTitle("Leave List")
            ->setSubject("Leave List")
            ->setDescription("Leave List")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Leave List");

            $objPHPExcel->setActiveSheetIndex(0);
            $styleheader = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'size' => 11,
                    'name' => 'Times New Roman',
                ));
            $stylebody = array(
                'text-align' => 'center',
                'font' => array(
                    'color' => array('rgb' => '000000'),
                    'size' => 11,
                    'name' => 'Times New Roman',
                ));
            $dataStyle = array('alignment' => array('wrap' => true, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),
        );
            $objPHPExcel->getActiveSheet()->getStyle('A1:B' . $objPHPExcel->getActiveSheet()->getHighestRow())
            ->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()
            ->getStyle('B')
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);

            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '1', 'Leave Start Date');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '1', 'Leave End Date');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('2', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2', '1', 'Applied Date');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('3', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('3', '1', 'Approval Date');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('4', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('4', '1', 'Employee Name');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('5', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('5', '1', 'No of Days');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('6', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('6', '1', 'Leave Type');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('7', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('7', '1', 'Leave Status');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('8', '1')->applyFromArray($styleheader);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('8', '1', 'Leave Comments');

            for ($i = 1; $i <= count($result); $i++) {
                $j = $i + 1;
                $k = $i - 1;

                if ($result[$k]['leave_status'] == '-1') {
                    $statusTxt = 'Rejected';
                } else if ($result[$k]['leave_status'] == '0') {
                    $statusTxt = 'Cancelled';
                } else if ($result[$k]['leave_status'] == '1') {
                    $statusTxt = 'Pending Approval';
                } else if ($result[$k]['leave_status'] == '2') {
                    $statusTxt = 'Approved';
                } else if ($result[$k]['leave_status'] == '3') {
                    $statusTxt = 'Taken';
                }

                if ($result[$k]['approval_date'] != '0000-00-00') {
                    $approval_date = date("d-m-Y", strtotime($result[$k]['approval_date']));
                } else {
                    $approval_date = '';
                }

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', $j, date("d-m-Y", strtotime($result[$k]['from_date'])));

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', $j, date("d-m-Y", strtotime($result[$k]['to_date'])));

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('2', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2', $j, date("d-m-Y", strtotime($result[$k]['date_applied'])));

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('3', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('3', $j, $approval_date);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('4', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('4', $j, $result[$k]['emp_firstname'] . ' ' . $result[$k]['emp_lastname']);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('5', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('5', $j, $result[$k]['no_of_days']);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('6', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('6', $j, $result[$k]['leave_type_name']);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('7', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('7', $j, $statusTxt);

                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('8', $j)->applyFromArray($stylebody);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('8', $j, $result[$k]['leave_comments']);
            }

            $file_name = 'export_leave.xlsx';
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

    }

    ?>
