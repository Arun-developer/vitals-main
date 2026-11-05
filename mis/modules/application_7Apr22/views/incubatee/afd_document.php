<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $additional_information[0]['name_of_enterprise'] . ' - Additional Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $additional_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $additional_information[0]['name_of_enterprise'], 'app_stage' => $additional_information[0]['stage'], 'program' => $additional_information[0]['program'], 'doc1' => $additional_information[0]['doc1'], 'doc2' => $additional_information[0]['doc2'], 'doc3' => $additional_information[0]['doc3'])); ?>
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
                                <?php if($additional_information[0]['program'] == 10) { ?>
                                    <div class="row">
                                        <div class="col-12 col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label>Why are you applying for the TANSEED program at Villgro?</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-8 col-md-8">
                                            <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['tanseed_program']; ?></textarea>
                                        </div>
                                    </div>
                                    <?php
                                    $learn_about = explode(',', $additional_information[0]['company_description']);
                                    foreach ($learn_about as $key => $value) {
                                        if ($learn_about[$key] == 'Others' && $additional_information[0]['from_villgro'] != '') {
                                            $learn_about[$key] = 'Others (' . trim($additional_information[0]['from_villgro']) . ')';
                                        }
                                    }
                                    $learn_values = implode(', ', $learn_about);
                                    ?>
                                    <div class="row" style="padding-bottom: 15px;">
                                        <div class="col-12 col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label>What are you most interested in learning more about?</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-8 col-md-8">
                                            <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $learn_values; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-bottom: 15px;">
                                        <div class="col-12 col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label>How did you hear about us?</label>
                                                <?php
                                                $aboutvill = explode(',', $additional_information[0]['hear_abt']);

                                                foreach ($aboutvill as $key => $value) {
                                                    if ($aboutvill[$key] == 'Other Mailers' && $additional_information[0]['support_name'] != '') {
                                                        $aboutvill[$key] = 'Other Mailers (' . trim($additional_information[0]['support_name']) . ')';
                                                    } else if ($aboutvill[$key] == 'Referral' && $additional_information[0]['referal_name'] != '') {
                                                        $aboutvill[$key] = 'Referral (' . trim($additional_information[0]['referal_name']) . ')';
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
                                        <div class="col-12 col-lg-8 col-md-8">
                                            <input type="text" class="form-control" value="<?= $abtVill . $implode_info . '' . $other_org_name; ?>" disabled />
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="row">
                                        <div class="col-12 col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label>How did you hear about us?</label>
                                                <?php
                                                $aboutvill = explode(',', $additional_information[0]['hear_abt']);

                                                foreach ($aboutvill as $key => $value) {
                                                    if ($aboutvill[$key] == 'Other Mailers' && $additional_information[0]['support_name'] != '') {
                                                        $aboutvill[$key] = 'Other Mailers (' . trim($additional_information[0]['support_name']) . ')';
                                                    } else if ($aboutvill[$key] == 'Referral' && $additional_information[0]['referal_name'] != '') {
                                                        $aboutvill[$key] = 'Referral (' . trim($additional_information[0]['referal_name']) . ')';
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
                                }
                                if($additional_information[0]['program'] == 10) {
                                    $doc_link = host_url() . "tanseed/uploads/"; 
                                } else {
                                    $doc_link = host_url() . "swachhata_startupchallenge/uploads/"; 
                                }
                                ?>
                                <div class="row">
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>Uploaded Document</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9 col-md-9">
                                        <?php if ($additional_information[0]['doc1'] != '') { ?>
                                            <a href="<?php echo $doc_link . $additional_information[0]['doc1']; ?>"
                                               target="_blank"><?php echo $additional_information[0]['doc1']; ?></a>
                                           <?php } ?>
                                       </div>
                                       <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>DIPP certificate</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9 col-md-9">
                                        <?php if ($additional_information[0]['doc2'] != '') { ?>
                                            <a href="<?php echo $doc_link . $additional_information[0]['doc2']; ?>"
                                               target="_blank"><?php echo $additional_information[0]['doc2']; ?></a>
                                           <?php } ?>
                                       </div>
                                       <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>Incorporation Certificate</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9 col-md-9">
                                        <?php if ($additional_information[0]['doc3'] != '') { ?>
                                            <a href="<?php echo $doc_link . $additional_information[0]['doc3']; ?>"
                                               target="_blank"><?php echo $additional_information[0]['doc3']; ?></a>
                                           <?php } ?>
                                       </div>
                                   </div>
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