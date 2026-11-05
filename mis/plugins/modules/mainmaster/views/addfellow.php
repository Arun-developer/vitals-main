<?php 
$formAction = "";
$val = array();
?>	
<h1><?=$cpagetitle?> </h1>
<!-- start id-form -->
<form action="<?=site_url('mainmaster/useraccess/addfellow');?>" method="post" enctype="multipart/form-data">   
<input type="hidden" value="" name="action" />
<input type="hidden" value="" name="id" /> 
<dl class="inline">

        <dt><label for="id">First Name<span style="color:#F00"  class="req_field">*</span></label></dt>
        <dd>
        <input type="text" name="mod_id" class="medium required" value="" readonly="readonly" />
        </dd>
        <dt><label for="Module Name">Middle Name</label></dt>
        <dd><input type="text" name="name" class="medium required" value=""/>
        </dd>
        <dt><label for="Owner">Last Name</label></dt>
        <dd><input type="text" name="owner" class="medium required" value=""/>
        </dd>
        <dt><label for="Description">Photo</label></dt>
        <dd><input type="file" name="Photo" class="medium required" value=""/>
        </dd>
        <br/>
      <div style="padding-right:120px" class="buttons">
                 <input type="submit" name="txtSubmit" value="Create" class="button" />
                 <input type="reset" value="Reset" class="button white" />
      </div>
</dl>             
</form>