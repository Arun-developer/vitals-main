<?php

$formAction = site_url('master/means_validation/form');
$id = '';
$val = array();
if (count($validationDetails)) {
    $val = $validationDetails['0'];
    $formAction = site_url('master/means_validation/form/' . $val['id']);
    $id = $val['id'];
    $action = 'edit';
} else {
    $action = 'add';
}

if (isset($_POST['action'])) {$val = $_POST;}

$criteria = isset($val["criteria"]) ? $val["criteria"] : "";
$validation = isset($val["validation"]) ? $val["validation"] : "";
$id = isset($val["id"]) ? $val["id"] : "";
?>
<h1><?=$cpagetitle?></h1>
<script type="text/javascript">
		 $(document).ready( function() {
			$.metadata.setType("attr", "validate");
            $("#reportForm").validate();
		  });
		 </script>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>

<!-- start id-form -->
<form name="reportForm" enctype="multipart/form-data" action="<?=$formAction?>" method="post" id="reportForm" >
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" />
<dl class="inline">

       <dt><label for="criteria">Criteria<font class="req_field">*</font></label></dt>
       <dd>
		<select name="criteria" class="required">
		<option value="">Select</option>
		<?php foreach ($criteriaList as $row) {?>
		<option value="<?=$row['id']?>" <?php echo ($criteria == $row['id']) ? ('selected') : (''); ?>><?=$row['master_name']?></option>
		<?php }?>
		</select>
	  </dd>
	   <dt><label for="validation">Validation <font class="req_field">*</font></label></dt>
       <dd>
         <input type="text" value="<?=$validation?>" class="input-text required" size="40" name="validation" />
       </dd>
</dl>
<div class="buttons">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
</div>

</form>

