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
                            <div class="inputplan-structureall plan-structure-new">
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>CIN Number</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['cin_number']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Year of Incorporation</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['incorporation_year']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Registered Office Address</label>
                                            <textarea class="form-control fieldDisable" name="txtAddressOne" cols="30" rows="3" disabled><?= str_replace(PHP_EOL, '', $enterprise_information[0]['company_address']); ?></textarea>
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
                                            <label>Company Website</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['website']; ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Focus area that you are applying</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['sub_sector']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Stage of Operation</label>
                                            <?php
                                            if ($enterprise_information[0]['operation_stage'] == 'Idea') {
                                                $stage_operation = 'Idea Stage';
                                            } else {
                                                $stage_operation = $enterprise_information[0]['operation_stage'];
                                            }
                                            ?>
                                            <input type="text" class="form-control" value="<?= $stage_operation; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Are you a technology driven startup?</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['ubs_trl']; ?>" disabled />
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
                                            <label>What are the current challenges that are you facing in scaling up your solution?</label>
                                            <textarea class="form-control" disabled ><?= $enterprise_information[0]['ubs_challenge']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>How do you think the Villgro accelerator program will help you overcome the above mentioned challenges?</label>
                                            <textarea class="form-control" disabled ><?= $enterprise_information[0]['incubated_accelerated']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Are there any corporate partners whom you would like to partner with for business growth?</label>
                                            <textarea class="form-control" disabled ><?= $enterprise_information[0]['corporate_partner']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
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

</body>
</html>