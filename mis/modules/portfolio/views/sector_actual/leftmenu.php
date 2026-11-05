<style type="text/css">
    .sidebar_show {display:block !important;}
</style>
<?php
$showMenu = '';
$april_active = $may_active = $june_active = $july_active = $august_active = $september_active = $october_active = $november_active = $december_active = $january_active = $february_active = $march_active = '';
$april_menu = $may_menu = $june_menu = $july_menu = $august_menu = $september_menu = $october_menu = $november_menu = $december_menu = $january_menu = $february_menu = $march_menu = '';

if ($class_name == '4') {
    $april_active = 'active';
    $active_cls = 'activeform';
    $april_menu = $showMenu;
} else if ($class_name == '5') {
    $may_active = 'active';
    $active_cls = 'activeform';
    $may_menu = $showMenu;
} else if ($class_name == '6') {
    $june_active = 'active';
    $active_cls = 'activeform';
    $june_menu = $showMenu;
} else if ($class_name == '7') {
    $july_active = 'active';
    $active_cls = 'activeform';
    $july_menu = $showMenu;
} else if ($class_name == '8') {
    $august_active = 'active';
    $active_cls = 'activeform';
    $august_menu = $showMenu;
} else if ($class_name == '9') {
    $september_active = 'active';
    $active_cls = 'activeform';
    $september_menu = $showMenu;
} else if ($class_name == '10') {
    $october_active = 'active';
    $active_cls = 'activeform';
    $october_menu = $showMenu;
} else if ($class_name == '11') {
    $november_active = 'active';
    $active_cls = 'activeform';
    $november_menu = $showMenu;
} else if ($class_name == '12') {
    $december_active = 'active';
    $active_cls = 'activeform';
    $december_menu = $showMenu;
} else if ($class_name == '1') {
    $january_active = 'active';
    $active_cls = 'activeform';
    $january_menu = $showMenu;
} else if ($class_name == '2') {
    $february_active = 'active';
    $active_cls = 'activeform';
    $february_menu = $showMenu;
} else if ($class_name == '3') {
    $march_active = 'active';
    $active_cls = 'activeform';
    $march_menu = $showMenu;
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
                            <?php
                            foreach ($fin_year as $year) {
                                $nxt_fyear = $year['fin_year'] + 1;
                                ?>
                                <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_financial) && $current_financial == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
<?php } ?>
                        </select>
                    </div>
                </li>
            </ul>
        </div>
        <div class="sidebar-menu">
            <ul>
                <?php
                $monthlist = array("0" => 'Apr', "1" => 'May', "2" => 'Jun', "3" => 'Jul', "4" => 'Aug', "5" => 'Sep', "6" => 'Oct', "7" => 'Nov', "8" => 'Dec', "9" => 'Jan', "10" => 'Feb', "11" => 'Mar');
                $chnk_month = array_chunk($monthlist, 3);
                ?>
                <li class="sidebar-dropdown <?= $april_active; ?> <?= $may_active; ?> <?= $june_active; ?>">
                    <a href="javascript:void(0)">
                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                        <span class="text-warning">Q1</span>
                    </a>
                    <div class="sidebar-submenu <?= $april_menu; ?> <?= $may_menu; ?> <?= $june_menu; ?>">
                        <ul>
                            <?php
                            $mnths = explode(',', $get_yearMonth[0]['months']);
                            $y = array();
                            for ($p = 0; $p < count($mnths); $p++) {
                                $f = trim($mnths[$p]);
                                unset($quater_month[$f]);
                            }
                            $flip_mnths = array_flip($mnths);
                            foreach ($chnk_month[0] as $months) {
                                $url = php72_array_search($months, $actual_month);
                                $fullmName = date("F", mktime(0, 0, 0, $url, 1));
                                $shortmName = date("M", mktime(0, 0, 0, $url, 1));
                                $pend = (array_diff_key($actual_month, $flip_mnths));

                                $pend_keys = php72_array_keys($quater_month);
                                $curdate = date('n');
                                if (($ky = array_search($curdate, $pend_keys)) !== false) {
                                    unset($pend_keys[$ky]);
                                }
                                ?>
                                <li class="<?php
                                if ($url == $class_name) {
                                    echo $active_cls;
                                }
                                ?>">
                                    <a href="<?= base_url() . 'index.php/portfolio/sector_actual/' . $module . '/' . $sector_id . '/' . $curfin_year . '/' . $url; ?>"><?php echo $fullmName; ?>
                                        <?php
                                        if (in_array($url, $pend_keys)) {
                                            ?>
                                            <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span>
                                            <?php
                                        }
                                        ?>
                                    </a>

                                </li>
<?php } ?>
                        </ul>
                    </div>
                </li>
