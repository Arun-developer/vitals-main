<h1 align="center"><?= $cpagetitle ?></h1>
<div style="height:400px; overflow:scroll; overflow-x:hidden">

    <table class="gtable detailtable" width="100%">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Document Description</th>
            </tr>
        </thead>

        <?php
        $key = 0;
        $na = '';
        foreach ($checkList as $row):
            $na_new = $row['master_name'];
            if ($na_new != $na) {
                $na = $na_new;
                $key = 0;
                ?>
                <tr>
                    <td colspan="3">
                        <h2><?= $row['master_name']; ?></h2>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td><?= ++$key; ?></td>
                <td>
                    <p style="width:520px; white-space:initial;"><?php echo $row['document_description']; ?></p>
                </td>
                <td>&nbsp;</td>
            </tr>
        <?php endforeach; ?>
        <tr class="odd">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

    </table>
</div>

<div class="divExport">
    <a class="button"
       href="<?php echo 'http://' . $_SERVER['HTTP_HOST']; ?>/vital/index.php/detailed_diligence/export_checklist"
       style=" cursor:pointer;">Export</a>
</div>