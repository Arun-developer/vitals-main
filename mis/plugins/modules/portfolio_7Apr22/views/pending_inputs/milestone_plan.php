
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Villgro MIS</title>

        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
        <!-- Library css -->
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    </head>

    <body>
        <?php
        $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
        $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';

        $company_name = isset($plan_header) ? $plan_header['company_data'][0]['name'] : '';
        $reg_city = isset($plan_header) ? $plan_header['company_data'][0]['reg_city'] : '';
        $sector_name = isset($plan_header) ? $plan_header['sector_name'] : '';

        $this->load->view('all_forms/header.php', array('page_title' => 'Milestone Tracker', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name));
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
                                <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/plan_updates/' . $innovation_id; ?>" role="tab" aria-controls="nav-Companymaster" aria-selected="true">Updates</a>
                                <a class="nav-item nav-link filled-data" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/sales_plan/' . $innovation_id; ?>" aria-controls="nav-business" aria-selected="false">Sales &amp; Pipeline</a>
                                <a class="nav-item nav-link filled-data" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/finance_plan/' . $innovation_id; ?>" aria-controls="nav-management" aria-selected="false">Finance &amp; Fundraise</a>
                                <a class="nav-item nav-link filled-data" id="nav-governance-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/impact_plan/' . $innovation_id; ?>" aria-controls="nav-governance" aria-selected="false">Impact</a>
                                <a class="nav-item nav-link filled-data" id="nav-relationship-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/hiring_plan/' . $innovation_id; ?>" aria-controls="nav-relationship" aria-selected="false">Team, TAP &amp; Mentors</a>
                                <a class="nav-item nav-link filled-data" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/dp_plan/' . $innovation_id; ?>" aria-controls="nav-incubation" aria-selected="true">Diagnostic Panels &amp; Board Meetings</a>
                                <a class="nav-item nav-link" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/pending_inputs/notes_plan/' . $innovation_id; ?>" aria-controls="nav-cap" aria-selected="false">Meetings &amp; Call Notes</a>
                                <a class="nav-item nav-link active" id="nav-cap-tab" href="javascript:void(0)" aria-controls="nav-cap" aria-selected="false">08</a>
                                <a class="nav-item nav-link brd-none bg-trasnparent" id="nav-about-tab"  href="#nav-about"  aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                                <a class="nav-item nav-link dataconfig_btn" id="nav-dataconfig-tab" href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id; ?>" role="tab" aria-controls="nav-dataconfig" aria-selected="false">View all forms</a>
                            </div>
                        </nav>
                        <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-Companymaster" role="tabpanel" aria-labelledby="nav-Companymaster-tab">
                                <div class="tabpanel-title">
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                            <h4>Milestone Tracker</h4>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                                            <ul class="milestone-links">
                                                <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                    <li><a class="savemilestone" onclick="saveProj()">Save</a></li>
                                                <?php } ?>
                                                <li>
                                                    <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend"><i class="far fa-question-circle"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabpanel-details pad-none config-wrapper dataconfig-content page-wrapper chiller-theme">
                                    <nav id="sidebar" data-topbar data-options="scrolltop:false" class="sidebar-wrapper top-bar">
                                        <div class="sidebar-content">
                                            <div class="sidebar-menu">
                                                <ul>
                                                    <li class="sidebar-dropdown no-arrow active ">
                                                        <a href="javascript:void(0)">
                                                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/project.png'; ?>" >
                                                            <span>Milestone Tracker</span>
                                                        </a>
                                                        <div class="sidebar-submenu sidebar_show">
                                                            <ul>
                                                                <?php
                                                                if (count($get_allmilestone) > 0) {
                                                                    foreach ($get_allmilestone as $miles) {
                                                                        ?>
                                                                        <li class="pending_month_btn <?php
                                                                        if ($milestone_id == $miles["id"]) {
                                                                            echo 'active';
                                                                        }
                                                                        ?>">
                                                                            <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/milestone_plan/' . $innovation_id . '/' . $miles["id"]; ?>"><?= $miles['name'] ?></a>
                                                                        </li>
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <li class="active pending_month_btn">
                                                                        <a href="<?= base_url() . 'index.php/portfolio/pending_inputs/milestone_plan/' . $innovation_id . '/' . $current_financial; ?>">Milestone 1</a>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </nav>
                                    <main class="page-content" id="pageContent">
                                        <div class="row dataconfig">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <?php if ($approvals[0]['project_approval'] == 2) { ?>
                                                    <h4 class="popup_milestone"><?= isset($get_milestone[0]['name']) ? $get_milestone[0]['name'] : 'Milestone 1'; ?></h4>
                                                <?php } else if ($approvals[0]['project_approval'] == 3) { ?>
                                                    <h4 class="popup_milestone"><?= isset($get_milestone[0]['name']) ? $get_milestone[0]['name'] : 'Milestone 1'; ?></h4>
                                                <?php } else { ?>
                                                    <h4 class="popup_milestone"><?= isset($get_milestone[0]['name']) ? $get_milestone[0]['name'] : 'Milestone 1'; ?></h4>
                                                <?php } ?>
                                            </div>
                                            <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12 text-right">
                                                    <ul class="milestone-links">
                                                        <li> <a href="javascript:void(0)" class="edit-btnconfig" id="edit_milestone"><i class="fas fa-pencil-alt"></i> Edit Title</a></li>
                                                        <?php
                                                        if (isset($get_milestone[0]['name']) && $get_milestone[0]['name'] != '') {
                                                            ?>
                                                            <li> <a href="javascript:void(0)" class="delete-btnconfig" id="delete_milestone" data-toggle="modal" data-target="#deletemilemodal"><i class="fas fa-trash-alt"></i> Delete Milestone</a></li>
                                                        <?php } ?>
                                                        <li class="brd-left-onboard"><a href="javascript:void(0)" class="edit-btnconfig" id="addMilestone"><i class="fas fa-plus-circle"></i> Add New Milestone</a></li>
                                                    </ul>

                                                </div>
                                            <?php } ?>
                                        </div>
                                        <hr class="cofig-spliter">
                                        <div class="Plan-structure milestone-task">
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
                                                    <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
                                                        <a class="nav-item nav-link" href="javascript:void(0)" class="edit-btnconfig" id="addTask"><i class="fas fa-plus-circle"></i> Add New Task</a>
                                                    <?php } ?>
                                                </div>
                                            </nav>
                                            <div class="clearfix"></div>
                                            <div class="tab-content" id="nav-tabContent">
                                                <form name="projform" id="projform" method="post" action="<?php echo base_url(); ?>index.php/portfolio/addProject" >
                                                    <input type='hidden' name='updatePlan' id="updatePlan" value="0">
                                                    <input type='hidden' name='approvalStatus' value="1">
                                                    <div class="tab-pane fade show active" id="taskone" role="tabpanel" aria-labelledby="task1">
                                                        <div class="row">

                                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                <label>Task Title<span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                <div class="form-group">
                                                                    <input class="form-control form-control-sm" maxlength="50" type="text" name="project_task" id="project_task" value="<?= isset($get_task) && $get_task[0]['id'] != '' ? $get_task[0]['task_name'] : '' ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12 text-right">
                                                                <label>Assigned to</label>
                                                            </div>
                                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                <div class="form-group">
                                                                    <input class="form-control form-control-sm" maxlength="50" type="text" name="project_assigned" id="project_assigned" value="<?= isset($get_proj) && $get_proj[0]['assigned_to'] != '' ? $get_proj[0]['assigned_to'] : '' ?>">
                                                                </div>
                                                            </div>
                                                            <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == 1) { ?>
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
                                                                <label>Description<span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                <div class="form-group">
                                                                    <textarea class="form-control form-control-sm" maxlength="250" rows="3" name="project_description" id="project_description"><?= isset($get_proj) && $get_proj[0]['id'] != '' ? $get_proj[0]['description'] : '' ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $chkd = isset($get_proj) && $get_proj[0]['type'] == '1' ? 'checked' : '';
                                                        $chkd2 = isset($get_proj) && $get_proj[0]['type'] == '2' ? 'checked' : '';
                                                        ?>
                                                        <div class="milestone-details">
                                                            <div style="height:20px;"></div>
                                                            <div class="row">
                                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                    <label>Meeting Type</label>
                                                                </div>
                                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input project_type" type="radio" name="project_type" id="project_type1" value="1" <?= $chkd; ?>>
                                                                        <label class="form-check-label disable_type" for="project_type1">
                                                                            Diagnostic Panel
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input project_type" type="radio" name="project_type" id="project_type2" value="2" <?= $chkd2; ?>>
                                                                        <label class="form-check-label disable_type" for="project_type2">
                                                                            Board Meeting
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
                                                                        <input type="text" name="project_due_by" id="project_due_by" placeholder="dd-mm-yyyy" value="<?= isset($get_proj[0]['due_by']) && $get_proj[0]['due_by'] != '0000-00-00 00:00:00' ? date("d-m-Y", strtotime($get_proj[0]['due_by'])) : '' ?>" class="form-control form-control-sm dateCalendar" autocomplete="off" readonly="readonly">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12 text-right">
                                                                    <label>Completed on</label>
                                                                </div>
                                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                                                    <div class="form-group">
                                                                        <input type="text" name="project_completed_on" id="project_completed_on" placeholder="dd-mm-yyyy" value="<?= isset($get_proj[0]['completed_on']) && $get_proj[0]['completed_on'] != '0000-00-00 00:00:00' ? date("d-m-Y", strtotime($get_proj[0]['completed_on'])) : '' ?>" class="form-control form-control-sm dateCalendar" autocomplete="off" readonly="readonly">
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
                                                                    <input type="hidden" name="module" id="module" value="plan" />
                                                                    <input type="hidden" name="task_count" id="task_count" value="<?= count($get_proj); ?>">
                                                                    <input type="hidden" name="edit_task_id" id="edit_task_id" value="<?= isset($get_task) && $get_task[0]['id'] != '' ? $get_task[0]['id'] : '' ?>" />
                                                                    <input type="hidden" name="edit_proj_id" id="edit_proj_id" value="<?= isset($get_proj) && $get_proj[0]['id'] != '' ? $get_proj[0]['id'] : '' ?>" />
                                                                    <input type='hidden' name='proj_innovation_id' id="proj_innovation_id" value="<?= $innovation_id; ?>">
                                                                    <input type='hidden' name='proj_finan_yr' id="proj_finan_yr" value="<?= $current_financial; ?>">
                                                                    <input type='hidden' name='proj_milestone_id' id="proj_milestone_id" value="<?= $milestone_id; ?>">
                                                                    <input type="hidden" name="sendApproval" id="sendApproval" value="0" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <?php if ($this->session->userdata['sector_lead'] == '1' && $approvals[0]['project_approval'] == 2) { ?>
                                            <!--                                            <div class="row">
                                                                                            <div class="col-12">
                                                                                                <div class="approved-btn text-right">
                                                                                                    <button class="btn btn-success capitilize">Approve</button>
                                                                                                    <div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>-->
                                        <?php } ?>
                                    </main>
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

        <!-- Model (Delete and select) -->
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

        <!-- Model (Add Milestone) -->
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
                            <input type="hidden" name="module" id="module" value="plan" />
                            <input type='hidden' name='cur_finance' id="cur_finance" value="<?= $current_financial; ?>">
                            <input type="hidden" name="milestone_edit_id" id="milestone_edit_id" />
                            <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                            <input type="submit" id="mileSubmit" class="btn add-btnconfig brd-rd30 btn-success btn-sm" value="Add">
                        </div>
                    </form>
                </div>
            </div>
            <input type="hidden" id="deleteID" value="">
        </div>

        <!-- Model (Add Task) -->
        <div class="modal" id="taskmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content delete-alert">
                    <form method="post" id="create_task" action="<?php echo base_url() . 'index.php/portfolio/addTask'; ?>" autocomplete="off">
                        <div class="modal-body text-center">
                            <div class="container-fluid">
                                <div class="row">
                                    <h4 class="text-center popup_milestone" id="milesTitle">Add New Task Title</h4>
                                    <div class="col-12">
                                        <input type='hidden' name='finan_yr' id="finan_yr" value="<?= $current_financial; ?>">
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
                            <input type="hidden" name="module" id="module" value="plan" />
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
        <input type="hidden" id="enableCount" value="<?= count($company_data); ?>">
        <input type="hidden" id="ajax_taskname" value="<?= isset($get_task) && $get_task[0]['id'] != '' ? $get_task[0]['task_name'] : '' ?>">

        <div class="modal" id="myModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content data_congifpopup">
                    <div class="modal-header text-center">
                        <h5 class="modal-title text-center" id="exampleModalLabel"><span class="text-success"><i
                                    class="fas fa-check-circle"></i></span> Saved successfully</h5>
                    </div>
                    <div class="modal-body onboarding-permission text-center">
                        <ul>
                            <li>You have successfully saved <strong>"Sri Sai Enterprises,Chennai - Agriculture"</strong> input data</li>
                        </ul>
                        <div class="popup-content-final popup-content">
                            <a class="close portfolioclose" data-dismiss="modal" aria-label="Close">close</a>

                            <a class="btn-configure" href="<?= base_url() . 'index.php/portfolio/uiPortfolio_summary' ?>" >Go to Portfolio</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type='hidden' name='innovation_id' id="innovation_id" value="<?= $innovation_id; ?>">
        <input type='hidden' name='cur_finance' id="cur_finance" value="<?= $current_financial; ?>">
        <style>
            .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active .sidebar-submenu{
                display:block;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/main.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

        <script type="text/javascript">
                            $(document).ready(function () {
                                var taskcnt = $('#task_count').val();
                                if (taskcnt > 0) {
                                    $('#projform input, #projform textarea, #project_assigned').attr('readonly', 'readonly');
                                    $('input[type="radio"]').addClass('opacity5');
                                    $('input[type="radio"], .disable_type').css('pointer-events', 'none');
                                    $('.dateCalendar, #project_assigned').css('pointer-events', 'none');
                                }
                                $("#project_due_by").datepicker({dateFormat: "dd-mm-yy", minDate: 0});
                                $("#project_completed_on").datepicker({dateFormat: "dd-mm-yy", minDate: 0});
                                $('.viewTask').first().addClass('active');

                                $('#edit_task').addClass('opacity5');
                                $('#deleteTask').addClass('opacity5');

                                var popup = $('#planBox').val();
                                if (popup == 1) {
                                    $('#planModal').modal('show');
                                } else {
                                    $('#planModal').modal('hide');
                                }

<?php if (isset($get_task) && $get_task[0]['id'] != '') { ?>
                                    GetTaskDetails(<?= $get_task[0]['id']; ?>);
<?php } ?>
                            });

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
                                $('#milestone_name').val('<?= isset($get_milestone[0]['name']) ? $get_milestone[0]['name'] : 'Milestone 1' ?>');
                                $('#milestone_edit_id').val('<?= $get_milestone[0]['id'] ?>');
                                $('#mileSubmit').val('Update');
                            });

                            $('#addTask').on('click', function () {
                                $('#taskmodal').modal('show');
                                $('#milestone_task').val('<?= isset($get_milestone[0]['name']) ? $get_milestone[0]['name'] : 'Milestone 1' ?>');
                                $('#milestone_id').val('<?= $get_milestone[0]['id'] ?>');
                                $('#taskSubmit').val('Add');
                            });

                            $(document).on('click', '#edit_task', function () {
                                $('#updatePlan').val('1');
                                $('#projform input, #projform textarea, #project_assigned').attr('readonly', false);
                                $('input[type="radio"]').removeClass('opacity5');
                                $('input[type="radio"], .disable_type').css('pointer-events', '');
                                $('.dateCalendar, #project_assigned').css('pointer-events', '');
                                $('#edit_task').removeClass('opacity5');
                                // $('#taskmodal').modal('show');
                                // $('#milestone_id').val('<?= $get_milestone[0]['id'] ?>');
                                // $('#taskSubmit').val('Update');
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
                                                    finan_yr: $('#cur_finance').val(),
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
                                window.location.href = '<?= base_url(); ?>' + 'index.php/all_forms/milestone/' + inv_id + '/' + year;
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

                            /* fetching task details */
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
                                        $('#ajax_taskname').val(msg.task_name);
                                        $('#edit_proj_id').val(msg.proj_id);
                                        $('#project_assigned').val(msg.assigned);
                                        $('#project_description').val(msg.description);
                                        if (msg.projtype != '') {
//                                                    $('.project_type').val(msg.projtype).prop("checked", true);
                                            $('#project_type' + msg.projtype).prop("checked", true);
                                        } else {
                                            $('input[name=project_type]').prop('checked', false);
                                        }
                                        $('#project_due_by').val(msg.due_by);
                                        $('#project_completed_on').val(msg.completed_on);
                                        $('#project_note').val(msg.notes);
                                    }
                                });
                            }

                            $('#projform').validate({
                                rules: {
                                    project_task: "required",
                                    project_description: "required",
                                    document_file: {
                                        extension: "pdf|ppt|pptx|doc|docx",
                                        maxfilesize: true
                                    },
                                    link_drive: {
                                        url: true
                                    }
                                },
                                messages: {
                                    project_task: "Please enter task title",
                                    project_description: "Please enter description",
                                    document_file: {
                                        extension: 'Only ppt,pdf,doc files are accepted'
                                    },
                                    link_drive: 'Enter valid url'
                                }
                            });

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
//                                        location.reload();
                                        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/pending_inputs/milestone_plan/' + invid + '/' + mileid;
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
                                        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/pending_inputs/milestone_plan/' + invid;
                                    }
                                });
                            }

                            function saveProj() {
                                if ($('#projform').valid()) {
                                    $('.savemilestone').css('pointer-events', 'none');
                                    $('#projform').submit();
                                }
                            }

//                            $(function () {
//                                var $form = $('#projform');
//                                var initialState = $form.find('input[name!=project_task]').serialize();
//                                $(document).on('click', '.pending_month_btn', function (e) {
//                                    var get_task = $('#project_task').val();
//                                    var actaul_task = $('#ajax_taskname').val();
//                                    var finalState = $form.find('input[name!=project_task]').serialize();
////                                    if (get_task === actaul_task) {
//                                    if (initialState === finalState) {
//                                        return(true);
//                                    } else {
//                                        if (confirm("Changes made in form are not saved. \nDo you want to continue without save?")) {
//                                            return(true);
//                                        } else {
//                                            return(false);
//                                        }
//                                    }
////                                    }
//                                });
//                            });
        </script>
    </body>
</html>