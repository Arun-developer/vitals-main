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
        $this->load->view('pending_inputs/header.php', array('page_title' => 'Team Hiring Plan', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name));
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
            <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Record(s) deleted successfully</div>
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
                                                    <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/hiring_plan/' . $innovation_id . '/' . $monthNumber; ?>">
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
                                                    <li class="sidebar-dropdown active no-arrow">
                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/hiring_plan/' . $innovation_id . '/' . $current_month; ?>">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/sales.png'; ?>" >
                                                            <span>Team - Hiring &amp; Current <br> Strength</span>
                                                            <?php if ($pending_plans['plan_team_hiring_exclam'] == 1) { ?>
                                                                <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                            <?php } ?>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-dropdown no-arrow">
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
                                                    <li class="sidebar-dropdown no-arrow">
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
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                <?php
                                                if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                                                    $next_financial = $current_financial + 1;
                                                } else {
                                                    $next_financial = $current_financial;
                                                }
                                                ?>
                                                <h4>Team - Hiring &amp; Current Strength > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
                                            </div>
                                            <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-12 text-right">
                                                    <ul class="milestone-links">
                                                        <li>
                                                            <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="addTeam"><i class="fas fa-plus-circle"></i> Add New</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <hr class="cofig-spliter">
                                        <div class="inputplan-structure plan-structure-new">
                                            <form method="post" id="hiringPlanForm" action="<?php echo base_url() . 'index.php/portfolio/pending_inputs/addHiringPlan'; ?>" autocomplete="off">
                                                <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 table_configcontentnew">
                                                        <div id="accordion">
                                                            <table class="input-fundtable mar-tp0">
                                                                <thead class="hiringTable">
                                                                    <tr>
                                                                        <th width="25%"></th>
                                                                        <th width="25%"class="text-center">YTD</th>
                                                                        <th width="25%"class="text-center">Current</th>
                                                                        <th width="5%" class="text-center">&nbsp;</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id='team_add'>
                                                                    <?php
                                                                    $j = 1;
                                                                    $total_ytd_hire = array();
                                                                    $hire_job = $job_list[0];
                                                                    $hire_count = isset($hire_job) ? php72_count($job_list) : php72_count($designation_list);

                                                                    for ($i = 0; $i < $hire_count; $i++) {
                                                                        $plan = $team_plan[0];
                                                                        $plan_count = isset($plan) ? php72_count($team_plan) : 0;

                                                                        if (php72_count($hire_job) == 0) {
                                                                            $job_title = $designation_list[$i]['name'];
                                                                        } else {
                                                                            $job_title = $job_list[$i]['job_name'];
                                                                        }

                                                                        $cond['inv_id'] = $innovation_id;
                                                                        $cond['job_name'] = $job_title;

                                                                        $status = 3;
                                                                        $only_value = '';
                                                                        $total_ytd = $now_value = 0;
                                                                        $all_ytd = $this->Mportfolio->getFinanceDetails('plan_team_hiring', $cond, $current_month, $current_financial, $status, 'now');
                                                                        $now_ytd = $this->Mportfolio->getFinanceDetails('plan_team_hiring', $cond, $current_month, $current_financial, $status, 'last');
                                                                        $only_ytd = $this->Mportfolio->getFinanceDetails('plan_team_hiring', $cond, $current_month, $current_financial, $status);


                                                                        foreach ($all_ytd as $value) {
                                                                            $a_ytd = str_replace(',', '', $value['current_value']);
                                                                            $total_ytd += $a_ytd;
                                                                        }
                                                                        foreach ($now_ytd as $value) {
                                                                            $n_ytd = str_replace(',', '', $value['current_value']);
                                                                            $now_value += $n_ytd;
                                                                        }
                                                                        foreach ($only_ytd as $value) {
                                                                            $o_ytd = str_replace(',', '', $value['current_value']);
                                                                            $only_value += $o_ytd;
                                                                        }
                                                                        array_push($total_ytd_hire, $total_ytd);
                                                                        ?>
                                                                        <tr id="team_tr_<?= $j; ?>" class="team_more">
                                                                            <td class="vill-gray"><?= $job_title; ?></td>
                                                                    <input type="hidden" name="team_name[]" id="team_name_<?php echo $j; ?>" value="<?= $job_title; ?>">
                                                                    <input type='hidden' name="team_id[]" id='team_id_<?php echo $j; ?>' value='<?php echo isset($job_list[$i]['id']) ? $job_list[$i]['id'] : $job_list[$i]['id']; ?>'>
                                                                    <input type='hidden' id='tot_ytd_<?php echo $j; ?>' value='<?= $now_value; ?>'>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input class="form-control form-control-sm currencyField readOnly" readonly="" type="text" placeholder="0" name="team_ytd[]" id="teamYtd_<?php echo $j; ?>" value='<?= $total_ytd; ?>'>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input class="form-control form-control-sm numberField" type="text" name='current_number[]' id='current_number_<?php echo $j; ?>' placeholder="00" value='<?= $only_value; ?>' maxlength="9">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <?php if (php72_count($team_plan) > 0) { ?>
                                                                            <a class="deleteteaminput text-danger deleteTeam" data-dyn="<?php echo $j; ?>" data-dyn-name="team" href="javascript:void(0)">
                                                                                <i class="fas fa-trash"></i>
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <span class="deleteteaminput cursor" title="Remove" onclick="hideRow(<?= $j; ?>);"><i class="fas fa-minus-circle"></i></span>
                                                                        <?php } ?>
                                                                    </td>
                                                                    </tr>
                                                                    <?php
                                                                    $j++;
                                                                }
                                                                ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td><b>Total</b></td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-sm totalytdField readOnly" readonly="" type="text" id='totalYTD' name='total_ytd' value='<?= array_sum($total_ytd_hire); ?>'>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-sm totalField readOnly" readonly="" type="text" id='totalValue' name='total_value' value='<?= $team_plan[0]['total_value']; ?>'>
                                                                            </div>
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
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

        <div class="modal" id="deletemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content delete-alert">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div class="col-10">
                                    <h4>Are you sure you want to delete selected items?</h4>
                                    <p>you are about to delete the selected information fields, you
                                        can't undo this</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="team_val" id="team_val" />
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
                    </div>
                </div>
            </div>
            <input type="hidden" id="deleteID" value="">
            <input type="hidden" id="deleteName" value="">
        </div>

        <input type="hidden" id="enableCount" value="<?= php72_count($team_plan); ?>">
        <style>
            i.fas.fa-minus-circle{
                color:#ffae42;
            }
        </style>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>

        <script type="text/javascript">

                                                                        $(document).ready(function () {
                                                                            onLoad();
                                                                        });

                                                                        function onLoad() {
                                                                            var editOpt = $('#enableCount').val();
                                                                            if (editOpt > 0) {
                                                                                $('input[type="text"], select').attr('readonly', 'readonly');
                                                                                $('select').css('pointer-events', 'none');
                                                                            }
                                                                            $('#editBtn').addClass('opacity5');
                                                                        }

                                                                        $(document).on('click', '#editBtn', function () {
                                                                            $('input[type="text"], select').attr('readonly', false);
                                                                            $('select').css('pointer-events', '');
                                                                            $('.readOnly').attr('readonly', true);
                                                                            $('#editBtn').removeClass('opacity5');
                                                                        });

                                                                        $(document).on('click', '#addTeam', function () {
                                                                            if ($('.team_more').length) {
                                                                                var dyn = $('.team_more').length;
                                                                                var increa = parseInt(dyn) + 1;
                                                                                var datas = '<tr id="team_tr_' + increa + '" class="team_more"><td><div class="form-group">';
                                                                                datas += '<input type="text" class="form-control form-control-sm" id="team_name_' + increa + '" name="team_name[]" value=""><input type="hidden" name="team_id[]" id="team_id_' + increa + '" value=""><input type="hidden" id="tot_ytd_' + increa + '" value=""></div></td>';
                                                                                datas += '<td><div class="form-group"><input type="text" class="form-control form-control-sm currencyField readOnly" readonly="" placeholder="0" id="teamYtd_' + increa + '" name="team_ytd[]" value=""></div></td>';
                                                                                datas += '<td><div class="form-group"><input class="form-control form-control-sm numberField" type="text" placeholder="00"  name="current_number[]" id="current_number_' + increa + '" maxlength="9"></div></td><td></td>';
                                                                                $(datas).insertAfter($('#team_tr_' + dyn));
                                                                            } else {
                                                                                var datas = '<tr id="team_tr_1" class="team_more"><td><div class="form-group">';
                                                                                datas += '<input type="text" class="form-control form-control-sm" id="team_name_1" name="team_name[]" value=""><input type="hidden" name="team_id[]" id="team_id_1" value=""><input type="hidden" id="tot_ytd_1" value=""></div></td>';
                                                                                datas += '<td><div class="form-group"><input type="text" class="form-control form-control-sm currencyField readOnly" readonly="" placeholder="0" id="teamYtd_1" name="team_ytd[]" value=""></div></td>';
                                                                                datas += '<td><div class="form-group"><input class="form-control form-control-sm numberField" type="text" placeholder="00" name="current_number[]" id="current_number_1" maxlength="9"></div></td><td></td>';
                                                                                $('#team_add').append(datas);
                                                                            }
                                                                        });

                                                                        function hideRow(id) {
                                                                            $('#team_tr_' + id).closest('tr').remove();
                                                                            var tr_count = $('.team_more').length;
                                                                            if (tr_count == 0) {
                                                                                var datas = '<tr id="team_tr_1" class="team_more"><td><div class="form-group">';
                                                                                datas += '<input type="text" class="form-control form-control-sm" id="team_name_1" name="team_name[]" value=""><input type="hidden" name="team_id[]" id="team_id_1" value=""><input type="hidden" id="tot_ytd_1" value=""></div></td>';
                                                                                datas += '<td><div class="form-group"><input type="text" class="form-control form-control-sm currencyField readOnly" readonly="" placeholder="0" id="teamYtd_1" name="team_ytd[]" value=""></div></td>';
                                                                                datas += '<td><div class="form-group"><input class="form-control form-control-sm numberField" type="text" placeholder="00" name="current_number[]" id="current_number_1" maxlength="9"></div></td><td></td>';
                                                                                $(datas).insertAfter($('.hiringTable'));
                                                                                datepickerEachFunction();
                                                                            }
                                                                        }

                                                                        $(document).on('click', '.deleteTeam', function () {
                                                                            var dynval = $(this).attr("data-dyn");
                                                                            var dynvalname = $(this).attr("data-dyn-name");
                                                                            var delete_id = $('#team_id_' + dynval).val();
                                                                            var delete_name = $('#team_name_' + dynval).val();
                                                                            $('#deletemodal').modal('show');
                                                                            $('#team_val').val(dynval);
                                                                            $('#deleteID').val(delete_id);
                                                                            $('#deleteName').val(delete_name);
                                                                        });

                                                                        $('.totalytdField').each(function (key, value) {
                                                                            var currency = $('.totalytdField');
                                                                            if (currency.val != 0 || currency.val == '') {
                                                                                currency.val(inrFormat(currency.val()));
                                                                            } else {
                                                                                currency.val(0);
                                                                            }
                                                                        });

                                                                        $('.currencyField').each(function (key, value) {
                                                                            var inc = key + 1;
                                                                            var currency = $('#teamYtd_' + inc);
                                                                            if (currency.val != 0 || currency.val == '') {
                                                                                if (currency.val() != '') {
                                                                                    var decim = pad(currency.val());
                                                                                    currency.val(decim);
                                                                                    currency.val(inrFormat(currency.val()));
                                                                                }
                                                                            } else {
                                                                                currency.val(0);
                                                                            }
                                                                        });

                                                                        $(document).on("input", ".numberField", function (evt) {
                                                                            var self = $(this);
                                                                            self.val(self.val().replace(/[^0-9]/g, ''));
                                                                        });

                                                                        function pad(num) {
                                                                            var s = num + "";
                                                                            s = parseFloat(s, 10);
                                                                            return s;
                                                                        }

                                                                        $(document).on("input", ".numberField", function (evt) {
                                                                            var sum = 0;
                                                                            var ytd_sum = 0;

                                                                            $('.numberField').each(function (key, value) {
                                                                                var int = $(this).parents().parents('tr').attr('id');

                                                                                var arr = int.split('team_tr_');
                                                                                var inc = arr[1];
                                                                                var currency = $(this);
                                                                                if (currency.val != 0 || currency.val == '') {
                                                                                    if (currency.val() != '') {
//                                                                                        var decim = pad(currency.val());
//                                                                                        currency.val(decim);
                                                                                        currency.val(inrFormat(currency.val()));
                                                                                    }
                                                                                } else {
                                                                                    currency.val(0);
                                                                                }
                                                                                var total = $('#tot_ytd_' + inc).val();
                                                                                var cost = $('#current_number_' + inc).val();
                                                                                var totalVal = Number(total.replace(/[^0-9.-]+/g, ""));
                                                                                var currencyVal = Number(cost.replace(/[^0-9.-]+/g, ""));

                                                                                var new_ytd = parseInt(totalVal) + parseInt(currencyVal);
                                                                                $('#teamYtd_' + inc).val(inrFormat(new_ytd));

                                                                                var amount = $(this).val();
                                                                                sum += Number(amount.replace(/[^0-9.-]+/g, ""));

                                                                                var actual_ytd = $('#teamYtd_' + inc).val();
                                                                                ytd_sum += Number(actual_ytd.replace(/[^0-9.-]+/g, ""));
                                                                            });
                                                                            $('#totalValue').val(inrFormat(sum));
                                                                            $('#totalYTD').val(inrFormat(ytd_sum));

                                                                            //                                                                                $('.currencyField').each(function (key, value) {
                                                                            //                                                                                    var inc = key + 1;
                                                                            //                                                                                    var actual_ytd = $('#teamYtd_' + inc).val();
                                                                            //                                                                                    ytd_sum += Number(actual_ytd.replace(/[^0-9.-]+/g, ""));
                                                                            //                                                                                });
                                                                            //                                                                                $('#totalYTD').val(inrFormat(ytd_sum));
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

                                                                        $('#deleteRecord').on('click', function () {
                                                                            var impt = $('#team_val').val();
                                                                            var deleteId = $('#deleteID').val();
                                                                            var deleteName = $('#deleteName').val();
                                                                            $('#team_tr_' + impt).remove();

                                                                            var inv_id = $('#innovation_id').val();
                                                                            var fin_year = $('#current_year').val();
                                                                            var cur_month = $('#current_month').val();
//                                                                            console.log(cur_month);

                                                                            if (!$('.team_more').length) {
                                                                                var datas = '<tr id="team_tr_1" class="team_more"><td><div class="form-group">';
                                                                                datas += '<input type="text" class="form-control form-control-sm" id="team_name_1" name="team_name[]" value=""><input type="hidden" id="tot_ytd_1" value=""></div></td>';
                                                                                datas += '<td><div class="form-group"><input type="text" class="form-control form-control-sm currencyField readOnly" readonly="" placeholder="0" id="teamYtd_1" name="team_ytd[]" value=""></div></td>';
                                                                                datas += '<td><div class="form-group"><input class="form-control form-control-sm numberField" type="text" placeholder="00" name="current_number[]" id="current_number_1"></div></td><td></td>';
                                                                                $('#team_add').append(datas);
                                                                            }
                                                                            $('#deletemodal').modal('hide');
                                                                            $.ajax({
                                                                                type: "POST",
                                                                                url: "<?php echo base_url(); ?>index.php/portfolio/pending_inputs/deleteTeamHiring",
                                                                                data: {
                                                                                    name: deleteName,
                                                                                    inv_id: inv_id,
                                                                                    fin_year: fin_year,
                                                                                    cur_month: cur_month,
                                                                                    table: 'plan_team_hiring'
                                                                                },
                                                                                dataType: 'json',
                                                                                success: function (msg) {
                                                                                    $('#accordion').load(location.href + ' #accordion');
                                                                                    $('#deletemodal').modal('hide');
                                                                                    $('#deleteMsg').show();
                                                                                    setTimeout(function () {
                                                                                        onLoad();
                                                                                    }, 500);
                                                                                    setTimeout(function () {
                                                                                        $('#deleteMsg').hide();
                                                                                    }, 3000);
                                                                                }
                                                                            });
                                                                        });

                                                                        $(document).on('click', ".saveContinue", function (e) {
                                                                            if ($('#hiringPlanForm').valid()) {
                                                                                $('.saveContinue').css('pointer-events', 'none');
                                                                                $('#hiringPlanForm').submit();
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