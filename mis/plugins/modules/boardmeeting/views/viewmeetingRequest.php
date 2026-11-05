<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->load->model('Mmeeting');
$this->jquery->fancybox();
?>
<h1><?=$cpagetitle ?></h1>
<br />

 <div id="user-grid" class="gtable sortable">

	<table id="table1" class="gtable sortable">
						<thead>
							<tr>
                                <th>Subject</th>
								<th>Status</th>
                                <th>Document</th>
								<th>Organizer</th>
                                <th>View</th>
							</tr>
						</thead>
						
		<tbody id="lineitemTable">
    <?php 
	 if(count($activityDetails))
	{    
			$rowtype = 'odd';
			foreach($activityDetails as $row):
			
			?>
                 <tr class="<?=$rowtype = ($rowtype == 'odd')?'even':'odd';?>">
						<td align="left" valign="middle"> <?= $row['subject']?></td>
						<td align="left" valign="middle"><?php if($row['status']==1)
						{?>
						  <img src="<?=base_url()?>source/template/images/icons/tick.png"  />
				  <?php } else
				        {?>
						 <img src="<?=base_url()?>source/template/images/icons/wrong.gif"  />
				  <?php } ?>
						 </td>
						<td align="left" valign="middle">
						 <?php if($row['filedoc'] !='')
						       {?>
						           <a target="_blank" href="<?=base_url()?>/uploads/boardmeeting/<?php echo $row['filedoc'];?>">Download</a>
						 <?php } 
						      else
						      { ?>
						             <?php echo "No Files"; ?>
				    	<?php } ?>
						</td>
						<td>
						   <?php  $emparr=$this->Mmeeting->findOrganizer($row['id']);
						         if(!empty($emparr))
								 {
						         echo $emparr['0']['employee'];
								 }
						    ?>
						</td>
						<td align="left" valign="middle">
						    <a href="<?=site_url('boardmeeting/view/'.$innovationid.'/'.$row['id'].'/view');?>" class="button">View</a>
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
	<?
	} ?>
	 <br/>
	
	</tbody>				
						
	</table>
	
	
	 </div>  
	<tbody>
	
	</tbody>
	</table>
	<!-- Paging style -->

