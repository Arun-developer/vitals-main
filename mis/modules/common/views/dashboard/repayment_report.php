<div class="grid4 ">
    <h2>Repayment:</h2>
    <table width="100%" class="gtable" cellspacing="3" cellpadding="4">
        <thead>
            <tr>
                <th class="head headLARGE">Name of Incubatee</th>
                <th class="head headLARGE">Total Repayment amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (php72_count($allrepayment)) {
                $i = 'odd';
                foreach ($allrepayment as $row):
                    $i = ($i == 'odd') ? 'even' : 'odd';
                    ?>
                    <tr class="<?= $i ?>">
                        <td><a href="<?php echo site_url('incubator_metrics/wglobal_report/index/' . $row['id'] . '/2') ?>">
                                <?= $row['name_of_enterprise'] ?>
                            </a></td>
                        <td><?= $row['amount'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                <tr>
                    <td>Total :</td>
                    <?php foreach ($repayment as $row): ?>
                        <td><?= $row['total']; ?></td>
                    <?php endforeach; ?>
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
</div>