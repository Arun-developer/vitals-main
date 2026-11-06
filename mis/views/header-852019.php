<?php
$sessionID = $this->session->userdata('user_id');
$this->load->model('changepass/change_password_model');
$loginDetails = $this->change_password_model->getEmailDetailsByID($sessionID);
if ($loginDetails == '0') {
    $login = "";
    $password = "";
} else {
    $login = $loginDetails['login'];
    $password = $loginDetails['password'];
}
$server_url = $this->config->item('server_url');
$url_server = explode('/', site_url(''), 2);
if (php72_cmp($this->session->userdata['partner_id']) == 2) {
    $img_url = "source/template/images/villgro-logo-kenya-one.png";
} else if (php72_cmp($this->session->userdata['partner_id']) == 3) {
    $img_url = "source/template/images/menterra.jpg";
} else if (php72_cmp($this->session->userdata['partner_id']) == 4) {
    $img_url = "source/template/images/startup.png";
} else if (php72_cmp($this->session->userdata['partner_id']) == 5) {
    $img_url = "source/template/images/IIMC.png";
} else if (php72_cmp($this->session->userdata['partner_id']) == 6) {
    $img_url = "source/template/images/KIIT.jpg";
} else if (php72_cmp($this->session->userdata['partner_id']) == 7) {
    $img_url = "source/template/images/SIIC_llogo.jpg";
} else {
    $img_url = "source/template/images/logo.png";
}
?>
<div id="wrapper">
    <div class="header"><div class="headerLOGO">
            <div class="headerLOGO_LFT">
                <a href="<?= base_url(); ?>index.php/login/icon_menu"><img src="<?php echo base_url() . $img_url; ?>" title="Villgro"></a></div>
            <div class="headerLOGO_RHT">
                <ul>
                    <br/>
                    <li style="line-height:18px"><span>Welcome : <?php
                            if ($this->session->userdata('user_type') == 'superadmin') {
                                echo "Super Admin";
                            } else if ($this->session->userdata('user_type') == 'admin' and php72_cmp($this->session->userdata('role_id')) == 2) {
                                echo $this->session->userdata('emp_name');
                                ?>

                                <?php
                            } else if ($this->session->userdata('user_type') == 'employee' and php72_cmp($this->session->userdata('role_id')) == 2) {
                                echo $this->session->userdata('emp_name');
                                ?>

                                <?php
                            } else if ($this->session->userdata('user_type') == 'admin' and php72_cmp($this->session->userdata('role_id')) == 1) {
                                echo $this->session->userdata('emp_name');
                                ?>

                                <?php
                            } else if ($this->session->userdata('user_type') != 'admin' and $this->session->userdata('user_type') != 'mipuser') {
                                echo $this->session->userdata('emp_name');
                            } else {
                                if (($this->session->userdata('user_type') != 'admin')) {
                                    echo $this->session->userdata('name');
                                } else {
                                    echo $this->uri->segment('3');
                                }
                            }
                            ?></span><a href="<?php echo site_url('login/change_master'); ?>" style="color:red;">

                            <?php
                            if (php72_cmp($this->session->userdata('role_id')) == 2 && $this->session->userdata('user_type') == 'admin') {
                                echo "(Switch to User)";
                            } elseif (php72_cmp($this->session->userdata('role_id')) == 2 && $this->session->userdata('user_type') == 'employee') {
                                echo "(Switch to Admin)";
                            }
                            ?>
                        </a> </li>

                    <li style="line-height:18px"> <a href="<?php echo site_url('changepass'); ?>" style="background-image:none;"> Change Password</a> | <a href="<?= site_url('login/logout'); ?>" ><strong>Logout</strong></a> </li>

                    <?php
                    if ($this->session->userdata('user_type')) {
                        if ($this->session->userdata('user_type') != 'incubatee' && php72_cmp($this->session->userdata('ais_privilege')) == 1) {
                            $count = total_pending_count();
                            ?>
                            <li style="line-height:18px"><a href="<?php echo site_url('login/approvals'); ?>">Items pending for approval: <?= $count; ?></a></li>
                            <?php
                        }
                    }
                    ?>

                </ul>
            </div>
        </div>
        <form id="gaia_loginform" method="post" action="https://accounts.google.com/ServiceLoginAuth">
            <input id="continue" type="hidden" value="https://mail.google.com/mail/" name="continue">
            <input id="service" type="hidden" value="mail" name="service">
            <input id="rm" type="hidden" value="false" name="rm">
            <input id="dsh" type="hidden" value="-8925822218338751444" name="dsh">
            <input id="ltmpl" type="hidden" value="default" name="ltmpl">
            <input id="hl" type="hidden" value="en" name="hl">
            <input id="ltmpl" type="hidden" value="default" name="ltmpl">
            <input id="scc" type="hidden" value="1" name="scc">
            <input id="ss" type="hidden" value="1" name="ss">
            <input type="hidden" value="LAgVX8HtZwE" name="GALX">
            <input id="pstMsg" type="hidden" value="1" name="pstMsg">
            <input id="dnConn" type="hidden" value="" name="dnConn">
            <input id="checkConnection" type="hidden" value="youtube:455:1" name="checkConnection">
            <input id="checkedDomains" type="hidden" value="youtube" name="checkedDomains">
            <input id="timeStmp" type="hidden" value="" name="timeStmp">
            <input id="secTok" type="hidden" value="" name="secTok">
            <label>
                <strong class="email-label"></strong>
                <input id="Email" type="hidden" name="Email" spellcheck="false" value="sanju98720111@gmail.com">
            </label>
            <label>
                <strong class="passwd-label"></strong>
                <input id="Passwd" type="hidden" name="Passwd" value="admin@admin">
            </label>
        </form>
        <script type="text/javascript">
            $('#gmailLogin').click(function () {
                $('#gaia_loginform').submit();
            });
        </script>
