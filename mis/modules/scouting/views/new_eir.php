<script type="text/javascript">
    $(document).ready(function () {

        $("#add_info1").hide();
        $("#ex_info1").show();

        $('#ex_info1').click(function () {
            $("#add_info1").slideToggle();
        });

    });

    function show_fund_div(value, element) {
        if (value == 1) {
            document.getElementById(element).style.display = 'block';
        } else {
            document.getElementById(element).style.display = 'none';
        }
    }
</script>



<form name="new_eir" action="" enctype="multipart/form-data" method="post" id="new_eir" class="uniform">

    <dl class="inline">

        <dl>
            <dt>
                <label>Name of Organization <span class="req_field">*</span></label>
            </dt>
            <dd>
                <input type="text" id="organisation" name="organisation" placeholder="" class="required input-text "
                       size="40"
                       value="<?php echo $organisation = isset($details['name_of_organisation']) ? $details['name_of_organisation'] : ''; ?>" />

            </dd>
            <dt>
                <label>Name of Applicant <span class="req_field">*</span></label>
            </dt>
            <dd>
                <input type="text" id="applicant" name="applicant" class="required input-text " size="40" placeholder=""
                       value="<?php echo $applicant = isset($details['name_of_applicant']) ? $details['name_of_applicant'] : ''; ?>" />

            </dd>
            <dt>
                <label>Email <span class="req_field">*</span></label>
            </dt>
            <dd>
                <input type="text" id="email1" name="email1" class="required input-text " size="40" placeholder=""
                       value="<?php echo $email = isset($details['email_id']) ? $details['email_id'] : ''; ?>" />

            </dd>
            <dt>
                <label>Mobile Number <span class="req_field">*</span></label>
            </dt>
            <dd>
                <input type="text" id="mobile_no" name="mobile_no" class="required input-text " size="40" placeholder=""
                       value="<?php echo $mobile = isset($details['mobile_no']) ? $details['mobile_no'] : ''; ?>" />

            </dd>
            <dt>
                <label>Alternate Phone Number</label>
            </dt>
            <dd>
                <input type="text" id="phone_no" size="40" name="phone_no" placeholder=""
                       value="<?php echo $phone = isset($details['alt_phone_no']) ? $details['alt_phone_no'] : ''; ?>" />

            </dd>

            <dt>
                <label>Address <span class="req_field">*</span></label>
            </dt>
            <dd>
                <textarea cols="40" rows="5" class="required input-text " name="address"
                          id="address"><?php echo $address = isset($details['address']) ? $details['address'] : ''; ?></textarea>
            </dd>
            <dt>
                <label>State <span class="req_field">*</span></label>
            </dt>
            <dd>
                <select id="state" name="state">
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
                <label>City <span class="req_field">*</span></label>
            </dt>
            <dd>
                <select id="city" name="city">
                    <option value="">--select a city--</option>

                </select>
            </dd>
            <div id="city_other" style="display:none">
                <dt>
                    <label>Others specify here <span class="req_field">*</span></label>
                </dt>
                <dd>
                    <input id="city_oth" name="city_oth" type="text" value="" />
                </dd>
            </div>

            <div class="spacer"></div>


            <dt style="float:right;">
                <h1><a href="#bottom" id="ex_info1" style="color:#719e41;">** Add Additional Information</a></h1>
            </dt>
            <div id="add_info1" style="display:none;">

                <dt>
                    <h3 style="color:green">Team Member 1</h3>
                </dt>
                <dt>
                    <label>Name</label>
                </dt>
                <dd>
                    <input type="text" id="name1" name="name[]" size="40" placeholder="" value="" />

                </dd>
                <dt>
                    <label>Current Organization</label>
                </dt>
                <dd>
                    <input type="text" id="org1" name="org[]" size="40" placeholder="" value="" />

                </dd>
                <dt>
                    <label>Current Title </label>
                </dt>
                <dd>
                    <input type="text" id="title1" name="title[]" size="40" placeholder="" value="" />

                </dd>
                <dt>
                    <label>Email Address </label>
                </dt>
                <dd>
                    <input type="text" id="email1" name="email[]" size="40" placeholder="" value="" />

                </dd>
                <dt>
                    <label>Mobile Number </label>
                </dt>
                <dd>

                    <input type="text" id="mob1" name="mobile[]" size="40" placeholder="" value="" />

                </dd>
                <dt>

                    <h3 style="color:green">Team Member 2</h3>
                </dt>
                <dt>
                    <label>Name</label>
                </dt>
                <dd>
                    <input type="text" id="name2" name="name[]" size="40" placeholder="" value="" />

                </dd>
                <dt>
                    <label>Current Organization</label>
                </dt>
                <dd>
                    <input type="text" id="org2" name="org[]" size="40" placeholder="" value="" />

                </dd>
                <dt>
                    <label>Current Title</label>
                </dt>
                <dd>
                    <input type="text" id="title2" name="title[]" size="40" placeholder="" value="" />

                </dd>
                <dt>
                    <label>Email Address</label>
                </dt>
                <dd>
                    <input type="text" id="email2" name="email[]" size="40" placeholder="" value="" />

                </dd>
                <dt>
                    <label>Mobile Number</label>
                </dt>
                <dd>
                    <input type="text" id="mob2" name="mobile[]" size="40" placeholder="" value="" />
                    <input type="hidden" id="per_id2" name="per_id[]" placeholder="" value="" />

                </dd>
                <dt>
                    <h3 style="color:green">Team Member 3</h3>
                </dt>
                <dt>
                    <label>Name</label>
                </dt>
                <dd>
                    <input type="text" id="name3" name="name[]" size="40" placeholder="" value="" />

                </dd>
                <dt>
                    <label>Current Organization</label>
                </dt>
                <dd>
                    <input type="text" id="org3" name="org[]" size="40" placeholder="" value="" />

                </dd>
                <dt>
                    <label>Current Title</label>
                </dt>
                <dd>
                    <input type="text" id="title3" name="title[]" size="40" placeholder="" value="" />

                </dd>
                <dt>
                    <label>Email Address</label>
                </dt>
                <dd>
                    <input type="text" id="email3" name="email[]" size="40" placeholder="" value="" />

                </dd>
                <dt>
                    <label>Mobile Number</label>
                </dt>
                <dd>
                    <input type="text" id="mob3" name="mobile[]" size="40" placeholder="" value="" />
                    <input type="hidden" id="per_id3" name="per_id[]" placeholder="" value="" />

                </dd>

                <dt class="text-label">
                    <label>b) Briefly describe your key competencies and skills that will enable you to set up
                        an incubatee (250 words):</label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="skills" name="skills"></textarea>

                </dd>
                <dt class="text-label">
                    <label>a) Briefly describe your idea, product or service (250 words) </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="text1" name="describtion"></textarea>
                </dd>
                <dt class="text-label">
                    <label>b) Describe the innovative element in your incubatee (250 words) </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="text2" name="innovative_element"></textarea>
                </dd>
                <dt class="text-label">
                    <label>c) What need does your idea address? What is the social benefit created by your idea? (250
                        words) </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="text3" name="social_benefit"></textarea>
                </dd>
                <dt class="text-label">
                    <label>d) Have you undertaken any pilots for your idea? If yes, please provide some detail on the
                        pilot and the key insights you gathered from the pilot (250 words) </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="text4" name="pilots"></textarea>
                </dd>
                <dt class="text-label">
                    <label>e) What are your expectations from the EIR program? What specific value addition are you
                        looking for? (250 words) </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" id="text5" name="expectation"></textarea>
                </dd>
                <dt class="text-label">
                    <label>a) Have you raised any funding for your incubatee? </label>
                </dt>
                <dd>
                    <input type="radio" name="funding" value="1" onchange="show_fund_div(this.value, 'funding');" />
                    Yes&nbsp;
                    <input type="radio" name="funding" value='0' onchange="show_fund_div(this.value, 'funding');" /> No
                </dd>
                <div id="funding" style="display:none;">
                    <dt class="text-label">
                        <label>If yes, provide details of funding raised</label>
                    </dt>
                    <dd class="text-area">
                        <textarea cols="50" rows="5" name="fund_detail"></textarea>
                    </dd>
                </div>
                <dt class="text-label">
                    <label>b) Have you set up an incubatee previously? </label>
                </dt>
                <dd>
                    <input type="radio" name="setup" value="1" onchange="show_fund_div(this.value, 'setup');" />
                    Yes&nbsp;
                    <input type="radio" name="setup" value="0" onchange="show_fund_div(this.value, 'setup');" /> No
                </dd>
                <div id="setup" style="display:none;">
                    <dt class="text-label">
                        <label>If yes, provide details of incubatee and current status of the incubatee </label>
                    </dt>
                    <dd class="text-area">
                        <textarea cols="50" rows="5" name="setup_detail"></textarea>
                    </dd>
                </div>
                <dt class="text-label">
                    <label>c) Are you incorporated as a for-profit entity? </label>
                </dt>
                <dd>

                    <input type="radio" name="profit" value="1" /> Yes &nbsp;
                    <input type="radio" name="profit" value="0" /> No
                </dd>
                <dt class="text-label">
                    <label>d) The Entrepreneur-in-Residence program is a full-time, 12-month commitment. Are you willing
                        to commit 12 months to establishing your business? </label>
                </dt>
                <dd>
                    <input type="radio" name="program_time" value="1" /> Yes&nbsp;
                    <input type="radio" name="program_time" value="0" /> No
                </dd>
                <dt class="text-label">
                    <label>e) How did you hear about the Entrepreneur-in-Residence program? </label>
                </dt>
                <dd class="text-area">
                    <textarea cols="50" rows="5" name="know_about"></textarea>
                </dd>
                <dt class="text-label">
                    <label>a) Please upload a resume for each member of your team </label>
                </dt>

                <dt>
                <dd>
                    <input type="file" id="file1" name="resume[]" />
                    <br />
                    <input type="file" id="file2" name="resume[]" />
                    <br>
                    <input type="file" id="file3" name="resume[]" />
                </dd>
                </dt>

                <dt class="text-label">
                    <label>b.Please upload any other additional documents you feel relevant to this application</label>
                </dt>
                <dt>
                <dd>
                    <input type="file" id="add1" name="additional[]" />
                    <br>
                    <input type="file" id="add2" name="additional[]" />
                    <br>
                </dd>
                </dt>

            </div>


        </dl>
        <div class="clear"></div>
        <div class="buttons">
            <button type="submit" class="button" name="eirSubmit" value="Submit">Submit</button>
            <button type="reset" class="button white" name="txtReset" value="Reset">Reset</button>
        </div>
</form>