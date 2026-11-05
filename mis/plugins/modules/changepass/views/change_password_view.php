
<div class="forgotpass_header"><h1>&nbsp;&nbsp;Change System Password</h1><hr>

    <span id="showChange" class="showpass" >(+)</span>
    <hr style="background-color: rgb(192, 192, 192); border-bottom: 1px solid rgb(187, 187, 187); -moz-border-radius: 10px 10px 10px 10px; float: left;">
    <div id="forgotpass-panel">

        <form name="changePasswordform1" action="<?php echo site_url('changepass/change_pass/'); ?>" method="POST">

            <table style="width:422px; height: 107px; margin-top:15px;float:left;"  cellspacing="4" cellpadding="4" border="0">
                <tr>
                    <td colspan="2" style="color:#488214;"> <?php echo $success_messege; ?></td>
                </tr>
                <tr>
                    <td align="left">
                        <span id="Label1" class="lblCaptionStyle" >Old Password</span></td>
                    <td >
                        <input name="oldPassword" type="password" id="txtOldpassword" style="width: 172px" title="Enter your User ID" maxlength="22"  /><span class="fnt_red">&nbsp;&nbsp;*</span>
                    </td>
                </tr>
                <tr>
                    <td  align="left">
                        <span id="Label1" class="lblCaptionStyle" >New Password</span></td>
                    <td >
                        <input name="APP_PASSWORD" type="password" id="txtnewPassword" style="width: 172px"  title="Enter your New password" maxlength="22" /><span class="fnt_red">&nbsp;&nbsp;*</span></td>
                </tr>
                <tr>
                    <td >
                        <span id="Label1" class="lblCaptionStyle" >Confirm Password</span></td>
                    <td >
                        <input name="confirmPassword" type="password" id="txtconfirmPassword" style="width: 172px"  title="Enter your User ID" maxlength="22" /><span class="fnt_red">&nbsp;&nbsp;*</span></td>
                </tr>
                <br>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td >
                        <input type="submit" class="button" name="txtSubmit" value="Submit" onclick="return passowrdfeildValidation();">&nbsp;&nbsp;
                        <input type="reset" class="button" value="Reset">
                    </td>

                </tr>
                <tr>
                    <td colspan="2">
                        <span class="error" id="error" ><?php echo $err_msg; ?></span>
                    </td>

                </tr>
            </table>
        </form>
    </div> </div>

<span id="showmailChange" class="showpass" >(+)</span>
<hr style="background-color: rgb(192, 192, 192); border-bottom: 1px solid rgb(187, 187, 187); -moz-border-radius: 10px 10px 10px 10px; float: left;">
<div id="forgotmail-panel">
    <div class="forgotmail_header"><h1>&nbsp;&nbsp;Change Mail Password</h1> </div>	<hr>
    <form name="changePasswordform" action="<?php echo site_url('changepass/changeEmailPasswordByUID/'); ?>" method="POST">


        <table style="width:422px; height: 107px; margin-top:15px;float:left;"  cellspacing="4" cellpadding="4" border="0">
            <tr>
                <td colspan="2" style="color:#488214;"></td>
            </tr>
            <tr>
                <td align="left">
                    <span id="Label1" class="lblCaptionStyle" >Email Id</span></td>
                <td >
                    <input name="user[txtemail]" type="text" id="txtEmailID" style="width: 172px" title="Enter your User ID" maxlength="50"  /><span class="fnt_red">&nbsp;&nbsp;*</span>
                </td>
            </tr>
            <tr>
                <td  align="left">
                    <span id="Label1" class="lblCaptionStyle" >Password</span></td>
                <td >
                    <input name="user[txtPassword]" type="password" id="txtPasswordID" style="width: 172px"  title="Enter your New password" maxlength="22" /><span class="fnt_red">&nbsp;&nbsp;*</span></td>
            </tr>
            <br>

            <tr>
                <td>
                    &nbsp;
                </td>
                <td >
                    <input type="submit" class="button" name="submitEMail" value="Submit" onclick="return passowrdfeildValidation();">&nbsp;&nbsp;
                    <input type="reset" class="button" value="Reset">
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    <span class="error" id="error" ></span>
                </td>

            </tr>
        </table>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#forgotpass-panel').show();
        $('#forgotmail-panel').hide();
    });
    $("#showChange").click(function () {

        $('#forgotpass-panel').slideToggle("slow");

    });
    $("#showmailChange").click(function () {

        $('#forgotmail-panel').slideToggle("slow");

    });

    function passowrdfeildValidation() {

        var pass = document.changePasswordform1['txtnewPassword'].value;
        var con_pass = document.changePasswordform1['txtconfirmPassword'].value;


        if (document.changePasswordform1['txtOldpassword'].value == '') {

            document.getElementById('error').innerHTML = "Old password field cannot be left Blank ";
            document.changePasswordform1['txtOldpassword'].focus();
            return false;

        } else if (pass == "") {

            document.getElementById('error').innerHTML = "New password field cannot be left Blank.";
            document.changePasswordform1['txtnewPassword'].focus();
            return false;

        } else if (pass.length < 6 || pass.length > 20) {

            document.getElementById('error').innerHTML = "Passwords must be between 6 and 20 characters.";
            document.changePasswordform1['APP_PASSWORD'].focus();
            return false;

        } else if (con_pass.length < 6 || con_pass.length > 20) {

            document.getElementById('error').innerHTML = "Passwords must be between 6 and 20 characters.";
            document.changePasswordform1['confirmPassword'].focus();
            return false;

        } else if (document.changePasswordform1['txtconfirmPassword'].value == '') {

            document.getElementById('error').innerHTML = "Confirm password field cannot be left Blank.";
            document.changePasswordform1['txtconfirmPassword'].focus();
            return false;

        } else if (con_pass != pass) {

            document.getElementById('error').innerHTML = " Confirm password should match with new Password.";
            document.changePasswordform1['txtconfirmPassword'].focus();
            return false;

        } else {

            return true;

        }

    }


</script>
<style type="text/css">

    table {

        border-spacing:4px !important;
    }
    .showpass {
        color:green;
        font-size: 13px;
        font-weight:bold;
        cursor:pointer;
        margin-left:867px;
    }
    .showpass:hover {
        color:pink;
        font-weight:bold;
        font-size: 13px;
        cursor:pointer;

    }
    #error {
        color:red;
    }
    .fnt_red {

        color:red;
    }
    span.passwordIcon {  
    right: 8px !important;    
    }
</style>
