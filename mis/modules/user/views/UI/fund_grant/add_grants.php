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
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/responsive_vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.4/css/dataTables.responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="fixed-headervi">
        <?php $this->load->view('UI/header.php'); ?>
    </div>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
            <div class="Vital-Newmenu">
                <div class="row">
                    <div class="col">
                        <ul>
                            <li><a href=""><i class="fas fa-home"></i> Home</a></li>
                            <li><a href=""><i class="fas fa-tag"></i> Deals</a></li>
                            <li><a href="<?php echo base_url() . 'index.php/user/user_ui/apply_leave'; ?>"><i class="fas fa-sync-alt"></i> Requests</a></li>
                            <li><a href=""><i class="far fa-check-square"></i> Approve</a></li>
                            <li><a href=""><i class="far fa-chart-bar"></i> Portfolio</a></li>
                            <li><a href=""><i class="fas fa-archive"></i> Resources</a></li>
                            <li class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/funds_grant_list'; ?>"><i class="fas fa-hand-holding-usd"></i> Funds/Grants</a></li>
                            <li><a href=""><i class="fas fa-suitcase"></i> Reports</a></li>
                            <li><a href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>"><i class="fas fa-user-friends"></i> Master's</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="dataconfig-content page-wrapper vitals_mainContent ">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('UI/fund_grant/fund_grant_sidemenu.php', array('page' => 'add_grant')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                    <h4>Add Funder/Grant</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/user/user_ui/add_donor'; ?>">Add Funder</a></li>
                                            <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/user/user_ui/add_grants'; ?>">Add Grant</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <div class="row">
                                                    <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                                        <h4 class="vitals_innerSub">Add Grants </h4>
                                                    </div>
                                                </div>
                                                <div class="row leaveLabel">
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <input class="form-control" type="text" placeholder="TLF">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Grant ID</label>
                                                            <input class="form-control" type="text" value="FY112019-102022" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Grant Signed Date <span>*</span></label>
                                                            <input class="form-control" type="text" placeholder="01-11-2019">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Grant Start Date <span>*</span></label>
                                                            <input class="form-control" type="text" placeholder="01-11-2019">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Purpose</label>
                                                            <textarea class="form-control" placeholder="Type here..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <input class="form-control display-unvisible" type="text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Grant Amount (INR) <span>*</span></label>
                                                            <input class="form-control" type="text" placeholder="Enter Amount">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Status <span>*</span></label>
                                                            <select class="form-control">
                                                                <option>Open</option>
                                                                <option>On Hold</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Grant End Date <span>*</span></label>
                                                            <input class="form-control" type="text" placeholder="01-10-2022">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                    </div>
                                                </div>
                                                <div style="height:30px"></div>
                                                <div class="table_configcontentnew pad-bt0">
                                                    <div class="tabpanel-title">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                <h4>Grant Line</h4>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                <ul class="milestone-links">
                                                                    <!-- <li>
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a>
                                                            </li> -->
                                                                    <li>
                                                                        <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                                    <table class="table" style="margin-top: 0">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%" class="removeArrow"><input class="form-control" type="checkbox"></th>
                                                                <th width="20%">Budget Head</th>
                                                                <th width="20%">Line Item</th>
                                                                <th width="15%">Amount (INR)</th>
                                                                <th width="25%">Comments</th>
                                                                <th width="5%"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="metric_more">
                                                                <td class="valign-center"><input class="form-control" type="checkbox"></td>
                                                                <td><input class="form-control" type="text" placeholder="Enter Name"></td>
                                                                <td><input class="form-control" type="text" placeholder="Enter Line Item"></td>
                                                                <td><input class="form-control" type="text" placeholder="Enter Amount"></td>
                                                                <td><input class="form-control" type="text" placeholder="Enter Comments"></td>
                                                                <td>
                                                                    <!-- <a class="deleteMetric" title="Delete Metric" onclick="deleteMetric(316);" href="javascript:void(0)"><i class="fas fa-trash"></i></a> -->
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div style="height:30px"></div>
                                                <div class="table_configcontentnew pad-bt0">
                                                    <div class="tabpanel-title">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                <h4>Disbursement schedule</h4>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                <ul class="milestone-links">
                                                                    <!-- <li>
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a>
                                                            </li> -->
                                                                    <li>
                                                                        <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                                    <table class="table" style="margin-top: 0">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%" class="removeArrow"><input class="form-control" type="checkbox"></th>
                                                                <th width="18%">Milestone</th>
                                                                <th width="16%">Date of Disbursement</th>
                                                                <th width="15%">Amount (INR)</th>
                                                                <th width="14%">Date of Deposite</th>
                                                                <th width="17%">Amount Deposited (INR)</th>
                                                                <th width="16%">Comments</th>                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="metric_more">
                                                                <td class="valign-center"><input class="form-control" type="checkbox"></td>
                                                                <td><textarea class="form-control"></textarea></td>
                                                                <td><input class="form-control" type="text" placeholder="01-01-2020"></td>
                                                                <td><input class="form-control" type="text" placeholder="Enter Amount"></td>
                                                                <td><input class="form-control" type="text" placeholder="01-01-2020"></td>
                                                                <td><input class="form-control" type="text" placeholder="Enter Amount"></td>
                                                                <td><input class="form-control" type="text" placeholder="Enter Comments"></td>
                                                                
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div style="height:30px"></div>
                                                <div class="table_configcontentnew pad-bt0">
                                                    <div class="tabpanel-title">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                <h4>Grant Reports</h4>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                <ul class="milestone-links">
                                                                    <!-- <li>
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a>
                                                            </li> -->
                                                                    <li>
                                                                        <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                                    <table class="table" style="margin-top: 0">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%" class="removeArrow"><input class="form-control" type="checkbox"></th>
                                                                <th width="20%">Date of Report</th>
                                                                <th width="20%">Responsibility</th>
                                                                <th width="20%">Comments</th>
                                                                <th width="28%">Submitted Report</th>
                                                                <th width="7%"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="metric_more">
                                                                <td class="valign-center"><input class="form-control" type="checkbox"></td>
                                                                <td><input class="form-control" type="text" placeholder="01-01-2020"></td>
                                                                <td><input class="form-control" type="text" placeholder="Enter Name"></td>
                                                                <td><input class="form-control" type="text" placeholder="Enter Comments"></td>
                                                                <td><input type="button" class="form-control masterPicUpdatebtn employeeInput" value="Upload Report"></td>
                                                                <td>
                                                                    <!-- <a class="deleteMetric" title="Delete Metric" onclick="deleteMetric(316);" href="javascript:void(0)"><i class="fas fa-trash"></i></a> -->
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div style="height:20px"></div>
                                                <div class="row justify-content-end">
                                                    <div class="col-12 col-sm-4  col-md-4 ">
                                                        <div class="text-right">
                                                            <ul class="vitals-links saveLinkView ">
                                                                <li><a href="#" class="vital_yellow_btn">Save Grant</a></li>
                                                                <li><a href="#" class="vital_bordered_btn">Reset</a></li>
                                                            </ul>
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
<script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script>
    $(document).ready(function() {
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 230) + 'px'
        });
    });

    // $('table').DataTable();

    // table row in a table clickable as a link
    // ---------------------------------------      


    $(document).ready(function() {

        $('#multiselect, #accessibleTo').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });

    });

    function getSelectedValues() {
        var selectedVal = $("#multiselect, #accessibleTo").val();
        for (var i = 0; i < selectedVal.length; i++) {
            if (window.CP.shouldStopExecution(0)) break;

            function innerFunc(i) {
                setTimeout(function() {
                    location.href = selectedVal[i];
                }, i * 2000);
            }
            innerFunc(i);
        }
        window.CP.exitedLoop(0);
    }
</script>

</html>