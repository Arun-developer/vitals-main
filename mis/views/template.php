<!DOCTYPE HTML>

<html lang="en">

    <head>

        <title><?php echo 'Villgro-MIS'; ?></title>

        <meta charset="utf-8">

        <?php
        $this->load->view('../includes');
        ?>

    </head>

    <body class="fluid">

        <?php
        $this->load->view('../header');
        ?>



        <div class="villgro-breadcrumb clearfix">
            <div class="row">
                <div class="col-md-12 col-12">



                    <?php if ($this->session->userdata('user_type') != 'incubatee' && $this->session->userdata('user_id') != '') { ?>

                        <ul>

                            <?php
                            if ($this->uri->segment('2') == 'partner_privilege' && $this->uri->segment('1') == 'login') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/master/'); ?>">
                                        Master <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Partner Privilege
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'dashboard' && $this->uri->segment('1') == 'detailed_diligence') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Detailed Diligence
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'company_team' && $this->uri->segment('1') == 'detailed_diligence') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('detailed_diligence/dashboard/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Company and Team
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'document_meeting' && $this->uri->segment('1') == 'detailed_diligence') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('detailed_diligence/dashboard/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Documents and Meetings
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'detailed_assessment' && $this->uri->segment('1') == 'detailed_diligence') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('detailed_diligence/dashboard/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Detailed Assessment
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'icon_menu') {
                                ?>

                                <li><a href="#" class="active">
                                        Home
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'new_innovation' && $this->uri->segment('3') == '') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Add an Innovation
                                    </a></li>

                                <?php
                            }
                            if ($this->uri->segment('2') == 'new_innovation' && $this->uri->segment('3') != '') {
                                ?>
                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('scouting/innovation_details/' . $this->uri->segment('3')); ?>">
                                        Incubation Application Form <i class="fa fa-angle-double-right"></i>
                                    </a></li>
                                <li><a href="#" class="active">
                                        Edit an Innovation
                                    </a></li>
                                <?php
                            }

                            if ($this->uri->segment('2') == 'inv_app_edit' && $this->uri->segment('3') != '') {
                                ?>
                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('scouting/innovation_details/' . $this->uri->segment('3')); ?>">
                                        Incubation Application Form <i class="fa fa-angle-double-right"></i>
                                    </a></li>
                                <li><a href="#" class="active">
                                        Edit an Innovation
                                    </a></li>
                                <?php
                            }

                            if ($this->uri->segment('2') == 'new_innovation_import') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('scouting/new_innovation'); ?>">
                                        Add an Innovation <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Import an Innovation
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'timesheet') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Time Sheet
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'requests') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Requests
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'approvals') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Approvals
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'mydeals') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        My Deals
                                    </a></li>

                                <?php
                            }

                            if (($this->uri->segment('1') == 'chart' && $this->uri->segment('2') == 'dashboardPieChart') || ($this->uri->segment('1') == 'chart' && $this->uri->segment('2') == 'stageSectorGraph') || ($this->uri->segment('1') == 'chart' && $this->uri->segment('2') == 'incharge_status') || ($this->uri->segment('1') == 'chart' && $this->uri->segment('2') == 'cityGraph')) {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Dashboard
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'changepass') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Change Passsword
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'portfolio') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Portfolio
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'reports') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Reports
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'resources') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Resources
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'master') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Master
                                    </a></li>

                                <?php
                            }
							

                            if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'admin_master') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/master'); ?>">
                                        Master <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Admin Master
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'login' && ($this->uri->segment('2') == 'manage_users' || $this->uri->segment('2') == 'manage_superadminusers')) {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/master'); ?>">
                                        Master <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Manage Users
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'assigned') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        My deals
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'all') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        All Deals
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'dealsScoreboard') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">
                                        All Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Report
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'assessment' && $this->uri->segment('1') == 'login') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Assessment
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'innovation_details' && $this->uri->segment('1') == 'scouting') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Incubation Application Form
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'eir_app_edit' && $this->uri->segment('1') == 'scouting') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('scouting/innovation_details/' . $this->uri->segment('3')); ?>">
                                        Incubation Application Form <i class="fa fa-angle-double-right"></i>
                                    </a></li>
                                <li> <a href="#" class="active">
                                        Edit
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'view_list' && $this->uri->segment('1') == 'assessment') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Preliminary Assessment
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'view_details' && $this->uri->segment('1') == 'assessment') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        View Assessment
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'form' && $this->uri->segment('1') == 'assessment') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Add Details
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'view' && $this->uri->segment('1') == 'grading') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Grading & Feedback
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'detailed_diligence' && $this->uri->segment('1') == 'login') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Detailed Diligence
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'invite_prescreen' && $this->uri->segment('1') == 'screening') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/detailed_diligence/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Invite to Diligence
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'editassessdoc' && $this->uri->segment('1') == 'screening') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/detailed_diligence/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('screening/assessform/' . $this->uri->segment('3') . 'm1/11'); ?>">
                                        Detailed Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('screening/showalldocuments/' . $this->uri->segment('3')); ?>">
                                        Assessment Documents <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Edit Assessment Document
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'nda_list' && $this->uri->segment('1') == 'screening') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/detailed_diligence/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        NDA Document
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'pre_ic' && $this->uri->segment('1') == 'screening') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/detailed_diligence/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        IC
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'assessform' || $this->uri->segment('2') == 'docverifyform' || $this->uri->segment('2') == 'peopleform' || $this->uri->segment('2') == 'peoplemeet' && $this->uri->segment('1') == 'screening') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/detailed_diligence/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Detailed Assessment
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'showalldocuments' && $this->uri->segment('1') == 'screening') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/detailed_diligence/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('screening/assessform/' . $this->uri->segment('3') . 'm1/11'); ?>">
                                        Detailed Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Assessment Documents
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'form' && $this->uri->segment('1') == 'screening') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/detailed_diligence/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Add Information
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'view_financial' && $this->uri->segment('1') == 'screening') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/detailed_diligence/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Add Information
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('3') == 'assigned_incubation' || $this->uri->segment('3') == 'incubation' && $this->uri->segment('1') == 'scouting') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        My Portfolio
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'myportfolio' && $this->uri->segment('1') == 'login') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        My Portfolio
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'view' && $this->uri->segment('1') == 'seedfunding') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Seed Funding
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'seedfunding' && $this->uri->segment('2') == 'monthly_progress') {
                                ?>
                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('seedfunding/view/' . $this->uri->segment('3') . ''); ?>">
                                        Seed Funding <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Monthly Target
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'getinstallment' && $this->uri->segment('1') == 'seedfunding') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('seedfunding/view/' . $this->uri->segment('3') . ''); ?>">
                                        Seed Funding <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Get Installment Amount
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'activities' && $this->uri->segment('1') == 'seedfunding') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Incubation Plan
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'view_list' && ($this->uri->segment('1') == 'boardmember' || $this->uri->segment('1') == 'boardmeeting')) {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Board Meeting
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('5') == 'view' && $this->uri->segment('2') == 'view' && $this->uri->segment('1') == 'boardmeeting') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('boardmember/view_list/' . $this->uri->segment('3')); ?>">
                                        Board Meeting <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        View Board Meeting
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('5') == 'edit' && $this->uri->segment('2') == 'view' && $this->uri->segment('1') == 'boardmeeting') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('boardmember/view_list/' . $this->uri->segment('3')); ?>">
                                        Board Meeting <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Edit Board Meeting
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'index' && $this->uri->segment('1') == 'activities') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Activities
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'view_list' && $this->uri->segment('1') == 'activities') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('activities/index/' . $this->uri->segment('3')); ?>">
                                        Activities <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        View Activities
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'add_activity' && $this->uri->segment('1') == 'activities') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('activities/index/' . $this->uri->segment('3')); ?>">
                                        Activities <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Add Activities
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'activity_details' && $this->uri->segment('1') == 'activities') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('activities/index/' . $this->uri->segment('3')); ?>">
                                        Activities <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Activity Details
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'fellows' && $this->uri->segment('1') == 'login') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Fellows
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'kra_report' && $this->uri->segment('3') == 'view_report') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('login/fellows/' . $this->uri->segment('4')); ?>">
                                        Fellows <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Add Progress
                                    </a></li>

                                <?php
                            }


                            if ($this->uri->segment('1') == 'reports' && $this->uri->segment('3') == 'view_incubateereport') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Dashboard Report of Incubatee
                                    </a></li>

                                <?php
                            }


                            if ($this->uri->segment('2') == 'kra_report' && $this->uri->segment('3') == 'list_report') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('login/fellows/' . $this->uri->segment('4')); ?>">
                                        Fellows <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        View Progress
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'portfolio_options' && $this->uri->segment('1') == 'login') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Portfolio Options
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'incubateeform' && $this->uri->segment('1') == 'screening') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('login/portfolio_options/' . $this->uri->segment(3) . ''); ?>">
                                        Portfolio Options <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                </li>

                                <li> <a href="#" class="active">
                                        Create Incubatee Password
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'scouting' && $this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'decision_pending') {
                                ?>
                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>
                                <li> <a href="#" class="active">
                                        Pending Deals
                                    </a></li>
                                <?php
                            }
                            if ($this->uri->segment('2') == 'options' && $this->uri->segment('1') == 'login') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Options
                                    </a></li>

                                <?php
                            }

                            if (($this->uri->segment('2') == 'mail' && $this->uri->segment('1') == 'common' && $this->uri->segment('3') != 'form' || $this->uri->segment('3') == 'add_ext_mail')) {
                                if (isset($_SERVER['HTTP_REFERER'])) {

                                    if (strpos($_SERVER['HTTP_REFERER'], 'portfolio_options')) {
                                        ?>

                                        <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                                Home <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                                Portfolio <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                                My Portfolio <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li><a href="<?= site_url('login/portfolio_options/' . $this->uri->segment('4')); ?>">
                                                Portfolio Options <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li><a href="#" class="active">
                                                Mail History
                                            </a></li>

                                    <?php } else if ((strpos($_SERVER['HTTP_REFERER'], 'options')) || (strpos($_SERVER['HTTP_REFERER'], 'mail'))) { ?>

                                        <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                                Home <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                                Deals <i class="fa fa-angle-double-right"></i>
                                            </a></li>
                                        <?php
                                        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
                                            ?>
                                            <li><a href="<?= site_url('scouting/innovation_pool/all'); ?>">
                                                    All Deals <i class="fa fa-angle-double-right"></i>
                                                </a></li>
                                            <?php
                                        } else {
                                            ?>
                                            <li><a href="<?= site_url('scouting/innovation_pool/assigned'); ?>">
                                                    My Deals <i class="fa fa-angle-double-right"></i>
                                                </a></li>
                                            <?php
                                        }
                                        ?>

                                        <li><a href="<?= site_url('login/options/' . $this->uri->segment('4')); ?>">
                                                Options <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li><a href="#" class="active">
                                                Mail History
                                            </a></li>

                                        <?php
                                    }
                                } else {
                                    ?>
                                    <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                            Home <i class="fa fa-angle-double-right"></i>
                                        </a></li>

                                    <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                            Deals <i class="fa fa-angle-double-right"></i>
                                        </a></li>

                                    <?php
                                    if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
                                        ?>
                                        <li><a href="<?= site_url('scouting/innovation_pool/all'); ?>">
                                                All Deals <i class="fa fa-angle-double-right"></i>
                                            </a></li>
                                        <?php
                                    } else {
                                        ?>
                                        <li><a href="<?= site_url('scouting/innovation_pool/assigned'); ?>">
                                                My Deals <i class="fa fa-angle-double-right"></i>
                                            </a></li>
                                        <?php
                                    }
                                    ?>

                                    <li><a href="<?= site_url('login/options/' . $this->uri->segment('4')); ?>">
                                            Options <i class="fa fa-angle-double-right"></i>
                                        </a></li>

                                    <li><a href="#" class="active">
                                            Mail History
                                        </a></li>
                                    <?php
                                }
                            }
                            if (($this->uri->segment('1') == 'common' && $this->uri->segment('2') == 'mail' && $this->uri->segment('3') == 'form')) {
                                if (isset($_SERVER['HTTP_REFERER'])) {

                                    if (strpos($_SERVER['HTTP_REFERER'], 'portfolio_options')) {
                                        ?>

                                        <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                                Home <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                                Portfolio <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                                My Portfolio <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li><a href="<?= site_url('login/portfolio_options/' . $this->uri->segment('4')); ?>">
                                                Portfolio Options <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li><a href="#" class="active">
                                                Mail History
                                            </a></li>

                                    <?php } else if (strpos($_SERVER['HTTP_REFERER'], 'options')) { ?>

                                        <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                                Home <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                                Deals <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <?php
                                        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
                                            ?>
                                            <li><a href="<?= site_url('scouting/innovation_pool/all'); ?>">
                                                    All Deals <i class="fa fa-angle-double-right"></i>
                                                </a></li>
                                            <?php
                                        } else {
                                            ?>
                                            <li><a href="<?= site_url('scouting/innovation_pool/assigned'); ?>">
                                                    My Deals <i class="fa fa-angle-double-right"></i>
                                                </a></li>
                                            <?php
                                        }
                                        ?>

                                        <li><a href="<?= site_url('login/options/' . $this->uri->segment('4')); ?>">
                                                Options <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li><a href="#" class="active">
                                                Mail History
                                            </a></li>

                                        <?php
                                    }
                                } else {
                                    ?>
                                    <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                            Home <i class="fa fa-angle-double-right"></i>
                                        </a></li>

                                    <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                            Deals <i class="fa fa-angle-double-right"></i>
                                        </a></li>

                                    <?php
                                    if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
                                        ?>
                                        <li><a href="<?= site_url('scouting/innovation_pool/all'); ?>">
                                                All Deals <i class="fa fa-angle-double-right"></i>
                                            </a></li>
                                        <?php
                                    } else {
                                        ?>
                                        <li><a href="<?= site_url('scouting/innovation_pool/assigned'); ?>">
                                                My Deals <i class="fa fa-angle-double-right"></i>
                                            </a></li>
                                        <?php
                                    }
                                    ?>

                                    <li><a href="<?= site_url('login/options/' . $this->uri->segment('4')); ?>">
                                            Options <i class="fa fa-angle-double-right"></i>
                                        </a></li>

                                    <li><a href="#" class="active">
                                            Mail History
                                        </a></li>
                                    <?php
                                }
                            }

                            if ($this->uri->segment('2') == 'alldocument' && $this->uri->segment('1') == 'common') {

                                if (isset($_SERVER['HTTP_REFERER'])) {

                                    if (strpos($_SERVER['HTTP_REFERER'], 'portfolio_options')) {
                                        ?>

                                        <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                                Home <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                                Portfolio <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                                My Portfolio <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li><a href="<?= site_url('login/portfolio_options/' . $this->uri->segment('4')); ?>">
                                                Portfolio Options <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li><a href="#" class="active">
                                                All Documents
                                            </a></li>

                                    <?php } else if (strpos($_SERVER['HTTP_REFERER'], 'options')) { ?>

                                        <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                                Home <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                                Deals <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <?php
                                        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
                                            ?>
                                            <li><a href="<?= site_url('scouting/innovation_pool/all'); ?>">
                                                    All Deals <i class="fa fa-angle-double-right"></i>
                                                </a></li>
                                            <?php
                                        } else {
                                            ?>
                                            <li><a href="<?= site_url('scouting/innovation_pool/assigned'); ?>">
                                                    My Deals <i class="fa fa-angle-double-right"></i>
                                                </a></li>
                                            <?php
                                        }
                                        ?>

                                        <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('4')); ?>">
                                                Assessment <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li><a href="<?= site_url('login/options/' . $this->uri->segment('4')); ?>">
                                                Options <i class="fa fa-angle-double-right"></i>
                                            </a></li>

                                        <li><a href="#" class="active">
                                                All Documents
                                            </a></li>

                                        <?php
                                    }
                                }
                            }



                            if ($this->uri->segment('2') == 'exitdetails' && $this->uri->segment('1') == 'exit_details') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('login/portfolio_options/' . $this->uri->segment('4')); ?>">
                                        Portfolio Options <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Exit Details
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'old_innovation' || $this->uri->segment('2') == 'old_innovations' || $this->uri->segment('2') == 'oldinnovation' && $this->uri->segment('1') == 'scouting') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/portfolio/'); ?>">
                                        Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">
                                        My Portfolio <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('login/portfolio_options/' . $this->uri->segment('4')); ?>">
                                        Portfolio Options <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Innovation Reports
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('3') == 'new_report' || $this->uri->segment('3') == 'innovations_report_totaldeals' || $this->uri->segment('3') == 'innovations_report_entryclosed' || $this->uri->segment('3') == 'innovations_report' || $this->uri->segment('3') == 'innovations_report_identifiedBy' || $this->uri->segment('3') == 'innovations_report_followUp' || $this->uri->segment('3') == 'innovations_report_DecisionPending' && $this->uri->segment('1') == 'common' && $this->uri->segment('2') == 'report') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/reports/'); ?>">
                                        Reports <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Innovations Report
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'ic_confirm' && $this->uri->segment('1') == 'screening') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/detailed_diligence/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        IC
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'screening' && $this->uri->segment('2') == 'agreement') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/detailed_diligence/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Agreement
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('1') == 'screening' && $this->uri->segment('2') == 'documents') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals/'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/detailed_diligence/' . $this->uri->segment('3')); ?>">
                                        Detailed Diligence <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Document Check List
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'leaves' && $this->uri->segment('1') == 'login') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/approvals/'); ?>">
                                        Approve <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Leave
                                    </a></li>

                                <?php
                            }

                            if ($this->uri->segment('2') == 'master_settings' || $this->uri->segment('1') == 'master') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/') ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/master/'); ?>">
                                        Masters <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Incubation Master
                                    </a></li>

                            <?php } ?>
                            <?php if ($this->uri->segment('1') == 'scouting' && $this->uri->segment('2') == 'seed_app_edit') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('scouting/innovation_details/' . $this->uri->segment('3')); ?>">
                                        Incubation Application Form <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        SEED Application Edit
                                    </a></li>

                            <?php } ?>
                            <?php if ($this->uri->segment('1') == 'scouting' && $this->uri->segment('2') == 'pitch_app_edit') {
                                ?>

                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a
                                        href="<?= site_url('scouting/innovation_details/' . substr($this->uri->segment('3'), 3)); ?>">
                                        Incubation Application Form <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Pitch Application Edit
                                    </a></li>

                            <?php } ?>
                            <?php
                            if ($this->uri->segment('1') == "assessment" && $this->uri->segment('2') == 'assess_summary' && $this->uri->segment('3') != '') {
                                ?>
                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/mydeals'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">
                                        Assessment <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Assessment Summary
                                    </a></li>
                                <?php
                            }
                            ?>
                            <?php
                            if ($this->uri->segment('1') == "close" && $this->uri->segment('2') == 'rejection') {
                                ?>
                                <li> <a href="<?= site_url('login/icon_menu/'); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">
                                        Deals <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Deals Bulk Close
                                    </a></li>


                                <?php
                            }
                            ?>

                        </ul>

                    <?php } else { ?>

                        <ul class="breadcrumb">

                            <?php if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'incubatee' && $this->uri->segment('3') == 'incubatee_menu') {
                                ?>

                                <li> <a href="#" class="active">
                                        Home
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'incubator_metrics' && $this->uri->segment('2') == 'wglobal_report' && $this->uri->segment('3') == 'dashboard') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('4')); ?>">
                                        Home
                                    </a></li>

                                <li> <a href="#">
                                        Home
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'incubatee' && $this->uri->segment('3') == 'company_info') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('4')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Company Info
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'scouting' && $this->uri->segment('2') == 'innovation_details') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('3')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('login/incubatee/company_info/' . $this->uri->segment('3')); ?>">
                                        Company Info <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Innovation Details
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'presentation' && $this->uri->segment('2') == 'view') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('3')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('login/incubatee/company_info/' . $this->uri->segment('3')); ?>">
                                        Company Info <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Presentation
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'screening' && $this->uri->segment('2') == 'form' || $this->uri->segment('2') == 'agreement' || $this->uri->segment('2') == 'documents' || $this->uri->segment('2') == 'getCompanyDetails') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('3')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('login/incubatee/company_info/' . $this->uri->segment('3')); ?>">
                                        Company Info <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Detailed Info
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'common' && $this->uri->segment('2') == 'alldocument' && $this->uri->segment('2') == 'view_list') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('4')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('login/incubatee/company_info/' . $this->uri->segment('4')); ?>">
                                        Company Info <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        View Documents
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'incubatee' && $this->uri->segment('3') == 'villgro_service') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('4')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Villgro Service's
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'seedfunding' && $this->uri->segment('2') == 'view') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('3')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/incubatee/villgro_service/' . $this->uri->segment('3')); ?>">
                                        Villgro Service's <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Seed Funding
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'seedfunding' && $this->uri->segment('2') == 'getinstallment') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('3')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/incubatee/villgro_service/' . $this->uri->segment('3')); ?>">
                                        Villgro Service's <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('seedfunding/view/' . $this->uri->segment('3')); ?>">
                                        Seed Funding <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Get Installment
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'boardmeeting' && $this->uri->segment('2') == 'view' && $this->uri->segment('5') == 'view') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('3')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/incubatee/villgro_service/' . $this->uri->segment('3')); ?>">
                                        Villgro Service's <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('boardmeeting/view_list/' . $this->uri->segment('3')); ?>">
                                        Board Meeting <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        View Board Meeting
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'boardmeeting' && $this->uri->segment('2') == 'view_list') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('3')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/incubatee/villgro_service/' . $this->uri->segment('3')); ?>">
                                        Villgro Service's <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('boardmeeting/view_list/' . $this->uri->segment('3')); ?>">
                                        Board Meeting <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        View Board Meeting
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'boardmeeting' && $this->uri->segment('2') == 'view' && $this->uri->segment('5') == 'edit') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('3')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/incubatee/villgro_service/' . $this->uri->segment('3')); ?>">
                                        Villgro Service's <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('boardmeeting/view_list/' . $this->uri->segment('3')); ?>">
                                        Board Meeting <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Edit Board Meeting
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'activities' && $this->uri->segment('2') == 'index') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('3')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/incubatee/villgro_service/' . $this->uri->segment('3')); ?>">
                                        Villgro Service's <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Activity
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'activities' && $this->uri->segment('2') == 'view_list') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('3')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/incubatee/villgro_service/' . $this->uri->segment('3')); ?>">
                                        Villgro Service's <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('activities/index/' . $this->uri->segment('3')); ?>">
                                        Activity <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        View Activity
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'activities' && $this->uri->segment('2') == 'add_activity') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('3')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/incubatee/villgro_service/' . $this->uri->segment('3')); ?>">
                                        Villgro Service's <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="<?= site_url('activities/index/' . $this->uri->segment('3')); ?>">
                                        Activity <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li><a href="#" class="active">
                                        Add Activity
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'incubatee' && $this->uri->segment('3') == 'report_villgro') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('4')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Report to Villgro
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'incubationprogress' && $this->uri->segment('2') == 'form') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('3')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/incubatee/report_villgro/' . $this->uri->segment('3')); ?>">
                                        Report Villgro <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Metrics Information
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'reports' && $this->uri->segment('2') == 'incubation_report') { ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('4')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/incubatee/report_villgro/' . $this->uri->segment('4')); ?>">
                                        Report Villgro <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Incubation Monthly Report
                                    </a></li>

                            <?php } ?>

                            <?php if ($this->uri->segment('1') == 'seedfunding' && $this->uri->segment('2') == 'monthly_progress') {
                                ?>

                                <li> <a href="<?= site_url('login/incubatee/incubatee_menu/' . $this->uri->segment('3')); ?>">
                                        Home <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="<?= site_url('login/incubatee/report_villgro/' . $this->uri->segment('3')); ?>">
                                        Report Villgro <i class="fa fa-angle-double-right"></i>
                                    </a></li>

                                <li> <a href="#" class="active">
                                        Monthly Target / Achieved
                                    </a></li>

                            <?php } ?>

                        </ul>

                        <br />

                        <?php
                    }
                    ?>



                </div>
            </div>
        </div>


    </div>





    <section id="content">

        <section class="container_12 clearfix">

            <?php if (($this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'assigned') || ($this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'all')) { ?>
                <section id="main" class="grid_12">
                <?php } else { ?>
                    <section id="main" class="grid_9 push_3">
                    <?php } ?>

                    <div>

                        <?php $this->load->view('../message'); ?>



                        <?php
                        if ($this->uri->segment('1') == 'master' && ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin')) {

                            $this->load->view('master/left_menu');
                        }

                        $this->load->view($cpage);
                        ?>

                    </div>

                </section>

            </section>

        </section>

        <?php $this->load->view('../footer'); ?>

    </div>

</div>

</body>


</html>