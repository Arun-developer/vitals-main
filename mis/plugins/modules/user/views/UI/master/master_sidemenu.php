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
} else if ($page == 'no_due_certificate') {
    $no_due_certificate_active = 'active';
    $no_due_certificate_menu = 'show';
} else if ($page == 'master_setting') {
    $master_setting_active = 'active';
    $master_setting_menu = 'show';
} else if ($page == 'incubation_US') {
    $incubation_US_active = 'active';
    $incubation_US_menu = 'show';
} else if ($page == 'incubation_SE') {
    $incubation_SE_active = 'active';
    $incubation_SE_menu = 'show';
} else if ($page == 'incubation_MS') {
    $incubation_MS_active = 'active';
    $incubation_MS_menu = 'show';
} else if ($page == 'incubation_SIM') {
    $incubation_SIM_active = 'active';
    $incubation_SIM_menu = 'show';
} else if ($page == 'incubation_DPSM') {
    $incubation_DPSM_active = 'active';
    $incubation_DPSM_menu = 'show';
} else if ($page == 'incubation_PSM') {
    $incubation_PSM_active = 'active';
    $incubation_PSM_menu = 'show';
} else if ($page == 'incubation_GM') {
    $incubation_GM_active = 'active';
    $incubation_GM_menu = 'show';
} else if ($page == 'incubation_SM') {
    $incubation_SM_active = 'active';
    $incubation_SM_menu = 'show';
} else if ($page == 'incubation_IPM') {
    $incubation_IPM_active = 'active';
    $incubation_IPM_menu = 'show';
} else if ($page == 'incubation_RR') {
    $incubation_RR_active = 'active';
    $incubation_RR_menu = 'show';
} else if ($page == 'incubation_MTM') {
    $incubation_MTM_active = 'active';
    $incubation_MTM_menu = 'show';
} else if ($page == 'incubation_DF') {
    $incubation_DF_active = 'active';
    $incubation_DF_menu = 'show';
} else if ($page == 'incubation_PR') {
    $incubation_PR_active = 'active';
    $incubation_PR_menu = 'show';
} else if ($page == 'incubation_sectors') {
    $incubation_sectors_active = 'active';
    $incubation_sectors_menu = 'show';
} else if ($page == 'incubation_DT') {
    $incubation_DT_active = 'active';
    $incubation_DT_menu = 'show';
} else if ($page == 'incubation_MT') {
    $incubation_MT_active = 'active';
    $incubation_MT_menu = 'show';
} else if ($page == 'incubation_PS') {
    $incubation_PS_active = 'active';
    $incubation_PS_menu = 'show';
} else if ($page == 'incubation_SL') {
    $incubation_SL_active = 'active';
    $incubation_SL_menu = 'show';
}
?>

