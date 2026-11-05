<div align="right" style="margin-bottom: 20px;"><a href="javascript:history.go(-1);" class="button">Back</a> </div>

<div id="user-grid" class="gtable sortable">
    <table width="100%" class="items">
        <thead>
            <tr>
                <?php $nullLink=""; ?>
                <th><a href="<?=$nullLink?>" field="label">Keyword</a></th>
                <th><a href="<?=$nullLink?>" field="label">Time</a></th>
                <th><a href="<?=$nullLink?>" field="label">File Path</a></th>
                <th><a href="<?=$nullLink?>" field="label">Count(Max Results)</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
    if(count($docList))
	{
		$r=1;
        $i=0;
		foreach($getkeyresult as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
            <tr class="clickable">
                <?php if($docList[$i]['status'] == 'checked'){
				?>
                <td align="left" valign="middle" style="color:blue;"><?=$docList[$i]["keywords"];?></td>
                <?php } else {
				?>
                <td align="left" valign="middle" style="color:red;"><?=$docList[$i]["keywords"];?></td>
                <?php } ?>
                <td align="left" valign="middle"><?=$docList[$i]["time"];?></td>
                <td align="left" valign="middle"><?=$docList[$i]["module"];?></td>
                <td align="left" valign="middle"><?=$docList[$i]["count"];?></td>
            </tr>
            <tr>
                <td><?=$row['keyword']?></td>
                <td><?=$row['filepath']?></td>
                <td><?=$row['file_name']?></td>
                <td><?=$row['docName']?></td>
            </tr>
            <?php
            $i++;
		}
	}
	else
	{ ?>
            <tr>
                <td colspan='9' align='center'>No Records found!</td>
            </tr>
            <?
	} ?>
        </tbody>
    </table>
    <!-- Paging style -->
</div>
<script type="text/javascript">
$(".clickable").click(function() {
    $(this).next().toggle();

});
</script>