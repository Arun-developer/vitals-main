<?php
$val = array();
if (php72_count($presentationInfo)) {

    $action = 'Update';
    $val = $presentationInfo['0'];} else {
    $action = 'add';
}
if (isset($_POST['id'])) {$val = $_POST;}
$description = isset($val["description"]) ? $val["description"] : "";
$document = isset($val["document"]) ? $val["document"] : "";
$id = isset($val["id"]) ? $val["id"] : "";
?>

<ul class="option-tab">
    <li><a href="<?=site_url('presentation/view/' . $innovation['id'])?>" class="button">Back</a></li>
</ul>

<h1><?=$cpagetitle?> - <?=$innovation['name_of_enterprise']?></h1>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<form name="presentationForm" enctype="multipart/form-data"
    action="<?=site_url('presentation/form/' . $innovation['id'])?>" method="post" id="presentationForm"
    class="uniform">
    <input type="hidden" name="id" value="<?=$id?>" />
    <input type="hidden" name="olddocument" value="<?=$document?>" />
    <dl class="inline">
        <dt><label for="name">Document Description</label></dt>
        <dd><input type="text" name="document_description" /></dd>

        <dt><label for="name">Document</label></dt>
        <dd><input type="file" name="document" />
            <?php if ($document != '') {?>
            <?=$document?>&nbsp;<a href="<?=base_url()?>uploads/presentation/<?=$document?>" target="_blank"
                class="button">View / Download</a>
            <?php }?></dd>

        <dt><label for="name"><?=($innovation['isAssociate']) ? 'Minutes of meeting' : 'Comments';?><span
                    class="req_field">*</span></label></dt>
        <dd><textarea name="description" id="editor" class="input-text" rows="20" cols="80"><?=$description?></textarea>
            <?=form_error('description', '<div class="req_field">', '<div>');?></dd>
    </dl>
    <div class="clear"></div>
    <div class="buttons">
        <input type="submit" value="<?=ucfirst($action)?> Details" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
    </div>
</form>