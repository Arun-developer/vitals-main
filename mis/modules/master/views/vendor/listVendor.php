<?php
$nullLink = 'javascript:void(0);';
$form_name = 'vendor_list';
?>
<form id="company_list" action="<?= site_url('master/vendor/view_list') ?>" method="post" name="<?= $form_name ?>">
    <input type="hidden"  name="ordertype" value="<?= $ordertype ?>"  />
    <input type="hidden"  name="orderby" value="<?= $orderby ?>"  />
    <div class="seachBox">
        <table border="0" cellpadding="0" cellspacing="0"  id="id-form" >
            <tr>
                <td valign="top">Vendor Name :</td>
                <td>
                    <?php $vendor_name = isset($_REQUEST['vendor_name']) ? $_REQUEST['vendor_name'] : ''; ?>
                    <input type="text"  name="vendor_name" value="<?= $vendor_name ?>"  />
                </td>
                <td></td>
            </tr>
            <tr>
                <td valign="top">Contact Person:</td>
                <td>
                    <?php $contact_person = isset($_REQUEST['contact_person']) ? $_REQUEST['contact_person'] : ''; ?>
                    <input type="text"  name="contact_person" value="<?= $contact_person ?>"  />
                </td>
                <td></td>
            <tr>
                <th>&nbsp;</th>
                <td valign="top">
                    <input type="button" value="Search" name="txtSubmit" class="button" onclick="search_form()" />
                </td>
                <td></td>
            </tr>
        </table>
    </div>
</form>
<div class="add_div" style="padding:5px; text-align:right"><?php echo anchor('master/vendor/add', 'Add Vendor', 'class="button"'); ?></div>
<!--start table-content  -->
<div id="table-content" >
    <!--  start product-table -->
    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
        <tr>
            <th><a href="<?= $nullLink ?>" onclick="sortlink('vendor_name');" class="sortlink">Vendor Name</a></th>
            <th><a href="<?= $nullLink ?>" onclick="sortlink('vendor_email');" class="sortlink">Email</a></th>
            <th><a href="<?= $nullLink ?>" onclick="sortlink('contact_person');" class="sortlink">Contact Person</a></th>
            <th><a href="<?= $nullLink ?>" onclick="sortlink('address');" class="sortlink">Company Address</a></th>
            <th><a href="<?= $nullLink ?>" onclick="sortlink('contact_no');" class="sortlink">Contact Number</a></th>
            <th><a href="<?= $nullLink ?>" onclick="sortlink('website');" class="sortlink">Website</a></th>
            <th><a href="<?= $nullLink ?>" onclick="sortlink('status');" class="sortlink">Status</a></th>
            <th><a href="<?= $nullLink ?>">Options</a></th>
        </tr>
        <?php
        if (count($vendorList)):
            $i = 0;
            foreach ($vendorList as $row):
                $row_type = ($i % 2 == 0) ? 'even' : 'odd';

                echo "<tr class='" . $row_type . "'>";
                echo "<td>" . $row["vendor_name"] . "</td>";
                echo "<td>" . $row["vendor_email"] . "</td>";
                echo "<td>" . $row["contact_person"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td>" . $row["contact_no"] . "</td>";
                ?>
                <?php
                echo "<td>" . $row["website"] . "</td>";
                echo "<td>";
                if ($row["status"] == '1') {
                    echo anchor('master/vendor/changestatus/' . $row["vendor_id"] . '/0', "Active", 'class="button"');
                } else {
                    echo anchor('master/vendor/changestatus/' . $row["vendor_id"] . '/1', "Inactive", 'class="button"');
                }
                echo "</td>";
                echo '<td nowrap="nowrap">'
                ?>
        <?php echo anchor('master/vendor/edit/' . $row["vendor_id"], "Edit", 'class="button"'); ?>
                <a href="javascript:void(0);" onclick="showDialog('delete_<?= $row["vendor_id"] ?>')" class="button">Delete</a>
                <div id="delete_<?= $row["vendor_id"] ?>" title="Vendor delete - Confirmation box" class="dialogBox"  >
                    <div class="dialog-content">Are you sure want to delete?</div>
                    <div class="dialog-options">
                        <?php echo anchor('master/vendor/delete/' . $row["vendor_id"], "Yes", 'class="button"'); ?>
                        <a href="javascript:void(0);" onclick="closeDialog('delete_<?= $row["vendor_id"] ?>')" class="button" >No</a></div></div>
                        <?php
                        "</td>";
                        echo "</tr>";

                    endforeach;
                else:
                    ?>
            <tr><td colspan="5" align="center">List Empty</td></tr>
        <?php
        endif;
        ?>
    </table>
    <!--  end product-table................................... -->
</div>
<!--  end content-table  -->
<?= $this->pagination->create_links($form_name); ?>

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
</script>
