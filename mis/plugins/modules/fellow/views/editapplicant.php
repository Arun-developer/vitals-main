<script type="text/javascript">
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
		$("#vendorForm").validate();
	});
</script>
<script type="text/javascript">

var BASE_URL = 'http://localhost/mis/';

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
		if(count($applicantDetails)>0)
		{  
			$formAction = site_url('fellow/edit/'.$id);
			$action = 'edit';
			$val = $applicantDetails['0'];

			$id = $val['applicant_id'];
			$applicant_name = isset($val["applicant_name"])?$val["applicant_name"]:"";
			$qualification = isset($val["qualification"])?$val["qualification"]:"";
			$experience = isset($val["experience"])?$val["experience"]:"";
			$date_received = isset($val["date_received"])?$val["date_received"]:"";
			$shortlist = isset($val["shortlist"])?$val["shortlist"]:"";

			

		}
		
?>	
<h1><?=$cpagetitle?> </h1>

<!-- start id-form -->
<form action="<?=$formAction;?>" method="post" enctype="multipart/form-data">   
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" /> 

<dl class="inline">
               <dt><label for="request_key">Applicant Name<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" name="applicant_name" class="medium required" size="50" value="<?=$applicant_name;?>"  />
				</dd>
                <dt><label for="request_topic_">Qualification<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" name="qualification" class="medium required" size="50" value="<?=$qualification;?>"  />
				</dd>
                <dt><label for="request_topic_">Experience<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" name="experience" class="medium required" size="50" value="<?=$experience;?>"  />
				</dd>
                <dt><label for="request_topic_">Date Recevied<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" name="date_received" class="medium required" size="50" value="<?=$date_received;?>"  />
				</dd>
               <dt><label for="request_topic_">Shortlist<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" name="shortlist" class="medium required" size="50" value="<?=$shortlist;?>" readonly="readonly" />
				</dd>
      <div class="buttons">
			<input type="submit" name="txtSubmit" value="Send Request" class="button" />
                 <input type="reset" value="Reset" class="button white" />
      </div>
      
</form>

<!-- end id-form  -->