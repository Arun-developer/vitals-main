<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['base_upload_folder'] = 'uploads';

$config['upload_networking'] = array(
    "upload_path" => './uploads/networking/',
    "allowed_types" => 'txt|pdf|doc|docx',
    "max_size" => '0',
    "max_width" => '1024',
    "max_height" => '768',
    "remove_spaces" => 'TRUE',
    "overwrite" => 'TRUE'
);
$config['success_message'] = array(
    "message" => "Details Updated Successfully",
    "delete" => "Selected items(s) deleted successfully",
    "message_add" => "Details Added Successfully",
    "login_err" => "<p>Invalid User Name/Password</p>",
    "login_activation" => "<p>Please Activate your account.</p>"
);

$config['ais_url'] = $_SERVER['HTTP_HOST'] . "/vital_ais/index.php/";
$config['hris_url'] = $_SERVER['HTTP_HOST'] . "/ctl_vill/login.php";
$config['hris_url1'] = $_SERVER['HTTP_HOST'] . "/ctl_vill/superadminlogin.php";
