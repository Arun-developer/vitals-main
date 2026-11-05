<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=exceldata.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border='1' width="70%">
<tr>
<td>Label</td>
</tr>
<?php


$na = '';
foreach($exceloutput as $item) {
	
$na_new = $item['mastertype'];
if($na != $na_new)
{
	$na = $na_new;
?>
<tr>
<td><h2><?=$item['mastertype'];?></h2></td>
</tr>
<?php } ?>
<tr>
<td style="padding-left:50px;"><?=$item['label']?></td>
</tr>
<?php } ?>
</table>