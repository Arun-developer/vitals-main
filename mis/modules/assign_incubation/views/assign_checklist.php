<h1><?=$cpagetitle?></h1>

<div align="right"><A class="button" HREF="<?php echo site_url('incubationprogress/form/'.$innovation)?>">
Back</A>
</div>
<ul class="tabs">
<li class="selected"><a href="<?=site_url('assign_incubation/assign_checklist/'.$innovation)?>">IRIS Metrics</a></li>
<li><a href="<?=site_url('assign_incubation/form2/'.$innovation)?>">Activity</a></li>
</ul>
<form name="step1" action="<?=site_url('assign_incubation/assign_checklist/'.$innovation);?>" enctype="multipart/form-data" method="post" id="step1" class="uniform"  >
<input type="hidden" name="innovation" value="<?=$innovation?>" />
<div style="height:400px; overflow:auto">
<table>

<tr>
<td align="left"><label for="incubation committee"><b>Incubation Metrices:</b></label></td></tr>
<tr>
<td align="left">
 
    <?php
	$key = 0;
	$na = '';
	foreach($checkList as $row): 
	
	$na_new = $row['mastertype'];
	if($na_new != $na)
	{
		$na = $na_new;
		$key = 0;
	?>
   <tr><td colspan="3"><h2><?=$row['mastertype']; ?></h2></td></tr>
   	<?php }?> 
	<tr>
			<td><?php ++$key;?></td>
			<td style="width:500px;"><?php echo $row['label'];?></td>
			<td><input type="checkbox" name="checklist[]" class="case" value="<?=$row['id']?>" <?=(in_array($row['id'],$innovationChecklist))?'checked':'';?> ></td>
			</tr>
    <?php 
	endforeach;
	?>
	</td>
	</tr>
	</table>
	<!-- Paging style -->
    </div>
    <div class="buttons"><input type="submit" name="txtSubmit" value="Assign" class="button" ></div>
    </form>