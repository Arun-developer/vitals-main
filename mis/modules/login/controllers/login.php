<?php

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Muser');
        $this->load->model('Mlogapproval');
        $this->load->model('master/Mmaster');
        $this->load->model('master/Mmailtemplate');
        $this->load->model('scouting/Minnovation');
        $this->load->model('portfolio/Mportfolio');
        $this->load->model('common/Mmail');
        $this->load->model('common/Minnovation_mail');
        $this->load->model('Memail');
        if ($this->uri->segment(2) != 'deals_mail' && $this->uri->segment(2) != 'search_dealsmail' && $this->uri->segment(2) != 'recipients') {
            $this->session->unset_userdata('bulkmail_to');
            $this->session->unset_userdata('bulkmail_invs');
            $this->session->unset_userdata('bulkmail_mailtype');
            $this->session->unset_userdata('bulkmail_subject');
            $this->session->unset_userdata('bulkmail_body');
            $this->session->unset_userdata('bulkmail_from');
        }
    }

    public function send_bulk() {
        echo 'Emails sending...</br>';
        $searchArray[] = 'status IN (0,2)';
        $whereQuery = implode(' and ', $searchArray);

        /* parent mail table */
        $bulkmail = $this->Mmail->getBulkMails($whereQuery);
        $partner_id = $this->session->userdata('partner_id');
        $from_mail = 'mis@villgro.org';
        $j = 0;
        foreach ($bulkmail as $mail_list) {
            $mailsarr = array();
            $mailsarr[] = 'status = 0';
            $mailsarr[] = "bulk_id = " . $mail_list['id'];
            $whereM = implode(' and ', $mailsarr);

            /* chil mail table having details of mail to etc */
            $mail = $this->Mmail->MailDetails($whereM);
            $mail_count = count($mail);

            /* used to replace the from & to hash value in mail contents */

            $mail_list['sender_id'];
            $from = $this->Minnovation_mail->getSender($mail_list['sender_id'], '');
            $to = $this->Minnovation_mail->getReceiver($from['partner']);

            $s = 0;
            foreach ($mail as $mail_invs) {
                /* innovation details to replace hash values in mail content */
                $da['innovationDetails'] = $innovationDetails = $this->Minnovation->getInnovationDetails($mail_invs['inv_id']);

                $innovation = $innovationDetails['0'];
                if ($options['mail_type'] == 'Rejection') {
                    $applied_date = $innovation['Submitted_Date'];
                } else {
                    $applied_date = mysql2date($innovation['created_date']);
                }

                // '#innovation_details#' => $this->load->view('innovation_details_content', $da, true),
                $content = array('#name_of_enterprise#' => $innovation['name_of_enterprise'],
                    '#name_of_entrepreneur#' => $innovation['name_of_entrepreneur'],
                    '#email#' => $mail_invs['mail_to'],
                    '#applied_date#' => $applied_date,
                    '#reasons#' => $innovation['reasons_title'],
                    '#action_employee#' => $to['ceo']['name'],
                    '#innovation_id#' => $innovation['innovation_id'],
                    '#to#' => $innovation['name_of_entrepreneur'],
                    '#from#' => $from['name']);

                $mail_subject = $this->Memail->_parseContent(@$mail_list['mail_subject'], $content);
                $mail_body = $this->Memail->_parseContent(@$mail_list['mail_body'], $content);
                /* Mail triggering function */
                // $mail_invs['mail_to'];
                $mailsend = $this->Memail->sendbulk('mis@villgro.org', $mail_invs['mail_to'], $mail_subject, $mail_body, $partner_id);


                if ($mailsend == 1) {

                    $org_mail = array();
                    $options['from'] = $from_mail;
                    $options['to'] = $mail_invs['mail_to'];
                    $options['innovation'] = $mail_invs['inv_id'];
                    $options['mail_type'] = $mail_list['mail_type'];
                    $options['subject'] = $mail_subject;
                    $options['body'] = $mail_body;
                    /* mail history insertion */
                    $this->Mmail->bulkhistoryinsert($options);

                    $org_mail['status'] = 1;
                    $org_mail['id'] = $mail_invs['id'];
                    $org_mail['mail_error_message'] = '';

                    /* status updation of child table */
                    $this->Mmail->bulkmailupdate($org_mail);
                    $inc_s = $s + 1;
                    if ($s == 0) {
                        $par_mail['status'] = 2;
                    }
                    if ($inc_s == $mail_count) {
                        $par_mail['status'] = 1;
                        ob_end_clean();
                        echo 'Emails sent successfully </br>';
                    }
                    $par_mail['id'] = $mail_list['id'];

                    /* status updation of parent table - partially completed */
                    $this->Mmail->bulkmailparent($par_mail);
                } else {
                    $org_mail = array();
                    $org_mail['status'] = 2;
                    $org_mail['id'] = $mail_invs['id'];
                    $org_mail['bulk_id'] = $mail_invs['bulk_id'];

                    $org_mail['mail_error_message'] = $mailsend;
                    /* status updation of child table - mail failed */
                    $this->Mmail->bulkmailupdate($org_mail);
                    ob_end_clean();
                    echo 'Email sent failed for some reasons </br>';
                }
                $s++;
            }
            $j++;
        }
    }

    public function inv_warning() {
        echo "sdf";
        $responce = $this->Mlogin->loginUser('heera', 'villgro');
        exit;
        $inv_drafts = $this->getDraftInv_Partner();
        $current_date = date('Y-m-d');

        if (!empty($inv_drafts)) {
            foreach ($inv_drafts as $inv) {
                $datetime1 = new DateTime($inv['created_date']);
                $datetime2 = new DateTime($current_date);
                $interval = $datetime1->diff($datetime2);

                $days = $interval->format('%a');
                $partner = $inv['partner_id'];
                if ($partner == '02') {
                    $url = 'http://villgrokenya.or.ke/apply-for-incubation';
                    $name = 'Villgro Kenya';
                    $email = 'apply@villgro.org';
                    $it = 'apply@villgro.org';
                } else if ($partner == '04') {
                    $url = 'http://mis.villgroapps.org/IncubationForm/Login.php?partner=Oasis';
                    $name = 'Startup Oasis';
                    $email = 'invent@startupoasis.in';
                    $it = 'invent@startupoasis.in';
                } else if ($partner == '05') {
                    $url = 'http://mis.villgroapps.org/IncubationForm/Login.php?partner=IIMC';
                    $name = 'Villgro IIMC';
                    $email = 'invent@iimcip.org';
                    $it = 'invent@iimcip.org';
                } else if ($partner == '06') {
                    $url = 'http://kiitincubator.in/invent-form/';
                    $name = 'Villgro KIIT';
                    $email = 'invent@kiitincubator.in';
                    $it = 'invent@kiitincubator.in';
                } else if ($partner == '07') {
                    $url = 'http://mis.villgroapps.org/IncubationForm/Login.php?partner=SIIC';
                    $name = 'Villgro SIIC';
                    $email = 'socialincubator.iitk@gmail.com';
                    $it = 'socialincubator.iitk@gmail.com';
                } else {
                    $url = 'http://www.villgro.org/incubation-apply';
                    $name = 'Villgro';
                    $email = 'apply@villgro.org';
                    $it = 'it@villgro.org';
                }
                if ($days == 11) {
                    $msg = "<p>You have not submitted your application form for the " . $name . " Incubation program in the last 10 days. Applications will need to be submitted within 3 weeks of registering. To access your application form login on " . $url . ". Please complete and submit your application at the earliest.</p>
                    <p>Please contact us at " . $email . " if you have any questions regarding the Incubation program. Or email us at " . $it . " for technical queries. </p>";
                    $sub = $name . 'Incubation Application form - Submission Reminder';
                } else if ($days == 21) {
                    $msg = "<p>You have not submitted your application form for the " . $name . " Incubation program in the last 3 weeks. Your application will be purged from the system within the next 24 hours. Following this you will need to re-register if you are still interested in applying to the incubation program.</p>
                    <p>Please contact us at " . $email . " if you have any questions regarding the Incubation program. Or email us at " . $it . " for technical queries. </p>
                    <p>You can access your application at " . $url . "</p>";
                    $sub = $name . 'Incubation Application form - Final Rem`inder';
                } else if ($days == 22) {
                    $result = $this->inv_status_update($inv['inv_no'], $inv['id']);
                }
            }
        }
    }

    public function inv_status_update($in, $id) {
        $this->db->set('status', 'Deleted');
        $this->db->where('inv_no', $in);
        $this->db->where('id', $id);
        $this->db->update('inv_user');
        if ($this->db->affected_rows() > 0) {
            $this->db->set('status', '11');
            $this->db->where('innovation_id', $in);
            $this->db->update('innovation_pool');
        }
        return true;
    }

    public function getDraftInv_partner() {
        $data = array();
        $this->db->select("INV.*,IP.partner_id");
        $this->db->from("inv_user INV");
        $this->db->join("innovation_pool IP", "IP.innovation_id = INV.inv_no", 'left');
        $this->db->where('INV.status', 'Draft'); // draft status
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return $data;
        }
    }

    public function mail($name, $email, $inv_no, $msg_val, $sub, $partner) {
        $partner_id = ltrim($partner, '0');
        $this->db->where('messagetype', 'Inv Remainder Message');
        $this->db->where('partner_id', $partner_id);
        $template = $this->db->get('master_mailtemplate');

        if ($template->num_rows() > 0) {

            $template1 = $template->result_array();
            $mail_template = $template1[0]['messagebody'];

            $org = array('#name_of_entrepreneur#', '#msg#');
            $replace = array($name, $msg_val);
            $messageBody = str_replace($org, $replace, $mail_template);
            $toEmail = 'muthu.k@quadrupleindia.com';
            $datas = array('innovation' => $inv_no,
                'from' => 'villgro.org',
                'to' => $email,
                'mail_type' => 'Remainder',
                'sent_date' => date('Y-m-d'), //date($this->config->item('mysqlDate')),
                'subject' => 'Innovation Detail Submittion Remainder',
                'body' => $messageBody,
                'send_by' => '',
            );
            $result = $this->db->insert('innovation_mail_history', $datas);
            $this->Memail->send('muthu.k@claritaz.com', $toEmail, $sub, $messageBody, $partner_id, $attach = array(), 'apply@villgro.org');
        }
    }

    /*
     * Main Function for Employee Login Which verifies the Given Username and Password with the Database
     * Get the User details and saved it in the Session Variable
     * Redirect to the Main Menu Page.
     */

    public function copy_request($partner_id) {
        $data['cpagetitle'] = "Innovation Pool";
        $data['cpage'] = "text";
        $this->load->vars($data);
        $this->load->view('../villgrotemplate');
    }

    public function server_maintanance() {
        redirect('login');
        $data['cpage'] = "server_maintanance";
        $this->load->vars($data);
        $this->load->view('server_maintanance');
    }

    public function old_index() {

//        redirect('login/server_maintanance');

        if ($this->input->post('ajax')) {
            $responce = $this->Muser->loginUser($_POST['username'], $_POST['password']);
            $get_ais_val = $this->Muser->get_aisPrivilege($responce[0]['partner_id']);
            $get_branch_name = $this->Muser->getPartneremail($responce[0]['partner_id']);
            if (count($responce) > 0) {
                foreach ($responce as $result) {
                    if ($result['mip_id'] != '0' and $result['mip_id'] != '1' and $result['emp_number'] != '0') {
                        $userType = "mipuser";
                    } else {
                        $userType = $this->Mauth->getUserType($result['emp_id'], $result['partner_id'], $result['user_role']);
                    }
                    $partner_currency = mb_strtoupper($get_ais_val[0]['currency']);

                    $is_superAdmin = 'No';
                    if ($result['user_role'] == '1' || $result['user_role'] == '4') {
                        $isAdmin = 'No';
                        $user_type = 'employee';
                    } else if ($result['user_role'] == '2') {
                        $isAdmin = 'No';
                        $user_type = 'employee';
                    } else if ($result['user_role'] == '3') {
                        $isAdmin = 'Yes';
                        $is_superAdmin = 'Yes';
                        $user_type = 'superadmin';
                    } else {
                        $isAdmin = 'No';
                        $user_type = 'employee';
                    }

                    $partner_logo = isset($get_branch_name['partner_logo']) && $get_branch_name['partner_logo'] != '' ? $get_branch_name['partner_logo'] : 'default_logo.jpg';
                    $userDetails = array(
                        'user_name' => $this->input->post('username'),
                        'password' => $this->input->post('password'),
                        'user_id' => $result['emp_id'],
                        'user' => $result['emp_id'],
                        'name' => $result['emp_first_name'],
                        'emp_number' => $result['emp_id'],
                        'emp_name' => $result['emp_name'],
                        'emp_mail' => $result['official_email'],
                        'admin_mail' => $result['admin_email'],
                        'isAdmin' => $isAdmin,
                        'user_group' => '',
                        'user_type' => $userType,
                        'partner_id' => $result['partner_id'],
                        'partner_name' => $get_branch_name['partner_name'],
                        'partner_logo' => $partner_logo,
                        'ais_privilege' => $get_ais_val[0]['ais_privilege'],
                        'currency' => $partner_currency,
                        'role_id' => $result['user_role'],
                        'graph_label' => $result['graph_label'],
                        'isSuperAdmin' => $is_superAdmin,
                        'accessTo' => $result['partner_access'],
                        'menuAccess' => $result['menu_access'],
                        'sectorAccess' => $result['sector_access'],
                        'programAccess' => $result['program_access'],
                        'dealsFrom' => $result['deals_from_date'],
                        'dealsTo' => $result['deals_to_date'],
                        'independent_shortlist' => $result['independent_shortlist']
                    );
                }

                $user = $this->Mmaster->getUserSetup();

                $this->session->set_userdata($userDetails);
                $data = $this->Muser->getLogindate($this->session->userdata['user_id']);
                $str = $data['login_date'];
                $month = date("m", strtotime($str));
                $afteronemont = date('Y-m-d');
                $aftercheckmonth = date("m", strtotime($afteronemont));
                $date2 = $str[0];
                if ($date2 == '0') {
                    echo 'Pass' . $date2;
                } else if ($month != $aftercheckmonth) {
                    echo 'afteronemonth';
                } else {
                    echo 'loginsuccess';
                }

                exit();
            } else {
                echo 'fail';
                exit();
            }
        }
        if ($this->input->post('txtSubmit')) {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() != false) {
                $responce = $this->Muser->loginUser($this->input->post('username'), $this->input->post('password'));
                $get_ais_val = $this->Muser->get_aisPrivilege($responce[0]['partner_id']);
                $get_branch_name = $this->Muser->getPartneremail($responce[0]['partner_id']);
                $partner_currency = mb_strtoupper($get_ais_val[0]['currency']);
                if (count($responce) > 0) {
                    $emp_log['employee_id'] = $responce[0]['emp_id'];
                    $emp_log['last_login'] = date("Y-m-d H:i:s");
                    $login_log = $this->Muser->create_emp_log('user_login_history', $emp_log);
                    foreach ($responce as $result) {
                        if ($result['mip_id'] != '0' and $result['mip_id'] != '1' and $result['emp_number'] != '0') {
                            $userType = "mipuser";
                        } else {
                            $userType = $this->Mauth->getUserType($result['emp_id'], $result['partner_id'], $result['user_role']);
                        }

                        $is_superAdmin = 'No';
                        if ($result['user_role'] == '1' || $result['user_role'] == '4') {
                            $isAdmin = 'No';
                            $user_type = 'employee';
                        } else if ($result['user_role'] == '2') {
                            $isAdmin = 'No';
                            $user_type = 'employee';
                        } else if ($result['user_role'] == '3') {
                            $isAdmin = 'Yes';
                            $is_superAdmin = 'Yes';
                            $user_type = 'superadmin';
                        } else {
                            $isAdmin = 'No';
                            $user_type = 'employee';
                        }

                        $partner_logo = isset($get_branch_name['partner_logo']) && $get_branch_name['partner_logo'] != '' ? $get_branch_name['partner_logo'] : 'default_logo.jpg';
                        $userDetails = array(
                            'user_name' => $this->input->post('username'),
                            'password' => $this->input->post('password'),
                            'user_id' => $result['emp_id'],
                            'user' => $result['emp_id'],
                            'name' => $result['emp_first_name'],
                            'emp_number' => $result['emp_id'],
                            'emp_name' => $result['emp_name'],
                            'emp_mail' => $result['official_email'],
                            'admin_mail' => $result['admin_email'],
                            'isAdmin' => $isAdmin,
                            'user_group' => '',
                            'user_type' => $user_type,
                            'partner_id' => $result['partner_id'],
                            'partner_name' => $get_branch_name['partner_name'],
                            'partner_logo' => $partner_logo,
                            'ais_privilege' => $get_ais_val[0]['ais_privilege'],
                            'currency' => $partner_currency,
                            'role_id' => $result['user_role'],
                            'graph_label' => $result['graph_label'],
                            'isSuperAdmin' => $is_superAdmin,
                            'accessTo' => $result['partner_access'],
                            'menuAccess' => $result['menu_access'],
                            'sectorAccess' => $result['sector_access'],
                            'programAccess' => $result['program_access'],
                            'dealsFrom' => $result['deals_from_date'],
                            'dealsTo' => $result['deals_to_date'],
                            'independent_shortlist' => $result['independent_shortlist'],
                            'last_log_view' => '1'
                        );
                    }
                    $user = $this->Mmaster->getUserSetup();

                    $this->session->set_userdata($userDetails);

                    $this->session->set_flashdata('successMsg', 'You are Logged In!');
                    $allowed_partner = array("1", "2");
                    if (in_array($this->session->userdata['partner_id'], $allowed_partner)) {
                        redirect('portfolio/dashboard');
                    } else {
                        redirect('portfolio/alldeals');
                    }
                } else {
                    $data['errorMsg'] = "Invalid username or password!";
                }
            } else {

                $data['errorMsg'] = "Validation error found, check it again!";
            }
        } else {
            if (isset($this->session->userdata['user_id']) && !empty($this->session->userdata['user_id'])) {
                $allowed_partner = array("1", "2");
                if (in_array($this->session->userdata['partner_id'], $allowed_partner)) {
                    redirect('portfolio/dashboard');
                } else {
                    redirect('portfolio/alldeals');
                }
            }
        }

        $this->load->vars($data);
        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
        $data['cpagetitle'] = "Login Panel";
        $data['cpage'] = "login";
        $this->load->view('login');
    }

    public function index() { 
	
//        redirect('login/server_maintanance');
        if ($this->input->post('ajax')) {
            $responce = $this->Muser->loginUser($_POST['username'], $_POST['password']);
            $get_ais_val = $this->Muser->get_aisPrivilege($responce[0]['partner_id']);
            $get_branch_name = $this->Muser->getPartneremail($responce[0]['partner_id']);
            if (count($responce) > 0) {
                foreach ($responce as $result) {
                    if ($result['mip_id'] != '0' and $result['mip_id'] != '1' and $result['emp_number'] != '0') {
                        $userType = "mipuser";
                    } else {
                        $userType = $this->Mauth->getUserType($result['emp_id'], $result['partner_id'], $result['user_role']);
                    }
                    $partner_currency = mb_strtoupper($get_ais_val[0]['currency']);

                    $is_superAdmin = 'No';
                    if ($result['user_role'] == '1' || $result['user_role'] == '4') {
                        $isAdmin = 'No';
                        $user_type = 'employee';
                    } else if ($result['user_role'] == '2') {
                        $isAdmin = 'No';
                        $user_type = 'employee';
                    } else if ($result['user_role'] == '3') {
                        $isAdmin = 'Yes';
                        $is_superAdmin = 'Yes';
                        $user_type = 'superadmin';
                    } else {
                        $isAdmin = 'No';
                        $user_type = 'employee';
                    }

                    $partner_logo = isset($get_branch_name['partner_logo']) && $get_branch_name['partner_logo'] != '' ? $get_branch_name['partner_logo'] : 'default_logo.jpg';
                    $userDetails = array(
                        'user_name' => $this->input->post('username'),
                        'password' => $this->input->post('password'),
                        'user_id' => $result['emp_id'],
                        'user' => $result['emp_id'],
                        'name' => $result['emp_first_name'],
                        'emp_number' => $result['emp_id'],
                        'emp_name' => $result['emp_name'],
                        'emp_mail' => $result['official_email'],
                        'admin_mail' => $result['admin_email'],
                        'isAdmin' => $isAdmin,
                        'user_group' => '',
                        'user_type' => $userType,
                        'partner_id' => $result['partner_id'],
                        'partner_name' => $get_branch_name['partner_name'],
                        'partner_logo' => $partner_logo,
                        'ais_privilege' => $get_ais_val[0]['ais_privilege'],
                        'currency' => $partner_currency,
                        'role_id' => $result['user_role'],
                        'graph_label' => $result['graph_label'],
                        'isSuperAdmin' => $is_superAdmin,
                        'accessTo' => $result['partner_access'],
                        'menuAccess' => $result['menu_access'],
                        'sectorAccess' => $result['sector_access'],
                        'programAccess' => $result['program_access'],
                        'dealsFrom' => $result['deals_from_date'],
                        'dealsTo' => $result['deals_to_date'],
                        'independent_shortlist' => $result['independent_shortlist']
                    );
                }

                $user = $this->Mmaster->getUserSetup();

                $this->session->set_userdata($userDetails);
                $data = $this->Muser->getLogindate($this->session->userdata['user_id']);
                $str = $data['login_date'];
                $month = date("m", strtotime($str));
                $afteronemont = date('Y-m-d');
                $aftercheckmonth = date("m", strtotime($afteronemont));
                $date2 = $str[0];
                if ($date2 == '0') {
                    echo 'Pass' . $date2;
                } else if ($month != $aftercheckmonth) {
                    echo 'afteronemonth';
                } else {
                    echo 'loginsuccess';
                }

                exit();
            } else {
                echo 'fail';
                exit();
            }
        }
        if ($this->input->post('txtSubmit')) {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() != false) {
                $responce = $this->Muser->loginUser($this->input->post('username'), $this->input->post('password'));
                if($responce[0]['partner_id'] == 2) {
                    $data['kenya_user'] = 1;
                    $this->load->vars($data);
                    $this->load->view('mis_login');
                } else {
                    $get_ais_val = $this->Muser->get_aisPrivilege($responce[0]['partner_id']);
                    $get_branch_name = $this->Muser->getPartneremail($responce[0]['partner_id']);
                    $partner_currency = mb_strtoupper($get_ais_val[0]['currency']);
                    if (count($responce) > 0) {
                        $emp_log['employee_id'] = $responce[0]['emp_id'];
                        $emp_log['last_login'] = date("Y-m-d H:i:s");
                        $login_log = $this->Muser->create_emp_log('user_login_history', $emp_log);
                        foreach ($responce as $result) {
                            if ($result['mip_id'] != '0' and $result['mip_id'] != '1' and $result['emp_number'] != '0') {
                                $userType = "mipuser";
                            } else {
                                $userType = $this->Mauth->getUserType($result['emp_id'], $result['partner_id'], $result['user_role']);
                            }

                            $is_superAdmin = 'No';
                            if ($result['user_role'] == '1' || $result['user_role'] == '4') {
                                $isAdmin = 'No';
                                $user_type = 'employee';
                            } else if ($result['user_role'] == '2') {
                                $isAdmin = 'No';
                                $user_type = 'employee';
                            } else if ($result['user_role'] == '3') {
                                $isAdmin = 'Yes';
                                $is_superAdmin = 'Yes';
                                $user_type = 'superadmin';
                            } else {
                                $isAdmin = 'No';
                                $user_type = 'employee';
                            }

                            $partner_logo = isset($get_branch_name['partner_logo']) && $get_branch_name['partner_logo'] != '' ? $get_branch_name['partner_logo'] : 'default_logo.jpg';
                            $userDetails = array(
                                'user_name' => $this->input->post('username'),
                                'password' => $this->input->post('password'),
                                'user_id' => $result['emp_id'],
                                'user' => $result['emp_id'],
                                'name' => $result['emp_first_name'],
                                'emp_number' => $result['emp_id'],
                                'emp_name' => $result['emp_name'],
                                'emp_mail' => $result['official_email'],
                                'admin_mail' => $result['admin_email'],
                                'isAdmin' => $isAdmin,
                                'user_group' => '',
                                'user_type' => $user_type,
                                'partner_id' => $result['partner_id'],
                                'partner_name' => $get_branch_name['partner_name'],
                                'partner_logo' => $partner_logo,
                                'ais_privilege' => $get_ais_val[0]['ais_privilege'],
                                'currency' => $partner_currency,
                                'role_id' => $result['user_role'],
                                'graph_label' => $result['graph_label'],
                                'isSuperAdmin' => $is_superAdmin,
                                'accessTo' => $result['partner_access'],
                                'menuAccess' => $result['menu_access'],
                                'sectorAccess' => $result['sector_access'],
                                'programAccess' => $result['program_access'],
                                'dealsFrom' => $result['deals_from_date'],
                                'dealsTo' => $result['deals_to_date'],
                                'independent_shortlist' => $result['independent_shortlist'],
                                'last_log_view' => '1'
                            );
                        }
                        $user = $this->Mmaster->getUserSetup();

                        $this->session->set_userdata($userDetails);


//                    $this->session->set_flashdata('successMsg', 'You are Logged In!');
                        if (isset($_POST['exportPage']) && $_POST['exportPage'] == 'export_doc') {
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $allowed_partner = array("1", "2");
                            if (in_array($this->session->userdata['partner_id'], $allowed_partner)) {
                                redirect('portfolio/dashboard');
                            } else {
                                redirect('portfolio/alldeals');
                            }
                        }
                    } else {
                        $data['errorMsg'] = "Invalid username or password!";
                    }
                }
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }
        } else {
            if (isset($this->session->userdata['user_id']) && !empty($this->session->userdata['user_id'])) {
                $allowed_partner = array("1", "2");
                if (in_array($this->session->userdata['partner_id'], $allowed_partner)) {
                    redirect('portfolio/dashboard');
                } else {
                    redirect('portfolio/alldeals');
                }
            }
        }

        $this->load->vars($data);
        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
        $data['cpagetitle'] = "Login Panel";
        $data['cpage'] = "login";
        $this->load->view('mis_login');
    }

    public function logout() {
        $this->unsetSession();
        $this->session->set_flashdata('successMsg', 'You are Logged out Successfully!');
        redirect('login');
    }

    /* Disconnect from DMS

     * Created By : Sanjoy Dey

     * Created Date : 28-02-2012

     * Last Updated By : Sanjoy

     * Modified Date : 28-02-2012

     *

     *  */

    public function unsetSession() {

        $glueCode = $_SERVER['DOCUMENT_ROOT'] . "/ajaxplorer/plugins/auth.remote/glueCode.php";

        $secret = "secret_key_passed_to_auth.remote_by_configuration";

        define('AJXP_EXEC', true);

        global $AJXP_GLUE_GLOBALS;

        $AJXP_GLUE_GLOBALS = array();

        $AJXP_GLUE_GLOBALS["secret"] = $secret;

        $AJXP_GLUE_GLOBALS["plugInAction"] = "logout";

        include $glueCode;

        /* End DMS Code */
        $userDetails = array(
            'user_name' => '',
            'password' => '',
            'user_id' => '',
            'user' => '',
            'emp_number' => '',
            'emp_name' => '',
            'username' => '',
            'user_group' => '',
            'user_type' => '',
            'partner_id' => '',
            'role_id' => '',
            'graph_label' => '',
            'accessTo' => '',
            'session_id' => ''
        );
        $this->session->unset_userdata($userDetails);
//        $this->session->sess_destroy();
    }

    public function icon_menu() {
        $allowed_partner = array("1", "2");
        if (in_array($this->session->userdata['partner_id'], $allowed_partner)) {
            $newDeals = site_url('portfolio/dashboard');
            redirect($newDeals);
        } else {
            checkAuth();
            if (!isset($this->session->userdata['user_id']) && empty($this->session->userdata['user_id'])) {
                redirect('login');
            } else {
                $data = $this->Muser->getLogindate($this->session->userdata['user_id']);
                $loginactivity = $this->Muser->user_login_update(date('Y-m-d'), $this->session->userdata['user_id']);
                $data['cpage'] = 'icon_menu';
                $data['cpagetitle'] = 'Main Menu';
                $this->load->view('../template', $data);
            }
        }
    }

    public function change_master() {
        $allowed_partner = array("1", "2");
        if ($this->session->userdata['user_type'] == 'admin') {
            $this->session->set_userdata("user_type", 'employee');
            $this->session->set_userdata("isAdmin", 'No');
            if (in_array($this->session->userdata['partner_id'], $allowed_partner)) {
                redirect('portfolio/dashboard');
            } else {
                redirect('portfolio/alldeals');
            }
        } else {
            $this->session->set_userdata("user_type", 'admin');
            $this->session->set_userdata("isAdmin", 'Yes');
            if (in_array($this->session->userdata['partner_id'], $allowed_partner)) {
                redirect('portfolio/dashboard');
            } else {
                redirect('portfolio/alldeals');
            }
        }
    }

    public function admin_portfolio() {
        $allowed_partner = array("1", "2");
        if ($this->session->userdata['user_type'] == 'admin') {
            $this->session->set_userdata("user_type", 'employee');
            $this->session->set_userdata("isAdmin", 'No');
            if (in_array($this->session->userdata['partner_id'], $allowed_partner)) {
                redirect('portfolio/dashboard');
            } else {
                redirect('portfolio/alldeals');
            }
        } else {
            $this->session->set_userdata("user_type", 'admin');
            $this->session->set_userdata("isAdmin", 'Yes');
            if (in_array($this->session->userdata['partner_id'], $allowed_partner)) {
                redirect('portfolio/dashboard');
            } else {
                redirect('portfolio/alldeals');
            }
        }
    }

    public function leave_archive($year) {
        $data['year'] = $year;
        $data['empid'] = $this->session->userdata('emp_number');
        $data['cpage'] = 'leave_archive';
        $data['cpagetitle'] = 'Leave Archives';
        $this->load->view('../template_plain', $data);
    }

    public function check() {
        phpinfo();
    }

    public function requests() {
        $this->Mauth->isLoggedCheck();
        $this->Mauth->isPartnerCheck();
        $financialArray = $this->Mapproval->findCurrentFinancialYear();
        $from = $this->Mapproval->convertMonthYearFrom($financialArray[0]['from']);
        $year = substr($from, 0, 4);
        $month = substr($from, -2, 2);
        $date = '01';
        $data['from_financial'] = $year . '-' . $month . '-' . $date;
        $to = $this->Mapproval->convertMonthYearTo($financialArray[0]['to']);
        $year = substr($to, 0, 4);
        $month = substr($to, -2, 2);
        $date = '31';
        $data['to_financial'] = $year . '-' . $month . '-' . $date;
        $data['pending_count'] = total_pending_count();
        $data['cpage'] = 'requests';
        $data['cpagetitle'] = 'Requests';
        $this->load->view('../template', $data);
    }

    public function timesheet() {
        $this->Mauth->isLoggedCheck();

        $financialArray = $this->Mapproval->findCurrentFinancialYear();
        $from = $this->Mapproval->convertMonthYearFrom($financialArray[0]['from']);
        $year = substr($from, 0, 4);
        $month = substr($from, -2, 2);
        $date = '01';
        $data['from_financial'] = $year . '-' . $month . '-' . $date;
        $to = $this->Mapproval->convertMonthYearTo($financialArray[0]['to']);
        $year = substr($to, 0, 4);
        $month = substr($to, -2, 2);
        $date = '31';
        $data['to_financial'] = $year . '-' . $month . '-' . $date;
        $data['pending_count'] = total_pending_count();
        $data['cpage'] = 'timesheet';

        $data['cpagetitle'] = 'TimeSheet';

        $this->load->view('../template', $data);
    }

    public function approvals() {
        $this->Mauth->isLoggedCheck();
        $this->load->model('Mapproval');
        $this->Mauth->isPartnerCheck();
        $apn_count = 0;
        $int_count = 0;
        $finance = unserialize($this->Mapproval->getApprovalSetting('finance'));
        $ceo = $this->Mapproval->getApprovalSetting('ceo');
        $financeteam = $finance;
        $ceoteam = array($ceo);
        if ($this->session->userdata('isAdmin') != 'Yes' && ($this->session->userdata('user_type') != 'superadmin')) {
            $apn_count += $this->Mapproval->getApprovalDashboard('mylist', 'pending');
            $apn_count += $this->Mapproval->getApprovalDashboard('rolist', 'pending');
            $apn_count += $this->Mapproval->getApprovalDashboard('phlist', 'pending');

            $int_count += $this->Mapproval->getInternalDashboard('mylist', 'pending');
            $int_count += $this->Mapproval->getInternalDashboard('rolist', 'pending');
            $int_count += $this->Mapproval->getInternalDashboard('phlist', 'pending');

            if (in_array($this->session->userdata('user_id'), $ceoteam)) {
                $apn_count += $this->Mapproval->getApprovalDashboard('ceolist', 'pending');
            }
            if (in_array($this->session->userdata('user_id'), $financeteam)) {
                $int_count += $this->Mapproval->getInternalDashboard('finance', 'pending');
            }
        } else {
            $apn_count += $this->Mapproval->getApprovalDashboard('admin', 'pending');
            $int_count += $this->Mapproval->getInternalDashboard('admin', 'pending');
        }
        $data['approvalNotes'] = $apn_count;
        $data['internalNotes'] = $int_count;
        $data['library_count'] = $library_count = $this->Mapproval->librarycount();
        $data['travel_count'] = $travel_count = $this->Mapproval->travelcount();
        $data['leave_count'] = $count = $this->Mapproval->leavecount();
        $data['cpage'] = 'approvals';
        $data['cpagetitle'] = 'Approvals';
        $this->load->view('../template', $data);
    }

    public function mydeals() {
        $newDeals = site_url('portfolio/alldeals');
        redirect($newDeals);
        $allowed_partner = array("1", "2");
        if (in_array($this->session->userdata['partner_id'], $allowed_partner)) {
            $newDeals = site_url('portfolio/alldeals');
            redirect($newDeals);
        } else {
            $this->Mauth->isLoggedCheck();
            $options['associate'] = '';
            $options['status'] = '!3';
            $options['grading_status'] = '1';
            $options['decision_status'] = '6';
            $options['branch_name'] = $this->session->userdata('partner_id');

            $options2 = $this->make_filter('assigned', $post_val);

            $data2['my_deals_count'] = $this->Minnovation->getLimitRecords_new($options2);
            $cio_emp_id = $this->Mmaster->getEmpIdBySetUP('cio', $this->session->userdata('partner_id'));
            if ($this->session->userdata('emp_number') == $cio_emp_id[0]['cio']) {
                $options3 = $this->make_filter('assigned', $post_val);
                $data3['my_deals_cio_count'] = $this->Minnovation->getLimitRecords_new($options3);
                $data['my_deals_cio_count'] = $data3['my_deals_cio_count']['iTotalRecords'];
            }
            $data['my_deals_count'] = $data2['my_deals_count']['iTotalRecords'];
            $data['count_decision_pending'] = $this->Minnovation->getAllCount($options);
            $data['cpage'] = 'mydeals';
            $data['cpagetitle'] = 'My Deals';
            $this->load->view('../template', $data);
        }
    }

    public function make_filter($currentTab, $post_Val = "") {
        $end_to = date('d/m/Y');
        $start = date('Y', strtotime('-1 year'));
        $start_from = date('d/m/' . $start);
        $options = array();
        if ($post_Val != "" && !empty($post_Val)) {
            $post_Val = trim($post_Val, "%22");
            $post_Val = str_replace("%20", ',', $post_Val);
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

            if (isset($options['status']) && $options['status'] != '') {
                if (isset($options['incomplete']) && $options['incomplete'] != '') {
                    $options['dstatus'] = '4';
                }
                // status = draft
                else {
                    $options['dstatus'] = '';
                }

                if (isset($options['register']) && $options['register'] != '') {
                    $options['rstatus'] = '10';
                }
                // status = registered
                else {
                    $options['rstatus'] = '';
                }

                if (isset($options['deleted']) && $options['deleted'] != '') {
                    $options['delstatus'] = '11';
                }
                // status != deleted
                else {
                    $options['delstatus'] = '';
                }
            } else {
                if (isset($options['incomplete']) && $options['incomplete'] != '') {
                    $options['dstatus'] = '4';
                }

                if (isset($options['register']) && $options['register'] != '') {
                    $options['rstatus'] = '10';
                }

                if (isset($options['deleted']) && $options['deleted'] != '') {
                    $options['delstatus'] = '11';
                }
            }
        } else {
            $options = $_POST;
            $options['dstatus'] = '!4'; // status != draft
            $options['rstatus'] = '!10'; // status != registered
            $options['delstatus'] = '!11'; // status != deleted
            $options['branch'] = (!empty($_POST['branch'])) ? ($_POST['branch']) : ($this->session->userdata('partner_id'));
            if (empty($_POST['txtExport']) && $currentTab != 'assigned') {
                $options['submitted_date'] = $start_from;
                $options['submitted_date_to'] = $end_to;
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
            $options['istage'] = '5';
            $options['istatus'] = '8';
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
            $innovation = (count($innovation)) ? $innovation : array();
            $options['associate'] = $innovation;
            if (!isset($_POST['stage'])) {
                $options['sstage'] = '!5';
            }
                // incubation stage
            if (!isset($_POST['status'])) {
                $options['sstatus'] = '!8';
            }
                // incubation status
            break;
            case 'assigned_incubation':
            $this->load->model('Mincharge');
            $innovation = $this->Mincharge->getAssociateInnovation($this->session->userdata('emp_number'));
            $innovation = (count($innovation)) ? $innovation : array();
            $options['associate'] = $innovation;
            $options['istage'] = '5';
            $options['istatus'] = '8';
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

    public function assessment($id) {
        checkAuth();
        $data['id'] = $id;
        $data['innovation'] = $innovation = $this->Minnovation->getinnovation($id);
        $data['cpage'] = 'assessments';
        $data['cpagetitle'] = $innovation['name_of_enterprise'];
        $this->load->view('../template', $data);
    }

    public function myportfolio($id) {
        $data['id'] = $id;
        $this->Mauth->isPartnerCheck();
        $innovation = $this->Minnovation->getinnovation($id);
        if ($innovation['partner_id'] != '1' || $innovation['partner_id'] != '01') {
            $this->session->set_flashdata('warningMsg', 'You are not Authorized to view this page');
            redirect('login');
        }
        $data['cpage'] = 'myportfolio';
        $data['cpagetitle'] = $innovation['name_of_enterprise'];
        $this->load->view('../template', $data);
    }

    public function resources() {
        $data['cpage'] = 'resources';
        $data['cpagetitle'] = 'Resources';
        $this->load->view('../template', $data);
    }

    public function reports() {
        $finance = unserialize($this->Mapproval->getApprovalSetting('finance'));
        if (in_array($this->session->userdata('user_id'), $finance)) {
            $data['isFinance'] = 'Yes';
        } else {
            $data['isFinance'] = 'No';
        }
        $data['isAdmin'] = $this->session->userdata('isAdmin');
        $data['cpage'] = 'reports';
        $data['cpagetitle'] = 'Reports';
        $this->load->view('../template', $data);
    }

    public function options($id) {
        checkAuth();
        $data['id'] = $id;
        $data['innovation'] = $innovation = $this->Minnovation->getinnovation($id);
        $data['cpage'] = 'options';
        $data['cpagetitle'] = $innovation['name_of_enterprise'];
        $this->load->view('../template', $data);
    }

    public function manage_users() {
        if (!isset($this->session->userdata['user_id']) && empty($this->session->userdata['user_id'])) {
            redirect('login');
        } else {
            $financialArray = $this->Mapproval->findCurrentFinancialYear();
            $from = $this->Mapproval->convertMonthYearFrom($financialArray[0]['from']);
            $year = substr($from, 0, 4);
            $month = substr($from, -2, 2);
            $date = '01';
            $data['from_financial'] = $year . '-' . $month . '-' . $date;
            $to = $this->Mapproval->convertMonthYearTo($financialArray[0]['to']);
            $year = substr($to, 0, 4);
            $month = substr($to, -2, 2);
            $date = '31';
            $data['to_financial'] = $year . '-' . $month . '-' . $date;
            $data['pending_count'] = total_pending_count();
            $data['cpage'] = 'manage_users';
            $data['cpagetitle'] = 'Manage Users';
            $this->load->view('../template', $data);
        }
    }

    public function partner_privilege() {
        $this->hris = $this->load->database('hris', true);
        $this->hris->select('*');
        $this->hris->from('master_settings');
        $this->hris->where('status', 'active');
        $query = $this->hris->get();
        $data['partner_data'] = $query->result_array();

        if ($this->input->post('partnerSubmit') != '') {
            for ($i = 0; $i < count($data['partner_data']); $i++) {
                $this->hris->set('ais_privilege', $this->input->post($data['partner_data'][$i]['partner_id']));
                $this->hris->where('partner_id', $data['partner_data'][$i]['partner_id']);
                $this->hris->update('hs_hr_branch');
            }
            redirect('login/partner_privilege');
        }
        $data['cpage'] = 'partner_privilege';
        $data['cpagetitle'] = 'Partner Privilege';
        $this->load->view('../template', $data);
    }

    public function master() {
        checkAuth();
        $data['cpage'] = 'master';
        $data['cpagetitle'] = 'Master Options';
        $this->load->view('../template', $data);
    }

    public function master_pro() {

        checkAuth();
        $data['cpage'] = 'master_pro';
        $data['cpagetitle'] = 'Master Options';
        $this->load->view('../templates/common_template', $data);
    }

    public function admin_master() {
        checkAuth();
        $data['cpage'] = 'admin_master';
        $data['cpagetitle'] = 'Admin Master';
        $this->load->view('../template', $data);
    }

    public function leaves() {
        $this->Mauth->isPartnerCheck();
        $financialArray = $this->Mapproval->findCurrentFinancialYear();
        $from = $this->Mapproval->convertMonthYearFrom($financialArray[0]['from']);
        $year = substr($from, 0, 4);
        $month = substr($from, -2, 2);
        $date = '01';
        $data['from_financial'] = $year . '-' . $month . '-' . $date;
        $to = $this->Mapproval->convertMonthYearTo($financialArray[0]['to']);
        $year = substr($to, 0, 4);
        $month = substr($to, -2, 2);
        $date = '31';
        $data['to_financial'] = $year . '-' . $month . '-' . $date;
        $data['pending_count'] = total_pending_count();
        $data['emp_leave_count'] = $this->Mapproval->emp_leavecount();
        $data['sub_leave_count'] = $this->Mapproval->subord_leavecount();
        $data['cpage'] = 'leaves';
        $data['cpagetitle'] = 'Leaves';
        $this->load->view('../template', $data);
    }

    public function fellows($id) {
        $this->Mauth->isPartnerCheck();
        $data['id'] = $id;
        $innovation = $this->Minnovation->getinnovation($id);
        $data['cpage'] = 'fellows';
        $data['cpagetitle'] = $innovation['name_of_enterprise'];
        $this->load->view('../template', $data);
    }

    public function portfolio() {
        $this->Mauth->isPartnerCheck();
        $data['cpage'] = 'portfolio';
        $data['cpagetitle'] = 'Portfolio';
        $this->load->view('../template', $data);
    }

    public function portfolio_options($id) {
        $data['id'] = $id;
        $this->Mauth->isPartnerCheck();
        $innovation = $this->Minnovation->getinnovation($id);
        $data['cpage'] = 'portfolio_options';
        $data['cpagetitle'] = $innovation['name_of_enterprise'];
        $this->load->view('../template', $data);
    }

    public function detailed_diligence($id) {
        $data['id'] = $id;
        $innovation = $this->Minnovation->getinnovation($id);
        $data['cpage'] = 'detailed_diligence';
        $data['cpagetitle'] = $innovation['name_of_enterprise'];
        $this->load->view('../template', $data);
    }

    public function toexcel() {
        header("Content-type: application/vnd.ms-excel; name='excel'");
        header("Content-Disposition: filename=ficheroExcel.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo str_replace('\"', '"', $_POST['datatodisplay']);
    }

    public function email() {

        $config = array('protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'b.arvind@quadrupleindia.com',
            'smtp_pass' => 'Super@321',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );

        $this->load->library('email', $config);

        $this->email->to('barvind13@gmail.com');

        $this->email->subject('testing email');

        $this->email->message('hi this is a test email');

        if ($this->email->send()) {
            echo "mail sent successfully";
        } else {
            echo $this->email->print_debugger();
        }
    }

//////////added by muthu/////////

    public function manage_superadminusers() {
        $financialArray = $this->Mapproval->findCurrentFinancialYear();
        $from = $this->Mapproval->convertMonthYearFrom($financialArray[0]['from']);
        $year = substr($from, 0, 4);
        $month = substr($from, -2, 2);
        $date = '01';
        $data['from_financial'] = $year . '-' . $month . '-' . $date;
        $to = $this->Mapproval->convertMonthYearTo($financialArray[0]['to']);
        $year = substr($to, 0, 4);
        $month = substr($to, -2, 2);
        $date = '31';
        $data['to_financial'] = $year . '-' . $month . '-' . $date;
        $data['cpage'] = 'manage_users';

        $data['cpagetitle'] = 'Manage Users';

        $this->load->view('../template', $data);
    }

    /* bulk email section */

    public function deals_mail($mails = '') {
        checkAuth();
        $data['mailType'] = $this->Mmailtemplate->getMailtype();
        $data['mail_ids'] = $_POST['to_recipients'];
        if ($data['mail_ids'] != '') {
            $mail_idscount = explode(',', $_POST['to_recipients']);
            $data['count_ids'] = count($mail_idscount);
        } else {
            $data['count_ids'] = 0;
        }
        $data['to_inv_id'] = $_POST['to_inv_id'];


        if (isset($_POST['txtSubmit'])) {
            $result = $this->Mmail->bulkmailinsert($_POST);
            if ($result) {
                $this->session->unset_userdata('bulkmail_to');
                $this->session->unset_userdata('bulkmail_invs');
                $this->session->unset_userdata('bulkmail_mailtype');
                $this->session->unset_userdata('bulkmail_subject');
                $this->session->unset_userdata('bulkmail_body');
                $this->session->unset_userdata('bulkmail_from');
                $msg = "Saved Successfully. Email will be processed later automatically.";
                $this->session->set_flashdata('successMsg', $msg);
                redirect('login/deals_mail');
            }
        }
        if ($id == '') {
            $data['cpagetitle'] = "Send Mail";
            $data['mailDetails'] = array();
        } else {
            $data['cpagetitle'] = "Resend Mail";
            $data['mailDetails'] = $this->Mmail->getMailInfo($id);
        }

        /* filter details */
        $data['stage_list'] = $this->Minnovation->getInnvationStage();
        if ($this->session->userdata['role_id'] == '4' && $this->session->userdata['independent_shortlist'] == '1') {
            $data['status'] = $this->Minnovation->getIndependentStatus();
        } else {
            $data['status'] = $this->Minnovation->getInnvationStatus();
        }
        $branch_id = $this->session->userdata('partner_id');
        $accessto = $this->session->userdata['accessTo'];
        $data['partnerS'] = $this->Mportfolio->getPartnerDetails($accessto, $branch_id);
        $userSetup1 = $this->Mmaster->getUserSetup_branch($branch_id);
        $data['user_list'] = $this->Muser->getUsersList($userSetup1['abi'], $branch_id);

        $userSetup = $this->Mmaster->getUserSetup();
        $data['usersList'] = $this->Muser->getUsersList($userSetup['abi']);
        /* filter details ends */

        // $data['cpage'] = 'portfolio/deals_mail';
        $this->load->vars($data);
        $this->load->view('portfolio/deals_mail');
        // $data['cpagetitle'] = $innovation['name_of_enterprise'];
        // $this->load->view('../template', $data);
    }

    public function search_mailtemplate() {
        $partner_id = $this->session->userdata('partner_id');

        $mailContent = $this->Mmail->getBulkMailContent($_POST['mailtype'], $partner_id);
        if (count($mailContent)) {
            $data['subject'] = $mailContent[0]['subject'];
            $data['body'] = $mailContent[0]['body'];
            $data['from'] = $mailContent[0]['from'];
        } else {
            $data['subject'] = '';
            $data['body'] = '';
            $data['from'] = '';
        }

        echo json_encode($data);
    }

    public function deals_maillist($offset = '0') {
        $offset = isset($offset) ? $offset : 0;
        $options['num'] = '5';
        $options['offset'] = $offset;
        $data['mail'] = $this->Mmail->getBulkMails('', $options);
        $maillist = $this->Mmail->getBulkMails();

        $this->load->vars($data);
        $this->load->view('portfolio/deals_maillist');
    }

    public function mailist_view() {
        $id = $_POST['id'];
        $stat_id = $_POST['stat_id'];
        $bulkarr[] = "id = " . $id;
        $bulkwhr = implode(' and ', $bulkarr);
        $data['bulkmail'] = $bulkmail = $this->Mmail->getBulkMails($bulkwhr);

        $sender = $this->Muser->getUsersList($bulkmail[0]['sender_id']);

        $mailsarr[] = "bulk_id = " . $id;
        if ($stat_id != '') {
            $mailsarr[] = "status = " . $stat_id;
        }
        $whereM = implode(' and ', $mailsarr);
        $mail = $this->Mmail->MailDetails($whereM);

        $tabledata = '';
        if (count($mail) > 0) {
            foreach ($mail as $row) {

                if ($row['status'] == 0) {
                    $status = 'Pending';
                } else if ($row['status'] == 1) {
                    $status = 'Sent';
                } else {
                    $status = 'Failed';
                }

                $row_type = ($row_type == 'odd') ? ('even') : ('odd');

                $tabledata .= '<tr class="' . $row_type . '">';
                $tabledata .= '<td style="text-align: center;">' . $sender[0]['emp_name'] . '</td>';
                $tabledata .= '<td style="text-align: center;">' . $row["mail_to"] . '</td>';
                $tabledata .= '<td style="text-align: center;"><a href="' . site_url('login/assessment/' . $row["inv_id"]) . '" target="_blank">' . $row["inv_id"] . '</a></td>';
                $tabledata .= '<td style="text-align: center;">' . date('d-M-Y g:i A', strtotime($row["mail_sent_date"])) . '</td>';
                $tabledata .= '<td style="text-align: center;">' . $status . '</td>';

                $tabledata .= '<td style="text-align: center;"><a href="' . site_url('common/mail/history/' . $row["inv_id"]) . '" target="_blank">View</a></td></tr>';
            }
        } else {
            $tabledata .= '<tr><td colspan="6" style="text-align: center">No records found</td></tr>';
        }
        echo $tabledata;
    }

    public function recipients() {
        checkAuth();
        $data['cpage'] = 'recipients';
        // $data['cpagetitle'] = $innovation['name_of_enterprise'];
        $this->load->vars($data);
        $this->load->view('../template_plain');
    }

    public function search_dealsmail() {

        $requestData = $_POST;

        $data['sector'] = (isset($_POST['sector'])) ? $_POST['sector'] : '';
        $data['program'] = (isset($_POST['program'])) ? $_POST['program'] : '';
        $data['stage'] = (isset($_POST['stage'])) ? $_POST['stage'] : '';
        $data['status'] = (isset($_POST['status'])) ? implode(',', $_POST['status']) : '';
        $data['submitted_date'] = (isset($_POST['submitted_date'])) ? $_POST['submitted_date'] : '';
        $data['submitted_date_to'] = (isset($_POST['submitted_date_to'])) ? $_POST['submitted_date_to'] : '';
        $data['assigned_incharge'] = (isset($_POST['assigned_incharge'])) ? $_POST['assigned_incharge'] : '';
        $data['branch_name'] = $this->session->userdata('partner_id');

        $indep_user = 0;
        if ($user_id != '') {
            $check_user = $this->Muser->getIndepUsersList($branch_id, $user_id);
            $data['independent_shortlister'] = $indep_user = count($check_user);
        }

        $query = $this->Mportfolio->getSearchDeals($data);
        $recipient_table = "<table class='table table-hover dt-responsive ' id='search_table'>
        <thead class='dealNewClassBlk'>
        <tr>
        <th><input type='checkbox' checked class='typecheck' onchange='selectRecipient(this.value)' name='recipient_chk' id='recipient_chk_" . $i . "' value='" . $i . "' /><input type='hidden' name='recipient_select' id='recipient_select_" . $i . "' value='" . $row['email_id'] . "' /><input type='hidden' name='recipientinv_select' id='recipientinv_select_" . $i . "' value='" . $row['id'] . "' /></th>
        <th width='20%'>Entrepreneur Name</th>
        <th width='20%'>Enterprise Name</th>
        <th width='15%'>Sector</th>
        <th width='15%'>Program</th>
        <th width='15%'>Stage</th>
        <th width='15%'>Status</th>
        </tr>
        </thead>
        <tbody id='search_tbody' class=' scrolltblBodyDeal'>";

        $totalData = count($query);

        if ($totalData > 0) {
            $data = $mail_to = $mail_to_id = $orgmail_to_id = array();
            $i = $requestData['start'] + 1;
            foreach ($query as $row) {

                $ep = $row['name_of_enterprise'];
                $enterprise = $ep;
                $er = $row['name_of_entrepreneur'];
                $entrepreneur = "<span title='" . $row['name_of_entrepreneur'] . "'>" . $er . "</span></a>";


                if ($row['sector'] == 'MCH') {
                    $sector_name = 'Maternal & child health';
                } else if ($row['sector'] > 0) {
                    $sector_name = $this->Minnovation->getNewSectorDetails($row['sector']);
                } else if ($row['program'] > 0) {
                    $sector_name = $this->Minnovation->getSectorName($row['pitch_id']);
                } else {
                    $sector_name = $row['sector'];
                }

                $sector_len = $sector_name;
                $sector = "<span title='" . $sector_name . "'>" . $sector_len . "</span></a>";
                $stage = $this->Minnovation->getInnvationStage();
                $status = $this->Minnovation->getInnvationStatus();

                $stage_text = $stage[$row['stage']];
                $get_status_text = $status[$row['status']];
                $status_text = "<span title='" . $status[$row['status']] . "'>" . $get_status_text . "</span></a>";
                $assign = $row['associate_emp_name'];

                if ($row['program'] == '1') {
                    $program = 'EIR';
                } else if ($row['program'] == '2') {
                    $program = 'SEED';
                } else if ($row['program'] == '3') {
                    $program = 'Unc Pitch';
                } else if ($row['program'] == '4') {
                    $program = 'Incubation';
                } else if ($row['program'] == '0') {
                    $program = 'Incubation';
                }
                if ($row['email_id'] != '') {
                    $mail_to[] = $row['id'];
                    $mail_to_id[] = $row['email_id'];
                }


                $recipient_table .= "<tr>
                <td><input type='checkbox' checked class='typecheck' onchange='selectRecipient(this.value)' name='recipient_chk' id='recipient_chk_" . $i . "' value='" . $i . "' /><input type='hidden' name='recipient_select' id='recipient_select_" . $i . "' value='" . $row['email_id'] . "' /><input type='hidden' name='recipientinv_select' id='recipientinv_select_" . $i . "' value='" . $row['id'] . "' /></td>
                <td  width='20%' class='text-left'>" . $er . "</td>
                <td  width='20%' class='text-left'>" . $enterprise . "</td>
                <td  width='15%'>" . $sector_len . "</td>
                <td  width='15%'>" . $program . "</td>
                <td  width='15%'>" . $stage_text . "</td>
                <td  width='15%'>" . $get_status_text . "</td>
                </tr>";
                $i++;
            }
        } else {
            $recipient_table .= "<tr><td colspan='6' style='text-align:center;'>No records found</td></tr>";
        }

        $recipient_table .= "</tbody>
        </table>";
        if (count($mail_to_id) > 0) {
            $mail_ids = implode(',', array_filter($mail_to_id));
            $mail_invs = implode(',', array_filter($mail_to));
            $count_receips = count(array_filter($mail_to_id));
            $recipient_table .= "<form id='recipient_form' name='recipient_form' action='" . base_url() . "index.php/login/deals_mail' method='post'><input type='hidden' name='to_recipients' id='to_recipients' value='" . $mail_ids . "' /><input type='hidden' name='count_recipients' id='count_recipients' value='" . $count_receips . "' />";
            $recipient_table .= "<input type='hidden' class='to_inv_id' name='to_inv_id' id='to_inv_id' value='" . $mail_invs . "' /><input type='hidden' name='to_body' id='to_body' value='' /><input type='hidden' name='to_subject' id='to_subject' value='' /></form>";
        }
        echo $recipient_table . "||*||" . $totalData;
    }

}
