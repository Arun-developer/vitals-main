<script type="text/javascript">
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
		$("#vendorForm").validate();
	});
</script>
 <script type="text/javascript">
             $(function() {
                $( ".monthYear" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    dateFormat: 'MM yy',
                    onClose: function(dateText, inst) { 
						var date = $("#ui-datepicker-div .ui-datepicker-date :selected").val();
                        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                        $(this).datepicker('setDate', new Date(year, month));
                    }
                });
                
            });
        </script>
		<script>
	$(function() {
		$( ".datepicker" ).datepicker();
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
 $formAction = "";

		$innovator_name = $this->session->userdata('user_name');
		$val = array();
		if(php72_count($applicantDetails)>0)
		{  
			$formAction = site_url('fellow/form/'.$innovationid.'/'.$id);
			$action = 'edit';
			$val = $applicantDetails['0'];
			$id = $val['id'];
			$innovator_name = isset($val["innovator_name"])?$val["innovator_name"]:"";
			$request_key = isset($val["request_key"])?$val["request_key"]:"";
			$request_date = isset($val["request_date"])?$val["request_date"]:"";
			$from_period = isset($val["from_period"])?$val["from_period"]:"";
			$to_period = isset($val["to_period"])?$val["to_period"]:"";
			$job_description = isset($val["job_description"])?$val["job_description"]:"";
			
		}
		else
		{
			$key = $request_key[0]['request_key'];
			$formAction = site_url('fellow/form/'.$innovationid);  
			$action = 'add';
			$innovator_name = isset($_REQUEST["innovator_name"])?$_REQUEST["innovator_name"]:"";
			$request_key = isset($_REQUEST["request_key"])?$_REQUEST["request_key"]:"";
			$request_date = isset($_REQUEST["request_date"])?$_REQUEST["request_date"]:"";
			$from_period = isset($_REQUEST["from_period"])?$_REQUEST["from_period"]:"";
			$to_period = isset($_REQUEST["to_period"])?$_REQUEST["to_period"]:"";
			$profile= isset($_REQUEST["profile"])?$_REQUEST["profile"]:"";
			$job_description = isset($_REQUEST["job_description"])?$_REQUEST["job_description"]:"";
     		
		}

?>	
<h1><?=$cpagetitle?> </h1>

<!-- start id-form -->
<form action="<?=$formAction;?>" method="post" enctype="multipart/form-data">   
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" /> 
<input type="hidden" value="<?=$innovationid; ?>" name="innovationid" />
<dl class="inline">
<?php
if($action == "add")
{
if(empty($key))
{
	$request_key = "job".'001';
}
else
{  
	$num = substr($key,3);
	$cnt = strlen($num);
	$num++;
	$num1 = str_pad($num,$cnt,0,STR_PAD_LEFT);
	$request_key = "job".$num1;

}
}
?>
                <dt><label for="request_key">Request Key<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" name="request_key" class="medium required" size="50" value="<?=$request_key;?>" readonly="readonly" />
				</dd>
                <dt><label for="request_topic_">Innovator Name <span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" name="innovator_name" class="medium required" size="50" value="<?=$this->session->userdata('user_name');?>" readonly="readonly" />
				</dd>
                <dt><label for="request_Date">Request Date<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" size="55" class="datepicker" name="request_date" value="<?=$request_date;?>"/>
				</dd>
                <dt><label for="request_Date">From Period<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" size="55" class="datepicker" name="from_period" value="<?=$from_period;?>"/>
				</dd>
                <dt><label for="request_Date">To Period<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" size="55" class="datepicker" name="to_period" value="<?=$to_period;?>"/>
				</dd>
               <dt><label for="description">Description</label></dt>
               <dd><textarea name="job_description" class="medium"><?=$job_description;?></textarea><small> Brief  Description</small>
               </dd>
               
      <div class="buttons">
			<input type="submit" name="txtSubmit" value="Send Request" class="button" />
                 <input type="reset" value="Reset" class="button white" />
      </div>
      
</form>

<!-- end id-form  -->