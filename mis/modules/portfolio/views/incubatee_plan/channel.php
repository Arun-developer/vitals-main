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
?>

<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Record(s) deleted successfully</div>
    <div id="updateMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong></div>
    <?php if ($this->session->userdata['approve_success'] == '1') { ?>
        <div id="approveMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Channel details approved successfully</div>
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
                        <a class="nav-item nav-link dataConfig active" id="nav-dataconfig-tab"  href="javascript:void(0);" role="tab" aria-controls="nav-dataconfig" aria-selected="false">Plan Setup</a>
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
                                            <li><a href="javascript:void(0);" class="saveContinue">Save</a></li>
                                        <?php } ?>
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

                        <div class="tabpanel-detailsconfig  config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('config_left_menu.php', array('class_name' => 'channelDiv', 'configData' => $dataConfig, 'approvals' => $approvals, 'fin_year' => $current_financial)); ?>
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
                                            <li class="tab-slider--triggerform active"><a href="javascript:void(0)">Channel&nbsp;
                                                    <?php if ($notify_icon != '' && $approvals[0]['channel_approval'] == 2) { ?>
                                                        <span class="alert-updation"><i class="fas fa-exclamation-circle"></i></span>
                                                    <?php } ?>
                                                </a></li>
                                            <li class="tab-slider--triggerform "><a href="<?= base_url() . 'index.php/portfolio/pipeline/' . $innovation_id . '/' . $current_financial; ?>">Pipeline&nbsp;
                                                    <?php if ($notify_icon != '' && $approvals[0]['pipeline_approval'] == 2) { ?>
                                                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i></span>
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
                                        <div class="inputplan-structureall plan-structure-new wdt-100">
                                            <div class="quaterlyNewplanstru">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
													
                                                        <?php if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['channel_approval'] == 2) { ?>
                                                            <h4>Channel Targets <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                        <?php } else if (($isAssociate == 1 || $this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['channel_approval'] == 3) { ?>
                                                            <h4>Channel Targets <span class="text-success"><small>(Approved)</small></span></h4>
                                                        <?php } else { ?>
                                                            <h4>Channel Targets</h4>
                                                        <?php } ?>
                                                    </div>
                                                    <?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['channel_approval'] == 2) { ?>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right">
                                                            <div class="approved-btn text-right">
                                                                <button type="button" class="btn btn-success capitilize">Approve</button>
                                                                <div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
												
                                                <form method="post" id="create_channel" action="<?php echo base_url() . 'index.php/portfolio/createChannel'; ?>" autocomplete="off">
                                                    <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                                    <input type='hidden' name='cur_finance' id="cur_finance" value="<?= $current_financial; ?>">
                                                   <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                        <div class="add-sales">
                                                            <ul class="milestone-links">
                                                                <li class="valigntop"><p>Channel name</p></li>
                                                                <li><div class="form-group">
                                                                        <input type="text" name="channel_name" id="channel_name" class="form-control form-control-sm" placeholder="Add new channel">
                                                                    </div></li>
                                                                <li class="valigntop"><span><input type="submit" id="channelSubmit" class="btn add-btnconfig brd-rd30 btn-success btn-sm" value="Add"></span></li>
                                                            </ul>
                                                        </div>
                                                    <?php } ?>
                                                </form>

                                                <div id='accordion' class="brd-tp wdt-100">
                                                    <form id="channelData" class="Plan-structure" method="post" action="<?php echo base_url() . 'index.php/portfolio/addChannels'; ?>" autocomplete="off">
                                                        <input type='hidden' name='inv_id' id="inv_id" value="<?= $innovation_id; ?>">
                                                        <input type='hidden' name='finance_Year' id="finance_Year" value="<?= $current_financial; ?>">
                                                        <input type='hidden' name='updatePlan' id="updatePlan" value="0">
                                                        <?php
                                                        $i = 1;
                                                        if (php72_count($channel_data) > 0) {
                                                            foreach ($channel_data as $row) {
                                                                $get_month = json_decode($row['data']);

                                                                $obj = json_decode($row['data'], true);
                                                                if (!php72_array_filter($obj)) {
                                                                    $enable = 0;
                                                                } else {
                                                                    $enable = 1;
                                                                }
                                                                ?>

                                                                <input type="hidden" class="enableCount" id="enableCount_<?= $i; ?>" value="<?= $enable; ?>">
                                                                <input type="hidden" name="row_id" id="row_id" value="<?= $i; ?>">
                                                                <input type="hidden" name="channel_id<?= $i; ?>" id="channel_id<?= $i; ?>" value="<?= $row['channel_id']; ?>">
                                                                <div>
                                                                    <div class=" table_configcontentnew table_content" id="table_content_<?= $i; ?>">
                                                                        <table class="table">
                                                                            <thead>
                                                                            <th colspan="9" id="edit_channelname<?= $i; ?>" ><span class="channellabel" onclick="editChannelName('<?= $row['channel_id']; ?>', '<?= $row['channel_name']; ?>')"><?= $row['channel_name']; ?></span></th>

                                                                            <th class="text-right" colspan="3">
                                                                                <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                                    <ul class="milestone-links">
                                                                                        <li id='editSec<?= $i; ?>'><a href="javascript:void(0)" id="edit_cmpny_<?= $i; ?>" class="edit-btnconfig" onclick="editBtn(<?= $i; ?>)"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                                                                        <li><a href="javascript:void(0)" class="delete-btnconfig opacity5" onclick="deleteBtn(<?= $row['channel_id']; ?>)"><i class="fas fa-trash"></i> Delete</a></li>
                                                                                    </ul>
                                                                                <?php } ?>
                                                                            </th>

                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <p><?= $get_month_list[0]; ?></p>
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="month<?= $i; ?>[]" value="<?= $get_month->{$get_month_list[0]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p><?= $get_month_list[1]; ?></p>
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="month<?= $i; ?>[]" value="<?= $get_month->{$get_month_list[1]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p><?= $get_month_list[2]; ?></p>
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="month<?= $i; ?>[]" value="<?= $get_month->{$get_month_list[2]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p><?= $get_month_list[3]; ?></p>
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="month<?= $i; ?>[]" value="<?= $get_month->{$get_month_list[3]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p><?= $get_month_list[4]; ?></p>
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="month<?= $i; ?>[]" value="<?= $get_month->{$get_month_list[4]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p><?= $get_month_list[5]; ?></p>
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="month<?= $i; ?>[]" value="<?= $get_month->{$get_month_list[5]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p><?= $get_month_list[6]; ?></p>
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="month<?= $i; ?>[]" value="<?= $get_month->{$get_month_list[6]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p><?= $get_month_list[7]; ?></p>
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="month<?= $i; ?>[]" value="<?= $get_month->{$get_month_list[7]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p><?= $get_month_list[8]; ?></p>
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="month<?= $i; ?>[]" value="<?= $get_month->{$get_month_list[8]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p><?= $get_month_list[9]; ?></p>
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="month<?= $i; ?>[]" value="<?= $get_month->{$get_month_list[9]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p><?= $get_month_list[10]; ?></p>
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="month<?= $i; ?>[]" value="<?= $get_month->{$get_month_list[10]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p><?= $get_month_list[11]; ?></p>
                                                                                        <div class="form-group">
                                                                                            <input type="text" name="month<?= $i; ?>[]" value="<?= $get_month->{$get_month_list[11]}; ?>" class="form-control form-control-sm volumefld" maxlength="20" placeholder="00">
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <br/>
                                                                </div>

                                                                <?php
                                                                $i++;
                                                            }
                                                        }
                                                        ?>
                                                    </form>
                                                </div>
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
                    <a class="btn btn-configure " href="javascript:void(0)" onclick="sendApproval();">Okay</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Model (Add channel) -->
