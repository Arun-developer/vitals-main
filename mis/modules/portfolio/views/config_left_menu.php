<style type="text/css">
    .sidebar_show {display:block !important;}
</style>
<?php
$showMenu = '';
$product_active = $sale_active = $channel_active = $pipe_active = $revenue_active = $profit_active = $vif_active = $fund_active = $mentor_active = $tap_active = $nontap_active = $panel_active = $team_active = $board_active = $impact_active = $project_active = '';
$product_menu = $sale_menu = $channel_menu = $pipe_menu = $revenue_menu = $profit_menu = $vif_menu = $fund_menu = $board_menu = $impact_menu = $mentor_menu = $tap_menu = $nontap_menu = $team_menu = $project_menu = '';

if ($class_name == 'productDiv') {
    $product_active = 'active';
    $product_menu = $showMenu;
} else if ($class_name == 'salesDiv') {
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
} else if ($class_name == 'panelDiv') {
    $panel_active = 'active';
} else if ($class_name == 'boardDiv') {
    $board_active = 'active';
} else if ($class_name == 'teamDiv') {
    $team_active = 'active';
} else if ($class_name == 'impactDiv') {
    $impact_active = 'active';
} else if ($class_name == 'projectDiv') {
    $project_active = 'active';
    $project_menu = $showMenu;
}

if ((isset($this->session->userdata['sector_lead']) && php72_cmp($this->session->userdata['sector_lead']) == 1) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
    $config_data = isset($configData) ? $configData : '';
} else {
    $config_data = '';
}
?>

