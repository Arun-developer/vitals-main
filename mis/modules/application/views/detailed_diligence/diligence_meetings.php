<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => 'Detailed Assessment - ' . $innovation['name_of_enterprise'])); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'diligence_document', 'inv_stage' => $innovation['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content vital_windowScroll">
                <?php $this->load->view('detailed_diligence/diligence_options.php', array('application_id' => $application_id, 'title' => 'Meetings/Call Notes', 'inv_id' => $inv_id_format, 'stage' => $stage_name, 'status' => $status_name, 'incharge' => $assign_incharge, 'enterprise_name' => $innovation['name_of_enterprise'], 'sector' => $sector[0]['sector'], 'sub_sector' => $subsector, 'assign_to' => $assign_to, 'eic_date' => $eic_date)); ?>

                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/diligence_documents/' . $application_id; ?>">Documents</a></li>
                                <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/application/diligence_meetings/' . $application_id; ?>">Meetings/Call Notes</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="table_configcontentnew pad-bt0">
                                <div class="tabpanel-title">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9"></div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                            <ul class="milestone-links">
                                                <?php if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || php72_in_array($this->session->userdata('emp_number'), $assign_incharge_id)) { ?>
                                                    <li class="brd-left-onboard" id="disableSave"><a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a></li>
                                                    <li class="brd-left-onboard" id="disableBtn"><a href="javascript:void(0)" class="deleteControl" id="deleteBtn"><i class="fas fa-trash-alt"></i> Delete</a></li>
                                                    <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue" id="saveForm">Save</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form method="post" id="diligenceMeetings" action="<?php echo base_url() . 'index.php/application/save_diligence_meeting'; ?>" class="form" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" name='inv_id' value="<?= $application_id; ?>" />
                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                    <table class="table table-hover dt-responsive" id="master_table">
                                        <thead>
                                            <tr>
                                                <th width="5%"></th>
                                                <th width="15%">Date<span class="text-danger">*</span></th>
                                                <th width="25%">Meeting Type<span class="text-danger">*</span></th>
                                                <th width="25%">Comments<span class="text-danger">*</span></th>
                                                <th width="20%">Minutes Doc<span class="text-danger">*</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $j = 1;
                                            if (php72_count($meeting_list) > 0) {
                                                for ($i = 0; $i < php72_count($meeting_list); $i++) {
                                                    ?>
                                                <input type="hidden" name='meeting_id[<?= $i; ?>]' id="meeting_id_<?= $j; ?>" value="<?php echo $meeting_list[$i]['meeting_id']; ?>" />
                                                <tr id="document_tr_<?php echo $j; ?>" class="document_more">
                                                    <td class="align-middle">
                                                        <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                            <div class="input-group">
                                                                <input type="checkbox" class="check_box" aria-label="Checkbox for following text input"
                                                                       name="check_delete" id="check_delete_<?php echo $j; ?>" value="<?php echo $meeting_list[$i]['meeting_id']; ?>">
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="meet_date[<?= $i; ?>]" id="meet_date_<?= $j; ?>" class="form-control meet_date" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($meeting_list[$i]['meeting_date'])); ?>"/>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="form-control form-control-sm meet_type" name="meet_type[<?= $i; ?>]" id="meet_type_<?= $j; ?>">
                                                                <option value="">--Select--</option>
                                                                <?php foreach ($meeting_type as $t) { ?>
                                                                    <option value="<?php echo $t['id']; ?>" <?php
                                                                    if ($t['id'] == $meeting_list[$i]['meeting_type']) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>><?php echo $t['name']; ?></option>
                                                                        <?php } ?>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <textarea class="form-control meet_desc" name="meet_desc[<?= $i; ?>]" id="meet_desc_<?= $j; ?>" cols="30" rows="3"><?= $meeting_list[$i]['comments']; ?></textarea>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="fileUpload blue-btn btn width100">
                                                            <?php
                                                            if (isset($meeting_list[$i]['meeting_doc']) && !empty($meeting_list[$i]['meeting_doc'])) {
                                                                $truncate_doc = strlen($meeting_list[$i]['meeting_doc']) > 20 ? "..." . substr($meeting_list[$i]['meeting_doc'], -20) : $meeting_list[$i]['meeting_doc'];
                                                                ?>
                                                                <span><?= $truncate_doc; ?></span>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <span><i class="fas fa-upload"></i> Upload</span>
                                                            <?php } ?>
                                                            <input type="file" class="uploadlogo" name="meet_doc[]" id="meet_doc_<?= $j; ?>" />
                                                            <input type="hidden" name="old_meet_doc[]" id="old_meet_doc_<?= $j; ?>" value="<?php echo isset($meeting_list[$i]['meeting_doc']) ? $meeting_list[$i]['meeting_doc'] : ''; ?>" />
                                                        </div>
                                                        <?php if (isset($meeting_list[$i]['meeting_doc']) && !empty($meeting_list[$i]['meeting_doc'])) { ?>
                                                            <span class="download-btn"><a href="<?php echo base_url() . 'uploads/detailed_diligence/' . $meeting_list[$i]['meeting_doc']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                        <?php } ?>
                                                        <label class="sow_msg error" id="meet_doc_<?= $j; ?>_error"></label>
                                                    </td>
                                                </tr>
                                                <?php
                                                $j++;
                                            }
                                            ?>

                                        <?php } else { ?>
                                            <tr id="document_tr_1" class="document_more">
                                                <td></td>
                                                <td>
                                                    <input type="text" class="form-control meet_date" name="meet_date[0]" id="meet_date_1" placeholder="dd-mm-yyyy"/>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <select class="form-control form-control-sm meet_type" name="meet_type[0]" id="meet_type_1">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($meeting_type as $t) { ?>
                                                                <option value="<?php echo $t['id']; ?>"><?php echo $t['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <textarea class="form-control meet_desc" name="meet_desc[0]" id="meet_desc_1" cols="30" rows="3"></textarea>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fileUpload blue-btn btn width100">
                                                        <span><i class="fas fa-upload"></i> Upload</span>
                                                        <input type="file" class="uploadlogo" name="meet_doc[]" id="meet_doc_1" />
                                                        <input type="hidden" name="old_meet_doc[]" id="old_meet_doc_1" value="1" />
                                                    </div>
                                                    <label class="sow_msg error" id="meet_doc_1_error"></label>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
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
                            <p>you are about delete <span id="delCount"></span> selected information fields, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="enableCount" value="<?= php72_count($meeting_list); ?>">

<script type="text/javascript">
    $(document).ready(function () {
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('#master_table input[type="text"], #master_table select, textarea').attr('readonly', 'readonly');
            $('#master_table input[type="text"], input[type="file"], #master_table select, textarea').css("pointer-events", "none");
            $('#saveForm').addClass('opacity5');
            $('#saveForm').css("pointer-events", "none");
        }
        $('#deleteBtn').addClass('opacity5');
        $('#disableSave, #disableBtn').css("cursor", "not-allowed");
        $('#deleteBtn').css("pointer-events", "none");
    });

    $(document).on("focus", ".meet_date", function () {
        if ($(this).hasClass('hasDatepicker') === false) {
            $(this).datepicker({dateFormat: 'dd-mm-yy'});
        }
    });

    $(document).on("click", ".saveContinue", function (e) {
        $('#diligenceMeetings').validate();

        $(".meet_date").each(function () {
            $(this).rules("add", {required: true, messages: {required: "Select date"}});
        });

        $(".meet_type").each(function () {
            $(this).rules("add", {required: true, messages: {required: "Select type"}});
        });

        $(".meet_desc").each(function () {
            $(this).rules("add", {required: true, messages: {required: "Enter comments"}});
        });

        $('#diligenceMeetings').submit();
        e.preventDefault();
    });

    $(document).on('submit', '#diligenceMeetings', function (e) {
        var result = validateForm();
        if (result == 1) {
            return false;
        } else {
            $('.saveContinue').css('pointer-events', 'none');
            return true;
        }
    });

    function validateForm() {
        var err = 0;
        var cmnt_arr = [];
        var cmnt_dyn = document.getElementsByName("meet_doc[]").length;
        for (var r = 0; r < cmnt_dyn; r++) {
            var dyn_id = document.getElementsByName("meet_doc[]")[r].id;
            cmnt_arr.push(dyn_id);
        }

        var s = 1;
        for (var q = 0; q < cmnt_arr.length; q++) {
            var addt_desc = $('#meet_desc_' + s).val();
            var addt_oldfile = $('#old_meet_doc_' + s).val();
            var additional_doc = $('#' + cmnt_arr[q]).val();
            if (addt_desc != '' && additional_doc == '' && addt_oldfile == '1') {
                $('#' + cmnt_arr[q] + '_error').text('Upload document');
                err = 1;
            } else {
                $('#' + cmnt_arr[q] + '_error').text('');
            }
            s++;
        }

        $(".uploadlogo").each(function () {
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
        });
        return err;
    }

    $(document).on('change', '.uploadlogo', function () {
        var filename = readURL(this);
        var result = filename.split('|*|');
        $(this).parent().children('span').html(result[0]);
        if (result[1] != '1') {
            $(this).parent().parent().children('.sow_msg').show();
            $(this).parent().parent().children('.sow_msg').text(result[1]);
        } else {
            $(this).parent().parent().children('.sow_msg').text('');
            $(this).parent().parent().children('.sow_msg').hide();
        }
    });

    function readURL(input) {
        var url = input.value;
        var path, filename;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        var bsize = (input.files.length && input.files[0].size) || '';
        if (bsize != '') {
            var fsize = Math.round(bsize / 1024);
            if (fsize <= 10000) {
                if (input.files && input.files[0] && (ext == "pdf" || ext == "doc" || ext == "docx" || ext == "ppt" || ext == "pptx")) {
                    path = $(input).val();
                    filename = path.replace(/^.*\\/, "");
                    return filename + '|*|1';
                } else {
                    filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file';
                    return filename;
                }
            } else {
                filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file size';
                return filename;
            }
        }
    }

    $(document).on('click', '#addMore', function () {
        var dyn = $(".document_more").length;
        var i = parseInt(dyn) + 1;
        var data = '<tr id="document_tr_' + i + '" class="document_more"><td></td>';
        data += '<td><input type="text" class="form-control meet_date" name="meet_date[' + (i - 1) + ']" id="meet_date_' + i + '" placeholder="dd-mm-yyyy"/></td>';
        data += "<td><div class='form-group'><select class='form-control form-control-sm meet_type' name='meet_type[" + (i - 1) + "]' id='meet_type_" + i + "'><option value=''>-Select-</option><?php
                                        foreach ($meeting_type as $t) {
                                            ?> <option value='<?php echo $t['id']; ?>'><?php echo $t['name']; ?></option> <?php } ?></select></div></td>";
        data += '<td><textarea class="form-control meet_desc" name="meet_desc[' + (i - 1) + ']" id="meet_desc_' + i + '" cols="30" rows="3"></textarea></td>';
        data += '<td><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" name="meet_doc[]" id="meet_doc_' + i + '" /><input type="hidden" name="old_meet_doc[]" id="old_meet_doc_' + i + '" value="1" /></div><label class="sow_msg error" id="meet_doc_' + i + '_error"></label></td></tr>';
        $(data).insertAfter($('#document_tr_' + dyn));
        $('#saveForm').removeClass('opacity5');
        $('#saveForm').css("pointer-events", "");
    });

    $('#deleteBtn').on('click', function () {
        $('#deletemodal').modal('show');
        var sel_item = $("input:checkbox[name=check_delete]:checked").length;
        $('#delCount').html(sel_item);
    });

    $('.check_box').on('click', function () {
        if ($("#diligenceMeetings input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
            $('#deleteBtn').removeClass('opacity5');
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
            $('#deleteBtn').addClass('opacity5');
        }
    });

    $('#deleteRecord').on('click', function () {
        var deleteId = new Array();
        $("input:checkbox[name=check_delete]:checked").each(function () {
            deleteId.push($(this).val());
        });

        if ($("#diligenceMeetings input:checkbox:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deletePortfolioDetail",
                data: {
                    id: deleteId,
                    table: 'diligence_meeting'
                },
                dataType: 'json',
                success: function (msg) {
                    location.reload();
                }
            });
        }
    });

</script>

<style type="text/css">
    label.error {
        display: block !important;
        text-align: left;
    }
</style>

</body>
</html>