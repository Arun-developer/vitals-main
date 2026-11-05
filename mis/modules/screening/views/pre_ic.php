<?php
$isAuth = false;
if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || $innovation['isAssociate'])
{
	$isAuth = true;
}
?>
<ul class="option-tab">
<li><a href="<?=site_url('screening/form/'.$innovation['id']);?>" class="button">Back</a></li>
</ul>
<h1><?php echo $cpagetitle.' - '.$innovation['name_of_enterprise']; ?></h1>
<?php

$isReinvite = false;
if(count($sentInfo)>0)
{
	?>
    <table class="gtable detailtable">
		<tbody>
			<tr>
				<th><strong>Sent By</strong></th>
                <th><strong>Sent Date</strong></th>
				<th><strong>Last Re-Sent By</strong></th>
				<th><strong>Last Re-Sent Date</strong></th>
			</tr>
    <?php
	foreach($sentInfo as $row):
		$subject = $row['subject'];
		$body = $row['body'];
		$email = $row['email'];
		$isReinvite = true;
		?>
			<tr class="even">
				<td><?=$row['created_emp']?></td>
                <td><?=mysql2date($row['created_date'])?></td>
				<td><?=$row['modified_emp']?></td>
				<td><?=mysql2date($row['modified_date'])?></td>
			</tr>
		<?php 
	endforeach;
	?>
    </tbody>
	</table>
    <?php
}
else
{
	$subject = $mailTemplate['0']['subject'];
	$body = $mailTemplate['0']['body'];
	$email = $userSetup['pre_ic'];
}
?>

<form name="send_pre_ic" enctype="multipart/form-data" action="<?=site_url('screening/send_pre_ic/'.$innovation['id']);?>" method="post" id="send_pre_ic" class="uniform">
<fieldset>
<input type="hidden" value="<?=$innovation['id']?>" name="innovation"  />

<input type="hidden" value="<?=($isReinvite)?'resend':'send';?>" name="send"  />
    <legend><?=($isReinvite)?'Resent':'Send';?> To Pre-Incubation Committee</legend>
    <dl class="inline">
        <dt><label for="email">To Email<font class="req_field">*</font></label></dt>
        <dd>
		<?php $email = ($isReinvite)?$row['email']:$email; ?>
		<input type="text" value="<?=$email?>" name="email" class="input-text required email" size="40" />
		</dd>
        
        <dt><label for="subject">Subject<font class="req_field">*</font></label></dt>
        <dd>
	   	<?php 
		$subject = ($isReinvite)?$row['subject']:$subject;
		?>
		<input type="text" value="<?=$subject?>" name="subject" class="input-text required" size="40" />
		</dd>
        
        <dt><label for="subject">Document<font class="req_field">*</font></label></dt>
        <dd><?=$document?>
        <input type="hidden" value="<?=$document?>" name="document" class="input-text required" size="40" />
	   	&nbsp;&nbsp;<a href="<?=base_url()?>uploads/<?=$document?>" target="_blank"><img src="<?=base_url()?>source/template/images/icons/download.gif" height="16" /></a>
		</dd>
        <dt><label for="body">Message<font class="req_field">*</font></label></dt>
        <dd>
	   <?php  
       $body = ($isReinvite)?$row['body']:$body;
       ?>
		<textarea name="body" id="editor" class="input-text" rows="6" cols="60"><?=$body?></textarea>
		 <font class="req_field">*</font>
         <?php echo form_error('description','<div class="req_field">','</div>'); ?>
		</dd>
    </dl>
   	<div class="buttons">
			<input type="submit" value="<?=($isReinvite)?'Re-Send':'Send';?>" name="txtSubmit" class="button"  />
			<input type="reset" value="Reset" name="txtReset" class="button white" />
	</div>
    </fieldset>
	</form>
<?php 
if($isAuth)
{
?>
<h1>Pre-Incubation Committee Comments</h1>
<ul class="comments">
<?php 
foreach($preIcComments as $com):
?>
                    <li>
						<div class="comment-body clearfix">
							<img class="comment-avatar" src="<?=base_url();?>source/template/images/icons/dummy.gif" />
							
							<div><?=$com['comments']?></div>
						</div>
						<div class="links">
							<span class="date"><strong>Added Date :</strong><?=mysql2date($com['created_date'])?></span>
                            <span class="date"><strong>Added By :</strong> <?=$com['created_emp']?></span>
							<a href="javascript:void(0);" url="<?=site_url('screening/delete_preiccomments/'.$innovation['id'].'/'.$com["id"],"delete",'class="button"');?>" class="confirmDelete delete">Delete</a>
						</div>
					</li>
<?php
endforeach; 
?>				
</ul>
<script type="text/javascript">
		 $(document).ready( function() {
			$.metadata.setType("attr", "validate");
            $("#add_comments").validate();
		  });
</script>
<form name="add_comments" enctype="multipart/form-data" action="<?=site_url('screening/add_preiccomments/'.$innovation['id'])?>" method="post" id="add_comments" >
<fieldset>
    <legend>Post Comments</legend>
    <input type="hidden" value="<?=$innovation['id']?>" name="innovation"  />
    <dl class="inline">
        <dt><label for="name">Comments<span class="req_field">*</span></label></dt>
        <dd><textarea name="comments" class="input-text required" rows="5" cols="80" ></textarea></dd>
	</dl>
<div class="buttons" style="margin-left:40%;">
		<input type="submit" value="Post Comments" name="txtSubmit" class="button" />
		<input type="reset" value="Reset" name="txtReset" class="button white" />
</div>
</fieldset>
</form>
<?php }?>