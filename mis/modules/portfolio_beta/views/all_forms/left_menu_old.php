<style type="text/css">
    .sidebar_show {display:block !important;}
</style>
<?php
$showMenu = 'sidebar_show';
$april_active = $may_active = $june_active = $july_active = $august_active = $september_active = $october_active = $november_active = $december_active = $january_active = $february_active = $march_active = '';
$april_menu = $may_menu = $june_menu = $july_menu = $august_menu = $september_menu = $october_menu = $november_menu = $december_menu = $january_menu = $february_menu = $march_menu = '';

if ($class_name == '4') {
    $april_active = 'active';
    $april_menu = $showMenu;
} else if ($class_name == '5') {
    $may_active = 'active';
    $may_menu = $showMenu;
} else if ($class_name == '6') {
    $june_active = 'active';
    $june_menu = $showMenu;
} else if ($class_name == '7') {
    $july_active = 'active';
    $july_menu = $showMenu;
} else if ($class_name == '8') {
    $august_active = 'active';
    $august_menu = $showMenu;
} else if ($class_name == '9') {
    $september_active = 'active';
    $september_menu = $showMenu;
} else if ($class_name == '10') {
    $october_active = 'active';
    $october_menu = $showMenu;
} else if ($class_name == '11') {
    $november_active = 'active';
    $november_menu = $showMenu;
} else if ($class_name == '12') {
    $december_active = 'active';
    $december_menu = $showMenu;
} else if ($class_name == '1') {
    $january_active = 'active';
    $january_menu = $showMenu;
} else if ($class_name == '2') {
    $february_active = 'active';
    $february_menu = $showMenu;
} else if ($class_name == '3') {
    $march_active = 'active';
    $march_menu = $showMenu;
}

if (isset($this->session->userdata['sector_lead']) && $this->session->userdata['sector_lead'] == 1) {
    $config_data = isset($configData) ? $configData : '';
} else {
    $config_data = '';
}
?>

<nav id="sidebar" data-topbar data-options="scrolltop:false" class="sidebar-wrapper top-bar">
    <div class="sidebar-content">
        <div class="allform-yrselection">
            <ul class="milestone-links">
                <li>Financial Year</li>
                <li>
                    <div class="form-group">
                        <select class="form-control form-control-sm" name="financial_year" id="financial_year" onchange="loadYear(this.value);">
                            <?php foreach ($fin_year as $year) { ?>
                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_financial) && $current_financial == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </li>
            </ul>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li class="sidebar-dropdown <?= $april_active; ?> <?= $may_active; ?> <?= $june_active; ?>">
                    <a href="javascript:void(0)">
                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                        <span class="text-warning">Q1</span>
                    </a>
                    <div class="sidebar-submenu <?= $april_menu; ?> <?= $may_menu; ?> <?= $june_menu; ?>">
                        <ul>
                            <li class="<?= $april_active; ?>">
                                <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/4'; ?>">April
                                    <?php // if ($config_data != '' && (count($config_data['salesCount']) > 0 || count($config_data['channelCount']) > 0 || count($config_data['pipeCount']) > 0)) { ?>
                                    <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span>
                                    <?php // } ?>
                                </a>

                            </li>
                            <li class="<?= $may_active; ?>">
                                <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/5'; ?>">May <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span></a>

                            </li>
                            <li class="<?= $june_active; ?>">
                                <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/6'; ?>">June <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span></a>

                            </li>

                        </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown <?= $july_active; ?> <?= $august_active; ?> <?= $september_active; ?>">
                    <a href="javascript:void(0)">
                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                        <span class="text-warning">Q2</span>
                    </a>
                    <div class="sidebar-submenu <?= $july_menu; ?> <?= $august_menu; ?> <?= $september_menu; ?>">
                        <ul>
                            <li class="<?= $july_active; ?>">
                                <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/7'; ?>">July <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span></a>

                            </li>
                            <li class="<?= $august_active; ?>">
                                <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/8'; ?>">August <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span></a>

                            </li>
                            <li class="<?= $september_active; ?>">
                                <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/9'; ?>">September <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span></a>

                            </li>

                        </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown <?= $project_active; ?>">
                    <a href="javascript:void(0)">
                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                        <span>Q3</span>
                    </a>
                    <div class="sidebar-submenu <?= $project_menu; ?>">
                        <ul>
                            <li>
                                <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/10'; ?>">October <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span></a>

                            </li>
                            <li>
                                <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/11'; ?>">November <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span></a>

                            </li>
                            <li>
                                <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/12'; ?>">December <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span></a>

                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-dropdown <?= $project_active; ?>">
                    <a href="javascript:void(0)">
                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                        <span>Q4</span>
                    </a>
                    <div class="sidebar-submenu <?= $project_menu; ?>">
                        <ul>
                            <li>
                                <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/1'; ?>">January <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span></a>

                            </li>
                            <li>
                                <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/2'; ?>">February <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span></a>

                            </li>
                            <li>
                                <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/3'; ?>">March <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span></a>

                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>