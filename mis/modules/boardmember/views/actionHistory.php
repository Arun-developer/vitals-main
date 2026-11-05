
  <h1><?=$cpagetitle ?></h1>

	<table class="gtable detailtable">
	<thead>
		<tr>
		    <th width="9%"><a href="#">S.No.</a></th>
			<th width="13%"><a href="#">Status Converted</a></th>
			<th width="42%"><a class="asc" href="#">Comments</a></th>
            <th width="7%"><a class="asc" href="#">Action Date</a></th>
            <th width="16%"><a class="asc" href="#">Action By</a></th>
		    <th width="16%"><a class="asc" href="#">Assigned Innovation</a></th>
	  </tr>
		
	</thead>
	<tbody>
    <?php
	$h = 0;
	
	foreach($historylist as $row): 
	?>
		<tr>
			<td><?=++$h;?></td>
			<td><?=$stage[$row['action']]?></td>
			<td><?php
			echo $row['comments'];
			?></td>
			
			<td><?=mysql2date($row['actiondate'])?></td>
			<td><?=$row['actionby']?></td>
			<td><?=$row['innovation']?></td>
			</tr>
    <?php 
	endforeach;
	?>
		
		
	</tbody>
	</table>

    

<!-- end id-form  -->
