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
                dialogClass: "dialogaddSeasons"});
        });
    });


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

    function show_div(value)
    {
        if (value == 'yes')
        {
            $("#cus_seg_yes").css('display', 'block');
        } else
        {
            $("#cus_seg_yes").css('display', 'none');
        }
    }

    function show_org(value)
    {
        if (value == 'Yes')
        {
            $("#other_org").css('display', 'block');
        } else
        {
            $("#other_org").css('display', 'none');
        }
    }

    function show_compet(value)
    {
        if (value == 'Yes')
        {
            $("#bus_compet").css('display', 'block');
        } else
        {
            $("#bus_compet").css('display', 'none');
        }
    }

    function show_compett(value)
    {
        if (value == 'Yes')
        {
            $("#age_companyy").css('display', 'block');
            $("#stage_cmpanyy").css('display', 'block');
        } else
        {
            $("#age_companyy").css('display', 'none');
            $("#stage_cmpanyy").css('display', 'none');
        }
    }

    function email_valid(value, id)
    {

        var reg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        if (value != '')
        {
            if (!reg.test(value))
            {
                $("#" + id).removeAttr('value');

                $("#" + id + "_error").text("'" + value + "' is not valid email id");

                setTimeout(function () {
                    $("#" + id).focus();
                }, 10);
            } else
            {
                $("#" + id + "_error").text("");
            }
        } else
        {
            $("#" + id + "_error").text("");
        }
    }
    function mob_valid(value, id)
    {
        if (value != '')
        {
            var filter = /^\+?[0-9 -]+$/;
            if (!filter.test(value))
            {
                $("#" + id).removeAttr('value');

                $("#" + id + "_error").text("'" + value + "' is not a valid phone number");

                setTimeout(function () {
                    $("#" + id).focus();
                }, 10);
            } else if (value.length > 15 || value.length < 10)
            {
                $("#" + id).removeAttr('value');

                $("#" + id + "_error").text("'" + value + "' length must be in the range of 10 - 15 digits");

                setTimeout(function () {
                    $("#" + id).focus();
                }, 10);
            } else
            {
                $("#" + id + "_error").text("");
            }
        } else
        {
            $("#" + id + "_error").text("");
        }
    }

    function res_valid(value, id)
    {
        var filename = $("#" + id).val();

        if (filename != '')
        {
            var extension = filename.replace(/^.*\./, '');
            if (extension == filename) {
                extension = '';
            } else {

                extension = extension.toLowerCase();
            }

            if (!(/\.(doc|docx|ppt|pptx|pdf)$/i).test(filename))
            {

                $("#" + id + "_file .filename").html('No file selected');
                var fieldSpan = $("#" + id + "_file");
                console.log(fieldSpan);
                fieldSpan.html(fieldSpan.html());

                $("#" + id + "_error").text("'" + filename + "' Not supported. Please upload the specified file type");

                setTimeout(function () {
                    $("#" + id).focus();
                }, 10);
            } else
            {
                $("#" + id + "_file .filename").html(filename);
                $("#" + id + "_error").text("");
            }
        } else
        {
            $("#" + id + "_file .filename").html("No file selected");
            $("#" + id + "_error").text("");
        }

    }

    function plan_check(id)
    {

        var filename = $("#" + id).val();

        if (filename != '')
        {

            if (!(/\.(doc|docx|pdf|ppt|pptx)$/i).test(filename))
            {

                $("#" + id + "_file .filename").html('No file selected');
                var fieldSpan = $("#" + id + "_file");
                fieldSpan.html(fieldSpan.html());

                $("#" + id + "_error").text("'" + filename + "' Not supported. Please upload the specified file type").css('color', 'red');
                return false;
                setTimeout(function () {
                    $("#" + id).focus();
                }, 10);
            } else
            {
                $("#" + id + "_file .filename").html(filename);
                $("#" + id + "_error").text("");
                return true;
            }
        } else
        {
            $("#" + id + "_file .filename").html("No file selected");
            $("#" + id + "_error").text("");
            return true;
        }
    }
