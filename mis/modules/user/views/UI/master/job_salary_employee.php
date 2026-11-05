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
                            <?php $this->load->view('UI/master/master_sidemenu.php', array('page' => 'emp_list')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                    <span><a href="<?php echo base_url() . 'index.php/user/user_ui/employee_master'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>Murugan M</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                                    <ul class="vitals-links">
                                        <li class="edit"><a href="javascript:" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/user/user_ui/personal_employee'; ?>">Personal</a></li>
                                            <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/user/user_ui/login_employee'; ?>">Login</a></li>
                                            <li class="tab-slider--triggerform"><a href="">Reporting</a></li>
                                            <li class="tab-slider--triggerform"><a href="">Contacts</a></li>
                                            <li class="tab-slider--triggerform"><a href="">Dependents</a></li>
                                            <li class="tab-slider--triggerform"><a href="">Immigration</a></li>
                                            <li class="tab-slider--triggerform active"><a href="#">Job & Salary</a></li>
                                            <li class="tab-slider--triggerform"><a href="">Bank</a></li>
                                            <li class="tab-slider--triggerform"><a href="">Education</a></li>
                                            <li class="tab-slider--triggerform"><a href="">Languages</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall vital_windowScroll plan-structure-new">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="vitals_innerSub">Designation Details</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="wdt_100">
                                                            <div class="form-group">
                                                                <label>Current Designation</label>
                                                                <select class="form-control employeeInput" disabled>
                                                                    <option>-- Select --</option>
                                                                    <option>Account Manager</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Status</label>
                                                                <select class="form-control employeeInput" disabled>
                                                                    <option>-- Select --</option>
                                                                    <option>Full Time Contract</option>
                                                                </select>
                                                            </div>                                                           
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="wdt_100">
                                                            <div class="form-group">
                                                                <label>Department</label>
                                                                <select class="form-control employeeInput" disabled>
                                                                    <option>-- Select --</option>
                                                                    <option>Account Manager</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Date</label>
                                                                <input placeholder="12-04-2018" class="form-control employeeInput" disabled>
                                                            </div>
                                                           
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="wdt_100">
                                                            <div class="form-group">
                                                                <label>Job Location</label>
                                                                <select class="form-control employeeInput" disabled>
                                                                    <option>-- Select --</option>
                                                                    <option>VIF, Chennai</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Service as on date</label>
                                                                <ul class="vitals-links">
                                                                    <li>
                                                                        <input placeholder="0" class="form-control employeeInput wdt_80" disabled>
                                                                    </li>
                                                                    <li><span>Year</span></li>
                                                                    <li>&nbsp;&nbsp;</li>
                                                                    <li><input placeholder="0" class="form-control employeeInput wdt_80" disabled></li>
                                                                    <li><span>Months</span></li>
                                                                </ul>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-8">
                                                        <div class="form-group">
                                                                <ul class="vitals-links">
                                                                <li><a href="Javascript:" class="vital_yellow_btn wdt_auto hide_destinationHis display-hide">Hide Designation History</a></li>
                                                                    <li><a href="Javascript:" class="vital_bordered_btn wdt_auto view_destinationHis">View Designation History</a></li>                                                                   
                                                                    <li><a href="javscript:" class="vital_bordered_btn">Revise Designation</a></li> 
                                                                    <li><a href="javscript:" class="vital_yellow_btn">Save</a></li>                                                                   
                                                                </ul>
                                                            </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                    <div class="form-group text-right">
                                                                <a href="#" class="master_deluser designation_His_del mar-vr10 display-hide"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 designation_His_table vitalMasterDataTbl display-hide">
                                                        <table class="table table-hover dt-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th><input class="form-control " type="checkbox"></th>
                                                                    <th>Designation</th>
                                                                    <th>Job Location</th>
                                                                    <th>Date</th>
                                                                    <th>Department</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><input class="form-control " type="checkbox"></td>
                                                                    <td>Accounts Manager</td>
                                                                    <td>VIF, Chennai</td>
                                                                    <td>00-00-0000</td>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>Full Time Contract</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control " type="checkbox"></td>
                                                                    <td>Accounts Manager</td>
                                                                    <td>VIF, Chennai</td>
                                                                    <td>00-00-0000</td>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>Full Time Contract</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="form-control " type="checkbox"></td>
                                                                    <td>Accounts Manager</td>
                                                                    <td>VIF, Chennai</td>
                                                                    <td>00-00-0000</td>
                                                                    <td>Incubation-Energy</td>
                                                                    <td>Full Time Contract</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div style="height:50px"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="vitals_innerSub">Salary Details</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="wdt_100">
                                                            <div class="form-group">
                                                                <label>Current CTC Band</label>
                                                                <select class="form-control employeeInput" disabled>
                                                                    <option>-- Select --</option>
                                                                    <option>2 to 4L</option>
                                                                    <option>5 to 8L</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Date</label>
                                                                <input placeholder="12-04-2018" class="form-control employeeInput" disabled>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="wdt_100">
                                                            <div class="form-group">
                                                                <label>Current Gross Salary</label>
                                                                <input placeholder="Enter Value (Rs.)" class="form-control employeeInput" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Contracted Hours</label>
                                                                <input placeholder="Enter Value (Hrs)" class="form-control employeeInput" disabled>
                                                            </div>                                                           
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="wdt_100">
                                                            <div class="form-group">
                                                                <label>Current Performance Linked Incentive (PLI)</label>
                                                                <input placeholder="Enter Value (Rs.)" class="form-control employeeInput" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Payment per Hours</label>
                                                                <input placeholder="Enter Value (Rs.)" class="form-control employeeInput" disabled>
                                                            </div>
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-8">
                                                        <div class="form-group">
                                                                <ul class="vitals-links">
                                                                <li><a href="javscript:" class="vital_yellow_btn hide_salay_details_btn display-hide">Hide Salary History</a></li>
                                                                    <li><a href="javscript:" class="vital_bordered_btn view_salay_details_btn">View Salary History</a></li>                                                                    
                                                                    <li><a href="javscript:" class="vital_bordered_btn">Revise Salary</a></li>  
                                                                    <li><a href="javscript:" class="vital_yellow_btn">Save</a></li>                                                                                                                                      
                                                                </ul>
                                                            </div>
                                                    </div>
                                                    <div class="col-12  col-md-4">
                                                    <div class="form-group text-right">
                                                                <a href="#" class="master_deluser salary_Details_del mar-vr10 display-hide"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 salary_His_table vitalMasterDataTbl display-hide">
                                                        <table class="table table-hover dt-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th class="removeArrow"><input class="form-control" type="checkbox"></th>
                                                                    <th>Current Gross Salary</th>
                                                                    <th>Current PLI</th>
                                                                    <th>Date</th>
                                                                    <th>Contracted Hours</th>
                                                                    <th>Payment Per Hour</th>
                                                                    <th>Current CTC</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><input class="form-control" type="checkbox"></td>
                                                                    <td>5.0</td>
                                                                    <td>2.00</td>
                                                                    <td>00-00-0000</td>
                                                                    <td>05</td>
                                                                    <td>50.00</td>
                                                                    <td>5 to 8L</td>
                                                                </tr>                                                                
                                                            </tbody>
                                                        </table>
                                                        <div style="height:50px"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="vitals_innerSub">Offer Details</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="wdt_100">
                                                            <div class="form-group">
                                                                <label>Offer Letter Date</label>
                                                                <input placeholder="12-04-2018" class="form-control employeeInput" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Offer Letter Gross Salary</label>
                                                                <input placeholder="Enter Value (Rs.)" class="form-control employeeInput" disabled>
                                                            </div>
                                                            <!-- <div class="form-group">
                                                                <a href="" class="vital_bordered_btn">View Salary History</a>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="wdt_100">
                                                            <div class="form-group">
                                                                <label>Offer Letter Designation</label>
                                                                <input placeholder="Enter Designation" class="form-control employeeInput" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Offer Letter PLI</label>
                                                                <input placeholder="Enter Value (Rs.)" class="form-control employeeInput" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-end">
                                                    <div class="col-12 col-sm-4  col-md-4 ">
                                                        <div class="text-right">
                                                            <ul class="vitals-links saveLinkView display-hide">
                                                                <li><a href="#" class="vital_yellow_btn">Save Job & Salary</a></li>
                                                                <li><a href="#" class="vital_bordered_btn">Reset</a></li> 
                                                            </ul>                                                    
                                                        </div>
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
<script>
    $('table').DataTable();

    $('.view_destinationHis').click(function() {
        $(".view_destinationHis").addClass("display-hide");
        $(".view_destinationHis").removeClass("display-show");
        $('.hide_destinationHis').removeClass("display-hide");
        $('.designation_His_del').removeClass("display-hide");
        $('.designation_His_table').removeClass("display-hide");
        $(".hide_destinationHis").addClass("display-show");
        $('.designation_His_del').addClass("display-show");
        $('.designation_His_table').addClass("display-show");

    });

    $('.hide_destinationHis').click(function() {
        $(".view_destinationHis").addClass("display-show");
        $('.view_destinationHis').removeClass("display-hide");
        $(".hide_destinationHis").addClass("display-hide");
        $('.hide_destinationHis').removeClass("display-show");
        $('.designation_His_del').addClass("display-hide");
        $('.designation_His_del').removeClass("display-show");
        $('.designation_His_table').addClass("display-hide");
        $('.designation_His_table').removeClass("display-show");
    });

    $('.view_salay_details_btn').click(function() {
        $(".view_salay_details_btn").addClass("display-hide");        
        $('.hide_salay_details_btn').removeClass("display-hide");
        $('.hide_salay_details_btn').addClass("display-show");
        $('.salary_Details_del').removeClass("display-hide");
        $('.salary_His_table').removeClass("display-hide");        
        $('.salary_Details_del').addClass("display-show");
        $('.salary_His_table').addClass("display-show");
        $(".view_salay_details_btn").removeClass("display-show");

    });

    $('.hide_salay_details_btn').click(function() {
        $(".hide_salay_details_btn").addClass("display-hide");
        $('.hide_salay_details_btn').removeClass("display-show");
        $(".view_salay_details_btn").addClass("display-show");
        $('.view_salay_details_btn').removeClass("display-hide");
        $('.salary_Details_del').addClass("display-hide");
        $('.salary_Details_del').removeClass("display-show");
        $('.salary_His_table').addClass("display-hide");
        $('.salary_His_table').removeClass("display-show");
    });

   // Window Height
    // ---------------------------------------
    $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 230) + 'px'});
        });

        $('.summaryEdit').click(function(){
            $(".employeeInput").attr("disabled", false);  
            $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
            $('li.edit').addClass("activeTabs");        
            $('li.edit a').addClass("greentab");
            $('.saveLinkView').removeClass("display-hide");
            $('.saveLinkView').addClass("display-show");
        })
</script>

</html>