<style type="text/css">
    .sidebar_show {
        display: block !important;
    }
</style>

<?php
$employee_active = $holiday_active = '';
$employee_menu = $holiday_menu = '';

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
} else if ($page == 'master_setting') {
    $master_setting_active = 'active';
    $master_setting_menu = 'show';
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

                <li class="nav-item <?= $partner_active; ?> <?= $master_setting_active; ?>  <?= $job_active; ?> <?= $job_location_active; ?>">
                    <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems2" aria-controls="collapseSubItems2" aria-expanded="false"><i class="fas fa-user-friends"></i> Admin Master</a>
                    <ul class="nav-second-level scrollsideMenu collapse <?= $partner_menu; ?> <?= $master_setting_menu; ?> <?= $job_menu; ?> <?= $job_location_menu; ?>" id="collapseSubItems2" data-parent="#navAccordion">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/master/balance_sheet'; ?>">
                                <span class="nav-link-text">Budget</span>
                            </a>
                        </li>
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
                        <li class="nav-item active">
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

                <li class="nav-item <?= $employee_active; ?>">
                    <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-user-friends"></i> Employee Master</a>
                    <ul class="nav-second-level scrollsideMenu collapse <?= $employee_menu; ?> " id="collapseSubItems4" data-parent="#navAccordion">
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
                                <span class="nav-link-text">Donor</span>
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
						<?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
							<li class="nav-item <?= $mail_template_active; ?>">
								<a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/mail_template'; ?>">
									<span class="nav-link-text">Mail Template Master</span>
								</a>
							</li>
						<?php } ?>
						<li class="nav-item <?= $incubation_SM_active; ?>">
							<a class="nav-link" href="">
								<span class="nav-link-text">Screening Master</span>
							</a>
						</li>
						<li class="nav-item <?= $incubation_IPM_active; ?>">
							<a class="nav-link" href="">
								<span class="nav-link-text">Incubation Progress Master</span>
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

