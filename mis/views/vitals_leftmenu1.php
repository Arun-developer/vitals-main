<style type="text/css">
    .sidebar_show { display: block !important; }
    .sidebar-dropdown.active .sidebar-submenu { display: block !important; }
    .submenucolor{
        background-color:#c9e4d3;
    }
</style>

<?php
$sess_empid = $this->session->userdata('emp_number');
$partner_id = $this->session->userdata('partner_id');

$finance_user_count = financeuser_count($sess_empid);
$fin_user = 0;
if ($finance_user_count == 1) {
    $fin_user = 1;
}

if ($left_menu == 'approve') {

    if (($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin')) {
        $an_approval_count = total_apppending_count();
        $in_approval_count = totalin_apppending_count();
    } else {
        $an_approval_ceo_count = 0;
        $ceo_status = '';
        if ($ceo == $sess_empid) {
            $ceo_status = 'Yes';
            $an_approval_ceo_count = total_an_ceo_count();
        }

        $data['an_rocount'] = $rocount = total_ropending_count($sess_empid);
        $data['an_phcount'] = $phcount = total_phpending_count($sess_empid);
        $an_approval_count = $rocount + $phcount + $an_approval_ceo_count;

        $in_rocount = totalin_ropending_count($sess_empid);
        $in_appcount = totalin_apppending_count($sess_empid);

        $finance_user_count = financeuser_count($sess_empid);
        $fincount = 0;
        if ($finance_user_count == 1) {
            $fincount += totalin_finpending_count();
        }
        $in_approval_count = $in_rocount + $in_appcount + $fincount;
    }

    $ph_user_count = $this->Mapproval->get_ph_user($sess_empid, $partner_id);

    $data['ph_Usercount'] = '0';
    if (!empty($ph_user_count)) {
        $data['ph_Usercount'] = '1';
    }

}

$get_travel_count = total_pending_count('travel');
$travel_count = 0;
if ($get_travel_count != '') {
    $travel_count = total_pending_count('travel');
}

$approval_count = approve_leave_list();
$lastsegment = end($this->uri->segment_array());

if ($page == 'emp_list') {
    $employee_active = 'active';
    $employee_menu = 'show';
} else if ($page == 'job') {
    $job_active = 'active';
    $job_menu = 'show';
} else if ($page == 'holiday') {
    $holiday_active = 'active';
    $holiday_menu = 'show';
} else if ($page == 'work_type') {
    $work_type_active = 'active';
    $work_type_menu = 'show';
} else if ($page == 'week_setup') {
    $work_setup_active = 'active';
    $work_setup_menu = 'show';
} else if ($page == 'work_days') {
    $work_days_active = 'active';
    $work_days_menu = 'show';
} else if ($page == 'working_days') {
    $working_days_active = 'active';
    $working_days_menu = 'show';
} else if ($page == 'leave_type') {
    $leave_type_active = 'active';
    $leave_type_menu = 'show';
} else if ($page == 'partner') {
    $partner_active = 'active';
    $partner_menu = 'show';
} else if ($page == 'admin_master') {
    $admin_master_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'asset_master') {

    if($lastsegment=='it'){
        $itsegment='active';
        $assetinventormaster='show';
        $submenuback='active';
        
    }else if($lastsegment=='general'){
        $generalsegment='active';
        $assetinventormaster='show';
        $submenuback='active';
    }else if($lastsegment=='vendor_master'){
        $vendorsegment='active';
        $assetmaster='show';
        $submenubackmaster='active';
    }
    else if($lastsegment=='it_asset'){
        $itassetsegment='active';
        $assetmaster='show';
        $submenubackmaster='active';
    } 
    else if($lastsegment=='general_asset'){
        $generalassetsegment='active';
        $assetmaster='show';
        $submenubackmaster='active';
    } 
    
    $asset_setting_active = 'active';
    $admin_master_menu = 'show';
}
else if($page == 'assetPay'){
    if($lastsegment=='listpayment'){
        $paysegment='active';
        $assetinventormaster='show';
        $submenuback='active ';
    } 
    $asset_setting_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'books_master') {
    $books_setting_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'visitors_log') {
    $log_setting_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'dispatch_inward') {
    $inward_setting_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'dispatch_outward') {
    $outward_setting_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'nodue') {
    $due_setting_active = 'active';
    $employee_menu = 'show';
} else if ($page == 'pay_grade') {
    $pay_grade_active = 'active';
    $admin_master_menu = 'show';
} else if ($page == 'leave') {
    $leave_active = 'active';
    $leave_menu = 'show';
} else if ($page == 'approve_leave') {
    $approve_leave_active = 'active';
    $approve_leave_menu = 'show';
} else if ($page == 'user_setup') {
    $usersetup_active = 'active';
    $employee_menu = 'show';
} else if ($page == 'incubation_masters') {
    $incubation_master_active = 'active';
    $incubation_master_menu = 'show';
} else if ($page == 'reason') {
    $reason_setting_active = 'active';
    $incubation_master_menu = 'show';
} else if ($page == 'donor_fit') {
    $donor_setting_active = 'active';
    $incubation_master_menu = 'show';
} else if ($page == 'portfolio_settings') {
    $portfolio_settings_active = 'active';
    $incubation_master_menu = 'show';
} else if ($page == 'mail_template') {
    $mail_template_active = 'active';
    $incubation_master_menu = 'show';
} else if ($page == 'approval_note') {
    $approval_note_active = 'active';
    $approval_note_menu = 'show';
} else if ($page == 'new_approval_note') {
    $new_approval_note_active = 'active';
    $new_approval_note_menu = 'show';
} else if ($page == 'my_approval_note') {
    $my_an_active = 'active';
    $my_an_menu = 'show';
} else if ($page == 'internal_note') {
    $internal_note_active = 'active';
    $internal_note_menu = 'show';
} else if ($page == 'my_internal_note') {
    $my_in_active = 'active';
    $my_in_menu = 'show';
} else if ($page == 'new_internal_note') {
    $new_internal_note_active = 'active';
    $new_internal_note_menu = 'show';
} else if ($page == 'bookrequest') {
    $bookrequest_active = 'active';
    $bookrequest_menu = 'show';
} else if ($page == 'booklist') {
    $booklist_active = 'active';
    $booklist_menu = 'show';
} else if ($page == 'assetUse') {
    $assetUse_active = 'active';
    $assetlist_menu = 'show';
} else if ($page == 'assetTrans') {
    $assettrans_active = 'active';
    $assetlist_menu = 'show';
} else if ($page == 'assetSalary') {
    $assetsalary_active = 'active';
    $assetlist_menu = 'show';
} else if ($page == 'assetlist') {
    $assetlist_active = 'active';
    $assetlist_menu = 'show';
} else if ($page == 'assetAvail') {
    $assetavail_active = 'active';
    $assetlist_menu = 'show';
} else if ($page == 'assetPay') {
    $assetpay_active = 'active';
    $assetlist_menu = 'show';
} else if ($page == 'assetEmp') {
    $assetemp_active = 'active';
    $assetlist_menu = 'show';
} else if ($page == 'travellist') {
    $travellist_active = 'active';
} else if ($page == 'reportlist') {
    $reportlist_active = 'active';
    $reportlist_menu = 'show';
} else if ($page == 'reportInno') {
    $reportInno_active = 'active';
    $reportInno_menu = 'show';
} else if ($page == 'reportUtil') {
    $reportUtil_active = 'active';
    $reportUtil_menu = 'show';
} else if ($page == 'reportAn') {
    $reportAn_active = 'active';
    $reportAn_menu = 'show';
} else if ($page == 'deals') {
    $deals_active = 'active';
    $deals_menu = 'show';
} else if ($page == 'pre_assitant') {
    $pre_assitant_active = 'active';
    $pre_assitant_menu = 'show';
} else if ($page == 'diligence_summary') {
    $diligence_summary_active = 'active';
    $diligence_summary_menu = 'show';
} else if ($page == 'diligence_company') {
    $diligence_company_active = 'active';
    $diligence_company_menu = 'show';
} else if ($page == 'diligence_document') {
    $diligence_document_active = 'active';
    $diligence_document_menu = 'show';
} else if ($page == 'diligence_detail') {
    $diligence_detail_active = 'active';
    $diligence_detail_menu = 'show';
} else if ($page == 'mail_history') {
    $mail_history_active = 'active';
    $mail_history_menu = 'show';
} else if ($page == 'view_document') {
    $view_document_active = 'active';
    $view_document_menu = 'show';
} else if ($page == 'app_option') {
    $option_active = 'active';
    $option_menu = 'show';
} else if ($page == 'change_password') {
    $change_password_active = 'active';
} else if ($page == 'funder_summary') {
    $funder_summary_active = 'active';
    $funder_summary_menu = 'show';
} else if ($page == 'funder_grant') {
    $funder_grant_active = 'active';
    $funder_grant_menu = 'show';
} else if ($page == 'master_settings') {
    $master_settings_active = 'active';
    $master_setting_menu = 'show';
} else if ($page == 'stage_efficiency') {
    $stage_efficiency_active = 'active';
    $master_setting_menu = 'show';
} else if ($page == 'document_type') {
    $document_type_active = 'active';
    $master_setting_menu = 'show';
} else if ($page == 'meeting_type') {
    $meeting_type_active = 'active';
    $master_setting_menu = 'show';
} else if ($page == 'budget_master') {
    $budget_active = $balance_active = 'active';
    $program_menu = 'show';
} else if ($page == 'budget_program') {
    $budget_active = $programme_active = 'active';
    $program_menu = 'show';
} else if ($page == 'budget_head') {
    $budget_active = $budget_head_active = 'active';
    $budget_head_menu = 'show';
} else if ($page == 'line_item') {
    $budget_active = $line_item_active = 'active';
    $line_menu = 'show';
} else if ($page == 'additional_info') {
    $budget_active = $additional_info_active = 'active';
    $additional_menu = 'show';
} else if ($page == 'financial_year') {
    $budget_active = $financial_year_active = 'active';
    $financial_menu = 'show';
}

$split_menu = explode(',', $this->session->userdata['menuAccess']);
?>

<?php if ($left_menu == 'sendmail') { ?>
    <div id="leftMenuLoad">
        <nav class="navbar navbar-expand-lg ">
            <div class="collapse navbar-collapse show" id="navbarCollapse">
                <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
                    <li class="nav-item" >
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>" ><span><i class="far fa-file-alt"></i></span> All Deals</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="javascript:void(0);"><span><i class="far fa-envelope"></i></span> Send Email</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
<?php } else if ($left_menu == 'application') { ?>
    <div id="leftMenuLoad">
        <nav class="navbar navbar-expand-lg ">
            <div class="collapse navbar-collapse show" id="navbarCollapse">
                <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
                    <li class="nav-item <?= $deals_active; ?>" >
                        <?php if ($application_id == '' || ($this->session->userdata['role_id'] == '4' && !in_array('3', $split_menu))) { ?>
                            <a class="nav-link disableIcon" href="javascript:void(0);" ><span><i class="far fa-file-alt"></i></span> Application Form</a>
                        <?php } else { ?>
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>" ><span><i class="far fa-file-alt"></i></span> Application Form</a>
                        <?php } ?>
                    </li>
                    <li class="nav-item <?= $pre_assitant_active; ?>">
                        <?php if ($application_id == '' || ($this->session->userdata['role_id'] == '4' && !in_array('4', $split_menu))) { ?>
                            <a class="nav-link disableIcon" href="javascript:void(0);"><span><i class="far fa-copy"></i></span> Preliminary Assessment</a>
                        <?php } else { ?>
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/application/assessment_scoring/' . $application_id; ?>"><span><i class="far fa-copy"></i></span> Preliminary Assessment</a>
                        <?php } ?>
                    </li>
                    <?php if ($inv_stage == '9' || $inv_stage == '12') { ?>
                        <li class="nav-item <?= $diligence_summary_active; ?> <?= $diligence_company_active; ?> <?= $diligence_document_active; ?> <?= $diligence_detail_active; ?>">
                            <?php if ($this->session->userdata['role_id'] == '4' && !in_array('5', $split_menu)) { ?>
                                <a class="nav-link disableIcon" href="javascript:void(0);"><span><i class="fas fa-book-open"></i></span> Detailed Diligence</a>
                            <?php } else { ?>
                                <a class="nav-link nav-link-collapse" href="void:javascript(0);" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-book-open"></i> Detailed Diligence</a>
                            <?php } ?>
                            <ul class="nav-second-level collapse <?= $diligence_summary_menu; ?> <?= $diligence_company_menu; ?> <?= $diligence_document_menu; ?> <?= $diligence_detail_menu; ?>" id="collapseSubItems4" data-parent="#navAccordion">
                                <li class="nav-item <?= $diligence_summary_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/application/diligence_summary/' . $application_id; ?>">
                                        <span class="nav-link-text">Summary</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $diligence_company_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/application/diligence_company_data/' . $application_id; ?>">
                                        <span class="nav-link-text">Company & Team</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $diligence_document_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/application/diligence_documents/' . $application_id; ?>">
                                        <span class="nav-link-text">Documents & Meetings</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $diligence_detail_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/application/assessment_background/' . $application_id; ?>">
                                        <span class="nav-link-text">Detailed Assessment</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if ($inv_stage == '12') { ?>
                        <li class="nav-item">
                            <?php if ($this->session->userdata['role_id'] == '4' && !in_array('6', $split_menu)) { ?>
                                <a class="nav-link" href="void:javascript(0);"><i class="fas fa-flag-checkered"></i> Portfolio</a>
                            <?php } else { ?>
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/portfolio/company_summary/' . $application_id; ?>"><i class="fas fa-flag-checkered"></i> Portfolio</a>
                            <?php } ?>
                        </li>
                    <?php } ?>
                    <li class="nav-item <?= $option_active; ?>" >
                        <?php if ($application_id == '') { ?>
                            <a class="nav-link disableIcon" href="javascript:void(0);"><i class="fas fa-filter"></i> Options</a>
                        <?php } else { ?>
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/application/assign_incharge/' . $application_id; ?>"><i class="fas fa-filter"></i> Options</a>
                        <?php } ?>
                    </li>
                    <li class="nav-item <?= $mail_history_active; ?>" >
                        <?php if ($application_id == '') { ?>
                            <a class="nav-link disableIcon" href="javascript:void(0);"><i class="far fa-envelope"></i> Mail History</a>
                        <?php } else { ?>
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/application/mail_history/' . $application_id; ?>"><i class="far fa-envelope"></i> Mail History</a>
                        <?php } ?>
                    </li>
                    <li class="nav-item <?= $view_document_active; ?>" >
                        <?php if ($application_id == '') { ?>
                            <a class="nav-link disableIcon" href="javascript:void(0);"><i class="far fa-eye"></i> Documents</a>
                        <?php } else { ?>
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/application/view_documents/' . $application_id; ?>"><i class="far fa-eye"></i> Documents</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
<?php } else if ($left_menu == 'approve') { ?>
    <?php
    if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') {
        $approve_url = 'approvaladmin/approval_notes/pending';
        $internal_url = 'internaladmin/internal_notes/pending/';
        $leave_url = 'leave/approve_leave_list';
        $book_url = 'approval/requests/pending';
        $asset_url = 'asset_admin/listasset';
        $travel_url = 'traveladmin/requestlist/pending';
        $finance_archives_url = 'approvaladmin/archive';
        $finance_archives_internal_url = 'internaladmin/archive';
    } else {
        $approve_url = 'approval_note/all_pending';
        $internal_url = 'internal_notes/pending';
        $leave_url = 'leave/approve_leave_list';
        $book_url = 'requests/pending';
        $asset_url = 'asset/requestlist/using';
        $travel_url = 'travel/request_form/book_request';
        $finance_archives_url = 'approval/archive';
        $finance_archives_internal_url = 'internal/archive';
    }
    ?>
    <?php
    if (isset($an_approval_count) && $an_approval_count != 0) {
        $approve_notify = '&nbsp;&nbsp;<span class="clr_redbtn"><i class="fas fa-exclamation-circle"></i></span>';
        $approve_subnotify = '(' . $an_approval_count . ')';
    } else {
        $approve_notify = "";
        $approve_subnotify = "";
    }
    if (isset($in_approval_count) && $in_approval_count != 0) {
        $internal_notify = '&nbsp;&nbsp;<span class="clr_redbtn"><i class="fas fa-exclamation-circle"></i></span>';
        $internal_subnotify = '(' . $in_approval_count . ')';
    } else {
        $internal_notify = "";
        $internal_subnotify = "";
    }
    if (isset($approval_count) && $approval_count != 0) {
        $leave_notify = '&nbsp;&nbsp;<span class="clr_redbtn"><i class="fas fa-exclamation-circle"></i></span>';
        $leave_subnotify = '(' . $approval_count . ')';
    } else {
        $leave_notify = "";
        $leave_subnotify = "";
    }
    if (($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin')) {
        if ($travel_count != 0) {
            $travel_notify = '(' . $travel_count . ')';
        } else {
            $travel_notify = "";
        }
    }
    
    $finance_status = '';
    $internal_finance_status = '';
    if($page =='approval_note' && $fin_user == 1 && $this->uri->segment(2)=='archive' && $this->uri->segment(3)=='1'){
        $finance_status = 'active';
    }
    if($page =='internal_note' && $fin_user == 1 && $this->uri->segment(2)=='archive' && $this->uri->segment(3)=='1'){
        $internal_finance_status = 'active';
    }   
	$fin_user_status = '';
	if($fin_user == '1' && $this->session->userdata('isAdmin') != 'Yes'){
		$fin_user_status = '1';
	}
    
    ?>
    <div id="leftMenuLoad">
        <nav class="navbar navbar-expand-lg ">
            <div class="collapse navbar-collapse show" id="navbarCollapse">
                <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
                    <li class="nav-item <?= $new_approval_note_active; ?> <?= $approval_note_active; ?> <?= $my_an_active; ?>">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems2" aria-controls="collapseSubItems2" aria-expanded="false"><i class="fas fa-book-reader"></i> Approval Note<?= $approve_notify; ?></a>
                        <ul class="nav-second-level collapse <?= $approval_note_menu; ?> <?= $new_approval_note_menu; ?> <?= $my_an_menu; ?>" id="collapseSubItems2" data-parent="#navAccordion">
                            <?php if ($this->session->userdata('user_type') == 'employee') { ?>
                                <li class="nav-item <?= $new_approval_note_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/approval/new_approval'; ?>">
                                        <span class="nav-link-text">Raise Approval Note</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="nav-item <?= $approval_note_active.$finance_status; ?> <?= $my_an_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/approval/' . $approve_url; ?>">
                                    <span class="nav-link-text">Approve <?= $approve_subnotify; ?></span>
                                </a>
                            </li>
                            <?php if($fin_user_status=='1') {?>
                                <li class="nav-item <?= $finance_status; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/'.$finance_archives_url.'/1'; ?>">
                                        <span class="nav-link-text">Archives</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item <?= $my_in_active; ?> <?= $internal_note_active; ?> <?= $new_internal_note_active; ?>">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-address-card"></i> Internal Note<?= $internal_notify; ?></a>
                        <ul class="nav-second-level collapse <?= $my_in_menu; ?> <?= $internal_note_menu; ?> <?= $new_internal_note_menu; ?>" id="collapseSubItems3" data-parent="#navAccordion">
                            <?php if ($this->session->userdata('user_type') == 'employee') { ?>
                                <li class="nav-item <?= $my_in_active; ?> <?= $new_internal_note_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/internal/confirmed_approval_note'; ?>">
                                        <span class="nav-link-text">Raise internal note</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="nav-item <?= $internal_note_active.$internal_finance_status; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/internal/' . $internal_url; ?>">
                                    <span class="nav-link-text">Approve <?= $internal_subnotify; ?></span>
                                </a>
                            </li>
                            <?php if($fin_user_status=='1') {?>
                                <li class="nav-item <?= $internal_finance_status; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/'.$finance_archives_internal_url.'/1'; ?>">
                                        <span class="nav-link-text">Archives</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item <?= $leave_active; ?> <?= $approve_leave_active; ?>">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-chess-pawn"></i> Leave<?= $leave_notify; ?></a>
                        <ul class="nav-second-level collapse <?= $leave_menu; ?> <?= $approve_leave_menu; ?>" id="collapseSubItems4" data-parent="#navAccordion">
                            <?php if ($this->session->userdata('user_type') == 'employee') { ?>
                                <li class="nav-item <?= $leave_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/apply_leave'; ?>">
                                        <span class="nav-link-text">Apply For Leave</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php // if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin' || count($supervisor) > 0) {   ?>
                                <li class="nav-item <?= $approve_leave_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/' . $leave_url; ?>">
                                        <span class="nav-link-text">Approve <?= $leave_subnotify; ?></span>
                                    </a>
                                </li>
                                <?php // }    ?>
                            </ul>
                        </li>
                        <li class="nav-item <?= $assetUse_active; ?> <?= $assettrans_active; ?> <?= $assetsalary_active; ?> <?= $assetlist_active; ?> <?= $assetavail_active; ?><?= $assetemp_active; ?>">
                            <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems5" aria-controls="collapseSubItems5" aria-expanded="false"><i class="fas fa-wallet"></i> Assets</a>
                            <ul class="nav-second-level collapse <?= $assetlist_menu; ?>" id="collapseSubItems5" data-parent="#navAccordion">
                                <?php if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') { ?>
                                 <li class="nav-item <?= $assetUse_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/asset_admin/requestlist/using'; ?>">
                                        <span class="nav-link-text">Assets in Use</span>
                                    </a>
                                </li>

                                <li class="nav-item <?= $assetemp_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/asset_admin/listpayment_employee'; ?>">
                                        <span class="nav-link-text">Deductions for Asset Usage</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $assettrans_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/asset_admin/transaction_history'; ?>">
                                        <span class="nav-link-text">Transaction History</span>
                                    </a>
                                </li>

                                <li class="nav-item <?= $assetlist_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/asset_admin/listasset'; ?>">
                                        <span class="nav-link-text">Assign Asset to Employee</span>
                                    </a>
                                </li>

                                <li class="nav-item <?= $assetavail_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/asset_admin/notavail'; ?>">
                                        <span class="nav-link-text">Assets Not Available</span>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item <?= $assetUse_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/' . $asset_url; ?>">
                                        <span class="nav-link-text">Assets In Use</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $assettrans_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/asset/requestlist/returned'; ?>">
                                        <span class="nav-link-text">Transaction History</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $assetsalary_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/asset/listpayment'; ?>">
                                        <span class="nav-link-text">Salary Deduction</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item <?= $bookrequest_active; ?> <?= $booklist_active; ?>">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems6" aria-controls="collapseSubItems6" aria-expanded="false"><i class="fas fa-book"></i> Book</a>
                        <ul class="nav-second-level collapse <?= $bookrequest_menu; ?> <?= $booklist_menu; ?>" id="collapseSubItems6" data-parent="#navAccordion">
                            <?php if ($this->session->userdata('user_type') == 'employee') { ?>
                                <li class="nav-item <?= $bookrequest_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/book/booklist/book_request'; ?>">
                                        <span class="nav-link-text">Request for a book</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="nav-item <?= $booklist_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/book/' . $book_url; ?>">
                                    <span class="nav-link-text">Requests</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item <?= $travellist_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/' . $travel_url; ?>" aria-controls="collapseSubItems7" aria-expanded="false"><i class="fas fa-route"></i> Travel & Accommodations <?= $travel_notify; ?>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<?php } else if ($left_menu == 'change_password') { ?>
    <div id="leftMenuLoad">
        <nav class="navbar navbar-expand-lg">
            <div class="collapse navbar-collapse show" id="navbarCollapse">
                <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
                    <li class="nav-item <?= $change_password_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/changepass'; ?>"><i class="fas fa-key"></i> Change Password</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
<?php } else if ($left_menu == 'funder') { ?>
    <div id="leftMenuLoad">
        <nav class="navbar navbar-expand-lg">
            <div class="collapse navbar-collapse show" id="navbarCollapse">
                <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
    <!--                    <li class="nav-item <?= $funder_summary_active; ?> <?= $funder_grant_active; ?>">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems9" aria-controls="collapseSubItems9" aria-expanded="false"><i class="fas fa-gem"></i> Funds/Grants</a>
                        <ul class="nav-second-level collapse <?= $funder_summary_menu; ?> <?= $funder_grant_menu; ?>" id="collapseSubItems9" data-parent="#navAccordion">-->
                            <li class="nav-item <?= $funder_summary_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/funder/display_summary_list'; ?>">
                                    <span class="nav-link-text">Summary</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $funder_grant_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/funder/add_funder_form'; ?>">
                                    <span class="nav-link-text">Add Funder/Grant</span>
                                </a>
                            </li>
                    <!--                        </ul>
                    </li>-->
                </ul>
            </div>
        </nav>
    </div>
<?php } else if ($left_menu == 'report') { ?>
    <div id="leftMenuLoad">
        <nav class="navbar navbar-expand-lg">
            <div class="collapse navbar-collapse show" id="navbarCollapse">
                <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
    <!--                    <li class="nav-item <?= $reportlist_active; ?> <?= $reportInno_active; ?> <?= $reportUtil_active; ?>">
                        <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems8" aria-controls="collapseSubItems8" aria-expanded="false"><i class="fas fa-flag-checkered"></i> Reports</a>
                        <ul class="nav-second-level collapse <?= $reportlist_menu; ?> <?= $reportInno_menu; ?> <?= $reportUtil_menu; ?>" id="collapseSubItems8" data-parent="#navAccordion">-->
                            <?php if (($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') || $fin_user == 1) { ?>
                                <li class="nav-item <?= $reportAn_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/report/report_an'; ?>">
                                        <span class="nav-link-text">AN / IN Report</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="nav-item <?= $reportUtil_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/report/untilized_report'; ?>">
                                    <span class="nav-link-text">Approval Note Unutilized Report</span>
                                </a>
                            </li>   
                            <!-- <li class="nav-item <?= $reportInno_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/report/new_report'; ?>">
                                    <span class="nav-link-text">Innovation Report</span>
                                </a>
                            </li>   -->
                            <li class="nav-item <?= $reportlist_active; ?>">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/report/old_innovations/1'; ?>">
                                    <span class="nav-link-text">Archives</span>
                                </a>
                            </li>                                                   
                        </ul>
                    </div>
                </nav>
            </div>
        <?php } else { ?>
            <div id="leftMenuLoad">
                <nav class="navbar navbar-expand-lg">
                    <div class="collapse navbar-collapse show" id="navbarCollapse">
                        <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
                            <li class="nav-item <?= $holiday_active; ?> <?= $work_type_active; ?> <?= $work_days_active; ?> <?= $work_setup_active; ?> <?= $working_days_active; ?> <?= $leave_type_active; ?>">
                                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems5" aria-controls="collapseSubItems5" aria-expanded="false"><i class="fas fa-calendar-alt"></i> Leave & Calendars</a>
                                <ul class="nav-second-level collapse <?= $holiday_menu; ?> <?= $work_type_menu; ?> <?= $work_days_menu; ?> <?= $work_setup_menu; ?> <?= $working_days_menu; ?> <?= $leave_type_menu; ?>" id="collapseSubItems5" data-parent="#navAccordion">
                                    <li class="nav-item <?= $holiday_active; ?>">
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/current_holiday_calendar'; ?>">
                                            <span class="nav-link-text">Holidays Details</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $work_setup_active; ?>" >
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/week_setup'; ?>">
                                            <span class="nav-link-text">Week Setup</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $working_days_active; ?>" >
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/working_days'; ?>">
                                            <span class="nav-link-text">Working Days</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $leave_type_active; ?>" >
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/leave_type'; ?>">
                                            <span class="nav-link-text">Leave Type</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item <?= $budget_active; ?>">
                                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems6" aria-controls="collapseSubItems6" aria-expanded="false"><i class="fas fa-gem"></i> Budget</a>
                                <ul class="nav-second-level  collapse <?= $budget_menu; ?> <?= $program_menu; ?> <?= $budget_head_menu; ?> <?= $line_menu; ?> <?= $additional_menu; ?> <?= $financial_menu; ?>" id="collapseSubItems6" data-parent="#navAccordion">
                                    <li class="nav-item <?= $balance_active; ?>">
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/master/balance_sheet'; ?>">
                                            <span class="nav-link-text">Balance Sheet</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $programme_active; ?>">
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/master/programme'; ?>">
                                            <span class="nav-link-text">Programme</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $budget_head_active; ?>">
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/master/budget_head'; ?>">
                                            <span class="nav-link-text">Budget Head</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $line_item_active; ?>">
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/master/line_item'; ?>">
                                            <span class="nav-link-text">Line Item</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $additional_info_active; ?>">
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/master/additional_info'; ?>">
                                            <span class="nav-link-text">Additional Info</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $financial_year_active; ?>">
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/master/financial_year'; ?>">
                                            <span class="nav-link-text">Financial Year</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item <?= $partner_active; ?> <?= $admin_master_active; ?> <?= $asset_setting_active; ?> <?= $books_setting_active; ?> <?= $log_setting_active; ?> <?= $inward_setting_active; ?> <?= $outward_setting_active; ?> <?= $job_active; ?> <?= $pay_grade_active; ?>">
                                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems2" aria-controls="collapseSubItems2" aria-expanded="false"><i class="fas fa-user-shield"></i> Admin Master</a>
                                <ul class="nav-second-level scrollsideMenu collapse <?= $partner_menu; ?> <?= $admin_master_menu; ?> <?= $job_menu; ?>" id="collapseSubItems2" data-parent="#navAccordion">


                                   <li class="nav-item <?= $submenuback; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/master/asset/general'; ?>">
                                        <span class="nav-link-text">Asset Inventory</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $submenubackmaster; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/master/vendor_master'; ?>">
                                        <span class="nav-link-text">Asset Master</span>
                                    </a>
                                </li>

                                <li class="nav-item <?= $books_setting_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/master/books_master'; ?>">
                                        <span class="nav-link-text">Books</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $log_setting_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/master/visitors_log'; ?>">
                                        <span class="nav-link-text">Visitor's Log</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $inward_setting_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/master/dispatch_inward'; ?>">
                                        <span class="nav-link-text">Dispatch Inward</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $outward_setting_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/master/dispatch_outward'; ?>">
                                        <span class="nav-link-text">Dispatch Outward</span>
                                    </a>
                                </li>                                    
                                <li class="nav-item <?= $job_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/job/lists'; ?>">
                                        <span class="nav-link-text">Job</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $pay_grade_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/master/pay_grade'; ?>">
                                        <span class="nav-link-text">Pay Grade</span>
                                    </a>
                                </li>
                                <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                    <li class="nav-item <?= $partner_active; ?>">
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/master/partners_list'; ?>">
                                            <span class="nav-link-text">Partners</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>

                        <li class="nav-item <?= $employee_active; ?> <?= $leave_active; ?> <?= $usersetup_active; ?> <?= $due_setting_active; ?>">
                            <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-user-cog"></i> Employee Master</a>
                            <ul class="nav-second-level collapse <?= $employee_menu; ?>  <?= $leave_menu; ?> <?= $due_setting_active; ?>" id="collapseSubItems4" data-parent="#navAccordion">
                                <li class="nav-item <?= $employee_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/user/lists/3'; ?>">
                                        <span class="nav-link-text">Employee Details</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $leave_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/leave_summary'; ?>">
                                        <span class="nav-link-text">Leave Allocation</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $usersetup_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_setup'; ?>">
                                        <span class="nav-link-text">User Setup</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $due_setting_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/master/nodue_certificate'; ?>">
                                        <span class="nav-link-text">No Due Certificate</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item <?= $incubation_master_active; ?> <?= $reason_setting_active; ?> <?= $donor_setting_active; ?> <?= $portfolio_settings_active; ?> <?= $mail_template_active; ?> <?= $master_settings_active; ?> <?= $stage_efficiency_active; ?> <?= $document_type_active; ?> <?= $meeting_type_active; ?>">
                            <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems3" aria-controls="collapseSubItems3" aria-expanded="false"><i class="fas fa-cogs"></i> Incubation Master</a>
                            <ul class="nav-second-level collapse scrollsideMenu <?= $incubation_master_menu; ?> <?= $master_setting_menu; ?>" id="collapseSubItems3" data-parent="#navAccordion">

                                <li class="nav-item <?= $incubation_master_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/sectors'; ?>">
                                        <span class="nav-link-text">Sector</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $reason_setting_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/reason'; ?>">
                                        <span class="nav-link-text">Reasons</span>
                                    </a>
                                </li>
                                <li class="nav-item <?= $donor_setting_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/donor_fit'; ?>">
                                        <span class="nav-link-text">Donor Fit</span>
                                    </a>
                                </li>
                                <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                    <li class="nav-item <?= $master_settings_active; ?>">
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/master_settings/source_type'; ?>">
                                            <span class="nav-link-text">Master Settings</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <li class="nav-item <?= $portfolio_settings_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/portfolio_settings/designation'; ?>">
                                        <span class="nav-link-text">Portfolio Settings</span>
                                    </a>
                                </li>
                                <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                    <li class="nav-item <?= $stage_efficiency_active; ?>">
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/stage_efficiency'; ?>">
                                            <span class="nav-link-text">Stage Efficiency</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                    <li class="nav-item <?= $document_type_active; ?>">
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/document_type'; ?>">
                                            <span class="nav-link-text">Document Type</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                    <li class="nav-item <?= $meeting_type_active; ?>">
                                        <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/meeting_type'; ?>">
                                            <span class="nav-link-text">Meeting Type</span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <li class="nav-item <?= $mail_template_active; ?>">
                                    <a class="nav-link" href="<?php echo base_url() . 'index.php/incubation_master/mail_template'; ?>">
                                        <span class="nav-link-text">Mail Template Master</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
    <?php } ?>

    <div class="footer-link">
        <p>copyright &copy; <?= date('Y'); ?> <a href="<?= site_url(); ?>">vitals.villgroapps.org</a>&nbsp;V2.0</a></p>
    </div>

