<?php 
$nullLink = "javascript:void(0);";

if(count($traininglist)>0)
{
$val=array();
$val=$traininglist[0];
}

?>
<input type="hidden" name="innovationid" value="<?php echo $innovationid; ?>" />
<h1><?=$cpagetitle ?></h1>

<br />


<!--start table-content  -->


<div id="user-grid" class="gtable sortable">

    <table class="gtable sortable">
        <tbody>
            <tr>
                <td width="22%">Request No. </td>
                <td width="78%"><?php echo $val['program_type']; ?></td>
            </tr>

            <tr>
                <td>Innovator Name</td>
                <td><?php echo $val['program_service']; ?></td>
            </tr>
            <tr>
                <td>Request Date</td>
                <td><?php echo $val['start_date']; ?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><?php echo $val['end_date']; ?></td>
            </tr>
            <tr>
                <td>From Period</td>
                <td><?php echo $val['documents']; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<br /><br />
<div id="user-grid" class="gtable sortable">

    <ul class="option-tab" style="margin-top:0px;">
        <li><?php echo anchor('training/addparticipant/'.$innovationid,'Add Participant','class="button"'); ?></li>
    </ul>
    <br /><br />

    <form action="<?= site_url('training/addparticipantstatus')?>" method="post">
        <input type="hidden" name="id" value="" />
        <table width="100%" class="items">
            <thead>
                <tr>
                    <th><a href="<?=$nullLink?>" field="label">Participant Type</a></th>
                    <th><a href="<?=$nullLink?>" field="label">Participant Name</a></th>
                    <th><a href="<?=$nullLink?>" field="label">Participant Organization</a></th>
                    <th><a href="<?=$nullLink?>" field="required">Participant status</a></th>
                    <th><a href="<?=$nullLink?>" field="required">Status</a></th>
                    <th><a href="<?=$nullLink?>" field="value">Action</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
 
	if(count($trainingDetails))
	{    
		$i=0;
		foreach($trainingDetails   as $row)
		{
			
	?>
                <tr>
                    <td align="left" valign="middle"><?php echo $row['participant_type'];?></td>
                    <td align="left" valign="middle"><?php echo $row['participant_name'];?></td>
                    <td align="left" valign="middle"><?php echo $row['participant_organization'];?></td>
                    <td align="left" valign="middle"><?php echo $row['participant_status'];?></td>
                    <td align="left" valign="middle">
                        <select name="status[]">
                            <?php if($row['status'] != ""){
					?>
                            <option value="<?=$row['status'];?>"><?=$row['status'];?></option><?php } else {?>
                            <option value="">--select--</option>
                            <option value="accept">Accept</option>
                            <option value="attended">Attended</option>
                            <option value="rejected">Rejected</option><?php } ?>
                        </select>
                    </td>
                    <td>
                        <a href="<?=site_url('training/addparticipant/'.$innovationid.'/'.$row['id'])?>"><img
                                src="<?php echo base_url(); ?>			source/template/images/icons/edit.png"
                                title="Edit"></a>&nbsp;
                        <a href="javascript:void(0);" url="<?=site_url('training/delete/'.$row['id'])?>"
                            class="confirmDelete"><img
                                src="<?php echo base_url(); ?>source/template/images/icons/cross.png"
                                title="Delete"></a>
                    </td>
                </tr>
                <input type="hidden" name="id[]" value="<?=$row['id'];?>" />
                <?php 
			$i++;
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
        <div align="right">

            <input type="submit" name="txtsubmit" value="save" class="button" />
        </div>
    </form>

</div>