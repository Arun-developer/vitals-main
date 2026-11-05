<div id="user-grid" class="gtable sortable">
    <table width="100%" class="items">
        <thead>
            <tr>
                <?php $nullLink=""; ?>

                <th><a href="<?=$nullLink?>" field="label">Keyword</a></th>
                <th><a href="<?=$nullLink?>" field="label">Filename</a></th>
                <th><a href="<?=$nullLink?>" field="label">Page No</a></th>
                <th><a href="<?=$nullLink?>" field="value">Document Name</a></th>
                <th><a href="<?=$nullLink?>" field="status">Action</a></th>


            </tr>
        </thead>
        <tbody>
            <?php
error_reporting(0);
	if(php72_count($totalkeywordList))
	{
		$r=1;
		foreach($totalkeywordList as $row)
		{
			$r++;
	?>
            <tr class="<?=$row_type?>">
                <td align="left" valign="middle"><?=$row["keyword"];?></td>
                <td align="left" valign="middle"><a href="<?php echo $row['filepath'];?>"><?=$row["file_name"];?></a>
                </td>
                <td align="left" valign="middle"><?=$row["pageNo"];?></td>
                <td align="left" valign="middle"><?=$row["docName"];?></td>
                <td align="left" valign="middle"> <a
                        href="<?php echo site_url("dms/document_system/gettotalkeyword/".$row["keyword"]."/".$row["id"]); ?>"
                        class="confirmDelete"> <img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete"></a>
                </td>
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