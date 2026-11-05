<!DOCTYPE HTML>

<html lang="en">

<head>

<title><?php echo $cpagetitle;?></title>

<meta charset="utf-8">

</head>

<body class="fluid">

<section id="content">

  <section class="container_12 clearfix">

    <section id="main" class="grid_9 push_3">

      <div >

        <?php  $this->load->view('../message'); ?>

        <?php if($this->session->userdata('user_type') != 'incubatee' && $this->session->userdata('user_id') != ''){?>

        <ul class="breadcrumb">

          <?php if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'icon_menu')

                {?>

          <li><a href="#"><font color="#000000"><b>Home</b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'new_innovation' && $this->uri->segment('3') =='')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('scouting/new_innovation');?>"><font color="#000000"><b>Add an Innovation</b></font></a></li>

          <?php }
                if($this->uri->segment('2') =='new_innovation' && $this->uri->segment('3') != '')
          {
            ?>
             <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

            <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

            <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

            <li> <a href="<?=site_url('scouting/innovation_details/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Incubation Application Form >></b></font></a></li>
            <li><a href="#"><font color="#000000"><b>Edit an Innovation</b></font></a></li>
            <?php
          }

            if($this->uri->segment('2') =='inv_app_edit' && $this->uri->segment('3') != '')
          {
            ?>
             <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

            <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

            <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

            <li> <a href="<?=site_url('scouting/innovation_details/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Incubation Application Form >></b></font></a></li>
            <li><a href="#"><font color="#000000"><b>Edit an Innovation</b></font></a></li>
            <?php
          }

		if($this->uri->segment('2') == 'new_innovation_import')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('scouting/new_innovation');?>"><font color="#000000"><b>Add an Innovation</b></font></a></li>

	<li> <a href="#"><font color="#000000"><b>Import an Innovation</b></font></a></li>	

          <?php } 

                if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'timesheet')

                {?>

          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/timesheet');?>"><font color="#000000"><b>Time Sheet</b></font></a></li>

          <?php }  

                if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'requests')

                {?>

          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/requests');?>"><font color="#000000"><b>Requests</b></font></a></li>

          <?php }  

                if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'approvals')

                {?>

          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/approvals');?>"><font color="#000000"><b>Approvals</b></font></a></li>

          <?php } 

                if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'mydeals')

                {?>

          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals');?>"><font color="#000000"><b>My Deals</b></font></a></li>

          <?php } 

				if($this->uri->segment('1') == 'changepass')

                {?>

          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('changepass/');?>"><font color="#000000"><b>Change Passsword</b></font></a></li>

          <?php }

                if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'portfolio')

                {?>

          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/myportfolio');?>"><font color="#000000"><b>Portfolio</b></font></a></li>

          <?php } 

                if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'reports')

                {?>

          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/reports');?>"><font color="#000000"><b>Reports</b></font></a></li>

          <?php } 

                if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'resources')

                {?>

          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/resources');?>"><font color="#000000"><b>Resources</b></font></a></li>

          <?php } 

                if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'master')

                {?>

          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/master');?>"><font color="#000000"><b>Master</b></font></a></li>

          <?php }

                if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'admin_master')

                {?>

          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/master');?>"><font color="#000000"><b>Master</b></font></a></li>

          <li> <a href="<?=site_url('login/admin_master');?>"><font color="#000000"><b>Admin Master</b></font></a></li>

          <?php }

                if($this->uri->segment('1') == 'login' && ($this->uri->segment('2') == 'manage_users' || $this->uri->segment('2') == 'manage_superadminusers'))

                {?>

          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/master');?>"><font color="#000000"><b>Master</b></font></a></li>

          <li> <a href="<?=site_url('login/manage_users');?>"><font color="#000000"><b>Manage Users</b></font></a></li>

          <?php }

                if($this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'assigned')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>My deals >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'all')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>All Deals >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'assessment' && $this->uri->segment('1') == 'login')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'innovation_details' && $this->uri->segment('1') == 'scouting')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Incubation Application Form >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'eir_app_edit' && $this->uri->segment('1') == 'scouting' )

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<?=site_url('scouting/innovation_details/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Incubation Application Form >></b></font></a></li>
          <li> <a href="<#"><font color="#000000"><b>Edit >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'view_list' && $this->uri->segment('1') == 'assessment')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Preliminary Assessment >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'view_details' && $this->uri->segment('1') == 'assessment')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>View Assessment >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'form' && $this->uri->segment('1') == 'assessment')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Add Details >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'view' && $this->uri->segment('1') == 'grading')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Grading & Feedback >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'detailed_diligence' && $this->uri->segment('1') == 'login')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Detailed Diligence >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'invite_prescreen' && $this->uri->segment('1') == 'screening')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<?=site_url('login/detailed_diligence/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Detailed Diligence >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Invite to Diligence >></b></font></a></li>

          <?php }

		  		if($this->uri->segment('2') == 'editassessdoc' && $this->uri->segment('1') == 'screening')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<?=site_url('login/detailed_diligence/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Detailed Diligence >></b></font></a></li>

		  <li> <a href="<?=site_url('screening/assessform/'.$this->uri->segment('3').'m1/11');?>"><font color="#000000"><b>Detailed Assessment >></b></font></a></li>

		  <li> <a href="<?=site_url('screening/showalldocuments/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment Documents >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Edit Assessment Document >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'nda_list' && $this->uri->segment('1') == 'screening')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<?=site_url('login/detailed_diligence/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Detailed Diligence >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>NDA Document >></b></font></a></li>

          <?php } 

		  if($this->uri->segment('2') == 'pre_ic' && $this->uri->segment('1') == 'screening')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<?=site_url('login/detailed_diligence/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Detailed Diligence >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>IC >></b></font></a></li>

          <?php }

                if($this->uri->segment('2') == 'assessform' || $this->uri->segment('2') == 'docverifyform' || $this->uri->segment('2') == 'peopleform' || $this->uri->segment('2') == 'peoplemeet' && $this->uri->segment('1') == 'screening')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<?=site_url('login/detailed_diligence/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Detailed Diligence >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Detailed Assessment >></b></font></a></li>

          <?php }

				if($this->uri->segment('2') == 'showalldocuments' && $this->uri->segment('1') == 'screening')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<?=site_url('login/detailed_diligence/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Detailed Diligence >></b></font></a></li>

          <li> <a href="<?=site_url('screening/assessform/'.$this->uri->segment('3').'m1/11');?>"><font color="#000000"><b>Detailed Assessment >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Assessment Documents >></b></font></a></li>

          <?php }

                if($this->uri->segment('2') == 'form' && $this->uri->segment('1') == 'screening')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<?=site_url('login/detailed_diligence/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Detailed Diligence >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Add Information >></b></font></a></li>

          <?php }
		  
		  		if($this->uri->segment('2') == 'view_financial' && $this->uri->segment('1') == 'screening')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<?=site_url('login/detailed_diligence/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Detailed Diligence >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Add Information >></b></font></a></li>

          <?php } 

                if($this->uri->segment('3') == 'assigned_incubation' || $this->uri->segment('3') == 'incubation' && $this->uri->segment('1') == 'scouting')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'myportfolio' && $this->uri->segment('1') == 'login')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'view' && $this->uri->segment('1') == 'seedfunding')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Seed Funding >></b></font></a></li>

          <?php }

            if($this->uri->segment('1') == 'seedfunding' && $this->uri->segment('2') == 'monthly_progress')
           {
            ?>
          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('seedfunding/view/'.$this->uri->segment('3').'');?>"><font color="#000000"><b>Seed Funding >></b></font></a></li>
        
          <li><a href="#"><font color="#000000"><b>Monthly Target</b></font></a></li>

         <?php
           }

		  if($this->uri->segment('2') == 'getinstallment' && $this->uri->segment('1') == 'seedfunding')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('seedfunding/view/'.$this->uri->segment('3').'');?>"><font color="#000000"><b>Seed Funding >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Get Installment Amount >></b></font></a></li>

          <?php } 

                 if($this->uri->segment('2') == 'activities' && $this->uri->segment('1') == 'seedfunding')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Incubation Plan >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'view_list' && ($this->uri->segment('1') == 'boardmember' || $this->uri->segment('1') == 'boardmeeting'))

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Board Meeting>></b></font></a></li>

          <?php } 

                if($this->uri->segment('5') == 'view' && $this->uri->segment('2') == 'view'  && $this->uri->segment('1') == 'boardmeeting')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('boardmember/view_list/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Board Meeting>></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>View Board Meeting>></b></font></a></li>

          <?php } 

                if($this->uri->segment('5') == 'edit' && $this->uri->segment('2') == 'view' && $this->uri->segment('1') == 'boardmeeting')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('boardmember/view_list/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Board Meeting>></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Edit Board Meeting>></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'index' && $this->uri->segment('1') == 'activities')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Activities >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'view_list' && $this->uri->segment('1') == 'activities')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('activities/index/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Activities >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>View Activities >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'add_activity' && $this->uri->segment('1') == 'activities')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('activities/index/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Activities >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Add Activities >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'activity_details' && $this->uri->segment('1') == 'activities')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('activities/index/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Activities >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Activity  Details>></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'fellows' && $this->uri->segment('1') == 'login')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('login/fellows/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Fellows >></b></font></a></li>

          <?php }  

                if($this->uri->segment('2') == 'kra_report' && $this->uri->segment('3') == 'view_report')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('login/fellows/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Fellows >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Add Progress >></b></font></a></li>

          <?php } 

              
		 if($this->uri->segment('1') == 'reports' && $this->uri->segment('3') == 'view_incubateereport')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

                    <li><a href="#"><font color="#000000"><b>Dashboard Report of Incubatee >></b></font></a></li>

          <?php }
		   

                if($this->uri->segment('2') == 'kra_report' && $this->uri->segment('3') == 'list_report')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('login/fellows/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Fellows >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>View Progress >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'portfolio_options' && $this->uri->segment('1') == 'login')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Portfolio Options >></b></font></a></li>

          <?php }

				 if($this->uri->segment('2') == 'incubateeform' && $this->uri->segment('1') == 'screening')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('login/portfolio_options/'.$this->uri->segment(3).'');?>"><font color="#000000"><b>Portfolio Options >></b></font></a></li>

          </li>

          <li> <a href="<#"><font color="#000000"><b>Create Incubatee Password >></b></font></a></li>

          <?php } 

                if($this->uri->segment('1') == 'scouting' && $this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'decision_pending') {?>
                   <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

                   <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>
                   <li> <a href="<#"><font color="#000000"><b>Pending Deals >></b></font></a></li>
                 <?php }
                if($this->uri->segment('2') == 'options' && $this->uri->segment('1') == 'login')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Options >></b></font></a></li>

          <?php } 

                if(($this->uri->segment('2') == 'mail' && $this->uri->segment('1') == 'common' && $this->uri->segment('3')!='form' || $this->uri->segment('3') == 'add_ext_mail'))
                {
				  if(isset($_SERVER['HTTP_REFERER']))

				  {

				    if(strpos($_SERVER['HTTP_REFERER'],'portfolio_options'))

					{

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('login/portfolio_options/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Portfolio Options >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Mail History >></b></font></a></li>

          <?php } else if((strpos($_SERVER['HTTP_REFERER'],'options')) || (strpos($_SERVER['HTTP_REFERER'],'mail'))){ ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>
            <?php
          if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')))
          {
            ?>
            <li><a href="<?=site_url('scouting/innovation_pool/all');?>"><font color="#000000"><b>All Deals >></b></font></a></li>
            <?php
          }
          else
          {
            ?>
            <li><a href="<?=site_url('scouting/innovation_pool/assigned');?>"><font color="#000000"><b>My Deals >></b></font></a></li>
            <?php
          }
          ?>
          
          <li><a href="<?=site_url('login/options/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Options >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Mail History >></b></font></a></li>

          <?php } 
		  			} 
					else
					{ ?>
						<li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>
				
						<li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>
				
                           <?php
          if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')))
          {
            ?>
            <li><a href="<?=site_url('scouting/innovation_pool/all');?>"><font color="#000000"><b>All Deals >></b></font></a></li>
            <?php
          }
          else
          {
            ?>
            <li><a href="<?=site_url('scouting/innovation_pool/assigned');?>"><font color="#000000"><b>My Deals >></b></font></a></li>
            <?php
          }
          ?>
				
						  <li><a href="<?=site_url('login/options/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Options >></b></font></a></li>
				
						  <li><a href="#"><font color="#000000"><b>Mail History >></b></font></a></li>
					<?php }
		  } 
		   if(($this->uri->segment('1') == 'common' && $this->uri->segment('2') == 'mail' && $this->uri->segment('3') == 'form'))
                {
				  if(isset($_SERVER['HTTP_REFERER']))

				  {

				    if(strpos($_SERVER['HTTP_REFERER'],'portfolio_options'))

					{

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('login/portfolio_options/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Portfolio Options >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Mail History >></b></font></a></li>

          <?php } else if(strpos($_SERVER['HTTP_REFERER'],'options')){ ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

           <?php
          if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')))
          {
            ?>
            <li><a href="<?=site_url('scouting/innovation_pool/all');?>"><font color="#000000"><b>All Deals >></b></font></a></li>
            <?php
          }
          else
          {
            ?>
            <li><a href="<?=site_url('scouting/innovation_pool/assigned');?>"><font color="#000000"><b>My Deals >></b></font></a></li>
            <?php
          }
          ?>

          <li><a href="<?=site_url('login/options/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Options >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Mail History >></b></font></a></li>

          <?php } 
		  			} 
					else
					{ ?>
										<li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>
				
						  <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>
				
 <?php
          if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')))
          {
            ?>
            <li><a href="<?=site_url('scouting/innovation_pool/all');?>"><font color="#000000"><b>All Deals >></b></font></a></li>
            <?php
          }
          else
          {
            ?>
            <li><a href="<?=site_url('scouting/innovation_pool/assigned');?>"><font color="#000000"><b>My Deals >></b></font></a></li>
            <?php
          }
          ?>
				
						  <li><a href="<?=site_url('login/options/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Options >></b></font></a></li>
				
						  <li><a href="#"><font color="#000000"><b>Mail History >></b></font></a></li>
					<?php }
		  }
		  

		  		if($this->uri->segment('2') == 'alldocument' && $this->uri->segment('1') == 'common')

                {

				  if(isset($_SERVER['HTTP_REFERER']))

				  {

				    if(strpos($_SERVER['HTTP_REFERER'],'portfolio_options'))

					{

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('login/portfolio_options/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Portfolio Options >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>All Documents >></b></font></a></li>

          <?php } else if(strpos($_SERVER['HTTP_REFERER'],'options')){ ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

 <?php
          if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')))
          {
            ?>
            <li><a href="<?=site_url('scouting/innovation_pool/all');?>"><font color="#000000"><b>All Deals >></b></font></a></li>
            <?php
          }
          else
          {
            ?>
            <li><a href="<?=site_url('scouting/innovation_pool/assigned');?>"><font color="#000000"><b>My Deals >></b></font></a></li>
            <?php
          }
          ?>

          <li><a href="<?=site_url('login/options/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Options >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>All Documents >></b></font></a></li>

          <?php } } } 

		  

                if($this->uri->segment('2') == 'exitdetails' && $this->uri->segment('1') == 'exit_details')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('login/portfolio_options/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Portfolio Options >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Exit Details >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'old_innovation' || $this->uri->segment('2') == 'old_innovations' || $this->uri->segment('2') == 'oldinnovation' && $this->uri->segment('1') == 'scouting')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/portfolio/');?>"><font color="#000000"><b>Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('scouting/innovation_pool/incubation');?>"><font color="#000000"><b>My Portfolio >></b></font></a></li>

          <li><a href="<?=site_url('login/portfolio_options/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Portfolio Options >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Innovation Reports >></b></font></a></li>

          <?php }

		if($this->uri->segment('3') == 'new_report' || $this->uri->segment('3') == 'innovations_report_totaldeals' ||  $this->uri->segment('3') == 'innovations_report_entryclosed' || $this->uri->segment('3') == 'innovations_report' || $this->uri->segment('3') == 'innovations_report_identifiedBy' || $this->uri->segment('3') == 'innovations_report_followUp' || $this->uri->segment('3') == 'innovations_report_DecisionPending' && $this->uri->segment('1') == 'common' && $this->uri->segment('2') == 'report')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/reports/');?>"><font color="#000000"><b>Reports >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Innovations Report >></b></font></a></li>

          <?php }

                if($this->uri->segment('2') == 'ic_confirm' && $this->uri->segment('1') == 'screening')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<?=site_url('login/detailed_diligence/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Detailed Diligence >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>IC >></b></font></a></li>

          <?php }

                if($this->uri->segment('1') == 'screening' && $this->uri->segment('2') == 'agreement')

                            {?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<?=site_url('login/detailed_diligence/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Detailed Diligence >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Agreement >></b></font></a></li>

          <?php }  

                if($this->uri->segment('1') == 'screening' && $this->uri->segment('2') == 'documents')

                            {?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals/');?>"><font color="#000000"><b>Deals >></b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment >></b></font></a></li>

          <li> <a href="<?=site_url('login/detailed_diligence/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Detailed Diligence >></b></font></a></li>

          <li> <a href="<#"><font color="#000000"><b>Document Check List >></b></font></a></li>

          <?php }  

                if($this->uri->segment('2') == 'leaves' && $this->uri->segment('1') == 'login')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/approvals/');?>"><font color="#000000"><b>Approve >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Leave >></b></font></a></li>

          <?php } 

                if($this->uri->segment('2') == 'master_settings' || $this->uri->segment('1') == 'master')

                {

                ?>

          <li> <a href="<?=site_url('login/icon_menu/')?>"><font color="#000000"><b>Home >></b></font></a></li>

          <li> <a href="<?=site_url('login/master/');?>"><font color="#000000"><b>Masters >></b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Incubation Master >></b></font></a></li>

          <?php } ?>
          <?php if($this->uri->segment('1') == 'scouting' && $this->uri->segment('2') == 'seed_app_edit')

                            {?>

          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('scouting/innovation_details/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Incubation Application Form</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>SEED Application Edit</b></font></a></li>

          <?php } ?>
          <?php if($this->uri->segment('1') == 'scouting' && $this->uri->segment('2') == 'pitch_app_edit')

                            {?>

          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('scouting/innovation_details/'.substr($this->uri->segment('3'),3));?>"><font color="#000000"><b>Incubation Application Form</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>Pitch Application Edit</b></font></a></li>

          <?php } ?>
          <?php
          if($this->uri->segment('1') == "assessment" && $this->uri->segment('2') == 'assess_summary' && $this->uri->segment('3') != '')
          {
            ?>
          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('login/mydeals');?>"><font color="#000000"><b>Deals</b></font></a></li>

          <li> <a href="<?=site_url('login/assessment/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Assessment</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>Assessment Summary</b></font></a></li>
          <?php
          }
         ?>
                   <?php
          if($this->uri->segment('1') == "close" && $this->uri->segment('2') == 'rejection')
          {
            ?>
          <li> <a href="<?=site_url('login/icon_menu/');?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('scouting/innovation_pool/all');?>"><font color="#000000"><b>Deals</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>Deals Bulk Close</b></font></a></li>

         
          <?php
          }
         ?>

        </ul>

        <?php } else { ?>

        <ul class="breadcrumb">

          <?php if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'incubatee' && $this->uri->segment('3') == 'incubatee_menu')

                            {?>

          <li> <a href="#"><font color="#000000"><b>Home</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'incubator_metrics' && $this->uri->segment('2') == 'wglobal_report' && $this->uri->segment('3') == 'dashboard')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>Home</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'incubatee' && $this->uri->segment('3') == 'company_info')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>Company Info</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'scouting' && $this->uri->segment('2') == 'innovation_details')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li><a href="<?=site_url('login/incubatee/company_info/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Company Info</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>Innovation Details</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'presentation' && $this->uri->segment('2') == 'view')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li><a href="<?=site_url('login/incubatee/company_info/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Company Info</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>Presentation</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'screening' && $this->uri->segment('2') == 'form' || $this->uri->segment('2') == 'agreement' || $this->uri->segment('2') == 'documents' || $this->uri->segment('2') == 'getCompanyDetails' )

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li><a href="<?=site_url('login/incubatee/company_info/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Company Info</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>Detailed Info</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'common' && $this->uri->segment('2') == 'alldocument' && $this->uri->segment('2') == 'view_list')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li><a href="<?=site_url('login/incubatee/company_info/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Company Info</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>View Documents</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'incubatee' && $this->uri->segment('3') == 'villgro_service')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>Villgro Service's</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'seedfunding' && $this->uri->segment('2') == 'view')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('login/incubatee/villgro_service/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Villgro Service's</b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Seed Funding</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'seedfunding' && $this->uri->segment('2') == 'getinstallment')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('login/incubatee/villgro_service/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Villgro Service's</b></font></a></li>

          <li><a href="<?=site_url('seedfunding/view/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Seed Funding</b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Get Installment</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'boardmeeting' && $this->uri->segment('2') == 'view' && $this->uri->segment('5') == 'view')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('login/incubatee/villgro_service/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Villgro Service's</b></font></a></li>

          <li><a href="<?=site_url('boardmeeting/view_list/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Board Meeting</b></font></a></li>

          <li><a href="#"><font color="#000000"><b>View Board Meeting</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'boardmeeting' && $this->uri->segment('2') == 'view_list' )

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('login/incubatee/villgro_service/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Villgro Service's</b></font></a></li>

          <li><a href="<?=site_url('boardmeeting/view_list/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Board Meeting</b></font></a></li>

          <li><a href="#"><font color="#000000"><b>View Board Meeting</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'boardmeeting' && $this->uri->segment('2') == 'view' && $this->uri->segment('5') == 'edit')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('login/incubatee/villgro_service/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Villgro Service's</b></font></a></li>

          <li><a href="<?=site_url('boardmeeting/view_list/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Board Meeting</b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Edit Board Meeting</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'activities' && $this->uri->segment('2') == 'index')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('login/incubatee/villgro_service/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Villgro Service's</b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Activity</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'activities' && $this->uri->segment('2') == 'view_list')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('login/incubatee/villgro_service/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Villgro Service's</b></font></a></li>

          <li><a href="<?=site_url('activities/index/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Activity</b></font></a></li>

          <li><a href="#"><font color="#000000"><b>View Activity</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'activities' && $this->uri->segment('2') == 'add_activity')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('login/incubatee/villgro_service/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Villgro Service's</b></font></a></li>

          <li><a href="<?=site_url('activities/index/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Activity</b></font></a></li>

          <li><a href="#"><font color="#000000"><b>Add Activity</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'login' && $this->uri->segment('2') == 'incubatee' && $this->uri->segment('3') == 'report_villgro')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>Report to Villgro</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'incubationprogress' && $this->uri->segment('2') == 'form')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('login/incubatee/report_villgro/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Report Villgro</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>Metrics Information</b></font></a></li>

          <?php } ?>

          <?php  if ($this->uri->segment('1') == 'reports' && $this->uri->segment('2') == 'incubation_report') { ?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('login/incubatee/report_villgro/'.$this->uri->segment('4'));?>"><font color="#000000"><b>Report Villgro</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>Incubation Monthly Report</b></font></a></li>

          <?php } ?>

          <?php if($this->uri->segment('1') == 'seedfunding' && $this->uri->segment('2') == 'monthly_progress')

                            {?>

          <li> <a href="<?=site_url('login/incubatee/incubatee_menu/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Home</b></font></a></li>

          <li> <a href="<?=site_url('login/incubatee/report_villgro/'.$this->uri->segment('3'));?>"><font color="#000000"><b>Report Villgro</b></font></a></li>

          <li> <a href="#"><font color="#000000"><b>Monthly Target / Achieved</b></font></a></li>

          <?php } ?>

        </ul>

        <br/>

        <?php }

                        if($this->uri->segment('1') == 'master' && ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin'))

                        {

                            $this->load->view('master/left_menu');

                        }

                        $this->load->view($cpage);

                 ?>

      </div>

    </section>

  </section>

</section>


</div>

</div>

</body>

</html>
