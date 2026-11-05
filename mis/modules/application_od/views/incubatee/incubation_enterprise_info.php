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
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>How long have you been in operation<span>*</span></label>
                                                <?php $operation_val = $enterprise_information[0]['in_operation']; ?>
                                                <select class="form-control fieldDisable" disabled id="in_operation" name="in_operation">
                                                    <option value="">--Select--</option>
                                                    <option value="0to6" <?php
                                                    if ($enterprise_information[0]['in_operation'] == '0to6') {
                                                        echo 'selected';
                                                    }
                                                    ?>>0 – 6 months</option>
                                                    <option value="6to12" <?php
                                                    if ($enterprise_information[0]['in_operation'] == '6to12') {
                                                        echo 'selected';
                                                    }
                                                    ?>>6 – 12 months</option>
                                                    <option value="1" <?php
                                                    if ($enterprise_information[0]['in_operation'] == '1') {
                                                        echo 'selected';
                                                    }
                                                    ?>>1 year </option>
                                                    <option value="2" <?php
                                                    if ($enterprise_information[0]['in_operation'] == '2') {
                                                        echo 'selected';
                                                    }
                                                    ?>>2 years </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6 leaveLabel">
                                            <div class="form-group">
                                                <label>In which states are you operating / plan to operate<span>*</span></label>
                                                <?php
                                                if ($enterprise_information[0]['operate_on_state'] != '') {
                                                    $states = explode(',', $enterprise_information[0]['operate_on_state']);
                                                    $state_list = '';
                                                    foreach ($states as $state) {
                                                        if ($state_list != '')
                                                            $state_list = $state_list . ', ' . $this->Minnovation->getStateName($state);
                                                        else
                                                            $state_list = $this->Minnovation->getStateName($state);
                                                    }
                                                }
                                                ?>
                                                <select id="select_state" class="multiselect" multiple="multiple" name="select_state[]" ></select>
                                                <!--<select class="form-control" multiple name="select_state[]" id="select_state" ></select>-->
                                            </div>
                                            <div id="state_err"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Have you been incubated, funded or participated in an accelerator program with another organization?<span>*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input fieldDisable" disabled type="radio" name="with_other_org" id="with_other_org1" value="Yes" <?php if ($enterprise_information[0]['ant_org'] == 'Yes') echo "checked=checked"; ?>  onclick="show_org(this.value);">
                                                    <label class="form-check-label" for="with_other_org1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input fieldDisable" disabled type="radio" name="with_other_org" id="with_other_org2" value="No" <?php if ($enterprise_information[0]['ant_org'] == 'No') echo "checked=checked"; ?>  onclick="show_org(this.value);">
                                                    <label class="form-check-label" for="with_other_org2">No</label>
                                                </div>
                                                <label for="with_other_org" class="error"></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Have you participated in or won any business plan competitions?<span>*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input fieldDisable" disabled type="radio" name="competition" id="competition1" value="Yes" <?php if ($enterprise_information[0]['won_competition'] == 'Yes') echo "checked=checked"; ?> onclick="show_compet(this.value);">
                                                    <label class="form-check-label" for="competition1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input fieldDisable" disabled type="radio" name="competition" id="competition2" value="No" <?php if ($enterprise_information[0]['won_competition'] == 'No') echo "checked=checked"; ?> onclick="show_compet(this.value);">
                                                    <label class="form-check-label" for="competition2">No</label>
                                                </div>
                                                <label for="competition" class="error"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $org_display_field = 'style="display:none"';
                                    $com_display_field = 'style="display:none"';
                                    if ($enterprise_information[0]['ant_org'] == 'Yes') {
                                        $org_display_field = 'style="display:block"';
                                    }
                                    if ($enterprise_information[0]['won_competition'] == 'Yes') {
                                        $com_display_field = 'style="display:block"';
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group" id="other_org" <?= $org_display_field; ?>>
                                                <label>Name of organization(s)<span>*</span></label>
                                                <input type="text" disabled name="other_org_name" class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['ant_org_name']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group" id="bus_compet" <?= $com_display_field; ?>>
                                                <label>Name of business plan competition(s)<span>*</span></label>
                                                <input type="text" disabled name="business_compet" class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['competition_name']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView display-hide">
                                                    <li><input type="submit" value="Save" id="saveForm" class="vital_yellow_btn wdt_100"></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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
    .ui-multiselect.ui-helper-clearfix.ui-widget {
        width: 100% !important;
    }
    .ui-multiselect.ui-helper-clearfix.ui-widget .selected,.ui-multiselect.ui-helper-clearfix.ui-widget .available{
        width: 50% !important;
    }
    .ui-multiselect.ui-helper-clearfix.ui-widget .selected .selected.connected-list.ui-sortable,.ui-multiselect.ui-helper-clearfix.ui-widget .available .available.connected-list{
        width: 100% !important;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('load_application' => 'application', 'page_load' => 'drag_multiselect')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        get_userLists();

        $(".ui-multiselect").width(550);
        $(".ui-multiselect > .available").width(274);
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
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').addClass("display-show");
        $('.saveLinkView').removeClass("display-hide");
        $(".multiselect").attr("disabled", false);
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
                    $('#select_state').multiselect('destroy');
                    $("#select_state").multiselect();
                } else if (response.all_states != '' || response.ext_state != null) {
                    '<option value="">Select </option>';
                    for (var i = 0; i < response.all_states.length; i++) {
                        options += '<option value="' + response.all_states[i].id + '">' + response.all_states[i].state_name + '</option>';
                    }
                    $('#select_state').multiselect('destroy');
                    $("#select_state").html(options);
                    if (response.ext_state != null) {
                        for (var i = 0; i < response.all_states.length; i++) {
                            if ($.inArray(response.all_states[i].id, response.ext_state.user_state) != -1) {
                                $("#select_state").find("option[value=" + response.all_states[i].id + "]").prop("selected", "selected");
                            }
                        }
                    }
                    $('#select_state').multiselect();
                    $("#select_state").multiselect("refresh");
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