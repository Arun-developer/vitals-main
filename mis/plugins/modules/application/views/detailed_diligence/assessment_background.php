<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => 'Detailed Assessment - ' . $innovation['name_of_enterprise'])); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'diligence_detail', 'inv_stage' => $innovation['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content vital_windowScroll">
                <?php $this->load->view('detailed_diligence/diligence_options.php', array('application_id' => $application_id, 'title' => 'Detailed Assessment', 'inv_id' => $inv_id_format, 'stage' => $stage_name, 'status' => $status_name, 'incharge' => $assign_incharge, 'enterprise_name' => $innovation['name_of_enterprise'], 'sector' => $sector[0]['sector'], 'sub_sector' => $subsector, 'assign_to' => $assign_to, 'eic_date' => $eic_date)); ?>

                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/application/assessment_background/' . $application_id; ?>">Background/ Description</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_situation/' . $application_id; ?>">Current Situation/ Next Steps</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_investment/' . $application_id; ?>">Investment Structure and Returns</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_thesis/' . $application_id; ?>">Investment Thesis</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_model/' . $application_id; ?>">Business Model</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_strategy/' . $application_id; ?>">Launch and scaling strategy of the company</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_impact/' . $application_id; ?>">Social Impact</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_sha/' . $application_id; ?>">Exit Options</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_investors/' . $application_id; ?>">Existing investors and strategic partners</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_options/' . $application_id; ?>">Exit Options</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_agreements/' . $application_id; ?>">Summary of other key Agreements </a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_drivers/' . $application_id; ?>">Sector summary and key Drivers</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_swot/' . $application_id; ?>">SWOT</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_terms/' . $application_id; ?>">Key Transaction Terms</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_risks/' . $application_id; ?>">Risks and Mitigations </a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_timing/' . $application_id; ?>">Timing & Next Steps</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_team/' . $application_id; ?>">Villgro Team</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_decision/' . $application_id; ?>">IC Decision</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container ">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <form name="detail_form" id="detail_form" action="<?php echo site_url('application/add_detailed_assessment'); ?>" method="post" autocomplete="off">
                                <input type="hidden" name="innovation_id" value="<?= $application_id; ?>">
                                <input type="hidden" name="form_name" value="assessment_background">
                                <input type="hidden" name="version" id="version" value="<?= $get_diligence[0]['version']; ?>" />
                                <input type="hidden" name="form_id" value="1">
                                <input type="hidden" name="save_type" id="save_type" value="">
                                <div class="inputplan-structureall plan-structure-new">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label>Background/ Description</label>
                                                <textarea class="form-control" name="description" id="description" cols="30" rows="3"><?= $get_diligence[0]['description']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView">
                                                    <?php if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || in_array($this->session->userdata('emp_number'), $assign_incharge_id)) { ?>
                                                        <li><input type="submit" value="Save" id="saveForm" class="vital_yellow_btn wdt_100"></li>
                                                        <li><input type="submit" value="Save as new version" id="saveVersion" class="vital_yellow_btn"></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/application/assessment_background/' . $application_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                        <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

<script type="text/javascript">
    $(document).on('click', '#saveVersion', function () {
        $('#save_type').val('save_version')
    });

    $(document).on('click', '#saveForm', function () {
        $('#save_type').val('save_exist')
    });
</script>

</body>
</html>