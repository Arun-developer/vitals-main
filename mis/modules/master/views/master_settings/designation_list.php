<div id="form_employeelist" style="display:none;">
    <div align="center" id="form_container" style="width:400px; height:400px;" >
        <form action="<?php echo site_url('master/master_settings/addSectorIncharge'); ?>" id="assign" method="post">
            <select id="associate_employee" data-placeholder="Select Employee" multiple class="" style="width:350px;height:330px;" tabindex="1"  name="associate_employee[]">
                <?php foreach ($usersList as $row) { ?>
                    <option value="<?= $row['emp_number']; ?>" ><?= $row['emp_name']; ?></option>
                <?php } ?>
            </select>

            <input type="hidden" name="sector_value" id="sector_value" />
            <br/><br/>
            <div>
                <input type="submit" name="txtSubmit" class="button" id="txtsub" value="Submit"/>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <h1 style="margin: 15px 0 10px;"><?= $cpagetitle; ?></h1>
</div>

<br />
<div style=" float:right; text-align:right;width:100%;">
    <?php echo anchor("master/master_settings/portfolio_add/$currentTab", 'Add Masters', 'class="button"'); ?>
</div>
<br />

<table id="table1" class="gtable sortable">
    <thead>
        <tr>
            <th width="15%" nowrap="nowrap"><center>S.No</center></th>
<th width="25%" nowrap="nowrap"><center>Designation</center></th>
<?php if ($this->session->userdata['isSuperAdmin'] == 'Yes') { ?>
    <th width="20%" nowrap="nowrap"><center>Partner Type</center></th>
<?php } ?>
<th width="15%" nowrap="nowrap"><center>Status</center></th>
<th width="15%" nowrap="nowrap"><center>Action</center></th>
</tr>
</thead>
<tbody>
    <?php
    if (php72_count($jobList)) {
        $r = 1;
        foreach ($jobList as $master) {
            $row_type = ($r % 2 == 0) ? ('even') : ('odd');
            $r++;
            ?>
            <tr class="<?= $row_type ?>">
                <td align="center" valign="middle"><?= $r - 1; ?></td>
                <td align="center" valign="middle"><?= $master["name"]; ?></td>
                <?php
                if ($this->session->userdata['isSuperAdmin'] == 'Yes') {
                    $partner_data = $this->Mmaster_settings->getPartnerName($master['partner_id']);
                    ?>
                    <td align="center" valign="middle"><?= $partner_data[0]['branch_name']; ?></td>
                <?php } ?>
                <td align="center" valign="middle"><?php if ($master["status"] == '1') { ?>
                        <a href="<?= site_url('master/master_settings/portfolio_status/' . $currentTab . '/' . $master["id"] . '/2'); ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/active.png"></a>
                    <?php } else { ?>
                        <a href="<?= site_url('master/master_settings/portfolio_status/' . $currentTab . '/' . $master["id"] . '/1'); ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png"></a>
                    <?php } ?>
                </td>
                <td align="center" nowrap="nowrap">
                    <a href="<?= site_url('master/master_settings/portfolio_edit/' . $currentTab . '/' . $master["id"]); ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png"></a>
                    <a href="<?= site_url('master/master_settings/portfolio_delete/' . $currentTab . '/' . $master["id"]); ?>" class="confirmDelete"><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
                </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan='7' align='center'>No Records found!</td>
        </tr>
    <?php } ?>
</tbody>
</table>

