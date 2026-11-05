<h1><?php echo $cpagetitle.' - '.$innovation['name_of_enterprise']; $nullLink = 'javascript:void(0);'; ?></h1>


Site_Url: <a href="<?=site_url('screening/form/'.@$inviteInfo[0]['invite_code']);?>" target="_blank"
    id="LeaveParent"><?=site_url('screening/form/'.@$inviteInfo[0]['invite_code']);?></a><br />
Status:
<?php $isReinvite = false;
			if($status == '1') { 
				echo "Active&nbsp;&nbsp;&nbsp;&nbsp;".anchor('screening/invite_status/'.$innovation["id"].'/0',"Block URL",'class="button"'); 
			}else{ 
				echo "Blocked&nbsp;&nbsp;&nbsp;&nbsp;".anchor('screening/invite_status/'.$innovation["id"].'/1',"Activate URL",'class="button"');
			}
?>
<br />
<table class="gtable sortable">
    <thead>
        <tr>
            <th><a href="<?=$nullLink?>" field="from" class="sortlink">Sent By</a></th>
            <th><a href="<?=$nullLink?>" field="sent_date" class="sortlink">Sent Date</a></th>
            <th><a href="<?=$nullLink?>" field="mail_type" class="sortlink">Mail Type</a></th>
            <th><a href="<?=$nullLink?>" field="subject" class="sortlink">Subject</a></th>
            <th class="head">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
		if(count($inviteInfo))
		{   
			$row_type = 'even';
			foreach($inviteInfo as $row1)
			{
				$row_type = ($row_type == 'odd') ? ('even'):('odd');
			?>
        <tr class="<?=$row_type?>">
            <td align="left" valign="middle"><?=$row1["modified_emp"]?$row1["modified_emp"]:$row1["created_emp"]?></td>
            <td align="left" valign="middle"><?=mysql2date($row1["created_date"])?></td>
            <td align="left" valign='middle'>Invite for Diligence</td>
            <td align="left" valign='middle'><?=$row1["subject"]?></td>
            <td align="left" valign='middle'>
                <a href="<?=site_url('screening/view/'.$innovation['id'].'/'.$row1["id"]);?>"
                    class="button fancybox">View</a>&nbsp;&nbsp;
                <?php echo anchor('screening/mail/'.$innovation['id'].'/'.$row1['id'],'Resend Mail','class="button"'); ?>&nbsp;&nbsp;
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
<?php if(count($inviteInfo) == 0){ ?>
<form name="invitePrescreen" enctype="multipart/form-data"
    action="<?=site_url('screening/invite_prescreen/'.$innovation['id']);?>" method="post" id="invitePrescreen"
    class="uniform">
    <fieldset>
        <input type="hidden" value="<?=($isReinvite)?'Reinvite':'Invite';?>" name="invite" />
        <legend><?=($isReinvite)?'Re-Invite':'Invite';?></legend>
        <dl class="inline">
            <dt><label for="email">Email<font class="req_field">*</font></label></dt>
            <dd>
                <?php $email = isset($_REQUEST["email"])?$_REQUEST["email"]:$innovation['email_id']; 
		      $email = ($isReinvite)?$row['email']:$email;
		?>
                <input type="text" value="<?=$email?>" name="email" class="input-text required email" size="40" />
            </dd>

            <dt><label for="subject">Subject<font class="req_field">*</font></label></dt>
            <dd>
                <?php $subject = isset($_REQUEST["subject"])?$_REQUEST["subject"]:'Invitation for detailed diligence Invitation - '.$innovation['name_of_enterprise'];  
		$subject = ($isReinvite)?$row['subject']:$subject;
		?>
                <input type="text" value="<?=$subject?>" name="subject" class="input-text required" size="40" />
            </dd>

            <dt><label for="description">Description<font class="req_field">*</font></label></dt>
            <dd>
                <?php  
       $description = isset($_REQUEST["description"])?$_REQUEST["description"]:'';
       $description = ($isReinvite)?$row['description']:$description;
       ?>
                <textarea name="description" id="editor" class="input-text" rows="6"
                    cols="60"><?=$description?></textarea>
                <font class="req_field">*</font>
                <?php echo form_error('description','<div class="req_field">','</div>'); ?>
            </dd>
        </dl>
        <div class="buttons">
            <input type="submit" value="<?=($isReinvite)?'Re-Invite':'Invite';?>" name="txtSubmit" class="button" />
            <input type="reset" value="Reset" name="txtReset" class="button white" />
        </div>
    </fieldset>
</form>
<?php } ?>