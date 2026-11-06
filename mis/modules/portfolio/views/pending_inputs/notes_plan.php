<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Villgro MIS</title>
    </head>

    <body>
        <?php
        $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
        $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';

        $plan_data = $note_plan[0];
        $note_count = isset($plan_data) ? php72_count($note_plan) : 1;

        $company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
        $reg_city = isset($plan_header) ? $plan_header['company_data'][0]['reg_city'] : '';
        $sector_name = isset($plan_header) ? $plan_header['sector_name'] : '';
        $this->load->view('pending_inputs/header.php', array('page_title' => 'Call Notes Plan', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name));
        ?>

        <!-- Inner Dashboard-->
        <div class="vi-dashboard onboardtabmenu mar-tp150">
            <?php if ($successMsg != '') { ?>
                <div class="msg success text-center"><strong class="text-success"><i class="fas fa-check"></i></strong>&nbsp;<?= $successMsg; ?></div>
                <?php
            }
            if ($errorMsg != '') {
                ?>
                <div class="msg error text-center"><strong><i class="fas fa-times"></i></strong>&nbsp;<?= $errorMsg; ?></div>
            <?php } ?>
            <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Record(s) deleted successfully</div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/plan_updates/' . $innovation_id . '/' . $current_month; ?>" role="tab" aria-controls="nav-Companymaster" aria-selected="true">Updates</a>
                                <a class="nav-item nav-link filled-data" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/sales_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="false">Sales &amp; Pipeline</a>
                                <a class="nav-item nav-link filled-data" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/finance_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Finance &amp; Fundraise</a>
                                <a class="nav-item nav-link filled-data" id="nav-governance-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/impact_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-governance" aria-selected="false">Impact</a>
                                <a class="nav-item nav-link filled-data" id="nav-relationship-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/hiring_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-relationship" aria-selected="false">Team, TAP &amp; Mentors</a>
                                <a class="nav-item nav-link filled-data" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/dp_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-incubation" aria-selected="true">Diagnostic Panels &amp; Board Meetings</a>
                                <a class="nav-item nav-link active" id="nav-cap-tab" href="" aria-controls="nav-cap" aria-selected="false">07</a>
                                <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/milestone_plan/' . $innovation_id; ?>" aria-controls="nav-cap" aria-selected="false">Milestone Tracker</a>
                                <a class="nav-item nav-link brd-none bg-trasnparent" id="nav-about-tab"  href="#nav-about"  aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                                <a class="nav-item nav-link dataconfig_btn" id="nav-dataconfig-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id; ?>" role="tab" aria-controls="nav-dataconfig" aria-selected="false">View all forms</a>
                            </div>
                        </nav>
                        <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-Companymaster" role="tabpanel" aria-labelledby="nav-Companymaster-tab">
                                <div class="tabpanel-title">
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                            <h4>Meetings &amp; Call Notes</h4>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                                            <ul class="milestone-links">
                                                <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || php72_cmp($this->session->userdata['sector_lead']) == 1) { ?>
                                                    <li><a class="saveContinue">Save &amp; Continue</a></li>
                                                <?php } ?>
                                                <li>
                                                    <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend"><i class="far fa-question-circle"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabpanel-details pad-none config-wrapper dataconfig-content page-wrapper chiller-theme">
                                    <nav id="sidebar" data-topbar data-options="scrolltop:false" class="sidebar-wrapper top-bar">
                                        <div class="sidebar-content">
                                            <div class="sidebar-menu">
                                                <ul>
                                                    <li class="sidebar-dropdown no-arrow">
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/notes_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/sales.png'; ?>" >
                                                            <span>Meetings &amp; Call Notes</span>
                                                            <?php if (php72_cmp($pending_plans['plan_notes_exclam']) == 1) { ?>
                                                                <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                            <?php } ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </nav>
                                    <main class="page-content">
                                        <div class="row dataconfig">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <h4>Meetings &amp; Call Notes</h4>
                                            </div>
                                            <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || php72_cmp($this->session->userdata['sector_lead']) == 1) { ?>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                    <ul class="milestone-links">
                                                        <li><a href="javascript:void(0)" class="edit-btnconfig editBtn" id="addMore"><i class="fas fa-plus-circle"></i> Add New</a></li>
                                                        <li><a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                                        <li class="brd-left-onboard" id="disableBtn"><a class="edit-btnconfig editBtn" href="javascript:void(0)" id="deleteBtn"><i class="fas fa-trash"></i> Delete</a>
                                                    </ul>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <hr class="cofig-spliter">
                                        <div class="inputplan-structure plan-structure-new">
                                            <form method="post" id="notesPlanForm" action="<?php echo base_url() . 'index.php/portfolio/pending_inputs/addNotesPlan'; ?>" autocomplete="off" enctype="multipart/form-data">
                                                <input type='hidden' name='innovation_id' id="innovationId" value="<?= $innovation_id; ?>">
                                                <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>
                                                       ">
                                                <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                <div class="input-viftable">
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 vil-Deals portfolio-table">
                                                            <div class="table_configcontentnew">
                                                                <table class="table" id="accordion">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width:3%;"></th>
                                                                            <th style="width:15%;">Date<span class="text-danger">*</span></th>
                                                                            <th style="width:22%;">Meeting Type<span class="text-danger">*</span></th>
                                                                            <th style="width:30%;">Comments<span class="text-danger">*</span><br>
                                                                            <th style="width:30%;">Minutes Doc <small>(Max 10MB size of ppt, pdf, doc files)</small></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="add_more_notes">
                                                                        <?php
                                                                        $j = 1;
                                                                        for ($i = 0; $i < $note_count; $i++) {
                                                                            $start_date = (isset($note_plan[$i]['meeting_date']) && $note_plan[$i]['meeting_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($note_plan[$i]['meeting_date'])) : '';
                                                                            ?>
                                                                            <tr id="notes_tr_<?= $j; ?>" class="notes_more">
                                                                                <td style="width:3%;">
                                                                                    <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                                                        <input type="checkbox" class="check_box" aria-label="Checkbox for following text input" name="check_delete" id="check_delete_<?= $j; ?>" value="<?= $note_plan[$i]['id']; ?>">
                                                                                    <?php } ?>
                                                                                </td>
                                                                                <td style="width:15%;">
                                                                                    <div class="form-group">
                                                                                        <input type="text" class="form-control form-control-sm startDat dateCalendar" placeholder="dd-mm-yyyy" name="start_date[]" id="startDate_<?= $j; ?>" value="<?php echo $start_date; ?>">
                                                                                    </div>
                                                                                    <p class="error" id="start_date_<?= $j; ?>_error"></p>
                                                                                </td>
                                                                                <td style="width:22%;">
                                                                                    <div class="form-group">
                                                                                        <select class="form-control form-control-sm mentorDiv" name="m_name[]" id="meet_name_<?php echo $j; ?>">
                                                                                            <option value="">-Select-</option>
                                                                                            <?php
                                                                                            foreach ($meeting_type as $m) {
                                                                                                if ($m['id'] == $note_plan[$i]['meeting_type']) {
                                                                                                    $selected = 'selected';
                                                                                                } else {
                                                                                                    $selected = '';
                                                                                                }
                                                                                                ?>
                                                                                                <option value="<?php echo $m['id']; ?>" <?= $selected; ?> ><?php echo $m['name']; ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <p class="error" id="meet_name_<?= $j; ?>_error"></p>
                                                                                </td>
                                                                                <td style="width:30%;">
                                                                                    <div class="form-group">
                                                                                        <textarea class="form-control" name="cmnt_desc[]" id="cmnt_desc_<?= $j; ?>" rows="2" onKeyUp="limitText(this.form.cmnt_desc_<?= $j; ?>, this.form.countdown_desc, 1000);"><?= $note_plan[$i]['description']; ?></textarea>
                                                                                    </div>
                                                                                    <p class="error" id="cmnt_desc_<?= $j; ?>_error"></p>
                                                                                </td>
                                                                                <td style="width:30%;">
                                                                                    <div class="fileUpload blue-btn btn wdt80">
                                                                                        <?php
                                                                                        if (isset($note_plan[$i]['document']) && !empty($note_plan[$i]['document'])) {
                                                                                            echo strlen($note_plan[$i]['document']) > 20 ? "..." . substr($note_plan[$i]['document'], -20) : $note_plan[$i]['document'];
                                                                                        } else {
                                                                                            ?>
                                                                                            <span><i class="fas fa-upload"></i>Upload</span>
                                                                                        <?php } ?>
                                                                                        <input type="file" class="uploadlogo" name="sow_doc[]" id="upLogo_<?= $j; ?>" />
                                                                                    </div>
                                                                                    <p class="sow_msg error" id="sow_doc_<?= $j; ?>_error"></p>

                                                                                    <?php if (isset($note_plan[$i]['document']) && !empty($note_plan[$i]['document'])) { ?>
                                                                                        <span class="download-btn"><a href="<?php echo base_url() . 'uploads/detailed_diligence/' . $note_plan[$i]['document']; ?>" title="Download Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                                                            <span><a href="javascript:void(0)" title="Delete Document" class="removeDoc desc_one_delete delete-btnconfig" onclick="delNotes('<?= $note_plan[$i]['id']; ?>')"><i class="fas fa-trash"></i></a></span>
                                                                                        <?php } ?>
                                                                                    <?php } ?>
                                                                                    <input type="hidden" name="old_sow_doc[]" id="old_sow_doc<?= $j; ?>" value="<?php echo $note_plan[$i]['document']; ?>">
                                                                                </td>
                                                                        <input type="hidden" name="id[]" value="<?= $note_plan[$i]['id']; ?>">
                                                                        </tr>
                                                                        <?php
                                                                        $j++;
                                                                    }
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </main>
                                </div>
                            </div>
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
                    <div class="modal-footer"><input type="hidden" name="dltDoc" id="dltDoc" />
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="enableCount" value="<?= php72_count($note_plan); ?>">

        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/additional-methods.js"></script>

        <script type="text/javascript">

                                                                                                $(document).ready(function () {
                                                                                                    onLoad();
                                                                                                });

                                                                                                function onLoad() {
                                                                                                    var editOpt = $('#enableCount').val();
                                                                                                    if (editOpt > 0) {
                                                                                                        $('input[type="text"], textarea, select').attr('readonly', 'readonly');
                                                                                                        $('input[type="file"], select').css("pointer-events", "none");
                                                                                                    } else {
                                                                                                        datepickerEachFunction();
                                                                                                    }
                                                                                                    $('#editBtn').addClass('opacity5');
                                                                                                    $('#disableBtn').css("cursor", "not-allowed");
                                                                                                    $('#deleteBtn').css("pointer-events", "none");
                                                                                                }

                                                                                                $(document).on('click', '#editBtn', function () {
                                                                                                    $('input[type="text"], textarea, select').attr('readonly', false);
                                                                                                    $('input[type="file"], select').css("pointer-events", "visible");
                                                                                                    $('.readOnly').attr('readonly', true);
                                                                                                    $('#editBtn').removeClass('opacity5');
                                                                                                    datepickerEachFunction();
                                                                                                });

                                                                                                $(document).on('click', '#addMore', function () {
                                                                                                    var dyn = $(".notes_more").length;
                                                                                                    var i = parseInt(dyn) + 1;
                                                                                                    var datas = '<tr id="notes_tr_' + i + '" class="notes_more"><td width="3%"><input type="checkbox" class="check_box" aria-label="Checkbox for following text input" name="check_delete" id="check_delete_' + i + '" value=""></td>';
                                                                                                    datas += '<td width="15%"><div class="form-group"><input type="text" class="form-control form-control-sm startDat dateCalendar" placeholder="dd-mm-yyyy" name="start_date[]" id="startDate_' + i + '" value=""></div><p class="error" id="start_date_' + i + '_error"></p></td>';
                                                                                                    datas += '<td width="22%"><div class="form-group"><select class="form-control form-control-sm name mentorDiv" name="m_name[]" id="meet_name_' + i + '"><option value="">-Select-</option><?php
                                                                    foreach ($meeting_type as $m) {
                                                                        ?> <option value="<?php echo $m['id']; ?>" <?= $selected; ?> ><?php echo htmlentities($m['name'], ENT_QUOTES); ?></option> <?php } ?></select></div><p class="error" id="meet_name_' + i + '_error"></p></td>';
                                                                                                    datas += '<td width="30%"><div class="form-group"><textarea class="form-control form-control-sm cmnt_desc" name="cmnt_desc[]" onKeyUp="limitText(this.form.cmnt_desc_' + i + ', this.form.countdown_desc, 1000);" value="" id="cmnt_desc_' + i + '"></textarea></div><p class="error" id="cmnt_desc_' + i + '_error"></p></td>';
                                                                                                    datas += '<td width="30%"><div class="fileUpload blue-btn btn wdt80"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" id="upLogo_' + i + '" name="sow_doc[]" /></div><p class="sow_msg error" id="sow_doc_' + i + '_error"></p><i class="fas fa-minus-circle mar-lf10 cursor" title="Remove" onclick="removeAddMore(' + i + ')"></i><input type="hidden" name="old_sow_doc[]" id="old_sow_doc' + i + '" class="uploadlogo" value=""></td></tr>';
                                                                                                    $(datas).insertAfter($('#notes_tr_' + dyn));
                                                                                                    datepickerEachFunction();
                                                                                                });

                                                                                                function removeAddMore(id) {
                                                                                                    $('#notes_tr_' + id).remove();
                                                                                                }

                                                                                                function datepickerEachFunction() {
                                                                                                    $('.startDat').each(function (index, value) {
                                                                                                        var index_val = index + 1;
                                                                                                        $("#startDate_" + index_val).datepicker({
                                                                                                            onSelect: function (selected) {
                                                                                                                $("#startDate_" + index_val).datepicker("option", "dateFormat", 'mm/dd/yy');
                                                                                                                var dt = new Date(selected);
                                                                                                                var dateval = dt.getDate();
                                                                                                                var monthval = dt.getMonth() + 1;
                                                                                                                var yearval = dt.getFullYear();
                                                                                                                if (monthval < 10) {
                                                                                                                    monthval = "0" + monthval;
                                                                                                                } else {
                                                                                                                    monthval = monthval;
                                                                                                                }
                                                                                                                if (dateval < 10) {
                                                                                                                    dateval = "0" + dateval;
                                                                                                                } else {
                                                                                                                    dateval = dateval;
                                                                                                                }
                                                                                                                var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
                                                                                                                $("#startDate_" + index_val).val(fulldatevalue);
                                                                                                            }
                                                                                                        });
                                                                                                    });
                                                                                                }

                                                                                                $(document).on('change', '.uploadlogo', function () {
                                                                                                    $('#notesPlanForm').valid();
                                                                                                    var get_id = $(this).attr('id');
                                                                                                    var filename = readURL(this);
                                                                                                    var reslt = filename.split('|*|');
                                                                                                    $(this).parent().children('span').html(reslt[0]);
                                                                                                    if (reslt[1] != '1') {
                                                                                                        $('#' + get_id).val('');
                                                                                                        $(this).parent().parent().children('.sow_msg').show();
                                                                                                        $(this).parent().parent().children('.sow_msg').text(reslt[1]);
                                                                                                    } else {
                                                                                                        $(this).parent().parent().children('.sow_msg').text('');
                                                                                                        $(this).parent().parent().children('.sow_msg').hide();
                                                                                                    }
                                                                                                });

                                                                                                function uploadFile() {
                                                                                                    $(".uploadlogo").on('change', function () {
                                                                                                        var get_id = $(this).attr('id');
                                                                                                        var filename = readURL(this);
                                                                                                        var reslt = filename.split('|*|');
                                                                                                        $(this).parent().children('span').html(reslt[0]);
                                                                                                        if (reslt[1] != '1') {
                                                                                                            $('#' + get_id).val('');
                                                                                                            $(this).parent().parent().children('.sow_msg').show();
                                                                                                            $(this).parent().parent().children('.sow_msg').text(reslt[1]);
                                                                                                        } else {
                                                                                                            $(this).parent().parent().children('.sow_msg').text('');
                                                                                                            $(this).parent().parent().children('.sow_msg').hide();
                                                                                                        }
                                                                                                    });
                                                                                                }

                                                                                                function readURL(input) {
                                                                                                    var url = input.value;
                                                                                                    var path, filename;
                                                                                                    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                                                                                                    var bsize = input.files[0].size;
                                                                                                    var fsize = Math.round(bsize / 1024);
//                                                                                                    if (fsize <= 10000) {
                                                                                                    if (bsize <= 10008250) {
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

                                                                                                function fieldValidate() {
                                                                                                    var tr_count = $('.notes_more').length;
                                                                                                    var err = 0;
                                                                                                    var s = 1;

                                                                                                    for (var q = 0; q < tr_count; q++) {
                                                                                                        var call_date = $('#startDate_' + s).val();
                                                                                                        var call_type = $('#meet_name_' + s).val();
                                                                                                        var call_desc = $('#cmnt_desc_' + s).val();
                                                                                                        var call_doc = $('#upLogo_' + s).val();
                                                                                                        var old_doc = $('#old_sow_doc' + s).val();

                                                                                                        if (call_date == '') {
                                                                                                            $('#start_date_' + s + '_error').text('Select date');
                                                                                                            err = 1;
                                                                                                        } else {
                                                                                                            $('#start_date_' + s + '_error').text('');
                                                                                                        }

                                                                                                        if (call_type == '') {
                                                                                                            $('#meet_name_' + s + '_error').text('Select meeting type');
                                                                                                            err = 1;
                                                                                                        } else {
                                                                                                            $('#meet_name_' + s + '_error').text('');
                                                                                                        }

                                                                                                        if (call_desc == '') {
                                                                                                            $('#cmnt_desc_' + s + '_error').text('Enter description');
                                                                                                            err = 1;
                                                                                                        } else {
                                                                                                            $('#cmnt_desc_' + s + '_error').text('');
                                                                                                        }

//                                                                                            if (call_doc == '' && old_doc == '') {
//                                                                                                $('#sow_doc_' + s + '_error').text('Upload document');
//                                                                                                err = 1;
//                                                                                            } else {
//                                                                                                $('#sow_doc_' + s + '_error').text('');
//                                                                                            }

                                                                                                        s++;
                                                                                                    }
                                                                                                    return err;
                                                                                                }

                                                                                                $(document).on('click', ".saveContinue", function (e) {
                                                                                                    fieldValidate();
                                                                                                    $('#notesPlanForm').submit();
                                                                                                    e.preventDefault();
                                                                                                });

                                                                                                $(document).on('submit', '#notesPlanForm', function (e) {
                                                                                                    $('#notesPlanForm').valid();
                                                                                                    var result = fieldValidate();
                                                                                                    if (result == 1) {
                                                                                                        return false;
                                                                                                    } else {
                                                                                                        $('.saveContinue').css('pointer-events', 'none');
                                                                                                        return true;
                                                                                                    }
                                                                                                });

                                                                                                function delNotes(mtrid) {
                                                                                                    $('#deletemodal').modal('show');
                                                                                                    $('#dltDoc').val(mtrid);
                                                                                                }

                                                                                                $('#deleteBtn').on('click', function () {
                                                                                                    $('#deletemodal').modal('show');
                                                                                                    var sel_item = $("input:checkbox[name=check_delete]:checked").length;
                                                                                                    $('#delCount').html(sel_item);
                                                                                                });

                                                                                                $('.check_box').on('click', function () {
                                                                                                    if ($("#notesPlanForm input:checkbox:checked").length > 0) {
                                                                                                        $('#disableBtn').css("cursor", "pointer");
                                                                                                        $('#deleteBtn').css("pointer-events", "");
                                                                                                    } else {
                                                                                                        $('#disableBtn').css("cursor", "not-allowed");
                                                                                                        $('#deleteBtn').css("pointer-events", "none");
                                                                                                    }
                                                                                                });

                                                                                                function deleteMore() {
                                                                                                    $('.check_box').on('click', function () {
                                                                                                        if ($("#notesPlanForm input:checkbox:checked").length > 0) {
                                                                                                            $('#disableBtn').css("cursor", "pointer");
                                                                                                            $('#deleteBtn').css("pointer-events", "");
                                                                                                        } else {
                                                                                                            $('#disableBtn').css("cursor", "not-allowed");
                                                                                                            $('#deleteBtn').css("pointer-events", "none");
                                                                                                        }
                                                                                                    });
                                                                                                }

                                                                                                $('#deleteRecord').on('click', function () {
                                                                                                    var dltDoc = $('#dltDoc').val();
                                                                                                    var editOpt = $('#enableCount').val();

                                                                                                    if (dltDoc != '') {
                                                                                                        var invId = $('#innovationId').val();
                                                                                                        $.ajax({
                                                                                                            type: "POST",
                                                                                                            url: "<?php echo base_url(); ?>index.php/portfolio/deleteUploadFiles",
                                                                                                            data: {
                                                                                                                invId: invId,
                                                                                                                note_id: dltDoc,
                                                                                                                table: 'plan_meeting_notes'
                                                                                                            },
                                                                                                            dataType: 'json',
                                                                                                            success: function (msg) {
                                                                                                                $('#accordion').load(location.href + ' #accordion');
                                                                                                                $('#dltDoc').val('');
                                                                                                                $('#deletemodal').modal('hide');
                                                                                                                $('#uploadSuccess').show();
                                                                                                                setTimeout(function () {
                                                                                                                    if (editOpt > 0) {
                                                                                                                        onLoad();
                                                                                                                    }
                                                                                                                    uploadFile();
                                                                                                                    deleteMore();
                                                                                                                }, 500);
                                                                                                            }
                                                                                                        });
                                                                                                    } else {
                                                                                                        var deleteId = new Array();
                                                                                                        $("input:checkbox[name=check_delete]:checked").each(function () {
                                                                                                            deleteId.push($(this).val());
                                                                                                        });

                                                                                                        if ($("#notesPlanForm input:checkbox:checked").length > 0) {
                                                                                                            $.ajax({
                                                                                                                type: "POST",
                                                                                                                url: "<?php echo base_url(); ?>index.php/portfolio/deletePortfolioDetail",
                                                                                                                data: {
                                                                                                                    id: deleteId,
                                                                                                                    table: 'plan_meeting_notes'
                                                                                                                },
                                                                                                                dataType: 'json',
                                                                                                                success: function (msg) {
                                                                                                                    $('#accordion').load(location.href + ' #accordion');
                                                                                                                    $('#deletemodal').modal('hide');
                                                                                                                    $('#deleteMsg').show();
                                                                                                                    setTimeout(function () {
                                                                                                                        console.log(editOpt);
                                                                                                                        if (editOpt > 0) {
                                                                                                                            onLoad();
                                                                                                                        }
                                                                                                                        deleteMore();
                                                                                                                    }, 1000);
                                                                                                                    setTimeout(function () {
                                                                                                                        $('#deleteMsg').hide();
                                                                                                                    }, 3000);
                                                                                                                }
                                                                                                            });
                                                                                                        }
                                                                                                    }
                                                                                                });

                                                                                                $('.plan-structure-new').css({'height': (($(window).height()) - 240) + 'px'});

                                                                                                $(function () {
                                                                                                    var $form = $('form');
                                                                                                    var initialState = $form.serialize();
                                                                                                    $(document).on('click', '.pending_month_btn', function (e) {
                                                                                                        if (initialState === $form.serialize()) {
                                                                                                            return(true);
                                                                                                        } else {
                                                                                                            if (confirm("Changes made in form are not saved. \nDo you want to continue without save?")) {
                                                                                                                return(true);
                                                                                                            } else {
                                                                                                                return(false);
                                                                                                            }
                                                                                                        }
                                                                                                    });
                                                                                                });

                                                                                                function limitText(limitField, limitCount, limitNum) {
                                                                                                    var wordcount = limitField.value.trim().split(" ");
                                                                                                    var wordcountlength;
                                                                                                    if (limitField.value.trim() == "")
                                                                                                        wordcountlength = 0;
                                                                                                    else
                                                                                                        wordcountlength = wordcount.length;
                                                                                                    var parse_limit = parseInt(limitNum);

                                                                                                    if (wordcountlength >= parse_limit) {
                                                                                                        resultArray = wordcount.slice(0, parse_limit);
                                                                                                        limitField.value = resultArray.join(" ");
                                                                                                        limitCount.value = 0;
                                                                                                        return false;
                                                                                                    } else {
                                                                                                        limitCount.value = parse_limit - wordcountlength;
                                                                                                    }
                                                                                                }

        </script>
        <style>
            i.fas.fa-minus-circle{
                color:#ffae42;
            }
        </style>
    </body>
</html>