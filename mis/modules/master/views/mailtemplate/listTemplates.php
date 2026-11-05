<?php
$nullLink = 'javascript:void(0);';
$form_name = 'templete_list';
?>
<script type="application/javascript">
    formname = '<?= $form_name ?>';
</script>
<script type="text/javascript">
    function change(value)
    {
        var value = value;
        if (value == 'mis')
        {
            location.href = "<?= site_url('master/mailtemplate/view_list') ?>";
        } else if (value == 'ais')
        {
            location.href = "<?= site_url('master/mailtemplate/view_mailtemplate') ?>";
        } else
        {
            location.href = "<?= site_url('master/mailtemplate/hrismail') ?>";
        }

    }

    function changeBranch(value)
    {
        var value = value;
        location.href = "<?= site_url('master/mailtemplate/view_list') ?>" + "/" + value;
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        //confirmantion Box
        $(".confirmDelete").click(function () {
            var linkUrl = $(this).attr('url');
            jConfirm('Can you confirm this?', 'Confirmation Dialog', function (r) {
                if (r)
                {
                    $(window.location).attr('href', linkUrl);
                }
            });
        });
    });
</script>
<h1 style="margin: 15px 0 10px;"><?= $cpagetitle ?></h1>
<div align="center">
    <label for="Module">Module:</label>

    <select name="module" onchange="change(this.value)">
        <option value="">-select-</option>
        <option value="mis" selected="selected">RAMP incubation</option>
        <option value="ais" >Admin</option>
        <option value="hris">HR</option>
    </select>
</div>

<div align="center" style="margin-top:10px;">
    <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
        <label for="program">Partner</label>
        <select name="branch" id="branch" onchange="changeBranch(this.value)">
            <option value="">Select Partner</option>
            <?php foreach ($branch as $partner) { ?>
                <option value="<?php echo $partner['id']; ?>"<?php echo ($partner_id == $partner['id']) ? ('selected') : (''); ?>><?php echo $partner['branch_name']; ?> </option>
            <?php } ?>
        </select>
    <?php } ?>
</div>


<form id="<?= $form_name ?>" action="<?= site_url('master/mailtemplate/view_list') ?>" method="post" name="<?= $form_name ?>">
    <input type="hidden"  name="ordertype" value="<?= $ordertype ?>"  />
    <input type="hidden"  name="orderby" value="<?= $orderby ?>"  />
    <div class="searchBox" style=" <?= ($_POST) ? '' : 'display:none;' ?>"  >
        <dl class="inline">

            <dt><label for="message type">Message Type:</label></dt>
            <td>
                <?php $message_type = isset($_REQUEST["message_type"]) ? $_REQUEST["message_type"] : "";
                ?>
                <input type="text" name="message_type" value="<?= $message_type ?>" class="input-text"	 /></td>

            <dt><label for="values">Status :</label></dt>
            <dd>
                <?php $status = isset($_REQUEST["status"]) ? $_REQUEST["status"] : "";
                ?>
                <select name="status">
                    <option value="">Select</option>
                    <option value="0" <?php echo ($status == '0') ? ('selected') : (''); ?>>Inactive</option>
                    <option value="1" <?php echo ($status == '1') ? ('selected') : (''); ?>>Active</option>
                </select>	</dd>

        </dl>
        <div class="buttons">
            <input type="submit" value="Submit" name="txtSubmit" class="button" />
            <input type="reset" value="Reset" name="txtReset" class="button white" />
        </div>

    </div>
</form>
<div style=" float:right; text-align:right;width:100%;">
    <a href="<?= $nullLink ?>" class="button toggleSearch">Show Search</a>&nbsp;&nbsp;
</div>
<br />
<br/>
<!--start table-content  -->
<div id="user-grid" class="grid-view">
    <table width="100%" class="gtable sortable">
        <thead>
            <tr>
                <th><a href="<?= $nullLink ?>" field="messagetype" class="sortlink">Template Type</a></th>
                <th><a href="<?= $nullLink ?>" field="messagesubject" class="sortlink">Message Subject</a></th>
                <th><a href="<?= $nullLink ?>" field="status" class="sortlink">Status</a></th>
                <th class="head">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (php72_count($templateList)) {
                $r = 1;
                foreach ($templateList as $row) {
                    $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                    $r++;
                    ?>
                    <tr class="<?= $row_type ?>">
                        <td align="left" valign="middle"><?= $row["messagetype"]; ?></td>
                        <td align="left" valign="middle"><?= $row["messagesubject"] ?></td>
                        <td align="left" valign="middle">
                            <?php
                            if ($row["status"] == '1') {
                                ?>
                                <a href="<?= site_url('master/mailtemplate/changestatus/' . $row["id"] . '/0') ?>"  title="Make Inactive" >
                                    <img src="<?php echo base_url(); ?>source/template/images/icons/active.png">
                                </a>


                            <?php } else { ?>

                                <a href="<?= site_url('master/mailtemplate/changestatus/' . $row["id"] . '/1') ?>"  title="Make Inactive" >
                                    <img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png">
                                </a>
                            <?php }
                            ?></td>
                        <td align="left" valign='middle' nowrap="nowrap" >
                            <a href="<?= site_url('master/mailtemplate/form/' . $row["id"]) ?>" >
                                <img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit">
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
    <?= $this->pagination->create_links($form_name); ?>
</div>



