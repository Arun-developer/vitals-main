<div align="right" style="margin-bottom: 20px;"><a href="javascript:history.go(-1);" class="button">Back</a> </div>

<div id="user-grid" class="gtable sortable">
    <table width="100%" class="items">
        <thead>
            <tr>
                <?php $nullLink=""; ?>

                <th><a href="<?=$nullLink?>" field="label">Keyword</a></th>
                <th><a href="<?=$nullLink?>" field="label">Filename</a></th>
                <th><a href="<?=$nullLink?>" field="label">File Path</a></th>
                <th><a href="<?=$nullLink?>" field="label">Page No</a></th>
                <th><a href="<?=$nullLink?>" field="value">Document Name</a></th>
                <th><a href="<?=$nullLink?>" field="status">Action</a></th>


            </tr>
        </thead>
        <tbody>
            <?php
error_reporting(0);
	if(count($getkeyresult))
	{
		$r=1;
		foreach($getkeyresult as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
	?>
            <tr class="<?=$row_type?>">
                <td align="left" valign="middle"><?=$row["keyword"];?></td>
                <td align="left" valign="middle"><?=$row["file_name"];?></td>
                <td align="left" valign="middle"><?=$row["filepath"];?></td>
                <td align="left" valign="middle"><?=$row["pageNo"];?></td>
                <td align="left" valign="middle"><?=$row["docName"];?></td>
                <td align="left" valign="middle"> <a
                        href="<?php echo site_url("dms/document_system/searchedKeyWord/".$row["id"]); ?>"
                        class="confirmDelete"> </a><img
                        src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete"></td>
            </tr>
            <?php
		}
	}
	else
	{ ?>
            <tr>
                <td colspan='9' align='center'>No Records found!</td>
            </tr>
            <?php
	} ?>
        </tbody>
    </table>
    <!-- Paging style -->
</div>