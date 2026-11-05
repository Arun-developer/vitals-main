<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Leave - Leave Type', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'leave_type')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4>Leave Type</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="leavetype_form" action="<?php echo base_url() . 'index.php/leave/addLeavetype' ?>" method="POST" autocomplete="off">
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <h4>Leave Types</h4>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                        <ul class="milestone-links">
                                                            <?php if (php72_count($leave_types) == 0 && $partner_id != 1) { ?>
                                                                <li  class="brd-left-onboard">
                                                                    <a href="<?php echo base_url() . 'index.php/leave/copy_leavetype'; ?>" class="master_aduser" title="Copy master data from Villgro India"><i class="fas fa-clone"></i> Copy Master</a>
                                                                </li>
                                                            <?php } ?>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15  opacity5 none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </li>
                                                            <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue leavetype_submit <?php if (php72_count($leave_types) > 0) { ?> opacity5 none-pointer <?php } ?>" onclick="submit_fields();">Save</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table table-hover dt-responsive" id="leavetype_table">
                                                <thead>
                                                    <tr>
                                                        <th><input class='form-control type_check_all' type='checkbox'  name='type_check_all' id='type_check_all' onchange="selectall_chk();" ></th>

                                                        <th width="15%">Leave Type ID</th>
                                                        <th width="30%">Leave Type</th>
                                                        <th width="15%">Restrictions</th>
                                                        <th width="35%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                            <input type="hidden" name="delete_ids" id="delete_ids" />
                                            <input type="hidden" name="restrict_ids" id="restrict_ids" value="<?= $restrictids; ?>" />
                                            <input type="hidden" name="code_count" id="code_count" value="<?= $count_types; ?>" />
                                        </div>
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
        setTimeout(function () {
            $('.success').addClass('display-hide');
        }, 3000);

        leavetype_trigger();
    });

    function leavetype_trigger() {
        $('#leavetype_table').DataTable({
            "bProcessing": true,
            "bSortable": false,
            "destroy": true,
            "bDestroy": true,
            "paging": true,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "bServerSide": true,
            "stateSave": false,
            "autoWidth": false,
            "pageLength": 10,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/leave/DTLeavetype",
                "type": "POST",
            },
            drawCallback: function (settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);

                var table = $('#leavetype_table').dataTable();
                var data_len = table.fnGetData().length;
                if (data_len == 0) {
                    $('.type_check_all').hide();
                    $('tr td:first-child').addClass('none-pointer');
                }
                $('.type_check_all').prop('checked', false);
                $('#delete_ids').val('');
                selectall_chk();
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [0, 3, 4],
                }],
            "order": [2, 'asc']
        });
    }

    $(document).on('click', '#delUser', function () {
        $('#delCount').val('');
        var sel_item = $(".typecheck:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0)
            $('#deletemodal').modal('show');
    });

    function deleteids(checkid) {
        var store = $('#delete_ids').val();
        var arr = store.split(',');
        var leavelen = $('.typecheck').length;
        var leaveinput = $('.typecheck:checked').length;
        var delete_id = $('#leavetype_edit_id_' + checkid).val();
        if (leavelen != leaveinput) {
            $('.type_check_all').prop('checked', false);
        } else {
            $('.type_check_all').prop('checked', true);
        }

        if ($('#leave_type_check_' + checkid).prop('checked') == true) {
            // $("#delUser").addClass("clr_red");
            $("#delUser").removeClass("opacity5 none-pointer");
            $('.leavetype_submit').removeClass("opacity5 none-pointer");
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
                arr.push(delete_id)
                arr.join(',')
                $('#delete_ids').val(arr);
            }
            $('.inline_field_' + delete_id).attr('readonly', false);
            $('.check_field_' + delete_id).attr('readonly', false);
            $('.check_field_' + delete_id).attr('disabled', false);
        } else {
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
            } else {
                $('.inline_field_' + delete_id).attr('readonly', true);
                $('.check_field_' + delete_id).attr('readonly', true);
                $('.check_field_' + delete_id).attr('disabled', true);
                arr.splice(arr.indexOf(delete_id), 1);
                arr.join(',')
                $('#delete_ids').val(arr);
            }
            if (arr == '') {
                var new_f = $(".new_field").length;
                if (new_f > 0) {
                    $('.leavetype_submit').removeClass("opacity5 none-pointer");
                } else {
                    $('.leavetype_submit').addClass("opacity5 none-pointer");
                }
                // $(".master_deluser").removeClass("clr_red");
                $("#delUser").addClass("opacity5 none-pointer");
            }
        }
    }

    function check_restrict(checkid) {
        var store = $('#restrict_ids').val();
        var arr = store.split(',');

        var restrict_id = $('#leave_restrictions_' + checkid).val();
        if ($('#leave_restrictions_' + checkid).prop('checked') == true) {
            var idx = $.inArray(restrict_id, arr);
            if (idx === -1) {
                arr.push(restrict_id)
                arr.join(',')
                $('#restrict_ids').val(arr);
            }
        } else {
            var idx = $.inArray(restrict_id, arr);
            if (idx === -1) {
            } else {
                arr.splice(arr.indexOf(restrict_id), 1);
                arr.join(',')
                $('#restrict_ids').val(arr);
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
                table: 'hr_leave_type',
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
        if ($('input[name="type_check_all"]:checked').length > 0) {
            $('.typecheck').prop('checked', true);
            // var favorite = [];
            $.each($(".typecheck:checked"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        } else {
            $('.typecheck').prop('checked', false);
            $.each($(".typecheck"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        }
    }

    function submit_fields() {
        $('#leavetype_form').submit();
    }

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

    $(document).on('click', '#addMore', function () {
        var code_count = $('#code_count').val();
        var increa_count = parseInt(code_count) + 1;
        var three_digi = String(increa_count).padStart(3, '0');
        var type_code = 'LTY' + three_digi;
        var dyn = $("#leavetype_table tr").length + 1;
        var empty_dT = $(".dataTables_empty").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="leavetype_tr_' + i + '" class="leavetype_more"><input type="hidden" name="leavetype_edit_id[]" id="leavetype_edit_id_' + i + '" value="0"> <td class="valign-center"><input class="form-control new_field typecheck" type="checkbox" name="leave_type_check[]" id="leave_type_check_' + i + '" onchange="deleteids(this.value);" value="' + i + '"></td>';
        datas += '<td><input type="text" class="form-control" readonly name="leave_type_id[]" id="leave_type_id_' + i + '" value="' + type_code + '" placeholder="Enter leave type id" /></td>';
        datas += '<td><input type="text" name="leave_type_name[]" id="leave_type_name_' + i + '" class="form-control commonAlphaNum inline_field_' + i + '" value="" placeholder="Enter name" /></td>';
        datas += '<td><input class="form-control check_field_' + i + '" type="checkbox" name="leave_restrictions[]" id="leave_restrictions_' + i + '" onchange="check_restrict(' + i + ');" value="' + type_code + '"></td><td></td></tr>';

        $("#leavetype_table tbody").prepend(datas);
        $('.leavetype_submit').removeClass("opacity5 none-pointer");
        $('#code_count').val(increa_count);
        setDatepicker();
        if (empty_dT = 1) {
            $(".dataTables_empty").parent('tr').remove();
        }
    });

</script>

</body>
</html>