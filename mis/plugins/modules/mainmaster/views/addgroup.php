<html>
    <h2><?= $cpagetitle; ?></h2>
    <div>
        <ul class="tabs">
            <li><a href="<?= site_url('mainmaster/useraccess/index') ?>">Add User Access</a></li>
            <li><a href="<?= site_url('mainmaster/useraccess/addgroup') ?>">Add User Group</a></li>
            <li><a href="<?= site_url('mainmaster/useraccess/admin') ?>">Add Admin</a></li>
            <li><a href="<?= site_url('mainmaster/useraccess/addincubatee') ?>">Manage Incubatee</a></li>
        </ul>
    </div>
    <iframe id="myframe" src="<?php echo host_url(); ?>ctl_vill/lib/controllers/CentralController.php?uniqcode=USG&VIEW=MAIN" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0" style="width:850px; height:700px;"></iframe>
</html>
