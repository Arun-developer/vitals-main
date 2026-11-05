<?php 
$this->load->library('jquery');
$this->jquery->fancybox();
$aisDomain = "http://localhost/ais/index.php/";
?>
<h1><?=$cpagetitle.'-'.$innovation['name_of_enterprise']?></h1>
 <?php if(!$isincubAuth){?> 
<ul class="option-tab" style="margin-top:0px;">
 <li><?php echo "<a href=\"javascript:history.go(-1)\" class='button'>GO BACK</a>";?></li>
    <li><a href="<?=site_url('fellow/add_fund/'.$innovation['id']);?>" class="button">Add</a></li>   
 </ul> <?php }?>

 <br />
<br />
	<table class="gtable sorttable">
	<thead>
		<tr>
        	<tr>
            <th width="235">Line Item</th>
            <th width="235">Amount</th>
            <th width="235">Period</th>
		</tr>
	</thead>
	<tbody id="activitiesTable">
    	 <?php 
	if(count($budgetList))
	{    
			foreach($budgetList as $row):
			?>
                    <tr>
                    <td align="left" valign="middle" width="235"><?=$row['line_item']?></td>
                    <?php if(!$isincubAuth)
					{
						?>
                    <td align="left" valign="middle" width="235"><a href="<?=site_url('fellow/getinstallment/'.$innovation['id'].'/'.$row['id'])?>" class="button"><?=$row['amount']?></a></strong></td>
                    <?php } else
					{
						?>
                     <td align="left" valign="middle"><?=$row['amount'];?></td><?php } ?>
                    <td align="left" valign="middle"> <?=$row['start_date']?>-  <?=$row['end_date']?></td>
                    </tr>
            <?php 
			endforeach;
			?>
             <tr>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp; </td>
					  <td align="left" valign="middle"><strong>
                       </td>								          
                    </tr>
            <?php
	}
	else
	{ ?>
		<tr>
		<td colspan='7' align='center'>No Records found!</td>
		</tr>
	<?php
	} ?> 
	</tbody>
	</table>
	<!-- Paging style -->
