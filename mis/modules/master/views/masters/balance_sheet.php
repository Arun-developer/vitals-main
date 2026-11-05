<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Balance Sheet', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'budget_master')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Balance Sheet - <span id="displayYear"><?= $current_year; ?></span></h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new pad-none">
                                    <div style="height: 10px;"></div>
                                    <div class="pad-hr15">
                                        <form id="filter_form" action="<?php echo base_url() . 'index.php/master/balance_export/1'; ?>"  action="" class="wdt100" method="POST" autocomplete="off">
                                            <div class="row spec-label">
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-12 ">
                                                    <div>
                                                        <label>Financial Year From</label>
                                                        <input class="form-control year_search" type="text" name="year_from" id="year_from" placeholder="Select year from" value="<?= $current_year; ?>">
                                                        <label class="error hidden" id="sel_error">Select type</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-12">
                                                    <div>
                                                        <label>Financial Year To</label>
                                                        <input class="form-control year_search" type="text" name="year_to" id="year_to" placeholder="Select year to" value="<?= $next_year; ?>">
                                                        <label class="error hidden" id="txt_error">Enter value</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-12">
                                                    <div>
                                                        <label>Programme Name</label>
                                                        <input class="form-control" type="text" name="programme_search" id="programme_search" placeholder="Enter programme">
                                                        <label class="error hidden" id="txt_error">Enter value</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-12">
                                                    <div style="height:10px"></div>
                                                    <ul class="vitals-links">
                                                        <li><a href="javascript:" id="search_btn" class="vital_yellow_btn pad-hr15 wdt_100">Search</a></li>
                                                        <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div style="height: 10px;"></div>
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <ul class="vitals-links">
                                                <!-- <li><a href="javascript:void(0)" id="custom_print" class="master_aduser"><span><i class="fas fa-print"></i></span> Print</a></li> -->
                                                <li><a href="<?php echo base_url() . 'index.php/master/addmultipledonor'; ?>" class="master_aduser"><span><i class="fas fa-plus-circle"></i></span> Add Amount</a></li>
                                                <li><a  id="export_summary" class="master_aduser"><span><i class="fas fa-download"></i></span>Export</a></li>

                                                <!-- <li><a href="<?php echo base_url() . 'index.php/master/donorAmountlist'; ?>" class="master_aduser"><span><i class="fas fa-hand-holding-usd"></i></span> Donors Amount</a></li>-->
                                                <li><a href="<?php echo base_url() . 'index.php/master/multipleAmountHistory'; ?>" class="master_aduser"><span><i class="far fa-file-alt"></i></span> Action History</a></li>

                                                <!-- <li><a href="<?php echo base_url() . 'index.php/master/balance_report'; ?>" class="master_aduser"><span><i class="far fa-file-alt"></i></span> Report</a></li>-->
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover order-column" id="master_table">
                                                <thead>
                                                    <tr>
                                                        <th>Programme</th>
                                                        <th>Donor</th>
                                                        <th>Grant ID</th>
                                                        <th>Budget Head</th>
                                                        <th>Line Item</th>
                                                        <!--<th>Additional Info</th>-->
                                                        <th>Assigned Amount (AM)(<?= $this->session->userdata('currency'); ?>)</th>
                                                        <th>Approval Notes (AN)(<?= $this->session->userdata('currency'); ?>)</th>
                                                        <th>Internal Note (IN)(<?= $this->session->userdata('currency'); ?>)</th>
                                                        <th>Recovered Amount (RA)(<?= $this->session->userdata('currency'); ?>)</th>
                                                        <th>Available (AM-AN)+RA (<?= $this->session->userdata('currency'); ?>)</th>
                                                        <th>Unutilized (AN-IN) (<?= $this->session->userdata('currency'); ?>)</th>
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
                                                        <th></th>
                                                        <!--<th></th>-->
                                                        <th style="text-align:center!important" ></th>
                                                        <th style="text-align:center!important"></th>
                                                        <th style="text-align:center!important"></th>
                                                        <th style="text-align:center!important"></th>
                                                        <th style="text-align:center!important"></th>
                                                        <th style="text-align:center!important"></th>
                                                        <th style="text-align:center!important"></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" name="delete_ids" id="delete_ids" />
                                    <input type="hidden" name="master_type" id="master_type" value="<?php echo $master_type; ?>" />
                                </div>
                                <div style="display:none;" id="load_print"></div>
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

