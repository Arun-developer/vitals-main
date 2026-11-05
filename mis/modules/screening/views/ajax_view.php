<?php

$r = 0;
foreach($fieldsList as $row):
if($r==0)
{
	$r = 1;
	?>


<div class="<?=$row['pid']?>_subLevel">
    <?php } ?>
    <dl class="inline fieldMain <?=$row['pid']?>_subLevel">
        <dt><label
                for="<?=$row['id']?>"><?php echo $row['label']; if($row['required'] == 'yes'){ echo '&nbsp;<font class="req_field">*</font>'; }?>
                : </label></dt>
        <dd>
            <?php
echo $cfValue = (isset($_POST['txtSubmit']))?$_POST[$row['id']]:$row['answer'];
$suQuesion = ($row['sub_field']>0)?'showSubField':'';
switch($row['input_type']){
	case 'Text':
		?>
            <input type="hidden" size="40"
                class="input-text <?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                name="<?=$row['id']?>" value="<?=$cfValue?>" />
            <?php
		break;
	case 'Textarea':
		?>
            <textarea cols="40" style="display:none;" rows="5"
                class="input-text <?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                name="<?=$row['id']?>"><?=$cfValue?></textarea>
            <?php
		break;
	case 'Listbox':
		?>
            <select name="<?=$row['id']?>" style="display:none;"
                class="<?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>">
                <option value="">Select</option>
                <?php foreach($row['value'] as $key=>$value): ?>
                <option value="<?=$value?>" <?=($cfValue==$value)?'selected':'';?>><?=$value?></option>
                <?php endforeach; ?>
            </select>
            <?php
		break;
	case 'Radio':
		foreach($row['value'] as $key=>$value): ?>
            <input type="hidden" name="<?=$row['id']?>"
                class="<?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                value="<?=$value?>" <?=($cfValue==$value)?'checked="checked"':'';?> />

            <?php
		 endforeach;
		break;
	case 'Checkbox':
		$cfValue = (isset($_POST['txtSubmit']))?$_POST[$row['id']]:explode(',',$row['answer']);
		foreach($row['value'] as $key=>$value): ?>
            <input type="hidden" name="<?=$row['id']?>[]"
                class="<?=$suQuesion?> <?=($row['required'] == 'yes')?'required':'';?> <?=$row['class']?>"
                value="<?=$value?>" <?=(php72_in_array($value,$cfValue))?'checked="checked"':'';?> />
            <?php
		 endforeach;
		break;
	case 'File':
		?>
            <input type="hidden" value="<?=$cfValue?>" name="olddocument_<?=$row['id']?>" />
            <?php
		if($cfValue!=''){ ?> <a href="<?=base_url()?>uploads/screening/<?=$cfValue?>" target="_blank"><img
                    src="<?=base_url();?>source/template/images/icons/download.gif" height="16" /></a><?php }
		break;
}

?>
        </dd>
    </dl>

    <?php
if($row['sub_field']>0)
{
	$this->Mscreening->ajaxForm($innovation,$criteria,$row['id'],$cfValue,$option);
}
endforeach;
?>
</div>

<script type="text/javascript">
$(function($) {
    $('.<?=$row['pid']?>_subLeve linput[type="checkbox"], .<?=$row['pid']?>_subLevel input[type="radio"], .<?=$row['pid']?>_subLevel input[type="file"]')
        .uniform();
});
</script>