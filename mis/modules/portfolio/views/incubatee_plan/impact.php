<?php
$innovation = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $innovation['name_of_enterprise'];
$reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Plan', 'company_name' => $company_name, 'port_action' => 'plan', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'fin_year' => $current_financial, 'add_class' => 'mar-tp140'));
$field_enable = '0';
?>

<!-- Inner Dashboard-->


<div class="vi-dashboard onboardtabmenu mar-tp10">
    <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Record(s) deleted successfully</div>
    <?php if ($this->session->userdata['approve_success'] == '1') { ?>
        <div id="approveMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Impact details approved successfully</div>
    <?php } ?>
    <?php if ($this->session->userdata['approve_success'] == '2') { ?>
        <div id="approveallMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;All plan details are approved successfully</div>
    <?php } ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab"
                        href="<?= base_url() . 'index.php/portfolio/company_data/' . $innovation_id; ?>"
                        aria-selected="false">Company Master Data</a>
                        <a class="nav-item nav-link filled-data" id="nav-business-tab"
                        href="<?= base_url() . 'index.php/portfolio/business_nature/' . $innovation_id; ?>"
                        aria-controls="nav-business" aria-selected="false">Nature of business</a>
                        <a class="nav-item nav-link filled-data" id="nav-management-tab"
                        href="<?= base_url() . 'index.php/portfolio/management/' . $innovation_id; ?>"
                        aria-controls="nav-management" aria-selected="false">Management</a>
                        <a class="nav-item nav-link filled-data" id="nav-governance-tab"
                        href="<?= base_url() . 'index.php/portfolio/governance/' . $innovation_id; ?>"
                        aria-controls="nav-governance" aria-selected="false">Governance</a>
                        <a class="nav-item nav-link filled-data" id="nav-relationship-tab"
                        href="<?= base_url() . 'index.php/portfolio/villgro_relationship/' . $innovation_id; ?>"
                        aria-controls="nav-relationship" aria-selected="false">Villgro Relationship Details</a>
                        <a class="nav-item nav-link filled-data" id="nav-incubation-tab"
                        href="<?= base_url() . 'index.php/portfolio/incubation_relationship/' . $innovation_id; ?>"
                        aria-controls="nav-incubation" aria-selected="false">Incubation Relationship</a>
                        <a class="nav-item nav-link filled-data" id="nav-cap-tab"
                        href="<?= base_url() . 'index.php/portfolio/cap_table/' . $innovation_id; ?>"
                        aria-controls="nav-cap" aria-selected="false">Cap Table</a>
                        <a class="nav-item nav-link filled-data" id="nav-interested-tab"
                        href="<?= base_url() . 'index.php/portfolio/interested_parties/' . $innovation_id; ?>"
                        aria-controls="nav-interested" aria-selected="false">Other Interested Parties</a>
                        <a class="nav-item nav-link bg-trasnparent brd-none" id="nav-about-tab" href="#nav-about"
                        aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                        <a class="nav-item nav-link dataConfig active" id="nav-dataconfig-tab"
                        href="javascript:void(0);" role="tab" aria-controls="nav-dataconfig"
                        aria-selected="false">Plan Setup</a>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-business" role="tabpanel"
                    aria-labelledby="nav-business-tab">
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
                            <?php $this->load->view('config_left_menu.php', array('class_name' => 'impactDiv', 'configData' => $dataConfig, 'approvals' => $approvals, 'fin_year' => $current_financial)); ?>
						<style>
							.select2-selection__rendered {
								white-space: normal !important; /* Enable text wrapping */
							}
							.select2-selection--single{
								width: 700px;
							}
							.select2-selection.select2-selection--single {
								height: 66px;
							}
						</style>
					   </div>
                        <main class="page-content" id="pageContent">
                            <div class="row dataconfig">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad0">
                                    <h4>Impact</h4>
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
                                        <form method="post" id="impact_form" action="<?php echo base_url() . 'index.php/portfolio/addImpact'; ?>" autocomplete="off">
                                            <input type="hidden" name="innovation_id" id="innovation_id" value="<?php echo $innovation_id; ?>" />
                                            <input type='hidden' name='cur_finance' id="cur_finance" value="<?= $current_financial; ?>">
                                            <input type='hidden' name='updatePlan' id="updatePlan" value="0">
                                            <input type='hidden' name='module_id' id="module_id" value="14">

                                            <div class="Plan-structure">
											
											
											
                                               

                                                <?php
                                                $short_year = substr($current_financial, -2);
                                                $get_end_year = $this->Mportfolio->getFYtoYear($this->session->userdata('partner_id'), $current_financial);
                                                $next_financial = substr($get_end_year[0]['fin_to_year'], -2);
                                                ?>

                                                <div class="row">
                                                    <div class="col-xl-7 col-md-7 col-lg-7 col-12">
                                                        <div class="quaterlyNewplanstru">
                                                              <!--<h4>Impact Targets</h4>-->
                                                        </div>
                                                    </div>
													
													<?php /*
                                                    <div class="col-xl-5 col-md-5 col-lg-5 col-12">
                                                        <div class="quaterlyNewplanstru">
                                                            <div class="text-right" id='editImpactSec'>
                                                                <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                    <a href="javascript:void(0)" id="editImpact" class="edit-btnconfig mar-bt15 display-block mar-rt5"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
													 <div class="col-xl-6 col-lg-6 col-md-6 col-12">
														<?php if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['impact_approval'] == 2) { ?>
															<h4>Impact Targets <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
														<?php  } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['impact_approval'] == 3) { ?>
															<h4>Impact Targets <span class="text-success"><small>(Approved)</small></span></h4>
														<?php } else { ?>
															<h4>Impact Targets</h4>
														<?php } ?>
													</div>
													<?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['impact_approval'] == 2) { ?>
														<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right">
															<div class="approved-btn text-right">
																<button type="button" class="btn btn-success capitilize">Approve</button>
																<div>
																</div>
															</div>
														</div>
													<?php } ?>
													} */ ?>
													
													<div class="col-xl-12 col-lg-6 col-md-6 col-12 quaterlyNewplanstru" style="display:flex;">
														<?php if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['impact_approval'] == 2) { ?>
															<h4>Impact Targets <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
														<?php  } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['impact_approval'] == 3) { ?>
															<h4>Impact Targets <span class="text-success"><small>(Approved)</small></span></h4>
														<?php } else { ?>
															<h4>Impact Targets</h4>
														<?php } ?>
														 <?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['impact_approval'] == 2) { ?>
															<!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right"> -->
																<div class="approved-btn text-right">
																	<button style="margin-left: 5px;margin-top: -14px;" type="button" class="btn btn-success capitilize">Approve</button>
																	<div>
																	</div>
																</div>
															 <!-- </div> -->
														<?php } ?>
														 <div class="text-right" id='editImpactSec' style="margin-left: auto; ">
															<?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
																<a href="javascript:void(0)" id="editImpact" class="edit-btnconfig mar-bt15 display-block mar-rt5"><i class="fas fa-pencil-alt"></i> Edit</a>
															<?php } ?>
														</div>
													</div>
														
													
													
													
													
                                                </div>
                                                <div class="table-responsive table_configcontentnew impact_div" id="impact_div">
                                                    <table class="table" style="margin-top: 0">
                                                        <thead>
                                                            <tr>
                                                                <th>Impact</th>
                                                                <th>Gender</th>
                                                               <?php /*  <th class="text-center">IRIS Code</th> */ ?>
                                                                <th class="text-center"><?= $get_month_list[0] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[1] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[2] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[3] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[4] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[5] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[6] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[7] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[8] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[9] . '-' . $next_financial; ?></th>
                                                                <th class="text-center"><?= $get_month_list[10] . '-' . $next_financial; ?></th>
                                                                <th class="text-center"><?= $get_month_list[11] . '-' . $next_financial; ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td rowspan="4" class="vill-gray">Number of end beneficiaries</td>
                                                                <td>Male</td>
                                                               <?php  /*  <td>
                                                                    <select class="form-control form-control-sm iris_code_plan" name="endBen_male_iris">
                                                                        <option>--Select--</option>
                                                                        <?php foreach ($iris_code as $code) { ?>
                                                                            <option value="<?= $code['id']; ?>" <?php if (isset($end_male[0]['iris_code']) && $end_male[0]['iris_code'] == $code['id']) { ?> selected <?php } ?>><?= $code['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td> */ ?>
                                                                <td>
                                                                    <input type="text" name="endBen_male_<?= strtolower($get_month_list[0]); ?>" value="<?= $end_male[0][strtolower($get_month_list[0])]; ?>" class="end_apr form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_male_<?= strtolower($get_month_list[1]); ?>" value="<?= $end_male[0][strtolower($get_month_list[1])]; ?>" class="end_may form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_male_<?= strtolower($get_month_list[2]); ?>" value="<?= $end_male[0][strtolower($get_month_list[2])]; ?>" class="end_jun form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_male_<?= strtolower($get_month_list[3]); ?>" value="<?= $end_male[0][strtolower($get_month_list[3])]; ?>" class="end_jul form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_male_<?= strtolower($get_month_list[4]); ?>" value="<?= $end_male[0][strtolower($get_month_list[4])]; ?>" class="end_aug form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_male_<?= strtolower($get_month_list[5]); ?>" value="<?= $end_male[0][strtolower($get_month_list[5])]; ?>" class="end_sep form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_male_<?= strtolower($get_month_list[6]); ?>" value="<?= $end_male[0][strtolower($get_month_list[6])]; ?>" class="end_oct form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_male_<?= strtolower($get_month_list[7]); ?>" value="<?= $end_male[0][strtolower($get_month_list[7])]; ?>" class="end_nov form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_male_<?= strtolower($get_month_list[8]); ?>" value="<?= $end_male[0][strtolower($get_month_list[8])]; ?>" class="end_dec form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_male_<?= strtolower($get_month_list[9]); ?>" value="<?= $end_male[0][strtolower($get_month_list[9])]; ?>" class="end_jan form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_male_<?= strtolower($get_month_list[10]); ?>" value="<?= $end_male[0][strtolower($get_month_list[10])]; ?>" class="end_feb form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_male_<?= strtolower($get_month_list[11]); ?>" value="<?= $end_male[0][strtolower($get_month_list[11])]; ?>" class="end_mar form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Female</td>
                                                               <?php  /*  <td>
                                                                    <select class="form-control form-control-sm iris_code_plan" name="endBen_female_iris">
                                                                        <option>--Select--</option>
                                                                        <?php foreach ($iris_code as $code) { ?>
                                                                            <option value="<?= $code['id']; ?>" <?php if (isset($end_female[0]['iris_code']) && $end_female[0]['iris_code'] == $code['id']) { ?> selected <?php } ?>><?= $code['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td> */ ?>
                                                                <td>
                                                                    <input type="text" name="endBen_female_<?= strtolower($get_month_list[0]); ?>" value="<?= $end_female[0][strtolower($get_month_list[0])]; ?>" class="end_apr form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_female_<?= strtolower($get_month_list[1]); ?>" value="<?= $end_female[0][strtolower($get_month_list[1])]; ?>" class="end_may form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_female_<?= strtolower($get_month_list[2]); ?>" value="<?= $end_female[0][strtolower($get_month_list[2])]; ?>" class="end_jun form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_female_<?= strtolower($get_month_list[3]); ?>" value="<?= $end_female[0][strtolower($get_month_list[3])]; ?>" class="end_jul form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_female_<?= strtolower($get_month_list[4]); ?>" value="<?= $end_female[0][strtolower($get_month_list[4])]; ?>" class="end_aug form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_female_<?= strtolower($get_month_list[5]); ?>" value="<?= $end_female[0][strtolower($get_month_list[5])]; ?>" class="end_sep form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_female_<?= strtolower($get_month_list[6]); ?>" value="<?= $end_female[0][strtolower($get_month_list[6])]; ?>" class="end_oct form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_female_<?= strtolower($get_month_list[7]); ?>" value="<?= $end_female[0][strtolower($get_month_list[7])]; ?>" class="end_nov form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_female_<?= strtolower($get_month_list[8]); ?>" value="<?= $end_female[0][strtolower($get_month_list[8])]; ?>" class="end_dec form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_female_<?= strtolower($get_month_list[9]); ?>" value="<?= $end_female[0][strtolower($get_month_list[9])]; ?>" class="end_jan form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_female_<?= strtolower($get_month_list[10]); ?>" value="<?= $end_female[0][strtolower($get_month_list[10])]; ?>" class="end_feb form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_female_<?= strtolower($get_month_list[11]); ?>" value="<?= $end_female[0][strtolower($get_month_list[11])]; ?>" class="end_mar form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Other</td>
                                                               <?php  /*  <td>
                                                                    <select class="form-control form-control-sm iris_code_plan" name="endBen_other_iris">
                                                                        <option>--Select--</option>
                                                                        <?php foreach ($iris_code as $code) { ?>
                                                                            <option value="<?= $code['id']; ?>" <?php if (isset($end_other[0]['iris_code']) && $end_other[0]['iris_code'] == $code['id']) { ?> selected <?php } ?>><?= $code['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td> */ ?>
                                                                <td>
                                                                    <input type="text" name="endBen_other_<?= strtolower($get_month_list[0]); ?>" value="<?= $end_other[0][strtolower($get_month_list[0])]; ?>" class="end_apr form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_other_<?= strtolower($get_month_list[1]); ?>" value="<?= $end_other[0][strtolower($get_month_list[1])]; ?>" class="end_may form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_other_<?= strtolower($get_month_list[2]); ?>" value="<?= $end_other[0][strtolower($get_month_list[2])]; ?>" class="end_jun form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_other_<?= strtolower($get_month_list[3]); ?>" value="<?= $end_other[0][strtolower($get_month_list[3])]; ?>" class="end_jul form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_other_<?= strtolower($get_month_list[4]); ?>" value="<?= $end_other[0][strtolower($get_month_list[4])]; ?>" class="end_aug form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_other_<?= strtolower($get_month_list[5]); ?>" value="<?= $end_other[0][strtolower($get_month_list[5])]; ?>" class="end_sep form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_other_<?= strtolower($get_month_list[6]); ?>" value="<?= $end_other[0][strtolower($get_month_list[6])]; ?>" class="end_oct form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_other_<?= strtolower($get_month_list[7]); ?>" value="<?= $end_other[0][strtolower($get_month_list[7])]; ?>" class="end_nov form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_other_<?= strtolower($get_month_list[8]); ?>" value="<?= $end_other[0][strtolower($get_month_list[8])]; ?>" class="end_dec form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_other_<?= strtolower($get_month_list[9]); ?>" value="<?= $end_other[0][strtolower($get_month_list[9])]; ?>" class="end_jan form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_other_<?= strtolower($get_month_list[10]); ?>" value="<?= $end_other[0][strtolower($get_month_list[10])]; ?>" class="end_feb form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_other_<?= strtolower($get_month_list[11]); ?>" value="<?= $end_other[0][strtolower($get_month_list[11])]; ?>" class="end_mar form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Unknown</td>
                                                                <?php  /* <td>
                                                                    <select class="form-control form-control-sm iris_code_plan" name="endBen_unknown_iris">
                                                                        <option>--Select--</option>
                                                                        <?php foreach ($iris_code as $code) { ?>
                                                                            <option value="<?= $code['id']; ?>" <?php if (isset($end_unknown[0]['iris_code']) && $end_unknown[0]['iris_code'] == $code['id']) { ?> selected <?php } ?>><?= $code['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td> */ ?>
                                                                <td>
                                                                    <input type="text" name="endBen_unknown_<?= strtolower($get_month_list[0]); ?>" value="<?= $end_unknown[0][strtolower($get_month_list[0])]; ?>" class="end_apr form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_unknown_<?= strtolower($get_month_list[1]); ?>" value="<?= $end_unknown[0][strtolower($get_month_list[1])]; ?>" class="end_may form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_unknown_<?= strtolower($get_month_list[2]); ?>" value="<?= $end_unknown[0][strtolower($get_month_list[2])]; ?>" class="end_jun form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_unknown_<?= strtolower($get_month_list[3]); ?>" value="<?= $end_unknown[0][strtolower($get_month_list[3])]; ?>" class="end_jul form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_unknown_<?= strtolower($get_month_list[4]); ?>" value="<?= $end_unknown[0][strtolower($get_month_list[4])]; ?>" class="end_aug form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_unknown_<?= strtolower($get_month_list[5]); ?>" value="<?= $end_unknown[0][strtolower($get_month_list[5])]; ?>" class="end_sep form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_unknown_<?= strtolower($get_month_list[6]); ?>" value="<?= $end_unknown[0][strtolower($get_month_list[6])]; ?>" class="end_oct form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_unknown_<?= strtolower($get_month_list[7]); ?>" value="<?= $end_unknown[0][strtolower($get_month_list[7])]; ?>" class="end_nov form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_unknown_<?= strtolower($get_month_list[8]); ?>" value="<?= $end_unknown[0][strtolower($get_month_list[8])]; ?>" class="end_dec form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_unknown_<?= strtolower($get_month_list[9]); ?>" value="<?= $end_unknown[0][strtolower($get_month_list[9])]; ?>" class="end_jan form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_unknown_<?= strtolower($get_month_list[10]); ?>" value="<?= $end_unknown[0][strtolower($get_month_list[10])]; ?>" class="end_feb form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="endBen_unknown_<?= strtolower($get_month_list[11]); ?>" value="<?= $end_unknown[0][strtolower($get_month_list[11])]; ?>" class="end_mar form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                            </tr>
                                                            <tr style="background: #e5f3e5;" class="total_calc">
                                                                <td></td>
                                                                <td><b>Total</b></td>
                                                                <td><input type="text" id="end_tot_apr" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="end_tot_may" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="end_tot_jun" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="end_tot_jul" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="end_tot_aug" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="end_tot_sep" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="end_tot_oct" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="end_tot_nov" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="end_tot_dec" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="end_tot_jan" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="end_tot_feb" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="end_tot_mar" readonly="" placeholder="00"></td>
                                                            </tr>
                                                            <tr>
                                                                <td rowspan="4" class="vill-gray">No. of direct jobs created</td>
                                                                <td>Male</td>
                                                               <?php b  /* <td>
                                                                    <select class="form-control form-control-sm iris_code_plan" name="dirJob_male_iris">
                                                                        <option>--Select--</option>
                                                                        <?php foreach ($iris_code as $code) { ?>
                                                                            <option value="<?= $code['id']; ?>" <?php if (isset($direct_male[0]['iris_code']) && $direct_male[0]['iris_code'] == $code['id']) { ?> selected <?php } ?>><?= $code['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td> */ ?>
                                                                <td>
                                                                    <input type="text" name="dirJob_male_<?= strtolower($get_month_list[0]); ?>" value="<?= $direct_male[0][strtolower($get_month_list[0])]; ?>" class="direct_apr form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_male_<?= strtolower($get_month_list[1]); ?>" value="<?= $direct_male[0][strtolower($get_month_list[1])]; ?>" class="direct_may form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_male_<?= strtolower($get_month_list[2]); ?>" value="<?= $direct_male[0][strtolower($get_month_list[2])]; ?>" class="direct_jun form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_male_<?= strtolower($get_month_list[3]); ?>" value="<?= $direct_male[0][strtolower($get_month_list[3])]; ?>" class="direct_jul form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_male_<?= strtolower($get_month_list[4]); ?>" value="<?= $direct_male[0][strtolower($get_month_list[4])]; ?>" class="direct_aug form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_male_<?= strtolower($get_month_list[5]); ?>" value="<?= $direct_male[0][strtolower($get_month_list[5])]; ?>" class="direct_sep form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_male_<?= strtolower($get_month_list[6]); ?>" value="<?= $direct_male[0][strtolower($get_month_list[6])]; ?>" class="direct_oct form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_male_<?= strtolower($get_month_list[7]); ?>" value="<?= $direct_male[0][strtolower($get_month_list[7])]; ?>" class="direct_nov form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_male_<?= strtolower($get_month_list[8]); ?>" value="<?= $direct_male[0][strtolower($get_month_list[8])]; ?>" class="direct_dec form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_male_<?= strtolower($get_month_list[9]); ?>" value="<?= $direct_male[0][strtolower($get_month_list[9])]; ?>" class="direct_jan form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_male_<?= strtolower($get_month_list[10]); ?>" value="<?= $direct_male[0][strtolower($get_month_list[10])]; ?>" class="direct_feb form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_male_<?= strtolower($get_month_list[11]); ?>" value="<?= $direct_male[0][strtolower($get_month_list[11])]; ?>" class="direct_mar form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Female</td>
                                                               <?php  /*  <td>
                                                                    <select class="form-control form-control-sm iris_code_plan" name="dirJob_female_iris">
                                                                        <option>--Select--</option>
                                                                        <?php foreach ($iris_code as $code) { ?>
                                                                            <option value="<?= $code['id']; ?>" <?php if (isset($direct_female[0]['iris_code']) && $direct_female[0]['iris_code'] == $code['id']) { ?> selected <?php } ?>><?= $code['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td> */ ?>
                                                                <td>
                                                                    <input type="text" name="dirJob_female_<?= strtolower($get_month_list[0]); ?>" value="<?= $direct_female[0][strtolower($get_month_list[0])]; ?>" class="direct_apr form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_female_<?= strtolower($get_month_list[1]); ?>" value="<?= $direct_female[0][strtolower($get_month_list[1])]; ?>" class="direct_may form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_female_<?= strtolower($get_month_list[2]); ?>" value="<?= $direct_female[0][strtolower($get_month_list[2])]; ?>" class="direct_jun form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_female_<?= strtolower($get_month_list[3]); ?>" value="<?= $direct_female[0][strtolower($get_month_list[3])]; ?>" class="direct_jul form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_female_<?= strtolower($get_month_list[4]); ?>" value="<?= $direct_female[0][strtolower($get_month_list[4])]; ?>" class="direct_aug form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_female_<?= strtolower($get_month_list[5]); ?>" value="<?= $direct_female[0][strtolower($get_month_list[5])]; ?>" class="direct_sep form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_female_<?= strtolower($get_month_list[6]); ?>" value="<?= $direct_female[0][strtolower($get_month_list[6])]; ?>" class="direct_oct form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_female_<?= strtolower($get_month_list[7]); ?>" value="<?= $direct_female[0][strtolower($get_month_list[7])]; ?>" class="direct_nov form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_female_<?= strtolower($get_month_list[8]); ?>" value="<?= $direct_female[0][strtolower($get_month_list[8])]; ?>" class="direct_dec form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_female_<?= strtolower($get_month_list[9]); ?>" value="<?= $direct_female[0][strtolower($get_month_list[9])]; ?>" class="direct_jan form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_female_<?= strtolower($get_month_list[10]); ?>" value="<?= $direct_female[0][strtolower($get_month_list[10])]; ?>" class="direct_feb form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_female_<?= strtolower($get_month_list[11]); ?>" value="<?= $direct_female[0][strtolower($get_month_list[11])]; ?>" class="direct_mar form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Other</td>
                                                                <?php  /* <td>
                                                                    <select class="form-control form-control-sm iris_code_plan" name="dirJob_other_iris">
                                                                        <option>--Select--</option>
                                                                        <?php foreach ($iris_code as $code) { ?>
                                                                            <option value="<?= $code['id']; ?>" <?php if (isset($direct_other[0]['iris_code']) && $direct_other[0]['iris_code'] == $code['id']) { ?> selected <?php } ?>><?= $code['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td> */ ?>
                                                                <td>
                                                                    <input type="text" name="dirJob_other_<?= strtolower($get_month_list[0]); ?>" value="<?= $direct_other[0][strtolower($get_month_list[0])]; ?>" class="direct_apr form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_other_<?= strtolower($get_month_list[1]); ?>" value="<?= $direct_other[0][strtolower($get_month_list[1])]; ?>" class="direct_may form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_other_<?= strtolower($get_month_list[2]); ?>" value="<?= $direct_other[0][strtolower($get_month_list[2])]; ?>" class="direct_jun form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_other_<?= strtolower($get_month_list[3]); ?>" value="<?= $direct_other[0][strtolower($get_month_list[3])]; ?>" class="direct_jul form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_other_<?= strtolower($get_month_list[4]); ?>" value="<?= $direct_other[0][strtolower($get_month_list[4])]; ?>" class="direct_aug form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_other_<?= strtolower($get_month_list[5]); ?>" value="<?= $direct_other[0][strtolower($get_month_list[5])]; ?>" class="direct_sep form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_other_<?= strtolower($get_month_list[6]); ?>" value="<?= $direct_other[0][strtolower($get_month_list[6])]; ?>" class="direct_oct form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_other_<?= strtolower($get_month_list[7]); ?>" value="<?= $direct_other[0][strtolower($get_month_list[7])]; ?>" class="direct_nov form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_other_<?= strtolower($get_month_list[8]); ?>" value="<?= $direct_other[0][strtolower($get_month_list[8])]; ?>" class="direct_dec form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_other_<?= strtolower($get_month_list[9]); ?>" value="<?= $direct_other[0][strtolower($get_month_list[9])]; ?>" class="direct_jan form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_other_<?= strtolower($get_month_list[10]); ?>" value="<?= $direct_other[0][strtolower($get_month_list[10])]; ?>" class="direct_feb form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_other_<?= strtolower($get_month_list[11]); ?>" value="<?= $direct_other[0][strtolower($get_month_list[11])]; ?>" class="direct_mar form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Unknown</td>
                                                               <?php  /*  <td>
                                                                    <select class="form-control form-control-sm iris_code_plan" name="dirJob_unknown_iris">
                                                                        <option>--Select--</option>
                                                                        <?php foreach ($iris_code as $code) { ?>
                                                                            <option value="<?= $code['id']; ?>" <?php if (isset($direct_unknown[0]['iris_code']) && $direct_unknown[0]['iris_code'] == $code['id']) { ?> selected <?php } ?>><?= $code['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td> */ ?>
                                                                <td>
                                                                    <input type="text" name="dirJob_unknown_<?= strtolower($get_month_list[0]); ?>" value="<?= $direct_unknown[0][strtolower($get_month_list[0])]; ?>" class="direct_apr form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_unknown_<?= strtolower($get_month_list[1]); ?>" value="<?= $direct_unknown[0][strtolower($get_month_list[1])]; ?>" class="direct_may form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_unknown_<?= strtolower($get_month_list[2]); ?>" value="<?= $direct_unknown[0][strtolower($get_month_list[2])]; ?>" class="direct_jun form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_unknown_<?= strtolower($get_month_list[3]); ?>" value="<?= $direct_unknown[0][strtolower($get_month_list[3])]; ?>" class="direct_jul form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_unknown_<?= strtolower($get_month_list[4]); ?>" value="<?= $direct_unknown[0][strtolower($get_month_list[4])]; ?>" class="direct_aug form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_unknown_<?= strtolower($get_month_list[5]); ?>" value="<?= $direct_unknown[0][strtolower($get_month_list[5])]; ?>" class="direct_sep form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_unknown_<?= strtolower($get_month_list[6]); ?>" value="<?= $direct_unknown[0][strtolower($get_month_list[6])]; ?>" class="direct_oct form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_unknown_<?= strtolower($get_month_list[7]); ?>" value="<?= $direct_unknown[0][strtolower($get_month_list[7])]; ?>" class="direct_nov form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_unknown_<?= strtolower($get_month_list[8]); ?>" value="<?= $direct_unknown[0][strtolower($get_month_list[8])]; ?>" class="direct_dec form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_unknown_<?= strtolower($get_month_list[9]); ?>" value="<?= $direct_unknown[0][strtolower($get_month_list[9])]; ?>" class="direct_jan form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_unknown_<?= strtolower($get_month_list[10]); ?>" value="<?= $direct_unknown[0][strtolower($get_month_list[10])]; ?>" class="direct_feb form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="dirJob_unknown_<?= strtolower($get_month_list[11]); ?>" value="<?= $direct_unknown[0][strtolower($get_month_list[11])]; ?>" class="direct_mar form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                            </tr>
                                                            <tr style="background: #e5f3e5;" class="total_calc">
                                                                <td></td>
                                                                <td><b>Total</b></td>
                                                                <td><input type="text" id="direct_tot_apr" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="direct_tot_may" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="direct_tot_jun" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="direct_tot_jul" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="direct_tot_aug" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="direct_tot_sep" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="direct_tot_oct" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="direct_tot_nov" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="direct_tot_dec" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="direct_tot_jan" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="direct_tot_feb" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="direct_tot_mar" readonly="" placeholder="00"></td>
                                                            </tr>
                                                            <tr>
                                                                <td rowspan="4" class="vill-gray">No. of indirect jobs created</td>
                                                                <td>Male</td>
                                                                <?php  /* <td>
                                                                    <select class="form-control form-control-sm iris_code_plan" name="indirJob_male_iris">
                                                                        <option>--Select--</option>
                                                                        <?php foreach ($iris_code as $code) { ?>
                                                                            <option value="<?= $code['id']; ?>" <?php if (isset($indirect_male[0]['iris_code']) && $indirect_male[0]['iris_code'] == $code['id']) { ?> selected <?php } ?>><?= $code['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td> */ ?>
                                                                <td>
                                                                    <input type="text" name="indirJob_male_<?= strtolower($get_month_list[0]); ?>" value="<?= $indirect_male[0][strtolower($get_month_list[0])]; ?>" class="indirect_apr form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_male_<?= strtolower($get_month_list[1]); ?>" value="<?= $indirect_male[0][strtolower($get_month_list[1])]; ?>" class="indirect_may form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_male_<?= strtolower($get_month_list[2]); ?>" value="<?= $indirect_male[0][strtolower($get_month_list[2])]; ?>" class="indirect_jun form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_male_<?= strtolower($get_month_list[3]); ?>" value="<?= $indirect_male[0][strtolower($get_month_list[3])]; ?>" class="indirect_jul form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_male_<?= strtolower($get_month_list[4]); ?>" value="<?= $indirect_male[0][strtolower($get_month_list[4])]; ?>" class="indirect_aug form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_male_<?= strtolower($get_month_list[5]); ?>" value="<?= $indirect_male[0][strtolower($get_month_list[5])]; ?>" class="indirect_sep form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_male_<?= strtolower($get_month_list[6]); ?>" value="<?= $indirect_male[0][strtolower($get_month_list[6])]; ?>" class="indirect_oct form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_male_<?= strtolower($get_month_list[7]); ?>" value="<?= $indirect_male[0][strtolower($get_month_list[7])]; ?>" class="indirect_nov form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_male_<?= strtolower($get_month_list[8]); ?>" value="<?= $indirect_male[0][strtolower($get_month_list[8])]; ?>" class="indirect_dec form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_male_<?= strtolower($get_month_list[9]); ?>" value="<?= $indirect_male[0][strtolower($get_month_list[9])]; ?>" class="indirect_jan form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_male_<?= strtolower($get_month_list[10]); ?>" value="<?= $indirect_male[0][strtolower($get_month_list[10])]; ?>" class="indirect_feb form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_male_<?= strtolower($get_month_list[11]); ?>" value="<?= $indirect_male[0][strtolower($get_month_list[11])]; ?>" class="indirect_mar form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Female</td>
                                                               <?php   /* <td>
                                                                    <select class="form-control form-control-sm iris_code_plan" name="indirJob_female_iris">
                                                                        <option>--Select--</option>
                                                                        <?php foreach ($iris_code as $code) { ?>
                                                                            <option value="<?= $code['id']; ?>" <?php if (isset($indirect_female[0]['iris_code']) && $indirect_female[0]['iris_code'] == $code['id']) { ?> selected <?php } ?>><?= $code['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td> */ ?>
                                                                <td>
                                                                    <input type="text" name="indirJob_female_<?= strtolower($get_month_list[0]); ?>" value="<?= $indirect_female[0][strtolower($get_month_list[0])]; ?>" class="indirect_apr form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_female_<?= strtolower($get_month_list[1]); ?>" value="<?= $indirect_female[0][strtolower($get_month_list[1])]; ?>" class="indirect_may form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_female_<?= strtolower($get_month_list[2]); ?>" value="<?= $indirect_female[0][strtolower($get_month_list[2])]; ?>" class="indirect_jun form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_female_<?= strtolower($get_month_list[3]); ?>" value="<?= $indirect_female[0][strtolower($get_month_list[3])]; ?>" class="indirect_jul form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_female_<?= strtolower($get_month_list[4]); ?>" value="<?= $indirect_female[0][strtolower($get_month_list[4])]; ?>" class="indirect_aug form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_female_<?= strtolower($get_month_list[5]); ?>" value="<?= $indirect_female[0][strtolower($get_month_list[5])]; ?>" class="indirect_sep form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_female_<?= strtolower($get_month_list[6]); ?>" value="<?= $indirect_female[0][strtolower($get_month_list[6])]; ?>" class="indirect_oct form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_female_<?= strtolower($get_month_list[7]); ?>" value="<?= $indirect_female[0][strtolower($get_month_list[7])]; ?>" class="indirect_nov form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_female_<?= strtolower($get_month_list[8]); ?>" value="<?= $indirect_female[0][strtolower($get_month_list[8])]; ?>" class="indirect_dec form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_female_<?= strtolower($get_month_list[9]); ?>" value="<?= $indirect_female[0][strtolower($get_month_list[9])]; ?>" class="indirect_jan form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_female_<?= strtolower($get_month_list[10]); ?>" value="<?= $indirect_female[0][strtolower($get_month_list[10])]; ?>" class="indirect_feb form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_female_<?= strtolower($get_month_list[11]); ?>" value="<?= $indirect_female[0][strtolower($get_month_list[11])]; ?>" class="indirect_mar form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Other</td>
                                                               <?php  /*  <td>
                                                                    <select class="form-control form-control-sm iris_code_plan" name="indirJob_other_iris">
                                                                        <option>--Select--</option>
                                                                        <?php foreach ($iris_code as $code) { ?>
                                                                            <option value="<?= $code['id']; ?>" <?php if (isset($indirect_other[0]['iris_code']) && $indirect_other[0]['iris_code'] == $code['id']) { ?> selected <?php } ?>><?= $code['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td> */ ?>
                                                                <td>
                                                                    <input type="text" name="indirJob_other_<?= strtolower($get_month_list[0]); ?>" value="<?= $indirect_other[0][strtolower($get_month_list[0])]; ?>" class="indirect_apr form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_other_<?= strtolower($get_month_list[1]); ?>" value="<?= $indirect_other[0][strtolower($get_month_list[1])]; ?>" class="indirect_may form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_other_<?= strtolower($get_month_list[2]); ?>" value="<?= $indirect_other[0][strtolower($get_month_list[2])]; ?>" class="indirect_jun form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_other_<?= strtolower($get_month_list[3]); ?>" value="<?= $indirect_other[0][strtolower($get_month_list[3])]; ?>" class="indirect_jul form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_other_<?= strtolower($get_month_list[4]); ?>" value="<?= $indirect_other[0][strtolower($get_month_list[4])]; ?>" class="indirect_aug form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_other_<?= strtolower($get_month_list[5]); ?>" value="<?= $indirect_other[0][strtolower($get_month_list[5])]; ?>" class="indirect_sep form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_other_<?= strtolower($get_month_list[6]); ?>" value="<?= $indirect_other[0][strtolower($get_month_list[6])]; ?>" class="indirect_oct form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_other_<?= strtolower($get_month_list[7]); ?>" value="<?= $indirect_other[0][strtolower($get_month_list[7])]; ?>" class="indirect_nov form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_other_<?= strtolower($get_month_list[8]); ?>" value="<?= $indirect_other[0][strtolower($get_month_list[8])]; ?>" class="indirect_dec form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_other_<?= strtolower($get_month_list[9]); ?>" value="<?= $indirect_other[0][strtolower($get_month_list[9])]; ?>" class="indirect_jan form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_other_<?= strtolower($get_month_list[10]); ?>" value="<?= $indirect_other[0][strtolower($get_month_list[10])]; ?>" class="indirect_feb form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_other_<?= strtolower($get_month_list[11]); ?>" value="<?= $indirect_other[0][strtolower($get_month_list[11])]; ?>" class="indirect_mar form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Unknown</td>
                                                                <?php  /* <td>
                                                                    <select class="form-control form-control-sm iris_code_plan" name="indirJob_unknown_iris">
                                                                        <option>--Select--</option>
                                                                        <?php foreach ($iris_code as $code) { ?>
                                                                            <option value="<?= $code['id']; ?>" <?php if (isset($indirect_unknown[0]['iris_code']) && $indirect_unknown[0]['iris_code'] == $code['id']) { ?> selected <?php } ?>><?= $code['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td> */ ?>
                                                                <td>
                                                                    <input type="text" name="indirJob_unknown_<?= strtolower($get_month_list[0]); ?>" value="<?= $indirect_unknown[0][strtolower($get_month_list[0])]; ?>" class="indirect_apr form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_unknown_<?= strtolower($get_month_list[1]); ?>" value="<?= $indirect_unknown[0][strtolower($get_month_list[1])]; ?>" class="indirect_may form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_unknown_<?= strtolower($get_month_list[2]); ?>" value="<?= $indirect_unknown[0][strtolower($get_month_list[2])]; ?>" class="indirect_jun form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_unknown_<?= strtolower($get_month_list[3]); ?>" value="<?= $indirect_unknown[0][strtolower($get_month_list[3])]; ?>" class="indirect_jul form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_unknown_<?= strtolower($get_month_list[4]); ?>" value="<?= $indirect_unknown[0][strtolower($get_month_list[4])]; ?>" class="indirect_aug form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_unknown_<?= strtolower($get_month_list[5]); ?>" value="<?= $indirect_unknown[0][strtolower($get_month_list[5])]; ?>" class="indirect_sep form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_unknown_<?= strtolower($get_month_list[6]); ?>" value="<?= $indirect_unknown[0][strtolower($get_month_list[6])]; ?>" class="indirect_oct form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_unknown_<?= strtolower($get_month_list[7]); ?>" value="<?= $indirect_unknown[0][strtolower($get_month_list[7])]; ?>" class="indirect_nov form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_unknown_<?= strtolower($get_month_list[8]); ?>" value="<?= $indirect_unknown[0][strtolower($get_month_list[8])]; ?>" class="indirect_dec form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_unknown_<?= strtolower($get_month_list[9]); ?>" value="<?= $indirect_unknown[0][strtolower($get_month_list[9])]; ?>" class="indirect_jan form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_unknown_<?= strtolower($get_month_list[10]); ?>" value="<?= $indirect_unknown[0][strtolower($get_month_list[10])]; ?>" class="indirect_feb form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="indirJob_unknown_<?= strtolower($get_month_list[11]); ?>" value="<?= $indirect_unknown[0][strtolower($get_month_list[11])]; ?>" class="indirect_mar form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                    <label class="error error_msg"></label>
                                                                </td>
                                                            </tr>
                                                            <tr style="background: #e5f3e5;" class="total_calc">
                                                                <td></td>
                                                                <td><b>Total</b></td>
                                                                <td><input type="text" id="indirect_tot_apr" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="indirect_tot_may" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="indirect_tot_jun" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="indirect_tot_jul" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="indirect_tot_aug" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="indirect_tot_sep" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="indirect_tot_oct" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="indirect_tot_nov" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="indirect_tot_dec" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="indirect_tot_jan" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="indirect_tot_feb" readonly="" placeholder="00"></td>
                                                                <td><input type="text" id="indirect_tot_mar" readonly="" placeholder="00"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="table_configcontentnew pad-bt0">
                                                    <div class="tabpanel-title">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                <h4>Incubatee Specific Impact Metrics</h4>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                <ul class="milestone-links">
                                                                    <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                        <li>
                                                                            <a href="javascript:void(0)" id="addMetric" class="edit-btnconfig mar-bt15 mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                                        </li>
                                                                        <li class="brd-left-onboard" id='editMetricSec'>
                                                                            <a href="javascript:void(0)" id="editMetric" class="edit-btnconfig mar-bt15 mar-tp15"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
												


                                                <div class="table-responsive table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                                    <table id="myTable" class="table scrollmenu" style="margin-top: 0">
                                                        <thead>
                                                            <tr>
                                                                <th width="20%">Metric</th>
                                                               <?php /*  <th width="7%">IRIS Code</th> */ ?>
                                                                <th class="text-center"><?= $get_month_list[0] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[1] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[2] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[3] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[4] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[5] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[6] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[7] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[8] . '-' . $short_year; ?></th>
                                                                <th class="text-center"><?= $get_month_list[9] . '-' . $next_financial; ?></th>
                                                                <th class="text-center"><?= $get_month_list[10] . '-' . $next_financial; ?></th>
                                                                <th class="text-center"><?= $get_month_list[11] . '-' . $next_financial; ?></th>
                                                                <th width="4%"></th>
                                                            </tr>
                                                        </thead> 
														
                                                        <tbody id="metric_add">
                                                            <?php //echo'<pre>';print_r($metric_value);die;
                                                            if (php72_count($metric_value) > 0) {
                                                                $metric_count = php72_count($metric_value);
                                                            } else {
                                                                $metric_count = 1;
                                                            }
                                                            $j = 1;
															#echo'<pre>';print_r($metric_value);die;
                                                            for ($i = 0; $i < $metric_count; $i++) {
                                                                ?>
                                                                <tr id="metric_tr_<?= $j; ?>" class="metric_more">
                                                                    <input type="hidden" name="metric_id[]" value="<?= $metric_value[$i]['id']; ?>">
                                                                    <td style="width:10%">
																	<select readonly="readonly" data-attr-metric-cls="metric_name_cls_<?php echo $i;?>"  name="metric_name_select[]" class="searchable-dropdown" style="width: 100%;">
																	  <option value="">--Select--</option>
																	  <?php if(isset($getMasterMetrics)) {
																			foreach($getMasterMetrics as $getMetricValues){
																		  ?>
																			<option  value="<?php echo $getMetricValues['id']; ?>" <?php if($metric_value[$i]['metric_name'] == $getMetricValues['id']){ echo"selected"; } ?>><?php echo $getMetricValues['name']; ?></option>
																		<?php }} ?>
																		
																		<input type="hidden" class="form-control form-control-sm metricName metric_name_cls_<?php echo $i;?>" maxlength="200" name="metric_name[]" title="<?= $metric_value[$i]['metric_name']; ?>" value="<?= $metric_value[$i]['metric_name']; ?>" placeholder="Impact metric 1">
																	
																	
																	</select>
																	</td>
                                                                    <?php /* <td>
                                                                        <select class="form-control form-control-sm iris_code_plan" name="metric_iris_<?= $j; ?>">
                                                                            <option>--Select--</option>
                                                                            <?php foreach ($iris_code as $code) { ?>
                                                                                <option value="<?= $code['id']; ?>" <?php if (isset($metric_value[$i]['iris_code']) && $metric_value[$i]['iris_code'] == $code['id']) { ?> selected <?php } ?>><?= $code['name']; ?></option>
                                                                            <?php } ?>
                                                                        </select> 
                                                                    </td> */?>
                                                                    <?php
                                                                    if ($reset_metric == 1) {
                                                                        unset($metric_value[$i]['jan'], $metric_value[$i]['feb'], $metric_value[$i]['mar'], $metric_value[$i]['apr'], $metric_value[$i]['may'], $metric_value[$i]['jun'], $metric_value[$i]['jul'], $metric_value[$i]['aug'], $metric_value[$i]['sep'], $metric_value[$i]['oct'], $metric_value[$i]['nov'], $metric_value[$i]['dec']);
                                                                    }
                                                                    ?>

                                                                    <td>
                                                                        <input type="text" name="metric_<?= strtolower($get_month_list[0]) . '_' . $j; ?>" value="<?= $metric_value[$i][strtolower($get_month_list[0])]; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                        <label class="error error_msg"></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="metric_<?= strtolower($get_month_list[1]) . '_' . $j; ?>" value="<?= $metric_value[$i][strtolower($get_month_list[1])]; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                        <label class="error error_msg"></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="metric_<?= strtolower($get_month_list[2]) . '_' . $j; ?>" value="<?= $metric_value[$i][strtolower($get_month_list[2])]; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                        <label class="error error_msg"></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="metric_<?= strtolower($get_month_list[3]) . '_' . $j; ?>" value="<?= $metric_value[$i][strtolower($get_month_list[3])]; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                        <label class="error error_msg"></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="metric_<?= strtolower($get_month_list[4]) . '_' . $j; ?>" value="<?= $metric_value[$i][strtolower($get_month_list[4])]; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                        <label class="error error_msg"></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="metric_<?= strtolower($get_month_list[5]) . '_' . $j; ?>" value="<?= $metric_value[$i][strtolower($get_month_list[5])]; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                        <label class="error error_msg"></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="metric_<?= strtolower($get_month_list[6]) . '_' . $j; ?>" value="<?= $metric_value[$i][strtolower($get_month_list[6])]; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                        <label class="error error_msg"></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="metric_<?= strtolower($get_month_list[7]) . '_' . $j; ?>" value="<?= $metric_value[$i][strtolower($get_month_list[7])]; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                        <label class="error error_msg"></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="metric_<?= strtolower($get_month_list[8]) . '_' . $j; ?>" value="<?= $metric_value[$i][strtolower($get_month_list[8])]; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                        <label class="error error_msg"></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="metric_<?= strtolower($get_month_list[9]) . '_' . $j; ?>" value="<?= $metric_value[$i][strtolower($get_month_list[9])]; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                        <label class="error error_msg"></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="metric_<?= strtolower($get_month_list[10]) . '_' . $j; ?>" value="<?= $metric_value[$i][strtolower($get_month_list[10])]; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                        <label class="error error_msg"></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="metric_<?= strtolower($get_month_list[11]) . '_' . $j; ?>" value="<?= $metric_value[$i][strtolower($get_month_list[11])]; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                        <label class="error error_msg"></label>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                            <?php if (php72_count($metric_value) > 0) { ?>
                                                                                <a class="deleteMetric" title="Delete Metric" onclick="deleteMetric(<?= $metric_value[$i]['id']; ?>);" href="javascript:void(0)"><i class="fas fa-trash"></i></a>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $j++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
												
												
												
												
												
												
												
												
												
												<hr><br><br>
												 <div class="quaterlyNewplanstru">
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                            <?php /* if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['impact_approval'] == 2) { ?>
                                                                <h4>Impact Plan <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                            <?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['impact_approval'] == 3) { ?>
                                                                <h4>Impact Plan <span class="text-success"><small>(Approved)</small></span></h4>
                                                            <?php } else { ?>
                                                                <h4>Impact Plan</h4>
                                                            <?php } */ ?>
															 <h4>Impact Plan</h4>
                                                        </div>
                                                        <?php /* if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['impact_approval'] == 2) { ?>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right">
                                                                <div class="approved-btn text-right">
                                                                    <button type="button" class="btn btn-success capitilize">Approve</button>
                                                                    <div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } */ ?>
                                                    </div>

                                                    <?php
                                                    if (php72_count($end_male) > 0) {
                                                        $imp_enable = 1;
                                                    } else {
                                                        $imp_enable = 0;
                                                    }

                                                    if (php72_count($metric_value) > 0) {
                                                        $met_enable = 1;
                                                    } else {
                                                        $met_enable = 0;
                                                    }
                                                    ?>
                                                    <input type="hidden" id="impEnableCount" value="<?= $imp_enable; ?>">
                                                    <input type="hidden" id="metEnableCount" value="<?= $met_enable; ?>">

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
                                                            <p>Q4 (<?= $get_month_list[9] . '-' . $get_month_list[11] . ' ' . current_FYendYear($this->session->userdata('partner_id')); ?>)</p>
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

<!-- Model (Delete and select) -->
<div class="modal" id="deletemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Are you sure you want to delete selected items?</h4>
                            <p>you are about to delete the selected information fields, you
                            can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="impt_val" id="impt_val" />
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
    <input type="hidden" id="deleteID" value="">
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

        <?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio', 'quantitative' => 'tiny')); ?>

        <script type="text/javascript">
		
			
			$(document).ready(function() {
			  $('.searchable-dropdown').select2();
			  $(".searchable-dropdown").select2({disabled:true});
			  //$(".searchable-dropdown").select2({dropdownAutoWidth : true});
			});
						

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
            var arr;
            $(document).ready(function () {
                var popup = $('#planBox').val();
        //                                    if (popup == 1) {
        //                                        $('#planModal').modal('show');
        //                                    } else {
        //                                        $('#planModal').modal('hide');
        //                                    }
        onLoad();
        setTimeout(function () {
            $('#approveMsg').hide();
            $('#approveallMsg').hide();
        }, 3000);
    });
            $(document).on("input", ".volumefld", function (evt) {
                var self = $(this);
                if (self.val() != 0 || self.val() == '') {
                    self.val(self.val().replace(/[^0-9]/g, ''));
            //                                        self.val(inrFormat(self.val()));
        } else {
            self.val(0);
        }
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
            evt.preventDefault();
        }
    });
            $(document).on('keyup', '.impact', function () {
                var imid = this.id;
                var splt = imid.split("_");
                if (this.value != '') {
                    $('#value_' + splt[1]).attr('required', 'required');
                }
            });
            function pad(num) {
                var s = num + "";
                s = parseFloat(s, 10);
                return s;
            }

            $(document).on('blur', '.currencyField', function (evt) {
                var self = $(this);
                var getValues = (self.val().split(',').join(''));
                var flval = parseFloat(getValues);
                var self_val = Number(flval.toFixed(2));
                if (self_val > 0 || self_val != '') {
                    var decim = pad(self_val);
                    self.val(decim);
                    self.val(self.val().replace(/[^0-9\.]/g, ''));
                    self.val(inrFormat(self.val()));
                    var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
                    var matchedString = self.val().match(patt);
                    if (matchedString) {
                        self.val(matchedString);
                    }

                    if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
                        evt.preventDefault();
                    }
                } else {
                    self.val(0);
                }
            });
            $(document).on('input', '.currencyField', function (evt) {
                var self = $(this);
                self.val(self.val().replace(/[^0-9\.]/g, ''));
                self.val(inrFormat(self.val()));
                var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
                var matchedString = self.val().match(patt);
                if (matchedString) {
                    self.val(matchedString);
                }
            });
            function inrFormat(nStr) {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                var z = 0;
                var len = String(x1).length;
                var num = parseInt((len / 2) - 1);
                while (rgx.test(x1)) {
                    if (z > 0) {
                        x1 = x1.replace(rgx, '$1' + ',' + '$2');
                    } else {
                        x1 = x1.replace(rgx, '$1' + ',' + '$2');
                        rgx = /(\d+)(\d{2})/;
                    }
                    z++;
                    num--;
                    if (num == 0) {
                        break;
                    }
                }
                return x1 + x2;
            }

            function onLoad() {
                var cur_mnth = $('#active_editor').val();
                if (cur_mnth != '')
                    highlightQuarter(cur_mnth);
                var impEditOpt = $('#impEnableCount').val();
                var enable_form = "<?= $field_enable; ?>";
                if (impEditOpt > 0 || enable_form == 0) {
                    $('.impact_div input[type="text"]').attr('readonly', 'readonly');
                    $('.impact_div select').attr('readonly', 'readonly');
                    $('.impact_div select').css("pointer-events", "none");
                    /*$('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').css("pointer-events", "none");
                    $('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').addClass('opacity5');*/
                }
                var metEditOpt = $('#metEnableCount').val();
                if (metEditOpt > 0 || enable_form == 0) {
                    $('.quatermetric_forma input[type="text"]').attr('readonly', 'readonly');
                    $('.quatermetric_forma select').attr('readonly', 'readonly');
                    $('.quatermetric_forma select').css("pointer-events", "none");
					//$('.searchable-dropdown').prop('disabled', true);

                }
                $('#editImpact').addClass('opacity5');
                $('#editMetric').addClass('opacity5');
                $('.total_calc :input').addClass('opacity5');
            }

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

            $(document).on('click', '.capitilize', function () {
                var inv_id = $('#innovation_id').val();
                var fin_year = $('#cur_finance').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/portfolio/impactApproved",
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
            $(document).on('click', '#editImpact', function () {
                $('#editImpactSec').html('<a href="javascript:void(0)" class="edit-btnconfig mar-bt15 display-block mar-rt5" id="cancelImpactBtn"><i class="fas fa-times"></i>&nbsp;Cancel</a>');
                $('.saveContinue').text('Save');
                $('#updatePlan').val('1');
                $(".impact_div select").css("pointer-events", "");
                $('.impact_div :input').attr('readonly', false);
                $('.impact_div select').attr('readonly', false);
                $('#editImpact').removeClass('opacity5');
                $('.total_calc :input').attr('readonly', true);
                $('.total_calc :input').addClass('opacity5');
            });
            $(document).on('click', '#editMetric', function () {
                $('#editMetricSec').html('<a href="javascript:void(0)" class="edit-btnconfig" id="cancelMetricBtn"><i class="fas fa-times"></i>&nbsp;Cancel</a>');
                $('.saveContinue').text('Save');
                $('#updatePlan').val('1');
                $('.quatermetric_forma :input').attr('readonly', false);
                $('.quatermetric_forma select').attr('readonly', false);
                $('.quatermetric_forma select').css("pointer-events", "");
				$(".searchable-dropdown").select2({disabled:false});
                $('#editMetric').removeClass('opacity5');
            });
            $(document).on('click', '#cancelImpactBtn', function () {
                $('#editImpactSec').html('<a href="javascript:void(0)" class="edit-btnconfig mar-bt15 display-block mar-rt5" id="editImpact"><i class="fas fa-pencil-alt"></i>Edit</a>');
                $('.saveContinue').text('Save');
                $('#updatePlan').val('0');
                onLoad();
            });
            $(document).on('click', '#cancelMetricBtn', function () {
                $('#editMetricSec').html('<a href="javascript:void(0)" id="editMetric"><i class="fas fa-pencil-alt"></i>Edit</a>');
                $('.saveContinue').text('Save');
                $('#updatePlan').val('0');
                onLoad();
				$(".searchable-dropdown").select2({disabled:true});
            });
            $('#deleteRecord').on('click', function () {
                var impt = $('#impt_val').val();
        //                                    $('#metric_tr_' + impt).remove();
        if (!$('.metric_more').length) {
			optionsList = '<?php echo $option_lists; ?>';
			/* var dyns = $('.metric_more').length;
			var increas = parseInt(dyn) + 1;
			 */
			 var increas = 0;
            //var datas = '<tr id="metric_tr_1" class="metric_more"><td class="metric_title" width="25%"><input type="text" class="form-control form-control-sm metricName" maxlength="200" name="metric_name[]" placeholder="Impact metric 1" id="metricNam_1"><span class="name_msg hidden_cls text-danger" id="name_msg_1">Enter metric</span></td><td width="40%"><div class="form-group"><input type="text" maxlength="20" class="form-control form-control-sm metric currencyField" id="metric_1" placeholder="Value" name="metric[]" value=""><span class="metric_msg hidden_cls text-danger" id="metric_msg_1">Enter value</span></div></td><td width="10%"></td>';
            var datas = '<tr id="metric_tr_1" class="metric_more">' +
            '<td><select data-attr-metric-cls="metric_name_cls_'+increas+'"  name="metric_name_select[]"  class="searchable-dropdown" style="width: 100%;">'+optionsList+'</select><input type="hidden" class="form-control form-control-sm metricName metric_name_cls_'+increas+'" maxlength="200" name="metric_name[]" placeholder="Impact metric 1" id="metricNam_1"><span class="name_msg hidden_cls text-danger" id="name_msg_' + increas + '">Enter metric</span></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[0]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[1]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[2]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[3]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[4]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[5]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[6]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[7]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[8]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[9]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[10]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[11]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td></tr>';
            $('#metric_add').append(datas);
        }
        $('#deletemodal').modal('hide');
        var finan_yr = $('#financial_year').val();
        var inv_id = $('#innovation_id').val();
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/deleteImpact",
            data: {
                finan_yr: finan_yr,
                inv_id: inv_id,
                del_id: impt,
                table: 'port_impact_metric',
                temp_table: 'temp_impact_metric'
            },
            dataType: 'json',
            success: function (msg) {
                $('#quatermetric_forma').load(location.href + ' #quatermetric_forma');
                //                                                                                    location.reload();
                arr = msg;
                $('#deletemodal').modal('hide');
                $('#deleteMsg').show();
                setTimeout(function () {
                    window.location.reload();
					//onLoad();
                    //                                                                                        onImpactDelete();
                    //                                                                                        onMetricDelete();
                }, 500);
                setTimeout(function () {
                    $('#deleteMsg').hide();
                }, 3000);
            }
        });
    });
