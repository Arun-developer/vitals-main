 	<script type="application/javascript">
	$(document).ready(function(){
		
		gradeList(this.value);
		//activity List
		$("#programStage").change(function(){
			gradeList(this.value);
		});
		if($("#programStage").val()){
			gradeList($("#programStage").val());			
		}
		if($("#PSTAGE").val())
		{
			gradeList($("#PSTAGE").val());
		}
		function gradeList(program_stage)
		{
		    
			if(program_stage != '')
				$('#addGradeRow').show();
			else
				$('#addGradeRow').hide();
			var form_data = {
					program_stage: program_stage,
					ajax: '4'		
				};
			$.ajax({
					url: '<?=site_url('master/grade/list_grade');?>',
					type: 'POST',
					data: form_data,
					success: function(msg) {
						$('#gradeTable').html(msg);
					}
			});
			ordering('sNo');
		}
		
		$('.removeGradeList').live('click',function(){
			var gradeId = $(this).attr('id');
			var delRow = $(this).parents('tr');										
			jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
				if(r)
				{
					var form_data = {
						gradeId: gradeId,
						ajax: '4'		
					};
					$.ajax({
						url: '<?=site_url('master/grade/delete_grade');?>',
						type: 'POST',
						data: form_data,
						success: function(msg) {
							if(msg == 'success')
							{
								delRow.hide();
								$('.msg').html('Grade Deleted Successfully').addClass('done').show();
							}
							else
							{
								$('.msg').html(msg).addClass('error').show();
							}
							$('.msg').fadeOut(50000);
						}
					});
				}
				
			});
		});
	});
	</script>
<h1><?=$cpagetitle?></h1>
<form id="gradeList" action="<?=site_url('master/grade/view_list')?>" method="post" name="gradeList">
<dl class="inline">

		<dt><label for="Program type">Program Type:</label></dt>
		<dd>
	    <?php if(isset($programtypeid)) {$progrmtypeid=$programtypeid;} else {$programtypeid="";}?>
		<?php $program_type = isset($_REQUEST['program_type'])?$_REQUEST['program_type']:$programtypeid;?>
        <select name="program_type" id="programType" >
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
		if(isset($programserviceid)){$programserviceid=$programserviceid ;}else {$programserviceid="";}
		$program_service_offering = isset($_REQUEST['program_service_offering'])?$_REQUEST['program_service_offering']:$programserviceid;?>
        <input type="hidden"  name="PSO" id="PSO" value="<?=$program_service_offering?>" />
        <select name="program_service_offering" id="programServiceOffering">
        <option value="">-Select-</option>
        </select>
		</dd>
	


		<dt><label for="Program stage">Program Stage:</label></dt>
		<dd>
		
		<?php 
		if(isset($programstageid)){$programstageid=$programstageid ;}else {$programstageid="";}
		$program_stage = isset($_REQUEST['program_stage'])?$_REQUEST['program_stage']:$programstageid;?>
        <input type="hidden"  name="PSTAGE" id="PSTAGE" value="<?=$program_stage?>" />
        <select name="program_stage" id="programStage">
        <option value="">-Select-</option>
        </select>
		</dd>
		

	
</dl>
<br />
<br/>
<div class="clear"></div>
<div style=" float:right; text-align:right;width:100%;">
	<?php echo anchor('master/grade/form','Add Grade','class="button"'); ?>
</div>
<br />
<br/>
<div id="user-grid" class="grid-view">
	<table width="100%" class="gtable sortable">
	<thead>
		<tr>
        	 <th>S.No.</th>
            <th>Criteria</th>
			<th>Sub-Criteria</th>
            <th>Weightage </th>
             <th>Scale</th>
             <th>Scaling Factor</th>
             <th>Action</th>
		</tr>
	</thead>
	<tbody id="gradeTable">
		
	</tbody>
	</table>
	<!-- Paging style -->
	</div>
   
   
	</form>  
   
    	
    
    
