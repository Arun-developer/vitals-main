<?php 
$nullLink = 'javascript:void(0);';

//load scripts
echo '<h1>'.$cpagetitle.'</h1>';
?>


<div style=" float:right; text-align:right;width:100%;">
	<?php echo anchor('master/master_settings/currency_add','Add Currency','class="button"'); ?>
</div>
<br />
<br />

	<table class="gtable sortable">
	<thead>
		<tr>
			<th width="15%"><a href="<?=$nullLink?>" field="donorfit_name" class="sortlink">Currency Name</a></th>
            <th width="15%"><a href="<?=$nullLink?>" field="donorfit_name" class="sortlink">Currency Code</a></th>
			<th width="15%"><a href="<?=$nullLink?>" field="donorfit_name" class="sortlink">Symbol</a></th>
			<th width="15%"><a href="<?=$nullLink?>" field="donorfit_name" class="sortlink">Prefix By</a></th>
			<th width="15%"><a href="<?=$nullLink?>" field="status" class="sortlink">Status</a></th>
			<th width="15%" class="head">Action</th>
			</tr>		
	</thead>
	<tbody>
   <?php
	if(php72_count($type_list)) {   
		$r=1;
		foreach($type_list as $doc) {
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
	?>
			<tr class="<?=$row_type?>">
				<td align="middle" valign="middle"><?=$doc["name"]?></td>
                <td align="middle" style="text-transform:uppercase" valign="middle"><?=$doc["currency_code"]?></td>
				<td align="middle" valign="middle"><?=$doc["currency_symbol"]?></td>
				<td align="middle" valign="middle"><?=$doc["prefix"]?></td>
				<td align="middle" valign="middle">
					<?php if($doc["status"]=='1') { ?>
					<a href="<?=site_url('master/master_settings/currency_changeStatus/'.$doc['id'].'/2'); ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/active.png"></a>
					<?php } else { ?>
					<a href="<?=site_url('master/master_settings/currency_changeStatus/'.$doc['id'].'/1'); ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png"></a>
					<?php } ?>
			    </td>
				<td align="middle" nowrap="nowrap">
					<a href="<?=site_url('master/master_settings/currency_edit/'.$doc['id']); ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png"></a>			
					<a class="confirmDelete" url="<?=site_url('master/master_settings/currency_changeStatus/'.$doc['id'].'/3')?>"  ><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
				</td>
			</tr>
	<?php 
		}
	} else { ?>
		<tr>
			<td colspan='7' align='center'>No Records found!</td>
		</tr>
	<?php } ?>
		
	</tbody>
	</table>


<script type="text/javascript">
$(document).ready( function() {
	$(".confirmDelete").click( function() {
	var linkUrl = $(this).attr('url');
	jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
		if(r) {
		  $(window.location).attr('href',linkUrl);
		}
	});
  });
});
</script> 


<style type="text/css">
	.confirmDelete{cursor: pointer;}
	 nav#topmenu { min-width: 947px !important;}
</style>