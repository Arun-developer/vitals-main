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
                        <?php // if ($this->session->userdata('partner_id') == '1') { ?>
                        <!--<div class="icon-btn"><a href="#" id="" style="cursor:default">New Approval Note</a></div>-->
                        <?php // } else { ?>
                        <div class="icon-btn"><a href="#" id="submitApproval">New Approval Note</a></div>
                        <?php // } ?>

                    </div>

                    <div class="icon-box">
                        <div class="icon">
                            <img src="<?= base_url(); ?>source/images/internalnote.png" alt="innovation" /></div>
                        <div class="icon-btn"><a href="#" id="submitInternal">New Internal Note

                            </a></div>
                    </div>

                    <?php if ($this->session->userdata('user_type') != 'admin') { ?>
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                            <!-- <div class="icon-btn"><a href="#" id="submitLeave">Leave/Work From Home</a></div> -->
                            <div class="icon-btn"><a href="<?php echo base_url() . 'index.php/leave/apply_leave'; ?>" id="vital_leavereq">Leave/Work From Home</a></div>
                        </div>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/2.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="submitBook">Want a Book?</a></div>
                            <div style="clear:both"></div>
                        </div>
                        <div style="clear:both"></div>
                    </div>

                    <div class="icon-row">
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/travel.png" alt="innovation" /></div>
                            <div class="icon-btn"><a href="#" id="submitTravel">Travel & Accomodation

                                </a></div>
                        </div>

                        <div style="clear:both"></div>
                    </div>


                    <div class="icon-row">
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
    $sessionhris_url = $url_server['0'] . "//" . $_SERVER['HTTP_HOST'] . "/vill/index.php/";

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
        <input type="hidden" value="new_approvalnote" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />
        <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" />
        <input type="hidden" value="<?php echo $this->session->userdata('session_id'); ?>" name="seesion[session_id]" />
        <input type="hidden" value="" name="seesion[is_session]"/>
    </form>
    <form name="frmApprovalSession" id="sessionInternalFRM" method="post" action="<?php echo $approvalUrl; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="new_internalnote" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />
        <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" />

    </form>
    <form name="frmApprovalSession" id="sessionBookFRM" method="post" action="<?php echo $approvalUrl; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="new_book" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />
        <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" />

    </form>
    <form name="frmTravelSession" id="sessionTravelFRM" method="post" action="<?php echo $approvalUrl; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="new_travel" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />
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
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />
    </form>



    <form name="frmLeaveSession" id="sessionLeaveHRIS" method="post" action="<?php echo $timeSheet; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="new_leave" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $from_financial; ?>" name="seesion[from_financial]"/>
        <input type="hidden" value="<?php echo $to_financial; ?>" name="seesion[to_financial]"/>
        <input type="hidden" value="<?php echo $pending_count; ?>" name="seesion[pending_count]"/>
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>
    <script type="text/javascript">
        $('#submitSession').click(function () {
            $('#sessionFRM').submit();
        });
        $('#submitApproval').click(function () {
            $('#sessionApprovalFRM').submit();
        });
        $('#submitInternal').click(function () {
            $('#sessionInternalFRM').submit();
        });
        $('#submitBook').click(function () {
            $('#sessionBookFRM').submit();
        });
        $('#submitTravel').click(function () {
            $('#sessionTravelFRM').submit();
        });
        $('#submitAssets').click(function () {
            $('#sessionAssetsFRM').submit();
        });
        $('#timeSheet').click(function () {
            $('#sessionHRIS').submit();
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
