<h1><?=$cpagetitle?></h2>
    <div style="height:500px; overflow:auto;">
        <table class="gtable detailtable">
            <thead>
                <tr>
                    <th width="37">S.No.</th>
                    <th width="355">Means of Validation</th>
                    <th width="69">Done</th>
                    <th width="277">Comments</th>
                </tr>

            </thead>
            <tbody>
                <?php
	$key = 0;
	
	foreach($criteriaList as $cr): 
	
	?>
                <tr>
                    <td colspan="4">
                        <h2><?=$cr['master_name']?></h2>
                    </td>
                </tr>
                <?php
	$validationList = $this->Mscreening_validation->getScreeningValidation($innovation,$cr['id']);
	foreach($validationList as $row):
	?>
                <tr>
                    <td><?=++$key;?></td>
                    <td><?php echo $row['validation']; ?></td>
                    <td><?=($row['done'] == '1')?'Done':'Pending';?></td>
                    <td><?=$row['comments']?></td>
                </tr>
                <?php 
	endforeach;
	endforeach;
	?>
        </table>
        <!-- Paging style -->
    </div>