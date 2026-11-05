<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Dispatch Inward', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'dispatch_inward')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Dispatch Inward</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" <?php if ($master_type == 'pending') { ?>class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/master/dispatch_inward/pending'; ?>">Pending Dispatches</a></li>
                                    <li role="presentation" <?php if ($master_type == 'confirmed') { ?>class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/master/dispatch_inward/confirmed'; ?>">Handed Over</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new pad-none">
                                    <div style="height: 10px;"></div>
                                    <form id="filter_job" action="<?php echo base_url() . 'index.php/master/inward_export/' . $master_type; ?>" class="pad-lt15px" method="POST" autocomplete="off">
                                        <div class="row leaveLabel spec-label">
                                            <div class="col-xl-12 col-lg-7 col-md-7 col-12">
                                                <ul class="vitals-links">
                                                    <li class="mob_fulfill">
                                                        <label class="form-group">Employee Name</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <select class="form-control" name="emp_search" id="emp_search">
                                                                <option value=''>--Select Employee--</option>
                                                                <?php foreach ($userList as $list) { ?>
                                                                    <option value="<?= $list['id'] ?>"><?= $list['user_name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div id="branch_err"></div>
                                                    </li>
                                                    <li class="mob_fulfill" id="template_id">
                                                        <label class="form-group">Received Date From</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <input type="text" id="handover_from" value="" name="handover_from" class="form-control received_date" placeholder="Received date from">
                                                        </div>
                                                        <div id="branch_err"></div>
                                                    </li>
                                                    <li class="mob_fulfill">
                                                        <label class="form-group">Received Date To</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <input type="text" id="handover_to" value="" name="handover_to" class="form-control received_date" placeholder="Received date to">
                                                        </div>
                                                        <div id="branch_err"></div>
                                                    </li>
                                                    <li><a href="javascript:" id="search_btn" class="vital_yellow_btn pad-hr15 wdt_100">Search</a></li>
                                                    <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-12 col-md-12 text-right">
                                            <ul class="vitals-links">
                                                <li><a class="master_aduser" id="export"><span><i class="fas fa-download"></i></span> Export</a></li>
                                                <?php if ($master_type == 'pending') { ?>
                                                    <li>
                                                        <a href="javascript:void(0)" class="master_deluser none-pointer" id="handover"> Handover</a>
                                                    </li>
                                                <?php } ?>
                                                <li>
                                                    <a href="<?php echo base_url() . 'index.php/master/dispatch_inward/pending/add'; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add Inward Dispatch</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="master_deluser none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover" id="master_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"><input class='form-control master_check_all' type='checkbox' name='master_check_all' id='master_check_all' onchange="selectall_chk();"></th>
                                                        <th width="10%">Received Date</th>
                                                        <th width="10%">Addressed To</th>
                                                        <th width="10%">Person's Name</th>
                                                        <th width="15%">Company's Name</th>
                                                        <th width="10%">Content</th>
                                                        <th width="10%">Vendor</th>
                                                        <th width="10%">Status</th>
                                                        <?php if ($master_type == 'confirmed') { ?>
                                                            <th width="10%">Handover To</th>
                                                            <th width="10%">Handover Date</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" name="delete_ids" id="delete_ids" />
                                    <input type="hidden" name="master_type" id="master_type" value="<?php echo $master_type; ?>" />
                                    <input type="hidden" name="inward_edit" id="inward_edit" />
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

<div class="modal" id="handoverdiv" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <form id="handover_form" action="<?php echo base_url() . 'index.php/master/addhandover_to/'; ?>" class="pad-lt15px" method="POST" autocomplete="off">
                            <div class="form-group">
                                <label>Handover To <span class="text-danger">*</span></label>
                                <select class="form-control" name="handover_to" id="handover_to">
                                    <option value="">--Select--</option>
                                    <?php foreach ($userList as $ulist) {
                                        ?>
                                        <option value="<?= $ulist['id'] ?>"><?= $ulist['user_name']; ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Handover Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control additionalInput" name="handover_date" id="handover_date" value="">
                            </div>
                            <input type="submit" name="handoversubmit" id="handoversubmit" value="Submit" />
                            <input type="hidden" name="inward_handoverto" id="inward_handoverto" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="delCount" id="delCount" />
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .plan-structure-vital .plan-structure-new {
        overflow-y: auto !important;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $("#export").click(function () {
        $("#filter_job").submit();
    });

    $('#handover_form').validate({
        rules: {
            handover_to: "required",
            handover_date: "required"

        },
        messages: {
            handover_to: "Select handover to",
            handover_date: "Select handover date"
        }
    });

    $(document).ready(function () {
        master_trigger();
        setDatepicker();
    });

    $("#go_printer").click(function () {
        $.ajax({
            url: '<?php echo base_url() . 'index.php/master/print_inward_pdf' ?>',
            cache: false,
            type: "POST",
            data: {
                tab: '<?= $master_type; ?>'
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

    function master_trigger() {
        var emp_search = $('#emp_search').val();
        var handover_from = $('#handover_from').val();
        var handover_to = $('#handover_to').val();
        var master_type = $('#master_type').val();

        $('#master_table').DataTable({
            "scrollX": true,
            "initComplete": function (settings, json) {
                $('.dataTables_scrollBody thead tr').css({
                    visibility: 'collapse'
                });
            },
            "bProcessing": true,
            "bSortable": true,
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
            "scrollY": '288px',
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/master/DTInward",
                "type": "POST",
                "data": {
                    "emp_search": emp_search,
                    "handover_from": handover_from,
                    "handover_to": handover_to,
                    "master_type": master_type
                }
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#master_table tbody').on('click', 'tr', function (e) {
                    if (!$(e.target).is("input")) {
                        var edited_id = $(":checkbox:eq(0)", this).val();
                        var slug = $('#master_edit_id_' + edited_id).val();
                        $(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/master/dispatch_inward/<?= $master_type; ?>/edit/' + slug);
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
                'targets': [0],
            }],
            "order": [1, 'asc']
        });
    }

    function setDatepicker() {
        $("#handover_from").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function () {
                var dt2 = $('#handover_to');
                var startDate = $(this).datepicker('getDate');
                startDate.setDate(startDate.getDate() + 30);
                var minDate = $(this).datepicker('getDate');
                var dt2Date = dt2.datepicker('getDate');
                var dateDiff = (dt2Date - minDate) / (86400 * 1000);
                if (dt2Date == null || dateDiff < 0) {
                    dt2.datepicker('setDate', minDate);
                } else if (dateDiff > 30) {
                    dt2.datepicker('setDate', startDate);
                }
                dt2.datepicker('option', 'maxDate', startDate);
                dt2.datepicker('option', 'minDate', minDate);
            }
        });
        $('#handover_to').datepicker({
            dateFormat: "yy-mm-dd",
        });

        $('#handover_date').datepicker({
            changeMonth: true,
            changeYear: true,
            // showButtonPanel: true,
            dateFormat: 'dd-mm-yy',
        });
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

    $(document).on('click', '#handover', function () {
        $('#handoverdiv').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });
        var in_edit = $('#inward_edit').val();
        $('#inward_handoverto').val(in_edit);
    });

    $(document).on('click', '#reset_search', function () {
        $('#emp_search').val('');
        $('#handover_from').val('');
        $('#handover_to').val('');
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
            if (payinput == 1) {
                $('#inward_edit').val(delete_id);
                $("#handover").addClass("clr_red");
                $("#handover").removeClass("opacity5 none-pointer");
            } else {
                $('#inward_edit').val('');
                $("#handover").removeClass("clr_red");
                $("#handover").addClass("opacity5 none-pointer");
            }

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
                $("#handover").removeClass("clr_red");
                $("#handover").addClass("opacity5 none-pointer");
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
                field: 'inward_id',
                delval: '0',
                table: 'dispatch_inward',
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

    $(document).on('click', '.master_check_all', function () {
        if (!$(this).is(":checked")) {
            $('.master_check_all').prop('checked', false);
            $('.master_check').prop('checked', false);
        }
    });

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