<?php if (php72_count($chnk_month[1]) > 0) { ?>
                    <li class="sidebar-dropdown <?= $july_active; ?> <?= $august_active; ?> <?= $september_active; ?>">
                        <a href="javascript:void(0)">
                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                            <span class="text-warning">Q2</span>
                        </a>
                        <div class="sidebar-submenu <?= $july_menu; ?> <?= $august_menu; ?> <?= $september_menu; ?>">
                            <ul>
                                <?php
//                            $pending_month = array(0 => 'Apr');
                                $mnths = explode(',', $get_yearMonth[0]['months']);
                                $y = array();

                                for ($p = 0; $p < count($mnths); $p++) {
                                    $f = trim($mnths[$p]);
                                    unset($quater_month[$f]);
                                }
                                $flip_mnths = array_flip($mnths);
                                foreach ($chnk_month[1] as $months) {
                                    $url = php72_array_search($months, $actual_month);
                                    $fullmName = date("F", mktime(0, 0, 0, $url, 1));
                                    $shortmName = date("M", mktime(0, 0, 0, $url, 1));
                                    $pend = (array_diff_key($actual_month, $flip_mnths));
                                    $pend_keys = php72_array_keys($quater_month);
                                    $curdate = date('n');
                                    if (($ky = array_search($curdate, $pend_keys)) !== false) {
                                        unset($pend_keys[$ky]);
                                    }
                                    ?>
                                    <li class="<?php
                                    if ($url == $class_name) {
                                        echo $active_cls;
                                    }
                                    ?>">
                                        <a href="<?= base_url() . 'index.php/portfolio/sector_actual/' . $module . '/' . $sector_id . '/' . $curfin_year . '/' . $url; ?>"><?php echo $fullmName; ?>
                                            <?php
                                            if (in_array($url, $pend_keys)) {
                                                ?>
                                                <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span>
                                                <?php
                                            }
                                            ?>
                                        </a>

                                    </li>
    <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <?php
                }
                if (php72_count($chnk_month[2]) > 0) {
                    ?>
                    <li class="sidebar-dropdown <?= $october_active; ?> <?= $november_active; ?> <?= $december_active; ?>">
                        <a href="javascript:void(0)">
                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                            <span class="text-warning">Q3</span>
                        </a>
                        <div class="sidebar-submenu <?= $october_menu; ?> <?= $november_menu; ?> <?= $december_menu; ?>">
                            <ul>
                                <?php
//                            $pending_month = array(0 => 'Apr');
                                $mnths = explode(',', $get_yearMonth[0]['months']);
                                $y = array();

                                for ($p = 0; $p < count($mnths); $p++) {
                                    $f = trim($mnths[$p]);
                                    unset($quater_month[$f]);
                                }
                                $flip_mnths = array_flip($mnths);
                                foreach ($chnk_month[2] as $months) {
                                    $url = php72_array_search($months, $actual_month);
                                    $fullmName = date("F", mktime(0, 0, 0, $url, 1));
                                    $shortmName = date("M", mktime(0, 0, 0, $url, 1));
                                    $pend = (array_diff_key($actual_month, $flip_mnths));
                                    $pend_keys = php72_array_keys($quater_month);
                                    $curdate = date('n');
                                    if (($ky = array_search($curdate, $pend_keys)) !== false) {
                                        unset($pend_keys[$ky]);
                                    }
                                    ?>
                                    <li class="<?php
                                    if ($url == $class_name) {
                                        echo $active_cls;
                                    }
                                    ?>">
                                        <a href="<?= base_url() . 'index.php/portfolio/sector_actual/' . $module . '/' . $sector_id . '/' . $curfin_year . '/' . $url; ?>"><?php echo $fullmName; ?>
                                            <?php
                                            if (in_array($url, $pend_keys)) {
                                                ?>
                                                <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span>
                                                <?php
                                            }
                                            ?>
                                        </a>

                                    </li>
    <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <?php
                }
                if (php72_count($chnk_month[3]) > 0) {
                    ?>
                    <li class="sidebar-dropdown <?= $january_active; ?> <?= $february_active; ?> <?= $march_active; ?>">
                        <a href="javascript:void(0)">
                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                            <span class="text-warning">Q4</span>
                        </a>
                        <div class="sidebar-submenu <?= $january_menu; ?> <?= $february_menu; ?> <?= $march_menu; ?>">
                            <ul>
                                <?php
//                            $pending_month = array(0 => 'Apr');
                                $mnths = explode(',', $get_yearMonth[0]['months']);
                                $y = array();

                                for ($p = 0; $p < count($mnths); $p++) {
                                    $f = trim($mnths[$p]);
                                    unset($quater_month[$f]);
                                }
                                $flip_mnths = array_flip($mnths);
                                foreach ($chnk_month[3] as $months) {
                                    $url = php72_array_search($months, $actual_month);
                                    $fullmName = date("F", mktime(0, 0, 0, $url, 1));
                                    $shortmName = date("M", mktime(0, 0, 0, $url, 1));
                                    $pend = (array_diff_key($actual_month, $flip_mnths));
                                    $pend_keys = php72_array_keys($quater_month);
                                    $curdate = date('n');
                                    if (($ky = array_search($curdate, $pend_keys)) !== false) {
                                        unset($pend_keys[$ky]);
                                    }
                                    ?>
                                    <li class="<?php
                                    if ($url == $class_name) {
                                        echo $active_cls;
                                    }
                                    ?>">
                                        <a href="<?= base_url() . 'index.php/portfolio/sector_actual/' . $module . '/' . $sector_id . '/' . $curfin_year . '/' . $url; ?>"><?php echo $fullmName; ?>
                                            <?php
                                            if (in_array($url, $pend_keys)) {
                                                ?>
                                                <span class="alert-allupdation"><i class="fas fa-exclamation-circle"></i></span>
                                                <?php
                                            }
                                            ?>
                                        </a>

                                    </li>
    <?php } ?>
                            </ul>
                        </div>
                    </li>
<?php } ?>
            </ul>
        </div>
    </div>
</nav>
<style>
    .sidebar-dropdown.active .sidebar-submenu{
        display:block !important;
    }
</style>