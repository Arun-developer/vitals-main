<h1><?=$cpagetitle?> </h1>
<table class="gtable">
    <thead>
        <tr>
            <td>Budget</td>
			<td>Line Item</td>
            <td>Amount Approved(in Rs.)</td>
			<td>Fund Utilized(in Rs.)</td>
			<td>Un Utilized(in Rs.)</td>
        </tr>
    </thead>
    <tbody>        
    <?php
	 foreach($media_report as $row):?>
        <tr>
            <td><?=$row['budget'];?></td>
			<td><?=$row['line_item'];?></td>
			<td><?=$row['amount_approved'];?></td>
            <td><?=$row['fund_utilized'];?></td>
			<?php $diff = $row['amount_approved'] - $row['fund_utilized'];?>
			<td><?=$diff;?></td>
        </tr>
      <?php endforeach;?>
    <!-- end id-form  -->
    </tbody>
</table>
