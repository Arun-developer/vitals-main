<ul class="option-tab">
<li><a href="<?=site_url('activities/index/'.$innovation['id'])?>" class="button"  >Back</a></li>
</ul>
<h1><?=$cpagetitle?> - <?=$innovation['name_of_enterprise']?></h1>
<form id="activity_list" action="<?=site_url('activities/view_list/'.$innovation['id'])?>" method="post" name="activity_list">
<input type="hidden" name="innovation" value="<?=$innovation['id']?>"  />
<dl class="inline">
        <dt>
        <label for="date">From Date</label>
        <dd><input type="text" name="time" class="input-text required" id="fromdate" size="40" /></dd>
		</dt>
		
		<dt>
		<label for="date">To Date</label>
        <dd><input type="text" name="totime" class="input-text required" id="todate" size="40" /></dd>
        </dt>
        
        <dt><label for="">Employee Name</label></dt>
        <dd>
        <select name="status" id="">
        <option value="">-Select-</option>
        
        <?php 
        
       foreach($employee as $row):?>
        <option value="<?=$row['emp_number'];?>"><?=$row['emp_firstname'];?></option>
        <?php endforeach;?>
        </select>
        </dd>
        <dd style="padding-left:180px;">
	<input type="submit" name="txtSubmit" value="Search" class="button" /> 
        </dd>
</dl>
</form>  
<?php if($addOption){ ?>
<ul class="option-tab addActivity">
<li>
<a href="<?=site_url('activities/add_activity/'.$innovation['id']);?>" class="button" >Add Activity</a>
</li>
</ul>
<?php } ?>
<br />
<br />

	<table class="gtable sortable">
	<thead>
		<tr>
			<th><a href="#">Activity Description</a></th>
            <th><a href="#">Date</a></th>
            <th><a href="#">Option</a></th>
		</tr>
	</thead>
	<tbody>
    <?php 
    $this->load->model('mactivities');
	if(php72_count($activitiesList)){
			$i='odd';
			foreach($activitiesList as $row): 
			$i = ($i=='odd')?'even':'odd';
			?>
				<tr class="<?=$i?>">
					<td><?=$row['activity_title']?></td>
					<td><?=mysql2date($row['end_date'])?></td>
					<td>
					<a href="<?=site_url('activities/activity_details/'.$row['innovation'].'/'.$row['id']);?>" class="button">Details</a>
					<?php if($deleteOption){ ?> 
				   <a href="<?=site_url('activities/delete/'.$row['innovation'].'/'.$row['id'].'/'.$row['activity']);?>" id="<?=$row['id']?>" activity="<?=$row['activity']?>" class="button red">Delete</a>
				   <?php } ?>
				   </td>
					</tr>
			<?php 
			endforeach;
		}
		else
		{
			?><tr><td colspan="10" align="center">No Records found!</td></tr>
            <?php
		}
	?>
	</tbody>
	</table>
       


 
 <script type="application/javascript">
	$(document).ready(function(){
		$('.removeActivityList').live('click',function(){
			var actId = $(this).attr('id');
			var activity = $(this).attr('activity');
			var delRow = $(this).parents('tr');										
			jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
				if(r)
				{
					var form_data = {
						actId: actId,
						activity: activity,
						ajax: '4'		
					};
					$.ajax({
						url: '<?=site_url('activities/delete');?>',
						type: 'POST',
						data: form_data,
						success: function(msg) {
							if(msg == 'success')
							{
								delRow.hide();
								$('.msg').html('Activity Deleted Successfully').addClass('done').show();
							}
							else
							{
								$('.msg').html(msg).addClass('error').show();
							}
							$('.msg').fadeOut(50000);
						}
					});
				}
				
			});
		});
	});
	</script>
   