<div class="modal" id="deletemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Are you sure you want to delete selected items?</h4>
                            <p>you are about to delete <span id="delCount"></span> selected row, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="printmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Custom Print</h4>
                            <p>Report Name :<select name="print_amt" id="print_amt" class="form-control edit_cls">
                                <option value="1">With Amount</option>
                                <option value="2">Without Amount</option>
                            </select>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
            <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Close</a></button>
            <button type="button" class="btn btn-success" id="go_printer">Print</button>
        </div>
    </div>
</div>
</div>

<div class="modal" id="exportmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Custom Export</h4>
                            <p>Report Name :<select name="export_amt" id="export_amt" class="form-control edit_cls">
                                <option value="1">With Amount</option>
                            </select>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
            <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Close</a></button>
            <button type="button" class="btn btn-success" id="go_export">Export</button>
        </div>
    </div>
</div>
</div>

<style>
    .plan-structure-vital .plan-structure-new{
        overflow-y: auto !important;
    }
    .DTFC_LeftBodyLiner thead {
        display: none !important;
    }
    .ui-datepicker-month {
        display: none !important;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.bootstrap.min.css">
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>

<script type = "text/javascript">
    $(document).ready(function () {

      $(document).on('click', '#export_summary', function () {
			//alert();
           $("#filter_form").submit();
       });


      setTimeout(function () {
        $('.success').addClass('display-hide');
    }, 3000);

      master_trigger();
      setDatepicker();
  });

    // $(document).on({
    //     mouseenter: function () {
    //         trIndex = $(this).index()+1;
    //         $("table.dataTable").each(function(index) {
    //             $(this).find("tr:eq("+trIndex+")").each(function(index) {
    //                 $(this).find("td").addClass("hover");
    //             });
    //         });
    //     },
    //     mouseleave: function () {
    //         trIndex = $(this).index()+1;
    //         $("table.dataTable").each(function(index) {
    //             $(this).find("tr:eq("+trIndex+")").each(function(index) {
    //                 $(this).find("td").removeClass("hover");
    //             });
    //         });
    //     }
    // }, ".dataTables_wrapper tr");

    function master_trigger() {
        var year_from = $('#year_from').val();
        var year_to = $('#year_to').val();
        var programme_search = $('#programme_search').val();
        $('#master_table').DataTable({
            "scrollX": true,
            "initComplete": function (settings, json) {
                $('.dataTables_scrollBody thead tr').css({
                    visibility: 'collapse'
                });
            },
            "scrollY": '288px',
            "scrollCollapse": true,
            "bProcessing": true,
            "bSortable": true,
            "destroy": true,
            "bDestroy": true,
            "paging": false,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "bServerSide": true,
            "fixedColumns": {
                leftColumns: 4
            },
//"ordering": true,
//"stateSave": false,
//"autoWidth": false,
//"pageLength": 500,
"ajax": {
    "url": "<?php echo base_url(); ?>index.php/master/DTBalance",
    "type": "POST",
    "data": {
        "from_year": year_from,
        "from_to": year_to,
        "programme_search": programme_search
    }
},
drawCallback: function (settings) {
    var table = $('#master_table').dataTable();
    var data_len = table.fnGetData().length;
    if (year_from != '') {
        $('#displayYear').html(year_from);
    } else {
        $('#displayYear').html('<?php echo $current_year; ?>');
    }
    if (data_len == 0) {
        $('tr td:first-child').addClass('none-pointer');
    }
    
    // $('#master_table tr').each(function () {
    //     var rowNode = this.node();
    //     var rowIndex = this.index();
    //     $(rowNode).attr('data-dt-row', rowIndex);
    // });
},
"footerCallback": function (row, data, start, end, display) {
    var api = this.api(),
    data;

    var intVal = function (i) {
        i = inrFormat(i);
        str1 = i.replace(/,/g, "");
        return typeof i === 'string' ?
        i.replace(/[\$,]/g, '') * 1 :
        typeof i === 'number' ?
        i : 0;
    };

    function inrFormat(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var res = x2.substring(0, 3);
        x2 = res;
        var rgx = /(\d+)(\d{3})/;
        var z = 0;
        var len = String(x1).length;
        var num = parseInt((len / 2) - 1);
        while (rgx.test(x1)) {
            if (z > 0) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            } else {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
                rgx = /(\d+)(\d{2})/;
            }
            z++;
            num--;
            if (num == 0) {
                break;
            }
        }
        return x1 + x2;
    }
    total6 = api
    .column(6)
    .data()
    .reduce(function (a, b) {
        var total_amt6 = intVal(a) + intVal(b);
        return inrFormat(total_amt6);
    }, 0);
    pageTotal5 = api.column(5, {page: 'current'}).data().reduce(function (a, b) {
        var total_amt55 = intVal(a) + intVal(b);
        return inrFormat(total_amt55);
    }, 0);

    pageTotal6 = api
    .column(6, {
        page: 'current'
    })
    .data()
    .reduce(function (a, b) {
        var total_amt5 = intVal(a) + intVal(b);
        return inrFormat(total_amt5);
    }, 0);
    pageTotal7 = api
    .column(7, {
        page: 'current'
    })
    .data()
    .reduce(function (a, b) {
        var total_amt4 = intVal(a) + intVal(b);
        return inrFormat(total_amt4);
    }, 0);
    pageTotal8 = api
    .column(8, {
        page: 'current'
    })
    .data()
    .reduce(function (a, b) {
        var total_amt3 = intVal(a) + intVal(b);
        return inrFormat(total_amt3);
    }, 0);
    pageTotal9 = api
    .column(9, {
        page: 'current'
    })
    .data()
    .reduce(function (a, b) {
        var total_amt2 = intVal(a) + intVal(b);
        return inrFormat(total_amt2);
    }, 0);
    pageTotal10 = api
    .column(10, {
        page: 'current'
    })
    .data()
    .reduce(function (a, b) {
        var total_amt1 = intVal(a) + intVal(b);
        return inrFormat(total_amt1);
    }, 0);
    pageTotal11 = api
    .column(11, {
        page: 'current'
    })
    .data()
    .reduce(function (a, b) {
        var total_amt = intVal(a) + intVal(b)
        return inrFormat(total_amt);
    }, 0);
    $(api.column(5).footer()).html(
        addCommas(pageTotal5)
        );
    $(api.column(6).footer()).html(
        addCommas(pageTotal6)
        );
    $(api.column(7).footer()).html(
        addCommas(pageTotal7)
        );
    $(api.column(8).footer()).html(
        addCommas(pageTotal8)
        );
    $(api.column(9).footer()).html(
        addCommas(pageTotal9)
        );
    $(api.column(10).footer()).html(
        addCommas(pageTotal10)
        );
},
'columnDefs': [{
    'orderable': false,
    'targets': [5, 6, 7, 8, 9, 10, 11],
},
{
    targets: [5, 6, 7, 8, 9, 10],
    className: 'dt-body-center'
},
],
"order": [1, 'asc']
});
}

