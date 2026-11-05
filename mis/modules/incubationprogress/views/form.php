<script type="text/javascript">
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
				data: {'value':val,'rownum':arr['5'],'field':arr['4'],'year':arr['2'],'frequency':arr['1'],'months':arr['3'],'type':arr['6'],'innovation':arr['7']},
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
function monthchange(val)
{
	document.monthchangeform.submit();
}
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
	   if($this->session->userdata('user_type')!='cio'){?>
		<li class="<?=($defaultsubcategory == $row3['subcategory'])?'selected':'';?>"><a href="<?=site_url('incubationprogress/form/'.$innovation.'/'.$defaultms.'/'.$defaultsubms.'/'.$defaulttype.'/'.$row3['subcategory'])?>"><?=$row3['subcategory'];?></a></li>	
		<?php } else if($defaultms == 'Financial Performance'){
		if($row3['subcategory']!='Ratios Concepts and Calculations'){?>
		<li class="<?=($defaultsubcategory == $row3['subcategory'])?'selected':'';?>"><a href="<?=site_url('incubationprogress/form/'.$innovation.'/'.$defaultms.'/'.$defaultsubms.'/'.$defaulttype.'/'.$row3['subcategory'])?>"><?=$row3['subcategory'];?></a></li>
		<?php } else { ?>		<li><a href="<?php echo site_url('incubationprogress/formula/'.$innovation)?>">Ratios Concepts and Calculations</a></li><?php } } } ?>
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
	 if($defaulttype == 'activity'){?>	
	<th colspan="2"><?php echo $years;?></th>
	<?php } else { ?>
	<th><?php echo $years;?></th>
	 <?php } endforeach; 
	?>
	</tr>
	<?php 
	for($i=0;$i < php72_count($yearreport); $i++)
	{
		echo '<tr>';
		echo '<td title="'.$yearreport[$i]['info'].'">'.$yearreport[$i]['label'].'</td>';
		$yearcount = 0;
		foreach($yearly as $years)
		{
			switch($yearcount)
			{
				case 0:
				if (is_array($yearanswerreport0))
				{
				if($defaulttype !='activity')
				{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport0[$i]['criteria'].' '.$yearanswerreport0[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport0[$i]['answer'].'</td>';	
				}
				else
				{
					 echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport0[$i]['criteria'].' '.$yearanswerreport0[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport0[$i]['answer'].'</td>';	
					 if($yearanswerreport0[$i]['document'] == ''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$years.'/'.$defaulttype.'/'.'NULL'.'/'.$yearanswerreport0[$i]['criteria'].'/'.$yearanswerreport0[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a></td>
					<?php }
					else{
						echo '<td width="20px">';
						echo substr($yearanswerreport0[$i]['document'],14,-3); ?>
						<a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$years.'/'.$defaulttype.'/'.'NULL'.'/'.$yearanswerreport0[$i]['criteria'].'/'.$yearanswerreport0[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a>
						<?php
						echo '</td>';
					}	
				}
			}				
				break;
				case 1:
				if (is_array($yearanswerreport1)){
					
				
				if($defaulttype!='activity')
				{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport1[$i]['criteria'].' '.$yearanswerreport1[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport1[$i]['answer'].'</td>';
				}
				else{
				echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport1[$i]['criteria'].' '.$yearanswerreport1[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport1[$i]['answer'].'</td>';
				if($yearanswerreport1[$i]['document'] == ''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$years.'/'.$defaulttype.'/'.$yearanswerreport1[$i]['criteria'].'/'.$yearanswerreport1[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a></td>
					<?php }
					else{
						
						echo '<td width="20px">';
						echo substr($yearanswerreport1[$i]['document'],14,-3); ?>
						<a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$years.'/'.$defaulttype.'/'.'NULL'.'/'.$yearanswerreport1[$i]['criteria'].'/'.$yearanswerreport1[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a>
						<?php
						echo '</td>';
					}	
				}
				} 
				break;
				case 2:
				if (is_array($yearanswerreport2)){
					
				
				if($defaulttype!='activity')
				{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport2[$i]['criteria'].' '.$yearanswerreport2[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport2[$i]['answer'].'</td>';
				}
				else
				{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport2[$i]['criteria'].' '.$yearanswerreport2[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport2[$i]['answer'].'</td>';
				 if($yearanswerreport2[$i]['document'] == ''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$years.'/'.$defaulttype.'/'.$yearanswerreport2[$i]['criteria'].'/'.$yearanswerreport2[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a></td>
					<?php }
					else{
						echo '<td width="20px">';
						echo substr($yearanswerreport2[$i]['document'],14,-3); ?>
						<a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$years.'/'.$defaulttype.'/'.'NULL'.'/'.$yearanswerreport2[$i]['criteria'].'/'.$yearanswerreport2[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a>
						<?php
						echo '</td>';
					}
				}
				}	
				break;
				case 3:
				if (is_array($yearanswerreport3)){
					
				
				if($defaulttype!='activity')
				{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport3[$i]['criteria'].' '.$yearanswerreport3[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport3[$i]['answer'].'</td>';
				}
				else{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport3[$i]['criteria'].' '.$yearanswerreport3[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport3[$i]['answer'].'</td>';
				 if($yearanswerreport3[$i]['document'] == ''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$years.'/'.$defaulttype.'/'.$yearanswerreport3[$i]['criteria'].'/'.$yearanswerreport3[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a></td>
					<?php }
					else{ 
					echo '<td width="20px">';
						echo substr($yearanswerreport3[$i]['document'],14,-3); ?>
						<a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$years.'/'.$defaulttype.'/'.'NULL'.'/'.$yearanswerreport3[$i]['criteria'].'/'.$yearanswerreport3[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a>
						<?php
						echo '</td>';
					}
				}
				}	
				break;
				case 4:
				if (is_array($yearanswerreport4)){
					
				
				if($defaulttype!='activity')
				{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport4[$i]['criteria'].' '.$yearanswerreport4[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport4[$i]['answer'].'</td>';
				}
				else{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport4[$i]['criteria'].' '.$yearanswerreport4[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport4[$i]['answer'].'</td>';
				 if($yearanswerreport4[$i]['document'] == ''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$years.'/'.$defaulttype.'/'.$yearanswerreport4[$i]['criteria'].'/'.$yearanswerreport4[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a></td>
					<?php }
					else{
						echo '<td width="20px">'.substr($yearanswerreport4[$i]['document'],14,-3).'</td>';
					}
				}
				}	
				break;
				case 5:
				if (is_array($yearanswerreport5)){
					
				
				if($defaulttype!='activity')
				{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport5[$i]['criteria'].' '.$yearanswerreport5[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport5[$i]['answer'].'</td>';
				}
				else
				{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport5[$i]['criteria'].' '.$yearanswerreport5[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport5[$i]['answer'].'</td>';
 					if($yearanswerreport5[$i]['document'] == ''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$years.'/'.$defaulttype.'/'.$yearanswerreport5[$i]['criteria'].'/'.$yearanswerreport5[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a></td>
					<?php }
					else{
						echo '<td width="20px">'.substr($yearanswerreport5[$i]['document'],14,-3).'</td>';
					}
				}
				}
				break;
				case 6:
				if (is_array($yearanswerreport6)){
					
				
				if($defaulttype!='activity')
				{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport6[$i]['criteria'].' '.$yearanswerreport6[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport6[$i]['answer'].'</td>';
				}
				else
				{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport6[$i]['criteria'].' '.$yearanswerreport6[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport6[$i]['answer'].'</td>';
				 if($yearanswerreport0[$i]['document'] == ''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$years.'/'.$defaulttype.'/'.$yearanswerreport6[$i]['criteria'].'/'.$yearanswerreport6[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a></td>
					<?php }
					else{
						echo '<td width="20px">'.substr($yearanswerreport6[$i]['document'],14,-3).'</td>';
					}
				}
				}	
				break;
				case 7:
				if (is_array($yearanswerreport7)){
					
				
				if($defaulttype!='activity')
				{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport7[$i]['criteria'].' '.$yearanswerreport7[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport7[$i]['answer'].'</td>';
				}
				else
				{
					echo '<td class="edit 4 '.$years.' '.'NULL'.' '.$yearanswerreport7[$i]['criteria'].' '.$yearanswerreport7[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$yearanswerreport7[$i]['answer'].'</td>';
				 if($yearanswerreport7[$i]['document'] == ''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$years.'/'.$defaulttype.'/'.NULL.'/'.$yearanswerreport0[$i]['criteria'].'/'.$yearanswerreport0[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a></td>
					<?php }
					else{
						echo '<td width="20px">'.substr($yearanswerreport7[$i]['document'],14,-3).'</td>';
					}
				}
				}	
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
	 if($defaulttype == 'activity'){?>	
	<th colspan="2"><?php echo $quarters;?></th>
	<?php } else { ?><th><?php echo $quarters;?></th> <?php }  endforeach; 
	?>
	</tr>
	<?php 
	
	for($i=0;$i<php72_count($quarterlyreport); $i++)
	{
	
		echo '<tr>';
		echo '<td title="'.$quarterlyreport[$i]['info'].'">'.$quarterlyreport[$i]['label'].'</td>';
		$quartercount = 0;
		foreach($quarterly as $quarters)
		{
			switch($quartercount)
			{
				case 0:
				if (is_array(@$quarterreport0))
				if($defaulttype!='activity')
				{
					echo '<td width="20px" class="edit 3 '.$defaultyearly.' '.$quarters.' '.$quarterreport0[$i]['criteria'].' '.$quarterreport0[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$quarterreport0[$i]['answer'].'</td>';
				}
				else
				{
					echo '<td width="20px" class="edit 3 '.$defaultyearly.' '.$quarters.' '.$quarterreport0[$i]['criteria'].' '.$quarterreport0[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$quarterreport0[$i]['answer'].'</td>';
					 if($quarterreport0[$i]['document'] == ''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$quarters.'/'.$quarterreport0[$i]['criteria'].'/'.$quarterreport0[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a></td>
					<?php }
					else{
				
						echo '<td width="20px">';
					echo substr($quarterreport0[$i]['document'],14,-3); ?>
					<a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$quarters.'/'.$quarterreport0[$i]['criteria'].'/'.$quarterreport0[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a>
						<?php
					echo '</td>';
					}
				}
					
	
				break;
				case 1:
				if (is_array(@$quarterreport1))
				if($defaulttype!='activity')
				{
					echo '<td width="20px" class="edit 3 '.$defaultyearly.' '.$quarters.' '.$quarterreport1[$i]['criteria'].' '.$quarterreport1[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$quarterreport1[$i]['answer'].'</td>';	
				}
				else
				{
					echo '<td width="20px" class="edit 3 '.$defaultyearly.' '.$quarters.' '.$quarterreport1[$i]['criteria'].' '.$quarterreport1[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$quarterreport1[$i]['answer'].'</td>';	
					if($quarterreport1[$i]['document'] == ''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$quarters.'/'.$quarterreport1[$i]['criteria'].'/'.$quarterreport1[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a></td>
					<?php }
					else{
							echo '<td width="20px">';
					echo substr($quarterreport1[$i]['document'],14,-3); ?>
					<a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$quarters.'/'.$quarterreport1[$i]['criteria'].'/'.$quarterreport1[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a>
						<?php
					echo '</td>';
					
					}
	
				}
					
				break;
				case 2:
				if (is_array(@$quarterreport2))
				if($defaulttype!='activity')
				{
					echo '<td width="20px" class="edit 3 '.$defaultyearly.' '.$quarters.' '.$quarterreport2[$i]['criteria'].' '.$quarterreport2[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$quarterreport2[$i]['answer'].'</td>';
				}
				else
				{
					echo '<td width="20px" class="edit 3 '.$defaultyearly.' '.$quarters.' '.$quarterreport2[$i]['criteria'].' '.$quarterreport2[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$quarterreport2[$i]['answer'].'</td>';
					if($quarterreport2[$i]['document'] == ''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$quarters.'/'.$quarterreport2[$i]['criteria'].'/'.$quarterreport2[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a></td>
					<?php }
					else{
						echo '<td width="20px">';
					echo substr($quarterreport2[$i]['document'],14,-3); ?>
					<a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$quarters.'/'.$quarterreport2[$i]['criteria'].'/'.$quarterreport2[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a>
						<?php
					echo '</td>';
					}
				}
					
	
				break;
				case 3:
				if (is_array(@$quarterreport3))
				if($defaulttype!='activity')
				{
					echo '<td width="20px" class="edit 3 '.$defaultyearly.' '.$quarters.' '.$quarterreport3[$i]['criteria'].' '.$quarterreport3[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$quarterreport3[$i]['answer'].'</td>';
				}
				else
				{
					echo '<td width="20px" class="edit 3 '.$defaultyearly.' '.$quarters.' '.$quarterreport3[$i]['criteria'].' '.$quarterreport3[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$quarterreport3[$i]['answer'].'</td>';
					if($quarterreport3[$i]['document'] == ''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$quarters.'/'.$quarterreport3[$i]['criteria'].'/'.$quarterreport3[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a></td>
					<?php }
					else{
							echo '<td width="20px">';
					echo substr($quarterreport3[$i]['document'],14,-3); ?>
					<a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$quarters.'/'.$quarterreport3[$i]['criteria'].'/'.$quarterreport3[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" title="File upload"></a>
						<?php
					echo '</td>';
					}
				}
					
	
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
	if($defaulttype=='metrices')
	{
	 
	if(isset($_POST['monthdropdown']))
	{
		$monthcount = $_POST['monthdropdown'];
		$months=$_POST['monthdropdown'];
	}
	else
	{
		$monthcount = $defaultmonthly - 1;
		$months = date("M");  	
	}
	?>
	<br>
	<form name="monthchangeform" action="<?php site_url('incubationprogress/form')?>" method="post">
	<label style="font-weight:bold;">Select Month  : &nbsp;&nbsp;</label>
	<select name="monthdropdown"  onchange="monthchange(this.value);">
	<option value="0" <?=($monthcount == 0)?'selected':''?>>Jan</option>
	<option value="1" <?=($monthcount == 1)?'selected':''?>>Feb</option>
	<option value="2" <?=($monthcount == 2)?'selected':''?>>Mar</option>
	<option value="3" <?=($monthcount == 3)?'selected':''?>>Apr</option>
	<option value="4" <?=($monthcount == 4)?'selected':''?>>May</option>
	<option value="5" <?=($monthcount == 5)?'selected':''?>>Jun</option>
	<option value="6" <?=($monthcount == 6)?'selected':''?>>Jul</option>
	<option value="7" <?=($monthcount == 7)?'selected':''?>>Aug</option>
	<option value="8" <?=($monthcount == 8)?'selected':''?>>Sep</option>
	<option value="9" <?=($monthcount == 9)?'selected':''?>>Oct</option>
	<option value="10" <?=($monthcount == 10)?'selected':''?>>Nov</option>
	<option value="11" <?=($monthcount == 11)?'selected':''?>>Dec</option>
	</select>
	</form>
	<br>
	<table id="travel" style="width:845px" cellspacing="3" cellpadding="4">
		
		<?php
		switch($monthcount)
			{
				case 0:
					if (is_array($monthanswerreport0))
				{ 
						$monthreportanswer = &$monthanswerreport0;
						break;
				}
				case 1:
					if (is_array($monthanswerreport1))
				{ 
						$monthreportanswer = &$monthanswerreport1;
						break;
				}
				case 2:
					if (is_array($monthanswerreport2))
				{ 
						$monthreportanswer = &$monthanswerreport2;
						break;
				}
				case 3:
					if (is_array($monthanswerreport3))
				{ 
						$monthreportanswer = &$monthanswerreport3;
						break;
				}
				case 4:
					if (is_array($monthanswerreport4))
				{ 
						$monthreportanswer = &$monthanswerreport4;
						break;
				}
				case 5:
					if (is_array($monthanswerreport5))
				{ 
						$monthreportanswer = &$monthanswerreport5;
						break;
				}
				case 6:
					if (is_array($monthanswerreport6))
				{ 
						$monthreportanswer = &$monthanswerreport6;
						break;
				}
				case 7:
					if (is_array($monthanswerreport7))
				{ 
						$monthreportanswer = &$monthanswerreport7;
						break;
				}
				case 8:
					if (is_array($monthanswerreport8))
				{ 
						$monthreportanswer = &$monthanswerreport8;
						break;
				}
				case 9:
					if (is_array($monthanswerreport9))
				{ 
						$monthreportanswer = &$monthanswerreport9;
						break;
				}
				case 10:
					if (is_array($monthanswerreport10))
				{ 
						$monthreportanswer = &$monthanswerreport10;
						break;
				}
				case 11:
					if (is_array($monthanswerreport11))
				{ 
						$monthreportanswer = &$monthanswerreport11;
						break;
				}
			}
		$currentmonth = $monthcount + 1;?>	
		<tr scope="row">
			<th scope="rowgroup" colspan="4"><?php echo date("M", mktime(0, 0, 0, $currentmonth, 1, 2000));?></th>
		</tr>
		<?php
		for($i=0;$i<php72_count($monthreportanswer); $i++)
		{
			echo '<tr>';
			echo '<td style="text-align:left;!important;">'.$monthreportanswer[$i]['name'].'</td>';
			echo '<td class="edit 2 '.$defaultyearly.' '.$currentmonth.' '.$monthreportanswer[$i]['criteria'].' '.$monthreportanswer[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$monthreportanswer[$i]['answer'].'</td>';
			echo '</tr>';
			buildtable($monthreportanswer[$i],$currentmonth,$defaulttype,$innovation,$defaultyearly);
		}
		
		 
		?>	
		
	</table>
	<?php } else
	{
	if(isset($_POST['monthdropdown']))
	{
		$monthcount = $_POST['monthdropdown'];
		$months=$_POST['monthdropdown'];
	}
	else
	{
		$monthcount = date("M");
		$months = date("M");  	
	}
	?>
	<br>
	<form name="monthchangeform" action="<?php site_url('incubationprogress/form')?>" method="post">
	<label style="font-weight:bold;">Select Month  : &nbsp;&nbsp;</label>
	<select name="monthdropdown"  onchange="monthchange(this.value);">
	<option value="0" <?=($monthcount == 0)?'selected':''?>>Jan</option>
	<option value="1" <?=($monthcount == 1)?'selected':''?>>Feb</option>
	<option value="2" <?=($monthcount == 2)?'selected':''?>>Mar</option>
	<option value="3" <?=($monthcount == 3)?'selected':''?>>Apr</option>
	<option value="4" <?=($monthcount == 4)?'selected':''?>>May</option>
	<option value="5" <?=($monthcount == 5)?'selected':''?>>Jun</option>
	<option value="6" <?=($monthcount == 6)?'selected':''?>>Jul</option>
	<option value="7" <?=($monthcount == 7)?'selected':''?>>Aug</option>
	<option value="8" <?=($monthcount == 8)?'selected':''?>>Sep</option>
	<option value="9" <?=($monthcount == 9)?'selected':''?>>Oct</option>
	<option value="10" <?=($monthcount == 10)?'selected':''?>>Nov</option>
	<option value="11" <?=($monthcount == 11)?'selected':''?>>Dec</option>
	</select>
	</form>
	<br>
	<table id="travel" style="width:845px" cellspacing="3" cellpadding="4">
	<tr scope="row">
	<th scope="rowgroup" colspan="4"><?php echo date("M", mktime(0, 0, 0, $months+1, 1, 2000));?></th>
	</tr>
	<?php
	for($i=0;$i<php72_count($monthreport); $i++)
	{
			echo '<tr scope="row">';
			echo '<td width="70%"><a class="fancybox" style="color:black" href="'.site_url("incubationprogress/assign/".$defaultyearly.'/'.$defaultmonthly.'/'.$monthreport[$i]['id'].'/'.$defaulttype.'/'.$innovation).'">'.$monthreport[$i]['label'].'</a></td>';

			switch($monthcount)
			{
				case 0:
				if (is_array($monthanswerreport0))
				{ 
						echo '<td width="20%" class="edit 2 '.$defaultyearly.' '.$monthcount.' '.$monthanswerreport0[$i]['criteria'].' '.$monthanswerreport0[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$monthanswerreport0[$i]['answer'].'</td>';
					    if($monthanswerreport0[$i]['document']==''){?>
						<td width="10%"><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$months.'/'.$monthanswerreport0[$i]['criteria'].'/'.$monthanswerreport0[$i]['id'].'/'.$defaultfrequency);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" onmouseover="this.src='<?php echo base_url(); ?>source/template/images/Doc_icon.png';" 
	    title="File upload"></a></td>
				<?php } 
					  else 
					  {
						echo '<td width="20%">'.substr($monthanswerreport0[$i]['document'],14,-3).'</td>';
    	 			  }
			   }
			 break;
			
				case 1:
				if (is_array($monthanswerreport1))
				{ 
					 
						echo '<td width="20%" class="edit 2 '.$defaultyearly.' '.$monthcount.' '.$monthanswerreport1[$i]['criteria'].' '.$monthanswerreport1[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$monthanswerreport1[$i]['answer'].'</td>';
					 
					    if($monthanswerreport1[$i]['document']==''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$months.'/'.$monthanswerreport1[$i]['criteria'].'/'.$monthanswerreport1[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" onmouseover="this.src='<?php echo base_url(); ?>source/template/images/Doc_icon.png';" 
	    title="File upload"></a></td>
				<?php } 
					  else 
					  {
						echo '<td width="20%">'.substr($monthanswerreport1[$i]['document'],14,-3).'</td>';
     			  }
			   }
			 break;
				case 2:
				if (is_array($monthanswerreport2))
				{ 
					  echo '<td width="20%" class="edit 2 '.$defaultyearly.' '.$monthcount.' '.$monthanswerreport1[$i]['criteria'].' '.$monthanswerreport2[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$monthanswerreport2[$i]['answer'].'</td>';
					 
					    if($monthanswerreport2[$i]['document']==''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$months.'/'.$monthanswerreport2[$i]['criteria'].'/'.$monthanswerreport2[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" onmouseover="this.src='<?php echo base_url(); ?>source/template/images/Doc_icon.png';" 
	    title="File upload"></a></td>
				<?php } 
					  else 
					  {
						echo '<td width="20%">'.substr($monthanswerreport2[$i]['document'],14,-3).'</td>';
     			  }
			   }
			 break;
				case 3:
				if (is_array($monthanswerreport3))
				{ 
					  echo '<td width="20%" class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport3[$i]['criteria'].' '.$monthanswerreport3[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$monthanswerreport3[$i]['answer'].'</td>';
					 
					    if($monthanswerreport3[$i]['document']==''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$months.'/'.$monthanswerreport3[$i]['criteria'].'/'.$monthanswerreport3[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" onmouseover="this.src='<?php echo base_url(); ?>source/template/images/Doc_icon.png';" 
	    title="File upload"></a></td>
				<?php } 
					  else 
					  {
						echo '<td width="20%">'.substr($monthanswerreport3[$i]['document'],14,-3).'</td>';
     			   }
			   }
			 break;	
				
				case 4:
				if (is_array($monthanswerreport4))
				{ 
					 echo '<td width="20%" class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport4[$i]['criteria'].' '.$monthanswerreport4[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$monthanswerreport4[$i]['answer'].'</td>';
					 
					    if($monthanswerreport4[$i]['document']==''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$months.'/'.$monthanswerreport4[$i]['criteria'].'/'.$monthanswerreport4[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" onmouseover="this.src='<?php echo base_url(); ?>source/template/images/Doc_icon.png';" 
	    title="File upload"></a></td>
				<?php } 
					  else 
					  {
						echo '<td width="20%">'.substr($monthanswerreport4[$i]['document'],14,-3).'</td>';
     			  }
			   }
			 break;
				case 5:
				if (is_array($monthanswerreport5))
				{ 
					  echo '<td width="20%" class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport5[$i]['criteria'].' '.$monthanswerreport5[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$monthanswerreport5[$i]['answer'].'</td>';
					 
					    if($monthanswerreport5[$i]['document']==''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$months.'/'.$monthanswerreport5[$i]['criteria'].'/'.$monthanswerreport5[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" onmouseover="this.src='<?php echo base_url(); ?>source/template/images/Doc_icon.png';" 
	    title="File upload"></a></td>
				<?php } 
					  else 
					  {
						echo '<td width="20%">'.substr($monthanswerreport5[$i]['document'],14,-3).'</td>';
     			  }
			   }
			 break;
				
				case 6:
				if (is_array($monthanswerreport6))
				{ 
					 echo '<td width="20%" class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport6[$i]['criteria'].' '.$monthanswerreport6[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$monthanswerreport6[$i]['answer'].'</td>';
					 
					    if($monthanswerreport6[$i]['document']==''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$months.'/'.$monthanswerreport6[$i]['criteria'].'/'.$monthanswerreport6[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" onmouseover="this.src='<?php echo base_url(); ?>source/template/images/Doc_icon.png';" 
	    title="File upload"></a></td>
				<?php } 
					  else 
					  {
						echo '<td width="20%">'.substr($monthanswerreport6[$i]['document'],14,-3).'</td>';
     			  }

			   }
			 break;
				
				case 7:
				if (is_array($monthanswerreport7))
				{ 
					  echo '<td width="20%" class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport7[$i]['criteria'].' '.$monthanswerreport7[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$monthanswerreport7[$i]['answer'].'</td>';
					 
					    if($monthanswerreport7[$i]['document']==''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$months.'/'.$monthanswerreport7[$i]['criteria'].'/'.$monthanswerreport7[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" onmouseover="this.src='<?php echo base_url(); ?>source/template/images/Doc_icon.png';" 
	    title="File upload"></a></td>
				<?php } 
					  else 
					  {
						echo '<td width="20%">'.substr($monthanswerreport7[$i]['document'],14,-3).'</td>';
     				  }
			   }
			 break;
				case 8:
				if (is_array($monthanswerreport8))
				{ 
					  echo '<td width="20%" class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport8[$i]['criteria'].' '.$monthanswerreport8[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$monthanswerreport8[$i]['answer'].'</td>';
					 
					    if($monthanswerreport8[$i]['document']==''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$months.'/'.$monthanswerreport8[$i]['criteria'].'/'.$monthanswerreport8[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" onmouseover="this.src='<?php echo base_url(); ?>source/template/images/Doc_icon.png';" 
	    title="File upload"></a></td>
				<?php } 
					  else 
					  {
						echo '<td width="20%">'.substr($monthanswerreport8[$i]['document'],14,-3).'</td>';
	     			  }
			   }
			 break;
				case 9:
				if (is_array($monthanswerreport9))
				{ 
					 echo '<td width="20%" class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport9[$i]['criteria'].' '.$monthanswerreport9[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$monthanswerreport9[$i]['answer'].'</td>';
					 
					    if($monthanswerreport9[$i]['document']==''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$months.'/'.$monthanswerreport9[$i]['criteria'].'/'.$monthanswerreport9[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" onmouseover="this.src='<?php echo base_url(); ?>source/template/images/Doc_icon.png';" 
	    title="File upload"></a></td>
				<?php } 
					  else 
					  {
						echo '<td width="20%">'.substr($monthanswerreport9[$i]['document'],14,-3).'</td>';
    	 			  }
			   }
			 break;
				case 10:
				if (is_array($monthanswerreport10))
				{ 
					  echo '<td width="20%" class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport10[$i]['criteria'].' '.$monthanswerreport10[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$monthanswerreport10[$i]['answer'].'</td>';
					 
					    if($monthanswerreport10[$i]['document']==''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$months.'/'.$monthanswerreport10[$i]['criteria'].'/'.$monthanswerreport10[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" onmouseover="this.src='<?php echo base_url(); ?>source/template/images/Doc_icon.png';" 
	    title="File upload"></a></td>
				<?php } 
					  else 
					  {
						echo '<td width="20%">'.substr($monthanswerreport10[$i]['document'],14,-3).'</td>';
	     			  }
			   }
			 break;
				case 11:
				if (is_array($monthanswerreport11))
				{ 
					  echo '<td width="20%" class="edit 2 '.$defaultyearly.' '.$months.' '.$monthanswerreport11[$i]['criteria'].' '.$monthanswerreport11[$i]['id'].' '.$defaulttype.' '.$innovation.'">'.$monthanswerreport11[$i]['answer'].'</td>';
					 
					    if($monthanswerreport11[$i]['document']==''){?>
						<td><a id="site-title" class="fancybox" href="<?=site_url('incubationprogress/fileupload/'.$innovation.'/'.$defaultyearly.'/'.$defaulttype.'/'.$months.'/'.$monthanswerreport11[$i]['criteria'].'/'.$monthanswerreport11[$i]['id']);?>"><img src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px" height="15px" onmouseover="this.src='<?php echo base_url(); ?>source/template/images/Doc_icon.png';" 
	    title="File upload"></a></td>
				<?php } 
					  else 
					  {
						echo '<td width="20%">'.substr($monthanswerreport11[$i]['document'],14,-3).'</td>';
    	 			  }
	
			   }
			 break;
			}
				
		}
		echo '</tr>';
		$monthcount++;
	//}
	?>
	</table>	
	<?php }
} ?>
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
<?php } 

?>
</div>
<?php 
function buildtable($arr,$monthcount,$defaulttype,$innovation,$defaultyearly,$depth=0)
{
	if(php72_array_key_exists('children',$arr))
	{
	foreach($arr['children'] as $row)
	{
			echo '<tr>';
			echo '<td style="text-align:left;!important;">';
			for($i=0;$i<=$depth;$i++)
			{
				echo '&nbsp;-';
			}
			echo $row['name'].'</td>';
			echo '<td class="edit 2 '.$defaultyearly.' '.$monthcount.' '.$row['criteria'].' '.$row['id'].' '.$defaulttype.' '.$innovation.'">'.$row['answer'].'</td>';
			echo '</tr>';
			buildtable($row,$monthcount,$defaulttype,$innovation,$defaultyearly,$depth++);
	}
	}
	
}
?>
<script type="text/javascript">
function change(val,criteria,label,month)
{
	         var option=val;
			 var frequency = <?php echo $defaultfrequency;?>;
			 var innovation = <?php echo $innovation;?>;
			 var year = <?php echo $defaultyearly;?>;
			 alert(month);
			 var datas = $.ajax({	
				type: "POST",
				url: "<?php echo site_url('incubationprogress/insertlist');?>",
				data: {'date_type':frequency,'innovation':innovation,'criteria':criteria,'label':label,'option':option,'month':month,'year':year},
				dataType:'json',
				success:{
					
				}
				});
						
}
</script>
