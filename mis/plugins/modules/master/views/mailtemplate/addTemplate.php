<?php
$formAction = site_url('master/mailtemplate/form');
$id = '';
$val = array();
$action = 'add';
if (count($templateDetails)) {
    $val = $templateDetails['0'];
    $id = $val['id'];
    $formAction = $formAction . "/" . $id;
    $action = 'edit';
}
if (isset($_POST['action'])) {$val = $_POST;}
$messagetype = isset($val["messagetype"]) ? $val["messagetype"] : "";
$messagesubject = isset($val["messagesubject"]) ? $val["messagesubject"] : "";
$messagebody = isset($val["messagebody"]) ? $val["messagebody"] : "";
?>
<h1><?=$cpagetitle?></h1>
<!-- start id-form -->
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction?>" method="post" id="templateForm" class="uniform" >
<input type="hidden" name="action" value="<?=$action?>"  />
<input type="hidden" name="id" value="<?=$id?>"  />

<dl class="inline">

	   <dt><label for="message type">Message Type <font class="req_field">*</font> </dt>
	   <dd>
		<input type="text" name="messagetype" <?=($action == 'edit') ? 'readonly' : '';?> class="input-text  required" size="80" value="<?=$messagetype?>" />
		<?=form_error('messagetype', '<div class="errortxt">', '</div>');?>
       </dd>



   <dt><label for="message subject">Message Subject <font class="req_field">*</font> </label></dt>
	<dd>
		<input type="text" name="messagesubject" class="input-text  required" size="80" value="<?=$messagesubject?>" />
		<?=form_error('messagesubject', '<div class="errortxt">', '</div>');?>
	</dd>


   <dt><label for="message body">Message Body <font class="req_field">*</font></label></dt>
	<dd>
		<textarea name="messagebody" class="input-text" id="editor"  style="height:560px;" cols="70" ><?=$messagebody?></textarea>
		<?=form_error('messagebody', '<div class="errortxt">', '</div>');?>
	</dd>

</dl>
<div class="buttons">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
</div>
</form>
<!-- end id-form  -->