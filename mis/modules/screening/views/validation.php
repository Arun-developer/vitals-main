<h2>Means of Validation</h2>
<form name="step1" action="<?=site_url('screening/validation/'.$innovation.'/'.$criteria);?>"
    enctype="multipart/form-data" method="post" id="step1" class="uniform">
    <input type="hidden" name="criteria" value="<?=$criteria?>" />
    <input type="hidden" name="innovation" value="<?=$innovation?>" />
    <div id="user-grid" class="grid-view">
        <table class="gtable detailtable">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Means of Validation</th>
                    <th>Done</th>
                    <th>Documents</th>
                    <th>Comments</th>
                </tr>

            </thead>
            <tbody>
                <?php
	$key = 0;
	foreach($validationList as $row): 
	?>
                <tr class="odd">
                    <td><?=++$key;?></td>
                    <td><?php echo $row['validation']; ?></td>
                    <td>
                        <input type="hidden" name="all[]" value="<?=$row['id']?>">
                        <input type="checkbox" name="validation[]" value="<?=$row['id']?>"
                            <?=($row['done'] == '1')?'checked':'';?>></td>
                    <td>
                        <div id="uniform-undefined" class="uploader"> <input type="file" size="40" style="opacity: 0;"
                                name="<?=$row['id']?>" />
                            <span class="filename" style="-moz-user-select: none;">No file selected</span>
                            <span class="action" style="-moz-user-select: none;">Choose File</span>
                        </div>
                    </td>
                    <td><textarea name="comments[]"><?=$row['comments']?></textarea></td>
                </tr>
                <?php 
	endforeach;
	?>
                <tr class="odd">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="txtSubmit" value="Save" class="button"></td>
                    <td>&nbsp;</td>
                </tr>

            </tbody>
        </table>
        <!-- Paging style -->
    </div>
</form>