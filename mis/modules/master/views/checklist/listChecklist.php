<h1><?= $cpagetitle ?></h1>
<?php
$nullLink = 'javascript:void(0);';
$form_name = 'checklist';
//load scripts
?>
<br />
<form id="<?= $form_name ?>" action="<?= site_url('master/checklist/view_list/') ?>" method="post" name="<?= $form_name ?>">
    <input type="hidden"  name="ordertype" value="<?= $ordertype ?>"  />
    <input type="hidden"  name="orderby" value="<?= $orderby ?>"  />
    <div class="searchBox" style=" <?= ($_POST) ? '' : 'display:none;' ?>"  >
        <dl class="inline">
            <dt><label for="area">Area/Origin</label></dt>
            <dd>
                <?php $area = isset($_REQUEST['area']) ? $_REQUEST['area'] : ''; ?>
                <select name="area" >
                    <option value="">-Select-</option>
                    <?php
                    foreach ($areaList as $pt):
                        ?><option value="<?= $pt['id'] ?>" <?= ($pt['id'] == $area) ? 'selected' : ''; ?>><?= $pt['master_name'] ?></option><?php
                    endforeach;
                    ?>
                </select>
            </dd>

            <dt><label for="document_description">Document Descripton</label></dt>
            <dd>
                <?php $document_description = isset($_REQUEST['document_description']) ? $_REQUEST['document_description'] : ''; ?>
                <input type="text"  name="document_description" class="input-text" value="<?= $document_description ?>"  />
            </dd>
        </dl>
        <div class="buttons">
            <input type="submit" value="Search" name="txtSubmit" class="button"/>
            <input type="reset" value="Reset" name="txtReset" class="button white"/>
        </div>
    </div>
</form>

<div style=" float:right; text-align:right;width:100%;">
    <a href="<?= $nullLink ?>" class="button toggleSearch" >Show Search</a>&nbsp;&nbsp;
    <?php echo anchor('master/checklist/form', 'Add Checklist', 'class="button fancybox"'); ?>&nbsp;&nbsp;
    <?php echo anchor('master/screening_master/view_list', 'Back', 'class="button"'); ?>
</div>
<br /><br />

<table class="gtable sortable">
    <thead>
        <tr>
            <th width="20%"><a href="<?= $nullLink ?>" field="area" class="sortlink">Area/Origin</a></th>
            <th width="59%"><a href="<?= $nullLink ?>" field="document_description" class="sortlink">Document Descripton</a></th>
            <th width="7%"><a href="<?= $nullLink ?>" field="status" class="sortlink">Status</a></th>
            <th width="14%" class="head">Action</th>
        </tr>

    </thead>
    <tbody>
        <?php
        if (count($checkList)) {
            $r = 1;
            foreach ($checkList as $row) {
                $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                $r++;
                ?>
                <tr class="<?= $row_type ?>">
                    <td align="left" valign="middle"><?= $row["master_name"] ?></td>
                    <td align="left" valign="middle"><?= $row["document_description"] ?></td>
                    <td align="left" valign="middle"><?php
                        if ($row["status"] == '1') {
                            ?>
                            <a href="<?= site_url('master/checklist/changestatus/' . $row["id"] . '/0') ?>"  title="Make Inctive" >
                                <img src="<?php echo base_url(); ?>source/template/images/icons/active.png">
                            </a>
                            <?php
                        } else {
                            ?>
                            <a href="<?= site_url('master/checklist/changestatus/' . $row["id"] . '/1') ?>"  title="Make Active" >
                                <img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png">
                            </a>
                            <?php
                        }
                        ?></td>
                    <td nowrap="nowrap">
                        <a class="fancybox" href="<?= site_url('master/checklist/form/' . $row["id"]) ?>">
                            <img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>

                        <a href="javascript:void(0);" url="<?= site_url('master/checklist/delete/' . $row["id"]); ?>" class="confirmDelete">
                            <img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete"></a>

                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan='7' align='center'>No Records found!</td>
            </tr>
        <?php }
        ?>

    </tbody>
</table>
<!-- Paging style -->
<?php echo $this->pagination->create_links($form_name); ?>
