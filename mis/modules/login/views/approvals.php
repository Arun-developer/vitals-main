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
                            <img src="<?= base_url(); ?>source/images/budget.png" alt="innovation" /></div>
                        <div class="icon-btn"><a href="#" class="submitPendigApproval">Approval Note <?php if ($approvalNotes) echo "(" . $approvalNotes . ")"; ?>

                            </a></div>
                    </div>

                    <div class="icon-box">
                        <div class="icon">
                            <img src="<?= base_url(); ?>source/images/internalnote.png" alt="innovation" /></div>
                        <div class="icon-btn"><a href="#" class="submitPendingInternalApproval">Internal Note <?php if ($internalNotes) echo "(" . $internalNotes . ")"; ?>

                            </a></div>
                    </div>
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                            <!-- <div class="icon-btn"><a href="<?= site_url('login/leaves'); ?>">Leave <?php if ($leave_count) echo "(" . $leave_count . ")"; ?></a></div> -->
                            <div class="icon-btn"><a href="<?php echo base_url() . 'index.php/leave/leave_list'; ?>">Leave <?php if ($leave_count) echo "(" . $leave_count . ")"; ?></a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/2.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitPendigBookApproval">Book <?php if ($library_count) echo "(" . $library_count . ")"; ?></a></div>
                            <div style="clear:both"></div>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                <?php if ($this->session->userdata('partner_id') == '1') { ?>
                    <div class="icon-row">
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/travel.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" class="submitPendigTravelApproval">Travel & Accomodation <?php if ($travel_count) echo "(" . $travel_count . ")"; ?>

                                </a></div>
                        </div>
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/travel.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="submitAssets">Assets

                                </a></div>
                        </div>

                        <div style="clear:both"></div>
                    </div>
                <?php } ?>



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
    ?>
    <form name="frmApprovalSession" id="sessionApprovalFRM" method="post" action="<?php echo $approvalUrl; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="pending_approve" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" >
            <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" >
                <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" >
                    </form>

                    <form name="frmApprovalSession" id="sessionInternalApprovalFRM" method="post" action="<?php echo $approvalUrl; ?>">
                        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
                        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
                        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
                        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
                        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
                        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
                        <input type="hidden" value="internal_pending_approve" name="seesion[requests]"/>
                        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" >
                            <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" >
                                <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" >
                                    </form>

                                    <form name="frmApprovalSession" id="sessionBookApprovlFRM" method="post" action="<?php echo $approvalUrl; ?>">
                                        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
                                        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
                                        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
                                        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
                                        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
                                        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
                                        <input type="hidden" value="book_pending_approve" name="seesion[requests]"/>
                                        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" >
                                            <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" >
                                                <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" >
                                                    </form>

                                                    <form name="frmApprovalSession" id="sessionTravelApprovalFRM" method="post" action="<?php echo $approvalUrl; ?>">
                                                        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
                                                        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
                                                        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
                                                        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
                                                        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
                                                        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
                                                        <input type="hidden" value="travel_pending_approve" name="seesion[requests]"/>
                                                        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" >
                                                            <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" >
                                                                <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" >
                                                                    </form>
                                                                    <form name="frmApprovalSession" id="sessionLeaveApprovalFRM" method="post" action="<?php echo $approvalUrl; ?>">
                                                                        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
                                                                        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
                                                                        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
                                                                        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
                                                                        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
                                                                        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
                                                                        <input type="hidden" value="leave_pending_approve" name="seesion[requests]"/>
                                                                        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" >
                                                                            <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" >
                                                                                <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" >

                                                                                    </form>
                                                                                    <form name="frmTravelSession" id="sessionAssetsFRM" method="post" action="<?php echo $approvalUrl; ?>">
                                                                                        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
                                                                                        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
                                                                                        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
                                                                                        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
                                                                                        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
                                                                                        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
                                                                                        <input type="hidden" value="new_assets" name="seesion[requests]"/>
                                                                                        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
                                                                                        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />
                                                                                    </form>
                                                                                    <script type="text/javascript">
                                                                                        $('#submitSession').click(function () {
                                                                                            $('#sessionFRM').submit();
                                                                                        });
                                                                                        $('.submitPendigApproval').click(function () {
                                                                                            $('#sessionApprovalFRM').submit();
                                                                                        });
                                                                                        $('.submitLeavePendigApproval').click(function () {
                                                                                            $('#sessionLeaveApprovalFRM').submit();
                                                                                        });
                                                                                        $('.submitPendingInternalApproval').click(function () {

                                                                                            $('#sessionInternalApprovalFRM').submit();
                                                                                        });
                                                                                        $('.submitPendigBookApproval').click(function () {
                                                                                            $('#sessionBookApprovlFRM').submit();
                                                                                        });
                                                                                        $('.submitPendigTravelApproval').click(function () {
                                                                                            $('#sessionTravelApprovalFRM').submit();
                                                                                        });
                                                                                        $('#timeSheet').click(function () {
                                                                                            $('#sessionHRIS').submit();
                                                                                        });
                                                                                        $('#submitAssets').click(function () {
                                                                                            $('#sessionAssetsFRM').submit();
                                                                                        });
                                                                                        $('#submitLeave').click(function () {
                                                                                            $('#sessionLeaveHRIS').submit();
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
