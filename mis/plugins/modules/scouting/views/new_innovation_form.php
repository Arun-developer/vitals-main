<script type="text/javascript">
    $(document).on('keyup', 'textarea', function () {
        if (this.value.match(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g, '');
        }
    });
    $(document).ready(function () {

        $("#inv_add_info1").hide();
        $("#inv_info1").show();

        $('#inv_info1').click(function () {
            $("#inv_add_info1").slideToggle();
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
    });

    function invState(val) {
        $(".branch").val(val);
        if (val == 2) {
            document.getElementById("new_innovation_form").style.display = "none";
            document.getElementById("kenya_form").style.display = "block";

        } else {
            document.getElementById("new_innovation_form").style.display = "block";
            document.getElementById("kenya_form").style.display = "none";
        }
        var url_state;
        url_state = "<?php echo site_url("scouting/getPartnerStateajax"); ?>";
        $.ajax({
            dataType: 'json',
            url: url_state,
            data: {
                p_id: val
            },
            success: function (state) {
                var options = '';
                $('#inv_state').multiselect('destroy');

                for (var i = 0; i < state.length; i++) {
                    options += '<option value="' + state[i].id + '">' + state[i].state_name + '</option>';
                }
                $("#inv_state").html(options);
                $('#inv_state').multiselect();
                $("#inv_state").multiselect("refresh");
            }
        });

    }

    function limitText(limitField, limitCount, limitNum) {
        wordcount = limitField.value.trim().split(" ");
        if (limitField.value.trim() == "")
            wordcountlength = 0;
        else
            wordcountlength = wordcount.length;
        if (wordcountlength > limitNum) {
            resultArray = wordcount.slice(0, limitNum);
            limitField.value = resultArray.join(" ");
            limitCount.value = 0;
            return false;
        } else {
            limitCount.value = limitNum - wordcountlength;
        }
    }



    function show_div_inv(value) {
        if (value == 'yes') {
            $("#cus_seg_yes").css('display', 'block');
        } else {
            $("#cus_seg_yes").css('display', 'none');
        }
    }

    function show_org(value) {
        if (value == 'Yes') {
            $("#other_org").css('display', 'block');
        } else {
            $("#other_org").css('display', 'none');
        }
    }

    function show_compet(value) {
        if (value == 'Yes') {
            $("#bus_compet").css('display', 'block');
        } else {
            $("#bus_compet").css('display', 'none');
        }
    }

    function email_valid(value, id) {

        var reg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        if (value != '') {
            if (!reg.test(value)) {


                $("#" + id).removeAttr('value');

                $("#" + id + "_error").text("'" + value + "' is not valid email id");

                setTimeout(function () {
                    $("#" + id).focus();
                }, 10);

            } else {
                $("#" + id + "_error").text("");
            }
        } else {
            $("#" + id + "_error").text("");
        }
    }

    function mob_valid(value, id) {
        if (value != '') {
            var filter = /^\+?[0-9 -]+$/;
            if (!filter.test(value)) {
                $("#" + id).removeAttr('value');

                $("#" + id + "_error").text("'" + value + "' is not a valid phone number");

                setTimeout(function () {
                    $("#" + id).focus();
                }, 10);
            } else if (value.length > 15 || value.length < 10) {
                $("#" + id).removeAttr('value');

                $("#" + id + "_error").text("'" + value + "' length must be in the range of 10 - 15 digits");

                setTimeout(function () {
                    $("#" + id).focus();
                }, 10);
            } else {
                $("#" + id + "_error").text("");
            }
        } else {
            $("#" + id + "_error").text("");
        }
    }

    function resume_valid(value, id) {
        var filename = $("#" + id).val();

        if (filename != '') {
            var extension = filename.replace(/^.*\./, '');
            if (extension == filename) {
                extension = '';
            } else {
                extension = extension.toLowerCase();
            }

            if (!(/\.(doc|docx|ppt|pptx|pdf)$/i).test(filename)) {

                $("#" + id + "_file .filename").html('No file selected');
                var fieldSpan = $("#" + id + "_file");
                console.log(fieldSpan);
                fieldSpan.html(fieldSpan.html());

                $("#" + id + "_error").text("'" + filename + "' Not supported. Please upload the specified file type");

                setTimeout(function () {
                    $("#" + id).focus();
                }, 10);
            } else {
                $("#" + id + "_file .filename").html(filename);
                $("#" + id + "_error").text("");
            }
        } else {
            $("#" + id + "_file .filename").html("No file selected");
            $("#" + id + "_error").text("");
        }

    }

    function plan_check(id) {
        var filename = $("#" + id).val();

        if (filename != '') {

            if (!(/\.(doc|docx|pdf)$/i).test(filename)) {

                $("#" + id + "_file .filename").html('No file selected');
                var fieldSpan = $("#" + id + "_file");
                fieldSpan.html(fieldSpan.html());

                $("#" + id + "_error").text("'" + filename + "' Not supported. Please upload the specified file type");

                setTimeout(function () {
                    $("#" + id).focus();
                }, 10);
            } else {
                $("#" + id + "_file .filename").html(filename);
                $("#" + id + "_error").text("");
            }
        } else {
            $("#" + id + "_file .filename").html("No file selected");
            $("#" + id + "_error").text("");
        }
    }
</script>
<script>
    $.validator.addMethod("maxfilesize", function (value, element) {
        return this.optional(element) || (element.files && element.files[0] && element.files[0].size <= 10008250);
    }, $.format('The file size cannot exceed 10MB.'));
    $(document).ready(function () {

        $('.support_check').click(function () {
            if ($(this).is(":checked"))
                $("#other_support").css('display', 'block');
            else
                $("#other_support").css('display', 'none');
        });

        $('.check').click(function () {
            var name = [];
            $("input[name='abt_vill[]']:checked").each(function () {

                if ($(this).val() == "Referral" || $(this).val() == "Past incubatee" || $(this)
                        .val() == "Villgro staff")
                    name.push('yes');
                else
                    name.push('no');
            });

            if ($.inArray('yes', name) == -1)
                $("#referral_name").css('display', 'none');
            else
                $("#referral_name").css('display', 'block');
        });


        $.validator.addMethod('customphone', function (value, element) {
            return this.optional(element) || /^\+?(\d[\d-. ]+)?(\([\d-. ]+\))?[\d-. ]+\d$/.test(value);
        }, "Please enter a valid phone number");
        $('#kenya_form').validate({
            rules: {
                ent_name: "required",
                name_entr: "required",
                inv_email: {
                    required: true,
                    email: true,
                },
                inv_mobile: {
                    required: true,
                    customphone: true
                },
                compnay_type: "required",
                inv_idea_ent: "required",
                location: "required",
                'sector[]': {
                    required: true,
                },
                company_desc: "required",
                impact_type: "required",
                "beneficiary[]": "required",
                "team_name[1]": "required",
                "team_desg[1]": "required",
                "team_org[1]": "required",
                "team_email[1]": "required",
                "team_mob[1]": "required",
                "team_res[]": {
                    extension: "doc|docx|ppt|pptx|pdf",
                    maxfilesize: true
                },
                "abt_vill[]": "required",
            }
        });


        $('#new_innovation_form').validate({
            rules: {
                ent_name: "required",
                name_entr: "required",
                inv_email: {
                    required: true,
                    email: true,
                },
                inv_mobile: {
                    required: true,
                    customphone: true
                },
                address1: "required",
                country: "required",
                inv_srcname: "required",
                compnay_type: "required",
                location: "required",
                inv_sector: "required",
                sub_sector: "required",
                impact_type: "required",
                "beneficiary[]": "required",
                "team_name[1]": "required",
                "team_desg[1]": "required",
                "team_org[1]": "required",
                "team_email[1]": "required",
                "team_mob[1]": "required",
                "team_res[]": {
                    extension: "doc|docx|ppt|pptx|pdf"
                },
                in_operation: "required",
                "inv_state[]": "required",
                type_prod: "required",
                stage_prod: "required",
                cust_seg: "required",
                "vill_support[]": "required",
                otr_support: {
                    required: function (element) {
                        var name = [];
                        $("input[name='vill_support[]']:checked").each(function () {
                            if ($(this).val() == "Other")
                                name.push('yes');
                            else
                                name.push('no');
                        });

                        if ($.inArray('yes', name) == -1)
                            return false;
                        else
                            return true;
                    }
                },
                "abt_vill[]": "required",
                with_other_org: "required",
                competition: "required",
                busi_plan: {
                    extension: "doc|docx|ppt|pptx|pdf",
                    maxfilesize: true
                },
                add_info_file: {
                    extension: "doc|docx|ppt|pptx|pdf",
                    maxfilesize: true
                },
            }
        });

        $("#invSubmit").click(function () {
            if ($('#new_innovation_form').valid()) {
                var msg = '';
                var country = $("#country option:selected").text();
                var based_on = $("input[name=location]:checked").val();
                var ent_type = $("input[name=compnay_type]:checked").val();
                var impact = $("input[name=impact_type]:checked").val();
                if (based_on != 'yes') {
                    msg = msg +
                            "\n   •  Incubatee is not based in India. Our incubates and supports social incubates that work or intend to work in India. We do not incubate social incubates in other countries at this time. \n";

                }
                if (ent_type != 'profit') {
                    msg = msg +
                            "\n   •  Incubatee is registered as a non-profit. We are only incubates and supports for-profit incubates.  \n";
                }
                var income = '';
                var income_res = [];
                $("input[name='beneficiary[]']:checked").each(function () {

                    if ($(this).val() == "Rural or urban middle income" || $(this).val() ==
                            "Rural or urban high income")
                        income_res.push('true');
                    else
                        income_res.push('false');
                });

                if ($.inArray('false', income_res))
                    income = 'yes';
                else
                    income = 'no';

                if (income == 'yes') {
                    msg = msg +
                            "\n   • The beneficiaries of product or service are high or middle income groups. Our incubates and supports social incubates that have impact on people at the base of the pyramid, or with rural and urban poor. \n";
                }
                if (impact != 'Direct') {
                    msg = msg + "\n   • The impact of product or service is not direct \n";
                }

                if (msg != '') {
                    if (confirm("Incubatee is not eligible for the Our Incubation program because \n" +
                            msg +
                            " \nPlease change your registration information if possible to proceed.\n\n Click cancel to modify your registration information. Click ok to reset the registration. "
                            ))
                        return true;
                    else
                        return false;
                } else {
                    return true;
                }

            } else {
                $("#inv_add_info1").slideToggle();
            }
        });
    });
</script>
<style type="text/css">
    .dialogaddSeasons {
        display: block;
        float: left;
        height: 150px;
        outline-color: -moz-use-text-color;
        outline-style: none;
        outline-width: 0;
        right: 305px;
        left: 486px;
        top: -643.6px;
        width: 490px;
        z-index: 1002;
    }

    .ui-widget-overlay {
        background: none;
        opacity: none;
    }

    .ui-dialog-titlebar-close {
        display: inline-block;
        float: right;
    }
</style>

<form name="new_innovation_form" action="" enctype="multipart/form-data" method="post" id="new_innovation_form"
      class="uniform"
      <?php echo ($this->session->userdata("user_type") == "superadmin" ? "style= 'display:block'" : ($this->session->userdata("partner_id") == 2 ? "style= 'display:none'" : "style= 'display:block'" )); ?>>

    <dl class="inline">
        <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
            <dt><label for="branch">Partner<span class="req_field">*</span></label></dt>
            <dd>
                <select name="branch" id="branch" class="required branch" onchange="invState(this.value)">
                    <option value="">Select Partner</option>
                    <?php foreach ($branch as $partner) { ?>
                        <option value="<?php echo $partner['id']; ?>"><?php echo $partner['branch_name']; ?> </option>
                    <?php } ?>
                </select>
            </dd>
        <?php } ?>

        <dt>
            <label>Name of Incubatee<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="ent_name" name="ent_name" placeholder="" class="required input-text " size="40"
                   value="" />
        </dd>

        <dt>
            <label>Name of Entrepreneur<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="name_entr" name="name_entr" placeholder="" class="required input-text " size="40"
                   value="" />
        </dd>

        <dt>
            <label>Email<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="inv_email" name="inv_email" placeholder="" class="required input-text " size="40"
                   value="" />
            <span style="color:red;" id="email_exist"></span>
        </dd>

        <dt>
            <label>Mobile<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="inv_mobile" name="inv_mobile" placeholder="" class="required input-text " size="40"
                   value="" />
        </dd>

        <dt>
            <label>Address 1<span class="req_field">*</span></label>
        </dt>
        <dd class="text-area">
            <textarea cols="50" rows="5" id="address1" name="address1"></textarea>
        </dd>

        <dt>
            <label>Address 2</label>
        </dt>
        <dd class="text-area">
            <textarea cols="50" rows="5" id="address2" name="address2"></textarea>
        </dd>


        <dt>
            <label>Country<span class="req_field">*</span></label>
        </dt>
        <dd>
            <?php
            $coun = $this->Minnovation->getCountry();
            ?>
            <select id="country" name="country">
                <option value="">-Select-</option>
                <?php foreach ($coun as $row) { ?>
                    <option value="<?= $row['id'] ?>"><?= $row['country_name'] ?></option>
                <?php } ?>
            </select>
            <br /><label class="error" style="display:none" for="country">Please choose one.</label>
        </dd>

        <dt>
            <label>Source Name<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="inv_srcname" name="inv_srcname" placeholder="" class="required input-text" size="40"
                   maxlength="50" value="" />
        </dd>

        <dt>
            <label> Is your incubatee a <a href="javascript:(void)" id="profit_hint">(?)</a> <span
                    class="req_field">*</span></label>
            <div id="dialog" title="Information" style="display:none;height:100px;">
                <p><b>For-profit:</b> Incubatee must be registered or plans to register as a Private Limited Company
                    <br /> <b>Non-profit:</b> Incubatee is registered or plans to register as a Society, Trust or
                    Section 25 Company</p>
            </div>
        </dt>
        <dd>
            <input type="radio" name="compnay_type" id="compnay_type" value="profit">For-profit organization<br />
            <input type="radio" name="compnay_type" id="compnay_type" value="nonprofit">Non-profit organization
            <br /><label class="error" style="display:none" for="compnay_type">Please choose one.</label>
        </dd>

        <dt>
            <label>Will your social incubatee be based in India<span class="req_field">*</span> </label>
        </dt>
        <dd>
            <input type="radio" name="location" id="location" value="yes">Yes <br />
            <input type="radio" name="location" id="location" value="no">No
            <br /><label class="error" style="display:none" for="location">Please choose one.</label>
        </dd>


        <dt>
            <label>Please select the relevant sector for your incubatee <span class="req_field">*</span> </label>
        </dt>
        <dd>
            <select name="inv_sector" id="inv_sector" onchange="insubsector(this.value);">
                <option value="">-Select-</option>
                <?php
                foreach ($sector_details as $index => $row) {
                    ?>

                    <option value="<?php echo $row['id'] ?>"><?php echo $row['sector'] ?></option>

                    <?php
                }
                ?>
            </select>
            <br /><label class="error" style="display:none" for="inv_sector">Please Select one.</label>
        </dd>

        <dt>
            <label>Please select the relevant sub sector for your incubatee <span class="req_field">*</span> </label>
        </dt>
        <dd>
            <select name="sub_sector" id="incsub_sector">
                <option value="">-Select-</option>
            </select>
            <br /><label class="error" style="display:none" for="sub_sector">Please Select one.</label>
        </dd>

        <dt>
            <label>Who will be the beneficiaries of your product / service? <span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="checkbox" name="beneficiary[]" id="beneficiary"
                   value="People at the base of the pyramid">People at the base of the pyramid <br />
            <input type="checkbox" name="beneficiary[]" id="beneficiary" value="Rural poor">Rural poor <br />
            <input type="checkbox" name="beneficiary[]" id="beneficiary" value="Urban poor">Urban poor <br />
            <input type="checkbox" name="beneficiary[]" id="beneficiary" value="Rural or urban middle income">Rural or
            urban middle income <br />
            <input type="checkbox" name="beneficiary[]" id="beneficiary" value="Rural or urban high income">Rural or
            urban high income
            <br /><label class="error" style="display:none" for="beneficiary[]">Please choose one.</label>
        </dd>
        <dt>
            <label>What type of impact will your product / service have on the BoP / poor?<span
                    class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="radio" name="impact_type" id="impact_type" value="Direct">Direct <br />
            <input type="radio" name="impact_type" id="impact_type" value="Indirect">Indirect
            <br /><label for="impact_type" class="error" style="display:none">Please choose one.</label>
        </dd>


        <dt style="float:right;">
            <h1><a href="#bottom" id="inv_info1" style="color:#719e41;">** Add Additional Information</a></h1>
        </dt>
        <div id="inv_add_info1" style="display:none;">

            <?php
            for ($i = 1; $i <= 4; $i++) {
                $imp = '';
                if ($i == 1) {
                    $imp = '<span class="req_field">*</span>';
                }
                ?>
                <dt>
                    <h3 style="color:green">Member <?php echo $i; ?></h3>
                </dt>
                <dt>
                    <label>Name <?= $imp ?></label>
                </dt>
                <dd>
                    <input type="text" id="team_name<?php echo $i; ?>" name="team_name[<?php echo $i; ?>]" size="40"
                           placeholder="" value="" />
                </dd>

                <dt>
                    <label>Current designation / occupation <?= $imp ?></label>
                </dt>
                <dd>
                    <input type="text" id="team_desg<?php echo $i; ?>" name="team_desg[<?php echo $i; ?>]" size="40"
                           placeholder="" value="" />
                </dd>

                <dt>
                    <label>Current organisation <?= $imp ?></label>
                </dt>
                <dd>
                    <input type="text" id="team_org<?php echo $i; ?>" name="team_org[<?php echo $i; ?>]" size="40"
                           placeholder="" value="" />
                </dd>

                <dt>
                    <label>Email<?= $imp ?> </label>
                </dt>
                <dd>
                    <input type="text" id="team_email<?php echo $i; ?>" name="team_email[<?php echo $i; ?>]" size="40"
                           placeholder="" value="" onblur="email_valid(this.value, 'team_email<?php echo $i; ?>');" />
                    <span id="team_email<?php echo $i; ?>_error" style="color:red"></span>
                </dd>
                <dt>
                    <label>Mobile <?= $imp ?></label>
                </dt>
                <dd>

                    <input type="text" id="team_mob<?php echo $i; ?>" name="team_mob[<?php echo $i; ?>]" size="40"
                           placeholder="" value="" onblur="mob_valid(this.value, 'team_mob<?php echo $i; ?>');" />
                    <span id="team_mob<?php echo $i; ?>_error" style="color:red"></span>
                </dd>
                <dt>
                    <label>Upload Resume</label>
                </dt>
                <dd>
                    <span id="team_res<?php echo $i; ?>_file">
                        <input type="file" id="team_res<?php echo $i; ?>" name="team_res[<?php echo $i; ?>]" size="40"
                               placeholder="" onblur="resume_valid(this.value, 'team_res<?php echo $i; ?>');" />
                    </span>
                    <span id="team_res<?php echo $i; ?>_error" style="color:red"></span>
                    <br /><span style="font-size:10px;color:#5A555A">(Supports only doc,docx,ppt,pptx,pdf files)</span>
                </dd>

            <?php } ?>

            <dt>
                <label>How long have you been in operation <span class="req_field">*</span> </label>
            </dt>
            <dd>
                <select id="in_operation" name="in_operation">
                    <option value="">-Select</option>
                    <option value="0to6">0 – 6 months</option>
                    <option value="6to12">6 – 12 months</option>
                    <option value="1">1 year </option>
                    <option value="2">2 years </option>
                </select>
            </dd>
            <dt>
                <label>In which states are you operating / plan to operate <span class="req_field">*</span> </label>
            </dt>
            <dd>
                <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
                    <select style="height:200px;width:485px;" id="inv_state" name="inv_state[]" class="multiselect"
                            multiple="multiple">

                    </select>
                <?php } else {
                    ?>
                    <select style="height:200px;width:485px;" id="inv_state" name="inv_state[]" class="multiselect"
                            multiple="multiple">

                        <?php
                        $state = $this->Minnovation->getPartnerState($this->session->userdata("partner_id"));
                        foreach ($state as $row) {
                            ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['state_name']; ?></option>
                        <?php } ?>

                    </select>
                <?php } ?>
                <label class="error" for="inv_state" style="display:none">This field is required.</label>
            </dd>
            <dt>
                <label>Are you developing a <span class="req_field">*</span></label>
            </dt>
            <dd>
                <select id="type_prod" name="type_prod">
                    <option value="">-Select</option>
                    <option value="Product">Product</option>
                    <option value="Service">Service</option>
                </select>
            </dd>


            <dt>
                <label>At what stage is your product / service <span class="req_field">*</span> </label>
            </dt>
            <dd>
                <select id="stage_prod" name="stage_prod">
                    <option value="">-Select</option>
                    <option value="Idea">Idea</option>
                    <option value="Proof of concept">Proof of concept</option>
                    <option value="Prototype development">Prototype development</option>
                    <option value="Prototype testing">Prototype testing</option>
                    <option value="Technical pilot">Technical pilot</option>
                    <option value="Commercial pilot">Commercial pilot</option>
                    <option value="Production">Production</option>
                    <option value="Growth">Growth</option>
                    <option value="Scaling">Scaling</option>
                </select>
            </dd>

            <dt class="text-label">
                <label>Provide a brief description of your innovation (product or service) </label>
            </dt>
            <dd class="text-area">
                <textarea class="input-text" id="inno_desc" cols="50" rows="5" name="inno_desc"
                          onKeyUp="limitText(this.form.inno_desc, this.form.countdown_inno_desc, 250);"></textarea>
                <div class="spacer"></div>
                <span style="margin:5px 0px 0px;">(Maximum words: 250). You have
                    <input readonly="readonly" type="text" name="countdown_inno_desc" id="countdown_inno_desc" size="3"
                           value="250" style="width:40px;" />
                    words left.</span>
            </dd>

            <dt class="text-label">
                <label>What problem does your innovation address? </label>
            </dt>
            <dd class="text-area">
                <textarea class="input-text" cols="50" rows="5" id="inno_prob" name="inno_prob"
                          onKeyUp="limitText(this.form.inno_prob, this.form.countdown_inno_prob, 250);"></textarea>
                <div class="spacer"></div>
                <span style="margin:5px 0px 0px;">(Maximum words: 250). You have
                    <input readonly="readonly" type="text" name="countdown_inno_prob" id="countdown_inno_prob" size="3"
                           value="250" style="width:40px;" />
                    words left.</span>
            </dd>


            <dt class="text-label">
                <label>How is the need addressed without your innovation? What are the available alternatives?</label>
            </dt>
            <dd class="text-area">
                <textarea class="input-text" cols="50" rows="5" id="avail_alter" name="avail_alter"
                          onKeyUp="limitText(this.form.avail_alter, this.form.countdown_avail_alter, 250);"></textarea>
                <div class="spacer"></div>
                <span style="margin:5px 0px 0px;">(Maximum words: 250). You have
                    <input readonly="readonly" type="text" name="countdown_avail_alter" id="countdown_avail_alter"
                           size="3" value="250" style="width:40px;" />
                    words left.</span>
            </dd>


            <dt class="text-label">
                <label>Describe your proposed / current business model </label>
            </dt>
            <dd class="text-area">
                <textarea class="input-text" cols="50" rows="5" id="prop_model" name="prop_model"
                          onKeyUp="limitText(this.form.prop_model, this.form.countdown_prop_model, 250);"></textarea>
                <div class="spacer"></div>
                <span style="margin:5px 0px 0px;">(Maximum words: 250). You have
                    <input readonly="readonly" type="text" name="countdown_prop_model" id="countdown_prop_model"
                           size="3" value="250" style="width:40px;" />
                    words left.</span>
            </dd>


            <dt class="text-label">
                <label>What challenges / risks have you identified in the business? </label>
            </dt>
            <dd class="text-area">
                <textarea class="input-text" cols="50" rows="5" id="ident_risk" name="ident_risk"
                          onKeyUp="limitText(this.form.ident_risk, this.form.countdown_ident_risk, 250);"></textarea>
                <div class="spacer"></div>
                <span style="margin:5px 0px 0px;">(Maximum words: 250). You have
                    <input readonly="readonly" type="text" name="countdown_ident_risk" id="countdown_ident_risk"
                           size="3" value="250" style="width:40px;" />
                    words left.</span>
            </dd>

            <dt class="text-label">
                <label>Who is the intended primary beneficiary of your product / service? </label>
            </dt>
            <dd class="text-area">
                <textarea class="input-text" cols="50" rows="5" id="prim_benefi" name="prim_benefi"
                          onKeyUp="limitText(this.form.prim_benefi, this.form.countdown_prim_benefi, 200);"></textarea>
                <div class="spacer"></div>
                <span style="margin:5px 0px 0px;">(Maximum words: 200). You have
                    <input readonly="readonly" type="text" name="countdown_prim_benefi" id="countdown_prim_benefi"
                           size="3" value="200" style="width:40px;" />
                    words left.</span>
            </dd>

            <dt class="text-label">
                <label>Have you conducted research on your customer segments / run pilots? <span
                        class="req_field">*</span></label>
            </dt>
            <dd class="text-area">
                <select name="cust_seg" id="cust_seg" onchange="show_div_inv(this.value);" style="width:250px;">
                    <option value="">-Select</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </dd>

            <div id="cus_seg_yes" style="display:none">
                <dt class="text-label">
                    <label>If yes, please provide the following information</label>
                    <label>What is the demographic profile of the primary beneficiary group?</label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text" cols="50" rows="5" id="benefi_grp" name="benefi_grp"
                              onKeyUp="limitText(this.form.benefi_grp, this.form.countdown_benefi_grp, 200);"></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 200). You have
                        <input readonly="readonly" type="text" name="countdown_benefi_grp" id="countdown_benefi_grp"
                               size="3" value="200" style="width:40px;" />
                        words left.</span>
                </dd>

                <dt class="text-label">
                    <label>What is the average monthly earning of the primary beneficiary group?</label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text" cols="50" rows="5" id="avg_earn" name="avg_earn"
                              onKeyUp="limitText(this.form.avg_earn, this.form.countdown_avg_earn, 100);"></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 100). You have
                        <input readonly="readonly" type="text" name="countdown_avg_earn" id="countdown_avg_earn"
                               size="3" value="100" style="width:40px;" />
                        words left.</span>
                </dd>
            </div>

            <dt class="text-label">
                <label>How many people do you expect to impact through your innovation?</label>
            </dt>
            <dd class="text-area">
                <textarea class="input-text" cols="50" rows="5" id="no_impact" name="no_impact"
                          onKeyUp="limitText(this.form.no_impact, this.form.countdown_no_impact, 100);"></textarea>
                <div class="spacer"></div>
                <span style="margin:5px 0px 0px;">(Maximum words: 100). You have
                    <input readonly="readonly" type="text" name="countdown_no_impact" id="countdown_no_impact" size="3"
                           value="100" style="width:40px;" />
                    words left.</span>
            </dd>

            <dt class="text-label">
                <label>Will your product or service benefit other beneficiary groups? Describe these groups briefly.
                </label>
            </dt>
            <dd class="text-area">
                <textarea class="input-text" cols="50" rows="5" id="service_benefit" name="service_benefit"
                          onKeyUp="limitText(this.form.service_benefit, this.form.countdown_service_benefit, 200);"></textarea>
                <div class="spacer"></div>
                <span style="margin:5px 0px 0px;">(Maximum words: 200). You have
                    <input readonly="readonly" type="text" name="countdown_service_benefit"
                           id="countdown_service_benefit" size="3" value="200" style="width:40px;" />
                    words left.</span>
            </dd>

            <dt>
                <label class="text-label">Please indicate the support you would like from us: <span
                        class="req_field">*</span></label>
            </dt>
            <dd class="text-area">
                <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]"
                       class="input-text" value="Funding" />Funding <br />
                <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]"
                       class="input-text" value="Mentoring" />Mentoring <br />
                <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]"
                       class="input-text" value="Talent" />Talent <br />
                <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]"
                       class="input-text" value="Networks" />Networks <br />
                <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]"
                       class="input-text" value="Capacity building" />Capacity building <br />
                <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]"
                       class="input-text" value="Training" />Training <br />
                <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]"
                       class="input-text" value="Board formation" />Board formation <br />
                <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]"
                       class="input-text" value="Technology transfer " />Technology transfer <br />
                <input type="checkbox" class="check support_check" size="40" id="vill_support" name="vill_support[]"
                       class="input-text" value="Other" />Other
                <br /><label class="error" for="vill_support[]" style="display:none">This field is required.</label>
            </dd>

            <div id="other_support" style="display:none">
                <dt>
                    <label class="text-label">Please Mention Support <span class="req_field">*</span></label>
                </dt>
                <dd class="text-area">
                    <input type="text" size="40" id="otr_support" name="otr_support" class="input-text" value="" />
                </dd>
            </div>

            <dt>
                <label class="text-label">How did you hear about our program <span class="req_field">*</span> </label>
            </dt>
            <dd class="text-area">
                <input type="checkbox" class="check" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                       value="Referral" />Referral <br />
                <input type="checkbox" class="check" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                       value="Online" />Online <br />
                <input type="checkbox" class="check" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                       value="Newspaper" />Newspaper <br />
                <input type="checkbox" class="check" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                       value="Past incubatee" />Past incubatee <br />
                <input type="checkbox" class="check" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                       value="Villgro staff" />Our staff<br />
                <input type="checkbox" class="check" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                       value="Other" />Other
                <br /><label class="error" for="abt_vill[]" style="display:none">This field is required.</label>
            </dd>

            <div id="referral_name" style="display:none">
                <dt>
                    <label class="text-label">Name</label>
                </dt>
                <dd class="text-area">
                    <input type="text" size="40" id="ref_name" name="ref_name" class="input-text" value="" />
                </dd>
            </div>

            <dt>
                <label class="text-label"> Have you been incubated, funded or participated in an accelerator program
                    with another organization?<span class="req_field">*</span> </label>
            </dt>
            <dd class="text-area">
                <input type="radio" class="check" size="40" id="with_other_org" name="with_other_org" class="input-text"
                       value="Yes" onclick="show_org(this.value);" />Yes<br />
                <input type="radio" class="check" size="40" id="with_other_org" name="with_other_org" class="input-text"
                       value="No" onclick="show_org(this.value);" />No<br />
                <label class="error" for="with_other_org" style="display:none">This field is required.</label>
            </dd>
            <div id="other_org" style="display:none">
                <dt>
                    <label class="text-label"> Name of organization(s) </label>
                </dt>
                <dd class="text-area">
                    <input type="text" size="40" id="other_org_name" name="other_org_name" class="input-text"
                           value="" />
                </dd>
            </div>
            <dt>
                <label class="text-label"> Have you participated in or won any business plan competitions?<span
                        class="req_field">*</span> </label>
            </dt>
            <dd class="text-area">
                <input type="radio" class="check" size="40" id="competition" name="competition" class="input-text"
                       value="Yes" onclick="show_compet(this.value);" />Yes<br />
                <input type="radio" class="check" size="40" id="competition" name="competition" class="input-text"
                       value="No" onclick="show_compet(this.value);" />No<br />
                <label class="error" for="competition" style="display:none">This field is required.</label>
            </dd>

            <div id="bus_compet" style="display:none">
                <dt>
                    <label class="text-label"> Name of business plan competition(s) </label>
                </dt>
                <dd class="text-area">
                    <input type="text" size="40" id="business_compet" name="business_compet" class="input-text"
                           value="" />
                </dd>
            </div>
            <dt>
                <label>Upload Business plan (if available) </label>
            </dt>
            <dd>
                <input type="file" size="40" name="busi_plan" id="busi_plan" class="input-text" value="" />
                <br /><span style="font-size:10px;color:#5A555A">(Supports only doc,docx,ppt,pptx,pdf files)</span>
            </dd>
            <dt>
                <label>Upload Additional Information </label>
            </dt>
            <dd>
                <input type="file" size="40" name="add_info_file" id="add_info_file" class="input-text" value="" />
                <br /><span style="font-size:10px;color:#5A555A">(Supports only doc,docx,ppt,pptx,pdf files)</span>
            </dd>

        </div>


    </dl>
    <div class="clear"></div>
    <div class="buttons">
        <button type="submit" class="button" id="invSubmit" name="invSubmit" value="Submit">Submit</button>
        <button type="reset" class="button white" name="txtReset" value="Reset">Reset</button>
    </div>
