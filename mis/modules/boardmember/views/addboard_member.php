<script type="text/javascript">
$(document).ready( function() {
	$.metadata.setType("attr", "validate");
	$("#addBoard").validate();
});

</script>


<?php
$formAction = "";
$id = '';

$val = array();
if (php72_count($memberDetails) > 0) {
    $val = $memberDetails['0'];
    $formAction = site_url('boardmember/form/' . $innovationid . '/' . $val['id']);
    $id = $val['id'];
    $action = 'edit';
    $boardmemberno = isset($val['no_boardmember']) ? $val['no_boardmember'] : "";
    $qualification = isset($val['qualification']) ? $val['qualification'] : "";
    $description = isset($val['description']) ? $val['description'] : "";
    $functional = isset($val['functionalarea']) ? $val['functionalarea'] : "";
} else {
    $formAction = site_url('boardmember/form/' . $innovationid);
    $action = 'add';
    $boardmemberno = isset($_REQUEST["boardmemeberno"]) ? $_REQUEST["boardmemeberno"] : "";
    $qualification = isset($_REQUEST["qulification"]) ? $_REQUEST["qualification"] : "";
    $description = isset($_REQUEST["description"]) ? $_REQUEST["description"] : "";
    $functional = isset($_REQUEST["functionalarea"]) ? $_REQUEST["functionalarea"] : "";
}

?>
<!-- start id-form -->
<form name="addBoard" id="addBoard" enctype="multipart/form-data" action="<?=$formAction;?>" method="post" >
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" />
<input type="hidden" value="<?=$innovationid?>" name="innovationid" />


	<h1><?=$cpagetitle?></h1>
	<fieldset>
	<legend><?=$cpagetitle?></legend>
	<dl class="inline">

             	<dt><label for="namesd">No of Member<font class="req_field">*</font></label></dt>
				<dd>
					<input type="text" name="boardmemberno" id="boardmemberno"   size="50" value="<?php echo $boardmemberno; ?>" class="input-text required" />
			   </dd>

               <dt><label for="namesd">Area of Expertise<font class="req_field">*</font></label></dt>
				<dd>
					<input type="text" name="qualification" id="qualification"  size="50" value="<?php echo $qualification; ?>" class="input-text required" />
			   </dd>

                <dt>
					<label for="comments">Desired Profile<font class="req_field">*</font></label></dt>
					<dd><textarea  name="description" id="description" class="input-text required"  cols="53" rows="6" ><?php echo $description; ?></textarea>
					<small> Write requirement description for board member</small>
			    </dd>
				<dt>
					<label for="comments">Functional Area<font class="req_field"></font></label></dt>
					<dd><input type="text" name="functionalarea" id="functionalarea"  size="50" value="<?php echo $functional; ?>" />
					<small> Which Functional Area do you work in</small>
			    </dd>


      </dl>
			    <div class="buttons">
			     <input type="submit" name="txtSubmit" value="Send Request" class="button" />
                 <input type="reset" value="Reset" class="button white" />
               </div>
			</fieldset>
</form>

<!-- end id-form  -->