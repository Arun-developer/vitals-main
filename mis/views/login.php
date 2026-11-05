<!DOCTYPE HTML>

<html lang="en">

    <head>

        <title>Login - Management Information System - Villgro</title>

        <meta charset="utf-8">

        <link rel="shortcut icon" href="<?php echo base_url(); ?>myfavicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="css/style.css">

        <script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>

        <script type="text/javascript" src="js/cufon-yui.js"></script>

        <script type="text/javascript" src="js/Delicious_500.font.js"></script>

    </head>

    <body>


        <header id="top">

            <div class="container_12 clearfix">

                <div id="logo" class="grid_12">

                    <!-- replace with your website title or logo -->

                    <a id="site-title" href="dashboard.html"><img src="images/logo.gif" title="Villgro"></a>

                </div>

            </div>

        </header>

        <div id="login" class="boxed">

            <h2>Login</h2>

            <section>

                <div class="error msg">Message if login failed</div>

                <form action="http://jogjadesign.net/demo/adminique/dashboard.html">

                    <dl>

                        <dt><label for="username">Username</label></dt>

                        <dd><input id="username" type="text" /></dd>



                        <dt><label for="adminpassword">Password</label></dt>

                        <dd><input id="adminpassword" type="password" /></dd>

                    </dl>

                    <p>

                        <button type="submit" class="button green" id="loginbtn">LOGIN</button>

                        <button type="reset" class="button white" id="resetbtn">RESET</button>

                    </p>

                </form>

            </section>

        </div>



    </body>

</html>