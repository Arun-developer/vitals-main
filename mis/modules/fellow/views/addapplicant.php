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
        $applicant_name = isset($_REQUEST["applicant_name"])?$_REQUEST["applicant_name"]:"";
		$qualification = isset($_REQUEST["qualification"])?$_REQUEST["qualification"]:"";
    	$date_appointment = isset($_REQUEST["date_appointment"])?$_REQUEST["date_appointment"]:"";
		$origin = isset($_REQUEST["origin"])?$_REQUEST["origin"]:"";
		$experience = isset($_REQUEST["experience"])?$_REQUEST["experience"]:"";
		$exp_from = isset($_REQUEST["exp_from"])?$_REQUEST["exp_from"]:"";
		$exp_to = isset($_REQUEST["exp_to"])?$_REQUEST["exp_to"]:"";
		$address = isset($_REQUEST["address"])?$_REQUEST["address"]:"";
		$city = isset($_REQUEST["city"])?$_REQUEST["city"]:"";
		$state = isset($_REQUEST["state"])?$_REQUEST["state"]:"";
		$telephone = isset($_REQUEST["telephone"])?$_REQUEST["telephone"]:"";
		$mobile = isset($_REQUEST["mobile"])?$_REQUEST["mobile"]:"";
		$email = isset($_REQUEST["email"])?$_REQUEST["email"]:"";
		$history= isset($_REQUEST["history"])?$_REQUEST["history"]:"";
		$profile= isset($_REQUEST["profile"])?$_REQUEST["profile"]:"";
		$area = isset($_REQUEST["area"])?$_REQUEST["area"]:"";

?>


<h1><?=$cpagetitle?> </h1>

<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=site_url('fellow/add/'.$innovationid.'/'.$id);?>" method="post" id="vendorForm" >
<input type="hidden" name="innovationid" value="<?php echo $innovationid; ?>" />
<input type="hidden" name="id" value="<?php echo $id ;?>"  />
<dl class="inline">

   <dt><label for="source_type">Applicant Name<span class="req_field">*</span></label></dt>
    <dd><input type="text" name="applicant_name" size=50 value="<?=$applicant_name;?>" />
      </dd>

    <dt><label for="source_type">Experience <span class="req_field">*</span> </label></dt>
    <dd>
	   <select name="experience" id="experience" class="medium">
        	<option value="">-Select-</option>
            <?php
			foreach($exparr as $row):
				?>
                <option value="<?=$row ;?>"  <?php echo ($experience==$row)?('selected'):(''); ?> ><?=$row;?></option>
                <?php 
			endforeach;
			?>
        </select>
    </dd>	
	
    <dt><label for="source_type">Area of Working<span class="req_field">*</span> </label></dt>
    <dd>
	     <input type="text" size="52" name="area" value="<?=$area ?>" class="input-text required"/>
    </dd>	
    <dt><label for="source_type">Qualification:<span class="req_field">*</span> </label></dt>
    <dd>
	     <input type="text" size="52" name="qualification" value="<?=$qualification ?>" class="input-text required"/>
    </dd>
    <dt><label for="date_appointment">Date Recevied<span style="color:#F00"  class="req_field">*</span></label></dt>
    <dd>
    	<input type="text" size="55" class="input-text   datepicker" name="date_appointment" value="<?=$date_appointment;?>"/>
	</dd>	
    <dt><label for="exp_from">Experience From<span style="color:#F00"  class="req_field">*</span></label></dt>
    <dd>
    	<input type="text" size="55" class="input-text   datepicker" name="exp_from" value="<?=$exp_from;?>"/>
	</dd>
	<dt><label for="exp_to">Experience To<span style="color:#F00"  class="req_field">*</span></label></dt>
	<dd>
    	<input type="text" size="55" class="input-text   datepicker" name="exp_to" value="<?=$exp_to;?>"/>
	</dd>

	<dt><label for="origin">Origin:</label></dt>
    <dd>
    <select name="origin">
    <option value="">--select--</option>
    <option value="national">National</option>
    <option value="international">International</option>
    </select>
    </dd> 
	 <dt><label for="source_type">Address : </label></dt>
   	 <dd>
	     <input type="text" size="52" name="address" value="<?=$address ?>" class="input-text required"/>
     </dd>
	 	
	 <dt><label for="source_type">City : </label></dt>
   	 <dd>
	     <input type="text" size="52" name="city" value="<?= $city ?>" class="input-text required"/>
     </dd>	
	 
    <dt><label for="source_type">State : </label></dt>
   	 <dd>
	     <input type="text" size="52" name="city" value="<?= $state ?>" class="input-text required"/>
     </dd>	

     <dt><label for="source_type">Telephone Number :</label></dt>
	 <dd>
	     <input type="text" size="52" name="telephone" value="<?= $telephone?>" />
	</dd>
	
	<dt><label for="source_type">Mobile Number :</label></dt>
	<dd>
	     <input type="text" size="52" name="mobile" value="<?= $mobile ?>" class="input-text required"/>
	</dd>
	
     <dt><label for="source_type">Email Address :</label></dt>
	 <dd>
	     <input type="text" size="52" name="email" value="<?= $email ?>" class="input-text required"/>
	</dd>
	
	 <dt><label for="source_type">History :</label></dt>
	 <dd>
	     <textarea cols="50" rows="5" class="input-text required" name="history"><?= $history ?></textarea>
	 </dd>
	
	 <dt><label for="source_type">profile :</label></dt>
	 <div class="uploader" id="uniform-undefined">
              <input type="file" name="profile" size=19  style="opacity : 0;" id="profile" />
               <span class="filename">No file selected</span>
               <span class="action">choose file</span>
    </div>
 
  
    
	
 
	<div class="buttons">
		 <input class="button" type="submit" name="txtSubmit"value="Save">
	 	 <input class="button white" type="reset" value="Reset">
	</div>

</dl>
</form>
<!-- end id-form  -->