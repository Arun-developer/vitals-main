<?php
$master_menu = $this->uri->segment(3);
$this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Mail Template Master', 'page_table' => 'datatable'));
?>

<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'mail_template')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Mail Template Master</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div style="height: 10px;"></div>
                                <form id="filter_job" action="" class="pad-lt15px " method="POST" autocomplete="off">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12" style="margin-left:-25px; ">
                                        <ul class="vitals-links spec-label">
                                            <li class="mob_fulfill">
                                                <label class="form-group" >Module</label>
                                                <div class="form-group mar-bt8  wdt_180">
                                                    <select class="form-control wdt_180"  name="module" id="module">
                                                        <option value="mis" >RAMP incubation</option>
                                                        <option value="ais" >Admin</option>
                                                        <!-- <option value="hris">HR</option> -->
                                                    </select>
                                                </div>
                                                <div id="branch_err" ></div>
                                            </li>
                                            <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                                <li class="mob_fulfill" id="partner_id">
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

                                            <li class="mob_fulfill" id="template_id" >
                                                <label class="form-group" >Template Type</label>
                                                <div class="form-group mar-bt8  wdt_180">
                                                    <select class="form-control wdt_180"  name="template_type" id="template_type">
                                                        <option value="">--Select--</option>
                                                        <option value="Book">Library</option>
                                                        <option value="Travel">Travel</option>
                                                        <option value="Asset">Asset</option>
                                                        <option value="Dispatch">Dispatch</option>
                                                        <option value="Leave">Leave</option>
                                                    </select>
                                                </div>
                                                <div id="branch_err" ></div>
                                            </li>
                                            <li class="mob_fulfill">
                                                <label class="form-group" >Status</label>
                                                <div class="form-group mar-bt8  wdt_180">
                                                    <select class="form-control wdt_180"  name="status" id="status">
                                                        <option value="">--Select--</option>
                                                        <option value="1">Approved</option>
                                                        <option value="0">Disapproved </option>
                                                    </select>
                                                </div>
                                                <div id="branch_err" ></div>
                                            </li>

                                            <li class="mob_fulfill" id="message_id" >
                                                <label class="form-group" ></label>
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

                                <div class="row">
                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                        <table class="table table-hover dt-responsive" id="master_table" style="margin-top: 0">
                                            <thead>
                                                <tr>
                                                    <th width="10%">Template Type</th>
                                                    <th width="10%">Message Subject</th>
                                                    <th width="5%">Status</th>
                                                    <th width="5%"></th>
                                                    <th width="5%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <input type="hidden" name="delete_ids" id="delete_ids" />
                        </div>
                        </main>
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

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $('.scrollsideMenu').scrollTop($('.scrollsideMenu').scrollTop() + 170);
    $(document).ready(function () {

        if ($("#module").val() == 'mis') {
            $("#template_id").css('display', 'none');
        }

        $(document).on('change', '#module', function () {
            if ($("#module").val() == 'mis') {
                $("#template_id").css('display', 'none');
                $("#message_id").css('display', 'inline-block');
                $("#partner_id").css('display', 'inline-block');
                master_trigger();
            }
            if ($("#module").val() == 'ais') {
                $("#template_id").css('display', 'inline-block');
                $("#message_id").css('display', 'none');
                $("#partner_id").css('display', 'none');
                master_trigger();
            }
        });

        $(document).on('change', '#branch', function () {
            master_trigger();
        });

        $(document).on('change', '#template_type', function () {
            master_trigger();
        });

        $(document).on('change', '#status', function () {
            master_trigger();
        });

        $('#filter_search').keypress(function (e) {
            if (e.which == 13) {
                master_trigger();
                return false;
            }
        });

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

    $(document).on('click', '#search_btn', function () {
        master_trigger();
    });

    $(document).on('click', '#reset_search', function () {
        $('#filter_search').val('');
        $('#branch').val('');
        location.reload();
        master_trigger();
    });

    function master_trigger() {
        var filter_search = $('#filter_search').val();
        var branch = $('#branch').val();
        var table_name = $('#table_name').val();

        var module = $('#module').val();
        var branch = $('#branch').val();
        var filter_search = $('#filter_search').val();
        var status = $('#status').val();
        var template_type = $('#template_type').val();

        if (module == 'mis') {
            var branch = $('#branch').val();
            var filter_search = $('#filter_search').val();
            var status = $('#status').val();
            var template_type = '';
        }
        if (module == 'ais') {
            var template_type = $('#template_type').val();
            var status = $('#status').val();
            var branch = '';
            var filter_search = '';
        }

        $('#master_table').DataTable({
            "scrollX": true,
            "initComplete": function (settings, json) {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
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
            "scrollY": '333px',
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/incubation_master/DTmail_template",
                "type": "POST",
                "data": {
                    "search_field": filter_search,
                    "branch": branch,
                    "status": status,
                    "template_type": template_type,
                    "module": module
                }
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#master_table tbody').on('click', 'tr', function (e) {
                    if (!$(e.target).is("input")) {
                        //var edited_id = $(":checkbox:eq(0)", this).val();
                        var edited_id = $(this).closest('tr').find('td:eq(3) input').val();
                        var mail_template_type = $(this).closest('tr').find('td:eq(3) input').val();
                        var mail_template_type = $(this).closest('tr').find('td:eq(4) input').val();
                        $(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/incubation_master/view_mail_template/' + edited_id + '/' + mail_template_type);
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
                $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                if (data_len > 0) {
                    $('.master_check_all').show();
                } else {
                    $('.master_check_all').hide();
                }
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [3, 4],
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
                table: 'port_dashboard_master',
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
            $("#delUser").addClass("opacity5 none-pointer");
            $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", true);
            $("#delUser").removeClass("clr_red");
        } else {
            $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
            $("#delUser").removeClass("opacity5 none-pointer");
            $("#delUser").addClass("clr_red");
        }
        if ($('input:checkbox.master_check').length > 0) {
            if ($('input:checkbox.master_check').length != $('input:checkbox.master_check:checked').length) {
                $('.master_check_all').prop('checked', false);
                $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
                $("#delUser").addClass("clr_red");
            } else if ($('input:checkbox.master_check').length == $('input:checkbox.master_check:checked').length) {
                $('.master_check_all').prop('checked', true);
            }
        }
        if ($('input:checkbox.master_check:checked').length == 0) {
            $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
            $("#delUser").removeClass("clr_red");
        }
    });

    $(document).on('click', '.master_check_all', function () {
        if (!$(this).is(":checked")) {
            $('.master_check').prop('checked', false);
            $("#delUser").addClass("opacity5 none-pointer");
            $("#delUser").removeClass("clr_red");
            $(".master_check").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", true);

        } else {
            $("#delUser").removeClass("opacity5 none-pointer");
            $("#delUser").addClass("clr_red");
            $('.master_check').prop('checked', true);
            $(".master_check").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
        }
        $(".new_field").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", false);

        if ($(".new_field").length > 0) {
            $("#save_btn").removeClass("opacity5 none-pointer");
            $("#delUser").addClass("clr_red");
        }
    });

    $(document).on('click', '.new_field', function () {
        $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
        $("#save_btn").removeClass("opacity5 none-pointer");
        $("#delUser").addClass("clr_red");
    });

    var adminType = '<?php echo $admin_type; ?>';
    $(document).on('click', '#addMore', function () {
        $(".dataTables_empty").css('display', 'none');
        var i = master_table_count = $('#master_table tr').length + 1;
        var datas = '<tr id="master_tr_' + i + '" class="master_more"><input type="hidden" name="reason_edit_id[' + i + ']" disabled><td class="valign-center"><input class="form-control master_check new_field" type="checkbox" name="master_check" ></td>';
        datas += '<td><input class="form-control commonAlphaNum" type="text"  name="name[' + i + ']" ></td>';
        if (adminType == 0) {
            datas += '<td><select class="form-control" name="branch[' + i + ']" ><?php echo $options; ?></select></td>';
        }
        datas += '<td><select class="form-control"  name="status[' + i + ']" ><option value="">--Select--</option><option value="1" >Approved</option><option value="0">Disapproved </option></td>';
        datas += '<td></td>';
        datas += '<td></td></tr>';
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
        $("#delUser").removeClass("clr_red");
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