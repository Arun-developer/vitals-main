<?php
$nullLink = "javascript:void(0);";

 
?>

<h1><?=$cpagetitle?></h1>


<br />

<ul class="option-tab" style="margin-top:0px;">

      <li><?php echo "<a href=\"javascript:history.go(-1)\" class='button'>GO BACK</a>";?></li>
      <li><?php echo anchor('fellow/job_induction/'.$innovation,'Add Job Induction','class="button"'); ?></li>
      
</ul>  
<br /><br/>
<!--start table-content  -->


 <div id="user-grid" class="gtable sortable">
	<table width="100%" class="items">
	<thead>
	<tr>
    <th><a href="<?=$nullLink?>" field="label">Program Title</a></th>
	<th><a href="<?=$nullLink?>" field="label">Program Description</a></th>
    <th><a href="<?=$nullLink?>" field="required">Mentor</a></th>
    <th><a href="<?=$nullLink?>" field="value">Reporting Officer</a></th>
	<th><a href="<?=$nullLink?>" field="status">Start Date</a></th>
    <th><a href="<?=$nullLink?>" field="status">End Date</a></th>
    <th><a href="<?=$nullLink?>" field="status">Induction Documents</a></th>
	
	</tr>
    </thead>
	<tbody>
	<?php
	if(count($inductionlist))
	{    
		$r=1;
		foreach($inductionlist as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
			<tr class="<?=$row_type?>">
            <td align="left" valign="middle"><?=$row["program_title"];?></td>
			<td align="left" valign="middle"><?=$row["program_description"];?></td>
			<td align="left" valign="middle"><?=$row["mentor"];?></td>
            <td align="left" valign="middle"><?=$row['reporting_officer'];?></td>
            <td align="left" valign="middle"><?=$row['start_date'];?></td>
            <td align="left" valign="middle"><?=$row['end_date'];?></td>
			<td align="left" valign="middle"><a class="fancybox" href="<?=site_url('fellow/upload_induction')?>" >documents</a></td>
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
