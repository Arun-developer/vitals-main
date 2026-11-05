<?php
$current = $this->uri->segment('1');
?>
<div class="headerMENU_OUT">
    <div class="headerMENU">
        <?php if ($this->session->userdata('emp_type') == 'fellow' && $this->session->userdata('user_id') != 'USR106') {
            ?>
            <a href="<?= site_url('scouting/innovation_pool/all'); ?>"
               class="<?php echo ($this->uri->segment('2') == 'innovation_pool') ? 'sel' : ''; ?>">
                <span>Innovation Pool</span>
            </a>
        <?php } else { ?>
            <?php
            $mip_userId = $this->session->userdata("mip_id");
            $mipstatusID = $this->session->userdata("mip_status");
            if ($this->Mauth->isLogged()) {
                ?>
                <a href="<?= site_url('common/dashboard'); ?>"
                   class="<?php echo ($this->uri->segment('2') == 'dashboard' || $this->uri->segment('1') == 'dashboard') ? 'sel' : ''; ?>">Dashboard</a>
               <?php } ?>
               <?php if ($this->session->userdata('user_type') == 'admin' || $mip_userId != '0') { ?>
                   <?php
               } else {

               }
               ?>
               <?php if ($this->session->userdata('user_id')) { ?>
                <a href="<?= site_url('master/source/view_list'); ?>"
                   class="<?php echo ($this->uri->segment('2') == 'source') ? 'sel' : ''; ?>"><span>Source</span></a>
                <a href="<?= site_url('scouting/innovation_pool/all'); ?>"
                   class="<?php echo ($this->uri->segment('2') == 'innovation_pool') ? 'sel' : ''; ?>">
                    <span>Innovation Pool</span>
                </a> <?php } ?>
            <?php if ($this->Mauth->isLogged()) { ?>
                <a href="javascript:;" id="submitApproval"> Approval Note</a>
                <a href="javascript:;" id="timeSheet"> Time Sheet</a>
                <a href="javascript:;" id="leave">Leave &nbsp;&nbsp;</a>
                <a href="javascript:;" id="submitTravel">Travel & Accomodation System</a>
                <a href="javascript:;" href="javascript:;" id="dmsID"> Document Management System</a>
                <a href="<?php echo site_url("eventcalender/index"); ?>" id="eventCalender"> Event Calender</a>
            <?php
            }
        }
        ?>
    </div>
</div>
<div class="header_BAR">
    <div class="header_BAR_OUT">
        <?php
        $current = $this->uri->segment('2');
        $currentInnovationURL = $this->uri->segment('3');
        $currentStage = $this->uri->segment('1');

        if (($current == "innovation_pool") || ($current == "new_innovation") || ($current == "master_settings") || ($current == "report") || ($currentStage != "common") || ($currentInnovationURL == "all") AND $currentStage != "imggallery" AND $currentStage != "dashboard") {

            $this->load->model("master/Mformbuilder");
            $formNameList = $this->Mformbuilder->getPublishedForm();
            ?>

            <div class="header_BAR_TXT">

                <?php if ($this->Mauth->isLogged() && $this->uri->segment("1") != "master" AND $this->uri->segment("1") != "mainmaster") { ?>
                    <?php if ($this->session->userdata('user_type') == 'admin') { ?>
        <?php } ?>
                    <a href="<?= site_url('scouting/new_innovation'); ?>">Create a new Innovation</a>
                    <a href="<?= site_url('scouting/innovation_pool/assigned'); ?>">Assigned Innovations</a>
                    <a href="<?= site_url('scouting/innovation_pool/identified'); ?>">My Applications</a>
                    <a href="<?= site_url('scouting/innovation_pool/all'); ?>">All Innovations</a>
                    <a href="<?= site_url('scouting/innovation_pool/lead'); ?>">Leads</a>
                    <a href="<?= site_url('scouting/innovation_pool/incubation'); ?>">Portfolio Innovations</a>
                    <a href="<?= site_url('scouting/innovation_pool/exit'); ?>"
                       class="<?php echo ($this->uri->segment('3') == 'exit' ) ? 'sel' : ''; ?>">Exited Innovations</a>
                    <a href="<?= site_url('common/report/innovation_report'); ?>">Innovation Reports</a>
    <?php } ?>

            </div>

            <?php
        }
        $url_server = explode('/', site_url(''), 2);
        $ais_url = $url_server['0'] . "//" . $this->config->item('ais_url');
        $hris_url = $url_server['0'] . "//" . $this->config->item('hris_url');

        $hrisnew = host_url() . 'ctl_vill/villcode/index.php/';

        $currentURL = $this->uri->segment('3');
        $currentdashboardURL = $this->uri->segment('2');
        $currentaisURL = $this->uri->segment('1');

        if ($currentURL == "user" || $currentURL == "admin_dashboard" || $currentaisURL == "main" || $currentaisURL == "dashboard" AND ( $currentaisURL != "scouting")) {
            ?>

            <div class="header_BAR_TXT" style="margin-top:0px;">
                <a href="<?= site_url('common/dashboard/admin_dashboard'); ?>">Portfolio Dashboard</a>
                <a href="javascript:;" id="submitAISDashboard">My Admin</a>
                <a href="<?= site_url('dashboard/dashboard'); ?>">Deal Flow</a>
                <a href="<?= $ais_url . 'main/myhrdashboard'; ?>">My HR</a>
            </div>
<?php } ?>
    </div>
