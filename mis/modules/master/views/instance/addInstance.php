


<h1><?=$cpagetitle?> - <?=$sourceDetails['0']['source_name']?></h1>


<ul class="option-tab">
<li><a href="<?=site_url('master/instance/view_list/'.$source);?>" class="button">Back</a></li>
</ul>
<!-- start id-form -->
<?php 
		//form values
		#default values
		$formAction = site_url('master/instance/instanceform/'.$source);
		$id = '';
		$val = array();
		if(count($instanceDetails))
		{
			$val = $instanceDetails['0'];
			$formAction = site_url('master/instance/instanceform/'.$source.'/'.$val['id']);
			$id = $val['id'];
			$action = 'edit';
		}
		else
		{
			$formAction = site_url('master/instance/instanceform/'.$source);
			$action = 'add';
		}
		if(isset($_POST['action'])){ $val = $_POST; }
		$instance_name = isset($val["instance_name"])?$val["instance_name"]:"";
		$date = isset($val["date"])?mysql2date($val["date"]):""; 
		$remarks = isset($val["remarks"])?$val["remarks"]:""; 
	    $document  = isset($_POST["pre_document"])?$_POST["pre_document"]:@$val["document"];

?>

<form name="instanceForm" enctype="multipart/form-data" action="<?=$formAction?>" method="post" id="instanceForm" class="uniform"">
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" /> 
<input type="hidden" value="<?=$source?>" name="source" /> 

<dl class="inline">
	   <dt><label for="source_type">Instance Name : </label></dt>
       <dd>	   
        <input type="text" name="instance_name" value="<?=$instance_name?>" class="input-text required" size="40"  />
		<font class="req_field">*</font>
        <?=form_error('master_name', '<div class="errorMsg">', '</div>');?>
       </dd>
	 
       
      
      
	    <dt><label for="source_type">Date:</label></dt>
		<dd>
        <input type="text" name="date" value="<?=$date?>" class="input-text required datepicker"  size="40" />
		<font class="req_field">*</font><?=form_error('date', '<div class="errorMsg">', '</div>'); ?>
		</dd>
	 
     
	    <dt><label for="source_type">Remarks:</dt>
		<dd>
        <textarea name="remarks" rows="3" cols="40" class="input-text required" ><?=$remarks?></textarea>
		<font class="req_field">*</font><?=form_error('remarks', '<div class="errorMsg">', '</div>'); ?>
		</dd>
	  
      
       <dt><label for="source_type">Document:</dt>
        <dd>
        <input type="hidden" name="pre_document" value="<?=$document?>"/>
        <input type="file" name="document"  />
         <?php if(!empty($document)){ ?>
          <a href="<?=base_url()?>uploads/instance/<?=$document?>" target="_blank" class="button">Download</a>
         <?php }?>
        </dd>
       
 </dl>      
<div class="buttons">
		<input type="submit" value="Save" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
		
</div>	

</form>
<!-- end id-form  -->