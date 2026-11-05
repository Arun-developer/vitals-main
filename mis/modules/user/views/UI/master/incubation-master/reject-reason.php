<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee - Personal info</title>
    <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/jquery-bootstrap-scrolling-tabs.css'; ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

</head>

<body>
    <div class="fixed-headervi">
        <?php $this->load->view('UI/header1.php'); ?>
    </div>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
            <div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
                <div class="row">

                    <div class="col-lg-3 col-xl-3 col-md-3 col-12">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('UI/master/master_sidemenu.php', array('page' => 'incubation_RR')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                    <h4>Incubation Master - Reasons</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">

                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div class="tab-slider--container tab-content">
                                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new ">
                                                <div class="row leaveLabel">
                                                    <div class="col-12 col-md-12 col-lg-3 col-xl-3">
                                                        <div class="form-group">
                                                            <label>Reason Name</label>
                                                            <input class="form-control" type="text" placeholder="Enter here">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div style="height: 15px;"></div>
                                                        <ul class="vitals-links">
                                                            <li><a href="" class="vital_yellow_btn pad-hr15 wdt_100">Search</a></li>
                                                            <li><span class="vitals_clearSearch">Clear search</span></li>
                                                        </ul>
                                                    </div>
                                                    <!-- <div class="col-xl-5 col-lg-5 col-md-12 col-12 text-right">
                                                        <div style="height: 25px;"></div>
                                                        <ul class="vitals-links ">
                                                            <li>
                                                                <a href="http://183.82.33.232:8095/vital/index.php/user/user_ui/add_reject_reason" class="master_aduser"><i class="fas fa-plus-circle"></i> Add Reject Reason</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div> -->
                                                </div>
                                                <div class="table_configcontentnew pad-bt0">
                                                    <div class="tabpanel-title">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                <!-- <h4>Contact Details</h4> -->
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                <ul class="milestone-links">
                                                                    <li class="brd-left-onboard">
                                                                        <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                    </li>
                                                                    <!-- <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a>
                                                            </li> -->
                                                                    <li class="brd-left-onboard">
                                                                        <a href="javascript:void(0)" class="edit-btnconfig mar-tp15 opacity5 none-pointer"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                                    </li>
                                                                    <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue holiday_submit  opacity5 none-pointer" ">Save</a></li>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                                    <table class="table table-hover dt-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th width="8%" class="removeArrow"></th>
                                                                <th width="35%">Reject Reason Name</th>
                                                                <th width="20%">Partner</th>
                                                                <th width="20%">Status</th>
                                                                <th width="17%" class="removeArrow"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input class="form-control" type="checkbox"></td>
                                                                <td>Not reliable</td>
                                                                <td><select class="form-control" disabled>
                                                                        <option value="1">Villgro India </option>
                                                                        <option value="2">Villgro Kenya </option>
                                                                        <option value="3">Menterra </option>
                                                                        <option value="4">Startup Oasis </option>
                                                                        <option value="5">IIM Calcutta </option>
                                                                        <option value="6">KIIT </option>
                                                                        <option value="7">SIIC, IITK </option>
                                                                        <option value="8">External Vendors </option>
                                                                        <option value="9">IIEF </option>
                                                                        <option value="10">Powering Livelihoods </option>
                                                                    </select></td>
                                                                <td><select class="form-control" disabled>
                                                                        <option>Approved</option>
                                                                        <option>Disapproved </option>
                                                                    </select></td>
                                                                <td>&nbsp</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input class="form-control" type="checkbox"></td>
                                                                <td>Power innovation</td>
                                                                <td><select class="form-control" disabled>
                                                                        <option value="1">Villgro India </option>
                                                                        <option value="2">Villgro Kenya </option>
                                                                        <option value="3">Menterra </option>
                                                                        <option value="4">Startup Oasis </option>
                                                                        <option value="5">IIM Calcutta </option>
                                                                        <option value="6">KIIT </option>
                                                                        <option value="7">SIIC, IITK </option>
                                                                        <option value="8">External Vendors </option>
                                                                        <option value="9">IIEF </option>
                                                                        <option value="10">Powering Livelihoods </option>
                                                                    </select></td>
                                                                <td><select class="form-control" disabled>
                                                                        <option>Approved</option>
                                                                        <option>Disapproved </option>
                                                                    </select></td>
                                                                <td>&nbsp</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input class="form-control" type="checkbox"></td>
                                                                <td>Very early stage/ Pre-revenue</td>
                                                                <td><select class="form-control" disabled>                                                                        
                                                                        <option value="3">Menterra </option>
                                                                        <option value="4">Startup Oasis </option>
                                                                        <option value="5">IIM Calcutta </option>
                                                                        <option value="6">KIIT </option>
                                                                        <option value="7">SIIC, IITK </option>
                                                                        <option value="8">External Vendors </option>
                                                                        <option value="9">IIEF </option>
                                                                        <option value="10">Powering Livelihoods </option>
                                                                    </select></td>
                                                                <td><select class="form-control" disabled>
                                                                        <option>Approved</option>
                                                                        <option>Disapproved </option>
                                                                    </select></td>
                                                                <td>&nbsp</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input class="form-control" type="checkbox"></td>
                                                                <td>Transferred to another partner</td>
                                                                <td><select class="form-control" disabled>
                                                                        <option value="1">Villgro India </option>
                                                                        <option value="2">Villgro Kenya </option>
                                                                        <option value="3">Menterra </option>
                                                                        <option value="4">Startup Oasis </option>
                                                                        <option value="5">IIM Calcutta </option>
                                                                        <option value="6">KIIT </option>
                                                                        <option value="7">SIIC, IITK </option>
                                                                        <option value="8">External Vendors </option>
                                                                        <option value="9">IIEF </option>
                                                                        <option value="10">Powering Livelihoods </option>
                                                                    </select></td>
                                                                <td><select class="form-control" disabled>
                                                                        <option>Approved</option>
                                                                        <option>Disapproved </option>
                                                                    </select></td>
                                                                <td>&nbsp</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input class="form-control" type="checkbox"></td>
                                                                <td>Insufficient information in application</td>
                                                                <td><select class="form-control" disabled>
                                                                        <option value="1">Villgro India </option>
                                                                        <option value="2">Villgro Kenya </option>
                                                                        <option value="3">Menterra </option>
                                                                        <option value="4">Startup Oasis </option>
                                                                        <option value="5">IIM Calcutta </option>
                                                                        <option value="6">KIIT </option>
                                                                        <option value="7">SIIC, IITK </option>
                                                                        <option value="8">External Vendors </option>
                                                                        <option value="9">IIEF </option>
                                                                        <option value="10">Powering Livelihoods </option>
                                                                    </select></td>
                                                                <td><select class="form-control" disabled>
                                                                        <option>Approved</option>
                                                                        <option>Disapproved </option>
                                                                    </select></td>
                                                                <td>&nbsp</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div style="height: 20px;"></div>
                                                <div class="table_configcontentnew pad-bt0">
                                                    <div class="tabpanel-title">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                <!-- <h4>Contact Details</h4> -->
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                <ul class="milestone-links">
                                                                    <li class="brd-left-onboard">
                                                                        <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                    </li>
                                                                    <!-- <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a>
                                                            </li> -->
                                                                    <li class="brd-left-onboard">
                                                                        <a href="javascript:void(0)" class="edit-btnconfig mar-tp15 opacity5 none-pointer"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                                    </li>
                                                                    <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue holiday_submit  opacity5 none-pointer" ">Save</a></li>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                                    <table class="table table-hover dt-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th width="8%" class="removeArrow"></th>
                                                                <th width="35%">Preliminary Reason</th>
                                                                <th width="20%">Partner</th>
                                                                <th width="20%">Status</th>
                                                                <th width="17%" class="removeArrow"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input class="form-control" type="checkbox"></td>
                                                                <td>Not reliable</td>
                                                                <td><select class="form-control" disabled>
                                                                        <option value="1">Villgro India </option>
                                                                        <option value="2">Villgro Kenya </option>
                                                                        <option value="3">Menterra </option>
                                                                        <option value="4">Startup Oasis </option>
                                                                        <option value="5">IIM Calcutta </option>
                                                                        <option value="6">KIIT </option>
                                                                        <option value="7">SIIC, IITK </option>
                                                                        <option value="8">External Vendors </option>
                                                                        <option value="9">IIEF </option>
                                                                        <option value="10">Powering Livelihoods </option>
                                                                    </select></td>
                                                                <td><select class="form-control" disabled>
                                                                        <option>Approved</option>
                                                                        <option>Disapproved </option>
                                                                    </select></td>
                                                                <td>&nbsp</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input class="form-control" type="checkbox"></td>
                                                                <td>Power innovation</td>
                                                                <td><select class="form-control" disabled>
                                                                        <option value="1">Villgro India </option>
                                                                        <option value="2">Villgro Kenya </option>
                                                                        <option value="3">Menterra </option>
                                                                        <option value="4">Startup Oasis </option>
                                                                        <option value="5">IIM Calcutta </option>
                                                                        <option value="6">KIIT </option>
                                                                        <option value="7">SIIC, IITK </option>
                                                                        <option value="8">External Vendors </option>
                                                                        <option value="9">IIEF </option>
                                                                        <option value="10">Powering Livelihoods </option>
                                                                    </select></td>
                                                                <td><select class="form-control" disabled>
                                                                        <option>Approved</option>
                                                                        <option>Disapproved </option>
                                                                    </select></td>
                                                                <td>&nbsp</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input class="form-control" type="checkbox"></td>
                                                                <td>Very early stage/ Pre-revenue</td>
                                                                <td><select class="form-control" disabled>                                                                        
                                                                        <option value="3">Menterra </option>
                                                                        <option value="4">Startup Oasis </option>
                                                                        <option value="5">IIM Calcutta </option>
                                                                        <option value="6">KIIT </option>
                                                                        <option value="7">SIIC, IITK </option>
                                                                        <option value="8">External Vendors </option>
                                                                        <option value="9">IIEF </option>
                                                                        <option value="10">Powering Livelihoods </option>
                                                                    </select></td>
                                                                <td><select class="form-control" disabled>
                                                                        <option>Approved</option>
                                                                        <option>Disapproved </option>
                                                                    </select></td>
                                                                <td>&nbsp</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input class="form-control" type="checkbox"></td>
                                                                <td>Transferred to another partner</td>
                                                                <td><select class="form-control" disabled>
                                                                        <option value="1">Villgro India </option>
                                                                        <option value="2">Villgro Kenya </option>
                                                                        <option value="3">Menterra </option>
                                                                        <option value="4">Startup Oasis </option>
                                                                        <option value="5">IIM Calcutta </option>
                                                                        <option value="6">KIIT </option>
                                                                        <option value="7">SIIC, IITK </option>
                                                                        <option value="8">External Vendors </option>
                                                                        <option value="9">IIEF </option>
                                                                        <option value="10">Powering Livelihoods </option>
                                                                    </select></td>
                                                                <td><select class="form-control" disabled>
                                                                        <option>Approved</option>
                                                                        <option>Disapproved </option>
                                                                    </select></td>
                                                                <td>&nbsp</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input class="form-control" type="checkbox"></td>
                                                                <td>Insufficient information in application</td>
                                                                <td><select class="form-control" disabled>
                                                                        <option value="1">Villgro India </option>
                                                                        <option value="2">Villgro Kenya </option>
                                                                        <option value="3">Menterra </option>
                                                                        <option value="4">Startup Oasis </option>
                                                                        <option value="5">IIM Calcutta </option>
                                                                        <option value="6">KIIT </option>
                                                                        <option value="7">SIIC, IITK </option>
                                                                        <option value="8">External Vendors </option>
                                                                        <option value="9">IIEF </option>
                                                                        <option value="10">Powering Livelihoods </option>
                                                                    </select></td>
                                                                <td><select class="form-control" disabled>
                                                                        <option>Approved</option>
                                                                        <option>Disapproved </option>
                                                                    </select></td>
                                                                <td>&nbsp</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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





        $('.summaryEdit').click(function() {
            $(".employeeInput").attr("disabled", false);
            $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
            $('li.edit').addClass("activeTabs");
            $('li.edit a').addClass("greentab");
            $('.saveLinkView').addClass("display-show");
            $('.saveLinkView').removeClass("display-hide");
            //                $(".removeImg").removeClass("none-pointer");
        });
    </script>


</body>

</html>