
  <h1><?=$cpagetitle ?>:</h1>

	<table class="gtable detailtable">
	<thead>
		<tr>
		    <th width="9%"><a href="#">S.No.</a></th>
			<th width="13%"><a href="#">Assigned Innovaton</a></th>
	
	  </tr>
		
	</thead>
	<tbody>
    <?php
	$h = 0;
	foreach($previouslist as $row): 
	?>
		<tr>
			<td><?=++$h;?></td>
			<td><?=$row['name']?></td>
	
	
			</tr>
    <?php 
	endforeach;
	?>
				
	</tbody>
	</table>

<!-- end id-form  -->
