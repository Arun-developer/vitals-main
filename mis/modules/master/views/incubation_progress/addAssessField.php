<?php
$formAction = site_url('master/incub_progress_master/assessform/' . $pid);
$id = '';
$val = array();
if (php72_count($assessDetails)) {
    $val = $assessDetails['0'];
    $formAction = site_url('master/incub_progress_master/assessform/' . $pid . '/' . $val['id']);
    $id = $val['id'];
    $action = 'edit';
} else {
    $action = 'add';
}

if (isset($_POST['action'])) {$val = $_POST;}

$label = isset($val["label"]) ? $val["label"] : "";
$input_type = isset($val["input_type"]) ? $val["input_type"] : '';
$value = isset($val["value"]) ? $val["value"] : array();
$required = isset($val["required"]) ? $val["required"] : '';
$class = isset($val["class"]) ? $val["class"] : '';
$order = isset($val["order"]) ? $val["order"] : '';
$id = isset($val["id"]) ? $val["id"] : "";
$inputArray = array('Text', 'Textarea', 'Listbox', 'Radio', 'Checkbox', 'File');
?>
<script type="text/javascript">
		 $(document).ready( function() {
			$.metadata.setType("attr", "validate");
            $("#reportForm").validate();
		  });
		 </script>
<h1><?=$cpagetitle?>&nbsp;-&nbsp;<?=$screeningDetails['0']['label']?></h1>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>

<!-- start id-form -->
<form name="reportForm" enctype="multipart/form-data" action="<?=$formAction?>" method="post" id="reportForm" >
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" />
<input type="hidden" value="<?=$screeningDetails['0']['criteria']?>" name="criteria" />
<input type="text" value="<?=$pid?>" name="pid" />
<dl class="inline">


	   <dt><label for="criteria">Label <font class="req_field">*</font></label></dt>
		<dd>
         <input type="text" value="<?=$label?>" class="input-text required" size="40" name="label" />
        </dd>


	  <dt><label for="input type">Input Type<font class="req_field">*</font></label></dt>
		<dd>
           <select id="input_type" class="required"  name="input_type" >
          		<option value="">Select</option>
				<?php foreach ($inputArray as $key => $typeValue) {?>
                <option value="<?=$typeValue?>" <?php echo ($input_type == $typeValue) ? ('selected') : (''); ?>><?=$typeValue?></option>
                <?php }?>
          </select>
		</dd>


	 <dt><label for="required">Required <font class="req_field">*</font></label></dt>
		<dd>
         <input type="radio" value="yes" name="required" <?php echo ($required == 'yes') ? ('checked') : (''); ?> /> Yes &nbsp;
         <input type="radio" value="no" name="required" <?php echo ($required == 'no' || $required == '') ? ('checked') : (''); ?>/> No
        </dd>


	    <dt><label for="criteria">Class <font class="req_field"></font> </label></dt>
		<dd>
        <input type="text" value="<?=$class?>" class="input-text" size="40" name="class" />
        </dd>

  </dl>
    <?php
if (php72_count($value)) {
    foreach ($value as $in => $val):
    ?>
    <dl class="inline valueField">
	  <dt><label for="values"> <?php if (php72_cmp($in) == 0) {?>Values <font class="req_field">*</font> <?php }?>&nbsp;</label></dt>
		<dd>
         <input type="text" value="<?=$val?>" class="input-text" size="30" name="value[]" />

         <?php if (php72_cmp($in) == 0) {?>
         &nbsp;&nbsp;(<a href="javascript:void(0);" class="addValueRow" style="color:green; text-decoration:none; font-weight:bold" >Add Values</a>)
         <?php } else {?>
         &nbsp;&nbsp;(<a href="javascript:void(0);" class="removeValueRow" style="color:red; text-decoration:none; font-weight:bold" >Remove</a>)
         <?php }?>
        </dd>
	</dl>
    <?php
endforeach;
} else {
    ?>
    <dl style="display:none;" class="inline valueField">
	 <dt><label for="values">Values <font class="req_field">*</font></label> </dt>
		 <dd>
         <input type="text" value="" class="input-text" size="30" name="value[]" />&nbsp;&nbsp;(<a href="javascript:void(0);" class="addValueRow" style="color:green; text-decoration:none; font-weight:bold" >Add Values</a>)
        </dd>
	</dl>
    <?php }?>
<div id="fieldTable"></div>
<div class="buttons">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
</div>
</form>

<!-- end id-form  -->
<div style="display:none">
        <dl class="inline cloneValue">
            <dt>&nbsp;</dt>
            <dd><input type="text" name="value[]" class="input-text" size="30" value="" />&nbsp;&nbsp;
            (<a href="javascript:void(0);" class="removeValueRow" style="color:red; text-decoration:none; font-weight:bold" >Remove</a>)</dd>
        </dl>
 </div>
 <script type="text/javascript">
 		$(document).ready(function(){
			$('.addValueRow').click(function(){
				var arow = $('.cloneValue').clone().removeClass('cloneValue').addClass('valueField');
				$('#fieldTable').append(arow);
			});
			$('.removeValueRow').live('click',function(){
				$(this).parents('dl').remove();
			});
			$("[name='input_type']").change(function(){
				showValueField(this.value);
			});
			if($("[name='input_type']").val() != '')
			{
				val1 = $("[name='input_type']").val();
				showValueField(val1);
			}
			function showValueField(inputValue)
			{
				if(inputValue == 'Listbox' || inputValue == 'Radio' || inputValue == 'Checkbox' )
				{
					$('.valueField').show();
				}
				else
				{
					$('.valueField').hide();
				}
			}

		});

 </script>


