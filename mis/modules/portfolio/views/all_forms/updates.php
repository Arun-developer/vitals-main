<?php
$company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
$quater_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');

$plan = $updates[0];
$actual_quarter = $this->Mportfolio->monthByQuarters();
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
                        <div class="new-nav-changes" >
                            <div class="new-changes-head"> &nbsp;</div>
                            <a class="nav-item nav-link active " id="nav-Companymaster-tab"   href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>"  aria-controls="nav-Companymaster" aria-selected="true" style="margin-right: 15px;position: relative;">01</a>
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
                                    <h4>Updates</h4>
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

                        <div class="tabpanel-details pad-none config-wrapper dataconfig-content page-wrapper">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('all_forms/left_menu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'updates', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
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
                                        <h4>Updates > <span> <?= $last_month . ' ' . $next_financial; ?></span></h4>
                                    </div>
                                    <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                            <a href="javascript:void(0)" class="edit-btnconfig" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="Plan-structure windowHieghtScroll">
                                    <form id="updatesForm" method="POST" action="<?php echo base_url() . 'index.php/portfolio/all_forms/addUpdates'; ?>" autocomplete="off">
                                        <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                        <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                        <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <div class="">
                                                    <div class="form-group">
                                                        <!-- <label>Incubatee Achievements</label> -->
														<h6>Incubatee Highlights</h6>
                                                        <textarea class="form-control achieveDesc" name="achievement_desc" id="achievement_desc" rows="3" onKeyUp="limitText(this.form.achievement_desc, this.form.countdown_desc, 50);"><?= $plan['achievements']; ?></textarea>
                                                        <span class="hidden_clss" style="margin:5px 0px 0px;color: #afafaf;">You have
                                                            <input readonly="readonly" type="text" name="countdown_desc" id="countdown_desc" size="3" value="50" style="width:45px;height: 20px;color: #afafaf;" />
                                                            words left.</span>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="form-group">
                                                        <h6>Incubatee Challenges</h6>
                                                        <textarea class="form-control challengeDesc" name="challenge_desc" id="challenge_desc" rows="3" onKeyUp="limitText(this.form.challenge_desc, this.form.countdown_challengedesc, 50);"><?= $plan['challenges']; ?></textarea>
                                                        <span class="hidden_clss" style="margin:5px 0px 0px;color: #afafaf;">You have
                                                            <input readonly="readonly" type="text" name="countdown_challengedesc" id="countdown_challengedesc" size="3" value="50" style="width:45px;height: 20px;color: #afafaf;" />
                                                            words left.</span>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="form-group">
                                                        <!--<label>Villgro relationship</label>-->
                                                        <h6>Villgro’s interventions for this month</h6>
                                                        <textarea class="form-control villgroDesc" name="villgro_desc" id="villgro_desc" rows="3" onKeyUp="limitText(this.form.villgro_desc, this.form.countdown_villdesc, 50);"><?= $plan['villgro_relationship']; ?></textarea>
                                                        <span class="hidden_clss" style="margin:5px 0px 0px;color: #afafaf;">You have
                                                            <input readonly="readonly" type="text" name="countdown_villdesc" id="countdown_villdesc" size="3" value="50" style="width:45px;height: 20px;color: #afafaf;" />
                                                            words left.</span>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="form-group">
                                                        <!--<label>Other comments</label>-->
                                                        <h6>Villgro’s Plan for next month</h6>
                                                        <textarea class="form-control otherDesc" name="other_desc" id="other_desc" rows="3" onKeyUp="limitText(this.form.other_desc, this.form.countdown_otherdesc, 50);"><?= $plan['other_comments']; ?></textarea>
                                                        <span class="hidden_clss" style="margin:5px 0px 0px;color: #afafaf;">You have
                                                            <input readonly="readonly" type="text" name="countdown_otherdesc" id="countdown_otherdesc" size="3" value="50" style="width:45px;height: 20px;color: #afafaf;" />
                                                            words left.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <label>&nbsp;</label>
                                                <div class="update_inputsec">
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-10 col-md-10 col-12">
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
                                                                                    <input type="text" name="actual_revenue" id="actual_revenue" value="<?= $actual_revenue; ?>" readonly="" style="width:120px;" class="form-control form-control-sm currencyField" maxlength="20" placeholder="0000">
                                                                                    <span style ="padding-left: 5px;"><?= $this->session->userdata['currency']; ?></span>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <input type="text" name="plan_revenue" id="plan_revenue" value="<?= $plan_revenue; ?>" readonly="" style="width:120px;" class="form-control form-control-sm currencyField" maxlength="20" placeholder="0000">
                                                                                    <span style ="padding-left: 5px;"><?= $this->session->userdata['currency']; ?></span>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Profit</td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <input type="text" name="actual_profit" id="actual_profit" value="<?= $actual_profit; ?>" readonly="" style="width:120px;" class="form-control form-control-sm currencyField" maxlength="20" placeholder="0000">
                                                                                    <span style ="padding-left: 5px;"><?= $this->session->userdata['currency']; ?></span>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group display-flex">
                                                                                    <input type="text" name="plan_profit" id="plan_profit" value="<?= $plan_profit; ?>" readonly="" style="width:120px;" class="form-control form-control-sm currencyField" maxlength="20" placeholder="0000">
                                                                                    <span style ="padding-left: 5px;"><?= $this->session->userdata['currency']; ?></span>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-12"></div>
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                            <?php if ($this->session->userdata['currency'] == 'INR') { ?>
                                                                <p class="currencyNotify"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
                                                            <?php } else { ?>
                                                                <p class="currencyNotify"><span class="text-danger">*</span> All <?= $this->session->userdata['currency']; ?> amounts are in '000's.</p>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h6>Upcoming Milestones</h6>
                                                            <ul class="update-milelist">
                                                                <?php
                                                                if (php72_count($milestone) > 0) {
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
                                                                            <th width="45%"></th>
                                                                            <th width="55%">No. of Meetings<th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="boardmeeting">
                                                                        <tr>
                                                                            <td>Diagnostic Panel</td>
                                                                            <td class="display-flex">
                                                                                <div class="form-group">
                                                                                    <input type="text" name="dp_count" id="diagnostic" value="<?= $dp_meet_count; ?>" readonly="" class="form-control form-control-sm meetingField" maxlength="2" placeholder="00">
                                                                                    <p class="sow_msg hidden_cls error" id="dpErrorMsg">Count exceeds the maximum length 30</p>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Board Meetings</td>
                                                                            <td class="display-flex">
                                                                                <div class="form-group">
                                                                                    <input type="text" name="bm_count" id="boardmeet" value="<?= $board_meet_count; ?>" readonly="" class="form-control form-control-sm meetingField" maxlength="2" placeholder="00">
                                                                                    <p class="sow_msg hidden_cls error" id="bmErrorMsg">Count exceeds the maximum length 30</p>
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
</div>
</div>

<input type="hidden" id="enableCount" value="<?= php72_count($updates); ?>">

<style type="text/css">
    .width-85{ width:85% !important; }
</style>

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('textarea').attr('readonly', 'readonly');
        }
        $('#editBtn').addClass('opacity5');

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

//                                                                    plan_rev.val(inrFormat(plan_rev.val()));
//                                                                    actual_rev.val(inrFormat(actual_rev.val()));
//                                                                    plan_profit.val(inrFormat(plan_profit.val()));
//                                                                    actual_profit.val(inrFormat(actual_profit.val()));

        var selector1 = document.getElementById('achievement_desc');
        var counter1 = document.getElementById('countdown_desc');
        limitText(selector1, counter1, 50);

        var selector2 = document.getElementById('challenge_desc');
        var counter2 = document.getElementById('countdown_challengedesc');
        limitText(selector2, counter2, 50);

        var selector3 = document.getElementById('other_desc');
        var counter3 = document.getElementById('countdown_otherdesc');
        limitText(selector3, counter3, 50);

        var selector5 = document.getElementById('villgro_desc');
        var counter5 = document.getElementById('countdown_villdesc');
        limitText(selector5, counter5, 50);
    });

    $(document).on('click', '#editBtn', function () {
        $('textarea').attr('readonly', false);
        $('#editBtn').removeClass('opacity5');
    });

    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        var cur_month = "<?php echo date('n'); ?>";
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/all_forms/updates/' + inv_id + '/' + year + '/' + cur_month;
    }

    $(document).on("input", "#diagnostic", function () {

        if ($(this).val() > 30) {
            $(this).val('');
            $('#dpErrorMsg').show();
        } else {
            $('#dpErrorMsg').hide();
        }
        var self = $(this);
        if (self.val() != 0 || self.val() == '') {
            self.val(self.val().replace(/[^0-9]/g, ''));
        } else {
            self.val(0);
        }
    });

    $(document).on("input", "#boardmeet", function () {
        if ($(this).val() > 30) {
            $(this).val('');
            $('#bmErrorMsg').show();
        } else {
            $('#bmErrorMsg').hide();
        }
        var self = $(this);
        if (self.val() != 0 || self.val() == '') {
            self.val(self.val().replace(/[^0-9]/g, ''));
        } else {
            self.val(0);
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

</script>
</body>

</html>