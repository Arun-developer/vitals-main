<?php
$nullLink = '';
?>
<table class="gtable sortable">
	<thead>
		<tr>
			<th><a href="<?=$nullLink?>" field="from" class="sortlink">From</a></th>
			<th><a href="<?=$nullLink?>" field="to" class="sortlink">To</a></th>
            <th><a href="<?=$nullLink?>" field="sent_date" class="sortlink">Sent Date</a></th>
			<th><a href="<?=$nullLink?>" field="mail_type" class="sortlink">Subject</a></th>
            <th><a href="<?=$nullLink?>" field="subject" class="sortlink">body</a></th>
			<th class="head">Action</th>
		</tr>
    </thead>
	<tbody>
		<?php
		if(count($mails))
		{    
			$row_type = 'even';
			foreach($mails as $row)
			{
				$row_type = ($row_type == 'odd') ? ('even'):('odd');
			?>
			<tr class="<?=$row_type?>">
			<td align="left" valign="middle"><?=$row['ifrom']; ?></td>
   			<td align="left" valign="middle"><?=$row['ito']; ?></td>
			<td align="left" valign="middle"><?=$row["sent_date"]?></td>
   			<td align="left" valign='middle'><?=$row["mail_type"]?></td>
            <td align="left" valign='middle'><?=$row["isubject"]?></td>
            <td align="left" valign='middle'>
			<?php 
                        if(empty($row['send_by']))
                        {
                            $to = 'admin@villgro.org';
                        }
                        else
                        {
                            $to = $row['send_by'];
                        }
                        echo anchor('common/dashboard/mailform/'.urlencode($to).'/'.urlencode($row['to']),'Reply','class="button"'); ?>&nbsp;&nbsp;
</td>
			</tr>
			<?php 
			}
		}
		else
		{ ?>
			<tr>
			<td colspan='9' align='center'>No Records found!</td>
			</tr>
		<?php
		} ?>
      </tbody>
	</table>
