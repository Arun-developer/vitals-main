<?php ?>
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
                                <?php $this->load->view('UI/deals/deal_sidemenu.php', array('page' => 'pre_assitant')); ?>
                            </div>
                        </div>
                        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                            <main class="page-content">
                                <div class="row dataconfig d_v_d_c">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                        <span><a href="<?php echo base_url() . 'index.php/user/user_ui/mydeals'; ?>"><i class="fas fa-angle-left"></i> Back</a></span>
                                        <h4>FlyLife - Preliminary Assessment</h4>
                                    </div>
                                </div>
                                <div class="inputplan-structureall plan-structure-new vital_windowScroll">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive" id="holiday_table">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">S.No</th>
                                                        <th width="25%">Parameters</th>
                                                        <th width="24%">Seraphina Selvanayakom</th>
                                                        <th width="23%">Rationale</th>
                                                        <th width="23%">Risk</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>01</td>
                                                        <td>Team</td>
                                                        <td class="text-center">-</td>
                                                        <td><input class="form-control " type="text" value="Enter rationale details here" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Enter risk details here" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td>02</td>
                                                        <td>Social impact</td>
                                                        <td class="text-center">-</td>
                                                        <td><input class="form-control " type="text" value="Enter rationale details here" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Enter risk details here" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td>03</td>
                                                        <td>Problem -solution fit</td>
                                                        <td class="text-center">-</td>
                                                        <td><input class="form-control " type="text" value="Enter rationale details here" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Enter risk details here" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td>04</td>
                                                        <td>Product-market fit</td>
                                                        <td class="text-center">-</td>
                                                        <td><input class="form-control " type="text" value="Enter rationale details here" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Enter risk details here" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td>05</td>
                                                        <td>Bussiness model</td>
                                                        <td class="text-center">-</td>
                                                        <td><input class="form-control " type="text" value="Enter rationale details here" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Enter risk details here" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td>06</td>
                                                        <td>Innovation</td>
                                                        <td class="text-center">-</td>
                                                        <td><input class="form-control " type="text" value="Enter rationale details here" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Enter risk details here" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td>07</td>
                                                        <td>Scale potential</td>
                                                        <td class="text-center">-</td>
                                                        <td><input class="form-control " type="text" value="Enter rationale details here" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Enter risk details here" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td>08</td>
                                                        <td>Mandate & Sub-sector fit</td>
                                                        <td class="text-center">-</td>
                                                        <td><input class="form-control " type="text" value="Enter rationale details here" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Enter risk details here" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td>09</td>
                                                        <td>Follow-on funding</td>
                                                        <td class="text-center">-</td>
                                                        <td><input class="form-control " type="text" value="Enter rationale details here" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Enter risk details here" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td>10</td>
                                                        <td>Returns</td>
                                                        <td class="text-center">-</td>
                                                        <td><input class="form-control " type="text" value="Enter rationale details here" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Enter risk details here" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td>11</td>
                                                        <td>Exit</td>
                                                        <td class="text-center">-</td>
                                                        <td><input class="form-control " type="text" value="Enter rationale details here" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Enter risk details here" disabled=""></td>
                                                    </tr>

                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td class="clr_geen">Total</td>
                                                        <td><input class="form-control " type="text" value="" disabled></td>
                                                        <td class="clr_geen">Total %</td>
                                                        <td><input class="form-control " type="text" value="" disabled=""></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div style="height: 20px;"></div>
                                    <div class="row leaveLabel">
                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                            <div class="form-group">
                                                <label>Comments</label>
                                                <textarea class="form-control" name="" id="" cols="30" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row leaveLabel">
                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                            <div class="form-group">
                                                <ul class="vitals-links">
                                                    <li><label>LIS</label></li>
                                                    <li>
                                                        <div class="input-group">
                                                            <input type="radio" checked> Yes
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="input-group">
                                                            <input type="radio"> NO
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="vitals_innerSub">Donor Fit</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive dataTable no-footer" id="donor_table">
                                                <thead>
                                                    <tr>
                                                        <th width="10%"></th>
                                                        <th width="30%">Donor</th>
                                                        <th width="30%">Fund Recommended</th>
                                                        <th width="30%">Funds Approved</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                        <td>Villgro Ed & Empolyabilty</td>
                                                        <td><input class="form-control " type="text" value="Funds recommended" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Funds approved" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                        <td>Beyond Capital</td>
                                                        <td><input class="form-control " type="text" value="Funds recommended" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Funds approved" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                        <td>Beyond Capital</td>
                                                        <td><input class="form-control " type="text" value="Funds recommended" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Funds approved" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                        <td>Beyond Capital</td>
                                                        <td><input class="form-control " type="text" value="Funds recommended" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Funds approved" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                        <td>Beyond Capital</td>
                                                        <td><input class="form-control " type="text" value="Funds recommended" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Funds approved" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                        <td>Beyond Capital</td>
                                                        <td><input class="form-control " type="text" value="Funds recommended" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Funds approved" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                        <td>Beyond Capital</td>
                                                        <td><input class="form-control " type="text" value="Funds recommended" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Funds approved" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                        <td>Beyond Capital</td>
                                                        <td><input class="form-control " type="text" value="Funds recommended" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Funds approved" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                        <td>Beyond Capital</td>
                                                        <td><input class="form-control " type="text" value="Funds recommended" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Funds approved" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                        <td>Beyond Capital</td>
                                                        <td><input class="form-control " type="text" value="Funds recommended" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Funds approved" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                        <td>Beyond Capital</td>
                                                        <td><input class="form-control " type="text" value="Funds recommended" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Funds approved" disabled=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                        <td>Beyond Capital</td>
                                                        <td><input class="form-control " type="text" value="Funds recommended" disabled=""></td>
                                                        <td><input class="form-control " type="text" value="Funds approved" disabled=""></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div style="height: 20px;"></div>
                                    <div class="row leaveLabel">
                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                            <div class="form-group">
                                                <label>Recommendation</label>
                                                <select class="form-control" disabled>
                                                    <option>select</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row leaveLabel">
                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                            <div class="form-group">
                                                <label>Comments</label>
                                                <textarea class="form-control" name="" id="" cols="30" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row leaveLabel">
                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                            <div class="form-group">
                                                <label>Upload Document</label>
                                                <input type="button" class="form-control employeeInput masterPicUpdatebtn" disabled value="Choose file to upload">
                                            </div>
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
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
    <script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <script>
        $(document).ready(function () {
            $('.vital_windowScroll').css({
                'height': (($(window).height()) - 190) + 'px'
            });
        });
        $(document).ready(function () {
            $('#donor_table, #holiday_table').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
            });
        });


        // $('table').DataTable();

        // table row in a table clickable as a link
        // ---------------------------------------

        jQuery(document).ready(function ($) {
            $(".clickable-row").click(function () {
                window.location = $(this).data("href");
            });
        });
    </script>

</html>