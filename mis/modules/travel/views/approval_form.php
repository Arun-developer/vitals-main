<?php
$this->load->view('vitals_header.php', array('main_menu' => 'travellist', 'page_title' => 'Travel Request Form', 'module' => 'travel_accom'));
?>

<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'travellist')); ?>
        </div>
        <?php
        $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
        $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';
        if ($successMsg != '') {
            ?>
            <div class="position-absolute d-flex flex-column p-4 toastPlace">
                <div id="toast-container" aria-live="polite" aria-atomic="true">
                    <div id="toast-wrapper">
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                            <div class="toast-header bg-success text-white">
                                <strong class="mr-auto"><?= $successMsg; ?></strong>
                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                    <span aria-hidden="true" class="text-white">×</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        if ($errorMsg != '') {
            ?>
            <div class="position-absolute d-flex flex-column p-4 toastPlace">
                <div id="toast-container" aria-live="polite" aria-atomic="true">
                    <div id="toast-wrapper">
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                            <div class="toast-header bg-danger text-white">
                                <strong class="mr-auto"><?= $errorMsg; ?></strong>
                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                    <span aria-hidden="true" class="text-white">×</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="display-hide deleteMsg">
            <div class="position-absolute d-flex flex-column p-4 toastPlace">
                <div id="toast-container" aria-live="polite" aria-atomic="true">
                    <div id="toast-wrapper">
                        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                            <div class="toast-header bg-success text-white">
                                <strong class="mr-auto">Record(s) deleted successfully</strong>
                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                    <span aria-hidden="true" class="text-white">×</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Travel Request Form</h4>
                    </div>
                    <div class="col-xl-8 col-lg-6 col-md-12 col-12 text-right">
                        <ul class="vitals-links">
                            <li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-upload"></i></i></span> Import XLS</a></li>
                            <li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-download"></i></span> Download Import Format</a></li>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div>
                        <div class="tab-slider--navform">
                            <ul class="tab-slider--tabsform">
                                <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/user/user_ui/new_approval_note'; ?>">New Approval Note</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form method="post" id="approval_form" enctype="multipart/form-data" name="approval_form" action="<?php echo base_url() . 'index.php/travel/insertApproval_note'; ?>" class="form" novalidate autocomplete="off">

                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Approval Number<span>*</span></label>
                                                    <input value="<?php echo $approval_new; ?>" readonly class="form-control" name="approval_no" type="text" placeholder="Enter here">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Date of Seeking Approval<span>*</span></label>
                                                    <input value="<?php echo date('d-m-Y'); ?>" readonly class="form-control" name="date_of_seeking_approval" type="text" placeholder="Enter here">
                                                </div>
                                            </div>

                                            <!--<div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                            <label>To(RO)<span>*</span></label>
                                            <?php if (count($RO) == 1 || count($RO) == 0) { ?>
                                                                        <input class="form-control" readonly name="to_RO_show" id="to_RO_show" value="<?php echo $RO[0]['user_name']; ?>" type="text" placeholder="Enter here">
                                            <?php } else if (count($RO) > 1) { ?>
                                                                        <select class="form-control">
                                                <?php foreach ($RO as $list) { ?>
                                                                                            <option value="<?php echo $list['user_id']; ?>" ><?php echo $list['user_name']; ?></option>
                                                <?php } ?>
                                                                        </select>
                                            <?php } ?>
                                                    </div>
                                                </div> -->

                                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label>To(RO)<span>*</span></label>
                                                        <select class="form-control" id="to_RO_show" name="to_RO_show">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($reporting_list as $ro) { ?>
                                                                <option value='<?= $ro['emp_id']; ?>'><?= $ro['emp_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row leaveLabel">
                                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label>Purpose</label>
                                                        <textarea class="form-control" name="purpose" id="purpose"  rows="3"><?php echo 'Travel advance/reimbursements'; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row leaveLabel">
                                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label>Programme<span>*</span></label>
                                                        <select name="programme" id="programme" class="form-control">
                                                            <option value="" >-Select Programme-</option>
                                                            <?php foreach ($programmeList as $lists) { ?>
                                                                <option value="<?php echo $lists['programme_id']; ?>" ><?php echo $lists['programme']; ?></option>
                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div style="height:20px"></div>
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
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table_configcontentnew quatermetric_forma" id="multi_donor">
                                                <table class="table" id="travel_approval_table" style="margin-top:0px">
                                                    <thead>
                                                        <tr id="add_tr_1">
                                                            <th width="5%"></th>
                                                            <th width="15%">Donor <span style="font-size:12px;color:#ff0000;" >*</span></th>
                                                            <th width="15%">Grant <span style="font-size:12px;color:#ff0000;">*</span></th>
                                                            <th width="15%">Budget Head <span style="font-size:12px;color:#ff0000;">*</span></th>
                                                            <th width="15%">Line Item <span style="font-size:12px;color:#ff0000;">*</span></th>
                                                            <th width="15%">Details <span style="font-size:12px;color:#ff0000;"></span></th>
                                                            <th width="20%">Amt Available(INR) <span style="font-size:12px;color:#ff0000;">*</span></th>
                                                            <th width="20%">Amt Required(INR) <span style="font-size:12px;color:#ff0000;">*</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyid"></tbody>
                                                </table>
                                            </div>
                                            <div style="height:20px"></div>
                                            <div class="table_configcontentnew pad-bt0">
                                                <div class="tabpanel-title">
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                            <h4>Upload Document</h4>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                            <ul class="milestone-links">
                                                                <li>
                                                                    <a href="javascript:void(0)"  id="docMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" table_configcontentnew quatermetric_forma" id="document_upload">
                                                <table class="table" style="margin-top: 0">
                                                    <thead>
                                                        <tr id="document_tr_1" class="document_more">
                                                            <th width="20%">Document Description</th>
                                                            <th width="20%">Upload Document</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr id="document_tr_1" class="document_more">
                                                            <td><textarea class="form-control meet_desc" name="meet_desc[]" id="meet_desc_1" cols="30" rows="3"></textarea></td>
                                                            <td>
                                                                <div class="fileUpload blue-btn btn width100">
                                                                    <span><i class="fas fa-upload"></i> Upload</span>
                                                                    <input type="file" class="uploadlogo" name="meet_doc[][1]" id="meet_doc_1" />
                                                                </div>
                                                                <label class="sow_msg error" id="meet_doc_1_error"></label>
                                                            </td>
                                                            <td></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div style="height:20px"></div>
                                            <div class="row ">
                                                <div class="col-12 col-sm-12  col-md-12 ">
                                                    <ul class="vitals-links">
                                                        <li><input type="submit" name="submitForm" value="Send Approval Note" class="vital_yellow_btn"></li>
                                                        <li><input type="submit" name="submitForm" value="Save" class="vital_yellow_btn"></li>
                                                        <!--<li><input type="submit" name="saveForm" value="Save" class="vital_yellow_btn wdt_100"></li>-->
                                                        <li><a href="<?php echo base_url(); ?>index.php/approval/approval_note/all_pending" class="wdt_100 vital_bordered_btn">Back</a></li>
                                                    </ul>
                                                </div>
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


    $(document).on('click', '#docMore', function () {
        var dyn = $(".document_more").length;
        var i = parseInt(dyn) + 1;
        //var data = '<tr id="document_tr_' + i + '" class="document_more">';
        var data = '<tr id="document_tr_' + i + '" class="document_more remove_more">';
        data += '<td width="30%"><textarea class="form-control meet_desc" name="meet_desc[' + (i - 1) + ']" id="meet_desc_' + i + '" cols="30" rows="3"></textarea></td>';
        data += '<td width="20%"><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" name="meet_doc[]" id="meet_doc_' + i + '" /></div><label class="sow_msg error" id="meet_doc_' + i + '_error"></label></td>';
        data += '<td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeDocRow(' + i + ');" aria-hidden = "true" ></i></td></tr>';
        $("#document_upload tbody").append(data);
        //$(data).insertAfter($('#document_tr_' + dyn));
    });

    $(document).on('change', '.uploadlogo', function () {
        var filename = readURL(this);
        var reslt = filename.split('|*|');
        console.log(reslt);
        $(this).parent().children('span').html(reslt[0]);
        if (reslt[1] != '1') {
            $(this).parent().parent().children('.sow_msg').show();
            $(this).parent().parent().children('.sow_msg').text(reslt[1]);
        } else {
            $(this).parent().parent().children('.sow_msg').text('');
            $(this).parent().parent().children('.sow_msg').hide();
        }
    });
    function readURL(input) {
        var url = input.value;
        var path, filename;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        //                                                                                    var bsize = input.files[0].size;
        var bsize = (input.files.length && input.files[0].size) || '';
        var fsize = Math.round(bsize / 1024);
        if (fsize <= 10000) {
            if (fsize != 0) {
                if (input.files && input.files[0] && (ext == "pdf" || ext == "doc" || ext == "docx" || ext == "ppt" || ext == "pptx")) {
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

    $(document).on('click', '#apply_form', function (e) {
        if ($('#approval_form').valid() == true) { //return false;
            $('#approval_form').submit();
        } else {
            return false;
        }
    });

    $('#approval_form').validate({
        rules: {
            "programme": "required",
            "donor_list[]": "required",
            "grant_list[]": "required",
            "budget_head[]": "required",
            "line_item[]": "required",
            //"additional_info[]": "required",
            "amt_available[]": "required",
            "amt_required[]": "required",
            "to_RO_show": "required",
        },
        messages: {
            "programme": "Select Programme",
            "donor_list[]": "Select donor",
            "grant_list[]": "Select grant",
            "budget_head[]": "Select budget",
            "line_item[]": "Select line item",
            //"additional_info[]": "Select additional info",
            "amt_available[]": "Select amount",
            "amt_required[]": "Select amount",
            "to_RO_show": "Select Ro",
        }
    });

    $(document).on('change', '#programme', function (e) {
        $("#tbodyid").empty();
        var numItems = $('.donor_cls').length;
        if (numItems == 0 && $(this).val() != '') {
            $('#addMore')[0].click();
        }
    });
    $(document).on('change', '.donor_cls', function (e) {
        var programm_id = $("#programme").val();
        var current_attr = $(this).attr('data-attr');

        //alert(current_attr);
        var donor_id = $(this).val();
        $("#amt_available_" + current_attr).val('');

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/travel/ajax_get_grant",
            data: {
                programm_id: programm_id,
                donor_id: donor_id
            },
            dataType: 'json',
            success: function (resp) {
                console.log(resp);
                $("#grant_list_" + current_attr).html(resp.response);
            }
        });
    });

    $(document).on('change', '.grant_cls', function (e) {
        var grant_id = $(this).val();
        var programm_id = $("#programme").val();
        var current_attr = $(this).attr('data-attr');
        //alert(current_attr);

        var current_attr = $(this).attr('data-attr');
        $("#amt_available_" + current_attr).val('');
        var donor_id = $("#donor_" + current_attr).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/travel/ajax_get_budget_head",
            data: {
                programm_id: programm_id,
                donor_id: donor_id,
                grant_id: grant_id
            },
            dataType: 'json',
            success: function (resp) {
                console.log(resp);
                $("#budget_head_" + current_attr).html(resp.response);
            }
        });
    });

    $(document).on('change', '.budget_cls', function (e) {
        var budget_id = $(this).val();
        var programm_id = $("#programme").val();
        var current_attr = $(this).attr('data-attr');

        var donor_id = $("#donor_" + current_attr).val();
        var grant_id = $("#grant_list_" + current_attr).val();
        $("#amt_available_" + current_attr).val('');
        //alert(budget_id);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/travel/ajax_get_lineitem",
            data: {
                programm_id: programm_id,
                donor_id: donor_id,
                grant_id: grant_id,
                budget_id: budget_id
            },
            dataType: 'json',
            success: function (resp) {
                console.log(resp);
                $("#line_item_" + current_attr).html(resp.response);
            }
        });
    });



    $(document).on('click', '#submit_btn', function (e) {
        $("#travelrequest_form").valid();
        if ($("#travelrequest_form").valid() == true) {
            $("#travelrequest_form").submit()
        }
        return false;
    });


    $(document).on('change', '.line_item_cls', function (e) {




        var donor = [];
        var budgethead = [];
        var lineitem = [];
        var amtavailable = [];
        var amtreq = [];
        var grant_list = [];
        var progid = $("#programme").val();
        $("select[name='donor_list[]']").each(function () {
            donor.push($(this).val());
        });
        $("select[name='budget_head[]']").each(function () {
            budgethead.push($(this).val());
        });
        $("select[name='line_item[]']").each(function () {
            lineitem.push($(this).val());
        });
        $("input[name='amt_available[]']").each(function () {
            amtavailable.push($(this).val());
        });
        $("input[name='amt_required[]']").each(function () {
            amtreq.push($(this).val());
        });
        $("select[name='grant_list[]']").each(function () {
            grant_list.push($(this).val());
        });
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/travel/check_calucalations",
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

        var current_attr = $(this).attr('data-attr');
        var donor_id = $("#donor_" + current_attr).val();
        var grant_list_id = $("#grant_list_" + current_attr).val();
        var budget_head_id = $("#budget_head_" + current_attr).val();
        var line_item_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/travel/getAdditionalList",
            data: {
                program: progid,
                donor: donor_id,
                budget: budget_head_id,
                lineitem: line_item_id
            },
            dataType: 'json',
            success: function (resp) {
                console.log(resp.response);
                $("#additional_info_" + current_attr).html(resp.response);
            }
        });

    });


    $(document).ready(function () {
        //$('.scrollsideMenu').scrollTop($('.scrollsideMenu').scrollTop()+170);
        $('.nav-tabs').scrollingTabs({
            enableSwiping: true
        }).on('ready.scrtabs', function () {
            $('.tab-content').show();
        });
        $('#navLoad').removeClass('display-hide');
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 190) + 'px'
        });
        $('.toast').toast('show');
        setTimeout(function () {
            $('.success').addClass('display-hide');
        }, 3000);

    });

    function showJourny(value) {
        $(".edit_cls ").val('');
        if (value == 'round') {
            $("#form_type").css('display', 'block');
        } else if (value == 'one') {
            $("#form_type").css('display', 'none');
        }
    }

    $(document).on('click', '.accomodation_cls', function () {
        var current_val = $(this).val();
        $("#accommodation_status").css('display', 'none');
        if (current_val == 'yes') {
            $("#accommodation_status").css('display', 'block');
        }
    });

    $(document).on('click', '.summaryEdit', function () {

        $("#edit_status").val("1");
        $(".edit_cls").attr("disabled", false);
        $(".multiselect").attr("disabled", false);
        $("#submit_btn_cls").css("display", "block");
        $(".edit").addClass("activeTabs");
    });

    $(document).on('click', '#deleteRecord', function () {
        common_ids = [];
        $(".master_check").each(function (index) {
            if ($(this).is(":checked")) {
                var attr_val = $(this).attr('data-attr');
                $('.row_cls_' + attr_val).remove();
            }
            $('.deleteMsg').removeClass('display-hide');
        });
        $('#deletemodal').modal('hide');
        var no_data_append = '<tr class="odd no_data" style="text-align: center;"><td valign="top" colspan="5" class="dataTables_empty none-pointer">No data available in table</td></tr>';
        if ($('input:checkbox.master_check:checked').length == 0) {
            $("#travel_request_form tbody").append(no_data_append);
        } else {
            $(".no_data").remove();
        }


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
                console.log('1');
                $('.master_check_all').prop('checked', false);
                $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
            } else if ($('input:checkbox.master_check').length == $('input:checkbox.master_check:checked').length) {
                console.log('2');
                $('.master_check_all').prop('checked', true);
            }
        }
        if ($('input:checkbox.master_check:checked').length == 0) {
            console.log('3');
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


    function removeRow(div_id) {
        $('#add_tr_' + div_id).closest('tr').remove();
    }

    function removeDocRow(div_id) {
        $('#document_tr_' + div_id).closest('tr').remove();
    }


    $(document).on('click', '#addMore', function () {
        var programm_id = $("#programme").val();
        if (programm_id == '') {
            $('#approval_form').valid();
            return false;
        }

        $(".dataTables_empty").css('display', 'none');

        var i = travel_request_count = $('#multi_donor tr').length + 1;
        var minus_btn = '<td><i></i>';
        if (i > 2) {
            var minus_btn = '<td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow(' + i + ');" aria-hidden = "true" ></i>';
        }

        var datas = '<tr id="add_tr_' + i + '" id="master_tr_' + i + '" class="row_cls_' + travel_request_count + '"><input type="hidden" name="edit_id[' + i + ']" >' + minus_btn + '</td><td class="valign-center"><select id="donor_' + i + '" class="form-control donor_cls" name="donor_list[]" data-attr =' + travel_request_count + ' ><option value="">--Select--</option></select></td>';
        datas += '<td id="set_user_type_' + travel_request_count + '" ><select id="grant_list_' + i + '" data-attr =' + travel_request_count + ' class="form-control grant_cls" name="grant_list[]" ><option value="">--Select--</option></select></td>';
        datas += '<td id="set_user_type_' + travel_request_count + '" ><select id="budget_head_' + i + '" data-attr =' + travel_request_count + ' class="form-control budget_cls" name="budget_head[]" ><option>--Select--</option value=""></select></td>';
        datas += '<td id="set_user_type_' + travel_request_count + '" ><select id="line_item_' + i + '" data-attr =' + travel_request_count + ' class="form-control line_item_cls" name="line_item[]" ><option value="">--Select--</option></select></td>';
        datas += '<td id="set_user_type_' + travel_request_count + '" ><select id="additional_info_' + i + '" data-attr =' + travel_request_count + ' class="form-control additional_info_cls" name="additional_info[]" ><option value="">--Select--</option></select></td>';
        datas += '<td id="set_user_type_' + travel_request_count + '" ><input readonly id="amt_available_' + i + '" data-attr =' + travel_request_count + ' placeholder="Enter Amount" class="form-control amt_available_cls" name="amt_available[]" ></input></td>';
        datas += '<td id="set_user_type_' + travel_request_count + '" ><input id="amt_required_' + i + '" data-attr =' + travel_request_count + ' placeholder="Enter Amount" class="form-control amt_required_cls" name="amt_required[]" ></input></td></tr>';

        if (programm_id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/travel/ajax_get_donor",
                data: {
                    programm_id: programm_id
                },
                dataType: 'json',
                success: function (resp) {
                    $("#donor_" + i).html(resp.response);
                }
            });
        }

        $("#multi_donor tbody").append(datas);
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
        $('#insertEditDocument_type').submit();
    }

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

</script>
</body>

<style>
    .dataTables_scrollBody{
        margin-top: -15px;
    }
</style>

</html>