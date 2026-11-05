<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $enterprise_information[0]['name_of_enterprise'] . ' - Enterprise Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $enterprise_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $enterprise_information[0]['name_of_enterprise'], 'app_stage' => $enterprise_information[0]['stage'], 'program' => $enterprise_information[0]['program'], 'doc1' => $enterprise_information[0]['doc1'], 'doc2' => $enterprise_information[0]['doc2'], 'doc3' => $enterprise_information[0]['doc3'])); ?>
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
                    <div id="tab1" class="tab-slider--body pad-none tab-pane userActiveSetupNew active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="enterpriseForm" action="<?php echo base_url() . 'index.php/application/add_enterprise_details'; ?>" autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <input type="hidden" name="inv_user_id" value="<?= $enterprise_information[0]['inv_user_id']; ?>">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>DPIIT Recognition Number</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['reco_no']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>TANSIM Registration Number</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['pilots']; ?>"/>
                                            </div>
                                        </div>
                                        <?php
                                        $reg_date = isset($enterprise_information[0]['org_reg_date']) && $enterprise_information[0]['org_reg_date'] != '0000-00-00' ? date("d-M-y", strtotime($enterprise_information[0]['org_reg_date'])) : '-';
                                        ?>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Date of registration of your startup</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $reg_date; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Corporate Identity Number</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['cin']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>PAN Number</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['pan']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>State</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['state_name']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['city']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Pin code</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['pincode']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Is your startup incubated/was incubated at any startup incubation center?</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['tech_challege']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Provide the Incubation Center name</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['vill_support']; ?>"/>
                                            </div>
                                        </div>
                                        <?php
                                        $incubated_date = isset($enterprise_information[0]['date_from_incubated']) && $enterprise_information[0]['date_from_incubated'] != '0000-00-00' ? date("d-M-y", strtotime($enterprise_information[0]['date_from_incubated'])) : '-';
                                        ?>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Date from which incubated</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $incubated_date; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Website URL</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['website_url']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Social media links</label>
                                                <input type="text" disabled class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['social_media']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Where is your company based?</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['org_short_desc']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['address']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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

<style type="text/css">
    .ui-multiselect.ui-helper-clearfix.ui-widget {
        width: 100% !important;
    }
    .ui-multiselect.ui-helper-clearfix.ui-widget .selected,.ui-multiselect.ui-helper-clearfix.ui-widget .available{
        width: 50% !important;
    }
    .ui-multiselect.ui-helper-clearfix.ui-widget .selected .selected.connected-list.ui-sortable,.ui-multiselect.ui-helper-clearfix.ui-widget .available .available.connected-list{
        width: 100% !important;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('load_application' => 'application', 'page_load' => 'drag_multiselect')); ?>


<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.toaster.js'; ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.toast').toast('show');
    });
</script>

</body>
</html>