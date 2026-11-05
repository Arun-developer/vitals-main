<h1><?= $cpagetitle ?></h1>
<?php
$nullLink = 'javascript:void(0);';
$form_name = 'program_service_list';
?>
<br />
<form id="<?= $form_name ?>" action="<?= site_url('master/program_service/view_list/search') ?>" method="post" name="<?= $form_name ?>" class="uniform">
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


            <dt><label for="source_type">Program Service:</label></dt>
            <dd>
                <?php $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : ''; ?>
                <input type="text"  name="title" class="input-text" value="<?= $title ?>"  />
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
    <?php echo anchor('master/program_service/add', 'Add Program Service', 'class="button"'); ?>
</div>
<br />
<br/>



<div id="user-grid" class="grid-view">
    <table width="100%" class="gtable sortable">
        <thead>
            <tr>
                <th width="9%"><a href="<?= $nullLink ?>" field="program_type" class="sortlink">Program Type</a></th>
                <th width="25%"><a href="<?= $nullLink ?>" field="title" class="sortlink">Program Service</a></th>
                <th width="4%"><a href="<?= $nullLink ?>" field="status" class="sortlink">Status</a></th>
                <th width="16%" class="head">Action</th>
            </tr>

        </thead>
        <tbody>
            <?php
            if (php72_count($programServiceList)) {
                $r = 1;
                foreach ($programServiceList as $row) {
                    $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                    $r++;
                    ?>
                    <tr class="<?= $row_type ?>">
                        <td align="left" valign="middle"><?= $row["master_name"] ?></td>
                        <td align="left" valign="middle"><?= $row["title"] ?></td>
                        <td align="left" valign="middle"><?php
                            if ($row["status"] == '1') {
                                ?>
                                <a href="<?= site_url('master/program_service/changestatus/' . $row["id"] . '/0') ?>" title="Make Active" >
                                    <img src="<?php echo base_url(); ?>source/template/images/icons/active.png">
                                </a>
                            <?php } else {
                                ?>

                                <a href="<?= site_url('master/program_service/changestatus/' . $row["id"] . '/1') ?>" title="Make ImActive" >
                                    <img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png">
                                </a>

                            <?php } ?>
                        </td>
                        <td nowrap="nowrap">
                            <a href="<?= site_url('master/program_service/edit/' . $row["id"]) ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>
                            <a href="<?= site_url('master/program_service/delete/' . $row["id"]); ?>" class="confirmDelete"><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete">	</a>
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
</div>