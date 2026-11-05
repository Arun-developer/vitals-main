<?php
$form_type = $this->uri->segment(4);
$this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - ' . ucfirst($form_type) . ' Dispatch Outward'));
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'dispatch_outward')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/master/dispatch_outward'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?= ucfirst($form_type); ?> Dispatch Outward</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <?php if (isset($editid) && $editid != '') { ?>
                                <li <?php if (!isset($editid)) { ?>class="activeTabs" <?php } ?>><a href="<?php echo base_url() . 'index.php/master/dispatch_outward/pending/add'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a></li>
                                <li class="edit"><a href="javascript:void(0)" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="inputplan-structureall plan-structure-new ">
                        <form id="outward_form" method="post" action="<?php echo base_url() . 'index.php/master/addOutward'; ?>" autocomplete="off">
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
                                        <label>Dispatch Date<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput dispatch_date" name="dispatch_date" id="dispatch_date" value="<?php echo isset($editid) && $editid != '' ? $outwardList[0]['dispatch_date'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Employee To</label>
                                        <select name="employee_id" id="employee_id" class="form-control additionalInput" <?= $disabled; ?>>
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($userList as $list) {
                                                if (isset($editid) && $editid != '') {
                                                    if ($outwardList[0]['employee_id'] == $list['id']) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                } else {
                                                    $selected = '';
                                                }
                                                ?>
                                                <option value="<?= $list['id'] ?>" <?= $selected; ?>><?= $list['user_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Person's Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" name="person_name" id="person_name" value="<?php echo isset($editid) && $editid != '' ? $outwardList[0]['person_name'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Company's Name</label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="company_name" id="company_name" value="<?php echo isset($editid) && $editid != '' ? $outwardList[0]['company_name'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>City <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="city" id="city" value="<?php echo isset($editid) && $editid != '' ? $outwardList[0]['city'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>State <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="state" id="state" value="<?php echo isset($editid) && $editid != '' ? $outwardList[0]['state'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Pincode <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="pincode" id="pincode" value="<?php echo isset($editid) && $editid != '' ? $outwardList[0]['pincode'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea class="form-control additionalInput" <?= $disabled; ?> name="content" id="content"><?php echo isset($editid) && $editid != '' ? $outwardList[0]['content'] : ''; ?> </textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-4 col-xl-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-4  col-md-4 ">
                                    <div class="text-left">
                                        <ul class="vitals-links saveLinkView <?= $dis_hide; ?>">
                                            <li><input id="submit" type="submit" value="Add" class="wdt_100 vital_yellow_btn"></li>
                                            <li><a href="<?php echo base_url() . 'index.php/master/dispatch_outward'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="edit_id" id="edit_id" value="<?php echo isset($editid) ? $editid : '' ?>" />
                            <input type="hidden" name="type" id="type" value="<?php echo isset($type) ? $type : '' ?>" />
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

<script>
    $('#outward_form').validate({
        rules: {
            dispatch_date: "required",
            person_name: "required",
            city: "required",
            state: "required",
            pincode: "required",
            content: "required"

        },
        messages: {
            dispatch_date: "Select dispatch date",
            person_name: "Enter person number",
            city: "Enter city name",
            state: "Enter state name",
            pincode: "Enter pincode name",
            content: "Enter content"
        }
    });

    $(document).ready(function () {
        setDatepicker();
    });

    function setDatepicker() {
        $('.dispatch_date').datepicker({
            changeMonth: true,
            changeYear: true,
            // showButtonPanel: true,
            dateFormat: 'dd-mm-yy',
        });
    }

    $('#submit').click(function (e) {
        $("#outward_form").submit();
        $("#submit").removeClass('none-pointer');
        if ($("#outward_form").valid() == true) {
            $("#outward_form").submit();
            $("#submit").addClass('none-pointer');
        } else {
            $("#submit").prop('disabled', false);
            e.preventDefault();
        }
    });

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