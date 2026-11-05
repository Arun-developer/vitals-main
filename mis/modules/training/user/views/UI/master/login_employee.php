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
                                        <div class="tab-slider--navform">
                                            <ul class="tab-slider--tabsform">
                                                <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/user/user_ui/personal_employee'; ?>">Personal</a></li>
                                                <li class="tab-slider--triggerform active"><a href="#">Login</a></li>
                                                <li class="tab-slider--triggerform "><a href="">Reporting</a></li>
                                                <li class="tab-slider--triggerform "><a href="">Contacts</a></li>
                                                <li class="tab-slider--triggerform "><a href="">Dependents</a></li>
                                                <li class="tab-slider--triggerform "><a href="">Immigration</a></li>
                                                <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/user/user_ui/job_salary_employee'; ?>">Job & Salary</a></li>
                                                <li class="tab-slider--triggerform "><a href="">Bank</a></li>
                                                <li class="tab-slider--triggerform "><a href="">Education</a></li>
                                                <li class="tab-slider--triggerform "><a href="">Languages</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-slider--container">
                                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                            <main class="page-content">
                                                <div class="inputplan-structureall plan-structure-new vital_windowScroll">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-4 col-md-4">
                                                            <div class="wdt_100">
                                                                <div class="form-group">
                                                                    <label>User Code</label>
                                                                    <input type="text" class="form-control" disabled placeholder="USR030" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>User Name <span>*</span></label>
                                                                    <input type="text" class="form-control employeeInput" disabled placeholder="Murugan" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Partner Name <span>*</span></label>
                                                                    <select class="form-control employeeInput" disabled>
                                                                        <option>-- Select --</option>
                                                                        <option>Villgro India</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                    <select class="form-control employeeInput" disabled>
                                                                        <option>Enabled</option>
                                                                        <option>Disabled</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-4 col-md-4">
                                                            <div class="wdt_100">
                                                                <div class="form-group hide-mob">
                                                                    <label>&nbsp;</label>
                                                                    <input type="text" class="form-control display-unvisible" placeholder="" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>New Password</label>
                                                                    <input type="Password" class="form-control employeeInput" disabled placeholder="**********" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>User Role <span>*</span></label>
                                                                    <select class="form-control employeeInput" disabled>
                                                                        <option>-- Select --</option>
                                                                        <option>User</option>
                                                                        <option>Partner Admin</option>
                                                                        <option>Super Admin</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Allow Access Tabs <span>*</span></label>
                                                                    <select class="form-control employeeInput" disabled id="multiselect"  multiple="multiple">
                                                                        <option>Emergency Contact(s)</option>
                                                                        <option>Dependents</option>
                                                                        <option>Immigration</option>
                                                                        <option>Job & Salary</option>
                                                                        <option>Bank</option>
                                                                        <option>Report-to</option>
                                                                        <option>Education</option>
                                                                        <option>Languages</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-4 col-md-4">
                                                            <div class="wdt_100">
                                                                <div class="form-group hide-mob">
                                                                    <label>&nbsp;</label>
                                                                    <input type="text" class="form-control display-unvisible" placeholder="" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Confirm New Password <span>*</span></label>
                                                                    <input type="Password" class="form-control employeeInput" disabled placeholder="**********" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Additional Partner Access</label>
                                                                    <select class="form-control employeeInput" id="accessibleTo" disabled multiple="multiple">
                                                                        <option>Villgro India</option>
                                                                        <option>Villgro Kenya</option>
                                                                        <option>Menterra</option>
                                                                        <option>Startup Oasis</option>
                                                                        <option>IIM Calcutta</option>
                                                                        <option>KIIT</option>
                                                                        <option>SIIC, IITK</option>
                                                                        <option>External Vendors</option>
                                                                        <option>IIEF</option>
                                                                        <option>Powering Livelihoods</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-end">
                                                        <div class="col-12 col-sm-4  col-md-4 ">
                                                            <div class="text-right">
                                                                <ul class="vitals-links saveLinkView display-hide">
                                                                    <li><a href="#" class="vital_yellow_btn">Save Login Details</a></li>
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

    <script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

    <script>
       

        $(document).ready(function () {
            
            $('#multiselect, #accessibleTo').multiselect({
                buttonWidth: '100%',
                includeSelectAllOption: true,
                nonSelectedText: 'Select an Option'
            });

        });

        function getSelectedValues() {
            var selectedVal = $("#multiselect, #accessibleTo").val();
            for (var i = 0; i < selectedVal.length; i++) {
                if (window.CP.shouldStopExecution(0)) break;

                function innerFunc(i) {
                    setTimeout(function() {
                        location.href = selectedVal[i];
                    }, i * 2000);
                }
                innerFunc(i);
            }
            window.CP.exitedLoop(0);
        }

        $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 230) + 'px'});
        });

        $('.summaryEdit').click(function(){
            $(".employeeInput").attr("disabled", false);  
            $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
            $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').attr("disabled", false);
            $('li.edit').addClass("activeTabs");        
            $('li.edit a').addClass("greentab");
            $('.saveLinkView').removeClass("display-hide");
            $('.saveLinkView').addClass("display-show");
        })
    </script>
    

</html>