$(document).on('click', '#addImpact', function () {
    if ($('.impact_more').length) {
        var dyn = $('.deleteImpact:last').attr('data-dyn');
        var increa = parseInt(dyn) + 1;
        var datas = '<tr id="impact_tr_' + increa + '" class="impact_more"><td width="50%"><input type="text" class="form-control form-control-sm impact" id="impact_' + increa + '" name="impact[]" placeholder="Impact" value=""><span class="impact_msg hidden_cls text-danger" id="impact_msg_' + increa + '">Enter impact</span></td><td width="40%"><input type="text" class="form-control form-control-sm value" id="value_' + increa + '" name="value[]" placeholder="Value" value=""><span class="value_msg hidden_cls text-danger" id="value_msg_' + increa + '">Enter value</span></td><td width="10%"><a class="deleteImpact" data-dyn="' + increa + '" data-dyn-name="impact" href="javascript:void(0)"><i class="fas fa-trash"></i></a></td>';
        $(datas).insertAfter($('#impact_tr_' + dyn));
    } else {
        var datas = '<tr id="impact_tr_1" class="impact_more"><td width="50%"><input type="text" class="form-control form-control-sm impact" id="impact_1" name="impact[]" placeholder="Impact" value=""><span class="impact_msg hidden_cls text-danger" id="impact_msg_1">Enter impact</span></td><td width="40%"><input type="text" class="form-control form-control-sm value" id="value_1" name="value[]" placeholder="Value" value=""><span class="value_msg hidden_cls text-danger" id="value_msg_1">Enter value</span></td><td width="10%"><a class="deleteImpact" data-dyn="1" data-dyn-name="impact" href="javascript:void(0)"><i class="fas fa-trash"></i></a></td>';
        $('#impact_add').append(datas);
    }
});
$(document).on('click', '#addMetric', function (){ 

	optionsList = '<?php echo $option_lists; ?>';
	
    if ($('.metric_more').length) {
		 $('.searchable-dropdown').select2();
			var dyn = $('.metric_more').length;
			var increa = parseInt(dyn) + 1;
            //var datas = '<tr id="metric_tr_' + increa + '" class="metric_more"><td class="metric_title" width="25%"><input type="text" class="form-control form-control-sm metricName" maxlength="200" name="metric_name[]" placeholder="Impact metric ' + increa + '" id="metricNam_' + increa + '"><span class="name_msg hidden_cls text-danger" id="name_msg_' + increa + '">Enter metric</span></td><td width="40%"><div class="form-group"><input type="text" maxlength="20" class="form-control form-control-sm metric currencyField" placeholder="Value" id="metric_' + increa + '" name="metric[]" value=""><span class="metric_msg hidden_cls text-danger" id="metric_msg_' + increa + '">Enter value</span></div></td><td width="10%"></td>';
            var datas = '<tr id="metric_tr_' + increa + '" class="metric_more">' +
            '<td><select data-attr-metric-cls="metric_name_cls_'+increa+'"  name="metric_name_select[]"  class="searchable-dropdown" style="width: 100%;">'+optionsList+'</select><input type="hidden" class="form-control form-control-sm metricName metric_name_cls_'+increa+'" maxlength="200" name="metric_name[]" placeholder="Impact metric 1" id="metricNam_1"><span class="name_msg hidden_cls text-danger" id="name_msg_' + increa + '">Enter metric</span></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[0]); ?>_' + increa + '" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[1]); ?>_' + increa + '" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[2]); ?>_' + increa + '" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[3]); ?>_' + increa + '" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[4]); ?>_' + increa + '" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[5]); ?>_' + increa + '" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[6]); ?>_' + increa + '" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[7]); ?>_' + increa + '" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[8]); ?>_' + increa + '" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[9]); ?>_' + increa + '" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[10]); ?>_' + increa + '" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[11]); ?>_' + increa + '" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td></tr>';
            $(datas).insertAfter($('#metric_tr_' + dyn));
			 $('#metric_tr_' + increa + ' .searchable-dropdown').select2();
        } else {
            //                                        var datas = '<tr id="metric_tr_1" class="metric_more"><td class="metric_title" width="25%"><input type="text" class="form-control form-control-sm metricName" maxlength="200" name="metric_name[]" placeholder="Impact metric 1" id="metricNam_1"><span class="name_msg hidden_cls text-danger" id="name_msg_1">Enter metric</span></td><td width="40%"><div class="form-group"><input type="text" maxlength="20" class="form-control form-control-sm metric currencyField" id="metric_1" name="metric[]" placeholder="Value" value=""><span class="metric_msg hidden_cls text-danger" id="metric_msg_1">Enter value</span></div></td><td width="10%"></td>';
            var datas = '<tr id="metric_tr_1" class="metric_more">' +
            '<td><select data-attr-metric-cls="metric_name_cls_'+increa+'"  name="metric_name_select[]"  class="searchable-dropdown" style="width: 100%;">'+optionsList+'</select><input type="hidden" class="form-control form-control-sm metricName metric_name_cls_'+increa+'" maxlength="200" name="metric_name[]" placeholder="Impact metric 1" id="metricNam_1"><span class="name_msg hidden_cls text-danger" id="name_msg_' + increa + '">Enter metric</span></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[0]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[1]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[2]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[3]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[4]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[5]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[6]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[7]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[8]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[9]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[10]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td>' +
            '<td><input type="text" name="metric_<?= strtolower($get_month_list[11]); ?>_1" value="" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00"></td></tr>';
            $('#metric_add').append(datas);
			 $('#metric_tr_' + increa + ' .searchable-dropdown').select2();
        }
    });
