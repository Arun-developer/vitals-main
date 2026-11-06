<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>

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
} else if (php72_cmp($this->session->userdata['partner_id']) == 10) {
    $img_url = "source/template/images/ceew.png";
} else {
    $img_url = "source/template/images/logo.png";
}

if ($this->session->userdata('user_type')) {
    if ($this->session->userdata('user_type') != 'incubatee' && php72_cmp($this->session->userdata('ais_privilege')) == 1) {
        $count = total_pending_count();
    }
}
?>

<div class="fixed-headervi">
    <header>
        <div class="vil-logo">
            <img src="<?php echo base_url() . $img_url; ?>" class="responsive"
                 alt="Villgro Logo" />
        </div>
        <div class="user-dropdown">
            <div class="dropdown">
                <small>Welcome,</small>
                <button class="dropbtn" onclick="headerdropdown()">
                    <?php
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
                    ?>

                    <i class="fas fa-sort-down"></i>
                </button>

                <?php
                $switch_type = '';
                if (php72_cmp($this->session->userdata('role_id')) == 2 && $this->session->userdata('user_type') == 'admin') {
                    $switch_type = 'Switch to user';
                } else if (php72_cmp($this->session->userdata('role_id')) == 2 && $this->session->userdata('user_type') == 'employee') {
                    $switch_type = 'Switch to admin';
                }
                ?>
                <div class="dropdown-content" id="myDropdown">
                    <?php if ($switch_type != '') { ?>
                        <a class="dropdown-item" href="<?php echo site_url('login/change_master'); ?>"><i class="fas fa-retweet"></i> <?= $switch_type; ?></a>
                    <?php } ?>
                    <a class="dropdown-item" href="<?php echo site_url('changepass'); ?>"><i class="fas fa-key"></i> Change password</a>
                    <a class="dropdown-item" href="<?= site_url('login/logout'); ?>"><i class="fas fa-sign-out-alt"></i> Sign out</a>
                </div>
                <a href="<?php echo site_url('login/approvals'); ?>">Items pending for approval: <?= $count; ?></a>
            </div>
        </div>
    </header>
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

    function headerdropdown() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    window.onclick = function (e) {
        if (!e.target.matches('.dropbtn')) {
            var myDropdown = document.getElementById("myDropdown");
            if (myDropdown.classList.contains('show')) {
                myDropdown.classList.remove('show');
            }
        }
    }
</script>