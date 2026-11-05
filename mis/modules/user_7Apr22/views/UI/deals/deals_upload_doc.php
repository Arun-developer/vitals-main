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
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
</head>

<body>
    <div class="fixed-headervi">
        <?php $this->load->view('UI/header1.php'); ?>
    </div>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">           
            <div class="dataconfig-content page-wrapper vitals_mainContent ">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('UI/deals/deal_sidemenu.php', array('page' => 'view_document')); ?>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                    <span><a href=""><i class="fas fa-angle-left"></i> Back</a></span> <h4>FlyLife - Mail History</h4>
                                </div>
                                
                            </div>
                            <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                        <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/user/user_ui/deals_all_doc'; ?>">All Documents</a></li>                                            
                                            <li class="tab-slider--triggerform active "><a href="<?php echo base_url() . 'index.php/user/user_ui/deals_upload_doc'; ?>">Upload Document</a></li>                                          
                                        </ul>
                                    </div>
                                        
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new vital_windowScroll">
                                                <div class="row leaveLabel">
                                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Document Description</label>
                                                            <input class="form-control" type="text" placeholder="Enter value (Rs.)"disabled>
                                                        </div>
                                                    </div>   
                                                </div>
                                                <div class="row leaveLabel">
                                                <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Upload Document</label>
                                                            <input type="button" class="form-control employeeInput masterPicUpdatebtn" value="Choose file to upload"disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row leaveLabel">
                                                <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div style="height: 15px;"></div>
                                                        <ul class="vitals-links">                                                                                                                        
                                                            <li><a href="" class="vital_yellow_btn pad-hr15 wdt-100">Upload</a></li>    
                                                            <!-- <li><span class="vitals_clearSearch">Clear search</span></li>                                                         -->
                                                        </ul>
                                                    </div> 
                                                </div>
                                                
                                                
                                            </div>
                                        </main>
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
        

        // $('table').DataTable();

         // table row in a table clickable as a link
    // ---------------------------------------

    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
        
       
    </script>
</html>