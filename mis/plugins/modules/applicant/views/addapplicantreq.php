<?php
$formAction = "";
$id = '';

$val = array();
if (count($applicantDetails) > 0) {
    $val = $applicantDetails['0'];
    $formAction = site_url('applicant/form/' . $innovationid . '/' . $val['id']);
    $id = $val['id'];
    $action = 'edit';
    $amount = isset($val['amount']) ? $val['amount'] : "";
    $sector = isset($val['sector']) ? $val['sector'] : "";
    $education = isset($val['education']) ? $val['education'] : "";
    $experience = isset($val['experience']) ? $val['experience'] : "";
    $description = isset($val['description']) ? $val['description'] : "";
} else {
    $formAction = site_url('applicant/form/' . $innovationid);
    $action = 'add';
    $amount = isset($_REQUEST["amount"]) ? $_REQUEST["amount"] : "";
    $sector = isset($_REQUEST["sector"]) ? $_REQUEST["sector"] : "";
    $education = isset($_REQUEST["education"]) ? $_REQUEST["education"] : "";
    $experience = isset($_REQUEST["experience"]) ? $_REQUEST["experience"] : "";
    $description = isset($_REQUEST["description"]) ? $_REQUEST["description"] : "";
}

?>
<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction;?>" method="post" id="addMemberForm" >
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" />
<input type="hidden" value="<?=$innovationid;?>" name="innovationid" />

	<h1><?=$cpagetitle?></h1>
	<fieldset>
		<legend><?=$cpagetitle?></legend>
		<dl class="inline">

			<dt><label for="namesd">Sector</label></dt>
			<dd>
				<input type="text" name="sector" id="sector" class="medium " size="50" value="<?php echo $sector; ?>" />
				<small>Sector</small>
			</dd>

			<dt><label for="namesd">Education</label></dt>
			<dd>
				<input type="text" name="education" id="education" class="medium " size="50" value="<?php echo $education; ?>" />
				<small>Sector</small>
			</dd>

			<dt><label for="namesd">Experience</label></dt>
			<dd>
				<input type="text" name="experience" id="experience" class="medium " size="50" value="<?php echo $experience; ?>" />
				<small>Sector</small>
			</dd>

			<dt><label for="comments">Description</label></dt>
			<dd><textarea  name="description" id="description" class="medium"><?php echo $description; ?></textarea>
			<small> Write requirement description for Applicant</small></dd>
		</dl>
			<div class="buttons">
				<input type="submit" name="txtSubmit" value="Send Request" class="button" />
				<input type="reset" value="Reset" class="button white" />
			</div>
	</fieldset>
</form>

<!-- end id-form  -->