<?php

class User_ui extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    // ********** Request **********
    // Leave
    public function leave_list() {
        $this->load->view('user/UI/request/leave_list');
    }

    public function view_leave_list() {
        $this->load->view('user/UI/request/view_leave_list');
    }

    public function apply_leave() {
        $this->load->view('user/UI/request/apply_leave');
    }

    public function approve_leave_list() {
        $this->load->view('user/UI/request/approve_leave_list');
    }

    public function leave_summary() {
        $this->load->view('user/UI/request/leave_summary');
    }

    public function leave_archive_2020() {
        $this->load->view('user/UI/request/leave_archive_2020');
    }

    public function leave_archive_2019() {
        $this->load->view('user/UI/request/leave_archive_2019');
    }

    public function leave_archive_2018() {
        $this->load->view('user/UI/request/leave_archive_2018');
    }

    public function leave_archive_2017() {
        $this->load->view('user/UI/request/leave_archive_2017');
    }

    public function leave_archive_2016() {
        $this->load->view('user/UI/request/leave_archive_2016');
    }

    public function leave_archive_2015() {
        $this->load->view('user/UI/request/leave_archive_2015');
    }

    //**********  Deal *************
    public function deals() {
        $this->load->view('user/UI/deals/deals');
    }

    public function mydeals() {
        $this->load->view('user/UI/deals/mydeals');
    }

    public function deals_pre_assitant() {
        $this->load->view('user/UI/deals/deals_pre_assitant');
    }

    public function deals_all_mails() {
        $this->load->view('user/UI/deals/deals_all_mails');
    }

    public function deals_external_mail() {
        $this->load->view('user/UI/deals/deals_external_mail');
    }

    public function deals_send_mail() {
        $this->load->view('user/UI/deals/deals_send_mail');
    }

    public function deals_all_doc() {
        $this->load->view('user/UI/deals/deals_all_doc');
    }

    public function deals_upload_doc() {
        $this->load->view('user/UI/deals/deals_upload_doc');
    }

    public function deals_info_about_enterprise() {
        $this->load->view('user/UI/deals/deals_info_about_enterprise');
    }

    public function deals_impact_of_innovation() {
        $this->load->view('user/UI/deals/deals_impact_of_innovation');
    }

    public function deals_addition_info() {
        $this->load->view('user/UI/deals/deals_addition_info');
    }

    public function investment_thesis() {
        $this->load->view('user/UI/deals/investment_thesis');
    }

    public function detailed_diligence_summary() {
        $this->load->view('user/UI/deals/detailed_diligence_summary');
    }
    public function detailed_company_team() {
        $this->load->view('user/UI/deals/detailed_company_team');
    }
    public function detailed_document_meeting() {
        $this->load->view('user/UI/deals/detailed_document_meeting');
    }
    public function detailed_asessment() {
        $this->load->view('user/UI/deals/detailed_asessment');
    }

    //**********  Request *************
    // Approval Note
    public function all_pending_AN() {
        $this->load->view('user/UI/request/approval-note/all_pending_AN');
    }

    public function approve_PH() {
        $this->load->view('user/UI/request/approval-note/approve_PH');
    }

    public function approve_RO() {
        $this->load->view('user/UI/request/approval-note/approve_RO');
    }

    public function my_approval_notes() {
        $this->load->view('user/UI/request/approval-note/my_approval_notes');
    }

    public function view_my_approval_notes() {
        $this->load->view('user/UI/request/approval-note/view_my_approval_notes');
    }

    public function edit_my_approval_notes() {
        $this->load->view('user/UI/request/approval-note/edit_my_approval_notes');
    }

    public function new_approval_note() {
        $this->load->view('user/UI/request/approval-note/new_approval_note');
    }

    // Internal Note
    public function all_pending_IN() {
        $this->load->view('user/UI/request/internal-note/all_pending_IN');
    }

    public function internalnote_approve_PH() {
        $this->load->view('user/UI/request/internal-note/approve_PH');
    }

    public function internalnote_approve_RO() {
        $this->load->view('user/UI/request/internal-note/approve_RO');
    }

    public function my_internal_notes() {
        $this->load->view('user/UI/request/internal-note/my_internal_notes');
    }

    public function view_my_internal_notes() {
        $this->load->view('user/UI/request/internal-note/view_my_internal_notes');
    }

    public function edit_my_internal_notes() {
        $this->load->view('user/UI/request/internal-note/edit_my_internal_notes');
    }

    public function new_internal_note() {
        $this->load->view('user/UI/request/internal-note/new_internal_note');
    }

    public function finance_update() {
        $this->load->view('user/UI/request/internal-note/finance_update');
    }

    // Assets
    public function assets_in_use() {
        $this->load->view('user/UI/request/assets/assets_in_use');
    }

    public function salary_deduction() {
        $this->load->view('user/UI/request/assets/salary_deduction');
    }

    public function transaction_history() {
        $this->load->view('user/UI/request/assets/transaction_history');
    }

    public function available_asset_list() {
        $this->load->view('user/UI/request/assets/available_asset_list');
    }

    public function assets_not_available() {
        $this->load->view('user/UI/request/assets/assets_not_available');
    }

    public function assets_payment() {
        $this->load->view('user/UI/request/assets/assets_payment');
    }

    public function add_avail_asset_payment() {
        $this->load->view('user/UI/request/assets/add_avail_asset_payment');
    }

    public function add_asset_payment() {
        $this->load->view('user/UI/request/assets/add_asset_payment');
    }

    //**********  Funds & Grants *************
    public function funds_grant_list() {
        $this->load->view('user/UI/fund_grant/funds_grant_list');
    }

    public function donor_information() {
        $this->load->view('user/UI/fund_grant/donor_information');
    }

    public function grants() {
        $this->load->view('user/UI/fund_grant/grants');
    }

    public function add_grants_table() {
        $this->load->view('user/UI/fund_grant/add_grants_table');
    }

    public function documents() {
        $this->load->view('user/UI/fund_grant/documents');
    }

    public function grants_details() {
        $this->load->view('user/UI/fund_grant/grants_details');
    }

    public function add_donor() {
        $this->load->view('user/UI/fund_grant/add_donor');
    }

    public function add_grants() {
        $this->load->view('user/UI/fund_grant/add_grants');
    }

    public function add_documents() {
        $this->load->view('user/UI/fund_grant/add_documents');
    }

    //**********  Master *************
    // Admin Master
    //--------- Master Settings---------
    public function travel_mode() {
        $this->load->view('user/UI/master/master-setting/travel_mode');
    }

    public function add_travel_mode() {
        $this->load->view('user/UI/master/master-setting/add_travel_mode');
    }

    public function books_category() {
        $this->load->view('user/UI/master/master-setting/books_category');
    }

    public function add_books_category() {
        $this->load->view('user/UI/master/master-setting/add_books_category');
    }

    //--------- Master Settings ( Budget Tab )---------
    public function balance_sheet() {
        $this->load->view('user/UI/master/master-setting/balance_sheet');
    }

    public function donor_amount() {
        $this->load->view('user/UI/master/master-setting/donor_amount');
    }

    public function donor_amount_list() {
        $this->load->view('user/UI/master/master-setting/donor_amount_list');
    }

    public function donor_amount_action_history() {
        $this->load->view('user/UI/master/master-setting/donor_amount_action_history');
    }

    public function action_history() {
        $this->load->view('user/UI/master/master-setting/action_history');
    }

    public function add_balance_sheet_amount() {
        $this->load->view('user/UI/master/master-setting/add_balance_sheet_amount');
    }

    public function balance_sheet_report() {
        $this->load->view('user/UI/master/master-setting/balance_sheet_report');
    }

    public function add_donor_amount() {
        $this->load->view('user/UI/master/master-setting/add_donor_amount');
    }

    public function programme() {
        $this->load->view('user/UI/master/master-setting/programme');
    }

    public function add_programme() {
        $this->load->view('user/UI/master/master-setting/add_programme');
    }

    public function no_due_certificate() {
        $this->load->view('user/UI/master/no_due_certificate');
    }

    //---------- End Master Settings------
    //--------- Partners ---------
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

    public function job() {
        $this->load->view('user/UI/master/job');
    }

    public function view_job() {
        $this->load->view('user/UI/master/view_job');
    }

    public function add_job() {
        $this->load->view('user/UI/master/add_job');
    }

    public function job_location() {
        $this->load->view('user/UI/master/job_location');
    }

    public function add_job_location() {
        $this->load->view('user/UI/master/add_job_location');
    }

    public function view_job_location() {
        $this->load->view('user/UI/master/view_job_location');
    }

    // Leave & Calendar
    public function current_holiday_calendar() {
        $this->load->view('user/UI/master/current_holiday_calendar');
    }

    public function add_holiday() {
        $this->load->view('user/UI/master/add_holiday');
    }

    public function archive_holiday_calendar() {
        $this->load->view('user/UI/master/archive_holiday_calendar');
    }

    public function week_setup() {
        $this->load->view('user/UI/master/week_setup');
    }

    public function working_days() {
        $this->load->view('user/UI/master/working_days');
    }

    public function add_working_days() {
        $this->load->view('user/UI/master/add_working_days');
    }

    public function leave_type() {
        $this->load->view('user/UI/master/leave_type');
    }

    public function add_leave_type() {
        $this->load->view('user/UI/master/add_leave_type');
    }

    // Incubation master
    public function reject_reason() {
        $this->load->view('user/UI/master/incubation-master/reject-reason');
    }

    public function add_reject_reason() {
        $this->load->view('user/UI/master/incubation-master/add_reject_reason');
    }

    public function user_setup() {
        $this->load->view('user/UI/master/incubation-master/user-setup');
    }

    public function sector_incubation() {
        $this->load->view('user/UI/master/incubation-master/sector_incubation');
    }

    public function master_settings() {
        $this->load->view('user/UI/master/incubation-master/master_settings');
    }

    public function granding_master() {
        $this->load->view('user/UI/master/incubation-master/granding_master');
    }

    public function add_grade_form() {
        $this->load->view('user/UI/master/incubation-master/add_grade_form');
    }

    public function stage_efficiency() {
        $this->load->view('user/UI/master/incubation-master/stage_efficiency');
    }

    public function mail_template() {
        $this->load->view('user/UI/master/incubation-master/mail_template');
    }

    public function sectors() {
        $this->load->view('user/UI/master/incubation-master/sectors');
    }

    public function view_sectors() {
        $this->load->view('user/UI/master/incubation-master/view_sectors');
    }

    public function work_from_home() {
        $this->load->view('user/UI/work_from_home');
    }

    //**********  Login *************
    public function login() {
        $this->load->view('user/UI/login/login');
    }

    public function forgot_password() {
        $this->load->view('user/UI/login/forgot_password');
    }

    public function change_password() {
        $this->load->view('user/UI/login/change_password');
    }

}

?>