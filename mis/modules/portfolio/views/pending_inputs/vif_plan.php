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
        $last_month = date("F", mktime(0, 0, 0, $current_month, 1));

        $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
        $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';

        $plan_data = $vif_plan[0];
        $vif_count = isset($plan_data) ? php72_count($vif_plan) : 1;

        $company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
        $reg_city = isset($plan_header) ? $plan_header['company_data'][0]['reg_city'] : '';
        $sector_name = isset($plan_header) ? $plan_header['sector_name'] : '';
        $this->load->view('pending_inputs/header.php', array('page_title' => 'VIF Funding Plan', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name));
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
                                    <!--                                    <div>
                                                                            <div class="tab-slider--nav">
                                                                                <label class="float-left">Pending</label>
                                                                                <ul class="tab-slider--tabs">
                                    <?php
//                                                for ($i = 0; $i < count($pending_month); $i++) {
//                                                    $activeMonth = date("M", mktime(0, 0, 0, $current_month, 1));
//                                                    $monthNumber = date("n", strtotime($pending_month[$i]));
//                                                    if ($pending_month[$i] == $activeMonth) {
//                                                        $selected = 'active';
//                                                    } else {
//                                                        $selected = '';
//                                                    }
                                    ?>
                                                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/vif_plan/' . $innovation_id . '/' . $monthNumber; ?>">
                                                                                            <li class="tab-slider--trigger pending_month_btn <?= $selected; ?>"><?= date("F", strtotime($pending_month[$i])); ?></li>
                                                                                        </a>
                                    <?php // } ?>
                                                                                </ul>
                                                                            </div>
                                                                        </div>-->
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
                                                    <li class="sidebar-dropdown no-arrow">
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/loan_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/fundraise.png'; ?>" >
                                                            <span>Loans &amp; Working Capital</span>
                                                            <?php if (php72_cmp($pending_plans['plan_loans_exclam']) == 1) { ?>
                                                                <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                            <?php } ?>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-dropdown active no-arrow">
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
                                                <!--<h4>VIF Funding > <span><?= $last_month . ' ' . $current_financial; ?></span></h4>-->
                                                <h4>VIF Funding</h4>
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
                                            <form method="post" id="vifPlanForm" action="<?php echo base_url() . 'index.php/portfolio/pending_inputs/addVifPlan'; ?>" autocomplete="off">
                                                <input type='hidden' name='innovation_id' value="<?= $innovation_id; ?>">
                                                <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                <div class="input-viftable">
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12 vil-Deals portfolio-table">
                                                            <div class="table_configcontentnew">
                                                                <table class="mar-tp0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="4%">S.No</th>
                                                                            <th width="13%">Donor</th>
                                                                            <th width="18%">Milestone</th>
                                                                            <th width="12%">Month of Disbursement</th>
                                                                            <th width="12%">Committed</th>
                                                                            <th width="15%">Disbursed Amount</th>
                                                                            <th width="12%">Disbursed Date</th>
                                                                            <th width="14%">Comments</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        if (php72_count($vif_config) > 0) {
                                                                            for ($i = 0; $i < php72_count($vif_config); $i++) {
                                                                                $cond['port_vif_id'] = $vif_config[$i]['id'];
                                                                                $cond['inv_id'] = $vif_config[$i]['inv_id'];
                                                                                $cond['financial_year'] = $vif_config[$i]['financial_year'];
//                                                                                $cond['month'] = $current_month;
                                                                                $get_data = $this->Mportfolio->getVifInput('plan_vif_funding', $cond, '3');
                                                                                $month_disburse = (isset($vif_config[$i]['month_disburse']) && $vif_config[$i]['month_disburse'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($vif_config[$i]['month_disburse'])) : '';
                                                                                $disburse_date = (isset($get_data[0]['disburse_date']) && $get_data[0]['disburse_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($get_data[0]['disburse_date'])) : '';
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?php echo $i + 1; ?></td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <select class="form-control form-control-sm donor readOnly" readonly="" name="donor_name[]" id="donor_name_<?= $i; ?>">
                                                                                                <option value="">-Select-</option>
                                                                                                <?php foreach ($donor_list as $donor) { ?>
                                                                                                    <option value="<?= $donor['id']; ?>" <?php if (isset($vif_config[$i]['donor']) && $vif_config[$i]['donor'] == $donor['id']) { ?> selected <?php } ?>><?= $donor['name']; ?></option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <input class="form-control form-control-sm milestone readOnly" readonly="" type="text" name="txtMilestone[]" id="txtMilestone_<?= $i; ?>" value="<?= $vif_config[$i]['milestone']; ?>">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <input class="form-control form-control-sm month readOnly" readonly="" type="text" name="txtMonth[]" id="txtMonth_<?= $i; ?>" value="<?= date('d-m-Y', strtotime($vif_config[$i]['month'])); ?>">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <input class="form-control form-control-sm commit readOnly" readonly="" type="text" name="txtCommit[]" id="txtCommit_<?= $i; ?>" value="<?= $vif_config[$i]['amount']; ?>">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <input class="form-control form-control-sm disbursedAmt currencyField" readonly="" type="text" name="txtDisbursedAmt[]" id="txtDisbursedAmt_<?= $i; ?>" maxlength="20" value="<?= $get_data[0]['disburse_amount']; ?>">
                                                                                            <span class="amt_msg hidden_cls text-danger" id="amt_msg_<?php echo $i; ?>">Enter amount</span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <input class="form-control form-control-sm disDate dateCalendar" type="text" name="txtDate[]" id="txtDate_<?= $i; ?>" value="<?= $disburse_date; ?>" placeholder="dd-mm-yyyy">
                                                                                            <span class="date_msg hidden_cls text-danger" id="date_msg_<?php echo $i; ?>">Select date</span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <input class="form-control form-control-sm comment" type="text" name="txtComment[]" id="txtComment_<?= $i; ?>" value="<?= $get_data[0]['comments']; ?>">
                                                                                        </div>
                                                                                    </td>
                                                                            <input type="hidden" name="id[]" value="<?php echo $get_data[0]['id']; ?>" />
                                                                            <input type="hidden" name="port_vif_id[]" id="port_vif_id" value="<?php echo $vif_config[$i]['id']; ?>" />
                                                                            </tr>
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

        <input type="hidden" id="enableCount" value="<?= php72_count($vif_plan); ?>">


        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/additional-methods.js"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>

        <script type="text/javascript">

            function datepickerEachFunction() {
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

            $(document).ready(function () {
                var editOpt = $('#enableCount').val();
                if (editOpt > 0) {
                    $('input[type="text"]').attr('readonly', 'readonly');
                    $('.disDate').css('pointer-events', 'none');
                    $('input[type="radio"], .wdt_50 label').css('pointer-events', 'none');
                } else {
                    checkVest();
                    datepickerEachFunction();
                }
                $('.donor').css("pointer-events", "none");
                $('#editBtn').addClass('opacity5');
            });

            $(document).on('click', '#editBtn', function () {
                $('input[type="text"]').attr('readonly', false);
                $('input[type="radio"], .wdt_50 label, .disDate').css('pointer-events', 'visible');
                $('.readOnly').attr('readonly', true);
                $('#editBtn').removeClass('opacity5');
                checkVest();
                datepickerEachFunction();
            });

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

            $(document).on('click', ".saveContinue", function (e) {
                var s = 0;
                var d = 0;
                var err = 0;
                var html;
                $('.disDate').each(function (key) {
                    var inc = key + 1;
                    var disAmt = $('#txtDisbursedAmt_' + s).val();
                    var disDate = this.value;
                    if (disDate != '') {
                        if (disAmt == '') {
                            html = $('#amt_msg_' + s).show();
                            err = 1;
                            return false;
                        } else {
                            html = $('#amt_msg_' + s).hide();
                        }
                    }
                    s++;
                });

                $('.disbursedAmt').each(function (key) {
                    var inc = key + 1;
                    var disDate = $('#txtDate_' + d).val();
                    var disAmt = this.value;
                    if (disAmt != '') {

                        if (disDate == '') {
                            html = $('#date_msg_' + d).show();
                            err = 1;
                            return false;
                        } else {

                            html = $('#date_msg_' + d).hide();
                        }
                    }
                    s++;
                    d++;
                });

                if (err == 0) {
                    $('.saveContinue').css('pointer-events', 'none');
                    $('#vifPlanForm').submit();
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