<?php
$master_data = $company_data[0];
$page_title = isset($master_data['name']) && $master_data['name'] != '' ? $master_data['name'] . ' - Summary' : 'Company Summary';
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $page_title, 'container' => 'yes'));

$innovation = $get_innovation[0];
$business_data = $business_nature[0];
$mgmt_data = $managementDetails[0];
$gov_data = $governanceDetails[0];
$vil_relation = $relationDetails[0];
$incubation = $villgro_incubation[0];
$cap_data = $capTableDetails[0];

$stage_val = array("1" => "No MVP", "2" => "MVP Ready, Not launched", "3" => "On sale, no traction", "4" => "Low/Inconsistent sales", "5" => "Consistent sales", "6" => "EBITDA Positive");

$company_class = $nature_class = $mgmnt_class = $govern_class = $vilrel_class = $increl_class = $cap_class = $int_class = $plan_class = "notDone";
$company_text = $nature_text = $mgmnt_text = $govern_text = $vilrel_text = $increl_text = $cap_text = $int_text = $plan_text = "Pending";
$company_icon = $nature_icon = $mgmnt_icon = $govern_icon = $vilrel_icon = $increl_icon = $cap_icon = $int_icon = $plan_icon = '<i class="fas fa-exclamation-circle"></i>';
$company_msg = $nature_msg = $mgmnt_msg = $govern_msg = $vilrel_msg = $increl_msg = $cap_msg = $int_msg = $plan_msg = 'text-warning';

if (count($company_data) > 0) {
    $company_class = '';
    $company_text = 'Done';
    $company_icon = '<i class="fas fa-check-circle"></i>';
    $company_msg = 'text-success';
}
if (count($business_nature) > 0) {
    $nature_class = '';
    $nature_text = 'Done';
    $nature_icon = '<i class="fas fa-check-circle"></i>';
    $nature_msg = 'text-success';
}
if (count($managementDetails) > 0) {
    $mgmnt_class = '';
    $mgmnt_text = 'Done';
    $mgmnt_icon = '<i class="fas fa-check-circle"></i>';
    $mgmnt_msg = 'text-success';
}
if (count($governanceDetails) > 0) {
    $govern_class = '';
    $govern_text = 'Done';
    $govern_icon = '<i class="fas fa-check-circle"></i>';
    $govern_msg = 'text-success';
}
if (count($relationDetails) > 0) {
    $vilrel_class = '';
    $vilrel_text = 'Done';
    $vilrel_icon = '<i class="fas fa-check-circle"></i>';
    $vilrel_msg = 'text-success';
}
if (count($villgro_incubation) > 0) {
    $increl_class = '';
    $increl_text = 'Done';
    $increl_icon = '<i class="fas fa-check-circle"></i>';
    $increl_msg = 'text-success';
}
if (count($capTableDetails) > 0) {
    $cap_class = '';
    $cap_text = 'Done';
    $cap_icon = '<i class="fas fa-check-circle"></i>';
    $cap_msg = 'text-success';
}
if (count($otherInterests) > 0) {
    $int_class = '';
    $int_text = 'Done';
    $int_icon = '<i class="fas fa-check-circle"></i>';
    $int_msg = 'text-success';
}
if ($plan_pending == 1) {
    $plan_class = '';
    $plan_text = 'Done';
    $plan_icon = '<i class="fas fa-check-circle"></i>';
    $plan_msg = 'text-success';
}
?>

<div class="vil-sub_menu deal-bread fixed-header-2">
    <div class="row">
        <div class="col-xl-3 col-md-3 col-sm-3 col-12 display-flex onbordconfig-title">
            <span><a href="<?php echo base_url() . 'index.php/portfolio/company_summary/' . $innovation_id . '/' . $current_financial; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
            <h4>Company Profile</h4>
        </div>
    </div>
</div>

