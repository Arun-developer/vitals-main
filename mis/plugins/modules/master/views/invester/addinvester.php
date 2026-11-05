<script type="text/javascript">
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
		$("#vendorForm").validate();
	});
</script>
<?php
$sector = isset($_REQUEST["sector"]) ? $_REQUEST["sector"] : "";

$investerfname = isset($_REQUEST["first_name"]) ? $_REQUEST["first_name"] : "";
$telephone = isset($_REQUEST["telephone"]) ? $_REQUEST["telephone"] : "";
$mobile = isset($_REQUEST["mobile"]) ? $_REQUEST["mobile"] : "";
$email = isset($_REQUEST["email"]) ? $_REQUEST["email"] : "";

$comments = isset($_REQUEST["comments"]) ? $_REQUEST["comments"] : "";

?>


<h1><?=$cpagetitle?> </h1>
<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=site_url('master/invester/add');?>" method="post" id="vendorForm" >
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



    <dt><label for="source_type">Invester Name : </label></dt>
    <dd>
	     <input type="text" size="52" name="first_name" value="<?=$investerfname?>" class="input-text required"/>
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

	 <dt><label for="source_type">Comments :</label></dt>

	 <dd>
	     <textarea cols="50" rows="5" class="input-text required" name="comments"><?=$comments?></textarea>
	</dd>




    <dt><label for="source_type">Document :</label></dt>
	 <dd>

		<input type="file" name="documents" id="documents" >

	</div>
	</dd>


	<div class="buttons">
	 <input class="button" type="submit" name="txtSubmit"value="Save">
	 <input class="button white" type="reset" value="Reset">
	</div>

</dl>
</form>
<!-- end id-form  -->