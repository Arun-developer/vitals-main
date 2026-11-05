<?php
$nullLink = "javascript:void(0);";
?>

<h1><?=$cpagetitle?>&nbsp;&nbsp;</h1>
<br />

<form name="frmRepayment" id="frmrepaymentID" enctype="multipart/form-data" action="<?php echo site_url('exit_details/exitdetails/gradingDetails/'.$innovation); ?>" method="post">
	<input type="hidden" name="" value="">
	<?php if(isset($error)) {echo "<span style='color:red;'>".$error."</span>";} ?>
	<fieldset><legend>Exit Details </legend>
	<dl class="inline">
			<dt><label for="source_type">Fund Released : </label></dt>
			<dd>
				<input type="text" name="exit[fund_released]" value="<?=$totalfundreleased;?>"   id="fundReleasedID" />  
			</dd>	
				
			<dt><label for="source_type">Fund Utilized :</label></dt>
			<dd>
				<input type="text" name="exit[fund_utilized]" id="fundUtilizedID" value="<?=$totalfundutilized;?>" class="required">
			</dd>
			<dt><label for="source_type">Exit Status : </label></dt>
			<dd>
				<select name="exit[exitstatus]" id="exitStatusID" value="" >
					<option value="">-Select-</option>
					<option value="1">Successful</option>
					<option value="0">UnSuccessful</option>
				</select>
			</dd>
			<dt><label for="exit_date">Date of Exit :</label></dt>
			<dd>
				<input type="text" name="exit[exit_date]" value="" id="exitDate" class="datepicker required"/>
			</dd>
			<dt><label for="source_type">Reason for exit :</label></dt>
				<dd>
					<textarea name="exit[exit_reason]" cols='40' rows='6' id="exitReasonID" class="required"> </textarea>
				</dd>	
			<dt><label for="source_type">Work done :</label></dt>
				<dd>
					<textarea name="exit[exitwork_description]" id="workDoneID" cols='40' rows='6' class="required"></textarea>
				</dd>
			<dt><label for="source_type">Documents :</label></dt>
				<dd>
					<input type="file" name="documentUpload" id="documentID"/>
					<span> <a href="<?php echo site_url('exit_details/exitdetails/download/');?>"></a> </span>
				</dd>
				
		<div class="buttons1" style="margin-left:330px;margin-top:10px;" >
			<button type="submit" class="button" value="Submit" name="txtSubmit">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="reset" class="button white" value="Reset" name="txtreset">Reset</button>
		</div>
 
		

</dl>
        </fieldset>                     
</form>


<style type="text/css">
dt
{
	width:35% !important;
}
dd
{
	width:65% !important;
}
</style>
<script type="text/javascript"> 
 $(document).ready(function(){
    $("#frmrepaymentID").validate();
  });
  $(".frm_Date").datepicker({
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd',
			changeYear:true,
			onClose: function(dateText, inst) { 
			}	
	});	
  $('#repaymentDate_ID').datepicker({
		showButtonPanel: true,
		changeMonth:true,
		changeYear:true,
		dateFormat: 'yy-mm-dd',
	    onClose: function(dateText, inst) { 
	   		
			if($(this).val()) {
					var fromDate = $("#repaymentFromID").val(); 
					var toDate = $(this).val();
					var format = 'yy/mm/dd';
					var from_data = fromDate.split("-",3);
					var to_data = toDate.split("-",3);
					
				   var getMonthNumber= monthsBetween(new Date(from_data[0],from_data[1],from_data[2]),new Date(to_data[0],to_data[1],to_data[2]));
				   var amount = $("#repayAmount").val();
				   var averageAmount;
				 
				   if(getMonthNumber) {				
						averageAmount =amount/getMonthNumber;
						document.getElementById("avgAmount").value = averageAmount;				
				   }
			}
	   }
	});
	function monthsBetween(date1, date2) {

      var months = date2.getFullYear() * 12 + date2.getMonth() - date1.getFullYear() * 12 - date1.getMonth();
		  if (date2.getDate() < date1.getDate()) {
				months--;
		  }
		
      return months;
	}
</script>
