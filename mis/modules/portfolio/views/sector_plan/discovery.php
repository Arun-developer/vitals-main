<?php
$emp_id = $this->session->userdata['emp_number'];
if (php72_count($sector_discovery) > 0 || php72_cmp(($master_portfolio[0]['app_annual'])) > 0) {
    $enable = 1;
} else {
    $enable = 0;
}
if (php72_count($subsector_discovery) > 0) {
    $enable_sub = 1;
} else {
    $enable_sub = 0;
}
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $sector_name . ' - Discovery Plan', 'port_action' => 'sec_plan', 'sector_id' => $sector_id, 'sector_name' => $sector_name, 'fin_year' => $current_financial, 'fin_list' => $fin_year, 'add_class' => 'mar-tp150'));
?>
<!-- Inner Dashboard-->
<div class="vi-dashboard-portfolio onboardtabmenu wdt-100 mar-tp10">
    <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Record(s) deleted successfully</div>
    <div id="updateMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong></div>
    <?php if ($this->session->userdata['approve_success'] == '1') { ?>
        <div id="approveMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Discovery details approved successfully</div>
    <?php } ?>
    <?php if ($this->session->userdata['approve_success'] == '2') { ?>
        <div id="approveallMsg" class="msg text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;All plan details are approved successfully</div>
    <?php } ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill mar-tp5" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link filled-data active" id="nav-Companymaster-tab" href="<?= base_url() . 'index.php/portfolio/sector_plan/discovery/' . $sector_id . '/' . $current_financial; ?>" aria-selected="false">01</a>
                        <a class="nav-item nav-link filled-data" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/sector_plan/graduates/' . $sector_id . '/' . $current_financial; ?>" aria-controls="nav-business" aria-selected="false">Graduates & Exits</a>
                        <a class="nav-item nav-link filled-data" id="nav-management-tab" href="<?= base_url() . 'index.php/portfolio/sector_plan/donorengagement/' . $sector_id . '/' . $current_financial; ?>" aria-controls="nav-management" aria-selected="false">Fundraise</a>
                        <a class="nav-item nav-link filled-data" id="nav-governance-tab" href="<?= base_url() . 'index.php/portfolio/sector_plan/conferences/' . $sector_id . '/' . $current_financial; ?>" aria-controls="nav-governance" aria-selected="false">Brand Building & Thought Leadership</a>
                        <a class="nav-item nav-link filled-data" id="nav-relationship-tab" href="<?= base_url() . 'index.php/portfolio/sector_plan/equity_investments/' . $sector_id . '/' . $current_financial; ?>" aria-controls="nav-relationship" aria-selected="false">Driving Financial Stability</a>
                        <a class="nav-item nav-link bg-trasnparent brd-none" id="nav-about-tab" href="#nav-about" aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-business" role="tabpanel" aria-labelledby="nav-business-tab">
                        <div class="tabpanel-title">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <h4>Define the annual plan for <?= $sector_name; ?></h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right">
                                    <ul class="milestone-links">
                                        <?php if ((php72_in_array($emp_id, $app_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && (php72_cmp($approvals[0]['discovery_approval']) == 2 || php72_cmp($approvals[0]['diligence_approval']) == 2 || php72_cmp($approvals[0]['selection_approval']) == 2 || php72_cmp($approvals[0]['graduates_approval']) == 2 || php72_cmp($approvals[0]['exits_approval']) == 2 || php72_cmp($approvals[0]['donorengagement_approval']) == 2 || php72_cmp($approvals[0]['donorconnect_approval']) == 2 || php72_cmp($approvals[0]['conferences_approval']) == 2 || php72_cmp($approvals[0]['blog_post_approval']) == 2 || php72_cmp($approvals[0]['publish_article_approval']) == 2 || php72_cmp($approvals[0]['speakingengagement_approval']) == 2 || php72_cmp($approvals[0]['jury_panels_approval']) == 2 || php72_cmp($approvals[0]['case_study_approval']) == 2 || php72_cmp($approvals[0]['equity_investment_approval']) == 2 || php72_cmp($approvals[0]['portfolio_return_approval']) == 2)) { ?>
                                            <li><a class="approveall" href="javascript:void(0);" onclick="ApproveAll();">Approve All</a></li>
                                        <?php } ?>
                                        <?php if (php72_in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                            <li><a class="saveContinue" href="javascript:void(0)">Save</a></li>
                                        <?php } ?>
                                        <?php if (php72_cmp($this->session->userdata['sector_lead']) == 1 && php72_cmp($approvals[0]['config_approval']) == 1) { ?>
                                            <li><a class="sectorApproval sendApprovalBtn" id="sectorApproval" href="javascript:void(0);" onclick="ApproveAll();">Send for Approval</a></li>
                                        <?php } else { ?>
                                            <?php if ((php72_in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && php72_cmp($approvals[0]['config_approval']) == 1) { ?>
                                                <li><a class="sendApproval sendApprovalBtn" id="sendApproval" href="javascript:void(0);">Send for Approval</a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <li>
                                            <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend"><i class="far fa-question-circle"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <form id="discoveryForm" method="post" action="<?php echo base_url() . 'index.php/portfolio/sector_plan/addDiscovery'; ?>" autocomplete="off" enctype=multipart/form-data>
                            <div class=" config-wrapper tabpanel-detailsconfig dataconfig-content page-wrapper chiller-theme">

                                <div id="leftMenuLoad">
                                    <?php $this->load->view('sector_plan/pipeline_leftmenu', array('sector_id' => $sector_id, 'class_name' => 'salesDiv', 'configData' => $dataConfig, 'approvals' => $approvals, 'fin_year' => $current_financial)); ?>
                                </div>
                                <main class="page-content" id="pageContent">
                                    <div class="row dataconfig">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <h4>Pipeline Plan</h4>
                                        </div>
                                    </div>
                                    <?php if ((php72_in_array($emp_id, $app_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') && php72_cmp($approvals[0]['discovery_approval']) == 2) { ?>
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
                                    <!--<form method="post" id="create_channel" action="" class="newPlansetupcnt" autocomplete="off">     <main class="page-content" id="pageContent">-->
                                    <div class="inputplan-structureall plan-structure-new sectorbgChange">
                                        <div class="Plan-structure">

                                            <!-- Quantity new design -->
                                            <div class="quaterlyNewplanstru">
                                                <?php if ((php72_in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin')) { ?>
                                                    <?php if (php72_cmp($approvals[0]['discovery_approval']) == 2) { ?>
                                                        <h4>Discovery Plan : <span class="text-danger"><small>(Awaiting approval)</small></span></h4>
                                                    <?php } else if (php72_cmp($approvals[0]['discovery_approval']) == 3) { ?>
                                                        <h4>Discovery Plan : <span class="text-success"><small>(Approved)</small></span></h4>
                                                    <?php } else { ?>
                                                        <h4>Discovery Plan</h4>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <h4>Discovery Plan</h4>
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <p>Q1 (Apr-Jun <?= $current_financial; ?>)</p>
                                                        <div class="quaterlyCardnew" id="qOne_active">
                                                            <textarea rows="3" class="mceEditor" id="txtQuarterOne" name="qOneDesc" placeholder="Enter quarterly plan details in here"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['q_one_desc'])); ?></textarea>
                                                            <div class="tabset1" onclick="highlightQuarter('qOne_active');">
                                                                <input type="radio" name="tabset1" id="tab4" aria-controls="Apr" checked >
                                                                <label for="tab4">Apr</label>
                                                                <input type="radio" name="tabset1" id="tab2" aria-controls="May" >
                                                                <label for="tab2">May</label>
                                                                <input type="radio" name="tabset1" id="tab3" aria-controls="Jun" >
                                                                <label for="tab3">Jun</label>
                                                                <div class="tab-panels">
                                                                    <section class="tab-panel" id="Apr">
                                                                        <div class="aprBox">
                                                                            <textarea rows="3" class="mceEditor" id="txtApril" name='aprContent' placeholder="Plan for April"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['apr_desc'])); ?></textarea>
                                                                        </div>
                                                                    </section>
                                                                    <section class="tab-panel" id="May">
                                                                        <div class="mayBox">
                                                                            <textarea rows="3" class="mceEditor" id="txtMay" name='mayContent' placeholder="Plan for May"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['may_desc'])); ?></textarea>
                                                                        </div>
                                                                    </section>
                                                                    <section class="tab-panel" id="Jun">
                                                                        <div class="junBox">
                                                                            <textarea rows="3" class="mceEditor" id="txtJune" name='junContent' placeholder="Plan for June"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['jun_desc'])); ?></textarea>
                                                                        </div>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <p>Q2 (Jul-Sep <?= $current_financial; ?>)</p>
                                                        <div class="quaterlyCardnew" id="qTwo_active">
                                                            <textarea rows="3" class="mceEditor" id="txtQuarterTwo" name="qTwoDesc" placeholder="Enter quarterly plan details in here"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['q_two_desc'])); ?></textarea>
                                                            <div class="tabset2" onclick="highlightQuarter('qTwo_active');">
                                                                <input type="radio" name="tabset2" id="tab5" aria-controls="Jul" checked >
                                                                <label for="tab5">Jul</label>
                                                                <input type="radio" name="tabset2" id="tab6" aria-controls="Aug" >
                                                                <label for="tab6">Aug</label>
                                                                <input type="radio" name="tabset2" id="tab7" aria-controls="Sep" >
                                                                <label for="tab7">Sep</label>

                                                                <div class="tab-panels">
                                                                    <section id="Jul" class="tab-panel">
                                                                        <div class="julBox">
                                                                            <textarea rows="3" class="mceEditor" id="txtJuly" name='julContent' placeholder="Plan for July"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['jul_desc'])); ?></textarea>
                                                                        </div>
                                                                    </section>
                                                                    <section id="Aug" class="tab-panel">
                                                                        <div class="augBox">
                                                                            <textarea rows="3" class="mceEditor" id="txtAugust" name='augContent' placeholder="Plan for August"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['aug_desc'])); ?></textarea>
                                                                        </div>
                                                                    </section>
                                                                    <section id="Sep" class="tab-panel">
                                                                        <div class="sepBox">
                                                                            <textarea rows="3" class="mceEditor" id="txtSeptember" name='sepContent' placeholder="Plan for September"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['sep_desc'])); ?></textarea>
                                                                        </div>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <p>Q3 (Oct-Dec <?= $current_financial; ?>)</p>
                                                        <div class="quaterlyCardnew" id="qThree_active">
                                                            <textarea rows="3" class="mceEditor" id="txtQuarterThree" name="qThreeDesc" placeholder="Enter quarterly plan details in here"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['q_three_desc'])); ?></textarea>
                                                            <div class="tabset3" onclick="highlightQuarter('qThree_active');">
                                                                <input type="radio" name="tabset3" id="tab8" aria-controls="Oct" checked >
                                                                <label for="tab8">Oct</label>
                                                                <input type="radio" name="tabset3" id="tab9" aria-controls="Nov" >
                                                                <label for="tab9">Nov</label>
                                                                <input type="radio" name="tabset3" id="tab10" aria-controls="Dec" >
                                                                <label for="tab10">Dec</label>

                                                                <div class="tab-panels">
                                                                    <section id="Oct" class="tab-panel">
                                                                        <div class="octBox">
                                                                            <textarea rows="3" class="mceEditor" id="txtOctober" name='octContent' placeholder="Plan for October"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['oct_desc'])); ?></textarea>
                                                                        </div>
                                                                    </section>
                                                                    <section id="Nov" class="tab-panel">
                                                                        <div class="novBox">
                                                                            <textarea rows="3" class="mceEditor" id="txtNovember" name='novContent' placeholder="Plan for November"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['nov_desc'])); ?></textarea>
                                                                        </div>
                                                                    </section>
                                                                    <section id="Dec" class="tab-panel">
                                                                        <div class="decBox">
                                                                            <textarea rows="3" class="mceEditor" id="txtDecember" name='decContent' placeholder="Plan for December"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['dec_desc'])); ?></textarea>
                                                                        </div>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <p>Q4 (Jan-Mar <?= $current_financial + 1; ?>)</p>
                                                        <div class="quaterlyCardnew" id="qFour_active">
                                                            <textarea rows="3" class="mceEditor" id="txtQuarterFour" name="qFourDesc" placeholder="Enter quarterly plan details in here"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['q_four_desc'])); ?></textarea>
                                                            <div class="tabset4" onclick="highlightQuarter('qFour_active');">
                                                                <input type="radio" name="tabset4" id="tab11" aria-controls="Jan" checked >
                                                                <label for="tab11">Jan</label>
                                                                <input type="radio" name="tabset4" id="tab12" aria-controls="Feb" >
                                                                <label for="tab12">Feb</label>
                                                                <input type="radio" name="tabset4" id="tab13" aria-controls="Mar" >
                                                                <label for="tab13">Mar</label>

                                                                <div class="tab-panels">
                                                                    <section id="Jan" class="tab-panel">
                                                                        <div class="janBox">
                                                                            <textarea rows="3" class="mceEditor" id="txtJanuary" name='janContent' placeholder="Plan for January"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['jan_desc'])); ?></textarea>
                                                                        </div>
                                                                    </section>
                                                                    <section id="Feb" class="tab-panel">
                                                                        <div class="febBox">
                                                                            <textarea rows="3" class="mceEditor" id="txtFebruary" name='febContent' placeholder="Plan for February"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['feb_desc'])); ?></textarea>
                                                                        </div>
                                                                    </section>
                                                                    <section id="Mar" class="tab-panel">
                                                                        <div class="marBox">
                                                                            <textarea rows="3" class="mceEditor" id="txtMarch" name='marContent' placeholder="Plan for March"><?= stripslashes(str_replace("\\r\\n", '', $qualitative_data[0]['mar_desc'])); ?></textarea>
                                                                        </div>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="sectorTargetsHead">
                                                <h2 class="mar-bt8">Annual targets for application discovery</h2>
                                            </div>
                                            <div class="Plan-structure">
                                                <div class=" table_configcontentnew" id="mainsector">
                                                    <div class="text-right" id='editSec'>
                                                        <?php if (php72_in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                            <a href="javascript:void(0)" class="edit-btnconfig  display-block mar-bt8 mar-rt5" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                        <?php } ?>
                                                    </div>
                                                    <?php
                                                    $q1 = isset($sector_discovery[0]['total_applications_q1']) && $sector_discovery[0]['total_applications_q1'] != '' ? $sector_discovery[0]['total_applications_q1'] : $master_portfolio[0]['app_q1'];
                                                    $q2 = isset($sector_discovery[0]['total_applications_q2']) && $sector_discovery[0]['total_applications_q2'] != '' ? $sector_discovery[0]['total_applications_q2'] : $master_portfolio[0]['app_q2'];
                                                    $q3 = isset($sector_discovery[0]['total_applications_q3']) && $sector_discovery[0]['total_applications_q3'] != '' ? $sector_discovery[0]['total_applications_q3'] : $master_portfolio[0]['app_q3'];
                                                    $q4 = isset($sector_discovery[0]['total_applications_q4']) && $sector_discovery[0]['total_applications_q4'] != '' ? $sector_discovery[0]['total_applications_q4'] : $master_portfolio[0]['app_q4'];
                                                    ?>
                                                    <table class="table" style="margin-top: 0;">
                                                        <thead>
                                                            <tr>
                                                                <th width="40%">Period</th>
                                                                <th width="15%">Q1</th>
                                                                <th width="15%">Q2</th>
                                                                <th width="15%">Q3</th>
                                                                <th width="15%">Q4</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="add_tranche">
                                                            <tr>
                                                                <td class="vill-gray">Total no. of Applications</td>
                                                                <td >
                                                                    <div class="form-group">
                                                                        <input type="text" name="tot_application[]" value="<?= $q1; ?>" class="form-control form-control-sm volumefld" placeholder="00" maxlength="6">
                                                                    </div>
                                                                </td>
                                                                <td >
                                                                    <div class="form-group">
                                                                        <input type="text" name="tot_application[]" value="<?= $q2; ?>" class="form-control form-control-sm volumefld" placeholder="00" maxlength="6">
                                                                    </div>
                                                                </td>
                                                                <td >
                                                                    <div class="form-group">
                                                                        <input type="text" name="tot_application[]" value="<?= $q3; ?>" class="form-control form-control-sm volumefld" maxlength="6" placeholder="00">
                                                                    </div>
                                                                </td>
                                                                <td >
                                                                    <div class="form-group">
                                                                        <input type="text" name="tot_application[]" value="<?= $q4; ?>" class="form-control form-control-sm volumefld" maxlength="6" placeholder="00">
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                        </tbody> <!-- <tbody id='more_tranche'></tbody> -->
                                                    </table>
                                                </div>
                                                <div class="table_configcontentnew pad-bt0">
                                                    <div class="tabpanel-title">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                <h4>No. of Applications in Subtheme</h4>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                <?php
                                                                if (php72_in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
                                                                    ?>
                                                                    <ul class="milestone-links">
                                                                        <li><a href="javascript:void(0)" id="addMore"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a> </li>
                                                                        <li class="brd-left-onboard" id="editMentor"><a href="javascript:void(0)" id="edit_mentor" class="opacity5"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a></li>
                                                                        <li class="brd-left-onboard" id="disableBtn" style="cursor: not-allowed;">
                                                                            <a class="deleteControl" href="javascript:void(0)" id="deleteBtn" style="pointer-events: none;"><i class="fas fa-trash"></i>&nbsp;Delete</a>
                                                                        </li>
                                                                    </ul>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" table_configcontentnew">
                                                    <table class="table mentor-table" id="accordion">
                                                        <thead class="mentor-table-head">
                                                            <tr>
                                                                <th ></th>
                                                                <th>Select a Subtheme</th>
                                                                <th >Q1</th>
                                                                <th >Q2</th>
                                                                <th >Q3</th>
                                                                <th >Q4</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="add_tranche">
                                                            <?php
                                                            $j = 1;
                                                            if (php72_count($subsector_discovery) <= 0) {
                                                                $subsec_count = 1;
                                                            } else {
                                                                $subsec_count = php72_count($subsector_discovery);
                                                            }
                                                            for ($i = 0; $i < $subsec_count; $i++) {
                                                                ?>
                                                                <tr id="subtheme_tr_<?= $j; ?>" class="subtheme_more">
                                                                    <td>
                                                                        <?php
                                                                        if (php72_in_array($emp_id, $assign_sectorlead) || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
                                                                            if (php72_cmp($delete_row) == 0) {
                                                                                ?>
                                                                                <input type="checkbox" class="check_box"
                                                                                       aria-label="Checkbox for following text input"
                                                                                       name="check_delete" id="check_delete_<?php echo $j; ?>"
                                                                                       value="<?php echo $subsector_discovery[$i]['id']; ?>">
                                                                                       <?php
                                                                                   } else if (php72_cmp($delete_row) == 1) {
                                                                                       ?>
                                                                                <span class="cursor" title="Remove" onclick="hideRow(<?= $j; ?>);"><i class="fas fa-minus-circle"></i></span>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control form-control-sm mentorDiv" name="subtheme[]" id="sub_theme_<?= $j; ?>">
                                                                            <option value="">--Select--</option>
                                                                            <?php
                                                                            foreach ($subsector_details as $sublist) {
                                                                                if ($subsector_discovery[$i]['subsector_id'] == $sublist['id']) {
                                                                                    $selected = 'selected';
                                                                                } else {
                                                                                    $selected = '';
                                                                                }
                                                                                ?>
                                                                                <option value="<?= $sublist['id']; ?>" <?= $selected; ?>><?= $sublist['sector']; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </td>
                                                                    <td >
                                                                        <div class="form-group">
                                                                            <input type="text" name="app_subtheme_q1[]" id="app_subtheme_q1_<?= $j; ?>" value="<?= $subsector_discovery[$i]['subsector_applications_q1'] ?>"  class="form-control form-control-sm volumefld" placeholder="00" maxlength="6">
                                                                        </div>
                                                                    </td>
                                                                    <td >
                                                                        <div class="form-group">
                                                                            <input type="text" name="app_subtheme_q2[]" id="app_subtheme_q2_<?= $j; ?>" value="<?= $subsector_discovery[$i]['subsector_applications_q2'] ?>" class="form-control form-control-sm volumefld" placeholder="00" maxlength="6">
                                                                        </div>
                                                                    </td>
                                                                    <td >
                                                                        <div class="form-group">
                                                                            <input type="text" name="app_subtheme_q3[]" id="app_subtheme_q3_<?= $j; ?>" value="<?= $subsector_discovery[$i]['subsector_applications_q3'] ?>" class="form-control form-control-sm volumefld" maxlength="6" placeholder="00">
                                                                        </div>
                                                                    </td>
                                                                    <td >
                                                                        <div class="form-group">
                                                                            <input type="text" name="app_subtheme_q4[]" id="app_subtheme_q4_<?= $j; ?>" value="<?= $subsector_discovery[$i]['subsector_applications_q4'] ?>" class="form-control form-control-sm volumefld" maxlength="6" placeholder="00">
                                                                        </div>
                                                                    </td>

                                                                </tr>
                                                            <input type='hidden' name='subsector_discovery_id[]' id="subsector_discovery_id_<?= $j; ?>" value="<?= $subsector_discovery[$i]['id']; ?>">
                                                            <?php
                                                            $j++;
                                                        }
                                                        ?>
</tbody> <!-- <tbody id='more_tranche'></tbody> -->
                                                    </table>
                                                </div>
                                            </div>

                                            <input type='hidden' name='sector_id' id="sector_id" value="<?= $sector_id; ?>">
                                            <input type='hidden' name='finance_Year' id="finance_Year" value="<?= $current_financial; ?>">
                                            <input type='hidden' name='financial_year' id="financial_year" value="<?= $current_financial; ?>">
                                            <!--<input type='hidden' name='updatePlan' id="updatePlan" value="0">-->
                                            <input type='hidden' name='module_id' id="module_id" value="1">
                                            <input type='hidden' name='discovery_id' id="discovery_id" value="<?= $sector_discovery[0]['id']; ?>">

                                        </div>
                                    </div>
                                </main>

                                <!--</form>-->
                                <!--</main>-->
                            </div>
                        </form>
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
                            <p>you are about delete <span id="delCount"></span> selected information fields, you
                                can't undo this</p>
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
                <h5 class="modal-title text-center" id="exampleModalLabel"><span class="text-success"><i class="fas fa-check-circle"></i></span> Successfully updated the plan</h5>
            </div>
            <div class="modal-body onboarding-permission text-center">
                <ul>
                    <li>You have successfully saved & updated the plan for <br>"<strong><span>
                                <?php
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
                <h5 class="modal-title text-center" id="exampleModalLabel"><span class="text-success"><i class="fas fa-check-circle"></i></span> Sending for Approval</h5>
            </div>
            <div class="modal-body onboarding-permission text-center">
                <ul>
                    <li>The updated plan for <?= $sector_name; ?> will now be sent to <?= $sector_lead[0]['emp_names']; ?> for approval. Click Okay to proceed.</li>
                </ul>
                <div class="popup-content-final popup-content">
                    <a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a>
                    <a class="btn btn-configure " href="javascript:void(0)"  onclick="sendApproval();" >Okay</a>
                </div>
            </div>
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
<input type="hidden" id="enableCount" value="<?= $enable; ?>">
<input type="hidden" id="enableCount_sub" value="<?= $enable_sub; ?>">

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
    $(document).ready(function () {
        var cur_mnth = $('#active_editor').val();
        if (cur_mnth != '')
            highlightQuarter(cur_mnth);

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

    $(document).on('click', '#editBtn', function () {
        $('#editSec').html('<a href="javascript:void(0)" class="edit-btnconfig mar-bt15 display-block mar-rt5" id="cancelBtn"><i class="fas fa-times"></i> Cancel</a>');
        $('.saveContinue').text('Save');
        $('#mainsector input[type="text"]').attr('readonly', false);
        $('#editBtn').removeClass('opacity5');
    });

    $(document).on('click', '#cancelBtn', function () {
        $('#editSec').html('<a href="javascript:void(0)" class="edit-btnconfig mar-bt15 display-block mar-rt5" id="editBtn"><i class="fas fa-pencil-alt"></i> Edit</a>');
        $('.saveContinue').text('Save');
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('#mainsector input[type="text"]').attr('readonly', 'readonly');
        }
        $('#editBtn').addClass('opacity5');
    });

//                                $(".volumefld").on("input", function (evt) {
    $(document).on("input", ".volumefld", function (evt) {
        var self = $(this);
        if (self.val() != 0 || self.val() == '') {
            self.val(self.val().replace(/[^0-9]/g, ''));
        } else {
            self.val(0);
        }
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
            evt.preventDefault();
        }
    });

    $(document).on('click', '#sendApproval', function () {
        $('#sendapproval').modal('show');
    });


    function sendApproval() {
        var sector_id = $('#sector_id').val();
        var fin_year = $('#financial_year').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/sector_plan/sendapproval",
            data: {
                fin_year: fin_year,
                sector_id: sector_id,
                table: 'sector_plan_approval'
            },
            dataType: 'json',
            success: function (msg) {
                if (msg == '1') {
                    location.reload();
                }
            }
        });
    }


    $('#deleteBtn').on('click', function () {
        $('#deletemodal').modal('show');
        var sel_item = $("input:checkbox[name=check_delete]:checked").length;
        $('#delCount').html(sel_item);
    });

    $(document).on('click', '.check_box', function () {
        if ($("#discoveryForm input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
        }
    });

    function deleteMore() {
//                                    $('.check_box').on('click', function () {
        if ($("#discoveryForm input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
        }
//                                    });
    }

    $('#deleteRecord').on('click', function () {
        var editOpt = $('#enableCount_sub').val();

        var deleteId = new Array();
        $("input:checkbox[name=check_delete]:checked").each(function () {
            deleteId.push($(this).val());
        });

        if ($("#discoveryForm input:checkbox:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/sector_plan/deleteSubsectorDetail",
                data: {
                    id: deleteId
                },
                dataType: 'json',
                success: function (msg) {
                    $('#accordion').load(location.href + ' #accordion');
                    $('#deletemodal').modal('hide');
                    $('#deleteMsg').show();
                    setTimeout(function () {
//                                                    if (editOpt > 0) {
                        onLoad();
//                                                    }
                        deleteMore();
                    }, 500);
                    setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000);
                }
            });
        }
    });

    $(".saveContinue").on('click', function (e) {
        if ($('#discoveryForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#discoveryForm').submit();
            e.preventDefault();
        }
    });

    function onLoad() {

        var app_editOpt = $('#enableCount').val();
        if (app_editOpt > 0) {
            $('#mainsector input[type="text"]').attr('readonly', 'readonly');
            $('#editBtn').addClass('opacity5');
        }


        var editOpt = $('#enableCount_sub').val();
        if (editOpt > 0) {
            $('#accordion input[type = "text"], #accordion select').attr('readonly', 'readonly');
            $('#accordion input[type = "file"]').css("pointer-events", "none");
            $("#accordion select").css("pointer-events", "none");
            $(".dateCalendar").css("pointer-events", "none");
        }
        $('#edit_mentor').addClass('opacity5');
        $('#disableBtn').css("cursor", "not-allowed");
        $('#deleteBtn').css("pointer-events", "none");
    }

    $(document).on('click', '#edit_mentor', function () {
        $('.saveContinue').text('Save');
        $('#editMentor').html('<a href="javascript:void(0)" id="cancel_mentor"><i class="fas fa-times"></i>&nbsp;Cancel</a>')
        $('#edit_mentor').removeClass('opacity5');
        $('#accordion select').attr('readonly', false);
        $('#accordion input[type="text"]').attr('readonly', false);
        $("#accordion select").css("pointer-events", "");
    });

    $(document).on('click', '#cancel_mentor', function () {
        $('.saveContinue').text('Save');
        $('#editMentor').html('<a href="javascript:void(0)" id="edit_mentor"><i class="fas fa-pencil-alt"></i>Edit</a>');
        onLoad();
        var editOpt = $('#enableCount_sub').val();
        if (editOpt > 0) {
            $('#accordion select').attr('readonly', 'readonly');
            $('#accordion input[type="text"]').attr('readonly', 'readonly');
        }
        $('#edit_mentor').addClass('opacity5');
    });


    $(document).on('click', '#addMore', function () {
        var dyn = $(".subtheme_more").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="subtheme_tr_' + i + '" class="subtheme_more"><td><input type="checkbox" class="check_box" aria-label="Checkbox for following text input" name="check_delete" id="check_delete_' + i + '" value=""></td><td><div class="form-group"><select class="form-control" name="subtheme[]" id="sub_theme_' + i + '"><option value="">--Select--</option><?php
foreach ($subsector_details as $sublist) {
    ?><option value="<?= $sublist['id']; ?>" <?= $selected; ?>><?= $sublist['sector']; ?></option> <?php } ?></select></div></td>';
        datas += '<td ><div class="form-group"><input type="text" name="app_subtheme_q1[]" id="app_subtheme_q1_' + i + '" value="" class="form-control form-control-sm volumefld" placeholder="00" maxlength="6"></div></td>';
        datas += '<td ><div class="form-group"><input type="text" name="app_subtheme_q2[]" id="app_subtheme_q2_' + i + '" value="" class="form-control form-control-sm volumefld" placeholder="00" maxlength="6"></div></td>';
        datas += '<td ><div class="form-group"><input type="text" name="app_subtheme_q3[]" id="app_subtheme_q3_' + i + '" value="" class="form-control form-control-sm volumefld" placeholder="00" maxlength="6"></div></td>';
        datas += '<td ><div class="form-group"><input type="text" name="app_subtheme_q4[]" id="app_subtheme_q4_' + i + '" value="" class="form-control form-control-sm volumefld" placeholder="00" maxlength="6"></div></td></tr>';
        $(datas).insertAfter($('#subtheme_tr_' + dyn));
    });

    function loadYear(year) {
        var sector_id = $('#sector_id').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/sector_plan/discovery/' + sector_id + '/' + year;
    }

    function load_sector(sector_id) {
        var year = $('#financial_year').val();
        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/sector_plan/discovery/' + sector_id + '/' + year;
    }

    function hideRow(id) {
        $('#subtheme_tr_' + id).closest('tr').remove();
        var tr_count = $('.subtheme_more').length;
        if (tr_count == 0) {
            var datas = '<tbody><tr id="subtheme_tr_' + i + '" class="subtheme_more"><td><input type="checkbox" class="check_box" aria-label="Checkbox for following text input" name="check_delete" id="check_delete_' + i + '" value=""></td><td><div class="form-group"><select class="form-control" name="subtheme[]" id="sub_theme_' + i + '"><option value="">--Select--</option><?php
foreach ($subsector_details as $sublist) {
    ?><option value="<?= $sublist['id']; ?>" <?= $selected; ?>><?= $sublist['sector']; ?></option> <?php } ?></select></div></td>';
            datas += '<td ><div class="form-group"><input type="text" name="app_subtheme_q1[]" id="app_subtheme_q1_' + i + '" value="" class="form-control form-control-sm volumefld" placeholder="00" maxlength="6"></div></td>';
            datas += '<td ><div class="form-group"><input type="text" name="app_subtheme_q2[]" id="app_subtheme_q2_' + i + '" value="" class="form-control form-control-sm volumefld" placeholder="00" maxlength="6"></div></td>';
            datas += '<td ><div class="form-group"><input type="text" name="app_subtheme_q3[]" id="app_subtheme_q3_' + i + '" value="" class="form-control form-control-sm volumefld" placeholder="00" maxlength="6"></div></td>';
            datas += '<td ><div class="form-group"><input type="text" name="app_subtheme_q4[]" id="app_subtheme_q4_' + i + '" value="" class="form-control form-control-sm volumefld" placeholder="00" maxlength="6"></div></td></tr></tbody>';
            $(datas).insertAfter($('.mentor-table-head'));
        }
    }

    $(document).on('click', '.capitilize', function () {
        var sector_id = $('#sector_id').val();
        var fin_year = $('#financial_year').val();
        var fields = ['total_applications_q1', 'total_applications_q2', 'total_applications_q3', 'total_applications_q4'];
        var subfields = ['subsector_id', 'subsector_applications_q1', 'subsector_applications_q2', 'subsector_applications_q3', 'subsector_applications_q4'];

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/sector_plan/Approved",
            data: {
                sector_id: sector_id,
                fin_year: fin_year,
                module_id: 1,
                approval_field: 'discovery_approval',
                maintable: 'sector_plan_discovery',
                subtable: 'sector_plan_discoverysubsector',
                temptable: 'temp_sectorplan_discovery',
                tempsubtable: 'temp_sectorplan_discoverysubsector',
                fields: fields,
                subfields: subfields
            },
            dataType: 'json',
            success: function (msg) {
                location.reload();
            }
        });
    });


