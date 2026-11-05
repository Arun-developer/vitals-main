<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $additional_information[0]['name_of_enterprise'] . ' - Additional Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $additional_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $additional_information[0]['name_of_enterprise'], 'app_stage' => $additional_information[0]['stage'], 'program' => $additional_information[0]['program'], 'doc1' => $additional_information[0]['doc1'], 'doc2' => $additional_information[0]['doc2'])); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Information About The Enterprise</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">Impact of Innovation</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <div class="row">
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>How did you hear about us?</label>
                                            <?php
                                            $aboutvill = explode(',', $additional_information[0]['info_about_program']);
                                            $aboutvill_om = explode(',', $additional_information[0]['info_other_mailer']);

                                            foreach ($aboutvill as $key => $value) {
                                                if ($aboutvill[$key] == 'Other Mailers' && $additional_information[0]['partner_name'] != '') {
                                                    $aboutvill[$key] = 'Other Mailers (' . trim($additional_information[0]['partner_name']) . ')';
                                                } else if ($aboutvill[$key] == 'Past Incubatee' && $additional_information[0]['inc_name'] != '') {
                                                    $aboutvill[$key] = 'Past Incubatee (' . trim($additional_information[0]['doc2'][0]['inc_name']) . ')';
                                                } else if ($aboutvill[$key] == ' Referral' && $additional_information[0]['referral_name'] != '') {
                                                    $aboutvill[$key] = 'Referral (' . trim($additional_information[0]['referral_name']) . ')';
                                                } else if ($aboutvill[$key] == 'Member Association (MA)' && $additional_information[0]['inc_name'] != '') {
                                                    $aboutvill[$key] = 'Member Association (' . trim($additional_information[0]['inc_name']) . ')';
                                                }
                                            }
                                            $abtVill = implode(', ', $aboutvill);
                                            $implode_info = '';
                                            $other_org_name = '';
                                            if ($additional_information[0]['info_other_mailer'] != '') {
                                                $info_other_mailer_om = trim($additional_information[0]['info_other_mailer']);
                                                $explode_info = explode(',', $info_other_mailer_om);
                                                $implode_info = ', ' . implode(', ', $explode_info);
                                            }
                                            if ($additional_information[0]['other_org_name'] != '') {
                                                $other_org_name = '(' . trim($additional_information[0]['other_org_name']) . ')';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9 col-md-9">
                                        <input type="text" class="form-control" value="<?= $abtVill . $implode_info . '' . $other_org_name; ?>" disabled />
                                    </div>
                                </div>
                                <?php
                                if ($additional_information[0]['program'] == 6) {
                                    $doc_link = 'https://www.villgro.org/ubsapply/document/';
                                } else if ($additional_information[0]['program'] == 5) {
                                    $doc_link = host_url() . "fpai/document/";
                                } else if ($additional_information[0]['program'] == 7) {
                                    $doc_link = host_url() . "ysvf/document/";
                                } else {
                                    $doc_link = host_url() . "pitchform/document/";
                                }
                                ?>
                                <div class="row">
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>Doc uploads </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9 col-md-9">
                                        <?php if ($additional_information[0]['doc1'] != '') { ?>
                                            <a href="<?php echo $doc_link . $additional_information[0]['doc1']; ?>"
                                               target="_blank"><?php echo $additional_information[0]['doc1']; ?></a>
                                           <?php } ?>
                                        <br>
                                        <?php if ($additional_information[0]['doc2'] != '') { ?>
                                            <a href="<?php echo $doc_link . $additional_information[0]['doc2']; ?>"
                                               target="_blank"><?php echo $additional_information[0]['doc2']; ?></a>
                                           <?php } ?>
                                    </div>
                                </div>
                                <?php if ($additional_information[0]['program'] == 3) { ?>
                                    <div class="row">
                                        <div class="col-12 col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label>I am aware and give permission for my company profile to be automatically created on the Artha Platform</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3 col-md-3">
                                            <input type="text" class="form-control" value="<?= $additional_information[0]['artha_platform']; ?>" disabled />
                                        </div>
                                    </div>
                                <?php } ?>
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

</body>
</html>