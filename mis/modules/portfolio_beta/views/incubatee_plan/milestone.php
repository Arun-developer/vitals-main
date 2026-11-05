<?php
$innovation = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $innovation['name_of_enterprise'];
$reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Plan', 'company_name' => $company_name, 'port_action' => 'plan', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'fin_year' => $current_financial, 'add_class' => 'mar-tp140'));
?>

<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <?php if ($this->session->userdata['approve_success'] == '1') { ?>
        <div id="approveMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Milestone details approved successfully</div>
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
                                    <ul class="milestone-links" id="save-links">
                                        <?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && ($approvals[0]['product_approval'] == 2 || $approvals[0]['sales_approval'] == 2 || $approvals[0]['channel_approval'] == 2 || $approvals[0]['pipeline_approval'] == 2 || $approvals[0]['revenue_approval'] == 2 || $approvals[0]['netprofit_approval'] == 2 || $approvals[0]['vif_approval'] == 2 || $approvals[0]['fundraise_approval'] == 2 || $approvals[0]['mentor_approval'] == 2 || $approvals[0]['tap_approval'] == 2 || $approvals[0]['nontap_approval'] == 2 || $approvaless[0]['dp_approval'] == 2 || $approvaless[0]['board_approval'] == 2 || $approvaless[0]['team_approval'] == 2 || $approvals[0]['impact_approval'] == 2 || $approvals[0]['project_approval'] == 2)) { ?>
                                            <li><a class="approveall" href="javascript:void(0);">Approve All</a></li>
                                        <?php } ?>
                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                            <li><a class="savemilestone" onclick="saveProj()">Save</a></li>
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

                        <div class="tabpanel-detailsconfig config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <div id="leftMenuLoad">
                                <?php
                                $mile_id = isset($milestone_id) && $milestone_id != '' ? $milestone_id : $get_allmilestone[0]['id'];
                                $this->load->view('config_left_menu.php', array('class_name' => 'projectDiv', 'milestone_id' => $mile_id, 'configData' => $dataConfig, 'approvals' => $approvals, 'fin_year' => $current_financial));
                                ?>
                            </div>
                            <main class="page-content" id="pageContent">
                                <div class="row dataconfig">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad0">
                                        <h4>Milestone Tracker</h4>
                                    </div>
                                    <!--                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
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
                                                                                </div>-->
                                                                            </div>

                                                                            <div>
                                                                                <div class="tab-slider--navform">
                                                                                    <ul class="tab-slider--tabsform">
                                                                                        <?php
                                                                                        if (count($get_allmilestone) > 0) {
                                                                                            foreach ($get_allmilestone as $g_miles) {
                                                                                                ?>
                                                                                                <li class="tab-slider--triggerform <?php
                                                                                                if ($milestone_id == $g_miles["id"]) {
                                                                                                    echo 'active';
                                                                                                }
                                                                                                ?>">
                                                                                                <a href="<?= base_url() . 'index.php/portfolio/milestone/' . $innovation_id . '/' . $current_financial . '/' . $g_miles["id"]; ?>"><?= $g_miles['name'] ?></a>
                                                                                            </li>
                                                                                            <?php
                                                                                        }
                                                                                    } else {
                                                                                        ?>
                                                                                        <li class="tab-slider--triggerform active">
                                                                                            <a href="<?= base_url() . 'index.php/portfolio/milestone/' . $innovation_id . '/' . $current_financial; ?>">Milestone 1</a>
                                                                                        </li>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </ul>
                                                                            </div>
                                                                        </div>

                                                                        <div class="tab-slider--container innerTabsPlansetup">
                                                                            <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                                                                <div class="inputplan-structureall plan-structure-new wdt-100">

                                                                                    <div class="Plan-structure">
                                                                                        <div class="quaterlyNewplanstru">
                                                                                            <div class="row">
                                                                                                <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                                                                    <h4 class="popup_milestone"><?= isset($get_milestone[0]['name']) ? $get_milestone[0]['name'] : 'Milestone 1'; ?></h4>
                                                            <?php /* if ($approvals[0]['project_approval'] == 2) { ?>
                                                              <h4 class="popup_milestone"><?= isset($get_milestone[0]['name']) ? $get_milestone[0]['name'] : 'Milestone 1'; ?> : <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                              <?php } else if ($approvals[0]['project_approval'] == 3) { ?>
                                                              <h4 class="popup_milestone"><?= isset($get_milestone[0]['name']) ? $get_milestone[0]['name'] : 'Milestone 1'; ?> : <span class="text-success"><small>(Approved)</small></span></h4>
                                                              <?php } else { ?>
                                                              <h4 class="popup_milestone"><?= isset($get_milestone[0]['name']) ? $get_milestone[0]['name'] : 'Milestone 1'; ?></h4>
                                                          <?php } */ ?>
                                                      </div>

                                                      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12 text-right">
                                                        <ul class="milestone-links">
                                                            <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                <li> <a href="javascript:void(0)" class="edit-btnconfig" id="edit_milestone"><i class="fas fa-pencil-alt"></i> Edit Title</a></li>
                                                                <?php
                                                                if (isset($get_milestone[0]['name']) && $get_milestone[0]['name'] != '') {
                                                                    ?>
                                                                    <li> <a href="javascript:void(0)" class="delete-btnconfig" id="delete_milestone" data-toggle="modal" data-target="#deletemilemodal"><i class="fas fa-trash-alt"></i> Delete Milestone</a></li>
                                                                <?php } ?>
                                                                <li class="brd-left-onboard"><a href="javascript:void(0)" class="edit-btnconfig" id="addMilestone"><i class="fas fa-plus-circle"></i> Add New Milestone</a></li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <?php if (($this->session->userdata['sector_lead'] == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && $approvals[0]['project_approval'] == 2) { ?>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="approved-btn text-right">
                                                                <button type="button" class="btn btn-success capitilize">Approve</button>
                                                                <div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="milestone-task">
                                                    <nav>
                                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                            <?php
                                                            if (count($get_task) > 0) {
                                                                foreach ($get_task as $task) {
                                                                    ?>
                                                                    <a class="nav-item nav-link viewTask" id="task<?= $task['id']; ?>" data-toggle="tab" href="#taskone" role="tab" aria-controls="nav-home" aria-selected="true" onclick="GetTaskDetails('<?= $task['id']; ?>')"><?= $task['task_name']; ?></a>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <a class="nav-item nav-link active" id="task1" data-toggle="tab" href="#taskone" role="tab" aria-controls="nav-home" aria-selected="true" >Task 1</a>
                                                            <?php } ?>
                                                            <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                <a class="nav-item nav-link" href="javascript:void(0)" class="edit-btnconfig" id="addTask"><i class="fas fa-plus-circle"></i> Add New Task</a>
                                                            <?php } ?>
                                                        </div>
                                                    </nav>
                                                    <div class="clearfix"></div>
                                                    <div class="tab-content" id="nav-tabContent">
                                                        <form name="projform" id="projform" method="post" action="<?php echo base_url(); ?>index.php/portfolio/addProject" >
                                                            <input type='hidden' name='updatePlan' id="updatePlan" value="0">
                                                            <input type='hidden' name='approvalStatus' value="1">
                                                            <input type='hidden' name='projfy' value="<?= $current_financial; ?>">
                                                            <div class="tab-pane fade show active" id="taskone" role="tabpanel" aria-labelledby="task1">
                                                                <div class="row">
                                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                        <label>Task Title</label>
                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                        <div class="form-group">
                                                                            <input class="form-control form-control-sm" maxlength="50" type="text" name="project_task" id="project_task" value="<?= isset($get_task) && $get_task[0]['id'] != '' ? $get_task[0]['task_name'] : '' ?>">
                                                                        </div>
                                                                    </div>
                                                                    <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 text-right">
                                                                            <ul class="milestone-links">
                                                                                <li id="editProj">
                                                                                    <a href="javascript:void(0)" class="edit-btnconfig" id="edit_task"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                                                </li>
                                                                                <?php if (isset($get_task) && $get_task[0]['id'] != '') { ?>
                                                                                    <li>
                                                                                        <a class="deleteControl delete-btnconfig" id="deleteTask"  data-toggle="modal" data-target="#deletemodal" href="javascript:void(0);"><i class="fas fa-trash"></i> Delete</a>
                                                                                    </li>
                                                                                <?php } ?>
                                                                            </ul>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                        <label>Area</label>
                                                                    </div>
                                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-2 col-12">
                                                                        <div class="form-group">
                                                                            <select name="project_area" id="project_area" class="form-control form-control-sm disable_type">
                                                                                <option value="">--Select--</option>
                                                                                <?php foreach ($project_area as $area) { ?>
                                                                                    <option value="<?= $area['id']; ?>" <?php
                                                                                    if ($get_proj[0]['area'] == $area['id']) {
                                                                                        echo 'selected';
                                                                                    }
                                                                                    ?>><?= $area['name']; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-2 col-12">
                                                                        <div class="form-group">
                                                                            <input class="form-control form-control-sm" maxlength="200" type="text" name="project_area_text" id="project_area_text" value="<?= isset($get_proj) && $get_proj[0]['area_content'] != '' ? $get_proj[0]['area_content'] : '' ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                        <label>Assigned to</label>
                                                                    </div>
                                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-2 col-12">
                                                                        <div class="form-group">
                                                                            <select name="project_assign_type" id="project_assign_type" class="form-control form-control-sm disable_type">
                                                                                <option value="">--Select--</option>
                                                                                <?php foreach ($project_assign_type as $assign) { ?>
                                                                                    <option value="<?= $assign['id']; ?>" <?php
                                                                                    if ($get_proj[0]['assign_type'] == $assign['id']) {
                                                                                        echo 'selected';
                                                                                    }
                                                                                    ?>><?= $assign['name']; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-2 col-12">
                                                                        <div class="form-group">
                                                                            <input class="form-control form-control-sm" maxlength="50" type="text" name="project_assigned" id="project_assigned" value="<?= isset($get_proj) && $get_proj[0]['assigned_to'] != '' ? $get_proj[0]['assigned_to'] : '' ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                        <label>Description</label>
                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                        <div class="form-group">
                                                                            <textarea class="form-control form-control-sm" rows="3" name="project_description" id="project_description" maxlength="250"><?= isset($get_proj) && $get_proj[0]['id'] != '' ? $get_proj[0]['description'] : '' ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                $chkd = isset($get_proj) && $get_proj[0]['type'] == '1' ? 'checked' : '';
                                                                $chkd2 = isset($get_proj) && $get_proj[0]['type'] == '2' ? 'checked' : '';
                                                                $chkd3 = isset($get_proj) && $get_proj[0]['type'] == '3' ? 'checked' : '';
                                                                ?>
                                                                <div class="milestone-details">
                                                                    <div style="height:20px;"></div>
                                                                    <div class="row">
                                                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                            <label>Meeting Type</label>
                                                                        </div>
                                                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input project_type" type="checkbox" name="project_type" id="project_type1" value="1" <?= $chkd; ?>>
                                                                                <label class="form-check-label disable_type" for="project_type1">
                                                                                    Diagnostic Panel
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input project_type" type="checkbox" name="project_type" id="project_type2" value="2" <?= $chkd2; ?>>
                                                                                <label class="form-check-label disable_type" for="project_type2">
                                                                                    Board Meeting
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input project_type" type="checkbox" name="project_type" id="project_type3" value="3" <?= $chkd3; ?>>
                                                                                <label class="form-check-label disable_type" for="project_type3">
                                                                                    Others
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div style="height:20px;"></div>
                                                                    <div class="row">
                                                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                            <label>Due by</label>
                                                                        </div>
                                                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                            <div class="form-group">
                                                                                <input type="text" name="project_due_by" id="project_due_by" placeholder="dd-mm-yyyy" value="<?= isset($get_proj[0]['due_by']) && $get_proj[0]['due_by'] != '0000-00-00 00:00:00' ? date("d-m-Y", strtotime($get_proj[0]['due_by'])) : '' ?>" class="form-control form-control-sm dateCalendar" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12 text-right">
                                                                            <label>Completed on</label>
                                                                        </div>
                                                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                            <div class="form-group">
                                                                                <input type="text" name="project_completed_on" id="project_completed_on" placeholder="dd-mm-yyyy" value="<?= isset($get_proj[0]['completed_on']) && $get_proj[0]['completed_on'] != '0000-00-00 00:00:00' ? date("d-m-Y", strtotime($get_proj[0]['completed_on'])) : '' ?>" class="form-control form-control-sm dateCalendar" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div style="height:15px;"></div>
                                                                    <div class="row">
                                                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                            <label>Notes</label>
                                                                        </div>
                                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                            <div class="form-group">
                                                                                <textarea class="form-control form-control-sm" rows="2" maxlength="250" name="project_note" id="project_note"><?= isset($get_proj) && $get_proj[0]['id'] != '' ? $get_proj[0]['notes'] : '' ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12 text-right">
                                                                            <input type="hidden" name="task_count" id="task_count" value="<?= count($get_proj); ?>">
                                                                            <input type="hidden" name="edit_task_id" id="edit_task_id" value="<?= isset($get_task) && $get_task[0]['id'] != '' ? $get_task[0]['id'] : '' ?>" />
                                                                            <input type="hidden" name="edit_proj_id" id="edit_proj_id" value="<?= isset($get_proj) && $get_proj[0]['id'] != '' ? $get_proj[0]['id'] : '' ?>" />
                                                                            <input type='hidden' name='proj_innovation_id' id="proj_innovation_id" value="<?= $innovation_id; ?>">
                                                                            <input type='hidden' name='proj_milestone_id' id="proj_milestone_id" value="<?= $milestone_id; ?>">
                                                                            <input type="hidden" name="sendApproval" id="sendApproval" value="0" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
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

<div class="modal" id="dataconfig" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content data_congifpopup">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel"><span class="text-success"><i
                    class="fas fa-check-circle"></i></span> Data Configured Successfully</h5>
                </div>
                <div class="modal-body onboarding-permission text-center">
                    <ul>
                        <li>You have successfully configured data for "<strong>
                            <?php
                            echo ucfirst($company_name) . ', ';
                            if ($reg_city != '') {
                                echo ucfirst($reg_city) . ' - ';
                            }
                            if ($sector_name != '') {
                                echo ucfirst($sector_name);
                            }
                            ?>
                        </strong>"</li>
                        <li>Configure the company goals for the year</li>
                    </ul>
                    <div class="popup-content-final popup-content">
                        <a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Close</a>
                        <a class="btn-configure btn" href="<?= base_url() . 'index.php/portfolio/company_profile/' . $innovation_id; ?>" >Go to Company profile</a>
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
                                <h4>Are you sure you want to delete selected task?</h4>
                                <p>you are about to delete the selected information fields, you
                                can't undo this</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal"
                       aria-label="Close">Cancel</a></button>
                       <button type="button" class="btn btn-success" onclick="deleteTask()" id="deleteRecord"> Delete Selected</button>
                   </div>
               </div>
           </div>
           <input type="hidden" id="deleteID" value="">
       </div>
       <div class="modal" id="deletemilemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content delete-alert">
                <div class="modal-body text-center">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-2">
                                <i class="fas fa-exclamation"></i>
                            </div>
                            <div class="col-10">
                                <h4>Are you sure you want to delete selected milestone?</h4>
                                <p>you are about to delete the selected information fields, you
                                can't undo this</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal"
                       aria-label="Close">Cancel</a></button>
                       <button type="button" class="btn btn-success" onclick="deleteMilestone()" id="deleteMileRecord"> Delete Selected</button>
                   </div>
               </div>
           </div>
           <input type="hidden" id="deleteID" value="">
       </div>

       <div class="modal" id="milestonemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content delete-alert">
                <form method="post" id="create_mile" action="<?php echo base_url() . 'index.php/portfolio/addMilestone'; ?>" autocomplete="off">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <h4 class="text-center popup_milestone" id="milesTitle">Add New Milestone Title</h4>
                                <div class="col-12">
                                    <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                    <div >
                                        <p>Milestone Title</p>
                                        <div class="form-group">
                                            <input type="text" name="milestone_name" id="milestone_name" class="form-control form-control-sm" placeholder="Milestone title">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type='hidden' name='approvalStatus' value="1">
                        <input type='hidden' name='milefy' value="<?= $current_financial; ?>">
                        <input type="hidden" name="milestone_edit_id" id="milestone_edit_id" />
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <input type="submit" id="mileSubmit" class="btn add-btnconfig brd-rd30 btn-success btn-sm" value="Add">
                    </div>
                </form>
            </div>
        </div>
        <input type="hidden" id="deleteID" value="">
    </div>

    <div class="modal" id="taskmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content delete-alert">
                <form method="post" id="create_task" action="<?php echo base_url() . 'index.php/portfolio/addTask'; ?>" autocomplete="off">
                    <div class="modal-body text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <h4 class="text-center popup_milestone" id="milesTitle">Add New Task Title</h4>
                                <div class="col-12">
                                    <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
                                    <div >
                                        <p>Milestone Title</p>
                                        <div class="form-group">
                                            <input type="text" name="milestone_task" id="milestone_task" class="form-control form-control-sm" placeholder="Add new milestone title" readonly="">
                                        </div>
                                    </div>
                                    <div >
                                        <p>Task Title</p>
                                        <div class="form-group">
                                            <input type="text" name="task_name" id="task_name" class="form-control form-control-sm" placeholder="Add new task title" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type='hidden' name='approvalStatus' value="1">
                        <input type='hidden' name='taskfy' value="<?= $current_financial; ?>">
                        <input type="hidden" name="milestone_id" id="milestone_id" />
                        <input type="hidden" name="task_edit_id" id="task_edit_id" />
                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <input type="submit" id="taskSubmit" class="btn add-btnconfig brd-rd30 btn-success btn-sm" value="Add">
                    </div>
                </form>
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
                            <a class="btn btn-configure" data-toggle="modal" data-target="#sendapproval">Send for Approval Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

            <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
            <input type='hidden' name='cur_finance' id="cur_finance" value="<?= $current_financial; ?>">

            <?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio')); ?>

            <script type="text/javascript">

                $("input:checkbox").on('click', function () {
                    var $box = $(this);
                    if ($box.is(":checked")) {
                        var group = "input:checkbox[name='" + $box.attr("name") + "']";
                        $(group).prop("checked", false);
                        $box.prop("checked", true);
                    } else {
                        $box.prop("checked", false);
                    }
                });

                $(document).ready(function () {
                    var taskcnt = $('#task_count').val();
                    if (taskcnt > 0) {
                        $('#projform input, #projform select, #projform textarea, #project_assigned').attr('readonly', 'readonly');
                        $('input[type="checkbox"]').addClass('opacity5');
                        $('input[type="checkbox"], .disable_type').css('pointer-events', 'none');
                        $('input[type="checkbox"]').css('pointer-events', 'none');
                        $('.dateCalendar, #project_assigned').css('pointer-events', 'none');
                    }
                    $("#project_due_by").datepicker({dateFormat: "dd-mm-yy", minDate: 0});
//                                        $("#project_completed_on").datepicker({dateFormat: "dd-mm-yy", minDate: 0});
$("#project_completed_on").datepicker({dateFormat: "dd-mm-yy"});
$('.viewTask').first().addClass('active');

$('#edit_task').addClass('opacity5');
$('#deleteTask').addClass('opacity5');

var popup = $('#planBox').val();
//                                        if (popup == 1) {
//                                            $('#planModal').modal('show');
//                                        } else {
//                                            $('#planModal').modal('hide');
//                                        }

setTimeout(function () {
    $('#approveMsg').hide();
    $('#approveallMsg').hide();
}, 3000);

<?php if (isset($get_task) && $get_task[0]['id'] != '') { ?>
    GetTaskDetails(<?= $get_task[0]['id']; ?>);
<?php } ?>
});

                $(document).on('click', '#sendApproval', function () {
                    $('#sendapproval').modal('show');
                });

                function sendApproval() {
                    var inv_id = $('#innovation_id').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/portfolio/sendapproval",
                        data: {
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

                $('#addMilestone').on('click', function () {
                    $("label.error").hide();
                    $(".error").removeClass("error");
                    $('#milestonemodal').modal('show');
                    $('#milesTitle').text('Add New Milestone Title');
                    $('#milestone_name').val('');
                    $('#milestone_edit_id').val('');
                    $('#mileSubmit').val('Add');
                });

                $('#edit_milestone').on('click', function () {
                    $("label.error").hide();
                    $(".error").removeClass("error");
                    $('#milestonemodal').modal('show');
                    $('#milesTitle').text('Update Milestone Title');
                    $('#milestone_name').val("<?= isset($get_milestone[0]['name']) ? $get_milestone[0]['name'] : 'Milestone 1' ?>");
                    $('#milestone_edit_id').val('<?= $get_milestone[0]['id'] ?>');
                    $('#mileSubmit').val('Update');
                });

                $('#addTask').on('click', function () {
                    $('#taskmodal').modal('show');
                    $('#milestone_task').val("<?= isset($get_milestone[0]['name']) ? $get_milestone[0]['name'] : 'Milestone 1' ?>");
                    $('#milestone_id').val('<?= $get_milestone[0]['id'] ?>');
                    $('#taskSubmit').val('Add');
                });

                $(document).on('click', '#edit_task', function () {
                    $('.savemilestone').text('Save');
                    $('#updatePlan').val('1');
                    $('#editProj').html('<a href="javascript:void(0)" class="edit-btnconfig" id="cancel_edit"><i class="fas fa-times"></i> Cancel</a>');
                    $('#projform input, #projform select, #projform textarea, #project_assigned').attr('readonly', false);
                    $('input[type="checkbox"]').removeClass('opacity5');
                    $('input[type="checkbox"], .disable_type').css('pointer-events', '');
                    $('.dateCalendar, #project_assigned').css('pointer-events', '');
                    $('#edit_task').removeClass('opacity5');
                });

                $(document).on('click', '#cancel_edit', function () {
                    $('.savemilestone').text('Save');
                    $('#updatePlan').val('0');
                    $('#editProj').html('<a href="javascript:void(0)" class="edit-btnconfig" id="edit_task"><i class="fas fa-pencil-alt"></i> Edit</a>');
                    $('#projform input, #projform select, #projform textarea, #project_assigned').attr('readonly', 'readonly');
                    $('input[type="checkbox"]').removeClass('opacity5');
                    $('input[type="checkbox"], .disable_type').css('pointer-events', '');
                    $('.dateCalendar, #project_assigned').css('pointer-events', 'none');
                });

                $(document).on('click', '#mileSubmit', function () {
                    $('#create_mile').validate({
                        rules: {
                            milestone_name: {
                                required: true,
                                remote: {
                                    url: "<?php echo base_url() . 'index.php/portfolio/milestoneName'; ?>",
                                    type: "post",
                                    data: {
                                        id: $('#innovation_id').val(),
                                        m_id: $('#milestone_edit_id').val(),
                                        milestone_name: function () {
                                            return $("#milestone_name").val();
                                        }
                                    }
                                }
                            }
                        },
                        messages: {
                            milestone_name: {
                                required: "Please enter milestone title",
                                remote: "Milestone title already exist"
                            }
                        }
                    });
                });

                $(document).on('click', '#taskSubmit', function () {
                    $('#create_task').validate({
                        rules: {
                            task_name: {
                                required: true,
                                remote: {
                                    url: "<?php echo base_url() . 'index.php/portfolio/taskName'; ?>",
                                    type: "post",
                                    data: {
                                        id: $('#innovation_id').val(),
                                        m_id: $('#milestone_id').val(),
                                        task_name: function () {
                                            return $("#task_name").val();
                                        }
                                    }
                                }
                            }
                        },
                        messages: {
                            task_name: {
                                required: "Please enter task title",
                                remote: "Task title already exist"
                            }
                        }
                    });
                });

                function loadYear(year) {
                    var inv_id = $('#innovation_id').val();
                    window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/milestone/' + inv_id + '/' + year;
                }

                $('#savemilestone').on('click', function () {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/portfolio/deleteImpact",
                        data: {
                            finan_yr: finan_yr,
                            imptname: imptname,
                            inv_id: inv_id,
                            jval: dyn,
                            table: 'plan_impact'
                        },
                        dataType: 'json',
                        success: function (msg) {
                            $('#' + divn).load(location.href + ' #' + divn);
                            $('#deletemodal').modal('hide');
                            $('#deleteMsg').show();
                            setTimeout(function () {
                                $('#deleteMsg').hide();
                            }, 3000);
                        }
                    });
                });

                function GetTaskDetails(id) {
                    $('.viewTask').removeClass('active');
                    $('#task' + id).addClass('active');
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/portfolio/getTaskdetails",
                        data: {
                            taskid: id,
                        },
                        dataType: 'json',
                        success: function (msg) {
                            $('#edit_task_id').val(msg.task_id);
                            $('#project_task').val(msg.task_name);
                            $('#edit_proj_id').val(msg.proj_id);
                            $('#project_assigned').val(msg.assigned);
                            $('#project_description').val(msg.description);
                            if (msg.projtype != '') {
                                $('#project_type' + msg.projtype).prop("checked", true);
                            } else {
                                $('input[name=project_type]').prop('checked', false);
                            }
                            $('#project_due_by').val(msg.due_by);
                            $('#project_completed_on').val(msg.completed_on);
                            $('#project_note').val(msg.notes);
                            $('#project_area').val(msg.area);
                            $('#project_area_text').val(msg.area_content);
                            $('#project_assign_type').val(msg.assign_type);
                        }
                    });
                }

                function deleteTask() {
                    var taskid = $('#edit_task_id').val();
                    var mileid = $('#proj_milestone_id').val();
                    var invid = $('#proj_innovation_id').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/portfolio/deleteTaskDetail",
                        data: {
                            taskid: taskid,
                            mileid: mileid,
                            invid: invid
                        },
                        dataType: 'json',
                        success: function (msg) {
//                                                location.reload();
window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/milestone/' + invid + '/' + <?php echo $current_financial; ?> + '/' + mileid;
}
});
                }
                function deleteMilestone() {
                    var mileid = $('#proj_milestone_id').val();
                    var invid = $('#proj_innovation_id').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/portfolio/deleteMilestoneDetail",
                        data: {
                            mileid: mileid,
                            invid: invid
                        },
                        dataType: 'json',
                        success: function (msg) {
                            window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/milestone/' + invid + '/' + <?php echo $current_financial; ?>;
                        }
                    });
                }

                function saveProj() {
                    if ($('#projform').valid()) {
                        $('.savemilestone').css('pointer-events', 'none');
                        $('#projform').submit();
                    }
                }

                $(document).on('click', '.capitilize', function () {
                    var inv_id = $('#innovation_id').val();
                    var mile_id = $('#proj_milestone_id').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/portfolio/projectApproved",
                        data: {
                            inv_id: inv_id,
                            mile_id: mile_id
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

            <style>
                .inputplan-structureall{padding: 0 !important;}
            </style>

        </body>
        </html>