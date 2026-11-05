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
           <img src="<?=base_url();?>source/images/request.png" alt="innovation" /></div>
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
             

             <?php if($innovation['status'] != '8' && $innovation['status'] == '3') { ?>
               <div class="icon-box">
                 <div class="icon">
                   <img src="<?=base_url();?>source/images/Time-Sheet.png" alt="innovation" /></div>
                   <div class="icon-btn"><a href="<?=site_url('scouting/action/resume/'.$id);?>" class="fancybox">Reopen
                     
                   </a></div>
                 </div> 
               <?php } else {
                 $action = array('3','8'); 
                 if(!in_array($innovation['status'],$action)) { ?>
                  <div class="icon-box">
                   <div class="icon">
                     <img src="<?=base_url();?>source/images/Time-Sheet.png" alt="innovation" /></div>
                     <div class="icon-btn"><a href="<?=site_url('scouting/action/close/'.$id);?>" class="fancybox">Close / Bank</a></div>
                   </div>
                 <?php } 
               } ?>   
               <div style="clear:both"></div>
             </div>
             <?php 
             $action = array('3','8');
             if($innovation['status'] != '8' && $innovation['status'] == '3' && !in_array($innovation['status'],$action)) {?>
               <div class="icon-row">
                <?php
                
                if(!in_array($innovation['status'],$action)) { ?>
                  <div class="icon-box">
                   <div class="icon">
                     <img src="<?=base_url();?>source/images/Time-Sheet.png" alt="innovation" /></div>
                     <div class="icon-btn"><a href="<?=site_url('scouting/action/close/'.$id);?>" class="fancybox">Close
                       
                     </a></div>
                   </div>
                 <?php } ?>
                 <div style="clear:both"></div>
               </div>
             <?php } ?>
             
           </div>
         </div>

       </body>
       </html>
