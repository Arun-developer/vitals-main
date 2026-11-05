<h1><?=$cpagetitle?></h1>
<div align="right"><A class="button" HREF="<?php echo site_url('incubationprogress/form/'.$innovation)?>">
Back</A></div>
<ul class="tabs">
<li class="selected"><a href="<?=site_url('assign_incubation/assign_checklist/'.$innovation)?>">IRIS Metrics</a></li>
<li ><a href="<?=site_url('assign_incubation/form2/'.$innovation)?>">Activity</a></li>
</ul>
<div style="height:400px; overflow:auto">
	<table class="gtable detailtable" >
	<thead>
		<tr>
			<th>S.No.</th>
			<th>Label</th>
            <th>Applicability</th>
		</tr>
		
	</thead>
	<tbody >
    <?php
	$key = 0;
	$na = '';
	foreach($checkList as $row): 
	
	$na_new = $row['master_name'];
	if($na_new != $na)
	{
		$na = $na_new;
		$key = 0;
	?>
    <tr><td colspan="3"><h2><?=$row['master_name']; ?></h2></td></tr>
    <?php }?> 
		<tr>
			<td><?=++$key;?></td>
			<td style="width:500px;"><?php echo $row['label']; ?></td>
			<td><?=(php72_in_array($row['id'],$innovationChecklist))?'<font color="green">Applicable</font>':'<font color="red">Not Applicable</font>';?></td>
		</tr>
    <?php 
	endforeach;
	?>
	<tr class="odd">
			<td>&nbsp;</td>
            <td>&nbsp;</td>
			<td></td>
			</tr>	
		
	</tbody>
	</table>
	<!-- Paging style -->
    </div>
