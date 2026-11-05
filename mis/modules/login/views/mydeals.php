<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Villgro</title>
</head>

<body>

<div class="container">
  
 <div style="clear:both"></div>
 
 <div class="icon-panal">
 
 <div class="icon-row">
   <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/deal.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('scouting/innovation_pool/assigned');?>">My Deals 
      <span>
        
        <?php $cio_emp_id = $this->Mmaster->getEmpIdBySetUP('cio',$this->session->userdata('partner_id'));
            if($this->session->userdata('emp_number') != $cio_emp_id[0]['cio']){ ?>
            ( <?= $my_deals_count;?>
         <?php  ?> ) <?php } else { ?>(
               <?= $my_deals_cio_count;?>
           )<?php } 

        ?></span>
      </a></div>
 </div>
 
 <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/all-deal.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('scouting/innovation_pool/all');?>">All Deals 
       
      </a></div>
 </div>

 <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/dashboard.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('chart/dashboardPieChart');?>">Dashboard</a></div>
 </div>

<?php if(in_array($this->session->userdata('user_type'),array('superadmin','admin','ceo','cio'))) { ?>  
 <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/assessments.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('scouting/innovation_pool/decision_pending');?>">Pending Deals</a>
       &nbsp;-&nbsp;<span style="color:#FF0000"><?=$count_decision_pending;?></span>
     </div>
 </div>
<?php } ?>
  
 <div style="clear:both"></div>
 </div>
 
 
 <div class="icon-row">
   <div style="clear:both"></div>
 </div>
  
</div>
</div>
</body>
</html>
