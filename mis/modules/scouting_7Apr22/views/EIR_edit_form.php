<script type="text/javascript">
    $(document).ready(function () {

        $("#cancel").click(function () {
            var str = "<?php echo $eir_user[0]['innovation_no']; ?>";
            var res = str.substring(3);
            var redirect = "<?php echo site_url() . '/scouting/innovation_details/'; ?>" + res;
            $(location).attr('href', redirect);
        });

        var stateid = "<?php if (isset($eir_user[0]['state'])) echo $eir_user[0]['state']; ?>";
        var cityid = "<?php if (isset($eir_user[0]['city'])) echo $eir_user[0]['city']; ?>";

        if (stateid) {
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>index.php/scouting/get_city",
                data: {
                    sname: stateid
                },
                success: function (selectValues) {
                    var selectValues = $.parseJSON(selectValues);
                    $('#city').empty();
                    $("#city").prepend("<option value='' selected='selected'>--Select city--</option>");
                    $.each(selectValues, function (key, value) {
                        $('#city')
                                .append($("<option></option>")
                                        .attr("value", key)
                                        .text(value));

                        if (key == cityid) {
                            $('#city')
                                    .append($("<option selected='selected'></option>")
                                            .attr("value", key)
                                            .text(value));
                        }
                    });
                    $('#city')
                            .append($("<option></option>")
                                    .attr("value", 'others')
                                    .text('others'));
                }
            });
        }

        $('#city').change(function () {
            var oth = $("#city").val();
            if (oth == 'others') {
                $("#city_other").show();
                $("#city_oth").addClass("error");
            } else {
                $("#city_other").hide();
                $("#city_oth").removeClass("error");
            }
        });

        $("#state").change(function () {
            var s_name = $("#state").val();
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>index.php/scouting/get_city",
                data: {
                    sname: s_name
                },
                success: function (selectValues) {

                    var selectValues = $.parseJSON(selectValues);

                    $('#city').empty();
                    $("#city").prepend(
                            "<option value='' selected='selected'>--Select city--</option>");
                    $.each(selectValues, function (key, value) {
                        $('#city')
                                .append($("<option></option>")
                                        .attr("value", key)
                                        .text(value));
                    });
                    $('#city')
                            .append($("<option></option>")
                                    .attr("value", 'others')
                                    .text('others'));
                }
            });
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
<?php
foreach ($eir_user as $row):
    ?>
    <h2><?= $row['name_of_organisation'] ?></h2>
    <div id="user-grid" class="grid-view">
        <form method="post" action="<?= site_url('scouting/eirapplication/update_basic_information'); ?>"
              enctype="multipart/form-data" name="" id="eir_edit">
            <table class="gtable " width="80%" class="items" bgcolor="#F5F5F5" cellspacing="5" cellpadding="5" border="1px">
                <thead>
                    <tr>
                        <th colspan="2"><?= $row['name_of_organisation'] ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" style="background-color:#FFF"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color:#FFF"><b>Basic Information</b></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color:#FFF"></td>
                    </tr>
                    <tr class="odd">
                        <td style="width:40%;border-right:thick solid #fff;">Innovation Id </td>
                        <td><?= $row['innovation_no'] ?></td>
                    </tr>
                    <tr class="even">
                        <td>Name of the Organisation<span style="color:red"> *</span></td>
                        <td><input type="text" id="org" name="organisation" placeholder=""
                                   value="<?php echo $organisation = isset($row['name_of_organisation']) ? $row['name_of_organisation'] : ''; ?>" />
                        </td>
                    </tr>
                    <tr class="odd">
                        <td style="border-right:thick solid #fff;">Name of the Applicant<span style="color:red"> *</span>
                        </td>
                        <td><input type="text" id="name" name="applicant" placeholder=""
                                   value="<?php echo $applicant = isset($row['name_of_applicant']) ? $row['name_of_applicant'] : ''; ?>" />
                        </td>
                    </tr>
                    <tr class="even">
                        <td>Email Address<span style="color:red"> *</span></td>
                        <td><input type="text" id="email" name="email1" placeholder=""
                                   value="<?php echo $email = isset($row['email_id']) ? $row['email_id'] : ''; ?>" /></td>
                    </tr>
                    <tr class="odd">
                        <td style="border-right:thick solid #fff;">Mobile Number<span style="color:red"> *</span></td>
                        <td><input type="text" id="mob" name="mobile_no" placeholder=""
                                   value="<?php echo $mobile = isset($row['mobile_no']) ? $row['mobile_no'] : ''; ?>" /></td>
                    </tr>
                    <tr class="even">
                        <td>Alternate Phone Number</td>
                        <td><input type="text" id="mob1" name="phone_no" placeholder=""
                                   value="<?php echo $phone = isset($row['alt_phone_no']) ? $row['alt_phone_no'] : ''; ?>" /></td>
                    </tr>
                    <tr class="odd">
                        <td>Address</td>
                        <td><textarea name="address"
                                      id="address"><?php echo $address = isset($row['address']) ? $row['address'] : ''; ?></textarea>
                        </td>
                    </tr>
                    <tr class="odd">
                        <td style="border-right:thick solid #fff;">State</td>
                        <td>
                            <select id="state" name="state">
                                <option value="">--select a state--</option>
                                <?php foreach ($states as $st) { ?>
                                    <option value="<?= $st['id'] ?>"
                                            <?php echo (isset($row['state']) && $row['state'] == $st['id']) ? 'selected="selected"' : ''; ?>>
                                            <?= $st['state_name'] ?></option>
                                    <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>City</td>
                        <td>
                            <select id="city" name="city">
                                <option value="">--select a city--</option>
                            </select>
                        </td>
                    </tr>

                    <tr id="city_other" style="display:none;" class="even">
                        <td>Specify a city..</td>
                        <td><input type="text" id="city_oth" name="city_oth" placeholder="" /></td>
                    </tr>

                    <tr class="odd">
                        <td style="border-right:thick solid #fff;">Date Created</td>
                        <td><?= $row['date_created'] ?></td>
                    </tr>
                    <tr class="even">
                        <td>Date Submitted</td>
                        <td><?= $row['date_submitted'] ?></td>
                    </tr>

                    <tr class="odd">
                        <td style="border-right:thick solid #fff;">Source</td>
                        <td>Website</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table id="add_info" class="gtable " width="100%">
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"><b>Application Information</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"></td>
                                </tr>
                                <tr class="odd">
                                    <td colspan="2">
                                        <table width="100%" cellspacing="2" cellpadding="2">
                                            <tr>
                                            <input type="hidden" name="applicant_id" value="<?= $app_id ?>" />
                                            <input type="hidden" name="innovation_id"
                                                   value="<?php echo $innnovation_id = isset($eir_user[0]['innovation_no']) ? $eir_user[0]['innovation_no'] : ''; ?>" />
                                            <input type="hidden" name="team_id"
                                                   value="<?php echo $team_id = isset($eir_app[0]['id']) ? $eir_user[0]['id'] : ''; ?>" />
                                            <input type="hidden" name="status" value="<?= $eir_user[0]['status'] ?>" />
                                            <input type="hidden" id="person_id1" name="person_id[]"
                                                   value="<?php echo $per_id = isset($eir_team[0]['id']) ? $eir_team[0]['id'] : ''; ?>" />
                                            <input type="hidden" id="person_id2" name="person_id[]"
                                                   value="<?php echo $per_id = isset($eir_team[1]['id']) ? $eir_team[1]['id'] : ''; ?>" />
                                            <input type="hidden" id="person_id3" name="person_id[]"
                                                   value="<?php echo $per_id = isset($eir_team[2]['id']) ? $eir_team[2]['id'] : ''; ?>" />
                                            <td>
                                                <table style="font: 12px/15px Arial,sans-serif;background-color:none"
                                                       cellspacing="2" cellpadding="2" border="1px;">
                                                    <tr>
                                                        <td colspan="2"
                                                            style="background-color: #A9CF55;text-align: center;">Team
                                                            Member 1</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:thin solid #fff;">Name<span
                                                                style="color:red"> *</span></td>
                                                        <td><input type="text" id="name1" name="name[]" placeholder=""
                                                                   value="<?php echo $name = isset($eir_team[0]['name']) ? $eir_team[0]['name'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:thin solid #fff;">Current
                                                            Organisation<span style="color:red"> *</span></td>
                                                        <td><input type="text" id="org1" name="org[]" placeholder=""
                                                                   value="<?php echo $org = isset($eir_team[0]['current_organisation']) ? $eir_team[0]['current_organisation'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:thin solid #fff;">Current title<span
                                                                style="color:red"> *</span></td>
                                                        <td><input type="text" id="title1" name="title[]" placeholder=""
                                                                   value="<?php echo $title = isset($eir_team[0]['current_title']) ? $eir_team[0]['current_title'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:thin solid #fff;">Email id<span
                                                                style="color:red"> *</span></td>
                                                        <td><input type="text" id="email1" name="email[]" placeholder=""
                                                                   value="<?php echo $email = isset($eir_team[0]['email_id']) ? $eir_team[0]['email_id'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr class="odd">
                                                        <td style="border-right:thin solid #fff;">Mobile No<span
                                                                style="color:red"> *</span></td>
                                                        <td><input type="text" id="mob1" name="mobile[]" placeholder=""
                                                                   value="<?php echo $mobile = isset($eir_team[0]['mobile_no']) ? $eir_team[0]['mobile_no'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table style="font: 12px/15px Arial,sans-serif;background-color:none"
                                                       cellspacing="2" cellpadding="2" border="1px;">
                                                    <tr>
                                                        <td colspan="2"
                                                            style="background-color: #A9CF55;text-align: center;">Team
                                                            Member 2</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:thin solid #fff;">Name</td>
                                                        <td><input type="text" id="name2" name="name[]" placeholder=""
                                                                   value="<?php echo $name = isset($eir_team[1]['name']) ? $eir_team[1]['name'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:thin solid #fff;">Current Organisation
                                                        </td>
                                                        <td><input type="text" id="org2" name="org[]" placeholder=""
                                                                   value="<?php echo $org = isset($eir_team[1]['current_organisation']) ? $eir_team[1]['current_organisation'] : ''; ?>" />
                                                        <td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:thin solid #fff;">Current title</td>
                                                        <td><input type="text" id="title2" name="title[]" placeholder=""
                                                                   value="<?php echo $title = isset($eir_team[1]['current_title']) ? $eir_team[1]['current_title'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:thin solid #fff;">Email id</td>
                                                        <td><input type="text" id="email2" name="email[]" placeholder=""
                                                                   value="<?php echo $email = isset($eir_team[1]['email_id']) ? $eir_team[1]['email_id'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr class="odd">
                                                        <td style="border-right:thin solid #fff;">Mobile No</td>
                                                        <td><input type="text" id="mob2" name="mobile[]" placeholder=""
                                                                   value="<?php echo $mobile = isset($eir_team[1]['mobile_no']) ? $eir_team[1]['mobile_no'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table style="font: 12px/15px Arial,sans-serif;background-color:none"
                                                       cellspacing="2" cellpadding="2" border="1px;">
                                                    <tr>
                                                        <td colspan="2"
                                                            style="background-color: #A9CF55;text-align: center;">Team
                                                            Member 3</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:thin solid #fff;">Name</td>
                                                        <td><input type="text" id="name3" name="name[]" placeholder=""
                                                                   value="<?php echo $name = isset($eir_team[2]['name']) ? $eir_team[2]['name'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:thin solid #fff;">Current Organisation
                                                        </td>
                                                        <td><input type="text" id="org3" name="org[]" placeholder=""
                                                                   value="<?php echo $org = isset($eir_team[2]['current_organisation']) ? $eir_team[2]['current_organisation'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:thin solid #fff;">Current title</td>
                                                        <td><input type="text" id="title3" name="title[]" placeholder=""
                                                                   value="<?php echo $title = isset($eir_team[2]['current_title']) ? $eir_team[2]['current_title'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-right:thin solid #fff;">Email id</td>
                                                        <td><input type="text" id="email3" name="email[]" placeholder=""
                                                                   value="<?php echo $email = isset($eir_team[2]['email_id']) ? $eir_team[2]['email_id'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr class="odd">
                                                        <td style="border-right:thin solid #fff;">Mobile No</td>
                                                        <td><input type="text" id="mob3" name="mobile[]" placeholder=""
                                                                   value="<?php echo $mobile = isset($eir_team[2]['mobile_no']) ? $eir_team[2]['mobile_no'] : ''; ?>" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr></tr>
                    <tr></tr>
                    <tr class="even">
                        <td style="vertical-align:top" width="30%">Briefly describe your key competencies and
                            skills that will enable you to set up an
                            incubatee (250 words):<span style="color:red"> *</span>
                        </td>
                        <td width="60%"><textarea cols="45" name="skills"><?= $eir_app[0]['skills'] ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="background-color:#FFF"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color:#FFF"><b>Information about incubatee</b></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color:#FFF"></td>
                    </tr>
                    <tr class="even">
                        <td style="vertical-align:top" width="30%">Briefly describe your idea, product or
                            service (250 words)<span style="color:red"> *</span></td>
                        <td width="60%"><textarea cols="45"
                                                  name="idea"><?= $eir_app[0]['describtion_of_idea'] ?></textarea></td>
                    </tr>
                    <tr class="odd">
                        <td style="vertical-align:top" width="30%" style="border-right:thick solid #fff;">
                            Describe the innovative element in your incubatee (250 words)<span
                                style="color:red"> *</span></td>
                        <td width="60%"><textarea cols="45"
                                                  name="enterprise"><?= $eir_app[0]['innovative_element'] ?></textarea></td>
                    </tr>
                    <tr class="even">
                        <td style="vertical-align:top" width="30%">What need does your idea address? What is the
                            social benefit created by your idea
                            (250 words)<span style="color:red"> *</span></td>
                        <td width="60%"><textarea cols="45"
                                                  name="social"><?= $eir_app[0]['social_benefit'] ?></textarea></td>
                    </tr>
                    <tr class="odd">
                        <td style="vertical-align:top" style="border-right:thick solid #fff;" width="30%">Have
                            you undertaken any pilots for your idea? If yes, please provide some detail on
                            the pilot and the key insights you gathered form the pilot (250 words)<span
                                style="color:red"> *</span></td>
                        <td width="60%"><textarea cols="45"
                                                  name="pilot"><?= $eir_app[0]['pilots_of_idea'] ?></textarea></td>
                    </tr>
                    <tr class="even">
                        <td style="vertical-align:top" width="30%">What are your expectations from the EIR
                            program? What specific value addition
                            are you looking for? (250 words)<span style="color:red"> *</span></td>
                        <td width="60%"><textarea cols="45"
                                                  name="program"><?= $eir_app[0]['expectation_from_EIR'] ?></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color:#FFF"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color:#FFF"><b>Additional Information</b></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color:#FFF"></td>
                    </tr>
                    <tr class="odd">
                        <td style="border-right:thick solid #fff;" width="30%">Have you raised any funding for
                            your incubatee?<span style="color:red"> *</span></td>
                        <td width="60%">
                            <input type="radio" name="funding" value="1"
                            <?php echo $checked = (isset($eir_app[0]['funding']) && ($eir_app[0]['funding'] == '1')) ? 'checked=checked' : ''; ?>
                                   onchange="show_fund_div(this.value, 'funding');" /> Yes&nbsp;
                            <input type="radio" name="funding" value='0'
                            <?php echo $checked = (isset($eir_app[0]['funding']) && ($eir_app[0]['funding'] == '0')) ? 'checked=checked' : ''; ?>
                                   onchange="show_fund_div(this.value, 'funding');" /> No
                            <!--<? echo $val = ($eir_app[0]['funding'] == '1') ? 'YES' : 'No'; ?>-->
                        </td>
                    </tr>


                    <tr id="funding"
                        style="<?php echo (isset($eir_app[0]['funding']) && ($eir_app[0]['funding'] == '0')) ? 'display:none' : 'display:block'; ?>"
                        class="even">
                        <td rowspan="2" style="vertical-align:top" width="30%">
                            If yes, provide details of funding raised
                        </td>
                        <td rowspan="2" width="60%">
                            <textarea
                                name="fund_detail"><?php echo $fund_detail = isset($eir_app[0]['funding_detail']) ? $eir_app[0]['funding_detail'] : ''; ?></textarea>
                        </td>
                    </tr>

                    <tr class="odd">
                        <td style="border-right:thick solid #fff;" width="30%">Have you set up an incubatee
                            previously?<span style="color:red"> *</span></td>
                        <td width="60%">
                            <input type="radio" name="setup" value="1"
                            <?php echo $checked = (isset($eir_app[0]['enterprise_setup']) && ($eir_app[0]['enterprise_setup'] == '1')) ? 'checked=checked' : ''; ?>
                                   onchange="show_fund_div(this.value, 'setup');" /> Yes&nbsp;
                            <input type="radio" name="setup" value="0"
                            <?php echo $checked = (isset($eir_app[0]['enterprise_setup']) && ($eir_app[0]['enterprise_setup'] == '0')) ? 'checked=checked' : ''; ?>
                                   onchange="show_fund_div(this.value, 'setup');" /> No
                        </td>
                    </tr>

                    <tr id="setup"
                        style="<?php echo (isset($eir_app[0]['enterprise_setup']) && ($eir_app[0]['enterprise_setup'] == '0')) ? 'display:none' : 'display:block'; ?>"
                        class="even">
                        <td style="vertical-align:top" width="30%">
                            <label>If yes, provide details of incubatee and current status of the incubatee
                            </label>
                        </td>
                        <td width="60%">
                            <textarea
                                name="setup_detail"><?php echo $setup_detail = isset($eir_app[0]['setup_detail']) ? $eir_app[0]['setup_detail'] : ''; ?></textarea>
                        </td>

                    <tr class="odd">
                        <td style="border-right:thick solid #fff;" width="30%">Are you incorporated as a
                            for-profit entity?<span style="color:red"> *</span></td>
                        <td width="60%">
                            <input type="radio" name="profit" value="1"
                                   <?php echo $checked = (isset($eir_app[0]['for_profit']) && ($eir_app[0]['for_profit'] == 1)) ? 'checked=checked' : ''; ?> />
                            Yes&nbsp;
                            <input type="radio" name="profit" value="0"
                                   <?php echo $checked = (isset($eir_app[0]['for_profit']) && ($eir_app[0]['for_profit'] == 0)) ? 'checked=checked' : ''; ?> />
                            No
                        </td>
                    </tr>
                    <tr class="even">
                        <td style="border-right:thick solid #fff;" width="30%">The Entrepreneur-in-Residence
                            program is a full-time, 12-month commitment. Are you willing to commit 12 months to
                            establishing your business?<span style="color:red"> *</span></td>
                        <td width="60%">
                            <input type="radio" name="program_time" value="1"
                                   <?php echo (isset($eir_app[0]['program_time']) && ($eir_app[0]['program_time'] == 1)) ? 'checked=checked' : ''; ?> />
                            Yes&nbsp;
                            <input type="radio" name="program_time" value="0"
                                   <?php echo (isset($eir_app[0]['program_time']) && ($eir_app[0]['program_time'] == 0)) ? 'checked=checked' : ''; ?> />
                            No
                        </td>
                    </tr>
                    <tr class="odd">
                        <td style="border-right:thick solid #fff;vertical-align:top" width="30%">How did you
                            hear about the Entrepreneur-in-Residence program?<span style="color:red"> *</span>
                        </td>
                        <td width="60%"><textarea cols="45"
                                                  name="entrepreneur"><?= $eir_app[0]['know_about'] ?></textarea></td>
                    </tr>
                    <?php
                    $record1 = explode("|", $eir_file[0]['resume']);
                    $record2 = explode("|", $eir_file[0]['additional_documents']);
                    ?>
                    <tr>
                        <td colspan="2" style="background-color:#FFF"><b>Additional Documents</b></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color:#FFF"></td>
                    </tr>
                    <tr class="odd">
                        <td style="border-right:thick solid #fff;">Resume<span style="color:red"> *</span></td>
                        <td width="30%">
                            <input type="file" id="file1" name="resume[]" />
    <?php
    if (isset($record1[0])) {
        $filename = pathinfo($record1[0], PATHINFO_FILENAME);
        ?>
                                <a href="<?php echo $record1[0]; ?>" download
                                   target="_blank"><?php echo $filename; ?></a>
                                <?php
                            }
                            ?>
                            <input type="hidden" name="hresume[]"
                                   value="<?php echo isset($record1[0]) ? $record1[0] : ''; ?>" />
                            <br />
                        </td>
                    </tr>
                    <tr class="even">
                        <td></td>
                        <td width="30%">
                            <input type="file" id="file2" name="resume[]" />
    <?php
    if (isset($record1[1])) {
        $filename = pathinfo($record1[1], PATHINFO_FILENAME);
        ?>
                                <a href="<?php echo $record1[1]; ?>" download><?php echo $filename; ?></a>
                                <?php
                            }
                            ?>
                            <input type="hidden" name="hresume[]"
                                   value="<?php echo isset($record1[1]) ? $record1[1] : ''; ?>" />
                        </td>
                    </tr>
                    <tr class="odd">
                        <td></td>
                        <td width="30%">
                            <input type="file" id="file3" name="resume[]" />
    <?php
    if (isset($record1[2])) {
        $filename = pathinfo($record1[2], PATHINFO_FILENAME);
        ?>
                                <a href="<?php echo $record1[2]; ?>" download><?php echo $filename; ?></a>
                                <?php
                            }
                            ?>
                            <input type="hidden" name="hresume[]"
                                   value="<?php echo isset($record1[2]) ? $record1[2] : ''; ?>" />
                        </td>
                    </tr>
                    </td>
                    </tr>
                    <tr class="even">
                        <td>General Documents</td>
                        <td style="width:50%;">

                            <input type="file" id="file11" name="add_doc[]" />
    <?php
    if (isset($record2[0])) {
        $filename = pathinfo($record2[0], PATHINFO_FILENAME);
        ?>
                                <a href="<?php echo $record1[0]; ?>" download target="_blank"><?php echo $filename; ?></a>
                                <?php
                            }
                            ?>
                            <input type="hidden" name="hdoc[]" value="<?php echo isset($record2[0]) ? $record2[0] : ''; ?>" />
                            <br />
                        </td>
                    </tr>
                    <tr class="odd">
                        <td></td>
                        <td width="30%">
                            <input type="file" id="file12" name="add_doc[]" />
    <?php
    if (isset($record2[1])) {
        $filename = pathinfo($record2[1], PATHINFO_FILENAME);
        ?>
                                <a href="<?php echo $record1[1]; ?>" download><?php echo $filename; ?></a>
                                <?php
                            }
                            ?>
                            <input type="hidden" name="hdoc[]" value="<?php echo isset($record2[1]) ? $record2[1] : ''; ?>" />
                        </td>
                    </tr>

                    </td>
                    </tr>
            </table>
            <input type="submit" value="Save" name="edit_save" class="button" />
            <input type="button" value="Cancel" name="edit_cancel" id="cancel" class="button" />
            </tbody>
            </table>
    <?php
endforeach;
?>
    </form>
</div>
<script>
    $(document).ready(function () {
        $.validator.addMethod("extension", function (value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        }, $.format("Please enter a value with a valid extension."));

        $.validator.addMethod("integer", function (value, element) {
            return this.optional(element) || /^\+?[0-9 -]+$/.test(value);
        }, "A positive or negative non-decimal number please");

        // validate the comment form when it is submitted
        $('#eir_edit').validate({
            rules: {
                'email[]': {
                    email: true
                },
                'mobile[]': {
                    integer: true,
                    minlength: 8,
                    maxlength: 15
                },
                organisation: "required",
                applicant: "required",
                email1: {
                    required: true,
                    email: true
                },
                mobile_no: {
                    required: true,
                    integer: true,
                    minlength: 8,
                    maxlength: 15
                },
                phone_no: {
                    integer: true,
                    minlength: 8,
                    maxlength: 15
                },
                'resume[]': {
                    extension: "doc|docx|xls|xlsx|txt|pdf"
                },
                'add_doc[]': {
                    extension: "doc|docx|xls|xlsx|txt|pdf"
                }
            },
            messages: {
                'email[]': {
                    email: "Enter the email address",
                },
                'mobile[]': {
                    integer: "Enter the valid mobile number",
                    minlength: "Mobile Number must be 8-15 in length",
                    maxlength: "Mobile Number must be 8-15 in length"
                },
                organisation: "Enter the organisation name",
                applicant: "Enter the applicant name",
                email1: "Enter the valid email address",
                mobile_no: {
                    required: "Enter the mobile number",
                    integer: "Enter the valid mobile number",
                    minlength: "Mobile Number must be 8-15 in length",
                    maxlength: "Mobile Number must be 8-15 in length"
                },
                phone_no: {
                    integer: "Enter the valid phone number",
                    minlength: "Phone Number must be 8-15 in length",
                    maxlength: "Phone Number must be 8-15 in length"
                },
                'resume[]': {
                    extension: "Please upload a valid file"
                },
                'add_doc[]': {
                    extension: "Please upload a valid file"
                }
            }
        });
    });

</script>