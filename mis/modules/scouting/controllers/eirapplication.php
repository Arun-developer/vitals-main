<?php
class Eirapplication extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Eirmodel');
    }
    public function index()
    {}

    // Function for new registration in eir
    public function sign_up()
    {

        $form_path = host_url() . "eir/";
        if (isset($_REQUEST['sign_up'])) {

            $this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|callback_mail_check');
            $this->form_validation->set_rules('password', 'Password', 'required|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');

            if ($this->form_validation->run() == false) {
                $error = "";
                $errors = validation_errors();
                $errors = explode("\n", $errors);
                $error = implode('|', $errors);
                $error = str_ireplace('<p>', '', rtrim($error, '|'));
                $error = str_ireplace('</p>', '', rtrim($error, '|'));
                redirect($form_path . "login.php?sign_msg=Failed&sign_errors=" . $error);
            } else {

                $data = array(
                    'user_email' => $_POST['user_email'],
					'password' => md5($_POST['password'])
				);

                $result = $this->Eirmodel->insert_data('eir_user', $data);
                if ($result) {
                    redirect($form_path . "registration.php?loggedin=true&app_id=$result");
                } else {
                    redirect($form_path . "login.php?sign_msg=Failed");
                }
            }
        }
    }

    ///validate existing mail address
    public function mail_check($mail_id)
    {
        if ($this->Eirmodel->check_mail($mail_id)) {
            $this->form_validation->set_message('mail_check', 'Mail_id already exists');
            return false;
        } else {
            return true;
        }
    }

    //// function to store the basic information
    public function basic_information()
    {

        ////////////////////// basic information form process///////////////

        if (isset($_REQUEST['basic_save'])) {
            $form_path = host_url() . "eir/registration.php";
            if ($this->input->post('organisation') != "" || $this->input->post('applicant') != "" || $this->input->post('email') != "" || $this->input->post('mobile_no') != "" || $this->input->post('phone_no') != "") {
                $data = array(

                    'name_of_organisation' => $this->input->post('organisation'),
                    'name_of_applicant' => $this->input->post('applicant'),
                    'email_id' => $this->input->post('email1'),
                    'mobile_no' => $this->input->post('mobile_no'),
                    'alt_phone_no' => $this->input->post('phone_no'),
                    'date_created' => date('Y-m-d'),
                    'status' => 'draft',
                );
                $result = $this->Eirmodel->update_data('eir_user', $data);
                if ($result) {
                    redirect($form_path . "?msg=success");
                } else {
                    redirect($form_path . "?msg=Failed");
                }

            } else {
                redirect($form_path);
            }
        }

        ////////////////////////// application information process //////////////////////////
        if (isset($_REQUEST['app_submit'])) {
            $form_path = host_url() . "eir/appllicant.php";

            if ($_POST['name'][0] == "" && $_POST['org'][0] == "" && $_POST['title'][0] == "" && $_POST['email'][0] == "" && $_POST['mobile'][0] == "" &&
                $_POST['name'][1] == "" && $_POST['org'][1] == "" && $_POST['title'][1] == "" && $_POST['email'][1] == "" && $_POST['mobile'][1] == "" &&
                $_POST['name'][2] == "" && $_POST['org'][2] == "" && $_POST['title'][2] == "" && $_POST['email'][2] == "" && $_POST['mobile'][2] == "" &&
                $this->input->post('skills') == "") {
                redirect($form_path);
            } else {
                for ($i = 0; $i < 3; $i++) {
                    if ($_POST['per_id'][$i] == '' && $_POST['name'][$i] != '') {
                        $data = array(
                            'app_id' => $this->input->post('applicant_id'),
                            'name' => $_POST['name'][$i],
                            'current_organisation' => $_POST['org'][$i],
                            'current_title' => $_POST['title'][$i],
                            'email_id' => $_POST['email'][$i],
                            'mobile_no' => $_POST['mobile'][$i],
                        );

                        $result = $this->Eirmodel->insert_data('eir_team', $data);

                    } else {
                        $data = array(
                            'name' => $_POST['name'][$i],
                            'current_organisation' => $_POST['org'][$i],
                            'current_title' => $_POST['title'][$i],
                            'email_id' => $_POST['email'][$i],
                            'mobile_no' => $_POST['mobile'][$i],
                        );
                        $result = $this->Eirmodel->update_team('eir_team', $data, $this->input->post('applicant_id'), $_POST['per_id'][$i]);
                    }
                }
                if ($this->input->post('info_id') == "" && $this->input->post('skills') != "") {
                    $data = array(
                        'skills' => $this->input->post('skills'),
                        'app_id' => $this->input->post('applicant_id'),
                    );
                    $result = $this->Eirmodel->insert_data('eir_app', $data);
                } else if ($this->input->post('info_id') != "" && $this->input->post('skills') != "") {
                    $data = array(
                        'skills' => $this->input->post('skills'),
                    );
                    $result = $this->Eirmodel->update_app('eir_app', $data, $this->input->post('applicant_id'));
                }
                if ($result) {
                    redirect($form_path . "?msg=success");
                } else {
                    redirect($form_path . "?msg=Failed");
                }

            }
        }

        //////////////////information enterprise process ////////////////////////////////////////////
        if (isset($_REQUEST['Info_enter'])) {
            $form_path = host_url() . "eir/info_enterprise.php";

            if ($this->input->post('describtion') == "" && $this->input->post('innovative_element') == "" && $this->input->post('social_benefit') == "" && $this->input->post('pilots') == "" && $this->input->post('expectation') == "") {
                redirect($form_path);
            } else {
                if ($this->input->post('ent_id') == "") {
                    $data = array(
                        'app_id' => $this->input->post('applicant_id'),
                        'describtion_of_idea' => $this->input->post('describtion'),
                        'innovative_element' => $this->input->post('innovative_element'),
                        'social_benefit' => $this->input->post('social_benefit'),
                        'pilots_of_idea' => $this->input->post('pilots'),
                        'expectation_from_EIR' => $this->input->post('expectation'),
                    );
                    $result = $this->Eirmodel->insert_data('eir_app', $data);
                } else {
                    $data = array(

                        'describtion_of_idea' => $this->input->post('describtion'),
                        'innovative_element' => $this->input->post('innovative_element'),
                        'social_benefit' => $this->input->post('social_benefit'),
                        'pilots_of_idea' => $this->input->post('pilots'),
                        'expectation_from_EIR' => $this->input->post('expectation'),
                    );
                    $result = $this->Eirmodel->update_app('eir_app', $data, $this->input->post('applicant_id'));
                }
                if ($result) {
                    redirect($form_path . "?msg=success");
                } else {
                    redirect($form_path . "?msg=Failed");
                }

            }
        }

        ///////////////////////// additional information process ///////////////////////
        if (isset($_REQUEST['add_info_submit'])) {
            $form_path = host_url() . "eir/add_info.php";

            if ($this->input->post('funding') == "" && $this->input->post('setup') == "" && $this->input->post('profit') == "" && $this->input->post('program_time') == "" && $this->input->post('know_about') == "") {
                redirect($form_path);
            } else {
                if ($this->input->post('ad_info_id') == "") {
                    $data = array(
                        'app_id' => $this->input->post('applicant_id'),
                        'funding' => $this->input->post('funding'),
                        'funding_detail' => $this->input->post('fund_detail'),
                        'enterprise_setup' => $this->input->post('setup'),
                        'setup_detail' => $this->input->post('setup_detail'),
                        'for_profit' => $this->input->post('profit'),
                        'program_time' => $this->input->post('program_time'),
                        'know_about' => $this->input->post('know_about'),
                    );
                    $result = $this->Eirmodel->insert_data('eir_app', $data);
                } else {
                    $data = array(

                        'funding' => $this->input->post('funding'),
                        'funding_detail' => $this->input->post('fund_detail'),
                        'enterprise_setup' => $this->input->post('setup'),
                        'setup_detail' => $this->input->post('setup_detail'),
                        'for_profit' => $this->input->post('profit'),
                        'program_time' => $this->input->post('program_time'),
                        'know_about' => $this->input->post('know_about'),
                    );
                    $result = $this->Eirmodel->update_app('eir_app', $data, $this->input->post('applicant_id'));
                }
                if ($result) {
                    redirect($form_path . "?msg=success");
                } else {
                    redirect($form_path . "?msg=Failed");
                }

            }
        }

        ///////////////////////document upload process//////////////////////////
        if (isset($_REQUEST['doc_submit'])) {

            $form_path = host_url() . "eir/add_docs.php";
            $upload_path = "./uploads/EIR_resume/";

            $this->load->library('upload');
            for ($i = 0; $i < 3; $i++) {
                if ($_POST['per_id'][$i] != '' && $_FILES["resume"]["name"][$i] != "") {
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
                        redirect($form_path . "?msg=Failed&sign_errors=" . $upload_error);
                    } else {
                        $upload_data = $this->upload->data();
                        $resume_path[$i] = $upload_data['file_name'];
                    }
                    unset($config);
                    if ($_POST['resume_path'][$i] != "") {
                        $file = trim($_POST['resume_path'][$i], base_url());
                        unlink($file);
                    }
                    $data = array(
                        'resume_path' => base_url() . 'uploads/EIR_resume/' . $resume_path[$i]);

                    $result = $this->Eirmodel->update_team('eir_team', $data, $this->input->post('applicant_id'), $_POST['per_id'][$i]);

                }
            }
            $data = array(
                'date_submitted' => date('Y-m-d'),
                'status' => 'completed');
            $result = $this->Eirmodel->update_data('eir_user', $data);

            if ($result) {
                redirect($form_path . "?msg=success");
            } else {
                redirect($form_path . "?msg=Failed");
            }

        }

        // deepan works on this eir document submit
        if (isset($_REQUEST['doc_submit1'])) {
            $form_path = host_url() . "eir/add_docs.php";
            $upload_path = "./uploads/EIR_resume/";

            $this->load->library('upload');
            $data1 = array();
            for ($i = 0; $i < 3; $i++) {
                if ($_FILES["resume"]["name"][$i] != "") {
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'doc|docx|pdf';
                    $file_name = explode('.', $_FILES["resume"]["name"][$i]);
                    $config['file_name'] = str_replace(' ', '_', $file_name[0] . '.' . $file_name[1]);

                    $this->upload->initialize($config);

                    $_FILES['resume_single']['name'] = $_FILES['resume']['name'][$i];
                    $_FILES['resume_single']['tmp_name'] = $_FILES['resume']['tmp_name'][$i];
                    $_FILES['resume_single']['size'] = $_FILES['resume']['size'][$i];
                    $_FILES['resume_single']['type'] = $_FILES['resume']['type'][$i];
                    $_FILES['resume_single']['error'] = $_FILES['resume']['error'][$i];

                    if (!$this->upload->do_upload('resume_single')) {
                        $upload_error = $this->upload->display_errors();
                        redirect($form_path . "?msg=Failed&sign_errors=" . $upload_error);
                    } else {
                        $upload_data = $this->upload->data();
                        $resume_path[$i] = $upload_data['file_name'];
                    }
                    unset($config);
                    if ($_POST['resume_path'][$i] != "") {
                        $file = trim($_POST['resume_path'][$i], base_url());
                        unlink($file);
                    }

                    $data1[] = base_url() . 'uploads/EIR_resume/' . $resume_path[$i];

                }
            }

            $data2 = array();
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
                        redirect($form_path . "?msg=Failed&sign_errors=" . $upload_error);
                    } else {
                        $upload_data = $this->upload->data();
                        $additional_path[$i] = $upload_data['file_name'];
                    }
                    unset($config);
                    if ($_POST['additional_path'][$i] != "") {
                        $file = trim($_POST['additional_path'][$i], base_url());
                        unlink($file);
                    }
                    $data2[] = base_url() . 'uploads/EIR_resume/' . $additional_path[$i];
                }
            }

            $resume = implode("|", $data1);

            $doc = implode("|", $data2);

            $this->Eirmodel->insert_files($this->input->post('applicant_id'), $resume, $doc);

            $data = array(
                'date_submitted' => date('Y-m-d'),
                'status' => 'completed');
            $result = $this->Eirmodel->update_data('eir_user', $data);

            if ($result) {
                redirect($form_path . "?msg=success");
            } else {
                redirect($form_path . "?msg=Failed");
            }

        }

    }

    public function update_basic_information()
    {
        $state = $this->input->post('state') ? $this->input->post('state') : '';
        $city = $this->input->post('city') ? $this->input->post('city') : '';
        $address = $this->input->post('address') ? $this->input->post('address') : '';
        if ($city == 'others') {
            $cityUpt = $this->input->post('city_oth');
            $data_city = array('state_id' => $state, 'city_name' => $cityUpt);
            $this->db->insert('eir_city', $data_city);
            $city = $this->db->insert_id();
        }
        $data = array(

            'name_of_organisation' => $this->input->post('organisation'),
            'name_of_applicant' => $this->input->post('applicant'),
            'email_id' => $this->input->post('email1'),
            'mobile_no' => $this->input->post('mobile_no'),
            'alt_phone_no' => $this->input->post('phone_no'),
            'date_modified' => date('Y-m-d'),
            'status' => $this->input->post('status'),
            'state' => $state,
            'city' => $city,
            'address' => $address,

        );
        $this->Eirmodel->update_data('eir_user', $data);
        for ($i = 0; $i < 3; $i++) {
            if ($_POST['person_id'][$i] == '' && $_POST['name'][$i] != '') {
                $data = array(
                    'app_id' => $this->input->post('applicant_id'),
                    'name' => $_POST['name'][$i],
                    'current_organisation' => $_POST['org'][$i],
                    'current_title' => $_POST['title'][$i],
                    'email_id' => $_POST['email'][$i],
                    'mobile_no' => $_POST['mobile'][$i],
                );

                $result = $this->Eirmodel->insert_data('eir_team', $data);

            } else if ($_POST['name'][$i] != '') {
                $data = array(
                    'name' => $_POST['name'][$i],
                    'current_organisation' => $_POST['org'][$i],
                    'current_title' => $_POST['title'][$i],
                    'email_id' => $_POST['email'][$i],
                    'mobile_no' => $_POST['mobile'][$i],
                );

                $this->Eirmodel->update_team('eir_team', $data, $this->input->post('applicant_id'), $_POST['person_id'][$i]);
            }

        }

        $data = array(
            'skills' => $this->input->post('skills'),
            'app_id' => $this->input->post('applicant_id'),
            'describtion_of_idea' => $this->input->post('idea'),
            'innovative_element' => $this->input->post('enterprise'),
            'social_benefit' => $this->input->post('social'),
            'pilots_of_idea' => $this->input->post('pilot'),
            'expectation_from_EIR' => $this->input->post('program'),
            'funding' => $this->input->post('funding'),
            'funding_detail' => $this->input->post('fund_detail'),
            'enterprise_setup' => $this->input->post('setup'),
            'setup_detail' => $this->input->post('setup_detail'),
            'for_profit' => $this->input->post('profit'),
            'program_time' => $this->input->post('program_time'),
            'know_about' => $this->input->post('entrepreneur'),
        );

        if ($this->input->post('team_id') == '') {
            $this->Eirmodel->insert_data('eir_app', $data);
        } else {
            $this->Eirmodel->update_app('eir_app', $data, $this->input->post('applicant_id'));
        }

        $upload_path = "./uploads/EIR_resume/";

        $this->load->library('upload');
        $data1 = array();
        for ($i = 0; $i < 3; $i++) {

            if ($_FILES["resume"]["name"][$i] != "") {
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'doc|docx|pdf';
                $file_name = explode('.', $_FILES["resume"]["name"][$i]);
                $config['file_name'] = str_replace(' ', '_', $file_name[0] . '.' . $file_name[1]);

                $this->upload->initialize($config);

                $_FILES['resume_single']['name'] = $_FILES['resume']['name'][$i];
                $_FILES['resume_single']['tmp_name'] = $_FILES['resume']['tmp_name'][$i];
                $_FILES['resume_single']['size'] = $_FILES['resume']['size'][$i];
                $_FILES['resume_single']['type'] = $_FILES['resume']['type'][$i];
                $_FILES['resume_single']['error'] = $_FILES['resume']['error'][$i];

                if (!$this->upload->do_upload('resume_single')) {
                    $upload_error = $this->upload->display_errors();
                    redirect($form_path . "?msg=Failed&sign_errors=" . $upload_error);
                } else {
                    $upload_data = $this->upload->data();
                    $resume_path[$i] = $upload_data['file_name'];
                }
                unset($config);

                if ($_POST['hresume'][$i] != "") {
                    $file = trim($_POST['hresume'][$i], base_url());
                    unlink($file);
                }

                $data1[] = base_url() . 'uploads/EIR_resume/' . $resume_path[$i];
            } else if ($_POST['hresume'][$i]) {

                $data1[] = $_POST['hresume'][$i];
            }

        }
        $data2 = array();
        for ($i = 0; $i < 2; $i++) {
            if ($_FILES["add_doc"]["name"][$i] != "") {
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'doc|docx|pdf|txt';
                $file_name = explode('.', $_FILES["add_doc"]["name"][$i]);
                $config['file_name'] = str_replace(' ', '_', $file_name[0] . '.' . $file_name[1]);

                $this->upload->initialize($config);

                $_FILES['additional_single']['name'] = $_FILES['add_doc']['name'][$i];
                $_FILES['additional_single']['tmp_name'] = $_FILES['add_doc']['tmp_name'][$i];
                $_FILES['additional_single']['size'] = $_FILES['add_doc']['size'][$i];
                $_FILES['additional_single']['type'] = $_FILES['add_doc']['type'][$i];
                $_FILES['additional_single']['error'] = $_FILES['add_doc']['error'][$i];

                if (!$this->upload->do_upload('additional_single')) {
                    $upload_error = $this->upload->display_errors();
                    redirect($form_path . "?msg=Failed&sign_errors=" . $upload_error);
                } else {
                    $upload_data = $this->upload->data();
                    $additional_path[$i] = $upload_data['file_name'];
                }
                unset($config);
                if ($_POST['hdoc'][$i] != "") {
                    $file = trim($_POST['hdoc'][$i], base_url());
                    unlink($file);
                }
                $data2[] = base_url() . 'uploads/EIR_resume/' . $additional_path[$i];
            } else if ($_POST['hdoc'][$i]) {
                $data2[] = $_POST['hdoc'][$i];
            }
        }

        $resume = implode("|", $data1);

        $doc = implode("|", $data2);
        $result = $this->Eirmodel->insert_files1($this->input->post('applicant_id'), $resume, $doc);

        $redirect = substr($this->input->post('innovation_id'), 3);

        redirect('scouting/innovation_details/' . $redirect);

    }

}
