<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Reject Reasons', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'reason')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Reject Reasons</h4>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <div class="" id="navLoad">
                        <div class="newCLickTabs">
                            <div class="scrtabs-allow-scrollbar" style="margin-left:5px;">
                                <div class="scrtabs-tab-container" style="visibility: visible;">
                                    <div class="scrtabs-tab-scroll-arrow scrtabs-tab-scroll-arrow-left" style=""><span class="fas fa-chevron-left"></span></div>
                                    <div class="scrtabs-tabs-fixed-container" style="width: 1386.25px;"><div class="scrtabs-tabs-movable-container" style="width: 1386.25px;">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active"><a>Reject Reasons</a></li>
                                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/incubation_master/preliminary_reason' ?>">PA/RD Reasons</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="scrtabs-tab-scroll-arrow scrtabs-tab-scroll-arrow-right" style=""><span class="fas fa-chevron-right"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new pad-none">
                                    <form id="filter_job" action="" method="POST" autocomplete="off">
                                        <div class="col-12">
                                            <ul class="vitals-links spec-label">
                                                <?php if ($admin_type == 0) { ?>
                                                    <li class="mob_fulfill">
                                                        <label class="form-group" >Partner</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <select class="form-control wdt_180"  name="branch" id="branch">
                                                                <option value="">--Select--</option>
                                                                <?php foreach ($barnch_details as $list) { ?>
                                                                    <option value="<?php echo $list->id; ?>"><?php echo $list->branch_name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div id="branch_err" ></div>
                                                    </li>
                                                <?php } ?>
                                                <li class="mob_fulfill">
                                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                                        <a class="form-control-feedback" id="search_btn"><span class="fa fa-search"></span></a>
                                                        <input type="text" id="filter_search"  name="filter_search" class="form-control" placeholder="Search">
                                                    </div>
                                                    <div id="filter_search_err" ></div>
                                                </li>
                                                <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                            </ul>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
                                            <ul class="vitals-links"></ul>
                                        </div>

                                    </form>
                                    <div style="height: 10px;"></div>

                                    <div class="table_configcontentnew pad-bt0">
                                        <div class="tabpanel-title">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                    <ul class="milestone-links">
                                                        <li class="brd-left-onboard">
                                                            <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                        </li>
                                                        <li class="brd-left-onboard">
                                                            <a href="javascript:void(0)" class="edit-btnconfig mar-tp15  opacity5 none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                        </li>
                                                        <li class="brd-left-onboard"><a href="javascript:void(0)" id="save_btn" class="saveContinue master_submit opacity5 none-pointer" onclick="submit_fields();">Save</a></li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form method="post" id="insertEditReason" action="<?php echo base_url() . 'index.php/incubation_master/insertEditReason'; ?>" class="form" novalidate autocomplete="off">
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table table-hover dt-responsive dataTable" id="master_table">
                                                <thead>
                                                    <tr>
                                                            <!--<th width="18px" class="removeArrow" style="position: initial;"><input class='form-control master_check_all' type='checkbox' name='master_check_all' id='master_check_all'></th>-->
                                                        <th width="18px" style="text-align: center" class="removeArrow"><input class='master_check_all' type='checkbox' name='master_check_all' id='master_check_all'></th>
                                                        <th width="35%">Reject Reason</th>
                                                        <th width="20%">Partner</th>
                                                        <th width="20%">Status</th>
                                                        <th width="17%" class="removeArrow"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                    <input type="hidden" name="delete_ids" id="delete_ids" />
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
    .plan-structure-vital .plan-structure-new {
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }
    .plan-structure-vital{
        overflow-y:hidden
    }
    .dataTables_scrollBody{
        margin-top: -15px;
    }
    div.dataTables_scrollHead table{
        margin-bottom: 10px !important;
    }
    .page-wrapper .page-content{
        padding-bottom: 0;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">

    $(document).ready(function () {

        $(document).on('click', '#search_btn', function () {
            filter_check();
        });

        $('#filter_search').keypress(function (e) {
            if (e.which == 13) {
                filter_check();
                return false;
            }
        });

        function filter_check() {
            var filter_err = 0;
            $("#branch_err").html('');
            $("#filter_search_err").html('');
            if (adminType != 1) {
                var branch = $('#branch').val();
                if (branch == '') {
                    filter_err = 1;
                    $("#branch_err").html('<label class="error" id="txt_error">Select type</label>');
                }
            }
            var filter_search = $('#filter_search').val();
            if (filter_search == '') {
                filter_err = 1;
                $("#filter_search_err").html('<label class="error" id="txt_error">Enter value</label>');
            }
            if (filter_err > 0) {
                return false;
            } else {
                master_trigger();
            }
        }

        $('#filter_form').validate({
            rules: {
                sector_type: "required"
            },
            messages: {
                sector_type: "Select Sector Type"
            }
        });

        master_trigger();
    });

    $(document).on('click', '#reset_search', function () {
        $("#branch_err").html('');
        $("#filter_search_err").html('');
        $('#filter_search').val('');
        $('#branch').val('');
        master_trigger();
    });

    function master_trigger() {
        var filter_search = $('#filter_search').val();
        var branch = $('#branch').val();
        var master_type = $('#master_type').val();
        $('#master_table').DataTable({
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
            "scrollY": '333px',
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/incubation_master/DTreason",
                "type": "POST",
                "data": {
                    "search_field": filter_search,
                    "master_type": master_type,
                    "branch": branch,
                }
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
                $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                if (data_len > 0) {
                    $('.master_check_all').show();
                } else {
                    $('.master_check_all').hide();
                }
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [0, 1, 2, 3, 4],
                }],
            //"order": [1, 'desc']
        });
    }

    $(document).on('click', '#deleteRecord', function () {
        var common_ids = [];
        $(".master_check").each(function (index) {
            if ($(this).is(":checked")) {
                if (this.value != '' && this.value != undefined && this.value != 'on') {
                    common_ids[index] = this.value;
                }
            }
        });

        var id = $('#delete_ids').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/incubation_master/commonDelete",
            data: {
                id: common_ids,
                table: 'master_settings',
            },
            dataType: 'json',
            success: function (msg) {
                $('#deletemodal').modal('hide');
                $('.deletetoast').toast('show');
                $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                //$('.deleteMsg').removeClass('display-hide');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        });
    });

    $(document).on('click', '.master_check', function () {
        if (!$(this).is(":checked")) {
            $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
            $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", true);
        } else {
            $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
            $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
        }
        if ($('input:checkbox.master_check').length > 0) {
            if ($('input:checkbox.master_check').length != $('input:checkbox.master_check:checked').length) {
                $('.master_check_all').prop('checked', false);
                $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
            } else if ($('input:checkbox.master_check').length == $('input:checkbox.master_check:checked').length) {
                $('.master_check_all').prop('checked', true);
            }
        }
        if ($('input:checkbox.master_check:checked').length == 0) {
            $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
        }
    });

    $(document).on('click', '.master_check_all', function () {
        if (!$(this).is(":checked")) {
            $('.master_check').prop('checked', false);
            $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
            $(".master_check").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", true);
        } else {
            $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
            $('.master_check').prop('checked', true);
            $(".master_check").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
        }
        $(".new_field").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", false);

        if ($(".new_field").length > 0) {
            $("#save_btn").removeClass("opacity5 none-pointer");
        }
    });

    $(document).on('click', '.new_field', function () {
        $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
        $("#save_btn").removeClass("opacity5 none-pointer");
    });

    var adminType = '<?php echo $admin_type; ?>';
    $(document).on('click', '#addMore', function () {
        $(".dataTables_empty").css('display', 'none');
        var i = master_table_count = $('#master_table tr').length + 1;
        var datas = '<tr id="master_tr_' + i + '" class="master_more"><input type="hidden" name="reason_edit_id[' + i + ']" disabled><td class="valign-center"><input class="form-control master_check new_field" type="checkbox" name="master_check" ></td>';
        datas += '<td><input class="form-control commonAlphaNum" type="text"  name="reason[' + i + ']" ></td>';
        if (adminType == 1) {
            datas += '<td><?php echo $branch_name; ?></td>';
        } else {
            datas += '<td><select class="form-control" name="branch[' + i + ']" ><?php echo $options; ?></select></td>';
        }
        datas += '<td><select class="form-control"  name="status[' + i + ']" ><option value="">--Select--</option><option value="1" >Approved</option><option value="0">Disapproved </option></td><td></td></tr>';
        $("#master_table tbody").prepend(datas);
        $("#save_btn").removeClass("opacity5 none-pointer");
    });

    $(document).on('click', '#delUser', function () {
        $('#delCount').val('');
        var sel_item = $(".master_check:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0)
            $('#deletemodal').modal('show');
    });

    function submit_fields() {
        $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
        $('#insertEditReason').submit();
    }

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

</script>

</body>
</html>