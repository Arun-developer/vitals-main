<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Leave - Current Holiday Calendar', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'holiday')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4>Holiday Details</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div>
                        <div class="tab-slider--navform">
                            <ul class="tab-slider--tabsform">
                                <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/leave/current_holiday_calendar'; ?>">Holiday Calendar-Current</a></li>
                                <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/leave/archive_holiday_calendar'; ?>">Holiday Calendar-Archive</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="holiday_form" action="<?php echo base_url() . 'index.php/leave/addHolidays' ?>" method="POST" autocomplete="off">
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <h4>Holidays</h4>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                        <ul class="milestone-links">
                                                            <?php if (count($holiday_detail) == 0 && $partner_id != 1) { ?>
                                                                <li  class="brd-left-onboard">
                                                                    <a href="<?php echo base_url() . 'index.php/leave/copy_holiday'; ?>" class="master_aduser" title="Copy master data from Villgro India"><i class="fas fa-clone"></i> Copy Master</a>
                                                                </li>
                                                            <?php } ?>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15  opacity5 none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </li>
                                                            <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue holiday_submit <?php if (count($holiday_detail) > 0) { ?> opacity5 none-pointer <?php } ?>" onclick="submit_fields();">Save</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table table-hover dt-responsive" id="holiday_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="18px"><input class='form-control holidays_check_all' type='checkbox' name='holidays_check_all' id='holidays_check_all' onchange="selectall_chk();"></th>
                                                        <th>Name of Holiday</th>
                                                        <th>Date</th>
                                                        <th>Type</th>
                                                        <th>Repeat Annually</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                        <input type="hidden" name="delete_ids" id="delete_ids" />
                                    </form>
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
                            <p>you are about to delete <span id="delCount"></span> selected rows, you can't undo this</p>
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

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        holiday_trigger();
    });

    function setDatepicker() {
        $('.holiday_date').datepicker({
            changeMonth: true,
            changeYear: true,
            // showButtonPanel: true,
            dateFormat: 'dd-mm-yy',
        });
    }

    function holiday_trigger() {
        $('#holiday_table').DataTable({
            "bProcessing": true,
            "bServerSide": true,
            "paging": true,
            "ordering": true,
            "info": false,
            "searching": false,
            "pageLength": 10,
            "lengthChange": false,
            "stateSave": false,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/leave/DTholiday",
                "type": "POST"
            },
            drawCallback: function (settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);

                var table = $('#holiday_table').dataTable();
                var data_len = table.fnGetData().length;
                if (data_len == 0) {
                    $('.holidays_check_all').hide();
                    $('tr td:first-child').addClass('none-pointer');
                }
                $('.holidays_check_all').prop('checked', false);
                $('#delete_ids').val('');
                selectall_chk();
                setDatepicker();
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [0],
                }],
            "order": [2, 'asc']
        });
    }

    function enableEdits() {
        var store = $('#delete_ids').val();
        var arr = store.split(',');
        var len = arr.length;
        for (var a = 0; a < len; a++) {
        }
    }

    $(document).on('click', '#delUser', function () {
        $('#delCount').val('');
        var sel_item = $(".holi_check:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0)
            $('#deletemodal').modal('show');
    });

    function deleteids(checkid) {
        var store = $('#delete_ids').val();
        var arr = store.split(',');
        var holilen = $('.holi_check').length;
        var holiinput = $('.holi_check:checked').length;
        var delete_id = $('#holiday_edit_id_' + checkid).val();

        if (holilen != holiinput) {
            $('.holidays_check_all').prop('checked', false);
        } else {
            $('.holidays_check_all').prop('checked', true);
        }
        if ($('#holidays_check_' + checkid).prop('checked') == true) {
            // $(".master_deluser").addClass("clr_red");
            $("#delUser").removeClass("opacity5 none-pointer");
            $('.holiday_submit').removeClass("opacity5 none-pointer");
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
                arr.push(delete_id)
                arr.join(',')
                $('#delete_ids').val(arr);
            }
            $('.inline_field_' + delete_id).attr('readonly', false);
            $('.inline_field_' + delete_id).removeClass('opacity5 none-pointer');
        } else {
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
            } else {
                $('.inline_field_' + delete_id).attr('readonly', true);
                $('.inline_field_' + delete_id).addClass('opacity5 none-pointer');
                arr.splice(arr.indexOf(delete_id), 1);
                arr.join(',')
                $('#delete_ids').val(arr);
            }
            if (arr == '') {
                var new_f = $(".new_field").length;
                if (new_f > 0) {
                    $('.holiday_submit').removeClass("opacity5 none-pointer");
                } else {
                    $('.holiday_submit').addClass("opacity5 none-pointer");
                }
                // $(".master_deluser").removeClass("clr_red");
                $("#delUser").addClass("opacity5 none-pointer");
            }
        }
    }

    $(document).on('click', '#deleteRecord', function () {
        var id = $('#delete_ids').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/leave/deleteLeave",
            data: {
                id: id,
                table: 'hr_holidays',
            },
            dataType: 'json',
            success: function (msg) {
                $('#deletemodal').modal('hide');
                $('.deleteMsg').removeClass('display-hide');
                location.reload();
            }
        });
    });

    function selectall_chk() {
        var len = $('.holi_check').length;

        if ($('input[name="holidays_check_all"]:checked').length > 0) {
            $('.holi_check').prop('checked', true);
            // var favorite = [];
            $.each($(".holi_check:checked"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        } else {
            $('.holi_check').prop('checked', false);
            $.each($(".holi_check"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        }
    }

    function submit_fields() {
        $('#holiday_form').submit();

    }

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

    $(document).on('click', '#addMore', function () {
        var dyn = $("#holiday_table tr").length;
        var empty_dT = $(".dataTables_empty").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="holiday_tr_' + i + '" class="holiday_more"><input type="hidden" name="holiday_edit_id[]" id="holiday_edit_id_' + i + '" value="0"><td class="valign-center"><input class="form-control holi_check new_field" type="checkbox" name="holidays_check" id="holidays_check_' + i + '" onchange="deleteids(this.value);" value="' + i + '"></td>';
        datas += '<td><input type="text" class="form-control commonAlphaNum inline_field_' + i + '" name="holiday_name[]" id="holiday_name_' + i + '" value="" placeholder="Enter name" /></td>';
        datas += '<td><div class="position-relative"><input type="text" name="holiday_date[]" id="holiday_date_' + i + '" class="form-control holiday_date inline_field_' + i + '" value="" placeholder="dd-mm-yyyy" /><span class="calendar-position"><i class="far fa-calendar-alt"></i></span></div></td>';
        datas += '<td><select class="form-control inline_field_' + i + '" name="holiday_type[]" id="holiday_type_' + i + '" ><option value="">--Select--</option><option value="1">Full Day</option><option value="2" >Half Day</option><option value="3">Optional Holiday</option></select></td>';
        datas += '<td><select class="form-control inline_field_' + i + '" name="holiday_repeat[]" id="holiday_repeat_' + i + '" ><option value="">--Select--</option><option value="1" >Yes</option><option value="2" >No</option></select></td></tr>';
        // $(datas).insertBefore($('#holiday_tr_1'));
        $("#holiday_table tbody").prepend(datas);
        $('.holiday_submit').removeClass("opacity5 none-pointer");
        setDatepicker();
        if (empty_dT = 1) {
            $(".dataTables_empty").parent('tr').remove();
        }
    });
</script>

</body>
</html>