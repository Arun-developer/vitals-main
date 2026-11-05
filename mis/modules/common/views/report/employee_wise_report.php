<h1><?=$cpagetitle?></h1>
<?php 
$nullLink = "javascript:void(0);";
?>

<div style=" float:right; text-align:right;width:100%;">
</div>
<br />

	<table class="gtable sortable">
	<thead>
		<tr>
        	<th><a href="<?=$nullLink?>" field="" class="">Referrers</a></th>
			<th><a href="<?=$nullLink?>" field="" class="">Source Type</a></th>
			<th><a href="<?=$nullLink?>" field="" class="">Source</a></th>
            <th><a href="<?=$nullLink?>" field="" class="">New</a></th>
            <th><a href="<?=$nullLink?>" field="" class="">Entry</a></th>
            <th><a href="<?=$nullLink?>" field="" class="">Convertion %</a></th>
             <th><a href="<?=$nullLink?>" field="" class="">Lead </a></th>
            <th><a href="<?=$nullLink?>" field="" class="">Convertion %</a></th>
			</tr>
		
	</thead>
	<tbody>
    <?php
	if(php72_count($employeeWiseReport)){
		$i='odd';
		foreach($employeeWiseReport as $row): 
		$i = ($i=='odd')?'even':'odd';
		?>
			<tr class="<?=$i?>">
            	<td rowspan="<?=php72_count($row['report'])+1?>"><?=$row['created_emp']?></td>
				</tr>
                <?php foreach($row['report'] as $value): ?>
                <tr class="<?=$i?>">
                <td><?=$value['source_type']?></td>
				<td><?=$value['source_name']?></td>
				<td><?=$value['total_new']?></td>
                <td><?=$value['total_entry']?></td>
                <td><?=$value['convertion_new_entry']?>%</td>
                <td><?=$value['total_lead']?></td>
                 <td><?=$value['convertion_entry_lead']?>%</td>
                </tr>
                 <?php endforeach; ?>
		<?php 
		endforeach;
	}
	else
	{
	?>
    <tr class="odd"><td colspan="10" align="center">No Records</td></tr>
	<?php } ?>
		
	</tbody>
	</table>
	<!-- Paging style -->
