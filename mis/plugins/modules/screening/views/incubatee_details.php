<h1>&nbsp;&nbsp;Incubatee Details</h1>
<div id="inline">

    <form name="changePasswordform" action="<?php echo site_url('screening/incubateeform/'.$innovation);?>"
        method="POST">
        <input type="hidden" value="<?php echo $innovation; ?>" name="innovationID" />
        <table style="width:422px; height: 107px; margin-top:15px;float:left;" cellspacing="4" cellpadding="4"
            border="0">
            <tr>
                <td colspan="2" style="color:#488214;"></td>
            </tr>
            <tr>
                <td align="left">
                    <span id="Label1" class="lblCaptionStyle">User Name</span></td>
                <td>
                    <input name="username" type="text" id="txtUserName" style="width: 172px" title="Enter Your UserName"
                        maxlength="22" /><span class="fnt_red">&nbsp;&nbsp;*</span>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span id="Label1" class="lblCaptionStyle">Password</span></td>
                <td>
                    <input name="userPassword" type="password" id="txtPassword" style="width: 172px"
                        title="Enter Your Password" maxlength="22" /><span class="fnt_red">&nbsp;&nbsp;*</span></td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" class="button" name="txtSubmit" value="Submit">&nbsp;&nbsp;
                    <input type="reset" class="button" value="Reset">
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    <span class="error" id="error"></span>
                </td>

            </tr>
        </table>
    </form>
</div>
<style type="text/css">
.fnt_red {
    color: red;
}
</style>