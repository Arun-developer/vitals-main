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
                <div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
                    <div class="row">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
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
                                        <h4> Leave Request for Anika Pandey</h4>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right pad-none">
                                        
                                    </div>
                                </div>
                                <div class="plan-structure-vital vital_windowScroll">                                 
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Leave Type</th>
                                                        <th>Day</th>
                                                        <th>Status</th>
                                                        <th>Duration(hours)	</th>
                                                        <th>Comments</th>                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>2017-07-11</td>
                                                        <td>Maternity</td>
                                                        <td>Tuesday</td>
                                                        <td>Closed</td>
                                                        <td>24.00</td>                                                        
                                                        <td><input type="text" class="form-control" value="Maternity Leave..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2017-07-11</td>
                                                        <td>Maternity</td>
                                                        <td>Tuesday</td>
                                                        <td>Closed</td>
                                                        <td>24.00</td>                                                        
                                                        <td><input type="text" class="form-control" value="Maternity Leave..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2017-07-11</td>
                                                        <td>Maternity</td>
                                                        <td>Tuesday</td>
                                                        <td>Closed</td>
                                                        <td>24.00</td>                                                        
                                                        <td><input type="text" class="form-control" value="Maternity Leave..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2017-07-11</td>
                                                        <td>Maternity</td>
                                                        <td>Tuesday</td>
                                                        <td>Closed</td>
                                                        <td>24.00</td>                                                        
                                                        <td><input type="text" class="form-control" value="Maternity Leave..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2017-07-11</td>
                                                        <td>Maternity</td>
                                                        <td>Tuesday</td>
                                                        <td>Closed</td>
                                                        <td>24.00</td>                                                        
                                                        <td><input type="text" class="form-control" value="Maternity Leave..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2017-07-11</td>
                                                        <td>Maternity</td>
                                                        <td>Tuesday</td>
                                                        <td>Closed</td>
                                                        <td>24.00</td>                                                        
                                                        <td><input type="text" class="form-control" value="Maternity Leave..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2017-07-11</td>
                                                        <td>Maternity</td>
                                                        <td>Tuesday</td>
                                                        <td>Closed</td>
                                                        <td>24.00</td>                                                        
                                                        <td><input type="text" class="form-control" value="Maternity Leave..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2017-07-11</td>
                                                        <td>Maternity</td>
                                                        <td>Tuesday</td>
                                                        <td>Closed</td>
                                                        <td>24.00</td>                                                        
                                                        <td><input type="text" class="form-control" value="Maternity Leave..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2017-07-11</td>
                                                        <td>Maternity</td>
                                                        <td>Tuesday</td>
                                                        <td>Closed</td>
                                                        <td>24.00</td>                                                        
                                                        <td><input type="text" class="form-control" value="Maternity Leave..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2017-07-11</td>
                                                        <td>Maternity</td>
                                                        <td>Tuesday</td>
                                                        <td>Closed</td>
                                                        <td>24.00</td>                                                        
                                                        <td><input type="text" class="form-control" value="Maternity Leave..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2017-07-11</td>
                                                        <td>Maternity</td>
                                                        <td>Tuesday</td>
                                                        <td>Closed</td>
                                                        <td>24.00</td>                                                        
                                                        <td><input type="text" class="form-control" value="Maternity Leave..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2017-07-11</td>
                                                        <td>Maternity</td>
                                                        <td>Tuesday</td>
                                                        <td>Closed</td>
                                                        <td>24.00</td>                                                        
                                                        <td><input type="text" class="form-control" value="Maternity Leave..."></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2017-07-11</td>
                                                        <td>Maternity</td>
                                                        <td>Tuesday</td>
                                                        <td>Closed</td>
                                                        <td>24.00</td>                                                        
                                                        <td><input type="text" class="form-control" value="Maternity Leave..."></td>
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
        $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 200) + 'px'});
        });

        $('table').DataTable();
    </script>

</html>