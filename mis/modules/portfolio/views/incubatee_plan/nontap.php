<?php
$innovation = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $innovation['name_of_enterprise'];
$reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Plan', 'company_name' => $company_name, 'port_action' => 'plan', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'fin_year' => $current_financial, 'add_class' => 'mar-tp140'));

if ((isset($this->session->userdata['sector_lead']) && $this->session->userdata['sector_lead'] == 1) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
    $notify_icon = isset($dataConfig) ? $dataConfig : '';
} else {
    $notify_icon = '';
}
$field_enable = '0';
?>

<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Record(s) deleted successfully</div>
    <?php if ($this->session->userdata['approve_success'] == '1') { ?>
        <div id="approveMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Partnership details approved successfully</div>
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
                        <a class="nav-item nav-link bg-trasnparent brd-none" id="nav-about-tab"  href="#nav-about"  aria-controls="nav-about" aria-selected="false">&nbsp;</a>
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
<?php $this->load->view('config_left_menu.php', array('class_name' => 'nontapDiv', 'configData' => $dataConfig, 'approvals' => $approvals, 'fin_year' => $current_financial)); ?>
                            </div>
                            <main class="page-content" id="pageContent">
                                <div class="row dataconfig">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad0">
                                        <h4>Mentors &amp; Partnerships</h4>
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
                                <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <li class="tab-slider--triggerform "><a href="<?= base_url() . 'index.php/portfolio/mentor/' . $innovation_id . '/' . $current_financial; ?>">Mentor&nbsp;
                                                    <?php if ($notify_icon != '' && $approvals[0]['mentor_approval'] == 2) { ?>
                                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
<?php } ?>
                                                </a></li>
                                            <li class="tab-slider--triggerform "><a href="<?= base_url() . 'index.php/portfolio/tap/' . $innovation_id . '/' . $current_financial; ?>">Technical Assistance&nbsp;
                                                    <?php if ($notify_icon != '' && $approvals[0]['tap_approval'] == 2) { ?>
                                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
<?php } ?>
                                                </a></li>
                                            <li class="tab-slider--triggerform active"><a href="javascript:void(0)">Partnerships&nbsp;
                                                    <?php if ($notify_icon != '' && $approvals[0]['nontap_approval'] == 2) { ?>
                                                        <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
<?php } ?>
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="tab-slider--container innerTabsPlansetup">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <div class="inputplan-structureall plan-structure-new wdt-100">
                                            <form id="nontapForm" method="POST" action="<?php echo base_url() . 'index.php/portfolio/addNonTap'; ?>" autocomplete="off">
                                                <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                <input type='hidden' name='cur_finance' id="cur_finance" value="<?= $current_financial; ?>">
                                                <input type='hidden' name='updatePlan' id="updatePlan" value="0">
                                                <input type='hidden' name='module_id' id="module_id" value="11">

                                                <div class="Plan-structure">
												
												
												 <div class="row">
                                                        <div class="col-xl-7 col-md-7 col-lg-7 col-12">
                                                            <div class="quaterlyNewplanstru">
                                                                <!--<h4>Partnerships Targets</h4>-->
                                                            </div>
                                                        </div>
                                                    </div>
													
													<div class="quaterlyNewplanstru">
                                                        <?php /* <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                                <?php if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['nontap_approval'] == 2) { ?>
                                                                    <h4>Partnerships Targets <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                                <?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['nontap_approval'] == 3) { ?>
                                                                    <h4>Partnerships Targets <span class="text-success"><small>(Approved)</small></span></h4>
                                                                <?php } else { ?>
                                                                    <h4>Partnerships Targets</h4>
                                                            <?php } ?>
                                                            </div>
<?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['nontap_approval'] == 2) { ?>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right">
                                                                    <div class="approved-btn text-right">
                                                                        <button type="button" class="btn btn-success capitilize">Approve</button>
                                                                        <div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<?php } ?>
                                                        </div> */ ?>
														<div class="row">
                                                            <div class="col-xl-12 col-lg-6 col-md-6 col-12" style="display:flex;">
                                                                <?php if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['nontap_approval'] == 2) { ?>
                                                                    <h4>Partnerships Targets <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                                <?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['nontap_approval'] == 3) { ?>
                                                                    <h4>Partnerships Targets <span class="text-success"><small>(Approved)</small></span></h4>
                                                                <?php } else { ?>
                                                                    <h4>Partnerships Targets</h4>
                                                            <?php } ?>
															<?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['nontap_approval'] == 2) { ?>
                                                                <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right"> -->
                                                                    <div class="approved-btn text-right">
                                                                        <button type="button" style="margin-left: 5px;margin-top: -14px;" class="btn btn-success capitilize">Approve</button>
                                                                        <div>
                                                                        </div>
                                                                  <!--  </div>-->
                                                                </div>
<?php } ?>
                                                            </div>

                                                        </div> 


														</div>
														
														

                                                    <div class="table_configcontentnew">
                                                        <div class="tabpanel-title ">
                                                            <div class="row">
                                                                <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                    <h4>Partnerships Details</h4>
                                                                </div>
