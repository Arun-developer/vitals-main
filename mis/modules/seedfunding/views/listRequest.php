<?php
$formAction = site_url('seedfunding/liststatus/approve/' . $innovationid);
$id = '';
$val = array();
$action = 'Send';
if (php72_count(@$mailDetails)) {
    $val = @$mailDetails['0'];
    $id = $val['id'];
    $formAction = $formAction . "/" . $id;
    $action = 'Resend';
}

$subject = isset($val["subject"]) ? $val["subject"] : "";
$documents = isset($val["documents"]) ? $val["documents"] : "";
$body = isset($val["body"]) ? $val["body"] : "";
$to = isset($val["to"]) ? $val["to"] : $innovation['email_id'];
$from = isset($val["from"]) ? $val["from"] : "";
?>
<h1><?=$cpagetitle?></h1>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<section id="main" style="height:200px !important;">
    <form id="rejectrequestform" action="<?=$formAction;?>" class="uniform" method="post">
        <?php $editrequest_status=1; ?>
        <input type="hidden" name="innovationid" value="<?=$innovationid;?>" />
        <input type="hidden" name="editrequest_status" value="<?=$editrequest_status;?>" />
        <input type="hidden" name="olddocument" value="<?=$documents?>" />
        <input type="hidden" name="from" value="<?=$from?>" />
        <dl class="inline">

            <dt><label for="to">To <font class="req_field">*</font></label></dt>
            <dd>
                <input type="text" name="to" class="input-text  required" size="80" value="<?=$to;?>" />
                <?=form_error('subject', '<div class="errortxt">', '</div>');?>
            </dd>
            <dt><label for="subject">Message Subject <font class="req_field">*</font></label></dt>
            <dd>
                <input type="text" name="subject" class="input-text  required" size="60" value="<?="Approved"?>" />
                <?=form_error('subject', '<div class="errortxt">', '</div>');?>
            </dd>

            <dt><label for="body">Message Body <font class="req_field">*</font></label></dt>
            <dd>
                <textarea name="body" class="input-text" id="editor" style="height:200px;"
                    cols="60"><?=$body?></textarea>
                <?=form_error('body', '<div class="errortxt">', '</div>');?>
            </dd>

            <dt><label for="name">Documents</label></dt>
            <dd><input type="file" name="documents" />
                <?php if ($documents != '') {?>
                <a href="/ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/assessment/<?=$documents?>"
                    class="button">view</a>
                <?php }?></dd>
        </dl>
        <div class="clear"></div>
        <div class="buttons">
            <input type="submit" value="<?=$action?> Details" name="approveSubmit" class="button" />
            <input type="reset" value="Reset" name="txtReset" class="button white" />
        </div>
    </form>

</section>