function deleteMetric(id) {
    $('#deletemodal').modal('show');
    $('#impt_val').val(id);
}
function loadYear(year) {
    var inv_id = $('#innovation_id').val();
    window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/impact/' + inv_id + '/' + year;
}


/* impact or metric delete function */
function deleteAddmore(divid, divtype) {
    if (divtype == 'impact') {

    }
}

$(document).on('click', '.saveContinue', function (e) {
    var err = 0;
    var html;
    $('.impact').each(function () {
        var impact = this.value;
        if (impact == '') {
            html = $(this).next('.impact_msg').show();
            err = 1;
            return false;
        } else {
            html = $(this).next('.impact_msg').hide();
        }
    });
    $('.value').each(function () {
        var impValue = this.value;
        if (impValue == '') {
            html = $(this).next('.value_msg').show();
            err = 1;
            return false;
        } else {
            html = $(this).next('.value_msg').hide();
        }
    });
        //                                    $('.metricName').each(function () {
        //                                        var inc = key + 1;
        //                                        var metric_nam = this.value;
        //                                        if (metric_nam == '') {
        //                                            html = $(this).next('.name_msg').show();
        //                                            err = 1;
        //                                            return false;
        //                                        } else {
        //                                            html = $(this).next('.name_msg').hide();
        //                                        }
        //                                    });
        $('.metric').each(function (key) {
            var inc = key + 1;
            var metric_nam = $('#metricNam_' + inc).val();
            var metric = this.value;
            if (metric_nam != '') {
                if (metric == '') {
                    html = $(this).next('.metric_msg').show();
                    err = 1;
                    return false;
                } else {
                    html = $(this).next('.metric_msg').hide();
                }
            }
        });
        if (err == 0) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#impact_form').submit();
        }
    });

