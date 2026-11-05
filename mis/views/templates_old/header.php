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
if ($this->session->userdata['partner_id'] == 2) {
    $img_url = "source/template/images/villgro-logo-kenya-one.png";
} else if ($this->session->userdata['partner_id'] == 3) {
    $img_url = "source/template/images/menterra.jpg";
} else if ($this->session->userdata['partner_id'] == 4) {
    $img_url = "source/template/images/startup.png";
} else if ($this->session->userdata['partner_id'] == 5) {
    $img_url = "source/template/images/IIMC.png";
} else if ($this->session->userdata['partner_id'] == 6) {
    $img_url = "source/template/images/KIIT.jpg";
} else if ($this->session->userdata['partner_id'] == 7) {
    $img_url = "source/template/images/SIIC_llogo.jpg";
} else if ($this->session->userdata['partner_id'] == 10) {
    $img_url = "source/template/images/ceew.png";
} else {
    $img_url = "source/template/images/logo.png";
}

if ($this->session->userdata('user_type')) {
    if ($this->session->userdata('user_type') != 'incubatee' && $this->session->userdata('ais_privilege') == 1) {
        $count = total_pending_count();
    }
}
?>
<header class="newVitalheader">
    <div class="container-fluid">
        <div class="row">
            <div class="col display-flex">
                <nav class="navbar navbar-light show_mob">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </nav>
                <div class="vil-logo">
                    <a href="<?php echo base_url(); ?>">
                        <?php
                        if ($this->session->userdata['partner_id'] == '10') {
                            $logo_name = 'ceew.png';
                        } else {
                            $logo_name = 'logo.jpg';
                        }
                        ?>
                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/' . $logo_name; ?>" class="responsive" alt="Villgro Logo" />
                    </a>
                </div>
            </div>
            <div class="col align-self-end text-right">
                <small>Welcome,</small>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                    if ($this->session->userdata('user_type') == 'superadmin') {
                        echo "Super Admin";
                    } else if ($this->session->userdata('user_type') == 'admin' and $this->session->userdata('role_id') == 2) {
                            echo  $this->session->userdata('emp_name');
                        ?>

                        <?php
                    } else if ($this->session->userdata('user_type') == 'employee' and $this->session->userdata('role_id') == 2) {
                        echo $this->session->userdata('emp_name');
                        ?>

                        <?php
                    } else if ($this->session->userdata('user_type') == 'admin' and $this->session->userdata('role_id') == 1) {
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
                    </a>
                    <?php
                    $switch_type = '';
                    if ($this->session->userdata('role_id') == 2 && $this->session->userdata('user_type') == 'admin') {
                        $switch_type = 'Switch to user';
                    } else if ($this->session->userdata('role_id') == 2 && $this->session->userdata('user_type') == 'employee') {
                        $switch_type = 'Switch to admin';
                    }
                    ?>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <?php if ($switch_type != '') { ?>
                            <a class="dropdown-item" href="<?php echo site_url('login/change_master'); ?>"><i class="fas fa-retweet"></i> <?= $switch_type; ?></a>
                        <?php } ?>
                        <a class="dropdown-item" href="<?php echo site_url('changepass'); ?>"><i class="fas fa-key"></i> Change password</a>
                        <a class="dropdown-item" href="<?= site_url('login/logout'); ?>"><i class="fas fa-sign-out-alt"></i> Sign out</a>
                  </div>
                    </br>
                <!-- <a href="<?php echo site_url('login/approvals'); ?>">Items pending for approval: <?= $count; ?></a>
                            -->
                </div>
            </div>
            <div class="collapse navbar-collapse show_mob" id="navbarTogglerDemo01">
                <ul class="navbar-nav ">
                    <li class="nav-item active">
                        <a class="nav-link" href="#"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-tag"></i> Deals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="<?php echo base_url() . 'index.php/user/user_ui/leave_list'; ?>"><i class="fas fa-sync-alt"></i> Requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="far fa-check-square"></i> Approve</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="far fa-chart-bar"></i> Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-archive"></i> Resources</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-suitcase"></i> Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>"><i class="fas fa-user-friends"></i> Master's</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script type="text/javascript">
   /*  $('#gmailLogin').click(function () {
        $('#gaia_loginform').submit();
    }); */

    function headerdropdown() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    /* window.onclick = function (e) {
        if (!e.target.matches('#dropdownMenuLink')) {
            var myDropdown = document.getElementById("myDropdown");
            if (myDropdown.classList.contains('show')) {
                myDropdown.classList.remove('show');
            }
        }
    } */
</script>