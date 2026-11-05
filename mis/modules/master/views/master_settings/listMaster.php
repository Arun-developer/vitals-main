<?php
$nullLink = 'javascript:void(0);';
$form_name = 'company_list';

//load scripts
echo '<h1>' . $cpagetitle . '</h1>';
?>
<br />
<form id="company_list" action="<?= site_url('master/master_settings/view_list/' . $currentTab . '/search') ?>" method="post" name="<?= $form_name ?>">
    <input type="hidden"  name="ordertype" value="<?= $ordertype ?>"  />
    <input type="hidden"  name="orderby" value="<?= $orderby ?>"  />
    <div class="searchBox" style="display:none;"  >
        <dl class="inline">
            <dt><label for="master_name"><?= $masterType[$currentTab] ?></label></dt>
            <dd>
                <?php $master_name = isset($_REQUEST['master_name']) ? $_REQUEST['master_name'] : ''; ?>
                <input type="text"  name="master_name" class="input-text" value="<?= $master_name ?>"  />
            </dd>
        </dl>
        <div class="buttons">
            <button type="submit" class="button" value="Search" name="txtSubmit">Search</button>
            <button type="reset" class="button white">Reset</button>
        </div>
    </div>
</form>

<div style=" float:right; text-align:right;width:100%;">
    <a href="<?= $nullLink ?>" class="button toggleSearch" >Show Search</a>&nbsp;&nbsp;
    <?php echo anchor('master/master_settings/add', 'Add Masters', 'class="button"'); ?>
</div>
<br />
<br />



<table class="gtable sortable">
    <thead>
        <tr>
            <th width="65%"><a href="<?= $nullLink ?>" field="master_name" class="sortlink"><?= $masterType[$currentTab] ?></a></th>
            <th width="18%"><a href="<?= $nullLink ?>" field="status" class="sortlink">Status</a></th>
            <th width="17%" class="head">Action</th>
        </tr>

    </thead>
    <tbody>
        <?php
        if (count($masterList)) {
            $r = 1;
            foreach ($masterList as $master) {
                $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                $r++;
                ?>
                <tr class="<?= $row_type ?>">
                    <td align="left" valign="middle"><?= $master["master_name"] ?></td>
                    <td align="left" valign="middle"><?php if ($master["status"] == '1') { ?>
                            <a href="<?= site_url('master/master_settings/changestatus/' . $currentTab . '/' . $master["id"] . '/0') ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/active.png"></a>

                        <?php } else {
                            ?>
                            <a href="<?= site_url('master/master_settings/changestatus/' . $currentTab . '/' . $master["id"] . '/1') ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png"></a>
                        <?php }
                        ?></td>
                    <td nowrap="nowrap">
                        <a href="<?= site_url('master/master_settings/edit/' . $master["id"]) ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png"></a>

                        <a href="<?= site_url('master/master_settings/delete/' . $currentTab . '/' . $master["id"]) ?>"  class="confirmDelete"><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
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

