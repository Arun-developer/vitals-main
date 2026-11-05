<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Edit Internal Note', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'my_internal_note')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/internal/internal_note_details/' . $internalNoteDetails[0]["internal_id"]; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4>Edit Internal Note <?php
                            if (isset($internalNoteDetails[0]['internal_no']) && $internalNoteDetails[0]['internal_no'] != '') {
                                echo '- ' . $internalNoteDetails[0]['internal_no'];
                            }
                            ?></h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right"></div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <form name="addApproval" id="addApproval" enctype="multipart/form-data" action="<?php echo base_url() . 'index.php/internal/insert_internal_note'; ?>" method="post" autocomplete="off">
                                    <input type="hidden" name="internal_edit_id" value="<?php echo $internalNoteDetails[0]["internal_id"]; ?>" >
                                    <div class="inputplan-structureall plan-structure-new">
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">

                                                <div class="form-group">
                                                    <label>Internal Note Number</label>
                                                    <input class="form-control" name="internal_no" type="text" readonly="" value="<?php
                                                    if (isset($internalNoteDetails[0]['internal_no']) && $internalNoteDetails[0]['internal_no'] != '') {
                                                        echo $internalNoteDetails[0]['internal_no'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Date<span>*</span></label>
                                                    <input class="form-control" name="date" type="text" name="approval_no" readonly="" value="<?php
                                                    if (isset($internalNoteDetails[0]['date']) && $internalNoteDetails[0]['date'] != '') {
                                                        echo $internalNoteDetails[0]['date'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>From<span>*</span></label>
                                                    <input class="form-control" readonly name="to_RO_show" id="to_RO_show" value="<?php
                                                    if (isset($from_employee) && $from_employee != '') {
                                                        echo $from_employee;
                                                    }
                                                    ?>" type="text" placeholder="Enter here">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Subject</label>
                                                    <input class="form-control" name="subject" type="text" name="subject" readonly="" value="<?php
                                                    if (isset($internalNoteDetails[0]['subject']) && $internalNoteDetails[0]['subject'] != '') {
                                                        echo $internalNoteDetails[0]['subject'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Approval Number<span>*</span></label>
                                                    <input class="form-control" name="approval_no" type="text" readonly="" value="<?php
                                                    if (isset($internalNoteDetails[0]['approval_no']) && $internalNoteDetails[0]['approval_no'] != '') {
                                                        echo $internalNoteDetails[0]['approval_no'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Programme<span>*</span></label>
                                                    <input class="form-control" name="programme" type="text" readonly="" value="<?php
                                                    if (isset($internalNoteDetails[0]['programme_name']) && $internalNoteDetails[0]['programme_name'] != '') {
                                                        echo $internalNoteDetails[0]['programme_name'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="approval_id" value="<?php echo $internalNoteDetails[0]['approval_id']; ?>" >
                                        <div style="height:20px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table" id="detail_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="removeArrow"></th>
                                                        <th width="13%">Donor<span class="clr-red">*</span></th>
                                                        <th width="15%">Grant<span class="clr-red">*</span></th>
                                                        <th width="15%">Budget Head<span class="clr-red">*</span></th>
                                                        <th width="15%">Line Item<span class="clr-red">*</span></th>
                                                        <th width="15%">Sub-Line Item<span class="clr-red">*</span></th>
                                                        <th width="10%">Details</th>
                                                        <th width="10%">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $tot_amount = 0;
                                                    foreach ($donorAN as $dataList) {
                                                        $tot_amount += $dataList['amt_required'];
                                                        $this->load->model('Minternal');
                                                        $get_grantName = $this->Minternal->get_grantName($an['grant_id']);
                                                        if ($get_grantName[0]->status_type == 'open') {
                                                            $opt_disable = '';
                                                            $opt_color = '#fff';
                                                        } else {
                                                            $opt_disable = 'disabled';
                                                            $opt_color = '#f1c2c4';
                                                        }
                                                        ?>
                                                        <tr id="add_tr_1" class="add_more">
                                                            <td class="align-middle">
                                                                <input value="<?php
                                                                if (isset($dataList['approval_donor_id']) && $dataList['approval_donor_id'] != '') {
                                                                    echo $dataList['approval_donor_id'];
                                                                }
                                                                ?>" type="checkbox" <?= $opt_disable; ?> <?= (($get_grantName[0]->status_type == 'open') ? 'checked' : ($apn_donor_id[0]['approval_donor_id'] == $an['approval_donor_id'])) ? 'checked' : ''; ?> class="form-control" name="select_donor" >
                                                            </td>
                                                            <td>
                                                                <input value="<?php
                                                                if (isset($dataList['donor']) && $dataList['donor'] != '') {
                                                                    echo $dataList['donor'];
                                                                }
                                                                ?>" readonly type="text" class="form-control" name="donor_list[]" id="donor_1" >
                                                            </td>

                                                            <td>
                                                                <input readonly value="<?php echo $get_grantName[0]->name; ?>"  type="text" class="form-control" name="grant_list[]" id="grant_1" >
                                                            </td>
                                                            <td>
                                                                <input value="<?php
                                                                if (isset($dataList['budget_head']) && $dataList['budget_head'] != '') {
                                                                    echo $dataList['budget_head'];
                                                                }
                                                                ?>" readonly type="text" class="form-control" name="budget_list[]" id="budget_1" >
                                                            </td>
                                                            <td>
                                                                <input value="<?php
                                                                if (isset($dataList['line_item']) && $dataList['line_item'] != '') {
                                                                    echo $dataList['line_item'];
                                                                }
                                                                ?>" readonly type="text" class="form-control" name="line_list[]" id="lineitem_1" >
                                                            </td>
                                                            <td>
                                                                <input value="<?php
                                                                if (isset($dataList['donor']) && $dataList['donor'] != '') {
                                                                    echo $dataList['donor'];
                                                                }
                                                                ?>" readonly type="text" class="form-control" name="donor_list[]" id="sublineitem_1" >
                                                            </td>
                                                            <td>
                                                                <input value="<?php
                                                                if (isset($dataList['cost_centre']) && $dataList['cost_centre'] != '') {
                                                                    echo $dataList['cost_centre'];
                                                                }
                                                                ?>" readonly type="text" class="form-control" name="additional_list[]" id="additional_1" >
                                                            </td>
                                                            <td>
                                                                <input value="<?php
                                                                if (isset($dataList['amt_required']) && $dataList['amt_required'] != '') {
                                                                    echo $dataList['amt_required'];
                                                                }
                                                                ?>" readonly type="text" class="form-control" name="amount" >
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="height:20px"></div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Amount for which approval has been taken (<?= $this->session->userdata['currency']; ?>)<span>*</span></label>
                                                    <input  name="total_amount" value="<?php
                                                    if (isset($internalNoteDetails[0]['total_amount']) && $internalNoteDetails[0]['total_amount'] != '') {
                                                        echo $internalNoteDetails[0]['total_amount'];
                                                    }
                                                    ?>" class="form-control" type="text" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Remaining amount on the selected donor (<?= $this->session->userdata['currency']; ?>)<span>*</span></label>
                                                    <input value="<?php echo $donor_balance; ?>" class="form-control" type="text" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Amount to be approved (<?= $this->session->userdata['currency']; ?>)<span>*</span></label>
                                                    <input class="form-control" name="amount_toapprove" type="text" id="amount_toapprove" readonly="" value="<?php
                                                    if (isset($internalNoteDetails[0]['amount_toapprove']) && $internalNoteDetails[0]['amount_toapprove'] != '') {
                                                        echo $internalNoteDetails[0]['amount_toapprove'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Date of Invoice<span>*</span></label>
                                                    <div class="position-relative">
                                                        <input class="form-control" placeholder="dd-mm-yy"  id="invoice_date" name="invoice_date" type="text"  value="<?php
                                                        if (isset($internalNoteDetails[0]['invoice_date']) && $internalNoteDetails[0]['invoice_date'] != '') {
                                                            echo $internalNoteDetails[0]['invoice_date'];
                                                        }
                                                        ?>">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Proposed date of processing payments<span>*</span></label>
                                                    <div class="position-relative">
                                                        <input class="form-control"  id="proposed_date" placeholder="dd-mm-yy" name="proposed_date" type="text"  value="<?php
                                                        if (isset($internalNoteDetails[0]['proposed_date']) && $internalNoteDetails[0]['proposed_date'] != '') {
                                                            echo $internalNoteDetails[0]['proposed_date'];
                                                        }
                                                        ?>">
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Reason for which payment is sought</label>
                                                    <div class="position-relative">
                                                        <textarea class="form-control" name="reason_payment_sougnt" id="reason_payment_sougnt"><?php
                                                            if (isset($internalNoteDetails[0]['reason_payment_sougnt']) && $internalNoteDetails[0]['reason_payment_sougnt'] != '') {
                                                                echo $internalNoteDetails[0]['reason_payment_sougnt'];
                                                            }
                                                            ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Supporting documents attached</label>
                                                    <div class="position-relative">
                                                        <textarea class="form-control" name="supporting_documents" id="supporting_documents"><?php
                                                            if (isset($internalNoteDetails[0]['supporting_documents']) && $internalNoteDetails[0]['supporting_documents'] != '') {
                                                                echo $internalNoteDetails[0]['supporting_documents'];
                                                            }
                                                            ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Payment in favor of<span>*</span></label>
                                                    <input class="form-control" name="payment_favor" type="text" readonly="" value="<?php
                                                    if (isset($internalNoteDetails[0]['payment_favor']) && $internalNoteDetails[0]['payment_favor'] != '') {
                                                        echo $internalNoteDetails[0]['payment_favor'];
                                                    }
                                                    ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div style="height:20px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <h4>Supporting Documents</h4>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <ul class="milestone-links">
                                                            <li>
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15" id="docMore"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="35%">Upload Document</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    if (php72_count(unserialize($approvalNoteDetails[0]['attachment']))) {
                                                        foreach (unserialize($internalNoteDetails[0]['attachment']) as $key => $value) {
                                                            //if (file_exists('uploads/support_docs/' . $value)){<tr id="document_tr_1" class="document_more remove_more"><td width="20%">
                                                            ?>
                                                            <tr id="document_tr_<?php echo $i; ?>" class="document_more">
                                                        <input type="hidden" name="exist_doc[]" class="exist_doc_<?php echo $i; ?>" id="exist_doc_<?php echo $i; ?>" value="<?= $value; ?>" />
                                                        <td>
                                                            <div class="fileUpload blue-btn btn width100">
                                                                <span><i ></i> <?php echo substr($value, -10); ?></span>
                                                                <input type="file" value="<?php echo substr($value, -10); ?>" class="uploadlogo" name="meet_doc[]"  id="meet_doc_<?php echo $i; ?>" />
                                                            </div>
                                                            <span class="download-btn"><a href="<?php
                                                                if (isset($value) && $value != '') {
                                                                    echo base_url() . '/uploads/support_docs/' . $value;
                                                                }
                                                                ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>

                                                            <i title="Remove" class="fas fa-minus-circle cursor" onclick="removeDocRow(<?php echo $i; ?>);" aria-hidden="true"></i>

                                                            <label class="sow_msg error" id="meet_doc_<?php echo $i; ?>_error"></label>
                                                        </td>
                                                        <td></td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                        //}</td></tr>
                                                    }
                                                } else {
                                                    ?>
                                                    <tr id="document_tr_1" class="document_more">
                                                        <td><textarea class="form-control meet_desc" name="supporting_documents[]" id="meet_desc_1" cols="30" rows="3"></textarea><label class="error" id="meet_desc_1_error"></label></td>
                                                        <td>
                                                            <div class="fileUpload blue-btn btn width100">
                                                                <span><i class="fas fa-upload"></i> Upload</span>
                                                                <input type="file" value="" class="uploadlogo" name="meet_doc[]"  id="meet_doc_1" />
                                                            </div>

                                                            <label class="sow_msg error" id="meet_doc_1_error"></label>
                                                        </td>

                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div style="height:20px"></div>
                                        <div class="row ">
                                            <div class="col-12 col-sm-12  col-md-12 ">
                                                <ul class="vitals-links">
                                                    <li><input type="submit" name="submitForm" value="Update" class="vital_yellow_btn wdt_100"></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('input[type="checkbox"]').on('change', function () {
            $('input[type="checkbox"]').not(this).prop('checked', false);
        });

        $('#invoice_date').datepicker({
            dateFormat: "dd-mm-yy",
        });

        $('#proposed_date').datepicker({
            dateFormat: "dd-mm-yy",
        });

        $('#addApproval').validate({
            rules: {
                "programme": "required",
                "donor_list[]": "required",
                "grant_list[]": "required",
                "budget_list[]": "required",
                "line_list[]": "required",
                "amt_required[]": "required",
                "to_RO": "required",
                "date_of_seeking_approval": "required",
            },
            messages: {
                "programme": "Select Programme",
                "donor_list[]": "Select donor",
                "grant_list[]": "Select grant",
                "budget_list[]": "Select budget",
                "line_list[]": "Select line item",
                "amt_required[]": "Enter amount",
                "date_of_seeking_approval": "Select Date",
                "to_RO": "Select RO",
            }
        });

    });

    $(document).on("focus", ".seeking_date", function () {
        if ($(this).hasClass('hasDatepicker') === false) {
            $(this).datepicker({dateFormat: 'dd-mm-yy'});
        }
    });

    function removeAddMore() {
        $(".remove_more").remove();
    }

    function getDonorList(id, val) {
        if (id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/approval/getDonorNameList",
                type: 'POST',
                "data": {'program': val},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    var i = 0;
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + split_arr[i].donor_id + '">' + split_arr[i].master_name + '</option>');
                        i++;
                    });
                    $('#donor_' + id).html(output.join(''));
                }
            });
        }
    }

    function getGrantList(id, val) {
        if (id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/approval/getGrantNameList",
                type: 'POST',
                "data": {'donor': val},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    var i = 0;
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + split_arr[i].id + '">' + split_arr[i].name + '</option>');
                        i++;
                    });
                    $('#grant_' + id).html(output.join(''));
                }
            });
        }
    }

    function getBudgetList(id, val) {
        if (id != '') {
            var program = $('#programme_id').val();
            var donor = $('#donor_' + id).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/approval/getBudgetItemList",
                type: 'POST',
                "data": {'program': program, 'donor': donor, 'grant': val},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    var i = 0;
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + split_arr[i].budget_id + '">' + split_arr[i].master_name + '</option>');
                        i++;
                    });
                    $('#budget_' + id).html(output.join(''));
                }
            });
        }
    }

    function getLineList(id, val) {
        if (id != '') {
            var program = $('#programme_id').val();
            var donor = $('#donor_' + id).val();
            var grant = $('#grant_' + id).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/approval/getLineList",
                type: 'POST',
                "data": {'program': program, 'donor': donor, 'grant': grant, 'budget': val},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    var i = 0;
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + split_arr[i].line_itemid + '">' + split_arr[i].master_name + '</option>');
                        i++;
                    });
                    $('#lineitem_' + id).html(output.join(''));
                }
            });
        }
    }

    function getAdditionalList(id, val) {
        if (id != '') {
            var program = $('#programme_id').val();
            var donor = $('#donor_' + id).val();
            var budget = $('#budget_' + id).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/approval/getAdditionalList",
                type: 'POST',
                "data": {'program': program, 'donor': donor, 'budget': budget, 'lineitem': val},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    var i = 0;
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + split_arr[i].id + '">' + split_arr[i].additionalinfo + '</option>');
                        i++;
                    });
                    $('#additional_' + id).html(output.join(''));
                }
            });
        }
    }

    function getAvailAmount() {
        var donor = [];
        var grant_list = [];
        var budgethead = [];
        var lineitem = [];
        var amtavailable = [];
        var amtreq = [];
        var progid = $("#programme_id").val();

        $("select[name='donor_list[]']").each(function () {
            donor.push($(this).val());
        });
        $("select[name='grant_list[]']").each(function () {
            grant_list.push($(this).val());
        });
        $("select[name='budget_list[]']").each(function () {
            budgethead.push($(this).val());
        });
        $("select[name='line_list[]']").each(function () {
            lineitem.push($(this).val());
        });
        $("input[name='amt_available[]']").each(function () {
            amtavailable.push($(this).val());
        });
        $("input[name='amt_required[]']").each(function () {
            amtreq.push($(this).val());
        });

        $.ajax({
            url: '<?php echo base_url(); ?>index.php/approval/check_calucalations',
            data: {donor: donor, budgethead: budgethead, lineitem: lineitem, amtavailable: amtavailable, amtreq: amtreq, progid: progid, grant_list: grant_list},
            dataType: "json",
            type: 'POST',
            success: function (msg) {
                $("input[name='amt_available[]']").each(function (i, elem) {
                    $(this).val(msg[i]["amtavailable"]);
                    $("input[name='amt_required[]']").eq(i).val(msg[i]["amtreq"]);
                });
            }
        });
    }

    $(document).on('click', '#addMore', function () {
        var dyn = $(".add_more").length;
        var i = parseInt(dyn) + 1;
        var program_id = $('#programme_id').val();
        getDonorList(i, program_id);
        var datas = '<tr id="add_tr_' + i + '" class="add_more remove_more"><td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow(' + i + ');" aria-hidden = "true" ></i></td>';
        datas += '<td><select class="form-control" name="donor_list[]" id="donor_' + i + '" onchange="getGrantList(' + i + ', this.value);"><option value="">--Select--</option></td>';
        datas += '<td><select class="form-control" name="grant_list[]" id="grant_' + i + '" onchange="getBudgetList(' + i + ', this.value);"><option value="">--Select--</option></select></td>';
        datas += '<td><select class="form-control" name="budget_list[]" id="budget_' + i + '" onchange="getLineList(' + i + ', this.value);"><option value="">--Select--</option></select></td>';
        datas += '<td><select class="form-control" name="line_list[]" id="lineitem_' + i + '" onchange="getAdditionalList(' + i + ', this.value);getAvailAmount(' + i + ', this.value);"><option value="">--Select--</option></select></td>';
        datas += '<td><select class="form-control" name="additional_list[]" id="additional_' + i + '"><option value="">--Select--</option></select></td>';
        datas += '<td><input class="form-control" readonly="" name="amt_available[]" id="amt_available_' + i + '" placeholder="Available Amount"></td>';
        datas += '<td><input class="form-control" name="amt_required[]" id="amt_required_' + i + '" placeholder="Enter Amount"></td></tr>';
        $(datas).insertAfter($('#add_tr_' + dyn));
    });

    function removeRow(div_id) {
        $('#add_tr_' + div_id).closest('tr').remove();
    }

    function removeDocRow(div_id) {
        $('#document_tr_' + div_id).closest('tr').remove();
    }

    $(document).on('click', '#docMore', function () {
        var dyn = $(".document_more").length;
        var i = parseInt(dyn) + 1;
        //var data = '<tr id="document_tr_' + i + '" class="document_more">';
        var data = '<tr id="document_tr_' + i + '" class="document_more remove_more">';
        data += '<td width="20%"><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" name="meet_doc[]" id="meet_doc_' + i + '" /></div><label class="sow_msg error" id="meet_doc_' + i + '_error"></label></td>';
        data += '<td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeDocRow(' + i + ');" aria-hidden = "true" ></i></td></tr>';
        $(data).insertAfter($('#document_tr_' + dyn));
    });

    $(document).on("click", ".vital_yellow_btn", function () {
        if ($('#addApproval').valid() == true) {
            var result = formValidate();
            if (result == 1) {
                return false;
            } else {
				$('.vital_yellow_btn').css('pointer-events', 'none');
                return true;
            }
        } else {
            return false;
        }
    });

    function formValidate() {
        var err = 0;
        var cmnt_arr = [];
        var hid_docarr = [];
        var cmnt_dyn = document.getElementsByName("meet_doc[]").length;
        for (var r = 0; r < cmnt_dyn; r++) {
            var dyn_id = document.getElementsByName("meet_doc[]")[r].id;
            var hdoc_id = document.getElementsByName("exist_doc[]")[r].id;
            cmnt_arr.push(dyn_id);
            hid_docarr.push(hdoc_id);
        }

        var s = 1;
        for (var q = 0; q < cmnt_arr.length; q++) {
            var cmnt_desc = $('#meet_desc_' + s).val();
            var doc = $('#' + cmnt_arr[q]).val();
            var hid_doc = $('#' + hid_docarr[q]).val();

            if (hid_doc == '') {
                if (doc == '') {
                    $('#' + cmnt_arr[q] + '_error').css('display', 'block');
                    $('#' + cmnt_arr[q] + '_error').text('Upload document');
                    err = 1;
                } else {
                    $('#' + cmnt_arr[q] + '_error').css('display', 'none');
                    $('#' + cmnt_arr[q] + '_error').text('');
                }
            } else {
                $('#' + cmnt_arr[q] + '_error').css('display', 'none');
                $('#' + cmnt_arr[q] + '_error').text('');
            }

            s++;
        }
        var g = 1;
        $(".uploadlogo").each(function () {
            var doc_desc = $('#meet_desc_' + g).val();
            var inputid = $(this).attr('id');
            var sprid = inputid.split('_');
            var hid_doc = $('#exist_doc_' + sprid[2]).val();
            if (typeof hid_doc == undefined || hid_doc == '') {
                var filename = readURL(this);
                if (filename) {
                    var result = filename.split('|*|');
                    $(this).parent().children('span').html(result[0]);
                    if (result[1] != '1') {
                        $(this).parent().parent().children('.sow_msg').show();
                        $(this).parent().parent().children('.sow_msg').text(result[1]);
                        err = 1;
                    } else {
                        $(this).parent().parent().children('.sow_msg').text('');
                        $(this).parent().parent().children('.sow_msg').hide();
                    }
                }
                g++;
            }
        });
        return err;
    }

    $(document).on('change', '.uploadlogo', function () {
        var inputid = $(this).attr('id');
        var sprid = inputid.split('_');
        var hid_doc = $('#exist_doc_' + sprid[2]).val();
        var filename = readURL(this);

        var reslt = filename.split('|*|');
        $(this).parent().children('span').html(reslt[0]);
        if (reslt[1] != '1') {
            $(this).parent().parent().children('.sow_msg').show();
            $(this).parent().parent().children('.sow_msg').text(reslt[1]);
        } else {
            $('#exist_doc_' + sprid[2]).val('');
            $(this).parent().parent().children('.sow_msg').text('');
            $(this).parent().parent().children('.sow_msg').hide();
        }
    });

    function readURL(input) {
        var url = input.value;
        var path, filename;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        //var bsize = input.files[0].size;
        var bsize = (input.files.length && input.files[0].size) || '';
        var fsize = Math.round(bsize / 1024);
        if (fsize <= 10000) {
            if (fsize != 0) {
                if (input.files && input.files[0] && (ext == "pdf" || ext == "doc" || ext == "docx" || ext == "ppt" || ext == "pptx" || ext == "jpg" || ext == "jpeg" || ext == "gif" || ext == "png" || ext == "xls" || ext == "xlsx" || ext == "csv")) {
                    path = $(input).val();
                    filename = path.replace(/^.*\\/, "");
                    return filename + '|*|1';
                } else {
                    filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file';
                    return filename;
                }
            } else {
                filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Upload document';
                return filename;
            }
        } else {
            filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file size';
            return filename;
        }
    }

</script>

</body>
</html>