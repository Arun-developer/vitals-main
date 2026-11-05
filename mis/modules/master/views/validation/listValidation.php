<?php
$nullLink = 'javascript:void(0);';
$form_name = 'means_validation';
?>
<h1><?= $cpagetitle ?></h1>
<form id="<?= $form_name ?>" action="<?= site_url('master/means_validation/view_list') ?>" method="post" name="<?= $form_name ?>">
    <input type="hidden"  name="ordertype" value="<?= $ordertype ?>"  />
    <input type="hidden"  name="orderby" value="<?= $orderby ?>"  />
    <div class="searchBox" style=" <?= ($_POST) ? '' : 'display:none;' ?>"  >
        <dl class="inline">
            <dt><label for="criteria">Criteria:</label></dt>
            <dd>
                <?php $criteria = isset($_REQUEST["criteria"]) ? $_REQUEST["criteria"] : ""; ?>
                <select name="criteria">
                    <option value="">Select</option>
                    <?php foreach ($criteriaList as $row) { ?>
                        <option value="<?= $row['id'] ?>" <?php echo ($criteria == $row['id']) ? ('selected') : (''); ?>><?= $row['master_name'] ?></option>
                    <?php } ?>
                </select>
            </dd>
            <dt><label for="value">Value:</label></dt>
            <dd>
                <?php $validation = isset($_REQUEST["validation"]) ? $_REQUEST["validation"] : ""; ?>
                <input type="text" name="value" value="<?= $validation ?>" class="input-text"  />
            </dd>
        </dl>


        <div class="buttons">
            <input type="submit" value="Submit" name="txtSubmit" class="button" />
            <input type="reset" value="Reset" name="txtReset" class="button white" />
        </div>

    </div>
</form>
<div style=" float:right; text-align:right;width:100%;">
    <a href="<?= $nullLink ?>" class="button toggleSearch" >Show Search</a>&nbsp;&nbsp;
    <?php echo anchor('master/means_validation/form', 'Add Validation', 'class="button fancybox"'); ?>&nbsp;&nbsp;
    <?php echo anchor('master/screening_master/view_list', 'Back', 'class="button"'); ?></div>
<br />
<br />
<!--start table-content  -->
<div id="user-grid" class="grid-view">
    <table width="100%" class="gtable sortable">
        <thead>
            <tr>
                <th><a href="<?= $nullLink ?>" field="criteria" class="sortlink">Criteria</a></th>
                <th><a href="<?= $nullLink ?>" field="label" class="sortlink">Validation</a></th>
                <th><a href="<?= $nullLink ?>" field="status" class="sortlink">Status</a></th>
                <th class="head">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (php72_count($validationList)) {
                $r = 1;
                foreach ($validationList as $row) {
                    $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                    $r++;
                    ?>
                    <tr class="<?= $row_type ?>">
                        <td align="left" valign="middle"><?php echo $row['criteria_title']; ?></td>
                        <td align="left" valign="middle"><?= $row["validation"]; ?></td>

                        <td align="left" valign="middle" width="60">
                            <?php
                            if ($row["status"] == '1') {
                                ?>
                                <a href="<?= site_url('master/means_validation/changestatus/' . $row["id"] . '/0') ?>"  title="Make Inctive" >
                                    <img src="<?php echo base_url(); ?>source/template/images/icons/active.png">
                                </a>
                                <?php
                            } else {
                                ?>
                                <a href="<?= site_url('master/means_validation/changestatus/' . $row["id"] . '/1') ?>"  title="Make Active" >
                                    <img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png">
                                </a>
                                <?php
                            }
                            ?>
                        </td>

                        <td nowrap="nowrap" width="70">
                            <a class="fancybox" href="<?= site_url('master/means_validation/form/' . $row["id"]) ?>">
                                <img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>

                            <a href="javascript:void(0);" url="<?= site_url('master/means_validation/delete/' . $row["id"]); ?>" class="confirmDelete">
                                <img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete"></a>



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
    <?php echo $this->pagination->create_links($form_name); ?>
</div>
