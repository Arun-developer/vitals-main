<style type="text/css">
    .sidebar_show {
        display: block !important;
    }
</style>

<?php
if ($page == 'emp_list') {
    $employee_active = 'active';
    $employee_menu = 'show';
} else if ($page == 'job') {
    $job_active = 'active';
    $job_menu = 'show';
} else if ($page == 'job_location') {
    $job_location_active = 'active';
    $job_location_menu = 'show';
} else if ($page == 'holiday') {
    $holiday_active = 'active';
    $holiday_menu = 'show';
} else if ($page == 'work_type') {
    $work_type_active = 'active';
    $work_type_menu = 'show';
} else if ($page == 'work_days') {
    $work_days_active = 'active';
    $work_days_menu = 'show';
} else if ($page == 'leave_type') {
    $leave_type_active = 'active';
    $leave_type_menu = 'show';
} else if ($page == 'partner') {
    $partner_active = 'active';
    $partner_menu = 'show';
} else if ($page == 'budget') {
    $budget_active = 'active';
    $budget_menu = 'show';
} else if ($page == 'master_setting') {
    $master_setting_active = 'active';
    $master_setting_menu = 'show';
} else if ($page == 'asset_master') {
    $asset_setting_active = 'active';
    $master_setting_menu = 'show';
} else if ($page == 'vendor_master') {
    $vendor_setting_active = 'active';
    $master_setting_menu = 'show';
} else if ($page == 'books_master') {
    $books_setting_active = 'active';
    $master_setting_menu = 'show';
} else if ($page == 'visitors_log') {
    $log_setting_active = 'active';
    $master_setting_menu = 'show';
} else if ($page == 'dispatch_inward') {
    $inward_setting_active = 'active';
    $master_setting_menu = 'show';
} else if ($page == 'dispatch_outward') {
    $outward_setting_active = 'active';
    $master_setting_menu = 'show';
} else if ($page == 'nodue') {
    $due_setting_active = 'active';
    $master_setting_menu = 'show';
} else if ($page == 'job_type') {
    $job_type_active = 'active';
    $job_type_menu = 'show';
} else if ($page == 'job_dept') {
    $job_dept_active = 'active';
    $job_dept_menu = 'show';
} else if ($page == 'job_specification') {
    $job_spec_active = 'active';
    $job_spec_menu = 'show';
} else if ($page == 'pay_grade') {
    $pay_grade_active = 'active';
    $pay_grade_menu = 'show';
}

?>

<div id="leftMenuLoad">
    <nav class="navbar navbar-expand-lg ">
        <div class="collapse navbar-collapse show" id="navbarCollapse">
            <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">

                <li class="nav-item <?= $holiday_active; ?> <?= $work_type_active; ?> <?= $work_days_active; ?> <?= $leave_type_active; ?>">
                    <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems5" aria-controls="collapseSubItems5" aria-expanded="false"><i class="fas fa-user-friends"></i> Leave & Calendars</a>
                    <ul class="nav-second-level collapse <?= $holiday_menu; ?> <?= $work_type_menu; ?> <?= $work_days_menu; ?> <?= $leave_type_menu; ?>" id="collapseSubItems5" data-parent="#navAccordion">
                        <li class="nav-item  <?= $holiday_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/current_holiday_calendar'; ?>">
                                <span class="nav-link-text">Holidays Details</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $work_type_active; ?>" >
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/week_setup'; ?>">
                                <span class="nav-link-text">Week Setup</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $work_days_active; ?>" >
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

                <li class="nav-item <?= $partner_active; ?> <?= $master_setting_active; ?> <?= $asset_setting_active; ?> <?= $asset_setting_active; ?> <?= $vendor_setting_active; ?> <?= $books_setting_active; ?> <?= $log_setting_active; ?> <?= $inward_setting_active; ?> <?= $outward_setting_active; ?> <?= $due_setting_active; ?> <?= $job_spec_active; ?> <?= $pay_grade_active; ?> <?= $job_location_active; ?> <?= $job_type_active; ?> <?= $job_dept_active; ?>">
                    <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems2" aria-controls="collapseSubItems2" aria-expanded="false"><i class="fas fa-user-friends"></i> Admin Master</a>
                    <ul class="nav-second-level collapse scrollsideMenu <?= $partner_menu; ?> <?= $master_setting_menu; ?> <?= $job_spec_menu; ?> <?= $pay_grade_menu; ?> <?= $job_type_menu; ?> <?= $job_dept_menu; ?>" id="collapseSubItems2" data-parent="#navAccordion">
                        <li class="nav-item  <?= $master_setting_active; ?>">
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
                       <!-- <li class="nav-item <?= $job_location_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/job/location'; ?>">
                                <span class="nav-link-text">Job Location</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $job_type_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/job_type'; ?>">
                                <span class="nav-link-text">Job Type</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $job_dept_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/job_department'; ?>">
                                <span class="nav-link-text">Job Department</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $job_spec_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/job_specification'; ?>">
                                <span class="nav-link-text">Job Specification</span>
                            </a>
                        </li> -->
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

                <li class="nav-item ">
                    <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-user-friends"></i> Employee Master</a>
                    <ul class="nav-second-level collapse <?= $employee_menu; ?> " id="collapseSubItems4" data-parent="#navAccordion">
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

                
                <li class="nav-item">
                    <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Incubation Master</a>
                    <ul class="nav-second-level collapse scrollsideMenu" id="collapseSubItems3" data-parent="#navAccordion">
					
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/sectors'; ?>">
                                <span class="nav-link-text">Sector</span>
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/reason'; ?>">
                                <span class="nav-link-text">Reasons</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/donor_fit'; ?>">
                                <span class="nav-link-text">Donor Fit</span>
                            </a>
                        </li>
						<?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/master_settings/source_type'; ?>">
									<span class="nav-link-text">Master Settings</span>
								</a>
							</li>
						 <?php } ?>
                        <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/portfolio_settings/designation'; ?>">
                            <span class="nav-link-text">Portfolio Settings</span>
                        </a>
						</li>
						<?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/stage_efficiency'; ?>">
									<span class="nav-link-text">Stage Efficiency</span>
								</a>
							</li>
						<?php } ?>
						<?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/document_type'; ?>">
									<span class="nav-link-text">Document Type</span>
								</a>
							</li>
						<?php } ?>
						<?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/meeting_type'; ?>">
									<span class="nav-link-text">Meeting Type</span>
								</a>
							</li>
						<?php } ?>
						<li class="nav-item">
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
<div class="footer-link">
    <p>copyright &copy; mis.villgroapps.org</p>
</div>

<style>
    .sidebar-dropdown.active .sidebar-submenu {
        display: block !important;
    }
</style>

