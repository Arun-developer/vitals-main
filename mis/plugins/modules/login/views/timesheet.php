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
                            <img src="<?= base_url(); ?>source/images/innovation.png" alt="innovation" /></div>
                        <div class="icon-btn">
                            <?php if ($this->session->userdata('user_type') == 'admin') { ?>
                                <a href="#" id="emp_timesheet">Employee Timesheet Report</a>
                            <?php } else if ($this->session->userdata('user_type') == 'superadmin') { ?>
                                <a href="#" id="emp_timesheet1">Employee Timesheet Report</a>
                            <?php } else { ?>
                                <a href="#" id="timeSheet">My Time Sheet</a>
                            <?php } ?></div>
                    </div>


                    <?php if ($this->session->userdata('user_type') == 'admin') { ?>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/time-reports.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="timeadminSheetreport">Time Sheet Report

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/time-reports.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="areaMaster">Area Master

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/time-reports.png" alt="innovation" /></div>
                            <div class="icon-btn">
                                <a href="#" id="projectMaster">Project Master</a></div>
                        </div>
                    <?php } else if ($this->session->userdata('user_type') == 'superadmin') { ?>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/time-reports.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="timeadminSheetreport1">Time Sheet Report

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/time-reports.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="areaMaster1">Area Master

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/time-reports.png" alt="innovation" /></div>
                            <div class="icon-btn">
                                <a href="#" id="projectMaster1">Project Master</a></div>
                        </div>
                    <?php } else { ?>
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/time-reports.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="timeSheetreport">Time Sheet Report

                                </a></div>
                        </div>
                    <?php } ?>
                    <div style="clear:both"></div>
                </div>

                <div class="icon-row">
                    <?php if ($this->session->userdata('user_type') == 'admin') { ?>
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/innovation.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="serviceMaster">Service Master

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/innovation.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="taskassign">Task Assign

                                </a></div>
                        </div>
                    <?php } if ($this->session->userdata('user_type') == 'superadmin') { ?>
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/innovation.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="serviceMaster1">Service Master

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/innovation.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="taskassign1">Task Assign

                                </a></div>
                        </div>
                    <?php } ?>
                </div>

                <div style="clear:both"></div>

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
    <form name="frmTravelSession" id="sessionHRIS" method="post" action="<?php echo $timeSheet; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>
    <form name="frmTravelSession" id="sessionEmpHRIS" method="post" action="<?php echo $timeSheet; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="emp_timesheet" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmTravelSession" id="sessionEmpHRIS1" method="post" action="<?php echo $timeSheet1; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="emp_timesheet" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>



    <form name="frmTravelSession" id="sessionAdminHRISreport" method="post" action="<?php echo $timeSheet; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="time_admin_report" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmTravelSession" id="sessionAdminHRISreport1" method="post" action="<?php echo $timeSheet1; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="time_admin_report" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmTravelSession" id="sessionHRISreport" method="post" action="<?php echo $timeSheet; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="time_report" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmTravelSession" id="sessionareaMaster" method="post" action="<?php echo $timeSheet; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="area_master" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmTravelSession" id="sessionareaMaster1" method="post" action="<?php echo $timeSheet1; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="area_master" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmTravelSession" id="sessionprojectMaster" method="post" action="<?php echo $timeSheet; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="project_master" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmTravelSession" id="sessionprojectMaster1" method="post" action="<?php echo $timeSheet1; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="project_master" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmTravelSession" id="sessionserviceMaster" method="post" action="<?php echo $timeSheet; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="service_master" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmTravelSession" id="sessionserviceMaster1" method="post" action="<?php echo $timeSheet1; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="service_master" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmTravelSession" id="sessiontaskassign" method="post" action="<?php echo $timeSheet; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="task_assign" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>
    <form name="frmTravelSession" id="sessiontaskassign1" method="post" action="<?php echo $timeSheet1; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="task_assign" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>
    <script type="text/javascript">
        $('#timeSheet').click(function () {
            $('#sessionHRIS').submit();
        });
        $('#emp_timesheet').click(function () {
            $('#sessionEmpHRIS').submit();
        });
        $('#emp_timesheet1').click(function () {
            $('#sessionEmpHRIS1').submit();
        });
        $('#timeadminSheetreport').click(function () {
            $('#sessionAdminHRISreport').submit();
        });
        $('#timeadminSheetreport1').click(function () {
            $('#sessionAdminHRISreport1').submit();
        });
        $('#timeSheetreport').click(function () {
            $('#sessionHRISreport').submit();
        });
        $('#areaMaster').click(function () {
            $('#sessionareaMaster').submit();
        });
        $('#areaMaster1').click(function () {
            $('#sessionareaMaster1').submit();
        });
        $('#projectMaster').click(function () {
            $('#sessionprojectMaster').submit();
        });
        $('#projectMaster1').click(function () {
            $('#sessionprojectMaster1').submit();
        });
        $('#serviceMaster').click(function () {
            $('#sessionserviceMaster').submit();
        });
        $('#serviceMaster1').click(function () {
            $('#sessionserviceMaster1').submit();
        });
        $('#taskassign').click(function () {
            $('#sessiontaskassign').submit();
        });
        $('#taskassign1').click(function () {
            $('#sessiontaskassign1').submit();
        });
    </script>
</html>
