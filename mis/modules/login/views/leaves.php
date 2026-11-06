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
                <?php if ($this->session->userdata('user_type') == 'admin') { ?>
                    <div class="icon-row">
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/innovation.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitLeavesummaryadmin">Leave Allocation

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/Time-Sheet.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitLeavelistadmin">Leave List

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/Time-Sheet.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitDaysOff">Define Days Off

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/Time-Sheet.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitHolidays">Holiday Listing

                                </a></div>
                        </div>
                    </div>
                <?php } else if ($this->session->userdata('user_type') == 'superadmin') { //echo "ff";die();?>
                    <div class="icon-row">
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/innovation.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitLeavesummaryadmin1">Leave Allocation

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/Time-Sheet.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitLeavelistadmin1">Leave List

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/Time-Sheet.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitDaysOff1">Define Days Off

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/Time-Sheet.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitHolidays1">Holiday Listing

                                </a></div>
                        </div>
                    </div>
                <?php } ?>
                <div class="icon-row">
                    <?php if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') { ?>


                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/innovation.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitLeavesummary">Leave Allocation

                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/Time-Sheet.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitLeavelist">Leave List
                                    <?php
                                    if (php72_cmp($emp_leave_count) != 0)
                                        echo '(' . $emp_leave_count . ')';
                                    ?>
                                </a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitLeaveapprove2">Approve Leave
                                    <?php
                                    if (php72_cmp($sub_leave_count) != 0)
                                        echo '(' . $sub_leave_count . ')';
                                    ?></a></div>
                        </div>
