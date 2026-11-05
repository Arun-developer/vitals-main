<?php

if (php72_count($mailDetails)) {
    foreach ($mailDetails as $row) {
        ?>
<h2><?=$row["subject"]?></h2>
<div id="user-grid" class="grid-view">
    <table width="80%" class="items">
        <tbody>
            <tr class="odd">
                <td align="left" valign="middle" style="width:10%"><strong>From</strong></td>
                <td align="left" valign="middle"><?=@$row["email"]?></td>
            </tr>
            <tr class="odd">
                <td align="left" valign="middle"><strong>Subject</strong></td>
                <td align="left" valign="middle"><?=$row["subject"]?></td>
            </tr>
            <tr class="even">
                <td align="left" valign="middle"><strong>Description</strong></td>
                <td align="left" valign="middle"><?=$row["description"]?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php
}
}
?>