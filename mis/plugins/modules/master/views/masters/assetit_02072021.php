<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - IT Asset', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'asset_master')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Asset Settings</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/master/asset/general'; ?>">General Asset</a></li>
                                    <li role="presentation" <?php if ($master_type == 'IT Asset') { ?>class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/master/asset/it'; ?>">IT Asset</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/master/vendor_master'; ?>">Vendor Master</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/master/general_asset'; ?>">General Asset Types</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/master/it_asset'; ?>">IT Asset Types</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new pad-none">
                                    <div style="height: 10px;"></div>
                                    <form id="filter_job" action="<?php echo base_url() . 'index.php/master/asset_export/' . $type; ?>" class="pad-hr15 wdt-100" method="POST" autocomplete="off">
                                        <div class="row spec-label">
                                            <div class="col-12 col-md-12 col-lg-3 col-xl-3">
                                                <label>Asset Type</label>
                                                <div class="form-group mar-bt8  ">
                                                    <select class="form-control " id="type_search" name="type_search">
                                                        <option value="">--Select Asset Type--</option>
                                                        <?php foreach ($assettype as $a_types) { ?>
                                                            <option value="<?= $a_types['master_id']; ?>"><?= $a_types['master_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <label class="error hidden" id="sel_error">Select type</label>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-3 col-xl-3">
                                                <label>Asset Name</label>
                                                <div class="form-group has-search-right mar-bt8 ">
                                                    <input type="text" id="asset_name" value="<?php if (isset($asset_name) && $asset_name != '') echo $asset_name; ?>" name="asset_name" class="form-control" placeholder="Asset Name">
                                                </div>
                                                <label class="error hidden" id="txt_error">Enter value</label>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-3 col-xl-3">
                                                <label>Asset Number</label>
                                                <div class="form-group mar-bt8">
                                                    <input type="text" id="asset_number" value="<?php if (isset($asset_number) && $asset_number != '') echo $asset_number; ?>" name="asset_number" class="form-control" placeholder="Asset number">
                                                </div>
                                                <label class="error hidden" id="txt_error">Enter value</label>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-3 col-xl-3">
                                                <label>Asset Code</label>
                                                <div class="form-group mar-bt8 ">
                                                    <input type="text" id="asset_code" value="<?php if (isset($asset_code) && $asset_code != '') echo $asset_code; ?>" name="asset_code" class="form-control" placeholder="Asset code">
                                                </div>
                                                <label class="error hidden" id="txt_error">Enter value</label>
                                            </div>
                                        </div>
                                        <div class="row spec-label">
                                            <div class="col-12 col-md-12 col-lg-3 col-xl-3">
                                                <label>Purchase Date</label>
                                                <div class="form-group mar-bt8">
                                                    <input type="text" id="purchase_date" value="<?php if (isset($purchase_date) && $purchase_date != '') echo $purchase_date; ?>" name="purchase_date" class="form-control asset_date" placeholder="Select purchase date">
                                                </div>
                                                <label class="error hidden" id="txt_error">Enter value</label>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-3 col-xl-3">
                                                <label>To</label>
                                                <div class="form-group mar-bt8">
                                                    <input type="text" id="purchaseto_date" value="<?php if (isset($purchaseto_date) && $purchaseto_date != '') echo $purchaseto_date; ?>" name="purchaseto_date" class="form-control asset_date" placeholder="Select purchase to date">
                                                </div>
                                                <label class="error hidden" id="txt_error">Enter value</label>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-3 col-xl-3">
                                                <div style="height: 30px;"></div>
                                                <ul class="vitals-links">
                                                    <li><label>Item Not Available</label></li>
                                                    <li><input type="checkbox" name="not_available" id="not_available" value="1" onchange="reasonshow();" /></li>
                                                </ul>
                                                <label class="error hidden" id="sel_error">Select type</label>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-3 col-xl-3 reasondiv display-hide">
                                                <div style="height: 20px;"></div>
                                                <div class="form-group mar-bt8 ">
                                                    <select class="form-control " id="reason_search" name="reason_search">
                                                        <option value="">--Select Reason--</option>
                                                        <option value="lost">Lost</option>
                                                        <option value="stolen">Stolen</option>
                                                        <option value="not working">Not Working</option>
                                                        <option value="others">Others</option>
                                                    </select>
                                                </div>
                                                <label class="error hidden" id="sel_error">Select type</label>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-3 col-xl-3">
                                                <div style="height: 10px;"></div>
                                                <ul class="vitals-links">
                                                    <li><a href="javascript:" id="search_btn" class="vital_yellow_btn pad-hr15 wdt_100">Search</a></li>
                                                    <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row justify-content-end">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 text-right">
                                            <ul class="vitals-links ">
                                                <li><a id="export" class="master_aduser"><span><i class="fas fa-download"></i></span> Export</a></li>
                                                <li>
                                                    <a href="<?php echo base_url() . 'index.php/master/asset/' . $type . '/add'; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add Assets</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="master_deluser none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive" id="master_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"><input class='form-control master_check_all' type='checkbox' name='master_check_all' id='master_check_all' onchange="selectall_chk();"></th>
                                                        <th width="5%">Asset Type</th>
                                                        <th width="10%">Asset Number</th>
                                                        <th width="5%">Asset Code</th>
                                                        <th width="10%">Asset Name</th>
                                                        <th width="10%">Brand Name</th>
                                                        <th width="10%">Model</th>
                                                        <th width="10%">Serial Number</th>
                                                        <th width="5%">Purchased Date</th>
                                                        <th width="5%">Warranty Expiry Date</th>
                                                        <th width="5%">Vendor</th>
                                                        <th width="5%">AMC</th>
                                                        <th width="5%">AMC Vendor</th>
                                                        <th width="5%">Available Status</th>
                                                        <th width="5%">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" name="delete_ids" id="delete_ids" />
                                    <input type="hidden" name="master_type" id="master_type" value="<?php echo $master_type; ?>" />
                                </div>
                                <div  style="display:none;"  id="load_print"></div>
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

<style type="text/css">
    div.dataTables_scrollHead table thead tr th:first-child,
    .vitalMasterDataTbl table.dataTable tbody tr td:first-child {
        min-width: 20px !important;
        max-width: 20px !important;
    }

    table.dataTable thead .sorting_desc:after {
        position: absolute;
        top: 10px;
        right: -3px;
        display: block;
        font-family: 'Glyphicons Halflings';
        opacity: 0.5;
    }

    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting:after {
        top: 10px;
        right: 0px;
    }
    .plan-structure-vital .plan-structure-new{
        overflow-y: auto !important;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        master_trigger();
        setDatepicker();
    });

    function setDatepicker() {
        $('.asset_date').datepicker({
            changeMonth: true,
            changeYear: true,
            // showButtonPanel: true,
            dateFormat: 'dd-mm-yy',
        });
    }

    $("#go_printer").click(function () {
        $.ajax({
            url: '<?php echo base_url() . 'index.php/master/print_asset_pdf' ?>',
            cache: false,
            type: "POST",
            data: {tab: '<?php echo $type; ?>'},
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

    function reasonshow() {
        if ($('#not_available').prop('checked') == true) {
            $('.reasondiv').removeClass('display-hide');
        } else {
            $('.reasondiv').addClass('display-hide');
        }
    }

    function master_trigger() {
        var type_search = $('#type_search').val();
        var asset_name = $('#asset_name').val();
        var asset_number = $('#asset_number').val();
        var asset_code = $('#asset_code').val();
        var purchase_date = $('#purchase_date').val();
        var purchaseto_date = $('#purchaseto_date').val();
        var reason_search = $('#reason_search').val();
        $('#master_table').DataTable({
            "scrollX": true,
            "initComplete": function (settings, json) {
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
            "responsive": false,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "bServerSide": true,
            "stateSave": false,
            "autoWidth": false,
            "pageLength": 10,
            "scrollY": '288px',
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/master/DTAsset",
                "type": "POST",
                "data": {
                    "type": 'it',
                    "type_search": type_search,
                    "asset_name": asset_name,
                    "asset_number": asset_number,
                    "asset_code": asset_code,
                    "purchase_date": purchase_date,
                    "purchaseto_date": purchaseto_date,
                    // "prgramme": prgramme,
                    "reason_search": reason_search
                }
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#master_table tbody').on('click', 'tr', function (e) {
                    if (!$(e.target).is("input")) {
                        var edited_id = $(":checkbox:eq(0)", this).val();
                        var slug = $('#master_edit_id_' + edited_id).val();
                        $(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/master/asset/<?= $type; ?>/edit/' + slug);
                        window.location = $(this).attr('href');
                        return false;
                    }
                });
            },
            drawCallback: function (settings) {
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
                selectall_chk();
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [0, 12],
                }],
            "order": [1, 'asc']
        });
    }

    function enableEdits() {
        var store = $('#delete_ids').val();
        var arr = store.split(',');
        var len = arr.length;
        for (var a = 0; a < len; a++) {
        }
    }

    $(document).on('click', '#export', function () {
        $("#filter_job").submit();
    });

    $(document).on('click', '#search_btn', function () {
        master_trigger();
    });

    $(document).on('click', '#reset_search', function () {
        $('#type_search').val('');
        $('#asset_name').val('');
        $('#asset_number').val('');
        $('#asset_code').val('');
        $('#purchase_date').val('');
        $('#purchaseto_date').val('');
        $('#reason_search').val('');
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
                field: 'asset_id',
                delval: '0',
                table: 'master_asset',
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

    $(document).on('click', '.master_check_all', function () {
        if (!$(this).is(":checked")) {
            $('.master_check_all').prop('checked', false);
            $('.master_check').prop('checked', false);
        }
    });

</script>

</body>
</html>