<style type="text/css">
    .sidebar_show {
        display: block !important;
    }
</style>

<?php
$employee_active = $holiday_active = $work_type_active = $week_setup_active = $working_days_active = $leave_allocation_active = '';
$employee_menu = $holiday_menu = $work_type_menu = $week_setup_menu = $working_days_menu = $leave_allocation_menu = '';

if ($page == 'emp_list') {
    $employee_active = 'active';
    $employee_menu = 'show';
} else if ($page == 'leave_allocation') {
    $leave_allocation_active = 'active';
    $leave_allocation_menu = 'show';
} else if ($page == 'holiday') {
    $holiday_active = 'active';
    $holiday_menu = 'show';
} else if ($page == 'work_type') {
    $work_type_active = 'active';
    $work_type_menu = 'show';
} else if ($page == 'week_setup') {
    $week_setup_active = 'active';
    $week_setup_menu = 'show';
} else if ($page == 'working_days') {
    $working_days_active = 'active';
    $working_days_menu = 'show';
}
?>
<div id="leftMenuLoad">
    <nav class="navbar navbar-expand-lg ">
        <div class="collapse navbar-collapse show" id="navbarCollapse">
            <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
                <li class="nav-item <?= $holiday_active; ?> <?= $work_type_active; ?> <?= $week_setup_active; ?> <?= $working_days_active; ?>">
                    <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems5" aria-controls="collapseSubItems5" aria-expanded="false"><i class="fas fa-user-friends"></i> Leave & Calendars</a>
                    <ul class="nav-second-level collapse <?= $holiday_menu; ?>  <?= $work_type_menu; ?> <?= $week_setup_menu; ?> <?= $working_days_menu; ?>" id="collapseSubItems5" data-parent="#navAccordion">
                        <li class="nav-item  <?= $holiday_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/current_holiday_calendar'; ?>">
                                <span class="nav-link-text">Holidays Details</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $week_setup_active; ?>" >
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/week_setup'; ?>">
                                <span class="nav-link-text">Week Setup</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $working_days_active; ?>" >
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/working_days'; ?>">
                                <span class="nav-link-text">Working Days</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $work_type_active; ?>" >
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/leave_type'; ?>">
                                <span class="nav-link-text">Leave Type</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?= $budget_active; ?>">
                    <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems6" aria-controls="collapseSubItems6" aria-expanded="false"><i class="fas fa-gem"></i> Budget</a>
                    <ul class="nav-second-level scrollsideMenu collapse <?= $budget_menu; ?> <?= $program_menu; ?> <?= $budget_head_menu; ?> <?= $line_menu; ?> <?= $additional_menu; ?> <?= $financial_menu; ?>" id="collapseSubItems6" data-parent="#navAccordion">
                        <li class="nav-item <?= $balance_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/balance_sheet'; ?>">
                                <span class="nav-link-text">Balance Sheet</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $programme_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/programme'; ?>">
                                <span class="nav-link-text">Programme</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $budget_head_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/budget_head'; ?>">
                                <span class="nav-link-text">Budget Head</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $line_item_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/line_item'; ?>">
                                <span class="nav-link-text">Line Item</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $additional_info_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/additional_info'; ?>">
                                <span class="nav-link-text">Additional Info</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $financial_year_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/financial_year'; ?>">
                                <span class="nav-link-text">Financial Year</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?= $partner_active; ?> <?= $master_setting_active; ?>">
                    <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems2" aria-controls="collapseSubItems2" aria-expanded="false"><i class="fas fa-user-friends"></i> Admin Master</a>
                    <ul class="nav-second-level scrollsideMenu collapse <?= $partner_menu; ?> <?= $master_setting_menu; ?>" id="collapseSubItems2" data-parent="#navAccordion">
                        <li class="nav-item ">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/asset'; ?>">
                                <span class="nav-link-text">Assets</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/books_master'; ?>">
                                <span class="nav-link-text">Books</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/visitors_log'; ?>">
                                <span class="nav-link-text">Visitor's Log</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/dispatch_inward'; ?>">
                                <span class="nav-link-text">Dispatch Inward</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/dispatch_outward'; ?>">
                                <span class="nav-link-text">Dispatch Outward</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/nodue_certificate'; ?>">
                                <span class="nav-link-text">No Due Certificate</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/job/lists'; ?>">
                                <span class="nav-link-text">Job</span>
                            </a>
                        </li>
                        <li class="nav-item">
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
                <li class="nav-item <?= $employee_active; ?> <?= $leave_allocation_active; ?>">
                    <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-user-friends"></i> Employee Master</a>
                    <ul class="nav-second-level  collapse <?= $employee_menu; ?> <?= $leave_allocation_menu; ?>" id="collapseSubItems4" data-parent="#navAccordion">
                        <li class="nav-item <?= $employee_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/user/lists/3'; ?>">
                                <span class="nav-link-text">Employee Details</span>
                            </a>
                        </li>
                        <li class="nav-item  <?= $leave_allocation_active; ?>">
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
                <li class="nav-item">
                    <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Incubation Master</a>
                    <ul class="nav-second-level collapse scrollsideMenu <?= $partner_menu; ?> <?= $master_setting_menu; ?>" id="collapseSubItems3" data-parent="#navAccordion">

                        <li class="nav-item  <?= $master_setting_active; ?>">
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
                        <?php /* if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                          <li class="nav-item <?= $incubation_pm_active; ?>">
                          <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/incubation_progress'; ?>">
                          <span class="nav-link-text">Incubation Progress Master</span>
                          </a>
                          </li>
                          <?php } */ ?>

                        <?php /* if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                          <li class="nav-item <?= $si_master_active; ?>">
                          <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/source_instance_master'; ?>">
                          <span class="nav-link-text">Source/Instance Master</span>
                          </a>
                          </li>
                          <?php } */ ?>
                        <?php /* if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                          <li class="nav-item <?= $ps_master_active; ?>">
                          <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/program_service_master'; ?>">
                          <span class="nav-link-text">Program Service Master</span>
                          </a>
                          </li>
                          <?php } */ ?>

                        <?php /* if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                          <li class="nav-item <?= $psm_master_active; ?>">
                          <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/program_stage_master'; ?>">
                          <span class="nav-link-text">Program Stage Master</span>
                          </a>
                          </li>
                          <?php } */ ?>
                        <?php /* if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                          <li class="nav-item <?= $gm_master_active; ?>">
                          <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/grading_master'; ?>">
                          <span class="nav-link-text">Grading Master</span>
                          </a>
                          </li>
                          <?php } */ ?>
                        <?php /* if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                          <li class="nav-item <?= $sm_master_active; ?>">
                          <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/screening_master'; ?>">
                          <span class="nav-link-text">Screening Master</span>
                          </a>
                          </li>
                          <?php } */ ?>

                </li>

            </ul>
        </div>
    </nav>
</div>
<style>
    .sidebar-dropdown.active .sidebar-submenu {
        display: block !important;
    }
</style>

<!-- <script>
    $(document).ready(function () {
        $('.nav-link-collapse').on('click', function () {
            $('.nav-link-collapse').not(this).removeClass('nav-link-show');
            $(this).toggleClass('nav-link-show');
        });
    });
</script> -->