<?php
$this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $innovation_information[0]['name_of_enterprise'] . ' - Innovation Info'));
require_once ("./language/lang_hi.php");
require_once ("./language/state_city_hi.php");
?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $innovation_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name_hi' => $innovation_information[0]['name_of_enterprise_hi'], 'app_stage' => $innovation_information[0]['stage'], 'program' => $innovation_information[0]['program'], 'doc1' => $innovation_information[0]['doc1'], 'doc2' => $innovation_information[0]['doc2'], 'lang_code' => $lang_code)); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id . '/hi'; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id . '/hi'; ?>">Team Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id . '/hi'; ?>">Information About The Enterprise</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id . '/hi'; ?>">Impact of Innovation</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id . '/hi'; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">

                                <?php if ($innovation_information[0]['sub_sector'] == '154' || $innovation_information[0]['sub_sector'] == '155') { ?>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>प्रस्तावित नवाचार का प्रौद्योगिकी तत्परता स्तर (TRL) क्या है?</label>
                                                <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['trl_innovation_hi']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>क्या आपके पास कोई मौजूदा साझेदारी और सहयोग है?</label>
                                                <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['partnerships_collaborations_hi']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>आपकी धारणाओं का समर्थन करने के लिए पायलट अध्ययनों के माध्यम से कौन से साक्ष्य/एविडेन्स उत्पन्न हुए हैं?</label>
                                                <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['pilot_studies_hi']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>भारतीय सार्वजनिक स्वास्थ्य सेवा अवसंरचना या निजी क्षेत्र (प्वाइंट-ऑफ-केयर, प्राथमिक/माध्यमिक/तृतीयक-स्तर) में फिट होने के लिए आपके समाधान की क्या क्षमता है?</label>
                                                <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['solution_to_fit_hi']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>आपका समाधान नैदानिक सत्यापन/ क्लिनिकल वैलिडेशन  के किस चरण में है?</label>
                                                <input type="text" class="form-control" value="<?= $innovation_information[0]['clinical_solution']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label>परियोजना की कुल लागत की तुलना में अपेक्षित निवेश राशि क्या है?</label>
                                                <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['expected_investment_amount_hi']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="row">
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>क्या आपने किसी पेटेंट के लिए आवेदन किया है?</label>
                                            <?php
                                            $patent_val = '';
                                            if ($innovation_information[0]['patents'] == '1') {
                                                $patent_val = $lang['yes'];
                                            } else if ($innovation_information[0]['patents'] == '2') {
                                                $patent_val = $lang['no'];
                                            }
                                            ?>
                                            <input type="text" class="form-control" value="<?= $patent_val; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>यदि हाँ, तो पेटेंट किसके लिए है?</label>
                                            <textarea class="form-control" name="" cols="30" rows="3" disabled><?= $innovation_information[0]['patent_desc_hi']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>क्या आपने अपने समाधान के लिए पुरस्कार, मान्यता या पुरस्कार जीता है?</label>
                                            <input type="text" class="form-control" value="<?= $lang[lcfirst($innovation_information[0]['prize_recognition'])]; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>यदि हाँ, तो विवरण निर्दिष्ट करें</label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['awards_hi']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>जिस समस्या को आप संबोधित कर रहे हैं, उसे संक्षेप में समझाएं।.</label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['addr_problem_hi']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>आपका उपाय समस्या को कैसे सुलझाता है, वर्णन करें।</label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['quest_1_hi']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>क्या आपका समाधान महिलाओं और लड़कियों को सीधे प्रभावित करता है?</label>
                                            <input type="text" class="form-control" value="<?= ucfirst($innovation_information[0]['direct_impact_status']); ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>क्या आपका समाधान महिलाओं और लड़कियों को सीधे प्रभावित करता है?</label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $lang[lcfirst($innovation_information[0]['direct_impact_sol_hi'])]; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>आपका समाधान सामाजिक प्रभाव कैसे बना रहा है?</label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['ent_impact_hi']; ?></textarea>
                                        </div>
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