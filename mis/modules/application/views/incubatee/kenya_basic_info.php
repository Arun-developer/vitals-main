<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $basic_information[0]['name_of_enterprise'] . ' - Basic Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $basic_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $basic_information[0]['name_of_enterprise'], 'app_stage' => $basic_information[0]['stage'], 'program' => $basic_information[0]['program'], 'doc1' => $basic_information[0]['doc1'], 'doc2' => $basic_information[0]['doc2'])); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container tab-content">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="basicForm" action="<?php echo base_url() . 'index.php/application/update_kenya_details'; ?>" autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <input type="hidden" name="inv_user_id" value="<?= $basic_information[0]['inv_user_id']; ?>">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Innovation ID</label>
                                                <?php
                                                if ($basic_information[0]['copy_partner_id'] == '') {
                                                    $inv_id = $basic_information[0]['copy_id'] . "_" . $basic_information[0]['partner_id'] . "_" . $basic_information[0]['partner_count'];
                                                } else {
                                                    $inv_id = $basic_information[0]['copy_id'] . "_" . $basic_information[0]['copy_partner_id'] . "_" . $basic_information[0]['partner_count'];
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $inv_id; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Name of Enterprise<span>*</span></label>
                                                <input type="text" class="form-control fieldDisable" disabled name="txtEnterprise" value="<?= $basic_information[0]['name_of_enterprise']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Name of Entrepreneur<span>*</span></label>
                                                <input type="text" class="form-control fieldDisable" disabled name="txtEntrepreneur" value="<?= $basic_information[0]['name_of_entrepreneur']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Email<span>*</span></label>
                                                <input type="text" class="form-control" disabled name="txtEmail" id="txtEmail" value="<?= $basic_information[0]['email_id']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Mobile<span>*</span></label>
                                                <input type="text" class="form-control fieldDisable" disabled name="txtMobile" value="<?= $basic_information[0]['mobile_no']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Website URL</label>
                                                <input type="text" class="form-control fieldDisable" disabled name="txtWebsite" value="<?= $basic_information[0]['website']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php
                                        $benificary_val = unserialize($basic_information[0]['benificiary']);
                                        ?>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Who will be the beneficiaries of your product/service?<span>*</span></label>
                                                <select class="form-control fieldDisable" disabled multiple name="txtBeneficiary[]" id="txtBeneficiary" >
                                                    <option value="People at the base of the pyramid" <?php if (php72_in_array('People at the base of the pyramid', $benificary_val)) echo "selected"; ?>>People at the base of the pyramid</option>
                                                    <option value="Rural poor" <?php if (php72_in_array('Rural poor', $benificary_val)) echo "selected"; ?>>Rural poor</option>
                                                    <option value="Urban poor" <?php if (php72_in_array('Urban poor', $benificary_val)) echo "selected"; ?>>Urban poor</option>
                                                    <option value="Rural or urban middle income" <?php if (php72_in_array('Rural or urban middle income', $benificary_val)) echo "selected"; ?>>Rural or urban middle income</option>
                                                    <option value="Rural or urban high income" <?php if (php72_in_array('Rural or urban high income', $benificary_val)) echo "selected"; ?>>Rural or urban high income</option>
                                                </select>
                                                <div id="beneficiary_err"></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Type of organization <a href="javascript:(void)" id="profit_hint">(?)</a><span>*</span></label>
                                                <div id="dialog" title="Information" style="display:none;height:100px;">
                                                    <p>
                                                        <b>For-profit:</b> Incubatee must be registered or plans to register as a Private Limited Company<br />
                                                        <b>Non-profit:</b> Incubatee is registered or plans to register as a Society, Trust or Section 25 Company
                                                    </p>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input fieldDisable" disabled type="radio" name="txtProfit" id="txtProfit1" value="profit" <?php if ($basic_information[0]['ent_type'] == 'profit') echo "checked=checked"; ?>>
                                                    <label class="form-check-label" for="txtProfit1">For-profit organization</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input fieldDisable" disabled type="radio" name="txtProfit" id="txtProfit2" value="nonprofit" <?php if ($basic_information[0]['ent_type'] == 'nonprofit') echo "checked=checked"; ?>>
                                                    <label class="form-check-label" for="txtProfit2">Non-profit organization</label>
                                                </div>
                                                <label for="txtProfit" class="error"></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>What type of impact will your Product / service have on the BoP / poor?<span>*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input fieldDisable" disabled type="radio" name="txtImpact" id="txtImpact1" value="Direct" <?php if ($basic_information[0]['impact_of_product'] == 'Direct') echo "checked=checked"; ?>>
                                                    <label class="form-check-label" for="txtImpact1">Direct</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input fieldDisable" disabled type="radio" name="txtImpact" id="txtImpact2" value="Indirect" <?php if ($basic_information[0]['impact_of_product'] == 'Indirect') echo "checked=checked"; ?>>
                                                    <label class="form-check-label" for="txtImpact2">Indirect</label>
                                                </div>
                                                <label for="txtImpact" class="error"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView display-hide">
                                                    <li><input type="submit" value="Save" id="saveForm" class="vital_yellow_btn wdt_100"></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </main>
                    </div>
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
        $('#txtBeneficiary').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });

        var sector_id = "<?php echo $basic_information[0]['sector_id']; ?>";
        incSubSector(sector_id);
    });

    $('.summaryEdit').click(function () {
        $(".fieldDisable").attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').addClass("display-show");
        $('.saveLinkView').removeClass("display-hide");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').attr("disabled", false);
    });

    $(document).on('click', '#saveForm', function (e) {
        var multiselect_len = $('.multiselect-selected-text').html();
        $("#beneficiary_err").html('');
        if (multiselect_len == 'Select an Option') {
            $("#basicForm").valid();
            e.preventDefault();
            $("#beneficiary_err").html('<label for="txtBeneficiary" class="error">Select beneficiary</label>');
        }
    });

    $('#basicForm').validate({
        rules: {
            "txtEnterprise": "required",
            "txtEntrepreneur": "required",
            "txtMobile": "required",
            "txtProfit": "required",
            "txtImpact": "required"
        },
        messages: {
            "txtEnterprise": "Enter name",
            "txtEntrepreneur": "Enter entrepreneur",
            "txtMobile": "Enter mobile",
            "txtProfit": "Select type",
            "txtImpact": "Select type"
        }
    });

    function incSubSector(val) {
        var myarray = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/scouting/getSubsector",
            data: {
                sector_id: val
            },
            dataType: 'json',
            success: function (msg) {
                $('#incsub_sector').find('option').not(':first').remove().end();
                $.each(msg, function (i, value) {
                    myarray.push(value.id);
                    $('#incsub_sector').append($('<option>').text(value.sector).attr('value', value.id));
                });
                var subsec_id = "<?php echo $basic_information[0]['sub_sector_id']; ?>";
                if ($.inArray(subsec_id, myarray) != -1) {
                    $('#incsub_sector').val(subsec_id);
                } else {
                    $('#incsub_sector').val('');
                }
            },
        });
    }

    $("#profit_hint").mouseover(function () {
        $("#dialog").dialog({
            modal: true,
            width: 460,
            maxWidth: 500,
            resizable: false,
            dialogClass: "dialogaddSeasons"
        });
    });
</script>

</body>
</html>