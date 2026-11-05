<?php
$nullLink = "javascript:void(0);";
?>

<h1><?= $cpagetitle ?></h1>


<br />

<ul class="option-tab" style="margin-top:0px;">

    <li><?php echo anchor('master/mentor/add/', 'Add Mentor', 'class="button"'); ?></li>
</ul>
<br /><br/>
<!--start table-content  -->


<div id="user-grid" class="gtable sortable">
    <table width="100%" class="items">
        <thead>
            <tr>
                <th><a href="<?= $nullLink ?>" field="label">Sector</a></th>
                <th><a href="<?= $nullLink ?>" field="label">Mentor Name</a></th>
                <th><a href="<?= $nullLink ?>" field="required">Mobile</a></th>
                <th><a href="<?= $nullLink ?>" field="value">Email</a></th>
                <th><a href="<?= $nullLink ?>" field="status">View</a></th>

                <th><a href="<?= $nullLink ?>" field="status">Action</a></th>

            </tr>
        </thead>
        <tbody>
            <?php
            if (php72_count($mentorList)) {
                $r = 1;
                foreach ($mentorList as $row) {
                    $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                    $r++;
                    ?>
                    <tr class="<?= $row_type ?>">
                        <td align="left" valign="middle"><?= $row["sector"]; ?></td>
                        <td align="left" valign="middle"><?= $row["first_name"]; ?></td>
                        <td align="left" valign="middle"><?= $row["mobile"]; ?></td>
                        <td align="left" valign="middle"><?= $row["email"]; ?></td>

                        <td nowrap="nowrap" >
                            <a class="fancybox" href="<?= site_url('master/mentor/viewprofile/' . $row["id"]) ?>" >View Profile</a>
                        </td>

                        <td colspan='3' align="left" valign="middle" >
                            <?php if ($row["status"] == '1') {
                                ?>
                                <a href="<?= site_url('master/mentor/changestatus/' . $row["id"] . '/0') ?>" >
                                    <img src="<?php echo base_url(); ?>source/template/images/icons/active.png" title="Active"></a>&nbsp;

                            <?php } else {
                                ?>

                                <a  href="<?= site_url('master/mentor/changestatus/' . $row["id"] . '/1') ?>" >
                                    <img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png" title="Inactive"></a>&nbsp;

                            <?php }
                            ?>

                            <a  href="<?= site_url('master/mentor/edit/' . $row['id']) ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>&nbsp;
                            <a href="javascript:void(0);" url="<?= site_url('master/mentor/delete/' . $row['id']) ?>"
                               class="confirmDelete"  ><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete"></a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan='9' align='center'>No Records found!</td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
    <!-- Paging style -->
</div>
