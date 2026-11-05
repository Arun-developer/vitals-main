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
                <?php if ($this->session->userdata('partner_id') == '1') { ?>
                    <div class="icon-row">
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/dealflow.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="<?= site_url('dashboard/dashboard'); ?>">Deal Flow

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/incubation.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="<?= site_url('common/dashboard/admin_dashboard'); ?>">Incubation

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/admin.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="request-dashboard">Admin</a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/hr.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="<?= site_url('dashboard/hrisdashboard/index'); ?>">HR</a></div>
                            <div style="clear:both"></div>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                <?php } ?>

                <div class="icon-row">

                    <?php if ($this->session->userdata('partner_id') == '1') { ?>
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/archive.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="<?= site_url('scouting/old_innovation'); ?>">Archives

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/archive.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="<?= site_url('common/report/new_report'); ?>">Innovation Report

                                </a></div>
                        </div>

                    <?php } ?>

                    <div class="icon-box">
                        <div class="icon">
                            <img src="<?= base_url(); ?>source/images/admin.png" alt="innovation" /></div>
                        <div class="icon-btn"><a href="#" id="report-dashboard">Approval Note Unutilized Report</a></div>
                    </div>

                    <?php if ($isFinance == 'Yes' || $isAdmin == 'Yes' || $this->session->userdata('role_id') == '3') { ?>
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/reports.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="an_in_report">AN/IN Report</a></div>
                        </div>
<?php } ?>
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
    <form name="frmApprovalSession" id="sessionApprovalFRM" method="post" action="<?php echo $approvalUrl; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="approve_dashboard" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" >
            <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" >
                <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" >

                    </form>

                    <form name="frmApprovalSession" id="sessionApprovalnoteFRM" method="post" action="<?php echo $approvalUrl; ?>">
                        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
                        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
                        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
                        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
                        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
                        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
                        <input type="hidden" value="approve_amount_report" name="seesion[requests]"/>
                        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" >
                            <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" >
                                <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" >

                                    </form>

                                    <form name="frmApprovalSession" id="sessionApprovalreportFRM" method="post" action="<?php echo $approvalUrl; ?>">
                                        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
                                        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
                                        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
                                        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
                                        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
                                        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
                                        <input type="hidden" value="an_in_report" name="seesion[requests]"/>
                                        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" >
                                            <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" >
                                                <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" >

                                                    </form>
                                                    <script type="text/javascript">
                                                        $('#request-dashboard').click(function () {
                                                            $('#sessionApprovalFRM').submit();
                                                        });

                                                        $('#report-dashboard').click(function () {
                                                            $('#sessionApprovalnoteFRM').submit();
                                                        });

                                                        $('#an_in_report').click(function () {
                                                            $('#sessionApprovalreportFRM').submit();
                                                        });
                                                    </script>
                                                    </html>

