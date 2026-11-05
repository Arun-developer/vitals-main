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
			$formAction = site_url('fellow/job_induction');  
			$action = 'add';
			$program_title = isset($_REQUEST["program_title"])?$_REQUEST["program_title"]:"";
			$program_description = isset($_REQUEST["program_description"])?$_REQUEST["program_description"]:"";
			$mentor = isset($_REQUEST["mentor"])?$_REQUEST["mentor"]:"";
			$start_date = isset($_REQUEST["start_date"])?$_REQUEST["start_date"]:"";
			$to_date = isset($_REQUEST["to_date"])?$_REQUEST["to_date"]:"";
			$indcution_documents= isset($_REQUEST["indcution_documents"])?$_REQUEST["indcution_documents"]:"";
			$reporting_officer = isset($_REQUEST["reporting_officer"])?$_REQUEST["reporting_officer"]:"";
     		


?>	
<h1><?=$cpagetitle?> </h1>

<!-- start id-form -->
<form action="<?=$formAction;?>" method="post" enctype="multipart/form-data">   
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" name="innovation" value="<?=$innovation?>"/>
<dl class="inline">

                <dt><label for="request_key">Program Title<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" name="program_title" class="medium required" size="50" value="<?=$program_title;?>" />
				</dd>
                <dt><label for="request_topic_">Program Description<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<textarea name="program_description" class="medium required"><?=$program_description;?></textarea><small> Brief  Description</small>
				</dd>
                <dt><label for="request_Date">Mentor<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
                <input type="text" name="mentor" class="medium required" size="50" value="<?=$mentor;?>" />
				</dd>
                <dt><label for="request_Date">Reporting Officer<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" name="reporting_officer" class="medium required" size="50" value="<?=$reporting_officer;?>" />
				</dd>
                <dt><label for="request_Date">Start Date<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" size="55" class="input-text   datepicker" name="start_date" value="<?=$start_date;?>"/>
				</dd>
                <dt><label for="request_Date">To Date<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" size="55" class="input-text   datepicker" name="to_date" value="<?=$to_date;?>"/>
				</dd>
                 <dt><label for="profile">Induction Documents:</label></dt>
                 <dd>
                   <input type="file" name="profile" id="profile" />
                
                </dd>
 
      <div class="buttons">
			<input type="submit" name="txtSubmit" value="Send Request" class="button" />
                 <input type="reset" value="Reset" class="button white" />
      </div>
      
</form>

<!-- end id-form  -->