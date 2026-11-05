<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => 'Add Deals - Basic Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'page' => 'deals')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4>Add Deal</h4>
                    </div>
                </div>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class=" active"><a href="javascript:void(0);">Basic Information</a></li>
                                <li role="presentation"><a href="javascript:void(0);" class="disableIcon">Team Information</a></li>
                                <li role="presentation"><a href="javascript:void(0);" class="disableIcon">Information About The Enterprise</a></li>
                                <li role="presentation"><a href="javascript:void(0);" class="disableIcon">Impact of Innovation</a></li>
                                <li role="presentation"><a href="javascript:void(0);" class="disableIcon">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container tab-content">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="basicForm" action="<?php echo base_url() . 'index.php/application/add_basic_details'; ?>" autocomplete="off">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Innovation ID</label>
                                                <input type="text" class="form-control" value="<?= $inv_id; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Name of Enterprise<span>*</span></label>
                                                <input type="text" class="form-control" name="txtEnterprise" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Name of Entrepreneur<span>*</span></label>
                                                <input type="text" class="form-control" name="txtEntrepreneur" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Address 1<span>*</span></label>
                                                <textarea class="form-control" name="txtAddressOne" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Address 2</label>
                                                <textarea class="form-control" name="txtAddressTwo" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Country<span>*</span></label>
                                                <select class="form-control" name="txtCountry" value="">
                                                    <option value="">--Select--</option>
                                                    <?php foreach ($country_list as $country) { ?>
                                                        <option value="<?= $country['id']; ?>"><?= $country['country_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Email<span>*</span></label>
                                                <input type="text" class="form-control" name="txtEmail" id="txtEmail" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Mobile<span>*</span></label>
                                                <input type="text" class="form-control" name="txtMobile" value=""/>
                                            </div>
                                        </div>
                                        <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Partner<span>*</span></label>
                                                    <select name="txtPartner" id="txtPartner" class="form-control">
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($branch as $partner) { ?>
                                                            <option value="<?= $partner['id']; ?>"><?= $partner['partner_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Partner<span>*</span></label>
                                                    <input type="text" class="form-control" name="txtPartner" value="<?= $this->session->userdata('partner_name'); ?>"/>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Sector<span>*</span></label>
                                                <select class="form-control" name="txtSector" id="txtSector" onchange="incSubSector(this.value);">
                                                    <option value="">--Select--</option>
                                                    <?php foreach ($sector_details as $index => $row) { ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['sector']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Sub Sector<span>*</span></label>
                                                <select class="form-control" name="txtSubSector" id="incsub_sector">
                                                    <option value="">--Select--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Is Your Enterprise a <a href="javascript:(void)" id="profit_hint">(?)</a><span>*</span></label>
                                                <div id="dialog" title="Information" style="display:none;height:100px;">
                                                    <p>
                                                        <b>For-profit:</b> Incubatee must be registered or plans to register as a Private Limited Company<br />
                                                        <b>Non-profit:</b> Incubatee is registered or plans to register as a Society, Trust or Section 25 Company
                                                    </p>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="txtProfit" id="txtProfit1" value="profit">
                                                    <label class="form-check-label" for="txtProfit1">For-profit organization</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="txtProfit" id="txtProfit2" value="nonprofit">
                                                    <label class="form-check-label" for="txtProfit2">Non-profit organization</label>
                                                </div>
                                                <label for="txtProfit" class="error"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Will your social enterprise be based in India<span>*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="txtIndia" id="txtIndia1" value="yes">
                                                    <label class="form-check-label" for="txtIndia1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="txtIndia" id="txtIndia2" value="no">
                                                    <label class="form-check-label" for="txtIndia2">No</label>
                                                </div>
                                                <label for="txtIndia" class="error"></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Who will be the beneficiaries of your product/service?<span>*</span></label>
                                                <select class="form-control" multiple name="txtBeneficiary[]" id="txtBeneficiary" >
                                                    <option value="People at the base of the pyramid">People at the base of the pyramid</option>
                                                    <option value="Rural poor">Rural poor</option>
                                                    <option value="Urban poor">Urban poor</option>
                                                    <option value="Rural or urban middle income">Rural or urban middle income</option>
                                                    <option value="Rural or urban high income">Rural or urban high income</option>
                                                </select>
                                                <div id="beneficiary_err"></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>What type of impact will your Product / service have on the BoP / poor?<span>*</span></label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="txtImpact" id="txtImpact1" value="Direct">
                                                    <label class="form-check-label" for="txtImpact1">Direct</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="txtImpact" id="txtImpact2" value="Indirect">
                                                    <label class="form-check-label" for="txtImpact2">Indirect</label>
                                                </div>
                                                <label for="txtImpact" class="error"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView">
                                                    <li><input type="submit" value="Save" id="saveForm" class="vital_yellow_btn wdt_100"></li>
                                                    <li><input type="reset" class="vital_bordered_btn wdt_100" name="txtReset" value="Reset"></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </main>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
</div>
</div>

<?php $this->load->view('vitals_footer.php', array('multi_select' => 'multiselect')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#txtBeneficiary').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });
    });

    $(document).on('click', '#saveForm', function (e) {
        var multiselect_len = $('.multiselect-selected-text').html();
        $("#beneficiary_err").html('');
        if (multiselect_len == 'Select an Option') {
            $("#basicForm").valid();
            e.preventDefault();
            $("#beneficiary_err").html('<label for="txtBeneficiary" class="error">Select beneficiary</label>');
        } else {
            if ($("#basicForm").valid()) {
                $('#saveForm').addClass('none-pointer');
            }
        }
    });

    $('#basicForm').validate({
        rules: {
            "txtEnterprise": "required",
            "txtEntrepreneur": "required",
            "txtAddressOne": "required",
            "txtCountry": "required",
            "txtEmail": {
                required: true,
                email: true,
                remote: {
                    url: "<?php echo base_url() . 'index.php/application/checkEmailExist'; ?>",
                    type: "post",
                    data: {
                        txtEmail: function () {
                            return $("#txtEmail").val();
                        }
                    }
                }
            },
            "txtMobile": "required",
            "txtPartner": "required",
            "txtProfit": "required",
            "txtIndia": "required",
            "txtSector": "required",
            "txtSubSector": "required",
            "txtImpact": "required"
        },
        messages: {
            "txtEnterprise": "Enter enterprise",
            "txtEntrepreneur": "Enter entrepreneur",
            "txtAddressOne": "Enter address",
            "txtCountry": "Select country",
            "txtEmail": {
                required: "Enter email id",
                email: "Enter a valid email",
                remote: "Email id already exist"
            },
            "txtMobile": "Enter mobile",
            "txtPartner": "Select partner",
            "txtProfit": "Select type",
            "txtIndia": "Select type",
            "txtSector": "Select sector",
            "txtSubSector": "Select sub sector",
            "txtImpact": "Select type"
        }
    });

    function incSubSector(val) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/scouting/getSubsector",
            data: {
                sector_id: val
            },
            dataType: 'json',
            success: function (msg) {
                $('#incsub_sector').find('option').not(':first').remove().end();
                $.each(msg, function (i, value) {
                    $('#incsub_sector').append($('<option>').text(value.sector).attr('value', value.id));
                });
            },
        });
    }

    $("#profit_hint").mouseover(function () {
        $("#dialog").dialog({
            modal: true,
            width: 460,
            maxWidth: 500,
            resizable: false,
            dialogClass: "dialogaddSeasons"
        });
    });
</script>

</body>
</html>