<?php
class Mip extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $data['username'] = $this->session->userdata('user_name');
        $data['password'] = $this->session->userdata('password');
        $data['cpagetitle'] = "Program Management System";
        $data['cpage'] = "mip_view";
        $this->load->view('../dashboard_template', $data);
    }
}
