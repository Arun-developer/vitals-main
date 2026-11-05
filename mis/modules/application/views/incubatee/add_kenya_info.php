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
                                <li role="presentation"><a href="javascript:void(0);" class="disableIcon">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container tab-content">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="basicForm" action="<?php echo base_url() . 'index.php/application/add_kenya_details'; ?>" autocomplete="off">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Innovation ID</label>
                                                <input type="text" class="form-control" value="<?= $inv_id; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Name<span>*</span></label>
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
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Website URL</label>
                                                <input type="text" class="form-control" name="txtWebsite" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
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
                                                <label>Type of organization <a href="javascript:(void)" id="profit_hint">(?)</a><span>*</span></label>
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
                                    <div class="row">
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

    $("#profit_hint").mouseover(function () {
        $("#dialog").dialog({
            modal: true,
            width: 460,
            maxWidth: 500,
            resizable: false,
            dialogClass: "dialogaddSeasons"
        });
    });

    $('#basicForm').validate({
        rules: {
            "txtEnterprise": "required",
            "txtEntrepreneur": "required",
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
            "txtProfit": "required",
            "txtImpact": "required"
        },
        messages: {
            "txtEnterprise": "Enter name",
            "txtEntrepreneur": "Enter entrepreneur",
            "txtEmail": {
                required: "Enter email id",
                email: "Enter a valid email",
                remote: "Email id already exist"
            },
            "txtMobile": "Enter mobile",
            "txtProfit": "Select type",
            "txtImpact": "Select type"
        }
    });
</script>

</body>
</html>