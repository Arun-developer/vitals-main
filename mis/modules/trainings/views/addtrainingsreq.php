<script type="text/javascript">
$.metadata.setType("attr", "validate");
$(document).ready(function() {
    $("#vendorForm").validate();
});
</script>
<script type="text/javascript">
var BASE_URL = 'http://localhost/mis/';

var SITE_URL = BASE_URL + 'index.php/';

function today_date()
{
    var d = new Date();

    var curr_date = d.getDate();

    var curr_month = d.getMonth() + 1;

    var curr_year = d.getFullYear();

    var today = curr_date + '/' + curr_month + '/' + curr_year;

    return today;

}
</script>
<?php
$formAction = "";
$val = array();
if (count($trainingDetails) > 0) {
    $formAction = site_url('trainings/form/' . $innovationid . '/' . $id);
    $action = 'edit';
    $val = $trainingDetails[0];
    $sector = isset($val["sector"]) ? $val["sector"] : "";
    $start_date = isset($val["start_date"]) ? $val["start_date"] : "";
    $to_date = isset($val["to_date"]) ? $val["to_date"] : "";
    $fund_allocated = isset($val["fund_allocated"]) ? $val["fund_allocated"] : "";
    $fund_utilized = isset($val["fund_utilized"]) ? $val["fund_utilized"] : "";
    $document = isset($val["Document"]) ? $val["Document"] : "";

} else {
    $formAction = site_url('trainings/form/' . $innovationid);
    $action = 'add';
    $sector = isset($_REQUEST["sector"]) ? $_REQUEST["sector"] : "";
    $start_date = isset($_REQUEST["start_date"]) ? $_REQUEST["start_date"] : "";
    $to_date = isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : "";
    $fund_allocated = isset($_REQUEST["fund_allocated"]) ? $_REQUEST["fund_allocated"] : "";
    $fund_utilized = isset($_REQUEST["fund_utilized"]) ? $_REQUEST["fund_utilized"] : "";
    $document = isset($_REQUEST["document"]) ? $_REQUEST["document"] : "";
}

?>
<h1><?=$cpagetitle?> </h1>
<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction;?>" method="post" id="vendorForm">
    <input type="hidden" value="<?=$action?>" name="action" />
    <input type="hidden" value="<?=$id?>" name="id" />
    <input type="hidden" value="<?=$innovationid;?>" name="innovationid" />
    <dl class="inline">
        <dt><label for="requested_on">Sector<span style="color:#F00" class="req_field">*</span></label></dt>
        <dd>
            <input type="text" size="40" class="required" name="sector" value="<?=$sector;?>" />
        </dd>
        <dt><label for="requested_on">Start Date<span style="color:#F00" class="req_field">*</span></label></dt>
        <dd>
            <input type="text" size="40" class="input-text   datepicker" name="start_date" value="<?=$start_date;?>" />
        </dd>
        <dt><label for="requested_on">TO Date<span style="color:#F00" class="req_field">*</span></label></dt>
        <dd>
            <input type="text" size="40" class="input-text   datepicker" name="to_date" value="<?=$to_date;?>" />
        </dd>
        <dt><label for="media_name">Fund Allocated</label></dt>
        <dd>
            <input type="text" size="40" class="medium required" name="fund_allocated" value="<?=$fund_allocated;?>" />
        </dd>
        <dt><label for="media_name">Fund Utilized</label></dt>
        <dd>
            <input type="text" size="40" class="medium required" name="fund_utilized" value="<?=$fund_utilized;?>" />
        </dd>
        <dt><label for="Document">Document</label></dt><?=$document;?>
        <div class="uploader" id="uniform-undefined">
            <input type="file" name="document" size=19 style="opacity : 0;" id="document" />
            <span class="filename">No file selected</span>
            <span class="action">choose file</span>
        </div>
        <div class="buttons">
            <input type="submit" name="txtSubmit" value="Send Request" class="button" />
            <input type="reset" value="Reset" class="button white" />
        </div>

</form>

<!-- end id-form  -->