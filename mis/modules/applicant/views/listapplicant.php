<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();

?>
<h1><?=$cpagetitle ?></h1>
<ul class="option-tab" style="margin-top:0px;">
 <?php  if($isincubAuth)
    { ?>
        <li>
		   <a href="<?=site_url('applicant/form/'.$innovationid);?>" class="button fancybox">Send Request</a></li>
	    </li>
 <?php	}	?>
 	</ul>  
<br /><br/>
<!--start table-content  -->


 <div id="user-grid" class="gtable sortable">
	<table width="100%" class="items">
	<thead>
	<tr>
		<th><a href="<?=$nullLink?>" field="label">Request Number</a></th>
		<th><a href="<?=$nullLink?>" field="label">Job Title</a></th>
		<th><a href="<?=$nullLink?>" field="label">Sector</a></th>
		<th><a href="<?=$nullLink?>" field="label">Education</a></th>
		<th><a href="<?=$nullLink?>" field="value">status</a></th>
		<th><a href="<?=$nullLink?>" field="status">Detail</a></th>
		<th><a href="<?=$nullLink?>" field="status">Action</a></th>
	</tr>
    </thead>
	<tbody>
	<?php
	
	if(php72_count($applicantList))
	{    
		$r=1;
		foreach($applicantList as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
			<tr class="<?=$row_type?>">
            <td align="left" valign="middle"><?=$row["request_applicantnumber"];?></td>
			<td align="left" valign="middle"><?=$row["jobtitle"];?></td>
			<td align="left" valign="middle"><?=$row["education"];?></td>
            <td align="left" valign="middle"><?=$row["sector"];?></td>
			<td align="left" valign="middle">
				<?php if(php72_cmp(($row['status']))==1)
					{
						echo "Accepted";
					}
					else
					{ ?> 
						<a class="button fancybox"  height="200" href="<?=site_url('applicant/liststatus/approve/'.$innovationid.'/'.$row['id']);?>">Approve</a> 
					<?php }?>
					<?php if(php72_cmp(($row['status']))==0)
						{
							echo "Rejected";
						}
						else
						{ ?>	 
							<a class="button fancybox" height="200" href="<?=site_url('applicant/liststatus/reject/'.$innovationid.'/'.$row['id']);?>">Reject</a> 
					<?php }  ?>
					
					<?php if(php72_cmp(($row['status']))==2)
					{
						echo "Pending";
					} ?>
			</td>
			<td nowrap="nowrap">
		        <a href="<?=site_url('applicant/applicantDetail/'.$innovationid.'/'.$row["id"]);?>"> Details</a>	
			</td>
            
			<td nowrap="nowrap" >
		          <a class="fancybox" href="<?=site_url('applicant/form/'.$innovationid.'/'.$row['id'])?>" >
					 	<img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit">
				  </a>&nbsp;
                  <a href="javascript:void(0);" url="<?=site_url('seedfunding/milestone/delete/'.$row['id'])?>" class="confirmDelete"  >
					<img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete">
				  </a>	
			</td>
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
	
