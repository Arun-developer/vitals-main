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
                        <?php $this->load->view('UI/master/master_sidemenu.php', array('page' => 'incubation_MTM')); ?>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                    <h4>Incubation Master - Mail Template Master</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right pad-none">
                                    <ul class="vitals-links">
                                        <li>Module</li>
                                        <li>
                                            <div class="form-group mar-bt0 ">
                                                <select class="form-control">
                                                    <option value="">-select-</option>
                                                    <option value="mis" >RAMP incubation</option>
                                                    <option value="ais"selected="selected">Admin</option>
                                                    <option value="hris">HR</option>
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div class="tab-slider--container tab-content">
                                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new ">
                                                <div class="row v_m_e_search">
                                                    <div class="col-12 col-md-12 col-lg-3 col-xl-3">
                                                        <div class="form-group">
                                                            <label>Template Type</label>
                                                            <select class="form-control">
                                                            <option value="">Select</option>
                                                                        <option value="Book ">Library</option>
                                                                        <option value="Travel">Travel</option>
                                                                        <option value="Asset">Asset</option>
                                                                        <option value="Dispatch">Dispatch</option>
                                                            
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-3 col-xl-3">
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <select class="form-control">
                                                                <option value="">Select</option>
                                                                <option value="0">Inactive</option>
                                                                <option value="1">Active</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div style="height: 15px;"></div>
                                                        <ul class="vitals-links pad-none">
                                                            <li><a href="" class="vital_yellow_btn pad-hr15 wdt_100">Search</a></li>
                                                            <li><span class="vitals_clearSearch">Clear search</span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-12 col-12 text-right">
                                                    <div style="height: 9px;"></div>
                                                        <ul class="vitals-links ">
                                                            <li>
                                                                <a href="#" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>

                                                
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                        <table class="table table-hover dt-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th width="5%" class="removeArrow"></th>
                                                                    <th width="30%">Template Type</th>
                                                                    <th width="30%">Message Subject</th>
                                                                    <th width="35%">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Book Request Cancel By Employee </td>
                                                                    <td>Book Request Canceled by Employee </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Book Request </td>
                                                                    <td>Book Request </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Book Request Confirmation </td>
                                                                    <td>Book Request Confirmation </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Book return </td>
                                                                    <td>Book return </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Book Request Renewal </td>
                                                                    <td>Book Request Renewal </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Book Request Renewal Confirmation </td>
                                                                    <td>Book Request Renewal Confirmation </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Travel Booking Request </td>
                                                                    <td>Travel Booking Request </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Asset Transfer </td>
                                                                    <td>Asset Transfer </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Book return reminder </td>
                                                                    <td>Book return reminder </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Travel Booking Approval </td>
                                                                    <td>Travel Booking Approval </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Approval Note Deferred by RO </td>
                                                                    <td>Approval Note Deferred by RO </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Travel booking Request Disapproval by Admin </td>
                                                                    <td>Travel booking Request Disapproval by Admin </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Asset AMC Reminder </td>
                                                                    <td>Asset AMC Reminder </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Travel Request cancellation by Employee </td>
                                                                    <td>Travel Request cancellation by Employee </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>Send To Vendor </td>
                                                                    <td>Send To Vendor </td>
                                                                    <td><select class="form-control" disabled>
                                                                            <option>Approved</option>
                                                                            <option>Disapproved </option>
                                                                        </select></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
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


    <script>
        // Window Height
        // ---------------------------------------
        $(document).ready(function() {
            $('.vital_windowScroll').css({
                'height': (($(window).height()) - 200) + 'px'
            });
        });

        $('table').DataTable();

        // table row in a table clickable as a link
        // ---------------------------------------

        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
    </script>


</body>

</html>