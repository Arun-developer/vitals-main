<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        #error_reporting(-1)
        parent::__construct();
    }

    public function setErrorMessage($type = "", $msg = "", $ajax = false) {
        $msg_type = '';
        if ($type != '' && $msg != '') {
            if ($type == 'Success') {
                $this->session->set_flashdata('Success', $msg);
            } else if ($type == 'error') {
                $this->session->set_flashdata('error', $msg);
            }
        }
        #echo $this->session->flashdata('error');die;
    }

    public function getAuthorization() {
        $getName = '';
        if ($this->session->userdata('user_type') == 'admin' and $this->session->userdata('role_id') == 2) {
            $getName = $this->session->userdata('emp_name');
        } else if ($this->session->userdata('user_type') == 'employee' and $this->session->userdata('role_id') == 2) {
            $getName = $this->session->userdata('emp_name');
        } else if ($this->session->userdata('user_type') == 'admin' and $this->session->userdata('role_id') == 1) {
            $getName = $this->session->userdata('emp_name');
        } else if ($this->session->userdata('user_type') != 'admin' and $this->session->userdata('user_type') != 'mipuser') {
            $getName = $this->session->userdata('emp_name');
        } else {
            if ($this->session->userdata('user_type') != 'admin') {
                $getName = $this->session->userdata('name');
            }
        }
        return $getName;
    }

    public function numberToCurrency($num, $type = '') { #echo $num;die;
        $RES = explode('.', $num);
        $num = $RES[0];
        $digit = '';
        if ($RES[1] > 0) {
            $digit = '.' . $RES[1];
        }
        if ($type == 'view') {
            $digit = '.' . $RES[1];
        }
        if (setlocale(LC_MONETARY, 'en_IN'))
            return money_format('%.0n', $num);
        else {
            $explrestunits = "";
            if (strlen($num) > 3) {
                $lastthree = substr($num, strlen($num) - 3, strlen($num));
                $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
                $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
                $expunit = str_split($restunits, 2);
                for ($i = 0; $i < sizeof($expunit); $i++) {
                    // creates each of the 2's group and adds a comma to the end
                    if ($i == 0) {
                        $explrestunits .= (int) $expunit[$i] . ","; // if is first value , convert into integer
                    } else {
                        $explrestunits .= $expunit[$i] . ",";
                    }
                }
                $thecash = $explrestunits . $lastthree . $digit;
            } else {
                $thecash = $num . $digit;
            }
            return '' . $thecash;
        }
    }

    public function getUsers() {

        $status['finance_user'] = '0';
        $status['donor_team'] = '0';
        $status['admin_user'] = '0';
        $this->load->model('Funder_model');

        $user_id = $this->session->userdata('emp_number');
        $settings = $this->funder_model->get_all_details('approval_setting', array('partner_id' => $this->session->userdata('partner_id')), array('finance'), '', '', '', true, 'ais');
        if (isset($settings[0]) && $settings[0] != '') {
            $financeUsers = unserialize($settings[0]->finance);
            $conditions = array('emp_id' => $financeUsers);
            #$getFinanceUsers = $this->funder_model->get_all_details_win('hr_users',$conditions,array('emp_number'),'','','',true,'hris');
            $getFinanceUsers = $this->funder_model->get_all_details_win('hr_user_login', $conditions, array('emp_id'));
            if (!empty($getFinanceUsers)) {
                $getFinanceUsers = json_decode(json_encode($getFinanceUsers), true);
                $emp_number = array_column($getFinanceUsers, 'emp_id');
                if (in_array($user_id, $emp_number)) {
                    $status['finance_user'] = '1';
                }
            }
        }
        $getDonorTeams = $this->Mmaster->getDonorTeam('user_setup', $this->session->userdata('partner_id'));
        $getDonorUser = unserialize($getDonorTeams[0]['donor_team']);
        if (in_array($user_id, $getDonorUser)) {
            $status['donor_team'] = '1';
        }
        if ($this->session->userdata('role_id') == 2 && $this->session->userdata('user_type') == 'admin') {
            $status['admin_user'] = '1';
        }
        if ($this->session->userdata('user_type') == 'superadmin') {
            $status['super_admin'] = '1';
        }
        return $status;
    }

}

/* The MX_Controller class is autoloaded as required */