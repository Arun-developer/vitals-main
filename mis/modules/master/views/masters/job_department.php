<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Job Department', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'job')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4>Job Department</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div>
                        <?php $type = $this->uri->segment(2); ?>
                        <div class="tab-slider--navform">
                            <ul class="tab-slider--tabsform" >
                                <li class="tab-slider--triggerform <?php if ($type == 'lists') echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/job/lists'; ?>" >Job</a></li>
                                <li class="tab-slider--triggerform  <?php if ($type == 'location') echo"active"; ?>"><a href= "<?php echo base_url() . 'index.php/job/location'; ?>">Job Location</a></li>
                                <li class="tab-slider--triggerform  <?php if ($type == 'job_type') echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/master/job_type'; ?>">Job Type</a></li>
                                <li class="tab-slider--triggerform  <?php if ($type == 'job_department') echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/master/job_department'; ?>">Job Department</a></li>
                                <li class="tab-slider--triggerform  <?php if ($type == 'job_specification') echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/master/job_specification'; ?>">Job Specification</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new pad-none">
                                    <div style="height: 15px;"></div>
                                    <form id="filter_job" action="" class="pad-lt15px" method="POST" autocomplete="off">
                                        <div class="row">
                                            <div class="col-xl-7 col-lg-7 col-md-7 col-12 ">
                                                <ul class="vitals-links spec-label">
                                                    <li class="mob_fulfill">
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <select class="form-control wdt_180" id="search_type" name="search_type">
                                                                <option value="">--Search by--</option>
                                                                <option value="1" <?php
                                                                if ($search_type == "1") {
                                                                    echo "selected";
                                                                }
                                                                ?>>Department</option>
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
                                            </div>
                                            <div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
                                                <ul class="vitals-links ">
                                                    <?php if (count($job_department) == 0) { ?>
                                                        <li>
                                                            <a href="<?php echo base_url() . 'index.php/master/copy_job_department'; ?>" class="master_aduser" title="Copy master data from Villgro India"><i class="fas fa-clone"></i> Copy Master</a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                    <div style="height: 10px;"></div>
                                    <form id="jobdept_form" action="<?php echo base_url() . 'index.php/master/addJobDept' ?>" method="POST" autocomplete="off">
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <h4>Job Department</h4>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                        <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15  opacity5 none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </li>
                                                            <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue jobdept_submit <?php if (count($job_department) > 0) { ?> opacity5 none-pointer <?php } ?>" onclick="submit_fields();">Save</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table table-hover dt-responsive" id="jobdept_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"><input class='form-control jobdept_check_all' type='checkbox' name='jobdept_check_all' id='jobdept_check_all' onchange="selectall_chk();"></th>
                                                        <th width="30%">Job Department</th>
                                                        <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                                            <th>Partner</th>
                                                        <?php } ?>
                                                        <th width="25%">Status</th>
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
        jobdept_trigger();
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
            jobdept_trigger();
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
                jobdept_trigger();
                return false;
            }
        }
    });

    function jobdept_trigger() {
        var filter_search = $('#filter_search').val();
        var search_type = $('#search_type').val();
        $('#jobdept_table').DataTable({
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
                "url": "<?php echo base_url(); ?>index.php/master/DTJobDept",
                "type": "POST",
                "data": {
                    "search_field": filter_search,
                    "search_type": search_type
                }
            },
            drawCallback: function (settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);

                var table = $('#jobdept_table').dataTable();
                var data_len = table.fnGetData().length;
                if (data_len == 0) {
                    $('.jobdept_check_all').hide();
                    $('tr td:first-child').addClass('none-pointer');
                }
                $('.jobdept_check_all').prop('checked', false);
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
        jobdept_trigger();
    });

    $(document).on('click', '#delUser', function () {
        $('#delCount').val('');
        var sel_item = $(".dept_check:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0)
            $('#deletemodal').modal('show');
    });

    function deleteids(checkid) {
        var store = $('#delete_ids').val();
        var arr = store.split(',');
        var paylen = $('.dept_check').length;
        var payinput = $('.dept_check:checked').length;
        var delete_id = $('#dept_edit_id_' + checkid).val();

        if (paylen != payinput) {
            $('.jobdept_check_all').prop('checked', false);
        } else {
            $('.jobdept_check_all').prop('checked', true);
        }
        if ($('#jobdept_check_' + checkid).prop('checked') == true) {
            $("#delUser").removeClass("opacity5 none-pointer");
            $('.jobdept_submit').removeClass("opacity5 none-pointer");
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
                    $('.jobdept_submit').removeClass("opacity5 none-pointer");
                } else {
                    $('.jobdept_submit').addClass("opacity5 none-pointer");
                }
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
                table: 'hr_job_department',
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
        if ($('input[name="jobdept_check_all"]:checked').length > 0) {
            $('.dept_check').prop('checked', true);
            $.each($(".dept_check:checked"), function () {
                deleteids($(this).val());
            });
        } else {
            $('.dept_check').prop('checked', false);
            $.each($(".dept_check"), function () {
                deleteids($(this).val());
            });
        }
    }

    function submit_fields() {
        $('#jobdept_form').submit();
    }

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

    $(document).on('click', '#addMore', function () {

<?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
            var parent_name_hid = $(".parent_name_hid").val();
<?php } ?>

        var dyn = $('#jobdept_table tr').length + 1;
        var empty_dT = $(".dataTables_empty").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="jobdept_tr_' + i + '" class="jobdept_more"><input type="hidden" name="dept_edit_id[]" id="dept_edit_id_' + i + '" value="0"><td class="valign-center"><input class="form-control dept_check new_field" type="checkbox" name="jobdept_check" id="jobdept_check_' + i + '" onchange="deleteids(this.value);" value="' + i + '"></td>';
        datas += '<td><input type="text" class="form-control commonAlphaNum inline_field_' + i + '" name="job_department[]" id="job_department_' + i + '" value="" placeholder="Enter name" /></td>';

<?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
            datas += '<td>' + parent_name_hid + '</td>';
<?php } ?>

        datas += '<td><select class="form-control inline_field_' + i + '" name="job_status[]" id="job_status_' + i + '" ><option value="1">Active</option><option value="2" >Inactive</option></select></td><td></td></tr>';
        $("#jobdept_table tbody").prepend(datas);
        $('.jobdept_submit').removeClass("opacity5 none-pointer");
        if (empty_dT = 1) {
            $(".dataTables_empty").parent('tr').remove();
        }
    });

</script>

</body>
</html>