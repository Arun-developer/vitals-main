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
            <th width="3%" nowrap="nowrap"><center>S.No</center></th>
<th width="15%" nowrap="nowrap"><center>Sector</center></th>
<th width="3%" nowrap="nowrap"><center>Financial Year</center></th>
<?php if ($this->session->userdata['isSuperAdmin'] == 'Yes') { ?>
    <th width="10%" nowrap="nowrap"><center>Partner Type</center></th>
<?php } ?>
<th width="8%" nowrap="nowrap"><center>Application</center></th>
<th width="8%" nowrap="nowrap"><center>PA/RD</center></th>
<th width="8%" nowrap="nowrap"><center>Deals at IIC</center></th>
<th width="8%" nowrap="nowrap"><center>Deals at EIC</center></th>
<th width="8%" nowrap="nowrap"><center>Total Inc</center></th>
<th width="8%" nowrap="nowrap"><center>New Inc</center></th>
<th width="8%" nowrap="nowrap"><center>Exit Inc</center></th>
<th width="8%" nowrap="nowrap"><center>Status</center></th>
<th width="8%" nowrap="nowrap"><center>Action</center></th>
</tr>
</thead>
<tbody>
    <?php
    if (count($jobList)) {
        $r = 1;
        foreach ($jobList as $master) {
            $row_type = ($r % 2 == 0) ? ('even') : ('odd');
            $r++;
            $sector_data = $this->Mmaster_settings->getSectorName($master['sector']);
            ?>
            <tr class="<?= $row_type ?>">
                <td align="center" valign="middle"><?= $r - 1; ?></td>
                <td align="center" valign="middle"><?= $sector_data[0]["sector"]; ?></td>
                <td align="center" valign="middle"><?= $master["financial_year"]; ?></td>
                <?php
                if ($this->session->userdata['isSuperAdmin'] == 'Yes') {
                    $partner_data = $this->Mmaster_settings->getPartnerName($master['partner_id']);
                    ?>
                    <td align="center" valign="middle"><?= $partner_data[0]['branch_name']; ?></td>
                <?php } ?>
                <td align="center" valign="middle"><?= $master["app_annual"]; ?></td>
                <td align="center" valign="middle"><?= $master["pard_annual"]; ?></td>
                <td align="center" valign="middle"><?= $master["iic_annual"]; ?></td>
                <td align="center" valign="middle"><?= $master["eic_annual"]; ?></td>
                <td align="center" valign="middle"><?= $master["tot_annual"]; ?></td>
                <td align="center" valign="middle"><?= $master["new_annual"]; ?></td>
                <td align="center" valign="middle"><?= $master["ext_annual"]; ?></td>
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
