<?php
$company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
$quater_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_quarter = $this->Mportfolio->monthByQuarters();
$get_quarter_fieldName = array("Q1" => 'q_one_desc', "Q2" => 'q_two_desc', "Q3" => 'q_three_desc', "Q4" => 'q_four_desc');
$get_quarter_monthField = array("1" => 'jan_desc', "2" => 'feb_desc', "3" => 'mar_desc', "4" => 'apr_desc', "5" => 'may_desc', "6" => 'jun_desc', "7" => 'jul_desc', "8" => 'aug_desc', "9" => 'sep_desc', "10" => 'oct_desc', "11" => 'nov_desc', "12" => 'dec_desc');

$last_month = date("F", mktime(0, 0, 0, $current_month, 1));
$reg_city = isset($plan_header) ? $plan_header['company_data'][0]['reg_city'] : '';
$sector_name = isset($plan_header) ? $plan_header['sector_name'] : '';
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Achievement', 'company_name' => $company_name, 'port_action' => 'actual', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'fin_year' => $current_financial, 'add_class' => 'mar-tp150'));
?>
<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill newIncubatesTabs" id="nav-tab" role="tablist">
                        <div class="new-nav-changes">
                            <div class="new-changes-head"> &nbsp</div>
                            <a class="nav-item nav-link  " id="nav-Companymaster-tab"    href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-Companymaster" aria-selected="true" style="margin-right: 15px;position: relative;">Updates</a>
                        </div>
                        <div class="new-nav-changes1"><div class="new-changes-head1"> Portfolio Information</div>
                            <a class="nav-item nav-link" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/product/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="false">Product &amp; Sales</a>
                            <a class="nav-item nav-link" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/finance/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Finance &amp; Fundraise</a>
                            <a class="nav-item nav-link" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/hiring/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Team &amp; Board Meetings</a>
                            <a class="nav-item nav-link" id="nav-governance-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/impact/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-governance" aria-selected="false">Impact</a>
                            <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/milestone/' . $innovation_id . '/' . $current_financial; ?>" aria-controls="nav-cap" aria-selected="false">Milestone Tracker</a>
                        </div>
                        <div class="new-nav-changes2"><div class="new-changes-head2">Incubator Services/Interventions</div>
                            <a class="nav-item nav-link active" id="nav-relationship-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/mentor/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-relationship" aria-selected="false" style="margin-left: 15px;">07 </a>
                            <a class="nav-item nav-link" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/dp/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-incubation" aria-selected="true">Diagnostic Panels</a>
                            <a class="nav-item nav-link" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/vif_funding/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-incubation" aria-selected="true">Seed Funding</a>
                            <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/notes/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-cap" aria-selected="false">Meetings &amp; Calls</a>
                        </div>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-Companymaster" role="tabpanel" aria-labelledby="nav-Companymaster-tab">
                        <div class="tabpanel-title">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                    <h4>Mentors &amp; Partnerships</h4>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                                    <ul class="milestone-links">
                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                            <li><a class="saveContinue">Save &amp; Continue</a></li>
                                        <?php } ?>
                                        <li>
                                            <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend"><i class="far fa-question-circle"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tabpanel-details pad-none config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('all_forms/left_menu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'tap', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
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
                                        <h4>Technical Assistance > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
                                    </div>
                                    <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                            <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/mentor/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Mentors</a></li>
                                            <li class="tab-slider--triggerform active"><a href="javascript:void(0)">Technical Assistance</a></li>
                                            <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/nontap/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Partnerships</a></li>
                                        </ul>
                                    </div>
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
                                                <form method="post" id="tapPlanForm" action="<?php echo base_url() . 'index.php/portfolio/all_forms/addTapPlan'; ?>" autocomplete="off" enctype="multipart/form-data">
                                                    <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                    <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                    <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                    <input type='hidden' name='module_id' id="module_id" value="10">
                                                    
                                                    <div class="row">
                                                        <div class="table-responsive table_configcontentnew ">
                                                            <table class="table mentor-table" id="accordion">
                                                                <thead class="mentor-table-head">
                                                                    <tr>
																		<th width="25%">Program</th>
                                                                        <th width="5%">Requirement</th>
                                                                        <th width="20%">Need by</th>
                                                                        <th width="5%">Firm engaged</th>
                                                                        <th width="15%">Focus area</th>
                                                                        <th width="10%">Contract start date</th>
                                                                        <th width="12%">Contract end date</th>
																		<th width="2%">Contract<br> Amount (INR)</th>
                                                                        <th width="15%">Comments</th>
                                                                        <th width="25%">Contract document</th>
                                                                        <th width="20%">Invoice</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <?php
                                                                    if (count($tap_config) != 0) {
                                                                        $config = $tap_config[0];
                                                                        $config_count = isset($config) ? count($tap_config) : 1;
                                                                        $j = 1;
                                                                        for ($i = 0; $i < $config_count; $i++) {
                                                                            $get_achieve['port_tap_id'] = $tap_config[$i]['id'];
                                                                            $get_achieve['inv_id'] = $innovation_id;
                                                                            $get_achieve['financial_year'] = $current_financial;
                                                                            // $get_achieve['month'] = $current_month;

                                                                            $get_achieve_data = $this->Mportfolio->getVifInput('plan_tap', $get_achieve, '3', 'order', 'add_cond');

                                                                            $serv_porvider_id = isset($get_achieve_data) && $get_achieve_data[0]['firm_engaged'] != '' ? $get_achieve_data[0]['firm_engaged'] : $tap_config[$i]['service_provider'];
                                                                            $need_date = (isset($tap_config[$i]['need_by']) && $tap_config[$i]['need_by'] != '0000-00-00 00:00:00' && $tap_config[$i]['need_by'] != '') ? date('d-m-Y', strtotime($tap_config[$i]['need_by'])) : '';
                                                                            $engage_date = (isset($get_achieve_data[0]['month_engaged']) && $get_achieve_data[0]['month_engaged'] != '0000-00-00' && $get_achieve_data[0]['month_engaged'] != '') ? date('d-m-Y', strtotime($get_achieve_data[0]['month_engaged'])) : '';
                                                                            $end_date = (isset($get_achieve_data[0]['month_end']) && $get_achieve_data[0]['month_end'] != '0000-00-00' && $get_achieve_data[0]['month_end'] != '') ? date('d-m-Y', strtotime($get_achieve_data[0]['month_end'])) : '';
                                                                            ?>
                                                                            <tr>
																				 <td>
																				<select class="form-control form-control-sm program readOnly" name="program[]" id="program_<?php echo $j; ?>">
																					<option value="">-Select-</option>
																					<?php
																					
																				   foreach ($program_type as $programData) {
																						if ($tap_config[$i]['program'] == $programData['id']) {
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
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm requirement readOnly" readonly="" type="text" name="requirement[]" value="<?= $tap_config[$i]['requirement']; ?>">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input style="width: 88px;" class="form-control form-control-sm needBy readOnly" readonly="" type="text" name="need_by[]" value="<?= $need_date; ?>">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <select class="form-control form-control-sm" name="firm_name[]">
                                                                                            <option value="">-Select-</option>
                                                                                            <?php foreach ($service_providers as $serv) { ?>
                                                                                                <option value="<?= $serv['id']; ?>" <?php if ($serv_porvider_id == $serv['id']) { ?> selected <?php } ?>><?= $serv['name']; ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                                <td width="10%">
                                                                                    <div class="form-group">
                                                                                        <select class="form-control form-control-sm focus_area" name="focus_area[]" id="focus_area_<?php echo $j; ?>">
                                                                                            <option value="">-Select-</option>
                                                                                            <?php
                                                                                            foreach ($focus_area as $area) {
                                                                                                if ($get_achieve_data[0]['focus_area'] == $area['id']) {
                                                                                                    $selected = 'selected';
                                                                                                } else {
                                                                                                    $selected = '';
                                                                                                }
                                                                                                ?>
                                                                                                <option value="<?php echo $area['id']; ?>" <?= $selected; ?> ><?php echo $area['name']; ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm startDat dateCalendar" type="text" name="start_date[]" id="startDate_<?= $i; ?>" value="<?= $engage_date; ?>" placeholder="dd-mm-yyyy">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm endDat dateCalendar" type="text" name="end_date[]" id="endDate_<?= $i; ?>" value="<?= $end_date; ?>" placeholder="dd-mm-yyyy">
                                                                                    </div>
                                                                                </td>
																				<td>
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm contract_amount currencyField" type="text" name="contract_amount[]" value="<?= $get_achieve_data[0]['contract_amount']; ?>">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <textarea style="width: 200px;" class="form-control form-control-sm" name="comments[]" id="comments_<?= $i; ?>" placeholder="Enter comments"><?= $get_achieve_data[0]['comment']; ?></textarea>
                                                                                        <!--<input class="form-control form-control-sm" type="text" name="comments[]" id="comments_<?= $i; ?>" value="<?= $get_achieve_data[0]['comment']; ?>" placeholder="Enter comments">-->
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div style="width: 85px;" class="fileUpload blue-btn btn width100">
                                                                                        <?php
                                                                                        if (isset($get_achieve_data[0]['contract_doc']) && !empty($get_achieve_data[0]['contract_doc'])) {
                                                                                            echo strlen($get_achieve_data[0]['contract_doc']) > 20 ? "..." . substr($get_achieve_data[0]['contract_doc'], -20) : $get_achieve_data[0]['contract_doc'];
                                                                                            ?>

                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                                                        <?php } ?>
                                                                                        <input type="file" class="contractdoc uploadlogo" id="contract_file_<?= $j; ?>" name="contract_file[]" />
                                                                                    </div>

                                                                                    <?php if (isset($get_achieve_data[0]['contract_doc']) && !empty($get_achieve_data[0]['contract_doc'])) { ?>
                                                                                        <span class="download-btn"><a class="old_file" data-toggle="tooltip" data-placement="top" title="Download" href="<?php echo base_url() . 'uploads/portfolio/tap/contract/' . $get_achieve_data[0]['contract_doc']; ?>" title="Download Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                                                            <span><a href="javascript:void(0)" class="delete-btnconfig" title="Delete Document" onclick="delContract('<?= $get_achieve_data[0]['id']; ?>', 'contract_doc')" id="removeDoc"><i class="fas fa-trash"></i></a></span>
                                                                                        <?php } ?>
                                                                                    <?php } ?>
                                                                                    <input type="hidden" name="old_contract_doc[]" value="<?php echo $get_achieve_data[0]['contract_doc']; ?>">
                                                                                    <p class="contract_msg hidden_cls error">Invalid file</p>
                                                                                </td>

                                                                                <td>
                                                                                    <div style="width: 150px!important;" class="fileUpload blue-btn btn width100">
                                                                                        <?php
                                                                                        if (isset($get_achieve_data[0]['other_doc']) && !empty($get_achieve_data[0]['other_doc'])) {
                                                                                            echo strlen($get_achieve_data[0]['other_doc']) > 20 ? "..." . substr($get_achieve_data[0]['other_doc'], -20) : $get_achieve_data[0]['other_doc'];
                                                                                            ?>

                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                                                        <?php } ?>
                                                                                        <input type="file" class="reportsdoc uploadlogo" id="reports_file_<?= $j; ?>" name="reports_file[]" />
                                                                                    </div>

                                                                                    <?php if (isset($get_achieve_data[0]['other_doc']) && !empty($get_achieve_data[0]['other_doc'])) { ?>
                                                                                        <span class="download-btn"><a class="old_file" data-toggle="tooltip" data-placement="top" title="Download" href="<?php echo base_url() . 'uploads/portfolio/tap/other/' . $get_achieve_data[0]['other_doc']; ?>" title="Download Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                                                            <span><a href="javascript:void(0)" class="delete-btnconfig" title="Delete Document" onclick="delContract('<?= $get_achieve_data[0]['id']; ?>', 'other_doc')" id="removeDoc"><i class="fas fa-trash"></i></a></span>
                                                                                        <?php } ?>
                                                                                    <?php } ?>
                                                                                    <input type="hidden" name="old_reports_doc[]" value="<?php echo $get_achieve_data[0]['other_doc']; ?>">
                                                                                    <p class="reports_msg hidden_cls error">Invalid file</p>
                                                                                </td>
                                                                        <input type='hidden' name="tap_id[]" id='tap_id_<?php echo $j; ?>' value='<?= $get_achieve_data[0]['id']; ?>'>
                                                                        <input type="hidden" name="port_tap_id[]" id="port_tap_id<?php echo $j; ?>" value="<?php echo $tap_config[$i]['id']; ?>" />
                                                                        </tr>
                                                                        <?php
                                                                        $j++;
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <tr align="center"><td colspan="10" >No data found</td></tr>
                                                                    <?php
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
                <input type="hidden" name="dltDocfield" id="dltDocfield" />
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
    <input type="hidden" id="deleteID" value="">
</div>

<input type="hidden" id="qualitCount" value="<?= count($qual_achieve); ?>">
<input type="hidden" id="enableCount" value="<?= count($tap_plan); ?>">

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio', 'quantitative' => 'tiny')); ?>

<script type="text/javascript">

	
	/////// New implement //////////////
	$(".contract_amount").each(function() {
		let id = $(this).attr('id');
		let val = $(this).val();
		if(id!='' && val!=''){
			var self = $(this);
            self.val(self.val().replace(/[^0-9\.]/g, ''));
            self.val(inrFormat_val(self.val()));
            var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
            var matchedString = self.val().match(patt);
			if (matchedString) {
                self.val(matchedString);
            }
		}
	});
	function inrFormat_val(nStr) {
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
	/////// New implement //////////////
	
	
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
                    $("#endDate_" + index).datepicker("option", {minDate: dt});
                }
//                                                                                            minDate: 0
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

    $(document).ready(function () {
        var qualitEdit = $('#qualitCount').val();
        var editOpt = $('#enableCount').val();
        if (qualitEdit > 0) {
            tinymce.get('achieveContent').setMode('readonly');
            $('#achieveField').addClass('fieldDisabled');
        } else {
            $('#achieveField').addClass('greenplantxt');
        }
        if (editOpt > 0) {
            $('input[type="text"], select').attr('readonly', 'readonly');
            $('.disDate, select').css('pointer-events', 'none');
        } else {
            datepickerEachFunction();
        }
        $('#financial_year').attr('readonly', false);
        $('#financial_year').css("pointer-events", "");
        $('#editBtn').addClass('opacity5');
    });

    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/all_forms/tap/' + inv_id + '/' + year;
    }

    $(document).on('click', '#editBtn', function () {
        $('input[type="text"], select').attr('readonly', false);
        $('.disDate, select').css('pointer-events', '');
        $('.readOnly').attr('readonly', true);
        $('#editBtn').removeClass('opacity5');
        tinymce.get('achieveContent').setMode('design');
        $('#achieveField').addClass('greenplantxt');
        $('#achieveField').removeClass('fieldDisabled');
        datepickerEachFunction();
    });

    $(document).on('click', ".saveContinue", function (e) {
        if ($('#tapPlanForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#tapPlanForm').submit();
        }
    });

    $('.plan-structure-new').css({'height': (($(window).height()) - 380) + 'px'});

    $('#deleteRecord').on('click', function () {
        var dltDoc = $('#dltDoc').val();
        var dltDocfield = $('#dltDocfield').val();
        if (dltDoc != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/sector_actual/deleteConsultingDoc",
                data: {
                    mentr: dltDoc,
                    table: 'plan_tap',
                    field: dltDocfield
                },
                dataType: 'json',
                success: function (msg) {
                    location.reload();
                }
            });
        }
    });

    function delContract(mtrid, field) {
        $('#deletemodal').modal('show');
        $('#dltDoc').val(mtrid);
        $('#dltDocfield').val(field);
    }

    function uploadFile() {
        $(".uploadlogo").on('change', function () {
            var filename = readURL(this);
            $(this).parent().children('span').html(filename);
        });
    }

    $(document).on('change', '.contractdoc', function () {
        var filename = readURL(this);
        var reslt = filename.split('|*|');
        $(this).parent().children('span').html(reslt[0]);
        if (reslt[1] != '1') {
            $(this).parent().parent().children('.contract_msg').show();
            $(this).parent().parent().children('.contract_msg').text(reslt[1]);
        } else {
            $(this).parent().parent().children('.contract_msg').text('');
            $(this).parent().parent().children('.contract_msg').hide();
        }
    });
    $(document).on('change', '.reportsdoc', function () {
        var filename = readURL(this);
        var reslt = filename.split('|*|');
        $(this).parent().children('span').html(reslt[0]);
        if (reslt[1] != '1') {
            $(this).parent().parent().children('.reports_msg').removeClass('hidden_cls');
            $(this).parent().parent().children('.reports_msg').show();
            $(this).parent().parent().children('.reports_msg').text(reslt[1]);
        } else {
            $(this).parent().parent().children('.reports_msg').addClass('hidden_cls');
            $(this).parent().parent().children('.reports_msg').text('');
            $(this).parent().parent().children('.reports_msg').hide();
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
</script>
<style>
    .table_configcontentnew table {
        margin: 0 0 10px !important;
        /* border: 1px solid #ccc; */
        box-shadow: 0 0px 10px rgba(0, 0, 0, 0.07);
        padding: 5px;
        border-radius: 3px;
        background-color: #fff !important;
        overflow-x: auto;
        /* display: block; */
        white-space: nowrap;
    }
</style>
</body>

</html>
