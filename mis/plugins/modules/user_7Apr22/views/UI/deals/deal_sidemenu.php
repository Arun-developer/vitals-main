<style type="text/css">
    .sidebar_show {
        display: block !important;
    }
</style>

<?php
$employee_active = $holiday_active = '';
$employee_menu = $holiday_menu = '';

if ($page == 'deals') {
    $deals_active = 'active';
    $deals_menu = 'show';
} else if ($page == 'pre_assitant') {
    $pre_assitant_active = 'active';
    $pre_assitant_menu = 'show';
} else if ($page == 'mail_history') {
    $mail_history_active = 'active';
    $mail_history_menu = 'show';
} else if ($page == 'view_document') {
    $view_document_active = 'active';
    $view_document_menu = 'show';
} else if ($page == 'summary') {
    $summary_active = 'active';
    $summary_menu = 'show';
} else if ($page == 'company_team') {
    $company_team_active = 'active';
    $company_team_menu = 'show';
} else if ($page == 'document_meetings') {
    $document_meetings_active = 'active';
    $document_meetings_menu = 'show';
} else if ($page == 'detailed_asessment') {
    $detailed_asessment_active = 'active';
    $detailed_asessment_menu = 'show';
}
?>
<nav class="navbar navbar-expand-lg ">
    <div class="collapse navbar-collapse show" id="navbarCollapse">
        <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
            <li class="nav-item <?= $deals_active; ?>" >
                <a class="nav-link nav-link-collapse" href="<?php echo base_url() . 'index.php/user/user_ui/deals'; ?>" ><span><i class="far fa-file-alt"></i></span> Incubation Application Form</a>                
            </li>
            <li class="nav-item <?= $pre_assitant_active; ?>" >
                <a class="nav-link nav-link-collapse" href="<?php echo base_url() . 'index.php/user/user_ui/deals_pre_assitant'; ?>"><span><i class="far fa-copy"></i></span> Preliminary Assessment</a>                
            </li>
            <li class="nav-item <?= $summary_active; ?> <?= $company_team_active; ?> <?= $document_meetings_active; ?> <?= $detailed_asessment_active; ?>">
                <a class="nav-link nav-link-collapse" href="#" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems5" aria-controls="collapseSubItems5" aria-expanded="false"><i class="fas fa-user-friends"></i> Detailed Diligence</a>
                <ul class="nav-second-level collapse <?= $summary_menu; ?> <?= $company_team_menu; ?> <?= $document_meetings_menu; ?> <?= $detailed_asessment_menu; ?>" id="collapseSubItems5" data-parent="#navAccordion">
                    <li class="nav-item  <?= $summary_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/detailed_diligence_summary'; ?>">
                            <span class="nav-link-text">Summary</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $company_team_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/detailed_company_team'; ?>">
                            <span class="nav-link-text">Company and Team</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $document_meetings_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/detailed_document_meeting'; ?>">
                            <span class="nav-link-text">Documents and Meetings</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $detailed_asessment_active; ?>">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/detailed_asessment'; ?>">
                            <span class="nav-link-text"> Detailed Assessment</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?= $mail_history_active; ?>" >
                <a class="nav-link nav-link-collapse" href="<?php echo base_url() . 'index.php/user/user_ui/deals_all_mails'; ?>"><span></span><i class="far fa-envelope"></i></span> Mail History</a>                
            </li>
            <li class="nav-item <?= $view_document_active; ?>" >
                <a class="nav-link nav-link-collapse" href="<?php echo base_url() . 'index.php/user/user_ui/deals_all_doc'; ?>"><span><i class="far fa-eye"></i></span> View Documents</a>                
            </li>            
        </ul>
    </div>
</nav>
<style>
    .sidebar-dropdown.active .sidebar-submenu {
        display: block !important;
    }
</style>