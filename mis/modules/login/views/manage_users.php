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

                <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>

                    <div class="icon-box">
                        <div class="icon">
                            <img src="<?= base_url(); ?>source/images/contact.png" alt="innovation" /></div>
                        <div class="icon-btn"><a href="#" id="submitMasters1">MIS Users

                            </a></div>
                    </div>
                <?php } else { ?>
                    <div class="icon-box">
                        <div class="icon">
                            <img src="<?= base_url(); ?>source/images/contact.png" alt="innovation" /></div>
                        <div class="icon-btn"><a href="#" id="submitMasters">MIS Users

                            </a></div>
                    </div>

                <?php } ?>

                <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
                    <div class="icon-box">
                        <div class="icon">
                            <img src="<?= base_url(); ?>source/images/Documents-management-icon1.png" alt="innovation" /></div>
                        <div class="icon-btn"><a href="#" id="dmsID1">Employee Master

                            </a></div>
                    </div>
                <?php } else { ?>
                    <div class="icon-box">
                        <div class="icon">
                            <img src="<?= base_url(); ?>source/images/Documents-management-icon1.png" alt="innovation" /></div>
                        <div class="icon-btn"><a href="#" id="dmsID">Employee Master

                            </a></div>
                    </div> <?php } ?>

                <div class="icon-box">
                    <div class="icon">
                        <img src="<?= base_url(); ?>source/images/Documents-management-icon1.png" alt="innovation" /></div>
                    <div class="icon-btn"><a href="#"  id="job">Job

                        </a></div>
                </div>


                <div class="icon-box">
                    <div class="icon">
                        <img src="<?= base_url(); ?>source/images/Documents-management-icon1.png" alt="innovation" /></div>
                    <div class="icon-btn"><a href="#"  id="loc">Job Location

                        </a></div>
                </div>

                <div style="clear:both"></div>



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
    $hris_url1 = $url_server['0'] . "//" . $this->config->item('hris_url1');
    $approvalUrl = $ais_url . 'login/index/';
    $travelUrl = $ais_url . 'traveladmin/requestlist';
    $timeSheet = $hris_url;
    $timeSheet1 = $hris_url1;
    $sessionhris_url = $url_server['0'] . "//" . $_SERVER['HTTP_HOST'] . "/ctl_vill/index.php/";

    $url_server = explode('/', site_url(''), 4);
    $dmsUser = site_url('dms/document_system/index/');
    $url = "";
    ?>
    <form name="frmApprovalSession1" id="sessionMasterFRM1" method="post" action="<?php echo $timeSheet1; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="manageusers" name="seesion[requests]"/>
        <input type="hidden" value="1" name="seesion[manageuser]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>
    <form name="frmTravelSession1" id="sessionHRIS1" method="post" action="<?php echo $timeSheet1; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="ess" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>
    <form name="frmApprovalSession" id="sessionMasterFRM" method="post" action="<?php echo $timeSheet; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="masters" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

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
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>
    <form name="frmTravelSession" id="sessionHRISjob" method="post" action="<?php echo $timeSheet; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="job" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>
    <form name="frmTravelSession" id="sessionHRISloc" method="post" action="<?php echo $timeSheet; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="loc" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
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
        $('#job').click(function () {
            $('#sessionHRISjob').submit();
        });
        $('#loc').click(function () {
            $('#sessionHRISloc').submit();
        });
        $('#submitMasters1').click(function () {
            $('#sessionMasterFRM1').submit();
        });
        $('#dmsID1').click(function () {
            $('#sessionHRIS1').submit();
        });
    </script>
</html>