<div class="modal" id="channelmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <form method="post" id="Update_channel" action="<?php echo base_url() . 'index.php/portfolio/editChannel'; ?>" autocomplete="off">
                <div class="modal-body text-center">
                    <div class="container-fluid">
                        <div class="row">
                            <h4 class="text-center popup_milestone" id="milesTitle">Edit Channel Name</h4>
                            <div class="col-12">
                                <input type='hidden' name='edit_innovation_id' id="edit_innovation_id" value="<?= $innovation_id; ?>">
                                <div >
                                    <p>Channel Name</p>
                                    <div class="form-group">
                                        <input type="text" name="edit_channel_name" id="edit_channel_name" class="form-control form-control-sm" placeholder="Channel name">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type='hidden' name='edit_cur_finance' id="edit_cur_finance" value="<?= $current_financial; ?>">
                    <input type="hidden" name="channel_edit_id" id="channel_edit_id" />
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
?>

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio')); ?>

<script type="text/javascript">

    $(document).ready(function () {
        $('.channellabel').css("cursor", "pointer");
        var popup = $('#planBox').val();
        //                                    if (popup == 1) {
        //                                        $('#planModal').modal('show');
        //                                    } else {
        //                                        $('#planModal').modal('hide');
        //                                    }
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

    $(document).on('click', '#editSubmit', function () {
        var channel_id = $('#channel_edit_id').val();
        var finan_yr = $('#edit_cur_finance').val();
        var inv_id = $('#edit_innovation_id').val();
        var channel_name = $('#edit_channel_name').val();
        $('#Update_channel').validate({
            rules: {
                edit_channel_name: {
                    required: true,
                    remote: {
                        url: "<?php echo base_url() . 'index.php/portfolio/checkChannel'; ?>",
                        type: "post",
                        data: {
                            id: channel_id,
                            yr: finan_yr,
                            inv_id: inv_id,
                            //                                                        channel_name: channel_name,
                            edit_channel_name: function () {
                                return $("#edit_channel_name").val();
                            }
                        }
                    }
                }
            },
            messages: {
                edit_channel_name: {
                    required: "Please enter channel name",
                    remote: "Channel name already exist"
                }
            }
        });
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

    function onLoad() {
        $('.enableCount').each(function (key, value) {
            var inc = key + 1;
            var editOpt = $('#enableCount_' + inc).val();
            if (editOpt > 0) {
                $('#table_content_' + inc + ' input[type="text"]').attr('readonly', 'readonly');
            } else {
                $('#table_content_' + inc + ' input[type="text"]').attr('readonly', false);
            }
            $('#edit_cmpny_' + inc).addClass('opacity5');
        });
    }

    function editChannelName(editid, channel) {
        $('#channel_edit_id').val(editid);
        $('#edit_channel_name').val(channel);
        $('#channelmodal').modal('show');
    }

    function editBtn(id) {
        $('#editSec' + id).html('<a href="javascript:void(0)" class="edit-btnconfig" onclick="cancelBtn(' + id + ')" id="cancel_edit_' + id + '"><i class="fas fa-times"></i> Cancel</a>');
        $('.saveContinue').text('Save');
        $('#updatePlan').val('1');
        $('#table_content_' + id + ' input[type="text"]').attr('readonly', false);
        $('#edit_cmpny_' + id).removeClass('opacity5');
    }

    function cancelBtn(id) {
        $('#editSec' + id).html('<a href="javascript:void(0)" id="edit_cmpny_' + id + '" class="edit-btnconfig" onclick="editBtn(' + id + ')" ><i class="fas fa-pencil-alt"></i> Edit</a>');
        $('.saveContinue').text('Save');
        $('#updatePlan').val('0');
        onLoad();
    }

    function deleteBtn(sales_id) {
        $('#deletemodal').modal('show');
        $('#deleteID').val(sales_id);
    }

    $('#deleteRecord').on('click', function () {
        var channel_id = $('#deleteID').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/deletePortfolioConfig",
            data: {
                fields: 'data',
                id: channel_id,
                table: 'port_channel_data',
                temp_table: 'temp_channel_data',
                plan_table: 'plan_channel',
                plan_column: 'channel_id',
                column: 'channel_id'
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





    $(document).on('click', '#channelSubmit', function () {
        $('#create_channel').validate({
            rules: {
                channel_name: {
                    required: true,
                    remote: {
                        url: "<?php echo base_url() . 'index.php/portfolio/channelName'; ?>",
                        type: "post",
                        data: {
                            id: $('#innovation_id').val(),
                            year: $('#financial_year').val(),
                            channel_name: function () {
                                return $("#channel_name").val();
                            }
                        }
                    }
                }
            },
            messages: {
                channel_name: {
                    required: "Please enter channel name",
                    remote: "Channel name already exist"
                }
            }
        });
    });

    $(".saveContinue").on('click', function (e) {
        if ($('#channelData').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#channelData').submit();
            e.preventDefault();
        }
    });

    function loadYear(year) {
        var inv_id = $('#inv_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/channel/' + inv_id + '/' + year;
    }

    $(document).on('click', '.capitilize', function () {
        var inv_id = $('#innovation_id').val();
        var fin_year = $('#cur_finance').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/channelApproved",
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