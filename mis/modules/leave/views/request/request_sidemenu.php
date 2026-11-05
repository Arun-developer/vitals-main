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
} else if ($page == 'approve_leave') {
    $approve_leave_active = 'active';
    $approve_leave_menu = 'show';
}

$switch_type = '';
$internal_url = '';
$approval_url = '';
$req_internal_url = '';
$req_approval_url = '';


if ($this->session->userdata('role_id') == 2 && $this->session->userdata('user_type') == 'admin') { 
    $switch_type = 'Switch to user';
    $internal_url = base_url() . 'index.php/login/approvals';
    #$approval_url = base_url() . 'index.php/login/approvals';
    $approval_url = base_url() . 'index.php/approval/approval_note/pending/mylist';

    $req_internal_url = '';
    $req_approval_url = '';
} else if ($this->session->userdata('role_id') == 2 && $this->session->userdata('user_type') == 'employee') { 
    $switch_type = 'Switch to admin';
    $internal_url = base_url() . 'index.php/login/approvals';
    $approval_url = base_url() . 'index.php/login/approvals';

    $req_internal_url = base_url() . 'index.php/approval/new_approval';
    $req_approval_url = base_url() . 'index.php/approval/new_approval';
}else if ($this->session->userdata('user_type') == 'superadmin') {
  /*   $switch_type = 'Switch to user';
    $internal_url = base_url() . 'index.php/login/approvals';
    $approval_url = base_url() . 'index.php/login/approvals';
 */
	$approval_url = base_url() . 'index.php/approval/approvaladmin/approval_notes/pending/mylist';
    $req_internal_url = base_url() . 'index.php/approval/new_approval';
    $req_approval_url = base_url() . 'index.php/approval/new_approval';
}
?>

<nav class="navbar navbar-expand-lg ">
    <div class="collapse navbar-collapse show" id="navbarCollapse">
        <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
            <li class="nav-item ">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems2" aria-controls="collapseSubItems2" aria-expanded="false"><i class="fas fa-user-friends"></i> Approval Note</a>
                <ul class="nav-second-level collapse " id="collapseSubItems2" data-parent="#navAccordion">
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo $req_internal_url; ?>">
                            <span class="nav-link-text">Raise Approval Note</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $approval_url; ?>">
                            <span class="nav-link-text">Approve (3)</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item ">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Internal Note</a>
                <ul class="nav-second-level collapse " id="collapseSubItems3" data-parent="#navAccordion">
					 <?php if ($this->session->userdata('user_type') != 'superadmin') { ?>
						<li class="nav-item ">
							<a class="nav-link"  href="<?php echo base_url() . 'index.php/approval/approval_note/pending'; ?>">
								<span class="nav-link-text">Raise internal note</span>
							</a>
						</li>
					<?php } ?>
					 <?php  if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
                        ?>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo $internal_url; ?>">
								<span class="nav-link-text">Approve</span>
							</a>
						</li>
					 <?php } ?>
                </ul>
            </li>
            <li class="nav-item <?= $leave_active; ?> <?= $approve_leave_active; ?>">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-user-friends"></i> Leave <?php echo isset($approval_count) && $approval_count != 0 ? '(' . $approval_count . ')' : ''; ?></a>
                <ul class="nav-second-level collapse <?= $leave_menu; ?> <?= $approve_leave_menu; ?>" id="collapseSubItems4" data-parent="#navAccordion">
                    <?php
                    if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') {
                        ?>
                        <li class="nav-item  <?= $leave_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/apply_leave'; ?>">
                                <span class="nav-link-text">Apply For Leave</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php
                    if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin' || php72_count($supervisor) > 0) {
                        ?>
                        <li class="nav-item <?= $approve_leave_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/approve_leave_list'; ?>">
                                <span class="nav-link-text">Approve <?php echo isset($approval_count) && $approval_count != 0 ? '(' . $approval_count . ')' : ''; ?></span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
			 <?php if ($this->session->userdata('user_type') == 'superadmin') {?>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url() . 'index.php/book/approval/requests/pending'; ?>" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Book</a>
				<?php }else{ ?>
					<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url() . 'index.php/book/booklist/book_request'; ?>" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Book</a>
				</li>
			<?php } ?>
            
			
			<?php if ($this->session->userdata('user_type') == 'superadmin') {?>
				<li class="nav-item">
					<a class="nav-link"  href="<?php echo base_url() . 'index.php/travel/requestlist/pending'; ?>" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Travel & Accomodation </a>
				</li>
			<?php }else{ ?>
				<li class="nav-item">
					<a class="nav-link"  href="<?php echo base_url() . 'index.php/travel/request_form/book_request'; ?>" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Travel & Accomodation </a>
				</li>
			<?php } ?>
             
            <?php  if($this->session->userdata('user_type') == 'superadmin'){ ?>
				<li class="nav-item">
					<a class="nav-link show" href="<?php echo base_url() . 'index.php/asset_admin/listasset'; ?>"  aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Assets Admin</a>
					</li>
				
			<?php }else{ ?>
				<li class="nav-item">
					<a class="nav-link show" href="<?php echo base_url() . 'index.php/asset/requestlist/using'; ?>"  aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Assets</a>
				</li>
			<?php } ?>
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
            <li class="nav-item <?= $holiday_active;
                    $work_type_active
                    ?>">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems5" aria-controls="collapseSubItems5" aria-expanded="false"><i class="fas fa-user-friends"></i> Leave & Calendar</a>
                <ul class="nav-second-level collapse <?= $holiday_menu;
            $work_type_menu;
                    ?>" id="collapseSubItems5" data-parent="#navAccordion">
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