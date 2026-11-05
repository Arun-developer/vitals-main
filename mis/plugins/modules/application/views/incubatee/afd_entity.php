<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $enterprise_information[0]['name_of_enterprise'] . ' - Enterprise Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $enterprise_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $enterprise_information[0]['name_of_enterprise'], 'app_stage' => $enterprise_information[0]['stage'], 'program' => $enterprise_information[0]['program'], 'doc1' => $enterprise_information[0]['doc1'], 'doc2' => $enterprise_information[0]['doc2'])); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team Information</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Information About The Enterprise</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">Impact of Innovation</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane userActiveSetupNew active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="enterpriseForm" action="<?php echo base_url() . 'index.php/application/add_enterprise_details'; ?>" autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <input type="hidden" name="inv_user_id" value="<?= $enterprise_information[0]['inv_user_id']; ?>">
                                    <h5>Entity Details</h5>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Type of Organisation</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $enterprise_information[0]['in_operation']; ?> "/>
                                            </div>
                                        </div>
                                        <?php if ($enterprise_information[0]['in_operation'] == 'For profit') { ?>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>DPIIT Recognition Number</label>
                                                    <input type="text" class="form-control fieldDisable" disabled value="<?= $enterprise_information[0]['reco_no']; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Corporate Identity Number</label>
                                                    <input type="text" class="form-control fieldDisable" disabled value="<?= $enterprise_information[0]['cin']; ?>"/>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Please elaborate on the collaboration with a French entity</label>
                                                    <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['inv_desc']; ?></textarea>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php $register_date = isset($enterprise_information[0]['org_reg_date']) && $enterprise_information[0]['org_reg_date'] != '0000-00-00 00:00:00' ? date('d-M-y', strtotime($enterprise_information[0]['org_reg_date'])) : ''; ?>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Date of registration of your organisation</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $register_date; ?> "/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Website URL</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $enterprise_information[0]['website_url']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Social media links</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $enterprise_information[0]['social_media']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Focus Area</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $enterprise_information[0]['type_prod']; ?> "/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>PAN Number</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $enterprise_information[0]['pan']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>State</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $enterprise_information[0]['state_name']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $enterprise_information[0]['city']; ?> "/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Pin code</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $enterprise_information[0]['pincode']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['address']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Short description of your organisation</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['org_short_desc']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <h5>Preferences</h5>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Have you participated in the Swachh Technology Challenge, by MOHUA in the past?</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $enterprise_information[0]['tech_challege']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Why are you applying for this Swachhata Startup Challenge?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['startup_challenge']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What are you most interested in learning more about?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['vill_support']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>If Other please specify</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $enterprise_information[0]['support_name']; ?>"/>
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

<?php $this->load->view('vitals_footer.php', array('load_application' => 'application')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        get_userLists();
        $('.leaveLabel').css("cursor", "not-allowed");
        $('.leaveLabel').css("pointer-events", "none");

    });

    function show_org(value) {
        if (value == 'Yes') {
            $("#other_org").css('display', 'block');
        } else {
            $("#other_org").css('display', 'none');
        }
    }

    function show_compet(value) {
        if (value == 'Yes') {
            $("#bus_compet").css('display', 'block');
        } else {
            $("#bus_compet").css('display', 'none');
        }
    }

    $('.summaryEdit').click(function () {
        $(".fieldDisable").attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').addClass("display-show");
        $('.saveLinkView').removeClass("display-hide");
        $('.leaveLabel').css("cursor", "pointer");
        $('.leaveLabel').css("pointer-events", "");
    });

    function get_userLists() {
        var inv_user_id = "<?= $enterprise_information[0]['inv_user_id']; ?>";
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('application/load_state_list'); ?>",
            data: {'inv_user_id': inv_user_id},
            success: function (response) {
                var options = '';
                if (response.all_states == '' && response.ext_state == null) {
                    options = '<option value=""> Select </option>';
                    $("#select_state").html('');
                } else if (response.all_states != '' || response.ext_state != null) {
                    '<option value="">Select </option>';
                    for (var i = 0; i < response.all_states.length; i++) {
                        options += '<option value="' + response.all_states[i].id + '">' + response.all_states[i].state_name + '</option>';
                    }
                    $("#select_state").html(options);
                    if (response.ext_state != null) {
                        for (var i = 0; i < response.all_states.length; i++) {
                            if ($.inArray(response.all_states[i].id, response.ext_state.user_state) != -1) {
                                $("#select_state").find("option[value=" + response.all_states[i].id + "]").prop("selected", "selected");
                            }
                        }
                    }
                }
            }
        });
    }

    $(document).on('click', '#saveForm', function (e) {
        var myArray = [];
        $("#select_state option:selected").each(function () {
            myArray.push($(this).val());
        });

        $("#state_err").html('');
        if (myArray.length == 0) {
            $("#enterpriseForm").valid();
            e.preventDefault();
            $("#state_err").html('<label for="select_state" class="error">Select state</label>');
        }

    });

    $('#enterpriseForm').validate({
        rules: {
            "in_operation": "required",
            "with_other_org": "required",
            "competition": "required",
            "other_org_name": {
                required: function (element) {
                    return $("#with_other_org").val() == "Yes";
                }
            },
            "business_compet": {
                required: function (element) {
                    return $("#competition").val() == "Yes";
                }
            }
        },
        messages: {
            "in_operation": "Select type",
            "with_other_org": "Select type",
            "competition": "Select type",
            "other_org_name": 'Enter organization',
            "business_compet": 'Enter plan'
        }
    });

</script>

<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.toaster.js'; ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.toast').toast('show');
    });
</script>

</body>
</html>