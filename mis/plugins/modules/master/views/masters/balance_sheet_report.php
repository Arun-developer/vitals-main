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
                                    <span><a href="<?php echo base_url() . 'index.php/master/balance_sheet'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>Balance Report</h4>
                                </div>
                                
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new pad-none"> 
                                            <div style="height: 10px;"></div> 
                                                <div class="pad-hr15">
                                                <form id="filter_job" action="" class="wdt100" method="POST" autocomplete="off">
                                                    <div class="row leaveLabel">
                                            <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                            <label>Financial Year From</label>
                                                                
                                                            <input class="form-control year_search" type="text" name="year_from" id="year_from" placeholder="Select year from">
                                                            </div>
                                                            <label class="error hidden" id="sel_error">Select type</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                <div class="form-group">

                                                               <label>&nbsp;</label>
                                                                <input class="form-control year_search" type="text" name="year_to" id="year_to" placeholder="Select year to">
                                                            </div>
                                                            <label class="error hidden" id="txt_error">Enter value</label>
                                                        </div>
                                                        <div class="col-12 col-sm-3 col-md-3">
                                                <div class="form-group">
                                                    <label>Programme</label>
                                                    <select class="form-control " id="programme_search" name="programme_search" onchange="getDonor(this.value);">
                                                                    <option value="">--Select Programme--</option>
                                                                    <?php foreach($programme as $p_search){ ?>
                                                                        <option value="<?= $p_search['programme_id']; ?>"><?= $p_search['programme']; ?></option>
                                                                    <?php } ?>
                                                                </select>   
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-3 col-md-3">
                                                <div class="form-group">
                                                    <label>Donor</label>
                                                    <select class="form-control " id="donor_search" name="donor_search" onchange="getBudget('', this.value);">
                                                                    <option value="">--Select Donor--</option>
                                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                                        <div class="col-12 col-sm-3 col-md-3">
                                                <div class="form-group">
                                                    <label>Budget Head</label>
                                                    <select class="form-control " id="budget_search" name="budget_search" onchange="getLineitem(this.value)">
                                                                    <option value="">--Select Budget head--</option>
                                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-3 col-md-3">
                                                <div class="form-group">
                                                    <label>Line Item</label>
                                                    <select class="form-control " id="line_search" name="line_search" onchange="getSublineitem(this.value)">
                                                                    <option value="">--Select Line item--</option>
                                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-3 col-md-3">
                                                <div class="form-group">
                                                    <label>Cost Center</label>
                                                    <select class="form-control " id="costcenter_search" name="costcenter_search">
                                                                    <option value="">--Select Line item--</option>
                                                                </select>
                                                </div>
                                            </div>
                                                            
                                                            
                                                        
                                                        </div>
                                                    <div class="row">
                                            <div class="col-xs-12">
                                                <ul class="vitals-links">
                                                    <li><a href="javascript:" id="search_btn" class="vital_yellow_btn pad-hr15 wdt_100">Search</a></li>  
                                            <li><span class="vitals_clearSearch" id="reset_search">Clear search</span></li>
                                        </ul>
                                            </div>
                                            <div class="col-xs-9 col-lg-9 col-md-9 col-12 text-right">
                                            <ul class="vitals-links  pad-hr15" style="margin : 10px -40px 0px 0px">
                                            <li><a href="javascript:void(0)" id="go_printer" class="master_aduser"><span><i class="fas fa-print"></i></span> Print</a></li>
                                                <li><a href="<?php echo base_url() . 'index.php/master/balance_export' ?>" class="master_aduser" ><span><i class="fas fa-download"></i></span> Export</a></li>                                      
                                            </ul>
                                        </div>
                                        </div>

                                                        </form>
                                                                                                         
                                                </div>

                                        <div class="row">
                                        
                                        </div>
                                                <div style="height: 10px;"></div>                                                    
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                        <table class="table table-hover" id="master_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Programme</th>
                                                                    <th>Donor</th>
                                                                    <th>Grant ID</th>
                                                                    <th>Budget Head</th>
                                                                    <th>Line Item</th>
                                                                    <th>Assigned Amount (INR)</th>
                                                                    <th>Planned Amount INR (%)</th>
                                                                    <th>Utilized Amount (INR)</th>
                                                                    <th>Available Amount AM-(AP)</th>
                                                                    <th>Unutilized Amount INR (%)</th>
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
                <th></th>
                <th></th>
                <th></th>
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
                                                <!-- </div> -->
                                                <!-- </div> -->
                                            </div>
                                            <div  style="display:none;"  id="load_print"></div>
                                        </main>
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

            setDatepicker();
        });

            $("#go_printer").click(function(){
            var year_from = $('#year_from').val();
            var year_to = $('#year_to').val();
            var programme_search = $('#programme_search').val();
            var grant_search = $('#grant_search').val();
            var donor_search = $('#donor_search').val();
            var budget_search = $('#budget_search').val();
            var lineitem_search = $('#lineitem_search').val();
            var costcenter_search = $('#costcenter_search').val();
        $.ajax({
            url: '<?php echo base_url() . 'index.php/master/print_balance_pdf' ?>',
            cache: false,
            type: "POST",
            data: {year_from: year_from,year_to: year_to, programme_search: programme_search, grant_search: grant_search, donor_search: donor_search, budget_search: budget_search, lineitem_search: lineitem_search, costcenter_search: costcenter_search},
            dataType: "html",
            success: function(response){
                $('#load_print').html('');
                $('#load_print').html(response);
                var prtContent = document.getElementById('load_print');
                var WinPrint = window.open('', '', 'left=0,top=0,width=20,height=20,toolbar=0,scrollbars=0,status=0');
                WinPrint.document.write(prtContent.innerHTML);
                WinPrint.document.close();
                WinPrint.focus();
                WinPrint.print();
                WinPrint.close();
            }
        });
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
            var programme_search = $('#programme_search').val();
            var grant_search = $('#grant_search').val();
            var donor_search = $('#donor_search').val();
            var budget_search = $('#budget_search').val();
            var lineitem_search = $('#lineitem_search').val();
            var costcenter_search = $('#costcenter_search').val();
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
                    "url": "<?php echo base_url(); ?>index.php/master/DTBalanceReport",
                    "type": "POST",
                    "data": {
                        "from_year": year_from,
                        "from_to": year_to,
                        "programme_search": programme_search,
                        "grant_search": grant_search,
                        "donor_search": donor_search,
                        "budget_search": budget_search,
                        "lineitem_search": lineitem_search,
                        "costcenter_search": costcenter_search,
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
                    // selectall_chk();
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
            total5 = api
                .column(5)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal5 = api
                .column(5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                // Total over this page
            pageTotal6 = api
                .column(6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                // Total over this page
            pageTotal7 = api
                .column(7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                // Total over this page
            pageTotal8 = api
                .column(8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                // Total over this page
            pageTotal9 = api
                .column(9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(5).footer() ).html(
                addCommas(pageTotal5)
            );
            $( api.column(6).footer() ).html(
                addCommas(pageTotal6)
            );
            $( api.column(7).footer() ).html(
                addCommas(pageTotal7)
            );
            $( api.column(8).footer() ).html(
                addCommas(pageTotal8)
            );
            $( api.column(9).footer() ).html(
                addCommas(pageTotal9)
            );
        },
                'columnDefs': [{
                    'orderable': false,
                    'targets': [5, 6, 7, 8, 9],
                },
                {
        targets: [5, 6,7,8,9],
        className: 'dt-body-center'
    },],
                "order": [1, 'asc']
            });
        }

                    function setDatepicker() {
                $('.year_search').datepicker({
                    // changeMonth: true,
                    changeYear: true,
                    viewMode: "years",
                // showButtonPanel: true,
                dateFormat: 'yy',
            });

            }

        function enableEdits() {
            var store = $('#delete_ids').val();
            var arr = store.split(',');
            var len = arr.length;
            for (var a = 0; a < len; a++) {}
        }

        $(document).on('click', '#search_btn', function() {
            // $('#filter_job').submit();
            master_trigger();
        });

        $(document).on('click', '#reset_search', function() {
            // $('#year_from').val('');
            // $('#year_to').val('');
            // $('#programme_search').val('');
            // $('#donor_search').val('');
            // $('#budget_search').val('');
            // $('#line_search').val('');
            // $('#costcenter_search').val('');
            // $('#filter_job').submit();
            // master_trigger();

                    location.reload();
        });


        function getDonor(prgmval){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/master/getPrgmDonor",
                data: {
                    parent: prgmval,
                },
                dataType: 'html',
                success: function(data) {
                    // $('.deletetoast').toast('show');

                        $('#donor_search').html(data);
                    
                    // }, 3000);
                }
            });
        }

        function getBudget(increa, donorval){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/master/getBudgetlist",
                data: {
                    m_type: 'Budget Head',
                    parent: donorval,
                },
                dataType: 'html',
                success: function(data) {
                    // $('.deletetoast').toast('show');
                    $('#budget_head_'+increa).html(data);
                    if(increa == ''){
                        $('#budget_search').html(data);
                    }
                    // }, 3000);
                }
            });
        }

        function getLineitem(budgetval){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/master/getBudgetlist",
                data: {
                    m_type: 'Line Item',
                    parent: budgetval,
                },
                dataType: 'html',
                success: function(data) {
                    $('#line_search').html(data);
                }
            });
        }

    function getSublineitem(lineval){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getBudgetlist",
            data: {
                m_type: 'Cost Centre',
                parent: lineval,
            },
            dataType: 'html',
            success: function(data) {
                $('#costcenter_search').html(data);
            }
        });
    }




    </script>
</body>

</html>