<?php
$nullLink = 'javascript:void(0);';
$form_name = 'program_stage_list';
?>
<h1><?= $cpagetitle ?></h1>
<br />
<form id="company_list" action="<?= site_url('master/program_stage/view_list/search') ?>" method="post" name="<?= $form_name ?>">
    <input type="hidden"  name="ordertype" value="<?= $ordertype ?>"  />
    <input type="hidden"  name="orderby" value="<?= $orderby ?>"  />
    <div class="searchBox" style=" <?= ($_POST) ? '' : 'display:none;' ?>"  >
        <dl class="inline">
            <dt><label for="source_type">Program Type:</label></dt>
            <dd>
                <?php $program_type = isset($_REQUEST['program_type']) ? $_REQUEST['program_type'] : ''; ?>
                <select name="program_type" >
                    <option value="">-Select-</option>
                    <?php
                    foreach ($programType as $pt):
                        ?><option value="<?= $pt['id'] ?>" <?= ($pt['id'] == $program_type) ? 'selected' : ''; ?>><?= $pt['master_name'] ?></option><?php
                    endforeach;
                    ?>
                </select>
            </dd>

            <dt><label for="Program Stage">Program Stage:</label></dt>
            <dd>
                <?php $program_stage = isset($_REQUEST['program_stage']) ? $_REQUEST['program_stage'] : ''; ?>
                <input type="text"  name="program_stage" class="input-text" value="<?= $program_stage ?>"  />
            </dd>

        </dl>
        <div class="buttons">
            <input type="submit" value="Search" name="txtSubmit" class="button"  />
            <input type="reset" value="Reset" name="txtReset" class="button white" />
        </div>

    </div>
</form>

<div style=" float:right; text-align:right;width:100%;">
    <a href="<?= $nullLink ?>" class="button toggleSearch" >Show Search</a>&nbsp;&nbsp;
    <?php echo anchor('master/program_stage/add', 'Add Program Stage', 'class="button"'); ?>
</div>
<br />
</br>



<div id="user-grid" class="grid-view">
    <table width="100%" class="gtable sortable">
        <thead>
            <tr>
                <th width="9%"><a href="<?= $nullLink ?>" field="program_type" class="sortlink">Program Type</a></th>
                <th width="25%"><a href="<?= $nullLink ?>" field="program_service_offering" class="sortlink">Program Service</a></th>
                <th width="25%"><a href="<?= $nullLink ?>" field="title" class="sortlink">Program Stage</a></th>
                <th width="4%"><a href="<?= $nullLink ?>" field="status" class="sortlink">Status</a></th>
                <th width="16%" class="head">Action</th>
            </tr>

        </thead>
        <tbody>
            <?php
            if (count($programStageList)) {
                $r = 1;
                foreach ($programStageList as $row) {
                    $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                    $r++;
                    ?>
                    <tr class="<?= $row_type ?>">
                        <td align="left" valign="middle"><?= $row["master_name"] ?></td>
                        <td align="left" valign="middle"><?= $row["program_service_title"] ?></td>
                        <td align="left" valign="middle"><?= $row["title"] ?></td>
                        <td align="left" valign="middle"><?php
                            if ($row["status"] == '1') {
                                ?>
                                <a href="<?= site_url('master/program_stage/changestatus/' . $row["id"] . '/0') ?>"  title="Make Inactive" >
                                    <img src="<?php echo base_url(); ?>source/template/images/icons/active.png">
                                </a>
                            <?php } else {
                                ?>

                                <a href="<?= site_url('master/program_stage/changestatus/' . $row["id"] . '/1') ?>"  title="Make Inactive" >
                                    <img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png">
                                </a>

                            <?php }
                            ?>

                        </td>
                        <td nowrap="nowrap">
                            <a href="<?= site_url('master/program_stage/edit/' . $row["id"]) ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>

                            <a href="javascript:void(0);" url="<?= site_url('master/program_stage/delete/' . $row["id"]) ?>"  class="confirmDelete"><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Edit"></a></a>

                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan='7' align='center'>No Records found!</td>
                </tr>
            <? }
            ?>

        </tbody>
    </table>
    <!-- Paging style -->
    <?php echo $this->pagination->create_links($form_name); ?>
</div>
