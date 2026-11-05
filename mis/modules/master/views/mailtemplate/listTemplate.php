
<?php
	echo "<h2>".@$cpagetitle."</h2>";
?>
<div align="center">
<label for="Module">Module:</label>
		<select name="module" onchange="change(this.value)">
		<option value="">-select-</option>
		<option value="mis" >RAMP incubation</option>
		<option value="ais" selected="selected">Admin</option>
		<option value="hris">HR</option>
		</select>	
</div><br/>
	<div id="cssform" align="center">
	<?php 
	echo form_open('master/mailtemplate/view_mailtemplate/search',"name=".$form_name); ?>
	<?php echo form_label('Template Type');
		  $message_type = isset($_REQUEST["message_type"])?$_REQUEST["message_type"]:"";
		  $messageArray = array('Book ' => 'Library',
		  						'Travel' => 'Travel',
								'Asset' => 'Asset',
								'Dispatch' => 'Dispatch');
		  ?>
		  <select name="message_type">
			  <option value="">Select</option>
			  <?php foreach($messageArray as $key => $value): ?>
			  <option value="<?=$key?>" <?php echo ($message_type== $key)?('selected'):(''); ?>><?=$value?></option>
 			  <?php endforeach;?> 
 		 </select>	
		  <?php
		  echo form_label('Status');
		  $status = isset($_REQUEST["status"])?$_REQUEST["status"]:"";
			  ?>
			  <select name="status">
			  <option value="">Select</option>
			  <option value="0" <?php echo ($status== '0')?('selected'):(''); ?>>Inactive</option>
			  <option value="1" <?php echo ($status== '1')?('selected'):(''); ?>>Active</option>
			  </select>	
<?php 
	$sort_column = isset($_REQUEST["sort_column"])?$_REQUEST["sort_column"]:"";
	echo form_hidden('sort_column',$sort_column);
	$sort_order = isset($_REQUEST["sort_order"])?$_REQUEST["sort_order"]:"";
	echo form_hidden('sort_order',$sort_order);	

	echo form_label('');
	$data = array ( 'name' => 'txtsubmit', 'id' => 'txtsubmit' ,'class' =>'button' , 'value' => 'Search');
	echo form_submit($data);?>
	</div> 
	<div id="cssform">

	<?php $sort=(@$sort_order == 'desc') ? ('asc') : ('desc'); ?>
		<table cellpadding="0" cellspacing="0" border="0" id="table" class="tablelist gtable">
		<thead>
			<tr>
			<th class="head">Template Type</th>
			<th class="head">Message Subject</th>
			<th class="head">Status</th>
			<th class="head">Action</th>
			</tr>
		</thead>
		
		<tbody>
		<?php
		if(count($templateList))
		{    
			$r=1;
			foreach($templateList as $row)
			{
				$row_type = ($r%2 == 0) ? ('evenrow'):('oddrow');
				$r++;
			?>
			<tr class="<?=$row_type?>">
			<td align="left" valign="middle"><?=$row["messagetype"]; ?></td>
			<td align="left" valign="middle"><?=$row["messagesubject"]?></td>
			
			<td align="left" valign="middle"><?php if($row["status"]=='1') { echo anchor('master/mailtemplate/view_mailtemplate/status/'.$row["id"].'/0',"<img src='".base_url()."source/template/images/icons/active.png' border='0'  / >"); }else{ echo anchor('master/mailtemplate/view_mailtemplate/status/'.$row["id"].'/1',"<img src='".base_url()."source/template/images/icons/inactive.png' border='0'  / >"); }
			?></td>
			<td align="left" valign='middle' nowrap="nowrap" >
			<?php echo anchor('master/mailtemplate/view_mailtemplate/edit/'.$row["id"],"<img src='".base_url()."source/template/images/icons/edit.png' border='0' height='20' / >");	?>
			<div id="delete_<?=$row["id"]?>" title="Confirmation Box" class="confirm_box" style="display:none" >
			<div class="confirm_msg">Are you sure want to delete?</div>
			<div class="comfirm_button" style="float:right">
			<?php echo anchor('master/mailtemplate/view_mailtemplate/edit/'.$row["id"],"Yes");  ?> 
			<a href="javascript:void(0);" onclick="closeDialogForm('delete_<?=$row["id"]?>')" >No</a></div></div>
			</td>
			</tr>
			<?php 
			}
		}
		else
		{ ?>
			<tr>
			<td colspan='9' align='center'>No Records found!</td>
			</tr>
		<?php
		} ?>
			 </tbody></table>
	
	
	<br>
	<?=$this->pagination->create_links($form_name);?>
    </div>
	<?=form_close();?>
<script type="text/javascript">
function change(value)
{
	var value = value;
	if(value == 'mis')
	{
		location.href="<?=site_url('master/mailtemplate/view_list')?>";	
	}
	else if(value == 'ais')
	{
		location.href="<?=site_url('master/mailtemplate/view_mailtemplate')?>";	
	}
	else
	{
		location.href="<?=site_url('master/mailtemplate/hrismail')?>";	
	}
	
}
</script>
