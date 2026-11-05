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
                            <li class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/apply_leave'; ?>"><i class="fas fa-sync-alt"></i> Requests</a></li>
                            <!-- <li><a href=""><i class="far fa-check-square"></i> Approve</a></li> -->
                            <li><a href=""><i class="far fa-chart-bar"></i> Portfolio</a></li>
                            <li><a href=""><i class="fas fa-archive"></i> Resources</a></li>
                            <li><a href=""><i class="fas fa-suitcase"></i> Reports</a></li>
                            <li><a href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>"><i class="fas fa-user-friends"></i> Master's</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <br>
            <div class="dataconfig-content page-wrapper vitals_mainContent ">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('UI/request/request_sidemenu.php', array('page' => 'new_approval_note')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                    <h4>Approve</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                                    
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <!-- <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/user/user_ui/approve_RO'; ?>">Approve as RO</a></li>                                             -->
                                            <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/user/user_ui/approve_PH'; ?>">Pending Notes</a></li>                                            
                                            <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/user/user_ui/all_pending_AN'; ?>">All Approvel Notes</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <div class="row leaveLabel">                                                
                                                    <div class="col-12 col-md-12 col-lg-2 col-xl-2">
                                                        <div class="form-group">
                                                            <label>Approval Number</label>
                                                            <input class="form-control" type="text" placeholder="Enter here">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-3 col-xl-3">
                                                        <div class="form-group">
                                                            <label>Purpose</label>
                                                            <input class="form-control" type="text" placeholder="Enter Purpose">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div style="height: 5px;"></div>
                                                        <ul class="vitals-links">                                                                                                                        
                                                            <li><a href="" class="vital_yellow_btn pad-hr15">Search</a></li>    
                                                            <!-- <li><span class="vitals_clearSearch">Clear search</span></li>                                                         -->
                                                        </ul>
                                                    </div>  
                                                    <div class="col-12 col-md-12 col-lg-3 col-xl-3 text-right">
                                                    <div style="height: 15px;"></div>
                                                    <ul class="vitals-links"> 
                                                        <li><a href="javascript:" class="master_aduser" data-toggle="modal" data-target="#printModal"><span><i class="fas fa-print"></i></span> Print</a></li>                                                                                                                                         
                                                            <li><a href="" class="master_aduser"><span><i class="fas fa-download"></i></span> Export</a></li>                                                            
                                                        </ul>
                                                    </div>  
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                        <table class="table table-hover dt-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th>Approval<br>Number</th>
                                                                    <th>Employee Name</th>
                                                                    <th>Date of Request</th>
                                                                    <th>Reporting<br>Manager</th>
                                                                    <th>Programme<br>Head</th>
                                                                    <th>Purpose</th>
                                                                    <th>Programme</th>
                                                                    <th>Donor</th>
                                                                    <th>Pending With</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0002</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>Claritaz User</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Test For April FY</td>
                                                                    <td>ANDE</td>
                                                                    <td>ANDE</td>
                                                                    <td>Srinivas Ramanujam (PH)</td>
                                                                    <td>Confirmed</td>
                                                                    
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0002</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>Claritaz User</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Test For April FY</td>
                                                                    <td>ANDE</td>
                                                                    <td>ANDE</td>
                                                                    <td>Srinivas Ramanujam (PH)</td>
                                                                    <td>Confirmed</td>
                                                                    
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0002</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>Claritaz User</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Test For April FY</td>
                                                                    <td>ANDE</td>
                                                                    <td>ANDE</td>
                                                                    <td>Srinivas Ramanujam (PH)</td>
                                                                    <td>Confirmed</td>
                                                                    
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0002</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>Claritaz User</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Test For April FY</td>
                                                                    <td>ANDE</td>
                                                                    <td>ANDE</td>
                                                                    <td>Srinivas Ramanujam (PH)</td>
                                                                    <td>Confirmed</td>
                                                                    
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0002</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>Claritaz User</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Test For April FY</td>
                                                                    <td>ANDE</td>
                                                                    <td>ANDE</td>
                                                                    <td>Srinivas Ramanujam (PH)</td>
                                                                    <td>Confirmed</td>
                                                                    
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0002</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>Claritaz User</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Test For April FY</td>
                                                                    <td>ANDE</td>
                                                                    <td>ANDE</td>
                                                                    <td>Srinivas Ramanujam (PH)</td>
                                                                    <td>Confirmed</td>
                                                                    
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0002</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>Claritaz User</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Test For April FY</td>
                                                                    <td>ANDE</td>
                                                                    <td>ANDE</td>
                                                                    <td>Srinivas Ramanujam (PH)</td>
                                                                    <td>Confirmed</td>
                                                                    
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0002</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>Claritaz User</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Test For April FY</td>
                                                                    <td>ANDE</td>
                                                                    <td>ANDE</td>
                                                                    <td>Srinivas Ramanujam (PH)</td>
                                                                    <td>Confirmed</td>
                                                                    
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0002</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>Claritaz User</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Test For April FY</td>
                                                                    <td>ANDE</td>
                                                                    <td>ANDE</td>
                                                                    <td>Srinivas Ramanujam (PH)</td>
                                                                    <td>Confirmed</td>
                                                                    
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0002</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>Claritaz User</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Test For April FY</td>
                                                                    <td>ANDE</td>
                                                                    <td>ANDE</td>
                                                                    <td>Srinivas Ramanujam (PH)</td>
                                                                    <td>Confirmed</td>
                                                                    
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0002</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>Claritaz User</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Test For April FY</td>
                                                                    <td>ANDE</td>
                                                                    <td>ANDE</td>
                                                                    <td>Srinivas Ramanujam (PH)</td>
                                                                    <td>Confirmed</td>
                                                                    
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0002</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>Claritaz User</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Test For April FY</td>
                                                                    <td>ANDE</td>
                                                                    <td>ANDE</td>
                                                                    <td>Srinivas Ramanujam (PH)</td>
                                                                    <td>Confirmed</td>
                                                                    
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0004</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>01/04/2020 </td>
                                                                    <td>10/05/2020</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Vijitha Panikkar (PH) </td>
                                                                    <td>Check Apr value</td>
                                                                    <td>VIF OH </td>
                                                                    <td>Chennai building Maintenance cost</td>
                                                                    <td>pending </td>
                                                                </tr><tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>' >
                                                                    <td>APN/0002</td>
                                                                    <td>Heera Jayachandran</td>
                                                                    <td>01/04/2020</td>
                                                                    <td>Claritaz User</td>
                                                                    <td>Srinivas Ramanujam</td>
                                                                    <td>Test For April FY</td>
                                                                    <td>ANDE</td>
                                                                    <td>ANDE</td>
                                                                    <td>Srinivas Ramanujam (PH)</td>
                                                                    <td>Confirmed</td>
                                                                    
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
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script><script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <script>
        $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 190) + 'px'});
        });

        $('table').DataTable({
            "scrollX": true,
                "initComplete": function(settings, json) {
                    $('.dataTables_scrollBody thead tr').css({visibility:'collapse'});
                },                             
                "paging": true,
                "ordering": true,              
                "info": false,
                "searching": false,
                "pageLength": 10,
                "lengthChange": false, 
                "responsive": false,
                fixedHeader: {
            header: true,
            headerOffset: 45,
            },

                // scrollY:'288px',                
                "autowidth": true,   
            });

         // table row in a table clickable as a link
    // ---------------------------------------

    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
        
       
    </script>

</html>