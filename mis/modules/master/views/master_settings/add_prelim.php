<script type="text/javascript">
function prelim_exist_check()
{ 
  var value = $('#prelim').val();
  var vals = '';
  var urls = '<?php echo site_url("master/master_settings/prelim_exist_check/");?>/'+value;
  <?php if(isset($reasons[0]['id'])){?>
  var vals = '<?php echo $reasons[0]["name"];?>';
  var urls = '<?php echo site_url("master/master_settings/prelim_exist_check/");?>/'+value+'/<?php echo $reasons[0]["id"];?>';	
  <?php } ?>
  var result;
  $.ajax({
        url: urls,
        async:false,
        success:function(response){
          if(response > 0)
          {
            $('#name_error').html(value +' Preliminary reason already Exist').css('color','red');
            $('#prelim').val(vals);
            result = 'false';
          }
          else
          {
            $('#name_error').html('');
            result = 'true';
          }
        }


     });
  if(result == 'false')
   return false;
  else
    return true;
}
</script>

<h1 style="margin: 15px 0 10px;"><?=$cpagetitle?></h1>
<div style=" float:right; text-align:right;width:100%;">
	<?php echo anchor('master/master_settings/preliminary_reason','Back','class="button"'); ?>
</div>
<?php
$url = 'master/master_settings/preliminary_reason_add';
if(isset($reasons[0]['id']))
    {
    	$url = 'master/master_settings/Prelim_edit/'.$reasons[0]['id'];
    }
 ?>
<form name="prelimForm" id="prelimForm" enctype="multipart/form-data" onsubmit="return prelim_exist_check();" action="<?=site_url($url);?>" method="post" id="prelimForm" class="uniform" >
<dl class="inline">



        <?php if($this->session->userdata('isSuperAdmin') == 'Yes'){ ?>
        <dt><label for="prelim">Partner</label></dt>
        <dd>
        <select name="branch" id="branch">
            <option value="">Select Partner</option>
            <?php 
            foreach ($branch as $partner) { ?>
                <option value="<?php echo $partner['id'];?>"<?php echo ($branch_name==$partner['id'])?('selected'):(''); ?>><?php echo $partner['branch_name'];?> </option>
            <?php } ?>
        </select>
        </dd>
        <?php }else{ ?>
          <input type="hidden" name="branch_user" value="branch_user" />
        <?php } ?>


            
        <dt><label for="prelim">Preliminary Reason</label></dt>
        <dd>
        <?php 

        $prelim_reason = (isset($reasons[0]['name']))?$reasons[0]['name']:"";
				?>
				<input type="text" name="prelim" id="prelim" value="<?php echo $prelim_reason;?>" class="required" >
				<span id="name_error"></span>
				<?php
				echo '<font class="req_field">*</font>'.form_error('master_name', '<div class="errorMsg">', '</div>');
		     ?>
            </dd>

        
 </dl>          
 <div class="buttons">
    <?php
    $text = 'Add';
    if(isset($reasons[0]['id']))
    {
    	$text = 'Update';
    	?>
    	<input type="hidden" name="id", id="id" value="<?php echo $reasons[0]['id'];?>">
    	<?php
    }
    ?>
    <input type="submit" class="button" name="txtSubmit" value ="<?php echo $text;?>" />
    <button type="reset" class="button white">Reset</button>
</div>

</form>
<!-- end id-form  -->