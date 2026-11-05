<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Login - Management Information System - Villgro</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/style.css">
<script type="text/javascript" src="<?=base_url();?>source/template/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>source/template/js/cufon-yui.js"></script>
<script type="text/javascript" src="<?=base_url();?>source/template/js/Delicious_500.font.js"></script>
</head>
<body>

<header id="top">
	<div class="container_12 clearfix">
		<div id="logo" class="grid_12">
			<a id="site-title" href="dashboard.html"><img src="<?=base_url();?>source/template/images/logo.gif" title="Villgro"></a>
		</div>
	</div>
</header>

<div id="login" class="boxed">
	<h2>Login For Incuabtee</h2>
	<section>
	<?php $this->load->view('../message'); ?>
		<form action="<?=site_url('login/incubatee');?>" method="post">
			<dl>
				<dt><label for="username">Username</label></dt>
				<dd>
                <?php $username = isset($_REQUEST["username"])?$_REQUEST["username"]:""; ?>
                <input id="username" name="username" type="text" value="<?=$username?>" /></dd>
			
				<dt><label for="adminpassword">Password</label></dt>
				<dd>
                <?php $password = isset($_REQUEST["password"])?$_REQUEST["password"]:"";?>
                <input id="adminpassword" name="password" type="password" value="<?=$password?>" /></dd>
			</dl>
			<p>
				<button type="submit" class="button green" name="txtSubmit" id="loginbtn" value="LOGIN">LOGIN</button>
                <button type="reset" class="button white" id="resetbtn">RESET</button>
			</p>
		</form>
	</section>
</div>

</body>
</html>