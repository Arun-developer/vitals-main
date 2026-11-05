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
if (php72_count($trainingDetails) > 0) {
    $formAction = site_url('training/addparticipant/' . $innovationid . '/' . $id);
    $action = 'edit';
    $val = $trainingDetails[0];
    $participant_type = isset($val["participant_type"]) ? $val["participant_type"] : "";
    $participant_name = isset($val["participant_name"]) ? $val["participant_name"] : "";
    $participant_status = isset($val["participant_status"]) ? $val["participant_status"] : "";
    $participant_organization = isset($val["participant_organization"]) ? $val["participant_organization"] : "";

} else {
    $formAction = site_url('training/addparticipant/' . $innovationid);
    $action = 'add';
    $participant_type = isset($_REQUEST["participant_type"]) ? $_REQUEST["participant_type"] : "";
    $participant_name = isset($_REQUEST["participant_name"]) ? $_REQUEST["participant_name"] : "";
    $participant_status = isset($_REQUEST["participant_status"]) ? $_REQUEST["participant_status"] : "";
    $participant_organization = isset($_REQUEST["participant_organization"]) ? $_REQUEST["participant_organization"] : "";
}

?>
<h1><?=$cpagetitle?> </h1>
<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction;?>" method="post" id="vendorForm">
    <input type="hidden" value="<?=$action?>" name="action" />
    <input type="hidden" value="<?=$id?>" name="id" />
    <input type="hidden" value="<?=$innovationid;?>" name="innovationid" />
    <dl class="inline">
        <dt><label for="media_name">Participant Type</label></dt>
        <dd>
            <select name="participant_type">
                <?php if (!empty($participant_type)) {?>
                <option value="<?=$participant_type;?>"><?=$participant_type;?></option><?php } else {?>
                <option value="student">Student</option>
                <option value="employee">Employee</option>
                <option value="innovator">Innovator</option>
                <option value="incubatee">Incuabtee</option><?php }?>
            </select>
        </dd>
        <dt><label for="media_name">Participant Name</label></dt>
        <dd>
            <input type="text" size="40" class="medium required" name="participant_name"
                value="<?=$participant_name;?>" />
        </dd>
        <dt><label for="media_name">Participant Status</label></dt>
        <dd>
            <input type="text" size="40" class="medium required" name="participant_status"
                value="<?=$participant_status;?>" />
        </dd>
        <dt><label for="participant_organization">Participant Organization</label></dt>
        <dd>
            <input type="text" name="participant_organization" size=50 value="<?=$participant_organization;?>" />
        </dd>

        <div class="buttons">
            <input type="submit" name="txtSubmit" value="Send Request" class="button" />
            <input type="reset" value="Reset" class="button white" />
        </div>

</form>

<!-- end id-form  -->