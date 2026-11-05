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
            <div class="dataconfig-content page-wrapper vitals_mainContent ">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
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
                                    <h4>Leave Allocation</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                    <ul class="vitals-links addActiveClass">
                                    <li><a href="<?php echo base_url() . 'index.php/user/user_ui/apply_leave'; ?>" class="master_aduser"><span><i class="fas fa-file-medical"></i></span> Apply Leave</a></li>
                                    <li><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                                        <li><a href="" class="master_aduser"><span><i class="fas fa-download"></i></span> Export</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="plan-structure-vital">
                                <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/user/user_ui/leave_list'; ?>">Leave List</a></li>
                                            <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/user/user_ui/approve_leave_list'; ?>">Approve Leave (3)</a></li>
                                            <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/user/user_ui/leave_summary'; ?>">Leave Allocation</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new vital_windowScroll">
                                                <div class="row leaveLabel">
                                                    <div class="col-12 col-sm-2 col-md-2">
                                                        <div class="form-group">
                                                            <label>Year</label>
                                                            <select class="form-control">
                                                                <option>2020</option>
                                                                <option>2019 </option>
                                                                <option>2018 </option>
                                                                <option>2017</option>
                                                                <option>2016 </option>
                                                                <option>2015</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-2 col-md-2">
                                                        <div class="form-group">
                                                            <label>User Type</label>
                                                            <select class="form-control">
                                                                <option>All Employees</option>
                                                                <option>Select </option>
                                                                <option>Employee </option>
                                                                <option>Student</option>
                                                                <option>Fellow </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-2 col-md-2">
                                                        <div class="form-group">
                                                            <label>Employee Name</label>
                                                            <select class="form-control" >
                                                                <option>Subalakshmi T.R</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-2 col-md-2">
                                                        <div class="form-group">
                                                            <label>Leave Type</label>
                                                            <select class="form-control" >
                                                                <option>All</option>
                                                                <option>Casual</option>
                                                                <option>Medical</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-2 col-md-2">

                                                    </div>
                                                    <div class="col-12 col-sm-2 col-md-2 text-right">
                                                        <a href="javascript:" class="vital_yellow_btn view_summary">View</a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 table-responsive vitalMasterDataTbl display-hide view_summary_table">
                                                        <table class="table table-hover dt-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th>Employee Name</th>
                                                                    <th>Leave Type</th>
                                                                    <th>Leave Entitled <small>(days)</small></th>
                                                                    <th>Leave Scheduled <small>(days)</small></th>
                                                                    <th>Leave Takens <small>(days)</small></th>
                                                                    <th>Leave Carry Forward <small>(days)</small></th>
                                                                    <th>Leave Encashed <small>(days)</small></th>
                                                                    <th>Leave Remaining <small>(days)</small></th>
                                                                    <th>Comments</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Subalakshmi T.R</td>
                                                                    <td>Casual</td>
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Subalakshmi T.R</td>
                                                                    <td>Medical</td>
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Subalakshmi T.R</td>
                                                                    <td>Earned</td>
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Subalakshmi T.R</td>
                                                                    <td>Maternity</td>
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Subalakshmi T.R</td>
                                                                    <td>Paternity</td>
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Subalakshmi T.R</td>
                                                                    <td>Adoption</td>
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Subalakshmi T.R</td>
                                                                    <td>Additional Leave</td>
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Subalakshmi T.R</td>
                                                                    <td>Comp off</td>
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Subalakshmi T.R</td>
                                                                    <td>Work from home</td>
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Subalakshmi T.R</td>
                                                                    <td>Casual</td>
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Subalakshmi T.R</td>
                                                                    <td>Medical</td>
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Subalakshmi T.R</td>
                                                                    <td>Earned</td>
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td>-</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Subalakshmi T.R</td>
                                                                    <td>Maternity</td>
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td><input class="form-control " type="text" value="0.00" disabled></td>  
                                                                    <td>-</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-end">
                                                    <div class="col-12 col-sm-4  col-md-4 text-right">
                                                        <div class="text-right saveLinkView display-hide">
                                                            <br>
                                                            <ul class="vitals-links ">
                                                                <li><a href="#" class="vital_yellow_btn">Save</a></li>
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
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script>
    $(document).ready(function() {
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 200) + 'px'
        });
    });

    $('table').DataTable({
        "columns": [ { "width": "15%" }, { "width": "10%" }, { "width": "10%" }, { "width": "10%" }, { "width": "10%" }, { "width": "10%" }, { "width": "10%" }, { "width": "10%" }, { "width": "15%" } ],
    });

    $('.view_summary').click(function() {
        $(".view_summary").addClass("display-hide");
        $(".view_summary").removeClass("display-show");
        $('.view_summary_table').removeClass("display-hide"); 
        $(".view_summary_table").addClass("display-show");      

    });

    $('.summaryEdit').click(function(){
        $("input").attr("disabled", false);
        $('.addActiveClass li:first-child').addClass("activeTabs");
        $('.addActiveClass li:first-child a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    })
</script>

<style>
    .form-control{
        width: 100% !important;        
    }
    
</style>

</html>