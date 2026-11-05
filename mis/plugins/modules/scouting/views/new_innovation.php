<?php $sectors_values = $sectors; ?>
<script type="text/javascript">
    $(document).ready(function () {

        $(document).on('keyup', 'textarea', function () {
            if (this.value.match(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g)) {
                this.value = this.value.replace(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g, '');
            }
        });

        $.validator.addMethod("extension", function (value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        }, $.format("Please enter a value with a valid extension."));

        $.validator.addMethod("integer", function (value, element) {
            return this.optional(element) || /^\+?[0-9 -]+$/.test(value);
        }, "A positive or negative non-decimal number please");
        // validate the comment form when it is submitted


        /* Innovation validation */
        $('#new_innovation').validate({
            rules: {
                program: {
                    required: true
                }
            }
        });
        /* Innovation validation ends */

        $('#new_eir').validate({
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
                address: "required",
                state: "required",
                city: "required",
                'resume[]': {
                    extension: "doc|docx|xls|xlsx|txt|pdf"
                },
                'additional[]': {
                    extension: "doc|docx|xls|xlsx|txt|pdf"
                }
            },
            messages: {
                'email[]': "Enter the email address",
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
                address: "Enter the address",
                state: "Select the state",
                city: "Select the city",
                'resume[]': {
                    extension: "Please upload a valid file"
                },
                'additional[]': {
                    extension: "Please upload a valid file"
                }
            }
        });

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
                url: "get_cities/" + s_name,
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


    $(document).ready(function () {
        var prog = $("#program").val();
        if (prog == 1) {
            $("#pitch").hide();
            $("#incubation").hide();
            $("#seed").hide();
            $("#import_button").hide();
            $("#eir").show();
        } else if (prog == 2) {
            $("#pitch").hide();
            $("#eir").hide();
            $("#seed").show();
            $("#import_button").hide();
            $("#incubation").hide();
        } else if (prog == 3) {
            $("#pitch").show();
            $("#eir").hide();
            $("#seed").hide();
            $("#import_button").hide();
            $("#incubation").hide();
        } else {
            $("#pitch").hide();
            $("#eir").hide();
            $("#seed").hide();
            $("#import_button").show();
            $("#incubation").show();
        }

        $("#add_info").hide();
        $("#ex_info").show();

        $('#ex_info').click(function () {
            $("#add_info").slideToggle();
        });

        $("#program").change(function () {
            var prog = $("#program").val();
            if (prog == 1) {
                $("#incubation").hide();
                $("#add_info2").hide();
                $("#seed").hide();
                $("#pitch").hide();
                $("#import_button").hide();
                $("#eir").show();
            } else if (prog == 2) {
                $("#eir").hide();
                $("#pitch").hide();
                $("#seed").show();
                $("#incubation").hide();
                $("#add_info1").hide();
                $("#import_button").hide();
            } else if (prog == 3) {
                $("#pitch").show();
                $("#eir").hide();
                $("#seed").hide();
                $("#incubation").hide();
                $("#import_button").hide();
            } else {
                $("#eir").hide();
                $("#seed").hide();
                $("#add_info1").hide();
                $("#pitch").hide();
                $("#import_button").show();
                $("#incubation").show();
            }
        });

    });
</script>

<script type="text/javascript">
    $(document).ready(function () {

        $("#add_info2").hide();
        $("#ex_info2").show();

        $('#ex_info2').click(function () {
            $("#add_info2").slideToggle();
        });

    });
</script>

<?php
$formAction = site_url('scouting/new_innovation');
$val = array();
if (count($innovationDetails)) {
    $val = $innovationDetails['0'];
    $formAction = site_url('scouting/new_innovation/' . $val['id']);
    $action = 'edit';
} else
    $action = 'add';

if (isset($_POST['action'])) {
    $val = $_POST;
}
$id = isset($val["id"]) ? $val["id"] : "";
$branch_name = isset($val['partner_id']) ? $val['partner_id'] : "";
$source_type = isset($val["sourceType"]) ? $val["sourceType"] : "";
$source = isset($val["source"]) ? $val["source"] : "";
$sector = isset($val["sector"]) ? $val["sector"] : "";
$source_others = isset($val["source_others"]) ? $val["source_others"] : "";
$sector_others = isset($val["sector_others"]) ? $val["sector_others"] : "";
$instance = isset($val["instance"]) ? $val["instance"] : '';
$name_of_entrepreneur = isset($val["name_of_entrepreneur"]) ? $val["name_of_entrepreneur"] : '';
$mobile_no = isset($val["mobile_no"]) ? $val["mobile_no"] : '';
$phone_no = isset($val["phone_no"]) ? $val["phone_no"] : '';
$email_id = isset($val["email_id"]) ? $val["email_id"] : '';
$address_line1 = isset($val["address_line1"]) ? $val["address_line1"] : '';
$address_line2 = isset($val["address_line2"]) ? $val["address_line2"] : '';
$city = isset($val["city"]) ? $val["city"] : '';
$district = isset($val["district"]) ? $val["district"] : '';
$state = isset($val["state"]) ? $val["state"] : '';
$country = isset($val["country"]) ? $val["country"] : '';
$pincode = isset($val["pincode"]) ? $val["pincode"] : '';
$name_of_enterprise = isset($val["name_of_enterprise"]) ? $val["name_of_enterprise"] : '';
$website = isset($val["website"]) ? $val["website"] : '';
$username = isset($val["username"]) ? $val["username"] : '';
$password = isset($val["password"]) ? $val["password"] : '';
$summary = isset($val["summary_of_business"]) ? $val["summary_of_business"] : '';
$entreprise_years = isset($val["entreprise_years"]) ? $val["entreprise_years"] : '';
$business_plan = isset($val["business_plan"]) ? $val["business_plan"] : '';
$business_plan_document = isset($val["business_plan_document"]) ? $val["business_plan_document"] : '';
$prog = isset($val['program']) ? $val["program"] : '';
?>
<?php
$style = "";
if (isset($_POST['program']) && $_POST['program'] == "1") {
    $cpagetitle = "EIR Application";
    $style = "style='visibility:hidden'";
}
?>
<ul class="option-tab">
    <?php
    if ($this->session->userdata('user_name') == 'Altacit') {
        ?>
        &nbsp;&nbsp;
        <li><a href="<?= site_url('login/icon_menu/'); ?>" class="button">Back</a></li>
        <li><a href="<?= site_url('login/logout'); ?>" class="button">Logout</a></li>
    <?php } else { ?>
        <?php if ($action == 'add') { ?>
            <li><a href="<?= site_url('login/icon_menu/'); ?>" class="button">Back</a></li>
        <?php } else { ?>
            <li><a href="<?= site_url('login/assessment/' . $id); ?>" class="button">Back</a></li>
            <?php
        }
    }
    ?>
</ul>
<br />
<h2 style="font-family:Gill !important;"><?= $cpagetitle; ?> </h2>
<div class="clear"></div>

<?php /* ?>
  <form class="uniform">
  <dl class="inline">
  <?php if ($this->session->userdata['partner_id'] == 2) { ?>
  <dt><label for="program">Program<span class="req_field">*</span></label></dt>
  <dd>
  <select name="program" id="program" class="required">
  <option value="">Select Program</option>
  <option value="0" <?php echo (isset($prog) && $prog == 0) ? 'selected="selected"' : ''; ?>>Incubation</option>

  </select>
  </dd>

  <?php } else { ?>
  <dt><label for="program">Program<span class="req_field">*</span></label></dt>
  <dd>
  <select name="program" id="program" class="required">
  <option value="">Select Program</option>
  <option value="0" <?php echo (isset($prog) && $prog == 0) ? 'selected="selected"' : ''; ?>>Incubation</option>
  <!--<option value="3" <?php echo (isset($prog) && $prog == 3) ? 'selected="selected"' : ''; ?>>Pitch</option>-->
  </select>
  </dd>
  <?php } ?>
  </dl>
  </form>
  <?php */ ?>

<div id="incubation" style="display:block;">
    <?php if (isset($old_inv) && $old_inv == 'set') { ?>
        <form name="new_innovation" action="<?= $formAction; ?>" enctype="multipart/form-data" method="post"
              id="new_innovation" class="uniform">
            <input type="hidden" value="<?= $action ?>" name="action" />
            <input type="hidden" value="<?= $id ?>" name="id" />
            <input type="hidden" value="<?= $videoOption ?>" name="videoOption" />
            <dl class="inline">
                <?php if ($source != '0' || $action == 'add') { ?>
                    <input type="hidden" value="<?= $source ?>" name="source" />
                    <input type="hidden" value="<?= $instance ?>" name="instance" />

                <?php } else {
                    ?>
                    <input type="hidden" value="<?= $source_type ?>" name="source_type" />
                    <input type="hidden" value="<?= $source ?>" name="source" />
                    <input type="hidden" value="<?= $instance ?>" name="instance" />
                <?php } ?>

                <dt><label for="branch_name">Branch<span class="req_field">*</span></label></dt>
                <dd><select name="branch_name" id="branch_name" class="required">
                        <option value="">-Select-</option>
                        <?php
                        foreach ($branch as $res):
                            ?>
                            <option value="<?= $res['partner_id'] ?>"
                                    <?php echo ($branch_name == $res['partner_id']) ? ('selected') : (''); ?>><?= $res['branch_name'] ?>
                            </option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </dd>


                <dt><label for="name_of_entrepreneur">Name of the Promoter<span class="req_field">*</span></label></dt>
                <dd>
                    <input type="text" size="40" name="name_of_entrepreneur" value="<?= $name_of_entrepreneur ?>"
                           class="required input-text " />
                </dd>


                <dt><label for="summary">Short Summary of the Business<span class="req_field">*</span></label></dt>
                <dd>
                    <textarea cols="40" rows="5" class="required input-text " name="summary"><?= $summary ?></textarea>
                </dd>



                <dt><label for="mobile_no">Mobile Number</label></dt>
                <dd>
                    <input type="text" size="40" name="mobile_no" value="<?= $mobile_no ?>" class="input-text  mobile" />
                </dd>


                <dt><label for="email_id">Email ID</label></dt>
                <dd>
                    <input type="text" size="40" name="email_id" value="<?= $email_id ?>" class="input-text  email" />
                </dd>


                <dt><label for="name_of_enterprise">Name of the Incubatee</label></dt>
                <dd>
                    <input type="text" size="40" name="name_of_enterprise" value="<?= $name_of_enterprise ?>"
                           class="input-text " />
                </dd>



                <dt style="float:right;">
                    <h1><a href="#bottom" id="ex_info2" style="color:#719e41;">** Add Additional Information</a></h1>
                </dt>
                <div id="add_info2" style="display:none;">

                    <dt><label for="source_type">Source Type</label></dt>
                    <dd><select name="source_type" id="sourceType" class="">
                            <option value="">-Select-</option>
                            <?php
                            foreach ($sourceTypeList as $row):
                                ?>
                                <option value="<?= $row['id'] ?>" <?php echo ($source_type == $row['id']) ? ('selected') : (''); ?>>
                                    <?= $row['master_name'] ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </dd>




                    <dt><label for="source">Source</label></dt>
                    <dd>

                        <select name="source" id="sourceList">
                            <option value="">-Select-</option>
                        </select>
                        <span style="display:<?php echo ($source_others == null ? 'none' : 'inline'); ?>" id="src_others">
                            <input type="text" name="source_others" id="souce_others"
                                   value="<?php echo $source_others; ?>" />
                        </span>
                    </dd>
                    <dt><label for="instance">Instance</label></dt>
                    <dd>

                        <select name="instance" id="instanceList">
                            <option value="">-Select-</option>
                        </select>
                    </dd>

                    <dt><label for="sector">Sector</label></dt>
                    <dd>

                        <select name="sector" id="sectorList">
                            <option value="">-Select-</option>
                            <option value="Agriculture" <?php echo ($sector == 'Agriculture') ? 'selected' : ''; ?>>
                                Agriculture</option>
                            <option value="Education" <?php echo ($sector == 'Education') ? 'selected' : ''; ?>>Education
                            </option>
                            <option value="Energy" <?php echo ($sector == 'Energy') ? 'selected' : ''; ?>> Energy</option>
                            <option value="Health" <?php echo ($sector == 'Health') ? 'selected' : ''; ?>>Health</option>
                            <option value="others" <?php echo ($sector == 'others') ? 'selected' : ''; ?>>Others</option>
                        </select>

                        <span
                        <?php echo ($sector_others != null && $sector == "others" ? "style='display:inline'" : "style='display:none'"); ?>
                            id="sector_others">
                            <input type="text" name="sector_others" value="<?= $sector_others ?>" />
                        </span>
                    </dd>

                    <?php if ($action == 'add') { ?>
                        <dt><label for="f">Any other supporting document you would like to share pertaining to the
                                Innovation?</label></dt>
                        <dd>
                            <table border="0" cellspacing="5" cellpadding="5" class="documentTable gtable sortable">
                                <tr>
                                    <td><strong>Document Type:</strong></td>
                                    <td><strong>Document:</strong></td>
                                    <td><a href="javascript:void(0);" class="addDocument button">Add Row</a>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="document_type[]" id="sourceType">
                                            <option value="">-Select-</option>
                                            <?php
                                            foreach ($documentTypeList as $row):
                                                ?>
                                                <option value="<?= $row['id'] ?>"><?= $row['master_name'] ?></option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                        <font color="red"></font>
                                    </td>
                                    <td><input type="file" name="supporting_documents[]" />
                                        <a href="javascript:void(0);" style="display:none"
                                           class="showYoutube button">Youtube</a>
                                        <div style="display:none; padding-top:5px;" class="youtubeField">
                                            <input type="text" name="youtube[]" class="input-text" size="40" /><br />
                                            Ex:<a href="http://www.youtube.com/watch?v=F7lao4eonuI" target="_blank"
                                                  style="color:#666;">
                                                http://www.youtube.com/watch?v=F7lao4eonuI</a>
                                            &nbsp;&nbsp;<a href="javascript:void(0);" class="hideYoutube">Hide</a></div>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </dd>
                    <?php } ?>

                    <dt><label for="phone_no">Phone Number</label></dt>
                    <dd>
                        <input type="text" size="40" name="phone_no" value="<?= $phone_no ?>" class="input-text  phone" />
                    </dd>


                    <dt><label for="address_line1">Address Line 1</label></dt>
                    <dd>
                        <input type="text" size="40" name="address_line1" value="<?= $address_line1 ?>" class="input-text " />
                    </dd>
                    <dt><label for="select1">Address Line 2</label></dt>
                    <dd>
                        <input type="text" size="40" name="address_line2" value="<?= $address_line2 ?>" class="input-text " />
                    </dd>
                    <dt><label for="city">City</label></dt>
                    <dd>
                        <input type="text" size="40" name="city" value="<?= $city ?>" class="input-text " />
                    </dd>
                    <dt><label for="district">District</label></dt>
                    <dd>
                        <input type="text" size="40" name="district" value="<?= $district ?>" class="input-text " />
                    </dd>
                    <dt><label for="state">State</label></dt>
                    <dd>
                        <input type="text" size="40" name="state" value="<?= $state ?>" class="input-text " />
                    </dd>
                    <dt><label for="country">Country</label></dt>
                    <dd>
                        <input type="text" size="40" name="country" value="<?= $country ?>" class="input-text " />
                    </dd>
                    <dt><label for="pincode"> Pin Code</label></dt>
                    <dd>
                        <input type="text" size="40" name="pincode" value="<?= $pincode ?>" class="input-text  number" />
                    </dd>


                    <dt><label for="website"> Website (if available)</label></dt>
                    <dd>
                        <input type="text" size="40" name="website" value="<?= $website ?>" class="input-text url" />
                        <small>Example: https://www.villgro.org</small>
                    </dd>



                    <dt><label for="entreprise_years">For how long have you been in operation?</label></dt>
                    <dd>
                        <label>
                            <input type="radio" name="entreprise_years"
                            <?php echo ($entreprise_years == 'Less than 1 year') ? ('checked') : (''); ?>
                                   value="Less than 1 year" /> Less than 1 year </label> <br />
                        <label><input type="radio" name="entreprise_years"
                            <?php echo ($entreprise_years == '1 year to 2 years') ? ('checked') : (''); ?>
                                      value="1 year to 2 years" /> 1 year to 2 years </label> <br />
                        <label><input type="radio" name="entreprise_years"
                            <?php echo ($entreprise_years == 'More than 2 years') ? ('checked') : (''); ?>
                                      value="More than 2 years" /> More than 2 years </label>
                    </dd>

                    <dt><label for="business_plan"> Do you have a Business Plan?</label></dt>
                    <dd>
                        <label><input type="radio" name="business_plan"
                                      <?php echo ($business_plan == 'Yes') ? ('checked') : (''); ?> value="Yes" /> Yes </label> <br />
                        <label><input type="radio" name="business_plan"
                                      <?php echo ($business_plan == 'No') ? ('checked') : (''); ?> value="No" /> No </label>
                    </dd>

                    <dt style="display:none" class="businessDocField"><label for="district">Upload Business Plan
                            Document</label></dt>
                    <dd style="display:none" class="businessDocField">
                        <input type="file" name="business_plan_document" />
                        <input type="hidden" name="pre_business_plan_document" value="<?= $business_plan_document ?>" />
                        <?php if ($business_plan_document != '') { ?> <a
                                href="<?= base_url(); ?>uploads/innovaton/supporting_documents/<?= $business_plan_document ?>"
                                class="button" target="_blank">View</a><?php } ?>
                    </dd>

                </div>


            </dl>
            <div class="clear"></div>
            <div class="buttons">
                <button type="submit" class="button" name="txtSubmit" value="Submit">Submit</button>
                <button type="button" class="button white" name="txtReset" value="Reset">Reset</button>
            </div>
        </form><?php } else { ?>
        <?php
        include("new_innovation_form.php");
    }
    ?>
</div>
<div id="eir" style="display:none;">
    <?php include("new_eir.php"); ?>
</div>

<div id="seed" style="display:none;">
    <?php include("new_seed.php"); ?>
</div>

<div id="pitch" style="display:none;">
    <?php include("new_pitch.php"); ?>
</div>

<table style="display:none">
    <tr class="cloneDocument">
        <td>
            <select name="document_type[]" id="sourceType">
                <option value="">-Select-</option>
                <?php
                foreach ($documentTypeList as $row):
                    ?>
                    <option value="<?= $row['id'] ?>"><?= $row['master_name'] ?></option>
                    <?php
                endforeach;
                ?>
            </select></td>
        <td><input type="file" name="supporting_documents[]" />
            <a href="javascript:void(0);" style="display:none" class="showYoutube button">Youtube</a>
            <div style="display:none; padding-top:5px;" class="youtubeField">
                <input type="text" name="youtube[]" class="input-text" size="40" /><br />
                Ex:<a href="http://www.youtube.com/watch?v=F7lao4eonuI" target="_blank" style="color:#666;">
                    http://www.youtube.com/watch?v=F7lao4eonuI</a>
                &nbsp;&nbsp;<a href="javascript:void(0);" class="hideYoutube">Hide</a></div>
        </td>
        <td><a href="javascript:void(0);" class="removeDocument" style="color:red; font-weight:bold;"><img
                    src="<?php echo base_url() . 'source/template/images/icons/cross.png'; ?>" /></a></td>
    </tr>
</table>

<style type="text/css">
    textarea {
        resize: none;
    }

    .txtdescription {
        width: 65% !important;
    }
</style>