<nav class="navbar navbar-expand-lg ">
    <div class="collapse navbar-collapse show" id="navbarCollapse">
        <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
            <li class="nav-item <?= $holiday_active; ?> <?= $work_type_active; ?> <?= $work_days_active; ?> <?= $leave_type_active; ?>">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems5" aria-controls="collapseSubItems5" aria-expanded="false"><i class="fas fa-user-friends"></i> Leave & Calendar</a>
                <ul class="nav-second-level collapse <?= $holiday_menu; ?> <?= $work_type_menu; ?> <?= $work_days_menu; ?> <?= $leave_type_menu; ?>" id="collapseSubItems5" data-parent="#navAccordion">
                    <li class="nav-item  <?= $holiday_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>">
                            <span class="nav-link-text">Holidays Details</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $work_type_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/week_setup'; ?>">
                            <span class="nav-link-text">Week Setup</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $work_days_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/working_days'; ?>">
                            <span class="nav-link-text">Working Days</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $leave_type_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/leave_type'; ?>">
                            <span class="nav-link-text">Leave Type</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?= $partner_active; ?> <?= $master_setting_active; ?> <?= $no_due_certificate_active; ?>">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems2" aria-controls="collapseSubItems2" aria-expanded="false"><i class="fas fa-user-friends"></i> Admin Master</a>
                <ul class="nav-second-level collapse <?= $partner_menu; ?> <?= $master_setting_menu; ?>" id="collapseSubItems2" data-parent="#navAccordion">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">Assets</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">Books</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $master_setting_active; ?>">
                        <a class="nav-link " href="<?php echo base_url() . 'index.php/user/user_ui/balance_sheet'; ?>">
                            <span class="nav-link-text">Budget</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $no_due_certificate_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/no_due_certificate'; ?>">
                            <span class="nav-link-text">No Due Certificate</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $partner_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/partner'; ?>">
                            <span class="nav-link-text">Partners</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?= $employee_active; ?> <?= $job_active; ?> <?= $job_location_active; ?>">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-user-friends"></i> Employee Master</a>
                <ul class="nav-second-level collapse <?= $employee_menu; ?> <?= $job_menu; ?> <?= $job_location_menu; ?>" id="collapseSubItems4" data-parent="#navAccordion">
                    <li class="nav-item <?= $employee_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/employee_master'; ?>">
                            <span class="nav-link-text">Employee Details</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $job_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/job'; ?>">
                            <span class="nav-link-text">Job</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $job_location_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/job_location'; ?>">
                            <span class="nav-link-text">Job Location</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?= $incubation_US_active; ?> <?= $incubation_SE_active; ?> <?= $incubation_MS_active; ?> <?= $incubation_SIM_active; ?> <?= $incubation_DPSM_active; ?> <?= $incubation_PSM_active; ?> <?= $incubation_GM_active; ?> <?= $incubation_SM_active; ?> <?= $incubation_IPM_active; ?> <?= $incubation_RR_active; ?> <?= $incubation_MTM_active; ?> <?= $incubation_DF_active; ?> <?= $incubation_PR_active; ?> <?= $incubation_sectors_active; ?> <?= $incubation_DT_active; ?> <?= $incubation_MT_active; ?> <?= $incubation_PS_active; ?> <?= $incubation_SL_active; ?>">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems10" aria-controls="collapseSubItems10" aria-expanded="false"><i class="fas fa-user-friends"></i> Incubation Master</a>
                <ul class="nav-second-level scrollsideMenu collapse <?= $incubation_US_menu; ?> <?= $incubation_SE_menu; ?> <?= $incubation_MS_menu; ?> <?= $incubation_SIM_menu; ?> <?= $incubation_DPSM_menu; ?> <?= $incubation_PSM_menu; ?> <?= $incubation_GM_menu; ?> <?= $incubation_SM_menu; ?> <?= $incubation_IPM_menu; ?> <?= $incubation_RR_menu; ?> <?= $incubation_MTM_menu; ?> <?= $incubation_DF_menu; ?> <?= $incubation_PR_menu; ?> <?= $incubation_sectors_menu; ?> <?= $incubation_DT_menu; ?> <?= $incubation_MT_menu; ?> <?= $incubation_PS_menu; ?> <?= $incubation_SL_menu; ?>" id="collapseSubItems10" data-parent="#navAccordion">
                    <li class="nav-item <?= $incubation_US_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/user_setup'; ?>">
                            <span class="nav-link-text">User Setup</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $incubation_SE_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/stage_efficiency'; ?>">
                            <span class="nav-link-text">Stage Efficiency</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $incubation_MS_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/master_settings'; ?>">
                            <span class="nav-link-text">Master Settings</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $incubation_SIM_active; ?>">
                        <a class="nav-link" href="">
                            <span class="nav-link-text">Source/Instance Master</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $incubation_DPSM_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/reject_reason'; ?>">
                            <span class="nav-link-text">Program Service Master</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $incubation_PSM_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/reject_reason'; ?>">
                            <span class="nav-link-text">Program Stage Master</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $incubation_GM_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/granding_master'; ?>">
                            <span class="nav-link-text">Grading Master</span>
                        </a>
                    </li>
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
                    <li class="nav-item <?= $incubation_RR_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/reject_reason'; ?>">
                            <span class="nav-link-text">Reasons</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $incubation_MTM_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/mail_template'; ?>">
                            <span class="nav-link-text">Mail Template Master</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $incubation_DF_active; ?>">
                        <a class="nav-link" href="">
                            <span class="nav-link-text">Donor Fit</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item <?= $incubation_PR_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/job_location'; ?>">
                            <span class="nav-link-text">Preliminary Reasons</span>
                        </a>
                    </li> -->
                    <li class="nav-item <?= $incubation_sectors_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/sectors'; ?>">
                            <span class="nav-link-text">Sectors</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $incubation_DT_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/job_location'; ?>">
                            <span class="nav-link-text">Document Type</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $incubation_MT_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/job_location'; ?>">
                            <span class="nav-link-text">Meeting Type</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $incubation_PS_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/job_location'; ?>">
                            <span class="nav-link-text">Portfolio Settings</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item <?= $incubation_SL_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/job_location'; ?>">
                            <span class="nav-link-text">Sector Leads</span>
                        </a>
                    </li> -->
                </ul>
            </li>

        </ul>
    </div>
</nav>

<style>
    .sidebar-dropdown.active .sidebar-submenu {
        display: block !important;
    }
</style>

<script>
    $(document).ready(function() {
        $('.nav-link-collapse').on('click', function() {
            $('.nav-link-collapse').not(this).removeClass('nav-link-show');
            $(this).toggleClass('nav-link-show');
        });
    });
</script>