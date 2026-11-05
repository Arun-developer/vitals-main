<?php

class Structure extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->model('Mstructure');
    }
    public function index()
    {
        $data['structure'] = $this->Mstructure->getstructure();
        $data['cpage'] = 'structure';
        $data['cpagetitle'] = 'Company Structure';
        $this->load->view('../template', $data);
    }
}
