
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
        $last_month = date("F", mktime(0, 0, 0, $current_month, 1));

        $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
        $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';

        $company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
        $reg_city = isset($plan_header) ? $plan_header['company_data'][0]['reg_city'] : '';
        $sector_name = isset($plan_header) ? $plan_header['sector_name'] : '';
        $this->load->view('pending_inputs/header.php', array('page_title' => 'Board Meetings', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name));
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
                                <a class="nav-item nav-link active" id="nav-incubation-tab" href="javascript:void(0)" aria-controls="nav-incubation" aria-selected="true">06</a>
                                <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/notes_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-cap" aria-selected="false">Meetings &amp; Call Notes</a>
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
                                            <h4>Diagnostic Panels &amp; Board Meetings</h4>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4  col-4 text-right">
                                            <ul class="milestone-links">
                                                <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                    <li><a class="saveContinue" href="javascript:void(0)">Save &amp; Continue</a></li>
                                                <?php } ?>
                                                <li>
                                                    <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend"><i class="far fa-question-circle"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php if (php72_count($pending_month) > 0) { ?>
                                    <div>
                                        <div class="tab-slider--nav">
                                            <label class="float-left">Pending</label>
                                            <ul class="tab-slider--tabs">
                                                <?php
                                                for ($i = 0; $i < php72_count($pending_month); $i++) {
                                                    $activeMonth = date("M", mktime(0, 0, 0, $current_month, 1));
                                                    $monthNumber = date("n", strtotime($pending_month[$i]));
                                                    if ($pending_month[$i] == $activeMonth) {
                                                        $selected = 'active';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    ?>
                                                    <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/meeting_plan/' . $innovation_id . '/' . $monthNumber; ?>">
                                                        <li class="tab-slider--trigger pending_month_btn <?= $selected; ?>"><?= date("F", strtotime($pending_month[$i])); ?></li>
                                                    </a>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="tabpanel-details pad-none config-wrapper dataconfig-content page-wrapper chiller-theme">
                                    <nav id="sidebar" data-topbar data-options="scrolltop:false" class="sidebar-wrapper top-bar">
                                        <div class="sidebar-content">
                                            <div class="sidebar-menu">
                                                <ul>
                                                    <li class="sidebar-dropdown no-arrow">
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/dp_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/sales.png'; ?>" >
                                                            <span>Diagnostic Panels</span>
                                                            <?php if ($pending_plans['plan_dp_exclam'] == 1) { ?>
                                                                <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                            <?php } ?>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-dropdown active no-arrow">
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/meeting_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/fundraise.png'; ?>" >
                                                            <span>Board Meetings</span>
                                                            <?php if ($pending_plans['plan_board_meetings_exclam'] == 1) { ?>
                                                                <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                            <?php } ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </nav>
                                    <main class="page-content">
                                        <form method="post" id="boardmeet_plan_form" name="boardmeet_plan_form" action="<?php echo base_url() . 'index.php/portfolio/pending_inputs/addboardmeetplan'; ?>" autocomplete="off" enctype="multipart/form-data">
                                            <div class="row dataconfig">
                                                <div class="col-xl-10 col-lg-10 col-md-10 col-12">
                                                    <?php
                                                    if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                                                        $next_financial = $current_financial + 1;
                                                    } else {
                                                        $next_financial = $current_financial;
                                                    }
                                                    ?>
                                                    <h4>Board Meetings > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
                                                </div>
                                                <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-12 text-right">
                                                        <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <hr class="cofig-spliter">
                                            <div class="inputplan-structure plan-structure-new">
                                                <div class="row">
                                                    <div class="col-xl-9 col-lg-9 col-md-9 col-12 vil-Deals portfolio-table">
                                                        <table class="tableresponsive input-fundtable mar-tp0">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="20%"><label>Meeting Date<small class="text-danger">*</small></label></td>
                                                                    <td width="30%">
                                                                        <ul class="milestone-links">
                                                                            <li>
                                                                                <div class="form-group">
                                                                                    <input class="form-control form-control-sm" type="text" name="meet_date" id="meet_date" value="<?php echo isset($boardmeet_plan[0]['meeting_date']) ? date('d-m-Y', strtotime($boardmeet_plan[0]['meeting_date'])) : ''; ?>">
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                    <td width="20%" class="text-right"><label>Type of Meeting<small class="text-danger">*</small></label></td>
                                                                    <td width="30%">
                                                                        <ul class="milestone-links">
                                                                            <li class="wdt-100">
                                                                                <div class="form-group">
                                                                                    <select class="form-control form-control-sm" name="type_meet" id="type_meet">
                                                                                        <option value="">select</option>
                                                                                        <option value="1" <?php
                                                                                        if (isset($boardmeet_plan[0]['meeting_type']) && $boardmeet_plan[0]['meeting_type'] == 1) {
                                                                                            echo 'selected';
                                                                                        }
                                                                                        ?>>Regular board meeting</option>
                                                                                        <option value="2" <?php
                                                                                        if (isset($boardmeet_plan[0]['meeting_type']) && $boardmeet_plan[0]['meeting_type'] == 2) {
                                                                                            echo 'selected';
                                                                                        }
                                                                                        ?>>Special board meeting</option>
                                                                                        <option value="3" <?php
                                                                                        if (isset($boardmeet_plan[0]['meeting_type']) && $boardmeet_plan[0]['meeting_type'] == 3) {
                                                                                            echo 'selected';
                                                                                        }
                                                                                        ?>>AGM</option>
                                                                                        <option value="4" <?php
                                                                                        if (isset($boardmeet_plan[0]['meeting_type']) && $boardmeet_plan[0]['meeting_type'] == 4) {
                                                                                            echo 'selected';
                                                                                        }
                                                                                        ?>>EGM</option>
                                                                                    </select>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label>Venue<small class="text-danger">*</small></label></td>
                                                                    <td>
                                                                        <ul class="milestone-links">
                                                                            <li>
                                                                                <div class="form-group">
                                                                                    <input class="form-control form-control-sm" type="text" name="venue" id="venue" value="<?php echo isset($boardmeet_plan[0]['venue']) ? $boardmeet_plan[0]['venue'] : ''; ?>">
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                    <td colspan="2">

                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-xl-9 col-lg-9 col-md-9 col-12 vil-Deals portfolio-table">
                                                        <table class="tableresponsive input-nontaptable mar-tp0">
                                                            <thead class="table-success">
                                                                <tr>
                                                                    <th colspan="3">Attendees</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><label>Board Members - External</label></td>
                                                                    <td colspan="2">
                                                                        <div >
                                                                            <input type="text" data-role="tagsinput"  placeholder="Add External Attendee Name Here" name="board_external" id="board_internal" value="<?php echo isset($boardmeet_plan[0]['external']) ? $boardmeet_plan[0]['external'] : ''; ?>">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label>Board Members - Internal</label></td>
                                                                    <td colspan="2">
                                                                        <div >
                                                                            <input type="text" data-role="tagsinput" placeholder="Add External Attendee Name Here" name="board_internal" id="board_internal" value="<?php echo isset($boardmeet_plan[0]['internal']) ? $boardmeet_plan[0]['internal'] : ''; ?>">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label>Board Observers</label></td>
                                                                    <td colspan="2">
                                                                        <div >
                                                                            <input type="text" data-role="tagsinput" placeholder="Add External Attendee Name Here" name="board_observer" id="board_observer" value="<?php echo isset($boardmeet_plan[0]['observers']) ? $boardmeet_plan[0]['observers'] : ''; ?>">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label>Other invitees</label></td>
                                                                    <td colspan="2">
                                                                        <div >
                                                                            <input type="text" data-role="tagsinput" placeholder="Add External Attendee Name Here" name="other_inviteees" id="other_invitees" value="<?php echo isset($boardmeet_plan[0]['invitees']) ? $boardmeet_plan[0]['invitees'] : ''; ?>">
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td width="20%">
                                                                        <label>Meeting minutes document</label>
                                                                    </td>
                                                                    <td width="50%">

                                                                        <div class="form-group">
                                                                            <div class="fileUpload blue-btn btn width100">
                                                                                <?php
                                                                                $document_file = isset($boardmeet_plan[0]['document']) ? $boardmeet_plan[0]['document'] : '';
                                                                                if (isset($document_file) && !empty($document_file)) {
                                                                                    echo $document_file;
                                                                                } else {
                                                                                    ?>
                                                                                    <span><i class="fas fa-upload"></i> Upload</span>
                                                                                    <input type="file" class="uploadlogo" name="document_file" id="document_file"/>
                                                                                <?php } ?>
                                                                            </div>
                                                                            <?php if (isset($document_file) && !empty($document_file)) { ?>
                                                                                <span><a href="<?php echo base_url() . 'uploads/portfolio/plan-boardmeet/' . $document_file; ?>" class="download-btn" title="Download Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                                                <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                                                    <span><a href="javascript:void(0)" id="removeDoc" title="Delete Document" class="delete-btnconfig"><i class="fas fa-trash"></i></a></span>
                                                                                <?php } ?>
                                                                                <input type="hidden" name="old_doc" value="<?php echo $document_file; ?>">
                                                                            <?php } ?>
                                                                        </div>
                                                                        <label for="document_file" class="error wdt-100m" ></label>

                                                                        <div class="col-xl-6 col-lg-6 col-md-3 col-sm-3 col-12"></div>
                                                                        <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3 col-12">
                                                                            <div id="uploadSuccess" class="msg hidden_cls success text-center">
                                                                                <strong class="text-success"><i class="fas fa-check"></i></strong>&nbsp;File has been deleted successfully
                                                                            </div>
                                                                        </div>

                                                                    </td>
                                                                    <td width="25%"></td>
                                                                </tr>
                                                                <tr id="accordion">
                                                                    <td>
                                                                        <label>Link to Drive</label>
                                                                    </td>
                                                                    <td>

                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control form-control-sm" placeholder="https://" name="link_drive" id="link_drive" value="<?php echo isset($boardmeet_plan[0]['document_link']) ? $boardmeet_plan[0]['document_link'] : '' ?>" />
                                                                        </div>
                                                                        <label for="link_drive" class="error wdt-100m" ></label>

                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                            <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                            <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                        </form>
                                    </main>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Model (Delete and select) -->
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
                                    <p>you are about delete <span id="delCount"></span> selected information fields, you
                                        can't undo this</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal"
                                                                         aria-label="Close">Cancel</a></button>
                        <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="enableCount" value="<?= php72_count($boardmeet_plan); ?>">


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/main.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/tagsinput.js'; ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

        <style>
            .fileUpload {
                width: 80%;
            }
        </style>

        <script type="text/javascript">
            $(document).ready(function () {
                var sel_month = $('#current_month').val();
                var sel_year = $('#current_year').val();
                if (sel_month < 4) {
                    sel_year = parseInt(sel_year) + 1;
                }
                var editOpt = $('#enableCount').val();
                if (editOpt > 0) {
                    $('input[type="text"],textarea, select').attr('readonly', 'readonly');
                    $('input[type="file"], select').css('pointer-events', 'none');
                } else {
                    $("#meet_date").datepicker({
                        dateFormat: "dd-mm-yy",
                        defaultDate: new Date(sel_year, sel_month - 1),
                        stepMonths: 0
                    });
                }
                $('#editBtn').addClass('opacity5');

                $('#external').tagsinput({
                    confirmKeys: [13, 44],
                    maxTags: 20
                });
                $('#internal').tagsinput({
                    confirmKeys: [13, 44],
                    maxTags: 20
                });
                $('#observers').tagsinput({
                    confirmKeys: [13, 44],
                    maxTags: 20
                });
                $('#invitees').tagsinput({
                    confirmKeys: [13, 44],
                    maxTags: 20
                });
            });

            $(document).on('click', '#editBtn', function () {
                var sel_month = $('#current_month').val();
                var sel_year = $('#current_year').val();
                if (sel_month < 4) {
                    sel_year = parseInt(sel_year) + 1;
                }
                $('input[type="text"], textarea, select').attr('readonly', false);
                $('input[type="file"], select').css('pointer-events', '');
                $('#editBtn').removeClass('opacity5');
                $("#meet_date").datepicker({
                    dateFormat: "dd-mm-yy",
                    defaultDate: new Date(sel_year, sel_month - 1),
                    stepMonths: 0
                });
            });

            $(".uploadlogo").on('change', function () {
                var filename = readURL(this);
                $(this).parent().children('span').html(filename);
            });

            $(document).on('keyup', '#venue', function () {
                if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
                    this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
                }
            });

            function readURL(input) {
                var url = input.value;
                var path, filename;
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0] && (ext == "pdf" || ext == "doc" || ext == "docx" || ext == "ppt" || ext == "pptx")) {
                    path = $(input).val();
                    filename = path.replace(/^.*\\/, "");
                    $('#boardmeet_plan_form').valid();
                    return filename;
                } else {
                    filename = '<span><i class="fas fa-upload"></i> Upload</span>';
                    $('#boardmeet_plan_form').valid();
                    return filename;
                }
            }

            $.validator.addMethod("maxfilesize", function (value, element) {
                return this.optional(element) || (element.files && element.files[0] && element.files[0].size <= 10008250);
            }, $.format('The file size cannot exceed 10MB'));

            $.validator.addMethod("extension", function (value, element, param) {
                param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
                return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
            }, "Not a valid file format");

            $('#boardmeet_plan_form').validate({
                rules: {
                    meet_date: "required",
                    venue: "required",
                    type_meet: "required",
                    document_file: {
                        extension: "pdf|ppt|pptx|doc|docx",
                        maxfilesize: true
                    },
                    link_drive: {
                        url: true
                    }
                },
                messages: {
                    meet_date: "Select date",
                    venue: "Please enter venue",
                    type_meet: "Select meeting type",
                    document_file: {
                        extension: 'Only ppt,pdf,doc files are accepted'
                    },
                    link_drive: 'Enter valid url'
                }
            });

            $(document).on('click', ".saveContinue", function (e) {
                if ($('#boardmeet_plan_form').valid()) {
                    $('.saveContinue').css('pointer-events', 'none');
                    $('#boardmeet_plan_form').submit();
                }
            });

            $('#removeDoc').on('click', function () {
                $('#deletemodal').modal('show');
            });
            $('#deleteRecord').on('click', function () {
                var invId = $('#innovation_id').val();
                var fyr = $('#current_year').val();
                var cmonth = $('#current_month').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/portfolio/deleteUploadFiles",
                    data: {
                        invId: invId,
                        year: fyr,
                        month: cmonth,
                        table: 'plan_board_meetings'
                    },
                    dataType: 'json',
                    success: function (msg) {
                        location.reload();
                    }
                });
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
        </script>
    </body>
</html>