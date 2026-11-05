<?php
$innovation = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $innovation['name_of_enterprise'];

$reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Plan', 'company_name' => $company_name, 'port_action' => 'plan', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'fin_year' => $current_financial, 'add_class' => 'mar-tp140'));

if ($this->session->userdata['sector_lead'] == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
    $notify_icon = isset($dataConfig) ? $dataConfig : '';
} else {
    $notify_icon = '';
}
$field_enable = '0';
?>

<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Record(s) deleted successfully</div>
    <?php if ($this->session->userdata['approve_success'] == '1') { ?>
        <div id="approveMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Sales details approved successfully</div>
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
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right">
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

                        <div class="config-wrapper tabpanel-detailsconfig  dataconfig-content page-wrapper chiller-theme">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('config_left_menu.php', array('class_name' => 'salesDiv', 'configData' => $dataConfig, 'approvals' => $approvals, 'fin_year' => $current_financial)); ?>
                            </div>
                            <main class="page-content" id="pageContent">
                                <div class="row dataconfig">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad0">
                                        <h4>Product &amp; Sales</h4>
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
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
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-12 text-right">
                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                            <a href="javascript:void(0)" class="edit-btnconfig editBtn" id="qualEditBtn"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                        <?php } ?>
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
                                            <li class="tab-slider--triggerform active"><a href="javascript:void(0)">Sales&nbsp;
                                                    <?php if ($notify_icon != '' && $approvals[0]['sales_approval'] == 2) { ?>
                                                        <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                    <?php } ?>
                                                </a></li>
                                            <li class="tab-slider--triggerform "><a href="<?= base_url() . 'index.php/portfolio/channel/' . $innovation_id . '/' . $current_financial; ?>">Channel&nbsp;
                                                    <?php if ($notify_icon != '' && $approvals[0]['channel_approval'] == 2) { ?>
                                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                                    <?php } ?>
                                                </a></li>
                                            <li class="tab-slider--triggerform "><a href="<?= base_url() . 'index.php/portfolio/pipeline/' . $innovation_id . '/' . $current_financial; ?>">Pipeline&nbsp;
                                                    <?php if ($notify_icon != '' && $approvals[0]['pipeline_approval'] == 2) { ?>
                                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
                                                    <?php } ?>
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-slider--container innerTabsPlansetup">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <div class="inputplan-structureall plan-structure-new wdt-100">
                                            <div class="quaterlyNewplanstru">
                                                <?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['sales_approval'] == 2) { ?>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                            <!--<h4>Create Sales</h4>-->
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right">
                                                            <div class="approved-btn text-right">
                                                                <button type="button" class="btn btn-success capitilize">Approve</button>
                                                                <div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                            <div id='accordion' class="Plan-structure">
                                                <div class="row" id="target">
												<div class="col-xl-12 col-md-7 col-lg-7 col-12">
                                                        <div class="quaterlyNewplanstru" style="display:flex;">
															<?php  if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['sales_approval'] == 2) { ?>
																<h4>Sales Targets <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
															<?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['sales_approval'] == 3) { ?>
																<h4>Sales Targets <span class="text-success"><small>(Approved)</small></span></h4>
															<?php } else { ?>
																<h4>Sales Targets</h4>
															<?php }  ?>
															<?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['sales_approval'] == 2) { ?>
															<div class="approved-btn text-right" style="margin-top: -14px;">
																<button style="margin-left: 5px;" type="button" class="btn btn-success capitilize">Approve</button>
															</div>
															<?php }  ?>
															 <?php if ($this->session->userdata['currency'] == 'INR') { ?>
																<p class="currencyNotify currencyPadd" style="margin-left: auto;margin-top: -10px;"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
															<?php } else { ?>
																<p class="currencyNotify currencyPadd" style="margin-left: auto;margin-top: -10px;"><span class="text-danger">*</span> All <?= $this->session->userdata['currency']; ?> amounts are in '000's.</p>
															<?php } ?>
														
                                                        </div>
														
                                                    </div>
                                                    <div class="col-xl-5 col-md-5 col-lg-5 col-12">
                                                        <?php /* if ($this->session->userdata['currency'] == 'INR') { ?>
                                                            <p class="currencyNotify currencyPadd"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
                                                        <?php } else { ?>
                                                            <p class="currencyNotify currencyPadd"><span class="text-danger">*</span> All <?= $this->session->userdata['currency']; ?> amounts are in '000's.</p>
                                                        <?php } ?>
														<?php  if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['sales_approval'] == 2) { ?>
														<div class="approved-btn text-right">
															<button type="button" class="btn btn-success capitilize">Approve</button>
															<div>
															</div>
														</div>
														<?php }  */?>
                                                    </div>
													
                                                    <!--<div class="col-xl-7 col-md-7 col-lg-7 col-12">
                                                        <div class="quaterlyNewplanstru">
                                                            <h4>Sales Targets</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-5 col-md-5 col-lg-5 col-12">
                                                        <?php if ($this->session->userdata['currency'] == 'INR') { ?>
                                                            <p class="currencyNotify currencyPadd"><span class="text-danger">*</span> All INR amounts are in Lakhs.</p>
                                                        <?php } else { ?>
                                                            <p class="currencyNotify currencyPadd"><span class="text-danger">*</span> All <?= $this->session->userdata['currency']; ?> amounts are in '000's.</p>
                                                        <?php } ?>
                                                    </div>-->
                                                </div>

                                                <form method="post" id="create_sales" class="mar-bt15" action="<?php echo base_url() . 'index.php/portfolio/createSales'; ?>" autocomplete="off">
                                                    <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                    <input type='hidden' name='cur_finance' id="cur_finance" value="<?= $current_financial; ?>">
                                                    <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                        <div class="add-sales">
                                                            <ul class="milestone-links">
                                                                <li class="valigntop pad-lf0"><p>Create SKU</p></li>
                                                                <li><div class="form-group">
                                                                        <input type="text" name="sales_name" id="sales_name" class="form-control form-control-sm" placeholder="Add new product">
                                                                    </div></li>
                                                                <li class="valigntop"> <span><input type="submit" id="skuSubmit" class="btn add-btnconfig brd-rd30 btn-success btn-sm" value="Add"></span></li>
                                                            </ul>
                                                        </div>
                                                    <?php } ?>
                                                </form>

                                                <form id="skuData" method="post" action="<?php echo base_url() . 'index.php/portfolio/addSales'; ?>" autocomplete="off">
                                                    <input type='hidden' name='inv_id' id="inv_id" value="<?= $innovation_id; ?>">
                                                    <input type='hidden' name='finance_Year' id="finance_Year" value="<?= $current_financial; ?>">
                                                    <input type='hidden' name='updatePlan' id="updatePlan" value="0">
                                                    <input type='hidden' name='module_id' id="module_id" value="2">
                                                    <?php
                                                    $i = 1;
                                                    if (count($sales_data) > 0) {
                                                        foreach ($sales_data as $row) {
                                                            $get_unit = $row['unit'];
                                                            $get_volume = json_decode($row['volume']);
                                                            $get_value = json_decode($row['value']);

                                                            $enable_volume = json_decode($row['volume'], true);
                                                            $enable_value = json_decode($row['value'], true);

                                                            if (!array_filter($enable_volume) && !array_filter($enable_volume) && $row['other'] == '' && $row['unit'] == '') {
                                                                $enable = 0;
                                                            } else {
                                                                $enable = 1;
                                                            }
                                                            ?>

                                                            <input type="hidden" class="enableCount" id="enableCount_<?= $i; ?>" value="<?= $enable; ?>">
                                                            <input type="hidden" name="row_id" id="row_id" value="<?= $i; ?>">
                                                            <input type="hidden" name="sales_id<?= $i; ?>" id="sales_id<?= $i; ?>" value="<?= $row['sales_id']; ?>">
                                                            <div class=" table_configcontentnew table_content" id="table_content_<?= $i; ?>">
                                                                <div class="row">
                                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-12">
                                                                        <h6>Create Plan</h6>
                                                                    </div>
                                                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-6 col-12" id="sku_list_<?= $i; ?>">
                                                                        <p>SKU <span><?= $i; ?></span> / <span class="saleslabel" onclick="editSalesName('<?= $row['sales_id']; ?>', '<?= $row['product_name']; ?>')"><?= $row['product_name']; ?></span></p>
                                                                    </div>
                                                                    <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 text-right">
                                                                            <ul class="milestone-links">
                                                                                <li id='editSec<?= $i; ?>'>
                                                                                    <a href="javascript:void(0)" class="edit-btnconfig" onclick="editBtn(<?= $i; ?>)" id="edit_sales_<?= $i; ?>"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="javascript:void(0)" class="delete-btnconfig" onclick="deleteSKU(<?= $row['sales_id']; ?>)" id="delete_sales_<?= $i; ?>"><i class="fas fa-trash-alt"></i> Delete</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                            <!--                                                        <div class="table-responsive table_configcontentnew table_content" id="table_content_<?= $i; ?>">-->
                                                                <table class="table">
                                                                    <thead>
                                                                    <th colspan="12">Volume</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <p><?= $get_month_list[0]; ?></p>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->{$get_month_list[0]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[1]; ?></p>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->{$get_month_list[1]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[2]; ?></p>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->{$get_month_list[2]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[3]; ?></p>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->{$get_month_list[3]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[4]; ?></p>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->{$get_month_list[4]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[5]; ?></p>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->{$get_month_list[5]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[6]; ?></p>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->{$get_month_list[6]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[7]; ?></p>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->{$get_month_list[7]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[8]; ?></p>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->{$get_month_list[8]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[9]; ?></p>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->{$get_month_list[9]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[10]; ?></p>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->{$get_month_list[10]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[11]; ?></p>
                                                                                <div class="form-group">
                                                                                    <input type="text" name="month<?= $i; ?>[]" value="<?= $get_volume->{$get_month_list[11]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <p>Unit</p>
                                                                            </td>
                                                                            <td colspan="2">
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control form-control-sm" name="unit<?= $i; ?>" value="<?= $get_unit; ?>" maxlength="15" placeholder="Unit">
                                                                                </div>
                                                                            </td>
                                                                            <td colspan="10">

                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table class="table">
                                                                    <thead>
                                                                        <?php
                                                                        if ($this->session->userdata['currency'] == 'INR') {
                                                                            $currency_text = "INR, In Lakhs";
                                                                        } else {
                                                                            $currency_text = $this->session->userdata['currency'] . ", In '000's";
                                                                        }
                                                                        ?>
                                                                    <th colspan="12">Value&nbsp;<span class="rupee-value">(<?= $currency_text; ?>)</span></th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <p><?= $get_month_list[0]; ?></p>
                                                                                <div class="form-group ">
                                                                                    <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->{$get_month_list[0]}; ?>" class="form-control form-control-sm currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[1]; ?></p>
                                                                                <div class="form-group ">
                                                                                    <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->{$get_month_list[1]}; ?>" class="form-control form-control-sm currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[2]; ?></p>
                                                                                <div class="form-group ">
                                                                                    <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->{$get_month_list[2]}; ?>" class="form-control form-control-sm currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[3]; ?></p>
                                                                                <div class="form-group ">
                                                                                    <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->{$get_month_list[3]}; ?>" class="form-control form-control-sm currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[4]; ?></p>
                                                                                <div class="form-group ">
                                                                                    <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->{$get_month_list[4]}; ?>" class="form-control form-control-sm currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[5]; ?></p>
                                                                                <div class="form-group ">
                                                                                    <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->{$get_month_list[5]}; ?>" class="form-control form-control-sm currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[6]; ?></p>
                                                                                <div class="form-group ">
                                                                                    <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->{$get_month_list[6]}; ?>" class="form-control form-control-sm currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[7]; ?></p>
                                                                                <div class="form-group ">
                                                                                    <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->{$get_month_list[7]}; ?>" class="form-control form-control-sm currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[8]; ?></p>
                                                                                <div class="form-group ">
                                                                                    <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->{$get_month_list[8]}; ?>" class="form-control form-control-sm currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[9]; ?></p>
                                                                                <div class="form-group ">
                                                                                    <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->{$get_month_list[9]}; ?>" class="form-control form-control-sm currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td >
                                                                                <p><?= $get_month_list[10]; ?></p>
                                                                                <div class="form-group ">
                                                                                    <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->{$get_month_list[10]}; ?>" class="form-control form-control-sm currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <p><?= $get_month_list[11]; ?></p>
                                                                                <div class="form-group ">
                                                                                    <input type="text" name="value<?= $i; ?>[]" value="<?= $get_value->{$get_month_list[11]}; ?>" class="form-control form-control-sm currencyField" maxlength="20" placeholder="00">
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <br/>
                                                            <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>

                                                </form>
												<hr><br><br>
												 <form id="qualitativeData" method="post" action="<?php echo base_url() . 'index.php/portfolio/addQualitativeSales'; ?>" autocomplete="off">
                                                    <input type='hidden' name='inv_id' id="inv_id" value="<?= $innovation_id; ?>">
                                                    <input type='hidden' name='finance_Year' id="finance_Year" value="<?= $current_financial; ?>">
                                                    <input type='hidden' name='updatePlan' id="updatePlan" value="0">
                                                    <input type='hidden' name='module_id' id="module_id" value="2">
                                                    <!-- Quantity new design -->

                                                    <div class="quaterlyNewplanstru">
                                                        <?php /* if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['sales_approval'] == 2) { ?>
                                                            <h4>Sales Plan <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                        <?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['sales_approval'] == 3) { ?>
                                                            <h4>Sales Plan <span class="text-success"><small>(Approved)</small></span></h4>
                                                        <?php } else { ?>
                                                            <h4>Sales Plan</h4>
                                                        <?php } */ ?>
														<h4>Sales Plan</h4>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6">
                                                                <p>Q1 (<?= $get_month_list[0] . '-' . $get_month_list[2] . ' ' . $current_financial; ?>)</p>
                                                                <div class="quaterlyCardnew" id="qOne_active">
                                                                    <textarea rows="3" class="mceEditor" id="txtQuarterOne" name="qOneDesc" placeholder="Enter quarterly plan details in here"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['q_one_desc'])); ?></textarea>
                                                                    <div class="tabset1" onclick="highlightQuarter('qOne_active');">
                                                                        <input type="radio" name="tabset1" id="tab4" aria-controls="Apr" checked >
                                                                        <label for="tab4"><?= $get_month_list[0]; ?></label>
                                                                        <input type="radio" name="tabset1" id="tab2" aria-controls="May" >
                                                                        <label for="tab2"><?= $get_month_list[1]; ?></label>
                                                                        <input type="radio" name="tabset1" id="tab3" aria-controls="Jun" >
                                                                        <label for="tab3"><?= $get_month_list[2]; ?></label>
                                                                        <div class="tab-panels">
                                                                            <section class="tab-panel" id="Apr">
                                                                                <div class="aprBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtApril" name='<?= strtolower($get_month_list[0]) . 'Content'; ?>' placeholder="Plan for April"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[0]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section class="tab-panel" id="May">
                                                                                <div class="mayBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtMay" name='<?= strtolower($get_month_list[1]) . 'Content'; ?>' placeholder="Plan for May"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[1]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section class="tab-panel" id="Jun">
                                                                                <div class="junBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtJune" name='<?= strtolower($get_month_list[2]) . 'Content'; ?>' placeholder="Plan for June"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[2]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6">
                                                                <p>Q2 (<?= $get_month_list[3] . '-' . $get_month_list[5] . ' ' . $current_financial; ?>)</p>
                                                                <div class="quaterlyCardnew" id="qTwo_active">
                                                                    <textarea rows="3" class="mceEditor" id="txtQuarterTwo" name="qTwoDesc" placeholder="Enter quarterly plan details in here"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['q_two_desc'])); ?></textarea>
                                                                    <div class="tabset2" onclick="highlightQuarter('qTwo_active');">
                                                                        <input type="radio" name="tabset2" id="tab5" aria-controls="Jul" checked >
                                                                        <label for="tab5"><?= $get_month_list[3]; ?></label>
                                                                        <input type="radio" name="tabset2" id="tab6" aria-controls="Aug" >
                                                                        <label for="tab6"><?= $get_month_list[4]; ?></label>
                                                                        <input type="radio" name="tabset2" id="tab7" aria-controls="Sep" >
                                                                        <label for="tab7"><?= $get_month_list[5]; ?></label>

                                                                        <div class="tab-panels">
                                                                            <section id="Jul" class="tab-panel">
                                                                                <div class="julBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtJuly" name='<?= strtolower($get_month_list[3]) . 'Content'; ?>' placeholder="Plan for July"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[3]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section id="Aug" class="tab-panel">
                                                                                <div class="augBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtAugust" name='<?= strtolower($get_month_list[4]) . 'Content'; ?>' placeholder="Plan for August"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[4]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section id="Sep" class="tab-panel">
                                                                                <div class="sepBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtSeptember" name='<?= strtolower($get_month_list[5]) . 'Content'; ?>' placeholder="Plan for September"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[5]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6">
                                                                <p>Q3 (<?= $get_month_list[6] . '-' . $get_month_list[8] . ' ' . $current_financial; ?>)</p>
                                                                <div class="quaterlyCardnew" id="qThree_active">
                                                                    <textarea rows="3" class="mceEditor" id="txtQuarterThree" name="qThreeDesc" placeholder="Enter quarterly plan details in here"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['q_three_desc'])); ?></textarea>
                                                                    <div class="tabset3" onclick="highlightQuarter('qThree_active');">
                                                                        <input type="radio" name="tabset3" id="tab8" aria-controls="Oct" checked >
                                                                        <label for="tab8"><?= $get_month_list[6]; ?></label>
                                                                        <input type="radio" name="tabset3" id="tab9" aria-controls="Nov" >
                                                                        <label for="tab9"><?= $get_month_list[7]; ?></label>
                                                                        <input type="radio" name="tabset3" id="tab10" aria-controls="Dec" >
                                                                        <label for="tab10"><?= $get_month_list[8]; ?></label>

                                                                        <div class="tab-panels">
                                                                            <section id="Oct" class="tab-panel">
                                                                                <div class="octBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtOctober" name='<?= strtolower($get_month_list[6]) . 'Content'; ?>' placeholder="Plan for October"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[6]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section id="Nov" class="tab-panel">
                                                                                <div class="novBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtNovember" name='<?= strtolower($get_month_list[7]) . 'Content'; ?>' placeholder="Plan for November"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[7]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section id="Dec" class="tab-panel">
                                                                                <div class="decBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtDecember" name='<?= strtolower($get_month_list[8]) . 'Content'; ?>' placeholder="Plan for December"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[8]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6">
                                                                <p>Q4 (<?= $get_month_list[9] . '-' . $get_month_list[11] . ' ' . current_FYendYear($this->session->userdata('partner_id')); ?>)</p>
                                                                <div class="quaterlyCardnew" id="qFour_active">
                                                                    <textarea rows="3" class="mceEditor" id="txtQuarterFour" name="qFourDesc" placeholder="Enter quarterly plan details in here"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['q_four_desc'])); ?></textarea>
                                                                    <div class="tabset4" onclick="highlightQuarter('qFour_active');">
                                                                        <input type="radio" name="tabset4" id="tab11" aria-controls="Jan" checked >
                                                                        <label for="tab11"><?= $get_month_list[9]; ?></label>
                                                                        <input type="radio" name="tabset4" id="tab12" aria-controls="Feb" >
                                                                        <label for="tab12"><?= $get_month_list[10]; ?></label>
                                                                        <input type="radio" name="tabset4" id="tab13" aria-controls="Mar" >
                                                                        <label for="tab13"><?= $get_month_list[11]; ?></label>

                                                                        <div class="tab-panels">
                                                                            <section id="Jan" class="tab-panel">
                                                                                <div class="janBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtJanuary" name='<?= strtolower($get_month_list[9]) . 'Content'; ?>' placeholder="Plan for January"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[9]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section id="Feb" class="tab-panel">
                                                                                <div class="febBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtFebruary" name='<?= strtolower($get_month_list[10]) . 'Content'; ?>' placeholder="Plan for February"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[10]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                            <section id="Mar" class="tab-panel">
                                                                                <div class="marBox">
                                                                                    <textarea rows="3" class="mceEditor" id="txtMarch" name='<?= strtolower($get_month_list[11]) . 'Content'; ?>' placeholder="Plan for March"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0][strtolower($get_month_list[11]) . '_desc'])); ?></textarea>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                               
											   
											   
                                            </div>
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
                            <p>you are about delete this selected information fields, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
    <input type="hidden" id="deleteID" value="">
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
                    <a class="btn btn-configure" href="javascript:void(0)" onclick="sendApproval();">Okay</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Model (Add sales) -->
<div class="modal" id="salesmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <form method="post" id="Update_sales" action="<?php echo base_url() . 'index.php/portfolio/editSales'; ?>" autocomplete="off">
                <div class="modal-body text-center">
                    <div class="container-fluid">
                        <div class="row">
                            <h4 class="text-center popup_milestone" id="milesTitle">Edit Sales Name</h4>
                            <div class="col-12">
                                <input type='hidden' name='edit_innovation_id' id="edit_innovation_id" value="<?= $innovation_id; ?>">
                                <div >
                                    <p>Sales Name</p>
                                    <div class="form-group">
                                        <input type="text" name="edit_sales_name" id="edit_sales_name" class="form-control form-control-sm" placeholder="Sales name">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type='hidden' name='edit_cur_finance' id="edit_cur_finance" value="<?= $current_financial; ?>">
                    <input type="hidden" name="sales_edit_id" id="sales_edit_id" />
                    <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                    <input type="submit" id="editSubmit" class="btn add-btnconfig brd-rd30 btn-success btn-sm" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$this->session->set_userdata('plan_lightbox', 0);
$this->session->set_userdata('approve_success', 0);

$month_id = '';
$current_month = date('n');
if ($current_month == '1' || $current_month == '2' || $current_month == '3') {
    $month_id = 'qFour_active';
} else if ($current_month == '4' || $current_month == '5' || $current_month == '6') {
    $month_id = 'qOne_active';
} else if ($current_month == '7' || $current_month == '8' || $current_month == '9') {
    $month_id = 'qTwo_active';
} else if ($current_month == '10' || $current_month == '11' || $current_month == '12') {
    $month_id = 'qThree_active';
}
?>
<input type="hidden" id="active_editor" value="<?= $month_id; ?>">
<input type="hidden" id="QualDataCount" value="<?= count($qualitative_data); ?>">

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio', 'quantitative' => 'tiny')); ?>

<script type="text/javascript">

    $(window).on("load", function () {
        ($("iframe").contents().click(function (event) {
            $('.quaterlyCardnew').removeClass('greenplantxt');
            if (event.target.localName == 'html') {
                var div_id = event.target.childNodes[1].attributes["0"].ownerElement.dataset.id
            } else if (event.target.localName == 'body') {
                var div_id = event.target.dataset.id;
            } else {
                var div_id = event.target.offsetParent.attributes["0"].ownerElement.dataset.id;
            }

            if (div_id == 'txtQuarterOne' || div_id == 'txtApril' || div_id == 'txtMay' || div_id == 'txtJune') {
                $("#qOne_active").addClass("greenplantxt");
            } else if (div_id == 'txtQuarterTwo' || div_id == 'txtJuly' || div_id == 'txtAugust' || div_id == 'txtSeptember') {
                $("#qTwo_active").addClass("greenplantxt");
            } else if (div_id == 'txtQuarterThree' || div_id == 'txtOctober' || div_id == 'txtNovember' || div_id == 'txtDecember') {
                $("#qThree_active").addClass("greenplantxt");
            } else if (div_id == 'txtQuarterFour' || div_id == 'txtJanuary' || div_id == 'txtFebruary' || div_id == 'txtMarch') {
                $("#qFour_active").addClass("greenplantxt");
            }
        }));
        // $('svg').attr("viewBox", "0 0 25 25");
        // $('svg').css({"width": "20", "height": "20"});
    });

    function highlightQuarter(id) {
        $('.quaterlyCardnew').removeClass('greenplantxt');
        $("#" + id).addClass("greenplantxt");
    }

    tinyMCE.init({
        mode: "specific_textareas",
        editor_selector: "mceEditor",
        entity_encoding: "numeric",
        menubar: false,
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

    function tinyLoad_old(class_val) {
        tinymce.init({
            selector: '.' + class_val,
            menubar: false,
            inline: true,
            plugins: [
                'link',
                'lists',
                'powerpaste',
                'autolink',
                'tinymcespellchecker'
            ],
            toolbar: [
                'undo redo | bold italic underline | fontselect fontsizeselect',
                'forecolor backcolor | alignleft aligncenter alignright alignfull | numlist bullist outdent indent'
            ],
            valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li',
            valid_styles: {
                '*': 'font-size,font-family,color,text-decoration,text-align'
            },
            powerpaste_word_import: 'clean',
            powerpaste_html_import: 'clean',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i'
            ]
        });
    }

    $(document).ready(function () {

        var popup = $('#planBox').val();
        //                                        if (popup == 1) {
        //                                            $('#planModal').modal('show');
        //                                        } else {
        //                                            $('#planModal').modal('hide');
        //                                        }
        onLoad();
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
    $(document).on('click', '#sendApproval', function () {
        $('#sendapproval').modal('show');
    });
    $(document).on('click', '#editSubmit', function () {
        var sales_id = $('#sales_edit_id').val();
        var finan_yr = $('#edit_cur_finance').val();
        var inv_id = $('#edit_innovation_id').val();
        $('#Update_sales').validate({
            rules: {
                edit_sales_name: {
                    required: true,
                    remote: {
                        url: "<?php echo base_url() . 'index.php/portfolio/checkSales'; ?>",
                        type: "post",
                        data: {
                            id: sales_id,
                            yr: finan_yr,
                            inv_id: inv_id,
                            edit_sales_name: function () {
                                return $("#edit_sales_name").val();
                            }
                        }
                    }
                }
            },
            messages: {
                edit_sales_name: {
                    required: "Please enter sales name",
                    remote: "Sales name already exist"
                }
            }
        });
    });
    function editSalesName(editid, sales) {
        $('#sales_edit_id').val(editid);
        $('#edit_sales_name').val(sales);
        $('#salesmodal').modal('show');
    }

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

    function onLoad() {
        var cur_mnth = $('#active_editor').val();
        if (cur_mnth != '')
            highlightQuarter(cur_mnth);

        var enable_form = "<?= $field_enable; ?>";
        var qualEditOpt = $('#QualDataCount').val();

        /*if (qualEditOpt > 0 || enable_form == 0) {
            $('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').css("pointer-events", "none");
            $('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').addClass('opacity5');
        } else {*/
            $('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').css("pointer-events", "");
            $('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').removeClass('opacity5');
        //}
        $('#qualEditBtn').addClass('opacity5');

        $('.enableCount').each(function (key, value) {
            var inc = key + 1;
            var editOpt = $('#enableCount_' + inc).val();
            if (editOpt > 0) {
                $('#table_content_' + inc + ' input[type="text"], #table_content_' + inc + ' select').attr('readonly', 'readonly');
                $('#table_content_' + inc + ' select').css('pointer-events', 'none');
            } else {
                $('#table_content_' + inc + ' input[type="text"], #table_content_' + inc + ' select').attr('readonly', false);
                $('#table_content_' + inc + ' select').css('pointer-events', '');
            }
            $('#edit_sales_' + inc).addClass('opacity5');
            $('#delete_sales_' + inc).addClass('opacity5');
        });
    }

    $(document).on('click', '#qualEditBtn', function () {
        $('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').css("pointer-events", "");
        $('#qOne_active, #qTwo_active, #qThree_active, #qFour_active').removeClass('opacity5');
        $('#qualEditBtn').removeClass('opacity5');
    });

    function editBtn(id) {
        $('#editSec' + id).html('<a href="javascript:void(0)" class="edit-btnconfig" onclick="cancelBtn(' + id + ')" id="cancel_edit_' + id + '"><i class="fas fa-times"></i> Cancel</a>');
        //                                        $('.saveContinue').text('Save & Update Plan');
        $('#updatePlan').val('1');
        $('#table_content_' + id + ' input[type="text"], #table_content_' + id + ' select').attr('readonly', false);
        $('#table_content_' + id + ' select').css('pointer-events', '');
        $('#edit_sales_' + id).removeClass('opacity5');
    }

    function cancelBtn(id) {
        $('#editSec' + id).html('<a href="javascript:void(0)" class="edit-btnconfig" onclick="editBtn(' + id + ')" id="edit_sales_' + id + '"><i class="fas fa-pencil-alt"></i> Edit</a>');
        //                                        $('.saveContinue').text('Save & Continue');
        $('#updatePlan').val('0');
        onLoad();
    }

    function deleteSKU(sales_id) {
        $('#deletemodal').modal('show');
        $('#deleteID').val(sales_id);
    }

    $('#deleteRecord').on('click', function () {
        var sales_id = $('#deleteID').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/deletePortfolioConfig",
            data: {
                fields: 'volume,value',
                id: sales_id,
                table: 'port_sales_data',
                temp_table: 'temp_sales_data',
                plan_table: 'plan_sales',
                plan_column: 'product_id',
                column: 'sales_id'
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
    $(document).on('click', '#skuSubmit', function () {
        $('#create_sales').validate({
            rules: {
                sales_name: {
                    required: true,
                    remote: {
                        url: "<?php echo base_url() . 'index.php/portfolio/productName'; ?>",
                        type: "post",
                        data: {
                            id: $('#innovation_id').val(),
                            year: $('#financial_year').val(),
                            sales_name: function () {
                                return $("#sales_name").val();
                            }
                        }
                    }
                }
            },
            messages: {
                sales_name: {
                    required: "Please enter product name",
                    remote: "Product name already exist"
                }
            }
        });
    });
    $(".saveContinue").on('click', function (e) {
        if ($('#skuData').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/addSales",
                data: $('#skuData').serialize(),
                success: function (msg) {
                    $('#qualitativeData').submit();
                    e.preventDefault();
                }
            });
        }
    });

    function loadYear(year) {
        var inv_id = $('#inv_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/sales/' + inv_id + '/' + year;
    }

    $(document).on('click', '.capitilize', function () {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#cur_finance').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/salesApproved",
            data: {
                inv_id: inv_id,
                fin_year: fin_year
            },
            dataType: 'json',
            success: function (msg) {
                //                                                    $('#pageContent').load(location.href + ' #pageContent');
                //                                                    setTimeout(function () {
                location.reload();
                //                                                    }, 1000);
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



    //                                    p:empty:not(:focus)::before {
    //                                        content: attr(data - placeholder);
    //                                    }
</script>

<style>
    .saleslabel{cursor: pointer;}
</style>

</body>
</html>