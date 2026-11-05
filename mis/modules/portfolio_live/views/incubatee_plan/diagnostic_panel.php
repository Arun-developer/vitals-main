<?php
$innovation = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $innovation['name_of_enterprise'];

$meeting = $dp_data[0];
$reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Plan', 'company_name' => $company_name, 'port_action' => 'plan', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'fin_year' => $current_financial, 'add_class' => 'mar-tp140'));

$get_plan = json_decode($meeting['dp_plan']);
$get_external = json_decode($meeting['dp_external']);
$field_enable = '0';
?>

<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <?php if ($this->session->userdata['approve_success'] == '1') { ?>
        <div id="approveMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Diagnostic Panel details approved successfully</div>
    <?php } ?>
    <?php if ($this->session->userdata['approve_success'] == '2') { ?>
        <div id="approveallMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;All plan details are approved successfully</div>
    <?php } ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab"  href="<?= base_url() . 'index.php/portfolio/company_data/' . $innovation_id; ?>"  aria-selected="false">Company Master Data</a>
                        <a class="nav-item nav-link filled-data" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/business_nature/' . $innovation_id; ?>" aria-controls="nav-business" aria-selected="false">Nature of business</a>
                        <a class="nav-item nav-link filled-data" id="nav-management-tab"  href="<?= base_url() . 'index.php/portfolio/management/' . $innovation_id; ?>" aria-controls="nav-management" aria-selected="false">Management</a>
                        <a class="nav-item nav-link filled-data" id="nav-governance-tab"  href="<?= base_url() . 'index.php/portfolio/governance/' . $innovation_id; ?>" aria-controls="nav-governance" aria-selected="false">Governance</a>
                        <a class="nav-item nav-link filled-data" id="nav-relationship-tab" href="<?= base_url() . 'index.php/portfolio/villgro_relationship/' . $innovation_id; ?>" aria-controls="nav-relationship" aria-selected="false">Villgro Relationship Details</a>
                        <a class="nav-item nav-link filled-data" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/incubation_relationship/' . $innovation_id; ?>"   aria-controls="nav-incubation" aria-selected="false">Incubation Relationship</a>
                        <a class="nav-item nav-link filled-data" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/cap_table/' . $innovation_id; ?>"   aria-controls="nav-cap" aria-selected="false">Cap Table</a>
                        <a class="nav-item nav-link filled-data" id="nav-interested-tab" href="<?= base_url() . 'index.php/portfolio/interested_parties/' . $innovation_id; ?>" aria-controls="nav-interested" aria-selected="false">Other Interested Parties</a>
                        <a class="nav-item nav-link brd-none" id="nav-about-tab"  href="#nav-about"  aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                        <a class="nav-item nav-link dataConfig active" id="nav-dataconfig-tab"  href="javascript:void(0);" role="tab" aria-controls="nav-dataconfig" aria-selected="false">Plan Setup</a>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-business" role="tabpanel" aria-labelledby="nav-business-tab">
                        <div class="tabpanel-title">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <h4>Define the annual plan for <?= $company_name; ?></h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right">
                                    <ul class="milestone-links">
                                        <?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && ($approvals[0]['product_approval'] == 2 || $approvals[0]['sales_approval'] == 2 || $approvals[0]['channel_approval'] == 2 || $approvals[0]['pipeline_approval'] == 2 || $approvals[0]['revenue_approval'] == 2 || $approvals[0]['netprofit_approval'] == 2 || $approvals[0]['vif_approval'] == 2 || $approvals[0]['fundraise_approval'] == 2 || $approvals[0]['mentor_approval'] == 2 || $approvals[0]['tap_approval'] == 2 || $approvals[0]['nontap_approval'] == 2 || $approvaless[0]['dp_approval'] == 2 || $approvaless[0]['board_approval'] == 2 || $approvaless[0]['team_approval'] == 2 || $approvals[0]['impact_approval'] == 2 || $approvals[0]['project_approval'] == 2)) { ?>
                                            <li><a class="approveall" href="javascript:void(0);">Approve All</a></li>
                                        <?php } ?>
                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                            <li><a class="saveContinue" href="javascript:void(0);">Save</a></li>
                                            <?php
                                            $field_enable = '1';
                                        }
                                        ?>
                                        <?php if ($this->session->userdata['sector_lead'] == 1 && $isAssociate == 1 && $approvals[0]['config_approval'] == 1) { ?>
                                            <li><a class="sendApprovalBtn" id="lead_approveall" href="javascript:void(0);">Send for Approval</a></li>
                                        <?php } else if (($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['config_approval'] == 1) { ?>
                                            <li><a class="sendApproval sendApprovalBtn" id="sendApproval" href="javascript:void(0);">Send for Approval</a></li>
<?php } ?>
                                        <li>
                                            <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend"><i class="far fa-question-circle"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tabpanel-detailsconfig config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <div id="leftMenuLoad">
<?php $this->load->view('config_left_menu.php', array('class_name' => 'panelDiv', 'configData' => $dataConfig, 'approvals' => $approvals, 'fin_year' => $current_financial)); ?>
                            </div>
                            <main class="page-content" id="pageContent">
                                <div class="row dataconfig">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad0">
                                        <h4>Diagnostic Panels</h4>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                        <div class="config-sales">
                                            <label>Financial Year</label>
                                            <div class="form-group">
                                                <select class="form-control form-control-sm" name="financial_year" id="financial_year" onchange="loadYear(this.value);">
                                                    <?php
                                                    foreach ($fin_year as $year) {
                                                        $nxt_fyear = $year['fin_year'] + 1;
                                                        ?>
                                                        <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_financial) && $current_financial == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
<?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-slider--container innerTabsPlansetup">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <div class="inputplan-structureall plan-structure-new wdt-100">
                                            <form method="post" id="meetingForm" action="<?php echo base_url() . 'index.php/portfolio/addDiagnosticPanel'; ?>" autocomplete="off">
                                                <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                <input type='hidden' name='cur_finance' id="cur_finance" value="<?= $current_financial; ?>">
                                                <input type='hidden' name='updatePlan' id="updatePlan" value="0">
                                                <input type='hidden' name='module_id' id="module_id" value="12">

                                                <div class="Plan-structure">
                                                    <div class="quaterlyNewplanstru">
													
													<div class="row">
                                                            <div class="col-xl-7 col-md-7 col-lg-7 col-12">
                                                                <div class="quaterlyNewplanstru">
                                                                    <!--<h4>Diagnostic Panel Targets</h4>-->
                                                                </div>
                                                            </div>
                                                           <?php  /* <div class="col-xl-5 col-md-5 col-lg-5 col-12">
                                                                <div class="quaterlyNewplanstru">
                                                                    <div class="text-right" id='editSec'>
                                                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                            <a href="javascript:void(0)" class="edit-btnconfig mar-bt15 display-block mar-rt5" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a>
<?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div> */ ?>
                                                        </div>
														
														
															<?php /* <div class="quaterlyNewplanstru">
															  <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                                <?php if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['dp_approval'] == 2) { ?>
                                                                    <h4>Diagnostic Panel Targets <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                                <?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['dp_approval'] == 3) { ?>
                                                                    <h4>Diagnostic Panel Targets <span class="text-success"><small>(Approved)</small></span></h4>
                                                                <?php } else { ?>
                                                                    <h4>Diagnostic Panel Targets</h4>
                                                            <?php } ?>
                                                            </div>
<?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['dp_approval'] == 2) { ?>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right">
                                                                    <div class="approved-btn text-right">
                                                                        <button type="button" class="btn btn-success capitilize">Approve</button>
                                                                        <div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<?php } ?>
                                                        </div>
														</div>
														<br> */ ?>
														<div class="quaterlyNewplanstru">
															  <div class="row">
                                                            <div class="col-xl-12 col-lg-6 col-md-6 col-12" style="display:flex;">
                                                                <?php if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['dp_approval'] == 2) { ?>
                                                                    <h4>Diagnostic Panel Targets <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                                <?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['dp_approval'] == 3) { ?>
                                                                    <h4>Diagnostic Panel Targets <span class="text-success"><small>(Approved)</small></span></h4>
                                                                <?php } else { ?>
                                                                    <h4>Diagnostic Panel Targets</h4>
                                                            <?php } ?>
															<?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['dp_approval'] == 2) { ?>
                                                                 <!--<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right">-->
                                                                    <div class="approved-btn text-right">
                                                                        <button type="button"  style="margin-left: 5px;margin-top: -14px;" class="btn btn-success capitilize">Approve</button>
                                                                        <div>
                                                                        </div>
                                                                    </div>
                                                                 <!--</div> -->
<?php } ?>
<div class="text-right" id='editSec'  style="margin-left: auto; ">
                                                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                            <a href="javascript:void(0)" class="edit-btnconfig mar-bt15 display-block mar-rt5" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a>
