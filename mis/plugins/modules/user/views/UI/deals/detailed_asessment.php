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
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/jquery-bootstrap-scrolling-tabs.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/responsive_vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
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
                            <?php $this->load->view('UI/deals/deal_sidemenu.php', array('page' => 'detailed_asessment')); ?>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                    <span><a href="<?php echo base_url() . 'index.php/user/user_ui/mydeals'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>BookMyBai - Detailed Assessment</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                    <ul class="vitals-links">
                                        <li><a href="" class="edt_btnVital"><span><i class="far fa-file-alt"></i></span> Application Status Log</a></li>
                                        <li><a href="" class="edt_btnVital"><span><i class="fas fa-user-check"></i></span> Asign user</a></li>
                                        <li><a href="" class="edt_btnVital"><span><i class="fas fa-download"></i></span> Export</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dealsFixedHeader">
                                <div class="row d_v_s_L">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                                        <ul class="vitals-links">
                                            <li>Incubatee name: <b>BookMyBai</b></li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                                        <ul class="vitals-links">
                                            <li>Inv id: <b>15713_01_01</b></li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                                        <ul class="vitals-links">
                                            <li>Sector: <b>Skill Development</b></li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                                        <ul class="vitals-links">
                                            <li>Sub Sector: <b>Job platforms</b></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row d_v_s_L">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                                        <ul class="vitals-links">
                                            <li>Stage: <b>Portfolio</b></li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                                        <ul class="vitals-links">
                                            <li>Assigned To: <b>Swetha, Vikash</b></li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                                        <ul class="vitals-links">
                                            <li>Status: <b>Open</b></li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                                        <ul class="vitals-links">
                                            <li>Action: <b>close <a href=""><i class="fas fa-pencil-alt">_</i></a></b></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="display-hide" id="navLoad">
                                <div class="newCLickTabs">
                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/deals'; ?>">Background/ Description</a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Current Situation/ Next Steps</a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Investment Structure and Returns</a></li>
                                            <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Investment Thesis</a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Business Model</a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Launch and scaling strategy of the company</a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Social Impact</a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Exit Options</a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Existing investors and strategic partners</a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Exit Options</a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Summary of other key Agreements </a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Sector summary and key Drivers</a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">SWOT </a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Key Transaction Terms</a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Risks and Mitigations </a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Timing & Next Steps</a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">Villgro Team</a></li>
                                            <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">IC Decision</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-slider--container ">
                                <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                    <main class="page-content">
                                        <div class="inputplan-structureall plan-structure-new">
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>How you conducted research on your product customer segment / run pilots? </label>
                                                        <input type="text" class="form-control" placeholder="Yes" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Who is the intended primary beneficiary of your product / service?</label>
                                                        <textarea class="form-control" name="" id="" cols="30" rows="3" disabled></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>What is the demographic profile of the primary beneficiary group?</label>
                                                        <textarea class="form-control" name="" id="" cols="30" rows="3" disabled></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>What is the average monthly earning of the primary beneficiary group?</label>
                                                        <textarea class="form-control" name="" id="" cols="30" rows="3" disabled></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>How many people do you expect to impact through your innovation?</label>
                                                        <textarea class="form-control" name="" id="" cols="30" rows="3" disabled></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-12 col-md-12">
                                                    <div class="form-group">
                                                        <label>Will your product or service benifit others beneficiary groups? Describe these groups briefly.</label>
                                                        <textarea class="form-control" name="" id="" cols="30" rows="3" disabled></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </main>
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
<script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url() . 'source/portfolio_assets/js/additional-methods.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-bootstrap-scrolling-tabs.js'; ?>"></script>
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