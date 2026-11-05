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
$val = array();
if (count($mediaDetails) > 0) {
    $formAction = site_url('media/form/' . $innovationid . '/' . $id);
    $action = 'edit';
    $val = $mediaDetails[0];

    $title = isset($val["title"]) ? $val["title"] : "";
    $topic = isset($val["topic"]) ? $val["topic"] : "";
    $requested_on = isset($val["requested_on"]) ? $val["requested_on"] : "";
    $media_name = isset($val["media_name"]) ? $val["media_name"] : "";
    $description = isset($val["description"]) ? $val["description"] : "";
    $document = isset($val["Document"]) ? $val["Document"] : "";

} else {
    $formAction = site_url('media/form/' . $innovationid);
    $action = 'add';
    $title = isset($_REQUEST["title"]) ? $_REQUEST["title"] : "";
    $topic = isset($_REQUEST["topic"]) ? $_REQUEST["topic"] : "";
    $requested_on = isset($_REQUEST["requested_on"]) ? $_REQUEST["requested_on"] : "";
    $media_name = isset($_REQUEST["media_name"]) ? $_REQUEST["media_name"] : "";
    $description = isset($_REQUEST["description"]) ? $_REQUEST["description"] : "";
    $document = isset($_REQUEST["document"]) ? $_REQUEST["document"] : "";
}

?>
<h1><?=$cpagetitle?> </h1>
<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction;?>" method="post" id="vendorForm" >
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" />
<input type="hidden" value="<?=$innovationid;?>" name="innovationid" />
<dl class="inline">
                <dt><label for="request_title_">Title<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" name="title" class="medium required" size="50" value="<?=$title;?>" />
				</dd>
                <dt><label for="request_topic_">Topic<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" name="topic" class="medium required" size="50" value="<?=$topic;?>"/>
				</dd>
                <dt><label for="requested_on">Requested On<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<input type="text" size="40" class="input-text   datepicker" name="requested_on" value="<?=$requested_on;?>"/>
				</dd>
                <dt><label for="media_name">Media Name</label></dt>
                <dd>
                <input type="text" size="40" class="medium required" name="media_name" value="<?=$media_name;?>"/>
               </dd>
               <dt><label for="description">Description</label></dt>
               <dd><textarea name="description" class="medium"><?=$description;?></textarea><small> Brief  Description</small>
               </dd>

               <dt><label for="Document">Document</label></dt><?=$document;?>
               <div class="uploader" id="uniform-undefined">
              <input type="file" name="document" size=19  style="opacity : 0;" id="document" value="<?=$document;?>"/>
               <span class="filename">No file selected</span>
               <span class="action">choose file</span>
              </div>
      <div class="buttons">
			<input type="submit" name="txtSubmit" value="Send Request" class="button" />
                 <input type="reset" value="Reset" class="button white" />
      </div>

</form>

<!-- end id-form  -->