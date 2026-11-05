<script type="text/javascript">
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
		$("#vendorForm").validate();
	});
</script>
<?php
$sector = isset($_REQUEST["sector"]) ? $_REQUEST["sector"] : "";
$experience = isset($_REQUEST["experience"]) ? $_REQUEST["experience"] : "";
$skills = isset($_REQUEST["skills"]) ? $_REQUEST["skills"] : "";
$investerfname = isset($_REQUEST["first_name"]) ? $_REQUEST["first_name"] : "";
$address = isset($_REQUEST["address"]) ? $_REQUEST["address"] : "";
$city = isset($_REQUEST["city"]) ? $_REQUEST["city"] : "";
$telephone = isset($_REQUEST["telephone"]) ? $_REQUEST["telephone"] : "";
$mobile = isset($_REQUEST["mobile"]) ? $_REQUEST["mobile"] : "";
$email = isset($_REQUEST["email"]) ? $_REQUEST["email"] : "";
$history = isset($_REQUEST["history"]) ? $_REQUEST["history"] : "";
$photograph = isset($_REQUEST["photograph"]) ? $_REQUEST["photograph"] : "";
$resume = isset($_REQUEST["resume"]) ? $_REQUEST["resume"] : "";

?>


<h1><?=$cpagetitle?> </h1>
<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=site_url('master/mentor/add');?>" method="post" id="vendorForm" >
<dl class="inline">

   <dt><label for="source_type">Sector<span class="req_field">*</span></label></dt>
    <dd><select name="sector" id="sector" class="medium">
        	<option value="">-Select-</option>
            <?php
foreach ($sectorarr as $row):
?>
                <option value="<?=$row;?>"  <?php echo ($sector == $row) ? ('selected') : (''); ?> ><?=$row;?></option>
                <?php
endforeach;
?>
        </select>
      </dd>

    <dt><label for="source_type">Experience : </label></dt>
    <dd>
	   <select name="experience" id="experience" class="medium">
        	<option value="">-Select-</option>
            <?php
foreach ($exparr as $row):
?>
                <option value="<?=$row;?>"  <?php echo ($experience == $row) ? ('selected') : (''); ?> ><?=$row;?></option>
                <?php
endforeach;
?>
        </select>
    </dd>

    <dt><label for="source_type">Skills : </label></dt>
    <dd>
	     <input type="text" size="52" name="skills" value="<?=$skills?>" class="input-text required"/>
    </dd>
    <dt><label for="source_type">Applicant Name : </label></dt>
    <dd>
	     <input type="text" size="52" name="first_name" value="<?=$investerfname?>" class="input-text required"/>
    </dd>

	 <dt><label for="source_type">Address : </label></dt>
   	 <dd>
	     <input type="text" size="52" name="address" value="<?=$address?>" class="input-text required"/>
     </dd>

	 <dt><label for="source_type">City : </label></dt>
   	 <dd>
	     <input type="text" size="52" name="city" value="<?=$city?>" class="input-text required"/>
     </dd>

     <dt><label for="source_type">Telephone Number :</label></dt>
	 <dd>
	     <input type="text" size="52" name="telephone" value="<?=$telephone?>" />
	</dd>

	<dt><label for="source_type">Mobile Number :</label></dt>
	<dd>
	     <input type="text" size="52" name="mobile" value="<?=$mobile?>" class="input-text required"/>
	</dd>


     <dt><label for="source_type">Email Address :</label></dt>
	 <dd>
	     <input type="text" size="52" name="email" value="<?=$email?>" class="input-text required"/>
	</dd>

	 <dt><label for="source_type">History :</label></dt>

	 <dd>
	     <textarea cols="50" rows="5" class="input-text required" name="history"><?=$history?></textarea>
	</dd>

	 <dt><label for="source_type">Photograph :</label></dt>
	 <dd>
		<input type="file" name="photograph" id="photograph" >
	</dd>


    <dt><label for="source_type">Resume :</label></dt>
	 <dd>
		<input type="file" name="resume" id="resume" >
	</dd>


	<div class="buttons">
		 <input class="button" type="submit" name="txtSubmit"value="Save">
	 	 <input class="button white" type="reset" value="Reset">
	</div>

</dl>
</form>
<!-- end id-form  -->