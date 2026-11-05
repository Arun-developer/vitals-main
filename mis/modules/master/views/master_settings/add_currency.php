<script type="text/javascript">
function check_existingType(value,submitval) {
  var vals = '';
  var id = '';
  var urls = '<?php echo site_url("master/master_settings/check_existingCurrency"); ?>';
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
            	$('#name_error').html('Currency already exist').css('color','red');
              $('#name').val(vals);
              setTimeout(function(){
                $('#name_error').html('');
              }, 5000);
            } else {
              $('#formsubmit').val("1");
              if(submitval == 1){
                $('#currencyForm').submit();
              }
            	$('#name_error').html('');
            }
        }
    });
}

function submitType() {
  var value = $('#name').val();
  check_existingType(value,1);
}

$(document).keypress(function(e) {
    if(e.which == 13) {
        var value = $('#name').val();
        check_existingType(value,1);
        return false;
    }    
});
</script>

<h1><?= $cpagetitle; ?></h1>
<div style=" float:right; text-align:right;width:100%;">
	<?php echo anchor('master/master_settings/partner_currency','Back','class="button"'); ?>
</div>
<?php
$url = 'master/master_settings/currency_add';
if(isset($type_list[0]['id'])) {
    	$url = 'master/master_settings/currency_edit/'.$type_list[0]['id'];
    }
 ?>

<form name="currencyForm" action="<?=site_url($url);?>" method="post" id="currencyForm" autocomplete="off" class="uniform" >
<input type="hidden" name="formsubmit" id="formsubmit" value="0"/>
<dl class="inline"> 
  <dt><label for="name">Currency Name<font class="req_field">*</font></label></dt>
  <dd>
     <?php 
        $cur_name = (isset($type_list[0]['name']))?$type_list[0]['name']:"";
		 ?>
		<input type="text" name="name" id="name" value="<?php echo $cur_name; ?>" class="required addInput" onblur="check_existingType(this.value,2)">
		<?php
		  echo form_error('master_name', '<div class="errorMsg">', '</div>');
    ?>
     <span id="name_error"></span>
  </dd>

  <dt><label for="currency_code">Currency Code<font class="req_field">*</font></label></dt>
  <dd>
     <?php 
        $cur_code = (isset($type_list[0]['currency_code']))?$type_list[0]['currency_code']:"";
		 ?>
		<input type="text" style="text-transform:uppercase" name="currency_code" id="currency_code" value="<?php echo $cur_code; ?>" class="required addInput" onblur="check_existingType(this.value,2)">
		<?php
		  echo form_error('master_name', '<div class="errorMsg">', '</div>');
    ?>
     <span id="name_error"></span>
  </dd>

  <dt><label for="currency_symbol">Currency Symbol<font class="req_field"></font></label></dt>
  <dd>
     <?php 
        $cur_symbol = (isset($type_list[0]['currency_symbol']))?$type_list[0]['currency_symbol']:"";
		 ?>
		<input type="text" name="currency_symbol" id="currency_symbol" value="<?php echo $cur_symbol; ?>" class="addInput" onblur="check_existingType(this.value,2)">
		
  </dd>

  <dt><label for="prefix">Prefix Amount By<font class="req_field"></font></label></dt>
  <dd>
     <?php 
        $prefix = (isset($type_list[0]['prefix']))?$type_list[0]['prefix']:"";
		 ?>
		<select name="prefix" id="prefix" onblur="check_existingType(this.value,2)">
      <option value="Code" <?php if($prefix == 'Code') { echo 'selected'; } ?> >Currency Code</option>
      <option value="Symbol" <?php if($prefix == 'Symbol') { echo 'selected'; } ?> >Currency Symbol</option>
    </select>
    <span id="symbol_error" style="color:red;display:none;">You haven't entered currency symbol</span>
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
    <button type="button" onclick="return submitType();" class="button" value="Save" id="btn_save" name="txtSubmit"><?php echo $text;?></button>
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


<script>
  $('form[name=currencyForm]').submit(function(event){
    var symbol = $('#currency_symbol').val();
    var prefix = $('#prefix').val();
    if(symbol == '' && prefix == 'Symbol'){
      $('#symbol_error').show();
      event.preventDefault();
    }else{
      $('#symbol_error').hide();
    }
  });
  
  
</script>