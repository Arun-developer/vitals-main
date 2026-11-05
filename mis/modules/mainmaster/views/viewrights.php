<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();
?>
<h1><?= $cpagetitle ?></h1>
<style>
    .message {
        display: none;
        margin: 0 0 13px 0;
        padding: 13px 13px 13px 52px;
        background: lightgreen;
        background-position: 13px 5px;
        border: solid 1px #BD8;
        color:#000000;
    }
</style>
<!--start table-content  -->
<div align="right">
    <a href="<?= site_url('mainmaster/useraccess/') ?>" class="button">Back</a>&nbsp;
</div>
<br/>
<div id="user-grid" class="gtable sortable">
    <table width="100%" class="items">
        <thead>
            <tr>
                <th><a href="<?= $nullLink ?>" field="label">User Group Name</a></th>
                <th><a href="<?= $nullLink ?>" field="label">Modules</a></th>
                <th><a href="<?= $nullLink ?>" field="label">Sub Modules</a></th>
                <th><a href="<?= $nullLink ?>" field="label">Add</a></th>
                <th><a href="<?= $nullLink ?>" field="label">Edit</a></th>
                <th><a href="<?= $nullLink ?>" field="label">View</a></th>
                <th><a href="<?= $nullLink ?>" field="label">Delete</a></th>
                <th><a href="<?= $nullLink ?>" field="label">Approve</a></th>
                <th colspan="2"><a href="<?= $nullLink ?>" field="label">Action(Select All)</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($viewrights)) {
                $i = 0;
                $r = 1;
                foreach ($viewrights as $row) {
                    $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                    $r++;
                    ?>
                    <tr class="<?= $row_type ?>">
                        <td align="left" valign="middle"><?= ucfirst($row['userg_name']); ?></td>
                        <td align="left" valign="middle"><?= $row['name']; ?></td>
                        <td align="left" valign="middle"><?= $row['sname']; ?></td>
                        <td align="left" valign="middle" width="60">
                            <?php
                            if ($row['smod_id'] == '') {
                                $row['smod_id'] = 'NULL';
                            }
                            if ($row["addition"] == '1') {
                                ?>

                                <input type="checkbox" title="Make Inctive"  onclick ="window.location = '<?= site_url('mainmaster/useraccess/changestatus/' . $row["userg_id"] . '/' . $row['mod_id'] . '/' . $row['smod_id'] . '/add' . '/0') ?>';" class="add_<?= $r; ?>" name="add_<?= $r; ?>" checked="checked"/>
                                <?php
                            } else {
                                ?>

                                <input type="checkbox" title="Make Active" onclick="window.location = '<?= site_url('mainmaster/useraccess/changestatus/' . $row["userg_id"] . '/' . $row['mod_id'] . '/' . $row['smod_id'] . '/add' . '/1') ?>';" class="add_<?= $r; ?>" name="add_<?= $r; ?>" />


                            <?php } ?>

                        </td>
                        <td align="left" valign="middle" width="60">
                            <?php if ($row["editing"] == '1') {
                                ?>

                                <input type="checkbox" title="Make Inctive" onclick="window.location = '<?= site_url('mainmaster/useraccess/changestatus/' . $row["userg_id"] . '/' . $row['mod_id'] . '/' . $row['smod_id'] . '/edit' . '/0') ?>';" class="edit_<?= $r; ?>" name="edit_<?= $r; ?>" checked="checked"/>

                                <?php
                            } else {
                                ?>

                                <input type="checkbox" title="Make Active" onclick="window.location = '<?= site_url('mainmaster/useraccess/changestatus/' . $row["userg_id"] . '/' . $row['mod_id'] . '/' . $row['smod_id'] . '/edit' . '/1') ?>';" class="edit_<?= $r; ?>" name="edit_<?= $r; ?>" />


                            <?php } ?>

                        </td>
                        <td align="left" valign="middle" width="60">
                            <?php if ($row["viewing"] == '1') {
                                ?>

                                <input type="checkbox" title="Make Inctive" onclick="window.location = '<?= site_url('mainmaster/useraccess/changestatus/' . $row["userg_id"] . '/' . $row['mod_id'] . '/' . $row['smod_id'] . '/view' . '/0') ?>';" class="view_<?= $r; ?>" name="view_<?= $r; ?>" checked="checked"/>

                                <?php
                            } else {
                                ?>

                                <input type="checkbox" title="Make Active" onclick="window.location = '<?= site_url('mainmaster/useraccess/changestatus/' . $row["userg_id"] . '/' . $row['mod_id'] . '/' . $row['smod_id'] . '/view' . '/1') ?>';" class="view_<?= $r; ?>" name="view_<?= $r; ?>" />
                            <?php } ?>
                        </td>
                        <td align="left" valign="middle" width="60">
                            <?php if ($row["deletion"] == '1') {
                                ?>
                                <input type="checkbox"  title="Make Inctive"  onclick="window.location = '<?= site_url('mainmaster/useraccess/changestatus/' . $row["userg_id"] . '/' . $row['mod_id'] . '/' . $row['smod_id'] . '/del' . '/0') ?>';" class="del_<?= $r; ?>" name="del_<?= $r; ?>" checked="checked" />
                                <?php
                            } else {
                                ?>
                                <input type="checkbox" title="Make Active" onclick="window.location = '<?= site_url('mainmaster/useraccess/changestatus/' . $row["userg_id"] . '/' . $row['mod_id'] . '/' . $row['smod_id'] . '/del' . '/1') ?>';"  class="del_<?= $r; ?>" name="del_<?= $r; ?>" />
                            <?php } ?>

                        </td>
                        <td align="left" valign="middle" width="60">
                            <?php if ($row["approve"] == '1') {
                                ?>

                                <input type="checkbox" onclick="window.location = '<?= site_url('mainmaster/useraccess/changestatus/' . $row["userg_id"] . '/' . $row['mod_id'] . '/' . $row['smod_id'] . '/app' . '/0') ?>';"  title="Make Inctive"  class="approve_<?= $r; ?>" name="approve_<?= $r; ?>" checked="checked"/>

                                <?php
                            } else {
                                ?>

                                <input type="checkbox" onclick="window.location = '<?= site_url('mainmaster/useraccess/changestatus/' . $row["userg_id"] . '/' . $row['mod_id'] . '/' . $row['smod_id'] . '/app' . '/1') ?>';"  title="Make Active"  class="approve_<?= $r; ?>" name="approve_<?= $r; ?>" />
                            <?php } ?>

                        </td>
                        <td>
                            <input type="hidden" id=userg_id_<?= $r; ?> value="<?= $row['userg_id']; ?>"/>
                            <input type="hidden" id=mod_id_<?= $r; ?> value="<?= $row['mod_id']; ?>"/>
                            <input type="hidden" id=smod_id_<?= $r; ?> value="<?= $row['smod_id']; ?>"/>
                            <input type="hidden" id="text_<?= $r; ?>" value="<?php echo 'select_all_' . $r; ?>" name="select_all_<?= $r; ?>"/>
                            <input type="checkbox"  class="select_all_<?= $r; ?>"  id="select_all_<?= $r ?>" />
                        </td>
                <script type="text/javascript">
                    $(document).ready(function () {


                        var a = $('#text_<?= $r; ?>').val();
                        $('.select_all_<?php echo $r; ?>').click(function () {
                            if ($('.select_all_<?php echo $r; ?>').is(':checked'))
                            {
                                $('.add_<?php echo $r; ?>').attr('checked', true);
                                $('.edit_<?php echo $r; ?>').attr('checked', true);
                                $('.view_<?php echo $r; ?>').attr('checked', true);
                                $('.del_<?php echo $r; ?>').attr('checked', true);
                                $('.approve_<?php echo $r; ?>').attr('checked', true);
                                var usergid = $('#userg_id_<?= $r; ?>').val();
                                var modid = $('#mod_id_<?= $r; ?>').val();
                                var smodid = $('#smod_id_<?= $r; ?>').val();
                                var datas = $.ajax({
                                    type: "POST",
                                    url: "<?php echo site_url('mainmaster/useraccess/change'); ?>",
                                    data: {'usergid': usergid, 'modid': modid, 'smodid': smodid},
                                    dataType: 'json',
                                    success: function (datas)
                                    {
                                        $(".message").show();
                                        $(".message").fadeOut(5000);
                                    }
                                });
                            } else if ($('.select_all_<?php echo $r; ?>').is(':unchecked'))
                            {
                                $('.add_<?php echo $r; ?>').attr('checked', false);
                                document.location = $('.add_rlink_<?php echo $r ?>').attr('href');
                            }
                        });
                    });
                </script>
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
    <table class="gtable">
        <tbody>
            <?php $i = 0;
            foreach ($mip as $rw):
                ?>
                <tr>
                    <td style="width:8% !important">&nbsp;</td>
                    <td style="width:8% !important">&nbsp;</td>
                    <td style="width:40% !important"><?= $rw['code']; ?></td>
                    <td><input type="checkbox" onclick="window.location = '<?= site_url('mainmaster/useraccess/changemipstatus/' . $viewrights[$i]["userg_id"] . '/' . $rw['id']) ?>';"   class="select_mip"  id="select_mip" /></td>
                </tr>
                <?php $i++;
            endforeach;
            ?>
        </tbody>
    </table>
    <!-- Paging style -->
</div>
<div class="message">Data has been added successfully.</div>
<br/><br/>