</div>
<?php
$ais_masters = $ais_url . 'master/master_settings';
$url_server = explode('/', site_url(''), 2);
$ais_url = $url_server['0'] . "//" . $this->config->item('ais_url');
$this->config->item('ais_url');
$hris_url = $url_server['0'] . "//" . $this->config->item('hris_url');
$approvalUrl = $ais_url . 'login/index/';
$travelUrl = $ais_url . 'traveladmin/requestlist';
$travelLogin = host_url() . "vital_ais/index.php/login/index/";
$timeSheet = $hris_url;
$sessionhris_url = $url_server['0'] . "//" . $_SERVER['HTTP_HOST'] . "/ctl_vill/index.php/";

$myIdea = host_url() . "mip_test/index.php";
$url_server = explode('/', site_url(''), 4);
$dmsUser = site_url('dms/document_system/index/');
$url = "";
$aismailTemplate = host_url() . "master/mailtemplate";
$useraccessURL = site_url("mainmaster/useraccess");
$pim_url = $url_server['0'] . "//" . $_SERVER['HTTP_HOST'] . "vil/index.php";
?>
<form name="frmmailTemplateSession" id="sessionAISMailFRM" method="post" action="<?php echo $approvalUrl; ?>">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]">
    <input type="hidden" value="" name="seesion[userid]">
    <input type="hidden" value="" name="seesion[emp_number]">
    <input type="hidden" value="" name="seesion[emp_name]">
    <input type="hidden" value="" name="seesion[user_type]">
    <input type="hidden" value="<?php echo "aismailtemplate"; ?>" name="seesion[mailtemplate]">
</form>


<form name="frmApprovalSession" id="sessionAISFRM" method="post" action="<?php echo $approvalUrl; ?>">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]">
    <input type="hidden" value="" name="seesion[userid]">
    <input type="hidden" value="<?php echo "aisdashboard"; ?>" name="seesion[dashboard]">
    <input type="hidden" value="" name="seesion[emp_number]">
    <input type="hidden" value="" name="seesion[emp_name]">
    <input type="hidden" value="" name="seesion[user_type]">
</form>

<form name="frmSession" id="sessionFRM" method="post" action="<?php echo $url; ?>">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]">
</form>

<form name="frmApprovalSession" id="sessionApprovalFRM" method="post" action="<?php echo $approvalUrl; ?>">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]">
    <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]">
    <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]">
    <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]">

</form>

<form name="frmAISMasters" id="aisFrmMasterID" method="post" action="<?php echo $approvalUrl; ?>">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]">
    <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]">
    <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]">
    <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]">
    <input type="hidden" value="<?php echo "ais_master"; ?>" name="seesion[aismaster]">
</form>




<form name="frmTravelSession" id="sessionTravelFRM" method="post" action="<?php echo $travelLogin; ?>">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_type'); ?>" name="seesion[emp_type]">
    <input type="hidden" value="Travel" name="seesion[menu]">
    <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]">
    <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]">
    <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]">
    <input type="hidden" value="<?php echo $useraccessURL; ?>" name="seesion[useraccessurl]">
</form>

