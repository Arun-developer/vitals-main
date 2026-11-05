<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $innovation_information[0]['name_of_enterprise'] . ' - Innovation Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $innovation_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $innovation_information[0]['name_of_enterprise'], 'app_stage' => $innovation_information[0]['stage'], 'program' => $innovation_information[0]['program'], 'doc1' => $innovation_information[0]['doc1'], 'doc2' => $innovation_information[0]['doc2'], 'doc3' => $innovation_information[0]['doc3'])); ?>
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
                                    <h5>Startup Details</h5>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Provide a short description/ elevator pitch of your startup</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['inno_desc']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Is yours a Technology Startup? If yes, pls explain the technology</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['inno_prob']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What is the problem you are solving and why are you focused on this?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['avail_alter']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What is your value proposition for this problem?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['prop_model']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What is your unique selling point?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['ident_risk']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What is your target customer segment?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['robot_efficient']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What is the market size of the opportunity?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['market_size']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Who are your key competitors and what is your competitive advantage?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['geographic']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>How do you aim to scale-up?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['scaleup']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What is your revenue model?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['business_model']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>How much is your company's monthly burn rate?</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $innovation_information[0]['competition_name']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What is your company's current product stage?</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $innovation_information[0]['product_stage']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What category best describes your business currently?</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $innovation_information[0]['business_category']; ?>"/>
                                            </div>
                                        </div>                                        
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Video URL explaining the product and/or business model</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $innovation_information[0]['video_url']; ?>"/>
                                            </div>
                                        </div>   
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Briefly describe the key milestones your company has already achieved</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['estimate_qua']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Have you previously taken part in any pitch training? Please provide details</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['part_org']; ?></textarea>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Describe where you see your company in the next five years. What impact will you create?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['other_funding']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <h5>Funding Details</h5>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Have you received monetary support under any Central or State government scheme?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['central_state']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What was the initial investment put into your project?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['future_growth']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What investment are you looking for in the next 12 months and what will the funds be used for?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['investment_looking']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Any other funding details, if any</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['funding_details']; ?></textarea>
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
</script>

</body>
</html>