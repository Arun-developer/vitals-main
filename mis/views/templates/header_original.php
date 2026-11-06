<?php #$current_page =  $this->uri->segment(1); echo $current_page; die;   ?>
<style>
    .form-group label span {
        font-size: 12px;
        color: #dc3545!important;
    }
</style>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Villgro MIS</title>
        <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <script src="<?php echo base_url() . 'source/mis/js/custom_scripts.js'; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url() . 'source/validate/jquery.validate.min.js'; ?>" type="text/javascript"></script>


    </head>
    <style>

    </style>
    <body>
        <div class="fixed-headervi">
            <!-- Start Header -->
            <header class="newVitalheader">
                <div class="container-fluid">
                    <div class="row">



                        <div class="col-7 col-md-10 display-flex">

                            <div class="vil-logo">
                                <a href="<?php echo base_url(); ?>">
                                    <?php
                                    if ($this->session->userdata['partner_id'] == '10') {
                                        $logo_name = 'ceew.png';
                                    } else {
                                        $logo_name = 'logo.jpg';
                                    }
                                    ?>
                                    <img src="<?php echo base_url() . 'source/portfolio_assets/img/logo2.png'; ?>" class="responsive" alt="Villgro Logo" />
                                </a>
                            </div>
                            <nav class="navbar navbar-light show_mob">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                            </nav>
                            <div class="headerMenuNew " id="navbarTogglerDemo01">
                                <ul></ul>
                            </div>
                        </div>
                        <div class="col align-self-end text-right">
                            <small>Welcome,</small>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownmenulink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                </a>
                                <?php
                                $switch_type = '';
                                if (php72_cmp($this->session->userdata('role_id')) == 2 && $this->session->userdata('user_type') == 'admin') {
                                    $switch_type = 'Switch to user';
                                } else if (php72_cmp($this->session->userdata('role_id')) == 2 && $this->session->userdata('user_type') == 'employee') {
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
                            </div>
                        </div>

                        <?php
                        $error_cls = '';
                        if ($this->session->flashdata('Success') != '') {
                            $error_cls = 'success';
                            $error_msg = $this->session->flashdata('Success');
                        } else if ($this->session->flashdata('error') != '') {
                            $error_cls = 'danger';
                            $error_msg = $this->session->flashdata('error');
                        }
                        ?>
                        <div class="position-absolute d-flex flex-column p-4 toastPlace">
                            <div id="toast-container" aria-live="polite" aria-atomic="true">
                                <div id="toast-wrapper">
                                    <div class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                        <div class="toast-header bg-<?php echo $error_cls; ?> text-white">
                                            <strong><?php echo $error_msg; ?></strong>
                                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                <span aria-hidden="true" class="text-white">×</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
            <!-- End Header -->
        </div>
        <div class="vi-dashboard-funder onboardtabmenu wdt-100">
            <div class="container-fluid">
                <div class="Vital-Newmenu">
                    <div class="row" >
                        <div class="col">

                        </div>
                    </div>
                </div>

                <div class="dataconfig-content page-wrapper vitals_mainContent ">
                    <div class="row">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('templates/sidemenu.php'); ?>
                            </div>
                            <div class="footer-link">
                               <!--<p>copyright &copy; mis.villgroapps.org</p>-->
                            </div>
                        </div>


                        <!-- Model (Print) -->


                        <div class="modal" id="deleteModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content delete-alert">
                                    <div class="modal-body text-center">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-2">
                                                    <i class="fas fa-exclamation"></i>
                                                </div>
                                                <div class="col-10">
                                                    <h4>Are you sure you want to delete selected items?</h4>
                                                    <p>you are about delete <span id="delCount"></span> selected information fields, you can't undo this</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
                                        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                                        <button type="button" class="btn btn-success" id="editSubmit"> Delete Selected</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script type="text/javascript" src="<?= base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
                        <script>
                            $(document).ready(function () {
                                //alert('<?php echo $result; ?>');
                                var flashdata = '<?php echo $this->session->flashdata('Success'); ?>';
                                var flashdata_error = '<?php echo $this->session->flashdata('error'); ?>';

                                if ((flashdata != '' || flashdata_error != '')) {
                                    $('.toast').toast('show');
                                }
                            });
                        </script>