$(document).ready(function () {
    load_end_total_apr();
    load_end_total_may();
    load_end_total_jun();
    load_end_total_jul();
    load_end_total_aug();
    load_end_total_sep();
    load_end_total_oct();
    load_end_total_nov();
    load_end_total_dec();
    load_end_total_jan();
    load_end_total_feb();
    load_end_total_mar();

    load_direct_total_apr();
    load_direct_total_may();
    load_direct_total_jun();
    load_direct_total_jul();
    load_direct_total_aug();
    load_direct_total_sep();
    load_direct_total_oct();
    load_direct_total_nov();
    load_direct_total_dec();
    load_direct_total_jan();
    load_direct_total_feb();
    load_direct_total_mar();

    load_indirect_total_apr();
    load_indirect_total_may();
    load_indirect_total_jun();
    load_indirect_total_jul();
    load_indirect_total_aug();
    load_indirect_total_sep();
    load_indirect_total_oct();
    load_indirect_total_nov();
    load_indirect_total_dec();
    load_indirect_total_jan();
    load_indirect_total_feb();
    load_indirect_total_mar();
});

$(document).on('keyup', '.end_apr', function () {
    load_end_total_apr();
});

$(document).on('keyup', '.end_may', function () {
    load_end_total_may();
});

$(document).on('keyup', '.end_jun', function () {
    load_end_total_jun();
});

