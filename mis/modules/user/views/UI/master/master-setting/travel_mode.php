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
                                    <h4>Master Settings</h4>
                                </div>
                                <div class="col-xl-8 col-lg-8 col-md-12 col-12 text-right">
                                    <ul class="vitals-links">                                    
                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/add_travel_mode'; ?>" class="master_aduser"><span><i class="fas fa-plus-circle"></i></span> Add Master</a></li>                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div>
                                    <div class="newCLickTabs">
                                        <div>
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/balance_sheet'; ?>" >Balance Sheet</a></li>
                                                <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Programme</a></li>
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
                                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <div class="row leaveLabel">                                                    
                                                    <div class="col-xl-7 col-lg-7 col-md-12 col-12 ">                                                        
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
                                                                    <th>Travel Mode</th>
                                                                    <th>Status</th>                                                                   
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>                                                                    
                                                                    <td>Train</i></td>
                                                                    <td><span class="clr_geen"><i class="fas fa-check"></i></span></td>
                                                                    <td><a href="" class="clr_geen"><i class="fas fa-edit"></i></a> <a class="clr_redbtn pad-lt15px" href=""><i class="fas fa-trash"></i></a>  </td>
                                                                </tr> 
                                                                <tr>                                                                    
                                                                    <td>Flight</i></td>
                                                                    <td><span class="clr_geen"><i class="fas fa-check"></i></span></td>
                                                                    <td><a href="" class="clr_geen"><i class="fas fa-edit"></i></a> <a class="clr_redbtn pad-lt15px" href=""><i class="fas fa-trash"></i></a>  </td>
                                                                </tr> 
                                                                <tr>                                                                    
                                                                    <td>Bus</i></td>
                                                                    <td><span class="clr_geen"><i class="fas fa-check"></i></span></td>
                                                                    <td><a href="" class="clr_geen"><i class="fas fa-edit"></i></a> <a class="clr_redbtn pad-lt15px" href=""><i class="fas fa-trash"></i></a>  </td>
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