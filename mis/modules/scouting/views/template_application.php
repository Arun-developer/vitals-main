<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />
	 <?php include('includes.php'); ?>    
	<title><?=$cpagetitle?></title>
</head>

<body>

<div id="main">


	<hr class="noscreen" />
	<hr class="noscreen" />
	<!-- Columns -->
	<div id="cols" class="box">
		

		<hr class="noscreen" />

		<!-- Content (Right Column) -->
		<div id="content" class="box"  style="width:70%; margin:auto;">
        <p id="logo" style="float:right; margin-top:-20px;"><a href="#"><img src="<?=base_url()?>source/images/logo.gif" alt="Our logo" title="Visit Site" /></a></p>

        <?php $this->load->view('../message'); ?>
		<?php $this->load->view($cpage); ?>
        </div>
        <!-- /content -->

	</div> <!-- /cols -->

	<hr class="noscreen" />

	<!-- Footer -->
	 <?php $this->load->view('../footer'); ?>
    <!-- /footer -->

</div> <!-- /main -->

</body>
</html>