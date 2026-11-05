<?php
$nullLink = 'javascript:void(0);';
$form_name = 'templete_list';
echo "<h2>".@$cpagetitle."</h2>";
?>
<div align="center">
<label for="Module">Module:</label>
		<select name="module" onchange="change(this.value)">
		<option value="">-select-</option>
		<option value="mis">RAMP incubation</option>
		<option value="ais">Admin</option>
		<option value="hris" selected="selected">HR</option>
		</select>	
</div><br/>
	<div id="cssform">

	<? $sort=(@$sort_order == 'desc') ? ('asc') : ('desc'); ?>
		<table cellpadding="0" cellspacing="0" border="0" id="table" class="tablelist gtable">
		<thead>
			<tr>
			<th class="head">Template Type</th>
			<th class="head">Message Subject</th>
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
			<td align="left" valign="middle">Timesheet<!--<?=$row["messagetype"]; ?>--></td>
			<td align="left" valign="middle"><?=$row["message"]?></td>
			<td align="left" valign='middle' nowrap="nowrap" >
			<?php echo anchor('master/mailtemplate/hrform/edit/'.$row["id"],"<img src='".base_url()."source/template/images/icons/edit.png' border='0' height='20' / >");	?>
			<div id="delete_<?=$row["id"]?>" title="Confirmation Box" class="confirm_box" style="display:none" >
			<div class="confirm_msg">Are you sure want to delete?</div>
			<div class="comfirm_button" style="float:right">
			<?php echo anchor('master/mailtemplate/view_mailtemplate/edit/'.$row["id"],"Yes");  ?> 
			<a href="javascript:void(0);" onclick="closeDialogForm('delete_<?=$row["id"]?>')" >No</a></div></div>
			</td>
			<tr>
			<td>Subordiante - Approval</td>
			<td><?=$mail['approval-subject'];?></td>
			
			<td><a href="<?=site_url('master/mailtemplate/readhrmail/subordinate/approval')?>"><img src="<?=base_url()?>source/template/images/icons/edit.png" height="20"/></a></td></tr>
			<tr>
			<td>Subordinate - Assign</td>
			<td><?=$mail['assign-subject'];?></td>
			<td><a href="<?=site_url('master/mailtemplate/readhrmail/subordinate/assign')?>"><img src="<?=base_url()?>source/template/images/icons/edit.png" height="20"/></a></td></tr>
			<tr>
			<td>Subordinate - Cancelled</td>
			<td><?=$mail['cancelled-subject'];?></td>
			<td><a href="<?=site_url('master/mailtemplate/readhrmail/subordinate/cancelled')?>"><img src="<?=base_url()?>source/template/images/icons/edit.png" height="20"/></a></td></tr>
			<tr>
			<td>Subordinate - Rejected</td>
			<td><?=$mail['reject-subject'];?></td>
			<td><a href="<?=site_url('master/mailtemplate/readhrmail/subordinate/rejected')?>"><img src="<?=base_url()?>source/template/images/icons/edit.png" height="20"/></a></td></tr>
			<tr>
			<td>Supervisor - applied</td>
			<td><?=$mail['applied-subject'];?></td>
			<td><a href="<?=site_url('master/mailtemplate/readhrmail/supervisor/applied')?>"><img src="<?=base_url()?>source/template/images/icons/edit.png" height="20"/></a></td></tr>
			<tr>
			<td>Supervisor - Cancelled</td>
			<td><?=$mail['cancel-subject'];?></td>
			<td><a href="<?=site_url('master/mailtemplate/readhrmail/supervisor/cancelled')?>"><img src="<?=base_url()?>source/template/images/icons/edit.png" height="20"/></a></td></tr>
			</tr>
			<?php 
			}
		}
		else
		{ ?>
			<tr>
			<td colspan='9' align='center'>No Records found!</td>
			</tr>
		<?
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
