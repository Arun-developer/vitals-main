<?php
$current = $this->uri->segment('1');
$isCEO = false;
$isAdmin = false;
$financeteam = array('USR075', 'USR088');
$this->load->model('dashboard/Mhrisdashboard');
$ceo = $this->Mhrisdashboard->getCeo();
if ($ceo == $this->session->userdata('user')) {
    $isCEO = true;
}

$admin = 'USR003';
if ($admin == $this->session->userdata('user_id')) {
    $isAdmin = true;
}
?>
<div class="headerMENU_OUT">
    <div class="headerMENU">
        <?php if ($this->session->userdata('emp_type') == 'fellow' && $this->session->userdata('user_id') != 'USR106') { ?>
            <a href="<?= site_url('scouting/new_innovation/'); ?>"
               class="<?php echo ($this->uri->segment('2') == 'innovation_pool') ? 'sel' : ''; ?>">
                <span>Innovation Pool</span>
            </a>

            <a href="javascript:;" id="submitApproval"> Approval Note</a>
            <a href="javascript:;" id="submitTravel">Travel & Accomodation System</a>
            <a href="javascript:;" id="leave">Leave &nbsp;&nbsp;</a>
        <?php } else if (in_array($this->session->userdata('user_id'), $financeteam)) { ?>
            <a href="javascript:;" id="submitApproval"> Approval Note</a>
            <a href="javascript:;" id="dmsID"> Document Management System</a>
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
                <a class="<?php echo ($this->uri->segment('1') == 'master') ? 'sel' : ''; ?>"
                   href="<?= site_url('master/master_settings') ?>">Masters</a>
                   <?php
               } else {

                   if ($mip_userId != '0') {
                       ?>
                    <a href="<?= site_url('master/source/view_list'); ?>"
                       class="<?php echo ($this->uri->segment('2') == 'source') ? 'sel' : ''; ?>"><span>Source</span></a>
                       <?php
                   }
               }
               ?>
               <?php if ($this->session->userdata('user_id')) { ?>
                <a href="<?= site_url('scouting/innovation_pool/all'); ?>"
                   class="<?php echo ($this->uri->segment('2') == 'innovation_pool') ? 'sel' : ''; ?>">
                    <span>Innovation Pool</span>
                </a> <?php } ?>
            <?php if ($this->Mauth->isLogged()) { ?>
                <a href="javascript:;" id="submitApproval"> Approval Note</a>
                <a href="javascript:;" id="timeSheet"> Time Sheet</a>
                <a href="javascript:;" id="leave">Leave &nbsp;&nbsp;</a>
                <a href="javascript:;" id="submitTravel">Travel & Accomodation System</a>
                <a href="javascript:;" id="submitMyIdea">My Idea Program</a>
                <a href="javascript:;" href="javascript:;" id="dmsID"
                   class="<?php echo ($this->uri->segment('1') == 'dms') ? 'sel' : ''; ?>"> Document Management System</a>
                <a href="<?php echo site_url("eventcalender/index"); ?>" id="eventCalender"
                   class="<?php echo ($this->uri->segment('1') == 'eventcalender') ? 'sel' : ''; ?>"> Event Calender</a>
               <?php } ?>

            <?php
            if ($mip_userId >= '0' and $mipstatusID == "Active") {
                ?>
                <a href="javascript:;" id="submitMyIdea">My Idea Program</a>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<div class="header_BAR">
    <div class="header_BAR_OUT">
        <?php
        $current = $this->uri->segment('2');
        $currentInnovationURL = $this->uri->segment('3');
        $currentStage = $this->uri->segment('1');

        if (($current == "innovation_pool") || ($current == "new_innovation") || ($current == "master_settings") || ($current == "report") || ($currentStage != "common") || ($currentInnovationURL == "all") and $currentStage != "imggallery" and $currentStage != "dashboard") {
            ?>

            <div class="header_BAR_TXT">

                <?php if ($this->Mauth->isLogged() && $this->uri->segment("1") != "structure" && $this->uri->segment("1") != "master" && $this->uri->segment('1') != 'dms' && $this->uri->segment("1") != 'eventcalender' and $this->uri->segment("1") != "mainmaster") { ?>
                    <?php if ($this->session->userdata('user_type') == 'admin') { ?>
                    <?php } else { ?>
                    <?php } ?>
                    <a href="<?= site_url('scouting/new_innovation'); ?>"
                       class="<?php echo ($this->uri->segment('2') == 'new_innovation') ? 'sel' : ''; ?>">Create a new
                        Innovation</a>
                    <?php if ($this->session->userdata('emp_type') != 'fellow') { ?>
                        <a href="<?= site_url('scouting/innovation_pool/assigned'); ?>"
                           class="<?php echo ($this->uri->segment('2') == 'assigned') ? 'sel' : ''; ?>">Assigned Innovations</a>
                        <a href="<?= site_url('scouting/innovation_pool/identified'); ?>"
                           class="<?php echo ($this->uri->segment('3') == 'identified') ? 'sel' : ''; ?>">My Applications</a>
                        <a href="<?= site_url('scouting/innovation_pool/all'); ?>"
                           class="<?php echo ($this->uri->segment('3') == 'all') ? 'sel' : ''; ?>">All Innovations</a>
                        <a href="<?= site_url('scouting/innovation_pool/lead'); ?>"
                           class="<?php echo ($this->uri->segment('3') == 'lead') ? 'sel' : ''; ?>">Leads</a>
                        <a href="<?= site_url('scouting/innovation_pool/incubation'); ?>"
                           class="<?php echo ($this->uri->segment('3') == 'incubation') ? 'sel' : ''; ?>">Portfolio Innovations</a>
                        <a href="<?= site_url('scouting/innovation_pool/exit'); ?>"
                           class="<?php echo ($this->uri->segment('3') == 'exit') ? 'sel' : ''; ?>">Exited Innovations</a>
                        <a href="<?= site_url('common/report/innovation_report'); ?>"
                           class="<?php echo ($this->uri->segment('3') == 'innovation_report') ? 'sel' : ''; ?>">Innovation
                            Reports</a>
                        <?php
                    }
                }
                ?>

            </div>

            <?php
        }
        $url_server = explode('/', site_url(''), 2);
        $ais_url = $url_server['0'] . "//" . $this->config->item('ais_url');
        $hris_url = $url_server['0'] . "//" . $this->config->item('hris_url');
//timesheet/index.php/area/taskAssign

        $hrisnew = host_url() . 'ctl_vill/villcode/index.php/';

        $currentURL = $this->uri->segment('3');
        $currentdashboardURL = $this->uri->segment('2');
        $currentaisURL = $this->uri->segment('1');
        ?>
        <div class="header_BAR_TXT" style="margin-top:0px;">
            <?php
            if ($currentURL == "admin" || $currentURL == "admin_dashboard" || $currentURL == "user" || $currentaisURL == "main" || $currentaisURL == "dashboard" and ( $currentaisURL != "scouting")) {
                ?>
                <a href="<?= site_url('common/dashboard/admin_dashboard'); ?>"
                   class="<?php echo ($this->uri->segment('3') == 'admin_dashboard') ? 'sel' : ''; ?>">Portfolio
                    Dashboard</a>
                <a href="javascript:;" id="submitAISDashboard"
                   class="<?php echo ($this->uri->segment('1') == 'main') ? 'sel' : ''; ?>">My Admin</a>
                <a href="<?= site_url('dashboard/dashboard'); ?>"
                   class="<?php echo ($this->uri->segment('1') == 'dashboard' && $this->uri->segment('2') == 'dashboard') ? 'sel' : ''; ?>">Deal
                    flow</a>
                <a href="javascript:;" id="submitADMINDashboard"
                   class="<?php echo ($this->uri->segment('1') == 'main') ? 'sel' : ''; ?>">Admin Dashboard</a>
                <a href="<?php echo site_url('dashboard/hrisdashboard/index'); ?>"
                   class="<?php echo ($this->uri->segment('2') == 'hrisdashboard') ? 'sel' : ''; ?>">HR Dashboard</a>
                <a href="javascript:;" id="hrdashboardID"
                   class="<?php echo ($this->uri->segment('2') == 'myhrdashboard') ? 'sel' : ''; ?>">My HR</a>
               <?php } ?>
        </div>

        <div class="header_BAR_TXT" style="margin-top:0px;">
            <?php if ($this->uri->segment('1') == 'master' || $this->uri->segment("2") == "useraccess" || $this->uri->segment("2") == "structure" and $this->Mauth->isLogged()) { ?>
                <?php if ($this->uri->segment('4') != "pimhris") { ?>
                    <a href="javascript:;" id="submitHRISPIMID">PIM</a>
                <?php }if ($this->uri->segment('4') == "pimhris") {
                    ?>
                    <a
                        href="<?php echo host_url(); ?>vill/index.php?module=Home&menu_no=12&submenutop=home1&menu_no_top=hr&li=pim"><?php echo "PIM"; ?></a>
                    <?php } ?>
                <a href="<?= site_url('mainmaster/useraccess/') ?>" id="userAccessID"
                   class="<?php echo ($this->uri->segment('2') == 'useraccess') ? 'sel' : ''; ?>">User Access</a>
                <a href="javascript:;" id="aisMastersID">AIS Masters</a>
                <a href="<?= site_url('master/mailtemplate/index') ?>"
                   class="<?php echo ($this->uri->segment('2') == 'mailtemplate') ? 'sel' : ''; ?>">Mail Template</a>
                <a href="<?php echo site_url("master/formbuilder/view_list"); ?>"
                   class="<?php echo ($this->uri->segment('2') == 'formbuilder') ? 'sel' : ''; ?>">Process Builder</a>
                <a href="<?php echo site_url("structure/structure/index"); ?>"
                   class="<?php echo ($this->uri->segment('2') == 'structure') ? 'sel' : ''; ?>">Organization Chart</a>
               <?php } ?>
               <?php ?>

        </div>



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
    <input type="hidden" value="<?php echo $this->session->userdata('emp_type'); ?>" name="seesion[emp_type]">
    <input type="hidden" value="" name="seesion[user_type]">
    <input type="hidden" value="<?php echo "aismailtemplate"; ?>" name="seesion[mailtemplate]">
</form>


<form name="frmmyhrmDashboard" id="frmmyhrmDashboard" method="post" action="<?php echo $approvalUrl; ?>">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]">
    <input type="hidden" value="" name="seesion[userid]">
    <input type="hidden" value="" name="seesion[emp_number]">
    <input type="hidden" value="" name="seesion[emp_name]">
    <input type="hidden" value="" name="seesion[user_type]">
    <input type="hidden" value="<?php echo "hrdashboard"; ?>" name="seesion[hrdashboard]">
