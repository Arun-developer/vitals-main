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
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/jquery-bootstrap-scrolling-tabs.css'; ?>">
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
                                    <span><a href="<?php echo base_url() . 'index.php/user/user_ui/employee_master'; ?>"><i class="fas fa-angle-left"></i> Back </a></span> <h4>Murugan M</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                                    <ul class="vitals-links">
                                        <li class="edit"><a href="javascript:" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                        <li class="color_disabled">Select user </li>
                                        <li>
                                            <div class="form-group mar-bt0 color_disabled">
                                                <select class="form-control" disabled>
                                                    <option>-- Select --</option>
                                                    <option>Employee</option>
                                                </select>
                                            </div>
                                        </li>
                                    </ul>                                   
                                </div>
                            </div>    
                            <div class="plan-structure-vital vital_windowScroll">                        
                            <div>
                                    <div class="newCLickTabs">
                                        <div>                                    
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/personal_employee'; ?>">Personal</a></li>
                                        <li role="presentation" ><a href="<?php echo base_url() . 'index.php/user/user_ui/login_employee'; ?>">Login</a></li>
                                        <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Reporting</a></li>
                                        <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">Contacts</a></li>
                                        <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Dependents</a></li>
                                        <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Immigration</a></li>
                                        <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/job_salary_employee'; ?>">Job & Salary</a></li>
                                        <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">Bank</a></li>
                                        <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Education</a></li>
                                        <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Languages</a></li>
                                    </ul>
                                </div>
                                    </div>
                            </div>
                            <div class="tab-slider--container tab-content">
                                <div  class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                    <main class="page-content">
                                        <div class="inputplan-structureall plan-structure-new vital_windowScroll">
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="wdt_100">
                                                        <div class="form-group display-flex align-bottom">
                                                            <div class="profilePicMaster">
                                                                <img src="https://i.pinimg.com/564x/04/56/86/0456869906dfa906c494b2b63aa67f2a.jpg" class="img-fluid">
                                                            </div>
                                                            <div class="masterPicUpdate">
                                                            <label>Profile Picture</label>
                                                            <input type="button" disabled class="form-control employeeInput masterPicUpdatebtn"  value="Upload/Change Picture" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Full Name <span>*</span></label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="Manas" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Date of Birth</label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="22-11-1990" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Blood Group</label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="B +ve" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Experience</label>
                                                            <select class="form-control employeeInput" disabled>
                                                                <option>5 to 10 </option>
                                                                <option>10 to 15 </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Insurance No</label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Driving License Number</label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Any Details of Illness</label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="wdt_100">
                                                        <div class="form-group hgt-100v ">
                                                            <label>Employee Type <span>*</span></label>
                                                            <select class="form-control employeeInput" disabled>
                                                                <option>Employee</option>                                                                
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Middle Name</label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Age</label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="40" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Maritial Status </label>
                                                            <select class="form-control employeeInput" disabled>
                                                                <option>Married</option> 
                                                                <option>Unmarried</option>                                                                 
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Source of Hiring</label>
                                                            <select class="form-control employeeInput" disabled>
                                                                <option>Linked</option> 
                                                                <option>Facebook</option>                                                                 
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>UAN Number</label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>License Expiry date</label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Hobbies</label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="wdt_100">
                                                        <div class="form-group hgt-100v ">
                                                            <label>Employee Id</label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="028" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Last Name <span>*</span></label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Gender </label>
                                                            <select class="form-control employeeInput" disabled>
                                                                <option>Male</option> 
                                                                <option>Female</option>                                                                 
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nationality</label>
                                                            <select class="form-control employeeInput" disabled>
                                                                <option>Indian</option>                                                                                                                                 
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Military Service</label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>PAN Number </label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>If Organ Donor Details</label>
                                                            <input type="text" class="form-control employeeInput" disabled placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                            <div class="col-12 col-sm-4  col-md-4 ">
                                                <div class="text-right">
                                                    <ul class="vitals-links saveLinkView display-hide">
                                                        <li><a href="#" class="vital_yellow_btn">Save Personal Details</a></li>
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
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-bootstrap-scrolling-tabs.js'; ?>"></script>
<script>
    $('table').DataTable();

    $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 230) + 'px'});
        });

        $('.summaryEdit').click(function(){
        $(".employeeInput").attr("disabled", false);        
        $('li.edit').addClass("activeTabs");        
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    })

    (function() {
        'use strict';
        $(activate);
        function activate() {
            $('.nav-tabs')
                .scrollingTabs({
                    enableSwiping: true
                })
                .on('ready.scrtabs', function() {
                    $('.tab-content').show();
                });
        }
    }());
</script>

</html>