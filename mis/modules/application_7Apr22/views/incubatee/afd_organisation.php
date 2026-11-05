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
                                    <h5>Organisation Details</h5>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What category best describes your business currently?</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $innovation_information[0]['business_category']; ?> "/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What is your organisation’s current product stage?</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $innovation_information[0]['current_product']; ?> "/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Describe the digital innovation developed or used by your organisation. Explain how digital innovation is solving challenges in the waste sector? How is it a different approach from what has been done so far?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['inno_desc']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Which waste management issues do you plan to solve and what solutions do you propose to achieve this? Describe the details of your key activities. How is your solution different from your competition?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['inno_prob']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Who will buy your services? If you offer a free of charge service, how do you intend to cover the costs of your organisation?Who are your key competitors?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['avail_alter']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>How much was your turnover (financial report) in the last 2 financial years? If your organisation is less than a year old, please answer</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['ident_risk']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What will be the operational model? How do you make your operations robust and efficient?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['robot_efficient']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>What is the market size of the opportunity?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['market_size']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Describe the geographic area impacted by your activity</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['geographic']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>How do you aim to scale-up?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['scaleup']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Describe how your business model is replicable and scalable</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['business_model']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Estimate quantitatively and qualitatively the social and/or environmental impact of your activity? Any insight into the impact indicators, the method of calculation and the data collection will be preferable?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['estimate_qua']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Who are the key partners of your organisation?in particular with local actors</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['part_org']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Video URL showcasing the product and/or business mode</label>
                                                <input type="text" class="form-control fieldDisable" disabled value="<?= $innovation_information[0]['video_url']; ?>"/>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <h5>Funding Details</h5>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Have you received monetary support under any Central or State government scheme? If Yes, mention the scheme name and amount?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['central_state']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>Other funding details, if any?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['other_funding']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>How will this grant support you in your future growth?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['future_growth']; ?></textarea>
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