$(document).on('keyup', '.end_jul', function () {
    load_end_total_jul();
});

$(document).on('keyup', '.end_aug', function () {
    load_end_total_aug();
});

$(document).on('keyup', '.end_sep', function () {
    load_end_total_sep();
});

$(document).on('keyup', '.end_oct', function () {
    load_end_total_oct();
});

$(document).on('keyup', '.end_nov', function () {
    load_end_total_nov();
});

$(document).on('keyup', '.end_dec', function () {
    load_end_total_dec();
});

$(document).on('keyup', '.end_jan', function () {
    load_end_total_jan();
});

$(document).on('keyup', '.end_feb', function () {
    load_end_total_feb();
});

$(document).on('keyup', '.end_mar', function () {
    load_end_total_mar();
});

function load_end_total_apr() {
    var a = 0;
    $(".end_apr").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#end_tot_apr').val(a);
}

function load_end_total_may() {
    var a = 0;
    $(".end_may").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#end_tot_may').val(a);
}

function load_end_total_jun() {
    var a = 0;
    $(".end_jun").each(function () {
        if ($(this).val() != '') {
            a += parseInt($(this).val());
        }
    });
    $('#end_tot_jun').val(a);
}

function load_end_total_jul() {
    var a = 0;
    $(".end_jul").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#end_tot_jul').val(a);
}

