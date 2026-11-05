<html>
<head>
</head>
<style>
body {font-family: Helvetica, Arial, sans-serif; color:#333;}
.pdf-page {height:100%; margin:10px -13px -20px -10px; padding:30px;}
.pdf-page p {width:100%; margin:0 0 20px 0;}

h1 {color: #FFFFFF; background-color: #014c67;}
h2 {color: #c41030;}
h3 {color: #014c67; font-size:14px}
h4 {color: #014c67; background-color: #e5edf0; font-size:14px; font-weight:normal; padding:3px 3px 4px 5px; margin-bottom:3px; padding-bottom:4px;}
h5 {color: #c41030;}

img {width:100%; height:100%;}
td{width:50%; background-color: #e5edf0; padding:5px;}
table{width:100%}
.highlight {background-color:#e6edf0; color:#014c67; padding:10px;}
</style>
<body>

<div class="pdf-page">
  <h2><?=$cpagetitle?></h2>
  <?php foreach($requestListInfo as $row){ ?>
<table id="table" >
		<tr>
		  <td><strong>Request Number :</strong></td>
		  <td><?=$row["travel_request_id"]?></td>
		</tr>
		<tr>
		  <td><strong>Date of Requisition :</strong></td>
		  <td><?=mysql2ddmmyyyy($row["date_of_requisition"])?></td>
		</tr>
		<tr>
		  <td><strong>Compliance with HR manual (YES/NO)</strong></td>
		  <td><?=$row["compliance_with_hr_manual"]?>&nbsp;</td>
		</tr>
		<tr>
		  <td><strong>Is booking 5 days prior to travel. </strong></td>
		  <td><?=$row["prior_booking"]?></td>
		</tr>
		<tr>
		  <td><strong>Names of Persons</strong></td>
		  <td>
			  <?php foreach($personsList as $row1){?>
				<div><strong>Name</strong> : <?=(strpos($row1['name'],'SR'))?getEmployeeName($row1['name']):$row1['name'];?></div>
				<div><strong>Age</strong> : <?=$row1['age']?></div>
				<div><strong>Sex</strong> : <?=$row1['sex']?></div>
				<?php } ?>
			</td>
		</tr>
		<tr>
		  <td><strong>Purpose  </strong></td>
		  <td><?=$row["purpose"]?></td>
		</tr>
		<?php foreach($journeyList as $row_journey) { ?>
		<tr>
		  <td><strong>Date of Travel</strong></td>
		  <td><?=mysql2ddmmyyyy($row_journey["date_of_travel"])?></td>
		</tr>
		<tr>
		  <td><strong>Destination From:</strong></td>
		  <td><?=$row_journey["destination_from"]?></td>
		</tr>
		<tr>
		  <td><strong>To: </strong></td>
		  <td><?=$row_journey["destination_to"]?></td>
		</tr>
		<tr>
		  <td><strong>Time </strong></td>
		  <td><?=$row_journey["travel_time"]?></td>
		</tr><tr>
		  <td><strong>Train/Flight/Cab/Bus</strong></td>
		  <td><?=$this->Mtravel->showMaster($row_journey["travel_mode"])?></td>
		</tr>
		<tr>
		  <td><strong>Any preferred Train/Flight</strong></td>
		  <td><?=$row_journey["preferred_train_flight"]?></td>
		</tr>
		<tr>
		  <td><strong>Date of Accomodation</strong></td>
		  <td><?=mysql2ddmmyyyy($row_journey["date_of_accomodation"])?></td>
		</tr>
		<tr>
		  <td><strong>Location Preference</strong></td>
		  <td><?=$row_journey["location_preference"]?></td>
		</tr>
		
	<?php } ?>
		<tr>
		  <td><strong>Donor</strong></td>
		  <td><?=($row["donor"]==0)?$row["other_donor"]:$this->Mtravel->showMaster($row["donor"]);?></td>
		</tr>
		<tr>
		  <td><strong>Budget Head</strong></td>
		  <td><?=($row["budget_head"]==0)?$row["other_budget_head"]:$this->Mtravel->showMaster($row["budget_head"]);?></td>
		</tr>
		<tr>
		  <td><strong>Sub-line Item</strong></td>
		  <td><?=($row["cost_centre"]==0)?$row["other_cost_centre"]:$this->Mtravel->showMaster($row["cost_centre"]);?></td>
		</tr>
		<tr>
		  <td><strong>Programme</strong></td>
		  <td><?=$row["programme"]?></td>
		</tr>
		<tr>
		  <td><strong>Innovation</strong></td>
		  <td><?=$row["innovation"]?></td>
		</tr>
		<tr>
		  <td><strong>Reporting Officers  Approval</strong></td>
		  <td><?=$row["reporting_approval"]?></td>
		</tr>
	  </table>
<?php } ?>
</div>


</body>
</html>