<?php } ?>
                                                                    </div>
																	
                                                            </div>

                                                        </div>
														</div>
														
														
														

                                                        <div class=" table_configcontentnew">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="40%">Period</th>
                                                                        <th width="15%"class="text-center">Q1</th>
                                                                        <th width="15%"class="text-center">Q2</th>
                                                                        <th width="15%"class="text-center">Q3</th>
                                                                        <th width="15%"class="text-center">Q4</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="vill-gray">No of Diagnostic Panel</td>
                                                                        <td>
                                                                            <input type="text" name="dp_one" value="<?= $get_plan->q1; ?>" class="form-control form-control-sm volumefld" maxlength="2" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="dp_two" value="<?= $get_plan->q2; ?>" class="form-control form-control-sm volumefld" maxlength="2" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                        <td >
                                                                            <input type="text" name="dp_three" value="<?= $get_plan->q3; ?>" class="form-control form-control-sm volumefld" maxlength="2" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="dp_four" value="<?= $get_plan->q4; ?>" class="form-control form-control-sm volumefld" maxlength="2" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="vill-gray">No of External Panel Members</td>
                                                                        <td>
                                                                            <input type="text" name="ext_one" value="<?= $get_external->q1; ?>" class="form-control form-control-sm volumefld" maxlength="2" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="ext_two" value="<?= $get_external->q2; ?>" class="form-control form-control-sm volumefld" maxlength="2" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                        <td >
                                                                            <input type="text" name="ext_three" value="<?= $get_external->q3; ?>" class="form-control form-control-sm volumefld" maxlength="2" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="ext_four" value="<?= $get_external->q4; ?>" class="form-control form-control-sm volumefld" maxlength="2" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
														
														
														<hr><br><br>
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                                <?php /*  if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['dp_approval'] == 2) { ?>
                                                                    <h4>Diagnostic Panel Plan <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                                <?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['dp_approval'] == 3) { ?>
                                                                    <h4>Diagnostic Panel Plan <span class="text-success"><small>(Approved)</small></span></h4>
                                                                <?php } else { ?>
                                                                    <h4>Diagnostic Panel Plan</h4>
                                                            <?php } */ ?>
															 <h4>Diagnostic Panel Plan</h4>
                                                            </div>
