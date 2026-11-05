<script type="text/javascript">
$(document).ready(function(){
	$("input[name='link']").change(function(){
		if($(this).val() != '')
			$('.loginField').show()
		else
			$('.loginField').hide()
	});
	
	if($("input[name='link']").val() != '')
	{
		$('.loginField').show()
	}
});
</script>
<ul class="option-tab">
<li><a href="<?=site_url('master/source/view_list/');?>" class="button">Back</a></li>
</ul>

<h1><?=$cpagetitle?></h1>
<!-- start id-form -->
<?php 
		//form values
		#default values
		$frequencyArray = array('Monthly','Quaterly','Half-Yearly','Yearly');
		$formAction = site_url('master/source/add');
		$id = '';
		$val = array();
		if(count($sourceDetails))
		{
			$val = $sourceDetails['0'];
			$formAction = site_url('master/source/sourceform/'.$val['id']);
			$id = $val['id'];
			$action = 'edit';
		}
		else
		{
			$formAction = site_url('master/source/sourceform');
			$action = 'add';
		}
		if(isset($_POST['action'])){ $val = $_POST; }
		$employee = isset($val["employee"])?$val["employee"]:"";
		$source_type = isset($val["source_type"])?$val["source_type"]:"";
		$source_name = isset($val["source_name"])?$val["source_name"]:"";
		$contact_person = isset($val["contact_person"])?$val["contact_person"]:""; 
		$designation = isset($val["designation"])?$val["designation"]:""; 
		$address = isset($val["address"])?$val["address"]:""; 
		$phone = isset($val["phone"])?$val["phone"]:""; 
		$mobile = isset($val["mobile"])?$val["mobile"]:"";
		$email = isset($val["email"])?$val["email"]:"";
		$fax = isset($val["fax"])?$val["fax"]:"";
		$frequency = isset($val["frequency"])?$val["frequency"]:""; 
		$date = isset($val["date"])?mysql2date($val["date"]):""; 
		$alert  = isset($val["alert"])?$val["alert"]:""; 
		$link  = isset($val["link"])?$val["link"]:""; 
		$username  = isset($val["username"])?$val["username"]:""; 
		$password  = isset($val["password"])?$val["password"]:""; 
		$pagecontent  = isset($val["pagecontent"])?$val["pagecontent"]:""; 
        $description  = isset($val["description"])?$val["description"]:""; 
		$document  = isset($_POST["pre_document"])?$_POST["pre_document"]:@$val["document"];

