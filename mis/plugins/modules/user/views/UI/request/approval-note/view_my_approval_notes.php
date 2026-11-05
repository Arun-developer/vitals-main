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
                                    <span><a href="<?php echo base_url() . 'index.php/user/user_ui/my_approval_notes'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>Approval Note Details - APN/0004</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                                    <ul class="vitals-links">
                                    <li class="edit"><a href="<?php echo base_url() . 'index.php/user/user_ui/edit_my_approval_notes'; ?>" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                                    <li class="edit"><a href="javascript:" data-toggle="modal" data-target="#approveModel" class="master_aduser summaryEdit"><span><i class="far fa-check-circle"></i></span> Approve</a></li>
                                    <li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="far fa-times-circle"></i></span> Disapprove</a></li>
                                    <li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-print"></i></span> Print</a></li>
                                        <!-- <li><a href="" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a></li> -->
                                    </ul>
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <!-- <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/user/user_ui/new_approval_note'; ?>">New Approval Note</a></li>                                            
                                            <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/user/user_ui/my_approval_notes'; ?>">My Approval Notes</a></li>                                            
                                        </ul>
                                    </div>
                                </div> -->
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <!-- <div class="Vital-notes-request">
                                                    <span>VILLGRO INNOVATIONS FOUNDATION APPROVAL NOTE</span>
                                                </div> -->
                                                <!-- <div style="height: 15px;"></div> -->
                                                <div class="row approvalLabel">
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="display-flex">
                                                            <label>Status :</label>
                                                            <p>Pending</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="display-flex">
                                                            <label>From Employee :</label>
                                                            <p>Vijitha Panikkar</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="display-flex">
                                                            <label>Date of Approval :</label>
                                                            <p>07/07/2020 </p>
                                                        </div>
                                                    </div> -->
                                                    
                                                </div>
                                                <div class="row approvalLabel">                                                    
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="display-flex">
                                                            <label>Approval Number :</label>
                                                            <p>APN/0017</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="display-flex">
                                                            <label>Programme Head Status:</label>
                                                            <p>Pending</p>
                                                        </div>
                                                    </div> 
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="display-flex">
                                                            <label>CEO Status:</label>
                                                            <p>Pending</p>
                                                        </div>
                                                    </div>                                                                                                        
                                                </div>
                                                <div class="row approvalLabel">
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="display-flex">
                                                            <label>Reporting Officer :</label>
                                                            <p>Srinivas Ramanujam</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="display-flex">
                                                            <label>Programme Head :</label>
                                                            <p>Heera Jayachandran</p>
                                                        </div>
                                                    </div> 
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="display-flex">
                                                            <label>CEO :</label>
                                                            <p>Heera Jayachandran</p>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="row approvalLabel">
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="display-flex">
                                                            <label>programme :</label>
                                                            <p>ANDE</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                                                        <div class="display-flex">
                                                            <label>Purpose :</label>
                                                            <p></p>
                                                        </div>
                                                    </div>                                                    
                                                </div>                                                
                                                <div style="height: 15px;"></div>                                                
                                                <div class="newApprovalNoteViewTbl">
                                                    <table class="table" style="margin-top: 0">
                                                        <thead>
                                                            <tr>                                                                
                                                                <th width="15%">Donor</th>
                                                                <th width="15%">Budget Head</th>
                                                                <th width="15%">Line Item</th>
                                                                <th width="15%">Details</th>
                                                                <th width="20%" class="text-center">Amt Available(INR)</th>
                                                                <th width="20%" class="text-center">Amt Required(INR)</th>                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="metric_more">                                                                
                                                                <td>TLF</td>
                                                                <td>Admin/utilities </td>
                                                                <td>Insurance </td>
                                                                <td></td>
                                                                <td align="center">8,468</td>
                                                                <td align="center">527</td>                                                                
                                                            </tr>
                                                            <tr class="metric_more">                                                                
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td align="center"><b>Total</b></td>
                                                                <td align="center">527</td>                                                                
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div style="height: 15px;"></div>
                                                <div class="row approvalLabel">
                                                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="display-flex">
                                                            <label>Programme Head Approval Status :</label>
                                                            <p>Pending</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="display-flex">
                                                            <label>Programme Head Approval Date :</label>
                                                            <p>07/07/2020 6.30PM</p>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                                <div class="row approvalLabel">
                                                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="display-flex">
                                                            <label>Comments of Programme Head :</label>
                                                            <p>-</p>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                                <div class="row approvalLabel">
                                                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="display-flex">
                                                            <label>CEO Approval Status :</label>
                                                            <p>Pending</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="display-flex">
                                                            <label>CEO Approval Date :</label>
                                                            <p>07/07/2020 6.30PM</p>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                                <div class="row approvalLabel">
                                                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="display-flex">
                                                            <label>Supporting Documents :</label>
                                                            <p>No documents found</p>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="display-flex">
                                                            <label>Is expense above Rs. 50,000?</label>
                                                            <p>No</p>
                                                        </div>
                                                    </div>                                                    -->
                                                </div>                                                
                                                <div class="row approvalLabel">
                                                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="display-flex">
                                                            <label>Attachments :</label>
                                                            <p></p>
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
    <div class="modal" id="approveModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approval Note - Approve</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="container-fluid">
                        <div class="row leaveLabel">
                            <div class="col-12 col-md-12 col-lg-10 col-xl-10">
                                <div class="form-group text-left">
                                    <label>Enter Comments</label>
                                    <textarea class="form-control" type="text"></textarea>
                                </div>
                            </div>
                        </div>
                        <div style="height:15px"></div>
                        <div class="row ">
                            <div class="col-12 col-sm-12  col-md-12 text-left ">
                                <ul class="vitals-links">
                                    <li><a href="javascript:" data-toggle="modal" data-target="#approveSuccessModel" id="closeModal" class="vital_yellow_btn wdt-100">Approve</a></li>
                                    <li><a href="javascript:" data-dismiss="modal" aria-label="Close" class="vital_bordered_btn wdt-100">Cancel</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>                    
            </div>
        </div>
    </div>
    <div class="modal" id="approveSuccessModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header brd-none">                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="container-fluid">
                        <div class="row leaveLabel">
                            <div class="col-12 col-md-12 col-lg-12 col-xl-12 text-center">
                                <img src="<?php echo base_url() . 'source/portfolio_assets/img/View.png'; ?>"/>
                                <div style="height:10px"></div>
                                <label>Approval Note No: APN/0017</label>                                    
                                <h3 class="clr_geen">Approved Successfully</h3>
                            </div>
                        </div>
                        <div style="height:35px"></div>                        
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


            $("#closeModal").click(function () {
                $("#approveModel").modal("hide");
            });
        });

        // $('table').DataTable();

        // table row in a table clickable as a link
        // ---------------------------------------      
     
        
       
    </script>

</html>