<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
</head>

<body>
    <table class="gtable sorttable">
        <tbody id="activitiesTable">
            <?php 
	if(count($showagreement))
	{       
			$rowtype = 'odd';
			foreach($showagreement as $row):
			?>
            <tr>
                <td align="left" valign="middle"><?=$row['agreement'];?></td>
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