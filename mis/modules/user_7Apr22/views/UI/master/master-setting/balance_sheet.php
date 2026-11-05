<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villgro MIS</title>
    <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/responsive_vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/jquery-bootstrap-scrolling-tabs.css'; ?>">
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
                            <li ><a href="<?php echo base_url() . 'index.php/user/user_ui/apply_leave'; ?>"><i class="fas fa-sync-alt"></i> Requests</a></li>
                            <!-- <li><a href=""><i class="far fa-check-square"></i> Approve</a></li> -->
                            <li><a href=""><i class="far fa-chart-bar"></i> Portfolio</a></li>
                            <li><a href=""><i class="fas fa-archive"></i> Resources</a></li>
                            <li><a href=""><i class="fas fa-suitcase"></i> Reports</a></li>
                            <li class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>"><i class="fas fa-user-friends"></i> Master's</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="dataconfig-content page-wrapper vitals_mainContent ">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('UI/master/master_sidemenu.php', array('page' => 'master_setting')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                                    <h4>Budget</h4>
                                </div>
                                <div class="col-xl-8 col-lg-8 col-md-12 col-12 text-right">
                                    <ul class="vitals-links">
                                        <li><a href="javascript:" class="master_aduser" data-toggle="modal" data-target="#printModal"><span><i class="fas fa-print"></i></span> Print</a></li>
                                        <li><a href="javascript:" class="master_aduser" data-toggle="modal" data-target="#exportModal"><span><i class="fas fa-download"></i></span> Export</a></li>
                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/donor_amount'; ?>" class="master_aduser"><span><i class="fas fa-hand-holding-usd"></i></span> Donors Amount</a></li>
                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/action_history'; ?>" class="master_aduser"><span><i class="far fa-file-alt"></i></span> Action History</a></li>
                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/add_balance_sheet_amount'; ?>" class="master_aduser"><span><i class="fas fa-plus-circle"></i></span> Add Amount</a></li>
                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/balance_sheet_report'; ?>" class="master_aduser"><span><i class="far fa-file-alt"></i></span> Report</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div>
                                    <div class="newCLickTabs">
                                        <div>
                                            <!-- <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" ><a href="<?php echo base_url() . 'index.php/user/user_ui/travel_mode'; ?>" >Travel Mode</a></li>
                                                <li role="presentation" ><a href="<?php echo base_url() . 'index.php/user/user_ui/books_category'; ?>" >Books Category</a></li>
                                                <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">General Asset</a></li>
                                                <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">IT Asset</a></li>
                                                <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">Business Card Category</a></li>
                                                <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Utilities Type</a></li>
                                                <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Donor</a></li>
                                                <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">Budget Head</a></li>
                                                <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Line Item</a></li>
                                                <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Additional Info</a></li>
                                                <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/balance_sheet'; ?>" >Balance Sheet</a></li>
                                                <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Financial Year</a></li>
                                                <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Programme</a></li>
                                                <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">Set Admin Email</a></li>
                                            </ul> -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/balance_sheet'; ?>">Balance Sheet</a></li>
                                                <li role="presentation" ><a href="<?php echo base_url() . 'index.php/user/user_ui/programme'; ?>">Programme</a></li>
                                                <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Donor</a></li>
                                                <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">Budget Head</a></li>
                                                <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Line Item</a></li>
                                                <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Additional Info</a></li>
                                                <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Financial Year</a></li>
                                            </ul>
                                        </div>
                                    </div>                                   
                                </div>
                                <div class="tab-slider--container tab-content">
                                    <div  class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <div class="row leaveLabel">
                                                    <div class="col-12 col-sm-2 col-md-2">
                                                        <div class="form-group">
                                                            <label>Financial Year From</label>
                                                            <input class="form-control" type="text" placeholder="2019-12-01">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-2 col-md-2">
                                                        <div class="form-group">
                                                            <label>&nbsp;</label>
                                                            <input class="form-control" type="text" placeholder="2019-12-01">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-7 col-lg-7 col-md-12 col-12 ">
                                                        <label>&nbsp;</label>
                                                        <ul class="vitals-links">
                                                            <li class="pad-lt15px">
                                                                <div class="form-group has-search-right mar-bt8 wdt_180">
                                                                    <a href="#" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                                                    <input type="text" class="form-control" placeholder="Search">
                                                                </div>
                                                            </li>
                                                            <li><span class="vitals_clearSearch">Clear search</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                        <table class="table table-hover dt-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th>Programme</th>
                                                                    <th>Donor</th>
                                                                    <th>Budget Head</th>
                                                                    <th>Line Item</th>
                                                                    <th>Additional Info</th>
                                                                    <th>Assigned Amount (AM)(INR)</th>
                                                                    <th>Approval Notes (AN)(INR)</th>
                                                                    <th>Internal Note (IN)(INR)</th>
                                                                    <th>Recovered Amount (RA)(INR)</th>
                                                                    <th>Available Amount (AM-AN)+RA(INR)</th>
                                                                    <th>Unutilized Amount (AN-IN)(INR)</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>HDFC</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td>0</td>
                                                                    <td><i class="fas fa-download"></i></td>
                                                                </tr> 
                                                                <tr>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>HDFC</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td>0</td>
                                                                    <td><i class="fas fa-download"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>HDFC</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td>0</td>
                                                                    <td><i class="fas fa-download"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>HDFC</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td>0</td>
                                                                    <td><i class="fas fa-download"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>HDFC</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td>0</td>
                                                                    <td><i class="fas fa-download"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>HDFC</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td>0</td>
                                                                    <td><i class="fas fa-download"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>HDFC</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td>0</td>
                                                                    <td><i class="fas fa-download"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>HDFC</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td>0</td>
                                                                    <td><i class="fas fa-download"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>HDFC</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td>0</td>
                                                                    <td><i class="fas fa-download"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>HDFC</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td>0</td>
                                                                    <td><i class="fas fa-download"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>HDFC</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td>0</td>
                                                                    <td><i class="fas fa-download"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>HDFC</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td>0</td>
                                                                    <td><i class="fas fa-download"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>HDFC</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td>Funding to Incubatee</td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>35,00,000</td>
                                                                    <td>0</td>
                                                                    <td><i class="fas fa-download"></i></td>
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


    <!-- Model (Print) -->
    <div class="modal" id="printModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content delete-alert">
                <form method="post" id="Update_channel"  autocomplete="off">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <h4 class="text-center popup_milestone" id="milesTitle">Balance Sheet Print</h4>
                                <div class="col-12">
                                    <input type='hidden' name='edit_innovation_id' id="edit_innovation_id" value="<?= $innovation_id; ?>">
                                    <div>
                                        <p>Report Name </p>
                                        <div class="form-group">
                                            <select class="form-control form-control-sm">
                                                <option>With Amount</option>
                                                <option>Without Amount</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <input type="submit" id="editSubmit" class="btn add-btnconfig brd-rd30 btn-success btn-sm" value="Print">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Model (Print) -->
    <div class="modal" id="printModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content delete-alert">
                <form method="post" id="Update_channel"  autocomplete="off">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <h4 class="text-center popup_milestone" id="milesTitle">Balance Sheet Export</h4>
                                <div class="col-12">
                                    <input type='hidden' name='edit_innovation_id' id="edit_innovation_id" value="<?= $innovation_id; ?>">
                                    <div>
                                        <p>Report Name </p>
                                        <div class="form-group">
                                            <select class="form-control form-control-sm">
                                                <option>With Amount</option>
                                                <option>Without Amount</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <input type="submit" id="editSubmit" class="btn add-btnconfig brd-rd30 btn-success btn-sm" value="Export">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-bootstrap-scrolling-tabs.js'; ?>"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script>
    // Window Height
    // ---------------------------------------
    $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 230) + 'px'});
        });

    $('table').DataTable();

    // table row in a table clickable as a link
    // ---------------------------------------

    
    
    (function() {
        'use strict';
        $(activate);

        function activate() {

            $('.nav-tabs')
                .scrollingTabs({
                    enableSwiping: true
                })
                .on('ready.scrtabs', function() {
                    $('.tab-content').show();
                });
        }
    }());
</script>

</html>