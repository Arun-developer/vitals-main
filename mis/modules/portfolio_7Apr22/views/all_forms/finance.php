<?php
$company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
$quater_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_quarter = $this->Mportfolio->monthByQuarters();
$get_quarter_fieldName = array("Q1" => 'q_one_desc', "Q2" => 'q_two_desc', "Q3" => 'q_three_desc', "Q4" => 'q_four_desc');
$get_quarter_monthField = array("1" => 'jan_desc', "2" => 'feb_desc', "3" => 'mar_desc', "4" => 'apr_desc', "5" => 'may_desc', "6" => 'jun_desc', "7" => 'jul_desc', "8" => 'aug_desc', "9" => 'sep_desc', "10" => 'oct_desc', "11" => 'nov_desc', "12" => 'dec_desc');

$plan = $finance_plan[0];
$last_month = date("F", mktime(0, 0, 0, $current_month, 1));

$current_ytdVal = isset($current_ytd) && $current_ytd != '' ? $current_ytd : 0;
$total_ytdVal = isset($ytd_value) && $ytd_value != 0 ? $ytd_value : 0;

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

                            <a class="nav-item nav-link  " id="nav-Companymaster-tab"    href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>"  aria-controls="nav-Companymaster" aria-selected="true" style="margin-right: 15px;position: relative;">Updates</a>
                        </div>
                        <div class="new-nav-changes1"><div class="new-changes-head1"> Portfolio Information</div>
                            <a class="nav-item nav-link" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/product/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="false">Product &amp; Sales</a>
                            <a class="nav-item nav-link active" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/finance/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">03</a>
                            <a class="nav-item nav-link" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/hiring/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Team &amp; Board Meetings</a>
                            <a class="nav-item nav-link" id="nav-governance-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/impact/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-governance" aria-selected="false">Impact</a>
                            <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/milestone/' . $innovation_id . '/' . $current_financial; ?>" aria-controls="nav-cap" aria-selected="false">Milestone Tracker</a>
                        </div>
                        <div class="new-nav-changes2"><div class="new-changes-head2"> Incubator Services/Interventions</div>
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
                                    <h4>Finance &amp; Follow-on Fundraise</h4>
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
                                <?php $this->load->view('all_forms/left_menu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'finance', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
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
                                        <h4>Finances > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
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
                                            <li class="tab-slider--triggerform active"><a href="javascript:void(0)">Finances</a></li>
                                            <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/loans/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Loans & Working Capital</a></li>
                                            <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/fundraise/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Fundraise</a></li>
                                            <?php if ($this->session->userdata['currency'] == 'INR') { ?>
                                                <p class="currencyNotify"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
                                            <?php } else { ?>
                                                <p class="currencyNotify"><span class="text-danger">*</span> All <?= $this->session->userdata['currency']; ?> amounts are in '000's.</p>
                                            <?php } ?>
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
                                                <form method="post" id="financePlanForm" action="<?php echo base_url() . 'index.php/portfolio/all_forms/addFinancePlan'; ?>" autocomplete="off">
                                                    <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                    <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                    <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                    <div class="row achievementNewComt">
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <div class="quaterlyNewplanstru">
                                                                <h4>Revenue Plan</h4>
                                                            </div>
                                                            <p>Plan for <?= $current_quarter; ?></p>
                                                            <div class="form-group quaterlyCardnew fieldDisabled">
                                                                <textarea rows="3" disabled class="mceEditor" id="quarterDesc" name="quarterDesc"><?= stripslashes(str_replace("\\r\\n", '', $rev_qualitative_plan[0][$total_qualPlan])); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <div class="quaterlyNewplanstru">
                                                                <h4>&nbsp;</h4>
                                                            </div>
                                                            <p>Plan for <?= $last_month; ?></p>
                                                            <div class="form-group quaterlyCardnew fieldDisabled">
                                                                <textarea rows="3" class="mceEditor" id="monthContent" name='monthContent'><?= stripslashes(str_replace("\\r\\n", '', $rev_qualitative_plan[0][$monthly_qualPlan])); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <div class="quaterlyNewplanstru">
                                                                <h4>Achievements</h4>
                                                            </div>
                                                            <p>Enter achievement for <?= $last_month; ?></p>
                                                            <div class="form-group quaterlyCardnew" id="achieveField">
                                                                <textarea rows="3" class="mceEditorActive" id="achieveContent" name='rev_achieveContent' autofocus><?= stripslashes(str_replace("\\r\\n", '', $plan['revenue_achievement'])); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row achievementNewComt">
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <div class="quaterlyNewplanstru">
                                                                <h4>Profit Plan</h4>
                                                            </div>
                                                            <p>Plan for <?= $current_quarter; ?></p>
                                                            <div class="form-group quaterlyCardnew fieldDisabled">
                                                                <textarea rows="3" disabled class="mceEditor" id="quarterDesc" name="quarterDesc"><?= stripslashes(str_replace("\\r\\n", '', $prof_qualitative_plan[0][$total_qualPlan])); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <div class="quaterlyNewplanstru">
                                                                <h4>&nbsp;</h4>
                                                            </div>
                                                            <p>Plan for <?= $last_month; ?></p>
                                                            <div class="form-group quaterlyCardnew fieldDisabled">
                                                                <textarea rows="3" class="mceEditor" id="monthContent" name='monthContent'><?= stripslashes(str_replace("\\r\\n", '', $prof_qualitative_plan[0][$monthly_qualPlan])); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <div class="quaterlyNewplanstru">
                                                                <h4>Achievements</h4>
                                                            </div>
                                                            <p>Enter achievement for <?= $last_month; ?></p>
                                                            <div class="form-group quaterlyCardnew" id="prof_achieveField">
                                                                <textarea rows="3" class="mceEditorActive" name='prof_achieveContent' autofocus><?= stripslashes(str_replace("\\r\\n", '', $plan['profit_achievement'])); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="120"><label>Revenue</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" id="txtRevenue" type="text" name="txtRevenue" value="<?= $plan['revenue']; ?>" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="120"><label>COGS</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" id="txtCOGS" type="text" name="txtCOGS" value="<?= $plan['cogs']; ?>" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="120"><label>Gross Profit</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm readOnly" readonly="" id="txtProfit" type="text" name="txtProfit" value="<?= $plan['gross_profit']; ?>">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="120"><label>Gross Margin</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm readOnly" readonly="" id="txtMargin" type="text" name="txtMargin" value="<?= $plan['gross_margin']; ?>">
                                                                                    </div>
                                                                                </li>
                                                                                <li>%</li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="120"><label>Sales &amp; distribution <br> expenses</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" id="txtSales" type="text" name="txtSales" value="<?= $plan['sales_expenses']; ?>" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>Market expenses</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" id="txtMarket" type="text" name="txtMarket" value="<?= $plan['market_expenses']; ?>" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>R&amp;D</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" id="txtRD" type="text" name="txtRD" value="<?= $plan['rd_expenses']; ?>" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>Salaries</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" id="txtSalaries" type="text" name="txtSalaries" value="<?= $plan['salaries']; ?>" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>Overheads</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" id="txtOverheads" type="text" name="txtOverheads" value="<?= $plan['over_heads']; ?>" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>Other OPTG exp</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" id="txtOPTG" type="text" name="txtOPTG" value="<?= $plan['other_optg']; ?>" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="120"><label>Total Expenditure</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm readOnly" readonly="" id="txtExpenditure" type="text" name="txtExpenditure" value="<?= $plan['total_expenses']; ?>">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>Net Profit</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm readOnly" readonly="" id="txtnetProfit" type="text" name="txtnetProfit" value="<?= $plan['net_profit']; ?>">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>Net Profit YTD</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm readOnly ytdField" readonly="" id="txtYTD" type="text" name="txtYTD" value="<?php echo $current_ytdVal; ?>">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
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

<input type="hidden" id="enableCount" value="<?= count($finance_plan); ?>">
<input type="hidden" id="current_ytd" value="<?= $total_ytdVal; ?>">

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio', 'quantitative' => 'tiny')); ?>

<script type="text/javascript">
    $(window).on("load", function () {
        ($("iframe").contents().click(function (event) {
            $('.quaterlyCardnew').removeClass('greenplantxt');
            if (event.target.localName == 'html') {
                var div_id = event.target.childNodes[1].attributes["0"].ownerElement.dataset.id;
            } else if (event.target.localName == 'body') {
                var div_id = event.target.dataset.id;
            } else {
                var div_id = event.target.offsetParent.attributes["0"].ownerElement.dataset.id;
            }

            if (div_id == 'prof_achieveContent') {
                $("#prof_achieveField").addClass("greenplantxt");
            } else if (div_id == 'achieveContent') {
                $("#achieveField").addClass("greenplantxt");
            }
        }));
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
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('input[type="text"]').attr('readonly', 'readonly');
            tinymce.get('achieveContent').setMode('readonly');
            tinymce.get('prof_achieveContent').setMode('readonly');
            $('#achieveField').addClass('fieldDisabled');
            $('#prof_achieveField').addClass('fieldDisabled');
        } else {
            $('#achieveField').addClass('greenplantxt');
        }

        $('#editBtn').addClass('opacity5');
        var ytd = $('.ytdField');
        ytd.val(inrFormat(ytd.val()));

        var goal = $('.annualGoal');
        goal.val(inrFormat(goal.val()));

        $('.currencyField').each(function (key, value) {
            var inc = key + 1;
            var currency = $('#currency_' + inc);
            if (currency.val != 0 || currency.val == '') {
                currency.val(inrFormat(currency.val()));
            } else {
                currency.val(0);
            }
        });
        getTotalYTD();
    });

    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/all_forms/finance/' + inv_id + '/' + year;
    }

    $(document).on('click', '#editBtn', function () {
        $('input[type="text"]').attr('readonly', false);
        $('.readOnly').attr('readonly', true);
        $('#editBtn').removeClass('opacity5');
        tinymce.get('achieveContent').setMode('design');
        tinymce.get('prof_achieveContent').setMode('design');
        $('#achieveField').addClass('greenplantxt');
        $('#achieveField').removeClass('fieldDisabled');
        $('#prof_achieveField').removeClass('greenplantxt fieldDisabled');
    });

    $(document).on('keyup', '#txtRevenue, #txtCOGS, #txtSales, #txtMarket, #txtRD, #txtOPTG, #txtSalaries, #txtOverheads', function () {
        getTotalYTD();
    });

    function getTotalYTD() {
        var revenue = $('#txtRevenue').val();
        var cogs = $('#txtCOGS').val();

        var revVal = Number(revenue.replace(/[^0-9.-]+/g, ""));
        var cogsVal = Number(cogs.replace(/[^0-9.-]+/g, ""));
        var profit = revVal - cogsVal;
        var profit_number = Number(profit).toFixed(2);
        if (!isNaN(profit_number))
            $('#txtProfit').val(inrFormat(profit_number));

        var sales = $('#txtSales').val();
        var market = $('#txtMarket').val();
        var rd = $('#txtRD').val();
        var salaries = $('#txtSalaries').val();
        var overheads = $('#txtOverheads').val();
        var optg = $('#txtOPTG').val();
        var g_profit = $('#txtProfit').val();

        var profitVal = Number(g_profit.replace(/[^0-9.-]+/g, ""));
        var margin = (profitVal / revVal) * 100;
        var margin_val = Number(margin).toFixed(2);
        if (margin_val > 0)
            $('#txtMargin').val(margin_val);
        else
            $('#txtMargin').val(0);

        var salesVal = Number(sales.replace(/[^0-9.-]+/g, ""));
        var marketVal = Number(market.replace(/[^0-9.-]+/g, ""));
        var rdVal = Number(rd.replace(/[^0-9.-]+/g, ""));
        var salaryVal = Number(salaries.replace(/[^0-9.-]+/g, ""));
        var headVal = Number(overheads.replace(/[^0-9.-]+/g, ""));
        var optgVal = Number(optg.replace(/[^0-9.-]+/g, ""));
        var expenditure = salesVal + marketVal + rdVal + salaryVal + headVal + optgVal;
        var netProfit = profitVal - expenditure;

        var new_expVal = Number(expenditure).toFixed(2);
        var new_netVal = Number(netProfit).toFixed(2);

        if (!isNaN(new_expVal))
            $('#txtExpenditure').val(inrFormat(new_expVal));
        if (!isNaN(new_netVal))
            $('#txtnetProfit').val(inrFormat(new_netVal));

        var current = $('#current_ytd').val();
        var new_ytd = parseFloat(current) + parseFloat(netProfit);
        var new_ytdVal = Number(new_ytd).toFixed(2);
        if (!isNaN(new_ytdVal))
            $('.ytdField').val(inrFormat(new_ytdVal));
    }

    $(".numberField").on("input", function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9]/g, ''));
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

    $(document).on('click', ".saveContinue", function (e) {
        if ($('#financePlanForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#financePlanForm').submit();
        }
    });
    $('.plan-structure-new').css({'height': (($(window).height()) - 380) + 'px'});
</script>

</body>
</html>
