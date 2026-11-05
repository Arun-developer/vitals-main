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
                            <?php $this->load->view('UI/fund_grant/fund_grant_sidemenu.php', array('page' => 'summary')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                    <span><a href="<?php echo base_url() . 'index.php/user/user_ui/grants'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>TLF - FY112019-102022</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                                    <ul class="vitals-links">
                                        <li><a href="javascript:" class="master_aduser"><span><i class="far fa-file-alt"></i></span> View Status Log</a></li>
                                        <li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                                        
                                        <li><a href="javascript:" class="master_aduser"><span><i class="fas fa-print"></i></span> Print</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <main class="page-content">
                                    <div class="inputplan-structureall plan-structure-new">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                                <h4 class="vitals_innerSub">Grants Details</h4>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Funder Name</label>
                                                    <input class="form-control grantInput" type="text" value="TLF" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label>Grant ID</label>
                                                    <input class="form-control" type="text" value="FY112019-102022" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Grant Signed Date</label>
                                                    <input class="form-control grantInput" type="text" value="01-11-2019" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Grant Start Date</label>
                                                    <input class="form-control grantInput" type="text" value="01-11-2019" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Purpose</label>
                                                    <textarea class="form-control grantInput" disabled>TLF</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <input class="form-control display-unvisible" type="text" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Grant Amount (INR)</label>
                                                    <input class="form-control grantInput" type="text" placeholder="Enter Amount" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="form-control grantInput" disabled>
                                                        <option>Open</option>
                                                        <option>On Hold</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Grant End Date</label>
                                                    <input class="form-control grantInput" type="text" value="01-10-2022" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                            </div>
                                        </div>
                                        <div class="saveLinkView display-hide" style="height:20px"></div>
                                        <div class="row justify-content-end">
                                            <div class="col-12 col-sm-4  col-md-4 ">
                                                <div class="text-right">
                                                    <ul class="vitals-links saveLinkView display-hide">
                                                        <li><a href="#" class="vital_yellow_btn">Save Grant Details</a></li>
                                                        <li><a href="#" class="vital_bordered_btn">Reset</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="height:30px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <h4>Grant Line Items</h4>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig grantLineEditBtn mar-tp15"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig  mar-tp15"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                            </li>
                                                            <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue ">Save</a></li>                                                              
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="metric_more">
                                                        <td class="valign-center"><input class="form-control" type="checkbox"></td>
                                                        <td><input class="form-control grandlineEdit" type="text" value="personnel" disabled></td>
                                                        <td><input class="form-control grandlineEdit" type="text" value="personnel" disabled></td>
                                                        <td><input class="form-control grandlineEdit" type="text" value="2,22,000" disabled></td>
                                                        <td><input class="form-control grandlineEdit" type="text" value="TLF Grants" disabled></td>                                                        
                                                    </tr>
                                                    <tr class="metric_more">
                                                        <td class="valign-center"><input class="form-control" type="checkbox"></td>
                                                        <td><input class="form-control grandlineEdit" type="text" value="personnel" disabled></td>
                                                        <td><input class="form-control grandlineEdit" type="text" value="personnel" disabled></td>
                                                        <td><input class="form-control grandlineEdit" type="text" value="2,22,000" disabled></td>
                                                        <td><input class="form-control grandlineEdit" type="text" value="TLF Grants" disabled></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td colspan="2"><b>Total</b></td>
                                                        <td ><b><input class="form-control " type="text" value="4,44,000" disabled></b></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                                <h4 class="vitals_innerSub">Grant Line</h4>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-6 col-xl-6 text-right">
                                                <ul class="vitals-links">
                                                    <li><a href="javascript:" class="master_aduser"><i class="fas fa-plus-circle"></i> Add</a></li>
                                                    <li><a href="" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                <table class="table table-hover dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th class="removeArrow"><input class="form-control" type="checkbox"></th>
                                                            <th>Budget Head</th>
                                                            <th>Line Item</th>
                                                            <th>Amount</th>
                                                            <th>Comments</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input class="form-control" type="checkbox"></td>
                                                            <td>personnel</td>
                                                            <td>personnel</td>
                                                            <td>2,22,000</td>
                                                            <td>TLF Grants</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td colspan="2"><b>Total</b></td>
                                                            <td colspan="2"><b>2,22,000</b></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div> -->
                                        <div style="height:30px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <h4>Disbursement schedule</h4>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                    <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig disbursementEditBtn  mar-tp15"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig  mar-tp15"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                            </li>
                                                            <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue ">Save</a></li>                                                              
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
                                                        <td><textarea class="form-control" disabled></textarea></td>
                                                        <td><input class="form-control disbursementEdit" type="text" value="28-08-2019" disabled></td>
                                                        <td><input class="form-control disbursementEdit" type="text" value="2,22,000" disabled></td>
                                                        <td><input class="form-control disbursementEdit" type="text" value="01-11-2019" disabled></td>
                                                        <td><input class="form-control disbursementEdit" type="text" value="2,22,000" disabled></td>
                                                        <td><input class="form-control disbursementEdit" type="text" value="TLF Grants" disabled></td>                                                        
                                                    </tr>
                                                    <tr class="metric_more">
                                                        <td class="valign-center"><input class="form-control" type="checkbox"></td>
                                                        <td><textarea class="form-control" disabled></textarea></td>
                                                        <td><input class="form-control disbursementEdit" type="text" value="28-08-2019" disabled></td>
                                                        <td><input class="form-control disbursementEdit" type="text" value="2,22,000" disabled></td>
                                                        <td><input class="form-control disbursementEdit" type="text" value="01-11-2019" disabled></td>
                                                        <td><input class="form-control disbursementEdit" type="text" value="2,22,000" disabled></td>
                                                        <td><input class="form-control disbursementEdit" type="text" value="TLF Grants" disabled></td> 
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td colspan="2"><b>Total</b></td>
                                                        <td><input class="form-control " type="text" value="4,44,000" disabled></td>
                                                        <td></td>
                                                        <td><input class="form-control " type="text" value="4,44,000" disabled></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                                <h4 class="vitals_innerSub">Disbursement schedule</h4>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-6 col-xl-6 text-right">
                                                <ul class="vitals-links">
                                                    <li><a href="javascript:" class="master_aduser"><i class="fas fa-plus-circle"></i> Add</a></li>
                                                    <li><a href="" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                <table class="table table-hover dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th class="removeArrow"><input class="form-control" type="checkbox"></th>
                                                            <th>Date of Disbursement</th>
                                                            <th>Amount</th>
                                                            <th>Date of Deposite</th>
                                                            <th>Amount Deposited</th>
                                                            <th>Comments</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input class="form-control" type="checkbox"></td>
                                                            <td>28-08-2019</td>
                                                            <td>2,22,000</td>
                                                            <td>01-11-2019</td>
                                                            <td>2,22,000</td>
                                                            <td>TLF Grants</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td><b>Total</b></td>
                                                            <td colspan="2"><b>2,22,000</b></td>
                                                            <td colspan="2"><b>2,22,000</b></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div> -->
                                        <div style="height:30px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <h4>Grant Reports</h4>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig grantReportEditBtn mar-tp15"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig  mar-tp15"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                            </li>
                                                            <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue ">Save</a></li>                                                              
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
                                                        <th width="18%">Due Date</th>
                                                        <th width="18%">Responsibility</th>
                                                        <th width="18%">Submitted Date</th>
                                                        <th width="18%">Comments</th>
                                                        <th width="24%">Report</th>                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="metric_more">
                                                        <td class="valign-center"><input class="form-control" type="checkbox"></td>
                                                        <td><input class="form-control grantReportEdit" type="text" value="01-11-2019" disabled></td>
                                                        <td><input class="form-control grantReportEdit" type="text" value="Heera Jayachandran" disabled></td>
                                                        <td><input class="form-control grantReportEdit" type="text" value="TLF Grants" disabled></td>
                                                        <td><input type="button" class="form-control grantReportEdit masterPicUpdatebtn employeeInput" value="tlf_report_2020.pdf" disabled></td>                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                                                <h4 class="vitals_innerSub">Grant Reports</h4>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-6 col-xl-6 text-right">
                                                <ul class="vitals-links">
                                                    <li><a href="javascript:" class="master_aduser"><i class="fas fa-plus-circle"></i> Add</a></li>
                                                    <li><a href="" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                <table class="table table-hover dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th class="removeArrow"><input class="form-control" type="checkbox"></th>
                                                            <th>Date of Report</th>
                                                            <th>Responsibility</th>
                                                            <th>Comments</th>
                                                            <th>Submitted Report</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input class="form-control" type="checkbox"></td>
                                                            <td>01-11-2019</td>
                                                            <td>Heera Jayachandran</td>
                                                            <td>TLF Grants</td>
                                                            <td><a href="" target="blank">tlf_report_2020.pdf</a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div> -->
                                        
                                    </div>
                                </main>
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

    // Edit Click to remove disabled
    // ---------------------------------------
    $('.summaryEdit').click(function() {
        $(".grantInput").attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    })
    $('.grantLineEditBtn').click(function() {
        $(".grandlineEdit").attr("disabled", false);        
    })
    $('.disbursementEditBtn').click(function() {
        $(".disbursementEdit").attr("disabled", false);        
    })
    $('.grantReportEditBtn').click(function() {
        $(".grantReportEdit").attr("disabled", false);        
    })
</script>
</script>

</html>