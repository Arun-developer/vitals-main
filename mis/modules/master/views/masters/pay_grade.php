<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Pay Grade', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'pay_grade')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4>Pay Grade</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new pad-none">
                                    <div style="height: 15px;"></div>
                                    <form id="filter_job" action="" class="pad-lt15px" method="POST" autocomplete="off">
                                        <ul class="vitals-links spec-label">
                                            <li class="mob_fulfill">
                                                <div class="form-group mar-bt8  wdt_180">
                                                    <select class="form-control wdt_180" id="search_type" name="search_type">
                                                        <option value="">--Search by--</option>
                                                        <option value="1" <?php
                                                        if ($search_type == "1") {
                                                            echo "selected";
                                                        }
                                                        ?>>Pay Grade</option>
                                                        <option value="2" <?php
                                                        if ($search_type == "2") {
                                                            echo "selected";
                                                        }
                                                        ?>>Status</option>
                                                    </select>
                                                </div>
                                                <label class="error hidden" id="sel_error">Select type</label>
                                            </li>
                                            <li class="mob_fulfill">
                                                <div class="form-group has-search-right mar-bt8 wdt_180">
                                                    <a class="form-control-feedback" id="search_btn"><span class="fa fa-search"></span></a>
                                                    <input type="text" id="filter_search" value="<?php if (isset($filter_search) && $filter_search != '') echo $filter_search; ?>" name="filter_search" class="form-control" placeholder="Search">
                                                </div>
                                                <label class="error hidden" id="txt_error">Enter value</label>
                                            </li>
                                            <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                        </ul>
                                    </form>
                                    <div style="height: 10px;"></div>
                                    <form id="paygrade_form" action="<?php echo base_url() . 'index.php/master/addPaygrade' ?>" method="POST" autocomplete="off">
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <h4>Pay Grade</h4>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                        <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15  opacity5 none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </li>
                                                            <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue paygrade_submit <?php if (php72_count($pay_grade) > 0) { ?> opacity5 none-pointer <?php } ?>" onclick="submit_fields();">Save</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table table-hover dt-responsive" id="paygrade_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"><input class='form-control paygrade_check_all' type='checkbox' name='paygrade_check_all' id='paygrade_check_all' onchange="selectall_chk();"></th>
                                                        <th width="30%">Pay Grade</th>
                                                        <th width="30%">Status</th>
                                                        <th></th>
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
    .plan-structure-vital .plan-structure-new{
        overflow-y: auto !important;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        paygrade_trigger();
    });

    $(document).on('click', '#search_btn', function () {
        var search = $('#search_type').val();
        var search_text = $('#filter_search').val();
        var sr_error = 0;
        if (search == '') {
            sr_error = 1;
            $('#sel_error').removeClass('hidden');
            return false;
        } else {
            sr_error = 0;
            $('#sel_error').addClass('hidden');
        }

        if (search_text == '') {
            sr_error = 1;
            $('#txt_error').removeClass('hidden');
            return false;
        } else {
            sr_error = 0;
            $('#txt_error').addClass('hidden');
        }

        if (sr_error == 0) {
            $('#sel_error, #txt_error').addClass('hidden');
            paygrade_trigger();
            return false;
        }
    });

    $('#filter_search').keypress(function (e) {
        if (e.which == 13) {
            var search = $('#search_type').val();
            var search_text = $('#filter_search').val();
            var sr_error = 0;
            if (search == '') {
                sr_error = 1;
                $('#sel_error').removeClass('hidden');
                return false;
            } else {
                sr_error = 0;
                $('#sel_error').addClass('hidden');
            }

            if (search_text == '') {
                sr_error = 1;
                $('#txt_error').removeClass('hidden');
                return false;
            } else {
                sr_error = 0;
                $('#txt_error').addClass('hidden');
            }

            if (sr_error == 0) {
                $('#sel_error, #txt_error').addClass('hidden');
                paygrade_trigger();
                return false;
            }
        }
    });

    function paygrade_trigger() {
        var filter_search = $('#filter_search').val();
        var search_type = $('#search_type').val();
        $('#paygrade_table').DataTable({
            "bProcessing": true,
            "bSortable": true,
            "destroy": true,
            "bDestroy": true,
            "paging": true,
            "ordering": true,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "bServerSide": true,
            "stateSave": false,
            "autoWidth": false,
            "pageLength": 10,
            "scrollY": '333px',
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/master/DTPaygrade",
                "type": "POST",
                "data": {
                    "search_field": filter_search,
                    "search_type": search_type
                }
            },
            drawCallback: function (settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);

                var table = $('#paygrade_table').dataTable();
                var data_len = table.fnGetData().length;
                if (data_len == 0) {
                    $('.paygrade_check_all').hide();
                    $('tr td:first-child').addClass('none-pointer');
                }
                $('.paygrade_check_all').prop('checked', false);
                $('#delete_ids').val('');
                selectall_chk();
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [0, 3],
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

    $(document).on('click', '#reset_search', function () {
        $('#filter_search').val('');
        $('#search_type').val('');
        paygrade_trigger();
    });

    $(document).on('click', '#delUser', function () {
        $('#delCount').val('');
        var sel_item = $(".pay_check:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0)
            $('#deletemodal').modal('show');
    });

    function deleteids(checkid) {
        var store = $('#delete_ids').val();
        var arr = store.split(',');
        var paylen = $('.pay_check').length;
        var payinput = $('.pay_check:checked').length;
        var delete_id = $('#grade_edit_id_' + checkid).val();

        if (paylen != payinput) {
            $('.paygrade_check_all').prop('checked', false);
        } else {
            $('.paygrade_check_all').prop('checked', true);
        }
        if ($('#paygrade_check_' + checkid).prop('checked') == true) {
            // $(".master_deluser").addClass("clr_red");
            $("#delUser").removeClass("opacity5 none-pointer");
            $('.paygrade_submit').removeClass("opacity5 none-pointer");
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
                arr.push(delete_id)
                arr.join(',')
                $('#delete_ids').val(arr);
            }
            $('.inline_field_' + delete_id).attr('readonly', false);
            $('.inline_field_' + delete_id).attr('disabled', false);
            $('.inline_field_' + delete_id).removeClass('opacity5 none-pointer');
        } else {
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
            } else {
                $('.inline_field_' + delete_id).attr('readonly', true);
                $('.inline_field_' + delete_id).attr('disabled', true);
                $('.inline_field_' + delete_id).addClass('opacity5 none-pointer');
                arr.splice(arr.indexOf(delete_id), 1);
                arr.join(',')
                $('#delete_ids').val(arr);
            }
            if (arr == '') {
                var new_f = $(".new_field").length;
                if (new_f > 0) {
                    $('.paygrade_submit').removeClass("opacity5 none-pointer");
                } else {
                    $('.paygrade_submit').addClass("opacity5 none-pointer");
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
            url: "<?php echo base_url(); ?>index.php/master/deleteSettings",
            data: {
                id: id,
                table: 'hr_salary_grade',
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
        if ($('input[name="paygrade_check_all"]:checked').length > 0) {
            $('.pay_check').prop('checked', true);
            // var favorite = [];
            $.each($(".pay_check:checked"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        } else {
            $('.pay_check').prop('checked', false);
            $.each($(".pay_check"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        }
    }

    function submit_fields() {
        $('#paygrade_form').submit();
    }

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

    $(document).on('click', '#addMore', function () {
        var dyn = $('#paygrade_table tr').length + 1;
        var empty_dT = $(".dataTables_empty").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="paygrade_tr_' + i + '" class="paygrade_more"><input type="hidden" name="grade_edit_id[]" id="grade_edit_id_' + i + '" value="0"><td class="valign-center"><input class="form-control pay_check new_field" type="checkbox" name="paygrade_check" id="paygrade_check_' + i + '" onchange="deleteids(this.value);" value="' + i + '"></td>';
        datas += '<td><input type="text" class="form-control commonAlphaNum inline_field_' + i + '" name="grade_name[]" id="grade_name_' + i + '" value="" placeholder="Enter name" /></td>';
        datas += '<td><select class="form-control inline_field_' + i + '" name="grade_status[]" id="grade_status_' + i + '" > <option value="">--Select--</option><option value="1">Active</option><option value="2" >Inactive</option></select></td><td></td></tr>';
        // $(datas).insertBefore($('#paygrade_tr_1'));
        $("#paygrade_table tbody").prepend(datas);
        $('.paygrade_submit').removeClass("opacity5 none-pointer");
        setDatepicker();
        if (empty_dT = 1) {
            $(".dataTables_empty").parent('tr').remove();
        }
    });

</script>

</body>
</html>