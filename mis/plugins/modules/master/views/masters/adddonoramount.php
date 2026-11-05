<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Add Donor Amount', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'admin_master')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/master/donorAmountlist'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?php
                            if ($edit_id != '') {
                                echo "Edit";
                            } else {
                                echo "Add";
                            }
                            ?> Donor Amount</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <?php if (isset($edit_id) && $edit_id != '') { ?>
                                <li <?php if (!isset($edit_id)) { ?>class="activeTabs" <?php } ?>><a href="<?php echo base_url() . 'index.php/master/addDonorAmount'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a></li>
                                <li class="edit"><a href="javascript:void(0)" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <main class="page-content">
                        <div class="inputplan-structureall plan-structure-new tabpanel-details">
                            <form id="donoramount_form" method="post" action="<?php echo base_url() . 'index.php/master/insertdonorAmount'; ?>" autocomplete="off">
                                <?php
                                if (isset($edit_id) && $edit_id != '') {
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
                                            <label>Donor <span class="text-danger">*</span></label>
                                            <select class="form-control amountInput" <?= $disabled; ?> name="donor" id="donor">
                                                <option value="">--Select--</option>
                                                <?php
                                                foreach ($donors as $dlist) {
                                                    if ($donoramount[0]['donor_id'] == $dlist['master_id']) {
                                                        $dselected = 'selected';
                                                    } else {
                                                        $dselected = '';
                                                    }
                                                    ?>
                                                    <option value="<?= $dlist['master_id']; ?>" <?= $dselected; ?>><?= $dlist['master_name'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Amount (<?= $this->session->userdata('currency'); ?>) </label>
                                            <input type="text" class="form-control currencyField amountInput" <?= $disabled; ?> name="donor_amt" id="donor_amt" value="<?= isset($donor_amt) && $donor_amt != '' ? $donor_amt : '' ?>" />
                                        </div>

                                        <div class="form-group">
                                            <label>Date <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control amountInput" <?= $disabled; ?> name="amt_date" id="amt_date" value="<?= isset($donoramount) && $donoramount[0]['amount_date'] != '' ? date('d-m-Y', strtotime($donoramount[0]['amount_date'])) : '' ?>" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4"></div>
                                </div>

                                <input type="hidden" name="delete_ids" id="delete_ids" />
                                <input type="hidden" name="master_type" id="master_type" value="<?php echo $master_type; ?>" />

                                <div class="row">
                                    <div class="col-12 col-sm-4  col-md-4 ">
                                        <div class="text-left">
                                            <ul class="vitals-links saveLinkView <?= $dis_hide; ?>">
                                                <li><input type="submit" value="Submit" class="wdt_100 vital_yellow_btn"></li>
                                                <li><a href="<?php echo base_url() . 'index.php/master/programme'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="edit_id" id="edit_id" value="<?= isset($edit_id) ? $edit_id : '' ?>" />
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

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type='text/javascript'>
    $('#donoramount_form').validate({
        rules: {
            donor: "required",
            donor_amt: "required",
            amt_date: "required"

        },
        messages: {
            donor: "Select donor",
            donor_amt: "Enter donor amount",
            amt_date: "Select date"
        }
    });

    $(document).ready(function () {
        setDatepicker();
    });

    function setDatepicker() {
        $('#amt_date').datepicker({
            changeMonth: true,
            changeYear: true,
            // showButtonPanel: true,
            dateFormat: 'dd-mm-yy',
        });
    }

    $('.summaryEdit').click(function () {
        $(".amountInput").attr("disabled", false);
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    });

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

    $(document).on('input', '.currencyField', function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9\.]/g, ''));
        self.val(inrFormat(self.val()));
        var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
        var matchedString = self.val().match(patt);
        if (matchedString) {
            self.val(matchedString);
        }
    });

    function inrFormat(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        var z = 0;
        var len = String(x1).length;
        var num = parseInt((len / 2) - 1);
        while (rgx.test(x1)) {
            if (z > 0) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            } else {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
                rgx = /(\d+)(\d{2})/;
            }
            z++;
            num--;
            if (num == 0) {
                break;
            }
        }
        return x1 + x2;
    }

</script>

</body>
</html>