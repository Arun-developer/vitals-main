<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Villgro</title>
</head>
<?php 
$detailLink = 'scouting/innovation_details/'.$id;
?>
<body>
  <h1><?=$cpagetitle;?></h1>
  <div class="container">
   <div style="clear:both"></div>

   <div class="icon-panal">

     <div class="icon-row">
       <div class="icon-box">
         <div class="icon">
           <img src="<?=base_url();?>source/images/innovation.png" alt="innovation" /></div>
           <div class="icon-btn"><a href="<?=site_url($detailLink);?>">Incubation Application Form</a></div>
         </div>

         <div class="icon-box">
           <div class="icon">
             <img src="<?=base_url();?>source/images/assesment.png" alt="innovation" /></div>
             <div class="icon-btn"><a href="<?=site_url('assessment/view_list/'.$id);?>">Preliminary Assessment</a></div>
           </div>

           <?php if($innovation['stage'] == '9' || $innovation['stage'] == '12' || $this->session->userdata('user_type')== 'superadmin') { ?>
            <div class="icon-box">
             <div class="icon">
               <img src="<?=base_url();?>source/images/detailed-diligence.png" alt="innovation" /></div>
               <div class="icon-btn"><a href="<?=site_url('detailed_diligence/dashboard/'.$id);?>">Detailed Diligence</a></div>
             </div>
           <?php } ?>

           <?php if($innovation['stage'] == '12') { ?>
            <div class="icon-box">
             <div class="icon">
               <img src="<?=base_url();?>source/images/my-portfolio.png" alt="innovation" /></div>
               <div class="icon-btn"><a href="<?=site_url('portfolio/company_data/'.$id);?>">Portfolio</a></div>
             </div>
           <?php } ?>

           <?php 
           if($innovation['stage'] != '12') { 
             if(($innovation['partner_id']== $this->session->userdata('partner_id')) || $this->session->userdata('user_type')== 'superadmin')
               {  ?>
                 <div class="icon-box">
                   <div class="icon">
                     <img src="<?=base_url();?>source/images/4.png" alt="innovation" /></div>
                     <div class="icon-btn"><a href="<?=site_url('login/options/'.$id);?>">Options</a></div>
                   </div> 
                   <?php 
                 } 
               } ?>

               <div style="clear:both"></div>
             </div>


             <div class="icon-row">
               <?php 
               if($innovation['stage'] == '12') { 
                 if(($innovation['partner_id']== $this->session->userdata('partner_id')) || $this->session->userdata('user_type')== 'superadmin')
                   {  ?>
                     <div class="icon-box">
                       <div class="icon">
                         <img src="<?=base_url();?>source/images/4.png" alt="innovation" /></div>
                         <div class="icon-btn"><a href="<?=site_url('login/options/'.$id);?>">Options</a></div>
                       </div> 
                       <?php 
                     } 
                   }
                   ?>

                   <div style="clear:both"></div>
                 </div>

               </div>
             </div>

           </body>
           </html>
