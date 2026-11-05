<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
</head>

<body>
    <table class="gtable sorttable">
        <thead>
            <tr>
                <th width="53">Id</th>
                <th width="235">Innovation</th>
                <th width="201">Modified By</th>
                <th width="292">Version</th>
                <th width="192">Modified Date</th>
                <th width="192">Agreement</th>
            </tr>
        </thead>
        <tbody id="activitiesTable">
            <?php 
	if(php72_count($actionhistory))
	{       
			$rowtype = 'odd';
			foreach($actionhistory as $row):
			?>
            <tr>
                <td align="left" valign="middle"><?=$row['id']?></td>
                <td align="left" valign="middle" width="235"><?=$row['innovation']?></td>
                <td align="left" valign="middle"> <?=$row['modified_by']?></td>
                <td align="left" valign="middle"> <?="Version".$row['version']?></td>
                <td align="left" valign="middle"><?=$row['modified_date']?></td>
                <td align="left" valign="middle"><a
                        href="<?=site_url('screening/showagreement/'.$row['id'])?>"><?="Version".$row['version'];?></a>
                </td>
                <?php 
			endforeach;					
			?>
            </tr>
            <?php
	}
	else
	{ ?>
            <tr>
                <td colspan='7' align='center'>No Records found!</td>
            </tr>
            <?php
	} ?>
        </tbody>
    </table>
</body>

</html>