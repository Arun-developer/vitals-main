<?php
$form_type = $this->uri->segment(4);
$this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - ' . ucfirst($type) . ' Asset'));
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'asset_master')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/master/asset/' . $type; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?= ucfirst($type); ?> Asset</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <?php if (isset($editid) && $editid != '') { ?>
                                <li <?php if (!isset($editid)) { ?>class="activeTabs" <?php } ?>><a href="<?php echo base_url() . 'index.php/master/additional_info/add'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a></li>
                                <li class="edit"><a href="javascript:void(0)" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="inputplan-structureall plan-structure-new ">
                        <form id="asset_form" method="post" action="<?php echo base_url() . 'index.php/master/addAsset'; ?>" autocomplete="off">
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
                                        <label>Asset type <span class="text-danger">*</span></label>
                                        <select class="form-control additionalInput" name="asset_type" id="asset_type" <?= $disabled; ?> >
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($assettype as $atype) {
                                                if (isset($editid) && $editid != '' && $assetlist[0]['asset_type'] == $atype['master_id']) {
                                                    $selected = 'selected';
                                                } else {
                                                    $selected = '';
                                                }
                                                ?>
                                                <option value="<?= $atype['master_id']; ?>" <?= $selected; ?>><?= $atype['master_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Asset Number <span class="text-danger">*</span></label>
                                        <?php
                                        $nxt_assetno=1;
                                        if(isset($assetlist)){
                                        $lastarray=end($assetlist);
                                        if(isset($lastarray['asset_id'])){
                                        $nxt_assetno = $lastarray['asset_id'] + 1;
                                        }
                                        }
                                        $generate_asset = 'AST/' . sprintf("%04s", $nxt_assetno);
                                        ?>
                                        <input type="text" class="form-control" readonly name="asset_no" id="asset_no" value="<?php echo isset($editid) && $editid != '' ? $assetlist[0]['asset_no'] : $generate_asset; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Asset Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="asset_name" id="asset_name" value="<?php echo isset($editid) && $editid != '' ? $assetlist[0]['asset_name'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Asset Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="asset_code" id="asset_code" value="<?php echo isset($editid) && $editid != '' ? $assetlist[0]['asset_code'] : ''; ?>" >
                                    </div>
                                </div>
                                <?php if ($type == 'it') { ?>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Brand Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="brand_name" id="brand_name" value="<?php echo isset($editid) && $editid != '' ? $assetlist[0]['brand_name'] : ''; ?>" >
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Model <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="model" id="model" value="<?php echo isset($editid) && $editid != '' ? $assetlist[0]['model'] : ''; ?>" >
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Serial Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="serial_no" id="serial_no" value="<?php echo isset($editid) && $editid != '' ? $assetlist[0]['serial_no'] : ''; ?>" >
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Description <span class="text-danger">*</span></label>
                                            <textarea class="form-control additionalInput" <?= $disabled; ?> name="description" id="description"><?php echo isset($editid) && $editid != '' ? $assetlist[0]['description'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Warranty Expiry Date </label>
                                        <input type="text" class="form-control additionalInput asset_date" <?= $disabled; ?> name="warrenty_expiry_date" id="warrenty_expiry_date" value="<?php echo isset($editid) && $editid != '' && $assetlist[0]['warrenty_expiry_date'] != '0000-00-00' ? date('d-m-Y', strtotime($assetlist[0]['warrenty_expiry_date'])) : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Purchase Date</label>
                                        <input type="text" class="form-control additionalInput asset_date" <?= $disabled; ?> name="purchase_date" id="purchase_date" value="<?php echo isset($editid) && $editid != '' && $assetlist[0]['purchase_date'] != '0000-00-00' ? date('d-m-Y', strtotime($assetlist[0]['purchase_date'])) : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Vendor <span class="text-danger">*</span></label>
                                        <select class="form-control additionalInput" name="vendor" id="vendor" <?= $disabled; ?> >
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($vendorList as $vlist) {
                                                if (isset($editid) && $editid != '' && $assetlist[0]['vendor'] == $vlist['vendor_id']) {
                                                    $selected = 'selected';
                                                } else {
                                                    $selected = '';
                                                }
                                                ?>
                                                <option value="<?= $vlist['vendor_id']; ?>" <?= $selected; ?>><?= $vlist['vendor_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="price" id="price" value="<?php echo isset($editid) && $editid != '' ? $assetlist[0]['price'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Bill Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="bill_no" id="bill_no" value="<?php echo isset($editid) && $editid != '' ? $assetlist[0]['bill_no'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Bill Date </label>
                                        <input type="text" class="form-control additionalInput asset_date" <?= $disabled; ?> name="bill_date" id="bill_date" value="<?php echo isset($editid) && $editid != '' && $assetlist[0]['bill_date'] != '0000-00-00' ? date('d-m-Y', strtotime($assetlist[0]['bill_date'])) : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>AMC </label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" onchange="amc_available(this.value);" name="inlineRadioOptions" id="inlineRadio1" value="option1" <?= $disabled; ?> name="amc" id="amc" value="1" <?php isset($editid) && $editid != '' && php72_cmp($assetlist[0]['amc']) == 1 ? 'checked' : ''; ?> >
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" onchange="amc_available(this.value);" name="inlineRadioOptions" id="inlineRadio2" value="option2" <?= $disabled; ?> name="amc" id="amc2" value="2" <?php isset($editid) && $editid != '' && php72_cmp($assetlist[0]['amc']) == 2 ? 'checked' : ''; ?> >
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select class="form-control programmeInput additionalInput" <?= $disabled; ?>  name="status" id="status" >
                                        <option value="">--Select--</option>
                                        <option <?php
                                        if (isset($assetlist[0]['status'])) {
                                            if ($assetlist[0]['status'] == '1') {
                                                echo"selected";
                                            }
                                        }
                                        ?> value="1">Active</option>
                                        <option <?php
                                        if (isset($assetlist[0]['status'])) {
                                            if ($assetlist[0]['status'] == '0') {
                                                echo"selected";
                                            }
                                        }
                                        ?> value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 display-hide amc_yes">
                                    <div class="form-group">
                                        <label>AMC Period </label>
                                        <input type="text" class="form-control additionalInput asset_date" <?= $disabled; ?> name="AMC_period" id="AMC_period" value="<?php echo isset($editid) && $editid != '' && $assetlist[0]['AMC_period'] != '0000-00-00' ? date('d-m-Y', strtotime($assetlist[0]['AMC_period'])) : ''; ?>" >
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 display-hide amc_yes">
                                    <div class="form-group">
                                        <label>AMC Vendor </label>
                                        <select class="form-control additionalInput" name="AMC_vendor" id="AMC_vendor" <?= $disabled; ?> >
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($vendorList as $vlist) {
                                                if (isset($editid) && $editid != '' && $assetlist[0]['AMC_vendor'] == $vlist['vendor_id']) {
                                                    $selected = 'selected';
                                                } else {
                                                    $selected = '';
                                                }
                                                ?>
                                                <option value="<?= $vlist['vendor_id']; ?>" <?= $selected; ?>><?= $vlist['vendor_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-4  col-md-4 ">
                                    <div class="text-left">
                                        <ul class="vitals-links saveLinkView <?= $dis_hide; ?>">
                                            <li><input type="submit" value="Add" class="wdt_100 vital_yellow_btn"></li>
                                            <li><a href="<?php echo base_url() . 'index.php/master/asset'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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

<script type="text/javascript">

<?php if ($type == 'general') { ?>
        $('#asset_form').validate({
            rules: {
                asset_type: "required",
                asset_no: "required",
                asset_name: "required",
                asset_code: "required",
                description: "required",
                vendor: "required",
                bill_no: "required",
                status: "required"

            },
            messages: {
                asset_type: "Select asset type",
                asset_no: "Enter asset number",
                asset_name: "Enter asset name",
                asset_code: "Enter asset code",
                description: "Enter description",
                vendor: "Select vendor ",
                bill_no: "Enter bill number",
                status: "Select status",
            }
        });
<?php } else { ?>
        $('#asset_form').validate({
            rules: {
                asset_type: "required",
                asset_no: "required",
                asset_name: "required",
                asset_code: "required",
                brand_name: "required",
                vendor: "required",
                model: "required",
                serial_no: "required",
                bill_no: "required",
                status: "required"

            },
            messages: {
                asset_type: "Select asset type",
                vendor: "Select vendor",
                asset_no: "Enter asset number",
                asset_name: "Enter asset name",
                asset_code: "Enter asset code",
                brand_name: "Enter brand name",
                model: "Enter model",
                serial_no: "Enter serial number",
                bill_no: "Enter bill number",
                status: "Select status",
            }
        });
<?php } ?>

    $(document).ready(function () {

        var form_type = '<?php echo $form_type; ?>';
        if (form_type == 'add') {
            $("#status").val('');
        }

        setDatepicker();
    });

    function setDatepicker() {
        $('.asset_date').datepicker({
            changeMonth: true,
            changeYear: true,
            // showButtonPanel: true,
            dateFormat: 'dd-mm-yy',
        });
    }

    function amc_available(amcval) {
        if (amcval == 1) {
            $('.amc_yes').removeClass('display-hide');
        } else {
            $('.amc_yes').addClass('display-hide');
        }
    }

    $('.summaryEdit').click(function () {
        $(".additionalInput").attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    });

    $(document).on('click', '.master_check_all', function () {
        if (!$(this).is(":checked")) {
            $('.master_check_all').prop('checked', false);
            $('.master_check').prop('checked', false);
        }
    });

</script>

</body>
</html>