<script>
$(document).ready(function()
{
	$('td.edit').click(function()
	{
		$('.ajax').html($('.ajax input').val());
		$('.ajax').removeClass('ajax');
		$(this).addClass('ajax');
		$(this).html('<input class="editbox" size="'+$(this).text().length+'" type="text" value="' + $(this).text() + '">');
		$('.editbox').focus();
	}
	);
	$('td.edit').keydown(function(event)
	{
		var arr = $(this).attr('class').split( " " );
		if(event.which == 13)
		{
			var val=$('.ajax input').val();
			$.ajax({    type: "POST",
				url: "<?php echo site_url('incubationprogress/update')?>",
				data: {'value':val,'rownum':arr['5'],'field':arr['4'],'year':arr['2'],'frequency':arr['1'],'months':arr['3'],'type':arr['6']},
				success: function(data)
				{
					$('.ajax').html($('.ajax input').val());
					$('.ajax').removeClass('ajax');
				}
				});
		}
	}
	);
	$('.editbox').live('blur',function()
	{
		$('.ajax').html($('.ajax input').val());
		$('.ajax').removeClass('ajax');
	}
	);
}
);
</script>
<style>

/* ---- Table ---- */
table {
	border-collapse:collapse;
	margin-bottom:15px;
	width:90%;
	}
	table td,
	table th {
		padding:3px;
		border:1px solid #ccc;
		border-width:0 1px 1px 0;
		font-size:11px;
		color:#FFFFFF;
		}
		
	thead th {
		background:#6aa74f;
			color:#FFFFFF;
		}
			
		thead th[colspan],
		thead th[rowspan] {
			background:#6aa74f;
			color:#FFFFFF;
			}
		
	tbody th,
	tfoot th {
		text-align:left;
		background:#6aa74f;
		}
		
	tbody td,
	tfoot td {
		text-align:center;
		color:#000000;

		}
		
	tfoot th {
		background:#b0cc7f;
		}
		
	tfoot td {
		background:#d7e1c5;
		font-weight:bold;
		}
			
	tbody tr.odd td { 
		background:#bcd9e1;
		}

</style>
<script type="text/javascript" src="js/jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="js/style-table.js"></script>
<script type="text/javascript" src="addclasskillclass.js"></script>


<ul class="tabs">
<?php foreach($mastertype as $row)
{
	?>
	<li class="<?=($defaultms == $row['master_type'])?'selected':'';?>"><a href="<?=site_url('incubationprogress/form/'.$innovation.'/'.($row['master_type']))?>"><?=$row['master_type']?></a></li>	
	<?php 
	}?>
</ul>
<div id="tabid" class="tabset_content">
<ul class="tabs">
<?php foreach($submastertype as $row1)
{
	?>
	<li class="<?=($defaultsubms == $row1['master_name'])?'selected':'';?>"><a href="<?=site_url('incubationprogress/form/'.$innovation.'/'.$defaultms.'/'.$row1['master_name'])?>"><?=$row1['master_name']?></a></li>
	<?php 
	}?>
</ul>
<ul class="tabs">
<?php foreach($type as $row2)
{
	?>
	<li class="<?=($defaulttype == $row2)?'selected':'';?>"><a href="<?=site_url('incubationprogress/form/'.$innovation.'/'.$defaultms.'/'.$defaultsubms.'/'.$row2)?>"><?=$row2 ?></a></li>
	<?php } ?>
</ul>
<?php if($defaulttype == 'metrices')
{
	?>
	<ul class="tabs">
	<?php foreach($subcategory as $row3)
	{
		?>
		<li class="<?=($defaultsubcategory == $row3['subcategory'])?'selected':'';?>"><a href="<?=site_url('incubationprogress/form/'.$innovation.'/'.$defaultms.'/'.$defaultsubms.'/'.$defaulttype.'/'.$row3['subcategory'])?>"><?=$row3['subcategory'];?></a></li>	
		<?php } ?>
	</ul><?php } ?>
