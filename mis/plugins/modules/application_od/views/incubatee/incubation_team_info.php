<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $team_information[0]['name_of_enterprise'] . ' - Team Info')); ?>
<?php $partner_id = $this->session->userdata('partner_id'); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $team_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $team_information[0]['name_of_enterprise'], 'app_stage' => $team_information[0]['stage'], 'program' => $team_information[0]['program'], 'doc1' => $team_information[0]['doc1'], 'doc2' => $team_information[0]['doc2'])); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team Information</a></li>
                                <?php if ($partner_id != '2') { ?>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Information About The Enterprise</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">Impact of Innovation</a></li>
                                <?php } ?>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container tab-content">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="teamForm" action="<?php echo base_url() . 'index.php/application/add_team_details'; ?>" enctype="multipart/form-data" autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <input type="hidden" name="inv_user_id" value="<?= $team_information[0]['inv_user_id']; ?>">
                                    <?php
                                    if ($partner_id == '2') {
                                        $list = '2';
                                    } else {
                                        $list = '3';
                                    }
                                    for ($i = 0; $i < $list; $i++) {
                                        $mandatory = '';
                                        if ($i == 0) {
                                            $mandatory = '<span>*</span>';
                                        }
                                        ?>
                                        <h5>Team Member <?= $i + 1; ?></h5>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Name<?= $mandatory; ?></label>
                                                    <input type="text" class="form-control fieldDisable" disabled id="team_name<?php echo $i; ?>" name="team_name[<?php echo $i; ?>]" value="<?= $team_information[$i]['mem_name']; ?> "/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Designation<?= $mandatory; ?></label>
                                                    <input type="text" class="form-control fieldDisable" disabled id="team_desg<?php echo $i; ?>" name="team_desg[<?php echo $i; ?>]" value="<?= $team_information[$i]['mem_occupation']; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Organization<?= $mandatory; ?></label>
                                                    <input type="text" class="form-control fieldDisable" disabled id="team_org<?php echo $i; ?>" name="team_org[<?php echo $i; ?>]" value="<?= $team_information[$i]['mem_org']; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Gender<?= $mandatory; ?></label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" id="tm_gender<?php echo $i; ?>" name="gender[<?php echo $i; ?>]" value="male" <?php
                                                        if ($team_information[$i]['mem_gender'] == 'male') {
                                                            echo 'checked="checked"';
                                                        }
                                                        ?> >
                                                        <label class="form-check-label" for="tm_gender<?php echo $i; ?>">Male</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" id="tf_gender<?php echo $i; ?>" name="gender[<?php echo $i; ?>]" value="female" <?php
                                                        if ($team_information[$i]['mem_gender'] == 'female') {
                                                            echo 'checked="checked"';
                                                        }
                                                        ?> >
                                                        <label class="form-check-label" for="tf_gender<?php echo $i; ?>">Female</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" id="to_gender<?php echo $i; ?>" name="gender[<?php echo $i; ?>]" value="other" <?php
                                                        if ($team_information[$i]['mem_gender'] == 'other') {
                                                            echo 'checked="checked"';
                                                        }
                                                        ?> >
                                                        <label class="form-check-label" for="to_gender<?php echo $i; ?>">Other</label>
                                                    </div>
                                                    <label for="gender[<?php echo $i; ?>]" class="error"></label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Email ID<?= $mandatory; ?></label>
                                                    <input type="text" class="form-control fieldDisable" disabled id="team_email<?php echo $i; ?>" name="team_email[<?php echo $i; ?>]" value="<?= $team_information[$i]['mem_email']; ?>" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Mobile No<?= $mandatory; ?></label>
                                                    <input type="text" class="form-control fieldDisable" disabled id="team_mob<?php echo $i; ?>" name="team_mob[<?php echo $i; ?>]"   value="<?= $team_information[$i]['mem_mobile']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group clearfix">
                                                    <label>Resume</label>
                                                    <div class="fileUpload blue-btn btn width100">
                                                        <?php
                                                        if (isset($team_information[$i]['mem_resume']) && !empty($team_information[$i]['mem_resume'])) {
                                                            $type_truncate = strlen($team_information[$i]['mem_resume']) > 20 ? "..." . substr($team_information[$i]['mem_resume'], -20) : $team_information[$i]['mem_resume'];
                                                            ?>
                                                            <span><?= $type_truncate; ?></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                        <?php } ?>
                                                        <input type="file" class="uploadlogo fieldDisable" name="mem_doc[]" id="mem_doc_<?= $j; ?>" />
                                                        <input type="hidden" name="old_mem_doc[]" id="old_mem_doc_<?= $j; ?>" value="<?php echo isset($team_information[$i]['mem_resume']) ? $team_information[$i]['mem_resume'] : ''; ?>" />
                                                    </div>
                                                    <?php if (isset($team_information[$i]['mem_resume']) && !empty($team_information[$i]['mem_resume'])) { ?>
                                                        <span class="download-btn"><a href="<?php echo host_url() . 'IncubationForm/uploads/' . $team_information[$i]['mem_resume']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                    <?php } ?>
                                                    <label class="sow_msg error" id="mem_doc_<?= $j; ?>_error"></label>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <input type="hidden" id="team_id<?php echo $i; ?>" name="team_id[<?php echo $i; ?>]" value="<?= $team_information[$i]['team_id']; ?>"/>
                                    <?php } ?>

                                    <div class="row ">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView display-hide">
                                                    <li><input type="submit" value="Save" id="saveForm" class="vital_yellow_btn wdt_100"></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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

<style type="text/css">
    /*    .fileUpload{width: 100% !important}*/
</style>

<?php $this->load->view('vitals_footer.php', array('load_application' => 'application')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('input[type="file"]').css("pointer-events", "none");
    });

    $('.summaryEdit').click(function () {
        $('input[type="file"]').css("pointer-events", "");
        $(".fieldDisable").attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').addClass("display-show");
        $('.saveLinkView').removeClass("display-hide");
    });

    $('#teamForm').validate({
        rules: {
            "team_name[0]": "required",
            "team_desg[0]": "required",
            "team_org[0]": "required",
            "gender[0]": "required",
            "team_email[0]": {
                required: true,
                email: true
            },
            "team_mob[0]": "required",
        },
        messages: {
            "team_name[0]": "Enter name",
            "team_desg[0]": "Enter designation",
            "team_org[0]": "Enter organization",
            "gender[0]": 'Select gender',
            "team_email[0]": {
                required: "Enter email id",
                email: "Enter a valid email"
            },
            "team_mob[0]": 'Enter mobile number',
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

    $(document).on('submit', '#teamForm', function (e) {
        $('#teamForm').valid();
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