<?php /* if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['dp_approval'] == 2) { ?>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right">
                                                                    <div class="approved-btn text-right">
                                                                        <button type="button" class="btn btn-success capitilize">Approve</button>
                                                                        <div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<?php } */ ?>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6">
                                                                <p>Q1 (<?= $get_month_list[0] . '-' . $get_month_list[2] . ' ' . $current_financial; ?>)</p>
                                                                <div class="quaterlyCardnew" id="qOne_active">
                                                                    <textarea rows="3" class="mceEditor" id="txtQuarterOne" name="qOneDesc" placeholder="Enter quarterly plan details in here"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['q_one_desc'])); ?></textarea>
                                                                    <div class="tabset1" onclick="highlightQuarter('qOne_active');">
                                                                        <input type="radio" name="tabset1" id="tab4" aria-controls="Apr" checked >
                                                                        <label for="tab4"><?= $get_month_list[0]; ?></label>
                                                                        <input type="radio" name="tabset1" id="tab2" aria-controls="May" >
                                                                        <label for="tab2"><?= $get_month_list[1]; ?></label>
                                                                        <input type="radio" name="tabset1" id="tab3" aria-controls="Jun" >
                                                                        <label for="tab3"><?= $get_month_list[2]; ?></label>
                                                                        <div class="tab-panels">
                                                                            <section class="tab-panel" id="Apr">
                                                                                <div class="aprBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtApril" name='<?= strtolower($get_month_list[0]) . 'Content'; ?>' placeholder="Plan for April"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[0]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section class="tab-panel" id="May">
                                                                                <div class="mayBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtMay" name='<?= strtolower($get_month_list[1]) . 'Content'; ?>' placeholder="Plan for May"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[1]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section class="tab-panel" id="Jun">
                                                                                <div class="junBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtJune" name='<?= strtolower($get_month_list[2]) . 'Content'; ?>' placeholder="Plan for June"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[2]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6">
                                                                <p>Q2 (<?= $get_month_list[3] . '-' . $get_month_list[5] . ' ' . $current_financial; ?>)</p>
                                                                <div class="quaterlyCardnew" id="qTwo_active">
                                                                    <textarea rows="3" class="mceEditor" id="txtQuarterTwo" name="qTwoDesc" placeholder="Enter quarterly plan details in here"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['q_two_desc'])); ?></textarea>
                                                                    <div class="tabset2" onclick="highlightQuarter('qTwo_active');">
                                                                        <input type="radio" name="tabset2" id="tab5" aria-controls="Jul" checked >
                                                                        <label for="tab5"><?= $get_month_list[3]; ?></label>
                                                                        <input type="radio" name="tabset2" id="tab6" aria-controls="Aug" >
                                                                        <label for="tab6"><?= $get_month_list[4]; ?></label>
                                                                        <input type="radio" name="tabset2" id="tab7" aria-controls="Sep" >
                                                                        <label for="tab7"><?= $get_month_list[5]; ?></label>

                                                                        <div class="tab-panels">
                                                                            <section id="Jul" class="tab-panel">
                                                                                <div class="julBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtJuly" name='<?= strtolower($get_month_list[3]) . 'Content'; ?>' placeholder="Plan for July"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[3]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section id="Aug" class="tab-panel">
                                                                                <div class="augBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtAugust" name='<?= strtolower($get_month_list[4]) . 'Content'; ?>' placeholder="Plan for August"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[4]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section id="Sep" class="tab-panel">
                                                                                <div class="sepBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtSeptember" name='<?= strtolower($get_month_list[5]) . 'Content'; ?>' placeholder="Plan for September"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[5]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6">
                                                                <p>Q3 (<?= $get_month_list[6] . '-' . $get_month_list[8] . ' ' . $current_financial; ?>)</p>
                                                                <div class="quaterlyCardnew" id="qThree_active">
                                                                    <textarea rows="3" class="mceEditor" id="txtQuarterThree" name="qThreeDesc" placeholder="Enter quarterly plan details in here"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['q_three_desc'])); ?></textarea>
                                                                    <div class="tabset3" onclick="highlightQuarter('qThree_active');">
                                                                        <input type="radio" name="tabset3" id="tab8" aria-controls="Oct" checked >
                                                                        <label for="tab8"><?= $get_month_list[6]; ?></label>
                                                                        <input type="radio" name="tabset3" id="tab9" aria-controls="Nov" >
                                                                        <label for="tab9"><?= $get_month_list[7]; ?></label>
                                                                        <input type="radio" name="tabset3" id="tab10" aria-controls="Dec" >
                                                                        <label for="tab10"><?= $get_month_list[8]; ?></label>

                                                                        <div class="tab-panels">
                                                                            <section id="Oct" class="tab-panel">
                                                                                <div class="octBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtOctober" name='<?= strtolower($get_month_list[6]) . 'Content'; ?>' placeholder="Plan for October"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[6]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section id="Nov" class="tab-panel">
                                                                                <div class="novBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtNovember" name='<?= strtolower($get_month_list[7]) . 'Content'; ?>' placeholder="Plan for November"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[7]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section id="Dec" class="tab-panel">
                                                                                <div class="decBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtDecember" name='<?= strtolower($get_month_list[8]) . 'Content'; ?>' placeholder="Plan for December"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[8]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6">
															<?php 
																$currentFinYear = current_FYendYear($this->session->userdata('partner_id'));
																$current_FYstartYear = current_FYstartYear($this->session->userdata('partner_id'));
																if($currentFinStartYear!=Date('Y')){
																	$currentFinYear = $current_financial+1;
																}
															?>
															<p>Q4 (<?= $get_month_list[9] . '-' . $get_month_list[11] . ' ' . $currentFinYear; ?>)</p>
                                                                <?php /*<p>Q4 
																
																 (<?= $get_month_list[9] . '-' . $get_month_list[11] . ' ' . current_FYendYear($this->session->userdata('partner_id')); ?>) </p> */
																?>
																
                                                                <div class="quaterlyCardnew" id="qFour_active">
                                                                    <textarea rows="3" class="mceEditor" id="txtQuarterFour" name="qFourDesc" placeholder="Enter quarterly plan details in here"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['q_four_desc'])); ?></textarea>
                                                                    <div class="tabset4" onclick="highlightQuarter('qFour_active');">
                                                                        <input type="radio" name="tabset4" id="tab11" aria-controls="Jan" checked >
                                                                        <label for="tab11"><?= $get_month_list[9]; ?></label>
                                                                        <input type="radio" name="tabset4" id="tab12" aria-controls="Feb" >
                                                                        <label for="tab12"><?= $get_month_list[10]; ?></label>
                                                                        <input type="radio" name="tabset4" id="tab13" aria-controls="Mar" >
                                                                        <label for="tab13"><?= $get_month_list[11]; ?></label>

                                                                        <div class="tab-panels">
                                                                            <section id="Jan" class="tab-panel">
                                                                                <div class="janBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtJanuary" name='<?= strtolower($get_month_list[9]) . 'Content'; ?>' placeholder="Plan for January"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[9]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section id="Feb" class="tab-panel">
                                                                                <div class="febBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtFebruary" name='<?= strtolower($get_month_list[10]) . 'Content'; ?>' placeholder="Plan for February"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[10]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section id="Mar" class="tab-panel">
                                                                                <div class="marBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtMarch" name='<?= strtolower($get_month_list[11]) . 'Content'; ?>' placeholder="Plan for March"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[11]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
														
														
														
														
														
                                                    </div>
                                                </div>
                                            </form>
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
</div>
</div>