//                                $(document).on('click', '.approveall', function () {
    function ApproveAll() {
        var sector_id = $('#sector_id').val();
        var fin_year = $('#financial_year').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/portfolio/sector_plan/ApproveAll",
            data: {
                sector_id: sector_id,
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
    }
</script>
<style>
    /* .onboardtabmenu nav>div a.nav-item.nav-link,
        .onboardtabmenu nav>div a.nav-item.nav-link.active {
            border: 1px solid #2e8751;
            padding: 7px 10px;
            color: #2e8751;
            background: #fff;
            border-radius: 0;
            font-size: 13px;
        }

        .onboardtabmenu nav>div a.nav-item.nav-link.dataConfig.active {
            background: #bc8128;
            color: #fff;
            font-weight: 400;
            font-family: 'firaMedium' !important;
            border: 1px solid #bc8128;
        } */

    /* .tabpanel-title {
            background-color: #cae4d4;
            color: #000;
        } */

    .helptab-link a {
        font-size: 14px;
        color: #23954c;
        padding: 8px 0;
    }

    .helptab-link a i {
        background: #fff;
        font-size: 11px;
        padding: 5px 1px;
        width: 22px;
        height: 22px;
        text-align: center;
        border-radius: 50%;
    }

    .config-sales {
        float: none;
        /* padding: 11px 0 11px; */
        justify-content: flex-end;
        /* border-right: 1px solid #ccc; */
    }

    #leftMenuLoad {
        float: left;
    }

    /* #sidebar {
            width: 300px;
            display: block;
        } */

    /* .page-wrapper .page-content {
        background: none;
    } */

    .innerTabsPlansetup .page-wrapper .page-content {
        display: inline-block;
        width: 100%;
        padding-left: 0px;
        background: none;
        padding-bottom: 10px;
        /* margin-left: 15px; */
    }

    .innerTabsPlansetup .inputplan-structureall {
        padding: 15px 20px;
        margin: 0 0px 0 0;
        background: #ffffff;
        border-top: 1px solid #abe0bf;
    }

    .planTableStruc h4 {
        font-size: 19px;
        margin: 0;
        padding: 0;
    }

    .currencyNotify {
        /* text-align: left !important; */
        font-size: 12px !important;
    }

    /* .currencyPadd {
        padding: 0px 10px 0px 0;
        margin: 0;
    } */

    .tabpanel-title a.sendApprovalBtn,
    .tabpanel-titleconfig a.sendApprovalBtn {
        display: inline-block;
        color: #FFF;
        padding: 2px 13px;
        font-size: 13px;
        border: 1px solid #fff;
        border-radius: 30px;
        margin: 7px 0px 7px 0px;
        transition: all 0.2s ease-in-out 0s;
    }

    .tabpanel-title a.saveContinue,
    .tabpanel-title a.approveall {
        display: inline-block;
        color: #fff;
        padding: 2px 13px;
        font-size: 13px;
        border: 1px solid #fff;
        border-radius: 30px;
        margin: 7px 0px 7px 0px;
        transition: all 0.2s ease-in-out 0s;
    }

    .appplanbtnnew {
        background: #d3df3f;
        border-radius: 30px;
    }

    .newPlansetupcnt {
        background-color: #fff;
    }

    .page-wrapper .page-content .dataconfig {
        padding: 20px 0px 10px;
        margin: 0;
        border-bottom: 1px solid #d3df3f;
    }

    .quaterlyNewplanstru h4 {
        font-size: 17px;
        padding-bottom: 15px;
    }
    .quaterlyNewplanmeetingstru h4{
        font-size: 17px;
        padding-bottom: 5px;
    }
    .quaterlyNewplanstru p {
        margin: 0;
        padding-left: 8px;
    }




    .Plan-structure {
        height: 350px;
        padding: 0;
        overflow-x: hidden;
    }

    /*            . {
                    overflow-x: hidden;
                }*/
    .table_configcontentnew .tabpanel-title h4{
        font-size: 14px;
        padding: 12px 15px;
    }
    .table_configcontentnew .tabpanel-title a{
        padding: 8px 0;
    }
</style>
</body>

</html>