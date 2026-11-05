<script type="text/javascript">
function reject_exist_check(value)
{ 
  var vals = '';
  var urls = '<?php echo site_url("master/master_settings/reject_exist_check/");?>/'+value;
  <?php if(isset($reject_reason[0]['id'])){?>
  var vals = '<?php echo $reject_reason[0]["name"];?>';
  var urls = '<?php echo site_url("master/master_settings/reject_exist_check/");?>/'+value+'/<?php echo $reject_reason[0]["id"];?>';	
  <?php } ?>
  $.ajax({
        url: urls,
        success:function(response){
            if(response == 1)
            {
                $('#name_error').html(value +' Reject Reason Name already Exist').css('color','red');
                $('#reject_name').val(vals);
            }
            else
            {
                $('#name_error').html('');
            }
        }

    });
}
</script>

<h1 style="margin: 15px 0 10px;"><?=$cpagetitle?></h1>
<div style=" float:right; text-align:right;width:100%;">
	<?php echo anchor('master/master_settings/reject_reasons','Back','class="button"'); ?>
</div>
<?php
$url = 'master/master_settings/reject_reasons_add';
if(isset($reject_reason[0]['id']))
    {
    	$url = 'master/master_settings/reject_reason_edit/'.$reject_reason[0]['id'];
    }
 ?>

<form name="rejectReasonForm" enctype="multipart/form-data" action="<?=site_url($url);?>" method="post" id="rejectReasonForm" class="uniform" >
<dl class="inline">
<?php if($this->session->userdata('user_type') == 'superadmin'){?>
            <dt><label for="program">Partner</label></dt>
            <dd><?php $branch_name = (isset($reject_reason[0]['partner_id']))?$reject_reason[0]['partner_id']:""; ?>
              <select name="branch" id="branch">
                  <option value="">Select Partner</option>
                  <?php 
                  foreach ($branch as $partner) { ?>
                     <option value="<?php echo $partner['id'];?>"<?php echo ($branch_name==$partner['id'])?('selected'):(''); ?>><?php echo $partner['branch_name'];?> </option>
                  <?php } ?>
              </select>
            </dd>
<?php } ?> 
            <dt><label for="reason">Reject Reason Name</label></dt>
            <dd>
             <?php 

             $reject_name = (isset($reject_reason[0]['master_name']))?$reject_reason[0]['master_name']:"";
				?>
				<input type="text" name="reject_name" id="reject_name" value="<?php echo $reject_name;?>" class="required" onblur="reject_exist_check(this.value)">
				<span id="name_error"></span>
				<?php
				echo '<font class="req_field">*</font>'.form_error('master_name', '<div class="errorMsg">', '</div>');
		     ?>
            </dd>
 </dl>          
 <div class="buttons">
    <?php
    $text = 'Add';
    if(isset($reject_reason[0]['id']))
    {
    	$text = 'Update';
    	?>
    	<input type="hidden" name="id", id="id" value="<?php echo $reject_reason[0]['id'];?>">
    	<?php
    }
    ?>
    <button type="submit" class="button" value="Save" name="txtSubmit"><?php echo $text;?></button>
    <button type="reset" class="button white">Reset</button>
</div>

</form>
<!-- end id-form  -->
