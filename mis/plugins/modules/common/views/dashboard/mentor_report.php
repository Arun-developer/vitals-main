<div class="grid3">
    <h2>Mentor:</h2>
    <table width="100%" class="gtable" cellspacing="3" cellpadding="4">
        <thead>
            <tr>
                <th class="head headLARGE">Name of Incubatee</th>

                <th class="head headLARGE">Company</th>
                <th class="head headLARGE">Total Time spend(In Hours)</th>
                <th class="head headLARGE">Value (INR)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($mentordetails != 0)) {
                foreach ($mentordetails as $row):
                    ?>
                    <tr>
                        <td><?= $row['name_of_enterprise'] ?></td>
                        <td><?= $row['company'] ?></td>
                        <td><?= $row['mentorhours'] ?></td>
                        <td><?= $row['mentormoney'] ?></td>
                    </tr>
                    <?php
                endforeach;
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