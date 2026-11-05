<h1><?=$cpagetitle?></h1>
<div style="height:400px; overflow:auto">
    <table class="gtable detailtable">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Comments</th>
                <th>Comments By</th>
                <th>Created Date</th>
            </tr>

        </thead>
        <tbody>
            <?php
	$key = 0;
	$na = '';
	foreach($commentsList as $row): 
	
	$na_new = $row['criteria'];
	if($na_new != $na)
	{
		$na = $na_new;
		$key = 0;
	?>
            <tr>
                <td colspan="3">
                    <h2><?php 
		foreach($criteriaList as $rowcriteria) { 
			
			if($rowcriteria['id'] == $row['criteria']) {  echo $rowcriteria['master_name']; }
		
		} 
	 ?></h2>
                </td>
            </tr>
            <?php }?>
            <tr>
                <td><?=++$key;?></td>
                <td style="width:500px;"><?php echo $row['comments']; ?></td>
                <td style="width:500px;"><?php echo $row['comments_by']; ?></td>
                <td style="width:500px;"><?php echo $row['cretaed_date']; ?></td>
            </tr>
            <?php 
	endforeach;
	?>
            <tr class="odd">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></td>
            </tr>

        </tbody>
    </table>
    <!-- Paging style -->
</div>