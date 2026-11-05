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
                                <?php $this->load->view('UI/master/master_sidemenu.php', array('page' => 'holiday')); ?>
                            </div>
                            <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                        </div>
                        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                            <main class="page-content">
                                <div class="row dataconfig d_v_d_c">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                        <h4>Holiday Details</h4>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                                        <ul class="vitals-links">
                                            <!-- <li><a href="" class="edt_btnVital"><i class="fas fa-eye"></i> View Calendar</a></li> -->
                                            <li><a href="<?php echo base_url() . 'index.php/user/user_ui/add_holiday'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a></li>
                                            <li><a href="" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="plan-structure-vital vital_windowScroll">
                                    <div>
                                        <div class="tab-slider--navform">
                                            <ul class="tab-slider--tabsform">
                                                <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>">Holiday Calendar-Current</a></li>
                                                <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/user/user_ui/archive_holiday_calendar'; ?>">Holiday Calendar-Archive</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-slider--container">
                                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                            <main class="page-content">
                                                <div class="inputplan-structureall plan-structure-new">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                            <table class="table table-hover dt-responsive">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="removeArrow"><input class="form-control" type="checkbox"></th>
                                                                        <th>Name of Holiday</th>
                                                                        <th>Date</th>
                                                                        <th>Full Day/Half Day</th>
                                                                        <th>Repeat Anually</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr >
                                                                        <td><input class="form-control" type="checkbox"></td>
                                                                        <td>New Year</td>
                                                                        <td>01-01-2020</td>
                                                                        <td>Full Day</td>
                                                                        <td>Yes</td>
                                                                    </tr>
                                                                    <tr >
                                                                        <td><input class="form-control" type="checkbox"></td>
                                                                        <td>New Year</td>
                                                                        <td>01-01-2020</td>
                                                                        <td>Full Day</td>
                                                                        <td>Yes</td>
                                                                    </tr>
                                                                    <tr >
                                                                        <td><input class="form-control" type="checkbox"></td>
                                                                        <td>New Year</td>
                                                                        <td>01-01-2020</td>
                                                                        <td>Full Day</td>
                                                                        <td>Yes</td>
                                                                    </tr>
                                                                    <tr >
                                                                        <td><input class="form-control" type="checkbox"></td>
                                                                        <td>New Year</td>
                                                                        <td>01-01-2020</td>
                                                                        <td>Full Day</td>
                                                                        <td>Yes</td>
                                                                    </tr>
                                                                    <tr >
                                                                        <td><input class="form-control" type="checkbox"></td>
                                                                        <td>New Year</td>
                                                                        <td>01-01-2020</td>
                                                                        <td>Full Day</td>
                                                                        <td>Yes</td>
                                                                    </tr>
                                                                    <tr >
                                                                        <td><input class="form-control" type="checkbox"></td>
                                                                        <td>New Year</td>
                                                                        <td>01-01-2020</td>
                                                                        <td>Full Day</td>
                                                                        <td>Yes</td>
                                                                    </tr>
                                                                    <tr >
                                                                        <td><input class="form-control" type="checkbox"></td>
                                                                        <td>New Year</td>
                                                                        <td>01-01-2020</td>
                                                                        <td>Full Day</td>
                                                                        <td>Yes</td>
                                                                    </tr>
                                                                    <tr >
                                                                        <td><input class="form-control" type="checkbox"></td>
                                                                        <td>New Year</td>
                                                                        <td>01-01-2020</td>
                                                                        <td>Full Day</td>
                                                                        <td>Yes</td>
                                                                    </tr>
                                                                    <tr >
                                                                        <td><input class="form-control" type="checkbox"></td>
                                                                        <td>New Year</td>
                                                                        <td>01-01-2020</td>
                                                                        <td>Full Day</td>
                                                                        <td>Yes</td>
                                                                    </tr>
                                                                    <tr >
                                                                        <td><input class="form-control" type="checkbox"></td>
                                                                        <td>New Year</td>
                                                                        <td>01-01-2020</td>
                                                                        <td>Full Day</td>
                                                                        <td>Yes</td>
                                                                    </tr>
                                                                    <tr >
                                                                        <td><input class="form-control" type="checkbox"></td>
                                                                        <td>New Year</td>
                                                                        <td>01-01-2020</td>
                                                                        <td>Full Day</td>
                                                                        <td>Yes</td>
                                                                    </tr>
                                                                    <tr >
                                                                        <td><input class="form-control" type="checkbox"></td>
                                                                        <td>New Year</td>
                                                                        <td>01-01-2020</td>
                                                                        <td>Full Day</td>
                                                                        <td>Yes</td>
                                                                    </tr>
                                                                    <tr >
                                                                        <td><input class="form-control" type="checkbox"></td>
                                                                        <td>New Year</td>
                                                                        <td>01-01-2020</td>
                                                                        <td>Full Day</td>
                                                                        <td>Yes</td>
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
    <script>
        $('table').DataTable();
        // Window Height
    // ---------------------------------------
    $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 230) + 'px'});
        });
    </script>

</html>