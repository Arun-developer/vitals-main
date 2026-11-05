<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?=base_url();?>" />
<link rel="stylesheet" href="<?= base_url();?>source/jquery_ui/css/south-street/master.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="<?= base_url();?>source/jquery_ui/css/south-street/style.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<script src="<?= base_url();?>source/jquery_ui/js/coda.js" type="text/javascript"> </script>

</head>
<body>

<div id="header" style="width:100%">
<?php $this->load->view($main); ?>
</div>

    <style type="text/css" >


    .eventDetails {
        color:#A9CF55 !important;
        cursor: pointer;
        text-decoration:none;
        border-radius:5px 5px 5px 5px;
        padding: 10px 10px 10px 10px;
        color:rgb(0, 0, 0);
        font-size:14px;
        font-family:arial, serif;
        text-shadow: 0px 0px 5px rgb(0, 102, 153);
        font-size: 14px;
    }

    .eventDetails :hover {
        color:#000 !important;
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
    }

    .eventDetails:active {
        cursor: pointer;
        text-decoration:none;
        border: 2px solid rgb(0, 204, 102);
        padding: 10px 10px 10px 10px;
        font-size:14px;
        font-family:arial, serif;
        text-shadow: 0px 0px 5px rgb(0, 102, 153);
        font-size: 14px;
    }


    </style>
</body>
</html>



