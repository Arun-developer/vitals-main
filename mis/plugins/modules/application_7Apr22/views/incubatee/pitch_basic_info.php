<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $basic_information[0]['name_of_enterprise'] . ' - Basic Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $basic_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $basic_information[0]['name_of_enterprise'], 'app_stage' => $basic_information[0]['stage'], 'program' => $basic_information[0]['program'], 'doc1' => $basic_information[0]['doc1'], 'doc2' => $basic_information[0]['doc2'])); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Information About The Enterprise</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">Impact of Innovation</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container tab-content">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Innovation ID</label>
                                            <?php
                                            if ($basic_information[0]['copy_partner_id'] == '') {
                                                $inv_id = $basic_information[0]['copy_id'] . "_" . $basic_information[0]['partner_id'] . "_" . $basic_information[0]['partner_count'];
                                            } else {
                                                $inv_id = $basic_information[0]['copy_id'] . "_" . $basic_information[0]['copy_partner_id'] . "_" . $basic_information[0]['partner_count'];
                                            }
                                            ?>
                                            <input type="text" class="form-control" value="<?= $inv_id; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Name of the Organisation</label>
                                            <input type="text" class="form-control" value="<?= $basic_information[0]['name_of_enterprise']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Name of the Applicant</label>
                                            <input type="text" class="form-control" value="<?= $basic_information[0]['name_of_entrepreneur']; ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Partner</label>
                                            <input type="text" class="form-control" value="<?= $basic_information[0]['partner_name']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Program</label>
                                            <input type="text" class="form-control" disabled value="<?= $program_name; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Source</label>
                                            <?php
                                            $userName = $this->Mapplication->getEmpFirstName($basic_information[0]['created_by']);
                                            $source_type = array('0', '123', '124', '125', '126', '127', '128', '129', '130');
                                            if (in_array($basic_information[0]['source'], $source_type)) {
                                                $source = 'Website - ' . $basic_information[0]['source_name'];
                                            } else if ($basic_information[0]['source'] == '2') {
                                                $source = 'Imported';
                                            } else {
                                                $source = 'Added by' . " " . $userName[0]['emp_first_name'];
                                            }
                                            ?>
                                            <input type="text" class="form-control" value="<?= $source; ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Language</label>
                                            <?php
                                            if ($basic_information[0]['lang_code'] == 'hi') {
                                                $app_lang = 'Hindi';
                                            } else {
                                                $app_lang = 'English';
                                            }
                                            ?>
                                            <input type="text" class="form-control" value="<?= $app_lang; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Designation of the Applicant</label>
                                            <input type="text" class="form-control" value="<?= $basic_information[0]['designation']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Gender of Applicant</label>
                                            <input type="text" class="form-control" value="<?= ucfirst($basic_information[0]['gender']); ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input type="text" class="form-control" value="<?= $basic_information[0]['email']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Mobile Number</label>
                                            <input type="text" class="form-control" value="<?= $basic_information[0]['mobileno']; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Alternate Phone Number</label>
                                            <input type="text" class="form-control" value="<?= ucfirst($basic_information[0]['altmobileno']); ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Registered Date</label>
                                            <?php
                                            $re_date = isset($basic_information[0]['reg_date']) && $basic_information[0]['reg_date'] != '0000-00-00' ? date("d-M-y", strtotime($basic_information[0]['reg_date'])) : '-';
                                            ?>
                                            <input type="text" class="form-control" value="<?= $re_date; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Submitted Date</label>
                                            <?php
                                            $sub_date = isset($basic_information[0]['submitted_date']) && $basic_information[0]['submitted_date'] != '0000-00-00' ? date("d-M-y", strtotime($basic_information[0]['submitted_date'])) : '-';
                                            ?>
                                            <input type="text" class="form-control" value="<?= $sub_date; ?>" disabled />
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