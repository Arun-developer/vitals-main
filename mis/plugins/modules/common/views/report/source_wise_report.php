<h1><?=$cpagetitle?></h1>
<?php 
$nullLink = "javascript:void(0);";
?>
<div style=" float:right; text-align:right;width:100%;">
<?php //$this->Mexport->exportOption('innovation',$form_name); ?>
</div>
<br />
	<table class="gtable sortable">
	<thead>
		<tr>
			<th><a href="<?=$nullLink?>" field="" class="">Source Type</a></th>
			<th><a href="<?=$nullLink?>" field="" class="">Source</a></th>
            <th><a href="<?=$nullLink?>" field="" class="">New</a></th>
			<th><a href="<?=$nullLink?>" field="" class="">%</a></th>
            <th><a href="<?=$nullLink?>" field="" class="">Entry</a></th>
            <th><a href="<?=$nullLink?>" field="" class="">Convertion %</a></th>
             <th><a href="<?=$nullLink?>" field="" class="">Lead </a></th>
            <th><a href="<?=$nullLink?>" field="" class="">Convertion %</a></th>
		</tr>
	</thead>
	<tbody>
    <?php
	if(count($sourceWiseReport)){
		$i='odd';
		foreach($sourceWiseReport as $row): 
		$i = ($i=='odd')?'even':'odd';
		?>
			<tr class="<?=$i?>">
            	<td><?=$row['source_type']?></td>
				<td><?=$row['source_name']?></td>
				<td><?=$row['total_new']?></td>
                <td><?=$row['innovation_percent']?>%</td>
                <td><?=$row['total_entry']?></td>
                <td><?=$row['convertion_new_entry']?>%</td>
                <td><?=$row['total_lead']?></td>
                 <td><?=$row['convertion_entry_lead']?>%</td>
				</tr>
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