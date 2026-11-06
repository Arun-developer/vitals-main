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

        $last_month = date("F", mktime(0, 0, 0, $current_month, 1));

        $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
        $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';

        $current_ytdVal = isset($current_ytd) && $current_ytd != '' ? $current_ytd : 0;
        $total_ytdVal = isset($ytd_value) && php72_cmp($ytd_value) != 0 ? $ytd_value : 0;

        $company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
        $reg_city = isset($plan_header) ? $plan_header['company_data'][0]['reg_city'] : '';
        $sector_name = isset($plan_header) ? $plan_header['sector_name'] : '';
        $this->load->view('pending_inputs/header.php', array('page_title' => 'Sales Plan', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name));
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
                                <a class="nav-item nav-link active" id="nav-business-tab" href="javascript:void(0)" aria-controls="nav-business" aria-selected="false">02</a>
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
                                            <h4>Sales &amp; Pipeline</h4>
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
                                <?php
                                if (php72_count($pending_month) > 0) {
                                    ?>
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
                                                    <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/sales_plan/' . $innovation_id . '/' . $monthNumber; ?>">
                                                        <li class="tab-slider--trigger pending_month_btn <?= $selected; ?>"><?= date("F", strtotime($pending_month[$i])); ?></li>
                                                    </a>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <nav id="sidebar" data-topbar data-options="scrolltop:false" class="sidebar-wrapper top-bar">
                                            <div class="sidebar-content">
                                                <div class="sidebar-menu">
                                                    <ul>
                                                        <li class="sidebar-dropdown active no-arrow">
                                                            <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/sales_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                                <img src="<?php echo base_url() . 'source/portfolio_assets/img/sales.png'; ?>" >
                                                                <span>Sales</span>
                                                                <?php if (php72_cmp($pending_plans['plan_sales_exclam']) == 1) { ?>
                                                                    <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                                <?php } ?>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-dropdown no-arrow">
                                                            <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/channel_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                                <img src="<?php echo base_url() . 'source/portfolio_assets/img/fundraise.png'; ?>" >
                                                                <span>Channel</span>
                                                                <?php if (php72_cmp($pending_plans['plan_channel_exclam']) == 1) { ?>
                                                                    <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                                <?php } ?>
                                                            </a>
                                                        </li>
                                                        <li class="sidebar-dropdown no-arrow">
                                                            <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/pipeline_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                                <img src="<?php echo base_url() . 'source/portfolio_assets/img/tap.png'; ?>" >
                                                                <span>Pipeline</span>
                                                                <?php if (php72_cmp($pending_plans['plan_pipeline_exclam']) == 1) { ?>
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
                                                    <h4>Sales > <span> <?= $last_month . ' ' . $next_financial; ?></span></h4>
                                                </div>
                                                <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || php72_cmp($this->session->userdata['sector_lead']) == 1) { ?>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                        <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <hr class="cofig-spliter">

                                            <?php
                                            $month_volume = $tot_volume = 0;
                                            if (php72_count($approved_sales) > 0) {
                                                foreach ($approved_sales as $sales) {
                                                    $get_mnth = $actual_month[$current_month];
                                                    $get_volume = json_decode($sales['value']);
                                                    $month_volume += str_replace(',', '', $get_volume->$get_mnth);
                                                    foreach ($get_volume as $volume) {
                                                        $total = str_replace(',', '', $volume);
                                                        $tot_volume += $total;
                                                    }
                                                }
                                            }
                                            ?>

                                            <div class="inputplan-structure plan-structure-new">
                                                <?php if ($this->session->userdata['currency'] == 'INR') { ?>
                                                    <p class="currencyNotify"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
                                                <?php } ?>
                                                <form id="salesPlanForm" method="POST" action="<?php echo base_url() . 'index.php/portfolio/pending_inputs/addSalesPlan'; ?>" autocomplete="off">
                                                    <input type='hidden' name='innovation_id' value="<?= $innovation_id; ?>">
                                                    <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                    <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                    <div class="row">
                                                        <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                                            <table>
                                                                <tr>
                                                                    <td width="120"><label>Monthly Plan</label></td>
                                                                    <td ><div class="form-group" style="padding-left:10px">
                                                                            <input class="form-control form-control-sm readOnly autoMonth" type="text" name="monthlyPlan" readonly="" value="<?= $month_volume; ?>">
                                                                        </div></td>
                                                                </tr>
                                                            </table>

                                                        </div>
                                                        <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                                            <table>
                                                                <tr>
                                                                    <td width="120"><label>Annual goal</label></td>
                                                                    <td><div class="form-group" style="padding-left:10px">
                                                                            <input class="form-control form-control-sm readOnly autoAnnual" type="text" name="annualGoal" readonly="" value="<?= $tot_volume; ?>">
                                                                        </div></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="2">Volume - <?= $last_month . ', ' . $next_financial; ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    if (php72_count($approved_sales) > 0) {
                                                                        foreach ($approved_sales as $sales) {
                                                                            $cond['product_id'] = $sales['id'];
                                                                            $cond['inv_id'] = $sales['inv_id'];
                                                                            $cond['financial_year'] = $sales['financial_year'];
                                                                            $cond['month'] = $current_month;
                                                                            $get_data = $this->Mportfolio->getSalesInput('plan_sales', $cond, '3');
                                                                            ?>
                                                                            <tr>
                                                                                <td width="120"><label><?= $sales['product_name']; ?></label></td>
                                                                                <td >
                                                                                    <ul class="milestone-linksec">
                                                                                        <li>
                                                                                            <div class="form-group">
                                                                                                <input class="form-control form-control-sm numberField" type="text" name="volume[]" value="<?= $get_data[0]['volume']; ?>" maxlength="20">
                                                                                            </div>
                                                                                        </li>
                                                                                        <li><?= $sales['unit']; ?></li>
                                                                                    </ul>
                                                                                </td>
                                                                            </tr>
                                                                        <input type="hidden" name="product[]" value="<?= $sales['product_name']; ?>">
                                                                        <input type="hidden" name="unit[]" value="<?= $sales['unit']; ?>">
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <tr>
                                                                        <td align="center">-N/A-</td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="2">Value - <?= $last_month . ', ' . $next_financial; ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $i = 1;
                                                                    if (php72_count($approved_sales) > 0) {
                                                                        foreach ($approved_sales as $sales) {
                                                                            $cond['product_id'] = $sales['id'];
                                                                            $cond['inv_id'] = $sales['inv_id'];
                                                                            $cond['financial_year'] = $sales['financial_year'];
                                                                            $cond['month'] = $current_month;
                                                                            $get_data = $this->Mportfolio->getSalesInput('plan_sales', $cond, '3');
                                                                            ?>
                                                                            <tr>
                                                                                <td width="120"><label><?= $sales['product_name']; ?></label></td>
                                                                                <td>
                                                                                    <ul class="milestone-linksec">
                                                                                        <li>
                                                                                            <div class="form-group">
                                                                                                <input class="form-control form-control-sm currencyField" id="currency_<?= $i; ?>" type="text" name="value[]" value="<?= $get_data[0]['value']; ?>" maxlength="20">
                                                                                            </div>
                                                                                        </li>
                                                                                        <li><?= $this->session->userdata['currency']; ?></li>
                                                                                    </ul>
                                                                                </td>
                                                                            </tr>
                                                                        <input type="hidden" name="amount[]" value="<?= $this->session->userdata['currency']; ?>">
                                                                        <input type="hidden" name="product_id[]" value="<?= $sales['id']; ?>">
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td width="120"><label>YTD &nbsp;  &nbsp;</label></td>
                                                                    <td>
                                                                        <ul class="milestone-linksec">
                                                                            <li>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="enableCount" value="<?= php72_count($sales_plan); ?>">
        <input type="hidden" id="current_ytd" value="<?= $total_ytdVal; ?>">

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

                var auto_month = $('.autoMonth');
                auto_month.val(inrFormat(auto_month.val()));

                var auto_goal = $('.autoAnnual');
                auto_goal.val(inrFormat(auto_goal.val()));

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

            function pad(num) {
                var s = num + "";
                s = parseFloat(s, 10);
                return s;
            }

            $(document).on('blur', '.numberField', function (evt) {
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

            $(document).on('input', '.numberField', function (evt) {
                var self = $(this);
                self.val(self.val().replace(/[^0-9\.]/g, ''));
                self.val(inrFormat(self.val()));
                var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
                var matchedString = self.val().match(patt);
                if (matchedString) {
                    self.val(matchedString);
                }
            });

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
                if ($('#salesPlanForm').valid()) {
                    $('.saveContinue').css('pointer-events', 'none');
                    $('#salesPlanForm').submit();
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
