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
        $this->load->view('pending_inputs/header.php', array('page_title' => 'Mentor Plan', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name));
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
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right"">
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
                                                    <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/mentor_plan/' . $innovation_id . '/' . $monthNumber; ?>">
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
                                                    <li class="sidebar-dropdown no-arrow">
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
                                                    <li class="sidebar-dropdown no-arrow active">
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
                                            <div class="col-xl-10 col-lg-10 col-md-10 col-12">
                                                <?php
                                                if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
                                                    $next_financial = $current_financial + 1;
                                                } else {
                                                    $next_financial = $current_financial;
                                                }
                                                ?>
                                                <h4>Mentor Hours > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
                                            </div>
                                            <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-12 text-right">
                                                    <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <hr class="cofig-spliter">
                                        <div class="inputplan-structure plan-structure-new">
                                            <form method="post" id="mentorPlanForm" action="<?php echo base_url() . 'index.php/portfolio/pending_inputs/addMentorPlan'; ?>" autocomplete="off">
                                                <input type='hidden' name='innovation_id' value="<?= $innovation_id; ?>">
                                                <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 vil-Deals portfolio-table">
                                                        <table class="tableresponsive table-inputmentor input-fundtable mar-tp0">
                                                            <thead>
                                                                <tr>
                                                                    <th width="20%">Mentor Assigned</th>
                                                                    <th width="15%">Hours Spent</th>
                                                                    <th width="30%">Requirement / Purpose</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $j = 1;
                                                                $men_data = $mentor_master[0];
                                                                $mentorData_count = isset($men_data) ? count($mentor_master) : 1;
                                                                if (count($mentor_master) != 0) {
                                                                    for ($i = 0; $i < $mentorData_count; $i++) {
                                                                        $master['id'] = $mentor_master[$i]['master_id'];
                                                                        $get_emp = $this->Mportfolio->getMentorsInput('port_villgro_relation_mentor', $master, '3');


                                                                        $cond['config_id'] = $mentor_master[$i]['id'];
                                                                        $cond['inv_id'] = $mentor_master[$i]['inv_id'];
                                                                        $cond['financial_year'] = $mentor_master[$i]['financial_year'];
                                                                        $cond['month'] = $current_month;
                                                                        $get_data = $this->Mportfolio->getMentorsInput('plan_mentor', $cond, '3');
                                                                        ?>
                                                                        <tr>
                                                                            <td width="20%" valign="top">
                                                                                <div class="form-group">
                                                                                    <select class="form-control form-control-sm mentorDiv readOnly" readonly="" name="name[]" id="mentor_name_<?php echo $j; ?>">
                                                                                        <option value="">-Select-</option>
                                                                                        <?php
                                                                                        foreach ($emp_mentors as $emps) {
                                                                                            if ($get_emp[0]['name'] == $emps['emp_number']) {
                                                                                                $selected = 'selected';
                                                                                            } else {
                                                                                                $selected = '';
                                                                                            }
                                                                                            ?>
                                                                                            <option value="<?php echo $emps['emp_number']; ?>" <?= $selected; ?> ><?php echo $emps['emp_name']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                            <td width="15%" valign="top">
                                                                                <div class="form-group">
                                                                                    <input class="form-control form-control-sm numberField" maxlength="6" type="text" name="hours_spent[]" id="hours_spent_<?php echo $j; ?>" value="<?= $get_data[0]['hours_spent']; ?>">
                                                                                </div>
                                                                            </td>
                                                                            <td width="30%" valign="top">
                                                                                <div class="form-group">
                                                                                    <textarea class="form-control form-control-sm description" maxlength="250" row="3" name="purpose[]" id="purpose_<?php echo $j; ?>"><?= $get_data[0]['purpose']; ?></textarea>
                                                                                </div>
                                                                            </td>
                                                                            <td width="35%"></td>
                                                                    <input type='hidden' name="mentor_id[]" id='mentor_id_<?php echo $j; ?>' value='<?= $get_data[0]['id']; ?>'>
                                                                    <input type="hidden" name="config_id[]" value="<?= $mentor_master[$i]['id']; ?>">
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

        <input type="hidden" id="enableCount" value="<?= count($mentor_plan); ?>">

        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>

        <script type="text/javascript">

            $(document).ready(function () {
                var editOpt = $('#enableCount').val();
                if (editOpt > 0) {
                    $('input[type="text"], textarea').attr('readonly', 'readonly');
                }
                $('select').css('pointer-events', 'none');
                $('#editBtn').addClass('opacity5');
            });

            $(document).on('click', '#editBtn', function () {
                $('input[type="text"], textarea').attr('readonly', false);
                $('.readOnly').attr('readonly', true);
                $('#editBtn').removeClass('opacity5');
            });

            function pad(num) {
                var s = num + "";
                s = parseFloat(s, 10);
                return s;
            }

            $(".numberField").on("blur", function (evt) {
                var self = $(this);
                self.val(self.val().replace(/[^0-9\.]/g, ''));

                if (self.val().split('.').length >= 3) {
                    self.val('');
                }

                var n = self.val();
                n = (n + "").split(".")[1];
                if (n == undefined) {
                    var flval = parseFloat(self.val());
                    var self_val = Number(flval.toFixed(2));
                    var decim = pad(self_val);
                    self.val(decim);
                    if (self_val >= 0 || self_val == '') {
                        self.val(self_val);
                    } else {
                        self.val(0);
                    }
                } else if (n.length == 1) {
                    var flval = parseFloat(self.val());
                    var self_val = Number(flval.toFixed(2));
                    var decim = pad(self_val);
                    self.val(decim);
                    var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{1}/i);
                    var matchedString = self.val().match(patt);
                    if (matchedString) {
                        var self_val = Number.parseFloat(matchedString).toFixed(1);
                        self.val(self_val);
                    }
                } else {
                    var flval = parseFloat(self.val());
                    var self_val = Number(flval.toFixed(2));
                    var decim = pad(self_val);
                    self.val(decim);
                    var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
                    var matchedString = self.val().match(patt);
                    if (matchedString) {
                        var self_val = Number.parseFloat(matchedString).toFixed(2);
                        if (self_val > 0) {
                            self.val(self_val);
                        }
                    }
                }
            });

            $(".description").on("input", function (evt) {
                var self = $(this);
                self.val(self.val().replace(/[^a-zA-Z0-9., &]/g, ''));
            });

            $(document).on('click', ".saveContinue", function (e) {
                if ($('#mentorPlanForm').valid()) {
                    $('.saveContinue').css('pointer-events', 'none');
                    $('#mentorPlanForm').submit();
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