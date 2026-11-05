<?php

class Incubatee extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mincubateeuser');
    }

    public function index()
    {
        $this->unsetSession();
        if ($this->input->post('txtIncubateeSubmit')) {
            $this->form_validation->set_rules('incubateeUsername', 'Username', 'required');
            $this->form_validation->set_rules('incubateePassword', 'Password', 'required');
            if ($this->form_validation->run() != false) {
                $responce = $this->Mincubateeuser->loginUser($this->input->post('incubateeUsername'), $this->input->post('incubateePassword'));if (count($responce) > 0) {
                    foreach ($responce as $result) {
                        $userDetails = array(
                            'user_id' => $result['id'],
                            'emp_number' => '',
                            'innovation' => $result['innovation'],
                            'emp_name' => $result['user_name'],
                            'user_name' => $result['user_name'],
                            'user_type' => 'incubatee',
                            'partner_id' => $result['partner_id'],
                        );
                    }
                    $this->session->set_userdata($userDetails);
                    if ($this->session->userdata['partner_id'] == 1) {
                        $innovation = $responce[0]['innovation'];
                        $this->session->set_flashdata('successMsg', 'You are Logged In!');
                        redirect('seedfunding/view/' . $innovation);
                    } else {
                        $data['errorMsg'] = "Invalid username or password!";
                    }
                } else {
                    $data['errorMsg'] = "Invalid username or password!";
                }
            } else {
                $data['errorMsg'] = "Validation error found, check it again!";
            }
        }
        $data['cpagetitle'] = "Login Panel for Incubatee";
        $data['cpage'] = "incubateelogin";
        $this->load->vars($data);
        $this->load->view('login');
    }

    public function logout()
    {
        $this->unsetSession();
        $this->session->set_flashdata('successMsg', 'You are Logged out Successfully!');
        redirect('login');
    }

    public function unsetSession()
    {
        $userDetails = array('user_id' => '',
            'innovation' => '',
            'emp_name' => '',
            'user_name' => '',
        );
        $this->session->unset_userdata($userDetails);
    }
    public function incubatee_menu($innovation)
    {
        $data['id'] = $innovation;
        $data['cpage'] = 'i_menu';
        $data['cpagetitle'] = 'Incubatee Menu';
        $this->load->view('../template', $data);
    }
    public function company_info($innovation)
    {
        $data['id'] = $innovation;
        $data['cpage'] = 'company_info';
        $data['cpagetitle'] = 'Company Info';
        $this->load->view('../template', $data);
    }
    public function villgro_service($innovation)
    {
        $data['id'] = $innovation;
        $data['cpage'] = 'villgro_service';
        $data['cpagetitle'] = 'Villgro Service';
        $this->load->view('../template', $data);
    }
    public function report_villgro($innovation)
    {
        $data['id'] = $innovation;
        $data['cpage'] = 'report_villgro';
        $data['cpagetitle'] = 'Report to Villgro';
        $this->load->view('../template', $data);
    }

}
