<h1><?=$cpagetitle?></h1>
<div style="height:400px; overflow:auto">
    <table class="gtable detailtable">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Document Description</th>
                <th>Applicability</th>
                <th>Document Uploaded</th>
            </tr>

        </thead>
        <tbody>
            <?php
	$key = 0;
	$na = '';
	foreach($checkList as $row): 
	
	$na_new = $row['master_name'];
	if($na_new != $na)
	{
		$na = $na_new;
		$key = 0;
	?>
            <tr>
                <td colspan="3">
                    <h2><?=$row['master_name']; ?></h2>
                </td>
            </tr>
            <?php }?>
            <tr>
                <td><?=++$key;?></td>
                <td style="width:500px;"><?php echo $row['document_description']; ?></td>
                <td><?=(php72_in_array($row['id'],$innovationChecklist))?'<font color="green">Applicable</font>':'<font color="red">Not Applicable</font>';?>
                </td>
                <td><?php if($row['documents'] != ''){?>
                    <strong>YES</strong>&nbsp;&nbsp;<a href="<?=base_url()?>uploads/screening/<?=$row['documents']?>"
                        style="text-decoration:none;" target="_blank">(<?=$row['documents']?>)&nbsp;&nbsp;<img
                            src="<?=base_url();?>source/template/images/icons/download.gif" alt="Download"
                            height="16" /></a>
                    <?php }else{ echo "<strong>NO</strong>"; } ?></td>
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