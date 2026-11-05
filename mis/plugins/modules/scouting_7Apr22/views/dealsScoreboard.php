<div class="searchBox" style="margin-top:10px;">
    <label for="created_date">Program</label>
    <?php $program = 'Unc Pitch';?>
    <span style="padding:10px;">
        <input type="text" name="copy_id" disabled="disabled" value="<?= $program?>" class="input-text" id="copy_id" />
    </span>

    <label for="created_date">submitted Date</label>
    <?php 	
		$currentdate = date("d/m/Y"); 
		$startdate   = "22/11/2017" ;
	 	$submitted_date = $startdate ;
		$submitted_date_to = $currentdate;
	?>

    <span style="padding:10px;">
        <input type="text" disabled="disabled" name="submitted_date" value="<?=$submitted_date?>" class="input-text"
            id="submitteddate" />&nbsp;-&nbsp;
        <input type="text" disabled="disabled" name="submitted_date_to" value="<?=$submitted_date_to?>"
            class="input-text" id="submitted_date_to" />
    </span>
</div>
<div id="user-grid" class="grid-view">
    <table width="80%" class="items gtable" bgcolor="#F5F5F5" cellspacing="5" cellpadding="5" border="1px">
        <thead>
            <tr>

                <th>Assigned To</th>
                <th>Healthcare</th>
                <th>AgriBusiness</th>
                <th>Education</th>
                <th>Others</th>
            </tr>
        </thead>
        <tbody>
            <?php 
		foreach($getdealsScoreboard as $row):
			if($row['AssignIncharge']!=''){ ?>
            <tr>
                <td><?php echo $row['AssignIncharge'] ?></td>
                <td><?php echo $row['Healthcare'] ?></td>
                <td><?php echo $row['AgriBusiness'] ?></td>
                <td><?php echo $row['Education'] ?></td>
                <td><?php echo $row['Others'] ?></td>

            </tr>
            <?php }
			endforeach; ?>
        </tbody>
    </table>

</div>
<style type="text/css">
.gtable thead tr th {
    background-color: #A9CF55;
    text-align: left !important;
    padding: 8px 5px !important;
}
</style>