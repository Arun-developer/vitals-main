<?php
$formAction = site_url('master/checklist/form');
$id = '';
$val = array();
if (php72_count($checklistDetails)) {
    $val = $checklistDetails['0'];
    $formAction = site_url('master/checklist/form/' . $val['id']);
    $id = $val['id'];
    $action = 'edit';
} else {
    $action = 'add';
}

if (isset($_POST['action'])) {$val = $_POST;}

$area = isset($val["area"]) ? $val["area"] : "";
$document_description = isset($val["document_description"]) ? $val["document_description"] : "";
$id = isset($val["id"]) ? $val["id"] : "";
?>
<h1><?=$cpagetitle?></h1>
<script type="text/javascript">
		 $(document).ready( function() {
			$.metadata.setType("attr", "validate");
            $("#checklistForm").validate();
		  });
		 </script>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>

<!-- start id-form -->
<form name="checklistForm"  action="<?=$formAction?>" method="post" id="checklistForm" >
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" />
<dl class="inline">
 		<dt><label for="area">Area/Origin<font class="req_field">*</font></label></dt>
		<dd>
		<select name="area" class="required" style="width:200px;">
		<option value="">Select</option>
		<?php foreach ($areaList as $row) {?>
		<option value="<?=$row['id']?>" <?php echo ($area == $row['id']) ? ('selected') : (''); ?>><?=$row['master_name']?></option>
		<?php }?>
		</select>
		</dd>
	   <dt><label for="area">Document Descripton<font class="req_field">*</font></label></dt>
	   <dd>
        <textarea name="document_description" class="input-text required" rows="5" cols="50"><?=$document_description?></textarea>
       </dd>
</dl>

<div class="buttons">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
<div>
</form>

