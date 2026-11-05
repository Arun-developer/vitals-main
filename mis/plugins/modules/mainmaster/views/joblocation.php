<html>
    <div class="villgro-breadcrumb clearfix" style="padding: 10px 10px;">
        <div class="row">
            <div class="col-md-12 col-12">
                <ul>
                    <?php if ($this->uri->segment('1') == 'mainmaster' && $this->uri->segment('3') == 'joblocation') {
                        ?>
                        <li><a href="<?= site_url('login/icon_menu'); ?>">Home <i class="fa fa-angle-double-right"></i></a></li>
                        <li><a href="<?= site_url('login/master'); ?>">Masters <i class="fa fa-angle-double-right"></i></a></li>
                        <li><a href="<?= site_url('login/manage_users'); ?>">Manage Users <i class="fa fa-angle-double-right"></i></a></li>
                        <li><a href="#" class="active">Job Location </a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <iframe id="myframe" src="<?php echo host_url(); ?>ctl_vill/lib/controllers/CentralController.php?uniqcode=LOC&VIEW=MAIN&isAdmin=No" scrolling="yes" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0" style="width:100%; height:700px;"></iframe>
</html>
