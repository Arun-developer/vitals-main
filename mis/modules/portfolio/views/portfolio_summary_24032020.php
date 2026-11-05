<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Portfolio Summary</title>
        <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
        <style>
            .switch {
                position: relative;
                display: inline-block;
                width: 40px !important;
                height: 20px !important;
            }

            .switch input {
                opacity: 0 !important;
                width: 0 !important;
                height: 0 !important;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                -webkit-transition: .4s;
                transition: .4s;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 16px;
                width: 16px;
                left: 2px;
                bottom: 2px;
                background-color: white;
                -webkit-transition: .4s;
                transition: .4s;
            }

            input:checked + .slider {
                background-color: #2e8751 !important;
            }

            input:focus + .slider {
                box-shadow: 0 0 1px #2e8751;
            }

            input:checked + .slider:before {
                -webkit-transform: translateX(20px);
                -ms-transform: translateX(20px);
                transform: translateX(20px);
            }

            /* Rounded sliders */
            .slider.round {
                border-radius: 34px;
            }

            .slider.round:before {
                border-radius: 50%;
            }
            /* Tooltip container */
            .tooltip {
                position: relative;
                display: inline-block;
                border-bottom: 1px dotted black;
                /* If you want dots under the hoverable text */
            }

            /* Tooltip text */
            .tooltip .tooltiptext {
                visibility: hidden;
                width: 120px;
                background-color: #fff;
                color: #2e8751;
                text-align: center;
                padding: 5px 0;
                border-radius: 6px;
                border: 2px solid #2e8751;

                /* Position the tooltip text - see examples below! */
                position: absolute;
                z-index: 1;
            }

            /* Show the tooltip text when you mouse over the tooltip container */
            .tooltip:hover .tooltiptext {
                visibility: visible;
            }
        </style>
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
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                    <a class="dropdown-item" href="<?php echo base_url() . 'index.php/login/logout'; ?>"><i
                                            class="fas fa-sign-out-alt"></i> Sign out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="villgro-breadcrumb container-fluid">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <ul>
                            <li><a href="<?= base_url() . 'index.php/portfolio/dashboard'; ?>">Home</a></li> <i
                                class="fa fa-angle-double-right"></i>
                            <li><a class="active">Portfolio</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="vil-sub_menu deal-bread">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-8 col-md-8 col-sm-8 col-12">
                            <!-- <h4> Portfolio Summary</h4> -->
                            <ul class="milestone-links">
                                <li>
                                    <div class="form-group">
                                        <ul class="milestone-links">
                                            <li>
                                                <select name="txtSector" id="txtSector" class="form-control form-control-sm" onchange="load_sector(this.value)">
                                                    <option value="">All Sectors</option>
                                                    <?php
                                                    foreach ($sectors_values as $row) {
                                                        ?>
                                                        <option value="<?php echo $row['id']; ?>" <?php
                                                        if ($row['id'] == $default_sector) {
                                                            echo 'selected';
                                                        }
                                                        ?>><?php echo $row['sector']; ?></option>
                                                            <?php } ?>
                                                </select>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <ul class="milestone-links sectormenusnav">
                                            <li>
                                                <select class="form-control form-control-sm" name="financial_year" id="financial_year" onchange="load_year(this.value);">
                                                    <?php
                                                    if (php72_count($fin_year) > 0) {
                                                        foreach ($fin_year as $year) {
                                                            $nxt_fyear = $year['fin_year'] + 1;
                                                            ?>
                                                            <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_fy) && $current_fy == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <option value="<?= date('Y'); ?>" <?php if (isset($current_fy) && $current_fy == date('Y')) { ?> selected <?php } ?>><?= date('Y'); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </li>
                                            <li><select class="form-control form-control-sm" name="quarter_name" id="quarter_name" onchange="load_quarter(this.value);">
                                                    <option value="">-Select-</option>
                                                    <option value="1">Q1</option>
                                                    <option value="2">Q2</option>
                                                    <option value="3">Q3</option>
                                                    <option value="4">Q4</option>
                                                    <option value="5" selected="">Annual</option>
                                                </select>
                                            </li>
                                            <span id="show_secLink">
                                                <li>
                                                    <a id="load_sectorPlan" href="<?= base_url() . 'index.php/portfolio/sector_plan/discovery/' . $default_sector . '/' . $current_fy; ?>">Sector Plan</a>
                                                </li>
                                                <li>
                                                    <a id="load_sectorAchievement" href="<?= base_url() . 'index.php/portfolio/sector_actual/discovery/' . $default_sector . '/' . $current_fy; ?>">Sector Achievements</a>
                                                </li>
                                                <!--                                                <li>
                                                                                                    <a id="load_sectorAchiev" href="<?= base_url() . 'index.php/portfolio/sector_plan/discovery/' . $default_sector . '/' . $current_fy; ?>">Sector Achievements</a>
                                                                                                </li>-->
                                            </span>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="col-xl-4 col-md-4 col-sm-4 col-12 text-right">
                            <?php
                            $g_label = $this->session->userdata['graph_label'];
                            if ($g_label == 1) {
                                $swt_check = 'Checked';
                                $swt_title = 'Data labels - on';
                            } else {
                                $swt_check = '';
                                $swt_title = 'Data labels - off';
                            }
                            ?>
                            <div style="padding-top:10px">
                                Data Labels&nbsp;&nbsp;
                                <label class="switch">
                                    <input type="checkbox" name="graphLabel" id="graphLabel" <?= $swt_check; ?>>
                                    <span title="<?= $swt_title; ?>" class="slider round" id="labelSwitch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inner Dashboard-->
        <div style="position:relative">
            <div class="vi-dashboard-portfolio">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                            <div class="title-cart-vi">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <h4>Financial Performance</h4>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-12 text-right">
                                        <!--                                    <a href="">
                                                                                <i class="fas fa-external-link-alt"></i><br>
                                                                                <span>Export</span>
                                                                            </a>
                                                                            <a href="">
                                                                                <i class="fas fa-expand-arrows-alt"></i><br>
                                                                                <span>Maximize</span>
                                                                            </a>-->
                                    </div>
                                </div>
                            </div>
                            <div class="comapny-graph mar-bt0">
                                <div class="row">
                                    <div class="col-lg-4 brd-rgtChart">
                                        <div class="company_chartvi brd-none">
                                            <div class="vil-portfolio_chart">
                                                <a href="javascript:void(0)" onclick="loadAllSales();">
                                                    <div id="all_sales"></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 brd-rgtChart">
                                        <div class="company_chartvi brd-none">
                                            <div class="vil-portfolio_chart">
                                                <a href="javascript:void(0)" onclick="loadAllRevenue();">
                                                    <div id="all_revenue"></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col">
                            <div class="title-cart-vi">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <h4>Seed Funding</h4>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-12 text-right">
                                        <!--                                    <a href="">
                                                                                <i class="fas fa-external-link-alt"></i><br>
                                                                                <span>Export</span>
                                                                            </a>
                                                                            <a data-toggle="modal" data-target="#seedfund">
                                                                                <i class="fas fa-expand-arrows-alt"></i><br>
                                                                                <span>Maximize</span>
                                                                            </a>-->
                                    </div>
                                </div>
                            </div>
                            <div class="comapny-graph mar-bt0">
                                <div class="port_chartvi">
                                    <div class="vil-portfolio_chart">
                                        <a href="javascript:void(0)" onclick="loadAllSeedfund();">
                                            <div id="all_seedfund"></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col">
                            <div class="title-cart-vi">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <h4>Fundraise</h4>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-12 text-right">
                                        <!--                                    <a href="">
                                                                                <i class="fas fa-external-link-alt"></i><br>
                                                                                <span>Export</span>
                                                                            </a>
                                                                            <a href="">
                                                                                <i class="fas fa-expand-arrows-alt"></i><br>
                                                                                <span>Maximize</span>
                                                                            </a>-->
                                    </div>
                                </div>
                            </div>
                            <div class="comapny-graph mar-bt0">
                                <div class="port_chartvi">
                                    <div class="vil-portfolio_chart">
                                        <a href="javascript:void(0)" onclick="loadAllCapital();">
                                            <div id="all_capital"></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col">
                            <div class="title-cart-vi">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <h4>Mentoring and TAP</h4>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-12 text-right">
                                        <!--                                    <a href="">
                                                                                <i class="fas fa-external-link-alt"></i><br>
                                                                                <span>Export</span>
                                                                            </a>
                                                                            <a href="">
                                                                                <i class="fas fa-expand-arrows-alt"></i><br>
                                                                                <span>Maximize</span>
                                                                            </a>-->
                                    </div>
                                </div>
                            </div>
                            <div class="comapny-graph mar-bt0">
                                <div class="row">
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4 brd-right">
                                        <div class="port_chartvi">
                                            <div class="vil-portfolio_chart">
                                                <a href="javascript:void(0)" onclick="loadMentorNumber();">
                                                    <div id="mentor_number"></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4 brd-right">
                                        <div class="port_chartvi">
                                            <div class="vil-portfolio_chart">
                                                <a href="javascript:void(0)" onclick="loadMentorHour();">
                                                    <div id="mentor_hour"></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-4 col-md-4 col-lg-4">
                                        <div class="port_chartvi">
                                            <div class="vil-portfolio_chart">
                                                <a href="javascript:void(0)" onclick="loadTap();">
                                                    <div id="tap_chart"></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col">
                            <div class="title-cart-vi">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <h4>Diagnostic Panel</h4>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-12 text-right">
                                        <!--                                    <a href="">
                                                                                <i class="fas fa-external-link-alt"></i><br>
                                                                                <span>Export</span>
                                                                            </a>
                                                                            <a href="">
                                                                                <i class="fas fa-expand-arrows-alt"></i><br>
                                                                                <span>Maximize</span>
                                                                            </a>-->
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white">
                                <div class="row">
                                    <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                        <div class="port_chartvi">
                                            <div class="vil-portfolio_chart">
                                                <a href="javascript:void(0)" onclick="loadDPMeeting();">
                                                    <div id="dp_meeting"></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-6 col-md-6 col-lg-6">
                                        <div class="vil-milestone portfolio-table" style="height: 100%;border-left: 1px solid #c9e4d4">
                                            <div class="title-label-sub">Upcoming Board Meetings/Diagnostic Panels</div>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Incubatee</th>
                                                        <th>Type</th>
                                                        <th>Date</th>
                                                        <th>Details</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $s = 1;
                                                    foreach ($upcoming_milestone as $miles) {
                                                        if ($miles['type'] == 1) {
                                                            $type = 'Diagnostic Panel';
                                                        } else if ($miles['type'] == 2) {
                                                            $type = 'Board Meeting';
                                                        } else {
                                                            $type = '-';
                                                        }
                                                        $task_date = (isset($miles['due_by']) && $miles['due_by'] != '0000-00-00 00:00:00') ? date('d-M-Y', strtotime($miles['due_by'])) : '';
                                                        ?>
                                                        <tr>
                                                            <td><?= $s; ?></td>
                                                            <td><?= strlen($miles['company_name']) > 20 ? substr($miles['company_name'], 0, 20) . "..." : $miles['company_name']; ?></td>
                                                            <td><?= $type; ?></td>
                                                            <td><?= $task_date; ?></td>
                                                            <td><?= strlen($miles['task_name']) > 15 ? substr($miles['task_name'], 0, 15) . "..." : $miles['task_name']; ?></td>
                                                        </tr>
                                                        <?php
                                                        $s++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="portfolio-sidemenu"> -->
            <div class="sidebar-item">
                <aside class="portfolio-sidebar make-me-sticky">
                    <div class="portfolio-Incubatees">
                        <label>Incubatees (<span id="incubatee_count"><?= php72_count($company_list); ?></span>)</label>
                        <ul class="scroll-company">
                            <?php
                            $curr_user_inv = array();
                            $other_user_inv = array();
                            $exited_inv = array();
                            $i = 0;
                            foreach ($company_list as $company) {
                                if ($company['company_status'] == 3) {
                                    $exited_inv[$i]['id'] = $company['id'];
                                    $exited_inv[$i]['name_of_enterprise'] = $company['name_of_enterprise'];
                                    $exited_inv[$i]['company_status'] = $company['company_status'];
                                    $exited_inv[$i]['emp_id'] = $company['emp_id'];
                                } else {
                                    if (php72_in_array($company['id'], $assignlist)) {
                                        $curr_user_inv[$i]['id'] = $company['id'];
                                        $curr_user_inv[$i]['name_of_enterprise'] = $company['name_of_enterprise'];
                                        $curr_user_inv[$i]['company_status'] = $company['company_status'];
                                        $curr_user_inv[$i]['emp_id'] = $company['emp_id'];
                                    } else {
                                        $other_user_inv[$i]['id'] = $company['id'];
                                        $other_user_inv[$i]['name_of_enterprise'] = $company['name_of_enterprise'];
                                        $other_user_inv[$i]['company_status'] = $company['company_status'];
                                        $other_user_inv[$i]['emp_id'] = $company['emp_id'];
                                    }
                                }
                                $i++;
                            }
                            
                            $companies = array_merge($curr_user_inv, $other_user_inv);
                            $company_merge = array_merge($companies, $exited_inv);
                            foreach ($company_merge as $company) {
                                $exit_class = '';
                                if ($company['company_status'] == 3) {
                                    $exit_class = 'addedExit';
                                }
                                ?>
                                <li><a href="<?php echo base_url() . 'index.php/portfolio/company_summary/' . $company['id'] . '/' . $current_fy; ?>" class="<?php echo $exit_class; ?>" title="<?php echo $company['name_of_enterprise']; ?>"><?= strlen($company['name_of_enterprise']) > 30 ? substr($company['name_of_enterprise'], 0, 30) . "..." : $company['name_of_enterprise']; ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </aside>
            </div>
            <!-- </div> -->
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
                                <?php /*
                                  <div class="col-12 col-xl-4 col-md-4 col-lg-4">
                                  <div class="newChatPortfolio-model">
                                  <form id="commentSubmit" method="POST" autocomplete="off">
                                  <h3 class="wdt-100">Comments</h3>
                                  <div class="input-group">
                                  <input type="text" name="txt_description" class="form-control" placeholder="Enter your comments">
                                  <div class="input-group-append">
                                  <input type="submit" class="btn btn-secondary"value="Submit">
                                  </div>
                                  </div>
                                  <label for="txt_description" class="error"></label>
                                  <input type="hidden" name="chart_sector" id="chart_filter_id" value="<?= $default_sector; ?>">
                                  <input type="hidden" name="financial_year" id="chartFY" value="">
                                  <input type="hidden" name="module_id" id="module_id" value="">
                                  <input type="hidden" name="page_id" value="2">
                                  </form>
                                  <div class="clearfix"></div>
                                  <span class="text-success" id="commentMsg"></span>
                                  <div class="chatWindow-model" id="conversationData"></div>
                                  <div id="load_data_message"></div>
                                  </div>
                                  </div>
                                 */ ?>
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
                                            </a>
                                        </span>
                                        <span style="display: inline-block; width: 35px;">
                                            <a href="javascript:void(0)" id="line_nxt_chart" title="Previous">
                                                <i class="fas fa-chevron-circle-right"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <?php /*
                                  <div class="col-12 col-xl-4 col-md-4 col-lg-4">
                                  <div class="newChatPortfolio-model">
                                  <form id="commentLineSubmit" method="POST" autocomplete="off">
                                  <h3 class="wdt-100">Comments</h3>
                                  <div class="input-group">
                                  <input type="text" name="txt_description" class="form-control" placeholder="Enter your comments">
                                  <div class="input-group-append">
                                  <input type="submit" class="btn btn-secondary"value="Submit">
                                  </div>
                                  </div>
                                  <label for="txt_description" class="error"></label>
                                  <input type="hidden" name="chart_sector" id="lineChart_filter_id" value="<?= $default_sector; ?>">
                                  <input type="hidden" name="financial_year" id="lineChartFY" value="<?= $current_fy; ?>">
                                  <input type="hidden" name="module_id" id="lineModule_id" value="">
                                  <input type="hidden" name="page_id" value="2">
                                  </form>
                                  <div class="clearfix"></div>
                                  <span class="text-success" id="commentLineMsg"></span>
                                  <div class="chatWindow-model" id="conversationLineData"></div>
                                  <div id="load_lineData_message"></div>
                                  </div>
                                  </div>
                                 */ ?>
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

        <input type="hidden" id="current_fy" value="<?= isset($current_fy) && $current_fy != '' ? $current_fy : date('Y'); ?>">
        <input type="hidden" id="current_partner" value="<?= $this->session->userdata['partner_id']; ?>">
        <input type="hidden" id="filter_sector" value="<?= $default_sector; ?>">
        <input type="hidden" id="filter_sector_name" value="<?= $default_sector_name; ?>">
        <input type="hidden" id="filter_year" value="<?= $current_fy; ?>">
        <input type="hidden" id="filter_quarter" value="">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>

        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/series-label.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>

        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/additional-methods.js"></script>

        <script type="text/javascript">
                                            $('.scroll-company').css({'height': (($(window).height()) - 250) + 'px'});
                                            $(document).ready(function () {
                                                $('#show_secLink').hide();
                                                $('#loaderGif').css('display', 'block');
                                                $('#monthRange').hide();
                                                $('#quarterView').hide();
                                                $('#monthView').hide();
                                                var fin_year = $('#filter_year').val();

                                                var sector_plan_link = "<?= base_url() . 'index.php/portfolio/sector_plan/discovery/'; ?>";
                                                var sector_achieve_link = "<?= base_url() . 'index.php/portfolio/sector_actual/discovery/'; ?>";

                                                if (localStorage.getItem("port_sector") !== null) {
                                                    var previous_sector = localStorage.getItem('port_sector');
                                                    if (previous_sector != '') {
                                                        $('#show_secLink').show();
                                                        $('#load_sectorPlan').attr('href', sector_plan_link + previous_sector + '/' + fin_year);
                                                        $('#load_sectorAchievement').attr('href', sector_achieve_link + previous_sector + '/' + fin_year);
                                                    } else {
                                                        $('#show_secLink').hide();
                                                    }
                                                    load_sector(previous_sector);
                                                    $('#txtSector').val(previous_sector);
                                                } else {
                                                    var sector = $('#filter_sector').val();
                                                    if (sector != '') {
                                                        $('#show_secLink').show();
                                                        $('#load_sectorPlan').attr('href', sector_plan_link + sector + '/' + fin_year);
                                                        $('#load_sectorAchievement').attr('href', sector_achieve_link + previous_sector + '/' + fin_year);
                                                        load_sector(sector);
                                                        localStorage.setItem('port_sector', sector);
                                                    } else {
                                                        $('#show_secLink').hide();
                                                        home_MentorNumber();
                                                        localStorage.setItem('port_sector', '');
                                                    }
                                                }
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
                                                var fin_year = $('#filter_year').val();
                                                var module_id = $('#module_id').val();
                                                var sector_id = $('#filter_sector').val();
                                                var partner_id = $('#current_partner').val();
                                                var page_id = '2';
                                                $('#chartFY').val(fin_year);

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
                                                var fin_year = $('#filter_year').val();
                                                var module_id = $('#lineModule_id').val();
                                                var sector_id = $('#filter_sector').val();
                                                var partner_id = $('#current_partner').val();
                                                var page_id = '2';
                                                $('#lineChartFY').val(fin_year);

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

                                            function load_incubatees() {
                                                var sector = $('#filter_sector').val();
                                                var base_url = "<?php echo base_url(); ?>";
                                                var year = $('#filter_year').val();
                                                $.ajax({
                                                    type: "POST",
                                                    async: true,
                                                    url: base_url + "index.php/portfolio/portfolio_incubatees",
                                                    data: {sector: sector, year: year},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        var split_arr = JSON.parse(msg);
                                                        var application_arr = split_arr['incubatee_list'];
                                                        var inc_count = application_arr.length;
                                                        $('#incubatee_count').html(inc_count);
                                                        $(".scroll-company").html('');

                                                        $.each(application_arr, function (key, val) {
                                                            var exit_class = '';
                                                            var text = '';
                                                            if (val.company_status == '2') {
                                                                text = val.name_of_enterprise + ' (Graduated)';
                                                            } else if (val.company_status == '3') {
                                                                exit_class = 'addedExit';
                                                                text = val.name_of_enterprise + ' (Exited)';
                                                            } else {
                                                                text = val.name_of_enterprise;
                                                            }
                                                            var count = 30;
                                                            var result = text.slice(0, count) + (text.length > count ? "..." : "");

                                                            var inc_list = '<li><a href="' + base_url + 'index.php/portfolio/company_summary/' + val.id + '/' + year + '" class="' + exit_class + '" title="' + text + '">' + result + '</a></li>';
                                                            $(".portfolio-Incubatees ul").append(inc_list);
                                                        });
                                                    }
                                                });
                                            }

                                            function home_sales() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();

                                                $.ajax({
                                                    type: "POST",
                                                    async: true,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allSales",
                                                    data: {id: 1, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (sales_msg) {
                                                        $("#all_sales").html(sales_msg);
                                                        home_revenue();
                                                    }
                                                });
                                            }

                                            function home_revenue() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                $.ajax({
                                                    type: "POST",
                                                    async: true,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allRevenue",
                                                    data: {id: 1, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (revenue_msg) {
                                                        $("#all_revenue").html(revenue_msg);
                                                        home_capital();
                                                    }
                                                });
                                            }

                                            function home_profit() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                $.ajax({
                                                    type: "POST",
                                                    async: true,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allProfit",
                                                    data: {id: 1, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (profit_msg) {
                                                        $("#all_profit").html(profit_msg);
                                                        $('#loaderGif').css('display', 'none');
                                                    }
                                                });
                                            }

                                            function home_capital() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                $.ajax({
                                                    type: "POST",
                                                    async: true,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allCapital",
                                                    data: {id: 1, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (capital_msg) {
                                                        $("#all_capital").html(capital_msg);
                                                        home_seedfund();
                                                    }
                                                });
                                            }

                                            function home_seedfund() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                $.ajax({
                                                    type: "POST",
                                                    async: true,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allSeedFund",
                                                    data: {id: 1, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (seedfund_msg) {
                                                        $("#all_seedfund").html(seedfund_msg);
                                                        home_profit();
                                                    }
                                                });
                                            }

                                            function loadAllSales() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                var sector_name = $('#filter_sector_name').val();
                                                $('#lineModule_id').val('1');
                                                selectLineType(1);
                                                lineDatepicker();
//                                                        loadLineConversation();
                                                $('#line_pre_chart').hide();
                                                $('#line_nxt_chart').show();
                                                $('#line_nxt_chart').attr('onClick', 'loadAllRevenue()');
                                                $('#line_nxt_chart').attr('title', 'Revenue');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allSales",
                                                    data: {id: 2, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#lineChartTitle').html('All ' + sector_name + ' Incubatees - Sales');
                                                        $('#linechartdiv').modal('show');
                                                        $("#lineChartContent").html(msg);
                                                        $("#lineName").val('allSales');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#line_searchBtn').click();
                                            }

                                            function loadAllRevenue() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                var sector_name = $('#filter_sector_name').val();
                                                $('#lineModule_id').val('2');
                                                selectLineType(1);
                                                lineDatepicker();
//                                                        loadLineConversation();
                                                $('#line_pre_chart, #line_nxt_chart').show();
                                                $('#line_pre_chart').attr('onClick', 'loadAllSales()');
                                                $('#line_nxt_chart').attr('onClick', 'loadAllProfit()');
                                                $('#line_pre_chart').attr('title', 'Sales');
                                                $('#line_nxt_chart').attr('title', 'Profit');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allRevenue",
                                                    data: {id: 2, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#lineChartTitle').html('All ' + sector_name + ' Incubatees - Revenue');
                                                        $('#linechartdiv').modal('show');
                                                        $("#lineChartContent").html(msg);
                                                        $("#lineName").val('allRevenue');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#line_searchBtn').click();
                                            }

                                            function loadAllProfit() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                var sector_name = $('#filter_sector_name').val();
                                                $('#lineModule_id').val('3');
                                                selectLineType(1);
                                                lineDatepicker();
//                                                        loadLineConversation();
                                                $('#line_pre_chart, #line_nxt_chart').show();
                                                $('#line_pre_chart').attr('onClick', 'loadAllRevenue()');
                                                $('#line_nxt_chart').attr('onClick', 'loadAllSeedfund()');
                                                $('#line_pre_chart').attr('title', 'Revenue');
                                                $('#line_nxt_chart').attr('title', 'Seed Funding');
                                                $('#newChartdiv').modal('hide');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allProfit",
                                                    data: {id: 2, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#lineChartTitle').html('All ' + sector_name + ' Incubatees - Profit');
                                                        $('#linechartdiv').modal('show');
                                                        $("#lineChartContent").html(msg);
                                                        $("#lineName").val('allProfit');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#line_searchBtn').click();
                                            }

                                            function loadAllSeedfund() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                var sector_name = $('#filter_sector_name').val();
                                                $('#lineModule_id').val('4');
                                                selectNewType(1);
                                                lineDatepicker();
//                                                        loadLineConversation();
                                                $('#new_pre_chart, #new_nxt_chart').show();
                                                $('#new_pre_chart').attr('onClick', 'loadAllProfit()');
                                                $('#new_nxt_chart').attr('onClick', 'loadAllCapital()');
                                                $('#new_pre_chart').attr('title', 'Profit');
                                                $('#new_nxt_chart').attr('title', 'Fundraise');
                                                $('#linechartdiv').modal('hide');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allSeedFund",
                                                    data: {id: 2, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#newChartTitle').html('All ' + sector_name + ' Incubatees - Seed Funding');
                                                        $('#newChartdiv').modal('show');
                                                        $("#newChartContent").html(msg);
                                                        $("#newName").val('allSeedFund');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#new_searchBtn').click();
                                            }

                                            function loadAllCapital() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                var sector_name = $('#filter_sector_name').val();
                                                $('#lineModule_id').val('5');
                                                selectNewType(1);
                                                lineDatepicker();
//                                                        loadLineConversation();
                                                $('#new_pre_chart, #new_nxt_chart').show();
                                                $('#new_pre_chart').attr('onClick', 'loadAllSeedfund()');
                                                $('#new_nxt_chart').attr('onClick', 'loadMentorNumber()');
                                                $('#v_pre_chart').attr('title', 'Seed Funding');
                                                $('#v_nxt_chart').attr('title', 'Mentor Numbers');
                                                $('#chartdiv').modal('hide');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allCapital",
                                                    data: {id: 2, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#newChartTitle').html('All ' + sector_name + ' Incubatees - Capital');
                                                        $('#newChartdiv').modal('show');
                                                        $("#newChartContent").html(msg);
                                                        $("#newName").val('allCapital');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#new_searchBtn').click();
                                            }

                                            function home_MentorNumber() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/mentorNumber",
                                                    data: {id: 1, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (MentorNumber_msg) {
                                                        $("#mentor_number").html(MentorNumber_msg);
                                                        home_MentorHour();
                                                        load_incubatees();
                                                    }
                                                });
                                            }

                                            function home_MentorHour() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/mentorHour",
                                                    data: {id: 1, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (MentorHour_msg) {
                                                        $("#mentor_hour").html(MentorHour_msg);
                                                        home_DPMeeting();
                                                    }
                                                });
                                            }

                                            function home_DPMeeting() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/dpMeeting",
                                                    data: {id: 1, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (meet_msg) {
                                                        $("#dp_meeting").html(meet_msg);
                                                        home_Tap();
                                                    }
                                                });
                                            }
                                            function home_Tap() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/Tap",
                                                    data: {id: 1, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (tap_msg) {
                                                        $("#tap_chart").html(tap_msg);
                                                        home_sales();
                                                    }
                                                });
                                            }

                                            function loadMentorNumber() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                var sector_name = $('#filter_sector_name').val();
                                                $('#module_id').val('6');
                                                selectType(1);
                                                lineDatepicker();