<?php }
else if ($this->session->userdata('user_type') == 'admin') {
    ?>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitspecificHolidays">Specific Holidays</a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitleavetypeSummary">Leave Type Summary</a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitWorkingdays">Working Days List</a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitLeaveapprove">Approve Leave
                        <?php
                        if (php72_cmp($sub_leave_count) != 0)
                            echo '(' . $sub_leave_count . ')';
                        ?></a></div>
                        </div>
<?php } else if ($this->session->userdata('user_type') == 'superadmin') { ?>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitspecificHolidays1">Specific Holidays</a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitleavetypeSummary1">Leave Type Summary</a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitWorkingdays1">Working Days List</a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitLeaveapprove1">Approve Leave</a></div>
                        </div>
<?php } ?>


                </div>
                <div style="clear:both"></div>
            </div>


            <div class="icon-row">
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
    $timeSheet2 = $hris_url;
    $sessionhris_url = $url_server['0'] . "//" . $_SERVER['HTTP_HOST'] . "/ctl_vill/index.php/";

    $url_server = explode('/', site_url(''), 4);
    $dmsUser = site_url('dms/document_system/index/');
    $url = "";
    ?>
    <form name="frmApprovalSession" id="sessionLeavesummary" method="post" action="<?php echo $timeSheet; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="leave_summary" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>


    <form name="frmApprovalSession" id="sessionLeavesummaryadmin" method="post" action="<?php echo $timeSheet; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="leave_summary_admin" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionLeavesummaryadmin1" method="post" action="<?php echo $timeSheet1; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="leave_summary_admin" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionLeavetypesummary" method="post" action="<?php echo $timeSheet; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="leave_type_summary" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionLeavetypesummary1" method="post" action="<?php echo $timeSheet1; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="leave_type_summary" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionDaysOff" method="post" action="<?php echo $timeSheet; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="define_days_off" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionDaysOff1" method="post" action="<?php echo $timeSheet1; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="define_days_off" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionHolidays" method="post" action="<?php echo $timeSheet; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="define_holidays" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionHolidays1" method="post" action="<?php echo $timeSheet1; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="define_holidays" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionspecificHolidays" method="post" action="<?php echo $timeSheet; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="define_specific_holidays" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionspecificHolidays1" method="post" action="<?php echo $timeSheet1; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="define_specific_holidays" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionWorkingdays" method="post" action="<?php echo $timeSheet; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="define_working_days" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionWorkingdays1" method="post" action="<?php echo $timeSheet1; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="define_working_days" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionLeavelist" method="post" action="<?php echo $timeSheet; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="leave_list" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionLeaveapply" method="post" action="<?php echo $timeSheet; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="leave_apply" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionLeaveHRIS" method="post" action="<?php echo $timeSheet; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="leave_list_admin" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />
    </form>

    <form name="frmApprovalSession" id="sessionLeaveHRIS1" method="post" action="<?php echo $timeSheet1; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="leave_list_admin" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />
    </form>
    <form name="frmApprovalSession" id="sessionLeaveApprovalFRM" method="post" action="<?php echo $timeSheet; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="leave_pending_approve" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>
    <form name="frmApprovalSession" id="sessionLeaveApprovalFRM2" method="post" action="<?php echo $timeSheet2; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="leave_pending_approve" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>

    <form name="frmApprovalSession" id="sessionLeaveApprovalFRM1" method="post" action="<?php echo $timeSheet1; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="leave_pending_approve" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>
    <script type="text/javascript">
        $('#submitSession').click(function () {
            $('#sessionFRM').submit();
        });
        $('.submitLeavesummary').click(function () {
            $('#sessionLeavesummary').submit();
        });
        $('.submitLeavesummaryadmin').click(function () {
            $('#sessionLeavesummaryadmin').submit();
        });

        $('.submitLeavesummaryadmin1').click(function () {
            $('#sessionLeavesummaryadmin1').submit();
        });
        $('.submitleavetypeSummary').click(function () {
            $('#sessionLeavetypesummary').submit();
        });
        $('.submitleavetypeSummary1').click(function () {
            $('#sessionLeavetypesummary1').submit();
        });
        $('.submitDaysOff').click(function () {
            $('#sessionDaysOff').submit();
        });
        $('.submitDaysOff1').click(function () {
            $('#sessionDaysOff1').submit();
        });
        $('.submitHolidays').click(function () {
            $('#sessionHolidays').submit();
        });
        $('.submitHolidays1').click(function () {
            $('#sessionHolidays1').submit();
        });
        $('.submitspecificHolidays').click(function () {
            $('#sessionspecificHolidays').submit();
        });
        $('.submitspecificHolidays1').click(function () {
            $('#sessionspecificHolidays1').submit();
        });
        $('.submitWorkingdays').click(function () {
            $('#sessionWorkingdays').submit();
        });
        $('.submitWorkingdays1').click(function () {
            $('#sessionWorkingdays1').submit();
        });
        $('.submitLeavelist').click(function () {
            $('#sessionLeavelist').submit();
        });
        $('.submitLeaveapply').click(function () {

            $('#sessionLeaveapply').submit();
        });
        $('.submitLeaveapprove').click(function () {
            $('#sessionLeaveApprovalFRM').submit();
        });

        $('.submitLeaveapprove1').click(function () {
            $('#sessionLeaveApprovalFRM1').submit();
        });
        $('.submitLeaveapprove2').click(function () {
            $('#sessionLeaveApprovalFRM2').submit();
        });
        $('.submitPendigTravelApproval').click(function () {
            $('#sessionTravelApprovalFRM').submit();
        });
        $('#timeSheet').click(function () {
            $('#sessionHRIS').submit();
        });
        $('.submitLeavelistadmin').click(function () {
            $('#sessionLeaveHRIS').submit();
        });

        $('.submitLeavelistadmin1').click(function () {
            $('#sessionLeaveHRIS1').submit();
        });
        $('#dmsID').click(function () {
            $('#frmUserDetails').submit();
        });

        $('#submitAISDashboard').click(function () {
            $('#sessionAISFRM').submit();
        });

        $('#submitMyIdea').click(function () {
            $('#sessionMyIdeaProgram').submit();
        });
        $('#eventCalender').click(function () {
            $('#sessionEventCalender').submit();
        });
    </script>

</html>

