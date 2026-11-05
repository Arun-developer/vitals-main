
    
                <h2 style="color:#902452;"> Innovation Stage Notifications </h2> <?php $countNotification = php72_count($notification_Details); ?>
                
                <hr>
               <?php foreach($notification_Details as $row) { ?>
            <div class="dataDetails" style="background-color:whitesmoke;height:auto;margin-bottom:8px;"> 
               <?php  
                if($row['status'] == '0') {
                    
                  $row['status'] = "New";
                }
                if($row['status'] == '1') {
                    
                  $row['status'] = "Follow-Up";
                }
                if($row['status'] == '2') {
                    
                  $row['status'] = "On-Hold";
                }
                if($row['status'] == '3') {
                    
                  $row['status'] = "Closed";
                }
                if($row['stage'] == '0') {
                    
                    $row['stage'] = "New";
                }
                 if($row['stage'] == '1') {
                    
                    $row['stage'] = "Entry";
                }
                if($row['stage'] == '2') {
                    
                    $row['stage'] = "Lead";
                }
                if($row['stage'] == '3') {
                    
                    $row['stage'] = "Shortlisted";
                }
                if($row['stage'] == '4') {
                    
                    $row['stage'] = "Leads for Due-Diligence";
                }
                if($row['stage'] == '5') {
                    
                    $row['stage'] = "Incubation";
                }
                if($row['stage'] == '6') {
                    
                    $row['stage'] = "Incubation Progress";
                }
                ?>
                <a href="<?php echo site_url('scouting/innovation_pool/all'); ?>"> <img src="<?php echo base_url(); ?>source/template/images/icons/alert_icon.png">
               <?php 
               echo "<span class='' style='font-size:11px;padding-left:10px;margin-top:15px;color:#5B90F6;background:url('../source/template/images/icons/bullet_go.png');'>".ucfirst($row['name_of_entrepreneur'])."</span>"."<span style='font-size:11px;color:#555555;'>"." is in <span style='color:green;'>".$row['stage']."</span>  stage,"."</span>"." "; 
               echo "<span style='font-size:11px;color:#555555;font-weight:bold;'> Status </span><span style='font-size:11px;color:#555555;'> is ".$row['status']."</span>"; ?>
		</a>	
                 </div>
               <?php }  ?>
                
                <?php ?>
                
                <div >
                    <?php
                  
                    ?>
                </div>
                <?php   ?>
             