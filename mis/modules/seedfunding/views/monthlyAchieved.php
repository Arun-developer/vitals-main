<h1><?= $cpagetitle ?></h1>
<ul class="option-tab" style="margin-top:0px;">
    <li><a href="<?= site_url('reports/incubation_report/index/' . $innovation['id']); ?>" class="button">View Monthly Achevied</a></li>
    <li><a href="<?= site_url('seedfunding/view/' . $innovation['id']); ?>" class="button">Back</a></li>
</ul>
<br />
<br />

<table class="gtable sorttable">
    <thead>
        <tr>
            <th width="100">Goal</th>
            <th width="100">Milestone</th>
            <th width="300">Period</th>
            <th width="200">Progress</th>
            <th width="300">Status</th>
        </tr>
    </thead>
    <tbody id="activitiesTable">
        <?php
        if (php72_count($activitiesList)) {
            $rowtype = 'odd';
            foreach ($activitiesList as $row):
                ?>
                <tr>
                    <td align="left" valign="middle"><?= $row['goal'] ?></td>
                    <td align="left" valign="middle"> <?= $row['milestone'] ?></td>
                    <td align="left" valign="middle"> <?= $row['from'] ?> -  <?= $row['to'] ?></td>
                    <?php if (!in_array($this->session->userdata('user_type'), array('admin', 'ceo'))) { ?>
                        <td align="left" valign="middle">
                            <?php
                            $monthlyReport = $this->Mseedfunding->getTargetList($innovation['id'], $row['mid']);
                            if (php72_count($monthlyReport)) {
                                foreach ($monthlyReport as $mt):
                                    ?>
                                    <br/>
                                    <?php
                                endforeach;
                            }
                            ?>
                            <a href="<?= site_url('seedfunding/add_month_report/' . $innovation['id'] . '/' . $row['mid']) ?>" class="fancybox">Add Report</a></td>							<?php } ?>
                    <td align="left" valign="middle">

                        <?= $progressStatus[$row['progress_status']] ?>
                        <?php
                        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo'))) {

                            if ($row['progress_status'] != '1') {
                                ?>
                                <a href="<?= site_url('seedfunding/progress_status/' . $innovation['id'] . '/' . $row['mid'] . '/1') ?>">Completed</a> &nbsp; <?php
                            } if ($row['progress_status'] != '2') {
                                ?>
                                <a href="<?= site_url('seedfunding/progress_status/' . $innovation['id'] . '/' . $row['mid'] . '/2') ?>">Not Completed</a><?php
                            }
                        }
                        ?>
                    </td>
                </tr>
                <?php
            endforeach;
        } else {
            ?>
            <tr>
                <td colspan='7' align='center'>No Records found!</td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>
<!-- Paging style -->

