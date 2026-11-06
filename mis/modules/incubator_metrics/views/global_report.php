<html>
<head>
<style>

/* ---- Table ---- */
table {
	border-collapse:collapse;
	margin-bottom:15px;
	width:90%;
	}
	table td,
	table th {
		padding:3px;
		border:1px solid #ccc;
		border-width:0 1px 1px 0;
		font-size:11px;
		color:#FFFFFF;
		}
		
	thead th {
		background:#6aa74f;
		}
			
		thead th[colspan],
		thead th[rowspan] {
			background:#6aa74f;
			}
		
	tbody th,
	tfoot th {
		text-align:left;
		background:#6aa74f;
		}
		
	tbody td,
	tfoot td {
		text-align:center;
		color:#000000;

		}
		
	tfoot th {
		background:#b0cc7f;
		}
		
	tfoot td {
		background:#d7e1c5;
		font-weight:bold;
		}
			
	tbody tr.odd td { 
		background:#bcd9e1;
		}

</style>
<script>
    $(function(){
      // bind change event to select
      $('#dynamic_select').bind('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
</script>
</head>
<body>
<div align="right">
<a href="<?=site_url('exit_details/exitdetails/gradingDetails/'.$innovation)?>" class="button">Move to Exit Stage</a>
</div>
<label for="innovation">Select Innovation:</label>
<select name="innovation" id="dynamic_select">
<option value="">Select</option>
<?php foreach($portfolioinnovation as $row):?>
<option value="<?=site_url('incubator_metrics/wglobal_report/index/'.$row['id'])?>"><?=$row['name_of_enterprise']?></option>
<?php endforeach;?>
</select>
    <h1><?=$name_of_enterprise;?>-Dashboard</h1>
<ul class="tabs">
<?php foreach($frequency as $key=>$value)
{
	?>
	<li class="<?=($defaultfrequency == $value)?'selected':'';?>"><a href="<?=site_url('incubator_metrics/wglobal_report/index/'.$innovation.'/'.$value)?>"><?=$key;?></a></li>
	<?php } ?>
</ul>
<?php if($defaultfrequency != '4')
{
	?>	
	<ul class="tabs">
	<?php foreach($yearly as $row5)
	{
		?>
		<li class="<?=($defaultyearly == $row5)?'selected':'';?>"><a href="<?=site_url('incubator_metrics/wglobal_report/index/'.$innovation.'/'.$defaultfrequency.'/'.$row5)?>"><?=$row5;?></a></li>
		<?php } ?>
	</ul>
	<?php if($defaultfrequency=='1')
	{
		?>	
		<ul class="tabs">
		<?php foreach($monthly as $row6)
		{
			?>
			<li class="<?=($defaultmonthly == $row6)?'selected':'';?>"><a href="<?=site_url('incubator_metrics/wglobal_report/index/'.$innovation.'/'.$defaultfrequency.'/'.$defaultyearly.'/'.$row6)?>"><?= date("M", mktime(0, 0, 0, $row6, 1, 2000));?></a></li>
			<?php }  ?>
		</ul>
		<?php } ?>
	<?php } ?>
<?php if($defaultfrequency == '4')
{
?>
<table class="gtable" width="auto" cellspacing="3" cellpadding="4">
<thead>
<tr>
<th style="background:#74AD5A !important;">Label:</th>
<?php foreach($yearly as $years):
?>
<th style="background:#74AD5A !important;"><?php echo $years;?></th>
<?php endforeach; 
?>
</tr>
</thead>
<tbody >
<?php
$this->load->model('incubator_metrics/mwglobal_report');
$yearreport = array('amount'=>'Total Fund Released','approved_amount'=>'TotalFund Approved','fund_utilized'=>'Total Fund Utilized');
$tdata['amount'] = $tdata['approved_amount'] = $tdata['fund_utilized'] = '';
$tdata['total'] = $tdata['accept'] = $tdata['reject'] = '';
$tfdata['total'] = $tfdata['accept'] = $tfdata['reject'] = '';
$tmdata['total'] = $tmdata['company'] = $tmdata['hours'] = $tmdata['money'] = '';
$tmtdata['count'] = '';
$trdata['answer'] = '';
$tydata['amount'] = '';
for($i=0;$i<php72_count($yearanswer); $i++)
{
	$tdata['amount'] .= '<td>'.$yearanswer[$i][0]['amount'].'</td>';	
	$tdata['approved_amount'] .= '<td>'.$yearanswer[$i][0]['approved_amount'].'</td>';	
	$tdata['fund_utilized'] .= '<td>'.$yearanswer[$i][0]['fund_utilized'].'</td>';	
}
if($tdata['amount'] == $tdata['fund_utilized'])
{
echo '<tr><td colspan="8"><h2 align="left" title="Successfully Completed" style="color:green !important">Seed Funding Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total Fund Approved(in Rs.)</td><span style="color:green !important">'.$tdata['amount'].'</span>';
echo '</tr>';
echo '<tr>';
echo '<td>TotalFund Released(in Rs.)</td><span style="color:green !important">'.$tdata['approved_amount'].'</span>';
echo '</tr>';
echo '<tr>';
echo '<td>Total Fund Utilized(in Rs.)</td><span style="color:green !important">'.$tdata['fund_utilized'].'</span>';
echo '</tr>';	
}
else{
echo '<tr><td colspan="8"><h2 align="left">Seed Funding Report</h2></td></tr>';	
echo '<tr>';
echo '<td>Total Fund Approved(in Rs.)</td>'.$tdata['amount'];
echo '</tr>';
echo '<tr>';
echo '<td>TotalFund Released(in Rs.)</td>'.$tdata['approved_amount'];
echo '</tr>';
echo '<tr>';
echo '<td>Total Fund Utilized(in Rs.)</td>'.$tdata['fund_utilized'];
echo '</tr>';

}
for($i=0;$i<php72_count($yearmeeting);$i++)
{
	$tmdata['count'] .= '<td>'.$yearmeeting[$i][0]['id'].'</td>';
}
if(php72_cmp($tmdata['count']) >= 4)
{
echo '<tr><td colspan="8"><h2 align="left"  style="color:green !important">Board Meeting Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total</td><span style="color=green">'.$tmdata['count'].'</span>';	
}
else
{
	echo '<tr><td colspan="8"><h2 align="left">Board Meeting Report</h2></td></tr>';
	echo '<tr>';
	echo '<td>Total</td>'.$tmdata['count'];
}
echo '</tr>';

for($i=0;$i<php72_count($yearraise);$i++)
{
	$tydata['amount'] .= '<td>'.$yearraise[$i][0]['amount_approved'].'</td>';
}
echo '<tr><td colspan="13"><h2 align="left">Raise Investment Report</h2></td></tr>';
echo '<tr>';
echo '<td>Investment Raised</td>'.$tydata['amount'];
echo '</tr>';

for($i=0;$i<php72_count($yearfellow);$i++)
{
	$tfdata['total'] .= '<td>'.$yearfellow[$i][0]['total'].'</td>';
	$tfdata['accept'] .= '<td>'.$yearfellow[$i][0]['accept'].'</td>';
	$tfdata['reject'] .= '<td>'.$yearfellow[$i][0]['reject'].'</td>';
}
if(php72_cmp($tfdata['accept']) >= 1 )
{
echo '<tr><td colspan="8"><h2 align="left" style="color:green" title="Successfully Completed">FellowShip Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total</td><span style="color=green">'.$tfdata['total'].'</span>';
echo '</tr>';
echo '<tr>';
echo '<td>Accept</td><span style="color=green">'.$tfdata['accept'].'</span>';
echo '</tr>';
echo '<tr>';
echo '<td>Reject</td><span style="color=green">'.$tfdata['reject'].'</span>';
echo '</tr>';
}
else{
echo '<tr><td colspan="8"><h2 align="left">FellowShip Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total</td>'.$tfdata['total'];
echo '</tr>';
echo '<tr>';
echo '<td>Accept</td>'.$tfdata['accept'];
echo '</tr>';
echo '<tr>';
echo '<td>Reject</td>'.$tfdata['reject'];
echo '</tr>';
}

for($i=0;$i<php72_count($yearmedia);$i++)
{
	$tmdata['total'] .= '<td>'.$yearmedia[$i][0]['created_emp'].'</td>';
	$tmdata['company'] .= '<td>'.$yearmedia[$i][0]['company'].'</td>';
	$tmdata['hours'] .= '<td>'.$yearmedia[$i][0]['mentorhours'].'</td>';
	$tmdata['money'] .= '<td>'.$yearmedia[$i][0]['mentormoney'].'</td>';
}
if(php72_cmp($tmdata['mentormoney']) > 0)
{
echo '<tr><td colspan="8"><h2 align="left" title="successfully completed" style="color:green !important">Mentor Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total</td><span style="color:green;">'.$tmdata['total'].'</span>';
echo '</tr>';
echo '<tr>';
echo '<td>Company</td><span style="color:green;">'.$tmdata['company'].'</span>';
echo '</tr>';
echo '<tr>';
echo '<td>Mentor Hours</td><span style="color=green">'.$tmdata['hours'].'</span>';
echo '</tr>';
echo '<tr>';
echo '<td>Mentor Money</td><span style="color=green">'.$tmdata['money'].'</span>';
echo '</tr>';	
}
else
{
echo '<tr><td colspan="8"><h2 align="left">Mentor Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total</td>'.$tmdata['total'];
echo '</tr>';
echo '<tr>';
echo '<td>Company</td>'.$tmdata['company'];
echo '</tr>';
echo '<tr>';
echo '<td>Mentor Hours</td>'.$tmdata['hours'];
echo '</tr>';
echo '<tr>';
echo '<td>Mentor Money</td>'.$tmdata['money'];
echo '</tr>';
}

for($i=0;$i<php72_count($yearrevenue);$i++)
{
	$trdata['answer'] .= '<td>'.$yearrevenue[$i][0]['answer'].'</td>';
}
echo '<tr><td colspan="8"><h2 align="left">Total Reveune Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total</td>'.$trdata['answer'];
echo '</tr>';
?>
</tbody>
</table>
<?php } ?>
<?php if($defaultfrequency == '3')
{
?>
<table class="gtable" width="auto" cellspacing="3" cellpadding="4">
<thead>
<tr>
<th style="background:#74AD5A !important;">Label:</th>
<?php foreach($quarterly as $quarters):
?>
<th style="background:#74AD5A !important;"><?php echo $quarters;?></th>
<?php endforeach; 
?>
</tr>
</thead>
<tbody >
<?php
$tdata['amount'] = $tdata['approved_amount'] = $tdata['fund_utilized'] = $tdata['answer'] = '';
$tdata['total'] = $tdata['accept'] = $tdata['reject'] = '';
$tfdata['total'] = $tfdata['accept'] = $tfdata['reject'] = '';
$tmdata['total'] = $tmdata['accept'] = $tmdata['reject'] = '';
$tmtdata['count'] = '';
$trdata['total'] = '';
$tqdata['amount'] = '';
for($i=0;$i<php72_count($quarteranswer); $i++)
{
	$tdata['amount'] .= '<td>'.$quarteranswer[$i][0]['amount'].'</td>';	
	$tdata['approved_amount'] .= '<td>'.$quarteranswer[$i][0]['approved_amount'].'</td>';	
	$tdata['fund_utilized'] .= '<td>'.$quarteranswer[$i][0]['fund_utilized'].'</td>';	
}
echo '<tr><td colspan="8"><h2 align="left">Seed Funding Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total Fund Released</td>'.$tdata['amount'];
echo '</tr>';
echo '<tr>';
echo '<td>TotalFund Approved</td>'.$tdata['approved_amount'];
echo '</tr>';
echo '<tr>';
echo '<td>Total Fund Utilized</td>'.$tdata['fund_utilized'];
echo '</tr>';

for($i=0;$i<php72_count($quarterraise);$i++)
{
	$tqdata['amount'] .= '<td>'.$quarterraise[$i][0]['amount_approved'].'</td>';
}
echo '<tr><td colspan="13"><h2 align="left">Raise Investment Report</h2></td></tr>';
echo '<tr>';
echo '<td>Investment Raised</td>'.$tqdata['amount'];
echo '</tr>';

for($i=0;$i<php72_count($quarterfellow);$i++)
{
	$tfdata['total'] .= '<td>'.$quarterfellow[$i][0]['total'].'</td>';
	$tfdata['accept'] .= '<td>'.$quarterfellow[$i][0]['accept'].'</td>';
	$tfdata['reject'] .= '<td>'.$quarterfellow[$i][0]['reject'].'</td>';
}
echo '<tr><td colspan="8"><h2 align="left">FellowShip Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total</td>'.$tfdata['total'];
echo '</tr>';
echo '<tr>';
echo '<td>Accept</td>'.$tfdata['accept'];
echo '</tr>';
echo '<tr>';
echo '<td>Reject</td>'.$tfdata['reject'];
echo '</tr>';
for($i=0;$i<php72_count($quartermedia);$i++)
{
	$tmdata['total'] .= '<td>'.$quartermedia[$i][0]['created_emp'].'</td>';
	$tmdata['accept'] .= '<td>'.$quartermedia[$i][0]['company'].'</td>';
	$tmdata['reject'] .= '<td>'.$quartermedia[$i][0]['hours'].'</td>';
}
echo '<tr><td colspan="8"><h2 align="left">Mentor Report</h2></td></tr>';
echo '<tr>';
echo '<td>Name</td>'.$tmdata['total'];
echo '</tr>';
echo '<tr>';
echo '<td>Company</td>'.$tmdata['accept'];
echo '</tr>';
echo '<tr>';
echo '<td>Hours</td>'.$tmdata['reject'];
echo '</tr>';
for($i=0;$i<php72_count($quartermeeting);$i++)
{
	$tmdata['count'] .= '<td>'.$quartermeeting[$i][0]['id'].'</td>';
}
echo '<tr><td colspan="8"><h2 align="left">Board Meeting Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total</td>'.$tmdata['count'];
echo '</tr>';
for($i=0;$i<php72_count($quarterrevenue);$i++)
{
	$tdata['answer'] .= '<td>'.$quarterrevenue[$i][0]['answer'].'</td>';
	echo $quarterreveune[$i]['answer'];
}
echo '<tr><td colspan="8"><h2 align="left">Total Reveune Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total</td>'.$tdata['answer'];
echo '</tr>';
?>
</tbody>
</table>
<?php } ?>
<?php if($defaultfrequency == '2')
{
?>
<table class="gtable" width="auto" cellspacing="3" cellpadding="4">
<thead>
<tr>
<th style="background:#74AD5A !important;">Label:</th>
<?php foreach($monthly as $months):
?>
<th style="background:#74AD5A !important;"><?php echo $months;?></th>
<?php endforeach; 
?>
</tr>
</thead>
<tbody >
<?php
$tdata['amount'] = $tdata['approved_amount'] = $tdata['fund_utilized'] = '';
$tdata['total'] = $tdata['accept'] = $tdata['reject'] = '';
$tfdata['total'] = $tfdata['accept'] = $tfdata['reject'] = '';
$tmdata['total'] = $tmdata['accept'] = $tmdata['reject'] = '';
$tmtdata['count'] = '';
$trdata['amount'] = '';
for($i=0;$i<php72_count($monthanswer); $i++)
{
	$tdata['amount'] .= '<td>'.$monthanswer[$i][0]['amount'].'</td>';	
	$tdata['approved_amount'] .= '<td>'.$monthanswer[$i][0]['approved_amount'].'</td>';	
	$tdata['fund_utilized'] .= '<td>'.$monthanswer[$i][0]['fund_utilized'].'</td>';	
}
echo '<tr><td colspan="13"><h2 align="left">Seed Funding Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total Fund Released</td>'.$tdata['amount'];
echo '</tr>';
echo '<tr>';
echo '<td>TotalFund Approved</td>'.$tdata['approved_amount'];
echo '</tr>';
echo '<tr>';
echo '<td>Total Fund Utilized</td>'.$tdata['fund_utilized'];
echo '</tr>';
for($i=0;$i<php72_count($monthraise);$i++)
{
	$trdata['amount'] .= '<td>'.$monthraise[$i][0]['amount_approved'].'</td>';
}
echo '<tr><td colspan="13"><h2 align="left">Raise Investment Report</h2></td></tr>';
echo '<tr>';
echo '<td>Investment Raised</td>'.$trdata['amount'];
echo '</tr>';


for($i=0;$i<php72_count($monthfellow);$i++)
{
	$tfdata['total'] .= '<td>'.$monthfellow[$i][0]['total'].'</td>';
	$tfdata['accept'] .= '<td>'.$monthfellow[$i][0]['accept'].'</td>';
	$tfdata['reject'] .= '<td>'.$monthfellow[$i][0]['reject'].'</td>';
}
echo '<tr><td colspan="13"><h2 align="left">FellowShip Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total</td>'.$tfdata['total'];
echo '</tr>';
echo '<tr>';
echo '<td>Accept</td>'.$tfdata['accept'];
echo '</tr>';
echo '<tr>';
echo '<td>Reject</td>'.$tfdata['reject'];
echo '</tr>';
for($i=0;$i<php72_count($monthmedia);$i++)
{
	$tmdata['total'] .= '<td>'.$monthmedia[$i][0]['total'].'</td>';
	$tmdata['accept'] .= '<td>'.$monthmedia[$i][0]['accept'].'</td>';
	$tmdata['reject'] .= '<td>'.$monthmedia[$i][0]['reject'].'</td>';
}
echo '<tr><td colspan="13"><h2 align="left">Media Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total</td>'.$tmdata['total'];
echo '</tr>';
echo '<tr>';
echo '<td>Accept</td>'.$tmdata['accept'];
echo '</tr>';
echo '<tr>';
echo '<td>Reject</td>'.$tmdata['reject'];
echo '</tr>';
for($i=0;$i<php72_count($monthmeeting);$i++)
{
	$tmdata['count'] .= '<td>'.$monthmeeting[$i][0]['id'].'</td>';
}
echo '<tr><td colspan="13"><h2 align="left">Board Meeting Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total</td>'.$tmdata['count'];
echo '</tr>';
for($i=0;$i<php72_count($monthrevenue);$i++)
{
	$trdata['total'] .= '<td>'.$monthrevenue[$i][0]['answer'].'</td>';
}
echo '<tr><td colspan="13"><h2 align="left">Total Reveune Report</h2></td></tr>';
echo '<tr>';
echo '<td>Total</td>'.$trdata['total'];
echo '</tr>';
?>
</tbody>
</table>
<?php } ?>
      
       </body>
       </html>