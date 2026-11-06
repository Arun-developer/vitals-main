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
       <img src="<?=base_url();?>source/images/checklist.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('screening/assign_checklist/'.$id);?>" class="fancybox">Document CheckList 
       
      </a></div>
 </div>
 
 <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/invite.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('screening/invite_prescreen/'.$id);?>">Invite to Diligence 
       
      </a></div>
 </div>
 
 
 <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/NDA.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('screening/nda_list/'.$id);?>">NDA Documents 
       
      </a></div>
 </div>
 
 <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/add-info.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('screening/peopleform/'.$id);?>">Add Site Visit Schedule
       
      </a></div>
 </div>
 
 
 
  
 <div style="clear:both"></div>
 </div>
 
 
 <div class="icon-row">
 
  <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/detailed-assessment.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('screening/assessform/'.$id.'/m1/11');?>">Detailed Assessment 
       
      </a></div>
 </div>

 
 
 <?php if($this->session->userdata('user_type') != 'incubatee'){ ?> 
 <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/detailed-assessment.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('screening/ic_confirm/'.$id);?>">IC 
       
      </a></div>
 </div>
 <?php } ?>
 <?php 
 $this->load->model('muser');
 $status = $this->Muser->geticstatus($id);
 if(php72_cmp($status[0]['ic_status']) == 1){ ?> 
 <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/detailed-assessment.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('screening/agreement/'.$id);?>">Agreement 
       
      </a></div>
 </div>
 <?php } ?>    
 
  <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/add-info.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('screening/form/'.$id);?>">Add Info
       
      </a></div>
 </div>
   <div style="clear:both"></div>
 </div>
  
</div>
</div>
</body>
</html>