<form name="frmPIMSession" id="sessionPIMHRIS" method="post" action="<?php echo $timeSheet; ?>">
    <input type="hidden" name="seesion[HRISPIM]" value="PIM" />
    <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]">
    <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]">
    <input type="hidden" value="<?php echo "PIM"; ?>" name="seesion[menu]">
    <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]">
    <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]">
    <input type="hidden" value="<?php echo $useraccessURL; ?>" name="seesion[useraccessurl]">
</form>


<form name="frmTravelSession" id="sessionHRIS" method="post" action="<?php echo $timeSheet; ?>">
    <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]">
    <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]">
    <input type="hidden" value="<?php echo "TimeSheet"; ?>" name="seesion[menu]">
    <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]">
    <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]">
    <input type="hidden" value="<?php echo ""; ?>" name="seesion[useraccess]">
    <input type="hidden" value="<?php echo $useraccessURL; ?>" name="seesion[useraccessurl]">
    <input type="hidden" name="seesion[HRISPIM]" value="" />

</form>
<form name="frmLeaveSession" id="sessionLeaveHRIS" method="post" action="<?php echo $timeSheet; ?>">

    <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]">
    <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]">
    <input type="hidden" value="<?php echo "Leave"; ?>" name="seesion[menu]">
    <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]">
    <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]">
    <input type="hidden" value="<?php echo ""; ?>" name="seesion[useraccess]">
    <input type="hidden" value="<?php echo $useraccessURL; ?>" name="seesion[useraccessurl]">
    <input type="hidden" name="seesion[HRISPIM]" value="" />

</form>

<form name="frmMyIdea" id="sessionMyIdeaProgram" method="post" action="<?php echo $myIdea; ?>">
    <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="login[user_name]">
    <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="login[password]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="login[userid]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="login[emp_number]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="login[emp_name]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="login[user_type]">
    <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="login[mis_url]">
    <input type="hidden" value="<?php echo $ais_url; ?>" name="login[ais_url]">
    <input type="hidden" value="<?php echo $hris_url; ?>" name="login[hris_url]">
</form>

<form name="frmUserAccess" id="sessionuserAccess" method="post" action="<?php echo $timeSheet; ?>">
    <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]">
    <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]">
    <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]">
    <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]">
    <input type="hidden" value="<?php echo "userAccess"; ?>" name="seesion[useraccess]">
    <input type="hidden" value="<?php echo $useraccessURL; ?>" name="seesion[useraccessurl]">
    <input type="hidden" name="seesion[HRISPIM]" value="" />
</form>


<form name="frmUserDetails" id="frmUserDetails" method="post" action="<?php echo $dmsUser; ?>">
    <?php
    $userName = $this->session->userdata('user_name');
    $password = $this->session->userdata('password');
    ?>
    <input type="hidden" name="login"
           value="<?php
           if ($userName == "Admin") {
               echo "admin";
           } else {
               echo strtolower($userName);
           }
           ?>" />
    <input type="hidden" name="password" value="<?php echo $password; ?>" />
</form>
<?php if ($this->Mauth->isLogged()) { ?>

<?php } ?>

<script type="text/javascript">
    $('#submitSession').click(function () {
        $('#sessionFRM').submit();
    });

    $('#submitApproval').click(function () {
        $('#sessionApprovalFRM').submit();
    });

    $('#submitTravel').click(function () {
        $('#sessionTravelFRM').submit();
    });

    $('#timeSheet').click(function () {
        $('#sessionHRIS').submit();
    });

    $('#submitHRISPIMID').click(function () {
        $('#sessionPIMHRIS').submit();
    });

    $('#leave').click(function () {
        $('#sessionLeaveHRIS').submit();
    });

    $('#dmsID').click(function () {
        $('#frmUserDetails').submit();
    });

    $('#submitAISDashboard').click(function () {
        $('#sessionAISFRM').submit();
    });

    $('#submitAISMail').click(function () {
        $('#sessionAISMailFRM').submit();
    });

    $('#submitMyIdea').click(function () {
        $('#sessionMyIdeaProgram').submit();
    });
    $('#userAccessID').click(function () {
        $('#sessionuserAccess').submit();
    });

    $('#aisMastersID').click(function () {
        $('#aisFrmMasterID').submit();
    });
</script>
<?php if (($this->uri->segment('2') == 'dashboard') && ($this->uri->segment('3') == 'admin') || ($this->uri->segment('3') == 'user')) {
    ?>
    <br>
<?php } ?>