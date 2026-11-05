<?php
$this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $team_information[0]['name_of_enterprise'] . ' - Team Info'));
require_once ("./language/lang_hi.php");
require_once ("./language/state_city_hi.php");
?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $team_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $team_information[0]['name_of_enterprise'], 'enterprise_name_hi' => $team_information[0]['name_of_enterprise_hi'], 'app_stage' => $team_information[0]['stage'], 'program' => $team_information[0]['program'], 'doc1' => $team_information[0]['doc1'], 'doc2' => $team_information[0]['doc2'], 'lang_code' => $lang_code)); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id . '/hi'; ?>">Basic Information</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id . '/hi'; ?>">Team Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id . '/hi'; ?>">Information About The Enterprise</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id . '/hi'; ?>">Impact of Innovation</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id . '/hi'; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container tab-content">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <h5>संस्थापक टीम विवरण</h5>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>पुरुष की संख्या</label>
                                            <input type="text" class="form-control" value="<?= $team_information[0]['male_numb']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>महिला की संख्या</label>
                                            <input type="text" class="form-control" value="<?= $team_information[0]['female_numb']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>ट्रांसजेंडर की संख्या</label>
                                            <input type="text" class="form-control" value="<?= $team_information[0]['transgender_numb']; ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>50% या अधिक स्वामित्व वाली महिला संस्थापकों/सह-संस्थापकों की कुल संख्या</label>
                                            <input type="text" class="form-control" value="<?= $team_information[0]['women_founder']; ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $i = 0;
                                foreach ($team_information as $team) {
                                    $j = $i + 1;
                                    ?>
                                    <h5>टीम सदस्य <?= $j; ?></h5>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>नाम</label>
                                                <input type="text" class="form-control" value="<?= $team['name_hi']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>शीर्षक</label>
                                                <input type="text" class="form-control" value="<?= $team['cur_title_hi']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>यदि अन्य हैं, तो निर्दिष्ट करें</label>
                                                <input type="text" class="form-control" value="<?= $team['other_title_hi']; ?>" disabled />
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>ईमेल</label>
                                                <input type="text" class="form-control" value="<?= $team['email']; ?>" disabled />
                                            </div>
                                        </div>                                        
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>मोबाइल नम्बर</label>
                                                <input type="text" class="form-control" value="<?= $team['phone']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>लिंग</label>
                                                <input type="text" class="form-control" value="<?= $lang[$team['gender']]; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>आयु</label>
                                                <input type="text" class="form-control" value="<?= $team['age']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>उच्चतम शैक्षिक योग्यता</label>
                                                <input type="text" class="form-control" value="<?= $team['education_qualify_hi']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>लिंक्डइन प्रोफाइल का लिंक</label>
                                                <input type="text" class="form-control" value="<?= $team['linkedin']; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $i++;
                                }
                                ?>
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

<?php $this->load->view('vitals_footer.php', array('load_application' => 'application')); ?>

</body>
</html>