<ul class="tabs">
<?php foreach($frequency as $key=>$value)
{
	?>
	<li class="<?=($defaultfrequency == $value)?'selected':'';?>"><a href="<?=site_url('incubationprogress/form/'.$innovation.'/'.$defaultms.'/'.$defaultsubms.'/'.$defaulttype.'/'.(($defaulttype == "metrices")?$defaultsubcategory.'/':'NULL'.'/').$value)?>"><?=$key;?></a></li>
	<?php } ?>
</ul>
<?php if($defaultfrequency != '4')
{
	?>	
	<ul class="tabs">
	<?php foreach($yearly as $row5)
	{
		?>
		<li class="<?=($defaultyearly == $row5)?'selected':'';?>"><a href="<?=site_url('incubationprogress/form/'.$innovation.'/'.$defaultms.'/'.$defaultsubms.'/'.$defaulttype.'/'.(($defaulttype == "metrices")?$defaultsubcategory.'/':'NULL'.'/').$defaultfrequency.'/'.$row5)?>"><?=$row5;?></a></li>
		<?php } ?>
	</ul>
	<?php if($defaultfrequency=='1')
	{
		?>	
		<ul class="tabs">
		<?php foreach($monthly as $row6)
		{
			?>
			<li class="<?=($defaultmonthly == $row6)?'selected':'';?>"><a href="<?=site_url('incubationprogress/form/'.$innovation.'/'.$defaultms.'/'.$defaultsubms.'/'.$defaulttype.'/'.(($defaulttype == "metrices")?$defaultsubcategory.'/':'NULL'.'/').$defaultfrequency.'/'.$defaultyearly.'/'.$row6)?>"><?= date("M", mktime(0, 0, 0, $row6, 1, 2000));?></a></li>
			<?php }  ?>
		</ul>
		<?php } ?>
	<?php } ?>
