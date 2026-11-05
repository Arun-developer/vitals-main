<script type="text/javascript">
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
		$("#vendorForm").validate();
	});
</script>

<h1><?=$cpagetitle?> </h1>
<!-- start id-form -->
<form name="templateForm" action="<?=site_url('incubator_metrics/wglobal_report/edit/');?>" method="post" id="vendorForm" >
<?php 
	if(count($taskDetails)>0)
	{
			 $tskDetails=$taskDetails[0];
			 $taskName=$tskDetails['task_name'];
			 $target=$tskDetails['target'];
			 $period= $taskDetails['period'];
			 $comments=$tskDetails['comments'];
	}

?>

 <input type="hidden" value="<?php echo $incubeteeID; ?>" name="incubeteeid" id="incubeteeid"/>
<dl class="inline">

   <dt><label for="source_type">Task Name <span class="req_field">*</span></label></dt>
    <dd>
	      <input type="text" size="52" name="editDetails[task_name]" value="<?=$taskName ?>" class="input-text required"/>

	</dd>

   

    <dt><label for="source_type">Target : </label></dt>
    <dd>
	     <input type="text" size="52" name="editDetails[target]" value="<?=$target ?>" class="input-text required"/>
     </dd>		
	 
	 
     <dt><label for="source_type">Period/Month :</label></dt>
	 <dd>
	     <input type="text" size="52" name="editDetails[period]" class="monthYear required" value="<?=$period?>" />
	</dd>
	
	
	
	 <dt><label for="source_type">Comments :</label></dt>
	
	 <dd>
	     <textarea cols="50" rows="5" class="input-text" name="editDetails[comments]"><?=$comments?></textarea>
	</dd>
	
	
	<div class="buttons">
	 <input class="button" type="submit" name="txtSubmit"value="Save">
	 <input class="button white" type="reset" value="Reset">
	</div>

</dl>
</form>
<!-- end id-form  -->

<script type="text/javascript">

 $(function() {
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
				
			});




</script>