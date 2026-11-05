<?php
$form_type = $this->uri->segment(3);
$this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - ' . ucfirst($form_type) . ' Programme'));
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'budget_program')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/master/programme'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?= ucfirst($form_type); ?> Programme</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <?php if (isset($editid) && $editid != '') { ?>
                                <li <?php if (!isset($editid)) { ?>class="activeTabs" <?php } ?>><a href="<?php echo base_url() . 'index.php/master/programme/add'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a></li>
                                <li class="edit"><a href="javascript:void(0)" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <main class="page-content">
                        <div class="inputplan-structureall plan-structure-new tabpanel-details">
                            <form id="programme_form" method="post" action="<?php echo base_url() . 'index.php/master/addProgramme'; ?>" autocomplete="off">
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
                                            <input type="text" class="form-control programmeInput" <?= $disabled; ?> name="programme_name" id="programme_name" maxlength="50" placeholder="Programme name"  value="<?php echo isset($editid) && $editid != '' ? $programme_details[0]['programme'] : ''; ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Programme Head<span class="text-danger">*</span></label>
                                            <select class="form-control programmeInput" name="programme_head" id="programme_head" <?= $disabled; ?> onchange="getDonor(this.value);">
                                                <option value="">--Select--</option>
                                                <?php
                                                foreach ($userList as $u_list) {
                                                    if (isset($editid) && $editid != '' && $programme_details[0]['programme_head'] == $u_list['id']) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    ?>
                                                    <option value="<?= $u_list['id']; ?>" <?= $selected; ?>><?= $u_list['user_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
										<div class="form-group">
                                            <label>AN approver user <span class="text-danger"></span></label>
                                            <select class="form-control programmeInput" name="an_assign_user" id="an_assign_user" <?= $disabled; ?> onchange="getDonor(this.value);">
                                                <option value="">--Select--</option>
                                                <?php
                                                foreach ($user_list as $list) {
                                                    if (isset($editid) && $editid != '' && $programme_details[0]['an_assign_user'] == $list['id']) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    ?>
                                                    <option value="<?= $list['id']; ?>" <?= $selected; ?>><?= $list['emp_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
										<div class="form-group">
                                            <label>AN Request Sector <span class="text-danger"></span></label>
                                            <select class="form-control programmeInput" name="an_request_sector" id="an_request_sector" <?= $disabled; ?>>
                                                <option value="">--Select--</option>
                                                <?php
                                                foreach ($sector_details as $list) {
                                                    if (isset($editid) && $editid != '' && $programme_details[0]['an_request_sector'] == $list['id']) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    ?>
                                                    <option value="<?= $list['id']; ?>" <?= $selected; ?>><?= $list['sector']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
										
                                        <div class="form-group">
                                            <label>Donor <span class="text-danger">*</span></label>
                                            <select class="form-control programmeInput" <?= $disabled; ?> multiple name="donor_types[]" id="donor_types" >
                                                <?php
                                                foreach ($donors as $dlist) {
                                                    $donorr = unserialize($programme_details[0]["donor"]);
                                                    $dselected = '';
                                                    if (isset($editid) && $editid != '') {
                                                        if (php72_in_array($dlist['master_id'], $donorr)) {
                                                            $dselected = 'selected';
                                                        } else {
                                                            $dselected = '';
                                                        }
                                                    }
                                                    ?>
                                                    <option value="<?= $dlist['master_id']; ?>" <?= $dselected; ?>><?= $dlist['master_name'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <div id="donor_err"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select class="form-control programmeInput" <?= $disabled; ?> name="status" id="status" >
                                                <option value="">--Select--</option>
                                                <?php
                                                if (isset($editid) && $editid != '') {
                                                    $active = $inactive = '';
                                                    if ($programme_details[0]['status'] == '1') {
                                                        $active = 'selected';
                                                    } else if ($programme_details[0]['status'] == '0') {
                                                        $inactive = 'selected';
                                                    }
                                                } else {
                                                    $active = 'selected';
                                                }
                                                ?>
                                                <option value="1" <?= $active; ?>>Active</option>
                                                <option value="0" <?= $inactive; ?>>Inactive</option>
                                                <?php ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4"></div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-4  col-md-4 ">
                                        <div class="text-left">
                                            <ul class="vitals-links saveLinkView <?= $dis_hide; ?>">
                                                <li><input type="submit" value="Submit" id="submit_btn" class="wdt_100 vital_yellow_btn"></li>
                                                <li><a href="<?php echo base_url() . 'index.php/master/programme'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="edit_id" id="edit_id" value="<?php echo isset($editid) ? $editid : '' ?>" />
                            </form>
                        </div>
                    </main>
                </div>
            </main>
        </div>
    </div>
</div>
</div>
</div>

<?php $this->load->view('vitals_footer.php', array('multi_select' => 'multiselect')); ?>

<script type="text/javascript">

    $(document).on('click', '#submit_btn', function (e) {
        multiselect_len = $('.multiselect-selected-text').html();
        $("#donor_err").html('');
        if (multiselect_len == 'Select an Option') {
            $("#programme_form").valid();
            e.preventDefault();
            $("#donor_err").html('<label style="text-align:end;color: #FF0000 !important;" id="assoc_err_lable" >Select Donor</label>');
        }
    });

    $('#programme_form').validate({
        rules: {
            programme_name: "required",
            status: "required",
            programme_head: "required",
            'donor_types[]': "required"

        },
        messages: {
            programme_name: "Enter programme name",
            status: "Select status",
            programme_head: "Select programme head",
            'donor_types[]': "Select donor type"
        }
    });

    $(document).ready(function () {
        $('#donor_types').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });
    });

    $('.summaryEdit').click(function () {
        $(".programmeInput").attr("disabled", false);
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    });

</script>

</body>
</html>