function load_end_total_aug() {
    var a = 0;
    $(".end_aug").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#end_tot_aug').val(a);
}

function load_end_total_sep() {
    var a = 0;
    $(".end_sep").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#end_tot_sep').val(a);
}

function load_end_total_oct() {
    var a = 0;
    $(".end_oct").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#end_tot_oct').val(a);
}

function load_end_total_nov() {
    var a = 0;
    $(".end_nov").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#end_tot_nov').val(a);
}

function load_end_total_dec() {
    var a = 0;
    $(".end_dec").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#end_tot_dec').val(a);
}

function load_end_total_jan() {
    var a = 0;
    $(".end_jan").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#end_tot_jan').val(a);
}

function load_end_total_feb() {
    var a = 0;
    $(".end_feb").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#end_tot_feb').val(a);
}

function load_end_total_mar() {
    var a = 0;
    $(".end_mar").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#end_tot_mar').val(a);
}


$(document).on('keyup', '.direct_apr', function () {
    load_direct_total_apr();
});

$(document).on('keyup', '.direct_may', function () {
    load_direct_total_may();
});

$(document).on('keyup', '.direct_jun', function () {
    load_direct_total_jun();
});

$(document).on('keyup', '.direct_jul', function () {
    load_direct_total_jul();
});

$(document).on('keyup', '.direct_aug', function () {
    load_direct_total_aug();
});

