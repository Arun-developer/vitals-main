<?php
$innovation = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $innovation['name_of_enterprise'];
$reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];

$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Plan', 'company_name' => $company_name, 'port_action' => 'plan', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'fin_year' => $current_financial, 'add_class' => 'mar-tp140'));

$assign_mentor = $villgro_mentor[0];
$assign_mentor_count = isset($assign_mentor) ? php72_count($villgro_mentor) : 1;

$men_data = $config_mentor[0];
$mentorData_count = isset($men_data) ? php72_count($config_mentor) : $assign_mentor_count;

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
        <div id="approveMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Mentor details approved successfully</div>
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
                    <form id="mentorForm" method="POST" action="<?php echo base_url() . 'index.php/portfolio/addMentor'; ?>" autocomplete="off" enctype="multipart/form-data">
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
                                                <li><a class="saveContinue" href="javascript:void(0)">Save</a></li>
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
                                    <?php $this->load->view('config_left_menu.php', array('class_name' => 'mentorDiv', 'configData' => $dataConfig, 'approvals' => $approvals, 'fin_year' => $current_financial)); ?>
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
                                                <li class="tab-slider--triggerform active"><a href="javascript:void(0)">Mentor&nbsp;
                                                        <?php if ($notify_icon != '' && $approvals[0]['mentor_approval'] == 2) { ?>
                                                            <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                        <?php } ?>
                                                    </a></li>
                                                <li class="tab-slider--triggerform "><a href="<?= base_url() . 'index.php/portfolio/tap/' . $innovation_id . '/' . $current_financial; ?>">Technical Assistance&nbsp;
                                                        <?php if ($notify_icon != '' && $approvals[0]['tap_approval'] == 2) { ?>
                                                            <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                                        <?php } ?>
                                                    </a></li>
                                                <li class="tab-slider--triggerform "><a href="<?= base_url() . 'index.php/portfolio/nontap/' . $innovation_id . '/' . $current_financial; ?>">Partnerships&nbsp;
                                                        <?php if ($notify_icon != '' && $approvals[0]['nontap_approval'] == 2) { ?>
                                                            <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                                        <?php } ?>
                                                    </a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="tab-slider--container innerTabsPlansetup">
                                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                            <div class="inputplan-structureall plan-structure-new wdt-100">
                                                <div class="Plan-structure">
												
												
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
                                                            <?php if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['mentor_approval'] == 2) { ?>
                                                                    <h5>Mentors Targets <span class="text-danger"><small>(Awaiting approval)</small></span></h5>
                                                                <?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['mentor_approval'] == 3) { ?>
                                                                    <h5>Mentors Targets <span class="text-success"><small>(Approved)</small></span></h5>
                                                                <?php } else { ?>
                                                                    <h5>Mentors Targets</h5>
                                                                <?php } ?>
                                                        </div>
                                                       <?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['mentor_approval'] == 2) { ?>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right">
                                                                <div class="approved-btn text-right">
                                                                    <button type="button" class="btn btn-success capitilize">Approve</button>
                                                                    <div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
														
														 */ ?>
														<div class="col-xl-12 col-lg-6 col-md-6 col-12" style="display:flex;">
															 <?php if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['mentor_approval'] == 2) { ?>
																	<h5>Mentors Targets <span class="text-danger"><small>(Awaiting approval)</small></span></h5>
																<?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['mentor_approval'] == 3) { ?>
																	<h5>Mentors Targets <span class="text-success"><small>(Approved)</small></span></h5>
																<?php } else { ?>
																	<h5>Mentors Targets</h5>
																<?php } ?>
															  <?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['mentor_approval'] == 2) { ?>
																<!--<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right"> -->
																	<div class="approved-btn text-right">
																		<button type="button" style="margin-left: 5px;margin-top: -14px;"  class="btn btn-success capitilize">Approve</button>
																		<div>
																		</div>
																	</div>
																 <!-- </div>-->
															 <?php } ?>
															 <div class="text-right" id='editImpactSec' style="margin-left: auto; ">
																<?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
																	<a href="javascript:void(0)" id="editImpact" class="edit-btnconfig mar-bt15 display-block mar-rt5"><i class="fas fa-pencil-alt"></i> Edit</a>
																<?php } ?>
															</div>
														</div>
														
                                                </div>
														
														
														

                                                    <div>
                                                        <table class="table mentor_tbl" style="margin-top:0;">
                                                            <thead>
                                                                <tr>
                                                                    <th width="40%">Period <small>(per Quarter)</small></th>
                                                                    <th width="15%"class="text-center">Q1</th>
                                                                    <th width="15%"class="text-center">Q2</th>
                                                                    <th width="15%"class="text-center">Q3</th>
                                                                    <th width="15%"class="text-center">Q4</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="vill-gray">No. of mentors </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm mentorfld" name="mentor[]" placeholder="00" maxlength="6" value="<?php echo $mentor_master_data[0]['mentor_qone']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm mentorfld" name="mentor[]" placeholder="00" maxlength="6" value="<?php echo $mentor_master_data[0]['mentor_qtwo']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm mentorfld" name="mentor[]" placeholder="00" maxlength="6" value="<?php echo $mentor_master_data[0]['mentor_qthree']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm mentorfld" name="mentor[]" placeholder="00" maxlength="6" value="<?php echo $mentor_master_data[0]['mentor_qfour']; ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="vill-gray">No. of hours </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm volumefld" name="quarter[]" placeholder="00" maxlength="6" value="<?php echo $mentor_master_data[0]['quarter_one']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm volumefld" name="quarter[]" placeholder="00" maxlength="6" value="<?php echo $mentor_master_data[0]['quarter_two']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm volumefld" name="quarter[]" placeholder="00" maxlength="6" value="<?php echo $mentor_master_data[0]['quarter_three']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm volumefld" name="quarter[]" placeholder="00" maxlength="6" value="<?php echo $mentor_master_data[0]['quarter_four']; ?>">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div>
                                                            <input type="hidden" name="mentor_master_id" id="mentor_master_id" value="<?= $mentor_master_data[0]['id']; ?>">
                                                            <div class="table_configcontentnew pad-bt0">
                                                                <div class="tabpanel-title">
                                                                    <div class="row">
                                                                        <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                            <h4>Mentors Details</h4>
                                                                        </div>
                                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                            <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                                <ul class="milestone-links">
                                                                                    <li><a href="javascript:void(0)" id="addMore"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a> </li>
                                                                                    <li class="brd-left-onboard" id="editMentor"><a href="javascript:void(0)" id="edit_mentor"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a></li>
                                                                                    <li class="brd-left-onboard" id="disableBtn">
                                                                                        <a class="deleteControl" href="javascript:void(0)" id="deleteBtn"><i class="fas fa-trash"></i>&nbsp;Delete</a>
                                                                                    </li>
                                                                                </ul>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" table_configcontentnew">
                                                                <table class="table mentor-table" id="accordion">
                                                                    <thead class="mentor-table-head">
                                                                        <tr>
                                                                            <th width="4%"></th>
																			<th width="15%">Program</th>
                                                                            <th width="15%">Mentor</th>
                                                                            <th width="11%">Start Date</th>
                                                                            <th width="11%">End Date</th>
                                                                            <th width="17%">Focus Area</th>
                                                                            <th width="22%">Comments</th>
                                                                            <th width="20%">Contract</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="add_more_mentor">
                                                                        <?php
                                                                        $j = 1;
                                                                        for ($i = 0; $i < $mentorData_count; $i++) {
                                                                            if (php72_count($config_mentor) > 0) {
                                                                                $cond['id'] = $config_mentor[$i]['master_id'];
                                                                                // $mentor_details = $this->Mportfolio->getCommonData('port_villgro_relation_mentor', $cond);
                                                                                $mentor_details = $config_mentor;
                                                                                $inc = $i;
                                                                                $delete_row = 0;
                                                                                $mentor_master_id = $config_mentor[$i]['master_id'];
                                                                                $start_date = (isset($mentor_details[$inc]['start_date']) && $mentor_details[$inc]['start_date'] != '0000-00-00') ? date('d-m-Y', strtotime($mentor_details[$inc]['start_date'])) : '';
                                                                                $end_date = (isset($mentor_details[$inc]['end_date']) && $mentor_details[$inc]['end_date'] != '0000-00-00') ? date('d-m-Y', strtotime($mentor_details[$inc]['end_date'])) : '';
                                                                            } else {
                                                                                $inc = $i;
                                                                                $mentor_details = $villgro_mentor;
                                                                                $delete_row = 1;
                                                                                $mentor_master_id = '';
                                                                                $start_date = (isset($mentor_details[$inc]['start_date']) && $mentor_details[$inc]['start_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($mentor_details[$inc]['start_date'])) : '';
                                                                                $end_date = (isset($mentor_details[$inc]['end_date']) && $mentor_details[$inc]['end_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($mentor_details[$inc]['end_date'])) : '';
                                                                            }
                                                                            ?>

                                                                            <tr id="mentor_tr_<?php echo $j; ?>" class="mentor_more">
																			
																		
                                                                                <td>
                                                                                    <?php
                                                                                    if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
                                                                                        if ($delete_row == 0) {
                                                                                            ?>
                                                                                            <input type="checkbox" class="check_box"
                                                                                                   aria-label="Checkbox for following text input"
                                                                                                   name="check_delete" id="check_delete_<?php echo $j; ?>"
                                                                                                   value="<?php echo $mentor_details[$inc]['id']; ?>">
                                                                                                   <?php
                                                                                               } else if (php72_count($villgro_mentor) > 0 && $delete_row == 1) {
                                                                                                   ?>
                                                                                            <span class="cursor" title="Remove" onclick="hideRow(<?= $j; ?>);"><i class="fas fa-minus-circle"></i></span>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </td>
																				<td>
																				<select class="form-control form-control-sm program" name="program[]" id="program_<?php echo $j; ?>">
																					<option value="">-Select-</option>
																					<?php
																				   foreach ($program_type as $programData) {
																						if ($mentor_details[$inc]['program'] == $programData['id']) {
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

                                                                                <td>
                                                                                    <select class="form-control form-control-sm mentorDiv" name="name[]" id="mentor_name_<?php echo $j; ?>">
                                                                                        <option value="">-Select-</option>
                                                                                        <?php
                                                                                        foreach ($emp_details as $emps) {
                                                                                            if ($mentor_details[$inc]['name'] == $emps['emp_number']) {
                                                                                                $selected = 'selected';
                                                                                            } else {
                                                                                                $selected = '';
                                                                                            }
                                                                                            ?>
                                                                                            <option value="<?php echo $emps['emp_number']; ?>" <?= $selected; ?> ><?php echo $emps['emp_name']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </td>

                                                                                <td>
                                                                                    <input type="text"
                                                                                           class="form-control form-control-sm startDat dateCalendar"
                                                                                           placeholder="dd-mm-yyyy" name="start_date[]"
                                                                                           id="startDate_<?= $i; ?>"
                                                                                           value="<?php echo $start_date; ?>">
                                                                                </td>

                                                                                <td>
                                                                                    <input type="text"
                                                                                           class="form-control form-control-sm endDat dateCalendar"
                                                                                           placeholder="dd-mm-yyyy" name="end_date[]"
                                                                                           id="endDate_<?= $i; ?>"
                                                                                           value="<?php echo $end_date; ?>">
                                                                                </td>

                                                                                <td>
                                                                                    <select class="form-control form-control-sm focus_area" name="focus_area[]" id="focus_area_<?php echo $j; ?>">
                                                                                        <option value="">-Select-</option>
                                                                                        <?php
                                                                                        foreach ($focus_area as $area) {
                                                                                            if ($mentor_details[$inc]['area'] == $area['id']) {
                                                                                                $selected = 'selected';
                                                                                            } else {
                                                                                                $selected = '';
                                                                                            }
                                                                                            ?>
                                                                                            <option value="<?php echo $area['id']; ?>" <?= $selected; ?> ><?php echo $area['name']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </td>

                                                                                <td>
                                                                                    <textarea class="form-control form-control-sm focus_area" name="comments[]" id="comments_<?php echo $j; ?>"><?php echo $mentor_details[$inc]['comment']; ?></textarea>
    <!--                                                                                            <input type="text"
                                                                                               class="form-control form-control-sm focus_area"
                                                                                               name="comments[]" id="comments_<?php echo $j; ?>"
                                                                                               value="<?php echo $mentor_details[$inc]['comment']; ?>" maxlength="100">-->
                                                                                </td>

                                                                                <td class="sowFile">
                                                                                    <div class="fileUpload blue-btn btn">
                                                                                        <?php
                                                                                        if (isset($mentor_details[$inc]['sow_document']) && !empty($mentor_details[$inc]['sow_document'])) {
                                                                                            echo strlen($mentor_details[$inc]['sow_document']) > 15 ? "..." . substr($mentor_details[$inc]['sow_document'], -15) : $mentor_details[$inc]['sow_document'];
                                                                                            ?>

                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                                                        <?php } ?>
                                                                                        <input type="file" class="uploadlogo" id="upLogo_<?= $j; ?>" name="sow_doc[]" />
                                                                                    </div>

                                                                                    <?php if (isset($mentor_details[$inc]['sow_document']) && !empty($mentor_details[$inc]['sow_document'])) { ?>
                                                                                        <span class="download-btn"><a class="old_file" href="<?php echo base_url() . 'uploads/portfolio/mentor/' . $mentor_details[$inc]['sow_document']; ?>"
                                                                                                                      title="Download Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                                                            <?php if ($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                                            <span><a href="javascript:void(0)" title="Delete Document" class="delete-btnconfig" onclick="delMentor('<?= $mentor_details[$inc]['id']; ?>', '<?= $mentor_master_id; ?>')" id="removeDoc"><i class="fas fa-trash"></i></a></span>
                                                                                        <?php } ?>
                                                                                    <?php } ?>
                                                                                    <input type="hidden" name="old_sow_doc[]" value="<?php echo $mentor_details[$inc]['sow_document']; ?>">

                                                                                    <span class="sow_msg hidden_cls error">Invalid file</span>
                                                                                </td>
                                                                        <input type="hidden" name="primary_id[]" value="<?= $mentor_details[$inc]['id']; ?>">
                                                                        <input type="hidden" name="config_master_id[]" value="<?= $mentor_master_id; ?>">
                                                                        </tr>
                                                                        <?php
                                                                        $j++;
                                                                    }
                                                                    ?>
                                                                    </tbody>
                                                                    <input type="hidden" id="enableCount" value="<?= php72_count($config_mentor); ?>">
                                                                    <!-- <tbody id='mentor_add'></tbody> -->
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
													
													
													
													<hr><br><br>
                                                    <div class="quaterlyNewplanstru">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                                <?php /* if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['mentor_approval'] == 2) { ?>
                                                                    <h4>Mentors Plan <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                                <?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['mentor_approval'] == 3) { ?>
                                                                    <h4>Mentors Plan <span class="text-success"><small>(Approved)</small></span></h4>
                                                                <?php } else { ?>
                                                                    <h4>Mentors Plan</h4>
                                                                <?php } */ ?>
																<h4>Mentors Plan</h4>
                                                            </div>
                                                            <?php /* if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['mentor_approval'] == 2) { ?>
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
                                                </main>
                                            </div>
                                            <input type='hidden' name='inv_id' id="inv_id" value="<?= $innovation_id; ?>">
                                            <input type='hidden' name='finance_Year' id="finance_Year" value="<?= $current_financial; ?>">
                                            <input type='hidden' name='updatePlan' id="updatePlan" value="0">
                                            <input type='hidden' name='module_id' id="module_id" value="9">
                                        </div>
                                        </form>
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
                            <p>you are about delete <span id="delCount"></span> selected information fields, you
                                can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="dltDoc" id="dltDoc" />
                <input type="hidden" name="dltMasterDoc" id="dltMasterDoc" />
                <button type="button" class="btn btn-default">
                    <a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
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
        $('.uploadlogo').next('.sow_msg').show();
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

    function pad(num) {
        var s = num + "";
        s = parseFloat(s, 10);
        return s;
    }

    $(".mentorfld").on("input", function (evt) {
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

    $(".volumefld").on("blur", function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g, ''));

        if (self.val().split('.').length >= 3) {
            self.val('');
        }

        var n = self.val();
        n = (n + "").split(".")[1];
        if (n == undefined) {
            var flval = parseFloat(self.val());
            var self_val = Number(flval.toFixed(2));
            var decim = pad(self_val);
            self.val(decim);
            if (self_val >= 0 || self_val == '') {
                self.val(self_val);
            } else {
                self.val(0);
            }
        } else if (n.length == 1) {
            var flval = parseFloat(self.val());
            var self_val = Number(flval.toFixed(2));
            var decim = pad(self_val);
            self.val(decim);
            var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{1}/i);
            var matchedString = self.val().match(patt);
            if (matchedString) {
                var self_val = Number.parseFloat(matchedString).toFixed(1);
                self.val(self_val);
            }
        } else {
            var flval = parseFloat(self.val());
            var self_val = Number(flval.toFixed(2));
            var decim = pad(self_val);
            self.val(decim);
            var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
            var matchedString = self.val().match(patt);
            if (matchedString) {
                var self_val = Number.parseFloat(matchedString).toFixed(2);
                if (self_val > 0) {
                    self.val(self_val);
                }
            }
        }
    });

    $(document).on('input', '.volumefld', function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g, ''));
        //                                    self.val(inrFormat(self.val()));
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

    $(document).on('keyup', '.sow_number', function () {
        if (this.value.match(/[^a-zA-Z0-9]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
        }
    });

    function onLoad() {
        var cur_mnth = $('#active_editor').val();
        if (cur_mnth != '')
            highlightQuarter(cur_mnth);

        var editOpt = $('#enableCount').val();
        var enable_form = "<?= $field_enable; ?>";
        if (editOpt > 0 || enable_form == 0) {
            /*$('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').css("pointer-events", "none");
            $('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').addClass('opacity5');*/
            $('input[type="text"], #accordion textarea, #accordion select').attr('readonly', 'readonly');
            $('input[name="mentor[]"], input[name="quarter[]"]').attr('readonly', false);
            $('#accordion input[type="file"]').css("pointer-events", "none");
            $("#accordion select").css("pointer-events", "none");
            $(".dateCalendar").css("pointer-events", "none");
        } else {
            datepickerEachFunction();
        }
        $('#edit_mentor').addClass('opacity5');
        $('#disableBtn').css("cursor", "not-allowed");
        $('#deleteBtn').css("pointer-events", "none");
        deleteMore();
    }

    $(document).on('click', '#sendApproval', function () {
        $('#sendapproval').modal('show');
    });

    function sendApproval() {
        var inv_id = $('#inv_id').val();
        var fin_year = $('#finance_Year').val();
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

    $(document).on('change', '.uploadlogo', function () {
        var filename = readURL(this);
        var reslt = filename.split('|*|');
        $(this).parent().children('span').html(reslt[0]);
        if (reslt[1] != '1') {
            $(this).parent().parent().children('.sow_msg').show();
            $(this).parent().parent().children('.sow_msg').text(reslt[1]);
        } else {
            $(this).parent().parent().children('.sow_msg').text('');
            $(this).parent().parent().children('.sow_msg').hide();
        }
    });

    function uploadFile() {
        $(".uploadlogo").on('change', function () {
            var filename = readURL(this);
            var reslt = filename.split('|*|');
            $(this).parent().children('span').html(reslt[0]);
            if (reslt[1] != '1') {
                $(this).parent().parent().children('.sow_msg').show();
                $(this).parent().parent().children('.sow_msg').text(reslt[1]);
            } else {
                $(this).parent().parent().children('.sow_msg').text('');
                $(this).parent().parent().children('.sow_msg').hide();
            }
        });
    }

    function readURL(input) {
        var url = input.value;
        var path, filename;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        var bsize = input.files[0].size;
        var fsize = Math.round(bsize / 1024);
        if (fsize <= 10000) {
            if (input.files && input.files[0] && (ext == "pdf" || ext == "doc" || ext == "docx" || ext == "ppt" || ext == "pptx")) {
                path = $(input).val();
                filename = path.replace(/^.*\\/, "");
                return filename + '|*|1';
            } else {

                filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file';
                return filename;
            }
        } else {
            filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file size';
            return filename;
        }
    }

    function datepickerEachFunction() {
        $('.startDat').each(function (index, value) {
            $("#startDate_" + index).datepicker({
                onSelect: function (selected) {
                    $("#startDate_" + index).datepicker("option", "dateFormat", 'mm/dd/yy');
                    $("#endDate_" + index).val('');
                    var dt = new Date(selected);
                    var dateval = dt.getDate();
                    var monthval = dt.getMonth() + 1;
                    var yearval = dt.getFullYear();
                    if (monthval < 10) {
                        monthval = "0" + monthval;
                    } else {
                        monthval = monthval;
                    }
                    if (dateval < 10) {
                        dateval = "0" + dateval;
                    } else {
                        dateval = dateval;
                    }
                    var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
                    $("#startDate_" + index).val(fulldatevalue);
                    dt.setDate(dt.getDate() + 1);
                    $("#endDate_" + index).datepicker("option", {
                        minDate: dt
                    });
                }
            });
        });

        $('.endDat').each(function (index, value) {
            $("#endDate_" + index).datepicker({
                onSelect: function (selected) {
                    var dt = new Date(selected);
                    var dateval = dt.getDate();
                    var monthval = dt.getMonth() + 1;
                    var yearval = dt.getFullYear();
                    if (monthval < 10) {
                        monthval = "0" + monthval;
                    } else {
                        monthval = monthval;
                    }
                    if (dateval < 10) {
                        dateval = "0" + dateval;
                    } else {
                        dateval = dateval;
                    }
                    var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
                    $("#endDate_" + index).val(fulldatevalue);
                    dt.setDate(dt.getDate() - 1);
                }
            });
        });
    }

    $(document).on('click', '#edit_mentor', function () {
        $('.saveContinue').text('Save');
        $('#updatePlan').val('1');
        $('#editMentor').html('<a href="javascript:void(0)" id="cancel_mentor"><i class="fas fa-times"></i>&nbsp;Cancel</a>')
        $('#edit_mentor').removeClass('opacity5');
        datepickerEachFunction();
        $('input[type="text"], #accordion textarea, select').attr('readonly', false);
        $('#accordion input[type = "file"]').css("pointer-events", "");
        $("select").css("pointer-events", "");
        $(".dateCalendar").css("pointer-events", "");
    });

    $(document).on('click', '#cancel_mentor', function () {
        $('.saveContinue').text('Save');
        $('#updatePlan').val('0');
        $('#editMentor').html('<a href="javascript:void(0)" id="edit_mentor"><i class="fas fa-pencil-alt"></i>Edit</a>');
        onLoad();
    });

    $(document).on('click', '#addMore', function () {
        var dyn = $(".mentor_more").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="mentor_tr_' + i + '" class="mentor_more"><td><input type="checkbox" class="check_box" aria-label="Checkbox for following text input" name="check_delete" id="check_delete_' + i + '" value=""></td>';
        datas += '<td><select class="form-control form-control-sm name program" name="program[]" id="program_' + i + '"><option value="">-Select-</option><?php
foreach ($program_type as $programData) {?> <option value="<?php echo $programData['id']; ?>"><?php echo $programData['program_name']; ?></option> <?php } ?></select></td>';
		datas += '<td><select class="form-control form-control-sm name mentorDiv" name="name[]" id="mentor_name_' + i + '"><option value="">-Select-</option><?php
foreach ($emp_details as $emps) {
    ?> <option value="<?php echo $emps['emp_number']; ?>"><?php echo $emps['emp_name']; ?></option> <?php } ?></select></td>';
        datas += '<td><input type="text" class="form-control form-control-sm startDat dateCalendar" placeholder="dd-mm-yyyy" name="start_date[]" id="startDate_' + (i - 1) + '" value=""></td>';
        datas += '<td><input type="text" class="form-control form-control-sm endDat dateCalendar" placeholder="dd-mm-yyyy" name="end_date[]" id="endDate_' + (i - 1) + '" value=""></td>';
        datas += '<td><select class="form-control form-control-sm name focus_area" name="focus_area[]" id="focus_area_' + i + '"><option value="">-Select-</option><?php
foreach ($focus_area as $area) {
    ?> <option value="<?php echo $area['id']; ?>"><?php echo $area['name']; ?></option> <?php } ?></select></td>';
        datas += '<td><textarea class="form-control form-control-sm comments" name="comments[]" id="comments_' + i + '"></textarea></td>';
        datas += '<td class="sowFile"><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" id="upLogo_' + i + '" name="sow_doc[]" /><span class="sow_msg hidden_cls error" id="sow_msg_' + i + '">Invalid</span></div><div class="download-btn"></div><span class="sow_msg hidden_cls error" id="sow_msg_' + i + '">Invalid file</span></td></tr>';
        $(datas).insertAfter($('#mentor_tr_' + dyn));
        datepickerEachFunction();
    });

    $.validator.addMethod("maxfilesize", function (value, element) {
        return this.optional(element) || (element.files && element.files[0] && element.files[0].size <= 10008250);
    }, $.format('The file size cannot exceed 10MB'));

    $.validator.addMethod("extension", function (value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    }, "Not a valid file format");

    $('#mentorForm').validate({
        rules: {
            name: "required",
            sow_doc: {
                extension: "pdf|ppt|pptx|doc|docx",
                maxfilesize: true
            }
        },
        messages: {
            name: "Please enter manager name",
            sow_doc: {
                extension: 'Only ppt,pdf,doc files are accepted'
            }
        }
    });

    function loadYear(year) {
        var inv_id = $('#inv_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/mentor/' + inv_id + '/' + year;
    }

    function hideRow(id) {
        $('#mentor_tr_' + id).closest('tr').remove();
        var tr_count = $('.mentor_more').length;
        if (tr_count == 0) {
            var datas = '<tbody><tr id="mentor_tr_1" class="mentor_more"><td><input type="checkbox" class="check_box" aria-label="Checkbox for following text input" name="check_delete" id="check_delete_1" value=""></td>';
            datas += '<td><select class="form-control form-control-sm name mentorDiv" name="name[]" id="mentor_name_1"><option value="">-Select-</option><?php
foreach ($emp_details as $emps) {
    ?> <option value="<?php echo $emps['emp_number']; ?>" <?= $selected; ?> ><?php echo $emps['emp_name']; ?></option> <?php } ?></select></td>';
            datas += '<td><input type="text" class="form-control form-control-sm startDat dateCalendar" placeholder="dd-mm-yyyy" name="start_date[]" id="startDate_0" value=""></td>';
            datas += '<td><input type="text" class="form-control form-control-sm endDat dateCalendar" placeholder="dd-mm-yyyy" name="end_date[]" id="endDate_0" value=""></td>';
            datas += '<td><select class="form-control form-control-sm name focus_area" name="focus_area[]" id="focus_area_' + i + '"><option value="">-Select-</option><?php
foreach ($focus_area as $area) {
    ?> <option value="<?php echo $area['id']; ?>"><?php echo $area['name']; ?></option> <?php } ?></select></td>';
            datas += '<td><textarea class="form-control form-control-sm comments" name="comments[]" id="comments_' + i + '"></textarea></td>';
            datas += '<td class="sowFile"><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" id="upLogo_1" name="sow_doc[]" /><span class="sow_msg hidden_cls error" id="sow_msg_1">Invalid</span></div><div class="download-btn"></div><span class="sow_msg hidden_cls error" id="sow_msg_1">Invalid file</span></td></tr></tbody>';
            $(datas).insertAfter($('.mentor-table-head'));
            datepickerEachFunction();
        }
    }


    $(document).on('click', '.saveContinue', function (e) {
        if ($('#mentorForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#mentorForm').submit();
        }
    });

    $('#deleteBtn').on('click', function () {
        $('#deletemodal').modal('show');
        $('#dltDoc').val('');
        $('#dltMasterDoc').val('');
        var sel_item = $("input:checkbox[name=check_delete]:checked").length;
        $('#delCount').html(sel_item);
    });

    $(document).on('click', '.check_box', function () {
        if ($("#mentorForm input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
        }
    });

    function delMentor(mtrid, master_id) {
        $('#deletemodal').modal('show');
        $('#dltDoc').val(mtrid);
        $('#dltMasterDoc').val(master_id);
    }

    function deleteMore() {
//                                                $('.check_box').on('click', function () {
        if ($("#mentorForm input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
        }
//                                                });
    }

    $('#deleteRecord').on('click', function () {
        var dltDoc = $('#dltDoc').val();
        var dltMasterDoc = $('#dltMasterDoc').val();
        var editOpt = $('#enableCount').val();

        if (dltDoc != '') {
            var invId = $('#innovationId').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deleteMentDoc",
                data: {
                    mentr: dltDoc,
                    master: dltMasterDoc,
                    column: 'sow_document',
                    table: 'port_config_mentor',
                    table_temp: 'temp_config_mentor'
                },
                dataType: 'json',
                success: function (msg) {
                    location.reload();
                    // $('#accordion').load(location.href + ' #accordion');
                    // $('#deletemodal').modal('hide');
                    // $('#uploadSuccess').show();
                    // setTimeout(function () {
                    //     if (editOpt > 0) {
                    //         onLoad();
                    //     }
                    //     uploadFile();
                    // }, 500);
                }
            });
        } else {
            var deleteId = new Array();
            $("input:checkbox[name=check_delete]:checked").each(function () {
                deleteId.push($(this).val());
            });

            if ($("#mentorForm input:checkbox:checked").length > 0) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/portfolio/deleteMentorDetail",
                    data: {
                        id: deleteId
                    },
                    dataType: 'json',
                    success: function (msg) {
                        $('#accordion').load(location.href + ' #accordion');
                        $('#deletemodal').modal('hide');
                        $('#deleteMsg').show();
                        setTimeout(function () {
//                                                                    if (editOpt > 0) {
                            onLoad();
//                                                                    }
                            deleteMore();
                        }, 500);
                        setTimeout(function () {
                            $('#deleteMsg').hide();
                        }, 3000);
                    }
                });
            }
        }
    });

    $(document).on('click', '.capitilize', function (e) {
        var inv_id = $('#inv_id').val();
        var fin_year = $('#finance_Year').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/mentorApproved",
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
        var inv_id = $('#inv_id').val();
        var fin_year = $('#finance_Year').val();
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
        var inv_id = $('#inv_id').val();
        var fin_year = $('#finance_Year').val();
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
<style>
    .fileUpload {width: 75%;}
</style>



</body>

</html>
