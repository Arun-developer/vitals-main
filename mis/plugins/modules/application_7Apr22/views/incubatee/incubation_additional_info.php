<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $additional_information[0]['name_of_enterprise'] . ' - Additional Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $additional_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $additional_information[0]['name_of_enterprise'], 'app_stage' => $additional_information[0]['stage'], 'program' => $additional_information[0]['program'], 'doc1' => $additional_information[0]['doc1'], 'doc2' => $additional_information[0]['doc2'], 'doc3' => $additional_information[0]['doc3'])); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Information About The Enterprise</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">Impact of Innovation</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="additionalForm" action="<?php echo base_url() . 'index.php/application/add_additional_details'; ?>" enctype="multipart/form-data" autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <input type="hidden" name="inv_user_id" value="<?= $additional_information[0]['inv_user_id']; ?>">
                                    <div class="text-right">
                                        <span class="clr-red">*</span>Supports only doc,docx,ppt,pptx,pdf files
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group clearfix">
                                                <label>Business plan (if available)</label>
                                                <div class="fileUpload blue-btn btn width100">
                                                    <?php
                                                    if (isset($additional_information[0]['doc1']) && !empty($additional_information[0]['doc1'])) {
                                                        $business_truncate = strlen($additional_information[0]['doc1']) > 20 ? "..." . substr($additional_information[0]['doc1'], -20) : $additional_information[0]['doc1'];
                                                        ?>
                                                        <span><?= $business_truncate; ?></span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span><i class="fas fa-upload"></i> Upload</span>
                                                    <?php } ?>
                                                    <input type="file" class="uploadlogo" name="business_file" id="business_file" />
                                                    <input type="hidden" name="old_business_file" id="old_business_file" value="<?php echo isset($additional_information[0]['doc1']) ? $additional_information[0]['doc1'] : ''; ?>" />
                                                </div>
                                                <?php if (isset($additional_information[0]['doc1']) && !empty($additional_information[0]['doc1'])) { ?>
                                                    <span class="download-btn"><a href="<?php echo host_url() . 'IncubationForm/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                <?php } ?>
                                                <label class="sow_msg error" id="business_file_error"></label>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Additional Information</label>
                                                <div class="fileUpload clearfix blue-btn btn width100">
                                                    <?php
                                                    if (isset($additional_information[0]['doc2']) && !empty($additional_information[0]['doc2'])) {
                                                        $info_truncate = strlen($additional_information[0]['doc2']) > 20 ? "..." . substr($additional_information[0]['doc2'], -20) : $additional_information[0]['doc2'];
                                                        ?>
                                                        <span><?= $info_truncate; ?></span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span><i class="fas fa-upload"></i> Upload</span>
                                                    <?php } ?>
                                                    <input type="file" class="uploadlogo" name="info_file" id="info_file" />
                                                    <input type="hidden" name="old_info_file" id="old_info_file" value="<?php echo isset($additional_information[0]['doc2']) ? $additional_information[0]['doc2'] : ''; ?>" />
                                                </div>
                                                <?php if (isset($additional_information[0]['doc2']) && !empty($additional_information[0]['doc2'])) { ?>
                                                    <span class="download-btn"><a href="<?php echo host_url() . 'IncubationForm/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                <?php } ?>
                                                <label class="sow_msg error" id="info_file_error"></label>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4" id="multiple_support">
                                            <div class="form-group">
                                                <label>Please indicate the support you would like from us<span>*</span></label>
                                                <?php $vill_support = explode(",", $additional_information[0]['from_villgro']); ?>
                                                <select class="form-control fieldDisable" id="vill_support" disabled multiple="multiple" name="vill_support[]" onchange="support_value();">
                                                    <option value="Board formation" <?php if (in_array('Board formation', $vill_support)) echo "selected"; ?>>Board formation</option>
                                                    <option value="Capacity building" <?php if (in_array('Capacity building', $vill_support)) echo "selected"; ?>>Capacity building</option>
                                                    <option value="Funding" <?php if (in_array('Funding', $vill_support)) echo "selected"; ?>>Funding</option>
                                                    <option value="Mentoring" <?php if (in_array('Mentoring', $vill_support)) echo "selected"; ?>>Mentoring</option>
                                                    <option value="Networks" <?php if (in_array('Networks', $vill_support)) echo "selected"; ?>>Networks</option>
                                                    <option value="Other" <?php if (in_array('Other', $vill_support)) echo "selected"; ?>>Other</option>
                                                    <option value="Talent" <?php if (in_array('Talent', $vill_support)) echo "selected"; ?>>Talent</option>
                                                    <option value="Technology transfer" <?php if (in_array('Technology transfer', $vill_support)) echo "selected"; ?>>Technology transfer</option>
                                                    <option value="Training" <?php if (in_array('Training', $vill_support)) echo "selected"; ?>>Training</option>
                                                </select>
                                            </div>
                                            <div id="support_err"></div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4" id="multiple_about">
                                            <div class="form-group">
                                                <label>How did you hear about our program<span>*</span></label>
                                                <?php $hear_abt = explode(",", $additional_information[0]['hear_abt']); ?>
                                                <select class="form-control fieldDisable" id="abt_vill" disabled multiple="multiple" name="abt_vill[]" onchange="about_value();">
                                                    <option value="Referral" <?php if (in_array('Referral', $hear_abt)) echo "selected"; ?>>Referral</option>
                                                    <option value="Online" <?php if (in_array('Online', $hear_abt)) echo "selected"; ?>>Online</option>
                                                    <option value="Newspaper" <?php if (in_array('Newspaper', $hear_abt)) echo "selected"; ?>>Newspaper</option>
                                                    <option value="Past incubatee" <?php if (in_array('Past incubatee', $hear_abt)) echo "selected"; ?>>Past incubatee</option>
                                                    <option value="Our staff" <?php if (in_array('Our staff', $hear_abt)) echo "selected"; ?>>Villgro staff</option>
                                                    <option value="Other" <?php if (in_array('Other', $hear_abt)) echo "selected"; ?>>Other</option>
                                                </select>
                                            </div>
                                            <div id="about_err"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group clearfix" id="villgro_other">
                                                <label>Please Mention Support<span>*</span></label>
                                                <input type="text" disabled name="otr_support" class="form-control fieldDisable" value="<?php echo $additional_information[0]['support_name']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group" id="about_other">
                                                <label>Please Mention Name<span>*</span></label>
                                                <input type="text" disabled name="ref_name" class="form-control fieldDisable" value="<?php echo $additional_information[0]['referal_name']; ?>"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView display-hide">
                                                    <li><input type="submit" value="Save" id="saveForm" class="vital_yellow_btn wdt_100"></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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


<?php $this->load->view('vitals_footer.php', array('load_application' => 'application', 'multi_select' => 'multiselect')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#vill_support, #abt_vill').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });

        support_value();
        about_value();
    });

    $(document).on('click', '#saveForm', function (e) {
        var support_len = $('#multiple_support .multiselect-selected-text').html();
        var about_len = $('#multiple_about .multiselect-selected-text').html();
        $("#support_err, #about_err").html('');
        if (support_len == 'Select an Option') {
            $("#additionalForm").valid();
            e.preventDefault();
            $("#support_err").html('<label for="vill_support" class="error">Select type</label>');
        }
        if (about_len == 'Select an Option') {
            $("#additionalForm").valid();
            e.preventDefault();
            $("#about_err").html('<label for="abt_vill" class="error">Select type</label>');
        }
    });

    function support_value() {
        var myArray = [];
        $('#vill_support option:selected').each(function () {
            myArray.push($(this).val());
        });

        if ($.inArray("Other", myArray) !== -1) {
            $('#villgro_other').show();
        } else {
            $('#villgro_other').hide();
        }
    }

    function about_value() {
        var myArray = [];
        $('#abt_vill option:selected').each(function () {
            myArray.push($(this).val());
        });
        if ($.inArray("Other", myArray) !== -1) {
            $('#about_other').show();
        } else {
            $('#about_other').hide();
        }
    }

    $(document).ready(function () {
        $('input[type="file"]').css("pointer-events", "none");
    });

    $('.summaryEdit').click(function () {
        $('input[type="file"]').css("pointer-events", "");
        $(".fieldDisable").attr("disabled", false);
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').addClass("display-show");
        $('.saveLinkView').removeClass("display-hide");
    });

    $('#additionalForm').validate({
        rules: {
            "otr_support": "required",
            "ref_name": "required",
        },
        messages: {
            "otr_support": "Enter name",
            "ref_name": "Enter name",
        }
    });

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

    $(document).on('submit', '#additionalForm', function (e) {
        $('#additionalForm').valid();
        var result = validateForm();
        if (result == 1) {
            return false;
        } else {
            $('#saveForm').css('pointer-events', 'none');
            return true;
        }
    });

    function validateForm() {
        var err = 0;

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
</script>

</body>
</html>