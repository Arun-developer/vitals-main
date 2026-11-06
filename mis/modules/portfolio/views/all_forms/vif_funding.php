<?php
$company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
$quater_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_quarter = $this->Mportfolio->monthByQuarters();
$get_quarter_fieldName = array("Q1" => 'q_one_desc', "Q2" => 'q_two_desc', "Q3" => 'q_three_desc', "Q4" => 'q_four_desc');
$get_quarter_monthField = array("1" => 'jan_desc', "2" => 'feb_desc', "3" => 'mar_desc', "4" => 'apr_desc', "5" => 'may_desc', "6" => 'jun_desc', "7" => 'jul_desc', "8" => 'aug_desc', "9" => 'sep_desc', "10" => 'oct_desc', "11" => 'nov_desc', "12" => 'dec_desc');

$plan = $vif_plan[0];
$vif_count = isset($plan) ? php72_count($vif_plan) : 1;
$last_month = date("F", mktime(0, 0, 0, $current_month, 1));

$reg_city = isset($plan_header) ? $plan_header['company_data'][0]['reg_city'] : '';
$sector_name = isset($plan_header) ? $plan_header['sector_name'] : '';
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Achievement', 'company_name' => $company_name, 'port_action' => 'actual', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'fin_year' => $current_financial, 'add_class' => 'mar-tp150'));
?>
<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Record(s) deleted successfully</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill newIncubatesTabs" id="nav-tab" role="tablist">
                        <div class="new-nav-changes">
                            <div class="new-changes-head"> &nbsp</div>
                            <a class="nav-item nav-link  " id="nav-Companymaster-tab"   href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-Companymaster" aria-selected="true" style="margin-right: 15px;position: relative;">Updates</a>
                        </div>
                        <div class="new-nav-changes1"><div class="new-changes-head1"> Portfolio Information</div>
                            <a class="nav-item nav-link" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/product/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="false">Product &amp; Sales</a>
                            <a class="nav-item nav-link" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/finance/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Finance &amp; Fundraise</a>
                            <a class="nav-item nav-link" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/hiring/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Team &amp; Board Meetings</a>
                            <a class="nav-item nav-link" id="nav-governance-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/impact/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-governance" aria-selected="false">Impact</a>
                            <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/milestone/' . $innovation_id . '/' . $current_financial; ?>" aria-controls="nav-cap" aria-selected="false">Milestone Tracker</a>
                        </div>
                        <div class="new-nav-changes2"><div class="new-changes-head2">Incubator Services/Interventions</div>
                            <a class="nav-item nav-link" id="nav-relationship-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/mentor/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-relationship" aria-selected="false" style="margin-left: 15px;">Mentors &amp; Partnerships </a>
                            <a class="nav-item nav-link" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/dp/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-incubation" aria-selected="true">Diagnostic Panels</a>
                            <a class="nav-item nav-link active" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/vif_funding/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-incubation" aria-selected="true">09</a>
                            <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/notes/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-cap" aria-selected="false">Meetings &amp; Calls</a>
                        </div>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-Companymaster" role="tabpanel" aria-labelledby="nav-Companymaster-tab">
                        <div class="tabpanel-title">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                    <h4>Seed Funding</h4>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                                    <ul class="milestone-links">
                                        <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                            <li><a class="saveContinue">Save &amp; Continue</a></li>
                                        <?php } ?>
                                        <li>
                                            <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend" style="font-size: 15px !important;text-decoration: underline;"><i class="far fa-question-circle"></i>&nbsp;M&E SOP - Click here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tabpanel-details pad-none config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('all_forms/left_menu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'vif_funding', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
                            </div>
                            <main class="page-content">
                                <div class="row dataconfig">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad0">
                                        <?php
                                        $get_Qval = $actual_quarter[$current_month];
                                        if ($get_Qval == 'Q4') {
                                            $get_end_year = $this->Mportfolio->getFYtoYear($this->session->userdata('partner_id'), $current_financial);
                                            $next_financial = $get_end_year[0]['fin_to_year'];
                                        } else {
                                            $next_financial = $current_financial;
                                        }
                                        ?>
                                        <h4>Seed Funding > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
                                    </div>
                                    <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                            <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php
                                $current_quarter = $actual_quarter[$current_month];
                                $total_qualPlan = $get_quarter_fieldName[$current_quarter];
                                $monthly_qualPlan = $get_quarter_monthField[$current_month];
                                ?>
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <form method="post" id="vifPlanForm" action="<?php echo base_url() . 'index.php/portfolio/all_forms/addVifPlan'; ?>" autocomplete="off"  enctype="multipart/form-data">
                                                    <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                    <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                    <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                    <input type='hidden' name='module_id' id="module_id" value="7">
                                                   

                                                    <div class="row">
                                                        <div class="col-xl-12 col-md-12 col-lg-12 col-12">
                                                            <?php if ($this->session->userdata['currency'] == 'INR') { ?>
                                                                <p class="currencyNotify"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
                                                            <?php } else { ?>
                                                                <p class="currencyNotify"><span class="text-danger">*</span> All <?= $this->session->userdata['currency']; ?> amounts are in '000's.</p>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-12 col-md-12 col-lg-12 col-12">
                                                            <div class="tabpanel-title">
                                                                <h4>Seeding Funding</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="input-viftable">
                                                        <div class="row">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-12 vil-Deals portfolio-table">
                                                                <div class="table_configcontentnew " id="loadSeedingData">
                                                                    <table class="mar-tp0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="5%">S.No</th>
																				<th width="14%">Program</th>
                                                                                <th width="13%">Donor</th>
                                                                                <th width="13%">Milestone</th>
                                                                                <th width="13%">Month of Disbursement</th>
                                                                                <th width="13%">Committed</th>
                                                                                <th width="15%">Disbursed Amount</th>
                                                                                <th width="13%">Disbursed Date</th>
                                                                                <th width="15%">Comments</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            if (php72_count($vif_config) > 0) {
                                                                                for ($i = 0; $i < php72_count($vif_config); $i++) {
                                                                                    $cond['port_vif_id'] = $vif_config[$i]['id'];
                                                                                    $cond['inv_id'] = $vif_config[$i]['inv_id'];
                                                                                    $cond['financial_year'] = $vif_config[$i]['financial_year'];
//                                                                                            $cond['month'] = $current_month;
                                                                                    $get_data = $this->Mportfolio->getVifInput('plan_vif_funding', $cond, '3');

                                                                                    $month_disburse = (isset($vif_config[$i]['month_disburse']) && $vif_config[$i]['month_disburse'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($vif_config[$i]['month_disburse'])) : '';
                                                                                    $disburse_date = (isset($get_data[0]['disburse_date']) && $get_data[0]['disburse_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($get_data[0]['disburse_date'])) : '';
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td width="5%"><?php echo $i + 1; ?></td>
																						<td>
																							<select class="form-control form-control-sm program readOnly" name="program[]" id="program_<?php echo $j; ?>">
																								<option value="">-Select-</option>
																								<?php
																							   foreach ($program_type as $programData) {
																									if ($vif_config[$i]['program'] == $programData['id']) {
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
                                                                                        <td width="13%">
                                                                                            <div class="form-group">
                                                                                                <select class="form-control form-control-sm donor readOnly" style="width:100px;" readonly="" name="donor_name[]" id="donor_name_<?= $i; ?>">
                                                                                                    <option value="">-Select-</option>
                                                                                                    <?php foreach ($donor_list as $donor) { ?>
                                                                                                        <option value="<?= $donor['id']; ?>" <?php if (isset($vif_config[$i]['donor']) && $vif_config[$i]['donor'] == $donor['id']) { ?> selected <?php } ?>><?= $donor['name']; ?></option>
                                                                                                    <?php } ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td width="13%">
                                                                                            <div class="form-group">
                                                                                                <input class="form-control form-control-sm milestone readOnly" readonly="" type="text" name="txtMilestone[]" id="txtMilestone_<?= $i; ?>" value="<?= $vif_config[$i]['milestone']; ?>">
                                                                                            </div>
                                                                                        </td>
                                                                                        <td width="13%">
                                                                                            <div class="form-group">
                                                                                                <input class="form-control form-control-sm month readOnly" readonly="" type="text" name="txtMonth[]" id="txtMonth_<?= $i; ?>" value="<?= date('M, Y', strtotime($vif_config[$i]['month'])); ?>">
                                                                                            </div>
                                                                                        </td>
                                                                                        <td width="13%">
                                                                                            <div class="form-group">
                                                                                                <input class="form-control form-control-sm commit readOnly" readonly="" type="text" name="txtCommit[]" id="txtCommit_<?= $i; ?>" value="<?= $vif_config[$i]['amount']; ?>">
                                                                                            </div>
                                                                                        </td>
                                                                                        <td width="15%">
                                                                                            <div class="form-group">
                                                                                                <input class="form-control form-control-sm disbursedAmt currencyField" type="text" name="txtDisbursedAmt[]" id="txtDisbursedAmt_<?= $i; ?>" maxlength="20" value="<?= $get_data[0]['disburse_amount']; ?>">
                                                                                                <span class="amt_msg hidden_cls text-danger" id="amt_msg_<?php echo $i; ?>">Enter amount</span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td width="13%">
                                                                                            <div class="form-group">
                                                                                                <input class="form-control form-control-sm disDate dateCalendar" type="text" name="txtDate[]" id="txtDate_<?= $i; ?>" value="<?= $disburse_date; ?>" style="width:90px;" placeholder="dd-mm-yyyy">
                                                                                                <span class="date_msg hidden_cls text-danger" id="date_msg_<?php echo $i; ?>">Select date</span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td width="15%">
                                                                                            <div class="form-group">
                                                                                                <input class="form-control form-control-sm comment" type="text" name="txtComment[]" id="txtComment_<?= $i; ?>" value="<?= $get_data[0]['comments']; ?>">
                                                                                            </div>
                                                                                        </td>
                                                                                <input type="hidden" name="id[]" value="<?php echo $get_data[0]['id']; ?>" />
                                                                                <input type="hidden" name="port_vif_id[]" id="port_vif_id" value="<?php echo $vif_config[$i]['id']; ?>" />
                                                                                </tr>
                                                                                <input type="hidden" id="enableCount" value="<?= php72_count($get_data); ?>">
                                                                                <?php
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                            <tr align="center"><td colspan="8" >No data found</td></tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="table_configcontentnew pad-bt0">
                                                            <div class="tabpanel-title">
                                                                <div class="row">
                                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                        <h4>Equity Investments</h4>
                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                        <ul class="milestone-links">
                                                                            <li><a href="javascript:void(0)" id="addEquity"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a> </li>
                                                                            <li class="brd-left-onboard" id="editEquity"><a href="javascript:void(0)" id="edit_equity" class="opacity5"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a></li>
                                                                            <li class="brd-left-onboard" id="disableEquity" style="cursor: not-allowed;">
                                                                                <a class="deleteControl" href="javascript:void(0)" id="deleteEquity" style="pointer-events: none;"><i class="fas fa-trash"></i>&nbsp;Delete</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" table_configcontentnew" id="loadEquityData">
                                                            <input type="hidden" id="equityCount" value="<?= php72_count($equity_list); ?>">
                                                            <table class="table mentor-table" id="accordion">
                                                                <thead class="mentor-table-head">
                                                                    <tr>
                                                                        <th width="4%"></th>
                                                                        <th width="18%">SHA Signed Date</th>
                                                                        <th width="20%">Incubatee Valuation <small>(At investment)</small></th>
                                                                        <th width="20%">Valuation of Villgro's Investment <small>(At investment)</small></th>
                                                                        <th width="20%">Comments</th>
                                                                        <th width="18%">SHA</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="add_more_equity">
                                                                    <?php
                                                                    $equityData_count = isset($equity_list) && php72_count($equity_list) > 0 ? php72_count($equity_list) : '1';
                                                                    $j = 1;
                                                                    for ($i = 0; $i < $equityData_count; $i++) {
                                                                        $get_sha_date = (isset($equity_list[$i]['sha_date']) && $equity_list[$i]['sha_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($equity_list[$i]['sha_date'])) : '';
                                                                        ?>
                                                                        <tr id="equity_tr_<?php echo $j; ?>" class="equity_more">
                                                                            <td width="4%">
                                                                                <input type="checkbox" class="check_box equityCheck" aria-label="Checkbox for following text input" name="check_equity" id="check_equity_<?php echo $j; ?>" value="<?= $equity_list[$i]['id']; ?>">
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" placeholder="dd-mm-yyyy" name="equity_date[]" id="equity_date_<?php echo $j; ?>" value="<?= $get_sha_date; ?>" class="form-control form-control-sm equityDate dateCalendar">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="incubatee_amount[]" id="incubatee_amount_<?php echo $j; ?>" value="<?= $equity_list[$i]['incubatee_amount']; ?>" class="form-control form-control-sm disbursedAmt currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                                <label class="error" id="incubatee_amount<?= $i . '_error'; ?>"></label>
                                                                            </td>
                                                                            <td >
                                                                                <div class="form-group">
                                                                                    <input type="text" name="invest_amount[]" id="invest_amount_<?php echo $j; ?>" value="<?= $equity_list[$i]['invest_amount']; ?>" class="form-control form-control-sm disbursedAmt currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                                <label class="error" id="invest_amount<?= $i . '_error'; ?>"></label>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <textarea row="2" class="form-control" name="equity_comment[]" id="equity_comment_<?php echo $j; ?>"><?= $equity_list[$i]['comments']; ?></textarea>
                                                                                </div>
                                                                            </td>
                                                                            <td class="sowFile">
                                                                                <div class="fileUpload blue-btn btn width100">
                                                                                    <?php
                                                                                    if (isset($equity_list[$i]['sha_document']) && !empty($equity_list[$i]['sha_document'])) {
                                                                                        echo strlen($equity_list[$i]['sha_document']) > 20 ? "..." . substr($equity_list[$i]['sha_document'], -20) : $equity_list[$i]['sha_document'];
                                                                                    } else {
                                                                                        ?>
                                                                                        <span><i class="fas fa-upload"></i> Upload</span>
                                                                                    <?php } ?>
                                                                                    <input type="file" class="uploadlogo" data-dyn="<?= $j; ?>" name="equity_doc[]" id="equity_doc<?= $j; ?>" />
                                                                                </div>
                                                                                <label class="sow_msg error" id="equity_doc<?= $i . '_error'; ?>"></label>
                                                                                <?php if (isset($equity_list[$i]['sha_document']) && !empty($equity_list[$i]['sha_document'])) { ?>
                                                                                    <span class="download-btn"><a href="<?php echo base_url() . 'uploads/portfolio/equity_investment/' . $equity_list[$i]['sha_document']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                                                    <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                                        <span><a href="javascript:void(0)" class="delete-btnconfig" title="Delete Document" onclick="delDocument('<?= $equity_list[$i]['id']; ?>')" id="removeDoc"><i class="fas fa-trash"></i></a></span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                                <input type="hidden" name="old_equity_doc[]" id="old_equity_doc<?= $j; ?>" class="uploadlogo" data-dyn="<?= $j; ?>" value="<?php echo $equity_list[$i]['sha_document']; ?>">
                                                                            </td>
                                                                    <input type="hidden" name="equity_id[]" value="<?= $equity_list[$i]['id']; ?>">
                                                                    </tr>
                                                                    <?php
                                                                    $j++;
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
													
													  <hr><br><br>
													 <div class="row achievementNewComt">
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <p>Plan for <?= $current_quarter; ?></p>
                                                            <div class="form-group quaterlyCardnew fieldDisabled">
                                                                <textarea rows="3" disabled class="mceEditor" id="quarterDesc" name="quarterDesc"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_plan[0][$total_qualPlan])); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <p>Plan for <?= $last_month; ?></p>
                                                            <div class="form-group quaterlyCardnew fieldDisabled">
                                                                <textarea rows="3" class="mceEditor" id="monthContent" name='monthContent'><?= stripslashes(str_replace("\\r\\n", '', $qualitative_plan[0][$monthly_qualPlan])); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <p>Enter achievement for <?= $last_month; ?></p>
                                                            <div class="form-group quaterlyCardnew" id="achieveField">
                                                                <textarea rows="3" class="mceEditorActive" id="achieveContent" name='achieveContent' autofocus><?= stripslashes(str_replace("\\r\\n", '', $qual_achieve[0]['description'])); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
													
													
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
    </div>
</div>
</div>
</div>

<div class="modal" id="deleteEquityModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
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
                            <p>you are about delete <span id="delEquityCount"></span> selected information fields, you
                                can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteEquityRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="deleteDocModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
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
                            <p>you are about to delete the selected information fields, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="doc_id" id="doc_id" />
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteDocRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="qualitCount" value="<?= php72_count($qual_achieve); ?>">

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio', 'quantitative' => 'tiny')); ?>

<script type="text/javascript">

    $(window).on("load", function () {
        $('svg').attr("viewBox", "0 0 25 25");
        $('svg').css({"width": "20", "height": "20"});
    });

    tinyMCE.init({
        mode: "specific_textareas",
        editor_selector: "mceEditor",
        entity_encoding: "numeric",
        menubar: false,
        readonly: 1,
        toolbar: [
            ''
        ],
        valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li,br',
        powerpaste_word_import: 'clean',
        powerpaste_html_import: 'clean'
    });

    tinyMCE.init({
        mode: "specific_textareas",
        editor_selector: "mceEditorActive",
        entity_encoding: "numeric",
        menubar: false,
        //auto_focus: "achieveContent",
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

    function datepickerEachFunction(id) {
        var sel_month = $('#current_month').val();
        var sel_year = $('#current_year').val();
        if (sel_month < 4) {
            sel_year = parseInt(sel_year) + 1;
        }
        $('.disDate').each(function (index, value) {
            $("#txtDate_" + index).datepicker({
                onSelect: function (selected) {
                    $("#txtDate_" + index).datepicker("option", "dateFormat", 'mm/dd/yy');
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
                    $("#txtDate_" + index).val(fulldatevalue);
                }
                // defaultDate: new Date(sel_year, sel_month - 1),
                // stepMonths: 0
            });
        });
    }

    function equityDatepicker() {
        var sel_month = $('#current_month').val();
        var sel_year = $('#current_year').val();
        if (sel_month < 4) {
            sel_year = parseInt(sel_year) + 1;
        }
        $('.equityDate').each(function (index, value) {
            var nxt_val = index + 1;
            $("#equity_date_" + nxt_val).datepicker({
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
                    $("#equity_date_" + nxt_val).val(fulldatevalue);
                },
                defaultDate: new Date(sel_year, sel_month - 1),
                stepMonths: 0
            });
        });
    }

    $(document).ready(function () {
        onLoad();
    });

    function onLoad() {
        var qualitEdit = $('#qualitCount').val();
        if (qualitEdit > 0) {
            tinymce.get('achieveContent').setMode('readonly');
            $('#achieveField').addClass('fieldDisabled');
        } else {
            $('#achieveField').addClass('greenplantxt');
        }

        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('#loadSeedingData input[type="text"]').attr('readonly', 'readonly');
            $('.disDate').css('pointer-events', 'none');
            $('#loadSeedingData input[type="radio"], .wdt_50 label').css('pointer-events', 'none');
        } else {
            checkVest();
            datepickerEachFunction();
        }
        var equityOpt = $('#equityCount').val();
        if (equityOpt > 0) {
            $('#loadEquityData input[type="text"], #loadEquityData textarea').attr('readonly', 'readonly');
            $('#loadEquityData input[type="file"]').css("pointer-events", "none");
            $('.equityDate').css('pointer-events', 'none');
        } else {
            equityDatepicker();
        }

        $('.donor').css("pointer-events", "none");
        $('#editBtn').addClass('opacity5');
    }

    $(document).on('click', '#editBtn', function () {
        $('#loadSeedingData input[type="text"]').attr('readonly', false);
        $('#loadSeedingData input[type="radio"], .wdt_50 label, .disDate').css('pointer-events', 'visible');
        $('.readOnly').attr('readonly', true);
        $('#editBtn').removeClass('opacity5');
        tinymce.get('achieveContent').setMode('design');
        $('#achieveField').addClass('greenplantxt');
        $('#achieveField').removeClass('fieldDisabled');
        checkVest();
        datepickerEachFunction();
    });

    $(document).on('click', '#editEquity', function () {
        $('#loadEquityData input[type="text"],#loadEquityData textarea').attr('readonly', false);
        $('#loadEquityData input[type="text"],#loadEquityData input[type="file"]').css("pointer-events", "");
        $('#edit_equity').removeClass('opacity5');
        equityDatepicker();
    });
    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/all_forms/vif_funding/' + inv_id + '/' + year;
    }

    $(document).on('click', '.vesting', function () {
        $('.vesting').each(function (key, value) {
            var checkVal = $('input[name="vesting[' + key + ']"]:checked').val();
            if (checkVal == 0) {
                $('#txtDate_' + key).val('').attr('readonly', true);
                $('#txtDate_' + key).css("pointer-events", "none");
            } else {
                $('#txtDate_' + key).attr('readonly', false);
                $('#txtDate_' + key).css("pointer-events", "");
            }
        });
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

    function checkVest() {
        $('.vesting').each(function (key, value) {
            var checkVal = $('input[name="vesting[' + key + ']"]:checked').val();
            if (checkVal == 0) {
                $('#txtDate_' + key).attr('readonly', true);
                $('#txtDate_' + key).css("pointer-events", "none");
            } else {
                $('#txtDate_' + key).attr('readonly', false);
                $('#txtDate_' + key).css("pointer-events", "");
            }
        });
    }

//                                                                                                    $(document).on('click', ".saveContinue", function (e) {
    function seedingValidate() {
        var s = 0;
        var d = 0;
        var err = 0;
        var html;

        $('.disDate').each(function (key) {
            var disAmt = $('#txtDisbursedAmt_' + s).val();
            var disDate = this.value;
            if (disDate != '') {
                if (disAmt == '') {
                    $('#amt_msg_' + s).removeClass('hidden_cls');
                    html = $('#amt_msg_' + s).show();
                    err = 1;
                    return false;
                } else {
                    $('#amt_msg_' + s).addClass('hidden_cls');
                    html = $('#amt_msg_' + s).hide();
                }
            }
            s++;
        });

        $('.disbursedAmt').each(function (key) {
            var disDate = $('#txtDate_' + d).val();
            var disAmt = this.value;
            if (disAmt != '') {
                if (disDate == '') {
                    $('#date_msg_' + d).removeClass('hidden_cls');
                    html = $('#date_msg_' + d).show();
                    err = 1;
                    return false;
                } else {
                    $('#date_msg_' + d).addClass('hidden_cls');
                    html = $('#date_msg_' + d).hide();
                }
            }
            d++;
        });
        return err;
//                                                                                                        if (err == 0 && equity_result == 0) {
//                                                                                                            $('.saveContinue').css('pointer-events', 'none');
//                                                                                                            $('#vifPlanForm').submit();
//                                                                                                        }
    }

    $('.plan-structure-new').css({'height': (($(window).height()) - 380) + 'px'});

    $(document).on('click', '#addEquity', function () {
        var dyn = $(".equity_more").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="equity_tr_' + i + '" class="equity_more">' +
                '<td><input type="checkbox" class="check_box" aria-label="Checkbox for following text input" name="check_equity" id="check_equity_' + i + '" value=""></td>' +
                '<td><div class="form-group"><input type="text" name="equity_date[]" id="equity_date_' + i + '" value="" class="form-control form-control-sm equityDate dateCalendar" placeholder="dd-mm-yyyy"></div></td>' +
                '<td><div class="form-group"><input type="text" class="form-control form-control-sm disbursedAmt currencyField" maxlength="20" placeholder="00" name="incubatee_amount[]" id="incubatee_amount_' + i + '" value=""></div><label class="error" id="incubatee_amount' + (i - 1) + '_error"></label></td>' +
                '<td><div class="form-group"><input type="text" class="form-control form-control-sm disbursedAmt currencyField" maxlength="20" placeholder="00" name="invest_amount[]" id="invest_amount_' + i + '" value=""></div><label class="error" id="invest_amount' + (i - 1) + '_error"></label></td>' +
                '<td><div class="form-group"><textarea row="5" class="form-control" name="equity_comment[]" value="" id="equity_comment_' + i + '"></textarea></div></td>' +
                '<td class="sowFile"><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" id="equity_doc' + i + '" name="equity_doc[]" /></div><div class="download-btn"></div><span class="sow_msg hidden_cls error" id="equity_doc' + (i - 1) + '_error">Invalid file</span></td></tr>';
        $(datas).insertAfter($('#equity_tr_' + dyn));
        equityDatepicker();
//                                                                                                        $(".equityDate").datepicker({dateFormat: "dd-mm-yy"});
    });
    $(document).on('change', '.uploadlogo', function () {
        var get_id = $(this).attr('id');
        var filename = readURL(this);
        var result = filename.split('|*|');
        $(this).parent().children('span').html(result[0]);
        if (result[1] != '1') {
            $('#' + get_id).val('');
            $(this).parent().parent().children('.sow_msg').show();
            $(this).parent().parent().children('.sow_msg').text(result[1]);
        } else {
            $(this).parent().parent().children('.sow_msg').text('');
            $(this).parent().parent().children('.sow_msg').hide();
        }
    });
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

    $(document).on('click', ".saveContinue", function (e) {
        var seeding_result = seedingValidate();
        var equity_result = equityValidate();
        if (seeding_result == 1 || equity_result == 1) {
            return false;
        } else {
            $('.saveContinue').css('pointer-events', 'none');
            $('#vifPlanForm').submit();
            return true;
        }
    });

    function equityValidate() {
        var err = 0;
        var equity_arr = [];
        var equity_dyn = document.getElementsByName("equity_date[]").length;
        for (var r = 0; r < equity_dyn; r++) {
            var dyn_id = document.getElementsByName("equity_date[]")[r].id;
            equity_arr.push(dyn_id);
        }

        var s = 1;
        for (var q = 0; q < equity_arr.length; q++) {
            var equity_date = $('#equity_date_' + s).val();
            var inc_amount = $('#incubatee_amount_' + s).val();
            var invest_amount = $('#invest_amount_' + s).val();
            var equity_document = $('#equity_doc' + s).val();
            var equity_old_document = $('#old_equity_doc' + s).val();
            if (equity_date != '') {
                if (inc_amount == '') {
                    $('#incubatee_amount' + [q] + '_error').css('display', 'block');
                    $('#incubatee_amount' + [q] + '_error').text('Enter amount');
                    err = 1;
                } else {
                    $('#incubatee_amount' + [q] + '_error').css('display', 'none');
                    $('#incubatee_amount' + [q] + '_error').text('');
                }
                if (invest_amount == '') {
                    $('#invest_amount' + [q] + '_error').css('display', 'block');
                    $('#invest_amount' + [q] + '_error').text('Enter amount');
                    err = 1;
                } else {
                    $('#invest_amount' + [q] + '_error').css('display', 'none');
                    $('#invest_amount' + [q] + '_error').text('');
                }
                if (equity_document == '' && (equity_old_document == '' || typeof equity_old_document == 'undefined')) {
                    $('#equity_doc' + [q] + '_error').css('display', 'block');
                    $('#equity_doc' + [q] + '_error').text('Upload document');
                    err = 1;
                } else {
                    $('#equity_doc' + [q] + '_error').css('display', 'none');
                    $('#equity_doc' + [q] + '_error').text('');
                }
            }

            s++;
        }
        return err;
    }

    $(document).on('click', '#deleteEquity', function () {
        $('#deleteEquityModal').modal('show');
        var sel_item = $("input:checkbox[name=check_equity]:checked").length;
        $('#delEquityCount').html(sel_item);
    });
    $('#deleteEquityRecord').on('click', function () {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#current_year').val();
        var cur_month = $('#current_month').val();
        var deleteId = new Array();
        $("input:checkbox[name=check_equity]:checked").each(function () {
            deleteId.push($(this).val());
        });
        if ($("input:checkbox[name=check_equity]:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/all_forms/deleteSeedingEquity",
                data: {
                    id: deleteId,
                    inv_id: inv_id,
                    fin_year: fin_year,
                    cur_month: cur_month
                },
                dataType: 'json',
                success: function (msg) {
                    $('#loadEquityData').load(location.href + ' #loadEquityData');
                    $('#deleteEquityModal').modal('hide');
                    $('#deleteMsg').show();
                    setTimeout(function () {
                        onLoad();
                        deleteMore();
                    }, 500);
                    setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000);
                }
            });
        }
    });

    $('.equityCheck').on('click', function () {
        if ($("#loadEquityData input:checkbox:checked").length > 0) {
            $('#disableEquity').css("cursor", "pointer");
            $('#deleteEquity').css("pointer-events", "");
        } else {
            $('#disableEquity').css("cursor", "not-allowed");
            $('#deleteEquity').css("pointer-events", "none");
        }
    });

    function delDocument(mtrid) {
        $('#deleteDocModal').modal('show');
        $('#doc_id').val(mtrid);
    }

    $(document).on('click', '#deleteDocRecord', function () {
        var document_id = $('#doc_id').val();
        if (document_id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deleteMentDoc",
                data: {
                    mentr: document_id,
                    column: 'sha_document',
                    table: 'plan_vif_equity'
                },
                dataType: 'json',
                success: function (msg) {
                    $('#loadEquityData').load(location.href + ' #loadEquityData');
                    $('#deleteDocModal').modal('hide');
                    $('#deleteMsg').show();
                    setTimeout(function () {
                        onLoad();
                        deleteMore();
                    }, 500);
                    setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000);
                }
            });
        }
    });

    $(document).on('click', '.equityCheck', function () {
        if ($("input:checkbox[name=check_equity]:checked").length > 0) {
            $('#disableEquity').css("cursor", "pointer");
            $('#deleteEquity').css("pointer-events", "");
        } else {
            $('#disableEquity').css("cursor", "not-allowed");
            $('#deleteEquity').css("pointer-events", "none");
        }
    });

    function deleteMore() {
        if ($("input:checkbox[name=check_equity]:checked").length > 0) {
            $('#disableEquity').css("cursor", "pointer");
            $('#deleteEquity').css("pointer-events", "");
        } else {
            $('#disableEquity').css("cursor", "not-allowed");
            $('#deleteEquity').css("pointer-events", "none");
        }
    }
</script>

<style>
    table {
        table-layout: fixed;
        word-wrap: break-word;
    }
</style>
</body>



</html>
