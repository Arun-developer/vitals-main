<?php
$split_empname = explode(' ', $this->session->userdata['emp_name']);
$first_name = array_shift($split_empname);
$partner_str = preg_replace('/\s+/', '', $this->session->userdata['partner_name']);
$gtag_user = $first_name . '_' . $partner_str . '_' . $this->session->userdata['emp_number'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Villgro MIS</title>
<!--        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23930880-2"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'UA-23930880-2', {'user_id': '<?= $gtag_user; ?>'});
        </script>-->
        <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    </head>

    <body>
        <div id="loaderGif"></div>
        <div class="fixed-headervi">
            <header>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="vil-logo">
                                <a href="<?php echo base_url(); ?>">
                                    <?php
                                    if ($this->session->userdata['partner_id'] == '10') {
                                        $logo_name = 'ceew.png';
                                    } else {
                                        $logo_name = 'logo.jpg';
                                    }
                                    ?>
                                    <img src="<?php echo base_url() . 'source/portfolio_assets/img/' . $logo_name; ?>" class="responsive" alt="Villgro Logo" />
                                </a>
                            </div>
                        </div>
                        <?php
                        $switch_type = '';
                        if ($this->session->userdata('role_id') == 2 && $this->session->userdata('user_type') == 'admin') {
                            $switch_type = 'Switch to user';
                        } else if ($this->session->userdata('role_id') == 2 && $this->session->userdata('user_type') == 'employee') {
                            $switch_type = 'Switch to admin';
                        }
                        ?>

                        <div class="col-xl-2 offset-xl-4 offset-md-2 col-md-4 order-10 col-12">
                            <small>Welcome,</small>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                    if ($this->session->userdata('user_type') == 'superadmin') {
                                        echo "Super Admin";
                                    } else if ($this->session->userdata('user_type') == 'admin' and $this->session->userdata('role_id') == 2) {
                                        echo ucfirst($this->session->userdata('emp_name'));
                                    } else if ($this->session->userdata('user_type') == 'employee' and $this->session->userdata('role_id') == 2) {
                                        echo ucfirst($this->session->userdata('emp_name'));
                                    } else if ($this->session->userdata('user_type') == 'admin' and $this->session->userdata('role_id') == 1) {
                                        echo ucfirst($this->session->userdata('emp_name'));
                                    } else if ($this->session->userdata('user_type') != 'admin' and $this->session->userdata('user_type') != 'mipuser') {
                                        echo ucfirst($this->session->userdata('emp_name'));
                                    } else {
                                        if (($this->session->userdata('user_type') != 'admin')) {
                                            echo ucfirst($this->session->userdata('name'));
                                        } else {
                                            echo ucfirst($this->uri->segment('3'));
                                        }
                                    }
                                    ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <?php if ($switch_type != '') { ?>
                                        <a class="dropdown-item" href="<?php echo base_url() . 'index.php/login/admin_portfolio'; ?>"><i class="fas fa-retweet"></i> <?= $switch_type; ?></a>
                                    <?php } ?>
                                    <a class="dropdown-item" href="<?php echo site_url('changepass'); ?>"><i class="fas fa-key"></i> Change password</a>
                                    <a class="dropdown-item" href="<?php echo base_url() . 'index.php/login/logout'; ?>"><i class="fas fa-sign-out-alt"></i> Sign out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="v-menu">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <ul>
                                <li><a href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>">Deals</a></li>
                                <?php if ($this->session->userdata['user_type'] == 'employee' && $this->session->userdata['ais_privilege'] == '1') { ?>
                                    <li><a href="<?php echo base_url() . 'index.php/login/requests'; ?>">Requests</a></li>
                                <?php } ?>
                                <?php if ($this->session->userdata['ais_privilege'] == '1') { ?>
                                    <li><a href="<?php echo base_url() . 'index.php/login/approvals'; ?>">Approve</a></li>
                                <?php } ?>
                                <li><a href="<?php echo base_url() . 'index.php/portfolio/portfolio_summary'; ?>">Portfolio</a></li>
                                <!-- <li><a href="<?php echo base_url() . 'index.php/login/resources'; ?>">Resources</a></li> -->
                                <!-- <li><a href="<?php echo base_url() . 'index.php/funder/display_summary_list'; ?>">Funds/Grants</a></li>-->
                                <li><a href="<?php echo base_url() . 'index.php/login/reports'; ?>">Reports</a></li>
                                <?php if ($this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                    <li><a href="<?php echo base_url() . 'index.php/login/master'; ?>">Master's</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $userName = strstr($this->session->userdata['emp_name'] . ' ', ' ', true);
        if ($this->session->userdata('user_type')) {
            if ($this->session->userdata('user_type') != 'incubatee' && $this->session->userdata('ais_privilege') == 1) {
                $pendingapproval_count = total_pending_count();
            }
        }

        if (isset($last_logtime) && $last_logtime != '') {
            $log_detail = date("M d, Y h:i a", strtotime($last_logtime));
            $welcome_msg = "your last login was on $log_detail";
        } else {
            $welcome_msg = 'This is your first login';
        }
        ?>

        <div class="vi-newdashboard">
            <?php if ($this->session->userdata['last_log_view'] == 1) { ?>
                <div class="msg success"><strong>Welcome <span><?php echo $userName; ?>,</span></strong>
                    <p><?= $welcome_msg; ?></p>
                </div>
            <?php } ?>
            <div class="container-fluid">
                <div class="topper-dashvil">
                    <div class="row">
                        <div class=" col-xl-4 col-lg-4 col-md-4 col-12 gray-background">
                            <div class="title-label">What's Pending</div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                    <a href="<?= base_url() . 'index.php/portfolio/configurationlist'; ?>">
                                        <div class="dash-card">
                                            <h6><?php echo $config_count; ?></h6>
                                            <p>Incubatee FY Plan <i class="fas fa-chevron-circle-right"></i></p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                    <a href="<?= base_url() . 'index.php/portfolio/pendinginputlist'; ?>">
                                        <div class="dash-card">
                                            <h6><?php echo $pending_count; ?></h6>
                                            <p>Incubatee Monthly Updates <i class="fas fa-chevron-circle-right"></i></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                <div class="row">
                                    <?php
                                    if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata('user_type') == 'admin') {
                                        $url = base_url() . 'index.php/portfolio/plan_approvals';
                                        ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col">
                                            <a href="<?= $url; ?>">
                                                <div class="dash-card mar-tp0">
                                                    <h6><?= $planapp_count; ?></h6>
                                                    <p>Approve Incubatee FY Plan <i class="fas fa-chevron-circle-right"></i></p>
                                                </div>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                    if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
                                        if ($sectorplan_count != '' || $sectorplan_count > 0) {
                                            $url = base_url() . 'index.php/portfolio/sectorplan_approvals';
                                        } else {
                                            $url = 'javascript:void(0)';
                                        }
                                        ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col">
                                            <a href="<?= $url; ?>">
                                                <div class="dash-card mar-tp0">
                                                    <h6><?= $sectorplan_count; ?></h6>
                                                    <p>Approve Sector FY Plan <i class="fas fa-chevron-circle-right"></i></p>
                                                </div>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <?php if ($this->session->userdata('user_type') != 'incubatee' && $this->session->userdata('ais_privilege') == 1) { ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col">
                                            <a href="<?php echo site_url('login/approvals'); ?>">
                                                <div class="dash-card mar-tp0">
                                                    <h6><?= $pendingapproval_count; ?></h6>
                                                    <p>Request Approvals <i class="fas fa-chevron-circle-right"></i></p>
                                                </div>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                <div class="row">
                                    <?php
                                    if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata('user_type') == 'admin') {
                                        $url = base_url() . 'index.php/portfolio/plan_approvals';
                                        ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col">
                                            <a href="<?= $url; ?>">
                                                <div class="dash-card mar-tp0">
                                                    <h6><?= $planapp_count; ?></h6>
                                                    <p>Approve Incubatee FY Plan <i class="fas fa-chevron-circle-right"></i></p>
                                                </div>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                    if ($this->session->userdata('user_type') != 'incubatee' && $this->session->userdata('ais_privilege') == 1) {
                                        ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col">
                                            <a href="<?php echo site_url('login/approvals'); ?>">
                                                <div class="dash-card mar-tp0">
                                                    <h6><?= $pendingapproval_count; ?></h6>
                                                    <p>Request Approvals <i class="fas fa-chevron-circle-right"></i></p>
                                                </div>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-12 pad-10">
                            <div class="vil-milestone dash-milestone hgt-100 boxshadows-white br-radius4 ">
                                <div class="title-label">Upcoming/Due Milestones</div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th class="text-left">Incubatee</th>
                                            <th class="text-left">Milestone</th>
                                            <th class="text-left">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $n = 1;
                                        foreach ($upcoming_milestone as $miles) {
                                            $company_name = strlen($miles['company_name']) > 20 ? substr($miles['company_name'], 0, 20) . "..." : $miles['company_name'];
                                            $miles_name = strlen($miles['name']) > 15 ? substr($miles['name'], 0, 15) . "..." : $miles['name'];
                                            $mile_date = (isset($miles['date']) && $miles['date'] != '0000-00-00 00:00:00') ? date('d-M-Y', strtotime($miles['date'])) : '';

                                            $curDateTime = date("Y-m-d");
                                            $myDate = date("Y-m-d", strtotime($miles['date']));
                                            if ($myDate < $curDateTime) {
                                                $date_color = "text-danger";
                                            } else {
                                                $date_color = "text-success";
                                            }
                                            ?>
                                            <tr>

                                                <td><?= $n; ?></td>
                                                <td class="text-left" title="<?= $miles['company_name']; ?>"><a href="<?= base_url() . 'index.php/portfolio/company_summary/' . $miles['inv_id']; ?>"><?= $company_name; ?></a></td>
                                                <td class="text-left" title="<?= $miles['name']; ?>"><?= $miles_name; ?></td>
                                                <td class="text-left">
                                                    <span class="<?= $date_color; ?>"><?= $mile_date; ?></span>
                                                </td>
                                            </tr>
                                            <?php
                                            $n++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class=" col-xl-4 col-lg-4 col-md-4 col-12 gray-background">
                            <div class=" br-radius4 positioRelative">
                                <div class="title-label">
                                    <ul class="milestone-links">
                                        <?php
                                        $get_sector = explode(',', $lead_sector);
                                        $split_sector = array_filter($get_sector);
                                        if (count($split_sector) > 1) {
                                            ?>
                                            <li>Summary for</li>
                                        <?php } if (count($split_sector) == 1) {
                                            ?>
                                            <li>Summary for <span id="company_sector"></span></li>
                                        <?php } else if (count($split_sector) == 0) { ?>
                                            <li>Summary</li>
                                        <?php } if (count($split_sector) > 1) { ?>
                                            <li style="padding: 0px;">
                                                <select name="comp_sector" id="comp_sector" class="change_sectorSel" onchange="change_comp_sector(this.value);">
                                                    <?php foreach ($sectors_values as $sector) { ?>
                                                        <option value="<?php echo $sector['id']; ?>">
                                                            <?php echo $sector['sector']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="table-responsive cmy-vil-summary">
                                    <table class="summary_table ">
                                        <tr>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td class="title-label-sub">Pipeline</td>
                                                        <td class="title-label-sub"><span class="pipelinehead">Actual/Plan</span></td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                        $app_value = $applicationDetails[0]['inc_app'] + $applicationDetails[0]['eir_app'] + $applicationDetails[0]['seed_app'] + $applicationDetails[0]['pitch_app'] + $applicationDetails[0]['liveli_app'];
                                                        $app_total_value = isset($total_count[0]['application']) && $total_count[0]['application'] != '' ? $total_count[0]['application'] : '0';
                                                        ?>
                                                        <td>1. Application :</td>
                                                        <td><span id="get_Capp"><?php echo $app_value . ' / ' . $app_total_value; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                        $pard_value = $pard_allcount[0]['PARD_count'];
                                                        $pard_total_value = isset($total_count[0]['pa_rd']) && $total_count[0]['pa_rd'] != '' ? $total_count[0]['pa_rd'] : '0';
                                                        ?>
                                                        <td>2. PA/RD :</td>
                                                        <td><span id="get_Cpard"><?php echo $pard_value . ' / ' . $pard_total_value; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                        $iic_value = $IIC_allCount[0]['IIC_count'];
                                                        $iic_total_value = isset($total_count[0]['iic_approve']) && $total_count[0]['iic_approve'] != '' ? $total_count[0]['iic_approve'] : '0';
                                                        ?>
                                                        <td>3. Deals at IIC :</td>
                                                        <td><span id="get_Ciic"><?php echo $iic_value . ' / ' . $iic_total_value; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                        $eic_value = $EIC_allcount[0]['EIC_count'];
                                                        $eic_total_value = isset($total_count[0]['eic_approve']) && $total_count[0]['eic_approve'] != '' ? $total_count[0]['eic_approve'] : '0';
                                                        ?>
                                                        <td>4. Deals at EIC :</td>
                                                        <td><span id="get_Ceic"><?php echo $eic_value . ' / ' . $eic_total_value; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="title-label-sub" colspan="2">Incubatees</td>
                                                    </tr>

                                                    <?php
                                                    $inc_total_value = isset($total_count[0]['tot_annual']) && $total_count[0]['tot_annual'] != '' ? $total_count[0]['tot_annual'] : '0';
                                                    $exit_total_value = isset($total_count[0]['exit_annual']) && $total_count[0]['exit_annual'] != '' ? $total_count[0]['exit_annual'] : '0';
                                                    $grad_total_value = isset($total_count[0]['graduate_annual']) && $total_count[0]['graduate_annual'] != '' ? $total_count[0]['graduate_annual'] : '0';
                                                    $new_total_value = isset($total_count[0]['new_annual']) && $total_count[0]['new_annual'] != '' ? $total_count[0]['new_annual'] : '0';
                                                    $ext_grad_tot = $exit_total_value + $grad_total_value;
                                                    ?>

                                                    <tr>
                                                        <td>Total Incubatees :</td>
                                                        <td><span id="get_Ctotal"><?php echo $total_companies[0]['annual'] . ' / ' . $inc_total_value; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Exits & Graduates :</td>
                                                        <td><span id="get_Cexits"><?php echo $ext_count . ' / ' . $ext_grad_tot; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>New Incubatees :</td>
                                                        <td><span id="get_Cnew"><?php echo $new_companies[0]['annual'] . ' / ' . $new_total_value; ?></span></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="overlaysummary_id"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $summary_space = '';
                if ($this->session->userdata['sector_lead'] == '1') {
                    ?>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col">
                            <div class="title-cart-vi">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <ul class="milestone-links">
                                            <?php
                                            $get_sector = explode(',', $lead_sector);
                                            $split_sector = array_filter($get_sector);
                                            if (count($split_sector) > 1) {
                                                ?>
                                                <li style="padding: 0;"><h4>Incubatees for</h4></li>
                                            <?php } if (count($split_sector) == 1) {
                                                ?>
                                                <li style="padding: 0;"><h4>Incubatees for <span id="selected_sector"></span></h4></li>
                                            <?php } else if (count($split_sector) == 0) { ?>
                                                <li style="padding: 0;"><h4>Incubatees</h4></li>
                                                <?php
                                            }

                                            if (count($split_sector) > 1) {
                                                ?>
                                                <li style="padding: 0px;">
                                                    <select name="sel_sector" id="sel_sector" class="change_sectorSel" onchange="change_sector(this.value);">
                                                        <?php foreach ($sectors_values as $sector) { ?>
                                                            <option value="<?php echo $sector['id']; ?>">
                                                                <?php echo $sector['sector']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </li></ul>
                                        <?php } ?>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-12 text-right">
                                    </div>
                                </div>
                            </div>
                            <div class="comapny-graph">
                                <div class="row">
                                    <div class="col-lg-4 brd-rgtChart">
                                        <div class="company_chartvi brd-none">
                                            <div class="vil-portfolio_chart">
                                                <a href="javascript:void(0)" onclick="loadTotalCompanies();">
                                                    <div id="total_companies"></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 brd-rgtChart">
                                        <div class="company_chartvi brd-none">
                                            <div class="vil-portfolio_chart">
                                                <a href="javascript:void(0)" onclick="loadNewCompanies();">
                                                    <div id="new_companies"></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="company_chartvi brd-none">
                                            <div class="vil-portfolio_chart">
                                                <a href="javascript:void(0)" onclick="loadExitCompanies();">
                                                    <div id="exist_companies"></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $summary_space = 'mar-tp0';
                }
                ?>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col">
                        <div class="title-cart-vi <?= $summary_space; ?>">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Villgro Summary</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph">
                            <div class="row">
                                <div class="col-lg-6 brd-rgtChart">
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0)" onclick="loadAllRevenue();">
                                                <div id="all_revenue"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 brd-rgtChart">
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0)" onclick="loadAllProfit();">
                                                <div id="all_profit"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph">
                            <div class="row">
                                <div class="col-lg-6 brd-rgtChart">
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0)" onclick="loadAllCapital();">
                                                <div id="all_capital"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 brd-rgtChart">
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0)" onclick="loadAllSeedfund();">
                                                <div id="all_seedfund"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph">
                            <div class="row">
                                <div class="col-lg-6 brd-rgtChart">
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0)" onclick="loadMentorNumber();">
                                                <div id="mentor_number"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0)" onclick="loadMentorHour();">
                                                <div id="mentor_hour"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="comapny-graph">
                            <div class="row">
                                <div class="col-lg-6 brd-rgtChart">
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0)" onclick="loadTap();">
                                                <div id="tap_chart"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="company_chartvi brd-none">
                                        <div class="vil-portfolio_chart">
                                            <a href="javascript:void(0)" onclick="loadDPMeeting();">
                                                <div id="dp_meeting"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade seedfund-portfolio" id="chartdiv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-head">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4 id="chartTitle"></h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="newmodelQuaterSlection">
                                <form method="post" id="chartFilter">
                                    <div class="row">
                                        <div class="col-12 col-xl-2 col-md-2 col-lg-2">
                                            <label class="wdt-100">View Type :</label>
                                            <select class="form-control form-control-sm" class="viewType" id="viewType" onchange="selectType(this.value);">
                                                <option value="">--Select--</option>
                                                <option value="1">Monthly</option>
                                                <option value="2">Quarterly</option>
                                            </select>
                                        </div>
                                        <div id="monthRange">
                                            <div class="col-12 col-xl-12 col-md-12 col-lg-12">
                                                <div class="row">
                                                    <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                        <label class="wdt-100">From :</label>
                                                        <input Type="text" class="startDat form-control form-control-sm dateCalendar" id="startDate" name="startDate" placeholder="dd-mm-yyyy">
                                                    </div>
                                                    <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                        <label class="wdt-100">To :</label>
                                                        <input Type="text" class="endDat form-control form-control-sm dateCalendar" id="endDate" name="endDate" placeholder="dd-mm-yyyy">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-xl-2 col-md-2 col-lg-2">
                                            <label class="wdt-100">&nbsp;</label>
                                            <button class="btn btn-sm btn-success wdt-100" id="chart_searchBtn" type="button" onclick="totalCompanyFilter();">Search</button>
                                        </div>
                                        <input type="hidden" id="functionName" value="">
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <div class="col-12 col-xl-12 col-md-12 col-lg-12">
                                    <div id="charts1">
                                        <div id="chartContent" class="chart_modal"></div>
                                    </div>
                                    <br>
                                    <div class="loadChartBtn">
                                        <span style="display: inline-block; width: 35px;">
                                            <a href="javascript:void(0)" id="pre_chart" title="Next">
                                                <i class="fas fa-chevron-circle-left"></i>
                                            </a>
                                        </span>
                                        <span style="display: inline-block; width: 35px;">
                                            <a href="javascript:void(0)" id="nxt_chart" title="Previous">
                                                <i class="fas fa-chevron-circle-right"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade seedfund-portfolio" id="linechartdiv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-head">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4 id="lineChartTitle"></h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="newmodelQuaterSlection">
                                <div class="row">
                                    <div class="col-12 col-xl-2 col-md-2 col-lg-2">
                                        <label class="wdt-100">View Type :</label>
                                        <select class="form-control form-control-sm" class="lineViewType" id="lineViewType" onchange="selectLineType(this.value);">
                                            <option value="">--Select--</option>
                                            <option value="1">Monthly</option>
                                            <option value="2">Quarterly</option>
                                        </select>
                                    </div>
                                    <div id="quarterView">
                                        <div class="col-12 col-xl-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <label class="wdt-100">From :</label>
                                                    <div class="row">
                                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                            <select class="form-control form-control-sm dropdown" name="fromQuarterName" id="fromQuarterName">
                                                                <option value="">--Quarter--</option>
                                                                <option value="1" selected="">Q1</option>
                                                                <option value="2">Q2</option>
                                                                <option value="3">Q3</option>
                                                                <option value="4">Q4</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                            <select class="form-control form-control-sm dropdown" name="fromYear" id="fromYear">
                                                                <option value="">--Year--</option>
                                                                <?php foreach ($fin_year as $year) { ?>
                                                                    <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <label class="wdt-100">To :</label>
                                                    <div class="row">
                                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                            <select class="form-control form-control-sm dropdown" name="toQuarterName" id="toQuarterName">
                                                                <option value="">--Quarter--</option>
                                                                <option value="1">Q1</option>
                                                                <option value="2">Q2</option>
                                                                <option value="3">Q3</option>
                                                                <option value="4" selected="">Q4</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                            <select class="form-control form-control-sm dropdown" name="toYear" id="toYear">
                                                                <option value="">--Year--</option>
                                                                <?php foreach ($fin_year as $year) { ?>
                                                                    <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="monthView">
                                        <div class="col-12 col-xl-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <label class="wdt-100">From :</label>
                                                    <input Type="text" class="form-control form-control-sm" id="lineStartDate" name="lineStartDate" placeholder="dd-mm-yyyy">
                                                </div>
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <label class="wdt-100">To :</label>
                                                    <input Type="text" class="form-control form-control-sm" id="lineEndDate" name="lineEndDate" placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-2 col-md-2 col-lg-2">
                                        <label class="wdt-100">&nbsp;</label>
                                        <button class="btn btn-sm btn-success wdt-100" id="line_searchBtn" type="button" onclick="totalLineFilter();">Search</button>
                                    </div>
                                    <input type="hidden" id="lineName" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-xl-12 col-md-12 col-lg-12 bgf4f5fa">
                                    <div id="charts1">
                                        <div id="lineChartContent" class="chart_modal"></div>
                                    </div>
                                    <br>
                                    <div class="loadChartBtn">
                                        <span style="display: inline-block; width: 35px;">
                                            <a href="javascript:void(0)" id="line_pre_chart" title="Next">
                                                <i class="fas fa-chevron-circle-left"></i>
                                            </a></span>
                                        <span style="display: inline-block; width: 35px;">
                                            <a href="javascript:void(0)" id="line_nxt_chart" title="Previous">
                                                <i class="fas fa-chevron-circle-right"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade seedfund-portfolio" id="newChartdiv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-head">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4 id="newChartTitle"></h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="newmodelQuaterSlection">
                                <div class="row">
                                    <div class="col-12 col-xl-2 col-md-2 col-lg-2">
                                        <label class="wdt-100">View Type :</label>
                                        <select class="form-control form-control-sm" class="lineViewType" id="newViewType" onchange="selectNewType(this.value);">
                                            <option value="">--Select--</option>
                                            <option value="1">Monthly</option>
                                            <option value="2">Quarterly</option>
                                        </select>
                                    </div>
                                    <div id="quarterNewView">
                                        <div class="col-12 col-xl-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <label class="wdt-100">From :</label>
                                                    <div class="row">
                                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                            <select class="form-control form-control-sm dropdown" name="fromNewQuarterName" id="fromNewQuarterName">
                                                                <option value="">--Quarter--</option>
                                                                <option value="1" selected="">Q1</option>
                                                                <option value="2">Q2</option>
                                                                <option value="3">Q3</option>
                                                                <option value="4">Q4</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                            <select class="form-control form-control-sm dropdown" name="fromNewYear" id="fromNewYear">
                                                                <option value="">--Year--</option>
                                                                <?php foreach ($fin_year as $year) { ?>
                                                                    <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <label class="wdt-100">To :</label>
                                                    <div class="row">
                                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                            <select class="form-control form-control-sm dropdown" name="toQuarterName" id="toNewQuarterName">
                                                                <option value="">--Quarter--</option>
                                                                <option value="1">Q1</option>
                                                                <option value="2">Q2</option>
                                                                <option value="3">Q3</option>
                                                                <option value="4" selected="">Q4</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                            <select class="form-control form-control-sm dropdown" name="toYear" id="toNewYear">
                                                                <option value="">--Year--</option>
                                                                <?php foreach ($fin_year as $year) { ?>
                                                                    <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="monthNewView">
                                        <div class="col-12 col-xl-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <label class="wdt-100">From :</label>
                                                    <input Type="text" class="form-control form-control-sm" id="newStartDate" name="lineStartDate" placeholder="dd-mm-yyyy">
                                                </div>
                                                <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                                    <label class="wdt-100">To :</label>
                                                    <input Type="text" class="form-control form-control-sm" id="newEndDate" name="lineEndDate" placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-2 col-md-2 col-lg-2">
                                        <label class="wdt-100">&nbsp;</label>
                                        <button class="btn btn-sm btn-success wdt-100" id="new_searchBtn" type="button" onclick="totalNewFilter();">Search</button>
                                    </div>
                                    <input type="hidden" id="newName" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-xl-12 col-md-12 col-lg-12 bgf4f5fa">
                                    <div id="charts1">
                                        <div id="newChartContent" class="chart_modal"></div>
                                    </div>
                                    <br>
                                    <div class="loadChartBtn">
                                        <span style="display: inline-block; width: 35px;">
                                            <a href="javascript:void(0)" id="new_pre_chart" title="Next">
                                                <i class="fas fa-chevron-circle-left"></i>
                                            </a></span>
                                        <span style="display: inline-block; width: 35px;">
                                            <a href="javascript:void(0)" id="new_nxt_chart" title="Previous">
                                                <i class="fas fa-chevron-circle-right"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer id="bottom">
            <section class="container clearfix">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-12">
                        <a href="#"></a>
                        <a href="#"></a>
                        <a href="#"></a>
                        <a href="#"></a>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 text-right">
                        Copyright © <?= date('Y'); ?> <a href="<?= site_url(); ?>">mis.villgroapps.org</a>
                    </div>
                </div>
            </section>
        </footer>

        <input type="hidden" id="check_firstLoad" value="<?php echo $this->session->userdata['last_log_view']; ?>">
        <?php $this->session->set_userdata('last_log_view', '0'); ?>

        <input type="hidden" id="lead_sector" value="<?= $split_sector[0]; ?>">
        <input type="hidden" id="current_fy" value="<?= isset($current_fy) && $current_fy != '' ? $current_fy : date('Y'); ?>">
        <input type="hidden" id="current_partner" value="<?= $this->session->userdata['partner_id']; ?>">
        <input type="hidden" id="find_secLead" value="<?= $this->session->userdata['sector_lead']; ?>">
        <input type="hidden" id="filter_comp_sector" value="">
        <input type="hidden" id="filter_sector" value="">

        <script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>

        <script src="<?php echo base_url() . 'source/portfolio_assets/js/highcharts.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/series-label.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/exporting.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/export-data.js'; ?>"></script>

        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/additional-methods.js'; ?>"></script>


        <script type="text/javascript">

                                            $(document).ready(function () {
                                                $('#loaderGif').css('display', 'block');
                                                $('#monthRange').hide();
                                                $('#quarterView').hide();
                                                $('#monthView').hide();

                                                var first_login = $('#check_firstLoad').val();
                                                if (first_login == 1) {
                                                    localStorage.removeItem('port_sector');
                                                }

                                                var sector_id = $('#lead_sector').val();
                                                $('#filter_sector').val(sector_id);
                                                $('#chart_filter_id').val(sector_id);
                                                $('#lineChart_filter_id').val(sector_id);

                                                if (sector_id != '') {
                                                    change_comp_sector(sector_id);
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/sectorname",
                                                        data: {sector_id: sector_id},
                                                        dataType: 'html',
                                                        success: function (sec_msg) {
                                                            $('#selected_sector').html(sec_msg);
                                                            $('#sel_sector').val(sector_id);
                                                        }
                                                    });

                                                    $.ajax({
                                                        type: "POST",
                                                        async: false,
                                                        url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/totalCompanies",
                                                        data: {id: 1, sector_id: sector_id},
                                                        dataType: 'html',
                                                        success: function (tot_msg) {
                                                            $("#total_companies").html(tot_msg);
                                                        }
                                                    });

                                                    $.ajax({
                                                        type: "POST",
                                                        async: false,
                                                        url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/newCompanies",
                                                        data: {id: 1, sector_id: sector_id},
                                                        dataType: 'html',
                                                        success: function (new_msg) {
                                                            $("#new_companies").html(new_msg);
                                                        }
                                                    });

                                                    $.ajax({
                                                        type: "POST",
                                                        async: false,
                                                        url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/exitCompanies",
                                                        data: {id: 1, sector_id: sector_id},
                                                        dataType: 'html',
                                                        success: function (exit_msg) {
                                                            $("#exist_companies").html(exit_msg);
                                                        }
                                                    });
                                                }

                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/mentorNumber",
                                                    data: {id: 1},
                                                    dataType: 'html',
                                                    success: function (num_msg) {
                                                        $("#mentor_number").html(num_msg);
                                                    }
                                                });

                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/mentorHour",
                                                    data: {id: 1},
                                                    dataType: 'html',
                                                    success: function (hr_msg) {
                                                        $("#mentor_hour").html(hr_msg);
                                                    }
                                                });

                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/Tap",
                                                    data: {id: 1},
                                                    dataType: 'html',
                                                    success: function (tap_msg) {
                                                        $("#tap_chart").html(tap_msg);
                                                    }
                                                });

                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/dpMeeting",
                                                    data: {id: 1},
                                                    dataType: 'html',
                                                    success: function (meet_msg) {
                                                        $("#dp_meeting").html(meet_msg);
                                                        home_revenue();
                                                    }
                                                });
                                            });

                                            $('#chartdiv').on('hide.bs.modal', function () {
                                                $('#conversationData').scrollTop(0);
                                                $('#conversationData').html('');
                                            });

                                            $('#linechartdiv').on('hide.bs.modal', function () {
                                                $('#conversationLineData').scrollTop(0);
                                                $('#conversationLineData').html('');
                                            });

                                            var limit = 5;
                                            var start = 0;
                                            var action = 'inactive';

                                            function loadConversation() {
                                                start = 0;
                                                $("#commentSubmit")[0].reset();
                                                $('#conversationData, .error').html('');
                                                load_chart_data(limit, start);
                                            }

                                            function loadLineConversation() {
                                                start = 0;
                                                $("#commentLineSubmit")[0].reset();
                                                $('#conversationLineData, .error').html('');
                                                load_lineChart_data(limit, start);
                                            }

                                            function load_chart_data(limit, start) {
                                                var fin_year = $('#current_fy').val();
                                                var module_id = $('#module_id').val();
                                                var sector_id = $('#filter_sector').val();
                                                var partner_id = $('#current_partner').val();
                                                var page_id = '1';

                                                $.ajax({
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/getConversation",
                                                    method: "POST",
                                                    data: {limit: limit, start: start, sector_id: sector_id, page_id: page_id, module_id: module_id, fin_year: fin_year, partner_id: partner_id},
                                                    cache: false,
                                                    success: function (data) {
                                                        var trim_data = data.trim();
                                                        if (trim_data != '')
                                                            $('#load_data_message').html("<button type='button' class='btn btn-warning'>Loading....</button>");

                                                        if (start == 0) {
                                                            if (trim_data != '')
                                                                $('#conversationData').html(data);
                                                            else
                                                                // $('#conversationData').text('Be the first to comment it.!');
                                                                $('#conversationData').html('');
                                                            $('#load_data_message').html("");
                                                        } else {
                                                            setTimeout(function () {
                                                                $('#conversationData').append(data);
                                                                $('#load_data_message').html("");
                                                            }, 2000);
                                                        }

                                                        action = "inactive";
                                                    }
                                                });
                                            }

                                            function load_lineChart_data(limit, start) {
                                                var fin_year = $('#current_fy').val();
                                                var module_id = $('#lineModule_id').val();
                                                var sector_id = $('#filter_sector').val();
                                                var partner_id = $('#current_partner').val();
                                                var page_id = '1';

                                                $.ajax({
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/getConversation",
                                                    method: "POST",
                                                    data: {limit: limit, start: start, sector_id: sector_id, page_id: page_id, module_id: module_id, fin_year: fin_year, partner_id: partner_id},
                                                    cache: false,
                                                    success: function (data) {
                                                        var trim_data = data.trim();
                                                        if (trim_data != '')
                                                            $('#load_lineData_message').html("<button type='button' class='btn btn-warning'>Loading....</button>");

                                                        if (start == 0) {
                                                            if (trim_data != '')
                                                                $('#conversationLineData').html(data);
                                                            else
                                                                // $('#conversationLineData').text('Be the first to comment it.!');
                                                                $('#conversationLineData').html('');
                                                            $('#load_lineData_message').html("");
                                                        } else {
                                                            setTimeout(function () {
                                                                $('#conversationLineData').append(data);
                                                                $('#load_lineData_message').html("");
                                                            }, 2000);
                                                        }

                                                        action = "inactive";
                                                    }
                                                });
                                            }

                                            $(document).ready(function () {
                                                $('#conversationData').scroll(function () {
                                                    if ($('#conversationData').scrollTop() + $(window).height() > $("#conversationData").height() && action == 'inactive') {
                                                        action = 'active';
                                                        start = start + limit;
                                                        setTimeout(function () {
                                                            load_chart_data(limit, start);
                                                        }, 1000);
                                                    }
                                                });
                                                $('#conversationLineData').scroll(function () {
                                                    if ($('#conversationLineData').scrollTop() + $(window).height() > $("#conversationLineData").height() && action == 'inactive') {
                                                        action = 'active';
                                                        start = start + limit;
                                                        setTimeout(function () {
                                                            load_lineChart_data(limit, start);
                                                        }, 1000);
                                                    }
                                                });
                                            });

                                            $('#commentSubmit').validate({
                                                rules: {
                                                    txt_description: "required"
                                                },
                                                messages: {
                                                    txt_description: "Please enter description"
                                                }
                                            });

                                            $('#commentLineSubmit').validate({
                                                rules: {
                                                    txt_description: "required"
                                                },
                                                messages: {
                                                    txt_description: "Please enter description"
                                                }
                                            });

                                            $("#commentSubmit").submit(function (e) {
                                                if ($('#commentSubmit').valid()) {
                                                    e.preventDefault();
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url() . 'index.php/portfolio/addChartConversation'; ?>",
                                                        data: $('#commentSubmit').serialize(),
                                                        success: function (output) {
                                                            $("#commentSubmit")[0].reset();
                                                            $('#commentMsg').html('Comment posted successfully');
                                                            $("#conversationData").html(output);
                                                            setTimeout(function () {
                                                                $('#commentMsg').html('');
                                                            }, 3000);
                                                        }
                                                    });
                                                }
                                            });

                                            $("#commentLineSubmit").submit(function (e) {
                                                if ($('#commentLineSubmit').valid()) {
                                                    e.preventDefault();
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: "<?php echo base_url() . 'index.php/portfolio/addChartConversation'; ?>",
                                                        data: $('#commentLineSubmit').serialize(),
                                                        success: function (output) {
                                                            $("#commentLineSubmit")[0].reset();
                                                            $('#commentLineMsg').html('Comment posted successfully');
                                                            $("#conversationLineData").html(output);
                                                            setTimeout(function () {
                                                                $('#commentLineMsg').html('');
                                                            }, 3000);
                                                        }
                                                    });
                                                }
                                            });

                                            function home_revenue() {
                                                $.ajax({
                                                    type: "POST",
                                                    async: true,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allRevenue",
                                                    data: {id: 1},
                                                    dataType: 'html',
                                                    success: function (revenue_msg) {
                                                        $("#all_revenue").html(revenue_msg);
                                                        home_capital();
                                                    }
                                                });
                                            }

                                            function home_profit() {
                                                $.ajax({
                                                    type: "POST",
                                                    async: true,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allProfit",
                                                    data: {id: 1},
                                                    dataType: 'html',
                                                    success: function (profit_msg) {
                                                        $("#all_profit").html(profit_msg);
                                                        $('#loaderGif').css('display', 'none');
                                                    }
                                                });
                                            }

                                            function home_capital() {
                                                $.ajax({
                                                    type: "POST",
                                                    async: true,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allCapital",
                                                    data: {id: 1},
                                                    dataType: 'html',
                                                    success: function (capital_msg) {
                                                        $("#all_capital").html(capital_msg);
                                                        home_seedfund();
                                                    }
                                                });
                                            }

                                            function home_seedfund() {
                                                $.ajax({
                                                    type: "POST",
                                                    async: true,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allSeedFund",
                                                    data: {id: 1},
                                                    dataType: 'html',
                                                    success: function (seedfund_msg) {
                                                        $("#all_seedfund").html(seedfund_msg);
                                                        home_profit();
                                                    }
                                                });
                                            }

                                            function datepickerEachFunction() {
                                                $(".startDat").datepicker({
                                                    onSelect: function (selected) {
                                                        $(".startDat").datepicker("option", "dateFormat", 'mm/dd/yy');
                                                        $(".endDat").val('');
                                                        var dt = new Date(selected);
                                                        var dateval = dt.getDate();
                                                        var monthval = dt.getMonth() + 1;
                                                        var yearval = dt.getFullYear();
                                                        if (monthval < 10) {
                                                            monthval = "0" + monthval;
                                                        } else {
                                                            monthval = monthval;
                                                        }
                                                        if (dateval < 10) {
                                                            dateval = "0" + dateval;
                                                        } else {
                                                            dateval = dateval;
                                                        }
                                                        var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
                                                        $(".startDat").val(fulldatevalue);
                                                        dt.setDate(dt.getDate() + 1);
                                                        $(".endDat").datepicker("option", {minDate: dt});
                                                    }
                                                });

                                                $(".endDat").datepicker({
                                                    onSelect: function (selected) {
                                                        var dt = new Date(selected);
                                                        var dateval = dt.getDate();
                                                        var monthval = dt.getMonth() + 1;
                                                        var yearval = dt.getFullYear();
                                                        if (monthval < 10) {
                                                            monthval = "0" + monthval;
                                                        } else {
                                                            monthval = monthval;
                                                        }
                                                        if (dateval < 10) {
                                                            dateval = "0" + dateval;
                                                        } else {
                                                            dateval = dateval;
                                                        }
                                                        var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
                                                        $(".endDat").val(fulldatevalue);
                                                        dt.setDate(dt.getDate() - 1);
                                                    }
                                                });
                                            }

                                            function loadTotalCompanies() {
                                                selectType(1);
                                                lineDatepicker();
                                                $('#nxt_chart').show();
                                                $('#pre_chart').hide();
                                                $('#nxt_chart').attr('onClick', 'loadNewCompanies()');
                                                $('#nxt_chart').attr('title', 'New Incubatees');
                                                var sector_id = $('#filter_sector').val();
                                                $('#module_id').val('10');
//                                                loadConversation();
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/totalCompanies",
                                                    data: {id: 2, sector_id: sector_id},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#chartTitle').html('Total Incubatees');
                                                        $('#chartdiv').modal('show');
                                                        $("#chartContent").html(msg);
                                                        $("#functionName").val('totalCompanies');
                                                        $('#sectorName').val(sector_id);
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#chart_searchBtn').click();
                                            }

                                            function loadNewCompanies() {
                                                selectType(1);
                                                lineDatepicker();
                                                $('#pre_chart, #nxt_chart').show();
                                                $('#pre_chart').attr('onClick', 'loadTotalCompanies()');
                                                $('#nxt_chart').attr('onClick', 'loadExitCompanies()');
                                                $('#pre_chart').attr('title', 'Total Incubatees');
                                                $('#nxt_chart').attr('title', 'Exit Incubatees');
                                                var sector_id = $('#filter_sector').val();
                                                $('#module_id').val('11');
//                                                loadConversation();
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/newCompanies",
                                                    data: {id: 2, sector_id: sector_id},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#chartTitle').html('New Incubatees');
                                                        $('#chartdiv').modal('show');
                                                        $("#chartContent").html(msg);
                                                        $("#functionName").val('newCompanies');
                                                        $('#sectorName').val(sector_id);
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#chart_searchBtn').click();
                                            }

                                            function loadExitCompanies() {
                                                selectType(1);
                                                lineDatepicker();
                                                $('#pre_chart, #nxt_chart').show();
                                                $('#pre_chart').attr('onClick', 'loadNewCompanies()');
                                                $('#nxt_chart').attr('onClick', 'loadAllRevenue()');
                                                $('#pre_chart').attr('title', 'New Incubatees');
                                                $('#nxt_chart').attr('title', 'Revenue');
                                                $('#linechartdiv').modal('hide');
                                                var sector_id = $('#filter_sector').val();
                                                $('#module_id').val('12');
//                                                loadConversation();
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/exitCompanies",
                                                    data: {id: 2, sector_id: sector_id},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#chartTitle').html('Graduates & Exist Incubatees');
                                                        $('#chartdiv').modal('show');
                                                        $("#chartContent").html(msg);
                                                        $("#functionName").val('exitCompanies');
                                                        $('#sectorName').val(sector_id);
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#chart_searchBtn').click();
                                            }

                                            function loadAllRevenue() {
                                                selectLineType(1);
                                                lineDatepicker();
                                                $('#lineModule_id').val('2');
//                                                loadLineConversation();
                                                var lead = $('#find_secLead').val();
                                                if (lead == 1) {
                                                    $('#line_pre_chart').show();
                                                    $('#line_pre_chart').attr('onClick', 'loadExitCompanies()');
                                                    $('#line_pre_chart').attr('title', 'Exit Incubatees');
                                                } else {
                                                    $('#line_pre_chart').hide();
                                                }
                                                $('#line_nxt_chart').show();
                                                $('#line_nxt_chart').attr('onClick', 'loadAllProfit()');
                                                $('#line_nxt_chart').attr('title', 'Profit');
                                                $('#chartdiv').modal('hide');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allRevenue",
                                                    data: {id: 2},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#lineChartTitle').html('All Incubatees - Revenue');
                                                        $('#linechartdiv').modal('show');
                                                        $("#lineChartContent").html(msg);
                                                        $("#lineName").val('allRevenue');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#line_searchBtn').click();
                                            }

                                            function loadAllProfit() {
                                                selectLineType(1);
                                                lineDatepicker();
                                                $('#lineModule_id').val('3');
//                                                loadLineConversation();
                                                $('#line_pre_chart, #line_nxt_chart').show();
                                                $('#line_pre_chart').attr('onClick', 'loadAllRevenue()');
                                                $('#line_nxt_chart').attr('onClick', 'loadAllCapital()');
                                                $('#line_pre_chart').attr('title', 'Revenue');
                                                $('#line_nxt_chart').attr('title', 'Fundraise');
                                                $('#newChartdiv').modal('hide');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allProfit",
                                                    data: {id: 2},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#lineChartTitle').html('All Incubatees - Profit');
                                                        $('#linechartdiv').modal('show');
                                                        $("#lineChartContent").html(msg);
                                                        $("#lineName").val('allProfit');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#line_searchBtn').click();
                                            }

                                            function loadAllCapital() {
                                                selectNewType(1);
                                                lineDatepicker();
                                                $('#module_id').val('5');
                                                $('#new_pre_chart, #new_nxt_chart').show();
                                                $('#new_pre_chart').attr('onClick', 'loadAllProfit()');
                                                $('#new_nxt_chart').attr('onClick', 'loadAllSeedfund()');
                                                $('#new_pre_chart').attr('title', 'Profit');
                                                $('#new_nxt_chart').attr('title', 'Seed Funding');
                                                $('#linechartdiv').modal('hide');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allCapital",
                                                    data: {id: 2},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#newChartTitle').html('All Incubatees - Capital');
                                                        $('#newChartdiv').modal('show');
                                                        $("#newChartContent").html(msg);
                                                        $("#newName").val('allCapital');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#new_searchBtn').click();
                                            }

                                            function loadAllSeedfund() {
                                                selectNewType(1);
                                                lineDatepicker();
                                                $('#module_id').val('4');
                                                $('#new_pre_chart, #new_nxt_chart').show();
                                                $('#new_pre_chart').attr('onClick', 'loadAllCapital()');
                                                $('#new_nxt_chart').attr('onClick', 'loadMentorNumber()');
                                                $('#new_pre_chart').attr('title', 'Fundraise');
                                                $('#new_nxt_chart').attr('title', 'Mentor Numbers');
                                                $('#chartdiv').modal('hide');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allSeedFund",
                                                    data: {id: 2},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#newChartTitle').html('All Incubatees - Seed Funding');
                                                        $('#newChartdiv').modal('show');
                                                        $("#newChartContent").html(msg);
                                                        $("#newName").val('allSeedFund');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#new_searchBtn').click();
                                            }

                                            function loadMentorNumber() {
                                                selectType(1);
                                                lineDatepicker();
                                                $('#module_id').val('6');
//                                                loadConversation();
                                                $('#pre_chart, #nxt_chart').show();
                                                $('#pre_chart').attr('onClick', 'loadAllSeedfund()');
                                                $('#nxt_chart').attr('onClick', 'loadMentorHour()');
                                                $('#pre_chart').attr('title', 'Seed Funding');
                                                $('#nxt_chart').attr('title', 'Mentor Hours');
                                                $('#newChartdiv').modal('hide');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/mentorNumber",
                                                    data: {id: 2},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#chartTitle').html('All Incubatees - Mentor Numbers');
                                                        $('#chartdiv').modal('show');
                                                        $("#chartContent").html(msg);
                                                        $("#functionName").val('mentorNumber');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#chart_searchBtn').click();
                                            }

                                            function loadMentorHour() {
                                                selectType(1);
                                                lineDatepicker();
                                                $('#module_id').val('7');
//                                                loadConversation();
                                                $('#pre_chart, #nxt_chart').show();
                                                $('#pre_chart').attr('onClick', 'loadMentorNumber()');
                                                $('#nxt_chart').attr('onClick', 'loadTap()');
                                                $('#pre_chart').attr('title', 'Mentor Numbers');
                                                $('#nxt_chart').attr('title', 'TAP Assignments');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/mentorHour",
                                                    data: {id: 2},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#chartTitle').html('All Incubatees - Mentor Hours');
                                                        $('#chartdiv').modal('show');
                                                        $("#chartContent").html(msg);
                                                        $("#functionName").val('mentorHour');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#chart_searchBtn').click();
                                            }

                                            function loadDPMeeting() {
                                                selectType(1);
                                                lineDatepicker();
                                                $('#module_id').val('9');
//                                                loadConversation();
                                                $('#pre_chart').show();
                                                $('#pre_chart').attr('onClick', 'loadTap()');
                                                $('#pre_chart').attr('title', 'TAP Assignments');
                                                $('#nxt_chart').hide();
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/dpMeeting",
                                                    data: {id: 2},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#chartTitle').html('All Incubatees - DP Meetings');
                                                        $('#chartdiv').modal('show');
                                                        $("#chartContent").html(msg);
                                                        $("#functionName").val('dpMeeting');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#chart_searchBtn').click();
                                            }

                                            function loadTap() {
                                                selectType(1);
                                                lineDatepicker();
                                                $('#module_id').val('8');
//                                                loadConversation();
                                                $('#pre_chart, #nxt_chart').show();
                                                $('#pre_chart').attr('onClick', 'loadMentorHour()');
                                                $('#pre_chart').attr('title', 'Mentor Hours');
                                                $('#nxt_chart').attr('onClick', 'loadDPMeeting()');
                                                $('#nxt_chart').attr('title', 'DP Meetings');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/Tap",
                                                    data: {id: 2},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#chartTitle').html('All Incubatees - TAP Assignments');
                                                        $('#chartdiv').modal('show');
                                                        $("#chartContent").html(msg);
                                                        $("#functionName").val('Tap');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#chart_searchBtn').click();
                                            }

                                            $('#chartFilter').validate({
                                                rules: {
                                                    startDate: "required"
                                                },
                                                messages: {
                                                    startDate: "Please select date"
                                                }
                                            });

                                            function selectType(id) {
                                                if (id == 2) {
                                                    $('#viewType').val('2');
                                                    $('#startDate').val('');
                                                    $('#endDate').val('');
                                                    $('#monthRange').hide();
                                                } else if (id == 1) {
                                                    $('#viewType').val('1');
                                                    $('#monthRange').show();
                                                    lineDatepicker();
                                                } else {
                                                    $('#viewType').val('');
                                                    $('#monthRange').hide();
                                                }
                                                $('#chart_searchBtn').click();
                                            }

                                            function selectLineType(id) {
                                                if (id == 2) {
                                                    $('#lineViewType').val('2');
                                                    $('#quarterView').show();
                                                    $('#monthView').hide();
                                                } else if (id == 1) {
                                                    $('#lineViewType').val('1');
                                                    $('#monthView').show();
                                                    $('#quarterView').hide();
                                                } else {
                                                    $('#lineViewType').val('');
                                                    $('#fromQuarterName').val('1');
                                                    $('#toQuarterName').val('4');
                                                    $('#quarterView').hide();
                                                    $('#monthView').hide();
                                                }
                                                $('#line_searchBtn').click();
                                            }

                                            function selectNewType(id) {
                                                if (id == 2) {
                                                    $('#newViewType').val('2');
                                                    $('#quarterNewView').show();
                                                    $('#monthNewView').hide();
                                                } else if (id == 1) {
                                                    $('#newViewType').val('1');
                                                    $('#monthNewView').show();
                                                    $('#quarterNewView').hide();
                                                } else {
                                                    $('#newViewType').val('');
                                                    $('#fromNewQuarterName').val('1');
                                                    $('#toNewQuarterName').val('4');
                                                    $('#quarterNewView').hide();
                                                    $('#monthNewView').hide();
                                                }
                                                $('#new_searchBtn').click();
                                            }

                                            function totalCompanyFilter() {
                                                var loadFilter = $("#functionName").val();
                                                var type = $('#viewType').val();
                                                if ($('#chartFilter').valid()) {
                                                    var quarter = $('#quarterName').val();
                                                    var start_date = $('#startDate').val();
                                                    var end_date = $('#endDate').val();
                                                    var sector_id = $('#sectorName').val();
                                                    $.ajax({
                                                        type: "POST",
                                                        async: false,
                                                        url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/" + loadFilter,
                                                        data: {id: 3, type: type, quarter: quarter, start_date: start_date, end_date: end_date, sector_id: sector_id},
                                                        dataType: 'html',
                                                        success: function (msg) {
                                                            $("#chartContent").html(msg);
                                                        }
                                                    });
                                                }
                                            }

                                            function totalLineFilter() {
                                                var loadFilter = $("#lineName").val();
                                                var type = $('#lineViewType').val();
                                                var f_quarter = $('#fromQuarterName').val();
                                                var t_quarter = $('#toQuarterName').val();
                                                var f_year = $('#fromYear').val();
                                                var t_year = $('#toYear').val();
                                                var start_date = $('#lineStartDate').val();
                                                var end_date = $('#lineEndDate').val();

                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/" + loadFilter,
                                                    data: {id: 3, type: type, f_quarter: f_quarter, t_quarter: t_quarter, f_year: f_year, t_year: t_year, start_date: start_date, end_date: end_date},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $("#lineChartContent").html(msg);
                                                    }
                                                });
                                            }

                                            function totalNewFilter() {
                                                var loadFilter = $("#newName").val();
                                                var type = $('#newViewType').val();
                                                var f_quarter = $('#fromNewQuarterName').val();
                                                var t_quarter = $('#toNewQuarterName').val();
                                                var f_year = $('#fromNewYear').val();
                                                var t_year = $('#toNewYear').val();
                                                var start_date = $('#newStartDate').val();
                                                var end_date = $('#newEndDate').val();

                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/" + loadFilter,
                                                    data: {id: 3, type: type, f_quarter: f_quarter, t_quarter: t_quarter, f_year: f_year, t_year: t_year, start_date: start_date, end_date: end_date},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $("#newChartContent").html(msg);
                                                    }
                                                });
                                            }

                                            function lineDatepicker() {
                                                var cur_year = $('#current_fy').val();
                                                var close_year = Number(cur_year) + Number(1);
                                                $('#startDate, #lineStartDate, #newStartDate').val('Apr, ' + cur_year);
                                                $('#endDate, #lineEndDate, #newEndDate').val('Mar, ' + close_year);
                                                $('#startDate, #lineStartDate, #newStartDate').datepicker({
                                                    changeMonth: true,
                                                    changeYear: true,
                                                    showButtonPanel: true,
                                                    dateFormat: 'M, yy',
                                                    defaultDate: new Date(cur_year, 03, 01),
                                                    beforeShow: function (dateText, inst) {
                                                        $(document).off('focusin.bs.modal');
                                                        $(this).datepicker('setDate', new Date(cur_year, 03, 1));
                                                    },
                                                    onClose: function (dateText, inst) {
                                                        $(document).on('focusin.bs.modal');
                                                        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                                                    }
                                                });
                                                $('#endDate, #lineEndDate, #newEndDate').datepicker({
                                                    changeMonth: true,
                                                    changeYear: true,
                                                    showButtonPanel: true,
                                                    dateFormat: 'M, yy',
                                                    defaultDate: new Date(close_year, 02, 31),
                                                    beforeShow: function (dateText, inst) {
                                                        $(document).off('focusin.bs.modal');
                                                        $(this).datepicker('setDate', new Date(close_year, 02, 31));
                                                    },
                                                    onClose: function (dateText, inst) {
                                                        $(document).on('focusin.bs.modal');
                                                        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                                                    }
                                                });
                                            }

                                            $(document).on('click', '#startDate, #lineStartDate, #newStartDate', function () {
                                                $('.ui-datepicker').css("position", "absolute");
                                                $('.ui-datepicker-calendar').css("display", "none");
                                            });

                                            $(document).on('click', '#endDate, #lineEndDate, #newEndDate', function () {
                                                $('.ui-datepicker').css("position", "absolute");
                                                $('.ui-datepicker-calendar').css("display", "none");
                                            });

                                            function filter_sector() {
                                                var sector_id = $('#filter_sector').val();

                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/newCompanies",
                                                    data: {id: 1, sector_id: sector_id},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $("#new_companies").html(msg);
                                                    }
                                                });

                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/exitCompanies",
                                                    data: {id: 1, sector_id: sector_id},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $("#exist_companies").html(msg);
                                                    }
                                                });

                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/totalCompanies",
                                                    data: {id: 1, sector_id: sector_id},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $("#total_companies").html(msg);
                                                        home_revenue();
                                                    }
                                                });

                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/sectorname",
                                                    data: {sector_id: sector_id},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#selected_sector').html(msg);
                                                        $('#sel_sector').val(sector_id);
                                                    }
                                                });
                                            }

                                            function change_sector(id) {
                                                $('#filter_sector').val(id);
                                                $('#chart_filter_id').val(id);
                                                $('#lineChart_filter_id').val(id);
                                                filter_sector();
                                            }

                                            function change_comp_sector(id) {
                                                $('#filter_comp_sector').val(id);
                                                filter_comp_sector();
                                            }

                                            function filter_comp_sector() {
                                                var sector_id = $('#filter_comp_sector').val();
                                                var fin_year = $('#current_fy').val();
                                                $('#overlaysummary_id').addClass('overlay-summary');
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/change_company_sector",
                                                    data: {sector_id: sector_id, fin_year: fin_year},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/sectorname",
                                                            data: {sector_id: sector_id},
                                                            dataType: 'html',
                                                            success: function (msg) {
                                                                $('#company_sector').html(msg);
                                                                $('#comp_sector').val(sector_id);
                                                            }
                                                        });
                                                        var split_arr = JSON.parse(msg);
                                                        var application_arr = split_arr['applicationDetails'];
                                                        var pard_count_arr = split_arr['pard_allcount'];
                                                        var iic_count_arr = split_arr['IIC_allCount'];
                                                        var eic_count_arr = split_arr['EIC_allcount'];
                                                        var master_arr = split_arr['masterDetails'];
                                                        var total_arr = split_arr['total_inc'];
                                                        var new_arr = split_arr['new_inc'];
                                                        var exit_arr = split_arr['exit_inc'];
                                                        var application_count = parseInt(application_arr[0].inc_app) + parseInt(application_arr[0].eir_app) + parseInt(application_arr[0].seed_app) + parseInt(application_arr[0].pitch_app) + parseInt(application_arr[0].liveli_app);
                                                        var pard_count = parseInt(pard_count_arr[0].PARD_count);
                                                        var iic_count = parseInt(iic_count_arr[0].IIC_count);
                                                        var eic_count = parseInt(eic_count_arr[0].EIC_count);

                                                        var app_total = master_arr[0].application != null ? master_arr[0].application : '0';
                                                        var pard_total = master_arr[0].pa_rd != null ? master_arr[0].pa_rd : '0';
                                                        var iic_total = master_arr[0].iic_approve != null ? master_arr[0].iic_approve : '0';
                                                        var eic_total = master_arr[0].eic_approve != null ? master_arr[0].eic_approve : '0';
                                                        var inc_total = master_arr[0].tot_annual != null ? master_arr[0].tot_annual : '0';
                                                        var exit_total = master_arr[0].exit_annual != null ? master_arr[0].exit_annual : '0';
                                                        var grad_total = master_arr[0].graduate_annual != null ? master_arr[0].graduate_annual : '0';
                                                        var new_total = master_arr[0].new_annual != null ? master_arr[0].new_annual : '0';
                                                        var exit_graduate = parseInt(exit_total) + parseInt(grad_total);

                                                        $('#get_Capp').html(application_count + ' / ' + app_total);
                                                        $('#get_Cpard').html(pard_count + ' / ' + pard_total);
                                                        $('#get_Ciic').html(iic_count + ' / ' + iic_total);
                                                        $('#get_Ceic').html(eic_count + ' / ' + eic_total);
                                                        $('#get_Ctotal').html(total_arr[0].annual + ' / ' + inc_total);
                                                        $('#get_Cnew').html(new_arr[0].annual + ' / ' + new_total);
                                                        $('#get_Cexits').html(exit_arr + ' / ' + exit_graduate);
                                                        $('#overlaysummary_id').removeClass('overlay-summary');
                                                    }
                                                });
                                            }

        </script>

        <style type="text/css">
            label.error{width: 100% !important;text-align:right}
            /* #total_companies, #new_companies, #exist_companies {height: 410px !important; overflow: scroll;}
            #all_revenue, #all_profit, #all_capital, #all_seedfund {height: 410px !important; overflow: scroll;} */
            /*.highcharts-menu-item:last-child {display: none !important;}*/
            .highcharts-title{font-size: 14px !important;}
            .ui-datepicker-calendar{display:none !important;}
            #ui-datepicker-div{width:16% !important;}
            .loadChartBtn{padding: 0 0 5px;}
            .loadChartBtn a{color: #000 !important}
            #line_pre_chart, #line_nxt_chart, #pre_chart, #nxt_chart{margin: 5px;}

            .overlay-summary {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
            }
            .change_sectorSel{
                padding: 3px 5px;
                border-radius: 4px;
                border: 1px solid #ccc;
            }
            .positioRelative{
                position:relative;
            }
        </style>
    </body>
</html>
