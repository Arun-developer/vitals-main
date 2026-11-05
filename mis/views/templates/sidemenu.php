<style type="text/css">
    .sidebar_show {
        display: block !important;
    }
</style>

<?php
$employee_active = $leave_active = '';
$employee_menu = $leave_menu = '';
$summary_active = $add_grant_active = '';

$current_page = $this->uri->segment(1);
$page_type = $this->uri->segment(2);
if($current_page == 'funder' && ($page_type=='edit_funder_documents' || $page_type == 'display_summary_list' || $page_type == 'display_grant_list' || $page_type == 'edit_funder_form' || $page_type == 'edit_grant_form')){
    $summary_active = 'active';
    $summary_menu = 'show';
}else if($current_page == 'funder' && ($page_type=='add_funder_form'||$page_type=='add_grant_form')){
    $add_grant_active = 'active';
    $add_grant_menu = 'show';
}

?>

<nav class="navbar navbar-expand-lg ">
    <div class="collapse navbar-collapse show" id="navbarCollapse">
        <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">            
            <li class="nav-item <?= $summary_active; ?>">
                <a class="nav-link " href="<?php echo base_url() . 'index.php/funder/display_summary_list'; ?>" id="hasSubItems" ><i class="far fa-file-alt"></i> Summary</a>                
            </li>
            <?php if($this->auth =='1'){?>
                <li class="nav-item <?= $add_grant_active; ?>">
                    <a class="nav-link " href="<?php echo base_url() . 'index.php/funder/add_funder_form'; ?>" id="hasSubItems" ><i class="fas fa-user-friends"></i> Add Funder/Grant</a>                
                </li>
            <?php }?>
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