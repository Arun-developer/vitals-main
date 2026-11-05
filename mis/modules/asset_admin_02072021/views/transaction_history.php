<?php $this->load->view('vitals_header.php', array('main_menu' => 'approve', 'page_title' => 'Assets - Transaction History', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'assetTrans', 'an_approval_count' => $an_approval_count)); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Assets - Transaction History</h4>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <?php /*
                      <div class="display-hide" id="navLoad">
                      <div class="newCLickTabs">
                      <div>
                      <ul class="nav nav-tabs" role="tablist" style="margin-left:5px;">
                      <li role="presentation"><a href="<?php echo base_url() . 'index.php/asset/requestlist/using'; ?>">Available Assets List</a></li>
                      <li role="presentation"><a href="<?php echo base_url() . 'index.php/asset_admin/requestlist/using'; ?>">Assets in Use</a></li>
                      <li role="presentation"><a href="<?php echo base_url() . 'index.php/asset_admin/notavail'; ?>">Assets Not Available</a></li>
                      <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/asset_admin/transaction_history'; ?>">Transaction History</a></li>
                      <li role="presentation"><a href="<?php echo base_url() . 'index.php/asset_admin/listpayment'; ?>">Asset Payments</a></li>
                      <li role="presentation"><a href="<?php echo base_url() . 'index.php/asset_admin/listpayment_employee'; ?>">Deductions for Asset Usage</a></li>
                      </ul>
                      </div>
                      </div>
                      </div>
                     */ ?>
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="filter_job" action="<?php echo base_url() . 'index.php/asset_admin/DTtransaction_export' ?>" class="pad-lt15px " method="POST" autocomplete="off">
                                        <div class="col-xl-11 col-lg-8 col-md-7 col-12" style="margin-left:-25px; ">
                                            <ul class="vitals-links leaveLabel">
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Asset Type</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <select class="form-control wdt_180"  name="asset_type" id="asset_type">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($assetTypeIT as $rows) { ?>
                                                                <option value="<?= $rows['master_id']; ?>" <?php echo ($asset_type == $rows['master_id']) ? ('selected') : (''); ?>><?= $rows['master_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Employee</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <select class="form-control wdt_180"  name="employee_id" id="employee_id">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($userList as $list) { ?>
                                                                <option value="<?php echo $list['id']; ?>"><?php echo $list['user_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Asset Number</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="asset_number"  name="asset_number" class="form-control" placeholder="Search">
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group">Bill Date</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="date_from" name="date_from" class="form-control" placeholder="dd-mm-yyyy">
                                                    </div>
                                                    <div id="date_from_err"></div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >To Date</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="date_to"  name="date_to" class="form-control" placeholder="dd-mm-yyyy">
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group">Returned Date</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="return_date_from" name="return_date_from" class="form-control" placeholder="dd-mm-yyyy">
                                                    </div>
                                                    <div id="date_from_err"></div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Returned To Date</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="return_date_to"  name="return_date_to" class="form-control" placeholder="dd-mm-yyyy">
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <div class="form-group mar-bt8">
                                                        <li><a href="javascript:" id="search_btn" class="vital_yellow_btn pad-hr15 wdt_100">Search</a></li>
                                                        <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                                        <li><a id="export_summary" class="master_aduser summaryEdit"><span><i class="fas fa-download"></i></span> Export</a></li>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
                                            <ul class="vitals-links"></ul>
                                        </div>
                                    </form>

                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive" id="master_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Asset Number</th>
                                                        <th width="10%">Asset Type</th>
                                                        <th width="10%">Asset Name</th>
                                                        <th width="5%">Employee Name</th>
                                                        <th width="5%">Issue Date</th>
                                                        <th width="5%">Return Date</th>
                                                        <th width="5%">Status</th>
                                                        <th width="5%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
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

<div class="modal" id="actionmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Are you sure want to delete?</h4>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="del_transfer_id" name="transfer_id">
            <input type="hidden" id="del_asset_id" name="asset_id">
            <input type="hidden" id="request_id" name="request_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="delete_asset">Ok</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="returnmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Asset Return</h4>
                        </div>
                        <form id="transfer_form" name="transfer_form" action="<?php echo base_url() . 'index.php/asset_admin/transfer'; ?>" class="pad-lt15px " method="POST" autocomplete="off">
                            <input type="hidden" id="vendor_asset_id" name="vendor_asset_id">
                            <table width="100%" cellspacing="5" cellpadding="5">
                                <tbody>
                                    <tr>
                                        <td style="width: 150px;"><strong>Asset Number :</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input readonly type="text" id="asset_no"  name="asset_no" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><strong>Return Date :</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input type="text" id="return_date"  name="return_date" class="form-control" placeholder="dd-mm-yyyy">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>

            <input type="hidden" id="an_transfer_id" name="transfer_id">
            <input type="hidden" id="an_asset_id" name="asset_id">
            <input type="hidden" id="request_id" name="request_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" ><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="return_assets">Ok</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on('click', '#export_summary', function () {
            $("#filter_job").submit();
        });

        $('#return_date').datepicker({
            dateFormat: "dd-mm-yy"
        });

        $(document).on('click', '.delete_cls', function () {
            $("#del_transfer_id").val('');
            $("#del_asset_id").val('');

            var transfer_id = $(this).attr('data-attr-tid');
            var asset_id = $(this).attr('data-attr-aid');
            var currentTab = '<?php echo $this->uri->segment(3); ?>';

            $("#del_transfer_id").val(transfer_id);
            $("#del_asset_id").val(asset_id);
            $('#actionmodal').modal('show');
        });

        $(document).on('click', '.return_cls', function () {
            $("#an_transfer_id").val('');
            $("#an_asset_id").val('');
            var transfer_id = $(this).attr('data-attr-tid');
            var asset_id = $(this).attr('data-attr-aid');
            var currentTab = '<?php echo $this->uri->segment(3); ?>';
            $("#an_transfer_id").val(transfer_id);
            $("#an_asset_id").val(asset_id);
            var asset_numb = $(this).attr('data-attr-an');
            $("#asset_no").val(asset_numb);
            $('#returnmodal').modal('show');
        });

        $(document).on('click', '#return_assets', function () {
            var transfer_id = $("#an_transfer_id").val();
            var asset_id = $("#an_asset_id").val();
            var asset_no = $("#asset_no").val();
            var return_date = $("#return_date").val();
            var currentTab = '<?php echo $this->uri->segment(3); ?>';
            var ajax_url = "<?php echo base_url(); ?>index.php/asset_admin/return_asset";
            if (transfer_id != '' && asset_id != '') {
                $('#actionmodal').modal('hide');
                $.ajax({
                    url: ajax_url,
                    type: "POST",
                    data: {"asset_no": asset_no, "return_date": return_date, "asset_id": asset_id, "transfer_id": transfer_id, "currentTab": currentTab},
                    dataType: "json",
                    cache: false,
                    success: function (res) {
                        location.reload();
                    }
                });
            }
        });

        $('#date_from').datepicker({
            dateFormat: "dd-mm-yy",
            onSelect: function (startDate) {
                $('#date_to').datepicker('option', 'minDate', startDate);
            }
        });

        $('#date_to').datepicker({
            dateFormat: "dd-mm-yy",
            onSelect: function (startDate) {
                $('#date_from').datepicker('option', 'maxDate', startDate);
            }
        });

        $('#return_date_from').datepicker({
            dateFormat: "dd-mm-yy",
            onSelect: function (startDate) {
                $('#return_date_to').datepicker('option', 'minDate', startDate);
            }
        });

        $('#return_date_to').datepicker({
            dateFormat: "dd-mm-yy",
            onSelect: function (startDate) {
                $('#return_date_from').datepicker('option', 'maxDate', startDate);
            }
        });
    });

    $(document).ready(function () {
        $(document).on('click', '#delete_asset', function () {
            var transfer_id = $("#del_transfer_id").val();
            var asset_id = $("#del_asset_id").val();
            var currentTab = '<?php echo $this->uri->segment(3); ?>';
            var ajax_url = "<?php echo base_url(); ?>index.php/asset_admin/delete_tranfer";
            if (transfer_id != '' && asset_id != '') {
                $('#actionmodal').modal('hide');
                $.ajax({
                    url: ajax_url,
                    type: "POST",
                    data: {"asset_id": asset_id, "transfer_id": transfer_id, "currentTab": currentTab},
                    dataType: "json",
                    cache: false,
                    success: function (res) {
                        location.reload();
                    }
                });
            }
            return false;
        });

        $('#author').keypress(function (e) {
            if (e.which == 13) {
                filter_check();
                return false;
            }
        });

        master_trigger();
    });

    $(document).on('click', '#search_btn', function () {
        filter_check();
    });

    $(document).on('click', '#reset_search', function () {
        $("#category_err").html('');
        $("#book_name_err").html('');
        $("#author_err").html('');

        $('#asset_type').val('');
        $('#employee_id').val('');
        $('#asset_number').val('');
        $('#date_from').val('');
        $('#date_to').val('');

        master_trigger();
    });

    function filter_check() {
        var filter_err = 0;
        $("#category_err").html('');
        $("#book_name_err").html('');
        $("#author_err").html('');

        var master_id = $('#master_id').val();
        var book_name = $('#book_name').val();
        var author = $('#author').val();

        if (master_id == '') {
            filter_err = 1;
            $("#category_err").html('<label class="error" id="txt_error">Select category</label>');
        }
        if (filter_err > 0) {
            return false;
        } else {
            master_trigger();
        }
    }

    function master_trigger() {
        var asset_type = $('#asset_type').val();
        var employee_id = $('#employee_id').val();
        var asset_number = $('#asset_number').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        var action = '<?php echo $this->uri->segment(3); ?>';

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
            "pageLength": 20,
            "scrollY": '333px',
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/asset_admin/DTtransaction",
                "type": "POST",
                "data": {
                    "asset_type": asset_type,
                    "employee_id": employee_id,
                    "asset_number": asset_number,
                    "date_from": date_from,
                    "date_to": date_to
                }
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [3, 5, 6],
                }],
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                /* $('#master_table').on('click', '.action_cls', function (e) {
                 if (!$(e.target).is("input")) {
                 var id =  $(this).attr('data-attr');
                 if(id != ''){
                 $('#actionmodal').modal('show');
                 $('#request_id').val(id);
                 }
                 return false;
                 }
                 return false;
                 }); */
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
            },
        });
    }

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

</script>

</body>
</html>