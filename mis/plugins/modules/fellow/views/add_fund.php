<script type="text/javascript">
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
		$("#vendorForm").validate();
	});
</script>
<script type="text/javascript">

var BASE_URL = "<?php echo base_url(); ?>";

var SITE_URL = BASE_URL+'index.php/';

function today_date()
{
	var d = new Date();

	var curr_date = d.getDate();

	var curr_month = d.getMonth()+1;

	var curr_year = d.getFullYear();

	var today = curr_date+'/'+curr_month+'/'+curr_year;

	return today;
}

</script>
<?php 
			$formAction = site_url('fellow/add_fund/'.$innovation);  
			$action = 'add';
			
			$lineitem = isset($_REQUEST["lineitem"])?$_REQUEST["lineitem"]:"";
			$amount = isset($_REQUEST["amount"])?$_REQUEST["amount"]:"";
			$start_date = isset($_REQUEST["start_date"])?$_REQUEST["start_date"]:"";
			$to_date = isset($_REQUEST["to_date"])?$_REQUEST["to_date"]:"";
			$remarks= isset($_REQUEST["remarks"])?$_REQUEST["remarks"]:"";
			
     		


?>	
<h1><?=$cpagetitle?> </h1>

<!-- start id-form -->
<form action="<?=$formAction;?>" method="post" enctype="multipart/form-data">  
<input type="hidden" value="<?php echo $innovation;?>" name="innovation" /> 
<input type="hidden" value="<?=$action?>" name="action" />
<dl class="inline">

                <dt><label for="request_key">Program lineitem<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" name="lineitem" class="medium required" size="50" value="<?=$lineitem;?>" />
				</dd>
                
                <dt><label for="request_Date">amount<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
                <input type="text" name="amount" class="medium required" size="50" value="<?=$amount;?>" />
				</dd>
                <dt><label for="request_Date">Start Date<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" size="55" class="input-text   datepicker" name="start_date" value="<?=$start_date;?>"/>
				</dd>
                <dt><label for="request_Date">To Date<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" size="55" class="input-text   datepicker" name="end_date" value="<?=$to_date;?>"/>
				</dd>
                 <dt><label for="request_Date">Remarks<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" name="remarks" class="medium required" size="50" value="<?=$remarks;?>" />
				</dd>
                 
 
      <div class="buttons">
			<input type="submit" name="txtSubmit" value="Send Request" class="button" />
                 <input type="reset" value="Reset" class="button white" />
      </div>
      
</form>

<!-- end id-form  -->