<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Add Donor Amount', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'budget_master')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/master/balance_sheet'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4>Add Donor Amount</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <?php if (isset($programme_edit) && $programme_edit != '') { ?>
                                <li <?php if (!isset($programme_edit)) { ?>class="activeTabs" <?php } ?>><a href="<?php echo base_url() . 'index.php/master/addMultipledonor'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a></li>
                                <li class="edit"><a href="javascript:void(0)" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <main class="page-content">
                        <div class="inputplan-structureall plan-structure-new tabpanel-details">
                            <form id="multipledonor_form" method="post" action="<?php echo base_url() . 'index.php/master/insertlineitemAmount'; ?>" autocomplete="off">
                                <?php
                                if (isset($programme_edit) && $programme_edit != '') {
                                    $disabled = 'disabled';
                                    $dis_hide = 'display-hide';
                                } else {
                                    $disabled = '';
                                    $dis_hide = '';
                                }
                                ?>
                                <div class="row">
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Programme <span class="text-danger">*</span></label>
                                            <select class="form-control amountInput ai" name="programme" id="programme" <?= $disabled; ?> onchange="getDonor(this.value);">
                                                <option value="">--Select--</option>
                                                <?php
                                                foreach ($programme as $p_list) {
                                                    if (isset($programme_edit) && $programme_edit != '' && $balance[0]['programme_id'] == $p_list['programme_id']) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    ?>
                                                    <option value="<?= $p_list['programme_id']; ?>" <?= $selected; ?>><?= $p_list['programme']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Total Grant Amount (<?= $this->session->userdata('currency'); ?>) </label>
                                            <input type="text" class="form-control " readonly="" name="granttotal" id="granttotal" value="<?= isset($total_available_amt) ? formatnumber($total_available_amt) : '' ?>" />
                                        </div>

                                        <div class="form-group">
                                            <label>Date <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control amountInput ai" <?= $disabled; ?> name="amt_date" id="amt_date" value="<?= isset($programme_edit) && $programme_edit != '' ? date('d-m-Y', strtotime($balance[0]['amount_date'])) : '' ?>" />
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Donor <span class="text-danger">*</span></label>
                                            <select class="form-control amountInput ai" <?= $disabled; ?> name="donor" id="donor" onchange="getGrant(this.value);">
                                                <option value="">--Select--</option>
                                                <?php
                                                if (isset($programme_edit) && $programme_edit != '') {
                                                    foreach ($donors as $dlist) {
                                                        if ($balance[0]['donor_id'] == $dlist['master_id']) {
                                                            $dselected = 'selected';
                                                        } else {
                                                            $dselected = '';
                                                        }
                                                        ?>
                                                        <option value="<?= $dlist['master_id']; ?>" <?= $dselected; ?>><?= $dlist['master_name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Projected Utilization (<?= $this->session->userdata('currency'); ?>) <span class="innerToolTIp"><i class="fas fa-info-circle"></i><span class="popover above">Total amount from confirmed Approval Notes for the grant</span></span></label>
                                            <input type="text" class="form-control " readonly="" name="grantprojected" id="grantprojected" value="<?= isset($projected_amt) ? formatnumber($projected_amt) : '' ?>" />

                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Grant <span class="text-danger">*</span></label>
                                            <select class="form-control amountInput ai" <?= $disabled; ?> name="grant" id="grant" onchange="getGrantAmount(this.value);">
                                                <option value="">--Select--</option>
                                                <?php
                                                if (isset($programme_edit) && $programme_edit != '') {
                                                    foreach ($grantlist as $glist) {
                                                        if ($balance[0]['grant_id'] == $glist['id']) {
                                                            $gselected = 'selected';
                                                        } else {
                                                            $gselected = '';
                                                        }
                                                        ?>
                                                        <option value="<?= $glist['id']; ?>" <?= $gselected; ?>><?= $glist['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Total Budget (<?= $this->session->userdata('currency'); ?>) </label>
                                            <input type="text" class="form-control " readonly="" name="totalbudget" id="totalbudget" value="<?= isset($tot_budget) ? formatnumber($tot_budget) : '' ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="table_configcontentnew pad-bt0">
                                    <div class="tabpanel-title">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                <h4></h4>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                <ul class="milestone-links">
                                                    <li>
                                                    <li class="brd-left-onboard">
                                                        <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15 addMore"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                    </li>
                                                    <li class="brd-left-onboard">
                                                        <a href="javascript:void(0)" class="edit-btnconfig mar-tp15  opacity5 none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                    </li>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                    <table class="table" id="master_table" style="margin-top: 0">
                                        <thead>
                                            <tr>
                                                <!--   <th>SNo</th>  -->
                                                <th width="10%" class="removeArrow" style="text-align: center"><input class='master_check_all' type='checkbox' name='master_check_all' id='master_check_all'></th>
                                                <th class="removeArrow" width="24%">Budget Head <span class="text-danger">*</span></th>
                                                <th class="sorting_disabled" width="22%">Line Item <span class="text-danger">*</span></th>
                                                <th class="sorting_disabled" width="22%">Sub Line-Item</th>
                                                <th class="sorting_disabled" width="22%">Amount (<?= $this->session->userdata('currency'); ?>) <span class="text-danger">*</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <input type="hidden" name="delete_ids" id="delete_ids" />
                                <input type="hidden" name="master_type" id="master_type" value="<?php echo $master_type; ?>" />

                                <?php if ($this->uri->segment(3) != '') { ?>
                                    <div class="row">
                                        <div class="col-12 col-sm-4  col-md-4 ">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView" style="display:none;">
                                                    <li><input type="submit" id="submit_btn" onclick="submitMultiple();"
                                                               value="<?php
                                                               if ($this->uri->segment(3) != '') {
                                                                   echo"Save";
                                                               } else {
                                                                   echo "Add";
                                                               }
                                                               ?>" class="wdt_100 vital_yellow_btn"></li>
                                                    <li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="row">
                                        <div class="col-12 col-sm-4  col-md-4 ">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView <?= $dis_hide; ?>">
                                                    <li><input type="submit" id="submit_btn" onclick="submitMultiple();" value="Add" class="wdt_100 vital_yellow_btn"></li>
                                                    <li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (isset($programme_edit) && $programme_edit != '') { ?>
                                    <input type="hidden" name="old_programme" id="old_programme" value="<?= isset($programme_edit) ? $programme_edit : '' ?>" />
                                    <input type="hidden" name="old_donor" id="old_donor" value="<?= isset($donor_edit) ? $donor_edit : '' ?>" />
                                    <input type="hidden" name="old_grant" id="old_grant" value="<?= isset($grant_edit) ? $grant_edit : '' ?>" />
                                    <input type="hidden" name="reasonforchange" id="reasonforchange" />
                                <?php } ?>

                                <div class="modal" id="reasondiv" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content delete-alert">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body text-center">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>Reason For Change <span style="font-size: 12px;color: #dc3545!important;">*</span></h4>
                                                            <textarea name="reason_change" id="reason_change" class="form-control required" placeholder="Enter reason"></textarea>
                                                            <label id="status_cmd_err" class="error"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" id="reasonsubmit">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </main>
                </div>
            </main>
        </div>
    </div>
</div>
</div>
</div>

<div class="modal" id="deleteModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
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
                            <p>you are about delete <span id="delCount"></span> selected information fields, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="editSubmit"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="delete_reason" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-content delete-alert">
                <div class="modal-body text-center">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-10">
                                <h4>Reason For Change <span style="font-size: 12px;color: #dc3545!important;">*</span></h4>
                                <textarea name="reason_change_delete" id="reason_change_delete" class="form-control required" type="text" placeholder="Enter comments"></textarea>
                                <label id="status_cmd_err" class="error"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer"><input type="hidden" name="delCount" id="delCount">
                    <button type="button" class="btn btn-success" id="reasonsubmit_del">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .error1 {
        color: #FF0000 !important;
        font-style: italic !important;
        text-align: left !important;
        width: 50% !important;
        float: left !important;
        margin-left: 5px !important;
    }

    .innerToolTIp {
        position: relative;
    }

    .innerToolTIp i {
        color: #1c9154;
    }

    .innerToolTIp .popover {
        background-color: rgba(0, 0, 0, 0.85);
        border-radius: 5px;
        bottom: 25px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
        color: #fff;
        display: none;
        font-size: 12px;
        font-family: 'Helvetica', sans-serif;
        left: -84px;
        padding: 24px 2px;
        position: absolute;
        width: 195px;
        z-index: 4;
        height: 70px;
        text-align: center;
        margin-top: -87px;
    }

    .innerToolTIp .popover:before {
        border-top: 7px solid rgba(0, 0, 0, 0.85);
        border-right: 7px solid transparent;
        border-left: 7px solid transparent;
        bottom: -7px;
        content: '';
        display: block;
        left: 50%;
        margin-left: -7px;
        position: absolute;
    }

    .innerToolTIp:hover .popover {
        display: block;
        -webkit-animation: fade-in .3s linear 1, move-up .3s linear 1;
        -moz-animation: fade-in .3s linear 1, move-up .3s linear 1;
        -ms-animation: fade-in .3s linear 1, move-up .3s linear 1;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $('#multipledonor_form').validate({
        rules: {
            programme: "required",
            donor: "required",
            grant: "required",
            amt_date: "required",
            "budget_head[]": "required",
            "budget_amt[]": "required",
            "line_item[]": "required",
            "reason_change": "required",
            "reason_change_delete": "required",
        },
        messages: {
            programme: "Select programme",
            donor: "Select donor",
            grant: "Select grant",
            amt_date: "Select date",
            "budget_head[]": "Select budget head",
            "budget_amt[]": "Enter amount",
            "line_item[]": "Select line item",
            "reason_change": "Enter reason",
            "reason_change_delete": "Enter reason",
        }
    });

    $(document).ready(function () {
<?php
if (isset($programme_edit) && $programme_edit != '') {
    ?>
            master_trigger();
<?php } else { ?>

            $("#addMore").click();
<?php } ?>
        setDatepicker();
    });

    $(document).on('click', '#submit_btn', function (e) {
        e.preventDefault();
<?php
if (isset($programme_edit) && $programme_edit != '') {
    ?>
            $('#reasondiv').modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            });
<?php } else { ?>
            $('#multipledonor_form').submit();
<?php } ?>
    });

    function submitMultiple(e) {
        /*  e.preventDefault();
<?php if (isset($programme_edit) && $programme_edit != '') { ?>
             $('#reasondiv').modal({show: true, backdrop: 'static', keyboard: false}
             );
<?php } else { ?>
             //$('#multipledonor_form').submit();
<?php } ?> */
    }

    $(document).on('click', '#reasonsubmit', function (e) {
        e.preventDefault();
        if ($('#multipledonor_form').valid()) {
            var in_edit = $('#reason_change').val();
            $('#reasonforchange').val(in_edit);
            $('#multipledonor_form').submit();
        }
    });

    function setDatepicker() {
        $('#amt_date').datepicker({
            changeMonth: true,
            changeYear: true,
            // showButtonPanel: true,
            dateFormat: 'dd-mm-yy',
        });
    }

    function getDonor(prgmval) {
        $('#grant').html('<option value="">--Select--</option>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getPrgmDonor",
            data: {
                parent: prgmval,
            },
            dataType: 'html',
            success: function (data) {
                $('#donor').html(data);
            }
        });
    }

    function getGrant(donorval) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getGrantlist",
            data: {
                // m_type: 'Budget Head',
                parent: donorval,
            },
            dataType: 'html',
            success: function (data) {
                $('#grant').html(data);
            }
        });

        if (donorval == '') {
            $('#granttotal').val('');
            $('#grantprojected').val('');
            $('.budget_head').html('<option value="">--Select--</option>');
            $('.line_item').html('<option value="">--Select--</option>');
            $('.subline_item').html('<option value="">--Select--</option>');
        }
    }

    function getGrantAmount(grantval) {
        var programme_id = $('#programme').val();
        var donor_id = $('#donor').val();
        $("#granttotal").val('');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getGrantamt",
            data: {
                // m_type: 'Budget Head',
                parent: grantval,
                // programme_id: programme_id,
                donor_id: donor_id
            },
            dataType: 'json',
            success: function (datas) {
                if (datas.status == 1) {
                    $("#granttotal").val(datas.total_available_amt);
                    $("#grantprojected").val(datas.projected_amt);
                }
            }
        });
    }

    $("#grant").on('change', function () {
        donor_val = $("#donor").val();
        if ($(this).val() == '') {
            $('#granttotal').val('');
            $('#grantprojected').val('');
        }
        getBudget(donor_val);
    });

    function getBudget(donorval) {
        $('.budget_head').html('<option value="">--Select--</option>');
        $('.line_item').html('<option value="">--Select--</option>');
        $('.subline_item').html('<option value="">--Select--</option>');
        $('.budget_amt').val('');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getBudgetlist",
            data: {
                m_type: 'Budget Head',
                parent: donorval,
            },
            dataType: 'html',
            success: function (data) {
                $('.budget_head').html(data);
            }
        });
    }

    function getparticularBudget(divid, donorval) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getBudgetlist",
            data: {
                m_type: 'Budget Head',
                parent: donorval,
            },
            dataType: 'html',
            success: function (data) {
                $('#budget_head_' + divid).html(data);
            }
        });
    }

    function getLineitem(divid, budgetval) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getBudgetlist",
            data: {
                m_type: 'Line Item',
                parent: budgetval,
            },
            dataType: 'html',
            success: function (data) {
                $('#line_item_' + divid).html(data);
            }
        });
    }

    function getSublineitem(divid, lineval) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getBudgetlist",
            data: {
                m_type: 'Cost Centre',
                parent: lineval,
            },
            dataType: 'html',
            success: function (data) {
                $('#subline_item_' + divid).html(data);
            }
        });
    }

    $('.summaryEdit').click(function () {
        $(".amountInput").attr("disabled", false);
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default').attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').css("display", "block");
		$(".master_check").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
        /* $('.saveLinkView').removeClass("display-hide");
         $('.saveLinkView').addClass("display-show"); */
    });
	$('.addMore').click(function () {
        $(".amountInput").attr("disabled", false);
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default').attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').css("display", "block");
		$(".master_check").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
        /* $('.saveLinkView').removeClass("display-hide");
         $('.saveLinkView').addClass("display-show"); */
    });

    function master_trigger() {
        var old_programme = $('#old_programme').val();
        var old_donor = $('#old_donor').val();
        var old_grant = $('#old_grant').val();
        $('#master_table').DataTable({
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
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/master/DTBudgetamt",
                "type": "POST",
                "data": {
                    "old_programme": old_programme,
                    "old_donor": old_donor,
                    "old_grant": old_grant
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
                selectall_chk();
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [0, 1, 2, 3, 4],
                }],
            "order": [1, 'asc']
        });
    }

    $(document).on('click', '#delUser', function () {
        $('#delCount').val('');
        var sel_item = $(".master_check:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0) {
            //$('#deletemodal').modal('show');
            var check_form_type = '<?php echo $this->uri->segment(3); ?>';
            console.log(check_form_type);
            if (check_form_type != '') {
                $('#delete_reason').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false
                });
            } else {
                $('#deleteModal').modal('show');
            }
        }
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
            // $(".master_deluser").addClass("clr_red");
            $("#delUser").removeClass("opacity5 none-pointer");
            $('.master_submit').removeClass("opacity5 none-pointer");
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
                    $('.master_submit').removeClass("opacity5 none-pointer");
                } else {
                    $('.master_submit').addClass("opacity5 none-pointer");
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
            url: "<?php echo base_url(); ?>index.php/master/deleteMasterSetting",
            data: {
                id: id,
                table: 'master_settings',
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

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

    $(document).on("keyup", ".budget_amt", function () {
        var sum = 0;
        $(".budget_amt").each(function () {
            if ($(this).val() !== "") {
                var str = $(this).val();
                var regex = /[,\s]/g;
                var result = str.replace(regex, '');
                sum += parseFloat(result);
            }
        });
        formated_val = inrFormat(sum);
        $('#totalbudget').val(formated_val);
    });

    $(document).on('click', '#addMore', function () {
        var donorval = $('#donor').val();
        var dyn = $('#master_table tr').length;
        var empty_dT = $(".dataTables_empty").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="master_tr_' + i + '" class="master_more"><input type="hidden" name="master_edit_id[]" id="master_edit_id_' + i + '" value="0"><td class="valign-center"><input class="form-control master_check new_field" type="checkbox" name="master_check" id="master_check_' + i + '" onchange="deleteids(this.value);" value="' + i + '"></td>';
        datas += '<td><select class="form-control budget_head inline_field_' + i + '" name="budget_head[]" id="budget_head_' + i + '" onchange="getLineitem(' + i + ', this.value)" ><option value="">--Select--</option><?php foreach ($budget_head as $blist) { ?><option value="<?= $blist['master_id'] ?>"><?= $blist['master_name'] ?></option><?php } ?></select></td>';
        datas += '<td><select class="form-control line_item inline_field_' + i + '" name="line_item[]" id="line_item_' + i + '" onchange="getSublineitem(' + i + ', this.value)" ><option value="">--Select--</option></select></td>';
        datas += '<td><select class="form-control subline_item inline_field_' + i + '" name="subline_item[]" id="subline_item_' + i + '" ><option value="">--Select--</option></select></td>';
        datas += '<td><input type="text" class="form-control commonAlphaNum budget_amt inline_field_' + i + '" onkeyup="sumTotal(this.value);" name="budget_amt[]" id="budget_amt_' + i + '" value="" placeholder="Enter amount" /></td></tr>';
        // $(datas).insertBefore($('#paygrade_tr_1'));
        $("#master_table tbody").prepend(datas);
        getparticularBudget(i, donorval);
        $('.master_submit').removeClass("opacity5 none-pointer");
        if (empty_dT = 1) {
            $(".dataTables_empty").parent('tr').remove();
        }
    });

    $(document).on('click', '.master_check', function () {
        if (!$(this).is(":checked")) {
            console.log('@');
            $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
            $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", true);
        } else {
            console.log('#');
            $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
            $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
        }
        if ($('input:checkbox.master_check').length > 0) {
            if ($('input:checkbox.master_check').length != $('input:checkbox.master_check:checked').length) {
                console.log('1');
                $('.master_check_all').prop('checked', false);
                $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
            } else if ($('input:checkbox.master_check').length == $('input:checkbox.master_check:checked').length) {
                console.log('2');
                $('.master_check_all').prop('checked', true);
            }
        }
        if ($('input:checkbox.master_check:checked').length == 0) {
            $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
        }
    });

    $(document).on('click', '#reasonsubmit_del', function () {
        $("#delete_reason").modal('hide');
        common_ids = [];
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
            url: "<?php echo base_url(); ?>index.php/master/commonDelete",
            data: {
                id: common_ids
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
            $(".ai").attr("disabled", true);
            $('.saveLinkView').css("display", "none");
            $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
        } else {
            $(".ai").attr("disabled", false);
            $('.saveLinkView').css("display", "block");
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

    $(document).on('click', '#delUser', function () {
        $('#delCount').val('');
        var sel_item = $(".master_check:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0) {
            var check_form_type = '<?php echo $this->uri->segment(3); ?>';
            if (check_form_type != '') {
                $('#delete_reason').modal('show');
            } else {
                $('#deleteModal').modal('show');
            }
        }
    });

    function submit_fields() {
        $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
        $('#insertEditDocument_type').submit();
    }

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

    $(document).on('input', '.commonAlphaNum', function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g, ''));
        self.val(inrFormat(self.val()));
        var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
        var matchedString = self.val().match(patt);
        if (matchedString) {
            self.val(matchedString);
        }
    });

    function inrFormat(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        var z = 0;
        var len = String(x1).length;
        var num = parseInt((len / 2) - 1);
        while (rgx.test(x1)) {
            if (z > 0) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            } else {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
                rgx = /(\d+)(\d{2})/;
            }
            z++;
            num--;
            if (num == 0) {
                break;
            }
        }
        return x1 + x2;
    }

</script>

</body>
</html>