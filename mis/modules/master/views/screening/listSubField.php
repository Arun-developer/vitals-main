<?php
$nullLink = "javascript:void(0);";
?>
<h1><?=$cpagetitle?> - <?=$screeningDetails['0']['label']?></h1>

<div style=" float:right; text-align:right;width:100%;">
<?php echo anchor('master/screening_master/sub_field/'.$pid,'Add Sub Field','class="button fancybox"'); ?>&nbsp;&nbsp;
<?php 
if($screeningDetails['0']['pid'] != 0)
	echo anchor('master/screening_master/sub_fieldlist/'.$screeningDetails['0']['pid'],'Back','class="button"');
else
	echo anchor('master/screening_master/view_list/','Back','class="button"');?>
</div>
<br />
<br />
<!--start table-content  -->
 <div id="user-grid" class="gtable sortable">
	<table width="100%" class="items">
	<thead>
	<tr>
    <th><a href="<?=$nullLink?>" field="label">Parent Value</a></th>
	<th><a href="<?=$nullLink?>" field="label">Label</a></th>
    <th><a href="<?=$nullLink?>" field="input_type">Input Type</a></th>
    <th><a href="<?=$nullLink?>" field="required">Required</a></th>
    <th><a href="<?=$nullLink?>" field="value">values</a></th>
	<th><a href="<?=$nullLink?>" field="status">Status</a></th>
    <th><a href="<?=$nullLink?>" field="status">Sub-Fields</a></th>
	<th class="head">Action</th>
	</tr>
    </thead>
	<tbody>
	<?php
	if(count($subfieldList))
	{    
		$r=1;
		foreach($subfieldList as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
			<tr class="<?=$row_type?>">
            <td align="left" valign="middle"><?=$row["parent_value"];?></td>
			<td align="left" valign="middle"><?=$row["label"];?></td>
            <td align="left" valign="middle"><?=$row["input_type"];?></td>
            <td align="left" valign="middle"><?=ucfirst($row["required"]);?></td>
            <td align="left" valign="middle"  width="400"><?=(is_array($row["value"]))?implode(',',$row["value"]):$row["value"];?></td>
			<td align="left" valign="middle" width="60">
			<? if($row["status"]=='1')
			{
				 echo anchor('master/screening_master/changestatus/'.$row["id"].'/0/'.$pid.'/sub',"Active",'class="button"'); 		
			}else{ 
				echo anchor('master/screening_master/changestatus/'.$row["id"].'/1/'.$pid.'/sub',"Inactive",'class="button"');
			}
			?></td>
              <td nowrap="nowrap" width="40">
            <?php echo anchor('master/screening_master/sub_fieldlist/'.$row["id"],"Sub-Fields",'class=""');?>
            </td>
			<td nowrap="nowrap" width="70">
			<?php echo anchor('master/screening_master/sub_field/'.$pid.'/'.$row["id"],"Edit",'class="button fancybox"');?>
			<a href="<?=$nullLink?>" url="<?=site_url('master/screening_master/delete/'.$row["id"].'/'.$pid.'/sub')?>" class="button confirmDelete" >Delete</a>
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
	<?
	} ?>
	</tbody>
	</table>
	<!-- Paging style -->
	</div>   
