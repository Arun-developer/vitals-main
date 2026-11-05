<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();
$if = (!$isincubAuth);
?>
<h1><?=$cpagetitle ?></h1>
<ul class="option-tab" style="margin-top:0px;">
    <?php  if($isincubAuth)
    { ?>
    <li>
        <a href="<?=site_url('training/form/'.$innovationid);?>" class="button">Request Program Service Offering</a>
    </li>
    </li>
    <?php	} else {?>
    <li>


        <?php  } ?>
    <li>
        <a href="<?=site_url('training/budget/'.$innovationid)?>" class="button">Add Budget</a>
    </li>
</ul>
<br /><br />
<!--start table-content  -->


<div id="user-grid" class="gtable sortable">
    <table width="100%" class="items">
        <thead>
            <tr>
                <th><a href="<?=$nullLink?>" field="label">Program Type</a></th>
                <th><a href="<?=$nullLink?>" field="label">Program Service Offering</a></th>
                <th><a href="<?=$nullLink?>" field="label">Program Service Offering Instance</a></th>
                <th><a href="<?=$nullLink?>" field="label">Start Date</a></th>
                <th><a href="<?=$nullLink?>" field="value">End Date</a></th>
                <th><a href="<?=$nullLink?>" field="value">Documents</a></th>
                <th><a href="<?=$nullLink?>" field="value">Status</a></th>

                <?php if($if){?>
                <th><a href="<?=$nullLink?>" field="details">Details</a></th>
                <th><a href="<?=$nullLink?>" field="status">Action</a></th><?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
	if(count($traininglist))
	{    
		$r=1;
		foreach($traininglist as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
            <tr class="<?=$row_type?>">
                <td align="left" valign="middle"><?=$row["program_type"];?></td>
                <td align="left" valign="middle"><?=$row["program_service"];?></td>
                <td align="left" valign="middle"><?=$row["program_service_instance"];?></td>
                <td align="left" valign="middle"><?=$row['start_date'];?></td>
                <td align="left" valign="middle"><?=$row['end_date'];?></td>
                <td align="left" valign="middle"><?=$row['documents'];?></td>
                <td align="left" valign="middle">
                    <?php if(($row['status'])==0)
						      {
							    echo "Accepted";
							  }
							  else
							  { if(!$isincubAuth) {?>
                    <a class="button fancybox " height="200"
                        href="<?=site_url('training/liststatus/approve/'.$innovationid.'/'.$row['id']);?>">Approve</a>
                    <?php } }?>
                    <?php if(($row['status'])==1)
						   {
						     echo "Rejected";
						   }
						   else
						   { if(!$isincubAuth) {?>
                    <a class="button  fancybox" height="200"
                        href="<?=site_url('training/liststatus/reject/'.$innovationid.'/'.$row['id']);?>">Reject</a>
                    <?php } } ?>

                    <?php if(($row['status'])==2)
					      {
					         echo "Pending";
			   		      } ?>
                </td>
                <td>
                    <?php if(!$isincubAuth){ ?>
                    <?php if($row['status']==0){?>
                    <a href="<?=site_url('training/participant/'.$innovationid.'/'.$row['id'])?>">Details</a><?php } }?>
                </td>

                <td nowrap="nowrap">
                    <?php if(!$isincubAuth){ ?>
                    <?php if($row['status']==0){?>
                    <a href="<?=site_url('training/addtraining_detail/'.$innovationid.'/'.$row['id'])?>"
                        class="button">Add</a><?php }?>
                    <a href="<?=site_url('training/form/'.$innovationid.'/'.$row['id'])?>">
                        <img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit">
                    </a>&nbsp;
                    <a href="<?=site_url('training/delete/'.$row['id'])?>" class="confirmDelete">
                        <img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete">
                    </a><?php  } ?>
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


<br /><br />