<?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                        <ul class="milestone-links">
                                                                            <li><a href="javascript:void(0)" id="addMore"><i
                                                                                        class="fas fa-plus-circle"></i> Add New</a></li>
                                                                            <li class="brd-left-onboard" id='editSec'><a href="javascript:void(0)" id="editBtn"><i
                                                                                        class="fas fa-pencil-alt"></i> Edit</a></li>
                                                                            <li class="brd-left-onboard" id="disableBtn">
                                                                                <a class="deleteControl" id="deleteBtn" href="javascript:void(0)"><i class="fas fa-trash"></i>
                                                                                    Delete</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
<?php } ?>
                                                            </div>
                                                        </div>
                                                        <div id='accordion'>
                                                            <table class="table" id="type_sel">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="5%"></th>
                                                                        <th width="10%">S. No</th>
																		<th width="14%" class="text-center">Program</th>
                                                                        <th width="20%">Type</th>
                                                                        <th width="20%">Partner's Name</th>
                                                                        <th width="15%">Target End Date</th>
                                                                        <th width="30%">Notes</th>
                                                                    </tr>
                                                                </thead>
                                                                <?php
                                                                $recordCount = isset($get_nontap[0]) ? php72_count($get_nontap) : 1;
                                                                for ($i = 0; $i < $recordCount; $i++) {
                                                                    $need_date = (isset($get_nontap[$i]['need_by']) && $get_nontap[$i]['need_by'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($get_nontap[$i]['need_by'])) : '';
                                                                    ?>
                                                                    <tbody class="add_more_nontap">
                                                                        <tr>
                                                                            <td width="5%">
    <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                                    <div class="input-group">
                                                                                        <input type="checkbox" class="check_box"
                                                                                               aria-label="Checkbox for following text input"
                                                                                               name="check_delete"
                                                                                               value="<?php echo $get_nontap[$i]['id']; ?>"
                                                                                    </div>
    <?php } ?>
                                                                            </td>
                                                                            <td width="10%" class="serial_index"><?php echo $i + 1; ?></td>
																			 <td>
                                                                            <select class="form-control form-control-sm program" name="program[]" id="program_<?php echo $j; ?>">
                                                                                <option value="">-Select-</option>
                                                                                <?php
                                                                               foreach ($program_type as $programData) {
                                                                                    if ($get_nontap[$i]['program'] == $programData['id']) {
                                                                                        $selected = 'selected';
                                                                                    } else {
                                                                                        $selected = '';
                                                                                    }
                                                                                    ?>
                                                                                    <option value="<?php echo $programData['id']; ?>" <?= $selected; ?> ><?php echo $programData['program_name']; ?></option>
																			<?php }   ?>
                                                                            </select>
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                            <td width="20%">
                                                                                <select class="form-control form-control-sm partnet_type" name="partnet_type[]" id="partnet_type">
                                                                                    <option value="">-Select-</option>
                                                                                    <?php foreach ($partner_type as $partner) { ?>
                                                                                        <option value="<?= $partner['id']; ?>" <?php if ($get_nontap[$i]['type'] == $partner['id']) { ?> selected <?php } ?>><?= $partner['name']; ?></option>
    <?php } ?>
                                                                                </select>
                                                                            </td>
                                                                            <td width="20%">
                                                                                <input type="text" name="name[]" class="form-control form-control-sm partnerNam" value="<?= $get_nontap[$i]['partner_name']; ?>" maxlength="50">
                                                                            </td>
                                                                            <td width="15%">
                                                                                <input type="text" id="startDate_<?= $i; ?>" value="<?php echo $need_date; ?>" name="need_by[]" class="need_by form-control form-control-sm dateCalendar" placeholder="dd-mm-yyyy">
                                                                            </td>
                                                                            <td width="30%">
                                                                                <input type="text" id="nontap_notes_<?= $i; ?>" value="<?= $get_nontap[$i]['notes']; ?>" name="nontap_notes[]" class="nontap_notes form-control form-control-sm">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <input type="hidden" id="enableCount" value="<?= php72_count($get_nontap); ?>">
                                                                    <input type="hidden" name="id[]" class="tapid" value="<?php echo $get_nontap[$i]['nontap_id']; ?>" />
<?php } ?>
                                                                <tbody id='nontap_add'></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
													
													
													<hr><br><br>
                                                    <div class="quaterlyNewplanstru">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                                <?php /* if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['nontap_approval'] == 2) { ?>
                                                                    <h4>Partnerships Plan <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                                <?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['nontap_approval'] == 3) { ?>
                                                                    <h4>Partnerships Plan <span class="text-success"><small>(Approved)</small></span></h4>
                                                                <?php } else { ?>
                                                                    <h4>Partnerships Plan</h4>
                                                            <?php } */ ?>
															<h4>Partnerships Plan</h4>
                                                            </div>
