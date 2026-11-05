<h1><?=$cpagetitle?></h1>
<!-- start id-form -->
<?php $stage=$stagefficient[0]; ?>

<form name="reportForm" enctype="multipart/form-data" action="<?=site_url('master/stageefficiency/setup');?>" method="post" id="reportForm" class="uniform" >
<dl class="inline">
     <dt><label for="message type"> New :	</label></dt>
	 <dd>
        <?php $new = isset($_REQUEST["new"])?$_REQUEST["new"]:$stage['new'];?>
		<input type="text" value="<?php echo $new; ?>" size="40" name="new" class="number" />&nbsp;&nbsp;<b>Days</b>
	</dd>
    
     <dt><label for="message type"> Entry :	</label></dt>
	 <dd>
        <?php $entry = isset($_REQUEST["entry"])?$_REQUEST["entry"]:$stage['entry'];?>
	    <input type="text" value="<?php echo $entry; ?>" size="40" name="entry" class="number" />&nbsp;&nbsp;<b>Days</b>
	</dd>
    
     <dt><label for="message type">Lead :	</label></dt>
	 <dd>
        <?php $lead = isset($_REQUEST["lead"])?$_REQUEST["lead"]:$stage['lead'];?>
	    <input type="text" value="<?php echo $lead; ?>" size="40" name="lead" class="number" />&nbsp;&nbsp;<b>Days</b>
	 </dd>
     
     <dt><label for="message type">Shortlisted :	</label></dt>
	 <dd>
        <?php $shortlisted = isset($_REQUEST["shortlisted"])?$_REQUEST["shortlisted"]:$stage['shortlisted'];?>
	    <input type="text" value="<?php echo $shortlisted; ?>" size="40" name="shortlisted" class="number" />&nbsp;&nbsp;<b>Days</b>
	</dd>
    
     <dt><label for="message type">Due-Diligence :	</label></dt>
	 <dd>
        <?php $due_diligence = isset($_REQUEST["due_diligence"])?$_REQUEST["due_diligence"]:$stage['due_diligence'];?>
	   <input type="text" value="<?php echo $due_diligence; ?>" size="40" name="due_diligence" class="number" />&nbsp;&nbsp;<b>Days</b>
	</dd>
    
    <dt><label for="message type">Incubation :	</label></dt>
	<dd>
       <?php $incubation = isset($_REQUEST["incubation"])?$_REQUEST["incubation"]:$stage['incubation'];?>
	  <input type="text" value="<?php echo $incubation; ?>" size="40" name="incubation" class="number" />&nbsp;&nbsp;<b>Days</b>
	</dd>
</dl>
<div class="buttons">
		<input type="submit" value="Save" name="txtSubmit" class="button" />
        <input type="reset" value="Cancel" name="txtReset" class="button white" />
</div>

</form>

<!-- end id-form  -->
