<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Villgro</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
    </head>

    <body>

        <div class="container">
            <div style="clear:both"></div>

            <div class="icon-panal">

                <div class="icon-row">
                    <div class="icon-box">
                        <div class="icon">
                            <img src="<?= base_url(); ?>source/images/contact.png" alt="innovation" /></div>
                        <div class="icon-btn"><a href="<?= site_url('mainmaster/essusers'); ?>" id="submitMasters">Manage ESS Users

                            </a></div>
                    </div>

                    <div class="icon-box">
                        <div class="icon">
                            <img src="<?= base_url(); ?>source/images/Documents-management-icon1.png" alt="innovation" /></div>
                        <div class="icon-btn"><a href="#" id="dmsID">ESS Users

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

    $myIdea = host_url() . "mip_test/index.php";
    $url_server = explode('/', site_url(''), 4);
    $dmsUser = site_url('dms/document_system/index/');
    $url = "";
    $eventCalender = host_url() . "WebCalendar-1.2.5/login.php";
    ?>
    <form name="frmApprovalSession" id="sessionMasterFRM" method="post" action="<?php echo $approvalUrl; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="masters" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />
        <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" />

    </form>
    <form name="frmTravelSession" id="sessionHRIS" method="post" action="<?php echo $timeSheet; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="ess" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>
    <script type="text/javascript">
        $('#submitMasters').click(function () {
            $('#sessionMasterFRM').submit();
        });
        $('#dmsID').click(function () {
            $('#sessionHRIS').submit();
        });
    </script>
</html>
