<?php
$formAction = "";
$val = array();
if (count($submodule) > 0) {
    $action = 'edit';
    $val = $submodule[0];
    $id = $val['id'];
    $formAction = site_url('mainmaster/useraccess/addsubmodule/' . $id);
    $mod_id = isset($val["mod_id"]) ? $val["mod_id"] : "";
    $smod_id = isset($val["smod_id"]) ? $val["smod_id"] : "";
    $name = isset($val["name"]) ? $val["name"] : "";
    $sname = isset($val["sname"]) ? $val["sname"] : "";
    $description = isset($val["description"]) ? $val["description"] : "";
} else {
    $formAction = site_url('mainmaster/useraccess/addsubmodule/');
    $action = 'add';
    $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : "";
    $mod_id = isset($_REQUEST["mod_id"]) ? $_REQUEST["mod_id"] : "";
    $smod_id = isset($_REQUEST["smod_id"]) ? $_REQUEST["smod_id"] : "";
    $name = isset($_REQUEST["name"]) ? $_REQUEST["name"] : "";
    $sname = isset($_REQUEST["sname"]) ? $_REQUEST["sname"] : "";
    $description = isset($_REQUEST["description"]) ? $_REQUEST["description"] : "";
}
?>
<h1><?=$cpagetitle?> </h1>
<!-- start id-form -->
<form action="<?=$formAction;?>" method="post" enctype="multipart/form-data">
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" />
<dl class="inline">

        <dt><label for="id">Module ID<span style="color:#F00"  class="req_field">*</span></label></dt>
        <dd>
                <select name="mod_id" onchange="module(this.value);">
                <?php foreach ($module as $row) {?>
                <option value="<?php echo $row['mod_id']; ?>"><?php echo $row['name']; ?></option>
                <?php }?>

                </select>
        </dd>

        <dt><label for="id">Sub Module ID<span style="color:#F00"  class="req_field">*</span></label></dt>
        <dd>
        <input type="text" name="smod_id" id="submoduleid" class="medium required" value="<?=$smod_id;?>" readonly="readonly" />
        </dd>

        <dt><label for="Module Name">Sub Module Name</label></dt>
        <dd><input type="text" name="sname" class="medium required" value="<?=$sname?>"/>
        </dd>
        <dt><label for="Description">Description</label></dt>
        <dd><input type="text" name="description" class="medium required" value="<?=$description?>"/>
        </dd>
        <br/>
      <div style="padding-right:120px" class="buttons">
                <input type="submit" name="txtSubmit" value="Create" class="button" />
                <input type="reset" value="Reset" class="button white" />
      </div>
</dl>
</form>
<script type="text/javascript">
function module(value)
{
        var moduleid=value;
        var datas = $.ajax({
        type: "POST",
        url: "<?php echo site_url('mainmaster/useraccess/addsubmodule'); ?>",
        data: {'moduleid':moduleid,'isajax':true},
        success: function(datas) {
                var m = datas;
                $('#submoduleid').val(m);
        }
        });
}

</script>