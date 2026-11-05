<?php $current = $this->uri->segment('1'); ?>
<div class="headerMENU_OUT">
<div class="headerMENU">
    <?php $incubateeID = $this->uri->segment("4"); ?>
             <a href="<?php echo site_url('incubator_metrics/wglobal_report/dashboard/'.$this->session->userdata('innovation')); ?>" class="<?php echo ($this->uri->segment('2') == 'wglobal_report')?'sel':''; ?>">Dashboard </a>
			 <a class="<?php echo ($this->uri->segment('2') == 'innovation_details')?'sel':''; ?>" href="<?=site_url('scouting/innovation_details/'.$this->session->userdata('innovation'));?>" ><span>Company Info</span></a>
            <?php if($this->session->userdata('user_id')){ ?>
            <a class="<?php echo ($this->uri->segment('1') == 'seedfunding' && $this->uri->segment('2') != 'monthly_progress')?'sel':''; ?>" href="<?=site_url('seedfunding/view/'.$this->session->userdata('innovation'));?>" >Villgro's Service</a>
            <?php } ?>
            <a class="<?php echo ($this->uri->segment('1') == 'incubationprogress' || $this->uri->segment('2') == 'monthly_progress')?'sel':''; ?>" href="<?=site_url('incubationprogress/form/'.$this->session->userdata('innovation'));?>" ><span>Report to Villgro</span></a>
</div>
</div>

<div class="header_BAR">
    <div class="header_BAR_OUT">

<?php
$current = $this->uri->segment('1');
$cur = $this->uri->segment('2');
if(($current == "seedfunding") && ($cur != 'monthly_progress') ||   ($current == "boardmember") || ($current == "invester") || ($current == "mentor") || ($current == "media") || ($current == "fellow") || ($current == "applicant") || ($current == "training") || ($current == "trainings") ) { ?>

  <div class="header_BAR_TXT">
        <a href="<?=site_url('seedfunding/view/'.$this->session->userdata('innovation'));?>" >Seed Funding</a>
        <a href="<?=site_url('boardmember/view_list/'.$this->session->userdata('innovation'));?>">Board Meeting</a>
  </div>

 <?php } ?>
<?php
$current = $this->uri->segment('1');
if(($current == "scouting") || ($current == "presentation") || ($current == "screening") || ($current == "common")) { ?>

        <div class="header_BAR_TXT">
            <a href="<?=site_url('scouting/innovation_details/'.$this->session->userdata('innovation'));?>" >Basic Information</a>
            <a href="<?=site_url('presentation/view/'.$this->session->userdata('innovation'));?>">Entrepreneur Presentation</a>
            <a href="<?=site_url('screening/form/'.$this->session->userdata('innovation'));?>">Detailed Info</a>
            <a href="<?=site_url('common/alldocument/view_list/'.$this->session->userdata('innovation'));?>">View Documents</a>
        </div>

 <?php } ?>
<?php
$current = $this->uri->segment('2');
if(($current == "form") || ($current == "monthly_progress")) { ?>
        <div class="header_BAR_TXT">
            <a href="<?=site_url('incubationprogress/form/'.$this->session->userdata('innovation'));?>" >Metrics Information</a>
            <a href="<?=site_url('seedfunding/monthly_progress/'.$this->session->userdata('innovation'));?>">Add MonthlyReport</a>
        </div>
<?php } ?>

</div>
</div>