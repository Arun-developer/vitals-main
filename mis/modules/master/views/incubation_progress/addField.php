<?php

$formAction = site_url('master/incub_progress_master/form');
$id = '';
$val = array();
if (php72_count($screeningDetails)) {
    $val = $screeningDetails['0'];
    $formAction = site_url('master/incub_progress_master/form/' . $val['id']);
    $id = $val['id'];
    $action = 'edit';
} else {
    $action = 'add';
}

if (isset($_POST['action'])) {$val = $_POST;}

$criteria = isset($val["mastertype"]) ? $val["mastertype"] : "";
$sel_criteria = isset($val["sel_criteria"]) ? $val["sel_criteria"] : "";
$period = isset($val["period"]) ? $val["period"] : "";
$label = isset($val["label"]) ? $val["label"] : "";
$input_type = isset($val["input_type"]) ? $val["input_type"] : '';
$info = isset($val["info"]) ? $val["info"] : '';
$value = isset($val["value"]) ? $val["value"] : array();
$subcategory = isset($val["subcategory"]) ? $val["subcategory"] : '';
$required = isset($val["required"]) ? $val["required"] : '';
$class = isset($val["class"]) ? $val["class"] : '';
$order = isset($val["order"]) ? $val["order"] : '';
$id = isset($val["id"]) ? $val["id"] : "";
$inputArray = array('Text', 'Textarea', 'Listbox', 'Radio', 'Checkbox', 'File', 'Group');

?>

<h2><?=$cpagetitle?></h2>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>
<!-- start id-form -->
<form name="reportForm" enctype="multipart/form-data" action="<?=$formAction?>" method="post" id="reportForm"  >
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" />
<dl class="inline">
       <dt><label for="criteria">Master Type<font class="req_field">*</font></label></dt>
       <dd>
	       <select name="mastertype" id="sel_mastertype" onchange="change(this.value);">
			<option value="">Select</option>
			    <?php $countCriteria = php72_count($mastertype);

foreach ($mastertype as $mymastertype) {
    ?>
			<option value="<?=$mymastertype['master_type'];?>" <?=($criteria == $mymastertype['master_type']) ? 'selected' : '';?> ><?php echo $mymastertype['master_type']; ?></option>
		    <?php }?>
			</select>
	 </dd>
     <dt><label for="criteria">Criteria<font class="req_field">*</font></label></dt>
     <dd>
            <select name="criteria" id="sel_criteriaadd" >
			</select>
	 </dd>
	 <dt><label for="subcategory">Subcategory <font class="req_field"></font> </label></dt>
      <dd>
       <input type="text" value="<?=$subcategory;?>" class="input-text" size="30" name="subcategory" />
     </dd>
	 <dt><label class="fontStyle"> Frequency<font class="req_field">*</font></label></dt>
	 <dd>

			<select name="period" class="required">
				<option value="">Select</option>
				     <?php
foreach ($criteriaList as $option => $valueID) {
    ?>
				<option value="<?php echo $option; ?>" <?=($period == $option) ? 'selected' : '';?>><?php echo $valueID; ?></option>
			         <?php }?>
			</select>
	 </dd>
	  <dt><label for="criteria">Label <font class="req_field">*</font></label></dt>
		<dd>
         <input type="text" value="<?=$label?>" class="input-text required" size="30" name="label" />
        </dd>
	   <dt><label for="input type">Input Type<font class="req_field">*</font></label></dt>
		<dd>
           <select id="input_type" class="required"  name="input_type" >
          		<option value="">Select</option>
				<?php foreach ($inputArray as $key => $typeValue) {echo $input_type;?>
                <option value="<?=$typeValue?>" <?php echo ($input_type == $typeValue) ? ('selected') : (''); ?>><?=$typeValue?></option>
                <?php }?>
          </select>
		</dd>

		 <dt><label for="info">Info<font class="req_field">*</font></label></dt>
			<dd><textarea name="info"><?php echo $info; ?></textarea></dd>
	    <dt><label for="required">Required <font class="req_field">*</font></label></dt>
		<dd>
         <input type="radio" value="yes" name="required" <?php echo ($required == 'yes') ? ('checked') : (''); ?> /> Yes &nbsp;
         <input type="radio" value="no" name="required" <?php echo ($required == 'no' || $required == '') ? ('checked') : (''); ?>/> No
        </dd>


	    <dt><label for="class">Class <font class="req_field"></font> </label></dt>
		<dd>
        <input type="text" value="<?=$class?>" class="input-text" size="30" name="class" />
        </dd>
</dl>
    <?php

if (($value)) {
    foreach ($value as $in => $val):
    ?>
    <dl class="inline">
	    <dt><label for="values"><?php if (php72_cmp($in) == 0) {?>Values <font class="req_field">*</font> <?php }?>&nbsp;</label></dt>
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
   <dl class="inline valueField" style="display:none;">
	    <dt><label for="values">Values <font class="req_field">*</font> </label></dt>
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
<div  style="display:none">
<dl class="inline cloneValue">
            <dt>&nbsp;</dt>
            <dd><input type="text" name="value[]" class="input-text" size="30" value="" />&nbsp;&nbsp;
            (<a href="javascript:void(0);" class="removeValueRow" style="color:red; text-decoration:none; font-weight:bold" >Remove</a>)</dd>
</dl>
    </div>
 <script type="text/javascript">
 		 function change(value)
		 {
			var mastertype=value;
			 var datas = $.ajax({
				type: "POST",
				url: "<?php echo site_url('master/incub_progress_master/view_list'); ?>",
				data: {'mastertypes':mastertype,'isajax':true},
				dataType:'json',
				success: function(datas) {
						var m = populateSelectbox(datas);

						$('#sel_criteriaadd').find('option').remove().end().append(m);
				}
						});
		 }

		 function populateSelectbox(optArray)
		 { 
			var option = '';
			$.each(optArray,function(i,value){
				option +='<option value="'+optArray[i].id+'">'+optArray[i].master_name+'</option>';
			});
			return option;
		 }

		 var master = $('#sel_mastertype').val();
		 if(master){
			change(master);
		 }


 		$(document).ready(function(){

		$.metadata.setType("attr", "validate");
		$("#reportForm").validate();


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

				$( ".weekDate" ).datepicker({
					changeMonth: true,
					changeYear: true,
					changeWeek : true,
					showButtonPanel: true,
					dateFormat: 'DD',

					onClose: function(dateText, inst) {
						var week = $("#ui-datepicker-div .ui-datepicker-week :selected").val();
						var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
						var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
						$(this).datepicker('setDate', new Date(week,month,year,1));
					}
				});

				$( ".monthYear" ).datepicker({
					changeMonth: true,
					changeYear: true,
					showButtonPanel: true,
					dateFormat: 'MM yy',

					onClose: function(dateText, inst) {

						var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
						var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
						$(this).datepicker('setDate', new Date(year, month, 1));
					}
				});

				$( ".yearReport" ).datepicker({
					changeYear: true,
					showButtonPanel: true,
					dateFormat: 'yy',

					onClose: function(dateText, inst) {
						var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
						var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
						$(this).datepicker('setDate', new Date(year,1));
					}
				});


			$("#weekdateID").hide();
			$("#monthdateID").hide();
			$("#yeardateID").hide();

			});
 </script>
