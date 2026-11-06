<?php
$company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
$quater_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_month = array("1" => 'Jan', "2" => 'Feb', "3" => 'Mar', "4" => 'Apr', "5" => 'May', "6" => 'Jun', "7" => 'Jul', "8" => 'Aug', "9" => 'Sep', "10" => 'Oct', "11" => 'Nov', "12" => 'Dec');
$actual_quarter = $this->Mportfolio->monthByQuarters();
$get_quarter_fieldName = array("Q1" => 'q_one_desc', "Q2" => 'q_two_desc', "Q3" => 'q_three_desc', "Q4" => 'q_four_desc');
$get_quarter_monthField = array("1" => 'jan_desc', "2" => 'feb_desc', "3" => 'mar_desc', "4" => 'apr_desc', "5" => 'may_desc', "6" => 'jun_desc', "7" => 'jul_desc', "8" => 'aug_desc', "9" => 'sep_desc', "10" => 'oct_desc', "11" => 'nov_desc', "12" => 'dec_desc');

$plan = $qual_achieve[0];
$last_month = date("F", mktime(0, 0, 0, $current_month, 1));

$reg_city = isset($plan_header) ? $plan_header['company_data'][0]['reg_city'] : '';
$sector_name = isset($plan_header) ? $plan_header['sector_name'] : '';
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Achievement', 'company_name' => $company_name, 'port_action' => 'actual', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'fin_year' => $current_financial, 'add_class' => 'mar-tp150'));
?>
<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Record(s) deleted successfully</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill newIncubatesTabs" id="nav-tab" role="tablist">
                        <div class="new-nav-changes">
                            <div class="new-changes-head"> &nbsp</div>

                            <a class="nav-item nav-link  " id="nav-Companymaster-tab"    href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>"  aria-controls="nav-Companymaster" aria-selected="true" style="margin-right: 15px;position: relative;">Updates</a>
                        </div>
                        <div class="new-nav-changes1"><div class="new-changes-head1"> Portfolio Information</div>
                            <a class="nav-item nav-link" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/product/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-business" aria-selected="false">Product &amp; Sales</a>
                            <a class="nav-item nav-link active" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/finance/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>" aria-controls="nav-management" aria-selected="false">03</a>
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
                                    <h4>Finance &amp; Follow-on Fundraise</h4>
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
                                <?php $this->load->view('all_forms/left_menu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'fundraise', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
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
                                        <h4>Fundraise > <span><?= $last_month . ' ' . $next_financial; ?></span></h4>
                                    </div>
                                    <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                            <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="qualitEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/finance/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Finances</a></li>
                                            <li class="tab-slider--triggerform"><a href="<?= base_url() . 'index.php/portfolio/all_forms/loans/' . $innovation_id . '/' . $current_financial . '/' . $current_month; ?>">Loans & Working Capital</a></li>
                                            <li class="tab-slider--triggerform active"><a href="javascript:void(0)">Fundraise</a></li>
                                            <?php if ($this->session->userdata['currency'] == 'INR') { ?>
                                                <p class="currencyNotify"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
                                            <?php } else { ?>
                                                <p class="currencyNotify"><span class="text-danger">*</span> All <?= $this->session->userdata['currency']; ?> amounts are in '000's.</p>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                                $current_quarter = $actual_quarter[$current_month];
                                $total_qualPlan = $get_quarter_fieldName[$current_quarter];
                                $monthly_qualPlan = $get_quarter_monthField[$current_month];
                                ?>
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new" id="accordion">
                                                <form method="post" id="fundPlanForm" action="<?php echo base_url() . 'index.php/portfolio/all_forms/addFundraisePlan'; ?>" autocomplete="off">
                                                    <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                    <input type='hidden' name='current_year' id="current_year" value="<?= $current_financial; ?>">
                                                    <input type='hidden' name='current_month' id="current_month" value="<?= $current_month; ?>">
                                                    <input type='hidden' name='module_id' id="module_id" value="8">
                                                   
                                                    <hr>
                                                    <div class="row" id="equityContent">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                            <div class="table_configcontentinput">
                                                                <div class="tabpanel-title">
                                                                    <div class="row">
                                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-12">
                                                                            <h4>Equity Amount</h4>
                                                                        </div>
                                                                        <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-12 text-right">
                                                                                <ul class="milestone-links">
                                                                                    <li>
                                                                                        <a href="javascript:void(0)" id="equityMore"><i class="fas fa-plus-circle"></i> Add New</a>
                                                                                    </li>
                                                                                    <li class="brd-left-onboard">
                                                                                        <a href="javascript:void(0)" id="equityEdit"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                                                    </li>
                                                                                    <li class="brd-left-onboard" id="disableEquity">
                                                                                        <a class="deleteControl" id="equityDelete" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 vil-Deals portfolio-table">
                                                                        <table class="input-fundtable">
                                                                            <tbody class="add_more_equity">
                                                                                <?php
                                                                                $equity_data = $equity_plan[0];
                                                                                $equity_count = isset($equity_data) ? php72_count($equity_plan) : 1;
                                                                                for ($i = 0; $i < $equity_count; $i++) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div class="input-group">
                                                                                                <input type="checkbox" class="check_box equityBox" onclick="deleteEquity();" name="equity_delete" value="<?= $equity_plan[$i]['id']; ?>">
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="pad-lf0">
                                                                                            <div class="form-group width150">
                                                                                                <input class="form-control form-control-sm equityName" placeholder="Investor" maxlength="50" type="text" name="equity_name[]" id="equity_name" value="<?php echo $equity_plan[$i]['name']; ?>">
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <ul class="milestone-linksec">
                                                                                                <li class="pad-lf0">
                                                                                                    <div class="form-group width150">
                                                                                                        <input class="form-control form-control-sm equityValue currencyField" maxlength="20" type="text" name="equity_value[]" id="equity_value" value="<?php echo $equity_plan[$i]['value']; ?>">
                                                                                                    </div>
                                                                                                </li>
                                                                                                <li class="pad-rt0"><?= $this->session->userdata['currency']; ?></li>
                                                                                            </ul>
                                                                                        </td>
                                                                                    </tr>
                                                                                <input type="hidden" name="equity_id[]" value="<?php echo $equity_plan[$i]['id']; ?>" />
                                                                            <?php } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 vil-Deals portfolio-table">
                                                                        <table class="input-fundtable">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><label>Total</label></td>
                                                                                    <td>
                                                                                        <ul class="milestone-linksec">
                                                                                            <li class="pad-lf0">
                                                                                                <div class="form-group width150">
                                                                                                    <input class="form-control form-control-sm equityTotal readOnly" readonly="" type="text" name="equity_total" id="equity_total" value="<?= $equity_plan[0]['equity_total']; ?>">
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="pad-rt0"><?= $this->session->userdata['currency']; ?></li>
                                                                                        </ul>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="grandContent">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                            <div class="table_configcontentinput">
                                                                <div class="tabpanel-title">
                                                                    <div class="row">
                                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-12">
                                                                            <h4>Grant Funding</h4>
                                                                        </div>
                                                                        <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-12 text-right">
                                                                                <ul class="milestone-links">
                                                                                    <li>
                                                                                        <a href="javascript:void(0)" id="grandMore"><i class="fas fa-plus-circle"></i> Add New</a>
                                                                                    </li>
                                                                                    <li class="brd-left-onboard">
                                                                                        <a href="javascript:void(0)" id="grandEdit"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                                                    </li>
                                                                                    <li class="brd-left-onboard" id="disableGrand">
                                                                                        <a class="deleteControl" id="grandDelete" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 vil-Deals portfolio-table">
                                                                        <table class="input-fundtable">
                                                                            <tbody class="add_more_grand">
                                                                                <?php
                                                                                $grand_data = $grand_plan[0];
                                                                                $grand_count = isset($grand_data) ? php72_count($grand_plan) : 1;
                                                                                for ($i = 0; $i < $grand_count; $i++) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div class="input-group">
                                                                                                <input type="checkbox" class="check_box grandBox" onclick="deleteGrand();" name="grand_delete" value="<?= $grand_plan[$i]['id']; ?>">
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="pad-lf0">
                                                                                            <div class="form-group width150">
                                                                                                <input class="form-control form-control-sm grandName" placeholder="Investor" maxlength="50" type="text" name="grand_name[]" id="grand_name" value="<?php echo $grand_plan[$i]['name']; ?>">
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <ul class="milestone-linksec">
                                                                                                <li class="pad-lf0">
                                                                                                    <div class="form-group width150">
                                                                                                        <input class="form-control form-control-sm grandValue currencyField" maxlength="20" type="text" name="grand_value[]" id="grand_value" value="<?php echo $grand_plan[$i]['value']; ?>">
                                                                                                    </div>
                                                                                                </li>
                                                                                                <li class="pad-rt0"><?= $this->session->userdata['currency']; ?></li>
                                                                                            </ul>
                                                                                        </td>
                                                                                    </tr>
                                                                                <input type="hidden" name="grand_id[]" value="<?php echo $grand_plan[$i]['id']; ?>" />
                                                                            <?php } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 vil-Deals portfolio-table">
                                                                        <table class="input-fundtable">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><label>Total</label></td>
                                                                                    <td>
                                                                                        <ul class="milestone-linksec">
                                                                                            <li class="pad-lf0">
                                                                                                <div class="form-group width150">
                                                                                                    <input class="form-control form-control-sm grandTotal readOnly" readonly="" type="text" name="grand_total" id="grand_total" value="<?= $grand_plan[0]['grand_total']; ?>">
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="pad-rt0"><?= $this->session->userdata['currency']; ?></li>
                                                                                        </ul>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="shortContent">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                            <div class="table_configcontentinput">
                                                                <div class="tabpanel-title">
                                                                    <div class="row">
                                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-12">
                                                                            <h4>Debt</h4>
                                                                        </div>
                                                                        <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-12 text-right">
                                                                                <ul class="milestone-links">
                                                                                    <li>
                                                                                        <a href="javascript:void(0)" id="shortMore"><i class="fas fa-plus-circle"></i> Add New</a>
                                                                                    </li>
                                                                                    <li class="brd-left-onboard">
                                                                                        <a href="javascript:void(0)" id="shortEdit"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                                                    </li>
                                                                                    <li class="brd-left-onboard" id="disableShort">
                                                                                        <a class="deleteControl" id="shortDelete" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 vil-Deals portfolio-table">
                                                                        <table class="input-fundtable">
                                                                            <tbody class="add_more_short">
                                                                                <?php
                                                                                $short_data = $short_plan[0];
                                                                                $short_count = isset($short_data) ? php72_count($short_plan) : 1;
                                                                                for ($i = 0; $i < $short_count; $i++) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div class="input-group">
                                                                                                <input type="checkbox" class="check_box shortBox" onclick="deleteShort();" name="short_delete" value="<?php echo $short_plan[$i]['id']; ?>">
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="pad-lf0">
                                                                                            <div class="form-group width150">
                                                                                                <input class="form-control form-control-sm shortName" placeholder="Lender" maxlength="50" type="text" name="short_name[]" id="short_name" value="<?php echo $short_plan[$i]['name']; ?>">
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <ul class="milestone-linksec">
                                                                                                <li class="pad-lf0">
                                                                                                    <div class="form-group width150">
                                                                                                        <input class="form-control form-control-sm shortValue currencyField" maxlength="20" type="text" name="short_value[]" id="short_value" value="<?php echo $short_plan[$i]['value']; ?>">
                                                                                                    </div>
                                                                                                </li>
                                                                                                <li class="pad-rt0"><?= $this->session->userdata['currency']; ?></li>
                                                                                            </ul>
                                                                                        </td>
                                                                                    </tr>
                                                                                <input type="hidden" name="short_id[]" value="<?php echo $short_plan[$i]['id']; ?>" />
                                                                            <?php } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 vil-Deals portfolio-table">
                                                                        <table class="input-fundtable">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><label>Total</label></td>
                                                                                    <td>
                                                                                        <ul class="milestone-linksec">
                                                                                            <li>
                                                                                                <div class="form-group width150">
                                                                                                    <input class="form-control form-control-sm shortTotal readOnly" readonly="" type="text" name="short_total" id="short_total" value="<?= $short_plan[0]['short_total']; ?>">
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="pad-rt0"><?= $this->session->userdata['currency']; ?></li>
                                                                                        </ul>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--<div class="row" id="longContent">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                            <div class="table_configcontentinput">
                                                                <div class="tabpanel-title">
                                                                    <div class="row">
                                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-12">
                                                                            <h4>Long Term</h4>
                                                                        </div>
                                                                        <?php if (php72_cmp($isAssociate) == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-12 text-right">
                                                                                <ul class="milestone-links">
                                                                                    <li>
                                                                                        <a href="javascript:void(0)" id="longMore"><i class="fas fa-plus-circle"></i> Add New</a>
                                                                                    </li>
                                                                                    <li class="brd-left-onboard">
                                                                                        <a href="javascript:void(0)" id="longEdit"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                                                    </li>
                                                                                    <li class="brd-left-onboard" id="disableLong">
                                                                                        <a class="deleteControl" id="longDelete" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 vil-Deals portfolio-table">
                                                                        <table class="input-fundtable">
                                                                            <tbody class="add_more_long">
                                                                                <?php
                                                                                $long_data = $long_plan[0];
                                                                                $long_count = isset($long_data) ? php72_count($long_plan) : 1;
                                                                                for ($i = 0; $i < $long_count; $i++) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div class="input-group">
                                                                                                <input type="checkbox" class="check_box longBox" onclick="deleteLong();" name="long_delete" value="<?php echo $long_plan[$i]['id']; ?>">
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="pad-lf0">
                                                                                            <div class="form-group width150">
                                                                                                <input class="form-control form-control-sm longName" placeholder="Lender" maxlength="50" type="text" name="long_name[]" id="long_name" value="<?php echo $long_plan[$i]['name']; ?>">
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <ul class="milestone-linksec">
                                                                                                <li class="pad-lf0">
                                                                                                    <div class="form-group width150">
                                                                                                        <input class="form-control form-control-sm longValue currencyField" maxlength="20" type="text" name="long_value[]" id="long_value" value="<?php echo $long_plan[$i]['value']; ?>">
                                                                                                    </div>
                                                                                                </li>
                                                                                                <li class="pad-rt0"><?= $this->session->userdata['currency']; ?></li>
                                                                                            </ul>
                                                                                        </td>
                                                                                    </tr>
                                                                                <input type="hidden" name="long_id[]" value="<?php echo $long_plan[$i]['id']; ?>" />
                                                                            <?php } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 vil-Deals portfolio-table">
                                                                        <table class="input-fundtable">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><label>Total</label></td>
                                                                                    <td>
                                                                                        <ul class="milestone-linksec">
                                                                                            <li>
                                                                                                <div class="form-group width150">
                                                                                                    <input class="form-control form-control-sm longTotal readOnly" readonly="" type="text" name="long_total" id="long_total" value="<?= $long_plan[0]['long_total']; ?>">
                                                                                                </div>
                                                                                            </li>
                                                                                            <li class="pad-rt0"><?= $this->session->userdata['currency']; ?></li>
                                                                                        </ul>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
													<hr>
													<br><br>
													 <div class="row achievementNewComt">
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <p>Plan for <?= $current_quarter; ?></p>
                                                            <div class="form-group quaterlyCardnew fieldDisabled">
                                                                <textarea rows="3" disabled class="mceEditor" id="quarterDesc" name="quarterDesc"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_plan[0][$total_qualPlan])); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <p>Plan for <?= $last_month; ?></p>
                                                            <div class="form-group quaterlyCardnew fieldDisabled">
                                                                <textarea rows="3" class="mceEditor" id="monthContent" name='monthContent'><?= stripslashes(str_replace("\\r\\n", '', $qualitative_plan[0][$monthly_qualPlan])); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-ms-4 col-12">
                                                            <p>Enter achievement for <?= $last_month; ?></p>
                                                            <div class="form-group quaterlyCardnew" id="achieveField">
                                                                <textarea rows="3" class="mceEditorActive" id="achieveContent" name='achieveContent' autofocus><?= stripslashes(str_replace("\\r\\n", '', $plan['description'])); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
													
													
                                                </form>
                                                <input type="hidden" id="qualitCount" value="<?= php72_count($qual_achieve); ?>">
                                                <input type="hidden" id="equityCount" value="<?= php72_count($equity_plan); ?>">
                                                <input type="hidden" id="grandCount" value="<?= php72_count($grand_plan); ?>">
                                                <input type="hidden" id="shortCount" value="<?= php72_count($short_plan); ?>">
                                                <input type="hidden" id="longCount" value="<?= php72_count($long_plan); ?>">
                                                <input type="hidden" id="partnerCurrency" value="<?= $this->session->userdata['currency']; ?>">
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
                            <p>you are about delete <span id="delCount"></span> selected information fields, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="delName" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio', 'quantitative' => 'tiny')); ?>

