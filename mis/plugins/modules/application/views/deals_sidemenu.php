<style type="text/css">
    .sidebar_show {
        display: block !important;
    }
</style>
<?php
if ($page == 'deals') {
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
}
?>
<nav class="navbar navbar-expand-lg ">
    <div class="collapse navbar-collapse show" id="navbarCollapse">
        <ul class="navbar-nav mr-auto vitalMastersidenav" id="navAccordion">
            <li class="nav-item <?= $deals_active; ?>" >
                <a class="nav-link nav-link-collapse" href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>" ><span><i class="far fa-file-alt"></i></span> Application Form</a>
            </li>
            <li class="nav-item <?= $pre_assitant_active; ?>" >
                <a class="nav-link nav-link-collapse" href="<?php echo base_url() . 'index.php/application/assessment_summary/' . $application_id; ?>"><span><i class="far fa-copy"></i></span> Preliminary Assessment</a>
            </li>
            <li class="nav-item <?= $diligence_summary_active; ?> <?= $diligence_company_active; ?> <?= $diligence_document_active; ?> <?= $diligence_detail_active; ?>">
                <a class="nav-link nav-link-collapse" href="void:javascript(0);" id="hasSubItems" data-toggle="collapse" data-target="#collapseSubItems4" aria-controls="collapseSubItems4" aria-expanded="false"><i class="fas fa-book-open"></i> Detailed Diligence</a>
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
            <li class="nav-item <?= $mail_history_active; ?>" >
                <a class="nav-link" href="<?php echo base_url() . 'index.php/application/mail_history/' . $application_id; ?>"><span></span><i class="far fa-envelope"></i></span> Mail History</a>
            </li>
            <li class="nav-item <?= $view_document_active; ?>" >
                <a class="nav-link" href="<?php echo base_url() . 'index.php/application/view_documents/' . $application_id; ?>"><span><i class="far fa-eye"></i></span> View Documents</a>
            </li>
        </ul>

    </div>
</nav>
<style>
    .sidebar-dropdown.active .sidebar-submenu {
        display: block !important;
    }
</style>