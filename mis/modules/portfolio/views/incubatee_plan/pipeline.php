<?php
$innovation = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $innovation['name_of_enterprise'];

$pipeline = $pipe_data[0];
$reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Plan', 'company_name' => $company_name, 'port_action' => 'plan', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'fin_year' => $current_financial, 'add_class' => 'mar-tp140'));

$get_open = json_decode($pipeline['open_pipeline']);
$get_under = json_decode($pipeline['under_discussion']);
$get_reject = json_decode($pipeline['closed_pipeline']);
$get_convert = json_decode($pipeline['converted_pipeline']);

if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
    $notify_icon = isset($dataConfig) ? $dataConfig : '';
} else {
    $notify_icon = '';
}
$field_enable = '0';
?>

<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <?php if ($this->session->userdata['approve_success'] == '1') { ?>
        <div id="approveMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Pipeline details approved successfully</div>
    <?php } ?>
    <?php if ($this->session->userdata['approve_success'] == '2') { ?>
        <div id="approveallMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;All plan details are approved successfully</div>
    <?php } ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab"  href="<?= base_url() . 'index.php/portfolio/company_data/' . $innovation_id; ?>"  aria-selected="false">Company Master Data</a>
                        <a class="nav-item nav-link filled-data" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/business_nature/' . $innovation_id; ?>" aria-controls="nav-business" aria-selected="false">Nature of business</a>
                        <a class="nav-item nav-link filled-data" id="nav-management-tab"  href="<?= base_url() . 'index.php/portfolio/management/' . $innovation_id; ?>" aria-controls="nav-management" aria-selected="false">Management</a>
                        <a class="nav-item nav-link filled-data" id="nav-governance-tab"  href="<?= base_url() . 'index.php/portfolio/governance/' . $innovation_id; ?>" aria-controls="nav-governance" aria-selected="false">Governance</a>
                        <a class="nav-item nav-link filled-data" id="nav-relationship-tab" href="<?= base_url() . 'index.php/portfolio/villgro_relationship/' . $innovation_id; ?>" aria-controls="nav-relationship" aria-selected="false">Villgro Relationship Details</a>
                        <a class="nav-item nav-link filled-data" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/incubation_relationship/' . $innovation_id; ?>"   aria-controls="nav-incubation" aria-selected="false">Incubation Relationship</a>
                        <a class="nav-item nav-link filled-data" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/cap_table/' . $innovation_id; ?>"   aria-controls="nav-cap" aria-selected="false">Cap Table</a>
                        <a class="nav-item nav-link filled-data" id="nav-interested-tab" href="<?= base_url() . 'index.php/portfolio/interested_parties/' . $innovation_id; ?>" aria-controls="nav-interested" aria-selected="false">Other Interested Parties</a>
                        <a class="nav-item nav-link bg-trasnparent brd-none" id="nav-about-tab"  href="#nav-about"  aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                        <a class="nav-item nav-link dataConfig active" id="nav-dataconfig-tab"  href="javascript:void(0)" role="tab" aria-controls="nav-dataconfig" aria-selected="false">Plan Setup</a>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-business" role="tabpanel" aria-labelledby="nav-business-tab">
                        <div class="tabpanel-title">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <h4>Define the annual plan for <?= $company_name; ?></h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right">
                                    <ul class="milestone-links">
                                        <?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && ($approvals[0]['product_approval'] == 2 || $approvals[0]['sales_approval'] == 2 || $approvals[0]['channel_approval'] == 2 || $approvals[0]['pipeline_approval'] == 2 || $approvals[0]['revenue_approval'] == 2 || $approvals[0]['netprofit_approval'] == 2 || $approvals[0]['vif_approval'] == 2 || $approvals[0]['fundraise_approval'] == 2 || $approvals[0]['mentor_approval'] == 2 || $approvals[0]['tap_approval'] == 2 || $approvals[0]['nontap_approval'] == 2 || $approvaless[0]['dp_approval'] == 2 || $approvaless[0]['board_approval'] == 2 || $approvaless[0]['team_approval'] == 2 || $approvals[0]['impact_approval'] == 2 || $approvals[0]['project_approval'] == 2)) { ?>
                                            <li><a class="approveall" href="javascript:void(0);">Approve All</a></li>
                                        <?php } ?>
                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                            <li><a class="saveContinue" href="javascript:void(0);">Save</a></li>
                                            <?php
                                            $field_enable = '1';
                                        }
                                        ?>
                                        <?php if ($this->session->userdata['sector_lead'] == 1 && $isAssociate == 1 && $approvals[0]['config_approval'] == 1) { ?>
                                            <li><a class="sendApprovalBtn" id="lead_approveall" href="javascript:void(0);">Send for Approval</a></li>
                                        <?php } else if (($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['config_approval'] == 1) { ?>
                                            <li><a class="sendApproval sendApprovalBtn" id="sendApproval" href="javascript:void(0);">Send for Approval</a></li>
                                        <?php } ?>
                                        <li>
                                            <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend"><i class="far fa-question-circle"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tabpanel-detailsconfig config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('config_left_menu.php', array('class_name' => 'pipeDiv', 'configData' => $dataConfig, 'approvals' => $approvals, 'fin_year' => $current_financial)); ?>
                            </div>
                            <main class="page-content" id="pageContent">
                                <div class="row dataconfig">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad0">
                                        <h4>Product &amp; Sales</h4>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                        <div class="config-sales">
                                            <label>Financial Year</label>
                                            <div class="form-group">
                                                <select class="form-control form-control-sm" name="financial_year" id="financial_year" onchange="loadYear(this.value);">
                                                    <?php
                                                    foreach ($fin_year as $year) {
                                                        $nxt_fyear = $year['fin_year'] + 1;
                                                        ?>
                                                        <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_financial) && $current_financial == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <li class="tab-slider--triggerform "><a href="<?= base_url() . 'index.php/portfolio/product/' . $innovation_id . '/' . $current_financial; ?>">Product&nbsp;
                                                    <?php if ($notify_icon != '' && $approvals[0]['product_approval'] == 2) { ?>
                                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                                    <?php } ?>
                                                </a></li>
                                            <li class="tab-slider--triggerform "><a href="<?= base_url() . 'index.php/portfolio/sales/' . $innovation_id . '/' . $current_financial; ?>">Sales&nbsp;
                                                    <?php if ($notify_icon != '' && $approvals[0]['sales_approval'] == 2) { ?>
                                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                                    <?php } ?>
                                                </a></li>
                                            <li class="tab-slider--triggerform "><a href="<?= base_url() . 'index.php/portfolio/channel/' . $innovation_id . '/' . $current_financial; ?>">Channel
                                                    &nbsp;
                                                    <?php if ($notify_icon != '' && $approvals[0]['channel_approval'] == 2) { ?>
                                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                                    <?php } ?>
                                                </a></li>
                                            <li class="tab-slider--triggerform active"><a href="javascript:void(0)">Pipeline&nbsp;
                                                    <?php if ($notify_icon != '' && $approvals[0]['pipeline_approval'] == 2) { ?>
                                                        <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                    <?php } ?>
                                                </a></li>
                                            <?php if ($this->session->userdata['currency'] == 'INR') { ?>
                                                <p class="currencyNotify currencyPadd"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
                                            <?php } else { ?>
                                                <p class="currencyNotify currencyPadd"><span class="text-danger">*</span> All <?= $this->session->userdata['currency']; ?> amounts are in '000's.</p>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-slider--container innerTabsPlansetup">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <div class="inputplan-structureall plan-structure-new">
                                            <form method="post" id="pipeline_form" action="<?php echo base_url() . 'index.php/portfolio/addPipeline'; ?>" autocomplete="off">
                                                <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                <input type='hidden' name='cur_finance' id="cur_finance" value="<?= $current_financial; ?>">
                                                <input type='hidden' name='updatePlan' id="updatePlan" value="0">

                                                <div class="quaterlyNewplanstru">
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                            <?php if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['pipeline_approval'] == 2) { ?>
                                                                <h4>Pipeline Targets <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                            <?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['pipeline_approval'] == 3) { ?>
                                                                <h4>Pipeline Targets <span class="text-success"><small>(Approved)</small></span></h4>
                                                            <?php } else { ?>
                                                                <h4>Pipeline Targets</h4>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12 text-right">
                                                            <?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['pipeline_approval'] == 2) { ?>
                                                                <div class="approved-btn text-right">
                                                                    <button type="button" class="btn btn-success capitilize">Approve</button>
                                                                    <div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 text-right" id="editdiv">
                                                            <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-bt15 display-block mar-rt5" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="Plan-structure">
                                                    <div class=" table_configcontentnew">
                                                        <table class="table">
                                                            <thead>
                                                            <th colspan="12">Open</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <p><?= $get_month_list[0]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="open[]" value="<?= $get_open->{$get_month_list[0]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[1]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="open[]" value="<?= $get_open->{$get_month_list[1]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[2]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="open[]" value="<?= $get_open->{$get_month_list[2]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[3]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="open[]" value="<?= $get_open->{$get_month_list[3]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[4]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="open[]" value="<?= $get_open->{$get_month_list[4]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[5]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="open[]" value="<?= $get_open->{$get_month_list[5]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[6]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="open[]" value="<?= $get_open->{$get_month_list[6]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[7]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="open[]" value="<?= $get_open->{$get_month_list[7]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[8]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="open[]" value="<?= $get_open->{$get_month_list[8]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[9]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="open[]" value="<?= $get_open->{$get_month_list[9]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[10]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="open[]" value="<?= $get_open->{$get_month_list[10]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[11]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="open[]" value="<?= $get_open->{$get_month_list[11]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="table">
                                                            <thead>
                                                            <th colspan="12">Hot/Under Discussion</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <p><?= $get_month_list[0]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="under[]" value="<?= $get_under->{$get_month_list[0]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[1]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="under[]" value="<?= $get_under->{$get_month_list[1]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[2]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="under[]" value="<?= $get_under->{$get_month_list[2]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[3]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="under[]" value="<?= $get_under->{$get_month_list[3]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[4]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="under[]" value="<?= $get_under->{$get_month_list[4]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[5]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="under[]" value="<?= $get_under->{$get_month_list[5]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[6]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="under[]" value="<?= $get_under->{$get_month_list[6]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[7]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="under[]" value="<?= $get_under->{$get_month_list[7]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[8]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="under[]" value="<?= $get_under->{$get_month_list[8]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[9]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="under[]" value="<?= $get_under->{$get_month_list[9]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[10]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="under[]" value="<?= $get_under->{$get_month_list[10]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[11]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="under[]" value="<?= $get_under->{$get_month_list[11]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="table">
                                                            <thead>
                                                            <th colspan="12">Rejected/Closed</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <p><?= $get_month_list[0]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="reject[]" value="<?= $get_reject->{$get_month_list[0]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[1]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="reject[]" value="<?= $get_reject->{$get_month_list[1]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[2]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="reject[]" value="<?= $get_reject->{$get_month_list[2]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[3]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="reject[]" value="<?= $get_reject->{$get_month_list[3]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[4]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="reject[]" value="<?= $get_reject->{$get_month_list[4]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[5]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="reject[]" value="<?= $get_reject->{$get_month_list[5]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[6]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="reject[]" value="<?= $get_reject->{$get_month_list[6]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[7]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="reject[]" value="<?= $get_reject->{$get_month_list[7]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[8]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="reject[]" value="<?= $get_reject->{$get_month_list[8]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[9]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="reject[]" value="<?= $get_reject->{$get_month_list[9]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[10]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="reject[]" value="<?= $get_reject->{$get_month_list[10]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[11]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="reject[]" value="<?= $get_reject->{$get_month_list[11]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="table">
                                                            <thead>
                                                            <th colspan="12">Converted</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <p><?= $get_month_list[0]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="convert[]" value="<?= $get_convert->{$get_month_list[0]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[1]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="convert[]" value="<?= $get_convert->{$get_month_list[1]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[2]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="convert[]" value="<?= $get_convert->{$get_month_list[2]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[3]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="convert[]" value="<?= $get_convert->{$get_month_list[3]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[4]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="convert[]" value="<?= $get_convert->{$get_month_list[4]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[5]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="convert[]" value="<?= $get_convert->{$get_month_list[5]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[6]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="convert[]" value="<?= $get_convert->{$get_month_list[6]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[7]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="convert[]" value="<?= $get_convert->{$get_month_list[7]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[8]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="convert[]" value="<?= $get_convert->{$get_month_list[8]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[9]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="convert[]" value="<?= $get_convert->{$get_month_list[9]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[10]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="convert[]" value="<?= $get_convert->{$get_month_list[10]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p><?= $get_month_list[11]; ?></p>
                                                                        <div class="form-group">
                                                                            <input type="text" name="convert[]" value="<?= $get_convert->{$get_month_list[11]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
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

<input type="hidden" id="planBox" value="<?= $this->session->userdata['plan_lightbox']; ?>">

<div class="modal" id="planModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content data_congifpopup">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel"><span class="text-success"><i
                            class="fas fa-check-circle"></i></span> Successfully updated the plan</h5>
            </div>
            <div class="modal-body onboarding-permission text-center">
                <ul>
                    <li>You have successfully saved & updated the plan for <br>"<strong><span>
                                <?php
                                echo ucfirst($company_name) . ', ';
                                if ($reg_city != '') {
                                    echo ucfirst($reg_city) . ', ';
                                }
                                if ($sector_name != '') {
                                    echo ucfirst($sector_name);
                                }
                                ?>
                            </span></strong>"</li>
                </ul>
                <div class="popup-content-final popup-content">
                    <a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Later</a>
                    <!--<a class="btn btn-configure " href="javascript:void(0)"  >Send for Approval Now</a>-->
                    <a class="btn btn-configure" data-toggle="modal" data-target="#sendapproval">Send for Approval Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- approval send modal -->
<div class="modal" id="sendapproval" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content data_congifpopup">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel"><span class="text-success"><i
                            class="fas fa-check-circle"></i></span> Sending for Approval</h5>
            </div>
            <div class="modal-body onboarding-permission text-center">
                <ul>
                    <li>The updated plan for <?= $company_name; ?> will now be sent to <?= $sector_lead[0]['emp_names']; ?> for approval. Click Okay to proceed.</li>
                </ul>
                <div class="popup-content-final popup-content">
                    <a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a>
                    <a class="btn btn-configure " href="javascript:void(0)" onclick="sendApproval();">Okay</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->session->set_userdata('plan_lightbox', 0);
$this->session->set_userdata('approve_success', 0);
?>

<?php
$obj_open = json_decode($pipeline['open_pipeline'], true);
$obj_under = json_decode($pipeline['under_discussion'], true);
$obj_reject = json_decode($pipeline['closed_pipeline'], true);
$obj_convert = json_decode($pipeline['converted_pipeline'], true);
if (!php72_array_filter($obj_open) && !php72_array_filter($obj_under) && !php72_array_filter($obj_reject) && !php72_array_filter($obj_convert)) {
    $enable = 0;
} else {
    $enable = 1;
}
?>

<input type="hidden" id="enableCount" value="<?= $enable; ?>">

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        var editOpt = $('#enableCount').val();
        var enable_form = "<?= $field_enable; ?>";
        if (editOpt > 0 || enable_form == 0) {
            $('input[type="text"]').attr('readonly', 'readonly');
        }
        var popup = $('#planBox').val();
//                                    if (popup == 1) {
//                                        $('#planModal').modal('show');
//                                    } else {
//                                        $('#planModal').modal('hide');
//                                    }
        $('#editBtn').addClass('opacity5');

        setTimeout(function () {
            $('#approveMsg').hide();
            $('#approveallMsg').hide();
        }, 3000);
    });

    function pad(num) {
        var s = num + "";
        s = parseFloat(s, 10);
        return s;
    }

    $(document).on('blur', '.volumefld', function (evt) {
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

    $(document).on('input', '.volumefld', function (evt) {
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

    $(document).on('click', '#sendApproval', function () {
        $('#sendapproval').modal('show');
    });

    function sendApproval() {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#cur_finance').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/sendapproval",
            data: {
                fin_year: fin_year,
                invid: inv_id,
                table: 'port_config_approval'
            },
            dataType: 'json',
            success: function (msg) {
                if (msg == '1') {
                    location.reload();
                }
            }
        });
    }
    $(document).on('click', '#editBtn', function () {

        $('#editdiv').html('<a href="javascript:void(0)" class="edit-btnconfig mar-bt15 display-block mar-rt5" id="cancelBtn"><i class="fas fa-times"></i> Cancel</a>');
        $('.saveContinue').text('Save');
        $('#updatePlan').val('1');
        $('input[type="text"]').attr('readonly', false);
    });

    $(document).on('click', '#cancelBtn', function () {
        $('#editdiv').html('<a href="javascript:void(0)" class="edit-btnconfig mar-bt15 display-block mar-rt5" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a>');
        $('.saveContinue').text('Save');
        $('#updatePlan').val('0');
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('input[type="text"]').attr('readonly', 'readonly');
        }
    });

    $(".saveContinue").on('click', function (e) {
        if ($('#pipeline_form').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#pipeline_form').submit();
            e.preventDefault();
        }
    });

    function loadYear(year) {
        var inv_id = $('#innovation_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/pipeline/' + inv_id + '/' + year;
    }

    $(document).on('click', '.capitilize', function () {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#cur_finance').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/pipeApproved",
            data: {
                inv_id: inv_id,
                fin_year: fin_year
            },
            dataType: 'json',
            success: function (msg) {
                location.reload();
            }
        });
    });

    $(document).on('click', '.approveall', function () {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#cur_finance').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/ApproveAll",
            data: {
                inv_id: inv_id,
                fin_year: fin_year
            },
            dataType: 'json',
            success: function (msg) {
//                                                    $('#pageContent').load(location.href + ' #pageContent');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        });
    });

    $(document).on('click', '#lead_approveall', function () {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#cur_finance').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/sectorLead_sendApproval",
            data: {
                inv_id: inv_id,
                fin_year: fin_year
            },
            dataType: 'json',
            success: function (msg) {
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        });
    });
</script>

</body>
</html>