<div class="vi-dashboard vi-dashboard-top170 mar-tp150">
    <div class="incubate-title companyTitlrProfile">
        <h6>
            <?php
            echo ucfirst($master_data['name']) . ', ';
            if ($master_data['reg_city'] != '') {
                echo ucfirst($master_data['reg_city']) . ', ';
            }
            if ($sector_name != '') {
                echo ucfirst($sector_name);
            }
            ?>
        </h6>
    </div>
    <div class="company_profiledetails bg-white">
        <div class="row">
            <div class="col-5">
                <div class="companyProfile-sidemenu">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-Company-tab" data-toggle="pill" href="#v-pills-Company" role="tab" aria-controls="v-pills-Company" aria-selected="false">Company Master Data <span class="<?= $company_class; ?>"><?= $company_text; ?><?= $company_icon; ?></span></a>
                        <a class="nav-link" id="v-pills-Business-tab" data-toggle="pill" href="#v-pills-Business" role="tab" aria-controls="v-pills-Business" aria-selected="true">Nature of Business <span class="<?= $nature_class; ?>"><?= $nature_text; ?><?= $nature_icon; ?></span></a>
                        <a class="nav-link" id="v-pills-Management-tab" data-toggle="pill" href="#v-pills-Management" role="tab" aria-controls="v-pills-Management" aria-selected="false">Management <span class="<?= $mgmnt_class; ?>"><?= $mgmnt_text; ?><?= $mgmnt_icon; ?></span></a>
                        <a class="nav-link" id="v-pills-Governance-tab" data-toggle="pill" href="#v-pills-Governance" role="tab" aria-controls="v-pills-Governance" aria-selected="false">Governance <span class="<?= $govern_class; ?>"><?= $govern_text; ?><?= $govern_icon; ?></span></a>
                        <a class="nav-link" id="v-pills-Relationship-tab" data-toggle="pill" href="#v-pills-Relationship" role="tab" aria-controls="v-pills-Relationship" aria-selected="false">Villgro Relationship details <span class="<?= $vilrel_class; ?>"><?= $vilrel_text; ?><?= $vilrel_icon; ?></span></a>
                        <a class="nav-link" id="v-pills-Incubation-tab" data-toggle="pill" href="#v-pills-Incubation" role="tab" aria-controls="v-pills-Incubation" aria-selected="false">Incubation Relationship <span class="<?= $increl_class; ?>"><?= $increl_text; ?><?= $increl_icon; ?></span></a>
                        <a class="nav-link" id="v-pills-Cap-tab" data-toggle="pill" href="#v-pills-Cap" role="tab" aria-controls="v-pills-Cap" aria-selected="false">Cap Table <span class="<?= $cap_class; ?>"><?= $cap_text; ?><?= $cap_icon; ?></span></a>
                        <a class="nav-link" id="v-pills-Interested-tab" data-toggle="pill" href="#v-pills-Interested" role="tab" aria-controls="v-pills-Interested" aria-selected="false">Other Interested Parties <span class="<?= $int_class; ?>"><?= $int_text; ?><?= $int_icon; ?></span></a>
                        <a class="nav-link" href="<?= base_url() . 'index.php/portfolio/product/' . $innovation_id . '/' . $current_financial; ?>" >Plan Setup <span class="<?= $plan_class; ?>"><?= $plan_text; ?><?= $plan_icon; ?></span></a>
                        <a class="nav-link" href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $innovation_id . '/' . $current_financial; ?>">Achievements <span>View Details</span></a>
                        <a class="nav-link" id="v-pills-Log-tab" data-toggle="pill" href="#v-pills-Log" role="tab" aria-controls="v-pills-Log" aria-selected="false">Log History <span>View Log</span></a>
                    </div>
                </div>
            </div>
            <div class="col-7 brd-left-profile">
                <div class="companyProfile-sidemenu">
                    <div class="tab-content " id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-Company" role="tabpanel" aria-labelledby="v-pills-Company-tab">
                            <div>
                                <div class="row detailheader-profile">
                                    <div class="col-7">
                                        <h6>Company Master Data</h6>
                                    </div>
                                    <?php
                                    if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
                                        $view_title = "<i class='fas fa-pencil-alt'></i>View & Edit";
                                    } else {
                                        $view_title = "";
                                    }
                                    ?>
                                    <div class="col-5 text-right">
                                        <a href="<?= base_url() . 'index.php/portfolio/company_data/' . $innovation_id; ?>" id="edit_cmpny"><?= $view_title; ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="detailshow-profile">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="profile-table">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td width="50%">
                                                            <label>Name of the company</label>
                                                            <p><?= $master_data['name']; ?></p>
                                                        </td>
                                                        <td>
                                                            <label>CIN #</label>
                                                            <p><?= $master_data['cin']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>Registered Company's Address</label>
                                                            <p><?= $master_data['reg_address'] . ' ' . $master_data['reg_pincode']; ?></p>
                                                        </td>
                                                        <td>
                                                            <label>Other Company's Address</label>
                                                            <p><?= $master_data['other_address'] . ' ' . $master_data['other_pincode']; ?></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>MIS INV ID</label>
                                                            <p><?= $innovation['copy_id'] . '_' . $innovation['partner_id'] . '_' . $innovation['partner_count']; ?></p>
                                                        </td>
                                                        <td>
                                                            <label>Document</label>
                                                            <p>
                                                                <?php if (isset($master_data['document']) && !empty($master_data['document'])) { ?>
                                                                    <a href="<?php echo base_url() . 'uploads/portfolio/company/' . $master_data['document']; ?>"
                                                                       target="_blank">
                                                                       <i class="fas fa-file-download"></i>
                                                                       <?php echo $master_data['document']; ?>
                                                                   </a>
                                                               <?php } ?>
                                                           </p>
                                                       </td>
                                                   </tr>
                                                   <tr>
                                                    <td>
                                                        <label>Company Status</label>
                                                        <?php
                                                        $company_status = isset($master_data) ? $master_data['company_status'] : '';
                                                        $status_name = '';
                                                        if ($company_status == 1) {
                                                            $status_name = 'Open';
                                                        } else if ($company_status == 2) {
                                                            $status_name = 'Company Graduated';
                                                        } else if ($company_status == 3) {
                                                            $status_name = 'Exited';
                                                        }
                                                        ?>
                                                        <p><?= $status_name; ?></p>
                                                    </td>
                                                    <td>
                                                        <label>Website</label>
                                                        <?php
                                                        $website_url = isset($inc_website[0]['inc_website']) && $inc_website[0]['inc_website'] != '' ? $inc_website[0]['inc_website'] : $inc_website[0]['pitch_website'];
                                                        ?>
                                                        <p><?= $website_url; ?></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                                                        <!-- <tr>
                                                                                            <td class="brd-none">
                                                                                                <h6>Completion Status</h6>
                                                                                            </td>
                                                                                            <td class="brd-none">
                                                                                                <p class="<?= $company_msg; ?>"><strong><?= $company_text; ?>&nbsp;<?= $company_icon; ?></strong></p>
                                                                                            </td>
                                                                                        </tr> -->
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="v-pills-Business" role="tabpanel" aria-labelledby="v-pills-Business-tab">
                                                                <div>
                                                                    <div class="row detailheader-profile">
                                                                        <div class="col-7">
                                                                            <h6>Nature of Business</h6>
                                                                        </div>
                                                                        <div class="col-5 text-right">
                                                                            <a href="<?= base_url() . 'index.php/portfolio/business_nature/' . $innovation_id; ?>" id="edit_cmpny"><?= $view_title; ?></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="detailshow-profile">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="profile-table">
                                                                                <table class="table">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td width="50%">
                                                                                                <label>Sector</label>
                                                                                            </td>
                                                                                            <td><p><?= $sector_name; ?></p></td>
                                                                                        </tr>
																						<tr>
                                                                                            <td width="50%">
                                                                                                <label>Subsector</label>
                                                                                            </td>
                                                                                            <td><p><?= $subsector_name; ?></p></td>
                                                                                        </tr>
																						<tr>
                                                                                            <td width="50%">
                                                                                                <label>Program</label>
                                                                                            </td>
                                                                                            <td><p><?= $programName; ?></p></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <label>Stage of the incubatee</label>
                                                                                            </td>
                                                                                            <td>
                                                                                                <p><?= $stage_val[$business_data['stage']]; ?></p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <label>Brief description of business</label>
                                                                                            </td>
                                                                                            <td>
                                                                                                <p><?= $business_data['description']; ?></p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>&nbsp;</td>
                                                                                            <td>&nbsp;</td>
                                                                                        </tr>
                <!-- <tr>
                    <td class="brd-none">
                        <h6>Completion Status</h6>
                    </td>
                    <td class="brd-none">
                        <p class="<?= $nature_msg; ?>"><strong><?= $nature_text; ?>&nbsp;<?= $nature_icon; ?></strong></p>
                    </td>
                </tr> -->
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
</div>
<div class="tab-pane fade" id="v-pills-Management" role="tabpanel" aria-labelledby="v-pills-Management-tab">
    <div>
        <div class="row detailheader-profile">
            <div class="col-7">
                <h6>Management</h6>
            </div>
            <div class="col-5 text-right">
                <a href="<?= base_url() . 'index.php/portfolio/management/' . $innovation_id; ?>" id="edit_cmpny"><?= $view_title; ?></a>
            </div>
        </div>
    </div>
    <div class="detailshow-profile">
        <div class="row">
            <div class="col-12">
                <div class="profile-tabletwo">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="20%">Founders / Management names</th>
                                <th width="17%">Mobile Number</th>
                                <th width="28%">Email</th>
                                <th width="15%">Location</th>
                                <th width="20%">Designation / Responsibility</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < count($managementDetails); $i++) {
                                ?>
                                <tr>
                                    <td><p><?= $managementDetails[$i]['name']; ?></p></td>
                                    <td><p><?= $managementDetails[$i]['mobile']; ?></p></td>
                                    <td><p><?= $managementDetails[$i]['email']; ?></p></td>
                                    <td><p><?= $managementDetails[$i]['location']; ?></p></td>
                                    <td><p><?= $managementDetails[$i]['designation']; ?></p></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                                                                <!-- <tr>
                                                                    <td colspan="3" class="brd-none">
                                                                        <h6>Completion Status</h6>
                                                                    </td>
                                                                    <td colspan="2" class="brd-none">
                                                                        <p class="<?= $mgmnt_msg; ?>"><strong><?= $mgmnt_text; ?>&nbsp;<?= $mgmnt_icon; ?></strong></p>
                                                                    </td>
                                                                </tr> -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-Governance" role="tabpanel" aria-labelledby="v-pills-Governance-tab">
                                        <div>
                                            <div class="row detailheader-profile">
                                                <div class="col-7">
                                                    <h6>Governance</h6>
                                                </div>
                                                <div class="col-5 text-right">
                                                    <a href="<?= base_url() . 'index.php/portfolio/governance/' . $innovation_id; ?>" id="edit_cmpny"><?= $view_title; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="detailshow-profile">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="profile-tabletwo">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th width="25%">Board of Advisors<br>
                                                                        <small>Members / Observers Name(s)</small>
                                                                    </th>
                                                                    <th width="25%">Mobile Number</th>
                                                                    <th width="30%">Email</th>
                                                                    <th width="20%">Representing</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                for ($i = 0; $i < count($governanceDetails); $i++) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><p><?= $governanceDetails[$i]['name']; ?></p></td>
                                                                        <td><p><?= $governanceDetails[$i]['mobile']; ?></p></td>
                                                                        <td><p><?= $governanceDetails[$i]['email']; ?></p></td>
                                                                        <td><p><?= $governanceDetails[$i]['representing']; ?></p></td>
                                                                    </tr>
                                                                <?php } ?>
                                                                <tr>
                                                                    <td colspan="2">&nbsp;</td>
                                                                    <td colspan="2">&nbsp;</td>
                                                                </tr>
                                                    <!-- <tr>
                                                        <td colspan="2" class="brd-none">
                                                            <h6>Completion Status</h6>
                                                        </td>
                                                        <td colspan="2" class="brd-none">
                                                            <p class="<?= $govern_msg; ?>"><strong><?= $govern_text; ?>&nbsp;<?= $govern_icon; ?></strong></p>
                                                        </td>
                                                    </tr> -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-Relationship" role="tabpanel" aria-labelledby="v-pills-Relationship-tab">
                            <div>
                                <div class="row detailheader-profile">
                                    <div class="col-7">
                                        <h6>Villgro Relationship Details</h6>
                                    </div>
                                    <div class="col-5 text-right">
                                        <a href="<?= base_url() . 'index.php/portfolio/villgro_relationship/' . $innovation_id; ?>" id="edit_cmpny"><?= $view_title; ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="detailshow-profile">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="profile-table">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <label>Villgro Portfolio Manager</label>
                                                            <?php
                                                            foreach ($emp_details as $emps) {
                                                                if ($vil_relation['manager'] == $emps['emp_number']) {
                                                                    ?>
                                                                    <p><?= $emps['emp_name']; ?></p>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <label>Villgro Lead/Senior</label>
                                                            <?php
                                                            foreach ($emp_details as $emps) {
                                                                if ($vil_relation['senior'] == $emps['emp_number']) {
                                                                    ?>
                                                                    <p><?= $emps['emp_name']; ?></p>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>Villgro Board Member</label>
                                                            <?php
                                                            foreach ($emp_details as $emps) {
                                                                if ($vil_relation['member'] == $emps['emp_number']) {
                                                                    ?>
                                                                    <p><?= $emps['emp_name']; ?></p>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <label>Board Observer</label>
                                                            <p><?= $vil_relation['observer']; ?></p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <br>
                            <div class="detailshow-profile">
                                <p>Assigned Mentors</p>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="profile-tabletwo">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th width="15%">Name</th>
                                                        <th width="15%">Start Date</th>
                                                        <th width="15%">End Date</th>
                                                        <th width="20%">Focus Area</th>
                                                        <th width="30%">Document</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    for ($i = 0; $i < count($mentorDetails); $i++) {
                                                        $start_date = (isset($mentorDetails[$i]['start_date']) && $mentorDetails[$i]['start_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($mentorDetails[$i]['start_date'])) : '';
                                                        $end_date = (isset($mentorDetails[$i]['end_date']) && $mentorDetails[$i]['start_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($mentorDetails[$i]['end_date'])) : '';

                                                        $cond['id'] = $mentorDetails[$i]['area'];
                                                        $cond['status'] = 1;
                                                        $focus_area = $this->Mportfolio->getCommonData('port_mentor_focus_area', $cond);
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                foreach ($emp_mentors as $emps) {
                                                                    if ($mentorDetails[$i]['name'] == $emps['emp_number']) {
                                                                        ?>
                                                                        <p><?= $emps['emp_name']; ?></p>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><p><?= $start_date; ?></p></td>
                                                            <td><p><?= $end_date; ?></p></td>
                                                            <td><p><?= $focus_area[0]['name']; ?></p></td>
                                                            <td>
                                                                <?php if ($mentorDetails[$i]['sow_document'] && !empty($mentorDetails[$i]['sow_document'])) { ?>
                                                                    <a href="<?php echo base_url() . 'uploads/portfolio/mentor/' . $mentorDetails[$i]['sow_document']; ?>"
                                                                       target="_blank">
                                                                       <i class="fas fa-file-download"></i>
                                                                       <?php echo strlen($mentorDetails[$i]['sow_document']) > 15 ? "..." . substr($mentorDetails[$i]['sow_document'], -15) : $mentorDetails[$i]['sow_document']; ?>
                                                                   </a>
                                                               <?php } ?>
                                                           </td>
                                                       </tr>
                                                   <?php } ?>

                                                   <tr>
                                                    <td colspan="3">&nbsp;</td>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $initial = isset($incubation) ? $incubation['initial_agreement'] : '';
                    $tap = isset($incubation) ? $incubation['tap_agreement'] : '';
                    $mentor = isset($incubation) ? $incubation['mentor_agreement'] : '';
                    $exit = isset($incubation) ? $incubation['exit_letter'] : '';
//                        $comment = isset($incubation) ? $incubation['description_one'] : '';
//                        $other = isset($incubation) ? $incubation['description_two'] : '';

                    $iniAgree = json_decode($initial);
                    $tapAgree = json_decode($tap);
                    $menAgree = json_decode($mentor);
                    $exitAgree = json_decode($exit);
//                        $cmtAgree = json_decode($comment);
//                        $othAgree = json_decode($other);
                    ?>

                    <div class="tab-pane fade" id="v-pills-Incubation" role="tabpanel" aria-labelledby="v-pills-Incubation-tab">
                        <div>
                            <div class="row detailheader-profile">
                                <div class="col-7">
                                    <h6>Incubation Relationship</h6>
                                </div>
                                <div class="col-5 text-right">
                                    <a href="<?= base_url() . 'index.php/portfolio/incubation_relationship/' . $innovation_id; ?>" id="edit_cmpny"><?= $view_title; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="detailshow-profile">
                            <div class="row">
                                <div class="col-12">
                                    <div class="profile-tabletwo">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Type</th>
                                                    <th width="30%">Brief Purpose</th>
                                                    <th width="15%">Signed on</th>
                                                    <th width="20%">Document</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h6>Initial Incubation Agreement</h6>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $ini_content = strlen($iniAgree->purpose) > 50 ? substr($iniAgree->purpose, 0, 50) . "..." : $iniAgree->purpose;
                                                        echo $ini_content;
                                                        ?>
                                                    </td>
                                                    <td><?= $iniAgree->sign; ?></td>
                                                    <td>
                                                        <?php if (isset($iniAgree->link) && !empty($iniAgree->link)) { ?>
                                                            <a href="<?php echo base_url() . 'uploads/portfolio/incubation_relation/' . $iniAgree->link; ?>" target="_blank">
                                                                <i class="fas fa-file-download"></i>
                                                                <?php echo strlen($iniAgree->link) > 20 ? "..." . substr($iniAgree->link, -20) : $iniAgree->link; ?>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6>TAP Agreement</h6>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $tap_content = strlen($tapAgree->purpose) > 50 ? substr($tapAgree->purpose, 0, 50) . "..." : $tapAgree->purpose;
                                                        echo $tap_content;
                                                        ?>
                                                    </td>
                                                    <td><?= $tapAgree->sign; ?></td>
                                                    <td>
                                                        <?php if (isset($tapAgree->link) && !empty($tapAgree->link)) { ?>
                                                            <a href="<?php echo base_url() . 'uploads/portfolio/incubation_relation/' . $tapAgree->link; ?>" target="_blank">
                                                                <i class="fas fa-file-download"></i>
                                                                <?php echo strlen($tapAgree->link) > 20 ? "..." . substr($tapAgree->link, -20) : $tapAgree->link; ?>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6>Mentoring Agreement</h6>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $men_content = strlen($menAgree->purpose) > 50 ? substr($menAgree->purpose, 0, 50) . "..." : $menAgree->purpose;
                                                        echo $men_content;
                                                        ?>
                                                    </td>
                                                    <td><?= $menAgree->sign; ?></td>
                                                    <td>
                                                        <?php if (isset($menAgree->link) && !empty($menAgree->link)) { ?>
                                                            <a href="<?php echo base_url() . 'uploads/portfolio/incubation_relation/' . $menAgree->link; ?>" target="_blank">
                                                                <i class="fas fa-file-download"></i>
                                                                <?php echo strlen($menAgree->link) > 20 ? "..." . substr($menAgree->link, -20) : $menAgree->link; ?>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6>Exit Letter</h6>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $exit_content = strlen($exitAgree->purpose) > 50 ? substr($exitAgree->purpose, 0, 50) . "..." : $exitAgree->purpose;
                                                        echo $exit_content;
                                                        ?>
                                                    </td>
                                                    <td><?= $exitAgree->sign; ?></td>
                                                    <td>
                                                        <?php if (isset($exitAgree->link) && !empty($exitAgree->link)) { ?>
                                                            <a href="<?php echo base_url() . 'uploads/portfolio/incubation_relation/' . $exitAgree->link; ?>" target="_blank">
                                                                <i class="fas fa-file-download"></i>
                                                                <?php echo strlen($exitAgree->link) > 20 ? "..." . substr($exitAgree->link, -20) : $exitAgree->link; ?>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                foreach ($incub_more as $incub) {
                                                    $reldata = isset($incub) ? $incub['data'] : '';
                                                    $reljson = json_decode($reldata);
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <h6><?= $reljson->type; ?></h6>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $add_content = strlen($reljson->purpose) > 50 ? substr($reljson->purpose, 0, 50) . "..." : $reljson->purpose;
                                                            echo $add_content;
                                                            ?>
                                                        </td>
                                                        <td><?= $reljson->sign; ?></td>
                                                        <td>
                                                            <?php if (isset($reljson->link) && !empty($reljson->link)) { ?>
                                                                <a href="<?php echo base_url() . 'uploads/portfolio/incubation_relation/' . $reljson->link; ?>" target="_blank">
                                                                    <i class="fas fa-file-download"></i>
                                                                    <?php echo strlen($reljson->link) > 20 ? "..." . substr($reljson->link, -20) : $reljson->link; ?>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <?php
                                                foreach ($mentor_plan as $mentor) {
                                                    $mentor_emp_name = $this->Mportfolio->getEmpDetailsById($mentor['name']);
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <h6>Mentor: <?= '<br>' . $mentor_emp_name[0]['emp_names']; ?></h6>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $add_content = strlen($mentor['comment']) > 50 ? substr($mentor['comment'], 0, 50) . "..." : $mentor['comment'];
                                                            echo $add_content;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $mentor_startDate = (isset($mentor['start_date']) && $mentor['start_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($mentor['start_date'])) : '-';
                                                            $mentor_endDate = (isset($mentor['end_date']) && $mentor['end_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($mentor['end_date'])) : '-';
                                                            echo $mentor_startDate . ' to <br>' . $mentor_endDate;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php if (isset($mentor['sow_document']) && !empty($mentor['sow_document'])) { ?>
                                                                <a href="<?php echo base_url() . 'uploads/portfolio/mentor/' . $mentor['sow_document']; ?>" target="_blank">
                                                                    <i class="fas fa-file-download"></i>
                                                                    <?php echo strlen($mentor['sow_document']) > 20 ? "..." . substr($mentor['sow_document'], -20) : $mentor['sow_document']; ?>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <?php
                                                foreach ($technical_achieve as $tech) {
                                                    $tech_cond['id'] = $tech['firm_engaged'];
                                                    $mentor_emp_name = $this->Mportfolio->getDetails('port_service_providers', $tech_cond);
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <h6>Technical Assistance: <?= '<br>' . $mentor_emp_name[0]['name']; ?></h6>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $add_content = strlen($tech['comment']) > 50 ? substr($tech['comment'], 0, 50) . "..." : $tech['comment'];
                                                            echo $add_content;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $mentor_startDate = (isset($tech['month_engaged']) && $tech['month_engaged'] != '0000-00-00') ? date('d-m-Y', strtotime($tech['month_engaged'])) : '-';
                                                            $mentor_endDate = (isset($tech['month_end']) && $tech['month_end'] != '0000-00-00') ? date('d-m-Y', strtotime($tech['month_end'])) : '-';
                                                            echo $mentor_startDate . ' to <br>' . $mentor_endDate;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php if (isset($tech['contract_doc']) && !empty($tech['contract_doc'])) { ?>
                                                                <a href="<?php echo base_url() . 'uploads/portfolio/tap/contract/' . $tech['contract_doc']; ?>" target="_blank">
                                                                    <i class="fas fa-file-download"></i>
                                                                    <?php echo strlen($tech['contract_doc']) > 20 ? "..." . substr($tech['contract_doc'], -20) : $tech['contract_doc']; ?>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="3">&nbsp;</td>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                                <!-- <tr>
                                                                    <td colspan="3" class="brd-none">
                                                                        <h6>Completion Status</h6>
                                                                    </td>
                                                                    <td colspan="2" class="brd-none">
                                                                        <p class="<?= $increl_msg; ?>"><strong><?= $increl_text; ?>&nbsp;<?= $increl_icon; ?></strong></p>
                                                                    </td>
                                                                </tr> -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-Cap" role="tabpanel" aria-labelledby="v-pills-Cap-tab">
                                        <div>
                                            <div class="row detailheader-profile">
                                                <div class="col-7">
                                                    <h6>Cap Table</h6>
                                                </div>
                                                <div class="col-5 text-right">
                                                    <a href="<?= base_url() . 'index.php/portfolio/cap_table/' . $innovation_id; ?>" id="edit_cmpny"><?= $view_title; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="detailshow-profile">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="profile-tabletwo">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%">S. No</th>
                                                                    <th width="25%">Shareholders</th>
                                                                    <th width="13%">% Shares</th>
                                                                    <th width="15%">Type of shares</th>
                                                                    <th width="17%">Vesting ?</th>
                                                                    <th width="20%">Vesting Schedule</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                for ($i = 0; $i < count($capTableDetails); $i++) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><p><?= $i + 1; ?></p></td>
                                                                        <td><p><?= $capTableDetails[$i]['name']; ?></p></td>
                                                                        <td><p><?= $capTableDetails[$i]['percentage']; ?></p></td>
                                                                        <td><p><?= $capTableDetails[$i]['type']; ?></p></td>
                                                                        <td>
                                                                            <p>
                                                                                <?php
                                                                                if ($capTableDetails[$i]['vesting'] == 1) {
                                                                                    echo "Yes";
                                                                                } else {
                                                                                    echo "No";
                                                                                }
                                                                                ?>
                                                                            </p>
                                                                        </td>
                                                                        <td><p><?= $capTableDetails[$i]['vesting_schedule']; ?></p></td>
                                                                    </tr>
                                                                <?php } ?>


                                                                <tr>
                                                                    <td colspan="3">&nbsp;</td>
                                                                    <td colspan="3">&nbsp;</td>
                                                                </tr>
                                        <!-- <tr>
                                            <td colspan="2" class="brd-none">
                                                <h6>Completion Status</h6>
                                            </td>
                                            <td colspan="4" class="brd-none">
                                                <p class="<?= $cap_msg; ?>"><strong><?= $cap_text; ?>&nbsp;<?= $cap_icon; ?></strong></p>
                                            </td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-Interested" role="tabpanel" aria-labelledby="v-pills-Interested-tab">
                <div>
                    <div class="row detailheader-profile">
                        <div class="col-7">
                            <h6>Other Interested Parties</h6>
                        </div>
                        <div class="col-5 text-right">
                            <a href="<?= base_url() . 'index.php/portfolio/interested_parties/' . $innovation_id; ?>" id="edit_cmpny"><?= $view_title; ?></a>
                        </div>
                    </div>
                </div>
                <div class="detailshow-profile">
                    <div class="row">
                        <div class="col-12">
                            <div class="profile-tabletwo">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="10%">S.No</th>
                                            <th width="40%">Name</th>
                                            <th width="30%">Nature of Relation</th>
                                            <th width="20%">Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for ($i = 0; $i < count($otherInterests); $i++) {
                                            ?>
                                            <tr>
                                                <td><p><?= $i + 1; ?></p></td>
                                                <td><p><?= $otherInterests[$i]['name']; ?></p></td>
                                                <td><p><?= $otherInterests[$i]['relation']; ?></p></td>
                                                <td><p><?= $otherInterests[$i]['comments']; ?></p></td>
                                            </tr>
                                        <?php } ?>

                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                                        <!-- <tr>
                                                            <td colspan="2" class="brd-none">
                                                                <h6>Completion Status</h6>
                                                            </td>
                                                            <td colspan="2" class="brd-none">
                                                                <p class="<?= $int_msg; ?>"><strong><?= $int_text; ?>&nbsp;<?= $int_icon; ?></strong></p>
                                                            </td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-Configuration" role="tabpanel" aria-labelledby="v-pills-Configuration-tab">...</div>
                            <div class="tab-pane fade" id="v-pills-Forms" role="tabpanel" aria-labelledby="v-pills-Forms-tab">...</div>
                            <div class="tab-pane fade" id="v-pills-Log" role="tabpanel" aria-labelledby="v-pills-Log-tab">
                                <div>
                                    <div class="row detailheader-profile">
                                        <div class="col-7">
                                            <h6>Application Status Log - Deals</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="detailshow-profile">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="profile-tabletwo">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th width="10%">Date</th>
                                                            <th width="10%">Time</th>
                                                            <th width="30%">Assigned Incharge</th>
                                                            <th width="15%">Updated By</th>
                                                            <th width="15%">Deal Stage</th>
                                                            <th width="20%">Deal Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        $reg_date = date('d-m-Y', strtotime($log_details[0]['created_date']));
                                                        $reg_time = date('h:i A', strtotime($log_details[0]['created_date']));
                                                        ?>

                                                        <tr>
                                                            <td style="padding:5px;"><?php echo $reg_date; ?></td>
                                                            <td style="padding:5px;"><?php echo $reg_time; ?></td>
                                                            <td style="padding:5px;"><?php echo $log_details[0]['assigned_incharge']; ?></td>
                                                            <td style="padding:5px;">-</td>
                                                            <td style="padding:5px;">Application</td>
                                                            <td style="padding:5px;">Registered</td>
                                                        </tr>

                                                        <?php
                                                        foreach ($log_details as $row) {
                                                            $date = date('d-m-Y', strtotime($row['modified_date']));
                                                            $time = date('h:i A', strtotime($row['modified_date']));

                                                            $stage = $this->Minnovation->getInnvationStage();
                                                            $status = $this->Minnovation->getInnvationStatus();
                                                            $status_text = $status[$row['status']];
                                                            $stage_text = $stage[$row['stage']];
                                                            ?>

                                                            <tr>

                                                                <?php
                                                                if ($row['reason'] != '') {
                                                                    ?>
                                                                    <td colspan="6" style="padding:5px;text-align:center;font-weight:bold;"><?php echo $row['reason']; ?></td>
                                                                    <?php
                                                                } else {
                                                                    ?>

                                                                    <td style="padding:5px;"><?php echo $date; ?></td>
                                                                    <td style="padding:5px;"><?php echo $time; ?></td>
                                                                    <td style="padding:5px;"><?php echo $row['assigned_incharge']; ?></td>
                                                                    <td style="padding:5px;"><?php
                                                                    if ($row['modified_by_user'])
                                                                        echo $row['modified_by_user'];
                                                                    else
                                                                        echo 'Admin';
                                                                    ?></td>
                                                                    <td style="padding:5px;"><?php echo $stage_text; ?></td>
                                                                    <td style="padding:5px;"><?php echo $status_text; ?></td>

                                                                    <?php
                                                                }
                                                                ?>

                                                            </tr>


                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio')); ?>



<style type="text/css">
    body{margin: 0px !important;     background-color: #000;}
    .companyProfile-sidemenu{
        /* display: contents; */
    }
    .tab-pane{
        width:98%;
    }
</style>

</body>
</html>