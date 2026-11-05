<script type="text/javascript">
    $(document).ready(function () {

        $('#other_cityname').hide();
        $("#pitch_add_info1").hide();
        $("#pitch_info1").show();

        $('#pitch_info1').click(function () {
            $("#pitch_add_info1").slideToggle();
        });


        $(document).on('keyup', 'textarea', function () {
            if (this.value.match(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g)) {
                this.value = this.value.replace(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g, '');
            }
        });

        /* Form validation */
        $.validator.addMethod("phonenumber", function (value, element) {
            return this.optional(element) || /^\+?(\d[\d- ]+)?(\([\d- ]+\))?[\d- ]+\d$/.test(value);
        }, "Please Enter Valid Phone Number");
        $.validator.addMethod("maxfilesize", function (value, element) {
            return this.optional(element) || (element.files && element.files[0] && element.files[0].size <=
                    10008250);
        }, $.format('The file size cannot exceed 10MB.'));
        $.validator.addMethod('numberonly', function (value, element) {
            return this.optional(element) || /^[0-9\ ]+$/.test(value);
        }, "Please enter number only");

        $.validator.addMethod("wordCount",
                function (value, element, params) {
                    var typedWords = jQuery.trim(value).match(/\S+/g).length;

                    if (typedWords <= params[0]) {
                        return true;
                    }

                }, "Only {250} words allowed.");

        $.validator.addMethod("extension", function (value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        }, "Not a valid file format.");

        $('#new_pitch').validate({
            rules: {
                org_name: {
                    required: true
                },
                app_name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                mobile: {
                    required: true,
                    phonenumber: true,
                    minlength: 10,
                    maxlength: 20
                },
                alt_ph: {
                    phonenumber: true,
                    minlength: 10,
                    maxlength: 20
                },
                city: {
                    required: true
                },
                ent_type: {
                    required: true
                },
                type_prod: {
                    required: true
                },
                sector: {
                    required: true
                },
                sub_sector: {
                    required: true
                },
                operation_stage: {
                    required: true
                },
                regions: {
                    required: true
                },
                'pitch_name[1]': {
                    required: true
                },
                'pitch_email[1]': {
                    required: true,
                    email: true
                },
                'pitch_gender[1]': {
                    required: true
                },
                'pitch_mob[1]': {
                    required: true,
                    phonenumber: true,
                    minlength: 10,
                    maxlength: 20
                },
                product_service: {
                    required: true
                },
                problem_addressed: {
                    required: true
                },
                enterprise_impact: {
                    required: true
                },
                'abt_vill[]': {
                    required: true
                },
                uploads1: {
                    required: true,
                    extension: "pdf|ppt|pptx",
                    maxfilesize: true
                },
                uploads2: {
                    extension: "pdf|ppt|pptx",
                    maxfilesize: true
                },
                uploads3: {
                    extension: "pdf|ppt|pptx",
                    maxfilesize: true
                },
            },
            messages: {
                'uploads1': {
                    extension: 'Only pdf,doc,docx,xls,xlsx,txt files are accepted'
                },
                'uploads2': {
                    extension: 'Only pdf,doc,docx,xls,xlsx,txt files are accepted'
                },
                'uploads3': {
                    extension: 'Only pdf,doc,docx,xls,xlsx,txt files are accepted'
                }
            }
        });
        /* Form validation ends */

        $('.count1').on('keyup', function (event) {
            var id = $(this).attr('id');
            var count = id.split("_");
            var words = this.value.match(/\S+/g).length;
            if (words > count[0]) {
                var len = $(this).val().length;
                $(this).val($(this).val().substring(0, len - 1));
                $("#error_" + $(this).attr("id")).css("color", "red").text(count[0] + ' Words reached');
            }

        });

        $('.count1').on('blur', function (event) {
            $("#error_" + $(this).attr("id")).css("color", "red").text('');
        });

    });

    function getCity(name) {
        if (name == 'Others') {
            $('#other_cityname').show();
        } else {
            $('#other_cityname').hide();
        }
    }

    function numbersonly(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode
        if (!(unicode == 8 || unicode == 46 || unicode == 9 || unicode == 13) && (unicode < 48 || unicode > 57)) {
            return false //disable key press
        }
    }

    function pcity(loca) {
        var loc = loca;
        var url_state;

        url_state = '<?php echo site_url("scouting/getPartnerCityajax"); ?>';
        $.ajax({
            dataType: 'json',
            url: url_state,
            data: {
                p_id: loc
            },
            success: function (city) {
                var options = '';
                for (var i = 0; i < city.length; i++) {
                    options += '<option value="' + city[i].id + '">' + city[i].city_name + '</option>';
                }
                $("select#city").html(options);
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
            var filter = /^\+?(\d[\d-. ]+)?(\([\d-. ]+\))?[\d-. ]+\d$/;
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

    function about_us_change(selval) {
        $('#emailer_div').hide();
        $('#social_media_div').hide();
        $('#website_div').hide();
        $('#other_website_div').hide();
        $('#other_aboutus_div').hide();


        if (selval == 'emailer') {
            $('#emailer_div').show();
        } else if (selval == 'social media') {
            $('#social_media_div').show();
        } else if (selval == 'website') {
            $('#website_div').show();
        } else if (selval == 'others') {
            $('#other_aboutus_div').show();
        }
    }

    function other_website_change(selval) {
        $('#other_website_div').hide();
        if (selval == 'other') {
            $('#other_website_div').show();
        }

    }

    function clearForm(form) {
        $(':input', form).each(function () {
            var type = this.type;
            var tag = this.tagName.toLowerCase(); // normalize case
            if (type == 'text' || type == 'password' || tag == 'textarea')
                this.value = "";
            else if (type == 'checkbox' || type == 'radio') {
                if ($("span").hasClass("checked") == true)
                    $("span").removeClass("checked");

            } else if (tag == 'select')
                this.selectedIndex = -1;
        });
        $("#a_fund").hide();
        $('#emailer_div').hide();
        $('#social_media_div').hide();
        $('#website_div').hide();
        $('#other_website_div').hide();
        $('#other_aboutus_div').hide();
        $("#uploads1").hide();
        $("#uploads2").hide();
        $("#uploads3").hide();
    }
</script>



<form name="new_pitch" action="" enctype="multipart/form-data" method="post" id="new_pitch" class="uniform">

    <dl class="inline">

        <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
            <dt><label for="program">Partner<span class="req_field">*</span></label></dt>
            <dd>
                <select name="branch" id="branch" class="required" onchange="pcity(this.value)">
                    <option value="">Select Partner</option>
                    <option value="1">India </option>
                </select>
            </dd>
        <?php } ?>

        <dt>
            <label>Name of the Organisation<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="org_name" name="org_name" placeholder="Name of the Organization"
                   class="required input-text " size="40" value="" />
        </dd>

        <dt>
            <label>Name of the Applicant<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="app_name" name="app_name" placeholder="Name of the Applicant"
                   class="required input-text " size="40" value="" />
        </dd>
        <dt>
            <label>Email Address<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="email" name="email" placeholder="Email id" class="required input-text " size="40"
                   value="" />
            <span id="email_error" style="color:red"></span>
        </dd>

        <dt>
            <label>Mobile Number<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="mobile" name="mobile" placeholder="Mobile No" class="required input-text " size="40"
                   value="" />
            <span id="mobile_error" style="color:red"></span>
        </dd>

        <dt>
            <label>Alternate Phone Number</label>
        </dt>
        <dd>
            <input type="text" id="alt_ph" name="alt_ph" placeholder="Phone number" class="input-text " size="40"
                   value="" />
            <span id="alt_ph_error" style="color:red"></span>
        </dd>

        <dt>
            <label>Headquarter City <span class="req_field">*</span></label>
        </dt>
        <dd>
            <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
                <select name="city" id="city">
                    <option value="">-Select-</option>

                </select>
            <?php } else { ?>
                <select name="city" id="city" onchange="getCity(this.value);">
                    <option value="">-Select-</option>
                    <?php
                    $city = array("Ahmedabad", "Bangalore", "Bhubaneswar", "Chennai", "Delhi", "Hyderabad", "Jaipur", "Kanpur", "Kochi", "Kolkata", "Mumbai", "Pune", "Others");

                    $clength = count($city);
                    for ($x = 0; $x < $clength; $x++) {
                        ?>
                        <option value="<?php echo $city[$x]; ?>"><?php echo $city[$x]; ?></option>
                    <?php } ?>

                </select>
            <?php } ?>

            <span id="city_error" style="color:red"></span>
        </dd>

        <div id="other_cityname">
            <dt>
                <label>City Name<span class="req_field">*</span></label>
            </dt>
            <dd>
                <input type="text" id="othercity" name="othercity" placeholder="City name" class="input-text" size="40"
                       value="" />
                <span id="othercity" style="color:red"></span>
            </dd>
        </div>


        <?php
        for ($i = 1; $i <= 3; $i++) {
            ?>
            <dt>
                <h3 style="color:green">Member <?php echo $i; ?></h3>
            </dt>
            <dt>
                <label>Name<?php if ($i == 1) { ?><span class="req_field">*</span><?php } ?></label>
            </dt>
            <dd>
                <input type="text" id="pitch_name<?php echo $i; ?>" name="pitch_name[<?php echo $i; ?>]" size="40"
                       placeholder="Enter the name" value="" />

            </dd>

            <dt>
                <label>Email Address <?php if ($i == 1) { ?><span class="req_field">*</span><?php } ?> </label>
            </dt>
            <dd>
                <input type="text" id="pitch_email<?php echo $i; ?>" name="pitch_email[<?php echo $i; ?>]" size="40"
                       placeholder="Enter Email Id" value="" />
                <span id="pitch_email<?php echo $i; ?>_error" style="color:red"></span>
            </dd>
            <dt>
                <label>Phone Number<?php if ($i == 1) { ?><span class="req_field">*</span><?php } ?> </label>
            </dt>
            <dd>
                <input type="text" id="pitch_mob<?php echo $i; ?>" name="pitch_mob[<?php echo $i; ?>]" size="40"
                       placeholder="Enter Mobile No" value="" />
                <span id="pitch_mob<?php echo $i; ?>_error" style="color:red"></span>
            </dd>

            <dt>
                <label>Gender<?php if ($i == 1) { ?><span class="req_field">*</span><?php } ?></label>
            </dt>
            <dd id='genderMsg'>
                <div class="chkbox chkboxiframe" style="width:60px !important;">
                    <label class="check">
                        <input type="radio" id="tm_gender" name="pitch_gender[<?php echo $i; ?>]" value="male" />
                        Male</label>
                </div>
                <div class="chkbox chkboxiframe" style="width:75px !important;">
                    <label class="check">
                        <input type="radio" id="tm_gender" name="pitch_gender[<?php echo $i; ?>]" value="female" />
                        Female</label>
                </div>
                <div class="chkbox chkboxiframe" style="width:60px !important;">
                    <label class="check">
                        <input type="radio" id="tm_gender" name="pitch_gender[<?php echo $i; ?>]" value="other" />
                        Other</label>
                </div>
                <span id="pitch_gender<?php echo $i; ?>_error" style="color:red"></span>
            </dd>
<?php } ?>


        <dt class="fund1">
            <label>Sector <span class="req_field">*</span> </label>
        </dt>
        <dd class="fund2">
            <select id="sector" name="sector" onchange="subsector(this.value)">
                <option value="">-Select-</option>
<?php
foreach ($sectors_values as $row) {
    ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['sector']; ?></option>

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
                <select id="pitchsub_sector" name="sub_sector">
                    <option value="">-Select-</option>
                </select>
            </dd>
        </div>


        <dt class="fund1">
            <label>Stage of Operation <span class="req_field">*</span> </label>
        </dt>
        <dd class="fund2">
            <select id="operation_stage" name="operation_stage">
                <option value="">-Select</option>
                <option value="Commercial Piloting / Initial Paying Customers">Commercial Piloting / Initial Paying
                    Customers</option>
                <option value="Idea">Idea</option>
                <option value="Minimum Viable Product / Prototype ready">Minimum Viable Product / Prototype ready
                </option>
                <option value="Scaling up / Rapid sales growth">Scaling up / Rapid sales growth</option>
            </select>
        </dd>

        <dt class="text-label">
            <label>Which region(s) is your incubatee currently operational in?<span class="req_field">*</span></label>
        </dt>
        <dd class="text-area">
            <textarea cols="50" rows="5" id="regions" name="regions" class="count1 txtdescription"
                      onKeyUp="limitText(this.form.regions, this.form.countdown_regions, 30);"></textarea>
            <br><span style="margin:5px 0px 0px;">(Maximum words: 30). You have
                <input readonly="readonly" type="text" name="countdown_regions" id="countdown_regions" size="3"
                       value="30" style="width:40px;" />
                words left.</span>
        </dd>


        <dt>
            <label>Is your incubatee a <span class="req_field">*</span> </label>
        </dt>
        <dd>
            <select id="ent_type" name="ent_type">
                <option value="">-Select</option>
                <option value="profit">For-profit Org</option>
                <option value="nonprofit">Non-profit Org</option>
            </select>
        </dd>


        <dt>
            <label>Are you developing a <span class="req_field">*</span> </label>
        </dt>
        <dd>
            <select id="type_prod" name="type_prod">
                <option value="">-Select</option>
                <option value="Product">Product</option>
                <option value="Service">Service</option>
            </select>
        </dd>


        <dt style="display:inline;text-align:left !important;">
            <label>Is your product invention based? (if your product is a hardware innovation)</label>
        </dt>
        <dd class="checkbox-div">
            <div class="chkbox chkboxiframe">
                <label class="check">
                    <input type="radio" name="invention_based" class="unique" value="yes" />
                    Yes</label>
            </div>
            <div class="chkbox chkboxiframe">
                <label class="check">
                    <input type="radio" name="invention_based" class="unique" value="no" />
                    No</label>
                <div class="spacer"></div>
                <div id="error_msg2" class="chkbox fleft"></div>
        </dd>


        <dt class="text-label">
            <label>Briefly explain the specific problem addressed. (max. 150 words):<span
                    class="req_field">*</span></label>
        </dt>
        <dd class="text-area">
            <textarea cols="50" rows="5" id="problem_addressed" name="problem_addressed" class="count1 txtdescription"
                      onKeyUp="limitText(this.form.problem_addressed, this.form.countdown_problem_addressed, 150);"></textarea>
            <br><span style="margin:5px 0px 0px;">(Maximum words: 150). You have
                <input readonly="readonly" type="text" name="countdown_problem_addressed"
                       id="countdown_problem_addressed" size="3" value="150" style="width:40px;" />
                words left.</span>
        </dd>
        <dt class="text-label">
            <label> Describe your idea, product or service and how it addresses the problem. (max. 250 words) <span
                    class="req_field">*</span></label>
        </dt>
        <dd class="text-area">
            <textarea cols="50" rows="5" id="product_service" name="product_service" class="count1 txtdescription"
                      onKeyUp="limitText(this.form.product_service, this.form.countdown_product_service, 250);"></textarea>
            <br> <span style="margin:5px 0px 0px;">(Maximum words: 250). You have
                <input readonly="readonly" type="text" name="countdown_product_service" id="countdown_product_service"
                       size="3" value="250" style="width:40px;" />
                words left.</span>
        </dd>
        <dt class="text-label">
            <label>Explain using bullet points, the impact your incubatee has on people at the bottom of the pyramid
                (max. 150 words).<span class="req_field">*</span></label>
        </dt>
        <dd class="text-area">
            <textarea cols="50" rows="5" id="enterprise_impact" name="enterprise_impact" class="count1 txtdescription"
                      onKeyUp="limitText(this.form.enterprise_impact, this.form.countdown_enterprise_impact, 150);"></textarea>
            <br><span style="margin:5px 0px 0px;">(Maximum words: 150). You have
                <input readonly="readonly" type="text" name="countdown_enterprise_impact"
                       id="countdown_enterprise_impact" size="3" value="150" style="width:40px;" />
                words left.</span>
        </dd>

        <dt class="text-label">
            <label>How many people do you expect to impact through your innovation (max. 50 words)</label>
        </dt>
        <dd class="text-area">
            <textarea cols="50" rows="5" id="no_of_people" name="no_of_people" class="input-text count1 txtdescription"
                      onKeyUp="limitText(this.form.no_of_people, this.form.countdown_no_of_people, 50);"></textarea>
            <br><span style="margin:5px 0px 0px;">(Maximum words: 50). You have
                <input readonly="readonly" type="text" name="countdown_no_of_people" id="countdown_no_of_people"
                       size="3" value="50" style="width:40px;" />
                words left.</span>
        </dd>

        <dt style="display:inline;text-align:right !important;">
            <label>Have you raised funding?</label>
        </dt>
        <dd class="checkbox-div">

            <div class="chkbox">
                <label class="check">
                    <input type="radio" id="fund1" name="pitch_fund_raise" value="yes" />
                    Yes</label>
            </div>
            <div class="chkbox">
                <label class="check">
                    <input type="radio" id="fund2" name="pitch_fund_raise" value="no" checked />
                    No</label>
            </div>

            <label class="error" for="pitch_fund_raise" style="display:none">This field is required.</label>
            <div class="spacer"></div>

            <div id="error_msg2" class="chkbox fleft"></div>

        </dd>

        <dt class="text-label">
            <label>Have you won a prize, recognition, award for your incubatee? If yes, please mention below.( max 100
                words)</label>
        </dt>
        <dd class="text-area">
            <textarea cols="50" rows="5" id="award_detail" name="award_detail" class="input-text "
                      onKeyUp="limitText(this.form.award_detail, this.form.countdown_award_detail, 100);"></textarea>
            <br><span style="margin:5px 0px 0px;">(Maximum words: 100). You have
                <input readonly="readonly" type="text" name="countdown_award_detail" id="countdown_award_detail"
                       size="3" value="100" style="width:40px;" />
                words left.</span>
        </dd>

        <dt>
            <label class="text-label">How did you hear about our program <span class="req_field">*</span></label>
        </dt>
        <dd class="text-area">
<?php $hearabt = explode(',', $pitch_org[0]['info_about_program']); ?>
            <input type="checkbox" class="check hear" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
            <?php echo (in_array('Villgro Mailer/Newsletter', $hearabt)) ? 'checked' : ''; ?>
                   value="Villgro Mailer/Newsletter" />Villgro Mailer/Newsletter <br />
            <input type="checkbox" onchange="valueChanged()" class="check hear" size="40" name="abt_vill[]"
                   id="partnerName" class="input-text" <?php echo (in_array('Other Mailers', $hearabt)) ? 'checked' : ''; ?>
                   value="Other Mailers" />Other Mailers/Newsletter, If checked Name of the partner:
            <input type="text" <?php if ($pitch_org[0]['partner_name'] == '') { ?> style="display:none;" <?php } ?>
                   id="partner_name" name="partner_name" <?php if (isset($pitch_org[0]['partner_name'])) { ?>
                       value="<?php echo $pitch_org[0]['partner_name']; ?>" <?php } ?> class="refer_text" /><br />

            <input type="checkbox" class="check hear" size="40" id="abt_vill" name="abt_vill[]" name="abt_vill[]"
                   class="input-text" <?php echo (in_array('Facebook', $hearabt)) ? 'checked' : ''; ?>
                   value="Facebook" />Facebook <br />
            <input type="checkbox" class="check hear" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
<?php echo (in_array('Twitter', $hearabt)) ? 'checked' : ''; ?> value="Twitter" />Twitter <br />
            <input type="checkbox" class="check hear" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                   <?php echo (in_array('LinkedIn', $hearabt)) ? 'checked' : ''; ?> value="LinkedIn" />LinkedIn <br />
            <input type="checkbox" class="check hear" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                   <?php echo (in_array('Referral', $hearabt)) ? 'checked' : ''; ?> value="Referral" />Referral <br />
            <input type="checkbox" class="check hear" size="40" id="abt_vill" name="abt_vill[]" class="input-text"
                   <?php echo (in_array('Google search', $hearabt)) ? 'checked' : ''; ?> value="Google search" />Google search
            <br />
            <input type="checkbox" onchange="valueChanged()" class="check hear" name="abt_vill[]" size="40"
                   id="incubateeName" class="input-text" <?php echo (in_array('Past Incubatee', $hearabt)) ? 'checked' : ''; ?>
                   value="Past Incubatee" />Past Incubatee, If checked Name of the incubatee:
            <input type="text" <?php if ($pitch_org[0]['inc_name'] == '') { ?> style="display:none;" <?php } ?>
                   id="inc_name" name="inc_name" <?php if (isset($pitch_org[0]['inc_name'])) { ?>
                       value="<?php echo $pitch_org[0]['inc_name']; ?>" <?php } ?> class="refer_text" /><br />

            <label class="error" for="abt_vill[]" style="display:none">This field is required.</label>
        </dd>


        <dd class="text-area" style="width:100%">
            <table width="70%" border="0" cellpadding="10px" cellspacing="10px">

                <tr style="height:30px;">
                    <td width="35%"><strong>Upload Documents (max size 10 MB)</strong><span class="req_field">*</span>
                    </td>
                    <td width="65%">
                        Please upload a presentation along the following
                        <a id="myBtn" class="guide">guidelines.</a><br>Presentation should be limited to 15 slides.<a
                            href="<?php echo base_url(); ?>source/template/Villgro-iPitch-Deck-Template.pptx">Click
                            here</a> to download a template of the presentation<br /><br />
                        <input type="file" name="uploads1" id="uploads1" />
                        <p style="color:red">(example:.pdf,.ppt,.pptx)</p>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="file" name="uploads2" id="uploads2" />
                        <p style="color:red">(example:.pdf,.ppt,.pptx)</p>

                    </td>
                </tr>
            </table>
        </dd>



    </dl>
    <div class="clear"></div>
    <div class="buttons">
        <input type="submit" class="button" name="pitchSubmit" value="Submit" />
        <button type="reset" class="button white" name="txtReset" value="Reset">Reset</button>
    </div>
</form>
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Presentation to follow the below template</h2>
        </div>
        <div class="modal-body">
            <li><strong>Title</strong>: Organisation name, your name and contact information</li>
            <li><strong>Summary</strong>: High level summary of your business</li>
            <li><strong>Problem</strong>: Describe the pain that your innovation is addressing</li>
            <li><strong>Solution</strong>: Explain how your value proposition alleviates this pain</li>
            <li><strong>Business Model</strong>: Customers, channels of distribution, gross margins etc</li>
            <li><strong>USP</strong>: Describe the technology, any patents and unique features of your offering</li>
            <li><strong>Marketing and Sales</strong>: How will you reach your customers?</li>
            <li><strong>Competition</strong>: What are the available alternatives in the market</li>
            <li><strong>Management Team</strong></li>
            <li><strong>Financial Projections & Key Metrics</strong></li>
            <li><strong>Current Status, Milestones</strong></li>
            <li><strong>Type of Impact & Beneficiaries</strong></li>
            <li><strong>Appendices (if any)</strong></li>
        </div>
    </div>

</div>


<script type="text/javascript">
    var modal = document.getElementById('myModal');

// Get the button that opens the modal
    var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
    btn.onclick = function () {
        modal.style.display = "block";
    }

// When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<style type="text/css">
    #genderMsg .error {
        white-space: nowrap;
        margin-left: 75px;
    }

    div.uploader label.error {
        font: 10px Tahoma, sans-serif;
        color: #ED7476;
        margin-left: 5px;
        position: absolute;
        top: 28px;
        z-index: 999;
        right: 0;
    }

    div.uploader {
        position: relative;
        overflow: visible;
        cursor: default;
        height: 30px;
    }

    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        /* 15% from the top and centered */
        border: 1px solid #888;
        width: 60%;
        /* Could be more or less, depending on screen size */
    }

    .modal-body {
        padding: 20px !important;
    }

    .modal-header h2 {
        color: #fff;
    }

    .modal-header {
        background-color: #78A747;
        color: #fff;
        padding: 5px 15px;
    }

    /* The Close Button */
    .close {
        color: #fff;
        float: right;
        font-size: 28px;
        font-weight: bold;
        margin-top: -8px;
    }

    .guide {
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .refer_text {
        border: 0 !important;
        outline: 0;
        background: transparent !important;
        border-bottom: 1px solid #333 !important;
    }
</style>


<script type="text/javascript">
    function valueChanged() {
        if ($('#partnerName').is(':checked')) {
            $('#partner_name').css("display", "block");
        } else {
            $('#partner_name').val('');
            $('#partner_name').css("display", "none");
        }
        if ($('#incubateeName').is(':checked')) {
            $('#inc_name').css("display", "block");
        } else {
            $('#inc_name').val('');
            $('#inc_name').css("display", "none");
        }
    }

    function subsector(val) {

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/scouting/getSubsector",
            data: {
                sector_id: val
            },
            dataType: 'json',
            success: function (msg) {
                $('#pitchsub_sector').find('option').not(':first')
                        .remove()
                        .end();
                $.each(msg, function (i, value) {
                    $('#pitchsub_sector').append($('<option>').text(value.sector).attr('value', value
                            .id));
                });
            },
        });
    }
</script>

<script type="text/javascript">
    $('#email').on('blur', function () {
        var mailID = $('#email').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/scouting/check_pitch_mail_exists",
            data: {
                mailid: mailID
            },
            dataType: 'html',
            success: function (msg) {
                if (msg > 0) {
                    $('#email_error').html('Email already exist');
                    setTimeout(function () {
                        $('#email_error').html('');
                        $('#email').val('');
                    }, 3000);
                } else {
                    $('#email_error').html('');
                }
            },
        });
    });
</script>