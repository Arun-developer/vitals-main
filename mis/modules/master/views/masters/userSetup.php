
<h1 style="margin: 15px 0 10px;"><?=$cpagetitle?></h1>
<!-- start id-form -->
<?php $setup = $userSetup;?>
<form name="reportForm" enctype="multipart/form-data" action="<?=site_url('master/user_setup_add');?>" method="post" id="reportForm" >
<dl class="inline">
	   
	<dt><label for="ceo">CEO : </label></dt>
	<dd>
	<?php $ceo = isset($_REQUEST["ceo"])?$_REQUEST["ceo"]:$setup['ceo']; ?>
	<select name="ceo" id="ceo" >
	<option value="">Select</option>
	<?php foreach($usersList as $row) { ?>
	<option value="<?=$row['emp_number']?>" <?php echo ($ceo==$row['id'])?('selected'):(''); ?>><?=$row['emp_name']?></option>
	<?php } ?>
	</select>
	<font class="req_field"></font>
	<?php echo form_error('report_type', '<div class="errorMsg">', '</div>'); ?>
	</dd>
	 

    <dt><label for="message type">Chief Incubation Officer :	</label></dt>
	<dd>
	<?php $cio = isset($_REQUEST["cio"])?$_REQUEST["cio"]:$setup['cio'];     ?>
		<select name="cio" id="cio" >
		<option value="">Select</option>
		<?php foreach($usersList as $row) { ?>
		<option value="<?=$row['emp_number']?>" <?php echo ($cio==$row['emp_number'])?('selected'):(''); ?>><?=$row['emp_name']?></option>
		<?php } ?>
		</select>
		<font class="req_field"></font>
		<?php echo form_error('cio', '<div class="errorMsg">', '</div>'); ?>
	</dd>


    <dt><label for="incubation committee">Incubation Committee Members:</dt>
	<dd>
	<?php $icm = isset($_REQUEST["icm"])?$_REQUEST["icm"]:$setup['icm'];?>
	<select id="icm" class="multiselect" multiple="multiple" name="icm[]" >
	 <?php foreach($usersList as $row) {
			
		 ?>
		<option value="<?=$row['emp_number']?>" <?php if(php72_in_array($row['emp_number'],$icm)){  echo 'selected'; } ?>><?=$row['emp_name']?></option>
		<?php } ?>
	
	 </select>
	 <font class="req_field"></font>
	<?php echo form_error('icm', '<div class="errorMsg">', '</div>'); ?>
	</dd>


   	 <dt><label for="associate">Associate: Business Incubation</dt>
	<dd>
	<?php $abi = isset($_REQUEST["abi"])?$_REQUEST["abi"]:$setup['abi'];?>
	<select id="abi" class="multiselect" multiple="multiple" name="abi[]" >
	 <?php foreach($usersList as $row) {
			
		 ?>
		<option value="<?=$row['emp_number']?>" <?php if(php72_in_array($row['emp_number'],$abi)){  echo 'selected'; } ?>><?=$row['emp_name']?></option>
		<?php } ?>
	
	 </select>
	 <font class="req_field"></font>
	<?php echo form_error('abi', '<div class="errorMsg">', '</div>'); ?>
	</dd>

		<?php $finance = unserialize($settings[0]["finance"]); ?>

	<dt><label for="associate">Finance Members</dt>
    <dd>
	  <select id="finance" class="multiselect" multiple="multiple" name="finance[]" >
	  <?php foreach($userListFinance as $rowsuser) { 
          
          ?>
	  <option value="<?=$rowsuser['id']?>" <?php  echo (php72_in_array($rowsuser['id'],$finance))?('selected'):(''); ?>>
		<?=$rowsuser['user_name']?>
	  </option>
	  <?php } ?>
	</select>
	</dd>



    <dt><label for="pre incubation">Pre - Incubation Committee</label></dt>
	<dd>
    	<?php $pre_ic = isset($_REQUEST["pre_ic"])?$_REQUEST["pre_ic"]:$setup['pre_ic'];?>
		<input type="text" value="<?=$pre_ic?>" size="40" name="pre_ic" class="input-text email" />
    </dd>

</dl>
<div class="buttons">
<input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('partner_id');?>" />
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
</div>

</form>
<!-- end id-form  -->
