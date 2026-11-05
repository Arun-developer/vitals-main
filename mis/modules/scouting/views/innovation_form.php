<br />
<h2 style="border:none"><?= $cpagetitle ?></h2>
<?php
$knowAboutUs = array('Villgro\'s Incubatee', 'Villgro\'s Employee', 'Web surf', 'e-mailers', 'Referral', 'Others');
$videoOption = '52';
?>
<script type="text/javascript">
    $(document).ready(function () {

        $('.addDocument').click(function () {
            var cloned = $('.cloneDocument').clone().removeClass('cloneDocument');
            $('.documentTable').append(cloned);
        });
        $('.removeDocument').live('click', function () {
            $(this).parents('td tr').remove();
        });

        $("[name='business_plan']").change(function () {
            businessPlan = $("[name='business_plan']:checked").val();
            if (businessPlan == 'Yes') {
                $(".businessDocField").show();
            } else {
                $(".businessDocField").hide();
            }
        });
        $("[name='document_type[]']").live('change', function () {
            if (this.value == '<?= $videoOption ?>') {
                $(this).parents('td tr').find('.showYoutube').show();
            } else {
                $(this).parents('td tr').find('.showYoutube').hide();
                $(this).parents('td tr').find('.youtubeField').hide();
            }
        });

        $(".showYoutube").live('click', function () {
            $(this).parents('td tr').find('.youtubeField').show();
        });
        $(".hideYoutube").live('click', function () {
            $(this).parents('td tr').find('.youtubeField').hide();
        });

        $('#add_info').hide();

        $('#ex_info').click(function () {
            $('#add_info').show();
        });

    });
</script>
<p>Please provide the information in the boxes below. We will review your application and get back to you as soon as
    possible. Please contact <a href="mailto:scouting@villgro.org"><strong>scouting@villgro.org</strong></a> if you have
    problem in filling the application form. </p>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>
<form name="new_innovation" action="<?= site_url('scouting/application'); ?>" enctype="multipart/form-data"
      method="post" id="new_innovation" class="uniform">
    <dl>
        <dt><label for="name_of_entrepreneur">Name of the Promoter<span class="req_field">*</span></label></dt>
        <dd><input type="text" size="40" name="name_of_entrepreneur" class="input-text required" /></dd>

        <dt><label for="mobile_no">Mobile Number<span class="req_field">*</span></label></dt>
        <dd><input type="text" size="40" name="mobile_no" class="input-text required mobile" /></dd>

        <dt><label for="email_id">Email Address<span class="req_field">*</span></label></dt>
        <dd><input type="text" size="40" name="email_id" class="input-text required email" /></dd>



        <dt><label for="phone_no">Phone Number<span class="req_field">*</span></label></dt>
        <dd><input type="text" size="40" name="phone_no" class="input-text required phone" /></dd>

        <dt><label for="name_of_enterprise">Name of the Incubatee<span class="req_field">*</span></label></dt>
        <dd><input type="text" size="40" name="name_of_enterprise" class="input-text required" /></dd>

        <dt><label for="summary">A Short Summary of your Business.<br />
                What Product / services do your offer?<span class="req_field">*</span></label></dt>
        <dd><textarea cols="40" rows="5" class="input-text required" name="summary"></textarea></dd>


        <dt style="display:none" class="businessDocField">
            <label for="business_plan_document">Upload Business Plan Document<span class="req_field">*</span></label>
        </dt>
        <dd style="display:none" class="businessDocField"><input type="file" name="business_plan_document" /></dd>

        <dt><label for="newstitle">Any other supporting document you would like to share pertaining to the
                product/service?<span class="req_field">*</span></label></dt>
        <dd></dd>

        <h2 id="ex-info">Click Here to Expand</h2>
        <div id="add_info">

            <dt><label for="address_line1">Address Line 1<span class="req_field">*</span></label></dt>
            <dd><input type="text" size="40" name="address_line1" class="input-text required" /></dd>

            <dt><label for="address_line2">Address Line 2<span class="req_field">*</span></label></dt>
            <dd><input type="text" size="40" name="address_line2" class="input-text required" /></dd>

            <dt><label for="city">City<span class="req_field">*</span></label></dt>
            <dd><input type="text" size="40" name="city" class="input-text required" /></dd>

            <dt><label for="newstitle">District<span class="req_field">*</span></label></dt>
            <dd><input type="text" size="40" name="district" class="input-text required" /></dd>

            <dt><label for="city">City<span class="req_field">*</span></label></dt>
            <dd><input type="text" size="40" name="city" class="input-text required" /></dd>

            <dt><label for="state">State<span class="req_field">*</span></label></dt>
            <dd><input type="text" size="40" name="state" class="input-text required" /></dd>

            <dt><label for="country">Country<span class="req_field">*</span></label></dt>
            <dd><input type="text" size="40" name="country" class="input-text required" /></dd>

            <dt><label for="pincode">Pin Code<span class="req_field">*</span></label></dt>
            <dd><input type="text" size="40" name="pincode" class="input-text required number" /></dd>


            <dt><label for="website">Website (if available)<span class="req_field">*</span></label></dt>
            <dd><input type="text" size="40" name="website" class="input-text" /></dd>


            <dt><label for="newstitle">For how long have you been in operation?<span class="req_field">*</span></label>
            </dt>
            <dd><label><input type="radio" name="entreprise_years" class="required" value="Less than 1 year" /> Less
                    than 1 year </label> <br />
                <label><input type="radio" name="entreprise_years" class="required" value="1 year to 2 years" /> 1 year
                    to 2 years </label> <br />
                <label><input type="radio" name="entreprise_years" class="required" value="More than 2 years" /> More
                    than 2 years </label></dd>

            <dt><label for="newstitle">Do you have a Business Plan?<span class="req_field">*</span></label></dt>
            <dd><label><input type="radio" name="business_plan" class="required" value="Yes" /> Yes </label> <br />
                <label><input type="radio" name="business_plan" class="required" value="No" /> No </label></dd>

        </div>
    </dl>


    <tr>
        <td>&nbsp;</td>
        <td><input type="submit" class="input-submit" name="txtSubmit" value="Submit" />&nbsp;&nbsp;
            <input type="reset" class="input-submit" name="txtReset" value="Reset" /></td>
    </tr>
</table>

</form>

<style type="text/css">
    .documentTable {
        background: #EEE;
        border: 2px solid #CCC;
        border-radius: 3px 3px;
        margin: 0;
    }
</style>