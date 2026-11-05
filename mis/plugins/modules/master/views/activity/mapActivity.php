
 <script type="text/javascript">
	$(document).ready(function(){
		//activity List
		$("#programStage").change(function(){
			var innovation = $("#innovation").val();
			activityListMap(innovation,this.value);
		});
		$("#innovation").change(function(){
			var program_stage = $("#programStage").val();
			activityListMap(this.value,program_stage);
		});
		if($("#innovation").val())
		{
			var innovation = $("#innovation").val();
			var program_stage = $("#PSTAGE").val();
			activityListMap(innovation,program_stage);
		}
		if($("#PSTAGE").val())
		{
			var innovation = $("#innovation").val();
			var program_stage = $("#PSTAGE").val();
			activityListMap(innovation,program_stage);
		}
		function activityListMap(innovation,program_stage)
		{
			var form_data = {
					program_stage: program_stage,
					innovation: innovation,
					ajax: '4'		
				};
			$.ajax({
					url: '<?=site_url('master/activity/list_activity_map');?>',
					type: 'POST',
					data: form_data,
					success: function(msg) {
						$('#activityTable').html(msg);
					}
			});
		}
	
	});
 </script>
<h1><?=$cpagetitle?></h1>
<form id="activityList" action="<?=site_url('master/activity/mapping')?>" method="post" name="activityList">
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
		<dt><label for="Program service offering">Program Service Offering:</label></dt>
		<dd>
		<?php 
		$program_service_offering = isset($_REQUEST['program_service_offering'])?$_REQUEST['program_service_offering']:'';?>
        <input type="hidden"  name="PSO" id="PSO" value="<?=$program_service_offering?>" />
        <select name="program_service_offering" id="programServiceOffering" class="required">
        <option value="">-Select-</option>
        </select>
		</dd>
		

		<dt><label for="Program stage">Program Stage:</label></dt>
		<dd>
		<?php $program_stage = isset($_REQUEST['program_stage'])?$_REQUEST['program_stage']:'';?>
         <input type="hidden"  name="PSTAGE" id="PSTAGE" value="<?=$program_stage?>" />
        <select name="program_stage" id="programStage" class="required">
        <option value="">-Select-</option>
        
        </select>
		</dd>
		

		<dt><label for="Innovation">Innovation:</label></dt>
		<dd>
		<?php $innovation = isset($_REQUEST['innovation'])?$_REQUEST['innovation']:'';?>
        <select name="innovation" id="innovation" class="required">
        <option value="">-Select-</option>
         <?php
		foreach($innovationList as $inL):
			?>
            <option value="<?=$inL['id']?>" <?=($inL['id']==$innovation)?'selected':'';?>><?=$inL['name']?></option>
			<?php 
		endforeach;
		?>
        </select>
		</dd>
		
</dl>
<br />

<div id="user-grid" class="grid-view">
<div class="clear"></div>
	<table width="100%" class="gtable sortable">
	<thead>
		<tr>
			<th>S.No.</th>
			<th>Activity Type</th>
			<th>Activity Description</th>
			<th>Option</th>
		</tr>
		
	</thead>
	<tbody id="activityTable">
		
	</tbody>
	</table>
	<!-- Paging style -->
	</div>
    <table class="nostyle" width="100%">
 	<tr>
		<td width="30%" align="right" valign="top">&nbsp;</td>
		<td valign="top">
			<input type="submit" value="Save" name="txtSubmit" class="button" />
			<input type="reset" value="Reset" name="txtReset" class="button white" />
		</td>
	</tr>
	</table>
	</form>  
   
    	
    
    
