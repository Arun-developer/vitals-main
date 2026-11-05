<script type="text/javascript">
	$(document).ready(function(){
		$('#addBudgetRow').click(function(){
			var arow = $('.cloneBudget').clone().removeClass('cloneBudget').addClass('odd');
			$('#milestoneTable').append(arow);
			ordering('sNo');
		$('.datepicker').attr('id','');
		$('.datepicker').removeClass('hasDatepicker').datepicker();
		$('#addcompanyrow').click(function(){

		var arow = $('.clonetable').clone().removeClass('clonetable').addClass('even');
			$("#clonetable").show();
			$('#cloneID').append(arow);
		$('.datepicker').attr('id','');
		$('.datepicker').removeClass('hasDatepicker').datepicker();
			ordering('sNo');
		});
		});

		<?php if (count($screeningDetails) == 0) {?>
			var arow = $('.cloneBudget').clone().removeClass('cloneBudget').addClass('odd');
			$('#milestoneTable').append(arow);
			ordering('sNo');
		<?php }?>

		$('.removeBudgetRow').live('click',function(){
			$(this).parents('tr').remove();
			ordering('sNo');
		});

		$('.removeCompanyRow').live('click',function(){
			$(this).parents('tr').remove();
			ordering('sNo');
		});
		$(function() {
				$( ".datepicker" ).datepicker({
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
			});
		function ordering(parent)
		{
			var d=1;
			$('.'+parent).each(function(){
				$(this).html(d);
				++d;
			});
		}
		$('.removeBudgetList').live('click',function(){
			var milestoneId = $(this).attr('id');
			var delRow = $(this).parents('tr');
			jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
				if(r)
				{
					var form_data = {
						milestoneId: milestoneId,
						ajax: '4'
					};
				}
			});
		});
	});
	</script>
<?php

$formAction = site_url('assign_incubation/form2');
$id = '';
$val = array();

if (count($screeningDetails)) {
    $val = $screeningDetails['0'];
    $formAction = site_url('assign_incubation/form2/' . $val['id']);
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
$value = isset($val["value"]) ? $val["value"] : array();
$required = isset($val["required"]) ? $val["required"] : '';
$class = isset($val["class"]) ? $val["class"] : '';
$order = isset($val["order"]) ? $val["order"] : '';
$id = isset($val["id"]) ? $val["id"] : "";
$inputArray = array('Text', 'Textarea', 'Listbox', 'Radio', 'Checkbox', 'File', 'Group');

?>
 <div class="msg" style="display:none"></div>
<h2><?=$cpagetitle?></h2>
<ul class="tabs">
<li><a href="<?=site_url('master/incub_progress_master/form')?>">IRIS Metrics</a></li>
<li class="selected"><a href="<?=site_url('master/incub_progress_master/form2')?>">Activity</a></li>
</ul>
<form id="milestoneList" action="<?=$formAction?>" method="post" name="milestoneList">

	<table class="gtable sortable" style="width:600px;">
	<thead>
		<tr>
        	<th>S.No.</th>
			<th>Master Type</th>
            <th>Master Name</th>
			<th>Frequency</th>
			<th>Assigned To</th>
			<th>Label</th>
			<th>options</th>
		</tr>


	</thead>
	<tbody id="milestoneTable">
	</tbody>
	</table>
	<!-- Paging style --><br />
    <a href="javascript:void(0);" id="addBudgetRow" class="button black" style="float:right" >Add Row</a>
    <table class="gtable detailtable">
 	<tr>
		<td width="30%" align="right" valign="top">&nbsp;</td>
		<td valign="top">
			<input type="submit" value="Save" name="txtSubmit" class="button" />
			<input type="reset" value="Reset" name="txtReset" class="button white" />
		</td>
	</tr>
	</table>
	</form>
    <table style="display:none">
    <tr class="cloneBudget">
    <td align="left" valign="middle" class="sNo">
    </td>
	 <td align="left" valign="middle" width="100">
	 <input type="hidden" name="id[]" value="" />
	 <input type="hidden" name="innovation[]" value="<?=$innovation?>"/>
		<select name="mastertype[]"  id="sel_mastertype" onchange="change(this);">
				<option value="">Select</option>
				    <?php $countCriteria = count($mastertype);
foreach ($mastertype as $mymastertype) {
    ?>
				<option value="<?=$mymastertype['master_type'];?>" <?=($mymastertype['master_type'] == $mymastertype['master_type']) ? 'selected' : '';?> ><?php echo $mymastertype['master_type']; ?></option>
			        <?php }?>
			</select>
	</td>
	<td align="left" valign="middle" width="100" >
		<select name="subcriteria[]" class="sel_criteriaadd" class="required" >
				<option value="">Select</option>
				</select>
	</td>
     <td align="left" valign="middle" width="100">
        <select name="period[]">
				<option value="">Select</option>
				     <?php foreach ($criteriaList as $option => $valueID) {?>
				<option value="<?php echo $option; ?>" <?=($period == $option) ? 'selected' : '';?>><?php echo $valueID; ?></option>
			         <?php }?>
			</select>
</td>
		  <td>
             <select id="assign"  name="assigned[]" >
             <option value="">-Select-</option>
             <?php
foreach ($fellowList as $row1) {
    ?>
                <option value="<?=$row1['emp_number']?>" >
                <?=$row1['emp_firstname']?></option>
                <?php }?>
             </select>
		  </td>
		   <td><input type="text" name="label[]" value="" size="30" />
		  </td>
             <td align="left" valign="middle"> <a href="javascript:void(0);" class="removeBudgetRow" ><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
			</td>
			</tr>
     </table>
 <script>
 function change(obj)
		 {
			var t = $(this).nextAll('select').find('.sel_criteriaadd').attr('class');
			var mastertype = obj.value;
			 var datas = $.ajax({
				type: "POST",
				url: "<?php echo site_url('assign_incubation/form2'); ?>",
				data: {'mastertypes':mastertype,'isajax':true},
				dataType:'json',
				success: function(datas) {
						var m = populateSelectbox(datas);
						$(obj).parents('tr').find('.sel_criteriaadd').html(m);
				}
			});
		 }

		 function populateSelectbox(optArray)
		 {
			var option = '<option value="">Select</option>';
			$.each(optArray,function(i,value){
				option +='<option value="'+optArray[i].id+'">'+optArray[i].master_name+'</option>';
			});
			return option;
		 }
 </script>