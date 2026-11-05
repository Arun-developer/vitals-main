<?php 
$formAction = "";
$val = array();
if(php72_count($module)>0)
{  
        $formAction = site_url('mainmaster/useraccess/addmodule/'.$mod_id);
        $action = 'edit';
        $val = $module['0'];
        $id = $val['mod_id'];
        $mod_id = isset($val["mod_id"])?$val["mod_id"]:"";
        $owner = isset($val["owner"])?$val["owner"]:"";
        $owner_email = isset($val["owner_email"])?$val["owner_email"]:"";
        $version = isset($val["version"])?$val["version"]:"";
        $description = isset($val["description"])?$val["description"]:"";
}
else
{
        $key = $mod_id[0]['mod_id'];
        $formAction = site_url('mainmaster/useraccess/addmodule/');  
        $action = 'add';
        $id = isset($_REQUEST["id"])?$_REQUEST["id"]:"";
        $name = isset($_REQUEST["name"])?$_REQUEST["name"]:"";
        $owner = isset($_REQUEST["owner"])?$_REQUEST["owner"]:"";
        $owner_email = isset($_REQUEST["owner_email"])?$_REQUEST["owner_email"]:"";
        $version= isset($_REQUEST["version"])?$_REQUEST["version"]:"";
        $description= isset($_REQUEST["description"])?$_REQUEST["description"]:"";
}
?>	
<h1><?=$cpagetitle?> </h1>
<!-- start id-form -->
<form action="<?=$formAction;?>" method="post" enctype="multipart/form-data">   
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" /> 
<dl class="inline">
<?php
if($action == "add")
{
if(!$key)
{
	$key = "MOD".'001';
}
else
{  
	$num = substr($key,3);
	$cnt = strlen($num);
	$num++;
	$num1 = str_pad($num,$cnt,0,STR_PAD_LEFT);
	$mod_id = "MOD".$num1;
}
}
?>
        <dt><label for="id">User Group ID<span style="color:#F00"  class="req_field">*</span></label></dt>
        <dd>
        <input type="text" name="mod_id" class="medium required" value="<?=$mod_id;?>" readonly="readonly" />
        </dd>
        <dt><label for="Module Name">Module Name</label></dt>
        <dd><input type="text" name="name" class="medium required" value="<?=$name?>"/>
        </dd>
        <dt><label for="Owner">Module Owned By</label></dt>
        <dd><input type="text" name="owner" class="medium required" value="<?=$owner?>"/>
        </dd>
        <dt><label for="Owner_email">Email</label></dt>
        <dd><input type="text" name="owner_email"  class="medium required" value="<?=$owner_email?>"/>
        </dd>
        <dt><label for="Version">Version</label></dt>
        <dd><input type="text" name="version" class="medium required" value="<?=$version?>"/>
        </dd>
        <dt><label for="Description">Module Name</label></dt>
        <dd><input type="text" name="description" class="medium required" value="<?=$description?>"/>
        </dd>
        <br/>
      <div style="padding-right:120px" class="buttons">
                <input type="submit" name="txtSubmit" value="Create" class="button" />
                <input type="reset" value="Reset" class="button white" />
      </div>
</dl>             
</form>