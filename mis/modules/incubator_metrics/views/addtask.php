<script type="text/javascript">
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
		$("#vendorForm").validate();
	});
</script>

<h1><?=$cpagetitle?> </h1>
<!-- start id-form -->
<form name="templateForm" action="<?=site_url('incubator_metrics/wglobal_report/add');?>" method="post" id="vendorForm" >
<dl class="inline">

   <dt><label for="source_type">Task Name <span class="req_field">*</span></label></dt>
    <dd>
	      <input type="text" size="52" name="assignDetails[task_name]" class="input-text required"/>
	</dd>

    <dt><label for="source_type">Target : </label></dt>
    <dd>
	     <input type="text" size="52" name="assignDetails[target]" class="input-text required"/>
     </dd>		
	 
     <dt><label for="source_type">Period/Month :</label></dt>
	 <dd>
	     <input type="text" size="52" name="assignDetails[period]" class="monthYear required" />
	</dd>
	
	 <dt><label for="source_type">Comments :</label></dt>
	 <dd>
	     <textarea cols="50" rows="5" class="input-text" name="assignDetails[comments]"></textarea>
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