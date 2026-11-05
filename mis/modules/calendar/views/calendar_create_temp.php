<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$header;?></title>
<base href="<?=base_url();?>" />
<script type="text/javascript" src="<?=base_url();?>source/template/js/jquery.js"></script>

<link rel="stylesheet" href="<?= base_url();?>source/datepick/jquery.datepick.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="<?= base_url();?>source/jquery_ui/css/south-street/style.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="<?= base_url();?>source/datepick/jquery.datepick.pack.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//configure the date format to match mysql date
	$('.datepicker').datepick({dateFormat: 'yy-mm-dd'});
});
</script>
</head>

<body>
  <div id="container">
<div id="navcontainer">
<ul>
        <li class="eventDetails"><?php echo anchor('calendar/index/', 'Show Events');?></li>
</ul>
</div>
      <br></br>
<div id="header">
<?php $this->load->view($main);?>
  </div>
</div>
<style type="text/css">
  .eventDetails {
        color:#669933 !important;
        cursor: pointer;
        text-decoration:none;
        border: 1px solid rgb(0, 204, 102);
        padding: 10px 10px 10px 10px;
        color:rgb(0, 0, 0);
        font-size:14px;
        font-family:arial, serif;
        text-shadow: 0px 0px 5px rgb(0, 102, 153);
        font-size: 14px;
        border-radius:5px 5px 5px 5px;
        -moz-border-radius:5px 5px 5px 5px;
        -webkit-border-radius:5px 5px 5px 5px !important;
        box-shadow:0px 0px 0px rgb(0, 0, 0) !important;
        -moz-box-shadow:0px 0px 0px rgb(0, 0, 0) !important;
        -webkit-box-shadow:0px 0px 0px rgb(0, 0, 0) !important;
        background-color: rgb(255, 255, 255) !important;
        background-image:linear-gradient(-90deg, rgb(238, 238, 238), rgb(51, 153, 102)) !important;
        background-image:-webkit-gradient(linear, 50% 0%, 50% 100%, from(rgb(238, 238, 238)), to(rgb(51, 153, 102))) !important;
        background-image:-moz-linear-gradient(-90deg, rgb(238, 238, 238), rgb(51, 153, 102)) !important;
    }


      .eventDetails :hover {

        color:#8B1A1A !important;
        border: 1px solid rgb(0, 204, 102);
        border-radius:5px 5px 5px 5px;
        -webkit-transform: scale(0.9);     
        -moz-transform: scale(0.9);        
        -o-transform: scale(0.9);         
        opacity: 0.5;
        filter: alpha(opacity=50);
        cursor: pointer;
        text-decoration:none;
        border: 2px solid rgb(0, 204, 102);
        padding: 10px 10px 10px 10px;
        font-size:14px;
        font-family:arial, serif;
        text-shadow: 0px 0px 5px rgb(0, 102, 153);
        font-size: 14px;
        -moz-border-radius:5px 5px 5px 5px;
        -webkit-border-radius:5px 5px 5px 5px;
        box-shadow:0px 0px 0px rgb(0, 0, 0) !important;
        -moz-box-shadow:0px 0px 0px rgb(0, 0, 0) !important;
        -webkit-box-shadow:0px 0px 0px rgb(0, 0, 0) !important;
        background-color: rgb(255, 255, 255) !important;

  
 }
 
 .eventDetails:active {
     
     cursor: pointer;
	text-decoration:none;
	border: 2px solid rgb(0, 204, 102);
	padding: 10px 10px 10px 10px;
	color:rgb(0, 0, 0);
	font-size:14px;
	font-family:arial, serif;
	text-shadow: 0px 0px 5px rgb(0, 102, 153);
	font-size: 14px;
	border-radius:5px 5px 5px 5px;
	-moz-border-radius:5px 5px 5px 5px;
	-webkit-border-radius:5px 5px 5px 5px;
	box-shadow:0px 0px 0px rgb(0, 0, 0);
	-moz-box-shadow:0px 0px 0px rgb(0, 0, 0);
	-webkit-box-shadow:0px 0px 0px rgb(0, 0, 0);
	background-color: rgb(255, 255, 255);
	background-image:linear-gradient(-90deg, rgb(238, 238, 238), rgb(0, 102, 102));
	background-image:-webkit-gradient(linear, 50% 0%, 50% 100%, from(rgb(238, 238, 238)), to(rgb(0, 102, 102)));
	background-image:-moz-linear-gradient(-90deg, rgb(238, 238, 238), rgb(0, 102, 102));
 }

    </style>
</body>
</html>