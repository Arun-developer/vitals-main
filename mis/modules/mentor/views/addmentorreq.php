<style>
form dl.inline dt {
    width: 22% !important;
}
</style>
<?php
$formAction = "";
$id = '';

$val = array();
if (php72_count($mentorDetails) > 0) {
    $val = $mentorDetails['0'];
    $formAction = site_url('mentor/form/' . $innovationid . '/' . $val['id']);
    $id = $val['id'];
    $action = 'edit';
    $nomentor = isset($val['no_mentor']) ? $val['no_mentor'] : "";
    $sector = isset($val['sector']) ? $val['sector'] : "";
    $experience = isset($val['experience']) ? $val['experience'] : "";
    $description = isset($val['description']) ? $val['description'] : "";
} else {
    $formAction = site_url('mentor/form/' . $innovationid);
    $action = 'add';
    $sector = isset($_REQUEST["sector"]) ? $_REQUEST["sector"] : "";
    $nomentor = isset($_REQUEST["nomentor"]) ? $_REQUEST["nomentor"] : "";
    $experience = isset($_REQUEST["experience"]) ? $_REQUEST["experience"] : "";
    $description = isset($_REQUEST["description"]) ? $_REQUEST["description"] : "";
}

?>
<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction;?>" method="post" id="addMemberForm">
    <input type="hidden" value="<?=$action?>" name="action" />
    <input type="hidden" value="<?=$id?>" name="id" />
    <input type="hidden" value="<?=$innovationid;?>" name="innovationid" />


    <h1><?=$cpagetitle?></h1>
    <fieldset>
        <legend><?=$cpagetitle?></legend>
        <dl class="inline" width="600">

            <dt><label for="namesd">No of Mentor</label></dt>
            <dd>
                <input type="text" name="nomentor" id="nomentor" class="medium " size="30"
                    value="<?php echo $nomentor ?>" />
                <small>No of Mentor Required</small>
            </dd>

            <dt><label for="namesd">Sector</label></dt>
            <dd>
                <select name="sector" id="sector" class="medium">
                    <option value="">-Select-</option>
                    <?php
foreach ($sectorarr as $row):
?>
                    <option value="<?=$row;?>" <?php echo ($sector == $row) ? ('selected') : (''); ?>><?=$row;?>
                    </option>
                    <?php
endforeach;
?>
                </select>
                <small>Sector</small>
            </dd>


            <dt><label for="namesd">Experience</label></dt>
            <dd>
                <input type="text" name="experience" id="experience" class="medium " size="30"
                    value="<?php echo $experience; ?>" />

            </dd>


            <dt><label for="comments">Description</label></dt>
            <dd><textarea cols="30" rows="5" name="description" id="editor"
                    class="medium"><?php echo $description; ?></textarea>
                <small> Write requirement description for Mentor</small></dd>

        </dl>
        <div class="buttons">
            <input type="submit" name="txtSubmit" value="Send Request" class="button" />
            <input type="reset" value="Reset" class="button white" />
        </div>
    </fieldset>
</form>

<!-- end id-form  -->