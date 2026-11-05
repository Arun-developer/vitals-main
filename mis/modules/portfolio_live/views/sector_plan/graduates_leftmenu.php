<style type="text/css">
    .sidebar_show {display:block !important;}
</style>
<?php
$showMenu = '';
$sale_active = $channel_active = $pipe_active = $revenue_active = $profit_active = $vif_active = $fund_active = $mentor_active = $tap_active = $nontap_active = $board_active = $impact_active = $project_active = '';
$sale_menu = $channel_menu = $pipe_menu = $revenue_menu = $profit_menu = $vif_menu = $fund_menu = $mentor_menu = $tap_menu = $nontap_menu = $project_menu = '';

if ($class_name == 'salesDiv') {
    $sale_active = 'active';
    $sale_menu = $showMenu;
} else if ($class_name == 'channelDiv') {
    $channel_active = 'active';
    $channel_menu = $showMenu;
} else if ($class_name == 'pipeDiv') {
    $pipe_active = 'active';
    $pipe_menu = $showMenu;
} else if ($class_name == 'revenueDiv') {
    $revenue_active = 'active';
    $revenue_menu = $showMenu;
} else if ($class_name == 'profitDiv') {
    $profit_active = 'active';
    $profit_menu = $showMenu;
} else if ($class_name == 'vifDiv') {
    $vif_active = 'active';
    $vif_menu = $showMenu;
} else if ($class_name == 'fundDiv') {
    $fund_active = 'active';
    $fund_menu = $showMenu;
} else if ($class_name == 'mentorDiv') {
    $mentor_active = 'active';
    $mentor_menu = $showMenu;
} else if ($class_name == 'tapDiv') {
    $tap_active = 'active';
    $tap_menu = $showMenu;
} else if ($class_name == 'nontapDiv') {
    $nontap_active = 'active';
    $nontap_menu = $showMenu;
} else if ($class_name == 'boardDiv') {
    $board_active = 'active';
} else if ($class_name == 'impactDiv') {
    $impact_active = 'active';
} else if ($class_name == 'projectDiv') {
    $project_active = 'active';
    $project_menu = $showMenu;
}

if (isset($this->session->userdata['sector_lead']) && $this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
    $config_data = isset($configData) ? $configData : '';
} else {
    $config_data = '';
}
?>

<nav id="sidebar" data-topbar data-options="scrolltop:false" class="sidebar-wrapper top-bar sectorplanLeftMenu">
    <div class="sidebar-content">
        <div class="sidebar-menu">
            <ul>
                <li class="sidebar-dropdown <?= $sale_active; ?> <?= $channel_active; ?> <?= $pipe_active; ?>  <?= $revenue_active; ?>  <?= $profit_active; ?>">
                    <a href="javascript:void(0)">
                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/project-new.png'; ?>" >
                        <span>Graduates & Exits</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li class="<?= $sale_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/sector_plan/graduates/' . $sector_id . '/' . $fin_year; ?>">Graduates (Non-Financial)
                                    <?php if ($config_data != '' && count($config_data['graduatesCount']) > 0) { ?>
                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                    <?php } ?>
                                </a></li>
                            <li class="<?= $channel_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/sector_plan/exits/' . $sector_id . '/' . $fin_year; ?>">Exits (With Equity)
                                    <?php if ($config_data != '' && count($config_data['exitsCount']) > 0) { ?>
                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                    <?php } ?>
                                </a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .sidebar-dropdown.active .sidebar-submenu{
        display:block !important;
    }
</style>

<script type="text/javascript">
//    $(document).on('click', '.sidebar-dropdown', function () {
//        $('div').toggleClass('sidebar_show').removeClass('sidebar_show');
//    });
</script>