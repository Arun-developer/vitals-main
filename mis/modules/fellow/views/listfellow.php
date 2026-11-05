<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();

?>
<h1><?=$cpagetitle ?></h1>
<ul class="option-tab" style="margin-top:0px;">
        <li>
		   <a href="<?=site_url('fellow/form/'.$innovationid);?>" class="button fancybox">Send Request</a></li>
	</ul>  
<br /><br/>
<!--start table-content  -->
<?php $this->load->model('mainmaster/museraccess');
$permission = array_pop($this->museraccess->approvepermission($this->session->userdata('user_group'),'fellow','incubation'));
?>

 <div id="user-grid" class="gtable sortable">
	<table width="100%" class="items">
	<thead>
	<tr>

    <th><a href="<?=$nullLink?>" field="label">Request Number</a></th>
    <th><a href="<?=$nullLink?>" field="label">Innovator Name</a></th>
	<th><a href="<?=$nullLink?>" field="label">Description</a></th>
	<th><a href="<?=$nullLink?>" field="label">Request Date</a></th>
        <?php if($permission == 1)
        {?>
    <th><a href="<?=$nullLink?>" field="value">Status</a></th>
           <?php } ?> 
    <th><a href="<?=$nullLink?>" field="value">Details</a></th><?php // } ?>
	<th><a href="<?=$nullLink?>" field="status">Action</a></th>

	</tr>
    </thead>
	<tbody>
	<?php
	if(count($applicantList))
	{    
		$r=1;
		foreach($applicantList as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
			<tr class="<?=$row_type?>">
            <?php if($isincubAuth) {?>
            <td align="left" valign="middle"><a href="<?=site_url('fellow/jobdetails/'.$innovationid.'/'.$row["request_key"]);?>" class=" fancybox"><?=$row["request_key"];?></a></td><?php } else { ?>
            <td align="left" valign="middle"><?=$row["request_key"];?></td><?php } ?>
			<td align="left" valign="middle"><?=$row["innovator_name"];?></td>
			<td align="left" valign="middle"><?=$row["job_description"];?></td>
            <td align="left" valign="middle"><?=$row["request_date"];?></td>
                <?php if($permission == 1)
                {?>
			<td align="left" valign="middle">
				  
				 <?php if(($row['status'])==1)
						      {
							    echo "Accepted";
							  }
							  else{ if(!$isincubAuth) {?> 
							  
						       <a class="button fancybox"  height="200" href="<?=site_url('fellow/liststatus/approve/'.$innovationid.'/'.$row['id']);?>">Approve</a> 
						<?php } }?>
						 <?php if(($row['status'])==2)
						   {
						     echo "Rejected";
						   }
						   else
						   { if(!$isincubAuth) {?>	 
							 <a class="button fancybox" height="200" href="<?=site_url('fellow/liststatus/reject/'.$innovationid.'/'.$row['id']);?>">Reject</a> 
				   <?php } } ?>
					  <?php if(($row['status'])==0)
					      {
					         echo "Pending";
			   		      } ?>
					 
			</td>
		<?php } ?>	
            <td><a href="<?=site_url('fellow/applicantdetail/'.$innovationid.'/'.$row['id']);?>">Details</a></td>
			<td nowrap="nowrap" >
		          <a class="fancybox" href="<?=site_url('fellow/form/'.$innovationid.'/'.$row['id'])?>" >
					 	<img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit">
				  </a>&nbsp;
                  <a href="<?=site_url('fellow/delete/'.$row['id'])?>" class="confirmDelete"  >
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
	