<script type="text/javascript">
    $(window).on("load", function () {
        $('svg').attr("viewBox", "0 0 25 25");
        $('svg').css({"width": "20", "height": "20"});
    });

    tinyMCE.init({
        mode: "specific_textareas",
        editor_selector: "mceEditor",
        entity_encoding: "numeric",
        menubar: false,
        readonly: 1,
        toolbar: [
            ''
        ],
        valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li,br',
        powerpaste_word_import: 'clean',
        powerpaste_html_import: 'clean'
    });

    tinyMCE.init({
        mode: "specific_textareas",
        editor_selector: "mceEditorActive",
        entity_encoding: "numeric",
        menubar: false,
        //auto_focus: "achieveContent",
        plugins: [
            'lists'
        ],
        toolbar: [
            'bold italic | numlist bullist'
        ],
        valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li,br',
        powerpaste_word_import: 'clean',
        powerpaste_html_import: 'clean'
    });

    $(document).ready(function () {
        onLoad();
    });
    function onLoad() {
        var qualitOpt = $('#qualitCount').val();
        if (qualitOpt > 0) {
            tinymce.get('achieveContent').setMode('readonly');
            $('#achieveField').addClass('fieldDisabled');
        } else {
            $('#achieveField').addClass('greenplantxt');
        }
        var equityOpt = $('#equityCount').val();
        if (equityOpt > 0) {
            $('#equityContent input[type="text"]').attr('readonly', 'readonly');
        }
        var grandOpt = $('#grandCount').val();
        if (grandOpt > 0) {
            $('#grandContent input[type="text"]').attr('readonly', 'readonly');
        }
        var shortOpt = $('#shortCount').val();
        if (shortOpt > 0) {
            $('#shortContent input[type="text"]').attr('readonly', 'readonly');
        }
        var longOpt = $('#longCount').val();
        if (longOpt > 0) {
            $('#longContent input[type="text"]').attr('readonly', 'readonly');
        }
        $('#qualitEdit, #equityEdit, #grandEdit, #shortEdit, #longEdit, .deleteControl').addClass('opacity5');
        $('#disableEquity, #disableGrand, #disableShort, #disableLong').css("cursor", "not-allowed");
        $('#equityDelete, #grandDelete, #shortDelete, #longDelete').css("pointer-events", "none");

        var e_total = $('#equity_total').val();
        var e_sum = Number(e_total).toFixed(2);
        if (!isNaN(e_sum))
            $('#equity_total').val(inrFormat(e_sum));

        var g_total = $('#grand_total').val();
        var g_sum = Number(g_total).toFixed(2);
        if (!isNaN(g_sum))
            $('#grand_total').val(inrFormat(g_sum));

        var s_total = $('#short_total').val();
        var s_sum = Number(s_total).toFixed(2);
        if (!isNaN(s_sum))
            $('#short_total').val(inrFormat(s_sum));

        var l_total = $('#long_total').val();
        var l_sum = Number(l_total).toFixed(2);
        if (!isNaN(l_sum))
            $('#long_total').val(inrFormat(l_sum));

    }

    $(document).on('click', '#qualitEdit', function () {
        tinymce.get('achieveContent').setMode('design');
        $('#achieveField').addClass('greenplantxt');
        $('#achieveField').removeClass('fieldDisabled');
        $('#qualitEdit').removeClass('opacity5');
    });
    $(document).on('click', '#equityEdit', function () {
        $('#equityContent input[type="text"]').attr('readonly', false);
        $('.readOnly').attr('readonly', true);
        $('#equityEdit').removeClass('opacity5');
    });
    $(document).on('click', '#grandEdit', function () {
        $('#grandContent input[type="text"]').attr('readonly', false);
        $('.readOnly').attr('readonly', true);
        $('#grandEdit').removeClass('opacity5');
    });
    $(document).on('click', '#shortEdit', function () {
        $('#shortContent input[type="text"]').attr('readonly', false);
        $('.readOnly').attr('readonly', true);
        $('#shortEdit').removeClass('opacity5');
    });
    $(document).on('click', '#longEdit', function () {
        $('#longContent input[type="text"]').attr('readonly', false);
        $('.readOnly').attr('readonly', true);
        $('#longEdit').removeClass('opacity5');
    });
    $(document).on('click', '.equityBox', function () {
        if ($("#equityContent input:checkbox:checked").length > 0) {
            $('#disableEquity').css("cursor", "pointer");
            $('#equityDelete').css("pointer-events", "");
        } else {
            $('#disableEquity').css("cursor", "not-allowed");
            $('#equityDelete').css("pointer-events", "none");
        }
    });
    $(document).on('click', '.grandBox', function () {
        if ($("#grandContent input:checkbox:checked").length > 0) {
            $('#disableGrand').css("cursor", "pointer");
            $('#grandDelete').css("pointer-events", "");
        } else {
            $('#disableGrand').css("cursor", "not-allowed");
            $('#grandDelete').css("pointer-events", "none");
        }
    });
    $(document).on('click', '.shortBox', function () {
        if ($("#shortContent input:checkbox:checked").length > 0) {
            $('#disableShort').css("cursor", "pointer");
            $('#shortDelete').css("pointer-events", "");
        } else {
            $('#disableShort').css("cursor", "not-allowed");
            $('#shortDelete').css("pointer-events", "none");
        }
    });
    $(document).on('click', '.longBox', function () {
        if ($("#longContent input:checkbox:checked").length > 0) {
            $('#disableLong').css("cursor", "pointer");
            $('#longDelete').css("pointer-events", "");
        } else {
            $('#disableLong').css("cursor", "not-allowed");
            $('#longDelete').css("pointer-events", "none");
        }
    });
    function deleteEquity() {
        $(document).on('click', '.equityBox', function () {
            if ($("#equityContent input:checkbox:checked").length > 0) {
                $('#disableEquity').css("cursor", "pointer");
                $('#equityDelete').css("pointer-events", "");
            } else {
                $('#disableEquity').css("cursor", "not-allowed");
                $('#equityDelete').css("pointer-events", "none");
            }
        });
    }
    function deleteGrand() {
        $(document).on('click', '.grandBox', function () {
            if ($("#grandContent input:checkbox:checked").length > 0) {
                $('#disableGrand').css("cursor", "pointer");
                $('#grandDelete').css("pointer-events", "");
            } else {
                $('#disableGrand').css("cursor", "not-allowed");
                $('#grandDelete').css("pointer-events", "none");
            }
        });
    }
    function deleteShort() {
        $(document).on('click', '.shortBox', function () {
            if ($("#shortContent input:checkbox:checked").length > 0) {
                $('#disableShort').css("cursor", "pointer");
                $('#shortDelete').css("pointer-events", "");
            } else {
                $('#disableShort').css("cursor", "not-allowed");
                $('#shortDelete').css("pointer-events", "none");
            }
        });
    }
    function deleteLong() {
        $(document).on('click', '.longBox', function () {
            if ($("#longContent input:checkbox:checked").length > 0) {
                $('#disableLong').css("cursor", "pointer");
                $('#longDelete').css("pointer-events", "");
            } else {
                $('#disableLong').css("cursor", "not-allowed");
                $('#longDelete').css("pointer-events", "none");
            }
        });
    }
    $(document).on('click', '#equityDelete', function () {
        $('#deletemodal').modal('show');
        var sel_item = $("input:checkbox[name=equity_delete]:checked").length;
        $('#delCount').html(sel_item);
        $('#delName').val('equity_delete');
    });
    $(document).on('click', '#grandDelete', function () {
        $('#deletemodal').modal('show');
        var sel_item = $("input:checkbox[name=grand_delete]:checked").length;
        $('#delCount').html(sel_item);
        $('#delName').val('grand_delete');
    });
    $(document).on('click', '#shortDelete', function () {
        $('#deletemodal').modal('show');
        var sel_item = $("input:checkbox[name=short_delete]:checked").length;
        $('#delCount').html(sel_item);
        $('#delName').val('short_delete');
    });
    $(document).on('click', '#longDelete', function () {
        $('#deletemodal').modal('show');
        var sel_item = $("input:checkbox[name=long_delete]:checked").length;
        $('#delCount').html(sel_item);
        $('#delName').val('long_delete');
    });
    $(document).on('click', '#deleteRecord', function () {
        var deleteId = new Array();
        var name = $('#delName').val();
        $("input:checkbox[name=" + name + "]:checked").each(function () {
            deleteId.push($(this).val());
        });
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#current_year').val();
        var cur_month = $('#current_month').val();
        if ($("#fundPlanForm input:checkbox:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deletePendingFundraise",
                data: {
                    id: deleteId,
                    inv_id: inv_id,
                    fin_year: fin_year,
                    cur_month: cur_month,
                    table: 'plan_fundraise'
                },
                dataType: 'json',
                success: function (msg) {
                    $('#accordion').load(location.href + ' #accordion');
                    $('#deletemodal').modal('hide');
                    $('#deleteMsg').show();
                    setTimeout(function () {
                        onLoad();
                        deleteEquity();
                        deleteGrand();
                        deleteShort();
                        deleteLong();
                    }, 500);
                    setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000);
                }
            });
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

    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/all_forms/fundraise/' + inv_id + '/' + year;
    }

    $(document).on('click', '#equityMore', function () {
        var lengthDiv = $('.add_more_equity').find('tr').length;
        var currency = $('#partnerCurrency').val();
        var data = '<tr>';
        data += '<td><div class="input-group"><input type="checkbox" class="check_box" name="equity_delete" value=""></div></td>';
        data += '<td class="pad-lf0"><div class="form-group width150"><input class="form-control form-control-sm equityName" maxlength="50" type="text" name="equity_name[]" id="equity_name' + lengthDiv + '" value="" placeholder="Investor" ></div></td>';
        data += '<td><ul class="milestone-linksec"><li class="pad-lf0"><div class="form-group width150"><input class="form-control form-control-sm equityValue currencyField" maxlength="20" type="text" name="equity_value[]" id="equity_value' + lengthDiv + '" value=""></div></li><li style="padding-left: 3px;">' + currency + '</li></ul></td>';
        data += '</tr>';
        $('.add_more_equity').append(data);
    });
    $(document).on('click', '#grandMore', function () {
        var lengthDiv = $('.add_more_grand').find('tr').length;
        var currency = $('#partnerCurrency').val();
        var data = '<tr>';
        data += '<td><div class="input-group"><input type="checkbox" class="check_box" name="grand_delete" value=""></div></td>';
        data += '<td class="pad-lf0"><div class="form-group width150"><input class="form-control form-control-sm grandName" maxlength="50" type="text" name="grand_name[]" id="grand_name' + lengthDiv + '" value="" placeholder="Investor" ></div></td>';
        data += '<td><ul class="milestone-linksec"><li class="pad-lf0"><div class="form-group width150"><input class="form-control form-control-sm grandValue currencyField" maxlength="20" type="text" name="grand_value[]" id="grand_value' + lengthDiv + '" value=""></div></li><li style="padding-left: 3px;">' + currency + '</li></ul></td>';
        data += '</tr>';
        $('.add_more_grand').append(data);
    });
    $(document).on('click', '#shortMore', function () {
        var lengthDiv = $('.add_more_short').find('tr').length;
        var currency = $('#partnerCurrency').val();
        var data = '<tr>';
        data += '<td><div class="input-group"><input type="checkbox" class="check_box" name="short_delete" value=""  ></div></td>';
        data += '<td class="pad-lf0"><div class="form-group width150"><input class="form-control form-control-sm shortName" maxlength="50" type="text" name="short_name[]" id="short_name' + lengthDiv + '" value="" placeholder="Lender"></div></td>';
        data += '<td><ul class="milestone-linksec"><li class="pad-lf0"><div class="form-group width150"><input class="form-control form-control-sm shortValue currencyField" maxlength="20" type="text" name="short_value[]" id="short_value' + lengthDiv + '" value=""></div></li><li style="padding-left: 3px;">' + currency + '</li></ul></td>';
        data += '</tr>';
        $('.add_more_short').append(data);
    });
    $(document).on('click', '#longMore', function () {
        var lengthDiv = $('.add_more_long').find('tr').length;
        var currency = $('#partnerCurrency').val();
        var data = '<tr>';
        data += '<td><div class="input-group"><input type="checkbox" class="check_box" name="long_delete" value=""></div></td>';
        data += '<td class="pad-lf0"><div class="form-group width150"><input class="form-control form-control-sm longName" maxlength="50" type="text" name="long_name[]" id="long_name' + lengthDiv + '" value="" placeholder="Lender" ></div></td>';
        data += '<td><ul class="milestone-linksec"><li class="pad-lf0"><div class="form-group width150"><input class="form-control form-control-sm longValue currencyField" maxlength="20" type="text" name="long_value[]" id="long_value' + lengthDiv + '" value=""></div></li><li style="padding-left: 3px;">' + currency + '</li></ul></td>';
        data += '</tr>';
        $('.add_more_long').append(data);
    });
    $(document).on("keyup", ".equityValue", function (evt) {
        var sum = 0;
        $('.equityValue').each(function (key, value) {
            var amount = $(this).val();
            sum += Number(amount.replace(/[^0-9.-]+/g, ""));
        });
        var sum_val = Number(sum).toFixed(2);
        if (!isNaN(sum_val))
            $('#equity_total').val(inrFormat(sum_val));
    });
    $(document).on("keyup", ".grandValue", function (evt) {
        var sum = 0;
        $('.grandValue').each(function (key, value) {
            var amount = $(this).val();
            sum += Number(amount.replace(/[^0-9.-]+/g, ""));
        });
        var sum_val = Number(sum).toFixed(2);
        if (!isNaN(sum_val))
            $('#grand_total').val(inrFormat(sum_val));
    });
    $(document).on("keyup", ".shortValue", function (evt) {
        var sum = 0;
        $('.shortValue').each(function (key, value) {
            var amount = $(this).val();
            sum += Number(amount.replace(/[^0-9.-]+/g, ""));
        });
        var sum_val = Number(sum).toFixed(2);
        if (!isNaN(sum_val))
            $('#short_total').val(inrFormat(sum_val));
    });
    $(document).on("keyup", ".longValue", function (evt) {
        var sum = 0;
        $('.longValue').each(function (key, value) {
            var amount = $(this).val();
            sum += Number(amount.replace(/[^0-9.-]+/g, ""));
        });
        var sum_val = Number(sum).toFixed(2);
        if (!isNaN(sum_val))
            $('#long_total').val(inrFormat(sum_val));
    });
    $(document).on('click', ".saveContinue", function (e) {
        if ($('#fundPlanForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#fundPlanForm').submit();
        }
    });
    $('.plan-structure-new').css({'height': (($(window).height()) - 380) + 'px'});
</script>

</body>
</html>
