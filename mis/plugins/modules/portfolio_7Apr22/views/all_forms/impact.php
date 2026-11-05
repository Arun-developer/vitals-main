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
                            <a class="nav-item nav-link active" id="nav-governance-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/impact/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-governance" aria-selected="false">05</a>
                            <a class="nav-item nav-link " id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/milestone/' . $innovation_id . '/' . $current_financial; ?>" aria-controls="nav-cap" aria-selected="false">Milestone Tracker</a>
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
                                    <h4>Impact</h4>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                                    <ul class="milestone-links">
                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                            <li><a class="saveContinue">Save &amp; Continue</a></li>
                                        <?php } ?>
                                        <li>
                                            <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend" style="font-size: 15px !important;text-decoration: underline;"><i class="far fa-question-circle"></i>&nbsp;M&E SOP - Click here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php
                        $current_quarter = $actual_quarter[$current_month];
                        $total_qualPlan = $get_quarter_fieldName[$current_quarter];
                        $monthly_qualPlan = $get_quarter_monthField[$current_month];
                        ?>
                        <div class="tabpanel-details pad-none config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('all_forms/left_menu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'impact', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
                            </div>
                            <main class="page-content">
                                <form method="post" id="impact_form" action="<?php echo base_url() . 'index.php/portfolio/all_forms/addImpactPlan'; ?>" autocomplete="off">
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
                                            <h4>Impact > <span> <?= $last_month . ' ' . $next_financial; ?></span></h4>
                                        </div>
                                    </div>
                                    <div class="inputplan-structure plan-structure-new">
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
                                                    <textarea rows="3" class="mceEditorActive" id="achieveContent" name='achieveContent' autofocus><?= stripslashes(str_replace("\\r\\n", '', $impact_plan[0]['achievement_desc'])); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                <div class="table_configcontentinput impact_form">
                                                    <div class="tabpanel-title">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-12">
                                                                <h6>Impact</h6>
                                                            </div>
                                                            <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-12 text-right" id='editImpactSec'>
                                                                    <a href="javascript:void(0)" class="pad-rt15px" id="editImpact"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-10 col-12 vil-Deals portfolio-table">
                                                            <table class="table" style="margin-top:0">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="25%">Impact</th>
                                                                        <th width="15%"class="text-center">Male</th>
                                                                        <th width="15%"class="text-center">Female</th>
                                                                        <th width="15%"class="text-center">Other</th>
                                                                        <th width="15%"class="text-center">Unknown</th>
                                                                        <th width="15%"class="text-center">Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <?php
                                                                $eMale_iris = isset($end_male_iris['name']) && $end_male_iris['name'] != '' ? $end_male_iris['name'] : '';
                                                                $eFemale_iris = isset($end_female_iris['name']) && $end_female_iris['name'] != '' ? $end_female_iris['name'] : '';
                                                                $eOther_iris = isset($end_other_iris['name']) && $end_other_iris['name'] != '' ? $end_other_iris['name'] : '';
                                                                $eUnknown_iris = isset($end_unknown_iris['name']) && $end_unknown_iris['name'] != '' ? $end_unknown_iris['name'] : '';

                                                                $dMale_iris = isset($direct_male_iris['name']) && $direct_male_iris['name'] != '' ? $direct_male_iris['name'] : '';
                                                                $dFemale_iris = isset($direct_female_iris['name']) && $direct_female_iris['name'] != '' ? $direct_female_iris['name'] : '';
                                                                $dOther_iris = isset($direct_other_iris['name']) && $direct_other_iris['name'] != '' ? $direct_other_iris['name'] : '';
                                                                $dUnknown_iris = isset($direct_unknown_iris['name']) && $direct_unknown_iris['name'] != '' ? $direct_unknown_iris['name'] : '';

                                                                $iMale_iris = isset($indirect_male_iris['name']) && $indirect_male_iris['name'] != '' ? $indirect_male_iris['name'] : '';
                                                                $iFemale_iris = isset($indirect_female_iris['name']) && $indirect_female_iris['name'] != '' ? $indirect_female_iris['name'] : '';
                                                                $iOther_iris = isset($indirect_other_iris['name']) && $indirect_other_iris['name'] != '' ? $indirect_other_iris['name'] : '';
                                                                $iUnknown_iris = isset($indirect_unknown_iris['name']) && $indirect_unknown_iris['name'] != '' ? $indirect_unknown_iris['name'] : '';
                                                                ?>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="vill-gray">No. of end beneficiaries</td>
                                                                        <td>
                                                                            <input type="text" name="end_male" id="end_male" value="<?= $impact_plan[0]['end_male']; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                            <p class="iris_code addedExit pad-none">
                                                                                <?php if ($eMale_iris != '') { ?>
                                                                                    <span>IRIS - <?php echo strlen($eMale_iris) > 15 ? "..." . substr($eMale_iris, -15) : $eMale_iris; ?></span>
                                                                                <?php } ?>
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="end_female" id="end_female" value="<?= $impact_plan[0]['end_female']; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                            <p class="iris_code addedExit pad-none">
                                                                                <?php if ($eFemale_iris != '') { ?>
                                                                                    <span>IRIS - <?php echo strlen($eFemale_iris) > 15 ? "..." . substr($eFemale_iris, -15) : $eFemale_iris; ?></span>
                                                                                <?php } ?>
                                                                            </p>
                                                                        </td>
                                                                        <td >
                                                                            <input type="text" name="end_other" id="end_other" value="<?= $impact_plan[0]['end_other']; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                            <p class="iris_code addedExit pad-none">
                                                                                <?php if ($eOther_iris != '') { ?>
                                                                                    <span>IRIS - <?php echo strlen($eOther_iris) > 15 ? "..." . substr($eOther_iris, -15) : $eOther_iris; ?></span>
                                                                                <?php } ?>
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="end_unknown" id="end_unknown" value="<?= $impact_plan[0]['end_unknown']; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                            <p class="iris_code addedExit pad-none">
                                                                                <?php if ($eUnknown_iris != '') { ?>
                                                                                    <span>IRIS - <?php echo strlen($eUnknown_iris) > 15 ? "..." . substr($eUnknown_iris, -15) : $eUnknown_iris; ?></span>
                                                                                <?php } ?>
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="end_tot" id="end_tot" class="form-control form-control-sm volumefld readonly" readonly="" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="vill-gray">No. of direct jobs created</td>
                                                                        <td>
                                                                            <input type="text" name="direct_male" id="direct_male" value="<?= $impact_plan[0]['direct_male']; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                            <p class="iris_code addedExit pad-none">
                                                                                <?php if ($dMale_iris != '') { ?>
                                                                                    <span>IRIS - <?php echo strlen($dMale_iris) > 15 ? "..." . substr($dMale_iris, -15) : $dMale_iris; ?></span>
                                                                                <?php } ?>
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="direct_female" id="direct_female" value="<?= $impact_plan[0]['direct_female']; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                            <p class="iris_code addedExit pad-none">
                                                                                <?php if ($dFemale_iris != '') { ?>
                                                                                    <span>IRIS - <?php echo strlen($dFemale_iris) > 15 ? "..." . substr($dFemale_iris, -15) : $dFemale_iris; ?></span>
                                                                                <?php } ?>
                                                                            </p>
                                                                        </td>
                                                                        <td >
                                                                            <input type="text" name="direct_other" id="direct_other" value="<?= $impact_plan[0]['direct_other']; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                            <p class="iris_code addedExit pad-none">
                                                                                <?php if ($dOther_iris != '') { ?>
                                                                                    <span>IRIS - <?php echo strlen($dOther_iris) > 15 ? "..." . substr($dOther_iris, -15) : $dOther_iris; ?></span>
                                                                                <?php } ?>
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="direct_unknown" id="direct_unknown" value="<?= $impact_plan[0]['direct_unknown']; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                            <p class="iris_code addedExit pad-none">
                                                                                <?php if ($dUnknown_iris != '') { ?>
                                                                                    <span>IRIS - <?php echo strlen($dUnknown_iris) > 15 ? "..." . substr($dUnknown_iris, -15) : $dUnknown_iris; ?></span>
                                                                                <?php } ?>
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="direct_tot" id="direct_tot" class="form-control form-control-sm volumefld readonly" readonly="" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="vill-gray">No. of indirect jobs created</td>
                                                                        <td>
                                                                            <input type="text" name="indirect_male" id="indirect_male" value="<?= $impact_plan[0]['indirect_male']; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                            <p class="iris_code addedExit pad-none">
                                                                                <?php if ($iMale_iris != '') { ?>
                                                                                    <span>IRIS - <?php echo strlen($iMale_iris) > 15 ? "..." . substr($iMale_iris, -15) : $iMale_iris; ?></span>
                                                                                <?php } ?>
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="indirect_female" id="indirect_female" value="<?= $impact_plan[0]['indirect_female']; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                            <p class="iris_code addedExit pad-none">
                                                                                <?php if ($iFemale_iris != '') { ?>
                                                                                    <span>IRIS - <?php echo strlen($iFemale_iris) > 15 ? "..." . substr($iFemale_iris, -15) : $iFemale_iris; ?></span>
                                                                                <?php } ?>
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="indirect_other" id="indirect_other" value="<?= $impact_plan[0]['indirect_other']; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                            <p class="iris_code addedExit pad-none">
                                                                                <?php if ($iOther_iris != '') { ?>
                                                                                    <span>IRIS - <?php echo strlen($iOther_iris) > 15 ? "..." . substr($iOther_iris, -15) : $iOther_iris; ?></span>
                                                                                <?php } ?>
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="indirect_unknown" id="indirect_unknown" value="<?= $impact_plan[0]['indirect_unknown']; ?>" class="form-control form-control-sm volumefld" maxlength="10" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                            <p class="iris_code addedExit pad-none">
                                                                                <?php if ($iUnknown_iris != '') { ?>
                                                                                    <span>IRIS - <?php echo strlen($iUnknown_iris) > 15 ? "..." . substr($iUnknown_iris, -15) : $iUnknown_iris; ?></span>
                                                                                <?php } ?>
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="indirect_tot" id="indirect_tot" class="form-control form-control-sm volumefld readonly" readonly="" placeholder="00">
                                                                            <label class="error error_msg"></label>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                <div class="table_configcontentinput metric_form">
                                                    <div class="tabpanel-title">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-12">
                                                                <h6>Incubatee Specific Metrics</h6>
                                                            </div>
                                                            <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-12 text-right" id='editMetricSec'>
                                                                    <a href="javascript:void(0)" class="pad-rt15px" id="editMetric"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-12 vil-Deals portfolio-table">
                                                            <!--<table class="input-fundtable">-->
                                                            <table class="table">
                                                                <tbody>
                                                                    <?php
                                                                    if (count($metric_plan) > 0) {
                                                                        $j = 1;
                                                                        foreach ($metric_plan as $metric) {
                                                                            $cond['plan_id'] = $metric['plan_id'];
                                                                            $cond['achievement_id'] = $impact_plan[0]['id'];
                                                                            $cond['inv_id'] = $metric['inv_id'];
                                                                            $cond['financial_year'] = $metric['financial_year'];
                                                                            $cond['month'] = $current_month;
                                                                            $get_metric_value = $this->Mportfolio->getVifInput('plan_impact_metric', $cond, '3');
                                                                            ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input type="text" class="form-control form-control-sm metricName" maxlength="200" name="metric_name[]" placeholder="Impact metric 1"  id="metricNam_<?php echo $j; ?>" readonly="" value="<?php echo $metric['metric_name']; ?>">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <ul class="milestone-linksec metric_achieve iris_line">
                                                                                        <li style="margin-left: 6px;">
                                                                                            <div class="form-group">
                                                                                                <input style="width: 84%;" class="form-control form-control-sm metric currencyField" maxlength="20" type="text" name="metric[]" placeholder="Value" id="metric_<?php echo $j; ?>" value="<?php echo $get_metric_value[0]['metric_value']; ?>">
                                                                                                <p class="iris_code addedExit pad-none">
                                                                                                    <?php if ($metric['name'] != '') { ?>
                                                                                                        <span>IRIS - <?php echo strlen($metric['name']) > 15 ? "..." . substr($metric['name'], -15) : $metric['name']; ?></span>
                                                                                                    <?php } ?>
                                                                                                </p>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </td>
                                                                            </tr>
                                                                        <input type="hidden" name="metric_plan_id[]" value="<?php echo $metric['plan_id']; ?>">
                                                                        <?php
                                                                        $j++;
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <tr align="center"><td>No data found</td></tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                    <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                    <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
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

<input type="hidden" id="enableCount" value="<?= count($impact_plan); ?>">
<input type="hidden" id="metEnableCount" value="<?= count($metric_count); ?>" />

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
        auto_focus: "achieveContent",
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
        end_total();
        direct_total();
        indirect_total();
    });

    $(document).on('keyup', '#end_male, #end_female, #end_other, #end_unknown', function () {
        end_total();
    });

    function end_total() {
        var male = $('#end_male').val() || 0;
        var female = $('#end_female').val() || 0;
        var other = $('#end_other').val() || 0;
        var unknown = $('#end_unknown').val() || 0;

        var total = parseInt(male) + parseInt(female) + parseInt(other) + parseInt(unknown);
        $('#end_tot').val(total);
    }

    $(document).on('keyup', '#direct_male, #direct_female, #direct_other, #direct_unknown', function () {
        direct_total();
    });

    function direct_total() {
        var male = $('#direct_male').val() || 0;
        var female = $('#direct_female').val() || 0;
        var other = $('#direct_other').val() || 0;
        var unknown = $('#direct_unknown').val() || 0;

        var total = parseInt(male) + parseInt(female) + parseInt(other) + parseInt(unknown);
        $('#direct_tot').val(total);
    }

    $(document).on('keyup', '#indirect_male, #indirect_female, #indirect_other, #indirect_unknown', function () {
        indirect_total();
    });

    function indirect_total() {
        var male = $('#indirect_male').val() || 0;
        var female = $('#indirect_female').val() || 0;
        var other = $('#indirect_other').val() || 0;
        var unknown = $('#indirect_unknown').val() || 0;

        var total = parseInt(male) + parseInt(female) + parseInt(other) + parseInt(unknown);
        $('#indirect_tot').val(total);
    }

    $(document).on('keyup', '.impact', function () {
        var imid = this.id;
        var splt = imid.split("_");
        if (this.value != '') {
            $('#value_' + splt[1]).attr('required', 'required');
        }
    });

    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/all_forms/impact/' + inv_id + '/' + year;
    }

    function onLoad() {
        var impEditOpt = $('#enableCount').val();
        if (impEditOpt > 0) {
            $('.impact_form input[type="text"]').attr('readonly', 'readonly');
        }
        var metEditOpt = $('#metEnableCount').val();
        if (metEditOpt > 0) {
            $('.metric_achieve input[type="text"]').attr('readonly', 'readonly');
        }
        $('#total_impacted').attr('readonly', 'readonly');
        $('#editImpact').addClass('opacity5');
        $('#editMetric').addClass('opacity5');
    }

    $(document).on('click', '#editImpact', function () {
        $('#updatePlan').val('1');
        $('.impact_form :input').attr('readonly', false);
        $('#editImpact').removeClass('opacity5');
        $('#total_impacted').attr('readonly', 'readonly');
        $('.readonly').attr('readonly', 'readonly');
    });
    $(document).on('click', '#editMetric', function () {
        $('#updatePlan').val('1');
        $('.metric_achieve :input').attr('readonly', false);
        $('#editMetric').removeClass('opacity5');
    });

    $(".volumefld").on("input", function (evt) {
        var self = $(this);
        if (self.val() != 0 || self.val() == '') {
            self.val(self.val().replace(/[^0-9]/g, ''));
            self.val(self.val());
//                    self.val(inrFormat(self.val()));
        } else {
            self.val(0);
        }
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
            evt.preventDefault();
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
            self.val(self.val());
//                    self.val(inrFormat(self.val()));

            var patt = new RegExp(/[0-9\,]*[.]{1}[0-9]{2}/i);
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
        self.val(self.val());
//                self.val(inrFormat(self.val()));
        var patt = new RegExp(/[0-9\,]*[.]{1}[0-9]{2}/i);
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

    $(document).on('keyup', '#end_beneficiaries, #created_jobs', function () {
        var ben = $('#end_beneficiaries').val();
        var job = $('#created_jobs').val();
        var benVal = Number(ben.replace(/[^0-9.-]+/g, ""));
        var jobVal = Number(job.replace(/[^0-9.-]+/g, ""));
        var value = benVal + jobVal;
        $('#total_impacted').val(inrFormat(value));
    });

    $(document).on('click', '.saveContinue', function (e) {
        if ($('#impact_form').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#impact_form').submit();
        }
    });
    $('.plan-structure-new').css({'height': (($(window).height()) - 380) + 'px'});
</script>

<style>
    .iris_code{
        margin-top: 3px;
        margin-bottom: 0;
        font-size: 12px;
        line-height:1.2;
    }
    .iris_line{
        font-size: 0;
        line-height: 1;
    }
</style>
</body>

</html>
