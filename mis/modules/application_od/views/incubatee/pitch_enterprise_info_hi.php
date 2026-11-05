<?php
$this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $enterprise_information[0]['name_of_enterprise'] . ' - Enterprise Info'));
require_once ("./language/lang_hi.php");
require_once ("./language/state_city_hi.php");
?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $enterprise_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $enterprise_information[0]['name_of_enterprise'], 'app_stage' => $enterprise_information[0]['stage'], 'program' => $enterprise_information[0]['program'], 'doc1' => $enterprise_information[0]['doc1'], 'doc2' => $enterprise_information[0]['doc2'], 'lang_code' => $lang_code)); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id . '/hi'; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id . '/hi'; ?>">Team Information</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id . '/hi'; ?>">Information About The Enterprise</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id . '/hi'; ?>">Impact of Innovation</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id . '/hi'; ?>">Additional Information</a></li>
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
                                            <label>आपका व्यवसाय इनमें से कौन सा संगठन है</label>
                                            <?php
                                            $entType = '';
                                            if ($enterprise_information[0]['ent_type'] == 'profit') {
                                                $entType = ' लाभ के लिए संगठन';
                                            } else if ($enterprise_information[0]['ent_type'] == 'nonprofit') {
                                                $entType = 'गैर लाभकारी संगठन';
                                            }
                                            ?>
                                            <input type="text" class="form-control" value="<?= $entType; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>क्या आपकी कंपनी MCA के तहत पंजीकृत है?</label>
                                            <?php
                                            if ($enterprise_information[0]['company_register'] == 'yes') {
                                                $reg_no = $lang[lcfirst($enterprise_information[0]['company_register'])] . ' - ' . $enterprise_information[0]['cin_number'];
                                            } else {
                                                $reg_no = $lang[lcfirst($enterprise_information[0]['company_register'])];
                                            }
                                            ?>
                                            <input type="text" class="form-control" value="<?= $reg_no; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>निगमन का वर्ष</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['incorporation_year']; ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>DIPP पंजीकरण</label>
                                            <?php
                                            if ($enterprise_information[0]['dipp_register'] == 'yes') {
                                                $dipp_no = $lang[lcfirst($enterprise_information[0]['dipp_register'])] . ' - ' . $enterprise_information[0]['dipp_number'];
                                            } else {
                                                $dipp_no = $lang[lcfirst($enterprise_information[0]['dipp_register'])];
                                            }
                                            ?>
                                            <input type="text" class="form-control" value="<?= $dipp_no; ?>" disabled />
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>मुख्यालय का राज्य / केन्द्र शासित प्रदेश</label>
                                            <input type="text" class="form-control" value="<?php
                                            $underscore_val = strtolower(preg_replace('/\s+/', '_', $enterprise_information[0]['state_name']));
                                            echo $lang[$underscore_val];
                                            ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>मुख्यालय का शहर</label>
                                            <input type="text" class="form-control" value="<?php
                                            $underscore_vall = strtolower(preg_replace('/\s+/', '_', $enterprise_information[0]['city_name']));
                                            echo $lang[$underscore_vall];
                                            ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>ऑपरेशन या संचालन का स्तर</label>
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
                                            <label>क्षेत्र</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['sector_name']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>उप क्षेत्र</label>
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
                                            <label>एसडीजी जो आपके नवाचार/आविष्कार से मेल खाते हैं</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['sdg_aligns']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>आपके द्वारा दिए जाने वाले समाधान का सबसे अच्छा वर्णन क्या होगा</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['describe_solution_hi']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>क्या आपकी कंपनी की कोई वेबसाइट है? </label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['website']; ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>कंपनी का राजस्व या रेवेन्यू: 2020-21</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['fy_20_21']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>कंपनी का राजस्व या रेवेन्यू: 2019-20</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['fy_19_20']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>कंपनी का राजस्व या रेवेन्यू: 2018-19</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['fy_18_19']; ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>म क्या आपने अतीत में धन जुटाया है?</label>
                                            <input type="text" class="form-control" value="<?= $lang[lcfirst($enterprise_information[0]['past_fund'])]; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>कुल इक्विटी राशि</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['grant_amount']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>कुल इक्विटी राशि</label>
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
                                            <label>What is the range of funding you are looking for?</label>
                                            <input type="text" class="form-control" value="<?= $enterprise_information[0]['funding_range']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>क्या आपकी कंपनी को किसी संस्थान द्वारा इनक्यूबेट / त्वरित किया गया है?</label>
                                            <input type="text" class="form-control" value="<?= $lang[lcfirst($enterprise_information[0]['accelerate_type'])]; ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>यदि हां, तो इनक्यूबेटर/त्वरक का नाम और भागीदारी का वर्ष निर्दिष्ट करें।</label>
                                            <textarea class="form-control" disabled ><?= $enterprise_information[0]['incubated_accelerated_hi']; ?></textarea>
                                        </div>
                                    </div>
                                    <?php if (($stage_operation == 'Commercial Piloting / Initial Paying Customers' || $stage_operation == 'Scaling up / Rapid sales growth') && $enterprise_information[0]['sub_sector'] == '16') { ?>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>आपके द्वारा दिए जाने वाले समाधान का सबसे अच्छा वर्णन क्या होगा?</label>
                                                <textarea class="form-control" disabled ><?= $enterprise_information[0]['saved_water']; ?></textarea>
                                            </div>
                                        </div>
                                    <?php } ?>
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