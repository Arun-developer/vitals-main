<style type="text/css">
    .sidebar_show {
        display: block !important;
    }
</style>

<?php

$url_type = $this->uri->segment(2);


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
} else if ($page == 'approve_leave') {
    $approve_leave_active = 'active';
    $approve_leave_menu = 'show';
}else if ($page == 'booklist') {
    $booklist_active = 'active';
}else if ($page == 'requestlist') {
    $requestlist = 'active';
}

?>

<nav class="navbar navbar-expand-lg ">
    <div class="collapse navbar-collapse show" id="navbarCollapse">
        <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
            
			<li class="nav-item <?php if($url_type =='old_innovations'){ echo "active"; } ?>">
				<a class="nav-link show" href="<?php echo base_url() . 'index.php/report/old_innovations/1'; ?>"  aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i>Archives</a>
			</li>
			<li class="nav-item <?php if($url_type =='new_report'|| $url_type=='innovations_report'){ echo "active"; } ?>">
				<a class="nav-link show" href="<?php echo base_url() . 'index.php/report/new_report'; ?>"  aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i>Innovation Report</a>
			</li>
			<li class="nav-item <?php if($url_type=='untilized_report'){ echo "active"; } ?>">
				<a class="nav-link show" href="<?php echo base_url() . 'index.php/report/untilized_report'; ?>"  aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i>Approval Note Unutilized Report</a>
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