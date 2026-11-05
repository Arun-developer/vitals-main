<?php

class Change_password_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('encrypt'); // Load encryption library
    }

    // Update the password in database with New password from user input

    function passwordUpdate($new_pass, $session_id) {
        $encryptpass = md5($new_pass); // Encode the password
        $data = array('password' => $encryptpass);
        $this->db->where('emp_id', $session_id);
        $this->db->update('hr_user_login', $data);
        return true;
    }

    function databasePassword($session_id) {
        $this->db->select('password');
        $this->db->where('emp_id', $session_id);
        $query = $this->db->get('hr_user_login');
        $check = $query->result_array();
        return $check;
    }

    function insertUserID($sessionID, $postData) {

        $encrypted_password = base64_encode($postData['txtPassword']);

        $data = array(
            'user_id' => $sessionID,
            'login_id' => $postData['txtemail'],
            'password' => $encrypted_password,
            'created_date' => date("Y-m-d")
        );

        if ($this->checkDuplicate($sessionID)) {

            $this->db->insert('gmail_user_details', $data);
        } else {

            $this->db->where('user_id', $sessionID);

            $this->db->update('gmail_user_details', $data);
        }

        return true;
    }

    function checkDuplicate($sessionID) {

        $this->db->select("user_id,login_id");

        $this->db->where("user_id", $sessionID);

        $result = $this->db->get('gmail_user_details');

        if ($result->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    function getEmailDetailsByID($userID) {

        if ($this->checkDuplicate($userID)) {

            $value = '0';

            return $value;
        } else {

            $this->db->select("login_id,password");

            $this->db->where("user_id", $userID);

            $query = $this->db->get('gmail_user_details');

            $data = $query->result_array();

            $result['login'] = @$data['0']['login_id'];

            $result['password'] = base64_decode($data['0']['password']);

            return $result;
        }
    }

}
