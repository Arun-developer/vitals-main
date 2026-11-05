<script type="text/javascript">
function check_existingType(value,submitval) {   
  var vals = '';
  var id = '';
  var urls = '<?php echo site_url("master/master_settings/check_existingMeeting"); ?>';
  <?php if(isset($type_list[0]['id'])){?>
  var vals = '<?php echo $type_list[0]["name"];?>';
  id = '<?php echo $type_list[0]["id"];?>';
  <?php } ?>
  $.ajax({
    type: 'POST',
    url: urls,
    data:{name:value,id:id},
    success:function(response){
      if(response > 0) {
        $('#name_error').html('Meeting type already exist').css('color','red');
        $('#doc_type').val(vals);
        setTimeout(function(){
          $('#name_error').html('');
        }, 5000);
      } else {
        $('#formsubmit').val("1");
        if(submitval == 1){
          $('#documenttypeForm').submit();
        }
        $('#name_error').html('');
      }
    }
  });
}

function submitType() {
  var value = $('#doc_type').val();
  check_existingType(value,1);
}

$(document).keypress(function(e) {
    if(e.which == 13) {
        var value = $('#doc_type').val();
        check_existingType(value,1);
        return false;
    }    
});
</script>

<h1><?= $cpagetitle; ?></h1>
<div style=" float:right; text-align:right;width:100%;">
	<?php echo anchor('master/master_settings/meeting_type','Back','class="button"'); ?>
</div>
<?php
$url = 'master/master_settings/meeting_type_add';
if(isset($type_list[0]['id'])) {
    	$url = 'master/master_settings/meeting_type_edit/'.$type_list[0]['id'];
    }
 ?>

<form name="documenttypeForm" action="<?=site_url($url);?>" method="post" id="documenttypeForm" autocomplete="off" class="uniform" >
<input type="hidden" name="formsubmit" id="formsubmit" value="0"/>
<dl class="inline"> 
  <dt><label for="donor">Meeting Type Name<font class="req_field">*</font></label></dt>
  <dd>
     <?php 
        $type_name = (isset($type_list[0]['name']))?$type_list[0]['name']:"";
		 ?>
		<input type="text" name="doc_type" id="doc_type" value="<?php echo $type_name; ?>" class="required addInput" onblur="check_existingType(this.value,2)">
		<?php
		  echo form_error('master_name', '<div class="errorMsg">', '</div>');
    ?>
     <span id="name_error"></span>
  </dd>
</dl>          
<div class="buttons">
    <?php
    $text = 'Add';
    if(isset($type_list[0]['id']))
    {
    	$text = 'Update';
    	?>
    	<input type="hidden" name="id", id="id" value="<?php echo $type_list[0]['id'];?>">
    	<?php
    }
    ?>
    <button type="button" onclick="return submitType();" class="button" value="Save" name="txtSubmit"><?php echo $text;?></button>
    <button type="reset" class="button white">Reset</button>
</div>

</form>
<!-- end id-form  -->
<style type="text/css">
  .addInput{
    width: 60%;
  }
  .error{
    display: block;
  }
  #name_error{
    display: block;
  }
  nav#topmenu
  {
    min-width: 947px !important;
  }
</style>