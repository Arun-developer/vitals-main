<form name="reportForm" enctype="multipart/form-data" action="<?=site_url('incubationprogress/assign')?>" method="post" id="reportForm"  >
<input type="hidden" value="<?=$innovation?>" name="id" /> 
<input type="hidden" value="<?=$type?>" name="type" /> 
<dl class="inline">
	 <dt><label class="fontStyle"> Year</label></dt>
	 <dd>
		<input type="text" name="year" id="year" value="<?php echo $year;?>"/>
	 </dd>
	 <dt><label for="label">Label<font class="req_field">*</font></label></dt>
	<dd>
	<select name="label" id="label">
	<option value="<?php echo $label;?>"><?php echo $lbl['label'];?></option>
	</select>
	</dd>	
	 <dt><label for="Assigned To">Assign To</label></dt>
	 <dd>
	  <select id="assigned" class="multiselect" multiple="multiple" name="assigned" >
             <option value="">-Select-</option>
             <?php 
             foreach($fellowList as $row1) {
                 ?>
                <option value="<?=$row1['emp_number']?>" >
                <?=$row1['emp_firstname']?></option>
                <?php } ?>
             </select>
	 </dd>
</dl> 	
<div id="fieldTable"></div>
<div class="buttons">
		<input type="submit" value="Submit" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
</div>
</form>

<!-- end id-form  -->
<div  style="display:none">
<dl class="inline cloneValue">
            <dt>&nbsp;</dt>
            <dd><input type="text" name="value[]" class="input-text" size="30" value="" />&nbsp;&nbsp;
            (<a href="javascript:void(0);" class="removeValueRow" style="color:red; text-decoration:none; font-weight:bold" >Remove</a>)</dd>		
</dl>
    </div>