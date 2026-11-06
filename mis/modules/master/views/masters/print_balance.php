<html>
<head>
<style>

		table {
			font-family: Helvetica, Arial, sans-serif;
			font-size: 13px;	
			width: 100%;
   border-collapse: collapse;
   table-layout: fixed;		
		}
		td{
overflow-wrap: break-word; 
word-wrap: break-word;
word-break: break-all;
}
body, p, li, td, table, tr, .bodytext, .stepfield {
	overflow-wrap: break-word; 
word-wrap: break-word;
word-break: break-all;
}
	</style>
</head>
<body id="pr_body">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<thead>
			<th>SNo</th>
			<th>Programme</th>
			<th>Donor</th>
			<th>Grant ID</th>
			<th>Budget Head</th>
			<th>Line Item</th>
			<th>Cost Item</th>
			<th>Additional Info</th>
			<?php if(php72_cmp($print_amt) == 1){?>
				<th>Assigned Amount INR</th>
				<th>Approval Notes INR</th>
				<th>Internal Notes INR</th>
				<th>Available Amount INR</th>
				<th>Unutilized Amount INR</th>
			<?php } ?>
		</thead>
		<tbody>
			<?php 
			$i = 1;
        foreach ($query as $row) {

            $assignAmountArray[] = $row['amount'];
            $assign_amt = formatnumber($row['amount']);

            $add_info_value = $this->Mmaster->getAdditionalInfo($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid']);
            $additional_info = $add_info_value['add_info_value']; 

            $approvalAmount = $this->Mmaster->checkApprovalNoteAmount($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid'], $fromperiod, $toperiod,$row['grant_id']);
            $approvalAmount = ($approvalAmount != '') ? round($approvalAmount, 2) : $approvalAmount;
            $approvalAmountArray[] = $approvalAmount;
            $approval_amt = formatnumber($approvalAmount);

            $internalAmount = $this->Mmaster->checkInternalAmount($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid'], $fromperiod, $toperiod,$row['grant_id']);
            $internalAmount = ($internalAmount != '') ? round($internalAmount, 2) : $internalAmount;
            $internalAmountArray[] = $internalAmount;
            $internal_amt = formatnumber($internalAmount);

            $recovered_amount = $this->Mmaster->checkRecoveredAmount($row['programme_id'], $row['donor_id'], $row['budget_id'], $row['line_itemid'], $row['subline_itemid'], $fromperiod, $toperiod,$row['grant_id']);
            $recoveredAmountArray[] = $recovered_amount;
            $recovered_amt = formatnumber($recovered_amount);

            $available = ($row['amount'] - ($approvalAmount)) + $recovered_amount;
            $availbleAmountArray[] = $available;
            $available_amt = formatnumber($available);

            $unuitizedAmount = $approvalAmount - ($internalAmount);
            $unutilizedamountArray[] = $unuitizedAmount;
            $unutilized_amt = formatnumber($unuitizedAmount);

            $nestedData = array();
            // $nestedData[] = '<input type="hidden" name="master_edit_id[]" id="master_edit_id_' . $i . '" value="' . $row['outward_id'] . '"><input class="form-control master_check" type="checkbox" name="master_check[]" id="master_check_' . $i . '" onchange="deleteids(this.value);" value="' . $i . '">';
            ?>
            <tr>
            <td><?= $i; ?></td>
            <td><?= $row['programme']; ?></td>
            <td><?= $row['master_name']; ?></td>
            <td><?= $row['grant_name']; ?></td>
            <td><?= $row['budget_head']; ?></td>
            <td><?= $row['line_item']; ?></td>
            <td><?= $additional_info; ?></td>
			<?php if(php72_cmp($print_amt) == 1){?>
				<td><?= $assign_amt; ?></td>
				<td><?= $approval_amt; ?></td>
				<td><?= $internal_amt; ?></td>
				<td><?= $recovered_amt; ?></td>
				<td><?= $available_amt; ?></td>
				<td><?= $unutilized_amt; ?></td>
			<?php } ?>
            </tr>
            <?php
            $i++;
        }
			 ?>
			
			
		</tbody>
	</table>

	
</body>

</html>