<html>
    <ul class="breadcrumb">
        <?php if ($this->uri->segment('1') == 'mainmaster' && $this->uri->segment('3') == 'essuserssuperadmin') {
            ?>
            <li><a href="<?= site_url('login/icon_menu'); ?>"><font color="#000000"><b>Home</b></font></a></li>
            <li><a href="<?= site_url('login/master'); ?>"><font color="#000000"><b>Masters</b></font></a></li>
            <li><a href="#"><font color="#000000"><b>Manage Users</b></font></a></li>
        <?php } ?>
    </ul>
    <iframe id="myframe" src="<?php echo host_url(); ?>ctl_vill/lib/controllers/CentralController.php?uniqcode=USR&VIEW=SAMAIN&isSuperAdmin=No" scrolling="yes" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0" style="width:100%; height:700px;"></iframe>
</html>
<style type="text/css">
    #essuserssuperadmin {
        width: 75%;
        margin: 0 auto;
    }
</style>
