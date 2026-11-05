<html>
    <div>
        <ul class="tabs">
            <li><a href="<?= site_url('mainmaster/useraccess/index') ?>">Add User Access</a></li>
            <li><a href="<?= site_url('mainmaster/useraccess/essusers') ?>">Add User</a></li>
            <li><a href="<?= site_url('mainmaster/useraccess/adduser') ?>">Add User Group</a></li>
            <li><a href="<?= site_url('mainmaster/useraccess/addadmin') ?>">Add Admin</a></li>
            <li><a href="<?= site_url('mainmaster/useraccess/pim') ?>">Add Employee</a></li>
            <li><a href="<?= site_url('mainmaster/useraccess/fellow') ?>">Add Fellow</a></li>
        </ul>
    </div>
    <iframe id="myframe" src="<?php echo host_url(); ?>ctl_vill/lib/controllers/CentralController.php?reqcode=EMP&VIEW=MAIN" scrolling="yes" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0" style="width:100%; height:700px;"></iframe>
</html>
