<h1>Grading Results - <?=$innovation['name_of_enterprise']?></h1>
 <table class="gtable sortable">
	<thead>
      <tr>
        <th>Program Stage </th>
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
	foreach($gradingList as $row):

	?>   
    <tr>
    		<td><?=$row['program_stage']?></td>
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
            <td align="left" valign="middle"><a href="<?=site_url('grading/spidermap/'.$row['activity'].'/'.$row['id']);?>" class="fancyboxIframe" >Spider Map</a></td>
            <td align="left" valign="middle">
            <a href="<?=site_url('grading/view/'.$row['activity'].'/'.$this->uri->segment('4').'/view');?>" class="fancybox" >View</a>
            </td>
			</tr>
      <?php endforeach;
	  if(php72_count($gradingList)=='0'){
		?>
         <tr class="odd"><td colspan="8" align="center">No Records Found!</td></tr>
        <?php  
	  }
	  ?>
      
	</tbody>
	</table><br />