<?php /* if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['nontap_approval'] == 2) { ?>
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
</div>
</div>
</div>

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
                            <p>you are about delete <span id="delCount"></span> selected information fields, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
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

    function onLoad() {
        var cur_mnth = $('#active_editor').val();
        if (cur_mnth != '')
            highlightQuarter(cur_mnth);

        $('#exampleModal').modal('show');
        var editOpt = $('#enableCount').val();
        var enable_form = "<?= $field_enable; ?>";
        if (editOpt > 0 || enable_form == 0) {
            /*$('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').css("pointer-events", "none");
            $('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').addClass('opacity5');*/
            $('input[type="text"], #type_sel select').attr('readonly', 'readonly');
            $('#type_sel select, .dateCalendar').css('pointer-events', 'none');
        } else {
            $(".dateCalendar").datepicker({dateFormat: "dd-mm-yy"});
        }
        $('#editBtn').addClass('opacity5');
        $('#disableBtn').css("cursor", "not-allowed");
        $('#deleteBtn').css("pointer-events", "none");
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

    $(document).on('click', '#addMore', function () {
        var i = 0;
        var datas = $('.add_more_nontap').html();
        $('#nontap_add').append(datas);
        $('.partnet_type').each(function (key, value) {
            $('#nontap_add').find('.check_box:last').val('');
            $('#nontap_add').find('.tapid:last').val('');
            $('#nontap_add').find('.partnet_type:last').val('').attr('readonly', false).css('pointer-events', 'visible');
			$('#nontap_add').find('.program:last').val('').attr('readonly', false).css('pointer-events', 'visible');
            $('#nontap_add').find('.partnerNam:last').val('').attr('readonly', false);
            $('#nontap_add').find('.need_by:last').val('').attr('readonly', false).css('pointer-events', '');
            $('#nontap_add').find('.nontap_notes:last').val('').attr('readonly', false).css('pointer-events', '');
            $('#nontap_add').find('.serial_index:last').html(i + 1);
            $("#nontap_add").find(".need_by:last").removeAttr('id').removeClass('hasDatepicker').val('');
            $("#nontap_add").find(".need_by:last").attr('id', 'startDate_' + i);
            $("#nontap_add").find(".need_by:last").datepicker({dateFormat: "dd-mm-yy"});
            i = i + 1;
        });
    });

    $(document).on('click', '#editBtn', function () {
        $('#editSec').html('<a href="javascript:void(0)" id="cancelBtn"><i class="fas fa-times"></i> Cancel</a>');
        $('.saveContinue').text('Save');
        $('#updatePlan').val('1');
        $('#editBtn').removeClass('opacity5');
        $('input[type="text"], #type_sel select').attr('readonly', false);
        $('#type_sel select, .dateCalendar').css('pointer-events', '');
        $(".dateCalendar").datepicker({dateFormat: "dd-mm-yy"});
    });

    $(document).on('click', '#cancelBtn', function () {
        $('#editSec').html('<a href="javascript:void(0)" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a>');
        $('.saveContinue').text('Save');
        $('#updatePlan').val('0');
        onLoad();
    });

    $('#deleteBtn').on('click', function () {
        $('#deletemodal').modal('show');
        var sel_item = $("input:checkbox[name=check_delete]:checked").length;
        $('#delCount').html(sel_item);
    });

    $(document).on('click', '.check_box', function () {
        if ($("#nontapForm input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
        }
    });

    function deleteMore() {
        if ($("#nontapForm input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
        }
    }

    $('#deleteRecord').on('click', function () {
        var deleteId = new Array();
        $("input:checkbox[name=check_delete]:checked").each(function () {
            deleteId.push($(this).val());
        });

        if ($("#nontapForm input:checkbox:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deletePortfolioDetail",
                data: {
                    id: deleteId,
                    table: 'port_ttm_partnership',
                    plan_table: 'plan_partnerships',
                    plan_field: 'port_nontap_id',
                    temp_table: 'temp_ttm_partnership',
                    temp_field: 'nontap_id'
                },
                dataType: 'json',
                success: function (msg) {
                    $('#accordion').load(location.href + ' #accordion');
                    $('#deletemodal').modal('hide');
                    $('#deleteMsg').show();
                    setTimeout(function () {
                        deleteMore();
                        onLoad();
                    }, 500);
                    setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000);
                }
            });
        }
    });

    $(document).on('click', '.saveContinue', function (e) {
        if ($('#nontapForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#nontapForm').submit();
        }
    });

    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/nontap/' + inv_id + '/' + year;
    }

    $(document).on('click', '.capitilize', function () {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#cur_finance').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/nontapApproved",
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