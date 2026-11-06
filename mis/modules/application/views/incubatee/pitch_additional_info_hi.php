<?php
$this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $additional_information[0]['name_of_enterprise'] . ' - Additional Info'));
require_once ("./language/lang_hi.php");
?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $additional_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name_hi' => $additional_information[0]['name_of_enterprise_hi'], 'app_stage' => $additional_information[0]['stage'], 'program' => $additional_information[0]['program'], 'doc1' => $additional_information[0]['doc1'], 'doc2' => $additional_information[0]['doc2'], 'lang_code' => $lang_code)); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id . '/hi'; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id . '/hi'; ?>">Team Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id . '/hi'; ?>">Information About The Enterprise</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id . '/hi'; ?>">Impact of Innovation</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id . '/hi'; ?>">Additional Information</a></li>
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
                                            <label>आपको हमारे बारे में कैसे पता चला?</label>
                                            <?php
                                            $aboutvill = explode(',', $additional_information[0]['info_about_program']);
                                            $aboutvill_om = explode(',', $additional_information[0]['info_other_mailer']);

                                            //$implode_info = '';
                                            $other_org_name = '';
                                            if ($additional_information[0]['info_other_mailer'] != '') {
                                                $info_other_mailer_om = trim($additional_information[0]['info_other_mailer']);
                                                $explode_info = explode(',', $info_other_mailer_om);
                                                //$implode_info = ', ' . implode(', ', $explode_info);
                                            }


                                            foreach ($aboutvill as $info_abtVill_val) {
                                                $values = trim($info_abtVill_val);
                                                if ($values == 'Villgro Mailer/Newsletter') {
                                                    $var_about .= $lang['villgro_mailer_news'] . ',';
                                                } else if ($values == 'Other Mailers(Previous)') {
                                                    //$var_about .= $lang['other_mailer_news'] . ',';
                                                    $test1 = '';
                                                    if ($details['partner_name_hi'] != '') {
                                                        $test1 = ' (' . $details['partner_name_hi'] . '), ';
                                                    }
                                                    $var_about .= $test1;
                                                } else if ($values == 'Other Mailers') {
                                                    $var_about .= $lang['other_mailer_news'] . ', ';
                                                } else if ($values == 'Facebook') {
                                                    $var_about .= $lang['facebook'] . ', ';
                                                } else if ($values == 'Twitter') {
                                                    $var_about .= $lang['twitter'] . ', ';
                                                } else if ($values == 'LinkedIn') {
                                                    $var_about .= $lang['linkedIn'] . ', ';
                                                } else if ($values == 'Instagram') {
                                                    $var_about .= $lang['instagram'] . ',';
                                                } else if ($values == 'Inc42') {
                                                    $var_about .= $lang['inc42'] . ', ';
                                                } else if ($values == 'YourStory') {
                                                    $var_about .= $lang['yourstory'] . ', ';
                                                } else if ($values == 'BetterIndia') {
                                                    $var_about .= $lang['the_better_india'] . ', ';
                                                } else if ($values == 'Press') {
                                                    $var_about .= $lang['press_media'] . ', ';
                                                } else if (trim($values) == 'Referral') {
                                                    $var_about .= $lang['referral'] . ', ';
                                                } else if ($values == 'Google search') {
                                                    $var_about .= $lang['google_search'] . ',';
                                                } else {
                                                    $aboutvill = $referalArr = explode('(', $values);
                                                    if ($referalArr[0] == 'Referral') {
                                                        $referral_only = $lang['referral'] . '';
                                                        $referal_sub = '';
                                                        if ($referalArr[1] != '' && $pitch_org[0]['referral_name_hi'] != '') {
                                                            $referal_sub = '(' . $pitch_org[0]['referral_name_hi'] . '), ';
                                                        }
                                                        $var_about .= $referral_only . $referal_sub;
                                                    }
                                                }
                                            }
                                            $implode_info .= '';
                                            $info_other_mailer = explode(',', $info_other_mailer_om);
                                            foreach ($info_other_mailer as $info_other_mailer_val) {
                                                $om_values = trim($info_other_mailer_val);
                                                if ($om_values == 'ANDE') {
                                                    $implode_info .= $lang['ande'] . ', ';
                                                } else if ($om_values == 'AVPN') {
                                                    $implode_info .= $lang['avpn'] . ', ';
                                                } else if ($om_values == 'Artha Impact') {
                                                    $implode_info .= $lang['artha_impact'] . ', ';
                                                } else if ($om_values == 'Impact for Breakfast') {
                                                    $implode_info .= $lang['impact_breakfast'] . ', ';
                                                } else if ($om_values == 'Others') {
                                                    $implode_info .= $lang['Others'];
                                                }
                                            }


                                            if (in_array('Others', $info_other_mailer)) {
                                                $other_org_name .= '(' . $additional_information[0]['other_org_name_hi'] . ') ';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9 col-md-9">
                                        <input type="text" class="form-control" value="<?= $var_about . $implode_info . '' . $other_org_name; ?>" disabled />
                                    </div>
                                </div>
                                <?php
                                if (php72_cmp($innovationDetails[0]['program']) == 6) {
                                    $doc_link = 'https://www.villgro.org/ubsapply/document/';
                                } else {
                                    $doc_link = host_url() . "pitchform/document/";
                                }
                                ?>
                                <div class="row">
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label>दस्तावेज अपलोड किए</label>
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