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
                                <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                                    <?php
                                    if(isset($donor_id) && $donor_id != ''){
                                     ?>
                                    
                                    <span><a href="<?php echo base_url() . 'index.php/master/donorAmountlist'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                <?php } else { ?>
                                    <span><a href="<?php echo base_url() . 'index.php/master/balance_sheet'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                <?php } ?>
                                    <h4>Donor Amount</h4>
                                </div>
                                <div class="col-xl-8 col-lg-8 col-md-12 col-12 text-right">
                                    <ul class="vitals-links">
                                        <li><a href="<?php echo base_url() . 'index.php/master/donorAmountHistory'; ?>" class="master_aduser"><span><i class="far fa-file-alt"></i></span> Action History</a></li>
                                        <li><a href="<?php echo base_url() . 'index.php/master/addDonorAmount'; ?>" class="master_aduser"><span><i class="fas fa-plus-circle"></i></span> Add Donor Amount</a></li>
                                    </ul>
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
                                                                    <th>Sno</th>
                                                                    <th>Donor</th>
                                                                    <th>Assigned Amount (INR)</th>
                                                                    <?php if(isset($donor_id) && $donor_id != ''){ ?>
                                                                        <th>Amount Date</th>
                                                                    <?php } ?>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                                                                              
                                                            </tbody>
                                                                    <tfoot>
            <tr>
                <th colspan="0" style="text-align:right">Total:</th>
                <th></th>
                <th></th>
                <th></th>
                
            </tr>
        </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="delete_ids" id="delete_ids" />
                                                <input type="hidden" name="master_type" id="master_type" value="<?php echo $master_type; ?>" />
                                                <input type="hidden" name="donor_id" id="donor_id" value="<?= isset($donor_id) && $donor_id != '' ? $donor_id : '' ?>" />
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

        function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

        function master_trigger() {
            var year_from = $('#year_from').val();
            var year_to = $('#year_to').val();
            var donor_id = $('#donor_id').val();

if(donor_id != ''){
            var ordr_tble = [0,3,4];
        } else {
            ordr_tble = [0,3];
        }
        
            $('#master_table').DataTable({
                "scrollX": true,
                "initComplete": function(settings, json) {
                    $('.dataTables_scrollBody thead tr').css({
                        visibility: 'collapse'
                    });
                },
                "bProcessing": true,
                "bSortable": true,
                "destroy": true,
                "bDestroy": true,
                "paging": true,
                // "ordering": true,
                "info": false,
                "searching": false,
                "lengthChange": false,
                "bServerSide": true,
                "stateSave": false,
                "autoWidth": false,
                "pageLength": 10,
                "ajax": {
                    "url": "<?php echo base_url(); ?>index.php/master/DTDonoramount",
                    "type": "POST",
                    "data": {
                        "from_year": year_from,
                        "from_to": year_to,
                        "donor_id": donor_id
                    }
                },
                drawCallback: function(settings) {
                    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                    pagination.toggle(this.api().page.info().pages > 1);

                    var table = $('#master_table').dataTable();
                    var data_len = table.fnGetData().length;
                    if (data_len == 0) {
                        $('.master_check_all').hide();
                        $('tr td:first-child').addClass('none-pointer');
                    }
                    $('.master_check_all').prop('checked', false);
                    $('#delete_ids').val('');
                },
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column(2)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column(2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                // Total over this page
 
            // Update footer
            $( api.column(2).footer() ).html(
                addCommas(pageTotal)
            );
        },
                'columnDefs': [{
                    'orderable': false,
                    'targets': ordr_tble,
                }],
                "order": [1, 'asc']
            });
        }


    </script>
</body>

</html>