
<h2><?=$cpagetitle?></h2>
<form name="assessform" action="<?=site_url('screening/assessform/'.$innovation.'/'.$criteria.'/'.$pid);?>" enctype="multipart/form-data" method="post" id="assessform">
<input type="hidden" name="criteria" value="<?=$criteria?>" />
<input type="hidden" name="innovation" value="<?=$innovation?>" />
<input type="hidden" name="pid" value="<?=$pid?>" />
<?php
foreach($fieldsList as $row):
?>
<div class="fieldMainAssess">
<div class="fieldLabelAssess"><?php echo $row['label']; if($row['required'] == 'yes'){ echo '&nbsp;<font class="req_field">*</font>'; }?>
 </div>
<?php $cfValue = (isset($_POST['txtSubmit']))?$_POST[$row['id']]:$row['answer']; ?>
<div class="fieldAnswer" title="Edit">
	<?=nl2br($cfValue)?>&nbsp;
</div> 
<div class="note_option">Edit</div>
<div class="fieldInputAssess" style="display:none">

<?php
switch($row['input_type']){
	case 'Text':
		?>
        <input type="text" size="40" class="assessin input-text <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>" name="<?=$row['id']?>" value="<?=$cfValue?>"  /><a href="javascript:void(0);" class="answerthis">Ok</a>
		<input type="file" size="40" class="<?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>" name="<?=$row['id']?>"  />
        <input type="hidden" value="<?=$cfValue?>" name="olddocument_<?=$row['id']?>"  />
        <?php
		if($cfValue!=''){ ?> <a href="<?=base_url()?>uploads/screening/<?=$cfValue?>" target="_blank">Download</a><?php } 
		?>
        <?php
		break;
	case 'Textarea':
		?>		
        <textarea cols="40" rows="5"  class="assessin input-text <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>" name="<?=$row['id']?>"><?=$cfValue?></textarea><a href="javascript:void(0);" class="answerthis">Ok</a>
		<input type="file" size="40" class="<?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>" name="<?=$row['id']?>"  />
        <input type="hidden" value="<?=$cfValue?>" name="olddocument_<?=$row['id']?>"  />
     
		<?php
		if($cfValue!=''){ ?> <a href="<?=base_url()?>uploads/screening/<?=$cfValue?>" target="_blank">Download</a><?php }
		
		?>
        <?php
		break;
	case 'Listbox':
		?>
        <select name="<?=$row['id']?>" id="<?=$row['id']?>" class="assessin <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>" >
           	<option value="">Select</option>
            <?php foreach($row['value'] as $key=>$value): ?>
            <option value="<?=$value?>" <?=($cfValue==$value)?'selected':'';?> ><?=$value?></option>
            <?php endforeach; ?>
        </select><a href="javascript:void(0);" class="answerthis">Ok</a>
		
		<input type="file" size="40" class="<?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>" name="<?=$row['id']?>"  />
        <input type="hidden" value="<?=$cfValue?>" name="olddocument_<?=$row['id']?>"  />
        <?php
		if($cfValue!=''){ ?> <a href="<?=base_url()?>uploads/screening/<?=$cfValue?>" target="_blank">Download</a><?php }
		
		?>
        <?php
		break;
	case 'Radio':
		foreach($row['value'] as $key=>$value): ?>
        <label><input  type="radio" name="<?=$row['id']?>" class="assessin <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>" value="<?=$value?>"
         <?=($cfValue==$value)?'checked="checked"':'';?> /> 
        <?=$value?></label>
        <?php
		 endforeach;  ?>
		 <input type="file" size="40" class="<?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>" name="<?=$row['id']?>"  />
        <input type="hidden" value="<?=$cfValue?>" name="olddocument_<?=$row['id']?>"  />
        <?php
		if($cfValue!=''){ ?> <a href="<?=base_url()?>uploads/screening/<?=$cfValue?>" target="_blank">Download</a><?php } 
		break;
	case 'Checkbox':
		$cfValue = (isset($_POST['txtSubmit']))?$_POST[$row['id']]:explode(',',$row['answer']);
		foreach($row['value'] as $key=>$value): ?>
        <label><input type="checkbox"  name="<?=$row['id']?>[]" class="assessin <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>" value="<?=$value?>" 
         <?=(php72_in_array($value,$cfValue))?'checked="checked"':'';?> /> 
        <?=$value?></label><br/>
        <?php
		 endforeach;
		break;
	case 'File':
		?>
        <input type="file" size="40" class="<?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>" name="<?=$row['id']?>"  />
        <input type="hidden" value="<?=$cfValue?>" name="olddocument_<?=$row['id']?>"  />
        <?php
		if($cfValue!=''){ ?> <a href="<?=base_url()?>uploads/screening/<?=$cfValue?>" target="_blank">Download</a><?php }
		break;
}
?>
</div>
</div>
<?php
endforeach;
?>
<div class="fieldMainAssess">
<div class="fieldLabelAssess">&nbsp;</div>
<div class="fieldInputAssess"><input type="submit" class="button" name="txtSubmit" value="Save" id="submit" />&nbsp;&nbsp;
            <input type="reset" class="button white" name="txtReset" value="Reset" />
</div>
</div>
</form>
<style type="text/css">
.fieldMainAssess
{
	border:1px solid #F8F8F8; 
	padding:5px;
	margin-bottom:5px;
	background:#FDFDFD; 
	width:100%;
}
.fieldLabelAssess
{
	font-weight:bold;
	padding:5px;
}
.fieldInputAssess
{
	padding:5px;
}

.fieldAnswer
{
	padding:5px;
	border-right:2px solid #CCC;
}
.answerthis
{
	text-decoration:none;
	background:green;
	padding:2px 4px;
	font-weight:bold;
	color:#FFF;
	border-radius:3px 4px;
	
}
.fieldAnswer:hover 
{
	border:1px solid #ccc;
	padding:4px;
}
.note_option
{
	display:none;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('.fieldAnswer,.answerthis').click(function(){
			$(this).parents('.fieldMainAssess').find('.fieldInputAssess').toggle();
			$(this).parents('.fieldMainAssess').find('.fieldAnswer').toggle();
			hh = $(this).parents('.fieldMainAssess').find('.assessin').val();
			$(this).parents('.fieldMainAssess').find('.fieldAnswer').html(hh);
	});
});
</script>