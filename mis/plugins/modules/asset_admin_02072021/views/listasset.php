<?php $this->load->view('vitals_header.php', array('main_menu' => 'approve', 'page_title' => 'Available Assets List', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'assetlist', 'an_approval_count' => $an_approval_count)); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Available Assets List</h4>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <?php /*
                      <div class="display-hide" id="navLoad">
                      <div class="newCLickTabs">
                      <div>
                      <ul class="nav nav-tabs" role="tablist" style="margin-left:5px;">
                      <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/asset_admin/listasset'; ?>">Available Assets List</a></li>
                      <li role="presentation"><a href="<?php echo base_url() . 'index.php/asset_admin/requestlist/using'; ?>">Assets in Use</a></li>
                      <li role="presentation"><a href="<?php echo base_url() . 'index.php/asset_admin/notavail'; ?>">Assets Not Available</a></li>
                      <li role="presentation"><a href="<?php echo base_url() . 'index.php/asset_admin/transaction_history'; ?>">Transaction History</a></li>
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
                                    <form id="filter_job" action="<?php echo base_url() . 'index.php/asset_admin/DTlistasset_export' ?>" class="pad-lt15px " method="POST" autocomplete="off">
                                        <div class="col-xl-12 col-lg-8 col-md-7 col-12" style="margin-left:-25px; ">
                                            <ul class="vitals-links leaveLabel">
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Asset Type</label>
                                                    <select class="form-control wdt_180"  name="vendor" id="vendor">
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($assetTypeIT as $rows) { ?>
                                                            <option value="<?= $rows['master_id']; ?>" <?php echo ($asset_type == $rows['master_id']) ? ('selected') : (''); ?>><?= $rows['master_name']; ?></option>
                                                        <?php } ?>
                                                        <?php foreach ($assetTypeGeneral as $rows) { ?>
                                                            <option value="<?= $rows['master_id']; ?>" <?php echo ($asset_type == $rows['master_id']) ? ('selected') : (''); ?>><?= $rows['master_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Asset Number</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="asset_number"  name="asset_number" class="form-control" placeholder="Search">
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Asset Name</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="asset_name"  name="asset_name" class="form-control" placeholder="Search">
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Asset Code</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="asset_code"  name="asset_code" class="form-control" placeholder="Search">
                                                    </div>
                                                </li>

                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Employee</label>
                                                    <select class="form-control wdt_180"  name="employee_id" id="employee_id">
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($userList as $list) { ?>
                                                            <option value="<?php echo $list['id']; ?>"><?php echo $list['user_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Purchase From Date</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="date_from"  name="date_from" class="form-control" placeholder="dd-mm-yyyy">
                                                    </div>
                                                </li>

                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Purchase To Date</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="date_to"  name="date_to" class="form-control" placeholder="dd-mm-yyyy">
                                                    </div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Available Status</label>
                                                    <select class="form-control wdt_180"  name="available_status" id="available_status">
                                                        <option value="">--Select--</option>
                                                        <option value="1" <?php echo ($status == '1') ? ('selected') : (''); ?>>Available</option>
                                                        <option value="0" <?php echo ($status == '0') ? ('selected') : (''); ?>>In Use</option>
                                                    </select>
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
                                                        <th width="10%">Asset Type</th>
                                                        <th width="10%">Asset Number</th>
                                                        <th width="5%">Asset Name</th>
                                                        <th width="5%">Asset Code</th>
                                                        <th width="5%">Serial Number</th>
                                                        <th width="5%">Purchased Date</th>
                                                        <th width="5%">Warranty Expiry Date</th>
                                                        <th width="5%">Vendor</th>
                                                        <th width="5%">AMC</th>
                                                        <th width="5%">Available Status</th>
                                                        <th width="5%">Payment</th>
                                                        <th width="5%">Transfer</th>
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

<div class="modal" id="transfermodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Asset Transfer</h4>
                        </div>
                        <form id="transfer_form" name="transfer_form" action="<?php echo base_url() . 'index.php/asset_admin/transfer'; ?>" class="pad-lt15px " method="POST" autocomplete="off">
                            <input type="hidden" id="vendor_asset_id" name="vendor_asset_id" >
                            <input type="hidden" id="ceiling_amount" name="ceiling_amount" >
                            <table width="100%" cellspacing="5" cellpadding="5">
                                <tbody>
                                    <tr>
                                        <td colspan="2" align="center"><strong></strong> </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><strong>Asset Number :</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input readonly type="text" id="asset_num"  name="asset_num" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><strong>Asset Code :</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input readonly type="text" id="asset_co" name="asset_co" class="form-control" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><strong>Employee :</strong></td>
                                        <td style="text-align: left;word-break: break-word;">
                                            <select class="form-control wdt_150"  name="emp_id" id="emp_id">
                                                <option value="">--Select--</option>
                                                <?php foreach ($userList as $list) { ?>
                                                    <option value="<?php echo $list['id']; ?>"><?php echo $list['user_name']; ?></option>
                                                <?php } ?>
                                                <option value="others">Others</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr  id="other_employee" style="display:none;" >
                                        <td style="width: 150px;"><strong>Others</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input type="text" id="other_employee_id" name="other_employee_id" class="form-control" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><strong>Issue Date :</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input type="text" id="issue_date"  name="issue_date" class="form-control" placeholder="dd-mm-yyyy">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <input type="hidden" id="request_id" name="request_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose cancel_at" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="transfer" >Transfer</button>
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
                            <h4>Vendor Details</h4>
                        </div>
                        <table width="100%" cellspacing="5" cellpadding="5">
                            <tbody>
                                <tr>
                                    <td colspan="2" align="center"><strong></strong> </td>
                                </tr>
                                <tr>
                                    <td style="width: 150px;"><strong>Vendor Name :</strong></td>
                                    <td style="text-align: left;word-break: break-word;" id="vendor_name"></td>
                                </tr>
                                <tr>
                                    <td style="width: 150px;"><strong>Contact Person :</strong></td>
                                    <td style="text-align: left;word-break: break-word;" id="contact_person"></td>
                                </tr>
                                <tr>
                                    <td style="width: 150px;"><strong>Email Address :</strong></td>
                                    <td style="text-align: left;word-break: break-word;" id="email_address"></td>
                                </tr>
                                <tr>
                                    <td style="width: 150px;"><strong>Contact Number :</strong></td>
                                    <td style="text-align: left;word-break: break-word;" id="contact_number"></td>
                                </tr>
                                <tr>
                                    <td style="width: 150px;"><strong>Address :</strong></td>
                                    <td style="text-align: left;word-break: break-word;"  id="vendor_address"></td>
                                </tr>
                                <tr>
                                    <td style="width: 150px;" ><strong>Website :</strong></td>
                                    <td style="text-align: left;word-break: break-word;" id="website"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <input type="hidden" id="request_id" name="request_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="cancel_request">Ok</button>
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

        $('#transfer_form').validate({
            rules: {
                emp_id: {
                    required: true
                },
                issue_date: {
                    required: true
                },
            },
            messages: {
                emp_id: "Select Employee",
                issue_date: "Select Date",
            }
        });

        $('#issue_date').datepicker({
            dateFormat: "dd-mm-yy"
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

        $(document).on('change', '#emp_id', function () {
            $("#other_employee").css('display', 'none');
            $("#other_employee").css('display', 'none');
            $("#other_employee_id").val('');
            if ($(this).val() == 'others') {
                $("#other_employee").css('display', 'contents');
            }
        });

        $(document).on('click', '.cancel_at', function () {
            $("#emp_id").val('');
            $("#issue_date").val('');
        });

        $(document).on('click', '#transfer', function () {
            if ($("#transfer_form").valid() == true) {
                $("#transfer_form").submit();
            }
            return false;
        });
    });

    $(document).ready(function () {
        $(document).on('click', '.transfer_cls', function () {
            var asset_number = $(this).attr('data-attr-an');
            var asset_code = $(this).attr('data-attr-ac');
            var asset_id = $(this).attr('data-attr-aid');
            var ceiling_amount = $(this).attr('data-attr-amount');

            $("#ceiling_amount").val(ceiling_amount);

            $("#vendor_asset_id").val(asset_id);
            $("#asset_num").val(asset_number);
            $("#asset_co").val(asset_code);
            $('#transfermodal').modal('show');
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

        $('#vendor').val('');
        $('#asset_number').val('');
        $('#asset_name').val('');
        $('#asset_code').val('');
        $('#employee_id').val('');
        $('#date_from').val('');
        $('#date_to').val('');
        $('#available_status').val('');
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
        var vendor = $('#vendor').val();
        var asset_number = $('#asset_number').val();
        var asset_name = $('#asset_name').val();
        var asset_code = $('#asset_code').val();
        var employee_id = $('#employee_id').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        var available_status = $('#available_status').val();

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
                "url": "<?php echo base_url(); ?>index.php/asset_admin/DTlistasset",
                "type": "POST",
                "data": {
                    "vendor": vendor,
                    "asset_number": asset_number,
                    "asset_name": asset_name,
                    "asset_code": asset_code,
                    "employee_id": employee_id,
                    "date_from": date_from,
                    "date_to": date_to,
                    "available_status": available_status
                }
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [10, 11],
                }],
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                /*  $('#master_table tbody').on( 'click', 'tr td:eq(7)', function (){
                 console.log("col1");
                 console.log($(this).attr('data-attr'));
                 return false;
                 });
                 return false; */

                /* $('#master_table tbody').on('click', 'tr', function (e) {
                 if (!$(e.target).is("input")){
                 var slug =  $(this).closest('tr').find('td:eq(7) input').val();
                 console.log(slug);
                 }
                 });
                 $('#master_table').on('click', '.action_cls', function (e) {
                 var slug =  $(this).closest('tr').find('td:eq(7) input').val();
                 console.log(slug);
                 if (!$(e.target).is("input")) {
                 var type =  $(this).attr('data-attr');

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

    $(document).on('click', '#cancel_request', function () {
        $('#actionmodal').modal('hide');
    });

    $('#master_table tbody').on('click', '.get_vendor', function () {
        var asset_id = $(this).attr('data-attr-id');
        var vendor_id = $(this).attr('data-attr-vid');

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/asset_admin/ajax_get_vendor",
            type: "POST",
            data: {"asset_id": asset_id, "vendor_id": vendor_id},
            dataType: "json",
            cache: false,
            success: function (res) {
                $("#vendor_name").append(res.name);
                $("#contact_person").append(res.person);
                $("#email_address").append(res.email);
                $("#contact_number").append(res.contact);
                $("#vendor_address").append(res.address);
                $("#website").append(res.website);
                $('#actionmodal').modal('show');
            }
        });
    });

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

</script>

</body>
</html>