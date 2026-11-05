<?php
$company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
$quater_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_quarter = $this->Mportfolio->monthByQuarters();
$get_quarter_fieldName = array("Q1" => 'q_one_desc', "Q2" => 'q_two_desc', "Q3" => 'q_three_desc', "Q4" => 'q_four_desc');
$get_quarter_monthField = array("1" => 'jan_desc', "2" => 'feb_desc', "3" => 'mar_desc', "4" => 'apr_desc', "5" => 'may_desc', "6" => 'jun_desc', "7" => 'jul_desc', "8" => 'aug_desc', "9" => 'sep_desc', "10" => 'oct_desc', "11" => 'nov_desc', "12" => 'dec_desc');

$last_month = date("F", mktime(0, 0, 0, $current_month, 1));
$reg_city = isset($plan_header) ? $plan_header['company_data'][0]['reg_city'] : '';
$sector_name = isset($plan_header) ? $plan_header['sector_name'] : '';
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Achievement', 'company_name' => $company_name, 'port_action' => 'actual', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'fin_year' => $current_financial, 'add_class' => 'mar-tp150'));
?>
<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill newIncubatesTabs" id="nav-tab" role="tablist">
                        <div class="new-nav-changes">
                            <div class="new-changes-head"> &nbsp</div>

                            <a class="nav-item nav-link  " id="nav-Companymaster-tab"   href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-Companymaster" aria-selected="true" style="margin-right: 15px;position: relative;">Updates</a>
                        </div>
                        <div class="new-nav-changes1"><div class="new-changes-head1"> Portfolio Information</div>
                            <a class="nav-item nav-link" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/product/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="false">Product &amp; Sales</a>
                            <a class="nav-item nav-link" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/finance/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Finance &amp; Fundraise</a>
                            <a class="nav-item nav-link" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/hiring/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Team &amp; Board Meetings</a>
                            <a class="nav-item nav-link" id="nav-governance-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/impact/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-governance" aria-selected="false">Impact</a>
                            <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/milestone/' . $innovation_id . '/' . $current_financial; ?>" aria-controls="nav-cap" aria-selected="false">Milestone Tracker</a>
                        </div>
                        <div class="new-nav-changes2"><div class="new-changes-head2"> Incubator Services/Interventions</div>
                            <a class="nav-item nav-link" id="nav-relationship-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/mentor/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-relationship" aria-selected="false" style="margin-left: 15px;">Mentors &amp; Partnerships </a>
                            <a class="nav-item nav-link active" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/dp/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-incubation" aria-selected="true">08</a>
                            <a class="nav-item nav-link" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/vif_funding/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-incubation" aria-selected="true">Seed Funding</a>
                            <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/notes/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-cap" aria-selected="false">Meetings &amp; Calls</a>

                        </div>
                    </div>

                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-Companymaster" role="tabpanel" aria-labelledby="nav-Companymaster-tab">
                        <div class="tabpanel-title">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                    <h4>Diagnostic Panels</h4>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                                    <ul class="milestone-links">
                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                            <li><a class="saveContinue">Save &amp; Continue</a></li>
                                        <?php } ?>
                                        <li>
                                            <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend" style="font-size: 15px !important;text-decoration: underline;"><i class="far fa-question-circle"></i>&nbsp;M&E SOP - Click here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tabpanel-details pad-none config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('all_forms/left_menu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'dp', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
                            </div>
                            <main class="page-content">
                                <div class="row dataconfig">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad0">
                                        <?php
                                        $get_Qval = $actual_quarter[$current_month];
                                        if ($get_Qval == 'Q4') {
                                            $get_end_year = $this->Mportfolio->getFYtoYear($this->session->userdata('partner_id'), $current_financial);
                                            $next_financial = $get_end_year[0]['fin_to_year'];
                                        } else {
                                            $next_financial = $current_financial;
                                        }
                                        ?>
                                        <h4>Diagnostic Panels > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                        <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                    </div>
                                </div>
                                <?php
                                $current_quarter = $actual_quarter[$current_month];
                                $total_qualPlan = $get_quarter_fieldName[$current_quarter];
                                $monthly_qualPlan = $get_quarter_monthField[$current_month];
                                ?>
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <form method="post" id="dp_plan_form" name="dp_plan_form" action="<?php echo base_url() . 'index.php/portfolio/all_forms/adddpplan'; ?>" autocomplete="off" enctype="multipart/form-data">
                                                <div class="inputplan-structureall plan-structure-new">
                                                    
                                                    <div class="row">
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-12 vil-Deals portfolio-table">
                                                            <table class="tableresponsive input-fundtable mar-tp0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="40%"><label>Purpose of the meeting <small class="text-danger">*</small></label></td>
                                                                        <td width="60%">
                                                                            <div class="form-group">
                                                                                <textarea class="form-control form-control-sm" name="purpose_meet" id="purpose_meet" maxlength="1000" row="3"><?php echo isset($dp_plan[0]['purpose']) ? $dp_plan[0]['purpose'] : ''; ?></textarea>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-12 vil-Deals portfolio-table">
                                                            <table class="tableresponsive input-nontaptable mar-tp0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="40%"><label>Meeting Date <small class="text-danger">*</small></label></td>
                                                                        <td width="22%">
                                                                            <ul class="milestone-links">
                                                                                <li class="pad-lf0">
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm" name="meet_date" id="meet_date" type="text" placeholder="dd-mm-yyyy" value="<?php echo isset($dp_plan[0]['meeting_date']) && $dp_plan[0]['meeting_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($dp_plan[0]['meeting_date'])) : ''; ?>">
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                        <td width="23%" class="text-right"><label>Location / City <small class="text-danger">*</small></label></td>
                                                                        <td width="25%">
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-sm" name="location" id="location" maxlength="100" type="text" value="<?php echo isset($dp_plan[0]['location']) ? $dp_plan[0]['location'] : ''; ?>">
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td width="40%"><label>Name of the external Attendee <small class="text-danger">*</small></label></td>
                                                                        <td colspan="3">
                                                                            <div>
                                                                                <input type="text" data-role="tagsinput" placeholder="Add External Attendee Name Here" name="external_attd" id="external_attd" value="<?php echo isset($dp_plan[0]['external_attendees']) ? $dp_plan[0]['external_attendees'] : ''; ?>">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <label>Meeting minutes document </label>
                                                                        </td>
                                                                        <td colspan="2">

                                                                            <div class="form-group">
                                                                                <div class="fileUpload blue-btn btn width100">
                                                                                    <?php
                                                                                    $document_file = isset($dp_plan[0]['document']) ? $dp_plan[0]['document'] : '';
                                                                                    if (isset($document_file) && !empty($document_file)) {
                                                                                        echo $document_file;
                                                                                    } else {
                                                                                        ?>
                                                                                        <span><i class="fas fa-upload"></i> Upload</span>
                                                                                        <input type="file" class="uploadlogo" name="document_file" id="document_file" />
                                                                                    <?php } ?>
                                                                                </div>
                                                                                <?php if (isset($document_file) && !empty($document_file)) { ?>
                                                                                    <span><a href="<?php echo base_url() . 'uploads/portfolio/plan-dpplan/' . $document_file; ?>" class="download-btn" title="Download Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                                                    <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                                        <span><a href="javascript:void(0)" id="removeDoc" title="Delete Document" class="delete-btnconfig"><i class="fas fa-trash"></i></a></span>
                                                                                    <?php } ?>
                                                                                    <input type="hidden" name="old_doc" value="<?php echo $document_file; ?>">
                                                                                <?php } ?>
                                                                            </div>
                                                                            <label for="document_file" class="error wdt-100m" ></label>

                                                                            <div class="col-xl-6 col-lg-6 col-md-3 col-sm-3 col-12"></div>
                                                                            <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3 col-12">
                                                                                <div id="uploadSuccess" class="msg hidden_cls success text-center"><strong
                                                                                        class="text-success"><i class="fas fa-check"></i></strong>&nbsp;File
                                                                                    has been deleted successfully</div>
                                                                            </div>

                                                                        </td>

                                                                    </tr>
                                                                    <tr id="accordion">
                                                                        <td>
                                                                            <label>Link to Drive</label>
                                                                        </td>
                                                                        <td colspan="2">
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control form-control-sm" name="link_drive" id="link_drive" placeholder="https://" alt="" value="<?php echo isset($dp_plan[0]['document_link']) ? $dp_plan[0]['document_link'] : ''; ?>" />
                                                                            </div>
                                                                            <label for="link_drive" class="error wdt-100m" ></label>
                                                                        </td>

                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
													
													 <hr><br><br>
													<div class="row achievementNewComt">
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <p>Plan for <?= $current_quarter; ?></p>
                                                            <div class="form-group quaterlyCardnew fieldDisabled">
                                                                <textarea rows="3" disabled class="mceEditor" id="quarterDesc" name="quarterDesc"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_plan[0][$total_qualPlan])); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <p>Plan for <?= $last_month; ?></p>
                                                            <div class="form-group quaterlyCardnew fieldDisabled">
                                                                <textarea rows="3" class="mceEditor" id="monthContent" name='monthContent'><?= stripslashes(str_replace("\\r\\n", '', $qualitative_plan[0][$monthly_qualPlan])); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <p>Enter achievement for <?= $last_month; ?></p>
                                                            <div class="form-group quaterlyCardnew" id="achieveField">
                                                                <textarea rows="3" class="mceEditorActive" id="achieveContent" name='achieveContent' autofocus><?= stripslashes(str_replace("\\r\\n", '', $dp_plan[0]['achievement_desc'])); ?></textarea>
                                                            </div>
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
                            </main>
                        </div>
                    </div>
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

