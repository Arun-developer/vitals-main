<h1><?=$cpagetitle?> - <?=$activityDetails['0']['name_of_enterprise']?></h1>
<?php
if(count($gradingDetails))
{
	foreach($gradingDetails as $row):
		$grading_id = $row['id'];
		$score = $row['score'];
		$feedback = $row['feed_back'];
		$result = $row['result'];
	endforeach;
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
		$('.viewScaleFact').click(function(){
			$('.scaleFact').hide();						   
			$(this).parents('td').find('.scaleFact').show();								   
		});
		$('.closeScaleFact').click(function(){
			$(this).parents('table').find('.scaleFact').hide();								   
		});
		
});
</script>
<h2><?=($innovation['isAssociate'])?'Recommendation':'Feedback'; ?></h2>
<p><strong><?=($innovation['isAssociate'])?'Recommendation':'Feedback'; ?></strong>: <?=$feedback?>&nbsp;&nbsp;&nbsp;<strong>Result:</strong><?=$result?></p>
<h2>Grades</h2>
<table class="gtable sortable">
<thead>
<tr>
<th width="12%">Criteria</th>
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
	$rowType='even';
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
                <?=$grade_result?>
      </td>
      		
     		<td valign="middle" align="center" id="<?=$row['id']."_wtg"?>" class="waitageWtg"><?=$row['waitage']?></td>
            <td valign="middle" align="center" id="<?=$row['id']."_avg"?>" class="avgWtg"><?=$grade_result*$row['waitage']?></td>
            <td valign="middle" align="center" id="<?=$row['id']."_max"?>" class="maxWtg"><?php echo $row['scale']*$row['waitage']; ?></td>
            <td valign="middle" align="center" id="<?=$row['id']."_score"?>" class="scoreWtg" ><?=round(($grade_result*$row['waitage'])/($row['scale']*$row['waitage']),2)?></td>
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
            <td align="center" valign="middle" id="totalScore"><?=$score?></td>
            <td align="left" valign="middle"><input type="hidden" name="totalScore" value="<?=$score?>" class="input-text" /></td>
			</tr>
	</tbody>
	</table>


