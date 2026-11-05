<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villgro MIS</title>
    <!-- <link rel="stylesheet" href="http://192.168.1.200:8095/vital/source/portfolio_assets/css/new-portfolio.css"> -->
    <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
</head>

<body>
    <div class="fixed-headervi">
        <?php $this->load->view('UI/header1.php'); ?>
    </div>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
            <div class="dataconfig-content page-wrapper vitals_mainContent ">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('UI/deals/deal_sidemenu.php', array('page' => 'deals')); ?>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                    <span><a href="<?php echo base_url() . 'index.php/user/user_ui/mydeals'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>FlyLife - PA/RD Summary</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">

                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                            <div class="row dataconfig d_v_s_L">
                                <div class="col-xl-7 col-lg-7 col-md-7 col-12 pad-none">
                                    <ul class="vitals-links">
                                        <li><b>Stage:</b> Application</li>
                                        <li><b>Status:</b> Open</li>
                                        <li><b>Incharge:</b> Seraphina Selvanayakom (Active)</li>
                                        <li><i class="fas fa-pencil-alt">_</i></li>
                                    </ul>
                                </div>
                                <div class="col-xl-5 col-lg-5 col-md-5 col-12 pad-none text-right">
                                    <ul class="vitals-links">
                                        <li><a href="" class="edt_btnVital"><span><i class="far fa-file-alt"></i></span> Application Status Log</a></li>
                                        <li><a href="" class="edt_btnVital"><span><i class="fas fa-download"></i></span> Export</a></li>
                                        <li><a href="" class="edt_btnVital"><span><i class="far fa-times-circle"></i></span> Close Deal</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="display-hide" id="navLoad">
                                    <div class="newCLickTabs">
                                        <div>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/user/user_ui/deals'; ?>">Basic Information</a></li>
                                        <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/deals_team_info'; ?>">Team Information</a></li>
                                        <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/deals_info_about_enterprise'; ?>">Information About The Enterprise</a></li>
                                        <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/deals_impact_of_innovation'; ?>">Impact of Innovation</a></li>
                                        <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/deals_addition_info'; ?>">Additional Information</a></li>
                                    </ul>
                                </div>
                                    </div>
                            </div>
                            <div class="tab-slider--container tab-content">
                                <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                    <main class="page-content">
                                        <div class="inputplan-structureall plan-structure-new">
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Innovation ID</label>
                                                        <input type="text" class="form-control" placeholder="19200_01_01" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Name Of Enterprise</label>
                                                        <input type="text" class="form-control" placeholder="FlyLife" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Name Of Enterpreneur</label>
                                                        <input type="text" class="form-control" placeholder="Manas Sing Tuteja" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Address 1</label>
                                                        <input type="text" class="form-control" placeholder="SRMIST, Chennai" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Address 2</label>
                                                        <input type="text" class="form-control" placeholder="-" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Country</label>
                                                        <input type="text" class="form-control" placeholder="india" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="text" class="form-control" placeholder="user@gmail.com" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Mobile</label>
                                                        <input type="text" class="form-control" placeholder="9176208050" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Sector</label>
                                                        <input type="text" class="form-control" placeholder="Haelth" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Sub Sector</label>
                                                        <input type="text" class="form-control" placeholder="Other" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Is Your Enterprise a</label>
                                                        <input type="text" class="form-control" placeholder="Profit" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Will your social Incubate be based in India</label>
                                                        <input type="text" class="form-control" placeholder="yes" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Who will be the beneficiaries of your product/service?</label>
                                                        <input type="text" class="form-control" placeholder="Urban poor" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>What type of impact will your Product / service have on the BoP / poor?</label>
                                                        <input type="text" class="form-control" placeholder="Direct" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Partner</label>
                                                        <input type="text" class="form-control" placeholder="Villgro india" disabled />
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </main>
                                </div>
                            </div>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-1.9.1.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-bootstrap-scrolling-tabs.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/additional-methods.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.toaster.js'; ?>"></script>
    <script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.nav-tabs').scrollingTabs({
                enableSwiping: true
            }).on('ready.scrtabs', function() {
                $('.tab-content').show();
            });
            $('#navLoad').removeClass('display-hide');

            $('.vital_windowScroll').css({
                'height': (($(window).height()) - 190) + 'px'
            });
        });
    </script>
</html>