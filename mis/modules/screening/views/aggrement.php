<?php
$isAuth = false;
if(in_array($this->session->userdata('user_type'),array('superadmin','admin','ceo','cio')) || $innovation['isAssociate'])
{
	$isAuth = true;
}
?>
<h1><?=$cpagetitle?> - <?=$innovation['name_of_enterprise']?> - Agreement</h1>
<?php 
$this->load->view('criteria_tab');
if($isAuth){ 
?>
<div class="t-right" style="float:right">
<a href="<?=site_url('screening/agreementhistory/'.$innovation['id']);?>" class="button fancybox">Action History</a>
<a href="<?=site_url('screening/createagreement/'.$innovation['id']);?>" class="button">Export To Doc</a>
<a href="<?=site_url('screening/update_agreement/'.$code);?>" class="fancybox button">Edit Agreement</a></div>
<?php } 
foreach($innovationAgreement as $row):
?>
<br />
<h2>Agreement</h2>
<p>
<?php  echo $row['agreement']; ?>
<p>
<?php
if($row['status'] == 0 && !$isAuth){ ?>
<a href="<?=site_url('screening/accept_agreement/'.$code);?>" class="button">Accept Agreement</a>
<?php }
else
{
	?>
    <h2>Agreement Accept Status : <?=($row['status'] == 0)?'Pending':'Accepted';?> </h2>
    <?php 
}
if($row['status'] == 1 ){
?>

<!--Signed Copy Uploaded by Innovator-->
<form name="documents" action="<?=site_url('screening/agreement_signed/'.$code.'/copy1');?>" enctype="multipart/form-data" method="post" id="documents"  class="uniform">
    <input type="hidden" name="innovation" value="<?=$innovation['id']?>" />
    <fieldset>
    <legend>Signed Document by <?=$innovation['name_of_enterprise']?></legend>
    <dl class="inline">
        <dt><label for="signed_document">Signed Document</label></dt>
        <dd>
        <input type="file" size="40"  name="signed_document"  />
        <input type="hidden" value="<?=$row['signed_copy1']?>" name="pre_signed_document"  />
        <?php
        if($row['signed_copy1']!=''){?><br />

       <strong> <?php echo $row['signed_copy1']; echo '&nbsp;( '.mysql2date($row['signed_copy1_date']).' )';?> </strong>
        <a href="<?=base_url()?>uploads/agreement/<?=$row['signed_copy1']?>" target="_blank">
        <img src="<?=base_url();?>source/template/images/icons/download.gif" height="16" alt="download"></a> 
        <?php } ?>
        </dd>
    </dl>
    <div class="buttons">
        <input type="submit" class="button" name="txtSubmit" value="Upload" id="submit" />&nbsp;&nbsp;
        <input type="reset" class="button white" name="txtReset" value="Reset" />
    </div>
    </fieldset>
</form>

<!--Signed Copy Uploaded by Villgro-->
	<?php if($isAuth){ ?>
    <form name="documents" action="<?=site_url('screening/agreement_signed/'.$code.'/copy2');?>" enctype="multipart/form-data" method="post" id="documents"
     class="uniform">
    <input type="hidden" name="innovation" value="<?=$innovation['id']?>" />
    <fieldset>
    <legend>Signed Document by Villgro</legend>
        <dl class="inline">
            <dt><label for="signed_document">Signed Document</label></dt>
            <dd>
            <input type="file" size="40" name="signed_document"  />
            <input type="hidden" value="<?=$row['signed_copy2']?>" name="pre_signed_document"  />
            <?php
            if($row['signed_copy2']!=''){ ?> <br />
             <strong> <?php echo $row['signed_copy2']; echo '&nbsp;( '.mysql2date($row['signed_copy2_date']).' )';?> </strong>
            <a href="<?=base_url()?>uploads/agreement/<?=$row['signed_copy2']?>" target="_blank">
            <img src="<?=base_url();?>source/template/images/icons/download.gif" height="16" alt="download"></a> <?php } ?>
            </dd>
        </dl>
        <div class="buttons">
            <input type="submit" class="button" name="txtSubmit" value="Upload" id="submit" />&nbsp;&nbsp;
            <input type="reset" class="button white" name="txtReset" value="Reset" />
        </div>
       </fieldset>
    </form>
    <?php 
    }}
	
endforeach;
?>
<h1>Agreement - Comments</h1>
<ul class="comments">
<?php 
foreach($agreementComments as $com):
?>
                    <li>
						<div class="comment-body clearfix">
							<img class="comment-avatar" src="<?=base_url();?>source/template/images/icons/dummy.gif" />
							
							<div><?=$com['comments']?></div>
						</div>
						<div class="links">
							<span class="date"><strong>Added Date :</strong><?=mysql2date($com['created_date'])?></span>
                            <span class="date"><strong>Added By :</strong> <?=($com['created_emp'] == '')?'Innovator':$com['created_emp'];?></span>
							<?php if($isAuth){ ?>
                            <a href="javascript:void(0);" url="<?=site_url('screening/delete_agreement_comments/'.$code.'/'.$com["id"],"delete",'class="button"');?>" class="confirmDelete delete">Delete</a>
                            <?php } ?>
						</div>
					</li>
<?php
endforeach; 
?>				
</ul>
<script type="text/javascript">
		 $(document).ready( function() {
			$.metadata.setType("attr", "validate");
            $("#add_agreement_comments").validate();
		  });
</script>
<form name="add_agreement_comments" enctype="multipart/form-data" action="<?=site_url('screening/add_agreement_comments/'.$code)?>" method="post" id="add_agreement_comments" >
<input type="hidden" name="assess_id" value=""  />
<fieldset>
    <legend>Post Comments</legend>
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
