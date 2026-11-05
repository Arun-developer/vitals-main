<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Villgro MIS</title>
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
        <!-- Library css -->
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    </head>

    <body>
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
            <div class="villgro-breadcrumb container-fluid">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <ul>
                            <li><a href="<?= base_url() . 'index.php/portfolio/dashboard'; ?>">Home </a></li> <i
                                class="fa fa-angle-double-right"></i>
                            <li><a href="<?= base_url() . 'index.php/portfolio/mydeals'; ?>">Deals</a></li> <i
                                class="fa fa-angle-double-right"></i>
                            <li><a class="active">Dashboard Chart</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="v-menu">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <ul>
                                <li><a href="<?php echo base_url() . 'index.php/portfolio/mydeals'; ?>">Deals</a></li>
                                <li><a href="<?php echo base_url() . 'index.php/login/requests'; ?>">Requests</a></li>
                                <li><a href="<?php echo base_url() . 'index.php/login/approvals'; ?>">Approve</a></li>
                                <!-- <li><a href="<?php // echo base_url() . 'index.php/login/portfolio';                                                                                                                                   ?>">Portfolio</a></li> -->
                                <li><a href="<?php echo base_url() . 'index.php/portfolio/uiPortfolio_summary'; ?>">Portfolio</a></li>
                                <li><a href="<?php echo base_url() . 'index.php/login/resources'; ?>">Resources</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $userName = strstr($this->session->userdata['emp_name'] . ' ', ' ', true); ?>

        <!-- Inner Dashboard-->
        <div class="vi-newdashboard">
            <div class="container-fluid">
                <div class="topper-dashvil">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col">
                            <div class="title-cart-vi">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <h4>Companies for Education</h4>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-12 text-right">
                                        <a href="">
                                            <i class="fas fa-external-link-alt"></i><br>
                                            <span>Export</span>
                                        </a>
                                        <a href="">
                                            <i class="fas fa-expand-arrows-alt"></i><br>
                                            <span>Maximize</span>
                                        </a>
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
                                                    <div id="exist_companies"></div></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col">
                            <div class="title-cart-vi mar-tp0">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <h4>Villgro Summary</h4>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-12 text-right">
                                        <a href="">
                                            <i class="fas fa-external-link-alt"></i><br>
                                            <span>Export</span>
                                        </a>
                                        <a href="">
                                            <i class="fas fa-expand-arrows-alt"></i><br>
                                            <span>Maximize</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="comapny-graph">
                                <div class="row">
                                    <div class="col-lg-4 brd-rgtChart">
                                        <div class="company_chartvi brd-none">
                                            <div class="vil-portfolio_chart">
                                                <a href="javascript:void(0)" onclick="loadAllRevenue();">
                                                    <div id="all_revenue"></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 brd-rgtChart">
                                        <div class="company_chartvi brd-none">
                                            <div class="vil-portfolio_chart">
                                                <a href="javascript:void(0)" onclick="loadAllProfit();">
                                                    <div id="all_profit"></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="company_chartvi brd-none">
                                            <div class="vil-portfolio_chart">
                                                <a href="javascript:void(0)" onclick="loadAllCapital();">
                                                    <div id="all_capital"></div>
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
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-head">
                            <div class="title-cart-vi">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <h4 id="chartTitle"></h4>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-12 text-right">
                                        <a href="">
                                            <i class="fas fa-external-link-alt"></i><br>
                                            <span>Export</span>
                                        </a>
                                        <a data-dismiss="modal">
                                            <i class="fas fa-compress-arrows-alt"></i><br>
                                            <span>Minimize</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-xl-9 col-md-9 col-lg-9">
                                        <div id="charts1">
                                            <div id="chartContent" class="chart_modal"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-3 col-md-3 col-lg-3">
                                        <form method="post" id="chartFilter">
                                            <div class="modal-fundseed">
                                                <ul class="milestone-links">
                                                    <li class="wdt-40">
                                                        <label class="wdt-100">View Type :</label>
                                                    </li>
                                                    <li class="wdt-50">
                                                        <select class="form-control form-control-sm" class="viewType" id="viewType" onchange="selectType(this.value);">
                                                            <option value="">--Select--</option>
                                                            <option value="1">Monthly</option>
                                                            <option value="2">Quarterly</option>
                                                        </select>

                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="modal-fundseed" id="monthRange">
                                                <div id="startCalender">
                                                    <label>Start Date :</label>
                                                    <span><input Type="text" class="startDat form-control form-control-sm dateCalendar" name="startDate" id="startDate" placeholder="dd-mm-yyyy"></span>
                                                </div>
                                                <div id="endCalender">
                                                    <label>End Date :</label>
                                                    <span><input Type="text" class="endDat form-control form-control-sm dateCalendar" name="endDate" id="endDate" placeholder="dd-mm-yyyy"></span>
                                                </div>
                                            </div>
                                            <div class="modal-fundseed">
                                                <button class="btn btn-sm btn-success" type="button" onclick="totalCompanyFilter();">Search</button>
                                            </div>
                                            <input type="hidden" id="functionName" value="">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade seedfund-portfolio" id="linechartdiv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-head">
                            <div class="title-cart-vi">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <h4 id="lineChartTitle"></h4>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-12 text-right">
                                        <a href="">
                                            <i class="fas fa-external-link-alt"></i><br>
                                            <span>Export</span>
                                        </a>
                                        <a data-dismiss="modal">
                                            <i class="fas fa-compress-arrows-alt"></i><br>
                                            <span>Minimize</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-xl-8 col-md-8 col-lg-8 bgf4f5fa">
                                        <div id="charts1">
                                            <div id="lineChartContent" class="chart_modal"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-4 col-md-4 col-lg-4">
                                        <form method="post" id="lineChartFilter">
                                            <div class="modal-fundseed">
                                                <ul class="milestone-links">
                                                    <li class="wdt-40">
                                                        <label class="wdt-100">View Type :</label>
                                                    </li>
                                                    <li class="wdt-50">
                                                        <select class="form-control form-control-sm" class="lineViewType" id="lineViewType" onchange="selectLineType(this.value);">
                                                            <option value="">--Select--</option>
                                                            <option value="1">Monthly</option>
                                                            <option value="2">Quarterly</option>
                                                        </select>

                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="modal-fundseed" id="quarterView">
                                                <span>
                                                    <div class="wdt-100">
                                                        <ul class="milestone-links">
                                                            <li class="wdt-20">
                                                                <label class="wdt-100">From :</label>
                                                            </li>
                                                            <li class="wdt-38">
                                                                <select class="form-control form-control-sm dropdown" name="fromQuarterName" id="fromQuarterName">
                                                                    <option value="">--Quarter--</option>
                                                                    <option value="1">Q1</option>
                                                                    <option value="2">Q2</option>
                                                                    <option value="3">Q3</option>
                                                                    <option value="4">Q4</option>
                                                                </select>
                                                            </li>
                                                            <li class="wdt-38">
                                                                <select class="form-control form-control-sm dropdown" name="fromYear" id="fromYear">
                                                                    <option value="">--Year--</option>
                                                                    <?php foreach ($fin_year as $year) { ?>
                                                                        <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_financial) && $current_financial == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="wdt-100">
                                                        <ul class="milestone-links">
                                                            <li class="wdt-20">
                                                                <label class="wdt-100">To :</label>
                                                            </li>
                                                            <li class="wdt-38">
                                                                <select class="form-control form-control-sm dropdown" name="toQuarterName" id="toQuarterName">
                                                                    <option value="">--Quarter--</option>
                                                                    <option value="1">Q1</option>
                                                                    <option value="2">Q2</option>
                                                                    <option value="3">Q3</option>
                                                                    <option value="4">Q4</option>
                                                                </select>
                                                            </li>
                                                            <li class="wdt-38">
                                                                <select class="form-control form-control-sm dropdown" name="toYear" id="toYear">
                                                                    <option value="">--Year--</option>
                                                                    <?php foreach ($fin_year as $year) { ?>
                                                                        <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_financial) && $current_financial == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="modal-fundseed" id="monthView">
                                                <span>
                                                    <div class="wdt-100">
                                                        <ul id="startCalender" class="milestone-links">
                                                            <li class="wdt-30">
                                                                <label class="wdt-100">From :</label>
                                                            </li>
                                                            <li class="wdt-50">
                                                                <input Type="text" class="form-control form-control-sm" id="lineStartDate" name="lineStartDate" placeholder="dd-mm-yyyy">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="wdt-100">
                                                        <ul id="endCalender" class="milestone-links">
                                                            <li class="wdt-30">
                                                                <label class="wdt-100">To :</label>
                                                            </li>
                                                            <li class="wdt-50">
                                                                <input Type="text" class="form-control form-control-sm" id="lineEndDate" name="lineEndDate" placeholder="dd-mm-yyyy">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="modal-fundseed">
                                                <button class="btn btn-sm btn-success" type="button" onclick="totalRevenue();">Search</button>
                                            </div>
                                            <input type="hidden" id="lineName" value="">
                                        </form>
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
                            Copyright © 2019 <a href="http://192.168.1.200:8095/ctl_mis/index.php/">mis.villgroapps.org</a>
                        </div>
                    </div>
                </section>
            </footer>

            <style>
                .seedfund-portfolio .modal-body .col-xl-4 {
                    background-color: #fff;
                }
            </style>

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
                                                    // $("div.highcharts-menu-item:last").css("display", "none");
                                                    $(document).ready(function () {
                                                        // $(".highcharts-menu-item").last().css( "background-color", "red" );
                                                        // $("div.highcharts-menu-item:last").css("display", "none");
                                                        $('#monthRange').hide();
                                                        $('#quarterView').hide();
                                                        $('#monthView').hide();
                                                        $.ajax({
                                                            type: "POST",
                                                            async: false,
                                                            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/totalCompanies",
                                                            data: {id: 1},
                                                            dataType: 'html',
                                                            success: function (msg) {
                                                                $("#total_companies").html(msg);
                                                            }
                                                        });

                                                        $.ajax({
                                                            type: "POST",
                                                            async: false,
                                                            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/newCompanies",
                                                            data: {id: 1},
                                                            dataType: 'html',
                                                            success: function (msg) {
                                                                $("#new_companies").html(msg);
                                                            }
                                                        });

                                                        $.ajax({
                                                            type: "POST",
                                                            async: false,
                                                            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/exitCompanies",
                                                            data: {id: 1},
                                                            dataType: 'html',
                                                            success: function (msg) {
                                                                $("#exist_companies").html(msg);
                                                            }
                                                        });

                                                        $.ajax({
                                                            type: "POST",
                                                            async: false,
                                                            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allRevenue",
                                                            data: {id: 1},
                                                            dataType: 'html',
                                                            success: function (msg) {
                                                                $("#all_revenue").html(msg);
                                                            }
                                                        });

                                                        $.ajax({
                                                            type: "POST",
                                                            async: true,
                                                            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allProfit",
                                                            data: {id: 1},
                                                            dataType: 'html',
                                                            success: function (msg) {
                                                                $("#all_profit").html(msg);
                                                            }
                                                        });

                                                        $.ajax({
                                                            type: "POST",
                                                            async: true,
                                                            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allCapital",
                                                            data: {id: 1},
                                                            dataType: 'html',
                                                            success: function (msg) {
                                                                $("#all_capital").html(msg);
                                                            }
                                                        });
                                                    });

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
                                                        selectType();
                                                        datepickerEachFunction();
                                                        $.ajax({
                                                            type: "POST",
                                                            async: false,
                                                            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/totalCompanies",
                                                            data: {id: 2},
                                                            dataType: 'html',
                                                            success: function (msg) {
                                                                $('#chartTitle').html('Total Companies');
                                                                $('#chartdiv').modal('show');
                                                                $("#chartContent").html(msg);
                                                                $("#functionName").val('totalCompanies');
                                                                datepickerEachFunction();
                                                            }
                                                        });
                                                    }

                                                    function loadNewCompanies() {
                                                        selectType();
                                                        datepickerEachFunction();
                                                        $.ajax({
                                                            type: "POST",
                                                            async: false,
                                                            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/newCompanies",
                                                            data: {id: 2},
                                                            dataType: 'html',
                                                            success: function (msg) {
                                                                $('#chartTitle').html('New Companies');
                                                                $('#chartdiv').modal('show');
                                                                $("#chartContent").html(msg);
                                                                $("#functionName").val('newCompanies');
                                                                datepickerEachFunction();
                                                            }
                                                        });
                                                    }

                                                    function loadExitCompanies() {
                                                        selectType();
                                                        datepickerEachFunction();
                                                        $.ajax({
                                                            type: "POST",
                                                            async: false,
                                                            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/exitCompanies",
                                                            data: {id: 2},
                                                            dataType: 'html',
                                                            success: function (msg) {
                                                                $('#chartTitle').html('Graduates & Exits Companies');
                                                                $('#chartdiv').modal('show');
                                                                $("#chartContent").html(msg);
                                                                $("#functionName").val('exitCompanies');
                                                                datepickerEachFunction();
                                                            }
                                                        });
                                                    }

                                                    function loadAllRevenue() {
                                                        selectLineType();
                                                        lineDatepicker();
                                                        $.ajax({
                                                            type: "POST",
                                                            async: false,
                                                            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allRevenue",
                                                            data: {id: 2},
                                                            dataType: 'html',
                                                            success: function (msg) {
                                                                $('#lineChartTitle').html('All Companies - Revenue');
                                                                $('#linechartdiv').modal('show');
                                                                $("#lineChartContent").html(msg);
                                                                $("#lineName").val('allRevenue');
                                                                lineDatepicker();
                                                            }
                                                        });
                                                    }

                                                    function loadAllProfit() {
                                                        selectLineType();
                                                        lineDatepicker();
                                                        $.ajax({
                                                            type: "POST",
                                                            async: false,
                                                            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allProfit",
                                                            data: {id: 2},
                                                            dataType: 'html',
                                                            success: function (msg) {
                                                                $('#lineChartTitle').html('All Companies - Profit');
                                                                $('#linechartdiv').modal('show');
                                                                $("#lineChartContent").html(msg);
                                                                $("#lineName").val('allProfit');
                                                                lineDatepicker();
                                                            }
                                                        });
                                                    }

                                                    function loadAllCapital() {
                                                        selectLineType();
                                                        lineDatepicker();
                                                        $.ajax({
                                                            type: "POST",
                                                            async: false,
                                                            url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/allCapital",
                                                            data: {id: 2},
                                                            dataType: 'html',
                                                            success: function (msg) {
                                                                $('#lineChartTitle').html('All Companies - Capital');
                                                                $('#linechartdiv').modal('show');
                                                                $("#lineChartContent").html(msg);
                                                                $("#lineName").val('allCapital');
                                                                lineDatepicker();
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

                                                    function selectType(id) {
                                                        if (id == 2) {
                                                            $('#startDate').val('');
                                                            $('#endDate').val('');
                                                            $('#monthRange').hide();
                                                        } else if (id == 1) {
                                                            $('#monthRange').show();
                                                        } else {
                                                            $('#viewType').val('');
                                                            $('#monthRange').hide();
                                                        }
                                                    }

                                                    function selectLineType(id) {
                                                        if (id == 2) {
                                                            $('#quarterView').show();
                                                            $('#monthView').hide();
                                                        } else if (id == 1) {
                                                            $('#monthView').show();
                                                            $('#quarterView').hide();
                                                        } else {
                                                            $('#lineViewType').val('');
                                                            $('#quarterView').hide();
                                                            $('#monthView').hide();
                                                        }
                                                    }

                                                    function totalCompanyFilter() {
                                                        var loadFilter = $("#functionName").val();
                                                        if ($('#chartFilter').valid()) {
                                                            var quarter = $('#quarterName').val();
                                                            var start_date = $('#startDate').val();
                                                            var end_date = $('#endDate').val();
                                                            $.ajax({
                                                                type: "POST",
                                                                async: false,
                                                                url: "<?php echo base_url(); ?>index.php/portfolio/portfolioui/" + loadFilter,
                                                                data: {id: 3, quarter: quarter, start_date: start_date, end_date: end_date},
                                                                dataType: 'html',
                                                                success: function (msg) {
                                                                    $("#chartContent").html(msg);
                                                                }
                                                            });
                                                        }
                                                    }

                                                    function totalRevenue() {
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

                                                    function lineDatepicker() {
                                                        $('#lineStartDate, #lineEndDate').datepicker({
                                                            changeMonth: true,
                                                            changeYear: true,
                                                            showButtonPanel: true,
                                                            dateFormat: 'M, yy',
                                                            onClose: function (dateText, inst) {
                                                                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                                                            }
                                                        });
                                                    }

                                                    $(document).on('click', '#lineStartDate', function () {
                                                        $('.ui-datepicker').css("top", "320px");
                                                        $('.ui-datepicker-calendar').css("display", "none");
                                                    });

                                                    $(document).on('click', '#lineEndDate', function () {
                                                        $('.ui-datepicker').css("top", "350px");
                                                        $('.ui-datepicker-calendar').css("display", "none");
                                                    });

                                                    $(document).on('click', '#startDate', function () {
                                                        $('.ui-datepicker').css("top", "320px");
                                                        $('.ui-datepicker-calendar').css("display", "block");
                                                    });

                                                    $(document).on('click', '#endDat', function () {
                                                        $('.ui-datepicker').css("top", "350px");
                                                        $('.ui-datepicker-calendar').css("display", "block");
                                                    });

            </script>

            <style type="text/css">
                .error{width: 100% !important;}
                #total_companies, #new_companies, #exist_companies {height: 410px !important; overflow: scroll;}
                #all_revenue, #all_profit, #all_capital {height: 410px !important; overflow: scroll;}
                .highcharts-menu-item:last-child {
                    display: none !important;
                }
            </style>

    </body>
</html>
