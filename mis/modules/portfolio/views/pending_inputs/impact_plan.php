
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

        $company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
        $reg_city = isset($plan_header) ? $plan_header['company_data'][0]['reg_city'] : '';
        $sector_name = isset($plan_header) ? $plan_header['sector_name'] : '';
        $this->load->view('pending_inputs/header.php', array('page_title' => 'Impact Plan', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name));
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
                                <a class="nav-item nav-link filled-data" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/finance_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">Finance &amp; Fundraise</a>
                                <a class="nav-item nav-link active" id="nav-governance-tab" href="javascript:void(0)" aria-controls="nav-governance" aria-selected="false">04</a>
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
                                            <h4>Impact</h4>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                                            <ul class="milestone-links">
                                                <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                    <li><a class="saveContinue" href="javascript:void(0)">Save &amp; Continue</a></li>
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
                                                    <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/impact_plan/' . $innovation_id . '/' . $monthNumber; ?>">
                                                        <li class="tab-slider--trigger pending_month_btn <?= $selected; ?>"><?= date("F", strtotime($pending_month[$i])); ?></li>
                                                    </a>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="tabpanel-details config-wrapper pad-none dataconfig-content page-wrapper chiller-theme">
                                    <nav id="sidebar" data-topbar data-options="scrolltop:false" class="sidebar-wrapper top-bar">
                                        <div class="sidebar-content">
                                            <div class="sidebar-menu">
                                                <ul>
                                                    <li class="sidebar-dropdown no-arrow active">
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/impact_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/sales.png'; ?>" >
                                                            <span>Impact</span>
                                                            <?php if ($pending_plans['plan_impact_exclam'] == 1) { ?>
                                                                <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                            <?php } ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </nav>
                                    <main class="page-content">
                                        <?php
                                        $impacts = $impact_list = json_decode($impact_config[0]['total_impacted'], true);
                                        $metrics = $metric_list = json_decode($impact_config[0]['metric_unit'], true);
                                        $metrics1 = $metric_list = json_decode($impact_plan[0]['metric_unit'], true);

                                        $impact_key = 0;
                                        foreach ($impacts as $key => $value) {
                                            $impacts[$impact_key] = $impacts[$key];
                                            unset($impacts[$key]);
                                            $impact_key++;
                                        }

                                        $metric_key = 0;
                                        foreach ($metrics as $key => $value) {
                                            $metrics[$metric_key] = $metrics[$key];
                                            unset($metrics[$key]);
                                            $metric_key++;
                                        }

                                        if (!php72_array_filter($impacts) && $impact_plan[0]['beneficiaries'] == '' && $impact_plan[0]['jobs_created'] == '') {
                                            $imp_enable = 0;
                                        } else {
                                            $imp_enable = 1;
                                        }

                                        if (!php72_array_filter($metrics1)) {
                                            $met_enable = 0;
                                        } else {
                                            $met_enable = 1;
                                        }
                                        ?>
                                        <input type="hidden" id="impEnableCount" value="<?= $imp_enable; ?>">
                                        <input type="hidden" id="metEnableCount" value="<?= $met_enable; ?>">
                                        <form method="post" id="impact_form" action="<?php echo base_url() . 'index.php/portfolio/pending_inputs/addImpactPlan'; ?>" autocomplete="off">
                                            <div class="row dataconfig">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                    <?php
                                                    if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                                                        $next_financial = $current_financial + 1;
                                                    } else {
                                                        $next_financial = $current_financial;
                                                    }
                                                    ?>
                                                    <h4>Impact > <span> <?= $last_month . ' ' . $next_financial; ?></span></h4>
                                                </div>
                                            </div>
                                            <hr class="cofig-spliter">
                                            <div class="inputplan-structure plan-structure-new">
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
                                                                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12 vil-Deals portfolio-table">
                                                                    <table class="input-fundtable">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><label>No of end beneficiaries</label></td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm volumefld" type="text" maxlength="6" name="end_beneficiaries" id="end_beneficiaries" placeholder="00" value="<?php echo isset($impact_plan[0]['beneficiaries']) ? $impact_plan[0]['beneficiaries'] : ''; ?>">
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label>Job created</label></td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm volumefld" type="text"  maxlength="6" name="created_jobs" id="created_jobs" placeholder="0000" value="<?php echo isset($impact_plan[0]['jobs_created']) ? $impact_plan[0]['jobs_created'] : ''; ?>" >
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 vil-Deals portfolio-table">
                                                                    <table class="input-fundtable">
                                                                        <tbody>
                                                                                <!-- <tr>
                                                                                    <td>
                                                                                        <ul class="milestone-links" style="visibility:hidden">
                                                                                            <li>
                                                                                                <div class="form-group">
                                                                                                    <input class="form-control form-control-sm" type="text">
                                                                                                </div>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </td>
                                                                                </tr> -->
                                                                            <tr>
                                                                                <td><label>Total Number of lives impacted</label></td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input class="form-control form-control-sm" name="total_impacted" id="total_impacted" readonly="" type="text" value="<?php echo isset($impact_plan[0]['total_impacted']) ? $impact_plan[0]['total_impacted'] : ''; ?>">
                                                                                    </div>
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
                                                                        <h6>Impact Metric</h6>
                                                                    </div>
                                                                    <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-12 text-right" id='editMetricSec'>
                                                                            <a href="javascript:void(0)" class="pad-rt15px" id="editMetric"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-10 col-lg-10 col-md-8 col-sm-6 col-12 vil-Deals portfolio-table">
                                                                    <table class="input-fundtable">
                                                                        <tbody>
                                                                            <?php
                                                                            if (php72_count($metrics1) > 0) {
                                                                                $j = 1;
                                                                                foreach ($metrics1 as $key => $val1) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td><label><?php echo $key; ?></label></td>
                                                                                <input type="hidden" class="form-control form-control-sm metricName" maxlength="50" name="metric_name[]" placeholder="Impact metric 1"  id="metricNam_<?php echo $j; ?>" readonly="" value="<?php echo $key; ?>">
                                                                                <td>
                                                                                    <ul class="milestone-linksec">
                                                                                        <li>
                                                                                            <div class="form-group">
                                                                                                <input class="form-control form-control-sm metric currencyField" maxlength="20" type="text" name="metric[]" placeholder="Value" id="metric_<?php echo $j; ?>" value="<?php echo $val1; ?>">
                                                                                                <span class="metric_msg hidden_cls text-danger" id="metric_msg_<?php echo $i; ?>"></span>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </td>
                                                                                </tr>
                                                                                <?php
                                                                                $j++;
                                                                            }
                                                                        } else {

                                                                            if (php72_count($metrics) > 0) {
                                                                                $metric_count = php72_count($metrics);
                                                                            } else {
                                                                                $metric_count = 1;
                                                                            }
                                                                            $j = 1;
                                                                            for ($i = 0; $i < $metric_count; $i++) {
                                                                                if (php72_count($metrics) > 0) {
                                                                                    $metric_values = explode("*|*", $metrics[$i]);
                                                                                }
                                                                                ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <input type="text" class="form-control form-control-sm metricName" maxlength="50" name="metric_name[]" placeholder="Impact metric 1"  id="metricNam_<?php echo $j; ?>" readonly="" value="<?php echo $metric_values[0]; ?>">
                                                                                            <span class="name_msg hidden_cls text-danger" id="name_msg_<?php echo $i; ?>">Enter metric</span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <ul class="milestone-linksec">
                                                                                            <li>
                                                                                                <div class="form-group">
                                                                                                    <input class="form-control form-control-sm metric currencyField" maxlength="7" type="text" name="metric[]" placeholder="Value" id="metric_<?php echo $j; ?>" value="">
                                                                                                    <span class="metric_msg hidden_cls text-danger" id="metric_msg_<?php echo $i; ?>"></span>
                                                                                                </div>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php
                                                                                $j++;
                                                                            }
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
                                            <input type='hidden' name='innovation_id' value="<?= $innovation_id; ?>">
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

        <input type="hidden" id="enableCount" value="<?= php72_count($impact_plan); ?>">
        <input type="hidden" name="port_impact_id" id="port_impact_id" value="<?php echo isset($impact_plan[0]['id']) ? $impact_plan[0]['id'] : $impact_config[0]['id']; ?>" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/main.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>

        <script type="text/javascript">

            $(document).ready(function () {
                onLoad();
            });

            $(document).on('keyup', '.impact', function () {
                var imid = this.id;
                var splt = imid.split("_");
                if (this.value != '') {
                    $('#value_' + splt[1]).attr('required', 'required');
                }
            });

            function onLoad() {
                var impEditOpt = $('#impEnableCount').val();
                if (impEditOpt > 0) {
                    $('.impact_form input[type="text"]').attr('readonly', 'readonly');
                }
                var metEditOpt = $('#metEnableCount').val();
                if (metEditOpt > 0) {
                    $('.metric_form input[type="text"]').attr('readonly', 'readonly');
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
            });
            $(document).on('click', '#editMetric', function () {
                $('#updatePlan').val('1');
                $('.metric_form :input').attr('readonly', false);
                $('#editMetric').removeClass('opacity5');
            });

            $(".volumefld").on("input", function (evt) {
                var self = $(this);
                if (self.val() != 0 || self.val() == '') {
                    self.val(self.val().replace(/[^0-9]/g, ''));
                    self.val(inrFormat(self.val()));
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
                    self.val(inrFormat(self.val()));

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
                self.val(inrFormat(self.val()));
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