<?php
		$formAction = site_url('fellow/add_fundutilization/'.$innovation.'/'.$installment);
		$id = '';
		$val = array();
		if(count($fundDetails))
		{
			echo $val = $fundDetails['0'];
			$formAction = site_url('fellow/add_fundutilization/'.$innovation.'/'.$installment.'/'.$val['id']);
			$id = $val['id'];
			$action = 'edit';
		}
		else
			$action = 'add';
		
		$date = isset($val["date"])?mysql2date($val["date"]):"";
		$amount = isset($val["amount"])?$val["amount"]:""; 
		$id = isset($val["id"])?$val["id"]:"";
		$document = isset($val["document"])?$val["document"]:"";
		$comments = isset($val["comments"])?$val["comments"]:"";
?>
<h1><?=$cpagetitle?></h1>
<script type="text/javascript">
		 $(document).ready( function() {
			$.metadata.setType("attr", "validate");
            $("#fundUtilizationForm").validate();
			$( ".datepicker" ).datepicker({
					changeMonth: true,
					changeYear: true,
			});
			$('.uniform input[type="checkbox"], .uniform input[type="radio"], .uniform input[type="file"]').uniform();
		  });

</script>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>

<!-- start id-form -->
<form name="fundUtilizationForm"  action="<?=$formAction?>" enctype="multipart/form-data" method="post" id="fundUtilizationForm" class="uniform" >
<input type="hidden" value="<?=$action?>" name="action" />
<input type="hidden" value="<?=$id?>" name="id" /> 
<dl class="inline">

 		<dt><label for="date">Date<font class="req_field">*</font></label></dt>
		<dd><input type="text" name="date" class="datepicker required" value="<?=$date?>" /></dd>
        
        <dt><label for="amount">Amount<font class="req_field">*</font></label></dt>
		<dd><input type="text" name="amount"  value="<?=$amount?>" class="required"/></dd>
        
        <dt><label for="comments">Comments<font class="req_field">*</font></label></dt>
    	<dd><textarea name="comments" class="input-text required" rows="5" cols="50"><?=$comments?></textarea></dd>
       
       <dt><label for="document">Document</label></dt>
	   <dd><input type="file" name="document"  class="" /><input type="hidden" name="pre_document"  value="<?=$document?>" />
       
       <?php if($document){ ?>
			<br/><a href="<?php echo base_url()."uploads/fund_utilization/".$document;?>"  target="_blank" >&nbsp;&nbsp;<img src="<?=base_url();?>source/template/images/icons/download.gif" height="20"  /> ( <?=$document?> )</a>
			<?php } ?>
       </dd>
</dl>  

<div class="buttons">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
<div>
</form>

