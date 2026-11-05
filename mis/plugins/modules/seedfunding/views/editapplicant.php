<script type="text/javascript">
$.metadata.setType("attr", "validate");
$(document).ready(function() {
    $("#vendorForm").validate();
});
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
			$id = $val['id'];
			$applicant_name = isset($val["applicant_name"])?$val["applicant_name"]:"";
			$qualification = isset($val["qualification"])?$val["qualification"]:"";
			$experience = isset($val["experience"])?$val["experience"]:"";
			$date_recevied = isset($val["date_recevied"])?$val["date_recevied"]:"";
			$shortlist = isset($val["shortlist"])?$val["shortlist"]:"";
		}
		
?>
<h1><?=$cpagetitle?> </h1>

<!-- start id-form -->
<form action="<?=$formAction;?>" method="post" enctype="multipart/form-data">
    <input type="hidden" value="<?=$action?>" name="action" />
    <input type="hidden" value="<?=$id?>" name="id" />

    <dl class="inline">
        <dt><label for="request_key">Applicant Name<span style="color:#F00" class="req_field">*</span></label></dt>
        <dd>
            <input type="text" name="applicant_name" class="medium required" size="50" value="<?=$applicant_name;?>"
                readonly="readonly" />
        </dd>
        <dt><label for="request_topic_">Qualification<span style="color:#F00" class="req_field">*</span></label></dt>
        <dd>
            <input type="text" name="qualificaiton" class="medium required" size="50" value="<?=qualification;?>"
                readonly="readonly" />
        </dd>
        <dt><label for="request_topic_">Experience<span style="color:#F00" class="req_field">*</span></label></dt>
        <dd>
            <input type="text" name="experience" class="medium required" size="50" value="<?=experience;?>"
                readonly="readonly" />
        </dd>
        <dt><label for="request_topic_">Date Recevied<span style="color:#F00" class="req_field">*</span></label></dt>
        <dd>
            <input type="text" name="date_recevied" class="medium required" size="50" value="<?=date_recevied;?>"
                readonly="readonly" />
        </dd>
        <dt><label for="request_topic_">Shortlist<span style="color:#F00" class="req_field">*</span></label></dt>
        <dd>
            <input type="text" name="shortlist" class="medium required" size="50" value="<?=shortlist;?>"
                readonly="readonly" />
        </dd>
        <div class="buttons">
            <input type="submit" name="txtSubmit" value="Send Request" class="button" />
            <input type="reset" value="Reset" class="button white" />
        </div>

</form>

<!-- end id-form  -->