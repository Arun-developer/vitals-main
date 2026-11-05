<style type="text/css">
    .sidebar_show {
        display: block !important;
    }
</style>

<?php
$employee_active = $leave_active = '';
$employee_menu = $leave_menu = '';

if ($page == 'summary') {
    $summary_active = 'active';
    $summary_menu = 'show';
} else if ($page == 'add_grant') {
    $add_grant_active = 'active';
    $add_grant_menu = 'show';
} 

?>

<nav class="navbar navbar-expand-lg ">
    <div class="collapse navbar-collapse show" id="navbarCollapse">
        <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">            
            <li class="nav-item <?= $summary_active; ?>">
                <a class="nav-link " href="<?php echo base_url() . 'index.php/user/user_ui/funds_grant_list'; ?>" id="hasSubItems" ><i class="far fa-file-alt"></i> Summary</a>                
            </li>
            <li class="nav-item <?= $add_grant_active; ?>">
                <a class="nav-link " href="<?php echo base_url() . 'index.php/user/user_ui/add_donor'; ?>" id="hasSubItems" ><i class="fas fa-user-friends"></i> Add Funder/Grant</a>                
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