<input type="hidden" id="enableCount" value="<?= php72_count($dp_plan); ?>">

<style type="text/css">
    .fileUpload {
        width: 80%;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio', 'quantitative' => 'tiny')); ?>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/tagsinput.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/typeahead.bundle.min.js'; ?>"></script>

<script type="text/javascript">
    $(window).on("load", function () {
        $('svg').attr("viewBox", "0 0 25 25");
        $('svg').css({"width": "20", "height": "20"});
    });

    tinyMCE.init({
        mode: "specific_textareas",
        editor_selector: "mceEditor",
        entity_encoding: "numeric",
        menubar: false,
        readonly: 1,
        toolbar: [
            ''
        ],
        valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li,br',
        powerpaste_word_import: 'clean',
        powerpaste_html_import: 'clean'
    });

    tinyMCE.init({
        mode: "specific_textareas",
        editor_selector: "mceEditorActive",
        entity_encoding: "numeric",
        menubar: false,
        //auto_focus: "achieveContent",
        plugins: [
            'lists'
        ],
        toolbar: [
            'bold italic | numlist bullist'
        ],
        valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li,br',
        powerpaste_word_import: 'clean',
        powerpaste_html_import: 'clean'
    });

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
            tinymce.get('achieveContent').setMode('readonly');
            $('#achieveField').addClass('fieldDisabled');
        } else {
            $('#achieveField').addClass('greenplantxt');
            $("#meet_date").datepicker({
                dateFormat: "dd-mm-yy",
                defaultDate: new Date(sel_year, sel_month - 1),
                stepMonths: 0
            });
        }
        $('#editBtn').addClass('opacity5');

        $('#financial_year').attr('readonly', false);
        $('#financial_year').css("pointer-events", "");

        $('#external_attd').tagsinput({
            confirmKeys: [13, 44],
            maxTags: 20
        });
    });

    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/all_forms/dp/' + inv_id + '/' + year;
    }

    $(document).on('click', '#editBtn', function () {
        var sel_month = $('#current_month').val();
        var sel_year = $('#current_year').val();
        if (sel_month < 4) {
            sel_year = parseInt(sel_year) + 1;
        }
        $('input[type="text"], textarea, select').attr('readonly', false);
        $('input[type="file"], select').css('pointer-events', '');
        $('#editBtn').removeClass('opacity5');
        tinymce.get('achieveContent').setMode('design');
        $('#achieveField').addClass('greenplantxt');
        $('#achieveField').removeClass('fieldDisabled');
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

    $(document).on('keyup', 'textarea', function () {
        if (this.value.match(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g, '');
        }
    });

    $(document).on('keyup', '#location', function () {
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
            $('#dp_plan_form').valid();
            return filename;
        } else {
            filename = '<span><i class="fas fa-upload"></i> Upload</span>';
            $('#dp_plan_form').valid();
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

    $('#dp_plan_form').validate({
        rules: {
            purpose_meet: {
                required: function (element) {
                    return ($("#purpose_meet").val() != "" || $("#meet_date").val() != "" || $("#location").val() != "" || $("#external_attd").val() != "");
                }
            },
            meet_date: {
                required: function (element) {
                    return ($("#purpose_meet").val() != "" || $("#meet_date").val() != "" || $("#location").val() != "" || $("#external_attd").val() != "");
                }
            },
            location: {
                required: function (element) {
                    return ($("#purpose_meet").val() != "" || $("#meet_date").val() != "" || $("#location").val() != "" || $("#external_attd").val() != "");
                }
            },
            external_attd: {
                required: function (element) {
                    return ($("#purpose_meet").val() != "" || $("#meet_date").val() != "" || $("#location").val() != "" || $("#external_attd").val() != "");
                }
            },
            document_file: {
                extension: "pdf|ppt|pptx|doc|docx",
                maxfilesize: true
            },
            link_drive: {
                url: true
            }
        },
        messages: {
            purpose_meet: "Please enter purpose",
            meet_date: "Select date",
            location: "Please enter location",
            external_attd: "Please enter attendee",
            document_file: {
                extension: 'Only ppt,pdf,doc files are accepted'
            },
            link_drive: 'Enter valid url'
        }
    });

    $(document).on('click', ".saveContinue", function (e) {
        if ($('#dp_plan_form').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#dp_plan_form').submit();
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
                table: 'plan_dp'
            },
            dataType: 'json',
            success: function (msg) {
                location.reload();
            }
        });
    });
    $('.plan-structure-new').css({'height': (($(window).height()) - 380) + 'px'});
</script>

</body>
</html>
