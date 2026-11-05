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
}else if ($page == 'booklist') {
    $booklist_active = 'active';
}else if ($page == 'requestlist') {
    $requestlist = 'active';
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
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo $req_internal_url; ?>">
                            <span class="nav-link-text">Raise internal note</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $internal_url; ?>">
                            <span class="nav-link-text">Approve (2)</span>
                        </a>
                    </li>                   
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-user-friends"></i> Leave <?php echo isset($approval_count) && $approval_count != 0 ? '('.$approval_count.')' : ''; ?></a>
                <ul class="nav-second-level collapse <?= $leave_menu; ?> <?= $approve_leave_menu; ?>" id="collapseSubItems4" data-parent="#navAccordion">
                    <?php
                    if($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin'){
                                ?>
                    <li class="nav-item  <?= $leave_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/apply_leave'; ?>">
                            <span class="nav-link-text">Apply For Leave</span>
                        </a>
                    </li>
                <?php } ?>
                    <?php
                    if($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin' || php72_count($supervisor) > 0){
                        ?>
                    <li class="nav-item" >
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/approve_leave_list'; ?>">
                            <span class="nav-link-text">Approve <?php echo isset($approval_count) && $approval_count != 0 ? '('.$approval_count.')' : ''; ?></span>
                        </a>
                    </li>  
                    <?php } ?>                 
                </ul>
            </li>
            <li class="nav-item">
				<a class="nav-link nav-link-collapse show" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Book</a>
				 <ul class="nav-second-level collapse " id="collapseSubItems3" data-parent="#navAccordion">
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url() . 'index.php/book/booklist/book_request'; ?>">
							<span class="nav-link-text">Request for a book</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url() . 'index.php/approval/booklist/book_request'; ?>">
							<span class="nav-link-text">Requests</span>
						</a>
					</li>                 
				</ul>
			</li>
            <li class="nav-item">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Travel & Accomodation </a>
            </li>
			 <?php  if($this->session->userdata('user_type') != 'superadmin'){ ?>
				<li class="nav-item active">
					<a class="nav-link nav-link-collapse show" href="<?php echo base_url() . 'index.php/asset/requestlist/using'; ?>"  aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Assets</a>
				</li>
			<?php }else{ ?>
					<li class="nav-item active">
					<a class="nav-link nav-link-collapse show" href="<?php echo base_url() . 'index.php/asset/requestlist/using'; ?>"  aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-user-friends"></i> Assetss</a>
					</li>
			<?php } ?>

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