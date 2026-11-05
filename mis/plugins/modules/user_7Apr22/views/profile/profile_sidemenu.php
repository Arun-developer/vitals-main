<style type="text/css">
    .sidebar_show { display: block !important; }
    .sidebar-dropdown.active .sidebar-submenu { display: block !important; }
</style>

<?php
if ($page == 'emp_list') {
    $employee_active = 'active';
    $employee_menu = 'show';
} else if ($page == 'job') {
    $job_active = 'active';
    $job_menu = 'show';
} else if ($page == 'holiday') {
    $holiday_active = 'active';
    $holiday_menu = 'show';
} else if ($page == 'work_type') {
    $work_type_active = 'active';
    $work_type_menu = 'show';
} else if ($page == 'week_setup') {
    $work_setup_active = 'active';
    $work_setup_menu = 'show';
} else if ($page == 'work_days') {
    $work_days_active = 'active';
    $work_days_menu = 'show';
} else if ($page == 'working_days') {
    $working_days_active = 'active';
    $working_days_menu = 'show';
} else if ($page == 'leave_type') {
    $leave_type_active = 'active';
    $leave_type_menu = 'show';
} else if ($page == 'partner') {
    $partner_active = 'active';
    $partner_menu = 'show';
} else if ($page == 'admin_master') {
    $admin_master_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'asset_master') {
    $asset_setting_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'books_master') {
    $books_setting_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'visitors_log') {
    $log_setting_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'dispatch_inward') {
    $inward_setting_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'dispatch_outward') {
    $outward_setting_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'nodue') {
    $due_setting_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'pay_grade') {
    $pay_grade_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'leave') {
    $leave_active = 'active';
    $leave_menu = 'show';
} else if ($page == 'user_setup') {
    $usersetup_active = 'active';
    $employee_menu = 'show';
} else if ($page == 'incubation_masters') {
    $incubation_master_active = 'active';
    $incubation_master_menu = 'show';
} else if ($page == 'reason') {
    $reason_setting_active = 'active';
    $incubation_master_menu = 'show';
} else if ($page == 'donor_fit') {
    $donor_setting_active = 'active';
    $incubation_master_menu = 'show';
} else if ($page == 'portfolio_settings') {
    $portfolio_settings_active = 'active';
    $incubation_master_menu = 'show';
} else if ($page == 'mail_template') {
    $mail_template_active = 'active';
    $incubation_master_menu = 'show';
} else if ($page == 'approval_note') {
    $approval_note_active = 'active';
    $approval_note_menu = 'show';
}
?>

