<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => 'Detailed Assessment - ' . $innovation['name_of_enterprise'])); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'diligence_company', 'inv_stage' => $innovation['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content vital_windowScroll">
                <?php $this->load->view('detailed_diligence/diligence_options.php', array('application_id' => $application_id, 'title' => 'Management Team', 'inv_id' => $inv_id_format, 'stage' => $stage_name, 'status' => $status_name, 'incharge' => $assign_incharge, 'enterprise_name' => $innovation['name_of_enterprise'], 'sector' => $sector[0]['sector'], 'sub_sector' => $subsector, 'assign_to' => $assign_to, 'eic_date' => $eic_date)); ?>

                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/diligence_company_data/' . $application_id; ?>">Company Master Data</a></li>
                                <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/application/diligence_management_team/' . $application_id; ?>">Management Team</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/diligence_cap_table/' . $application_id; ?>">Cap Table</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container ">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="table_configcontentnew pad-bt0">
                                <div class="tabpanel-title">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9"></div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                            <ul class="milestone-links">
                                                <?php if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || in_array($this->session->userdata('emp_number'), $assign_incharge_id)) { ?>
                                                    <li class="brd-left-onboard" id="disableSave"><a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a></li>
                                                    <li class="brd-left-onboard" id="disableBtn"><a href="javascript:void(0)" class="deleteControl" id="deleteBtn"><i class="fas fa-trash-alt"></i> Delete</a></li>
                                                    <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue" id="saveForm">Save</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form method="post" id="diligenceManagement" action="<?php echo base_url() . 'index.php/application/save_diligence_management'; ?>" class="form" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" name='inv_id' value="<?= $application_id; ?>" />
                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                    <table class="table table-hover dt-responsive" id="master_table">
                                        <thead>
                                            <tr>
                                                <th width="4%"></th>
                                                <th width="16%">Founder(s) / Mgmt Names<span class="text-danger">*</span></th>
                                                <th width="16%">Mobile</th>
                                                <th width="16%">Email ID</th>
                                                <th width="16%">Location</th>
                                                <th width="16%">Desig., resp.</th>
                                                <th width="16%">Profile/ resume</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $j = 1;
                                            if (count($teamData) > 0) {
                                                for ($i = 0; $i < count($teamData); $i++) {
                                                    ?>
                                                <input type="hidden" name="memberId[<?= $i; ?>]" id="memberId_<?= $j; ?>" value="<?php echo $teamData[$i]['id']; ?>"/>
                                                <tr id="mgmt_tr_<?php echo $j; ?>" class="mgmt_more">
                                                    <td class="align-middle">
                                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                            <div class="input-group">
                                                                <input type="checkbox" class="check_box" aria-label="Checkbox for following text input"
                                                                       name="check_delete" id="check_delete_<?php echo $j; ?>" value="<?php echo $teamData[$i]['id']; ?>">
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="name[<?= $i; ?>]" id="name_<?= $j; ?>" class="form-control mgmt_name" placeholder="Enter name" value="<?php echo $teamData[$i]['name']; ?>"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="mobile[<?= $i; ?>]" id="mobile_<?= $j; ?>" class="form-control" placeholder="Enter mobile" value="<?php echo $teamData[$i]['mobile']; ?>"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="email[<?= $i; ?>]" id="email_<?= $j; ?>" class="form-control" placeholder="Enter email" value="<?php echo $teamData[$i]['email']; ?>"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="location[<?= $i; ?>]" id="location_<?= $j; ?>" class="form-control" placeholder="Enter location" value="<?php echo $teamData[$i]['location']; ?>"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="design[<?= $i; ?>]" id="design_<?= $j; ?>" class="form-control" placeholder="Enter design" value="<?php echo $teamData[$i]['design']; ?>"/>
                                                    </td>
                                                    <td>
                                                        <div class="fileUpload blue-btn btn width100">
                                                            <?php
                                                            if (isset($teamData[$i]['resume']) && !empty($teamData[$i]['resume'])) {
                                                                $truncate_doc = strlen($teamData[$i]['resume']) > 20 ? "..." . substr($teamData[$i]['resume'], -20) : $teamData[$i]['resume'];
                                                                ?>
                                                                <span><?= $truncate_doc; ?></span>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <span><i class="fas fa-upload"></i> Upload</span>
                                                            <?php } ?>
                                                            <input type="file" class="uploadlogo" name="resume[]" id="resume_<?= $j; ?>" />
                                                            <input type="hidden" name="old_resume[]" id="old_resume_<?= $j; ?>" value="<?php echo isset($teamData[$i]['resume']) ? $teamData[$i]['resume'] : ''; ?>" />
                                                        </div>
                                                        <?php if (isset($teamData[$i]['resume']) && !empty($teamData[$i]['resume'])) { ?>
                                                            <span class="download-btn"><a href="<?php echo base_url() . 'uploads/detailed_diligence/' . $teamData[$i]['resume']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                        <?php } ?>
                                                        <label class="sow_msg error" id="resume_<?= $j; ?>_error"></label>
                                                    </td>
                                                </tr>
                                                <?php
                                                $j++;
                                            }
                                            ?>

                                        <?php } else { ?>
                                            <tr id="mgmt_tr_1" class="mgmt_more">
                                                <td></td>
                                                <td>
                                                    <input type="text" class="form-control mgmt_name" name="name[0]" id="name_1" placeholder="Enter name"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="mobile[0]" id="mobile_1" placeholder="Enter mobile"/>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="email[0]" id="email_1" placeholder="Enter email"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="location[0]" id="location_1" placeholder="Enter location"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="design[0]" id="design_1" placeholder="Enter designation"/>
                                                </td>
                                                <td>
                                                    <div class="fileUpload blue-btn btn width100">
                                                        <span><i class="fas fa-upload"></i> Upload</span>
                                                        <input type="file" class="uploadlogo" name="resume[]" id="resume_1" />
                                                        <input type="hidden" name="old_resume_doc[]" id="old_resume_doc_1" value="1" />
                                                    </div>
                                                    <label class="sow_msg error" id="resume_1_error"></label>
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

<input type="hidden" id="enableCount" value="<?= count($teamData); ?>">

<script type="text/javascript">
    $(document).ready(function () {
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('#master_table input[type="text"]').attr('readonly', 'readonly');
            // $('#saveForm').addClass('opacity5');
            // $('#saveForm').css("pointer-events", "none");
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
        $('#diligenceManagement').validate();

        $(".mgmt_name").each(function () {
            $(this).rules("add", {required: true, messages: {required: "Enter name"}});
        });

        $('#diligenceManagement').submit();
        e.preventDefault();
    });

    $(document).on('submit', '#diligenceManagement', function (e) {
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
        var cmnt_dyn = document.getElementsByName("resume[]").length;
        for (var r = 0; r < cmnt_dyn; r++) {
            var dyn_id = document.getElementsByName("resume[]")[r].id;
            cmnt_arr.push(dyn_id);
        }

        var s = 1;
        for (var q = 0; q < cmnt_arr.length; q++) {
            var addt_desc = $('#meet_desc_' + s).val();
            var addt_oldfile = $('#old_resume_' + s).val();
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
        var dyn = $(".mgmt_more").length;
        var i = parseInt(dyn) + 1;
        var data = '<tr id="mgmt_tr_' + i + '" class="mgmt_more"><td></td>';
        data += '<td><input type="text" class="form-control mgmt_name" name="name[' + (i - 1) + ']" id="name_' + i + '" placeholder="Enter name"/></td>';
        data += '<td><input type="text" class="form-control" name="mobile[' + (i - 1) + ']" id="mobile_' + i + '" placeholder="Enter mobile"/></td>';
        data += '<td><input type="text" class="form-control" name="email[' + (i - 1) + ']" id="email_' + i + '" placeholder="Enter email"/></td>';
        data += '<td><input type="text" class="form-control" name="location[' + (i - 1) + ']" id="location_' + i + '" placeholder="Enter location"/></td>';
        data += '<td><input type="text" class="form-control" name="design[' + (i - 1) + ']" id="design_' + i + '" placeholder="Enter designation"/></td>';
        data += '<td><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" name="resume[]" id="resume_' + i + '" /><input type="hidden" name="old_resume_doc[]" id="old_resume_doc_' + i + '" value="1" /></div><label class="sow_msg error" id="resume_' + i + '_error"></label></td></tr>';
        $(data).insertAfter($('#mgmt_tr_' + dyn));
        $('#saveForm').removeClass('opacity5');
        $('#saveForm').css("pointer-events", "");
    });

    $('#deleteBtn').on('click', function () {
        $('#deletemodal').modal('show');
        var sel_item = $("input:checkbox[name=check_delete]:checked").length;
        $('#delCount').html(sel_item);
    });

    $('.check_box').on('click', function () {
        if ($("#diligenceManagement input:checkbox:checked").length > 0) {
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

        if ($("#diligenceManagement input:checkbox:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deletePortfolioDetail",
                data: {
                    id: deleteId,
                    table: 'management_team'
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
