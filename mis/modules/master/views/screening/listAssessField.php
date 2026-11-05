<?php
$nullLink = "javascript:void(0);";
?>
<h1><?=$cpagetitle?></h1>

<div style=" float:right; text-align:right;width:100%;">
<?php echo anchor('master/screening_master/assessform/'.$pid,'Add Field','class="button fancybox"'); ?>&nbsp;&nbsp;
<?php echo anchor('master/screening_master/view_list','Back','class="button"'); ?></div>
<br />
<br/>
<!--start table-content  -->
 <div id="user-grid" class="gtable sortable">
	<table width="100%" class="items">
	<thead>
	<tr>
	<th><a href="<?=$nullLink?>" field="label">Label</a></th>
    <th><a href="<?=$nullLink?>" field="input_type">Input Type</a></th>
    <th><a href="<?=$nullLink?>" field="required">Required</a></th>
    <th><a href="<?=$nullLink?>" field="value">values</a></th>
    <th><a href="<?=$nullLink?>" field="order">Order</a></th>
	<th><a href="<?=$nullLink?>" field="status">Status</a></th>
	<th class="head">Action</th>
	</tr>
    </thead>
	<tbody>
	<?php
	if(count($assessmentList))
	{    
		$r=1;
		foreach($assessmentList as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
			<tr class="<?=$row_type?>">
			<td align="left" valign="middle"><?=$row["label"];?></td>
            <td align="left" valign="middle"><?=$row["input_type"];?></td>
            <td align="left" valign="middle"><?=ucfirst($row["required"]);?></td>
             <td align="left" valign="middle"  width="400"><?=implode(',',$row["value"]);?></td>
              <td align="left" valign="middle">
			  <a href="<?=$nullLink?>" class="button makeOrderUp" criteria="<?=$row['pid']?>" id="<?=$row["id"]?>"  >Up</a>&nbsp;
              <a href="<?=$nullLink?>" class="button makeOrderDown" criteria="<?=$row['pid']?>" id="<?=$row["id"]?>"  >Down</a>
			  </td>
			<td align="left" valign="middle" width="60">
			<?php if($row["status"]=='1')
			{
				 echo anchor('master/screening_master/changestatus/'.$row["id"].'/0/'.$pid,"Active",'class="button"'); 		
			}else{ 
				echo anchor('master/screening_master/changestatus/'.$row["id"].'/1/'.$pid,"Inactive",'class="button"');
			}
			?></td>
			<td nowrap="nowrap" width="70">
			<?php echo anchor('master/screening_master/assessform/'.$pid.'/'.$row["id"],"Edit",'class="button fancybox"');?>
			<a href="<?=$nullLink?>" url="<?=site_url('master/screening_master/delete/'.$row["id"].'/'.$pid)?>" class="button confirmDelete" >Delete</a>
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
	</tbody>
	</table>
	<!-- Paging style -->
	</div>   
<script type="text/javascript">
$(document).ready(function(){

	
	$('.makeOrderDown').live('click', function () {
		var criteria = $(this).attr('criteria');
		var id = $(this).attr('id');
		var rowToMove = $(this).parents('tr');
		var next = rowToMove.next('tr');
		var next_criteria = next.find('.makeOrderDown').attr('criteria');
		if(next_criteria == criteria)
		{
			if(rowToMove.hasClass('odd'))
			{
				rowToMove.removeClass('odd').addClass('even');
				next.removeClass('even').addClass('odd');
			}
			else
			{
				rowToMove.removeClass('even').addClass('odd');
				next.removeClass('odd').addClass('even');
			}
			if (next.length == 1) { next.after(rowToMove); }
			makeOrder(criteria,id,'Down');
		}
	});


	$('.makeOrderUp').live('click', function () {
		var criteria = $(this).attr('criteria');
		var id = $(this).attr('id');
		var rowToMove = $(this).parents('tr');
		var prev = rowToMove.prev('tr');
		var prev_criteria = prev.find('.makeOrderDown').attr('criteria');
		if(prev_criteria == criteria)
		{
			if(rowToMove.hasClass('odd'))
			{
				rowToMove.removeClass('odd').addClass('even');
				prev.removeClass('even').addClass('odd');
			}
			else
			{
				rowToMove.removeClass('even').addClass('odd');
				prev.removeClass('odd').addClass('even');
			}
			if (prev.length == 1) { prev.before(rowToMove); }
			makeOrder(criteria,id,'Up');
		}
	});
	
	function makeOrder(criteria,id,order)
	{
		var form_data = {
				criteria: criteria,
				id: id,
				order: order,
				ajax: '4'		
			};
		$.ajax({
				url: '<?=site_url('master/screening_master/make_order');?>/'+criteria+'/'+id+'/'+order+'/sub',
				type: 'POST',
				data: form_data,
				success: function(msg) {
					$('#activityTable').html(msg);
				}
		});
	}

});
</script>
