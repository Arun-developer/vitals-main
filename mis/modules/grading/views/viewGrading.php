<?php
$addOption = true;
	$editOption = false;
if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')))
{
	$editOption = true;
}
?>
<ul class="option-tab">
</ul>
<h1><?=$cpagetitle?> - <?=$activityDetails['0']['name_of_enterprise']?></h1>

<?php
$form = true;
$nullLink = 'javascript:void(0);';
$form_name = 'grading';
if(count($gradingDetails))
{
	foreach($gradingDetails as $row):
		$grading_id = $row['id'];
		$score = $row['score'];
		$feedback = $row['feed_back'];
		$result = $row['result'];
	endforeach;
	$form = true;
}
else
{
	$grading_id = '';
	$score = '';
	$feedback = '';
	$result = '';
}

?>

<script type="text/javascript">
$(document).ready(function(){

		$('#gradingForm').validate({
			rules: {
				"grade[]": {
					'required' : true
				},
			        "stage":{
                 		      required: function(element) {
				      return $("#result").val() == 'Accepted'
				      }
				     },
			        "reason":{
			    	      required: function(element) {
				      return $("#result").val() == 'Rejected'
				      }
			         }
			}						   
		});
		
		
		$('.gradeRow').each(function(){
			 if($(this).val() != '')
			 {
				var gradeVal = $(this).val();
				var rowId = $(this).parents('tr').attr('id');
				calculate(gradeVal,rowId);
			 }
		});
		$('.gradeRow').change(function(){
				var gradeVal = $(this).val();
				var rowId = $(this).parents('tr').attr('id');
				calculate(gradeVal,rowId);
		});
		function calculate(gradeVal,rowId)
		{
				var row = rowId.split('_');
				var id = row['0'];
				var weightage = parseInt($("#"+id+"_wtg").html());
				var avgWtg = gradeVal*weightage;
				$("#"+id+"_avg").html(avgWtg);
				var maxWtg = parseInt($("#"+id+"_max").html());
				var score = avgWtg/maxWtg;
				$("#"+id+"_score").html(Math.round(score*100)/100);
				
				findSum('waitageWtg','totalWtg');
				findSum('avgWtg','totalAvg');
				findSum('maxWtg','totalMax');
				findSum('scoreWtg','totalScore');
				totalVal = parseFloat($("#totalScore").html());
				$("input[name=totalScore]").val(totalVal);
		}
		function findSum(className,totalId)
		{
				var total = 0;
				$('.'+className).each(function(){
					total += parseFloat($(this).html());
				});
				$('#'+totalId).html(Math.round(total*100)/100);
		}
		
		$('.viewScaleFact').click(function(){
			$('.scaleFact').hide();						   
			$(this).parents('td').find('.scaleFact').show();								   
		});
		$('.closeScaleFact').click(function(){
			$(this).parents('table').find('.scaleFact').hide();								   
		});
                $("#result").change(function(){
			if($("#result").val() == 'Accepted')
			{
				$("#stage").show();
				$("#reason").hide();
			}
			else
			{
				$("#stage").hide();
				$("#reason").show();
			}
		});
		
});
</script>
<?php if(count($gradingList)>0){ ?>
<h2>Grading Results</h2>
 <table class="gtable sortable">
	<thead>
    <tr>
        <th>Graded By </th>
        <th>Date </th>
        <th>Score</th>
        <th>Result </th>
        <th><?=($innovation['isAssociate'])?'Recommendation':'Feedback'; ?></th>
        <th>Modified on </th>
        <th>Modified By </th>
        <th>Spider Map </th>
        <th>Action</th>
    </tr>
	</thead>
	<tbody class="agendaTable">
   <?php
	$rowType='odd';
	foreach($gradingList as $row):
	$rowType = ($rowType=='odd')?'even':'odd';
	
	if($row['created_by'] == $this->session->userdata('emp_number') && $grading_id == '')
		$form = false;
	?>   
    <tr class="<?=$rowType?>">
			<td align="left" valign="middle">
				<?=$row['created_emp']?>
            </td>
            <td align="left" valign="middle">
				<?=mysql2date($row['created_date'])?>
            </td>
            <td align="left" valign="middle"><?=$row['score']?></td>
            <td align="left" valign="middle"><?=$row['result']?></td>
            <td align="left" valign="middle"><?=$row['feed_back']?></td>
            <td align="left" valign="middle"><?=mysql2date($row['modified_date'])?></td>
            <td align="left" valign="middle"><?=$row['modified_emp']?></td>
            <td align="left" valign="middle"><a href="<?=site_url('grading/spidermap/'.$activity.'/'.$row['id']);?>" class="fancyboxIframe" >Spider Map</a></td>
            <td align="left" valign="middle">
            <a href="<?=site_url('grading/view/'.$activity.'/'.$row['id'].'/view');?>" class="fancybox" >View</a>&nbsp;&nbsp;
                
            	<?php if($editOption){ ?>
                <a href="<?=site_url('grading/view/'.$activity.'/'.$row['id']);?>"  >Edit</a>
				<?php } ?>
            </td>
			</tr>
      <?php endforeach;
	  if(count($gradingList)=='0'){
		?>
         <tr class="odd"><td colspan="8" align="center">No Records Found!</td></tr>
        <?php  
	  }
	  ?>
      
	</tbody>
	</table><br />

<?php }
else
{
	$form = true;
}
if($form){
?>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>

<form id="gradingForm" action="<?=site_url('grading/view/'.$activity.'/'.$this->uri->segment('4'))?>" enctype="multipart/form-data" method="post" name="gradingForm">
<input type="hidden" name="grading_id" value="<?=$grading_id?>"   />
    
<ul class="option-tab">

</ul>

<h2>Grade</h2>
<table class="gtable sortable">
<thead>
<tr>
<th>Criteria</th>
<?php if($curStage != '5'){?>
<th>Sub - Criteria</th>
<?php } ?>
<th>Scaling Factor</th>
<th>Grade</th>
<th>Weightage</th>
<th>Weighted Average</th>
<th>Max</th>
<th>Score</th>

</tr>
	</thead>
	<tbody class="agendaTable">
   <?php
	$rowType='odd';
        
	foreach($gradesMasterList as $row):
	$rowType = ($rowType=='odd')?'even':'odd';
	$grade_result = '';
	$commentsRow ='';
	if(count($gradesList))
	{
		foreach($gradesList as $grd):
			if($grd['grading_master'] == $row['category'])
			{
				$grade_result = $grd['grade'];
				$commentsRow = $grd['description'];
			}
		endforeach;
	}
	?>   
    <tr class="<?=$rowType?>" id="<?=$row['id']?>_row">
			<td align="left" valign="middle">
			<input type="hidden" name="grede_id[]" value="<?=$row['id']?>" />
			<?=$row['criteria']?>
            </td>
           
            <?php if($curStage != '5'){?>
           <td align="left" valign="middle"><?=$row['criteria']?></td>
            <?php } ?>
           <td>
            <a href="javascript:void(0);" class="viewScaleFact" >View</a>
            <table class="scaleFact" style="display:none;position:absolute; background:#C5DBED; border:2px solid #666; width:500px;" >
            <tr>
                <td align="center" valign="top" colspan="2">Scaling Factors ( <a href="javascript:void(0);" class="closeScaleFact" style="color:red;" >Close</a>)</td>
			</tr>
			<?php 
			$scaling_factor = @unserialize($row['scaling_factor']);
			$scaling_factor = (is_array($scaling_factor))?$scaling_factor:array();
			foreach($scaling_factor as $key=>$value): ?>
             <tr>
                <td width="100"  align="right" valign="top">[<strong>Scale <?=$key+1?></strong>]</td>
                <td><?=$value?></td>
			</tr>
   			<?php endforeach;?>
            </table>
            </td>
            <td align="left" valign="middle">
            <select name="grade[]" class="gradeRow" disabled="disabled">
			<option value="0">-Select-</option>
            <?php 
            
            for($i=1; $i<=$row['scale']; $i++){ ?>
            <option value="<?=$i?>" <?=($grade_result == $i)?'selected':'';?>><?=$i?></option>
            <?php } ?>
	  </select></td>
      		
     		<td valign="middle" align="center" id="<?=$row['id']."_wtg"?>" class="waitageWtg"><?=$row['waitage']?></td>
            <td valign="middle" align="center" id="<?=$row['id']."_avg"?>" class="avgWtg">0</td>
            <td valign="middle" align="center" id="<?=$row['id']."_max"?>" class="maxWtg"><?php echo $row['scale']*$row['waitage']; ?></td>
            <td valign="middle" align="center" id="<?=$row['id']."_score"?>" class="scoreWtg" >0</td>
           
			</tr>
      <?php endforeach; ?>
       <tr class="<?=$rowType?>">
			<td align="left" valign="middle">Total
            </td>
            <td align="left" valign="middle">&nbsp;</td>
             <?php if($curStage != '5'){?>
             <td align="left" valign="middle">&nbsp;</td>
            <?php } ?>
           
            <td align="left" valign="middle" id="totalGrade">&nbsp;</td>
     		<td align="center" valign="middle" id="totalWtg">&nbsp;</td>
            <td align="center" valign="middle" id="totalAvg">&nbsp;</td>
            <td align="center" valign="middle" id="totalMax">&nbsp;</td>
            <td align="center" valign="middle" id="totalScore"><?=$score?></td>
            <td align="left" valign="middle"><input type="hidden" name="totalScore" value="<?=$score?>" class="input-text" /></td>
			</tr>
	</tbody>
	</table>
<h2><?=($innovation['isAssociate'])?'Recommendation':'Decision'; ?></h2>
<dl class="inline">
        <dt><label for="feedback"><?=($innovation['isAssociate'])?'Recommendation':'Decision'; ?>  <span class="req_field">*</span></label></dt>
        <dd><textarea name="feedback" rows="4" cols="40" class="input-text required"><?=$feedback?></textarea></dd>
		
        <dt><label for="feedback"> Result  <span class="req_field">*</span></label></dt>
		<dd>
         <select name="result"  class="required" id="result" <?php if($innovation['status'] == '3') {echo 'disabled="disabled"';}?>>
                <option value="">-Select-</option>
                <option value="Rejected" <?=($result=='Rejected')?'selected':'';?>>Rejected</option>
                <option value="Accepted" <?=($result=='Accepted')?'selected':'';?>>Accepted</option>
          </select>
         </dd>
         <div id="stage" style="display:none">
         <dt><label>Stage <span class="req_field">*</span></label></dt>
         <dd>
         <select name="stage"  class="required" id="stage">
          <option value="">-Select-</option>
          <option value="Pre-Product" >Pre-Product</option>
          <option value="Pre-Revenue">Pre-Revenue</option>
          <option value="Pre-Scale" >Pre-Scale</option>
          </select>
         </dd>
         </div>

         <div id="reason" style="display:none">
         <dt><label>Reason <span class="req_field">*</span></label></dt>
         <dd>
         <select name="reason" id="reason" <?php echo $disabled;?>>
          <option value="">Select Reason</option>
          <?php
          foreach($reasonsList as $list)
            {?>
          <option value="<?php echo $list['id'];?>" <?php echo (isset($feed_back[0]['reject_reason']) && $feed_back[0]['reject_reason'] != '' && $feed_back[0]['reject_reason'] == $list['id'])?'selected="selected"':'';?>><?php echo $list['master_name'];?></option>
          <?php } ?>
          </select>
          </dd>
          </div>
</dl>
<div class="buttons" style="<?php if($innovation['status'] == '3') {echo 'display:none';}?>">
        <?php if($addOption || ($editOption && $grading_id != '')){?>
       <input type="submit" name="txtSubmit" value="Save" class="button" />&nbsp;&nbsp;
        <input type="reset" name="txtReset" value="Reset" class="button white" />&nbsp;&nbsp;
        <?php }?>
 </div>

</form>
<?php }?>
