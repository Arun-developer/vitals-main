<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee - Personal info</title>
    <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/jquery-bootstrap-scrolling-tabs.css'; ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

</head>

<body>
    <div class="fixed-headervi">
        <?php $this->load->view('UI/header1.php'); ?>
    </div>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
            <div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
                <div class="row">

                    <div class="col-lg-3 col-xl-3 col-md-3 col-12">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('UI/master/master_sidemenu.php', array('page' => 'incubation_sectors')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                    <h4>Incubation Master - Sectors</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">

                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div class="tab-slider--container tab-content">
                                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new ">
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 salary_His_table vitalMasterDataTbl">
                                                        <table class="table table-hover dt-responsive">
                                                            <thead>
                                                                <tr>                                                                    
                                                                    <th>Sector</th>
                                                                    <th>Assigned Incharge</th>
                                                                    <th>Lead's</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>'>                                                                    
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>">Agri-business</a></td>
                                                                    <td><p>Ram V</p><p>Srinivas Ramanujam</p><p>Anika Pandey</p></td>
                                                                    <td><p>Ram V</p><p>Srinivas Ramanujam</p></td>
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>'>                                                                    
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>">CleanTech</a></td>
                                                                    <td><p>Ananth Aravamudhan</p><p>Anika Pandey</p></td>
                                                                    <td><p>Ananth Aravamudhan</p></td>
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>'>                                                                    
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>">Education & Employability</a></td>
                                                                    <td><p>Ram V</p><p>Srinivas Ramanujam</p><p>Anika Pandey</p></td>
                                                                    <td><p>Ram V</p><p>Srinivas Ramanujam</p></td>
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>'>                                                                    
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>">Energy & CleanTech</a></td>
                                                                    <td><p>Ananth Aravamudhan</p></td>
                                                                    <td><p>Ananth Aravamudhan</p></td>
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>'>                                                                    
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>">Health</a></td>
                                                                    <td><p>Ram V</p></td>
                                                                    <td><p>Ram V</p></td>
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>'>                                                                    
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>">Waste management</a></td>
                                                                    <td><p>Srinivas Ramanujam</p></td>
                                                                    <td><p>Ram V</p></td>
                                                                </tr>
                                                                <tr class='clickable-row' data-href='<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>'>                                                                    
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/view_sectors'; ?>">Skill Development</a></td>
                                                                    <td><p>Anuja Master</p></td>
                                                                    <td><p>Ram V</p></td>
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



    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-1.9.1.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-bootstrap-scrolling-tabs.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/additional-methods.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.toaster.js'; ?>"></script>
    <script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>


    <script type="text/javascript">
        $(document).ready(function() { 
            $('.vital_windowScroll').css({
                'height': (($(window).height()) - 190) + 'px'
            });
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


</body>

</html>