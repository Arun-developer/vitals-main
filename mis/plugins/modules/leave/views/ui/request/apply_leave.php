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
                            <li class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/leave_list'; ?>"><i class="fas fa-sync-alt"></i> Requests</a></li>
                            <!-- <li><a href=""><i class="far fa-check-square"></i> Approve</a></li> -->
                            <li><a href=""><i class="far fa-chart-bar"></i> Portfolio</a></li>
                            <li><a href=""><i class="fas fa-archive"></i> Resources</a></li>
                            <li><a href=""><i class="fas fa-suitcase"></i> Reports</a></li>
                            <li ><a href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>"><i class="fas fa-user-friends"></i> Master's</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="dataconfig-content page-wrapper vitals_mainContent ">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
                        <div id="leftMenuLoad">
                        <?php $this->load->view('UI/request/request_sidemenu.php', array('page' => 'leave')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                    
                                    <span><a href="<?php echo base_url() . 'index.php/user/user_ui/leave_list'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                        <h4>Apply Leave</h4>
                                </div>
                               
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                    <!-- <ul class="vitals-links">                                        
                                        <li class="activeTabs"><a href="Javascript:" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add Job</a></li>                                       
                                        <li><a href="" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a></li>
                                    </ul> -->
                                </div>
                            </div>
                            <div class="plan-structure-vital">
                                <main class="page-content">
                                    <div class="inputplan-structureall plan-structure-new">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="vitals_innerSub ">Apply Leave Request</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Leave Type </label>
                                                    <select class="form-control">
                                                        <option>Select Leave Type</option>
                                                        <option>No Leave Types</option>                                                        
                                                    </select>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="Vital-notes">
                                            <span>Leave Quota not allocated. Please consult HR Admin</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">                                                
                                                <div class="form-group">
                                                    <label>From Date </label>
                                                    <input type="text" class="form-control"  placeholder="YYYY/MM/DD" />
                                                </div>  
                                                <div class="form-group">
                                                    <label>Comments </label>
                                                    <textarea class="form-control" rows="3"></textarea>
                                                </div>                                                                                             
                                            </div>    
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>To Date</label>
                                                    <input type="text" class="form-control"  placeholder="YYYY/MM/DD" />
                                                </div> 
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Full Day/Half Day </label>
                                                    <select class="form-control">
                                                        <option>Select Leave Type</option>
                                                        <option>No Leave Types</option>                                                        
                                                    </select>
                                                </div>                                                  
                                            </div>                                               
                                        </div>
                                        <div class="row ">
                                            <div class="col-12 col-sm-4  col-md-4 ">                                                
                                                <ul class="vitals-links">
                                                    <li><a href="<?php echo base_url() . 'index.php/user/user_ui/job'; ?>" class="vital_yellow_btn">Apply Leave</a></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/user/user_ui/job'; ?>" class="vital_bordered_btn">Cancel</a></li> 
                                                </ul>
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
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>    

</html>