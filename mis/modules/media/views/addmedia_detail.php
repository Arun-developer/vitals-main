<script type="text/javascript">
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
		$("#vendorForm").validate();
	});
</script>
<?php
if (php72_count($mediaDetails) > 0) {
    $formAction = site_url('media/addmedia_detail/' . $innovationid . '/' . $id);
    $val = $mediaDetails['list1'][0];
    $val1 = $mediaDetails['list2'];

    $title = isset($val["title"]) ? $val["title"] : "";
    $topic = isset($val["topic"]) ? $val["topic"] : "";
    $requested_on = isset($val["requested_on"]) ? $val["requested_on"] : "";
    $media_name = isset($_REQUEST["media_name"]) ? $_REQUEST["media_name"] : "";
    $media_type = isset($_REQUEST['media_type']) ? $_REQUEST['media_type'] : "";
    $journalist_name = isset($_REQUEST['journalist_name']) ? $_REQUEST['journalist_name'] : "";
    $publish_date = isset($_REQUEST['publish_date']) ? $_REQUEST['publish_date'] : "";
    $description = isset($_REQUEST['description']) ? $_REQUEST['description'] : "";
    $document = isset($_REQUEST['document']) ? $_REQUEST['document'] : "";
    $interview = isset($_REQUEST['interview']) ? $_REQUEST['interview'] : "";
}
?>


<h1><?=$cpagetitle?> </h1>


<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction;?>" method="post" id="vendorForm" >
<input type="hidden" value="<?=$id;?>" name="id" />
<input type="hidden" value="<?=$innovationid;?>" name="innovationid" />

<dl class="inline">

   <dt><label for="request_title_">Request Title<span style="color:#F00"  class="req_field">*</span></label></dt>
		<dd>
			<input type="text" name="title" class="medium required" size="50" value="<?=$title;?>" />
		</dd>
		<dt><label for="request_topic_">Request Topic<span style="color:#F00"  class="req_field">*</span></label></dt>
		<dd>
			<input type="text" name="topic" class="medium required" size="50" value="<?=$topic;?>" />
		</dd>
		<dt><label for="publish_date">Publish Date<span style="color:#F00"  class="req_field">*</span></label></dt>
		<dd>
			<input type="text" name="publish_date" class="input-text   datepicker required" size="50" />
		</dd>
		<?php
for ($i = 0; $i < php72_count($val1); $i++) {
    if ($i == 0) {
        $media_name = "<select name='media_name'>";
        $media_type = "<select name='media_type'>";
        $journalist_name = "<select name='journalist_name'>";
    }
    $media_name .= "<option value='" . $val1[$i]['media_name'] . "'>" . $val1[$i]['media_name'] . "</option>";
    $media_type .= "<option value='" . $val1[$i]['media_type'] . "'>" . $val1[$i]['media_type'] . "</option>";
    $journalist_name .= "<option value='" . $val1[$i]['journalist_name'] . "'>" . $val1[$i]['journalist_name'] . "</option>";
}
$media_name .= "</select>";
$media_type .= "</select>";
$journalist_name .= "</select>";
?><dt><label for="media_name">Media Name</label></dt>
                <dd><?php echo $media_name; ?></dd>

                <dt><label for="media_type">Media Type<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<?php echo $media_type; ?></dd>
				</dd>
               <dt><label for="journalist_name">Journalist Name<span style="color:#F00"  class="req_field">*</span></label></dt>
                <dd>
					<?php echo $journalist_name; ?></dd>
				</dd>

               <dt><label for="description">Description</label></dt>
               <dd><textarea name="description" class="medium"></textarea><small> Brief  Description</small>
               </dd>
               <dt><label for="interview">Did the Interview Happened</label></dt>
               <dd><input type="checkbox" name="interview" value="checked" /></dd>
               <dt><label for="document">Article</label></dt>
               <div class="uploader" id="uniform-undefined">
              <input type="file" name="document" size=19  style="opacity : 0;" id="document" value="<?=$document;?>"/>
               <span class="filename">No file selected</span>
               <span class="action">choose file</span>
              </div>

      <div class="buttons">
			<input type="submit" value="Save" class="button" name="txtSubmit" />
            <input type="reset" value="Reset" class="button white" />
      </div>
      </dl>
</form>

<!-- end id-form  -->