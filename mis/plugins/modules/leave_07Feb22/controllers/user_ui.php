<?php

class leave extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
    }
    
   
    public function deals() {
        $this->load->view('user/UI/deals/deals');
    }  
    // Admin Master
    public function partner() {
        $this->load->view('user/UI/master/partner');
    }
    public function add_partner() {
        $this->load->view('user/UI/master/add_partner');
    }
    // Employee Master
    public function employee_master() {
        $this->load->view('user/UI/master/employee_master');
    }
    public function personal_employee() {
        $this->load->view('user/UI/master/personal_employee');
    }
    public function login_employee() {
        $this->load->view('user/UI/master/login_employee');
    }
    public function job_salary_employee() {
        $this->load->view('user/UI/master/job_salary_employee');
    }
    // Leave & Calendar
    public function current_holiday_calendar() {
        $this->load->view('user/UI/master/current_holiday_calendar');
    }
    public function add_holiday() {
        $this->load->view('leave/ui/add_holiday');
    }
    public function archive_holiday_calendar() {
        $this->load->view('user/UI/master/archive_holiday_calendar');
    }
    public function week_setup() {
        $this->load->view('user/UI/master/week_setup');
    }
    public function leave_type() {
        $this->load->view('user/UI/master/leave_type');
    }


    public function work_from_home() {
        $this->load->view('user/UI/work_from_home');
    }
    
}


?>