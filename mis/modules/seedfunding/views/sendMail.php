<?php
$formAction = site_url('seedfunding/mail_form/' . $innovation['id']);
$id = '';
$val = array();
$action = 'Send';
if (count($mailDetails)) {
    $val = $mailDetails['0'];
    $id = $val['id'];
    $formAction = $formAction . "/" . $id;
    $action = 'Resend';
}
if (isset($_POST['action'])) {$val = $_POST;}
$subject = isset($val["subject"]) ? $val["subject"] : "";
$mail_type = isset($val["mail_type"]) ? $val["mail_type"] : "";
$body = isset($val["body"]) ? $val["body"] : "";
$to = isset($val["to"]) ? $val["to"] : $innovation['email_id'];
$from = isset($val["from"]) ? $val["from"] : "";

if (isset($_POST['mail_type'])) {
    $mailContent = $this->Mmail->getMailContent($innovation['id'], $_POST['mail_type']);
    if (count($mailContent)) {
        $subject = $mailContent['subject'];
        $body = $mailContent['body'];
        $from = $mailContent['from'];
    }
}
?>
<ul class="option-tab">
    <li><a href="<?=site_url('seedfunding/view/' . $innovation['id']);?>" class="button">Back</a></li>
</ul>

<h1><?=$cpagetitle?></h1>
<!-- start id-form -->
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction?>" method="post" id="templateForm"
    class="uniform">
    <input type="hidden" name="action" value="<?=$action?>" />
    <input type="hidden" name="id" value="<?=$id?>" />
    <input type="hidden" name="innovation" value="<?=$innovation['id']?>" />
    <input type="hidden" name="from" value="<?=$from?>" />

    <dl class="inline">
        <dt><label for="to">To <font class="req_field">*</font></label></dt>
        <dd>
            <input type="text" name="to" class="input-text  required" size="80" value="<?="admin@villgro.org";?>" />
            <?=form_error('subject', '<div class="errortxt">', '</div>');?>
        </dd>

        <dt><label for="subject">Message Subject <font class="req_field">*</font></label></dt>
        <dd>
            <input type="text" name="subject" class="input-text  required" size="80" value="<?=$subject?>" />
            <?=form_error('subject', '<div class="errortxt">', '</div>');?>
        </dd>

        <dt><label for="body">Message Body</label></dt>
        <dd>
            <textarea name="body" class="input-text" id="editor" style="height:360px;" cols="100"><?=$body?></textarea>
            <?=form_error('body', '<div class="errortxt">', '</div>');?>
        </dd>
    </dl>
    <div class="buttons">
        <input type="submit" value="<?=$action?>" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
    </div>
</form>
<!-- end id-form  -->