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
} else if ($page == 'holiday') {
    $holiday_active = 'active';
    $holiday_menu = 'show';
} else if ($page == 'work_type') {
    $work_type_active = 'active';
    $work_type_menu = 'show';
}

?>

<nav class="navbar navbar-expand-lg ">
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
            <li class="nav-item ">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems2" aria-controls="collapseSubItems2" aria-expanded="false"><i class="fas fa-user-friends"></i> Admin Master</a>
                <ul class="nav-second-level collapse " id="collapseSubItems2" data-parent="#navAccordion">
                    <li class="nav-item ">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">Master Settings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">Asset Manager</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">Vendor Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">Books Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">Visitor's Log</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">Dispatch Inward</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">Dispatch Outward</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">No Due Certificate</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/partner'; ?>">
                            <span class="nav-link-text">Partners</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?= $employee_active; ?>">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-user-friends"></i> Employee Master</a>
                <ul class="nav-second-level collapse <?= $employee_menu; ?>" id="collapseSubItems4" data-parent="#navAccordion">
                    <li class="nav-item <?= $employee_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/employee_master'; ?>">
                            <span class="nav-link-text">Employee Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">Job</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">Job Location</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Incubation Master</a>
            </li>
            <li class="nav-item <?= $holiday_active; $work_type_active ?>">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems5" aria-controls="collapseSubItems5" aria-expanded="false"><i class="fas fa-user-friends"></i> Leave & Calendar</a>
                <ul class="nav-second-level collapse <?= $holiday_menu; $work_type_menu; ?>" id="collapseSubItems5" data-parent="#navAccordion">
                    <li class="nav-item  <?= $holiday_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>">
                            <span class="nav-link-text">Holidays Details</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $work_type_active; ?>" >
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/week_setup'; ?>">
                            <span class="nav-link-text">Week Setup</span>
                        </a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/working_days'; ?>">
                            <span class="nav-link-text">Working Days</span>
                        </a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/leave_type'; ?>">
                            <span class="nav-link-text">Leave Type</span>
                        </a>
                    </li>
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
    $(document).ready(function () {
        $('.nav-link-collapse').on('click', function () {
            $('.nav-link-collapse').not(this).removeClass('nav-link-show');
            $(this).toggleClass('nav-link-show');
        });
    });
</script>