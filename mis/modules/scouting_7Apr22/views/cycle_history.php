<h2><?=$cpagetitle.' - '.$innovation['name_of_enterprise']?></h2>

<table class="gtable detailtable">
    <thead>
        <tr>
            <th width="9%"><a href="#">S.No.</a></th>
            <th width="13%"><a href="#">Incubation Cycle</a></th>
            <th width="42%"><a class="asc" href="#">Comments</a></th>
            <th width="7%"><a class="asc" href="#">Assigned Date</a></th>
            <th width="16%"><a class="asc" href="#">Assigned By</a></th>
        </tr>

    </thead>
    <tbody>
        <?php
	$h = 0;
	foreach($historyList as $row): 
	?>
        <tr>
            <td><?=++$h;?></td>
            <td><?=$row['cycle_name']?></td>
            <td><?=$row['comments'];?></td>
            <td><?=mysql2date($row['created_date'])?></td>
            <td><?=$row['created_emp']?></td>
        </tr>
        <?php 
	endforeach;
	?>
    </tbody>
</table>