?>
<div class="clear" ></div>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div style="min-height:1050px !important;">
<form name="sourceForm" enctype="multipart/form-data" action="<?=$formAction?>" method="post" id="sourceForm"  class="uniform">
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" /> 
<dl class="inline">
   <dt><label for="name">Employee</dt>
   <dd>	
		<select id="employee" name="employee" >
        	<option value="">Select</option>
	 <?php foreach($usersList as $row) {
		 ?>
		<option value="<?=$row['emp_number']?>" <?php if($row['emp_number']==$employee){  echo 'selected'; } ?>><?=$row['emp_name']?></option>
		<?php } ?>
	 </select>
  </dd>
    
   <dt><label for="name">Source Type <font class="req_field">*</font> </dt>
   <dd>
		<select name="source_type"  class="required">
			<option value="">Select</option>
			<?php foreach($sourceType as $st) { ?>
			<option value="<?=$st['id']?>" <?php echo ($source_type==$st['id'])?('selected'):(''); ?>><?=$st['master_name']?></option>
			<?php } ?>
		</select>
		<?php 
		echo form_error('source_type', '<div class="errorMsg">', '</div>');
		?>
   </dd>
   <dt><label for="name">Source Name <font class="req_field">*</font></label></dt>
   <dd><input type="text" name="source_name" value="<?=$source_name?>" class="input-text required" size="40"  />
        <?=form_error('source_name', '<div class="errorMsg">', '</div>');?>
   </dd>
   
    <dt><label for="name">Contact Name <font class="req_field">*</font></dt>
	<dd>
        <input type="text" name="contact_person" value="<?=$contact_person?>" class="input-text required"  size="40" />
		<?=form_error('contact_person', '<div class="errorMsg">', '</div>'); ?>
   </dd>	
	
    <dt><label for="name">Designation<font class="req_field">*</font></label></dt>
	<dd> <input type="text"  type="text"  name="designation" value="<?=$designation?>" class="input-text required"  size="40" />
		<?=form_error('designation', '<div class="errorMsg">', '</div>'); ?>
   </dd>
	<dt><label for="name">Address<font class="req_field">*</font></label></dt>
	<dd>	
        <textarea name="address" rows="3" cols="40" class="input-text required" ><?=$address?></textarea>
		<?=form_error('address', '<div class="errorMsg">', '</div>'); ?>
   </dd>		
   <dt><label for="name">Phone(Office No.):</label></dt>
   <dd>	
        <input type="text" name="phone" value="<?=$phone?>" class="input-text phone"  size="40" />
   <dd>
   <dt><label for="name">Mobile:<label/></dt>
   <dd>	
        <input  type="text" name="mobile" value="<?=$mobile?>" class="input-text mobile"  size="40" />
   </dd>	  
   
   <dt><label for="name">E-Mail:</label></dt>
   <dd>
        <input type="text"  name="email" value="<?=$email?>" class="input-text email"  size="40" />
   </dd>
   		
   <dt><label for="name">Fax:</label></dt>
   <dd>
        <input type="text" name="fax" value="<?=$fax?>" class="input-text number"  size="40" />
   </dd>
   <dt>	<label for="name">Frequency<font class="req_field">*</font></label></dt>
   <dd>         
		<select name="frequency"  class="required">
				<option value="">Select</option>
				<?php foreach($frequencyArray as $key=>$value) { ?>
				<option value="<?=$value?>" <?php echo ($frequency==$value)?('selected'):(''); ?>><?=$value?></option>
				<?php } ?>
		</select>
		<?=form_error('frequency', '<div class="errorMsg">', '</div>'); ?>
   </dd>		
   <dt><label for="name">Date<font class="req_field">*</font></label></dt>
	
   <dd>
        <input type="text" name="date" value="<?=$date?>" class="input-text required datepicker"  size="40" />
		<?=form_error('date', '<div class="errorMsg">', '</div>'); ?>
   </dd>     
	   
	 <dt><label for="name">Alert<font class="req_field">*</font></label></dt>
	 <dd>      
        <label><input type="radio" name="alert" checked="checked" value="1" class="input-text required"  size="40" />&nbsp;Yes</label>
        <label><input type="radio" name="alert" value="0" class="input-text required"  size="40" />&nbsp;No</label>
		<?=form_error('alert', '<div class="errorMsg">', '</div>'); ?>
	</dd>   
     
    <dt><label for="name">Link:</label></dt>
	<dd>
        <input type="text" name="link" value="<?=$link ?>" class="url"  size="40" />
        <small>Please write link for username and password</small>
	</dd>	
    <dt class="loginField" style="display:none"> <label for="name">Username:</label></dt>
	<dd class="loginField" style="display:none">
        <input type="text" name="username" value="<?=$username?>" class="input-text"  size="40" />
	</dd>	
    <dt class="loginField" style="display:none"><label for="name">Password:</label></dt> 	 	
    <dd class="loginField" style="display:none">  
        <input type="text" name="password" value="<?=$password?>" class="input-text"  size="40" />
	<dd>	
	<dt><label for="name">Pagecontent:</label></dt>
    <dd>
	 	
        <textarea name="pagecontent" rows="3" cols="40" class="input-text" ><?=$pagecontent?></textarea>
	</dd>	
	 
	 <dt><label for="name">Description:</label></dt>
	 <dd>
         <textarea name="description" rows="3" cols="40" class="input-text" ><?=$description?></textarea>
     </dd>
      <dt><label for="name">Document:</label></dt>
     
     <dd>   <input type="hidden" name="pre_document" value="<?=$document?>"/>
        <input type="file" name="document" value="<?=$document ?>"   />
         <?php if(!empty($document)){ ?>
          <a href="<?=base_url()?>uploads/source/<?=$document?>" target="_blank" class="button">Download</a>
         <? }?>
     </dd>  
	  <dt> 
	    <dd>
           <input type="submit" value="Submit" name="txtSubmit" class="button" />
           <input type="reset" value="Reset" name="txtReset" class="button white" />
	    </dd>	
      </dt>
  </dl>
   

</form>
</div>
<!-- end id-form  -->