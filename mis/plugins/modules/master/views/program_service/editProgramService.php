
<!-- start id-form -->
<?php foreach($programServiceDetails as $row):?>
<form name="program_serviceForm" enctype="multipart/form-data" action="<?=site_url('master/program_service/edit/'.$row['id']);?>" method="post" id="program_serviceForm" class="uniform" >
<dl class="inline">
  
      <dt><label for="name">Source Type :</label></dt>
      <dd>
		<?php $program_type = isset($_REQUEST["program_type"])?$_REQUEST["program_type"]:$row['program_type'];
				?>
				<select name="program_type"  class="required">
						<option value="">Select</option>
						<?php foreach($programType as $st) { ?>
						<option value="<?=$st['id']?>" <?php echo ($program_type==$st['id'])?('selected'):(''); ?>><?=$st['master_name']?></option>
						<?php } ?>
						</select>
				<?php 
				echo '<font class="req_field">*</font>'.form_error('program_type', '<div class="errorMsg">', '</div>');
		?>
       </dd> 
	  
	 <dt><label for="name">Program Service :</label></dt> 
	 <dd>
		<?php $title = isset($_REQUEST["title"])?$_REQUEST["title"]:$row['title'];?>
        <input type="text" name="title" value="<?=$title?>" class="input-text required" size="40"  />
		<font class="req_field">*</font>
        <?=form_error('title', '<div class="errorMsg">', '</div>');?>
     </dd>
	 
     <dt><label for="description">Description:</dt>
		<dd>
		<?php $description = isset($_REQUEST["description"])?$_REQUEST["description"]:$row['description'];?>
        <textarea id="editor" name="description"><?=$description?></textarea>
        </dd>
        
 </dl>     
 <div class="buttons">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
 </div>	
</form>
<?php endforeach; ?>
<!-- end id-form  -->