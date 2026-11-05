<?php
$nullLink = 'javascript:void(0);';
$form_name = 'reports';
?>
<form id="company_list" action="<?= site_url('master/reports/view_list') ?>" method="post" name="<?= $form_name ?>">
    <h1><?= $cpagetitle ?></h1>
    <input type="hidden"  name="ordertype" value="<?= $ordertype ?>"  />
    <input type="hidden"  name="orderby" value="<?= $orderby ?>"  />
    <div class="searchBox" style=" <?= ($_POST) ? '' : 'display:none;' ?>"  >
        <dl class="inline">

            <dt><label for="report type">Report Type:</label></dt>
            <dd>
                <?php $report_type = isset($_REQUEST["report_type"]) ? $_REQUEST["report_type"] : ""; ?>
                <select name="report_type">
                    <option value="">Select</option>
                    <?php foreach ($reportTypes as $key => $value) { ?>
                        <option value="<?= $key ?>" <?php echo ($report_type == $key) ? ('selected') : (''); ?>><?= $value ?></option>
                    <?php } ?>
                </select>
            </dd>

            <dt><label for="report name">Report Name:</label></dt>
            <dd>
                <?php $report_name = isset($_REQUEST["report_name"]) ? $_REQUEST["report_name"] : ""; ?>
                <input type="text" name="report_name" value="<?= $report_name ?>" class="input-text"  />
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
    <?php echo anchor('master/reports/form', 'Add Custom Report', 'class="button"'); ?></div>
<br />
<br/>
<!--start table-content  -->
<div id="user-grid" class="grid-view">
    <table width="100%" class="gtable sortable">
        <thead>
            <tr>
                <th><a href="<?= $nullLink ?>" field="report_type" class="sortlink">Report Type</a></th>
                <th><a href="<?= $nullLink ?>" field="report_name" class="sortlink">Report Name</a></th>
                <th><a href="<?= $nullLink ?>" field="status" class="sortlink">Status</a></th>
                <th class="head">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (php72_count($reportsList)) {
                $r = 1;
                foreach ($reportsList as $reports) {
                    $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                    $r++;
                    ?>
                    <tr class="<?= $row_type ?>">
                        <td align="left" valign="middle"><?php echo $reportTypes[$reports["report_type"]]; ?></td>
                        <td align="left" valign="middle"><?= $reports["report_name"]; ?></td>
                        <td align="left" valign="middle" width="60">
                            <?php if ($reports["status"] == '1') {
                                ?>
                                <a href="<?= site_url('master/reports/changestatus/' . $reports["id"] . '/0') ?>"  title="Make Inactive" >
                                    <img src="<?php echo base_url(); ?>source/template/images/icons/active.png">
                                </a>

                                <?php
                            } else {
                                ?>
                                <a href="<?= site_url('master/reports/changestatus/' . $reports["id"] . '/1') ?>"  title="Make Inactive" >
                                    <img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png">
                                </a>

                            <?php }
                            ?>
                        </td>
                        <td nowrap="nowrap" width="70">
                            <a href="<?= site_url('master/reports/form/' . $reports["id"]) ?>" >
                                <img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit">
                            </a>



                            <a href="<?= $nullLink ?>" url="<?= site_url('master/reports/delete/' . $reports["id"]) ?>" class="confirmDelete" >
                                <img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Edit">
                            </a>


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

<script type="text/javascript">
    function search_form()
    {
        document.<?= $form_name ?>.submit();
    }
    function sortlink(field)
    {
        orderType = document.<?= $form_name ?>.ordertype.value;
        orderType = (orderType == 'asc') ? 'desc' : 'asc';
        document.<?= $form_name ?>.orderby.value = field;
        document.<?= $form_name ?>.ordertype.value = orderType;
        document.<?= $form_name ?>.submit();
    }
    function toggleDiv(divId)
    {
        $('.' + divId).toggle();
    }
</script>