//                                                loadConversation();
                                                $('#pre_chart, #nxt_chart').show();
                                                $('#pre_chart').attr('onClick', 'loadAllCapital()');
                                                $('#nxt_chart').attr('onClick', 'loadMentorHour()');
                                                $('#pre_chart').attr('title', 'Fundraise');
                                                $('#nxt_chart').attr('title', 'Mentor Hours');
                                                $('#newChartdiv').modal('hide');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/mentorNumber",
                                                    data: {id: 2, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#chartTitle').html('All ' + sector_name + ' Incubatees - Mentor Numbers');
                                                        $('#chartdiv').modal('show');
                                                        $("#chartContent").html(msg);
                                                        $("#functionName").val('mentorNumber');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#chart_searchBtn').click();
                                            }

                                            function loadMentorHour() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                var sector_name = $('#filter_sector_name').val();
                                                $('#module_id').val('7');
                                                selectType(1);
                                                lineDatepicker();
//                                                        loadConversation();
                                                $('#pre_chart, #nxt_chart').show();
                                                $('#pre_chart').attr('onClick', 'loadMentorNumber()');
                                                $('#nxt_chart').attr('onClick', 'loadTap()');
                                                $('#pre_chart').attr('title', 'Mentor Numbers');
                                                $('#nxt_chart').attr('title', 'TAP Assignments');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/mentorHour",
                                                    data: {id: 2, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#chartTitle').html('All ' + sector_name + ' Incubatees - Mentor Hours');
                                                        $('#chartdiv').modal('show');
                                                        $("#chartContent").html(msg);
                                                        $("#functionName").val('mentorHour');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#chart_searchBtn').click();
                                            }

                                            function loadDPMeeting() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                var sector_name = $('#filter_sector_name').val();
                                                $('#module_id').val('9');
                                                selectType(1);
                                                lineDatepicker();