$(document).on('keyup', '.direct_sep', function () {
    load_direct_total_sep();
});

$(document).on('keyup', '.direct_oct', function () {
    load_direct_total_oct();
});

$(document).on('keyup', '.direct_nov', function () {
    load_direct_total_nov();
});

$(document).on('keyup', '.direct_dec', function () {
    load_direct_total_dec();
});

$(document).on('keyup', '.direct_jan', function () {
    load_direct_total_jan();
});

$(document).on('keyup', '.direct_feb', function () {
    load_direct_total_feb();
});

$(document).on('keyup', '.direct_mar', function () {
    load_direct_total_mar();
});

function load_direct_total_apr() {
    var a = 0;
    $(".direct_apr").each(function () {
        if ($(this).val() != '') {
            a += parseInt($(this).val());
        }
    });
    $('#direct_tot_apr').val(a);
}

function load_direct_total_may() {
    var a = 0;
    $(".direct_may").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#direct_tot_may').val(a);
}

function load_direct_total_jun() {
    var a = 0;
    $(".direct_jun").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#direct_tot_jun').val(a);
}

function load_direct_total_jul() {
    var a = 0;
    $(".direct_jul").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#direct_tot_jul').val(a);
}

function load_direct_total_aug() {
    var a = 0;
    $(".direct_aug").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#direct_tot_aug').val(a);
}

