<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $team_information[0]['name_of_enterprise'] . ' - Team Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $team_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $team_information[0]['name_of_enterprise'], 'app_stage' => $team_information[0]['stage'], 'program' => $team_information[0]['program'], 'doc1' => $team_information[0]['doc1'], 'doc2' => $team_information[0]['doc2'])); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team Information</a></li>
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
                                <?php if (php72_cmp($team_information[0]['program']) == 3) { ?>
                                    <h5>Management Team Details</h5>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>No. of Male</label>
                                                <input type="text" class="form-control" value="<?= $team_information[0]['male_numb']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>No. of Female</label>
                                                <input type="text" class="form-control" value="<?= $team_information[0]['female_numb']; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>No. of Transgender</label>
                                                <input type="text" class="form-control" value="<?= $team_information[0]['transgender_numb']; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Total number of Women Founders/Co-Founders with 50% or more ownership</label>
                                                <input type="text" class="form-control" value="<?= $team_information[0]['women_founder']; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if (php72_cmp($team_information[0]['program']) != 7) {
                                    $i = 0;
                                    foreach ($team_information as $team) {
                                        $j = $i + 1;
                                        ?>
                                        <h5>Team Member <?= $j; ?></h5>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" value="<?= $team['name']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control" value="<?= $team['cur_title']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>If other, specify</label>
                                                    <input type="text" class="form-control" value="<?= $team['other_title']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Email ID</label>
                                                    <input type="text" class="form-control" value="<?= $team['email']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Mobile No</label>
                                                    <input type="text" class="form-control" value="<?= $team['phone']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <input type="text" class="form-control" value="<?= ucfirst($team['gender']); ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Age</label>
                                                    <input type="text" class="form-control" value="<?= $team['age']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Highest Educational Qualification</label>
                                                    <input type="text" class="form-control" value="<?= $team['education_qualify']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>LinkedIn</label>
                                                    <input type="text" class="form-control" value="<?= $team['linkedin']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $i++;
                                    }
                                } else if (php72_cmp($team_information[0]['program']) == 7) {
                                    $i = 0;
                                    foreach ($team_information as $team) {
                                        $j = $i + 1;

                                        if (php72_cmp($j) == 4) {
                                            ?>
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Is there any team member who is between the age group 15 - 25 years?</label>
                                                        <input type="text" class="form-control" value="<?= $team['young_team']; ?>" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        if (php72_cmp($j) != 4 || (php72_cmp($j) == 4 && $team['young_team'] == 'Yes')) {
                                            ?>
                                            <h5>Team Member <?= $j; ?></h5>
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control" value="<?= $team['name']; ?>" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" class="form-control" value="<?= $team['cur_title']; ?>" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Designation</label>
                                                        <input type="text" class="form-control" value="<?= $team['cur_org']; ?>" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Email ID</label>
                                                        <input type="text" class="form-control" value="<?= $team['email']; ?>" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Mobile No</label>
                                                        <input type="text" class="form-control" value="<?= $team['phone']; ?>" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>Age</label>
                                                        <input type="text" class="form-control" value="<?= $team['age']; ?>" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (php72_cmp($j) != 4 && $team['applicant_type'] == 'Individual') { ?>
                                                <div class="row">
                                                    <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="form-group">
                                                            <label>Name of your institution</label>
                                                            <input type="text" class="form-control" value="<?= $team['institute']; ?>" disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="form-group">
                                                            <label>What type of institution are you associated with?</label>
                                                            <input type="text" class="form-control" value="<?= $team['institute_type']; ?>" disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="form-group">
                                                            <label>Give the website link of your institution</label>
                                                            <input type="text" class="form-control" value="<?= $team['  institute_link']; ?>" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="row">
                                                <div class="col-12 col-lg-4 col-md-4">
                                                    <div class="form-group">
                                                        <label>LinkedIn</label>
                                                        <input type="text" class="form-control" value="<?= $team['linkedin']; ?>" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $i++;
                                        }
                                    }
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