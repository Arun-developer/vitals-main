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
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <?php if (php72_cmp($enterprise_information[0]['program']) == 5) { ?>
                                <div class="inputplan-structureall plan-structure-new">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>You are applying as a</label>
                                                <?php
                                                $entType = '';
                                                if ($enterprise_information[0]['ent_type'] == 'profit') {
                                                    $entType = 'For-profit Organization';
                                                } else if ($enterprise_information[0]['ent_type'] == 'nonprofit') {
                                                    $entType = 'Non-profit Organization';
                                                } else if ($enterprise_information[0]['ent_type'] == 'notapplicable') {
                                                    $entType = 'Applying as an individual';
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $entType; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Is your company registered under the MCA?</label>
                                                <?php
                                                if ($enterprise_information[0]['company_register'] == 'yes') {
                                                    $reg_no = ucfirst($enterprise_information[0]['company_register']) . ' - ' . $enterprise_information[0]['cin_number'];
                                                } else if ($enterprise_information[0]['company_register'] == 'intend') {
                                                    $reg_no = "Intend to register";
                                                } else {
                                                    $reg_no = ucfirst($enterprise_information[0]['company_register']);
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $reg_no; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Does your company have a website? </label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['website']; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Headquarter State/UT</label>
                                                <input type="text" class="form-control" value="<?= ucfirst($enterprise_information[0]['state_name']); ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Headquarter City</label>
                                                <input type="text" class="form-control" value="<?= ucfirst($enterprise_information[0]['city_name']); ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Under which problem statement are you applying</label>
                                                <?php
                                                if ($enterprise_information[0]['applying_stage'] == '1') {
                                                    $applying_stage = 'Affordable, easy to use solutions for early diagnosis of pregnancy';
                                                } else if ($enterprise_information[0]['applying_stage'] == '2') {
                                                    $applying_stage = 'Affordable and multi-parameter, ovulation monitoring and management solutions';
                                                } else if ($enterprise_information[0]['applying_stage'] == '3') {
                                                    $applying_stage = 'Easy and non-invasive diagnosis of Polycystic Ovary Syndrome (PCOS) among young girls';
                                                } else if ($enterprise_information[0]['applying_stage'] == '4') {
                                                    $applying_stage = 'Low cost, eco-friendly, easy to use solutions for dispensing and disposing of sanitary napkins';
                                                } else if ($enterprise_information[0]['applying_stage'] == '5') {
                                                    $applying_stage = 'Technology-driven solutions for providing multilingual comprehensive sexual education to youth';
                                                } else if ($enterprise_information[0]['applying_stage'] == '6') {
                                                    $applying_stage = 'Other';
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $applying_stage; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Stage of Operation</label>
                                                <?php
                                                if ($enterprise_information[0]['operation_stage'] == 'Idea') {
                                                    $stage_operation = 'Idea Stage';
                                                } else if ($enterprise_information[0]['operation_stage'] == 'Scaling up / Rapid sales growth') {
                                                    $stage_operation = 'Growth stage / generating revenue';
                                                } else {
                                                    $stage_operation = $enterprise_information[0]['operation_stage'];
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $stage_operation; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Sector</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['sector_name']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Sub-sector</label>
                                                <?php
                                                if ($enterprise_information[0]['other_subsector'] != '') {
                                                    $subsector_val = $enterprise_information[0]['sub_sector_name'] . ' - ' . $enterprise_information[0]['other_subsector'];
                                                } else {
                                                    $subsector_val = $enterprise_information[0]['sub_sector_name'];
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $subsector_val; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>What would best describe your solution</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['describe_solution']; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else if (php72_cmp($enterprise_information[0]['program']) == 7) { ?>
                                <div class="inputplan-structureall plan-structure-new">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Applicant type</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['applicant_type']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>You are applying as a</label>
                                                <?php
                                                $entType = '';
                                                if ($enterprise_information[0]['ent_type'] == 'profit') {
                                                    $entType = 'For-profit Organization';
                                                } else if ($enterprise_information[0]['ent_type'] == 'nonprofit') {
                                                    $entType = 'Non-profit Organization';
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $entType; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Is your company registered as a legal entity?</label>
                                                <?php
                                                if ($enterprise_information[0]['company_register'] == 'yes') {
                                                    $reg_no = ucfirst($enterprise_information[0]['company_register']) . ' - ' . $enterprise_information[0]['cin_number'];
                                                } else {
                                                    $reg_no = ucfirst($enterprise_information[0]['company_register']);
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $reg_no; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" class="form-control" value="<?= ucfirst($enterprise_information[0]['ysvf_country']); ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Headquarter State/UT</label>
                                                <input type="text" class="form-control" value="<?= ucfirst($enterprise_information[0]['ysvf_state']); ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Headquarter City</label>
                                                <input type="text" class="form-control" value="<?= ucfirst($enterprise_information[0]['ysvf_city']); ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Does your company have a website?</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['website']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Under which problem statement are you applying?</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['areas_other']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Stage of Operation</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['operation_stage']; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>What would best describe your solution</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['describe_solution']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>If Other, please specify the details</label>
                                                <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $enterprise_information[0]['quest_2']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="inputplan-structureall plan-structure-new">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Is your enterprise a</label>
                                                <?php
                                                $entType = '';
                                                if ($enterprise_information[0]['ent_type'] == 'profit') {
                                                    $entType = 'For-profit Organization';
                                                } else if ($enterprise_information[0]['ent_type'] == 'nonprofit') {
                                                    $entType = 'Non-profit Organization';
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $entType; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Is your company registered under the MCA?</label>
                                                <?php
                                                if ($enterprise_information[0]['company_register'] == 'yes') {
                                                    $reg_no = ucfirst($enterprise_information[0]['company_register']) . ' - ' . $enterprise_information[0]['cin_number'];
                                                } else {
                                                    $reg_no = ucfirst($enterprise_information[0]['company_register']);
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $reg_no; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Year of Incorporation</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['incorporation_year']; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>DIPP Registration </label>
                                                <?php
                                                if ($enterprise_information[0]['dipp_register'] == 'yes') {
                                                    $dipp_no = ucfirst($enterprise_information[0]['dipp_register']) . ' - ' . $enterprise_information[0]['dipp_number'];
                                                } else {
                                                    $dipp_no = ucfirst($enterprise_information[0]['dipp_register']);
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $dipp_no; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Headquarter State/UT</label>
                                                <input type="text" class="form-control" value="<?= ucfirst($enterprise_information[0]['state_name']); ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Headquarter City</label>
                                                <input type="text" class="form-control" value="<?= ucfirst($enterprise_information[0]['city_name']); ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Stage of Operation</label>
                                                <?php
                                                if ($enterprise_information[0]['operation_stage'] == 'Idea') {
                                                    $stage_operation = 'Idea Stage';
                                                } else if ($enterprise_information[0]['operation_stage'] == 'Scaling up / Rapid sales growth') {
                                                    $stage_operation = 'Growth stage / generating revenue';
                                                } else {
                                                    $stage_operation = $enterprise_information[0]['operation_stage'];
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $stage_operation; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Sector</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['sector_name']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Sub-sector</label>
                                                <?php
                                                if ($enterprise_information[0]['other_subsector'] != '') {
                                                    $subsector_val = $enterprise_information[0]['sub_sector_name'] . ' - ' . $enterprise_information[0]['other_subsector'];
                                                } else {
                                                    $subsector_val = $enterprise_information[0]['sub_sector_name'];
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $subsector_val; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>SDGs that the innovation aligns with</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['sdg_aligns']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>What would best describe your solution</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['describe_solution']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Does your company have a website? </label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['website']; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Revenue of company: 2020-21</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['fy_20_21']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Revenue of company: 2019-20</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['fy_19_20']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Revenue of company: 2018-19</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['fy_18_19']; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Have you raised funds in the past?</label>
                                                <input type="text" class="form-control" value="<?= ucfirst($enterprise_information[0]['past_fund']); ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Total Grant Amount</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['grant_amount']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Total Equity Amount</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['equity_amount']; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>What kind of funding instruments are you looking for?</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['funding_instrument']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>What is the range of funding that you are looking for?</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['funding_range']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Has your company been incubated / accelerated by any institution?</label>
                                                <input type="text" class="form-control" value="<?= $enterprise_information[0]['accelerate_type']; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>The name of the incubator / accelerator and the year of participation</label>
                                                <textarea class="form-control" disabled ><?= $enterprise_information[0]['incubated_accelerated']; ?></textarea>
                                            </div>
                                        </div>
                                        <?php if (($stage_operation == 'Commercial Piloting / Initial Paying Customers' || $stage_operation == 'Scaling up / Rapid sales growth') && $enterprise_information[0]['sub_sector'] == '16') { ?>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Liters of water you saved in the last one year</label>
                                                    <textarea class="form-control" disabled ><?= $enterprise_information[0]['saved_water']; ?></textarea>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
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

</body>
</html>