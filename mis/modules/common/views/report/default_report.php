<?php
$nullLink = "javascript:void(0);";
?>
<div style=" float:right; text-align:right;width:100%;">
    <a href="<?= $nullLink ?>" class="button toggleSearch">Show Search</a>&nbsp;&nbsp;

    <?php $this->Mexport->exportOption('innovation', $form_name); ?>
</div>
<br /><br />

<table class="gtable sortable">
    <thead>
        <tr>
            <th><a href="<?= $nullLink ?>" field="source" class="sortlink">Source</a></th>
            <th><a href="<?= $nullLink ?>" field="name_of_enterprise" class="sortlink">Name of the Incubatee</a></th>
            <th><a href="<?= $nullLink ?>" field="created_date" class="sortlink">Date Applied</a></th>
            <th><a href="#">Assigned to</a></th>
            <th><a href="<?= $nullLink ?>" field="stage" class="sortlink">Stage</a></th>
            <th><a href="<?= $nullLink ?>" field="status" class="sortlink">Status</a></th>
            <th><a href="<?= $nullLink ?>" field="incubation_cycle" class="sortlink">Incubation Cycle</a></th>
            <th><a href="<?= $nullLink ?>" field="reference" class="sortlink">Reference</a></th>
            <th><a href="<?= $nullLink ?>" field="reference" class="sortlink">Email Address</a></th>
        </tr>

    </thead>
    <tbody>
        <?php
        if (php72_count($innovationList)) {
            $i = 'odd';
            foreach ($innovationList as $row):
                $i = ($i == 'odd') ? 'even' : 'odd';
                ?>
                <tr class="<?= $i ?>">
                    <td><?= $row['source_name']; ?></td>
                    <td><a href="<?= site_url('scouting/innovation_details/' . $row['id']); ?>" ><?= $row['name_of_enterprise'] ?></a></td>
                    <td><?= mysql2date($row['created_date']) ?></td>
                    <td width="150"><?= $row['associate_emp_name'] ?></td>
                    <td><?= $stage[$row['stage']] ?></td>
                    <td><?= $status[$row['status']] ?></td>
                    <td><?= $row['incubation_cycle_title'] ?></td>
                    <td><?= $row['reference'] ?></td>
                    <td><?= $row['email_id'] ?></td>
                </tr>
                <?php
            endforeach;
        }
        else {
            ?>
            <tr class="odd"><td colspan="10" align="center">No Records</td></tr>
        <?php } ?>

    </tbody>
</table>
<!-- Paging style -->
<?php echo $this->pagination->create_links($form_name); ?>
