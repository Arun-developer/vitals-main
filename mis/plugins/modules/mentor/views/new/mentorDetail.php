<?php 
$nullLink = "javascript:void(0);";

if(count($mentorDetails)>0)
{
$val=array();
$val=$mentorDetails[0];
}

?>
<input type="hidden" name="innovationid" value="<?php echo $innovationid; ?>" />
<h1><?=$cpagetitle ?></h1>

<br />


<!--start table-content  -->


<div id="user-grid" class="gtable sortable">
    <div style="float:right;margin-top:-11px;">
        <?php  if(!$isincubAuth) 
	         { ?>
        <a class="button" href="<?=site_url('mentor/suggestMentor/'.$innovationid.'/'.$id);?>">
            Suggest Mentor
        </a> &nbsp;&nbsp;
        <?php $programService= $pservice; $programStage=$pstage; ?>
        <a class="button"
            href="<?=site_url('activities/view_list/'.$innovationid.'/'.$programService.'/'.$programStage);?>">
            Activities
        </a>

        <?php } ?>
    </div>

    <table class="gtable sortable">
        <tbody>
            <tr>
                <td width="22%">Request No. </td>
                <td width="78%"><?php echo $val['request_mentornumber']; ?></td>
            </tr>
            <tr>
                <td width="22%">Sector </td>
                <td width="78%"><?php echo $val['sector']; ?></td>
            </tr>

            <tr>
                <td>Experience</td>
                <td><?php echo $val['experience']; ?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><?php echo $val['description']; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<br /><br />
<div id="user-grid" class="gtable sortable">

    <br /><br />

    <form name="mentortotalsubmit" enctype="multipart/form-data"
        action="<?=site_url('mentor/allUpdate/'.$innovationid.'/'.$id);?>" method="post" id="lineitemForm">
        <input type="hidden" name="innovationid" value="<?php echo $innovationid; ?>" />
        <table width="100%" class="items">
            <thead>
                <tr>

                    <th><a href="<?=$nullLink?>" field="label">Mentor Name</a></th>
                    <th><a href="<?=$nullLink?>" field="label">Company</a></th>

                    <th><a href="<?=$nullLink?>" field="required">Hours </a></th>
                    <th><a href="<?=$nullLink?>" field="required">Money</a></th>

                    <th><a href="<?=$nullLink?>" field="required">Villgro Status</a></th>



                </tr>
            </thead>
            <tbody>
                <?php
 
	if(count($assignmentorList))
	{   
	
	   $r=1;
		foreach($assignmentorList as $row)
		{
		
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
                <tr class="<?=$row_type?>">


                    <td align="left" valign="middle">
                        <input type="hidden" name="id[]" value="<?php echo $row['id']; ?>" id="id" />
                        <?php if($row['company']=='Villgro')
			{
			  	$this->load->model('Mmentor');
			    $employeedata=$this->Mmentor->Villgroemployeedetail($row['mentor_id']); 
				echo $employeedata[0]['emp_firstname'];
			
			}
			else
			  {?>
                        <?=$row["first_name"];?>
                        <?php }   ?>
                    </td>
                    <td align="left" valign="middle"><?=$row["company"];?></td>
                    <?php
		
			  if(($row['villgro_status'])==1)
			  {?>
                    <td align="left" valign="middle">
                        <?php  if($this->session->userdata('user_type') == 'incubatee')
					{?>
                        <?=$row['mentorhours'];?>
                        <?php } 
			   else {?>
                        <input type="text" name="mentorhour[]" value="<?=$row['mentorhours'];?>" size="5" />
                        <?php   } ?>
                    </td>
                    <td align="left" valign="middle">
                        <?php  if($this->session->userdata('user_type') == 'incubatee')
					{?>
                        <?=$row['mentormoney'];?>
                        <?php } 
			    else {?>
                        <input type="text" name="mentoramount[]" value="<?=$row['mentormoney'];?>" />
                        <?php } ?>
                    </td>
                    <?php }
		      else
			  { ?>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle">&nbsp;</td>
                    <?php  }
		 ?>

                    <td align="left" valign="middle">
                        <?php 
							if($this->session->userdata('user_type') == 'incubatee')
								{?>
                        <?php echo $statusArr[$row['villgro_status']]; ?>
                        <?php } else
						        {?>
                        <?php 
									    if(($row['villgro_status'])==1)
										  {
											echo "Accepted";
										  }
										  else
										  {?>
                        <a class="button fancybox" height="200"
                            href="<?=site_url('mentor/changevillgrostatus/approve/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.$row['mentor_id']);?>">Approve</a>
                        <?php }?>
                        <?php if(($row['villgro_status'])==2)
									   {
										 echo "Rejected";
									   }
									   else
									   {?>
                        <a class="button fancybox" height="200"
                            href="<?=site_url('mentor/changevillgrostatus/reject/'.$innovationid.'/'.$id.'/'.$row['id'].'/'.$row['mentor_id']);?>">Reject</a>
                        <?php }  ?>

                        <?php if(($row['villgro_status'])==0)
									  {
										 echo "Pending";
									  } 
									  
							   } ?>

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
                <?
	} ?>
            </tbody>
        </table>

        <br /> <br />
        <div style="float:right;">
            <input type="submit" name="txtSubmit" value="submit" class="button" />
        </div>

        <br /> <br />
    </form>


</div>