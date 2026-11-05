<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Villgro MIS</title>
    <!-- <link rel="stylesheet" href="http://192.168.1.200:8095/vital/source/portfolio_assets/css/new-portfolio.css"> -->

</head>

<body>
    <?php
    $this->load->view('masters/header.php', array('page' => 'master'));
    ?>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
            <?php
            $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
            $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';
            if ($successMsg != '') {
            ?>
                <div class="position-absolute d-flex flex-column p-4 toastPlace">
                    <div id="toast-container" aria-live="polite" aria-atomic="true">
                        <div id="toast-wrapper">
                            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                <div class="toast-header bg-success text-white">
                                    <strong class="mr-auto"><?= $successMsg; ?></strong>
                                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                        <span aria-hidden="true" class="text-white">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            if ($errorMsg != '') {
            ?>
                <div class="position-absolute d-flex flex-column p-4 toastPlace">
                    <div id="toast-container" aria-live="polite" aria-atomic="true">
                        <div id="toast-wrapper">
                            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                <div class="toast-header bg-danger text-white">
                                    <strong class="mr-auto"><?= $errorMsg; ?></strong>
                                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                        <span aria-hidden="true" class="text-white">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="display-hide deleteMsg">
                <div class="position-absolute d-flex flex-column p-4 toastPlace">
                    <div id="toast-container" aria-live="polite" aria-atomic="true">
                        <div id="toast-wrapper">
                            <div class="toast deletetoast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                <div class="toast-header bg-success text-white">
                                    <strong class="mr-auto">Record(s) deleted successfully</strong>
                                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                        <span aria-hidden="true" class="text-white">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('masters/master_sidemenu.php', array('page' => 'master_setting')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                    <span><a href="<?php echo base_url() . 'index.php/master/donorAmountlist'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>Donor Amount</h4>
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div  class="display-hide" id="navLoad">
                                    <div class="newCLickTabs">
                                        <div>
                                            <ul class="nav nav-tabs" role="tablist">
                                                
                                                <li role="presentation" <?php if($master_type == 'Balance Sheet'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/balance_sheet'; ?>" >Balance Sheet</a></li>
                                                <li role="presentation" <?php if($master_type == 'Programme'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/programme'; ?>" >Programme</a></li>
                                                <li role="presentation"  <?php if($master_type == 'Donor'){ ?>class="active"<?php }?>><a href="<?php echo base_url() . 'index.php/master/donor'; ?>"  >Donor</a></li>
                                                <li role="presentation" <?php if($master_type == 'Budget Head'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/budget_head'; ?>" >Budget Head</a></li>
                                                <li role="presentation" <?php if($master_type == 'Line Item'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/line_item'; ?>" >Line Item</a></li>
                                                <li role="presentation" <?php if($master_type == 'Additional Info'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/additional_info'; ?>" >Additional Info</a></li>
                                                
                                                <li role="presentation" <?php if($master_type == 'Financial Year'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/financial_year'; ?>" >Financial Year</a></li>
                                                
                                                <!-- <li role="presentation" <?php if($master_type == 'Set Admin Email'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/set_admin_email'; ?>" >Set Admin Email</a></li> -->
                                            </ul>
                                        </div>
                                    </div>                                   
                                </div>
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new pad-none"> 
                                            <div style="height: 10px;"></div>                                                   
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                        <table class="table table-hover" id="master_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Donor</th>
                                                                    <th>Amount (INR)</th>
                                                                    <th>Amount Date</th>
                                                                    <th>IP Address</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            foreach($history_action as $actionlist){
                                                             ?>    
                                                         <tr>
                                                            <td><?= $actionlist['master_name']; ?></td>
                                                            <td><?= $actionlist['amount']; ?></td>
                                                            <td><?= date('d-m-Y', strtotime($actionlist['amount_date'])); ?></td>
                                                            <td><?= $actionlist['ipaddress']; ?></td>
                                                         </tr>                             
                                                             <?php                       
                                                            }
                                                            ?>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- </div> -->
                                                <!-- </div> -->
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



    <script type="text/javascript">
        $(document).ready(function() {
             $('.nav-tabs').scrollingTabs({
                enableSwiping: true
            }).on('ready.scrtabs', function() {
                $('.tab-content').show();
            });
            $('#navLoad').removeClass('display-hide');
            $('.vital_windowScroll').css({
                'height': (($(window).height()) - 190) + 'px'
            });
            $('.toast').toast('show');
            setTimeout(function() {
                $('.success').addClass('display-hide');
            }, 3000);
            master_trigger();

        });

        function master_trigger() {
            $('#master_table').DataTable({
                "bProcessing": true,
                "bSortable": true,
                "paging": true,
                // "ordering": true,
                "info": false,
                "searching": false,
                "lengthChange": false,
                "stateSave": false,
                "autoWidth": false,
                "pageLength": 10,
                drawCallback: function(settings) {
                    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                    pagination.toggle(this.api().page.info().pages > 1);

                },

                "order": [1, 'asc']
            });
        }


    </script>
</body>

</html>