<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $additional_information[0]['name_of_enterprise'] . ' - Additional Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $additional_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $additional_information[0]['name_of_enterprise'], 'app_stage' => $additional_information[0]['stage'], 'program' => $additional_information[0]['program'], 'doc1' => $additional_information[0]['doc1'], 'doc2' => $additional_information[0]['doc2'])); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team Information</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="additionalForm" action="<?php echo base_url() . 'index.php/application/kenya_additional_details'; ?>" enctype="multipart/form-data" autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <input type="hidden" name="inv_user_id" value="<?= $additional_information[0]['inv_user_id']; ?>">
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Brief description of your company<span>*</span></label>
                                                <textarea class="form-control fieldDisable" name="company_desc" id="company_desc" cols="30" rows="3" disabled><?= $additional_information[0]['company_description']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Where is your incubatee based?<span>*</span></label>
                                                <textarea class="form-control fieldDisable" name="inno_based" id="inno_based" cols="30" rows="3" disabled><?= $additional_information[0]['india_based']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What is innovative about your idea/incubatee?<span>*</span></label>
                                                <textarea class="form-control fieldDisable" name="inv_idea_ent" id="inv_idea_ent" cols="30" rows="3" disabled><?= $additional_information[0]['inv_idea_ent']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4" id="multiple_about">
                                            <div class="form-group">
                                                <label>How did you hear about Villgro Kenya<span>*</span></label>
                                                <?php $hear_abt = explode(",", $additional_information[0]['hear_abt']); ?>
                                                <select class="form-control fieldDisable" id="abt_vill" disabled multiple="multiple" name="abt_vill[]" onchange="about_value();">
                                                    <option value="Referral" <?php if (in_array('Referral', $hear_abt)) echo "selected"; ?>>Referral</option>
                                                    <option value="Online" <?php if (in_array('Online', $hear_abt)) echo "selected"; ?>>Online</option>
                                                    <option value="Newspaper" <?php if (in_array('Newspaper', $hear_abt)) echo "selected"; ?>>Newspaper</option>
                                                    <option value="Past incubatee" <?php if (in_array('Past incubatee', $hear_abt)) echo "selected"; ?>>Past incubatee</option>
                                                    <option value="Villgro staff" <?php if (in_array('Villgro staff', $hear_abt)) echo "selected"; ?>>Villgro staff</option>
                                                    <option value="Other" <?php if (in_array('Other', $hear_abt)) echo "selected"; ?>>Other</option>
                                                </select>
                                            </div>
                                            <div id="about_err"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4" id="multiple_support">
                                            <div class="form-group">
                                                <label>Please indicate the relevant sectors of your business<span>*</span></label>
                                                <?php $sectors = explode(",", $additional_information[0]['ent_sector']); ?>
                                                <select class="form-control fieldDisable" id="sector" disabled multiple="multiple" name="sector[]" onchange="support_value();">
                                                    <option value="Agri-business" <?php if (in_array('Agri-business', $sectors)) echo "selected"; ?>>Agri-business</option>
                                                    <option value="Healthcare" <?php if (in_array('Healthcare', $sectors)) echo "selected"; ?>>Healthcare</option>
                                                    <option value="ICT" <?php if (in_array('ICT', $sectors)) echo "selected"; ?>>ICT</option>
                                                    <option value="Cosmetics and wellness" <?php if (in_array('Cosmetics and wellness', $sectors)) echo "selected"; ?>>Cosmetics and wellness</option>
                                                    <option value="Ergonomics" <?php if (in_array('Ergonomics', $sectors)) echo "selected"; ?>>Ergonomics</option>
                                                    <option value="Automation/mechanization of agriculture" <?php if (in_array('Automation/mechanization of agriculture', $sectors)) echo "selected"; ?>>Automation/mechanization of agriculture</option>
                                                    <option value="Pest control" <?php if (in_array('Pest control', $sectors)) echo "selected"; ?>>Pest control</option>
                                                    <option value="Post harvest technologies" <?php if (in_array('Post harvest technologies', $sectors)) echo "selected"; ?>>Post harvest technologies</option>
                                                    <option value="Industrial application of biotechnology" <?php if (in_array('Industrial application of biotechnology', $sectors)) echo "selected"; ?>>Industrial application of biotechnology</option>
                                                    <option value="Green/environmental friendly technologies" <?php if (in_array('Green/environmental friendly technologies', $sectors)) echo "selected"; ?>>Green/environmental friendly technologies</option>
                                                    <option value="MCH" <?php if (in_array('MCH', $sectors)) echo "selected"; ?>>Maternal and Child Health</option>
                                                    <option value="Water and Sanitation" <?php if (in_array('Water and Sanitation', $sectors)) echo "selected"; ?>>Water and Sanitation</option>
                                                    <option value="Waste management" <?php if (in_array('Waste management', $sectors)) echo "selected"; ?>>Waste management</option>
                                                    <option value="Medical Devices" <?php if (in_array('Medical Devices', $sectors)) echo "selected"; ?>>Medical Devices</option>
                                                    <option value="Diagnostics" <?php if (in_array('Diagnostics', $sectors)) echo "selected"; ?>>Diagnostics</option>
                                                    <option value="Drugs" <?php if (in_array('Drugs', $sectors)) echo "selected"; ?>>Drugs</option>
                                                    <option value="Vaccines" <?php if (in_array('Vaccines', $sectors)) echo "selected"; ?>>Vaccines</option>
                                                    <option value="eHealth Technologies" <?php if (in_array('eHealth Technologies', $sectors)) echo "selected"; ?>>eHealth Technologies</option>
                                                    <option value="mHealth Technologies" <?php if (in_array('mHealth Technologies', $sectors)) echo "selected"; ?>>mHealth Technologies</option>
                                                    <option value="Sanitation / Environmental Health" <?php if (in_array('Sanitation / Environmental Health', $sectors)) echo "selected"; ?>>Sanitation / Environmental Health</option>
                                                    <option value="Epidemiology" <?php if (in_array('Epidemiology', $sectors)) echo "selected"; ?>>Epidemiology</option>
                                                    <option value="Public Health Tools" <?php if (in_array('Public Health Tools', $sectors)) echo "selected"; ?>>Public Health Tools</option>
                                                    <option value="Vector Control" <?php if (in_array('Vector Control', $sectors)) echo "selected"; ?>>Vector Control</option>
                                                    <option value="Biotechnology" <?php if (in_array('Biotechnology', $sectors)) echo "selected"; ?>>Biotechnology</option>
                                                    <option value="Pharmaceuticals" <?php if (in_array('Pharmaceuticals', $sectors)) echo "selected"; ?>>Pharmaceuticals</option>
                                                    <option value="Plant health" <?php if (in_array('Plant health', $sectors)) echo "selected"; ?>>Plant health</option>
                                                    <option value="Animal health" <?php if (in_array('Animal health', $sectors)) echo "selected"; ?>>Animal health</option>
                                                    <option value="Nutrition" <?php if (in_array('Nutrition', $sectors)) echo "selected"; ?>>Nutrition</option>
                                                    <option value="Others" <?php if (in_array('Others', $sectors)) echo "selected"; ?>>Others</option>
                                                </select>
                                            </div>
                                            <div id="support_err"></div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4" id="multiple_about">
                                            <div class="form-group">
                                                <label>If other please specify</label>
                                                <input type="text" disabled name="sector_other" class="form-control fieldDisable" value="<?php echo isset($additional_information[0]['sector_others']) && $additional_information[0]['sector_others'] != '0' ? $additional_information[0]['sector_others'] : ''; ?>"/>
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
        $('#sector, #abt_vill').multiselect({
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
            $("#support_err").html('<label for="sector" class="error">Select type</label>');
        }
        if (about_len == 'Select an Option') {
            $("#additionalForm").valid();
            e.preventDefault();
            $("#about_err").html('<label for="abt_vill" class="error">Select type</label>');
        }
    });

    function support_value() {
        var myArray = [];
        $('#sector option:selected').each(function () {
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