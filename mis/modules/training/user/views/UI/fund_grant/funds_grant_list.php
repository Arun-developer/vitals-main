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
                            <li><a href="<?php echo base_url() . 'index.php/user/user_ui/apply_leave'; ?>"><i class="fas fa-sync-alt"></i> Requests</a></li>
                            <li><a href=""><i class="far fa-check-square"></i> Approve</a></li>
                            <li><a href=""><i class="far fa-chart-bar"></i> Portfolio</a></li>
                            <li><a href=""><i class="fas fa-archive"></i> Resources</a></li>
                            <li class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/funds_grant_list'; ?>"><i class="fas fa-hand-holding-usd"></i> Funds/Grants</a></li>
                            <li><a href=""><i class="fas fa-suitcase"></i> Reports</a></li>
                            <li><a href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>"><i class="fas fa-user-friends"></i> Master's</a></li>
                        </ul>
                    </div>
                </div>
            </div> 
            <div class="dataconfig-content page-wrapper vitals_mainContent ">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
                        <div id="leftMenuLoad">
                        <?php $this->load->view('UI/fund_grant/fund_grant_sidemenu.php', array('page' => 'summary')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                    <h4>Funds/Grants</h4>
                                </div>                                
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">                                
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <div class="row leaveLabel">
                                                    <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                                        <ul class="vitals-links">
                                                            <li>
                                                                <div class="form-group mar-bt8 wdt_180">
                                                                    <select class="form-control wdt_180">
                                                                        <option>Search by</option>
                                                                        <option>Funder</option>
                                                                        <option>Grant ID</option>
                                                                        <option>Start Date</option>
                                                                        <option>End Date</option>
                                                                        <option>Grant Amount</option>
                                                                        <option>Amount Received</option>
                                                                        <option>Total Utilised</option>
                                                                        <option>Grant Status</option>
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
                                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4 text-right">   

                                                        <ul class="vitals-links">
                                                        <li><a href="javascript:" class="master_aduser"><span><i class="fas fa-download"></i></span> Export</a></li>
                                                            <li>
                                                        <a href="#" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a>   </li>                                                      
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                        <table class="table table-hover dt-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th class="removeArrow"><input class="form-control" type="checkbox"></th>
                                                                    <th>Funder</th>
                                                                    <th>Grant ID</th>
                                                                    <th>Start Date</th>
                                                                    <th>End Date</th>
                                                                    <th>Grant Amount (INR)</th>
                                                                    <th>Amount Received (INR)</th>
                                                                    <th>Total Utilised (INR)</th>
                                                                    <th>Grant Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="selectedOne">
                                                                <td><input class="form-control" type="checkbox"></td>
                                                                    <td><a class="tlf_row1" href="javascript:"><i class="fas fa-caret-down"></i></a></td>
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/donor_information'; ?>">TLF(3)</a></td>
                                                                    <td><span class="clr_gray">Type:</span> Foundation</td>
                                                                    <td><span class="clr_gray">FCRA Status</span> FCRA</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    
                                                                </tr>
                                                                <tr class="display-none tlf_1">
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>TLF</td>
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/grants_details'; ?>">FY112019-102022</a></td>
                                                                    <td>01-11-2019</td>
                                                                    <td>30-10-2022</td>
                                                                    <td>1,20,00,000</td>
                                                                    <td>70,00,000</td>
                                                                    <td>35,00,000</td>
                                                                    <td>Open</td>
                                                                </tr>
                                                                <tr class="display-none tlf_1">
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>TLF</td>
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/grants_details'; ?>">FY112019-102022</a></td>
                                                                    <td>01-11-2019</td>
                                                                    <td>30-10-2022</td>
                                                                    <td>1,20,00,000</td>
                                                                    <td>70,00,000</td>
                                                                    <td>35,00,000</td>
                                                                    <td>Open</td>
                                                                </tr>
                                                                <tr class="display-none tlf_1">
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>TLF</td>
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/grants_details'; ?>">FY112019-102022</a></td>
                                                                    <td>01-11-2019</td>
                                                                    <td>30-10-2022</td>
                                                                    <td>1,20,00,000</td>
                                                                    <td>70,00,000</td>
                                                                    <td>35,00,000</td>
                                                                    <td>Open</td>
                                                                </tr>
                                                                <tr class="selectedTwo">
                                                                <td><input class="form-control" type="checkbox"></td>
                                                                    <td><a class="tlf_row2" href="javascript:"><i class="fas fa-caret-down"></i></a></td>
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/donor_information'; ?>">TLF(3)</a></td>
                                                                    <td><span class="clr_gray">Type:</span> Foundation</td>
                                                                    <td><span class="clr_gray">FCRA Status</span> FCRA</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    
                                                                </tr>
                                                                <tr class="display-none tlf_2">
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>TLF</td>
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/grants_details'; ?>">FY112019-102022</a></td>
                                                                    <td>01-11-2019</td>
                                                                    <td>30-10-2022</td>
                                                                    <td>1,20,00,000</td>
                                                                    <td>70,00,000</td>
                                                                    <td>35,00,000</td>
                                                                    <td>Open</td>
                                                                </tr>
                                                                <tr class="display-none tlf_2">
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>TLF</td>
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/grants_details'; ?>">FY112019-102022</a></td>
                                                                    <td>01-11-2019</td>
                                                                    <td>30-10-2022</td>
                                                                    <td>1,20,00,000</td>
                                                                    <td>70,00,000</td>
                                                                    <td>35,00,000</td>
                                                                    <td>Open</td>
                                                                </tr>
                                                                <tr class="display-none tlf_2">
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>TLF</td>
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/grants_details'; ?>">FY112019-102022</a></td>
                                                                    <td>01-11-2019</td>
                                                                    <td>30-10-2022</td>
                                                                    <td>1,20,00,000</td>
                                                                    <td>70,00,000</td>
                                                                    <td>35,00,000</td>
                                                                    <td>Open</td>
                                                                </tr>
                                                                <tr class="selectedThree">
                                                                <td><input class="form-control" type="checkbox"></td>
                                                                    <td><a class="tlf_row3" href="javascript:"><i class="fas fa-caret-down"></i></a></td>
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/donor_information'; ?>">TLF(3)</a></td>
                                                                    <td><span class="clr_gray">Type:</span> Foundation</td>
                                                                    <td><span class="clr_gray">FCRA Status</span> FCRA</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    
                                                                </tr>
                                                                <tr class="display-none tlf_3">
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>TLF</td>
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/grants_details'; ?>">FY112019-102022</a></td>
                                                                    <td>01-11-2019</td>
                                                                    <td>30-10-2022</td>
                                                                    <td>1,20,00,000</td>
                                                                    <td>70,00,000</td>
                                                                    <td>35,00,000</td>
                                                                    <td>Open</td>
                                                                </tr>
                                                                <tr class="display-none tlf_3">
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>TLF</td>
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/grants_details'; ?>">FY112019-102022</a></td>
                                                                    <td>01-11-2019</td>
                                                                    <td>30-10-2022</td>
                                                                    <td>1,20,00,000</td>
                                                                    <td>70,00,000</td>
                                                                    <td>35,00,000</td>
                                                                    <td>Open</td>
                                                                </tr>
                                                                <tr class="display-none tlf_3">
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>TLF</td>
                                                                    <td><a href="<?php echo base_url() . 'index.php/user/user_ui/grants_details'; ?>">FY112019-102022</a></td>
                                                                    <td>01-11-2019</td>
                                                                    <td>30-10-2022</td>
                                                                    <td>1,20,00,000</td>
                                                                    <td>70,00,000</td>
                                                                    <td>35,00,000</td>
                                                                    <td>Open</td>
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>    
    <script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
     
    <script>
         $(document).ready(function () {
            $(".tlf_row1").click(function(){
               var activeClass= $(this).closest('tr').attr('class');
                $(".tlf_1").toggle(); 
                $('.selectedOne').addClass('active') ;
                if(activeClass=='selectedOne active'){
                    $('.selectedOne').removeClass('active') ;
                }        
            });
            $(".tlf_row2").click(function(){   
                var activeClass= $(this).closest('tr').attr('class');             
                $(".tlf_2").toggle(); 
                $('.selectedTwo').addClass('active') ;
                if(activeClass=='selectedTwo active'){
                    $('.selectedTwo').removeClass('active') ;
                }                 
            });
            $(".tlf_row3").click(function(){  
                var activeClass= $(this).closest('tr').attr('class');              
                $(".tlf_3").toggle(); 
                $('.selectedThree').addClass('active') ;
                if(activeClass=='selectedThree active'){
                    $('.selectedThree').removeClass('active') ;
                }                 
            });
       });

        $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 230) + 'px'});
        });

        $('table').DataTable({
            "columns": [ { "width": "15%" }, { "width": "10%" }, { "width": "10%" }, { "width": "10%" }, { "width": "10%" }, { "width": "12%" }, { "width": "8%" }, { "width": "15%" } ],
        });

        // table row in a table clickable as a link
        // ---------------------------------------       

       

       
    </script>

</html>