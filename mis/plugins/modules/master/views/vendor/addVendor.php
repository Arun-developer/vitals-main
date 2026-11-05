<script type="text/javascript">
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
		$("#vendorForm").validate();
	});
</script>
<!-- start id-form -->
<form name="templateForm" enctype="multipart/form-data" action="<?=site_url('master/vendor/add');?>" method="post" id="vendorForm" >
	<table width="90%" border="0" align="center" cellpadding="5" cellspacing="2" id="id-form">
	<tr>
	   <td width="24%" align="right" valign="top">Vendor Name : </td>
		<td width="2%" align="right" valign="top">&nbsp; </td>
		<td width="74%">
		<?php
		$vendor_name = isset($_REQUEST["vendor_name"])?$_REQUEST["vendor_name"]:"";
		echo form_input('vendor_name',$vendor_name,'class="required"');
		echo '<font class="req_field">*</font>'.form_error('messagetype', '<div class="errorMsg">', '</div>');?></td>
	   </tr>
	   <tr>
   <td align="right" valign="top">website : </td>
	<td align="right">&nbsp;</td>
	<td valign="top">
		<?php 
		$website = isset($_REQUEST["website"])?$_REQUEST["website"]:"";
		echo form_input("website",$website);
		echo form_error('website', '<div class="errorMsg">', '</div>');
		?>
	</td>
	</tr>
	<tr>
   <td align="right" valign="top">Company Address :</td>
	<td align="right">&nbsp;</td>
	<td valign="top">
		<?php 
		$address = isset($_REQUEST["address"])?$_REQUEST["address"]:"";
		echo '<textarea name="address">'.$address.'</textarea>';
		echo form_error('address', '<div class="errorMsg">', '</div>');
		?>
	</td>
	</tr>
	<tr>
   <td align="right" valign="top">Contact Person :</td>
	<td align="right">&nbsp;</td>
	<td valign="top">
		<?php 
		$contact_person = isset($_REQUEST["contact_person"])?$_REQUEST["contact_person"]:"";
		echo form_input("contact_person",$contact_person);
		echo form_error('contact_person', '<div class="errorMsg">', '</div>');
		?>
	</td>
	</tr>
	<tr>
   <td align="right" valign="top">Contact Number :</td>
	<td align="right">&nbsp;</td>
	<td valign="top">
		<?php 
		$contact_no = isset($_REQUEST["contact_no"])?$_REQUEST["contact_no"]:"";
		echo form_input("contact_no",$contact_no);
		echo form_error('contact_no', '<div class="errorMsg">', '</div>');
		?>
	</td>
	</tr>
	<tr>
   <td align="right" valign="top">Email Address :</td>
	<td align="right">&nbsp;</td>
	<td valign="top">
		<?php 
		$vendor_email = isset($_REQUEST["vendor_email"])?$_REQUEST["vendor_email"]:"";
		echo form_input("vendor_email",$vendor_email,'class="required email"');
		echo '<font class="req_field">*</font>'.form_error('vendor_email', '<div class="errorMsg">', '</div>');
		?>
	</td>
	</tr>
	
 
<tr>
   <td align="right">&nbsp;</td>
	<td align="right">&nbsp;</td>
	<td valign="top">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
		<?php echo "&nbsp;&nbsp;".anchor('master/vendor','Back','class="button"');?>		</td>
	</tr>
</table>
</form>
<!-- end id-form  -->