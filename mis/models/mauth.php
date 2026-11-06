<?php

class Mauth extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->hris = $this->load->database('hris', TRUE);
        $this->load->model('master/Mmaster');
    }

    /* CHECK IS EMPLOYEE LOGGED IN */

    function isLoggedCheck() {
        if ($this->session->userdata('user_id') == '') {
            $this->session->set_flashdata('warningMsg', 'Please Login to Access this page');
            redirect('login');
        }
    }

    function isPartnerCheck() {
        $this->isLoggedCheck();
        if (php72_cmp($this->session->userdata('ais_privilege')) != 1) {
            $this->session->set_flashdata('warningMsg', 'You are not Authorized to view this page');
            redirect('login');
        }
    }

    /* CHECK IS ADMIN LOGGED IN */

    function isAdminCheck() {
        $this->isLoggedCheck();
        if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
            $this->session->set_flashdata('warningMsg', 'You are not Authorized to view this page');
            redirect('login');
        }
    }

    function isSuperAdminCheck() {
        $this->isLoggedCheck();
        if ($this->session->userdata('user_type') != 'superadmin') {
            $this->session->set_flashdata('warningMsg', 'You are not Authorized to view this page');
            redirect('login');
        }
    }

    /* GET USER TYPE */

    function getUserType($emp_number = '', $branch = '', $role = '') {
        if (php72_cmp($role) == 1) {
            $user = $this->Mmaster->getUserSetup_branch($branch);
            if ($emp_number == $user['ceo'])
                return 'ceo';
            if ($emp_number == $user['cio'])
                return 'cio';
            if (php72_in_array($emp_number, $user['icm']))
                return 'icm';
            if (php72_in_array($emp_number, $user['abi']))
                return 'abi';
        }
        if (php72_cmp($role) == 2) {
            return 'admin';
        }
        if (php72_cmp($role) == 3)
            return 'superadmin';

        #DEFAULT
        return 'employee';
    }

    function isLogged() {
        if ($this->session->userdata('user_id') == '')
            return false;
        else
            return true;
    }

}

?>
