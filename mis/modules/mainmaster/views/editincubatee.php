<?php
$formAction = "";
$val = array();
if (count($incubateelist) > 0) {

    $action = 'edit';
    $val = $incubateelist[0];
    $formAction = site_url('mainmaster/useraccess/saveincubatee/' . $val['innovation']);
    $name = isset($val["user_name"]) ? $val["user_name"] : "";
    $status = isset($val["status"]) ? $val["status"] : "";
    $password = isset($val["password"]) ? $val["password"] : "";
} else {
    $formAction = site_url('media/form/' . $innovationid);
    $action = 'add';
    $name = isset($_REQUEST["user_name"]) ? $_REQUEST["user_name"] : "";
    $status = isset($_REQUEST["status"]) ? $_REQUEST["status"] : "";
    $password = isset($_REQUEST["user_password"]) ? $_REQUEST["user_password"] : "";
}

?>
<h1><?=$cpagetitle?> </h1>
<ul class="tabs">
	<li class="<?php echo ($this->uri->segment('3') == 'useraccess') ? 'selected' : ''; ?>"><a href="<?=site_url('mainmaster/useraccess/index')?>" >Add User Access</a></li>
	<li class="<?php echo ($this->uri->segment('3') == 'essusers') ? 'selected' : ''; ?>"><a href="<?=site_url('mainmaster/useraccess/essusers')?>">Add Users</a></li>
	<li class="<?php echo ($this->uri->segment('3') == 'addgroup') ? 'selected' : ''; ?>"><a href="<?=site_url('mainmaster/useraccess/adduser')?>">Add User Group</a></li>
	<li class="<?php echo ($this->uri->segment('3') == 'addadmin') ? 'selected' : ''; ?>"><a href="<?=site_url('mainmaster/useraccess/addadmin')?>">Add Admin</a></li>
	<li class="<?php echo ($this->uri->segment('3') == 'addincubatee') ? 'selected' : ''; ?>"><a href="<?=site_url('mainmaster/useraccess/addincubatee')?>">Add Incubatee</a></li>
</ul>
<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=$formAction;?>" method="post" id="vendorForm" >
<input type="hidden" value="edit" name="action" />
<input type="hidden" value="<?=$val['innovation'];?>" name="id"/>
<dl class="inline">
	<dt><label for="request_topic_">Name<span style="color:#F00"  class="req_field">*</span></label></dt>
	<dd>
		<input type="text" name="name" class="medium required" size="50" value="<?=$name;?>"/>
	</dd>
	<dt><label for="description">Status</label></dt>
	<dd>
	<select name="status">
	<option value="1"  <?=($status == '1') ? 'selected' : '';?> >Enabled</option>
	<option value="0" <?=($status == '0') ? 'selected' : '';?>>Disabled</option>
	</select>
	</dd>
	<div class="buttons">
		<input type="submit" name="txtSubmit" value="Submit" class="button" />
		<input type="reset" value="Reset" class="button white" />
	</div>
</dl>
</form>

<!-- end id-form  -->