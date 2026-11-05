<h1><?=$cpagetitle?></h1>
<form name="programStageForm" action="<?=site_url('master/program_stage/add');?>" method="post" id="programStageForm" class="uniform" >
<dl class="inline">

        <dt><label for="programtype">Program Type : </label></dt>
     	<dd>
		<?php $program_type = isset($_REQUEST["program_type"])?$_REQUEST["program_type"]:'';
				?>
				<select name="program_type"  class="required" id="programType">
						<option value="">Select</option>
						<?php foreach($programType as $st) { ?>
						<option value="<?=$st['id']?>" <?php echo ($program_type==$st['master_name'])?('selected'):(''); ?>><?=$st['master_name']?></option>
						<?php } ?>
						</select>
				<?php 
				echo '<font class="req_field">*</font>'.form_error('program_type', '<div class="errorMsg">', '</div>');
		?></dd>
	
	   <dt><label for="programserviceoffering">Program Service Offering:</label></dt>
	   <dd>
        <select name="program_service_offering"  class="required" id="programServiceOffering">
						<option value="">-Select-</option>
		</select>
		<font class="req_field">*</font>
        <?=form_error('program_service_offering', '<div class="errorMsg">', '</div>');?>
        </dd>
	 
  
	    <dt><label for="program stage">Program Stage: </label></dt>
		<dd>
      	<?php $title = isset($_REQUEST["title"])?$_REQUEST["title"]:'';?>
        <input type="text" name="title" value="<?=$title?>" class="input-text required" size="40"  />
		<font class="req_field">*</font>
        <?=form_error('title', '<div class="errorMsg">', '</div>');?>
        </dd>
	 
 </dl>    
  <div class="buttons">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
  </div>
</form>
<!-- end id-form  -->