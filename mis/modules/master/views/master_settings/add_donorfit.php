<script type="text/javascript">
function donor_exist_check(value)
{ 
  var vals = '';
  var urls = '<?php echo site_url("master/master_settings/donor_exist_check/");?>/'+value;
  <?php if(isset($donor[0]['id'])){?>
  var vals = '<?php echo $donor[0]["name"];?>';
  var urls = '<?php echo site_url("master/master_settings/donor_exist_check/");?>/'+value+'/<?php echo $donor[0]["id"];?>';	
  <?php } ?>
  $.ajax({
        url: urls,
        success:function(response){
            if(response == 1)
            {
                $('#name_error').html(value +' Donor Fit Name already Exist').css('color','red');
                $('#donor_fit').val(vals);
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
	<?php echo anchor('master/master_settings/donor_fit_list','Back','class="button"'); ?>
</div>
<?php
$url = 'master/master_settings/donor_fit_add';
if(isset($donor[0]['id']))
    {
    	$url = 'master/master_settings/DonorFit_edit/'.$donor[0]['id'];
    }
 ?>

<form name="donorfitForm" enctype="multipart/form-data" action="<?=site_url($url);?>" method="post" id="donorfitForm" class="uniform" >
<dl class="inline">
<?php if($this->session->userdata('user_type') == 'superadmin'){?>
            <dt><label for="program">Partner</label></dt>
            <dd><?php $branch_name = (isset($donor[0]['partner_id']))?$donor[0]['partner_id']:"";//$branch_name = isset($_REQUEST["branch"])?$_REQUEST["branch"]:$setup['partner_id'];  <?php echo ($branch_name==$partner['id'])?('selected'):(''); ?>
              <select name="branch" id="branch">
                  <option value="">Select Partner</option>
                  <?php 
                  foreach ($branch as $partner) { ?>
                     <option value="<?php echo $partner['id'];?>"<?php echo ($branch_name==$partner['id'])?('selected'):(''); ?>><?php echo $partner['branch_name'];?> </option>
                  <?php } ?>
              </select>
            </dd>
<?php } ?> 
            <dt><label for="donor">Donor Fit Name</label></dt>
            <dd>
             <?php 

             $donor_fit = (isset($donor[0]['name']))?$donor[0]['name']:"";
				?>
				<input type="text" name="donor_fit" id="donor_fit" value="<?php echo $donor_fit;?>" class="required" onblur="donor_exist_check(this.value)">
				<span id="name_error"></span>
				<?php
				echo '<font class="req_field">*</font>'.form_error('master_name', '<div class="errorMsg">', '</div>');
		     ?>
            </dd>
 </dl>          
 <div class="buttons">
    <?php
    $text = 'Add';
    if(isset($donor[0]['id']))
    {
    	$text = 'Update';
    	?>
    	<input type="hidden" name="id", id="id" value="<?php echo $donor[0]['id'];?>">
    	<?php
    }
    ?>
    <button type="submit" class="button" value="Save" name="txtSubmit"><?php echo $text;?></button>
    <button type="reset" class="button white">Reset</button>
</div>

</form>
<!-- end id-form  -->
