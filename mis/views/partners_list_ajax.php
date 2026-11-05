<table id="partnersTable">
    <thead style="border-bottom: 1px solid #000;">
        <tr>
            <th>Partner</th>
            <th>INV ID</th>
            <th>Name of Incubatee</th>
            <th>Name of Entrepreneur</th>
            <th>Sector</th>
            <th>Stage</th>
            <th>Status</th>
            <th>Registered Date</th>
            <th>Email ID</th>
            <th>Phone Number</th>
            <th>Submitted Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (php72_count($partnersList) > 0) {
            $name = isset($pa_entreprise) && $pa_entreprise != '' ? $pa_entreprise : 1;
            $ent_name = isset($pa_entrepreneur) && $pa_entrepreneur != '' ? $pa_entrepreneur : 1;
            $ent_email = isset($pa_email) && $pa_email != '' ? urlencode($pa_email) : 1;
            $downloadLink = 'scouting/export_partners/' . $name . '/' . $ent_name . '/' . $ent_email;
            ?>
        <a href="<?= site_url($downloadLink); ?>" id="popup_export" class="button popup_export">Export</a>
        <?php
        foreach ($partnersList as $r) {
            ?>
            <tr>
                <td><?= $r['partnersList']; ?></td>
                <td><?= $r['inv_id']; ?></td>
                <td><?= $r['enterprise']; ?></td>
                <td><?= $r['entrepreneur']; ?></td>
                <td><?= $r['sector']; ?></td>
                <td><?= $r['stage']; ?></td>
                <td><?= $r['status_text']; ?></td>
                <td><?= $r['identified_date']; ?></td>
                <td><?= $r['email']; ?></td>
                <td><?= $r['phone']; ?></td>
                <td><?= $r['submitted_date']; ?></td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="10" style='margin-top:5px;text-align:center;font-weight:bold;font-size:14px;color:#3b6e22'>
                <?= 'Search result not found'; ?></td>
        </tr>
    <?php } ?>

</tbody>
</table>

<style type="css/text">
    table th {
        background-color: #ddd;
    }
    table td {
        border-bottom:1px solid #ddd;
    }

</style>