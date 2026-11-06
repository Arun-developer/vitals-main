<?php
$company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
$quater_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_quarter = $this->Mportfolio->monthByQuarters();

$last_month = date("F", mktime(0, 0, 0, $current_month, 1));
$current_ytdVal = isset($current_ytd) && $current_ytd != '' ? $current_ytd : 0;
$total_ytdVal = isset($ytd_value) && php72_cmp($ytd_value) != 0 ? $ytd_value : 0;

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
                            <a class="nav-item nav-link  " id="nav-Companymaster-tab"   href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-Companymaster" aria-selected="true" style="margin-right: 15px;position: relative;">Updates</a>
                        </div>
                        <div class="new-nav-changes1"><div class="new-changes-head1"> Portfolio Information</div>
                            <a class="nav-item nav-link active" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/product/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="false">02</a>
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
                                    <h4>Product &amp; Sales</h4>
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
                                <?php $this->load->view('all_forms/left_menu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'pipeline', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
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
                                        <h4>Pipeline > <span> <?= $last_month . ' ' . $next_financial; ?></span></h4>
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
                                            <li class="tab-slider--triggerform "><a href="<?= base_url() . 'index.php/portfolio/all_forms/product/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Product</a></li>
                                            <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/sales/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Sales</a></li>
                                            <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/channel/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Channel</a></li>
                                            <li class="tab-slider--triggerform active"><a href="javascript:void(0)">Pipeline</a></li>
                                            <?php if ($this->session->userdata['currency'] == 'INR') { ?>
                                                <p class="currencyNotify"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
                                            <?php } else { ?>
                                                <p class="currencyNotify"><span class="text-danger">*</span> All <?= $this->session->userdata['currency']; ?> amounts are in '000's.</p>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-slider--container">
                                    <div id="tab3" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <?php
                                            $tot_open = $tot_under = $tot_close = $tot_reject = $annual = 0;
                                            if (php72_count($pipe_config) > 0) {
                                                foreach ($pipe_config as $pipe) {
                                                    $get_open = json_decode($pipe['open_pipeline'], true);
                                                    $get_under = json_decode($pipe['under_discussion'], true);
                                                    $get_close = json_decode($pipe['closed_pipeline'], true);
                                                    $get_reject = json_decode($pipe['converted_pipeline'], true);
                                                    foreach ($get_open as $open) {
                                                        $tot_open += $open;
                                                    }
                                                    foreach ($get_under as $under) {
                                                        $tot_under += $under;
                                                    }
                                                    foreach ($get_close as $close) {
                                                        $tot_close += $close;
                                                    }
                                                    foreach ($get_reject as $reject) {
                                                        $tot_reject += $reject;
                                                    }
                                                    $annual = $tot_open + $tot_under + $tot_close + $tot_reject;
                                                }
                                            }
                                            ?>
                                            <div class="inputplan-structureall plan-structure-new">
                                                <form method="post" id="pipePlanForm" action="<?php echo base_url() . 'index.php/portfolio/all_forms/addPipePlan'; ?>" autocomplete="off">
                                                    <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                    <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                    <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                    <div class="row">
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                            <table>
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="120"><label>Annual goal</label></td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-sm readOnly annualGoal" type="text" name="annualGoal" readonly="" value="<?= $annual; ?>">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <hr class="cofig-spliter">
                                                    <div class="row">
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                            <table>
                                                                <tbody>

                                                                    <?php
                                                                    $i = 1;
                                                                    if (php72_count($pipe_plan) > 0) {
                                                                        $get_open_value = $pipe_plan[0]['open'];
                                                                        $get_under_value = $pipe_plan[0]['under_discussion'];
                                                                        $get_close_value = $pipe_plan[0]['rejected'];
                                                                        $get_convert_value = $pipe_plan[0]['converted'];

                                                                        $currencyVal = isset($pipe_plan[0]['currency']) && $pipe_plan[0]['currency'] ? $pipe_plan[0]['currency'] : $this->session->userdata['currency'];
                                                                        ?>
                                                                        <tr>
                                                                            <td width="120"><label>Open</label></td>
                                                                            <td>
                                                                                <ul class="milestone-linksec">
                                                                                    <li class="pad0">
                                                                                        <div class="form-group">
                                                                                            <input class="form-control form-control-sm currencyField" id="currency_<?= $i; ?>" type="text" name="openValue" value="<?= $get_open_value; ?>" maxlength="20">
                                                                                        </div>
                                                                                    </li>
                                                                                    <li><?= $currencyVal; ?></li>
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="120"><label>Hot/Under</label></td>
                                                                            <td>
                                                                                <ul class="milestone-linksec">
                                                                                    <li class="pad0">
                                                                                        <div class="form-group">
                                                                                            <input class="form-control form-control-sm currencyField" id="currency_<?= $i; ?>" type="text" name="underValue" value="<?= $get_under_value; ?>" maxlength="20">
                                                                                        </div>
                                                                                    </li>
                                                                                    <li><?= $currencyVal; ?></li>
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="120"><label>Discussion Rejected</label></td>
                                                                            <td>
                                                                                <ul class="milestone-linksec">
                                                                                    <li class="pad0">
                                                                                        <div class="form-group">
                                                                                            <input class="form-control form-control-sm currencyField" id="currency_<?= $i; ?>" type="text" name="rejectValue" value="<?= $get_close_value; ?>" maxlength="20">
                                                                                        </div>
                                                                                    </li>
                                                                                    <li><?= $currencyVal; ?></li>
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="120"><label>Closed Converted</label></td>
                                                                            <td>
                                                                                <ul class="milestone-linksec">
                                                                                    <li class="pad0">
                                                                                        <div class="form-group">
                                                                                            <input class="form-control form-control-sm currencyField" id="currency_<?= $i; ?>" type="text" name="convertValue" value="<?= $get_convert_value; ?>" maxlength="20">
                                                                                        </div>
                                                                                    </li>
                                                                                    <li><?= $currencyVal; ?></li>
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                    <input type="hidden" name="amount" value="<?= $currencyVal; ?>">
                                                                    <?php
                                                                    $i++;
                                                                } else {
                                                                    ?>
                                                                    <tr>
                                                                        <td width="120"><label>Open</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li class="pad0">
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm currencyField" id="currency_<?= $i; ?>" type="text" name="openValue" value="" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="120"><label>Hot/Under</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li class="pad0">
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm currencyField" id="currency_<?= $i; ?>" type="text" name="underValue" value="" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="120"><label>Discussion Rejected</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li class="pad0">
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm currencyField" id="currency_<?= $i; ?>" type="text" name="rejectValue" value="" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="120"><label>Closed Converted</label></td>
                                                                        <td>
                                                                            <ul class="milestone-linksec">
                                                                                <li class="pad0">
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm currencyField" id="currency_<?= $i; ?>" type="text" name="convertValue" value="" maxlength="20">
                                                                                    </div>
                                                                                </li>
                                                                                <li><?= $this->session->userdata['currency']; ?></li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <input type="hidden" name="amount" value="<?= $this->session->userdata['currency']; ?>">
                                                                    <?php
                                                                    $i++;
                                                                }
                                                                ?>

                                                                <tr>
                                                                    <td width="120"><label>YTD</label></td>
                                                                    <td>
                                                                        <ul class="milestone-linksec">
                                                                            <li class="pad0">
                                                                                <div class="form-group">
                                                                                    <input class="form-control form-control-sm readOnly ytdField" type="text" readonly="" name="ytdCount" value="<?php echo $current_ytdVal; ?>">
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

<input type="hidden" id="enableCount" value="<?= php72_count($pipe_plan); ?>">
<input type="hidden" id="current_ytd" value="<?= $total_ytdVal; ?>">

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
        getTotalYTD();
    });

    $(document).on('click', '#editBtn', function () {
        $('input[type="text"]').attr('readonly', false);
        $('.readOnly').attr('readonly', true);
        $('#editBtn').removeClass('opacity5');
    });

    $(document).on("keyup", ".currencyField", function (evt) {
        getTotalYTD();
    });

    function getTotalYTD() {
        var sum = 0;
        var current = $('#current_ytd').val();
        $('.currencyField').each(function (key, value) {
            var amount = $(this).val();
            sum += Number(amount.replace(/[^0-9.-]+/g, ""));
        });
        var new_ytd = parseFloat(current) + parseFloat(sum);
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

    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/all_forms/pipeline/' + inv_id + '/' + year;
    }

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
        if ($('#pipePlanForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#pipePlanForm').submit();
        }
    });
    $('.plan-structure-new').css({'height': (($(window).height()) - 380) + 'px'});
</script>
</body>

</html>
