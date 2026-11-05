<?php
$formAction = "";
$val = array();
if (php72_count($usergroup) > 0) {
    $formAction = site_url('mainmaster/useraccess/adduser/' . $id);
    $action = 'edit';
    $val = $usergroup['0'];
    $id = $val['id'];
    $userg_id = isset($val["userg_id"]) ? $val["userg_id"] : "";
    $userg_name = isset($val["userg_name"]) ? $val["userg_name"] : "";
} else {
    $key = $userg_id[0]['userg_id'];
    $formAction = site_url('mainmaster/useraccess/adduser/');
    $action = 'add';
    $userg_id = isset($_REQUEST["userg_id"]) ? $_REQUEST["userg_id"] : "";
    $userg_name = isset($_REQUEST["userg_name"]) ? $_REQUEST["userg_name"] : "";
}
?>

<!-- start id-form -->
<div>
        <ul class="tabs">
		<li><a href="<?=site_url('mainmaster/useraccess/index')?>">Add User Access</a></li>
		<li class="selected"><a href="<?=site_url('mainmaster/useraccess/adduser')?>">Add User Group</a></li>
		<li><a href="<?=site_url('mainmaster/useraccess/addadmin')?>">Add Admin</a></li>
		<li><a href="<?=site_url('mainmaster/useraccess/addincubatee')?>">Manage Incubatee</a></li>
	</ul>
</div>

<h1><?=$cpagetitle?> </h1>
<form action="<?=$formAction;?>" method="post" enctype="multipart/form-data">
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$userg_id?>" name="id" />
<dl class="inline">
<?php
if ($action == "add") {
    if (!$key) {
        $userg_id = "USG" . '001';
    } else {
        $num = substr($key, 3);
        $cnt = strlen($num);
        $num++;
        $num1 = str_pad($num, $cnt, 0, STR_PAD_LEFT);
        $userg_id = "USG" . $num1;
    }
}
?>
        <dt style="display:none;"><label for="userg_id">User Group ID<span style="color:#F00"  class="req_field">*</span></label></dt>
        <dd style="display:none;">
		<input type="text" name="userg_id" class="medium required" value="<?=$userg_id;?>" readonly="readonly" />
		</dd>
                <dt><label for="User Group Name">User Group Name</label></dt>
                <dd><input type="text" name="userg_name" value="<?=$userg_name?>"/>
                </dd><br/>
      <div style="padding-right:120px" class="buttons">
		<input type="submit" name="txtSubmit" value="Create" class="button" />
                <input type="reset" value="Reset" class="button white" />
      </div>
</form>