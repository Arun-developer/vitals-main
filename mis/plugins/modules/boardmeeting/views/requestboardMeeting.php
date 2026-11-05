<script type="text/javascript">
		 $(document).ready( function()
		 {
			$.metadata.setType("attr", "validate");
            $("#addBoard").validate();
         });
</script>

<!-- start id-form -->
<form name="addBoard" id="addBoard" enctype="multipart/form-data" action="<?//=$formAction;?>" method="post" >
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" />
<input type="hidden" value="<?=$innovationid?>" name="innovationid" />

	<h1><?=$cpagetitle?></h1>
	<fieldset>
	<legend><?=$cpagetitle?></legend>

	<dl class="inline">
             	<dt><label for="namesd">Subject<font class="req_field">*</font></label></dt>
				<dd>
					<input type="text" name="subject" id="subject"   size="50" value="<?php echo $boardmemberno; ?>" class="input-text required" />
			   </dd>

               <dt><label for="namesd">Location<font class="req_field">*</font></label></dt>
				<dd>
					<input type="text" name="location" id="location"  size="50" value="<?php echo $qualification; ?>" class="input-text required" />
			   </dd>

			   <dt><label for="namesd">Meeting Date&Time<font class="req_field">*</font></label></dt>
			    <dd>
                 <input  class="input-text datetimepicker required hasDatepicker" type="text" size="40" value="" name="start_datetime">
			   </dd>


			   <dt><label for="comments">Attendees Required<font class="req_field">*</font></label></dt>
                <dd><textarea  name="description" id="description" class="input-text required"  cols="53" rows="6" ><?php echo $description; ?></textarea>
				<small>Committe Member Names </small></dd>

      </dl>
			    <div class="buttons">
			     <input type="submit" name="txtSubmit" value="Send Request" class="button" />
                 <input type="reset" value="Reset" class="button white" />
               </div>
			</fieldset>
</form>

<!-- end id-form  -->