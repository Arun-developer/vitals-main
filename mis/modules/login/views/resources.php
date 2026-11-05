<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Villgro</title>
    </head>

    <body>

        <div class="container">
            <div style="clear:both"></div>

            <div class="icon-panal">

                <div class="icon-row">
                    <div class="icon-box">
                        <div class="icon">
                            <img src="<?= base_url(); ?>source/images/contact.png" alt="innovation" /></div>
                        <div class="icon-btn"><a href="#" id="submitContact">Contacts

                            </a></div>
                    </div>

                    <div class="icon-box">
                        <div class="icon">
                            <img src="<?= base_url(); ?>source/images/Documents-management-icon1.png" alt="innovation" /></div>
                        <div class="icon-btn"><a href="#" id="dmsID">DMS

                            </a></div>
                    </div>




                    <div style="clear:both"></div>
                </div>


                <div class="icon-row">
                    <div style="clear:both"></div>
                </div>

            </div>
        </div>

    </body>
    <?php
    $url_server = explode('/', site_url(''), 2);
    $ais_url = $url_server['0'] . "//" . $this->config->item('ais_url');
    $this->config->item('ais_url');
    $hris_url = $url_server['0'] . "//" . $this->config->item('hris_url');
    $approvalUrl = $ais_url . 'login/index/';
    $travelUrl = $ais_url . 'traveladmin/requestlist';
    $timeSheet = $hris_url;
    $sessionhris_url = $url_server['0'] . "//" . $_SERVER['HTTP_HOST'] . "/ctl_vill/index.php/";

    $url_server = explode('/', site_url(''), 4);
    $dmsUser = site_url('dms/document_system/index/');
    $url = "";
    ?>
    <form name="frmApprovalSession" id="sessionContactFRM" method="post" action="<?php echo $approvalUrl; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="new_contact" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" >
            <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" >
                <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" >

                    </form>
                    <form name="frmUserDetails" id="frmUserDetails" method="post" action="<?php echo $dmsUser; ?>">
<?php
$userName = $this->session->userdata('user_name');
$password = $this->session->userdata('password');
if ($password == 'villgro' || $password == 'chief' || $password == 'sindhu') {
    $password = $password . '123';
}
?>
                        <input type="hidden" name="login" value="<?php if ($userName == "Admin") {
                            echo "admin";
                        } else {
                            echo strtolower($userName);
                        } ?>"/>
                        <input type="hidden" name="password" value="<?php echo $password; ?>"/>
                    </form>
                    <script type="text/javascript">
                        $('#submitContact').click(function () {
                            $('#sessionContactFRM').submit();
                        });
                        $('#dmsID').click(function () {
                            $('#frmUserDetails').submit();
                        });
                    </script>
                    </html>
