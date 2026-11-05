
<script type="text/javascript">
    var o_city = $('#get_othercity').val();
    if (o_city != '') {
        $('#other_cityname').show();
    } else {
        $('#other_cityname').hide();
    }

    $(document).ready(function () {
        $(document).on('keyup', 'textarea', function () {
            if (this.value.match(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g)) {
                this.value = this.value.replace(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g, '');
            }
        });
        /* Form validation */
        $.validator.addMethod("phonenumber", function (value, element) {
            return this.optional(element) || /^\+?(\d[\d- ]+)?(\([\d- ]+\))?[\d- ]+\d$/.test(value);
        }, "Please Enter Valid Phone Number");

        $.validator.addMethod("wordCount",
                function (value, element, params) {
                    var typedWords = jQuery.trim(value).split(' ').length;

                    if (typedWords <= params[0]) {
                        return true;
                    }

                }, "Only {250} words allowed.");

        $.validator.addMethod("extension", function (value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        }, "Not a valid file format.");

        $.validator.addMethod("maxfilesize", function (value, element) {
            return this.optional(element) || (element.files && element.files[0] && element.files[0].size <= 10008250);
        }, $.format('The file size cannot exceed 10MB.'));
        $.validator.addMethod('numberonly', function (value, element) {
            return this.optional(element) || /^[0-9\ ]+$/.test(value);
        }, "Please enter number only");


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
                'pitch_name[1]': {
                    required: true
                },
                'pitch_org[1]': {
                    required: true
                },
                'pitch_email[1]': {
                    required: true,
                    email: true
                },
                'pitch_mob[1]': {
                    required: true,
                    phonenumber: true,
                    minlength: 10,
                    maxlength: 20
                },
                sector: {
                    required: true,
                },
                uploads1: {
                    extension: "pdf|ppt|pptx",
                    maxfilesize: true
                },
                uploads2: {
                    extension: "pdf|ppt|pptx",
                    maxfilesize: true
                },
            },
            messages: {
                'uploads1': {extension: 'Only pdf,ppt,pptx files are accepted'},
                'uploads2': {extension: 'Only pdf,ppt,pptx files are accepted'},
            }
        });
        /* Form validation ends */

        $('.count1').on('keyup', function (event) {

            var id = $(this).attr('id');
            var count = id.split("_");
            var words = this.value.match(/\S+/g).length;
            if (words > count[0])
            {
                var len = $(this).val().length;
                $(this).val($(this).val().substring(0, len - 1));
                $("#error_" + $(this).attr("id")).css("color", "red").text(count[0] + ' Words reached');
            }

        });

        $('.count1').on('blur', function (event) {
            $("#error_" + $(this).attr("id")).css("color", "red").text('');
        });

    });

    function numbersonly(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode
        if (!(unicode == 8 || unicode == 46 || unicode == 9 || unicode == 13) && (unicode < 48 || unicode > 57))
        {
            return false //disable key press
        }
    }


    function show_div(element) {
        var chboxs = document.getElementsByName("sector[]");
        var vis = "none";
        for (var i = 0; i < chboxs.length; i++) {
            if (chboxs[i].checked && chboxs[i].value == "others") {
                vis = "block";
                break;
            }
        }
        document.getElementById(element).style.display = vis;
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
            var filter = /^\+?(\d[\d-. ]+)?(\([\d-. ]+\))?[\d-. ]+\d$/;
            if (!filter.test(value))
            {
                $("#" + id).val('');
                $("#" + id + "_error").text("'" + value + "' is not a valid phone number");
                setTimeout(function () {
                    $("#" + id).focus();
                }, 10);
            } else if (value.length > 15 || value.length < 10)
            {
                $("#" + id).val('');
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


    function about_us_change(selval)
    {
        $('#emailer_div').hide();
        $('#social_media_div').hide();
        $('#website_div').hide();
        $('#other_website_div').hide();
        $('#other_aboutus_div').hide();


        if (selval == 'emailer')
        {
            $('#emailer_div').show();
        } else if (selval == 'social media')
        {
            $('#social_media_div').show();
        } else if (selval == 'website')
        {
            $('#website_div').show();
        } else if (selval == 'others')
        {
            $('#other_aboutus_div').show();
        }
    }
    function other_website_change(selval)
    {
        $('#other_website_div').hide();
        if (selval == 'other')
        {
            $('#other_website_div').show();
        }

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

</script>
<br />
<h2 style="font-family:Gill !important;"><?= $cpagetitle ?> </h2>
<div class="clear"></div>


<?php
$attributes = array('id' => 'new_pitch');
$i_othercity = isset($pitch_user[0]['other_city']) ? $pitch_user[0]['other_city'] : '';
echo form_open_multipart("scouting/pitch_app_edit_save/" . $this->uri->segment('3') . '/' . $this->uri->segment('4'), $attributes);
?>
<dl class="inline">

    <dl>
        <input type="hidden" id='get_othercity' value="<?php echo $i_othercity; ?>">
        <dt>
            <label>Name of the Organisation<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="org_name" name="org_name" placeholder="Name of the Organization" class="required input-text " size="40" value="<?= $pitch_user[0]['org_name'] ?>"/>
        </dd>

        <dt>
            <label>Name of the Applicant<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="app_name" name="app_name" placeholder="Name of the Applicant" class="required input-text " size="40" value="<?= $pitch_user[0]['app_name'] ?>"/>
        </dd>
        <dt>
            <label>Email Address<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="email" name="email" placeholder="Email id" class="required input-text " size="40" value="<?= $pitch_user[0]['email'] ?>" />
            <span id="email_error" style="color:red"></span>
        </dd>

        <dt>
            <label>Mobile Number<span class="req_field">*</span></label>
        </dt>
        <dd>
            <input type="text" id="mobile" name="mobile" placeholder="Mobile No" class="required input-text "  size="40" value="<?= $pitch_user[0]['mobileno'] ?>"/>
            <span id="mobile_error" style="color:red"></span>
        </dd>

        <dt>
            <label>Alternate Phone Number</label>
        </dt>
        <dd>
            <input type="text" id="alt_ph" name="alt_ph" placeholder="Phone number" class="input-text " size="40" value="<?= ($pitch_user[0]['altmobileno'] != 0 && $pitch_user[0]['altmobileno'] != '') ? $pitch_user[0]['altmobileno'] : '' ?>" />
            <span id="alt_ph_error" style="color:red"></span>
        </dd>

        <dt>
            <label>Headquarter City <span class="req_field">*</span></label>
        </dt>
        <dd>
<?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
                <select name="city" id="city" onchange="getCity(this.value);">
    <?php
    $city = $this->Minnovation->getPartnerCity($innovationDetails[0]['partner_id']);
    foreach ($city as $row) {
        ?>
                        <option value="<?php echo $row['id']; ?>"<?php if (isset($pitch_user[0]['city']) && $pitch_user[0]['city'] == $row['id']) {
            echo "selected=selected";
        } ?>><?php echo $row['city_name']; ?></option>
                    <?php } ?>

                </select>
                <?php } else { ?>
                <select name="city" id="city">
                    <?php
                    $cities = array("Ahmedabad", "Bangalore", "Bhubaneswar", "Chennai", "Delhi", "Hyderabad", "Jaipur", "Kanpur", "Kochi", "Kolkata", "Mumbai", "Pune", "Others");

                    $clength = count($cities);
                    for ($x = 0; $x < $clength; $x++) {
                        ?>

                        <option value="<?php echo $cities[$x]; ?>"<?php if (isset($pitch_user[0]['city']) && $pitch_user[0]['city'] == $cities[$x]) {
                    echo "selected=selected";
                } ?>><?php echo $cities[$x]; ?></option>

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
                <input type="text" id="othercity" name="othercity" placeholder="City name" class="input-text" size="40" value="<?= $pitch_user[0]['other_city'] ?>"/>
                <span id="othercity" style="color:red"></span>
            </dd>
        </div>

<?php
$i = 1;
foreach ($pitch_member as $mem) {
    ?>
            <dt>
                <h3 style="color:green">Member <?php echo $i; ?></h3>
            </dt>
            <dt>
                <label>Name</label>
            </dt>
            <dd>
                <input type="text" id="pitch_name<?php echo $i; ?>" name="pitch_name[<?php echo $i; ?>]" size="40" placeholder="Enter the name" value="<?= $mem['name']; ?>"/>

            </dd>


            <dt>
                <label>Email Address </label>
            </dt>
            <dd>
                <input type="text" id="pitch_email<?php echo $i; ?>" name="pitch_email[<?php echo $i; ?>]" size="40" placeholder="Enter Email Id" value="<?= $mem['email']; ?>"  />
                <span id="pitch_email<?php echo $i; ?>_error" style="color:red"></span>
            </dd>
            <dt>
                <label>Phone Number </label>
            </dt>
            <dd>
                <input type="text" id="pitch_mob<?php echo $i; ?>" name="pitch_mob[<?php echo $i; ?>]"  size="40" placeholder="Enter Mobile No"  value="<?= $mem['phone']; ?>" />
                <span id="pitch_mob<?php echo $i; ?>_error" style="color:red"></span>
            </dd>

            <dt>
                <label>Gender<?php if ($i == 1) { ?><span class="req_field">*</span><?php } ?></label>
            </dt>
            <dd>
                <div class="chkbox chkboxiframe" style="width:60px !important;">
                    <label class="check">
                        <input type="radio" id="tm_gender" name="pitch_gender[<?php echo $i; ?>]" value="male" <?php if ($mem['gender'] == 'male') {
            echo 'checked="checked"';
        } ?> />
                        Male</label>
                </div>
                <div class="chkbox chkboxiframe" style="width:75px !important;">
                    <label class="check">
                        <input type="radio" id="tm_gender" name="pitch_gender[<?php echo $i; ?>]" value="female" <?php if ($mem['gender'] == 'female') {
            echo 'checked="checked"';
        } ?> />
                        Female</label>
                </div>
                <div class="chkbox chkboxiframe" style="width:60px !important;">
                    <label class="check">
                        <input type="radio" id="tm_gender" name="pitch_gender[<?php echo $i; ?>]" value="other" <?php if ($mem['gender'] == 'other') {
            echo 'checked="checked"';
        } ?> />
                        Other</label>
                </div>
                <span id="pitch_gender<?php echo $i; ?>_error" style="color:red"></span>
            </dd>

            <input type="hidden" name="pitch_mem_id[<?php echo $i; ?>]" id="pitch_mem_id<?php echo $i; ?>" value="<?php echo $mem['id']; ?>"/>

    <?php
    $i = $i + 1;
}
if ($i < 4) {
    for ($j = $i; $j <= 3; $j++) {
        ?>
                <dt>
                    <h3 style="color:green">Member <?php echo $j; ?></h3>
                </dt>
                <dt>
                    <label>Name</label>
                </dt>
                <dd>
                    <input type="text" id="pitch_name<?php echo $j; ?>" name="pitch_name[<?php echo $j; ?>]" size="40" placeholder="Enter the Name" value=""/>

                </dd>


                <dt>
                    <label>Email Address </label>
                </dt>
                <dd>
                    <input type="text" id="pitch_email<?php echo $i; ?>" name="pitch_email[<?php echo $i; ?>]" size="40" placeholder="Enter Email Id" value=""  />
                    <span id="pitch_email<?php echo $i; ?>_error" style="color:red"></span>
                </dd>
                <dt>
                    <label>Phone Number </label>
                </dt>
                <dd>
                    <input type="text" id="pitch_mob<?php echo $i; ?>" name="pitch_mob[<?php echo $i; ?>]"  size="40" placeholder="Enter Mobile No"  value="" />
                    <span id="pitch_mob<?php echo $i; ?>_error" style="color:red"></span>
                </dd>
                <input type="hidden" name="pitch_mem_id[<?php echo $j; ?>]" id="pitch_mem_id<?php echo $j; ?>" value=""/>

                <?php
            }
        }
        ?>

<?php
$get_sectorName = unserialize($pitch_org[0]['sector']);
$sectorName = $get_sectorName[0];
?>

        <dt class="fund1">
            <label>Sector <span class="req_field">*</span> </label>
        </dt>
        <dd class="fund2">
            <select id="sector" name="sector" onchange="subsector(this.value)">
                <option value="">-Select-</option>
                <?php
                foreach ($sectors_values as $row) {
                    ?>
                    <option value="<?php echo $row['id']; ?>" <?php if ($sectorName == $row['sector']) {
                    echo 'selected';
                } ?> ><?php echo $row['sector']; ?></option>

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
<?php if ($pitch_org[0]['sub_sector'] != 0 || $pitch_org[0]['sub_sector'] != '') { ?>
                        <option value="<?php echo $subSectorName[0]['id']; ?>" selected><?php echo $subSectorName[0]['sector']; ?></option>
<?php } ?>
                </select>
            </dd>
        </div>


        <dt class="fund1">
            <label>Stage of Operation <span class="req_field">*</span> </label>
        </dt>
        <dd class="fund2">
            <select id="operation_stage" name="operation_stage">
                <option value="">-Select</option>
                <option value="Commercial Piloting / Initial Paying Customers" <?php if ($pitch_org[0]['operation_stage'] == 'Commercial Piloting / Initial Paying Customers') {
    echo 'selected';
} ?> >Commercial Piloting / Initial Paying Customers</option>
                <option value="Idea" <?php if ($pitch_org[0]['operation_stage'] == 'Idea') {
    echo 'selected';
} ?> >Idea</option>
                <option value="Minimum Viable Product / Prototype ready" <?php if ($pitch_org[0]['operation_stage'] == 'Minimum Viable Product / Prototype ready') {
    echo 'selected';
} ?> >Minimum Viable Product / Prototype ready</option>
                <option value="Scaling up / Rapid sales growth" <?php if ($pitch_org[0]['operation_stage'] == 'Scaling up / Rapid sales growth') {
    echo 'selected';
} ?> >Scaling up / Rapid sales growth</option>
            </select>
        </dd>


        <dt >
            <label>Is your incubatee a <span class="req_field">*</span> </label>
        </dt>
        <dd>
            <select id="ent_type" name="ent_type">
                <option value="">-Select</option>
                <option value="profit" <?= $pitch_info[0]['ent_type'] == "profit" ? "selected='selected'" : "" ?> >For-profit Org</option>
                <option value="nonprofit" <?= $pitch_info[0]['ent_type'] == "nonprofit" ? "selected='selected'" : "" ?> >Non-profit Org</option>
            </select>
        </dd>


        <dt >
            <label>Are you developing a <span class="req_field">*</span> </label>
        </dt>
        <dd>
            <select id="type_prod" name="type_prod">
                <option value="">-Select</option>
                <option value="Product" <?= $pitch_info[0]['type_prod'] == "Product" ? "selected='selected'" : "" ?> >Product</option>
                <option value="Service" <?= $pitch_info[0]['type_prod'] == "Service" ? "selected='selected'" : "" ?> >Service</option>
            </select>
        </dd>


        <dt style="display:inline;text-align:left !important;">
            <label>Is your product invention based? (if your product is a hardware innovation)</label>
        </dt>
        <dd class="checkbox-div">
            <div class="chkbox chkboxiframe">
                <label class="check">
                    <input type="radio" name="invention_based" class="unique" <?= $pitch_info[0]['invention_based'] == "yes" ? "checked='checked'" : ""; ?> value="yes" />
                    Yes</label>
            </div>
            <div class="chkbox chkboxiframe">
                <label class="check">
                    <input type="radio" name="invention_based" class="unique" <?= $pitch_info[0]['invention_based'] == "no" ? "checked='checked'" : ""; ?> value="no"  />
                    No</label>
                <div class="spacer"></div>
                <div id="error_msg2" class="chkbox fleft"></div>
        </dd>

        <dt class="text-label" >
            <label>Briefly explain the specific problem addressed. (max. 150 words):</label>
        </dt>
        <dd class="text-area">
            <textarea  cols="50" rows="5" id="problem_addressed" name="problem_addresed" class="count1" onKeyUp="limitText(this.form.problem_addressed, this.form.countdown_problem_addressed, 150);"><?php echo @$pitch_org[0]['addr_problem'] ?></textarea>
            <br><span style="margin:5px 0px 0px;">(Maximum words: 150). You have
                <input readonly="readonly" type="text" name="countdown_problem_addressed" id="countdown_problem_addressed" size="3" value="150" style="width:40px;" />
                words left.</span>
        </dd>
        <dt class="text-label" >
            <label>Describe your idea, product or service and how it addresses the problem. (max. 250 words)</label>
        </dt>
        <dd class="text-area">
            <textarea  cols="50" rows="5"  id="product_service" name ="product_service" class="count1" onKeyUp="limitText(this.form.product_service, this.form.countdown_product_service, 250);"><?php echo @$pitch_org[0]['quest_1'] ?></textarea>
        </dd>
        <dt class="text-label">
            <label>Explain using bullet points, the impact your incubatee has on people at the bottom of the pyramid (max. 150 words).</label>
        </dt>
        <dd class="text-area">
            <textarea  cols="50" rows="5" id="enterprise_impact" name ="enterprise_impact" class="count1" onKeyUp="limitText(this.form.enterprise_impact, this.form.countdown_enterprise_impact, 150);"><?php echo @$pitch_org[0]['ent_impact'] ?></textarea>
            <br><span style="margin:5px 0px 0px;">(Maximum words: 150). You have
                <input readonly="readonly" type="text" name="countdown_enterprise_impact" id="countdown_enterprise_impact" size="3" value="150" style="width:40px;" />
                words left.</span>
        </dd>

        <dt class="text-label">
            <label>How many people do you expect to impact through your innovation (max. 50 words)</label>
        </dt>
        <dd class="text-area">
            <textarea  cols="50" rows="5" id="no_of_people" name="no_of_people" class="input-text count1" onKeyUp="limitText(this.form.profile, this.form.countdown_profile, 50);"><?php echo @$pitch_org[0]['people_impact']; ?></textarea>
            <br><span style="margin:5px 0px 0px;">(Maximum words: 50). You have
                <input readonly="readonly" type="text" name="countdown_profile" id="countdown_profile" size="3" value="50" style="width:40px;" />
                words left.</span>
        </dd>

        <dt style="display:inline;text-align:left !important;width:20%">
            <label>Have you raised funding?</label>
        </dt>
        <dd class="checkbox-div">

            <div class="chkbox">
                <label class="check">
                    <input type="radio" id="fund1" name="fund" value="yes" <?php if ($pitch_org[0]['fund'] == 'yes') {
    echo 'checked="checked"';
} ?> />
                    Yes</label>
            </div>
            <div class="chkbox">
                <label class="check">
                    <input type="radio" id="fund2" name="fund" value="no" <?php if ($pitch_org[0]['fund'] == 'no') {
    echo 'checked="checked"';
} ?> />
                    No</label>
            </div>
            <label class="error" for="fund" style="display:none"></label>
            <div class="spacer"></div>

            <div id="error_msg2" class="chkbox fleft"></div>

        </dd>

        <dt class="text-label">
            <label>Have you won a prize, recognition, award for your incubatee? If yes, please mention below. (Maximum words: 100)</label>
        </dt>
        <dd class="text-area">
            <textarea  cols="50" rows="5" id="award_detail" name="award_detail" class="input-text count1" onKeyUp="limitText(this.form.award_detail, this.form.countdown_award_detail, 100);"><?php if (isset($pitch_org) && !empty($pitch_org) && !empty($pitch_org[0]['awards'])) echo $pitch_org[0]['awards']; ?></textarea>
            <br><span style="margin:5px 0px 0px;">(Maximum words: 100). You have
                <input readonly="readonly" type="text" name="countdown_award_detail" id="countdown_award_detail" size="3" value="100" style="width:40px;" />
                words left.</span>
        </dd>

        <dt>
            <label class="text-label">How did you hear about our program <span class="req_field">*</span></label>
        </dt>
        <dd class="text-area">
<?php $hearabt = explode(',', $pitch_org[0]['info_about_program']);
?>
            <input type="checkbox" class="check hear" size="40" id="abt_vill" name="abt_vill[]" class="input-text" <?php echo (in_array('Villgro Mailer/Newsletter', $hearabt)) ? 'checked' : ''; ?> value="Villgro Mailer/Newsletter"/>Villgro Mailer/Newsletter <br/>
            <input type="checkbox" onchange="valueChanged()" class="check hear" size="40" name="abt_vill[]" id="partnerName" class="input-text" <?php echo (in_array('Other Mailers', $hearabt)) ? 'checked' : ''; ?> value="Other Mailers"/>Other Mailers/Newsletter, If checked Name of the partner:
            <input type="text" <?php if ($pitch_org[0]['partner_name'] == '') { ?> style="display:none;" <?php } ?> id="partner_name" name="partner_name" <?php if (isset($pitch_org[0]['partner_name'])) { ?> value="<?php echo $pitch_org[0]['partner_name']; ?>" <?php } ?> class="refer_text" /><br/>

            <input type="checkbox" class="check hear" size="40" id="abt_vill" name="abt_vill[]" name="abt_vill[]" class="input-text" <?php echo (in_array('Facebook', $hearabt)) ? 'checked' : ''; ?> value="Facebook"/>Facebook <br/>
            <input type="checkbox" class="check hear" size="40" id="abt_vill" name="abt_vill[]" class="input-text" <?php echo (in_array('Twitter', $hearabt)) ? 'checked' : ''; ?> value="Twitter"/>Twitter <br/>
            <input type="checkbox" class="check hear" size="40" id="abt_vill" name="abt_vill[]" class="input-text" <?php echo (in_array('LinkedIn', $hearabt)) ? 'checked' : ''; ?> value="LinkedIn"/>LinkedIn <br/>
            <input type="checkbox" class="check hear" size="40" id="abt_vill" name="abt_vill[]" class="input-text" <?php echo (in_array('Referral', $hearabt)) ? 'checked' : ''; ?> value="Referral"/>Referral <br/>
            <input type="checkbox" class="check hear" size="40" id="abt_vill" name="abt_vill[]" class="input-text" <?php echo (in_array('Google search', $hearabt)) ? 'checked' : ''; ?> value="Google search"/>Google search <br/>
            <input type="checkbox" onchange="valueChanged()" class="check hear" name="abt_vill[]" size="40" id="incubateeName" class="input-text" <?php echo (in_array('Past Incubatee', $hearabt)) ? 'checked' : ''; ?> value="Past Incubatee"/>Past Incubatee, If checked Name of the incubatee:
            <input type="text" <?php if ($pitch_org[0]['inc_name'] == '') { ?> style="display:none;" <?php } ?> id="inc_name" name="inc_name"  <?php if (isset($pitch_org[0]['inc_name'])) { ?> value="<?php echo $pitch_org[0]['inc_name']; ?>" <?php } ?> class="refer_text" /><br/>

            <label class="error" for="abt_vill[]" style="display:none">This field is required.</label>
        </dd>


        <dd class="text-area" style="width:100%">
            <table width="70%" border="0" cellpadding="10px" cellspacing="10px" >

                <tr style="height:30px;"><td style="padding-right: 30px;"><strong>Upload Documents (max size 10 MB)</strong><span class="req_field">*</span></td>
                    <td>
                        <input type="file" name="uploads1" id="uploads1"/>
                        <p style="color:red">(example:.pdf,.ppt,.pptx)</p>
                    <td>
<?php if (isset($pitch_doc) && !empty($pitch_doc) && !empty($pitch_doc[0]['doc1'])) { ?>
                            <a href="<?php echo host_url() . 'pitchform/document/' . $pitch_doc[0]['doc1']; ?>" target="_blank"><?php echo $pitch_doc[0]['doc1']; ?></a>
                            <input type="hidden" name="uploads1_hidden" value="<?php echo $pitch_doc[0]['doc1']; ?>">
<?php } ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="file" name="uploads2" id="uploads2" /><p style="color:red">(example:.pdf,.ppt,.pptx)</p>
                    <td>
    <?php if (isset($pitch_doc) && !empty($pitch_doc) && !empty($pitch_doc[0]['doc2'])) { ?>
                            <a href="<?php echo host_url() . 'pitchform/document/' . $pitch_doc[0]['doc2']; ?>" target="_blank"><?php echo $pitch_doc[0]['doc2']; ?></a>
                            <input type="hidden" name="uploads2_hidden" value="<?php echo $pitch_doc[0]['doc2']; ?>">
<?php } ?>
                    </td>

                </tr>
            </table>

        </dd>

        <input type="hidden" name="innovation_id" id="innovation_id" value="<?php echo $innovationDetails[0]['innovation_id']; ?>">
        <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $innovationDetails[0]['partner_id']; ?>">
    </dl>
    <div class="clear"></div>
    <div class="buttons">
        <input type="submit" value="Save" name="pitchSubmit" id="pitchSubmit" class="button" />
        <a href="<?php echo base_url() . "index.php/scouting/innovation_details/" . $inv_id; ?>" class="button" style="padding: 4px 6px 5px;">Back</a>
    </div>

<?php echo form_close(); ?>

    <style type="text/css">
        form input[type="radio"] {
            margin-top: 3px;
        }
        .refer_text{
            border: 0 !important;
            outline: 0;
            background: transparent !important;
            border-bottom: 1px solid #333 !important;
        }
        textarea {resize: none;width: 65%;}
        .check {
            margin: 5px !important;
        }
    </style>

    <script type="text/javascript">
        function getCity(name) {
            if (name == 'Others') {
                $('#other_cityname').show();
            } else {
                $('#other_cityname').hide();
            }
        }

        function subsector(val) {

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/scouting/getSubsector",
                data: {sector_id: val},
                dataType: 'json',
                success: function (msg) {
                    console.log(msg);
                    $('#sub_sector').find('option')
                            .remove()
                            .end();
                    $.each(msg, function (i, value) {
                        $('#sub_sector').append($('<option>').text(value.sector).attr('value', value.id));
                    });
                },
            });
        }

        function valueChanged()
        {
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
    </script>

    <script type="text/javascript">
        $('#email').on('blur', function () {
            var mailID = $('#email').val();
            var invId = $('#innovation_id').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/scouting/check_pitch_mail_exists",
                data: {mailid: mailID, invId: invId},
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