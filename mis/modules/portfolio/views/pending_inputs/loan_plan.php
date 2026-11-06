<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Villgro MIS</title>
    </head>

    <body>
        <?php
        $l_plan = $loan_plan[0];
        $f_plan = $finance_plan[0];
        $last_month = date("F", mktime(0, 0, 0, $current_month, 1));

        $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
        $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';

        $company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
        $reg_city = isset($plan_header) ? $plan_header['company_data'][0]['reg_city'] : '';
        $sector_name = isset($plan_header) ? $plan_header['sector_name'] : '';
        $this->load->view('pending_inputs/header.php', array('page_title' => 'Loan Plan', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name));
        ?>

        <!-- Inner Dashboard-->
        <div class="vi-dashboard onboardtabmenu mar-tp150">
            <?php if ($successMsg != '') { ?>
                <div class="msg success text-center"><strong class="text-success"><i class="fas fa-check"></i></strong>&nbsp;<?= $successMsg; ?></div>
                <?php
            }
            if ($errorMsg != '') {
                ?>
                <div class="msg error text-center"><strong><i class="fas fa-times"></i></strong>&nbsp;<?= $errorMsg; ?></div>
            <?php } ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/plan_updates/' . $innovation_id . '/' . $current_month; ?>" role="tab" aria-controls="nav-Companymaster" aria-selected="true">Updates</a>
                                <a class="nav-item nav-link filled-data" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/sales_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="false">Sales &amp; Pipeline</a>
                                <a class="nav-item nav-link active" id="nav-management-tab" href="javascript:void(0)" aria-controls="nav-management" aria-selected="false">03</a>
                                <a class="nav-item nav-link " id="nav-governance-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/impact_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-governance" aria-selected="false">Impact</a>
                                <a class="nav-item nav-link" id="nav-relationship-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/hiring_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-relationship" aria-selected="false">Team, TAP &amp; Mentors</a>
                                <a class="nav-item nav-link" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/dp_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-incubation" aria-selected="true">Diagnostic Panels &amp; Board Meetings</a>
                                <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/notes_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-cap" aria-selected="false">Meetings &amp; Call Notes</a>
                                <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/milestone_plan/' . $innovation_id; ?>" aria-controls="nav-cap" aria-selected="false">Milestone Tracker</a>
                                <a class="nav-item nav-link brd-none bg-trasnparent" id="nav-about-tab"  href="#nav-about"  aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                                <a class="nav-item nav-link dataconfig_btn" id="nav-dataconfig-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id; ?>" role="tab" aria-controls="nav-dataconfig" aria-selected="false">View all forms</a>
                            </div>
                        </nav>
                        <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-Companymaster" role="tabpanel" aria-labelledby="nav-Companymaster-tab">
                                <div class="tabpanel-title">
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                            <h4>Finance &amp; Fundraise</h4>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                                            <ul class="milestone-links">
                                                <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || php72_cmp($this->session->userdata['sector_lead']) == 1) { ?>
                                                    <li><a class="saveContinue">Save &amp; Continue</a></li>
                                                <?php } ?>
                                                <li>
                                                    <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend"><i class="far fa-question-circle"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php if (php72_count($pending_month) > 0) { ?>
                                    <div>
                                        <div class="tab-slider--nav">
                                            <label class="float-left">Pending</label>
                                            <ul class="tab-slider--tabs">
                                                <?php
                                                for ($i = 0; $i < php72_count($pending_month); $i++) {
                                                    $activeMonth = date("M", mktime(0, 0, 0, $current_month, 1));
                                                    $monthNumber = date("n", strtotime($pending_month[$i]));
                                                    if ($pending_month[$i] == $activeMonth) {
                                                        $selected = 'active';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    ?>
                                                    <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/loan_plan/' . $innovation_id . '/' . $monthNumber; ?>">
                                                        <li class="tab-slider--trigger pending_month_btn <?= $selected; ?>"><?= date("F", strtotime($pending_month[$i])); ?></li>
                                                    </a>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="tabpanel-details pad-none config-wrapper dataconfig-content page-wrapper chiller-theme">
                                    <nav id="sidebar" data-topbar data-options="scrolltop:false" class="sidebar-wrapper top-bar">
                                        <div class="sidebar-content">
                                            <div class="sidebar-menu">
                                                <ul>
                                                    <li class="sidebar-dropdown no-arrow">
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/finance_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/sales.png'; ?>" >
                                                            <span>Finances</span>
                                                            <?php if (php72_cmp($pending_plans['plan_finance_exclam']) == 1) { ?>
                                                                <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                            <?php } ?>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-dropdown active no-arrow">
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/loan_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/fundraise.png'; ?>" >
                                                            <span>Loans &amp; Working Capital</span>
                                                            <?php if (php72_cmp($pending_plans['plan_loans_exclam']) == 1) { ?>
                                                                <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                            <?php } ?>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-dropdown no-arrow">
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/vif_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/tap.png'; ?>" >
                                                            <span>VIF Funding</span>
                                                            <?php if (php72_cmp($pending_plans['plan_vif_funding_exclam']) == 1) { ?>
                                                                <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                            <?php } ?>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-dropdown no-arrow">
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/fundraise_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/meeting.png'; ?>" >
                                                            <span>Fundraise</span>
                                                            <?php if (php72_cmp($pending_plans['plan_fundraise_exclam']) == 1) { ?>
                                                                <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                            <?php } ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </nav>
                                    <main class="page-content">
                                        <div class="row dataconfig">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <?php
                                                if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                                                    $next_financial = $current_financial + 1;
                                                } else {
                                                    $next_financial = $current_financial;
                                                }
                                                ?>
                                                <h4>Loans &amp; Working Capital > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
                                            </div>
                                            <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || php72_cmp($this->session->userdata['sector_lead']) == 1) { ?>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                    <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <hr class="cofig-spliter">
                                        <div class="inputplan-structure plan-structure-new">
                                            <?php if ($this->session->userdata['currency'] == 'INR') { ?>
                                                <p class="currencyNotify"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
                                            <?php } ?>
                                            <form method="post" id="loanPlanForm" action="<?php echo base_url() . 'index.php/portfolio/pending_inputs/addLoanPlan'; ?>" autocomplete="off">
                                                <input type='hidden' name='innovation_id' value="<?= $innovation_id; ?>">
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
                                                                                <div class="form-group">
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
                                                                                <div class="form-group">
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
                                                                                <div class="form-group">
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
                                                                                <div class="form-group">
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
                                                                        <div class="form-group" style="visibility: hidden;">
                                                                            <input class="form-control form-control-sm" type="text">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td>
                                                                        <div class="form-group" style="visibility: hidden;">
                                                                            <input class="form-control form-control-sm" type="text">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td>
                                                                        <div class="form-group" style="visibility: hidden;">
                                                                            <input class="form-control form-control-sm" type="text">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label>NP Less Interest</label></td>
                                                                    <td>
                                                                        <ul class="milestone-linksec">
                                                                            <li>
                                                                                <div class="form-group">
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
                                                                                <div class="form-group">
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
                                                                                <div class="form-group">
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
                                                                                <div class="form-group">
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
                                                                                <div class="form-group">
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
                                                                                <div class="form-group">
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
                                                                                <div class="form-group">
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
                                                                    <td width="83%">
                                                                        <ul class="milestone-linksec">
                                                                            <li>
                                                                                <div class="form-group">
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
                                                                    <td width="21%"><label>Value</label></td>
                                                                    <td width="89%">
                                                                        <ul class="milestone-linksec">
                                                                            <li>
                                                                                <div class="form-group">
                                                                                    <input class="form-control form-control-sm currencyField readOnly" readonly="" type="text" name="txtValue" id="txtValue" value="<?= $l_plan['total_value']; ?>">
                                                                                </div>
                                                                            </li>
                                                                            <li><?= $this->session->userdata['currency']; ?></li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="21%"><label>WC days</label></td>
                                                                    <td width="89%">
                                                                        <ul class="milestone-linksec">
                                                                            <li>
                                                                                <div class="form-group">
                                                                                    <input class="form-control form-control-sm currencyField readOnly" readonly="" type="text" name="wcDay" id="wcDay" value="<?= $l_plan['wc_days']; ?>">
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="21%"><label>Runway</label></td>
                                                                    <td width="89%">
                                                                        <ul class="milestone-linksec">
                                                                            <li>
                                                                                <div class="form-group">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="enableCount" value="<?= php72_count($loan_plan); ?>">

        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>

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

            $('.plan-structure-new').css({'height': (($(window).height()) - 240) + 'px'});

            $(function () {
                var $form = $('form');
                var initialState = $form.serialize();
                $(document).on('click', '.pending_month_btn', function (e) {
                    if (initialState === $form.serialize()) {
                        return(true);
                    } else {
                        if (confirm("Changes made in form are not saved. \nDo you want to continue without save?")) {
                            return(true);
                        } else {
                            return(false);
                        }
                    }
                });
            });

        </script>
    </body>
</html>