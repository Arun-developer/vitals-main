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
        $this->load->view('pending_inputs/header.php', array('page_title' => 'TAP Plan', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name));
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
                                <a class="nav-item nav-link filled-data" id="nav-governance-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/impact_plan/' . $innovation_id . '/' . $current_month; ?>" aria-controls="nav-governance" aria-selected="false">Impact</a>
                                <a class="nav-item nav-link active" id="nav-relationship-tab" href="javascript:void(0)" aria-controls="nav-relationship" aria-selected="false">05</a>
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
                                            <h4>Team, TAP &amp; Mentors</h4>
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
                                                    <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/tap_plan/' . $innovation_id . '/' . $monthNumber; ?>">
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
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/hiring_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/sales.png'; ?>" >
                                                            <span>Team - Hiring &amp; Current <br> Strength</span>
                                                            <?php if ($pending_plans['plan_team_hiring_exclam'] == 1) { ?>
                                                                <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                            <?php } ?>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-dropdown active no-arrow">
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/tap_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/fundraise.png'; ?>" >
                                                            <span>TAP</span>
                                                            <?php if ($pending_plans['plan_tap_exclam'] == 1) { ?>
                                                                <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                            <?php } ?>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-dropdown no-arrow">
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/mentor_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/Tap.png'; ?>" >
                                                            <span>Mentor Hours</span>
                                                            <?php if ($pending_plans['plan_mentor_exclam'] == 1) { ?>
                                                                <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                            <?php } ?>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-dropdown">
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/nontap_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/meeting.png'; ?>" >
                                                            <span>Partnership (Non-TAP)</span>
                                                            <?php if ($pending_plans['plan_partnerships_exclam'] == 1) { ?>
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
                                            <div class="col-xl-10 col-lg-10 col-md-10 col-12">
                                                <?php
                                                if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                                                    $next_financial = $current_financial + 1;
                                                } else {
                                                    $next_financial = $current_financial;
                                                }
                                                ?>
                                                <h4>TAP > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
                                            </div>
                                            <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-12 text-right">
                                                    <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <hr class="cofig-spliter">
                                        <div class="inputplan-structure plan-structure-new">
                                            <form method="post" id="tapPlanForm" action="<?php echo base_url() . 'index.php/portfolio/pending_inputs/addTapPlan'; ?>" autocomplete="off">
                                                <input type='hidden' name='innovation_id' value="<?= $innovation_id; ?>">
                                                <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 table_configcontentnew">
                                                        <table class="input-fundtable mar-tp0 wdt-100">
                                                            <thead>
                                                                <tr>
                                                                    <th>Requirement</th>
                                                                    <th>Firm engaged</th>
                                                                    <th>Need by</th>
                                                                    <th>Date engaged</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $plan = $tap_plan[0];
                                                                $tap_count = isset($plan) ? count($tap_plan) : 1;
                                                                $j = 1;
                                                                if (count($tap_plan) != 0) {
                                                                    for ($i = 0; $i < $tap_count; $i++) {
                                                                        $need_date = (isset($tap_plan[$i]['need_by']) && $tap_plan[$i]['need_by'] != '0000-00-00 00:00:00' && $tap_plan[$i]['need_by'] != '') ? date('d-m-Y', strtotime($tap_plan[$i]['need_by'])) : '';
                                                                        $engage_date = (isset($tap_plan[$i]['month_engaged']) && $tap_plan[$i]['month_engaged'] != '0000-00-00' && $tap_plan[$i]['month_engaged'] != '') ? date('d-m-Y', strtotime($tap_plan[$i]['month_engaged'])) : '';
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input class="form-control form-control-sm requirement readOnly" readonly="" type="text" name="requirement[]" id="requirement_<?php echo $j; ?>" value="<?= $tap_plan[$i]['requirement']; ?>">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <select class="form-control form-control-sm" name="firm_name[]" id="firm_name_<?php echo $j; ?>">
                                                                                        <option>-Select-</option>
                                                                                        <?php foreach ($service_providers as $serv) { ?>
                                                                                            <option value="<?= $serv['id']; ?>" <?php if (isset($tap_plan) && $tap_plan[$i]['firm_engaged'] == $serv['id']) { ?> selected <?php } ?>><?= $serv['name']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input class="form-control form-control-sm needBy readOnly" readonly="" type="text" name="need_by[]" id="need_by_<?php echo $j; ?>" value="<?= $need_date; ?>">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input class="form-control form-control-sm disDate dateCalendar" type="text" name="eng_date[]" id="eng_date_<?= $i; ?>" value="<?= $engage_date; ?>" placeholder="dd-mm-yyyy">
                                                                                </div>
                                                                            </td>
                                                                    <input type='hidden' name="tap_id[]" id='tap_id_<?php echo $j; ?>' value='<?= $tap_plan[$i]['id']; ?>'>
                                                                    <input type="hidden" name="port_tap_id[]" id="port_tap_id<?php echo $j; ?>" value="<?php echo $tap_plan[$i]['port_tap_id']; ?>" />
                                                                    </tr>
                                                                    <?php
                                                                    $j++;
                                                                }
                                                            } else if (count($tap_config) != 0) {
                                                                $config = $tap_config[0];
                                                                $config_count = isset($config) ? count($tap_config) : 1;
                                                                $j = 1;
                                                                for ($i = 0; $i < $config_count; $i++) {
                                                                    $need_date = (isset($tap_config[$i]['need_by']) && $tap_config[$i]['need_by'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($tap_config[$i]['need_by'])) : '';
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-sm requirement readOnly" readonly="" type="text" name="requirement[]" value="<?= $tap_config[$i]['requirement']; ?>">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <select class="form-control form-control-sm" name="firm_name[]">
                                                                                    <option>-Select-</option>
                                                                                    <?php foreach ($service_providers as $serv) { ?>
                                                                                        <option value="<?= $serv['id']; ?>" <?php if (isset($tap_config) && $tap_config[$i]['service_provider'] == $serv['id']) { ?> selected <?php } ?>><?= $serv['name']; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-sm needBy readOnly" readonly="" type="text" name="need_by[]" value="<?= $need_date; ?>">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-sm disDate dateCalendar" type="text" name="eng_date[]" id="eng_date_<?= $i; ?>" placeholder="dd-mm-yyyy">
                                                                            </div>
                                                                        </td>
                                                                    <input type="hidden" name="port_tap_id[]" id="port_tap_id<?php echo $j; ?>" value="<?php echo $tap_config[$i]['id']; ?>" />
                                                                    </tr>
                                                                    <?php
                                                                    $j++;
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr align="center"><td colspan="4" >No data found</td></tr>
                                                                <?php
                                                            }
                                                            ?>
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

        <input type="hidden" id="enableCount" value="<?= count($tap_plan); ?>">

        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/additional-methods.js"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>

        <script type="text/javascript">

            function datepickerEachFunction() {
                var sel_month = $('#current_month').val();
                var sel_year = $('#current_year').val();
                if (sel_month < 4) {
                    sel_year = parseInt(sel_year) + 1;
                }
                $('.disDate').each(function (index, value) {
                    $("#eng_date_" + index).datepicker({
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
                            $("#eng_date_" + index).val(fulldatevalue);
                        },
                        defaultDate: new Date(sel_year, sel_month - 1),
                        stepMonths: 0
                    });
                });
            }

            $(document).ready(function () {
                var editOpt = $('#enableCount').val();
                if (editOpt > 0) {
                    $('input[type="text"], select').attr('readonly', 'readonly');
                    $('.disDate, select').css('pointer-events', 'none');
                } else {
                    datepickerEachFunction();
                }
                $('#editBtn').addClass('opacity5');
            });

            $(document).on('click', '#editBtn', function () {
                $('input[type="text"], select').attr('readonly', false);
                $('.disDate, select').css('pointer-events', '');
                $('.readOnly').attr('readonly', true);
                $('#editBtn').removeClass('opacity5');
                datepickerEachFunction();
            });

            $(document).on('click', ".saveContinue", function (e) {
                if ($('#tapPlanForm').valid()) {
                    $('.saveContinue').css('pointer-events', 'none');
                    $('#tapPlanForm').submit();
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