<?php if($defaultfrequency == '4')
{
	?>
	<table id="travel" width="auto" cellspacing="3" cellpadding="4">
	<tr><th>Label</th>
	<?php foreach($yearly as $years):
	?>	
	<th colspan="2"><?php echo $years;?></th>
	<?php  endforeach; 
	?>
	</tr>
	<?php 
	for($i=0;$i < php72_count($yearreport); $i++)
	{
		echo '<tr>';
		echo '<td>'.$yearreport[$i]['label'].'</td>';
		$yearcount = 0;
		foreach($yearly as $years)
		{
			switch($yearcount)
			{
				case 0:
				if (is_array($yearanswerreport0))
					echo '<td class="edit 4 '.$years.'  '.$yearanswerreport0[$i]['criteria'].' '.$yearanswerreport1[$i]['id'].' '.$defaulttype.'">'.$yearanswerreport0[$i]['answer'].'</td>';
				echo '<td class="browse"><a class="fancybox" href="'.site_url("incubationprogress/fileupload/".$years.'/'.$yearanswerreport0[$i]['criteria'].'/'.$yearanswerreport0[$i]['id'].'/'.$defaulttype).'">'.$yearanswerreport0[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport0[$i]['document'].'</a></td>';	
				break;
				case 1:
				if (is_array($yearanswerreport1))
					echo '<td class="edit 4 '.$years.' 0 '.$yearanswerreport1[$i]['criteria'].' '.$yearanswerreport1[$i]['id'].' '.$defaulttype.'">'.$yearanswerreport1[$i]['answer'].'</td>';
				echo '<td class="browse"><a class="fancybox" href="'.site_url("incubationprogress/fileupload/".$years.'/'.$yearanswerreport1[$i]['criteria'].'/'.$yearanswerreport1[$i]['id'].'/'.$defaulttype).'">'.$yearanswerreport2[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport1[$i]['document'].'</a></td>';
				break;
				case 2:
				if (is_array($yearanswerreport2))
					echo '<td class="edit 4 '.$years.' 0 '.$yearanswerreport1[$i]['criteria'].' '.$yearanswerreport2[$i]['id'].' '.$defaulttype.'">'.$yearanswerreport2[$i]['answer'].'</td>';
				echo '<td class="browse"><a class="fancybox" href="'.site_url("incubationprogress/fileupload/".$years.'/'.$yearanswerreport2[$i]['criteria'].'/'.$yearanswerreport2[$i]['id'].'/'.$defaulttype).'">'.$yearanswerreport2[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport2[$i]['document'].'</a></td>';	
				break;
				case 3:
				if (is_array($yearanswerreport3))
					echo '<td class="edit 4 '.$years.' 0 '.$yearanswerreport1[$i]['criteria'].' '.$yearanswerreport3[$i]['id'].' '.$defaulttype.'">'.$yearanswerreport3[$i]['answer'].'</td>';
				echo '<td class="edit 4 '.$years.' 0 '.$yearanswerreport1[$i]['criteria'].' '.$yearanswerreport3[$i]['id'].' '.$defaulttype.'">'.$yearanswerreport3[$i]['answer'].'</td>';	
				break;
				case 4:
				if (is_array($yearanswerreport4))
					echo '<td class="edit 4 '.$years.' 0 '.$yearanswerreport1[$i]['criteria'].' '.$yearanswerreport4[$i]['id'].' '.$defaulttype.'">'.$yearanswerreport4[$i]['answer'].'</td>';
				echo '<td class="browse"><a class="fancybox" href="'.site_url("incubationprogress/fileupload/".$years.'/'.$yearanswerreport4[$i]['criteria'].'/'.$yearanswerreport4[$i]['id'].'/'.$defaulttype).'">'.$yearanswerreport4[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport4[$i]['document'].'</a></td>';
				break;
				case 5:
				if (is_array($yearanswerreport5))
					echo '<td class="edit 4 '.$years.' 0 '.$yearanswerreport1[$i]['criteria'].' '.$yearanswerreport5[$i]['id'].' '.$defaulttype.'">'.$yearanswerreport5[$i]['answer'].'</td>';
				echo '<td class="browse"><a class="fancybox" href="'.site_url("incubationprogress/fileupload/".$years.'/'.$yearanswerreport5[$i]['criteria'].'/'.$yearanswerreport5[$i]['id'].'/'.$defaulttype).'">'.$yearanswerreport5[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport5[$i]['document'].'</a></td>';
				break;
				case 6:
				if (is_array($yearanswerreport6))
					echo '<td class="edit 4 '.$years.' 0 '.$yearanswerreport1[$i]['criteria'].' '.$yearanswerreport6[$i]['id'].' '.$defaulttype.'">'.$yearanswerreport6[$i]['answer'].'</td>';
				echo '<td class="browse"><a class="fancybox" href="'.site_url("incubationprogress/fileupload/".$years.'/'.$yearanswerreport6[$i]['criteria'].'/'.$yearanswerreport6[$i]['id'].'/'.$defaulttype).'">'.$yearanswerreport6[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport6[$i]['document'].'</a></td>';
				break;
				case 7:
				if (is_array($yearanswerreport7))
					echo '<td class="edit 4 '.$years.' 0 '.$yearanswerreport1[$i]['criteria'].' '.$yearanswerreport7[$i]['id'].' '.$defaulttype.'">'.$yearanswerreport7[$i]['answer'].'</td>';
				echo '<td class="browse"><a class="fancybox" href="'.site_url("incubationprogress/fileupload/".$years.'/'.$yearanswerreport7[$i]['criteria'].'/'.$yearanswerreport7[$i]['id'].'/'.$defaulttype).'">'.$yearanswerreport7[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport7[$i]['document'].'</a></td>';
				break;
				case 8:
				if (is_array($yearanswerreport8))
					echo '<td class="edit 4 '.$years.' 0 '.$yearanswerreport1[$i]['criteria'].' '.$yearanswerreport8[$i]['id'].' '.$defaulttype.'">'.$yearanswerreport8[$i]['answer'].'</td>';
				echo '<td class="browse"><a class="fancybox" href="'.site_url("incubationprogress/fileupload/".$years.'/'.$yearanswerreport8[$i]['criteria'].'/'.$yearanswerreport8[$i]['id'].'/'.$defaulttype).'">'.$yearanswerreport8[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport8[$i]['document'].'</a></td>';
				break;
				case 9:
				if (is_array($yearanswerreport9))
					echo '<td class="edit 4 '.$years.' 0 '.$yearanswerreport1[$i]['criteria'].' '.$yearanswerreport9[$i]['id'].' '.$defaulttype.'">'.$yearanswerreport9[$i]['answer'].'</td>';
				echo '<td class="browse"><a class="fancybox" href="'.site_url("incubationprogress/fileupload/".$years.'/'.$yearanswerreport9[$i]['criteria'].'/'.$yearanswerreport9[$i]['id'].'/'.$defaulttype).'">'.$yearanswerreport9[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport9[$i]['document'].'</a></td>';
				break;
			}
			$yearcount++;
		}
		echo '</tr>';
	}
	?>
	</table>
	<?php } ?>
<?php if($defaultfrequency == '3')
{
	?>
	<table id="travel" width="auto" class="gtable" cellspacing="3" cellpadding="4">
	<tr><th>Label</th>
	<?php foreach($quarterly as $quarters):
	?>	
	<th><?php echo $quarters;?></th>
	<?php  endforeach; 
	?>
	</tr>
	<?php 
	for($i=0;$i<php72_count($quarterlyreport); $i++)
	{
		echo '<tr>';
		echo '<td>'.$quarterlyreport[$i]['label'].'</td>';
		$quartercount = 0;
		foreach($quarterly as $quarters)
		{
			switch($quartercount)
			{
				case 0:
				if (is_array($quarterreport0))
					echo '<td class="edit">'.$quarterreport0[$i]['answer'].'</td>';	
				break;
				case 1:
				if (is_array($quarterreport1))
					echo '<td  class="edit">'.$quarterreport1[$i]['answer'].'</td>';	
				break;
				case 2:
				if (is_array($quarterreport2))
					echo '<td  class="edit">'.$quarterreport2[$i]['answer'].'</td>';	
				break;
				case 3:
				if (is_array($quarterreport3))
					echo '<td  class="edit">'.$quarterreport3[$i]['answer'].'</td>';	
				break;
			}
			$quartercount++;
		}
		echo '</tr>';
	}
	?>
	</table>
	<?php } ?>
<?php if($defaultfrequency == '2')
{
	?>
	<table id="travel" style="width:845px" cellspacing="3" cellpadding="4">
	<tr><th>Label</th>
	<?php foreach($monthly as $months):
	?>	
	<th><?php echo date("M", mktime(0, 0, 0, $months, 1, 2000));?></th>
	<?php  endforeach; 
	?>
	</tr>
	<?php
	for($i=0;$i<php72_count($monthreport); $i++)
	{
		echo '<tr scope="row">';
		if($defaulttype == 'metrices')
		{
			echo '<th>'.$monthreport[$i]['label'].'</th>';	
		}
		else
		{
			echo '<th><a class="fancybox" style="color:white" href="'.site_url("incubationprogress/assign/".$defaultyearly.'/'.$defaultmonthly.'/'.$monthreport[$i]['id'].'/'.$defaulttype.'/'.$innovation).'">'.$monthreport[$i]['label'].'</a></th>';
		}
		$monthcount = 0;
		foreach($monthly as $months)
		{
			switch($monthcount)
			{
				case 0:
				if (is_array($monthanswerreport0))
				{
					echo '<td class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport0[$i]['criteria'].' '.$monthanswerreport0[$i]['id'].' '.$defaulttype.'">'.$monthanswerreport0[$i]['answer'].'</td>';
					break;
				}
				case 1:
				if (is_array($monthanswerreport1))
					echo '<td  class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport1[$i]['criteria'].' '.$monthanswerreport1[$i]['id'].' '.$defaulttype.'">'.$monthanswerreport1[$i]['answer'].'</td>';	
				break;
				case 2:
				if (is_array($monthanswerreport2))
					echo '<td  class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport2[$i]['criteria'].' '.$monthanswerreport2[$i]['id'].' '.$defaulttype.'">'.$monthanswerreport2[$i]['answer'].'</td>';	
				break;
				case 3:
				if (is_array($monthanswerreport3))
					echo '<td  class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport3[$i]['criteria'].' '.$monthanswerreport3[$i]['id'].' '.$defaulttype.'">'.$monthanswerreport3[$i]['answer'].'</td>';	
				break;
				case 4:
				if (is_array($monthanswerreport4))
					echo '<td  class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport4[$i]['criteria'].' '.$monthanswerreport4[$i]['id'].' '.$defaulttype.'">'.$monthanswerreport4[$i]['answer'].'</td>';	
				break;
				case 5:
				if (is_array($monthanswerreport5))
					echo '<td  class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport5[$i]['criteria'].' '.$monthanswerreport5[$i]['id'].' '.$defaulttype.'">'.$monthanswerreport5[$i]['answer'].'</td>';	
				break;
				case 6:
				if (is_array($monthanswerreport6))
					echo '<td  class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport6[$i]['criteria'].' '.$monthanswerreport6[$i]['id'].' '.$defaulttype.'">'.$monthanswerreport6[$i]['answer'].'</td>';	
				break;
				case 7:
				if (is_array($monthanswerreport7))
					echo '<td  class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport7[$i]['criteria'].' '.$monthanswerreport7[$i]['id'].' '.$defaulttype.'">'.$monthanswerreport7[$i]['answer'].'</td>';	
				break;
				case 8:
				if (is_array($monthanswerreport8))
					echo '<td  class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport8[$i]['criteria'].' '.$monthanswerreport8[$i]['id'].' '.$defaulttype.'">'.$monthanswerreport8[$i]['answer'].'</td>';	
				break;
				case 9:
				if (is_array($monthanswerreport9))
					echo '<td  class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport9[$i]['criteria'].' '.$monthanswerreport9[$i]['id'].' '.$defaulttype.'">'.$monthanswerreport9[$i]['answer'].'</td>';	
				break;
				case 10:
				if (is_array($monthanswerreport10))
					echo '<td  class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport10[$i]['criteria'].' '.$monthanswerreport10[$i]['id'].' '.$defaulttype.'">'.$monthanswerreport10[$i]['answer'].'</td>';	
				break;
				case 11:
				if (is_array($monthanswerreport11))
					echo '<td  class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport11[$i]['criteria'].' '.$monthanswerreport11[$i]['id'].' '.$defaulttype.'">'.$monthanswerreport11[$i]['answer'].'</td>';	
				break;
			}
			$monthcount++;
		}
		echo '</tr>';
	}
	?>
	</table>
	<?php } ?>
<?php if($defaultfrequency == '1')
{
	?>
	<table id="table1" width="auto" class="gtable" cellspacing="3" cellpadding="4">
	<tr><th>Label</th>
	<?php foreach($weekly as $weeks):
	?>	
	<th><?php echo $weeks;?></th>
	<?php  endforeach; 
	?>
	</tr>
	<?php 
	for($i=0;$i<php72_count($weekreport); $i++)
	{
		echo '<tr>';
		echo '<td>'.$weekreport[$i]['label'].'</td>';
		$weekcount = 0;
		foreach($weekly as $weeks)
		{
			switch($weekcount)
			{
				case 0:
				if (is_array($weekanswerreport0))
					echo '<td class="edit">'.$weekanswerreport0[$i]['answer'].'</td>';	
				echo '<td>Hello</td>';
				break;
				case 1:
				if (is_array($weekanswerreport1))
					echo '<td  class="edit">'.$weekanswerreport1[$i]['answer'].'</td>';	
				break;
				case 2:
				if (is_array($weekanswerreport2))
					echo '<td  class="edit">'.$weekanswerreport2[$i]['answer'].'</td>';	
				break;
				case 3:
				if (is_array($weekanswerreport3))
					echo '<td  class="edit">'.$weekanswerreport3[$i]['answer'].'</td>';	
				break;
				case 4:
				if (is_array($weekanswerreport4))
					echo '<td  class="edit">'.$weekanswerreport4[$i]['answer'].'</td>';	
				break;
				case 5:
				if (is_array($weekanswerreport5))
					echo '<td  class="edit">'.$weekanswerreport5[$i]['answer'].'</td>';	
				break;
			}
			$weekcount++;
		}
		echo '</tr>';
	}
	?>
	</table>
<?php } ?>
</div>