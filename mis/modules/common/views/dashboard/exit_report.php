<h2><?php echo $cpagetitle; ?> </h2>
<div class="grid6">
<div class="boxNotice fr" style="width:583px;">

<?php
$header = NULL;

$td = '<table id="table1" width="100%" class="gtable" cellspacing="3" cellpadding="4">';
$td .= '<th  style="background:url(../../../source/template/images/head_table_1px.gif);border-right:1px solid #DBDBD9;border-bottom:1px solid #DBDBD9;">Amout</th>';
$td .= '<th  style="background:url(../../../source/template/images/head_table_1px.gif);border-right:1px solid #DBDBD9;border-bottom:1px solid #DBDBD9;">Stage</th>';
$td .= '<th  style="background:url(../../../source/template/images/head_table_1px.gif);border-right:1px solid #DBDBD9;border-bottom:1px solid #DBDBD9;">Innovation</th>';
$td .= '<th  style="background:url(../../../source/template/images/head_table_1px.gif);border-right:1px solid #DBDBD9;border-bottom:1px solid #DBDBD9;">Date</th>';
foreach($allrepayment as $row)
	{
	$td.="<tr>";
	$td.="<td>".$row['amount']."</td>";
	$td.="<td>".$row['stage']."</td>";
	$td.="<td>".$row['name_of_enterprise']."</td>";
	$td.="<td>".$row['from_date']."</td>";
	$td.="</tr>";
}
$td .= '</table>';
echo $td;
?>
</div>
</div>


<?php
$td = '<table class="gtable" style="width:588px;" cellspacing="3" cellpadding="4">';
$td .= '<th class="" style="background:url(../../../source/template/images/head_table_1px.gif);border-right:1px solid #DBDBD9;border-bottom:1px solid #DBDBD9;">Exit Criteria</th>';
$td .= '<th class="" style="background:url(../../../source/template/images/head_table_1px.gif);border-right:1px solid #DBDBD9;border-bottom:1px solid #DBDBD9;">Year</th>';
$td .= '<th class="" style="background:url(../../../source/template/images/head_table_1px.gif);border-right:1px solid #DBDBD9;border-bottom:1px solid #DBDBD9;">Target</th>';
$td .= '<th class="" style="background:url(../../../source/template/images/head_table_1px.gif);border-right:1px solid #DBDBD9;border-bottom:1px solid #DBDBD9;">Achevied</th>';

$td .= '<tr>';
$td .= '<td style="background-color:#dce7cc;border:1px solid #B9CE98;">'."Board Meeting".'</a></td>';
$td .= '</tr>';
if(!empty($exitDetails)) {
	if(php72_count($exitDetails) == '4') {
		foreach($exitDetails as $row)
			$td .= '<tr>';
		$td .= '<td>'.$row['name_of_enterprise'].'</td>';
		$td .= '<td>'.$row['exitDate'].'</td>';
		$td .= '<td>'.'4'.'</td>';
		$td .= '<td style="color:green;font-weight:bold;">'.$exitDetails.'</a></td>';
		$td .= '</tr>';
		} else {
		$td .= '<tr class="tblrow">';
		$td .= '<td>'.$row['name_of_enterprise'].'</td>';
		$td .= '<td>'.$row['exitDate'].'</td>';
		$td .= '<td>'.'4'.'</td>';
		$td .= '<td style="color:red;font-weight:bold;">'. php72_count($exitDetails) .'</td>';
		$td .= '</tr>';
	}
}

$td .='<tr>';
$td .='<td style="background-color:#dce7cc;border:1px solid #B9CE98;">'."Raise Investment".'</a></td></tr>';
if(!empty($raiseinvestment))
{
	foreach($raiseinvestment as $row)
	{
		if($row['amount'] == $row['amount_approved'])
		{
			$td .= '<td style="color:green;font-weight:bold;">'.$row['amount_approved'].'</a></td>';
		}
		$td .= '<tr class="tblrow">';
		$td .= '<td>'.$row['name_of_enterprise'].'</td>';
		$td .= '<td>'.date('Y').'</td>';
		$td .= '<td>'.$row['amount'].'</td>';
		$td .= '<td>'.$row['amount_approved'].'</td>';
	}
}
$td .='</tr>';
$td .= '<tr>';
$td .= '</tr>';
$td .= '</table>';

echo $td;
?>
<style type="text/css">
    .tblrow {
        background:#F0F9D9 !important;
    }
</style>