<?php
$nullLink = 'javascript:void(0);';
$form_name = 'instance_list';
?>

<h1><?=$cpagetitle?> - <?=$sourceDetails['0']['source_name']?></h1>

<form id="company_list" action="<?=site_url('master/instance/view_list/'.$source)?>" method="post" name="<?=$form_name?>">
<input type="hidden"  name="ordertype" value="<?=$ordertype?>"  />
<input type="hidden"  name="orderby" value="<?=$orderby?>"  />
<div class="searchBox" style=" <?=($_POST)?'':'display:none;'?>"  >
<dl class="inline">
   <dt><label for="source_type">Instance Name:</dt>
   <dd>
		<?php $source_name = isset($_REQUEST['source_name'])?$_REQUEST['source_name']:'';?>
		<input type="text"  name="source_name" class="input-text" value="<?=$source_name?>"  />
   </dd>
   
  <dt><label for="source_type">Date:</dt>
  <dd>
		<?php $date_from = isset($_REQUEST['date_from'])?$_REQUEST['date_from']:'';
		$date_to = isset($_REQUEST['date_to'])?$_REQUEST['date_to']:'';
		?>
		<input type="text"  name="date_from" class="input-text" id="fromdate" value="<?=$date_from?>"  />&nbsp;To&nbsp;
        <input type="text"  name="date_to" class="input-text" id="todate" value="<?=$date_to?>"  />
  </dd>	
	
</dl>
<div class="buttons">
		<input type="button" value="Search" name="txtSubmit" class="button" onclick="search_form()" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
</div>
</div>
</form>
<ul class="option-tab">
<li><a href="<?=$nullLink?>" class="button toggleSearch" >Show Search</a></li>
<li><?php echo anchor('master/instance/instanceform/'.$source,'Add Instance','class="button"'); ?></li>
<li><a href="<?=site_url('master/source/view_list');?>" class="button">Back</a></li>
</ul>
<br />
<br/>   
 <div id="user-grid" class="grid-view">
	<table width="100%" class="gtable sortable">
	<thead>
		<tr>
			<th width="9%"><a href="<?=$nullLink?>" field="source" class="sortlink">Source</a></th>
            <th width="25%"><a href="<?=$nullLink?>" field="instance_name" class="sortlink">Instance Name</a></th>
            <th width="20%"><a href="<?=$nullLink?>" field="date" class="sortlink">Date</a></th>
            <th width="10%"><a href="<?=$nullLink?>" field="remarks" class="sortlink">Remarks</a></th>
             <th width="10%"><a href="<?=$nullLink?>" field="document" class="sortlink">Documentd</a></th>
			<th width="4%"><a href="<?=$nullLink?>" field="status" class="sortlink">Status</a></th>
			<th width="16%" class="head">Action</th>
			</tr>
		
	</thead>
	<tbody>
   <?php
	if(count($instanceList))
	{    
		$r=1;
		foreach($instanceList as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
			<tr class="<?=$row_type?>">
			<td align="left" valign="middle"><?=$row["source_id"]?></td>
            <td align="left" valign="middle"><?=$row["instance_name"]?></td>
            <td align="left" valign="middle"><?=mysql2date($row["date"])?></td>
            <td align="left" valign="middle"><?=$row["remarks"]?></td>
            <td align="left" valign="middle">
			<?php if(!empty($row["document"])){ ?>
              <a href="<?=base_url()?>uploads/instance/<?=$row["document"]?>" target="_blank" ><img width="16" height="16" src="<?php echo base_url(); ?>source/template/images/icons/download.gif"></a>
             <? }?>
            </td>
			<td align="left" valign="middle"><? 
			if($row["status"]=='1') 
			{ ?>
			    <a href="<?=site_url('master/instance/changestatus/'.$row["source_id"].'/'.$row["id"].'/0') ?>"  title="Make Inactive" >
                   <img src="<?php echo base_url(); ?>source/template/images/icons/active.png"></a>
			<?php } else
			{ ?>
             <a href="<?=site_url('master/instance/changestatus/'.$row["source_id"].'/'.$row["id"].'/1') ?>"  title="Make Active" >
                   <img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png"></a>
            
           <?php }
				
			?></td>
			<td nowrap="nowrap">
			
            
            
            <a href="<?=site_url('master/instance/instanceform/'.$row["source_id"].'/'.$row["id"] );?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>
            <a href="<?=site_url('master/instance/delete/'.$row["source_id"].'/'.$row["id"]);?>" class="confirmDelete"><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete">	</a>
            
		
			</td>
			</tr>
			<?php 
		}
	}
	else
	{ ?>
		<tr>
		<td colspan='7' align='center'>No Records found!</td>
		</tr>
	<?
	} ?>
		
	</tbody>
	</table>
	<!-- Paging style -->
	<?php echo  $this->pagination->create_links($form_name);?>
	</div>   
