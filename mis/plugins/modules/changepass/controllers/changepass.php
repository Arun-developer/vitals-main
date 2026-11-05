<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Changepass extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->library('encrypt'); // Load encryption library
        $this->load->library('form_validation'); // Load form validation library
        $this->load->model('changepass/change_password_model');
    }

    public function index() {

        $this->load->helper(array('form', 'url')); // Load helper
        $data['cpagetitle'] = "Change Password Page";
        $data['left_box'] = array('ajax_left_box');
        $data['cpage'] = "change_password_view";
        $this->load->vars($data);
        $this->load->view('mis_change_password');
    }

    public function change_pass() {
        $old_pass = $this->input->post('oldPassword'); // Get the post datas from the user input
        $new_pass = $this->input->post('newPassword'); // post value
        $session_id = $this->session->userdata('emp_number'); // retrive user Id
        $pass = $this->change_password_model->databasePassword($session_id);
        $encrypted_pass = md5($old_pass);

        if ($_POST['txtSubmit']) {
            if ($pass['0']['password'] == $encrypted_pass) {
                $this->change_password_model->passwordUpdate($new_pass, $session_id);
                $this->session->set_flashdata('successMsg', 'Your password is updated successfully.');
            } else {
                $this->session->set_flashdata('errormsg', 'Please check your old password');
            }
        }
        redirect('changepass');
    }

    public function checkOldPassword() {
        $current_pswrd = $_POST['oldPassword'];
        $user_id = $this->session->userdata('emp_number');
        $pass = $this->change_password_model->databasePassword($user_id);
        $encrypted_pass = md5($current_pswrd);

        if ($pass['0']['password'] == $encrypted_pass) {
            $response = 'true';
        } else {
            $response = 'false';
        }
        echo $response;
    }

    public function changeEmailPasswordByUID() {

        $userDetails = $this->input->post('user');
        if ($this->input->post('submitEMail')) {
            $sessionID = $this->session->userdata('user_id');
            $this->change_password_model->insertUserID($sessionID, $userDetails);
        }
        redirect('changepass');
    }

}

/* End of file changepass.php */
