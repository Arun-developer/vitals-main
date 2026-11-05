<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $innovation_information[0]['name_of_enterprise'] . ' - Innovation Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $innovation_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $innovation_information[0]['name_of_enterprise'], 'app_stage' => $innovation_information[0]['stage'], 'program' => $innovation_information[0]['program'], 'doc1' => $innovation_information[0]['doc1'], 'doc2' => $innovation_information[0]['doc2'])); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Information About The Enterprise</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">Impact of Innovation</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="innovationForm" action="<?php echo base_url() . 'index.php/application/add_innovation_details'; ?>" autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <input type="hidden" name="inv_user_id" value="<?= $innovation_information[0]['inv_user_id']; ?>">
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Are you developing a<span>*</span></label>
                                                <select class="form-control fieldDisable" disabled id="type_prod" name="type_prod">
                                                    <option value="">--Select--</option>
                                                    <option value="Product" <?php if ($innovation_information[0]['develop_product'] == "Product") echo "selected"; ?>>Product</option>
                                                    <option value="Service" <?php if ($innovation_information[0]['develop_product'] == "Service") echo "selected"; ?>>Service</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>At what stage is your product / service<span>*</span></label>
                                                <select class="form-control fieldDisable" disabled id="stage_prod" name="stage_prod">
                                                    <option value="">--Select--</option>
                                                    <option value="Idea" <?php if ($innovation_information[0]['stage_product'] == "Idea") echo "selected"; ?>>Idea</option>
                                                    <option value="Proof of concept" <?php if ($innovation_information[0]['stage_product'] == "Proof of concept") echo "selected"; ?>>Proof of concept</option>
                                                    <option value="Prototype development" <?php if ($innovation_information[0]['stage_product'] == "Prototype development") echo "selected"; ?>>Prototype development</option>
                                                    <option value="Prototype testing" <?php if ($innovation_information[0]['stage_product'] == "Prototype testing") echo "selected"; ?>>Prototype testing</option>
                                                    <option value="Technical pilot" <?php if ($innovation_information[0]['stage_product'] == "Technical pilot") echo "selected"; ?>>Technical pilot</option>
                                                    <option value="Commercial pilot" <?php if ($innovation_information[0]['stage_product'] == "Commercial pilot") echo "selected"; ?>>Commercial pilot</option>
                                                    <option value="Production" <?php if ($innovation_information[0]['stage_product'] == "Production") echo "selected"; ?>>Production</option>
                                                    <option value="Growth" <?php if ($innovation_information[0]['stage_product'] == "Growth") echo "selected"; ?>>Growth</option>
                                                    <option value="Scaling" <?php if ($innovation_information[0]['stage_product'] == "Scaling") echo "selected"; ?>>Scaling</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Provide a brief description of your innovation (product or service)</label>
                                                <textarea class="form-control fieldDisable" name="inno_desc" id="inno_desc" cols="30" rows="3" disabled><?= $innovation_information[0]['inv_desc']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What problem does your innovation address?</label>
                                                <textarea class="form-control fieldDisable" name="inno_prob" id="inno_prob" cols="30" rows="3" disabled><?= $innovation_information[0]['inv_problem']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>How is the need addressed without your innovation? What are the available alternatives?</label>
                                                <textarea class="form-control fieldDisable" name="avail_alter" id="avail_alter" cols="30" rows="3" disabled><?= $innovation_information[0]['inv_alternatives']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Describe your proposed / current business model</label>
                                                <textarea class="form-control fieldDisable" name="prop_model" id="prop_model" cols="30" rows="3" disabled><?= $innovation_information[0]['proposal_desc']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What challenges / risks have you identified in the business?</label>
                                                <textarea class="form-control fieldDisable" name="ident_risk" id="ident_risk" cols="30" rows="3" disabled><?= $innovation_information[0]['inv_risks']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Who is the intended primary beneficiary of your product / service?</label>
                                                <textarea class="form-control fieldDisable" name="prim_benefi" id="prim_benefi" cols="30" rows="3" disabled><?= $innovation_information[0]['primary_benifi']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Will your product or service benefit other beneficiary groups? Describe these groups briefly.</label>
                                                <textarea class="form-control fieldDisable" name="service_benefit" id="service_benefit" cols="30" rows="3" disabled><?= $innovation_information[0]['others_benefit']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>How many people do you expect to impact through your innovation?</label>
                                                <textarea class="form-control fieldDisable" name="no_impact" id="no_impact" cols="30" rows="3" disabled><?= $innovation_information[0]['inv_impact']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Have you conducted research on your customer segments / run pilots?<span>*</span></label>
                                                <select class="form-control fieldDisable" name="cust_seg" id="cust_seg" onchange="showSegment(this.value);" disabled>
                                                    <option value="">--Select--</option>
                                                    <option value="yes" <?php if ($innovation_information[0]['research_cus_seg'] == 'yes') echo "selected='selected'"; ?>>Yes</option>
                                                    <option value="no" <?php if ($innovation_information[0]['research_cus_seg'] == 'no') echo "selected='selected'"; ?>>No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $seg_display_field = 'style="display:none"';
                                    if ($innovation_information[0]['research_cus_seg'] == 'yes') {
                                        $seg_display_field = 'style="display:block"';
                                    }
                                    ?>
                                    <div class="row" id="cus_seg_yes" >
                                        <div class="col-12 col-lg-6 col-md-6 showGroup" <?= $seg_display_field; ?> >
                                            <div class="form-group">
                                                <label>If yes, please provide the following information<br>What is the demographic profile of the primary beneficiary group? </label>
                                                <textarea class="form-control fieldDisable" name="benefi_grp" id="benefi_grp" cols="30" rows="3" disabled><?= $innovation_information[0]['demographic_profie']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6 showGroup" <?= $seg_display_field; ?>>
                                            <div class="form-group">
                                                <label>What is the average monthly earning of the primary beneficiary group?</label>
                                                <textarea class="form-control fieldDisable" name="avg_earn" id="avg_earn" cols="30" rows="3" disabled><?= $innovation_information[0]['avg_monthly']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView display-hide">
                                                    <li><input type="submit" value="Save" id="saveForm" class="vital_yellow_btn wdt_100"></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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
    </div>
</div>
</div>
</div>

<?php $this->load->view('vitals_footer.php', array('load_application' => 'application')); ?>

<script type="text/javascript">
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

    function showSegment(value) {
        if (value == 'yes') {
            $(".showGroup").css('display', 'block');
        } else {
            $(".showGroup").css('display', 'none');
        }
    }

    $('#innovationForm').validate({
        rules: {
            "type_prod": "required",
            "stage_prod": "required",
            "cust_seg": "required"
        },
        messages: {
            "type_prod": "Select type",
            "stage_prod": "Select type",
            "cust_seg": "Select type"
        }
    });
</script>

</body>
</html>