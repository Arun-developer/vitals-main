
<h1><?=$cpagetitle?></h1>
<form name="program_serviceForm" enctype="multipart/form-data" action="<?=site_url('master/program_service/add');?>" method="post" id="program_serviceForm"  class="uniform" >
<dl class="inline">
   
        <dt><label for="name">Source Type <font class="req_field">*</font> </label></dt>
     	<dd>
		<?php $program_type = isset($_REQUEST["program_type"])?$_REQUEST["program_type"]:'';
				?>
				<select name="program_type"  class="required">
						<option value="">Select</option>
						<?php foreach($programType as $st) { ?>
						<option value="<?=$st['id']?>" <?php echo ($program_type==$st['master_name'])?('selected'):(''); ?>><?=$st['master_name']?></option>
						<?php } ?>
						</select>
				<?php 
				echo form_error('program_type', '<div class="errorMsg">', '</div>');
		?></dd>

	
	   <dt><label for="name">Program Service <font class="req_field">*</font> </dt>
		<dd>
		<?php $title = isset($_REQUEST["title"])?$_REQUEST["title"]:"";?>
        <input type="text" name="title" value="<?=$title?>" class="input-text required" size="40"  />
		
        <?=form_error('title', '<div class="errorMsg">', '</div>');?>
        </dd>

        <dt><label for="description">Description:</dt>
		<dd>
		<?php $description = isset($_REQUEST["description"])?$_REQUEST["description"]:"";?>
        <textarea id="editor" name="description"><?=$description?></textarea>
        </dd>
     
  </dl>    
   <div class="buttons">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
   </div>

</form>
<!-- end id-form  -->