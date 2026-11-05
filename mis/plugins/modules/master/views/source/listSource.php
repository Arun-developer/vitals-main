<?php
$nullLink = 'javascript:void(0);';
$form_name = 'source_list';
?>
<h1><?= $cpagetitle ?></h1>
<br />
<form id="company_list" action="<?= site_url('master/source/view_list/' . $tab . '/search') ?>" method="post" name="<?= $form_name ?>">
    <input type="hidden"  name="ordertype" value="<?= $ordertype ?>"  />
    <input type="hidden"  name="orderby" value="<?= $orderby ?>"  />
    <input type="hidden"  name="export" value=""  />
    <div class="searchBox" style=" <?= ($_POST) ? '' : 'display:none;' ?>"  >
        <dl class="inline">

            <dt><label for="source_type">Source Type</label></dt>
            <dd>
                <?php $source_type = isset($_REQUEST['source_type']) ? $_REQUEST['source_type'] : ''; ?>
                <select name="source_type" >
                    <option value="">-Select-</option>
                    <?php
                    foreach ($sourceTypeList as $st):
                        ?><option value="<?= $st['id'] ?>" <?= ($st['id'] == $source_type) ? 'selected' : ''; ?>><?= $st['master_name'] ?></option><?php
                    endforeach;
                    ?>
                </select>
            </dd>


            <dt><label for="source_type">Source Name:</label></dt>
            <dd>
                <?php $source_name = isset($_REQUEST['source_name']) ? $_REQUEST['source_name'] : ''; ?>
                <input type="text"  name="source_name" class="input-text" value="<?= $source_name ?>"  />

            </dd>


            <dt><label for="source_type">Contact Person:</label></dt>
            <dd>
                <?php $contact_person = isset($_REQUEST['contact_person']) ? $_REQUEST['contact_person'] : ''; ?>
                <input type="text"  name="contact_person" class="input-text" value="<?= $contact_person ?>"  />
            </dd>
        </dl>
        <div class="buttons">
            <input type="submit" value="Search" name="txtSubmit" class="button"  />
            <input type="reset" value="Reset" name="txtReset" class="button white" />
        </div>
    </div>
</form>
<div style=" float:right; text-align:right;width:100%;">
    <a href="<?= site_url('master/source/view_list/'); ?>" class="button">My Source</a>
    <a href="<?= site_url('master/source/view_list/all'); ?>" class="button">All Source</a>
    <a href="<?= $nullLink ?>" class="button toggleSearch">Show Search</a>&nbsp;&nbsp;
    <?php echo anchor('master/source/sourceform', 'Add Source', 'class="button"'); ?>
    <?php $this->Mexport->exportOption('source', $form_name); ?>
</div>
<br />
<br />

<div id="user-grid" class="grid-view">
    <table  class="gtable sortable">
        <thead>
            <tr>
                <th><a href="<?= $nullLink ?>" field="source_type" class="sortlink">Source Type</a></th>
                <th ><a href="<?= $nullLink ?>" field="source_name" class="sortlink">Source Name</a></th>
                <th ><a href="<?= $nullLink ?>" field="employee" class="sortlink">Employee</a></th>
                <th><a href="<?= $nullLink ?>" field="contact_person" class="sortlink">Contact Person</a></th>         <th width="84"><a href="<?= $nullLink ?>" field="designation" class="sortlink">Designation</a>
                </th>
                <th >Instance</th>
                <?php if ($isAuth) { ?>
                    <th><a href="<?= $nullLink ?>" field="status" class="sortlink">Status</a></th><?php } ?>
                <th class="head">Action</th>
            </tr>

        </thead>
        <tbody>
            <?php
            if (count($sourceList)) {
                $r = 1;
                foreach ($sourceList as $row) {
                    $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                    $r++;
                    ?>
                    <tr class="<?= $row_type ?>">
                        <td align="left" valign="middle"><?= $row["master_name"] ?></td>
                        <td align="left" valign="middle"><?= $row["source_name"] ?></td>
                        <td align="left" valign="middle"><?= $row["emp_name"] ?></td>
                        <td align="left" valign="middle"><?= $row["contact_person"] ?></td>
                        <td align="left" valign="middle"><?= $row["designation"] ?></td>
                        <td align="left" valign="middle">
                            <a href="<?= site_url('master/instance/view_list/' . $row['id']) ?>"  class="">View Instance</a></td>
                        <?php if ($isAuth) { ?>
                            <td align="left" valign="middle"><?
                                if ($row["status"] == '1') {
                                    ?>
                                    <a href="<?= site_url('master/source/changestatus/' . $row["id"] . '/0') ?>"  title="Make Inactive" >
                                        <img src="<?php echo base_url(); ?>source/template/images/icons/active.png"></a>

                                <?php } else {
                                    ?>
                                    <a href="<?= site_url('master/source/changestatus/' . $row["id"] . '/1') ?>" title="Make Active" >
                                        <img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png"></a>
                                <?php }
                                ?></td>
                            <?php } ?>
                        <td nowrap="nowrap">
                            <?php echo anchor('master/source/view_details/' . $row["id"], "View", 'class="fancybox"'); ?>

                            <?php if ($isAuth) { ?>
                                <a href="<?= site_url('master/source/sourceform/' . $row["id"]) ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>
                                <a href="<?= site_url('master/source/delete/' . $row["id"]); ?>" class="confirmDelete"><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete">	</a>
                                <?php } ?>
                        </td>

                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan='7' align='center'>No Records found!</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <!-- Paging style -->
    <?php echo $this->pagination->create_links($form_name); ?>
</div>
