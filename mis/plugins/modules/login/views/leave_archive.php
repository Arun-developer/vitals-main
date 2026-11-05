<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

        <title>Leave Archive</title>
        <script type="text/javascript" src="<?php echo base_url(); ?>source/template/js/jquery.js"></script>

    </head>

    <body>
        <iframe src="<?php echo host_url(); ?>ctl_vill/villcode/index.php/home/get_leave_archive/<?= $year; ?>/<?= $empid ?>" scrolling="auto" height="600px" width="800px"></iframe>
    </body>
</html>
