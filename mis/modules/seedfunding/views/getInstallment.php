<?php
$aisDomain = "ais.villgroapps.org/index.php/";
?>
<h1><?= $cpagetitle ?> ( <?= $installmentDetails['from'] . ' - ' . $installmentDetails['to'] ?> ) (
    <?= formatnumber($installmentDetails['vfunded']) ?> )</h1>
<?php
if ($this->session->userdata('user_type') != 'incubatee') {
    ?>
    <h2>Approval Notes</h2>
    <ul class="option-tab" style="margin-top:0px;">
        <form action="<?php echo host_url(); ?>vital_ais/index.php/login/index" method="post">
            <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]" />
            <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]" />
            <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]" />
            <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]" />
            <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]" />
            <input type="hidden" value="<?= $innovation['id'] ?>" name="seesion[innovation]" />
            <input type="hidden" value="<?= $installmentDetails['id']; ?>" name="seesion[installment]" />
            <input type="hidden" value="<?= $installmentDetails['vfunded']; ?>" name="seesion[amount]" />
            <input type="hidden" value="seedfunding" name="seesion[requests]" />
            <input type="submit" name="txsubmit" value="Request Approval Note" class="button" />
        </form>

        <li><a href="<?= site_url('seedfunding/view/' . $innovation['id']); ?>" class="button">Back</a></li>
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
                foreach ($approvalnoteList as $row):
                    ?>
                    <tr>
                        <td align="left" valign="middle"><a
                                href="<?php echo host_url(); ?>vital_ais/index.php/approvaluser/approval_note_details/<?= $row['approval_id'] ?>"><?= $row['approval_no'] ?></a>
                        </td>
                        <td align="left" valign="middle" width="235"><?= mysql2date($row['date_of_request']) ?></td>
                        <td align="left" valign="middle"> <?= formatnumber($row['amt_required']) ?></td>
                        <td align="left" valign="middle"> <?= $row['status'] ?>
                            <?php
                            if ($row['status'] == 'confirmed') {

                                if ($row["internal_note"] == 'sent') {
                                    ?><a href="#" class="detail-link button">View Internal
                                        Note</a><?php
                                }

                                echo anchor('<?php echo host_url(); ?>vital_ais/index.php/internaluser/send_internalnote/' . $row["approval_id"] . '/' . $innovation['id'] . '/' . $installmentDetails['id'], 'Send
                Internal Note', 'class="button"') . "&nbsp;&nbsp;";
                            }
                            ?></td>
                    </tr>
                    <?php
                    if ($row["internal_note"] == 'sent') {
                        $internalnoteList = $this->Mseedfunding->getInternalNote($row["approval_id"]);
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
                                        <?php foreach ($internalnoteList as $int): ?>
                                            <tr>
                                                <td><a href="<?php echo host_url(); ?>vital_ais/index.php/internaluser/internal_note_details/<?= $int['internal_id'] ?>"><?= $int['internal_no'] ?></a>
                                                </td>
                                                <td><?= formatnumber($int['amount_toapprove']) ?></td>
                                                <td><?= mysql2date($int['date']) ?></td>
                                                <td><?= $int['status'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php
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
    <!-- Paging style -->
<?php } ?>
<h2>Amount Released</h2>
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
                    $internalnoteList = $this->Mseedfunding->getInternalNote($row["approval_id"]);
                    foreach ($internalnoteList as $int):
                        ?>
                        <tr>
                            <td><?= $int['check_no'] ?></td>
                            <td><?= mysql2date($int['check_date']) ?></td>
                            <td><?= formatnumber($int['amount_toapprove']) ?></td>

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

<br />
<br />
<h2>Fund Utilization Report</h2>
<?php if ($this->session->userdata('user_type') == 'incubatee') {
    ?>
    <ul class="option-tab" style="margin-top:0px;">
        <li><a href="<?= site_url('seedfunding/add_fundutilization/' . $innovation['id'] . '/' . $installmentDetails['id']); ?>"
               class="fancybox button">Add Fund Utilization</a></li>
    </ul>
<?php } ?>
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
            foreach ($fundUtilizationList as $fu):
                ?>
                <tr>
                    <td align="left" valign="middle"><?= mysql2date($fu['date']) ?></td>
                    <td align="left" valign="middle"><?= formatnumber($fu['amount']) ?></td>
                    <td align="left" valign="middle">
                        <?php
                        if ($fu['document']) {
                            $document = explode(',', $fu['document']);
                            for ($i = 0; $i < count($document); $i++) {
                                ?>
                                <a href="<?php echo base_url() . "uploads/" . $document[$i]; ?>" target="_blank">&nbsp;&nbsp;<img
                                        src="<?= base_url(); ?>source/template/images/icons/download.gif" height="20" />
                                    <?= $document[$i]; ?><br /> </a>
                            <?php
                            }
                        }
                        ?>
                    </td>
                    <td align="left" valign="middle"><?= $fu['comments'] ?></td>
                    <td align="left" valign="middle">


                        <a href="<?= site_url('seedfunding/add_fundutilization/' . $innovation['id'] . '/' . $installmentDetails['id'] . '/' . $fu["id"]) ?>"
                           class="fancybox"><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png"
                                              title="Edit"></a>

                        <a href="javascript:void(0);"
                           url="<?= site_url('seedfunding/delete_fundutilization/' . $innovation['id'] . '/' . $installmentDetails['id'] . '/' . $fu["id"]) ?>"
                           class=" confirmDelete"><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png"
                                                    title="Delete"></a></td>
                </tr>
                <?php
            endforeach;
        } else {
            ?>
            <tr>
                <td colspan='4' align='center'>No Records found!</td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>