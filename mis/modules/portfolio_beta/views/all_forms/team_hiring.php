<?php
$company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
$quater_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_quarter = $this->Mportfolio->monthByQuarters();
$get_quarter_fieldName = array("Q1" => 'q_one_desc', "Q2" => 'q_two_desc', "Q3" => 'q_three_desc', "Q4" => 'q_four_desc');
$get_quarter_monthField = array("1" => 'jan_desc', "2" => 'feb_desc', "3" => 'mar_desc', "4" => 'apr_desc', "5" => 'may_desc', "6" => 'jun_desc', "7" => 'jul_desc', "8" => 'aug_desc', "9" => 'sep_desc', "10" => 'oct_desc', "11" => 'nov_desc', "12" => 'dec_desc');

$plan = $qual_achieve[0];
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
                            <a class="nav-item nav-link  " id="nav-Companymaster-tab"    href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-Companymaster" aria-selected="true" style="margin-right: 15px;position: relative;">Updates</a>
                        </div>
                        <div class="new-nav-changes1"><div class="new-changes-head1"> Portfolio Information</div>
                            <a class="nav-item nav-link" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/product/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="false">Product &amp; Sales</a>
                            <a class="nav-item nav-link" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/finance/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Finance &amp; Fundraise</a>
                            <a class="nav-item nav-link active" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/hiring/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">04</a>
                            <a class="nav-item nav-link" id="nav-governance-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/impact/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-governance" aria-selected="false">Impact</a>
                            <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/milestone/' . $innovation_id . '/' . $current_financial; ?>" aria-controls="nav-cap" aria-selected="false">Milestone Tracker</a>
                        </div>
                        <div class="new-nav-changes2"><div class="new-changes-head2">Incubator Services/Interventions</div>
                            <a class="nav-item nav-link" id="nav-relationship-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/mentor/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-relationship" aria-selected="false" style="margin-left: 15px;">Mentors &amp; Partnerships </a>
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
                                    <h4>Team &amp; Board Meetings</h4>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                                    <ul class="milestone-links">
                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
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
                                <?php $this->load->view('all_forms/left_menu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'hiring', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
                            </div>
                            <main class="page-content">
                                <div class="row dataconfig">
                                    <div class="col-xl-8 col-lg-8 col-md-6 col-12 pad0">
                                        <?php
                                        $get_Qval = $actual_quarter[$current_month];
                                        if ($get_Qval == 'Q4') {
                                            $get_end_year = $this->Mportfolio->getFYtoYear($this->session->userdata('partner_id'), $current_financial);
                                            $next_financial = $get_end_year[0]['fin_to_year'];
                                        } else {
                                            $next_financial = $current_financial;
                                        }
                                        ?>
                                        <h4>Team - Hiring &amp; Current Strength ><span> <?= $last_month . ' ' . $next_financial; ?></span></h4>
                                    </div>
                                    <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-12 text-right">
                                            <!--<a href="javascript:void(0)" class="edit-btnconfig editBtn" id="addTeam"><i class="fas fa-plus-circle"></i> Add New</a>-->
                                            <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                        </div>
                                    <?php } ?>

                                </div>
                                <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <li class="tab-slider--triggerform active"><a href="javascript:void(0)">Team</a></li>
                                            <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/meeting/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Board Meetings</a></li>
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
                                                <form method="post" id="hiringPlanForm" action="<?php echo base_url() . 'index.php/portfolio/all_forms/addHiringPlan'; ?>" autocomplete="off" enctype="multipart/form-data">
                                                    <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                    <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                    <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                    <input type='hidden' name='module_id' id="module_id" value="15">
                                                    
                                                    <?php /*
                                                      <div class="row">
                                                      <div class="col-xl-12 col-lg-12 col-md-12 col-12 table_configcontentnew">
                                                      <div id="accordion">
                                                      <table class="input-fundtable mar-tp0">
                                                      <thead class="hiringTable">
                                                      <tr>
                                                      <th width="25%"></th>
                                                      <th width="25%"class="text-center">YTD</th>
                                                      <th width="25%"class="text-center">Current</th>
                                                      <th width="5%" class="text-center">&nbsp;</th>
                                                      </tr>
                                                      </thead>
                                                      <tbody id='team_add'>
                                                      <?php
                                                      $j = 1;
                                                      $total_ytd_hire = array();
                                                      $hire_job = $job_list[0];
                                                      $hire_count = isset($hire_job) ? count($job_list) : count($designation_list);

                                                      for ($i = 0; $i < $hire_count; $i++) {
                                                      $plan = $team_plan[0];
                                                      $plan_count = isset($plan) ? count($team_plan) : 0;

                                                      if (count($hire_job) == 0) {
                                                      $job_title = $designation_list[$i]['name'];
                                                      } else {
                                                      $job_title = $job_list[$i]['job_name'];
                                                      }

                                                      $cond['inv_id'] = $innovation_id;
                                                      $cond['job_name'] = $job_title;
                                                      $get_data = $this->Mportfolio->getCommonData('plan_team_hiring', $cond, '', '3');

                                                      $status = 3;
                                                      $total_ytd = $now_value = $only_value = 0;
                                                      $all_ytd = $this->Mportfolio->getFinanceDetails('plan_team_hiring', $cond, $current_month, $current_financial, $status, 'now');
                                                      $now_ytd = $this->Mportfolio->getFinanceDetails('plan_team_hiring', $cond, $current_month, $current_financial, $status, 'last');
                                                      $only_ytd = $this->Mportfolio->getFinanceDetails('plan_team_hiring', $cond, $current_month, $current_financial, $status);

                                                      foreach ($all_ytd as $value) {
                                                      $a_ytd = str_replace(',', '', $value['current_value']);
                                                      $total_ytd += $a_ytd;
                                                      }
                                                      foreach ($now_ytd as $value) {
                                                      $n_ytd = str_replace(',', '', $value['current_value']);
                                                      $now_value += $n_ytd;
                                                      }
                                                      foreach ($only_ytd as $value) {
                                                      $o_ytd = str_replace(',', '', $value['current_value']);
                                                      $only_value += $o_ytd;
                                                      }
                                                      array_push($total_ytd_hire, $total_ytd);
                                                      ?>
                                                      <tr id="team_tr_<?= $j; ?>" class="team_more">
                                                      <td class="vill-gray"><?= $job_title; ?></td>
                                                      <input type="hidden" name="team_name[]" id="team_name_<?php echo $j; ?>" value="<?= $job_title; ?>">
                                                      <input type='hidden' name="team_id[]" id='team_id_<?php echo $j; ?>' value='<?= $team_plan[$i]['id']; ?>'>
                                                      <input type='hidden' id='tot_ytd_<?php echo $j; ?>' value='<?= $now_value; ?>'>
                                                      <td>
                                                      <div class="form-group">
                                                      <input class="form-control form-control-sm currencyField readOnly" readonly="" type="text" placeholder="0" name="team_ytd[]" id="teamYtd_<?php echo $j; ?>" value='<?= $total_ytd; ?>'>
                                                      </div>
                                                      </td>
                                                      <td>
                                                      <div class="form-group">
                                                      <input class="form-control form-control-sm numberField" type="text" placeholder="00" name='current_number[]' id='current_number_<?php echo $j; ?>' value='<?= $only_value; ?>' maxlength="9">
                                                      </div>
                                                      </td>
                                                      <td>
                                                      <?php if (count($team_plan) > 0) { ?>
                                                      <a class="deleteteaminput text-danger deleteTeam" data-dyn="<?php echo $j; ?>" data-dyn-name="team" href="javascript:void(0)">
                                                      <i class="fas fa-trash"></i>
                                                      </a>
                                                      <?php } else { ?>
                                                      <span class="deleteteaminput cursor" title="Remove" onclick="hideRow(<?= $j; ?>);"><i class="fas fa-minus-circle"></i></span>
                                                      <?php } ?>
                                                      </td>
                                                      </tr>
                                                      <?php
                                                      $j++;
                                                      }
                                                      ?>
                                                      </tbody>
                                                      <tfoot>
                                                      <tr>
                                                      <td><b>Total</b></td>
                                                      <td>
                                                      <div class="form-group">
                                                      <input class="form-control form-control-sm totalytdField readOnly" readonly="" type="text" id='totalYTD' name='total_ytd' value='<?= array_sum($total_ytd_hire); ?>'>
                                                      </div>
                                                      </td>
                                                      <td>
                                                      <div class="form-group">
                                                      <input class="form-control form-control-sm totalField readOnly" readonly="" type="text" id='totalValue' name='total_value' value='<?= $team_plan[0]['total_value']; ?>'>
                                                      </div>
                                                      </td>
                                                      <td></td>
                                                      </tr>
                                                      </tfoot>
                                                      </table>
                                                      </div>
                                                      </div>
                                                      </div>
                                                     */ ?>

                                                    <div class="table_configcontentnew pad-bt0">
                                                        <div class="tabpanel-title">
                                                            <div class="row">
                                                                <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                    <h4>Employee Hires</h4>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                    <ul class="milestone-links">
                                                                        <li><a href="javascript:void(0)" id="addHires"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a> </li>
                                                                        <li class="brd-left-onboard" id="editHires"><a href="javascript:void(0)" id="edit_hires" class="opacity5"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a></li>
                                                                        <li class="brd-left-onboard" id="disableHires" style="cursor: not-allowed;">
                                                                            <a class="deleteControl" href="javascript:void(0)" id="deleteHires" style="pointer-events: none;"><i class="fas fa-trash"></i>&nbsp;Delete</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class=" table_configcontentnew" id="loadHireData">
                                                            <input type="hidden" id="hireCount" value="<?= count($hire_list); ?>">
                                                            <table class="table" style="margin-top: 0">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="3%"></th>
                                                                        <th width="19%">Position/Role</th>
                                                                        <th width="8%">Gender</th>
                                                                        <th width="13%">Date Opened</th>
                                                                        <th width="20%">Offer Letter Signed</th>
                                                                        <th width="40%">Comments</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody class="add_more_hires">
                                                                    <?php
                                                                    $hireData_count = isset($hire_list) && count($hire_list) > 0 ? count($hire_list) : '1';
                                                                    $j = 1;
                                                                    for ($i = 0; $i < $hireData_count; $i++) {
                                                                        $get_open_date = (isset($hire_list[$i]['date_value']) && $hire_list[$i]['date_value'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($hire_list[$i]['date_value'])) : '';
                                                                        $get_sign_date = (isset($hire_list[$i]['signed_date']) && $hire_list[$i]['signed_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($hire_list[$i]['signed_date'])) : '';
                                                                        ?>
                                                                        <tr id="hire_tr_<?php echo $j; ?>" class="hire_more">
                                                                            <td>
                                                                                <input type="checkbox" class="check_box hireCheck" aria-label="Checkbox for following text input" name="check_hire" id="check_hire_<?php echo $j; ?>" value="<?= $hire_list[$i]['id']; ?>">
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <input type="text" style="width: 150px;" name="hire_position[]" id="hire_position_<?php echo $j; ?>" value="<?= $hire_list[$i]['role']; ?>" class="form-control form-control-sm" placeholder="">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <select style="width: 137px;" class="form-control form-control-sm" name="hire_gender[]" id="hire_gender_<?php echo $j; ?>">
                                                                                        <option value="">--Select--</option>
                                                                                        <option value="1" <?php if ($hire_list[$i]['gender'] == 1) echo 'selected'; ?>>Male</option>
                                                                                        <option value="2" <?php if ($hire_list[$i]['gender'] == 2) echo 'selected'; ?>>Female</option>
                                                                                        <option value="3" <?php if ($hire_list[$i]['gender'] == 3) echo 'selected'; ?>>Unknown</option>
                                                                                        <option value="4" <?php if ($hire_list[$i]['gender'] == 4) echo 'selected'; ?>>Other</option>
                                                                                    </select>
                                                                                </div>
                                                                                <label class="error" id="hire_gender<?= $i . '_error'; ?>"></label>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <input type="text" style="width: 120px;" name="hire_openDate[]" id="hire_openDate_<?php echo $j; ?>" value="<?= $get_open_date; ?>" class="form-control form-control-sm dateOpenCalendar" placeholder="dd-mm-yyyy">
                                                                                </div>
                                                                                <label class="error" id="hire_openDate<?= $i . '_error'; ?>"></label>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <input type="text" style="width:120px;" name="hire_signDate[]" id="hire_signDate_<?php echo $j; ?>" value="<?= $get_sign_date; ?>" class="form-control form-control-sm disDate dateCalendar" placeholder="dd-mm-yyyy">
                                                                                </div>
                                                                                <label class="error" id="hire_signDate<?= $i . '_error'; ?>"></label>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <textarea row="5" class="form-control" name="hire_comment[]" id="hire_comment_<?php echo $j; ?>"><?= $hire_list[$i]['comments']; ?></textarea>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    <input type="hidden" name="hire_id[]" value="<?= $hire_list[$i]['id']; ?>">
                                                                    <?php
                                                                    $j++;
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="table_configcontentnew pad-bt0">
                                                            <div class="tabpanel-title">
                                                                <div class="row">
                                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                        <h4>Employee Exits</h4>
                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                        <ul class="milestone-links">
                                                                            <li><a href="javascript:void(0)" id="addExit"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a> </li>
                                                                            <li class="brd-left-onboard" id="editExit"><a href="javascript:void(0)" id="edit_exit" class="opacity5"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a></li>
                                                                            <li class="brd-left-onboard" id="disableExit" style="cursor: not-allowed;">
                                                                                <a class="deleteControl" href="javascript:void(0)" id="deleteExit" style="pointer-events: none;"><i class="fas fa-trash"></i>&nbsp;Delete</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" table_configcontentnew" id="loadExitData">
                                                            <input type="hidden" id="exitCount" value="<?= count($exit_list); ?>">
                                                            <table class="table" style="margin-top: 0">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="3%"></th>
                                                                        <th width="19%">Position/Role</th>
                                                                        <th width="8%">Gender</th>
                                                                        <th width="13%">Type of Exit</th>
                                                                        <th width="20%">Date of Exit</th>
                                                                        <th width="40%">Comments</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="add_more_exit">
                                                                    <?php
                                                                    $exitData_count = isset($exit_list) && count($exit_list) > 0 ? count($exit_list) : '1';
                                                                    $k = 1;
                                                                    for ($i = 0; $i < $exitData_count; $i++) {
                                                                        $get_exit_date = (isset($exit_list[$i]['date_value']) && $exit_list[$i]['date_value'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($exit_list[$i]['date_value'])) : '';
                                                                        ?>
                                                                        <tr id="exit_tr_<?php echo $k; ?>" class="exit_more">
                                                                            <td>
                                                                                <input type="checkbox" class="check_box exitCheck" aria-label="Checkbox for following text input" name="check_exit" id="check_exit_<?php echo $k; ?>" value="<?= $exit_list[$i]['id']; ?>">
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <input type="text" style="width: 150px;" name="exit_position[]" id="exit_position_<?php echo $k; ?>" value="<?= $exit_list[$i]['role']; ?>" class="form-control form-control-sm" placeholder="">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <select style="width: 137px;"class="form-control form-control-sm" name="exit_gender[]" id="exit_gender_<?php echo $k; ?>">
                                                                                        <option value="">--Select--</option>
                                                                                        <option value="1" <?php if ($exit_list[$i]['gender'] == 1) echo 'selected'; ?>>Male</option>
                                                                                        <option value="2" <?php if ($exit_list[$i]['gender'] == 2) echo 'selected'; ?>>Female</option>
                                                                                        <option value="3" <?php if ($exit_list[$i]['gender'] == 3) echo 'selected'; ?>>Unknown</option>
                                                                                        <option value="4" <?php if ($exit_list[$i]['gender'] == 4) echo 'selected'; ?>>Other</option>
                                                                                    </select>
                                                                                </div>
                                                                                <label class="error" id="exit_gender<?= $i . '_error'; ?>"></label>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <select style="width: 120px;"class="form-control form-control-sm" name="exit_type[]" id="exit_type_<?php echo $k; ?>">
                                                                                        <option value="">--Select--</option>
                                                                                        <option value="1" <?php if ($exit_list[$i]['exit_type'] == 1) echo 'selected'; ?>>Voluntary</option>
                                                                                        <option value="2" <?php if ($exit_list[$i]['exit_type'] == 2) echo 'selected'; ?>>Terminated</option>
                                                                                    </select>
                                                                                </div>
                                                                                <label class="error" id="exit_type<?= $i . '_error'; ?>"></label>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <input type="text" style="width:120px;" name="exit_date[]" id="exit_date_<?php echo $k; ?>" value="<?= $get_exit_date; ?>" class="form-control form-control-sm disDate dateCalendar" placeholder="dd-mm-yyyy">
                                                                                </div>
                                                                                <label class="error" id="exit_date<?= $i . '_error'; ?>"></label>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <textarea row="5" class="form-control" name="exit_comment[]" id="exit_comment_<?php echo $k; ?>"><?= $exit_list[$i]['comments']; ?></textarea>
                                                                                </div>
                                                                            </td>
                                                                    <input type="hidden" name="exit_id[]" value="<?= $exit_list[$i]['id']; ?>">
                                                                    </tr>
                                                                    <?php
                                                                    $k++;
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="table_configcontentnew pad-bt0">
                                                            <div class="tabpanel-title">
                                                                <div class="row">
                                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                        <h4>Satisfaction Surveys</h4>
                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                        <ul class="milestone-links">
                                                                            <li><a href="javascript:void(0)" id="addSurvey"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a> </li>
                                                                            <li class="brd-left-onboard" id="editSurvey"><a href="javascript:void(0)" id="edit_survey" class="opacity5"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a></li>
                                                                            <li class="brd-left-onboard" id="disableSurvey" style="cursor: not-allowed;">
                                                                                <a class="deleteControl" href="javascript:void(0)" id="deleteSurvey" style="pointer-events: none;"><i class="fas fa-trash"></i>&nbsp;Delete</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class=" table_configcontentnew" id="loadSurveyData">
                                                            <input type="hidden" id="surveyCount" value="<?= count($survey_list); ?>">
                                                            <table class="table" style="margin-top: 0">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="4%"></th>
                                                                        <th width="13%">Date of Survey Close</th>
                                                                        <th width="25%">Comments</th>
                                                                        <th width="20%">Document</th>
                                                                        <th width="48%">&nbsp;</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="add_more_survey">
                                                                    <?php
                                                                    $surveyData_count = isset($survey_list) && count($survey_list) > 0 ? count($survey_list) : '1';
                                                                    $m = 1;
                                                                    for ($i = 0; $i < $surveyData_count; $i++) {
                                                                        $get_survey_date = (isset($survey_list[$i]['date_value']) && $survey_list[$i]['date_value'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($survey_list[$i]['date_value'])) : '';
                                                                        ?>
                                                                        <tr id="survey_tr_<?php echo $m; ?>" class="survey_more">
                                                                            <td>
                                                                                <input type="checkbox" class="check_box surveyCheck" aria-label="Checkbox for following text input" name="check_survey" id="check_survey_<?php echo $i; ?>" value="<?= $survey_list[$i]['id']; ?>">
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <input type="text" style="width: 170px;" name="survey_date[]" id="survey_date_<?php echo $m; ?>" value="<?= $get_survey_date; ?>" class="form-control form-control-sm disDate dateCalendar" placeholder="dd-mm-yyyy">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <textarea row="5" class="form-control" name="survey_comment[]" id="survey_comment_<?php echo $m; ?>"><?= $survey_list[$i]['comments']; ?></textarea>
                                                                                </div>
                                                                            </td>
                                                                            <td class="sowFile">
                                                                                <div class="fileUpload blue-btn btn width100">
                                                                                    <?php
                                                                                    if (isset($survey_list[$i]['document']) && !empty($survey_list[$i]['document'])) {
                                                                                        echo strlen($survey_list[$i]['document']) > 20 ? "..." . substr($survey_list[$i]['document'], -20) : $survey_list[$i]['document'];
                                                                                    } else {
                                                                                        ?>
                                                                                        <span><i class="fas fa-upload"></i>Upload</span>
                                                                                    <?php } ?>
                                                                                    <input type="file" class="uploadlogo" data-dyn="<?= $m; ?>" name="survey_doc[]" id="survey_doc<?= $m; ?>" />
                                                                                </div>
                                                                                <label class="sow_msg error" id="survey_doc<?= $m . '_error'; ?>"></label>
                                                                                <?php if (isset($survey_list[$i]['document']) && !empty($survey_list[$i]['document'])) { ?>
                                                                                    <span class="download-btn"><a href="<?php echo base_url() . 'uploads/portfolio/team_hiring/' . $survey_list[$i]['document']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                                                    <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                                        <span><a href="javascript:void(0)" class="delete-btnconfig" title="Delete Document" onclick="delDocument('<?= $survey_list[$i]['id']; ?>')" id="removeDoc"><i class="fas fa-trash"></i></a></span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                                <input type="hidden" name="old_survey_doc[]" id="old_survey_doc<?= $m; ?>" class="uploadlogo" data-dyn="<?= $m; ?>" value="<?php echo $survey_list[$i]['document']; ?>">
                                                                            </td>
                                                                            <td></td>
                                                                    <input type="hidden" name="survey_id[]" value="<?= $survey_list[$i]['id']; ?>">
                                                                    </tr>
                                                                    <?php
                                                                    $m++;
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
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
                                                                <textarea rows="3" class="mceEditorActive" id="achieveContent" name='achieveContent' ><?= stripslashes(str_replace("\\r\\n", '', $plan['description'])); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
													
													
                                                    </div>
                                                </form>
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

<div class="modal" id="deleteHireModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
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
                            <p>you are about delete <span id="delHireCount"></span> selected information fields, you
                                can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteHireRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="deleteExitModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
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
                            <p>you are about delete <span id="delExitCount"></span> selected information fields, you
                                can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteExitRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="deleteSurveyModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
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
                            <p>you are about delete <span id="delSurveyCount"></span> selected information fields, you
                                can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteSurveyRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="qualitCount" value="<?= count($qual_achieve); ?>">

<style type="text/css">
    i.fas.fa-minus-circle{
        color:#ffae42;
    }
</style>

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

        var hireButtons = $('#hireCount').val();
        if (hireButtons > 0) {
            $('#loadHireData input[type="text"],#loadHireData select,#loadHireData textarea').attr('readonly', 'readonly');
            $('#loadHireData select').css('pointer-events', 'none');
        } else {
            datepickerEachFunction('hire_signDate_');
        }

        var exitButtons = $('#exitCount').val();
        if (exitButtons > 0) {
            $('#loadExitData input[type="text"],#loadExitData select,#loadExitData textarea').attr('readonly', 'readonly');
            $('#loadExitData select').css('pointer-events', 'none');
        } else {
            datepickerEachFunction('exit_date_');
        }

        var surveyButtons = $('#surveyCount').val();
        if (surveyButtons > 0) {
            $('#loadSurveyData input[type="text"],#loadSurveyData select,#loadSurveyData textarea').attr('readonly', 'readonly');
            $('#loadSurveyData select').css('pointer-events', 'none');
            $('#loadSurveyData input[type="file"]').css("pointer-events", "none");
        } else {
            datepickerEachFunction('survey_date_');
        }

        $('#financial_year').attr('readonly', false);
        $('#financial_year').css("pointer-events", "");
        $('#editBtn').addClass('opacity5');
        $(".dateOpenCalendar").datepicker({dateFormat: "dd-mm-yy"});
    }

    $(document).on('click', '#editBtn', function () {
        $('#editBtn').removeClass('opacity5');
        tinymce.get('achieveContent').setMode('design');
        $('#achieveField').addClass('greenplantxt');
        $('#achieveField').removeClass('fieldDisabled');
    });
    $(document).on('click', '#editHires', function () {
        $('#loadHireData input[type="text"],#loadHireData select,#loadHireData textarea').attr('readonly', false);
        $('#loadHireData select').css('pointer-events', '');
        $('#edit_hires').removeClass('opacity5');
        datepickerEachFunction('hire_signDate_');
    });
    $(document).on('click', '#editExit', function () {
        $('#loadExitData input[type="text"],#loadExitData select,#loadExitData textarea').attr('readonly', false);
        $('#loadExitData select').css('pointer-events', '');
        $('#edit_exit').removeClass('opacity5');
        datepickerEachFunction('exit_date_');
    });
    $(document).on('click', '#editSurvey', function () {
        $('#loadSurveyData input[type="text"],#loadSurveyData select,#loadSurveyData textarea').attr('readonly', false);
        $('#loadSurveyData select').css('pointer-events', '');
        $('#loadSurveyData input[type="file"]').css("pointer-events", "");
        $('#edit_survey').removeClass('opacity5');
        datepickerEachFunction('survey_date_');
    });
    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/all_forms/hiring/' + inv_id + '/' + year;
    }

    $(document).on('click', '#addTeam', function () {
        if ($('.team_more').length) {
            var dyn = $('.team_more').length;
            var increa = parseInt(dyn) + 1;
            var datas = '<tr id="team_tr_' + increa + '" class="team_more"><td><div class="form-group">';
            datas += '<input type="text" class="form-control form-control-sm" id="team_name_' + increa + '" name="team_name[]" value=""><input type="hidden" name="team_id[]" id="team_id_' + increa + '" value=""><input type="hidden" id="tot_ytd_' + increa + '" value=""></div></td>';
            datas += '<td><div class="form-group"><input type="text" class="form-control form-control-sm currencyField readOnly" readonly="" placeholder="0" id="teamYtd_' + increa + '" name="team_ytd[]" value=""></div></td>';
            datas += '<td><div class="form-group"><input class="form-control form-control-sm numberField" type="text" placeholder="00" name="current_number[]" id="current_number_' + increa + '" maxlength="9"></div></td><td></td>';
            $(datas).insertAfter($('#team_tr_' + dyn));
        } else {
            var datas = '<tr id="team_tr_1" class="team_more"><td><div class="form-group">';
            datas += '<input type="text" class="form-control form-control-sm" id="team_name_1" name="team_name[]" value=""><input type="hidden" name="team_id[]" id="team_id_1" value=""><input type="hidden" id="tot_ytd_1" value=""></div></td>';
            datas += '<td><div class="form-group"><input type="text" class="form-control form-control-sm currencyField readOnly" readonly="" placeholder="0" id="teamYtd_1" name="team_ytd[]" value=""></div></td>';
            datas += '<td><div class="form-group"><input class="form-control form-control-sm numberField" type="text" placeholder="00" name="current_number[]" id="current_number_1" maxlength="9"></div></td><td></td>';
            $('#team_add').append(datas);
        }
    });
    function hideRow(id) {
        $('#team_tr_' + id).closest('tr').remove();
        var tr_count = $('.team_more').length;
        if (tr_count == 0) {
            var datas = '<tr id="team_tr_1" class="team_more"><td><div class="form-group">';
            datas += '<input type="text" class="form-control form-control-sm" id="team_name_1" name="team_name[]" value=""><input type="hidden" name="team_id[]" id="team_id_1" value=""><input type="hidden" id="tot_ytd_1" value=""></div></td>';
            datas += '<td><div class="form-group"><input type="text" class="form-control form-control-sm currencyField readOnly" readonly="" placeholder="0" id="teamYtd_1" name="team_ytd[]" value=""></div></td>';
            datas += '<td><div class="form-group"><input class="form-control form-control-sm numberField" type="text" placeholder="00" name="current_number[]" id="current_number_1" maxlength="9"></div></td><td></td>';
            $(datas).insertAfter($('.hiringTable'));
            datepickerEachFunction();
        }
    }

    $(document).on('click', '.deleteTeam', function () {
        var dynval = $(this).attr("data-dyn");
        var dynvalname = $(this).attr("data-dyn-name");
        var delete_id = $('#team_id_' + dynval).val();
        var delete_name = $('#team_name_' + dynval).val();
        $('#deletemodal').modal('show');
        $('#team_val').val(dynval);
        $('#deleteID').val(delete_id);
        $('#deleteName').val(delete_name);
    });
    $('.totalytdField').each(function (key, value) {
        var currency = $('.totalytdField');
        if (currency.val != 0 || currency.val == '') {
            currency.val(inrFormat(currency.val()));
        } else {
            currency.val(0);
        }
    });
    $('.currencyField').each(function (key, value) {
        var inc = key + 1;
        var currency = $('#teamYtd_' + inc);
        if (currency.val != 0 || currency.val == '') {
            if (currency.val() != '') {
                var decim = pad(currency.val());
                currency.val(decim);
                currency.val(inrFormat(currency.val()));
            }
        } else {
            currency.val(0);
        }
    });
    $(document).on("input", ".numberField", function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9]/g, ''));
    });
    function pad(num) {
        var s = num + "";
        s = parseFloat(s, 10);
        return s;
    }

    $(document).on("input", ".numberField", function (evt) {
        var sum = 0;
        var ytd_sum = 0;
        $('.numberField').each(function (key, value) {
            var inc = key + 1;
            var currency = $('#current_number_' + inc);
            if (currency.val != 0 || currency.val == '') {
                if (currency.val() != '') {
                    //                                                                                                            var decim = pad(currency.val());
                    //                                                                                                            currency.val(decim);
                    currency.val(inrFormat(currency.val()));
                }
            } else {
                currency.val(0);
            }

            var total = $('#tot_ytd_' + inc).val();
            var cost = $('#current_number_' + inc).val();
            var totalVal = Number(total.replace(/[^0-9.-]+/g, ""));
            var currencyVal = Number(cost.replace(/[^0-9.-]+/g, ""));
            var new_ytd = parseInt(totalVal) + parseInt(currencyVal);
            $('#teamYtd_' + inc).val(inrFormat(new_ytd));
            var amount = $(this).val();
            sum += Number(amount.replace(/[^0-9.-]+/g, ""));
            var actual_ytd = $('#teamYtd_' + inc).val();
            ytd_sum += Number(actual_ytd.replace(/[^0-9.-]+/g, ""));
        });
        $('#totalValue').val(inrFormat(sum));
        $('#totalYTD').val(inrFormat(ytd_sum));
        //                                                                                $('.currencyField').each(function (key, value) {
        //                                                                                    var inc = key + 1;
        //                                                                                    var actual_ytd = $('#teamYtd_' + inc).val();
        //                                                                                    ytd_sum += Number(actual_ytd.replace(/[^0-9.-]+/g, ""));
        //                                                                                });
        //                                                                                $('#totalYTD').val(inrFormat(ytd_sum));
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

    $('#deleteRecord').on('click', function () {
        var impt = $('#team_val').val();
        var deleteId = $('#deleteID').val();
        var deleteName = $('#deleteName').val();
        $('#team_tr_' + impt).remove();
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#current_year').val();
        var cur_month = $('#current_month').val();
        if (!$('.team_more').length) {
            var datas = '<tr id="team_tr_1" class="team_more"><td><div class="form-group">';
            datas += '<input type="text" class="form-control form-control-sm" id="team_name_1" name="team_name[]" value=""><input type="hidden" id="tot_ytd_1" value=""></div></td>';
            datas += '<td><div class="form-group"><input type="text" class="form-control form-control-sm currencyField readOnly" readonly="" placeholder="0" id="teamYtd_1" name="team_ytd[]" value=""></div></td>';
            datas += '<td><div class="form-group"><input class="form-control form-control-sm numberField" type="text" placeholder="00" name="current_number[]" id="current_number_1"></div></td><td></td>';
            $('#team_add').append(datas);
        }
        $('#deletemodal').modal('hide');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/pending_inputs/deleteTeamHiring",
            data: {
                name: deleteName,
                inv_id: inv_id,
                fin_year: fin_year,
                cur_month: cur_month,
                table: 'plan_team_hiring'
            },
            dataType: 'json',
            success: function (msg) {
                $('#accordion').load(location.href + ' #accordion');
                $('#deletemodal').modal('hide');
                $('#deleteMsg').show();
                setTimeout(function () {
                    onLoad();
                }, 500);
                setTimeout(function () {
                    $('#deleteMsg').hide();
                }, 3000);
            }
        });
    });
//        $(document).on('click', ".saveContinue", function (e) {
//            if ($('#hiringPlanForm').valid()) {
//                $('.saveContinue').css('pointer-events', 'none');
//                $('#hiringPlanForm').submit();
//            }
//        });
    $('.plan-structure-new').css({'height': (($(window).height()) - 380) + 'px'});
    $(document).on('click', '#addHires', function () {
        var dyn = $(".hire_more").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="hire_tr_' + i + '" class="hire_more">' +
                '<td><input type="checkbox" class="check_box" aria-label="Checkbox for following text input" name="check_hire" id="check_hire_' + i + '" value=""></td>' +
                '<td><div class="form-group display-flex"><input type="text" style="width: 150px;" name="hire_position[]" id="hire_position_' + i + '" value="" class="form-control form-control-sm" placeholder=""></div></td>' +
                '<td><div class="form-group display-flex"><select style="width: 137px;" class="form-control form-control-sm" name="hire_gender[]" id="hire_gender_' + i + '"><option value="">--Select--</option><option value="1">Male</option><option value="2">Female</option><option value="3">Unknown</option><option value="4">Other</option></select></div><label class="error" id="hire_gender' + (i - 1) + '_error"></label></td>' +
                '<td><div class="form-group display-flex"><input type="text" style="width:120px;" class="form-control form-control-sm dateOpenCalendar" placeholder="dd-mm-yyyy" name="hire_openDate[]" id="hire_openDate_' + i + '" value=""></div><label class="error" id="hire_openDate' + (i - 1) + '_error"></label></td>' +
                '<td><div class="form-group display-flex"><input type="text" style="width:120px;" class="form-control form-control-sm disDate dateCalendar" placeholder="dd-mm-yyyy" name="hire_signDate[]" id="hire_signDate_' + i + '" value=""></div><label class="error" id="hire_signDate' + (i - 1) + '_error"></label></td>' +
                '<td><div class="form-group display-flex"><textarea row="5" class="form-control" name="hire_comment[]" value="" id="hire_comment_' + i + '"></textarea></div></td></tr>';
        $(datas).insertAfter($('#hire_tr_' + dyn));
        $(".dateOpenCalendar").datepicker({dateFormat: "dd-mm-yy"});
        datepickerEachFunction('hire_signDate_');
    });
    $(document).on('click', '#addExit', function () {
        var dyn = $(".exit_more").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="exit_tr_' + i + '" class="exit_more">' +
                '<td><input type="checkbox" class="check_box" aria-label="Checkbox for following text input" name="check_exit" id="check_exit_' + i + '" value=""></td>' +
                '<td><div class="form-group display-flex"><input type="text" style="width: 150px;" name="exit_position[]" id="exit_position' + i + '" value="" class="form-control form-control-sm" placeholder=""></div></td>' +
                '<td><div class="form-group display-flex"><select style="width: 137px;" class="form-control form-control-sm" name="exit_gender[]" id="exit_gender_' + i + '"><option value="">--Select--</option><option value="1">Male</option><option value="2">Female</option><option value="3">Unknown</option><option value="4">Other</option></select></div><label class="error" id="exit_gender' + (i - 1) + '_error"></label></td>' +
                '<td><div class="form-group display-flex"><select style="width: 120px;"class="form-control form-control-sm" name="exit_type[]" id="exit_type_' + i + '"><option value="">--Select--</option><option value="1">Voluntary</option><option value="2">Terminated</option></select></div><label class="error" id="exit_type' + (i - 1) + '_error"></label></td>' +
                '<td><div class="form-group display-flex"><input type="text" style="width:120px;" class="form-control form-control-sm disDate dateCalendar" placeholder="dd-mm-yyyy" name="exit_date[]" id="exit_date_' + i + '" value=""></div><label class="error" id="exit_date' + (i - 1) + '_error"></label></td>' +
                '<td><div class="form-group display-flex"><textarea row="5" class="form-control" name="exit_comment[]" value="" id="exit_comment_' + i + '"></textarea></div></td></tr>';
        $(datas).insertAfter($('#exit_tr_' + dyn));
        datepickerEachFunction('exit_date_');
    });
    $(document).on('click', '#addSurvey', function () {
        var dyn = $(".survey_more").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="survey_tr_' + i + '" class="survey_more">' +
                '<td><input type="checkbox" class="check_box" aria-label="Checkbox for following text input" name="check_survey" id="check_survey_' + i + '" value=""></td>' +
                '<td><div class="form-group display-flex"><input type="text" style="width:170px;" class="form-control form-control-sm disDate dateCalendar" placeholder="dd-mm-yyyy" name="survey_date[]" id="survey_date_' + i + '" value=""></div></td>' +
                '<td><div class="form-group display-flex"><textarea row="5" class="form-control" name="survey_comment[]" value="" id="survey_comment_' + i + '"></textarea></div></td>' +
                '<td class="sowFile"><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" id="survey_doc' + i + '" name="survey_doc[]" /></div><div class="download-btn"></div><span class="sow_msg hidden_cls error" id="survey_doc' + i + '_error">Invalid file</span></td></tr>';
        $(datas).insertAfter($('#survey_tr_' + dyn));
        datepickerEachFunction('survey_date_');
    });
    function datepickerEachFunction(id) {
        var sel_month = $('#current_month').val();
        var sel_year = $('#current_year').val();
        if (sel_month < 4) {
            sel_year = parseInt(sel_year) + 1;
        }
        $('.disDate').each(function (index, value) {
            $("#" + id + index).datepicker({
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
                    $("#" + id + index).val(fulldatevalue);
                },
                defaultDate: new Date(sel_year, sel_month - 1),
                stepMonths: 0
            });
        });
    }

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
        var hire_result = hireValidate();
        var exit_result = exitValidate();
        var survey_result = surveyValidate();
        if (hire_result == 1 || exit_result == 1 || survey_result == 1) {
            return false;
        } else {
            $('.saveContinue').css('pointer-events', 'none');
            $('#hiringPlanForm').submit();
            return true;
        }
    });
    function hireValidate() {
        var err = 0;
        var hire_arr = [];
        var hire_dyn = document.getElementsByName("hire_position[]").length;
        for (var r = 0; r < hire_dyn; r++) {
            var dyn_id = document.getElementsByName("hire_position[]")[r].id;
            hire_arr.push(dyn_id);
        }

        var s = 1;
        for (var q = 0; q < hire_arr.length; q++) {
            var hire_role = $('#hire_position_' + s).val();
            var hire_gender = $('#hire_gender_' + s).val();
            var hire_openDate = $('#hire_openDate_' + s).val();
            var hire_signDate = $('#hire_signDate_' + s).val();
            if (hire_role != '') {
                if (hire_gender == '') {
                    $('#hire_gender' + [q] + '_error').css('display', 'block');
                    $('#hire_gender' + [q] + '_error').text('Select gender');
                    err = 1;
                } else {
                    $('#hire_gender' + [q] + '_error').css('display', 'none');
                    $('#hire_gender' + [q] + '_error').text('');
                }
                if (hire_openDate == '') {
                    $('#hire_openDate' + [q] + '_error').css('display', 'block');
                    $('#hire_openDate' + [q] + '_error').text('Select date');
                    err = 1;
                } else {
                    $('#hire_openDate' + [q] + '_error').css('display', 'none');
                    $('#hire_openDate' + [q] + '_error').text('');
                }
                if (hire_signDate == '') {
                    $('#hire_signDate' + [q] + '_error').css('display', 'block');
                    $('#hire_signDate' + [q] + '_error').text('Select date');
                    err = 1;
                } else {
                    $('#hire_signDate' + [q] + '_error').css('display', 'none');
                    $('#hire_signDate' + [q] + '_error').text('');
                }
            }

            s++;
        }
        return err;
    }

    function exitValidate() {
        var err = 0;
        var exit_arr = [];
        var exit_dyn = document.getElementsByName("exit_position[]").length;
        for (var r = 0; r < exit_dyn; r++) {
            var dyn_id = document.getElementsByName("exit_position[]")[r].id;
            exit_arr.push(dyn_id);
        }

        var s = 1;
        for (var q = 0; q < exit_arr.length; q++) {
            var exit_role = $('#exit_position_' + s).val();
            var exit_gender = $('#exit_gender_' + s).val();
            var exit_type = $('#exit_type_' + s).val();
            var exit_date = $('#exit_date_' + s).val();
            if (exit_role != '') {
                if (exit_gender == '') {
                    $('#exit_gender' + [q] + '_error').css('display', 'block');
                    $('#exit_gender' + [q] + '_error').text('Select gender');
                    err = 1;
                } else {
                    $('#exit_gender' + [q] + '_error').css('display', 'none');
                    $('#exit_gender' + [q] + '_error').text('');
                }
                if (exit_type == '') {
                    $('#exit_type' + [q] + '_error').css('display', 'block');
                    $('#exit_type' + [q] + '_error').text('Select type');
                    err = 1;
                } else {
                    $('#exit_type' + [q] + '_error').css('display', 'none');
                    $('#exit_type' + [q] + '_error').text('');
                }
                if (exit_date == '') {
                    $('#exit_date' + [q] + '_error').css('display', 'block');
                    $('#exit_date' + [q] + '_error').text('Select date');
                    err = 1;
                } else {
                    $('#exit_date' + [q] + '_error').css('display', 'none');
                    $('#exit_date' + [q] + '_error').text('');
                }
            }

            s++;
        }
        return err;
    }

    function surveyValidate() {
        var err = 0;
        var survey_arr = [];
        var survey_dyn = document.getElementsByName("survey_doc[]").length;
        for (var r = 0; r < survey_dyn; r++) {
            var dyn_id = document.getElementsByName("survey_doc[]")[r].id;
            survey_arr.push(dyn_id);
        }
        var s = 1;
        for (var q = 0; q < survey_arr.length; q++) {
            var surv_date = $('#survey_date_' + s).val();
            var surv_doc = $('#' + survey_arr[q]).val();
            var surv_old_doc = $('#old_survey_doc' + s).val();
            if (surv_date != '' && surv_doc == '' && (surv_old_doc == '' || typeof surv_old_doc == 'undefined')) {
                $('#' + survey_arr[q] + '_error').css('display', 'block');
                $('#' + survey_arr[q] + '_error').text('Upload document');
                err = 1;
            } else {
                $('#' + survey_arr[q] + '_error').css('display', 'none');
                $('#' + survey_arr[q] + '_error').text('');
            }
            s++;
        }
        return err;
    }

    $(document).on('click', '#deleteHires', function () {
        $('#deleteHireModal').modal('show');
        var sel_item = $("input:checkbox[name=check_hire]:checked").length;
        $('#delHireCount').html(sel_item);
    });
    $(document).on('click', '#deleteExit', function () {
        $('#deleteExitModal').modal('show');
        var sel_item = $("input:checkbox[name=check_exit]:checked").length;
        $('#delExitCount').html(sel_item);
    });
    $(document).on('click', '#deleteSurvey', function () {
        $('#deleteSurveyModal').modal('show');
        var sel_item = $("input:checkbox[name=check_survey]:checked").length;
        $('#delSurveyCount').html(sel_item);
    });
    $('#deleteHireRecord').on('click', function () {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#current_year').val();
        var cur_month = $('#current_month').val();
        var deleteId = new Array();
        $("input:checkbox[name=check_hire]:checked").each(function () {
            deleteId.push($(this).val());
        });
        if ($("input:checkbox[name=check_hire]:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/all_forms/deleteHiringAchieve",
                data: {
                    id: deleteId,
                    inv_id: inv_id,
                    fin_year: fin_year,
                    cur_month: cur_month,
                    field: '1'
                },
                dataType: 'json',
                success: function (msg) {
                    $('#loadHireData').load(location.href + ' #loadHireData');
                    $('#deleteHireModal').modal('hide');
                    $('#deleteMsg').show();
                    setTimeout(function () {
                        onLoad();
                        deleteMore('check_hire', 'disableHires', 'deleteHires');
                    }, 500);
                    setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000);
                }
            });
        }
    });
    $('#deleteExitRecord').on('click', function () {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#current_year').val();
        var cur_month = $('#current_month').val();
        var deleteId = new Array();
        $("input:checkbox[name=check_exit]:checked").each(function () {
            deleteId.push($(this).val());
        });
        if ($("input:checkbox[name=check_exit]:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/all_forms/deleteHiringAchieve",
                data: {
                    id: deleteId,
                    inv_id: inv_id,
                    fin_year: fin_year,
                    cur_month: cur_month,
                    field: '2'
                },
                dataType: 'json',
                success: function (msg) {
                    $('#loadExitData').load(location.href + ' #loadExitData');
                    $('#deleteExitModal').modal('hide');
                    $('#deleteMsg').show();
                    setTimeout(function () {
                        onLoad();
                        deleteMore('check_exit', 'disableExit', 'deleteExit');
                    }, 500);
                    setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000);
                }
            });
        }
    });
    $('#deleteSurveyRecord').on('click', function () {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#current_year').val();
        var cur_month = $('#current_month').val();
        var deleteId = new Array();
        $("input:checkbox[name=check_survey]:checked").each(function () {
            deleteId.push($(this).val());
        });
        if ($("input:checkbox[name=check_survey]:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/all_forms/deleteHiringAchieve",
                data: {
                    id: deleteId,
                    inv_id: inv_id,
                    fin_year: fin_year,
                    cur_month: cur_month,
                    field: '3'
                },
                dataType: 'json',
                success: function (msg) {
                    $('#loadSurveyData').load(location.href + ' #loadSurveyData');
                    $('#deleteSurveyModal').modal('hide');
                    $('#deleteMsg').show();
                    setTimeout(function () {
                        onLoad();
                        deleteMore('check_survey', 'disableSurvey', 'deleteSurvey');
                    }, 500);
                    setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000);
                }
            });
        }
    });
    $('.hireCheck').on('click', function () {
        if ($("#loadHireData input:checkbox:checked").length > 0) {
            $('#disableHires').css("cursor", "pointer");
            $('#deleteHires').css("pointer-events", "");
        } else {
            $('#disableHires').css("cursor", "not-allowed");
            $('#deleteHires').css("pointer-events", "none");
        }
    });
    $('.exitCheck').on('click', function () {
        if ($("#loadExitData input:checkbox:checked").length > 0) {
            $('#disableExit').css("cursor", "pointer");
            $('#deleteExit').css("pointer-events", "");
        } else {
            $('#disableExit').css("cursor", "not-allowed");
            $('#deleteExit').css("pointer-events", "none");
        }
    });
    $('.surveyCheck').on('click', function () {
        if ($("#loadSurveyData input:checkbox:checked").length > 0) {
            $('#disableSurvey').css("cursor", "pointer");
            $('#deleteSurvey').css("pointer-events", "");
        } else {
            $('#disableSurvey').css("cursor", "not-allowed");
            $('#deleteSurvey').css("pointer-events", "none");
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
                    column: 'document',
                    table: 'plan_team'
                },
                dataType: 'json',
                success: function (msg) {
                    $('#loadSurveyData').load(location.href + ' #loadSurveyData');
                    $('#deleteDocModal').modal('hide');
                    $('#deleteMsg').show();
                    setTimeout(function () {
                        onLoad();
                        deleteMore('check_survey', 'disableSurvey', 'deleteSurvey');
                    }, 500);
                    setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000);
                }
            });
        }
    });

    $(document).on('click', '.hireCheck', function () {
        if ($("input:checkbox[name=check_hire]:checked").length > 0) {
            $('#disableHires').css("cursor", "pointer");
            $('#deleteHires').css("pointer-events", "");
        } else {
            $('#disableHires').css("cursor", "not-allowed");
            $('#deleteHires').css("pointer-events", "none");
        }
    });

    $(document).on('click', '.exitCheck', function () {
        if ($("input:checkbox[name=check_exit]:checked").length > 0) {
            $('#disableExit').css("cursor", "pointer");
            $('#deleteExit').css("pointer-events", "");
        } else {
            $('#disableExit').css("cursor", "not-allowed");
            $('#deleteExit').css("pointer-events", "none");
        }
    });

    $(document).on('click', '.surveyCheck', function () {
        if ($("input:checkbox[name=check_survey]:checked").length > 0) {
            $('#disableSurvey').css("cursor", "pointer");
            $('#deleteSurvey').css("pointer-events", "");
        } else {
            $('#disableSurvey').css("cursor", "not-allowed");
            $('#deleteSurvey').css("pointer-events", "none");
        }
    });

    function deleteMore(field_name, list_id, btn_id) {
        if ($('input:checkbox[name=' + field_name + ']:checked').length > 0) {
            $('#' + list_id).css("cursor", "pointer");
            $('#' + btn_id).css("pointer-events", "");
        } else {
            $('#' + list_id).css("cursor", "not-allowed");
            $('#' + btn_id).css("pointer-events", "none");
        }
    }

</script>
</body>

</html>


<!--function uploadFile() {
            $(".uploadlogo").on('change', function () {
                var filename = readURL(this);
                var result = filename.split('|*|');
                $(this).parent().children('span').html(result[0]);
                if (result[1] != '1') {
                    $(this).parent().parent().children('.sow_msg').show();
                    $(this).parent().parent().children('.sow_msg').text(result[1]);
                } else {
                    $(this).parent().parent().children('.sow_msg').text('');
                    $(this).parent().parent().children('.sow_msg').hide();
                }
            });
        }-->
