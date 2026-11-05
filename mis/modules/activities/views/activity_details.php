<?php
foreach ($activityDetails as $row):
?>
<h1><?=$row['name_of_enterprise']?> - Activity Details</h1>
<?php
//Discussion 27
//Meeting 28
//Grading 29
//Query 30
$createDiscussion = false;
$viewDiscussion = false;
$viewMeeting = false;
$viewGrading = false;
$viewQuery = false;
if ($row['activity_type'] == '27') {
    $createDiscussion = true;
    $viewDiscussion = true;
}
if ($row['activity_type'] == '28') {
    $viewMeeting = true;
}
if ($row['activity_type'] == '29') {
    $viewGrading = true;
}
if ($row['activity_type'] == '30') {
    $viewQuery = true;
}
?>
<ul class="option-tab">
<?php if ($viewDiscussion) {?>
<li><a href="<?=site_url('discussion/view/' . $row['id']);?>" class="button">View Discussion</a>
</li>
<?php }?>
<?php if ($viewMeeting) {?>
<li><a href="<?=site_url('meeting/view/' . $row['id']);?>" class="button">View Meeting</a>
</li>
<?php }?>
<?php if ($viewGrading) {?>
<li><a href="<?=site_url('grading/view/' . $row['id']);?>" class="button"> View Grading&Feedback</a>
</li>
<?php }?>
<?php if ($viewQuery) {?>
<li><a href="<?=site_url('query/view_list/' . $row['id']);?>" class="button">View Query</a>
</li>
<?php }?>
<?php if ($editOption) {?>
<li><a href="<?=site_url('activities/edit_activity/' . $row['innovation'] . '/' . $row['id']);?>" class="fancybox button" >Edit</a></li>
<?php }?>
<li><a href="<?=site_url('activities/view_list/' . $row['innovation']);?>" class="button white" >Back</a></li>
</ul><br />
<br />
    <table class="gtable sortable">
	<thead>
		<tr>
			<th colspan="2"><?=$row['name_of_enterprise']?></th>
			</tr>
	</thead>
	<tbody>
        <tr class="odd">
			<td>Activity Description</td>
			<td><?=$row['activity_description']?></td>
		</tr>
        <tr class="odd">
			<td>Date</td>
			<td><?=mysql2date($row['end_date'])?></td>
		</tr>

        <tr class="odd">
			<td>Created Date</td>
			<td><?=mysql2date($row['created_date'])?></td>
		</tr>
        <tr class="even">
			<td>Created By</td>
			<td><?=$row['created_emp']?></td>
		</tr>
        <tr class="odd">
			<td>Last Modified </td>
			<td><?=mysql2date($row['modified_date'])?></td>
		</tr>
        <tr class="even">
			<td>Modified By</td>
			<td><?=$row['modified_emp']?></td>
		</tr>
    	<tr class="odd">
			<td>Documents</td>
			<td>
             <a href="<?php echo site_url("master/documents/view_list/" . $row['id']) ?>" class="button fancyboxIframe" target="_blank" >view Documents</a>
            </td>
		</tr><br/>


	</tbody>
	</table>
    <?php
endforeach;
?>
	<br/><br/>

        <div>
            <label><b>Comments:</b></label>
               <?php foreach ($activityDetails as $row): ?>
            	<ul class="comments">
      				<li>
                        <div class="comment-body clearfix">
                        <img class="comment-avatar" src="<?=base_url()?>source/template/images/icons/dummy.gif" />
						<div><?=$row['remarks']?></div>
                        <div class="links">
                        	<span class="date"><strong>Added By :</strong><?=$row['created_emp']?></span>
							<span class="date"><strong>Added Date :</strong><?=mysql2date($row['created_date'])?></span>
                         </div>
                         <div class="links">
							 <a href="<?php echo site_url("activities/comments/" . $row['id']) ?>" class="fancyboxIframe" target="_blank" >Post Comments</a>
                        </div>
						</div>
                    </li>
                </ul>
               <?php endforeach;?>

        </div>