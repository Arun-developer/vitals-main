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

            <div class="icon-row" style="border-top:0px;">
                <div class="icon-box">
                    <div class="icon">
                        <img src="<?= base_url(); ?>source/images/innovation.png" alt="innovation" /></div>
                        <div class="icon-btn"><a href="<?= site_url('application/add_deal') ?>">Add  an Innovation

                        </a></div>
                    </div>
                    <?php if (php72_cmp($this->session->userdata('partner_id')) == 1 || $this->session->userdata('role_id') == '3') { ?>
                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/Time-Sheet.png" alt="innovation" /></div>
                                <div class="icon-btn"><a href="<?= site_url('login/timesheet'); ?>">Time Sheet

                                </a></div>
                            </div>
                        <?php } ?>

                        <div class="icon-box">
                            <div class="icon">
                                <img src="<?= base_url(); ?>source/images/my-deals.png" alt="innovation" /></div>
                                <div class="icon-btn"><a href="<?= site_url('login/mydeals/'); ?>">Deals</a></div>
                            </div>
                            
                            <?php if ($this->session->userdata('role_id') != '2' && $this->session->userdata('role_id') != '3' && php72_cmp($this->session->userdata('ais_privilege')) == 1 && php72_cmp($this->session->userdata('partner_id')) == 1) { ?>
                                <div class="icon-box">
                                    <div class="icon">
                                        <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                                        <!-- <div class="icon-btn"><a href="<?= site_url('login/requests') ?>">Requests</a></div> -->
                                        <div class="icon-btn"><a href="<?= site_url('leave/apply_leave') ?>">

                                        Requests</a></div>
                                    </div>
                                <?php } ?>
                                <?php if ($this->session->userdata('role_id') == '2' && $this->session->userdata('user_type') == 'employee' && php72_cmp($this->session->userdata('ais_privilege')) == 1 && php72_cmp($this->session->userdata('partner_id')) == 1) { ?>
                                    <div class="icon-box">
                                        <div class="icon">
                                            <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                                            <!-- <div class="icon-btn"><a href="<?= site_url('login/requests') ?>"> -->
                                                <div class="icon-btn"><a href="<?= site_url('leave/apply_leave') ?>">

                                                Requests</a></div>
                                            </div>
                                        <?php } ?>

                                        <?php if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') { ?>
                                            <div style="clear:both"></div>
                                        </div>
                                        <div class="icon-row">
                                        <?php } ?>
                                        <?php if (php72_cmp($this->session->userdata('partner_id')) != 1 && php72_cmp($this->session->userdata('ais_privilege')) == 1 && $this->session->userdata('user_type') != 'admin') { ?>
                                            <div class="icon-box">
                                                <div class="icon">
                                                    <img src="<?= base_url(); ?>source/images/requests.png" alt="innovation" /></div>
                                                    <!-- <div class="icon-btn"><a href="<?= site_url('login/requests') ?>">Requests</a></div> -->
                                                    <div class="icon-btn"><a href="<?= site_url('leave/apply_leave') ?>">

                                                    Requests</a></div>
                                                    <div style="clear:both"></div>
                                                </div>
                                            <?php } ?>

                                            <?php if (php72_cmp($this->session->userdata('ais_privilege')) == 1 && php72_cmp($this->session->userdata('partner_id')) == 1) { ?>
                                                <div class="icon-box">
                                                    <div class="icon">
                                                        <img src="<?= base_url(); ?>source/images/approval.png" alt="innovation" /></div>
                                                        <!-- <div class="icon-btn"><a href="<?= site_url('login/approvals'); ?>">Approve</a></div> -->
                                                        <div class="icon-btn"><a href="<?= site_url('leave/approve_leave_list'); ?>">Approve</a></div>
                                                        <div style="clear:both"></div>
                                                    </div>
                                                <?php } ?>
                                                <?php if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') { ?>

                                                </div>
                                                <div class="icon-row">
                                                <?php } ?>
                                                <?php if (php72_cmp($this->session->userdata('partner_id')) == 1) { ?>
                                                    <div class="icon-box">
                                                        <div class="icon">
                                                            <img src="<?= base_url(); ?>source/images/my-portfolio.png" alt="innovation" /></div>
                                                            <div class="icon-btn"><a href="<?= site_url('login/portfolio/'); ?>">Portfolio</a></div>
                                                            <div style="clear:both"></div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if (php72_cmp($this->session->userdata('ais_privilege')) == 1 && php72_cmp($this->session->userdata('partner_id')) != 1) { ?>
                                                        <div class="icon-box">
                                                            <div class="icon">
                                                                <img src="<?= base_url(); ?>source/images/approval.png" alt="innovation" /></div>
                                                                <!-- <div class="icon-btn"><a href="<?= site_url('login/approvals'); ?>">Approve</a></div> -->
                                                                <div class="icon-btn"><a href="<?= site_url('leave/approve_leave_list'); ?>">Approve</a></div>
                                                                <div style="clear:both"></div>
                                                            </div>
                                                        <?php } ?>


                                                        <div class="icon-box">
                                                            <div class="icon">
                                                                <img src="<?= base_url(); ?>source/images/reports.png" alt="innovation" /></div>
                                                                <div class="icon-btn"><a href="<?= site_url('login/reports'); ?>">Reports

                                                                </a></div>
                                                            </div>


                                                            <?php if (php72_cmp($this->session->userdata('partner_id')) == 1) { ?>
                                                                <div class="icon-box">
                                                                    <div class="icon">
                                                                        <img src="<?= base_url(); ?>source/images/resources.png" alt="innovation" /></div>
                                                                        <div class="icon-btn"><a href="<?= site_url('login/resources'); ?>">Resources</a></div>
                                                                    </div>

                                                                <?php } ?>
                                                                <?php if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin') { ?>
                                                                    <div style="clear:both"></div>
                                                                </div>
                                                                <div class="icon-row">

                                                                <?php } ?>

                                                                <?php if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') { ?>



                                                                    <div class="icon-box">
                                                                        <div class="icon">
                                                                            <img src="<?= base_url(); ?>source/images/Documents-management-icon1.png" alt="innovation" /></div>
                                                                            <div class="icon-btn"><a href="<?= site_url('user/lists/3'); ?>" >Master's

                                                                            </a></div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <div style="clear:both"></div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </body>
                                                    </html>

