<script type="text/javascript">
$.metadata.setType("attr", "validate");
$(document).ready(function() {
    $("#vendorForm").validate();
});
</script>
<?php
if (php72_count($trainingDetails) > 0) {

    $formAction = site_url('training/addtraining_detail/' . $innovationid . '/' . $id);
    $val = @$trainingDetails['list1'][0];
    $val1 = $trainingDetails['list2'];

    $facilitator_name = isset($val["facilitator"]) ? $val["facilitator"] : "";
    $topic = isset($_REQUEST["topic"]) ? $_REQUEST["topic"] : "";
    $start_date = isset($_REQUEST["start_date"]) ? $_REQUEST["start_date"] : "";
    $to_date = isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : "";
    $description = isset($_REQUEST['description']) ? $_REQUEST['description'] : "";
    $document = isset($_REQUEST['document']) ? $_REQUEST['document'] : "";

}
for ($i = 0; $i < php72_count($val1); $i++) {
    if ($i == 0) {
        $facilitator_name = "<select name='facilitator_name'>";

    }
    $facilitator_name .= "<option value='" . $val1[$i]['facilitator_name'] . "'>" . $val1[$i]['facilitator_name'] . "</option>";

}
$facilitator_name .= "</select>";
?>


<h1><?=$cpagetitle?> </h1>


<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction;?>" method="post" id="vendorForm">
    <input type="hidden" value="<?=$id;?>" name="id" />
    <input type="hidden" value="<?=$innovationid;?>" name="innovationid" />

    <dl class="inline">

        <dt><label for="request_topic_">Request Topic<span style="color:#F00" class="req_field">*</span></label></dt>
        <dd>
            <input type="text" name="topic" class="medium required" size="50" value="<?=$topic;?>" />
        </dd>

        <dt><label for="media_name">Facilitator Name<span style="color:#F00" class="req_field">*</span></label></dt>
        <dd><input type="text" name="facilitator_name" class="medium-required" size="50" value="" /></dd>


        <dt><label for="requested_on">Start Date<span style="color:#F00" class="req_field">*</span></label></dt>
        <dd>
            <input type="text" size="40" class="input-text   datepicker" name="start_date" value="<?=$start_date;?>" />
        </dd>
        <dt><label for="requested_on">TO Date<span style="color:#F00" class="req_field">*</span></label></dt>
        <dd>
            <input type="text" size="40" class="input-text   datepicker" name="to_date" value="<?=$to_date;?>" />
        </dd>

        <dt><label for="description">Description</label></dt>
        <dd><textarea name="description" class="medium"></textarea><small> Brief Description</small>
        </dd>
        <dt><label for="document">Documents</label></dt>
        <dd>
            <div class="uploader" id="uniform-undefined">
                <input type="file" name="document" size=19 style="opacity : 0;" id="document" />
                <span class="filename">No file selected</span>
                <span class="action">choose file</span>
            </div>
        </dd>
    </dl>
    <div class="buttons">
        <input type="submit" value="Save" class="button" name="txtSubmit" />
        <input type="reset" value="Reset" class="button white" />
    </div>

</form>

<!-- end id-form  -->