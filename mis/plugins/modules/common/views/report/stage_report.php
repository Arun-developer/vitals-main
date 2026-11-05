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

            <th><a href="<?= $nullLink ?>" field="name_of_enterprise" class="sortlink">Name of the Incubatee</a></th>
            <th><a href="<?= $nullLink ?>" field="name_of_enterprise" class="sortlink">Name of the Promoter</a></th>
            <th><a href="<?= $nullLink ?>" field="created_date" class="sortlink">Date Applied</a></th>
            <th><a href="<?= $nullLink ?>" field="entry_date" class="sortlink">Date Of Entry</a></th>
            <th><a href="<?= $nullLink ?>" field="created_date" class="">Time Taken(New - Entry)</a></th>
            <th><a href="<?= $nullLink ?>" field="created_date" class="">Date Of Lead</a></th>
            <th><a href="<?= $nullLink ?>" field="entry_lead" class="sortlink">Time Taken(Entry - Lead)</a></th>
            <th><a href="<?= $nullLink ?>" field="created_date" class="">No. Of Incharge</a></th>
        </tr>

    </thead>
    <tbody>
        <?php
        if (count($innovationList)) {
            $i = 'odd';
            foreach ($innovationList as $row):
                $i = ($i == 'odd') ? 'even' : 'odd';
                ?>
                <tr class="<?= $i ?>">
                    <td><a href="<?= site_url('scouting/innovation_details/' . $row['id']); ?>" ><?= $row['name_of_enterprise'] ?></a></td>
                    <td><?= $row['name_of_entrepreneur'] ?></td>
                    <td><?= mysql2date($row['created_date']) ?></td>
                    <td><?= mysql2date($row['entry_date']) ?></td>
                    <td><?= $row['new_entry'] ?></td>
                    <td><?= mysql2date($row['lead_date']) ?></td>
                    <td><?= $row['entry_lead'] ?></td>
                    <td><?= $row['no_of_incharge'] ?></td>
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
