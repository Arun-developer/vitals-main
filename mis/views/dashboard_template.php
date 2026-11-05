<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $cpagetitle; ?></title>
<meta charset="utf-8">
<?php $this->load->view('../includes'); ?>
</head>
<body class="fluid">
<?php $this->load->view('../header'); ?>


<div class="villgro-breadcrumb clearfix">
      <div class="row">
      <div class="col-md-12 col-12">


      <ul>
        <?php
          if($this->uri->segment('2') == 'exitdetails' && $this->uri->segment('1') == 'exit_details')
          {
          ?>
          <li> <a href="<?=site_url('login/icon_menu/')?>">Home <i class="fa fa-angle-double-right"></i></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>">Portfolio <i class="fa fa-angle-double-right"></i></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>">My Portfolio <i class="fa fa-angle-double-right"></i></a></li>

          <li><a href="<?=site_url('login/portfolio_options/'.$this->uri->segment('4'));?>">Portfolio Options <i class="fa fa-angle-double-right"></i></a></li>

          <li><a href="#" class="active">Exit Details </a></li>

          <?php }
        if ($this->uri->segment('2') == 'dashboard' && $this->uri->segment('3') == 'admin') { ?>
        <li> <a href="#" class="active">Dashboard</a></li>
        <?php } ?>
        <?php if ($this->uri->segment('2') == 'getCompanyDetails' || $this->uri->segment('2') == 'getcompany' || $this->uri->segment('2') == 'view_financial' && $this->uri->segment('1') == 'screening') { ?>
        <li> <a href="<?= site_url('login/icon_menu/') ?>">Home <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('login/mydeals/'); ?>">Deals <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('login/assessment/' . $this->uri->segment('3')); ?>">Assessment <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('login/detailed_diligence/' . $this->uri->segment('3')); ?>">Detailed Diligence <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Add Information</a></li>
        <?php } ?>
        <?php if ($this->uri->segment('2') == 'view_incubateereport' && $this->uri->segment('1') == 'incubation_report') { ?>
        <li> <a href="<?= site_url('login/icon_menu/') ?>">Home <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('login/portfolio/'); ?>">Portfolio <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('login/myportfolio/' . $this->uri->segment('3')); ?>">My Portfolio <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Dashboard Report of Incubatee </a></li>
        <?php } ?>
        <?php if ($this->uri->segment('2') == 'alldocument' && $this->uri->segment('1') == 'common') { ?>
        <li> <a href="<?= site_url('login/icon_menu/') ?>">Home <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Documents </a></li>
        <?php } ?>
        <?php if (($this->uri->segment('2') == 'dashboard') && ($this->uri->segment('3') == 'admin_dashboard')) { ?>
        <li> <a href="<?=site_url('login/icon_menu');?>">Home<i class="fa fa-angle-double-right"></i></a></li>
                <li> <a href="<?=site_url('login/reports');?>">Reports<i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('common/dashboard/admin_dashboard'); ?>">Incubation Dashboard</a></li>
        <?php } 
         if(($this->uri->segment('1') == 'dashboard') && ($this->uri->segment('2') == 'hrisdashboard'))
          { ?>
            <li> <a href="<?=site_url('login/icon_menu/')?>">Home <i class="fa fa-angle-double-right"></i></a></li><li> <a href="<?=site_url('login/reports/');?>">Reports <i class="fa fa-angle-double-right"></i></a></li><li> <a href="#" class="active">HR Dashboard</a></li>
          <?php }

        if ($this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'all') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations</a></li>
        <?php } if ($this->uri->segment('1') == 'master') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">Main Masters <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('master/user_setup'); ?>">Masters</a></li>
        <?php } if ($this->uri->segment('2') == 'new_innovation') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/new_innovation'); ?>">New Innovation</a></li>
        <?php } if ($this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'assigned') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/assigned'); ?>">Assigned Innovation</a></li>
        <?php } if ($this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'identified') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/identified'); ?>">Identified Innovation</a></li>
        <?php } if ($this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'lead') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/lead'); ?>">Lead Innovation</a></li>
        <?php } if ($this->uri->segment('3') == 'innovation_report') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('common/report/innovation_report'); ?>">Innovation Report</a></li>
        <?php } if ($this->uri->segment('1') == 'seedfunding' && $this->uri->segment('2') == 'sfactivities') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Seedfunding</a></li>
        <?php } if ($this->uri->segment('1') == 'boardmember') { ?>
        <li> <a href="<?= site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3')) ?>">Home <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('login/incubatee/villgro_service/'.$this->uri->segment('3')); ?>">Villgro Services <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Board Meeting</a></li>
        <?php } if ($this->uri->segment('1') == 'invester') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Raise Investment</a></li>
        <?php } if ($this->uri->segment('1') == 'mentor') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Mentor</a></li>
        <?php } if ($this->uri->segment('1') == 'media') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Media</a></li>
        <?php } if ($this->uri->segment('1') == 'fellow') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Fellow</a></li>
        <?php } if ($this->uri->segment('1') == 'applicant') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Access To Naukri</a></li>
        <?php } if ($this->uri->segment('1') == 'training') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Peer to Peer Learning</a></li>
        <?php } if ($this->uri->segment('1') == 'trainings') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Training</a></li>
        <?php } if ($this->uri->segment('1') == 'incubationprogress') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Incubation Progress</a></li>
        <?php } if ($this->uri->segment('1') == 'assign_incubation') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Assign Metrics Incubation</a></li>
        <?php }  if ($this->uri->segment('1') == 'assessment') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Assessment</a></li>
        <?php } if ($this->uri->segment('1') == 'presentation') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Presentation</a></li>
        <?php } if ($this->uri->segment('1') == 'screening' && $this->uri->segment('2') == 'form') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="#" class="active">Detailed Diligence</a></li>
        <?php } if ($this->uri->segment('1') == 'screening' && $this->uri->segment('2') == 'invite_prescreen') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('screening/form/' . $this->uri->segment('3')); ?>">Detailed Diligence /</a></li>
        <li> <a href="#" class="active">Invite Pre Screen</a></li>
        <?php } if ($this->uri->segment('1') == 'screening' && $this->uri->segment('2') == 'nda_list') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('screening/form/' . $this->uri->segment('3')); ?>">Detailed Diligence /</a></li>
        <li> <a href="#" class="active">NDA Document List</a></li>
        <?php } if ($this->uri->segment('1') == 'screening' && $this->uri->segment('2') == 'assessform') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('screening/form/' . $this->uri->segment('3')); ?>">Detailed Diligence /</a></li>
        <li> <a href="#" class="active">Assess Form</a></li>
        <?php } if ($this->uri->segment('1') == 'screening' && $this->uri->segment('2') == 'view_peoplelist') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('screening/form/' . $this->uri->segment('3')); ?>">Detailed Diligence /</a></li>
        <li> <a href="#" class="active">Site Visit Schedule</a></li>
        <?php } if ($this->uri->segment('1') == 'screening' && $this->uri->segment('2') == 'peopleform') { ?>
        <li> <a href="<?= site_url('scouting/innvovation_pool/all') ?>">innovation_pool <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations <i class="fa fa-angle-double-right"></i></a></li>
        <li> <a href="<?= site_url('screening/form/' . $this->uri->segment('3')); ?>">Detailed Diligence /</a></li>
        <li> <a href="#" class="active">Add Site Visit Schedule</a></li>
        <?php } if ($this->uri->segment('1') == 'dashboard' && $this->uri->segment('2') == 'dashboard') { ?>
        <li> <a href="<?= site_url('login/icon_menu/') ?>">Home <i class="fa fa-angle-double-right"></i></a></li>
        <li><a href="<?= site_url('login/reports/'); ?>">Report <i class="fa fa-angle-double-right"></i></a></li>
        <li><a href="#" class="active">Deal Flow </a></li>
        <?php } if ($this->uri->segment('2') == 'old_innovation' || $this->uri->segment('2') == 'old_innovations' || $this->uri->segment('2') == 'oldinnovation' && $this->uri->segment('1') == 'scouting') { ?>
        <li> <a href="<?= site_url('login/icon_menu/') ?>">Home <i class="fa fa-angle-double-right"></i></a></li>
        <li><a href="<?= site_url('login/reports/'); ?>">Report <i class="fa fa-angle-double-right"></i></a></li>
        <li><a href="#" class="active">Innovation Archives </a></li>
        <?php } if ($this->uri->segment('1') == 'dms' && $this->uri->segment('2') == 'document_system') { ?>
        <li> <a href="#" class="active">Document Managment System </a></li>
        <?php }
        if ($this->uri->segment('1') == 'reports' && $this->uri->segment('2') == 'incubation_report' && $this->uri->segment('3') == 'view_incubateereport') { ?>
        <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('4'));?>">Home</a></li><li> <a href="#" class="active">Report Villgro</a></li><li> <a href="#" class="active">View Incubation Monthly Report</a></li>
        <?php }
        if($this->uri->segment('2') == 'showalldocuments' && $this->uri->segment('1') == 'screening')
                {
                ?>
                        <li> <a href="<?=site_url('login/icon_menu/')?>">Home <i class="fa fa-angle-double-right"></i></a></li><li> <a href="<?=site_url('login/mydeals/');?>">Deals <i class="fa fa-angle-double-right"></i></a></li><li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>">Assessment <i class="fa fa-angle-double-right"></i></a></li><li> <a href="<?=site_url('login/detailed_diligence/'.$this->uri->segment('3'));?>">Detailed Diligence <i class="fa fa-angle-double-right"></i></a></li><li> <a href="<?=site_url('screening/assessform/'.$this->uri->segment('3').'/m1/11');?>">Detailed Assessment <i class="fa fa-angle-double-right"></i></a></li><li> <a href="#" class="active">Assessment Documents </a></li>
                <?php }
        if ($this->uri->segment('1') == 'incubator_metrics' && $this->uri->segment('2') == 'wglobal_report' && $this->uri->segment('3') == 'dashboard') { ?>
        <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('4'));?>">Home</a></li><li> <a href="#" class="active">Dashboard</a></li>
        <?php }

          if($this->uri->segment('1') == 'reports' && $this->uri->segment('2') == 'incubation_report' && $this->uri->segment('3') == 'index')
                {
                  if(strpos($_SERVER['HTTP_REFERER'],'seedfunding') || $this->session->userdata('user_type') !='incubatee'){
               ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>">Home <i class="fa fa-angle-double-right"></i></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>">Portfolio <i class="fa fa-angle-double-right"></i></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>">My Portfolio <i class="fa fa-angle-double-right"></i></a></li>
          <li><a href="<?=site_url('seedfunding/view/'.$this->uri->segment('4'));?>">Seed Funding</a></li>
                    
          <li><a href="<?=site_url('seedfunding/monthly_progress/'.$this->uri->segment('4'));?>">Monthly Target</a></li>
          <li><a href="#" class="active">Monthly Achived</a></li>
             <?php } 
               else
                {
                    ?>
           <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('4'))?>">Home <i class="fa fa-angle-double-right"></i></a></li>
           <li> <a href="<?=site_url('login/incubatee/report_villgro/'.$this->uri->segment('4'));?>">Report Villgro <i class="fa fa-angle-double-right"></i></a></li>
           <li> <a href="<?=site_url('seedfunding/monthly_progress/'.$this->uri->segment('4'));?>">Monthly Target / Achieved <i class="fa fa-angle-double-right"></i></a></li>
             <li> <a href="#" class="active">Monthly Target List</a></li>
        <?php } }
        ?>
      </ul>

    </div>
    </div>
    </div>


    </div>


<section id="content">
  <section class="container_12 clearfix">
    <article id="<?php echo $cpage; ?>" >
      <?php $this->load->view('../message'); ?>

      <br/>
      <?php $this->load->view($cpage); ?>
    </article>
    <?php $this->load->view('../left'); ?>
  </section>
</section>
<?php $this->load->view('../footer'); ?>
</body>
</html>
