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
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Have you filed for any patent?</label>
                                            <?php
                                            $patent_val = '';
                                            if ($innovation_information[0]['patents'] == '1') {
                                                $patent_val = 'Yes';
                                            } else if ($innovation_information[0]['patents'] == '0' || $innovation_information[0]['patents'] == '2') {
                                                $patent_val = 'No';
                                            }
                                            ?>
                                            <input type="text" class="form-control" value="<?= $patent_val; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>If yes, what is the patent for?</label>
                                            <textarea class="form-control" name="" cols="30" rows="3" disabled><?= $innovation_information[0]['patent_desc']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Who is your customer? Provide details of upto 3 customers who are using your solution</label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['customer_details']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Have you raised funds, participated in an accelerator program, won a prize, recognition or award for your solution?</label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['ubs_other_details']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Briefly explain the problem that you are addressing.</label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['addr_problem']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Describe how your solution addresses the problem.</label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['quest_1']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>How is your solution creating social impact?</label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['ent_impact']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Does your solution directly impact Community health workers, children’s health or health centers?</label>
                                            <textarea class="form-control" name="" id="" cols="30" rows="3" disabled><?= $innovation_information[0]['quest_2']; ?></textarea>
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