<?php 
foreach($activityDetails as $act):
?>

<?php
$readonly = ($scoutingStage != $act['program_stage'])?'readonly':'';
?>
	<h2><?php echo $act['name_of_enterprise']?> - Edit Activity </h2>
	<form name="edit_activity" enctype="multipart/form-data" action="<?=site_url('activities/edit_activity/'.$act['innovation'].'/'.$act['id'])?>" method="post" id="edit_activity" >
    <input type="hidden" name="program_stage" class="input-text" value="<?=$act['program_stage']?>" size="40"/>
     <input type="hidden" name="id" class="input-text" value="<?=$act['id']?>" size="40"/>
      <input type="hidden" name="activity" class="input-text" value="<?=$act['activity']?>" size="40"/>
<dl class="inline">
    <dt><label for="at">Activity Type<font color="red">*</font></label></dt>
    <dd><select name="at" id="sourceType" >
            <?php
			foreach($activityTypeList as $row):
				?>
                <option value="<?=$row['id']?>" <?=($act['activity_type'] == $row['id'])?'selected':'';?> disabled="disabled"><?=$row['master_name']?></option>
                <?php 
			endforeach;
			?>
        </select>
        <input type="hidden" name="activity_type"   value="<?=$act['activity_type']?>"  size="40"/>
       </dd>
    
    <dt><label for="activity_description">Activity Description<font color="red">*</font></label></dt>
    <dd><textarea name="activity_description" class="input-text required"  <?=$readonly?> rows="5" cols="40" ><?=$act['activity_description']?></textarea></dd>
    
     <dt><label for="start_date">Start Date<font color="red">*</font></label></dt>
    <dd><input type="text" name="start_date" class="input-text required" size="40" id="fromdate" value="<?=mysql2date($act['start_date'])?>" /></dd>
    
     <dt><label for="name">End Date<font color="red">*</font></label></dt>
    <dd><input type="text" name="end_date" class="input-text required" size="40" id="todate"  value="<?=mysql2date($act['end_date'])?>" /></dd>
 </dl>
 <div class="buttons">
			<input type="submit" value="Save" name="txtSubmit" class="button" />
			<input type="reset" value="Reset" name="txtReset" class="button white" />
 </div>
	</form>
<?php endforeach; ?>
<!-- end id-form  -->
