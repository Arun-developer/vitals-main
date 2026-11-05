<?php
$formAction = site_url('fellow/do_upload');
?>
<form name="indcution_documentsForm"  action="<?=$formAction?>" enctype="multipart/form-data" method="post" id="indcution_documentsForm" class="uniform" >
<input type="hidden" name="uploadpath" value="./fellow/upload_induction/" />
<dl class="inline">

       <dt><label for="document">Document</label></dt>
	   <dd><input type="file" name="profile" id="profile" value=""/>
       </dd>
</dl>  

<div class="buttons">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
<div>
</form>