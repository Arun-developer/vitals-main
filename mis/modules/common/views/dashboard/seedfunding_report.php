<h2><?php echo $cpagetitle; ?> </h2>
<table width="100%" class="gtable" cellspacing="3" cellpadding="4">
    <thead>
        <tr>
            <th class="head headLARGE">Name of Incubatee</th>
            <th class="head headLARGE">Total Fund Disbursed</th>
            <th class="head headLARGE">Total Fund Approved</th>
            <th class="head headLARGE">Total Fund Utilized</th>
        </tr>
    </thead>
    <tbody>


        <?php
        if (count($allfunddisbursed)) {
            $i = 'odd';
            foreach ($allfunddisbursed as $row):
                $i = ($i == 'odd') ? 'even' : 'odd';
                ?>
                <tr class="<?= $i ?>">
                    <td><a href="<?php echo site_url('incubator_metrics/wglobal_report/index/' . $row['id'] . '/2') ?>">
                            <?= $row['name_of_enterprise'] ?>
                        </a></td>
                    <td><?= $row['amount'] ?></td>
                    <td><?= $row['approved_amount'] ?></td>
                    <td><?= $row['fund_utilized'] ?></td>
                </tr>
                <?php
                $total += $row['amount'];
                $total_approved += $row['approved_amount'];
                $total_utilized += $row['fund_utilized'];
            endforeach;
            ?>
            <tr>
                <td>Total :</td>
                <td style="font-weight:bold;"><?= $total; ?></td>
                <td style="font-weight:bold;"><?= $total_approved; ?></td>
                <td style="font-weight:bold;"><?= $total_utilized; ?></td>
            </tr>
            <?php
        }
        else {
            ?>
            <tr class="odd">
                <td colspan="10" align="center">No Records</td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$header = NULL;

$td = '<table width="100%" class="gtable" cellspacing="3" cellpadding="4">';
$td .= '<th class="" style="background:url(../../../source/template/images/head_table_1px.gif);border-right:1px solid #DBDBD9;border-bottom:1px solid #DBDBD9;">Amout</th>';
$td .= '<th class="" style="background:url(../../../source/template/images/head_table_1px.gif);border-right:1px solid #DBDBD9;border-bottom:1px solid #DBDBD9;">Reqeusted Date</th>';
$td .= '<th class="" style="background:url(../../../source/template/images/head_table_1px.gif);border-right:1px solid #DBDBD9;border-bottom:1px solid #DBDBD9;">Innovation</th>';
$td .='<th style="background:url(../../../source/template/images/head_table_1px.gif);border-right:1px solid #DBDBD9;border-bottom:1px solid #DBDBD9;"></th>';
$this->load->model('common/Mincubation_reports');
foreach ($seedfunding_report as $row) {
    $td.="<tr>";
    $td.="<td>" . $row['amount'] . "</td>";
    $td.="<td>" . $row['date'] . "</td>";
    $td.="<td>" . $row['name_of_enterprise'] . "</td>";
    $td.="<td></td>";
    $td.="</tr>";
}
$td .= '</table>';
echo $td;
?>
