<?php 
if(php72_count($memberDetails)>0)
{
$val=array();
$val=$memberDetails[0];
}
?>
<h1><?=$cpagetitle.'-'.$innovation['name_of_enterprise']?></h1>

<div align="right">
  <a class="button" href="<?=site_url('boardmember/view_list/'.$innovationid);?>" > 
				     Back </a>
		 <?php if(!$isincubAuth) 
	         {
			 	 if($nboardmember['total'] < $nboardmember['no_boardmember'])
				 {
			  ?> <a class="button" href="<?=site_url('boardmember/suggestMember/'.$innovationid.'/'.$id);?>" > 
				     Suggest Member </a>
				 
		   <?php }	?>
		      
			      <?php $programService= $pservice; $programStage=$pstage; ?>	   
		            <a class="button" href="<?=site_url('activities/view_list/'.$innovationid.'/'.$programService.'/'.$programStage);?>">
			            Activities
			       </a>	 	
		   
        <?php }  ?>
				 &nbsp;&nbsp;
		
		</div>		        
        <table class="gtable sortable">
            <tbody>
                <tr>
                    <td width="22%">Request No. </td>
                    <td width="78%"><?php echo $val['request_number']; ?></td>
                </tr>
                <tr>
                    <td>No of Boardmember</td>
                    <td><?php echo $val['no_boardmember']; ?></td>
                </tr>
                <tr>
                    <td>Area of Expertise</td>
                    <td><?php echo $val['qualification']; ?></td>
                </tr>
                <tr>
                    <td>Desired Profile</td>
                    <td><?php echo $val['description']; ?></td>
                </tr>
            </tbody>
         </table>		
  </div>
  <br/><br/>
  <div id="user-grid" class="gtable sortable">

     <form name="membersuggestsubmit" enctype="multipart/form-data"  action="<?=site_url('boardmember/allUpdate/'.$innovationid.'/'.$id);?>" method="post" id="lineitemForm" >
		<table id="table1" class="gtable sortable">
		  <tbody>
						<thead>
							<tr>
							    <th>Member Name</th>
								<?php if(!($isincubAuth))
								{?>	
                                <th>Member Comments</th>
								<th>Member Status</th>
								 <?php } ?>
							
                                <th>Incubatee Comments</th>
								<th>Incubatee Status</th>
								<th>Action History</th>
								<th>Villgro Status</th>
						</tr>
						</thead>
		 </tbody>				
						
		<tbody id="lineitemTable">
    <?php 
	
	 	if(php72_count($assignedmember))
		{    
			$rowtype = 'odd';
			foreach($assignedmember as $row):
			?>
                    <tr class="<?=$rowtype = ($rowtype == 'odd')?'even':'odd';?>">
					
						<input type="hidden" name="id[]" value="<?php echo $row['id']; ?>" />
						
						<td align="left" valign="middle">
							<a class="fancybox" href="<?=site_url('boardmember/masterMemberDetail/'.$innovationid.'/'.$row['board_id']);?>"><?=$row['first_name']?></a>    
					   </td>
					    <?php 
					 if(!$isincubAuth)
					{?>	
						<td align="left" valign="middle">
						   <a  class="fancybox" href="<?=site_url('boardmember/boardmemberComments/'.$innovationid.'/'.$row['id'].'/'.$id);?>">View</a>
			  <?php } ?>	 </td>
						 
						 
					 <?php 
					 if(!$isincubAuth)
					{?>	 
						<td align="left" valign="middle"> 
		
						 <?php 
						 
						if($isAbi )
						{?>
						
						    <?php if(($row['member_status'])==1)
						      {
							    echo "Accepted";
							  }
					          else
							  {?> 
						       <a class="button fancybox"  height="200" href="<?=site_url('boardmember/changememberstatus/approve/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.
							   $row['board_id']);?>">Approve</a> 
						 <?php }?>
							 <?php if(($row['member_status'])==2)
							   {
								 echo "Rejected";
							   }
							   else
							   {?>	 
								 <a class="button fancybox" height="200" href="<?=site_url('boardmember/changememberstatus/reject/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.
								  $row['id'].'/'.$row['board_id']);?>">Reject</a> 
						  <?php } ?>
					     
								<?php if(($row['member_status'])==0)
								  {
									 echo "Pending";
								  } 
						  }  
					 else{ ?>
						   
						      <?php  echo $statusArr[$row['member_status']]; ?>
				 <?php  } ?> 
						
					    </td>
					<?php } ?>
					
					
						<td>
						   <a  class="fancybox" href="<?=site_url('boardmember/boardincubateeComments/'.$innovationid.'/'.$row['id'].'/'.$id);?>">View</a>
						</td>
						
						<td align="left" valign="middle">
						 <?php 
						 
						if($isincubAuth)
						{?>
						
						    <?php if(($row['incubatee_status'])==1)
						      {
							    echo "Accepted";
							  }
					          else
							  {?> 
						       <a class="button fancybox"  height="200" href="<?=site_url('boardmember/changeincubateestatus/approve/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.
							   $row['board_id']);?>">Approve</a> 
						 <?php }?>
							 <?php if(($row['incubatee_status'])==2)
							   {
								 echo "Rejected";
							   }
							   else
							   {?>	 
								 <a class="button fancybox" height="200" href="<?=site_url('boardmember/changeincubateestatus/reject/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.
								  $row['id'].'/'.$row['board_id']);?>">Reject</a> 
						  <?php } ?>
					     
								<?php if(($row['incubatee_status'])==0)
								  {
									 echo "Pending";
								  } 
						  }  else{ ?>
						  <?php  echo $statusArr[$row['incubatee_status']]; ?>
				           <?php } ?>
						
						</td>
						<td>
						     <a class="fancybox"  href="<?=site_url('boardmember/actionHistory/'.$row['board_id']);?>">
								    <img src="<?php echo base_url(); ?>source/template/images/icons/history.png" title="Action History">
							 </a> 
							
							 
						</td>
					  <?php if(!($isincubAuth))
						{?>
						
						
						<td align="left" valign="middle">
					    <?php if($isAbi)
						{?>
						    <?php  echo $statusArr[$row['villgro_status']]; ?>
						
						<?php  } 
					
						else
						{ 
						   if(($row['villgro_status'])==1)
						      {
						         echo "Accepted";
						      }
					          else
						  { ?>
						       <a class="button fancybox"  height="200" href="<?=site_url('boardmember/changevillgrostatus/approve/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.
							   $row['board_id']);?>">Approve</a> 
						 <?php } 
						 if(($row['villgro_status'])==2)
						   {
						     echo "Rejected";
						   }
						   else
						   {?>	 
							 <a class="button fancybox" height="200" href="<?=site_url('boardmember/changevillgrostatus/reject/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.
							  $row['id'].'/'.$row['board_id']);?>">Reject</a> 
				      <?php } 
					     if(($row['villgro_status'])=="")
					      {
					         echo "Pending";
			   		      } 
					 } 
				  ?> 
					   </td>
			           <?php } ?>
                    </tr>
            <?php 
			endforeach;
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
   </form>				
   </div>  