$("#custom_print").click(function () {
    $('#printmodal').modal('show');
});

$("#custom_export").click(function () {
    $('#exportmodal').modal('show');
});

$("#go_export").click(function () {
    var print_amt = $('#export_amt').val();
    $('#exportmodal').modal('hide');
    window.location.href = "<?php echo base_url() . 'index.php/master/balance_export/"+print_amt+"' ?>";
});

$("#go_printer").click(function () {
    var print_amt = $('#print_amt').val();
    $('#printmodal').modal('hide');
    var year_from = $('#year_from').val();
    var year_to = $('#year_to').val();
    var programme_search = $('#programme_search').val();
    $.ajax({
        url: '<?php echo base_url() . 'index.php/master/print_balance_pdf' ?>',
        cache: false,
        type: "POST",
        data: {
            year_from: year_from,
            year_to: year_to,
            programme_search: programme_search,
            print_amt: print_amt
        },
        dataType: "html",
        success: function (response) {
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

function setDatepicker() {
    $('.year_search').datepicker({
// changeMonth: true,
changeYear: true,
viewMode: "years",
// showButtonPanel: true,
dateFormat: 'yy',
});
}

function addCommas(nStr) {
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

function enableEdits() {
    var store = $('#delete_ids').val();
    var arr = store.split(',');
    var len = arr.length;
    for (var a = 0; a < len; a++) {
    }
}

$(document).on('click', '#search_btn', function () {
    master_trigger();
});

$(document).on('click', '#reset_search', function () {
    $('#year_from').val('');
    $('#year_to').val('');
    $('#programme_search').val('');
    master_trigger();
});

$(document).on('click', '#delUser', function () {
    $('#delCount').val('');
    var sel_item = $(".master_check:checkbox:checked").length;
    $('#delCount').html(sel_item);
    if (sel_item > 0)
        $('#deletemodal').modal('show');
});

function deleteids(checkid) {
    var store = $('#delete_ids').val();
    var arr = store.split(',');
    var paylen = $('.master_check').length;
    var payinput = $('.master_check:checked').length;
    var delete_id = $('#master_edit_id_' + checkid).val();

    if (paylen != payinput) {
        $('.master_check_all').prop('checked', false);
    } else {
        $('.master_check_all').prop('checked', true);
    }
    if ($('#master_check_' + checkid).prop('checked') == true) {
        $("#delUser").addClass("clr_red");
        $("#delUser").removeClass("opacity5 none-pointer");
        var idx = $.inArray(delete_id, arr);
        if (idx === -1) {
            arr.push(delete_id)
            arr.join(',')
            $('#delete_ids').val(arr);
        }
    } else {
        var idx = $.inArray(delete_id, arr);
        if (idx === -1) {
        } else {
            arr.splice(arr.indexOf(delete_id), 1);
            arr.join(',')
            $('#delete_ids').val(arr);
        }
        if (arr == '') {
            var new_f = $(".new_field").length;
            if (new_f > 0) {
            } else {
            }
            $("#delUser").removeClass("clr_red");
            $("#delUser").addClass("opacity5 none-pointer");
        }
    }
}


$(document).on('click', '#deleteRecord', function () {
    var id = $('#delete_ids').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>index.php/master/deleteMasterSetting",
        data: {
            id: id,
            field: 'programme_id',
            delval: '-1',
            table: 'master_programme',
        },
        dataType: 'json',
        success: function (msg) {
            $('#deletemodal').modal('hide');
// $('.deletetoast').toast('show');
$('.deleteMsg').removeClass('display-hide');
// setTimeout(function() {
    location.reload();
// }, 3000);
}
});
});

function selectall_chk() {
    if ($('input[name="master_check_all"]:checked').length > 0) {
        $('.master_check').prop('checked', true);
// var favorite = [];
$.each($(".master_check:checked"), function () {
// favorite.push($(this).val());
deleteids($(this).val());
});
} else {
    $('.master_check').prop('checked', false);
    $.each($(".master_check"), function () {
// favorite.push($(this).val());
deleteids($(this).val());
});
}
}

function submit_fields() {
    $('#master_form').submit();
}

$(document).on('input', '.commonAlphaNum', function () {
    if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
        this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
    }
});

</script>

</body>
</html>