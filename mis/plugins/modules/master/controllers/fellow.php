<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Fellow extends CI_Controller
{
    public function _construct()
    {
        parent::_construct();
    }
    public function add()
    {
        $data = array();
        if (isset($_POST['txtsubmit'])) {
            $this->load->model('master/Mfellow');
            $this->Mfellow->add_kra($_POST);
            $this->session->set_flashdata('successMsg', 'KRA Details Added Successfully');
        }
        $this->load->model('login/Muser');
        $data['userList'] = $this->Muser->getUsersList();
        $data['cpage'] = "master/add_kra";
        $data['cpagetitle'] = 'Add KRA Sheet';
        $this->load->vars($data);
        $this->load->view('../template');
    }
    public function view_list()
    {
        $this->load->model('master/Mfellow');
        $data['kra_list'] = $this->Mfellow->getkra_list();
        $data['cpage'] = 'master/list_kra';
        $data['cpagetitle'] = 'KRA Sheet';
        $this->load->view('../template', $data);
    }
}
