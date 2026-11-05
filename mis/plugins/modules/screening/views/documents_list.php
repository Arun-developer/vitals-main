<?php

$innovation = $this->uri->segment("3");
$this->load->model('Mscreening_documents');
$innovationChecklist = $this->Mscreening_documents->getAssignedChecklist($innovation);
$checklist = isset($innovationChecklist['0']);

$isAuth = false;
if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || $innovation['isAssociate'])
{
	$isAuth = true;
}
?>
<h1><?=$cpagetitle?>-<?=$name_of_enterprise;?></h1>
<?php 
$this->load->view('criteria_tab');

if($isAuth){ ?>
<br />
<ul class="option-tab">
	
   <?php
		if($this->session->userdata('user_type') != "") {

   if($checklist != "")  {  ?>
		<li><a href="<?=site_url('screening/assign_checklist/'.$innovation);?>" class="fancybox button">View Document Checklist</a></li>
        <?php }  if($checklist == "")   { ?>
		<li><a href="<?=site_url('screening/assign_checklist/'.$innovation);?>" class="fancybox button">Assign Document Checklist</a></li>
		
		<?php } 
		
		}
		?>	
</ul>
<?php } ?>
<br />
<br />
<form name="documents" action="<?=site_url('screening/documents/'.$this->uri->segment('3'));?>" enctype="multipart/form-data" method="post" id="documents" class="uniform">
<input type="hidden" name="innovation" value="<?=$innovation?>"  />
<input type="hidden" name="name_of_enterprise" value="<?=$name_of_enterprise?>"  />
<dl>
<?php
    $key = 0;
	$na = '';
	
	foreach($checkList as $row): 
	$na_new = $row['master_name'];
	if($na_new != $na)
	{
		$na = $na_new;
		$key = 0;
	?>
    <dt><h2><?=$row['master_name']; ?></h2><dt>
    <dd></dd>
    <?php }?> 
<dt><label for=""><?php echo ++$key.')&nbsp;&nbsp;'.$row['document_description']; ?></label></dt>
<dd style="border-bottom:1px dashed #ccc; padding:5px; margin-bottom:20px;">
<?php
$cfValue = (isset($_POST['txtSubmit']))?$_POST[$row['id']]:$row['documents'];
?>
<input type="file" size="40"  name="<?=$row['id']?>"  />
<?php if($cfValue){?>
<input type="hidden" value="<?=$cfValue?>" name="olddocument_<?=$row['id']?>"  />
<?php } ?>
<?php
		if($cfValue!=''){ ?> <a href="<?=base_url()?>uploads/screening/<?=$cfValue?>" style="text-decoration:none;" target="_blank">(<?=$cfValue?>)&nbsp;&nbsp;<img src="<?=base_url();?>source/template/images/icons/download.gif" alt="Download" height="16"  /></a><?php }
?>
</dd>

<?php
endforeach;
?>
</dl>
<div class="buttons">
<input type="submit" class="button" name="txtSubmit" value="Save" id="submit" />
<input type="reset" class="button white" name="txtReset" value="Reset" />
</div>
</form>
