<?php
$formAction = site_url('master/mailtemplate/hrform');
$id = '';
$val = array();
$action = 'add';
if (php72_count($templateDetails)) {
    $val = $templateDetails['0'];
    $id = $val['id'];
    $message = $val['message'];
    $formAction = $formAction . "/" . $id;
    $action = 'edit';
}
if (isset($_POST['action'])) {$val = $_POST;}
$id = isset($val["id"]) ? $val["id"] : "";
$days = isset($val["days"]) ? $val["days"] : "";
$message = isset($val["message"]) ? $val["message"] : "";
?>
<h1><?=$cpagetitle?></h1>
<!-- start id-form -->
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>
<div align="right"><a href="<?=site_url('master/mailtemplate')?>" class="button">Back</a></div>
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction?>" method="post" id="templateForm" class="uniform" >
<input type="hidden" name="action" value="<?=$action?>"  />
<input type="hidden" name="id" value="<?=$id?>"  />

<dl class="inline">

   <dt><label for="message body">Message<font class="req_field">*</font></label></dt>
	<dd>
		<textarea name="message" class="input-text" id="editor"  style="height:100px;"><?=$message?></textarea>
		<?=form_error('messagebody', '<div class="errortxt">', '</div>');?>
	</dd>

</dl>
<div class="buttons">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
</div>
</form>
<!-- end id-form  -->