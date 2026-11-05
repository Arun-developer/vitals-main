<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Visitors Log', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'visitors_log')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4>Visitors Log</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new pad-none">
                                    <div style="height: 10px;"></div>
                                    <form id="filter_job" action="<?php echo base_url() . 'index.php/master/visitor_export'; ?>" class="pad-lt15px" method="POST" autocomplete="off">
                                        <input type="hidden" name="export_type" id="export_type" >
                                        <div class="row leaveLabel spec-label">
                                            <div class="col-xl-12 col-lg-7 col-md-7 col-12" >
                                                <ul class="vitals-links">
                                                    <li class="mob_fulfill">
                                                        <label class="form-group">Employee Name</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <select class="form-control" name="userid" id="userid">
                                                                <option value="">--Select Empoyee--</option>
                                                                <?php foreach ($userList as $list) { ?>
                                                                    <option value="<?= $list['id'] ?>"><?= $list['user_name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div id="branch_err"></div>
                                                    </li>
                                                    <li class="mob_fulfill" id="template_id">
                                                        <label class="form-group">Log Date</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <input type="text" id="date_search" value="" name="date_search" class="form-control date_search" placeholder="Select date">
                                                        </div>
                                                        <div id="branch_err"></div>
                                                    </li>
                                                    <li class="mob_fulfill">
                                                        <label class="form-group">Log Month</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <select name="month_search" id="month_search" class='form-control'>
                                                                <option value="">Month</option>
                                                                <?php
                                                                $monthArray = array('1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
                                                                foreach ($monthArray as $key => $value) {
                                                                    ?>
                                                                    <option value="<?= $key ?>" >
                                                                        <?= $value ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </li>

                                                    <li class="mob_fulfill">
                                                        <label class="form-group">Log Year</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <select name="year_search" id="year_search" class="form-control">
                                                                <option value="">Year</option>
                                                                <?php for ($i = 2011; $i <= date('Y') + 10; $i++) { ?>
                                                                    <option value="<?= $i ?>">
                                                                        <?= $i ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
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
                                                <li><a id="export" class="master_aduser" ><span><i class="fas fa-download"></i></span> Export</a></li>
                                                <li>
                                                    <a href="<?php echo base_url() . 'index.php/master/visitors_log/add'; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add Visitors Log</a>
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
                                                        <th width="5%"><input class='form-control master_check_all' type='checkbox' name='master_check_all' id='master_check_all' onchange="selectall_chk();" style="width: 20px;"></th>
                                                        <th width="15%">Date</th>
                                                        <th width="15%">Name of visitor</th>
                                                        <th width="15%">Name of organization</th>
                                                        <th width="10%">Intending to meet</th>
                                                        <th width="10%">Purpose</th>
                                                        <th width="10%">Time In</th>
                                                        <th width="10%">Time Out</th>
                                                        <th width="10%">Innovation</th>
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
                                    <option value="1">Visitor Log</option>
                                    <option value="2">Visitor Innovation</option>
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

<style type="text/css">
    .plan-structure-vital .plan-structure-new{
        overflow-y: auto !important;
    }
</style>
<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">

    $("#export").click(function () {
        $('#exportmodal').modal('show');
    });

    $("#go_export").click(function () {
        $("#export_type").val('');
        $('#exportmodal').modal('hide');
        var print_amt = $('#export_amt').val();
        if (print_amt != '') {
            $("#export_type").val(print_amt);
        }
        $("#filter_job").submit();
        //$('#filter_job').modal('hide');
        // window.location.href = "<?php echo base_url() . 'index.php/master/balance_export/"+print_amt+"' ?>";
    });

    $(document).ready(function () {
        master_trigger();
        setDatepicker();
    });

    function setDatepicker() {
        $('.date_search').datepicker({
            changeMonth: true,
            changeYear: true,
            // showButtonPanel: true,
            dateFormat: 'yy-mm-dd',
        });
    }

    $("#go_printer").click(function () {
        $.ajax({
            url: '<?php echo base_url() . 'index.php/master/print_visitor_pdf' ?>',
            cache: false,
            type: "POST",
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
        var userid = $('#userid').val();
        var date_search = $('#date_search').val();
        var month_search = $('#month_search').val();
        var year_search = $('#year_search').val();
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
                "url": "<?php echo base_url(); ?>index.php/master/DTVisitorslog",
                "type": "POST",
                "data": {
                    "userid": userid,
                    "date_search": date_search,
                    "month_search": month_search,
                    "year_search": year_search
                }
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#master_table tbody').on('click', 'tr', function (e) {
                    if (!$(e.target).is("input")) {
                        var edited_id = $(":checkbox:eq(0)", this).val();
                        var slug = $('#master_edit_id_' + edited_id).val();
                        $(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/master/visitors_log/edit/' + slug);
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
                    'targets': [0, 8],
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

    $(document).on('click', '#search_btn', function () {
        master_trigger();
    });

    $(document).on('click', '#reset_search', function () {
        $('#userid').val('');
        $('#date_search').val('');
        $('#month_search').val('');
        $('#year_search').val('');
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
                field: 'log_id',
                delval: '0',
                table: 'visitors_log',
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