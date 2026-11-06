<?php 
if(php72_count($investerDetails)>0)
{
$val=array();
$val=$investerDetails[0];
}
?>
<h1><?=$cpagetitle ?></h1>
<br />
<!--start table-content  -->
		<div style="float:right;margin-top:-30px;">
		<?php if($this->session->userdata('user_type') != 'incubatee'){ ?>
		    <a class="button fancybox" href="<?=site_url('invester/requestDoc/'.$innovationid.'/'.$id);?>">Request Document</a>
            <a class="button" href="<?=site_url('invester/suggestinvester/'.$innovationid.'/'.$id);?>" >Suggest Investor</a> &nbsp;&nbsp;
			<?php } ?>
			<?php $programService= $pservice; $programStage=$pstage; ?>
			<a class="button" href="<?=site_url('activities/view_list/'.$innovationid.'/'.$programService.'/'.$programStage);?>">
			  Activities
			</a>
		</div>		  
 <div id="user-grid">
        <table class="gtable sortable">
            <tbody>
                <tr>
                    <td width="22%">Request No. </td>
                    <td width="78%"><?php echo $val['request_investernumber']; ?></td>
                </tr>
                <tr>
                    <td>Sector</td>
                    <td><?php echo $val['sector']; ?></td>
                </tr>
                <tr>
                    <td>Investment Required</td>
                    <td><?php echo $val['amount']; ?></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><?php echo $val['description']; ?></td>
                </tr>
				<tr>
					<td>Comments</td>
					<td><?php echo $val['comments'];?></td>
				</tr>
            </tbody>
         </table>		
  </div>
  <br/><br/>
  <div id="user-grid" class="gtable sortable">
   <form name="membersuggestsubmit" enctype="multipart/form-data"  action="<?=site_url('invester/allUpdate/'.$innovationid.'/'.$id);?>" method="post" id="lineitemForm" >
		<table id="table1" class="gtable sortable">
		  <tbody>
						<thead>
							<tr>
							    <th width="100">Invester Name</th>
                                <th width="100">Invester/Incubatee Comments</th>
						
							   <?php if($this->session->userdata('user_type') != 'incubatee')
								{?>	
								
								<th width="100">Invester Status</th>
						        <?php } ?>
                    
								<th width="100">Incubatee Status</th>
								<th width="100">Action History</th>
								<th width="100">Agreement</th>
								<th width="100">Amount Approved</th>
								<th width="100">Villgro Status</th>
							</tr>
						</thead>
		 </tbody>				
						
		<tbody id="lineitemTable">
    <?php 
	
	 if(php72_count($assignedinvester))
	{       
			$rowtype = 'odd';
			foreach($assignedinvester as $row):
			
			
			?>
                    <tr class="<?=$rowtype = ($rowtype == 'odd')?'even':'odd';?>">
					
						<input type="hidden" name="id[]" value="<?php echo $row['id']; ?>" />
						<td align="left" valign="middle"><a class="fancybox" href="<?=site_url('invester/masterinvesterDetail/'.$innovationid.'/'.$row['invester_id']);?>">
						  <?=$row['first_name']?></a>
						</td>
						<td align="left" valign="middle">
						   <a  class="fancybox" href="<?=site_url('invester/investermemberComments/'.$innovationid.'/'.$row['id'].'/'.$id);?>">View</a>
						   /  
						    <a  class="fancybox" href="<?=site_url('invester/investerincubateeComments/'.$innovationid.'/'.$row['id'].'/'.$id);?>">View</a>
						 </td>
						
						
						<?php if($this->session->userdata('user_type') != 'incubatee')
								{?>
							<td align="left" valign="middle">
								
								
								  <?php 
						 
						if($isAbi )
						{?>
						
						    <?php if(php72_cmp(($row['invester_status']))==1)
						      {
							    echo "Accepted";
								?>
								
								<?php
							  }
					          else
							  {?> 
						       <a class="button fancybox"  height="200" href="<?=site_url('invester/changeinvesterstatus/approve/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.
							   $row['invester_id']);?>">Approve</a> 
						 <?php }?>
							 <?php if(php72_cmp(($row['invester_status']))==2)
							   {
								 echo "Rejected";
								 ?>
								 
								 <?php
							   }
							   else
							   {?>	 
								 <a class="button fancybox" height="200" href="<?=site_url('invester/changeinvesterstatus/reject/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.
								  $row['id'].'/'.$row['invester_id']);?>">Reject</a> 
						  <?php } ?>
					     
								<?php if(php72_cmp(($row['invester_status']))==0)
								  {
									 echo "Pending"; 
									 ?>
									 
									 <?php
								  } 
						  }  
					 else{ ?>
						   
						      <?php  echo $statusArr[$row['invester_status']]; 
							  if($statusArr[$row['invester_status']] == 'Pending') { 
						 ?>
						  <input type="hidden"  name="invester_status"  value="<?php echo '1'; ?>"/>
						 <?php  } ?>
						  
							  
				 <?php  } ?> 
								
							
							</td>
						  <?php } 
						  else
						    {?>
							  
							
							<?php }
						  ?>
						<td align="left" valign="middle">
						   	 <?php 
						 if($this->session->userdata('user_type') == 'incubatee')
						{?>
						
						    <?php if(php72_cmp(($row['incubatee_status']))== 1)
						      {
							    echo "Accepted";
								?>
								
								<?php 
							  }
					          else
							  {?> 
						       <a class="button fancybox"  height="200" href="<?=site_url('invester/changeincubateestatus/approve/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.
							   $row['invester_id']);?>">Approve</a> 
						 <?php }?>
							 <?php if(php72_cmp(($row['incubatee_status']))==2)
							   {
								 echo "Rejected"; ?>
								 
								 
								 <?php 
							   }
							   else
							   {?>	 
								 <a class="button fancybox" height="200" href="<?=site_url('invester/changeincubateestatus/reject/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.$row['invester_id']);?>">Reject</a> 
						  <?php } ?>
					     
								<?php if(php72_cmp(($row['incubatee_status']))==0)
								  {
								  
									 echo "Pending";
									 ?>
									 
									 <?php
								  } 
						  } 
						else{ ?>
						  <?php  
						  echo $statusArr[$row['incubatee_status']];
				        } ?>
						</td>
						<td>
						        <a class="fancybox"  href="<?=site_url('invester/actionHistory/'.$row['invester_id']);?>">
								    <img src="<?php echo base_url(); ?>source/template/images/icons/history.png" title="Action History">
								</a> 
						</td>
						<td>
						  <a class="fancybox"  href="<?=site_url('invester/agreement/'.$innovationid.'/'.$id.'/'.$row['invester_id'].'/'.$row['id']);?>">
						  <?php

						  if(($row['incubatee_agreement'] == "") || ($row['invester_agreement'] ==''))
						  {?>
						  <font color="red">Agreement</font>
						  <?php } 
						  else
						  {?>
						     <font color="green">Agreement</font>
				     <?php } ?>
						  </a>
						</td>
						<td>
						   <?php if($this->session->userdata('user_type') == 'incubatee')
								{?>
								
						         <input type="hidden" name="amountapproved[]"  id="amountapproved" size="10" value="<?=  $row['amount_approved']; ?>" readonly="readonly" />
								 <?=  $row['amount_approved']; ?>
								<?php } else
								{?>
								
								 <input type="text" name="amountapproved[]"  id="amountapproved" size="10" value="<?=$row['amount_approved']; ?>" />
								<?php } ?>
						</td>
						<td align="left" valign="middle">
					      <?php 
							if($this->session->userdata('user_type') == 'incubatee' || $isAbi)
								{?>
								  <?php echo $statusArr[$row['villgro_status']]; ?>
						  <?php } else
						        {?>
								 <?php 
									    if(php72_cmp(($row['villgro_status']))==1)
										  {
											echo "Accepted";
										  }
										  else
										  {
										  ?>
										
										   <a class="button fancybox" height="200" href="<?=site_url('invester/changevillgrostatus/approve/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.$row['invester_id'].'/');?>">Approve</a> 
									
									<?php }?>
									 <?php if(php72_cmp(($row['villgro_status']))==2)
									   {
										 echo "Rejected";
									   }
									   else
									   {?>	 
										 <a class="button fancybox" height="200" href="<?=site_url('invester/changevillgrostatus/reject/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.$row['invester_id']);?>">Reject</a> 
								  <?php }  ?>
								  
								  <?php if(php72_cmp(($row['villgro_status']))==0)
									  {
										 echo "Pending";
									  } 
									  
							   } ?>
					   </td>
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
	  <br/> 
	  <div style="float:right;">
	  <?php if($this->session->userdata('user_type')!= 'incubatee')
	  {?>
	  	<input type="submit" name="txtSubmit" value="submit" class="button" />
	  <?php } ?>
		 
	  </div>	 
   </form>							
   </div>   
   <br/><br/>
   <div>
    <?php 
       $this->load->view('criteria_tab');
     ?>
   </div>   
