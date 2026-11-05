<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();
$if = (!$isincubAuth);
?>
<h1><?=$cpagetitle ?></h1>
<!--start table-content  -->


 <div id="user-grid" class="gtable sortable">
	<table width="100%" class="items">
	<thead>
	<tr>
    <th><a href="<?=$nullLink?>" field="value">Created By</a></th>
	<th><a href="<?=$nullLink?>" field="status">Link </a></th>
	<th><a href="<?=$nullLink?>" field="label">Documents</a></th>
	</tr>
    </thead>
	<tbody>
	<?php
	if(count($linkdoc))
	{    
		$r=1;
		foreach($linkdoc as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
			<tr class="<?=$row_type?>">
            <td align="left" valign="middle"><?= !empty($row["created_emp"]) ? $row['created_emp'] : 'Admin';?></td>
            <td align="left" valign="middle"><?=$row["link"];?></td>
			<td align="left" valign="middle"><?=$row['documents']; ?>
            <a href="<?=base_url().'uploads/assessment/'.$row['documents']?>"  target="_blank"><img src="<?=base_url();?>source/template/images/icons/download.gif" title="Download" height="25" /></a></td>
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
	
	
	<br/><br/>
	