//                                                        loadConversation();
                                                $('#pre_chart').show();
                                                $('#pre_chart').attr('onClick', 'loadTap()');
                                                $('#pre_chart').attr('title', 'TAP Assignments');
                                                $('#nxt_chart').hide();
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/dpMeeting",
                                                    data: {id: 2, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#chartTitle').html('All ' + sector_name + ' Incubatees - DP Meetings');
                                                        $('#chartdiv').modal('show');
                                                        $("#chartContent").html(msg);
                                                        $("#functionName").val('dpMeeting');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#chart_searchBtn').click();
                                            }

                                            function loadTap() {
                                                var sector = $('#filter_sector').val();
                                                var year = $('#filter_year').val();
                                                var quarter = $('#filter_quarter').val();
                                                var sector_name = $('#filter_sector_name').val();
                                                $('#module_id').val('8');
                                                selectType(1);
                                                lineDatepicker();
//                                                        loadConversation();
                                                $('#pre_chart, #nxt_chart').show();
                                                $('#pre_chart').attr('onClick', 'loadMentorHour()');
                                                $('#pre_chart').attr('title', 'Mentor Hours');
                                                $('#nxt_chart').attr('onClick', 'loadDPMeeting()');
                                                $('#nxt_chart').attr('title', 'DP Meetings');
                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/Tap",
                                                    data: {id: 2, sector: sector, year: year, quarter: quarter},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $('#chartTitle').html('All ' + sector_name + ' Incubatees - TAP Assignments');
                                                        $('#chartdiv').modal('show');
                                                        $("#chartContent").html(msg);
                                                        $("#functionName").val('Tap');
                                                        lineDatepicker();
                                                    }
                                                });
                                                $('#chart_searchBtn').click();
                                            }

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
                                                var cur_year = $('#filter_year').val();
                                                if (id == 2) {
                                                    $('#lineViewType').val('2');
                                                    $('#quarterView').show();
                                                    $('#monthView').hide();
                                                    $('#fromQuarterName').val("1");
                                                    $('#fromYear').val(cur_year);
                                                    $('#toQuarterName').val("4");
                                                    $('#toYear').val(cur_year);
                                                } else if (id == 1) {
                                                    $('#lineViewType').val('1');
                                                    $('#monthView').show();
                                                    $('#quarterView').hide();
                                                } else {
                                                    $('#lineViewType').val('');
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

                                            function lineDatepicker() {
                                                var cur_year = $('#filter_year').val();
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

                                            $('#chartFilter').validate({
                                                rules: {
                                                    startDate: "required"
                                                },
                                                messages: {
                                                    startDate: "Please select date"
                                                }
                                            });

                                            function totalCompanyFilter() {
                                                var loadFilter = $("#functionName").val();
                                                var type = $('#viewType').val();
                                                var sector = $('#filter_sector').val();
                                                var filquater = $('#filter_quarter').val();
                                                if ($('#chartFilter').valid()) {
                                                    var quarter = $('#quarterName').val();
                                                    var start_date = $('#startDate').val();
                                                    var end_date = $('#endDate').val();
                                                    $.ajax({
                                                        type: "POST",
                                                        async: false,
                                                        url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/" + loadFilter,
                                                        data: {id: 3, sector: sector, type: type, filquater: filquater, quarter: quarter, start_date: start_date, end_date: end_date},
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
                                                var sector = $('#filter_sector').val();
                                                var filquater = $('#filter_quarter').val();

                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/" + loadFilter,
                                                    data: {id: 3, sector: sector, type: type, filquater: filquater, f_quarter: f_quarter, t_quarter: t_quarter, f_year: f_year, t_year: t_year, start_date: start_date, end_date: end_date},
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
                                                var sector = $('#filter_sector').val();
                                                var filquater = $('#filter_quarter').val();

                                                $.ajax({
                                                    type: "POST",
                                                    async: false,
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/" + loadFilter,
                                                    data: {id: 3, sector: sector, type: type, filquater: filquater, f_quarter: f_quarter, t_quarter: t_quarter, f_year: f_year, t_year: t_year, start_date: start_date, end_date: end_date},
                                                    dataType: 'html',
                                                    success: function (msg) {
                                                        $("#newChartContent").html(msg);
                                                    }
                                                });
                                            }

                                            function load_sector(id) {
                                                $('#filter_sector').val(id);
                                                $('#chart_filter_id').val(id);
                                                $('#lineChart_filter_id').val(id);
                                                var fin_year = $('#filter_year').val();
                                                localStorage.setItem('port_sector', id);

                                                if (id != '') {
                                                    var sector_plan_link = "<?= base_url() . 'index.php/portfolio/sector_plan/discovery/'; ?>";
                                                    var sector_achieve_link = "<?= base_url() . 'index.php/portfolio/sector_actual/discovery/'; ?>";
                                                    $('#show_secLink').show();
                                                    $('#load_sectorPlan').attr('href', sector_plan_link + id + '/' + fin_year);
                                                    $('#load_sectorAchievement').attr('href', sector_achieve_link + id + '/' + fin_year);
                                                } else {
                                                    $('#show_secLink').hide();
                                                }

                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo base_url(); ?>index.php/portfolio/summary_sectorName",
                                                    data: {sec_id: id},
                                                    dataType: "text",
                                                    success: function (msg) {
                                                        if (msg == '')
                                                            $('#filter_sector_name').val('');
                                                        else
                                                            $('#filter_sector_name').val(msg);
                                                    }
                                                });

                                                home_MentorNumber();
                                            }

                                            function load_year(id) {
//                                                $('#filter_year').val(id);
//                                                var sector_id = $('#filter_sector').val();
//
//                                                var sector_plan_link = "<?= base_url() . 'index.php/portfolio/sector_plan/discovery/'; ?>";
//                                                $('#load_sectorPlan').attr('href', sector_plan_link + sector_id + '/' + id);
//                                                home_MentorNumber();
                                                window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/portfolio_summary/' + id;
                                            }

                                            function load_quarter(id) {
                                                $('#filter_quarter').val(id);
                                                home_MentorNumber();
                                            }

                                            $(document).on('click', '#startDate, #lineStartDate, #newStartDate', function () {
                                                $('.ui-datepicker').css("position", "absolute");
                                                $('.ui-datepicker-calendar').css("display", "none");
//                                                var get_date = this.value;
//                                                var split_date = get_date.split(", ");
//                                                var get_month = getMonth(split_date[0]);
//                                                var set_month = get_month - 1;
//                                                $('.ui-datepicker-month').val(set_month);
//                                                $('.ui-datepicker-year').val(split_date[1]);
//                                                lineDatepicker();
                                            });

                                            $(document).on('click', '#endDate, #lineEndDate, #newEndDate', function () {
                                                $('.ui-datepicker').css("position", "absolute");
                                                $('.ui-datepicker-calendar').css("display", "none");
                                            });

                                            function getMonth(monthStr) {
                                                return new Date(monthStr + '-1-01').getMonth() + 1
                                            }

                                            $(document).on('click', '#graphLabel', function () {
                                                if ($(this).is(":checked")) {
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url(); ?>index.php/portfolio/updateGraphLabel",
                                                        data: {enable: 1},
                                                        dataType: 'html',
                                                        success: function (msg) {
                                                            location.reload();
                                                        }
                                                    });
                                                } else if ($(this).is(":not(:checked)")) {
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url(); ?>index.php/portfolio/updateGraphLabel",
                                                        data: {enable: 0},
                                                        dataType: 'html',
                                                        success: function (msg) {
                                                            location.reload();
                                                        }
                                                    });
                                                }
                                            });

        </script>

        <style type="text/css">
            label.error{width: 100% !important;text-align:right}
            /* #all_sales, #mentor_number, #mentor_hour, #dp_meeting {height: 410px !important; overflow: scroll;}
            #all_revenue, #all_profit, #all_capital, #all_seedfund {height: 410px !important; overflow: scroll;} */
            /*.highcharts-menu-item:last-child {display: none !important;}*/
            .highcharts-title{font-size: 14px !important;}
            .ui-datepicker-calendar{display:none !important;}
            #ui-datepicker-div{width:16% !important;}
            .loadChartBtn{padding: 0 0 5px;}
            .loadChartBtn a{color: #000 !important}
            #line_pre_chart, #line_nxt_chart, #pre_chart, #nxt_chart{margin: 5px;}
        </style>



    </body>

</html>
