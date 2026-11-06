<?php
$nullLink = "javascript:void(0);";
$this->load->model('exit_details/mexitdetails');
?>
<h1><?=$cpagetitle ?></h1>
<div id="user-grid" class="gtable sortable">
	<table width="100%" class="items">
	<thead>
	<tr>
	<th><a href="<?=$nullLink?>" field="label">Innovation</a></th>
 	<th><a href="<?=$nullLink?>" field="label">Date</a></th>
	<th><a href="<?=$nullLink?>" field="label">Description</a></th>
	<th><a href="<?=$nullLink?>" field="label">Reason</a></th>
    <th><a href="<?=$nullLink?>" field="value">Decision</a></th>
    <th><a href="<?=$nullLink?>" field="value">Exit_Status</a></th>
	</tr>
    </thead>
	<tbody>
	<?php
	if(php72_count($exitdetails))
	{    
		$r=1;
		foreach($exitdetails as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
			<tr class="<?=$row_type?>">
            <td align="left" valign="middle"><?=$this->mexitdetails->getenterprisename($row["innovation"]);?></td>
            <td align="left" valign="middle"><?=$row["exit_date"];?></td>
			 <td align="left" valign="middle"><?=$row["exit_description"];?></td>
             <td align="left" valign="middle"><?=$row['exit_reason'];?></td>
			<td align="left" valign="middle">
				 <?php if(php72_cmp(($row['ceo_status']))==1)
						      {
							    echo "Accepted";
							  }
							  else if(php72_cmp($row['ceo_status']) == 0)
							  { if($this->session->userdata('user_type')!= 'incubatee' ) {?> 
						       <a class="button fancybox "  height="200" href="<?=site_url('exit_details/exitdetails/liststatus/approve/'.$row['innovation'].'/'.$row['id']);?>">Approve</a> 
						 <?php } }?>
						 <?php if(php72_cmp(($row['ceo_status']))==2)
						   {
						     echo "Rejected";
						   }
						   else if(php72_cmp($row['ceo_status']) == 0)
						   { if($this->session->userdata('user_type')!= 'incubatee') {?>	 
							 <a class="button  fancybox" height="200" href="<?=site_url('exit_details/exitdetails/liststatus/reject/'.$row['innovation'].'/'.$row['id']);?>">Reject</a> 
				      <?php } } ?>
					  
					  <?php if(php72_cmp(($row['ceo_status']))==0)
					      {
					         echo "Pending";
			   		      } ?>
			</td>
			<?php if(php72_cmp($row['exitstatus']) == 1)
			{?>
				<td align="left" valign="middle">Successfull</td>	
			<?php } else {?>
				<td align="left" valign="middle">UnSuccessfull</td>	
			<?php } ?>
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
	
	
	<br/><br/>
	