function load_direct_total_sep() {
    var a = 0;
    $(".direct_sep").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#direct_tot_sep').val(a);
}

function load_direct_total_oct() {
    var a = 0;
    $(".direct_oct").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#direct_tot_oct').val(a);
}

function load_direct_total_nov() {
    var a = 0;
    $(".direct_nov").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#direct_tot_nov').val(a);
}

function load_direct_total_dec() {
    var a = 0;
    $(".direct_dec").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#direct_tot_dec').val(a);
}

function load_direct_total_jan() {
    var a = 0;
    $(".direct_jan").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#direct_tot_jan').val(a);
}

function load_direct_total_feb() {
    var a = 0;
    $(".direct_feb").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#direct_tot_feb').val(a);
}

function load_direct_total_mar() {
    var a = 0;
    $(".direct_mar").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#direct_tot_mar').val(a);
}


$(document).on('keyup', '.indirect_apr', function () {
    load_indirect_total_apr();
});

$(document).on('keyup', '.indirect_may', function () {
    load_indirect_total_may();
});

$(document).on('keyup', '.indirect_jun', function () {
    load_indirect_total_jun();
});

$(document).on('keyup', '.indirect_jul', function () {
    load_indirect_total_jul();
});

$(document).on('keyup', '.indirect_aug', function () {
    load_indirect_total_aug();
});

$(document).on('keyup', '.indirect_sep', function () {
    load_indirect_total_sep();
});

$(document).on('keyup', '.indirect_oct', function () {
    load_indirect_total_oct();
});

$(document).on('keyup', '.indirect_nov', function () {
    load_indirect_total_nov();
});

$(document).on('keyup', '.indirect_dec', function () {
    load_indirect_total_dec();
});

$(document).on('keyup', '.indirect_jan', function () {
    load_indirect_total_jan();
});

$(document).on('keyup', '.indirect_feb', function () {
    load_indirect_total_feb();
});

$(document).on('keyup', '.indirect_mar', function () {
    load_indirect_total_mar();
});

function load_indirect_total_apr() {
    var a = 0;
    $(".indirect_apr").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#indirect_tot_apr').val(a);
}

function load_indirect_total_may() {
    var a = 0;
    $(".indirect_may").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#indirect_tot_may').val(a);
}

function load_indirect_total_jun() {
    var a = 0;
    $(".indirect_jun").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#indirect_tot_jun').val(a);
}

function load_indirect_total_jul() {
    var a = 0;
    $(".indirect_jul").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#indirect_tot_jul').val(a);
}

function load_indirect_total_aug() {
    var a = 0;
    $(".indirect_aug").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#indirect_tot_aug').val(a);
}

function load_indirect_total_sep() {
    var a = 0;
    $(".indirect_sep").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#indirect_tot_sep').val(a);
}

function load_indirect_total_oct() {
    var a = 0;
    $(".indirect_oct").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#indirect_tot_oct').val(a);
}

function load_indirect_total_nov() {
    var a = 0;
    $(".indirect_nov").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#indirect_tot_nov').val(a);
}

function load_indirect_total_dec() {
    var a = 0;
    $(".indirect_dec").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#indirect_tot_dec').val(a);
}

function load_indirect_total_jan() {
    var a = 0;
    $(".indirect_jan").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#indirect_tot_jan').val(a);
}

function load_indirect_total_feb() {
    var a = 0;
    $(".indirect_feb").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#indirect_tot_feb').val(a);
}

function load_indirect_total_mar() {
    var a = 0;
    $(".indirect_mar").each(function () {
        var get_val = $(this).val();
        var check_val = get_val.replace(/[^0-9.-]+/g, "");
        if (check_val != '') {
            a += parseInt(check_val);
        }
    });
    $('#indirect_tot_mar').val(a);
}


$(document).on('change', '.searchable-dropdown', function() {
	var currentValue =  $(this).val();
	var selectedItem = $(this).attr('data-attr-metric-cls');
	if (selectedItem) {
		$("."+selectedItem).val(currentValue); 
	}
});

</script>

<style>
    /*.tox{height:auto !important;}*/
    .impact_div table tr td input {
        width: 49px !important;
    }
    .table_configcontentnew .tabpanel-title h4{
        font-size: 14px;
        padding: 12px 15px;
    }
    .table_configcontentnew .tabpanel-title a{
        padding: 8px 0;
        margin: 0;
    }
    .total_calc td input{
        border-radius: 4px;
        box-shadow: none;
        outline: none;
        border: 1px solid #ccc;
        padding: 2px 7px;
        background: #fff;
        opacity: 1 !important;
    }
    .iris_code_plan {
        width: 70px !important;
    }
</style>

</body>
</html>