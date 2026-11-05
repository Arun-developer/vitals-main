<?php
		$formAction = site_url('screening/editagreement/');
		$id = '';
		$val = array();
		$action = 'Send';
?>
<ul class="option-tab">
    <li><a href="<?=site_url('screening/view/');?>" class="button">Back</a></li>
</ul>

<h1><?=$cpagetitle?></h1>
<!-- start id-form -->
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction?>" method="post" id="templateForm"
    class="uniform">
    <input type="hidden" name="action" value="<?=$action?>" />
    <input type="hidden" name="id" value="<?=$id?>" />

    <dl class="inline">
        <dt><label for="name">User<font class="req_field">*</font></label></dt>
        <dd>
            <input type="text" name="username" value="<?php echo $username;?>" />
        </dd>
        <dt><label for="body">Message Body <font class="req_field">*</font></label></dt>
        <dd>
            <textarea name="body" class="input-text" id="editor" style="height:360px;"
                cols="100"><?=$contents?></textarea>
            <?=form_error('body', '<div class="errortxt">', '</div>');?>
        </dd>
    </dl>
    <div class="buttons">
        <input type="submit" value="<?=$action?>" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
    </div>
</form>
<!-- end id-form  -->