<nav id="sidebar" data-topbar data-options="scrolltop:false" class="sidebar-wrapper top-bar">
    <div class="sidebar-content">
        <div class="sidebar-menu">
            <ul>
                <li class="sidebar-dropdown <?= $product_active; ?> <?= $sale_active; ?> <?= $channel_active; ?> <?= $pipe_active; ?> <?= $revenue_active; ?> <?= $profit_active; ?> <?= $fund_active; ?> <?= $board_active; ?> <?= $team_active; ?> <?= $impact_active; ?> <?= $project_active; ?>">
                    <a href="javascript:void(0)">
                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/project-new.png'; ?>" >
                        <span>Portfolio Information</span>
                        <?php /* if ($config_data != '' && (count($config_data['productCount']) > 0 || count($config_data['salesCount']) > 0 || count($config_data['channelCount']) > 0 || count($config_data['pipeCount']) > 0)) { ?>
                          <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                          <?php } */ ?>
                    </a>
                    <div class="sidebar-submenu <?= $product_menu; ?> <?= $sale_menu; ?> <?= $channel_menu; ?> <?= $pipe_menu; ?> <?= $revenue_menu; ?> <?= $profit_menu; ?> <?= $fund_menu; ?> <?= $board_menu; ?> <?= $impact_menu; ?> <?= $project_menu; ?>">
                        <ul>
                            <li class="<?= $product_active; ?> <?= $sale_active; ?> <?= $channel_active; ?> <?= $pipe_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/product/' . $innovation_id . '/' . $fin_year; ?>">Product &amp; Sales
                                    <?php if ($config_data != '' && (php72_count($config_data['productCount']) > 0 || php72_count($config_data['salesCount']) > 0 || php72_count($config_data['channelCount']) > 0 || php72_count($config_data['pipeCount']) > 0)) { ?>
                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                    <?php } ?>
                                </a></li>
                            <li class=" <?= $revenue_active; ?> <?= $profit_active; ?> <?= $fund_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/revenue/' . $innovation_id . '/' . $fin_year; ?>">Finance &amp; Follow-on Fundraise
                                    <?php if ($config_data != '' && (php72_count($config_data['revenueCount']) > 0 || php72_count($config_data['netCount']) > 0 || php72_count($config_data['fundCount']) > 0)) { ?>
                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                    <?php } ?>
                                </a></li>
                            <li class="<?= $team_active; ?> <?= $board_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/team/' . $innovation_id . '/' . $fin_year; ?>">Team &amp; Board meetings
                                    <?php if ($config_data != '' && (php72_count($config_data['teamCount']) > 0 || php72_count($config_data['boardCount']) > 0)) { ?>
                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                    <?php } ?>
                                </a></li>
                            <li class="<?= $impact_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/impact/' . $innovation_id . '/' . $fin_year; ?>">Impact
                                    <?php if ($config_data != '' && (php72_count($config_data['impactCount']) > 0)) { ?>
                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                    <?php } ?>
                                </a></li>
                            <li class="<?= $project_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/milestone/' . $innovation_id . '/' . $fin_year; ?>">Milestone Tracker
                                    <?php if ($config_data != '' && (php72_count($config_data['projectCount']) > 0)) { ?>
                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                    <?php } ?>
                                </a></li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown <?= $vif_active; ?> <?= $mentor_active; ?> <?= $tap_active; ?> <?= $nontap_active; ?> <?= $panel_active; ?>">
                    <a href="javascript:void(0)">
                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/fundraise.png'; ?>" >
                        <span>Incubator Services/Interventions</span>
                        <?php /* if ($config_data != '' && (count($config_data['revenueCount']) > 0 || count($config_data['netCount']) > 0 || count($config_data['vifCount']) > 0 || count($config_data['fundCount']) > 0)) { ?>
                          <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                          <?php } */ ?>
                    </a>
                    <div class="sidebar-submenu <?= $vif_menu; ?> <?= $mentor_menu; ?> <?= $tap_menu; ?> <?= $nontap_menu; ?> <?= $panel_active; ?>">
                        <ul>
                            <li class="<?= $mentor_active; ?> <?= $tap_active; ?> <?= $nontap_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/mentor/' . $innovation_id . '/' . $fin_year; ?>">Mentors &amp; Partnerships
                                    <?php /* if ($config_data != '' && count($config_data['mentorCount']) > 0) { ?><span class="text-danger"><i class="fas fa-exclamation-circle"></i></span><?php } */ ?>
                                    <?php if ($config_data != '' && (php72_count($config_data['mentorCount']) > 0 || php72_count($config_data['tapCount']) > 0 || php72_count($config_data['nontapCount']) > 0)) { ?>
                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                    <?php } ?>
                                </a></li>
                            <li class="<?= $panel_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/diagnosticpanel/' . $innovation_id . '/' . $fin_year; ?>">Diagnostic Panels <?php if ($config_data != '' && php72_count($config_data['dpCount']) > 0) { ?><span class="text-danger"><i class="fas fa-exclamation-circle"></i></span><?php } ?></a></li>
                            <li class="<?= $vif_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/viffunding/' . $innovation_id . '/' . $fin_year; ?>">Seed Funding <?php if ($config_data != '' && php72_count($config_data['vifCount']) > 0) { ?><span class="text-danger"><i class="fas fa-exclamation-circle"></i></span><?php } ?></a></li>
                            <!--<li class="<?= $tracker_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/mentor/' . $innovation_id . '/' . $fin_year; ?>">Activity Tracker <?php if ($config_data != '' && php72_count($config_data['trackerCount']) > 0) { ?><span class="text-danger"><i class="fas fa-exclamation-circle"></i></span><?php } ?></a></li>-->
                        </ul>
                    </div>
                </li>
                <?php /*
                  <li class="sidebar-dropdown <?= $mentor_active; ?> <?= $tap_active; ?> <?= $nontap_active; ?>">
                  <a href="javascript:void(0)">
                  <img src="<?php echo base_url() . 'source/portfolio_assets/img/tap.png'; ?>" >
                  <span>Team, TAP &amp; Mentors</span>
                  <?php if ($config_data != '' && (count($config_data['mentorCount']) > 0 || count($config_data['tapCount']) > 0 || count($config_data['nontapCount']) > 0)) { ?>
                  <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                  <?php } ?>
                  </a>
                  <div class="sidebar-submenu <?= $mentor_menu; ?> <?= $tap_menu; ?> <?= $nontap_menu; ?>">
                  <ul>
                  <li class="<?= $mentor_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/mentor/' . $innovation_id; ?>">Mentors <?php if ($config_data != '' && count($config_data['mentorCount']) > 0) { ?><span class="text-danger"><i class="fas fa-exclamation-circle"></i></span><?php } ?></a></li>
                  <li class="<?= $tap_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/tap/' . $innovation_id; ?>">TAP <?php if ($config_data != '' && count($config_data['tapCount']) > 0) { ?><span class="text-danger"><i class="fas fa-exclamation-circle"></i></span><?php } ?></a></li>
                  <li class="<?= $nontap_active; ?>"><a href="<?= base_url() . 'index.php/portfolio/nontap/' . $innovation_id; ?>">Partnerships(Non-TAP) <?php if ($config_data != '' && count($config_data['nontapCount']) > 0) { ?><span class="text-danger"><i class="fas fa-exclamation-circle"></i></span><?php } ?></a></li>
                  </ul>
                  </div>
                  </li>
                  <li class="sidebar-dropdown no-arrow <?= $board_active; ?>">
                  <a href="<?= base_url() . 'index.php/portfolio/boardmeeting/' . $innovation_id; ?>">
                  <img src="<?php echo base_url() . 'source/portfolio_assets/img/meeting.png'; ?>" >
                  <span>DP &amp; Board meetings</span>
                  <?php if ($config_data != '' && count($config_data['boardCount']) > 0) { ?>
                  <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                  <?php } ?>
                  </a>
                  </li>
                  <li class="sidebar-dropdown no-arrow <?= $impact_active; ?>">
                  <a href="<?= base_url() . 'index.php/portfolio/impact/' . $innovation_id; ?>">
                  <img src="<?php echo base_url() . 'source/portfolio_assets/img/import.png'; ?>" >
                  <span>Impact</span>
                  <?php if ($config_data != '' && count($config_data['impactCount']) > 0) { ?>
                  <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                  <?php } ?>
                  </a>
                  </li>
                  <li class="sidebar-dropdown <?= $project_active; ?>">
                  <a href="javascript:void(0)">
                  <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                  <span>Milestone Tracker</span>
                  <?php if ($config_data != '' && count($config_data['projectCount']) > 0) { ?>
                  <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                  <?php } ?>
                  </a>
                  <div class="sidebar-submenu <?= $project_menu; ?>">
                  <ul>
                  <?php
                  if (count($get_allmilestone) > 0) {
                  foreach ($get_allmilestone as $miles) {
                  ?>
                  <li class="<?php
                  if ($milestone_id == $miles["id"]) {
                  echo $project_active;
                  }
                  ?>">
                  <a href="<?= base_url() . 'index.php/portfolio/milestone/' . $innovation_id . '/' . $miles["id"]; ?>"><?= $miles['name'] ?></a>
                  </li>
                  <?php
                  }
                  } else {
                  ?>
                  <li class="active">
                  <a href="<?= base_url() . 'index.php/portfolio/milestone/' . $innovation_id; ?>">Milestone 1</a>
                  </li>
                  <?php
                  }
                  ?>
                  </ul>
                  </div>
                  </li>
                 */ ?>
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