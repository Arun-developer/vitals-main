<script type="text/javascript">
    $(document).ready(function () {

        $("#seed_add_info1").hide();
        $("#seed_info1").show();

        $('#seed_info1').click(function () {
            $("#seed_add_info1").slideToggle();
        });

        /* City Load Process */
        $("#state_seed").change(function () {
            var s_name = $("#state_seed").val();
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>index.php/scouting/get_city",
                data: {
                    sname: s_name
                },
                success: function (selectValues) {

                    var selectValues = $.parseJSON(selectValues);

                    $('#city_seed').empty();
                    $("#city_seed").prepend(
                            "<option value='' selected='selected'>--Select city--</option>");
                    $.each(selectValues, function (key, value) {
                        $('#city_seed')
                                .append($("<option></option>")
                                        .attr("value", key)
                                        .text(value));
                    });
                    $('#city_seed')
                            .append($("<option></option>")
                                    .attr("value", 'others')
                                    .text('others'));
                }
            });
        });
        /* city load process ends */

        /* Form validation */
        $.validator.addMethod("phonenumber", function (value, element) {
            return this.optional(element) || /^[0-9\s+-]+$/.test(value);
        }, "Please Enter Valid Phone Number");

        $('#new_seed').validate({
            rules: {
                program: {
                    required: true
                },
                email_id: {
                    required: true,
                    email: true
                },
                citizen_ship: {
                    required: true
                },
                ph_num: {
                    required: true,
                    phonenumber: true,
                    minlength: 10,
                    maxlength: 15
                },
                full_time: {
                    required: true
                },
                profit_entity: {
                    required: true
                }

            }
        });
        /* Form validation ends */

        $('.count').on('keyup', function (event) {
            var len = $(this).val().length;

            if (len >= 1500) {
                $(this).val($(this).val().substring(0, len - 1));
                $("#error_" + $(this).attr("id")).css("color", "red").text('1500 Characters reached');
            }
        });

        $('.count').on('blur', function (event) {
            $("#error_" + $(this).attr("id")).css("color", "red").text('');
        });

    });



    function show_div(element) {
        var chboxs = document.getElementsByName("operate[]");
        var vis = "none";
        for (var i = 0; i < chboxs.length; i++) {
            if (chboxs[i].checked && chboxs[i].value == "other") {
                vis = "block";
                break;
            }
        }
        document.getElementById(element).style.display = vis;
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

    function res_valid(value, id) {
        var filename = $("#" + id).val();

        if (filename != '') {
            var extension = filename.replace(/^.*\./, '');
            console.log(extension);
            if (extension == filename) {
                extension = '';
            } else {

                extension = extension.toLowerCase();
            }
            console.log(extension != 'docx' || extension != 'doc' || extension != 'pdf');
            if (!(/\.(doc|docx|pdf)$/i).test(filename)) {

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

            if (!(/\.(doc|docx|pdf|ppt|pptx|xls|xlsx)$/i).test(filename)) {

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

<form name="new_seed" action="" enctype="multipart/form-data" method="post" id="new_seed" class="uniform">

    <dl class="inline">
        <dl>
            <dt>
                <label>Name<span class="req_field">*</span></label>
            </dt>
            <dd>
                <input type="text" id="first_name" name="first_name" placeholder="" class="required input-text "
                       size="40" value="" />
            </dd>

            <dt>
                <label>Contact Email Address(es)<span class="req_field">*</span></label>
            </dt>
            <dd>
                <input type="text" id="email_id" name="email_id" placeholder="" class="required input-text " size="40"
                       value="" />
            </dd>

            <dt>
                <label>Contact Phone Number(s)<span class="req_field">*</span></label>
            </dt>
            <dd>
                <input type="text" id="ph_num" name="ph_num" placeholder="" class="required input-text " size="40"
                       value="" />
            </dd>

            <dt>
                <label>How did you hear about the SEED program?<span class="req_field">*</span></label>
            </dt>
            <dd>
                <input type="text" id="hear_abt" name="hear_abt" placeholder="" class="required input-text " size="40"
                       value="" />
            </dd>

            <dt>
                <label>Country of Citizen Ship<span class="req_field">*</span></label>
            </dt>
            <dd>
                <?php
                $coun = $this->Minnovation->getCountry();
                ?>
                <select id="citizen_ship" name="citizen_ship">
                    <option value="">-Select-</option>
                    <?php foreach ($coun as $row) { ?>
                        <option value="<?= $row['country_name'] ?>"><?= $row['country_name'] ?></option>
                    <?php } ?>
                </select>
            </dd>

            <dt>
                <label> Are you committed full-time to your incubatee?<span class="req_field">*</span></label>
            </dt>
            <dd>
                <input type="radio" name="full_time" id="full_time1" value="yes" /> Yes.I am full time committed. <br />
                <input type="radio" name="full_time" id="full_time0" value='no' /> No.I have another full time
                engagement <br />
                <label for="full_time" class="error" style="display:none;">Please choose one.</label>
            </dd>
            <dt>
                <label>Name of the Venture <span class="req_field">*</span> </label>
            </dt>
            <dd>
                <input type="text" id="venture" name="venture" placeholder="" class="required input-text " size="40"
                       value="" />

            </dd>
            <dt>
                <label>Is your organization an incorporated for profit-entity <span class="req_field">*</span> </label>
            </dt>
            <dd>
                <input type="radio" name="profit_entity" value="Yes" /> Yes. <br />
                <input type="radio" name="profit_entity" value='Yes,but we are not incorporated' /> Yes, but we are not
                incorporated <br />
                <input type="radio" name="profit_entity" value='No,we are a hybrid' /> No, we are a hybrid<br />
                <input type="radio" name="profit_entity" value='No,we are neither a for-profit nor a hybrid' /> No, we
                are neither a for-profit nor a hybrid<br />
                <label for="profit_entity" class="error" style="display:none;">Please choose one.</label>
            </dd>




            <dt style="float:right;">
                <h1><a href="#bottom" id="seed_info1" style="color:#719e41;">** Add Additional Information</a></h1>
            </dt>
            <div id="seed_add_info1" style="display:none;">
                <dt>
                    <label>website</label>
                </dt>
                <dd>
                    <input type="text" id="website" size="40" name="website" placeholder="" value="" />

                </dd>

                <dt>
                    <label>Postal Address </label>
                </dt>
                <dd>
                    <textarea cols="40" rows="5" class="input-text " name="address" id="address"></textarea>
                </dd>
                <dt>
                    <label>State </label>
                </dt>
                <dd>
                    <select id="state_seed" name="state_seed">
                        <option value="">--select a state--</option>
<?php
$state = $this->Minnovation->getState();
foreach ($state as $row) {
    ?>
                            <option value="<?= $row['id'] ?>"><?= $row['state_name'] ?></option>
                        <?php } ?>
                    </select>
                </dd>
                <dt>
                    <label>City</label>
                </dt>
                <dd>
                    <select id="city_seed" name="city_seed">
                        <option value="">--select a city--</option>

                    </select>
                </dd>
                <div id="city_other" style="display:none">
                    <dt>
                        <label>Others specify here
                        </label>
                    </dt>
                    <dd>
                        <input id="city_oth" name="city_oth" type="text" value="" />
                    </dd>
                </div>
                <dt>
                    <label>Region(s) of operation
                    </label>
                </dt>
                <dd>
                    <input type="text" id="region_oper" size="40" name="region_oper" placeholder="" value=""
                           class="input-text " />

                </dd>
                <dt>
                    <label>Number of month in opetation
                    </label>
                </dt>
                <dd>
                    <input type="text" id="month_oper" size="40" name="month_oper" placeholder="" value=""
                           class="input-text " />
                </dd>
                <dt>
                    <label>What sector do you operate in?
                    </label>
                </dt>
                <dd>
                    <input type="checkbox" id="operate1" size="40" name="operate[]" placeholder=""
                           value="energy" />Energy<br />
                    <input type="checkbox" id="operate2" size="40" name="operate[]" placeholder=""
                           value="agriculture" />Agriculture <br />
                    <input type="checkbox" id="operate3" size="40" name="operate[]" placeholder=""
                           value="health" />Health<br />
                    <input type="checkbox" id="operate4" size="40" name="operate[]" placeholder=""
                           value="education" />Education<br />
                    <input type="checkbox" id="operate5" size="40" name="operate[]" placeholder=""
                           value="livelihoods" />Livelihoods<br />
                    <input type="checkbox" id="operate8" size="40" name="operate[]" placeholder="" value="other"
                           onchange="show_div('other_operate')" />Other<br />

                    <div id="other_operate" style="display:none">
                        <input type="text" id="operate_other" name="operate_other" class="input-text" value=""> <br />
                    </div>
                </dd>
                <?php
                for ($i = 1; $i <= 5; $i++) {
                    ?>
                    <dt>
                        <h3 style="color:green">Member <?php echo $i; ?></h3>
                    </dt>
                    <dt>
                        <label>Name</label>
                    </dt>
                    <dd>
                        <input type="text" id="seed_name<?php echo $i; ?>" name="seed_name[<?php echo $i; ?>]" size="40"
                               placeholder="" value="" />

                    </dd>

                    <dt>
                        <label>Email Address </label>
                    </dt>
                    <dd>
                        <input type="text" id="seed_email<?php echo $i; ?>" name="seed_email[<?php echo $i; ?>]" size="40"
                               placeholder="" value="" onblur="email_valid(this.value, 'seed_email<?php echo $i; ?>');" />
                        <span id="seed_email<?php echo $i; ?>_error" style="color:red"></span>
                    </dd>
                    <dt>
                        <label>Phone Number </label>
                    </dt>
                    <dd>

                        <input type="text" id="seed_mob<?php echo $i; ?>" name="seed_mob[<?php echo $i; ?>]" size="40"
                               placeholder="" value="" onblur="mob_valid(this.value, 'seed_mob<?php echo $i; ?>');" />
                        <span id="seed_mob<?php echo $i; ?>_error" style="color:red"></span>
                    </dd>
                    <dt>
                        <label>Upload Resume</label>
                    </dt>
                    <dd>
                        <span id="seed_res<?php echo $i; ?>_file">
                            <input type="file" id="seed_res<?php echo $i; ?>" name="seed_res[<?php echo $i; ?>]" size="40"
                                   placeholder="" onblur="res_valid(this.value, 'seed_res<?php echo $i; ?>');" />
                        </span>
                        <span id="seed_res<?php echo $i; ?>_error" style="color:red"></span>
                        <br /><span style="font-size:10px;color:red">Supports only docx,doc and pdf files</span>
                    </dd>
                    <dt>
                        <label></label>
                    </dt>
                    <dd>

                        <input type="checkbox" id="ftm<?php echo $i; ?>" name="ftm[<?php echo $i; ?>]" size="40"
                               placeholder="" value="" />Member of Founding Team

                    </dd>
                <?php } ?>


                <dt class="text-label">
                    <label>What insipred you to start this social incubatee?(maximum 1500 characters):
                    </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="inspiration" name="inspiration" maxlength="1500"
                              class="count"></textarea>
                    <span id="error_inspiration"></span>
                </dd>
                <dt class="text-label">
                    <label>What value do you expect the SEED program to bring to you and your organization?(maximum 1500
                        characters)
                    </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="expect_seed" name="expect_seed" class="count"></textarea>
                    <span id="error_expect_seed"></span>
                </dd>
                <dt class="text-label">
                    <label>Have you raised institutional funding/grants/investment in the past? if so, how much and from
                        whom?(Maximum character:1500)
                    </label>
                </dt>
                <dd class="text-area">

                    <textarea cols="50" rows="5" id="past_invest" name="past_invest" maxlength="1500"
                              class="count"></textarea>
                    <span id="error_past_invest"></span>
                </dd>

                <!-- Organization ends -->
                <!-- Products step 2 -->
                <dt class="text-label">
                    <label>What is your product/service?
                    </label>
                </dt>
                <dd class="text-area">
                    <input type="text" id="product" size="40" name="product" placeholder="" value=""
                           class="input-text " />
                </dd>

                <dt class="text-label">
                    <label>What need does your product/service address?(Maximum character:1500)
                    </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="product_need" name="product_need" maxlength="1500"
                              class="count"></textarea>
                    <span id="error_product_need"></span>
                </dd>

                <dt class="text-label">
                    <label>What makes your solution innovative?(Maximum character:1500)
                    </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="innovative_solution" maxlength="1500" name="innovative_solution"
                              class="input-text count"></textarea>
                    <span id="error_innovative_solution"></span>
                </dd>

                <!-- Product ends -->

                <!-- Social Impacts step 2 -->

                <dt class="text-label">
                    <label>What is the social impact that your innovation creates?(Maximum character:1500)
                    </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="social_impact" maxlength="1500" name="social_impact"
                              class="input-text count"></textarea>
                    <span id="error_social_impact"></span>
                </dd>

                <dt class="text-label">
                    <label>How does your organization measure its socail impact?(Maximum character:1500)
                    </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="measure_impact" maxlength="1500" name="measure_impact"
                              class="input-text count"></textarea>
                    <span id="error_measure_impact"></span>
                </dd>

                <!-- Social Impacts ends -->

                <!-- Business Viability step 3 -->

                <dt class="text-label">
                    <label>How big do you estimate the market for your product to be?(In terms of Rs. crores)
                    </label>
                </dt>
                <dd class="text-area">
                    <input type="text" id="market_estimate" size="40" name="market_estimate" placeholder="" value=""
                           class="input-text " />
                </dd>

                <dt class="text-label">
                    <label>Have you undertaken pilots for your venture? If so, where and to what scale?(Maximum
                        character:1500)
                    </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="pilots_venture" maxlength="1500" name="pilots_venture"
                              class="input-text count"></textarea>
                    <span id="error_pilots_venture"></span>
                </dd>

                <dt class="text-label">
                    <label>What have been your major learning since launching your incubatee?(Maximum character:1500)
                    </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="launch_learn" maxlength="1500" name="launch_learn"
                              class="input-text count"></textarea>
                    <span id="error_launch_learn"></span>
                </dd>

                <dt class="text-label">
                    <label>Who are your key customers? And who is your end user?(Maximum character:1500)
                    </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="customer" maxlength="1500" name="customer"
                              class="input-text count"></textarea>
                    <span id="error_customer"></span>
                </dd>
                <dt class="text-label">
                    <label>Upload your business plan here
                    </label>
                </dt>
                <dd class="text-area">
                    <span id="business_paln_file">
                        <input type="file" id="business_paln" name="business_plan" size="40" placeholder="" value=""
                               onblur="plan_check('business_paln')" />
                        <span id="business_paln_error" style="color:red"></span>
                    </span>
                    <br /><span style="font-size:10px;color:red">Supports only docx,doc,ppt,pptx,xls,xlsx and pdf
                        files</span>
                </dd>
                <!-- Scalability -->
                <dt class="text-label">
                    <label>List the steps you will take to achieve your business goals for the next six month?(Maximum
                        character:1500)
                    </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="steps_to_goal" maxlength="1500" name="steps_to_goal"
                              class="input-text count"></textarea>
                    <span id="error_steps_to_goal"></span>
                </dd>
                <!-- Scalability ends -->

                <!-- Business Viability ends -->

            </div>


        </dl>
        <div class="clear"></div>
        <div class="buttons">
            <button type="submit" class="button" name="seedSubmit" value="Submit">Submit</button>
            <button type="reset" class="button white" name="txtReset" value="Reset">Reset</button>
        </div>
</form>