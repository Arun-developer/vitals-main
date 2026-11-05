<?php
$nullLink = 'javascript:void(0);';
$form_name = 'incub_progress_master';
?>
<script type="text/javascript">
    function changeData(value)
    {
        var mastertype = value;
        var datas = $.ajax({
            type: "POST",
            url: "<?php echo site_url('master/incub_progress_master/view_list'); ?>",
            data: {'mastertypes': mastertype, 'isajax': true},
            dataType: 'json',
            success: function (datas) {
                var m = populateSelectbox(datas);
                $('#sel_criteria').find('option').remove().end().append(m);
            }
        });
    }

    function populateSelectbox(optArray)
    {
        var option = '<option value="">Select</option>';
        $.each(optArray, function (i, value) {
            option += '<option value="' + optArray[i].id + '">' + optArray[i].master_name + '</option>';
        });
        return option;
    }
</script>

<h1><?= $cpagetitle ?></h1>
<form id="<?= $form_name ?>" action="<?= site_url('master/incub_progress_master/view_list') ?>" method="post" name="<?= $form_name ?>">
    <input type="hidden"  name="ordertype" value="<?= $ordertype ?>"  />
    <input type="hidden"  name="orderby" value="<?= $orderby ?>"  />
    <div class="searchBox" style=" <?= ($_POST) ? '' : 'display:none;' ?>"  >

        <dl class="inline">
            <dt><label for="source_type">Criteria:</label></dt>
            <dd>
                <?php $criteria = isset($_POST["criteria"]) ? $_POST["criteria"] : ""; ?>
                <select name="criteria">
                    <option value="">Select</option>
                    <?php foreach ($criteriaList as $row) { ?>
                        <option value="<?= $row['id'] ?>" <?php echo ($criteria == $row['id']) ? ('selected') : (''); ?>><?= $row['master_name'] ?></option>
                    <?php } ?>
                </select></dd>


            <dt><label for="source_type">Label:</dt>
            <dd>
                <?php $label = isset($_REQUEST["label"]) ? $_REQUEST["label"] : ""; ?>
                <input type="text" name="label" value="<?= $label ?>" class="input-text"  />
            </dd>



            <dl class="inline">
                <div class="buttons">
                    <input type="submit" value="Search" name="txtSubmit" class="button"  />
                    <input type="reset" value="Reset" name="txtReset" class="button white" />
                </div>


                </div>
                </form>
                <div style=" float:right; text-align:right;width:100%;">
                    <a href="<?= site_url('master/incub_progress_master/export'); ?>" class="button">Export</a>
                    <a href="<?= $nullLink ?>" class="button toggleSearch" >Show Search</a>&nbsp;&nbsp;
                    <?php echo anchor('master/incub_progress_master/form', 'Add Field', 'class="button fancybox"'); ?>&nbsp;&nbsp;

                </div>
                <br />
                <br />

                <!--start table-content  -->
                <div id="user-grid" class="grid-view">
                    <table width="100%" class="gtable sortable">
                        <thead>
                            <tr>
                                <th width="65">S.No.</th>
                                <th width="91"><a href="<?= $nullLink ?>" field="criteria" class="sortlink">Criteria</a></th>
                                <th width="91"><a href="<?= $nullLink ?>" field="period" class="sortlink">Period</a></th>
                                <th width="176"><a href="<?= $nullLink ?>" field="label" class="sortlink">Label</a></th>
                                <th width="93"><a href="<?= $nullLink ?>" field="input_type" class="sortlink">Input Type</a></th>
                                <th width="70"><a href="<?= $nullLink ?>" field="required" class="sortlink">Required</a></th>
                                <th width="106"><a href="<?= $nullLink ?>" field="order" class="sortlink">Order</a></th>
                                <th><a href="<?= $nullLink ?>" field="status" class="sortlink">Status</a></th>
                                <th>Add SubFeild </th>
                                <th class="head">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (php72_count($progressList)) {
                                $r = 1;

                                foreach ($progressList as $row) {
                                    $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                                    ?>
                                    <tr class="<?= $row_type ?>">
                                        <td align="left" valign="middle"><?php
                                            echo $r;
                                            $r++;
                                            ?></td>

                                        <td align="left" valign="middle"><?php echo $row['criteria_title']; ?></td>
                                        <td align="left" valign="middle"><?php echo $criteriaList[$row["period"]]; ?></td>
                                        <td align="left" valign="middle"><?= $row["label"]; ?></td>
                                        <td align="left" valign="middle"><?= $row["input_type"]; ?></td>
                                        <td align="left" valign="middle"><?= ucfirst($row["required"]); ?></td>
                                        <td align="left" valign="middle">
                                            <a href="<?= $nullLink ?>" class="makeOrderUp" criteria="<?= $row['criteria'] ?>" id="<?= $row["id"] ?>"  ><img src="<?php echo base_url(); ?>source/template/images/icons/up.png" title="up"></a></a>&nbsp;
                                            <a href="<?= $nullLink ?>" class="makeOrderDown" criteria="<?= $row['criteria'] ?>" id="<?= $row["id"] ?>"  ><img src="<?php echo base_url(); ?>source/template/images/icons/down.png" title="Down"></a>
                                        </td>
                                        <td align="left" valign="middle" width="60">
                                            <?php if ($row["status"] == '1') {
                                                ?>
                                                <a href="<?= site_url('master/incub_progress_master/changestatus/' . $row["id"] . '/0') ?>"  title="Make Inctive" >
                                                    <img src="<?php echo base_url(); ?>source/template/images/icons/active.png">
                                                </a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="<?= site_url('master/incub_progress_master/changestatus/' . $row["id"] . '/1') ?>"  title="Make Active" >
                                                    <img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png">
                                                </a>

                                            <?php } ?>

                                        </td>
                                        <td nowrap="nowrap" width="124">
                                            <?php echo anchor('master/incub_progress_master/sub_fieldlist/' . $row["id"], "Sub-Fields", 'class=""'); ?>
                                        </td>
                                        <td nowrap="nowrap" width="70">

                                            <a class="fancybox" href="<?= site_url('master/incub_progress_master/form/' . $row["id"]) ?>"><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>

                                            <a href="<?= $nullLink ?>" url="<?= site_url('master/incub_progress_master/delete/' . $row["id"]) ?>" class="confirmDelete" ><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete"></a>

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
                    $(document).ready(function () {


                        $('.makeOrderDown').live('click', function () {
                            var criteria = $(this).attr('criteria');
                            var id = $(this).attr('id');
                            var rowToMove = $(this).parents('tr');
                            var next = rowToMove.next('tr');
                            var next_criteria = next.find('.makeOrderDown').attr('criteria');
                            if (rowToMove.hasClass('odd'))
                            {
                                rowToMove.removeClass('odd').addClass('even');
                                next.removeClass('even').addClass('odd');
                            } else
                            {
                                rowToMove.removeClass('even').addClass('odd');
                                next.removeClass('odd').addClass('even');
                            }
                            if (next.length == 1) {
                                next.after(rowToMove);
                            }
                            makeOrder(criteria, id, 'Down');
                        });


                        $('.makeOrderUp').live('click', function () {
                            var criteria = $(this).attr('criteria');
                            var id = $(this).attr('id');
                            var rowToMove = $(this).parents('tr');
                            var prev = rowToMove.prev('tr');
                            var prev_criteria = prev.find('.makeOrderDown').attr('criteria');
                            if (rowToMove.hasClass('odd'))
                            {
                                rowToMove.removeClass('odd').addClass('even');
                                prev.removeClass('even').addClass('odd');
                            } else
                            {
                                rowToMove.removeClass('even').addClass('odd');
                                prev.removeClass('odd').addClass('even');
                            }
                            if (prev.length == 1) {
                                prev.before(rowToMove);
                            }
                            makeOrder(criteria, id, 'Up');
                        });

                        function makeOrder(criteria, id, order)
                        {
                            var form_data = {
                                criteria: criteria,
                                id: id,
                                order: order,
                                ajax: '4'
                            };
                            $.ajax({
                                url: '<?= site_url('master/incub_progress_master/make_order'); ?>/' + criteria + '/' + id + '/' + order + '/main',
                                type: 'POST',
                                data: form_data,
                                success: function (msg) {
                                    $('#activityTable').html(msg);
                                }
                            });
                        }

                    });
                </script>
