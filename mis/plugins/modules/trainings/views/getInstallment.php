<?php
$aisDomain = host_url() . "vital_ais/index.php/";
?>
<h1><?= $cpagetitle ?></h1>
<?php
if ($this->session->userdata('user_type') != 'incubatee') {
    ?>
    <h2>Approval Notes</h2>
    <?php foreach ($budgetList as $row1) { ?>
        <ul class="option-tab" style="margin-top:0px;">
            <li><a href="<?= $aisDomain ?>approvaluser/approval_form/add/mis/training/<?= $innovation['id'] ?>/<?= $row1['id'] ?>"
                   class="button">Request Approval Note</a></li>
            <li><a href="<?= site_url('training/budget/' . $innovation['id']); ?>" class="button">Back</a></li>
        </ul>
        <br />
        <br />

        <table id="table2" class="gtable detailtable">
            <thead>
                <tr>
                    <th width="100">Approval No</th>
                    <th width="100">Request Date</th>
                    <th width="200">Amount</th>
                    <th width="401">Status</th>
                </tr>
            </thead>
            <tbody id="activitiesTable">
                <?php
                if (count($approvalnoteList)) {
                    foreach ($approvalnoteList as $row) {
                        ?>
                        <tr>
                            <td align="left" valign="middle"><a
                                    href="<?= $aisDomain ?>approvaluser/approval_note_details/<?= $row['approval_id'] ?>"><?= $row['approval_no'] ?></a>
                            </td>
                            <td align="left" valign="middle" width="235"><?= mysql2date($row['date_of_request']) ?></td>
                            <td align="left" valign="middle"> <?= $row['amt_required'] ?></td>
                            <td align="left" valign="middle"> <?= $row['status'] ?>
                                <?php
                                if ($row['status'] == 'confirmed') {

                                    if ($row["internal_note"] == 'sent') {
                                        ?><a href="#" class="detail-link button">View Internal Note</a><?php
                                    }

                                    echo anchor($aisDomain . 'internaluser/send_internalnote/' . $row["approval_id"] . '/' . $innovation['id'] . '/' . $row1['id'], 'Send Internal Note', 'class="button"') . "&nbsp;&nbsp;";
                                }
                                ?></td>
                        </tr>
                        <?php
                        if ($row["internal_note"] == 'sent') {
                            $internalnoteList = $this->Mtraining->getInternalNote($row["approval_id"]);
                            ?>
                            <tr class="detail">
                                <td colspan="4">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Internal Note No</th>
                                                <th>Amount</th>
                                                <th>Request Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($internalnoteList as $int) { ?>
                                                <tr>
                                                    <td><a
                                                            href="<?= $aisDomain ?>internaluser/internal_note_details/<?= $int['internal_id'] ?>"><?= $int['internal_no'] ?></a>
                                                    </td>
                                                    <td><?= $int['amount_toapprove'] ?></td>
                                                    <td><?= mysql2date($int['date']) ?></td>
                                                    <td><?= $int['status'] ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan='4' align='center'>No Records found!</td>
                    </tr>
                </tbody>
            </table>
            <!-- Paging style -->
        <?php } ?>


        <br />
        <br />
        <table id="table2" class="gtable detailtable">
            <thead>
                <tr>
                    <th>Cheque Number</th>
                    <th>Cheque Date</th>
                    <th>Amount</th>

                </tr>
            </thead>
            <tbody id="activitiesTable">
                <?php
                if (count($approvalnoteList)) {
                    foreach ($approvalnoteList as $row):
                        if ($row["internal_note"] == 'sent') { //finance_status
                            $internalnoteList = $this->Mtraining->getInternalNote($row["approval_id"]);
                            foreach ($internalnoteList as $int):
                                ?>
                                <tr>
                                    <td><?= $int['check_no'] ?></td>
                                    <td><?= mysql2date($int['check_date']) ?></td>
                                    <td><?= $int['amount_toapprove'] ?></td>

                                </tr>
                                <?php
                            endforeach;
                        }
                    endforeach;
                }
                else {
                    ?>
                    <tr>
                        <td colspan='4' align='center'>No Records found!</td>
                    </tr>
                <? }
                ?>
            </tbody>
        </table>
    <?php } ?>
    <br />
    <br />
    <h2>Fund Utilization</h2>
    <ul class="option-tab" style="margin-top:0px;">
        <li><a href="<?= site_url('training/add_fundutilization/' . $innovation['id'] . '/' . $row1['id']); ?>"
               class="fancybox button">Add Fund Utilization</a></li>

    </ul>
    <br />
    <br />

    <table id="table2" class="gtable detailtable">
        <thead>
            <tr>
                <th width="100">Date</th>
                <th width="100">Amount Utilized</th>
                <th width="300">Document</th>
                <th width="401">Comments</th>
                <th width="100">Options</th>
            </tr>
        </thead>
        <tbody id="activitiesTable">
            <?php
            if (count($fundUtilizationList)) {
                foreach ($fundUtilizationList as $fu) {
                    ?>
                    <tr>
                        <td align="left" valign="middle"><?= mysql2date($fu['date']) ?></td>
                        <td align="left" valign="middle"><?= $fu['amount'] ?></td>
                        <td align="left" valign="middle">
                            <?php if ($fu['document']) { ?>
                                <a href="<?php echo base_url() . "uploads/fund_utilization/" . $fu['document']; ?>"
                                   target="_blank">&nbsp;&nbsp;<img src="<?= base_url(); ?>source/template/images/icons/download.gif"
                                                                 height="20" /> ( <?= $fu['document'] ?> )</a>
                                <?php } ?>
                        </td>
                        <td align="left" valign="middle"><?= $fu['comments'] ?></td>
                        <td align="left" valign="middle">


                            <a href="<?= site_url('training/add_fundutilization/' . $innovation['id'] . '/' . $budgetList['id'] . '/' . $fu["id"]) ?>"
                               class="fancybox"><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png"
                                                  title="Edit"></a>

                            <a href="javascript:void(0);"
                               url="<?= site_url('training/delete_fundutilization/' . $innovation['id'] . '/' . $budgetList['id'] . '/' . $fu["id"]) ?>"
                               class=" confirmDelete"><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png"
                                                        title="Delete"></a></td>
                    </tr>
                    <?php
                }
            }
        } else {
            ?>
            <tr>
                <td colspan='4' align='center'>No Records found!</td>
            </tr>
        <? }
        ?>
    </tbody>
</table>