</form>


<form name="frmApprovalSession" id="sessionAISFRM" method="post" action="<?php echo $approvalUrl; ?>">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]">
    <input type="hidden" value="" name="seesion[userid]">
    <input type="hidden" value="<?php echo "aisdashboard"; ?>" name="seesion[dashboard]">
    <input type="hidden" value="" name="seesion[emp_number]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_type'); ?>" name="seesion[emp_type]">
    <input type="hidden" value="" name="seesion[user_type]">
</form>


<form name="frmApprovalSession" id="sessionAISDASHBOARDFRM" method="post" action="<?php echo $approvalUrl; ?>">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]">
    <input type="hidden" value="" name="seesion[userid]">
    <input type="hidden" value="<?php echo "admindashboard"; ?>" name="seesion[dashboard]">
    <input type="hidden" value="" name="seesion[emp_number]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_type'); ?>" name="seesion[emp_type]">
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
    <input type="hidden" value="<?php echo $this->session->userdata('emp_type'); ?>" name="seesion[emp_type]">
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
    <input type="hidden" value="" name="seesion[mylistleave]">
    <input type="hidden" value="" name="seesion[rolelistleave]">
    <input type="hidden" value="" name="seesion[adminlistleave]">
    <input type="hidden" value="" name="seesion[adminfellowrecruitment]">
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
    <input type="hidden" value="" name="seesion[mylistleave]">
    <input type="hidden" value="" name="seesion[rolelistleave]">
    <input type="hidden" name="seesion[HRISPIM]" value="" />
    <input type="hidden" value="" name="seesion[adminlistleave]">
    <input type="hidden" value="" name="seesion[adminfellowrecruitment]">
</form>
<form name="frmLeaveSession" id="sessionLeaveHRIS" method="post" action="<?php echo $timeSheet; ?>">

    <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]">
    <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]">
    <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]">
    <input type="hidden" value="<?php echo $this->session->userdata('emp_type'); ?>" name="seesion[emp_type]">
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
    <input type="hidden" value="" name="seesion[mylistleave]">
    <input type="hidden" value="" name="seesion[rolelistleave]">
    <input type="hidden" name="seesion[HRISPIM]" value="" />
    <input type="hidden" value="" name="seesion[adminlistleave]">
    <input type="hidden" value="" name="seesion[adminfellowrecruitment]">
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

    $('#submitADMINDashboard').click(function () {
        $('#sessionAISDASHBOARDFRM').submit();
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

    $('#hrdashboardID').click(function () {
        $('#frmmyhrmDashboard').submit();
    });
</script>