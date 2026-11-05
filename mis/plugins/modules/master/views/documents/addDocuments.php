<?php
$formAction = site_url('master/documents/form/' . $activity_id);
$id = '';
$val = array();
$document = '';
if (count($documentsDetails)) {
    $val = $documentsDetails['0'];
    $formAction = $formAction . '/' . $val['id'];
    $id = $val['id'];
    $action = 'edit';
    $document = $documentsDetails['0']['document'];
} else {
    $action = 'add';
}

if (isset($_POST['action'])) {$val = $_POST;}

$document = isset($_POST["pre_document"]) ? $_POST["pre_document"] : $document;
$tag = isset($val["tag"]) ? $val["tag"] : "";

?>
<script type="text/javascript">
		 $(document).ready( function() {
        	 $('.uniform input[type="checkbox"], .uniform input[type="radio"], .uniform input[type="file"]').uniform();
		 });
</script>
<h2><?=$cpagetitle?></h2>
<!-- start id-form -->
<form name="documentForm" enctype="multipart/form-data" action="<?=$formAction?>" method="post" id="documentForm" class="uniform" >
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" />
<input type="hidden" value="<?=$activity_id?>" name="field" />
<dl class="inline">
<dt><label for="">document<font class="req_field">*</font></label> </dt>
<dd>
	<input type="file" name="document[]" multiple="multiple" class="required" />
        <?php if ($document != '') {echo '<br/> ' . $document;?>
           <a href="<?php echo base_url() . "uploads/documents/" . $document; ?>"  target="_blank" >&nbsp;&nbsp;<img src="<?=base_url();?>source/template/images/icons/download.gif" height="20"  /></a>
            <?php }?>
</dd>
<dt><label for="tag">Tags</label></dt>
<dd><textarea class="input-text" cols="30" rows="6" name="tag"><?=$tag?></textarea></dd>
</dl>
<div class="buttons">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
</div>
</form>

<!-- end id-form  -->



