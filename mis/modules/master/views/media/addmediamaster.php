<script type="text/javascript">
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
		$("#vendorForm").validate();
	});
</script>
<?php

if (count($mediaDetails) > 0) {
    $val = $mediaDetails[0];
    $action = 'edit';
    $formAction = site_url('master/media/form/' . $id);
    $media_name = isset($val["media_name"]) ? $val["media_name"] : "";
    $media_type = isset($val["media_type"]) ? $val["media_type"] : "";
    $journalist_name = isset($val["journalist_name"]) ? $val["journalist_name"] : "";
    $media_subtype = isset($val["media_subtype"]) ? $val["media_subtype"] : "";
    $address1 = isset($val["address1"]) ? $val["address1"] : "";
    $address2 = isset($val["address2"]) ? $val["address2"] : "";
    $city = isset($val["city"]) ? $val["city"] : "";
    $phone = isset($val["phone"]) ? $val["phone"] : "";
    $email = isset($val["email"]) ? $val["email"] : "";
    $remarks = isset($val["remarks"]) ? $val["remarks"] : "";
    $zip = isset($val["zip"]) ? $val["zip"] : "";
    $id = isset($val["id"]) ? $val["id"] : "";
} else {
    $formAction = site_url('master/media/form');
    $action = 'add';
    $media_name = isset($_REQUEST["media_name"]) ? $_REQUEST["media_name"] : "";
    $media_type = isset($_REQUEST["media_type"]) ? $_REQUEST["media_type"] : "";
    $journalist_name = isset($_REQUEST["journalist_name"]) ? $_REQUEST["journalist_name"] : "";
    $media_subtype = isset($_REQUEST["media_subtype"]) ? $_REQUEST["media_subtype"] : "";
    $address1 = isset($_REQUEST["address1"]) ? $_REQUEST["address1"] : "";
    $address2 = isset($_REQUEST["address2"]) ? $_REQUEST["address2"] : "";
    $city = isset($_REQUEST["city"]) ? $_REQUEST["city"] : "";
    $phone = isset($_REQUEST["phone"]) ? $_REQUEST["phone"] : "";
    $email = isset($_REQUEST["email"]) ? $_REQUEST["email"] : "";
    $remarks = isset($_REQUEST["remarks"]) ? $_REQUEST["remarks"] : "";
    $zip = isset($_REQUEST["zip"]) ? $_REQUEST["zip"] : "";

}

?>


<h1><?=$cpagetitle?> </h1>
<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction;?>" method="post" id="vendorForm" >
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" />
<dl class="inline">

   <dt><label for="source_type">Media Name<span class="req_field">*</span></label></dt>
    <dd>
                 <input type="text" size="52" name="media_name" value="<?=$media_name?>" class="input-text required"/>
        </select>
      </dd>

    <dt><label for="source_type">Media Type:<span class="req_field">*</span> </label></dt>
    <dd>
	    		<input type="text" size="52" name="media_type" value="<?=$media_name?>" class="input-text required"/>
        </select>
    </dd>

    <dt><label for="source_type">Media Sub Type :<span class="req_field">*</span> </label></dt>
    <dd>
	     <input type="text" size="52" name="media_subtype" value="<?=$media_subtype?>" class="input-text required"/>
    </dd>
    <dt><label for="source_type">Journalist Name :<span class="req_field">*</span> </label></dt>
    <dd>
	     <input type="text" size="52" name="journalist_name" value="<?=$journalist_name?>" class="input-text required"/>
    </dd>

	 <dt><label for="source_type">Address : </label></dt>
   	 <dd>
	     <input type="text" size="52" name="address1" value="<?=$address1?>" class="input-text required"/>
     </dd>

      <dt><label for="source_type">Address : </label></dt>
   	 <dd>
	     <input type="text" size="52" name="address2" value="<?=$address2?>" class="input-text required"/>
     </dd>

	 <dt><label for="source_type">City : </label></dt>
   	 <dd>
	     <input type="text" size="52" name="city" value="<?=$city?>" class="input-text required"/>
     </dd>

	<dt><label for="source_type">Mobile Number :</label></dt>
	<dd>
	     <input type="text" size="52" name="phone" value="<?=$phone?>" class="input-text required mobile"/>
	</dd>
	     <dt><label for="source_type">Email Address :</label></dt>
	 <dd>
	     <input type="text" size="52" name="email" value="<?=$email?>" class="input-text required email"/>
	</dd>


	 <dt><label for="source_type">Remarks :</label></dt>

	 <dd>
	     <textarea cols="50" rows="5" class="input-text required" name="remarks"><?=$remarks?></textarea>
	</dd>

	<div class="buttons">
		 <input class="button" type="submit" name="txtSubmit"value="Save">
	 	 <input class="button white" type="reset" value="Reset">
	</div>

</dl>
</form>
<!-- end id-form  -->