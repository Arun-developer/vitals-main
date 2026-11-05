<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Login - Management Information System - Villgro</title>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>myfavicon.ico" type="image/x-icon"></link>
        <link rel="stylesheet" href="<?= base_url(); ?>source/template/css/assets/css/styles.css" />
        <link rel="stylesheet" href="<?= base_url(); ?>source/template/css/assets/css/slide.css" type="text/css" media="screen" />

        <script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script src="<?= base_url(); ?>source/template/js/script.js"></script>
    </head>
    <body>
        <?php
        if (isset($_REQUEST['logMsg'])) {
            $errorMsg = $_REQUEST['logMsg'];
        }
        ?>
        <div id="toppanel" >
            <div id="panel">
                <div class="content clearfix">
                    <div class="left" style="color:red;">
                        <?php echo $errorMsg; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($errorMsg)) {
            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    $("div#panel").slideDown("slow");
                    $('div#panel').fadeIn(1500).delay(3500).fadeOut(1500);
                });
            </script>
        <?php }
        ?>
        <!--panel -->

        <div id="formContainer">
            <form id="login" method="post" action="<?php echo site_url('login'); ?>">

                <!--<a href="#" id="flipToRecover" class="flipLink">Forgot?</a>-->
                <?php $username = isset($_REQUEST["username"]) ? $_REQUEST["username"] : ""; ?>
                <input type="text" name="username"   onblur="if (this.value == '')
                            this.value = 'Enter your Username';" onfocus="this.value = ''"id="loginEmail" value="Enter your Username" />
                <div class="error" id="userID" style="position: absolute; width: 55%; left: 264px; top: 221px;">
                    <div class="errorEl">Field is required !!</div>

                </div>

                <?php $password = isset($_REQUEST["password"]) ? $_REQUEST["password"] : ""; ?>
                <input type="password" name="password"  onblur="if (this.value == '')
                            this.value = 'Password';" onfocus="this.value = ''"  id="loginPass" value="Password" />
                <div class="error" id="passID" style="position: absolute; width: 55%; top: 180px; left: 265px;">
                    <div class="errorEl">Field is required !!</div>

                </div>

                <input type="submit" name="txtSubmit" class="button" value="Login >>" id="isSubmitted" />

            </form>
            <form id="recover" method="post" action="<?= site_url('login/incubatee'); ?>">
                <a href="#" id="flipToLogin" class="flipLink">Forgot?</a>

                <?php $usernameIncubatee = isset($_REQUEST["incubateeUsername"]) ? $_REQUEST["incubateeUsername"] : ""; ?>
                <input name="incubateeUsername" id="recoverEmail" placeholder="Enter your Username" type="text" value="<?= $usernameIncubatee ?>" />
                <div class="error" id="usermailID" style="position: absolute; width: 55%; left: 264px; top: 221px;">
                    <div class="errorEl">Field is required !!</div>

                </div>
                <?php $passwordIncubatee = isset($_REQUEST["incubateePassword"]) ? $_REQUEST["incubateePassword"] : ""; ?>
                <input type="password" name="incubateePassword" placeholder="Enter your Password" id="loginPassword" value="<?= $passwordIncubatee ?>" />
                <div class="error" id="passwordID" style="position: absolute; width: 55%; top: 180px; left: 265px;">
                    <div class="errorEl">Field is required !!</div>

                </div>


                <input type="submit" name="txtIncubateeSubmit" class="button" value="Login >>"/>
            </form>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#userID").hide();
                $("#passID").hide();
                $("#usermailID").hide();
                $("#passwordID").hide();
                $("#login").submit(function () {
                    var loginID = $("#loginEmail").val();
                    var passID = $("#loginPass").val();
                    (loginID == "") ? $("#userID").show() : $("#userID").hide();
                    (passID == "") ? $("#passID").show() : $("#passID").hide();
                    if (loginID != "" && passID != "") {
                        $("#login").submit();
                    } else {

                        return false;
                    }
                });

                $("#recover").submit(function () {
                    var incubateeloginID = $("#recoverEmail").val();
                    var incubateepassID = $("#loginPassword").val();
                    (incubateeloginID == "") ? $("#usermailID").show() : $("#usermailID").hide();
                    (incubateepassID == "") ? $("#passwordID").show() : $("#passwordID").hide();
                    if (incubateeloginID != "" && incubateepassID != "") {
                        $("#recover").submit();
                    } else {

                        return false;
                    }
                });

                function addElement(el, msg, errEl) {
                    if (el) {
                        var errorEl = el.next('.error'), errEl = errEl ? errEl : 'div';
                        if (msg) {
                            if (!errorEl.attr('class')) {
                                var offset = el.offset();
                                el.after($('<' + errEl + ' class="error"><' + errEl + ' class="errorEl">' + msg + '</' + errEl + '></' + errEl + '>').css({'position': 'absolute', 'width': '100%', 'left': el.width(), 'top': el.width()}));
                            } else
                                errorEl.find(errEl + '.errorEl').html(msg).end().show();
                            return false;
                        } else {
                            errorEl.hide();
                            return true;
                        }
                    }
                    return false;
                }

                $.ajax({
                    type: "POST",
                    url: "<?php echo host_url(); ?>vital_ais/index.php/login/logout"
                });

                $.ajax({
                    type: "POST",
                    url: "<?php echo host_url(); ?>ctl_vill/unset_session.php"
                });
            });


        </script>

        <style type="text/css">

            .error{background: transparent url('../source/template/images/msg_arrow.gif') no-repeat scroll left center;padding-left: 7px;font-size: 14px;}
            .errorEl{background-color:#F3E6E6;border-color: #924949;border-style: solid solid solid none;border-width: 2px;padding: 2px 5px; box-shadow: 0 0 10px #888;}

        </style>
    </body>
</html>



