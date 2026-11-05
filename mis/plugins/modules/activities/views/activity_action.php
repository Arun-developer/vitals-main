<h2><?php echo "Activity : ".$activityDetails['0']['activity_description'] ?></h2>
	<form name="action" enctype="multipart/form-data" action="<?=site_url('activities/action/'.$activityDetails['0']['innovation'].'/'.$activityDetails['0']['id']);?>" method="post" id="action" >
<dl class="inline">
							<dt><label for="name">Comments<span class="req_field">*</span></label></dt>
							<dd><textarea id="editor" name="comments" class="required" ></textarea></dd>
</dl>
<div class="buttons">
			<input type="submit" value="Submit" name="txtSubmit" class="button" />
			<input type="reset" value="Reset" name="txtReset" class="button white" />
</div>
</form>

<!-- end id-form  -->
