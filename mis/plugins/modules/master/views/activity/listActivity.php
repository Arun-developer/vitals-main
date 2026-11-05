 <script type="text/javascript">
	$(document).ready(function(){
		$('#addActivityRow').click(function(){
			var arow = $('.cloneActivity').clone().removeClass('cloneActivity').addClass('odd');
			$('#activityTable').append(arow);
			ordering('sNo');
		});
		$('.removeActivityRow').live('click',function(){
			$(this).parents('tr').remove();
			ordering('sNo');
		});
		function ordering(parent)
		{
			var d=1;
			$('.'+parent).each(function(){
				$(this).html(d);
				++d;
			});
		}
		//activity List
		$("#programStage").change(function(){
			activityList(this.value);
		});
		if($("#programStage").val()){
			activityList($("#programStage").val());			
		}
		
		if($("#PSTAGE").val())
		{
			activityList($("#PSTAGE").val());
		}
		function activityList(program_stage)
		{
			if(program_stage != '')
				$('#addActivityRow').show();
			else
				$('#addActivityRow').hide();
			var form_data = {
					program_stage: program_stage,
					ajax: '4'		
				};
			$.ajax({
					url: '<?=site_url('master/activity/list_activity');?>',
					type: 'POST',
					data: form_data,
					success: function(msg) {
						$('#activityTable').html(msg);
					}
			});
			ordering('sNo');
		}
		
		$('.editActivityRow').live('click',function(){
			var thisVal = $(this).parents('tr');
			thisVal.find('input').attr('disabled',false)
			
		});
		
		$('.removeActivityList').live('click',function(){
			var actId = $(this).attr('id');
			var delRow = $(this).parents('tr');										
			jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
				if(r)
				{
					var form_data = {
									actId: actId,
									ajax: '4'		
									};
					$.ajax({
						url: '<?=site_url('master/activity/delete_activity');?>',
						type: 'POST',
						data: form_data,
						success: function(msg) {
							
							if(msg == 'success') 
							{
								delRow.hide();
								$('.msg').html('Grade Deleted Successfully').addClass('success').show();
							}
							else
							{
								alert(msg);
								$('.msg').html(msg).addClass('error').show();
							}
						}
					});
				}
				
			});
		});
	});
	</script>
<h1><?=$cpagetitle?></h1>
<form id="activityList" action="<?=site_url('master/activity/view_list/search')?>" method="post" name="activityList" class="">
<dl class="inline">
 
 
	    <dt><label for="Program type">Program Type:</label></dt>
      	<dd>
			<?php $program_type = isset($_REQUEST['program_type'])?$_REQUEST['program_type']:'';?>
            <select name="program_type" id="programType" class="required" >
            <option value="">-Select-</option>
            <?php
            foreach($programType as $pt):
                ?>
                <option value="<?=$pt['id']?>" <?=($pt['id']==$program_type)?'selected':'';?>><?=$pt['master_name']?></option>
                <?php 
            endforeach;
            ?>
            </select>
	    </dd>
	
 
		<dt><label for="Program service">Program Service Offering:</label></dt>
		<dd>
			<?php 
            $program_service_offering = isset($_REQUEST['program_service_offering'])?$_REQUEST['program_service_offering']:'';?>
            <input type="hidden"  name="PSO" id="PSO" value="<?=$program_service_offering?>" />
            <select name="program_service_offering" id="programServiceOffering" class="required" >
            <option value="">-Select-</option>
            </select>
		</dd>
			
    
		<dt><label for="Program service">Program Stage:</label></dt>
		<dd>
		<?php $program_stage = isset($_REQUEST['program_stage'])?$_REQUEST['program_stage']:'';?>
         <input type="hidden"  name="PSTAGE" id="PSTAGE" value="<?=$program_stage?>" />
        <select name="program_stage" id="programStage" class="required">
        <option value="">-Select-</option>
        </select>
		</dd>
	
</dl>


<br /><br />

	<table  class="gtable sortable">
	<thead>
		<tr>
        	 <th>S.No.</th>
            <th>Activity Type</th>
			<th>Activity Description</th>
             <th>Action</th>
		</tr>
		
	</thead>
	<tbody id="activityTable">
		
	</tbody>
	</table>
	<!-- Paging style -->
    <a href="javascript:void(0);" id="addActivityRow" class="button" style="display:none" >Add Row</a>
    <table class="nostyle" width="100%" >
 	<tr>
		<td width="30%" align="right" valign="top">&nbsp;</td>
		<td valign="top">
			<input type="submit" value="Save" name="txtSubmit" class="button" />
			<input type="reset" value="Reset" name="txtReset" class="button white" />
		</td>
	</tr>
	</table>
	</form>  
    <table style="display:none">
    <tr class="cloneActivity">
    <td align="left" valign="middle" class="sNo">
    </td>
            <td align="left" valign="middle">
           
            <input type="hidden" name="id[]" value="" />
            <select name="activity_type[]" class="required" >
                <option value="">-Select-</option>
                <?php
                foreach($activityType as $pt):
                    ?>
                    <option value="<?=$pt['id']?>"><?=$pt['master_name']?></option><?php 
                endforeach;
                ?>
                </select>
            </td>
			<td align="left" valign="middle"><input type="text" name="activity_description[]" value="" size="80" class="input-text required" /></td>
           
             <td align="left" valign="middle"> <a href="javascript:void(0);" class="removeActivityRow " ><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Edit"></a>
			</td>
			</tr>
     </table>	
    
    
