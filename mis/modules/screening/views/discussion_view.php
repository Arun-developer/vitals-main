<?php
$username = $this->session->userdata("user_name");
$empmail = $this->session->userdata("emp_mail");
$adminmail = $this->session->userdata("admin_mail");
?>

<iframe id="myframe"
    src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . '/screening_discussion/'; ?>?id=<?php echo $this->uri->segment('3') ?>&?username=<?php echo $username; ?>&empmail=<?php echo $empmail; ?>&adminmail=<?php echo $adminmail; ?>"
    scrolling="yes" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0"
    style="width:1270px;min-height:870px;height:auto; overflow:hidden;scrolling:no;"></iframe>

<script type="text/javascript">
$(function() {
    document.getElementById('myframe').style.overflow = 'hidden';
});
</script>