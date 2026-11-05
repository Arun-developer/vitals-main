<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Untitled Document</title>
</head>

<body>
    <form name="invitePrescreen" enctype="multipart/form-data"
        action="<?=site_url('screening/invite_prescreen/'.$innovation['id']);?>" method="post" id="invitePrescreen"
        class="uniform">
        <fieldset>
            <input type="hidden" value="Reinvite" name="invite" />
            <legend>"Re-Invite"</legend>
            <dl class="inline">
                <dt><label for="email">Email<font class="req_field">*</font></label></dt>
                <dd>
                    <?php $email = isset($_REQUEST["email"])?$_REQUEST["email"]:$innovation['email_id']; 
		     
		?>
                    <input type="text" value="<?=$email?>" name="email" class="input-text required email" size="40" />
                </dd>

                <dt><label for="subject">Subject<font class="req_field">*</font></label></dt>
                <dd>
                    <?php $subject = isset($_REQUEST["subject"])?$_REQUEST["subject"]:'Invitation for detailed diligence Invitation - '.$innovation['name_of_enterprise'];  
		
		?>
                    <input type="text" value="<?=$subject?>" name="subject" class="input-text required" size="40" />
                </dd>

                <dt><label for="description">Description<font class="req_field">*</font></label></dt>
                <dd>
                    <?php  
       $description = isset($_REQUEST["description"])?$_REQUEST["description"]:'';
       ?>
                    <textarea name="description" id="editor" class="input-text" rows="6"
                        cols="60"><?=$description?></textarea>
                    <font class="req_field">*</font>
                    <?php echo form_error('description','<div class="req_field">','</div>'); ?>
                </dd>
            </dl>
            <div class="buttons">
                <input type="submit" value="Re-Invite" name="txtSubmit" class="button" />
                <input type="reset" value="Reset" name="txtReset" class="button white" />
            </div>
        </fieldset>
    </form>
</body>

</html>