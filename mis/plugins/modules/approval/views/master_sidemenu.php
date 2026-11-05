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
} else if ($page == 'booklist') {
    $booklist_active = 'active';
} else if ($page == 'travel') {
    $travel_active = 'active';
} else if ($page == 'approval_note') {
    $approval_note_active = 'active';
    $approval_note_menu = 'show';
} else if ($page == 'approval_note') {
    $approval_note_active_sm = 'active';
    $approval_note_menu_sm = 'show';
}
if ($this->uri->segment(4) == 'mylist') {
    $approval_note_active = '';
}
?>

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
                                <span class="nav-link-text">Approve (2)</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?= $leave_active; ?> <?= $approve_leave_active; ?>">
                    <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-user-friends"></i> Leave (3)</a>
                    <ul class="nav-second-level collapse <?= $leave_menu; ?> <?= $approve_leave_menu; ?>" id="collapseSubItems4" data-parent="#navAccordion">
                        <li class="nav-item  <?= $leave_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/apply_leave'; ?>">
                                <span class="nav-link-text">Apply For Leave</span>
                            </a>
                        </li>
                        <li class="nav-item <?= $approve_leave_active; ?>">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/approve_leave_list'; ?>">
                                <span class="nav-link-text">Approve (3)</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems5" aria-controls="collapseSubItems5" aria-expanded="false"><i class="fas fa-user-friends"></i> Book (3)</a>
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