<ul class="option-tab">
<li><a href="<?=site_url('common/mail/history/'.$inno_id);?>" class="button">Back</a></li>
</ul>
<?php 
$inno_id = $this->uri->segment('4');
?>
<h1>Add External Mail</h1>
<!-- start id-form -->
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>
<form name="templateForm" enctype="multipart/form-data" action="<?=site_url('common/mail/add_ext_mail/'.$inno_id.'')?>" method="post" id="templateForm" class="uniform" >
<input type="hidden" name="inno_id" value="<?=$inno_id?>" />
<dl class="inline">
		
        <dt><label for="to">To <font class="req_field">*</font></label></dt>
		<dd>
        <input type="text" name="to" class="input-text email required" size="80" value="" />
		<?=form_error('subject', '<div class="errortxt">', '</div>');?>
		</dd>
        
        <dt><label for="subject">Message Subject <font class="req_field">*</font></label></dt>
		<dd>
        <input type="text" name="subject" class="input-text  required" size="80" value="" />
		<?=form_error('subject', '<div class="errortxt">', '</div>');?>
		</dd>
        
        <dt><label for="body">Message Body</label></dt>
		<dd>
        <textarea name="body" class="input-text" id="editor"  style="height:360px;" cols="100" ></textarea>
		<?=form_error('body', '<div class="errortxt">', '</div>');?>
		</dd>
		
		<dt><label for="subject">Upload <font class="req_field"></font></label></dt>
		<dd>
        <input type="file" name="upload" class="input-text" size="80" value="" />
		<?=form_error('upload', '<div class="errortxt">', '</div>');?>
		</dd>
</dl>
<div class="buttons">
	<input type="submit" value="Save" name="txtSubmit" class="button" />
    <input type="reset" value="Reset" name="txtReset" class="button white" onclick="setTimeout(function(){window.location = '<?php echo $_SERVER["PHP_SELF"] ?>'},500)" />
</div>	 
</form>
<!-- end id-form  -->
