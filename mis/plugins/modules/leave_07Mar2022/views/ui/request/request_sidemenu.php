<style type="text/css">
    .sidebar_show {
        display: block !important;
    }
</style>

<?php
$employee_active = $leave_active = '';
$employee_menu = $leave_menu = '';

if ($page == 'leave') {
    $leave_active = 'active';
    $leave_menu = 'show';
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
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems2" aria-controls="collapseSubItems2" aria-expanded="false"><i class="fas fa-user-friends"></i> Approval Note</a>
                <ul class="nav-second-level collapse " id="collapseSubItems2" data-parent="#navAccordion">
                    <li class="nav-item ">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">Raise Approval Note</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-link-text">Approve (3)</span>
                        </a>
                    </li>                   
                </ul>
            </li>
            <li class="nav-item ">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Internal Note</a>
            </li>
            <li class="nav-item <?= $leave_active; ?>">
                <a class="nav-link " href="#" id="hasSubItems" ><i class="fas fa-user-friends"></i> Leave (3)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Book (3)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Travel & Accomodation </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Assets </a>
            </li>

            <!-- <li class="nav-item <?= $employee_active; ?>">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-user-friends"></i> Leave (3)</a>
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
            </li> -->
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