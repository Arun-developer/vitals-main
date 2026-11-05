<?php
$nullLink = 'javascript:void(0);';

//load scripts
echo '<h1 style="margin: 15px 0 10px;">' . $cpagetitle . '</h1>';
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.clear1').hide();
        $('.toggleSearchs').click(function () {
            $('.searchBox').toggle();
            if ($('.toggleSearchs').html() == 'Show Search')
            {
                $('.toggleSearchs').html('Hide Search');
                $('.clear1').show();
            } else
            {
                $('.clear1').hide();
                $('.toggleSearchs').html('Show Search');
            }
        });

        $('.white').click(function () {
            $("#fit_name").val('');
        });

<?php
if (isset($_REQUEST['fit_name']) && $_REQUEST['fit_name'] != '') {
    ?>
            $('.toggleSearchs').trigger('click');
    <?php
}
?>
    });
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
<br />
<form id="search" action="<?= site_url('master/master_settings/donor_fit_list/search') ?>" method="post" name="<?= $form_name ?>">
    <input type="hidden"  name="ordertype" value="<?= $ordertype ?>"  />
    <input type="hidden"  name="orderby" value="<?= $orderby ?>"  />
    <div class="searchBox" style="display:none;"  >
        <dl class="inline">
            <?php
            if ($this->session->userdata['user_type'] == 'superadmin') {
                $branch_name = isset($_REQUEST["branch"]) ? $_REQUEST["branch"] : '';
                ?>
                <dt><label for="program">Partner</label></dt>

                <dd>
                    <select name="branch" id="branch">
                        <option value="">Select Partner</option>
                        <?php foreach ($branch as $partner) { ?>
                            <option value="<?php echo $partner['id']; ?>"<?php echo ($branch_name == $partner['id']) ? ('selected') : (''); ?>><?php echo $partner['branch_name']; ?> </option>
                        <?php } ?>
                    </select>
                </dd>
            <?php } ?>

            <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $this->session->userdata('partner_id'); ?>">


            <dt><label for="fit_name">Donor Fit Name</label></dt>
            <dd>
                <?php $fit_name = isset($_REQUEST['fit_name']) ? $_REQUEST['fit_name'] : ''; ?>
                <input type="text" id="fit_name" name="fit_name" class="input-text" value="<?= $fit_name ?>"  />
            </dd>
        </dl>
        <div class="buttons">
            <button type="submit" class="button" value="Search" name="txtSubmit">Search</button>
            <button type="reset" class="button white">Reset</button>
        </div>
    </div>
</form>

<div style=" float:right; text-align:right;width:100%;">
    <?php echo anchor('master/master_settings/donor_fit_list', 'Clear Search', 'class="button clear1"'); ?>
    <a href="<?= $nullLink ?>" class="button toggleSearchs" >Show Search</a>&nbsp;&nbsp;
    <?php echo anchor('master/master_settings/donor_fit_add', 'Add Donor Fit', 'class="button"'); ?>
</div>
<br />
<br />



<table class="gtable sortable">
    <thead>
        <tr>
            <th width="55%"><a href="<?= $nullLink ?>" field="donorfit_name" class="sortlink">Donor Fit Name</a></th>
            <th width="15%"><a href="<?= $nullLink ?>" field="status" class="sortlink">Partner</a></th>
            <th width="15%"><a href="<?= $nullLink ?>" field="status" class="sortlink">Status</a></th>
            <th width="15%" class="head">Action</th>
        </tr>

    </thead>
    <tbody>
        <?php
        if (count($donors)) {
            $r = 1;
            foreach ($donors as $donor) {
                $this->hris = $this->load->database('hris', TRUE);
                $this->hris->select('branch_name');
                $this->hris->where('id', $donor['partner_id']);
                $emp = $this->hris->get('hr_branch');
                $branch_name = $emp->result_array();
                $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                $r++;
                ?>
                <tr class="<?= $row_type ?>">
                    <td align="middle" valign="middle"><?= $donor["name"] ?></td>
                    <td align="middle" valign="middle"><?= $branch_name[0]["branch_name"] ?></td>

                    <td align="middle" valign="middle"><?php if ($donor["status"] == '1') { ?>
                            <a href="<?= site_url('master/master_settings/DonorFit_changestatus/' . $donor['id'] . '/0') ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/active.png"></a>

                        <?php } else {
                            ?>
                            <a href="<?= site_url('master/master_settings/DonorFit_changestatus/' . $donor['id'] . '/1') ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png"></a>
                        <?php }
                        ?></td>
                    <td nowrap="nowrap">
                        <a href="<?= site_url('master/master_settings/DonorFit_edit/' . $donor['id']) ?>" ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png"></a>

                        <a  class="confirmDelete" url="<?= site_url('master/master_settings/DonorFit_delete/' . $donor['id']) ?>"  ><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png"></a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan='7' align='center'>No Records found!</td>
            </tr>
        <? }
        ?>

    </tbody>
</table>
<!-- Paging style -->
<?php echo $this->pagination->create_links($form_name); ?>

