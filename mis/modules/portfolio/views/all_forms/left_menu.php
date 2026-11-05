<style type="text/css">
    .sidebar_show {display:block !important;}
</style>
<?php
$showMenu = '';
$april_active = $may_active = $june_active = $july_active = $august_active = $september_active = $october_active = $november_active = $december_active = $january_active = $february_active = $march_active = '';
$april_menu = $may_menu = $june_menu = $july_menu = $august_menu = $september_menu = $october_menu = $november_menu = $december_menu = $january_menu = $february_menu = $march_menu = '';

if ($class_name == '4') {
    $april_active = 'active';
    $april_menu = $showMenu;
    $active_cls = 'activeform';
} else if ($class_name == '5') {
    $may_active = 'active';
    $may_menu = $showMenu;
    $active_cls = 'activeform';
} else if ($class_name == '6') {
    $june_active = 'active';
    $june_menu = $showMenu;
    $active_cls = 'activeform';
} else if ($class_name == '7') {
    $july_active = 'active';
    $july_menu = $showMenu;
    $active_cls = 'activeform';
} else if ($class_name == '8') {
    $august_active = 'active';
    $august_menu = $showMenu;
    $active_cls = 'activeform';
} else if ($class_name == '9') {
    $september_active = 'active';
    $september_menu = $showMenu;
    $active_cls = 'activeform';
} else if ($class_name == '10') {
    $october_active = 'active';
    $october_menu = $showMenu;
    $active_cls = 'activeform';
} else if ($class_name == '11') {
    $november_active = 'active';
    $november_menu = $showMenu;
    $active_cls = 'activeform';
} else if ($class_name == '12') {
    $december_active = 'active';
    $december_menu = $showMenu;
    $active_cls = 'activeform';
} else if ($class_name == '1') {
    $january_active = 'active';
    $january_menu = $showMenu;
    $active_cls = 'activeform';
} else if ($class_name == '2') {
    $february_active = 'active';
    $february_menu = $showMenu;
    $active_cls = 'activeform';
} else if ($class_name == '3') {
    $march_active = 'active';
    $march_menu = $showMenu;
    $active_cls = 'activeform';
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
        <?php if (!isset($nosidebar)) { ?>
            <div class="sidebar-menu">
                <ul>
                    <?php
//                    $monthlist = array("0" => 'Apr', "1" => 'May', "2" => 'Jun', "3" => 'Jul', "4" => 'Aug', "5" => 'Sep', "6" => 'Oct', "7" => 'Nov', "8" => 'Dec', "9" => 'Jan', "10" => 'Feb', "11" => 'Mar');
                    $monthlist = $this->Mportfolio->month();
                    $chnk_month = array_chunk($monthlist, 3);

                    $active_q1_a1 = strtolower(date('F', strtotime($monthlist[0]))) . '_active';
                    $active_q1_a2 = strtolower(date('F', strtotime($monthlist[1]))) . '_active';
                    $active_q1_a3 = strtolower(date('F', strtotime($monthlist[2]))) . '_active';
                    $active_q1_m1 = strtolower(date('F', strtotime($monthlist[0]))) . '_menu';
                    $active_q1_m2 = strtolower(date('F', strtotime($monthlist[1]))) . '_menu';
                    $active_q1_m3 = strtolower(date('F', strtotime($monthlist[2]))) . '_menu';
                    ?>
                    <li class="sidebar-dropdown <?= $$active_q1_a1; ?> <?= $$active_q1_a2; ?> <?= $$active_q1_a3; ?>">
                        <a href="javascript:void(0)">
                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                            <span class="text-warning">Q1</span>
                        </a>
                        <div class="sidebar-submenu <?= $$active_q1_m1; ?> <?= $$active_q1_m2; ?> <?= $$active_q1_m3; ?>">
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
                                        <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/' . $curfin_year . '/' . $url; ?>"><?php echo $fullmName; ?>
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
                    if (php72_count($chnk_month[1]) > 0) {
                        $active_q2_a1 = strtolower(date('F', strtotime($monthlist[3]))) . '_active';
                        $active_q2_a2 = strtolower(date('F', strtotime($monthlist[4]))) . '_active';
                        $active_q2_a3 = strtolower(date('F', strtotime($monthlist[5]))) . '_active';
                        $active_q2_m1 = strtolower(date('F', strtotime($monthlist[3]))) . '_menu';
                        $active_q2_m2 = strtolower(date('F', strtotime($monthlist[4]))) . '_menu';
                        $active_q2_m3 = strtolower(date('F', strtotime($monthlist[5]))) . '_menu';
                        ?>
                        <li class="sidebar-dropdown <?= $$active_q2_a1; ?> <?= $$active_q2_a2; ?> <?= $$active_q2_a3; ?>">
                            <a href="javascript:void(0)">
                                <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                                <span class="text-warning">Q2</span>
                            </a>
                            <div class="sidebar-submenu <?= $$active_q2_m1; ?> <?= $$active_q2_m2; ?> <?= $$active_q2_m3; ?>">
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
                                            <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/' . $curfin_year . '/' . $url; ?>"><?php echo $fullmName; ?>
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
                        $active_q3_a1 = strtolower(date('F', strtotime($monthlist[6]))) . '_active';
                        $active_q3_a2 = strtolower(date('F', strtotime($monthlist[7]))) . '_active';
                        $active_q3_a3 = strtolower(date('F', strtotime($monthlist[8]))) . '_active';
                        $active_q3_m1 = strtolower(date('F', strtotime($monthlist[6]))) . '_menu';
                        $active_q3_m2 = strtolower(date('F', strtotime($monthlist[7]))) . '_menu';
                        $active_q3_m3 = strtolower(date('F', strtotime($monthlist[8]))) . '_menu';
                        ?>
                        <li class="sidebar-dropdown <?= $$active_q3_a1; ?> <?= $$active_q3_a2; ?> <?= $$active_q3_a3; ?>">
                            <a href="javascript:void(0)">
                                <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                                <span class="text-warning">Q3</span>
                            </a>
                            <div class="sidebar-submenu <?= $$active_q3_m1; ?> <?= $$active_q3_m2; ?> <?= $$active_q3_m3; ?>">
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
                                            <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/' . $curfin_year . '/' . $url; ?>"><?php echo $fullmName; ?>
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
                        $active_q4_a1 = strtolower(date('F', strtotime($monthlist[9]))) . '_active';
                        $active_q4_a2 = strtolower(date('F', strtotime($monthlist[10]))) . '_active';
                        $active_q4_a3 = strtolower(date('F', strtotime($monthlist[11]))) . '_active';
                        $active_q4_m1 = strtolower(date('F', strtotime($monthlist[9]))) . '_menu';
                        $active_q4_m2 = strtolower(date('F', strtotime($monthlist[10]))) . '_menu';
                        $active_q4_m3 = strtolower(date('F', strtotime($monthlist[11]))) . '_menu';
                        ?>
                        <li class="sidebar-dropdown <?= $$active_q4_a1; ?> <?= $$active_q4_a2; ?> <?= $$active_q4_a3; ?>">
                            <a href="javascript:void(0)">
                                <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                                <span class="text-warning">Q4</span>
                            </a>
                            <div class="sidebar-submenu <?= $$active_q4_m1; ?> <?= $$active_q4_m2; ?> <?= $$active_q4_m3; ?>">
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
                                            <a href="<?= base_url() . 'index.php/portfolio/all_forms/' . $module . '/' . $innovation_id . '/' . $curfin_year . '/' . $url; ?>"><?php echo $fullmName; ?>
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
        <?php } ?>
    </div>
</nav>
<style>
    .sidebar-dropdown.active .sidebar-submenu{
        display:block !important;
    }
</style>