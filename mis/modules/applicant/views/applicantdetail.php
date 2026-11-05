<?php
$nullLink = "javascript:void(0);";

if (count($applicantDetails) > 0) {
    $val = array();
    $val = $applicantDetails[0];
}
?>
<input type="hidden" name="innovationid" value="<?php echo $innovationid; ?>" />
<h1><?= $cpagetitle ?></h1>

<br />

<!--start table-content  -->

<div id="user-grid" class="gtable sortable">

    <table class="gtable sortable">
        <tbody>
            <tr>
                <td width="22%">Request No. </td>
                <td width="78%"><?php echo $val['request_applicantnumber']; ?></td>
            </tr>
            <tr>
                <td>Education</td>
                <td><?php echo $val['education']; ?></td>
            </tr>
            <tr>
                <td>Experience</td>
                <td><?php echo $val['experience']; ?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><?php echo $val['description']; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<br/><br/>
<div id="user-grid" class="gtable sortable">

    <ul class="option-tab" style="margin-top:0px;">
        <li><?php echo anchor('applicant/add/' . $innovationid . '/' . $val['id'], 'Add Applicant', 'class="button"'); ?></li>
    </ul>
    <br /><br/>

    <table width="100%" class="items">
        <thead>
            <tr>
                <th><a href="<?= $nullLink ?>" field="label">Applicant Name</a></th>
                <th><a href="<?= $nullLink ?>" field="label">Applicant Comments</a></th>
                <th><a href="<?= $nullLink ?>" field="required">Applicant Status</a></th>
                <th><a href="<?= $nullLink ?>" field="value">Interview</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($applicantList)) {
                $r = 1;
                foreach ($applicantList as $row) {
                    $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                    $r++;
                    ?>
                <td align="left" valign="middle"><?= $row["first_name"]; ?></td>
                <tr class="<?= $row_type ?>">
                    <td align="left" valign="middle">Comments</td>

                    <td align="left" valign="middle"><?= $row["mobile"]; ?></td>
                    <td align="left" valign="middle"><?= $row["email"]; ?></td>

                    <td nowrap="nowrap" >
                        <a class="fancybox" href="<?= site_url('master/applicant/viewprofile/' . $row["id"]) ?>" >View Profile</a>
                    </td>

                    <td colspan='3' align="left" valign="middle" >
                        <?php if ($row["status"] == '1') {
                            ?>
                            <a href="<?= site_url('master/applicant/changestatus/' . $row["id"] . '/0') ?>" >
                                <img src="<?php echo base_url(); ?>source/template/images/icons/active.png" title="Active"></a>&nbsp;

                        <?php } else {
                            ?>

                            <a  href="<?= site_url('master/applicant/changestatus/' . $row["id"] . '/1') ?>" >
                                <img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png" title="Inactive"></a>&nbsp;

                        <?php }
                        ?>

                        <a  href="<?= site_url('master/applicant/edit/' . $row['id']) ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>&nbsp;
                        <a href="javascript:void(0);" url="<?= site_url('master/applicant/delete/' . $row['id']) ?>"
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
        <?php } ?>
        </tbody>
    </table>



</div>
