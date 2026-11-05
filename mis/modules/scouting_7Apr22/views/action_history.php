<h2><?=$innovation['name_of_enterprise']?> - Action History</h2>

<table class="gtable detailtable">
    <thead>
        <tr>
            <th width="9%"><a href="#">S.No.</a></th>
            <th width="13%"><a href="#">Status Converted</a></th>
            <th width="13%"><a href="#">Reasons</a></th>
            <th width="42%"><a class="asc" href="#">Comments</a></th>
            <th width="7%"><a class="asc" href="#">Action Date</a></th>
            <th width="16%"><a class="asc" href="#">Action By</a></th>
        </tr>

    </thead>
    <tbody>
        <?php
	$h = 0;
	foreach($historyList as $row): 
	?>
        <tr>
            <td><?=++$h;?></td>
            <td><?=$status[$row['status']]?></td>
            <td><?php
			echo $row['reasons_title'];
			?></td>
            <td><?=$row['comments'];?></td>
            <td><?=mysql2date($row['added_date'])?></td>
            <td><?=$row['added_emp']?></td>
        </tr>
        <?php 
	endforeach;
	?>


    </tbody>
</table>



<!-- end id-form  -->