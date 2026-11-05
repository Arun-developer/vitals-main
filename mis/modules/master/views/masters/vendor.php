<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Vendor', 'page_table' => 'datatable')); ?>
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
                        <h4>Vendor Master</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                     <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"> <a href="<?php echo base_url() . 'index.php/master/vendor_master'; ?>">Vendor Master</a></li>
                                    
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
                                    <form id="filter_job" action="<?php echo base_url() . 'index.php/master/vendor_export'; ?>" class="pad-lt15px" method="POST" autocomplete="off">
                                        <div class="row spec-label">
                                            <div class=" col-12 ">
                                                <ul class="vitals-links">
                                                    <li>
                                                        <div class="form-group has-search-right mar-bt8 wdt_180">
                                                            <label>Vendor Name</label>
                                                            <input type="text" id="vendor_name" value="" name="vendor_name" class="form-control" placeholder="Vendor Name">
                                                        </div>
                                                        <label class="error hidden" id="txt_error">Enter value</label>
                                                    </li>
                                                    <li>
                                                        <div class="form-group has-search-right mar-bt8 wdt_180">
                                                            <label>Contact Person</label>
                                                            <input type="text" id="contact_person" value="" name="contact_person" class="form-control" placeholder="Contact Person">
                                                        </div>
                                                        <label class="error hidden" id="txt_error">Enter value</label>
                                                    </li>
                                                    <li><a href="javascript:" class="vital_yellow_btn pad-hr15 wdt_100" id="search_btn">Search</a></li>
                                                    <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-12 col-md-12 text-right">
                                            <ul class="vitals-links">
                                                <li><a class="master_aduser" id="export"><span><i class="fas fa-download"></i></span> Export</a></li>
                                                <li>
                                                    <a href="<?php echo base_url() . 'index.php/master/vendor_master/add'; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add Vendor</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="master_deluser none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover " id="master_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"><input class='form-control master_check_all' type='checkbox' name='master_check_all' id='master_check_all' onchange="selectall_chk();"></th>
                                                        <th width="15%">Vendor Name</th>
                                                        <th width="15%">Email</th>
                                                        <th width="10%">Contact Person</th>
                                                        <th width="20%">Company Address</th>
                                                        <th width="10%">Contact Number</th>
                                                        <th width="5%">More Contacts</th>
                                                        <th width="15%">Website</th>
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

<div class="modal" id="contactmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <table class="table table-hover dt-responsive" id="contactmore_table">
                            <thead>
                                <tr>
                                    <th width="30%">Contact Person</th>
                                    <th width="30%">Contact Number</th>
                                    <th width="30%">Email Address</th>
                                </tr>
                            </thead>
                            <tbody id="more_contacts_modal">
                            </tbody>
                        </table>
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
    .plan-structure-vital .plan-structure-new{
        overflow-y: auto !important;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $("#export").click(function () {
        $("#filter_job").submit();
    });

    $(document).ready(function () {
        master_trigger();
    });

    function master_trigger() {
        var vendor_name = $('#vendor_name').val();
        var contact_person = $('#contact_person').val();
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
                "url": "<?php echo base_url(); ?>index.php/master/DTVendor",
                "type": "POST",
                "data": {
                    "contact_person": contact_person,
                    "vendor_name": vendor_name,
                }
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#master_table tbody').on('click', 'tr', function (e) {
                    if (!$(e.target).is("input")) {
                        var edited_id = $(":checkbox:eq(0)", this).val();
                        var slug = $('#master_edit_id_' + edited_id).val();
                        $(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/master/vendor_master/edit/' + slug);
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
        $('#contact_person').val('');
        $('#vendor_name').val('');
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
                field: 'vendor_id',
                delval: '0',
                table: 'master_vendor',
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

    function showContacts(vendor) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/showmorecontacts",
            data: {
                id: vendor,
            },
            dataType: 'html',
            success: function (msg) {
                $('#contactmodal').modal('show');
                // $('.deletetoast').toast('show');
                $('#more_contacts_modal').html(msg);
            }
        });
    }

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