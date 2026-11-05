<h1><?=$cpagetitle?></h1>
<!-- start id-form -->
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>
<?php
	$subject = $mailTemplate['0']['messagesubject'];
	$body = $mailTemplate['0']['messagebody'];
?>
<form name="templateForm" enctype="multipart/form-data"
    action="<?php echo site_url('repayment/reminderMail/'.$innovationID.'/');?>" method="post" id="templateForm"
    class="uniform">
    <dl class="inline">
        <dt><label for="subject">Message Subject <font class="req_field">*</font></label></dt>
        <dd>
            <input type="text" name="subject" class="input-text  required" size="80" value="<?php echo $subject;?>" />
        </dd>
        <dt><label for="body">Message Body <font class="req_field">*</font></label></dt>
        <dd>
            <textarea name="messegebody" class="input-text" id="editor" style="height:360px;"
                cols="100"><?php  echo $body;?></textarea>
        </dd>
    </dl>
    <div class="buttons">
        <input type="submit" value="Send" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
    </div>
</form>
<!-- end id-form  -->