<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();

?>
<h1><?=$cpagetitle ?></h1>
<ul class="option-tab" style="margin-top:0px;">
        <li>
		   <a href="<?=site_url('invester/form/'.$innovationid);?>" class="button fancybox">Send Request</a></li>
 	</ul>  
<br /><br/>
<!--start table-content  -->


 <div id="user-grid" class="gtable sortable">
	<table width="100%" class="items">
	<thead>
	<tr>

    <th><a href="<?=$nullLink?>" field="label">Request Number</a></th>
	<th><a href="<?=$nullLink?>" field="label">Sector</a></th>
    <th><a href="<?=$nullLink?>" field="input_type">Amount</a></th>
    <th><a href="<?=$nullLink?>" field="value">Status</a></th>
    <th><a href="<?=$nullLink?>" field="status">Detail</a></th>
	<?php if($isincubAuth)
	    {?>
     <th><a href="<?=$nullLink?>" field="status">Action</a></th>
  <?php  } ?>

	</tr>
    </thead>
	<tbody>
	<?php
	if(count($investerList))
	{    
		$r=1;
		foreach($investerList as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
			<tr class="<?=$row_type?>">
            <td align="left" valign="middle"><?=$row["request_investernumber"];?></td>
            <td align="left" valign="middle"><?=$row["sector"];?></td>
			<td align="left" valign="middle"><?=$row["amount"];?></td>
			<td align="left" valign="middle">
			<?php 
			if($isincubAuth || $isAbi) 
			{
			   echo $statusArr[$row['status']];
			}
			else
			{?>
			 <?php if(($row['status'])==1)
					  { echo "Accepted";}
				   else
					  {?> 
						   <a class="button fancybox"  height="200" href="<?=site_url('invester/liststatus/approve/'.$innovationid.'/'.$row['id']);?>">Approve</a>  
				 <?php }?>
			<?php if(($row['status'])==2)
					  {  echo "Rejected";}
				   else
                      {?>	 
						<a class="button fancybox" height="200" href="<?=site_url('invester/liststatus/reject/'.$innovationid.'/'.$row['id']);?>">Reject</a> 
				 <?php }  ?>
					  
			  <?php if(($row['status'])==0)
			   { echo "Pending"; } ?>
			<?php }  ?>
  
			</td>
			<td nowrap="nowrap">
		           <a href="<?=site_url('invester/investerDetail/'.$innovationid.'/'.$row['id']);?>"> Details</a>	
			</td>
            <?php if($isincubAuth)
	       {?>
			<td nowrap="nowrap" >
		          <a class="fancybox" href="<?=site_url('invester/form/'.$innovationid.'/'.$row['id']);?>" >
					 	<img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit">
				  </a>&nbsp;
                  <a href="javascript:void(0);" url="<?=site_url('seedfunding/milestone/delete/'.$row['id'])?>" class="confirmDelete"  >
					    <img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete">
				  </a>	
			</td>
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
	<?
	} ?>
	</tbody>
	</table>
	<!-- Paging style -->
	</div>   
	
	
	<br/><br/>
	
