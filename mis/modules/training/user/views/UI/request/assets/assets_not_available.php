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
                            <?php $this->load->view('UI/request/request_sidemenu.php', array('page' => 'assets_not_available')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                    <h4>Assets Not Available</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                                    
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <div class="row leaveLabel">
                                                
                                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Asset Type</label>
                                                            <select class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="3">Datacard</option>
                                                            <option value="2">Laptop</option>
                                                            <option value="4">Mobile</option>
                                                            <option value="923">Software</option>
                                                                    <option value="172">Electrical equipments</option>
                                                            <option value="174">Furnitures &amp; Fixtures</option>
                                                            <option value="173">Office equipments</option>
                                                            <option value="537">Voice Recorder</option>                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Asset Number</label>
                                                            <input class="form-control" type="text" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Asset Name</label>
                                                            <input class="form-control" type="text" placeholder="">
                                                        </div>
                                                    </div>

                                                    
                                                       
                                                </div>
                                                <div class="row leaveLabel">
                                                <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Asset code</label>
                                                            <input class="form-control" type="text" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div style="height: 15px;"></div>
                                                        <ul class="vitals-links">                                                                                                                        
                                                            <li><a href="" class="vital_yellow_btn pad-hr15">Search</a></li>    
                                                            <!-- <li><span class="vitals_clearSearch">Clear search</span></li>                                                         -->
                                                        </ul>
                                                    </div>
                                                </div> 
                                                <div class="row leaveLabel">                                                
                                                    <div class="col-12 col-md-12 col-lg-12 col-xl-12 text-right">                                                        
                                                        <ul class="vitals-links"> 
                                                        <li><a href="javascript:" class="master_aduser" data-toggle="modal" data-target="#printModal"><span><i class="fas fa-print"></i></span> Print</a></li>                                                                                                                                         
                                                            <li><a href="" class="master_aduser"><span><i class="fas fa-download"></i></span> Export</a></li>
                                                            <li><a href="javascript:" data-toggle="modal" data-target="#AvailableModel" class="master_aduser">Available</a></li>                                                           
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                        <table class="table table-hover dt-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>Asset Type</th>
                                                                    <th>Asset Number</th>
                                                                    <th>Asset Name</th>
                                                                    <th>Asset code</th>
                                                                    <th>Status</th>
                                                                    <th>Reason</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>Office equipments </td>
                                                                    <td>AST/0327</td>
                                                                    <td>Samsung Laptop 530u4c-so4 J9vF9IFCB00264  	</td>
                                                                    <td>VIF/COM/Dest/001 </td>
                                                                    <td>Not Working  </td>
                                                                    <td>Several Services Done¬ Work </td>
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
    <div class="modal" id="AvailableModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation Box</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="container-fluid">
                        <div class="row leaveLabel">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group text-left">
                                    
                                    <label >Are you sure want to make this asset as Available?</label>
                                   
                                    
                                </div>
                            </div>
                        </div>
                        <div style="height:15px"></div>
                        <div class="row ">
                            <div class="col-12 col-sm-12  col-md-12 text-left ">
                                <ul class="vitals-links">
                                    <li><a href="javascript:" data-toggle="modal" data-target="#approveSuccessModel" id="closeModal" class="vital_yellow_btn wdt-100">Confirm</a></li>
                                    <li><a href="javascript:" data-dismiss="modal" aria-label="Close" class="vital_bordered_btn wdt-100">Cancel</a></li>
                                </ul>
                            </div>
                        </div>
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

        $('table').DataTable();

         // table row in a table clickable as a link
    // ---------------------------------------

    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
        
       
    </script>

</html>