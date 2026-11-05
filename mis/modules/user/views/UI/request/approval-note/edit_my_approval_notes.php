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
                            <?php $this->load->view('UI/request/request_sidemenu.php', array('page' => 'my_approval_note')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                             <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                    <span><a href="<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>Approval Note Details - APN/0004</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                                <!-- <ul class="vitals-links">
                                        <li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>                                       
                                    </ul> -->
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <div class="row leaveLabel">                                                    
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Approval Number</label>
                                                            <input class="form-control" type="text" disabled value="APN/0017">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Reporting Manager<span>*</span></label>
                                                            <select class="form-control">                                                                
                                                                <option>Srinivas Ramanujam</option>                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Date of seeking approval</label>
                                                            <input class="form-control" type="text" disabled placeholder="07/07/2020">
                                                        </div>
                                                    </div>                                                       
                                                </div>
                                                <div class="row leaveLabel">                                                
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Purpose</label>
                                                            <textarea class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>  
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Programme<span>*</span></label>
                                                            <select class="form-control">                                                                
                                                            <option>ANDE</option>                                                                 
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="height:20px"></div>
                                                <div class="table_configcontentnew pad-bt0">
                                                    <div class="tabpanel-title">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                <!-- <h4>Add Donor Amount</h4> -->
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                <ul class="milestone-links">
                                                                    <li class="brd-left-onboard">
                                                                        <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                    </li>
                                                                    <li class="brd-left-onboard">
                                                                        <a href="javascript:void(0)" class="edit-btnconfig documentEditBtn mar-tp15"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a>
                                                                    </li>
                                                                    <li class="brd-left-onboard">
                                                                        <a href="javascript:void(0)" class="edit-btnconfig  mar-tp15"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                                    </li>
                                                                    <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue ">Save</a></li>                                                               
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                                    <table class="table" style="margin-top: 0">
                                                        <thead>
                                                            <tr>
                                                                <!-- <th width="5%" class="removeArrow"><input class="form-control" type="checkbox"></th> -->
                                                                <th width="15%">Donor<span>*</span></th>
                                                                <th width="15%">Budget Head<span>*</span></th>
                                                                <th width="15%">Line Item<span>*</span></th>
                                                                <th width="15%">Details</th>
                                                                <th width="20%">Amt Available(INR)<span>*</span></th>
                                                                <th width="20%">Amt Required(INR)<span>*</span></th>                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="metric_more">                                                                
                                                                <td><select class="form-control"><option>TLF</option></select></td>
                                                                <td><select class="form-control"><option>Admin/utilities</option></select></td>
                                                                <td><select class="form-control"><option>Insurance</option></select></td>
                                                                <td><input class="form-control" placeholder=""></td>
                                                                <td><input class="form-control" placeholder="Enter Amount" value="8,468"></td>
                                                                <td><input class="form-control" placeholder="Enter Amount" value="527"></td>                                                                
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div style="height:20px"></div>
                                                <div class="table_configcontentnew pad-bt0">
                                                    <div class="tabpanel-title">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                <h4>Upload Document</h4>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                <ul class="milestone-links">
                                                                    <!-- <li>
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a>
                                                            </li> -->
                                                                    <li>
                                                                        <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                                    <table class="table" style="margin-top: 0">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%" class="removeArrow"><input class="form-control" type="checkbox"></th>
                                                                <th width="20%">Document Description</th>
                                                                <th width="20%">Upload Document</th>   
                                                                <th></th>                                                                                                                          
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="metric_more">
                                                                <td class="valign-center"><input class="form-control" type="checkbox"></td>
                                                                <td><input class="form-control" type="text" placeholder="Enter Name"></td>
                                                                <td><input type="button"  class="form-control employeeInput masterPicUpdatebtn"  value="Choose file to upload" /></td>                                                                                                                              
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div style="height:20px"></div>
                                                <div class="row ">
                                                    <div class="col-12 col-sm-4  col-md-4 ">
                                                        <ul class="vitals-links">
                                                            <li><a href="<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>" class="vital_yellow_btn wdt-100">Save</a></li>
                                                            <li><a href="<?php echo base_url() . 'index.php/user/user_ui/view_my_approval_notes'; ?>" class="vital_bordered_btn wdt-100">Cancel</a></li>
                                                        </ul>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <script>
        $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 190) + 'px'});
        });        
        
       
    </script>

</html>