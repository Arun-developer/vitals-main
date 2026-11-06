<?php
$company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
$quater_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_quarter = $this->Mportfolio->monthByQuarters();

$l_plan = $loan_plan[0];
$f_plan = $finance_plan[0];
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

                            <a class="nav-item nav-link  " id="nav-Companymaster-tab"    href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>"  aria-controls="nav-Companymaster" aria-selected="true" style="margin-right: 15px;position: relative;">Updates</a>
                        </div>
                        <div class="new-nav-changes1"><div class="new-changes-head1"> Portfolio Information</div>
                            <a class="nav-item nav-link" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/product/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="false">Product &amp; Sales</a>
                            <a class="nav-item nav-link active" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/finance/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">03</a>
                            <a class="nav-item nav-link" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/hiring/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Team &amp; Board Meetings</a>
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
                                    <h4>Finance &amp; Follow-on Fundraise</h4>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                                    <ul class="milestone-links">
                                        <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
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
                                <?php $this->load->view('all_forms/left_menu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'loans', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
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
                                        <h4>Loans &amp; Working Capital > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
                                    </div>
                                    <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                            <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/finance/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Finances</a></li>
                                            <li class="tab-slider--triggerform active"><a href="javascript:void(0)">Loans & Working Capital</a></li>
                                            <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/fundraise/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Fundraise</a></li>
                                            <?php if ($this->session->userdata['currency'] == 'INR') { ?>
                                                <p class="currencyNotify"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
                                            <?php } else { ?>
                                                <p class="currencyNotify"><span class="text-danger">*</span> All <?= $this->session->userdata['currency']; ?> amounts are in '000's.</p>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <form method="post" id="loanPlanForm" action="<?php echo base_url() . 'index.php/portfolio/all_forms/addLoanPlan'; ?>" autocomplete="off">
                                                    <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                    <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                    <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><label>Long term</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" type="text" name="longTerm" id="longTerm" value="<?= $l_plan['long_term']; ?>" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>Short term</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" type="text" name="shortTerm" id="shortTerm" value="<?= $l_plan['short_term']; ?>" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>Interest paid on LT</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" type="text" name="longInterest" id="longInterest" value="<?= $l_plan['long_interest']; ?>" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>Interest paid on ST</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" type="text" name="shortInterest" id="shortInterest" value="<?= $l_plan['short_interest']; ?>" maxlength="20">
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
                                                                        <td>&nbsp;</td>
                                                                        <td>
                                                                            <div class="form-group wdt140" style="visibility: hidden;">
                                                                                <input class="form-control form-control-sm" type="text">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                        <td>
                                                                            <div class="form-group wdt140" style="visibility: hidden;">
                                                                                <input class="form-control form-control-sm" type="text">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                        <td>
                                                                            <div class="form-group wdt140" style="visibility: hidden;">
                                                                                <input class="form-control form-control-sm" type="text">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>NP Less Interest</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField readOnly" readonly="" type="text" name="lessInterest" id="lessInterest" value="<?= $l_plan['np_interest']; ?>">
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
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><label>Account payable</td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" type="text" name="accPayable" id="accPayable" value="<?= $l_plan['acc_payable']; ?>" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>Account receivable</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" type="text" name="accReceive" id="accReceive" value="<?= $l_plan['acc_receivable']; ?>" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>FG / Inventory</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" type="text" name="inventory" id="inventory" value="<?= $l_plan['inventory']; ?>" maxlength="20">
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
                                                                        <td><label>Payable days</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField readOnly" readonly="" type="text" name="dayPayable" id="dayPayable" value="<?= $l_plan['payable_days']; ?>">
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>Receivable days</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField readOnly" readonly="" type="text" name="dayReceive" id="dayReceive" value="<?= $l_plan['receivable_days']; ?>">
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label>Inventory days</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField readOnly" readonly="" type="text" name="dayInvent" id="dayInvent" value="<?= $l_plan['inventory_days']; ?>">
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h6>Working Capital</h6>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                            <table class="tableresponsive">
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="27%"><label>Cash in Bank</label></td>
                                                                        <td width="88%">
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField" type="text" name="bankCash" id="bankCash" value="<?= $l_plan['bank_cash']; ?>" maxlength="20">
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
                                                            <table class="tableresponsive">
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="22%"><label>Value</label></td>
                                                                        <td width="88%">
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField readOnly" readonly="" type="text" name="txtValue" id="txtValue" value="<?= $l_plan['total_value']; ?>">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="22%"><label>WC days</label></td>
                                                                        <td width="88%">
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField readOnly" readonly="" type="text" name="wcDay" id="wcDay" value="<?= $l_plan['wc_days']; ?>">
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="22%"><label>Runway</label></td>
                                                                        <td width="88%">
                                                                            <ul class="milestone-linksec">
                                                                                <li>
                                                                                    <div class="form-group wdt140">
                                                                                        <input class="form-control form-control-sm currencyField readOnly" readonly="" type="text" name="runWay" id="runWay" value="<?= $l_plan['runway']; ?>">
                                                                                    </div>
                                                                                </li>
                                                                                <li>Months</li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="totRevenue" value="<?= isset($f_plan['revenue']) && $f_plan['revenue'] != '' ? $f_plan['revenue'] : 0; ?>">
                                                    <input type="hidden" id="cogsValue" value="<?= isset($f_plan['cogs']) && $f_plan['cogs'] != '' ? $f_plan['cogs'] : 0; ?>">
                                                    <input type="hidden" id="netProfit" value="<?= isset($f_plan['net_profit']) && $f_plan['net_profit'] != '' ? $f_plan['net_profit'] : 0; ?>">
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

<input type="hidden" id="enableCount" value="<?= php72_count($loan_plan); ?>">

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio')); ?>

<script type="text/javascript">

    $(document).ready(function () {
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('input[type="text"]').attr('readonly', 'readonly');
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

        npintrest();
        receiveDays();
        inventDay();
        payableDay();
        runwayCash();
        loadWCval();
    });

    $(document).on('click', '#editBtn', function () {
        $('input[type="text"]').attr('readonly', false);
        $('.readOnly').attr('readonly', true);
        $('#editBtn').removeClass('opacity5');
    });

    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/all_forms/loans/' + inv_id + '/' + year;
    }

    $(document).on('keyup', '#longInterest, #shortInterest', function () {
        npintrest();
    });

    function npintrest() {
        var long = $('#longInterest').val();
        var short = $('#shortInterest').val();
        var profit = $('#netProfit').val();

        var longVal = Number(long.replace(/[^0-9.-]+/g, ""));
        var shortVal = Number(short.replace(/[^0-9.-]+/g, ""));
        var profitVal = Number(profit.replace(/[^0-9.-]+/g, ""));

        if (profitVal != '0') {
            var less = profitVal - (longVal + shortVal);
        } else {
            var less = '';
        }
        if (!isNaN(less)) {
            var less_cost = Number(less).toFixed(2);
            $('#lessInterest').val(inrFormat(less_cost));
        }
    }

    $(document).on('keyup', '#accPayable', function () {
        payableDay();
    });

    function payableDay() {
        var pay = $('#accPayable').val();
        var cogs = $('#cogsValue').val();
        var payVal = Number(pay.replace(/[^0-9.-]+/g, ""));
        var cogsVal = Number(cogs.replace(/[^0-9.-]+/g, ""));
        if (cogsVal != '0') {
            var days = (payVal / cogsVal) * 365;
            var num = Number(days).toFixed(0);
        } else {
            var days = '';
            var num = '';
        }
        if (!isNaN(num))
            $('#dayPayable').val(inrFormat(num));
    }

    $(document).on('keyup', '#accReceive', function () {
        receiveDays();
    });

    function receiveDays() {
        var pay = $('#accReceive').val();
        var revenue = $('#totRevenue').val();
        var payVal = Number(pay.replace(/[^0-9.-]+/g, ""));
        var revVal = Number(revenue.replace(/[^0-9.-]+/g, ""));
        if (revVal != '0') {
            var days = (payVal / revVal) * 365;
            var num = Number(days).toFixed(0);
        } else {
            var days = '';
            var num = '';
        }
        if (!isNaN(num))
            $('#dayReceive').val(inrFormat(num));
    }

    $(document).on('keyup', '#inventory', function () {
        inventDay();
    });

    function inventDay() {
        var invent = $('#inventory').val();
        var cogs = $('#cogsValue').val();
        var inventVal = Number(invent.replace(/[^0-9.-]+/g, ""));
        var cogsVal = Number(cogs.replace(/[^0-9.-]+/g, ""));

        if (cogsVal != '0') {
            var days = (inventVal / cogsVal) * 365;
            var num = Number(days).toFixed(0);
        } else {
            var days = '';
            var num = '';
        }
        if (!isNaN(num))
            $('#dayInvent').val(inrFormat(num));
    }

    $(document).on('keyup', '#accPayable, #accReceive, #inventory', function () {
        var pay = $('#accPayable').val();
        var receive = $('#accReceive').val();
        var invent = $('#inventory').val();
        var payVal = Number(pay.replace(/[^0-9.-]+/g, ""));
        var receiveVal = Number(receive.replace(/[^0-9.-]+/g, ""));
        var inventVal = Number(invent.replace(/[^0-9.-]+/g, ""));
        var value = (receiveVal + inventVal) - payVal;
        var wcVal = Number(value).toFixed(2);
        if (!isNaN(wcVal))
            $('#txtValue').val(inrFormat(wcVal));
    });

    $(document).on('keyup', '#accPayable, #accReceive, #inventory', function () {
        loadWCval();
    });

    function loadWCval() {
        var pay = $('#dayPayable').val();
        var receive = $('#dayReceive').val();
        var invent = $('#dayInvent').val();
        var payVal = Number(pay.replace(/[^0-9.-]+/g, ""));
        var receiveVal = Number(receive.replace(/[^0-9.-]+/g, ""));
        var inventVal = Number(invent.replace(/[^0-9.-]+/g, ""));
        var value = receiveVal + inventVal + payVal;
        var wcVal = Number(value).toFixed(2);
        if (!isNaN(wcVal))
            $('#wcDay').val(inrFormat(wcVal));
    }

    $(document).on('keyup', '#bankCash', function () {
        runwayCash();
    });

    function runwayCash() {
        var cash = $('#bankCash').val();
        var profit = $('#netProfit').val();

        var cashVal = Number(cash.replace(/[^0-9.-]+/g, ""));
        var profitVal = Number(profit.replace(/[^0-9.-]+/g, ""));

        if (profitVal != '0') {
            var runway = cashVal / profitVal;
            var num = Number(runway).toFixed(2);
        } else {
            var runway = '';
            var num = '';
        }
        if (!isNaN(num))
            $('#runWay').val(inrFormat(num));
    }

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
        var sum = x1 + x2;
        return sum;
    }

    $(document).on('click', ".saveContinue", function (e) {
        if ($('#loanPlanForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#loanPlanForm').submit();
        }
    });
    $('.plan-structure-new').css({'height': (($(window).height()) - 380) + 'px'});
</script>
</body>

</html>
