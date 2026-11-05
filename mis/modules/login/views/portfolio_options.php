<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Villgro</title>
</head>
<?php 
    $detailLink = 'scouting/assign_incharge/'.$id;
?>
<body>
    <h1><?=$cpagetitle;?></h1>
<div class="container">
 <div style="clear:both"></div>
 
 <div class="icon-panal">
 
 <div class="icon-row">
   <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/requests.png" alt="innovation" /></div>
       <div class="icon-btn">
	   
	   <a href="<?=site_url($detailLink);?>" class="fancybox">Assign Incharge 
       
      </a></div>
 </div>
 
 <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/mail.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('common/mail/history/'.$id);?>">Mail History
       
      </a></div>
 </div>
     
<div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/1.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('common/alldocument/view_list/'.$id);?>">View Documents
       
      </a></div>
 </div>
     
<div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/Time-Sheet.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('exit_details/exitdetails/gradingDetails/'.$id);?>">Exit Innovation
       
      </a></div>
 </div>
     
  
 
 
 <div style="clear:both"></div>
 </div>
 
 <div class="icon-row">
     <div class="icon-box">
     <div class="icon">
       <img src="<?=base_url();?>source/images/Time-Sheet.png" alt="innovation" /></div>
       <div class="icon-btn"><a href="<?=site_url('screening/incubateeform/'.$id);?>">Create Incubatee Password
       
      </a></div>
 </div> 
  
   <div style="clear:both"></div>
 </div>
  
</div>


</body>
</html>
