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
                            <?php $this->load->view('UI/deals/deal_sidemenu.php', array('page' => 'mail_history')); ?>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                    <span><a href=""><i class="fas fa-angle-left"></i> Back</a></span>
                                    <h4>FlyLife - Mail History</h4>
                                </div>

                            </div>
                            <div class="tab-slider--navform">
                                <ul class="tab-slider--tabsform">
                                    <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/user/user_ui/deals_all_mails'; ?>">All Mails</a></li>
                                    <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/user/user_ui/deals_external_mail'; ?>">Add External Mail</a></li>
                                    <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/user/user_ui/deals_send_mail'; ?>">Send Mail</a></li>
                                </ul>
                            </div>

                            <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                <main class="page-content">
                                    <div class="inputplan-structureall plan-structure-new vital_windowScroll">
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-12 col-lg-2 col-xl-2">
                                                <div class="form-group">
                                                    <label>Option</label>
                                                    <select class="form-control">
                                                        <option>All</option>
                                                        <option>Confirmed Notes </option>
                                                        <option>Cancelled Notes</option>
                                                        <option>Deffered Notes </option>
                                                        <option>Closed Notes</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-2 col-xl-2">
                                                <div class="form-group">
                                                    <label>Mail type</label>
                                                    <input class="form-control" type="text" placeholder="Type here">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-2 col-xl-2">
                                                <div class="form-group">
                                                    <label>Send date</label>
                                                    <input class="form-control" type="text" placeholder="01-12-2019">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-2 col-xl-2">
                                                <div class="form-group">
                                                    <label> &nbsp; </label>
                                                    <input class="form-control" type="text" placeholder="01-12-2019">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                <div style="height: 15px;"></div>
                                                <ul class="vitals-links">
                                                    <li><a href="" class="vital_yellow_btn pad-hr15">Search</a></li>
                                                    <li><span class="vitals_clearSearch">Clear search</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- <div class="row leaveLabel">                                                
                                                    <div class="col-12 col-md-12 col-lg-12 col-xl-12 text-right">                                                        
                                                        <ul class="vitals-links"> 
                                                        <li><a href="javascript:" class="master_aduser" data-toggle="modal" data-target="#printModal"><span><i class="fas fa-print"></i></span> Print</a></li>                                                                                                                                         
                                                            <li><a href="" class="master_aduser"><span><i class="fas fa-download"></i></span> Export</a></li>                                                            
                                                        </ul>
                                                    </div>
                                                </div> -->
                                        <div style="height:20px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-titl">
                                                <div class="row  d_v_d_c">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <h6>Internal Mail</h6>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <!-- <ul class="milestone-links">
                                                                    <li class="brd-left-onboard">
                                                                        <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                    </li>                                                         
                                                                </ul> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                <table class="table table-hover dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th><input class="form-control" type="checkbox"></th>
                                                            <th>From</th>
                                                            <th>TO</th>
                                                            <th>Send Date</th>
                                                            <th>Mail Type</th>
                                                            <th>subject</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="odd">
                                                            <td valign="top" colspan="11" class="dataTables_empty text-center">No data available in table</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                        <div style="height:20px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-titl">
                                                <div class="row  d_v_d_c">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <h6>External Mail</h6>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <!-- <ul class="milestone-links">
                                                                    <li class="brd-left-onboard">
                                                                        <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                    </li>                                                         
                                                                </ul> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                <table class="table table-hover dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th><input class="form-control" type="checkbox"></th>
                                                            <th>TO</th>
                                                            <th>Subject</th>
                                                            <th>Body</th>
                                                            <th>Send On</th>
                                                            <th>Document</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="odd">
                                                            <td valign="top" colspan="11" class="dataTables_empty text-center">No data available in table</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
<script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script>
    $(document).ready(function() {
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 190) + 'px'
        });
    });
    $(document).ready(function() {
        $('#holiday_table').DataTable({
            columnDefs: [{
                orderable: false,
                targets: [0, 1, 2, 3]
            }],
            "bProcessing": true,
            "bServerSide": true,
            "paging": true,
            "ordering": true,
            "info": false,
            "searching": false,
            "pageLength": 10,
            "lengthChange": false,
            "stateSave": false,

        });
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