<?php if ($left_menu == 'approve') { ?>
    <div id="leftMenuLoad">
        <nav class="navbar navbar-expand-lg ">
            <div class="collapse navbar-collapse show" id="navbarCollapse">
                <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
                    <li class="nav-item <?= $approval_note_menu; ?> <?= $approval_note_active; ?>">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems2" aria-controls="collapseSubItems2" aria-expanded="false"><i class="fas fa-user-friends"></i> Approval Note</a>
                        <ul class="nav-second-level collapse <?= $approval_note_menu; ?> <?= $new_approval_note_menu; ?>" id="collapseSubItems2" data-parent="#navAccordion">
                            <li class="nav-item <?= $my_approval_note_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/approval/new_approval'; ?>">
                                    <span class="nav-link-text">Raise Approval Note</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $approval_note_active; ?>">
                                <?php /* user/user_ui/approve_RO  */ ?>
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/approval/approval_note/pending/rolist'; ?>">
                                    <span class="nav-link-text">Approve</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item <?= $my_internal_note_active; ?> <?= $new_internal_note_active; ?>">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Internal Note</a>
                        <ul class="nav-second-level collapse <?= $my_internal_note_menu; ?> <?= $new_internal_note_menu; ?>" id="collapseSubItems3" data-parent="#navAccordion">
                            <li class="nav-item <?= $my_internal_note_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/new_internal_note'; ?>">
                                    <span class="nav-link-text">Raise internal note</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $new_internal_note_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/internalnote_approve_RO'; ?>">
                                    <span class="nav-link-text">Approve</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item <?= $leave_active; ?> <?= $approve_leave_active; ?>">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-user-friends"></i> Leave</a>
                        <ul class="nav-second-level collapse <?= $leave_menu; ?> <?= $approve_leave_menu; ?>" id="collapseSubItems4" data-parent="#navAccordion">
                            <li class="nav-item  <?= $leave_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/apply_leave'; ?>">
                                    <span class="nav-link-text">Apply For Leave</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $approve_leave_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/approve_leave_list'; ?>">
                                    <span class="nav-link-text">Approve</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems5" aria-controls="collapseSubItems5" aria-expanded="false"><i class="fas fa-user-friends"></i> Book</a>
                        <ul class="nav-second-level collapse " id="collapseSubItems5" data-parent="#navAccordion">
                            <li class="nav-item ">
                                <a class="nav-link" href="#">
                                    <span class="nav-link-text">Request for a book</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="nav-link-text">Requests</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Travel & Accomodation </a>
                    </li> -->
                    <li class="nav-item <?= $assets_use_active; ?> <?= $assets_transaction_active; ?> <?= $assets_salary_active; ?> <?= $assets_available_active; ?> <?= $assets_not_available_active; ?> <?= $assets_payment_active; ?> ">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems6" aria-controls="collapseSubItems6" aria-expanded="false"><i class="fas fa-user-friends"></i> Assets </a>
                        <ul class="nav-second-level collapse <?= $assets_use_menu; ?> <?= $assets_transaction_menu; ?> <?= $assets_salary_menu; ?> <?= $assets_available_menu; ?> <?= $assets_not_available_menu; ?> <?= $assets_payment_menu; ?>" id="collapseSubItems6" data-parent="#navAccordion">
                            <li class="nav-item <?= $assets_use_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/assets_in_use'; ?>">
                                    <span class="nav-link-text">Assets In Use</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $assets_transaction_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/transaction_history'; ?>">
                                    <span class="nav-link-text">Transaction History</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $assets_salary_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/salary_deduction'; ?>">
                                    <span class="nav-link-text">Salary Deduction</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $assets_available_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/available_asset_list'; ?>">
                                    <span class="nav-link-text">Available Asset List</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $assets_not_available_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/assets_not_available'; ?>">
                                    <span class="nav-link-text">Assets Not Available</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $assets_payment_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/assets_payment'; ?>">
                                    <span class="nav-link-text">Asset Payments</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
<?php } else { ?>
    <div id="leftMenuLoad">
        <nav class="navbar navbar-expand-lg">
            <div class="collapse navbar-collapse show" id="navbarCollapse">
                <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
                    <li class="nav-item <?= $holiday_active; ?> <?= $work_type_active; ?> <?= $work_days_active; ?> <?= $work_setup_active; ?> <?= $working_days_active; ?> <?= $leave_type_active; ?>">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems5" aria-controls="collapseSubItems5" aria-expanded="false"><i class="fas fa-user-friends"></i> Leave & Calendars</a>
                        <ul class="nav-second-level collapse <?= $holiday_menu; ?> <?= $work_type_menu; ?> <?= $work_days_menu; ?> <?= $work_setup_menu; ?> <?= $working_days_menu; ?> <?= $leave_type_menu; ?>" id="collapseSubItems5" data-parent="#navAccordion">
                            <li class="nav-item  <?= $holiday_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/current_holiday_calendar'; ?>">
                                    <span class="nav-link-text">Holidays Details</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $work_setup_active; ?>" >
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/week_setup'; ?>">
                                    <span class="nav-link-text">Week Setup</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $working_days_active; ?>" >
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/working_days'; ?>">
                                    <span class="nav-link-text">Working Days</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $leave_type_active; ?>" >
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/leave_type'; ?>">
                                    <span class="nav-link-text">Leave Type</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item <?= $partner_active; ?> <?= $admin_master_active; ?> <?= $asset_setting_active; ?> <?= $books_setting_active; ?> <?= $log_setting_active; ?> <?= $inward_setting_active; ?> <?= $outward_setting_active; ?> <?= $due_setting_active; ?> <?= $job_active; ?> <?= $pay_grade_active; ?>">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems2" aria-controls="collapseSubItems2" aria-expanded="false"><i class="fas fa-user-friends"></i> Admin Master</a>
                        <ul class="nav-second-level scrollsideMenu collapse <?= $partner_menu; ?> <?= $admin_master_menu; ?> <?= $job_menu; ?>" id="collapseSubItems2" data-parent="#navAccordion">
                            <li class="nav-item <?= $admin_master_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/master/balance_sheet'; ?>">
                                    <span class="nav-link-text">Budget</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $asset_setting_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/master/asset'; ?>">
                                    <span class="nav-link-text">Assets</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $books_setting_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/master/books_master'; ?>">
                                    <span class="nav-link-text">Books</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $log_setting_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/master/visitors_log'; ?>">
                                    <span class="nav-link-text">Visitor's Log</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $inward_setting_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/master/dispatch_inward'; ?>">
                                    <span class="nav-link-text">Dispatch Inward</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $outward_setting_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/master/dispatch_outward'; ?>">
                                    <span class="nav-link-text">Dispatch Outward</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $due_setting_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/master/nodue_certificate'; ?>">
                                    <span class="nav-link-text">No Due Certificate</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $job_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/job/lists'; ?>">
                                    <span class="nav-link-text">Job</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $pay_grade_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/master/pay_grade'; ?>">
                                    <span class="nav-link-text">Pay Grade</span>
                                </a>
                            </li>
                            <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                <li class="nav-item <?= $partner_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/master/partners_list'; ?>">
                                        <span class="nav-link-text">Partners</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>

                    <li class="nav-item <?= $employee_active; ?> <?= $leave_active; ?> <?= $usersetup_active; ?>">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-user-friends"></i> Employee Master</a>
                        <ul class="nav-second-level collapse <?= $employee_menu; ?>  <?= $leave_menu; ?>" id="collapseSubItems4" data-parent="#navAccordion">
                            <li class="nav-item <?= $employee_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/user/lists/3'; ?>">
                                    <span class="nav-link-text">Employee Details</span>
                                </a>
                            </li>
                            <li class="nav-item  <?= $leave_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/leave_summary'; ?>">
                                    <span class="nav-link-text">Leave Allocation</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $usersetup_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_setup'; ?>">
                                    <span class="nav-link-text">User Setup</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item <?= $incubation_master_active; ?> <?= $reason_setting_active; ?> <?= $donor_setting_active; ?> <?= $portfolio_settings_active; ?> <?= $mail_template_active; ?>">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Incubation Master</a>
                        <ul class="nav-second-level collapse scrollsideMenu <?= $partner_menu; ?> <?= $incubation_master_menu; ?>" id="collapseSubItems3" data-parent="#navAccordion">

                            <li class="nav-item <?= $incubation_master_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/sectors'; ?>">
                                    <span class="nav-link-text">Sector</span>
                                </a>
                            </li>
                            <li class="nav-item  <?= $reason_setting_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/reason'; ?>">
                                    <span class="nav-link-text">Reasons</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $donor_setting_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/donor_fit'; ?>">
                                    <span class="nav-link-text">Donor Fit</span>
                                </a>
                            </li>
                            <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                <li class="nav-item <?= $master_settings_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/master_settings/source_type'; ?>">
                                        <span class="nav-link-text">Master Settings</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="nav-item <?= $portfolio_settings_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/portfolio_settings/designation'; ?>">
                                    <span class="nav-link-text">Portfolio Settings</span>
                                </a>
                            </li>
                            <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                <li class="nav-item <?= $stage_efficiency_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/stage_efficiency'; ?>">
                                        <span class="nav-link-text">Stage Efficiency</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                <li class="nav-item <?= $document_type_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/document_type'; ?>">
                                        <span class="nav-link-text">Document Type</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                <li class="nav-item <?= $meeting_type_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/meeting_type'; ?>">
                                        <span class="nav-link-text">Meeting Type</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="nav-item <?= $mail_template_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/mail_template'; ?>">
                                    <span class="nav-link-text">Mail Template Master</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
<?php } ?>

<div class="footer-link">
    <p>copyright &copy; <?= date('Y'); ?> <a href="<?= site_url(); ?>">mis.villgroapps.org</a></p>
</div>

