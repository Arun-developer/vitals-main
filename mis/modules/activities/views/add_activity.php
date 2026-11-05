<script type="text/javascript">
		 $(document).ready( function() {
				var dates = $( "#fromdate, #todate" ).datepicker({
					defaultDate: "+1w",
					changeMonth: true,
					changeMonth: true,
					changeYear: true,
					numberOfMonths: 1,
					onSelect: function( selectedDate ) {
						var option = this.id == "fromdate" ? "minDate" : "maxDate",
							instance = $( this ).data( "datepicker" ),
							date = $.datepicker.parseDate(
								instance.settings.dateFormat ||
								$.datepicker._defaults.dateFormat,
								selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
					}
				});

				$('#add_activity').validate({
					submitHandler: function(form) {
					form.submit();
					}
					});
		  });
fCount = 0;
function addFileField()
{
	fCount = fCount + 1;
	var id = 'file'+fCount;
	content = '<div id="'+id+'"><input type="file" class="upload" name="document[]"  />&nbsp;&nbsp;<a href="javascript:void(0);" style="color:red;" onclick="removeDiv(\''+id+'\');" ><strong>( Remove )</strong></a><br/><br/></div>';

	$(content).appendTo('#multiFile');
}
function removeDiv(divId)
{
$('#'+divId).remove();
}
</script>
<!-- start id-form -->

<h2><?php echo $innovationInfo['name_of_enterprise'] ?> - Add Activity </h2>
<?php
$pstage = $scoutingStage;
if (isset($activityDetails)) {

    $action = "activities/edit_activity/" . $this->uri->segment('3') . '/' . $this->uri->segment('4');
    foreach ($activityDetails as $row):
        $activity_id = $row['activity'];
        $id = $row['id'];
        $innovation = $row['innovation'];
        $date = $row['end_date'];
        $purpose_activity = $row['activity_title'];
        $activity_desc = $row['activity_description'];
    endforeach;
} else {
    $action = "activities/add_activity/" . $innovationInfo['id'] . '/' . $curService . '/' . $curStage;
}
?>
<form name="add_activity" enctype="multipart/form-data" action="<?=site_url($action)?>" method="post" id="add_activity" >
 <input type="hidden" name="program_stage" class="input-text" value="<?=$curStage?>" />
 <input type="hidden" name="activity" class="input-text" value="<?=$activity_id?>" />
 <input type="hidden" name="id" class="input-text" value="<?=$id?>" />
 <input type="hidden" name="innovation"  class="input-text" value="<?=$innovation?>" />

<dl class="inline">

        <dt><label for="end_date">Date<font color="red">*</font></label></dt>
        <dd><input type="text" name="end_date" class="input-text required"  id="todate" size="40" value="<?=isset($date) ? $date : '';?>"/></dd>

        <dt><label for="end_date">Purpose of the Activity<font color="red">*</font></label></dt>
        <dd><input type="text" name="activity_title" class="input-text required" size="40" value="<?=isset($purpose_activity) ? $purpose_activity : '';?>" /></dd>

		<dt><label for="activity_description">Activity Description</label></dt>
        <dd><textarea name="activity_description" id="editor" class="input-text" rows="5" cols="40"><?=isset($activity_desc) ? $activity_desc : '';?></textarea></dd>

		<dt><label for="end_date">Doucment Description</label></dt>
        <dd><input type="text" name="tags" class="input-text" size="40" /></dd>

</dl>
<dl class="inline">
<dt><label for="">Document</label> </dt>
<dd id="multiFile">
	<div><input type="file" name="document[]" class="" />
	&nbsp;&nbsp;
	<a href="javascript:void(0);" onclick="addFileField();" style="color:green" ><strong>( Add )</strong></a><br /><br /></div>
</dd>
	<dd><input type="submit" value="Add" name="txtSubmit" class="button" />
	<input type="reset" value="Reset" name="txtReset" class="button white" /></dd>
</dl>


</form>
<!-- end id-form  -->