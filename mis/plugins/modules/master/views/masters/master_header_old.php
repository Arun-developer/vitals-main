<script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<header class="newVitalheader">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-md-6 col-12">
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

            <?php
            $switch_type = '';
            if ($this->session->userdata('role_id') == 2 && $this->session->userdata('user_type') == 'admin') {
                $switch_type = 'Switch to user';
            } else if ($this->session->userdata('role_id') == 2 && $this->session->userdata('user_type') == 'employee') {
                $switch_type = 'Switch to admin';
            }
            ?>

            <div class="col-xl-2 offset-xl-4 offset-md-2 col-md-4 order-10 col-12">
                <small>Welcome,</small>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                        if ($this->session->userdata('user_type') == 'superadmin') {
                            echo "Super Admin";
                        } else if ($this->session->userdata('user_type') == 'admin' and $this->session->userdata('role_id') == 2) {
                            echo ucfirst($this->session->userdata('emp_name'));
                        } else if ($this->session->userdata('user_type') == 'employee' and $this->session->userdata('role_id') == 2) {
                            echo ucfirst($this->session->userdata('emp_name'));
                        } else if ($this->session->userdata('user_type') == 'admin' and $this->session->userdata('role_id') == 1) {
                            echo ucfirst($this->session->userdata('emp_name'));
                        } else if ($this->session->userdata('user_type') != 'admin' and $this->session->userdata('user_type') != 'mipuser') {
                            echo ucfirst($this->session->userdata('emp_name'));
                        } else {
                            if (($this->session->userdata('user_type') != 'admin')) {
                                echo ucfirst($this->session->userdata('name'));
                            } else {
                                echo ucfirst($this->uri->segment('3'));
                            }
                        }
                        ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <?php if ($switch_type != '') { ?>
                            <a class="dropdown-item" href="<?php echo base_url() . 'index.php/login/admin_portfolio'; ?>"><i class="fas fa-retweet"></i> <?= $switch_type; ?></a>
                        <?php } ?>
                        <a class="dropdown-item" href="<?php echo site_url('changepass'); ?>"><i class="fas fa-key"></i> Change password</a>
                        <a class="dropdown-item" href="<?php echo base_url() . 'index.php/login/logout'; ?>"><i class="fas fa-sign-out-alt"></i> Sign out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    setTimeout(function () {
        $('.msg').hide();
    }, 3000);
</script>