<input type="hidden" id="planBox" value="<?= $this->session->userdata['plan_lightbox']; ?>">

<div class="modal" id="planModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content data_congifpopup">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel"><span class="text-success"><i
                            class="fas fa-check-circle"></i></span> Successfully updated the plan</h5>
            </div>
            <div class="modal-body onboarding-permission text-center">
                <ul>
                    <li>You have successfully saved & updated the plan for <br>"<strong><span>
                                <?php
                                echo ucfirst($company_name) . ', ';
                                if ($reg_city != '') {
                                    echo ucfirst($reg_city) . ', ';
                                }
                                if ($sector_name != '') {
                                    echo ucfirst($sector_name);
                                }
                                ?>
                            </span></strong>"</li>
                </ul>
                <div class="popup-content-final popup-content">
                    <a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Later</a>
                    <a class="btn btn-configure" data-toggle="modal" data-target="#sendapproval">Send for Approval Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- approval send modal -->
<div class="modal" id="sendapproval" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content data_congifpopup">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel"><span class="text-success"><i
                            class="fas fa-check-circle"></i></span> Sending for Approval</h5>
            </div>
            <div class="modal-body onboarding-permission text-center">
                <ul>
                    <li>The updated plan for <?= $company_name; ?> will now be sent to <?= $sector_lead[0]['emp_names']; ?> for approval. Click Okay to proceed.</li>
                </ul>
                <div class="popup-content-final popup-content">
                    <a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a>
                    <a class="btn btn-configure " href="javascript:void(0)" onclick="sendApproval();">Okay</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$obj_plan = json_decode($meeting['dp_plan'], true);
