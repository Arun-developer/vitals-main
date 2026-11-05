<?php
$form_type = $this->uri->segment(3);
$this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - ' . ucfirst($form_type) . ' Additional Info'));
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'additional_info')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/master/additional_info'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?= ucfirst($form_type); ?> Additional Info</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <?php if (isset($editid) && $editid != '') { ?>
                                <li <?php if (!isset($editid)) { ?>class="activeTabs" <?php } ?>><a href="<?php echo base_url() . 'index.php/master/additional_info/add'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a></li>
                                <li class="edit"><a href="javascript:void(0)" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                                                               <!--  <li><a href="javascript:void(0)" class="master_deluser clr_red"><i class="fas fa-trash-alt"></i> Delete</a></li> -->
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="inputplan-structureall plan-structure-new ">
                        <form id="additionalinfo_form" method="post" action="<?php echo base_url() . 'index.php/master/addAdditionalinfo'; ?>" autocomplete="off">
                            <?php
                            if (isset($editid) && $editid != '') {
                                $disabled = 'disabled';
                                $dis_hide = 'display-hide';
                            } else {
                                $disabled = '';
                                $dis_hide = '';
                            }
                            ?>
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Programme <span class="text-danger">*</span></label>
                                        <select class="form-control additionalInput" name="programme" id="programme" <?= $disabled; ?> onchange="getDonor(this.value);">
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($programme as $p_list) {
                                                if (isset($editid) && $editid != '' && $additional_details[0]['programme'] == $p_list['programme_id']) {
                                                    $selected = 'selected';
                                                } else {
                                                    $selected = '';
                                                }
                                                ?>
                                                <option value="<?= $p_list['programme_id']; ?>" <?= $selected; ?>><?= $p_list['programme']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Donor <span class="text-danger">*</span></label>
                                        <select class="form-control additionalInput" <?= $disabled; ?> name="donor" id="donor" onchange="getBudget(this.value);">
                                            <option value="">--Select--</option>
                                            <?php
                                            if (isset($editid) && $editid != '') {
                                                foreach ($donors as $dlist) {
                                                    if ($additional_details[0]['donor'] == $dlist['master_id']) {
                                                        $dselected = 'selected';
                                                    } else {
                                                        $dselected = '';
                                                    }
                                                    ?>
                                                    <option value="<?= $dlist['master_id']; ?>" <?= $dselected; ?>><?= $dlist['master_name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Budget Head <span class="text-danger">*</span></label>
                                        <select class="form-control additionalInput" <?= $disabled; ?> name="budget_head" id="budget_head" onchange="getLineitem(this.value);">
                                            <option value="">--Select--</option>
                                            <?php
                                            if (isset($editid) && $editid != '') {
                                                foreach ($budget_head as $blist) {
                                                    if ($additional_details[0]['budgethead'] == $blist['master_id']) {
                                                        $bselected = 'selected';
                                                    } else {
                                                        $bselected = '';
                                                    }
                                                    ?>
                                                    <option value="<?= $blist['master_id']; ?>" <?= $bselected; ?>><?= $blist['master_name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Line Item <span class="text-danger">*</span></label>
                                        <select class="form-control additionalInput" <?= $disabled; ?> name="line_item" id="line_item">
                                            <option value="">--Select--</option>
                                            <?php
                                            if (isset($editid) && $editid != '') {
                                                foreach ($line_item as $llist) {
                                                    if ($additional_details[0]['lineitem'] == $llist['master_id']) {
                                                        $lselected = 'selected';
                                                    } else {
                                                        $lselected = '';
                                                    }
                                                    ?>
                                                    <option value="<?= $llist['master_id']; ?>" <?= $lselected; ?>><?= $llist['master_name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Additional Info<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="additional_info" id="additional_info" maxlength="50" placeholder="Additional info"  value="<?php echo isset($editid) && $editid != '' ? $additional_details[0]['additionalinfo'] : ''; ?>"/>
                                    </div>
                                </div>
                                <?php if ($this->uri->segment(3) != 'add') { ?>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Status<span class="text-danger">*</span></label>
                                            <select class="form-control additionalInput" name="status" id="status" disabled>
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-4  col-md-4 ">
                                    <div class="text-left">
                                        <ul class="vitals-links saveLinkView <?= $dis_hide; ?>">
                                            <li><input type="submit" value="Add" class="wdt_100 vital_yellow_btn"></li>
                                            <li><a href="<?php echo base_url() . 'index.php/master/additional_info'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="edit_id" id="edit_id" value="<?php echo isset($editid) ? $editid : '' ?>" />
                        </form>
                    </div>

                </div>
            </main>
        </div>
    </div>
</div>
</div>
</div>

<?php $this->load->view('vitals_footer.php'); ?>

<script type="text/javascript">
    $('#additionalinfo_form').validate({
        rules: {
            programme: "required",
            donor: "required",
            budget_head: "required",
            line_item: "required",
            additional_info: "required",
            status: "required"

        },
        messages: {
            programme: "Select programme",
            donor: "Select donor",
            budget_head: "Select budget head",
            line_item: "Select line item",
            additional_info: "Enter additional info",
            status: "Select status"
        }
    });

    function getDonor(prgmval) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getPrgmDonor",
            data: {
                parent: prgmval,
            },
            dataType: 'html',
            success: function (data) {
                $('#donor').html(data);
            }
        });
    }

    function getBudget(donorval) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getBudgetlist",
            data: {
                m_type: 'Budget Head',
                parent: donorval,
            },
            dataType: 'html',
            success: function (data) {
                $('#budget_head').html(data);
            }
        });
    }

    function getLineitem(budgetval) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/getBudgetlist",
            data: {
                m_type: 'Line Item',
                parent: budgetval,
            },
            dataType: 'html',
            success: function (data) {
                $('#line_item').html(data);
            }
        });
    }

    $('.summaryEdit').click(function () {
        $(".additionalInput").attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    });

</script>

</body>
</html>