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
                <div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
                    <div class="row">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('UI/master/master_sidemenu.php', array('page' => 'partner')); ?>
                            </div>
                            <div class="footer-link">
                                <p>copyright &copy; mis.villgroapps.org</p>
                            </div>
                        </div>
                        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                            <main class="page-content">

                                <div class="row dataconfig d_v_d_c">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                        <h4>Partner</h4>
                                    </div>
                                </div>
                                <div class="plan-structure-vital vital_windowScroll">
                                    <div class="row v_m_e_search">
                                        <div class="col-xl-7 col-lg-7 col-md-7 col-12 ">
                                            <ul class="vitals-links">
                                                <li>
                                                    <div class="form-group mar-bt8 wdt_180">
                                                        <select class="form-control wdt_180" >
                                                            <option>Search by</option>
                                                            <option>Partner ID</option>
                                                            <option>Partner Name</option>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="pad-lt15px">
                                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                                        <a href="#" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                                        <input type="text" class="form-control" placeholder="Search">
                                                    </div>
                                                </li>
                                                <li><span class="vitals_clearSearch">Clear search</span></li>
                                            </ul>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
                                            <ul class="vitals-links ">
                                                <li>
                                                    <a href="<?php echo base_url() . 'index.php/user/user_ui/add_partner'; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add Partner</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 salary_His_table vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive">
                                                <thead>
                                                    <tr>
                                                        <th class="removeArrow"></th>
                                                        <th>Partner ID</th>
                                                        <th>Partner Name</th>
                                                        <th>Partner Status</th>                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/add_partner'; ?>'>
                                                        <td><input class="form-control" type="checkbox"></td>
                                                        <td>001</td>
                                                        <td>Villgro India</td>
                                                        <td>Enable</td>                                                        
                                                    </tr>
                                                    <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/add_partner'; ?>'>
                                                        <td><input class="form-control" type="checkbox"></td>
                                                        <td>002</td>
                                                        <td>Villgro Kenya</td>
                                                        <td>Enable</td>                                                        
                                                    </tr>
                                                    <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/add_partner'; ?>'>
                                                        <td><input class="form-control" type="checkbox"></td>
                                                        <td>003</td>
                                                        <td>Menterra</td>
                                                        <td>Enable</td>                                                        
                                                    </tr>
                                                    <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/add_partner'; ?>'>
                                                        <td><input class="form-control" type="checkbox"></td>
                                                        <td>004</td>
                                                        <td>Startup Oasis</td>
                                                        <td>Enable</td>                                                        
                                                    </tr>
                                                    <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/add_partner'; ?>'>
                                                        <td><input class="form-control" type="checkbox"></td>
                                                        <td>005</td>
                                                        <td>IIM Calcutta</td>
                                                        <td>Enable</td>                                                        
                                                    </tr>
                                                    <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/add_partner'; ?>'>
                                                        <td><input class="form-control" type="checkbox"></td>
                                                        <td>006</td>
                                                        <td>KIIT</td>
                                                        <td>Enable</td>                                                        
                                                    </tr>
                                                    <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/add_partner'; ?>'>
                                                        <td><input class="form-control" type="checkbox"></td>
                                                        <td>007</td>
                                                        <td>SIIC, IITK</td>
                                                        <td>Enable</td>                                                        
                                                    </tr>
                                                    <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/add_partner'; ?>'>
                                                        <td><input class="form-control" type="checkbox"></td>
                                                        <td>008</td>
                                                        <td>External Vendors</td>
                                                        <td>Enable</td>                                                        
                                                    </tr>
                                                    <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/add_partner'; ?>'>
                                                        <td><input class="form-control" type="checkbox"></td>
                                                        <td>009</td>
                                                        <td>IIEF</td>
                                                        <td>Enable</td>                                                        
                                                    </tr>
                                                    <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/add_partner'; ?>'>
                                                        <td><input class="form-control" type="checkbox"></td>
                                                        <td>010</td>
                                                        <td>Powering Livelihoods</td>
                                                        <td>Enable</td>                                                        
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
            $('.vital_windowScroll').css({'height': (($(window).height()) - 230) + 'px'});
        });

        $('table').DataTable();

        
        // table row in a table clickable as a link
        // ---------------------------------------

        jQuery(document).ready(function ($) {
            $(".clickable-row").click(function () {
                window.location = $(this).data("href");
            });
        });
    </script>

</html>