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
                            <?php $this->load->view('UI/request/request_sidemenu.php', array('page' => 'assets_transaction')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                    <h4>Transaction Histroy</h4>
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
                                                                <option>Select</option>
                                                                <option>Datacard</option>
                                                                <option>Laptop</option>
                                                                <option>Mobile</option>                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Employee</label>
                                                            <select class="form-control">
                                                        <option value="">Select</option>
                                                            <option value="USR293">
                                                        Abhijit Sathe (IITK)            </option>
                                                            <option value="USR291">
                                                        Aditya Jahagirdar            </option>
                                                            <option value="USR272">
                                                        Ananth Aravamudhan            </option>
                                                            <option value="USR271">
                                                        Anika Pandey            </option>
                                                            <option value="USR252">
                                                        Anuja Master            </option>
                                                            <option value="USR180">
                                                        Bangalore VIF            </option>
                                                            <option value="USR325">
                                                        Beyond Capital            </option>
                                                            <option value="USR306">
                                                        Bhargava KC            </option>
                                                            <option value="USR231">
                                                        Binu Mathews            </option>
                                                            <option value="USR032">
                                                        Chakravarthy A.B            </option>
                                                            <option value="USR179">
                                                        Daphne Salinas Rodriguez            </option>
                                                            <option value="USR343">
                                                        Deepa VK            </option>
                                                            <option value="USR282">
                                                        Deepanshi Balooni            </option>
                                                            <option value="USR244">
                                                        Gowtham Raju            </option>
                                                            <option value="USR167">
                                                        Hang Vo            </option>
                                                            <option value="USR122">
                                                        Heera Jayachandran            </option>
                                                            <option value="USR251">
                                                        Jenaan Lilani            </option>
                                                            <option value="USR297">
                                                        Kavya Agarwal            </option>
                                                            <option value="USR298">
                                                        Kevin Bobby            </option>
                                                            <option value="USR290">
                                                        Malathy M            </option>
                                                            <option value="USR322">
                                                        Meenatshi C            </option>
                                                            <option value="USR318">
                                                        Mehal Poddar            </option>
                                                            <option value="USR224">
                                                        Mohammad Azhar            </option>
                                                            <option value="USR227">
                                                        Mohammad Azhar            </option>
                                                            <option value="USR320">
                                                        Mrinalini V            </option>
                                                            <option value="USR098">
                                                        Mukesh Sharma            </option>
                                                            <option value="USR030">
                                                        Murugan M            </option>
                                                            <option value="USR241">
                                                        Nirupa Rao            </option>
                                                            <option value="USR321">
                                                        Nivvedhitha Shankar            </option>
                                                            <option value="USR305">
                                                        Pankaj Anand            </option>
                                                            <option value="USR043">
                                                        Paul Basil            </option>
                                                            <option value="USR278">
                                                        Praveen Rajan            </option>
                                                            <option value="USR232">
                                                        Ragini Pillai            </option>
                                                            <option value="USR323">
                                                        Ram V            </option>
                                                            <option value="USR229">
                                                        Rama Kannan            </option>
                                                            <option value="USR283">
                                                        Rashi .            </option>
                                                            <option value="USR243">
                                                        Rohit Lalwani            </option>
                                                            <option value="USR315">
                                                        Saipriya Salla            </option>
                                                            <option value="USR308">
                                                        Seraphina Selvanayakom            </option>
                                                            <option value="USR286">
                                                        Shaikh Mobin            </option>
                                                            <option value="USR285">
                                                        Shankha Lahiri            </option>
                                                            <option value="USR317">
                                                        Shoma Bhardwaj            </option>
                                                            <option value="USR292">
                                                        Shreya Agrawal (IITK)            </option>
                                                            <option value="USR289">
                                                        Siddharth Vashist            </option>
                                                            <option value="USR296">
                                                        Soujit Das (IIMCIP)            </option>
                                                            <option value="USR259">
                                                        Srinivas Ramanujam            </option>
                                                            <option value="USR274">
                                                        Sucharita Kamath            </option>
                                                            <option value="USR242">
                                                        Sukriti Somvanshi            </option>
                                                            <option value="USR295">
                                                        Surekha Routray (KIIT)            </option>
                                                            <option value="USR319">
                                                        Swetha Tipparaju            </option>
                                                            <option value="USR284">
                                                        Tanuja Kate            </option>
                                                            <option value="USR326">
                                                        Tanya Agarwal            </option>
                                                            <option value="USR182">
                                                        Thuy Pham            </option>
                                                            <option value="USR294">
                                                        Vaibhav Vashishtha (SO)            </option>
                                                            <option value="USR276">
                                                        Venture Centre, Pune            </option>
                                                            <option value="USR248">
                                                        Vigneshwaran V            </option>
                                                            <option value="USR119">
                                                        Vijitha Panikkar            </option>
                                                            <option value="USR240">
                                                        Vikash Jha            </option>
                                                        <option value="0">Others</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                       
                                                </div>
                                                <div class="row leaveLabel">
                                                <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Asset Number</label>
                                                            <input class="form-control" type="text" placeholder="">
                                                        </div>
                                                    </div>
                                                <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Bill Date</label>
                                                            <input class="form-control" type="text" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>To</label>
                                                            <input class="form-control" type="text" placeholder="">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row leaveLabel">
                                                <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Returned Date</label>
                                                            <input class="form-control" type="text" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>To</label>
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
                                                            <li><a href="javascript:" data-toggle="modal" data-target="#ConfirmationModel" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a></li>                                                           
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                        <table class="table table-hover dt-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>Asset Number</th>
                                                                    <th>Asset Type</th>
                                                                    <th>Asset Name</th>
                                                                    <th>Empolyee Name</th>
                                                                    <th>Issue Date</th>
                                                                    <th>Return Date</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
                                                                </tr>
                                                                <tr>
                                                                <td class="sorting_1"><input class="form-control" type="checkbox"></td>
                                                                    <td>AST/0001</td>
                                                                    <td>Laptop</td>
                                                                    <td>Samsung Desktop LCD	</td>
                                                                    <td>Monika Khullar	</td>
                                                                    <td>09/02/2011</td>
                                                                    <td>10/02/2011</td>
                                                                    <td>Returned</td>
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
    <div class="modal" id="ConfirmationModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
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
                                    
                                    <label >Are you sure want to delete?</label>
                                   
                                    
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