</script>
<script>
    $(document).ready(function () {

        $('.support_check').click(function () {
            if ($(this).is(":checked"))
                $("#other_support").css('display', 'block');
            else
                $("#other_support").css('display', 'none');

        });

        $('.check').click(function () {
            var name = [];
            $("input[name='abt_vill[]']:checked").each(function ()
            {
                if ($(this).val() == "Referral" || $(this).val() == "Past incubatee" || $(this).val() == "Villgro staff")
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

        $.validator.addMethod('filetype', function (value, element) {
            var id = $(element).attr('id');
            return plan_check(id);
        }, "File type not supported");

        $.validator.addMethod('numberonly', function (value, element) {
            return this.optional(element) || /^[0-9\ ]+$/.test(value);
        }, "Please enter number only");

        $.validator.addMethod("extension", function (value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, '|') : "doc|docx|ppt|pptx|pdf";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        }, "Not a valid file format.");

        $.validator.addMethod("maxfilesize", function (value, element) {
            return this.optional(element) || (element.files && element.files[0] && element.files[0].size <= 10008250);
        }, $.format('The file size cannot exceed 10MB.'));

        if ($('#inv_sector').val() != 'Maternal & child health') {
            $('.form').validate({
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
                    "gender[1]": "required",
                    "team_res[]": {extension: "doc|docx|ppt|pptx|pdf", maxfilesize: true},
                    in_operation: "required",
                    "inv_state[]": "required",
                    type_prod: "required",
                    stage_prod: "required",
                    cust_seg: "required",
                    "vill_support[]": "required",
                    otr_support: {
                        required: function (element) {
                            var name = [];
                            $("input[name='vill_support[]']:checked").each(function ()
                            {

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
                    busi_plan: {filetype: true, maxfilesize: true},
                    add_info_file: {filetype: true, maxfilesize: true}

                }
            });
        } else
        {

            $('.form').validate({
                rules: {
                    ent_name: "required",
                    name_entr: "required",
                    inv_email: {
                        required: true,
                        email: true
                    },
                    inv_mobile: {
                        required: true,
                        customphone: true
                    },
                    address1: "required",
                    country: "required",
                    compnay_type: "required",
                    location: "required",
                    sector: "required",
                    sub_sector: "required",
                    impact_type: "required",
                    "beneficiary[]": "required",
                    company: "required",
                    age_company: {
                        required: function (element) {
                            var name = [];
                            $("input[name='company']:checked").each(function ()
                            {

                                if ($(this).val() == "No")
                                    name.push('No');
                                else
                                    name.push('Yes');
                            });

                            if ($.inArray('No', name) != -1)
                                return false;
                            else
                                return true;
                        },
                        number: true,
                        numberonly: true
                    },
                    stage_cmpany: {
                        required: function (element) {
                            var name = [];
                            $("input[name='company']:checked").each(function ()
                            {

                                if ($(this).val() == "No")
                                    name.push('No');
                                else
                                    name.push('Yes');
                            });

                            if ($.inArray('No', name) != -1)
                                return false;
                            else
                                return true;
                        }
                    },
                    cust_seg: "required",
                    background: "required",
                    inno_prob: "required",
                    problrm_solv: "required",
                    medical_device: "required",
                    work_done: "required",
                    child_health: "required",
                    problem_time: "required",
                    tm_name1: "required",
                    tm_email1: {required: true,
                        email: true},
                    tm_phone1: {required: true,
                        customphone: true},
                    tm_name2: "required",
                    tm_email2: {required: true,
                        email: true},
                    tm_phone2: {required: true,
                        customphone: true},
                    tm_name3: "required",
                    tm_email3: {required: true,
                        email: true},
                    tm_phone3: {required: true,
                        customphone: true},
                    tm_resume: {
                        required: function () {
                            if ($("#tm_resume_old").val() == '')
                                return true;
                            else
                                return false;
                        },
                        extension: "doc|docx|ppt|pptx|pdf"
                    }
                }
            });
        }

        $("#invupdate").click(function () {
            if ($('.form').valid())
            {
                var msg = '';
                var country = $("#country option:selected").text();
                var based_on = $("input[name=location]:checked").val();
                var ent_type = $("input[name=compnay_type]:checked").val();
                var impact = $("input[name=impact_type]:checked").val();
                if (based_on != 'yes')
                {
                    msg = msg + "\n   •  Incubatee is not based in India. Villgro incubates and supports social incubates that work or intend to work in India. We do not incubate social incubates in other countries at this time. \n";

                }
                if (ent_type != 'profit')
                {
                    msg = msg + "\n   •  Incubatee is registered as a non-profit. Villgro only incubates and supports for-profit incubates.  \n";
                }
                var income = '';
                var income_res = [];
                $("input[name='beneficiary[]']:checked").each(function ()
                {
                    if ($(this).val() == "Rural or urban middle income" || $(this).val() == "Rural or urban high income")
                        income_res.push('true');
                    else
                        income_res.push('false');
                });
                if ($.inArray('false', income_res))
                    income = 'yes';
                else
                    income = 'no';

                if (income == 'yes')
                {
                    msg = msg + "\n   • The beneficiaries of product or service are high or middle income groups. Villgro incubates and supports social incubates that have impact on people at the base of the pyramid, or with rural and urban poor. \n";
                }
                if (impact != 'Direct')
                {
                    msg = msg + "\n   • The impact of  product or service is not direct \n";
                }
                if (msg != '')
                {
                    return true;
                } else
                {
                    return true;
                }
            } else
            {
                $("#inv_add_info1").show();
            }
        });
    });
    function show_compett(value)
    {
        if (value == 'Yes')
        {
            $("#age_companyy").css('display', 'block');
            $("#stage_cmpanyy").css('display', 'block');
        } else
        {
            $("#age_companyy").css('display', 'none');
            $("#stage_cmpanyy").css('display', 'none');
        }
    }
</script>
<style type="text/css">
    .dialogaddSeasons
    {
        display:block;
        float:left;
        height:150px;
        outline-color:-moz-use-text-color;
        outline-style:none;
        outline-width:0;
        right:305px;
        left: 478 !important;
        top: -494.6 !important;
        width:490px;
        z-index:1002;
    }
    .ui-widget-overlay {
        background: none;
        opacity:none;
    }
    .ui-dialog-titlebar-close{
        display:inline-block;float:right;
    }
</style>


<br />
<h2 style="font-family:Gill !important;"><?= $cpagetitle ?> </h2>
<div class="clear"></div>

<form name="new_innovation_form" class="form" action="<?php echo site_url('scouting/inv_app_edit_save/' . $this->uri->segment('3') . '/' . $this->uri->segment('4')); ?>" enctype="multipart/form-data" method="post" id="new_innovation_form" class="uniform">

    <dl class="inline">

        <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $innovationDetails[0]['partner_id']; ?>">
        <dt>
            <label>Name of Incubatee<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="ent_name" name="ent_name" placeholder="" class="input-text " size="40" value="<?php echo $inv_user[0]['ent_name']; ?>"/>
        </dd>

        <dt>
            <label>Name of Entrepreneur<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="name_entr" name="name_entr" placeholder="" class="input-text " size="40" value="<?php echo $inv_user[0]['applicant_name']; ?>"/>
        </dd>

        <dt>
            <label>Email<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="inv_email" name="inv_email" placeholder="" class="input-text " size="40" value="<?php echo $inv_user[0]['email']; ?>"/>
            <span style="color:red;" id="email_exist"></span>
        </dd>

        <dt>
            <label>Mobile<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="inv_mobile" name="inv_mobile" placeholder="" class="input-text " size="40" value="<?php echo $inv_user[0]['mobile']; ?>"/>
        </dd>

        <dt>
            <label>Address 1<span class="req_field">*</span></label>
        </dt>
        <dd class="text-area">
            <textarea  cols="50" rows="5" id="address1" name="address1"  ><?php echo $inv_user[0]['address1']; ?></textarea>
        </dd>

        <dt>
            <label>Address 2</label>
        </dt>
        <dd class="text-area">
            <textarea  cols="50" rows="5" id="address2" name="address2"  ><?php echo $inv_user[0]['address2']; ?></textarea>
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
                    <option value="<?= $row['id'] ?>" <?php if ($inv_user[0]['country'] == $row['id']) echo "selected='selected'"; ?>><?= $row['country_name'] ?></option>
                <?php } ?>
            </select>
        </dd>

        <dt>
            <label>Source Name<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="inv_srcname" name="inv_srcname" placeholder="" class="required input-text" size="40" maxlength="50" value="<?php echo $innovationDetails[0]['sourceName']; ?>"/>
        </dd>

        <dt>
            <label> Is your incubatee a <a href="javascript:(void)" id="profit_hint">(?)</a><span class="req_field">*</span></label>
            <div id="dialog" title="Information" style="display:none;height:100px;">
                <p><b>For-profit:</b> Incubatee must be registered or plans to register as a Private Limited Company
                    <br/> <b>Non-profit:</b> Incubatee is registered or plans to register as a Society, Trust or Section 25 Company</p>
            </div>
        </dt>
        <dd>
            <input type="radio" name="compnay_type" id="compnay_type" value="profit" <?php if ($inv_user[0]['ent_type'] == 'profit') echo "checked='checked'"; ?>>For-profit organization<br/>
            <input type="radio" name="compnay_type" id="compnay_type" value="nonprofit" <?php if ($inv_user[0]['ent_type'] == 'nonprofit') echo "checked='checked'"; ?>>Non-profit organization
            <label for="compnay_type" class="error" style="display:none;">Please choose one.</label>
        </dd>

        <dt>
            <label>Will your social incubatee be based in India<span class="req_field">*</span> </label>

        </dt>
        <dd>
            <input type="radio" name="location" id="location" value="yes"<?php if ($inv_user[0]['india_based'] == 'yes') echo "checked='checked'"; ?> >Yes <br/>
            <input type="radio" name="location" id="location" value="no" <?php if ($inv_user[0]['india_based'] == 'no') echo "checked='checked'"; ?>>No
            <label for="location" class="error" style="display:none;">Please choose one.</label>
        </dd>

        <dt class="fund1">
            <label>Sector <span class="req_field">*</span> </label>
        </dt>
        <dd class="fund2">
            <select id="inv_sector" name="inv_sector" onchange="subsector(this.value)">
                <option value="">-Select-</option>
                <?php
                foreach ($sectors_values as $row) {
                    ?>
                    <option value="<?php echo $row['id']; ?>" <?php
                    if ($inv_user[0]['ent_sector'] == $row['id']) {
                        echo 'selected';
                    }
                    ?> ><?php echo $row['sector']; ?></option>

                    <?php
                }
                ?>
            </select>
        </dd>

        <div id="cleantech_div">
            <dt class="fund1">
                <label for="emailer">Please select a Sub Sector<span class="req_field">*</span></label>
            </dt>
            <dd class="fund2" id="sub_sector_cat">
                <select id="sub_sector" name="sub_sector">
                    <option value="">-Select-</option>
                    <?php if (php72_cmp($inv_user[0]['sub_sector']) != 0 || $inv_user[0]['sub_sector'] != '') { ?>
                        <option value="<?php echo $subSectorName[0]['id']; ?>" selected><?php echo $subSectorName[0]['sector']; ?></option>
                    <?php } ?>
                </select>
            </dd>
        </div>

        <dt>
            <label>Who will be the beneficiaries of your product / service? <span class="req_field">*</span></label>
        </dt>
        <dd>
            <?php
            $beneficiary = unserialize($inv_user[0]['benificiary']);
            ?>
            <input type="checkbox" name="beneficiary[]" id="beneficiary" value="People at the base of the pyramid" <?php if (php72_in_array('People at the base of the pyramid', $beneficiary)) echo "checked='checked'"; ?> >People at the base of the pyramid <br/>
            <input type="checkbox" name="beneficiary[]" id="beneficiary" value="Rural poor" <?php if (php72_in_array('Rural poor', $beneficiary)) echo "checked='checked'"; ?>>Rural poor <br/>
            <input type="checkbox" name="beneficiary[]" id="beneficiary" value="Urban poor" <?php if (php72_in_array('Urban poor', $beneficiary)) echo "checked='checked'"; ?>>Urban poor <br/>
            <input type="checkbox" name="beneficiary[]" id="beneficiary" value="Rural or urban middle income" <?php if (php72_in_array('Rural or urban middle income', $beneficiary)) echo "checked='checked'"; ?>>Rural or urban middle income <br/>
            <input type="checkbox" name="beneficiary[]" id="beneficiary" value="Rural or urban high income" <?php if (php72_in_array('Rural or urban high income', $beneficiary)) echo "checked='checked'"; ?> >Rural or urban high income <br/>
            <label for="beneficiary" class="error" id="error1" style="display:none"></label>
        </dd>
        <dt>
            <label>What type of impact will your product / service have on the BoP / poor?<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="radio" name="impact_type" id="impact_type" value="Direct" <?php if ($inv_user[0]['impact_of_product'] == 'Direct') echo "checked='checked'"; ?>>Direct  <br/>
            <input type="radio" name="impact_type" id="impact_type" value="Indirect" <?php if ($inv_user[0]['impact_of_product'] == 'Indirect') echo "checked='checked'"; ?>>Indirect
            <label for="impact_type" class="error" id="error1" style="display:none"></label>
        </dd>



        <dt style="float:right;"><h1><a href="#bottom" id="inv_info1" style="color:#719e41;">** Add Additional Information</a></h1></dt>
        <?php if (!empty($inv_user) && $inv_user[0]['ent_sector'] != 'MCH' && $inv_user[0]['ent_sector'] != "Maternal & child health") { ?>
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
                        <input type="text" id="team_name<?php echo $i; ?>" name="team_name[<?php echo $i; ?>]" size="40" placeholder="" value="<?php if (isset($inv_team[$i - 1]['mem_name'])) echo $inv_team[$i - 1]['mem_name']; ?> "/>
                        <input type="hidden" id="team_id<?php echo $i; ?>" name="team_id[<?php echo $i; ?>]" value="<?php if (isset($inv_team[$i - 1]['id'])) echo $inv_team[$i - 1]['id']; ?>"/>
                    </dd>

                    <dt>
                        <label>Current designation / occupation <?= $imp ?></label>
                    </dt>
                    <dd>
                        <input type="text" id="team_desg<?php echo $i; ?>" name="team_desg[<?php echo $i; ?>]" size="40" placeholder="" value="<?php if (isset($inv_team[$i - 1]['mem_occupation'])) echo $inv_team[$i - 1]['mem_occupation']; ?>"/>

                    </dd>

                    <dt>
                        <label>Current organisation <?= $imp ?></label>
                    </dt>
                    <dd>
                        <input type="text" id="team_org<?php echo $i; ?>" name="team_org[<?php echo $i; ?>]" size="40" placeholder="" value="<?php if (isset($inv_team[$i - 1]['mem_org'])) echo $inv_team[$i - 1]['mem_org']; ?>"/>

                    </dd>

                    <dt>
                        <label>Email<?= $imp ?> </label>
                    </dt>
                    <dd>
                        <input type="text" id="team_email<?php echo $i; ?>" name="team_email[<?php echo $i; ?>]" size="40" placeholder="" value="<?php if (isset($inv_team[$i - 1]['mem_email'])) echo $inv_team[$i - 1]['mem_email']; ?>" onblur="email_valid(this.value, 'team_email<?php echo $i; ?>');" />
                        <span id="team_email<?php echo $i; ?>_error" style="color:red"></span>
                    </dd>
                    <dt>
                        <label>Mobile <?= $imp ?></label>
                    </dt>
                    <dd>

                        <input type="text" id="team_mob<?php echo $i; ?>" name="team_mob[<?php echo $i; ?>]"  size="40" placeholder=""  value="<?php if (isset($inv_team[$i - 1]['mem_mobile'])) echo $inv_team[$i - 1]['mem_mobile']; ?>" onblur="mob_valid(this.value, 'team_mob<?php echo $i; ?>');"/>
                        <span id="team_mob<?php echo $i; ?>_error" style="color:red"></span>

                    </dd>
                    <dt>
                        <label>Gender<?php if ($i == 1) { ?><span class="req_field">*</span><?php } ?></label>
                    </dt>
                    <dd>
                        <div class="chkbox chkboxiframe" style="width:60px !important;">
                            <label class="check">
                                <input type="radio" id="tm_gender" name="gender[<?php echo $i; ?>]" value="male" <?php
                                if ($inv_team[$i - 1]['mem_gender'] == 'male') {
                                    echo 'checked="checked"';
                                }
                                ?> />
                                Male</label>
                        </div>
                        <div class="chkbox chkboxiframe" style="width:75px !important;">
                            <label class="check">
                                <input type="radio" id="tm_gender" name="gender[<?php echo $i; ?>]" value="female" <?php
                                if ($inv_team[$i - 1]['mem_gender'] == 'female') {
                                    echo 'checked="checked"';
                                }
                                ?> />
                                Female</label>
                        </div>
                        <div class="chkbox chkboxiframe" style="width:60px !important;">
                            <label class="check">
                                <input type="radio" id="tm_gender" name="gender[<?php echo $i; ?>]" value="other" <?php
                                if ($inv_team[$i - 1]['mem_gender'] == 'other') {
                                    echo 'checked="checked"';
                                }
                                ?> />
                                Other</label>
                        </div>
                    </dd>
                    <dt>
                        <label>Upload Resume</label>
                    </dt>
                    <dd>
                        <span id="team_res<?php echo $i; ?>_file">
                            <input type="file" id="team_res<?php echo $i; ?>" name="team_res[<?php echo $i; ?>]"  size="40" placeholder=""  onblur="res_valid(this.value, 'team_res<?php echo $i; ?>');"/>
                            <?php
                            if (isset($inv_team[$i - 1]['mem_resume']) && $inv_team[$i - 1]['mem_resume'] != '') {
                                ?>
                                <a href="<?php echo host_url() . 'IncubationForm/uploads/' . $inv_team[$i - 1]['mem_resume']; ?>" target="_blank"><?php echo $inv_team[$i - 1]['mem_resume']; ?></a>
                            <?php } ?>
                            <input type="hidden" id="hidden_team_res<?php echo $i; ?>" name="hidden_team_res[<?php echo $i; ?>]" value="<?php if (isset($inv_team[$i - 1]['mem_resume'])) echo $inv_team[$i - 1]['mem_resume']; ?>"/>
                        </span>
                        <span id="team_res<?php echo $i; ?>_error" style="color:red"></span>
                        <br/><span style="font-size:10px;color:#5A555A">(Supports only doc,docx,ppt,pptx,pdf files)</span>
                    </dd>

                <?php } ?>

                <dt >
                    <label>How long have you been in operation <span class="req_field">*</span> </label>
                </dt>
                <dd>
                    <select id="in_operation" name="in_operation">
                        <option value="">-Select</option>
                        <option value="0to6" <?php if ($inv_ent_info[0]['in_operation'] == '0to6') echo "selected='selected'"; ?>>0 – 6 months</option>
                        <option value="6to12" <?php if ($inv_ent_info[0]['in_operation'] == '6to12') echo "selected='selected'"; ?>>6 – 12 months</option>
                        <option value="1" <?php if ($inv_ent_info[0]['in_operation'] == '1') echo "selected='selected'"; ?>>1 year </option>
                        <option value="2" <?php if ($inv_ent_info[0]['in_operation'] == '2') echo "selected='selected'"; ?>>2 years </option>
                    </select>
                </dd>
                <dt >
                    <label>In which states are you operating / plan to operate <span class="req_field">*</span> </label>
                </dt>
                <dd >
                    <select style="height:200px;width:485px;" id="inv_state" name="inv_state[]"  class="multiselect" multiple="multiple">

                        <?php
                        if ($innovationDetails[0]['partner_id'] == '2') {
                            $state = $this->Minnovation->getKenyaState();
                            $states = explode(',', $inv_ent_info[0]['operate_on_state']);
                        } else {

                            $state = $this->Minnovation->getState();
                            $states = explode(',', $inv_ent_info[0]['operate_on_state']);
                        }

                        foreach ($state as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" <?php if (in_array($row['id'], $states)) echo "selected='selected'"; ?> ><?= $row['state_name'] ?></option>
                        <?php } ?>
                    </select>
                    <br/><label for="inv_state" generated="true" class="error" style="display:none;">This field is required.</label>
                </dd>
                <dt >
                    <label>Are you developing a <span class="req_field">*</span></label>
                </dt>
                <dd >

                    <select id="type_prod" name="type_prod">
                        <option value="">-Select</option>
                        <option value="Product" <?php if ($inv_ent_info[0]['develop_product'] == "Product") echo "selected='selected'"; ?>>Product</option>
                        <option value="Service" <?php if ($inv_ent_info[0]['develop_product'] == "Service") echo "selected='selected'"; ?>>Service</option>
                    </select>
                </dd>


                <dt >
                    <label>At what stage is your product / service <span class="req_field">*</span> </label>
                </dt>
                <dd >
                    <select id="stage_prod" name="stage_prod">
                        <option value="">-Select</option>
                        <option value="Idea" <?php if ($inv_ent_info[0]['stage_product'] == "Idea") echo "selected='selected'"; ?>>Idea</option>
                        <option value="Proof of concept" <?php if ($inv_ent_info[0]['stage_product'] == "Proof of concept") echo "selected='selected'"; ?>>Proof of concept</option>
                        <option value="Prototype development" <?php if ($inv_ent_info[0]['stage_product'] == "Prototype development") echo "selected='selected'"; ?>>Prototype development</option>
                        <option value="Prototype testing" <?php if ($inv_ent_info[0]['stage_product'] == "Prototype testing") echo "selected='selected'"; ?>>Prototype testing</option>
                        <option value="Technical pilot" <?php if ($inv_ent_info[0]['stage_product'] == "Technical pilot") echo "selected='selected'"; ?>>Technical pilot</option>
                        <option value="Commercial pilot" <?php if ($inv_ent_info[0]['stage_product'] == "Commercial pilot") echo "selected='selected'"; ?>>Commercial pilot</option>
                        <option value="Production" <?php if ($inv_ent_info[0]['stage_product'] == "Production") echo "selected='selected'"; ?>>Production</option>
                        <option value="Growth" <?php if ($inv_ent_info[0]['stage_product'] == "Growth") echo "selected='selected'"; ?>>Growth</option>
                        <option value="Scaling" <?php if ($inv_ent_info[0]['stage_product'] == "Scaling") echo "selected='selected'"; ?>>Scaling</option>
                    </select>
                </dd>

                <dt class="text-label">
                    <label>Provide a brief description of your innovation (product or service) <span class="req_field">*</span></label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text txtdescription" id="inno_desc" cols="50" rows="5" name="inno_desc" onKeyUp="limitText(this.form.inno_desc, this.form.countdown_inno_desc, 250);"><?php echo $inv_ent_info[0]['inv_desc']; ?></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 250). You have
                        <input readonly="readonly" type="text" name="countdown_inno_desc" id="countdown_inno_desc" size="3" value="250" style="width:40px;" />
                        words left.</span>
                </dd>

                <dt class="text-label">
                    <label>What problem does your innovation address? <span class="req_field"></span></label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text txtdescription" cols="50" rows="5" id="inno_prob" name="inno_prob" onKeyUp="limitText(this.form.inno_prob, this.form.countdown_inno_prob, 250);"><?php echo $inv_ent_info[0]['inv_problem']; ?></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 250). You have
                        <input readonly="readonly" type="text" name="countdown_inno_prob" id="countdown_inno_prob" size="3" value="250" style="width:40px;" />
                        words left.</span>
                </dd>


                <dt class="text-label">
                    <label>How is the need addressed without your innovation? What are the available alternatives?</label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text txtdescription" cols="50" rows="5" id="avail_alter" name="avail_alter" onKeyUp="limitText(this.form.avail_alter, this.form.countdown_avail_alter, 250);"><?php echo $inv_ent_info[0]['inv_alternatives']; ?></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 250). You have
                        <input readonly="readonly" type="text" name="countdown_avail_alter" id="countdown_avail_alter" size="3" value="250" style="width:40px;" />
                        words left.</span>
                </dd>


                <dt class="text-label">
                    <label>Describe your proposed / current business model <span class="req_field"></span></label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text txtdescription" cols="50" rows="5" id="prop_model" name="prop_model" onKeyUp="limitText(this.form.prop_model, this.form.countdown_prop_model, 250);"><?php echo $inv_ent_info[0]['proposal_desc']; ?></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 250). You have
                        <input readonly="readonly" type="text" name="countdown_prop_model" id="countdown_prop_model" size="3" value="250" style="width:40px;" />
                        words left.</span>
                </dd>


                <dt class="text-label">
                    <label>What challenges / risks have you identified in the business? </label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text txtdescription" cols="50" rows="5" id="ident_risk" name="ident_risk" onKeyUp="limitText(this.form.ident_risk, this.form.countdown_ident_risk, 250);"><?php echo $inv_ent_info[0]['inv_risks']; ?></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 250). You have
                        <input readonly="readonly" type="text" name="countdown_ident_risk" id="countdown_ident_risk" size="3" value="250" style="width:40px;" />
                        words left.</span>
                </dd>

                <dt class="text-label">
                    <label>Who is the intended primary beneficiary of your product / service?  <span class="req_field"></span></label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text txtdescription"  cols="50" rows="5" id="prim_benefi" name="prim_benefi" onKeyUp="limitText(this.form.prim_benefi, this.form.countdown_prim_benefi, 200);"><?php echo $inv_impact[0]['primary_benifi']; ?></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 200). You have
                        <input readonly="readonly" type="text" name="countdown_prim_benefi" id="countdown_prim_benefi" size="3" value="200" style="width:40px;" />
                        words left.</span>
                </dd>

                <dt class="text-label">
                    <label>Have you conducted research on your customer segments / run pilots? <span class="req_field">*</span></label>
                </dt>
                <dd class="text-area">
                    <select name="cust_seg" id="cust_seg" onchange="show_div(this.value);" style="width:250px;">
                        <option value="" >-Select</option>
                        <option value="yes" <?php if ($inv_impact[0]['research_cus_seg'] == 'yes') echo "selected='selected'"; ?>>Yes</option>
                        <option value="no" <?php if ($inv_impact[0]['research_cus_seg'] == 'no') echo "selected='selected'"; ?>>No</option>
                    </select>
                </dd>

                <div id="cus_seg_yes" style="<?php
                if ($inv_impact[0]['research_cus_seg'] == 'yes')
                    echo "display:block";
                else
                    echo "display:none";
                ?>" >
                    <dt class="text-label">
                        <label>If yes, please provide the following information</label>
                        <label>What is the demographic profile of the primary beneficiary group?</label>
                    </dt>
                    <dd class="text-area">
                        <textarea class="input-text txtdescription" cols="50" rows="5" id="benefi_grp" name="benefi_grp" onKeyUp="limitText(this.form.benefi_grp, this.form.countdown_benefi_grp, 200);"><?php echo $inv_impact[0]['demographic_profie']; ?></textarea>
                        <div class="spacer"></div>
                        <span style="margin:5px 0px 0px;">(Maximum words: 200). You have
                            <input readonly="readonly" type="text" name="countdown_benefi_grp" id="countdown_benefi_grp" size="3" value="200" style="width:40px;" />
                            words left.</span>
                    </dd>

                    <dt class="text-label">
                        <label>What is the average monthly earning of the primary beneficiary group?</label>
                    </dt>
                    <dd class="text-area">
                        <textarea class="input-text txtdescription" cols="50" rows="5" id="avg_earn" name="avg_earn" onKeyUp="limitText(this.form.avg_earn, this.form.countdown_avg_earn, 100);"><?php echo $inv_impact[0]['avg_monthly']; ?></textarea>
                        <div class="spacer"></div>
                        <span style="margin:5px 0px 0px;">(Maximum words: 100). You have
                            <input readonly="readonly" type="text" name="countdown_avg_earn" id="countdown_avg_earn" size="3" value="100" style="width:40px;" />
                            words left.</span>
                    </dd>
                </div>
                <dt class="text-label">
                    <label>How many people do you expect to impact through your innovation?</label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text txtdescription"  cols="50" rows="5" id="no_impact" name="no_impact" onKeyUp="limitText(this.form.no_impact, this.form.countdown_no_impact, 100);"><?php echo $inv_impact[0]['inv_impact']; ?></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 100). You have
                        <input readonly="readonly" type="text" name="countdown_no_impact" id="countdown_no_impact" size="3" value="100" style="width:40px;" />
                        words left.</span>
                </dd>

                <dt class="text-label">
                    <label>Will your product or service benefit other beneficiary groups? Describe these groups briefly.  </label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text txtdescription" cols="50" rows="5" id="service_benefit" name="service_benefit" onKeyUp="limitText(this.form.service_benefit, this.form.countdown_service_benefit, 200);"><?php echo $inv_impact[0]['others_benefit']; ?></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 200). You have
                        <input readonly="readonly" type="text" name="countdown_service_benefit" id="countdown_service_benefit" size="3" value="200" style="width:40px;" />
                        words left.</span>
                </dd>

                <dt>
                    <?php
                    if (php72_cmp($this->session->userdata['partner_id']) == 6) {
                        $status = 'KIIT';
                    } else if (php72_cmp($this->session->userdata['partner_id']) == 4) {
                        $status = 'Oasis';
                    } else if (php72_cmp($this->session->userdata['partner_id']) == 5) {
                        $status = 'IIMC';
                    } else if (php72_cmp($this->session->userdata['partner_id']) == 7) {
                        $status = 'SIIC';
                    } else if (php72_cmp($this->session->userdata['partner_id']) == 1) {
                        $status = 'Villgro';
                    }
                    ?>
                    <label class="text-label">Please indicate the support you would like from <?php echo $status; ?>: <span class="req_field">*</span></label>
                </dt>
                <dd class="text-area">
                    <?php
                    $vill_support = explode(",", $add_info[0]['from_villgro']);
                    ?>
                    <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]" class="input-text" value="Funding" <?php if (in_array('Funding', $vill_support)) echo "checked='checked'"; ?>/>Funding <br/>
                    <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]" class="input-text" value="Mentoring" <?php if (in_array('Mentoring', $vill_support)) echo "checked='checked'"; ?>/>Mentoring <br/>
                    <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]" class="input-text" value="Talent" <?php if (in_array('Talent', $vill_support)) echo "checked='checked'"; ?>/>Talent <br/>
                    <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]" class="input-text" value="Networks" <?php if (in_array('Networks', $vill_support)) echo "checked='checked'"; ?>/>Networks <br/>
                    <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]" class="input-text" value="Capacity building" <?php if (in_array('Capacity building', $vill_support)) echo "checked='checked'"; ?>/>Capacity building <br/>
                    <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]" class="input-text" value="Training" <?php if (in_array('Training', $vill_support)) echo "checked='checked'"; ?>/>Training <br/>
                    <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]" class="input-text" value="Board formation" <?php if (in_array('Board formation', $vill_support)) echo "checked='checked'"; ?>/>Board formation <br/>
                    <input type="checkbox" class="check" size="40" id="vill_support" name="vill_support[]" class="input-text" value="Technology transfer" <?php if (in_array('Technology transfer', $vill_support)) echo "checked='checked'"; ?>/>Technology transfer <br/>
                    <input type="checkbox" class="check support_check" size="40" id="vill_support" name="vill_support[]" class="input-text" value="Other" <?php if (in_array('Other', $vill_support)) echo "checked='checked'"; ?>/>Other<br/>
                    <label for="vill_support[]" generated="true" class="error" style="display:none">This field is required.</label>
                </dd>

                <?php
                $display_otr = 'none';
                if (in_array('Other', $vill_support))
                    $display_otr = 'block';
                ?>
                <div id="other_support" style="display:<?= $display_otr ?>">
                    <dt >
                        <label class="text-label">Please Mention Support <span class="req_field">*</span></label>
                    </dt>
                    <dd class="text-area">
                        <input type="text"  size="40" id="otr_support" name="otr_support" class="input-text" value="<?php echo $add_info[0]['support_name']; ?>"/>
                    </dd>
                </div>
                <?php
                if (php72_cmp($this->session->userdata['partner_id']) == 6) {
                    $status = 'KIIT';
                } else if (php72_cmp($this->session->userdata['partner_id']) == 4) {
                    $status = 'Oasis';
                } else if (php72_cmp($this->session->userdata['partner_id']) == 5) {
                    $status = 'IIMC';
                } else if (php72_cmp($this->session->userdata['partner_id']) == 7) {
                    $status = 'SIIC';
                } else if (php72_cmp($this->session->userdata['partner_id']) == 1) {
                    $status = 'Villgro';
                }
                ?>
                <dt >
                    <label class="text-label">How did you hear about <?php echo $status; ?> <span class="req_field">*</span> </label>
                </dt>
                <dd class="text-area">
                    <?php
                    $hear_abt = explode(",", $add_info[0]['hear_abt']);
                    ?>
                    <input type="checkbox" class="check" size="40" id="abt_vill" name="abt_vill[]" class="input-text" value="Referral" <?php if (in_array('Referral', $hear_abt)) echo "checked='checked'"; ?>/>Referral <br/>
                    <input type="checkbox" class="check" size="40" id="abt_vill" name="abt_vill[]" class="input-text" value="Online" <?php if (in_array('Online', $hear_abt)) echo "checked='checked'"; ?>/>Online <br/>
                    <input type="checkbox" class="check" size="40" id="abt_vill" name="abt_vill[]" class="input-text" value="Newspaper" <?php if (in_array('Newspaper', $hear_abt)) echo "checked='checked'"; ?>/>Newspaper <br/>
                    <input type="checkbox" class="check" size="40" id="abt_vill" name="abt_vill[]" class="input-text" value="Past incubatee" <?php if (in_array('Past incubatee', $hear_abt)) echo "checked='checked'"; ?>/>Past incubatee <br/>
                    <input type="checkbox" class="check" size="40" id="abt_vill" name="abt_vill[]" class="input-text" value="Our staff" <?php if (in_array('Villgro staff', $hear_abt)) echo "checked='checked'"; ?>/>Villgro staff<br/>
                    <input type="checkbox" class="check" size="40" id="abt_vill" name="abt_vill[]" class="input-text" value="Other" <?php if (in_array('Other', $hear_abt)) echo "checked='checked'"; ?>/>Other <br/>
                    <label for="abt_vill[]" generated="true" class="error" style="display:none">This field is required.</label>
                </dd>

                <?php
                $abtdisplay = 'none';
                if (in_array('Referral', $hear_abt) || in_array('Past incubatee', $hear_abt) || in_array('Villgro staff', $hear_abt))
                    $abtdisplay = 'block';
                ?>
                <div id="referral_name" style="display:<?= $abtdisplay ?>">
                    <dt >
                        <label class="text-label">Name</label>
                    </dt>
                    <dd class="text-area">
                        <input type="text"  size="40" id="ref_name" name="ref_name" class="input-text" value="<?= $add_info[0]['referal_name'] ?>"/>
                    </dd>
                </div>


                <dt >
                    <label class="text-label"> Have you been incubated, funded or participated in an accelerator program with another organization?<span class="req_field">*</span> </label>
                </dt>
                <dd class="text-area">
                    <input type="radio" class="check" size="40" id="with_other_org" name="with_other_org" class="input-text" value="Yes" <?php if ($add_info[0]['ant_org'] == 'Yes') echo "checked=checked"; ?> onclick="show_org(this.value);" />Yes<br/>
                    <input type="radio" class="check" size="40" id="with_other_org" name="with_other_org" class="input-text" value="No" <?php if ($add_info[0]['ant_org'] == 'No') echo "checked=checked"; ?> onclick="show_org(this.value);" />No<br/>
                    <label for="with_other_org" generated="true" class="error" style="display:none">This field is required.</label>
                </dd>

                <?php
                if ($add_info[0]['ant_org'] == 'Yes')
                    $disp = "block";
                else
                    $disp = "none";
                ?>
                <div id="other_org" style="display:<?= $disp ?>">
                    <dt >
                        <label class="text-label"> Name of organization(s) </label>
                    </dt>
                    <dd class="text-area">
                        <input type="text"  size="40" id="other_org_name" name="other_org_name" class="input-text" value="<?php echo $add_info[0]['ant_org_name']; ?>"/>
                    </dd>
                </div>
                <dt >
                    <label class="text-label"> Have you participated in or won any business plan competitions?<span class="req_field">*</span> </label>
                </dt>
                <dd class="text-area">
                    <input type="radio" class="check" size="40" id="competition" name="competition" class="input-text" value="Yes" onclick="show_compet(this.value);" <?php if ($add_info[0]['won_competition'] == 'Yes') echo "checked=checked"; ?> />Yes<br/>
                    <input type="radio" class="check" size="40" id="competition" name="competition" class="input-text" value="No" onclick="show_compet(this.value);" <?php if ($add_info[0]['won_competition'] == 'No') echo "checked=checked"; ?> />No<br/>
                    <label for="competition" generated="true" class="error" style="display:none">This field is required.</label>
                </dd>

                <div id="bus_compet" style="<?php
                if ($add_info[0]['won_competition'] == 'Yes')
                    echo "display:block";
                else
                    echo "display:none";
                ?>">
                    <dt >
                        <label class="text-label"> Name of business plan competition(s) </label>
                    </dt>
                    <dd class="text-area">
                        <input type="text"  size="40" id="business_compet" name="business_compet" class="input-text" value="<?php echo $add_info[0]['competition_name']; ?>"/>
                    </dd>
                </div>
                <dt>
                    <label>Upload Business plan (if available) </label>
                </dt>
                <dd>
                    <input type="file" size="40"  name="busi_plan" id="busi_plan" class="input-text" value="" onblur="plan_check('busi_plan');" />
                    <?php
                    if ($add_info[0]['business_plan'] != '') {
                        ?>
                        <a href="<?php echo host_url() . 'IncubationForm/uploads/' . $add_info[0]['business_plan']; ?>" target="_blank"><?php echo $add_info[0]['business_plan']; ?></a>
                    <?php } ?>
                    <input type="hidden" name="hidden_busi_plan" id="hidden_busi_plan" value="<?php echo $add_info[0]['business_plan']; ?>"/>
                    <br/><span style="font-size:10px;color:#5A555A">(Supports only doc,docx,ppt,pptx,pdf files)</span>
                    <br/><span id="busi_plan_error"></span>
                </dd>
                <dt>
                    <label>Upload Additional Information </label>
                </dt>
                <dd>
                    <input type="file" size="40"  name="add_info_file" id="add_info_file" class="input-text" value="" onblur="plan_check('add_info_file');"/>
                    <?php
                    if ($add_info[0]['add_info'] != '') {
                        ?>
                        <a href="<?php echo host_url() . 'IncubationForm/uploads/' . $add_info[0]['add_info']; ?>" target="_blank"><?php echo $add_info[0]['add_info']; ?></a>
                    <?php } ?>
                    <input type="hidden" name="hidden_add_info_file" id="hidden_add_info_file" value="<?php echo $add_info[0]['add_info']; ?>"/>
                    <br/><span style="font-size:10px;color:#5A555A">(Supports only doc,docx,ppt,pptx,pdf files)</span>
                    <br/><span id="add_info_file_error"></span>
                </dd>
            </div>
        <?php } else { //not MCH end  ?>
            <div id="inv_add_info1" style="display:none;">


                <dt >
                    <label class="text-label"> Have you already started a company?<span class="req_field">*</span> </label>
                </dt>
                <dd class="text-area">
                    <input type="radio" class="check" size="40" id="company" name="company" class="input-text" <?php
                    if (isset($mch_users) && !empty($mch_users)) {
                        if ($mch_users[0]["start_company"] == "Yes")
                            echo "checked='checked'";
                    }
                    ?> value="Yes" onclick="show_compett(this.value);" />Yes<br/>
                    <input type="radio" class="check" size="40" id="company" name="company" class="input-text" <?php
                    if (isset($mch_users) && !empty($mch_users)) {
                        if ($mch_users[0]["start_company"] == "No")
                            echo "checked='checked'";
                    }
                    ?> value="No" onclick="show_compett(this.value);" />No<br/>
                    <label class="error" for="competition"></label>
                </dd>

                <div id="age_companyy" style=<?php
                if (isset($mch_users) && !empty($mch_users)) {
                    echo ($mch_users[0]["start_company"] == "Yes") ? "display:block" : "display:none";
                }
                ?>>
                    <dt >
                        <label class="text-label"> How old is it?<span class="req_field">*</span> </label>
                    </dt>
                    <dd class="text-area">
                        <input type="text"  size="40" id="age_company" name="age_company" class="input-text" value="<?php echo isset($mch_users[0]['company_age']) ? $mch_users[0]['company_age'] : ''; ?>"/>
                    </dd>
                </div>
                <div id="stage_cmpanyy" style=<?php echo ($mch_users[0]["start_company"] == "Yes") ? "display:block" : "display:none"; ?>>
                    <dt >
                        <label class="text-label">What stage is it?<span class="req_field">*</span></label>
                    </dt>
                    <dd class="text-area">
                        <textarea class="input-text txtdescription" cols="50" rows="5" id="stage_cmpany" name="stage_cmpany" onKeyUp="limitText(this.form.stage_cmpany, this.form.countdown_stage_cmpany, 50);"><?php echo isset($mch_users[0]['company_stage']) ? $mch_users[0]['company_stage'] : ''; ?></textarea>
                        <div class="spacer"></div>
                        <span style="margin:5px 0px 0px;">(Maximum words: 50). You have
                            <input readonly="readonly" type="text" name="countdown_stage_cmpany" id="countdown_stage_cmpany" size="3" value="50" style="width:40px;" />
                            words left.</span>
                    </dd>
                </div>

                <dt >
                    <label class="text-label">What is your citizenship status?<span class="req_field">*</span></label>
                </dt>
                <dd >
                    <select name="cust_seg" id="cust_seg">
                        <option value="">-Select</option>
                        <option value="pio" <?php
                        if (isset($mch_users) && !empty($mch_users)) {
                            echo $selected = ($mch_users[0]["citizen_status"] == "pio") ? "selected" : "";
                        }
                        ?>>PIO</option>
                        <option value="oci" <?php
                        if (isset($mch_users) && !empty($mch_users)) {
                            echo $selected = ($mch_users[0]["citizen_status"] == "oci") ? "selected" : "";
                        }
                        ?>>OCI</option>
                        <option value="citizen" <?php
                        if (isset($mch_users) && !empty($mch_users)) {
                            echo $selected = ($mch_users[0]["citizen_status"] == "citizen") ? "selected" : "";
                        }
                        ?>>Citizen</option>
                    </select>
                </dd>


                <dt >
                    <label class="text-label">Is your background?<span class="req_field">*</span></label>
                </dt>
                <dd >
                    <select name="background" id="background">
                        <option value="">-Select</option>
                        <option value="clinical" <?php
                        if (isset($mch_users) && !empty($mch_users)) {
                            echo $selected = ($mch_users[0]["background"] == "clinical") ? "selected" : "";
                        }
                        ?>>Clinical</option>
                        <option value="technical" <?php
                        if (isset($mch_users) && !empty($mch_users)) {
                            echo $selected = ($mch_users[0]["background"] == "technical") ? "selected" : "";
                        }
                        ?>>Technical</option>
                        <option value="business" <?php
                        if (isset($mch_users) && !empty($mch_users)) {
                            echo $selected = ($mch_users[0]["background"] == "business") ? "selected" : "";
                        }
                        ?>>Business</option>
                        <option value="other" <?php
                        if (isset($mch_users) && !empty($mch_users)) {
                            echo $selected = ($mch_users[0]["background"] == "other") ? "selected" : "";
                        }
                        ?>>other</option>
                    </select>
                </dd>

                <dt >
                    <label class="text-label">Describe the problem in Maternal and Child Health you are most interested in solving?<span class="req_field">*</span></label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text txtdescription" cols="50" rows="5" id="inno_prob" name="inno_prob" onKeyUp="limitText(this.form.inno_prob, this.form.countdown_inno_prob, 150);"><?php echo isset($mch_users[0]['mch_problem']) ? $mch_users[0]['mch_problem'] : ''; ?></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 150). You have
                        <input readonly="readonly" type="text" name="countdown_inno_prob" id="countdown_inno_prob" size="3" value="150" style="width:40px;" />
                        words left.</span>
                </dd>
                <dt >
                    <label class="text-label">Why you are interested in solving this particular problem?<span class="req_field">*</span></label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text txtdescription" cols="50" rows="5" id="problrm_solv" name="problrm_solv" onKeyUp="limitText(this.form.problrm_solv, this.form.countdown_problrm_solv, 150);"><?php echo isset($mch_users[0]['problem_solving']) ? $mch_users[0]['problem_solving'] : ''; ?></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 150). You have
                        <input readonly="readonly" type="text" name="countdown_problrm_solv" id="countdown_problrm_solv" size="3" value="150" style="width:40px;" />
                        words left.</span>
                </dd>

                <dt >
                    <label class="text-label">What are your strengths/experience that will help you develop a medical device to solve this

                        problem? <span class="req_field">*</span></label>
                </dt>
                <dd>
                    <textarea class="input-text txtdescription" cols="50" rows="5" id="medical_device" name="medical_device" onKeyUp="limitText(this.form.medical_device, this.form.countdown_medical_device, 150);"><?php echo isset($mch_users[0]['strength_exp']) ? $mch_users[0]['strength_exp'] : ''; ?></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 150). You have
                        <input readonly="readonly" type="text" name="countdown_medical_device" id="countdown_medical_device" size="3" value="150" style="width:40px;" />
                        words left.</span>
                </dd>

                <dt >
                    <label class="text-label">Do you have any ideas about how to solve it? If so how much work have you done on exploring

                        them? <span class="req_field">*</span></label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text txtdescription" cols="50" rows="5" id="work_done" name="work_done" onKeyUp="limitText(this.form.work_done, this.form.countdown_work_done, 150);"><?php echo isset($mch_users[0]['idea_problem']) ? $mch_users[0]['idea_problem'] : ''; ?></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 150). You have
                        <input readonly="readonly" type="text" name="countdown_work_done" id="countdown_work_done" size="3" value="150" style="width:40px;" />
                        words left.</span>
                </dd>
                <dt >
                    <label class="text-label">Why are you interested in solving problems related to maternal and child health for the base of

                        the pyramid?<span class="req_field">*</span></label>
                </dt>
                <dd class="text-area">
                    <textarea class="input-text txtdescription" cols="50" rows="5" id="child_health" name="child_health" onKeyUp="limitText(this.form.child_health, this.form.countdown_child_health, 150);"><?php echo isset($mch_users[0]['intrest_solve']) ? $mch_users[0]['intrest_solve'] : ''; ?></textarea>
                    <div class="spacer"></div>
                    <span style="margin:5px 0px 0px;">(Maximum words: 150). You have
                        <input readonly="readonly" type="text" name="countdown_child_health" id="countdown_child_health" size="3" value="150" style="width:40px;" />
                        words left.</span>
                </dd>
                <dt >
                    <label class="text-label">Will you be working on this problem<span class="req_field">*</span>:</label>
                </dt>
                <dd >
                    <select name="problem_time" id="problem_time">
                        <option value="">-Select</option>
                        <option value="fulltime" <?php
                        if (isset($mch_users) && !empty($mch_users)) {
                            echo $selected = ($mch_users[0]["problem_time"] == "fulltime") ? "selected" : "";
                        }
                        ?>>Full Time</option>
                        <option value="parttime" <?php
                        if (isset($mch_users) && !empty($mch_users)) {
                            echo $selected = ($mch_users[0]["problem_time"] == "parttime") ? "selected" : "";
                        }
                        ?>>Part Time</option>
                    </select>
                </dd>
                <dt>
                    <label class="text-label"><p style="font-size:14px;color:#A9CF55;">Reference 1:</p></label>
                </dt>
                <dt >
                    <label class="text-label">Name<span class="req_field">*</span></label>
                </dt>
                <dd>
                    <input type="text" size="40" id="tm_name1" name="tm_name1" class="input-text" value="<?php echo isset($mch_users[0]['name1']) ? $mch_users[0]['name1'] : ''; ?>"/>
                    <input type="hidden" size="40" id="tm1_id" name="tm_id1" class="input-text" value="<?php echo isset($mem_id[0]['id']) ? $mem_id[0]['id'] : ''; ?>"/>
                </dd>

                <dt >
                    <label class="text-label">Email<span class="req_field">*</span></label>
                </dt>
                <dd>
                    <input type="text" size="40" id="tm_email1" name="tm_email1" class="input-text" value="<?php echo isset($mch_users[0]['email1']) ? $mch_users[0]['email1'] : ''; ?>" onblur="email_valid(this.value, 'tm_email1');" />
                    <span id="tm_email1_error" style="color:red"></span>
                </dd>
                <dt >
                    <label class="text-label">Mobile<span class="req_field">*</span></label>
                </dt>
                <dd >
                    <input type="text" size="40" id="tm_phone1" name="tm_phone1" class="input-text" value="<?php echo isset($mch_users[0]['phone1']) ? $mch_users[0]['phone1'] : ''; ?>" onblur="mob_valid(this.value, 'tm_phone1');"/>
                    <span id="tm_phone1_error" style="color:red"></span>
                </dd>
                <dt >
                    <label class="text-label"><p style="font-size:14px;color:#A9CF55;">Reference 2:</p></label>
                </dt>
                <dt>
                    <label class="text-label">Name<span class="req_field">*</span></label>
                </dt>
                <dd >
                    <input type="text" size="40"  name="tm_name2" id="tm_name2" class="input-text" value="<?php echo isset($mch_users[0]['name2']) ? $mch_users[0]['name2'] : ''; ?>"/>
                    <input type="hidden" size="40"  name="tm_id2" class="input-text" value="<?php echo isset($mem_id[1]['id']) ? $mem_id[1]['id'] : ''; ?>"/>
                </dd>

                <dt >
                    <label class="text-label">Email<span class="req_field">*</span> </label>
                </dt>
                <dd >
                    <input type="text" size="40"  name="tm_email2" id="tm_email2" class="input-text" value="<?php echo isset($mch_users[0]['email2']) ? $mch_users[0]['email2'] : ''; ?>" onblur="email_valid(this.value, 'tm_email2');" />
                    <span id="tm_email2_error" style="color:red"></span>
                </dd>
                <dt >
                    <label class="text-label">Mobile <span class="req_field">*</span></label>
                </dt>
                <dd>
                    <input type="text" size="40" name="tm_phone2" id="tm_phone2" class="input-text" value="<?php echo isset($mch_users[0]['phone2']) ? $mch_users[0]['phone2'] : ''; ?>" onblur="mob_valid(this.value, 'tm_phone2');"/>
                    <span id="tm_phone2_error" style="color:red"></span>
                </dd>
                <dt >
                    <label class="text-label"><p style="font-size:14px;color:#A9CF55;">Reference 3:</p></label>
                </dt>
                <dt >
                    <label class="text-label">Name <span class="req_field">*</span></label>
                </dt>
                <dd >
                    <input type="text" size="40"  name="tm_name3" id="tm_name3"class="input-text" value="<?php echo isset($mch_users[0]['name3']) ? $mch_users[0]['name3'] : ''; ?>"/>
                    <input type="hidden" size="40"  name="tm_id3" class="input-text" value="<?php echo isset($mem_id[2]['id']) ? $mem_id[2]['id'] : ''; ?>"/>
                </dd>

                <dt >
                    <label class="text-label">Email <span class="req_field">*</span></label>
                </dt>
                <dd >
                    <input type="text" size="40"  id="tm_email3" name="tm_email3" class="input-text" value="<?php echo isset($mch_users[0]['email3']) ? $mch_users[0]['email3'] : ''; ?>" onblur="email_valid(this.value, 'tm_email3');" />
                    <span id="tm_email3_error" style="color:red"></span>
                </dd>
                <dt >
                    <label class="text-label">Mobile <span class="req_field">*</span></label>
                </dt>
                <dd >
                    <input type="text" size="40" name="tm_phone3" id="tm_phone3" class="input-text" value="<?php echo isset($mch_users[0]['phone3']) ? $mch_users[0]['phone3'] : ''; ?>" onblur="mob_valid(this.value, 'tm_phone3');"/>
                    <span id="tm_phone3_error" style="color:red"></span>
                </dd>



                <dt >
                    <label class="text-label">Upload Resume <span class="req_field">*</span></label>
                </dt>
                <dd >
                    <span id="tm_resume_file">
                        <input type="file" size="40"  name="tm_resume" id="tm_resume" class="input-text" value="" />
                        <label class="error" for="tm_resume" style="display:none">Not a valid file format.</label>
                        <?php
                        if (isset($mch_users) && !empty($mch_users)) {
                            if ($mch_users[0]['documents'] != '') {
                                ?>
                                <a href="<?php echo host_url() . 'IncubationForm/uploads/' . $mch_users[0]['documents']; ?>" target="_blank"><?php echo $mch_users[0]['documents']; ?></a>
                                <?php
                            }
                        }
                        ?>
                        <input type="hidden" name="tm_resume_old" id="tm_resume_old" value="<?php
                        if (isset($mch_users) && !empty($mch_users)) {
                            echo $mch_users[0]['documents'];
                        }
                        ?>"/>
                        <br/><span style="font-size:10px;color:#5A555A">(Supports only doc,docx,ppt,pptx,pdf files)</span>
                        <br/>



                </dd>

            </div>

        <?php } //MCH end    ?>

    </dl>

    <div class="clear"></div>
    <div class="buttons">
        <input type="hidden" name="inv_user_id" id="inv_user_id" value="<?php echo $inv_user[0]['id']; ?>">
        <input type="hidden" name="innovation_id" id="innovation_id" value="<?php echo $inv_user[0]['inv_no']; ?>">
        <input type="hidden" name="inv_status" id="inv_status" value="<?php echo $innovationDetails[0]['status']; ?>">
        <input type="submit" class="button" id="invupdate"  name="invupdate" value="Submit" />
        <a name="cancel" id="cancel" href="<?= site_url('scouting/innovation_details/' . $innovationDetails[0]['id']); ?>" class="button" >Back</a>
    </div>
</form>

<style type="text/css">
    .txtdescription {width: 65% !important;}
    textarea {resize: none;}
</style>

<script type="text/javascript">
    function subsector(val) {

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/scouting/getSubsector",
            data: {sector_id: val},
            dataType: 'json',
            success: function (msg) {
                $('#sub_sector').find('option')
                        .remove()
                        .end();
                $.each(msg, function (i, value) {
                    $('#sub_sector').append($('<option>').text(value.sector).attr('value', value.id));
                });
            },
        });
    }

    $('#inv_email').on('blur', function () {
        var mailID = $('#inv_email').val();
        var invId = $('#innovation_id').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/scouting/check_mail_exists",
            data: {mailid: mailID, invId: invId},
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
</script>