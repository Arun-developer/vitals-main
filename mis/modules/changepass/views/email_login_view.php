<html>
<body>
<form id="gaia_loginform" method="post" action="https://accounts.google.com/ServiceLoginAuth">
<input id="continue" type="hidden" value="https://mail.google.com/mail/" name="continue">
<input id="service" type="hidden" value="mail" name="service">
<input id="rm" type="hidden" value="false" name="rm">
<input id="dsh" type="hidden" value="3211113654759946394" name="dsh">
<input id="ltmpl" type="hidden" value="default" name="ltmpl">
<input id="hl" type="hidden" value="en" name="hl">
<input id="ltmpl" type="hidden" value="default" name="ltmpl">
<input id="scc" type="hidden" value="1" name="scc">
<input id="ss" type="hidden" value="1" name="ss">
<input type="hidden" value="z95T682k-1o" name="GALX">
<input id="pstMsg" type="hidden" value="1" name="pstMsg">
<input id="dnConn" type="hidden" value="https://accounts.youtube.com" name="dnConn">
<input id="checkConnection" type="hidden" value="" name="checkConnection">
<input id="checkedDomains" type="hidden" value="" name="checkedDomains">
<input id="timeStmp" type="hidden" value="" name="timeStmp">
<input id="secTok" type="hidden" value="" name="secTok">

<label>
<strong class="email-label">Username</strong>
<input id="Email" type="text" name="Email" spellcheck="false" value="<?php echo $login; ?>">
</label>
<label>
<strong class="passwd-label">Password</strong>
<input id="Passwd" type="password" name="Passwd" value="<?php echo $password; ?>">
</label>
<br>
<input id="signIn" class="g-button g-button-submit" type="submit" value="Sign in" name="signIn">
<?php  
echo $login;
echo $password;

?>

</form>
</body>
</html>