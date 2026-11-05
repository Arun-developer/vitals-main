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
        $actual_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');

        $plan = $updates[0];

        $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
        $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';

        $company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
        $reg_city = isset($plan_header) ? $plan_header['company_data'][0]['reg_city'] : '';
        $sector_name = isset($plan_header) ? $plan_header['sector_name'] : '';

        $this->load->view('pending_inputs/header.php', array('page_title' => 'Update Plan', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name));
        ?>

        <!-- Inner Dashboard-->
        <div class="vi-dashboard onboardtabmenu">
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
                                <a class="nav-item nav-link active" id="nav-Companymaster-tab" data-toggle="tab" href="javascript:void(0)" role="tab" aria-controls="nav-Companymaster" aria-selected="true">01</a>
                                <a class="nav-item nav-link" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/sales_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="false">Sales &amp; Pipeline</a>
                                <a class="nav-item nav-link" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/finance_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Finance &amp; Fundraise</a>
                                <a class="nav-item nav-link" id="nav-governance-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/impact_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-governance" aria-selected="false">Impact</a>
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
                                            <h4>Updates</h4>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                                            <ul class="milestone-links">
                                                <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                    <li><a class="saveContinue">Save &amp; Continue</a></li>
                                                <?php } ?>
                                                <li>
                                                    <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend"><i class="far fa-question-circle"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php if (count($pending_month) > 0) { ?>
                                    <div>
                                        <div class="tab-slider--nav">
                                            <label class="float-left">Pending</label>
                                            <ul class="tab-slider--tabs">
                                                <?php
                                                for ($i = 0; $i < count($pending_month); $i++) {
                                                    $activeMonth = date("M", mktime(0, 0, 0, $current_month, 1));
                                                    $monthNumber = date("n", strtotime($pending_month[$i]));
                                                    if ($pending_month[$i] == $activeMonth) {
                                                        $selected = 'active';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    ?>
                                                    <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/plan_updates/' . $innovation_id . '/' . $monthNumber; ?>">
                                                        <li class="tab-slider--trigger pending_month_btn <?= $selected; ?>"><?= date("F", strtotime($pending_month[$i])); ?></li>
                                                    </a>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="tabpanel-details pad-none config-wrapper dataconfig-content page-wrapper">
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
                                                <h4>Updates > <span> <?= date("F", mktime(0, 0, 0, $current_month, 1)) . ' ' . $next_financial; ?></span></h4>
                                            </div>
                                            <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                    <a href="javascript:void(0)" class="edit-btnconfig" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <hr class="cofig-spliter">
                                        <div class="Plan-structure">
                                            <form id="updatesForm" method="POST" action="<?php echo base_url() . 'index.php/portfolio/pending_inputs/addUpdates'; ?>" autocomplete="off">
                                                <input type='hidden' name='innovation_id' value="<?= $innovation_id; ?>">
                                                <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="">
                                                            <div class="form-group">
                                                                <label>Incubatee Achievements</label>
                                                                <textarea class="form-control achieveDesc" name="achievement_desc" id="achievement_desc" rows="3" onKeyUp="limitText(this.form.achievement_desc, this.form.countdown_desc, 1000);"><?= $plan['achievements']; ?></textarea>
                                                                <span class="hidden_cls" style="margin:5px 0px 0px;">You have
                                                                    <input readonly="readonly" type="text" name="countdown_desc" id="countdown_desc" size="3" value="1000" style="width:45px;height: 20px;" />
                                                                    words left.</span>
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <div class="form-group">
                                                                <label>Incubatee Challenges</label>
                                                                <textarea class="form-control challengeDesc" name="challenge_desc" id="challenge_desc" rows="3" onKeyUp="limitText(this.form.challenge_desc, this.form.countdown_challengedesc, 1000);"><?= $plan['challenges']; ?></textarea>
                                                                <span class="hidden_cls" style="margin:5px 0px 0px;">You have
                                                                    <input readonly="readonly" type="text" name="countdown_challengedesc" id="countdown_challengedesc" size="3" value="1000" style="width:45px;height: 20px;" />
                                                                    words left.</span>
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <div class="form-group">
                                                                <label>Villgro relationship</label>
                                                                <textarea class="form-control villgroDesc" name="villgro_desc" id="villgro_desc" rows="3" onKeyUp="limitText(this.form.villgro_desc, this.form.countdown_villdesc, 1000);"><?= $plan['villgro_relationship']; ?></textarea>
                                                                <span class="hidden_cls" style="margin:5px 0px 0px;">You have
                                                                    <input readonly="readonly" type="text" name="countdown_villdesc" id="countdown_villdesc" size="3" value="1000" style="width:45px;height: 20px;" />
                                                                    words left.</span>
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <div class="form-group">
                                                                <label>Other comments</label>
                                                                <textarea class="form-control otherDesc" name="other_desc" id="other_desc" rows="3" onKeyUp="limitText(this.form.other_desc, this.form.countdown_otherdesc, 1000);"><?= $plan['other_comments']; ?></textarea>
                                                                <span class="hidden_cls" style="margin:5px 0px 0px;">You have
                                                                    <input readonly="readonly" type="text" name="countdown_otherdesc" id="countdown_otherdesc" size="3" value="1000" style="width:45px;height: 20px;" />
                                                                    words left.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <label>&nbsp;</label>
                                                        <div class="update_inputsec">
                                                            <div class="row">
                                                                <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                                    <div>
                                                                        <table class="tableresponsive">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th width="20%"></th>
                                                                                    <th width="40%">Actual (YTD)</th>
                                                                                    <th width="40%">Plan (Annual)</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Revenue</td>
                                                                                    <td>
                                                                                        <div class="form-group display-flex">
                                                                                            <input type="text" name="actual_revenue" id="actual_revenue" value="<?= $actual_revenue; ?>" readonly="" style="width:120px;" class="form-control form-control-sm currencyField" placeholder="0000">
                                                                                            <span style ="padding-left: 5px;"><?= $this->session->userdata['currency']; ?></span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group display-flex">
                                                                                            <input type="text" name="plan_revenue" id="plan_revenue" value="<?= $plan_revenue; ?>" readonly="" style="width:120px;" class="form-control form-control-sm currencyField" placeholder="0000">
                                                                                            <span style ="padding-left: 5px;"><?= $this->session->userdata['currency']; ?></span>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Profit</td>
                                                                                    <td>
                                                                                        <div class="form-group display-flex">
                                                                                            <input type="text" name="actual_profit" id="actual_profit" value="<?= $actual_profit; ?>" readonly="" style="width:120px;" class="form-control form-control-sm currencyField" placeholder="0000">
                                                                                            <span style ="padding-left: 5px;"><?= $this->session->userdata['currency']; ?></span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group display-flex">
                                                                                            <input type="text" name="plan_profit" id="plan_profit" value="<?= $plan_profit; ?>" readonly="" style="width:120px;" class="form-control form-control-sm currencyField" placeholder="0000">
                                                                                            <span style ="padding-left: 5px;"><?= $this->session->userdata['currency']; ?></span>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-12"></div>
                                                                <?php if ($this->session->userdata['currency'] == 'INR') { ?>
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                                        <p class="currencyNotify"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>

                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h6>Upcoming Milestones</h6>
                                                                    <ul class="update-milelist">
                                                                        <?php
                                                                        if (count($milestone) > 0) {
                                                                            foreach ($milestone as $mile) {
                                                                                ?>
                                                                                <li><?= $mile['name']; ?></li>
                                                                                <?php
                                                                            }
                                                                        } else {
                                                                            echo '- N/A-';
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                                    <div>
                                                                        <table class="tableresponsive">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th width="25%"></th>
                                                                                    <th width="75%">No. of Meetings<th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="boardmeeting">
                                                                                <tr>
                                                                                    <td>Diagnostic Panel</td>
                                                                                    <td class="display-flex">
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="dp_count" id="diagnostic" value="<?= $dp_meet_count; ?>" readonly="" class="form-control form-control-sm meetingField" maxlength="2" placeholder="00">
                                                                                            <p class="sow_msg hidden_cls error" id="dpErrorMsg">Count exceeds the maximum value 30</p>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Board Meetings</td>
                                                                                    <td class="display-flex">
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="bm_count" id="boardmeet" value="<?= $board_meet_count; ?>" readonly="" class="form-control form-control-sm meetingField" maxlength="2" placeholder="00">
                                                                                            <p class="sow_msg hidden_cls error" id="bmErrorMsg">Count exceeds the maximum value 30</p>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12"></div>
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

        <input type="hidden" id="enableCount" value="<?= count($updates); ?>">

        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>

        <script type="text/javascript">
                                                                    $(document).ready(function () {
                                                                        var editOpt = $('#enableCount').val();
                                                                        if (editOpt > 0) {
                                                                            $('textarea').attr('readonly', 'readonly');
                                                                        }
                                                                        $('#editBtn').addClass('opacity5');

                                                                        $("#achieveCount").html((95 - $(".achieveDesc").val().length) + " Characters left");
                                                                        $("#challengeCount").html((95 - $(".challengeDesc").val().length) + " Characters left");
                                                                        $("#villgroCount").html((95 - $(".villgroDesc").val().length) + " Characters left");
                                                                        $("#otherCount").html((95 - $(".otherDesc").val().length) + " Characters left");

                                                                        var plan_rev = $('#plan_revenue');
                                                                        var actual_rev = $('#actual_revenue');
                                                                        var plan_profit = $('#plan_profit');
                                                                        var actual_profit = $('#actual_profit');

                                                                        if (!isNaN(plan_rev.val())) {
                                                                            var rev_plan_cost = Number(plan_rev.val()).toFixed(2);
                                                                            plan_rev.val(inrFormat(rev_plan_cost));
                                                                        }
                                                                        if (!isNaN(actual_rev.val())) {
                                                                            var rev_actual_cost = Number(actual_rev.val()).toFixed(2);
                                                                            actual_rev.val(inrFormat(rev_actual_cost));
                                                                        }
                                                                        if (!isNaN(plan_profit.val())) {
                                                                            var pro_plan_cost = Number(plan_profit.val()).toFixed(2);
                                                                            plan_profit.val(inrFormat(pro_plan_cost));
                                                                        }
                                                                        if (!isNaN(actual_profit.val())) {
                                                                            var pro_actual_cost = Number(actual_profit.val()).toFixed(2);
                                                                            actual_profit.val(inrFormat(pro_actual_cost));
                                                                        }

//                                                                        plan_rev.val(inrFormat(plan_rev.val()));
//                                                                        actual_rev.val(inrFormat(actual_rev.val()));
//                                                                        plan_profit.val(inrFormat(plan_profit.val()));
//                                                                        actual_profit.val(inrFormat(actual_profit.val()));

                                                                        var selector1 = document.getElementById('achievement_desc');
                                                                        var counter1 = document.getElementById('countdown_desc');
                                                                        limitText(selector1, counter1, 1000);

                                                                        var selector2 = document.getElementById('challenge_desc');
                                                                        var counter2 = document.getElementById('countdown_challengedesc');
                                                                        limitText(selector2, counter2, 1000);

                                                                        var selector3 = document.getElementById('other_desc');
                                                                        var counter3 = document.getElementById('countdown_otherdesc');
                                                                        limitText(selector3, counter3, 1000);

                                                                        var selector5 = document.getElementById('villgro_desc');
                                                                        var counter5 = document.getElementById('countdown_villdesc');
                                                                        limitText(selector5, counter5, 1000);
                                                                    });

                                                                    $(document).on('click', '#editBtn', function () {
                                                                        $('textarea').attr('readonly', false);
                                                                        $('#editBtn').removeClass('opacity5');
                                                                    });

                                                                    $(".achieveDesc").keyup(function () {
                                                                        $("#achieveCount").html((95 - $(this).val().length) + " Characters left");
                                                                    });

                                                                    $(".challengeDesc").keyup(function () {
                                                                        $("#challengeCount").html((95 - $(this).val().length) + " Characters left");
                                                                    });

                                                                    $(".villgroDesc").keyup(function () {
                                                                        $("#villgroCount").html((95 - $(this).val().length) + " Characters left");
                                                                    });

                                                                    $(".otherDesc").keyup(function () {
                                                                        $("#otherCount").html((95 - $(this).val().length) + " Characters left");
                                                                    });

                                                                    $(document).on("input", "#diagnostic", function () {
                                                                        if ($(this).val() > 30) {
                                                                            $(this).val('');
                                                                            $('#dpErrorMsg').show();
                                                                        } else {
                                                                            $('#dpErrorMsg').hide();
                                                                        }

                                                                        var self = $(this);
                                                                        self.val(self.val().replace(/[^0-9]/g, ''));
                                                                    });

                                                                    $(document).on("input", "#boardmeet", function () {
                                                                        if ($(this).val() > 30) {
                                                                            $(this).val('');
                                                                            $('#bmErrorMsg').show();
                                                                        } else {
                                                                            $('#bmErrorMsg').hide();
                                                                        }

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

                                                                    function limitText(limitField, limitCount, limitNum) {
                                                                        var wordcount = limitField.value.trim().split(" ");
                                                                        var wordcountlength;
                                                                        if (limitField.value.trim() == "")
                                                                            wordcountlength = 0;
                                                                        else
                                                                            wordcountlength = wordcount.length;
                                                                        var parse_limit = parseInt(limitNum);

                                                                        if (wordcountlength >= parse_limit) {
                                                                            resultArray = wordcount.slice(0, parse_limit);
                                                                            limitField.value = resultArray.join(" ");
                                                                            limitCount.value = 0;
                                                                            return false;
                                                                        } else {
                                                                            limitCount.value = parse_limit - wordcountlength;
                                                                        }
                                                                    }

                                                                    $(document).on('click', ".saveContinue", function (e) {
                                                                        if ($('#updatesForm').valid()) {
                                                                            $('.saveContinue').css('pointer-events', 'none');
                                                                            $('#updatesForm').submit();
                                                                        }
                                                                    });

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