$obj_ext = json_decode($meeting['dp_external'], true);
if (!array_filter($obj_plan) && !array_filter($obj_ext)) {
    $enable = 0;
} else {
    $enable = 1;
}
$this->session->set_userdata('plan_lightbox', 0);
$this->session->set_userdata('approve_success', 0);

$month_id = '';
$current_month = date('n');
if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
    $month_id = 'qFour_active';
} else if ($current_month == '4' || $current_month == '5' || $current_month == '6') {
    $month_id = 'qOne_active';
} else if ($current_month == '7' || $current_month == '8' || $current_month == '9') {
    $month_id = 'qTwo_active';
} else if ($current_month == '10' || $current_month == '11' || $current_month == '12') {
    $month_id = 'qThree_active';
}
?>
<input type="hidden" id="active_editor" value="<?= $month_id; ?>">
<input type="hidden" id="enableCount" value="<?= $enable; ?>">

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio', 'quantitative' => 'tiny')); ?>

<script type="text/javascript">

    $(window).on("load", function () {
        ($("iframe").contents().click(function (event) {
            $('.quaterlyCardnew').removeClass('greenplantxt');
            if (event.target.localName == 'html') {
                var div_id = event.target.childNodes[1].attributes["0"].ownerElement.dataset.id
            } else if (event.target.localName == 'body') {
                var div_id = event.target.dataset.id;
            } else {
                var div_id = event.target.offsetParent.attributes["0"].ownerElement.dataset.id;
            }

            if (div_id == 'txtQuarterOne' || div_id == 'txtApril' || div_id == 'txtMay' || div_id == 'txtJune') {
                $("#qOne_active").addClass("greenplantxt");
            } else if (div_id == 'txtQuarterTwo' || div_id == 'txtJuly' || div_id == 'txtAugust' || div_id == 'txtSeptember') {
                $("#qTwo_active").addClass("greenplantxt");
            } else if (div_id == 'txtQuarterThree' || div_id == 'txtOctober' || div_id == 'txtNovember' || div_id == 'txtDecember') {
                $("#qThree_active").addClass("greenplantxt");
            } else if (div_id == 'txtQuarterFour' || div_id == 'txtJanuary' || div_id == 'txtFebruary' || div_id == 'txtMarch') {
                $("#qFour_active").addClass("greenplantxt");
            }
        }));
        // $('svg').attr("viewBox", "0 0 25 25");
        // $('svg').css({"width": "20", "height": "20"});
    });

    function highlightQuarter(id) {
        $('.quaterlyCardnew').removeClass('greenplantxt');
        $("#" + id).addClass("greenplantxt");
    }

    tinyMCE.init({
        mode: "specific_textareas",
        editor_selector: "mceEditor",
        entity_encoding: "numeric",
        menubar: false,
        plugins: [
            'lists'
        ],
        toolbar: [
            'bold italic | numlist bullist'
        ],
        valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li,br',
        powerpaste_word_import: 'clean',
        powerpaste_html_import: 'clean'
    });

    $(document).ready(function () {
        var cur_mnth = $('#active_editor').val();
        if (cur_mnth != '')
            highlightQuarter(cur_mnth);

        var editOpt = $('#enableCount').val();
        var enable_form = "<?= $field_enable; ?>";
        if (editOpt > 0 || enable_form == 0) {
            /*$('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').css("pointer-events", "none");
            $('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').addClass('opacity5');*/
            $('input[type="text"]').attr('readonly', 'readonly');
        }
        $('#editBtn').addClass('opacity5');
        var popup = $('#planBox').val();
        //                                    if (popup == 1) {
        //                                        $('#planModal').modal('show');
        //                                    } else {
        //                                        $('#planModal').modal('hide');
        //                                    }

        setTimeout(function () {
            $('#approveMsg').hide();
            $('#approveallMsg').hide();
        }, 3000);
    });
    var _changeInterval = null;
    $(".volumefld").on("input", function (evt) {
        if ($(this).val() > 90) {
            $(this).val('');
            $(this).next('label').text('Value should be less than 90');
            clearInterval(_changeInterval);
            _changeInterval = setInterval(function () {
                // Typing finished, now you can Do whatever after 2 sec
                $('.error_msg').text('');
                clearInterval(_changeInterval);

            }, 3000);
        }

        var self = $(this);
        if (self.val() != 0 || self.val() == '') {
            self.val(self.val().replace(/[^0-9]/g, ''));
        } else {
            self.val(0);
        }
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
            evt.preventDefault();
        }
    });

    $(document).on('click', '#sendApproval', function () {
        $('#sendapproval').modal('show');
    });

    function sendApproval() {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#cur_finance').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/sendapproval",
            data: {
                fin_year: fin_year,
                invid: inv_id,
                table: 'port_config_approval'
            },
            dataType: 'json',
            success: function (msg) {
                if (msg == '1') {
                    location.reload();
                }
            }
        });
    }


    $(document).on('click', '#editBtn', function () {
        $('#editSec').html('<a href="javascript:void(0)" class="edit-btnconfig mar-bt15 display-block mar-rt5" id="cancelBtn"><i class="fas fa-times"></i> Cancel</a>');
        $('.saveContinue').text('Save');
        $('#updatePlan').val('1');
        $('input[type="text"]').attr('readonly', false);
        $('#editBtn').removeClass('opacity5');
    });

    $(document).on('click', '#cancelBtn', function () {
        $('#editSec').html('<a href="javascript:void(0)" class="edit-btnconfig mar-bt15 display-block mar-rt5" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a>');
        $('.saveContinue').text('Save');
        $('#updatePlan').val('0');
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('input[type="text"]').attr('readonly', 'readonly');
        }
        $('#editBtn').addClass('opacity5');
    });

    $(".saveContinue").on('click', function (e) {
        if ($('#meetingForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#meetingForm').submit();
            e.preventDefault();
        }
    });

    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/diagnosticpanel/' + inv_id + '/' + year;
    }

    $(document).on('click', '.capitilize', function () {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#cur_finance').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/panelApproved",
            data: {
                inv_id: inv_id,
                fin_year: fin_year
            },
            dataType: 'json',
            success: function (msg) {
                location.reload();
            }
        });
    });

    $(document).on('click', '.approveall', function () {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#cur_finance').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/ApproveAll",
            data: {
                inv_id: inv_id,
                fin_year: fin_year
            },
            dataType: 'json',
            success: function (msg) {
                //                                                    $('#pageContent').load(location.href + ' #pageContent');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        });
    });

    $(document).on('click', '#lead_approveall', function () {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#cur_finance').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/sectorLead_sendApproval",
            data: {
                inv_id: inv_id,
                fin_year: fin_year
            },
            dataType: 'json',
            success: function (msg) {
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        });
    });

</script>

</body>
</html>