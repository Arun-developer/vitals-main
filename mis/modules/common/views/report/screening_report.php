<?php
$nullLink = "javascript:void(0);";
?>

<script>

    $(document).ready(function () {
        $(".toggleSearch").click(function () {
            $("#showToggole").toggle("slow");
        });

    });



</script>

<h1><?= $cpagetitle ?></h1>

<div id="showToggole" style="display:none;">

    <form id="" action="<?= site_url('common/report/screening') ?>" method="post" name="screening">

        <br />

        <div class="searchBox">

            <table class="gtable" cellpadding="5" align="center" style="width:45%;">

                <tr>

                    <td width="24%" align="right" >Source Type</td>

                    <td width="73%">

<?php $source_type = isset($_REQUEST['source_type']) ? $_REQUEST['source_type'] : ''; ?>

                        <select name="source_type"  id="sourceType">

                            <option value="">-Select-</option>

                            <option value="0" <?= ("0" == $source_type) ? 'selected' : ''; ?>>Direct Applications</option>

<?php
foreach ($sourceTypeList as $row):
    ?>

                                <option value="<?= $row['id'] ?>" <?= ($row['id'] == $source_type) ? 'selected' : ''; ?>><?= $row['master_name'] ?></option>

                                <?php
                            endforeach;
                            ?>

                        </select></td>

                </tr>

                <tr>

                    <td width="24%" align="right">Gender</td>

                    <td>

                        <select name="gender" class="required">

                            <option value="">-Select-</option>

                            <option value="male">Male</option>

                            <option value="female">Female</option>

                        </select>

                    </td>

                </tr>

                <tr>

                    <td width="24%" align="right">Year</td>

                    <td>

                        <select name="year" class="required">

                            <option value="">-Select-</option>

                            <option value="2010">2010</option>

                            <option value="2011">2011</option>

                            <option value="2012">2012</option>

                            <option value="2013">2013</option>

                            <option value="2014">2014</option>

                        </select>

                    </td>

                </tr>

                <tr>

                    <td width="24%" align="right">types</td>

                    <td>

                        <select name="types" class="required">

                            <option value="">-Select-</option>

                            <option value="Combination of product and service">Combination of product and service</option>

                            <option value="Product">Product</option>

                            <option value="Service">Service</option>

                            <option value="Business model">Business model</option>

                            <option value="Practices">Practices</option>

                        </select>

                    </td>

                </tr>

                <tr>

                    <td width="24%" align="right" valign="top">Stage:</td>

                    <td>

<?php
$stage_post = isset($_REQUEST['stage']) ? $_REQUEST['stage'] : "";
?>

                        <select name="stage" >

                            <option value="">-Select-</option>

                        <?php
                        foreach ($stage as $key => $value):
                            ?><option value="<?= $key ?>" <?= ((string) $key == $stage_post) ? 'selected' : ''; ?>><?= $value ?></option>

    <?php
endforeach;
?>

                        </select>

                    </td>

                </tr>

                <tr>

                    <td width="24%" align="right" valign="top">Status:</td>

                    <td>

<?php
$status_post = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";
?>

                        <select name="status" >

                            <option value="">-Select-</option>

<?php
foreach ($status as $key => $value):
    ?><option value="<?= $key ?>" <?= ((string) $key == $status_post) ? 'selected' : ''; ?>><?= $value ?></option>

                            <?php
                        endforeach;
                        ?>

                        </select>

                    </td>

                </tr>

                <tr>

                    <th>&nbsp;</th>

                    <td valign="top">

                        <input type="submit" value="Search" name="txtSubmit" class="button" />

                        <input type="reset" value="Clear" name="txtReset" class="button white" />

                    </td>

                </tr>

            </table>

        </div>

    </form>

</div>

<?php if (isset($filename) == "") { ?>

    <ul class="option-tab">

        <li><a href="<?= $nullLink ?>" class="button toggleSearch">Show Search</a></li>

        <li><a href="<?= site_url('common/report/screening/' . "ex"); ?>" class="button">Export</a></li>

    </ul>

<?php } ?>

<table class="gtable sortable">

    <thead>

        <tr>

            <th><a href="<?= $nullLink ?>" field="source" class="sortlink" >Name of the Innovator</a></th>

            <th><a href="<?= $nullLink ?>" field="name_of_enterprise" class="sortlink">Name of the Incubatee</a></th>

            <th><a href="<?= $nullLink ?>" field="stage" class="sortlink">Stage</a></th>

            <th><a href="<?= $nullLink ?>" field="status" class="sortlink">Status</a></th>

            <th><a href="<?= $nullLink ?>" field="created_date" class="sortlink">Created Date</a></th>

        </tr>

    </thead>

    <tbody>

<?php foreach ($due_diligence as $row): ?>

            <tr>

                <td align="left" valign="middle"><?= $row['name_of_entrepreneur']; ?></td>

                <td align="left" valign="middle"><?= $row['name_of_enterprise']; ?></td>

                <td align="left" valign="middle"><?= $row['stage']; ?></td>

                <td align="left" valign="middle"><?= $row['status']; ?></td>

                <td align="left" valign="middle"><?= $row['created_date']; ?></td>

            </tr>

<?php endforeach; ?>

        <tr align="right">

            <td>Total No of Innovations :<?php echo php72_count($due_diligence); ?> </td>

        </tr>

    </tbody>

</table>

<div class="clear"></div>

<?php ?>

