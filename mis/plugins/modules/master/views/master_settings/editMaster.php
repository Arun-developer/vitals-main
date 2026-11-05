<h1><?=$cpagetitle?></h1>

<div style=" float:right; text-align:right;width:100%;">

	<?php echo anchor('master/master_settings/view_list'.'/'.$masterPage,'Back','class="button"'); ?>

</div>

<!-- start id-form -->

<?php 	foreach($masterDetails as $row): ?>

<form name="masterForm" enctype="multipart/form-data" action="<?=site_url('master/master_settings/edit/'.$row['id']);?>" method="post" id="masterForm" class="uniform" >

<?php echo form_hidden('id',$row['id']); ?>

<dl class="inline">

            <dt><label for="master_type">Master Type</label></dt>

            <dd>

				<?php $master_type = isset($_REQUEST["master_type"])?$_REQUEST["master_type"]:$row["master_type"]; ?>

				<input name="master_type"  class="required input-text"  readonly value="<?=$row["master_type"]?>">

				<?php 

				echo '<font class="req_field">*</font>'.form_error('master_type', '<div class="errorMsg">', '</div>');

				?>

            </dd>

             <dt><label for="master_name">Master Name</label></dt>

            <dd>

             <?php $master_name = isset($_REQUEST["master_name"])?$_REQUEST["master_name"]:$row["master_name"];

				echo form_textarea("master_name",$master_name,'class="input-text required"');

				echo '<font class="req_field">*</font>'.form_error('master_name', '<div class="errorMsg">', '</div>');

		     ?>

            </dd>

 </dl>          

 <div class="buttons">

    <button type="submit" class="button" name="txtSubmit">Save</button>

    <button type="reset" class="button white">Reset</button>

</div>



</form>

<?php endforeach; ?>

<!-- end id-form  -->



	