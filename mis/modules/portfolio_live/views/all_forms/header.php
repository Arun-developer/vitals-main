<link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/tagsinput.css'; ?>" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
<div class="fixed-headervi">
    <header>
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
                if ($this->session->userdata('role_id') == 2 && $this->session->userdata['user_type'] == 'admin') {
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
    <div class="villgro-breadcrumb container-fluid">
        <div class="row">
            <div class="col-md-6 col-xl-6 col-lg-6 col-12">
                <ul>
                    <li><a href="<?= base_url() . 'index.php/portfolio/dashboard'; ?>">Home </a></li> <i class="fa fa-angle-double-right"></i>
                    <?php if ($this->session->userdata['role_id'] != '4') { ?>
                        <li><a href="<?= base_url() . 'index.php/portfolio/portfolio_summary/' . $fin_year; ?>">Portfolio Summary </a></li> <i class="fa fa-angle-double-right"></i>
                    <?php } ?>
                    <li><a href="<?= base_url() . 'index.php/portfolio/company_summary/' . $innovation_id . '/' . $fin_year; ?>"><?= ucfirst($company_name); ?></a></li> <i
                    class="fa fa-angle-double-right"></i>
                    <!--<li><a class="active"><?= $page_title; ?></a></li>-->
                    <li><a class="active">Achievements (All Months)</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-xl-6 col-lg-6 col-12 text-right onbordconfig-title">
                <h6>
                    <a href="<?= base_url() . 'index.php/portfolio/product/' . $innovation_id . '/' . $fin_year; ?>">
                        <span>
                            Plan: <?php echo ucfirst($company_name) . ', '; ?>
                            <small>
                                <?php
                                if ($reg_city != '') {
                                    echo ucfirst($reg_city) . ', ';
                                }
                                if ($sector_name != '') {
                                    echo ucfirst($sector_name);
                                }
                                ?>
                            </small>
                        </span>
                    </a>
                </h6>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
<!--<script src="<?php // echo base_url() . 'source/portfolio_assets/js/jquery.3.4.0.js';                 ?>"></script>-->

<script type="text/javascript">
    setTimeout(function () {
        $('.msg').hide();
    }, 3000);
</script>