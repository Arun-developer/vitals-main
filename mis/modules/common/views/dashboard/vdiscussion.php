<html>
<?php
$username = $this->session->userdata("user_name");
$empmail = $this->session->userdata("emp_mail");
$adminmail = $this->session->userdata("admin_mail");
?>

<iframe id="myframe" class="scrolling" src="<?php echo base_url() . 'index.php/discussion/'; ?>?username=<?php echo $username; ?>&empmail=<?php echo $empmail; ?>&adminmail=<?php echo $adminmail; ?>"  marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0" style="width:900px;min-height:870px;height:auto; overflow:auto;"></iframe>

<link type="text/css" href="scrollpane/style/jquery.jscrollpane.css" rel="stylesheet" media="all" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<script type="text/javascript" src="scrollpane/script/jquery.mousewheel.js"></script>

<script type="text/javascript" src="scrollpane/script/jquery.jscrollpane.js"></script>

<script type="text/javascript">
    $(function()
    {
        $('.scrolling').jScrollPane();
    });
    </script>
</html>