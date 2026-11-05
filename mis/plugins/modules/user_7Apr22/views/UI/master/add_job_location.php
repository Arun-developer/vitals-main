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
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/responsive_vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>">
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
                            <?php $this->load->view('UI/master/master_sidemenu.php', array('page' => 'job_location')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                    
                                    <span><a href="<?php echo base_url() . 'index.php/user/user_ui/job_location'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                        <h4>Job Location</h4>
                                </div>
                               
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                                    <ul class="vitals-links">                                        
                                        <li class="activeTabs"><a href="Javascript:" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add Job Location</a></li>                                        
                                        <li><a href="" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <main class="page-content">
                                    <div class="inputplan-structureall plan-structure-new">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="vitals_innerSub">Add Jobs Location</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Location Id</label>
                                                    <input type="text" class="form-control" value="JOB003" disabled />
                                                </div>
                                                <div class="form-group">
                                                    <label>Location Name <span>*</span></label>
                                                    <input type="text" class="form-control"  placeholder="Enter Location Name " />
                                                </div>    
                                                <div class="form-group">
                                                    <label>Country <span>*</span></label>
                                                    <select class="form-control">
                                                        <option>India</option>                                                        
                                                    </select>
                                                </div>                                                     
                                                <div class="form-group">
                                                    <label>Address <span>*</span></label>
                                                    <textarea rows="3" class="form-control" placeholder="Enter Address"></textarea>
                                                </div> 
                                                <div class="form-group">
                                                    <label>Comments</label>
                                                    <textarea rows="3" class="form-control" placeholder="Enter Comments"></textarea>
                                                </div>                                                
                                            </div>    
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group hide-mob">
                                                    <label>&nbsp;</label>
                                                    <input type="text" class="form-control display-unvisible" />
                                                </div>
                                                <div class="form-group hide-mob">
                                                    <label>&nbsp;</label>
                                                    <input type="text" class="form-control display-unvisible" />
                                                </div>
                                                <div class="form-group">
                                                    <label>State / Province</label>
                                                    <input type="text" class="form-control"  placeholder="Enter State / Province" />
                                                </div>                                                        
                                                <div class="form-group">
                                                    <label>ZIP Code	<span>*</span></label>
                                                    <input type="text" class="form-control"  placeholder="Enter ZIP Code" />
                                                </div>                                                
                                            </div> 
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group hide-mob">
                                                    <label>&nbsp;</label>
                                                    <input type="text" class="form-control display-unvisible"  />
                                                </div>
                                                <div class="form-group hide-mob">
                                                    <label>&nbsp;</label>
                                                    <input type="text" class="form-control display-unvisible" />
                                                </div>
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" class="form-control"  placeholder="Enter City" />
                                                </div> 
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="text" class="form-control"  placeholder="Enter Phone Number" />
                                                </div>
                                            </div>                                               
                                        </div>
                                        <div class="row justify-content-end">
                                            <div class="col-12 col-sm-4  col-md-4 ">
                                                <div class="text-right">
                                                    <ul class="vitals-links">
                                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/job_location'; ?>" class="vital_yellow_btn">Save Job Location</a></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/job_location'; ?>" class="vital_bordered_btn">Cancel</a></li> 
                                                    </ul>                                                    
                                                </div>
                                            </div>
                                        </div>
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
<script>
    // Window Height
    // ---------------------------------------
    $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 230) + 'px'});
        });
</script>


</html>