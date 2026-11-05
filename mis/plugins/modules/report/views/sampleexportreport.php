<?php
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=approval_note.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<div class="table_section ">
    <table class="gtable" width="100%" border="0" cellspacing="0" cellpadding="0" >
        <tr>
            <th width="14%" style="font-weight:bold;">Programme</font></th>
            <th width="14%" style="font-weight:bold;">AN No</font></th>
            <th width="14%" style="font-weight:bold;">AN Date</font></th>
            <th width="14%" style="font-weight:bold;">AN Purpose</font></th>
            <th width="14%" style="font-weight:bold;">IN No</font></th>
            <th width="14%" style="font-weight:bold;">IN Date</font></th>
            <th width="14%" style="font-weight:bold;">IN Purpose</font></th>
            <th width="14%" style="font-weight:bold;">AN Amount</font></th>
            <th width="14%" style="font-weight:bold;">IN Amount</font></th>
            <th width="14%" style="font-weight:bold;">Remaining Amount</font></th>
        </tr>
        <?php
        $na = '';
        foreach ($amount as $row) {
            $amount_diff = $row['total_amount'] - $row['amount_utilized'];
            ?>
            <tr>
                <td> <?php echo $row['programme']; ?> </td>
                <td> <?php echo $row['approval_no']; ?> </td>
                <td> <?php echo date('d-m-Y', strtotime($row['date_of_request'])); ?> </td>
                <td> <?php echo $row['purpose']; ?> </td>
                <td> <?php echo $row['internal_no']; ?> </td>
                <td> <?php echo date('d-m-Y', strtotime($row['date'])); ?> </td>
                <td> <?php echo $row['reason_payment_sougnt']; ?> </td>
                <td> <?php echo $row['total_amount']; ?> </td>
                <td> <?php echo $row['amount_utilized']; ?> </td>
                <td> <?php echo $amount_diff; ?> </td>
            </tr>
        <?php } ?>
    </table>
    <br>
</div>
