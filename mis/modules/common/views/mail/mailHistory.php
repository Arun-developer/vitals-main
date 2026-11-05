<?php
$nullLink = 'javascript:void(0);';
$form_name = 'templete_list';
?>
<script type="text/javascript" >
    $(function () {
        $("#opt").change(function () {
            var check = document.getElementById('opt').value;
            if (check == 'internal')
            {
                $("#hide").show();
            } else
            {
                $("#hide").hide();
            }
        });

        $("#search_but").click(function () {
            var val = document.getElementById('search_but').value;
            if (val == 'Show Search')
            {
                $("#sear").show();
                document.getElementById('search_but').value = 'Hide Search';
            } else
            {
                $("#sear").hide();
                document.getElementById('search_but').value = 'Show Search';
            }

        });

    });
</script>
<h1><?= $cpagetitle ?> - <?= $innovation['name_of_enterprise'] ?></h1>
<form id="<?= $form_name ?>" action="<?= site_url('common/mail/history/' . $innovation['id']) ?>" method="post" name="<?= $form_name ?>">
    <input type="hidden"  name="ordertype" value="<?= $ordertype ?>"  />
    <input type="hidden"  name="orderby" value="<?= $orderby ?>"  />
    <div class="searchBox" id="sear" <?php
    if (isset($_POST) && isset($_POST['txtSubmit']))
        echo "";
    else
        echo "style='display:none'";
    ?> >
        <dl class="inline">
            <dt><label for="opt">Option</label></dt>
            <dd><select name="opt" id="opt" required>
                    <option value="">-- select option --</option>
                    <option <?php
                    if (isset($_REQUEST["opt"]) && $_REQUEST['opt'] == "internal") {
                        echo "selected";
                    }
                    ?> value="internal">Internal</option>
                    <option <?php
                    if (isset($_REQUEST["opt"]) && $_REQUEST['opt'] == "external") {
                        echo "selected";
                    }
                    ?> value="external">External</option>
                </select>
            </dd>
            <div id="hide" <?php
            if (isset($_REQUEST['opt']) && $_REQUEST['opt'] == 'external') {
                echo "style = 'display:none'";
            }
            ?>>
                <dt><label for="mail_type">Mail Type</label></dt>
                <dd>
                    <?php $mail_type = isset($_REQUEST["mail_type"]) ? $_REQUEST["mail_type"] : ""; ?>
                    <input type="text" name="mail_type" value="<?= $mail_type ?>" class="input-text"	 /></dd>
            </div>
            <dt><label for="sent_date">Sent Date</label></dt>
            <dd>
                <?php
                $sent_date = isset($_REQUEST['sent_date']) ? $_REQUEST['sent_date'] : '';
                $sent_date_to = isset($_REQUEST['sent_date_to']) ? $_REQUEST['sent_date_to'] : '';
                ?>
                <input type="text" name="sent_date" value="<?= $sent_date ?>" class="input-text" id="fromdate" />&nbsp;-&nbsp;
                <input type="text" name="sent_date_to" value="<?= $sent_date_to ?>" class="input-text" id="todate"/>

            </dd>
        </dl>
        <div class="buttons">
            <button type="submit" class="button" value="Search" name="txtSubmit">Search</button>
            <button type="reset" class="button white">Reset</button>
        </div>
    </div>
</form>
<div style=" float:right; text-align:right;width:100%;">
    <a href="<?= site_url('common/mail/add_ext_mail/' . $innovation['id'] . '') ?>" class="button">Add External Mail</a>&nbsp;&nbsp;
    <a href="<?= $nullLink ?>" class="button toggleSearch">Show Search</a>&nbsp;&nbsp;
    <?php echo anchor('common/mail/form/' . $innovation['id'], 'Send Mail', 'class="button"'); ?>
</div>
<br />
<br />

<!--start table-content  -->
<table class="gtable sortable">
    <thead>
        <tr>
            <th><a href="<?= $nullLink ?>" field="from" class="sortlink">From</a></th>
            <th><a href="<?= $nullLink ?>" field="to" class="sortlink">To</a></th>
            <th><a href="<?= $nullLink ?>" field="sent_date" class="sortlink">Sent Date</a></th>
            <th><a href="<?= $nullLink ?>" field="mail_type" class="sortlink">Mail Type</a></th>
            <th><a href="<?= $nullLink ?>" field="subject" class="sortlink">Subject</a></th>
            <th class="head">View</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($mailList)) {
            $row_type = 'even';
            foreach ($mailList as $row) {
                $row_type = ($row_type == 'odd') ? ('even') : ('odd');
                ?>
                <tr class="<?= $row_type ?>">
                    <td align="left" valign="middle"><?= $row["from"]; ?></td>
                    <td align="left" valign="middle"><?= $row["to"] ?></td>
                    <td align="left" valign="middle"><?= mysql2date($row["sent_date"]) ?></td>
                    <td align="left" valign='middle'><?= $row["mail_type"] ?></td>
                    <td align="left" valign='middle'><?= $row["subject"] ?></td>
                    <td align="left" valign='middle' width="50px">
                        <a href="<?= site_url('common/mail/view/' . $innovation['id'] . '/' . $row["id"]); ?>" class="button fancybox">View</a></td>
                    <td>
                        <?php echo anchor('common/mail/form/' . $innovation['id'] . '/' . $row['id'], 'Resend', 'class="button"'); ?><a href="javascript:void(0);" url="<?= site_url('common/mail/delete/' . $innovation['id'] . '/' . $row["id"]); ?>" class="button confirmDelete">Delete</a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan='9' align='center'>No Records found!</td>
            </tr>
        <? }
        ?>
    </tbody>
</table>
<?= $allPageLink; ?>

<h1>External Mail History</h1>

<table class="gtable sortable">
    <thead>
        <tr>
            <th><a href="<?= $nullLink ?>" field="to" class="sortlink">To</a></th>
            <th><a href="<?= $nullLink ?>" field="sent_date" class="sortlink">Subject</a></th>
            <th><a href="<?= $nullLink ?>" field="mail_type" class="sortlink">Body</a></th>
            <th><a href="<?= $nullLink ?>" field="subject" class="sortlink">Sent On</a></th>
            <th><a href="<?= $nullLink ?>" field="subject" class="sortlink">Document</a></th>
        </tr>
        <?php
        $emailcnt = count($ext_maillist);
        if ($emailcnt) {
            for ($i = 0; $i < $emailcnt; $i++) {
                ?>
                <tr>
                    <td><?= $ext_maillist[$i]['to']; ?></td>
                    <td><?= $ext_maillist[$i]['subject']; ?></td>
                    <td><?= $ext_maillist[$i]['body']; ?></td>
                    <td><?= $ext_maillist[$i]['sent_on']; ?></td>
                    <td><a href="<?= base_url() ?>uploads/ext_mail_docs/<?= str_replace(" ", "_", $ext_maillist[$i]['file_name']) ?>" target="_blank" ><?= $ext_maillist[$i]['file_name'] ?></a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="5" align="5" >No records found!</td>
            </tr>
            <?php
        }
        ?>
    </thead>
</table>
<?= $newPageLink; ?>