</form>
<form name="kenya_form" action="" enctype="multipart/form-data" method="post" id="kenya_form" class="uniform"
      <?php echo ($this->session->userdata("user_type") == "superadmin" ? "style= 'display:none'" : ($this->session->userdata("partner_id") != 2 ? "style= 'display:none'" : "style= 'display:block'" )); ?>>

    <dl class="inline">

        <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
            <dt><label for="branch">Partner<span class="req_field">*</span></label></dt>
            <dd>
                <select name="branch" id="branch" class="required branch" onchange="invState(this.value)">
                    <option value="">Select Partner</option>
                    <?php foreach ($branch as $partner) { ?>
                        <option value="<?php echo $partner['id']; ?>"><?php echo $partner['branch_name']; ?> </option>
                    <?php } ?>
                </select>
            </dd>
        <?php } ?>


        <dt>
            <label> Your Name<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="name_entr" name="name_entr" placeholder="" class="required input-text " size="40"
                   value="" />
        </dd>
        <dt>
            <label>Email<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="inv_email" name="inv_email" placeholder="" class="required input-text " size="40"
                   value="" />
        </dd>

        <dt>
            <label>Phone Number <span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="inv_mobile" name="inv_mobile" placeholder="" class="required input-text " size="40"
                   value="" />
        </dd>

        <dt>
            <label> Website URL </label>
        </dt>
        <dd>
            <input type="text" name="website_url" size="40" id="website_url" />
        </dd>
        <dt>
            <label>Name of your Incubatee<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="ent_name" name="ent_name" placeholder="" class="required input-text " size="40"
                   value="" />
        </dd>
        <?php
        for ($i = 1; $i <= 2; $i++) {
            $imp = '';
            if ($i == 1) {
                $imp = '<span class="req_field">*</span>';
            }
            ?>
            <dt>
                <h3 style="color:green">Member <?php echo $i; ?></h3>
            </dt>
            <dt>
                <label>Name <?= $imp ?></label>
            </dt>
            <dd>
                <input type="text" id="team_name<?php echo $i; ?>" name="team_name[<?php echo $i; ?>]" size="40"
                       placeholder="" value="" />
            </dd>

            <dt>
                <label>Current designation / occupation <?= $imp ?></label>
            </dt>
            <dd>
                <input type="text" id="team_desg<?php echo $i; ?>" name="team_desg[<?php echo $i; ?>]" size="40"
                       placeholder="" value="" />
            </dd>

            <dt>
                <label>Current organisation <?= $imp ?></label>
            </dt>
            <dd>
                <input type="text" id="team_org<?php echo $i; ?>" name="team_org[<?php echo $i; ?>]" size="40"
                       placeholder="" value="" />
            </dd>

            <dt>
                <label>Email<?= $imp ?> </label>
            </dt>
            <dd>
                <input type="text" id="team_email<?php echo $i; ?>" name="team_email[<?php echo $i; ?>]" size="40"
                       placeholder="" value="" onblur="email_valid(this.value, 'team_email<?php echo $i; ?>');" />
                <span id="team_email<?php echo $i; ?>_error" style="color:red"></span>
            </dd>
            <dt>
                <label>Mobile <?= $imp ?></label>
            </dt>
            <dd>

                <input type="text" id="team_mob<?php echo $i; ?>" name="team_mob[<?php echo $i; ?>]" size="40"
                       placeholder="" value="" onblur="mob_valid(this.value, 'team_mob<?php echo $i; ?>');" />
                <span id="team_mob<?php echo $i; ?>_error" style="color:red"></span>
            </dd>
            <dt>
                <label>Upload Resume </label>
            </dt>
            <dd>
                <span id="team_res<?php echo $i; ?>_file">
                    <input type="file" id="team_res<?php echo $i; ?>" name="team_res[<?php echo $i; ?>]" size="40"
                           placeholder="" onblur="resume_valid(this.value, 'team_res<?php echo $i; ?>');" />
                </span>
                <span id="team_res<?php echo $i; ?>_error" style="color:red"></span>
                <br /><span style="font-size:10px;color:#5A555A">(Supports only doc,docx,ppt,pptx,pdf files)</span>
            </dd>

        <?php } ?>

        <dt>
            <label>Type of organization <span class="req_field">*</span></label>
        </dt>
        <dd>
            <select name="compnay_type" id="compnay_type">
                <option value="">-Select-</option>
                <option value="profit">For-profit organization</option>
                <option value="nonprofit">Non-profit organization</option>
            </select>

        </dd>
        <dt>
            <label>Brief description of your company <span class="req_field">*</span></label>
        </dt>
        <dd class="text-area">
            <textarea id="company_desc" name="company_desc" rows="5"
                      cols="50"><?php echo isset($ent['inv_desc']) ? $ent['inv_desc'] : ''; ?></textarea>
        </dd>
        <dt>
            <label> Where is your incubatee based? <span class="req_field">*</span></label>
        </dt>
        <dd class="text-area">
            <textarea id="location" name="location" rows="5"
                      cols="50"><?php echo isset($ent['inv_desc']) ? $ent['inv_desc'] : ''; ?></textarea>
        </dd>
        <dt>
            <label>How did you hear about Villgro Kenya <span class="req_field">*</span> </label>
        </dt>
        <dd>
            <?php $hearabt = explode(',', $add['hear_abt']); ?>
            <label class="regulr">
                <input type="checkbox" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                       <?php echo (in_array('Referral', $hearabt)) ? 'checked' : ''; ?> value="Referral" /> Referral
            </label> <br />
            <label class="regulr"><input type="checkbox" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                                         <?php echo (in_array('Online', $hearabt)) ? 'checked' : ''; ?> value="Online" /> Online </label>
            <br />
            <label class="regulr"> <input type="checkbox" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                                          <?php echo (in_array('Newspaper', $hearabt)) ? 'checked' : ''; ?> value="Newspaper" /> Newspaper
            </label><br />
            <label class="regulr"><input type="checkbox" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                                         <?php echo (in_array('Past incubatee', $hearabt)) ? 'checked' : ''; ?> value="Past incubatee" />
                Past incubatee </label> <br />
            <label class="regulr"><input type="checkbox" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                                         <?php echo (in_array('Villgro staff', $hearabt)) ? 'checked' : ''; ?> value="Villgro staff" /> Our
                staff </label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                                          <?php echo (in_array('Other', $hearabt)) ? 'checked' : ''; ?> value="Other" /> Other </label> <br />
            <br /><label class="error" for="abt_vill[]" style="display:none">This field is required.</label>
        </dd>
        <?php
        $naming = array('Referral', 'Past incubatee', 'Villgro staff');
        $array = array_intersect($naming, $hearabt);
        ?>
        <div id="referal" style=<?php echo (!empty($array)) ? "display:block" : "display:none"; ?>>
            <dt>
                <label>Name:</label>
            </dt>
            <dd>
                <input type="text" size="40" id="referal_name" name="referal_name" class="input-text"
                       value="<?php echo isset($add['referal_name']) ? $add['referal_name'] : ''; ?>" />
            </dd>
        </div>
        <dt>
            <label>Please indicate the relevant sectors of your business <span class="req_field">*</span> </label>
        </dt>
        <dd>
            <?php $sectors = explode(',', $add['sectors']); ?>
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                          <?php echo (in_array('Agri-business', $sectors)) ? 'checked' : ''; ?> value="Agri-business" />
                Agri-business</label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                          <?php echo (in_array('Healthcare', $sectors)) ? 'checked' : ''; ?> value="Healthcare" />
                Healthcare</label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                          <?php echo (in_array('ICT', $sectors)) ? 'checked' : ''; ?> value="ICT" /> ICT </label><br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                <?php echo (in_array('Cosmetics and wellness', $sectors)) ? 'checked' : ''; ?>
                                          value="Cosmetics and wellness" /> Cosmetics and wellness</label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                          <?php echo (in_array('Ergonomics', $sectors)) ? 'checked' : ''; ?> value="Ergonomics" /> Ergonomics
            </label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                <?php echo (in_array('Automation/mechanization of agriculture', $sectors)) ? 'checked' : ''; ?>
                                          value="Automation/mechanization of agriculture" /> Automation/mechanization of agriculture</label>
            <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                          <?php echo (in_array('Pest control', $sectors)) ? 'checked' : ''; ?> value="Pest control" /> Pest
                control</label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                <?php echo (in_array('Post harvest technologies', $sectors)) ? 'checked' : ''; ?>
                                          value="Post harvest technologies" /> Post harvest technologies </label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                <?php echo (in_array('Industrial application of biotechnology', $sectors)) ? 'checked' : ''; ?>
                                          value="Industrial application of biotechnology" /> Industrial application of biotechnology </label>
            <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                <?php echo (in_array('Green/environmental friendly technologies', $sectors)) ? 'checked' : ''; ?>
                                          value="Green/environmental friendly technologies" /> Green/environmental friendly technologies
            </label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                          <?php echo (in_array('MCH', $sectors)) ? 'checked' : ''; ?> value="MCH" /> Maternal and Child Health
            </label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                <?php echo (in_array('Water and sanitation', $sectors)) ? 'checked' : ''; ?>
                                          value="Water and sanitation" /> Water and Sanitation </label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                          <?php echo (in_array('Waste management', $sectors)) ? 'checked' : ''; ?> value="Waste management" />
                Waste Management </label> <br />
            <label class="regulr"><input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                         <?php echo (in_array('Medical Devices', $sectors)) ? 'checked' : ''; ?> value="Medical Devices" />
                Medical Devices</label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                          <?php echo (in_array('Diagnostics', $sectors)) ? 'checked' : ''; ?> value="Diagnostics" />
                Diagnostics</label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                          <?php echo (in_array('Drugs', $sectors)) ? 'checked' : ''; ?> value="Drugs" /> Drugs </label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                          <?php echo (in_array('Vaccines', $sectors)) ? 'checked' : ''; ?> value="Vaccines" /> Vaccines
            </label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                <?php echo (in_array('eHealth Technologies', $sectors)) ? 'checked' : ''; ?>
                                          value="eHealth Technologies" /> eHealth Technologies </label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                <?php echo (in_array('mHealth Technologies', $sectors)) ? 'checked' : ''; ?>
                                          value="mHealth Technologies" /> mHealth Technologies </label> <br />
            <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                <?php echo (in_array('Sanitation / Environmental Health', $sectors)) ? 'checked' : ''; ?>
                                          value="Sanitation / Environmental Health" /> Sanitation / Environmental Health <br />
                <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                              <?php echo (in_array('Epidemiology', $sectors)) ? 'checked' : ''; ?> value="Epidemiology" />
                    Epidemiology </label> <br />
                <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                    <?php echo (in_array('Public Health Tools', $sectors)) ? 'checked' : ''; ?>
                                              value="Public Health Tools" /> Public Health Tools </label> <br />
                <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                              <?php echo (in_array('Vector Control', $sectors)) ? 'checked' : ''; ?> value="Vector Control" />
                    Vector Control </label> <br />
                <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                              <?php echo (in_array('Biotechnology', $sectors)) ? 'checked' : ''; ?> value="Biotechnology" />
                    Biotechnology </label> <br />
                <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                    <?php echo (in_array('Pharmaceuticals', $sectors)) ? 'checked' : ''; ?>
                                              value="Pharmaceuticals" /> Pharmaceuticals </label> <br />
                <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                              <?php echo (in_array('Plant health', $sectors)) ? 'checked' : ''; ?> value="Plant health" />
                    Plant health </label> <br />
                <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                              <?php echo (in_array('Animal health', $sectors)) ? 'checked' : ''; ?> value="Animal health" />
                    Animal health </label> <br />
                <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                              <?php echo (in_array('Nutrition', $sectors)) ? 'checked' : ''; ?> value="Nutrition" /> Nutrition
                </label><br />
				<label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                          <?php echo (in_array('Gender Inclusion', $sectors)) ? 'checked' : ''; ?> value="Gender Inclusion" />
                Gender Inclusion</label> <br />
                <label class="regulr"> <input type="checkbox" size="40" id="sector" name="sector[]" class="input-text"
                                              <?php echo (in_array('Others', $sectors)) ? 'checked' : ''; ?> value="Others" /> Others </label>
                <br />
                <label class="error" for="sector[]" style="display:none">This field is required.</label>

        </dd>
        <dt>
            <label>If other please specify </label>
        </dt>
        <dd>
            <input type="text" size="40" id="sector_other" name="sector_other" class="input-text"
                   value="<?php echo isset($mem_email[1]['email']) ? $mem_email[1]['email'] : ''; ?>" />
        </dd>
        <dt>
            <label style="line-height:1.5!important">Who are the beneficiaries of your incubatee? <span
                    class="req_field">*</span></label>
        </dt>
        <dd>
            <label class="regulr">
                <input type="checkbox" name="beneficiary[]" id="beneficiary"
                       value="People at the base of the pyramid"><span class="l-label"> People at the base of the
                    pyramid</span> </label> <br />
            <label class="regulr"> <input type="checkbox" name="beneficiary[]" id="beneficiary" value="Rural poor"><span
                    class="l-label"> Rural poor</span> </label> <br />
            <label class="regulr"> <input type="checkbox" name="beneficiary[]" id="beneficiary" value="Urban poor"><span
                    class="l-label"> Urban poor</span> </label> <br />
            <label class="regulr"> <input type="checkbox" name="beneficiary[]" id="beneficiary"
                                          value="Rural or urban middle income"><span class="l-label"> Rural or urban middle income</span>
            </label> <br />
            <label class="regulr"> <input type="checkbox" name="beneficiary[]" id="beneficiary"
                                          value="Rural or urban high income"><span class="l-label"> Rural or urban high income</span> </label>
            <br />
            <label class="error" for="beneficiary[]" style="display:none">This field is required.</label>
        </dd>
        <dt>
            <label>​What type of impact will your product/service have on the BoP/poor? <span
                    class="req_field">*</span></label>
        </dt>
        <dd>
            <select name="impact_type" id="impact_type">
                <option value="">-Select-</option>
                <option value="Direct">Direct</option>
                <option value="Indirect">Indirect</option>
            </select>

        </dd>
        <dt>
            <label>What is innovative about your idea/incubatee? <span class="req_field">*</span></label>
        </dt>
        <dd class="text-area">
            <textarea class="input-text" id="inv_idea_ent" name="inv_idea_ent" rows="5"
                      cols="50"><?php echo isset($ent['inv_idea_ent']) ? $ent['inv_idea_ent'] : ''; ?></textarea>
        </dd>
    </dl>
    <div class="clear"></div>
    <div class="buttons">
        <button type="submit" class="button" id="invSubmit" name="invSubmit" value="Submit">Submit</button>
        <button type="reset" class="button white" name="txtReset" value="Reset">Reset</button>
    </div>
</form>



<script type="text/javascript">
    $('#inv_email').on('blur', function () {
        var mailID = $('#inv_email').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/scouting/check_mail_exists",
            data: {
                mailid: mailID
            },
            dataType: 'html',
            success: function (msg) {
                if (msg > 0) {
                    $('#email_exist').html('Email already exist');
                    setTimeout(function () {
                        $('#email_exist').html('');
                        $('#inv_email').val('');
                    }, 3000);
                } else {
                    $('#email_exist').html('');
                }
            },
        });
    });

    function insubsector(val) {

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/scouting/getSubsector",
            data: {
                sector_id: val
            },
            dataType: 'json',
            success: function (msg) {
                $('#incsub_sector').find('option').not(':first')
                        .remove()
                        .end();
                $.each(msg, function (i, value) {
                    $('#incsub_sector').append($('<option>').text(value.sector).attr('value', value
                            .id));
                });
            },
        });
    }
</script>