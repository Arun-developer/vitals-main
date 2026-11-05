<?php
$currency = $this->session->userdata['currency'];
?>
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
            <tr>
                <td>
                    <div class="logo">
                        <img src="https://mis.villgroapps.org/mis_master/source/template/images/logo.png" alt="Villgro Logo" />
                    </div>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <h2>Grant Information</h2>
                </td>
            </tr>
            <tr>
                <td style="text-align:left;">
                    <h4 style="margin: 0; padding:8px ; font-size:18px;">Grant Details</h4>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 1px solid #ccc; margin-bottom:20px;">
                        <tr>
                            <td style="width:20%; padding:8px; border-bottom:2px solid #2a7d47"><b>Funder Name</b></td>
                            <td style="width:10%;padding:8px ; border-bottom:2px solid #2a7d47"><b>Grant Name</b></td>
                            <td style="width:13%;padding:8px ;border-bottom:2px solid #2a7d47"><b>Grant Signed Date</b></td>
                            <td style="width:10%;padding:8px ; border-bottom:2px solid #2a7d47"><b>Grant Start Date</b></td>
                            <td style="width:10%;padding:8px ; border-bottom:2px solid #2a7d47"><b>Grant End Date</b></td>
                            <td style="width:12%;padding:8px ; border-bottom:2px solid #2a7d47"><b>Grant Amount (<?= $currency; ?>)</b></td>
                            <td style="width:10%;padding:8px ; border-bottom:2px solid #2a7d47"><b>Status</b></td>
                            <td style="width:15%;padding:8px ; border-bottom:2px solid #2a7d47"><b>Purpose</b></td>
                        </tr>
                        <tr>
                            <?php
                            if (!empty($grant_list)) {
                                foreach ($grant_list as $list) {
                                    ?>
                                    <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->funder_name) && $list->funder_name != '') echo $list->funder_name; ?></td>
                                    <td style="width:100px;padding:8px ;border-bottom:1px solid #ccc; white-space:pre-line;word-break: break-all;word-wrap: break-word;overflow-wrap: break-word; "><p><?php if (isset($list->name) && $list->name != '') echo $list->name; ?></p></td>
                                    <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->signed_date) && $list->signed_date != '') echo date('d-m-Y', strtotime($list->signed_date)); ?></td>
                                    <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->start_date) && $list->start_date != '') echo date('d-m-Y', strtotime($list->start_date)); ?></td>
                                    <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->end_date) && $list->end_date != '') echo date('d-m-Y', strtotime($list->end_date)); ?></td>
                                    <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->grant_amount) && $list->grant_amount != '') echo $list->grant_amount; ?></td>
                                    <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->status_type) && $list->status_type != '') echo ucfirst($list->status_type); ?></td>
                                    <td style="padding:8px ;border-bottom:1px solid #ccc;white-space:pre-line;word-break: break-all;word-wrap: break-word;overflow-wrap: break-word; "><?php if (isset($list->purpose) && $list->purpose != '') echo ucfirst($list->purpose); ?></td>
                                    <?php
                                }
                            }
                            ?>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align:left;">
                    <h4 style="margin: 0; padding:8px ; font-size:18px;"><b>Grant Line Items</b></h4>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 1px solid #ccc; margin-bottom:20px;">
                        <tr>
                            <td width="25%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Budget Head</b></td>
                            <td width="25%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Line Item</b></td>
                            <td width="25%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Amount (<?= $currency; ?>)</b></td>
                            <td width="25%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Comments</b></td>
                        </tr>
                        <?php
                        $gl_amount = 0.00;
                        if (!empty($grant_line)) {
                            foreach ($grant_line as $list) {
                                ?>
                                <tr>
                                    <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->budget_head_id) && $list->budget_head_id != '') echo $list->budget_head_id; ?></td>
                                    <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->lineitem_id) && $list->lineitem_id != '') echo $list->lineitem_id; ?></td>
                                    <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->amount) && $list->amount != '') echo $list->amount; ?></td>
                                    <td style="padding:8px ;border-bottom:1px solid #ccc;white-space:pre-line;word-break: break-all;word-wrap: break-word;overflow-wrap: break-word; "><?php if (isset($list->comments) && $list->comments != '') echo $list->comments; ?></td>
                                </tr>
                                <?php
                                $gl_amount += $list->amount;
                                if ($gl_amount == 0) {
                                    $gl_amount = '0.00';
                                }
                            }
                        }
                        ?>
                        <tr>
                            <td style="padding:8px ;border-bottom:1px solid #ccc"><b>Total</b></td>
                            <td style="padding:8px ;border-bottom:1px solid #ccc"></td>
                            <td style="padding:8px ;border-bottom:1px solid #ccc"><b><?php echo $gl_amount; ?><b></td>
                                        <td style="padding:8px ;border-bottom:1px solid #ccc;white-space:pre-line;word-break: break-all;word-wrap: break-word;overflow-wrap: break-word; "></td>
                                        </tr>
                                        </table>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left;">
                                                <h4 style="margin: 0; padding:8px ; font-size:18px;">Disbursement Schedule</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 1px solid #ccc; margin-bottom:20px;">
                                                    <tr>
                                                        <td width="25%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Milestone</b></td>
                                                        <td width="15%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Date of Disbursement</b></td>
                                                        <td width="15%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Amount (<?= $currency; ?>)</b></td>
                                                        <td width="15%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Date of Deposit</b></td>
                                                        <td width="15%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Amount Deposited (<?= $currency; ?>)</b></td>
                                                        <td width="15%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Comments</b></td>
                                                    </tr>
                                                    <?php
                                                    $disb_amt = 0.00;
                                                    $disb_amt_dop = 0.00;
                                                    if (!empty($disb_schedule)) {
                                                        foreach ($disb_schedule as $list) {
                                                            ?>
                                                            <tr>
                                                                <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->milestone) && $list->milestone != '') echo $list->milestone; ?></td>
                                                                <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->date_of_disbursement) && $list->date_of_disbursement != '' && $list->date_of_disbursement > 0) echo date('d-m-Y', strtotime($list->date_of_disbursement)); ?></td>
                                                                <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->amount) && $list->amount != '') echo $list->amount; ?></td>
                                                                <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->date_of_deposite) && $list->date_of_deposite != '' && $list->date_of_deposite > 0) echo date('d-m-Y', strtotime($list->date_of_deposite)); ?></td>
                                                                <td style="padding:8px ;border-bottom:1px solid #ccc"><?php if (isset($list->amount_deposite) && $list->amount_deposite != '') echo $list->amount_deposite; ?></td>
                                                                <td style="padding:8px ;border-bottom:1px solid #ccc;white-space:pre-line;word-break: break-all;word-wrap: break-word;overflow-wrap: break-word; "><?php if (isset($list->comments) && $list->comments != '') echo $list->comments; ?></td>
                                                            </tr>
                                                            <?php
                                                            $disb_amt += $list->amount;
                                                            $disb_amt_dop += $list->amount_deposite;

                                                            if ($disb_amt == 0) {
                                                                $disb_amt = '0.00';
                                                            }
                                                            if ($disb_amt_dop == 0) {
                                                                $disb_amt_dop = '0.00';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td style="padding:8px ;border-bottom:1px solid #ccc"><b>Total</b></td>
                                                        <td style="padding:8px ;border-bottom:1px solid #ccc"></td>
                                                        <td style="padding:8px ;border-bottom:1px solid #ccc"><b><?php echo $disb_amt; ?></b></td>
                                                        <td style="padding:8px ;border-bottom:1px solid #ccc"></td>
                                                        <td style="padding:8px ;border-bottom:1px solid #ccc"><b><?php echo $disb_amt_dop; ?></b></td>
                                                        <td style="padding:8px ;border-bottom:1px solid #ccc;white-space:pre-line;word-break: break-all;word-wrap: break-word;overflow-wrap: break-word; "></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left;">
                                                <h4 style="margin: 0; padding:8px ; font-size:18px;">Grant Reports</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 1px solid #ccc; margin-bottom:20px;">
                                                    <tr>
                                                        <td width="18%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Due Date</b></td>
                                                        <td width="18%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Submitted date</b></td>
                                                        <td width="19%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Responsibility</b></td>
                                                        <td width="20%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Comments</b></td>
                                                        <td width="25%" style="padding:8px; border-bottom:2px solid #2a7d47"><b>Document</b></td>
                                                    </tr>
                                                    <?php
                                                    if (!empty($grant_reports)) {
                                                        foreach ($grant_reports as $list) {
                                                            ?>
                                                            <tr>
                                                                <td style="padding:8px ; border-bottom:1px solid #ccc"><?php if (isset($list->date_of_report) && $list->date_of_report != '' && $list->date_of_report > 0) echo date('d-m-Y', strtotime($list->date_of_report)); ?></td>
                                                                <td style="padding:8px ; border-bottom:1px solid #ccc"><?php if (isset($list->submit_date) && $list->submit_date != '' && $list->submit_date > 0) echo date('d-m-Y', strtotime($list->submit_date)); ?></td>
                                                                <td style="padding:8px ; border-bottom:1px solid #ccc"><?php if (isset($list->responsibility) && $list->responsibility != '') echo $responsibility[$list->responsibility]; ?></td>
                                                                <td style="padding:8px ; border-bottom:1px solid #ccc;white-space:pre-line;word-wrap: break-word;word-break: break-all;overflow-wrap: break-word; "><?php if (isset($list->comments) && $list->comments != '') echo $list->comments; ?></td>
                                                                <td style="padding:8px ; border-bottom:1px solid #ccc"><?php if (isset($list->file_name) && $list->file_name != '') echo substr($list->file_name, -35); ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </table>
                                            </td>
                                        </tr>
                                        </table>
                                        </body>
                                        </html>