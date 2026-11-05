<h2><?=$cpagetitle;?></h2>
<form name="templateForm" enctype="multipart/form-data" action="dashboard/mailform" method="post" id="templateForm" class="uniform" >
<input type="hidden" name="action" value="<?=$action?>"  />
<input type="hidden" name="id" value="<?=$id?>"  />
<input type="hidden" name="innovation" value="<?=$innovation['id']?>"  />
<input type="hidden" name="from" value="<?=urldecode($from)?>"  />

<dl class="inline">
        <dt><label for="to">To <font class="req_field">*</font></label></dt>
		<dd>
                    <input type="text" name="to" class="input-text  required" size="80" value="<?=  urldecode($tomail)?>" />
		<?=form_error('subject', '<div class="errortxt">', '</div>');?>
		</dd>
        
        <dt><label for="subject">Message Subject <font class="req_field">*</font></label></dt>
		<dd>
        <input type="text" name="subject" class="input-text  required" size="80" value="" />
		<?=form_error('subject', '<div class="errortxt">', '</div>');?>
		</dd>
        
        <dt><label for="body">Message Body <font class="req_field">*</font></label></dt>
		<dd>
        <textarea name="body" class="input-text" id="editor"  style="height:360px;" cols="100" ></textarea>
		<?=form_error('body', '<div class="errortxt">', '</div>');?>
		</dd>
</dl>
<div class="buttons">
	<input type="submit" value="Send" name="txtSubmit" class="button" />
    <input type="reset" value="Reset" name="txtReset" class="button white" />
</div>	 
</form>